<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance instanceof PDO) {
            return self::$instance;
        }

        $host = Config::get('DB_HOST');
        $name = Config::get('DB_NAME');
        $user = Config::get('DB_USER');
        $password = Config::get('DB_PASSWORD');
        $port = Config::get('DB_PORT', '3306');
        if (!$host || !$name || !$user || $password === null) {
            throw new PDOException('Configuração do banco de dados ausente.');
        }
        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
        $lastError = null;

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            try {
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
                self::ensureSchema();
                return self::$instance;
            } catch (PDOException $error) {
                $lastError = $error;
                if ($attempt < 5) {
                    usleep(500000);
                }
            }
        }

        throw new PDOException('Não foi possível conectar ao banco de dados.', 0, $lastError);
    }

    public static function ensureSchema(): void
    {
        if (!self::$instance instanceof PDO) {
            return;
        }

        $directory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Migrations';
        $files = glob($directory . DIRECTORY_SEPARATOR . '*.sql') ?: [];
        sort($files);
        foreach ($files as $file) {
            try {
                self::$instance->exec((string) file_get_contents($file));
            } catch (PDOException $error) {
                $mysqlCode = (int) ($error->errorInfo[1] ?? 0);
                $sqlState = $error->errorInfo[0] ?? '';
                if (!in_array($mysqlCode, [1060, 1061, 1091], true) && !in_array($sqlState, ['42S21', '42S02'], true)) {
                    throw $error;
                }
            }
        }
    }
}
