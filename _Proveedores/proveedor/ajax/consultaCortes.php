<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch ($tipo) {
	case 1:		
		$array_params = array(
			array('name' => 'p_idProveedor', 'value' => 0, 'type' =>'i')
		);

		$oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_select_proveedor_cortes');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();
	   	
	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["idProveedor"] = $data[$i]["idProveedor"];
				$datos[$index]["nombreProveedor"] = utf8_encode($data[$i]["nombreProveedor"]);
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
	    }else{
	    	$datos = 0;
	    }		
	    echo json_encode($datos);


		// $array_params = array(
		// 	array('name' => 'p_idProveedor', 'value' => 0, 'type' =>'i')
		// );
		
  //       $oRdb->setSDatabase('redefectiva');
	 //    $oRdb->setSStoredProcedure('sp_select_proveedor_cortes');
	 //    $oRdb->setParams($array_params);
	 //    $result = $oRdb->execute();
	   	
	 //   	if ( $result['nCodigo'] ==0){
	 //    	$data = $oRdb->fetchAll();
	 //    	$datos = array();
	 //    	$index = 0;
		// 	for($i=0;$i<count($data);$i++){
		// 		$datos[$index]["idProveedor"] = utf8_encode($data[$i]["idProveedor"]);
		// 		$datos[$index]["nombreProveedor"] = utf8_encode($data[$i]["nombreProveedor"]);
		// 		$index++;
		// 	}
		// 	$oRdb->closeStmt();
		// 	$totalDatos = $oRdb->foundRows();
		// 	$oRdb->closeStmt();
	 //    }else{
	 //    	$datos = 0;
	 //    	$totalDatos = 0;
	 //    }
		// $resultado = array(
		//     "iTotalRecords"     => $totalDatos,
		//     "iTotalDisplayRecords"  => $totalDatos,
		//     "aaData"        => $datos,
		// );
	 //    echo json_encode($resultado);
		break;

	case 2:
		$proveedor =$_POST["proveedor"];
		$fechaIni =$_POST["fechaIni"];
		$fechaFin =$_POST["fechaFin"];
		$tipo_busqueda =$_POST["tipo_busqueda"];

		// $hoy = date("Y-m-d");



		$idProducto = (!empty($_POST["idProducto"]))? $_POST["idProducto"] : 0;
		$array_params = array(
			array('name' => 'P_IDPROVEEDOR', 'value' => $proveedor, 'type' =>'i'),
			array('name' => 'P_FECHAINI', 'value' => $fechaIni, 'type' =>'s'),
			array('name' => 'P_FECHAFIN', 'value' => $fechaFin, 'type' =>'s'),
			array('name' => 'P_TIPOBUSQUEDA', 'value' => $tipo_busqueda, 'type' =>'i'),
		);
		
        $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_select_corte_proveedor');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();

	    // var_dump($result);
	    // exit();
	   	
	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["nIdProveedor"] = $data[$i]["nIdProveedor"];
				$datos[$index]["nombreProveedor"] = utf8_encode($data[$i]["nombreProveedor"]);
				$datos[$index]["nTotalOperaciones"] = $data[$i]["nTotalOperaciones"];
				$datos[$index]["nTotalMonto"] = $data[$i]["nTotalMonto"];
				$datos[$index]["nTotalComision"] = $data[$i]["nTotalComision"];
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

	case 3:
		$oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('SP_LOAD_ESTATUS');
	    $result = $oRdb->execute();
	   	
	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["idEstatus"] = $data[$i]["idEstatus"];
				$datos[$index]["descEstatus"] = utf8_encode($data[$i]["descEstatus"]);
				$index++;
			}
			$oRdb->closeStmt();
			$totalDatos = $oRdb->foundRows();
			$oRdb->closeStmt();
	    }else{
	    	$datos = 0;
	    }		
	    echo json_encode($datos);
	break;
	
	case 4:
		$idProducto = (!empty($_POST["idProducto"])) ? $_POST["idProducto"] : 0;
		$familia = (!empty($_POST["familia"])) ? $_POST["familia"] : 0;
		$subfamilia = (!empty($_POST["subfamilia"])) ? $_POST["subfamilia"] : 0;
		$emisor = (!empty($_POST["emisor"])) ? $_POST["emisor"] : 0;
		$descripcion = (!empty($_POST["descripcion"])) ? $_POST["descripcion"] : 0;
		$abreviatura = (!empty($_POST["abreviatura"])) ? $_POST["abreviatura"] : 0;
		$sku = (!empty($_POST["sku"])) ? $_POST["sku"] : 0;
		
		if(!empty($_POST["fechaentradavigor"])){
			$fechaentradavigor = ($_POST["fechaentradavigor"]);
		}else{
			$fechaentradavigor="0000-00-00";
		}

		if(!empty($_POST["fechasalidavigor"])){
			$fechasalidavigor = ($_POST["fechasalidavigor"]);
		}else{
			$fechasalidavigor="0000-00-00";
		}
		$flujoimporte = (!empty($_POST["flujoimporte"])) ? $_POST["flujoimporte"] : 0;
		$importeminimoproducto = (!empty($_POST["importeminimoproducto"])) ? $_POST["importeminimoproducto"] : 0;
		$importemaximoproducto = (!empty($_POST["importemaximoproducto"])) ? $_POST["importemaximoproducto"] : 0;
		$porcentajecomisionproducto = (!empty($_POST["porcentajecomisionproducto"])) ? $_POST["porcentajecomisionproducto"] : 0;
		$importecomisionproducto = (!empty($_POST["importecomisionproducto"])) ? $_POST["importecomisionproducto"] : 0;
		$porcentajecomisioncorresponsal = (!empty($_POST["porcentajecomisioncorresponsal"])) ? $_POST["porcentajecomisioncorresponsal"] : 0;
		$importecomisioncorresponsal = (!empty($_POST["importecomisioncorresponsal"])) ? $_POST["importecomisioncorresponsal"] : 0;
		$porcentajecomisioncliente = (!empty($_POST["porcentajecomisioncliente"])) ? $_POST["porcentajecomisioncliente"] : 0;
		$importecomisioncliente = (!empty($_POST["importecomisioncliente"])) ? $_POST["importecomisioncliente"] : 0;
		$estatus = (!empty($_POST["estatus"])) ? $_POST["estatus"] : 0;
		$usuario = $_SESSION["idU"];

		
		$query = "CALL `redefectiva`.`sp_update_producto`($idProducto,$familia,$subfamilia,$emisor,'$abreviatura','$descripcion','$sku','$fechaentradavigor','$fechasalidavigor',$flujoimporte,$importeminimoproducto,$importemaximoproducto,$porcentajecomisionproducto,$importecomisionproducto,$porcentajecomisioncorresponsal,$importecomisioncorresponsal,$porcentajecomisioncliente,$importecomisioncliente,$estatus,$usuario);";
		$resultado = $WBD->query($query);

		if (!($resultado)) {
		    $datos[$index]["ErrorCode"] = "1";
			$datos[$index]["ErrorMsg"] = "Error al Actulizar";
		    print json_encode($datos);
		}else{
			while ($row = mysqli_fetch_assoc($resultado)) { 
				$datos[$index]["ErrorCode"] = $row["ErrorCode"];
				$datos[$index]["ErrorMsg"] = utf8_encode($row["ErrorMsg"]);
			}
			print json_encode($datos);
		}
	break;

	default:
		# code...
		break;
}

?>