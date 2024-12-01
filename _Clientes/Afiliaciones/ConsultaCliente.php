<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$submenuTitulo = "Afiliaci&oacute;n Express";
	$subsubmenuTitulo = "Consulta";
	$tipoDePagina = "Mixto";
	$idOpcion = 61;

	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../../error.php");
		exit();
	}

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];
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
			<title>.::Mi Red::.Nuevo Usuario</title>
			<!-- Núcleo BOOTSTRAP -->
			<link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />
			<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
			<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
			<!--ASSETS-->
			<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
			<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
			<!-- ESTILOS MI RED -->
			<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
			<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
			<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" />

			<link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" />

			<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
			<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
			<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
			<![endif]-->

			<style>
				.ui-autocomplete-loading {
					background: white url('<?php echo $PATHRAIZ;?>/img/loadAJAX.gif') right center no-repeat;
				}
				.ui-autocomplete {
					max-height: 190px;
					overflow-y: auto;
					overflow-x: hidden;
					font-size: 12px;
				}	
			</style>

		</head>
		<!--Include Cuerpo, Contenedor y Cabecera-->
		<?php include($_SERVER['DOCUMENT_ROOT']."/inc/cabecera2.php"); ?>
		<!--Fin de la Cabecera-->
		<!--Inicio del Menú Vertical-->
		<!--Función "Include" del Menú-->
		<?php include($_SERVER['DOCUMENT_ROOT']."/inc/menu.php"); ?>
		<!--Final del Menú Vertical-->
		<!--Contenido Principal del Sitio-->

			<section id="main-content">
				<section class="wrapper site-min-height">
					<div class="row">
						<div class="col-lg-12">

							<!--Panel Principal-->
							<div class="panelrgb">
								<div class="titulorgb-prealta">
									<span><i class="fa fa-users"></i></span>
									<h3>Afiliación Express</h3><span class="rev-combo pull-right">Afiliación<br>Express</span>
								</div>

								<div class="panel">
									<div class="jumbotron">
										<div class="container">
											<h2>Consulta de Clientes</h2>
											<p>Llene uno de los campos de b&uacute;squeda, y seleccione el cliente deseado.</p>
										</div>
									</div>

									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12">

 												<div class="well">
													<form class="form-horizontal">
														<div class="form-group">
															<label class="col-lg-1 control-label">Cliente:</label>
															<div class="col-lg-4">
																<input type="hidden" name="idCliente" id="idCliente">
																<input class="form-control m-bot15" type="text" placeholder="ID o Nombre del Cliente" name="txtCliente" id="txtCliente">
															</div>

															<label class="col-lg-1 control-label">RFC:</label>
															<div class="col-lg-4">
																<input class="form-control m-bot15" type="text" placeholder="RFC del Cliente" name="txtRFC" id="txtRFC">
															</div>

															<div class="col-lg-2">
																<button type="button" class="btn btn-guardar" id="btnSeleccion">Ver Cliente &nbsp;<i class="fa fa-search"></i></button>
															</div>
														</div>
													</form>
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

<!--*.JS Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->

<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesConsultaCliente.js"></script>

<script>
	$(function(){
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";

		initConsultaCliente();

	});
</script>

</body>
</html>