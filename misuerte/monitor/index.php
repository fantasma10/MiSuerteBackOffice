<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Cliente";

$tipoDePagina = "mixto";
$idOpcion = 137;

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

$oConfiguracion = new ConfiguracionRedEfectiva();
$oConfiguracion->setORdb($MRDB);
$oConfiguracion->setOWdb($MWDB);
$oConfiguracion->setNIdConfiguracion(1);

$resultado = $oConfiguracion->cargar();

$nTiempoActualizacion	= $resultado['data']['nTiempoActualizacion'];
$nTiempoInactividad		= $resultado['data']['nTiempoInactividad'];
$nTiempoAlerta			= $resultado['data']['nTiempoAlerta'];

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
	<title>.::Mi Red::.M&eacute;todos de Pago</title>
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
								<h3>Monitor por Cliente</h3><span class="rev-combo pull-right">Monitor <br>&nbsp;</span>
							</div>
							<div class="panel">
								<div class="panel-body">

									<div class="col-xs-6">
										<div class="form-group">
											<label>Receptor</label>
											<select name="nIdCliente" id="cmbCliente" class="form-control">

											</select>
										</div>
									</div>

									<div class="col-xs-12" style="margin-top:10px;">
										<table id="tbl-resumen-semana" class="display table table-bordered table-striped">
											<thead>
												<tr>
													<th>S&aacute;bado</th>
													<th>Domingo</th>
													<th>Lunes</th>
													<th>Martes</th>
													<th>Mi&eacute;rcoles</th>
													<th>Jueves</th>
													<th>Viernes</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>

									<br/>

									<div class="col-xs-1" style="margin-top:10px;">
										<table id="tbl-resumen-hora" class="display table table-bordered table-striped">
											<thead>
												<tr>
													<th>Hora</th>
													<th>Venta</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>

									<div class="col-xs-10" style="margin-top:10px;" id="div-grafica">

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
		<!--<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>-->
		<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/highcharts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/monitor/MonitorCliente.js"></script>
		<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
			N_TIEMPOACTUALIZACION = "<?php echo $nTiempoActualizacion;?>";
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				initViewMonitor();
			});
		</script>
	</body>
</html>