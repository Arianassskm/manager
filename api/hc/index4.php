<?php
if (!extension_loaded('gd')) {
    die('GD库没安装');
}
$msg = $_GET['msg'] ?? '';
$breakChar = ">";
$imageDir = 'img/';
if (!is_dir($imageDir)) {
    die('指定的图片文档夹不存在');
}
$imageFiles = array_filter(scandir($imageDir), function($file) use ($imageDir) {
    return is_file($imageDir . $file) && in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
});
if (empty($imageFiles)) {
    die('图片文档夹中没有图片文档');
}
$imagePath = $imageDir . $imageFiles[array_rand($imageFiles)];
if (!is_readable($imagePath)) {
    die('无法读取图片文档: ' . $imagePath);
}
list($width, $height, $type) = getimagesize($imagePath);
switch ($type) {
    case IMAGETYPE_JPEG:
        $image = imagecreatefromjpeg($imagePath);
        break;
    case IMAGETYPE_PNG:
        $image = imagecreatefrompng($imagePath);
        break;
    case IMAGETYPE_GIF:
        $image = imagecreatefromgif($imagePath);
        break;
    case IMAGETYPE_WEBP:
        $image = imagecreatefromwebp($imagePath);
        break;
    default:
        die('不支持的图片格式: ' . $imagePath);
}
$fontSize = 25;
$bottomTextY = $height - 40;
$bottomText = "";
$bottomTextColor = imagecolorallocate($image, 255, 255, 255);
$x = 55;
$y = 50;
if (filter_var($msg, FILTER_VALIDATE_URL)) {
    $response = file_get_contents($msg);
    if ($response !== false) {
        $msg = str_replace('<br>', "/", $response);
    } else {
        $msg = "无法从接口获取数据";
    }
}
$lines = explode($breakChar, $msg);
foreach ($lines as $line) {
    $textColor = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    $textWidth = imagettfbbox($fontSize, 0, '1.ttf', $line)[2] - imagettfbbox($fontSize, 0, '1.ttf', $line)[0];
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, '1.ttf', $line);
    $lineHeight = imagettftext($image, $fontSize, 0, $x, $y, $textColor, '1.ttf', $line)[1] - imagettftext($image, $fontSize, 0, $x, $y, $textColor, '1.ttf', $line)[7];
    $y += $lineHeight + 10;
}
imagettftext($image, $fontSize, 0, $width - (strlen($bottomText) * $fontSize), $bottomTextY, $bottomTextColor, '1.ttf', $bottomText);
switch ($type) {
    case IMAGETYPE_JPEG:
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        break;
    case IMAGETYPE_PNG:
        header('Content-Type: image/png');
        imagepng($image);
        break;
    case IMAGETYPE_GIF:
        header('Content-Type: image/gif');
        imagegif($image);
        break;
    case IMAGETYPE_WEBP:
        header('Content-Type: image/webp');
        imagewebp($image);
        break;
}
imagedestroy($image);
?>