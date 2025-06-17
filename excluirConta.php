<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit();
}

$serverName = 'localhost';
$nomeUsuario = 'root';
$senha = '';
$db = 'db_scholarsupport';

$mysqli = new mysqli($serverName, $nomeUsuario, $senha, $db);

if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

$id = $_SESSION['id'];
$stmt = $mysqli->prepare("DELETE FROM tb_usuario WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Limpa todos os dados da sessão
    $_SESSION = array();
 
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    
    header("Location: login.html?conta_excluida=1");
    exit();
} else {

    header("Location: perfil.php?erro_exclusao=1");
    exit();
}

$stmt->close();
$mysqli->close();
?>