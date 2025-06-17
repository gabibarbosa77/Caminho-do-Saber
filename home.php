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
    <title>home</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

        /* Novas regras para o rodapé fixo */
        html, body {
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background-color: var(--light-gray);
            color: var(--black);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding-bottom: 20px;
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

        /* Search Bar */
        form {
            width: 100%;
            margin: 50px auto;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .input-container {
            display: flex;
            align-items: center;
            width: 50%;
            max-width: 600px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 20px;
            font-size: 1rem;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            background-color: var(--white);
            transition: var(--transition);
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--gold-color);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        button {
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            margin-left: 10px;
            box-shadow: var(--box-shadow);
        }

        button:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
        }

        /* Cards */
        .cards-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
            margin: 40px auto;
            padding: 0 20px;
            max-width: 1200px;
        }

        .card, .card3 {
            width: 100%;
            max-width: 480px;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: var(--border-radius);
            border: 2px solid var(--gold-color);
            background-color: var(--white);
            padding: 2rem;
            color: var(--black);
            text-align: left;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .card:hover, .card3:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .card3 {
            max-width: 800px;
            margin: 30px auto;
        }

        .header {
            display: flex;
            flex-direction: column;
            margin-bottom: 1.5rem;
        }

        .title2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--gold-dark);
            margin: 10px 0;
        }

        .desc {
            margin: 1rem 0;
            color: var(--dark-gray);
            font-size: 1rem;
            line-height: 1.6;
        }

        .action {
            border: none;
            border-radius: var(--border-radius);
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            padding: 12px 25px;
            text-align: center;
            font-weight: 600;
            color: var(--white);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            width: fit-content;
            box-shadow: var(--box-shadow);
        }

        .action:hover {
            background: linear-gradient(to right, var(--gold-dark), var(--gold-color));
            transform: translateY(-2px);
        }

        /* Search Results */
        .search-results {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .search-results h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            text-align: center;
        }

        .search-results ul {
            list-style: none;
        }

        .search-results li {
            margin-bottom: 15px;
            padding: 15px;
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .search-results li:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .link {
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--primary-color);
            transition: var(--transition);
            display: block;
        }

        .link:hover {
            color: var(--gold-dark);
            transform: translateX(5px);
        }

        /* Lista de provas */
        .provas-list {
            margin: 40px 0;
        }

        .year-group {
            margin-bottom: 30px;
        }

        .year-title {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: var(--white);
            padding: 12px 20px;
            border-radius: var(--border-radius);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            box-shadow: var(--box-shadow);
        }

        .prova-item {
            background-color: var(--white);
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            border-left: 4px solid var(--gold-color);
        }

        .prova-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .prova-link {
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--primary-color);
            transition: var(--transition);
            display: block;
        }

        .prova-link:hover {
            color: var(--gold-dark);
        }

        /* Resultados da busca */
        .search-results {
            margin: 30px 0;
        }

        .search-results h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.8rem;
        }

         footer {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-black));
            color: var(--white);
            text-align: center;
            padding: 20px 0;
            width: 100%;
            border-top: 3px solid var(--gold-color);
            position: relative;
            bottom: 0;
            margin-top: auto;
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

        /* Responsive Design */
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

            .input-container {
                width: 80%;
                flex-direction: column;
            }

            button {
                width: 80%;
                margin: 10px 0 0 0;
            }

            .card, .card3 {
                width: 90%;
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

            nav ul {
                gap: 10px;
            }

            nav ul li a {
                padding: 6px 10px;
                font-size: 0.9rem;
            }

            .input-container {
                width: 90%;
            }

            .card, .card3 {
                padding: 1.5rem;
            }

            .price {
                font-size: 2rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</head>
<body>
    <header class="animate-in">
        <div class="container">
            <div class="logo">
                <img src="imagem/logonova.png" alt="Logo">
            </div>
            <h1 class="title">CAMINHO DO SABER</h1>
        </div>
    </header>
    
    <nav class="animate-in delay-1">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="exibirProvas.php">Provas</a></li>
            <li><a href="corretor.php">Corretor</a></li>
            <li><a href="progresso.php">Progresso</a></li>
            <li><a href="perfil.php">Perfil</a></li>       
        </ul>
    </nav>

    <main>
        <!-- Barra de pesquisa -->
        <div class="search-container">
            <form method="GET">
                <div class="input-container">
                    <input type="text" id="nome" name="nome" placeholder="Pesquise por provas...">
                    <button type="submit">Buscar</button>
                </div>
            </form>
        </div>

        <center>
       
        <?php if (isset($_GET['nome']) && !empty($_GET['nome'])): ?>
            <div class="search-results">
                <h2>Resultados encontrados:</h2>
                <ul>
                    <?php
                    $host = 'localhost'; 
                    $db = 'db_scholarsupport';
                    $user = 'root';
                    $pass = '';

                    $conn = new mysqli($host, $user, $pass, $db);

                    if ($conn->connect_error) {
                        die("Erro na conexão: " . $conn->connect_error);
                    }

                    $nome = $_GET['nome'];
                    $sql = "SELECT * FROM tb_prova WHERE nome LIKE ?";
                    $stmt = $conn->prepare($sql);

                    if ($stmt === false) {
                        die("Erro ao preparar a consulta: " . $conn->error);
                    }

                    $nome_like = "%" . $nome . "%";
                    $stmt->bind_param("s", $nome_like);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tipoProva = (strpos($row['nome'], 'ENEM') !== false) ? 'ENEM' : 'SARESP';
                            echo "<li class='prova-item' data-type='$tipoProva'>";
                            echo "<a href='mostraQuest.php?id=" . $row['id'] . "' class='prova-link'>" . $row['nome'] . "</a>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li>Nenhum resultado encontrado.</li>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </ul>
            </div>
        <?php endif; ?>
        </center>

        <div class="cards-container">
            <div class="card animate-in delay-2">
                <div class="header">
                    <span class="title2">Provas</span>
                    <span class="price">ENEM</span>
                </div>
                <p class="desc">Cada questão resolvida é uma vitória! O ENEM não mede só conhecimento, mas também sua persistência - e você está mais perto do que imagina. 💡🏆</p>
                <a href="exibirProvas.php?filter=ENEM" class="action">Começar</a>
            </div>

            <div class="card animate-in delay-2">
                <div class="header">
                    <span class="title2">Provão</span>
                    <span class="price">PAULISTA</span>
                </div>
                <p class="desc">Caderno aberto, mente focada! O Provão não espera, e você não pode parar. Hoje é dia de virar o jogo: uma questão de cada vez! 💪</p>
                <a href="exibirProvas.php?filter=SARESP" class="action">Começar</a>
            </div>

            <div class="card card3 animate-in delay-2">
                <div class="header">
                    <span class="title2">Corretor de</span>
                    <span class="price">REDAÇÃO</span>
                </div>
                <p class="desc">Cada palavra que você escreve é um passo rumo à sua aprovação - deixe sua voz ecoar na folha em branco e transforme ideias em argumentos poderosos! ✍️📚</p>
                <a href="corretor.php" class="action">Escrever</a>
            </div>
        </div>
    </main> 

    <footer class="animate-in delay-2">
        <p>&copy; 2025 Caminho do Saber. Todos os direitos reservados.</p>
        <a href="POLITICA.php">Política de privacidade</a>
    </footer>
</body>
</html>