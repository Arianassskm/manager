<?php
include_once '../function.php';
$apiCardId = 58;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
include 'lib/IpLocation.php';
$ip = $_GET['ip'];
if (empty($ip)) {
    $ip = $_SERVER["REMOTE_ADDR"];
}
$ipadress = new IpLocation();
$location = $ipadress->getlocation($ip);	
$city = str_replace('–', '', $location['country']);
$response = array(
    "code" => 200,
    "msg" => "请求成功",
    "data" => array(
        "city" => $city
    )
);
exit(json_encode($response,480));