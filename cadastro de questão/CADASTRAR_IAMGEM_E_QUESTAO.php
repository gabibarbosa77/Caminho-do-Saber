<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_scholarsupport";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pergunta = $_POST['pergunta'];
    $alt_a = $_POST['alternativaA'];
    $alt_b = $_POST['alternativaB'];
    $alt_c = $_POST['alternativaC'];
    $alt_d = $_POST['alternativaD'];
    $alt_e = $_POST['alternativaE'];
    $alt_corre = $_POST['correta'];
	$prova = $_POST['prova'];

    // Processa a imagem
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['foto']['tmp_name'];
		$tipo = $_FILES['foto']['type'];
        if (is_uploaded_file($image)) {
            $imageData = file_get_contents($image);
            if ($imageData === false) {
                die("Erro ao ler o conteúdo do arquivo.");
            }
        } else {
            die("O arquivo não foi enviado corretamente.");
        }
    } else {
        die("Nenhum arquivo enviado ou erro no upload: " . $_FILES['foto']['error']);
    }
    

    // Prepara a consulta para inserir os dados da questão
    $stmt = $conn->prepare("INSERT INTO tb_quest ( quest, alt_a, alt_b, alt_c, alt_d, alt_e, alt_corre, foto, tipo, prova) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    // Insere os dados
    $stmt->bind_param("ssssssssss", $pergunta, $alt_a, $alt_b, $alt_c, $alt_d, $alt_e, $alt_corre, $imageData, $tipo, $prova);

    // Executa e verifica se foi bem-sucedido
    if ($stmt->execute()) {
        echo "Questão cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar a questão: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
