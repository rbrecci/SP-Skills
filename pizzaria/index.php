<?php

session_start();
include("connection.php");

if(!isset($_SESSION['usuario'])){
    header("location: login.php");
}

include("funcoes_estoque.php");

$alerta_estoque = gerarAlertaEstoque($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Pizzaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Sistema Pizzaria</h1>
        
        <div class="welcome">
            Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>!
        </div>

        <?php if ($alerta_estoque): ?>
            <div class="alert">
                <h3>Estoque Baixo!</h3>
                <ul>
                    <?php foreach ($alerta_estoque['pizzas'] as $pizza): ?>
                        <li><?= htmlspecialchars($pizza['nome']) ?> - <?= $pizza['estoque_atual'] ?>/<?= $pizza['estoque_minimo'] ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><a href="movimentacoes.php">Registrar Movimentações</a></p>
            </div>
        <?php endif; ?>

        <div class="menu-grid">
            <a href="pizzas.php" class="menu-item">
                <h3>Pizzas</h3>
                <p>Gerenciar cardápio</p>
            </a>
            <a href="movimentacoes.php" class="menu-item">
                <h3>Movimentações</h3>
                <p>Entrada e saída</p>
            </a>
            <a href="historico.php" class="menu-item">
                <h3>Histórico</h3>
                <p>Ver movimentações</p>
            </a>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="logout.php" class="btn">Sair</a>
        </div>
    </div>
</body>
</html>