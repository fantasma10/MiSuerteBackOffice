
<?php
       
include ('../../../inc/config.inc.php');

$rfc = $_POST['rfc'];//'HEAA8004257E0';

$sQuery = "call afiliacion.SP_REPRESENTANTELEGAL_BUSCAR('$rfc');";

$resultRL = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultRL);
               
               
$rfc            =    $DATS['sRFC'];
$nombre         =    $DATS['sNombreRepresentante'];
$paterno        =    $DATS['sPaternoRepresentante'];
$materno        =    $DATS['sMaternoRepresentante'];
$fechnac        =    $DATS['dFechaNacimiento'];
$idnac          =    $DATS['nIdNacionalidad'];
$curp           =    $DATS['sCURP'];
$tipoid         =    $DATS['nIdTipoIdentificacion'];
$numid          =    $DATS['sNumeroIdentificacion'];
$telefono       =    $DATS['sTelefono'];
$mail           =    $DATS['sEmail'];
$calle          =    $DATS['sCalle'];
$numint         =    $DATS['sNumInterno'];
$numext         =    $DATS['nNumExterno'];
$cp             =    $DATS['nCodigoPostal'];
$idcolonia      =    $DATS['nNumColonia'];
$idmunicip      =    $DATS['nNumMunicipio'];
$idestado       =    $DATS['nIdEstado'];
$idocupac       =    $DATS['nIdOcupacion'];
$iddocid        =    $DATS['nIdDocIdentificacion'];
$iddocpod       =    $DATS['nIdDocPoder'];
$expuesto       =    $DATS['bExpuesto'];

//bExpuesto

  $RL = json_encode(array(
              "rfc" => "$rfc",
             "nombre" => "$nombre",
             "paterno" => "$paterno",
             "materno" => "$materno",
             "fnac" => "$fechnac",
             "idnac" => "$idnac",
             "curp" => "$curp",
             "tipoid" => "$tipoid",
             "numid" => "$numid",
             "telefono" => "$telefono",
             "mail" => "$mail",
             "calle" => "$calle",
             "numint" => "$numint",
             "numext" => "$numext",
             "cp" => "$cp",
             "idcol" => "$idcolonia",
             "idmun" => "$idmunicip",
             "idest" => "$idestado",
             "idocup" => "$idocupac",
             "idocid" => "$iddocid",
             "idocpod" => "$iddocpod",
            "expuesto" => "$expuesto",
             
       ));   

echo $RL;

?>
 
