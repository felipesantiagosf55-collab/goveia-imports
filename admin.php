<?php
require_once "conexao.php";
if (isset($_GET['action']) && $_GET['action'] === 'deletar' && isset($_GET['id'])) {
    // Garante que o usuário está logado antes de deletar
    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true) {
        $id_deletar = intval($_GET['id']);
        try {
            $stmt_foto = $conexao->prepare("SELECT foto_url FROM produtos WHERE id = :id");
            $stmt_foto->bindParam(':id', $id_deletar);
            $stmt_foto->execute();
            $prod = $stmt_foto->fetch();
            
            if ($prod && file_exists($prod['foto_url'])) {
                unlink($prod['foto_url']);
            }
            $stmt_del = $conexao->prepare("SELECT * FROM produtos WHERE id = :id; DELETE FROM produtos WHERE id = :id");
            $stmt_del = $conexao->prepare("DELETE FROM produtos WHERE id = :id");
            $stmt_del->bindParam(':id', $id_deletar);
            if ($stmt_del->execute()) {
                echo "<script>alert('❌ iPhone removido do estoque com sucesso!'); window.location.href='admin.php';</script>";
                exit;
            }
        } catch(PDOException $erro) {
            echo "<script>alert('Erro interno ao tentar deletar o item.');</script>";
        }
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header("Location: admin.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_login'])) {
    $usuarioInput = trim($_POST['usuario']);
    $senhaInput = trim($_POST['senha']);
    if ($usuarioInput === 'Matheus' && $senhaInput === 'imports01') {
        session_regenerate_id(true);
        $_SESSION['user_id'] = 1;
        $_SESSION['user_logged'] = true;
        $_SESSION['last_activity'] = time();
        header("Location: admin.php");
        exit;
    } else {
        $erroLogin = "Usuário ou senha incorretos.";
    }
}
if (isset($_SESSION['user_logged'])) {
    if (time() - $_SESSION['last_activity'] > 1200) {
        header("Location: admin.php?action=logout");
        exit;
    }
    $_SESSION['last_activity'] = time(); 
}
$isLogged = isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo — Goveia Imports</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/50f439f8e3.js" crossorigin="anonymous"></script>
    <style>
        .admin-body { background: #000000; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; font-family: 'Inter', Arial, sans-serif; }
        .login-card, .dash-card { background: #1C1C1E; width: 100%; max-width: 450px; border-radius: 16px; padding: 32px; border: 1px solid rgba(255,255,255,0.08); }
        .admin-title { font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 24px; text-align: center; }
        .admin-form-group { display: flex; flex-direction: column; gap: 16px; margin-bottom: 20px; }
        .admin-input, .admin-select { width: 100%; padding: 14px; background: #2C2C2E; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; color: #fff; outline: none; font-size: 0.95rem; }
        .admin-input:focus, .admin-select:focus { border-color: #0A84FF; }
        .admin-btn { width: 100%; background: #0A84FF; color: #fff; border: none; padding: 14px; border-radius: 100px; font-weight: 600; cursor: pointer; font-size: 0.95rem; }
        .erro-msg { color: #FF453A; font-size: 0.85rem; text-align: center; margin-bottom: 12px; }
        .dash-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 16px; }
        .btn-logout { text-decoration: none; color: #FF453A; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 6px; }
    </style>
</head>
<body class="admin-body">
    <?php if (!$isLogged): ?>
        <div class="login-card">
            <h1 class="admin-title"><i class="fa-solid fa-lock"></i> Painel de Segurança</h1>
            <?php if (isset($erroLogin)): ?>
                <div class="erro-msg"><?= htmlspecialchars($erroLogin) ?></div>
            <?php endif; ?>
            <form action="admin.php" method="POST">
                <div class="admin-form-group">
                    <input type="text" name="usuario" class="admin-input" placeholder="Usuário" required autocomplete="off">
                    <input type="password" name="senha" class="admin-input" placeholder="Senha" required>
                </div>
                <button type="submit" name="btn_login" class="admin-btn">Entrar no Sistema</button>
            </form>
        </div>
    <?php else: ?>
        <div class="dash-card">
            <div class="dash-header">
                <h1 class="admin-title" style="margin:0; font-size:1.2rem;">Cadastrar Celular</h1>
                <a href="admin.php?action=logout" class="btn-logout"><i class="fa-solid fa-power-off"></i> Sair</a>
            </div>
            <form action="cadastrar_produto.php" method="POST" enctype="multipart/form-data">
                <div class="admin-form-group">
                    <select name="condicao" class="admin-select" required>
                        <option value="Semi-novo">Semi-novo</option>
                        <option value="Novo Lacrado">Novo Lacrado</option>
                    </select>
                    <input type="text" name="modelo" class="admin-input" placeholder="Modelo (Ex: iPhone 15 Pro Max)" required>
                    <input type="text" name="armazenamento" class="admin-input" placeholder="Specs (Ex: Titânio 256GB)" required>
                    <input type="number" step="0.01" name="preco" class="admin-input" placeholder="Preço (Ex: 4480.00)" required>
                    <input type="text" name="detalhes" class="admin-input" placeholder="Porcentagem de bateria" required>
                    <label style="color:#AEAEB2; font-size:0.85rem; margin-left:4px;">Foto do Aparelho:</label>
                    <input type="file" name="foto_produto" class="admin-input" accept="image/*" required style="padding:10px;">
                </div>
                <button type="submit" class="admin-btn"><i class="fa-solid fa-cloud-arrow-up"></i> Publicar no Catálogo</button>
            </form>
            <div style="margin-top: 30px; text-align: center;">
                <button type="button" onclick="alternarVisibilidadeEstoque()" class="admin-btn" style="background: #2C2C2E; border: 1px solid rgba(255,255,255,0.1); display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-eye" id="iconeBotaoEstoque"></i> 
                    <span id="textoBotaoEstoque">Mostrar Estoque Atual</span>
                </button>
            </div>
            <div id="tabelaEstoqueWrapper" style="display: none; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 20px;">
                <h2 style="color: #fff; font-size: 1.1rem; margin-bottom: 15px; font-weight: 600;"><i class="fa-solid fa-boxes-stacked"></i> Itens no Catálogo</h2>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem; color: #AEAEB2;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); color: #fff;">
                                <th style="padding: 10px 5px;">Aparelho</th>
                                <th style="padding: 10px 5px;">Preço</th>
                                <th style="padding: 10px 5px; text-align: center;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt_estoque = $conexao->query("SELECT id, modelo, armazenamento, preco FROM produtos ORDER BY id DESC");
                            $total_itens = $stmt_estoque->rowCount();
                            if ($total_itens == 0):
                            ?>
                                <tr>
                                    <td colspan="3" style="padding: 20px 0; text-align: center; color: #8E8E93;">Nenhum iPhone cadastrado no momento.</td>
                                </tr>
                            <?php 
                            else:
                                while($item = $stmt_estoque->fetch()):
                            ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                                    <td style="padding: 12px 5px; color: #fff;">
                                        <strong><?= htmlspecialchars($item['modelo']) ?></strong>
                                        <div style="font-size: 0.75rem; color: #8E8E93;"><?= htmlspecialchars($item['armazenamento']) ?></div>
                                    </td>
                                    <td style="padding: 12px 5px; font-weight: 600; color: #0A84FF;">
                                        R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                                    </td>
                                    <td style="padding: 12px 5px; text-align: center;">
                                        <a href="admin.php?action=deletar&id=<?= $item['id'] ?>" onclick="return confirm('Tem certeza absoluta que deseja deletar este <?= htmlspecialchars($item['modelo']) ?> do site?')" style="color: #FF453A; font-size: 1.1rem; padding: 5px;" title="Excluir Produto">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                endwhile;
                            endif; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script>
        function alternarVisibilidadeEstoque() {
            const wrapper = document.getElementById("tabelaEstoqueWrapper");
            const textoBotao = document.getElementById("textoBotaoEstoque");
            const iconeBotao = document.getElementById("iconeBotaoEstoque");
            
            if (wrapper.style.display === "none") {
                wrapper.style.display = "block";
                textoBotao.innerText = "Ocultar Estoque Atual";
                iconeBotao.className = "fa-solid fa-eye-slash";
            } else {
                wrapper.style.display = "none";
                textoBotao.innerText = "Mostrar Estoque Atual";
                iconeBotao.className = "fa-solid fa-eye";
            }
        }
    </script>
</body>
</html>