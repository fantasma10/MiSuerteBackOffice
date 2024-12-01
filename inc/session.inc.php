<?php
#################################
#Session
#
if ($_SERVER["SERVER_PORT"] != 443){ 
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']); 
    exit(); 
}

session_start();

//print_r($_SESSION); exit;

if (isset($_SESSION['MiSuerte']))
{

	if($IP == $_SESSION['sip']){
		extract($_SESSION);	
	}else{
		header('Location: '.$ROOT.'/logout.php');
		exit;
	}
}
else
{
	header('Location: '.$ROOT.'/index.php?bad_login');
	exit;
}

	$g_hace1Mes 	= date('Y-m-d', strtotime('-1 month'));
	$g_hace1Sem 	= date('Y-m-d', strtotime('-7 day'));
	$g_ayer	 		= date('Y-m-d', strtotime('-1 day'));
	$g_hoy			= strftime( "%Y-%m-%d", time());

?>