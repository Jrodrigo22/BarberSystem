<?php
include '../includes/config/conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if ($senha !== $confirmar_senha) {
        header("Location: ../paginas/cadastro.php?erro=senhas_diferentes");
        exit();
    }
    

    $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO Clientes (nome, cpf, email, telefone, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $cpf, $email, $telefone, $senha_hashed]);

        header("Location: ../paginas/login.php?cadastro_sucesso=true");
        exit();

    } catch (PDOException $e) {
        $errorCode = $e->getCode();
        if ($errorCode == 23000) { 
            header("Location: ../paginas/cadastro.php?erro=email_existente"); 
            exit();
        } else {
            die("Erro ao cadastrar: " . $e->getMessage());
        }
    }
} else {
  
    header("Location: ../paginas/cadastro.php");
    exit();
}