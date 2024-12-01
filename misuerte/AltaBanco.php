<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Banco";
$subsubmenuTitulo	= "Alta de Banco";

$tipoDePagina = "mixto";
$idOpcion = 90;

if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
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
	<title>.::Mi Red::.Alta de Banco</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
			<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
			<![endif]-->
			
		</head>
		<!--Include Cuerpo, Contenedor y Cabecera-->
		<?php include($PATH_PRINCIPAL."/inc/cabecera2.php"); ?>
		<!--Fin de la Cabecera-->
		<!--Inicio del Menú Vertical-->
		<!--Función "Include" del Menú-->
		<?php include($PATH_PRINCIPAL."/inc/menu.php"); ?>
		<!--Final del Menú Vertical-->
		<!--Contenido Principal del Sitio-->
		<section id="main-content">
			<section class="wrapper site-min-height">
				<div class="row">
					<div class="col-lg-12">
						<!--Panel Principal-->
						<div class="panelrgb">
							<div class="titulorgb-prealta">
								<span><i class="fa fa-credit-card"></i></span>
								<h3>Datos del Banco</h3><span class="rev-combo pull-right">Alta <br>de Banco</span>
							</div>
							<div class="panel">
								<div class="panel-body">
								<div class="well">
									<div class="form-group col-xs-12">
										<label class="col-xs-4 control-label">Selecciona el tipo de cuenta: </label>
									</div>
									<div class="form-group col-xs-12">
										<div class="form-group col-xs-4">
											<select name="opcionCuenta" id="opcionCuenta" class="form-control m-bot15">
												<option value="0">Seleccione una opcion</option>
												<option value="1">Cuenta de Abono</option>
												<option value="2">Cuenta de Cargo</option>
												<option value="3">Cuenta de Cargo y Abono</option>
											</select>
										</div>
									</div>
								</div>
								<div class="well" id="cuentaAbono" style="display:none">
										<div>
											<h4><span><i class="fa fa-arrow-circle-up"></i></span> Cuenta de Abono</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Selecciona un banco</label>
											<label class="col-xs-4 control-label">Numero de cuenta bancaria: </label>
											<label class="col-xs-4 control-label">Numero de cuenta contable:</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<select name="banco" id="banco" class="form-control m-bot15">
													<option value="0">Banco</option>
													<?php 
													$result = $MRDB->SP("CALL `redefectiva`.`SP_LOAD_BANCOS`();") or die(mysql_error());
													while($row = mysqli_fetch_array($result)){
														$id = $row["idBanco"];
														$nombre = utf8_encode($row["nombreBanco"]);
														echo '<option value='.$id.'>'.$nombre.'</option>';                    
													} 
													mysqli_free_result($result);
													?>
												</select>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="cuentaBancaria" class='form-control m-bot15'">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="cuentaContable" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Saldo Inicial:</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="saldo" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
											<button class="btn btn-xs btn-info " id="guardar" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando" value="1" style="margin-top:10px;"> Guardar </button>
										</div>										
									</div>
									<div class="well" id="cuentaCargo" style="display:none">
										<div>
											<h4><span><i class="fa fa-arrow-circle-down"></i></span> Cuenta de Cargo</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Selecciona un banco</label>
											<label class="col-xs-4 control-label">Numero de cuenta bancaria: </label>
											<label class="col-xs-4 control-label">Numero de cuenta contable:</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<select name="bancoCargo" id="bancoCargo" class="form-control m-bot15">
													<option value="0">Banco</option>
													<?php 
													$result = $MRDB->SP("CALL `redefectiva`.`SP_LOAD_BANCOS`();") or die(mysql_error());
													while($row = mysqli_fetch_array($result)){
														$id = $row["idBanco"];
														$nombre = utf8_encode($row["nombreBanco"]);
														echo '<option value='.$id.'>'.$nombre.'</option>';                    
													} 
													mysqli_free_result($result);
													?>
												</select>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="cuentaBancariaCargo" class='form-control m-bot15'">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="cuentaContableCargo" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Saldo Inicial:</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="saldoCargo" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
											<button class="btn btn-xs btn-info " id="guardar" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando" value="2" style="margin-top:10px;"> Guardar </button>
										</div>
									</div>

									<div class="well" id="cuentaCargoAbono" style="display:none">
										<div>
											<h4><span><i class="fa fa-exchange"></i></span> Cuenta de Cargo y Abono</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Selecciona un banco</label>
											<label class="col-xs-4 control-label">Numero de cuenta bancaria: </label>
											<label class="col-xs-4 control-label">Numero de cuenta contable:</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<select name="bancoCA" id="bancoCA" class="form-control m-bot15">
													<option value="0">Banco</option>
													<?php 
													$result = $MRDB->SP("CALL `redefectiva`.`SP_LOAD_BANCOS`();") or die(mysql_error());
													while($row = mysqli_fetch_array($result)){
														$id = $row["idBanco"];
														$nombre = utf8_encode($row["nombreBanco"]);
														echo '<option value='.$id.'>'.$nombre.'</option>';                    
													} 
													mysqli_free_result($result);
													?>
												</select>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="cuentaBancariaCA" class='form-control m-bot15'">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="cuentaContableCA" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Saldo Inicial:</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="saldoCA" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
											<button class="btn btn-xs btn-info " id="guardar" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando" value="3" style="margin-top:10px;"> Guardar </button>
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
		<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
		<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
		<!--Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/altaBanco.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
		<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		</script>
	</body>
	<style type="text/css">
		.prueba{
			width:100%!important;
		}

		#movimientosBanco td{
			width: 30% !important;
		}

		#E td{
			width: 24% !important;
		}

		.dataTables_filter{
			text-align: right!important;
			width: 40% !important;
			padding-right: 0!important;
		}
	</style>
	</html>
