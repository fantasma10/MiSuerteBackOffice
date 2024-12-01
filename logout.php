<?php 
	session_start();
	session_destroy();
	//echo 'sale';exit;
	$directorio = $_SERVER['HTTP_HOST'];
    $PATHRAIZ = "https://".$directorio;
	header('Location: '.$PATHRAIZ.'/index.php');
	exit;
?>