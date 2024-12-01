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
					<h3>Actualización de Cliente</h3>
					<span class="rev-combo pull-right">Afiliación<br>Express</span>
				</div>
				<div class="panel-body">
					<form name="capturacliente" id="frmCapturaCliente">
						<div class="row" id="first-row-cliente">
							<div class="col-xs-3">
								<div class="form-group">
									<label>Cliente</label>
									<input type="text" class="form-control" name="sNombreSubCadena" id="txtSNombreSubCadena"/>
									<input type="hidden" class="" name="nIdSubCadena" id="txtNIdSubCadena"/>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<label>Versión</label>
									<select class="form-control" name="nIdVersion" id="cmbVersion">
										<option>--</option>
									</select>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<label>Regimen Fiscal</label>
									<select class="form-control" name="nIdRegimen" id="cmbRegimen">
										<option value="0">--</option>
										<option value="1">Físico</option>
										<option value="2">Moral</option>
									</select>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<label>No. Cuenta Forelo</label>
									<input type="text" class="form-control" name="nNumCuentaForelo" id="txtNNumCuentaForelo" readonly="" />
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-xs-3">
								<div class="form-group">
									<label>Teléfono</label>
									<input type="text" class="form-control" name="sTelefono" id="txtSTelefono" maxlength="15" />
								</div>
							</div>
							<div class="col-xs-7">
								<div class="form-group">
									<label>Correo Electrónico</label>
									<input type="text" class="form-control" name="sEmail" id="txtSEmail" maxlength="150" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-3">
								<div class="form-group">
									<label>Tipo de Reembolso</label><br/>
									<label style="margin-right: 5px;"><input type="radio" name="nIdTipoReembolso" value="1"/>Corte</label>
									<label><input type="radio" name="nIdTipoReembolso" value="2"/>Integro</label>
								</div>
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<label>Tipo de Comisi&oacute;n</label><br/>
									<label style="margin-right: 5px;"><input type="radio" name="nIdTipoComision" value="1"/>Con IVA</label>&nbsp;
									<label><input type="radio" name="nIdTipoComision" value="2"/>Sin IVA</label>
								</div>
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<label>Pago de Reembolso</label><br/>
									<label style="margin-right: 5px;"><input type="radio" name="nIdTipoLiquidacionReembolso" value="1"/>Forelo</label>&nbsp;
									<label><input type="radio" name="nIdTipoLiquidacionReembolso" value="2"/>Banco</label>
								</div>
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<label>Pago de Comisi&oacute;n</label><br/>
									<label style="margin-right: 5px;"><input type="radio" name="nIdTipoLiquidacionComision" value="1"/>Forelo</label>&nbsp;
									<label><input type="radio" name="nIdTipoLiquidacionComision" value="2"/>Banco</label>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-3">
								<div class="form-group">
									<label class="control-label">Tipo de Movimiento:</label>
									<select id="ddlTipoMovimiento" class="form-control" name="nIdTipoMovimiento">
										<option value="0">Pago</option>
									</select>
								</div>
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<label class="control-label">Tipo de Instrucción:</label>
									<select id="ddlInstruccion" class="form-control" name="nIdTipoInstruccion">
										<option value="-1">Todos</option>
									</select>
								</div>
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<label class=" control-label">Destino:</label>
									<div class="">
										<select id="ddlDestino"  class="form-control" name="nIdDestino">
											<option value="-1">Seleccione</option>
											<option value="1">Forelo</option>
											<option value="2">Banco</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-3">
								<div class="form-group">
									<label>CLABE</label>
									<input type="text" name="nClabe" id="txtNCLABE" maxlength="18" class="form-control" />
								</div>
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<label>Banco</label>
									<input type="hidden" name="nIdBanco" id="txtNIdBanco"/>
									<input type="text" name="sNombreBanco" id="txtSNombreBanco" maxlength="18" class="form-control" readonly="" />
								</div>
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<label>Cuenta</label>
									<input type="text" name="nNumCuenta" id="txtNNumCuenta" maxlength="11" class="form-control" readonly="" />
								</div>
							</div>

							<div class="col-xs-3">
								<div class="form-group">
									<label>Beneficiario</label>
									<input type="text" name="sNombreBeneficiario" id="txtSNombreBeneficiario" maxlength="35" class="form-control" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-3">
								<div class="form-group">
									<label>RFC</label>
									<input type="text" name="sRfcBen" maxlength="18" class="form-control" id="txtSRFCBen"/>
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Correo</label>
									<input type="text" name="sCorreoBen" maxlength="120" class="form-control" id="txtSCorreo"/>
								</div>
							</div>

							<?php
								if($esEscritura){
							?>
							<div class="col-xs-3">
								<button id="btnActualizarCliente" type="button" class="btn btn-sm btn-default pull-right" style="margin-top:20px;">Actualizar</button>
							</div>
							<?php
							}
							?>
						</div>

						<!--<div class="row">
							<div class="col-xs-3">
								<label>Tipo de Reembolso</label>
								1 Corte
								2 In
							</div>
						</div>-->
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
<script src="../../inc/js/common-custom-scripts.js"></script>
<script src="../../inc/js/_Autorizar.js"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../css/ui/jquery.ui.core.js"></script>
<script src="../../css/ui/jquery.ui.widget.js"></script>
<script src="../../css/ui/jquery.ui.position.js"></script>
<script src="../../css/ui/jquery.ui.menu.js"></script>
<script src="../../css/ui/jquery.ui.autocomplete.js"></script>
<script src="../../inc/js/Correcciones/clientes.js"></script>
<script src="../../inc/input-mask/input-mask.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(':input').unbind('paste');
	});
</script>
<!--Cierre del Sitio-->
</body>
</html>