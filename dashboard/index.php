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
$stmt = $conn->prepare("SELECT id, artist, song, filename, datetime FROM stagedmusic ORDER BY ID ASC");
$stmt->execute();
$muziek = $stmt->get_result();
$stmt->close();

$stmt = $conn->prepare("SELECT id, categorie FROM categories ORDER BY ID ASC");
$stmt->execute();
$categorie = $stmt->get_result();
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
                <h2 class="text-white">Music Upload Requests</h2>
                <hr>
                <table class="table table-dark table-striped table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Music</th>
                            <th scope="col">Artist</th>
                            <th scope="col">Song</th>
                            <th scope="col">Datetime</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($muziek as $item) {
                            echo '<tr><th scope="row">' . $item['id'] . '</th><td><audio controls> <source src="../music/' . $item['filename'] . '" type="audio/mpeg"></audio></td><td>' . $item['artist'] . '</td><td>' . $item['song'] . '</td><td>' . $item['datetime'] . '</td><td><a href="addsong.php?id=' . $item['id'] . '" class="btn btn-success">Accept</a></td> <td><a href="../php/middelwear/removesong.php?id=' . $item['id'] . '" class="btn btn-danger">Remove</a></td></tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#categorie">Create Categorie</button>
                <h2 class="text-white">Categories</h2>
                <hr>
                <table class="table table-dark table-striped table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Categorie</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorie as $item) {
                            echo '<tr><th scope="row">' . $item['id'] . '</th><td>' . $item['categorie'] . '</td><td><a href="../php/middelwear/removecategorie.php?id=' . $item['id'] . '" class="btn btn-danger">Remove</a></td></tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="categorie" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../php/middelwear/addcat.php" method="post">
                        <div class="row g-2 row-cols-2">
                            <div class="col">
                                <label>Categorie Name</label>
                                <input maxlength="32" name="categorie" class="form-control" type="text">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mt-2" value="Create Categorie">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>