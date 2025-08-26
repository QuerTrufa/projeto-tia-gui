<?php
include 'db1.php';

// Processa o agendamento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_cliente = $_POST['nome_cliente'];
    $cpf_cliente = $_POST['cpf_cliente'];
    $id_barbeiro = $_POST['id_barbeiro'];
    $id_servico = $_POST['id_servico'];
    $data_agendamento = $_POST['data_agendamento'];
    $hora_agendamento = $_POST['hora_agendamento'];
    $observacoes = $_POST['observacoes'];

    // Verifica se o cliente já está cadastrado no banco
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE cpf = ?");
    $stmt->execute([$cpf_cliente]);
    $cliente = $stmt->fetch();

    if (!$cliente) {
        // Se o cliente não existir, registra o novo cliente
        $stmt = $pdo->prepare("INSERT INTO clientes (nome, cpf) VALUES (?, ?)");
        $stmt->execute([$nome_cliente, $cpf_cliente]);

        // Recupera o ID do novo cliente
        $id_cliente = $pdo->lastInsertId();
    } else {
        // Se o cliente já estiver cadastrado, usa o ID dele
        $id_cliente = $cliente['id_cliente'];
    }

    // Realiza o agendamento
    $sql = "INSERT INTO agendamentos (id_cliente, id_barbeiro, id_servico, data_agendamento, hora_agendamento, observacoes)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_cliente, $id_barbeiro, $id_servico, $data_agendamento, $hora_agendamento, $observacoes]);

    echo "<script>alert('Agendamento realizado com sucesso!'); window.location.href='agendar.php';</script>";
}

// Obtém os barbeiros e serviços disponíveis
$barbeiros = $pdo->query("SELECT * FROM barbeiros")->fetchAll();
$servicos = $pdo->query("SELECT * FROM servicos")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Corte | German's Barber</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Adiciona o CSS para o layout flexível */
        html, body {
            height: 100%;
            margin: 0;
            position: relative; /* Para permitir que o overlay se posicione sobre o fundo */
        }

        /* Imagem de fundo */
        body {
            background-image: url('img/barbearia.jpg'); /* Caminho para a imagem de fundo */
            background-size: cover;  /* Faz a imagem cobrir toda a tela */
            background-position: center;  /* Centraliza a imagem */
            background-attachment: fixed;  /* Faz a imagem ficar fixa ao rolar a página */
            display: flex;
            flex-direction: column;
        }

        /* Overlay para clareamento */
        .overlay {
            position: absolute; /* Sobre a imagem */
            top: 0;
            left: 0;
            width: 100%;
            height: 1108px;
            background: rgba(255, 255, 255, 0.59); /* Cor branca com opacidade */
            z-index: -1; /* Coloca o overlay atrás do conteúdo */
        }

        footer {
            margin-top: auto; /* Isso garante que o footer vá para o final da página */
        }

        .container {
            flex: 1;
            padding: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        textarea {
            resize: none;
        }
    </style>
</head>
<body>
    <!-- Overlay com clareamento -->
    <div class="overlay"></div>

    <?php include 'header.html'; ?>

    <div class="container my-5">
        <h1 class="text-center">Agende seu Corte</h1>

        <form method="POST">
            <!-- Informações do Cliente -->
            <div class="mb-3">
                <label for="nome_cliente" class="form-label">Seu Nome</label>
                <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
            </div>

            <div class="mb-3">
                <label for="cpf_cliente" class="form-label">Seu CPF</label>
                <input type="text" class="form-control" id="cpf_cliente" name="cpf_cliente" required>
            </div>

            <div class="mb-3">
                <label for="cliente_telefone" class="form-label">Seu Telefone</label>
                <input type="tel" class="form-control" id="cliente_telefone" name="cliente_telefone">
            </div>

            <div class="mb-3">
                <label for="cliente_email" class="form-label">Seu E-mail</label>
                <input type="text" class="form-control" id="cliente_email" name="cliente_email">
            </div>

            <!-- Escolha do Barbeiro -->
            <div class="mb-3">
                <label for="id_barbeiro" class="form-label">Escolha o Barbeiro</label>
                <select class="form-select" id="id_barbeiro" name="id_barbeiro" required>
                    <option value="">Selecione um Barbeiro</option>
                    <?php foreach ($barbeiros as $barbeiro): ?>
                        <option value="<?= $barbeiro['id_barbeiro'] ?>"><?= $barbeiro['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Escolha do Serviço -->
            <div class="mb-3">
                <label for="id_servico" class="form-label">Escolha o Serviço</label>
                <select class="form-select" id="id_servico" name="id_servico" required>
                    <option value="">Selecione um Serviço</option>
                    <?php foreach ($servicos as $servico): ?>
                        <option value="<?= $servico['id_servico'] ?>"><?= $servico['descricao'] ?> - R$ <?= number_format($servico['preco'], 2, ',', '.') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Data e Hora do Agendamento -->
            <div class="mb-3">
                <label for="data_agendamento" class="form-label">Data do Agendamento</label>
                <input type="date" class="form-control" id="data_agendamento" name="data_agendamento" required>
            </div>

            <div class="mb-3">
                <label for="hora_agendamento" class="form-label">Hora do Agendamento</label>
                <input type="time" class="form-control" id="hora_agendamento" name="hora_agendamento" required>
            </div>

            <!-- Observações -->
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Agendar Corte</button>
            </div>
        </form>
    </div>

    <?php include 'footer.html'; ?>
</body>
</html>