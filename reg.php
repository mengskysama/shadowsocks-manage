<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com>                        |
// |          Your Name <you@example.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id:$
session_start();
include('Captcha/CaptchaBuilderInterface.php');
include('Captcha/PhraseBuilderInterface.php');
include('Captcha/CaptchaBuilder.php');
include('Captcha/PhraseBuilder.php');
use Gregwar\Captcha\CaptchaBuilder;

require 'function.php';
dbconn(true);
global $BASEURL;
$err_msg = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    do {
        //POST
        if (!isset($_POST['email']) || !isset($_POST['pass']) || !isset($_POST['vcode']) || !isset($_POST['vcode2'])) {
            $err_msg = '你在搞什么?';
            break;
        }
        //检查验证码
        if (strtolower($_POST['vcode2']) != 'v2ex') {
            $err_msg = '邀请码错误!';
            break;
        }
        //检查验证码
        if (!isset($_SESSION['phrase']) || strtolower($_POST['vcode']) != $_SESSION['phrase']) {
            $err_msg = '验证码错误!';
            $_SESSION['phrase'] = '';
            break;
        }
        $_SESSION['phrase'] = '';
        $email = mysql_real_escape_string($_POST['email']);
        $pass = mysql_real_escape_string($_POST['pass']);
        //长度检查
        if (strlen($email) > 32) {
            $err_msg = '邮箱长度非法!';
            break;
        }
        if (strlen($pass) > 16) {
            $err_msg = '密码长度非法!';
            break;
        }
        preg_match("/^[0-9a-z._]+@(([0-9a-z]+)[.])+[a-z]{2,}$/", strtolower($_POST['email']), $re);
        if ($re == null) {
            $err_msg = '邮箱格式错误!';
            break;
        }
        //检查是否已经注册
        $sql = "SELECT id FROM `user` WHERE `email` = '$email'";
        $result = mysql_query($sql);
        if ($result && mysql_num_rows($result) > 0) {
            $err_msg = '邮箱已经注册!';
            break;
        }
        //找一个端口
        $sql = "select max(port) as port from user";
        $result = mysql_query($sql);
        $port = 50000;
        if ($row = mysql_fetch_array($result)) {
            $max_port = intval($row['port']);
            if ($max_port != 0) {
                $port = $max_port + 1;
            }
        }
        $passwd = get_rand_passwd(8);
        //插入注册用户数据
        $sql = "INSERT INTO `user` (`email`, `pass`, `passwd`, `u`, `d`, `transfer_enable`, `port`) VALUES ('$email', '$pass', '$passwd', '0', '0', '$init_transfer', '$port')";
        $result = mysql_query($sql);
        if (!$result) {
            $err_msg = '发生错误!';
            break;
        }
        $err_msg = '注册成功!<a href="login.php" class="btn">登录</a>';
        break;

    } while (false);
}
?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">
    <title>MakeDieSS</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/my.css" rel="stylesheet">
    <link href="./css/my.css" rel="stylesheet">
</head>

<body>

<?PHP print_navbar() ?>

<div class="container">
    <!-- 内容 -->
    <div class="row">
        <div class="col-md-7">
            <!-- 左侧内容 -->
            <h2 id="labels" class="page-header">注册一个帐号</h2>
            <?php
            if ($err_msg != '') {
                echo "<div class='alert alert-danger' role='alert'>{$err_msg}</div>";
            }
            ?>
            <form class="form-horizontal" role="form" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">邮箱帐号:</label>

                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">登录密码:</label>

                    <div class="col-sm-10">
                        <input type="pass" name="pass" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">邀请码:</label>

                    <div class="col-sm-10">
                        <input type="text" name="vcode2" class="form-control" id="inputPassword3" placeholder="Code">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">验证码:</label>
                    <?php
                    $builder = new CaptchaBuilder;
                    $_SESSION['phrase'] = $builder->getPhrase();
                    $builder->build();
                    ?>
                    <div class="col-sm-6">
                        <input type="text" name="vcode" class="form-control" id="inputPassword3" placeholder="Code">
                    </div>
                    <div class="col-sm-4">
                        <img src="<?php echo $builder->inline(); ?>"/>
                    </div>
                    <label for="inputPassword3" class="col-sm-2 control-label">注意事项:</label>

                    <div class="col-sm-8">
                        0x00请区别于其他密码，目前本系统尚以明文存储密码。<br>
                        0x01请牢记你的密码，目前本系统不提供任何找回更改服务。<br>
                        0x02恶意囤积小号，2个月未使用者，小号嫌疑者会被删除。<br>
                        0x03请低调传播，我不希望域名被特殊关照<br>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">注册</button>

                    </div>
                </div>
            </form>


        </div>


        <div class="col-md-4">
            <!-- 右侧内容 -->
            <div style="padding-top: 100px; font-size: 18px;"><a href="login.php">登入</a> 入口在这里喂</div>
        </div>
    </div>


</div>
<!-- /.container -->
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script src="./js/bootstrap.min.js"></script>

</body>
</html>