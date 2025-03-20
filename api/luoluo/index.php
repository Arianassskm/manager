<?php
include_once '../function.php';
$apiCardId = 103;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET');
header('Access-Control-Allow-Headers:x-requested-with, content-type');
header('Content-Type: text/plain');
$kimiConfig = [
    'api_key' => 'sk-eRQacj3K0XxvQz56X6WldPMDvjjkKLOICiESppAUdPy7Jodh',
    'api_url' => 'https://api.moonshot.cn/v1/chat/completions',
];
function handleError($message, $code = 500) {
    http_response_code($code);
    echo $message;
    exit;
}
$redis = new Redis();
try {
    $redis->connect('127.0.0.1', 6379);
} catch (RedisException $e) {
    handleError('redis异常' . $e->getMessage());
}
$userQuery = $_GET['msg'] ?? '';
$userQuery = htmlspecialchars($userQuery, ENT_QUOTES, 'UTF-8');
if ($userQuery === '') {
    handleError('未提供有效问题参数', 400);
}
$cacheKey = 'personality_content';
$personality = $redis->get($cacheKey);
if ($personality === false) {
    $personalityFile = __DIR__ . '/1.txt';
    if (!file_exists($personalityFile)) {
        handleError("人设文件 $personalityFile 不存在");
    }
    $personalityContent = file_get_contents($personalityFile);
    if ($personalityContent === false) {
        handleError('人设文件读取失败');
    }
    $personality = trim($personalityContent);
    $redis->set($cacheKey, $personality);
}
$requestData = [
    'model' => 'moonshot-v1-8k',
    'messages' => [
        ['role' => 'system', 'content' => $personality],
        ['role' => 'user', 'content' => $userQuery]
    ],
    'temperature' => 0.3
];
$payload = json_encode($requestData);
$ch = curl_init($kimiConfig['api_url']);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $kimiConfig['api_key'],
        'Content-Length: ' . strlen($payload)
    ],
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($response === false) {
    handleError('落落异常');
}
$jsonResponse = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    handleError('落落异常');
}
if (isset($jsonResponse['choices'][0]['message']['content'])) {
    echo $jsonResponse['choices'][0]['message']['content'];
    exit;
}
handleError('落落异常', $httpCode);