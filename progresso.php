<?php
// Verificando se está logado
session_start();
if (isset($_SESSION['id'])) {
    $id = $_SESSION["id"];
} else {
    header("Location: login.html");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progresso - Caminho do Saber</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --gold-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background-color: var(--light-gray);
            color: var(--black);
        }

        header {
            width: 100%;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-color), var(--dark-black));
            padding: 20px;
            border-bottom: 3px solid var(--gold-color);
            box-shadow: var(--box-shadow);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .logo img {
            height: 70px;
            transition: var(--transition);
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .title {
            text-align: center;
            font-size: 2rem;
            color: var(--white);
            font-weight: 600;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        nav {
            background-color: var(--primary-dark);
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        nav ul li a {
            color: var(--white);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
        }

        nav ul li a:hover {
            background-color: var(--gold-color);
            color: var(--dark-black);
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--gold-color);
            transition: var(--transition);
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        /* Conteúdo principal */
        .main-content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Card de progresso */
        .progress-card {
            width: 100%;
            max-width: 400px;
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            margin: 0 auto 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .progress-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(to right, var(--primary-color), var(--gold-color));
        }

        .progress-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .progress-stats {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 15px 0;
        }

        .progress-message {
            font-size: 1rem;
            color: var(--dark-gray);
            margin: 15px 0;
            min-height: 40px;
        }

        /* Barra de progresso */
        .progress-bar-container {
            width: 100%;
            height: 20px;
            background-color: var(--medium-gray);
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, var(--primary-color), var(--primary-light));
            border-radius: 10px;
            transition: width 0.5s ease-in-out;
            position: relative;
        }

        .progress-bar::after {
            content: attr(data-progress);
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--white);
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Histórico de provas */
        .history-container {
            margin-top: 50px;
        }

        .history-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .history-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--gold-color);
            border-radius: 3px;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            border-radius: var(--border-radius);
        }

        .history-table th, 
        .history-table td {
            padding: 15px 20px;
            text-align: center;
            border: 1px solid var(--medium-gray);
        }

        .history-table th {
            background-color: var(--primary-color);
            color: var(--white);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .history-table tr:nth-child(even) {
            background-color: var(--light-gray);
        }

        .history-table tr:hover {
            background-color: rgba(13, 75, 158, 0.05);
        }

         footer {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-black));
            color: var(--white);
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
            border-top: 3px solid var(--gold-color);
        }

        footer p {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        footer a {
            color: var(--gold-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        footer a:hover {
            color: var(--gold-light);
            text-decoration: underline;
        }

        /* Responsividade */
        @media screen and (max-width: 992px) {
            .container {
                flex-direction: column;
                text-align: center;
            }

            .logo img {
                height: 60px;
                margin-bottom: 10px;
            }

            .title {
                font-size: 1.5rem;
            }

            nav ul {
                flex-wrap: wrap;
                gap: 15px;
            }
        }

        @media screen and (max-width: 768px) {
            .history-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .progress-card {
                padding: 20px;
            }
        }

        @media screen and (max-width: 576px) {
            header {
                height: auto;
                padding: 15px;
            }

            .title {
                font-size: 1.3rem;
            }

            nav ul li a {
                padding: 6px 10px;
                font-size: 0.9rem;
            }

            .progress-title {
                font-size: 1.3rem;
            }

            .progress-stats {
                font-size: 1.5rem;
            }

            .history-table th, 
            .history-table td {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <div class="logo">
            <img src="imagem/logonova.png" alt="Logo">
        </div>
        <h1 class="title">CAMINHO DO SABER</h1>
    </div>
</header>

<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="exibirProvas.php">Provas</a></li>
        <li><a href="corretor.php">Corretor</a></li>
        <li><a href="progresso.php">Progresso</a></li>
        <li><a href="perfil.php">Perfil</a></li>
    </ul>
</nav>

<div class="main-content">
    <!-- Card de Progresso -->
    <div class="progress-card">
        <h2 class="progress-title">Seu Progresso</h2>
        <?php
        $host = 'localhost';
        $db = 'db_scholarsupport';
        $user = 'root';
        $pass = '';

        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT * FROM tb_tentativas WHERE idUsuario = $id");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $num_linhas = $result->num_rows;
                
                $stmt = $conn->prepare("SELECT metaProvas FROM tb_usuario WHERE id = $id");
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $dados = mysqli_fetch_assoc($result);

                    if($dados["metaProvas"] == 0){
                        echo "<div class='progress-stats'>0 / 0</div>";
                        $porc = 0;
                        echo "
                        <div class='progress-bar-container'>
                            <div class='progress-bar' style='width: ".$porc."%;' data-progress='".$porc."%'></div>
                        </div>
                        <div class='progress-message'>Defina uma meta de provas no seu perfil!</div>";
                    } else {
                        echo "<div class='progress-stats'>".$num_linhas." / ".$dados["metaProvas"]."</div>";
                        $porc = ($num_linhas/$dados["metaProvas"])*100;
                        $porc = min($porc, 100); // Limita a 100%
                        echo "
                        <div class='progress-bar-container'>
                            <div class='progress-bar' style='width: ".$porc."%;' data-progress='".round($porc)."%'></div>
                        </div>";

                        if($num_linhas >= $dados["metaProvas"]){
                            echo "<div class='progress-message' style='color: var(--success-color);'>Meta concluída com sucesso! 🎉</div>";
                        } else {
                            $diferenca = $dados["metaProvas"] - $num_linhas;
                            if($diferenca == 1){
                                echo "<div class='progress-message'>Falta <strong>".$diferenca."</strong> prova para concluir sua meta!</div>";
                            } elseif($diferenca > 1) {
                                echo "<div class='progress-message'>Faltam <strong>".$diferenca."</strong> provas para concluir sua meta!</div>"; 
                            }
                        }
                    }
                }
            } else {
                $stmt = $conn->prepare("SELECT metaProvas FROM tb_usuario WHERE id = $id");
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $dados = mysqli_fetch_assoc($result);
                    echo "<div class='progress-stats'>0 / ".$dados["metaProvas"]."</div>";
                    $porc = 0;
                    echo "
                    <div class='progress-bar-container'>
                        <div class='progress-bar' style='width: ".$porc."%;' data-progress='".$porc."%'></div>
                    </div>";
                    if($dados["metaProvas"] == 1){
                        echo "<div class='progress-message'>Falta <strong>".$dados["metaProvas"]."</strong> prova para concluir sua meta!</div>";
                    } else {
                        echo "<div class='progress-message'>Faltam <strong>".$dados["metaProvas"]."</strong> provas para concluir sua meta!</div>"; 
                    }
                }
            }
        }
        ?>
    </div>

    <!-- Histórico de Provas -->
    <div class="history-container">
        <h2 class="history-title">Histórico de Provas</h2>
        
        <table class="history-table">
            <thead>
                <tr>
                    <th>Prova</th>
                    <th>Acertos</th>
                    <th>Erros</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $host = 'localhost';
                $db = 'db_scholarsupport';
                $user = 'root';
                $pass = '';

                $conn = new mysqli($host, $user, $pass, $db);

                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                } else {
                    $sql = "SELECT tb_tentativas.acertos, tb_tentativas.erros, tb_tentativas.dataTentativa, tb_prova.nome, tb_prova.id FROM tb_tentativas INNER JOIN tb_prova ON tb_tentativas.idProva = tb_prova.id WHERE tb_tentativas.idUsuario = $id";
                    $consulta = mysqli_query($conn, $sql);

                    if ($consulta == false) {
                        echo "<tr><td colspan='4'>Erro ao carregar histórico</td></tr>";
                    } else {
                        if (mysqli_num_rows($consulta) > 0) {
                            while ($dados = mysqli_fetch_assoc($consulta)) {
                                echo "<tr>";
                                echo "<td><a href='mostraQuest.php?id=" . $dados['id'] . "' class='prova-link'>" . htmlspecialchars($dados['nome']) . "</a></td>";
                                echo "<td>" . htmlspecialchars($dados['acertos']) . "</td>";
                                echo "<td>" . htmlspecialchars($dados['erros']) . "</td>";
                                echo "<td>" . htmlspecialchars($dados['dataTentativa']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Nenhuma prova realizada ainda</td></tr>";
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <p>&copy; 2025 Caminho do Saber. Todos os direitos reservados.</p>
    <a href="POLITICA.php">Política de privacidade</a>
</footer>

</body>
</html>