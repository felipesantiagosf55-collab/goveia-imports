<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use PDO;

final class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private readonly PDO $database)
    {
    }

    public function findAllGroupedByLinha(): array
    {
        $statement = $this->database->prepare('SELECT * FROM produtos ORDER BY linha_numero DESC, id DESC');
        $statement->execute();
        $grouped = [];
        foreach ($statement->fetchAll() as $row) {
            $product = Product::fromArray($row);
            $grouped[$product->getLinha()][] = $product;
        }
        return $grouped;
    }

    public function findAll(): array
    {
        $statement = $this->database->prepare('SELECT * FROM produtos ORDER BY linha_numero DESC, id DESC');
        $statement->execute();
        return array_map(static fn (array $row): Product => Product::fromArray($row), $statement->fetchAll());
    }

    public function create(Product $product): Product
    {
        $statement = $this->database->prepare(
            'INSERT INTO produtos (condicao, modelo, linha_numero, armazenamento, preco, detalhes, foto_url)
             VALUES (:condicao, :modelo, :linha_numero, :armazenamento, :preco, :detalhes, :foto_url)'
        );
        $statement->execute([
            'condicao' => $product->getCondicao(),
            'modelo' => $product->getModelo(),
            'linha_numero' => $product->getLinhaNumero(),
            'armazenamento' => $product->getArmazenamento(),
            'preco' => $product->getPreco(),
            'detalhes' => $product->getDetalhes(),
            'foto_url' => $product->getFotoUrl(),
        ]);
        $id = (int) $this->database->lastInsertId();
        return Product::fromArray([
            'id' => $id,
            'condicao' => $product->getCondicao(),
            'modelo' => $product->getModelo(),
            'linha_numero' => $product->getLinhaNumero(),
            'armazenamento' => $product->getArmazenamento(),
            'preco' => $product->getPreco(),
            'detalhes' => $product->getDetalhes(),
            'foto_url' => $product->getFotoUrl(),
        ]);
    }

    public function delete(int $id): bool
    {
        $find = $this->database->prepare('SELECT foto_url FROM produtos WHERE id = :id');
        $find->execute(['id' => $id]);
        $product = $find->fetch();
        if (!$product) {
            return false;
        }

        $delete = $this->database->prepare('DELETE FROM produtos WHERE id = :id');
        $delete->execute(['id' => $id]);
        $path = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . ltrim((string) $product['foto_url'], '/\\');
        if (is_file($path)) {
            unlink($path);
        }
        return $delete->rowCount() > 0;
    }
}
