
<?php
       
include ('../../../inc/config.inc.php');

$sRFC = /*"HEAA8004257E2";*/ $_POST["RFC"];
//""
$sQuery = "CALL `afiliacion`.`SP_VALIDAR_RFC`('$sRFC');";
$resultPais = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultPais);
               
               
$mensaje = $DATS['sMensaje'];
$codigo = $DATS['nCodigo'];



          $json = json_encode(array("msg"=>"$mensaje","cod"=>"$codigo"));   

//echo $mensaje;
//echo $codigo;

echo $json;

mysqli_close($rconn);
?>
 
