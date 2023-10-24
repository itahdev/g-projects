<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\BaseController;
use App\Resources\Base\ErrorResource;
use App\Resources\Base\SuccessResource;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AnimalController extends BaseController
{
    #[OA\Get(
        path: '/v1/animals',
        summary: 'Paginate animal. ***DONE***',
        security: [['BearerAuth' => []]],
        tags: ['ANIMALS'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                description: 'Page',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            ),
            new OA\Parameter(
                name: 'per_page',
                description: 'Per page',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                    example: 10
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful',
                content: new OA\JsonContent(ref: SuccessResource::class)
            ),
            new OA\Response(
                response: 500,
                description: 'Server error',
                content: new OA\JsonContent(ref: ErrorResource::class)
            ),
        ]
    )]
    public function index(Request $request): SuccessResource
    {
        return SuccessResource::make();
    }
}
