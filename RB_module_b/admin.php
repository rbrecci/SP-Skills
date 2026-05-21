<?php

// include no middleware
include(__DIR__ . "/middleware.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bem vindo admin! <span>Tempo restante de login: <?= $tempoRestante ?></span></h1>
    <a href="products.php">Ver Produtos</a>
    <a href="companies.php">Ver Empresas</a>
    <a href="logout.php">Deslogar</a>
</body>
</html>