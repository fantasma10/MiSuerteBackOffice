<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Cliente";

$tipoDePagina = "mixto";
$idOpcion = 133;

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
	<title>.::Mi Red::.Configuraci&oacute;n</title>
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
								<h3>Configuraci&oacute;n</h3><span class="rev-combo pull-right">Configuraci&oacute;n<br>&nbsp;</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<form name="formConfiguracion" id="form_Configuracion">
											<input type="hidden" name="nIdConfiguracion" value="0">
											<div style="margin-bottom:20px;">
												<h4><span><i class="fa fa-file-text"></i></span> Datos Bancarios</h4>
											</div>
											<div class="row">
												<div class="col-xs-3">
													<div class="form-group">
														<label>CLABE Retiro</label>
														<input type="text" name="sClabeRetiro" id="txtSClabeRetiro" class="form-control"/>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>CLABE Dep&oacute;sito</label>
														<input type="text" name="sClabeDeposito" id="txtSClabeDeposito" class="form-control"/>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-3">
													<div class="form-group">
														<label>Cuenta Contable Dep&oacute;sito</label>
														<input type="text" name="nNumCuentaContableDeposito" id="txtNNumCuentaContableDeposito" class="form-control"/>
													</div>
												</div>
											</div>

											<div style="margin-bottom:20px;margin-top:20px;">
												<h4><span><i class="fa fa-file-text"></i></span> Monitor</h4>
											</div>
											<div class="row">
												<div class="col-xs-3">
													<div class="form-group">
														<label>Tiempo Actualizaci&oacute;n (Segundos)</label>
														<input type="text" name="nTiempoActualizacion" id="txtNTiempoActualizacion" class="form-control"/>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>Tiempo Inactividad (Minutos)</label>
														<input type="text" name="nTiempoInactividad" id="txtNTiempoInactividad" class="form-control"/>
													</div>
												</div>
												<div class="col-xs-3">
													<div class="form-group">
														<label>Tiempo Alerta (Minutos)</label>
														<input type="text" name="nTiempoAlerta" id="txtNTiempoAlerta" class="form-control"/>
													</div>
												</div>
											</div>
											<?php
												if($esEscritura){
											?>
											<button type="button" class="btn btn-xs btn-info pull-right" id="btnGuardarConfiguracion" style="margin-top:20px;"> Guardar </button>
											<?php
												}
											?>
										</form>
									</div>
									<div class="well">
										<div style="margin-bottom:20px;">
											<h4><span><i class="fa fa-file-text"></i></span> Alertas</h4>
										</div>
										<form name="formAlertas" id="form_Alertas">
											<input type="hidden" name="nIdNotificacion" value="0">
											<div class="row">
												<div class="col-xs-3">
													<div class="form-group">
														<label>&Aacute;rea</label>
														<select name="nIdArea" id="cmbArea" class="form-control">
															<option value="0">Seleccione</option>
														</select>
													</div>
												</div>
												<div class="col-xs-4">
													<div class="form-group">
														<label>Correo</label>
														<input type="text" name="sCorreo" id="txtSCorreo" class="form-control"/>
													</div>
												</div>
												<?php
													if($esEscritura){
												?>
												<div class="col-xs-3">
													<button type="button" class="btn btn-xs btn-info" id="btnGuardarAlerta" style="margin-top:20px;"> Guardar </button>
												</div>
												<?php
													}
												?>
											</div>
										</form>
									</div>
									<div id="gridbox" class="adv-table table-responsive">
										<table id="tblGridBox" class="display table table-bordered table-striped">
											<thead>
												<tr>
													<th>&Aacute;rea</th>
													<th>Correo</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Soporte</td>
													<td>edgar@redefectiva.com</td>
												</tr>
											</tbody>
										</table>
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
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/configuracion.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				initViewConfiguracion();
			});
		</script>
	</body>
	</html>
