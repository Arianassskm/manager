<?php
include_once '../function.php';
$apiCardId = 57;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
$url = $_GET['url'];
if(!isset($url)) {
  exit("视频链接参数不全");
}
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_exec($ch);
$headers = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
preg_match('/photoId=(.*?)&/', $headers, $matches);
$realUrl = "https://www.kuaishou.com/short-video/".$matches[1];
curl_close($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $realUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
  'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36',
  'Content-Type: application/x-www-form-urlencoded',
  'Cookie: did=web_a6dbfc25519a4f3d8ef77051d4197d57; didv='.(time() * 1000).'; kpf=PC_WEB; clientid=3; ',
  'Accept-Language: zh-CN,zh;q=0.9',
]);
$response = curl_exec($ch);
curl_close($ch);
$startString = '"},"VisionVideoDetailPhoto:';
$endString = ',"$VisionVideoDetailPhoto:';
$startPosition = strpos($response, $startString);
$endPosition = strpos($response, $endString);
$content = substr($response, $startPosition + strlen($startString), $endPosition - $startPosition - strlen($startString));
$result = substr($content, strpos($content, '":') + 2);
echo $result;

?>