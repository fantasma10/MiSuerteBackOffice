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


$idCorresponsal = (isset($_GET['id'])) ? $_GET['id'] :113;

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<title>.::Mi Red::.Validación de Corresponsal</title>
<!-- Núcleo BOOTSTRAP -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../css/miredgen.css" rel="stylesheet">
<link href="../../css/style-responsive.css" rel="stylesheet" />
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
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include("../../inc/menu.php"); ?>
<!--Final del Menú Vertical-->
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
                                 Validación<br> de Corresponsal
                              </span>
                          </div>
<div class="panel-body">
<a href="#modal" class="btn btnrevision" onClick="irABusqueda()">Nueva Búsqueda <i class="fa fa-search"></i></a>
<div class="room-desk">
<div class="row mini">
<div class="col-lg-3 col-sm-4 col-xs-8">
<div class="minipanel">
<div class="icono orange">
<i class="fa fa-3x fa-exclamation-circle"></i>
</div>
<div class="linea">
Estatus
</div>
<div class="dato">
Validado
</div>
</div>
</div>
<!--Referencia-->
<div class="col-lg-3 col-sm-4 col-xs-8">
<div class="minipanel">
<div class="icono yellow">
<i class="fa fa-3x fa-money"></i>
</div>
<div class="linea">
Referencia Bancaria
</div>
<div class="dato">
<?php
	$ref = $oCorresponsal->getReferenciaBancaria();
	if($ref == ""){
		$sub = $oCorresponsal->getTipoSubCadena();
		if($sub == 0){
			$str = $RBD->query("SELECT ref.`referencia`
								FROM `ops_cuenta` AS c
								JOIN `data_contable`.`dat_banco_ref` AS ref ON ref.`numCuenta` = c.`numCuenta`
								WHERE idSubCadena = $idSubCadena AND idCorresponsal = -1;");
			$res = mysqli_fetch_assoc($str);
			$ref = "SubCadena ".$res['referencia'];
		}
		else{
			$sql = "CALL `prealta`.`SP_LOAD_PRESUBCADENA`($idSubCadena);";
        	$res = $RBD->SP($sql);

        	if(!$RBD->error()){
        		$r = mysqli_fetch_array($res);
                $xml = simplexml_load_string($r[0]);
                $ref = 'PreSubCadena '.$xml->RefBancaria;
        	}
		}
	}
	echo $ref;
?>
</div>
</div>
</div>
</div>
<br>
<!--Panel-->


<!--Panel
<div style="margin-bottom:12px; margin-left:-3px; width:190px; float:left; margin-right:30px;">
<div class="minipanel">
<div class="icono yellow">
<i class="fa fa-3x fa-money"></i>
</div>
<div class="linea">
Referencia
</div>
<div class="dato">
YHS8SKN7S4S58KC8A
</div>
</div>
</div>
Panel
<div style="margin-bottom:12px; width:190px; float:left; margin-right:60px;">
<div class="minipanel">
<div class="icono red">
<i class="fa fa-3x fa-dollar"></i>
</div>
<div class="linea">
FORELO
</div>
<div class="dato">
<span class="forelo_rojo">7%</span>$1,520.08</div>
</div>
</div>
Room
<!--adkjgf-->

<div class="room-auto">
  <h5 class="text-primary"><i class="fa fa-dollar"></i> Afiliación y Cuotas</h5>
<table class="tablarevision-hc">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Concepto</th>
                                          <th class="theadtablita">Importe</th>
                                          <th class="theadtablita">Fecha de Inicio</th>
                                          <th class="theadtablita">Observaciones</th>
                                          <th class="theadtablita">Configuraci&oacute;n</th>
                                      </tr>
                                      </thead>
                                      <tbody class="tablapequena">                                     
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
													echo "</tr>";
												}										
											}
										}										
										
										if ( $debeCrearsePreAfiliacion && $debeCrearsePreCuota ) {
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
													echo "</tr>";
												}										
											} else {
												echo "<tr>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "<td class=\"tdtablita-o\"></td>";
												echo "</tr>";
											}										
										} else if ( !$debeCrearsePreAfiliacion && $debeCrearsePreCuota ) {
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
													echo "</tr>";											
											}
																  
									  	} else if ( $debeCrearsePreAfiliacion && !$debeCrearsePreCuota ) {
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
													echo "</tr>";											
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
													echo "</tr>";											
											}																						
										}
										?>
                                          </tbody></table></div>
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
                                          <div class="room-auto">
                                            <h5 class="text-primary"><i class="fa fa-dollar"></i> Corresponsal Bancario</h5>
                                          
                                          <table class="tablarevision">
<tr>
<td>Bancos Activos</td></tr>
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
</table>
<br>
</div>
<?php } ?>

<!--dfkdjf-->
<div class="room-auto">
  <h5 class="text-primary"><i class="fa fa-book"></i> Datos Generales</h5>
  
<table class="tablaauto">
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
$nombreGrupo = $oCorresponsal->getNombreGrupo();
if ( $nombreGrupo != "" ) {
	echo $nombreGrupo;
} else {
	echo "N/A";
}
?></td><td class="dato"><?php
$nombreReferencia = $oCorresponsal->getNombreReferencia();
if ( $nombreReferencia != "" ) {
	echo $nombreReferencia;
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
	echo utf8_encode($oCorresponsal->getNombreGiro());
} else {
	echo "N/A";
}
?></td></tr>
<td>No. Sucursal</td><td>Nombre de Sucursal</td></tr>
<td class="dato">
<?php
$numeroSucursal = $oCorresponsal->getNumSucu();
if ( $numeroSucursal != "" ) {
	echo $numeroSucursal;
} else {
	echo "N/A";
}
?>
</td><td class="dato">
<?php
$nombreSucursal = $oCorresponsal->getNomSucu();
if ( $nombreSucursal != "" ) {
	echo $nombreSucursal;
} else {
	echo "N/A";
}
?>
</td></tr>
<tr>
<td>Teléfono</td><td>Correo</td></tr>
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
</div>


<!--Versión-->
<div class="room-auto">
<h5 class="text-primary"><i class="fa fa-shopping-cart"></i> Versión</h5>
<div class="table-responsive">
<table class="tablarevision">
<tr>
<td>Versión</td></tr>
<tr>
<td class="dato">
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
	$oCorresponsal->setVersion($idVersion);
	echo $oCorresponsal->getNombreVersion();
?>
</td></tr>
</table></table><br></div></div>
<!--Fin de Versión-->

                             
<div class="room-auto">
<h5 class="text-primary"><i class="fa fa-map-marker"></i> Dirección y Horario</h5>


<table class="tablaauto">
<tr>
<td><i class="fa fa-home"></i> Dirección</td></tr>
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
</table>
<table class="tablarevision">
<tr>
<td><i class="fa fa-clock-o"></i> Horario</td></tr>
<div class="table-responsive">
</table>
<table class="tablarevision-hc" style="margin-bottom:22px;">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Lunes</th>
                                          <th class="theadtablita">Martes</th>
                                          <th class="theadtablita">Miércoles</th>
                                          <th class="theadtablita">Jueves</th>
                                          <th class="theadtablita">Viernes</th>
                                          <th class="theadtablita">Sábado</th>
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
                                      </tbody></table>
  </div>                                        


<div class="room-auto">
  <h5 class="text-primary"><i class="fa fa-users"></i> Contactos</h5>
  
<div class="table-responsive">
<table class="tablarevision-hc" style="margin-bottom:22px;">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Contacto</th>
                                          <th class="theadtablita">Teléfono</th>
                                          <th class="theadtablita">Extensión</th>
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
                                      </tbody></table><br>
</div>


</div>


<div class="room-auto">
<h5 class="text-primary"><i class="fa fa-credit-card"></i> Cuenta</h5>
<div class="table-responsive">
<table class="tablaauto">
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
<td>Banco</td><td>No. Cuenta</td><td>Beneficiario</td><td>Descripción</td></tr>
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
</table>
</div>
</div>

<!--Final de Cuenta-->
<!--Inicio de Documentación-->
<div class="room-auto">
<h5 class="text-primary"><i class="fa fa-folder"></i> Documentación</h5>
<div class="table-responsive">
<table class="tablaauto">
<tr><td>Archivos</td></tr>
<tr>
<td class="dato">Comprobante de Domicilio</td><td><button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 2, <?php echo $oCorresponsal->getDDomicilio()?>)"><i class="fa fa-folder-open"></i>Ver...</button></td></tr>
<?php if ( $tipoFORELO == 2 ) { ?>
<td class="dato">Carátula de Banco</td><td><button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 2, <?php echo $oCorresponsal->getDBanco()?>)"><i class="fa fa-folder-open"></i>Ver...</a></td></tr>
<?php } ?>
</table>  
</div>                 
</div>
<!--Fin de Documentación-->
<!--Fin del Desk-->
</div>

<div class="prealta-footer">
<div id="container" style="display:none;">
</div>
<?php if($idPerfil == 1 || $idPerfil == 4) { ?>
<button class="btn btn-default" type="button" onClick="irAAutorizarCorresponsal(<?php echo $idCorresponsal; ?>)">Ir a Autorización <i class="fa fa-mail-forward"></i> </button>
<?php } ?>
</div>


<!--Inicia Modal-->
<div class="modal fade" id="modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-revision">
<span><i class="fa fa-check-square"></i></span>
<h3>Nombre de Corresponsal</h3>
<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
</div>
<div class="modal-body">
<!--<h5 class="text-primary"><i class="fa fa-folder-open-o"></i> Nombre de Documento</h5>-->
<br>
<form class="form-horizontal">
<div class="form-group">
<label class="col-lg-1 control-label">Agregar:</label>
<div class="col-lg-4">
<select class="form-control m-bot15">
<option>Seleccione Banco</option>
<option>Un Banco</option>
<option>Banco</option>
</select>
</div>
<div class="col-lg-1"><a href="#"><i class="fa fa-plus"></i></a></div>
<label class="col-lg-1 control-label">Agregado:</label> <table><tr><td>Banco</td><td><a href="#"><i class="fa fa-times"></i></a></td></tr></table>
</div>
</form>
</div>

<div class="modal-footer">
                                              
                                              <button class="btn btn-success" type="button"><i class="fa fa-plus"></i> Agregar</button>
                                          </div>

</div>
</div>
</div>
<!--Cierre Modal-->
<!--Inicia Modal-->
<div class="modal fade" id="docu" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-revision">
<span><i class="fa fa-check-square"></i></span>
<h3>Nombre de Corresponsal</h3>
<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
</div>
<div class="modal-body">
<!--<h5 class="text-primary"><i class="fa fa-folder-open-o"></i> Nombre de Documento</h5>-->
<br>

</div>

<div class="modal-footer">
                                              
                                              
                                          </div>

</div>
</div>
</div>
<!--Cierre Modal-->
<!--Cierre Modal-->



</div>
</div>
</div> 
</div>
</div>
</section>
</section>



<!--*.JS Generales-->
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>