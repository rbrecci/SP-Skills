<?php

// iniciando a sessão em
session_start();
// acho que iniciar a sessão faz meu dia mais feliz

// se o request method do servidor for post, aí entra no if
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // aqui eu to salvando o valor do input de senha dentro da minha variável
    $senha = $_POST['senha'] ?? '';
    // é sempre bom colocar essas interrogações mas eu não lembro o por que

    // aqui eu prossigo com a lógica só se a senha estiver preenchida
    if(isset($senha)){

        // mais um if pq sou dev júnior e não sei fazer login com função nativa
        if($senha == 'admin'){
            // mó legal essa função de tempo, achei super maneira e vou fazer uns testes com ela depois
            $_SESSION['logou'] = time();

            // HEADER LOCATIOOOOOOOONNNN
            header("Location: admin.php");
        }
    } else {

        // MANO EU VOU A LOUCURA DOIS HEADERS LOCATIONS SEGUIDOS
        header("Location: index.php");
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
    <form method="POST">
        <label for="senha">Entre com a senha:</label>
        <input type="text" name="senha">
        <button type="submit">Logar</button>
    </form>
</body>
</html>