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
namespace Endroid\Tests\QrCode;
include('QrCode/Endroid/QrCode/QrCode.php');
use Endroid\QrCode\QrCode;

require 'function.php';
dbconn(true);
checklogin();
$msg = 0;
$msgtype = 0;
global $BASEURL;

$url = "aes-256-cfb:{$_GET['passwd']}@{$_GET['server']}:{$_GET['port']}";
$url = "ss://" . base64_encode($url);
$qrCode = new QrCode();
$qrCode->setText($url);
$qrCode->setSize(350);
$qrCode->setPadding(10);
echo "<img src='{$qrCode->getDataUri()}'>";
?>