<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

function guardarServicios($servicios,$idProducto,$emisor){
	$contador=0;
	foreach ($servicios as $key => $value) {
		$splitear = explode("_", $value);
		$id_servicio = $splitear[1];
		/*SP*/
		$usuario = $_SESSION["idU"];
		$query = "CALL `redefectiva`.`sp_insert_inf_productoservicio`($idProducto,$id_servicio,$emisor,$usuario,$contador);";
		$resultado = $GLOBALS['WBD']->query($query);
		$contador++;
		/*SP*/
	}
}

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch ($tipo) {
	case 1:	
		$familia = 	(!empty($_POST["familia"]))? $_POST["familia"] : 0;
		$subfamilia = (!empty($_POST["subfamilia"]))? $_POST["subfamilia"] : 0;
		$emisor = (!empty($_POST["emisor"]))? $_POST["emisor"] : 0;
        $tipo_busqueda = (!empty($_POST["tipo_busqueda"]))? $_POST["tipo_busqueda"] : 0;
        $activo = (!empty($_POST["tipo_estado"]))? $_POST["tipo_estado"] : 0;

		$array_params = array(
			array('name' => 'p_familia', 'value' => $familia, 'type' =>'i'),
			array('name' => 'p_subfamilia', 'value' => $subfamilia, 'type' =>'i'),
			array('name' => 'p_emisor', 'value' => $emisor, 'type' =>'i'),
            array('name' => 'p_tipo_busqueda', 'value' => $tipo_busqueda, 'type' =>'i'),
            array('name' => 'p_activo', 'value' => $activo, 'type' =>'i'),
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
				$datos[$index]["idProducto"] = $data[$i]["idProducto"];
				$datos[$index]["idFamilia"] = $data[$i]["idFamilia"];
				$datos[$index]["idSubFamilia"] = $data[$i]["idSubFamilia"];
				$datos[$index]["idEmisor"] = $data[$i]["idEmisor"];
				$datos[$index]["abrevProducto"] = utf8_encode($data[$i]["abrevProducto"]);
				$datos[$index]["descProducto"] = utf8_encode($data[$i]["descProducto"]);
				$datos[$index]["skuProducto"] = utf8_encode($data[$i]["skuProducto"]);
				$datos[$index]["idFevProducto"] = $data[$i]["idFevProducto"];
                $datos[$index]["idFsvProducto"] = $data[$i]["idFsvProducto"];
                $datos[$index]["EstatusProducto"] = ($data[$i]["idEstatusProducto"] === 0 ? 'Activo' : 'Inactivo');
                $datos[$index]["idEstatusProducto"] = $data[$i]["idEstatusProducto"];
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

	case 2:
		$idProducto = (!empty($_POST["idProducto"]))? $_POST["idProducto"] : 0;
		$array_params = array(
			array('name' => 'IDPROD', 'value' => $idProducto, 'type' =>'i'),
		);
		
        $oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_select_producto');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();
	   	
	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["idProducto"] = $data[$i]["idProducto"];
				$datos[$index]["idFamilia"] = $data[$i]["idFamilia"];
				$datos[$index]["idSubFamilia"] = $data[$i]["idSubFamilia"];
				$datos[$index]["idEmisor"] = $data[$i]["idEmisor"];
				$datos[$index]["abrevProducto"] = utf8_encode($data[$i]["abrevProducto"]);
				$datos[$index]["descProducto"] = utf8_encode($data[$i]["descProducto"]);
				$datos[$index]["skuProducto"] = $data[$i]["skuProducto"];
				$datos[$index]["idFevProducto"] = $data[$i]["idFevProducto"];
				$datos[$index]["idFsvProducto"] = $data[$i]["idFsvProducto"];
				$datos[$index]["idFlujoImporte"] = $data[$i]["idFlujoImporte"];
				$datos[$index]["impMinProducto"] = $data[$i]["impMinProducto"];
				$datos[$index]["impMaxProducto"] = $data[$i]["impMaxProducto"];
				$datos[$index]["perComProducto"] = $data[$i]["perComProducto"];
				$datos[$index]["impComProducto"] = $data[$i]["impComProducto"];
				$datos[$index]["perComCorresponsal"] = $data[$i]["perComCorresponsal"];
				$datos[$index]["impComCorresponsal"] = $data[$i]["impComCorresponsal"];
				$datos[$index]["perComCliente"] = $data[$i]["perComCliente"];
				$datos[$index]["impComCliente"] = $data[$i]["impComCliente"];
				$datos[$index]["idEstatusProducto"] = $data[$i]["idEstatusProducto"];
                $datos[$index]["productoservicio"] = json_decode('['.$data[$i]["productoservicio"].']', true);
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
		
		$lista_servicios = $_POST["lista_servicios"];
		
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

		$porcentajecomisionproducto = $porcentajecomisionproducto/100;
		$porcentajecomisioncorresponsal = $porcentajecomisioncorresponsal/100;
		$porcentajecomisioncliente = $porcentajecomisioncliente/100;

		
		$query = "CALL `redefectiva`.`sp_update_producto`($idProducto,$familia,$subfamilia,$emisor,'$abreviatura','$descripcion','$fechaentradavigor','$fechasalidavigor',$flujoimporte,$importeminimoproducto,$importemaximoproducto,$porcentajecomisionproducto,$importecomisionproducto,$porcentajecomisioncorresponsal,$importecomisioncorresponsal,$porcentajecomisioncliente,$importecomisioncliente,$estatus,$usuario);";

		$resultado = $WBD->query($query);

		if (!($resultado)) {
		    $datos[$index]["ErrorCode"] = "1";
			$datos[$index]["ErrorMsg"] = "Error al Actulizar";
		    print json_encode($datos);
		}else{
			while ($row = mysqli_fetch_assoc($resultado)) { 
				$datos[$index]["ErrorCode"] = $row["ErrorCode"];
				$datos[$index]["ErrorMsg"] = "Actualización exitosa";//utf8_encode($row["ErrorMsg"]);
			}
			guardarServicios($lista_servicios,$idProducto,$emisor);
			print json_encode($datos);
		}
	break;
	case 5:

		$producto = $_POST["producto"];
		$array_params = array(
			array('name' => 'p_idproducto', 'value' => $producto, 'type' =>'i'),
		);

		$oRdb->setSDatabase('redefectiva');
	    $oRdb->setSStoredProcedure('sp_get_inf_productoservicio');
	    $oRdb->setParams($array_params);
	    $result = $oRdb->execute();
	   	
	   	if ( $result['nCodigo'] ==0){
	    	$data = $oRdb->fetchAll();
	    	$datos = array();
	    	$index = 0;
			for($i=0;$i<count($data);$i++){
				$datos[$index]["idTranType"] = $data[$i]["idTranType"];
				$datos[$index]["descEstatus"] = utf8_encode($data[$i]["descTranType"]);
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
    case 6:
        $idProducto = $_POST["idProducto"];
        $estatus = $_POST["estatus"];
        $usuario = $_SESSION["idU"];

        $array_params = array(
            array('name' => 'p_idProducto', 'value' => $idProducto, 'type' => 'i'),
            array('name' => 'p_idEstatusProducto', 'value' => $estatus, 'type' => 'i'),
            array('name' => 'p_idEmpleado', 'value' => $usuario, 'type' => 'i'),
        );
        $oWdb->setSDatabase('redefectiva');
        $oWdb->setSStoredProcedure('sp_update_estatus_producto');
        $oWdb->setParams($array_params);
        $result = $oWdb->execute();
        if($result['nCodigo'] == 0){
            echo json_encode(array(
                "showMessage"	=> 0,
                "msg"			=> "Registro Actualizado."
            ));
        }else{
            echo json_encode(array(
                "showMessage"	=> 1,
                "msg"			=> $result['sMensajeDetallado']
            ));
        }
        $oWdb->closeStmt();
        break;
	default:
		# code...
		break;
}

?>