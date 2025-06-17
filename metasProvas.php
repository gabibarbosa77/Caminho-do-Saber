<?php
 
 // Verificando se está logado
session_start();
if (isset($_SESSION['id'])) {
    $id = $_SESSION["id"];
} else {
    header("Location: login.html");
}
 
 $host = 'localhost';
 $db = 'db_scholarsupport';
 $user = 'root';
 $pass = '';

 $conn = new mysqli($host, $user, $pass, $db);

 if ($conn->connect_error) {
     die("Conexão falhou: " . $conn->connect_error);
 } else {

    $stmt = $conn->prepare("SELECT * FROM tb_usuario WHERE idUsuario = $id");
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["id"];

?>