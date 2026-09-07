<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\AuthMiddleware;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;

final class AdminController
{
    public function login(?string $error = null): void
    {
        if (!empty($_SESSION['user_id'])) {
            Response::redirect('/admin');
        }
        Response::view('admin_login', ['error' => $error]);
    }

    public function authenticate(Request $request): void
    {
        $auth = new AuthService(new UserRepository(Database::getInstance()));
        if ($auth->authenticate((string) $request->input('usuario'), (string) $request->input('senha'))) {
            Response::redirect('/admin');
        }
        $this->login('Usuário ou senha incorretos.');
    }

    public function dashboard(): void
    {
        AuthMiddleware::require();
        $products = new ProductRepository(Database::getInstance());
        Response::view('admin_dashboard', [
            'groups' => $products->findAllGroupedByLinha(),
            'products' => $products->findAll(),
        ]);
    }

    public function logout(): void
    {
        AuthMiddleware::logout();
        Response::redirect('/admin/login');
    }
}
