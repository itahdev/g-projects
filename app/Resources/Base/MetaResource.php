<?php

namespace App\Transformers\Commons;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(
            property: 'message',
            description: 'Meta message',
            type: 'string',
        ),
        new OA\Property(
            property: 'errors',
            description: 'Meta error',
            type: 'object',
        ),
    ],
)]
class MetaResource
{
    /** @var string */
    public string $message;

    /** @var array|null */
    public ?array $errors;

    /**
     * MetaResource constructor.
     *
     * @param string $message
     * @param array|null $errors
     */
    public function __construct(string $message, array $errors = null)
    {
        $this->message = $message;
        $this->errors = $errors;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $arr = [
            'message' => $this->message,
        ];

        if ($this->errors !== null) {
            $arr['errors'] = $this->errors;
        }

        return $arr;
    }
}
