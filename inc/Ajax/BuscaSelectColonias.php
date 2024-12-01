<?php
include("../config.inc.php");
include("../session.ajax.inc.php");

$j 			= (isset($_POST['j']))?$_POST['j']:'';
$seccion 	= (isset($_POST['seccion']))?$_POST['seccion']:'';
$pais		= (isset($_POST['idpais']))?$_POST['idpais']:'';
$edo		= (isset($_POST['idedo']))?$_POST['idedo']:'';
$cd			= (isset($_POST['idcd']))?$_POST['idcd']:'';

$funcion1		= (isset($_POST['funcion1']))?$_POST['funcion1']:'';

if(isset($_POST['idpais'])){
	$res = NULL;
	$sql2 = "CALL `redefectiva`.`SP_LOAD_COLONIAS`($pais, $edo, $cd);";
	$res = $RBD->SP($sql2);
	$d = "";
	if($res != NULL){
		$d = "<select id='ddlColonia' name='ddlColonia' onchange='$funcion1;BuscaCPColonia();' class='form-control m-bot15''><option value='-2'>Seleccione una Colonia</option>";
		while($r = mysqli_fetch_array($res)){
			 $r[1] = htmlentities($r[1]);
			 $d.="<option value='$r[0]'	>$r[1]</option>";   
		}
		$d.="</select>";
		echo $d;
	}else{
		echo "<select id='ddlColonia' name='ddlColonia' class='form-control m-bot15''><option value='-2'>Seleccione una Ciudad (Error1)</option></select>";
	}
}
?>