<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (empty($_SESSION['id'])) {
    header('location: ../logout.php');
    return false;
}

include_once '../database.php';

if(empty($_GET['id'])) {
    header('location: ../../dashboard/songs.php?error=Geen liedje geselecteerd.');
    return false;
}

$id = $_GET['id'];
$song = $_POST['song'];
$artist = $_POST['artist'];
$categorie = $_POST['categorie'];
$categorie = (int)$categorie;

// Insert
$stmt = $conn->prepare("UPDATE music SET song = ?, artist = ?, categorie= ? WHERE id = ?");
$stmt->bind_param("sssi", $song, $artist, $categorie, $id);
$stmt->execute();
$stmt->close();

header('location: ../../dashboard/songs.php');
