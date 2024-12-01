<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
// include($PATH_PRINCIPAL . "/afiliacion/application/models/Cat_pais.php");
// include($PATH_PRINCIPAL . "/_Proveedores/proveedor/ajax/Cat_familias.php");
$usuario_logueado = $_SESSION['idU'];
$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];
$parametro_emisor = $_POST["txtidEmisor"];
$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Lista Emisores";
$tipoDePagina = "mixto";
// $idOpcion = 206;
$idOpcion = 152;


if (!desplegarPagina($idOpcion, $tipoDePagina)) {
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
	$esEscritura = true;
}

$hoy = date("Y-m-d");

function acentos($word)
{
	return (!preg_match('!!u', $word)) ? utf8_encode($word) : $word;
}

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
	<title>.::Mi Red::.Afiliacion de Proveedor</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />

	<style type="text/css">
		.inhabilitar {
			background-color: #d9534f !important;
			border-color: #d9534f !important;
			margin-left: 10px;
			color: #FFFFFF;
		}

		.habilitar {
			margin-left: 10px;
		}

		.alignRight {
			text-align: right;
		}
	</style>
</head>

<body>

	<!--Include Cuerpo, Contenedor y Cabecera-->
	<?php include($PATH_PRINCIPAL . "/inc/cabecera2.php"); ?>
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
							<span><i class="fa fa-user"></i></span>
							<h3>Emisor <em id="labelEmisor"></em></h3>
							<span class="rev-combo pull-right">Emisor</span>
						</div>
						<div id="consultaClientePanel" class="panel">
							<!--Datos Generales-->
							<div class="panel-body">
								<div id="loading" style="text-align: center; display: none;">
									<img src="../../../img/cargando3.gif">
								</div>
								<div id="formularioEmisores">
									<input type="hidden" id="idUsuario" name="idUsuario" value='<?php echo $usuario_logueado; ?>'>
									<input type="hidden" id="e_idemisor" name="e_idemisor" value='<?php echo $parametro_emisor; ?>'>
									<div class="form-group col-xs-12">
										<button class="btn btn-xs btn-info btnback" style="margin-top:20px;">Regresar</button>
									</div>
									<div class="form-group col-lg-12">
										<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
									</div>
	
									<div class="form-group col-xs-12">
										<div class="form-group col-xs-4">
											<label class="control-label">Abreviatura: </label>
											<input type="text" id="abreviaturaEmisor" class='form-control m-bot15' maxlength="15">
											<small></small>
										</div>
										<div class="form-group col-xs-4">
											<label class="control-label">Descripción: </label>
											<input type="text" id="descripcionEmisor" class='form-control m-bot15' maxlength="45">
											<small></small>
										</div>
										<div class="form-group col-xs-4">
											<label>Estatus: </label>
											<select class="form-control" id="opcionEstastus">
												<option value="-1">Seleccionar</option>
												<option value="0" selected="selected">Inactivo</option>
												<option value="1">Activo</option>
											</select>
											<small></small>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<button id="btn-emisor" type="button" class="btn btn-primary pull-right" style="margin-right:1.1em">Guardar</button>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
	</section>

	<!--*.JS Generales-->
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
	<!--Generales-->
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>

	<!--Autocomplete -->
	<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.core.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.widget.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.position.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.menu.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.autocomplete.js"></script>

	<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/emisor/js/consultaEmisor.js"></script>
	<script type="text/javascript">
		BASE_PATH = "<?php echo $PATHRAIZ; ?>";
		ID_PERFIL = "<?php echo $_SESSION['idPerfil']; ?>";
		initViewConsultaEmisores();
		$(".btnback").on('click', function() {
			let ruta = './consulta.php';
			window.location.href = ruta;
		});
	</script>
	<style type="text/css">
		.sizeColumn {
			max-width: 70px;
		}

		.dataTables_processing {
			border: none;
			background: none;
		}

		/*LOADER*/
		.loaderEmisor {
			z-index: 999999;
			align-items: center;
			display: flex;
			justify-content: center;
			width: 100%;
			height: 100%;
			position: fixed;
			background: #00000080;
			left: 0;
			top: 0;
		}

		.loader {
			font-size: 20px;
			margin: 45% auto;
			width: 1em;
			height: 1em;
			border-radius: 50%;
			position: relative;
			text-indent: -9999em;
			-webkit-animation: load4 1.3s infinite linear;
			animation: load4 1.3s infinite linear;
		}

		@-webkit-keyframes load4 {

			0%,
			100% {
				box-shadow: 0em -3em 0em 0.2em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 0em #ffffff;
			}

			12.5% {
				box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 0.2em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			25% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 0.2em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			37.5% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 0.2em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			50% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 0.2em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			62.5% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 0.2em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			75% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0.2em #ffffff, -2em -2em 0 0em #ffffff;
			}

			87.5% {
				box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 0.2em #ffffff;
			}
		}

		@keyframes load4 {

			0%,
			100% {
				box-shadow: 0em -3em 0em 0.2em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 0em #ffffff;
			}

			12.5% {
				box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 0.2em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			25% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 0.2em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			37.5% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 0.2em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			50% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 0.2em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			62.5% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 0.2em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 -0.5em #ffffff;
			}

			75% {
				box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0.2em #ffffff, -2em -2em 0 0em #ffffff;
			}

			87.5% {
				box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 0.2em #ffffff;
			}
		}
	</style>
</body>

</html>