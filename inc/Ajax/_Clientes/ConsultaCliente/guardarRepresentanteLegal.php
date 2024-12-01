<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");


	$idCliente				= (!empty($_POST['idCliente']))				? $_POST['idCliente']	 							: 0;
	$idRepresentantelegal	= (!empty($_POST['idRepresentantelegal']))	? $_POST['idRepresentantelegal']					: 0;
	$idTipoIdent			= (!empty($_POST['idTipoIdent']))	? $_POST['idTipoIdent']					: 0;
	
	$nombreRepLegal			= (!empty($_POST['nombreRepLegal']))		? trim(urldecode($_POST['nombreRepLegal']))			: "";
	$paternoRepLegal		= (!empty($_POST['paternoRepLegal']))		? trim(urldecode($_POST['paternoRepLegal']))		: "";
	$maternoRepLegal		= (!empty($_POST['maternoRepLegal']))		? trim(urldecode($_POST['maternoRepLegal']))		: "";
	$rfcRepresentantelegal	= (!empty($_POST['rfcRepresentantelegal']))	? trim(urldecode($_POST['rfcRepresentantelegal']))	: "";
	$numeroIdentificacion	= (!empty($_POST['numeroIdentificacion']))	? trim(urldecode($_POST['numeroIdentificacion']))	: "";
	$figPolitica			= (isset($_POST['figPolitica']))							? 1												: 0;
	$famPolitica			= (isset($_POST['famPolitica']))							? 1 											: 0;

	if($idCliente > 0){

		$C = new Cliente($RBD, $WBD, $LOG);
		$C->load($idCliente);

		$C->ID_REPRESENTANTELEGAL		= $idRepresentantelegal;
		$C->NOMBRE_REPLEGAL				= utf8_decode($nombreRepLegal);
		$C->PATERNO_REPRESENTANTELEGAL	= utf8_decode($paternoRepLegal);
		$C->MATERNO_REPRESENTANTELEGAL	= utf8_decode($maternoRepLegal);
		$C->RFC_REPRESENTANTELEGAL		= $rfcRepresentantelegal;
		$C->FAM_POLITICA				= $famPolitica;
		$C->FIG_POLITICA				= $figPolitica;
		$C->NUMERO_IDENTIFICACION		= $numeroIdentificacion;
		$C->ID_TIPOIDENTIFICACION		= $idTipoIdent;

		//var_dump("ID_REPRESENTANTELEGAL: ".$C->ID_REPRESENTANTELEGAL);

		if($C->ID_REPRESENTANTELEGAL == 0){
			/*
			**	validar si no existe ya un representante con esos datos
			*/
			$QUERY = "CALL `redefectiva`.`SP_FIND_REPRESENTANTELEGAL`('$C->ID_TIPOIDENTIFICACION', '$C->NUMERO_IDENTIFICACION' , '$C->RFC_REPRESENTANTELEGAL', $C->ID_REPRESENTANTELEGAL)";
			$sql = $RBD->query($QUERY);

			if(!$RBD->error()){
				$result = mysqli_fetch_assoc($sql);
				if($result['cuenta'] > 0){
					$response = array(
						'showMsg'	=> 1,
						'msg'		=> 'Ya existe un Representante Legal con los Datos Proporcionados'
					);
					echo json_encode($response);
					exit();
				}
			}
			else{
				$response = array(
					'msg'		=> 'No se han podido comprobar los datos del Representante Legal',
					'showMsg'	=> 1,
					'errmsg'	=> $RBD->error()
				);
				echo json_encode($response);
				exit();
			}

			$res = $C->guardarRepresentanteLegal();
		}
		else{
			$res = $C->guardarRepresentanteLegal();
		}

		if($res['success'] == true){
			$res['showMsg'] = 0;
			$res['msg']		= 'Operación Exitosa';
			$C->load($idCliente);
			$res['idRepresentanteLegal'] = $C->ID_REPRESENTANTELEGAL;
			$res['nombreCompleto'] = codificarUTF8($C->NOMBRE_REPLEGAL).' '.codificarUTF8($C->PATERNO_REPRESENTANTELEGAL).' '.codificarUTF8($C->MATERNO_REPRESENTANTELEGAL);
			$res['nombre'] = codificarUTF8($C->NOMBRE_REPLEGAL);
			$res['paterno'] = codificarUTF8($C->PATERNO_REPRESENTANTELEGAL);
			$res['materno'] = codificarUTF8($C->MATERNO_REPRESENTANTELEGAL);
			$res['rfc'] = $C->RFC_REPRESENTANTELEGAL;
			$res['famPoliticaDesc'] = ($C->FAM_POLITICA == 1)? codificarUTF8('Sí') : 'No';
			$res['figPoliticaDesc'] = ($C->FIG_POLITICA == 1)? codificarUTF8('Sí') : 'No';
			$res['famPolitica'] = $C->FAM_POLITICA;
			$res['figPolitica'] = $C->FIG_POLITICA;
			$res['numeroIdentificacion'] = $C->NUMERO_IDENTIFICACION;
			$res['nombreIdentificacion'] = codificarUTF8($C->NOMBRE_TIPOIDENTIFICACION);
			$res['tipoIdentificacion'] = $C->ID_TIPOIDENTIFICACION;
		}
		else{
			$res['showMsg'] = 1;
			$res['msg']		= 'No ha sido posible guardar los Datos del Representante Legal';	
		}
	}
	else{
		$res = array(
			'success'	=> false,
			'showMsg'	=> 1,
			'msg'		=> 'Id de Cliente inválido'
		);
	}

	echo json_encode($res);
?>