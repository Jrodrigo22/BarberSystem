<?php

include '../includes/verifica_sessao.php'; 
include '../includes/config/conexao.php'; 


$modo_edicao = false;
$funcionario_editar = [
    'id_funcionario' => '',
    'nome' => '',
    'email' => '',
    'telefone' => '',
    'cargo' => 'Barbeiro' 
];
$mensagem = ''; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $cargo = trim($_POST['cargo']);
    $senha = $_POST['senha'];
    $id = (int)$_POST['id_funcionario'];

    try {
        if ($id > 0) {
        
            if (!empty($senha)) {
              
                $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
                $sql = "UPDATE Funcionarios SET nome = ?, email = ?, telefone = ?, cargo = ?, senha = ? WHERE id_funcionario = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $email, $telefone, $cargo, $senha_hashed, $id]);
            } else {
               
                $sql = "UPDATE Funcionarios SET nome = ?, email = ?, telefone = ?, cargo = ? WHERE id_funcionario = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $email, $telefone, $cargo, $id]);
            }
            $mensagem = '<p style="color: green;">Funcionário atualizado com sucesso!</p>';
        } else {
           
            if (empty($senha)) {
                 $mensagem = '<p style="color: orange;">A senha é obrigatória para o cadastro.</p>';
            
                 header("Location: funcionarios.php?msg=" . urlencode($mensagem));
                 exit();
            }
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Funcionarios (nome, email, telefone, cargo, senha) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $telefone, $cargo, $senha_hashed]);
            $mensagem = '<p style="color: green;">Funcionário cadastrado com sucesso!</p>';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            $mensagem = '<p style="color: red;">Erro: O e-mail já está em uso por outro funcionário.</p>';
        } else {
            $mensagem = '<p style="color: red;">Erro de DB: ' . $e->getMessage() . '</p>';
        }
    }
}


if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    $id = (int)$_GET['id'] ?? 0;

    if ($id > 0) {
        if ($acao == 'excluir') {

            try {
                $sql = "DELETE FROM Funcionarios WHERE id_funcionario = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                $mensagem = '<p style="color: green;">Funcionário excluído com sucesso!</p>';
                header("Location: funcionarios.php?msg=" . urlencode($mensagem));
                exit();
            } catch (PDOException $e) {
                $mensagem = '<p style="color: red;">Erro ao excluir: ' . $e->getMessage() . '</p>';
            }

        } elseif ($acao == 'editar') {

            try {
                $sql = "SELECT id_funcionario, nome, email, telefone, cargo FROM Funcionarios WHERE id_funcionario = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                $funcionario_editar = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($funcionario_editar) {
                    $modo_edicao = true;
                }
            } catch (PDOException $e) {
                 $mensagem = '<p style="color: red;">Erro ao buscar funcionário: ' . $e->getMessage() . '</p>';
            }
        }
    }
}


try {
    $stmt = $pdo->query("SELECT id_funcionario, nome, email, telefone, cargo FROM Funcionarios ORDER BY nome ASC");
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar funcionários: " . $e->getMessage());
}


if (isset($_GET['msg'])) {
    $mensagem = $_GET['msg'];
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Funcionários | BarberSystem</title>
    <style>
      
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;}
        .form-crud { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; margin-bottom: 30px; border-radius: 8px;}
        .form-crud label, .form-crud input, .form-crud select { display: block; margin-bottom: 10px; }
        .form-crud input[type="text"], .form-crud input[type="email"], .form-crud input[type="password"], .form-crud input[type="tel"], .form-crud select { width: 98%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .form-crud button { background-color: #4e342e; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4e342e; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Funcionários</h1>
        <a href="pagInicial.php">← Voltar para a Home</a>
        
        <?php echo $mensagem; ?>

        <div class="form-crud">
            <h2><?php echo $modo_edicao ? 'Editar Funcionário' : 'Novo Funcionário'; ?></h2>
            <form method="POST" action="funcionarios.php">
                
                <input type="hidden" name="id_funcionario" value="<?php echo htmlspecialchars($funcionario_editar['id_funcionario']); ?>">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required 
                       value="<?php echo htmlspecialchars($funcionario_editar['nome']); ?>"><br>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required 
                       value="<?php echo htmlspecialchars($funcionario_editar['email']); ?>"><br>
                       
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" 
                       value="<?php echo htmlspecialchars($funcionario_editar['telefone']); ?>"><br>

                <label for="cargo">Cargo:</label>
                <select id="cargo" name="cargo" required>
                    <option value="Barbeiro" <?php echo ($funcionario_editar['cargo'] == 'Barbeiro') ? 'selected' : ''; ?>>Barbeiro</option>
                    <option value="Administrador" <?php echo ($funcionario_editar['cargo'] == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                </select><br>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" 
                       placeholder="<?php echo $modo_edicao ? 'Deixe em branco para não alterar' : 'Senha inicial (obrigatório)'; ?>"
                       <?php echo $modo_edicao ? '' : 'required'; ?>><br>

                <button type="submit"><?php echo $modo_edicao ? 'Salvar Edição' : 'Cadastrar Funcionário'; ?></button>
                <?php if ($modo_edicao): ?>
                    <a href="funcionarios.php" style="margin-left: 15px;">Cancelar Edição</a>
                <?php endif; ?>
            </form>
        </div>

        <h2>Lista de Funcionários Cadastrados</h2>
        <?php if (count($funcionarios) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Cargo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($funcionarios as $func): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($func['id_funcionario']); ?></td>
                        <td><?php echo htmlspecialchars($func['nome']); ?></td>
                        <td><?php echo htmlspecialchars($func['email']); ?></td>
                        <td><?php echo htmlspecialchars($func['telefone']); ?></td>
                        <td><?php echo htmlspecialchars($func['cargo']); ?></td>
                        <td>
                            <a href="funcionarios.php?acao=editar&id=<?php echo $func['id_funcionario']; ?>">Editar</a> | 
                            <a href="funcionarios.php?acao=excluir&id=<?php echo $func['id_funcionario']; ?>" 
                               onclick="return confirm('Tem certeza que deseja excluir o funcionário <?php echo htmlspecialchars($func['nome']); ?>?');">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum funcionário cadastrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>