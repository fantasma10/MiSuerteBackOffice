
<?php
 
include ('../../../inc/config.inc.php');
include ('../../libs/cypher.php');
 
$nIdPais = $_POST['pais'];//

$nIdRegimen = $_POST['regimen'];//2
$sRFC =  strtoupper($_POST['rfc']);//3
$Telefono = $_POST['telefono'];//4
$sTelefono = preg_replace("/[^0-9]/","", $Telefono);

//echo $sTelefono;
$sNombre = strtoupper($_POST['nombre']);//6
$sPaterno = strtoupper($_POST['paterno']);//7
$sMaterno = strtoupper($_POST['materno']);//8
$sNombreCompleto = $sNombre . " " . $sPaterno . " " . $sMaterno;//5
$sCodigoValidacion = $codvalidacion; //$_POST["RFC"];//9
$nIdUsuario = $_POST['usr'];//$_POST["RFC"];//10
$nIdOrigen = 1;//11
$sEmail = $_POST['mail'];//12
//""

$sQuery = "CALL `afiliacion`.`SP_MODCERO_GUARDAR`('$nIdPais', '$nIdRegimen', '$sRFC', '$sEmail', '$sTelefono', '$sNombreCompleto', '$sNombre', '$sPaterno', '$sMaterno', '$sCodigoValidacion', '$nIdUsuario', '$nIdOrigen');";

$resultPais = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultPais);
 

               
$incremental = $DATS['nIdIncremental'];
$correo = $DATS['sEmail'];
$nombre = $DATS['sNombreContacto'];
$codigoval = $DATS['sCodigoValidacion'];




          $json = json_encode(array(
              "incr"=>"$incremental",
              "mail"=>"$correo",
              "nombre"=>"$nombre",
              "codigoval"=>"$codigoval"
                                   
                                   
                                   ));   

//echo $mensaje;
//echo $codigo;

echo $json;


//mysqli_close($conn);
?>
 