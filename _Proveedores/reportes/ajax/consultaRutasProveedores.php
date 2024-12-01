<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include_once $_SERVER['DOCUMENT_ROOT']."/inc/PHPExcel/Classes/PHPExcel.php";

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch ($tipo){
    case 1:
        $familia    = (!empty($_POST['familia'])) ? $_POST["familia"] : 2;
        $proveedor  = (!empty($_POST["proveedor"])) ? $_POST["proveedor"] : NULL;
        $producto   = ((!empty($_POST["producto"]))) ? $_POST["producto"] : NULL;
        $start      = (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"] : 0;
        $limit      = (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : NULL;
        $estatus    = ($_POST['estatus'] >= 0) ? $_POST['estatus'] : NULL;
        $buscar     = (!empty($_POST['sSearch'])) ? trim($_POST['sSearch']) : NULL;
        $array_params = array(
            array('name' => 'ck_familia', 'value' => $familia, 'type' =>'i'),
            array('name' => 'ck_proveedor', 'value' => $proveedor, 'type' =>'i'),
            array('name' => 'ck_producto', 'value' => $producto, 'type' =>'i'),
            array('name' => 'ck_start', 'value' => $start, 'type' =>'i'),
            array('name' => 'ck_limit', 'value' => $limit, 'type' =>'i'),
            array('name' => 'ck_idEstatusProducto', 'value' => $estatus, 'type' => 'i'),
            array('name' => 'ck_buscar', 'value' => $buscar, 'type' =>'s'),
        );
    	$oRdb->setSDatabase('redefectiva');
    	$oRdb->setSStoredProcedure('sp_select_rutas_proveedores');
    	$oRdb->setParams($array_params);
    	$result = $oRdb->execute();
    	if ( $result['nCodigo'] ==0){
    	  	$data = $oRdb->fetchAll();
    	   	$datos = array();
    	   	$index = 0;
    		for($i=0;$i<count($data);$i++){
                $datos[$i]["FAMILIA"]                           = $data[$i]["FAMILIA"];
                $datos[$i]["ID_PROVEEDOR"]                      = $data[$i]["ID_PROVEEDOR"];
                $datos[$i]["NOMBRE_COM_PROVEEDOR"]              = $data[$i]["NOMBRE_COM_PROVEEDOR"];
                $datos[$i]["NOMBRE_PROVEEDOR"]                  = $data[$i]["NOMBRE_PROVEEDOR"];
                $datos[$i]["ID_PRODUCTO"]                       = $data[$i]["ID_PRODUCTO"];
                $datos[$i]["PRODUCTO"]                          = $data[$i]["PRODUCTO"];
                $datos[$i]["ESTATUS_PRODUCTO"]                  = ($data[$i]["ESTATUS_PRODUCTO"] == 0) ? 'ACTIVO' : 'INACTIVO';
                $datos[$i]["ID_RUTA"]                           = $data[$i]["ID_RUTA"];
                $datos[$i]["RUTA"]                              = $data[$i]["RUTA"];
                $datos[$i]["PORCENTAJE_USUARIO_MAX_POSIBLE"]    = $data[$i]["PORCENTAJE_USUARIO_MAX_POSIBLE"];
                $datos[$i]["IMP_USUARIO_MAS_POSIBLE"]           = $data[$i]["IMP_USUARIO_MAS_POSIBLE"];
                $datos[$i]["PORCENTAJE_COBRO_PROVEEDOR"]        = $data[$i]["PORCENTAJE_COBRO_PROVEEDOR"];
                $datos[$i]["IMP_COBRO_PROVEEDOR"]               = $data[$i]["IMP_COBRO_PROVEEDOR"];
                $datos[$i]["PORCENTAJE_PAGO_PROVEEDOR"]         = $data[$i]["PORCENTAJE_PAGO_PROVEEDOR"];
                $datos[$i]["IMP_PAGO_PROVEEDOR"]                = $data[$i]["IMP_PAGO_PROVEEDOR"];
                $datos[$i]["SUMA_INGRESO_RED"]                  = $data[$i]["SUMA_INGRESO_RED"];
                $datos[$i]["MARGEN_MINIMO"]                     = $data[$i]["MARGEN_MINIMO"];
                $datos[$i]["MAXIMO_COMISION_RUTAS"]             = $data[$i]["MAXIMO_COMISION_RUTAS"];
                $datos[$i]["PORCENTAJE_COMISION_CADENA"]        = $data[$i]["PORCENTAJE_COMISION_CADENA"];
                $datos[$i]["IMP_MAX_COMISION_CADENA"]           = $data[$i]["IMP_MAX_COMISION_CADENA"];
                $datos[$i]["MARGEN_RED"]                        = $data[$i]["MARGEN_RED"];
                
    		}
    		$oRdb->closeStmt();
    		$totalDatos = $oRdb->foundRows();
    		$oRdb->closeStmt();
    	}else{
    	   	$datos      = 0;
            $totalDatos = 0;
    	}
        $resultado = array(
            //"detalle_consulta"=> $result,
            "iTotalRecords"     => $totalDatos,
            "iTotalDisplayRecords"  => $totalDatos,
            "aaData"        => $datos
        );	
    	echo json_encode($resultado);

        break;
    case 2:
        $familia = (!empty($_POST['familia'])) ? $_POST['familia'] : 0;
        $array_params = array(
            array('name' => 'pfamilia', 'value' => $familia, 'type' =>'i'),
            array('name' => 'psubfamilia', 'value' => 0, 'type' =>'i'),
            array('name' => 'pemisor', 'value' => 0, 'type' =>'i'),
            array('name' => 'ptipobusqueda', 'value' => 4, 'type' =>'i'),
            array('name' => 'pactivo', 'value' => 1, 'type' =>'i'),
        );
    	$oRdb->setSDatabase('redefectiva');
    	$oRdb->setSStoredProcedure('sp_busca_productos');
    	$oRdb->setParams($array_params);
    	$result = $oRdb->execute();
    	if ( $result['nCodigo'] ==0){
    	  	$data = $oRdb->fetchAll();
    	   	$datos = array();
    	   	$index = 0;
    		for($i=0;$i<count($data);$i++){
                if ($data[$i]['idEstatusProducto'] == 0) {
    			    $datos[$index]["idProducto"] = $data[$i]["idProducto"];
    			    $datos[$index]["descProducto"] = utf8_encode($data[$i]["descProducto"]);
    			    $index++;
                }
    		}
    		$oRdb->closeStmt();
    		$totalDatos = $oRdb->foundRows();
    		$oRdb->closeStmt();
    	}else{
    	   	$datos = 0;
    	}		
    	echo json_encode($datos);
        break;
}