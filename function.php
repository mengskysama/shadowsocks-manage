<?php

$COOKIEEXPTIME = 3600 * 24;
$BASEURL = 'mdss.mengsky.net';
$mysql_host = '127.0.0.1';
$mysql_user = 'root';
$mysql_pass = 'nicaicai';
$mysql_db = 'shadowsocks';
$init_transfer = 1024 * 1024 * 1024;
$arr_server = array(
    array('uri' => 'http://mdss01.mengsky.net:80', 'key' => 'nicaicai', 'type' => 1)
    //,
    //array('uri'=>'http://mdss10.mengsky.net:80', 'key'=>'nicaicai', 'type'=>1)
);


$account_id = 0;
$account_email = '';

date_default_timezone_set('PRC');

function get_ip()
{
    if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) {
        $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
    } elseif ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) {
        $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else {
        $ip = "Unknown";
    }
    return $ip;
}

function log_ip($id)
{

}

function get_rand_passwd($length)
{
    $str = '';
    $arr_chars = '0123456789';
    $max = strlen($arr_chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $arr_chars[rand(0, $max)];
    }
    return $str;
}

function format_transfer($t)
{
    $units = array("B", "KB", "MB", "GB");
    $level = 0;
    while ($t > 1024) {
        $t /= 1024.0;
        $level++;
    }
    return sprintf("%01.2f", $t) . $units[$level];
}

function getIPv4()
{
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    return '0.0.0.0';
}

function getmd5()
{
    return md5(md5(microtime()));
}

//0 浏览器进程
//
function makecookie($id, $keeplogin = true)
{
    global $COOKIEEXPTIME;
    //生成一个足够复杂的md5
    $md5 = getmd5();
    //防止伪造remote地址注入
    $ip = mysql_real_escape_string(getIPv4());
    $time = time();
    $sql = "INSERT INTO `cookie` (`hash`, `id`, `ip` , `time`) VALUES ('$md5', $id, '$ip', $time)";
    mysql_query($sql);
    setcookie('u2', $md5, $keeplogin == true ? time() + $COOKIEEXPTIME : 0);
}

function getuid()
{
    global $account_id;
    return $account_id;
}

function getemail()
{
    global $account_email;
    return $account_email;
}

//检查cookie有效性
function checklogin($jump_login = True)
{
    global $COOKIEEXPTIME;
    global $BASEURL;
    global $account_id;
    global $account_email;

    if (!isset($_COOKIE['u2'])) {
        if ($jump_login == True)
            header("Location: " . get_protocol_prefix() . "$BASEURL/login.php");
        return false;
    }

    #其他Cookie在CleanUp中清除

    $cookie = mysql_real_escape_string($_COOKIE['u2']);
    $sql = "SELECT * FROM `cookie` WHERE `hash` = '$cookie'";
    $result = mysql_query($sql);
    if ($result) {
        if ($row = mysql_fetch_array($result)) {
            if ($row['time'] < time() - $COOKIEEXPTIME) {
                //已经作废!删除客户端饼干
                setcookie('u2', '', time() - 2333);
                //清掉服务器记录
                $sql = "DELETE FROM `cookie` WHERE `hash` = '$cookie'";
                mysql_query($sql);
                if ($jump_login == True)
                    header("Location: " . get_protocol_prefix() . "$BASEURL/login.php");
                return false;
            }
            $account_id = $row['id'];
            $sql = "SELECT email FROM `user` WHERE `id` = '$account_id'";
            $result = mysql_query($sql);
            if ($result) {
                if ($row = mysql_fetch_array($result))
                    $account_email = $row['email'];
                else
                    die('get_account_id_err');
            } else
                die('get_account_id_err');
            return true;
        }
    }
    if ($jump_login == True)
        header("Location: " . get_protocol_prefix() . "$BASEURL/login.php");
    return false;
}

function get_protocol_prefix()
{
    global $securelogin;
    if ($securelogin == "yes") {
        return "https://";
    } elseif ($securelogin == "no") {
        return "http://";
    } else {
        if (!isset($_COOKIE["c_secure_ssl"])) {
            return "http://";
        } else {
            return base64_decode($_COOKIE["c_secure_ssl"]) == "yeah" ? "https://" : "http://";
        }
    }
}

function dbconn($autoclean = false)
{
    global $mysql_host;
    global $mysql_user;
    global $mysql_pass;
    global $mysql_db;
    if (!mysql_connect($mysql_host, $mysql_user, $mysql_pass)) {
        switch (mysql_errno()) {
            case 1040:
            case 2002:
                die("<html><head><meta http-equiv=refresh content=\"10 $_SERVER[REQUEST_URI]\">
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
                </head><body><table border=0 width=100% height=100%><tr><td><h3 align=center>"
                    . 'server load very high' . "</h3></td></tr></table></body></html>");
            default:
                die("[" . mysql_errno() . "] dbconn: mysql_connect: " . mysql_error());
        }
    }

    mysql_query("SET NAMES UTF8");
    mysql_query("SET collation_connection = 'utf8_general_ci'");
    mysql_query("SET sql_mode=''");
    mysql_select_db($mysql_db) or die('dbconn: mysql_select_db: ' + mysql_error());
}

function print_navbar()
{
    ?>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target=".navbar-collapse">
                        <span class="sr-only">
Toggle navigation
</span>
                        <span class="icon-bar">
                        </span>
                        <span class="icon-bar">
                        </span>
                        <span class="icon-bar">
                        </span>
                </button>
                <a class="navbar-brand" href="#">
                    MakeDieSS
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?PHP
                    $arr_pages = array(
                        array('panel.php', '面板'),
                        array('about.php', '关于'),
                        array('contact.php', '联系我'),
                        array('tsukomi.php', '吐槽板')
                    );
                    $page = end(explode('/', $_SERVER['PHP_SELF']));
                    foreach ($arr_pages as $p) {
                        if ($p[0] == $page)
                            echo '<li class="active"><a href="#">' . $p[1] . '</a></li>';
                        else
                            echo '<li><a href="' . $p[0] . '">' . $p[1] . '</a></li>';
                    }
                    ?>
                </ul>
                <?PHP
                global $account_id;
                if ($account_id > 0) {
                    $sql = "SELECT  email FROM `user` WHERE `id` = '{$account_id}'";
                    $result = mysql_query($sql);
                    if ($row = mysql_fetch_array($result)) {
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="">
                                    <?php echo $row['email']; ?>
                                </a>
                            </li>
                            <li>
                                <a id="logout" href="logout.php">
                                    注销
                                </a>
                            </li>
                        </ul>
                    <?PHP
                    }
                }
                ?>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
<?PHP
}
?>