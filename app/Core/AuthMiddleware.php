<?php

declare(strict_types=1);

namespace App\Core;

final class AuthMiddleware
{
    public static function require(): void
    {
        if (empty($_SESSION['user_id'])) {
            Response::redirect('/admin/login');
        }

        $lastActivity = (int) ($_SESSION['last_activity'] ?? 0);
        if ($lastActivity > 0 && time() - $lastActivity > 1200) {
            self::logout();
            Response::redirect('/admin/login');
        }
        $_SESSION['last_activity'] = time();
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }
}
