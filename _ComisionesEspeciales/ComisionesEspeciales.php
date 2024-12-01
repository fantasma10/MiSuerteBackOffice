<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../inc/config.inc.php");
	include("../inc/session.inc.php");

	$idCadena			= (!empty($_POST['idCadena']))? $_POST['idCadena'] : 0;
	$idSubCadena		= (!empty($_POST['idSubCadena']))? $_POST['idSubCadena'] : -1;
	$idSubCadenaR		= (!empty($_POST['idSubCadenaR']))? $_POST['idSubCadenaR'] : -1;
	$idCorresponsal		= (!empty($_POST['idCorresponsal']))? $_POST['idCorresponsal'] : -1;
	$idCorresponsalR	= (!empty($_POST['idCorresponsalR']))? $_POST['idCorresponsalR'] : -1;
	$idGrupo			= (!empty($_POST['idGrupo']))? $_POST['idGrupo'] : 0;
	$idVersion			= (!empty($_POST['idVersion']))? $_POST['idVersion'] : 0;
	$regresaA			= (!empty($_POST['regresaA']))? $_POST['regresaA'] : '';
	$name				= (!empty($_POST['nombre']))? $_POST['nombre'] : '';

	$nombre = (!preg_match('!!u', $name))? utf8_encode($name) : $name;

	$lblCorner = ($idCorresponsal == -1)? 'SubCadena' : 'Corresponsal';

	//echo "<pre>".var_dump($_POST)."</pre>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Favicon-->
	<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
	<title>Comisiones Especiales</title>

	<!-- Núcleo BOOTSTRAP -->
	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../../assets/opensans/open.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="../../css/miredgen.css" rel="stylesheet">
	<link href="../../css/style-responsive.css" rel="stylesheet" />

	<style>
		.divInvisible{
			display: none;
		}

		.divShowTablaParent{
			display	: none;
		}

		.importesCom, .perCom{
			text-align : right;
		}
	</style>

	<script>

		function loadTabla(){
			cargaTabla(<?php echo $idCadena?>, <?php echo $idSubCadena?>, <?php echo $idCorresponsal?>);
			cargaComboProductos(<?php echo $idVersion?>, <?php echo $idCadena?>, <?php echo $idSubCadena?>, <?php echo $idCorresponsal?>);
		}

		window.onload = loadTabla;
	</script>
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../inc/cabecera.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include("../inc/menu.php"); ?>
<!--Final del Menú Vertical-->

<!--Contenido Principal del Sitio-->

<section id="main-content">
<section class="wrapper site-min-height">
<div class="row">
<div class="col-lg-12">

<!--Panel Principal-->
<div class="panelrgb">
<div class="panel">
	<div class="titulorgb-prealta">
		<span>
			<i class="fa fa-check-square"></i>
		</span>

		<h3><?php echo $nombre;?></h3>
		<span class="rev-combo pull-right">
			Autorización<br> de <?php echo $lblCorner;?>
		</span>
	</div>

	<div class="panel-body">
		<a href="#modal" data-toggle="modal" class="btn btnrevision" onclick="regresaA('<?php echo $regresaA;?>', <?php echo $idCadena?>, <?php echo $idSubCadena?>, <?php echo $idCorresponsal?>);"><i class="fa fa-mail-reply"></i> Regresar</a>
		<div class="room-desk">
			<h4 class="text-primary">
				<i class="fa fa-money"></i> Comisiones Personalizadas
			</h4>
			<br>
			<div class="room-flex">
					<form class="form-horizontal">
						<div class="comisiones"> 
							<label class="col-lg-1 col-sm-2 col-xs-2 control-label">Producto:</label>
							<div class="col-lg-4 col-sm-5 col-xs-6" id="divComboProducto">
								<select class="form-control m-bot15"></select>
							</div>
						</div>
						<button type="button" class="btn btn-default btn-xs"
							onclick="cargaComision(<?php echo $idGrupo?>,
															<?php echo $idVersion?>,
															<?php echo $idCadena?>,
															<?php echo $idSubCadenaR?>,
															-1);">Agregar</button>
					</form>
			</div>
			<!--DIV Agregar-->

				<div class="divInvisible">
					<div class="room-invisible">
						<h5 class="text-primary">Porcentaje de Comisión</h5>
						<!--Otro-->
						<form class="form-horizontal" id="formComisiones">
							<input type="hidden" id= "idPermiso" name = "idPermiso" value="0" obligatorio>
							<input type="hidden" id= "idCadena" name = "idCadena" value="<?php echo $idCadena;?>" obligatorio>
							<input type="hidden" id= "idSubCadena" name = "idSubCadena" value="<?php echo $idSubCadena;?>" obligatorio>
							<input type="hidden" id= "idSubCadenaR" name = "idSubCadenaR" value="<?php echo $idSubCadenaR;?>" obligatorio>
							<input type="hidden" id= "idCorresponsal" name = "idCorresponsal" value="<?php echo $idCorresponsal;?>" obligatorio>
							<input type="hidden" id= "idCorresponsalR" name = "idCorresponsalR" value="<?php echo $idCorresponsalR;?>" obligatorio>
							<input type="hidden" id= "idGrupo" name = "idGrupo" value="<?php echo $idGrupo;?>" obligatorio>
							<input type="hidden" id= "idVersion" name = "idVersion" value="<?php echo $idVersion;?>" obligatorio>
							<input type="hidden" id= "idProducto" name = "idProducto" value="" obligatorio>

							<div class="form-group">
								<label class="col-lg-2 control-label">Cliente:</label>
								<div class="col-lg-2">
									<input type="text" class="form-control perCom" placeholder="10%" id="perComCliente" name="perComCliente" value='0.00'>
								</div>

								<label class="col-lg-2 control-label">Corresponsal:</label>
								<div class="col-lg-2">
									<input type="text" class="form-control perCom" placeholder="10%" id="perComCorresponsal" name="perComCorresponsal" value='0.00'>
								</div>

								<label class="col-lg-2 control-label">Comisión Especial:</label>
								<div class="col-lg-2">
									<input type="text" class="form-control perCom" placeholder="10%" id="perComEspecial" name="perComEspecial" value='0.00'>
								</div>
							</div>
						
					
						<h5 class="text-primary">Importe de Comisión</h5>
						<!--Otro-->
						
							<div class="form-group">
								<label class="col-lg-2 control-label">Cliente:</label>
								<div class="col-lg-2">
									<input type="text" class="form-control importesCom" placeholder="$10.00" id="impComCliente" name="impComCliente" value='0.00'>
								</div>

								<label class="col-lg-2 control-label">Corresponsal:</label>
								<div class="col-lg-2">
									<input type="text" class="form-control importesCom" placeholder="$10.00" id="impComCorresponsal" name="impComCorresponsal" value='0.00'>
								</div>

								<label class="col-lg-2 control-label">Comisión Especial:</label>
								<div class="col-lg-2">
									<input type="text" class="form-control importesCom" placeholder="$10.00" id="impComEspecial" name="impComEspecial" value='0.00'>
								</div>
							</div>
						
						
							<h5 class="text-primary">Limite de Importe</h5>
							<div class="form-group">
								<label class="col-lg-2 control-label">Máximo:</label>
								<div class="col-lg-2">
									<input type="text" class="form-control importesCom" placeholder="$10.00" id="impMaxPermiso" name="impMaxPermiso" value='0.00'>
								</div>

								<label class="col-lg-2 control-label">Mínimo:</label>
								<div class="col-lg-2">
									<input type="text" class="form-control importesCom" placeholder="$10.00" id="impMinPermiso" name="impMinPermiso" value='0.00'>
								</div>
							</div>
						
						
							<h5 class="text-primary">Permiso</h5>
							<div class="form-group">
								<label class="col-lg-2 control-label">Permitido:</label>
								<div class="col-lg-2">
									<select class="form-control m-bot15" id="idTipoPermiso" name="idTipoPermiso">
										<option value='0'>Si</option>
										<option value='1'>No</option>
									</select>
								</div>
							</div>
						</form>
					</div>

					<div style="float:right;">
						<a class="btn btn-default btn-xs" href="#" id="btnGuardarComisiones">Guardar</a>
					</div>
				</div>
			
		</div>
	
		<div class="divShowTablaParent">
			<div class="room-invisible col-lg-12">
				<div class="col-lg-12" id='divShowTabla'>

				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!--Fin-->
</div>
</div>
</section>
</section>



<!--*.JS Generales-->
<script src="../inc/js/jquery.js"></script>
<script src="../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../inc/js/jquery.scrollTo.min.js"></script>
<script src="../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../inc/js/common-scripts.js"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../inc/js/_ComisionesEspeciales.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>