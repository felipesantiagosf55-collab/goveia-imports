<?php

declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

\App\Core\Response::redirect('/admin/login');
