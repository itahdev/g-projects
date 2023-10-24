<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use OpenApi\Attributes as OA;

#[OA\Schema(
    required: ['email', 'password'],
    properties: [
        new OA\Property(
            property: 'email',
            type: 'string',
            example: 'eu0@example.com'
        ),
        new OA\Property(
            property: 'password',
            type: 'string',
            example: 'password'
        )
    ]
)]
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|min:6|max:255',
            'password' => 'required|min:6|max:255',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->any()) {
                throw ValidationException::withMessages([trans('auth.failed')]);
            }
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
