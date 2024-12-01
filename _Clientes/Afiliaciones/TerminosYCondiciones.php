<?php

/*	error_reporting(E_ALL);
	ini_set('display_errors',1);*/

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
	$idCliente = (!empty($_GET['idCliente']))? $_GET['idCliente'] : 0;

	if($idCliente <= 0){
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
				.tc{
					display: none;
				}

				.noesconsulta, .esconsulta{
					display:  none;
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
								<h3>Afiliación Express</h3>
								<span class="rev-combo pull-right">Afiliación<br>Express</span>
							</div>

							<div class="panel">

								<div class="jumbotron">
									<div class="container">
										<h2>Términos y Condiciones</h2>
										<p>Env&iacute;e, lea y acepte los t&eacute;rminos y condiciones.</p>
									</div>
								</div>

								<div class="panel-body">
									<div class="cliente-activo">
										<span><i class="fa fa-user"></i> Cliente </span>
										<h3 id="lblCliente"></h3>
									</div>  

									<table class="tc" id="tbl0">
										<tbody>
											<tr>
												<td>
													<img src="<?php echo $PATHRAIZ;?>/img/check.png">
												</td>
											</tr>
											<tr>
												<td class="sub">Estado</td>
											</tr>
											<tr>
												<td>Aceptado</td>
											</tr>
											<tr>
												<td>
													<a href="#correo" data-toggle="modal" class="btn btn-labeled btn-envio">Reenviar&nbsp;&nbsp;<i class="fa fa-envelope"></i></a>
												</td>
											</tr>
										</tbody>
									</table>
 
									<table class="tc" id="tbl1">
										<tbody>
											<tr>
												<td>
													<img src="<?php echo $PATHRAIZ;?>/img/pendiente.png">
												</td>
											</tr>
											<tr>
												<td class="sub">Estado</td>
											</tr>
											<tr>
												<td>Pendiente</td>
											</tr>
											<tr>
												<td>
													<a href="#correo" data-toggle="modal" class="btn btn-labeled btn-envio boton_guardar">Reenviar&nbsp;&nbsp;<i class="fa fa-envelope"></i></a>
												</td>
											</tr>
										</tbody>
									</table>
 
									<table class="tc" id="tbl2">
										<tbody>
											<tr>
												<td>
													<img src="<?php echo $PATHRAIZ;?>/img/deny.png">
												</td>
											</tr>
											<tr>
												<td class="sub">Estado</td>
											</tr>
											<tr>
												<td>Declinado</td>
											</tr>
											<tr>
												<td>
													<a href="#correo" data-toggle="modal" class="btn btn-labeled btn-envio boton_guardar">Reenviar&nbsp;&nbsp;<i class="fa fa-envelope"></i></a>
												</td>
											</tr>
										</tbody>
									</table>

									<a href="formnew5.php?idCliente=<?php echo $idCliente;?>" class="noesconsulta">
										<button class="btn btn-xs btn-info pull-left">Anterior</button>
									</a>  
			 						<a href="Resumen.php?idCliente=<?php echo $idCliente;?>" class="noesconsulta boton_guardar">
			 							<button class="btn btn-xs btn-info pull-right">Siguiente</button>
			 						</a>

			 						<a href="Cliente.php?idCliente=<?php echo $idCliente;?>" class="esconsulta">
										<button class="btn btn-xs btn-info pull-left">Regresar</button>
									</a>  
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</section>

		<!--Inicia Modal-->
		<div class="modal fade" id="correo" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-consulta">
						<span><i class="fa fa-envelope"></i></span>
						<h3>Envío de Información</h3>
						<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
					</div>
					<div class="modal-body">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="col-xs-2 col-xs-offset-2 control-label">Correo Electrónico:</label>
								<div class="col-xs-4">
									<input type="text" class="form-control m-bot15" id="email">
								</div>
								<div class="col-xs-1">
									<a href="#" class="btn btn-guardar" onclick="enviarCorreo();">Enviar &nbsp;&nbsp;<i class="fa fa-envelope"></i></a> 
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
				
					</div>
				</div>
			</div>
		</div>
		<!--Finaliza Modal-->

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

<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/RE.js"></script>
<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesTerminosYCondiciones.js"></script>

<script>
	$(function(){
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		//ID_AFILIACION	= "<?php echo $idAfiliacion;?>";
		ID_CLIENTE		= "<?php echo $idCliente;?>";

		ES_CONSULTA		= "<?php echo $ESCONSULTA;?>";

		initTerminosYCondiciones();

	});
</script>

</body>
</html>