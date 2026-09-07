<?php

declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use App\Core\Database;

Database::getInstance();
echo "Migrações executadas com sucesso." . PHP_EOL;
