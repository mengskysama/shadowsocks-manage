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
checklogin();
$msg = 0;
$msgtype = 0;
global $BASEURL;
?>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="./favicon.ico">
        <title>
            MakeDieSS
        </title>
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/my.css" rel="stylesheet">
        <link href="./css/my.css" rel="stylesheet">
        <script src="http://libs.useso.com/js/jquery/1.9.1/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("Button#resetpasswd").click(
                    function () {
                        $.get("api.php", { cmd: "resetpasswd"}, function (data) {
                            $("#passwd").val(data);
                            alert("新的服务密码为:" + data);
                        });
                    })
                $("Button#restart").click(
                    function () {
                        $.get("api.php", { cmd: "restart"}, function (data) {
                            alert(data);
                        });
                    })
                $("Button#gift500mb").click(
                    function () {
                        $.get("api.php", { cmd: "gift500mb"}, function (data) {
                            alert(data);
                        });
                    })

            });
        </script>
    </head>
    <body>


    <?PHP
    print_navbar();
    ?>

    <div class="container">
        <!-- 内容 -->
        <div class="row">
            <div class="col-md-8">
                <!-- 左侧内容 -->
                <h2 id="labels" class="page-header">
                    SS帐号基本信息
                </h2>

                <div class="row">
                    <?php echo_servers_status(); ?>
                </div>
                <div class="row">
                    <?php echo_get_500MB() ?>
                </div>
                <div class="row">
                    <?php
                    $sql = "SELECT u, d, transfer_enable, type, port, passwd, email FROM `user` WHERE `id` = '{$account_id}'";
                    $result = mysql_query($sql);
                    if ($row = mysql_fetch_array($result)) {
                    echo_transfer_info($row['type'], $row['u'], $row['d'], $row['transfer_enable']);
                    ?>
                        </div>
                        <div class="row">
                            <?php
                            echo_server_info($row['port'], $row['passwd']);
                            ?>
                        </div>
                        <div class="row">
                        <?php
                        echo_servers_info($row['port'], $row['passwd']);
                        }
                        ?>
                </div>
            </div>
            <div class="col-md-4">
                <!-- 右侧边栏 -->
                <div class="container-fluid">
                    <div class="row" style="padding-top: 50px;">
                    </div>
                    <div class="row">

                    </div>
                </div>
            </div>
            <!-- Standard button -->
        </div>
        <!-- /.container -->
    </body>

    </html>

<?PHP
function echo_servers_info($port, $passwd)
{
    global $account_id;
    ?>
    <div class="col-md-10">
        <h3 id="labels" class="page-header">
            服务器信息
        </h3>

        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            服务器地址
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="input-group">
                            <span class="input-group-addon">节点01(东京x2)</span>
                            <input type="text" value="mdss01.mengsky.net" readOnly="true" class="form-control">
												<span class="input-group-btn">
                                                <button type="button" id="qrcode"
                                                        onclick="window.open('qrcode.php?server=mdss01.mengsky.net&port=<?php echo $port; ?>&passwd=<?php echo $passwd; ?>')"
                                                        class="btn btn-default">
                                                    二维码
                                                </button>
                                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?PHP
}

?>


<?php
function echo_transfer_info($type, $u, $d, $transfer_enable)
{
    $transfer_leave = $transfer_enable - $u - $d;
    $transfer_leave = $transfer_leave < 0 ? 0 : $transfer_leave;
    $transfer_enable_ = $transfer_enable < $u + $d ? $u + $d : $transfer_enable;
    $per_u = $u / $transfer_enable_ * 100.0;
    $per_u = $per_u > 100.0 ? 100.0 : $per_u;
    $per_d = $d / $transfer_enable_ * 100.0;
    $per_d = $per_d > 100.0 ? 100.0 : $per_d;
    ?>
    <div class="col-md-10">
        <h3 id="labels" class="page-header">
            流量统计
        </h3>

        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php
                            switch ($type) {
                                case 1:
                                    echo '免费用户(每天可用2048MB流量)';
                                    break;
                                case 3:
                                    echo '作死用户(每天可用8888MB流量)';
                                    break;
                                case 7:
                                    echo '做大死用户(每天可用88888MB流量)';
                                    break;
                            }
                            ?>

                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar"
                                 aria-valuenow="<?php
                                 echo $per_d;
                                 ?>
" aria-valuemin="0" aria-valuemax="100"
                                 style="width: <?php
                                 echo $per_d;
                                 ?>
                                     %">
                            </div>
                            <div
                                class="progress-bar progress-bar-success progress-bar-striped active"
                                role="progressbar" aria-valuenow="<?php
                            echo $per_u;
                            ?>
" aria-valuemin="0" aria-valuemax="100"
                                style="width: <?php
                                echo $per_u;
                                ?>
                                    %">
                            </div>
                        </div>
                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    套餐流量
                                                </span>
                            <input type="text" value="<?php
                            echo format_transfer($transfer_enable);
                            ?>
" disabled="disabled" class="form-control">
                        </div>
                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    下行流量
                                                </span>
                            <input type="text" value="<?php
                            echo format_transfer($d);
                            ?>
" disabled="disabled" class="form-control">
                        </div>
                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    上行流量
                                                </span>
                            <input type="text" value="<?php
                            echo format_transfer($u);
                            ?>
" disabled="disabled" class="form-control">
                        </div>
                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    剩余流量
                                                </span>
                            <input type="text" value="<?php
                            echo format_transfer($transfer_leave);
                            ?>
" disabled="disabled" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}

function echo_server_info($port, $passwd)
{
    ?>
    <div class="col-md-10">
        <h3 id="labels" class="page-header">
            服务信息
        </h3>

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            连接
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="input-group">
                                            <span class="input-group-addon">
                                                方式
                                            </span>
                            <input type="text" value="AES-256-CFB" disabled="disabled" class="form-control">
                        </div>
                        <div class="input-group">
                                            <span class="input-group-addon">
                                                端口
                                            </span>
                            <input type="text" value="<?php
                            echo $port;
                            ?>
" disabled="disabled" class="form-control">
                        </div>
                        <div class="input-group">
                                            <span class="input-group-addon">
                                                密码
                                            </span>
                            <input type="text" id="passwd" value="<?php
                            echo $passwd;
                            ?>
" disabled="disabled" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="button" id="resetpasswd"
                                                        class="btn btn-default action-reset-password">
                                                    重置密码
                                                </button>
                                            </span>
                        </div>
                        <div class="input-group">
                                            <span class="input-group-addon">
                                                状态
                                            </span>
                            <input type="text" value="" disabled="disabled" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="button" id="restart"
                                                        class="btn btn-default action-reset-password">
                                                    重启服务
                                                </button>
                                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}

function echo_get_500MB()
{
    ?>
    <div class="col-md-10">
        <h3 id="labels" class="page-header">
            兑换临时流量
        </h3>
        <button type="button" id="gift500mb" class="btn btn-default">1024MB</button>
    </div>
<?PHP
}

?>

<?PHP
function echo_servers_status()
{
    ?>
    <div class="col-md-10">
        <h3 id="labels" class="page-header">
            各个节点服务器当前负载
        </h3>
        <?PHP
        $time_act = time() - 60 * 10;
        $sql = "SELECT count(id) as online_cnt FROM `user` WHERE `t` > {$time_act}";
        $result = mysql_query($sql);
        if ($row = mysql_fetch_array($result)) {
            $cnt = $row['online_cnt'];
            echo '<img src="http://mdss01.mengsky.net/01.png" width="497" height="155" /><br>';
            echo '当前活跃用户数:' . $cnt;
        }
        ?>
    </div>
<?PHP
}

?>