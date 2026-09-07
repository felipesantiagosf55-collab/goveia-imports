<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function findAllGroupedByLinha(): array;

    public function findAll(): array;

    public function create(Product $product): Product;

    public function delete(int $id): bool;
}
