<?php

session_start();
if (empty($_SESSION['id'])) {
    header('location: ../logout.php');
    return false;
}

require_once '../database.php';

// Insert
$stmt = $conn->prepare("INSERT INTO categories (categorie) VALUES (?)");
$stmt->bind_param("s", $_POST['categorie']);
$stmt->execute();
$stmt->close();

header('location: ../../dashboard/index.php');