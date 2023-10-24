<?php

namespace App\Transformers\Commons;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;

abstract class Resource extends JsonResource
{
    /** @var MetaResource */
    protected MetaResource $meta;

    /**
     * Resource constructor.
     *
     * @param $resource
     * @param MetaPaginationResource|MetaResource $meta
     */
    public function __construct($resource, MetaPaginationResource|MetaResource $meta)
    {
        $this->meta = $meta;

        parent::__construct($resource);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'meta' => $this->meta->toArray($request),
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        if ($this->resource instanceof AbstractPaginator || $this->resource instanceof AbstractCursorPaginator) {
            return $this->resource->items();
        }

        return is_array($this->resource)
            ? $this->resource
            : $this->resource->toArray();
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return (new ResourceResponse($this))->toResponse($request);
    }
}
