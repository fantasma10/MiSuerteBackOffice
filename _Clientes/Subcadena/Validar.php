<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreSubCadena.php");

$posicionPermiso = 11;
$posicionPermisoSubSeccion = 0;
$idPerfil = $_SESSION['idPerfil'];

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="SubCadena";
if(!isset($_SESSION['rec']))
    $_SESSION['rec'] = true;

$idOpcion = 2;
$tipoDePagina = "Escritura";

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( $idPerfil != 1 && $idPerfil != 4 && $idPerfil != 7 ) {
	header("Location: ../../../error.php");
	exit();
}

$idSubCadena = (isset($_GET['id'])) ? $_GET['id'] : -1;

if ( $idSubCadena == -1 ) {
    header('Location: ../../index.php');//redireccionar no existe la pre-cadena
} else {
	$oSubCadena = new XMLPreSubCad($RBD,$WBD);
	$oSubCadena->load($idSubCadena);
	if ( $oSubCadena->getExiste() ) {
		$_SESSION['idPreSubCadena'] = $idSubCadena;
		$idCadena = $oSubCadena->getIdCadena();
	} else {
		header('Location: ../../index.php');//redireccionar no existe la pre-cadena
	}
}

$esPosibleValidar = false;

if ( $oSubCadena->getPreRevisadoGenerales() && $oSubCadena->getPreRevisadoDireccion()
&& $oSubCadena->getPreRevisadoContactos() && $oSubCadena->getPreRevisadoCargos() 
&& $oSubCadena->getPreRevisadoContrato() && $oSubCadena->getPreRevisadoCuenta()
&& $oSubCadena->getPreRevisadoDocumentacion() ) {
	$esPosibleValidar = true;
}

$oConceptos = new Concepto($LOG, $RBD, '', '');

function acentos($txt){
	return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::.Validaci&oacute;n de Sub Cadena</title>
<!-- Núcleo BOOTSTRAP -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../css/miredgen.css" rel="stylesheet">
<link href="../../css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../../assets/bootstrap-datepicker/css/datepicker.css" />
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreSubCadena.js" type="text/javascript"></script>
<script src="../../inc/js/_Autorizar.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical---->
<!--Función "Include" del Menú-->
<?php include("../../inc/menu.php"); ?>
<!--Final del Menú Vertical----->
<!--Contenido Principal del Sitio-->

<section id="main-content">
<section class="wrapper site-min-height">
<div class="row">
<div class="col-lg-12">


<!--Panel Principal-->

<div class="panelrgb">
<div class="panel">
<div class="titulorgb-prealta"><span>
                                  <i class="fa fa-check-square"></i>
                              </span>
                              <h3><?php
								$nombre = $oSubCadena->getNombre();
								if ( !preg_match('!!u', $nombre) ) {
									echo $oSubCadena->getNombre();
								}
								echo $nombre;                               
							  ?></h3>
                              <span class="rev-combo pull-right">
                                 Validaci&oacute;n<br> de Sub Cadena
                              </span>
                          </div>
<div class="panel-body">
<button class="btn btnrevision" type="button" onClick="irABusqueda()">Nueva B&uacute;squeda <i class="fa fa-search"></i></button>
<div class="room-desk">
<?php
	/*$oCargoCadena = new Cargo($LOG, $WBD, $RBD, NULL, $tipoConcepto, $idCadena, -1, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
	$debeCrearsePreCargo = false;
	$afiliacionesCadena = $oCargoCadena->cargarAfiliaciones();
	$cuotasCadena = $oCargoCadena->cargarCuotas();
	if ( $afiliacionesCadena['totalAfiliaciones'] == 0 || $cuotasCadena['totalCuotas'] == 0 ) {*/
?>
<div class="room-form">
  <h5 class="text-primary"><i class="fa fa-dollar"></i> Afiliaci&oacute;n y Cuotas</h5>

<table class="tablarevision">
<td class="dato"><a href="#ayc" data-toggle="modal" onClick="prepararCamposCargo()">Nueva Cuota <i class="fa fa-plus"></i></a></td></tr></table>
<div id="wrapperAfiliaciones">
<table class="tablarevision-hc">
                                      <!--<thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Concepto</th>
                                          <th class="theadtablita">Importe</th>
                                          <th class="theadtablita">Fecha de Inicio</th>
                                          <th class="theadtablita">Observaciones</th>
                                          <th class="theadtablita">Configuraci&oacute;n</th>
                                          <th class="acciones">Editar</th>
                                          <th class="acciones">Eliminar</th>
                                      </tr>
                                      </thead>
                                      <tbody class="tablapequena">-->                                  
                                      <?php
									  	//var_dump("TEST A");
										$oCargoCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $idCadena, -1, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
										//var_dump("TEST B");
										//$tipoSubCadena = $oCorresponsal->getTipoSubCadena();
										//var_dump("TEST C");
										$afiliacionesCadena = $oCargoCadena->cargarAfiliaciones();
										//var_dump("TEST D");
										$cuotasCadena = $oCargoCadena->cargarCuotas();
										//var_dump("TEST E");
										/*echo "<pre>";
										print_r($cuotasCadena);
										echo "</pre>";*/
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
										
										/*echo "<pre>";
										print_r($afiliacionesCadena);
										echo "</pre>";
										
										echo "<pre>";
										print_r($cuotasCadena);
										echo "</pre>";*/
										
										if ( $afiliacionesCadena['totalAfiliaciones'] == 0 ) {
											$debeCrearsePreAfiliacion = true;
										} else {
											$debeCrearsePreAfiliacion = false;
											$quienHaPagadoAfiliacion = 0;
										}
										
										if ( $cuotasCadena['totalCuotas'] == 0 ) {
											$debeCrearsePreCuota = true;				
										} else {
											$debeCrearsePreCuota = false;
											$quienHaPagadoCuota = 0;
										}
										
										/*var_dump("debeCrearsePreAfiliacion: $debeCrearsePreAfiliacion");
										var_dump("debeCrearsePreCuota: $debeCrearsePreCuota");*/
										
                                      	echo "<thead class=\"theadtablita\">";
                                      	echo "<tr>";
                                      	echo "<th class=\"theadtablitauno\">Concepto</th>";
                                      	echo "<th class=\"theadtablita\">Importe</th>";
                                      	echo "<th class=\"theadtablita\">Fecha de Inicio</th>";
                                      	echo "<th class=\"theadtablita\">Observaciones</th>";
                                      	echo "<th class=\"theadtablita\">Configuraci&oacute;n</th>";
									  	if ( $debeCrearsePreAfiliacion || $debeCrearsePreCuota ) {
                                      		echo "<th class=\"acciones\">Editar</th>";
                                      		echo "<th class=\"acciones\">Eliminar</th>";
									  	}
                                      	echo "</tr>";
                                      	echo "</thead>";
                                      	echo "<tbody class=\"tablapequena\">";										
										
										$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);
										$preCargos = $oPreCargo->cargarTodos();
										/*echo "<pre>";
										print_r($preCargos);
										echo "</pre>";*/
										if ( count($preCargos) > 0 ) {
											foreach ( $preCargos as $preCargo ) {
												echo "<tr>";
												if ( !preg_match('!!u', $preCargo['nombreConcepto']) ) {
													$preCargo['nombreConcepto'] = utf8_encode($preCargo['nombreConcepto']);
												}
												if ( !preg_match('!!u', $preCargo['observaciones']) ) {
													$preCargo['observaciones'] = utf8_encode($preCargo['observaciones']);
												}
												echo "<td class=\"tdtablita-o\">{$preCargo['nombreConcepto']}<input type=\"hidden\" id=\"nombreConcepto-{$preCargo['idConf']}\" value=\"{$preCargo['idConcepto']}\" /></td>";
												echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($preCargo['importe'], 2, '.', ',')."<input type=\"hidden\" id=\"importe-{$preCargo['idConf']}\" value=\"{$preCargo['importe']}\" /></td>";
												echo "<td class=\"tdtablita-o\">{$preCargo['fechaInicio']}<input type=\"hidden\" id=\"fechaInicio-{$preCargo['idConf']}\" value=\"{$preCargo['fechaInicio']}\" /></td>";
												echo "<td class=\"tdtablita-o\">{$preCargo['observaciones']}<input type=\"hidden\" id=\"observaciones-{$preCargo['idConf']}\" value=\"{$preCargo['observaciones']}\" /></td>";
												switch ( $preCargo["Configuracion"] ) {
													case 0:
														echo "<td class=\"tdtablita-o\">Compartida<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
													break;
													case 1:
														echo "<td class=\"tdtablita-o\">Individual<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
													break;
													default:
														echo "<td class=\"tdtablita-o\">Compartida<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
													break;
												}
												echo "<td class=\"acciones\">";
												echo "<a href=\"#ayc\" data-toggle=\"modal\" onClick=\"editarCargo(".$preCargo['idConf'].")\">";
												echo "<i class=\"fa fa-pencil\">";
												echo "</i>";
												echo "</a>";
												echo "</td>";
												echo "<td class=\"acciones\">";
												echo "<a href=\"#ayc\" onClick=\"eliminarCargo({$preCargo['idConf']}, $idCadena, $idSubCadena, -1)\">";
												echo "<i class=\"fa fa-times\">";
												echo "</i>";
												echo "</a>";
												echo "</td>";
												echo "</tr>";
											}										
										}
									
										if ( $debeCrearsePreAfiliacion && $debeCrearsePreCuota ) {
											$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);
											$preCargos = $oPreCargo->cargarTodos();
											/*echo "<pre>";
											print_r($preCargos);
											echo "</pre>";*/
											if ( count($preCargos) > 0 ) {
												foreach ( $preCargos as $preCargo ) {
													echo "<tr>";
													if ( !preg_match('!!u', $preCargo['nombreConcepto']) ) {
														$preCargo['nombreConcepto'] = utf8_encode($preCargo['nombreConcepto']);
													}
													if ( !preg_match('!!u', $preCargo['observaciones']) ) {
														$preCargo['observaciones'] = utf8_encode($preCargo['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$preCargo['nombreConcepto']}<input type=\"hidden\" id=\"nombreConcepto-{$preCargo['idConf']}\" value=\"{$preCargo['idConcepto']}\" /></td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($preCargo['importe'], 2, '.', ',')."<input type=\"hidden\" id=\"importe-{$preCargo['idConf']}\" value=\"{$preCargo['importe']}\" /></td>";
													echo "<td class=\"tdtablita-o\">{$preCargo['fechaInicio']}<input type=\"hidden\" id=\"fechaInicio-{$preCargo['idConf']}\" value=\"{$preCargo['fechaInicio']}\" /></td>";
													echo "<td class=\"tdtablita-o\">{$preCargo['observaciones']}<input type=\"hidden\" id=\"observaciones-{$preCargo['idConf']}\" value=\"{$preCargo['observaciones']}\" /></td>";
													switch ( $preCargo["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\">Compartida<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
														break;
													}
													echo "<td class=\"acciones\">";
													echo "<a href=\"#ayc\" data-toggle=\"modal\" onClick=\"editarCargo(".$preCargo['idConf'].")\">";
													echo "<i class=\"fa fa-pencil\">";
													echo "</i>";
													echo "</a>";
													echo "</td>";
													echo "<td class=\"acciones\">";
													echo "<a href=\"#ayc\" onClick=\"eliminarCargo({$preCargo['idConf']}, $idCadena, $idSubCadena, $idCorresponsal)\">";
													echo "<i class=\"fa fa-times\">";
													echo "</i>";
													echo "</a>";
													echo "</td>";
													echo "</tr>";
												}										
											} else {
												echo "<tr>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"acciones\">";
												echo "</td>";
												echo "<td class=\"acciones\">";
												echo "</td>";
												echo "</tr>";
											}										
										} else if ( !$debeCrearsePreAfiliacion && $debeCrearsePreCuota ) {
											//var_dump("TEST AB");
											if ( $quienHaPagadoAfiliacion == 0 ) {
													echo "<tr>";
													if ( !preg_match('!!u', $afiliacionesCadena['nombreConcepto']) ) {
														$afiliacionesCadena['nombreConcepto'] = utf8_encode($afiliacionesCadena['nombreConcepto']);
													}
													if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
														$afiliacionesCadena['observaciones'] = utf8_encode($afiliacionesCadena['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$afiliacionesCadena['nombreConcepto']}</td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($afiliacionesCadena['importe'], 2, '.', ',')."</td>";
													echo "<td class=\"tdtablita-o\">{$afiliacionesCadena['fechaInicio']}</td>";
													echo "<td class=\"tdtablita-o\">{$afiliacionesCadena['observaciones']}</td>";
													switch ( $afiliacionesSubCadena["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida</td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual</td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\"></td>";
														break;
													}
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "</tr>";
											} else if ( $quienHaPagadoAfiliacion == 1 ) {
													echo "<tr>";
													if ( !preg_match('!!u', $afiliacionesSubCadena['nombreConcepto']) ) {
														$afiliacionesSubCadena['nombreConcepto'] = utf8_encode($afiliacionesSubCadena['nombreConcepto']);
													}
													if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
														$afiliacionesSubCadena['observaciones'] = utf8_encode($afiliacionesSubCadena['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['nombreConcepto']}</td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($afiliacionesSubCadena['importe'], 2, '.', ',')."</td>";
													echo "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['fechaInicio']}</td>";
													echo "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['observaciones']}</td>";
													switch ( $afiliacionesSubCadena["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida</td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual</td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\"></td>";
														break;
													}
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "</tr>";											
											}
																  
									  	} else if ( $debeCrearsePreAfiliacion && !$debeCrearsePreCuota ) {
											//var_dump("TEST DF");
											if ( $quienHaPagadoCuota == 0 ) {
													echo "<tr>";
													if ( !preg_match('!!u', $cuotasCadena['nombreConcepto']) ) {
														$cuotasCadena['nombreConcepto'] = utf8_encode($cuotasCadena['nombreConcepto']);
													}
													if ( !preg_match('!!u', $cuotasCadena['observaciones']) ) {
														$cuotasCadena['observaciones'] = utf8_encode($cuotasCadena['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$cuotasCadena['nombreConcepto']}</td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($cuotasCadena['importe'], 2, '.', ',')."</td>";
													echo "<td class=\"tdtablita-o\">{$cuotasCadena['fechaInicio']}</td>";
													echo "<td class=\"tdtablita-o\">{$cuotasCadena['observaciones']}</td>";
													switch ( $cuotasCadena["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida</td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual</td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\"></td>";
														break;
													}
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "</tr>";											
											} else if ( $quienHaPagadoCuota == 1 ) {
													echo "<tr>";
													if ( !preg_match('!!u', $cuotasSubCadena['nombreConcepto']) ) {
														$cuotasSubCadena['nombreConcepto'] = utf8_encode($cuotasSubCadena['nombreConcepto']);
													}
													if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
														$cuotasSubCadena['observaciones'] = utf8_encode($cuotasSubCadena['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$cuotasSubCadena['nombreConcepto']}</td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($cuotasSubCadena['importe'], 2, '.', ',')."</td>";
													echo "<td class=\"tdtablita-o\">{$cuotasSubCadena['fechaInicio']}</td>";
													echo "<td class=\"tdtablita-o\">{$cuotasSubCadena['observaciones']}</td>";
													switch ( $cuotasSubCadena["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida</td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual</td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\"></td>";
														break;
													}
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "</tr>";											
											}
										} else if ( !$debeCrearsePreAfiliacion && !$debeCrearsePreCuota ) {
											//var_dump("TEST AX");
											//Agregar Afiliacion
											if ( $quienHaPagadoAfiliacion == 0 ) {
													//var_dump("TEST A");
													echo "<tr>";
													if ( !preg_match('!!u', $afiliacionesCadena['nombreConcepto']) ) {
														$afiliacionesCadena['nombreConcepto'] = utf8_encode($afiliacionesCadena['nombreConcepto']);
													}
													if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
														$afiliacionesCadena['observaciones'] = utf8_encode($afiliacionesCadena['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$afiliacionesCadena['nombreConcepto']}</td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($afiliacionesCadena['importe'], 2, '.', ',')."</td>";
													echo "<td class=\"tdtablita-o\">{$afiliacionesCadena['fechaInicio']}</td>";
													echo "<td class=\"tdtablita-o\">{$afiliacionesCadena['observaciones']}</td>";
													switch ( $afiliacionesCadena["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida</td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual</td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\"></td>";
														break;
													}
											} else if ( $quienHaPagadoAfiliacion == 1 ) {
													//var_dump("TEST B");
													echo "<tr>";
													if ( !preg_match('!!u', $afiliacionesSubCadena['nombreConcepto']) ) {
														$afiliacionesSubCadena['nombreConcepto'] = utf8_encode($afiliacionesSubCadena['nombreConcepto']);
													}
													if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
														$afiliacionesSubCadena['observaciones'] = utf8_encode($afiliacionesSubCadena['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['nombreConcepto']}</td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($afiliacionesSubCadena['importe'], 2, '.', ',')."</td>";
													echo "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['fechaInicio']}</td>";
													echo "<td class=\"tdtablita-o\">{$afiliacionesSubCadena['observaciones']}</td>";
													switch ( $afiliacionesSubCadena["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida</td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual</td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\"></td>";
														break;
													}											
											}
											//Agregar Cuota
											if ( $quienHaPagadoCuota == 0 ) {
													//var_dump("TEST C");
													/*echo "<pre>";
													print_r($cuotasCadena);
													echo "</pre>";*/
													/*var_dump("idCadena: $idCadena");
													var_dump("idSubCadena: $idSubCadena");*/
													echo "<tr>";
													if ( !preg_match('!!u', $cuotasCadena['nombreConcepto']) ) {
														$cuotasCadena['nombreConcepto'] = utf8_encode($cuotasCadena['nombreConcepto']);
													}
													if ( !preg_match('!!u', $cuotasCadena['observaciones']) ) {
														$cuotasCadena['observaciones'] = utf8_encode($cuotasCadena['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$cuotasCadena['nombreConcepto']}</td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($cuotasCadena['importe'], 2, '.', ',')."</td>";
													echo "<td class=\"tdtablita-o\">{$cuotasCadena['fechaInicio']}</td>";
													echo "<td class=\"tdtablita-o\">{$cuotasCadena['observaciones']}</td>";
													//echo "<td class=\"tdtablita-o\"></td>";
													switch ( $cuotasCadena["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida</td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual</td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\"></td>";
														break;
													}																							
											} else if ( $quienHaPagadoCuota == 1 ) {
													//var_dump("TEST D");
													echo "<tr>";
													if ( !preg_match('!!u', $cuotasSubCadena['nombreConcepto']) ) {
														$cuotasSubCadena['nombreConcepto'] = utf8_encode($cuotasSubCadena['nombreConcepto']);
													}
													if ( !preg_match('!!u', $afiliacionesCadena['observaciones']) ) {
														$cuotasSubCadena['observaciones'] = utf8_encode($cuotasSubCadena['observaciones']);
													}
													echo "<td class=\"tdtablita-o\">{$cuotasSubCadena['nombreConcepto']}</td>";
													echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($cuotasSubCadena['importe'], 2, '.', ',')."</td>";
													echo "<td class=\"tdtablita-o\">{$cuotasSubCadena['fechaInicio']}</td>";
													echo "<td class=\"tdtablita-o\">{$cuotasSubCadena['observaciones']}</td>";
													switch ( $cuotasSubCadena["Configuracion"] ) {
														case 0:
															echo "<td class=\"tdtablita-o\">Compartida</td>";
														break;
														case 1:
															echo "<td class=\"tdtablita-o\">Individual</td>";
														break;
														default:
															echo "<td class=\"tdtablita-o\"></td>";
														break;
													}											
											}																						
										}
									  ?>
                                      </tbody>
                                      </table>
</div>                                    
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkcargos" value="" <?php echo ($oSubCadena->getPreRevisadoCargos())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<?php //} ?>
<!--adkjgf-->
<div class="room-box">
  <h5 class="text-primary"><i class="fa fa-book"></i> Datos Generales</h5>

<table class="tablarevision">
<tr>
<td>Cadena</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getNombreCadena() != "" ) {
		echo acentos($oSubCadena->getNombreCadena());	
	} else {
		echo "N/A";
	}
?>
</td></tr>
<tr>
<td>Grupo</td><td>Referencia</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getNombreGrupo() != "" ) {
		echo $oSubCadena->getNombreGrupo();	
	} else {
		echo "N/A";
	}
?>
</td><td class="dato">
<?php
	if ( $oSubCadena->getNombreReferencia() != "" ) {
		echo $oSubCadena->getNombreReferencia();	
	} else {
		echo "N/A";
	}
?>
</td></tr>
<tr>
<td>Teléfono</td><td>Correo</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getTel1() != "" ) {
		echo $oSubCadena->getTel1();	
	} else {
		echo "N/A";
	}
?>
</td>
<td class="dato">
<?php
	if ( $oSubCadena->getCorreo() != "" ) {
		echo $oSubCadena->getCorreo();
	} else {
		echo "N/A";
	}
?>
</td></tr>
</table>
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(1, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkgenerales" value="" <?php echo ($oSubCadena->getPreRevisadoGenerales())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--dfkdjf-->




                             
<div class="room-box">
<h5 class="text-primary"><i class="fa fa-map-marker"></i> Direcci&oacute;n</h5>
<table class="tablarevision">
<tr>
<td><i class="fa fa-home"></i> Direcci&oacute;n</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getCalle() != '' && $oSubCadena->getNext() != ''
	&& $oSubCadena->getColonia() != '' && $oSubCadena->getCP() != '' && $oSubCadena->getNombreCiudad() != ''
	&& $oSubCadena->getNombreEstado() != '' && $oSubCadena->getNombrePais() != '' ) {
		if ( $oSubCadena->getCalle() != '' )
			echo acentos($oSubCadena->getCalle()); 
		if ( $oSubCadena->getCalle() != '' && $oSubCadena->getNext() != '' )    
			echo " No. ".$oSubCadena->getNext();
		if ( $oSubCadena->getCalle() != '' && $oSubCadena->getNint() != '' )
			echo " No. Int. ".$oSubCadena->getNint();
		
		echo "<br />";
		
		if ( $oSubCadena->getColonia() != '' )
			echo "Col. ".utf8_encode($oSubCadena->getNombreColonia());
		if ( $oSubCadena->getCP() != '' )
			echo " C.P. ".$oSubCadena->getCP();
		
		echo "<br />";										
		
		if ( $oSubCadena->getColonia() != '' && $oSubCadena->getNombreCiudad() != '' )
			echo utf8_encode($oSubCadena->getNombreCiudad());                                    
		if ( $oSubCadena->getNombreEstado() != '' )
			echo ", ".utf8_encode($oSubCadena->getNombreEstado());
		if ( $oSubCadena->getNombreEstado() != '' && $oSubCadena->getNombrePais() )
			echo ", ".utf8_encode($oSubCadena->getNombrePais());
	} else {
		echo "N/A";
	}					
?>
</td></tr>
<tr>
<tr>
<td style="font-size:10px;">
	<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDDomicilio()?>)"> <i class="fa fa-folder-open"></i>Ver Comprobante de Domicilio.</button>
</td>
</tr>
</table>                         
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(2, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkdireccion" value="" <?php echo ($oSubCadena->getPreRevisadoDireccion())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>




<div class="room-box">
  <h5 class="text-primary"><i class="fa fa-users"></i> Contactos</h5>
  <div class="table-responsive">
<table class="tablarevision-hc">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Contacto</th>
                                          <th class="theadtablita">Tel&eacute;fono</th>
                                          <th class="theadtablita">Extensi&oacute;n</th>
                                          <th class="theadtablita">Correo</th>
                                          <th class="theadtablita">Tipo de Contacto</th>
                                      </tr>
                                      </thead>
                                      <tbody class="tablapequena">                                    
									  <?php
                                        $sql = "CALL `prealta`.`SP_LOAD_PRESUBCADENA`({$_SESSION['idPreSubCadena']});";
                                        $ax = $sql;
                                        $res = $RBD->SP($sql);
                                        $AND = "";
                                        if ( $RBD->error() == '' ) {
                                            if ( $res != '' && mysqli_num_rows($res) > 0 ) {
                                                $r = mysqli_fetch_array($res);
												$xml = simplexml_load_string(utf8_encode($r[0]));
                                                /*$r = mysqli_fetch_array($res);

                                                $reg = base64_decode($r[0]);
                                                $xml = simplexml_load_string(utf8_encode($reg));*/
                                                /*$r = mysqli_fetch_array($res);
                                                $xml = simplexml_load_string($r[0]);*/
                                                $band = false;
                                                foreach ( $xml->Contactos->Contacto as $cont ) {
                                                    if ( $band == false && $cont != '' ) {
                                                        $AND .= " AND I.`idSubCadenaContacto` = $cont ";
                                                        $band = true;
                                                    } else if ( $band ) {
                                                        $AND .= " OR I.`idSubCadenaContacto` = $cont ";
                                                    }
                                                }
                                                
                                                if ( $AND != '' ) {
                                                    $sql = "CALL `prealta`.`SP_LOAD_CONTACTOSPDFAUTORIZACIONPRESUBCADENA`('$AND');";
                                                    $Result = $RBD->SP($sql);
                                                    if ( $RBD->error() == '' ) {
                                                        if ( $Result != '' && mysqli_num_rows($Result) > 0 ) {
                                                            $i = 0;
                                                            while ( list($infid,$tipo,$id,$nombre,$paterno,$materno,$telefono,$ext,$correo,$desc) = mysqli_fetch_array($Result) ) {
                                                                if ( !preg_match('!!u', $nombre) ) {
                                                                    $nombre = utf8_encode($nombre);
                                                                }
                                                                if ( !preg_match('!!u', $paterno) ) {
                                                                    $paterno = utf8_encode($paterno);
                                                                }
                                                                if ( !preg_match('!!u', $materno) ) {
                                                                    $materno = utf8_encode($materno);
                                                                }
                                                                echo "<tr>";														
                                                                echo "<td class=\"tdtablita\">$nombre $paterno $materno</td>";
                                                                echo "<td class=\"tdtablita\">$telefono</td>";
                                                                echo "<td class=\"tdtablita\">$ext</td>";
                                                                echo "<td class=\"tdtablita\">$correo</td>";
                                                                echo "<td class=\"tdtablita\">".utf8_encode($desc)."</td>";
                                                                echo "</tr>";																
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                  echo "<td class=\"tbodyuno\"></td>";
                                                  echo "<td class=\"tdtablita\"></td>";
                                                  echo "<td class=\"tdtablita\"></td>";
                                                  echo "<td class=\"tdtablita\"></td>";
                                                  echo "<td class=\"tdtablita\"></td>";												
                                                }								
                                            }	
                                        } else {
                                          echo "<td class=\"tbodyuno\"></td>";
                                          echo "<td class=\"tdtablita\"></td>";
                                          echo "<td class=\"tdtablita\"></td>";
                                          echo "<td class=\"tdtablita\"></td>";
                                          echo "<td class=\"tdtablita\"></td>";									
                                        }						  
                                      ?>
                                      </tbody></table>
</div>
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(3, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkcontactos" value="" <?php echo ($oSubCadena->getPreRevisadoContactos())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>

<!--Contrato-->
<div class="room-box">
<h5 class="text-primary"><i class="fa fa-file"></i> Contrato</h5>
<div class="table-responsive">
<table class="tablaauto">
<tr>
<td>R&eacute;gimen</td><td>RFC</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getNombreCRegimen() != "" ) {
		echo $oSubCadena->getNombreCRegimen();
	} else {
		echo "N/A";
	}
?>
</td>
<td class="dato">
<?php
	if ( $oSubCadena->getCRfc() != "" ) {
		echo $oSubCadena->getCRfc();
	} else {
		echo "N/A";
	}
?>
</td></tr>
<tr>
<td>Raz&oacute;n Social</td><td>Fecha de Constituci&oacute;n</td></tr>
<tr>
<td class="dato">
<?php
	$razonSocial = $oSubCadena->getCRSocial();
	if ( !preg_match('!!u', $razonSocial) ) {
		$razonSocial = utf8_encode($razonSocial);
	}
	if ( $razonSocial != "" ) {
		echo $razonSocial;
	} else {
		echo "N/A";
	}
?>
</td><td class="dato">
<?php
	$fechaConstitucion = $oSubCadena->getCFConstitucion();
	if ( $fechaConstitucion != "" ) {
		echo (isset($fechaConstitucion) && $fechaConstitucion != "")? date("Y-m-d", strtotime($fechaConstitucion)) : '';
	} else {
		echo "N/A";
	}
?>
</td></tr>
</table>
<table class="tablaauto">
<tr>
<td>Representante Legal</td></tr>
<tr>
<td class="dato">
<?php
	$nombreRepLegal = $oSubCadena->getCNombre();
	$apellidoPaternoRepLegal = $oSubCadena->getCPaterno();
	$apellidoMaternoRepLegal = $oSubCadena->getCMaterno();
	if ( !preg_match('!!u', $nombreRepLegal) ) {
		$nombreRepLegal = utf8_encode($nombreRepLegal);
	}
	if ( !preg_match('!!u', $apellidoPaternoRepLegal) ) {
		$apellidoPaternoRepLegal = utf8_encode($apellidoPaternoRepLegal);
	}
	if ( !preg_match('!!u', $apellidoMaternoRepLegal) ) {
		$apellidoMaternoRepLegal = utf8_encode($apellidoMaternoRepLegal);
	}	
	if ( $nombreRepLegal != "" && $apellidoPaternoRepLegal != "" && $apellidoMaternoRepLegal != "" ) {
		echo $nombreRepLegal." ".$apellidoPaternoRepLegal." ".$apellidoMaternoRepLegal;
	} else {
		echo "N/A";
	}
?>
</td></tr>
</table>
<table class="tablaauto">
<tr>
<td>No. de Identificaci&oacute;n</td><td>Tipo de Identificaci&oacute;n</td>   
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getCNumIden() != "" ) {
		echo $oSubCadena->getCNumIden();
	} else {
		echo "N/A";
	} 
?>
</td><td class="dato">
<?php
	if ( $oSubCadena->getNombreCRTipoIden() != "" ) {
		echo $oSubCadena->getNombreCRTipoIden();
	} else {
		echo "N/A";
	}
?>
</td></tr>
<tr>
<td>RFC</td><td>CURP</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getCRfc() != "" ) {
		echo $oSubCadena->getCRfc();
	} else {
		echo "N/A";
	}
?>
</td><td class="dato">
<?php
	if ( $oSubCadena->getCCurp() != "" ) {
		echo $oSubCadena->getCCurp();
	} else {
		echo "N/A";
	}
?>
</td></tr>
<td>Figura Pol&iacute;ticamente Expuesta</td><td>Familia Pol&iacute;ticamente Expuesta</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getCFigura() == 0 && $oSubCadena->getCFigura() != "" ) {
		echo "S&iacute;";
	} else {
		echo "No";
	}
?>
</td><td class="dato">
<?php
	if ( $oSubCadena->getCFamilia() == 0 && $oSubCadena->getCFamilia() != "" ) {
		echo "S&iacute;";
	} else {
		echo "No";
	}
?>
</td></tr>
</table>
<table class="tablarevision">
<tr>
<td>Direcci&oacute;n Fiscal</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oSubCadena->getCCalle() != '' && $oSubCadena->getCNext() != ''
	&& $oSubCadena->getCColonia() != '' && $oSubCadena->getCCP() != '' && $oSubCadena->getCNombreCiudad() != ''
	&& $oSubCadena->getCNombreEstado() != '' && $oSubCadena->getCNombrePais() != '' ) {
		if ( $oSubCadena->getCCalle() != '' )
			echo acentos($oSubCadena->getCCalle()); 
		if ( $oSubCadena->getCCalle() != '' && $oSubCadena->getCNext() != '' )    
			echo " No. ".$oSubCadena->getCNext();
		if ( $oSubCadena->getCCalle() != '' && $oSubCadena->getCNint() != '' )
			echo " No. Int. ".$oSubCadena->getCNint();
		
		echo "<br />";
		
		if ( $oSubCadena->getCColonia() != '' )
			echo "Col. ".utf8_encode($oSubCadena->getCNombreColonia());
		if ( $oSubCadena->getCCP() != '' )
			echo " C.P. ".$oSubCadena->getCCP();
		
		echo "<br />";										
		
		if ( $oSubCadena->getCColonia() != '' && $oSubCadena->getCNombreCiudad() != '' )
			echo utf8_encode($oSubCadena->getCNombreCiudad());                                    
		if ( $oSubCadena->getCNombreEstado() != '' )
			echo ", ".utf8_encode($oSubCadena->getCNombreEstado());
		if ( $oSubCadena->getCNombreEstado() != '' && $oSubCadena->getCNombrePais() )
			echo ", ".utf8_encode($oSubCadena->getCNombrePais());
	} else {
		echo "N/A";
	}					
?>
</td></tr>
</table></div>           
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(5, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkcontrato" value="" <?php echo ($oSubCadena->getPreRevisadoContrato())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--Fin de Contrato-->
<!--Versión-->
<div class="room-box">
<h5 class="text-primary"><i class="fa fa-shopping-cart"></i> Versi&oacute;n</h5>
<div class="table-responsive">
<table class="tablarevision">
<tr>
<td>Versi&oacute;n</td></tr>
<tr>
<td class="dato"><?php
if ( $oSubCadena->getNombreVersion() != "" ) {
	echo utf8_encode($oSubCadena->getNombreVersion());
} else {
	echo "N/A";
}
?></td></tr>
</table>  
</div>                 
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(6, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkversion" value="" <?php echo ($oSubCadena->getPreRevisadoVersion())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--Fin de Versión-->
<!--Inicio de Cuenta-->
<div class="room-box">
<h5 class="text-primary"><i class="fa fa-credit-card"></i> Cuenta</h5>
<div class="table-responsive">
<table class="tablaauto">
<tr>
<td>CLABE</td></tr>
<tr><td class="dato">
<?php
	$CLABE = $oSubCadena->getClabe();
	if ( !preg_match('!!u', $CLABE) ) {
		//no es utf-8
		$CLABE = utf8_encode($CLABE);
	}
	if ( $CLABE != "" ) {
		echo $CLABE;
	} else {
		echo "N/A";
	}
?>
</td></tr>
<tr>
<td>Banco</td><td>No. Cuenta</td><td>Beneficiario</td><td>Descripci&oacute;n</td></tr>
<tr>
<td class="dato">
<?php
	$banco = $oSubCadena->getNombreBanco();
	if ( !preg_match('!!u', $banco) ) {
		//no es utf-8
		$banco = utf8_encode($banco);
	}
	if ( $banco != "" ) {
		echo $banco;
	} else {
		echo "N/A";
	}												
?>
</td><td class="dato">
<?php
	$numeroCuenta = $oSubCadena->getNumCuenta();
	if ( !preg_match('!!u', $numeroCuenta) ) {
		//no es utf-8
		$numeroCuenta = utf8_encode($numeroCuenta);
	}
	if ( $numeroCuenta != "" ) {
		echo $numeroCuenta;
	} else {
		echo "N/A";
	}
?>
</td><td class="dato">
<?php
	$beneficiario = $oSubCadena->getBeneficiario();
	if ( !preg_match('!!u', $beneficiario) ) {
		//no es utf-8
		$beneficiario = utf8_encode($beneficiario);
	}
	if ( $beneficiario != "" ) {
		echo $beneficiario;
	} else {
		echo "N/A";
	}
?>
</td><td class="dato">
<?php
	$descripcion = $oSubCadena->getDescripcion();
	if ( !preg_match('!!u', $descripcion) ) {
		//no es utf-8
		$descripcion = utf8_encode($descripcion);
	}
	if ( $descripcion != "" ) {
		echo $descripcion;
	} else {
		echo "N/A";
	}
?>
</td>
</tr>
<tr><td style="font-size:10px;"><button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDBanco()?>)"><i class="fa fa-folder-open"></i> Ver Car&aacute;tula de Banco.</button></td></tr>
</table>
</div>
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(7, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkcuenta" value="" <?php echo ($oSubCadena->getPreRevisadoCuenta())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--Final de Cuenta-->
<!--Inicio de Documentación-->
<div class="room-box">
<h5 class="text-primary"><i class="fa fa-folder"></i> Documentaci&oacute;n</h5>
<div class="table-responsive">
<table class="tablarevision">
<tr>
	<td>
    	Archivos
    </td>
</tr>
<tr>
	<td class="dato">
		Comprobante de Domicilio
	</td>
    <td>
    	<?php if($oSubCadena->getDDomicilio() != ''){ ?>
		<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDDomicilio()?>)">
        	<i class="fa fa-folder-open"></i>Ver...
        </button>
        <?php } ?>
	</td>
</tr>
<tr>
	<td class="dato">
		Car&aacute;tula de Banco
	</td>
    <td>
    	<?php if($oSubCadena->getDBanco() != ''){ ?>
		<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDBanco()?>)">
       		<i class="fa fa-folder-open"></i>Ver...
        </button>
        <?php } ?>
	</td>
</tr>
<tr>
    <td class="dato">
        Identificaci&oacute;n del Representante Legal
    </td>
    <td>
    	<?php if($oSubCadena->getDRepLegal() != ''){ ?>
        <button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDRepLegal()?>)">
        	<i class="fa fa-folder-open"></i>Ver...
        </button>
        <?php } ?>
    </td>
</tr>
<tr>
	<td class="dato">RFC Raz&oacute;n Social</td>
    <td>
    	<?php if($oSubCadena->getDRSocial() != ''){ ?>
    	<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDRSocial()?>)">
        	<i class="fa fa-folder-open"></i>Ver...
        </button>
        <?php } ?>
    </td>
</tr>
<?php if($oSubCadena->getCRegimen() == 2){?>
<tr>
	<td class="dato">Acta Constitutiva</td>
    
    <td>
    	<?php if($oSubCadena->getDAConstitutiva() != ''){ ?>
    	<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDAConstitutiva()?>)">
        	<i class="fa fa-folder-open"></i>Ver...
        </button>
        <?php } ?>
    </td>
</tr>
<?php } ?>
<tr>
	<td class="dato">Comprobante de Domicilio Fiscal</td>
    <td>
    	<?php if($oSubCadena->getDFiscal() != ''){ ?>
    	<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDFiscal()?>)">
        	<i class="fa fa-folder-open"></i>Ver...
        </button>
        <?php } ?>
    </td>
</tr>
<?php if($oSubCadena->getCRegimen() == 2){?>
<tr>
	<td class="dato">Poderes</td>
    <td>
    	<?php if($oSubCadena->getDPoderes() != ''){ ?>
        <button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDPoderes()?>)">
    		<i class="fa fa-folder-open"></i>Ver...
        </button>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</table>  
</div>                 
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(7, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkdocumentacion" value="" <?php echo ($oSubCadena->getPreRevisadoDocumentacion())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--Fin de Documentación-->


<!--sjdh-->


</div>

<div class="prealta-footer">
<button id="validarCambios" class="btn btn-default" type="button" <?php
echo !$esPosibleValidar? "disabled" : "";
?> onClick="validar()"><i class="fa fa-check"></i> Validar</button>
</div>


<!--Inicia Modal-->
<div class="modal fade" id="ayc" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-revision">
<span><i class="fa fa-check-square"></i></span>
<h3><?php echo $oSubCadena->getNombre(); ?></h3>
<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
</div>
<div class="modal-body">
<h5 style="margin-bottom:30px;"><i class="fa fa-dollar"></i> Nuevos Cargos</h5>

<form class="form-horizontal">
                                     
                                     <div class="form-group">
                                          <label class="col-lg-2 control-label">Concepto:</label>
                                          <div class="col-lg-3">
                                       		<select class="form-control m-bot15" id="ddlConcepto">
											  <?php
											  	$catalogoConceptos = $oConceptos->cargarActivos();
												foreach ( $catalogoConceptos as $concepto ) {
													if ( !preg_match('!!u', $concepto[1]) ) {
														//no es utf-8
														$concepto[1] = utf8_encode($concepto[1]);
													}
													echo "<option value=\"{$concepto[0]}\">{$concepto[1]}</option>";
												}
											  ?>
                                            </select>
                                          </div>
                            
                                          
                        
                                          <label class="col-lg-1 control-label">Importe:</label>
                                          <div class="col-lg-2">
                                              <input type="text" class="form-control" id="txtImporte" maxlength="13" placeholder="">
                                          </div>
                                         
                                          
                                          
                                          <label class="col-lg-2 control-label">Fecha de Inicio:</label>
                                          <div class="col-lg-2">
                                      		<input class="form-control default-date-picker" id="txtFecha" maxlength="10">
                                      <span class="help-block">Seleccionar Fecha.</span>  
                                      </div>
                                      </div>                              
                                      
                                           <div class="form-group">
                                           <label class="col-lg-2 control-label">Observaciones:</label>
                                           <div class="col-lg-3">
                                           <textarea class="form-control" rows="3" id="txtObservaciones" maxlength="100"></textarea>
                                          </div>
                                          </div>
                                          
                                          <div class="form-group">
                                            <label class="col-lg-2 control-label">Configuraci&oacute;n:</label>
                                          <div class="col-lg-3">
                                       		<select class="form-control m-bot15" id="ddlTipo">
                                       			<option value="-1">Selecciona Configuraci&oacute;n</option>
                                              	<option value="0">Compartida</option>
                                              	<option value="1">Individual</option>
                                            </select>
                                          </div>
                                     
                                          
                                          </div>                                  
      </form>
                                   </div>
                                   <div class="modal-footer">
                                   	<input type="hidden" id="idPreCargo" value="" />
                                   	<button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button> 
            						<button type="button" class="btn btn-default" id="botonAgregar" onClick="agregarConcepto()">Agregar</button>
          						   </div>
</div>
</div>
</div>
</div>
<!--Cierre Modal-->


<!--Inicia Modal-->
<div class="modal fade" id="cayb" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-revision">
<span><i class="fa fa-check-square"></i></span>
<h3>Nombre de Sub Cadena</h3>
<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
</div>
<div class="modal-body">

<div class="legmed"> <i class="fa fa-home"></i> Corresponsal Bancario</div>

<form class="form-horizontal">
<div class="form-group">
														<label class="col-lg-2 control-label">Nuevo Banco:</label>
														<div class="col-lg-3" id="divddlBanco">
															<select class="form-control m-bot15" id="ddlBanco">
																<option value="-1">Elegir Banco</option>
															</select>
														</div>
														<div class="col-lg-2">
														<a href="#">Agregar <i class="fa fa-plus"></i></a>
														</div>
														
														<div id="divcorrbanc">
                                                        
                                                         <table class="tablabanco">
                                      						<tr>
                                                            	<th>Bancos Activos</th>
                                          						<th>Eliminar</th>
                                      						</tr>
                                                            <tr>
                                                            <td>Nombre de Banco</td>
                                      						<td class="accion">
                                                            	<i class="fa fa-times"></i>
                                                            </td>
                                      						</tr>
                                                         </table>
                                                        
                                                       </div>
														
													</div>

												</form>
											</div>
<div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
</div>
</div>
</div>
<!--Cierre Modal-->
</div>
</div>
</div> 
</div>
</div>
</section>
</section>

<input type="hidden" id="cadenaID" value="<?php echo $idCadena; ?>" />
<input type="hidden" id="subcadenaID" value="<?php echo $idSubCadena; ?>" />

<!--*.JS Generales-->
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Específicos-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>