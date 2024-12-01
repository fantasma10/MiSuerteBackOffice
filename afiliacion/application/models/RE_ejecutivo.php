<?php

        
//include ('../../inc/config.inc.php');

$htmlEjecutivo = '';

$tipEjec = 5;

	$sQuery = "CALL `redefectiva`.`SP_LOAD_EJECUTIVOS`('$tipEjec','');";
$resultEjecutivo = $WBD->query( $sQuery );
 while($ejecutivo  = mysqli_fetch_array($resultEjecutivo)){
    $htmlEjecutivo .= '<option value="'.$ejecutivo['idUsuario'].'">'.utf8_encode($ejecutivo['nombreCompleto']).'</option>';
 }

	       /* $resultEjecutivo = mysqli_query($rconn,"CALL `redefectiva`.`SP_LOAD_EJECUTIVOS`('$tipEjec','')");
            while($ejecutivo  = mysqli_fetch_array($resultEjecutivo,MYSQLI_ASSOC)){
             $htmlEjecutivo .= '<option value="'.$ejecutivo['idUsuario'].'">'.utf8_encode($ejecutivo['nombreCompleto']).'</option>';
             }


mysqli_close($rconn);
*/



?>