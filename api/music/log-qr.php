<?php
// 设置响应头，告诉浏览器这是一个图片响应
header('Content-Type: image/png');

// 请求第一个接口获取unikey
$keyUrl = 'http://music.lovestory.wiki/login/qr/key';
$keyResponse = file_get_contents($keyUrl);
$keyData = json_decode($keyResponse, true);

if ($keyData['code'] == 200 && isset($keyData['data']['unikey'])) {
    $unikey = $keyData['data']['unikey'];

    // 使用unikey请求第二个接口
    $qrUrl = "http://music.lovestory.wiki/login/qr/create?qrimg=true&key=" . urlencode($unikey);
    $qrResponse = file_get_contents($qrUrl);
    $qrData = json_decode($qrResponse, true);

    if ($qrData['code'] == 200 && isset($qrData['data']['qrimg'])) {
        // 解码base64图片数据并输出
        $base64Image = $qrData['data']['qrimg'];
        $imageData = base64_decode(str_replace('data:image/png;base64,', '', $base64Image));
        echo $imageData;
    } else {
        echo "Failed to get QR image data.";
    }
} else {
    echo "Failed to get unikey.";
}
?>