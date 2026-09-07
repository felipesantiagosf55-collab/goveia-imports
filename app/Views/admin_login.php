<?php $title = 'Login | Goveia Imports'; $error = $error ?? null; require __DIR__ . '/partials/head.php'; ?>
<body class="admin-body">
    <div class="login-card">
        <h1 class="admin-title"><i class="fa-solid fa-lock"></i> Painel de Segurança</h1>
        <?php if ($error): ?><div class="erro-msg"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
        <form action="<?= htmlspecialchars(\App\Core\Url::to('/admin/login'), ENT_QUOTES, 'UTF-8') ?>" method="POST">
            <div class="admin-form-group">
                <input type="text" name="usuario" class="admin-input" placeholder="Usuário" required autocomplete="username">
                <div class="senha-wrapper">
                    <input type="password" name="senha" id="senhaInput" class="admin-input" placeholder="Senha" required autocomplete="current-password">
                    <i class="fa-solid fa-eye" id="olhoIcone" onclick="alternarSenha()"></i>
                </div>
            </div>
            <button type="submit" class="admin-btn">Entrar no Sistema</button>
        </form>
    </div>
    <script>
        function alternarSenha() {
            const input = document.getElementById('senhaInput');
            const icone = document.getElementById('olhoIcone');
            if (input.type === 'password') {
                input.type = 'text';
                icone.classList.remove('fa-eye');
                icone.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icone.classList.remove('fa-eye-slash');
                icone.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>