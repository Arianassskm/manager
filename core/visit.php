<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$visits = $redis->incrby('visit-count', 1);
echo $visits;
?>