<?php

namespace App\Transformers\Commons;

use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(property: 'data', type: 'object'),
        new OA\Property(property: 'meta', ref: MetaResource::class),
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
    public function __construct($resource = null, string $message = 'Successful operation')
    {
        parent::__construct($resource, new MetaResource($message));
    }
}
