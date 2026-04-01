<?php

include(__DIR__ . "/middleware.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = count($usuarios) + 1;
    $username = $_POST['username'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $equipe = $_POST['equipe'] ?? '';

    if(!empty($username) && !empty($senha) && !empty($nome) && !empty($email) && !empty($equipe)){
        foreach($usuarios as $usuario){
            if($usuario['username'] == $username || $usuario['email'] === $email){
                http_response_code(422);
                echo json_encode([ "Message" => "(422) Usuário já cadastrado!" ]);
                $usuarioExiste = true;
                break;
            }
        }

        if(!$usuarioExiste){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $newUser = [
                    "id" => $id,
                    "nome" => $nome,
                    "email" => $email,
                    "equipe" => $equipe,
                    "username" => $username,
                    "senha" => $hash
                ];
                $usuarios[] = $newUser;
                file_put_contents("../assets/usuarios.json", json_encode($usuarios, JSON_PRETTY_PRINT));
                http_response_code(201);
                echo json_encode([ "Message" => "(201) Cadastro efetuado com sucesso" ]);
            } else {
                http_response_code(422);
                echo json_encode([ "Message" => "(422) Verifque o email, tente novamente" ]);
            }
            
        }
    } else {
        http_response_code(422);
        echo json_encode([ "Message" => "(422) Verifique novamente, campos faltando" ]);
    }
} else {
    header("Location: signup-form.html");
}

?>