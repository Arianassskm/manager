<?php
// 引入 Composer 自动加载文件
include_once '/www/wwwroot/接口/api/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// 获取二维码内容
$qrContent = isset($_GET['content']) ? $_GET['content'] : 'https://example.com';

// 创建二维码
$qrCode = new QrCode($qrContent);
$qrCode->setSize(300);
$qrCode->setMargin(10);

// 写入二维码为 PNG 格式
$writer = new PngWriter();
$result = $writer->writeString($qrCode);

// 保存二维码到临时文件
$tempQrPath = tempnam(sys_get_temp_dir(), 'qr_');
file_put_contents($tempQrPath, $result);

// 使用 GD 库打开二维码图像
$qrImage = imagecreatefrompng($tempQrPath);

// 随机生成边框宽度和颜色
$borderWidth = rand(1, 3);
$borderColor = imagecolorallocate($qrImage, rand(0, 255), rand(0, 255), rand(0, 255));

// 创建更大的图像用于添加边框
$newWidth = imagesx($qrImage) + $borderWidth * 2;
$newHeight = imagesy($qrImage) + $borderWidth * 2;
$borderedQr = imagecreatetruecolor($newWidth, $newHeight);

// 填充边框颜色
imagefill($borderedQr, 0, 0, $borderColor);

// 将二维码复制到带边框的图像中心
imagecopy($borderedQr, $qrImage, $borderWidth, $borderWidth, 0, 0, imagesx($qrImage), imagesy($qrImage));

// 保存带边框的二维码到临时文件
$borderedQrPath = tempnam(sys_get_temp_dir(), 'bordered_qr_');
imagepng($borderedQr, $borderedQrPath);

// 释放 GD 图像资源
imagedestroy($qrImage);
imagedestroy($borderedQr);

// 随机选择一个水印 GIF 图片
$gifFiles = glob('img/*.gif');
if (!empty($gifFiles)) {
    $randomGif = $gifFiles[array_rand($gifFiles)];

    try {
        // 使用 Imagick 打开 GIF 动图
        $gif = new Imagick($randomGif);
        $gif = $gif->coalesceImages();

        // 创建新的 Imagick 对象用于存储合并后的帧
        $outputGif = new Imagick();

        // 设置水印透明度
        $transparency = 55;

        // 遍历 GIF 的每一帧
        foreach ($gif as $frame) {
            $currentFrame = clone $frame;

            // 调整帧大小与二维码一致
            $currentFrame->scaleImage($newWidth, $newHeight);

            // 设置透明度
            $currentFrame->evaluateImage(Imagick::EVALUATE_MULTIPLY, (100 - $transparency) / 100, Imagick::CHANNEL_ALPHA);

            // 打开带边框的二维码
            $borderedQrImagick = new Imagick($borderedQrPath);

            // 将当前帧与带边框的二维码合并
            $borderedQrImagick->compositeImage($currentFrame, Imagick::COMPOSITE_OVER, 0, 0);

            // 设置帧延迟
            $delay = $currentFrame->getImageDelay();
            $borderedQrImagick->setImageDelay($delay);

            // 设置图像页面属性
            $borderedQrImagick->setImagePage($newWidth, $newHeight, 0, 0);

            // 将合并后的帧添加到输出动图中
            $outputGif->addImage($borderedQrImagick);

            // 释放资源
            $currentFrame->destroy();
            $borderedQrImagick->destroy();
        }

        // 设置输出 GIF 的格式
        $outputGif->setImageFormat('gif');

        // 优化 GIF 以减小文件大小
        $outputGif->optimizeImageLayers();

        // 输出最终的 GIF 动图
        header('Content-Type: image/gif');
        echo $outputGif->getImagesBlob();

        // 释放 Imagick 资源
        $gif->destroy();
        $outputGif->destroy();

    } catch (ImagickException $e) {
        echo 'Imagick error: '. $e->getMessage();
    }
} else {
    // 如果没有找到 GIF 图片，输出带边框的二维码
    header('Content-Type: image/png');
    readfile($borderedQrPath);
}

// 删除临时文件
unlink($tempQrPath);
unlink($borderedQrPath);