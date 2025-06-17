<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Questões</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group input[type="file"] {
            padding: 0;
        }
        .form-group .alternativas {
            display: flex;
            flex-direction: column;
        }
        .form-group .alternativas input {
            margin-bottom: 5px;
        }
        .form-group .alternativas label {
            margin-bottom: 0;
        }
        .form-group button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #218838;
        }
        @media (max-width: 600px) {
            .form-group {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<form action="CADASTRAR_IAMGEM_E_QUESTAO.php" method="post" enctype="multipart/form-data">
  
    <!-- Os outros campos do formulário -->
    <div class="form-group">
        <label for="foto">Foto do Enunciado</label>
        <input type="file" id="foto" name="foto" accept="image/*">
    </div>
    <div class="form-group">
        <label for="pergunta">Pergunta da Questão</label>
        <textarea id="pergunta" name="pergunta" rows="4" required></textarea>
    </div>
    <div class="form-group alternativas">
        <label>Alternativas</label>
        <label for="alternativaA">Alternativa A</label>
        <input type="text" id="alternativaA" name="alternativaA" required>
        <label for="alternativaB">Alternativa B</label>
        <input type="text" id="alternativaB" name="alternativaB" required>
        <label for="alternativaC">Alternativa C</label>
        <input type="text" id="alternativaC" name="alternativaC">
        <label for="alternativaD">Alternativa D</label>
        <input type="text" id="alternativaD" name="alternativaD">
        <label for="alternativaE">Alternativa E</label>
        <input type="text" id="alternativaE" name="alternativaE">
    </div>
    <div class="form-group">
        <label for="correta">Alternativa Correta</label>
        <select id="correta" name="correta" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
        </select>
    </div>
	
	<?php
		$host = 'localhost';
		$db = 'db_scholarsupport';
		$user = 'root';
		$pass = '';

		// Cria a conexão
		$conn = new mysqli($host, $user, $pass, $db);

		// Checa a conexão
		if ($conn->connect_error) {
			die("Conexão falhou: " . $conn->connect_error);
		}

		// Prepara a consulta SQL
		$sql = "SELECT id, nome FROM tb_prova";
		$result = $conn->query($sql);

		// Verifica se há resultados
		if ($result->num_rows > 0) {
			echo "<label for='prova'>Prova: </label>
					<select id='prova' name='prova'>";
			// Exibe cada linha como um link
			while ($row = $result->fetch_assoc()) {
				echo "	<option value='".$row['id']."'>".$row['nome']."</option>";			
			}
			echo "</select>";
			echo "</ul>";
		} else {
			echo "Nenhum resultado encontrado.";
		}

		$conn->close();
		?>
	
    <div class="form-group">
        <button type="submit">Cadastrar Questão</button>
    </div>
</form>
