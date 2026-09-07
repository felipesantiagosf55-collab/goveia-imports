<?php

declare(strict_types=1);

namespace App\Services;

use RuntimeException;

final class FileUploadService
{
    private const EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    public function __construct(private readonly string $directory)
    {
    }

    public function store(?array $file): string
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Selecione uma imagem válida.');
        }
        $extension = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::EXTENSIONS, true) || !is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('Extensão inválida. Use JPG, PNG ou WEBP.');
        }
        if (!is_dir($this->directory) && !mkdir($this->directory, 0755, true) && !is_dir($this->directory)) {
            throw new RuntimeException('Não foi possível preparar o diretório de imagens.');
        }
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        if (!move_uploaded_file($file['tmp_name'], $this->directory . DIRECTORY_SEPARATOR . $filename)) {
            throw new RuntimeException('Erro ao salvar o arquivo no servidor.');
        }
        return 'uploads/' . $filename;
    }
}
