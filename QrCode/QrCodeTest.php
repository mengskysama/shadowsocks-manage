<?php
/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Endroid\Tests\QrCode;
include('Endroid/QrCode/QrCode.php');

use Endroid\QrCode\QrCode;

$qrCode = new QrCode();
$qrCode->setText("Life is too short to be generating QR codes");
$qrCode->setSize(150);
$qrCode->setPadding(10);
echo "<img src='{$qrCode->getDataUri()}'>";
?>