<?php
include 'api/header.php';
$messages = [
    'success' => [],
    'error' => []
];
try {
    $classifyStmt = $pdo->prepare("SELECT `id`, `name` FROM `api_classify`");
    $classifyStmt->execute();
    $apiClassify = $classifyStmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("获取分类信息失败: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    $api_id = $_POST['api_id'];
    $api_name = $_POST['api_name'] ?? null;
    $api_url = $_POST['api_url'] ?? null;
    $api_chestnut = $_POST['api_chestnut'] ?? null;
    $api_jianjie = $_POST['api_jianjie'] ?? null;
    $api_canshu = $_POST['api_canshu'] ?? null;
    $api_toll = $_POST['api-toll'] ?? null;
    $api_state = $_POST['api-state'] ?? null;
    $api_source = $_POST['api-source'] ?? null;
    $harging_method	= $_POST['harging_method'] ?? null;
    $api_price = $_POST['api_price'] ?? null;
    $api_classify = $_POST['api_classify'] ?? null;
$sql = "UPDATE api_card SET ";
$params = [];
if (!is_null($api_name)) {
    $sql .= "api_name = ?, ";
    $params[] = $api_name;
}
if (!is_null($api_url)) {
    $sql .= "api_url = ?, ";
    $params[] = $api_url;
}
if (!is_null($api_chestnut)) {
    $sql .= "api_chestnut = ?, ";
    $params[] = $api_chestnut;
}
if (!is_null($api_jianjie)) {
    $sql .= "api_jianjie = ?, ";
    $params[] = $api_jianjie;
}
if (!is_null($api_canshu)) {
    $sql .= "api_canshu = ?, ";
    $params[] = $api_canshu;
}
if (!is_null($api_toll)) {
    $sql .= "api_toll = ?, ";
    $params[] = $api_toll;
}
if (!is_null($api_state)) {
    $sql .= "api_state = ?, ";
    $params[] = $api_state;
}
if (!is_null($api_source)) {
    $sql .= "api_source = ?, ";
    $params[] = $api_source;
}
if (!is_null($harging_method)) {
    $sql .= "harging_method = ?, ";
    $params[] = $harging_method;
}
if (!is_null($api_price)) {
    $sql .= "api_price = ?, ";
    $params[] = $api_price;
}
if (!is_null($api_classify)) {
    $sql .= "api_classify = ?, ";
    $params[] = $api_classify;
}

$sql .= "api_update = ?, ";
$params[] = date('Y-m-d H:i:s');
$sql = rtrim($sql, ', ') . ' WHERE id = ?';
$params[] = $api_id;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        $messages['success'][] = 'API信息更新成功。';
    } else {
        $messages['error'][] = 'API信息更新失败。';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_delete'])) {
    $delete_id = (int)$_POST['delete'];
    $checkStmt = $pdo->prepare('SELECT * FROM api_card WHERE id = ?');
    $checkStmt->execute([$delete_id]);
    if ($checkStmt->rowCount() == 0) {
        $messages['error'][] = 'API不存在（ID: ' . $delete_id . '）。';
    } else {
        $stmt = $pdo->prepare('DELETE FROM api_card WHERE id = ?');
        $stmt->execute([$delete_id]);

        if ($stmt->rowCount() > 0) {
            $messages['success'][] = 'API删除成功！';
        } else {
            $messages['error'][] = 'API删除失败，请稍后重试。';
        }
    }
}

$api_cards = $pdo->query('SELECT * FROM api_card')->fetchAll(PDO::FETCH_ASSOC);
?> <style>
	.container {width: 80%;max-width: 1200px;margin: 0 auto;padding-top: 20px;}.alert {padding: 10px;margin-bottom: 20px;border-radius: 5px;color: white;}.alert-success {background-color: #4CAF50;}.alert-danger {background-color: #f44336;}.btn {display: inline-block;padding: 4px 8px;margin: 4px auto;border: none;border-radius: 4px;cursor: pointer;}.btn-primary {background-color: #008CBA;color: white;}.btn-danger {background-color: #f44336;color: white;}.btn-container {text-align: center;}textarea, input[type="text"], select {width: 100%;padding: 8px;margin: 4px 0;border-radius: 4px;border: 1px solid #ddd;}textarea {resize: vertical;}input {width: 50px;}.modal {display: none;position: fixed;z-index: 1;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.4);padding-top: 60px;}.modal-content {background-color: #fefefe;margin: 5% auto;padding: 20px;border: 1px solid #888;width: 80%;}.close {color: #aaa;float: right;font-size: 28px;font-weight: bold;}.close:hover, .close:focus {color: black;text-decoration: none;cursor: pointer;}.layui-panel {border-radius: 15px;background-color: rgba(255, 255, 255, 0.6);}body{height: 1500px}
</style>
<body>
	<main class="lyear-layout-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<ul class="nav nav-tabs page-tabs">
							<li class="active"> <a href="add-api.php">添加接口</a> </li>
							<li class="active"> <a href="change-api.php">管理接口</a> </li>
							<li class="active"> <a href="movie.php">影视接口</a> </li>
							<li class="active"> <a href="pic.php">图片接口</a> </li>
							<li class="active"> <a href="api-message.php">接口信息</a> </li>
						</ul>
						<div class="container"> <?php if (!empty($messages['success'])): ?> <div class="alert alert-success"> <?php foreach ($messages['success'] as $message): ?> <p><?php echo $message; ?></p> <?php endforeach; ?> </div> <?php endif; ?> <?php if (!empty($messages['error'])): ?> <div
								class="alert alert-danger"> <?php foreach ($messages['error'] as $message): ?> <p><?php echo $message; ?></p> <?php endforeach; ?> </div> <?php endif; ?> <ul class="api-list"> <?php foreach ($api_cards as $api_card): ?> <div class="layui-panel">
									<div class="btn-container">
										<li class="api-item">
											<div style="margin-top: 2px">
												<strong style="font-size: 12px;">ID:</strong> <?php echo htmlspecialchars($api_card['id']); ?><br>
												<strong>API名称:</strong> <?php echo htmlspecialchars($api_card['api_name']); ?><br>
												<strong>API状态:</strong> <?php echo htmlspecialchars($api_card['api_state']); ?><br>
												<strong>API收费状态:</strong> <?php echo htmlspecialchars($api_card['api_toll']); ?><br>
												<strong>API开源状态:</strong> <?php echo htmlspecialchars($api_card['api_source']); ?><br>
												<strong>API收费方式:</strong> <?php echo htmlspecialchars($api_card['harging_method']); ?><br>
												<strong>API接口费用:</strong> <?php echo htmlspecialchars($api_card['api_price']); ?><br>
												<strong>API接口分类:</strong> <?php echo htmlspecialchars($api_card['api_classify']); ?><br>
												<button style="" class="btn btn-success" onclick="editApi(<?php echo $api_card['id']; ?>)">修改</button>
												<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="display: inline-block;">
													<input type="hidden" name="delete" value="<?php echo $api_card['id']; ?>">
													<button type="submit" name="submit_delete" class="btn btn-danger" onclick="return confirm('您确定要删除这个API接口吗？')">删除</button>
												</form>
											</div>
										</li>
									</div>
								</div> <?php endforeach; ?> </ul>
						</div>
						<div id="editModal" class="modal">
							<div class="modal-content" style="margin-top: 50px">
								<span class="close">&times;</span>
								<form id="editForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
									<input type="hidden" name="api_id" value="">
									<label for="api_name">API名称:</label>
									<input type="text" id="api_name" name="api_name" value="" required><br><br>
									<label for="api_url">API链接:</label>
									<textarea id="api_url" name="api_url" required></textarea><br><br>
									<label for="api_chestnut">API实例:</label>
									<textarea id="api_chestnut" name="api_chestnut" required><?php echo htmlspecialchars($api_card['api_chestnut']); ?></textarea><br><br>
									<label for="api_jianjie">API简介:</label>
									<textarea id="api_jianjie" name="api_jianjie" required></textarea><br><br>
									<label for="api_canshu">API参数:</label>
									<textarea id="api_canshu" name="api_canshu" required></textarea><br><br>
									<label for="api_state">API状态:</label>
									<select id="api_state" name="api-state" required>
										<option value="正常">正常</option>
										<option value="异常">异常</option>
										<option value="维护">维护</option>
										<option value="收费">收费</option>
									</select>
									<label for="api_toll">收费状态:<br>(免费状态表示不开启收费模式 下方收费方式不会生效)</label>
									<select id="api_toll" name="api-toll" required>
										<option value="免费">免费</option>
										<option value="收费">收费</option>
									</select>
									<label for="harging_method">收费方式:</label>
									<select id="harging_method" name="harging_method" required>
										<option value="会员">会员</option>
										<option value="余额">余额</option>
										<option value="会员+余额">会员+余额</option>
									</select>
									<label for="api_price">接口费用(0表示免费):</label>
									<textarea type="text" id="api_price" name="api_price" required placeholder="当前设置费用:<?php echo htmlspecialchars($api_card['api_price']); ?>"><?php echo htmlspecialchars($api_card['api_price']); ?></textarea>
									<label for="api_source">开源状态:</label>
									<select id="api_source" name="api-source" required>
										<option value="开源">开源</option>
										<option value="闭源">闭源</option>
									</select>
									<label for="api_classify">API分类:</label>
									<select id="api_classify" name="api_classify" required>
										<option value="">请选择分类</option> <?php foreach ($apiClassify as $classify): ?> <option value="<?php echo $classify['id']; ?>"><?php echo $classify['name']; ?></option> <?php endforeach; ?>
									</select>
									<br><br>
									<button type="submit" name="confirm" value="1" class="btn btn-primary">确认修改</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script>
		var modal = document.getElementById("editModal");
		var span = document.getElementsByClassName("close")[0];
		span.onclick = function() {
		    modal.style.display = "none";
		}
		window.onclick = function(event) {
		    if (event.target == modal) {
		        modal.style.display = "none";
		    }
		}
		function editApi(api_id) {
		    var api_card = <?php echo json_encode($api_cards); ?>;
		    var selectedApi = api_card.find(function(api) { return api.id == api_id; });
		    document.getElementById('api_name').value = selectedApi.api_name;
		    document.getElementById('api_url').value = selectedApi.api_url;
		    document.getElementById('api_chestnut').value = selectedApi.api_chestnut;
		    document.getElementById('api_jianjie').value = selectedApi.api_jianjie;
		    document.getElementById('api_canshu').value = selectedApi.api_canshu;
		    document.getElementById('api_state').value = selectedApi.api_state;
		    document.getElementById('api_toll').value = selectedApi.api_toll;
		    document.getElementById('api_source').value = selectedApi.api_source;
		    document.getElementById('api_classify').value = selectedApi.api_classify; // 设置选中的分类
		    document.getElementById('editForm').elements.namedItem('api_id').value = api_id;
		    modal.style.display = "block";
		}
	</script> <?php include 'api/footer.php'; ?>
</body>
</html>