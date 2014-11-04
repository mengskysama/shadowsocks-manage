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
require 'function.php';
dbconn(true);
global $BASEURL;
$err_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    do {
        //POST
        if (!isset($_POST['email']) || !isset($_POST['pass'])) {
            $err_msg = '你在搞什么?';
            break;
        }
        $email = mysql_real_escape_string(strtolower($_POST['email']));
        $pass = mysql_real_escape_string($_POST['pass']);
        //检查是密码正确性
        $sql = "SELECT id FROM `user` WHERE `email` = '{$email}' AND `pass` = '{$pass}'";
        $result = mysql_query($sql);
        if (mysql_num_rows($result) == 0) {
            $err_msg = '你输入的密码有误!';
            break;
        }
        if ($row = mysql_fetch_array($result)) {
            //IP
            log_ip($row['id']);
            //密码正确保存cookie
            makecookie($row['id'], isset($_POST['remember']));
            //做跳转
            header('Location: ' . get_protocol_prefix() . "{$BASEURL}/pannel.php");
        } else {
            $err_msg = '抱歉!发生了我们认为不可能发生的错误,请与客服联系!';
            break;
        }
    } while (false);
} else {
    if (checklogin(False) == True) {
        header('Location: ' . get_protocol_prefix() . "{$BASEURL}/pannel.php");
    }
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
            <h2 id="labels" class="page-header">登录管理面板</h2>
            <?php
            if ($err_msg != '') {
                echo "<div class='alert alert-danger' role='alert'>{$err_msg}</div>";
            }
            ?>
            <form class="form-horizontal" role="form" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">邮箱帐号:</label>

                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">登录密码:</label>

                    <div class="col-sm-10">
                        <input type="password" name="pass" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember">24小时内记住我
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">登入</button>

                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <!-- 右侧内容 -->
            <div style="padding-top: 100px; font-size: 18px;">注册请戳 <a href="reg.php">这里</a></div>
            <div style="padding-top: 20px; font-size: 18px;">找回请戳 <a href="forgot.php">这里</a></div>
        </div>
    </div>

</div>
<!-- /.container -->
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script src="./js/bootstrap.min.js"></script>

</body>
</html>
