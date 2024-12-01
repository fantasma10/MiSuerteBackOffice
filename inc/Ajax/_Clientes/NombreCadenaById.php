<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$cadena = (isset($_POST['cadena']))?$_POST['cadena']:-1;

$sql = "SELECT `nombreCadena` FROM `redefectiva`.`dat_cadena` WHERE `idCadena` = $cadena ;";
$res = $RBD->query($sql);
if($RBD->error() == ''){
    if($res != '' && mysqli_num_rows($res) > 0){
        $r = mysqli_fetch_array($res);
        echo $r[0];
    }else{
        echo "Lo Sentimos Pero No Se Encontraron Resultados";
    }
}else{
    echo "Error al realizar la consulta: ".$RBD->error();
}
?>