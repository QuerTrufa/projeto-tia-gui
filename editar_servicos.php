<?php include('db.php'); ?>

<?php
if (!isset($_GET['id'])) {
    die("ID do serviço não especificado.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM servicos WHERE id_servico = ?");
$stmt->execute([$id]);
$servico = $stmt->fetch();

if (!$servico) {
    die("Serviço não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("UPDATE servicos SET descricao=?, preco=?, duracao_minutos=? WHERE id_servico=?");
    $stmt->execute([$_POST['descricao'], $_POST['preco'], $_POST['duracao_minutos'], $id]);
    echo "Dados do serviço atualizados com sucesso!";
    header("Location: servicos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Serviço</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Editar Serviço</h1>
    <form method="POST">
        <input type="text" name="descricao" value="<?php echo $servico['descricao']; ?>" placeholder="Descrição" required>
        <input type="number" name="preco" step="0.01" value="<?php echo $servico['preco']; ?>" placeholder="Preço (R$)" required>
        <input type="number" name="duracao_minutos" value="<?php echo $servico['duracao_minutos']; ?>" placeholder="Duração (minutos)" required>
        <button type="submit">Salvar Alterações</button>
    </form>
    <button onclick="window.location.href='servicos.php'">Voltar</button>
</body>
</html>