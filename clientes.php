<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Cadastro de Clientes</h1>
    <form method="POST" action="clientes.php">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="cpf" placeholder="CPF" required>
        <input type="text" name="fone" placeholder="Telefone">
        <input type="email" name="email" placeholder="E-mail">
        <input type="date" name="data_nascimento" required>
        <button type="submit">Cadastrar</button>
    </form>
    <button onclick="window.location.href='indexx.php'">Voltar</button>

    <h2>Lista de Clientes</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $stmt = $pdo->prepare("INSERT INTO clientes (nome, cpf, fone, email, data_nascimento) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['nome'],
                $_POST['cpf'],
                $_POST['fone'],
                $_POST['email'],
                $_POST['data_nascimento']
            ]);
            echo "<p style='color: green;'>Cliente cadastrado com sucesso!</p>";
        } catch (PDOException $e) {
            // Verifica se o erro é de violação de restrição de unicidade
            if ($e->getCode() == '23000') {
                // Verifica a mensagem de erro para identificar qual restrição foi violada
                if (strpos($e->getMessage(), 'unico_cliente_cpf') !== false) {
                    echo "<p style='color: red;'>Erro: CPF já cadastrado. Por favor, utilize outro CPF.</p>";
                } elseif (strpos($e->getMessage(), 'unico_cliente_email') !== false) {
                    echo "<p style='color: red;'>Erro: E-mail já cadastrado. Por favor, utilize outro e-mail.</p>";
                } else {
                    echo "<p style='color: red;'>Erro de integridade no banco de dados. Por favor, verifique os dados.</p>";
                }
            } else {
                // Outros erros
                echo "<p style='color: red;'>Ocorreu um erro ao cadastrar o cliente: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    }

    $stmt = $pdo->query("SELECT * FROM clientes");
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>{$row['nome']} - CPF: {$row['cpf']} <a href='editar_clientes.php?id={$row['id_cliente']}'>Editar</a> | <a href='excluir_clientes.php?id={$row['id_cliente']}'>Excluir</a></li>";
    }
    echo "</ul>";
    ?>
</body>
</html>