<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");


	$idAfiliacion	= (!empty($_POST['idAfiliacion']))? $_POST['idAfiliacion'] : -1;

	$aut = new AfiliacionClienteAutorizacion($RBD, $WBD, $LOG);
	$aut->IDAFILIACION = $idAfiliacion;

	$pre = $aut->iniciarPaseCliente();
	
	if($pre['existe'] != true){
		$respuesta = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'msg'		=> 'No ha sido posible Cargar los Datos de la Afiliación',
			'errmsg'	=> $oAf->ERROR_CODE." : ".$oAf->ERROR_MSG
		);
		echo json_encode($respuesta);
		exit();
	}

	$error = "";

	$lack = "";
	if($aut->AF->IDNIVEL <= 0){
		$lack .= "- Expediente\n";
	}

	if($aut->AF->IDCADENA <= 0){
		$lack .= "- Cadena\n";
	}
	if($aut->AF->IDGRUPO <= -1){
		$lack .= "- Grupo\n";
	}
	if($aut->AF->IDREFERENCIA <= 0){
		$lack .= "- Referencia\n";
	}
	if($aut->AF->IDTIPOPERSONA <= 0){
		$lack .= "- R\u00E9gimen Fiscal \n";
	}
	else{
		switch($aut->AF->IDTIPOPERSONA){
			case '1':
				if($aut->AF->NOMBREPERSONA == ""){
					$lack .= "- Nombre\n";
				}
				if($aut->AF->APATERNOPERSONA == ""){
					$lack .= "- Apellido Paterno\n";
				}
				if($aut->AF->AMATERNOPERSONA == ""){
					$lack .= "- Apellido Materno\n";
				}
			break;

			case '2':
				if($aut->AF->RAZONSOCIAL == ""){
					$lack .= "- Raz\u00F3n Social\n";
				}
			break;
		}
	}
	if($aut->AF->RFC == ""){
		$lack .= "- RFC \n";
	}

	if($aut->AF->IDGIRO <= -1){
		$lack .= "- Giro\n";
	}
	if($aut->AF->IDNIVEL > 1){
		if($aut->AF->FECHACONSITUTUCION == ""){
			$lack .= "- Fecha Constitutiva\n";
		}
	}
	if($aut->AF->TELEFONO == ""){
		$lack .= "- Tel\u00E9fono\n";
	}
	if($aut->AF->CORREO == ""){
		$lack .= "- Correo\n";
	}

	// validaciones de direccion
	if($aut->AF->IDPAIS <= 0){
		$lack .= "- Pa\u00EDs\n";
	}
	if($aut->AF->CALLE == ""){
		$lack .= "- Calle\n";
	}

	if($aut->AF->NUMEROEXTERIOR == ""){
		$lack .= "- N\u00FAmero Exterior\n";
	}

	if($aut->AF->CODIGOPOSTAL == ""){
		$lack .= "- C\u00F3digo Postal\n";
	}
	if($aut->AF->IDCOLONIA <= 0 || $aut->AF->IDCOLONIA == null){
		$lack .= "- Colonia\n";
	}
	if($aut->AF->IDENTIDAD <= 0 || $aut->AF->IDENTIDAD == null){
		$lack .= "- Estado\n";
	}
	if($aut->AF->IDMUNICIPIO <= 0 || $aut->AF->IDMUNICIPIO == null){
		$lack .= "- Ciudad\n";
	}

	// representante legal
	if($aut->AF->IDNIVEL > 1){
		if($aut->AF->NOMBREREPLEGAL == ""){
			$lack .= "- Nombre de Representante Legal\n";
		}
		if($aut->AF->APATERNOREPLEGAL == ""){
			$lack .= "- Apellido Paterno de Representante Legal\n";
		}
		if($aut->AF->AMATERNOREPLEGAL == ""){
			$lack .= "- Apellido Materno de Representante Legal\n";
		}
		if($aut->AF->RFCREPLEGAL == ""){
			$lack .= "- RFC de Representate Legal\n";
		}
		if($aut->AF->IDTIPOIDENTIFICACION == -1){
			$lack .= "- Tipo de Identificaci\u00F3n\n";
		}
		if($aut->AF->NUMEROIDENTIFICACION == ""){
			$lack .= "- N\u00FAmero de Identificaci\u00F3n\n";
		}
	}

	if($lack != ""){
		$black = ($lack != "")? "Los siguientes datos son Obligatorios : \n".$lack : "";

		$response['error']		= $lack;
		$response['showMsg']	= 1;
		$response['msg']		= $black;

		echo json_encode($response);
		exit();
	}

	//
	// creamos la subcadena en redefectiva.dat_subcadena
	//
	$res = $aut->crearSubCadena();

	if($res['success'] == true){
		$idSubCadena = $res['idSubCadena'];
	}
	else{
		$response = array(
			'success'	=> false,
			'msg'		=> 'No ha sido posible Crear el Cliente',
			'errmsg'	=> $res['errmsg'],
			'showMsg'	=> 1
		);
		echo json_encode($response);
		exit();
	}

	//
	// crear la direccion
	//
	$res = $aut->crearDireccion();

	if($res['success'] == true){
		$res = $aut->crearRelacionDireccion($idSubCadena, $res['idDireccion']);
	
		if($res['success'] != true){
			$error .= "- Relacion de Direccion";
		}
	}
	else{
		$error .= "- Dirección \n";
	}
	

	//
	// crear el representante legal
	//
	$actualizarRepLegal = false;
	if(!empty($aut->AF->IDREPLEGAL)){
		$res = $aut->crearRepresentanteLegal();
		if($res['success'] == true){
			$idRepLegal = $res['idRepLegal'];
			$actualizarRepLegal = true;
		}
		else{
			$error .= "- Representante Legal\n";
		}
	}

	//
	// crear cuenta de forelo
	//
	if($aut->AF->TIPOFORELO == 1){
		$res = $aut->crearCuentaForelo($idSubCadena, -1);
		if($res['success'] == true){
			$numCuenta = $res['numCuenta'];

			//crear la relacion de la cuenta de forelo
			$res = $aut->crearRelacionCuentaForelo($idSubCadena, -1, $numCuenta);
			if($res['success'] == true){
				
				// asignar la referencia bancaria
				$res = $aut->asignarReferenciaBancaria($numCuenta, $aut->AF->REFERENCIABANCARIA);

				if($res['success'] == true){
					//crear la cuenta de banco
					if($aut->AF->COMISIONES == 1 || $aut->AF->REEMBOLSO == 1){
						$clabe = $aut->AF->CLABE;
						$rfc = $aut->AF->RFC;

						$nombreBeneficiario = $aut->AF->BENEFICIARIO;
						if($aut->AF->COMISIONES == 1){
							$res = $aut->altaCuentaBanco($numCuenta, $clabe, $rfc, $nombreBeneficiario, 2);
						}
						if($aut->AF->REEMBOLSO == 1){
							$res = $aut->altaCuentaBanco($numCuenta, $clabe, $rfc, $nombreBeneficiario, 1);
						}

						if($res['success'] != true){
							$error .= "- Cuenta Bancaria\n";
						}
					}
					if($aut->AF->COMISIONES == 0 || $aut->AF->REEMBOLSO == 0){
						if($aut->AF->COMISIONES == 0){
							$res = $aut->altaCuentaConf(2, $numCuenta);
						}
						if($aut->AF->REEMBOLSO == 0){
							$res = $aut->altaCuentaConf(1, $numCuenta);
						}

						if($res['success'] != true){
							$error .= "- Configuración de Cuenta\n";
						}
					}
				}
				else{
					$error.= "- Asignar Referencia Bancaria\n";
				}
			}
			else{
				$error .= "- Relacion de Cuenta de Forelo\n";
			}
		}
		else{
			$error .= "- Cuenta de forelo \n";
		}
	}

	$res = $aut->actualizarCuentaCliente($idSubCadena, $idRepLegal, $numCuenta);

	if($res['success'] == true){

	}
	else{
		$error .= "- No se Actualizó la Cuenta";
	}

	$response = $res;

	$response['error']		= $error;
	$response['showMsg']	= 1;
	$response['msg']		= (empty($error))? "Operación Relizada Exitosamente" : $error;
	echo json_encode($response);

?>