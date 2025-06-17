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
    <title>Provas - Caminho do Saber</title>
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

        /* Filtros */
        .filters-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 25px;
            font-size: 1rem;
            font-weight: 600;
            background: var(--medium-gray);
            color: var(--black);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--box-shadow);
        }

        .filter-btn.active {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: var(--white);
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Container principal */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Barra de pesquisa */
        .search-container {
            width: 100%;
            margin: 30px auto;
            padding: 0 20px;
        }

        .input-container {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        input[type="text"] {
            width: 70%;
            padding: 12px 20px;
            font-size: 1rem;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            background-color: var(--white);
            transition: var(--transition);
            margin-right: 10px;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--gold-color);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        button[type="submit"] {
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--box-shadow);
        }

        button[type="submit"]:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
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

        /* Footer */
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

            .input-container {
                width: 80%;
            }
        }

        @media screen and (max-width: 768px) {
            .input-container {
                flex-direction: column;
                width: 90%;
            }

            input[type="text"] {
                width: 100%;
                margin-right: 0;
                margin-bottom: 10px;
            }

            button[type="submit"] {
                width: 100%;
            }

            .year-title, .prova-item {
                margin-left: 15px;
                margin-right: 15px;
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

            .filter-btn {
                padding: 8px 15px;
                font-size: 0.9rem;
            }

            .year-title {
                font-size: 1rem;
                padding: 10px 15px;
            }

            .prova-item {
                padding: 12px 15px;
            }

            .prova-link {
                font-size: 1rem;
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

<div class="main-container">
    <!-- Filtros -->
    <div class="filters-container">
        <button class="filter-btn active" onclick="filterProvas('all')">Todas</button>
        <button class="filter-btn" onclick="filterProvas('ENEM')">ENEM</button>
        <button class="filter-btn" onclick="filterProvas('SARESP')">SARESP</button>
    </div>

    <!-- Barra de pesquisa -->
    <div class="search-container">
        <form method="GET">
            <div class="input-container">
                <input type="text" id="nome" name="nome" placeholder="Pesquise por provas...">
                <button type="submit">Buscar</button>
            </div>
        </form>
    </div>

    <!-- Resultados da busca (PHP preservado) -->
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

    <!-- Lista completa de provas (PHP preservado) -->
    <div class="provas-list" id="provasList">
        <?php
        $host = 'localhost';
        $db = 'db_scholarsupport';
        $user = 'root';
        $pass = '';

        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $sql = "SELECT id, nome, anoProva FROM tb_prova ORDER BY anoProva DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $currentYear = null;
            
            while ($row = $result->fetch_assoc()) {
                $tipoProva = (strpos($row['nome'], 'ENEM') !== false) ? 'ENEM' : 'SARESP';
                
                if ($row['anoProva'] !== $currentYear) {
                    if ($currentYear !== null) {
                        echo "</div>"; // Fecha o grupo do ano anterior
                    }
                    $currentYear = $row['anoProva'];
                    echo "<div class='year-group' data-year='$currentYear'>";
                    echo "<div class='year-title'>$currentYear</div>";
                }
                
                echo "<div class='prova-item' data-type='$tipoProva'>";
                echo "<a href='mostraQuest.php?id=" . $row['id'] . "' class='prova-link'>" . $row['nome'] . "</a>";
                echo "</div>";
            }
            
            if ($currentYear !== null) {
                echo "</div>"; // Fecha o último grupo de ano
            }
        } else {
            echo "<p>Nenhuma prova disponível no momento.</p>";
        }

        $conn->close();
        ?>
    </div>
</div>

<footer>
    <p>&copy; 2025 Caminho do Saber. Todos os direitos reservados.</p>
    <a href="POLITICA.php">Política de privacidade</a>
</footer>

<script>
    function filterProvas(type) {
        // Atualiza botões ativos
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.textContent === type || (type === 'all' && btn.textContent === 'Todas')) {
                btn.classList.add('active');
            }
        });

        // Mostra/oculta provas
        document.querySelectorAll('.prova-item').forEach(item => {
            if (type === 'all') {
                item.style.display = 'block';
            } else {
                const itemType = item.getAttribute('data-type');
                item.style.display = itemType === type ? 'block' : 'none';
            }
        });

        // Ajusta a visibilidade dos grupos de ano
        document.querySelectorAll('.year-group').forEach(group => {
            const hasVisibleItems = Array.from(group.querySelectorAll('.prova-item'))
                .some(item => item.style.display !== 'none');
            
            group.style.display = hasVisibleItems ? 'block' : 'none';
        });

        // Ajusta o espaçamento do container principal
        adjustMainContainerSpacing();
    }

    function adjustMainContainerSpacing() {
        const provasList = document.getElementById('provasList');
        const visibleItems = provasList.querySelectorAll('.prova-item[style="display: block"], .prova-item:not([style])');
        
        if (visibleItems.length === 0) {
            provasList.style.marginBottom = '20px';
        } else {
            provasList.style.marginBottom = '';
        }
    }

    // Inicializa mostrando todas as provas
    document.addEventListener('DOMContentLoaded', function() {
        filterProvas('all');
    });

    
    // Detecta o parâmetro de filtro na URL e aplica automaticamente
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter');
        
        if (filter) {
            filterProvas(filter);
        } else {
            filterProvas('all');
        }
    });

</script>
</body>
</html>