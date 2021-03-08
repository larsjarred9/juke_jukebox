<?php

function getAlbum($artist, $album, $size) {
    $artist = urlencode($artist);
    $album = urlencode($album);
    $xml    = "http://ws.audioscrobbler.com/2.0/?method=album.getinfo&artist={$artist}&album={$album}&api_key=c3b3983b4e1d86ddfaca3f3731265f08";
    $xml    = @file_get_contents($xml);
    
    if(!$xml) {
            return;  // Artist lookup failed.
    }
    
    $xml = new SimpleXMLElement($xml);
    $xml = $xml->album;
    $xml = $xml->image[$size];
    
    $return = convert($xml);             

    return $return;

}  
function convert($file){

    $parts=pathinfo($file);
    //dont convert if its a jpg
    if (!isset($parts['extension'])) {
        return '<img src="images/nocover.png">';
    }
    if($parts['extension'] == "jpg"){ 
            return '<img src="' . $file . '" />';
    } else {

    $image = imagecreatefrompng($file);
    $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    imagealphablending($bg, TRUE);
    imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));

    ob_start (); 
    imagejpeg($bg, NULL, 80);
    $image_data = ob_get_contents (); 
    ob_end_clean (); 
    $imageData = base64_encode ($image_data);

    imagedestroy($image);
    ImageDestroy($bg);

    return '<img src="data:image/jpg;base64,'.$imageData.'" />';

    }

}

?>