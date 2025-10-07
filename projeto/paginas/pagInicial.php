<?php

include '../includes/verifica_sessao.php'; 

include '../includes/config/conexao.php'; 


try {
    $stmt = $pdo->query("SELECT id_servico, nome_servico, descricao, preco FROM Servicos ORDER BY nome_servico ASC");
    $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
 
    $servicos = []; 
    $erro_servicos = "Não foi possível carregar os serviços. Erro: " . $e->getMessage();
}


$nome_usuario = $_SESSION['nome_usuario'];
$tipo_usuario = $_SESSION['tipo_usuario'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BarberSystem | Olá, <?php echo htmlspecialchars($nome_usuario); ?></title>
  <style>
  
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f5f1e6; 
      color: #111;
    }

    header {
      background-color: #3b2b2b; 
      color: #fff;
      padding: 20px 0;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 32px;
      color: #d4af37;
    }

    header p {
      margin: 5px 0 0;
      font-size: 16px;
      color: #fff;
    }

    nav {
      margin-top: 10px;
    }

    nav a {
      color: #fff;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
    }

    nav a:hover {
      color: #d4af37;
    }

    .container {
      padding: 40px 20px;
      text-align: center;
    }

    .button {
      background-color: #d4af37; 
      color: #111; 
      padding: 15px 30px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      font-size: 18px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
      display: inline-block;
      margin-top: 10px;
    }

    .button:hover {
      background-color: #b9972d;
    }

    .servicos {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 40px;
    }

    .card {
      background: #fff;
      border: 2px solid #d4af37; 
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }

    .card h3 {
      color: #3b2b2b; 
      margin-bottom: 10px;
    }

    footer {
      background-color: #3b2b2b; 
      color: #fff;
      padding: 20px 0;
      margin-top: 40px;
      text-align: center;
    }

    footer p {
      margin: 5px 0;
    }
  </style>
</head>
<body>
  <header>
    <h1>BarberSystem</h1>
    <p>Bem-vindo(a), <?php echo htmlspecialchars($nome_usuario); ?>! | <a href="../processa/logout.php" style="color: #ffc107;">Sair</a></p>
    
    <nav>
      <a href="#servicos">Serviços</a>
      <a href="agendamento.php">Agendar</a>
      <a href="#contato">Contato</a>
      
      <?php if ($tipo_usuario != 'cliente'): ?>
          <a href="servicos.php" style="color: #FF6347;">Gerenciar Serviços</a>
          <a href="listagem.php" style="color: #FF6347;">Ver Clientes</a>
      <?php endif; ?>
    </nav>
  </header>

  <div class="container">
    <h2>Escolha seu corte e agende com facilidade</h2>
    <a class="button" href="agendamento.php">Agendar Agora</a>

    <section id="servicos">
      <h2>Nossos Serviços</h2>
      
      <?php if (isset($erro_servicos)): ?>
          <p style="color: red;"><?php echo $erro_servicos; ?></p>
      <?php elseif (empty($servicos)): ?>
          <p>Nenhum serviço está cadastrado no momento. Por favor, cadastre alguns na área de Gerenciamento.</p>
      <?php else: ?>
      
        <div class="servicos">
          <?php foreach ($servicos as $servico): ?>
          <div class="card">
            <h3><?php echo htmlspecialchars($servico['nome_servico']); ?></h3>
            <p><?php echo htmlspecialchars($servico['descricao']); ?></p> 
            <p><strong>R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?></strong></p>
            <a class="button" href="agendamento.php?servico=<?php echo $servico['id_servico']; ?>">Selecionar</a>
          </div>
          <?php endforeach; ?> </div>
      <?php endif; ?> </section>
  </div>

  <footer id="contato">
    <p>📍 Rua Exemplo, 123 - Gravataí/RS</p>
    <p>📞 (11) 99999-9999</p>
    <p>WhatsApp: (11) 98888-8888</p>
  </footer>
</body>
</html>