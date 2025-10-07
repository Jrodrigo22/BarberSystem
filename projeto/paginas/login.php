<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$mensagem = '';
if (isset($_GET['erro'])) {
    if ($_GET['erro'] == 'credenciais_invalidas') {
        $mensagem = '<p style="color: #ffcc00; font-weight: bold; margin-bottom: 10px;">Erro: E-mail ou senha inválidos!</p>';
    } elseif ($_GET['erro'] == 'acesso_negado') {
        $mensagem = '<p style="color: #ffcc00; font-weight: bold; margin-bottom: 10px;">Acesso negado. Faça login.</p>';
    }
} elseif (isset($_GET['cadastro_sucesso'])) {
    $mensagem = '<p style="color: lightgreen; font-weight: bold; margin-bottom: 10px;">Cadastro realizado com sucesso! Faça login.</p>';
} elseif (isset($_GET['logout'])) {
    $mensagem = '<p style="color: lightblue; font-weight: bold; margin-bottom: 10px;">Sessão encerrada com sucesso.</p>';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BarberSystem - Login Cliente</title>
    <style>
      :root {
        --dark-brown: #4e342e;
        --light-beige: #f5e6d3;
        --gold: #c49a6c;
        --white: #ffffff;
        --black: #1c1c1c;
      }

      body {
        font-family: Arial, sans-serif;
        background-color: var(--light-beige);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        position: relative;
      }

      .login-container {
        background-color: var(--dark-brown);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 300px;
        text-align: center;
      }

      h1 {
        color: var(--dark-brown);
        font-size: 3em;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      }

      h2 {
        color: var(--gold);
        font-size: 1.2em;
        margin-top: 15px;
        margin-bottom: 5px;
        text-transform: uppercase;
      }

      input[type="email"],
      input[type="password"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        background-color: var(--white);
        color: var(--black);
        font-size: 1em;
        outline: none;
      }

      input[type="email"]::placeholder,
      input[type="password"]::placeholder {
        color: #888;
      }

      button {
        background-color: var(--gold);
        color: var(--dark-brown);
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      button:hover {
        background-color: #c49a6c;
      }

      .employee-link {
        position: absolute;
        bottom: 20px;
        right: 20px;
        color: var(--dark-brown);
        text-decoration: none;
        font-weight: bold;
        font-size: 0.9em;
      }

      .employee-link:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>BarberSystem - Cliente</h1>

    <div class="login-container">
        <?php echo $mensagem;  ?>
      
        <form action="../processa/login_cliente.php" method="POST">
            <h2>E-MAIL:</h2>
            <input type="email" name="email" placeholder="Digite seu e-mail" required />
            
            <h2>SENHA:</h2>
            <input type="password" name="senha" placeholder="Digite sua senha" required />
            
            <button type="submit">Login</button>
        </form>
    </div>

    <a href="cadastro.php" class="employee-link">Cadastrar.</a>
    
    <a href="admLogin.php" class="employee-link" style="bottom: 40px; right: 20px;">Sou Funcionário/Barbeiro.</a>
  </body>
</html>