<?php
include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");

$j 			= (isset($_POST['j']))?$_POST['j']:'';
$seccion 	= (isset($_POST['seccion']))?$_POST['seccion']:'';
$cad		= (isset($_POST['idcad']))?$_POST['idcad']:'';

	
if(isset($_POST['idcad'])){
	$desabilitar = "";
	$seleccionar = "";
	if($cad <= 0)
		$desabilitar = "disabled='disabled'";
	if($cad == 0)
		$seleccionar = "selected='selected'";
	//$funcion1 = "window.setTimeout(\"buscarSelectCorresponsal()\",50);";
	$funcion2 = (isset($_POST['funcion2']))?"window.setTimeout(\"".$_POST['funcion2']."\",50);":"";
	$funcion3 = (isset($_POST['funcion3']))?"window.setTimeout(\"".$_POST['funcion3']."\",150);":"";
	
	$res = null;
	$res = $RBD->query("SELECT `idSubCadena`,`nombreSubCadena` FROM `redefectiva`.`dat_subcadena` WHERE `idCadena` = ".$cad." ORDER BY `nombreSubCadena`;");
	$d = "";
	if($res != null){
		$d = "<select $desabilitar id='ddlSubCad' class='textfield' onchange='$funcion1 $funcion2 $funcion3'><option value='-3'>Seleccione una subcadena</option><option value='-1' selected='selected'>General</option>";
		$d.="<option value='0' $seleccionar>Unipuntos</option>";
		while($r = mysqli_fetch_array($res)){		
			if($r[0] != 0 && $r[1] != "Unipuntos")
                 $d.="<option value='$r[0]'	>$r[1]</option>";
		}
		
		
		
		$d.="</select>";
		echo utf8_encode($d);
	}else{
		echo "<select $desabilitar id='ddlSubCad'><option value='-3'>Seleccione una subcadena</option></select>";
	}
}else{ echo "<select $desabilitar id='ddlSubCad'><option value='-3'>Seleccione una subcadena</option></select>";}
?>