<?php
function aizongjie($content, $max_tokens = 100) {
    $apiKey = "sk-eRQacj3K0XxvQz56X6WldPMDvjjkKLOICiESppAUdPy7Jodh";
    $apiUrl = "https://api.moonshot.cn/v1/chat/completions";
    $model = "moonshot-v1-8k";
    $postData = [
        "model" => $model,
        "messages" => [
            [
                "role" => "system",
                "content" => "你叫落落，输出内容时需要说明你的名字，例如:落落觉得，落落认为...请用二次元风格的说话方式但是不需要开头说“二次元风:”，还需要多种颜文字表情和emoji标签，最后用50字左右对以下内容进行描述然后添加落落的QQ是3420802604，并且千万要总结完并且严格控制在50个字符以内："
            ],
            [
                "role" => "user",
                "content" => $content
            ]
        ],
        "max_tokens" => $max_tokens
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);
    if (isset($response["choices"][0]["message"]["content"])) {
        return nl2br($response["choices"][0]["message"]["content"]);
    }
}
?>