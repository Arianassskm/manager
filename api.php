<?php
require 'public/header.php';
require 'public/ai.php';
function huoquapixiangqing($pdo, $id) {
    try {
        $stmt = $pdo->prepare("SELECT id, `api_name`, `api_url`, `api_jianjie`, `api_canshu`, `api_counter`, `api_data`, `api_state`, `api_update`, `api_chestnut`, `api_price`, `api_toll`,`harging_method`, `api_source` FROM `api_card` WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new Exception("接口不存在");
        }
        return $result;
    } catch (PDOException $e) {
        error_log("获取API详情失败: " . $e->getMessage());
        return null;
    }
}
function huoquwangzhanxinxi($pdo, $websiteid) {
    try {
        $stmt = $pdo->prepare("SELECT `id`, `site_name`, `site_description`, `site_keywords`, `footer_content`, `site_icon`, `site_url`, `site_icp`, `site_security`, `site_moe`, `site_time`, `website_time`, `site_sakura` FROM `site_info` WHERE `id` = ?");
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
function huoqufenlei($pdo) {
    try {
        $stmt = $pdo->query("SELECT id, name FROM api_classify");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("获取分类数据失败: " . $e->getMessage());
        return [];
    }
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$apis = huoquapixiangqing($pdo, $id);
if (!$apis) {
    die("接口不存在");
}
if ($apis['api_state'] === '异常' || $apis['api_state'] === '维护') {
    $message = ($apis['api_state'] === '异常') ? "API异常，请等待管理员修复" : "API维护中...";
    echo "<script type='text/javascript'>
            alert('$message');
            window.location.href = 'index.php';
          </script>";
    exit;
}
ob_start();
echo $apis['api_jianjie'];
$content = ob_get_clean();
$summary = aizongjie($content);
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
$classes = huoqufenlei($pdo);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Api详情-<?php echo $apis['api_name']; ?></title>
  <link rel="icon" type="image/ico" href="<?php echo nl2br($website['site_icon']); ?>">
  <meta name="keywords" content="<?php echo nl2br($website['site_keywords']); ?>">
  <meta name="description" content="<?php echo $apis['api_jianjie']; ?>">
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
<div class="custom-card-container first-card">
	<div class="custom-card">
		<div class="custom-card-content">
			<h1 class="custom-card-title" style="color: #20b2aa"><?php echo $apis['api_name']; ?>-<?php echo $apis['api_toll']; ?></h1>
			<p class="custom-card-text"><?php echo $summary;?></p>
		</div>
	</div>
</div>
<div class="custom-card-container">
	<div class="custom-card">
		<div class="custom-card-content">
		    <h1 class="custom-card-title" style="color: #ffaaff">接口简介:</h1>
            <p class="custom-card-text"><?php echo $apis['api_jianjie']; ?></p>
		</div>
	</div>
</div>
<div class="custom-card-container">
	<div class="custom-card">
		<div class="custom-card-content">
			<h1 class="custom-card-title-2" style="color: #aaaaff">接口地址:</h1>
			<a href="<?php echo $apis['api_url']; ?>" class="custom-card-text"><?php echo $apis['api_url']; ?></a>
			<div class="hr-container-1">
				<hr class="custom-hr-1" />
			</div>
			<h2 class="custom-card-title-2">调用实例:</h2>
			<a href="<?php echo $apis['api_chestnut']; ?>" class="custom-card-text"><?php echo $apis['api_chestnut']; ?></a>
		</div>
	</div>
</div>
<div class="custom-card-container">
	<div class="custom-card">
		<div class="custom-card-content">
			<h1 class="custom-card-title" style="color: #55aa7f">调用参数:</h1>
			<div class="table-container"> <?php echo $apis['api_canshu']; ?> </div>
		</div>
	</div>
</div>
<div class="custom-card-container">
	<div class="custom-card">
		<div class="custom-card-content">
			<h1 class="custom-card-title" style="color: #55aaff">接口详情:</h1>
			<div class="table-container">
				<table class="custom-table">
					<thead>
						<tr>
							<th>调用次数</th>
							<th>发布日期</th>
							<th>更新日期</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $apis['api_counter']; ?></td>
							<td><?php echo $apis['api_data']; ?></td>
							<td><?php echo $apis['api_update']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="custom-card-container foot-card">
	<div class="custom-card">
		<div class="custom-card-content">
			<h1 class="custom-card-title" style="color: #cca8e9">收费详情:</h1>
			<div class="table-container">
				<table class="custom-table">
					<thead>
						<tr>
							<th>收费方式</th>
							<th>收费价格</th>
							<th>开源情况</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $apis['harging_method']; ?></td>
							<td><?php echo $apis['api_price']; ?></td>
							<td><?php echo $apis['api_source']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="nothing"></div>
<?php include'public/foot.php';?>
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