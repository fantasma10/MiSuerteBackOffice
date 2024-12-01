<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

/* tipo:
1: Buscar Proveedores
2: Busca Familias
3: obtiene reporte general
4: obtiene reporte detallado
5: obtiene los totales de la tabla
11: obtiene el reporte por producto
*/

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

$proveedor = (isset($_POST['idProveedor']))?$_POST['idProveedor']:'';
$familia = (isset($_POST['idFamilia']))?$_POST['idFamilia']:'';
$fecha1 = (isset($_POST['fecha1']))?$_POST['fecha1']:'';
$fecha2 = (isset($_POST['fecha2']))?$_POST['fecha2']:'';
$tipo_res = (!empty($_POST["tipo_res"]))? $_POST["tipo_res"] : 0;


switch ($tipo) {
	case 1:
		$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_PROVEEDORES`()");
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($sql)) {
			$datos[$index]["idProveedor"] = $row["idProveedor"];
			$datos[$index]["nombreProveedor"] = utf8_encode($row["nombreProveedor"]);
			$index++;
		}
		print json_encode($datos);
		break;

	case 2:
		$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_FAMILIAS`()");
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($sql)) {
			$datos[$index]["idFamilia"] = $row["idFamilia"];
			$datos[$index]["descFamilia"] = utf8_encode($row["descFamilia"]);
			$index++;
		}
		print json_encode($datos);
		break;
	
	case 3:
		if($proveedor < -1)
        	$proveedor = null;
    	if($familia < -1)
        	$familia = null;

        $array_params = array(	    	
	      	array('name'    => 'fecha1','value'   => $fecha1,'type'    => 's'),
	      	array('name'    => 'fecha2','value'   => $fecha2,'type'    => 's'),
	      	array('name'    => 'proveedor','value'   => $proveedor, 'type'    => 'i'),
	       	array('name'    => 'familia','value'   => $familia,'type'    => 'i'),
	       	array('name'    => 'start','value'   => null,'type'    => 'i'),
	      	array('name'    => 'limit','value'   => null,'type'    => 'i'),
	      	array('name'    => 'tipo','value'   => $tipo_res,'type'    => 'i')
	    );


	    $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('SP_LOAD_REPORTEPROVEEDORES');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();

	    if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$pago_proveedor=0;
			$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["idProveedor"] 			= $data[$i]["idProveedor"];
				$datos[$index]["RFC"] 					= utf8_decode(mb_convert_encoding($data[$i]["RFC"], "UTF-8"));
				$datos[$index]["NOMBRE_PROVEEDOR"] 		= utf8_decode(mb_convert_encoding($data[$i]["NOMBRE_PROVEEDOR"], "UTF-8"));
				$datos[$index]['RAZON_SOCIAL'] 			= utf8_decode(mb_convert_encoding($data[$i]["RAZON_SOCIAL"], "UTF-8"));
				$datos[$index]["total"] 				= $data[$i]["MOV"];
				$datos[$index]["PRODUCTO"] 				= utf8_encode($data[$i]["PRODUCTO"]);
				$datos[$index]["IMPORTE"] 				= "$".number_format($data[$i]["IMPORTE"],2,'.',',');				
				$datos[$index]["COMISION_CLIENTE"] 		= "$".number_format($data[$i]["COMISION_CLIENTE"],2,'.',',');				
				$datos[$index]["IMPORTE_TOTAL"] 		= "$".number_format($data[$i]["IMPORTE_TOTAL"],2,'.',',');				
				$datos[$index]["COMISION_X_PAGAR"] 		= "$".number_format($data[$i]["COMISION_X_PAGAR"],2,'.',',');
				$datos[$index]["COMISION_X_COBRAR"] 	= "$".number_format($data[$i]["COMISION_X_COBRAR"],2,'.',',');	
				$datos[$index]["COMISION_X_PAGAR_CLI"] 	= "$".number_format($data[$i]["COMISION_X_PAGAR_CLI"],2,'.',',');
				$datos[$index]["COMISION_X_COBRAR_CLI"] = "$".number_format($data[$i]["COMISION_X_COBRAR_CLI"],2,'.',',');	
				$datos[$index]["COMISION_CORRESPONSAL"] = "$".number_format($data[$i]["COMISION_CORRESPONSAL"],2,'.',',');
				$datos[$index]["MARGEN_UTILIDAD"] 		= "$".number_format($data[$i]["MARGEN_UTILIDAD"],2,'.',',');
				$datos[$index]["PAGO_PROVEEDOR"] 		= "$".number_format($data[$i]["PAGO_PROVEEDOR"],2,'.',',');

				$datos[$index]["IMPORTE2"] 				= $data[$i]["IMPORTE"];				
				$datos[$index]["COMISION_CLIENTE2"] 	= $data[$i]["COMISION_CLIENTE"];
				$datos[$index]["IMPORTE_TOTAL2"] 		= $data[$i]["IMPORTE_TOTAL"];
				$datos[$index]["COMISION_X_PAGAR2"] 	= $data[$i]["COMISION_X_PAGAR"];
				$datos[$index]["COMISION_X_COBRAR2"] 	= $data[$i]["COMISION_X_COBRAR"];
				$datos[$index]["COMISION_X_PAGAR_CLI2"] = $data[$i]["COMISION_X_PAGAR_CLI"];
				$datos[$index]["COMISION_X_COBRAR_CLI2"]= $data[$i]["COMISION_X_COBRAR_CLI"];
				$datos[$index]["COMISION_CORRESPONSAL2"]= $data[$i]["COMISION_CORRESPONSAL"];
				$datos[$index]["MARGEN_UTILIDAD2"] 		= $data[$i]["MARGEN_UTILIDAD"];
				$datos[$index]["PAGO_PROVEEDOR2"] 		= $data[$i]["PAGO_PROVEEDOR"];
				$index++;

				$pago_proveedor = $pago_proveedor + $data[$i]["PAGO_PROVEEDOR"];				
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
	    }else{
	    	$datos = 0;
	    	$totalDatos = 0;
	    }
		$resultado = array(
		    "iTotalRecords"     => $totalDatos,
		    "iTotalDisplayRecords"  => $totalDatos,
		    "aaData"        => $datos,
		    "iPagoProveedor" => $pago_proveedor,
		);
	    echo json_encode($resultado);
		break;

	case 4:
		if($proveedor < -1)
        	$proveedor = NULL;
    	if($familia < -1)
        	$familia = NULL;
		$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
		$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
		
		$array_params = array(	    	
	      	array('name'    => 'fecha1','value'   => $fecha1,'type'    => 's'),
	      	array('name'    => 'fecha2','value'   => $fecha2,'type'    => 's'),
	      	array('name'    => 'proveedor','value'   => $proveedor,'type'    => 'i'),
	       	array('name'    => 'familia','value'   => $familia,'type'    => 'i'),
	       	array('name'    => 'start','value'   => $nStart,'type'    => 'i'),
	      	array('name'    => 'limit','value'   => $nLimit,'type'    => 'i'),
	      	array('name'    => 'tipo','value'   => 2,'type'    => 'i')
	    );
	   	
	   
	    $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('SP_LOAD_REPORTEPROVEEDORES');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();

	    if ( $result['nCodigo'] == 0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
			$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["idsOperacion"] = $data[$i]["idsOperacion"];
				$datos[$index]["AUTORIZACION"] = $data[$i]["AUTORIZACION"];
				$datos[$index]["REFERENCIA"] = $data[$i]["REFERENCIA"];
				$datos[$index]["PRODUCTO"] = utf8_encode($data[$i]["PRODUCTO"]);
				$datos[$index]["IMPORTE"] = "$".number_format($data[$i]["IMPORTE"],2,'.',',');
				$datos[$index]["COMISION_CLIENTE"] = "$".number_format($data[$i]["COMISION_CLIENTE"],2,'.',',');
				$datos[$index]["IMPORTE_TOTAL"] = "$".number_format($data[$i]["IMPORTE_TOTAL"],2,'.',',');
				$datos[$index]["COMISION_X_PAGAR"] = "$".number_format($data[$i]["COMISION_X_PAGAR"],2,'.',',');
				$datos[$index]["COMISION_X_COBRAR"] = "$".number_format($data[$i]["COMISION_X_COBRAR"],2,'.',',');	
				$datos[$index]["COMISION_X_PAGAR_CLI"] 	= "$".number_format($data[$i]["COMISION_X_PAGAR_CLI"],2,'.',',');
				$datos[$index]["COMISION_X_COBRAR_CLI"] = "$".number_format($data[$i]["COMISION_X_COBRAR_CLI"],2,'.',',');
				//$datos[$index]["COMISION_CORRESPONSAL"] = "$".number_format($data[$i]["COMISION_CORRESPONSAL"],2,'.',',');
				$datos[$index]["MARGEN_UTILIDAD"] = "$".number_format($data[$i]["MARGEN_UTILIDAD"],2,'.',',');
				$datos[$index]["PAGO_PROVEEDOR"] = "$".number_format($data[$i]["PAGO_PROVEEDOR"],2,'.',',');
				$datos[$index]["FECHA"] = $data[$i]["FECHA"];
				$datos[$index]["NOMCORR"] = utf8_encode($data[$i]["NOMCORR"]);
				$datos[$index]["CUENTACONTABLE"] = $data[$i]["CUENTACONTABLE"];
				$datos[$index]["NOMBRE_PROVEEDOR"] 		= utf8_decode(mb_convert_encoding($data[$i]["NOMBRE_PROVEEDOR"], "UTF-8"));
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
	    }else{
	    	$datos = 0;
	    	$totalDatos = 0;
	    }

		$resultado = array(
		    "iTotalRecords"     => $totalDatos,
		    "iTotalDisplayRecords"  => $totalDatos,
		    "aaData"        => $datos,
		);
	    echo json_encode($resultado);
		break;
	
	case 5:
		if($proveedor < -1)
        	$proveedor = NULL;
    	if($familia < -1)
        	$familia = NULL;

        $array_params = array(	    	
	      	array('name'    => 'fecha1',	'value'	=> $fecha1,		'type'    => 's'),
	      	array('name'    => 'fecha2',	'value' => $fecha2,		'type'    => 's'),
	      	array('name'    => 'proveedor',	'value' => $proveedor,	'type'    => 'i'),
	       	array('name'    => 'familia',	'value' => $familia,	'type'    => 'i'),
	       	array('name'    => 'start',		'value' => 0,			'type'    => 'i'),
	      	array('name'    => 'limit',		'value' => 0,			'type'    => 'i'),
	      	array('name'    => 'tipo',		'value' => 1,			'type'    => 'i')
	    );


	    $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('SP_LOAD_REPORTEPROVEEDORES');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();

	    if ( $result['nCodigo'] == 0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
	    	for($i=0;$i<count($data);$i++){
	    		$datos[$index]["total_operaciones"] =  number_format($data[$i]["MOV"],0,'.',',');
				$datos[$index]["IMPORTE"] = "$".number_format($data[$i]["IMPORTE"],2,'.',',');
				$datos[$index]["COMISION_CLIENTE"] = "$".number_format($data[$i]["COMISION_CLIENTE"],2,'.',',');
				$datos[$index]["IMPORTE_TOTAL"] = "$".number_format($data[$i]["IMPORTE_TOTAL"],2,'.',',');
				$datos[$index]["COMISION_X_PAGAR"] = "$".number_format($data[$i]["COMISION_X_PAGAR"],2,'.',',');
				$datos[$index]["COMISION_X_COBRAR"] = "$".number_format($data[$i]["COMISION_X_COBRAR"],2,'.',',');
				$datos[$index]["COMISION_CORRESPONSAL"] = "$".number_format($data[$i]["COMISION_CORRESPONSAL"],2,'.',',');
				$datos[$index]["MARGEN_UTILIDAD"] = "$".number_format($data[$i]["MARGEN_UTILIDAD"],2,'.',',');
				$datos[$index]["PAGO_PROVEEDOR"] = "$".number_format($data[$i]["PAGO_PROVEEDOR"],2,'.',',');
				$index++;
			}			
	    }else{
	    	$datos = 0;
	    }
		echo json_encode($datos);
		break;

	case 6:

		/*if($proveedor < -1)
        	$proveedor = NULL;
    	if($familia < -1)
        	$familia = NULL;

        $array_params = array(	    	
	      	array(
	        	'name'    => 'fecha1',
	        	'value'   => $fecha1,
	        	'type'    => 's'
	      	),
	      	array(
	        	'name'    => 'fecha2',
	        	'value'   => $fecha2,
	        	'type'    => 's'
	      	),
	      	array(
	        	'name'    => 'proveedor',
	        	'value'   => $proveedor, 
	        	'type'    => 'i'
	      	),
	       	array(
	        	'name'    => 'familia',
	        	'value'   => $familia,
	        	'type'    => 'i'
	      	),
	       	array(
	        	'name'    => 'start',
	        	'value'   => 0,
	        	'type'    => 'i'
	      	),
	      	array(
	        	'name'    => 'limit',
	        	'value'   => 10,
	        	'type'    => 'i'
	      	),
	      	array(
	        	'name'    => 'tipo',
	        	'value'   => 4,
	        	'type'    => 'i'
	      	)
	    );



	    $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('SP_LOAD_REPORTEPROVEEDORES');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();

	    if ( $result['nCodigo'] == 0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
	    	for($i=0;$i<count($data);$i++){
				$datos[$index]["AUT"] = $data[$i]["AUT"];
				$datos[$index]["PROD"] = $data[$i]["PROD"];
				$datos[$index]["IMPOP"] = "$".number_format($data[$i]["IMPOP"],2,'.',',');
				$datos[$index]["COMCLI"] = "$".number_format($data[$i]["COMCLI"],2,'.',',');
				$datos[$index]["SUBTOTAL"] = "$".number_format($data[$i]["SUBTOTAL"],2,'.',',');
				$datos[$index]["IVA"] = "$".number_format($data[$i]["IVA"],2,'.',',');
				$datos[$index]["IMPTOTAL"] = "$".number_format($data[$i]["IMPTOTAL"],2,'.',',');
				$datos[$index]["COMGANADA"] = "$".number_format($data[$i]["COMGANADA"],2,'.',',');
				$datos[$index]["IMPNETO"] = "$".number_format($data[$i]["IMPNETO"],2,'.',',');
				$datos[$index]["FECHA"] = $data[$i]["FECHA"]; 
				$datos[$index]["CUENTA"] = $data[$i]["CUENTA"]; 
				$datos[$index]["IDCORR"] = $data[$i]["IDCORR"]; 
				$datos[$index]["NOMCORR"] = $data[$i]["NOMCORR"];
				$datos[$index]["CUENTACONTABLE"] = $data[$i]["CUENTACONTABLE"];
				$index++;
			}			
	    }else{
	    	$datos = 0;
	    }
		echo json_encode($datos);*/
		break;
	
	case 7:

		if($proveedor < -1)
        	$proveedor = NULL;
    	if($familia < -1)
            $familia = NULL;

        $nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
		$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;

        $array_params = array(	    	
	      	array(
	        	'name'    => 'fecha1',
	        	'value'   => $fecha1,
	        	'type'    => 's'
	      	),
	      	array(
	        	'name'    => 'fecha2',
	        	'value'   => $fecha2,
	        	'type'    => 's'
	      	),
	      	array(
	        	'name'    => 'proveedor',
	        	'value'   => $proveedor, 
	        	'type'    => 'i'
	      	),
	       	array(
	        	'name'    => 'familia',
	        	'value'   => $familia,
	        	'type'    => 'i'
	      	),
	       	array(
	        	'name'    => 'start',
	        	'value'   => $nStart,
	        	'type'    => 'i'
	      	),
	      	array(
	        	'name'    => 'limit',
	        	'value'   => $nLimit,
	        	'type'    => 'i'
	      	),
	      	array(
	        	'name'    => 'p_tipo',
	        	'value'   => 1,
	        	'type'    => 'i'
	      	)
	    );


		    $oRdb->setSDatabase('redefectiva');
		    $oRdb->setSStoredProcedure('sp_reporte_prov_detalle');
		    $oRdb->setParams($array_params);
		    $result = $oRdb->execute();

	    if ( $result['nCodigo'] == 0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
	    	for($i=0;$i<count($data);$i++){
				$datos[$index]["IDSOPERACION"] = $data[$i]["IDSOPERACION"];
				$datos[$index]["REFERENCIA"] = $data[$i]["REFERENCIA"];
				$datos[$index]["FECHA_OP"] = $data[$i]["FECHA_OP"];
				$datos[$index]["HORA_OP"] = $data[$i]["HORA_OP"];
				$datos[$index]["IMPORTE_UFINAL_VALOR"] = "$".number_format($data[$i]["IMPORTE_UFINAL_VALOR"],2,'.',',');
				$datos[$index]["COMISION_ENTIDAD_VALOR"] = "$".number_format($data[$i]["COMISION_ENTIDAD_VALOR"],2,'.',',');
				$datos[$index]["IVA_COMISION"] = "$".number_format($data[$i]["IVA_COMISION"],2,'.',',');
				$datos[$index]["ID_COMERCIO"] = $data[$i]["ID_COMERCIO"];
				$datos[$index]["NOMBRE_COMERCIO"] = $data[$i]["NOMBRE_COMERCIO"];
				$datos[$index]["NO_AUTORIZACION"] = $data[$i]["NO_AUTORIZACION"];
				$datos[$index]["LIQUIDACION"] = $data[$i]["LIQUIDACION"];
				$index++;
            }
            $oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();	
	    }else{
            $datos = 0;
            $totalDatos = 0;
        }

        $resultado = array(
		    "iTotalRecords"     => $totalDatos,
		    "iTotalDisplayRecords"  => $totalDatos,
		    "aaData"        => $datos,
		);
		echo json_encode($resultado);
        break;
	
	case 8:
		$idProveedor = $_POST["idProveedor"];
		$listaFechasUnicas = $_POST["listaFechasUnicas"];
		$fechaPago = $_POST["fechaPago"];
		$contador=0;
		foreach ($listaFechasUnicas as $key => $value) {
			$sql = $WBD->query("CALL `redefectiva`.`sp_update_liquidacion`($idProveedor,'$value','$fechaPago');");
			$contador++;
		}
		print json_encode($contador);
		break;
	
	case 9: 
		$idProveedor = $_POST["idProveedor"];
		$sql = $RBD->query("CALL `redefectiva`.`sp_get_tipocredito_proveedor`($idProveedor)");
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($sql)) {
			$datos[$index]["nTipoTiempoAire"] = $row["nTipoTiempoAire"];
			$index++;
		}
		print json_encode($datos);
		break;
	
	case 10:

		$nStart		= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
		$nLimit 	= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;

		if($proveedor<0){
			$proveedor=NULL;
		}
		if($familia<0){
			$familia=NULL;
		}

		$array_params = array(	    	
			array(
				'name'    => 'fecha1',
				'value'   => $fecha1,
				'type'    => 's'
			),
			array(
				'name'    => 'fecha2',
				'value'   => $fecha2,
				'type'    => 's'
			),
			array(
				'name'    => 'proveedor',
				'value'   => $proveedor, 
				'type'    => 'i'
			),
			array(
				'name'    => 'familia',
				'value'   => $familia,
				'type'    => 'i'
			),
			array(
				'name'    => 'start',
				'value'   => $nStart,
				'type'    => 'i'
			),
			array(
				'name'    => 'limit',
				'value'   => $nLimit,
				'type'    => 'i'
			),
			array(
				'name'    => 'p_tipo',
				'value'   => 2,
				'type'    => 'i'
			)
		);

		$oRdb->setSDatabase('redefectiva');
		$oRdb->setSStoredProcedure('sp_reporte_prov_detalle');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();

		if ( $result['nCodigo'] == 0){
			$data = $oRdb->fetchAll();
			$datos = array();
			$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["FECHA"] = $data[$i]["FECHA"];
				$datos[$index]["TOTAL"] = $data[$i]["TOTAL"];
				$datos[$index]["IMPORTE_COBRANZA"] = $data[$i]["IMPORTE_COBRANZA"];
				$datos[$index]["DIA_SIGUIENTE"] = $data[$i]["DIA_SIGUIENTE"];
				$datos[$index]["COMISION"] = $data[$i]["COMISION"];
				$datos[$index]["IMPORTE_LIQUIDACION"] = $data[$i]["IMPORTE_LIQUIDACION"];
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();	
		}else{
			$datos = 0;
			$totalDatos = 0;
		}

		$resultado = array(
			"iTotalRecords"     => $totalDatos,
			"iTotalDisplayRecords"  => $totalDatos,
			"aaData"        => $datos,
		);
		echo json_encode($resultado);
		break;
	
	case 11:
		if($proveedor < -1)
        	$proveedor = null;
    	if($familia < -1)
        	$familia = null;

        $array_params = array(	    	
	      	array('name'    => 'fecha1','value'   => $fecha1,'type'    => 's'),
	      	array('name'    => 'fecha2','value'   => $fecha2,'type'    => 's'),
	      	array('name'    => 'proveedor','value'   => $proveedor, 'type'    => 'i'),
	       	array('name'    => 'familia','value'   => $familia,'type'    => 'i'),
	       	array('name'    => 'start','value'   => null,'type'    => 'i'),
	      	array('name'    => 'limit','value'   => null,'type'    => 'i'),
	      	array('name'    => 'tipo','value'   => $tipo_res,'type'    => 'i')
	    );


	    $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('SP_LOAD_REPORTEPROVEEDORES');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();

	    if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
			$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["NOMBRE_PRODUCTO"] = utf8_encode($data[$i]["NOMBRE_PRODUCTO"]);
				$datos[$index]["total"] = $data[$i]["MOV"];
				//$datos[$index]["RAZON_SOCIAL"] = $data[$i]["RAZON_SOCIAL"];
				//$datos[$index]["PRODUCTO"] = utf8_encode($data[$i]["PRODUCTO"]);
				$datos[$index]["IMPORTE"] = "$".number_format($data[$i]["IMPORTE"],2,'.',',');
				$datos[$index]["COMISION_CLIENTE"] = "$".number_format($data[$i]["COMISION_CLIENTE"],2,'.',',');
				$datos[$index]["IMPORTE_TOTAL"] = "$".number_format($data[$i]["IMPORTE_TOTAL"],2,'.',',');
				$datos[$index]["COMISION_X_PAGAR"] = "$".number_format($data[$i]["COMISION_X_PAGAR"],2,'.',',');
				$datos[$index]["COMISION_X_COBRAR"] = "$".number_format($data[$i]["COMISION_X_COBRAR"],2,'.',',');
				$datos[$index]["COMISION_X_PAGAR_CLI"] 	= "$".number_format($data[$i]["COMISION_X_PAGAR_CLI"],2,'.',',');
				$datos[$index]["COMISION_X_COBRAR_CLI"] = "$".number_format($data[$i]["COMISION_X_COBRAR_CLI"],2,'.',',');	
				$datos[$index]["COMISION_CORRESPONSAL"] = "$".number_format($data[$i]["COMISION_CORRESPONSAL"],2,'.',',');
				$datos[$index]["MARGEN_UTILIDAD"] = "$".number_format($data[$i]["MARGEN_UTILIDAD"],2,'.',',');
				$datos[$index]["PAGO_PROVEEDOR"] = "$".number_format($data[$i]["PAGO_PROVEEDOR"],2,'.',',');
				$datos[$index]["RETENCION"] = ($data[$i]["RETENCION"] == 1) ? 'Sin retención' : 'Con retención';
					
				//$pago_proveedor = $pago_proveedor + $data[$i]["PAGO_PROVEEDOR"];

				$datos[$index]["IMPORTE2"] 				= $data[$i]["IMPORTE"];				
				$datos[$index]["COMISION_CLIENTE2"] 	= $data[$i]["COMISION_CLIENTE"];
				$datos[$index]["IMPORTE_TOTAL2"] 		= $data[$i]["IMPORTE_TOTAL"];
				$datos[$index]["COMISION_X_PAGAR2"] 	= $data[$i]["COMISION_X_PAGAR"];
				$datos[$index]["COMISION_X_COBRAR2"] 	= $data[$i]["COMISION_X_COBRAR"];
				$datos[$index]["COMISION_X_PAGAR_CLI2"] = $data[$i]["COMISION_X_PAGAR_CLI"];
				$datos[$index]["COMISION_X_COBRAR_CLI2"]= $data[$i]["COMISION_X_COBRAR_CLI"];
				$datos[$index]["COMISION_CORRESPONSAL2"]= $data[$i]["COMISION_CORRESPONSAL"];
				$datos[$index]["MARGEN_UTILIDAD2"] 		= $data[$i]["MARGEN_UTILIDAD"];
				$datos[$index]["PAGO_PROVEEDOR2"] 		= $data[$i]["PAGO_PROVEEDOR"];	

				$index++;		
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
	    }else{
	    	$datos = 0;
	    	$totalDatos = 0;
	    }
		$resultado = array(
		    "iTotalRecords"     => $totalDatos,
		    "iTotalDisplayRecords"  => $totalDatos,
		    "aaData"        => $datos
		);
	    echo json_encode($resultado);
		break;
	
	default:
		# code...
		break;
}