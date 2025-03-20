<?php include 'api/header.php'; $db = getDb(); $success = false; $error = false; if ($_SERVER["REQUEST_METHOD"] == "POST") { $quantity = (int)$_POST['quantity']; if (isset($_POST['balance'])) { $balance = $_POST['balance']; $sql = "INSERT INTO api_key (`key`, `balance`) VALUES (:key, :balance)"; } else { $duration = $_POST['duration']; $initialDate = '0000-00-00 00:00:00'; $balance = date('Y-m-d H:i:s', strtotime("+{$duration} days", strtotime($initialDate))); switch ($duration) { case '3': $vip = '3'; break; case '7': $vip = '7'; break; case '15': $vip = '15'; break; case '30': $vip = '31'; break; case '90': $vip = '90'; break; case '180': $vip = '181'; break; case '365': $vip = '365'; break; case '1095': $vip = '1095'; break; case '1825': $vip = '1825'; break; default: $vip = '0'; break; } $sql = "INSERT INTO api_key (`key`, `balance`, `vip`) VALUES (:key, :balance, :vip)"; } $stmt = $db->prepare($sql); function generateRandomKey() { $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; $randomString = ''; for ($i = 0; $i < 12; $i++) { $randomString .= $characters[rand(0, strlen($characters) - 1)]; } return substr($randomString, 0, 4) . '-' . substr($randomString, 4, 4) . '-' . substr($randomString, 8); } for ($i = 0; $i < $quantity; $i++) { $key = generateRandomKey(); if (isset($vip)) { $stmt->execute(['key' => $key, 'balance' => $balance, 'vip' => $vip]); } else { $stmt->execute(['key' => $key, 'balance' => $balance]); } } if ($stmt->rowCount() === $quantity) { $success = "创建成功"; } else { $error = "创建失败"; } } ?>
<main class="lyear-layout-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="layui-bg-green layui-text" style="margin-bottom:15px;"> <?php echo $success; ?> <?php echo $error; ?> </div>
					<button style="margin-bottom: 20px;margin-top: 20px" class="layui-btn" id="simpleFormBtn">余额密钥</button>
					<button style="margin-bottom: 20px;margin-top: 20px" class="layui-btn" id="advancedFormBtn">会员密钥</button>
					<form method="post" action="" id="simpleForm" style="display:none;">
						<input class="layui-input" type="number" name="quantity" placeholder="生成密钥的数量"><br>
						<input class="layui-input" type="text" name="balance" placeholder="余额额度"><br>
						<button class="layui-btn" type="submit">确定</button>
					</form>
					<form method="post" action="" id="advancedForm" style="display:none;">
						<input class="layui-input" type="number" name="quantity" placeholder="生成密钥的数量"><br>
						<select class="layui-input" name="duration">
							<option value="3">3天</option>
							<option value="7">7天</option>
							<option value="15">15天</option>
							<option value="30">一个月</option>
							<option value="90">三个月</option>
							<option value="180">6个月</option>
							<option value="365">1年</option>
							<option value="1095">3年</option>
							<option value="1825">5年</option>
						</select><br>
						<button style="margin-bottom: 20px;margin-top: 20px" class="layui-btn" type="submit">确定</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>
</main> <?php include 'api/footer.php';?> <script>
	document.getElementById('simpleFormBtn').addEventListener('click',function(){document.getElementById('simpleForm').style.display='block';document.getElementById('advancedForm').style.display='none'});document.getElementById('advancedFormBtn').addEventListener('click',function(){document.getElementById('simpleForm').style.display='none';document.getElementById('advancedForm').style.display='block'});
</script>