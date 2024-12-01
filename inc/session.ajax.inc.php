<?php
#################################
#Session
#
if ($_SERVER["SERVER_PORT"] != 443){ 
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']); 
    exit(); 
}

session_start();

if (isset($_SESSION['MiSuerte']))
{
	if($IP == $_SESSION['sip']){
		extract($_SESSION);	
	}else{
		echo "10000000|XYZ.,;";
		exit;
	}
}else{
	echo "10000000|XYZ.,;";
	exit;
}

?>