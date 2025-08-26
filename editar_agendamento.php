<?php include('db.php'); ?>

<?php
if (!isset($_GET['id'])) {
    die("ID do agendamento não especificado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE id_agendamento = ?");
$stmt->execute([$id]);
$agendamento = $stmt->fetch();

if (!$agendamento) {
    die("Agendamento não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("UPDATE agendamentos SET id_cliente=?, id_barbeiro=?, id_servico=?, data_agendamento=?, hora_agendamento=?, observacoes=? WHERE id_agendamento=?");
    $stmt->execute([$_POST['id_cliente'], $_POST['id_barbeiro'], $_POST['id_servico'], $_POST['data_agendamento'], $_POST['hora_agendamento'], $_POST['observacoes'], $id]);
    echo "Agendamento atualizado com sucesso!";
    header("Location: agendamentos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Agendamento</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Editar Agendamento</h1>
    <form method="POST">
        <label>Cliente:</label>
        <select name="id_cliente" required>
            <?php
            $stmt = $pdo->query("SELECT id_cliente, nome FROM clientes");
            while ($row = $stmt->fetch()) {
                $selected = ($row['id_cliente'] == $agendamento['id_cliente']) ? 'selected' : '';
                echo "<option value='{$row['id_cliente']}' $selected>{$row['nome']}</option>";
            }
            ?>
        </select>

        <label>Barbeiro:</label>
        <select name="id_barbeiro" required>
            <?php
            $stmt = $pdo->query("SELECT id_barbeiro, nome FROM barbeiros");
            while ($row = $stmt->fetch()) {
                $selected = ($row['id_barbeiro'] == $agendamento['id_barbeiro']) ? 'selected' : '';
                echo "<option value='{$row['id_barbeiro']}' $selected>{$row['nome']}</option>";
            }
            ?>
        </select>

        <label>Serviço:</label>
        <select name="id_servico" required>
            <?php
            $stmt = $pdo->query("SELECT id_servico, descricao FROM servicos");
            while ($row = $stmt->fetch()) {
                $selected = ($row['id_servico'] == $agendamento['id_servico']) ? 'selected' : '';
                echo "<option value='{$row['id_servico']}' $selected>{$row['descricao']}</option>";
            }
            ?>
        </select>

        <label>Data:</label>
        <input type="date" name="data_agendamento" value="<?php echo $agendamento['data_agendamento']; ?>" required>

        <label>Hora:</label>
        <input type="time" name="hora_agendamento" value="<?php echo $agendamento['hora_agendamento']; ?>" required>

        <label>Observações:</label>
        <textarea name="observacoes"><?php echo $agendamento['observacoes']; ?></textarea>

        <button type="submit">Salvar Alterações</button>
    </form>
    <button onclick="window.location.href='agendamentos.php'">Voltar</button>
</body>
</html>