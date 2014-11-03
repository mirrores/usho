<?php

/**
 * 向浏览器友输出友好的变量或对象
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $strict = true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo($output);
        return null;
    } else
        return $output;
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
function redirect($url, $time = 0, $msg = '') {
//多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
// redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}

/**
 * 获取星期
 * @static
 * @access public
 * @param datetime $date 原始日期
 * @return string 返回星期
 * @example
 */
function getWeek($date) {
    $week = array('0' => '星期日', '1' => '星期一', '2' => '星期二', '3' => '星期三', '4' => '星期四', '5' => '星期五', '6' => '星期六');
    $dateArr = explode("-", date('Y-n-d', strtotime($date)));
    return $week[date("w", mktime(0, 0, 0, $dateArr[1], $dateArr[2], $dateArr[0]))];
}

/**
 * 个性化日期显示
 * @static
 * @access public
 * @param datetime $times 日期
 * @return string 返回大致日期
 * @example 示例 ueTime('')
 */
function ueTime($times) {
    if ($times == '' || $times == 0) {
        return false;
    }
//完整时间戳
    $strtotime = is_int($times) ? $times : strtotime($times);
    $times_day = date('Y-m-d', $strtotime);
    $times_day_strtotime = strtotime($times_day);

//今天
    $nowdate_str = strtotime(date('Y-m-d'));

//精确的时间间隔(秒)
    $interval = time() - $strtotime;

//今天的
    if ($times_day_strtotime == $nowdate_str) {

//小于一分钟
        if ($interval < 60) {
            $pct = sprintf("%d秒前", $interval);
        }
//小于1小时
        elseif ($interval < 3600) {
            $pct = sprintf("%d分钟前", ceil($interval / 60));
        } else {
            $pct = sprintf("%d小时前", floor($interval / 3600));
        }
    }
//昨天的
    elseif ($times_day_strtotime == strtotime(date('Y-m-d', strtotime('-1 days')))) {
        $pct = '昨天' . date('H:i', $strtotime);
    }
//前天的
    elseif ($times_day_strtotime == strtotime(date('Y-m-d', strtotime('-2 days')))) {
        $pct = '前天' . date('H:i', $strtotime);
    }
//一个月以内
    elseif ($interval < (3600 * 24 * 30)) {
        $pct = date('m月d日', $strtotime);
    }
//一年以内
    elseif ($interval < (3600 * 24 * 365)) {
        $pct = date('m月d日', $strtotime);
    }
//一年以上
    else {
        $pct = date('Y年m月d日', $strtotime);
    }
    return $pct;
}
