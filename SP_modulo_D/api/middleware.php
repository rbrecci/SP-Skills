<?php

header('Content-Type: application/json');

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? null;
$tokenEnviado = str_ireplace('Bearer ', '', $authHeader);

$json = file_get_contents("../assets/usuarios.json");
$jsonToken = file_get_contents("../assets/token.json");

$tokenArray = json_decode($jsonToken, true);
$usuarios = json_decode($json, true);

$usuarioExiste = false;
$loginValido = false;

?>