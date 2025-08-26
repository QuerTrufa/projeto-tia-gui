<?php include('db.php'); ?>

<?php
if (!isset($_GET['id'])) {
    die("ID do cliente não especificado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmt->execute([$id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    die("Cliente não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("UPDATE clientes SET nome=?, cpf=?, fone=?, email=?, data_nascimento=? WHERE id_cliente=?");
    $stmt->execute([$_POST['nome'], $_POST['cpf'], $_POST['fone'], $_POST['email'], $_POST['data_nascimento'], $id]);
    echo "Dados do cliente atualizados com sucesso!";
    header("Location: clientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Editar Cliente</h1>
    <form method="POST">
        <input type="text" name="nome" value="<?php echo $cliente['nome']; ?>" placeholder="Nome" required>
        <input type="text" name="cpf" value="<?php echo $cliente['cpf']; ?>" placeholder="CPF" required>
        <input type="text" name="fone" value="<?php echo $cliente['fone']; ?>" placeholder="Telefone">
        <input type="email" name="email" value="<?php echo $cliente['email']; ?>" placeholder="E-mail">
        <input type="date" name="data_nascimento" value="<?php echo $cliente['data_nascimento']; ?>" required>
        <button type="submit">Salvar Alterações</button>
    </form>
    <button onclick="window.location.href='clientes.php'">Voltar</button>
</body>
</html>