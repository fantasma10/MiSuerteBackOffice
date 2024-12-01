<?php
	/*error_reporting(E_ALL);
	ini_set("display_errors", 1);*/

	include("../../inc/config.inc.php");
	include("../../inc/session.inc.php");
	include("../../inc/obj/XMLPreCorresponsal.php");

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

	$idCorresponsal = (!empty($_POST['idCorresponsal'])) ? $_POST['idCorresponsal'] : 0/*2*/;

	if($idCorresponsal == -1){
		header('Location: ../../index.php');//redireccionar no existe la pre-cadena
	}
	else{
		$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
		$oCorresponsal->load($idCorresponsal);

		if($oCorresponsal->getExiste()){
			$_SESSION['idPreCorresponsal'] = $idCorresponsal;
		}
		else{
			//echo "<pre>"; echo var_dump("<h2>No existe el Precorresponsal : $idCorresponsal</h2>"); echo "</pre>";
			header('Location: ../../index.php');//redireccionar no existe la pre-cadena
		}	
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
	<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
	<title>.::Mi Red::.Autorización de Corresponsal</title>
	<!-- Núcleo BOOTSTRAP -->
	<link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css" />

	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../../assets/opensans/open.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="../../css/miredgen.css" rel="stylesheet">
	<link href="../../css/style-responsive.css" rel="stylesheet" />

	<link rel="stylesheet" type="text/css" href="../../assets/bootstrap-datepicker/css/datepicker.css" />

	<style>
		.ui-autocomplete-loading {
			background: white url('../../img/loadAJAX.gif') right center no-repeat;
		}
		.ui-autocomplete {
			max-height	: 190px;
			overflow-y	: auto;
			overflow-x	: hidden;
			font-size	: 12px;
		}
	</style>

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
	<div id="container"></div>
	<div class="titulorgb-prealta">
		<span>
			<i class="fa fa-check-square"></i>
		</span>
		<h3>
			<?php
				$nombreCor = $oCorresponsal->getNombre();
				echo ((!preg_match('!!u', $nombreCor))? utf8_encode($nombreCor) : $nombreCor);
			?>
		</h3>
		<span class="rev-combo pull-right">
			Autorización<br> de Corresponsal
		</span>
	</div>
	<div class="panel-body">
		<button class="btn btnrevision" type="button" onClick="irABuscarCorresponsal();">Nueva Búsqueda <i class="fa fa-search"></i></button>
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
								$referencia = $oCorresponsal->getReferenciaBancaria();
								if($referencia != ""){
									$sql = $RBD->query("CALL `prealta`.`SP_SUMA_DEPOSITOS_CARGOS`('$referencia', -1, -1, -1)");
									$row = mysqli_fetch_assoc($sql);

									echo "\$".number_format($row['importe_depositos'], 2);
								}
								else{
									$sub = $oCorresponsal->getTipoSubCadena();
									if($sub == 0){
										/*echo "SELECT ref.`referencia`, c.numCuenta, c.saldoCuenta
															FROM `ops_cuenta` AS c
															JOIN `data_contable`.`dat_banco_ref` AS ref ON ref.`numCuenta` = c.`numCuenta`
															WHERE idSubCadena = $idSubCadena AND idCorresponsal = -1;";*/
										$str = $RBD->query("SELECT ref.`referencia`, c.numCuenta, c.saldoCuenta
															FROM `ops_cuenta` AS c
															JOIN `data_contable`.`dat_banco_ref` AS ref ON ref.`numCuenta` = c.`numCuenta`
															WHERE idSubCadena = $idSubCadena AND idCorresponsal = -1;");
										$res = mysqli_fetch_assoc($str);
										$ref = $res['referencia'];
										$lbl = "SubCadena";
										$saldo = $res['saldoCuenta'];
									}
									else{
										$sql = "CALL `prealta`.`SP_LOAD_PRESUBCADENA`($idSubCadena);";
							        	$res = $RBD->SP($sql);

							        	if(!$RBD->error()){
							        		$r = mysqli_fetch_array($res);
							                $xml = simplexml_load_string($r[0]);
							                $ref = $xml->RefBancaria;
							        	}

							        	$lbl = "PreSubCadena";

							        	//echo "CALL `prealta`.`SP_SUMA_DEPOSITOS_CARGOS`('$ref', -1, -1, -1)";
										$sql = $RBD->query("CALL `prealta`.`SP_SUMA_DEPOSITOS_CARGOS`('$ref', -1, -1, -1)");
										$row = mysqli_fetch_assoc($sql);

										$saldo = $row['importe_depositos'];
									}

									

									echo $lbl."  \$".number_format($saldo, 2);
								}
							?>
						</div>

					</div>

				</div>
				<?php if($referencia != ""){?>
				<a href="#PagoAgregar"  data-toggle="modal" class="btn btn-success btn-xs" style="margin-top:18px; background:#c82647; border:1px solid #c82647; ">Registrar Pago <i class="fa fa-plus"></i></a>
				<?php } ?>
				<!--Final de los Mini Paneles-->
			</div>
			<br>
			<!--adkjgf-->
			<div class="room-auto">
				<h5 class="text-primary"><i class="fa fa-dollar"></i> Afiliación y Cuotas</h5>
				<table class="tablarevision">
					<tr>
						<td>Cuotas</td>
					</tr>
				</table>

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
					</tbody>
				</table>
			</div>

			<div class="room-auto">   
				<h5 class="text-primary">
					<i class="fa fa-dollar"></i> Corresponsal Bancario
				</h5>
				<table class="tablarevision">
					<tr>
						<td>Bancos Activos</td>
					</tr>
					<?php
						$bancos = $oCorresponsal->getCorresponsalias();
						foreach ($bancos as $key => $banco) {
							$nombreBanco = $oCorresponsal->getNombreCorresponsaliaBancaria($banco);
							echo "<tr><td class='dato'>".wordmatch($nombreBanco)."</td></tr>";
						}
					?>
					<!--tr>
						<td class="dato">Banco</td>
					</tr>
					<tr>
						<td class="dato">Banco</td>
					</tr>
					<tr>
						<td class="dato">Banco</td>
					</tr-->
				</table>
				<br>
			</div>
			<!--dfkdjf-->
			<div class="room-auto">
				<h5 class="text-primary"><i class="fa fa-book"></i> Datos Generales</h5>

				<table class="tablaauto">
					<tr>
						<td>Cadena</td>
						<td>Sub Cadena</td>
					</tr>
					<tr>
						<td class="dato"><?php echo wordmatch($oCorresponsal->getNombreCadena());?></td>
						<td class="dato"><?php echo wordmatch($oCorresponsal->getNombreSubCadena());?></td>
					</tr>
					<tr>
						<td>Grupo</td>
						<td>Referencia</td>
					</tr>
					<tr>
						<td class="dato"><?php echo wordmatch($oCorresponsal->getNombreGrupo());?></td>
						<td class="dato"><?php echo wordmatch($oCorresponsal->getNombreReferencia());?></td>
					</tr>
					<tr>
						<td>Giro</td>
					</tr>
					<tr>
						<td class="dato"><?php echo wordmatch($oCorresponsal->getNombreGiro())?></td>
					</tr>
					<tr>
						<td>No. Sucursal</td>
						<td>Nombre de Sucursal</td>
					</tr>
					<tr>
						<td class="dato"><?php echo wordmatch($oCorresponsal->getNumSucu());?></td>
						<td class="dato"><?php echo wordmatch($oCorresponsal->getNomSucu());?></td>
					</tr>
					<tr>
						<td>Teléfono</td>
						<td>Correo</td>
					</tr>
					<tr>
						<td class="dato"><?php echo $oCorresponsal->getTel1();?></td>
						<td class="dato"><?php echo $oCorresponsal->getCorreo();?></td>
					</tr>
					<tr>
						<td>IVA</td>
					</tr>
					<tr>
						<td class="dato"><?php echo wordmatch($oCorresponsal->getNombreIva())?></td>
					</tr>
				</table>
			</div>

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
							<td class="dato"><?php echo $oCorresponsal->getNombreVersion();?></td>
							<td>
								<a href="#" onClick="agregarComisionesEspeciales(<?php echo $oCorresponsal->getIdCadena()?>, <?php echo $oCorresponsal->getIdSubCadena()?>, <?php echo $oCorresponsal->getID()?>, <?php echo $oCorresponsal->getIdGrupo()?>, <?php echo $oCorresponsal->getVersion()?>, '../_Clientes/Corresponsal/Autorizar.php', '<?php echo $oCorresponsal->getNombre();?>');">Agregar
									<i class="fa fa-plus"></i>
								</a>
								<?php
									$sql = $RBD->query("CALL `prealta`.`SP_GET_PRECOMISIONES`({$oCorresponsal->getIdCadena()}, {$oCorresponsal->getIdSubCadena()}, {$oCorresponsal->getID()})");
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
					<br>
				</div>
			</div>

			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-map-marker"></i> Dirección y Horario
				</h5>

				<table class="tablaauto">
					<tr>
						<td>
							<i class="fa fa-home"></i> Dirección
						</td>
					</tr>
					<tr>
						<td class="dato">
							<?php
								$dir = wordmatch($oCorresponsal->getCalle())." ".$oCorresponsal->getNint()." ".$oCorresponsal->getNext();
								$dir.= "<br/>Col. ".wordmatch($oCorresponsal->getNombreColonia())." C.P.".$oCorresponsal->getCp();
								$dir.= "<br/>".wordmatch($oCorresponsal->getNombreCiudad()).", ".wordmatch($oCorresponsal->getNombreEstado()).", ".wordmatch($oCorresponsal->getNombrePais());

								echo $dir;
							?>
						</td>
					</tr>
					<tr>
						<td style="font-size:10px;">
							<!--a href="#" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 3, <?php echo $oCorresponsal->getDDomicilio()?>)">
								<i class="fa fa-folder-open"></i>Ver Comprobante de Domicilio.
							</a-->
							<button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 3, <?php echo $oCorresponsal->getDDomicilio()?>)">
								<i class="fa fa-folder-open"></i>Ver...
							</button>
						</td>
					</tr>
				</table>

				<table class="tablarevision">
					<tr>
						<td>
							<i class="fa fa-clock-o"></i> Horario
						</td>
					</tr>
				</table>

				<table class="tablaautoc">
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
						<?php
							$lunes		= $oCorresponsal->HDE1." a ".$oCorresponsal->HA1;
							$martes		= $oCorresponsal->HDE2." a ".$oCorresponsal->HA2;
							$miercoles	= $oCorresponsal->HDE3." a ".$oCorresponsal->HA3;
							$jueves		= $oCorresponsal->HDE4." a ".$oCorresponsal->HA4;
							$viernes	= $oCorresponsal->HDE5." a ".$oCorresponsal->HA5;
							$sabado		= $oCorresponsal->HDE6." a ".$oCorresponsal->HA6;
							$domingo	= $oCorresponsal->HDE7." a ".$oCorresponsal->HA7;
						?>
						<tr>
							<td class="tdtablita"><?php echo $lunes;?></td>
							<td class="tdtablita"><?php echo $martes;?></td>
							<td class="tdtablita"><?php echo $miercoles;?></td>
							<td class="tdtablita"><?php echo $jueves;?></td>
							<td class="tdtablita"><?php echo $viernes;?></td>
							<td class="tdtablita"><?php echo $sabado;?></td>
							<td class="tdtablita"><?php echo $domingo;?></td>

						</tr>
					</tbody>
				</table>
			</div>

			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-users"></i> Contactos
				</h5>
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
						</tbody>
					</table>
					<br>
				</div>
			</div>
			<!--jdh-->

			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-credit-card"></i> Cuenta
				</h5>
				<div class="table-responsive">
					<table class="tablaauto">
						<tr>
							<td>Tipo FORELO</td>
						</tr>
						<tr>
							<td class="dato">
							<?php
								$tipoForelo = $oCorresponsal->getTipoFORELO();

								switch($tipoForelo){
									case '1':
										echo "Compartido";
									break;
									case '2':
										echo "Individual";
									break;
									default:
										# code...
									break;
								}
							?>
							</td>
						</tr>
						<?php if($tipoForelo == 2){?>
						<tr>
							<td>CLABE</td>
						</tr>
						<tr>
							<td class="dato">
								<?php
									if($tipoForelo == 2){
										echo $oCorresponsal->getClabe();
									}
								?>
							</td>
						</tr>
						<tr>
							<td>Banco</td>
							<td>No. Cuenta</td>
							<td>Beneficiario</td>
							<td>Descripción</td>
						</tr>
						<tr>
							<td class="dato">
								<?php
									echo wordmatch($oCorresponsal->getNombreBanco());
								?>
							</td>
							<td class="dato">
								<?php
									echo $oCorresponsal->getNumCuenta();
								?>
							</td>
							<td class="dato">
								<?php
									echo wordmatch($oCorresponsal->getBeneficiario());
								?>
							</td>
							<td class="dato">
								<?php
									echo wordmatch($oCorresponsal->getDescripcion());
								?>
							</td>
						</tr>
						<tr>
							<td style="font-size:10px;">
								<!--a href="#" onclick="showComprobante(<?php echo $oCorresponsal->getID()?>, 3, <?php echo $oCorresponsal->getDBanco()?>)">
									<i class="fa fa-folder-open"></i>Ver Carátula de Banco.
								</a-->
								<button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 3, <?php echo $oCorresponsal->getDBanco()?>)">
									<i class="fa fa-folder-open"></i>Ver...
								</button>
							</td>
						</tr>
						<?php }?>
					</table>
				</div>
			</div>

			<!--Inicio de Documentación-->
			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-folder"></i> Documentación
				</h5>
				<div class="table-responsive">
					<table class="tablaauto">
						<tr>
							<td>Archivos</td>
						</tr>
						<tr>
							<td class="dato">Comprobante de Domicilio</td>
							<td>
								<?php if($oCorresponsal->getDDomicilio() != ''){ ?>
								<button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 3, <?php echo $oCorresponsal->getDDomicilio()?>)">
									<i class="fa fa-folder-open"></i>Ver...
								</button>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="dato"><?php if($oCorresponsal->getDBanco() != ''){ ?>Carátula de Banco<?php }?></td>
							<td>
								<?php if($oCorresponsal->getDBanco() != ''){ ?>
								<button class="btn btn-link" onClick="showComprobante(<?php echo $oCorresponsal->getID()?>, 3, <?php echo $oCorresponsal->getDBanco()?>)">
									<i class="fa fa-folder-open"></i>Ver...
								</button>
								<?php } ?>
							</td>
						</tr>
					</table>  
				</div>                 
			</div>
			<!--Fin de Documentación-->

			<!--div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-desktop"></i> Configuraci&oacute;n de Acceso
				</h5>

				<form class="form-horizontal" style="margin-top:10px;">
					<div class="form-group">
						<label class="col-lg-2 control-label">Ejecutivo de Venta : </label>
						<div class="col-lg-3">
							<input type="hidden" id="idEjecutivoVenta">
							<input type="text" class="form-control" id="txtEjecutivoVenta">
						</div>
					
						<label class="col-lg-2 control-label">Ejecutivo de Cuenta : </label>
						<div class="col-lg-3">
							<input type="hidden" id="idEjecutivoCuenta">
							<input type="text" class="form-control" id="txtEjecutivoCuenta">
						</div>
					</div>
				</form>                 
			</div-->

			<!--Inicio de Documentación-->
			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-desktop"></i> Configuraci&oacute;n de Acceso
				</h5>

				<form class="form-horizontal" style="margin-top:10px;">
					<div class="form-group">
						<label class="col-lg-2 control-label">Tipo de Cliente:</label>
						<div class="col-lg-2">
							<select class="form-control m-bot15" id="ddlTipoCliente">
								<option value="-1">Seleccione</option>
								<option value="1">Integrado</option>
								<option value="0">Red Efectiva</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Tipo de Acceso:</label>
						<div class="col-lg-2">
							<select class="form-control m-bot15" id="ddlTipoAcceso">
								<option value='-1'>Seleccione</option>
							</select>
						</div>
					</div>
				</form>

				<!--div class="table-responsive">
					<table class="tablaauto">
						<tr>
							<td>Tipo de Acceso</td>
						</tr>
						<tr>
							<td class="dato">Cliente Integrado</td>
						</tr>
					</table>  
				</div-->                 
			</div>
			<!--Fin de Documentación-->
		</div>

		<!--Pié-->
		<div class="prealta-footer">
			<?php
				if($comisionesPorAutorizar == 0){
			?>
			<button class="btn btn-default" type="button" onClick="autorizarCorresponsal(<?php echo $oCorresponsal->getID();?>);">
				<i class="fa fa-check"></i> Autorizar
			</button>
			<?php
				}
			?>
			<!--button class="btn btn-success" type="button"> Exportar a PDF
				<i class="fa fa-print"></i>
			</button-->
		</div>
		<!--Cierre de Pié-->

		<!--Inicia Modal-->
		<div class="modal fade" id="modal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-revision">
						<span>
							<i class="fa fa-check-square"></i>
						</span>
						<h3><?php wordmatch($oCorresponsal->getNombre());?></h3>
						<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
					</div>
					<div class="modal-body">
						<legend>
							<i class="fa fa-folder-open-o"></i> Comprobante de Domicilio
						</legend>
						<div id="modalContent">
							<img src="img/dummyimage.jpg" width="60%" height="60%">
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success" type="button">Editar <i class="fa fa-edit"></i></button>
					</div>
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
						<h3><?php echo $oCorresponsal->getNombre();?></h3>
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
												$lblBanco = (!preg_match('!!u', $row['nombreBanco']))? utf8_encode($row['nombreBanco']) : $row['nombreBanco'];
												echo "<option value='".$row['idBanco']."'>".$lblBanco."</option>";
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
										<input type="text" id="txtReferencia" class="form-control" readonly="true" value="<?php echo $oCorresponsal->getReferenciaBancaria();?>">
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
						<button type="button" class="btn btn-success pull-right" onClick="guardarDeposito(<?php echo $oCorresponsal->getIdSubCadena()?>, <?php echo $oCorresponsal->getID()?>);">Guardar</button>
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

<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<script src="../../inc/js/_Autorizar.js"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<script src="../../css/ui/jquery.ui.core.js"></script>
<script src="../../css/ui/jquery.ui.widget.js"></script>
<script src="../../css/ui/jquery.ui.position.js"></script>
<script src="../../css/ui/jquery.ui.menu.js"></script>
<script src="../../css/ui/jquery.ui.autocomplete.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>