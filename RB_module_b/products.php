<?php

// include no middleware
include(__DIR__ . "/middleware.php");

// declarando minha primeira variável
$produtos = new SplFileObject("./MEDIA_FILES/products.csv");
// lendo o csv
$produtos->setFlags(SplFileObject::READ_CSV);

// declarando minha segunda variável
$produtosJson = new ArrayObject(json_decode(file_get_contents("products.json"), true));
if(!$produtosJson[50]){
    foreach($produtos as $row){
        // atribuindo valores para as minhas variaveis
        list($GTIN, $name, $description, $frenchDescription, $frenchName, $brandName, $originCountry, $weight, $netWeight, $unitWeight) = $row;
        // declarando minha terceira variável
        $novoProduto = [
            "GTIN" => $GTIN,
            "name" => $name,
            "description" => $description,
            "frenchDescription" => $frenchDescription,
            "frenchName" => $frenchName,
            "brandName" => $brandName,
            "originCountry" => $originCountry,
            "weight" => $weight,
            "netWeight" => $netWeight,
            "unitWeight" => $unitWeight
        ];
        // adicionando o produto atual ao json de produtos
        $produtosJson->append(array($novoProduto));
        file_put_contents("products.json", json_encode($produtosJson, JSON_PRETTY_PRINT));
    }
}


?>

<!-- iniciando o html da minha página -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <!-- Header mostrando o tempo restante -->
        <h1>Tempo restante de login: <?= $tempoRestante ?></h1>
    </header>
    <!-- Main mostrando os cards -->
    <main>
        <?php foreach($produtos as $row): 
            list($GTIN, $name, $description, $frenchDescription, $frenchName, $brandName, $originCountry, $weight, $netWeight, $unitWeight) = $row;
        ?>
            <div class="card">
                <h2>Nome da Empresa</h2>
                <img src="./MEDIA_FILES/images/placeholder.jpg" alt="Placeholder">
                <h3>GTIN: <?= $GTIN ?></h3>
                <p><?= $description ?></p>
                <p>weight:<?= $weight ?></p>
                <p>net content weight: <?= $netWeight ?></p>
            </div>
        <?php endforeach; ?>
    </main>
    <!-- Abrindo meu style para estilizar a página -->
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        header{
            padding: 20px;
            text-align: center;
        }
        main{
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
            row-gap: 50px;
        }
        .card{
            padding: 20px;
            border: 1px solid black;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            width: 200px;
            height: 400px;

            & img{
                height: 100px;
                width: 150px;
            }
        }
    </style>
</body>
</html>