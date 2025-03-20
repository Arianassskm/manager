<?php
$directoryPath = '../';
require 'api/header.php';
function getApiCounterSum() {
    $db = getDb();
    $stmt = $db->query("SELECT SUM(api_counter) as total FROM api_card");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}
$apiCounterSum = getApiCounterSum();
function getUserListCount() {
    $db = getDb();
    $stmt = $db->query("SELECT COUNT(*) as count FROM user_list");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? 0;
}
$userListCount = getUserListCount();
function getapicount() {
    $db = getDb();
    $stmt = $db->query("SELECT COUNT(*) as count FROM api_card");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? 0;
}
$getapicount = getapicount();
function getapiclassify() {
    $db = getDb();
    $stmt = $db->query("SELECT COUNT(*) as count FROM api_classify");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? 0;
}
$getapiclassify = getapiclassify();
function getLastSixDaysApiCount() {
    $db = getDb();
    $labels = [];
    $data = [];
    for ($i = 0; $i <= 5; $i++) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM api_count WHERE DATE(datetime) = :date");
        $stmt->execute([':date' => $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['count'] > 0) {
            $labels[] = $date;
            $data[] = $result['count'];
        }
    }
    return ['labels' => $labels, 'data' => $data];
}
$apiCounts = getLastSixDaysApiCount();
?>

<div class="lyear-layout-web">
	<div class="lyear-layout-container">
		<main class="lyear-layout-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6 col-lg-3">
						<div class="card bg-success">
							<div class="card-body clearfix">
								<div class="pull-left">
									<p class="h6 text-white m-t-0">调用统计</p>
									<p class="h3 text-white m-b-0 fa-1-5x"><?php echo $apiCounterSum; ?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="card bg-primary">
							<div class="card-body clearfix">
								<div class="pull-left">
									<p class="h6 text-white m-t-0">站点用户</p>
									<p class="h3 text-white m-b-0 fa-1-5x"><?php echo $userListCount; ?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="card bg-danger">
							<div class="card-body clearfix">
								<div class="pull-left">
									<p class="h6 text-white m-t-0">接口数量</p>
									<p class="h3 text-white m-b-0 fa-1-5x"><?php echo $getapicount; ?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="card bg-purple">
							<div class="card-body clearfix">
								<div class="pull-left">
									<p class="h6 text-white m-t-0">分类数量</p>
									<p class="h3 text-white m-b-0 fa-1-5x"><?php echo $getapiclassify; ?></p>
								</div>
							</div>
						</div>
					</div>
			    	<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h4>接口调用统计</h4>
							</div>
							<div class="card-body">
								<div id="main" style="width: 100%;height:400px;"></div>
							</div>
						</div>
					</div>
					
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h4>接口调用统计</h4>
							</div>
							<div class="card-body"> <?php
                $apiCounts = getLastSixDaysApiCount();
                foreach ($apiCounts['labels'] as $index => $label) {
                    echo "<li>" . htmlspecialchars($label) . ": " . htmlspecialchars($apiCounts['data'][$index]) . "次</li>";
                }
                ?> </div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</main>
</div>
</div>

<script src="https://cdn.bootcdn.net/ajax/libs/echarts/5.3.3/echarts.min.js"></script>
<script type="text/javascript">
layui.use(['jquery'], function(){
    var $ = layui.jquery;
    var apiCounts = {
        labels: <?php echo json_encode($apiCounts['labels']); ?>,
        data: <?php echo json_encode($apiCounts['data']); ?>
    };
    
    var myChart = echarts.init(document.getElementById('main'));
    var option = {
        tooltip: {},
        xAxis: {
            data: apiCounts.labels
        },
        yAxis: {},
        series: [{
            name: '调用量',
            type: 'bar',
            data: apiCounts.data
        }]
    };
    
    myChart.setOption(option);
});
</script>
<?php include 'api/footer.php'; ?>