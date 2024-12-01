<?php

class consultar_prospectos{

    private $nIdUsuario;
    function setsnIdUsuario($nIdUsuario){
        $this->nIdUsuario=$nIdUsuario;
    }

    function prospectosAut(){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
       $param = array
                (   array(
                        'nIdUsuario'  => 'CknIdUsuario',
                        'type'  => 'i',
                        'value' => $this->nIdUsuario)       
                );
       $oRAMP->setSStoredProcedure('sp_select_pendientesfiscalizado');
       $oRAMP->setParams($param);
       $result2 = $oRAMP->execute();
       $data = $oRAMP->fetchAll();
       $oRAMP->closeStmt();
       return $data;   
    }
  
}

$obj = new consultar_prospectos();
$obj->setsnIdUsuario(0);


$result=$obj->prospectosAut();


echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>