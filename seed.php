<?php

declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use App\Core\Database;
use App\Repositories\UserRepository;

$database = Database::getInstance();
$users = new UserRepository($database);
if (!$users->findByUsername('admin')) {
    $users->create('admin', password_hash('admin123', PASSWORD_BCRYPT));
}
$seed = $database->prepare(file_get_contents(__DIR__ . '/app/Seeders/001_initial_data.sql'));
$seed->execute();
echo "Dados iniciais inseridos. Usuário local: admin / admin123" . PHP_EOL;
