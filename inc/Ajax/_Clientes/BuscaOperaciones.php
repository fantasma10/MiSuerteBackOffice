<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");


$idcorresponsal = (isset($_POST['idCorresponsal'])) ? $_POST['idCorresponsal'] :  -1;
if($idcorresponsal > -1){
    
    $sql = "CALL `redefectiva`.`SP_BUSCA_OPERACIONES_FILTROS`(-1, -1, $idcorresponsal, -1, -1, -1, -1, '0000-00-00', '0000-00-00', 0, 10)";
	$res = $RBD->query($sql);
    $d = "<table  class='tablanueva'>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Referencia</th>
                    <th>Operador</th>
                    <th>Fec. Aplicaci&oacute;n</th>
                    <th>Autorizaci&oacute;n</th>
                    <th>Estatus</th>
                    <th>Proveedor</th>
                    <th>Producto</th>
                </tr>
            </thead>
            <tbody>";
    if($RBD->error() == ''){
        $class = "";
        $band = true;
        if($res != '' && mysqli_num_rows($res) > 0){
            while($row = mysqli_fetch_assoc($res)){
                $class = ($band) ? "renglon1_tabla" : "renglon2_tabla";
                $band = !$band;
                $d.= "<tr class='gradeA'>";
                $d.= "<td>".$row["idsOperacion"]."</td>";
                $d.= "<td>".$row["referencia1Operacion"]."</td>";
                $d.= "<td style='text-align:right;'>".$row["idOperador"]."</td>";
                $d.= "<td style='text-align:center;'>".$row["fecAplicacionOperacion"]."</td>";
                $d.= "<td style='text-align:right;'>".$row["autorizacionOperacion"]."</td>";
                $d.= "<td>".$row["lblEstatus"]."</td>";
                $d.= "<td>".$row["nombreProveedor"]."</td>";
                $d.= "<td>".$row["descProducto"]."</td>";
                $d.="</tr>";
            }
            
            $d.="</tbody></table>
            <br />
			<a href='../../_Reportes/Operaciones/Listado.php'>Ver m&aacute;s Operaciones</a>
            <!--table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td width='18%' align='center' valign='middle'><a href='#' onmouseout='' onmouseover=''></a></td>
                  <td align='center' valign='middle'><a href='#' onclick='goOperaciones();' onmouseout='' onmouseover=''><img src='../../img/btn_ver_detalle1.png' alt='' name='Image2' width='120' height='31' border='0' id='Image2' /></a><a href='#' onmouseout='' onmouseover=''></a></td>
                  <td width='18%' align='center' valign='middle'>&nbsp;</td>
                </tr>
            </table-->";
            echo $d;
        }else{
            echo "<span class='errores'>Lo sentimos pero no se encontraron operaciones</span>";
        }
    }else{
        echo "<span class='errores'>Error al realizar la consulta: ".$RBD->error()."</span>";
    }

}
?>