<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$id= (isset($_POST['id'])) ? $_POST['id'] : -1;


if($id > -1){
    $sql = "SELECT P.`nombreContacto`,P.`apPaternoContacto`,P.`apMaternoContacto`,P.`telefono1`,P.`extTelefono1`,P.`correoContacto`,I.`idcTipoContacto`
        FROM `prealta`.`dat_precontacto` as P
        INNER JOIN `prealta`.`inf_precorresponsalcontacto` as I on I.`idContacto` = P.`idContacto`
        WHERE `idEstatusCorCont` = 0 AND I.`idCorresponsalContacto` = $id ;";
        
    $res = $RBD->query($sql);
    if($RBD->error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            list($nombre,$paterno,$materno,$telefono,$ext,$correo,$tipo ) = mysqli_fetch_array($res);
            echo utf8_encode("$nombre,$paterno,$materno,$telefono,$ext,$correo,$tipo");
        }
    }else{
        echo "Error al realizar la consulta: ".$RBD->error();
    }
}


?>