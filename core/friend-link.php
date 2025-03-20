<?php
$name = isset($_GET['name']) ? $_GET['name'] : '';
$url = isset($_GET['url']) ? $_GET['url'] : '';
$head_url = isset($_GET['head_url']) ? $_GET['head_url'] : '';
$create_time = isset($_GET['create_time']) ? $_GET['create_time'] : '';
$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
$whereClause = [];
$params = [];
$whereClause[] = "state = '审核通过'";
if ($name) {
    $whereClause[] = "name LIKE :name";
    $params[':name'] = "%$name%";
}
if ($url) {
    $whereClause[] = "url LIKE :url";
    $params[':url'] = "%$url%";
}
if ($head_url) {
    $whereClause[] = "head_url LIKE :head_url";
    $params[':head_url'] = "%$head_url%";
}
if ($user_name) {
    $whereClause[] = "user_name LIKE :user_name";
    $params[':user_name'] = "%$user_name%";
}
if ($create_time) {
    $whereClause[] = "create_time = :create_time";
    $params[':create_time'] = $create_time;
}
$sql = "SELECT id, name, url, head_url, create_time , user_name FROM friend_link";
if (!empty($whereClause)) {
    $sql .= " WHERE " . implode(' AND ', $whereClause);
}
$stmt = getDb()->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>