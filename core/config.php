<?php
$host = 'localhost';
$dbname = 'newapi';
$username = 'newapi';
$password = 'newapi';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

function getDb() {
    global $pdo;
    return $pdo;
}

?>