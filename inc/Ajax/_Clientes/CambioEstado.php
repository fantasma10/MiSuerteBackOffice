<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$pais		= (isset($_POST['idpais']))?$_POST['idpais']:'';

	
if(isset($_POST['idpais'])){
	$res = NULL;
	$sql2 = "CALL `redefectiva`.`SP_LOAD_ESTADOS`('$pais');";
	$res = $RBD->SP($sql2);
	$d = "";
	if($res != NULL){
		$d = "<select class=\"form-control m-bot15\" id='ddlEstado' name='ddlEstado' onchange='buscaSelectCiudad()'><option value='-2'>Seleccione un Edo</option>";
		while($r = mysqli_fetch_array($res)){
			 $d.="<option value='$r[0]'	>$r[1]</option>";   
		}
		$d.="</select>";
		echo utf8_encode($d);
	}else{
		echo "<select class=\"form-control m-bot15\" id='ddlEstado' name='ddlEstado' ><option value='-2'>Seleccione un Edo (Error)</option></select>";
	}
}
?>