<?php
include("../../../inc/config.inc.php");
include("../../../inc/session.ajax.inc.php");

$idCorresponsal = (isset($_POST['idCorresponsal'])) ? $_POST['idCorresponsal'] : -1;

$nombreCorresponsal		= (isset($_POST['nombreCorresponsal']))? trim($_POST['nombreCorresponsal']) : null;
$telefono1				= (isset($_POST['telefono1']))? trim($_POST['telefono1']) : null;
$telefono2				= (isset($_POST['telefono2']))? trim($_POST['telefono2']) : null;
$fax					= (isset($_POST['fax']))? trim($_POST['fax']) : null;
$correo					= (isset($_POST['correo']))? trim($_POST['correo']) : null;
$fechaVencimiento		= (isset($_POST['fechaVencimiento']))? trim($_POST['fechaVencimiento']) : null;
$giro					= (isset($_POST['giro']) /*AND $_POST["giro"] > 0*/)? $_POST['giro'] : null;
$referencia				= (isset($_POST['referencia']))? $_POST['referencia'] : null;
$estatus				= (isset($_POST['estatus'])/* AND $_POST["estatus"] > -1*/)? $_POST['estatus'] : null;
$usuarioAlta			= (isset($_POST['usuarioAlta']))? $_POST['usuarioAlta'] : null;
$nombreSucursal			= (isset($_POST['nombreSucursal']))? trim($_POST['nombreSucursal']) : '';
$numeroSucursal			= (isset($_POST['numeroSucursal']))? trim($_POST['numeroSucursal']) : '';
$representanteLegal		= (isset($_POST['representanteLegal']))? $_POST['representanteLegal'] : null;
$calle					= (isset($_POST['calle']))? trim($_POST['calle']) : null;
$numeroExterior			= (isset($_POST['numeroExterior']))? trim($_POST['numeroExterior']) : null;
$numeroInterior			= (isset($_POST['numeroInterior']))? trim($_POST['numeroInterior']) : null;
$colonia				= (isset($_POST['colonia']))? trim($_POST['colonia']) : null;
$estado					= (isset($_POST['estado']))? $_POST['estado'] : null;
$municipio				= (isset($_POST['municipio']))? $_POST['municipio'] : null;
$pais					= (isset($_POST['pais']))? $_POST['pais'] : null;
$codigoPostal			= (isset($_POST['codigoPostal']))? trim($_POST['codigoPostal']) : null;
$corresponsaliaBancaria	= (isset($_POST['corresponsaliaBancaria']))? $_POST['corresponsaliaBancaria'] : null;
$ejecutivoVenta			= (isset($_POST['ejecutivoVenta']))? $_POST['ejecutivoVenta'] : null;
$ejecutivoCuenta		= (isset($_POST['ejecutivoCuenta']))? $_POST['ejecutivoCuenta'] : null;
$ejecutivoRemesas		= (isset($_POST['ejecutivoRemesas']))? $_POST['ejecutivoRemesas'] : null;
$ejecutivoBancario		= (isset($_POST['ejecutivoBancario']))? $_POST['ejecutivoBancario'] : null;
$idIva					= (!empty($_POST['iva']) AND $_POST["iva"] >-1)? $_POST['iva'] : "";

$idUsuario = $_SESSION["idU"];
$calle = utf8_decode($calle);

$telefono1 = str_replace("-", "", $telefono1);
$telefono2 = str_replace("-", "", $telefono2);

$arrEjecutivos = array(
	array(
		"idTipo"		=> 5,
		"idEjecutivo"	=> $ejecutivoCuenta
	),
	array(
		"idTipo"		=> 2,
		"idEjecutivo"	=> $ejecutivoVenta
	),
	array(
		"idTipo"		=> 9,
		"idEjecutivo"	=> $ejecutivoRemesas
	),
	array(
		"idTipo"		=> 10,
		"idEjecutivo"	=> $ejecutivoBancario
	),
);

if ( empty($representanteLegal) || $representanteLegal == -3 ) {
	$representanteLegal = "NULL";
}
if ( empty($fechaVencimiento) ) {
	$fechaVencimiento = "NULL";
} else {
	$fechaVencimiento = "'$fechaVencimiento'";
}
if ( empty($giro) || $giro <= 0 ) {
	$giro = "NULL";
}
if ( empty($codigoPostal) ) {
	$codigoPostal = "NULL";
}
if ( empty($ejecutivoVenta) || $ejecutivoVenta == -3 ) {
	$ejecutivoVenta = "NULL";
}
if ( empty($usuarioAlta) || $usuarioAlta == -3 ) {
	$usuarioAlta = "NULL";
}

$RES = '';
if ( $idCorresponsal > 0 ) {
	$estatusCor = (!empty($_POST['corresponsaliaBancaria']))? $_POST['corresponsaliaBancaria'] : 0;

	/*$sql = $WBD->query("CALL `data_info`.`SP_CREATE_CORRESPONSALIABANCARIA`($idCorresponsal, $estatusCor, $idUsuario)");

	if($WBD->error()){
		echo $RES = "1|Error al crear la corresponsalia bancaria ".$sql." ".$WBD->error();
		exit();
	}*/

	$sql = "CALL `redefectiva`.`SP_UPDATE_CORRESPONSAL`('$nombreCorresponsal', '$telefono1', '$telefono2', '$fax', '$correo', $fechaVencimiento, $giro, $referencia, '$estatus', $usuarioAlta, '$nombreSucursal', '$numeroSucursal', $idCorresponsal);";
    $WBD->SP($sql);
    if ( $WBD->error() == '' ) {
    	/* actualizar o crear los ejecutivos de cuenta y venta */
    	foreach($arrEjecutivos AS $ej){
    		$idEjecutivo	= $ej['idEjecutivo'];
    		$tipoEjecutivo	= $ej['idTipo'];

			$sql		= "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOCORRESPONSAL`($idCorresponsal, $tipoEjecutivo);";
			$sql2		= "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOCORRESPONSAL`($idCorresponsal, $idEjecutivo, {$_SESSION['idU']}, _IDCORRESPONSALEJECUTIVO_);";
			$fecVigen	= date('Y-m-d', strtotime('+10 Year'));
			$sql3		= "CALL `redefectiva`.`SP_INSERT_EJECUTIVOCORRESPONSAL`($idCorresponsal, $idEjecutivo, '$fecVigen', {$_SESSION['idU']}, $tipoEjecutivo);";

			$RESsql = $RBD->SP($sql);	
			if(mysqli_num_rows($RESsql) > 0){
				$row = mysqli_fetch_assoc($RESsql);

				$arrReplace		 = array('_IDCORRESPONSALEJECUTIVO_');
				$arrReplacements = array($row["idCorresponsalEjecutivo"]);

				$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);

				$WBD->SP($sql2);

				if($WBD->error() == ''){
					$RES = "0|Se ha actualizado correctamente el Corresponsal";
				}
				else{
					$RES = "2|Error al asignar el Ejecutivo ".$sql2." ".$WBD->error();
				}
			}
			else{
				$WBD->SP($sql3);
				if($WBD->error() == ''){
					$RES = "0|Se ha actualizado correctamente el Corresponsal";
				}
				else{
					$RES = "1|Error al asignar el ejecutivo ".$sql3." ".$WBD->error();	
				}
			}
		}/* foreach */

		$fecha		= strftime( "%Y-%m-%d", time() );	
		$fecha 		= explode("-",$fecha);
		$fecha_en10 = mktime(0,0,0,$fecha[1],$fecha[2],$fecha[0]+10);
		$fecVen 	= date("Y-m-d", $fecha_en10);
		//echo "CALL SP_SET_CORRESPONSALIVA($idCorresponsal, $idIva, '$fecVen', $idUsuario)";
		/*if(!empty($idIva)){
			$sql = $WBD->query("CALL SP_SET_CORRESPONSALIVA($idCorresponsal, $idIva, '$fecVen', $idUsuario)");
			if($WBD->error() != ""){
				echo $RES = "1|".$WBD->error();
			}
		}*/

        $RES = "0|Se actualizo la informacion del corresponsal";
		//$sql = "CALL `redefectiva`.`SP_UPDATE_CORRESPONSALBANCO`('$corresponsaliaBancaria', $idCorresponsal);";
		$sql = "CALL `data_info`.`SP_CREATE_CORRESPONSALIABANCARIA`($idCorresponsal, $estatusCor, $idUsuario)";
		//$sql = $WBD->query("SELECT 1");
		$WBD->SP($sql);
		if ( $WBD->error() == '' ) {

			if($estatusCor == 3){
				$sql = $WBD->query("CALL `redefectiva`.`SP_UPDATE_CORRESPONSALBANCO`('$estatusCor', $idCorresponsal);");

				if($WBD->error()){
					echo $RES = "1|Error al actualizar la corresponsalia bancaria ".$sql." ".$WBD->error();
					exit();
				}
			}

			$sql = "CALL `redefectiva`.`SP_UPDATE_CORRESPONSALUSUARIOALTA`($usuarioAlta, $idCorresponsal);";
			$WBD->SP($sql);
			/*if ( $WBD->error() == '' ) {
				$sql = "CALL `redefectiva`.`SP_UPDATE_CORRESPONSALEJECUTIVO`($ejecutivoVenta, $idCorresponsal);";
				$WBD->SP($sql);*/
				if ( $WBD->error() == '' ) {
					$sql = "CALL `redefectiva`.`SP_UPDATE_CORRESPONSALREPLEGAL`($representanteLegal, $idCorresponsal);";
					$WBD->SP($sql);
					if ( $WBD->error() == '' ) {
						if ( $pais == 164 ) {
							$sql = "CALL `redefectiva`.`SP_UPDATE_CORRESPONSALDIRECCION`('$calle', '$numeroExterior', '$numeroInterior', $pais, $colonia, $estado, $municipio, $codigoPostal, $idCorresponsal);";
							$res = $WBD->SP($sql);
							if ( $WBD->error() != '' ) {
								$RES = "4|No fue posible actualizar la Direccion del Corresponsal ".$WBD->error();
							}
							else{
								/*$sql = $WBD->query("SELECT ROW_COUNT() AS cuenta");*/
								$row = mysqli_fetch_assoc($res);

								if($row['cuenta'] == 0){
								//if(mysqli_affected_rows() == 0){
									$sql = "CALL `redefectiva`.`SP_INSERT_DIRECCION`('$calle', '$numeroExterior', '$numeroInterior', $pais, $estado, $municipio, $colonia, $codigoPostal, 0, $idUsuario)";
									$res = $WBD->query($sql);
									if($WBD->error()){
										echo $WBD->error();
									}
									else{
										$res = mysqli_fetch_array($res);
										$iDir = $res[0];
										$sql = "CALL `redefectiva`.`SP_INSERT_INFDIRECCION`($idCorresponsal, $iDir, $idUsuario)";
										$WBD->query($sql);
										if($WBD->error()){
											echo $WBD->error();
										}
									}
								}
							}
						} else if ( $pais != 164 && $pais > 0 ) {
								$estado = utf8_decode($estado);
								$municipio = utf8_decode($municipio);
								$colonia = utf8_decode($colonia);
								$sql = "CALL `redefectiva`.`SP_FIND_ESTADOEXTRANJERO`($pais, '$estado');";
								$result = $RBD->SP($sql);
								if ( $RBD->error() == '' ) {
									if ( $result->num_rows > 0 ) {
										list( $idEstadoExtranjero ) = $result->fetch_array();
									} else {
										$sql = "CALL `redefectiva`.`SP_INSERT_ESTADOEXTRANJERO`($pais, '$estado', {$_SESSION['idU']});";
										$result = $WBD->SP($sql);
										if ( $WBD->error() == '' ) {
											$sql = "CALL `redefectiva`.`SP_FIND_ESTADOEXTRANJERO`($pais, '$estado');";
											$result = $RBD->SP($sql);
											if ( $RBD->error() == '' ) {
												list( $idEstadoExtranjero ) = $result->fetch_array();
											} else {
												echo "5|Error al buscar estado extranjero";
												exit();
											}	
										} else {
											echo "4|Error al insertar estado extranjero";
											exit();
										}
									}	
								} else {
									echo "2|Error al guardar la direccion";
									exit();
								}
								$sql = "CALL `redefectiva`.`SP_FIND_CIUDADEXTRANJERA`($idEstadoExtranjero, '$municipio');";
								$result = $RBD->SP($sql);
								if ( $RBD->error() == '' ) {
									if ( $result->num_rows > 0 ) {
										list( $idCiudadExtranjera ) = $result->fetch_array();
									} else {
										$sql = "CALL `redefectiva`.`SP_INSERT_CIUDADEXTRANJERA`($idEstadoExtranjero, $pais, '$municipio', {$_SESSION['idU']});";
										$result = $WBD->SP($sql);
										if ( $WBD->error() == '' ) {
											$sql = "CALL `redefectiva`.`SP_FIND_CIUDADEXTRANJERA`($idEstadoExtranjero, '$municipio')";
											$result = $RBD->SP($sql);
											if ( $RBD->error == '' ) {
												if ( $result->num_rows > 0 ) {
													list( $idCiudadExtranjera ) = $result->fetch_array();
												} else {
													echo "8|Error al buscar ciudad extranjera";
													exit();
												}
											} else {
												echo "7|Error al buscar ciudad extranjera";
												exit();
											}
										} else {
											echo "6|Error al insertar ciudad extranjera";
											exit();
										}
									}
								} else {
									echo "3|Error al guardar la direccion";
									exit();
								}
								$sql = "CALL `redefectiva`.`SP_FIND_COLONIAEXTRANJERA`($pais, $idEstadoExtranjero, $idCiudadExtranjera, '$colonia');";
								$result = $RBD->SP($sql);
								if ( $RBD->error() == '' ) {
									if ( $result->num_rows > 0 ) {
										list( $idColoniaExtranjera ) = $result->fetch_array();
									} else {
										$sql = "CALL `redefectiva`.`SP_INSERT_COLONIAEXTRANJERA`($pais, $idEstadoExtranjero, $idCiudadExtranjera, '$colonia', {$_SESSION['idU']});";
										$result = $WBD->SP($sql);
										if ( $WBD->error() == '' ) {
											$sql = "CALL `redefectiva`.`SP_FIND_COLONIAEXTRANJERA`($pais, $idEstadoExtranjero, $idCiudadExtranjera, '$colonia');";
											$result = $RBD->SP($sql);
											if ( $RBD->error() == '' ) {
												list( $idColoniaExtranjera ) = $result->fetch_array();
												$sql = "CALL `redefectiva`.`SP_UPDATE_CORRESPONSALDIRECCION`('$calle', '$numeroExterior', '$numeroInterior', $pais, $idColoniaExtranjera, $idEstadoExtranjero, $idCiudadExtranjera, $codigoPostal, $idCorresponsal);";
												$WBD->SP($sql);
												if ( $WBD->error() != '' ) {
													$RES = "12|No fue posible actualizar la Direccion del Corresponsal";
												}							
											} else {
												echo "11|Error al buscar ciudad extranjera";
												exit();
											}
										} else {
											echo "10|Error al insertar colonia extranjera";
											exit();
										}
									}
								} else {
									echo "9|Error al buscar colonia extranjera";
									exit();
								}
								$sql = "CALL `redefectiva`.`SP_UPDATE_CORRESPONSALDIRECCION`('$calle', '$numeroExterior', '$numeroInterior', $pais, $idColoniaExtranjera, $idEstadoExtranjero, $idCiudadExtranjera, $codigoPostal, $idCorresponsal);";
								$res = $WBD->SP($sql);
								if ( $WBD->error() != '' ) {
									$RES = "12|No fue posible actualizar la Direccion del Corresponsal";
								}
								$row = mysqli_fetch_assoc($res);
								if($row['cuenta'] == 0){
								//if(mysqli_affected_rows() == 0){
									$sql = "CALL `redefectiva`.`SP_INSERT_DIRECCION`('$calle', '$numeroExterior', '$numeroInterior', $pais, '$idEstadoExtranjero', '$idCiudadExtranjera', $idColoniaExtranjera, '$codigoPostal', 0, $idUsuario)";
									$res = $WBD->query($sql);
									if($WBD->error()){
										echo $WBD->error();
									}
									else{
										$res = mysqli_fetch_array($res);
										$iDir = $res[0];
										$sql = "CALL `redefectiva`.`SP_INSERT_INFDIRECCION`($idCorresponsal, $iDir, $idUsuario)";
										$WBD->query($sql);
										if($WBD->error()){
											echo $WBD->error();
										}
									}
								}
						}
					} else {
						$RES = "3|No fue posible asociar el Representante Legal con el Corresponsal";
					}
				}
				else {
					$RES = "2|No fue posible asociar el Banco con el Corresponsal";
				}
			/*} else {
				$RES = "13|No fue posible actualizar el Ejecutivo de Venta";
			}*/
		} else {
			$RES = "14|No fue posible actualizar el Usuario de Alta";
		}
    } else {
        //$RES = "1|No fue posible actualizar el corresponsal: ".$sql;
		$RES = "1|No fue posible actualizar el corresponsal: ".$WBD->error();
    }   
} else {
    $RES = "No se recibieron datos para actualizar";
}

echo $RES;

?>