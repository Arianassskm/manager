<?php
session_start();
require 'core/config.php';
require 'core/visit.php';
function huoqushuju($pdo, $query, $params = []) {
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("数据库查询失败: " . $e->getMessage());
        return [];
    }
}
function huoqudange($pdo, $query, $params = []) {
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("数据库查询失败: " . $e->getMessage());
        return null;
    }
}
function huoquyonghushuliang($pdo) {
    $result = huoqudange($pdo, "SELECT COUNT(*) AS count FROM user_list");
    return $result['count'] ?? 0;
}
function huoqujishu($pdo, $date) {
    $result = huoqudange($pdo, "SELECT COUNT(*) as total FROM api_count WHERE DATE(datetime) = :date", [':date' => $date]);
    return $result['total'] ?? 0;
}
function huoqujintianjishu($pdo) {
    return huoqujishu($pdo, date('Y-m-d'));
}
function huoquzuotianjishu($pdo) {
    return huoqujishu($pdo, date('Y-m-d', strtotime('-1 day')));
}
function huoqujishuzonghe($pdo) {
    $result = huoqudange($pdo, "SELECT SUM(api_counter) as total FROM api_card");
    return $result['total'] ?? 0;
}
function huoqujiekouzongshu($pdo) {
    $result = huoqudange($pdo, "SELECT COUNT(*) AS count FROM api_card");
    return $result['count'] ?? 0;
}
function huoquapifenleishuliang($pdo) {
    $result = huoqudange($pdo, "SELECT COUNT(*) AS count FROM api_classify");
    return $result['count'] ?? 0;
}
$fenleishuliang = huoquapifenleishuliang($pdo);
$apizongshu = huoqujiekouzongshu($pdo);
$todayCount = huoqujintianjishu($pdo);
$yesterdayCount = huoquzuotianjishu($pdo);
$apiCounterSum = huoqujishuzonghe($pdo);
$用户总数 = huoquyonghushuliang($pdo);
?>