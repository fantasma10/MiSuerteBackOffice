<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$rfc = (isset($_POST['rfc'])) ? $_POST['rfc'] : '';

if($rfc !=  ''){
    $sql = "SELECT `razonSocial`,``";
}
?>