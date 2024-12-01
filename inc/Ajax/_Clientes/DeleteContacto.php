<?php
	include("../../config.inc.php");
	include("../../session.inc.php");

	global $RBD;
	global $WBD;

	$tipoCliente	= (isset($_POST['tipoCliente']))?$_POST['tipoCliente']: -1;
	$id				= (isset($_POST['id']))?$_POST['id']: -1;
	$idContacto		= (isset($_POST['idContacto']))?$_POST['idContacto']: -1;
	$idEmpleado		= $_SESSION['idU'];

	if($tipoCliente > 0){

		/* si es corresponsal se debe validar que tenga por lo menos un corresponsal */
		$eliminar = true;
		if($tipoCliente == 3){
			$sql = $RBD->query("CALL `redefectiva`.`SP_COUNT_CONTACTOS`($id);");
			$res = mysqli_fetch_assoc($sql);

			if(!$RBD->error()){
				$total = $res["cuenta"];

				if($total > 1){
					$eliminar = true;
				}
				else{
					$eliminar = false;
					$RES = "1|El Corresponsal Debe tener por lo menos un Contacto Activo";
				}
			}
			else{
				$RES = "1|Ha ocurrido un error, Inténtelo de Nuevo";
			}
		}

		if($eliminar == true){
			$query = "CALL `redefectiva`.`SP_DELETE_CONTACTOS`($id, $idContacto, $idEmpleado, $tipoCliente);";

			$sql = $WBD->query($query);

			if(!$WBD->error()){
				$RES = "0|Se ha Eliminado correctamente el contacto";
			}
			else{
				$RES = "2|Error al eliminar contacto".$WBD->error();
			}
		}
	}
	else{
		$RES = "4|Ha ocurrido un error, Inténtelo de Nuevo";
	}

	echo $RES;

/*$FROM 	= "";
$WHERE 	= "";
$SET 	= "";
switch($tipoCliente)
{
	case 1:
		$FROM = "`redefectiva`.`inf_cadenacontacto`";
		$WHERE = "`idCadena`= $id AND `idContacto`= $idContacto";
		$SET 	= "`idEstatusCadCont`=3,";
	break;

	case 2:
		$FROM = "`redefectiva`.`inf_subcadenacontacto`";
		$WHERE = "`idSubCadena`= $id AND `idContacto`= $idContacto";
		$SET 	= "`idEstatusSubCadCont`=3,";
	break;

	case 3:
		$FROM = "`redefectiva`.`inf_corresponsalcontacto`";
		$WHERE = "`idCorresponsal`= $id AND `idContacto`= $idContacto";
		$SET 	= "`idEstatusCorCont`=3,";
	break;
}

$RES		= '';

$sql 		= "Select `idContacto` from $FROM where($WHERE);";
$RESsql 	= $RBD->query($sql);	

if(mysqli_num_rows($RESsql)){				
	
	$sql2 	= "UPDATE $FROM SET $SET `idEmpleado` = ".$_SESSION['idU']." WHERE $WHERE";
	
	$WBD->query($sql2);
	
	if($WBD->error() == ''){
		$RES = "0|Se ha Eliminado correctamente el contacto";
	}else{
		//$RES = "2|".$RBD->error();
		$RES = "2|Error al eliminar contacto".$sql2;
	}
			
}else{$RES = '3|No se pudo eliminar, El id no existe';}	

		
		
echo $RES;*/

?>