<?php

// Iniciando minha sessão
session_start();
// adoro salvar coisas na sessão

// Verificando se o usuario está logado
if(!isset($_SESSION['logou'])){
    // redirecionando para o index
    header('Location: index.php');
    // não sei se gosto muito do header location
}

// declarando minha primeira variável
$tempoRestante = ($_SESSION['logou'] - time()) * -1;
// multiplico o tempo por -1 para converter para uma contagem positiva

// se o tempo for maior que 120, ele desloga
if($tempoRestante > 120){
    // redirecionando para o logout
    header("Location: logout.php");
    // header location é uma funçao bem legal
}

?>