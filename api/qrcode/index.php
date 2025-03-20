<?php
include_once '../function.php';
$apiCardId = 95;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
include_once '/www/wwwroot/接口/api/vendor/autoload.php';
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
$qrContent = isset($_GET['content']) ? $_GET['content'] : 'https://api.lovestory.wiki';
$qrCode = new QrCode($qrContent);
$qrCode->setSize(300);
$qrCode->setMargin(10);
$writer = new PngWriter();
$result = $writer->writeString($qrCode);

// 将图像保存到临时文件
$tempQrPath = tempnam(sys_get_temp_dir(), 'qr_');
file_put_contents($tempQrPath, $result);

// 打开二维码图像
$qrImage = imagecreatefrompng($tempQrPath);

// 随机生成边框宽度和颜色
$borderWidth = rand(1, 3);
$borderColor = imagecolorallocate($qrImage, rand(0, 255), rand(0, 255), rand(0, 255));

// 创建一个更大的图像用于添加边框
$newWidth = imagesx($qrImage) + $borderWidth * 2;
$newHeight = imagesy($qrImage) + $borderWidth * 2;
$newImage = imagecreatetruecolor($newWidth, $newHeight);

// 填充边框颜色
imagefill($newImage, 0, 0, $borderColor);

// 将二维码图像复制到新图像中心
imagecopy($newImage, $qrImage, $borderWidth, $borderWidth, 0, 0, imagesx($qrImage), imagesy($qrImage));
$watermarkFiles = array_merge(
    glob('img/*.png'),
    glob('img/*.jpg'),
    glob('img/*.jpeg'),
    glob('img/*.gif')
);
if (!empty($watermarkFiles)) {
    $randomWatermark = $watermarkFiles[array_rand($watermarkFiles)];
    $fileExtension = strtolower(pathinfo($randomWatermark, PATHINFO_EXTENSION));
    switch ($fileExtension) {
        case 'png':
            $watermark = imagecreatefrompng($randomWatermark);
            break;
        case 'jpg':
        case 'jpeg':
            $watermark = imagecreatefromjpeg($randomWatermark);
            break;
        case 'gif':
            $imagick = new \Imagick($randomWatermark);
            $imagick->setIteratorIndex(0);
            $watermark = imagecreatefromstring($imagick->getImageBlob());
            $imagick->destroy();
            break;
        default:
            $watermark = null;
            break;
    }
    if ($watermark) {
        $watermarkWidth = imagesx($qrImage);
        $watermarkHeight = imagesy($qrImage);
        $resizedWatermark = imagecreatetruecolor($watermarkWidth, $watermarkHeight);
        imagecopyresampled($resizedWatermark, $watermark, 0, 0, 0, 0, $watermarkWidth, $watermarkHeight, imagesx($watermark), imagesy($watermark));
        $transparency = 55;
        imagecopymerge($newImage, $resizedWatermark, $borderWidth, $borderWidth, 0, 0, $watermarkWidth, $watermarkHeight, $transparency);
        imagedestroy($watermark);
        imagedestroy($resizedWatermark);
    }
}
header('Content-Type: image/png');
imagepng($newImage);
imagedestroy($qrImage);
imagedestroy($newImage);
unlink($tempQrPath);