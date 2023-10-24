<?php

namespace App\Resources\Base;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(
            property: 'message',
            description: 'Status code message',
            type: 'string',
            example: 'Successful operation'
        ),
        new OA\Property(
            property: 'pagination',
            properties: [
                new OA\Property(
                    property: 'total',
                    description: 'Total records',
                    type: 'integer',
                    example: '10'
                ),
                new OA\Property(
                    property: 'count',
                    description: 'Total records at current page',
                    type: 'integer',
                    example: '15'
                ),
                new OA\Property(
                    property: 'per_page',
                    description: 'Number of records per page',
                    type: 'integer',
                    example: '10'
                ),
                new OA\Property(
                    property: 'current_page',
                    description: 'Current page',
                    type: 'integer',
                    example: '1'
                ),
                new OA\Property(
                    property: 'last_page',
                    description: 'Last page',
                    type: 'integer',
                    example: '2'
                )
            ],
            type: 'object',
        )
    ],
)]
class MetaPaginationResource extends MetaResource
{
    /** @var array|null */
    public ?array $pagination;

    /**
     * MetaResource constructor.
     *
     * @param string $message
     * @param array|null $pagination
     */
    public function __construct(string $message, array $pagination = null)
    {
        parent::__construct($message);

        $this->pagination = $pagination;
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
            'pagination' => $this->pagination,
        ];
    }
}
