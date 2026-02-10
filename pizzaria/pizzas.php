<?php

session_start();

include("connection.php");

if(!isset($_SESSION['usuario'])){
    header("location: login.php");
    exit();
}

include("funcoes_estoque.php");

//pegar o que o usuário digitou na busca
$texto_busca = $_GET['busca'] ?? '';

//se o usuário clicou em "Cadastrar"
if ($_POST['add'] ?? false) {
    $nome_pizza = $_POST['nome'];
    $ingredientes_pizza = $_POST['ingredientes'];
    $preco_pizza = $_POST['preco'];
    $tamanho_pizza = $_POST['tamanho'];
    $categoria_pizza = $_POST['categoria'];
    $estoque_minimo_pizza = $_POST['estoque_minimo'];
    
    //inserir nova pizza no banco
    $sql = "INSERT INTO pizzas (nome, ingredientes, preco, tamanho, categoria, estoque_minimo) 
            VALUES ('$nome_pizza', '$ingredientes_pizza', $preco_pizza, '$tamanho_pizza', '$categoria_pizza', $estoque_minimo_pizza)";
    $conn->query($sql);
    
    //voltar para a mesma página
    header("Location: pizzas.php");
    exit();
}

if ($texto_busca) {
    $sql = "SELECT * FROM pizzas WHERE nome LIKE '%$texto_busca%' OR ingredientes LIKE '%$texto_busca%' ORDER BY nome";
} else {
    $sql = "SELECT * FROM pizzas ORDER BY nome";
}
$resultado_pizzas = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pizzas - Sistema Pizzaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciar Pizzas</h1>

        <div style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd;">
            <form method="get" style="display: flex; gap: 10px;">
                <input name="busca" placeholder="Buscar..." value="<?= htmlspecialchars($texto_busca) ?>" style="flex: 1; padding: 8px;">
                <button type="submit" class="btn">Buscar</button>
                <a href="index.php" class="btn">Voltar</a>
            </form>
        </div>

        <table>
            <tr><th>Nome</th><th>Ingredientes</th><th>Preço</th><th>Tamanho</th><th>Categoria</th><th>Estoque</th><th>Ações</th></tr>
            <?php 
            // Mostrar cada pizza na tabela
            while($pizza = $resultado_pizzas->fetch_assoc()): 
                $pizza_id = $pizza['id'];
                
                // Calcular estoque atual desta pizza
                $sql_entradas = "SELECT SUM(quantidade) as total FROM movimentacoes WHERE pizza_id = $pizza_id AND tipo = 'entrada'";
                $entradas = $conn->query($sql_entradas)->fetch_assoc();
                $total_entradas = $entradas['total'] ? $entradas['total'] : 0;
                
                $sql_saidas = "SELECT SUM(quantidade) as total FROM movimentacoes WHERE pizza_id = $pizza_id AND tipo = 'saida'";
                $saidas = $conn->query($sql_saidas)->fetch_assoc();
                $total_saidas = $saidas['total'] ? $saidas['total'] : 0;
                
                $estoque_atual = $total_entradas - $total_saidas;
                $estoque_minimo = $pizza['estoque_minimo'];
                
                // Verificar se estoque está baixo
                $estoque_baixo = $estoque_atual <= $estoque_minimo;
            ?>
                <tr class="<?= $estoque_baixo ? 'estoque-baixo' : 'estoque-ok' ?>">
                    <td><span class="status-indicator <?= $estoque_baixo ? 'status-baixo' : 'status-ok' ?>"></span><?= htmlspecialchars($pizza['nome']) ?></td>
                    <td><?= htmlspecialchars($pizza['ingredientes']) ?></td>
                    <td>R$ <?= number_format($pizza['preco'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($pizza['tamanho']) ?></td>
                    <td><?= htmlspecialchars($pizza['categoria']) ?></td>
                    <td><strong><?= $estoque_atual ?></strong>/<?= $estoque_minimo ?><?= $estoque_baixo ? '<br><small>⚠️ Baixo!</small>' : '' ?></td>
                    <td>
                        <a href="editar_pizza.php?id=<?= $pizza['id'] ?>" class="btn" style="padding: 3px 8px; font-size: 11px;">Editar</a>
                        <a href="deletar_pizza.php?id=<?= $pizza['id'] ?>" class="btn" style="padding: 3px 8px; font-size: 11px;" onclick="return confirm('Excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div style="background: #f9f9f9; padding: 15px; border: 1px solid #ddd;">
            <h3>Adicionar Pizza</h3>
            <form method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label>Preço:</label>
                        <input type="number" name="preco" step="0.01" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tamanho:</label>
                        <select name="tamanho" required>
                            <option value="">Selecione</option>
                            <option value="Pequena">Pequena</option>
                            <option value="Media">Média</option>
                            <option value="Grande">Grande</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Categoria:</label>
                        <input type="text" name="categoria" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Estoque Mínimo:</label>
                        <input type="number" name="estoque_minimo" min="0" value="5" required>
                    </div>
                    <div class="form-group">
                        <label>Ingredientes:</label>
                        <textarea name="ingredientes" required></textarea>
                    </div>
                </div>
                <button type="submit" name="add" class="btn">Cadastrar</button>
            </form>
        </div>

        <div style="text-align: center; margin-top: 15px;">
            <a href="movimentacoes.php" class="btn">Movimentações</a>
        </div>
    </div>
</body>
</html>