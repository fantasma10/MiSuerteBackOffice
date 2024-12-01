<?php
        
include ('../../../inc/config.inc.php');


$sClabe = $_POST['clabe'];
	//echo $sClabe;
   $sQuery = "CALL `redefectiva`.`SP_FIND_BANCO_CLABE`('$sClabe');";
    $resultBanco = $RBD->query($sQuery);
    $banco  = mysqli_fetch_array($resultBanco);

//$resultBanco = mysqli_query($conn,$sQuery);
//$banco  = mysqli_fetch_array($resultBanco,MYSQLI_ASSOC);

                $idbanco = $banco['idBanco'];
                $nombreBanco = $banco['nombreBanco'];
                $registros = $banco['rows'];


        $bancos =  json_encode(array("idbanco" => "$idbanco","nombrebanco" => "$nombreBanco","records"=>"$registros" ));
//printf("Error: %s\n", mysqli_error($conn));
        echo $bancos ;

//mysqli_close($rconn);


?>

