<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = "sql111.infinityfree.com";
$db_name = "if0_42457350_senha_hash";
$username = "if0_42457350";
$password = "K1XKRJRnTvud"; 
try {
    $conexao = new PDO("mysql:host=" . $host . ";dbname=" . $db_name . ";charset=utf8mb4", $username, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $erro) {
    die("Erro interno de comunicação com o servidor.");
}
?>