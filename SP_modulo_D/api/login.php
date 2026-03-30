<?php
header('Content-Type: application/json');

session_start();
$json = file_get_contents("../assets/usuarios.json");
$usuarios = json_decode($json, true);
$loginValido = false;


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
        http_response_code(401);
        echo json_encode([
            "Message" => "(401) Login inválido, tente novamente"
        ]);
    }

    if($loginValido){
        $_SESSION['token'] = rand(1111, 9999);
        http_response_code(200);
        echo json_encode([
            "Message" => "(200) {$_SESSION['token']}"
        ]);
    } else {
        http_response_code(422);
        echo json_encode([
            "Message" => "(422) Verifique novamente, campos faltando"
        ]);
    }
}

?>