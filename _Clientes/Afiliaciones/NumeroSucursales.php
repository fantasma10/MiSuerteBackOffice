<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$submenuTitulo = "Afiliaci&oacute;n Express";
	$subsubmenuTitulo = "N&uacute;mero de Sucursales";
	$tipoDePagina = "Mixto";
	if(!empty($_POST['consultaAfiliacion'])){
		$idOpcion = 61;
		$ESCONSULTA = true;
	}
	else{
		$idOpcion = 60;
		$ESCONSULTA = false;
	}

	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../../error.php");
		exit();
	}

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];

	$idCliente	= (!empty($_REQUEST['idCliente']))? $_REQUEST['idCliente'] : 0;

	if(empty($idCliente)){
		header("Location:newuser.php");
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
			<title>.::Mi Red::.Nuevo Usuario</title>
			<!-- Núcleo BOOTSTRAP -->
			<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
			<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
			<!--ASSETS-->
			<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
			<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
			<!-- ESTILOS MI RED -->
			<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
			<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
			<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" />
			<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
			<![endif]-->
			<style>
				.noesconsulta, .esconsulta{
					display:  none;
				}
			</style>
		</head>
		<body>
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
								<h3>Afiliación Express</h3>
								<span class="rev-combo pull-right">Afiliación<br>Express</span>
							</div>

							<div class="panel">
								<div class="jumbotron">
									<div class="container">
										<h2>Número de Sucursales</h2>
										<p>Seleccione el paquete de su preferencia.</p>
									</div>
								</div>

								<div class="panel-body">
									<div class="cliente-activo">
										<span>
											<i class="fa fa-user"></i> Cliente
										</span>
										<h3 id="lblCliente"></h3>
									</div>

									<div class="row" id="contenidoHTML">

									</div>
			 
									<a href="DatosGenerales.php?idCliente=<?php echo $idCliente;?>" class="noesconsulta">
										<form action="DatosGenerales.php" method="post">
											<input type="hidden" name="idCliente" value="<?php echo $_GET['idCliente']?>">
											<button class="btn btn-xs btn-info pull-left">Anterior</button>
										</form>
									</a>

									<a href="#" class="noesconsulta">
										<form action="" method="post" id="formSiguiente">
											<input type="hidden" name="idCliente" value="<?php echo $_GET['idCliente']?>">
											<button class="btn btn-xs btn-info pull-right" id="btnSiguiente">Siguiente</button>
										</form>
									</a>

									<a href="Cliente.php?idCliente=<?php echo $idCliente;?>" class="esconsulta">
										<button class="btn btn-xs btn-info pull-left">Regresar</button>
									</a>

									<!-- form para regresar al principio del registro del cliente -->
									<form name="formStart" id="formStart" method="post" action="newuser.php">
										<input type="hidden" name="idCliente" value="<?php echo $_GET['idCliente'];?>">
									</form>
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
<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--script src="<?php echo $PATHRAIZ;?>/inc/js/advanced-form-components.js"></script-->
<!--Cierre del Sitio-->                        

<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesNumeroSucursales.js" type="text/javascript"></script>

<script>
	$(function(){
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		ID_AFILIACION	= "<?php echo $idCliente;?>";
		ID_CLIENTE		= "<?php echo $idCliente;?>";

		ES_CONSULTA		= "<?php echo $ESCONSULTA;?>";

		initNumeroSucursales();

	});
</script>


</body>
</html>