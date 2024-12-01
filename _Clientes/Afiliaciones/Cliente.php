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

	$idCliente = (!empty($_GET['idCliente']))? $_GET['idCliente'] : 0;

	if($idCliente <= 0){
		header("Location:newuser.php");
	}
	else{
		//$_SESSION['consultaAfiliacion'] = true;
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
								<h3>Consulta de Clientes</h3>
								<span class="rev-combo pull-right">Afiliación<br>Express</span>
							</div>

							<div class="panel">

								<div class="jumbotron">
									<div class="container">
										<h2 id="lblCliente"></h2>
										<div class="row">
											<div class="col-xs-3">
												<div class="info">
													<div class="titulo">Nivel Expediente</div>
													<div class="regimen" id="nombreNivel"></div>
												</div>
											</div>
						
											<div class="col-xs-3">
												<div class="info">
													<div class="titulo">Estatus</div>
													<div class="regimen" id="pagoPendiente"></div>
												</div>
											</div>

											<div class="col-xs-3">
												<div class="info">
													<div class="titulo">Tipo de FORELO</div>
													<div class="regimen" id="lblTipoForelo"></div>
												</div>
											</div>

											<!--div class="col-xs-3">
												<div class="info">
													<div class="titulo">FORELO</div>
													<div class="regimen"></div>
												</div>
											</div-->
										</div>
									</div>
								</div>

								<div class="panel-body">
									<div class="well">
										<ul>
											<li>
												<!--a href="newuser.php?idCliente=<?php echo $idCliente?>"><i class="fa fa-file"></i> Nivel de Expediente</a-->
												<form id="formExpediente" action="newuser.php" method="post">
													<input type="hidden" name="consultaAfiliacion" value="true">
													<input type="hidden" name="idCliente" value="<?php echo $idCliente;?>">
													<a href="#" onClick="submitForm('formExpediente')"><i class="fa fa-file"></i> Nivel de Expediente</a>
													<i class="fa fa-square-o pull-right" id="iExpediente"></i>
												</form>
											</li>
											<li>
												<!--a href="DatosGenerales.php?idCliente=<?php echo $idCliente?>"><i class="fa fa-book"></i> Información General</a-->
												<form id="formGenerales" action="DatosGenerales.php" method="post">
													<input type="hidden" name="consultaAfiliacion" value="true">
													<input type="hidden" name="idCliente" value="<?php echo $idCliente;?>">
													<a href="#" onClick="submitForm('formGenerales')"><i class="fa fa-book"></i> Información General</a>
													<i class="fa fa-square-o pull-right" id="iGenerales"></i>
												</form>
											</li>
											<li>
												<!--a href="NumeroSucursales.php?idCliente=<?php echo $idCliente?>"><i class="fa fa-home"></i> Tipo de FORELO y Cantidad de Sucursales</a-->
												<form id="formNumSucursales" action="NumeroSucursales.php?idCliente=<?php echo $idCliente?>" method="post">
													<input type="hidden" name="consultaAfiliacion" value="true">
													<a href="#" onClick="submitForm('formNumSucursales')"><i class="fa fa-home"></i> Tipo de FORELO y Cantidad de Sucursales</a>
													<i class="fa fa-square-o pull-right" id="iNumSucursales"></i>
												</form>
											</li>
											<li id="liComisiones">
												<!--a href="ConfiguracionCuenta.php?idCliente=<?php echo $idCliente?>"><i class="fa fa-dollar"></i> Comisiones y Reembolsos</a-->
												<form id="formConfig" action="ConfiguracionCuenta.php?idCliente=<?php echo $idCliente?>" method="post">
													<input type="hidden" name="consultaAfiliacion" value="true">
													<a href="#" onClick="submitForm('formConfig')"><i class="fa fa-dollar"></i> Comisiones y Reembolsos</a>
													<i class="fa fa-square-o pull-right" id="iConfig"></i>
												</form>
											</li>
											<!--li>
												<a href="formnew4.php"><i class="fa fa-folder"></i> Documentación</a>
												<form id="formDocumentacion" action="formnew4.php?idCliente=<?php echo $idCliente?>" method="post">
													<input type="hidden" name="consultaAfiliacion" value="true">
													<a href="#"><i class="fa fa-folder"></i> Documentaci&oacute;n</a>
													<i class="fa fa-square-o pull-right" id="iDocs"></i>
												</form>
											</li-->
											<li>
												<?php
													$qT = $RBD->query("SELECT COUNT(*) AS `numS` FROM `afiliacion`.`dat_sucursal` WHERE idCliente = $idCliente AND idEstatus IN(0, 1)");
													$resT = mysqli_fetch_assoc($qT);
													$numSucursales = $resT['numS'];

													$qA = $RBD->query("SELECT COUNT(*) AS `numA` FROM `afiliacion`.`dat_sucursal` WHERE idCliente = $idCliente AND idEstatus = 0");
													$resA = mysqli_fetch_assoc($qA);
													$sucActivas = $resA['numA'];
													
													$qMax = $RBD->query("SELECT `MaxSucursales` FROM afiliacion.dat_cliente WHERE `idCliente` = $idCliente;");
													$resMax = mysqli_fetch_assoc($qMax);
													$maxSuc = $resMax['MaxSucursales'];
													
													//var_dump("numSucursales: $numSucursales");
													//var_dump("sucActivas: $sucActivas");
													
													/*if($numSucursales > 0 && $numSucursales == $sucActivas){
														$lbl = '<i class="fa fa-check-square-o pull-right" id="iSucursales"></i>';
													}
													else{
														$lbl = '<i class="fa fa-square-o pull-right" id="iSucursales"></i>';
													}*/
													/*if($numSucursales > 0 && $sucActivas >= 1){
														$lbl = '<i class="fa fa-check-square-o pull-right" id="iSucursales"></i>';
													}else{
														$lbl = '<i class="fa fa-square-o pull-right" id="iSucursales"></i>';
													}*/
													if($numSucursales > 0 && $numSucursales = $sucActivas && $sucActivas == $maxSuc){
														$lbl = '<i class="fa fa-check-square-o pull-right" id="iSucursales"></i>';
													}else{
														$lbl = '<i class="fa fa-square-o pull-right" id="iSucursales"></i>';
													}
												?>
												<!--a href="formnew5.php?idCliente=<?php echo $idCliente?>"><i class="fa fa-home"></i> Sucursales</a><span>10 de 20</span-->
												<form id="formSucursales" action="formnew5.php?idCliente=<?php echo $idCliente?>" method="post">
													<input type="hidden" name="consultaAfiliacion" value="true">
													<a href="#" onClick="submitForm('formSucursales')"><i class="fa fa-home"></i> Sucursales</a>
													<?php echo $lbl;?>
													<span id="lblSucursales"></span>
												</form>
											</li>
											<li>
												<!--a href="TerminosYCondiciones.php?idCliente=<?php echo $idCliente?>"><i class="fa fa-file-text"></i> Estado de Términos y Condiciones</a-->
												<form id="formTerminos" action="TerminosYCondiciones.php?idCliente=<?php echo $idCliente?>" method="post">
													<input type="hidden" name="consultaAfiliacion" value="true">
													<a href="#" onClick="submitForm('formTerminos')"><i class="fa fa-file-text"></i> Estado de T&eacute;rminos y Condiciones</a>
													<i class="fa fa-square-o pull-right" id="iTerminos"></i>
												</form>
											</li>
											<li>
												<!--a href="Resumen.php?idCliente=<?php echo $idCliente?>"><i class="fa fa-bank"></i> Referencia Bancaria</a-->
												<form id="formReferencia" action="Resumen.php?idCliente=<?php echo $idCliente?>" method="post">
													<input type="hidden" name="consultaAfiliacion" value="true">
													<a href="#" onClick="submitForm('formReferencia')"><i class="fa fa-bank"></i> Referencia Bancaria</a>
													<i class="fa fa-check-square-o pull-right" id="iReferencia"></i>
												</form>
											</li>
										</ul>
									</div>
									<a href="#" onClick="crearCliente(<?php echo $idCliente;?>);"><button id="btn_crear" style="display:none" class="btn btn-xs btn-info pull-left">Crear</button></a>
										
								<a href="ConsultaCliente.php">
									<button class="btn btn-xs btn-info pull-right">Regresar</button>
								</a>
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
<!--Cierre del Sitio-->                             

<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesConsultaCliente.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesCliente.js"></script>

<script>
	$(function(){
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		ID_CLIENTE		= "<?php echo $idCliente;?>";
		
		initCliente();
	});
	function crearCliente(idCliente){
		if(idCliente != undefined){
			$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/crearCliente.php",
				{
					idCliente : idCliente
				},
				function(response){

					if(showMsg(response)){
						alert(response.msg);
					}

					window.location = "ConsultaCliente.php";
				},
				"json"
			);
		}
	}
</script>

</body>
</html>