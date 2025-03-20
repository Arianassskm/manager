<?php
include_once '../function.php';
$apiCardId = 50;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}


$html = file_get_contents("LookIdiom.json"); 
$result = preg_match_all('/{"图片":"(.*?)","答案":"(.*?)"}/',$html,$arr);
$response = [
    'status' => 200,
    'data' => [],
    'error' => null,
];

if($result == 0){
    $response['status'] = 401;
    $response['error'] = '接口异常，请联系管理员修复。';
} else {
    $rand = rand(0, $result - 1);
    $imageUrl = "http://api.lovestory.wiki/api/idiom/img/" . urlencode($arr[1][$rand]);
    $answer = $arr[2][$rand];
    $response['data']['image'] = $imageUrl;
    $response['data']['answer'] = $answer;
}
echo json_encode($response);
?>