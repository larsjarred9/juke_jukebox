<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'php/middelwear/albumInlezen.php';
require_once 'php/database.php';


if(empty($_GET['id'])) {
    $stmt = $conn->prepare("SELECT id, artist, song from music WHERE status = 1");
    $stmt->execute();
    $muziek = $stmt->get_result();
    $stmt->close();
}
else {
    $stmt = $conn->prepare("SELECT id, artist, song from music WHERE status = 1 AND categorie = ".$_GET['id']);
    $stmt->execute();
    $muziek = $stmt->get_result();
    $stmt->close();
}


$stmt = $conn->prepare("SELECT * from categories");
$stmt->execute();
$categories = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUKE | Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/juke_favicon.png" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="images/juke.png"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">All</a>
                    </li>
                    <?php foreach ($categories as $item) {
                        echo '<li class="nav-item"><a class="nav-link" href="index.php?id='.$item['id'].'">' . $item['categorie'] . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <footer class="mt-auto">
        <div class="bg-secondary text-white">
            <div class="container pt-2 pb-2 fs-3">
                <div class="row">
                    <div class="col-2">
                        <i style="cursor: pointer;" onclick="resumeaudio();" class="bi-play-circle-fill  me-3"></i>
                        <i style="cursor: pointer;" onclick="pauzeaudio();" class="bi bi-pause-circle-fill"></i>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-10">
                                <input disabled type="range" class="form-range float-right pt-2">
                            </div>
                            <div class="col-2">
                                <p class="m-0 p-0"><small>0.00/<span id="duration">0.00</span></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <section id="muziek">
        <div class="container">
            <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                <?php foreach ($muziek as $item) {
                    echo '<div class="col mt-4"><span style="cursor: pointer;" onclick="playaudio('.$item['id'].');"><div class="card h-100"><div class="card-body text-center text-white">' . getAlbum($item['artist'], $item['song'], 2) . '<p>' . $item['song'] . '</p><h4>' . $item['artist'] . '</h4></div></div></span></div>';
                }
                ?>
            </div>
        </div>
    </section>
    <div id="audio"></div>
    <script>
        function playaudio(id) {
        	// Get audio file
            document.getElementById("audio").innerHTML = "<audio id='testAudio' hidden src='https://beroeps29.ict-lab.nl/music/"+id+".mp3' type='audio/mpeg'></audio>"; 

            // Play Audio
            var audio = document.getElementById('testAudio');
            getDuration();
            audio.play();

        }

        function pauzeaudio() {
        	// Pauze Audio
            var audio = document.getElementById('testAudio');
            audio.pause();
            getDuration();
        }

        function resumeaudio() {
        	// Resume adio
            var audio = document.getElementById('testAudio');
            audio.play();
            getDuration();
        }

        function getDuration() {
        	// Get duration
            var duration = document.getElementById("testAudio").duration;

            var minutes = Math.floor(duration / 60);
            var seconds = duration - minutes * 60;
            var seconds = seconds.toFixed(0);

            // Put duration as innerhtml element duration
            document.getElementById("duration").innerHTML = minutes+":"+seconds;

            // Current time
            var currenttime = document.getElementById("testAudio").currentTime;
            console.log(currenttime);
        }

        

    </script>
</body>

</html>