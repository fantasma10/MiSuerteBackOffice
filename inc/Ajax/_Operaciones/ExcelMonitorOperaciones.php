<?php
	include("../../../inc/config.inc.php");
	include("../../../inc/session.inc.php");
	
	$hora			= (isset($_POST['hora'])) ? $_POST['hora'] : '';
	$estatus		= (isset($_POST['estatus'])) ? $_POST['estatus'] : '';
	$fechaInicial   = (!empty($_POST['fechaInicial'])) ? $_POST['fechaInicial'] : date("Y-m-d");
	$fechaFinal		= (!empty($_POST['fechaFinal'])) ? $_POST['fechaFinal'] : date("Y-m-d");
	$idCadena		= (!empty($_POST['idCadena'])) ? $_POST['idCadena'] : -1;
	
	header("Content-type=application/x-msdownload");
	header("Content-disposition:attachment;filename=Operaciones.xls");
	header("Pragma:no-cache");
	header("Expires:0");
	
	if ( !empty($idCadena) && !empty($fechaInicial) && !empty($fechaFinal) ) {
		$res = $RBD->query("CALL redefectiva.SP_BUSCA_OPERACIONES_HORA($hora, '$fechaInicial', '$fechaFinal', $estatus, $idCadena)");
		if($RBD->error() == ''){
			$class = "";
			$band = true;
			if($res != '' && mysqli_num_rows($res) > 0){
				$d = "<table>";
				$d .= "<thead>";
				$d .= "<tr>";
				$d .= "<th>Fecha</th>";
				$d .= "<th>Comercio</th>";
				$d .= "<th>Cod. Res</th>";
				$d .= "<th>Corresponsal</th>";
				$d .= "<th>Emisor</th>";
				$d .= "<th>Proveedor</th>";
				$d .= "<th>Importe</th>";
				$d .= "<th>Tran Type</th>";
				$d .= "<th>Referencia</th>";
				$d .= "</tr>";
				$d .= "</thead>";
				$d .= "<tbody>";
				while( list($idcad,$idcorr,$idemisor,$idtrantype,$fecaplicacion,$importe,$referencia,$respuesta,$nomProveedor) = mysqli_fetch_array($res)){
					$class = ($band) ? "renglon1_tabla" : "renglon2_tabla";
					$band = !$band;
					$d .= "<tr>";
					$d .= "<td>$fecaplicacion</td>";
					$d .= "<td>".htmlentities($idcad)."</td>";
					$d .= "<td>$respuesta</td>";
					$d .= "<td>".htmlentities($idcorr)."</td>";
					$d .= "<td>".htmlentities($idemisor)."</td>";
					$d .= "<td>".htmlentities($nomProveedor)."</td>";
					$d .= "<td>$".number_format($importe,2)."</td>";
					$d .= "<td>".htmlentities($idtrantype)."</td>";
					$d .= "<td style=\"mso-number-format:\@;\">$referencia</td>";
					$d .= "</tr>";
				}			
				$d .= "</tbody>";
				$d .= "</table>";
				echo utf8_encode($d);		
			}else{
				echo "Lo sentimos pero no se encontraron resultados";
			}
		}else{
			echo "Error al realizar la consulta: ".$RBD->error();
		}
	}
?>
