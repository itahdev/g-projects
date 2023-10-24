<?php

namespace App\Transformers\Commons;

use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(
            property: 'data',
            type: 'object',
        ),
        new OA\Property(
            property: 'meta',
            ref: '#/components/schemas/MetaResource',
        ),
    ]
)]
class ErrorResource extends Resource
{
    /**
     * @inheritDoc
     *
     * @param string $message
     * @param array|null $errors
     * @param $resource
     */
    public function __construct(string $message = 'Bad request', $resource = null, array $errors = null)
    {
        parent::__construct($resource, new MetaResource($message, $errors));
    }
}
