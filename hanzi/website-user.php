<?php
include 'api/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'], $_POST['user_qq'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_qq = $_POST['user_qq'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if (!empty($username)) {
            $stmt = $pdo->prepare('UPDATE users SET username = ? WHERE id = 1');
            $stmt->execute([$username]);
        }
        if (!empty($password)) {
            $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = 1');
            $stmt->execute([$hashed_password]);
        }
        if (!empty($user_qq)) {
            $stmt = $pdo->prepare('UPDATE users SET user_qq = ? WHERE id = 1');
            if ($stmt->execute([$user_qq])) {
                $success = 'Credentials updated successfully!';
            } else {
                $error = 'Failed to update credentials.';
            }
        }
    } else {
        $error = 'All fields are required.';
    }
}
$stmt = $pdo->query('SELECT * FROM users WHERE id = 1');
$admin = $stmt->fetch();
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
<div class="layui-row">
    <div class="content-box">
        <?php if (isset($success)): ?>
            <div class="layui-bg-green layui-text"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="layui-bg-red layui-text"><?php echo $error; ?></div>
        <?php endif; ?>
        <form class="layui-form" action="website-user.php" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">账号</label>
                <div class="layui-input-block">
                    <input type="text" name="username" required lay-verify="required" value="<?php echo htmlspecialchars($admin['username']); ?>" placeholder="Enter New Username" autocomplete="off" class="layui-input transparent-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                    <input type="password" name="password" required lay-verify="required" placeholder="Enter New Password" autocomplete="off" class="layui-input transparent-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">QQ号</label>
                <div class="layui-input-block">
                    <input type="text" name="user_qq" required lay-verify="required" placeholder="Enter QQ" autocomplete="off" class="layui-input transparent-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">更新信息</button>
                </div>
            </div>
        </form>
    </div>
</div>
				</div>
			</div>
		</div>
	</div>
</main> 
<?php include 'api/footer.php'; ?>