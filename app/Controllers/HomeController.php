<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Response;
use App\Repositories\ProductRepository;

final class HomeController
{
    public function index(): void
    {
        $products = new ProductRepository(Database::getInstance());
        Response::view('home', ['groups' => $products->findAllGroupedByLinha()]);
    }
}
