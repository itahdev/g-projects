<?php

namespace App\Transformers\Commons;

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
class TrvSuccessResource extends Resource
{
    /**
     * SuccessResource constructor.
     *
     * @param mixed|null $resource
     * @param string $message
     */
    public function __construct($resource = null, string $message = 'Successful operation')
    {
        parent::__construct($resource, new MetaResource($message));
    }
}
