<?php
/*error_reporting(1);
ini_set('display_errors', 1);*/

$pemiso	= (isset($_POST['pemiso']))?$_POST['pemiso']: false; /*if($pemiso){*/

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

global $WBD;

function mueveFacturaXML($archivoXML, $fechaFactura, $rfc, $noFactura){
	$nuevaRuta = "D:/Server/wwwroot/https/facturasXML";
	$arrFecha = explode('-', $fechaFactura);
	$año = $arrFecha[0];    
	$mes = $arrFecha[1];    
	$dia = $arrFecha[2];    
	$fileName = substr(strrchr($archivoXML, "\\"), 1);
	$renFile = $rfc . $noFactura . ".xml";
	if(!file_exists("$nuevaRuta/$año")) 
		mkdir("$nuevaRuta/$año");
	if(!file_exists("$nuevaRuta/$año/$mes"))
		mkdir("$nuevaRuta/$año/$mes");
	if(!file_exists("$nuevaRuta/$año/$mes/$dia"))
		mkdir("$nuevaRuta/$año/$mes/$dia");
	$nvoArchivoXML = "$nuevaRuta/$año/$mes/$dia/$renFile";

	copy($archivoXML,$nvoArchivoXML);
	rename($archivoXML,$nvoArchivoXML);
	return $nvoArchivoXML;
}

$idFactura			= (!empty($_POST['idFactura']))? $_POST['idFactura'] : 0;
$idEstatus			= 1; // Pago Pendiente
$idEmpleado         = $_SESSION['idU'];
$origenDocumento	= $_POST["txtOrigenDcto"]; // Proveedores
$tipoDocumento		= $_POST["txtTipoDcto"];
$tipoAlta			= $_POST["txtAlta"];
$rfc				= urldecode($_POST["txtRFC"]);
$numeroCuenta		= $_POST["txtNumCta"];
$fechaFactura		= urldecode($_POST["txtFechaFactura"]);
/*$fechaInicio		= urldecode($_POST["txtFechaIni"]);
$fechaFin			= urldecode($_POST["txtFechaFin"]);*/
$noFactura			= urldecode($_POST["txtNumFactura"]);
$subtotal			= toInt($_POST["txtSubtotal"]);
$iva				= toInt($_POST["txtIVA"]);
$total				= toInt($_POST["txtTotal"]);
$detalle			= urldecode($_POST["txtDetalle"]);
$razonSocial		= urldecode($_POST["txtRazonSocial"]);
$archivoXML			= $_POST["txtFileToUploadTmp"];

$calle				= (!empty($_POST["txtCalle"]))? urldecode(utf8_decode($_POST["txtCalle"])) : '';
$noExterior			= (!empty($_POST["txtNoExterior"]))? urldecode($_POST["txtNoExterior"]) : '';
$noInterior			= (!empty($_POST["txtNoInterior"]))? urldecode($_POST["txtNoInterior"]) : '';
$colonia			= (!empty($_POST["txtColonia"]))? urldecode(utf8_decode($_POST["txtColonia"])) : '';
$municipio			= (!empty($_POST["txtMunicipio"]))? urldecode(utf8_decode($_POST["txtMunicipio"])) : '';
$estado				= (!empty($_POST["txtEstado"]))? urldecode(utf8_decode($_POST["txtEstado"])) : '';
$codigoPostal		= (!empty($_POST["txtCodigoPostal"]))? $_POST["txtCodigoPostal"] : 0;
$pais				= (!empty($_POST["txtPais"]))? urldecode(utf8_decode($_POST["txtPais"])) : '';

$serie				= (!empty($_POST["txtSerie"]))? $_POST["txtSerie"] : '';
$folio				= (!empty($_POST["txtFolio"]))? $_POST["txtFolio"] : '';
$moneda				= (!empty($_POST["txtMoneda"]))? $_POST["txtMoneda"] : 'MXN';
$tipoCambio			= (!empty($_POST["txtTipoCambio"]))?  str_replace(array("\$", ","), array("", ""), $_POST["txtTipoCambio"]) :  1;
$descripcion		= ""; // Verificar con Frank
$UUID				= (!empty($_POST["txtUUID"]))? $_POST["txtUUID"] : '';
$UUID = strtoupper($UUID);

$razonSocial = utf8_decode($razonSocial);

$archivoXML = $_FILES['fileToUpload']['tmp_name'];
if($archivoXML){
	$nvoArchivoXML = mueveFacturaXML($archivoXML,$fechaFactura,$rfc,$noFactura);
}
else{
	$nvoArchivoXML = "";
}

if($idFactura == 0){

	// validar si el origen del documento es diferente de corresponsales o grupos
	if($origenDocumento < 3){
		$idTipoProveedor = (!empty($_POST['txtIdTipoProveedor']))? $_POST['txtIdTipoProveedor'] : 0;

		if($idTipoProveedor == 0){
			$origenDocumento = 1;  // Proveedor interno
		}
		if($idTipoProveedor == 1){
			$origenDocumento = 2; // Proveedor Externo
		}
	}
	$reg = "registrada";
	$sql = "CALL data_contable.SP_FACTURAS_ALTA('$idEstatus','$idEmpleado'," 
			. "'$origenDocumento','$tipoDocumento','$tipoAlta','$rfc',"
			. "'$numeroCuenta','$fechaFactura',NULL,NULL,"
			. "'$noFactura','$subtotal','$iva','$total',"
			. "'$detalle','$razonSocial','$nvoArchivoXML','$calle',"
			. "'$noExterior','$noInterior','$colonia','$municipio',"
			. "'$estado','$codigoPostal','$pais','$serie',"
			. "'$folio','$moneda','$tipoCambio','$descripcion', '$UUID')";
}
else{
	$reg = "modificada";
	$sql = "CALL `data_contable`.`SP_FACTURAS_UPDATE`($idFactura, $idEmpleado, '$rfc', '$numeroCuenta', '$fechaFactura', NULL, NULL,
			'$noFactura', '$subtotal', '$iva', '$total', '$detalle', '$razonSocial', '$calle', '$noExterior', '$noInterior', '$colonia', '$municipio',
			'$estado', '$codigoPostal', '$pais', '$serie', '$folio', '$moneda', '$tipoCambio', '$descripcion', $tipoDocumento, '$UUID')";
}

$result = $WBD->SP($sql);

if($WBD->error() == '') {
	if(mysqli_num_rows($result) > 0){
		while($row= mysqli_fetch_assoc($result)) {
			if($row["CodigoRespuesta"] == 0 && $row["DescRespuesta"] == "OK") {
				if($tipoDocumento == 1)
					$RES = "0|La factura #$noFactura de $razonSocial fue ".$reg." exitosamente.|".$row["idFactura"];
				else
					$RES = "0|La remision #$noFactura de $razonSocial fue ".$reg." exitosamente.|".$row["idFactura"];
			}
			else {
				if(!$RES) $RES = "1|";
				$RES .= "\n--------------";
				$RES .= "\nParametro: " . $row["_param"];
				$RES .= "\nMensaje: " . $row["_msgError"];
			}
		}
	} else { $RES .= '2|No se Encontraron datos del Proveedor';}	
} else { $RES .= '3|'.$WBD->error();}	

exit($RES);
?>