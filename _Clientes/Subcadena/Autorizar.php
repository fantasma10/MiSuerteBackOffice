<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include("../../inc/config.inc.php");
	include("../../inc/session.inc.php");
	include("../../inc/obj/XMLPreSubCadena.php");


	$idOpcion = 2;
	$tipoDePagina = "Escritura";
	$idPerfil = $_SESSION['idPerfil'];

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location: ../../../error.php");
		exit();
	}

	if ( $idPerfil != 1 && $idPerfil != 4 ) {
		header("Location: ../../../error.php");
		exit();
	}

	$submenuTitulo = "Pre-Alta";
	$subsubmenuTitulo ="Corresponsal";

	if(!isset($_SESSION['rec'])){
		$_SESSION['rec'] = true;
	}

	$idSubCadena = (!empty($_POST['idSubCadena'])) ? $_POST['idSubCadena'] : 0/*3*/;

	if($idSubCadena == -1){
		header('Location: ../../index.php');//redireccionar no existe la pre-cadena
	}
	else{
		$oSubCadena = new XMLPreSubCad($RBD,$WBD);
		$oSubCadena->load($idSubCadena);

		if($oSubCadena->getExiste()){
			$_SESSION['idPreCadena'] = $idSubCadena;
			$idCadena = $oSubCadena->getIdCadena();
		}
		else{
			//echo "<pre>"; echo var_dump("<h2>No existe el Precorresponsal : $idSubCadena</h2>"); echo "</pre>";
			header('Location: ../../index.php');//redireccionar no existe la pre-cadena
		}	
	}
	
	/*$referencia1 = $oSubCadena->getReferenciaBancaria();
	echo "referencia1: $referencia1";*/

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
	<title>.::Mi Red::.Autorización de Sub Cadena</title>
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

<?php
	function wordmatch($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}
?>

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
				<h3><?php echo wordmatch($oSubCadena->getNombre());?></h3>
				<span class="rev-combo pull-right">
					 Autorización<br/> de Sub Cadena
				</span>
			</div>

			<div class="panel-body">
				<button class="btn btnrevision" type="button" onClick="irABuscarSubCadena();">Nueva Búsqueda <i class="fa fa-search"></i></button>
				<div class="room-desk">
					<div class="row mini">
						<!--Mini Panel-->
						<div class="col-lg-3 col-sm-4 col-xs-8">
							<div class="minipanel">
								<div class="icono red">
									<i class="fa fa-3x fa-dollar"></i>
								</div>
								<div class="linea">
									Saldo a Favor
								</div>
								<div class="dato">
									<?php
										$referencia = $oSubCadena->getReferenciaBancaria();
										$sql = $RBD->query("CALL `prealta`.`SP_SUMA_DEPOSITOS_CARGOS`('$referencia', -1, -1, -1)");
										$row = mysqli_fetch_assoc($sql);

										echo "\$".number_format($row['importe_depositos'], 2);
									?>
								</div>
							</div>
						</div>
						<a href="#PagoAgregar"   data-toggle="modal" class="btn btn-success btn-xs" style="margin-top:18px; background:#c82647; border:1px solid #c82647; ">Registrar Pago <i class="fa fa-plus"></i></a>
						<!--Final de los Mini Paneles-->
					</div>

					<br/>
					<!--adkjgf-->
					<div class="room-formauto">
						<h5 class="text-primary">
							<i class="fa fa-dollar"></i> Afiliación y Cuotas
						</h5>

						<?php
							/*$emptyRow = "<tr><td colspan='5' class='tdtablita-o'>No hay informaci&oacute;n para mostrar</td></tr>";

								$oPreCargo = new PreCargo($LOG, $WBD, $RBD, null, null, $oSubCadena->getIdCadena(), $oSubCadena->getID(), -1, 0, "", "", "", 0, 0, 0);
								$cargos = $oPreCargo->cargarTodos();
								$cuenta = count($cargos);*/

								//if($cuenta > 0){
							?>
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
											//$debeCrearsePreAfiliacion = true;
										} else {
											$debeCrearsePreAfiliacion = false;
											$quienHaPagadoAfiliacion = 0;
										}
										
										if ( $cuotasCadena['totalCuotas'] == 0 ) {
											//$debeCrearsePreCuota = true;				
										} else {
											$debeCrearsePreCuota = false;
											$quienHaPagadoCuota = 0;
										}
										
										/*var_dump("debeCrearsePreAfiliacion: $debeCrearsePreAfiliacion");
										var_dump("debeCrearsePreCuota: $debeCrearsePreCuota");*/
										
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
													echo "</tr>";
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
													echo "</tr>";											
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
													echo "</tr>";											
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
													echo "</tr>";											
											}																						
										}
									  ?>
									
									<?php
										/*if($cuenta > 0){
											foreach($cargos AS $cargo){
												$cfg = ($cargo['Configuracion'] == 0)? 'Compartido' : 'Individual';
												echo '<tr>';
													echo '<td class="tdtablita-o">'.wordmatch($cargo['nombreConcepto']).'</td>';
													echo '<td class="tdtablita-o" style="text-align:right;">$'.number_format($cargo['importe'], 2).'</td>';
													echo '<td class="tdtablita-o">'.$cargo['fechaInicio'].'</td>';
													echo '<td class="tdtablita-o">'.wordmatch($cargo['observaciones']).'</td>';
													echo '<td class="tdtablita-o">'.$cfg.'</td>';
												echo '</tr>';
											}
										}
										else{
											echo $emptyRow;
										}*/
									?>
								</tbody>
							</table>
						<?php
							//}
						?>
					</div>

					<!--dfkdjf-->
					<!--Inicio de Datos Generales-->
					<div class="room-auto">
						<h5 class="text-primary">
							<i class="fa fa-book"></i> Datos Generales
						</h5>
						<div class="table-responsive">
							<table class="tablarevision">
								<tr>
									<td>Cadena</td>
								</tr>
								<tr>
									<td class="dato"><?php echo wordmatch($oSubCadena->getNombreCadena());?></td>
								</tr>
								<tr>
									<td>Grupo</td>
									<td>Referencia</td>
								</tr>
								<tr>
									<td class="dato"><?php echo wordmatch($oSubCadena->getNombreGrupo())?></td>
									<td class="dato"><?php echo wordmatch($oSubCadena->getNombreReferencia())?></td>
								</tr>
								<tr>
									<td>Teléfono</td>
									<td>Correo</td>
								</tr>
								<tr>
									<td class="dato"><?php echo wordmatch($oSubCadena->getTel1())?></td>
									<td class="dato"><?php echo wordmatch($oSubCadena->getCorreo());?></td>
								</tr>
							</table>
							<br/>
						</div>
					</div>
					<!--Final de D	atos Generales-->
					<!--Inicio de Dirección-->
					<div class="room-auto">
						<h5 class="text-primary">
							<i class="fa fa-map-marker"></i> Dirección
						</h5>
						<table class="tablarevision">
							<tr>
								<td>
									<i class="fa fa-home"></i> Dirección
								</td>
							</tr>
							<tr>
								<td class="dato">
									<?php
										$dir = wordmatch($oSubCadena->getCalle())." ".$oSubCadena->getNint()." ".$oSubCadena->getNext();
										$dir.= "<br/>Col. ".wordmatch($oSubCadena->getNombreColonia())." C.P.".$oSubCadena->getCp();
										$dir.= "<br/>".wordmatch($oSubCadena->getNombreCiudad()).", ".wordmatch($oSubCadena->getNombreEstado()).", ".wordmatch($oSubCadena->getNombrePais());

										echo $dir;
									?>
								</td>
							</tr>
						</table>
						<br/>
					</div>
					<!--Final de Dirección-->
					<!--Inicio de Contactos-->
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
										$query = "CALL `prealta`.`SP_LOAD_PRECONTACTOS_GENERAL`($idSubCadena, 0, 2)";

										$emptyRow = "<tr>
											<td class='tdtablita'>&nbsp;</td>
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
														echo "<td class='tdtablita-o'>".((!preg_match("!!u", $row['nombreCompleto']))? utf8_encode($row['nombreCompleto']) : $row['nombreCompleto'])."</td>";
														echo "<td class='tdtablita-o'>".$row['telefono1']."</td>";
														echo "<td class='tdtablita-o'>".$row['extTelefono1']."</td>";
														echo "<td class='tdtablita-o'>".$row['correoContacto']."</td>";
														echo "<td class='tdtablita-o'>".((!preg_match("!!u", $row['descTipoContacto']))? utf8_encode($row['descTipoContacto']) : $row['descTipoContacto'])."</td>";
													echo "</tr>";
												}
											}
											else{
												echo $emptyRow;
											}
										}
										else{
											echo $emptyRow;
											echo "<pre>"; echo var_dump($RBD->error()); echo "</pre>";
										}
									?>
								</tbody>
							</table>
							<br/>
						</div>
					</div>
					<!--Fin de Contacto-->
					<!--Inicio Contrato-->
					<div class="room-auto">
						<h5 class="text-primary">
							<i class="fa fa-file"></i> Contrato
						</h5>
						<div class="table-responsive">
							<table class="tablarevision">
								<tr>
									<td>Régimen</td>
									<td>RFC</td>
								</tr>
								<tr>
									<td class="dato">
										<?php
											switch($oSubCadena->getCRegimen()){
												case 1:
													echo 'F&iacute;sica';
												break;
												case 2:
													echo 'Moral';
												break;
												default:
													echo '';
												break;												
											}
										?>
									</td>
									<td class="dato"><?php echo $oSubCadena->getCRfc(); ?></td>
								</tr>
								<tr>
									<td>Raz&oacute;n Social</td>
									<td>Fecha de Constituci&oacute;n</td>
								</tr>
								<tr>
									<td class="dato"><?php echo wordmatch($oSubCadena->getCRSocial());?></td>
									<td class="dato"><?php echo wordmatch($oSubCadena->getCFConstitucion());?></td>
								</tr>
							</table>
							<br/>
							<table class="tablarevision">
								<tr>
									<td>Representante Legal</td>
								</tr>
								<tr>
									<td class="dato">
										<?php
											$nombreCompletoRepLegal = $oSubCadena->getCNombre()." ".$oSubCadena->getCPaterno()." ".$oSubCadena->getCMaterno();
											echo wordmatch($nombreCompletoRepLegal);
										?>
									</td>
								</tr>
							</table>
							<br/>
							<table class="tablarevision">
								<tr>
									<td>No. de Identificación</td>
									<td>Tipo de Identificación</td>
								</tr>
								<tr>
									<td class="dato"><?php echo $oSubCadena->getCNumIden();?></td>
									<td class="dato"><?php echo $oSubCadena->getNombreCRTipoIden();?></td>
								</tr>
								<tr>
									<td>RFC</td>
									<td>CURP</td>
								</tr>
								<tr>
									<td class="dato"><?php echo $oSubCadena->getCRRfc(); ?></td>
									<td class="dato"><?php echo $oSubCadena->getCCurp(); ?></td>
								</tr>
								<tr>
									<td>Figura Políticamente Expuesta</td>
									<td>Familia Políticamente Expuesta</td>
								</tr>
								<tr>
									<td class="dato"><?php echo ($oSubCadena->getCFigura() == 0 && $oSubCadena->getCFigura() != "")? 'S&iacute;' : 'No';?></td>
									<td class="dato"><?php echo ($oSubCadena->getCFamilia()== 0 && $oSubCadena->getCFamilia() != "")? 'S&iacute;' : 'No'; ?></td>
								</tr>
							</table>

							<br/><!--Salto de la Tabla-->

							<table class="tablarevision">
								<tr>
									<td>Dirección Fiscal</td>
								</tr>
								<tr>
									<td class="dato">
										<?php
											$dir = wordmatch($oSubCadena->getCCalle())." ".$oSubCadena->getCNint()." ".$oSubCadena->getCNext();
											$dir.= "<br/>Col. ".wordmatch($oSubCadena->getCNombreColonia())." C.P.".$oSubCadena->getCCp();
											$dir.= "<br/>".wordmatch($oSubCadena->getCNombreCiudad()).", ".wordmatch($oSubCadena->getCNombreEstado()).", ".wordmatch($oSubCadena->getCNombrePais());

											echo $dir;
										?>
									</td>
								</tr>
							</table>
							<br/>
						</div>
					</div>
					<!--Fin de Contrato-->
					<!--Versión-->
					<div class="room-auto">
						<h5 class="text-primary">
							<i class="fa fa-shopping-cart"></i> Versión
						</h5>
						<div class="table-responsive">
							<table class="tablarevision">
								<tr>
									<td>Versión</td>
									<td>Comisiones Personalizadas</td>
								</tr>
								<tr>
									<td class="dato"><?php echo wordmatch($oSubCadena->getNombreVersion());?></td>
									<td>                                    
										<a href="#" onClick="agregarComisionesEspeciales(<?php echo $oSubCadena->getIdCadena()?>, <?php echo $oSubCadena->getID()?>, -1, <?php echo $oSubCadena->getIdGrupo()?>, <?php echo $oSubCadena->getVersion()?>, '../_Clientes/Subcadena/Autorizar.php', '<?php echo $oSubCadena->getNombre()?>');">Agregar <i class="fa fa-plus"></i></a>
										<?php
											//echo "CALL `prealta`.`SP_GET_PRECOMISIONES`({$oSubCadena->getIdCadena()}, {$oSubCadena->getID()}, -1)";
											$sql = $RBD->query("CALL `prealta`.`SP_GET_PRECOMISIONES`({$oSubCadena->getIdCadena()}, {$oSubCadena->getID()}, -1)");
											if(!$RBD->error()){
												$comisionesPorAutorizar = mysqli_num_rows($sql);
												if($comisionesPorAutorizar > 0){
													echo "<span class='dato'>".$comisionesPorAutorizar." Pendientes de Autorizaci&oacute;n</span>";
												}
											}
										?>
									</td>
								</tr>
							</table>
							<br/>
						</div>
					</div>
					<!--Fin de Versión-->
					<!--Inicio de Cuenta-->
					<div class="room-auto">
						<h5 class="text-primary">
							<i class="fa fa-credit-card"></i> Cuenta
						</h5>
						<div class="table-responsive">
						<table class="tablarevision">
							<tr>
								<td>CLABE</td>
							</tr>
							<tr>
								<td class="dato"><?php echo $oSubCadena->getClabe();?></td>
							</tr>
							<tr>
								<td>Banco</td>
								<td>No. Cuenta</td>
								<td>Beneficiario</td>
								<td>Descripción</td>
							</tr>
							<tr>
								<td class="dato"><?php echo wordmatch($oSubCadena->getNombreBanco());?></td>
								<td class="dato"><?php echo $oSubCadena->getNumCuenta();?></td>
								<td class="dato"><?php echo wordmatch($oSubCadena->getBeneficiario());?></td>
								<td class="dato"><?php echo wordmatch($oSubCadena->getDescripcion());?></td>
							</tr>
						</table>
						<br/>
					</div>
				</div>
				<!--Final de Cuenta-->
				<!--Inicio de Documentación-->
				<!--Versión-->
				<div class="room-auto">
					<h5 class="text-primary"><i class="fa fa-folder"></i> Documentación</h5>
					<div class="table-responsive">
						<table class="tablaauto">
							<tr>
								<td>Archivos</td>
							</tr>
							<tr>
								<td class="dato">Comprobante de Domicilio</td>
								<td>
									<?php if($oSubCadena->getDDomicilio() != ''){ ?>
									<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDDomicilio()?>)">
										<i class="fa fa-folder-open"></i>Ver...
									</button>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td class="dato">Carátula de Banco</td>
								<td>
									<?php if($oSubCadena->getDBanco() != ''){ ?>
									<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDBanco()?>)">
										<i class="fa fa-folder-open"></i>Ver...
									</button>
									<?php }?>
								</td>
							</tr>
							<tr>
								<td class="dato">Identificación del Representante Legal</td>
								<td>
									<?php if($oSubCadena->getDRepLegal() != ''){ ?>
									<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDRepLegal()?>)">
										<i class="fa fa-folder-open"></i>Ver...
									</button>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td class="dato">RFC Razón Social</td>
								<td>
									<?php if($oSubCadena->getDRSocial() != ''){ ?>
									<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDRSocial()?>)">
										<i class="fa fa-folder-open"></i>Ver...
									</button>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td class="dato">Comprobante de Domicilio Fiscal</td>
								<td>
									<?php if($oSubCadena->getDFiscal() != ''){ ?>
									<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDFiscal()?>)">
										<i class="fa fa-folder-open"></i>Ver...
									</button>
									<?php }?>
								</td>
							</tr>
							<?php if($oSubCadena->getCRegimen() == 2){?>
							<tr>
								<td class="dato">Acta Constitutiva</td>
								<td>
									<?php if($oSubCadena->getDAConstitutiva() != ''){ ?>
									<button class="btn btn-link" onClick="showComprobante(<?php echo $oSubCadena->getID()?>, 2, <?php echo $oSubCadena->getDAConstitutiva()?>)">
										<i class="fa fa-folder-open"></i>Ver...</button>
									<?php } ?>
								</td>
							</tr>
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
							<?php }?>
						</table>
					</div>
				</div>
				<!--Fin de Documentación-->
			</div>
			<!--Pié-->
			<div class="prealta-footer">
				<?php
					if($comisionesPorAutorizar == 0){
				?>
				<button class="btn btn-default" type="button" onClick="autorizarSubCadena(<?php echo $oSubCadena->getID();?>)"><i class="fa fa-check"></i> Autorizar</button>
				<?php
					}
				?>
				<!--button class="btn btn-success" type="button" onClick="showPdfSubCadena(<?php echo $oSubCadena->getID();?>);"><i class="fa fa-print"></i> Exportar a PDF</button-->
			</div>
			<!--Cierre de Pié-->
			<!--Modal de Ejemplo-->
			<!--Inicia Modal-->
			<div class="modal fade" id="modal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-revision">
							<span>
								<i class="fa fa-check-square"></i>
							</span>
							<h3>Nombre de Corresponsal</h3>
							<span class="rev-combo pull-right">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</span>
						</div>
						<div class="modal-body">
							<h5 class="text-primary">
								<i class="fa fa-folder-open-o"></i> Comprobante de Domicilio
							</h5>

							<img src="img/dummyimage.jpg" width="60%" height="60%">
						</div>
						<div class="modal-footer">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Cierre Modal-->
		<!--Inicia Modal-->
		<div class="modal fade" id="modal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-revision">
						<span>
							<i class="fa fa-check-square"></i>
						</span>
						<h3>Nombre de Sub Cadena</h3>
						<span class="rev-combo pull-right">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</span>
					</div>
					<div class="modal-body">
						<h5 class="text-primary">
							<i class="fa fa-folder-open-o"></i> Nombre de Documento
						</h5>
						<img src="img/dummyimage.jpg" width="60%" height="60%">
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="PagoAgregar" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-revision">
						<span>
							<i class="fa fa-check-square"></i>
						</span>
						<h3><?php echo $oSubCadena->getNombre();?></h3>
						<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
					</div>

					<div class="modal-body">
						<div class="legmed">
							<i class="fa fa-dollar"></i> Registro de Pago
						</div>

						<form class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Importe: </label>
								<div class="col-lg-2">
									<input type="text" class="form-control" id="txtimporte">
								</div>

								<label class="col-lg-1 control-label"> Banco: </label>
								<div class="col-lg-2">
									<select class="form-control m-bot15" id="ddlBanco">
										<option value='-1'>Seleccione Banco</option>
										<?php
											$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_BANCOS`()");

											while($row = mysqli_fetch_assoc($sql)){

												echo "<option value='".$row['idBanco']."'>".((!preg_match('!!u', $row['nombreBanco']))? utf8_encode($row['nombreBanco']) : $row['nombreBanco'])."</option>";
											}
										?>
									</select>
								</div>

								<label class="col-lg-2 control-label"> Cuenta de Depósito: </label>
								<div class="col-lg-2">
									<input type="text" class="form-control" id="numeroCuenta">
								</div>
							</div>

							<form class="form-horizontal">
								<div class="form-group">
									<label class="col-lg-2 control-label"> Autorización/Folio: </label>
									<div class="col-lg-2">
										<input type="text" class="form-control" id="txtAut">
									</div>

									<label class="col-lg-1 control-label">Fecha:</label>
									<div class="col-lg-2">
										<input id="fechaDeposito" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="" onKeyPress="return validaFecha(event,'fechaDeposito')" onKeyUp="validaFecha2(event,'fechaDeposito')" maxlength="10"  />
										<span class="help-block">Seleccionar Fecha.</span>
									</div>

									<label class="col-lg-2 control-label"> Referencia: </label>
									<div class="col-lg-2">
										<input type="text" id="txtReferencia" class="form-control" readonly="true" value="<?php echo $oSubCadena->getReferenciaBancaria();?>">
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-2 control-label"> Ficha de Depósito: </label>                                   
									<input type="file" class="col-lg-3" style="background:none;" id="archivo" name="archivo"><i class="fa fa-check"></i>
									<input type="hidden" id="texto" type="text">
								</div>
							</form>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success pull-right" onClick="guardarDeposito(<?php echo $oSubCadena->getID();?>, -1);">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Cierre Modal-->
	<!--Cierre de Modal de Ejemplo-->
	<!--Cierres-->
</div>
</div>
</div> 
</div>
</div>
</section>
</section>
<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../inc/js/_Autorizar.js"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Cierre del Sitio-->                             
</body>
</html>