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
    header('location: ../../dashboard/index.php?error=Geen liedje geselecteerd.');
    return false;
}

$id = $_GET['id'];
$song = $_POST['song'];
$artist = $_POST['artist'];
$file = $_POST['file'];
$categorie = $_POST['categorie'];
$categorie = (int)$categorie;

// Delete from staged
$stmt = $conn->prepare("DELETE FROM stagedmusic WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

rename ("../../music/".$file, "../../music/".$id.'.mp3');

$file = $id.'.mp3';

// Insert
$stmt = $conn->prepare("INSERT INTO music (id, song, artist, categorie, file) VALUES (?, ?,?,?, ?)");
$stmt->bind_param("issis", $id, $song, $artist, $categorie, $file);
$stmt->execute();
$stmt->close();

header('location: ../../dashboard/index.php');
