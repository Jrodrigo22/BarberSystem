<?php

include '../includes/verifica_sessao.php'; 
include '../includes/config/conexao.php'; 


try {
    $stmt = $pdo->query("SELECT id_cliente, nome, email, cpf, telefone FROM Clientes ORDER BY nome ASC");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar clientes: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Lista de Clientes | BarberSystem</title>
    <style>
     
      :root {
        --marrom: #4e342e;
        --bege: #f5e6d3;
        --dourado: #c49a6c;
        --branco: #ffffff;
        --preto: #1c1c1c;
      }
      body {
        font-family: Arial;
        margin: 24px;
        background: var(--bege);
        color: var(--preto);
      }
      .container {
        max-width: 1000px;
        margin: 0 auto;
      }
      h1 {
        color: var(--marrom);
        text-align: center;
        margin-bottom: 18px;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        background: var(--branco);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 6px;
        overflow: hidden;
      }
      th,
      td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #eee;
      }
      th {
        background-color: var(--marrom);
        color: var(--branco);
        font-weight: 700;
      }
      tr:hover td {
        background-color: #faf6f2;
      }
      .destaque {
        color: var(--dourado);
        font-weight: 600;
      }
      .acoes a {
          color: var(--marrom);
          text-decoration: none;
          font-weight: bold;
          margin-right: 10px;
      }
      .acoes a:hover {
          color: var(--dourado);
      }
    </style>
</head>
<body>
    <div class="container">
      <h1>Lista de Clientes Cadastrados</h1>
      <p><a href="pagInicial.php">← Voltar para a Página Inicial</a></p>
      
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Ações</th> 
          </tr>
        </thead>
        <tbody>
          <?php if (count($clientes) > 0): ?>
            <?php foreach ($clientes as $cliente): ?>
              <tr>
                <td><?php echo htmlspecialchars($cliente['id_cliente']); ?></td>
                <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                <td class="destaque"><?php echo htmlspecialchars($cliente['email']); ?></td>
                <td><?php echo htmlspecialchars($cliente['cpf']); ?></td>
                <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                <td class="acoes">
                    <a href="editar_cliente.php?id=<?php echo $cliente['id_cliente']; ?>">Editar</a> 
                    <a href="../processa/deletar_cliente.php?id=<?php echo $cliente['id_cliente']; ?>" 
                       onclick="return confirm('Tem certeza que deseja DELETAR o cliente <?php echo htmlspecialchars($cliente['nome']); ?>?');">Excluir</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">Nenhum cliente cadastrado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
      
      <p style="margin-top: 20px;"><a href="cadastro.php">Adicionar novo cliente</a></p>
    </div>
</body>
</html>