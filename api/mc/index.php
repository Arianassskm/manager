<?php
include_once '../function.php';
$apiCardId = 47;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
$arr=file('index.txt');
$n=count($arr)-1;
for ($i=1;$i <=1;$i++){
$x=rand(0,$n);
header("Location:".$arr[$x],"\n");
}
?>