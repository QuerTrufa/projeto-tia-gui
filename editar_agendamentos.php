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