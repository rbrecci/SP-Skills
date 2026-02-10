<?php

session_start();

include("connection.php");

if(!isset($_SESSION['usuario'])){
    header("location: login.php");
    exit();
}

$filtro_pizza = $_GET['pizza'] ?? '';
$filtro_tipo = $_GET['tipo'] ?? '';

$sql = "SELECT m.id, p.nome AS pizza_nome, u.nome AS usuario_nome, m.tipo, m.quantidade, m.data_hora, m.observacoes 
        FROM movimentacoes m
        JOIN pizzas p ON m.pizza_id = p.id
        JOIN usuarios u ON m.usuario_id = u.id
        WHERE 1=1
";

//se escolheu uma pizza específica
if($filtro_pizza){
    $sql .= " AND m.pizza_id = $filtro_pizza";
}

//se escolheu um tipo especifico
if($filtro_tipo){
    $sql .= " AND m.tipo = '$filtro_tipo'";
}

$sql .= " ORDER BY m.data_hora DESC";

//executa a consulta
$resultado_movimentacoes = $conn->query($sql);

//busca todas as pizzas para o filtro
$sql_pizzas = "SELECT * FROM pizzas ORDER BY nome";
$resultado_pizzas = $conn->query($sql_pizzas);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico - Sistema Pizzaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Histórico</h1>
        
        <a href="index.php" class="btn">Voltar</a>

        <div style="background: #f9f9f9; padding: 15px; border: 1px solid #ddd; margin: 15px 0;">
            <h3>Filtros</h3>
            <form method="get">
                <div class="form-row">
                    <div class="form-group">
                        <label>Pizza:</label>
                        <select name="pizza">
                            <option value="">Todas</option>
                            <?php while($pizza = $resultado_pizzas->fetch_assoc()): ?>
                                <option value="<?= $pizza['id'] ?>" <?= $filtro_pizza == $pizza['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($pizza['nome']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo:</label>
                        <select name="tipo">
                            <option value="">Todos</option>
                            <option value="entrada" <?= $filtro_tipo == 'entrada' ? 'selected' : '' ?>>Entrada</option>
                            <option value="saida" <?= $filtro_tipo == 'saida' ? 'selected' : '' ?>>Saída</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn">Filtrar</button>
                <a href="historico.php" class="btn">Limpar</a>
            </form>
        </div>

        <table>
            <tr><th>ID</th><th>Data/Hora</th><th>Pizza</th><th>Usuário</th><th>Tipo</th><th>Qtd</th><th>Obs</th></tr>
            <?php 
            // Verificar se tem movimentações
            if ($resultado_movimentacoes->num_rows > 0): 
                // Mostrar cada movimentação
                while($movimentacao = $resultado_movimentacoes->fetch_assoc()): 
            ?>
                <tr>
                    <td><?= $movimentacao['id'] ?></td>
                    <td><?= date('d/m H:i', strtotime($movimentacao['data_hora'])) ?></td>
                    <td><?= htmlspecialchars($movimentacao['pizza_nome']) ?></td>
                    <td><?= htmlspecialchars($movimentacao['usuario_nome']) ?></td>
                    <td class="<?= $movimentacao['tipo'] ?>"><?= $movimentacao['tipo'] == 'entrada' ? 'Entrada' : 'Saída' ?></td>
                    <td><?= $movimentacao['quantidade'] ?></td>
                    <td><?= htmlspecialchars($movimentacao['observacoes']) ?></td>
                </tr>
            <?php 
                endwhile; 
            else: 
            ?>
                <tr><td colspan="7" style="text-align: center; padding: 20px;">Nenhuma movimentação encontrada.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
