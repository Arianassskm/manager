<?php
include_once '../function.php';
$apiCardId = 41;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}


$url = 'https://spark-api-open.xf-yun.com/v1/chat/completions';
$apiPassword = '';//密钥

// 请求头
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiPassword
];

// 从GET请求中获取content参数
$content = isset($_GET['content']) ? $_GET['content'] : '你好，讯飞星火';

// 请求体
$data = [
    "model" => "lite", // 指定请求的模型
    "messages" => [[
        "role" => "user",
        "content" => $content // 动态设置用户的问题
    ]],
    "response_format" => [ // 添加response_format参数
        "type" => "text"
    ],
    "stream" => false // 是否流式返回结果
];

// 将请求体转换为JSON格式
$json_data = json_encode($data);

// 初始化cURL会话
$ch = curl_init($url);

// 设置cURL选项
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

// 执行cURL请求
$response = curl_exec($ch);

// 检查是否有cURL错误发生
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    // 关闭cURL会话
    curl_close($ch);

    // 解析响应
    $response_data = json_decode($response, true);
    if (isset($response_data['error'])) {
        // 打印错误信息
        echo json_encode([
            'code' => $response_data['error']['code'] ?? null,
            'message' => $response_data['error']['message'] ?? 'Unknown error'
        ]);
    } else {
        // 提取需要的字段并直接返回content
        $extracted_response = [
            'code' => $response_data['code'] ?? null,
            'message' => $response_data['message'] ?? null,
            'content' => $response_data['choices'][0]['message']['content'] ?? null
        ];
        // 直接返回content字段，不进行JSON编码
        echo $extracted_response['content'];
    }
}

?>