<?php
    $hnIdUsuario = $_POST['hnIdUsuario'];
    $hnIdSucursal = $_POST['hnIdSucursal'];
    $rangoReglas = $_POST['rangoReglas'];
    $nIdrangoReglas = $_POST['nIdrangoReglas'];
    $bS = (empty($_POST['bS']))?0:1;
    $bM = (empty($_POST['bM']))?0:1;
    $arrayNew=array();
    arsort($rangoReglas);
    $cont=0;
    $contTipo=1;
    count($rangoReglas);
    
    foreach(array_keys( $rangoReglas ) as $key){ 
        if($key!='M' && $rangoReglas[$key]!='') {
            $arrayNew[$cont]=[
                              'id' => $cont,
                              'nIdSucursal' => $hnIdSucursal,
                              'tipoForelo' => $key,
                              'minimo' => '0',
                              'maximo' => $rangoReglas[$key],
                              'nIdForeloDetalle'=>(empty(($nIdrangoReglas[$key])))?0:key($nIdrangoReglas[$key])
                              ];
             
        }
        if( ($cont-1)>=0 && ($rangoReglas[$key]-1)>=0 && $contTipo>1){
            if (array_key_exists($cont-1, $arrayNew)) {
                $arrayNew[$cont-1][ "minimo" ] = ($rangoReglas[$key]+1);
            }
        }
        $contTipo++;
        if(count($rangoReglas)==$contTipo){
            $arrayNew[$cont-1][ "maximo" ] = $arrayNew[$cont-1][ "maximo" ];
        }
        $cont++;
    }
    $ReglasOperacion=""; 
    $ReglasOperacionUPD="";
    $Notificacion="";
    $NotificacionUPD="";
    foreach (  ($arrayNew) as $key => $value) {
        $ReglasOperacion.= $value['tipoForelo']."-".$value['minimo']."-".$value['maximo']."-".$value['nIdSucursal']."-1".",";
        $ReglasOperacionUPD.= "nValorMinimo='".$value['minimo']."',nValorMaximo='".$value['maximo']."' WHERE nIdForeloDetalle='".$value['nIdForeloDetalle']."'|";
    }
    foreach (  ($arrayNew) as $key => $value) {
        $Notificacion.=$value['nIdSucursal']."-".$bS."-".$bM.",";
        $NotificacionUPD.="bSmsAlerta='".$bS."',bMostrarForelo='".$bM."' WHERE nIdForeloNotificacion!=0 AND  nIdSucursal='".$value['nIdSucursal']."' AND nIdForelo='".$_POST['txtnIdForelo']."' |";
    }

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
class reglasNotificacionForeloRegistrar{

        private $setCknIdUsuario;
        private $setCksSmsAlerta;
        private $setp_Cadena;
        private $setsNotificacion;

        function setCknIdUsuario($setCknIdUsuario){
            $this->setCknIdUsuario=$setCknIdUsuario;
        }
        function setCksSmsAlerta($setCksSmsAlerta){
            $this->setCksSmsAlerta=$setCksSmsAlerta;
        }
        function setp_Cadena($setp_Cadena){
            $this->setp_Cadena=$setp_Cadena;
        }
        function setsNotificacion($setsNotificacion){
            $this->setsNotificacion=$setsNotificacion;
        }


    function insertReglasOperaciones(){
        include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
                $param = array
                ( 
                    array(
                    'name'  => 'CknIdUsuario',
                    'type'  => 'i',
                    'value' => $this->setCknIdUsuario),
                    array(
                    'name'  => 'CksSmsAlerta',
                    'type'  => 'i',
                    'value' => $this->setCksSmsAlerta),
                    array(
                    'name'  => 'p_Cadena',
                    'type'  => 's',
                    'value' => $this->setp_Cadena),
                    array(
                    'name'  => 'sNotificacion',
                    'type'  => 's',
                    'value' => $this->setsNotificacion)
                );
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_insert_reglasOperacion');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                var_dump($result2);
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;
    }  

    function UpdateReglasOperaciones(){
        include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
                $param = array
                ( 
                    array(
                    'name'  => 'CknIdUsuario',
                    'type'  => 'i',
                    'value' => $this->setCknIdUsuario),
                    array(
                    'name'  => 'CksSmsAlerta',
                    'type'  => 'i',
                    'value' => $this->setCksSmsAlerta),
                    array(
                    'name'  => 'p_Cadena',
                    'type'  => 's',
                    'value' => $this->setp_Cadena),
                    array(
                    'name'  => 'sNotificacion',
                    'type'  => 's',
                    'value' => $this->setsNotificacion)
                );
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_update_reglasOperacion');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;
    }  
}


$obj = new reglasNotificacionForeloRegistrar();
    
    if ($_POST['txtnIdForelo']>0) {
        $obj->setCknIdUsuario($hnIdUsuario);
        $obj->setCksSmsAlerta($bS);
        $obj->setp_Cadena(trim($ReglasOperacionUPD,'|'));
        $obj->setsNotificacion(trim($NotificacionUPD,'|'));
        $result=$obj->UpdateReglasOperaciones(); 
    }else{
        $obj->setCknIdUsuario($hnIdUsuario);
        $obj->setCksSmsAlerta($bS);
        $obj->setp_Cadena(trim($ReglasOperacion,','));
        $obj->setsNotificacion(trim($Notificacion,','));
        $result=$obj->insertReglasOperaciones();
    }
    


echo  json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Limites de Saldo Registrados',
    'data'      => utf8ize($result),
    'nIdUsuario'=> $hnIdUsuario,
    'nIdSucursal'=> $hnIdSucursal
));

?>