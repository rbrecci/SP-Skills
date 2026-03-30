<?php
header('Content-Type: application/json');

session_start();
$json = file_get_contents("../assets/usuarios.json");
$usuarios = json_decode($json, true);
$usuarioExiste = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $equipe = $_POST['equipe'] ?? '';

    if(!empty($username) && !empty($senha) && !empty($nome) && !empty($email) && !empty($equipe)){
        foreach($usuarios as $usuario){
            if($usuario['username'] == $username || $usuario['email'] === $email){
                http_response_code(422);
                echo json_encode([
                    "Message" => "(422) Usuário já cadastrado!"
                ]);
                $usuarioExiste = true;
                break;
            }
        }

        if(!$usuarioExiste){
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $newUser = [
                "nome" => $nome,
                "email" => $email,
                "equipe" => $equipe,
                "username" => $username,
                "senha" => $hash
            ];
            $usuarios[] = $newUser;
            file_put_contents("../assets/usuarios.json", json_encode($usuarios, JSON_PRETTY_PRINT));
            http_response_code(201);
            echo json_encode([
                "Message" => "(201) Cadastro efetuado com sucesso"
            ]);
        }
    } else {
        http_response_code(422);
        echo json_encode([
            "Message" => "(422) Verifique novamente, campos faltando"
        ]);
    }
} else {
    header("Location: signup-form.html");
}

?>