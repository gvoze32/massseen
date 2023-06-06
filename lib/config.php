<?php
include('func.php');
include('igfunc.php');
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

// EDIT DARI SINI
$countTarget    = '200'; //Ambil jumlah akun per target
$sleep_1        = rand(90,120); //Jeda per view story
$sleep_2        = rand(90,120); //Jeda per view story 1 akun user
// SAMPAI SINI 

$answerFile		= 'storyAnswer.txt'; 
$saveFile 		= 'logData.txt'; 
$cookieFile 	= 'cookieData.txt'; 
$targetFile 	= 'targetData.txt'; // File target
$date 			= date("Y-m-d");
$time 			= date("H:i:s");
?>
