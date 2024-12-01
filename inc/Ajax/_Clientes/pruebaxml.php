<?php



include("../../config.inc.php");
include("../../session.ajax.inc.php");

     $sql = "SELECT CONVERT(`XML` USING utf8)
            FROM `redefectiva`.`dat_precadena`
            WHERE `idPreClave` = ".$_SESSION['idPreCadena']." ;";
    $res =  $RBD->query($sql);
    
    if($RBD->error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            $xml = simplexml_load_string($r[0]);
             echo "<br />........................</br>";
            print_r($xml);
        }
    }
?>