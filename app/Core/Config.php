<?php

declare(strict_types=1);

namespace App\Core;

final class Config
{
    private static bool $loaded = false;

    public static function get(string $key, ?string $default = null): ?string
    {
        if (!self::$loaded) {
            Environment::load(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env');
            self::$loaded = true;
        }

        return Environment::get($key, $default);
    }
}
