<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idcolonia = isset($_POST['idcolonia']) ? $_POST['idcolonia'] : -1;

$sql = "CALL `prealta`.`SP_LOAD_CODIGO_POSTAL`('$idcolonia');";
$res = $RBD->query($sql);
if($res != '' && mysqli_num_rows($res) > 0){
    $r = mysqli_fetch_array($res);
    echo $r[0];
}


?>