<?php
include("../../../inc/config.inc.php");
include("../../../inc/session.inc.php");
#error_reporting(E_ALL);
#ini_set('display_errors', 1);
function xml2assoc($xml) {
	$assoc = null;
	while($xml->read()){
		switch ($xml->nodeType) {
			case XMLReader::END_ELEMENT: return $assoc;
			case XMLReader::ELEMENT:
				$assoc[$xml->name] = array('value' => $xml->isEmptyElement ? '' : xml2assoc($xml));
				if($xml->hasAttributes){
					$el =& $assoc[$xml->name][count($assoc[$xml->name]) - 1];
					while($xml->moveToNextAttribute()) $el['attributes'][$xml->name] = utf8_decode($xml->value);
				}
				break;
			case XMLReader::TEXT:
			case XMLReader::CDATA: $assoc .= $xml->value;
		}
	}
	return $assoc;
}

function acentos($txt){
	return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
}

function validarUUID($UUID){
	$formatoUUID = "/^[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}$/";
	if ( preg_match($formatoUUID, $UUID) ) {
		$seccionesUUID = explode("-", $UUID);
		if ( count($seccionesUUID) == 5 ) {
			if ( strlen($seccionesUUID[0]) == 8 && strlen($seccionesUUID[1]) == 4 && strlen($seccionesUUID[2]) == 4
			&& strlen($seccionesUUID[3]) == 4 && strlen($seccionesUUID[4]) == 12 ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

$xml = new XMLReader();
$xml->open($_GET["archivoXML"]);

/*$xml->read();
$nodo = $xml->expand();
$node = $xml->readInnerXML();

#echo $node;
$nodo2 = trim($node);
echo $nodo2 = '<Comprobante>'.$nodo2.'</Comprobante>';
echo '<pre>'; var_dump('--------------'); echo '</pre>';
$xmlEl = new SimpleXmlElement($nodo2);
echo '<pre>'; var_dump($xmlEl); echo '</pre>';*/

$xmls = simplexml_load_file($_GET["archivoXML"]);

$namespaces = $xmls->getNamespaces(true);

$xmls->registerXPathNamespace('cfdi', 'http://www.sat.gob.mx/cfd/3');

$assoc = xml2assoc($xml);
//echo '<pre>'; var_dump($assoc); echo '</pre>';
$xml->close();

/*echo "<pre>";
print_r($assoc);
echo "</pre>";*/

/** cfdiComprobante Arreglos **/
$cfdiComprobante = $assoc["cfdi:Comprobante"]["0"]["attributes"];

/** cfdiComprobante Arreglos **/
/******************************************************************************/
/** cfdiComprobante Variables Disponibles **/
if ( isset($cfdiComprobante["xmlns:cfdi"]) ) {
	$cfdiComprobanteXmlnsCfdi = $cfdiComprobante["xmlns:cfdi"];
}
$cfdiComprobanteXmlnsXsi			= $cfdiComprobante["xmlns:xsi"];
$cfdiComprobanteXsiSchemaLocation	= $cfdiComprobante["xsi:schemaLocation"];
$cfdiComprobanteVersion				= $cfdiComprobante["version"];
$cfdiComprobanteSerie				= $cfdiComprobante["serie"];
$cfdiComprobanteFolio				= $cfdiComprobante["folio"];
$cfdiComprobanteFecha				= $cfdiComprobante["fecha"];
$cfdiComprobanteSello				= $cfdiComprobante["sello"];
$cfdiComprobanteFormaDePago			= $cfdiComprobante["formaDePago"];
$cfdiComprobanteNoCertificado		= $cfdiComprobante["noCertificado"];
$cfdiComprobanteCertificado			= $cfdiComprobante["certificado"];
$cfdiComprobanteSubTotal			= $cfdiComprobante["subTotal"];
if ( isset($cfdiComprobante["TipoCambio"]) ) {
	$cfdiComprobanteTipoCambio = $cfdiComprobante["TipoCambio"];
}
$cfdiComprobanteMoneda = $cfdiComprobante["Moneda"];
$cfdiComprobanteLugarExpedicion = $cfdiComprobante["LugarExpedicion"];
$cfdiComprobanteTotal = $cfdiComprobante["total"];
$cfdiComprobanteMetodoDePago = $cfdiComprobante["metodoDePago"];
$cfdiComprobanteNumCtaPago = $cfdiComprobante["NumCtaPago"];
$cfdiComprobanteTipoDeComprobante = $cfdiComprobante["tipoDeComprobante"];
if ( isset($cfdiComprobante["xmlns:xs"]) ) {
	$cfdiComprobanteXmlnsXs = $cfdiComprobante["xmlns:xs"];
}
if ( isset($cfdiComprobante["xmlns:tfd"]) ) {
	$cfdiComprobanteXmlnsTfd = $cfdiComprobante["xmlns:tfd"];
}

/** cfdiComprobante Variables Disponibles **/
/** cfdiEmisor Arreglos **/
$cfdiEmisorDomicilioFiscal = $assoc["cfdi:Comprobante"]["value"]["cfdi:Emisor"]["value"]["cfdi:DomicilioFiscal"]["0"]["attributes"];
$cfdiEmisorExpedidoEn = $assoc["cfdi:Comprobante"]["value"]["cfdi:Emisor"]["value"]["cfdi:ExpedidoEn"]["0"]["attributes"];
$cfdiEmisorRegimenFiscal = $assoc["cfdi:Comprobante"]["value"]["cfdi:Emisor"]["value"]["cfdi:RegimenFiscal"]["0"]["attributes"];
$cfdiEmisor = $assoc["cfdi:Comprobante"]["value"]["cfdi:Emisor"]["0"]["attributes"];

/** cfdiEmisor Arreglos **/
/******************************************************************************/
/** cfdiEmisor Variables Disponibles **/
$cfdiEmisorDomicilioFiscalCalle = acentos($cfdiEmisorDomicilioFiscal["calle"]);
$cfdiEmisorDomicilioFiscalCodigoPostal = $cfdiEmisorDomicilioFiscal["codigoPostal"];
$cfdiEmisorDomicilioFiscalColonia = acentos($cfdiEmisorDomicilioFiscal["colonia"]);
$cfdiEmisorDomicilioFiscalEstado = acentos($cfdiEmisorDomicilioFiscal["estado"]);
$cfdiEmisorDomicilioFiscalLocalidad = acentos($cfdiEmisorDomicilioFiscal["localidad"]);
$cfdiEmisorDomicilioFiscalMunicipio = acentos($cfdiEmisorDomicilioFiscal["municipio"]);
$cfdiEmisorDomicilioFiscalNoExterior = $cfdiEmisorDomicilioFiscal["noExterior"];
if ( isset($cfdiEmisorDomicilioFiscal["noInterior"]) ) {
	$cfdiEmisorDomicilioFiscalNoInterior = $cfdiEmisorDomicilioFiscal["noInterior"];
}
$cfdiEmisorDomicilioFiscalPais = acentos($cfdiEmisorDomicilioFiscal["pais"]);
if ( isset($cfdiEmisorDomicilioFiscal["referencia"]) ) {
	$cfdiEmisorDomicilioFiscalReferencia = $cfdiEmisorDomicilioFiscal["referencia"];
}
$cfdiEmisorExpedidoEnCalle = $cfdiEmisorExpedidoEn["calle"];
$cfdiEmisorExpedidoEnCodigoPostal = $cfdiEmisorExpedidoEn["codigoPostal"];
$cfdiEmisorExpedidoEnColonia = $cfdiEmisorExpedidoEn["colonia"];
$cfdiEmisorExpedidoEnEstado = $cfdiEmisorExpedidoEn["estado"];
if ( isset($cfdiEmisorExpedidoEn["localidad"]) ) {
	$cfdiEmisorExpedidoEnLocalidad = $cfdiEmisorExpedidoEn["localidad"];
}
if ( isset($cfdiEmisorExpedidoEn["municipio"]) ) {
	$cfdiEmisorExpedidoEnMunicipio = $cfdiEmisorExpedidoEn["municipio"];
}
if ( isset($cfdiEmisorExpedidoEn["noExterior"]) ) {
	$cfdiEmisorExpedidoEnNoExterior = $cfdiEmisorExpedidoEn["noExterior"];
}
$cfdiEmisorExpedidoEnPais = $cfdiEmisorExpedidoEn["pais"];
$cfdiEmisorRegimenFiscalRegimen = $cfdiEmisorRegimenFiscal["Regimen"];
$cfdiEmisorNombre = $cfdiEmisor["nombre"];
$cfdiEmisorRFC = $cfdiEmisor["rfc"];


# buscar tipo el regimen del cliente
$sql		= "CALL redefectiva.SP_CLIENTE_LOAD('$cfdiEmisorRFC')";
$result		= $RBD->SP($sql);
$rowcount	= mysqli_num_rows($result);
$nIdRegimen	= 0;

if($rowcount){
	$row		= mysqli_fetch_assoc($result);
	$nIdRegimen = $row['idRegimen'];
}
/** cfdiEmisor Variables Disponibles **/
/******************************************************************************/
/** cfdiReceptor Arreglos **/
if ( !empty($assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["value"]) ) {
	$cfdiReceptorDomicilio = $assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["value"]["cfdi:Domicilio"]["0"]["attributes"];
}
//$cfdiReceptorDomicilio = $assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["value"]["cfdi:Domicilio"]["0"]["attributes"];
$cfdiReceptor = $assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["0"]["attributes"];

/** cfdiReceptor Arreglos **/
/******************************************************************************/
/** cfdiEmisor Variables Disponibles **/
$cfdiReceptorDomicilioCalle = $cfdiReceptorDomicilio["calle"];
$cfdiReceptorDomicilioCodigoPostal = $cfdiReceptorDomicilio["codigoPostal"];
$cfdiReceptorDomicilioColonia = $cfdiReceptorDomicilio["colonia"];
$cfdiReceptorDomicilioEstado = $cfdiReceptorDomicilio["estado"];
$cfdiReceptorDomicilioLocalidad = $cfdiReceptorDomicilio["localidad"];
if ( isset($cfdiReceptorDomicilio["municipio"]) ) {
	$cfdiReceptorDomicilioMunicipio = $cfdiReceptorDomicilio["municipio"];
}
if ( isset($cfdiReceptorDomicilio["noExterior"]) ) {
	$cfdiReceptorDomicilioNoExterior = $cfdiReceptorDomicilio["noExterior"];
}
if ( isset($cfdiReceptorDomicilio["noInterior"]) ) {
	$cfdiReceptorDomicilioNoInterior = $cfdiReceptorDomicilio["noInterior"];
}
$cfdiReceptorDomicilioPais = $cfdiReceptorDomicilio["pais"];
$cfdiReceptorNombre = $cfdiReceptor["nombre"];
$cfdiReceptorRFC = $cfdiReceptor["rfc"];

/** cfdiEmisor Variables Disponibles **/
/******************************************************************************/
/** cfdiConceptos Arreglos **/
$cfdiConceptos = $assoc["cfdi:Comprobante"]["value"]["cfdi:Conceptos"]["value"]["cfdi:Concepto"]["0"]["attributes"];

/** cfdiConceptos Arreglos **/
/******************************************************************************/
/** cfdiConceptos Variables Disponibles **/
$cfdiConceptosCantidad = $cfdiConceptos["cantidad"];
$cfdiConceptosUnidad = $cfdiConceptos["unidad"];
if ( isset($cfdiConceptos["noIdentificacion"]) ) {
	$cfdiConceptosNoIdentificacion = $cfdiConceptos["noIdentificacion"];
}
$cfdiConceptosDescripcion = $cfdiConceptos["descripcion"];
$cfdiConceptosValorUnitario = $cfdiConceptos["valorUnitario"];
$cfdiConceptosImporte = $cfdiConceptos["importe"];

/** cfdiConceptos Variables Disponibles **/
/******************************************************************************/
/** cfdiImpuestos Arreglos **/
if ( isset($assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["0"]["attributes"]) ) {
	$cfdiImpuestos = $assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["0"]["attributes"];
}

/** cfdiImpuestos Arreglos **/
/******************************************************************************/
/** cfdiImpuestosTraslados Variables Disponibles **/
if ( isset($cfdiImpuestos) ) {
	$cfdiImpuestosTotalImpuestosTrasladados = $cfdiImpuestos["totalImpuestosTrasladados"];
}

/** cfdiImpuestosTraslados Variables Disponibles **/
/******************************************************************************/
/** cfdiImpuestosTraslados Arreglos **/
#echo '<pre>'; var_dump($assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["value"]); echo '</pre>';
$cfdiImpuestosTraslados		= $assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["value"]["cfdi:Traslados"]["value"]["cfdi:Traslado"]["0"]["attributes"];
#echo '<pre>'; var_dump($cfdiImpuestosTraslados); echo '</pre>';

#if($nIdRegimen == 1){
#	$cfdiImpuestosRetenciones	= $assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["value"]["cfdi:Retenciones"]["value"]["cfdi:Retencion"]["0"]["attributes"];
#}

/** cfdiImpuestosTraslados Arreglos **/
/******************************************************************************/
/** cfdiImpuestosTraslados Variables Disponibles **/
$cfdiImpuestosTrasladosImpuesto = $cfdiImpuestosTraslados["impuesto"];
$cfdiImpuestosTrasladosTasa = $cfdiImpuestosTraslados["tasa"];
$cfdiImpuestosTrasladosImporte = $cfdiImpuestosTraslados["importe"];

$nodosTraslados = $xmls->xpath('//cfdi:Traslados/cfdi:Traslado');

foreach($nodosTraslados as $tagTraslado){
	$esTraslado = false;
	$arrTag = array();
	foreach ($tagTraslado->attributes() as $attrName => $xmlValue){
		if($attrName == "importe" && $esTraslado == true){
			$traslado = $xmlValue->__toString();
			$esTraslado == false;
		}

		if($attrName == "impuesto" && $xmlValue->__toString() == "IVA"){
			$esTraslado = true;
		}

		$arrTag[$attrName] = $xmlValue->__toString();
	}

	if($arrTag['impuesto'] == 'IVA'){
		$traslado = $arrTag['importe'];
	}
}

$cfdiImpuestosTrasladosImporte = $traslado;
#echo '<pre>'; var_dump($cfdiImpuestosTrasladosImporte); echo '</pre>';


if($nIdRegimen == 1){
	$nodosRetenciones	= $xmls->xpath('//cfdi:Retenciones/cfdi:Retencion');
	foreach($nodosRetenciones as $tagRetencion){
		$esRetencion = false;
		$arrTag = array();
		foreach ($tagRetencion->attributes() as $attrName => $xmlValue){
			if($attrName == "importe" && $esRetencion == true){
				$retencion = $xmlValue->__toString();
				$esRetencion == false;
			}

			if($attrName == "impuesto" && $xmlValue->__toString() == "IVA"){
				$esRetencion = true;
			}

			$arrTag[$attrName] = $xmlValue->__toString();
		}

		if($arrTag['impuesto'] == 'IVA'){
			$retencion = $arrTag['importe'];
		}

	}
	$cfdiImpuestosRetencionesRetencion = $retencion;
}
else{
	$cfdiImpuestosRetencionesRetencion = 0;
}
/** cfdiImpuestosTraslados Variables Disponibles **/
/******************************************************************************/
/** cfdiComplemento Arreglos **/
$cfdiComplemento = $assoc["cfdi:Comprobante"]["value"]["cfdi:Complemento"]["value"]["tfd:TimbreFiscalDigital"]["0"]["attributes"];

/** cfdiComplemento Arreglos **/
/******************************************************************************/
/** cfdiComplemento Variables Disponibles **/
$cfdiComplementoFechaTimbrado = $cfdiComplemento["FechaTimbrado"];
$cfdiComplementoUUID = $cfdiComplemento["UUID"];
$cfdiComplementoNoCertificadoSAT = $cfdiComplemento["noCertificadoSAT"];
$cfdiComplementoSelloCFD = $cfdiComplemento["selloCFD"];
$cfdiComplementoSelloSAT = $cfdiComplemento["selloSAT"];
$cfdiComplementoVersion = $cfdiComplemento["version"];
$cfdiComplementoXsiSchemaLocation = $cfdiComplemento["xsi:schemaLocation"];

/** cfdiComplemento Variables Disponibles **/
/******************************************************************************/
/** cfdiAddenda Arreglos **/
// ADDENDAS DEPENDEN DE CADA PROVEEDOR //
/** cfdiAddenda Arreglos **/
/******************************************************************************/

/******************************************************************************/
/** Pago a proveedores **/
/** No mover orden de la concatenacion, agregar variables para abajo **/

$return = "";

$sql = "CALL redefectiva.SP_CLIENTE_LOAD('$cfdiEmisorRFC')";
$result = $RBD->SP($sql);
$rowcount = mysqli_num_rows($result);

$array = array();
$data = array();

if ( $rowcount ) {
	if ( validarUUID($cfdiComplementoUUID) ) {
		$row = mysqli_fetch_assoc($result);
		$noFactura = "$cfdiComprobanteSerie$cfdiComprobanteFolio";
		$emisorRFC = $cfdiEmisorRFC;
		if ( empty($cfdiComprobanteSerie) || empty($cfdiComprobanteFolio) ) {
			$noFactura = -1;
		}
		if ( empty($emisorRFC) ) {
			$emisorRFC = -1;
		}
		$sql = "CALL redefectiva.SP_LOAD_FACTURA('1', '$noFactura', '$emisorRFC', '$cfdiComplementoUUID')";
		$result2 = $RBD->SP($sql);
		$rowcount2 = mysqli_num_rows($result2);
		if ($rowcount2) {
			$array['showMsg']   = 1;
			$array['success']	= false;
			$array['errmsg']    = '2; Si existe cliente y la factura ya esta capturada';
			//$array['msg']	    = 'La factura '.$cfdiComprobanteSerie.$cfdiComprobanteFolio.' ya existe en la Base de Datos por lo tanto no es posible darla de alta';
			$array['msg']		= 'La factura con UUID '.$cfdiComplementoUUID.' ya existe en la Base de Datos por lo tanto no es posible darla de alta';
		} else {
			$array['showMsg']   = 0;
			$array['success']	= true;
			$array['errmsg']    = '1; Si existe cliente = '.$rowcount;
			$array['msg']		= '1; Si existe cliente = '.$rowcount;
		}
		$data['txtNumCta']		= $row['numCuenta'];
		$data['idCadena']		= $row['idCadena'];
		$data['idSubCadena']	= $row['idSubCadena'];
		$data['idCorresponsal'] = $row['idCorresponsal'];
		$data['txtRazonSocial'] = $row['razonSocial'];
	} else {
		$array['showMsg']  	= 2;
		$array['success']	= false;
		$array['errmsg']	= '2; El UUID no tiene un formato correcto.';
		$array['msg']		= 'El UUID no tiene un formato correcto.';
	}
} else {
	$array['showMsg']  	= 1;
	$array['success']	= false;
	$array['errmsg']	= '2; '.$cfdiEmisorNombre.' no esta dado de alta en nuestra Base de Datos';
	$array['msg']		= $cfdiEmisorNombre.' no esta dado de alta en nuestra Base de Datos';
}

$data['txtFileToUploadTmp'] =  addslashes($_GET["archivoXML"]); // Archivo temporal, guardar en hidden
$data['txtRFC']				= $cfdiEmisorRFC;
$data['txtCalle']			= $cfdiEmisorDomicilioFiscalCalle;
$data['txtNoExterior']		= $cfdiEmisorDomicilioFiscalNoExterior;
$data['txtNoInterior']		= $cfdiEmisorDomicilioFiscalNoInterior;
$data['txtColonia']			= $cfdiEmisorDomicilioFiscalColonia;
$data['txtMunicipio']		= $cfdiEmisorDomicilioFiscalMunicipio;
$data['txtEstado']			= $cfdiEmisorDomicilioFiscalEstado;
$data['txtCodigoPostal']	= $cfdiEmisorDomicilioFiscalCodigoPostal;
$data['txtPais']			= $cfdiEmisorDomicilioFiscalPais;
$data['txtSerie']			= $cfdiComprobanteSerie;
$data['txtFolio']			= $cfdiComprobanteFolio;
$data['txtFechaFactura']	= $cfdiComprobanteFecha;
$data['txtNumFactura']		= $cfdiComprobanteSerie.$cfdiComprobanteFolio;
$data['txtMoneda']			= $cfdiComprobanteMoneda;
$data['txtTipoCambio']		= $cfdiComprobanteTipoCambio;
$data['txtSubtotal']		= "\$".number_format($cfdiComprobanteSubTotal, 2);
$data['txtUUID']			= $cfdiComplementoUUID;

//$return .= "$cfdiEmisorNombre|";
if ( !$cfdiImpuestosTotalImpuestosTrasladados ) {
	if($nIdRegimen == 1){
		$cfdiImpuestosTrasladosImporte = $cfdiImpuestosTrasladosImporte - $cfdiImpuestosRetencionesRetencion;
		#echo '<pre>'; var_dump($cfdiImpuestosTrasladosImporte); echo '</pre>';
		#echo '<pre>'; var_dump($cfdiImpuestosRetencionesRetencion); echo '</pre>';
	}
	$data['txtIVA'] = "\$".number_format($cfdiImpuestosTrasladosImporte, 2);
} else {
	if($nIdRegimen == 1){
		#echo '<pre>'; var_dump($cfdiImpuestosTotalImpuestosTrasladados); echo '</pre>';
		$cfdiImpuestosTotalImpuestosTrasladados = $cfdiImpuestosTotalImpuestosTrasladados - $cfdiImpuestosRetencionesRetencion;
		#echo '<pre>'; var_dump($cfdiImpuestosTotalImpuestosTrasladados); echo '</pre>';
		#echo '<pre>'; var_dump($cfdiImpuestosRetencionesRetencion); echo '</pre>';
		#echo '<pre>'; var_dump($cfdiImpuestosRetencionesRetencion); echo '</pre>';
	}
	$data['txtIVA'] = "\$".number_format($cfdiImpuestosTotalImpuestosTrasladados, 2);
}
$data['txtTotal'] = "\$".number_format($cfdiComprobanteTotal, 2);

$array['data']	= $data;

return $array;

?>


