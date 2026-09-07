<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use PDO;

final class UserRepository
{
    public function __construct(private readonly PDO $database)
    {
    }

    public function findByUsername(string $username): ?User
    {
        $statement = $this->database->prepare('SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1');
        $statement->execute(['username' => $username]);
        $data = $statement->fetch();
        return $data ? User::fromArray($data) : null;
    }

    public function create(string $username, string $passwordHash): User
    {
        $statement = $this->database->prepare('INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)');
        $statement->execute(['username' => $username, 'password_hash' => $passwordHash]);
        return new User((int) $this->database->lastInsertId(), $username, $passwordHash);
    }
}
