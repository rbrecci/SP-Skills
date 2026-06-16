<?php

require_once(__DIR__ . "/middleware.php");

$sql = "SELECT * FROM animals";
$animals = $conn->query($sql);
$sql = "SELECT * FROM categories";
$cats = $conn->query($sql);
$sql = "SELECT * FROM extinction_risks";
$risks = $conn->query($sql);

function GetStatus($status_id){
    switch($status_id){
        case '1': return("Em Exposição");
        case '2': return("Fora de Exibição");
        case '3': return("Em Adaptação");
    }
}

if(!logged($login)){
    header("Location: ./index.php");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina inicial</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <button>Novo animal</button>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Nome cientifico</th>
                <th>Quantidade de visitas</th>
                <th>Categoria</th>
                <th>Status de operação</th>
                <th>Risco de extição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($animals as $animal): ?>
                <tr>
                    <td><?= $animal['name'] ?></td>
                    <td><?= $animal['scientific_name'] ?></td>
                    <td><?= $animal['visits'] ?></td>
                    <?php foreach($cats as $cat):  if($cat['id'] == $animal['category_id']): ?>
                        <td><?= $cat['name'] ?></td>
                    <?php endif; endforeach; ?>
                    <td><?= GetStatus($animal['status_id']) ?></td>
                    <?php foreach($risks as $risk):  if($risk['id'] == $animal['extinction_risk_id']): ?>
                        <td><?= $risk['name'] ?></td>
                    <?php endif; endforeach; ?>
                    <td><a href="">Editar</a> <a href="">Excluir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>