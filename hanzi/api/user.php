<?php
require_once "../../core/config.php";
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM user_list WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(['code' => 0, 'msg' => '删除成功!']);
    } else {
        echo json_encode(['code' => 1, 'msg' => '系统异常...']);
    }
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $username = $pdo->quote($_POST['username']);
    $email = $pdo->quote($_POST['email']);
    $reg_time = $pdo->quote($_POST['reg_time']);
    $user_balance = $pdo->quote($_POST['user_balance']);
    $vip_time = $pdo->quote($_POST['vip_time']);
    $reg_ip = $pdo->quote($_POST['reg_ip']);
    $user_qq = $pdo->quote($_POST['user_qq']);
    $state = $pdo->quote($_POST['state']);

    $stmt = $pdo->prepare("UPDATE user_list SET username = $username, email = $email, reg_time = $reg_time, user_balance = $user_balance, vip_time = $vip_time, reg_ip = $reg_ip, user_qq = $user_qq, state = $state WHERE id = $id");
    $stmt->execute();
    echo json_encode(['code' => 0, 'msg' => '更新成功!']);
    exit;
}
$stmt = $pdo->prepare("SELECT `id`, `username`, `email`, `reg_time`, `user_balance`, `vip_time`, `reg_ip`, `user_qq`, `state` FROM user_list");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['data' => $users]);
exit;
?>