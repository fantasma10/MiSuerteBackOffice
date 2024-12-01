<?php
$PATHRAIZ   =  $_SERVER['HTTP_HOST'];
$BASE_PATH  = $PATHRAIZ;    
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}
class ProcesaSolicitudCredito{
        private $setstoken;
        private $setnstatus;
        function setstoken($setstoken){
            $this->setstoken=$setstoken;
        }
        function setnstatus($setnstatus){
            $this->setnstatus=$setnstatus;
        }
    function ProcesarSolicitudCredito(){
        include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
                $param = array
                ( 
                    array(
                    'name'  => 'CksToken',
                    'type'  => 's',
                    'value' => $this->setstoken),
                    array(
                    'name'  => 'CknIdEstatusSolicitud',
                    'type'  => 'i',
                    'value' => $this->setnstatus),
                    array(
                    'name'  => 'CknIdusuarioREproc',
                    'type'  => 'i',
                    'value' => '0') 
                );                
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_update_solicitud_credito');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();               
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        if ($ArrayRetorno['data'][0]['CodigoRespuesta'] == 0 ) {                
                $param2 = array
                ( 
                    array(
                    'name'  => 'CkdFecCobroInic',
                    'type'  => 's',
                    'value' => '0000-00-00'),
                    array(
                    'name'  => 'CkdFecCobroFinal',
                    'type'  => 's',
                    'value' => '0000-00-00'),
                    array(
                    'name'  => 'CknIdEstatusSolicitud',
                    'type'  => 'i',
                    'value' => '-1'),
                    array(
                    'name'  => 'CknIdSolicitudCredito',
                    'type'  => 'i',
                    'value' => '0'),
                    array(
                    'name'  => 'CksToken',
                    'type'  => 's',
                    'value' => $this->setstoken)
                );                
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_solicitud_credito');
                $oRAMP->setParams($param2);
                $resultCorreo = $oRAMP->execute();
                $dataCoreo = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $msg="";
                $nIdSolicitudCredito = $dataCoreo[0]['nIdSolicitudCredito'];
                $sRazonSocial = $dataCoreo[0]['sRazonSocial'];
                $sNombreCadena = $dataCoreo[0]['sNombreCadena'];
                $saldoCuenta = $dataCoreo[0]['saldoCuenta'];
                $nAbono = $dataCoreo[0]['nAbono'];
                $sToken = $dataCoreo[0]['sToken'];
                $sNombreusuarioRE = $dataCoreo[0]['sNombreusuarioRE'];
                if($dataCoreo[0]['nIdEstatusSolicitud']==1){ $statusSolicitud="Autorizado"; $msg=", verifica el nuevo saldo de su FORELO"; }
                if($dataCoreo[0]['nIdEstatusSolicitud']==2){ $statusSolicitud="Rechazado"; }	
                $sCorreoSolicitante = $dataCoreo[0]['sCorreoSolicitante'];
                include_once($_SERVER['DOCUMENT_ROOT']."/amp/foreloscomisionista/views/procesarSolicitudCreditoCorreo.php");
        }
        return $ArrayRetorno;
    }  
}
$obj = new ProcesaSolicitudCredito();
	$token= substr( $_GET['token'] , 0, -1); ;
	$status = substr($_GET['token'], -1); 
    $obj->setstoken($token);
    $obj->setnstatus($status);
$result=$obj->ProcesarSolicitudCredito();
if ($result) {
	$ruta = "https://".$_SERVER['HTTP_HOST']."/index.php";
	echo "<script> window.location='".$ruta."'; </script>";
}
   json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Movimiento Aplicado Correctamente',
    'data'      => utf8ize($result)
));
?>