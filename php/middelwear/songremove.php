<?php
session_start();
if (empty($_SESSION['id'])) {
    header('location: ../logout.php');
    return false;
}

require_once '../database.php';

if(empty($_GET['id'])) {
    header('location: ../../dashboard/songs.php?error=Geen liedje geselecteerd.');
    return false;
}

$id = $_GET['id'];

// Delete from staged
$stmt = $conn->prepare("DELETE FROM music WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header('location: ../../dashboard/songs.php');
