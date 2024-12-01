<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$numcta =  (isset($_POST['numcta'])) ? $_POST['numcta'] : -1 ;

if($numcta != ''){

    $sql = "CALL `redefectiva`.`SP_LOAD_MOVIMIENTOS`('$numcta', -1, '', '', -1, 0, 10);";
    $res = $RBD->query($sql);
    if($RBD->error() == ''){
        $class = "";
        $band = true;
        if($res != '' && mysqli_num_rows($res) > 0){
            $d = "<table  width='90%' border='0' cellspacing='0' cellpadding='0' style='margin-left:5%'><thead><tr width='8%' align='center' valign='middle' class='encabezado_tabla'><th>ID Mov.</th><th>Folio</th><th>Fecha Aplicaci&oacute;n</th><th>Tipo de Mov.</th><th>Cargo</th><th>Abono</th><th>Saldo Final</th></tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($res)){
                $class = ($band) ? "renglon1_tabla" : "renglon2_tabla";
                $band = !$band;
                $d.= "<tr align='center' valign='middle' class='$class'>";
                $d.= "<td>".$row["idsMovimiento"]."</td>";
                $d.= "<td>".$row["idsOperacion"]."</td>";
                $d.= "<td>".$row["fecAppMov"]."</td>";
                $d.= "<td style='text-align:left;'>".$row["descTipoMovimiento"]."</td>";
                $d.= "</td>
                    <td align='right'><span style='float:left;margin-left:20px;'>
                        $</span>".number_format($row["cargoMov"],2)."
                    </td>
                    <td align='right'>
                        <span style='float:left;margin-left:20px;'>$</span>".number_format($row["abonoMov"],2)."
                    </td>
                    <td align='right'>
                        <span style='float:left;margin-left:20px;'>$</span>".number_format($row["saldoFinal"],2)."
                        </td>
                </tr>";
            }
            $d.="</tbody></table>
            <br />
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td width='18%' align='center' valign='middle'><a href='#' onmouseout='' onmouseover=''></a></td>
                  <td align='center' valign='middle'><a href='#' onclick='goMovimientos(-1);' onmouseout='' onmouseover=''><img src='../../img/btn_ver_detalle1.png' alt='' name='Image2' width='120' height='31' border='0' id='Image2' /></a><a href='#' onmouseout='' onmouseover=''></a></td>
                  <td width='18%' align='center' valign='middle'>&nbsp;</td>
                </tr>
            </table>";
            echo $d;
        }else{
            echo "<span class='errores'>Lo sentimos pero no se encontraron movimientos</span>";
        }
    }else{
        echo "<span class='errores'>Error al realizar la consutlta:".$RBD->error()."</span>";
    }
}
?>