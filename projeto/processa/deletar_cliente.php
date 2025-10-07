<?php

session_start();
include '../includes/verifica_sessao.php';
include '../includes/config/conexao.php'; 

if ($_SESSION['tipo_usuario'] == 'cliente') {
    header("Location: ../paginas/pagInicial.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_cliente = (int)$_GET['id'];

    if ($id_cliente > 0) {
        try {
            $sql = "DELETE FROM Clientes WHERE id_cliente = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_cliente]);

            header("Location: ../paginas/listagem.php?sucesso=cliente_deletado");
            exit();
            
        } catch (PDOException $e) {
      
            header("Location: ../paginas/listagem.php?erro=erro_deletar_cliente");
            exit();
        }
    }
}

header("Location: ../paginas/listagem.php");
exit();
?>