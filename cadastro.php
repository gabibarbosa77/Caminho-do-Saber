<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conecta = mysqli_connect("localhost", "root", "", "db_scholarsupport");

if ($conecta == false) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$nomeCompleto = trim($_POST["nomeCompleto"]);
$nomeUsuario = trim($_POST["nomeUsuario"]);
$email = $_POST["email"];
$senha = $_POST["senha"];
$telefone = $_POST["telefone"];
$datNasc = $_POST["datNasc"];

// Verifica se o nome de usuário já existe
$sql2 = "SELECT nomeUsuario FROM tb_usuario WHERE nomeUsuario = ?";
$stmt = mysqli_prepare($conecta, $sql2);
mysqli_stmt_bind_param($stmt, 's', $nomeUsuario);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "Não é possível cadastrar, pois o nome de usuário já existe!";
} else {
    // Cria o hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO tb_usuario (nomeCompleto, email, nomeUsuario, senha, telefone, datNasc) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsert = mysqli_prepare($conecta, $sql);
    mysqli_stmt_bind_param($stmtInsert, 'ssssss', $nomeCompleto, $email, $nomeUsuario, $senhaHash, $telefone, $datNasc);
    
    if (mysqli_stmt_execute($stmtInsert)) {
        echo "Cadastrado com sucesso, nome de usuário válido!";
        echo "<script>window.location.href = 'home.php';</script>";
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conecta);
    }
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($stmtInsert);
mysqli_close($conecta);
?>