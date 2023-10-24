<?php

namespace App\Transformers\Commons;

class SuccessCollectionResource extends Resource
{
    /**
     * SuccessAllResource constructor.
     *
     * @param mixed|null $resource
     * @param string $message
     */
    public function __construct(mixed $resource = null, string $message = 'Successful operation')
    {
        parent::__construct($resource, new MetaResource($message));
    }
}
