<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goveia Imports</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/50f439f8e3.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imask"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body class="light-theme"> 
    <header>
        <div class="logo-container">
            <img src="goveia-imports.jpg" alt="">
            <span>GOVEIA IMPORTS</span>
        </div>
        <nav style="display: flex; align-items: center; gap: 14px;">
             <label for="switch-itema" style="cursor: pointer; display: flex; align-items: center;">
                <input type="checkbox" id="switch-itema" style="display: none;">
                <i class="fa-regular fa-moon icone-lua-css"></i>
                <i class="fa-solid fa-sun icone-sol-css" style="color: #FFD60A;"></i>
            </label>
            <a href="https://wa.me/5543999301558" target="_blank" class="nav-link">CONTATO</a>
            <a href="#reserva" class="btn-reserva-header">Reserva</a>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>GOVEIA IMPORTS</h1>
            <p>Encontre o iPhone perfeito para você</p>
        </section>
        <section class="vitrine">
            <?php
            require_once "conexao.php";
            $stmt = $conexao->query("SELECT * FROM produtos ORDER BY id DESC");
            while($produto = $stmt->fetch()):
            ?>
            <article class="produto-card">
                <span class="tag-condicao"><?= htmlspecialchars($produto['condicao']) ?></span>
                <div class="produto-imagem">
                    <img src="<?= htmlspecialchars($produto['foto_url']) ?>" alt="<?= htmlspecialchars($produto['modelo']) ?>">
                </div>
                <div class="produto-info">
                    <h3 class="p-modelo"><?= htmlspecialchars($produto['modelo']) ?></h3>
                    <p class="p-armazenamento"><?= htmlspecialchars($produto['armazenamento']) ?></p>
                    <h2 class="p-preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></h2>
                    <p class="p-detalhes"><?= htmlspecialchars($produto['detalhes']) ?>%🔋​</p>
                    <button class="btn-comprar">Comprar</button>
                </div>
            </article>
            <?php endwhile; ?>
        </section>
        <section class="sobre">
            <h2>Sobre a loja</h2>
            <p>Aqui na Goveia Imports, temos produtos de qualidade e os melhores preços. Venha ser feliz de iPhone novo!</p>
            <div class="counter-grid">
                <div class="counter-item">
                    <h3>100+</h3>
                    <p>Clientes Satisfeitos</p>
                </div>
                <div class="counter-item">
                    <h3>10+</h3>
                    <p>Modelos Disponíveis</p>
                </div>
                <div class="counter-item">
                    <h3>24h</h3>
                    <p>Suporte</p>
                </div>
            </div>
        </section>
        <section class="diferenciais">
            <h2>Goveia Imports é diferente</h2>
            <div class="diferenciais-list">
                <div class="diferencial-item">
                    <span class="emoji">💳</span>
                    <h3>As Melhores Taxas</h3>
                    <p>Em até 12x com juros reduzidos</p>
                </div>
                <div class="diferencial-item">
                    <span class="emoji">🚀</span>
                    <h3>A Entrega Mais Rápida</h3>
                    <p>Entregamos em até 48 Horas em Wenceslau Braz e Região</p>
                </div>
                <div class="diferencial-item">
                    <span class="emoji">✅</span>
                    <h3>Qualidade</h3>
                    <p>Novos e semi-novos com a melhor qualidade do mercado</p>
                </div>
            </div>
        </section>
        <section class="reserva-container" id="reserva">
            <h2>Faça a sua Reserva</h2>
            <div class="reserva-card">
                <h3>Reserve seu iPhone</h3>
                <p>Se o Iphone que você procura não está disponível, reserve já e ganhe um cupom de desconto!</p>
                <div class="form-grupo">
                    <input type="text" id="nome" placeholder="Nome:">
                    <input type="tel" id="tel" placeholder="Telefone:">
                    <input type="text" id="escolha" placeholder="Qual Iphone você quer reservar?">
                    <button id="reservar" onclick="reservar()" class="btn-tech">Reservar</button>
                </div>
            </div>
        </section>
        <section class="redes">
            <a href="https://www.instagram.com/matheus_goveia043/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://wa.me/5543999301558" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="mailto:felipesantiagos.f55@gmail.com" target="_blank"><i class="fa-solid fa-envelope"></i></a>
        </section>
    </main>
    <footer>
        <div class="footer-info">
            <h3>Goveia Imports</h3>
            <p>Sua melhor opção para comprar iPhones novos e semi-novos com qualidade e os melhores preços do mercado.</p>
            <h4 class="atendimento-titulo">Horário de Atendimento</h4>
            <p>Segunda a Sexta: 09h às 22h</p>
            <p>Sábado: 09h às 22h</p>
            <p>Domingo: Aberto o dia todo</p>
        </div>
        <div class="footer-copy">
            <p>© 2025 Goveia Imports. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>