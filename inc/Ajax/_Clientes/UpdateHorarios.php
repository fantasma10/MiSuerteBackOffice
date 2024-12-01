<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $WBD;

$id             = (isset($_POST['idCorresponsal']))?$_POST['idCorresponsal']: 0;

$DE1		    = (isset($_POST['DE1']))?$_POST['DE1']: '';
$DE2		    = (isset($_POST['DE2']))?$_POST['DE2']: '';
$DE3		    = (isset($_POST['DE3']))?$_POST['DE3']: '';
$DE4		    = (isset($_POST['DE4']))?$_POST['DE4']: '';
$DE5		    = (isset($_POST['DE5']))?$_POST['DE5']: '';
$DE6		    = (isset($_POST['DE6']))?$_POST['DE6']: '';
$DE7		    = (isset($_POST['DE7']))?$_POST['DE7']: '';

$A1			    = (isset($_POST['A1']))?$_POST['A1']: '';
$A2			    = (isset($_POST['A2']))?$_POST['A2']: '';
$A3			    = (isset($_POST['A3']))?$_POST['A3']: '';
$A4			    = (isset($_POST['A4']))?$_POST['A4']: '';
$A5			    = (isset($_POST['A5']))?$_POST['A5']: '';
$A6			    = (isset($_POST['A6']))?$_POST['A6']: '';
$A7			    = (isset($_POST['A7']))?$_POST['A7']: '';


$RES		= '';
$SET		= '';
if($id > 0)	{

	$SET = ($DE1 == "")?"`inicioDia1` = ".NULL:"`inicioDia1` = ".$DE1;
	$SET.= ($A1 == "")?", `cierreDia1` = ".NULL:", `cierreDia1` = ".$A1;
	$SET.= ($DE2 == "")?", `inicioDia2` = ".NULL:", `inicioDia2` = ".$DE2;
	$SET.= ($A2 == "")?", `cierreDia2` = ".NULL:", `cierreDia2` = ".$A2;
	$SET.= ($DE3 == "")?", `inicioDia3` = ".NULL:", `inicioDia3` = ".$DE3;
	$SET.= ($A3 == "")?", `cierreDia3` = ".NULL:", `cierreDia3` = ".$A3;
	$SET.= ($DE4 == "")?", `inicioDia4` = ".NULL:", `inicioDia4` = ".$DE4;
	$SET.= ($A4 == "")?", `cierreDia4` = ".NULL:", `cierreDia4` = ".$A4;
	$SET.= ($DE5 == "")?", `inicioDia5` = ".NULL:", `inicioDia5` = ".$DE5;
	$SET.= ($A5 == "")?", `cierreDia5` = ".NULL:", `cierreDia5` = ".$A5;
	$SET.= ($DE6 == "")?", `inicioDia6` = ".NULL:", `inicioDia6` = ".$DE6;
	$SET.= ($A6 == "")?", `cierreDia6` = ".NULL:", `cierreDia6` = ".$A6;
	$SET.= ($DE7 == "")?", `inicioDia7` = ".NULL:", `inicioDia7` = ".$DE7;
	$SET.= ($A7 == "")?", `cierreDia7` = ".NULL:", `cierreDia7` = ".$A7;	
	

	$sql = "CALL `redefectiva`.`SP_INSERT_HORARIO`(".$id.", $DE1, $A1, $DE2, $A2,$DE3, $A3, $DE4, $A4, $DE5, $A5, $DE6, $A6, $DE7, $A7)";
	$WBD->query($sql);

	if(!$WBD->error()){
		$RES = "0|Se ha actualizado correctamente el Horario";
	}
	else{
		$RES = "11|No se ha actualizado correctamente el Horario".$WBD->error();
	}

echo $RES;
exit();
}
			
			
?>