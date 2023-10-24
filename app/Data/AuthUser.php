<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AuthUser extends Data
{
    /**
     * @param string $token
     * @param int $expiresIn
     */
    public function __construct(
        public string $token,
        public int $expiresIn
    ) {
    }

    /**
     * @return  array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'access_token' => $this->token,
            'expires_in' => $this->expiresIn
        ];
    }
}
