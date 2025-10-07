<?php
// Arquivo: paginas/editar_cliente.php - Formulário de Edição (U - Update)

// 1. Inclui a proteção de sessão e a conexão (usando o caminho corrigido)
include '../includes/verifica_sessao.php'; 
include '../includes/config/conexao.php'; 

// Somente administradores ou funcionários devem poder editar!
if ($_SESSION['tipo_usuario'] == 'cliente') {
    header("Location: pagInicial.php");
    exit();
}

// 2. Verifica se o ID do cliente foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listagem.php");
    exit();
}

$id_cliente = (int)$_GET['id'];
$cliente = null;

try {
    // 3. Busca os dados atuais do cliente para preencher o formulário (R - Read)
    $sql = "SELECT nome, cpf, email, telefone FROM Clientes WHERE id_cliente = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_cliente]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        // Se o cliente não for encontrado
        header("Location: listagem.php?erro=cliente_nao_encontrado");
        exit();
    }

} catch (PDOException $e) {
    die("Erro ao carregar dados do cliente: " . $e->getMessage());
}

// Lógica para exibir mensagens de erro/sucesso (se vierem do script de processamento)
$mensagem = '';
if (isset($_GET['sucesso'])) {
    $mensagem = '<p style="color: green; font-weight: bold; margin-bottom: 15px;">Cliente atualizado com sucesso!</p>';
} elseif (isset($_GET['erro'])) {
    if ($_GET['erro'] == 'email_existente') {
        $mensagem = '<p style="color: red; font-weight: bold; margin-bottom: 15px;">Erro: O e-mail informado já está em uso.</p>';
    }
    // ... outros erros
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Cliente - BarberSystem</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f5e1c8;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }

      .container {
        background-color: #4e2d20;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        width: 350px;
        color: #fff;
      }

      .container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #fff;
      }

      label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
        color: #f5c16c;
      }

      input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: none;
        border-radius: 5px;
      }

      button {
        width: 100%;
        padding: 10px;
        margin-top: 20px;
        background-color: #c48a51;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        cursor: pointer;
        transition: 0.3s;
      }

      button:hover {
        background-color: #a66f3f;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Editar Cliente: <?php echo htmlspecialchars($cliente['nome']); ?></h2>
      <p><a href="listagem.php" style="color: #f5c16c; text-decoration: none;">← Voltar para Listagem</a></p>
      
      <?php echo $mensagem; ?>

      <form action="../processa/editar_cliente.php" method="POST">
        
        <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">

        <label for="nome">Nome:</label>
        <input
          type="text"
          id="nome"
          name="nome"
          value="<?php echo htmlspecialchars($cliente['nome']); ?>"
          required
        />

        <label for="cpf">CPF:</label>
        <input
          type="text"
          id="cpf"
          name="cpf"
          value="<?php echo htmlspecialchars($cliente['cpf']); ?>"
          required
        />

        <label for="email">E-mail:</label>
        <input
          type="email"
          id="email"
          name="email"
          value="<?php echo htmlspecialchars($cliente['email']); ?>"
          required
        />

        <label for="telefone">Telefone:</label>
        <input
          type="tel"
          id="telefone"
          name="telefone"
          value="<?php echo htmlspecialchars($cliente['telefone']); ?>"
        />

        <label for="senha">Nova Senha (Opcional):</label>
        <input
          type="password"
          id="senha"
          name="senha"
          placeholder="Deixe em branco para manter a senha atual"
        />

        <button type="submit">Salvar Alterações</button>
      </form>
    </div>
  </body>
</html>