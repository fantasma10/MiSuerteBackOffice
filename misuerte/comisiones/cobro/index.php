<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Cliente";

$tipoDePagina = "mixto";
$idOpcion = 134;

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
	<title>.::Mi Red::.Cobro de Comisiones</title>
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
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
								<h3>Cobro de Comisiones</h3><span class="rev-combo pull-right">Cobro<br>de Comisiones</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<form name="formFiltros" id="form_Filtros">
											<div class="row">
												<div class="col-xs-3">
													<div class="form-group">
														<label>Proveedor</label>
														<select name="nIdProveedor" class="form-control" id="cmbProveedor">
															<option value="0">--</option>
														</select>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>Estatus</label>
														<select name="nIdEstatus" class="form-control" id="cmbEstatus">
															<option value="0">--</option>
														</select>
													</div>
												</div>
												<div class="col-xs-2">
													<div class="form-group">
														<label>Fecha Inicio</label>
														<input type="text" name="dFechaInicio" id="txtFechaInicio" class="form-control" readonly="" value=""/>
													</div>
												</div>
												<div class="col-xs-2">
													<div class="form-group">
														<label>Fecha Final</label>
														<input type="text" name="dFechaFinal" id="txtFechaFinal" class="form-control" readonly="" value=""/>
													</div>
												</div>
												<div class="col-xs-2">
													<button type="button" class="btn btn-xs btn-info pull-right" id="btnFiltros" style="margin-top:20px;"> Buscar </button>
												</div>
											</div>
										</form>
									</div>

									<div class="show-estatus">

									</div>
									<div id="gridbox" class="adv-table table-responsive">
										<table id="tblGridBox" class="display table table-bordered table-striped">
											<thead>
												<tr>
													<th></th>
													<th>Proveedor</th>
													<th>Folio</th>
													<th>Fecha Corte</th>
													<th>Fecha Pago</th>
													<th>Monto</th>
													<th>Estatus</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
									<div class="row">
										<div class="col-xs-3">
											<button type="button" onclick="" class="btn btn-xs btn-info pull-left" id="btnFactura" style="margin-top:20px;"> Factura </button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</section>

		<!-- Modal Factura Subir -->
		<div class="modal fade" id="modal-subirFactura" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-consulta">
						<span><i class="fa fa-edit"></i></span>
						<h3>Subir Factura</h3>
						<span class="rev-combo pull-right">
							<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
						</span>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" name="formSubirFactura">
							<div class="form-group">
								<label class="col-xs-2 control-label">Archivo:</label>
								<div class="col-xs-6">
									<input type="file" class="form-control" name="sFileFactura" id="sFileFactura" onchange="">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<?php
							if($esEscritura){
						?>
						<button class="btn btnconsultabig consulta pull-right" type="button" id="btnSubirFactura">Guardar</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<!-- Fin de Modal Factura Subir -->

		<!-- Modal de Poliza -->
		<div class="modal fade" id="modal-poliza" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-consulta">
						<span><i class="fa fa-edit"></i></span>
						<h3>P&oacute;liza</h3>
						<span class="rev-combo pull-right">
							<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
						</span>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" name="formPolizaIngresos">
							<input type="hidden" name="nIdCorte" value="0"/>
							<h5><strong>P&oacute;liza</strong>&nbsp;&nbsp;<a href="#" style="font-size:11px;display:none;" id="aDescargaPoliza1" nidpoliza="0">Descargar</a></h5>
							<div class="form-group">
								<label class="col-xs-2 control-label">Folio:</label>
								<label class="col-xs-2 control-label">Fecha:</label>
								<label class="col-xs-5 control-label">Concepto:</label>
							</div>
							<div class="form-group">
								<div class="col-xs-2">
									<input type="text" class="form-control" name="sFolio">
								</div>

								<div class="col-xs-2">
									<input type="text" class="form-control" placeholder="" name="dFecha" readonly="">
								</div>

								<div class="col-xs-5">
									<input type="text" class="form-control" placeholder="" name="sConcepto">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<?php
							if($esEscritura){
						?>
						<button class="btn btnconsultabig consulta pull-right" type="button" id="btnGeneraPoliza">Generar</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<!-- Fin de Modal de Poliza -->

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
		<!--<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>-->
		<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/comisiones/cobro/CobroComisiones.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				initViewCobro();
			});
		</script>
	</body>
	</html>
