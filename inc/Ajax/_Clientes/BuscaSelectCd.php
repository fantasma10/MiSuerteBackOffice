<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$j 			= (isset($_POST['j']))?$_POST['j']:'';
$seccion 	= (isset($_POST['seccion']))?$_POST['seccion']:'';
$pais		= (isset($_POST['idpais']))?$_POST['idpais']:'';
$edo		= (isset($_POST['idedo']))?$_POST['idedo']:'';
	
if(isset($_POST['idpais'])){
	$res = NULL;
	$sql2 = "CALL `redefectiva`.`SP_LOAD_CIUDADES`($pais, $edo);";
	$res = $RBD->SP($sql2);
	$d = "";
	if($res != NULL){
		$d = "<select class=\"form-control m-bot15\" id='ddlMunicipio' name='ddlMunicipio' onchange='buscaSelectColonia(false)'><option value='-2'>Seleccione un Cd</option>";
		while($r = mysqli_fetch_array($res)){				
			$d.="<option value='$r[0]'>$r[1]</option>";  
		}
		$d.="</select>";
		echo utf8_encode($d);
	}else{
		echo "<select class=\"form-control m-bot15\" id='ddlMunicipio' name='ddlMunicipio' ><option value='-2'>Seleccione un Edo (Error)</option></select>";
	}
}
?>