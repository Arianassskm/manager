<?php require_once "../core/config.php";
session_start();
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
$websiteid = 1;
try {
    $stmt = $pdo->prepare(
        "SELECT `id`, `site_name`, `site_description`, `site_keywords`, `site_icon`, `site_url` FROM `site_info` WHERE `id` = ?"
    );
    $stmt->execute([$websiteid]);
    $website = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$website) {
        die("网站信息不存在");
    }
} catch (PDOException $e) {
    die("获取网站信息失败: " . $e->getMessage());
} 
?>


<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<title><?php echo nl2br($website['site_name']); ?>-后台管理</title>
	<link rel="icon" href="<?php echo nl2br($website['site_icon']); ?>" type="image/ico">
	<meta name="keywords" content="<?php echo nl2br($website['site_keywords']); ?>">
	<meta name="description" content="<?php echo nl2br($website['site_description']); ?>">
	<meta name="author" content="zhousihan">
	<link href="//unpkg.com/layui@2.9.20/dist/css/layui.css" rel="stylesheet">
	<script src="//unpkg.com/layui@2.9.16/dist/layui.js"></script>
	<script src="https://kit.fontawesome.com/5434b822ca.js" crossorigin="anonymous"></script>
	<link href="https://api.lovestory.wiki/hanzi/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://api.lovestory.wiki/hanzi/assets/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="https://api.lovestory.wiki/hanzi/assets/css/style.min.css" rel="stylesheet">
</head>
<body>
	<div class="lyear-layout-web">
		<div class="lyear-layout-container">
			<aside class="lyear-layout-sidebar">
				<div id="logo" class="sidebar-header">
					<a style="font-size: 44px" href="index.php"><?php echo nl2br($website['site_name']); ?></a>
				</div>
				<div class="lyear-layout-sidebar-scroll">
					<nav class="sidebar-main">
						<ul class="nav nav-drawer">
							<li class="nav-item active">  <a href="index.php"><i class="mdi mdi-home" style="color: #16baaa"></i>后台首页</a> </li>
							<li class="nav-item nav-item-has-subnav">
								<a href="javascript:void(0)"><i class="mdi mdi-alarm-light" style="color: #ffb800 "></i>系统管理</a>
								<ul class="nav nav-subnav">
									<li><a href="web-site.php">基础设置</a></li>
									<li><a href="website-user.php">站长信息</a></li>
								</ul>
							</li>
							<li class="nav-item nav-item-has-subnav">
								<a href="javascript:void(0)"><i class="mdi mdi-currency-rub" style="color: #1e9fff"></i>接口管理</a>
								<ul class="nav nav-subnav">
									<li><a href="add-api.php">添加接口</a></li>
									<li><a href="change-api.php">接口设置</a></li>
									<li><a href="api-message.php">接口信息</a></li>
								</ul>
							</li>
							<li class="nav-item nav-item-has-subnav">
								<a href="javascript:void(0)"><i class="mdi mdi-server-network" style="color: #a233c6"></i>接口分类</a>
								<ul class="nav nav-subnav">
									<li><a href="add-classify.php">添加分类</a></li>
									<li><a href="change-classify.php">分类管理</a></li>
								</ul>
							</li>
							<li class="nav-item nav-item-has-subnav">
								<a href="javascript:void(0)"><i class="mdi mdi-lightbulb-outline" style="color: #ffb800"></i>日志系统</a>
								<ul class="nav nav-subnav">
									<li><a href="api-log.php">接口日志</a></li>
									<li><a href="user-log.php">用户日志</a></li>
								</ul>
							</li>
							<li class="nav-item nav-item-has-subnav">
								<a href="javascript:void(0)"><i class="mdi mdi-blur-off" style="color: #31bdec"></i>友链系统</a>
								<ul class="nav nav-subnav">
									<li><a href="friend-link.php">友链管理</a></li>
								</ul>
							</li>
							<li class="nav-item nav-item-has-subnav">
								<a href="javascript:void(0)"><i class="mdi mdi-account" style="color: #ff5722"></i>用户系统</a>
								<ul class="nav nav-subnav">
									<li><a href="user.php">用户管理</a></li>
								</ul>
							</li>
							<li class="nav-item nav-item-has-subnav">
								<a href="javascript:void(0)"><i class="mdi mdi-key-plus" style="color: #a233c6"></i>充值系统</a>
								<ul class="nav nav-subnav">
									<li><a href="add-key.php">充值密钥</a></li>
								</ul>
							</li>
							<li class="nav-item nav-item-has-subnav">
								<a href="javascript:void(0)"><i class="mdi mdi-server" style="color: #31bdec"></i>系统邮箱</a>
								<ul class="nav nav-subnav">
									<li><a href="mail-set.php">邮箱设置</a></li>
								</ul>
							</li>
						</ul>
					</nav>
					<div class="sidebar-footer">
						<p class="copyright"></p>
					</div>
				</div>
			</aside>
			<header class="lyear-layout-header">
				<nav class="navbar navbar-default">
					<div class="topbar">
						<div class="topbar-left">
							<div class="lyear-aside-toggler">
								<span class="lyear-toggler-bar"></span>
								<span class="lyear-toggler-bar"></span>
								<span class="lyear-toggler-bar"></span>
							</div>
							<span class="navbar-page-title"> 后台首页 </span>
						</div>
						<ul class="topbar-right">
							<li class="dropdown dropdown-skin">
								<span data-toggle="dropdown" class="icon-palette"><i class="mdi mdi-palette"></i></span>
								<ul class="dropdown-menu dropdown-menu-right" data-stopPropagation="true">
									<li class="drop-title">
										<p>主题</p>
									</li>
									<li class="drop-skin-li clearfix">
										<span>
											<input type="radio" name="site_theme" value="default" id="site_theme_1" checked>
											<label for="site_theme_1"></label>
										</span>
										<span>
											<input type="radio" name="site_theme" value="dark" id="site_theme_2">
											<label for="site_theme_2"></label>
										</span>
										<span>
											<input type="radio" name="site_theme" value="translucent" id="site_theme_3">
											<label for="site_theme_3"></label>
										</span>
									</li>
									<li class="drop-title">
										<p>LOGO</p>
									</li>
									<li class="drop-skin-li clearfix">
										<span >
											<input type="radio" name="logo_bg" value="default" id="logo_bg_1" checked>
											<label for="logo_bg_1"></label>
										</span>
										<span>
											<input type="radio" name="logo_bg" value="color_2" id="logo_bg_2">
											<label for="logo_bg_2"></label>
										</span>
										<span>
											<input type="radio" name="logo_bg" value="color_3" id="logo_bg_3">
											<label for="logo_bg_3"></label>
										</span>
										<span>
											<input type="radio" name="logo_bg" value="color_4" id="logo_bg_4">
											<label for="logo_bg_4"></label>
										</span>
										<span>
											<input type="radio" name="logo_bg" value="color_5" id="logo_bg_5">
											<label for="logo_bg_5"></label>
										</span>
										<span>
											<input type="radio" name="logo_bg" value="color_6" id="logo_bg_6">
											<label for="logo_bg_6"></label>
										</span>
										<span>
											<input type="radio" name="logo_bg" value="color_7" id="logo_bg_7">
											<label for="logo_bg_7"></label>
										</span>
										<span>
											<input type="radio" name="logo_bg" value="color_8" id="logo_bg_8">
											<label for="logo_bg_8"></label>
										</span>
									</li>
									<li class="drop-title">
										<p>头部</p>
									</li>
									<li class="drop-skin-li clearfix">
										<span>
											<input type="radio" name="header_bg" value="default" id="header_bg_1" checked>
											<label for="header_bg_1"></label>
										</span>
										<span>
											<input type="radio" name="header_bg" value="color_2" id="header_bg_2">
											<label for="header_bg_2"></label>
										</span>
										<span>
											<input type="radio" name="header_bg" value="color_3" id="header_bg_3">
											<label for="header_bg_3"></label>
										</span>
										<span>
											<input type="radio" name="header_bg" value="color_4" id="header_bg_4">
											<label for="header_bg_4"></label>
										</span>
										<span>
											<input type="radio" name="header_bg" value="color_5" id="header_bg_5">
											<label for="header_bg_5"></label>
										</span>
										<span>
											<input type="radio" name="header_bg" value="color_6" id="header_bg_6">
											<label for="header_bg_6"></label>
										</span>
										<span>
											<input type="radio" name="header_bg" value="color_7" id="header_bg_7">
											<label for="header_bg_7"></label>
										</span>
										<span>
											<input type="radio" name="header_bg" value="color_8" id="header_bg_8">
											<label for="header_bg_8"></label>
										</span>
									</li>
									<li class="drop-title">
										<p>侧边栏</p>
									</li>
									<li class="drop-skin-li clearfix">
										<span >
											<input type="radio" name="sidebar_bg" value="default" id="sidebar_bg_1" checked>
											<label for="sidebar_bg_1"></label>
										</span>
										<span>
											<input type="radio" name="sidebar_bg" value="color_2" id="sidebar_bg_2">
											<label for="sidebar_bg_2"></label>
										</span>
										<span>
											<input type="radio" name="sidebar_bg" value="color_3" id="sidebar_bg_3">
											<label for="sidebar_bg_3"></label>
										</span>
										<span>
											<input type="radio" name="sidebar_bg" value="color_4" id="sidebar_bg_4">
											<label for="sidebar_bg_4"></label>
										</span>
										<span>
											<input type="radio" name="sidebar_bg" value="color_5" id="sidebar_bg_5">
											<label for="sidebar_bg_5"></label>
										</span>
										<span>
											<input type="radio" name="sidebar_bg" value="color_6" id="sidebar_bg_6">
											<label for="sidebar_bg_6"></label>
										</span>
										<span>
											<input type="radio" name="sidebar_bg" value="color_7" id="sidebar_bg_7">
											<label for="sidebar_bg_7"></label>
										</span>
										<span>
											<input type="radio" name="sidebar_bg" value="color_8" id="sidebar_bg_8">
											<label for="sidebar_bg_8"></label>
										</span>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
		</div>
	</div>
