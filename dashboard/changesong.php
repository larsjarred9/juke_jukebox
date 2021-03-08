<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (empty($_SESSION['id'])) {
    header('location: ../logout.php');
    return false;
}

require_once '../php/database.php';

if (empty($_GET['id'])) {
    header('location: ../../dashboard/index.php?error=Geen liedje geselecteerd.');
    return false;
}

$stmt = $conn->prepare("SELECT id, categorie FROM categories ORDER BY ID ASC");
$stmt->execute();
$categorie = $stmt->get_result();
$stmt->close();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT artist, song, file, categorie FROM music WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($artist, $song, $file, $categories);
$stmt->fetch();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUKE | Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../images/juke_favicon.png" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../images/juke.png"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="songs.php">Songs</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="text-white">Nummer Wijzigen</h2>
                <hr>
                <form action="../php/middelwear/editsong.php?id=<?php echo $id; ?>" method="post">
                    <div class="form-group">
                        <input type="hidden" name="file" value="<?php echo $file; ?>">
                        <label for="ArtiestInvoer">Artiest</label>
                        <input type="text" class="form-control" name="artist" value="<?php echo $artist; ?>" placeholder="Naam van Artiest">
                    </div>
                    <div class="form-group">
                        <label for="Nummer">Nummer</label>
                        <input type="text" class="form-control" name="song" value="<?php echo $song; ?>" placeholder="Naam van Nummer">
                    </div>
                    <div class="form-group">
                        <label for="Nummer">Categories</label>
                        <select class="form-select" name='categorie'>
                            <?php foreach ($categorie as $item) {
                                echo '<option'; if($categories == $item["id"]){ echo " selected "; } echo ' value="' . $item["id"] . '">' . $item["categorie"] . '</option>';
                            } ?>
                        </select>
                    </div>
                    <br>
                    <input type="submit" value="Aanpassen" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</body>

</html>