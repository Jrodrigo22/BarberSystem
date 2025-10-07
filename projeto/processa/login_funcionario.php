<?php

session_start();
include '../includes/config/conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        header("Location: ../paginas/admLogin.php?erro=vazio");
        exit();
    }

    try {
    
        $sql = "SELECT id_funcionario, nome, senha, cargo FROM Funcionarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

  
        if ($funcionario && $senha === $funcionario['senha']) { 
            
          
            $_SESSION['usuario_logado'] = true;
            $_SESSION['id_usuario'] = $funcionario['id_funcionario'];
            $_SESSION['nome_usuario'] = $funcionario['nome'];
            $_SESSION['tipo_usuario'] = $funcionario['cargo']; 

            header("Location: ../paginas/pagInicial.php"); 
            exit();

        } else {
            header("Location: ../paginas/admLogin.php?erro=credenciais_invalidas");
            exit();
        }

    } catch (PDOException $e) {
        die("Erro de acesso ao banco: " . $e->getMessage());
    }

} else {
    header("Location: ../paginas/admLogin.php");
    exit();
}
?>