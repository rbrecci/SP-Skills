<?php
// olha que abertura de tag de php magnífica

// include no middleware
include(__DIR__ . "/middleware.php");
// o include é realmente um dos meus comandos favoritos do php

// limpando as variaveis da sessão para garatir que ela está limpa
$_SESSION = [];
// minha mãe sempre me ensinou a ser organizado, tem que limpar a sessão

// destruindo a sessão por que eu não preciso mais dela
session_destroy();
// realmente, os seres humanos são hiper mega hipócritas

// OPA MAIS UM HEADER LOCATION VAMBORAAAA
header("Location: index.php")
// agora eu já não gosto mais tanto do header location


// que droga, vou ter que fechar a tag do php
?>