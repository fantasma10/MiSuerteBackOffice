<?php
include("../../../inc/config.inc.php");
include("../../../inc/session.inc.php");

$hora			= (isset($_POST['hra'])) ? $_POST['hra'] : '';
$estatus		= (isset($_POST['estatus'])) ? $_POST['estatus'] : '';
$fechaInicial   = (!empty($_POST['fechaInicial'])) ? $_POST['fechaInicial'] : date("Y-m-d");
$fechaFinal		= (!empty($_POST['fechaFinal'])) ? $_POST['fechaFinal'] : date("Y-m-d");
$cadena			= (($_POST['cadena'])) ? $_POST['cadena'] : -1;

if($hora != ''){
    $res = $RBD->query("CALL redefectiva.SP_BUSCA_OPERACIONES_HORA($hora, '$fechaInicial', '$fechaFinal', $estatus, $cadena)");
	//var_dump("CALL redefectiva.SP_BUSCA_OPERACIONES_HORA($hora, '$fechaInicial', '$fechaFinal', $estatus, $cadena)");
	if($RBD->error() == ''){
        $class = "";
        $band = true;
        if($res != '' && mysqli_num_rows($res) > 0){
			$d = "<table class=\"tablacentrada\" style=\"border: 1px solid rgb(226, 226, 226); font-size:12px;\">";
			$d .= "<thead>";
			$d .= "<tr>";
			$d .= "<th style=\"padding:10px; width:110px; border: 1px solid rgb(226, 226, 226);\">Fecha</th>";
			$d .= "<th style=\"padding:10px; border: 1px solid rgb(226, 226, 226);\">Comercio</th>";
			$d .= "<th style=\"padding:10px; width:110px; border: 1px solid rgb(226, 226, 226);\"\">Cod. Res</th>";
			$d .= "<th style=\"padding:10px; border: 1px solid rgb(226, 226, 226);\">Corresponsal</th>";
			$d .= "<th style=\"padding:10px; border: 1px solid rgb(226, 226, 226);\">Emisor</th>";
			$d .= "<th style=\"padding:10px; border: 1px solid rgb(226, 226, 226);\">Proveedor</th>";
			$d .= "<th style=\"padding:10px; width:110px; border: 1px solid rgb(226, 226, 226);\">Importe</th>";
			$d .= "<th style=\"padding:10px; border: 1px solid rgb(226, 226, 226);\">Tran Type</th>";
			$d .= "<th style=\"padding:10px; border: 1px solid rgb(226, 226, 226);\">Referencia</th>";
			$d .= "</tr>";
			$d .= "</thead>";
			$d .= "<tbody>";
			while( list($idcad,$idcorr,$idemisor,$idtrantype,$fecaplicacion,$importe,$referencia,$respuesta,$nomProveedor) = mysqli_fetch_array($res)){
				$class = ($band) ? "renglon1_tabla" : "renglon2_tabla";
				$band = !$band;
				$d .= "<tr>";
				$d .= "<td style=\"border: 1px solid rgb(226, 226, 226);\">$fecaplicacion</td>";
				$d .= "<td style=\"border: 1px solid rgb(226, 226, 226);\">$idcad</td>";
				$d .= "<td style=\"border: 1px solid rgb(226, 226, 226);\">$respuesta</td>";
				$d .= "<td style=\"border: 1px solid rgb(226, 226, 226);\">$idcorr</td>";
				$d .= "<td style=\"border: 1px solid rgb(226, 226, 226);\">$idemisor</td>";
				$d .= "<td style=\"border: 1px solid rgb(226, 226, 226);\">$nomProveedor</td>";
				$d .= "<td align='right' style=\"border: 1px solid rgb(226, 226, 226);\"><span style='float:left;'>$</span>".number_format($importe,2)."</td>";
				$d .= "<td style=\"border: 1px solid rgb(226, 226, 226);\">$idtrantype</td>";
				$d .= "<td style=\"border: 1px solid rgb(226, 226, 226);\">$referencia</td>";
				$d .= "</tr>";
			}			
			$d .= "</tbody>";
			$d .= "</table>";
            echo utf8_encode($d);
        }else{
            echo "<label class='subtitulo_contenido'>Lo sentimos pero no se encontraron resultados</label>";
        }
    }else{
        echo "Error al realizar la consulta: ".$RBD->error();
    }
}

?>