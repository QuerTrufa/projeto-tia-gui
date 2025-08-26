<?php include('db.php'); ?>

<?php
if (!isset($_GET['id'])) {
    die("ID do agendamento não especificado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id_agendamento = ?");
$stmt->execute([$id]);

echo "Agendamento excluído com sucesso!";
header("Location: agendamentos.php");
exit();
?>