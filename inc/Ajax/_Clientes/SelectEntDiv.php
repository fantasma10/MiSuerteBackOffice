<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idbanco = (isset($_POST['idBanco'])) ? $_POST['idBanco'] : -1;
if($idbanco > -1){
    $sql = "SELECT `id`,`NombreEntidad`,`Division`
    FROM `data_info`.`banco_division`
    WHERE `idBanco` = $idbanco ";
    $d = "<select name='ddlEntDiv' id='ddlEntDiv'>";
    $res = $RBD->query($sql);
    if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                    while($r = mysqli_fetch_array($res)){
                            $d.= "<option value='$r[0]'>$r[1] $r[2]</option>";
                    }
            }else{
                $d.= "<option>No tiene</option>";
            }
    }else{
        $d.="<option>No tiene</option>";
    }
    $d.="</select>";
   
    echo utf8_encode($d);
}
?>