<?php

declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use App\Core\Request;
use App\Core\Router;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

(new Router())->dispatch(new Request());
