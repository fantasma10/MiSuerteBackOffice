<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$iddireccion = (isset($_POST['iddireccion'])) ? $_POST['iddireccion'] : -1;
$calle = (isset($_POST['calle'])) ? $_POST['calle'] : '';
$nint = (isset($_POST['nint'])) ? $_POST['nint'] : '';
$next = (isset($_POST['next'])) ? $_POST['next'] : '';
$idpais = (isset($_POST['idpais'])) ? $_POST['idpais'] : -1;
$idestado = (isset($_POST['idestado'])) ? $_POST['idestado'] : -1;
$idciudad = (isset($_POST['idciudad'])) ? $_POST['idciudad'] : -1;
$idcolonia = (isset($_POST['idcolonia'])) ? $_POST['idcolonia'] : -1;
$cp = (isset($_POST['cp'])) ? $_POST['cp'] : '';

if($iddireccion > -1 && $calle != '' && $nint != '' && $next != '' && $idpais > -1 && $idestado > -1 && $idciudad > -1 &&$idcolonia > -1 && $cp != ''){
    
    /*$sql = "UPDATE `redefectiva`.`dat_predireccion`
            SET `calleDireccion` =  Ck_calle, `numeroIntDireccion` =  Ck_numInt, `numeroExtDireccion` = Ck_numExt,
            `idPais` =  Ck_idPais, `idcEntidad` =  Ck_idEntidad, `idcMunicipio`  =  Ck_idMunicipio, `idcLocalidad` = 0 , `idcColonia` =  Ck_idColonia,
            `cpDireccion` =  Ck_CP, `idcTipoLocal` = 0 ,
            WHERE `idDireccion` =  Ck_idDireccion;";*/
    //$sql = "INSERT INTO `redefectiva`.`dat_predireccion` (`calleDireccion`,`numeroIntDireccion`,`numeroExtDireccion`,`idPais`,`idcEntidad`,`idcMunicipio`,`idcLocalidad`,`idcColonia`,`cpDireccion`,`idcTipoLocal`,`fecAltaDireccion`,`fecVigenciaDireccion`,`idTipoDireccion`)
    //    VALUES ('$calle','$nint','$next',$idpais,$idestado,$idciudad,0,$idcolonia,'$cp',0,NOW(),NULL,3) ;";
    

    $sql = "CALL `prealta`.`SP_UPDATE_PREDIRECCION`('$calle', '$nint', '$next', $idpais, $idestado, $idciudad, $idcolonia, '$cp', $iddireccion);";
    $WBD->query($sql);
    if($WBD->error() == ''){
        echo "0|Se edito la direccion";
    }else{
        echo "1|No se pudo agregar la direccion".$WBD->error();
    }
    
}


?>