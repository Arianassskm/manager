<?php
// 设置响应头为纯文本格式
header('Content-Type: text/plain');

// 构造请求URL
$requestUrl = "http://music.lovestory.wiki/login/qr/key";

// 使用cURL发起请求
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if (!$response) {
    // 如果请求失败，返回错误信息
    echo "请求失败";
    exit;
}

// 解析返回的JSON数据
$responseData = json_decode($response, true);

if ($responseData['code'] != 200 || !isset($responseData['data']['unikey'])) {
    // 如果返回的code不是200或没有unikey字段，返回错误信息
    echo "请求失败或数据格式错误";
    exit;
}

// 获取unikey字段的值
$unikey = $responseData['data']['unikey'];

// 以纯文本形式返回unikey
echo $unikey;
?>