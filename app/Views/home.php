<?php $title = 'Goveia Imports'; $groups = $groups ?? []; require __DIR__ . '/partials/head.php'; ?>
<body class="light-theme">
<?php require __DIR__ . '/partials/header.php'; ?>
<main>
    <section class="hero">
        <h1>GOVEIA IMPORTS</h1>
        <p>Encontre o iPhone perfeito para você</p>
    </section>
    <section class="vitrine">
        <?php foreach ($groups as $linha => $products): ?>
            <section class="linha-produtos">
                <h2><?= htmlspecialchars($linha, ENT_QUOTES, 'UTF-8') ?></h2>
                <div class="produtos-grid">
                    <?php foreach ($products as $product): ?>
                        <article class="produto-card">
                            <span class="tag-condicao"><?= htmlspecialchars($product->getCondicao(), ENT_QUOTES, 'UTF-8') ?></span>
                            <div class="produto-imagem"><img src="<?= htmlspecialchars(\App\Core\Url::to('/' . $product->getFotoUrl()), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product->getModelo(), ENT_QUOTES, 'UTF-8') ?>"></div>
                            <div class="produto-info">
                                <h3 class="p-modelo"><?= htmlspecialchars($product->getModelo(), ENT_QUOTES, 'UTF-8') ?></h3>
                                <p class="p-armazenamento"><?= htmlspecialchars($product->getArmazenamento(), ENT_QUOTES, 'UTF-8') ?></p>
                                <h2 class="p-preco">R$ <?= number_format($product->getPreco(), 2, ',', '.') ?></h2>
                                <p class="p-detalhes"><?= htmlspecialchars((string) $product->getDetalhes(), ENT_QUOTES, 'UTF-8') ?>%🔋</p>
                                <button class="btn-comprar" type="button">Comprar</button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="carrossel-indicators"></div>
            </section>
        <?php endforeach; ?>
    </section>
    <section class="sobre">
        <h2>Sobre a loja</h2>
        <p>Aqui na Goveia Imports, temos produtos de qualidade e os melhores preços. Venha ser feliz de iPhone novo!</p>
        <div class="counter-grid"><div class="counter-item"><h3>100+</h3><p>Clientes Satisfeitos</p></div><div class="counter-item"><h3>10+</h3><p>Modelos Disponíveis</p></div><div class="counter-item"><h3>24h</h3><p>Suporte</p></div></div>
    </section>
    <section class="diferenciais"><h2>Goveia Imports é diferente</h2><div class="diferenciais-list"><div class="diferencial-item"><span class="emoji">💳</span><h3>As Melhores Taxas</h3><p>Em até 12x com juros reduzidos</p></div><div class="diferencial-item"><span class="emoji">🚀</span><h3>A Entrega Mais Rápida</h3><p>Entregamos em até 48 Horas em Wenceslau Braz e Região</p></div><div class="diferencial-item"><span class="emoji">✅</span><h3>Qualidade</h3><p>Novos e semi-novos com a melhor qualidade do mercado</p></div></div></section>
    <section class="reserva-container" id="reserva"><h2>Faça a sua Reserva</h2><div class="reserva-card"><h3>Reserve seu iPhone</h3><p>Se o Iphone que você procura não está disponível, reserve já e ganhe um cupom de desconto!</p><div class="form-grupo"><input type="text" id="nome" placeholder="Nome:"><input type="tel" id="tel" placeholder="Telefone:"><input type="text" id="escolha" placeholder="Qual Iphone você quer reservar?"><button id="reservar" type="button" class="btn-tech">Reservar</button></div></div></section>
    <section class="redes"><a href="https://www.instagram.com/matheus_goveia043/" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a><a href="https://wa.me/5543999301558" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i></a><a href="mailto:felipesantiagos.f55@gmail.com"><i class="fa-solid fa-envelope"></i></a></section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
