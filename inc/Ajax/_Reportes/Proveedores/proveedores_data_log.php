<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

//$data=array();
/* tipo:
1: Buscar Proveedores
2: Busca Familias
3: obtiene reporte general
4: obtiene reporte detallado
5: obtiene los totales de la tabla
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
        	$proveedor = 0;
    	if($familia < -1)
        	$familia = null;

        $array_params = array(
					array('name' => 'p_IdProveedor', 'value' => $proveedor, 'type' =>'i'),
				);

        $oRdb->setSDatabase('nautilus');
	    $oRdb->setSStoredProcedure('sp_select_proveedor_conector');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();
	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	
	    	$datos = array();
	    	$index = 0;
	    	$totalOperaciones = 0;
	    	$totalImporte = 0;
			for($i=0;$i<count($data);$i++){
				if(strlen($data[$i]["idConector"])<3)
					$num_conector = str_pad($data[$i]["idConector"],3,"0",STR_PAD_LEFT);
				else
					$num_conector = $data[$i]["idConector"];
				$nomProveedor = $data[$i]["NomProveedor"];

				$array_params = array(
					array('name' => 'p_num_conector', 'value' => $num_conector, 'type' =>'s'),
					array('name' => 'p_fecha1', 'value' => $fecha1, 'type' =>'s'),
					array('name' => 'p_fecha2', 'value' => $fecha2, 'type' =>'s')
				);		
				$oRdb->closeStmt();	

				$oRDLdb->setSDatabase('data_log');
	    		$oRDLdb->setSStoredProcedure('sp_select_reporte_conector');
	    		$oRDLdb->setParams($array_params);
	    		$result = $oRDLdb->execute();
	    		if ( $result['nCodigo'] ==0){
			    	$data2 = $oRDLdb->fetchAll();	
			    	$oRDLdb->closeStmt();				
					for($j=0;$j<count($data2);$j++){	
						if($data2[$j]["totalOperaciones"]>0){							
							$datos[$index]["conector"] = $num_conector;
							$datos[$index]["total"] = $data2[$j]["totalOperaciones"];
							$datos[$index]["NOMPROVEEDOR"] = utf8_encode($nomProveedor);	
							$datos[$index]["IMPOP"] = "$".number_format($data2[$j]["sumaImporte"],2,'.',',');	
							
							$totalOperaciones = $totalOperaciones + $data2[$j]["totalOperaciones"];
							$totalImporte = $totalImporte +	$data2[$j]["sumaImporte"];		
							$index++;
						}																
					}
			
			    }
			}
	
	    }
	    $resultado = array(
		    "iTotalRecords"     => $index,
		    "iTotalDisplayRecords"  => $index,
		    "totalOperacion" => $totalOperaciones,
		    "totalImporte" => "$".number_format($totalImporte,2,'.',','),
		    "aaData"        => $datos
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
	        	'name'    => 'tipo',
	        	'value'   => 2,
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
				$datos[$index]["idsOperacion"] = $data[$i]["idsOperacion"];
				$datos[$index]["AUT"] = $data[$i]["AUT"];
				$datos[$index]["PROD"] = utf8_encode($data[$i]["PROD"]);
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
	        	'value'   => 0,
	        	'type'    => 'i'
	      	),
	      	array(
	        	'name'    => 'tipo',
	        	'value'   => 1,
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
				$datos[$index]["total_operaciones"] =  number_format($data[$i]["COUNT(`idsOperacion`)"],0,'.',',');
				$datos[$index]["IMPOP"] = "$".number_format($data[$i]["IMPOP"],2,'.',',');
				$datos[$index]["COMCLI"] = "$".number_format($data[$i]["COMCLI"],2,'.',',');
				$datos[$index]["SUBTOTAL"] = "$".number_format($data[$i]["SUBTOTAL"],2,'.',',');
				$datos[$index]["IVA"] = "$".number_format($data[$i]["IVA"],2,'.',',');
				$datos[$index]["IMPTOTAL"] = "$".number_format($data[$i]["IMPTOTAL"],2,'.',',');
				$datos[$index]["COMGANADA"] = "$".number_format($data[$i]["COMGANADA"],2,'.',',');
				$datos[$index]["IMPNETO"] = "$".number_format($data[$i]["IMPNETO"],2,'.',',');
				$index++;
			}			
	    }else{
	    	$datos = 0;
	    }
		echo json_encode($datos);
		break;
	
	default:
		# code...
		break;
}