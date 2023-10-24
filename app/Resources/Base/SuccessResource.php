<?php

namespace App\Resources\Base;

use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(property: 'data', type: 'object'),
        new OA\Property(
            property: 'meta', properties: [
            new OA\Property(
                property: 'message',
                type: 'string',
                example: 'Successful operation',
            ),
        ], type: 'object',
        ),
    ],
)]
class SuccessResource extends Resource
{
    /**
     * SuccessResource constructor.
     *
     * @param mixed|null $resource
     * @param string $message
     */
    public function __construct(mixed $resource = null, string $message = 'Successful operation')
    {
        parent::__construct(resource: $resource, meta: new MetaResource(message: $message));
    }
}
