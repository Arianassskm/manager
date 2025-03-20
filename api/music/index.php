<?php
// 获取URL参数
$gm = isset($_GET['gm']) ? $_GET['gm'] : '';
$n = isset($_GET['n']) ? intval($_GET['n']) : 0;

// 如果没有传入gm参数，则返回错误
if (empty($gm)) {
    echo "Missing required parameter: gm";
    exit;
}

// 构造请求的API URL
$apiUrl = "https://www.hhlqilongzhu.cn/api/dg_wyymusic.php?gm=" . urlencode($gm);
if ($n > 0) {
    $apiUrl .= "&n=" . $n;
}

// 使用cURL发起请求
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// 检查API返回的数据
if (!$response) {
    echo "Failed to fetch data from the API";
    exit;
}

// 如果传入了n参数，解析并返回播放链接的JSON格式
if ($n > 0) {
    // 提取播放链接部分
    $playLink = null;
    if (preg_match('/播放链接：(.*?)\s*$/', $response, $matches)) {
        $playLink = trim($matches[1]);
    }

    if ($playLink) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'play_link' => $playLink
        ]);
    } else {
        echo "Play link not found in the API response";
    }
} else {
    // 仅传入gm参数，直接输出纯文本
    header('Content-Type: text/plain; charset=utf-8');
    echo $response;
}