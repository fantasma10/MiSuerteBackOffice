
<?php
        
//include ('../../inc/config.inc.php');


$htmlPais = '';
$orden = '';
$sQuery = "CALL `redefectiva`.`SP_PAISES_NACIONALIDAD_LISTA`(0);";
$reslt = $RBD->query( $sQuery );
    while($pais = mysqli_fetch_array($reslt)){
 $htmlPais .= '<option value="'.$pais['idPais'].'">'.utf8_encode($pais['nombre']).'</option>';   
}
	

//mysqli_close($rconn);
//var_dump($resultPais);

?>
 
    