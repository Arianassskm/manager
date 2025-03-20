<?php
include 'api/header.php';
global $pdo;

// 检查数据库连接
if (!$pdo) {
    die('数据库连接失败');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取POST数据
    $mail_host = isset($_POST['mail_host']) ? trim($_POST['mail_host']) : null;
    $mail_email = isset($_POST['mail_email']) ? trim($_POST['mail_email']) : null;
    $mail_password = isset($_POST['mail_password']) ? trim($_POST['mail_password']) : null;
    $mail_smtpsecure = isset($_POST['mail_smtpsecure']) ? trim($_POST['mail_smtpsecure']) : null;
    $mail_port = isset($_POST['mail_port']) ? trim($_POST['mail_port']) : null;
    $mail_mymail = isset($_POST['mail_mymail']) ? trim($_POST['mail_mymail']) : null;

    try {
        $stmt = $pdo->prepare(
            'INSERT INTO api_mail (id, mail_host, mail_email, mail_password, mail_smtpsecure, mail_port, mail_mymail) ' .
            'VALUES (1, ?, ?, ?, ?, ?, ?) ' .
            'ON DUPLICATE KEY UPDATE ' .
            'mail_host = VALUES(mail_host), ' .
            'mail_email = VALUES(mail_email), ' .
            'mail_password = VALUES(mail_password), ' .
            'mail_smtpsecure = VALUES(mail_smtpsecure), ' .
            'mail_port = VALUES(mail_port), ' .
            'mail_mymail = VALUES(mail_mymail)'
        );
        
        $stmt->execute([
            $mail_host, $mail_email, $mail_password, $mail_smtpsecure, $mail_port, $mail_mymail
        ]);
        
        $success = '邮件设置成功';
    } catch (PDOException $e) {
        // 错误处理
        $error = '数据库错误: ' . $e->getMessage();
    }
}
$mail_info = $pdo->query('SELECT * FROM api_mail WHERE id = 1')->fetch(PDO::FETCH_ASSOC) ?: [
    'mail_host' => '',
    'mail_email' => '',
    'mail_password' => '',
    'mail_smtpsecure' => '',
    'mail_port' => '',
    'mail_mymail' => ''
];
?>
<main class="lyear-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs page-tabs">
                        <li class="active"> <a href="mail-set.php">邮件设置</a> </li>
                    </ul>
                    <div class="layui-container">
                        <div class="layui-row">
                            <div class="content-box">
                                <?php if (isset($success)): ?>
                                    <div class="layui-bg-green layui-text"><?php echo $success; ?></div>
                                <?php endif; ?>
                                <form class="layui-form" action="mail-set.php" method="post">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">邮件服务器</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mail_host" required lay-verify="required" placeholder="Enter Mail Host" autocomplete="off" class="layui-input transparent-input" value="<?php echo htmlspecialchars($mail_info['mail_host'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">发件人邮箱</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mail_email" required lay-verify="required" placeholder="Enter Mail Email" autocomplete="off" class="layui-input transparent-input" value="<?php echo htmlspecialchars($mail_info['mail_email'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">邮箱密码</label>
                                        <div class="layui-input-block">
                                            <input type="password" name="mail_password" required lay-verify="required" placeholder="Enter Mail Password" autocomplete="off" class="layui-input transparent-input" value="<?php echo htmlspecialchars($mail_info['mail_password'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">SMTP安全选项</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mail_smtpsecure" required lay-verify="required" placeholder="Enter Mail SMTP Secure" autocomplete="off" class="layui-input transparent-input" value="<?php echo htmlspecialchars($mail_info['mail_smtpsecure'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">SMTP端口</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mail_port" required lay-verify="required" placeholder="Enter Mail Port" autocomplete="off" class="layui-input transparent-input" value="<?php echo htmlspecialchars($mail_info['mail_port'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">发件人名称</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mail_mymail" required lay-verify="required" placeholder="Enter Mail MyMail" autocomplete="off" class="layui-input transparent-input" value="<?php echo htmlspecialchars($mail_info['mail_mymail'] ?? ''); ?>">
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
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'api/footer.php'; ?>