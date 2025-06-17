<?php

session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conecta = mysqli_connect("localhost", "root", "", "db_scholarsupport");

if ($conecta == false) {
    die("Erro de conexão: " . mysqli_connect_error());
}
else{
    
$acertos = $_GET["acertos"];
$erros = $_GET["erros"];
$idProva = $_GET["prova"];
$dataTentativa = date('d/m/Y');
$idUsuario = $_SESSION["id"];

    $sql = "INSERT INTO tb_tentativas (acertos, erros, idProva, dataTentativa, idUsuario) VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = mysqli_prepare($conecta, $sql);
    mysqli_stmt_bind_param($stmtInsert, 'sssss', $acertos, $erros, $idProva, $dataTentativa, $idUsuario);
    
    if (mysqli_stmt_execute($stmtInsert)) {
        echo "Cadastrado com sucesso, nome de usuário válido!";

         echo "<script>
                    window.location.href = 'progresso.php';
                </script>";

    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conecta);
    }
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($stmtInsert);
mysqli_close($conecta);
?>
