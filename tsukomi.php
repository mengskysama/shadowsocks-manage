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
</head>

<body>
<?PHP print_navbar() ?>
<div class="container">
    <!-- 内容 -->
    <div class="row">
        <div class="col-md-8">
            <!-- 左侧内容 -->
            <h2 id="labels" class="page-header">
                能不能更懒
            </h2>
            <br><br>

            <div id="disqus_thread"></div>
            <script type="text/javascript">
                /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                var disqus_shortname = 'disqus-bootstrap'; // required: replace example with your forum shortname

                /* * * DON'T EDIT BELOW THIS LINE * * */
                (function () {
                    var dsq = document.createElement('script');
                    dsq.type = 'text/javascript';
                    dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by
                    Disqus.</a></noscript>
            <a href="http://disqus.com" class="dsq-brlink">comments powered by <span
                    class="logo-disqus">Disqus</span></a>
            <br><br>
        </div>
    </div>
    <!-- /.container -->
</body>

</html>