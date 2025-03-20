<?php
require '../../core/config.php';
$db = getDb();
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$siteInfo = $db->query("SELECT site_frequency, site_second FROM site_info")->fetch(PDO::FETCH_ASSOC);

/**
 * 获取API卡片信息
 * 
 * @param int $id API卡片的ID
 * @return mixed 返回包含api_name, api_price, harging_method, api_toll, api_counter的数组，如果未找到则返回false
 */
function getApiCardInfo($id) {
    global $db;
    $query = "SELECT api_name, api_price, harging_method, api_toll, api_counter FROM api_card WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        updateApiCounter($id, $result['api_counter'] + 1);
        return $result;
    } else {
        return false;
    }
}

/**
 * 更新API卡片的计数器
 * 
 * @param int $id API的ID
 * @param int $newCounter 新的计数器值
 */
function updateApiCounter($id, $newCounter) {
    global $db;
    $query = "UPDATE api_card SET api_counter = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$newCounter, $id]);
}

/**
 * 记录API调用
 * 
 * @param string $apiName API名称
 * @param string $userIp 用户IP地址
 */
function recordApiCall($apiName, $userIp) {
    global $db;
    $datetime = date('Y-m-d H:i:s');
    $address = getIpAddressInfo($userIp);
    $query = "INSERT INTO api_count (name, ip, datetime, address) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$apiName, $userIp, $datetime, $address]);
}

/**
 * 获取IP地址信息
 * 
 * @param string $ip IP地址
 * @return string 返回IP地址对应的地理位置信息
 */
function getIpAddressInfo($ip) {
    $url = "https://api.cenguigui.cn/api/UserInfo/?ip=".$ip;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    if ($data && $data['code'] == 200) {
        return $data['data']['area'];
    } else {
        return '未知';
    }
}

/**
 * 检查API调用并处理用户余额或会员时间
 * 
 * @param int $id API的ID
 * @param string $username 用户名
 * @return string 返回操作结果信息
 */
function checkAndProcessApiCall($id, $username) {
    global $db, $redis, $siteInfo;
    if (empty($username)) {
        return '请输入账号 账号请前往主页侧滑栏注册';
    }
    $apiInfo = getApiCardInfo($id);
    if ($apiInfo === false) {
        return getApiMessage('api_message1'); // 接口不存在 返回信息
    }

    // 如果API是免费的，直接记录调用并返回true
    if ($apiInfo['api_toll'] === '免费') {
        $userIp = $_SERVER['REMOTE_ADDR'];
        recordApiCall($apiInfo['api_name'], $userIp);
        return true;
    }

    // 如果API不是免费的，继续执行后续逻辑
    $userIp = $_SERVER['REMOTE_ADDR'];
    $sql = "SELECT user_balance, vip_time FROM user_list WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if (!$user) {
        return getApiMessage('api_message2'); // 账号不存在 返回信息
    }
    $userBalance = $user['user_balance'];
    $vipTime = strtotime($user['vip_time']);
    if ($apiInfo['harging_method'] === '会员' || $apiInfo['harging_method'] === '会员+余额') {
        if ($vipTime < time()) {
            return getApiMessage('api_message3'); // 会员到期 返回信息
        }
    }
    if ($apiInfo['harging_method'] === '余额' || $apiInfo['harging_method'] === '会员+余额') {
        if (!is_numeric($userBalance) || $userBalance < $apiInfo['api_price']) {
            return getApiMessage('api_message4'); // 余额不足 返回信息
        }
        $userBalance -= $apiInfo['api_price'];
        $sqlUpdate = "UPDATE user_list SET user_balance = ? WHERE username = ?";
        $stmtUpdate = $db->prepare($sqlUpdate);
        $stmtUpdate->execute([$userBalance, $username]);
    }

    // 检查访问频率
    $key = "api_call:{$username}";
    $frequency = $siteInfo['site_frequency'];
    $second = $siteInfo['site_second'];
    if ($redis->exists($key) && $redis->ttl($key) > 0 && $redis->get($key) >= $frequency) {
        return getApiMessage('api_message6');
    } elseif ($redis->exists($key)) {
        $expire = is_int($second) ? $second : 60;
        $redis->setex($key, $expire, 1);
    } else {
        $expire = is_int($second) ? $second : 60;
        $redis->setex($key, $expire, 1);
    }
    $redis->incr($key);

    recordApiCall($apiInfo['api_name'], $userIp);
    return true;
}
/**
 * 获取API消息
 * 
 * @param string $field 消息字段
 * @return string 返回API消息
 */
function getApiMessage($field) {
    global $db;
    $sql = "SELECT `$field` FROM api_set";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result[$field];
}