<?php
include_once '../function.php';
$apiCardId = 46;
if (!isset($_GET['username'])) {
    echo "请输入账号";
    exit;
}
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
function getImageByAction($action, $time = null) {
    $directory = __DIR__ . '/';
    $files = scandir($directory);
    $images = array_filter($files, function($file) {
        return preg_match('/^\d+\.jpg$/', $file);
    });

    switch ($action) {
        case 'img':
            return getMaxImageByDate($images, $directory);
        case 'date':
            if ($time && in_array($time . '.jpg', $images)) {
                return $directory . $time . '.jpg';
            } else {
                return "照片未找到";
            }
        default:
            return "请输入参数及有效参数";
    }
}

function getMaxImageByDate($images, $directory) {
    $latestDate = 0;
    $latestImage = null;
    foreach ($images as $image) {
        $imageDate = intval(substr($image, 0, 8));
        if ($imageDate > $latestDate) {
            $latestDate = $imageDate;
            $latestImage = $image;
        }
    }
    return $latestImage ? $directory . $latestImage : "No images found.";
}
$action = isset($_GET['action']) ? $_GET['action'] : 'img';
$time = isset($_GET['time']) ? $_GET['time'] : null;
$imagePath = getImageByAction($action, $time);
if (strpos($imagePath, "Error") !== false) {
    echo $imagePath;
} else {
    header('Content-Type: image/jpeg');
    readfile($imagePath);
}