<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\AdminController;
use App\Controllers\AdminProductController;
use App\Controllers\HomeController;

final class Router
{
    public function dispatch(Request $request): void
    {
        $path = $request->path();
        $method = $request->method();
        $home = new HomeController();
        $admin = new AdminController();
        $products = new AdminProductController();

        if ($method === 'GET' && $path === '/') { $home->index(); return; }
        if ($method === 'GET' && $path === '/admin/login') { $admin->login(); return; }
        if ($method === 'POST' && $path === '/admin/login') { $admin->authenticate($request); return; }
        if ($method === 'GET' && $path === '/admin/logout') { $admin->logout(); return; }
        if ($method === 'GET' && $path === '/admin') { $admin->dashboard(); return; }
        if ($method === 'POST' && $path === '/admin/products') { $products->store($request); return; }
        if ($method === 'POST' && $path === '/admin/products/delete') { $products->destroy($request); return; }

        http_response_code(404);
        echo 'Página não encontrada.';
    }
}
