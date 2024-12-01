<?php
$pemiso		= (isset($_POST['pemiso']))?$_POST['pemiso']: false; if($pemiso){
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idOpcion = 29;
$tipoDePagina = "Escritura";

/*if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}
*/

//global $RBD;
global $MRDB;

$id				= (isset($_POST['id']))?$_POST['id']: 0;
$val			= (isset($_POST['val']))?$_POST['val']: 2;

switch($val)
{
	case 0:
		$str = "Activado";	
	break;
	
	case 1:
		$str = "Desactivado";	
	break;
	
	case 2:
		$str = "Eliminado";	
	break;
}

$RES		= '';

$sql		= "CALL `data_acceso`.`SP_GET_USUARIO`($id);";
//$RESsql 	= $RBD->SP($sql);	
$RESsql 	= $MRDB->SP($sql);	

if(mysqli_num_rows($RESsql)){				
	
	$sql	= "CALL `data_acceso`.`SP_UPDATE_USUARIOESTATUS`($id, $val, {$_SESSION['idU']});";
	//$RBD->SP($sql);
	$MRDB->SP($sql);
	
	$RES = "0|Se ha ".$str." correctamente";
			
}else{$RES .= '3|No se pudo '.$str.' , El id no existe';}	

		
		
echo $RES;
}else{header("location: ../../../main.php");		}				
?>