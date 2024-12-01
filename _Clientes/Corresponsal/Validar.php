<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreCorresponsal.php");

$idOpcion = 2;
$tipoDePagina = "Escritura";
$idPerfil = $_SESSION['idPerfil'];

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( $idPerfil != 1 && $idPerfil != 4 && $idPerfil != 7 ) {
	header("Location: ../../../error.php");
	exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="Corresponsal";
if(!isset($_SESSION['rec']))
    $_SESSION['rec'] = true;


$idCorresponsal = (isset($_GET['id'])) ? $_GET['id'] : -1;

if($idCorresponsal == -1){
    header('Location: ../../index.php');//redireccionar no existe la pre-cadena
}else{
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($idCorresponsal);
    if($oCorresponsal->getExiste()){
        $_SESSION['idPreCorresponsal'] = $idCorresponsal;
    }
    else
        header('Location: ../../index.php');//redireccionar no existe la pre-cadena   
}
$idCadena = $oCorresponsal->getIdCadena();
$idSubCadena = $oCorresponsal->getIdSubCadena();

$oConceptos = new Concepto($LOG, $RBD, '', '');

if ( $oCorresponsal->getPreRevisadoGenerales() && $oCorresponsal->getPreRevisadoDireccion()
&& $oCorresponsal->getPreRevisadoContactos() && $oCorresponsal->getPreRevisadoCargos() 
&& $oCorresponsal->getPreRevisadoVersion() && $oCorresponsal->getPreRevisadoCuenta()
&& $oCorresponsal->getPreRevisadoDocumentacion() && $oCorresponsal->getPreRevisadoBancos() ) {
	$esPosibleValidar = true;
}

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
<title>.::Mi Red::.Validaci&oacute;n de Corresponsal</title>
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
<script src="../../inc/js/_PrealtaPreCorresponsal.js" type="text/javascript"></script>
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
								$nombre = $oCorresponsal->getNombre();
								if ( !preg_match('!!u', $nombre) ) {
									echo $oCorresponsal->getNombre();
								}
								echo $nombre;                              
							  ?></h3>
                              <span class="rev-combo pull-right">
                                 Validaci&oacute;n<br> de Corresponsal
                              </span>
                          </div>
<div class="panel-body">
<button class="btn btnrevision" type="button" onClick="irABusqueda()">Nueva B&uacute;squeda <i class="fa fa-search"></i></button>
<div class="room-desk">
<div class="room-form">
  <h5 class="text-primary"><i class="fa fa-dollar"></i> Afiliaci&oacute;n y Cuotas</h5>

<table class="tablarevision">
<tr>
<td class="dato"><a href="#ayc" data-toggle="modal" onClick="prepararCamposCargo()">Nueva Cuota <i class="fa fa-plus"></i></a></td></tr></table>

<!--Inicio de la Tabla de Cuotas-->
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
										$oCargoCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $idCadena, -1, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);
										$tipoSubCadena = $oCorresponsal->getTipoSubCadena();
										$afiliacionesCadena = $oCargoCadena->cargarAfiliaciones();
										$cuotasCadena = $oCargoCadena->cargarCuotas();
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
										print_r($cuotasCadena);
										echo "</pre>";
										
										echo "<pre>";
										print_r($afiliacionesCadena);
										echo "</pre>";*/
										
										if ( $afiliacionesCadena['totalAfiliaciones'] == 0 ) {
											if ( $tipoSubCadena == 0 ) { //SubCadena Real
												//var_dump("TEST KLM");
												$oCargoSubCadena = new Cargo($LOG, $WBD, $RBD, NULL, -1, $idCadena, $idSubCadena, -1, $importe, $fechaInicio, $observaciones, "", 0, "", 0, $configuracion, $_SESSION['idU']);													
											} else if ( $tipoSubCadena == 1 ) { //SubCadena PRE
												$oCargoSubCadena = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);										
											}
											$afiliacionesSubCadena = $oCargoSubCadena->cargarAfiliaciones();
											/*echo "<pre>";
											print_r($afiliacionesSubCadena);
											echo "</pre>";*/
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
											/*echo "<pre>";
											print_r($cuotasSubCadena);
											echo "</pre>";*/
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
										
										if ( !$debeCrearsePreAfiliacion || !$debeCrearsePreCuota ) {
											$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, $idCorresponsal, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);
											$preCargos = $oPreCargo->cargarTodos();
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
											}
										}
										
										if ( $debeCrearsePreAfiliacion && $debeCrearsePreCuota ) {
											//var_dump("TEST A");
											//var_dump("TEST X");
											$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, $idSubCadena, $idCorresponsal, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);
											$preCargos = $oPreCargo->cargarTodos();
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
											//var_dump("TEST B");
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
													//echo "<td class=\"tdtablita-o\"></td>";
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
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "<td class=\"acciones\">";
													echo "</td>";
													echo "</tr>";
											} else if ( $quienHaPagadoAfiliacion == 1 ) {
													//var_dump("TEST C");
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
											if ( $quienHaPagadoCuota == 0 ) {
													//var_dump("TEST D");
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
											//Agregar Afiliacion
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
											}																						
										}
										?>
                                      </tbody>
                                      </table>
                                      </div>
                                          </div>
                                          <div class="checkbox">
<label><input type="checkbox" id="chkcargos" value="" <?php echo ($oCorresponsal->getPreRevisadoCargos())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--Fin-->
<?php
	if ( $tipoSubCadena == 1 ) {
		$sql = "CALL `redefectiva`.`SP_GET_VERSIONPRESUBCADENA`($idSubCadena);";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == "" ) {
			if ( $result->num_rows > 0 ) {
				$row = $result->fetch_array();
				if ( isset($row[0]) && $row[0] > 0 && $row[0] != "" ) {
					$idVersion = $row[0];
				} else {
					$idVersion = NULL;
				}	
			} else {
				$idVersion = NULL;
			}
		} else {
			$idVersion = NULL;
		}
	} else if ( $tipoSubCadena == 0 ) {
		$sql = "CALL `redefectiva`.`SP_GET_VERSIONSUBCADENA`($idSubCadena);";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == "" ) {
			if ( $result->num_rows > 0 ) {
				$row = $result->fetch_array();
				if ( isset($row[0]) && $row[0] > 0 && $row[0] != "" ) {
					$idVersion = $row[0];
				} else {
					$idVersion = NULL;
				}	
			} else {
				$idVersion = NULL;
			}
		} else {
			$idVersion = NULL;
		}			
	}	
	
	$sql = "CALL `redefectiva`.`SP_LOAD_FAMILIASDEVERSION`($idVersion);";
	$result = $RBD->SP($sql);
	if ( $RBD->error() == '' ) {
		if ( $result->num_rows > 0 ) {
			$familiasDeVersion = array();
			$index = 0;
			while ( $familia = $result->fetch_array() ) {
				$familiasDeVersion[$index] = $familia[1];
				$index++;
			}
			if ( in_array(3, $familiasDeVersion) ) {
				$tieneFamiliaBancos = true;
			} else {
				$tieneFamiliasBancos = false;
			}
		}
	}
	if ( $tieneFamiliaBancos ) {	
?>
<div class="room-form">
<!--Fin de la Tabla-->
  <h5 class="text-primary"><i class="fa fa-dollar"></i> Corresponsal Bancario</h5>
<table class="tablarevision">
<td class="dato"><a href="#cayb" data-toggle="modal">Agregar Banco <i class="fa fa-plus"></i></a></td></tr>
<span id="bancosDeCorresponsal">
<?php
	$corresponsalias = $oCorresponsal->getCorresponsalias();
	$data = "";
	foreach( $corresponsalias as $banco ){
		$nombreBanco = $oCorresponsal->getNombreCorresponsaliaBancaria($banco);
		$data .= "<tr>";
		$data .= "<td>$nombreBanco</td>";
		$data .= "</tr>";
	}
	echo $data;
?>
</span>
</table>
<br>
<!--<a class="btn btn-info btn-xs pull-right" href="#">Editar <i class="fa fa-pencil"></i></a>-->
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkbancos" value="" <?php echo ($oCorresponsal->getPreRevisadoBancos())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<?php } ?>
<!--adkjgf-->
<div class="room-box">
  <h5 class="text-primary"><i class="fa fa-book"></i> Datos Generales</h5>
  
<table class="tablarevision">
<tr>
<td>Cadena</td><td>Sub Cadena</td></tr>
<tr>
<td class="dato"><?php
$nombreCadena = $oCorresponsal->getNombreCadena();
if ( !preg_match('!!u', $nombreCadena) ) {
	$nombreCadena = utf8_encode($nombreCadena);
}
if ( $nombreCadena != "" ) {
	echo $nombreCadena;
} else {
	echo "N/A";
}
//echo $nombreCadena;
?></td><td class="dato"><?php
$nombreSubCadena = $oCorresponsal->getNombreSubCadena();
if ( !preg_match('!!u', $nombreSubCadena) ) {
	echo $oCorresponsal->getNombreSubCadena();
}
if ( $nombreSubCadena != "" ) {
	echo $nombreSubCadena;
} else {
	echo "N/A";
}
?></td></tr>
<tr>
<td>Grupo</td><td>Referencia</td></tr>
<tr>
<td class="dato"><?php
if ( $oCorresponsal->getNombreGrupo() != "" ) {
	echo $oCorresponsal->getNombreGrupo();
} else {
	echo "N/A";
}
?></td><td class="dato"><?php
if ( $oCorresponsal->getNombreReferencia() != "" ) {
	echo $oCorresponsal->getNombreReferencia();
} else {
	echo "N/A";
}
?></td></tr>
<tr>
<td>Giro</td></tr>
<tr>
<td class="dato"><?php
$nombreGiro = $oCorresponsal->getNombreGiro();
if ( $nombreGiro != "" ) {
	echo acentos($nombreGiro);
} else {
	echo "N/A";
}
?></td></tr>
<td>No. Sucursal</td><td>Nombre de Sucursal</td></tr>
<td class="dato"><?php
$numeroSucursal = $oCorresponsal->getNumSucu();
if ( $numeroSucursal != "" ) {
	echo $numeroSucursal;
} else {
	echo "N/A";
}
?></td><td class="dato"><?php
$nombreSucursal = $oCorresponsal->getNomSucu();
if ( $nombreSucursal != "" ) {
	echo $nombreSucursal;
} else {
	echo "N/A";
}
?></td></tr>
<tr>
<td>Tel&eacute;fono</td><td>Correo</td></tr>
<td class="dato"><?php
$telefono = $oCorresponsal->getTel1();
if ( $telefono != "" ) {
	echo $telefono;
} else {
	echo "N/A";
}
?></td><td class="dato"><?php
$correo = $oCorresponsal->getCorreo();
if ( $correo != "" ) {
	echo $correo;
} else {
	echo "N/A";
}
?></td></tr>
<tr>
<td>IVA</td></tr>
<tr>
<td class="dato"><?php
$nombreIVA = $oCorresponsal->getNombreIva();
if ( $nombreIVA != "" ) {
	echo $nombreIVA;
} else {
	echo "N/A";
}
?></td></tr>
</table>
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(1, false)" >Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkgenerales" value="" <?php echo ($oCorresponsal->getPreRevisadoGenerales())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>

<!--Versión-->
<div class="room-box">
<h5 class="text-primary"><i class="fa fa-shopping-cart"></i> Versi&oacute;n</h5>
<div class="table-responsive">
<table class="tablarevision">
<tr>
<td>Versi&oacute;n</td></tr>
<tr>
<td class="dato">
<?php
	if ( $tipoSubCadena == 1 ) {
		$sql = "CALL `prealta`.`SP_GET_VERSIONPRESUBCADENA`($idSubCadena);";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == "" ) {
			if ( $result->num_rows > 0 ) {
				$row = $result->fetch_array();
				if ( isset($row[0]) && $row[0] > 0 && $row[0] != "" ) {
					$idVersion = $row[0];
				} else {
					$idVersion = NULL;
				}	
			} else {
				$idVersion = NULL;
			}
		} else {
			$idVersion = NULL;
		}
	} else if ( $tipoSubCadena == 0 ) {
		$sql = "CALL `redefectiva`.`SP_GET_VERSIONSUBCADENA`($idSubCadena);";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == "" ) {
			if ( $result->num_rows > 0 ) {
				$row = $result->fetch_array();
				if ( isset($row[0]) && $row[0] > 0 && $row[0] != "" ) {
					$idVersion = $row[0];
				} else {
					$idVersion = NULL;
				}	
			} else {
				$idVersion = NULL;
			}
		} else {
			$idVersion = NULL;
		}			
	}
	$oCorresponsal->setVersion($idVersion);
	echo $oCorresponsal->getNombreVersion();	
?>
</td></tr>
</table></table></div></div>
<div class="checkbox">
<label><input type="checkbox" id="chkversion" value="" <?php echo ($oCorresponsal->getPreRevisadoVersion())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--Fin de Versión-->


                             
<div class="room-box">
<h5 class="text-primary"><i class="fa fa-map-marker"></i> Direcci&oacute;n y Horario</h5>
<div class="row">
<div class="col-lg-4 col-sm-14">
<table class="tablarevision">
<tr>
<td><i class="fa fa-home"></i> Direcci&oacute;n</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oCorresponsal->getCalle() != '' && $oCorresponsal->getNext() != ''
	&& $oCorresponsal->getColonia() != '' && $oCorresponsal->getCP() != '' && $oCorresponsal->getNombreCiudad() != ''
	&& $oCorresponsal->getNombreEstado() != '' && $oCorresponsal->getNombrePais() != '' ) {
		if ( $oCorresponsal->getCalle() != '' )
			echo utf8_encode($oCorresponsal->getCalle()); 
		if ( $oCorresponsal->getCalle() != '' && $oCorresponsal->getNext() != '' )    
			echo " No. ".$oCorresponsal->getNext();
		if ( $oCorresponsal->getCalle() != '' && $oCorresponsal->getNint() != '' )
			echo " No. Int. ".$oCorresponsal->getNint();
		
		echo "<br />";
		
		if ( $oCorresponsal->getColonia() != '' )
			echo "Col. ".utf8_encode($oCorresponsal->getNombreColonia());
		if ( $oCorresponsal->getCP() != '' )
			echo " C.P. ".$oCorresponsal->getCP();
		
		echo "<br />";										
		
		if ( $oCorresponsal->getColonia() != '' && $oCorresponsal->getNombreCiudad() != '' )
			echo utf8_encode($oCorresponsal->getNombreCiudad());                                    
		if ( $oCorresponsal->getNombreEstado() != '' )
			echo ", ".utf8_encode($oCorresponsal->getNombreEstado());
		if ( $oCorresponsal->getNombreEstado() != '' && $oCorresponsal->getNombrePais() )
			echo ", ".utf8_encode($oCorresponsal->getNombrePais());
	} else {
		echo "N/A";
	}
?>
</td></tr>
<tr><td style="font-size:10px;"><button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 2, <?php echo $oCorresponsal->getDDomicilio()?>)"> <i class="fa fa-folder-open"></i>Ver Comprobante de Domicilio.</button></td></tr>
</table>
</div>

<div class="col-lg-12 col-sm-12">
<table class="tablarevision">
<tr>
<td><i class="fa fa-clock-o"></i> Horario</td></tr>
</table>
</div>
</div>
<div class="table-responsive">
<table class="tablarevision-hc">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Lunes</th>
                                          <th class="theadtablita">Martes</th>
                                          <th class="theadtablita">Mi&eacute;rcoles</th>
                                          <th class="theadtablita">Jueves</th>
                                          <th class="theadtablita">Viernes</th>
                                          <th class="theadtablita">S&aacute;bado</th>
                                          <th class="theadtablita">Domingo</th>
                                          </tr>
                                      </thead>
                                      <tbody class="tablapequena">                                     
                                          <tr>
                                          <td class="tdtablita"><?php echo $oCorresponsal->getHDe1()." ".$oCorresponsal->getHA1(); ?></td>
                                          <td class="tdtablita"><?php echo $oCorresponsal->getHDe2()." ".$oCorresponsal->getHA2(); ?></td>
                                          <td class="tdtablita"><?php echo $oCorresponsal->getHDe3()." ".$oCorresponsal->getHA3(); ?></td>
                                          <td class="tdtablita"><?php echo $oCorresponsal->getHDe4()." ".$oCorresponsal->getHA4(); ?></td>
                                          <td class="tdtablita"><?php echo $oCorresponsal->getHDe5()." ".$oCorresponsal->getHA5(); ?></td>
                                          <td class="tdtablita"><?php echo $oCorresponsal->getHDe6()." ".$oCorresponsal->getHA6(); ?></td>
                                          <td class="tdtablita"><?php echo $oCorresponsal->getHDe7()." ".$oCorresponsal->getHA7(); ?></td>
                                          </tr>
                                      </tbody>
                                      </table></div>
                                          
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(2, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkdireccion" value="" <?php echo ($oCorresponsal->getPreRevisadoDireccion())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>




<div class="room-box">
  <h5 class="text-primary"><i class="fa fa-users"></i> Contactos</h5>
  
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
										$tipoContacto	= 0;
										$categoria		= (!empty($_POST["categoria"]))? $_POST["categoria"] : 3;
							
										$query = "CALL `prealta`.`SP_LOAD_PRECONTACTOS_GENERAL`($idCorresponsal, $tipoContacto, $categoria)";
							
										$emptyRow = "<tr>
											<td class='tdtablita'>&nbsp;</td>
											<td class='tdtablita'>&nbsp;</td>
											<td class='tdtablita'>&nbsp;</td>
											<td class='tdtablita'>&nbsp;</td>
											<td class='tdtablita'>&nbsp;</td></tr>";
							
										$sql = $RBD->query($query);
							
										if(!$RBD->error()){
											if(mysqli_num_rows($sql) > 0){
												while($row = mysqli_fetch_assoc($sql)){
													echo "<tr>";
														echo "<td class='tdtablita'>".((!preg_match("!!u", $row['nombreCompleto']))? utf8_encode($row['nombreCompleto']) : $row['nombreCompleto'])."</td>";
														echo "<td class='tdtablita'>".$row['telefono1']."</td>";
														echo "<td class='tdtablita'>".$row['extTelefono1']."</td>";
														echo "<td class='tdtablita'>".$row['correoContacto']."</td>";
														echo "<td class='tdtablita'>".((!preg_match("!!u", $row['descTipoContacto']))? utf8_encode($row['descTipoContacto']) : $row['descTipoContacto'])."</td>";
													echo "</tr>";
												}
											}
											else{
												echo $emptyRow;
											}
										}
										else{
											echo $emptyRow;
										}					  
                                      ?>
                                      </tbody></table>

<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(3, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkcontactos" value="" <?php echo ($oCorresponsal->getPreRevisadoContactos())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>


<!--jdh-->

<div class="room-box">
<h5 class="text-primary"><i class="fa fa-credit-card"></i> Cuenta</h5>
<div class="table-responsive">
<table class="tablarevision">
<tr>
<td>Tipo FORELO</td></tr>
<tr>
<td class="dato">
<?php
	$tipoFORELO = $oCorresponsal->getTipoFORELO();
	switch ( $tipoFORELO ) {
		case 1:
			echo "Compartido";
		break;
		case 2:
			echo "Individual";													
		break;
		default:
			echo "N/A";											
		break;
	}
?>
</td></tr>

<tr>
<td>CLABE</td></tr>
<tr><td class="dato">
<?php
	if ( $tipoFORELO == 2 ) {
		$CLABE = $oCorresponsal->getClabe();
		if ( !preg_match('!!u', $CLABE) ) {
			$CLABE = utf8_encode($CLABE);
		}
		if ( isset($CLABE) && $CLABE != "" ) {
			echo $CLABE;
		}
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
	if ( $tipoFORELO == 2 ) {
		$idBanco = $oCorresponsal->getIdBanco();
		echo $oCorresponsal->getNombreBanco($idBanco);
	} else {
		echo "N/A";
	}
?>
</td><td class="dato">
<?php
	if ( $tipoFORELO == 2 ) {
		$numeroDeCuenta = $oCorresponsal->getNumCuenta();
		if ( !preg_match('!!u', $numeroDeCuenta) ) {
			//no es utf-8
			$numeroDeCuenta = utf8_encode($numeroDeCuenta);
		}
		if ( isset($numeroDeCuenta) && $numeroDeCuenta != "" ) {
			echo $numeroDeCuenta;
		}
	} else {
		echo "N/A";
	}
?>
</td><td class="dato">
<?php
	if ( $tipoFORELO == 2 ) {
		$numeroDeCuenta = $oCorresponsal->getNumCuenta();
		if ( !preg_match('!!u', $numeroDeCuenta) ) {
			//no es utf-8
			$numeroDeCuenta = utf8_encode($numeroDeCuenta);
		}
		if ( isset($numeroDeCuenta) && $numeroDeCuenta != "" ) {
			echo $numeroDeCuenta;
		}
	} else {
		echo "N/A";
	}
?>
</td><td class="dato">
<?php
	if ( $tipoFORELO == 2 ) {
		$descripcion = $oCorresponsal->getDescripcion();
		if ( !preg_match('!!u', $descripcion) ) {
			//no es utf-8
			$descripcion = utf8_encode($descripcion);
		}
		echo $descripcion;
	} else {
		echo "N/A";
	}
?>
</td>
</tr>
<tr><td style="font-size:10px;"><button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 2, <?php echo $oCorresponsal->getDDomicilio()?>)"> <i class="fa fa-folder-open"></i>Ver Comprobante de Domicilio.</button></td></tr>
</table>
</div>
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(4, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkcuenta" value="" <?php echo ($oCorresponsal->getPreRevisadoCuenta())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--Final de Cuenta-->
<!--Inicio de Documentación-->
<div class="room-box">
<h5 class="text-primary"><i class="fa fa-folder"></i> Documentaci&oacute;n</h5>
<div class="table-responsive">
<table class="tablarevision">
<tr><td>Archivos</td></tr>
<tr>
<td class="dato">Comprobante de Domicilio</td><td><button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 2, <?php echo $oCorresponsal->getDDomicilio()?>)"><i class="fa fa-folder-open"></i>Ver...</button></td></tr>
<?php if ( $tipoFORELO == 2 ) { ?>
<td class="dato">Car&aacute;tula de Banco</td>
<td>
	<button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 2, <?php echo $oCorresponsal->getDBanco()?>)"><i class="fa fa-folder-open"></i>Ver...</button>
</td></tr>
<?php } ?>
</table>  
</div>                 
<a class="btn btn-info btn-xs pull-right" href="#" onClick="CambioPagina(5, false)">Editar <i class="fa fa-pencil"></i></a>
</div>
<div class="checkbox">
<label><input type="checkbox" id="chkdocumentacion" value="" <?php echo ($oCorresponsal->getPreRevisadoDocumentacion())? "checked" : ""; ?> onChange="PreValidarSeccionesPreSubCadena()">Secci&oacute;n Validada.</label></div>
<!--Fin de Documentación-->
<!--Fin del Desk-->
</div>

<div class="prealta-footer">
<button class="btn btn-default" id="validarCambios" type="button" href="#" <?php
echo !$esPosibleValidar? "disabled" : "";
?> onClick="validar()"> <i class="fa fa-check"></i> Validar</a> </button>
</div>


<!--Inicia Modal-->
<div class="modal fade" id="ayc" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-revision">
<span><i class="fa fa-check-square"></i></span>
<h3><?php echo $oCorresponsal->getNombre(); ?></h3>
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
      </form>
                                   </div>
                                   <div class="modal-footer">
                                   	<input type="hidden" id="idPreCargo" value="" />
                                   	<button class="btn btn-success" data-dismiss="modal" type="button">Cerrar</button> 
            						<button type="button" id="botonAgregar" class="btn btn-default" onClick="agregarConcepto()">Agregar</button>
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
<h3><?php echo $oCorresponsal->getNombre(); ?></h3>
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
																<?php
                                                                    $query = "CALL `prealta`.`SP_LOAD_PRECORRESPONSALIAS`($idCorresponsal);";
                                                                    $result = $RBD->SP($query);
                                                                    if ( $RBD->error() == "" ) {
                                                                        while ( $row = mysqli_fetch_assoc($result) ) {
                                                                            echo "<option value=\"{$row['idBanco']}\">{$row['descBanco']}</option>";
                                                                        }
                                                                    }
                                                                ?>
															</select>
														</div>
														<div class="col-lg-2">
														<a href="#" onClick="agregarBanco()">Agregar <i class="fa fa-plus"></i></a>
														</div>
														
														<div id="divcorrbanc">
                                                        
                                                         <table class="tablabanco">
                                      						<tr>
                                                            	<th>Bancos Activos</th>
                                          						<th>Eliminar</th>
                                      						</tr>
																<?php
                                                                    $query = "CALL `prealta`.`SP_LOAD_BANCOSPRECORRESPONSAL`($idCorresponsal);";
																	$result = $RBD->SP($query);
																	if ( $RBD->error() == "" ) {
                                                                        while ( $row = mysqli_fetch_assoc($result) ) {
                                                                            echo "<tr>";
																			echo "<td>{$row['descBanco']}</td>";
                                                                            echo "<td class=\"accion\">";
                                                                            echo "<a href=\"#\" onClick=\"eliminarCorresponsalia( $idCorresponsal, {$row['idBanco']} )\"><i class=\"fa fa-times\"></i></a>";
                                                                            echo "</td>";
																			echo "</tr>";
                                                                        }
                                                                    }
                                                                ?>
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
<input type="hidden" id="corresponsalID" value="<?php echo $idCorresponsal; ?>" />

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