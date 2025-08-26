<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Serviços</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Cadastro de Serviços</h1>
    <form method="POST" action="servicos.php">
        <input type="text" name="descricao" placeholder="Descrição" required>
        <input type="number" name="preco" step="0.01" placeholder="Preço (R$)" required>
        <input type="number" name="duracao_minutos" placeholder="Duração (minutos)" required>
        <button type="submit">Cadastrar</button>
    </form>
    <button onclick="window.location.href='indexx.php'">Voltar</button>

    <h2>Lista de Serviços</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $stmt = $pdo->prepare("INSERT INTO servicos (descricao, preco, duracao_minutos) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['descricao'], $_POST['preco'], $_POST['duracao_minutos']]);
        echo "<p>Serviço cadastrado com sucesso!</p>";
    }

    $stmt = $pdo->query("SELECT * FROM servicos");
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>{$row['descricao']} - R$ {$row['preco']} - {$row['duracao_minutos']} min <a href='editar_servicos.php?id={$row['id_servico']}'>Editar</a> | <a href='excluir_servicos.php?id={$row['id_servico']}'>Excluir</a></li>";
    }
    echo "</ul>";
    ?>
</body>
</html>