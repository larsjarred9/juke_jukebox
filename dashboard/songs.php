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
$stmt = $conn->prepare("SELECT id, artist, song, file FROM music ORDER BY ID ASC");
$stmt->execute();
$muziek = $stmt->get_result();
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
                <h2 class="text-white">Music</h2>
                <hr>
                <table class="table table-dark table-striped table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Music</th>
                            <th scope="col">Artist</th>
                            <th scope="col">Song</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($muziek as $item) {
                            echo '<tr><th scope="row">' . $item['id'] . '</th><td><audio controls> <source src="../music/' . $item['file'] . '" type="audio/mpeg"></audio></td><td>' . $item['artist'] . '</td><td>' . $item['song'] . '</td><td><a href="changesong.php?id=' . $item['id'] . '" class="btn btn-warning">Wijzigen</a></td> <td><a href="../php/middelwear/songremove.php?id=' . $item['id'] . '" class="btn btn-danger">Verwijderen</a></td></tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>