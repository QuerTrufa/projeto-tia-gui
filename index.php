<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>German's Barber</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
    
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
            height: 100%;
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
    </style>
</head>
<body>
    <!-- Overlay com clareamento -->
    <div class="overlay"></div>

    <?php include 'header.html'; ?>

    <div class="container my-5">
        <h1 class="text-center">Bem-vindo à German's Barber</h1>
        <p class="text-center">Aqui, você encontra os melhores barbeiros e serviços para um atendimento de qualidade.</p>

        <div class="row justify-content-center"> <!-- Adiciona a classe 'justify-content-center' para centralizar a linha -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Agendar um Corte</h5>
                        <p class="card-text">Marque um horário com um dos nossos barbeiros qualificados.</p>
                        <a href="agendar.php" class="btn btn-primary">Agendar Agora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.html'; ?>

    <script src="bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!--
Imagem de fundo corrigida
Site funcionando
-->