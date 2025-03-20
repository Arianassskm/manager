<?php
include_once '../function.php';
$apiCardId = 101;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
function 接收参数($post_key, $get_key) {
    return isset($_POST[$post_key]) ? $_POST[$post_key] : (isset($_GET[$get_key]) ? $_GET[$get_key] : null);
}
function 检查参数是否为空($参数, $错误信息) {
    if (empty($参数)) {
        echo json_encode(['error' => $错误信息]);
        exit;
    }
}
function 获取QQ头像($qq, &$多线程句柄) {
    $头像链接 = "http://q1.qlogo.cn/g?b=qq&nk={$qq}&s=100";
    $头像句柄 = curl_init($头像链接);
    curl_setopt($头像句柄, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($头像句柄, CURLOPT_FAILONERROR, true);
    curl_multi_add_handle($多线程句柄, $头像句柄);
    return $头像句柄;
}
function 执行多线程请求(&$多线程句柄) {
    $运行状态 = null;
    do {
        curl_multi_exec($多线程句柄, $运行状态);
        curl_multi_select($多线程句柄);
    } while ($运行状态 > 0);
}
function 上传头像到目标接口($targetUrl, $avatarData, &$多线程句柄) {
    $上传句柄 = curl_init($targetUrl);
    curl_setopt($上传句柄, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($上传句柄, CURLOPT_POST, true);
    curl_setopt($上传句柄, CURLOPT_POSTFIELDS, [
        'images' => curl_file_create('data://image/jpeg;base64,' . base64_encode($avatarData))
    ]);
    curl_multi_add_handle($多线程句柄, $上传句柄);
    return $上传句柄;
}
function 上传文字到目标接口($targetUrl, $text, &$多线程句柄) {
    $上传句柄 = curl_init($targetUrl);
    curl_setopt($上传句柄, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($上传句柄, CURLOPT_POST, true);
    curl_setopt($上传句柄, CURLOPT_POSTFIELDS, [
        'texts' => $text
    ]);
    curl_multi_add_handle($多线程句柄, $上传句柄);
    return $上传句柄;
}
$path = 接收参数('path', 'path');
检查参数是否为空($path, '文件夹路径不能为空');
$type = 接收参数('type', 'type');
检查参数是否为空($type, 'type参数不能为空');
$targetBaseUrl = "http://meme.lovestory.wiki/memes/";
$targetUrl = $targetBaseUrl . rtrim($path, '/') . '/';
$多线程句柄 = curl_multi_init();
if ($type === 'images') {
    $qq = 接收参数('qq', 'qq');
    检查参数是否为空($qq, 'QQ号不能为空');
    $头像句柄 = 获取QQ头像($qq, $多线程句柄);
    执行多线程请求($多线程句柄);
    $avatarData = curl_multi_getcontent($头像句柄);
    curl_multi_remove_handle($多线程句柄, $头像句柄);
    curl_close($头像句柄);
    if (!$avatarData) {
        echo json_encode(['error' => '无法获取QQ头像']);
        curl_multi_close($多线程句柄);
        exit;
    }
    $上传句柄 = 上传头像到目标接口($targetUrl, $avatarData, $多线程句柄);
} elseif ($type === 'texts') {
    $msg = 接收参数('msg', 'msg');
    检查参数是否为空($msg, 'msg参数不能为空');
    $上传句柄 = 上传文字到目标接口($targetUrl, $msg, $多线程句柄);
} else {
    echo json_encode(['error' => 'type参数值不合法，允许的值为 images 或 texts']);
    curl_multi_close($多线程句柄);
    exit;
}
执行多线程请求($多线程句柄);
$response = curl_multi_getcontent($上传句柄);
curl_multi_remove_handle($多线程句柄, $上传句柄);
curl_close($上传句柄);
curl_multi_close($多线程句柄);
if (empty($response)) {
    echo json_encode(['error' => '上传失败']);
    exit;
}
header('Content-Type: image/jpeg');
echo $response;