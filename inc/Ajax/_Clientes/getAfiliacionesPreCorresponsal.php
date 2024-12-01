<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$idCadena = (isset($_POST['cadenaID'])) ? $_POST['cadenaID'] : '';
$idSubCadena = (isset($_POST['subcadenaID'])) ? $_POST['subcadenaID'] : '';
$idCorresponsal = (isset($_POST['corresponsalID'])) ? $_POST['corresponsalID'] : '';

if ( $idCadena != "" && $idSubCadena != "" ) {
	$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
	$oCorresponsal->load($idCorresponsal);
	$oCargoCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $idCadena, -1, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
	$tipoSubCadena = $oCorresponsal->getTipoSubCadena();
	$afiliacionesCadena = $oCargoCadena->cargarAfiliaciones();
	$cuotasCadena = $oCargoCadena->cargarCuotas();
	/*$resultado .= "<pre>";
	print_r($cuotasCadena);
	$resultado .= "</pre>";*/
	$debeCrearsePreAfiliacion = false;
	$debeCrearsePreCuota = false;
	/**
	* Si esta variable vale 0 quiere decir que la Cadena ya pago Afiliacion
	* Si esta variable vale 1 quiere decir que la Sub Cadena ya pago Afiliacion
	**/
	$quienHaPagadoAfiliacion = -500;
	/**
	* Si esta variable vale 0 quiere decir que la Cadena ya pago Cuota
	* Si esta variable vale 1 quiere decir que la Sub Cadena ya pago Cuota
	**/
	$quienHaPagadoCuota = -500;										
	
	if ( $afiliacionesCadena['totalAfiliaciones'] == 0 ) {
		if ( $tipoSubCadena == 0 ) { //SubCadena Real
			$oCargoSubCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $idCadena, $idSubCadena, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);													
		} else if ( $tipoSubCadena == 1 ) { //SubCadena PRE
			$oCargoSubCadena = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);										
		}
		$afiliacionesSubCadena = $oCargoSubCadena->cargarAfiliaciones();
		if ( $afiliacionesSubCadena['totalAfiliaciones'] == 0 ) {
			$debeCrearsePreAfiliacion = true;
		} else {
			$debeCrearsePreAfiliacion = false;
			$quienHaPagadoAfiliacion = 1;
		}								
	} else {
		$debeCrearsePreAfiliacion = false;
		$quienHaPagadoAfiliacion = 0;
	}
	
	if ( $cuotasCadena['totalCuotas'] == 0 ) {
		if ( $tipoSubCadena == 0 ) { //SubCadena Real
			$oCargoSubCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $idCadena, $idSubCadena, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);													
		} else if ( $tipoSubCadena == 1 ) { //SubCadena PRE
			$oCargoSubCadena = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);										
		}
		$cuotasSubCadena = $oCargoSubCadena->cargarCuotas();
		/*$resultado .= "<pre>";
		print_r($cuotasSubCadena);
		$resultado .= "</pre>";*/
		if ( $cuotasSubCadena['totalCuotas'] == 0 ) {
			$debeCrearsePreCuota = true;
		} else {
			$debeCrearsePreCuota = false;
			$quienHaPagadoCuota = 1;
		}																
	} else {
		$debeCrearsePreCuota = false;
		$quienHaPagadoCuota = 0;
	}
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
	
	if ( !$debeCrearsePreAfiliacion || !$debeCrearsePreCuota ) {
		$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, $idCorresponsal, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);
		$preCargos = $oPreCargo->cargarTodos();
		if ( count($preCargos) > 0 ) {
			foreach ( $preCargos as $preCargo ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $preCargo['nombreConcepto']) ) {
					$preCargo['nombreConcepto'] = utf8_encode($preCargo['nombreConcepto']);
				}
				if ( !preg_match('!!u', $preCargo['observaciones']) ) {
					$preCargo['observaciones'] = utf8_encode($preCargo['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$preCargo['nombreConcepto']}<input type=\"hidden\" id=\"nombreConcepto-{$preCargo['idConf']}\" value=\"{$preCargo['idConcepto']}\" /></td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($preCargo['importe'], 2, '.', ',')."<input type=\"hidden\" id=\"importe-{$preCargo['idConf']}\" value=\"{$preCargo['importe']}\" /></td>";
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
				$resultado .= "<a href=\"#ayc\" onClick=\"eliminarCargo({$preCargo['idConf']}, $idCadena, $idSubCadena, $idCorresponsal)\">";
				$resultado .= "<i class=\"fa fa-times\">";
				$resultado .= "</i>";
				$resultado .= "</a>";
				$resultado .= "</td>";
				$resultado .= "</tr>";
			}										
		}
	}
		
	if ( $debeCrearsePreAfiliacion && $debeCrearsePreCuota ) {
		$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, $idCorresponsal, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);
		$preCargos = $oPreCargo->cargarTodos();
		if ( count($preCargos) > 0 ) {
			foreach ( $preCargos as $preCargo ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $preCargo['nombreConcepto']) ) {
					$preCargo['nombreConcepto'] = utf8_encode($preCargo['nombreConcepto']);
				}
				if ( !preg_match('!!u', $preCargo['observaciones']) ) {
					$preCargo['observaciones'] = utf8_encode($preCargo['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$preCargo['nombreConcepto']}<input type=\"hidden\" id=\"nombreConcepto-{$preCargo['idConf']}\" value=\"{$preCargo['idConcepto']}\" /></td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($preCargo['importe'], 2, '.', ',')."<input type=\"hidden\" id=\"importe-{$preCargo['idConf']}\" value=\"{$preCargo['importe']}\" /></td>";
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
				$resultado .= "<a href=\"#ayc\" onClick=\"eliminarCargo({$preCargo['idConf']}, $idCadena, $idSubCadena, $idCorresponsal)\">";
				$resultado .= "<i class=\"fa fa-times\">";
				$resultado .= "</i>";
				$resultado .= "</a>";
				$resultado .= "</td>";
				$resultado .= "</tr>";
			}										
		} else {
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
	} else if ( !$debeCrearsePreAfiliacion && $debeCrearsePreCuota ) {
		if ( $quienHaPagadoAfiliacion == 0 ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $afiliacionesCadena['nombreConcepto']) ) {
					$afiliacionesCadena['nombreConcepto'] = utf8_encode($afiliacionesCadena['nombreConcepto']);
				}
				if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
					$afiliacionesCadena['observaciones'] = utf8_encode($afiliacionesCadena['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesCadena['nombreConcepto']}</td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($afiliacionesCadena['importe'], 2, '.', ',')."</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesCadena['fechaInicio']}</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesCadena['observaciones']}</td>";
				switch ( $afiliacionesCadena["Configuracion"] ) {
					case 0:
						$resultado .= "<td class=\"tdtablita-o\">Compartida</td>";
					break;
					case 1:
						$resultado .= "<td class=\"tdtablita-o\">Individual</td>";
					break;
					default:
						$resultado .= "<td class=\"tdtablita-o\"></td>";
					break;
				}
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "</tr>";
		} else if ( $quienHaPagadoAfiliacion == 1 ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $afiliacionesSubCadena['nombreConcepto']) ) {
					$afiliacionesSubCadena['nombreConcepto'] = utf8_encode($afiliacionesSubCadena['nombreConcepto']);
				}
				if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
					$afiliacionesSubCadena['observaciones'] = utf8_encode($afiliacionesSubCadena['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['nombreConcepto']}</td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($afiliacionesSubCadena['importe'], 2, '.', ',')."</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['fechaInicio']}</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['observaciones']}</td>";
				switch ( $afiliacionesSubCadena["Configuracion"] ) {
					case 0:
						$resultado .= "<td class=\"tdtablita-o\">Compartida</td>";
					break;
					case 1:
						$resultado .= "<td class=\"tdtablita-o\">Individual</td>";
					break;
					default:
						$resultado .= "<td class=\"tdtablita-o\"></td>";
					break;
				}
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "</tr>";											
		}
							  
	} else if ( $debeCrearsePreAfiliacion && !$debeCrearsePreCuota ) {
		if ( $quienHaPagadoCuota == 0 ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $cuotasCadena['nombreConcepto']) ) {
					$cuotasCadena['nombreConcepto'] = utf8_encode($cuotasCadena['nombreConcepto']);
				}
				if ( !preg_match('!!u', $cuotasCadena['observaciones']) ) {
					$cuotasCadena['observaciones'] = utf8_encode($cuotasCadena['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasCadena['nombreConcepto']}</td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($cuotasCadena['importe'], 2, '.', ',')."</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasCadena['fechaInicio']}</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasCadena['observaciones']}</td>";
				switch ( $cuotasCadena["Configuracion"] ) {
					case 0:
						$resultado .= "<td class=\"tdtablita-o\">Compartida</td>";
					break;
					case 1:
						$resultado .= "<td class=\"tdtablita-o\">Individual</td>";
					break;
					default:
						$resultado .= "<td class=\"tdtablita-o\"></td>";
					break;
				}
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "</tr>";											
		} else if ( $quienHaPagadoCuota == 1 ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $cuotasSubCadena['nombreConcepto']) ) {
					$cuotasSubCadena['nombreConcepto'] = utf8_encode($cuotasSubCadena['nombreConcepto']);
				}
				if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
					$cuotasSubCadena['observaciones'] = utf8_encode($cuotasSubCadena['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasSubCadena['nombreConcepto']}</td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($cuotasSubCadena['importe'], 2, '.', ',')."</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasSubCadena['fechaInicio']}</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasSubCadena['observaciones']}</td>";
				switch ( $cuotasSubCadena["Configuracion"] ) {
					case 0:
						$resultado .= "<td class=\"tdtablita-o\">Compartida</td>";
					break;
					case 1:
						$resultado .= "<td class=\"tdtablita-o\">Individual</td>";
					break;
					default:
						$resultado .= "<td class=\"tdtablita-o\"></td>";
					break;
				}
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "</tr>";											
		}
	} else if ( !$debeCrearsePreAfiliacion && !$debeCrearsePreCuota ) {
		//Agregar Afiliacion
		if ( $quienHaPagadoAfiliacion == 0 ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $afiliacionesCadena['nombreConcepto']) ) {
					$afiliacionesCadena['nombreConcepto'] = utf8_encode($afiliacionesCadena['nombreConcepto']);
				}
				if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
					$afiliacionesCadena['observaciones'] = utf8_encode($afiliacionesCadena['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesCadena['nombreConcepto']}</td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($afiliacionesCadena['importe'], 2, '.', ',')."</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesCadena['fechaInicio']}</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesCadena['observaciones']}</td>";
				switch ( $afiliacionesCadena["Configuracion"] ) {
					case 0:
						$resultado .= "<td class=\"tdtablita-o\">Compartida</td>";
					break;
					case 1:
						$resultado .= "<td class=\"tdtablita-o\">Individual</td>";
					break;
					default:
						$resultado .= "<td class=\"tdtablita-o\"></td>";
					break;
				}
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "</tr>";
		} else if ( $quienHaPagadoAfiliacion == 1 ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $afiliacionesSubCadena['nombreConcepto']) ) {
					$afiliacionesSubCadena['nombreConcepto'] = utf8_encode($afiliacionesSubCadena['nombreConcepto']);
				}
				if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
					$afiliacionesSubCadena['observaciones'] = utf8_encode($afiliacionesSubCadena['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['nombreConcepto']}</td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($afiliacionesSubCadena['importe'], 2, '.', ',')."</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['fechaInicio']}</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['observaciones']}</td>";
				switch ( $afiliacionesSubCadena["Configuracion"] ) {
					case 0:
						$resultado .= "<td class=\"tdtablita-o\">Compartida</td>";
					break;
					case 1:
						$resultado .= "<td class=\"tdtablita-o\">Individual</td>";
					break;
					default:
						$resultado .= "<td class=\"tdtablita-o\"></td>";
					break;
				}
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "</tr>";											
		}
		//Agregar Cuota
		if ( $quienHaPagadoCuota == 0 ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $cuotasCadena['nombreConcepto']) ) {
					$cuotasCadena['nombreConcepto'] = utf8_encode($cuotasCadena['nombreConcepto']);
				}
				if ( !preg_match('!!u', $cuotasCadena['observaciones']) ) {
					$cuotasCadena['observaciones'] = utf8_encode($cuotasCadena['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasCadena['nombreConcepto']}</td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($cuotasCadena['importe'], 2, '.', ',')."</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasCadena['fechaInicio']}</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasCadena['observaciones']}</td>";
				switch ( $cuotasCadena["Configuracion"] ) {
					case 0:
						$resultado .= "<td class=\"tdtablita-o\">Compartida</td>";
					break;
					case 1:
						$resultado .= "<td class=\"tdtablita-o\">Individual</td>";
					break;
					default:
						$resultado .= "<td class=\"tdtablita-o\"></td>";
					break;
				}
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "</tr>";											
		} else if ( $quienHaPagadoCuota == 1 ) {
				$resultado .= "<tr>";
				if ( !preg_match('!!u', $cuotasSubCadena['nombreConcepto']) ) {
					$cuotasSubCadena['nombreConcepto'] = utf8_encode($cuotasSubCadena['nombreConcepto']);
				}
				if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
					$cuotasSubCadena['observaciones'] = utf8_encode($cuotasSubCadena['observaciones']);
				}
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasSubCadena['nombreConcepto']}</td>";
				$resultado .= "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($cuotasSubCadena['importe'], 2, '.', ',')."</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasSubCadena['fechaInicio']}</td>";
				$resultado .= "<td class=\"tdtablita-o\">{$cuotasSubCadena['observaciones']}</td>";
				switch ( $cuotasSubCadena["Configuracion"] ) {
					case 0:
						$resultado .= "<td class=\"tdtablita-o\">Compartida</td>";
					break;
					case 1:
						$resultado .= "<td class=\"tdtablita-o\">Individual</td>";
					break;
					default:
						$resultado .= "<td class=\"tdtablita-o\"></td>";
					break;
				}
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "<td class=\"acciones\">";
				$resultado .= "</td>";
				$resultado .= "</tr>";											
		}																						
	}
	$resultado .= "</tbody>";
	$resultado .= "</table>";	
	echo $resultado;
}
?>