<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agendamentos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Agendar Serviço</h1>
    <form method="POST" action="agendamentos.php">
        <label>Cliente:</label>
        <select name="id_cliente" required>
            <?php
            $stmt = $pdo->query("SELECT id_cliente, nome FROM clientes");
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id_cliente']}'>{$row['nome']}</option>";
            }
            ?>
        </select>

        <label>Barbeiro:</label>
        <select name="id_barbeiro" required>
            <?php
            $stmt = $pdo->query("SELECT id_barbeiro, nome FROM barbeiros");
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id_barbeiro']}'>{$row['nome']}</option>";
            }
            ?>
        </select>

        <label>Serviço:</label>
        <select name="id_servico" required>
            <?php
            $stmt = $pdo->query("SELECT id_servico, descricao FROM servicos");
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id_servico']}'>{$row['descricao']}</option>";
            }
            ?>
        </select>

        <label>Data:</label>
        <input type="date" name="data_agendamento" required>

        <label>Hora:</label>
        <input type="time" name="hora_agendamento" required>

        <label>Observações:</label>
        <textarea name="observacoes"></textarea>

        <button type="submit">Agendar</button>
    </form>

    <button onclick="window.location.href='indexx.php'">Voltar</button>

    <h2>Lista de Agendamentos</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $stmt = $pdo->prepare("INSERT INTO agendamentos (id_cliente, id_barbeiro, id_servico, data_agendamento, hora_agendamento, observacoes) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['id_cliente'], $_POST['id_barbeiro'], $_POST['id_servico'], $_POST['data_agendamento'], $_POST['hora_agendamento'], $_POST['observacoes']]);
        echo "Agendamento realizado com sucesso!";
    }

    $stmt = $pdo->query("SELECT agendamentos.*, clientes.nome AS cliente_nome, barbeiros.nome AS barbeiro_nome, servicos.descricao AS servico_descricao 
                         FROM agendamentos 
                         JOIN clientes ON agendamentos.id_cliente = clientes.id_cliente 
                         JOIN barbeiros ON agendamentos.id_barbeiro = barbeiros.id_barbeiro 
                         JOIN servicos ON agendamentos.id_servico = servicos.id_servico");

    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>{$row['data_agendamento']} - {$row['hora_agendamento']} - {$row['cliente_nome']} - {$row['barbeiro_nome']} - {$row['servico_descricao']} 
              <a href='editar_agendamento.php?id={$row['id_agendamento']}'>Editar</a> | <a href='excluir_agendamento.php?id={$row['id_agendamento']}'>Excluir</a></li>";
    }
    echo "</ul>";
    ?>
</body>
</html>