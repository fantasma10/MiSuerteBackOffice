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
class configuracionComisionistasCorreos{
    private $setCknIdUsuarioRE;
    private $setCknIdTipoCredito;
    private $setCknombre;
    private $setCkapellidoPaterno;
    private $setCkapellidoMaterno;
    private $setCkCorreoRedEfect;
    private $setCkCorreoPersonal;
    private $setCkTelefono;
    private $setCknIdTipoCreditoNoticacion;
    private $setCkIdentificador;


    function setCkIdentificador($setCkIdentificador){
        $this->setCkIdentificador=$setCkIdentificador;
    }
    function setCknIdTipoCreditoNoticacion($setCknIdTipoCreditoNoticacion){
        $this->setCknIdTipoCreditoNoticacion=$setCknIdTipoCreditoNoticacion;
    }
    function setCknIdUsuarioRE($setCknIdUsuarioRE){
        $this->setCknIdUsuarioRE=$setCknIdUsuarioRE;
    }
    function setCknIdTipoCredito($setCknIdTipoCredito){
        $this->setCknIdTipoCredito=$setCknIdTipoCredito;
    }
    function setCknombre($setCknombre){
        $this->setCknombre=$setCknombre;
    }
    function setCkapellidoPaterno($setCkapellidoPaterno){
        $this->setCkapellidoPaterno=$setCkapellidoPaterno;
    }
    function setCkapellidoMaterno($setCkapellidoMaterno){
        $this->setCkapellidoMaterno=$setCkapellidoMaterno;
    }
    function setCkCorreoRedEfect($setCkCorreoRedEfect){
        $this->setCkCorreoRedEfect=$setCkCorreoRedEfect;
    }
    function setCkCorreoPersonal($setCkCorreoPersonal){
        $this->setCkCorreoPersonal=$setCkCorreoPersonal;
    }
    function setCkTelefono($setCkTelefono){
        $this->setCkTelefono=$setCkTelefono;
    }
   
    function registrarCorreos(){
    include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
        $param = array
                (   
                    array(
                    'name'  => 'CknIdTipoCreditoNoticacion',
                    'type'  => 'i',
                    'value' => $this->setCknIdTipoCreditoNoticacion),
                    array(
                    'name'  => 'CknIdUsuarioRE',
                    'type'  => 's',
                    'value' => $this->setCknIdUsuarioRE),
                    array(
                    'name'  => 'CknIdTipoCredito',
                    'type'  => 's',
                    'value' => $this->setCknIdTipoCredito),
                    array(
                    'name'  => 'Cknombre',
                    'type'  => 's',
                    'value' => $this->setCknombre),
                    array(
                    'name'  => 'CkapellidoPaterno',
                    'type'  => 's',
                    'value' => $this->setCkapellidoPaterno),
                    array(
                    'name'  => 'CkapellidoMaterno',
                    'type'  => 's',
                    'value' => $this->setCkapellidoMaterno),
                    array(
                    'name'  => 'CkCorreoPersonal',
                    'type'  => 's',
                    'value' => $this->setCkCorreoPersonal),
                    array(
                    'name'  => 'CkTelefono',
                    'type'  => 's',
                    'value' => $this->setCkTelefono),
                    array(
                    'name'  => 'CkIdentificador',
                    'type'  => 'i',
                    'value' => $this->setCkIdentificador)
                );

                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_insert_configuracion_credito_correos'); // OK BD: data_aquimispagos

                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;        
    }  
}
$obj = new configuracionComisionistasCorreos();
$obj->setCknIdUsuarioRE($_POST['CknIdUsuarioRE']);
$obj->setCknIdTipoCredito($_POST['CknIdTipoCredito']);
$obj->setCknombre($_POST['Cknombre']);
$obj->setCkapellidoPaterno($_POST['CkapellidoPaterno']);
$obj->setCkapellidoMaterno($_POST['CkapellidoMaterno']);
$obj->setCkCorreoRedEfect($_POST['CkCorreoRedEfect']);
$obj->setCkCorreoPersonal($_POST['CkCorreoPersonal']);
$obj->setCkTelefono($_POST['CkTelefono']);
$obj->setCkIdentificador($_POST['CkIdentificador']);
if($_POST['CknIdTipoCreditoNoticacion'] == null){
    $_POST['CknIdTipoCreditoNoticacion'] = 0;
}
$obj->setCknIdTipoCreditoNoticacion($_POST['CknIdTipoCreditoNoticacion']);
$result=$obj->registrarCorreos();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Configuración Actualizada',
    'data'      => utf8ize($result)
));
?>