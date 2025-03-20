<?php
require 'public/header.php';
function huoqufenlei($pdo) {
    try {
        $stmt = $pdo->query("SELECT id, name FROM api_classify");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("获取分类数据失败: " . $e->getMessage());
        return [];
    }
}
function huoqufenleimingcheng($pdo, $id) {
    try {
        $stmt = $pdo->prepare("SELECT name FROM api_classify WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new Exception("分类不存在。");
        }
        return $result['name'];
    } catch (PDOException $e) {
        error_log("获取分类名称失败: " . $e->getMessage());
        return null;
    }
}
function huoquapishuju($pdo, $id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM api_card WHERE api_classify = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("获取API数据失败: " . $e->getMessage());
        return [];
    }
}
function huoquwangzhanxinxi($pdo, $websiteid) {
    try {
        $stmt = $pdo->prepare("SELECT `id`, `site_name`, `site_description`, `site_keywords`, `site_icon`, `site_url`, `footer_content`, `site_icp`, `site_security`, `site_moe`, `site_announcement`, `site_time`, `website_time`, `site_sakura` FROM `site_info` WHERE `id` = ?");
        $stmt->execute([$websiteid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new Exception("网站信息不存在");
        }
        return $result;
    } catch (PDOException $e) {
        error_log("获取网站信息失败: " . $e->getMessage());
        return null;
    }
}
function huoquyonghuxinxi($pdo, $userid) {
    try {
        $stmt = $pdo->prepare("SELECT `id`, `username`, `user_qq` FROM `users` WHERE `id` = ?");
        $stmt->execute([$userid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new Exception("用户不存在");
        }
        return $result;
    } catch (PDOException $e) {
        error_log("获取用户信息失败: " . $e->getMessage());
        return null;
    }
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$classes = huoqufenlei($pdo);
$className = huoqufenleimingcheng($pdo, $id);
if (!$className) {
    die("分类不存在。");
}
$apis = huoquapishuju($pdo, $id);
$websiteid = 1;
$website = huoquwangzhanxinxi($pdo, $websiteid);
if (!$website) {
    die("网站信息不存在");
}
$userid = 1;
$user = huoquyonghuxinxi($pdo, $userid);
if (!$user) {
    die("用户不存在");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>接口分类-<?php echo htmlspecialchars($className); ?></title>
  <link rel="icon" type="image/ico" href="<?php echo nl2br($website['site_icon']); ?>">
  <meta name="keywords" content="<?php echo nl2br($website['site_keywords']); ?>">
  <meta name="description" content="<?php echo nl2br($website['site_description']); ?>">
  <script src="./assets/js/jqury.js"></script>
  <link href="./assets/css/box.css" rel="stylesheet">
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
     <?php foreach ($apis as $api): ?> 
      <div class="contentbox">
          <h2><a style="color: white" href="api.php?id=<?php echo $api['id']; ?>"><?php echo htmlspecialchars($api['api_name']); ?></a></h2>
              <div class="box" style="font-size: 12px;margin-left: 10px;margin-right: 10px">
                <?php echo $api['api_jianjie']; ?>
              </div>
            <div class="hr-container">
              <hr class="custom-hr" />
            </div>
           <i class="el-icon-alarm-clock icon-index"> 2024-03-03 </i>
           <i class="el-icon-postcard icon-index"> <?php echo $api['harging_method']; ?> </i>
           <i class="el-icon-wallet icon-index"> <?php echo $api['api_price']; ?> </i>  
      </div>
     <?php endforeach; ?>
    </a>
  </div>
</div> 
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
data-fade-duration="1.5s"
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
    