<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$numcta =  (isset($_POST['numcta'])) ? $_POST['numcta'] : -1 ;

if($numcta != ''){
    $sql = "CALL redefectiva.SP_LOAD_MOVIMIENTOS('$numcta', -1, -1, -1,'', '', 7, 0, 10, @cr,@tr);";
    //var_dump("sql: $sql");
	$res = $RBD->query($sql);
    if($RBD->error() == ''){
        $class = "";
        $band = true;
        if($res != '' && mysqli_num_rows($res) > 0){
            $d = "<table class='tablanueva tabla-inline'>
                    <thead>
                        <tr>
                            <th style='width: 14%;'>ID dep&oacute;sito</th>
                            <th style='width: 14%;'>Importe</th>
                            <th style='width: 14%;'>Fecha Captura</th>
                            <th style='width: 14%;'>Empleado</th>
                            <th style='width: 14%;'>Fecha Aplicaci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody>";
            while($row = mysqli_fetch_assoc($res)){
                $idmov = $row["idsMovimiento"];
                $salini = $row["saldoInicial"];
                $salfin = $row["saldoFinal"];
                $fecmov = $row["fecAppMovDate"];
                $fecaplicacion = $row["fecAppMov"];
                $idempleado = $row["idEmpleado"];

                $class = ($band) ? "renglon1_tabla" : "renglon2_tabla";
                $band = !$band;
                $imp = $salfin - $salini;
                $d.="<tr align='center' valign='middle' class='$class'><td style='width: 14%;'>$idmov</td><td class='td-inline' style='width: 14%; text-align: right;'>$".number_format($imp,2)."</td><td style='width: 14%;'>$fecmov</td><td style='width: 14%;'>";

                $nombreemp = (!empty($row["nombreEmpleado"]))? $row["nombreEmpleado"] : " N/A ";
               
                $d.="$nombreemp</td><td style='width: 14%;'>$fecaplicacion</td></tr>";
            }
            $d.="</tbody></table>
            <br />
			<a href='../../_Reportes/Movimientos/Listado.php'>Ver m&aacute;s Dep&oacute;sitos</a>
            <!--table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td width='18%' align='center' valign='middle'><a href='#' onmouseout='' onmouseover=''></a></td>
                  <td align='center' valign='middle'><a href='#' onclick='goMovimientos(7);' onmouseout='' onmouseover=''><img src='../../img/btn_ver_detalle1.png' alt='' name='Image2' width='120' height='31' border='0' id='Image2' /></a><a href='#' onmouseout='' onmouseover=''></a></td>
                  <td width='18%' align='center' valign='middle'>&nbsp;</td>
                </tr>
            </table-->";
            echo $d;
        }else{
            echo "<span class='errores'>Lo sentimos pero no se encontraron dep&oacute;sitos</span>";
        }
    }else{
        echo "<span class='errores'>Error al realizar la consutlta: ".$RBD->error()."</span>";
    }
}
?>