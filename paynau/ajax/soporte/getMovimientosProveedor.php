
<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

$nIdProveedor   = (!empty($_POST['nIdProveedor'])) ? $_POST['nIdProveedor']   : 0;
$nTipo          = (!empty($_POST['nTipo'])) ? $_POST['nTipo']   : 0;
$nRefencia      = (!empty($_POST['nReferencia'])) ? $_POST['nReferencia']   : 0;
$fechaIni       = (!empty($_POST["dFechaIni"])? $_POST["dFechaIni"] : '0000-00-00');
$fechaFin       = (!empty($_POST["dFechafin"])? $_POST["dFechafin"] : '0000-00-00');

$tipo = $_POST['tipo'];
if ($_POST) {
    
        $array_params = array(
            array('name'    => 'nTipo','value'   => $nTipo,'type'    => 'i'),
            array('name'    => 'nIdProveedor','value'   => $nIdProveedor,'type'    => 'i'),
            array('name'    => 'nReferencia','value'   => $nRefencia,'type'    => 's'),
            array('name'    => 'dFechaInicio','value'   => $fechaIni,'type'    => 's'),
            array('name'    => 'dFechafinal','value'   => $fechaFin,'type'    => 's')
        );

        $oRDPN->setSDatabase('paycash_one');
        $oRDPN->setSStoredProcedure('sp_select_movimientos_proveedor');
        $oRDPN->setParams($array_params);

        $result = $oRDPN->execute();
        $data = $oRDPN->fetchAll();
        $data =utf8ize($data);
        $oRDPN->closeStmt();
        echo json_encode($data);
}

?>