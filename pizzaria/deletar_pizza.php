<?php

session_start();

include("connection.php");

if (!isset($_SESSION['usuario'])){
    header("location: login.php");
    exit();
}

$id = $_GET['id'] ?? 0;

if ($id > 0){
    $stmt = $conn->prepare("DELETE FROM pizzas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("location: pizzas.php");
exit();