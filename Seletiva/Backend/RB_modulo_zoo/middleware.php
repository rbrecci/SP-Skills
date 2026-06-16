<?php

require_once(__DIR__ . "/conn.php");

$loginJson = file_get_contents("./login.json");
$login = json_decode($loginJson);

function logged($login){
    if($login == true){
        return(true);
    }

    return(false);
}

?>