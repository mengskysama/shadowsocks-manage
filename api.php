<?php

error_reporting(0);

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
if (checklogin(False) == False) {
    echo '非法的请求!';
}
function http_requset($uri)
{
    $ctx = stream_context_create(array('http' => array('timeout' => 4)));
    try {
        $ret = file_get_contents($uri, null, $ctx);
        return $ret;
    } catch (Exception $e) {
        return False;
    }
}

function requset_all_server($arg, $type)
{
    global $arr_server;
    foreach ($arr_server as $server) {
        if ($server['type'] & $type != 0) {
            http_requset($server['uri'] . $arg . '&key=' . $server['key']);
        }
    }
}

function new_serve($port, $passwd, $type)
{
    requset_all_server("/cmd/new_server?port={$port}&passwd={$passwd}", $type);
}

function del_serve($port, $type)
{
    requset_all_server("/cmd/del_server?port={$port}", $type);
}

function restart()
{
    global $account_id;
    $sql = "SELECT u, d, transfer_enable, port, type, passwd FROM `user` WHERE `id` = '{$account_id}'";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result)) {
        del_serve($row['port'], $row['type']);
        if ($row['u'] + $row['d'] >= $row['transfer_enable']) {
            return '帐号无剩余流量';
        }
        //会自己启动
        //new_serve($row['port'], $row['passwd'], $row['type']);
        return '服务重启完成';
    }
}

function reset_passwd()
{
    global $account_id;
    $passwd = get_rand_passwd(8);
    $sql = "UPDATE `user` SET passwd = '{$passwd}' WHERE `id` = '{$account_id}'";
    mysql_query($sql);
    restart();
    return $passwd;
}

function gift500mb()
{
    global $account_id;
    $sql = "SELECT last_get_gitf_time FROM `user` WHERE `id` = '{$account_id}'";
    $result = mysql_query($sql);
	$time_now = time();
    if ($row = mysql_fetch_array($result)) {
        if ($time_now - $row['last_get_gitf_time'] > 3600*12) {
            //可以领取
			$transfer = 1024 * 1024 * 1024;
			$sql = "UPDATE `user` SET transfer_enable = transfer_enable + '{$transfer}', last_get_gitf_time = '{$time_now}' WHERE `id` = '{$account_id}'";
			mysql_query($sql);
			return '领取成功';
        }
        return '12小时内只能领取一次';
    }
}

if (isset($_GET['cmd'])) {
    if ($_GET['cmd'] == 'resetpasswd') {
        echo reset_passwd();
    } elseif ($_GET['cmd'] == 'restart') {
        echo restart();
    }elseif ($_GET['cmd'] == 'gift500mb') {
        echo gift500mb();
    }
}