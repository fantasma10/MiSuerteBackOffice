<?php

	error_reporting(0);
	ini_set('display_errors', 0);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idCosto		= (!empty($_POST['idCosto']))? $_POST['idCosto'] : 0;
	$idTipoForelo	= (!empty($_POST['idTipoForelo']))? $_POST['idTipoForelo'] : 0;
	$idCliente		= (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	//var_dump("TEST A");

	$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);

	$oAf->load($idCliente);

	$tipoForeloOriginal = $oAf->TIPOFORELO;

	$oAf->TIPOFORELO = $idTipoForelo;
	$idCostoOriginal = $oAf->IDCOSTO;
	$oAf->IDCOSTO = $idCosto;
	$idExpediente = $oAf->IDNIVEL;

	$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`($idCosto, $idExpediente)");
	$res = mysqli_fetch_assoc($sql);
	
	$res['minimoPuntos'] = ($res['minimoPuntos'] == null)? 0 : $res['minimoPuntos'] ;
	$res['maximoPuntos'] = ($res['maximoPuntos'] == null)? 0 : $res['maximoPuntos'] ;
	$cobroA		= (!empty($res['CobroA']))? $res['CobroA'] : 0;
	$tipoCobro	= (!empty($res['TipoCobro']))? $res['TipoCobro'] : 0;

	if($cobroA <= 0){
		echo json_encode(array(
			'success'	=> false,
			'showMsg'	=> 1,
			'msg'		=> "Falta Configuración de Costos",
			'errmsg'	=> "No cuenta con la configuración de Cobro"
		));
		exit();
	}

	$maximoPuntosOriginal = $oAf->MAXIMOPUNTOS;
	$puntosMaximos = ($res['maximoPuntos'] == 0)? $res['minimoPuntos'] : $res['maximoPuntos'];
	/*var_dump("maximoPuntos: {$res['maximoPuntos']}");
	var_dump("minimoPuntos: {$res['minimoPuntos']}");
	var_dump("NUMEROCORRESPONSALES: ".$oAf->NUMEROCORRESPONSALES);*/
	if($maximoPuntos > 0 && $res['minimoPuntos'] > 0){
		if(/*($maximoPuntosOriginal > $puntosMaximos) && */$oAf->NUMEROCORRESPONSALES > $puntosMaximos){
			echo json_encode(array(
				'success'	=> false,
				'showMsg'	=> 1,
				'msg'		=> "No puede seleccionar un paquete con rango menor al número de sucursales registradas",
				'errmsg'	=> $maximoPuntos." ".$puntosMaximos
			));
			exit();
		}
	}

	$oAf->MAXIMOPUNTOS = $puntosMaximos;
	$oAf->IDVERSION = $res['idVersion'];

	$response =	$oAf->guardarDatosGenerales();

	if($response["success"] == true){
		$response["showMsg"] = 0;
		// si es forelo compartido se crea la referencia bancaria
		if($oAf->TIPOFORELO == 1 || $cobroA == 2){
			if($oAf->IDREFERENCIABANCARIA == 0){
				$response = $oAf->crearReferenciaBancaria();

				if($response["success"] == true){
					$response["showMsg"] = 0;

					$oAf->IDREFERENCIABANCARIA = $response['data']['idReferencia'];

					// crear las cuotas
					$oAf->load($idCliente);
					if($cobroA == 2 && $tipoCobro == 1){
						$response = $oAf->crearCuotas();

						if($response["success"] == true){
							$response["showMsg"] = 0;
						}
						else{
							$response["showMsg"]	= 1;
							$response["msg"]		= "Ha ocurrido un error al crear las Cuotas";
						}
					}
				}
				else{
					$response["showMsg"]	= 1;
					$response["msg"]		= "Ha ocurrido un error al crear la Referencia Bancaria, inténtelo de nuevo";
				}
			}
			else{
				if($idCostoOriginal != $idCosto){
					$oAf->load($idCliente);

					if($cobroA == 2){
						$response = $oAf->crearCuotas();

						if($response["success"] == true){
							$response["showMsg"] = 0;
						}
						else{
							$response["showMsg"]	= 1;
							$response["msg"]		= "Ha ocurrido un error al crear las Cuotas";
						}
					}
					else{
						$QUERY = "CALL `afiliacion`.`SP_CUOTA_ELIMINAR`(".$oAf->ID_CLIENTE.", 0,0);";

						$sql = $WBD->query($QUERY);

						if(!$WBD->error()){
							if($oAf->NUMEROCORRESPONSALES > $puntosMaximos){
								$response = array(
									'success'	=> true,
									'showMsg'	=> 1,
									'msg'		=> "El paquete seleccionado tiene un máximo de puntos menor al número de sucursales registradas para este cliente.",
									'data'		=> array()
								);						
							}else{
								$response = array(
									'success'	=> true,
									'data'		=> array()
								);
							}
						}
						else{
							$response = array(
								'success'	=> false,
								'data'		=> array(),
								'errmsg'	=> $WBD->error()
							);
							$LOG->error("Error al eliminar Las cuotas : ".$QUERY." | ".$WBD->error(), false);
						}
					}
				}
			}
		}
		else{
			if($oAf->IDREFERENCIABANCARIA > 0){
				$response = $oAf->eliminarForelo();

				if($response["success"] == true){
					$response["showMsg"] = 0;

					//$oAf->IDREFERENCIABANCARIA = $response['data']['idReferencia'];
				}
				else{
					$response["showMsg"]	= 1;
					$response["msg"]		= "Ha ocurrido un error al Eliminar la Relación con la Referencia Bancaria, inténtelo de nuevo";
				}
			}
		}
	}
	else{
		$response["showMsg"]	= 1;
		$response["msg"]		= "No ha sido posible guardar el Paquete Seleccionado";
	}

	$oAf->prepararCliente();

	/*var_dump("tipoForeloOriginal: $tipoForeloOriginal");
	var_dump("idTipoForelo: $idTipoForelo");
	var_dump("tipoCobro: $tipoCobro");
	var_dump("cobroA: $cobroA");*/
	
	if(($tipoForeloOriginal != $idTipoForelo) || ($tipoCobro == 0 || $cobroA == 1)){
		$numSucursales = $oAf->NUMEROCORRESPONSALES;
		$QUERY = $RBD->query("CALL `afiliacion`.`SP_SUCURSAL_LISTA`($idCliente, 0, 'ASC', '', 0, $numSucursales, 0);");
		//var_dump("CALL `afiliacion`.`SP_SUCURSAL_LISTA`($idCliente, 0, 'ASC', '', 0, $numSucursales, 0);");
		$SUC = new AfiliacionSucursal2($RBD, $WBD, $LOG);
		$SUC->load($idCliente);

		if(($tipoForeloOriginal == 2 && $idTipoForelo == 2) || $cobroA == 1){
			$SUC->eliminarCuotas();
		}

		while($res = mysqli_fetch_assoc($QUERY)){
			$SUC->completoSucursal($res['idCorresponsal']);
			$oAf->TIPOFORELO;
			$SUC->prepararSucursal($res['idCorresponsal']);

			// al cambiar de forelo compartido a individual se deben crear las cuotas para las sucursales que ya estan creadas
			/*var_dump("tipoForeloOriginal: $tipoForeloOriginal");
			var_dump("idTipoForelo: $idTipoForelo");
			var_dump("tipoCobro: $tipoCobro");*/
			if(($tipoForeloOriginal == 1 && $idTipoForelo == 2) || $tipoCobro == 0){
				/*var_dump("TEST A");
				var_dump("idCorresponsal: ".$res['idCorresponsal']);*/
				$sucursal = $SUC->getSucursal($res['idCorresponsal']);
				$idForelo = $sucursal['idForelo'];
				/*echo "<pre>";
				print_r($sucursal);
				echo "</pre>";
				var_dump("TEST B");*/
				if($cobroA == 1){
					/*var_dump("TEST C");
					var_dump("idForelo: $idForelo");*/
					if($idForelo != null && $idForelo != ""){
						//var_dump("TEST D");
						$resCrearRefBancaria = $SUC->crearReferenciaBancaria($res['idCorresponsal'], $idCliente, 0);
						if ( $resCrearRefBancaria["success"] ) {
							$idForelo = $resCrearRefBancaria["data"]["idForelo"];
							$referenciaBancaria = $resCrearRefBancaria["data"]["referenciaBancaria"];
							if ( empty($sucursal["Correo"]) ) {
								$sucursal["Correo"] = "''";
							}
							$sucursal["FecActivacion"] = 'NULL';
							$sucursal["NombreSucursal"] = "'".$sucursal["NombreSucursal"]."'";
							$sucursal["idEstatus"] = 1;
							$sucursal["idForelo"] = $idForelo;
							$sucursal["ReferenciaBanco"] = $referenciaBancaria;
							$resEditarSucursal = $SUC->editarSucursal( $res['idCorresponsal'], $sucursal );
							
							if ( $resEditarSucursal["success"] ) {
								$sucursal['idCuentaBanco'] = 0;
								$resActualizarForelo = $SUC->actualizarForelo( $idForelo, $res['idCorresponsal'], -1, -1, $sucursal['idCuentaBanco'], $sucursal['ReferenciaBanco'] );
								if ( $resActualizarForelo['success'] ) {
									$SUC->crearCuotas($oAf->IDCOSTO, $oAf->IDNIVEL, $idForelo, $idCliente, 0, $res['idCorresponsal']);
								}
							}
							
							/*if ( $resEditarSucursal["success"] ) {
								$SUC->crearCuotas($oAf->IDCOSTO, $oAf->IDNIVEL, $idForelo, $idCliente, 0, $res['idCorresponsal']);
							}*/
							
							//if ( $resActualizarForelo['success'] ) {
								/*echo "<pre>";
								print_r($sucursal);
								echo "</pre>";
								echo "<pre>";
								print_r($resEditarSucursal);
								echo "</pre>";*/
								//if ( $resEditarSucursal["success"] ) {
									//$SUC->crearCuotas($oAf->IDCOSTO, $oAf->IDNIVEL, $idForelo, $idCliente, 0, $res['idCorresponsal']);
								//}
							//}
						}
					}
				}
				else if($cobroA == 2){
					//$SUC->crearCuotas($oAf->IDCOSTO, $oAf->IDNIVEL, $oAf->IDFORELO, $idCliente, 0, 0);	
					$SUC->ES_CLIENTE_REAL = false;
					$SUC->ID_SUCURSAL_ACTIVA = $res['idCorresponsal']  ;
					$SUC->actualizarCuotas();
				}
			}
			if(($tipoForeloOriginal == 2 && $idTipoForelo == 1)){
				$sucursal = $SUC->getSucursal($res['idCorresponsal']);
				$sucursal['idForelo'] = 0;
				$sucursal['NombreSucursal'] = "'".$sucursal['NombreSucursal']."'";
				$sucursal['FecActivacion'] = "'".$sucursal['FecActivacion']."'";
				$sucursal['Correo'] = "NULL";
				$SUC->editarSucursal($res['idCorresponsal'], $sucursal);
			}
		}
		// cuando cambia de forelo individual a forelo compartido se eliminan las cuotas de las sucursales que ya estan creadas
		if(($tipoForeloOriginal == 2 && $idTipoForelo == 1) || $cobroA == 2){
			$SUC->eliminarCuotas();
		}
	}

	echo json_encode($response);
?>