<?php

namespace App\Exceptions;

use App\Resources\Base\ErrorResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ApiException $e, $request) {
            return $this->makeErrorResponse($e->getCode(), $e->getMessage(), null, $e->getData());
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return $this->makeErrorResponse(Response::HTTP_UNAUTHORIZED, trans('auth.unauthenticated'));
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            return $this->makeErrorResponse(Response::HTTP_FORBIDDEN, trans('exceptions.assess_denied_permission'));
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return $this->makeNotFoundResponse($e);
        });
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param Request $request
     * @param ValidationException $exception
     * @return Response
     */
    protected function invalidJson($request, ValidationException $exception): Response
    {
        return $this->makeErrorResponse($exception->status, trans('validation.general'), $exception->errors());
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  Request  $request
     * @param  \Throwable  $e
     * @return Response
     */
    protected function prepareJsonResponse($request, Throwable $e): Response
    {
        if (config('app.debug')) {
            return $this->makeErrorResponse(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                trans('exceptions.server_error'),
                $this->convertExceptionToArray($e)
            );
        }

        return $this->makeErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, trans('exceptions.server_error'));
    }

    /**
     * @param int $code
     * @param string $message
     * @param array|null $errors
     * @param mixed|null $data
     * @return Response
     */
    protected function makeErrorResponse(int $code, string $message, ?array $errors = null, mixed $data = null): Response
    {
        return (new ErrorResource($message, $data, $errors))->response()->setStatusCode($code);
    }

    /**
     * @param NotFoundHttpException $e
     * @return Response
     */
    protected function makeNotFoundResponse(NotFoundHttpException $e): Response
    {
        $message = trans('exceptions.not_found');
        if (($previous = $e->getPrevious()) && $previous instanceof ModelNotFoundException) {
            $model = $previous->getModel();

            $key = "model.not_found.$model";
            if (!Lang::has($key)) {
                $key = 'model.not_found.default';
            }

            $message = trans($key);
        }

        return $this->makeErrorResponse(Response::HTTP_NOT_FOUND, $message);
    }
}
