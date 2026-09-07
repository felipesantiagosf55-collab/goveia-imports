<?php

declare(strict_types=1);

namespace App\Core;

final class Url
{
    public static function to(string $path = '/'): string
    {
        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        $path = '/' . ltrim($path, '/');
        return ($base === '' || $base === '/') ? $path : $base . $path;
    }
}
