<?php
require_once 'php/database.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUKE | Upload Muziek</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/juke_favicon.png" />
</head>

<body>
    <div class="container">
        <img class="d-block mx-auto" src="images/juke.png" alt="">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title text-white">Upload Music</h5>
                <hr class="text-primary">
                <p class="text-white">
                    Upload hier je eigen muziek om die later tijdens feest te kunnen afspelen. Geuplode muziek zal gecontroleerd worden door de admin.</br>
                    <ul class="text-white">
                    <li>Geen geluids effecten;</li>
                    <li>Geen self-made recordings;</li>
                    <li>Alleen muziek waar je rechten voor bezit.</li>
                    </ul>
                </p>
                <form method="post" action="php/middelwear/upload.php" enctype="multipart/form-data">
                    <label class="text-white">Artiest</label>
                    <input class="form-control" type="text" name="artist" id=""><br>
                    <label class="text-white">Nummer</label>
                    <input class="form-control" type="text" name="song" id=""><br>
                    <label class="text-white">File</label>
                    <input type="file" required name="upload[]" multiple class="form-control">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary mt-3" type="submit">Uploaden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>