<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Goveia Imports', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars(\App\Core\Url::to('/style.css'), ENT_QUOTES, 'UTF-8') ?>?v=<?= filemtime(dirname(__DIR__, 3) . '/style.css') ?>">
    <script src="https://kit.fontawesome.com/50f439f8e3.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imask"></script>
</head>