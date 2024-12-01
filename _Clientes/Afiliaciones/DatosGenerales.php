<?php 

	error_reporting(0);
	ini_set('display_errors', 0);
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$submenuTitulo = "Afiliaci&oacute;n Express";
	$subsubmenuTitulo = "Datos Generales";
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

	$directorio = $_SERVER['HTTP_HOST'];
	$PATHRAIZ = "https://".$directorio;

	$idNivel	= (!empty($_POST['idNivel']))? $_POST['idNivel'] : 0;
	$familias	= (!empty($_POST['familias']))? $_POST['familias'] : 0;
	$idCliente	= (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	if(empty($_POST['idCliente'])){
		if(empty($idNivel) || empty($familias)){
			header("Location:newuser.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--Favicon-->
		<link rel="shortcut icon" href="<?php echo $PATHRAIZ?>/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo $PATHRAIZ?>/img/favicon.ico" type="image/x-icon">
		<title>.::Mi Red::.Nuevo Usuario</title>
		<!-- Núcleo BOOTSTRAP -->
		<!--link href="<?php echo $PATHRAIZ?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet"-->

		<link rel="stylesheet" href="<?php echo $PATHRAIZ?>/css/themes/base/jquery.ui.all.css" />
		<link href="<?php echo $PATHRAIZ?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ?>/css/bootstrap-reset.css" rel="stylesheet">
		<!--ASSETS-->
		<link href="<?php echo $PATHRAIZ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ?>/assets/opensans/open.css" rel="stylesheet" />
		<!-- ESTILOS MI RED -->
		<link href="<?php echo $PATHRAIZ?>/css/miredgen.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ?>/css/style-responsive.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ?>/assets/bootstrap-datepicker/css/datepicker.css" />
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

		<style>
			.noesconsulta, .esconsulta{
				display:  none;
			}
			.ui-autocomplete-loading {
				background: white url('../../img/loadAJAX.gif') right center no-repeat;
			}
			.ui-autocomplete {
				max-height: 190px;
				overflow-y: auto;
				overflow-x: hidden;
				font-size: 12px;
			}

			.personafisica, .personamoral, .personamoral2{
				display: none;
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
			<div class="col-xs-12">

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
								<h2>Ingresa la Información</h2>
								<p>Llene los datos del cliente.</p>
							</div>
						</div>

						<div class="panel-body" id="htmlContent">

						</div>

						<div class="panel-body">
							<a href="#" id="btnAnterior" class="noesconsulta">
								<form name="formAnterior" id="formAnterior" action="newuser.php" method="post">
									<input type="hidden" name="idNivel" value="<?php echo $_POST['idNivel'];?>"/>
									<input type="hidden" name="familias" value="<?php echo $_POST['familias'];?>"/>
									<input type="hidden" name="idCliente" value="<?php echo $_POST['idCliente'];?>"/>
									<button type="" onClick="enviarForm('formAnterior');" class="btn btn-xs btn-info pull-left">Anterior</button>
								</form>
							</a>
							
							<a href="#" onClick="guardarDatosGenerales();" class="noesconsulta"><button class="btn btn-xs btn-info pull-right">Siguiente</button></a>


							<a href="#" id="btnRegresar" class="esconsulta"><button class="btn btn-xs btn-info pull-left">Regresar</button></a> 
							<a href="#" onClick="guardarDatosGenerales();" class="esconsulta"><button class="btn btn-xs btn-info pull-right">Guardar</button></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>

<!--*.JS Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--script src="<?php echo $PATHRAIZ;?>/inc/js/advanced-form-components.js"></script-->
<!--Cierre del Sitio-->

<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesExpressClienteGenerales.js" type="text/javascript"></script>


<script>
	$(function(){
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		ID_AFILIACION	= "<?php echo $idAfiliacion;?>";

		ES_CONSULTA		= "<?php echo $ESCONSULTA;?>";
		ID_NIVEL		= "<?php echo $idNivel;?>";
		ID_CLIENTE		= "<?php echo $idCliente;?>";

		initDatosGeneralesAfiliacion();

	});
</script>

</body>
</html>