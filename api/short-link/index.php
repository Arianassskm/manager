<?php
include_once '../function.php';
$apiCardId = 51;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
header('Content-Type: application/json');
$redisHost = 'localhost';
$redisPort = 6379;
$redis = new Redis();
try {
    $redis->connect($redisHost, $redisPort);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'code' => 500,
        'success' => false,
        'error' => '数据库异常(一般是redis没安装，或者redis出错了!)' . $e->getMessage()
    ]);
    exit;
}
function completeUrlProtocol($url) {
    if (!preg_match('/^(https?:\/\/)/i', $url)) {
        $url = 'https://' . $url;
    }
    return filter_var($url, FILTER_VALIDATE_URL) ?: 'http://' . $url;
}
function generateShortCode() {
    return bin2hex(random_bytes(3));
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['url'])) {
    $original_url = $_GET['url'];
    $original_url = completeUrlProtocol($original_url);

    if (!$original_url) {
        http_response_code(400);
        echo json_encode([
            'code' => 400,
            'success' => false,
            'error' => '该短链没有记录到数据库中...'
        ]);
        exit;
    }
    $short_code = generateShortCode();
    $redis_key = 'url:' . $short_code;
    $redis->set($redis_key, $original_url, 3600);
    $short_url = "http://" . $_SERVER['HTTP_HOST'] . "/api/short-link/?code=" . $short_code;
    http_response_code(201);
    echo json_encode([
        'code' => 201,
        'success' => true,
        'url' => $short_url
    ]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['code'])) {
    $short_code = $_GET['code'];
    $original_url = $redis->get('url:' . $short_code);

    if ($original_url) {
        header("Location: " . $original_url);
        exit;
    } else {
        http_response_code(404);
        echo json_encode([
            'code' => 404,
            'success' => false,
            'error' => '该短链没有记录到数据库中...'
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'code' => 400,
        'success' => false,
        'error' => '参数没填呢!'
    ]);
}
?>