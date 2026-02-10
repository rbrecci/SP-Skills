<?php

session_start();

include("connection.php");
include("funcoes_estoque.php");

if (!isset($_SESSION['usuario'])){
    header("location: login.php");
    exit();
}

if ($_POST['add_movimento'] ?? false){
    $pizza_escolhida = $_POST['pizza_id'];
    $tipo_movimento = $_POST['tipo'];
    $quantidade_movimento = $_POST['quantidade'];
    $observacoes_movimento = $_POST['observacoes'];
    $usuario_id = $_SESSION['usuario']['id'];

    //inserir movimentação no banco
    $sql = "INSERT INTO  movimentacoes (pizza_id, usuaio_id, data_hora, tipo, quantidade, observacoes)
            VALUES ($pizza_escolhida, $usuario_id, NOW(), '$tipo_movimento, $quantidade_movimento, '$observacoes_movimento')
    ";
    $conn->query($sql);

    header("location: movimentacoes.php");
    exit();
}

//busca as pizzas ativas
$sql_pizzas = "SELECT * FROM pizzas WHERE ativo = 1 ORDER BY nome";
$resultado_pizzas = $conn->query($sql_pizzas);

//buscar ultimas 20 movimentações
$sql_movimentacoes = "SELECT m.*, p.nome as pizza_nome, u.nome as usuario_nome 
                      FROM movimentacoes m 
                      JOIN pizzas p ON m.pizza_id = p.id 
                      JOIN usuarios u ON m.usuario_id = u.id 
                      ORDER BY m.data_hora DESC LIMIT 20";
$resultado_movimentacoes = $conn->query($sql_movimentacoes);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentações - Sistema Pizzaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Movimentações</h1>
        
        <a href="index.php" class="btn">Voltar</a>

        <div style="background: #f9f9f9; padding: 15px; border: 1px solid #ddd; margin: 15px 0;">
            <h3>Nova Movimentação</h3>
            <form method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label>Pizza:</label>
                        <select name="pizza_id" required>
                            <option value="">Selecione uma pizza</option>
                            <?php while($pizza = $resultado_pizzas->fetch_assoc()): 
                                $pizza_id = $pizza['id'];
                                
                                // Calcular estoque atual desta pizza
                                $sql_entradas = "SELECT SUM(quantidade) as total FROM movimentacoes WHERE pizza_id = $pizza_id AND tipo = 'entrada'";
                                $entradas = $conn->query($sql_entradas)->fetch_assoc();
                                $total_entradas = $entradas['total'] ? $entradas['total'] : 0;
                                
                                $sql_saidas = "SELECT SUM(quantidade) as total FROM movimentacoes WHERE pizza_id = $pizza_id AND tipo = 'saida'";
                                $saidas = $conn->query($sql_saidas)->fetch_assoc();
                                $total_saidas = $saidas['total'] ? $saidas['total'] : 0;
                                
                                $estoque_atual = $total_entradas - $total_saidas;
                            ?>
                                <option value="<?= $pizza['id'] ?>">
                                    <?= htmlspecialchars($pizza['nome']) ?> - <?= $estoque_atual ?>/<?= $pizza['estoque_minimo'] ?> - R$ <?= number_format($pizza['preco'], 2, ',', '.') ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo:</label>
                        <select name="tipo" required>
                            <option value="">Selecione</option>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Quantidade:</label>
                        <input type="number" name="quantidade" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Observações:</label>
                        <textarea name="observacoes"></textarea>
                    </div>
                </div>
                <button type="submit" name="add_movimento" class="btn">Registrar</button>
            </form>
        </div>

        <h3>Histórico Recente</h3>
        <table>
            <tr><th>Data/Hora</th><th>Pizza</th><th>Usuário</th><th>Tipo</th><th>Qtd</th><th>Obs</th></tr>
            <?php while($movimentacao = $resultado_movimentacoes->fetch_assoc()): ?>
                <tr>
                    <td><?= date('d/m H:i', strtotime($movimentacao['data_hora'])) ?></td>
                    <td><?= htmlspecialchars($movimentacao['pizza_nome']) ?></td>
                    <td><?= htmlspecialchars($movimentacao['usuario_nome']) ?></td>
                    <td class="<?= $movimentacao['tipo'] ?>"><?= $movimentacao['tipo'] == 'entrada' ? 'Entrada' : 'Saída' ?></td>
                    <td><?= $movimentacao['quantidade'] ?></td>
                    <td><?= htmlspecialchars($movimentacao['observacoes']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        
        <div style="text-align: center; margin-top: 15px;">
            <a href="historico.php" class="btn">Histórico Completo</a>
        </div>
    </div>
</body>
</html>
