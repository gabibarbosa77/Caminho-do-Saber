<?php
session_start();

$host = 'localhost';
$db = 'db_scholarsupport';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioLogin = trim($_POST['usuarioLogin']);
    $loginSenha = $_POST['loginSenha'];

    $stmt = $conn->prepare("SELECT senha, id FROM tb_usuario WHERE nomeUsuario = ?");
    $stmt->bind_param("s", $usuarioLogin);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $senha_hash = $row["senha"];
        $id = $row["id"];

        // Verifica se a senha corresponde ao hash armazenado
        if (password_verify($loginSenha, $senha_hash)) {
            $_SESSION['nomeUsuario'] = $usuarioLogin;
            $_SESSION['id'] = $id;

            echo "<script>window.location.href = 'home.php';</script>";    
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }

    $stmt->close();
}

$conn->close();
?>