<?php

header('Content-Type: application/json');

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? null;
$tokenEnviado = str_ireplace('Bearer ', '', $authHeader);
$jsonToken = file_get_contents("../assets/token.json");
$tokenArray = json_decode($jsonToken, true) ?? null;

if(!$authHeader || empty($tokenEnviado)){
    http_response_code(422);
    echo json_encode(["Message" => "Atenção, token não informado"]);
    exit;
}

if (!$tokenArray || !isset($tokenArray['token']) ||$tokenEnviado !== $tokenArray['token']){
    http_response_code(401);
    echo json_encode(["Message" => "Atenção, token inválido"]);
    exit;
}

$tokenArray = [ "token" => '' ];
file_put_contents("../assets/token.json", json_encode($tokenArray, JSON_PRETTY_PRINT));
http_response_code(200);
echo json_encode(["Message" => "Logout efetuado com sucesso"]);

?>