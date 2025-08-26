<?php include('db.php'); ?>

<?php
if (!isset($_GET['id'])) {
    die("ID do barbeiro não especificado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM barbeiros WHERE id_barbeiro = ?");
$stmt->execute([$id]);
$barbeiro = $stmt->fetch();

if (!$barbeiro) {
    die("Barbeiro não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("UPDATE barbeiros SET nome=?, cpf=?, fone=?, email=? WHERE id_barbeiro=?");
    $stmt->execute([$_POST['nome'], $_POST['cpf'], $_POST['fone'], $_POST['email'], $id]);
    echo "Dados do barbeiro atualizados com sucesso!";
    header("Location: barbeiros.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Barbeiro</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Editar Barbeiro</h1>
    <form method="POST">
        <input type="text" name="nome" value="<?php echo $barbeiro['nome']; ?>" placeholder="Nome" required>
        <input type="text" name="cpf" value="<?php echo $barbeiro['cpf']; ?>" placeholder="CPF" required>
        <input type="text" name="fone" value="<?php echo $barbeiro['fone']; ?>" placeholder="Telefone">
        <input type="email" name="email" value="<?php echo $barbeiro['email']; ?>" placeholder="E-mail">
        <button type="submit">Salvar Alterações</button>
    </form>
    <button onclick="window.location.href='barbeiros.php'">Voltar</button>
</body>
</html>