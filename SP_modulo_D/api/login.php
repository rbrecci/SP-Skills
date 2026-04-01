<?php

include(__DIR__ . "/middleware.php");


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'] ?? '';
    $senha = $_POST['senha'] ?? '';
    if(!empty($username) && !empty($senha)){
        foreach($usuarios as $usuario){
            if($usuario['username'] == $username && password_verify($senha, $usuario['senha'])){
                $loginValido = true;
                break;
            }
        }
    } else {
        http_response_code(422);
        echo json_encode([ "Message" => "(422) Verifique novamente, campos faltando" ]);
        exit;
    }

    if($loginValido){
        $novoToken = bin2hex(random_bytes(3));
        $usuarioLogado = $usuario['id'];

        $token = [
            "token" => $novoToken,
            "usuario" => $usuarioLogado
        ];

        $tokenArray[] = $token;
        file_put_contents("../assets/token.json", json_encode($token, JSON_PRETTY_PRINT));
        http_response_code(200);
        echo json_encode([ "Message" => "(200) token: {$token['token']}" ]);
    } else {
        http_response_code(401);
        echo json_encode([ "Message" => "(401) Login inválido, tente novamente" ]);
    }
}

?>