<?php

session_start();
include '../includes/verifica_sessao.php'; 
include '../includes/config/conexao.php'; 

if ($_SESSION['tipo_usuario'] == 'cliente') {
    header("Location: ../paginas/pagInicial.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_cliente = (int)$_POST['id_cliente'];
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $nova_senha = $_POST['senha'] ?? '';

    try {
        if (!empty($nova_senha)) {
            $senha_hashed = password_hash($nova_senha, PASSWORD_DEFAULT);
            $sql = "UPDATE Clientes SET nome = ?, cpf = ?, email = ?, telefone = ?, senha = ? WHERE id_cliente = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $cpf, $email, $telefone, $senha_hashed, $id_cliente]);
        } else {
            $sql = "UPDATE Clientes SET nome = ?, cpf = ?, email = ?, telefone = ? WHERE id_cliente = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $cpf, $email, $telefone, $id_cliente]);
        }

        header("Location: ../paginas/editar_cliente.php?id=$id_cliente&sucesso=true");
        exit();

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            header("Location: ../paginas/editar_cliente.php?id=$id_cliente&erro=email_existente"); 
            exit();
        } else {
            die("Erro ao atualizar cliente: " . $e->getMessage());
        }
    }
} else {
    header("Location: ../paginas/listagem.php");
    exit();
}
?>