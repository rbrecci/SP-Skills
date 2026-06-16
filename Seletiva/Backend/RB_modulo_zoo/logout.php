<?php

require_once(__DIR__ . "/middleware.php");

if(!logged($login)){
    header("Location: ./index.php");
}

?>