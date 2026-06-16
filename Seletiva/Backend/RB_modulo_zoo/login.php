<?php

require_once(__DIR__ . "/middleware.php");
$message = '';

if($_POST){
    $password = $_POST['password'] ?? '';

    if(!empty($password) && $password === "admin"){
        $login = json_encode([true], JSON_PRETTY_PRINT);
        file_put_contents(__DIR__ . "/login.json", $login);
        header("Location: ./animals.php");
        exit();
    }
    $message = "Senha de acesso inválida";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST">
        <label for="password">Senha:</label> <br>
        <input type="password" id="password" name="password"> <br>
    </form>

    <p><?= $message ?></p>
</body>
</html>