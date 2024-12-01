<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $RBD;
global $WBD;

$id             = (isset($_POST['id']))?$_POST['id']: 0;
$tipoCliente	= (isset($_POST['idTipoCliente']))?$_POST['idTipoCliente']: 0;
$idContacto     = (isset($_POST['idContacto']))?$_POST['idContacto']: 0;

$nomC			= (isset($_POST['NomC']))?trim($_POST['NomC']): '';
$apPC			= (isset($_POST['apPC']))?trim($_POST['apPC']): '';
$apMC			= (isset($_POST['apMC']))?trim($_POST['apMC']): '';
$telC			= (isset($_POST['telC']))?trim($_POST['telC']): '';
$mailC			= (isset($_POST['mailC']))?trim($_POST['mailC']): '';
$tipoC			= (isset($_POST['tipoC']))?$_POST['tipoC']: -2;
$extension		= (!empty($_POST['extension']))? $_POST["extension"]: "";

$nomC = utf8_decode($nomC);
$apPC = utf8_decode($apPC);
$apMC = utf8_decode($apMC);

$telC = str_replace("-", "", $telC);

$FROM ="";		$WHERE = "";		$AND = "";	$INSERT = "";
if($tipoCliente == 1){
	$FROM = "`redefectiva`.`inf_cadenacontacto` AS inf";
	$WHERE = "inf.`idCadena` = ".$id;
	$AND = " AND inf.`idEstatusCadCont` = 0";
	$INSERT = "INSERT INTO `redefectiva`.`inf_cadenacontacto`(`idCadena`, `idContacto`, `fecAltaCadCont`, `fecVigenciaCadCont`, `idEstatusCadCont`, `fecMovCadCont`, `idEmpleado`) ";
}

if($tipoCliente == 2){
	$FROM = "`redefectiva`.`inf_subcadenacontacto` AS inf";
	$WHERE = "inf.`idSubCadena` = ".$id;
	$AND = " AND inf.`idEstatusSubCadCont` = 0";
	$INSERT = "INSERT INTO `redefectiva`.`inf_subcadenacontacto`(`idSubCadena`, `idContacto`, `fecAltaSubCadCont`, `fecVigenciaSubCadCont`, `idEstatusSubCadCont`, `fecMovSubCadCont`, `idEmpleado`) ";
}
	
if($tipoCliente == 3){
	$FROM = "`redefectiva`.`inf_corresponsalcontacto` AS inf";
	$WHERE = "inf.`idCorresponsal` = ".$id;
	$AND = " AND inf.`idEstatusCorCont` = 0";
	$INSERT = "INSERT INTO `redefectiva`.`inf_corresponsalcontacto`(`idCorresponsal`, `idContacto`, `fecAltaCorCont`, `fecVigenciaCorCont`, `idEstatusCorCont`, `fecMovCorCont`, `idEmpleado`) ";
}


$RES		= '';

if($idContacto > -1){

	if($tipoC == 6){
		$sql 	= "SELECT inf.`idContacto`,dat.`nombreContacto` ,dat.`apPaternoContacto`,
				dat.`apMaternoContacto`, cat.`descTipoContacto`, dat.`correoContacto`, dat.`telefono1`
				FROM $FROM
				LEFT JOIN `redefectiva`.`dat_contacto` AS dat
				ON inf.`idContacto` = dat.`idContacto`
				LEFT JOIN `cat_tipocontacto` AS cat
				ON dat.`idcTipoContacto` = cat.`idTipoContacto`
				WHERE $WHERE
				AND dat.`idcTipoContacto` = 6
				AND inf.`idContacto` != $idContacto
				AND dat.`idEstatusContacto` = 0
				$AND";
		
		$res = $RBD->query($sql);

		if($RBD->error() == '')
		{
			if($res != '' && mysqli_num_rows($res) >= 1){
				echo $RES = "3|Ya cuenta con 1 Responsable ";
				exit();
			}
		}
		else{
			echo $RES = "6|Error al actualizar contacto";
			exit();
		}
	}

	$sql4 	= "SELECT dat.`idContacto`
				FROM `redefectiva`.`dat_contacto` AS dat
				LEFT JOIN $FROM
				ON dat.`idContacto` = inf.`idContacto`
				WHERE dat.`nombreContacto` = '$nomC'
				AND dat.`apPaternoContacto` = '$apPC'
				AND dat.`apMaternoContacto` = '$apMC'
				AND dat.`idEstatusContacto` = 0
				$AND
				AND dat.`idContacto` != $idContacto";
				
	$res = $RBD->query($sql4);

	if($RBD->error() == '') {	
		if ( mysqli_num_rows($res) == 0 ) {
			$idUsuario = $_SESSION["idU"];
			$sql 	= "CALL `redefectiva`.`SP_UPDATE_CONTACTO`($idUsuario, '$telC', '$extension', '$mailC', '$tipoC', '$nomC', '$apPC', '$apMC', '$idContacto');";
			
			$WBD->query($sql);
			
			if($WBD->error() == ''){
				$RES = "0|Se a actualizado correctamente el contacto";
			}else{
				//$RES = "2|".$RBD->error();
				$RES = "10|Error al actualizar contacto".$WBD->error();
			}			
		} else {
			$RES = "7|Lo sentimos este contacto ya existe para este cliente";
		}				
	}
}else{
	$sql4 	= "SELECT dat.`idContacto`
				FROM `redefectiva`.`dat_contacto` AS dat
				LEFT JOIN $FROM
				ON dat.`idContacto` = inf.`idContacto`
				WHERE dat.`nombreContacto` = '$nomC'
				AND dat.`apPaternoContacto` = '$apPC'
				AND dat.`apMaternoContacto` = '$apMC'
				AND dat.`idEstatusContacto` = 0
				$AND";

	$res = $RBD->query($sql4);
	
	if($RBD->error() == '')
	{
		if(mysqli_num_rows($res) == 0){
			if($tipoC == 6){//este es para revisar los contactos de tipo Responsable
				$sql 	= "SELECT inf.`idContacto`,dat.`nombreContacto` ,dat.`apPaternoContacto`,
							dat.`apMaternoContacto`, cat.`descTipoContacto`, dat.`correoContacto`, dat.`telefono1`
							FROM $FROM
							LEFT JOIN `redefectiva`.`dat_contacto` AS dat
							ON inf.`idContacto` = dat.`idContacto`
							LEFT JOIN `cat_tipocontacto` AS cat
							ON dat.`idcTipoContacto` = cat.`idTipoContacto`
							WHERE $WHERE
							AND dat.`idcTipoContacto` = 6
							AND dat.`idEstatusContacto` = 0
							$AND";

				$res = $RBD->query($sql);

				if($RBD->error() == '')
				{
					if($res != '' && mysqli_num_rows($res) < 1){

						$fecVigen = date('Y-m-d', strtotime('+10 Year'));
						$idUsuario = $_SESSION["idU"];
						$sql2 	= "CALL `redefectiva`.`SP_INSERT_NUEVO_CONTACTO`('$tipoC', '$nomC', '$apPC', '$apMC', '$telC', '$extension', '$mailC', '$fecVigen', $idUsuario)";

						$res = $WBD->query($sql2);
						if($WBD->error() == '')
						{
							//$idUltimo = mysqli_insert_id($WBD->LINK);
							$res2 = mysqli_fetch_assoc($res);
							$idUltimo = $res2['idContacto'];
							
							/*$sql3 	= "$INSERT
											VALUES (".$id.",".$idUltimo.",NOW(),'".$fecVigen."',0,NOW(),".$_SESSION['idU'].")";*/
			
							$idUsuario = $_SESSION['idU'];
							$sql3 = "CALL `redefectiva`.`SP_CREATE_INFCONTACTOS`($id, $idUltimo, '$fecVigen', $idUsuario, $tipoCliente)";

							$res = $WBD->query($sql3);
							
							if($WBD->error() == '')
							{
								$RES = "0|Contacto Asignado";	
							}else{
								$RES = "01|Error al asignar el Contacto";	
							}
						}else{
							$RES = "2|Error al crear el Contacto";	
						}	
						
					}else{
						$RES = "3|Ya cuenta con 1 Responsable ";	
					}
				}
				else
				{
					//$RES = "2|".$RBD->error();
					$RES = "4|Error al actualizar contacto";
				}
			}
			else{
			
				$fecVigen = date('Y-m-d', strtotime('+10 Year'));

				$idUsuario = $_SESSION["idU"];
				$sql2 	= "CALL `redefectiva`.`SP_INSERT_NUEVO_CONTACTO`('$tipoC', '$nomC', '$apPC', '$apMC', '$telC', '$extension', '$mailC', '$fecVigen', '$idUsuario')";

				$res = $WBD->query($sql2);
				if($WBD->error() == '')
				{
					//$idUltimo = mysqli_insert_id($WBD->LINK);
					$res2 = mysqli_fetch_assoc($res);
					$idUltimo = $res2['idContacto'];
					
					/*$sql3 	= "$INSERT
					VALUES (".$id.",".$idUltimo.",NOW(),'".$fecVigen."',0,NOW(),".$_SESSION['idU'].")";*/
					$idUsuario = $_SESSION['idU'];
					$sql3 = $sql3 = "CALL `redefectiva`.`SP_CREATE_INFCONTACTOS`($id, $idUltimo, '$fecVigen', $idUsuario, $tipoCliente)";
		
					$res = $WBD->query($sql3);
					
					if($WBD->error() == '')
					{
						$RES = "0|Contacto Asignado";	
					}else{
						//ECHO $WBD->error();
						$RES = "1|Error al asignar el Contacto Nuevo ";	
					}
				}else{
					$RES = "2|Error al crear el Contacto Nuevo ";	
				}	
				
			}
		
		}else{
			$RES = "7|Lo sentimos este contacto ya existe para este cliente";
		}
	}
}
			
echo $RES;
			
?>