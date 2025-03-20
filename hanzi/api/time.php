<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['timeUnit']) && isset($_GET['duration']) && isset($_GET['returnUnit'])) {
    $timeUnit = $_GET['timeUnit'];
    $duration = intval($_GET['duration']);
    $returnUnit = $_GET['returnUnit'];
    function convertTime($timeUnit, $duration, $returnUnit) {
        $seconds = match ($timeUnit) {
            'year' => $duration * 365 * 24 * 60 * 60,
            'month' => $duration * 30 * 24 * 60 * 60,
            'day' => $duration * 24 * 60 * 60,
            'hour' => $duration * 60 * 60,
            'minute' => $duration * 60,
            default => 0,
        };
        return match ($returnUnit) {
            'year' => $seconds / (365 * 24 * 60 * 60),
            'month' => $seconds / (30 * 24 * 60 * 60),
            'day' => $seconds / (24 * 60 * 60),
            'hour' => $seconds / (60 * 60),
            'minute' => $seconds / 60,
            'second' => $seconds,
            default => 0,
        };
    }
    $result = convertTime($timeUnit, $duration, $returnUnit);
    header('Content-Type: application/json');
    echo json_encode(array('result' => $result));
} else {
    header('Content-Type: application/json');
    echo json_encode(array('error' => '接口异常'));
}
?>