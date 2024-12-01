<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Cliente";

$tipoDePagina = "mixto";
$idOpcion = 126;

if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
}

$hoy = date("Y-m-d");

function acentos($word){
	return (!preg_match('!!u', $word))? utf8_encode($word) : $word;
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
	<title>.::Mi Red::.Afiliacion de Proveedores</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
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
								<span><i class="fa fa-user"></i></span>
								<h3>Datos del Proveedor</h3><span class="rev-combo pull-right">Afiliacion <br>de Proveedor</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<div style="margin-bottom:30px;">
											<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Nombre Comercial: </label>
											<label class="col-xs-4 control-label">Razón Social: </label>
											<label class="col-xs-4 control-label">RFC: </label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="nombreComercial" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="razonSocial" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="rfc" class='form-control m-bot15' maxlength="12" onkeyup="RFCFormato();" onkeypress="RFCFormato();">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Beneficiario: </label>
											<label class="col-xs-4 control-label">Teléfono: </label>
											<label class="col-xs-4 control-label">Correo: </label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="beneficiario" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="telefono" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="correo" class='form-control m-bot15'>
											</div>
										</div>
										<div style="margin-top:200px;">
											<h4><span><i class="fa fa-building"></i></span> Dirección</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">País: </label>
											<label class="col-xs-4 control-label">Calle: </label>
											<label class="col-xs-4 control-label">Número Interior: </label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="hidden" class="form-control m-bot15" name="idPais" id="idPais" value="164">
												<input type="text" class="form-control m-bot15" name="txtPais" id="txtPais" value="Mexico">
											</div>
											<div class="form-group col-xs-4	">
												<input type="text" class="form-control m-bot15" name="calleDireccion" id="txtCalle">
											</div>
											<div class="form-group col-xs-4	">
													<input type="text" id="int" class="form-control m-bot15" name="numeroIntDireccion">	
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Número Exterior: </label>
											<label class="col-xs-4 control-label">Código Postal: </label>
											<label class="col-xs-4 control-label">Colonia: </label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" class="form-control m-bot15" id="ext" name="numeroExtDireccion">	
											</div>
											<div class="form-group col-xs-4">
												<input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCP">
											</div>
											<div class="form-group col-xs-4">
												<select class="form-control m-bot15" name="idcColonia" id="cmbColonia">
													<option value="-1">Seleccione</option>
												</select>
											</div>
											</div>
											<div class="form-group col-xs-12">
												<label class="col-xs-4 control-label">Ciudad: </label>
												<label class="col-xs-4 	control-label">Estado: </label>
											</div>
											<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<select class="form-control m-bot15" name="idcMunicipio" id="cmbMunicipio">
													<option value="-1">Seleccione</option>
												</select>
											</div>
											<div class="form-group col-xs-4">
												<select class="form-control m-bot15" name="idcEntidad" id="cmbEstado">
													<option value="-1">Seleccione</option>
												</select>
											</div>
										</div>
										</div>
									<div class="well">
										<div>
											<h4><span><i class="fa fa-gear"></i></span> Datos Operativos</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Comisión: </label>
											<label class="col-xs-4 control-label">Porcentaje de comisión: </label>
											<label class="col-xs-4 control-label">Dias Liquidación de Pagos: </label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="comision" class='form-control m-bot15' step="any"">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="porcentajeComision" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="liquidacionPagos" class='form-control m-bot15'>
											</div>
										</div>
										<div class="from-group col-xs-12">
										<label class="col-xs-4 control-label">Dias de liquidación de comisiones: </label>
										<label class="col-xs-4 control-label">Retención de Comisiones: </label>		
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="pagoComisiones" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<select class="form-control m-bot15" name="retencion" id="retencion">
													<option value="-1">Seleccione</option>
													<option value="0">Sin Retención</option>
													<option value="1">Con Retención</option>
												</select>
											</div>
										</div>
										<div style="margin-top:200px;">
											<h4><span><i class="fa fa-desktop"></i></span> Datos de Conexion</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Host: </label>
											<label class="col-xs-4 control-label">Puerto: </label>
											<label class="col-xs-4 control-label">Usuario: </label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="host" class='form-control m-bot15' step="any"">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="port" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="user" class='form-control m-bot15'>
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Password: </label>
											<label class="col-xs-4 control-label">Path de folder remoto: </label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="password" class='form-control m-bot15' step="any"">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="remoteFolder" class='form-control m-bot15'>
											</div>
										</div>
									</div>
									<div class="well">
										<div>
											<h4><span><i class="fa fa-credit-card"></i></span> Datos Bancarios</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">CLABE Interbancaria para depósito de pagos: </label>
											<label class="col-xs-4 control-label">Banco</label>
											<label class="col-xs-4 control-label">Ingresa una referencia numérica</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="clabe" class='form-control m-bot15' onkeyup="analizarCLABE();" onkeypress="analizarCLABE();">
											</div>
											<div class="form-group col-xs-4">
											<input type="hidden" name="idBanco" id="idBanco"/>
											<input type="text" id="txtBanco" name="txtBanco" class='form-control m-bot15' maxlength="18" disabled>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="referencia" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Ingresa una referencia alfanumérica</label>
											<label class="col-xs-4 control-label" id="labelMetodo" style="display:none">Selecciona el método de pago</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" name="referenciaAlfa" id="referenciaAlfa" class='form-control m-bot15' maxlength="18">
											</div>
											<div class="form-group col-xs-4" id="selectMetodo" style="display:none">
												<select class="form-control m-bot15" name="opcionMetodo" id="opcionMetodo">
													<option value="-1">Seleccione</option>
												</select>
											</div>
										</div>
										<div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
											<button class="btn btn-xs btn-info " id="guardarP" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;"> Guardar </button>
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
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/Afiliacion/afiliacion.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
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
