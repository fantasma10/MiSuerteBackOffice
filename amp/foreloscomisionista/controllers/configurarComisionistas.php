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
class configuracionComisionistas{
    private $setCknIdCadena; 
    private $setCkbCredito; 
    private $setCkbActivoGrafico; 
    private $setCknIdTipoCredito; 
    function setCknIdCadena($setCknIdCadena){
        $this->setCknIdCadena=$setCknIdCadena;
    }
    function setCkbCredito($setCkbCredito){
        $this->setCkbCredito=$setCkbCredito;
    }
    function setCkbActivoGrafico($setCkbActivoGrafico){
        $this->setCkbActivoGrafico=$setCkbActivoGrafico;
    }
    function setCknIdTipoCredito($setCknIdTipoCredito){
        $this->setCknIdTipoCredito=$setCknIdTipoCredito;
    }
    function forelosComisionistas(){
    include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
        $param = array
                (                     
                    array(
                    'name'  => 'CknIdCadena',
                    'type'  => 's',
                    'value' => $this->setCknIdCadena),
                    array(
                    'name'  => 'CkbCredito',
                    'type'  => 's',
                    'value' => $this->setCkbCredito),
                    array(
                    'name'  => 'CkbActivoGrafico',
                    'type'  => 's',
                    'value' => $this->setCkbActivoGrafico),
                    array(
                    'name'  => 'CknIdTipoCredito',
                    'type'  => 's',
                    'value' => $this->setCknIdTipoCredito)
                );

                // $oRAMP->setSDatabase('data_AquiMisPagos');
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_update_configuracion_credito'); // OK BD: data_aquimispagos

                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        return $ArrayRetorno;        
    }  
}
$obj = new configuracionComisionistas();
$obj->setCknIdCadena($_POST['CknIdCadena']);
$obj->setCkbCredito($_POST['CkbCredito']);
$obj->setCkbActivoGrafico($_POST['CkbActivoGrafico']);
$obj->setCknIdTipoCredito($_POST['CknIdTipoCredito']);
$result=$obj->forelosComisionistas();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Configuración Actualizada',
    'data'      => utf8ize($result)
));
?>