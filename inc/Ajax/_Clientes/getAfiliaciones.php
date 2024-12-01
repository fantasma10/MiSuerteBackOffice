<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$idCadena = (isset($_POST['cadenaID'])) ? $_POST['cadenaID'] : '';

if ( $idCadena != "" ) {
	$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, -1, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);
	$preCargos = $oPreCargo->cargarTodos();
	//var_dump("idCadena: $idCadena");
	/*echo "<pre>";
	print_r($preCargos);
	echo "</pre>";*/
	if ( count($preCargos) > 0 ) {
		$resultado = "";
		$resultado .= "<table class=\"tablarevision-hc\" id=\"afiliaciones\">";
        $resultado .= "<thead class=\"theadtablita\">";
        $resultado .= "<tr>";
       	$resultado .= "<th class=\"theadtablitauno\">Concepto</th>";
        $resultado .= "<th class=\"theadtablita\">Importe</th>";
        $resultado .= "<th class=\"theadtablita\">Fecha de Inicio</th>";
        $resultado .= "<th class=\"theadtablita\">Observaciones</th>";
        $resultado .= "<th class=\"theadtablita\">Configuraci&oacute;n</th>";
        $resultado .= "<th class=\"acciones\">Editar</th>";
        $resultado .= "<th class=\"acciones\">Eliminar</th>";
        $resultado .= "</tr>";
        $resultado .= "</thead>";
        $resultado .= "<tbody class=\"tablapequena\">";
		foreach ( $preCargos as $preCargo ) {
			$resultado .= "<tr>";
			if ( !preg_match('!!u', $preCargo['nombreConcepto']) ) {
				$preCargo['nombreConcepto'] = utf8_encode($preCargo['nombreConcepto']);
			}
			if ( !preg_match('!!u', $preCargo['observaciones']) ) {
				$preCargo['observaciones'] = utf8_encode($preCargo['observaciones']);
			}
			$resultado .= "<td class=\"tdtablita-o\">{$preCargo['nombreConcepto']}<input type=\"hidden\" id=\"nombreConcepto-{$preCargo['idConf']}\" value=\"{$preCargo['idConcepto']}\" /></td>";
			$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right\">$".number_format($preCargo['importe'], 2, '.', ',')."<input type=\"hidden\" id=\"importe-{$preCargo['idConf']}\" value=\"{$preCargo['importe']}\" /></td>";
			$resultado .= "<td class=\"tdtablita-o\">{$preCargo['fechaInicio']}<input type=\"hidden\" id=\"fechaInicio-{$preCargo['idConf']}\" value=\"{$preCargo['fechaInicio']}\" /></td>";
			$resultado .= "<td class=\"tdtablita-o\">{$preCargo['observaciones']}<input type=\"hidden\" id=\"observaciones-{$preCargo['idConf']}\" value=\"{$preCargo['observaciones']}\" /></td>";
			switch ( $preCargo["Configuracion"] ) {
				case 0:
					$resultado .= "<td class=\"tdtablita-o\">Compartida<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
				break;
				case 1:
					$resultado .= "<td class=\"tdtablita-o\">Individual<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
				break;
				default:
					$resultado .= "<td class=\"tdtablita-o\">Compartida<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
				break;
			}
			$resultado .= "<td class=\"acciones\">";
			$resultado .= "<a href=\"#ayc\" data-toggle=\"modal\" onClick=\"editarCargo(".$preCargo['idConf'].")\">";
			$resultado .= "<i class=\"fa fa-pencil\">";
			$resultado .= "</i>";
			$resultado .= "</a>";
			$resultado .= "</td>";
			$resultado .= "<td class=\"acciones\">";
			$resultado .= "<a href=\"#ayc\" onClick=\"eliminarCargo({$preCargo['idConf']}, $idCadena)\">";
			$resultado .= "<i class=\"fa fa-times\">";
			$resultado .= "</i>";
			$resultado .= "</a>";
			$resultado .= "</td>";
			$resultado .= "</tr>";
		}										
	} else {
		$resultado .= "<table class=\"tablarevision-hc\" id=\"afiliaciones\">";
        $resultado .= "<thead class=\"theadtablita\">";
        $resultado .= "<tr>";
       	$resultado .= "<th class=\"theadtablitauno\">Concepto</th>";
        $resultado .= "<th class=\"theadtablita\">Importe</th>";
        $resultado .= "<th class=\"theadtablita\">Fecha de Inicio</th>";
        $resultado .= "<th class=\"theadtablita\">Observaciones</th>";
        $resultado .= "<th class=\"theadtablita\">Configuraci&oacute;n</th>";
        $resultado .= "<th class=\"acciones\">Editar</th>";
        $resultado .= "<th class=\"acciones\">Eliminar</th>";
        $resultado .= "</tr>";
        $resultado .= "</thead>";
        $resultado .= "<tbody class=\"tablapequena\">";		
		$resultado .= "<tr>";
		$resultado .= "<td class=\"tdtablita-o\"></td>";
		$resultado .= "<td class=\"tdtablita-o\"></td>";
		$resultado .= "<td class=\"tdtablita-o\"></td>";
		$resultado .= "<td class=\"tdtablita-o\"></td>";
		$resultado .= "<td class=\"tdtablita-o\"></td>";
		$resultado .= "<td class=\"acciones\">";
		$resultado .= "</td>";
		$resultado .= "<td class=\"acciones\">";
		$resultado .= "</td>";
		$resultado .= "</tr>";
	}
	$resultado .= "</tbody>";
	$resultado .= "</table>";
	echo $resultado;
}
?>