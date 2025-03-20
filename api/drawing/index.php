<?php
include_once '../function.php';
$apiCardId = 60;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}

function request_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curlPost = http_build_query($param);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $postUrl);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}

$image_url = $_GET['url'] ?? null;
$option = $_GET['option'] ?? 'cartoon';
if (!$image_url) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => '请输入需要处理的图片链接']);
    exit;
}

$token = '24.b899fcd999154e3f39a916d5d23cb09b.2592000.1738122112.282335-116895894';
$url = 'https://aip.baidubce.com/rest/2.0/image-process/v1/style_trans?access_token=' . $token;
$img = file_get_contents($image_url);
if (!$img) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => '无法获取图片内容']);
    exit;
}

$img = base64_encode($img);
$bodys = array(
    'option' => $option,
    'image' => $img
);
$res = request_post($url, $bodys);
$res_array = json_decode($res, true);

if (isset($res_array['image'])) {
    $base64_image = $res_array['image'];
    $image_data = base64_decode($base64_image);
    if ($image_data === false) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Base64解码失败']);
        exit;
    }

    // 生成图片文件名，包含日期、小时、分钟和秒数
    $datetime = date('YmdHis');
    $image_filename = "image/$datetime.png";

    // 确保image文件夹存在
    if (!is_dir('image')) {
        mkdir('image', 0777, true);
    }

    // 保存图片到image文件夹
    file_put_contents($image_filename, $image_data);

    // 返回图片数据
    header('Content-Type: image/png');
    readfile($image_filename);
} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => '没有找到图片数据']);
    exit;
}