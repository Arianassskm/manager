<!--
代码出错可以修改
希望生活也能像代码 可以及时修改错误 
--花间舞半曲

重置第一版: 2025-03-03 23:30:00
--动态背景图及动态效果 (壁纸本地化) (移动设备横版图片自适应) (壁纸过滤效果)
--顶部菜单栏 参考B站UP主 莜莱Ceale

2025-03-04 18:30:00
--新增各种页面的遮盖层 加载窗 可以通过api定义遮盖层效果
!-->

<!--
(如果需要更改壁纸过滤效果 壁纸以及相关配置请查看 "assets/js/index.js" )
---过滤效果: 44行
---背景图片: 45行-46行 (壁纸存放地址assets/bg-img)
---背景图片自动切换时间: 158行

部分js变量名 方法名说明：
 --huabu (画布)
 --huabuwenli (画布纹理)
 --xingxing (星星)
 --daxiao (大小)
 --toumingdu (透明度)
 --beijingrongqi (背景容器)
 --beijingceng (背景层)
 --xianzhiceng (限制层)

 --huodexiayizhang (获取下一张)
 --yingyongguodu (应用过渡)
 --yingyongxiaoguo (应用效果)
 --chuangjianceng (创建层)
!-->
<?php
require 'public/header.php';
$classes = huoqushuju($pdo, "SELECT id, name FROM api_classify");
$apis = huoqushuju($pdo, "SELECT id, api_name, api_url, api_jianjie, api_state, api_toll, api_source, api_price, api_update, api_data, api_counter, harging_method FROM api_card");
$websiteid = 1;
$website = huoqudange($pdo, "SELECT id, site_name, site_description, site_keywords, site_icon, site_url, footer_content, site_icp, site_security, site_moe, site_announcement, site_time, website_time, site_sakura FROM site_info WHERE id = ?", [$websiteid]);
$userid = 1;
$user = huoqudange($pdo, "SELECT id, username, user_qq FROM users WHERE id = ?", [$userid]);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo nl2br($website['site_name']); ?></title>
  <link rel="icon" type="image/ico" href="<?php echo nl2br($website['site_icon']); ?>">
  <meta name="keywords" content="<?php echo nl2br($website['site_keywords']); ?>">
  <meta name="description" content="<?php echo nl2br($website['site_description']); ?>">
  <script src="./assets/js/jqury.js"></script>
  <link href="./assets/css/box.css" rel="stylesheet">
  <link href="./assets/css/api.css" rel="stylesheet">
  <script>
   document.addEventListener('visibilitychange',function(){if(document.visibilityState=='hidden'){normal_title=document.title;document.title='(☍﹏⁰。)补药走啊!!!(◞‸◟)'}else document.title=normal_title});
  </script>
</head>
<body>
<!--导航栏-->
<?php include'public/head.php';?>
<!--api卡片盒子-->
<div id="app">
  <div class="container">
    <a href="#">
     <?php foreach ($apis as $api): $datetime = $api['api_data'] ?? '';$date = substr($datetime, 0, 10);?>
      <div class="contentbox">
          <h2><a class="random-color" href="api.php?id=<?php echo $api['id']; ?>"><?php echo $api['api_name']; ?></a></h2>
              <div class="box" style="font-size: 12px;margin-left: 10px;margin-right: 10px">
                <?php echo $api['api_jianjie']; ?>
              </div>
            <div class="hr-container">
              <hr class="custom-hr" />
            </div>
           <i class="el-icon-alarm-clock icon-index"> <?php echo htmlspecialchars($date); ?> </i> </i>
           <i class="el-icon-postcard icon-index"> <?php echo $api['harging_method']; ?> </i>
           <i class="el-icon-wallet icon-index"> <?php echo $api['api_price']; ?> </i>  
      </div>
     <?php endforeach; ?> 
    </a>
  </div>
</div>
<div class="foot-box"></div>
<!--底栏-->
<?php include'public/foot.php';?>
<!-- 遮盖层配置
属性名	描述	
data-background	背景颜色（RGBA格式）
data-blur	模糊强度	
data-spinner-color	旋转图标颜色
data-fade-duration	淡入淡出时间 
data-zindex	z-index值	（请确保修改的值为整个系统的最大值 否则会导致加载遮盖层异常）
data-mode	显示模式（1=网站资源加载时间,2=固定/3秒,3=随机/3到5秒）
-->
<script 
src="./assets/js/load.js"
data-background="rgba(255,255,255,0.8)"
data-blur="15px"
data-spinner-color="#ff5722"
data-fade-duration="1s"
data-mode="2">
</script>

<!-- 页面弹窗整体配置
属性名	描述   默认值
data-background	背景颜色（RGBA格式）	rgba(0,0,0,0.8)
data-blur	模糊强度	10px
data-fade-duration	淡入淡出时间	0.3s
data-zindex	z-index值	2147483647
data-auto-show	是否自动显示	false
data-auto-hide	是否自动隐藏	false
data-show-delay	自动显示延迟（毫秒）	0
data-hide-delay	自动隐藏延迟（毫秒）	5000
-->
<script
src="./assets/js/modal.js"
data-background="rgba(0,0,0,0.6)"
data-blur="12px"
data-fade-duration="0.4s"
data-zindex="99999"
data-auto-show="false"
data-auto-hide="false"
data-show-delay="30000">
</script>
<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<link href="./assets/css/index.css" rel="stylesheet">
<script type="text/javascript" src="./assets/js/index.js"></script>
</body>
</html>