<?php
$serverName = 'localhost';
$nomeUsuario = 'root';
$senha = '';
$db = 'db_scholarsupport';

session_start();
if (isset($_SESSION['id'])) {
    $id = $_SESSION["id"];
} else {
    header("Location: login.html");
}

$mysqli = new mysqli($serverName, $nomeUsuario, $senha, $db);

if ($mysqli == false) {
    echo "erro de conexao";
    exit;
} else {
    $stmt = $mysqli->prepare("SELECT * FROM tb_usuario WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Caminho do Saber</title>
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
            --error-color: #dc3545;
            --success-color: #28a745;
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

        /* Card de perfil */
        .profile-card {
            width: 100%;
            max-width: 570px;
            background: var(--white);
            box-shadow: var(--box-shadow);
            margin: 40px auto;
            border-radius: var(--border-radius);
            padding: 30px;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--medium-gray);
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(to right, var(--primary-color), var(--gold-color));
        }

        .profile-title {
            font-family: 'Times New Roman', Times, serif;
            font-size: 2rem;
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }

        .profile-title::after {
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

        /* Formulário */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: var(--primary-color);
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-input {
            display: block;
            width: 100%;
            height: 45px;
            background-color: var(--white);
            border-radius: var(--border-radius);
            border: 1px solid var(--medium-gray);
            padding: 0 15px;
            outline: none;
            color: var(--black);
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-input:focus {
            border-color: var(--gold-color);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--dark-gray);
            transition: var(--transition);
        }

        .toggle-password:hover {
            color: var(--gold-dark);
        }

        /* Botões */
        .buttons-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 40px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            min-width: 120px;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: var(--white);
            box-shadow: var(--box-shadow);
        }

        .btn-primary:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-danger {
            background: linear-gradient(to right, var(--error-color), #c82333);
            color: var(--white);
            box-shadow: var(--box-shadow);
        }

        .btn-danger:hover {
            background: linear-gradient(to right, #c82333, var(--error-color));
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(to right, var(--dark-gray), #5a6268);
            color: var(--white);
            box-shadow: var(--box-shadow);
        }

        .btn-secondary:hover {
            background: linear-gradient(to right, #5a6268, var(--dark-gray));
            transform: translateY(-2px);
        }

        /* Modal de confirmação */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            max-width: 500px;
            width: 90%;
            box-shadow: var(--box-shadow);
            text-align: center;
        }

        .modal-title {
            font-size: 1.5rem;
            color: var(--black);
            margin-bottom: 20px;
        }

        .modal-text {
            margin-bottom: 30px;
            color: var(--dark-gray);
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
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
        @media screen and (max-width: 768px) {
            .profile-card {
                margin: 30px 15px;
                padding: 20px;
            }

            .buttons-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            nav ul {
                flex-wrap: wrap;
                gap: 10px;
            }
        }

        @media screen and (max-width: 576px) {
            header {
                height: auto;
                padding: 15px;
            }

            .title {
                font-size: 1.5rem;
            }

            .profile-title {
                font-size: 1.5rem;
            }

            nav ul li a {
                padding: 6px 10px;
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

<div class="profile-card">
    <h1 class="profile-title">DADOS DO USUÁRIO</h1>
    <form method="POST" action="updatePerfil.php" id="profileForm">
        <div class="form-group">
            <label for="nomeCompleto" class="form-label">Nome completo:</label>
            <input type="text" id="nomeCompleto" name="nomeCompleto" class="form-input" required value="<?php echo htmlspecialchars($usuario['nomeCompleto']) ?>">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-input" required value="<?php echo htmlspecialchars($usuario['email']) ?>">
        </div>

        <div class="form-group">
            <label for="nomeUsuario" class="form-label">Nome de usuário:</label>
            <input type="text" id="nomeUsuario" name="nomeUsuario" class="form-input" required value="<?php echo htmlspecialchars($usuario['nomeUsuario']) ?>">
        </div>

        <div class="form-group">
            <label for="novaSenha" class="form-label">Nova Senha (deixe em branco para manter a atual):</label>
            <div class="password-container">
                <input type="password" id="novaSenha" name="novaSenha" class="form-input" placeholder="Digite uma nova senha">
                <span class="toggle-password" onclick="togglePassword()">
                    <i id="iconeOlho" class="fa-solid fa-eye"></i>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" class="form-input" oninput="mascTelefone(this)" required value="<?php echo htmlspecialchars($usuario['telefone']) ?>">
        </div>

        <div class="form-group">
            <label for="datNasc" class="form-label">Data de Nascimento:</label>
            <input type="text" id="datNasc" name="datNasc" class="form-input" oninput="aplicarMascara(this)" required value="<?php echo htmlspecialchars($usuario['datNasc']) ?>">
        </div>

        <div class="form-group">
            <label for="metaProvas" class="form-label">Meta de provas a serem concluídas:</label>
            <input type="number" id="metaProvas" name="metaProvas" min="0" class="form-input" required value="<?php echo htmlspecialchars($usuario['metaProvas']) ?>">
        </div>

        <div class="buttons-container">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="sair.php" class="btn btn-secondary">Sair</a>
            <button type="button" class="btn btn-danger" onclick="openDeleteModal()">Excluir Conta</button>
        </div>
    </form>
</div>

<!-- Modal de Confirmação para Excluir Conta -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h2 class="modal-title">Confirmar Exclusão</h2>
        <p class="modal-text">Tem certeza que deseja excluir sua conta permanentemente? Esta ação não pode ser desfeita.</p>
        <div class="modal-buttons">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
            <form method="POST" action="excluirConta.php" style="display: inline;">
                <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
            </form>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2025 Caminho do Saber. Todos os direitos reservados.</p>
    <a href="POLITICA.php">Política de privacidade</a>
</footer>

<script>
   function togglePassword() {
    const passwordField = document.getElementById("novaSenha");
    const icon = document.getElementById("iconeOlho");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

    function mascTelefone(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.substring(0, 11);

        if (value.length > 6) {
            value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
        } else if (value.length > 2) {
            value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
        } else {
            value = value.replace(/^(\d*)/, '($1');
        }

        input.value = value;
    }

    function aplicarMascara(input) {
        let valor = input.value.replace(/\D/g, '');

        if (valor.length > 10) {
            valor = valor.substring(0, 6);
        }

        if (valor.length <= 2) {
            valor = valor.replace(/(\d{2})/, '$1');
        } else if (valor.length <= 4) {
            valor = valor.replace(/(\d{2})(\d{2})/, '$1/$2');
        } else {
            valor = valor.replace(/(\d{2})(\d{2})(\d{4})/, '$1/$2/$3');
        }

        input.value = valor;
    }

    function openDeleteModal() {
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Fechar modal ao clicar fora
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            closeDeleteModal();
        }
    }
</script>

</body>
</html>