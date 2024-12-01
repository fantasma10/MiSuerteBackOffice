<?php

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
class notificacionOperadores{   
    private $setsTituloMensaje;
    private $setsMensaje;
    private $setnOperadores;
    private $setusuario_logueado;
    private $setdFechasEnvio; 
    private $hnOperadores;
    function setsTituloMensaje($setsTituloMensaje){
        $this->setsTituloMensaje=$setsTituloMensaje;
    }
    function setsMensaje($setsMensaje){
        $this->setsMensaje=$setsMensaje;
    }
    function setnOperadores($setnOperadores){
        $this->setnOperadores=$setnOperadores;
    }  
    function setusuario_logueado($setusuario_logueado){
        $this->setusuario_logueado=$setusuario_logueado;
    }
    function setdFechasEnvio($setdFechasEnvio){
        $this->setdFechasEnvio=$setdFechasEnvio;
    } 
    function sethnOperadores($hnOperadores){
        $this->hnOperadores=$hnOperadores;
    }    
    function notificacionRegistrar(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");             
                $param = array
                (    
	                
                    array(
                    'name'  => 'CknIdTipoNotificacion',
                    'type'  => 's',
                    'value' => 1),
                    array(
                    'name'  => 'CknIdUsuarioRed',
                    'type'  => 's',
                    'value' => $this->setusuario_logueado),
                    array(
                    'name'  => 'CknIdUsuario',
                    'type'  => 's',
                    'value' => 0),                    
                    array(
                    'name'  => 'CksTituloMensaje',
                    'type'  => 's',
                    'value' => utf8_decode($this->setsTituloMensaje)),
                    array(
                    'name'  => 'CksMensaje',
                    'type'  => 's',
                    'value' => utf8_decode($this->setsMensaje)),
                    array(
                    'name'  => 'CknOperadores',
                    'type'  => 's',
                    'value' => "".$this->setnOperadores.""),
                    array(
                    'name'  => 'CkdFechasEnvio',
                    'type'  => 's',
                    'value' => "".$this->setdFechasEnvio."")
                );
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_insert_notificaciones');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        return $ArrayRetorno;   
    }  
}
$obj = new notificacionOperadores();
$obj->setsTituloMensaje($_POST['CksTituloMensaje']);
$obj->setsMensaje($_POST['CksMensaje']);
    //if ( $_POST['CknOperadores']=="-1"  ){
$obj->setnOperadores( (string) $_POST['hnOperadores']);
    //}else{
    //    $obj->setnOperadores( (string) $_POST['CknOperadores']);
    //}
$obj->setusuario_logueado( $_POST['usuario_logueado'] );
$obj->setdFechasEnvio( (string) $_POST['CkdFechasEnvio'] );
$result=$obj->notificacionRegistrar();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Notificación Registrada.',
    'data'      => utf8ize($result)
));

?>