<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$parametros = $_POST;

if (!empty($parametros)) {
        
        $param = array(
            array(
                'name'	=> 'P_nidProveedor',
                'type'	=> 'i',
                'value'	=> $_POST["idProveedor"]
            ),
            array(
                'name'	=> 'P_fechaInicio',
                'type'	=> 's',
                'value'	=> $_POST["mesBusqueda"]
            )
        );
        $oRDPN->setSDatabase('paycash_one');
        $oRDPN->setSStoredProcedure('sp_select_corte_ordenescobro_reporte');
        $oRDPN->setParams($param);

        $result = $oRDPN->execute();
        $data = $oRDPN->fetchAll();

        $oRDPN->closeStmt();
        $oReporte = utf8ize($data);

        $result = array(
            'Exito' =>true,
            'Codigo' => 0,
            'Mensaje' => "Consulta Exitosa",
            'Data' => $oReporte
        );  
    echo json_encode($result);
    }else{
        $result = array(
        'Exito' =>false,
        'Codigo' => 1,
        'Mensaje' => "Captura los parametros",
            );  
        echo json_encode($result);
    }
?>