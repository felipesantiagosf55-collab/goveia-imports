<?php

declare(strict_types=1);

namespace App\Models;

final class User
{
    public function __construct(
        private readonly int $id,
        private readonly string $username,
        private readonly string $passwordHash
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self((int) $data['id'], (string) $data['username'], (string) $data['password_hash']);
    }

    public function getId(): int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getPasswordHash(): string { return $this->passwordHash; }
}
