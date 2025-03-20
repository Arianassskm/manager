<?php
include 'api/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $api_message1 = isset($_POST['api_message1']) ? trim($_POST['api_message1']) : '';
    $api_message2 = isset($_POST['api_message2']) ? trim($_POST['api_message2']) : '';
    $api_message3 = isset($_POST['api_message3']) ? trim($_POST['api_message3']) : '';
    $api_message4 = isset($_POST['api_message4']) ? trim($_POST['api_message4']) : '';
    $api_message5 = isset($_POST['api_message5']) ? trim($_POST['api_message5']) : '';

    $stmt = $pdo->prepare('INSERT INTO api_set (id, api_message1, api_message2, api_message3, api_message4, api_message5), api_message5
                          VALUES (1, ?, ?, ?, ?, ? )
                          ON DUPLICATE KEY UPDATE
                          api_message1 = VALUES(api_message1),
                          api_message2 = VALUES(api_message2),
                          api_message3 = VALUES(api_message3),
                          api_message4 = VALUES(api_message4),
                          api_message5 = VALUES(api_message5)');
    $stmt->bindParam(1, $api_message1);
    $stmt->bindParam(2, $api_message2);
    $stmt->bindParam(3, $api_message3);
    $stmt->bindParam(4, $api_message4);
    $stmt->bindParam(5, $api_message5);

    if ($stmt->execute()) {
        $success = '接口信息修改成功';
    } else {
        $error = '系统异常:' . implode(', ', $stmt->errorInfo());
    }
}
$site_info = $pdo->query('SELECT * FROM api_set WHERE id = 1')->fetch() ?: [
    'api_message1' => '',
    'api_message2' => '',
    'api_message3' => '',
    'api_message4' => '',
    'api_message5' => ''
];?>
<main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
				    <ul class="nav nav-tabs page-tabs">
						<li class="active"> <a href="add-api.php">添加接口</a> </li>
						<li class="active"> <a href="change-api.php">管理接口</a> </li>
						<li class="active"> <a href="api-message.php">接口信息</a> </li>
					</ul>
<div class="layui-container">
    <div class="layui-row">
        <div class="content-box">
            <?php if (isset($success)): ?>
                <div class="layui-bg-green layui-text"><?php echo $success; ?></div>
            <?php elseif (isset($error)): ?>
                <div class="layui-bg-red layui-text"><?php echo $error; ?></div>
            <?php endif; ?>
            <form class="layui-form" action="api-message.php" method="post">
                <div class="layui-form-item">
                    <label class="layui-form-label">会员到期</label>
                    <div class="layui-input-block">
                        <input type="text" name="api_message3" required lay-verify="required" value="<?php echo htmlspecialchars($site_info['api_message3']); ?>" placeholder="会员到期 返回信息" autocomplete="off" class="layui-input transparent-input">
                    </div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">余额不足</label>
                    <div class="layui-input-block">
                        <input type="text" name="api_message4" required lay-verify="required" value="<?php echo htmlspecialchars($site_info['api_message4']); ?>" placeholder="余额不足 返回信息" autocomplete="off" class="layui-input transparent-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">接口不存在</label>
                    <div class="layui-input-block">
                        <input type="text" name="api_message1" required lay-verify="required" value="<?php echo htmlspecialchars($site_info['api_message1'] ?? ''); ?>" placeholder="接口不存在 返回信息" autocomplete="off" class="layui-input transparent-input">
                    </div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">账号不存在</label>
                    <div class="layui-input-block">
                        <input type="text" name="api_message2" required lay-verify="required" value="<?php echo htmlspecialchars($site_info['api_message2']); ?>" placeholder="账号不存在 返回信息" autocomplete="off" class="layui-input transparent-input">
                    </div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">账号冻结中</label>
                    <div class="layui-input-block">
                        <input type="text" name="api_message5" required lay-verify="required" value="<?php echo htmlspecialchars($site_info['api_message5']); ?>" placeholder="账号冻结中 返回信息" autocomplete="off" class="layui-input transparent-input">
                    </div>
                </div>
        
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">更新接口</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
				</div>
			</div>
		</div>
	</div>
</main> 
<?php include 'api/footer.php'; ?>