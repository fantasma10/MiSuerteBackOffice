<?php
ini_set("soap.wsdl_cache_enabled", "1");
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
class conf_facturacion{

    function catalogoFormaPago($id){
        include($_SERVER['DOCUMENT_ROOT']."/amp/facturacion/inc/conexionWS.php");
        $idUnidadNegocio = array('Id' => $id);
		$result = $client->GetFormaPago($idUnidadNegocio);
		return json_encode($result);	
    }
    function catalogoMetodoPago($id){
        include($_SERVER['DOCUMENT_ROOT']."/amp/facturacion/inc/conexionWS.php");
        $idUnidadNegocio = array('Id' => $id);
		$result = $client->GetMetodoPago($idUnidadNegocio);
        $array = array($result);
		$metodo_pago = $array[0]->GetMetodoPagoResult->MetodoPago;	
        if(count($metodo_pago)==1){
			return json_encode(array($metodo_pago));
		}else{
			return json_encode($metodo_pago);
		}
    }
    function catalogoCFDI($id){
        include($_SERVER['DOCUMENT_ROOT']."/amp/facturacion/inc/conexionWS.php");
        $idUnidadNegocio = array('Id' => $id);
		$result = $client->GetUsoCFDI($idUnidadNegocio);
		return json_encode($result);
    }
    function catalogoProducto($id){
        include($_SERVER['DOCUMENT_ROOT']."/amp/facturacion/inc/conexionWS.php");
        $idUnidadNegocio = array('Id' => $id);
		$result = $client->GetProductoServicio($idUnidadNegocio);
		return json_encode($result);
    }
    /*function catalogoIVA(){
        $idUnidadNegocio = array('Id' => $id);
		$result = $client->GetEmpresa($idUnidadNegocio);
		echo json_encode($result);	
    }*/
}
$obj = new conf_facturacion();
$arrayData=array();
$arrayData['catalogoFormaPago'] = $obj->catalogoFormaPago(0);
$arrayData['catalogoMetodoPago'] = $obj->catalogoMetodoPago(0);
$arrayData['catalogoCFDI'] = $obj->catalogoCFDI(0);
$arrayData['catalogoProducto'] = $obj->catalogoProducto(0);

echo json_encode(array("result"=>$arrayData));