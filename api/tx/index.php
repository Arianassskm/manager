<?php

$qq = new tx();
print_r($qq->GetUrl('https://v.qq.com/txp/iframe/player.html?vid=b4100e0q4at'));

class tx {
    static function GetUrl($url = 0) {//解析视频地址
        $url = tx::ToUrl(isset($url) ? $url : $_GET['url']);
        $tm = time();
        $day = date("w") == '0' ? '7' : date("w");
        $vid = tx::GetVid($url);
        $ckey = tx::GetCkey($url, $vid, $tm);
        $api = 'https://vd.l.qq.com/proxyhttp';
        $cookie = 'luin=o1538236552;lskey=000100002f5807ee11112ae5823936dfc93e8c29f02f1ef89f275c7a81f699071f307290eebb538ac41130f8';
        $post = json_encode(array(
            'buid' => 'vinfoad',
            'vinfoparam' => 'otype=ojson&platform=10201&ehost=' . $url . '&refer=v.qq.com&sphttps=1&tm=' . $tm . '&spwm=4&vid=' . $vid . '&defn=fhd&fhdswitch=0&show1080p=1&isHLS=1&dtype=3&sphls=2&spgzip=1&dlver=2&drm=32&spau=1&spaudio=15&defsrc=2&encryptVer=7.' . $day . '&cKey=' . $ckey . '&fp2p=1'
        ));
        $ret = self::get_curl($api, $post, $cookie);
        $ret = json_decode($ret, true);
        if (is_array($ret) && $ret['errCode'] == '0') {
            $ret = json_decode($ret['vinfo'], true);
            $ret = array(
                'name' => $ret['vl']['vi']['0']['ti'],
                'url' => $ret['vl']['vi']['0']['ul']['ui']['3']['url']
            );
            return $ret;
        } else
            return false;
    }
    static function getinaurl($longurl) {
        $appkey = '31641035';
        $url = 'https://api.weibo.com/2/short_url/shorten.json?source=' . $appkey . '&url_long=' . urlencode($longurl);
        $result = self::curl_get($url);
        $arr = json_decode($result, true);
        return isset($arr['urls'][0]['url_short']) ? $arr['urls'][0]['url_short'] : false;
    }
    static function ToUrl($url = 0) {
        if (preg_match('/m.v.qq.com/', $url)) {
            preg_match('/w\/(\w+){1,20}\//', $url, $ret);
            $url = 'https://v.qq.com/x/cover/' . $ret[1] . '.html';
            return $url;
        } else
            return $url;
    }
    static function GetVid($url) {
        preg_match('/vid=(\w+){1,20}&/', self::get_curl($url), $ret);
        return $ret[1];
    }
    static function GetCkey($url = null, $vid = null, $tm = Null) {
        // ckey7=md5 ( key + vid + tm + "*#06#" + platform );
        $platform = '10201';
        $day = date("w") == '0' ? '7' : date("w");
        switch ($day) {
            case '1':
                $key = '06fc1464';
                break;
            case '2':
                $key = '4244ce1b';
                break;
            case '3':
                $key = '77de31c5';
                break;
            case '4':
                $key = 'e0149fa2';
                break;
            case '5':
                $key = '60394ced';
                break;
            case '6':
                $key = '2da639f0';
                break;
            case '7': // 星期天
                $key = 'c2f0cf9f';
                break;
        }
        $ckey = md5($key . $vid . $tm . "*#06#" . $platform);
        return $ckey;
    }
    static function get_curl($url, $post = 0, $cookie = 0, $header = 0, $referer = 0, $ua = 0, $nobaody = 0, $proxy = 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $httpheader[] = "Accept:*/*";
        $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
        $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
        $httpheader[] = "Connection:close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($referer) {
            if ($referer == 1) {
                curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
            } else {
                curl_setopt($ch, CURLOPT_REFERER, $referer);
            }
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        if ($proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
}