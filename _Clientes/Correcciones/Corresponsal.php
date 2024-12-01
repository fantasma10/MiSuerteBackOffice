<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../inc/config.inc.php");
	include("../../inc/session.inc.php");

	$idOpcion		= 1;
	$tipoDePagina	= "Escritura";
	$idPerfil		= $_SESSION['idPerfil'];

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location: ../../../error.php");
		exit();
	}

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}
	$submenuTitulo		= "Correcciones";
	$subsubmenuTitulo	= "Corresponsal";

	if(!isset($_SESSION['rec'])){
		$_SESSION['rec'] = true;
	}

	header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
	header("Pragma: no-cache");
	header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

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
			<div class="panel panelrgb">
				<div class="titulorgb-prealta">
					<span><i class="fa fa-users"></i></span>
					<h3>Actualización de Corresponsal</h3>
					<span class="rev-combo pull-right">Afiliación<br>Express</span>
				</div>  
				<div class="panel-body">
					<form name="formCorreccionCorresponsal" id="frmCorreccionCorresponsal">
						<div class="row">
							<div class="col-xs-4">
								<div class="form-group">
									<label>Corresponsal</label>
									<input type="text" class="form-control" name="sNombreCorresponsal" id="txtSNombreCorresponsal"/>
									<input type="hidden" class="form-control" name="nIdCorresponsal" id="txtNIdCorresponsal"/>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<label>Cliente</label>
									<select class="form-control" name="nIdCliente" id="cmbCliente">
										<option>--</option>
									</select>
								</div>
							</div>
							<div class="col-xs-4">
								<?php
									if($esEscritura){
								?>
								<button type="button" class="btn btn-sm btn-default" style="margin-top:20px;" id="btnActualizarCorresponsal">Actualizar</button> 
								<?php
									}
								?>
							</div>
						</div>
					</form>
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
<script src="../../css/ui/jquery.ui.core.js"></script>
<script src="../../css/ui/jquery.ui.widget.js"></script>
<script src="../../css/ui/jquery.ui.position.js"></script>
<script src="../../css/ui/jquery.ui.menu.js"></script>
<script src="../../css/ui/jquery.ui.autocomplete.js"></script>
<script src="../../inc/js/Correcciones/corresponsal.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>