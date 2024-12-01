<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include($_SERVER['DOCUMENT_ROOT'].'/inc/PHPExcel/Classes/PHPExcel.php');

/*
case 1  
case 2  
case 3  inserta la ruta
case 4 	
case 5 	selecciona la informacion por ruta
case 6 	actualiza la ruta
*/

$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

function guardarRelacionProductos($idProveedor,$productos){
	foreach ($productos as &$valor) {
		    $partes = explode(",", $valor);
		   	$id=$partes[0];
		   	$familia = $partes[1];
		   	$subfamilia= $partes[2];
		   	$producto = $partes[3];
		   	$importe = $partes[4];
		   	$descuento = $partes[5];
		   	$importesindescuento = $partes[6];
		   	$importesiniva = $partes[7];
		   	$importesinivaLimpio = substr($importesiniva,0, -1);
			$query = "CALL `redefectiva`.`sp_insert_proveedor_producto`($idProveedor,$producto,$importe,$descuento,$importesindescuento,$importesinivaLimpio);";
		    $resultado = $GLOBALS['WBD']->query($query);
		}

	return;
}

function obtenerFamSubFamProdExcel($familia,$subfamilia,$producto){

	$query = "CALL `redefectiva`.`sp_select_fam_sub_prod`($familia,$subfamilia,$producto);";
		$sql = $GLOBALS['RBD']->query($query);
		$datos = array();
		while ($row = mysqli_fetch_assoc($sql)) {
			$datos["descFamilia"] = utf8_encode($row["descFamilia"]);
			$datos["descSubFamilia"] = utf8_encode($row["descSubFamilia"]);
			$datos["descProducto"] = utf8_encode($row["descProducto"]);
		}
		return $datos;

}

switch ($tipo) {
	case 1:
		$idProveedor = $_POST["idProveedor"];
		$query = "CALL `redefectiva`.`sp_select_proveedor_producto`($idProveedor);";
		$sql = $RBD->query($query);
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($sql)) {
			$datos[$index]["nIdProveedor"] = $row["nIdProveedor"];
			$datos[$index]["nIdProducto"] = $row["nIdProducto"];
			$datos[$index]["descProducto"] = utf8_encode($row["descProducto"]);
			$datos[$index]["importe"] = utf8_encode($row["importe"]);
			$datos[$index]["descuento"] = utf8_encode($row["descuento"]);
			$datos[$index]["importeSinDescuento"] = utf8_encode($row["importeSinDescuento"]);
			$datos[$index]["importeSinIva"] = utf8_encode($row["importeSinIva"]);
			$datos[$index]["idfamilia"] = utf8_encode($row["idfamilia"]);
			$datos[$index]["descFamilia"] = utf8_encode($row["descFamilia"]);
			$datos[$index]["idsubfamilia"] = utf8_encode($row["idsubfamilia"]);
			$datos[$index]["descSubFamilia"] = utf8_encode($row["descSubFamilia"]);
			$datos[$index]["nPorcentaje"] = utf8_encode($row["nPorcentaje"]);
			$index++;
		}
		print json_encode($datos);
		break;
	
	case 2:
		$idFamilia = (!empty($_POST["idFamilia"]))? $_POST["idFamilia"] : 0;
		$query = "CALL `redefectiva`.`SP_GET_SUBFAMILIAS`($idFamilia);";
		$sql = $RBD->query($query);
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($sql)) {
			$datos[$index]["idSubFamilia"] = $row["idSubFamilia"];
			$datos[$index]["descSubFamilia"] = utf8_encode($row["descSubFamilia"]);
			$index++;
		}
		print json_encode($datos);
		break;
	
	case 3 :

		$select_productos = $_POST["select_productos"];
		$select_conector = $_POST["select_conector"];
		$idProveedor = $_POST["idProveedor"];
		$nombreProveedor = $_POST["nombreProveedor"];
		$skuProveedor = $_POST["skuProveedor"];
		$descripcionRuta = $_POST["descripcionRuta"];
		$fecha_entrada_vigor = $_POST["fecha_entrada_vigor"];
		$fecha_salida_vigor = $_POST["fecha_salida_vigor"];
		$partes = explode('-',$fecha_salida_vigor);
		$anio = $partes[0];
		$mes  = $partes[1];
		$dia  = $partes[2];
		$anio = $anio+20;

		$fecha_salida_vigor = $anio."-".$mes."-".$dia;
		
		$importe_minimo_ruta 				= $_POST["importe_minimo_ruta"];
		$importe_maximo_ruta 				= $_POST["importe_maximo_ruta"];
		$porcentaje_costo_ruta 				= $_POST["porcentaje_costo_ruta"];
		$importe_costo_ruta 				= $_POST["importe_costo_ruta"];
		$porcentaje_comision_producto 		= $_POST["porcentaje_comision_producto"];
		$importe_comision_producto 			= $_POST["importe_comision_producto"];
		$porcentaje_comision_corresponsal 	= $_POST["porcentaje_comision_corresponsal"];
		$importe_comision_corresponsal 		= $_POST["importe_comision_corresponsal"];
		$porcentaje_comision_cliente 		= $_POST["porcentaje_comision_cliente"];
		$importe_comision_cliente 			= $_POST["importe_comision_cliente"];
		$importe_cxc 						= $_POST["importe_cxc"];
		$importe_cxp 						= $_POST["importe_cxp"];
        $porcentaje_pago_producto           = $_POST["porcentaje_pago_producto"];
        $importe_pago_producto              = $_POST["importe_pago_producto"];
		$porcentaje_margen_red 				= $_POST['porcentaje_margen_red'];
		$importe_margen_red 				= $_POST['importe_margen_red'];

		if(empty($importe_minimo_ruta)){
			$importe_minimo_ruta =0;
		}
		if(empty($importe_maximo_ruta)){
			$importe_maximo_ruta =0;
		}

		if(empty($porcentaje_costo_ruta)){
			$porcentaje_costo_ruta =0;
		}else{
			$porcentaje_costo_ruta = $porcentaje_costo_ruta/100;
		}
		if(empty($importe_costo_ruta)){
			$importe_costo_ruta =0;
		}


		if(empty($porcentaje_comision_producto)){
			$porcentaje_comision_producto =0;
		}else{
			$porcentaje_comision_producto = $porcentaje_comision_producto/100;
		}
		if(empty($importe_comision_producto)){
			$importe_comision_producto =0;
		}


		if(empty($porcentaje_comision_corresponsal)){
			$porcentaje_comision_corresponsal =0;
		}else{
			$porcentaje_comision_corresponsal = $porcentaje_comision_corresponsal/100;
		}
		if(empty($importe_comision_corresponsal)){
			$importe_comision_corresponsal =0;
		}


		if(empty($porcentaje_comision_cliente)){
			$porcentaje_comision_cliente =0;
		}else{
			$porcentaje_comision_cliente = $porcentaje_comision_cliente/100;
		}
		if(empty($importe_comision_cliente)){
			$importe_comision_cliente =0;
		}

		if(empty($importe_cxc)){
			$importe_cxc =0;
		}
		if(empty($importe_cxp)){
			$importe_cxp =0;
		}

        if(empty($porcentaje_pago_producto)){
            $porcentaje_pago_producto =0;
        }else{
            $porcentaje_pago_producto = $porcentaje_pago_producto/100;
        }
        if(empty($importe_pago_producto)){
            $importe_pago_producto =0;
        }

		if (empty($porcentaje_margen_red)) {
			$porcentaje_margen_red = 0;
		} else {
			$porcentaje_margen_red = $porcentaje_margen_red/100;
		}

		if (empty($importe_margen_red)) {
			$importe_margen_red = 0;
		}

		$usuario = $_SESSION["idU"];

        $query = "CALL `redefectiva`.`sp_insert_proveedor_producto`($select_productos,
				$select_conector,
				$idProveedor,
				'$skuProveedor',
				'$descripcionRuta',
				'$fecha_entrada_vigor',
				'$fecha_salida_vigor',
				$importe_minimo_ruta,
				$importe_maximo_ruta,
				$porcentaje_costo_ruta,
				$importe_costo_ruta,
				$porcentaje_comision_producto,
				$importe_comision_producto,
				$porcentaje_comision_corresponsal,
				$importe_comision_corresponsal,
				$porcentaje_comision_cliente,
				$importe_comision_cliente,
				'$usuario',
				$importe_cxp,
				$importe_cxc,
				$porcentaje_pago_producto,
				$importe_pago_producto,
				$porcentaje_margen_red,
				$importe_margen_red
				);";

		$resultado = $WBD->query($query);
		//$contador++;
		
		$row = mysqli_fetch_assoc($resultado);
		$code = $row["ErrorCode"];
		$msg = $row["ErrorMsg"];
		
		
		echo json_encode(array(
			"showMessage"	=> $code,
			"msg"			=> $msg
		));

		break;
	
	case 4://saca la informacion del excel
		if($_FILES['sFile']){
    		$name = $_FILES['sFile']['name'];
    		$tmp = $_FILES['sFile']['tmp_name'];
    	}
		$archivo = $tmp;
		$inputFileType = PHPExcel_IOFactory::identify($archivo);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($archivo);
		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		$datos = array();
		$contadorErrores=0;
		$contadorCorrectos=0;
		for ($row = 2; $row <= $highestRow; $row++) { 
			$array = array();
			$idFamilia =$sheet->getCell("A".$row)->getValue();
			$idSubFamilia = $sheet->getCell("B".$row)->getValue();
			$idProducto= $sheet->getCell("C".$row)->getValue(); 
			$importe = $sheet->getCell("D".$row)->getValue(); 
			$descuento = $sheet->getCell("E".$row)->getValue();
			$importeSinDescuento = $sheet->getCell("F".$row)->getValue(); 
			$imprteSinIVA = $sheet->getCell("G".$row)->getValue();	

			if(is_null($idFamilia) ||is_null($idSubFamilia) || is_null($idProducto)){
			}else{
				$resultado = obtenerFamSubFamProdExcel($idFamilia,$idSubFamilia,$idProducto);
				if(is_null($resultado['descFamilia']) || is_null($resultado['descSubFamilia']) || is_null($resultado['descProducto']) || is_null($importe) || is_null($descuento) ||is_null($importeSinDescuento) || is_null($imprteSinIVA)){
					$contadorErrores++;
				}else{
					$array["idFamilia"] = $idFamilia;
					$array["idSubFamilia"] = $idSubFamilia;
					$array["idProducto"] = $idProducto;
					$array["importe"] = $importe;
					$array["descuento"] = $descuento;
					$array["importeSinDescuento"] = $importeSinDescuento;
					$array["imprteSinIVA"] = $imprteSinIVA;
					$array["descFamilia"] = $resultado['descFamilia'];
					$array["descSubFamilia"] = $resultado['descSubFamilia'];
					$array["descProducto"] = $resultado['descProducto'];
					$contadorCorrectos++;
					$array["correctos"] = $contadorCorrectos;
					$array["errores"] = $contadorErrores;
					$datos[] = $array;
				}
			}


		}

	    echo json_encode($datos);
		break;
	
	case 5:
		$ruta = $_POST["ruta"];
		$idProveedor = $_POST["idProveedor"];

		$query = "CALL `redefectiva`.`sp_get_info_rutaprov`($idProveedor,$ruta);";


	    $sql = $RBD->query($query);
		$datos = array();
		$index = 0;
		while ($row = mysqli_fetch_assoc($sql)) {
			$datos[$index]["abrevProducto"] = utf8_encode($row["abrevProducto"]);
            $datos[$index]["descProducto"] = $row["descProducto"];
			$datos[$index]["idRuta"] = utf8_encode($row["idRuta"]);
			$datos[$index]["descRuta"] = utf8_encode($row["descRuta"]);
			$datos[$index]["idProducto"] = utf8_encode($row["idProducto"]);
			$datos[$index]["idProveedor"] = utf8_encode($row["idProveedor"]);
			$datos[$index]["idConector"] = utf8_encode($row["idConector"]);
			$datos[$index]["skuProveedor"] = utf8_encode($row["skuProveedor"]);
			$datos[$index]["impMaxRuta"] = utf8_encode($row["impMaxRuta"])*1;
			$datos[$index]["impMinRuta"] = utf8_encode($row["impMinRuta"])*1;
			$datos[$index]["idFevRuta"] = utf8_encode($row["idFevRuta"]);
			$datos[$index]["idFsvRuta"] = utf8_encode($row["idFsvRuta"]);
			$datos[$index]["perCostoRuta"] = utf8_encode($row["perCostoRuta"])*1;
			$datos[$index]["impCostoRuta"] = utf8_encode($row["impCostoRuta"])*1;
			$datos[$index]["perComisionProducto"] = utf8_encode($row["perComisionProducto"])*1;
			$datos[$index]["impComisionProducto"] = utf8_encode($row["impComisionProducto"])*1;
			$datos[$index]["perComCliente"] = utf8_encode($row["perComCliente"])*1;
			$datos[$index]["impComCliente"] = utf8_encode($row["impComCliente"])*1;
			$datos[$index]["perComCorresponsal"] = utf8_encode($row["perComCorresponsal"])*1;
			$datos[$index]["impComCorresponsal"] = utf8_encode($row["impComCorresponsal"])*1;
			$datos[$index]["nPerPagoProveedor"] = utf8_encode($row["nPerPagoProveedor"])*1;
			$datos[$index]["nImpPagoProveedor"] = utf8_encode($row["nImpPagoProveedor"])*1;
			$datos[$index]["nPerMargen"] = utf8_encode($row["nPerMargen"])*1;
			$datos[$index]["nImpMargen"] = utf8_encode($row["nImpMargen"])*1;
			$index++;
		}
		print json_encode($datos);
		break;
	
	case 6 :
		$select_productos = $_POST["select_productos"];
		$select_conector = $_POST["select_conector"];
		$idProveedor = $_POST["idProveedor"];
		$nombreProveedor = $_POST["nombreProveedor"];
		$skuProveedor = $_POST["skuProveedor"];
		$descripcionRuta = $_POST["descripcionRuta"];
		$fecha_entrada_vigor = $_POST["fecha_entrada_vigor"];
		$fecha_salida_vigor = $_POST["fecha_salida_vigor"];
		$partes = explode('-',$fecha_entrada_vigor);
		$anio = $partes[0];
		$mes  = $partes[1];
		$dia  = $partes[2];
		$anio = $anio+50;

		$fecha_salida_vigor = $anio."-".$mes."-".$dia;

		$importe_minimo_ruta = $_POST["importe_minimo_ruta"];
		$importe_maximo_ruta = $_POST["importe_maximo_ruta"];
		$porcentaje_costo_ruta = $_POST["porcentaje_costo_ruta"];
		$importe_costo_ruta = $_POST["importe_costo_ruta"];
		$porcentaje_comision_producto = $_POST["porcentaje_comision_producto"];
		$importe_comision_producto = $_POST["importe_comision_producto"];
		$porcentaje_comision_corresponsal = $_POST["porcentaje_comision_corresponsal"];
		$importe_comision_corresponsal = $_POST["importe_comision_corresponsal"];
		$porcentaje_comision_cliente = $_POST["porcentaje_comision_cliente"];
		$importe_comision_cliente = $_POST["importe_comision_cliente"];
		$importe_cxp = $_POST["importe_cxp"];
		$importe_cxc = $_POST["importe_cxc"];
        $porcentaje_pago_producto = $_POST["porcentaje_pago_producto"];
        $importe_pago_producto = $_POST["importe_pago_producto"];
		$porcentaje_margen_red = $_POST["porcentaje_margen_red"];
        $importe_margen_red = $_POST["importe_margen_red"];

		if(empty($importe_minimo_ruta)){
			$importe_minimo_ruta =0;
		}
		if(empty($importe_maximo_ruta)){
			$importe_maximo_ruta =0;
		}

		if(empty($porcentaje_costo_ruta)){
			$porcentaje_costo_ruta =0;
		}else{
			$porcentaje_costo_ruta = $porcentaje_costo_ruta/100;
		}
		if(empty($importe_costo_ruta)){
			$importe_costo_ruta =0;
		}


		if(empty($porcentaje_comision_producto)){
			$porcentaje_comision_producto =0;
		}else{
			$porcentaje_comision_producto = $porcentaje_comision_producto/100;
		}
		if(empty($importe_comision_producto)){
			$importe_comision_producto =0;
		}


		if(empty($porcentaje_comision_corresponsal)){
			$porcentaje_comision_corresponsal =0;
		}else{
			$porcentaje_comision_corresponsal = $porcentaje_comision_corresponsal/100;
		}
		if(empty($importe_comision_corresponsal)){
			$importe_comision_corresponsal =0;
		}


		if(empty($porcentaje_comision_cliente)){
			$porcentaje_comision_cliente =0;
		}else{
			$porcentaje_comision_cliente = $porcentaje_comision_cliente/100;
		}
		if(empty($importe_comision_cliente)){
			$importe_comision_cliente =0;
		}

        if(empty($porcentaje_pago_producto)){
            $porcentaje_pago_producto =0;
        }else{
            $porcentaje_pago_producto = $porcentaje_pago_producto/100;
        }
        if(empty($importe_pago_producto)){
            $importe_pago_producto =0;
        }

		if (empty($porcentaje_margen_red)) {
			$porcentaje_margen_red = 0;
		} else {
			$porcentaje_margen_red = $porcentaje_margen_red/100;
		}
		if (empty($importe_margen_red)) {
			$importe_margen_red = 0;
		}
		
		$usuario = $_SESSION["idU"];
		$ruta = $_POST["ruta"];
		   
		$query = "CALL `redefectiva`.`sp_update_proveedor_producto`($select_productos,
				$select_conector,
				$idProveedor,
				'$skuProveedor',
				'$descripcionRuta',
				'$fecha_entrada_vigor',
				'$fecha_salida_vigor',
				$importe_minimo_ruta,
				$importe_maximo_ruta,
				$porcentaje_costo_ruta,
				$importe_costo_ruta,
				$porcentaje_comision_producto,
				$importe_comision_producto,
				$porcentaje_comision_corresponsal,
				$importe_comision_corresponsal,
				$porcentaje_comision_cliente,
				$importe_comision_cliente,
				'$usuario',
				$ruta,
				$importe_cxp,
				$importe_cxc,
				$porcentaje_pago_producto,
				$importe_pago_producto,
				$porcentaje_margen_red,
				$importe_margen_red
			);";
        
        $resultado = $WBD->query($query);
        $contador++;
		while ($row = mysqli_fetch_assoc($resultado)) { 
				$datos["code"] = $row["ErrorCode"];
				$datos["msg"] = $row["ErrorMsg"];
		}

		if(is_array($datos)){
			if($datos["code"]== 0){
	            echo json_encode(array(
	                "showMessage"    => 0,
	                "msg"            => "Operación Exitosa"
	            ));
	        }else{
	            echo json_encode(array(
	                "showMessage"    => 1,
	                "msg"            => "Fallo Operación"
	            ));
	        }
		}else{
			echo json_encode(array(
                "showMessage"    => 1,
                "msg"            => "Fallo Operación"
            ));
		}

		break;

	default:
		# code...
		break;
}

?>