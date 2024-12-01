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
	else if(!empty($_POST['consultaSucursal'])){
		$idOpcion = 61;
		$ESCONSULTA = false;
		$ESCONSULTASUCURSAL  = true;
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
	$idCliente	= (!empty($_GET['idCliente']))? $_GET['idCliente'] : 0;
	$idSubCadena = (isset($_GET['idSubCadena']))? $_GET['idSubCadena'] : -1;

	if($_POST['vieneDeNuevaSucursal'] == 0 && $_POST['esSubCadena'] == 0){
		$idSubCadena = $idCliente;
		$idCliente = 0;
	}
	else{
		if($_POST['esSubCadena'] == 1){
			$idSubCadena = -1;
		}
		else if($_POST['esSubCadena'] == 0){
			$idSubCadena = $idCliente;
		}
	}

	$tbl = '';

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
			<title>.::Mi Red::.Depósito</title>
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
			
			<link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" />
            
            <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
			<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />

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
											<h2>Depósito a FORELO</h2>
											<p>Deposite la cantidad mostrada en alguna de las siguientes cuentas con su referencia correspondiente.</p>
										</div>
									</div>

									<div class="panel-body">
										<div class="cliente-activo">
											<span><i class="fa fa-user"></i> Cliente </span>
											<h3 id="lblCliente"></h3>
										</div>

										<?php
											$SUB = new SubCadena($RBD, $WBD);

											$res = $SUB->load($idSubCadena);

											$response = array();

											if($res['codigoRespuesta'] == 0){
												$response['success'] = true;

												$referenciaBancaria = $SUB->getReferenciaBancaria();
											}
											else{
												$response['success'] = false;
											}

											$sql = $RBD->query("SELECT `idCliente`, `idTipoForelo` FROM `redefectiva`.`dat_cliente` WHERE `idSubCadena` = $idSubCadena");
											$res = mysqli_fetch_assoc($sql);

											$idCliente = $res['idCliente'];
											$idTipoForelo = $res['idTipoForelo'];

											if($idCliente > 0){
												if($idCliente > 0){
													$CLIENTE = new AfiliacionCliente($RBD, $WBD, $LOG);
													$CLIENTE->loadClienteReal($idCliente, 1);
												}

												if($idCliente > 0){
													$tbl .= '<th>Inversi&oacute;n por Tienda</th>
														<th>Inversi&oacute;n Total</th>';

													$sql2 = $RBD->query("CALL afiliacion.SP_COSTO_FIND($CLIENTE->IDCOSTO, $CLIENTE->IDNIVEL)");
													$res2 = mysqli_fetch_assoc($sql2);
													$costo = $CLIENTE->COSTO/*$res2['Afiliacion']*/;
													$sqlC = $RBD->query("SELECT COUNT(*) AS `cuenta` FROM `afiliacion`.`dat_sucursal` WHERE idSubcadena = $idCliente AND `idEstatus` IN(1, 0)");
													$res = mysqli_fetch_assoc($sqlC);
													$CLIENTE->NUMEROCORRESPONSALES = $res['cuenta'];

													$costoTotal = $CLIENTE->PAGO_PENDIENTE/*$costo * $CLIENTE->NUMEROCORRESPONSALES*/;
												}
											}
										

											$QUERY = "CALL `afiliacion`.`SP_CUENTA_BANCARIA_LISTA`(0, 0, 1, 0)";
											$sql = $RBD->query($QUERY);

											if(!$RBD->error()){
												$result = array();
												while($row = mysqli_fetch_assoc($sql)){
													$result[] = $row;
												}
											}
										?>

										<table class="deposito-activo">
											<thead>
												<tr>
													<th>
														<span class="deposito-activo">Banco</span>
													</th>
													<th>
														<span class="deposito-activo">Cuenta</span>
													</th>
													<th>
														<span class="deposito-activo">CLABE</span>
													</th>
													<?php if($idCliente > 0){ ?>
													<th>
														<span class="deposito-activo">Inversión por Tienda</span>
													</th>
													<?php } ?>
													<?php if($idTipoForelo == 1){?>
													<th>
														<span class="deposito-activo">Referencia</span>
													</th>
													<?php }?>
													<?php if($idCliente > 0){ ?>
													<th>
														<span class="deposito-activo">Inversión Total</span>
													</th>
													<?php } ?>
												</tr>
											</thead>
											<tbody>
												<?php
													$rowspan = count($result);
													$rowspan = ($rowspan == 0)? 1 : $rowspan;

													$vuelta = 1;

													foreach($result as $key => $res){
														echo "<tr>";
															echo "<td>".(!preg_match("!!u", $res['nombreBanco'])? utf8_encode($res['nombreBanco']) : $res['nombreBanco'])."</td>";
															echo "<td>".$res['numCuenta']."</td>";
															echo "<td>".$res['CLABE']."</td>";

														if($vuelta == 1){
															if($idCliente > 0){
																echo "<td rowspan='$rowspan'>
																		<h3 id='costo'>\$".number_format($costo, 2)."</h3>
																	</td>";
															}

															if($idTipoForelo == 1){
																echo "<td rowspan='$rowspan'>
																		<h3>$referenciaBancaria</h3>
																	</td>";
															}

															if($idCliente > 0){
																echo "<td rowspan='$rowspan'>
																		<h3 id='CostoTotal'>\$".number_format($costoTotal, 2)."</h3>
																	</td>";
															}
														}
														$vuelta++;
														echo "</tr>";
													}
												?>
												
											</tbody>
										</table>

										<div class="adv-table" id="htmlTbl">
											
										</div>

										<table class="tc">
											<tbody>
												<tr>
													<td>
														<a href="#correo" data-toggle="modal" class="btn btn-labeled btn-envio boton_guardar">Enviar Información&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-envelope"></i></a>
													</td>
												</tr>
											</tbody>
										</table>

										<form method="post" action="ConsultaSucursal.php">
			 								<input type="hidden" name="idCliente" value="<?php echo $idCliente;?>">
			 								<input type="hidden" name="finalizarSucursal" value="1">
			 								<a class="noesconsulta" href="#">
			 									<button class="btn btn-xs btn-info pull-right"> Finalizar</button>
			 								</a>
			 							</form>
		 								<a class="noesconsulta" href="TerminosYCondiciones.php?idCliente=<?php echo $idCliente;?>"><button class="btn btn-xs btn-info pull-left"> Anterior</button></a>

		 								<a class="esconsulta" href="Cliente.php?idCliente=<?php echo $idCliente;?>"><button class="btn btn-xs btn-info pull-left"> Regresar</button></a>
		 								
		 								<?php if($ESCONSULTASUCURSAL){ ?>
		 									<form id="formRegresar" action="Sucursal.php?ns=<?php echo $_GET['ns']?>&n2=<?php echo $_GET['ns2'];?>&idSubCadena=<?php echo $_REQUEST['idSubCadena'];?>&idSucursal=<?php echo $_REQUEST['idSucursal'];?>&idCliente=<?php echo $_GET['idCliente'];?>" method="post">
		 								<?php }
		 								else { ?>
		 									<form id="formRegresar" action="formnew5.php?ns=<?php echo $_GET['ns']?>&n2=<?php echo $_GET['ns2'];?>&idSubCadena=<?php echo $_REQUEST['idSubCadena'];?>&idSucursal=<?php echo $_REQUEST['idSucursal'];?>&idCliente=<?php echo $_GET['idCliente'];?>" method="post">
		 								<?php } ?>
											<input type="hidden" name="consultaSucursal" value="<?php echo $_REQUEST['consultaSucursal'];?>">
											<input type="hidden" name="idCliente" value="<?php echo $_GET['idCliente'];?>">
											<input type="hidden" name="esSubcadena" value="<?php echo $_REQUEST['esSubcadena'];?>">
											<input type="hidden" name="idSucursal" value="<?php echo $_REQUEST['idSucursal']?>">
											<input type="hidden" name="vieneDeNuevaSucursal" value="<?php echo $_REQUEST['vieneDeNuevaSucursal'];?>">
		 									<a href="#">
		 										<button class="btn btn-xs btn-info pull-left"> Regresar</button>
		 									</a>
										</form>
										<form method="post" action="ConsultaSucursal.php">
			 								<input type="hidden" name="idCliente" value="<?php echo $idCliente;?>">
			 								<input type="hidden" name="finalizarSucursal" value="1">
			 								<a class="" href="#">
			 									<button class="btn btn-xs btn-info pull-right"> Finalizar</button>
			 								</a>
			 							</form>
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
										<input type="text" class="form-control m-bot15" name="email" id="email">
									</div>
									<div class="col-xs-1">
										<!--a href="#" class="btn btn-labeled btn-envio" data-dismiss="modal" */-->
										<a href="#" class="btn btn-labeled btn-envio" onClick="enviarCorreo2()">
											Enviar &nbsp;&nbsp;<i class="fa fa-envelope"></i>
										</a> 
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
<!--script src="<?php echo $PATHRAIZ;?>/inc/js/jquery-1.10.2.js" type="text/javascript"></script-->

<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Cierre del Sitio-->                             



<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>

<script src="<?php echo $PATHRAIZ;?>/inc/js/advanced-form-components.js"></script>

<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<link href="<?php echo $PATHRAIZ;?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css"  rel="stylesheet"/>

<script src="<?php echo $PATHRAIZ;?>/inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesResumen.js" type="text/javascript"></script>

<script>
	$(function(){
		/*
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";

		ES_CONSULTA		= "<?php echo $ESCONSULTA;?>";

		if(ID_SUBCADENA == -1){
			initResumen();
		}
		else{*/
			//initResumen2();
		/*}*/
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_CLIENTE		= "<?php echo $idCliente;?>";
		ID_SUBCADENA	= "<?php echo $idSubCadena;?>";

		ROW_SPAN		= "<?php echo $rowspan;?>";
		mostrarListaSucursales2();
	});
</script>

</body>
</html>