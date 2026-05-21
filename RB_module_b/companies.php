<?php

// include no middleware
include(__DIR__ . "/middleware.php");
$teste = [];

// nessa parte aqui o zeal salvou demais, eu não fazia ideia de que dava pra fazer isso
$empresas = new SplFileObject("./MEDIA_FILES/companies.csv");
// os caras fornecerem os dados em csv é uma sacanagem enorme, é só pra fazer a gente perder tempo
$empresas->setFlags(SplFileObject::READ_CSV);

// aqui o zeal foi bem bom também, eu não manjava desse arrayobject, ele facilita bastante
$empresasJson = new ArrayObject(json_decode(file_get_contents("companies.json"), true));

// como eu sou dev júnior eu repopulo o json caso ele esteja vazio, que aí aparece alguma coisa e eu ganho ponto
if(!$empresasJson[6]){
    // como eu amo o foreach do php cara, muito melho que o do js
    foreach($empresas as $row){
        // isso aqui é bem legal também, ele atribui os valores das variaveis tudo de uma vez, vou usar em form grande
        list($name, $address, $telephone, $email, $owner, $ownerNumber, $ownerEmail, $contact, $contactNumber, $contactEmail) = $row;
        // puxando os dados de cada empresa pra dentro de um arrayzinho de input
        $novaEmpresa = [
            "name" => $name,
            "address" => $address,
            "telephone" => $telephone,
            "email" => $email,
            "owner" => $owner,
            "ownerNumber" => $ownerNumber,
            "ownerEmail" => $ownerEmail,
            "contact" => $contact,
            "contactNumber" => $contactNumber,
            "contactEmail" => $contactEmail
        ];
        // aqui o ArrayObject salvou, pq com esse append eu consigo somar os dados dentro do array que já tinha dados sem reescrever ele
        $empresasJson->append(array($novaEmpresa));
        // e por fim eu coloco o array novo dentro do json
        file_put_contents("companies.json", json_encode($empresasJson, JSON_PRETTY_PRINT));
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Tempo restante de login: <?= $tempoRestante ?></h1>
    </header>
    <main>
        <?php foreach($empresas as $row): 
            list($name, $address, $telephone, $email, $owner, $ownerNumber, $ownerEmail, $contact, $contactNumber, $contactEmail) = $row;
        ?>
            <div class="card">
                <h2>name: <?= $name ?></h2>
                <p>address: <?= $address ?></p>
                <p>telephone: <?= $telephone ?></p>
                <p>email: <?= $email ?></p>
                <p>owner: <?= $owner ?></p>
                <p>ownerNumber: <?= $ownerNumber ?></p>
                <p>ownerEmail: <?= $ownerEmail ?></p>
                <p>contact: <?= $contact ?></p>
                <p>contactNumber: <?= $contactNumber ?></p>
                <p>contactEmail: <?= $contactEmail ?></p>
            </div>
        <?php endforeach; ?>
    </main>
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
        }
    </style>
</body>
</html>