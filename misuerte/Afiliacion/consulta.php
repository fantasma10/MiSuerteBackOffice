<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Afiliacion";
$subsubmenuTitulo	= "Lista de Clientes";

$tipoDePagina = "mixto";
$idOpcion = 155;
setlocale(LC_TIME, 'spanish');  
$mesSiguiente = date('m', strtotime('+1 month')); 
$mesSiguiente=strftime("%B",mktime(0, 0, 0, $mesSiguiente, 1, 2000));

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
	<title>.::Mi Red::.Consulta de Clientes</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
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
								<span><i class="fa fa-search"></i></span>
								<h3>Consulta de Clientes</h3><span class="rev-combo pull-right">Lista<br>de clientes</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<form class="form-horizontal" id="formFiltros">	
											<div class="form-group col-xs-12" style="margin-bottom:30px;">
												<div class="form-group col-xs-6" style="text-align:right;padding-right:10px;">

													<div class="btn-group" data-toggle="buttons">			
														<label class="btn boton btn-default active" id="proveedor">Proveedor
															<input type="radio" name="proveedor" id="proveedor">
															<span class="fa fa-check"></span>
														</label>
													</div>
												</div>
												<div class="form-group col-xs-6" style="padding-left:40px;">										
													<div class="btn-group" data-toggle="buttons">			
														<label class="btn boton btn-primary" id="cliente">Cliente
															<input type="radio" name="cliente" id="cliente">
															<span class="fa fa-check"></span>
														</label>
													</div>
												</div>
											</div>
										</form>
										<div class="form-group col-xs-12" id="tablaProveedores" style="display: inline;">
											<div id="gridbox" class="adv-table table-responsive">
												<table id="ordertablaE" class="display table table-bordered table-striped" style="display:inline-table;">
													<thead>
														<tr>
															<th>Proveedor</th>
															<th>Retención de comisiones</th>
															<th>Dias de liquidación</th>
															<th>Comisión</th>
															<th>Porcentaje de Comisión</th>
															<th>Acciones</th>
														</tr>	
													</thead>
													<tbody id="E">													
													</tbody>
												</table>
											</div>
										</div>	
										<div class="form-group col-xs-12" id="tablaReceptores" style="display: none">
											<div id="gridbox" class="adv-table table-responsive">
												<table id="ordertablaR" class="display table table-bordered table-striped" style=" width: 100%; display:none;">
													<thead>
														<tr>
															<th>Cliente</th>													
															<th>Retención de comisiones</th>
															<th>Días de liquidación</th>
															<th>Comisión</th>
															<th>Porcentaje de Comisión</th>
															<th>Acciones</th>
														</tr>
													</thead>	
													<tbody id="R">

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--Informacion del emisor seleccionado -->
							<div class="panel" id="proveedorInfo" style="display: none">
								<div class="panel-body">
									<div class="well">
										<div style="margin-bottom:30px;">
											<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
										</div>
										<div class="form-group col-xs-12" style="text-align: right" id="edicion">
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Nombre Comercial: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="nombreComercial" class='form-control m-bot15 lectura'>
												<input type="hidden" id="proveedorId" class='form-control m-bot15'>
												<input type="hidden" id="estatusEmisor" class='form-control m-bot15'>
											</div>
											<label class="col-xs-1 control-label">Razón Social: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="razonSocial" class='form-control m-bot15 lectura' readonly="">
											</div>
											<label class="col-xs-1 control-label">RFC: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="rfc" class='form-control m-bot15 lectura' maxlength="12" onkeyup="RFCFormato();" onkeypress="RFCFormato();" readonly="">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Contacto: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="beneficiario" class='form-control m-bot15'>		
											</div>
											<label class="col-xs-1 control-label">Teléfono: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="telefono" class='form-control m-bot15'>
											</div>
											<label class="col-xs-1 control-label">Correo: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="correo" class='form-control m-bot15'>
											</div>
										</div>
										<div style="margin-top:150px;">
											<h4><span><i class="fa fa-building"></i></span> Dirección</h4>
										</div>
										<div class="form-group col-xs-12">
											<input type="hidden" name="idDireccion" id="idDireccion" value="0">
											<input type="hidden" name="origen" id="origen" value="0" />
											<label class="col-xs-1 control-label">País: </label>
											<div class="form-group col-xs-3">
												<input type="hidden" class="form-control m-bot15" name="idPais" id="idPais" value="164">
												<input type="text" class="form-control m-bot15 lectura" name="txtPais" id="txtPais" value="Mexico" readonly="">
											</div>
											<label class="col-xs-1 control-label">Calle: </label>
											<div class="form-group col-xs-3	">
												<input type="text" class="form-control m-bot15 lectura" name="calleDireccion" id="txtCalle" readonly="">
											</div>
											<label class="col-xs-1 control-label">Número Interior: </label>
											<div class="form-group col-xs-3	">
												<input type="text" id="int" class="form-control m-bot15 lectura" name="numeroIntDireccion" readonly="">	
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Número Exterior: </label>
											<div class="form-group col-xs-3	">
												<input type="text" class="form-control m-bot15 lectura" id="ext" name="numeroExtDireccion" readonly="">	
											</div>
											<label class="col-xs-1 control-label">Código Postal: </label>
											<div class="form-group col-xs-3	">
												<input type="text" class="form-control m-bot15 lectura" name="cpDireccion" id="txtCP" readonly="">
												<input type="hidden" class="form-control m-bot15" name="idLocalidad" id="idLocalidad">
											</div>
											<label class="col-xs-1 control-label">Colonia: </label>
											<div class="form-group col-xs-3	">
												<input type="text" class="form-control m-bot15 lectura" id="cmbColonia" readonly="">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Ciudad: </label>
											<div class="form-group col-xs-3	">
												<input type="text" class="form-control m-bot15 lectura" id="cmbMunicipio" readonly="">
											</div>
											<label class="col-xs-1 control-label">Estado: </label>
											<div class="form-group col-xs-3	">
												<input class="form-control m-bot15 lectura" name="idcEntidad" id="cmbEstado" readonly="">
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
												<input type="text" id="perComision" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="liquidacion" class='form-control m-bot15'>
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
													<option value="0">Sin Retención</option>
													<option value="1">Con Retención</option>
												</select>
											</div>
										</div>
										<div style="margin-top:150px;">
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
											<label class="col-xs-4 control-label">Referencia numérica</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="clabe" class='form-control m-bot15' onkeyup="analizarCLABE();" onkeypress="analizarCLABE();">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="nombreBanco" name="nombreBanco" class='form-control m-bot15 lectura' maxlength="18" readonly="">
												<input type="hidden" name="banco" id="banco" />
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="referencia" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Referencia alfanumérica</label>
											<label class="col-xs-4 control-label">Cuenta contable</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" name="referenciaAlfa" id="referenciaAlfa" class='form-control m-bot15' maxlength="18">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" name="cuentaContable" id="cuentaContable" class='form-control m-bot15 lectura' maxlength="15" readonly="">
											</div>
										</div>
										<div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
											<button class="btn btn-xs btn-info " id="actualizarProveedor" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;"> Actualizar </button>
										</div>
									</div>

								</div>
							</div>
							<!--Informacion del receptor seleccionado -->
							<div class="panel" id="clienteInfo" style="display: none;">
								<div class="panel-body">
									<div class="well">
										<div style="margin-bottom:30px;">
											<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
										</div>
										<div class="form-group col-xs-12" style="text-align: right" id="edicionCadena">
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Nombre Comercial: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="nombreComercialCadena" class='form-control m-bot15 lectura' readonly="">
												<input type="hidden" id="clienteId" class='form-control m-bot15'>
												<input type="hidden" id="estatusCadena" class='form-control m-bot15'>
											</div>
											<label class="col-xs-1 control-label">Razón Social: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="razonSocialCadena" class='form-control m-bot15 lectura' readonly="">
											</div>
											<label class="col-xs-1 control-label">RFC: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="rfcCadena" class='form-control m-bot15 lectura' maxlength="12" onkeyup="RFCFormato();" onkeypress="RFCFormato();" readonly="">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Contacto: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="beneficiarioCadena" class='form-control m-bot15'>		
											</div>
											<label class="col-xs-1 control-label">Teléfono: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="telefonoCadena" class='form-control m-bot15'>
											</div>
											<label class="col-xs-1 control-label">Correo: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="correoCadena" class='form-control m-bot15'>
											</div>
										</div>
										<div style="margin-top:150px;">
											<h4><span><i class="fa fa-building"></i></span> Dirección</h4>
										</div>
										<div class="form-group col-xs-12">
											<input type="hidden" name="idDireccion" id="idDireccion" value="0">
											<input type="hidden" name="origen" id="origen" value="0" />
											<label class="col-xs-1 control-label">País: </label>
											<div class="form-group col-xs-3">
												<input type="hidden" class="form-control m-bot15" name="idPais" id="idPais" value="164">
												<input type="text" class="form-control m-bot15 lectura" name="txtPais" id="txtPais" value="Mexico" readonly="">
											</div>
											<label class="col-xs-1 control-label">Calle: </label>
											<div class="form-group col-xs-3	">
												<input type="text" class="form-control m-bot15 lectura" name="calleDireccion" id="txtCalleCadena" readonly="">
											</div>
											<label class="col-xs-1 control-label">Número Interior: </label>
											<div class="form-group col-xs-3	">
												<input type="text" id="intCadena" class="form-control m-bot15 lectura" name="numeroIntDireccion" readonly="">	
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Número Exterior: </label>
											<div class="form-group col-xs-3	">
												<input type="text" class="form-control m-bot15 lectura" id="extCadena" name="numeroExtDireccion" readonly="">	
											</div>
											<label class="col-xs-1 control-label">Código Postal: </label>
											<div class="form-group col-xs-3	">
												<input type="text" class="form-control m-bot15 lectura" name="cpDireccion" id="txtCPCadena" readonly="">
												<input type="hidden" class="form-control m-bot15" name="idLocalidad" id="idLocalidad">
											</div>
											<label class="col-xs-1 control-label">Colonia: </label>
											<div class="form-group col-xs-3	">
												<input class="form-control m-bot15 lectura" name="idcColonia" id="cmbColoniaCadena" readonly="">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Ciudad: </label>
											<div class="form-group col-xs-3	">
												<input class="form-control m-bot15 lectura" name="idcMunicipio" id="cmbMunicipioCadena" readonly="">
											</div>
											<label class="col-xs-1 control-label">Estado: </label>
											<div class="form-group col-xs-3	">
												<input class="form-control m-bot15 lectura" name="idcEntidad" id="cmbEstadoCadena" readonly="">
											</div>
										</div>
									</div>
									<div class="well">
										<div>
											<h4><span><i class="fa fa-gear"></i></span> Datos Operativos</h4>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-1 control-label">Comisión: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="comisionCadena" value="0" class='form-control m-bot15' step="any"">
											</div>
											<label class="col-xs-1 control-label">Porcentaje de comisión: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="perComisionCadena" value="0" class='form-control m-bot15'>
											</div>
											<label class="col-xs-1 control-label">Dias Liquidación: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="liquidacionCadena" value="0" class='form-control m-bot15'>
											</div>
										</div>
										<div class="form-group col-xs-12">
										<label class="col-xs-1 control-label">Dias de liquidacion comisiones: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="liquidacionComisiones" value="0" class='form-control m-bot15' step="any"">
											</div>
											<label class="col-xs-1 control-label">Numero de Socio: </label>
											<div class="form-group col-xs-3">
												<input type="text" id="numSocio" value="0" class='form-control m-bot15'>
											</div>
											<label class="col-xs-1 control-label">Retención de Comisiones: </label>
											<div class="form-group col-xs-3">
												<select class="form-control m-bot15" name="retencionCadena" id="retencionCadena">
													<option value="0">Sin Retención</option>
													<option value="1">Con Retención</option>
												</select>
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
											<label class="col-xs-4 control-label">Referencia numérica</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="clabeCadena" class='form-control m-bot15' onkeyup="analizarCLABE1();" onkeypress="analizarCLABE1();">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="nombreBancoCliente" name="nombreBancoCliente" class='form-control m-bot15 lectura' maxlength="18" readonly="">
												<input type="hidden" name="banco" id="bancoCliente" />
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="referenciaCadena" class='form-control m-bot15' maxlength="18">
											</div>
										</div>
										<div class="form-group col-xs-12">
											<label class="col-xs-4 control-label">Referencia alfanumérica</label>
											<label class="col-xs-4 control-label">Cuenta Contable</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" name="referenciaAlfaCadena" id="referenciaAlfaCadena" class='form-control m-bot15' maxlength="18">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" name="cuentaContableCadena" id="cuentaContableCadena" class='form-control m-bot15 lectura' maxlength="15" readonly="">
											</div>
										</div>
										<div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
											<button class="btn btn-xs btn-info " id="actualizarCliente" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;"> Actualizar </button>
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

	<div id="confirmacion" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modificar Estatus Emisor</h4>
					</div>
					<div class="modal-body">
					<p></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="borrarEmisor">Aceptar</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					</div>
				</div>

			</div>
		</div>

		<div id="confirmacionCadena" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modificar Estatus Cadena</h4>
					</div>
					<div class="modal-body">
					<p></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="borrarCadena">Aceptar</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					</div>
				</div>

			</div>
		</div>


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
	<script src="<?php echo $PATHRAIZ;?>/misuerte/js/Afiliacion/consulta.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
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

	#td{
		width: 30% !important;
	}

	#inputs{
		text-align: center;
	}

	.dataTables_filter{
		text-align: right!important;
		width: 40% !important;
		padding-right: 0!important;
	}

	.well ul li {
		padding: 0 !important;
		font-size: 11px !important;
	}


	.boton span.fa-check {    			
		opacity: 0;				
	}
	.boton.active span.fa-check {				
		opacity: 1;				
	}

	#emisor{
		background-color: #0275d8!important;
		border-color: #0275d8!important;
	}


	.inhabilitar{
		background-color: #d9534f!important;
		border-color: #d9534f!important;
		margin-left: 10px;
	}

	.habilitar{
		margin-left: 10px;
	}

	.lectura{
		 background: rgb(238, 238, 238); color: rgb(128, 128, 128);
	}
</style>
</html>
