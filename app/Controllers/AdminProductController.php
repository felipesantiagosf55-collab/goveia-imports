<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\AuthMiddleware;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\ProductRepository;
use App\Services\FileUploadService;
use App\Services\ProductService;
use InvalidArgumentException;
use RuntimeException;

final class AdminProductController
{
    public function store(Request $request): void
    {
        AuthMiddleware::require();
        try {
            $service = $this->service();
            $service->createProduct($_POST, $request->file('foto_produto'));
            $_SESSION['flash'] = 'iPhone publicado com sucesso!';
        } catch (InvalidArgumentException | RuntimeException $error) {
            $_SESSION['flash_error'] = $error->getMessage();
        }
        Response::redirect('/admin');
    }

    public function destroy(Request $request): void
    {
        AuthMiddleware::require();
        try {
            $this->service()->deleteProduct((int) $request->input('id'));
            $_SESSION['flash'] = 'iPhone removido do estoque com sucesso!';
        } catch (InvalidArgumentException | RuntimeException $error) {
            $_SESSION['flash_error'] = $error->getMessage();
        }
        Response::redirect('/admin');
    }

    private function service(): ProductService
    {
        return new ProductService(
            new ProductRepository(Database::getInstance()),
            new FileUploadService(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads')
        );
    }
}
