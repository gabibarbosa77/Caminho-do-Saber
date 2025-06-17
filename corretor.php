<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

$idUsuario = $_SESSION['id'];
$conn = new mysqli("localhost", "root", "", "db_scholarsupport");

// Processar exclusão se houver requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $idExcluir = (int)$_POST['excluir_id'];
    $stmt = $conn->prepare("DELETE FROM tb_redacao WHERE id = ? AND idUsuario = ?");
    $stmt->bind_param("ii", $idExcluir, $idUsuario);
    $stmt->execute();
    // Recarrega a página para atualizar a lista
    echo "<script>window.location.href = 'corretor.php';</script>";
    exit();
}

// Buscar redações do usuário
$sql = "SELECT * FROM tb_redacao WHERE idUsuario = ? ORDER BY dataRedacao DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redação ENEM | Caminho do Saber</title>
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

        /* Header */
        header {
            width: 100%;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-color), var(--dark-black));
            padding: 20px;
            border-bottom: 3px solid var(--gold-color);
            box-shadow: var(--box-shadow);
        }

        .header-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            height: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo img {
            height: 70px;
            transition: var(--transition);
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .site-title {
            font-size: 2rem;
            color: var(--white);
            font-weight: 600;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        /* Navegação */
        nav {
            background-color: var(--primary-dark);
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-list {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .nav-link {
            color: var(--white);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover {
            background-color: var(--gold-color);
            color: var(--dark-black);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--gold-color);
            transition: var(--transition);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Conteúdo Principal */
        .main {
            padding: 2rem 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Aviso Importante */
        .alert-box {
            background-color: var(--white);
            border-left: 4px solid var(--gold-dark);
            padding: 20px;
            margin: 30px 0;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .alert-title {
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-icon {
            color: var(--gold-dark);
        }

        /* Formulário de Redação */
        .form-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin-top: 20px;
        }

        @media (min-width: 992px) {
            .form-layout {
                grid-template-columns: 2fr 1fr;
            }
        }

        .form-section, .criteria-section {
            background-color: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .criteria-section {
            border-top: 4px solid var(--primary-color);
        }

        .section-title {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .section-subtitle {
            color: var(--primary-dark);
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-textarea {
            min-height: 300px;
            resize: vertical;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--gold-color);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        .char-counter {
            font-size: 0.9rem;
            color: var(--dark-gray);
            text-align: right;
            margin-bottom: 20px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--box-shadow);
        }

        .submit-btn:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
        }

        /* Lista de Critérios */
        .criteria-list {
            list-style: none;
            margin-bottom: 20px;
        }

        .criteria-item {
            margin-bottom: 15px;
            padding-left: 25px;
            position: relative;
            line-height: 1.5;
        }

        .criteria-item::before {
            content: '•';
            color: var(--gold-color);
            font-size: 1.5rem;
            position: absolute;
            left: 0;
            top: -5px;
        }

        .note {
            color: var(--gold-dark);
            font-size: 0.9rem;
            line-height: 1.6;
            padding: 15px;
            background-color: rgba(212, 175, 55, 0.1);
            border-radius: var(--border-radius);
            border-left: 3px solid var(--gold-dark);
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

        .footer-text {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .footer-link {
            color: var(--gold-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .footer-link:hover {
            color: var(--gold-light);
            text-decoration: underline;
        }

        /* Seção de Redações - NOVOS ESTILOS */
        .redacoes-section {
            margin: 40px 0;
            padding: 0 30px;
        }

        .titulo-redacoes {
            color: var(--primary-dark);
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
            padding-left: 15px;
        }

        .titulo-redacoes i {
            margin-right: 12px;
            color: var(--gold-color);
        }

        .titulo-redacoes::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 15px;
            width: 120px;
            height: 3px;
            background: linear-gradient(to right, var(--gold-color), var(--primary-color));
            border-radius: 3px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-left: 10px;
        }

        .card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            cursor: pointer;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-left-color: var(--gold-color);
        }

        .card h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .card-info {
            display: flex;
            justify-content: space-between;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .nota-badge {
            background-color: var(--primary-light);
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: var(--white);
            width: 90%;
            max-width: 700px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 25px;
            border-radius: var(--border-radius);
            position: relative;
            box-shadow: var(--box-shadow);
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            color: var(--dark-gray);
            cursor: pointer;
            transition: var(--transition);
        }

        .close-btn:hover {
            color: var(--primary-dark);
        }

        .redacao-text {
            white-space: pre-wrap;
            background-color: var(--light-gray);
            padding: 15px;
            border-radius: var(--border-radius);
            margin: 15px 0;
            line-height: 1.8;
        }

        .comentarios-list {
            list-style: none;
            margin-top: 15px;
        }

        .comentario-item {
            margin-bottom: 15px;
            padding: 15px;
            background-color: rgba(212, 175, 55, 0.05);
            border-left: 3px solid var(--gold-color);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .comentario-titulo {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            header {
                height: auto;
                padding: 15px;
            }
            
            .header-container {
                flex-direction: column;
                gap: 10px;
            }
            
            .logo img {
                height: 60px;
            }
            
            .site-title {
                font-size: 1.5rem;
            }
            
            .nav-list {
                flex-wrap: wrap;
                gap: 15px;
            }
            
            .form-section, .criteria-section {
                padding: 20px;
            }

            .redacoes-section {
                padding: 0 15px;
            }

            .card-container {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .site-title {
                font-size: 1.3rem;
            }
            
            .nav-link {
                padding: 6px 10px;
                font-size: 0.9rem;
            }
            
            .section-title {
                font-size: 1.3rem;
            }
            
            .form-textarea {
                min-height: 250px;
            }

            .titulo-redacoes {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="imagem/logonova.png" alt="Logo Caminho do Saber">
            </div>
            <h1 class="site-title">CAMINHO DO SABER</h1>
        </div>
    </header>

    <nav>
        <div class="nav-container">
            <ul class="nav-list">
                <li><a href="home.php" class="nav-link">Home</a></li>
                <li><a href="exibirProvas.php" class="nav-link">Provas</a></li>
                <li><a href="corretor.php" class="nav-link">Corretor</a></li>
                <li><a href="progresso.php" class="nav-link">Progresso</a></li>
                <li><a href="perfil.php" class="nav-link">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <main class="main">
        <div class="container">
            <div class="alert-box">
                <h2 class="alert-title">
                    <i class="fas fa-exclamation-triangle alert-icon"></i>
                    AVISO IMPORTANTE
                </h2>
                <p>O corretor automático avalia sua redação com base nos critérios oficiais do ENEM, fornecendo uma estimativa de pontuação. Esta avaliação é realizada por inteligência artificial e não substitui a análise detalhada de um professor qualificado. Para melhores resultados, siga rigorosamente as diretrizes da prova oficial.</p>
            </div>

            <form action="redacao.php" method="POST">
                <div class="form-layout">
                    <div class="form-section">
                        <h2 class="section-title">Insira seu TEMA e sua REDAÇÃO</h2>
                        <input type="text" name="temaRedacao" id="temaRedacao" class="form-input" placeholder="Digite o tema da redação..." required>
                        <textarea name="redacao" id="redacao" class="form-textarea" placeholder="Digite sua redação aqui..." oninput="contarCaracteres()"></textarea>
                        <p id="contador" class="char-counter">Caracteres: 0</p>
                        <button type="submit" class="submit-btn">Enviar Redação</button>
                    </div>

                    <div class="criteria-section">
                        <h3 class="section-subtitle">Critérios para nota 1000 no ENEM</h3>
                        <p>(Cada critério vale 200 pontos):</p>
                        <ul class="criteria-list">
                            <li class="criteria-item"><strong>Domínio da norma culta:</strong> Gramática e ortografia corretas.</li>
                            <li class="criteria-item"><strong>Compreensão do tema:</strong> Abordar exatamente o que é pedido.</li>
                            <li class="criteria-item"><strong>Coesão textual:</strong> Uso adequado de conectivos e estrutura bem organizada.</li>
                            <li class="criteria-item"><strong>Argumentação:</strong> Apresentar ideias consistentes e bem desenvolvidas.</li>
                            <li class="criteria-item"><strong>Proposta de intervenção:</strong> Deve ser clara, viável e detalhada.</li>
                        </ul>
                        <p class="note"><strong>Observação:</strong> A redação ideal possui quatro parágrafos (um de introdução, dois de desenvolvimento e um de conclusão).</p>
                    </div>
                </div>
            </form>

            <!-- Seção de Redações -->
            <section class="redacoes-section">
                <h2 class="titulo-redacoes">
                    <i class="fas fa-book-open"></i>
                    Suas Redações
                </h2>
                
                <?php if ($result->num_rows === 0): ?>
                    <div class="card" style="text-align: center; padding: 30px;">
                        <i class="far fa-file-alt" style="font-size: 2rem; color: var(--dark-gray); margin-bottom: 15px;"></i>
                        <p style="color: var(--dark-gray);">Nenhuma redação encontrada. Comece escrevendo sua primeira redação!</p>
                    </div>
                <?php else: ?>
                    <div class="card-container">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php 
                            $erros = json_decode($row['errosRedacao'], true) ?? [];
                            $dataFormatada = date('d/m/Y H:i', strtotime($row['dataRedacao']));
                            $notaFormatada = number_format($row['notaRedacao'], 1, ',', '.');
                            ?>
                            
                            <div class="card" onclick="openModal(<?php echo $row['id']; ?>)">
                                <h3><?php echo htmlspecialchars($row['temaRedacao']); ?></h3>
                                <div class="card-info">
                                    <span><i class="far fa-calendar-alt"></i> <?php echo $dataFormatada; ?></span>
                                    <span class="nota-badge">Nota: <?php echo $notaFormatada; ?></span>
                                </div>
                            </div>
                            
                            <!-- Modal para esta redação -->
                            <div class="modal" id="modal-<?php echo $row['id']; ?>">
                                <div class="modal-content">
                                    <span class="close-btn" onclick="closeModal(<?php echo $row['id']; ?>)">&times;</span>
                                    <h2><?php echo htmlspecialchars($row['temaRedacao']); ?></h2>
                                    <p><strong>Nota:</strong> <?php echo $notaFormatada; ?> | 
                                       <strong>Data:</strong> <?php echo $dataFormatada; ?></p>
                                    
                                    <h3>Sua Redação:</h3>
                                    <div class="redacao-text"><?php echo nl2br(htmlspecialchars($row['redacao'])); ?></div>
                                    
                                    <?php if (!empty($erros)): ?>
                                        <h3>Comentários do Corretor:</h3>
                                        <ul class="comentarios-list">
                                            <?php foreach ($erros as $competencia => $comentario): ?>
                                                <li class="comentario-item">
                                                    <div class="comentario-titulo">
                                                        <?php echo ucfirst(str_replace('_', ' ', $competencia)); ?>
                                                    </div>
                                                    <p><?php echo htmlspecialchars($comentario); ?></p>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    
                                    <div class="action-buttons">
                                        <button class="btn btn-primary" onclick="window.print()">
                                            <i class="fas fa-print"></i> Imprimir
                                        </button>
                                        <form method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta redação?');">
                                            <input type="hidden" name="excluir_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <footer>
        <p class="footer-text">&copy; 2025 Caminho do Saber. Todos os direitos reservados.</p>
        <a href="POLITICA.php" class="footer-link">Política de privacidade</a>
    </footer>

    <script>
        function contarCaracteres() {
            const texto = document.getElementById("redacao").value;
            document.getElementById("contador").textContent = "Caracteres: " + texto.length;
        }

        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
    </script>
</body>
</html>