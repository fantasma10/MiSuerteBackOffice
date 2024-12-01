<?php
	include("../../../inc/config.inc.php");
	include("../../../inc/session.inc.php");
	
	$hora			= (isset($_POST['hora'])) ? $_POST['hora'] : '';
	$estatus		= (isset($_POST['estatus'])) ? $_POST['estatus'] : '';
	$fechaInicial   = (!empty($_POST['fechaInicial'])) ? $_POST['fechaInicial'] : date("Y-m-d");
	$fechaFinal		= (!empty($_POST['fechaFinal'])) ? $_POST['fechaFinal'] : date("Y-m-d");
	$idCadena		= (!empty($_POST['idCadena'])) ? $_POST['idCadena'] : -1;
	
	header("Content-type=application/x-msdownload");
	header("Content-disposition:attachment;filename=OperacionesTotal.xls");
	header("Pragma:no-cache");
	header("Expires:0");
	
	if ( !empty($idCadena) && !empty($fechaInicial) && !empty($fechaFinal) ) {
		$sql = "SELECT C.`nombreCadena`,CO.`nombreCorresponsal`,
		E.`descEmisor`,T.`abrevTranType`,
		O.`fecAplicacionOperacion`,O.`importeOperacion`,
		O.`referencia1Operacion`,O.`respuestaOperacion`
		FROM `redefectiva`.`ops_operacion` as O
		INNER JOIN `redefectiva`.`dat_cadena` as C on C.`idCadena` = O.`idCadena`
		INNER JOIN `redefectiva`.`dat_corresponsal` as CO on CO.`idCorresponsal` = O.`idCorresponsal`
		INNER JOIN `redefectiva`.`cat_emisor` as E on E.`idEmisor` = O.`idEmisor`
		INNER JOIN `redefectiva`.`cat_trantype` as T on T.`idTranType` = O.`idTranType`
		WHERE `fecAltaOperacion` BETWEEN '$fechaInicial' AND '$fechaFinal'
		AND IF($estatus = 1, `idEstatusOperacion` > 0 AND `respuestaOperacion` > 0, 1)
		AND IF($estatus = 0, `idEstatusOperacion` = 0 AND `respuestaOperacion` = 0, 1)
		AND IF($idCadena > -1,  O.`idCadena` = $idCadena, 1)
		AND O.`idCadena` != 109
		ORDER BY C.`nombreCadena`, DATE(O.`fecAplicacionOperacion`), TIME(O.`fecAplicacionOperacion`) DESC;";
		$res = $RBD->query($sql);
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
				$d .= "<th>Importe</th>";
				$d .= "<th>Tran Type</th>";
				$d .= "<th>Referencia</th>";
				$d .= "</tr>";
				$d .= "</thead>";
				$d .= "<tbody>";
				while( list($idcad,$idcorr,$idemisor,$idtrantype,$fecaplicacion,$importe,$referencia,$respuesta ) = mysqli_fetch_array($res)){
					$class = ($band) ? "renglon1_tabla" : "renglon2_tabla";
					$band = !$band;
					$d .= "<tr>";
					$d .= "<td>$fecaplicacion</td>";
					$d .= "<td>$idcad</td>";
					$d .= "<td>$respuesta</td>";
					$d .= "<td>$idcorr</td>";
					$d .= "<td>$idemisor</td>";
					$d .= "<td>$".number_format($importe,2)."</td>";
					$d .= "<td>$idtrantype</td>";
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
