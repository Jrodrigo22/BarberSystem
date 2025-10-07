<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$mensagem_erro = '';
if (isset($_GET['erro'])) {
    if ($_GET['erro'] == 'senhas_diferentes') {
        $mensagem_erro = '<p style="color: #ffcc00; font-weight: bold; margin-bottom: 10px;">Erro: As senhas digitadas não coincidem.</p>';
    } elseif ($_GET['erro'] == 'email_existente') {
        $mensagem_erro = '<p style="color: #ffcc00; font-weight: bold; margin-bottom: 10px;">Erro: O e-mail informado já está cadastrado.</p>';
    } elseif ($_GET['erro'] == 'cpf_invalido') {
        $mensagem_erro = '<p style="color: #ffcc00; font-weight: bold; margin-bottom: 10px;">Erro: O CPF não é válido ou já está cadastrado.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro - BarberSystem</title>
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

      .link {
        text-align: center;
        margin-top: 15px;
      }

      .link a {
        color: #f5c16c;
        text-decoration: none;
        font-size: 14px;
      }

      .link a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Cadastro - BarberSystem</h2>
      
      <?php echo $mensagem_erro; ?>
      
      <form action="../processa/cadastro.php" method="POST">
        <label for="nome">Nome:</label>
        <input
          type="text"
          id="nome"
          name="nome"
          placeholder="Digite seu nome"
          required
        />

        <label for="cpf">CPF:</label>
        <input
          type="text"
          id="cpf"
          name="cpf"
          placeholder="Digite seu CPF"
          required
        />

        <label for="email">E-mail:</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="Digite seu e-mail"
          required
        />

        <label for="telefone">Telefone:</label>
        <input
          type="tel"
          id="telefone"
          name="telefone"
          placeholder="Digite seu telefone"
        />

        <label for="senha">Senha:</label>
        <input
          type="password"
          id="senha"
          name="senha"
          placeholder="Digite sua senha"
          required
        />
        
        <label for="confirmar_senha">Confirme a Senha:</label>
        <input
          type="password"
          id="confirmar_senha"
          name="confirmar_senha"
          placeholder="Confirme sua senha"
          required
        />
        <button type="submit">Cadastrar</button>
      </form>

      <div class="link">
        <p>Já tem conta? <a href="login.php">Fazer login</a></p>
      </div>
    </div>
  </body>
</html>