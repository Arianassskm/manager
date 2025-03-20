<?php
require_once 'api/header.php';
$messages = [
    'success' => [],
    'error' => []
];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_update'])) {
        $id = $_POST['update_id'];
        $name = $_POST['update_name'];
        $url = $_POST['url'];
        $head_url = $_POST['head_url'];
        $user_name = $_POST['user_name'];
        $state = $_POST['state'];
        $sql = "UPDATE friend_link SET name = :name, url = :url, head_url = :head_url, user_name = :user_name, state = :state WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':head_url', $head_url);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':state', $state);
        if ($stmt->execute()) {
            $messages['success'][] = '友链信息更新成功！';
        } else {
            $messages['error'][] = '友链信息更新失败：' . $stmt->errorInfo()[2];
        }
    } elseif (isset($_POST['submit_delete'])) {
        $id = $_POST['delete'];
        $sql = "DELETE FROM friend_link WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            $messages['success'][] = '友链信息删除成功！';
        } else {
            $messages['error'][] = '友链信息删除失败：' . $stmt->errorInfo()[2];
        }
    }
}
$sql = "SELECT id, name, url, head_url, user_name, state, create_time FROM friend_link";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$apiClassify = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!is_array($apiClassify) || empty($apiClassify)) {
    $messages['error'][] = '没有找到友链信息';
    $apiClassify = [];
}
?>
<main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="container"> <?php if (!empty($messages['success'])): ?> <div class="alert alert-success"> <?php foreach ($messages['success'] as $message): ?> <p><?php echo $message; ?></p> <?php endforeach; ?> </div> <?php endif; ?> <?php if (!empty($messages['error'])): ?> <div
							class="alert alert-danger"> <?php foreach ($messages['error'] as $message): ?> <p><?php echo $message; ?></p> <?php endforeach; ?> </div> <?php endif; ?> <div class="layui-panel">
							<table class="layui-table">
								<tr>
									<th scope="row">ID</th>
									<th>站点名称</th>
									<th>站点链接</th>
									<th>站长名称</th>
									<th>友链状态</th>
									<th>记录时间</th>
									<th>操作</th>
								</tr> <?php foreach ($apiClassify as $classify): ?> <tr>
									<td scope="row"><?php echo htmlspecialchars($classify['id']); ?></td>
									<td><?php echo htmlspecialchars($classify['name']); ?></td>
									<td><?php echo htmlspecialchars($classify['url']); ?></td>
									<td><?php echo htmlspecialchars($classify['user_name']); ?></td>
									<td><?php echo htmlspecialchars($classify['state']); ?> </td>
									<td><?php echo htmlspecialchars($classify['create_time']); ?></td>
									<td>
										<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="display: inline;">
											<input type="hidden" name="update_id" value="<?php echo $classify['id']; ?>">
											<input class="layui-input" type="text" name="update_name" placeholder="站点名称" value="<?php echo htmlspecialchars($classify['name']); ?>" required>
											<input class="layui-input" type="text" name="url" placeholder="站点链接" value="<?php echo htmlspecialchars($classify['url']); ?>" required>
											<input class="layui-input" type="text" name="head_url" placeholder="图标链接" value="<?php echo htmlspecialchars($classify['head_url']); ?>" required>
											<input class="layui-input" type="text" name="user_name" placeholder="站长名称" value="<?php echo htmlspecialchars($classify['user_name']); ?>" required>
											<select class="layui-input" name="state" required>
												<option value="待审核" <?php echo ($classify['state'] === '待审核') ? 'selected' : ''; ?>>待审核</option>
												<option value="审核通过" <?php echo ($classify['state'] === '审核通过') ? 'selected' : ''; ?>>审核通过</option>
											</select>
											<button type="submit" name="submit_update" class="btn btn-primary">更新</button>
										</form>
										<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="display: inline;">
											<input type="hidden" name="delete" value="<?php echo $classify['id']; ?>">
											<button type="submit" name="submit_delete" class="btn btn-danger" onclick="return confirm('您确定要删除这个友链吗？')">删除</button>
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
</main>
<?php require_once 'api/footer.php';?>