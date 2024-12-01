<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");



	$tipoProveedor	= (!empty($_POST['tipoProveedor']))? $_POST['tipoProveedor'] : 0;
	$tipoCorte		= (!empty($_POST['tipoCorte']))? $_POST['tipoCorte'] : 0;
	$idCorte		= (!empty($_POST['idCorte']))? $_POST['idCorte'] : 0;
	$idFactura		= (!empty($_POST['idFactura']))? $_POST['idFactura'] : 0;
	$descripcion	= (!empty($_POST['descripcion']))? $_POST['descripcion'] : '';
	$tipoRelacion = (!empty($_POST['tipoRelacion']))? $_POST['tipoRelacion'] : 0;

	$idUsuario = $_SESSION['idU'];

	$corte		= "";
	$factura	= "";

	switch($tipoCorte){
		// corte proveedor interno
		case '1' :
			$facturas = explode("|", $_POST['idFacturas']);

			foreach($facturas AS $c){
				$factura .= $c.",";
			}

			$factura = trim($factura, ",");
			//var_dump($factura);
			$sQ = "CALL `data_contable`.`SP_CORTES_PROVEEDOR_ASIGNARFACTURA`($idCorte, '$factura', '$descripcion', $idUsuario)";
		break;
		// corresponsales
		case '3' :
			if($tipoRelacion == 1){
				
				$cortes = explode("|", $_POST['cortes']);

				foreach($cortes AS $c){
					$corte .= $c.",";
				}

				$cortes = trim($corte, ",");
				
				$idFactura = $_POST['idFacturas'];

				$sQ = "CALL `data_contable`.`SP_CORTES_COMISION_ASIGNARFACTURA`('$cortes', $idFactura, '$descripcion', $idUsuario)";
			}else{
			
				$facturas = explode("|", $_POST['idFacturas']);

				foreach($facturas AS $c){
					$factura .= $c.",";
				}

				$factura = trim($factura, ",");
				
				$corte = $_POST['cortes'];
				
				$sQ = "CALL `data_contable`.`SP_CORTES_COMISION_ASIGNARFACTURA_2`($corte, '$factura', '$descripcion', $idUsuario)";
				
			}


			
		break;
		// grupos
		case '4' :
		
			if($tipoRelacion == 1){
				
				$cortes = explode("|", $_POST['cortes']);

				foreach($cortes AS $c){
					$corte .= $c.",";
				}

				$cortes = trim($corte, ",");
				
				$idFactura = $_POST['idFacturas'];

				$sQ = "CALL `data_contable`.`SP_CORTES_GRUPO_ASIGNARFACTURA`('$cortes', $idFactura, '$descripcion', $idUsuario)";
			}else{
			
				$facturas = explode("|", $_POST['idFacturas']);

				foreach($facturas AS $c){
					$factura .= $c.",";
				}

				$factura = trim($factura, ",");
				
				$corte = $_POST['cortes'];
				
				
				$sQ = "CALL `data_contable`.`SP_CORTES_GRUPO_ASIGNARFACTURA_2`($corte, '$factura', '$descripcion', $idUsuario)";
				
			}
			
		break;
	}

	$sql = $WBD->query($sQ);

	if(!$WBD->error()){

		$res = mysqli_fetch_assoc($sql);
		if($res['codigo'] == 0){
			$response = array(
				'showMsg'	=> 0,
				'msg'		=> 'Factura Asignada',
				'errmsg'	=> ''
			);
		}
		else{
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> acentos($res['msg']),
				'errmsg'	=> 'codigo :'.acentos($res['errmsg']).' ; msg : '.acentos($res['msg'])
			);	
		}

	}
	else{
		$response = array(
			'showMsg'	=> 1,
			'msg'		=> 'No fue posible asignar la Factura al Corte',
			'errmsg'	=> $WBD->error()
		);
	}

	echo json_encode($response);
?>