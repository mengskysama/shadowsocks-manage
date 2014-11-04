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
//
//

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
</head>

<body>
<?PHP print_navbar() ?>
<div class="container">
    <!-- 内容 -->
    <div class="row">
        <div class="col-md-8">
            <!-- 左侧内容 -->
            <h2 id="labels" class="page-header">
                MakeDieSS
            </h2>

            <div class="row">
                <div class="col-md-12">
                    <h3 id="labels" class="page-header">关于MakeDieSS</h3>

                    <div class="row">
                        <div class="col-md-12">
                            基于 Shad0ws0cks(SS)<a href="https://github.com/clowwindy">@clowwindy</a> <a
                                href="https://github.com/mengskysama/shadowsocks/tree/manyuser">修改的分支版本</a>
                            提供的服务，目前正在重构阶段，遇到暂抽风属于正常现象。提供免费的翻嫱服务，为了提供更高质量的服务或者恶意用户，目前每用户每天有2048M流量，目前2台云主机3000G/月流量，在能力范围内提供翻嫱服务，暂不提供收费服务。
                        </div>
                    </div>
                    <h3 id="labels" class="page-header">MakeDieSS限制</h3>

                    <div class="row">
                        <div class="col-md-12">
                            0x00. 限制25端口的转发请求<br>
                            0x01. 限制135端口的转发请求<br>
                            0x02. 限制1433端口的转发请求<br>
                            0x03. 限制3389端口请转发求频率<br>
                            0x04. 限制100并发每个IP<br>
                            0x04. 限制200并发每个服务<br>
                        </div>
                    </div>
                    <h3 id="labels" class="page-header">使用方法</h3>

                    <div class="row">
                        <div class="col-md-12">
                            http://www.jianshu.com/p/08ba65d1f91a<br>
                        </div>
                    </div>
                    <h3 id="labels" class="page-header">历史版本</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Future
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    SS WebPannel Demo 功能代码整理<br>
                                    SS 数据接口重构<br>
                                    SS Web数据统计接口<br>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Ver0.1 2014.10.22
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    减轻服务器负载，承载后端更换为libev<br>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Ver0.1 2014.10.02
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    目前为止服务器正常。其中几次机器重启，开机脚本错误导致的文件数超过限制连不上<br>
                                    修改每天赠送233M增加到1024M流量<br>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Ver0.1 2014.09.18
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    内核/系统参数调整，解决13，16，17出现的句柄用尽导致连不上服务器的问题<br>
                                    SS Pool中Demo不安全跨线程的接口改为事件驱动<br>
                                    mdss重启服务<br>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Ver0.1 2014.09.12
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    SS WebPannel 0.1<br>
                                    BugFix 数据库接口逻辑错误导致某些情况流量多扣<br>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Ver0.1 2014.09.07
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    SS WebPannel Demo完成<br>
                                    SS WebPannel 用户注册/服务/恶意用户IP黑名单相关<br>
                                    MakeDieSS 开始提供服务测试<br>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Ver0.1 2014.09.05
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    SS 非异步数据库线程<br>
                                    SS 非异步数据库用户流量<br>
                                    SS 非异步WebApi完成<br>
                                    SS 服务Pool完成<br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 id="labels" class="page-header">项目目的</h3>

                    <div class="row">
                        <div class="col-md-12">
                            0x00. 观察怪物运作方式，特定IP大量连接数据是否会被X。
                        </div>
                        <div class="col-md-12">
                            0x01. ss分支版本开发。
                        </div>
                        <div class="col-md-12">
                            0x02. 为了学术。
                        </div>
                    </div>
                </div>
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


