
<?php
 
include ('../../../inc/config.inc.php');



$incrId = $_POST['incr'];//4
$Telefono = $_POST['telefono'];//4

$sTelefono = preg_replace("/[^0-9]/","", $Telefono);
$sNombre = UTF8_DECODE(strtoupper($_POST['nombre']));//6
$sPaterno = UTF8_DECODE(strtoupper($_POST['paterno']));//7
$sMaterno = UTF8_DECODE(strtoupper($_POST['materno']));//8
$sEmail = $_POST['mail'];//12
//""
$sQuery = "CALL `afiliacion`.`SP_MODCERO_ACTUALIZAR`($incrId,'$sEmail','$sNombre', '$sPaterno', '$sMaterno', '$sTelefono');";
$result = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($result);
 

                
$idcontacto = $DATS['idcontacto'];
$RFC = $DATS['RFC'];


//$json = json_encode(array("inc"=>"$incrId","tel"=>"$sTelefono","nom"=>"$sNombre","pat"=>"$sPaterno","mat"=>"$sMaterno","mail"=>"$sEmail",));

        $json = json_encode(array("idcont"=>"$idcontacto","rfc"=>"$RFC"));   

//echo $mensaje;
//echo $codigo;

echo $json;

//mysqli_close($conn);
?>
 