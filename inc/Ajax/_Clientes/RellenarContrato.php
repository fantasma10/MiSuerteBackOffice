<?php
include("../../config.inc.php");
include("../../session.inc.php");
if(!isset($_SESSION['Permisos'])){
	header("Location: ../../logout.php"); 
    exit(); 
}

$rfc	= (isset($_POST['rfc']))?$_POST['rfc']: 0;

$RES		= '';

$sql		= "CALL `prealta`.`SP_GET_RAZONSOCIAL`('$rfc');";
$RESsql 	= $RBD->SP($sql);	

if(mysqli_num_rows($RESsql) > 0){			
	if($RBD->error() == '')
	{
		$id = mysqli_fetch_array($RESsql);
		$RES = "0|".$id[0]."|".$id[1]."|".$id[2];
	}
	else
	{
		$RES = "2|".$RBD->error();
	}			
}else{$RES .= '0|||';}	

echo $RES;

?>