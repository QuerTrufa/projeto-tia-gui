<?php include('db.php'); ?>

<?php
if (!isset($_GET['id'])) {
    die("ID do barbeiro não especificado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM barbeiros WHERE id_barbeiro = ?");
$stmt->execute([$id]);

echo "Barbeiro excluído com sucesso!";
header("Location: barbeiros.php");
exit();
?>