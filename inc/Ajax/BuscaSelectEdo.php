<?php
include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");

$j 			= (isset($_POST['j']))?$_POST['j']:'';
$seccion 	= (isset($_POST['seccion']))?$_POST['seccion']:'';
$pais		= (isset($_POST['idpais']))?$_POST['idpais']:'';

$funcion1		= (isset($_POST['funcion1']))?$_POST['funcion1']:'';

	
if ( isset($_POST['idpais']) ) {
	$res = NULL;
	$sql2 = "CALL `redefectiva`.`SP_LOAD_ESTADOS`('$pais');";
	$res = $RBD->SP($sql2);
	$d = "";
	if ( $res != NULL ) {
		$d = "<select id='ddlEstado' name='ddlEstado' class='form-control m-bot15' onchange='buscaSelectCiudad($j, \"$funcion1\"); $funcion1'><option value='-2'>Seleccione un Edo</option>";
		while ( $r = mysqli_fetch_array($res) ) {
			$r[1] = htmlentities($r[1]);
			$d.="<option value='$r[0]'	>$r[1]</option>";   
		}
		$d .= "</select>";
		echo $d;
	} else {
		echo "<select id='ddlEstado' name='ddlEstado' ><option value='-2'>Seleccione un Edo (Error)</option></select>";
	}
}
?>