<?php include 'api/header.php';

$messages = [
    'success' => [],
    'error' => []
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $classify_name = trim($_POST['classify_name'] ?? '');

    if (empty($classify_name)) {
        $messages['error'][] = '分类名称是必填的。';
    } else {
        $stmt = $pdo->prepare('INSERT INTO api_classify (name) VALUES (?)');
        $stmt->bindParam(1, $classify_name);

        if ($stmt->execute()) {
            $messages['success'][] = '分类添加成功！';
        } else {
            $messages['error'][] = '分类添加失败。';
        }
    }
}
?> 
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
								<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
									<input type="text" id="classify_name" name="classify_name" value="" required class="layui-input" placeholder="请输入分类名称"><br>
									<button style="margin-bottom: 10px;margin-left: 20px" type="submit" name="submit" class="btn btn-primary">添加分类</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main> 
<?php include 'api/footer.php'; ?>
