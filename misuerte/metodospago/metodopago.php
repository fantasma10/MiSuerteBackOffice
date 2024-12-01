<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Cliente";

$tipoDePagina = "mixto";
$idOpcion = 128;

if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
}

$hoy = date("Y-m-d");

function acentos($word){
	return (!preg_match('!!u', $word))? utf8_encode($word) : $word;
}

$nIdMetodoPago = (isset($_POST['nIdMetodoPago']) && $_POST['nIdMetodoPago'] >= 1)? $_POST['nIdMetodoPago'] : 0;

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Favicon-->
	<link rel="shortcut icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">
	<title>.::Mi Red::.Afiliacion de emisores</title>

	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
			<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
			<![endif]-->

		</head>
		<!--Include Cuerpo, Contenedor y Cabecera-->
		<?php include($PATH_PRINCIPAL."/inc/cabecera2.php"); ?>
		<!--Fin de la Cabecera-->
		<!--Inicio del Menú Vertical-->
		<!--Función "Include" del Menú-->
		<?php include($PATH_PRINCIPAL."/inc/menu.php"); ?>
		<!--Final del Menú Vertical-->
		<!--Contenido Principal del Sitio-->
		<section id="main-content">
			<section class="wrapper site-min-height">
				<div class="row">
					<div class="col-lg-12">
						<!--Panel Principal-->
						<div class="panelrgb">
							<div class="titulorgb-prealta">
								<span><i class="fa fa-user"></i></span>
								<h3>M&eacute;todo de Pago</h3><span class="rev-combo pull-right">M&eacute;todos <br>de Pago</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<form name="formMetodoPago" action="" id="form_MetodoPago">
											<input type="hidden" name="nIdMetodoPago" value="0">
											<div style="margin-bottom:30px;">
												<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
											</div>
											<div class="row">
												<div class="col-xs-3">
													<div class="form-group">
														<label>Nombre : </label>
														<input type="text" id="txtSNombre" name="sNombre" class='form-control m-bot15'>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>Id Método de Pago : </label>
														<input type="text" id="txtNId" name="nIdMetodo" class='form-control m-bot15'>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>Estatus : </label>
														<select id="cmbEstatus" name="nIdEstatus" class='form-control m-bot15'>
															<option value="-1">Seleccione</option>
														</select>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>Venta Indirecta :<br/>
														<input type="checkbox" id="txtBIndirecta" name="bIndirecta" class="form-control">
														</label>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-3">
													<div class="form-group">
														<label>Importe Costo $ : </label>
														<input type="text" id="txtNImporteCosto" name="nImporteCosto" class='form-control'>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>Porcentaje Costo % :</label>
														<input type="text" id="txtNPorcentajeCosto" name="nPorcentajeCosto" class="form-control">
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>Importe Adicional Costo $ : </label>
														<input type="text" id="txtNImporteAdicionalCosto" name="nImporteCostoAdicional" class='form-control'>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>IVA % :</label>
														<input type="text" id="txtNImporteIVA" name="nPorcentajeIVA" class="form-control">
													</div>
												</div>
											</div>

											<div style="margin-bottom:30px;margin-top:30px;">
												<h4><span><i class="fa fa-file-text"></i></span> D&iacute;as de Pago</h4>
											</div>

											<div class="row">
												<div class="col-xs-1">
													<div class="form-group">
														<label>
															Lunes
															<input type="checkbox" name="nIdDia" value="1" class="form-control">
														</label>
													</div>
												</div>
												<div class="col-xs-1">
													<div class="form-group">
														<label>
															Martes
															<input type="checkbox" name="nIdDia" value="2" class="form-control">
														</label>
													</div>
												</div>

												<div class="col-xs-1">
													<div class="form-group">
														<label>
															Mi&eacute;rcoles
															<input type="checkbox" name="nIdDia" value="3" class="form-control">
														</label>
													</div>
												</div>

												<div class="col-xs-1">
													<div class="form-group">
														<label>
															Jueves
															<input type="checkbox" name="nIdDia" value="4" class="form-control">
														</label>
													</div>
												</div>

												<div class="col-xs-1">
													<div class="form-group">
														<label>
															Viernes
															<input type="checkbox" name="nIdDia" value="5" class="form-control">
														</label>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-12" style="text-align:right;">
													<button type="button" class="btn btn-xs btn-info " id="btnGuardarMetodoPago" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando" style="margin-top:10px;"> Guardar </button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</section>



		<!--*.JS Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
		<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
		<!--Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-custom-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/MetodoPago.js"></script>
		<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
			NID_METODOPAGO	= "<?php echo $nIdMetodoPago;?>";
			$(document).ready(function() {
				initMetodoPagoAlta();
			});

		</script>
	</body>
	</html>
