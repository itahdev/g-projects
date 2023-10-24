<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;
use Illuminate\Validation\ValidationException;

class ApiException extends RuntimeException
{
    private mixed $data;

    /**
     * @param int $httpCode
     * @param string $message
     * @param mixed|null $data
     * @param Throwable|null $previous
     */
    public function __construct(int $httpCode, string $message, mixed $data = null, Throwable $previous = null)
    {
        $this->data = $data;

        parent::__construct($message, $httpCode, $previous);
    }

    /**
     * @return mixed|null
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function serviceUnavailable(string $message = 'Service unavailable', mixed $data = null): ApiException
    {
        return new ApiException(httpCode: 503, message: $message, data: $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function badRequest(string $message = 'Bad request', mixed $data = null): ApiException
    {
        return new ApiException(httpCode: 400, message: $message, data: $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function forbidden(string $message = 'Forbidden', mixed $data = null): ApiException
    {
        return new ApiException(httpCode: 403, message: $message, data: $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function notFound(string $message = 'Not found', mixed $data = null): ApiException
    {
        return new ApiException(httpCode: 404, message: $message, data: $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function conflict(string $message = 'Conflict', mixed $data = null): ApiException
    {
        return new ApiException(httpCode: 409, message: $message, data: $data);
    }

    /**
     * Create a new validation exception from a plain array of messages.
     *
     * @throws ValidationException
     */
    public static function validation(array $messages): ValidationException
    {
        throw ValidationException::withMessages(messages: $messages);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function serverError(string $message = 'Server error', mixed $data = null): ApiException
    {
        return new ApiException(httpCode: 500, message: $message, data: $data);
    }
}
