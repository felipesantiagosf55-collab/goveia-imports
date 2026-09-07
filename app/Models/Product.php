<?php

declare(strict_types=1);

namespace App\Models;

final class Product
{
    public function __construct(
        private readonly ?int $id,
        private readonly string $condicao,
        private readonly string $modelo,
        private readonly int $linhaNumero,
        private readonly string $armazenamento,
        private readonly float $preco,
        private readonly ?string $detalhes,
        private readonly string $fotoUrl
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['id']) ? (int) $data['id'] : null,
            (string) $data['condicao'],
            (string) $data['modelo'],
            (int) $data['linha_numero'],
            (string) $data['armazenamento'],
            (float) $data['preco'],
            $data['detalhes'] !== null ? (string) $data['detalhes'] : null,
            (string) $data['foto_url']
        );
    }

    public function getId(): ?int { return $this->id; }
    public function getCondicao(): string { return $this->condicao; }
    public function getModelo(): string { return $this->modelo; }
    public function getLinhaNumero(): int { return $this->linhaNumero; }
    public function getLinha(): string { return 'iPhone ' . $this->linhaNumero; }
    public function getArmazenamento(): string { return $this->armazenamento; }
    public function getPreco(): float { return $this->preco; }
    public function getDetalhes(): ?string { return $this->detalhes; }
    public function getFotoUrl(): string { return $this->fotoUrl; }
}
