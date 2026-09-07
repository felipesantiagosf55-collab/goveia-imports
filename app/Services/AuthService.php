<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;

final class AuthService
{
    public function __construct(private readonly UserRepository $users)
    {
    }

    public function authenticate(string $username, string $password): bool
    {
        $username = trim(strip_tags($username));
        $user = $this->users->findByUsername($username);
        if (!$user || !password_verify($password, $user->getPasswordHash())) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_logged'] = true;
        $_SESSION['last_activity'] = time();
        return true;
    }
}
