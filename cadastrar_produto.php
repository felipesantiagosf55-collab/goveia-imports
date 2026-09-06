<?php
require_once "conexao.php";
if (!isset($_SESSION['user_logged']) || $_SESSION['user_logged'] !== true) {
    header("Location: admin.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $condicao = htmlspecialchars(trim($_POST['condicao']), ENT_QUOTES, 'UTF-8');
    $modelo = htmlspecialchars(trim($_POST['modelo']), ENT_QUOTES, 'UTF-8');
    $armazenamento = htmlspecialchars(trim($_POST['armazenamento']), ENT_QUOTES, 'UTF-8');
    $preco = floatval($_POST['preco']);
    $detalhes = htmlspecialchars(trim($_POST['detalhes']), ENT_QUOTES, 'UTF-8');
    if (isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] === 0) {
        $arquivo = $_FILES['foto_produto'];
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($extensao, $extensoes_permitidas)) {
            echo "<script>alert('Extensão inválida! Use apenas JPG, PNG ou WEBP.'); window.location.href='admin.php';</script>";
            exit;
        }
        $pasta_destino = "imagens/";
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0755, true);
        }
        $novo_nome_foto = bin2hex(random_bytes(16)) . "." . $extensao;
        $caminho_final = $pasta_destino . $novo_nome_foto;
        if (!move_uploaded_file($arquivo['tmp_name'], $caminho_final)) {
            echo "<script>alert('Erro ao salvar o arquivo no servidor.'); window.location.href='admin.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Selecione uma imagem válida.'); window.location.href='admin.php';</script>";
        exit;
    }
    try {
        $stmt = $conexao->prepare("INSERT INTO produtos (condicao, modelo, armazenamento, preco, detalhes, foto_url) 
                                  VALUES (:condicao, :modelo, :armazenamento, :preco, :detalhes, :foto_url)");
        $stmt->bindParam(':condicao', $condicao);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':armazenamento', $armazenamento);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':detalhes', $detalhes);
        $stmt->bindParam(':foto_url', $caminho_final);
        if ($stmt->execute()) {
            echo "<script>alert('⚡ iPhone publicado com sucesso!'); window.location.href='admin.php';</script>";
            exit;
        }
    } catch(PDOException $erro) {
        echo "<script>alert('Erro interno ao salvar dados.'); window.location.href='admin.php';</script>";
    }
} else {
    header("Location: admin.php");
    exit;
}
?>