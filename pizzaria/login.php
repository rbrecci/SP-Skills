<?php

session_start();
include("connection.php");

if(isset($_SESSION["usuario"])){
    header("location: index.php");
    exit();
}

$mensagem_erro = "";

if($_POST){
    $nome_digitado = $_POST["nome"] ?? '';
    $senha_digitada = $_POST["senha"] ?? '';

    $sql = "SELECT * FROM usuarios WHERE nome = '$nome_digitado' AND senha = '$senha_digitada'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $dados_usuario = $result->fetch_assoc();
        $_SESSION['usuario'] = $dados_usuario;
        header("location: index.php");
        exit();
    } else { 
        $mensagem_erro = "Usuario ou senha inválidos."; 
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Pizzaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <h1>Sistema Pizzaria</h1>
        <form method="post">
            <div class="form-group">
                <label>Usuário:</label>
                <input type="text" name="nome" required>
            </div>
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="senha" required>
            </div>
            <button type="submit">Entrar</button>
            <?php if ($mensagem_erro): ?>
                <div class="erro"><?= $mensagem_erro ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
