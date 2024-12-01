<?php
        
//include ('../../inc/config.inc.php');


$htmlTipoSociedad = '';
	
	$sQuery = "CALL `redefectiva`.`SP_CAT_TIPOSOCIEDAD_LISTA`();";
$resultTipoSociedad = $RBD->query( $sQuery );
 while($sociedad  = mysqli_fetch_array($resultTipoSociedad)){
  $htmlTipoSociedad .= '<option value="'.$sociedad['idTipoSociedad'].'">'.utf8_encode($sociedad['descTipoSociedad']).'</option>';
 }	
	   
/*
         $resultTipoSociedad = mysqli_query($rconn,"CALL `redefectiva`.`SP_CAT_TIPOSOCIEDAD_LISTA`()");
            while($sociedad  = mysqli_fetch_array($resultTipoSociedad,MYSQLI_ASSOC)){
             $htmlTipoSociedad .= '<option value="'.$sociedad['idTipoSociedad'].'">'.utf8_encode($sociedad['descTipoSociedad']).'</option>';
             }

mysqli_close($rconn);*/


?>
