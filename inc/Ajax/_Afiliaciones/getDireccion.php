<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");

$texto = (isset($_POST['term']))?strtolower($_POST['term']):'';

if ($texto != ''){
	//$texto = (!preg_match('!!u', $texto))? utf8_decode($texto) : $texto;
    $texto = utf8_decode($texto);
    $sql = "CALL `afiliacion`.`SP_CALLE_FIND`('$texto');";
    $res = $RBD->SP($sql);
    if($RBD-> error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            $data = array();

            while($row = mysqli_fetch_assoc($res)){
                foreach($row AS $key => $value){
                    $row[$key] = (!preg_match("!!u", $value))? utf8_encode($value) : $value;
                }
                $data[] = $row;
            }

            $response = array(
                'data'  => $data
            );
        }
        else{
            $response = array(
                'errmsg'    => '0 resultados',
                'data'      => array()
            );
        }
    }
    else{
        $response = array(
            'errmsg'    => $RBD->error(),
            'data'      => array()
        );
    }
    echo json_encode($response);
}
?>