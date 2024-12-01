<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;
switch ($tipo) {
	case 1:
		$fechaIni	= $_POST["fechaIni"];
		$fechaFin	= $_POST["fechaFin"];
		$mPago          = $_POST["metodoPago"];
                $sBuscar        = !empty($_POST['sSearch']) ? trim($_POST['sSearch'])    : '';
                $nStart         = (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
                $nLimit         = (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
		
            $datos = array();
            $index = 0;
            $array_params = array(
                array('name' => '_fechaIni',    'value' => $fechaIni, 'type' =>'s'),
                array('name' => '_fechaFin',    'value' => $fechaFin, 'type' =>'s'),
                array('name' => '_metodoPago',  'value' => $mPago,    'type' =>'i'),
                array('name' => 'p_buscar',	'value' => $sBuscar,  'type' => 's'),
                array('name' => 'p_start',      'value' => $nStart,   'type' => 'i'),
                array('name' => 'p_limit',      'value' => $nLimit,   'type' => 'i'),
                array('name' => 'p_tipo',       'value' => 1,         'type' => 'i')
            );
            $MRDB->setSDatabase('pronosticos');
            $MRDB->setSStoredProcedure('sp_select_ventas');
            $MRDB->setParams($array_params);
            $result = $MRDB->execute();

            if ( $result['nCodigo'] ==0){
                $data = $MRDB->fetchAll();
                $datos = array();
                $index = 0;
                for($i=0;$i<count($data);$i++){
                    $datos[$index]["FechaContable"]         = $data[$i]["dFechaContable"];       
                    $datos[$index]["dFecSolicitud"]         = $data[$i]["dFecSolicitud"];
                    $datos[$index]["dFecConfirmacion"]      = $data[$i]["dFecConfirmacion"];
                    $datos[$index]["sGameName"]             = $data[$i]["sGameName"];
                    $datos[$index]["metodo_pago"]           = $data[$i]["metodo_pago"];
                    $datos[$index]["nIdFolio"]              = $data[$i]["nIdFolio"];
                    $datos[$index]["nIdFolioVenta"]         = $data[$i]["nIdFolioVenta"];
//                    $datos[$index]["nIdGame"]               = $data[$i]["nIdGame"];
//                    $datos[$index]["nIdEntryMode"]          = $data[$i]["nIdEntryMode"];                    
                    $datos[$index]["nMontoCargo"]           = "$".number_format($data[$i]["nMontoCargo"],2,'.',',');
                    $datos[$index]["nMontoRedencion"]       = "$".number_format($data[$i]["nMontoRedencion"],2,'.',',');
                    $datos[$index]["nMonto"]                = "$".number_format($data[$i]["nMonto"],2,'.',',');
                    $datos[$index]["comision_pronosticos"]  = "$".number_format($data[$i]["comision_pronosticos"],2,'.',',');
                    $index++;
                }
                    $MRDB->closeStmt();
                    $totalDatos = $MRDB->foundRows();
                    $MRDB->closeStmt();
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
	
	default:
		# code...
		break;
}
?>