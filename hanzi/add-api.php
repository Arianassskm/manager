<?php
include 'api/header.php';
$websiteid = 1;
try {
    $stmt = $pdo->prepare("SELECT `id`, `site_url` FROM `site_info` WHERE `id` = ?");
    $stmt->execute([$websiteid]);
    $website = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$website) {
        die("系统异常");
    }
} catch(PDOException $e) {
    die("获取网站信息失败: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $api_name = trim($_POST['api_name'] ?? '');
    $api_url = trim($_POST['api_url'] ?? '');
    $api_chestnut = trim($_POST['api_chestnut'] ?? '');
    $api_jianjie = trim($_POST['api_jianjie'] ?? '');
    $api_canshu = trim($_POST['api_canshu'] ?? '');
    $api_state = trim($_POST['api_state'] ?? '');
    $api_toll = trim($_POST['api_toll'] ?? '');
    $api_source = trim($_POST['api_source'] ?? '');
    $harging_method = trim($_POST['harging_method'] ?? '');
    $api_price = trim($_POST['api_price'] ?? '');
    $api_classify = trim($_POST['api_classify'] ?? '');

    if (empty($api_name) || empty($api_url) || empty($api_jianjie) || empty($api_canshu)) {
        $error = '所有字段都是必填的。';
    } else {
        $stmt = $pdo->prepare('INSERT INTO api_card (api_name, api_url, api_chestnut, api_jianjie, api_canshu, api_state, api_toll, api_source, harging_method, api_price, api_classify)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bindParam(1, $api_name);
        $stmt->bindParam(2, $api_url);
        $stmt->bindParam(3, $api_chestnut);
        $stmt->bindParam(4, $api_jianjie);
        $stmt->bindParam(5, $api_canshu);
        $stmt->bindParam(6, $api_state);
        $stmt->bindParam(7, $api_toll);
        $stmt->bindParam(8, $api_source);
        $stmt->bindParam(9, $harging_method);
        $stmt->bindParam(10, $api_price);
        $stmt->bindParam(11, $api_classify);

        if ($stmt->execute()) {
            $success = 'API添加成功！';
            $error = null;
        } else {
            $error = 'API添加失败。';
        }
    }
}
try {
    $stmt = $pdo->prepare("SELECT `id`, `name` FROM `api_classify`");
    $stmt->execute();
    $apiClassify = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("获取分类信息失败: " . $e->getMessage());
}
?> <main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<ul class="nav nav-tabs page-tabs">
						<li class="active"> <a href="add-api.php">添加接口</a> </li>
						<li class="active"> <a href="change-api.php">管理接口</a> </li>
						<li class="active"> <a href="api-message.php">接口信息</a> </li>
						<li class="active"> <a href="movie.php">影视接口</a> </li>
						<li class="active"> <a href="pic.php">图片接口</a> </li>
					</ul>
					<div class="layui-container">
						<div class="layui-row">
							<div class="content-box"> <?php if (isset($success)): ?> <div class="layui-bg-green layui-text" style="margin-bottom:15px;"> <?php echo $success; ?> </div> <?php elseif (isset($error)): ?> <div class="layui-bg-red layui-text" style="margin-bottom:15px;">
									<?php echo $error; ?> </div> <?php endif; ?> <form class="layui-form" action="add-api.php" method="post">
									<div class="layui-form-item">
										<label class="layui-form-label">API名称</label>
										<div class="layui-input-block">
											<input type="text" name="api_name" required lay-verify="required" placeholder="输入要添加的API名称" autocomplete="off" class="layui-input">
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">API链接</label><br>
										<div class="layui-input-block">
											<textarea name="api_url" required lay-verify="required" placeholder="输入要添加的API链接:<?php echo nl2br(
                            $website["site_url"]
                        ); ?>api/接口存放目录名称" autocomplete="off" class="layui-textarea"><?php echo nl2br(
    $website["site_url"]
); ?>api/</textarea>
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">API实例</label>
										<div class="layui-input-block">
											<textarea name="api_chestnut" required lay-verify="required" placeholder="输入要添加的API实例:<?php echo nl2br(
                            $website["site_url"]
                        ); ?>api/接口存放目录名称" autocomplete="off" class="layui-textarea"><?php echo nl2br(
    $website["site_url"]
); ?>api/?username=</textarea>
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">API简介</label>
										<div class="layui-input-block">
											<textarea name="api_jianjie" required lay-verify="required" placeholder="输入要添加的API简介" class="layui-textarea"></textarea>
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">API参数</label>
										<div class="layui-input-block">
											<textarea name="api_canshu" required lay-verify="required" class="layui-textarea" placeholder="">
<table class="custom-table">
  <thead>
  <tr>
   <th scope="row">参数</th>
   <th>说明</th>
   <th>必选</th>
  </tr>
  </thead>
  <tbody>
  <tr>
   <td>username</td>
   <td>你的账号</td>
   <td>是</td>
  </tr>
  </tbody>
</table>                            
                        </textarea>
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">运行状态</label>
										<div class="layui-input-block">
											<select name="api_state" required lay-verify="required" class="layui-select">
												<option value="">请选择状态</option>
												<option value="正常">正常</option>
												<option value="异常">异常</option>
												<option value="维护">维护</option>
												<option value="未知">未知</option>
											</select>
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">收费状态</label>
										<div class="layui-input-block">
											<select name="api_toll" required lay-verify="required" class="layui-select">
												<option value="">请选择状态</option>
												<option value="免费">免费</option>
												<option value="收费">收费</option>
											</select>
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">收费方式</label>
										<div class="layui-input-block">
											<select name="harging_method" required lay-verify="required" class="layui-select">
												<option value="">请选择状态</option>
												<option value="会员">会员</option>
												<option value="余额">余额</option>
												<option value="会员+余额">会员+余额</option>
											</select>
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">接口费用</label>
										<div class="layui-input-block">
											<input type="text" name="api_price" required lay-verify="required" placeholder="当开启余额收费模式时此费用系统才会生效" autocomplete="off" class="layui-input">
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">开源状态</label>
										<div class="layui-input-block">
											<select name="api_source" required lay-verify="required" class="layui-select">
												<option value="">请选择状态</option>
												<option value="开源">开源</option>
												<option value="闭源">闭源</option>
											</select>
										</div>
									</div>
									<div class="layui-form-item">
										<label class="layui-form-label">接口分类</label>
										<div class="layui-input-block">
											<select name="api_classify" required lay-verify="required" class="layui-select">
												<option value="">请选择分类</option> <?php foreach ($apiClassify as $classify): ?> <option value="<?php echo $classify['id']; ?>"><?php echo $classify['name']; ?></option> <?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="layui-form-item">
										<div class="layui-input-block">
											<button class="layui-btn" lay-submit lay-filter="formDemo">确认添加</button>
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
</main> <?php include 'api/footer.php';?>