<?php
include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");

$j 			= (isset($_POST['j']))?$_POST['j']:'';
$seccion	= (isset($_POST['seccion']))?$_POST['seccion']:'';
$cad		= (isset($_POST['idcad']))?$_POST['idcad']:'';
if(isset($_POST['idcad'])){
	$desabilitar = "";
	$seleccionar = "";
	if($cad == 0)
	{
		$desabilitar = "disabled='disabled'";
		$seleccionar = "selected='selected'";
	}
	
	$funcion2 = (isset($_POST['funcion2']))?"window.setTimeout(\"".$_POST['funcion2']."\",100)":"";


	$res = null;
	//$res = $RBD->query("SELECT `idSubCadena`,`nombreSubCadena` FROM `redefectiva`.`dat_subcadena` WHERE `idCadena` = ".$cad." ORDER BY `nombreSubCadena`;")	;
	$res = $RBD->query("call SP_LOAD_SUBCADENAS($cad)");
	$d = "";
	if($res != null){
		$d = "<select id='ddlSubCad' class='textfield' onchange='buscarCorresponsalRefBanc(".$j.");$funcion2' $desabilitar><option value='-1' selected='selected'></option>";
		if($seccion != "Operadores")
			$d.="<option value='0' $seleccionar>Unipuntos</option>";
		
		while($r = mysqli_fetch_array($res)){
		
			if($r["idSubCadena"] != 0 && $r["nombreSubCadena"] != "Unipuntos")
				$d.="<option value='$r[idSubCadena]' onclick='$funcion2'>$r[nombreSubCadena]</option>";  
		}
		$d.="</select>";
		echo utf8_encode($d);
	}else{
		echo "<select id='ddlSubCad'><option value='-2' selected='selected'>Todos</option></select>";
	}
}else{ echo "<select id='ddlSubCad'><option value='-2' selected='selected'>Todos</option></select>";}
?>