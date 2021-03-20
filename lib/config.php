<?php
include('func.php');
include('igfunc.php');
date_default_timezone_set('Asia/Hong_Kong');
error_reporting(0);
/*
Jika akun terkena feedback_required tenang, tinggal tunggu 24 jam ntar pulih lagi
@theaxe.id
*/

//UBAH BAGIAN INI
$countTarget    = '100'; //Ambil jumlah akun per target
//SAMPAI SINI AJA

$saveFile 		= 'logData.txt'; // File log
$cookieFile 	= 'cookieData.txt'; // File cookie
$targetFile 	= 'targetData.txt'; // File target
$date 			= date("Y-m-d");
$time 			= date("H:i:s");
?>
