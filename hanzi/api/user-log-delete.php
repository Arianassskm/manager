<?php
include '../../core/config.php';
header('Content-Type: application/json; charset=utf-8');
try {
    $db = getDb();
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('ID参数未提供');
    }
    $id = $_POST['id'];
    $stmt = $db->prepare("DELETE FROM user_log WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'code' => 0,
            'msg' => '删除成功'
        ]);
    } else {
        echo json_encode([
            'code' => -1,
            'msg' => '删除失败：未找到对应记录'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'code' => -1,
        'msg' => '数据库操作失败',
        'error' => $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'code' => -1,
        'msg' => $e->getMessage()
    ]);
}
?>