<?php
include 'api/header.php';
global $pdo;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = isset($_POST['site_name']) ? trim($_POST['site_name']) : null;
    $site_description = isset($_POST['site_description']) ? trim($_POST['site_description']) : null;
    $site_keywords = isset($_POST['site_keywords']) ? trim($_POST['site_keywords']) : null;
    $site_icon = isset($_POST['site_icon']) ? trim($_POST['site_icon']) : null;
    $footer_content = isset($_POST['footer_content']) ? trim($_POST['footer_content']) : null;
    $site_url = isset($_POST['site_url']) ? trim($_POST['site_url']) : null;
    $site_icp = isset($_POST['site_icp']) ? trim($_POST['site_icp']) : null;
    $site_security = isset($_POST['site_security']) ? trim($_POST['site_security']) : null;
    $site_moe = isset($_POST['site_moe']) ? trim($_POST['site_moe']) : null;
    $site_announcement = isset($_POST['site_announcement']) ? trim($_POST['site_announcement']) : null;
    $site_time = isset($_POST['site_time']) ? trim($_POST['site_time']) : null;
    $website_time = isset($_POST['website_time']) ? trim($_POST['website_time']) : null;
    $site_frequency = isset($_POST['site_frequency']) ? trim($_POST['site_frequency']) : null;
    $site_second = isset($_POST['site_second']) ? trim($_POST['site_second']) : null;
    $site_sakura = isset($_POST['site_sakura']) ? trim($_POST['site_sakura']) : null;
$stmt = $pdo->prepare(
    'INSERT INTO site_info (id, site_name, site_description, site_keywords, site_icon, footer_content, site_url, site_icp, site_security, site_moe, site_announcement, site_time, site_frequency, site_second, website_time, site_sakura) ' .
    'VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ' .
    'ON DUPLICATE KEY UPDATE ' .
    'site_name = VALUES(site_name), ' .
    'site_description = VALUES(site_description), ' .
    'site_keywords = VALUES(site_keywords), ' .
    'site_icon = VALUES(site_icon), ' .
    'footer_content = VALUES(footer_content), ' .
    'site_url = VALUES(site_url), ' .
    'site_icp = VALUES(site_icp), ' .
    'site_security = VALUES(site_security), ' .
    'site_moe = VALUES(site_moe), ' .
    'site_announcement = VALUES(site_announcement), ' .
    'site_time = VALUES(site_time), ' .
    'site_frequency = VALUES(site_frequency), ' .
    'site_second = VALUES(site_second), ' .
    'website_time = VALUES(website_time), ' . 
    'site_sakura = VALUES(site_sakura)'
);
    $stmt->execute([
        $site_name, $site_description, $site_keywords, $site_icon, $footer_content,
        $site_url, $site_icp, $site_security, $site_moe, $site_announcement, $site_time,
        $site_frequency, $site_second, $website_time, $site_sakura
    ]);
    $success = '系统设置成功';
}
$site_info = $pdo->query('SELECT * FROM site_info WHERE id = 1')->fetch(PDO::FETCH_ASSOC) ?: [
    'site_name' => '',
    'site_description' => '',
    'site_keywords' => '',
    'site_icon' => '',
    'footer_content' => '',
    'site_url' => '',
    'site_icp' => '',
    'site_security' => '',
    'site_moe' => '',
    'site_announcement' => '',
    'site_time' => '',
    'site_frequency' => '',
    'site_second' => '',
    'website_time' => '',
    'site_sakura' => ''
];
?>
<main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
				    <ul class="nav nav-tabs page-tabs">
						<li class="active"> <a href="web-site.php">基础设置</a> </li>
						<li class="active"> <a href="website-user.php">站长信息</a> </li>
					</ul>
<div class="layui-container">
    <div class="layui-row">
        <div class="content-box">
            <?php if (isset($success)): ?>
                <div class="layui-bg-green layui-text"><?php echo $success; ?></div>
            <?php elseif (isset($error)): ?>
                <div class="layui-bg-red layui-text"><?php echo $error; ?></div>
            <?php endif; ?>
            <form class="layui-form" action="web-site.php" method="post">
                <div class="layui-form-item">
                    <label class="layui-form-label">网站名称</label>
                    <div class="layui-input-block">
                        <textarea name="site_name" required lay-verify="required" placeholder="Enter Site Name" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_name'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网站描述</label>
                    <div class="layui-input-block">
                        <textarea name="site_description" required lay-verify="required" placeholder="Enter website description" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_description'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网站关键词</label>
                    <div class="layui-input-block">
                        <textarea name="site_keywords" required lay-verify="required" placeholder="Enter website keywords" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_keywords'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网站图标</label>
                    <div class="layui-input-block">
                        <textarea name="site_icon" required lay-verify="required" placeholder="Enter Site Icon URL" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_icon'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">底部版权</label>
                    <div class="layui-input-block">
                        <textarea name="footer_content" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['footer_content'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网站URL</label>
                    <div class="layui-input-block">
                        <textarea name="site_url" required lay-verify="required" placeholder="Enter Site URL" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_url'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">ICP备案号</label>
                    <div class="layui-input-block">
                        <textarea name="site_icp" required lay-verify="required" placeholder="没有ICP备案请填-1" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_icp'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">公安备案号</label>
                    <div class="layui-input-block">
                        <textarea name="site_security" required lay-verify="required" placeholder="没有公安备案请填-1" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_security'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">萌国备案号</label>
                    <div class="layui-input-block">
                        <textarea name="site_moe" required lay-verify="required" placeholder="没有萌备案请填-1" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_moe'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网站公告</label>
                    <div class="layui-input-block">
                        <textarea name="site_announcement" required lay-verify="required" placeholder="支持html标签 内嵌css样式 关闭公告请填-1" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_announcement'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">建站时间</label>
                    <div class="layui-input-block">
                        <textarea name="website_time" required lay-verify="required" placeholder="注意格式:2024-05-20-00:00:00" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['website_time'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">公告消失时长(单位:秒)</label>
                    <div class="layui-input-block">
                        <textarea name="site_time" required lay-verify="required" placeholder="通过cookie实现 请注意辨别" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_time'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">接口访问限制次数(单位/次)</label>
                    <div class="layui-input-block">
                        <textarea name="site_frequency" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_frequency'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">接口访问限制秒数(单位/秒)</label>
                    <div class="layui-input-block">
                        <textarea name="site_second" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_second'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">樱花飘落效果</label>
                    <div class="layui-input-block">
                        <textarea name="site_sakura" required lay-verify="required" placeholder="1-开启 0-关闭" autocomplete="off" class="layui-input transparent-input"><?php echo htmlspecialchars($site_info['site_sakura'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">确定</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="layui-container">
	<div class="layui-row">
		<div class="content-box">
			<p style="text-align:center">备案信息以及公告填 -1 表示关闭 (不显示)</p>
			<p style="text-align:center">接口访问限制填写演示 次数:5 时间:1 1秒内超过5次提示调用频繁</p>
			<br>
		</div>
	</div>
</div>

<div class="layui-container">
	<div class="layui-row">
		<div class="content-box">
			<h2 style="text-align:center">时间转换器</h2>
			<div class="layui-form" lay-filter="test">
				<div class="layui-form-item">
					<label class="layui-form-label">输入时间单位:</label>
					<div class="layui-input-inline">
						<select id="timeUnit" lay-filter="timeUnit">
							<option value="year">年</option>
							<option value="month">月</option>
							<option value="day">日</option>
							<option value="hour">小时</option>
							<option value="minute">分钟</option>
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">时长:</label>
					<div class="layui-input-inline">
						<input type="number" id="duration" min="1" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">返回时间单位:</label>
					<div class="layui-input-inline">
						<select id="returnUnit" lay-filter="returnUnit">
							<option value="year">年</option>
							<option value="month">月</option>
							<option value="day">日</option>
							<option value="hour">小时</option>
							<option value="minute">分钟</option>
							<option value="second">秒</option>
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" onclick="convertTime()">转换</button>
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block" id="result"></div>
				</div>
			</div>
		</div>
	</div>
</div>
				</div>
			</div>
		</div>
	</div>
</main> 


<?php include 'api/footer.php'; ?>