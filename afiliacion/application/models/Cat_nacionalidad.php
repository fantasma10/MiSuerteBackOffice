
<?php
        
//include ('../../inc/config.inc.php');


$orden = 1;
$htmlnacionalidad = '';

	$sQuery = "CALL `redefectiva`.`SP_PAISES_NACIONALIDAD_LISTA`($orden);";
$resultnacionalidad = $RBD->query( $sQuery );
 while($nacionalidad  = mysqli_fetch_array($resultnacionalidad)){
   $htmlnacionalidad .= '<option value="'.$nacionalidad['idPais'].'">'.utf8_encode($nacionalidad['nacionalidad']).'</option>';
 }

	       /* $resultPais = mysqli_query($rconn,"CALL `redefectiva`.`SP_PAISES_NACIONALIDAD_LISTA`($orden)");
         while($nacionalidad  = mysqli_fetch_array($resultPais,MYSQLI_ASSOC)){
             $htmlnacionalidad .= '<option value="'.$nacionalidad['idPais'].'">'.utf8_encode($nacionalidad['nacionalidad']).'</option>';
             }
            mysqli_close($rconn);*/

?>
 
