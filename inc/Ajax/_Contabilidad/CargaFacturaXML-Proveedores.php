<?php
include("../../../inc/config.inc.php");
include("../../../inc/session.inc.php");

/**
 * Retorna un arreglo asociativo de un archivo XML
 * 
 * Función que regresa todos los atributos y valores de todos los elementos<br/>
 * de una cadena en formato XML en un arreglo asociativo<br/>
 * Fecha de creación: 25 de Febrero del 2014<br/>
 * Fecha de modificación: 25 de Febrero del 2014
 * 
 * @param string $xml String en formato XML
 * @return arreglo asociativo
 * @author César Cavazos <ccavazos@mpsystems.com.mx>
 */
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

$xml = new XMLReader();
$xml->open($_GET["archivoXML"]);
$assoc = xml2assoc($xml);
$xml->close();

//echo "<pre>";
//print_r($assoc);

/** cfdiComprobante Arreglos **/
$cfdiComprobante = $assoc["cfdi:Comprobante"]["0"]["attributes"];
/** cfdiComprobante Arreglos **/
/******************************************************************************/
/** cfdiComprobante Variables Disponibles **/
if(isset($cfdiComprobante["xmlns:cfdi"])) {
$cfdiComprobanteXmlnsCfdi = $cfdiComprobante["xmlns:cfdi"];
}
$cfdiComprobanteXmlnsXsi = $cfdiComprobante["xmlns:xsi"];
$cfdiComprobanteXsiSchemaLocation = $cfdiComprobante["xsi:schemaLocation"];
$cfdiComprobanteVersion = $cfdiComprobante["version"];
$cfdiComprobanteSerie = $cfdiComprobante["serie"];
$cfdiComprobanteFolio = $cfdiComprobante["folio"];
$cfdiComprobanteFecha = $cfdiComprobante["fecha"];
$cfdiComprobanteSello = $cfdiComprobante["sello"];
$cfdiComprobanteFormaDePago = $cfdiComprobante["formaDePago"];
$cfdiComprobanteNoCertificado = $cfdiComprobante["noCertificado"];
$cfdiComprobanteCertificado = $cfdiComprobante["certificado"];
$cfdiComprobanteSubTotal = $cfdiComprobante["subTotal"];
if(isset($cfdiComprobante["TipoCambio"])) {
$cfdiComprobanteTipoCambio = $cfdiComprobante["TipoCambio"];
}
$cfdiComprobanteMoneda = $cfdiComprobante["Moneda"];
$cfdiComprobanteLugarExpedicion = $cfdiComprobante["LugarExpedicion"];
$cfdiComprobanteTotal = $cfdiComprobante["total"];
$cfdiComprobanteMetodoDePago = $cfdiComprobante["metodoDePago"];
$cfdiComprobanteNumCtaPago = $cfdiComprobante["NumCtaPago"];
$cfdiComprobanteTipoDeComprobante = $cfdiComprobante["tipoDeComprobante"];
if(isset($cfdiComprobante["xmlns:xs"])) {
$cfdiComprobanteXmlnsXs = $cfdiComprobante["xmlns:xs"];
}
if(isset($cfdiComprobante["xmlns:tfd"])) {
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
if(isset($cfdiEmisorDomicilioFiscal["noInterior"])) {
$cfdiEmisorDomicilioFiscalNoInterior = $cfdiEmisorDomicilioFiscal["noInterior"];
}
$cfdiEmisorDomicilioFiscalPais = acentos($cfdiEmisorDomicilioFiscal["pais"]);
if(isset($cfdiEmisorDomicilioFiscal["referencia"])) {
$cfdiEmisorDomicilioFiscalReferencia = $cfdiEmisorDomicilioFiscal["referencia"];
}
$cfdiEmisorExpedidoEnCalle = $cfdiEmisorExpedidoEn["calle"];
$cfdiEmisorExpedidoEnCodigoPostal = $cfdiEmisorExpedidoEn["codigoPostal"];
$cfdiEmisorExpedidoEnColonia = $cfdiEmisorExpedidoEn["colonia"];
$cfdiEmisorExpedidoEnEstado = $cfdiEmisorExpedidoEn["estado"];
if(isset($cfdiEmisorExpedidoEn["localidad"])) {
$cfdiEmisorExpedidoEnLocalidad = $cfdiEmisorExpedidoEn["localidad"];
}
if(isset($cfdiEmisorExpedidoEn["municipio"])) {
$cfdiEmisorExpedidoEnMunicipio = $cfdiEmisorExpedidoEn["municipio"];
}
if(isset($cfdiEmisorExpedidoEn["noExterior"])) {
$cfdiEmisorExpedidoEnNoExterior = $cfdiEmisorExpedidoEn["noExterior"];
}
$cfdiEmisorExpedidoEnPais = $cfdiEmisorExpedidoEn["pais"];
$cfdiEmisorRegimenFiscalRegimen = $cfdiEmisorRegimenFiscal["Regimen"]; 
$cfdiEmisorNombre = $cfdiEmisor["nombre"];
$cfdiEmisorRFC = $cfdiEmisor["rfc"];
/** cfdiEmisor Variables Disponibles **/
/******************************************************************************/
/** cfdiReceptor Arreglos **/
if ( !empty($assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["value"]) ) {
	$cfdiReceptorDomicilio = $assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["value"]["cfdi:Domicilio"]["0"]["attributes"];
}
$cfdiReceptor = $assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["0"]["attributes"];
/** cfdiReceptor Arreglos **/
/******************************************************************************/
/** cfdiEmisor Variables Disponibles **/
$cfdiReceptorDomicilioCalle = $cfdiReceptorDomicilio["calle"];
$cfdiReceptorDomicilioCodigoPostal = $cfdiReceptorDomicilio["codigoPostal"];
$cfdiReceptorDomicilioColonia = $cfdiReceptorDomicilio["colonia"];
$cfdiReceptorDomicilioEstado = $cfdiReceptorDomicilio["estado"];
$cfdiReceptorDomicilioLocalidad = $cfdiReceptorDomicilio["localidad"];
if(isset($cfdiReceptorDomicilio["municipio"])) {
$cfdiReceptorDomicilioMunicipio = $cfdiReceptorDomicilio["municipio"];
}
if(isset($cfdiReceptorDomicilio["noExterior"])) {
$cfdiReceptorDomicilioNoExterior = $cfdiReceptorDomicilio["noExterior"];
}
if(isset($cfdiReceptorDomicilio["noInterior"])) {
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
if(isset($cfdiConceptos["noIdentificacion"])) {
$cfdiConceptosNoIdentificacion = $cfdiConceptos["noIdentificacion"];
}
$cfdiConceptosDescripcion = $cfdiConceptos["descripcion"];
$cfdiConceptosValorUnitario = $cfdiConceptos["valorUnitario"];
$cfdiConceptosImporte = $cfdiConceptos["importe"];
/** cfdiConceptos Variables Disponibles **/
/******************************************************************************/
/** cfdiImpuestos Arreglos **/
if(isset($assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["0"]["attributes"])) {
$cfdiImpuestos = $assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["0"]["attributes"];
}
/** cfdiImpuestos Arreglos **/
/******************************************************************************/
/** cfdiImpuestosTraslados Variables Disponibles **/
if(isset($cfdiImpuestos)) {
$cfdiImpuestosTotalImpuestosTrasladados = $cfdiImpuestos["totalImpuestosTrasladados"];
}
/** cfdiImpuestosTraslados Variables Disponibles **/
/******************************************************************************/
/** cfdiImpuestosTraslados Arreglos **/
$cfdiImpuestosTraslados = $assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["value"]["cfdi:Traslados"]["value"]["cfdi:Traslado"]["0"]["attributes"];
/** cfdiImpuestosTraslados Arreglos **/
/******************************************************************************/
/** cfdiImpuestosTraslados Variables Disponibles **/
$cfdiImpuestosTrasladosImpuesto = $cfdiImpuestosTraslados["impuesto"];
$cfdiImpuestosTrasladosTasa = $cfdiImpuestosTraslados["tasa"];
$cfdiImpuestosTrasladosImporte = $cfdiImpuestosTraslados["importe"];
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
if($_GET["idTipoProveedor"] == 0) {
    $tipoProveedor = "Interno";
    $sql = "CALL redefectiva.SP_LOAD_PROVEEDOR_PORRFC('" . $_GET["idTipoProveedor"] . "', '$cfdiEmisorRFC')";
} else {
    $tipoProveedor = "Externo";   
    $sql = "CALL redefectiva.SP_ACREEDOR_LOAD(0, '$cfdiEmisorRFC', 0)";
}
$result = $RBD->SP($sql);
$rowcount = mysqli_num_rows($result);
if($rowcount) {
    $row = mysqli_fetch_assoc($result);
    $sql = "CALL redefectiva.SP_LOAD_FACTURA('1',"
            . "'$cfdiComprobanteSerie$cfdiComprobanteFolio',"
            . "'$cfdiEmisorRFC')";
    $result2 = $RBD->SP($sql);
    $rowcount2 = mysqli_num_rows($result2);
    if($rowcount2) {
        $return .= "2|";
        $return .= "Si existe proveedor y la factura ya esta capturada|";         
    } else {
        $return .= "1|";     
        $return .= "Si existe proveedor = $rowcount|";        
    }
    $concat = $row["idProveedor"] . "|";
    $concat .= $row["numCuenta"] . "|";
} else {
    $return .= "0|";     
    $return .= "$cfdiEmisorNombre no esta dado de alta como \"Proveedor $tipoProveedor\" en nuestra Base de Datos | ";
}

$return .= addslashes($_GET["archivoXML"]) . "|"; // Archivo temporal, guardar en hidden
$return .= "$cfdiEmisorNombre|";
$return .= "$cfdiEmisorRFC|";
$return .= "$cfdiEmisorDomicilioFiscalCalle|";
$return .= "$cfdiEmisorDomicilioFiscalNoExterior|";
$return .= "$cfdiEmisorDomicilioFiscalNoInterior|";
$return .= "$cfdiEmisorDomicilioFiscalColonia|";
$return .= "$cfdiEmisorDomicilioFiscalMunicipio|";
$return .= "$cfdiEmisorDomicilioFiscalEstado|";
$return .= "$cfdiEmisorDomicilioFiscalCodigoPostal|";
$return .= "$cfdiEmisorDomicilioFiscalPais|";
$return .= "$cfdiComprobanteFecha|";
$return .= "$cfdiComprobanteSerie|";
$return .= "$cfdiComprobanteFolio|";
$return .= "$cfdiComprobanteSerie" . "$cfdiComprobanteFolio|";
$return .= "$cfdiComprobanteMoneda|";
$return .= "$cfdiComprobanteTipoCambio|";
$return .= "$cfdiComprobanteSubTotal|";
if(!$cfdiImpuestosTotalImpuestosTrasladados){
    $return .= "$cfdiImpuestosTrasladosImporte|";
} else {
    $return .= "$cfdiImpuestosTotalImpuestosTrasladados|";
}
$return .= "$cfdiComprobanteTotal|";    

/** No mover orden de la concatenacion, agregar variables para abajo **/
/** Pago a proveedores **/

if($concat) $return .= $concat;
return $return;

?>


