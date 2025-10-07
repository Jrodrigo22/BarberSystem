<?php

session_start();


include '../includes/config/conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        header("Location: ../paginas/login.php?erro=credenciais_invalidas");
        exit();
    }

    try {
        $sql = "SELECT id_cliente, nome, senha FROM Clientes WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente && password_verify($senha, $cliente['senha'])) {
            
            $_SESSION['usuario_logado'] = true;
            $_SESSION['id_usuario'] = $cliente['id_cliente'];
            $_SESSION['nome_usuario'] = $cliente['nome'];
            $_SESSION['tipo_usuario'] = 'cliente'; 

            header("Location: ../paginas/pagInicial.php"); 
            exit();

        } else {
            header("Location: ../paginas/login.php?erro=credenciais_invalidas");
            exit();
        }

    } catch (PDOException $e) {
      
        die("Erro de acesso ao banco: " . $e->getMessage());
    }

} else {
   
    header("Location: ../paginas/login.php");
    exit();
}   