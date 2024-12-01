
<?php
       
include ('../../../inc/config.inc.php');

$idcontacto = $_POST["contacto"];//'3';


$sQuery = "call afiliacion.SP_PROSPECTO_CARGA_CONTACTOEDITAR($idcontacto);";
 $resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);
               
             
$idcont     =    $DATS['nIdContacto'];
$nombre     =    utf8_encode($DATS['sNombreContacto']);
$paterno    =    utf8_encode($DATS['sPaternoContacto']);
$materno    =    utf8_encode($DATS['sMaternoContacto']);
$tel        =    $DATS['sTelefono'];
$ext        =    $DATS['sExtTelefono'];
$cel        =    $DATS['sCelular'];
$email      =    $DATS['sEmailContacto'];
$descr     =    utf8_encode($DATS['sDescripcionContacto']);
$tipo  =    $DATS['nIdTipoContacto'];
$telmask  =  "(".substr($tel, 0, 2).") ".substr($tel, 2, 2)."-".substr($tel,4,2)."-".substr($tel,6,2)."-".substr($tel,8);
$celmask  =  "(".substr($cel, 0, 2).") ".substr($cel, 2, 2)."-".substr($cel,4,2)."-".substr($cel,6,2)."-".substr($cel,8);




          $cont = json_encode(array(
              "idct" => "$idcont",
              "nom"  => "$nombre",
              "pat"  => "$paterno",
              "mat"  => "$materno",
              "tel"  => "$telmask",
              "ext"  => "$ext",
              "cel"  => "$celmask",
              "mail"  => "$email",
              "desc" => "$descr",
              "tipo" => "$tipo"
       
          ));   



echo $cont;
?>
 
