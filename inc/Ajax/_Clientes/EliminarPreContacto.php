<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$id= (isset($_POST['id'])) ? $_POST['id'] : -1;

if($id > -1){
    $oCadena = new XMLPreCadena($RBD,$WBD);
    $oCadena->load($_SESSION['idPreCadena']);
    $oCadena->setID($_SESSION['idPreCadena']);
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

    if($oCadena->EliminarContacto($id)){
        echo utf8_encode("0|Se eliminó el contacto");
    }else{
        echo "1|No se pudo eliminar el contacto";
    }
}
?>