<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROVAS</title>
    <style>
        :root {
            --primary-color: #0d4b9e;
            --primary-dark: #0a3a7a;
            --primary-light: #3a6cb5;
            --gold-color: #D4AF37;
            --gold-light: #E6C200;
            --gold-dark: #996515;
            --black: #212529;
            --dark-black: #121212;
            --white: #ffffff;
            --light-gray: #f5f7fa;
            --medium-gray: #e0e5ec;
            --dark-gray: #6c757d;
        }

        .ocultar {
            display: none;
        }

        body {
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--light-gray);
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-voltar {
            background: var(--primary-color);
            color: var(--white);
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-voltar:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-voltar:active {
            transform: translateY(1px);
        }

        h1 {
            text-align: center;
            color: var(--primary-dark);
            margin-bottom: 30px;
        }

        .questao {
            margin-bottom: 30px;
            border-bottom: 1px solid var(--medium-gray);
            padding-bottom: 20px;
        }

        .questao h2 {
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        img {
            display: block;
            margin: 10px auto;
            border-radius: 5px;
            max-width: 100%;
            height: auto;
        }

        label {
            display: block;
            margin: 10px 0;
            background: var(--light-gray);
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        label:hover {
            background: var(--medium-gray);
        }

        input[type="radio"] {
            margin-right: 10px;
            accent-color: var(--primary-color);
        }

        button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: var(--gold-color);
            color: var(--black);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: var(--gold-light);
        }
    </style>
</head>
<body>

<div class="container">
    <a href="exibirProvas.php" class="btn-voltar">
        <span>←</span> Voltar
    </a>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_scholarsupport";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $idProva = $_GET['id'];

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Query para obter o nome da prova
    $sqlNome = "SELECT nome FROM tb_prova WHERE id = $idProva";
    $resultNome = $conn->query($sqlNome);

    if ($resultNome->num_rows > 0) {
        $rowNome = $resultNome->fetch_assoc();
        echo "<h1>" . htmlspecialchars($rowNome['nome']) . "</h1>";
    } else {
        echo "<h1>Prova não encontrada</h1>";
    }

    // Query para obter as questões baseadas no número da questão (numQuestao)
    $sql = "SELECT * FROM tb_quest WHERE prova = $idProva ORDER BY numQuestao";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibe todas as questões
        while ($row = $result->fetch_assoc()) {
            echo "<div class='questao'>";
            echo "<h2>Questão " . htmlspecialchars($row['numQuestao']) . "</h2>";
            echo "<img src='data:" . htmlspecialchars($row['tipo']) . ";base64," . base64_encode($row['foto']) . "' alt='Imagem' width='300' />";
            echo "<p>" . htmlspecialchars($row['quest']) . "</p>";

            $alternativas = ['A' => $row['alt_a'], 'B' => $row['alt_b'], 'C' => $row['alt_c'], 'D' => $row['alt_d'], 'E' => $row['alt_e']];
            foreach ($alternativas as $letra => $alternativa) {
                $correta = ($row['alt_corre'] == $letra) ? 'correta' : strtolower($letra);
                echo "<label><input type='radio' name='quest" . $row['numQuestao'] . "' value='$correta' required>" . htmlspecialchars($alternativa) . "</label>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>Nenhum resultado encontrado.</p>";
    }

    ?>
</div>
<button onclick='corrigir()'>Enviar Respostas</button>

<script>
    function corrigir() {
        let acertos = 0;
        let erros = 0;

        // Coleta todas as questões
        const questoes = document.querySelectorAll('.questao');

        questoes.forEach(questao => {
            const questaoNum = questao.querySelector('h2').innerText.split(' ')[1]; // Obtém o número da questão
            const respostaSelecionada = questao.querySelector(`input[name="quest${questaoNum}"]:checked`);
            const respostaCorreta = questao.querySelector(`input[name="quest${questaoNum}"][value="correta"]`);

            if (respostaSelecionada) {
                if (respostaSelecionada.value === 'correta') {
                    acertos++;
                } else {
                    erros++;
                }
            } else {
                erros++; // Considera como erro se não houver seleção
            }
        });
        const urlParams = new URLSearchParams(window.location.search);
        const prova = urlParams.get('id');
        // Redireciona para a página de resultados
        window.location.href = `tentativas.php?acertos=${acertos}&erros=${erros}&prova=${prova}`;
    }
</script>

</body>
</html>