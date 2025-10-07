<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    
    
    header("Location: login.php");
    exit();
}


$id_usuario = $_SESSION['id_usuario'] ?? null;
$nome_usuario = $_SESSION['nome_usuario'] ?? 'Usuário';
$tipo_usuario = $_SESSION['tipo_usuario'] ?? 'cliente'; 
?>