<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idcorresponsal = (isset($_POST['idCorresponsal'])) ? $_POST['idCorresponsal'] :  -1;

if($idcorresponsal > -1){
    $sql = "CALL `redefectiva`.`SP_LOAD_REMESAS`($idcorresponsal, 0);";
    
    
    $res = $RBD->query($sql);
    if($RBD->error() == ''){
        $class = "";
        $band = true;
        if($res != '' && mysqli_num_rows($res) > 0){
            $d = "<table  width='90%' border='0' cellspacing='0' cellpadding='0' style='margin-left:5%'><thead><tr width='8%' align='center' valign='middle' class='encabezado_tabla'><th>Fecha Env&iacute;o</th><th>Monto</th><th>Estatus</th><th>Proveedor</th></tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($res)){

                $estatus    = $row["ESTATUS"];
                $monto      = $row["MONTO"];
                $fecenvio   = $row["FECENVIO"];
                $prov       = $row["PROV"];

                $class = ($band) ? "renglon1_tabla" : "renglon2_tabla";
                $band = !$band;
                $d.="<tr align='center' valign='middle' class='$class'>
                        <td>$fecenvio</td>
                        <td align='right'>
                            <span style='float:left;'>$</span>".number_format($monto,2)."
                        </td>
                        <td>$estatus</td>
                        <td>$prov</td>
                    </tr>";
            }
            $d.="</tbody>";
            echo $d;
        }else{
            echo "<span class='errores'>Lo sentimos pero no se encontraron remesas</span>";
        }
    }else{
        echo "<span class='errores'>Error al realizar la consutlta: ".$RBD->error()."</span>";
    }
}
?>