<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use InvalidArgumentException;

final class ProductService
{
    public function __construct(
        private readonly ProductRepository $products,
        private readonly FileUploadService $uploads
    ) {
    }

    public function createProduct(array $input, ?array $file): Product
    {
        $condicao = $this->clean($input['condicao'] ?? '');
        $modelo = $this->clean($input['modelo'] ?? '');
        $armazenamento = $this->clean($input['armazenamento'] ?? '');
        $detalhes = $this->clean($input['detalhes'] ?? '');
        $preco = filter_var($input['preco'] ?? null, FILTER_VALIDATE_FLOAT);
        if ($condicao === '' || $modelo === '' || $armazenamento === '' || $detalhes === '' || $preco === false || (float) $preco <= 0) {
            throw new InvalidArgumentException('Preencha todos os campos corretamente e informe um preço maior que zero.');
        }
        if (!preg_match('/iPhone\s*(\d+)/i', $modelo, $match)) {
            throw new InvalidArgumentException('O modelo deve conter uma linha de iPhone, como iPhone 15.');
        }

        $photoUrl = $this->uploads->store($file);
        return $this->products->create(new Product(null, $condicao, $modelo, (int) $match[1], $armazenamento, (float) $preco, $detalhes, $photoUrl));
    }

    public function deleteProduct(int $id): bool
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Produto inválido.');
        }
        return $this->products->delete($id);
    }

    private function clean(mixed $value): string
    {
        return trim(strip_tags((string) $value));
    }
}
