<?php

	error_reporting(0);
	ini_set('display_errors', 0);

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

	$CLIENTE = new AfiliacionCliente($RBD, $WBD, $LOG);
	$CLIENTE->load($idCliente);

	if($CLIENTE->TIPOFORELO == 2){
		if($ESCONSULTA){
			header("Location:Cliente.php?idCliente=".$idCliente);
		}
		else{
			header("Location:formnew5.php?idCliente=".$idCliente);
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
				.confCuenta{
					display: none;
				}

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
										<h2>Comisiones y Reembolsos</h2>
										<p>Indique la manera de reembolso.</p>
									</div>
								</div>

								<div class="panel-body">
									<div class="cliente-activo">
										<span><i class="fa fa-user"></i> Cliente</span>
										<h3 id="lblCliente"></h3>
									</div>

									<div class="well">

										<form class="form-horizontal" id="formCuenta">
											<div class="form-group col-xs-4" style="margin-right:16px;">
												<label class="control-label">Liquidación de Comisiones:</label>
												<br/>
													<select class="form-control m-bot15" name="comisiones" id="cmbComisiones">
														<option value="-1">Seleccione</option>
														<option value="0">FORELO</option>
														<option value="1">Cuenta Bancaria</option>
													</select>
												</div>
 
                                                <div class="form-group col-xs-4">
												<label class="control-label">Reembolsos:</label>
												<br/>
													<select class="form-control m-bot15" name="reembolso" id="cmbReembolsos">
														<option value="-1">Seleccione</option>
														<option value="0">FORELO</option>
														<option value="1">Cuenta Bancaria</option>
													</select>
												</div>
										 
                                          <div class="form-group col-xs-4">
                                          </div>

											
                                            <div class="form-group col-xs-4 confCuenta" style="margin-right:16px;">
												<label class="control-label confCuenta">CLABE:</label>
												<br/>
													<input class="form-control m-bot15" type="text" name="CLABE">
												</div>
										
																					
											<div class="form-group col-xs-4 confCuenta" style="margin-right:16px;">
												<label class="control-label">Banco:</label>
												<br/>
													<input type="hidden" class="form-control m-bot15" type="text" name="idBanco">
													<input class="form-control m-bot15" type="text" name="txtBanco">
												</div>

                                              <div class="form-group col-xs-4 confCuenta">
												<label class="control-label">Cuenta:</label>
												<br/>
													<input class="form-control m-bot15" type="text" name="numCuenta">
												</div>
										
																					
											<div class="form-group col-xs-4 confCuenta" style="margin-right:16px;">
												<label class="control-label">Beneficiario:</label>
												<br/>
													<input class="form-control m-bot15" type="text" name="beneficiario">
												</div>

                                               <div class="form-group col-xs-4 confCuenta">
												<label class="control-label">Descripción:</label>
												<br/>
													<input class="form-control m-bot15" type="text" name="descripcion">
												</div>
										
										</form>
									</div>     

			 						<a href="NumeroSucursales.php?idCliente=<?php echo $idCliente;?>" class="noesconsulta">
										<button class="btn btn-xs btn-info pull-left">Anterior</button>
									</a>
									<a href="#" id="btnNext" class="noesconsulta boton_guardar">
			 							<button class="btn btn-xs btn-info pull-right">Siguiente</button>
			 						</a>

			 						<a href="#" class="esconsulta boton_guardar" onClick="guardarConfiguracionCuenta();">
			 							<button class="btn btn-xs btn-info pull-right">Guardar</button>
			 						</a>
			 						<a class="esconsulta" href="Cliente.php?idCliente=<?php echo $idCliente;?>">
			 							<button class="btn btn-xs btn-info pull-left">Regresar</button>
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
<!--script src="js/advanced-form-components.js"></script-->
<!--Cierre del Sitio-->

<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesConfiguracionCuenta.js" type="text/javascript"></script>

<script>
	$(function(){
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		//ID_AFILIACION	= "<?php echo $idAfiliacion;?>";
		ID_CLIENTE		= "<?php echo $idCliente;?>";

		ES_CONSULTA		= "<?php echo $ESCONSULTA;?>";

		initNumeroSucursales();

	});
</script>

</body>
</html>