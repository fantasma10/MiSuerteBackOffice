<?php
include("../config.inc.php");
error_reporting(E_ALL);
ini_set("display_errors", 1);
$texto = (isset($_REQUEST['term']))?strtolower($_REQUEST['term']):'';

if ($texto != ''){
    $sql = "CALL `redefectiva`.`SP_LOAD_REPRESENTANTES_LEGALES`(0, '$texto', 0)";
    $res = $RBD->query($sql);
    if($RBD-> error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            $items2 = array();
            $result = array();
			$result2 = array();
            while($r =  mysqli_fetch_assoc($res)){
                $items2[] = $r;
            }
			 while($r2 =  mysqli_fetch_array($res)){
             	$result2[$r2[0]] = $r2[1]; 
            }
			
			
			//aki va la tabla a los contactos tmps y se unen a res
			
			
            foreach($items2 as $value){
                //$result[$value['idCadena']] = Normalizar($value['nombreCadena']);
                array_push($result,
                    array(
                        "id"    =>  $value['idRepLegal'],
                        "label" =>  Normalizar($value["nombreCompleto"]),
                        "value" =>  strip_tags(Normalizar($value["nombreCompleto"]))
                    )
                );
            }
        }
    }else{
        echo "Error al Realizar La Consulta: ".$RBD->error();
    }
    echo json_encode($result);
}
?>