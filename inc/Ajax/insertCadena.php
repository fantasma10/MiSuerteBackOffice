<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
include("../../inc/session.ajax.inc.php");
global $WBD;
$error = false;
session_start();
if (!isset($_POST["nombreCadena"]) && !isset($_POST["selectGiro"])) {
    $error = true;
} else {
    $nombreCadena = $_POST["nombreCadena"];
    $giro = $_POST["selectGiro"];
    $numeroTelefono = $_POST["numeroTelefono"];
    $email = $_POST["email"];
    $idUser = $_SESSION['idU']; //"idUsuario" $_SESSION['idU']

    $WBD->query("CALL `redefectiva`.`sp_insert_cadena`($giro,'$nombreCadena','$numeroTelefono','$email',$idUser,$idUser)");

    if ($WBD->error()) {
        $error = true;
    }
    echo json_encode($error);
}
