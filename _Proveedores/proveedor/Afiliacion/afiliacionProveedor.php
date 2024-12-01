<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
include($PATH_PRINCIPAL . "/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL . "/_Proveedores/proveedor/ajax/Cat_familias.php");
$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];
$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Proveedor";
$tipoDePagina = "mixto";
$idOpcion = 205;
$parametro_proveedor = $_POST["txtidProveedor"];
if (!desplegarPagina($idOpcion, $tipoDePagina)) {
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
	$esEscritura = true;
}
$hoy = date("Y-m-d");
function acentos($word)
{
	return (!preg_match('!!u', $word)) ? utf8_encode($word) : $word;
}
$idemisores =  (isset($_POST['txtidemisor'])) ? $_POST['txtidemisor'] : 0;

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Favicon-->
	<link rel="shortcut icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
	<title>.::Mi Red::.Afiliacion de Proveedor</title>
	<!-- Núcleo BOOTSTRAP -->
	<!-- <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet"> -->
	<!--<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap3.min.css" rel="stylesheet">-->
	<link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap3.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
	<!--<link href="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />-->
	<link href="<?php echo $PATHRAIZ; ?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<!-- Autocomplete -->
	<link href="<?php echo $PATHRAIZ; ?>/css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">
	<style type="text/css">
		.inhabilitar {
			background-color: #d9534f !important;
			border-color: #d9534f !important;
			margin-left: 10px;
			color: #FFFFFF;
		}

		.disabledbutton {
			pointer-events: none;
			opacity: 0.4;
		}

		.form-group.error input,
		.form-group.error select {
			border-color: #dc3545;
		}

		.form-group.success input,
		.form-group.success select {
			/* border-color: #28a745; */
			border-color: #cdcfd1;
		}

		.form-group small {
			color: #dc3545;
		}
	</style>
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include($PATH_PRINCIPAL . "/inc/cabecera2.php"); ?>
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include($PATH_PRINCIPAL . "/inc/menu.php"); ?>
<!--Final del Menú Vertical-->
<!--Contenido Principal del Sitio-->


<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-lg-12">
				<div class="panelrgb">
					<div class="titulorgb-prealta">
						<span><i class="fa fa-user"></i></span>
						<h3>Proveedor <em id="proveedor-nombre"></em></h3>
						<span class="rev-combo pull-right">Afiliación <br>de Proveedor</span>
					</div>
					<div class="panel">

						<div class="wizard">
							<div class="wizard-inner">
								<div class="connecting-line"></div>
								<ul class="nav nav-tabs" role="tablist">

									<li role="presentation" class="active">
										<a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Definicion Proveedor">
											<span class="round-tab">
												<i class="glyphicon glyphicon-folder-open"></i> Información
											</span>
										</a>
									</li>

									<li id="li_paso2" role="presentation" class="disabled" onclick="revision('repr-datos')">
										<a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Representante Legal y Datos Bancarios">
											<span class="round-tab">
												<i class="glyphicon glyphicon-picture"></i> Repr. Legal y Bancarios
											</span>
										</a>
									</li>

									<li id="li_paso3" role="presentation" class="disabled" onclick="revision('documentos')">
										<a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Documentos">
											<span class="round-tab">
												<i class="glyphicon glyphicon-picture"></i> Docs.
											</span>
										</a>
									</li>

									<li id="li_paso4" role="presentation" class="disabled" onclick="revision('liquidacion')">
										<a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Liquidacion">
											<span class="round-tab">
												<i class="glyphicon glyphicon-picture"></i> Liquidacion
											</span>
										</a>
									</li>

									<li id="li_paso5" role="presentation" class="disabled" onclick="revision('facturacion')">
										<a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Datos Facturacion">
											<span class="round-tab">
												<i class="glyphicon glyphicon-picture"></i> Datos Fact.
											</span>
										</a>
									</li>

									<!--	
                    <li id="li_paso6" role="presentation" class="disabled">
                        <a href="#step6" data-toggle="tab" aria-controls="step6" role="tab" title="Ctas. Cntbles">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-picture"></i> Ctas Contables
                            </span>
                        </a>
                    </li>
					-->

									<li id="li_paso7" role="presentation" class="disabled" onclick="revision('matriz-escalamiento')">
										<a href="#step7" data-toggle="tab" aria-controls="step7" role="tab" title="Matriz Escalamiento">
											<span class="round-tab">
												<i class="glyphicon glyphicon-picture"></i> Matriz Escalamiento
											</span>
										</a>
									</li>


									<?php if (in_array($usuario_logueado, $usuarios_afiliacion_proveedores['usuarios_mesa_control'])) { ?>
										<li id="verificar" role="presentation" class="disabled">
											<a href="#" data-toggle="tab" aria-controls="complete" role="tab" title="Autorizar">
												<span class="round-tab">
													<i class="glyphicon glyphicon-ok"></i>
												</span>
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>

							<!-- <form role="form"> -->
							<div class="tab-content">
								<input type="hidden" id="p_proveedor" name="p_proveedor" value='<?php echo $parametro_proveedor; ?>'>
								<input type="hidden" name="tipoProceso" id="tipoProceso" />
								<div class="tab-pane active" role="tabpanel" id="step1">
									<div id="step1-processing" style="text-align: center;">
										<img src="../../../img/cargando3.gif">
									</div>
									<div id="step1-informacion" style="display: none;">
										<div class="form-group col-xs-12">
											<button class="btn btn-xs btn-info btnback" style="margin-top:20px;">Regresar</button>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-5">
												<label class="control-label" for="solicitante">Solicitante: </label>
												<select class="form-control m-bot15" name="solicitante" id="cmbSolicitante">
													<option value="-1">Seleccione</option>
												</select>
												<small></small>
											</div>
										</div>
										<div class="form-group col-lg-12">
											<h4><span><i class="fa fa-file-text"></i></span> Definicion de Tipo Proveedor</h4>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-2">
												<label class=" control-label"><input type="radio" onclick="validarProveedor();" name="ctetipo" id="ctetipo" value="0" /> Proveedor</label>
											</div>
											<div class="form-group col-xs-2">
												<label class=" control-label"><input type="radio" onclick="validarProveedor();" name="ctetipo" id="ctetipo3" value="1" /> Integrador</label>
											</div>
											<small id="error-proveedor" class="col-xs-12"></small>
										</div>
										<div class="form-group col-xs-12" id="div_tipos">
											<div class="form-group col-xs-4">
												<label class=" control-label">
													<input type="radio" name="tipo" onclick="enviarTipo();" id="radio_venta_servicios" value="0"> Cobro de Servicios
												</label>
											</div>
											<div class="form-group col-xs-4">
												<label class=" control-label">
													<input type="radio" name="tipo" onclick="enviarTipo();" id="radio_recarga" value="1"> Compra de Tiempo Aire
												</label>
											</div>
											<div class="form-group col-xs-4">
												<label class=" control-label">
													<input type="radio" name="tipo" id="radio_servicio_recarga" value="2" onclick="enviarTipo();"> Cobro de Servicios y Compra de Tiempo Aire
												</label>
											</div>
											<small id="error-tipo" class="col-xs-12"></small>
										</div>

										<div class="form-group col-lg-12">
											<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
										</div>

										<div class="form-group col-xs-12">
											<div class="form-group col-xs-3" id="div-rfc">
												<label class="control-label">RFC: </label>
												<input type="text" id="rfc" class='form-control m-bot15' maxlength="12" onkeyup="RFCFormato();" onkeypress="RFCFormato();" onblur="RFCFormato(this.value);">
												<small></small>
											</div>
											<div class="form-group col-xs-3">
												<label class="control-label">Razón Social: </label>
												<input type="text" id="razonSocial" class='form-control m-bot15' style="text-transform: uppercase;" onkeyup="Clonar()">
												<small></small>
											</div>
											<div class="form-group col-xs-6">
												<label class="control-label">Régimen Societario: </label>
												<input type="text" id="regimenSocietario" class='form-control m-bot15' onkeyup="Clonar()">
												<small></small>
											</div>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-3">
												<label class="control-label">Nombre Comercial: </label>
												<input type="text" id="nombreComercial" class='form-control m-bot15' style="text-transform: uppercase;">
												<small></small>
											</div>
											<div class="form-group col-xs-3">
												<label class="control-label">Pais: </label>
												<select class="form-control m-bot15" name="cmbpais" id="cmbpais">
													<option value="-1">Seleccione</option>
													<?php echo $htmlPais; ?>
												</select>
												<small></small>
											</div>
											<div class="form-group col-xs-3">
												<label for="fechaConstitutiva" class="control-label">Fecha Constitutiva</label>
												<input class="datepicker form-control" id="fecha-constitutiva" name="fechaConstitutiva">
												<small></small>
											</div>
											<div class="form-group col-xs-6">
												<label>Regimen Fiscal:</label>
												<select class="form-control" id="cmbRegimenFiscal"></select>
												<small></small>
											</div>
											<div class="form-group col-xs-6">
												<label>Giro:</label>
												<select class="form-control" id="cmbGiro"></select>
												<small></small>
											</div>
										</div>
										<div class="form-group col-xs-12">
											<h4><span><i class="fa fa-map-marker"></i></span> Dirección</h4>
										</div>
										<div class="form-group col-xs-12">
											<input type="hidden" name="idDireccion" id="idDireccion" value="0">
											<input type="hidden" name="origen" id="origen" value="0" />
											<div class="form-group col-xs-6">
												<label class=" control-label">Calle: </label>
												<input type="text" class="form-control m-bot15" name="calleDireccion" id="txtCalle" style="text-transform: uppercase;">
												<small></small>
											</div>
											<div class="form-group col-xs-2">
												<label class=" control-label">Número Exterior: </label>
												<input type="text" class="form-control m-bot15" id="ext" name="numeroExtDireccion" style="text-transform: uppercase;">
												<small></small>
											</div>
											<div class="form-group col-xs-2">
												<label class=" control-label">Número Interior: </label>
												<input type="text" id="int" class="form-control m-bot15" name="numeroIntDireccion" style="text-transform: uppercase;">
												<small></small>
											</div>
											<div class="form-group col-xs-2">
												<label class=" control-label">Código Postal: </label>
												<input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCP">
												<small></small>
											</div>
										</div>
										<div class="form-group col-xs-12" id="divDirext" style="display:none">
											<div class="form-group col-xs-4	">
												<label class=" control-label">Colonia: </label>
												<input type="text" class="form-control m-bot15" name="cpDireccion" id="txtColonia" style="text-transform: uppercase;">
												<small></small>
											</div>
											<div class="form-group col-xs-4	">
												<label class=" control-label">Ciudad: </label>
												<input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCiudad" style="text-transform: uppercase;">
												<small></small>
											</div>
											<div class="form-group col-xs-4	">
												<label class=" control-label">Estado: </label>
												<input type="text" class="form-control m-bot15" name="cpDireccion" id="txtEstado" style="text-transform: uppercase;">
												<small></small>
											</div>
										</div>
										<div class="form-group col-xs-12" id="divDirnac">
											<div class="form-group col-xs-4">
												<label class=" control-label">Colonia: </label>
												<select class="form-control m-bot15" name="idcColonia" id="cmbColonia">
													<option value="-1">Seleccione</option>
												</select>
												<small></small>
											</div>
											<div class="form-group col-xs-4">
												<label class=" control-label">Ciudad: </label>
												<select class="form-control m-bot15" name="idcMunicipio" id="cmbCiudad">
													<option value="-1">Seleccione</option>
												</select>
												<small></small>
											</div>
											<div class="form-group col-xs-4">
												<label class=" control-label">Estado: </label>
												<select class="form-control m-bot15" name="idcEntidad" id="cmbEntidad">
													<option value="-1">Seleccione</option>
												</select>
												<small></small>
											</div>
										</div>
										<div class="form-group col-xs-12">
											<button id="btn-informacion" type="button" class="btn btn-primary pull-right" style="margin-right:1.1em">Guardar</button>
										</div>
									</div>
								</div>
								<div class="tab-pane" role="tabpanel" id="step2">
									<div class="form-group col-xs-12">
										<button class="btn btn-xs btn-info btnback" style="margin-top:20px;">Regresar</button>
									</div>
									<div class="form-group col-xs-8">
										<input type="hidden" id="usuario_logueado" name="usuario_logueado" value="<?php echo $usuario_logueado; ?>">
										<h4><span><i class="fa fa-asterisk"></i></span>Representante Legal</h4>
									</div>

									<div class="form-group col-xs-12">
										<div class="form-group col-xs-6">
											<label class=" control-label">Nombre: </label>
											<input type="text" class="form-control m-bot15" name="" id="representante_legal" style="text-transform: uppercase;">
											<input type="hidden" name="positionRepre" id="positionRepre">
											<input type="hidden" name="idRepre" id="idRepre">
											<small></small>
										</div>
										<div class="form-group col-xs-3">
											<label class="control-label">Identificación</label>
											<select class="form-control" id="cmbIdentificacion">
												<option value="-1">Seleccione</option>
												<option value="1">INE</option>
												<option value="2">Pasaporte</option>
												<option value="3">Licencia de Conducir</option>
											</select>
											<small></small>
										</div>
										<div class="form-group col-xs-3">
											<label class="control-label">No. Identificación</label>
											<input type="text" class="form-control" name="" id="numeroIdentificacion" style="text-transform: uppercase;">
											<small></small>
										</div>
										<div class="form-group col-xs-12" style="margin-top: 15px;">
											<button id="limpiar-representante-legal" type="button" class="btn btn-default pull-right" style="margin-right: 1.1em;" onclick="limpiarInputsRepresentanteLegal()">Limpiar</button>
											<button id="agregar-representante-legal" type="button" class="btn btn-primary pull-right" style="margin-right: 1.1em;" onclick="agregarRepresentanteLegal()">Agregar</button>
										</div>

										<div class="form-group col-xs-12" id="datos_representante_legal">
											<table id="tabla_representante_legal" class="display table table-bordered table-striped" style="width: 100%">
												<thead>
													<tr>
														<th>Representante</th>
														<th>Identificación</th>
														<th>No. Identificación</th>
														<!-- <th>CLABE Interbancaria</th>
														<th>Cuenta</th>
														<th>Beneficiario</th> -->
														<th>Acción</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>

										<div class="form-group col-xs-12">
											<button id="btn-repr-datos" type="button" class="btn btn-primary pull-right" style="margin-right: 1.1em;">Guardar</button>
										</div>
									</div>

									<div class="form-group col-xs-12" id="div_titulo_datos_bancarios_proveedor">
										<div>
											<h4><span><i class="fa fa-credit-card"></i></span> Datos Bancarios Proveedor</h4>
										</div>
										<!--
							<div class="form-check" id="divEntidadZona">
								<input type="checkbox" class="form-check-input" id="checkEntidad">
								<label class="form-check-label" for="checkEntidad">Por Entidad</label>
							</div>
							-->
									</div>

									<div class="form-group col-xs-8" id="datos_bancarios_proveedor_zona">
										<table class="table" id="tabla_clabes_zonas">
											<thead>
												<tr>
													<th>Zona</th>
													<th>CLABE Interbancaria</th>
													<th>Referencia</th>
													<th></th>
												</tr>
											</thead>
											<tr id="filaZona_0">
												<!-- <td><select class="form-control m-bot15" id="select_zonas_0"></select></td> -->

												<td><input type="text" id="nombreZona_0" class="form-control m-bot15" maxlength="18"></td>
												<td><input type="text" id="clabeXZona_0" class="form-control m-bot15" maxlength="18" onkeyup="analizarCLABEZona();" onkeypress="analizarCLABEZona();"></td>
												<td style="display: none;"><input type="text" id="bancoXZona_0" class="form-control m-bot15" maxlength="18"></td>
												<td><input type="text" id="referenciaZona_0" class="form-control m-bot15" maxlength="18"></td>
												<td><button id="row_0" class="add_button btn btn-sm btn-default" onclick="agregarFilaZona(this.id,'front');">
														<i class="fa fa-plus-circle" aria-hidden="true"></i>
													</button></td>
											</tr>
										</table>
									</div>

									<div class="form-group col-xs-12" id="datos_bancarios_proveedor">
										<div class="form-group col-xs-4">
											<label class="control-label">CLABE Interbancaria: </label>
											<input type="text" id="clabe" class='form-control m-bot15' onkeyup="analizarCLABE();" onkeypress="analizarCLABE();">
											<small></small>
										</div>
										<div class="form-group col-xs-4">
											<label class=" control-label">Banco</label>
											<input type="text" id="nombreBanco" class='form-control m-bot15' maxlength="18" disabled="">
											<input type="hidden" name="banco" id="banco" />
											<small></small>
										</div>
										<div class="form-group col-xs-4">
											<label class="control-label">Cuenta</label>
											<input type="text" name="cuentaBanco" id="cuentaBanco" class='form-control m-bot15' maxlength="18" style="text-transform: uppercase;">
											<small></small>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<div class="form-group col-xs-4">
											<label class="control-label">Referencia alfanumérica</label>
											<input type="text" name="referenciaAlfa" id="referenciaAlfa" class='form-control m-bot15' maxlength="18" style="text-transform: uppercase;">
											<input type="hidden" name="cuentaContable" id="cuentaContable" class='form-control m-bot15' maxlength="15">
											<small></small>
										</div>
										<div class="form-group col-xs-4">
											<label class="control-label">Beneficiario</label>
											<input type="text" name="beneficiario_DB" id="beneficiario_DB" class='form-control m-bot15' style="text-transform: uppercase;">
											<input type="hidden" name="nIdCuentaBanco" id="nIdCuentaBanco">
											<input type="hidden" name="positionBancos" id="positionBancos">
											<small></small>
										</div>
										<div class="form-group col-xs-4">
											<label class="control-label">Pais Pago</label>
											<select name="paisPago" id="paisPago" class="form-control m-bot15" onchange="validarPais(this.value)">
												<option value="-1">Seleccione</option>
												<?php echo $htmlPais; ?>
											</select>
										</div>
										<div id='camposBancoLatam' style="display: none;">
											<div class="form-group col-xs-4">
												<label class="control-label">Swift</label>
												<input type="text" id="swift" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<label class="control-label">ABA/IBAN</label>
												<input type="text" id="iban" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<label class="control-label">CODE</label>
												<input type="text" id="code" name="code" class="form-control m-bot15">
											</div>
										</div>
									</div>


									<div class="form-group col-xs-12" style="margin-top: 15px;">
										<button id="limpiar-datos-bancarios" type="button" class="btn btn-default pull-right" style="margin-right: 1.1em;" onclick="limpiarInputsDatosBancarios()">Limpiar</button>
										<button id="agregar-datos-bancarios" type="button" class="btn btn-primary pull-right" style="margin-right: 1.1em;" onclick="agregarDatosBancarios()">Agregar</button>
									</div>

									<div class="form-group col-xs-12" id="datos_bancarios">
										<table id="tabla_datos_bancarios" class="display table table-bordered table-striped" style="width: 100%">
											<thead>
												<tr>
													<th>CLABE Interbancaria</th>
													<th>Banco</th>
													<th>Cuenta</th>
													<th>Referencia alfanumérica</th>
													<th>Beneficiario</th>
													<th>Acción</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>

									<div class="form-group col-xs-12">

										<button id="btn-banco-datos" type="button" class="btn btn-primary pull-right" style="margin-right: 1.1em;">Guardar</button>
									</div>
								</div>
								<div class="tab-pane" role="tabpanel" id="step3">
									<div class="form-group col-xs-12">
										<button class="btn btn-xs btn-info btnback" style="margin-top:20px;">Regresar</button>
									</div>
									<div style="margin-bottom:30px;" class="form-group col-xs-5">
										<h4><span><i class="fa fa-gear"></i></span> Documentos</h4>
									</div>
									<div style="margin-top:10px;text-align:right;margin-left:5.5rem;color:#024182" class="form-group col-xs-6">
										<span><i class="fa fa-exclamation-circle"></i></span> El tamaño máximo de un archivo PDF es de 15 MB.
									</div>
									<div class="form-group col-xs-12">
										<div class="col-xs-4">
											<label>Acta Constitutiva: <sup>*</sup></label>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input type="file" accept="application/pdf" class="hidess" name="acta_constitutiva" id="acta_constitutiva" onchange="validarArchivoSeleccionado('acta_constitutiva')" idtipodoc="1">
												<input type="hidden" name="nIdDoc" id="txtNIdDoc" idtipodoc="1">
											</div>
										</div>
										<div class="col-xs-4" style="display: flex; justify-content: space-between;align-items: center;">
											<span id="file-urlActa" style='color:#024182'></span>
											<input type="hidden" id="urlActa">
											<input origen="emisor" type="button" id="file_Acta" value="Ver Comprobante" idtipodoc="1" onclick="verdocumento(this.id);" class="btnfiles">
										</div>
									</div>
									<div class="form-group col-xs-12" id="div_contrato">
										<div class="col-xs-4">
											<label>Contrato: <sup>*</sup></label>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input type="file" accept="application/pdf" class="hidess" name="contrato" id="contrato" onchange="validarArchivoSeleccionado('contrato')" idtipodoc="6">
												<input type="hidden" name="nIdDoc" id="txtNIdDoc" idtipodoc="6">
											</div>
										</div>
										<div class="col-xs-4" style="display: flex; justify-content: space-between;align-items: center;">
											<span id="file-urlContrato" style='color:#024182'></span>
											<input type="hidden" id="urlContrato">
											<input origen="emisor" type="button" id="file_Contrato" value="Ver Comprobante" idtipodoc="6" onclick="verdocumento(this.id);" class="btnfiles">
										</div>
									</div>
									<div class="form-group col-xs-12">
										<div class="col-xs-4">
											<label>Cédula Fiscal: <sup>*</sup></label>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input type="file" accept="application/pdf" class="hidess" name="documento_rfc" id="documento_rfc" onchange="validarArchivoSeleccionado('documento_rfc')" idtipodoc="2">
												<input type="hidden" name="nIdDoc" id="txtNIdDoc" idtipodoc="2">
											</div>
										</div>
										<div class="col-xs-4" style="display: flex; justify-content: space-between;align-items: center;">
											<span id="file-urlRFC" style='color:#024182'></span>
											<input type="hidden" id="urlRFC">
											<input origen="emisor" type="button" id="file_Rfc" value="Ver Comprobante" idtipodoc="2" onclick="verdocumento(this.id);" class="btnfiles">

										</div>
									</div>
									<div class="form-group col-xs-12">
										<div class="col-xs-4">
											<label class="">Comprobante de Domicilio: <sup>*</sup></label>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input type="file" accept="application/pdf" class="hidess" name="sFile" id="txtFile" onchange="validarArchivoSeleccionado('txtFile')" idtipodoc="3">
												<input type="hidden" name="nIdDoc" id="txtNIdDoc" idtipodoc="3">
											</div>
										</div>
										<div class="col-xs-4" style="display: flex; justify-content: space-between;align-items: center;">
											<span id="file-urlDomicilio" style='color:#024182'></span>
											<input type="hidden" name="" id="urlDomicilio">
											<input origen="emisor" type="button" id="file_Domicilio" value="Ver Comprobante" idtipodoc="3" onclick="verdocumento(this.id);" class="btnfiles">
										</div>
									</div>
									<div class="form-group col-xs-12">
										<div class="col-xs-4">
											<label class=""> ID Representante Legal: <sup>*</sup></label>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input type="file" accept="application/pdf" class="hidess" name="id_representante_legal" id="id_representante_legal" onchange="validarArchivoSeleccionado('id_representante_legal')" idtipodoc="5">
												<input type="hidden" name="nIdDoc" id="txtNIdDoc" idtipodoc="5">
											</div>
										</div>
										<div class="col-xs-4" style="display: flex; justify-content: space-between;align-items: center;">
											<span id="file-urlRepre" style='color:#024182'></span>
											<input type="hidden" id="urlRepre">
											<input origen="emisor" type="button" id="file_Repre" value="Ver Comprobante" idtipodoc="5" onclick="verdocumento(this.id);" class="btnfiles">

										</div>
									</div>
									<div class="form-group col-xs-12">
										<div class="col-xs-4">
											<label class="">Poder Legal: </label>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input type="file" accept="application/pdf" class="hidess" name="poder_legal" id="poder_legal" onchange="validarArchivoSeleccionado('poder_legal')" idtipodoc="4">
												<input type="hidden" name="nIdDoc" id="txtNIdDoc" idtipodoc="4">
											</div>
										</div>
										<div class="col-xs-4" style="display: flex; justify-content: space-between;align-items: center;">
											<span id="file-urlPoder" style='color:#024182'></span>
											<input type="hidden" id="urlPoder">
											<input origen="emisor" type="button" id="file_Poder" value="Ver Comprobante" idtipodoc="4" onclick="verdocumento(this.id);" class="btnfiles">

										</div>
									</div>
									<div class="form-group col-xs-12" id="div_adendo1">
										<div class="col-xs-4">
											<label class=""> Carátula Bancaria:</label>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input type="file" accept="application/pdf" class="hidess" name="adendo1" id="adendo1" onchange="validarArchivoSeleccionado('adendo1')" idtipodoc="7">
												<input type="hidden" name="nIdDoc" id="txtNIdDoc" idtipodoc="7">
											</div>
										</div>
										<div class="col-xs-4" style="display: flex; justify-content: space-between;align-items: center;">
											<span id="file-urlAdendo1" style='color:#024182'></span>
											<input type="hidden" id="urlAdendo1">
											<input origen="emisor" type="button" id="file_Adendo1" value="Ver Comprobante" idtipodoc="7" onclick="verdocumento(this.id);" class="btnfiles">
										</div>
									</div>

									<div class="form-group col-xs-12" id="div_adendo2">
										<div class="col-xs-4">
											<label class=""> Adendo:</label>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input type="file" accept="application/pdf" class="hidess" name="adendo2" id="adendo2" onchange="validarArchivoSeleccionado('adendo2')" idtipodoc="8">
												<input type="hidden" name="nIdDoc" id="txtNIdDoc" idtipodoc="8">
											</div>
										</div>
										<div class="col-xs-4" style="display: flex; justify-content: space-between;align-items: center;">
											<span id="file-urlAdendo2" style='color:#024182'></span>
											<input type="hidden" name="" id="urlAdendo2">
											<input origen="emisor" type="button" id="file_Adendo2" value="Ver Comprobante" idtipodoc="8" onclick="verdocumento(this.id);" class="btnfiles">
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<span id="span-documentos" class="" style="display: none;"></span>
										</div>
									</div>
									<div class="form-group col-xs-12" style="margin-top: 5px;">
										<button id="btn-documentos" type="button" class="btn btn-primary pull-right" style="margin-right:2em">Guardar</button>
									</div>
								</div>

								<!-- <div class="tab-pane" role="tabpanel" id="step5"> -->
								<div class="tab-pane" role="tabpanel" id="step4">
									<div class="form-group col-xs-12">
										<button class="btn btn-xs btn-info btnback" style="margin-top:20px;">Regresar</button>
									</div>
									<div style="margin-bottom:30px;" class="form-group col-xs-9">
										<h4 id="h4_liquidacion_servicios"><span><i class="fa fa-gear"></i></span> Liquidación</h4>
									</div>
									<div class="form-group col-xs-12" id="div_tipo_proveedorVS" style="display: none;">
										<div class="form-group col-xs-4">
											<label class=" control-label">
												<input type="radio" name="subtipo" onclick="validarSubTipo();" id="radio_prepago" value="0" checked> Prepago
											</label>
										</div>
										<div class="form-group col-xs-4">
											<label class=" control-label">
												<input type="radio" name="subtipo" onclick="validarSubTipo();" id="radio_credito" value="1"> Credito
											</label>
										</div>
										<small id="error-tiempo-aire" class="col-xs-12"></small>
										<div class="form-group col-xs-12" id="div_opciones_credito" style="display: none; padding-left: 0px; padding-bottom: 20px;">

											<div class="form-group col-xs-4">
												<label class=" control-label">Cantidad de Crédito</label>
												<input id="monto_credito" type="text" class="form-control" data-inputmask="'alias': 'numeric'">
												<small></small>
											</div>
											<div class="form-group col-xs-4">
												<label class=" control-label">Tipo</label>
												<select id="select_tipo_credito" class="form-control">
													<option value="1">Solo Factura</option>
													<option value="2">Factura y Nota de Crédito</option>
												</select>
											</div>
											<div class="form-group col-xs-4" id="contenedor_dias_credito">
												<label class=" control-label">Días de Crédito</label>
												<input id="dias_credito" type="text" class="form-control" data-inputmask="'alias': 'numeric'">
												<small></small>
											</div>
										</div>
										<div class="form-group col-xs-4" id="div_forma_pago_liquidacion">
											<label class="control-label">Retención<sup>*</sup></label>
											<select class="form-control m-bot15" name="retencion" id="retencion" onchange="SetearFormaPago();">
												<option value="-1">Seleccione</option>
												<option value="1">Sin Retención</option>
												<option value="2">Con Retención</option>
											</select>
											<small></small>
										</div>
										<div class="form-group col-xs-4" id="div_tipo_liquidacion">
											<label>Tipo de Liquidacion<sup>*</sup></label>
											<select id="dias_liquidacion" class="form-control">
												<option value="-1">Seleccione</option>
												<option value="1">T+ndias </option>
												<option value="2">Calendario</option>
												<option value="4">Especial</option>
											</select>
											<small></small>
										</div>
										<div class="col-xs-4" id="divEnviaReporteCS">
											<label class="control-label" style="margin-top:2.2em">
												<input type="checkbox" id="checkEnviaCS" class='m-bot15'>¿Enviar Reporte de Pago?
											</label>
										</div>

										<div id="divTndias" style="display:none;margin-top:90px;">
											<div class="form-group col-xs-4 col-xs-offset-4" style="margin-top:20px;">
												<center><label>T+n dias</label></center>
												<input type="text" id="tn_dias" class="form-control m-bot15">
												<small></small>
											</div>
										</div>

										<div id="divporperiodos" style="display:none;margin-top:90px;">
										<div class="form-group col-xs-4 col-xs-offset-4" style="margin-top:20px;">
											<center><label>Por periodos</label></center>
											<div style="text-align:center;">
												<table style="margin: 0 auto;">
													<?php
													$semana = array("Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado", "Domingo");
													for ($i = 0; $i < 5; $i++) {
														if ($i == 0) {
															$dia = "Lu_Check";
														}
														if ($i == 1) {
															$dia = "Ma_Check";
														}
														if ($i == 2) {
															$dia = "Mi_Check";
														}
														if ($i == 3) {
															$dia = "Ju_Check";
														}
														if ($i == 4) {
															$dia = "Vi_Check";
														}
													?>
														<tr>
															<td rowspan="2">
																<input type="text" class="form-control m-bot15" style="text-align: center;" id="" valorConfig="$i" value="<?php echo $semana[$i] ?>" disabled>
															</td>
															<td width="20">L</td>
															<td width="20">M</td>
															<td width="20">M</td>
															<td width="20">J</td>
															<td width="20">V</td>
															<td width="20">S</td>
															<td width="20">D</td>
														</tr>
														<tr>
															<td><input type="checkbox" id="0" data-dia="<?php echo $dia; ?>" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this)"></td>
															<td><input type="checkbox" id="1" data-dia="<?php echo $dia; ?>" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this)"></td>
															<td><input type="checkbox" id="2" data-dia="<?php echo $dia; ?>" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this)"></td>
															<td><input type="checkbox" id="3" data-dia="<?php echo $dia; ?>" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this)"></td>
															<td><input type="checkbox" id="4" data-dia="<?php echo $dia; ?>" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this)"></td>
															<td><input type="checkbox" id="5" data-dia="<?php echo $dia; ?>" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this)"></td>
															<td><input type="checkbox" id="6" data-dia="<?php echo $dia; ?>" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this)"></td>
														</tr>
													<?php } ?>
												</table>
											</div>
										</div>
										</div>

										<div class="row" id="divEspecial" style="display:none;margin-top:90px;">
											<div class="col-md-12" style="margin-top:20px;">
												<div class="col-md-3"><label></label></div>
												<div class="form-group col-md-3">
													<center><label> Dia Fecha Pago</label></center><br>
													<select class="form-control" id="especial_select_dias">
														<option value="-1">Seleccione...</option>
														<option value="0">Lunes</option>
														<option value="1">Martes</option>
														<option value="2">Miercoles</option>
														<option value="3">Jueves</option>
														<option value="4">Viernes</option>
													</select>
													<small></small>
												</div>
												<div class="col-md-4">
													<center><label> Cuantos dias hacia atras <br>no se contemplaran para el pago ?</label></center>
													<input type="number" min="0" max="31" maxlength="2" id="especial_dias" onkeyup="validarMinMax(this.id);" class="form-control m-bot15">
													<small></small>
												</div>
												<div class="col-md-2"><label></label></div>
											</div>
										</div>
										<div class="col-xs-7" style="margin-top:2em;" id="divCorreosNotificaciones">
											<label>Correos a enviar notificaciones de liquidacion<sup>*</sup></label>
											<div class="row field_wrapper" id="">
												<div class="form-group col-xs-12">
													<input type="text" id="nuevocorreonotificaciones" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
													<button id="btnCorreoNotificaciones" class="add_button btn btn-sm btn-default" onclick="agregarCorreoNotificaciones();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
													</button>
													<small style="display:block"></small>
												</div>
											</div>
											<div class="row field_wrapper" id="contenedordecorreosliquidacion"></div>
										</div>

										<div class="form-group col-xs-12" style="margin-top:20px;" id="div_liq4">
											<label>
												<h5>Comisión por Transferencia</h5>
											</label>
										</div>
										<div class="form-group col-xs-12" id="div_liq5">
											<div class="form-group col-xs-12">
												<label class="control-label">
													<input type="checkbox" id="monto_transferencia" value="1" class='m-bot15' onclick="habilitar_transferencia(this);">
													¿Se cobrará monto por Transferencia?
												</label>
											</div>
										</div>
										<div class="form-group col-xs-12" id="divcobtrans" style="display: none;"><!-- facturas-->
											<div class="form-group col-xs-3">
												<label class="control-label">Cantidad: </label>
												<input type="text" id="txtCantTrans" value="0" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-4">
												<label>IVA</label>
												<select class="form-control" id="ivaFactura">
													<option value="1">16%</option>
													<option value="2">8%</option>
													<option value="3">0%</option>
												</select>
											</div>
											<div class="form-group col-xs-3">
												<label class="control-label">Costo por Transferencia: </label>
												<input type="text" id="txtcostotrans" value="0" class='form-control m-bot15' disabled>
												<small></small>
											</div>
										</div>
									</div>
									<div style="margin-bottom:30px;" class="form-group col-xs-9">
										<h4 id="h4_liquidacion_TA"><span><i class="fa fa-gear"></i></span> Liquidación</h4>
									</div>
									<!-- <div class="form-group col-xs-12" id="div_tipo_proveedorTA" style="display: none;">
										<div class="form-group col-xs-4">
											<label class=" control-label">
												<input type="radio" name="subtipo" onclick="validarSubTipo();" id="radio_prepago" value="0"> Prepago
											</label>
										</div>
										<div class="form-group col-xs-4">
											<label class=" control-label">
												<input type="radio" name="subtipo" onclick="validarSubTipo();" id="radio_credito" value="1"> Credito
											</label>
										</div>
										<small id="error-tiempo-aire" class="col-xs-12"></small>
										<div class="form-group col-xs-12" id="div_opciones_credito" style="display: none;">

											<div class="form-group col-xs-4">
												<label class=" control-label">Cantidad de Credito</label>
												<input id="monto_credito" type="text" class="form-control" data-inputmask="'alias': 'numeric'">
												<small></small>
											</div>
											<div class="form-group col-xs-4">
												<label class=" control-label">Tipo</label>
												<select id="select_tipo_credito" class="form-control">
													<option value="1">Solo Factura</option>
													<option value="2">Factura y Nota de Credito</option>
												</select>
											</div>
										</div>
									</div> -->
									<div class="form-group col-xs-12" id="div_tipo_proveedorPT" style="display: none;">
										<!--
                        	<div class="col-xs-3" id="div_tipo_liquidacion">
                         		<label>Tipo de Liquidacion</label>
                         		<select id="dias_liquidacion_ppt" class="form-control">
                         			<option value="-1">Seleccione</option>
                         			<option value="1">T+ndias </option>
                         			<option value="2">Por periodos</option>
                         			<option value="4">Especial</option>
                         		</select>
                         	</div>
                            <div class="col-xs-3" id="divEnviaReportePCT">
                                <label class="control-label"><br><br>
                                    <input type="checkbox" id="checkEnviaPCT" class='m-bot15'>¿Enviara Reporte Cobranza? 
                                </label>
                            </div>
							-->
										<!-- 
							<div id="divTndias_ppt" style="display:none;margin-top:90px;">
								<div class="col-xs-3 col-xs-offset-4">
									<center><label>T+n dias</label></center>
									<input type="text" id="tn_dias_ppt" class="form-control m-bot15">
								</div>                                     
							</div>
							-->
										<!--
							<div id="divporperiodos_ppt" style="display:none;margin-top:90px;">
								<center><label>Por periodos</label></center>
								<div style="text-align:center;">
								<table style="margin: 0 auto;">
									<?php /* 
									$semana = array ("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
									for ($i=0; $i < 5; $i++) { 
										if($i==0){ $dia="Lu_Check_ppt"; }
										if($i==1){ $dia="Ma_Check_ppt"; }
										if($i==2){ $dia="Mi_Check_ppt"; }
										if($i==3){ $dia="Ju_Check_ppt"; }
										if($i==4){ $dia="Vi_Check_ppt"; }
									*/ ?>
									<tr>
										<td rowspan="2">
											<input type="text" class="form-control m-bot15" style="text-align: center;" id="" valorConfig="$i" value="<?php /*echo $semana[$i]*/ ?>" disabled>
										</td>
										<td width="20">L</td><td width="20">M</td><td width="20">M</td><td width="20">J</td><td width="20">V</td><td width="20">S</td><td width="20">D</td>	
									</tr>
									<tr>
										<td><input type="checkbox" id="0" value="0" class="<?php /*echo $dia;*/ ?>" onclick="validarCantidadPPT(this.id)"></td>
										<td><input type="checkbox" id="1" value="0" class="<?php /*echo $dia;*/ ?>" onclick="validarCantidadPPT(this.id)"></td>
										<td><input type="checkbox" id="2" value="0" class="<?php /*echo $dia;*/ ?>" onclick="validarCantidadPPT(this.id)"></td>
										<td><input type="checkbox" id="3" value="0" class="<?php /*echo $dia;*/ ?>" onclick="validarCantidadPPT(this.id)"></td>
										<td><input type="checkbox" id="4" value="0" class="<?php /*echo $dia;*/ ?>" onclick="validarCantidadPPT(this.id)"></td>
										<td><input type="checkbox" id="5" value="0" class="<?php /*echo $dia;*/ ?>" onclick="validarCantidadPPT(this.id)"></td>
										<td><input type="checkbox" id="6" value="0" class="<?php /*echo $dia;*/ ?>" onclick="validarCantidadPPT(this.id)"></td>
									</tr>
									<?php /* } */ ?>
								</table></div>                           
							</div>
							-->
										<!--
							<div class="row" id="divEspecial_ppt" style="display:none;margin-top:90px;">
								<div class="col-md-12">
									<div class="col-md-3"><label></label></div>
									<div class="col-md-3">
										<center><label> Dia Fecha Pago</label></center><br>
										<select class="form-control" id="especial_select_dias_ppt">
											<option value="-1">Seleccione...</option>
											<option value="0">Lunes</option>
											<option value="1">Martes</option>
											<option value="2">Miercoles</option>
											<option value="3">Jueves</option>
											<option value="4">Viernes</option>
										</select>
									</div>
									<div class="col-md-4">
										<center><label> Cuantos dias hacia atras <br>no se contemplaran para el pago ?</label></center>
										<input type="number" min="0" max="31" maxlength="2" id="especial_dias_ppt" onkeyup="validarMinMax(this.id);" class="form-control m-bot15">
									</div>
									<div class="col-md-2"><label></label></div>
								</div>
							</div>
							-->
										<!-- 
							<div class="form-group col-xs-12" id="div_tabla_bancos" style="display: none;"><br><br>
								<h4 id=""> Bancos Preferentes</h4>
								<table class="table" id="tablaBP">
									<thead>
										<tr>
										<th>Banco</th>
										<th>Tipo</th>
										<th>Porcentaje</th>
										<th></th>
										</tr>
									</thead>
									<tr id="filabp_0">
										<td>
											<select class="form-control" id="selectbancopreferente_0">
												<option value="1">Santander</option>
												<option value="2">Banamex</option>
												<option value="3">Banorte</option>
												<option value="4">HSBC</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="selecttipocuotapreferente_0">
												<option value="1">Credito</option>
												<option value="2">Debito</option>
											</select></td>
										<td>
										<input type="text" name="porcentajebancopreferente_0" id="porcentajebancopreferente_0" class="form-control">
										</td>
										<td>
											<button id="rowbp_0" class="add_button btn btn-sm btn-default" onclick="agregarFilaBancoPref(this.id);">
												<i class="fa fa-plus-circle" aria-hidden="true"></i>
											</button>
										</td>
									</tr>
								</table>
							</div>
							-->
										<!-- <div class="form-group col-xs-12"  id="div_bancos_otros"> -->
										<!--
							<div class="form-group col-xs-12">
		                        <label class="control-label">Otros Bancos: </label>
							</div>
							-->
										<!--
							<table class="table" id="tabla_tarjetas">
                        	<thead>
					            <tr>
					              <th>Tipo</th><th>Tarjeta</th><th>Porcentaje</th>
					            </tr>
					          </thead>
                        		<tr id="filatarjetas_0">
                        		<td>
                        			<select class="form-control" id="select_tipo_credito_tarjeta_0">
                						<option value="1">Credito</option>
                						<option value="2">Debito</option>
                        			</select>
                        		</td>

                        		<td>
                        			<select class="form-control" id="select_tipo_tarjeta_0">
                						<option value="1">VISA</option>
                						<option value="2">MASTER CARD</option>
                						<option value="3">AMERICAN EXPRESS</option>
                        			</select>
                        		</td>
                        		<td><input type="text" id="porcentajetarjeta_0" class="form-control m-bot15"></td>
                        		<td><button id="row_0" class="add_button btn btn-sm btn-default" onclick="agregarFilaTarjeta(this.id);">
                         		 	<i class="fa fa-plus-circle" aria-hidden="true"></i>
	                             </button></td>
                        		</tr>
                        	</table> 
							-->
										<!-- 
							<div class="form-group col-xs-3">
		                        <label class="control-label">Tipo: </label>
								<select class="form-control" id="select_tipo_cuota_otros">
                					<option value="1">Credito</option>
                					<option value="2">Debito</option>
                        		</select>
							</div> 
							-->
										<!-- <div class="form-group col-xs-3">
		                        <label class=" control-label">Porcentaje: </label>
								<input type="text" name="porcentaje_banco_otros" id="porcentaje_banco_otros" class="form-control">
							</div> -->
										<!-- </div> -->

										<!--
						<div class="form-group col-xs-12"  id="div_bancos_amex" style="display: none;">
							<div class="form-group col-xs-12">
		                        <label class="control-label">American Express: </label>
							</div>
		                    <div class="form-group col-xs-3">
		                        <label class="control-label">Tipo: </label>
								<select class="form-control" id="select_tipo_cuota_amex">
                					<option value="1">Credito</option>
                					<option value="2">Debito</option>
                        		</select>
							</div>
		                    <div class="form-group col-xs-3">
		                        <label class=" control-label">Porcentaje: </label>
								<input type="text" name="porcentaje_banco_amex" id="porcentaje_banco_amex" class="form-control">
							</div>
						</div>
						-->

										<!--
						<div class="form-group col-xs-12"  id="div_fondo_reserva"><br>
							<div class="form-group col-xs-12" id="">
							 	<div class="col-xs-4">
	                    	 	<label class="control-label">
	                    	 		<input type="checkbox" id="fondo_reserva" value="1" class='m-bot15' onclick="habilitarDivFondoReserva(this);"> Fondo de Reserva 
	                    	 	</label>
							 	</div>
	                    	</div>
		                    <div class="form-group col-xs-12"  id="div_datos_fondo_reserva" style="display: none;">
		                    	<div class="col-xs-4">
			                       <label>Porcentaje Reserva</label>
			                       <input type="text" name="porcentaje_reserva" id="porcentaje_reserva" class="form-control">
		                    	</div>
		                    	<div class="col-xs-4">
			                       <label>Monto Reserva</label>
			                       <input type="text" name="monto_reserva" id="monto_reserva" class="form-control">
		                    	</div>
							</div>

							<div class="form-group col-xs-12" id="">
							 	<div class="col-xs-4">
                        	 	<label class="control-label">Periodicidad para recibir facturas</label>
                        	 		<select id="periodicidad_ppt" class="form-control">
                        	 			<option value="1">Diario</option>
                        	 			<option value="2">Semanal</option>
                        	 			<option value="3">Quincenal</option>
                        	 			<option value="4">Mensual</option>
                        	 		</select>
							 	</div>
                        	 </div>
						</div>
						-->
									</div>

									<div class="form-group col-xs-12">
										<button id="btn-liquidacion" type="button" class="btn btn-primary pull-right" style="margin-right:3em">Guardar</button>
									</div>
								</div>

								<!-- <div class="tab-pane" role="tabpanel" id="step6"> -->
								<div class="tab-pane" role="tabpanel" id="step5">
									<div class="form-group col-xs-12">
										<button class="btn btn-xs btn-info btnback" style="margin-top:20px;">Regresar</button>
									</div>
									<div style="margin-bottom:30px;" class="form-group col-xs-9">
										<h4><span><i class="fa fa-gear"></i></span> Datos Facturación</h4>
									</div>

									<div id="facturacion_VSTA" style="display: none;">
										<!-- <div class="form-group col-xs-4">
											<label>IVA de Facturación:</label>
											<select class="form-control" id="ivaFactura">
												<option value="1">16%</option>
												<option value="2">8%</option>
												<option value="3">0%</option>
											</select>
										</div> -->

										<div class="form-group col-xs-12">
											<label class="control-label" style="margin-top:1em;"><strong style="font-size:16px;margin-top:1em;">Factura por Comisión</strong></label>
										</div>
										<div class="form-group col-xs-12">
											<input type="checkbox" id="genera_factura_comision" onclick="habilitarDivFacturaComision();" value="1" class='m-bot15'>&nbsp;&nbsp;<label>Genera Factura:</label>
										</div>

										<div id="contenidoFacturaComision">
											<div class="form-group col-xs-4">
												<label>Uso del CFDI:</label><select class="form-control" id="cmbCFDIComision"></select>
											</div>
											<div class="form-group col-xs-4">
												<label>Forma de pago:</label><select class="form-control" id="cmbFormaPagoComision"></select>
											</div>
											<div class="form-group col-xs-4">
												<label>Método de pago:</label><select class="form-control" id="cmbMetodoPagoComision"></select>
											</div>
											<div class="form-group col-xs-6">
												<label>Clave del producto:</label><select class="form-control" id="cmbProductoServicioComision"></select>
											</div>
											<div class="form-group col-xs-6">
												<label>Clave de Unidad:</label><select class="form-control" id="cmbClaveUnidadComision"></select>
											</div>
											<div class="form-group col-xs-4">
												<label>Periodicidad de facturación:</label>
												<select class="form-control" id="periocidadComision">
													<option value="1">Semanal</option>
													<option value="2">Quincenal</option>
													<option value="3">Mensual</option>
												</select>
											</div>
											<div class="form-group col-xs-4">
												<label>Días para liquidar la factura:</label>
												<input class="form-control" type="text" id="diasLiquidacionComision" disabled>
												<small></small>
											</div>
											<div class="col-xs-7" id="divCorreosFacturaComision">
												<label>Correos a enviar la factura:</label>
												<div class="row field_wrapper" id="contenedordecorreosfacturas">
													<div class="form-group col-xs-12">
														<input type="text" id="nuevocorreofacturasComision" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
														<button id="btnCorreoFacturasComision" class="add_button btn btn-sm btn-default" onclick="agrergarcorreosfacturasComision();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
														</button>
														<small style="display: block;"></small>
													</div>
												</div>
												<div class="row field_wrapper" id="contenedordecorreosfacturasComision"></div>
											</div>
										</div>

										<div class="form-group col-xs-12">
											<label class="control-label" style="margin-top:1.5em;"><strong style="font-size:16px">Factura Comisión por Transferencia</strong></label>
										</div>
										<div class="form-group col-xs-12">
											<input type="checkbox" id="genera_factura_comision_transferencia" onclick="habilitarDivFacturaTransferencia();" value="1" class='m-bot15'>&nbsp;&nbsp;<label>Genera Factura:</label>
										</div>


										<div id="contenidoFacturaTransferencia">
											<div class="form-group col-xs-4">
												<label>Uso del CFDI:</label><select class="form-control" id="cmbCFDITransferencia"></select>
											</div>
											<div class="form-group col-xs-4">
												<label>Forma de pago:</label><select class="form-control" id="cmbFormaPagoTransferencia"></select>
											</div>
											<div class="form-group col-xs-4">
												<label>Método de pago:</label><select class="form-control" id="cmbMetodoPagoTransferencia"></select>
											</div>
											<div class="form-group col-xs-6">
												<label>Clave del producto:</label><select class="form-control" id="cmbProductoServicioTransferencia"></select>
											</div>
											<div class="form-group col-xs-6">
												<label>Clave de Unidad:</label><select class="form-control" id="cmbClaveUnidadTransferencia"></select>
											</div>
											<div class="form-group col-xs-4">
												<label>Periodicidad de facturación:</label>
												<select class="form-control" id="periocidadTransferencia">
													<option value="1">Semanal</option>
													<option value="2">Quincenal</option>
													<option value="3">Mensual</option>
												</select>
											</div>
											<div class="form-group col-xs-4">
												<label>Días para liquidar la factura:</label>
												<input class="form-control" type="text" id="diasLiquidacionTransferencia" value="0" disabled>
												<small></small>
											</div>
											<div class="col-xs-7" id="divCorreosFacturaTransferencia">
												<label>Correos a enviar la factura:</label>
												<div class="row field_wrapper" id="contenedordecorreosfacturas">
													<div class="form-group col-xs-12">
														<input type="text" id="nuevocorreofacturasTransferencia" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
														<button id="btnCorreoFacturas" class="add_button btn btn-sm btn-default" onclick="agrergarcorreosfacturasTransferencia();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
														</button>
														<small style="display: block;"></small>
													</div>
												</div>
												<div class="row field_wrapper" id="contenedordecorreosfacturasTransferencia"></div>
											</div>
										</div>

									</div>

									<!-- 
                        <div id="facturacion_PPT" style="display: none;">

                        	<div class="col-xs-4">
                            	<input type="checkbox" id="cobran_pago_transferencia" onclick="habilitarDivMontoCobroPagoTransfer();" value="1" class='m-bot15'>&nbsp;&nbsp;<label>Proveedor Cobra Pago por Transferencia:</label><br><br>

                            	<label id="label_mpt" style="display: none;">Monto Pago Transferencia</label>
                            	<input type="text" style="display: none;" name="monto_pago_transferencia" id="monto_pago_transferencia" class="form-control"><br><br>
                        	</div>
                        	<div class="col-xs-12">
	                        	<div class="col-xs-4">
	                            	<label>IVA de Facturación:</label>
	                                <select class="form-control" id="ivaFactura_ppt">
	                                	<option value="1">16%</option>                                    		
	                                	<option value="2">8%</option>
	                                	<option value="3">0%</option>		
	                                </select>
	                           	</div>
                        	</div>
                        	<div class="form-group col-xs-12">
                             	<label class="control-label"><strong style="font-size: 16px;">Factura Publico en General</strong></label>
                            </div>
                            <div class="form-group col-xs-12">
                           		<input type="checkbox" id="genera_factura_public_gral" onclick="habilitarDivFacturaPubGral();" value="1" class='m-bot15'>&nbsp;&nbsp;<label>Genera Factura:</label>
                           	</div>

                           	<div id="contenidoFacturaPubGral" style="display: none;">
                                    <div class="form-group col-xs-4">
                                    	<label>Uso del CFDI:</label><select class="form-control" id="cmbCFDIPubGral"></select>
                                    </div> 
                                    <div class="form-group col-xs-4">
                                    	<label>Forma de pago:</label><select class="form-control" id="cmbFormaPagoPubGral"></select>
                                    </div>
                                    <div class="form-group col-xs-4">
                                    	<label>Método de pago:</label><select class="form-control" id="cmbMetodoPagoPubGral"></select>
                                    </div>                                   	
                                    <div class="form-group col-xs-6">
                                    	<label>Clave del producto:</label><select class="form-control" id="cmbProductoServicioPubGral"></select>
                                    </div>
                                    <div class="form-group col-xs-6">
                                    	<label>Clave de Unidad:</label><select class="form-control" id="cmbClaveUnidadPubGral"></select>
                                    </div>                                    	
                                    <div class="form-group col-xs-4">
                                    	<label>Periodicidad de facturación:</label>
                                    	<select class="form-control" id="periocidadPubGral">
                                    		<option value="1">Semanal</option>
                                    		<option value="2">Quincenal</option>
                                    		<option value="3">Mensual</option>
                                    	</select>
                                    </div>
                                    <div class="form-group col-xs-4">
                                    	<label>Días para liquidar la factura:</label>
                                    	<input class="form-control" type="text" id="diasLiquidacionPubGral">
                                    </div>
                                    <div class="col-xs-7" id="divCorreosFacturaPubGral">
                                    	<label>Correos a enviar la factura:</label>
										<div class="row field_wrapper" id="contenedordecorreosPubGral">
			                                <div class="col-xs-12">
			                                    <input type="text" id="nuevocorreofacturasPubGral" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
			                                    <button id="btnCorreoPubGral" class="add_button btn btn-sm btn-default" onclick="agrergarcorreosfacturasPubGral();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
			                                    </button>
			                                </div>
                                       	</div>
		                                <div class="row field_wrapper" id="contenedordecorreosfacturasPubGral"></div> 
									</div>
								</div>

                        </div>
						-->

									<div class="row">
										<div class="col-lg-12">
											<br><span id="span-facturacion" class="" style="display: none;"></span>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<button id="btn-facturacion" type="button" class="btn btn-primary pull-right">Guardar</button>
									</div>
								</div>

								<!-- <div class="tab-pane" role="tabpanel" id="step7"> -->
								<div class="tab-pane" role="tabpanel" id="step6">
									<div style="margin-bottom:30px;" class="form-group col-xs-9">
										<h4 id="h4_datos_contables"><span><i class="fa fa-gear"></i></span> Cuentas Contables</h4>
									</div>
									<div class="form-group col-xs-12">
										<div class="col-xs-3" id="div_cc_ingresos">
											<label>Cuenta Contable Ingresos</label>
											<input type="text" id="cuenta_contable_ingresos" class="form-control m-bot15" maxlength="16">
										</div>
										<div class="col-xs-3" id="div_cc_costos">
											<label>Cuenta Contable Costos</label>
											<input type="text" id="cuenta_contable_costos" class="form-control m-bot15" maxlength="16">
										</div>
										<div class="col-xs-3">
											<label>Cuenta Contable del Proveedor</label>
											<input type="text" id="cuenta_contable_proveedor" class="form-control m-bot15" maxlength="16">
										</div>
										<div class="col-xs-3">
											<label>Cuenta Contable del Banco</label>
											<input type="text" id="cuenta_contable_banco" class="form-control" maxlength="16">
										</div>
										<div class="col-xs-3">
											<label>Cuenta Contable del Cliente</label>
											<input type="text" id="cuenta_contable_cliente" class="form-control" maxlength="16">
										</div>
										<div class="col-xs-3">
											<label>IVA Traslado por Cobrar</label>
											<input type="text" id="cuenta_contable_iva_translado_por_cobrar" class="form-control" maxlength="16">
										</div>
										<div class="col-xs-3">
											<label>IVA Acreditable por Pagar</label>
											<input type="text" id="cuenta_contable_iva_acreditable_por_pagar" class="form-control" maxlength="16">
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<br><br><br>
											<span id="span_paso7" class="" style="display: none;"></span>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<button id="paso7" type="button" class="btn btn-primary pull-right" style="margin-right: 0.9em;">Guardar</button>
									</div>
								</div>

								<!-- <div class="tab-pane" role="tabpanel" id="step8"> -->
								<!--
						<div style="margin-bottom:30px;" class="form-group col-xs-9">
                            <h4><span><i class="fa fa-gear"></i></span> Time Out</h4>
                        </div>
						-->

								<!-- 
                        <div id="timeout_VSTA">
                        	<div class="form-group col-xs-12">
                             	<div class="col-xs-3" id="div_tiempo_timeout">
                             		 <label>Tiempo de Time Out en Segundos</label>
                             		<input type="text" id="tiempo_timeout" maxlength="5" class="form-control m-bot15">
                             	</div>
                             	<div class="col-xs-3" id="div_vpn">
                             		 <label>VPN</label>
                             		 <select id="select_vpn" class="form-control">
                             		 	<option value="1">SI</option>
                             		 	<option value="2">NO</option>
                             		 </select>
                             	</div>
                             	<div class="col-xs-3" id="div_vpn_pruebas">
                             		 <label>VPN Desarrollo/Pruebas</label>
                             		 <select id="select_vpnDesPrue" class="form-control">
                             		 	<option value="si">SI</option>
                             		 	<option value="no">NO</option>
                             		 </select>
                             	</div>
                             	<div class="col-xs-3" id="div_metodo_entrega">
                             		 <label>Metodo Entrega</label>
                             		 <select class="form-control m-bot15" name="cbnotif" id="cbnotif" onchange="ftpopt(this.value)">
                                           <option value="0">Seleccione</option>
                                           <option value="1">Via FTP</option>
                                           <option value="2">Via SFTP</option>
                                           <option value="3">Via FTPS</option>
                                        </select>
                             	</div>
                            </div>

                            <div  style="display: none;" id="datosFtp">
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Host: </label>
                                            <input type="text" id="host" class='form-control m-bot15' step="any">
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Puerto: </label>
                                            <input type="text" id="port" class='form-control m-bot15'>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Usuario: </label>
                                            <input type="text" id="user" class='form-control m-bot15'>
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Password: </label>
                                            <input type="text" id="password" class='form-control m-bot15' step="any">
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Path de folder remoto: </label>
                                            <input type="text" id="remoteFolder" class='form-control m-bot15'>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                    	<div class="row" style="display: none;" id="confcorreos">
	                                     <label style="margin-left: 15px; margin-top: 15px; text-align:center" class="col-xs-12 control-label"></label>
	                                     
	                                    <div id="formCorreos"  style="margin-left: 30px; margin-top: 15px;">
	                                       <label class=" control-label">Correos: </label>
	                                            <div class="row field_wrapper" id="contenedordecorreos">
	                                                <div class="col-xs-12">
	                                                    <input type="text" id="nuevocorreo" class="form-control m-bot15" name="correos" style="width: 300px; display:inline-block;">
	                                                    <button id="nuevoCorreo" class="add_button btn btn-sm btn-default" onclick="agregarcorreosTimeOut();">  <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
	                                                </div>
	                                            </div>
	                                            <div class="row field_wrapper" id="contenedordecorreos1">
	                                            </div>
	                                    </div>
                                		</div>
                                    </div>
                                </div>
                        </div>
						-->

								<!-- 
                        <div id="timeout_PPT">
                        	<div class="col-xs-12">
                        	<div class="col-xs-3" id="div_metodo_envioppt1">
                         		 <label>Metodo Envio</label>
                         		 <select class="form-control m-bot15" name="cbnotif_ppt1" id="cbnotif_ppt1" onchange="ftpoptppt1(this.value)">
                                       <option value="0">Seleccione</option>
                                       <option value="1">Via FTP</option>
                                       <option value="2">Via SFTP</option>
                                       <option value="3">Via FTPS</option>
                                    </select>
                         	</div>
                        	</div>
                         	<div  style="display: none;" id="datosFtp_ppt1">
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Host: </label>
                                            <input type="text" id="hostppt1" class='form-control m-bot15' step="any">
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Puerto: </label>
                                            <input type="text" id="portppt1" class='form-control m-bot15'>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Usuario: </label>
                                            <input type="text" id="userppt1" class='form-control m-bot15'>
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Password: </label>
                                            <input type="text" id="passwordppt1" class='form-control m-bot15' step="any">
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Path de folder remoto: </label>
                                            <input type="text" id="remoteFolderppt1" class='form-control m-bot15'>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                    	<div class="row" style="display: none;" id="confcorreosppt1">
	                                     <label style="margin-left: 15px; margin-top: 15px; text-align:center" class="col-xs-12 control-label"></label>
	                                     
	                                    <div id="formCorreosTimeOutEnvio"  style="margin-left: 30px; margin-top: 15px;">
	                                       <label class=" control-label">Correos: </label>
	                                            <div class="row field_wrapper" id="contenedordecorreosTimeOutEnvio11">
	                                                <div class="col-xs-12">
	                                                    <input type="text" id="nuevocorreoenvio" class="form-control m-bot15" name="correos" style="width: 300px; display:inline-block;">
	                                                    <button id="nuevoCorreoenvio" class="add_button btn btn-sm btn-default" onclick="agregarcorreosTimeOutenvio();">  <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
	                                                </div>
	                                            </div>
	                                            <div class="row field_wrapper" id="contenedordecorreosTimeOutEnvio">
	                                            </div>
	                                    </div>

                                		</div>
                                    </div>
                                </div>



                            <div class="col-xs-12">
                        	<div class="col-xs-3" id="div_metodo_entregappt1">
                         		 <label>Metodo Entrega</label>
                         		 <select class="form-control m-bot15" name="cbnotif_ppt2" id="cbnotif_ppt2" onchange="ftpoptppt2(this.value)">
                                       <option value="0">Seleccione</option>
                                       <option value="1">Via FTP</option>
                                       <option value="2">Via SFTP</option>
                                       <option value="3">Via FTPS</option>
                                    </select>
                         	</div>
                        	</div>
                         	<div  style="display: none;" id="datosFtp_ppt2">
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Host: </label>
                                            <input type="text" id="hostppt2" class='form-control m-bot15' step="any">
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Puerto: </label>
                                            <input type="text" id="portppt2" class='form-control m-bot15'>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Usuario: </label>
                                            <input type="text" id="userppt2" class='form-control m-bot15'>
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Password: </label>
                                            <input type="text" id="passwordppt2" class='form-control m-bot15' step="any">
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Path de folder remoto: </label>
                                            <input type="text" id="remoteFolderppt2" class='form-control m-bot15'>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                    	<div class="row" style="display: none;" id="confcorreosppt2">
	                                     <label style="margin-left: 15px; margin-top: 15px; text-align:center" class="col-xs-12 control-label"></label>
	                                     
	                                    <div id="formCorreosTimeOutEntrega"  style="margin-left: 30px; margin-top: 15px;">
	                                       <label class=" control-label">Correos: </label>
	                                            <div class="row field_wrapper" id="contenedordecorreosppt211">
	                                                <div class="col-xs-12">
	                                                    <input type="text" id="nuevocorreoentrega" class="form-control m-bot15" name="correos" style="width: 300px; display:inline-block;">
	                                                    <button id="nuevoCorreoppt2" class="add_button btn btn-sm btn-default" onclick="agregarcorreosTimeOutEntrega();">  <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
	                                                </div>
	                                            </div>
	                                            <div class="row field_wrapper" id="contenedordecorreosentrega">
	                                            </div>
	                                    </div>
                                		</div>
                                    </div>
                                </div>
                        </div> 
						-->
								<!-- 
					    <div class="row">
					        <div class="col-lg-12">
					        	<br><br>
					            <span id="span_paso8" class="" style="display: none;"></span>
					        </div>
					    </div>
					    <ul class="list-inline pull-right">
					       	<li><button type="button" class="btn btn-default prev-step">Anterior</button></li>
					        <li><button id="paso8" type="button" class="btn btn-primary next-step">Continuar</button></li>
					    </ul>
						-->
								<!-- </div> -->

								<!-- <div class="tab-pane" role="tabpanel" id="step9"> -->
								<div class="tab-pane" role="tabpanel" id="step7">
									<div class="form-group col-xs-12">
										<button class="btn btn-xs btn-info btnback" style="margin-top:20px;">Regresar</button>
									</div>
									<div style="margin-bottom:30px;" class="form-group col-xs-9">
										<h4><span><i class="fa fa-gear"></i></span> Matriz de Escalamiento</h4>
									</div>

									<table class="table" id="tabla_escalamiento">
										<thead>
											<tr>
												<th>Departamento</th>
												<th>Nombre</th>
												<th>Puesto</th>
												<th>Telefono</th>
												<th>Correo</th>
												<th></th>
											</tr>
										</thead>
										<tr id="fila_0">
											<td><select class="form-control m-bot15" id="departamento_0"></select></td>
											<td><input type="text" id="nombre_0" class="form-control m-bot15"></td>
											<td><input type="text" id="puesto_0" class="form-control m-bot15"></td>
											<td><input type="text" id="telefono_0" maxlength="12" class="form-control m-bot15 telefono"></td>
											<td><input type="text" id="correo_0" class="form-control m-bot15"></td>
											<td><button id="row_0" class="add_button btn btn-sm btn-default" onclick="agregarFila(this.id);">
													<i class="fa fa-plus-circle" aria-hidden="true"></i>
												</button></td>
										</tr>
									</table>
									<div class="row">
										<div class="col-lg-12"><br><br>
											<!-- <span id="span_paso9" class="" style="display: none;"></span> -->
											<span id="span-matriz-escalamiento" class="" style="display: none;"></span>
										</div>
									</div>
									<div class="form-group col-sx-12">
										<button id="btn-matriz-escalamiento" type="button" class="btn btn-primary pull-right" style="margin-right: 0.5em;">Guardar</button>
									</div>
								</div>

								<!-- 
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Formulario Completo</h3>
                        <p id="mensajefinal">Se ha guardado la informacion correctamente</p>
                    </div>
					 -->
								<div class="clearfix"></div>
							</div>
							<!-- </form> -->
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<div id="ayuda" class="modal fade col-xs-12" role="dialog">
	<div class="modal-dialog" style="width:50%;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<span><i class="fa fa-lightbulb-o" style="font-size:18px"></i> Información de Ayuda</span>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body texto">
				<div class="row">
					<div class="col-md-12">
						<div class="panel with-nav-tabs panel-default" style="box-shadow: none;">
							<div class="panel-heading">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab1default" data-toggle="tab">Referencias</a></li>
								</ul>
							</div>
							<div class="panel-body">
								<div class="tab-content">
									<div class="tab-pane fade in active" id="tab1default">
										<p><b>Referencia Emisor</b> : se genera la referencia respetando de 1 hasta 9 posiciones de la referencia del emisor. </p>
										<p><b>Referencia PayCash</b> : Referencia creada via el webservice de PayCash.</p>
										<p><b>Via WebService</b> : El emisor integra el webservice para generar referencias de 30 posiciones.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<button id="btnOpenModal" type="button" class="btn btn-primary" data-toggle="modal" style="display: none;" data-target="#modalAgregarProducto"></button>
<div class="modal fade" id="modalAgregarProducto" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xs" style="width: 30%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Agregar Producto</h4>
			</div>
			<div class="modal-body">
				<label>Familia</label>
				<select id="familia_modal" class="form-control" onchange="BuscarSubFamilias(this.value)"></select>
				<label>Sub Familia</label>
				<select id="subfamilia_modal" class="form-control"></select>
				<label>Emisor</label>
				<select id="emisor_modal" class="form-control"></select>
				<label>Descripcion</label>
				<input type="text" id="producto_descripcion" class="form-control">
				<label>Abreviatura</label>
				<input type="text" id="producto_abreviatura" class="form-control">
				<label>SKU</label>
				<input type="text" id="sku" class="form-control">
				<label>Fecha de entrada en vigor</label>
				<input class="datepicker form-control" id="fecha_entrada_vigor" onkeypress="sumarFechas(this.value);">
				<label>Fecha de salida de vigor</label>
				<input class="datepicker form-control" id="fecha_salida_vigor">
				<label>Flujo del Importe</label>
				<select id="select_flujo_importe" class="form-control"></select>
				<label>Importe Minimo Producto</label>
				<input type="text" id="importe_minimo_producto" class="form-control">
				<label>Importe Maximo Producto</label>
				<input type="text" id="importe_maximo_producto" class="form-control">
				<label>% Comision del Producto</label>
				<input type="text" id="porcentaje_comision_producto" class="form-control">
				<label>Importe Comision del Producto</label>
				<input type="text" id="importe_comision_producto" class="form-control">
				<label>% Comision del Corresponsal</label>
				<input type="text" id="porcentaje_comision_corresponsal" class="form-control">
				<label>Importe Comision del Corresponsal</label>
				<input type="text" id="importe_comision_corresponsal" class="form-control">
				<label>% Comision del Cliente</label>
				<input type="text" id="porcentaje_comision_cliente" class="form-control">
				<label>Importe Comision del Cliente</label>
				<input type="text" id="importe_comision_cliente" class="form-control">
				<div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="guardar_producto_nuevo" onclick="guardarProducto();">Guardar</button>
			</div>
		</div>
	</div>
</div>
<button id="btnVisor" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVisor" style="display: none;"></button>
<div class="modal fade" id="modalVisor" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xs" style="width: 50%;height: 100%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Ver Comprobante</h4>
			</div>
			<div class="modal-body">
				<iframe id="iframepdf" src="" style="width: -moz-available;height: 600px;"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-agreement">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div id="contenedorEmbed"></div>
				<!-- <embed src="" frameborder="0" width="100%" height="400px" id="embertoIn"> -->
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="confirmarEliminarRepresentante" class="modal fade col-xs-12" role="dialog">
	<div class="modal-dialog" style="width:50%;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Eliminar Representante Legal</h4>
			</div>
			<div class="modal-body">
				<p></p>
				<input type="hidden" id="idRepresentante" class='form-control m-bot15'>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Eliminando" id="eliminarRepre">Aceptar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<div id="confirmarEliminarDatosBancarios" class="modal fade col-xs-12" role="dialog">
	<div class="modal-dialog" style="width:50%;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Eliminar Representante Legal</h4>
			</div>
			<div class="modal-body">
				<p></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Eliminando" id="eliminarBanco">Aceptar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<!--*.JS Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/input-mask/input-mask.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script> -->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/paycash/ajax/pdfobject.js"></script>
<!--Autocomplete -->
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.core.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.widget.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.position.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.menu.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.autocomplete.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/codigo_postal.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/consulta.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.inputmask.bundle.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/afiliacionProveedor.js"></script>
<script type="text/javascript">
	BASE_PATH = "<?php echo $PATHRAIZ; ?>";
	initViewAltaProveedor();
</script>
<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
<link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">
<script type="text/javascript">
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
	}).on('changeDate', function(e) {
		var fecha = $("#fecha_entrada_vigor").val();
		var partes = fecha.split("/");
		var aniosExtra = 20;
		var dia = partes[0];
		var mes = partes[1];
		var anio = partes[2];
		var anioS = parseInt(anio) + parseInt(aniosExtra);
		var fsv = dia + "/" + mes + "/" + anioS;
		$("#fecha_salida_vigor").val(fsv);
	});

	function validarArchivoSeleccionado(inputId) {
		var inputFile = $('#' + inputId);
		var span = inputFile.next('span.text-danger');

		if (inputFile.get(0).files.length > 0) {
			span.hide();
		} else {
			span.show();
		}
	}

	$(".btnback").on('click', function() {
		let ruta = './consulta.php';
		window.location.href = ruta;
	});
</script>
<style>
	#datos_representante_legal,
	#datos_bancarios {
		margin-top: 50px;
	}

	#tabla_representante_legal th,
	#tabla_datos_bancarios th {
		text-align: center;
		background-color: #EDEFF1;
	}

	#tabla_representante_legal td,
	#tabla_datos_bancarios td {
		text-align: center;
		font-size: 12px;
	}

	#tabla_representante_legal td:nth-child(1),
	#tabla_datos_bancarios td:nth-child(5) {
		font-weight: bold;
	}
</style>
</body>

</html>