<?php
include_once '../function.php';
$apiCardId = 73;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
if (!extension_loaded('gd')) {
    die('GD库没安装');
}
$msg = $_GET['msg'] ?? '';
$breakChar = $_GET['break'] ?? "\n";
$imagePath = '1.png';
list($width, $height) = getimagesize($imagePath);
$image = imagecreatefromjpeg($imagePath);
$fontSize = 40;
$bottomTextY = $height - 40;
$bottomText = "Api FROM Hanzi home";
$bottomTextColor = imagecolorallocate($image, 255, 255, 255);
$x = 55; 
$y = 850; 
$lines = explode($breakChar, $msg);
foreach ($lines as $line) {
    $textColor = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    $textWidth = imagettfbbox($fontSize, 0, 'arial.ttf', $line)[2] - imagettfbbox($fontSize, 0, 'arial.ttf', $line)[0];
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, 'arial.ttf', $line);
    $lineHeight = imagettfbbox($fontSize, 0, 'arial.ttf', $line)[1] - imagettfbbox($fontSize, 0, 'arial.ttf', $line)[7];
    $y += $lineHeight + 10;
}
imagettftext($image, $fontSize, 0, $width - (strlen($bottomText) * $fontSize), $bottomTextY, $bottomTextColor, 'arial.ttf', $bottomText);
header('Content-Type: image/jpeg');
imagejpeg($image);
imagedestroy($image);
?>