<?php
$msg=$_REQUEST["msg"]?:"随机一言";//需要查看的类型(目前支持安慰语录、QQ签名、趣味笑话、随机一言、英汉语录、毒鸡汤、爱情语录、文案温柔、伤感语录、舔狗日记、社会语录、诗词、骚话、经典语录、情话、人生话语、我在人间凑数的日子、网易语录)(默认随机一言)
$type=$_REQUEST["type"]?:"text";//返回格式，默认json可选text、js

//合并
$jk=array(
"安慰语录"=>"data/wenben/Comforting.txt",
"QQ签名"=>"data/wenben/qianming.txt",
"趣味笑话"=>"data/wenben/qwxh.txt",
"随机一言"=>"data/wenben/yan.txt",
"英汉语录"=>"data/wenben/yhyl.txt",
"毒鸡汤"=>"data/wenben/dujitang.txt",
"爱情语录"=>"data/wenben/aiqing.txt",
"温柔语录"=>"data/wenben/wenrou.txt",
"伤感语录"=>"data/wenben/shanggan.txt",
"舔狗日记"=>"data/wenben/tiangou.txt",
"社会语录"=>"data/wenben/shehui.txt",
"诗词"=>"data/wenben/sc1.txt",
"骚话"=>"data/wenben/saohua.txt",
"经典语录"=>"data/wenben/jdyl.txt",
"情话"=>"data/wenben/qinghua.txt",
"人生话语"=>"data/wenben/rshy.txt",
"网易语录"=>"data/wenben/wyyl.txt",
"我在人间凑数的日子"=>"data/wenben/renjian.txt");

//获取句子文件的绝对路径
$path = dirname(__FILE__);
$file = file($path."/".$jk[$msg]."");
 
//随机读取一行
$arr  = mt_rand( 0, count( $file ) - 1 );
$content  = trim($file[$arr]);

//编码判断，用于输出相应的响应头部编码
if (isset($_GET['charset']) && !empty($_GET['charset'])) {
    $charset = $_GET['charset'];
    if (strcasecmp($charset,"gbk") == 0 ) {
        $content = mb_convert_encoding($content,'gbk', 'utf-8');
    }
} else {
    $charset = 'utf-8';
}
 
//格式化判断，输出js或纯文本
if (''.$type.'' === 'js') {
    echo "function yiyan(){document.write('" . $content ."');}";
}else if(''.$type.'' === 'json'){
    header('Content-type:text/json');
    $content = array('text'=>$content);
    echo json_encode($content, JSON_UNESCAPED_UNICODE);
}else {
    echo $content;
}
?>