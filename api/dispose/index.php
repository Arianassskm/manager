<?php
include_once '../function.php';
$apiCardId = 52;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}

$apiKey = 'kxq6QELaGDtnZGyJeCJr5DYg';
$imageUrl = $_GET['url'] ?? null;

if (!$imageUrl) {
    die('图片链接参数没填');
}
$tempImageFilePath = 'temp_image.png';
$ch = curl_init($imageUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$imageData = curl_exec($ch);
if (curl_errno($ch)) {
    echo '当前接口使用线程过多，请稍后再试。' . curl_error($ch);
    curl_close($ch);
    exit;
}
curl_close($ch);
file_put_contents($tempImageFilePath, $imageData);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.remove.bg/v1.0/removebg');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['image_file' => new CURLFile($tempImageFilePath)]);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-Api-Key: ' . $apiKey
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo '当前接口使用线程过多，请稍后再试。' . curl_errno($ch) . "\n";
    echo '当前接口使用线程过多，请稍后再试。' . curl_error($ch) . "\n";
    curl_close($ch);
    exit;
}
$processedImageFilePath = 'processed_no-bg.png';
file_put_contents($processedImageFilePath, $response);
header('Content-Type: image/png');
readfile($processedImageFilePath);
unlink($tempImageFilePath);
unlink($processedImageFilePath);
curl_close($ch);

?>