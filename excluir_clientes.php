<?php include('db.php'); ?>

<?php
if (!isset($_GET['id'])) {
    die("ID do cliente não especificado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM clientes WHERE id_cliente = ?");
$stmt->execute([$id]);

echo "Cliente excluído com sucesso!";
header("Location: clientes.php");
exit();
?>