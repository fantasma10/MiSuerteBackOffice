<?php

$salt			= "=-5$0_";
//$randomWord		= "randomWord";
$randomWLength	= 12;
$chars			= "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
$strlenchars	= strlen($chars);
$limit			= $strlenchars-1;

$randomWord = '';
		for($i=0; $i<$randomWLength; $i++){
			$randomWord .= $chars[rand(0, $limit)];
		}
$codvalidacion =  md5(sha1($salt.$randomWord));
?>