<?php

include(__DIR__ . "/middleware.php");

if(!$authHeader || empty($tokenEnviado)){
    http_response_code(422);
    echo json_encode(["Message" => "(422) Atenção, token não informado"]);
    exit;
}

if (!$tokenArray || !isset($tokenArray['token']) ||$tokenEnviado !== $tokenArray['token']){
    http_response_code(401);
    echo json_encode(["Message" => "(401) Atenção, token inválido"]);
    exit;
}

$tokenArray = [ "token" => '', "usuario" => '' ];
file_put_contents("../assets/token.json", json_encode($tokenArray, JSON_PRETTY_PRINT));
http_response_code(200);
echo json_encode(["Message" => "(200) Logout efetuado com sucesso"]);

?>