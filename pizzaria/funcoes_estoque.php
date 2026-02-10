<?php

//função para pegar pizzas com estoque baixo
function getPizzasEstoqueBaixo($conn){
    //buscar todas as pizzas
    $sql = "SELECT * FROM pizzas WHERE ativo = 1";
    $resultado = $conn->query($sql);

    $pizzas_estoque_baixo = array();

    //para cada pizza, calcular o estoque
    while($pizza = $resultado->fetch_assoc()){
        $pizza_id = $pizza['id'];

        //somar todas as entradas
        $sql_entradas = "SELECT SUM(quantidade) as total FROM movimentacoes WHERE pizza_id = $pizza_id AND tipo = 'entrada'";
        $entradas = $conn->query($sql_entradas)->fetch_assoc();
        $total_entradas = $entradas['total'] ?? 0;

        //somar todas as saidas
        $sql_saida = "SELECT SUM(quantidade) as total FROM movimentacoes WHERE pizza_id = $pizza_id AND tipo = 'saida'";
        $saidas = $conn->query($sql_saida)->fetch_assoc();
        $total_saidas = $saidas['total'] ?? 0;

        $estoque_atual = $total_entradas - $total_saidas;

        if($estoque_atual <= $pizza['estoque_minimo']){
            $pizza['estoque_atual'] = $estoque_atual;
            $pizzas_estoque_baixo[] = $pizza;
        }
    }

    return $pizzas_estoque_baixo;
}

//função para gerar alerta de estoque baixo
function gerarAlertaEstoque($conn){
    $pizzas_com_estoque_baixo = getPizzasEstoqueBaixo($conn);

    return array(
        'quantidade' => $quantidade_pizzas,
        'pizzas' => $pizzas_com_estoque_baixo,
        'mensagem' => $quantidade_pizzas . "pizza(s) com estoque baixo!"
    );
}