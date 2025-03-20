<?php
include 'api/header.php';
$messages = [
    'success' => [],
    'error' => []
];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_delete'])) {
    $delete_id = (int)$_POST['delete'];
    $checkStmt = $pdo->prepare('SELECT * FROM api_classify WHERE id = ?');
    $checkStmt->execute([$delete_id]);
    if ($checkStmt->rowCount() == 0) {
        $messages['error'][] = '分类不存在（ID: ' . $delete_id . '）。';
    } else {
        $stmt = $pdo->prepare('DELETE FROM api_classify WHERE id = ?');
        $stmt->execute([$delete_id]);

        if ($stmt->rowCount() > 0) {
            $messages['success'][] = '分类删除成功！';
        } else {
            $messages['error'][] = '分类删除失败，请稍后重试。';
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update'])) {
    $update_id = (int)$_POST['update_id'];
    $update_name = trim($_POST['update_name'] ?? '');

    if (empty($update_name)) {
        $messages['error'][] = '分类名称是必填的。';
    } else {
        $stmt = $pdo->prepare('UPDATE api_classify SET name = ? WHERE id = ?');
        $stmt->bindParam(1, $update_name);
        $stmt->bindParam(2, $update_id);

        if ($stmt->execute()) {
            $messages['success'][] = '分类更新成功！';
        } else {
            $messages['error'][] = '分类更新失败。';
        }
    }
}
$apiClassify = $pdo->query('SELECT * FROM api_classify')->fetchAll(PDO::FETCH_ASSOC);
?> <body>
	<main class="lyear-layout-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<ul class="nav nav-tabs page-tabs">
							<li class="active"> <a href="add-classify.php">添加分类</a> </li>
							<li class="active"> <a href="change-classify.php">管理分类</a> </li>
						</ul>
						<div class="container"> <?php if (!empty($messages['success'])): ?> <div class="alert alert-success"> <?php foreach ($messages['success'] as $message): ?> <p><?php echo $message; ?></p> <?php endforeach; ?> </div> <?php endif; ?> <?php if (!empty($messages['error'])): ?> <div
								class="alert alert-danger"> <?php foreach ($messages['error'] as $message): ?> <p><?php echo $message; ?></p> <?php endforeach; ?> </div> <?php endif; ?> <div class="layui-panel">
								<table class="table">
									<tr>
										<th>ID</th>
										<th>分类名称</th>
										<th>操作</th>
									</tr> <?php foreach ($apiClassify as $classify): ?> <tr>
										<td><?php echo htmlspecialchars($classify['id']); ?></td>
										<td><?php echo htmlspecialchars($classify['name']); ?></td>
										<td>
											<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="display: inline;">
												<input type="hidden" name="update_id" value="<?php echo $classify['id']; ?>">
												<input class="layui-input" type="text" name="update_name" value="<?php echo htmlspecialchars($classify['name']); ?>" required>
												<button type="submit" name="submit_update" class="btn btn-primary">更新</button>
											</form>
											<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="display: inline;">
												<input type="hidden" name="delete" value="<?php echo $classify['id']; ?>">
												<button type="submit" name="submit_delete" class="btn btn-danger" onclick="return confirm('您确定要删除这个分类吗？')">删除</button>
											</form>
										</td>
									</tr> <?php endforeach; ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main> <?php include 'api/footer.php'; ?>
