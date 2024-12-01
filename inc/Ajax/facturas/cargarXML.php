<?php
//require("../inc/session.inc.php");
//variables de la version 3.3

           error_reporting(E_ALL);
        error_reporting(1);
        
            
             // comprobante 9
            $version = 0;
            $LugarExpedicion = 0;
            $metodoPago = '';
            $tipoCombrobante = '';
            $total = 0;
            $moneda = '';
            $subtotal = 0;
            $formaPago = 0;
            $fecha = '';
            $folio = '';
             //emisor 3
            $emisorRfc = '';
            $emisorNombre = '';
            $regimenFiscal = 0;        
            
            //receptor 3
            $receptorRfc = '';
            $receptorNombre = '';
            $receptorUsoCfdi = '';
            
            //conceptos 3
            
            $claveProdServ = 0;
            $claveUnidad = '';
            $descripcion = '';
            $cantidad = 0;

            //impuestos  tralados 4
            
            $trsladoImpuesto = 0;//clave de catálogo;
            $trasladoTipoFactor = '';
            $trasladoTasaCuota = 0;
            $trasladoImporte = 0;
        
            //impuestos Retenciones
             $retencionImpuesto = 0;
             $retencionTipoFactor = '';
             $retencionTasaCuota = 0;
             $retencionImporte = 0;
   
            // complemento 1
            $UUID = '';
        
            $regimensss = 0;
                //1 fisica
                //2 Moral
                //0 No se encontro



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
//var_dump($calabaza);

$xmls = simplexml_load_file($_GET["archivoXML"]);


$namespaces = $xmls->getNamespaces(true);


//$xmls->registerXPathNamespace('cfdi', 'http://www.sat.gob.mx/cfd/3');

$assoc = xml2assoc($xml);
//echo '<pre>'; var_dump($assoc); echo '</pre>';
$xml->close();




$cfdiComprobanteMoneda = '';
$cfdiEmisorDomicilioFiscalCodigoPostal = 0;
$cfdiEmisorDomicilioFiscalNoInterior = '';
$cfdiComprobanteTipoCambio =  0;
$cfdiComprobanteSerie = '';
$cfdiComprobanteFolio = '';
$cfdiEmisorDomicilioFiscalNoExterior = '';
$cfdiComprobanteNumCtaPago= 0;

/*echo "<pre>";
print_r($assoc);
echo "</pre>";*/

/** cfdiComprobante Arreglos **/

$cfdiComprobante = $assoc["cfdi:Comprobante"]["0"]["attributes"];

if(isset($cfdiComprobante["Version"])){$version = $cfdiComprobante["Version"];}

if(isset($cfdiComprobante["version"])){$version = $cfdiComprobante["version"];}    
    
            
            
 if($version == '3.3'){   
     
     //comprobante
            
         if(isset($cfdiComprobante["LugarExpedicion"])){$LugarExpedicion= (float)$cfdiComprobante["LugarExpedicion"];}
         if(isset($cfdiComprobante["MetodoPago"])){$metodoPago = $cfdiComprobante["MetodoPago"];}
         if(isset($cfdiComprobante["TipoDeComprobante"])){$tipoCombrobante= $cfdiComprobante["TipoDeComprobante"];}
         if(isset($cfdiComprobante["Total"])){$total = $cfdiComprobante["Total"];}
         if(isset($cfdiComprobante["Moneda"])){$moneda = $cfdiComprobante["Moneda"];}
         if(isset($cfdiComprobante["SubTotal"])){$subtotal = $cfdiComprobante["SubTotal"];}
         if(isset($cfdiComprobante["FormaPago"])){$formaPago = $cfdiComprobante["FormaPago"];}
         if(isset($cfdiComprobante["Fecha"])){$fecha = substr($cfdiComprobante["Fecha"],0,10);}
    
      //emisor
     
$cfdiEmisor = $assoc["cfdi:Comprobante"]["value"]["cfdi:Emisor"]["0"]["attributes"];  
     
     
         if(isset($cfdiEmisor["Rfc"])){$emisorRfc      = $cfdiEmisor["Rfc"];}
         if(isset($cfdiEmisor["Nombre"])){$emisorNombre   = $cfdiEmisor["Nombre"];}
         if(isset($cfdiEmisor["RegimenFiscal"])){$regimenFiscal  = $cfdiEmisor["RegimenFiscal"];}
     
        if(strlen($emisorRfc) == 13){$regimensss = 1;}
        if(strlen($emisorRfc) == 12){$regimensss = 2;}

            
       ////receptor
  $cfdiReceptor = $assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["0"]["attributes"];  
     
        if(isset($cfdiReceptor["Rfc"])){$receptorRfc = $cfdiReceptor["Rfc"];}
        if(isset($cfdiReceptor["Nombre"])){$receptorNombre  = $cfdiReceptor["Nombre"];}
        if(isset($cfdiReceptor["UsoCFDI"])){$receptorUsoCfdi  = $cfdiReceptor["UsoCFDI"];}
     
      //conceptos 3
            
            
$cfdiConceptos = $assoc["cfdi:Comprobante"]["value"]["cfdi:Conceptos"]["value"]["cfdi:Concepto"]["0"]["attributes"];
            
        if(isset($cfdiConceptos["ClaveProdServ"])){$claveProdServ = $cfdiConceptos["ClaveProdServ"];}  
        if(isset($cfdiConceptos["Cantidad"])){ $cantidad = $cfdiConceptos["Cantidad"];} 
        if(isset($cfdiConceptos["ClaveUnidad"])){$claveUnidad = $cfdiConceptos["ClaveUnidad"];} 
        if(isset($cfdiConceptos["Descripcion"])){ $descripcion = $cfdiConceptos["Descripcion"];} 
            
     //impuestos  trasladado
            
     
   $cfdiImpuestosTraslado =  $assoc["cfdi:Comprobante"]["value"]["cfdi:Conceptos"]["value"]["cfdi:Concepto"]["value"]["cfdi:Impuestos"]["value"]["cfdi:Traslados"]["value"]["cfdi:Traslado"]["0"]["attributes"];  
     
         if(isset($cfdiImpuestosTraslado["Impuesto"])){$trsladoImpuesto = $cfdiImpuestosTraslado["Impuesto"];}
         if(isset($cfdiImpuestosTraslado["TipoFactor"])){$trasladoTipoFactor = $cfdiImpuestosTraslado["TipoFactor"];}
         if(isset($cfdiImpuestosTraslado["TasaOCuota"])){$trasladoTasaCuota = $cfdiImpuestosTraslado["TasaOCuota"];}
         if(isset($cfdiImpuestosTraslado["Importe"])){$trasladoImporte = $cfdiImpuestosTraslado["Importe"];}
     
     
     //impuestos Retencion
     if($regimensss == 1){
     
    $cfdiImpuestosRetencion= $assoc["cfdi:Comprobante"]["value"]["cfdi:Conceptos"]["value"]["cfdi:Concepto"]["value"]["cfdi:Impuestos"]["value"]["cfdi:Retenciones"]["value"]["cfdi:Retencion"]["0"]["attributes"];          
         if(isset($cfdiImpuestosRetencion["Impuesto"])){$retencionImpuesto = $cfdiImpuestosRetencion["Impuesto"];}
         if(isset($cfdiImpuestosRetencion["TipoFactor"])){$retencionTipoFactor = $cfdiImpuestosRetencion["TipoFactor"];}
         if(isset($cfdiImpuestosRetencion["TasaOCuota"])){$retencionTasaCuota = $cfdiImpuestosRetencion["TasaOCuota"];}
         if(isset($cfdiImpuestosRetencion["Importe"])){$retencionImporte = $cfdiImpuestosRetencion["Importe"];}
         
         
     }
     
          
  $cfdiComplemento = $assoc["cfdi:Comprobante"]["value"]["cfdi:Complemento"]["value"]["tfd:TimbreFiscalDigital"]["0"]["attributes"];
            
       if(isset($cfdiComplemento["UUID"])){$UUID = $cfdiComplemento["UUID"];}     
           
      
   }else if($version == '3.2'){
            
            
         if(isset($cfdiComprobante["LugarExpedicion"])){$LugarExpedicion= (float)$cfdiComprobante["LugarExpedicion"];}
         if(isset($cfdiComprobante["metodoDePago"])){$metodoPago = $cfdiComprobante["metodoDePago"];}
         if(isset($cfdiComprobante["tipoDeComprobante"])){$tipoCombrobante= $cfdiComprobante["tipoDeComprobante"];}
         if(isset($cfdiComprobante["total"])){$total = $cfdiComprobante["total"];}
         if(isset($cfdiComprobante["Moneda"])){$moneda = $cfdiComprobante["Moneda"];}
         if(isset($cfdiComprobante["subTotal"])){$subtotal = $cfdiComprobante["subTotal"];}
         if(isset($cfdiComprobante["formaDePago"])){$formaPago = $cfdiComprobante["formaDePago"];}
         if(isset($cfdiComprobante["fecha"])){$fecha = substr($cfdiComprobante["fecha"],0,10);}
         if(isset($cfdiComprobante["folio"])){$folio = $cfdiComprobante["folio"];}

      //emisor
     
		$cfdiEmisor = $assoc["cfdi:Comprobante"]["value"]["cfdi:Emisor"]["0"]["attributes"];  
     
     
	         if(isset($cfdiEmisor["rfc"])){$emisorRfc  = $cfdiEmisor["rfc"];}
	         if(isset($cfdiEmisor["nombre"])){$emisorNombre  = $cfdiEmisor["nombre"];}
	         if(isset($cfdiEmisor["RegimenFiscal"])){$regimenFiscal = $cfdiEmisor["RegimenFiscal"];}

	           if(strlen($emisorRfc) == 13){$regimensss = 1;}
	        if(strlen($emisorRfc) == 12){$regimensss = 2;}  
	       ////receptor
		$cfdiReceptor = $assoc["cfdi:Comprobante"]["value"]["cfdi:Receptor"]["0"]["attributes"];  
     
        if(isset($cfdiReceptor["rfc"])){$receptorRfc = $cfdiReceptor["rfc"];}
        if(isset($cfdiReceptor["nombre"])){$receptorNombre  = $cfdiReceptor["nombre"];}
        if(isset($cfdiReceptor["UsoCFDI"])){$receptorUsoCfdi  = $cfdiReceptor["UsoCFDI"];}
     
      //conceptos 3
            
            
$cfdiConceptos = $assoc["cfdi:Comprobante"]["value"]["cfdi:Conceptos"]["value"]["cfdi:Concepto"]["0"]["attributes"];
            
        if(isset($cfdiConceptos["ClaveProdServ"])){$claveProdServ = $cfdiConceptos["ClaveProdServ"];}  
       
        if(isset($cfdiConceptos["ClaveUnidad"])){$claveUnidad = $cfdiConceptos["ClaveUnidad"];} 
        if(isset($cfdiConceptos["descripcion"])){ $descripcion = $cfdiConceptos["descripcion"];} 
            
     //impuestos  trasladado
            
  $cfdiImpuestosTraslado = $assoc["cfdi:Comprobante"]["value"]["cfdi:Impuestos"]["value"]["cfdi:Traslados"]["value"]["cfdi:Traslado"]["0"]["attributes"];          
         if(isset($cfdiImpuestosTraslado["impuesto"])){$trsladoImpuesto = $cfdiImpuestosTraslado["impuesto"];}
         if(isset($cfdiImpuestosTraslado["TipoFactor"])){$trasladoTipoFactor = $cfdiImpuestosTraslado["TipoFactor"];}
         if(isset($cfdiImpuestosTraslado["tasa"])){$trasladoTasaCuota = $cfdiImpuestosTraslado["tasa"];}
         if(isset($cfdiImpuestosTraslado["importe"])){$trasladoImporte = $cfdiImpuestosTraslado["importe"];}

      // complemento 1
            
  $cfdiComplemento = $assoc["cfdi:Comprobante"]["value"]["cfdi:Complemento"]["value"]["tfd:TimbreFiscalDigital"]["0"]["attributes"];
            
       if(isset($cfdiComplemento["UUID"])){$UUID = $cfdiComplemento["UUID"];}  
            
            
            
    }else{array_push($rechazo, " La Version del XML no es Admitida, utilize la version 3.3");$validado = 1;}



/*
        
            echo '-----------------------------comprobante-------------------<br>';
            echo 'version: '.$version.'<br>';
            echo 'Lugar de expedicion: '.$LugarExpedicion.'<br>';
            echo 'Metodo de pago: '.$metodoPago.'<br>';
            echo 'tipoComprobante: '.$tipoCombrobante.'<br>';
            echo 'Total: '.$total.'<br>';
            echo 'Moneda: '.$moneda.'<br>';
            echo 'Sub Total: '.$subtotal.'<br>';
            echo 'Forma de Pago: '.$formaPago.'<br>';
            echo 'Fecha factura: '.$fecha.'<br>';
                              
            echo '-----------------------------Emisor-------------------<br>';
            echo 'RFC: '.$emisorRfc.'<br>';
            echo 'Nombre: '.$emisorNombre.'<br>';
            echo 'Regimen Fiscal: '.$regimenFiscal.'<br>';
            echo 'Regimen: '.$regimensss.'<br>';
                
            echo '-----------------------------Receptor-------------------<br>';
            echo 'RFC: '.$receptorRfc.'<br>';
            echo 'Nombre: '.$receptorNombre.'<br>';
            echo 'Uso de CFDI: '.$receptorUsoCfdi.'<br>';   
        
            echo '-----------------------------Conceptos-------------------<br>';
            echo 'Calve de producto o Servicio: '.$claveProdServ.'<br>';
            echo 'Clave de Unidad: '.$claveUnidad.'<br>';
            echo 'Descripcion: '.$descripcion.'<br>';   
        
        
            echo '-----------------------------impuesto - Traslados-------------------<br>';
            echo 'Impuestos: '.$trsladoImpuesto.'<br>';
            echo 'Tipo de Factor: '.$trasladoTipoFactor.'<br>';
            echo 'Tasa o Cuota: '.$trasladoTasaCuota.'<br>';   
            echo 'Importe: '.$trasladoImporte.'<br>'; 
    
            echo '-----------------------------impuesto - Retenciones -------------------<br>';
            echo 'Impuestos: '.$retencionImpuesto.'<br>';
            echo 'Tipo de Factor: '.$retencionTipoFactor.'<br>';
            echo 'Tasa o Cuota: '.$retencionTasaCuota.'<br>';   
            echo 'Importe: '.$retencionImporte.'<br>'; 
      
            echo '-----------------------------Complementos-------------------<br>';
            echo 'UUID: '.$UUID.'<br>';    
    
         
    */
            
    
         //// variables  para insercion
    
        
        $cfdiEmisorRFC = $emisorRfc;
        $cfdiReceptorRFC = $receptorRfc;
        $cfdiComprobanteFecha = $fecha;
        $cfdiComprobanteFolio = $folio;
        $cfdiComprobanteSubTotal = $subtotal;
        $cfdiImpuestosTrasladosImporte = $trasladoImporte;
        $cfdiComprobanteTotal = $total;
        $cfdiEmisorNombre = $emisorNombre;
        $cfdiEmisorDomicilioFiscalCalle = '';
        $cfdiEmisorDomicilioFiscalNoExterior = 0;
        $cfdiEmisorDomicilioFiscalNoInterior = 0;
        $cfdiEmisorDomicilioFiscalColonia = '';
        $cfdiEmisorDomicilioFiscalMunicipio = '';
        $cfdiEmisorDomicilioFiscalEstado = '';
        $cfdiEmisorDomicilioFiscalCodigoPostal = $LugarExpedicion;
        $cfdiEmisorDomicilioFiscalPais = '';
        $cfdiComprobanteSerie = '';
        $cfdiComprobanteFolio = $folio;
        $cfdiComprobanteMoneda = $moneda;
        $cfdiComprobanteTipoCambio = 0;
        $cfdiComplementoUUID = $UUID;
        $cfdiImpuestosRetencionesRetencion =  $retencionImporte;
        
        
?>


