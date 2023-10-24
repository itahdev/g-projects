<?php

namespace App\Transformers\Commons;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'MetaCursorPaginationResource', properties: [
    new OA\Property(
        property: 'message',
        description: 'Status code message',
        type: 'string',
        example: 'Successful operation',
    ),
    new OA\Property(
        property: 'pagination', properties: [
        new OA\Property(
            property: 'path', type: 'string', example: 'api/v1/example',
        ),
        new OA\Property(
            property: 'per_page', type: 'int', example: '15',
        ),
        new OA\Property(
            property: 'next_cursor',
            type: 'string',
            example: 'eyJjcmVhdGVkX2F0IjoiMjAyMy0wNC0yMCAxMjowODoxMSIsIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0',
            nullable: true,
        ),
        new OA\Property(
            property: 'next_page_url',
            type: 'string',
            example: 'api/v1/example?cursor=eyJjcmVhdGVkX2F0IjoiMjAyMy0wNC0yMCAxMjowODoxMSIsIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0',
            nullable: true,
        ),
        new OA\Property(
            property: 'prev_cursor',
            type: 'string',
            example: 'eyJjcmVhdGVkX2F0IjoiMjAyMy0wNC0yMCAxMjowNjozMSIsIl9wb2ludHNUb05leHRJdGVtcyI6ZmFsc2V9',
            nullable: true,
        ),
        new OA\Property(
            property: 'prev_page_url',
            type: 'string',
            example: 'api/v1/example?cursor=eyJjcmVhdGVkX2F0IjoiMjAyMy0wNC0yMCAxMjowODoxMSIsIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0',
            nullable: true,
        ),
    ], type: 'object'
    ),
])]
class MetaCursorPaginationResource extends MetaResource
{
    /**
     * MetaResource constructor.
     *
     * @param string $message
     * @param array|null $cursorPagination
     */
    public function __construct(
        public string $message,
        public ?array $cursorPagination = null
    ) {
        parent::__construct($message);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => $this->message,
            'pagination' => $this->cursorPagination,
        ];
    }
}
