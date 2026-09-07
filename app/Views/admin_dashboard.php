<?php
$title = 'Painel Administrativo | Goveia Imports';
$groups = $groups ?? [];
$products = $products ?? [];
require __DIR__ . '/partials/head.php';
$flash = $_SESSION['flash'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash'], $_SESSION['flash_error']);
?>
<body class="admin-body admin-dashboard-body">
<div class="dash-card">
    <div class="dash-header"><h1 class="admin-title">Cadastrar Celular</h1><a href="<?= htmlspecialchars(\App\Core\Url::to('/admin/logout'), ENT_QUOTES, 'UTF-8') ?>" class="btn-logout"><i class="fa-solid fa-power-off"></i> Sair</a></div>
    <?php if ($flash): ?><div class="flash-success"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <?php if ($flashError): ?><div class="erro-msg"><?= htmlspecialchars($flashError, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <form action="<?= htmlspecialchars(\App\Core\Url::to('/admin/products'), ENT_QUOTES, 'UTF-8') ?>" method="POST" enctype="multipart/form-data">
        <div class="admin-form-group"><select name="condicao" class="admin-select" required><option value="Semi-novo">Semi-novo</option><option value="Novo Lacrado">Novo Lacrado</option></select><input type="text" name="modelo" class="admin-input" placeholder="Modelo (Ex: iPhone 15 Pro Max)" required><input type="text" name="armazenamento" class="admin-input" placeholder="Specs (Ex: Titânio 256GB)" required><input type="number" step="0.01" min="0.01" name="preco" class="admin-input" placeholder="Preço (Ex: 4480.00)" required><input type="text" name="detalhes" class="admin-input" placeholder="Porcentagem de bateria" required><label class="admin-label" for="foto_produto">Foto do Aparelho:</label><input id="foto_produto" type="file" name="foto_produto" class="admin-input" accept=".jpg,.jpeg,.png,.webp" required></div>
        <button type="submit" class="admin-btn"><i class="fa-solid fa-cloud-arrow-up"></i> Publicar no Catálogo</button>
    </form>
    <section class="estoque-section">
        <h2 class="admin-section-title"><i class="fa-solid fa-boxes-stacked"></i> Itens no Catálogo</h2>
        <div class="category-pills"><button type="button" class="category-pill active" data-filter="all">Todos: <?= count($products) ?></button><?php foreach ($groups as $linha => $items): ?><button type="button" class="category-pill" data-filter="<?= htmlspecialchars((string) $items[0]->getLinhaNumero(), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($linha, ENT_QUOTES, 'UTF-8') ?>: <?= count($items) ?></button><?php endforeach; ?></div>
        <label class="admin-label" for="filtro-estoque">Filtrar linha</label><select id="filtro-estoque" class="admin-select"><option value="all">Todas as linhas</option><?php foreach ($groups as $linha => $items): ?><option value="<?= htmlspecialchars((string) $items[0]->getLinhaNumero(), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($linha, ENT_QUOTES, 'UTF-8') ?></option><?php endforeach; ?></select>
        <div class="estoque-table-wrapper"><table class="estoque-table"><thead><tr><th>Foto</th><th>Aparelho</th><th>Preço</th><th>Ação</th></tr></thead><tbody><?php if (!$products): ?><tr><td colspan="4">Nenhum iPhone cadastrado no momento.</td></tr><?php else: foreach ($products as $product): ?><tr data-linha="<?= htmlspecialchars((string) $product->getLinhaNumero(), ENT_QUOTES, 'UTF-8') ?>"><td><img src="<?= htmlspecialchars(\App\Core\Url::to('/' . $product->getFotoUrl()), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product->getModelo(), ENT_QUOTES, 'UTF-8') ?>" class="estoque-thumb"></td><td><strong><?= htmlspecialchars($product->getModelo(), ENT_QUOTES, 'UTF-8') ?></strong><div><?= htmlspecialchars($product->getArmazenamento(), ENT_QUOTES, 'UTF-8') ?></div></td><td>R$ <?= number_format($product->getPreco(), 2, ',', '.') ?></td><td><form action="<?= htmlspecialchars(\App\Core\Url::to('/admin/products/delete'), ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');"><input type="hidden" name="id" value="<?= (int) $product->getId() ?>"><button type="submit" class="delete-button" title="Excluir produto"><i class="fa-solid fa-trash-can"></i></button></form></td></tr><?php endforeach; endif; ?></tbody></table></div>
    </section>
</div>
<script>const filtro = document.getElementById('filtro-estoque'); const pills = document.querySelectorAll('.category-pill'); const rows = document.querySelectorAll('.estoque-table tbody tr[data-linha]'); function filtrarEstoque(valor) { filtro.value = valor; rows.forEach(row => row.hidden = valor !== 'all' && row.dataset.linha !== valor); pills.forEach(pill => pill.classList.toggle('active', pill.dataset.filter === valor)); } filtro.addEventListener('change', event => filtrarEstoque(event.target.value)); pills.forEach(pill => pill.addEventListener('click', () => filtrarEstoque(pill.dataset.filter)));</script>
</body>
</html>