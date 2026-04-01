<?php

header('Content-Type: application/json');

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? null;
$tokenEnviado = str_ireplace('Bearer ', '', $authHeader);

$json = file_get_contents("../assets/usuarios.json");
$jsonToken = file_get_contents("../assets/token.json");
$jsonTarefas = json_decode(file_get_contents("../assets/tarefas.json"), true);

$tokenArray = json_decode($jsonToken, true);
$tarefasArray = $jsonTarefas;
$usuarios = json_decode($json, true);

$usuarioExiste = false;
$loginValido = false;

function validarData($data, $formato = 'Y-m-d'){
    $d =  DateTime::createFromFormat($formato, $data);
    return $d && $d->format($formato) === $data;
}

?>