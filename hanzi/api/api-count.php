<?php
include '../../core/config.php';
header('Content-Type: application/json; charset=utf-8');
try {
    $db = getDb();
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
    $totalStmt = $db->query("SELECT COUNT(*) FROM api_count");
    $totalRows = $totalStmt->fetchColumn();
    $offset = ($page - 1) * $limit;
    $stmt = $db->prepare("SELECT * FROM api_count LIMIT :offset, :limit");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode([
        'code' => 0,
        'msg' => 'success',
        'count' => $totalRows,
        'data' => $data
    ]);
} catch(PDOException $e) {
    echo json_encode([
        'code' => -1,
        'msg' => '数据库查询失败',
        'error' => $e->getMessage(),
        'count' => 0,
        'data' => []
    ]);
}
?>