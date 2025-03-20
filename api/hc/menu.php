<?php
$msg = $_GET['msg'] ?? '';
$colors = $_GET['colors'] ?? '';
$breakChar = $_GET['break'] ?? '/';
$imageDir = 'image/';
if (!is_dir($imageDir)) {
    die('指定的图片目录不存在');
}
$imageFiles = array_filter(scandir($imageDir), function ($file) use ($imageDir) {
    return is_file($imageDir . $file) && in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
});
if (empty($imageFiles)) {
    die('图片目录中没有图片文件');
}
$imagePath = $imageDir . $imageFiles[array_rand($imageFiles)];
if (!is_readable($imagePath)) {
    die('无法读取图片文件: ' . $imagePath);
}
$image = new Imagick($imagePath);
$colorMap = [
    'red' => 'red',
    'blue' => 'blue',
    'green' => 'green',
    'yellow' => 'yellow',
    'orange' => 'orange',
    'purple' => 'purple',
    'black' => 'black',
    'white' => 'white',
];
$colorArray = explode(',', $colors);
$lines = explode($breakChar, $msg);
$fontPath = __DIR__ . '/1.ttf';
if (!file_exists($fontPath)) {
    die('字体文件不存在: ' . $fontPath);
}
$fontSize = 13;
$x = 225;
$y = 40;
$draw = new ImagickDraw();
foreach ($lines as $index => $line) {
    $currentColorName = isset($colorArray[$index % count($colorArray)]) ? $colorArray[$index % count($colorArray)] : 'white';
    if (!isset($colorMap[$currentColorName])) {
        $currentColorName = 'white';
    }
    $currentColor = $colorMap[$currentColorName];
    $draw->setFillColor($currentColor);
    $draw->setFont($fontPath);
    $draw->setFontSize($fontSize);
    $draw->annotation($x, $y, $line);
    $y += $fontSize + 5;
}
$originalApiUrl = 'https://api.lovestory.wiki/api/yulu/?type=%E6%83%85%E8%AF%9D';
$originalApiMsg = file_get_contents($originalApiUrl);
if ($originalApiMsg === false) {
    $originalApiMsg = '无法从接口获取数据';
}
if (mb_strlen($originalApiMsg, 'UTF-8') > 30) {
    $originalApiMsg = mb_substr($originalApiMsg, 0, 30, 'UTF-8') . '...';
}
$originalApiTextColor = 'white';
$originalApiTextColorHex = $colorMap[$originalApiTextColor];
$originalApiTextFontSize = 30;
$originalApiTextX = 380;
$originalApiTextY = 1037;
$draw->setFillColor($originalApiTextColorHex);
$draw->setFont($fontPath);
$draw->setFontSize($originalApiTextFontSize);
$draw->annotation($originalApiTextX, $originalApiTextY, $originalApiMsg);
$newApiUrl = 'https://api.lovestory.wiki/api/bot.php?display=apis';
$newApiMsg = file_get_contents($newApiUrl);
if ($newApiMsg === false) {
    $newApiMsg = '调用详情接口异常';
}
$newApiMsg = str_replace('<br>', "\n", $newApiMsg);
$newApiLines = explode("\n", $newApiMsg);
$newApiTextColor = 'white';
$newApiTextColorHex = $colorMap[$newApiTextColor];
$newApiTextFontSize = 15;
$newApiTextX = 1693;
$newApiTextY = 14;
foreach ($newApiLines as $index => $newApiLine) {
    $draw->setFillColor($newApiTextColorHex);
    $draw->setFont($fontPath);
    $draw->setFontSize($newApiTextFontSize);
    $draw->annotation($newApiTextX, $newApiTextY, $newApiLine);
    $newApiTextY += $newApiTextFontSize + 5;
}
$timeColor = 'white';
$timeColorHex = $colorMap[$timeColor];
$timeFontSize = 30;
$timeX = 38;
$timeY = 1030;
$currentTime = date('Y-m-d H:i:s');
$draw->setFillColor($timeColorHex);
$draw->setFont($fontPath);
$draw->setFontSize($timeFontSize);
$draw->annotation($timeX, $timeY, $currentTime);
$apiImageUrl = 'https://jk.lovestory.wiki/%E5%9B%BE%E7%89%87/%E4%B8%8B%E8%BD%BD.png';
$apiImageData = @file_get_contents($apiImageUrl);
if ($apiImageData === false) {
    die('无法从接口获取图片');
}
$apiImage = new Imagick();
$apiImage->readImageBlob($apiImageData);
$apiImageWidth = 272;
$apiImageHeight = 275;
$apiImage->resizeImage($apiImageWidth, $apiImageHeight, Imagick::FILTER_LANCZOS, 1);
$apiImageX = 42;
$apiImageY = 700;
$image->compositeImage($apiImage, Imagick::COMPOSITE_OVER, $apiImageX, $apiImageY);
$image->drawImage($draw);
$image->setImageFormat('png');
header('Content-Type: image/png');
echo $image->getImageBlob();
$image->clear();
$image->destroy();
$apiImage->clear();
$apiImage->destroy();
?>