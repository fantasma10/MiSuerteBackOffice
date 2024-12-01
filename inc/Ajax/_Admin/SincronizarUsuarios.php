<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

global $WBD;
$RES = '';

$obj = new adLDAP();
$a = new adLDAPUsers($obj);

$datos = $a->all();

for( $i = 0; $i < count($datos); $i++ ) {
	$otra = $a->info($datos[$i]);
	foreach( $otra as $t ) {
		if( isset($t["displayname"][0]) ) {
			if( isset($t["mail"][0]) ) {
				$result=$obj->user()->infoCollection($t["samaccountname"][0], array("*"));
				if( isset($result->memberof[0])&& $result->samaccountname != "Administrator"
				&& $t["mail"][0] != "radmin@redefectiva.com"
				&& $t["mail"][0] != "SBSFaxService@redefectiva.com" ) {

					$correo 	= $t["mail"][0];
					$sql = "CALL `data_acceso`.`SP_GET_USUARIOBYMAIL`('$correo');";
					$datUsu = explode(" ",$t["displayname"][0]);
					$nombre = "";

					if( sizeof($datUsu) > 2 ) {
						for( $j = 0; $j < (sizeof($datUsu)-1); $j++ ) {
							$nombre .= $datUsu[$j]." ";
						}
					} else {
						$nombre = $datUsu[0];
					}

					$apellido = $datUsu[sizeof($datUsu)-1];

					$RESsql = $WBD->SP($sql);

					if( mysqli_num_rows($RESsql) == 0 ) {

								$sql = "CALL `data_acceso`.`SP_INSERT_USUARIO`('$nombre', '$apellido', '', '$correo', {$_SESSION['idU']});";
								$WBD->SP($sql);

								if( $WBD->error() == '' ) {

									$sql = "CALL `data_acceso`.`SP_FIND_USUARIO`('$correo', '$nombre', '$apellido', {$_SESSION['idU']});";
									$Result = $WBD->SP($sql);

									if( mysqli_num_rows($Result) == 1 ) {
										$r = mysqli_fetch_array($Result);
										$id = $r[0];
										$var =  $result->memberOf;
										$resUpdate = UpdateGrupos($id,$var,$WBD, $result);
										if( $resUpdate == 0 ) {
											$RES = array('nCodigo'=>"0", 'sMensaje' => "Se ha Sincronizado correctamente con Windows");
										} else {
											$RES = array('nCodigo'=>"1".$resUpdate, 'sMensaje' => "Error en Sincronizacion de Grupos de Windows ".$id);
											echo "Entro al break 1";
											break;
										}
									}

									$sql = "CALL `data_acceso`.`SP_GET_PERFILES`($id);";
									$Result = $WBD->SP($sql);

									if ( mysqli_num_rows($Result) == 0 ) {
										if ( $_SESSION['MiSuerte'] ) {
											$idPortal = 1;
											$sql = "CALL `data_acceso`.`SP_INSERT_PERFILDEUSUARIO`($id, -1, $idPortal, {$_SESSION['idU']});";
											$Result = $WBD->SP($sql);

											if ( $WBD->error() != '' ) {
												$RES = array('nCodigo'=>"2", 'sMensaje' => $WBD->error());
											}
										}
									}

								} else {
									$RES = array('nCodigo'=>"3", 'sMensaje'=>$WBD->error());
									break;
								}

					} else {

						$sqlu = "CALL `data_acceso`.`SP_UPDATE_USUARIO`(null, '$nombre', '$apellido', '', {$_SESSION['idU']}, '$correo', 0, 1);";
						$WBD->SP($sqlu);

						if( $WBD->error() == '' ) {
							$r = mysqli_fetch_array($RESsql);
							$id = $r[0];
							$var =  $result->memberOf;
							$resUpdate = UpdateGrupos($id, $var, $WBD, $result);
							if( $resUpdate == 0 ) {
								$RES = array('nCodigo'=>"0", 'sMensaje'=>"Se ha Sincronizado correctamente con Windows");
							} else {
								$RES = array('nCodigo'=>"2".$resUpdate, 'sMensaje'=>"Error en Sincronizacion de Grupos de Windows ".$id);
								break;
							}
						} else {
							$RES = array('nCodigo'=>"5", 'sMensaje'=>"Error en Sincronizacion Usuarios de Windows, no se pudo actualizar correo ".$correo);
							break;
						}

						$sql = "CALL `data_acceso`.`SP_GET_PERFILES`($id);";
						$Result = $WBD->SP($sql);

						if ( mysqli_num_rows($Result) == 0 ) {
							if ( $_SESSION['MiSuerte'] ) {
								$idPortal = 1;
								$sql = "CALL `data_acceso`.`SP_INSERT_PERFILDEUSUARIO`($id, -1, $idPortal, {$_SESSION['idU']});";

								$Result = $WBD->query($sql);
								if ( $WBD->error() != '' ) {
									$RES = array('nCodigo'=>"2", 'sMensaje'=>$WBD->error());
								}
							}
						}

					}
				}
			}
		}
	}
}


function UpdateGrupos( $id, $var, $WBD, $result ) {
	if( is_array($var) ) {
		foreach ( $var as $group ) {
			$var = explode(",",$group);
			if( strpos($group,"Windows") == false && strpos($group,"Domain Admins") == false
			&& strpos($group,"Enterprise Admins") == false && strpos($group,"Schema Admins") == false
			&& strpos($group,"All Users") == false ) {
					if( $result->primarygroupid != "" ) {
						$var2 = explode("=", $var[0]);
						$sql = "CALL `data_acceso`.`SP_GET_GRUPOS`($id, '{$var2[1]}');";
						$resultado = $WBD->SP($sql);
						if ( $WBD->error() == '' ) {
							if ( mysqli_num_rows($resultado) == 0 ) {
								$sql = "CALL `data_acceso`.`SP_INSERT_GRUPO`($id, '{$var2[1]}', {$_SESSION['idU']});";
								$WBD->SP($sql);
								if ( $WBD->error() != '' ) {
									return 1;
								}
							} else {
								return 0;
							}
						}
					}
			}
		}
	}
	if( $WBD->error() == '' ) {
		return 0;
	} else {
		return 1;
	}
}

echo json_encode($RES);

?>