<?php
require "../database.php";
// Count # of uploaded files in array
$total = count($_FILES['upload']['name']);

if (!file_exists($_FILES['upload']['tmp_name'][0])) {
    // header('location: ../../upload.php?error=file does not exist');
    return false;
}

// Loop through each file
for ($i = 0; $i < $total; $i++) {

    //Get the temp file path
    $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
    $fileExt = pathinfo($_FILES['upload']['name'][$i], PATHINFO_EXTENSION);

    //Make sure we have a file path
    if ($tmpFilePath != "") {
        //Setup our new file path
        $newName = uniqid() . "_" . uniqid() . "." . $fileExt;
        $newFilePath = "../../music/" . $newName;
        // if ($_FILES['upload']['type'][$i] == 'audio/mpeg') {


            //Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                // Put inside database
                $stmt = $conn->prepare("INSERT INTO stagedmusic (id, artist, song, filename) VALUES (null, ?, ?, ?)");
                $stmt->bind_param("sss", $_POST['artist'], $_POST['song'], $newName);
                $stmt->execute();
                $stmt->close();
                echo $_POST['song'];
                echo $_POST['artist'];
                echo $newName;
                header('location: ../../upload.php');
            } else {
                header('location: .../../upload.php?error=filemove');
                return false;
            }
        // }
        // else {
        //     header('location: ../../upload.php?error=no audio file');
        //     return false; 
        // }
    } else {
        header('location: ../../upload.php?error=nopath');
        return false;
    }
}
