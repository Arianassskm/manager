<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'];
    $dbname = $_POST['dbname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $config = "<?php\n";
    $config .= "\$host = '$host';\n";
    $config .= "\$dbname = '$dbname';\n";
    $config .= "\$username = '$username';\n";
    $config .= "\$password = '$password';\n";
    $config .= "try {\n";
    $config .= "    \$pdo = new PDO(\"mysql:host=\$host;dbname=\$dbname;charset=utf8\", \$username, \$password);\n";
    $config .= "    \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n";
    $config .= "} catch(PDOException \$e) {\n";
    $config .= "    die(\"数据库连接失败: \" . \$e->getMessage());\n";
    $config .= "}\n";
    $config .= "function getDb() {\n";
    $config .= "    global \$pdo;\n";
    $config .= "    return \$pdo;\n";
    $config .= "}\n";
    $config .= "?>";
    $configFilePath = '../core/config.php';
    if (file_exists($configFilePath)) {
        if (!unlink($configFilePath)) {
            die("无法重置core/config.php文件，请检查文件权限。");
        }
    }
    if (!file_put_contents($configFilePath, $config)) {
        die("无法写入config.php文件，请检查core目录权限。");
    }
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = file_get_contents('install.sql');
        $pdo->exec($sql);
        header('Location: /index.php');
        exit();
    } catch (PDOException $e) {
        die("数据库初始化失败: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HanziのApi安装程序</title>
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.header h1 {
    font-size: 2.5em;
    margin-bottom: 10px;
    color: #ff6f61;
}

.header p {
    font-size: 1.2em;
    color: #555;
}

.form-container {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-group input {
    width: 95%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
    margin-right: 10px;
}

.submit-btn {
    background: #ff6f61;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 1.2em;
    cursor: pointer;
    transition: background 0.3s ease;
}

.submit-btn:hover {
    background: #ff3b2f;
}

.footer {
    margin-top: 20px;
    font-size: 0.9em;
    color: #777;
}

.disabled-btn {
    background: #ccc;
    color: #777;
    cursor: not-allowed;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>HanziのApi安装程序</h1>
        </div>
        <div class="form-container">
            <form method="post" id="db-form">
                <div class="form-group">
                    <label for="host">数据库主机</label>
                    <input type="text" id="host" placeholder="localhost" name="host" required>
                </div>
                <div class="form-group">
                    <label for="dbname">数据库名称</label>
                    <input type="text" id="dbname" name="dbname" required>
                </div>
                <div class="form-group">
                    <label for="username">数据库用户名</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">数据库密码</label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit" class="submit-btn" id="install-btn">安装</button>
            </form>
        </div>
        <div class="footer">
            <p>© 2025 HanziのApi</p>
            <p>安装完请将install文件夹删除,防止系统泄露!</p>
        </div>
    </div>
    <script>
        const phpVersion = <?php echo json_encode(PHP_VERSION); ?>;
        const version = phpVersion.split('.').map(Number);
        const minVersion = [8, 0, 0];
        const isVersionValid = version[0] > minVersion[0] || (version[0] === minVersion[0] && version[1] > minVersion[1]) || (version[0] === minVersion[0] && version[1] === minVersion[1] && version[2] >= minVersion[2]);
        const installBtn = document.getElementById('install-btn');
        if (!isVersionValid) {
            installBtn.classList.add('disabled-btn');
            installBtn.disabled = true;
            alert('当前 PHP 版本低于 8.0，无法进行安装。');
        }
        const form = document.getElementById('db-form');
        form.addEventListener('submit', function(event) {
            const inputs = form.querySelectorAll('input[required]');
            for (let input of inputs) {
                if (!input.value.trim()) {
                    event.preventDefault();
                    alert('请将数据库信息输入完整。');
                    return;
                }
            }
        });
    </script>
</body>
</html>