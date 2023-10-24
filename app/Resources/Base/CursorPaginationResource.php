<?php

namespace App\Resources\Base;

use Illuminate\Pagination\CursorPaginator;

class CursorPaginationResource extends Resource
{
    /**
     * SuccessResource constructor.
     *
     * @param CursorPaginator $resource
     * @param string $message
     */
    public function __construct(CursorPaginator $resource, string $message = 'Successful operation')
    {
        $cursorPagination = [
            'path' => $resource->path(),
            'per_page' => $resource->perPage(),
            'next_cursor' => $resource->nextCursor()?->encode(),
            'next_page_url' => $resource->nextPageUrl(),
            'prev_cursor' => $resource->previousCursor()?->encode(),
            'prev_page_url' => $resource->previousPageUrl(),
        ];

        $meta = new MetaCursorPaginationResource(
            message: $message,
            cursorPagination: $cursorPagination
        );

        parent::__construct(resource: $resource, meta: $meta);
    }
}
