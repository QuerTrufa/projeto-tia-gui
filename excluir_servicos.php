<?php include('db.php'); ?>

<?php
if (!isset($_GET['id'])) {
    die("ID do serviço não especificado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM servicos WHERE id_servico = ?");
$stmt->execute([$id]);

echo "Serviço excluído com sucesso!";
header("Location: servicos.php");
exit();
?>