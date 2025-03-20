<?php
include_once '../function.php';
$apiCardId = 44;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $outputName = 'screenshot.jpg'; 
    $command = "wkhtmltoimage --quality 100 --width 1024 --height 768 " . escapeshellarg($url) . " " . escapeshellarg($outputName);
    shell_exec($command);
    header('Content-Type: image/jpeg');
    header('Content-Disposition: inline; filename="' . $outputName . '"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    header('Expires: 0');
    readfile($outputName);
    unlink($outputName); 
} else {
    header('HTTP/1.1 400 Bad Request');
    echo 'Error: URL parameter is missing.';
}
?>