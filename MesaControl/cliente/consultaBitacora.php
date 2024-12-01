<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");

$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Cliente";
$tipoDePagina = "mixto";
$idOpcion = 317;
$prealta = isset($_GET['prealta']) ? ($_GET['prealta'] == 1 ? 1 : 0) : 0;
$usuario_logueado = $_SESSION['idU'] * 1;
$permisosAut = (in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_autorizador']) || in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_capturistas'])) ? 1 : 0;

if (!desplegarPagina($idOpcion, $tipoDePagina)) {
	header("Location: $PATHRAIZ/error.php");
	exit();
}

$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
	$esEscritura = true;
}

$hoy = date("Y-m-d");

$idemisores =  (isset($_POST['txtidemisor'])) ? $_POST['txtidemisor'] : 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Favicon-->
	<link rel="shortcut icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
	<title>.::Mi Red::.Consulta de Bitácora</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" />
	<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
			<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include($PATH_PRINCIPAL . "/inc/cabecera_PC.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include($PATH_PRINCIPAL . "/inc/menu.php"); ?>
<!--Final del Menú Vertical-->
<!--Contenido Principal del Sitio-->
<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-lg-12">
				<!--Panel Principal-->
				<div class="panelrgb">
					<div class="titulorgb-prealta">
						<span><i class="fa fa-search"></i></span>
						<h3>Consulta de Bitácora</h3>
					</div>
					<div id="bitacoraPanel" class="panel">
						<div class="panel-body">
							<div class="well">
								<div class="row" style='padding-bottom: 10px;'>
									<div class="col-xs-2">
										<div class="form-group">
											<label>Registro</label>
											<input type="text" id="txtregistro" class='form-control m-bot15'>
										</div>
									</div>
									<div id="txtusuario" class="col-xs-3">
										<div class="form-group">
											<label>Usuario</label>
											<select class="form-control" id="opcionUsuarios">
												<option value="" selected="selected">Seleccione una opción</option>
											</select>
										</div>
									</div>
									<div id="tipoAccionSelect" class="col-xs-2">
										<div class="form-group">
											<label>Tipo de Acción</label>
											<select class="form-control" id="tipoAccion">
												<option value="" selected="selected">Todos</option>
												<option value="I">Insertó</option>
												<option value="U" >Actualizó</option>
											</select>
										</div>
									</div>
									<div class="col-xs-2 col-xs-offset-1">
										<div class="form-group">
											<label>Fecha Inicial</label>
											<input type="text" onpaste="return false;" id="txtFechaIni" class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>">
										</div>
									</div>
									<div class="col-xs-2 ">
										<div class="form-group">
											<label>Fecha Final</label>
											<input type="hidden" id="fecha" value="<?php echo $hoy ?>" class="form-control">
											<input type="text" onpaste="return false;" id="txtFechaFin" class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'txtFechaFin')" onKeyUp="validaFecha2(event,'txtFechaFin')">
										</div>
									</div>
								</div>
								<div class="row">
									<div id="nombreCatalogosSelect" class="col-xs-3">
										<div class="form-group">
											<label>Catálogo</label>
											<select class="form-control" id="opcionCatalogo">
												<option value="" selected="selected">Seleccione una opción</option>
											</select>
										</div>
									</div>
									<button id="botonBuscar" class="btn btn-xs btn-info col-xs-offset-7" style="margin-top: 20px;" onclick="buscarBitacora()"> Buscar </button>
								</div>

								<div class="form-group col-xs-12">
									<div class="adv-table table-responsive">
										<table id="bitacoraTable" class="display table table-bordered table-striped table-hover" style="display:inline-table;">
											<thead>
												<tr>
													<th>Registro</th>
													<th>Catálogo</th>
													<th>Fecha Movimiento</th>
													<th>Usuario</th>
													<th>Tipo de Acción</th>
													<th>Últimos cambios</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
										<div id="circularG">
											<div id="circularG_1" class="circularG"></div>
											<div id="circularG_2" class="circularG"></div>
											<div id="circularG_3" class="circularG"></div>
											<div id="circularG_4" class="circularG"></div>
											<div id="circularG_5" class="circularG"></div>
											<div id="circularG_6" class="circularG"></div>
											<div id="circularG_7" class="circularG"></div>
											<div id="circularG_8" class="circularG"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="bitacoraClientePanel" class="panel">
						<div class="panel-body">
							<div class="well">
								<div class="form-group col-xs-12">
									<h5 class="col-xs-6 pb-3 control-label">Catálogo: <em id='labelCatalogo'></em></h5>
									<h5 class="col-xs-6 pb-3 control-label">Usuario: <em id='labelUsuario'></em></h5>
									<h5 class="col-xs-6 pb-3 control-label">Fecha de Movimiento: <em id='labelFechaMovimiento'></em></h5>
									<h5 class="col-xs-6 pb-3 control-label">Tipo de acción: <em id='labelAccion'></em></h5>
								</div>
								<button id="botonVolverBitacora" class="btn btn-xs btn-info col-xs-offset-10" onclick="volverBitacora()"> Volver </button>
								<div class="adv-table table-responsive">
									<table id="bitacoraClienteTable" class="display table table-bordered table-striped" style="display:inline-table;width: 100%!important">
										<thead>
											<tr>
												<th>#</th>
												<th>Campo</th>
												<th>Cambio Anterior</th>
												<th>Cambio Nuevo</th>
											</tr>
										</thead>
										<tbody id="bitacoraClienteTableBody">
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		</div>
	</section>
</section>

<!-- jQuery -->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
<!-- Bootstrap -->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
<!-- Otros scripts generales -->
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
<!-- Datatable -->
<script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>
<!-- Otros scripts específicos de la página -->
<script src="<?php echo $PATHRAIZ; ?>/MesaControl/cliente/js/bitacora.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
<!-- Datepicker -->
<script src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script>
	BASE_PATH = "<?php echo $PATHRAIZ; ?>";
	ID_PERFIL = "<?php echo $_SESSION['idPerfil']; ?>";
	ES_ESCRITURA = "<?php echo $esEscritura; ?>";
</script>

</body>
<style type="text/css">
	#td {
		width: 30% !important;
	}

	.well ul li {
		padding: 0 !important;
		font-size: 11px !important;
	}

	td.ellipsis {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		max-width: 200px;
	}

	#circularG {
		position: relative;
		width: 58px;
		height: 58px;
		margin: auto;
	}

	.circularG {
		position: absolute;
		background-color: rgb(115, 115, 115);
		width: 14px;
		height: 14px;
		border-radius: 9px;
		-o-border-radius: 9px;
		-ms-border-radius: 9px;
		-webkit-border-radius: 9px;
		-moz-border-radius: 9px;
		animation-name: bounce_circularG;
		-o-animation-name: bounce_circularG;
		-ms-animation-name: bounce_circularG;
		-webkit-animation-name: bounce_circularG;
		-moz-animation-name: bounce_circularG;
		animation-duration: 1.1s;
		-o-animation-duration: 1.1s;
		-ms-animation-duration: 1.1s;
		-webkit-animation-duration: 1.1s;
		-moz-animation-duration: 1.1s;
		animation-iteration-count: infinite;
		-o-animation-iteration-count: infinite;
		-ms-animation-iteration-count: infinite;
		-webkit-animation-iteration-count: infinite;
		-moz-animation-iteration-count: infinite;
		animation-direction: normal;
		-o-animation-direction: normal;
		-ms-animation-direction: normal;
		-webkit-animation-direction: normal;
		-moz-animation-direction: normal;
	}

	#circularG_1 {
		left: 0;
		top: 23px;
		animation-delay: 0.41s;
		-o-animation-delay: 0.41s;
		-ms-animation-delay: 0.41s;
		-webkit-animation-delay: 0.41s;
		-moz-animation-delay: 0.41s;
	}

	#circularG_2 {
		left: 6px;
		top: 6px;
		animation-delay: 0.55s;
		-o-animation-delay: 0.55s;
		-ms-animation-delay: 0.55s;
		-webkit-animation-delay: 0.55s;
		-moz-animation-delay: 0.55s;
	}

	#circularG_3 {
		top: 0;
		left: 23px;
		animation-delay: 0.69s;
		-o-animation-delay: 0.69s;
		-ms-animation-delay: 0.69s;
		-webkit-animation-delay: 0.69s;
		-moz-animation-delay: 0.69s;
	}

	#circularG_4 {
		right: 6px;
		top: 6px;
		animation-delay: 0.83s;
		-o-animation-delay: 0.83s;
		-ms-animation-delay: 0.83s;
		-webkit-animation-delay: 0.83s;
		-moz-animation-delay: 0.83s;
	}

	#circularG_5 {
		right: 0;
		top: 23px;
		animation-delay: 0.97s;
		-o-animation-delay: 0.97s;
		-ms-animation-delay: 0.97s;
		-webkit-animation-delay: 0.97s;
		-moz-animation-delay: 0.97s;
	}

	#circularG_6 {
		right: 6px;
		bottom: 6px;
		animation-delay: 1.1s;
		-o-animation-delay: 1.1s;
		-ms-animation-delay: 1.1s;
		-webkit-animation-delay: 1.1s;
		-moz-animation-delay: 1.1s;
	}

	#circularG_7 {
		left: 23px;
		bottom: 0;
		animation-delay: 1.24s;
		-o-animation-delay: 1.24s;
		-ms-animation-delay: 1.24s;
		-webkit-animation-delay: 1.24s;
		-moz-animation-delay: 1.24s;
	}

	#circularG_8 {
		left: 6px;
		bottom: 6px;
		animation-delay: 1.38s;
		-o-animation-delay: 1.38s;
		-ms-animation-delay: 1.38s;
		-webkit-animation-delay: 1.38s;
		-moz-animation-delay: 1.38s;
	}



	@keyframes bounce_circularG {
		0% {
			transform: scale(1);
		}

		100% {
			transform: scale(.3);
		}
	}

	@-o-keyframes bounce_circularG {
		0% {
			-o-transform: scale(1);
		}

		100% {
			-o-transform: scale(.3);
		}
	}

	@-ms-keyframes bounce_circularG {
		0% {
			-ms-transform: scale(1);
		}

		100% {
			-ms-transform: scale(.3);
		}
	}

	@-webkit-keyframes bounce_circularG {
		0% {
			-webkit-transform: scale(1);
		}

		100% {
			-webkit-transform: scale(.3);
		}
	}

	@-moz-keyframes bounce_circularG {
		0% {
			-moz-transform: scale(1);
		}

		100% {
			-moz-transform: scale(.3);
		}
	}
</style>

</html>