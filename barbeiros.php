<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Barbeiros</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Cadastro de Barbeiros</h1>
    <form method="POST" action="barbeiros.php">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="cpf" placeholder="CPF" required>
        <input type="text" name="fone" placeholder="Telefone">
        <input type="email" name="email" placeholder="E-mail">
        <button type="submit">Cadastrar</button>
    </form>
    <button onclick="window.location.href='indexx.php'">Voltar</button>

    <h2>Lista de Barbeiros</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $stmt = $pdo->prepare("INSERT INTO barbeiros (nome, cpf, fone, email) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_POST['nome'], $_POST['cpf'], $_POST['fone'], $_POST['email']]);
            echo "<p style='color: green;'>Barbeiro cadastrado com sucesso!</p>";
        } catch (PDOException $e) {
            // Verifica se o erro é de violação de restrição de unicidade
            if ($e->getCode() == '23000') {
                $errorMessage = $e->getMessage();
                // Verifica se a mensagem contém o nome da restrição de CPF duplicado
                if (strpos($errorMessage, 'unico_barbeiro_cpf') !== false) {
                    echo "<p style='color: red;'>Erro: CPF já cadastrado.</p>";
                } elseif (strpos($errorMessage, 'unico_barbeiro_email') !== false) {
                    echo "<p style='color: red;'>Erro: E-mail já cadastrado.</p>";
                } else {
                    echo "<p style='color: red;'>Erro ao cadastrar o barbeiro: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            } else {
                // Outros erros
                echo "<p style='color: red;'>Erro inesperado: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    }

    $stmt = $pdo->query("SELECT * FROM barbeiros");
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>{$row['nome']} - CPF: {$row['cpf']} <a href='editar_barbeiros.php?id={$row['id_barbeiro']}'>Editar</a> | <a href='excluir_barbeiros.php?id={$row['id_barbeiro']}'>Excluir</a></li>";
    }
    echo "</ul>";
    ?>
</body>
</html>