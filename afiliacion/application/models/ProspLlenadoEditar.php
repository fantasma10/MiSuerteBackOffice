
<?php
       
include ('../../../inc/config.inc.php');

$incr = $_POST["idincr"];//'3';
//""
$sQuery = "call afiliacion.SP_GET_PROSPECTOLLENADOEDITAR($incr);";
$resultpros =  $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultpros);
               
               
$idincr     =    $DATS['nIdIncremental'];
$rfc        =    $DATS['sRFC'];
$pais       =    $DATS['nIdPais'];
$regimen    =    $DATS['nIdRegimen'];
$email      =    utf8_encode($DATS['sEmail']);
$nombre     =    utf8_encode($DATS['sNombreContacto']);
$paterno    =    utf8_encode($DATS['sPaternoContacto']);
$materno    =    utf8_encode($DATS['sMaternoContacto']);
$nomcomp    =    utf8_encode($DATS['nombreCompleto']);
$tel        =    $DATS['sTelefono'];
$codval     =    $DATS['bCorreoValidado'];
$codigoval  =    $DATS['sCodigoValidacion'];
$telefono   =  "(".substr($tel, 0, 2).") ".substr($tel, 2, 2)."-".substr($tel,4,2)."-".substr($tel,6,2)."-".substr($tel,8);
          $json = json_encode(array(
              "incr" => "$idincr",
              "rfc"  => "$rfc",
              "pais" => "$pais",
              "reg"  => "$regimen",
              "mail" => "$email",
              "nom"  => "$nombre",
              "pat"  => "$paterno",
              "mat"  => "$materno",
              "tel"  => "$telefono",
              "cod"  => "$codval",
              "cval" => "$codigoval",
              "ncom" => "$nomcomp"
       
          ));   



echo $json;

//mysqli_close($rconn);
?>
 
