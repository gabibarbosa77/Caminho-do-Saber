<?php
session_start();

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "db_scholarsupport";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$id = $_SESSION["id"];
$nomeCompleto = trim($_POST["nomeCompleto"]);
$email = $_POST["email"];
$nomeUsuario = trim($_POST["nomeUsuario"]);
$novaSenha = $_POST["novaSenha"]; // Novo campo
$telefone = $_POST["telefone"];
$datNasc = $_POST["datNasc"];
$metaProvas = $_POST["metaProvas"];

// Prepara a declaração SQL
$sql = "UPDATE tb_usuario SET nomeCompleto=?, email=?, nomeUsuario=?, telefone=?, datNasc=?, metaProvas=?";

// Se uma nova senha foi fornecida, atualiza o hash
if (!empty($novaSenha)) {
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $sql .= ", senha=?";
}

$sql .= " WHERE id=?";

$stmt = $conn->prepare($sql);

if (!empty($novaSenha)) {
    $stmt->bind_param("sssssssi", $nomeCompleto, $email, $nomeUsuario, $telefone, $datNasc, $metaProvas, $senhaHash, $id);
} else {
    $stmt->bind_param("ssssssi", $nomeCompleto, $email, $nomeUsuario, $telefone, $datNasc, $metaProvas, $id);
}

if ($stmt->execute()) {
    echo "<script>window.location.href = 'perfil.php';</script>";
} else {
    echo "Erro ao atualizar registro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>