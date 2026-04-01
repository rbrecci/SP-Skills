<?php

include(__DIR__ . "/middleware.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!$authHeader || empty($tokenEnviado)){
        http_response_code(422);
        echo json_encode(["Message" => "(422) Atenção, token não informado"]);
        exit;
    }

    if(!$tokenArray || !isset($tokenArray['token']) || $tokenEnviado !== $tokenArray['token']){
        http_response_code(401);
        echo json_encode(["Message" => "(401) Atenção, token inválido"]);
        exit;
    }

    foreach($usuarios as $usuario){
        if($usuario['id'] == $tokenArray['usuario']){
            $equipeUsuario = $usuario['equipe'];
            if($equipeUsuario != 'Gestão'){
                http_response_code(401);
                echo json_encode(["Message" => "(422) Você não tem privilégio para incluir uma nova tarefa"]);
                exit;
            }
        }
    }

    $id = count($tarefasArray) + 1;
    $titulo = $_POST['Titulo'] ?? '';
    $desc = $_POST['Descricao'] ?? '';
    $prazo = $_POST['Prazo'] ?? '';
    $equipe = $_POST['Equipe'] ?? '';
    $prioridade = $_POST['Prioridade'] ?? '';
    $status = $_POST['Status'] ?? '';
    $projeto = $_POST['Projeto'] ?? '';
    $responsavel = $_POST['Responsavel'] ?? '';

    if(!empty($titulo) && !empty($desc) && !empty($prazo) && !empty($projeto) && !empty($responsavel)){
        if($prazo != ''){
            if(!validarData($prazo)){
                http_response_code(422);
                echo json_encode([ "Message" => "(422) Verifique novamente, dados incorretos" ]);
                exit;
            } else {
                if(filter_var($responsavel, FILTER_VALIDATE_INT)){
                $novaTarefa = [
                    "id" => $id,
                    "titulo" => $titulo,
                    "descricao" => $desc,
                    "prazo" => $prazo,
                    "equipe" => $equipe,
                    "prioridade" => $prioridade,
                    "status" => $status,
                    "projeto" => $projeto,
                    "responsavel" => $responsavel
                ];
                $tarefasArray[] = $novaTarefa;
                file_put_contents("../assets/tarefas.json", json_encode($tarefasArray, JSON_PRETTY_PRINT));
                http_response_code(201);
                echo json_encode([ "Message" => "(201) Nova tarefa registrada com sucesso" ]);
                } else {
                    http_response_code(422);
                    echo json_encode([ "Message" => "(422) Verifique novamente, dados incorretos" ]);
                    exit;
                }
            }
        } else {
            if(filter_var($responsavel, FILTER_VALIDATE_INT)){
                $novaTarefa = [
                    "id" => $id,
                    "titulo" => $titulo,
                    "descricao" => $desc,
                    "prazo" => $prazo,
                    "equipe" => $equipe,
                    "prioridade" => $prioridade,
                    "status" => $status,
                    "projeto" => $projeto,
                    "responsavel" => $responsavel
                ];
                $tarefasArray[] = $novaTarefa;
                file_put_contents("../assets/tarefas.json", json_encode($tarefasArray, JSON_PRETTY_PRINT));
                http_response_code(201);
                echo json_encode([ "Message" => "(201) Nova tarefa registrada com sucesso" ]);
            } else {
                http_response_code(422);
                echo json_encode([ "Message" => "(422) Verifique novamente, dados incorretos" ]);
                exit;
            }
        }
    } else {
        http_response_code(422);
        echo json_encode([ "Message" => "(422) Verifique novamente, campos faltando" ]);
    }
}

?>