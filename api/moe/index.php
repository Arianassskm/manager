<?php
include_once '../function.php';
$apiCardId = 44;
$username = $_GET['username'];
$result = checkAndProcessApiCall($apiCardId, $username);
if ($result !== true) {
    echo $result;
    exit;
}
?>
<?php
$qq = $_GET["qq"];
$numble = $_GET["numble"] ?? null;

if ($qq == '') {
    header("Content-type: text/html; charset=utf-8");
    echo 'QQ参数为空';
} else {
    header("Content-type:image/png");
    $image = imagecreatetruecolor(720,720);
    $white = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $white);
    $qqimage1 = imagecreatefromstring(file_get_contents('https://q4.qlogo.cn/g?b=qq&nk='.$qq.'&s=640'));
    if (is_null($numble) || !is_numeric($numble) || $numble < 1 || $numble > 92) {
        $files = glob('images/*.png');
        if (count($files) > 0) {
            $numble = $files[array_rand($files)];
        } else {
            header("Content-type: text/html; charset=utf-8");
            echo '没有找到背景图片';
            exit;
        }
    } else {
        $numble = 'images/' . $numble . '.png';
        if (!file_exists($numble)) {
            header("Content-type: text/html; charset=utf-8");
            echo '指定的背景图片不存在';
            exit;
        }
    }
    $qianimg = imagecreatefrompng($numble);
    imagecopyresized($image, $qianimg, 0, 0, 0, 0, 720, 720, 700, 700);
    $头像宽度 = 90;
    $头像高度 = 90;
    $头像x = imagesx($qqimage1);
    $头像y = imagesy($qqimage1);
    $缩放头像 = imagecreatetruecolor($头像宽度, $头像高度);
    imagecopyresampled($缩放头像, $qqimage1, 0, 0, 0, 0, $头像宽度, $头像高度, $头像x, $头像y);
    $圆心X = $头像宽度 / 2;
    $圆心Y = $头像高度 / 2;
    $半径 = min($头像宽度, $头像高度) / 2;
    $圆 = imagecreatetruecolor($头像宽度, $头像高度);
    $透明色 = imagecolorallocatealpha($圆, 0, 0, 0, 127);
    imagefill($圆, 0, 0, $透明色);
    for ($x = 0; $x < $头像宽度; $x++) {
        for ($y = 0; $y < $头像高度; $y++) {
            if (pow($x - $圆心X, 2) + pow($y - $圆心Y, 2) < pow($半径, 2)) {
                $color = imagecolorat($缩放头像, $x, $y);
                imagesetpixel($圆, $x, $y, $color);
            } else {
                imagesetpixel($圆, $x, $y, $透明色);
            }
        }
    }
    imagealphablending($圆, false);
    imagesavealpha($圆, true);
    imagecopy($image, $圆, 50, 625, 0, 0, $头像宽度, $头像高度);
    imagepng($image);
    imagedestroy($qqimage1);
    imagedestroy($qianimg);
    imagedestroy($缩放头像);
    imagedestroy($圆);
    imagedestroy($image);
}
?>