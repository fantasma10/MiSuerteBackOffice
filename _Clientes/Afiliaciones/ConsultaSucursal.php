<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$submenuTitulo = "Afiliaci&oacute;n Express";
	$subsubmenuTitulo = "Consulta";
	$tipoDePagina = "Mixto";
	$idOpcion = 62;

	$ES_FINALIZAR_SUCURSAL = false;
	if(isset($_POST['finalizarSucursal']) && $_POST['finalizarSucursal'] == "1"){
		$ES_FINALIZAR_SUCURSAL = true;
		$idCliente = (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

		$sql = $RBD->query("SELECT CASE `idRegimen`
										WHEN 1 THEN CONCAT_WS(' ', `Nombre`, `Paterno`, `Materno`)
										WHEN 2 THEN `RazonSocial`
										ELSE CONCAT_WS(' ', `RazonSocial`, `Nombre`, `Paterno`, `Materno`)
									END AS `nombreCliente`
				FROM `redefectiva`.`dat_cliente`
				WHERE `idCliente` = $idCliente");
		$result = mysqli_fetch_assoc($sql);
		
		if(isset($result['nombreCliente']) && !empty($result['nombreCliente'])){
			$nombreCliente = $result['nombreCliente'];
		}
		else{
			$ES_FINALIZAR_SUCURSAL = false;
		}
		
	}

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
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

			<link rel="stylesheet" href="../assets/data-tables/DT_bootstrap.css" />
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
											<h2>Consulta de Sucursales</h2>
											<p>Llene uno de los campos, y seleccione la sucursal deseada.</p>
										</div>
									</div>

									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12">
												<div class="well">
													<form class="form-horizontal">
										 
														<div class="form-group col-xs-4" style="margin-right:16px;">
															<label class="control-label">Sucursal:</label>
															<br/>
																<input type="hidden" id="idSucursal">
																<input class="form-control m-bot15" type="text" placeholder="ID ó Nombre" id="txtSucursal">
															</div>

                                                            <div class="form-group col-xs-4" style="margin-right:16px;">
															<label class="control-label">Cliente:</label>
															<br/>
																<input type="hidden" id="idAfiliacion">
																<input type="hidden" id="idSubCadena" value="0">
																<input class="form-control m-bot15" type="text" placeholder="Nombre de Cliente" name="txtCliente" id="txtCliente">
															</div>

                                                            <div class="form-group col-xs-4">
															<label class="control-label">Teléfono:</label>
															<br/>
																<input class="form-control m-bot15" type="text" placeholder="Teléfono de la Sucursal" id="txtTelefono">
															</div>
                                                            
															<div class="form-group col-xs-12" style="margin-top:20px;">
																<button type="button" class="btn btn-guardar pull-right" onClick="buscarSucursales();">Buscar </button>
															</div>
														</div>
													</form>
												</div>

												<div class="adv-table" id="htmlListaSucursales">
													<!--div id="tblListaCorresponsales_wrapper" class="dataTables_wrapper form-inline" role="grid">
														<div class="row-fluid">
															<div class="span6">
																<div id="tblListaCorresponsales_length" class="dataTables_length">
																	<label>Mostrar
																		<select class="form-control" size="1" name="tblListaCorresponsales_length" aria-controls="tblListaCorresponsales">
																			<option value="10" selected="selected">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> registros por página.</label></div></div><div class="span6"><div class="dataTables_filter" id="tblListaCorresponsales_filter"><label>Buscar <input type="text" class="form-control" aria-controls="tblListaCorresponsales">
																	</label>
																</div>
															</div>
														</div>
														<table class="display table table-bordered table-striped dataTable" id="tblListaCorresponsales" aria-describedby="tblListaCorresponsales_info">
															<thead>
																<tr><th class="sorting_asc">ID</th><th class="sorting">Nombre de Sucursal</th><th class="sorting">Dirección</th><th class="sorting">Teléfono</th><th class="sorting">Correo</th><th>Estatus</th><th>Ver</th></tr>
															</thead>
															<tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="odd"><td class=" sorting_1">1</td><td class="">Sucursal de Sucursales</td><td class="">Santander 3917 Colonia Las Torres C.P. 64930, Monterrey NuevoLeón México.</td><td class="tdder">8186017744</td><td class="">correo@correo.com.mx</td><td>Incompleto</td><td><a href="consulta_express_sucursal.php">Ver</a></td>
															</tr>
														</table>
													</div-->
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
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js"></script>
<!--Cierre del Sitio-->

<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>

<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesConsultaSucursal.js"></script>

<script>
	$(function(){
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";

		ES_FINALIZAR_SUCURSAL	= "<?php echo $ES_FINALIZAR_SUCURSAL;?>";
		ID_CLIENTE				= "<?php echo $idCliente;?>";
		NOMBRE_CLIENTE			= "<?php echo $nombreCliente;?>";
		initConsultaSucursal();
	
		if(ES_FINALIZAR_SUCURSAL){
			$("#txtCliente").val(NOMBRE_CLIENTE);
			$("#idAfiliacion").val(ID_CLIENTE);
			$("#idSubCadena").val(ID_CLIENTE);

			buscarSucursales();
		}
	});
</script>

</body>
</html>
