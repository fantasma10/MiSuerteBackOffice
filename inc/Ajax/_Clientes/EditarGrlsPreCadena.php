<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$idpreclave = (isset($_POST['idpreclave'])) ? trim($_POST['idpreclave']) : 9;
$grupo = (isset($_POST['idgrupo'])) ? trim($_POST['idgrupo']) : '';
$referencia = (isset($_POST['idref'])) ? trim($_POST['idref']) : '';
$tel1 = (isset($_POST['tel1'])) ? trim($_POST['tel1']) : '';
$mail = (isset($_POST['mail'])) ? trim($_POST['mail']) : '';

//if ( $idpreclave > -1 && $grupo > -1 && $referencia > -1 ){

    $oCadena = new XMLPreCadena($RBD,$WBD);
    $oCadena->load($_SESSION['idPreCadena']);
    $oCadena->setIdGrupo($grupo);
    $oCadena->setIdReferencia($referencia);
    $oCadena->setTel1($tel1);
    $oCadena->setCorreo($mail);

    $oCadena->setPreRevisadoCargos(false);
    $oCadena->setPreRevisadoGenerales(false);
    $oCadena->setPreRevisadoDireccion(false);
    $oCadena->setPreRevisadoContactos(false);
    $oCadena->setPreRevisadoEjecutivos(false);
    $oCadena->setRevisadoCargos(false);
    $oCadena->setRevisadoGenerales(false);
    $oCadena->setRevisadoDireccion(false);
    $oCadena->setRevisadoContactos(false);
    $oCadena->setRevisadoEjecutivos(false);

    if ( $oCadena->GuardarXML() ) {
        $oCadena->CalcularPorcentaje();
        echo utf8_encode("0|Se actualizó la información");
    } else {
        echo utf8_encode("1|No se pudo actualizar la información");
    }
    
//}





?>