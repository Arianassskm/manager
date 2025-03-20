<?php
header('Content-Type: text/html; charset=utf-8');
$logDir = __DIR__ . '/log';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}
function getmappingfilepath() {
    $sessionId = session_id();
    return $GLOBALS['logDir'] . "/id_mapping_{$sessionId}.txt";
}
if (isset($_GET['keywords'])) {
    echo '<div>' . search($_GET['keywords'], isset($_GET['page']) ? (int)$_GET['page'] : 1) . '</div>';
} elseif (isset($_GET['id'])) {
    musicurl($_GET['id']);
} elseif (isset($_GET['lyric_id'])) {
    getlyric($_GET['lyric_id']);
} else {
    echo '<div>请按照参数输入</div>';
}
function search($keywords, $page = 1) {
    $searchUrl = "http://music.lovestory.wiki/cloudsearch?keywords=" . urlencode($keywords) . "&limit=5&offset=" . (($page - 1) * 5);
    $response = @file_get_contents($searchUrl);
    if ($response === false) {
        return "无法连接到搜索接口";
    }
    $data = json_decode($response, true);
    if ($data['code'] == 200 && isset($data['result']['songs'])) {
        $songs = $data['result']['songs'];
        $output = [];
        $idMap = [];
        foreach ($songs as $index => $song) {
            $id = $song['id'];
            $name = $song['name'];
            $artistName = $song['ar'][0]['name'] ?? '';
            $output[] = ($index + 1 + ($page - 1) * 5) . ". " . $name . " - " . $artistName;
            $idMap[$index + 1 + ($page - 1) * 5] = $id;
        }
        $mappingFilePath = getmappingfilepath();
        $fileHandle = @fopen($mappingFilePath, 'w');
        if ($fileHandle) {
            if (flock($fileHandle, LOCK_EX)) {
                fwrite($fileHandle, json_encode($idMap));
                flock($fileHandle, LOCK_UN);
            }
            fclose($fileHandle);
        }
        return implode("<br>", $output);
    } else {
        return "未找到结果。";
    }
}
function musicurl($id) {
    $mappingFilePath = getmappingfilepath();
    if (!file_exists($mappingFilePath)) {
        echo '<div>会话/ID 已结束</div>';
        return;
    }
    $fileHandle = @fopen($mappingFilePath, 'r');
    if ($fileHandle) {
        if (flock($fileHandle, LOCK_SH)) {
            $idMap = json_decode(fread($fileHandle, filesize($mappingFilePath)), true);
            flock($fileHandle, LOCK_UN);
        }
        fclose($fileHandle);
    } else {
        echo '<div>无法打开映射文件</div>';
        return;
    }
    if (!isset($idMap[$id])) {
        echo '<div>会话/ID 已结束</div>';
        return;
    }
    $musicId = $idMap[$id];
    $url = "http://music.lovestory.wiki/song/url?id=" . $musicId;
    $response = @file_get_contents($url);
    if ($response === false) {
        echo '<div>无法连接到音乐链接接口</div>';
        return;
    }
    $data = json_decode($response, true);
    if ($data['code'] == 200 && isset($data['data'][0]['url'])) {
        $musicUrl = $data['data'][0]['url'];
        $musicContent = @file_get_contents($musicUrl);
        if ($musicContent !== false) {
            header('Content-Type: audio/mpeg');
            echo $musicContent;
        } else {
            echo '<div>无法获取音乐内容</div>';
        }
    } else {
        echo '<div>会话/ID 已结束 无法查找音乐</div>';
    }
}
function getlyric($id) {
    $mappingFilePath = getmappingfilepath();
    if (!file_exists($mappingFilePath)) {
        echo '<div>会话/ID 已结束</div>';
        return;
    }
    $fileHandle = @fopen($mappingFilePath, 'r');
    if ($fileHandle) {
        if (flock($fileHandle, LOCK_SH)) {
            $idMap = json_decode(fread($fileHandle, filesize($mappingFilePath)), true);
            flock($fileHandle, LOCK_UN);
        }
        fclose($fileHandle);
    } else {
        echo '<div>无法打开映射文件</div>';
        return;
    }
    if (!isset($idMap[$id])) {
        echo '<div>会话/ID 已结束</div>';
        return;
    }
    $musicId = $idMap[$id];
    $lyricUrl = "http://music.lovestory.wiki/lyric?id=" . $musicId;
    $response = @file_get_contents($lyricUrl);
    if ($response === false) {
        echo '<div>无法连接到歌词接口</div>';
        return;
    }
    $data = json_decode($response, true);
    if ($data['code'] == 200 && isset($data['lrc']['lyric'])) {
        $lyric = $data['lrc']['lyric'];
        $lyric = htmlspecialchars($lyric);
        $lyric = str_replace("\n", "<br>", $lyric);
        echo '<div>' . $lyric . '</div>';
    } else {
        echo '<div>会话/ID 已结束</div>';
    }
}
session_start();