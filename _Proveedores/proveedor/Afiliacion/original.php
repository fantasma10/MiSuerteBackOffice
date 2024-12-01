<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL."/_Proveedores/proveedor/ajax/Cat_familias.php");
$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];
$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Proveedor";
$tipoDePagina = "mixto";
$idOpcion = 205;
$parametro_proveedor = $_POST["txtidProveedor"];
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
$idemisores =  (isset($_POST['txtidemisor']))?$_POST['txtidemisor']: 0;
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
	<title>.::Mi Red::.Afiliacion de Proveedor</title>
	<!-- Núcleo BOOTSTRAP -->
	<!-- <link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet"> -->
	<!--<link href="<?php echo $PATHRAIZ;?>/css/bootstrap3.min.css" rel="stylesheet">-->
	<link href="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/estilos/css/bootstrap3.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<!--<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />-->
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<!-- Autocomplete -->
  <link href="<?php echo $PATHRAIZ;?>/css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">
  <style type="text/css">
  	.inhabilitar{
			background-color: #d9534f!important;
			border-color: #d9534f!important;
			margin-left: 10px;
			color: #FFFFFF;
	}
	.disabledbutton {
    	pointer-events: none;
    	opacity: 0.4;
	}

  </style>
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include($PATH_PRINCIPAL."/inc/cabecera2.php"); ?>
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include($PATH_PRINCIPAL."/inc/menu.php"); ?>
<!--Final del Menú Vertical-->
<!--Contenido Principal del Sitio-->




<div class="container">
    <div class="row">
        <section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form role="form">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <h3>Step 1</h3>
                        <p>This is step 1</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h3>Step 2</h3>
                        <p>This is step 2</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h3>Step 3</h3>
                        <p>This is step 3</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Complete</h3>
                        <p>You have successfully completed all steps.</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
   </div>
</div>

<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-lg-12">
				<!--Panel Principal-->
				<div class="panelrgb">
					<div class="titulorgb-prealta">
						<span><i class="fa fa-user"></i></span>
						<h3>Datos del Proveedor</h3>
                        <span class="rev-combo pull-right">Afiliación <br>de Proveedor</span>
					</div>
					<div class="panel">
						<!--Datos Generales-->

						<div class="panel-body" id="">
							<div class="row">
			                <div class="form-group col-xs-12" id="panel_botones" style="display: none;" >
			                    <div class="form-group col-xs-6" style="">
			                        <button class="btn btn-xs btn-info " id="btnback" onclick="Regresar();" style="margin-top:20px;display:block" >Regresar </button>
			                    </div>
			                     
			                    <div class="form-group col-xs-6" style="">
			                        <button class="btn btn-xs btn-info pull-right" id="btnedit" onclick="habilitarDivs();" style="margin-top:20px;display:block" >Editar </button>
			                    </div>
			                </div>
			            	</div>

			            	<div class="well" id="">
			            		<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
			                  	<div class="form-group col-xs-12">
			                  		<div class="form-group col-xs-2">
			                        	<label class=" control-label"><input type="radio" onclick="validarProveedor();" name="ctetipo" id="ctetipo" value="0" /> Proveedor</label>
			                      	</div>
                      				<div class="form-group col-xs-2">
                              			<label class=" control-label"><input type="radio" onclick="validarProveedor();" name="ctetipo" id="ctetipo3" value="1" /> Integrador</label>
                      				</div>
                      				<div class="form-group col-xs-4">
                              			<label class=" control-label"><input type="radio" onclick="validarProveedor();" name="ctetipo" id="ctetipo4" value="1" /> Proveedor de Servicio Pago con Tarjeta</label>
                      				</div>
                  				</div>

                  				<div class="form-group col-xs-12" id="div_tipos" style="display: none;">
			                  		<div class="form-group col-xs-4">
			                        	<label class=" control-label">
			                        		<input type="radio" name="tipo" onclick="validarTipo();" id="radio_venta_servicios" value="0" > Venta de Servicios
			                        	</label>
			                      	</div>
                      				<div class="form-group col-xs-4">
                              			<label class=" control-label">
                              				<input type="radio" name="tipo"  onclick="validarTipo();" id="radio_recarga" value="1" > Compra de Tiempo Aire
                              			</label>
                      				</div>
                  				</div>

							</div>
							<div class="well" id="datos_generales">
								<div class="form-group col-xs-8">
			                    	<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4><input type="hidden" name="tipoProceso" id="tipoProceso" />
			                  	</div>

                  				


				                <div class="form-group col-xs-12">
				                    <div class="form-group col-xs-3" id="div-rfc">
				                        <label class="control-label">RFC: </label>
				                       <input type="hidden" id="p_proveedor" name="p_proveedor" value='<?php echo $parametro_proveedor;?>' >
										<input type="text" id="rfc" class='form-control m-bot15' maxlength="12" onkeyup="RFCFormato();" onkeypress="RFCFormato();" onblur="RFCFormato(this.value);">
									</div>
				                    <div class="form-group col-xs-3">
				                        <label class="control-label">Razón Social: </label>
										<input type="text" id="razonSocial" class='form-control m-bot15' style="text-transform: uppercase;" onkeyup="Clonar()">
									</div>
				                    <div class="form-group col-xs-3">
				                        <label class=" control-label">Nombre Comercial: </label>
										<input type="text" id="nombreComercial" class='form-control m-bot15' style="text-transform: uppercase;">
									</div>
									<div class="form-group col-xs-3">
				                        <label class=" control-label">Pais: </label>
								        <select class="form-control m-bot15" name="cmbpais" id="cmbpais">
								            <option value="-1">Seleccione</option>
								            <?php echo $htmlPais; ?>
								        </select>
				                    </div>
								</div>
								<div  class="form-group col-xs-12">
									<h4><span><i class="fa fa-map-marker"></i></span> Dirección</h4>
								</div>
								<div class="form-group col-xs-12">
					            	<input type="hidden" name="idDireccion" id="idDireccion" value="0">
					                <input type="hidden" name="origen" id="origen" value="0" />
					                <div class="form-group col-xs-6">
					                    <label class=" control-label">Calle: </label>
					                    <input type="text" class="form-control m-bot15" name="calleDireccion" id="txtCalle" style="text-transform: uppercase;">
					                </div>
					                <div class="form-group col-xs-2">
					                    <label class=" control-label">Número Exterior: </label>
					                    <input type="text" class="form-control m-bot15" id="ext" name="numeroExtDireccion" style="text-transform: uppercase;">
					                </div>
					                <div class="form-group col-xs-2">
					                    <label class=" control-label">Número Interior: </label>
					                    <input type="text" id="int" class="form-control m-bot15" name="numeroIntDireccion" style="text-transform: uppercase;">
					                </div>
					                <div class="form-group col-xs-2">
					                    <label class=" control-label">Código Postal: </label>
					                    <input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCP" onkeyup="buscar_cp(event)">
					                </div>
								</div>
				     			<div class="form-group col-xs-12" id="divDirext" style="display:none">
									<div class="form-group col-xs-4	">
				                        <label class=" control-label">Colonia: </label>
				                        <input type="text" class="form-control m-bot15" name="cpDireccion" id="txtColonia" style="text-transform: uppercase;">
									</div>
									<div class="form-group col-xs-4	">
				                        <label class=" control-label">Ciudad: </label>
				                        <input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCiudad" style="text-transform: uppercase;">
									</div>
									<div class="form-group col-xs-4	">
				                       	<label class=" control-label">Estado: </label>
				                    	<input type="text" class="form-control m-bot15" name="cpDireccion" id="txtEstado" style="text-transform: uppercase;">
									</div>
								</div>
								<div class="form-group col-xs-12" id="divDirnac">
									<div class="form-group col-xs-3	">
				                        <label class=" control-label">Colonia: </label>
				                            <select class="form-control m-bot15" name="idcColonia" id="cmbColonia">
				                                <option value="-1">Seleccione</option>
				                            </select>
									</div>
									<div class="form-group col-xs-3	">
				                        <label class=" control-label">Ciudad: </label>
				                        <select class="form-control m-bot15" name="idcMunicipio" id="cmbCiudad">
				                    	    <option value="-1">Seleccione</option>
				                        </select>
									</div>
									<div class="form-group col-xs-3">
				                        <label class=" control-label">Estado: </label>
				                        <select class="form-control m-bot15" name="idcEntidad" id="cmbEntidad">
				                            <option value="-1">Seleccione</option>
				                        </select>
									</div>
								</div>
				            </div>
						</div>
						<!--Representate legal-->
						<div class="panel-body" id="div_representante_legal">
							<div class="well">
				                <div class="form-group col-xs-8">
				                	<input type="hidden" id="usuario_logueado" name="usuario_logueado" value="<?php echo $usuario_logueado;?>" >
				                   	<h4><span><i class="fa fa-asterisk"></i></span>Representante Legal</h4>
				                </div>
				                <div class="form-group col-xs-12">
				                	<div class="form-group col-xs-6">
				                		<label class=" control-label">Nombre: </label>
				                		<input type="text" class="form-control m-bot15" name="" id="representante_legal" style="text-transform: uppercase;">
				            		</div>
				            		<div class="form-group col-xs-3">
				            			<label class="control-label">Identificación</label>
				            			<select class="form-control" id="cmbIdentificacion">
				            				<option value="0">Seleccione</option>
				            				<option value="1">INE</option>
				            				<option value="2">Pasaporte</option>
				            				<option value="3">Licencia de Conducir</option>
				            			</select>
				            		</div>
				            		<div class="form-group col-xs-3">
				            			<label class="control-label">No. Indentificación</label>
				            			<input type="text" class="form-control" name="" id="numeroIdentificacion" style="text-transform: uppercase;">
				            		</div>
				            	</div>
				            </div>
			        	</div>
			        	<div class="panel-body" id="div_datos_bancarios">
			        		<div class="well">
			        			<div class="form-group col-xs-12" id="div_titulo_datos_bancarios_proveedor">
                                    <div>
                                        <h4><span><i class="fa fa-credit-card"></i></span> Datos Bancarios Proveedor</h4>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12" div="datos_bancarios_proveedor">
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">CLABE Interbancaria: </label>
                                        <input type="text" id="clabe" class='form-control m-bot15' onkeyup="analizarCLABE();" onkeypress="analizarCLABE();">
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label class=" control-label">Banco</label>
                                        <input type="text" id="nombreBanco" class='form-control m-bot15' maxlength="18" disabled="">
                                        <input type="hidden" name="banco" id="banco" />
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">Referencia alfanumérica</label>
                                        <input type="text" name="referenciaAlfa" id="referenciaAlfa" class='form-control m-bot15' maxlength="18"  style="text-transform: uppercase;">
                                        <input type="hidden" name="cuentaContable" id="cuentaContable" class='form-control m-bot15' maxlength="15">
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">Beneficiario</label>
                                        <input type="text" name="beneficiario_DB" id="beneficiario_DB" class='form-control m-bot15' disabled="disabled" maxlength="18" style="text-transform: uppercase;">
                                    </div>
                                </div>


                                <div class="form-group col-xs-12">
                                    <div id="div_titulo_datos_bancarios_red" style="display: none;">
                                        <h4><span><i class="fa fa-credit-card"></i></span> Datos Bancarios Red Efectiva</h4>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12" id="datos_bancarios_red" style="display: none;">
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">CLABE Interbancaria: </label>
                                        <input type="text" id="clabered" class='form-control m-bot15' onkeyup="analizarCLABEred();" onkeypress="analizarCLABEred();">
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label class=" control-label">Banco</label>
                                        <input type="text" id="nombreBancored" class='form-control m-bot15' maxlength="18" disabled="">
                                        <input type="hidden" name="bancored" id="bancored" />
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">Referencia alfanumérica</label>
                                        <input type="text" name="referenciaAlfared" id="referenciaAlfared" class='form-control m-bot15' maxlength="18"  style="text-transform: uppercase;">
                                        <input type="hidden" name="cuentaContablered" id="cuentaContablered" class='form-control m-bot15' maxlength="15">
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">Beneficiario</label>
                                        <input type="text" name="beneficiario_DBred" id="beneficiario_DBred" class='form-control m-bot15' disabled="disabled" maxlength="18" style="text-transform: uppercase;">
                                    </div>
                                </div>
			        		</div>
			        	</div>
						<!--Documentos-->
						<div class="panel-body" id="div_documentos">
                            <div class="well">
                                <div style="margin-bottom:30px;" class="form-group col-xs-9">
                                    <h4><span><i class="fa fa-gear"></i></span> Documentos</h4>
                                </div>
                                 <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Comprobante de Domicilio:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                        		<input type="file" class="hidess" style="" name="sFile" id="txtFile" idtipodoc="3">
                                            	<input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="3">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                    	<input type="hidden" name="" id="urlDomicilio">
                                        <input origen="emisor" type="button" id="file_Domicilio"  value="Ver Comprobante" idtipodoc="3" onclick="verdocumento(this.id);" class ="btnfiles">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Documento RFC:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                            <input type="file" class="hidess" style="" name="documento_rfc" id="documento_rfc" idtipodoc="2">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="2">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                    	<input type="hidden" name="" id="urlRFC">
                                        <input origen="emisor" type="button" id="file_Rfc"  value="Ver Comprobante" idtipodoc="2" onclick="verdocumento(this.id);" class ="btnfiles">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Acta Constitutiva:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                             <input type="file" class="hidess" style="" name="acta_constitutiva" id="acta_constitutiva" idtipodoc="1">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="1">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                    	<input type="hidden" name="" id="urlActa">
                                        <input origen="emisor" type="button" id="file_Acta"  value="Ver Comprobante" idtipodoc="1" onclick="verdocumento(this.id);" class ="btnfiles">
                                    </div>
                                </div>
                                 <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Poder Legal:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                             <input type="file" class="hidess" style="" name="poder_legal" id="poder_legal" idtipodoc="4">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="4">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                    	<input type="hidden" name="" id="urlPoder">
                                        <input origen="emisor" type="button" id="file_Poder"  value="Ver Comprobante"  idtipodoc="4" onclick="verdocumento(this.id);" class ="btnfiles">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> ID Representatante Legal:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                             <input type="file" class="hidess" style="" name="id_representante_legal" id="id_representante_legal" idtipodoc="5">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="5">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                    	<input type="hidden" name="" id="urlRepre">
                                        <input origen="emisor" type="button" id="file_Repre"  value="Ver Comprobante"  idtipodoc="5" onclick="verdocumento(this.id);" class ="btnfiles">
                                    </div>
                                </div>

                                <div class="form-group col-xs-12" id="div_contrato" style="display: none">
                                    <div class="col-xs-5">
                                         <label class=""> Contrato:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                             <input type="file" class="hidess" style="" name="contrato" id="contrato" idtipodoc="5">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="6">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                    	<input type="hidden" name="" id="urlContrato">
                                        <input origen="emisor" type="button" id="file_Contrato"  value="Ver Comprobante"  idtipodoc="5" onclick="verdocumento(this.id);" class ="btnfiles">
                                    </div>
                                </div>
                            </div>       
                        </div>
                        <!--Productos-->
                        <!-- <div class="panel-body" id="div_productos">
                            <div class="well">
                                <div style="margin-bottom:30px;" class="form-group col-xs-9">
                                    <h4><span><i class="fa fa-gear"></i></span> Productos</h4>
                                </div>
                                 <div class="form-group col-xs-12">
                                 	<table class="table" id="tabla_listaProductos">
                                	<thead>
							            <tr>
							              <th style="text-align: center;">Familia</th>
							              <th style="text-align: center;">SubFamilia</th>
							              <th style="text-align: center;">Producto</th>
							              <th style="text-align: center;">Importe</th>
							              <th style="text-align: center;"><input type="checkbox" name="tipo_descuento" value="Porcentaje">%  Descuento</th>
							              <th style="text-align: center;">Importe sin descuento</th>
							              <th style="text-align: center;">Importe sin IVA</th>
							              <th style="text-align: center;"></th>
							            </tr>
							          </thead>
                                	<tr id="lista_productos_0">
                                		<td><select class="form-control" id="select_familia"  name="select_familia" onchange="BuscarSubFamilias(this.value)">
                                    			<option value="-1">Seleccione</option>
                                    		</select>
                                    	</td>
                                		<td><select class="form-control" id="select_subfamilia" name="select_subfamilia" onchange="BuscarProductos(this.value)">
                                    			<option value="-1">Seleccione</option>
                                    		</select>
                                    	</td>
                                		<td><select class="form-control"  id="select_productos">
	                                 			<option value="-1">Seleccione</option>
	                                 		</select>
	                                 	</td>
			                         	<td><input class="form-control" type="text" name="importe_0" id="importe_0"></td>
			                         	<td><input class="form-control" type="text" name="descuento_0" id="descuento_0"></td>
			                         	<td><input class="form-control" type="text" name="importesindescuento_0" id="importesindescuento_0"></td>
			                         	<td><input class="form-control" type="text" name="importesiniva_0" id="importesiniva_0"></td>
                                		<td><button id="filaProducto_0" class="add_button btn btn-sm btn-default" onclick="agregarListaProductos(this.id);">
                                 		 	<i class="fa fa-plus-circle" aria-hidden="true"></i>
			                             </button>
			                         	</td>
                                	</tr>
                                </table>
                                </div>
                            </div>       
                        </div> -->
                        <!--Liquidación-->
                        <div class="panel-body" id="div_liquidacion">
                            <div class="well">
                                <div style="margin-bottom:30px;" class="form-group col-xs-9">
                                    <h4 id="h4_liquidacion"><span><i class="fa fa-gear"></i></span> Liquidación</h4>
                                </div>

                               


                  				<div class="form-group col-xs-12" id="div_subtipos" style="display: none;">

			                  		<div class="form-group col-xs-4">
			                        	<label class=" control-label">
			                        		<input type="radio" name="subtipo" onclick="validarSubTipo();" id="radio_prepago" value="0" > Prepago
			                        	</label>
			                      	</div>
                      				<div class="form-group col-xs-4">
                              			<label class=" control-label">
                              				<input type="radio" name="subtipo"  onclick="validarSubTipo();" id="radio_credito" value="1" > Credito
                              			</label>
                      				</div>
                  				</div>


                  				<div class="form-group col-xs-12" id="div_opciones_credito" style="display: none;">

			                  		<div class="form-group col-xs-4">
			                        	<label class=" control-label">Cantidad de Credito</label>
			                        	<input type="text" id="monto_credito"  name="monto_credito" class="form-control">
			                      	</div>
                      				<div class="form-group col-xs-4">
                              			<label class=" control-label">Tipo</label>
                              			<select id="select_tipo_credito" class="form-control">
                              				<option value="1">Solo Factura</option>
                              				<option value="2">Factura y Nota de Credito</option>
                              			</select>
                      				</div>

                                <div style="margin-bottom:30px;" class="form-group col-xs-9">
                                    <!-- <h4><span><i class="fa fa-bank"></i></span> Cuentas Contables por Producto</h4> -->
                                    <!-- <h4>Cuentas Contables por Producto</h4> -->
                                </div>
                                <table class="table" id="tabla_ccp">
                                	<thead>
							            <tr>
							              <th>Familia</th>
							              <th>SubFamilia</th>
							              <th>Producto</th>
							              <th>Cuenta Contable</th>
							              <th></th>
							            </tr>
							          </thead>
                                	<tr id="filaccp_0">
                                		<td>
                                			<select id="familiaccp_0" class="form-control" onchange="BuscarSubFamilias(this.value);">
                                			</select>
                                		</td>
                                		<td>
                                			<select id="subfamiliaccp_0" class="form-control" onchange="BuscarProductos(this.value);">
                                			</select>
                                		</td>
                                		<td>
                                			<select id="productoccp_0" class="form-control">
                                			</select>
                                		</td>
                                		<td>
                                			<input type="text" id="cuentacc_0" class="form-control m-bot15">
                                		</td>
			                         	<td>
			                         		<select id="select_credito_prepago_0" class="form-control">
			                         			<option value="1">Crédito</option>
			                         			<option value="2">Prepago</option>
			                         		</select>
			                         	</td>
			                         	<td>
			                         		<select id="select_comercio_0" class="form-control">
			                         		</select>
			                         	</td>
                                		<td>
                                			<button id="rowccp_0" class="add_button btn btn-sm btn-default" onclick="agregarFilaCCP(this.id);">
                                 		 		<i class="fa fa-plus-circle" aria-hidden="true"></i>
			                             	</button>
			                         	</td>
                                	</tr>
                                </table>      


                  				</div>


                                <div class="form-group col-xs-12" id="div_liq1" style="display: none;">
                                 	<div class="col-xs-2" id="div_pagaran_comisiones">
                             			<label>Pagaran Comisiones</label>
                                 		<select id="pagan_comisiones" class="form-control">
                                 			<option value="1">Si</option>
                                 			<option value="2">No</option>
                                 		</select>
                                 	</div>
                                 	<div class="col-xs-2" id="div_cobran_comision">
                                 		<label>Cobraran Comision</label>
                                    	<select class="form-control" id="cobran_comision" name="cobran_comision">
                                    		<option value="1">Si</option>
                                    		<option value="2">No</option>
                                    	</select>
                                    </div>
                                    <div class="col-xs-3" id="div_forma_pago_liquidacion">
                                 	<label>Forma Pago Liquidacion</label>
                                    	<select class="form-control" id="pago_liquidacion" name="pago_liquidacion">
                                    		<option value="1">Total. (Total de Operaciones)</option>
                                    		<option value="2">Neto. (Total de Operaciones menos la comision)</option>
                                    	</select>
                                    </div>                                    
                                    <div class="col-xs-3" id="div_tipo_liquidacion">
                                 		<label>Tipo de Liquidacion</label>
                                 		<select id="dias_liquidacion" class="form-control">
                                 			<option value="-1">Seleccione</option>
                                 			<option value="1">T+ndias </option>
                                 			<option value="2">Por periodos</option>
                                 			<option value="3">Prepago</option>
                                 			<option value="4">Especial</option>
                                 		</select>
                                 	</div>  
                                 	<div id="div_tiempo_liquidacion"class="col-xs-2" style="display: none">
                                 		<label>Tiempo para Liquidar</label>
                                 		<input type="text" name="" value="0"class="form-control m-bot15" id="tiempo_liquidacion">
                                    </div>                               	 
                                 	<div id="divTndias" style="display:none;margin-top:90px;">
                                 		<div class="col-xs-3 col-xs-offset-4">
                                 			<center><label>T+n dias</label></center>
                                 			<input type="text" id="tn_dias" class="form-control m-bot15">
                                    	</div>                                     
                                 	</div>	
                                 	<div id="divporperiodos" style="display:none;margin-top:90px;">
                                 		<center><label>Por periodos</label></center>
                                 		<div style="text-align:center;">
                                 		<table style="margin: 0 auto;">
                                 			<?php 
                                 			$semana = array ("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
                                 			for ($i=0; $i < 5; $i++) { 
                                 				if($i==0){
                                 					$dia="Lu_Check";	
                                 				}
                                 				if($i==1){
                                 					$dia="Ma_Check";	
                                 				}
                                 				if($i==2){
                                 					$dia="Mi_Check";	
                                 				}
                                 				if($i==3){
                                 					$dia="Ju_Check";	
                                 				}
                                 				if($i==4){
                                 					$dia="Vi_Check";	
                                 				}
                                 				
                                 			?>
											<tr>
												<td rowspan="2">
													<input type="text" class="form-control m-bot15" style="text-align: center;" id="" valorConfig="$i" value="<?php echo $semana[$i]?>" disabled>
												</td>
												<td width="20">L</td><td width="20">M</td><td width="20">M</td><td width="20">J</td><td width="20">V</td><td width="20">S</td><td width="20">D</td>	
											</tr>
											<tr>
												<td><input type="checkbox" id="0" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this.id)"></td>
												<td><input type="checkbox" id="1" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this.id)"></td>
												<td><input type="checkbox" id="2" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this.id)"></td>
												<td><input type="checkbox" id="3" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this.id)"></td>
												<td><input type="checkbox" id="4" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this.id)"></td>
												<td><input type="checkbox" id="5" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this.id)"></td>
												<td><input type="checkbox" id="6" value="0" class="<?php echo $dia; ?>" onclick="validarCantidad(this.id)"></td>
											</tr>
											<?php } ?>
										</table></div>                           
                                 	</div>
                                 			<div class="row" id="divEspecial" style="display:none;margin-top:90px;">
                                 				<div class="col-md-12">
                                 					<div class="col-md-3"><label></label></div>
                                 					<div class="col-md-3">
                                 						<center><label> Dia Fecha Pago</label></center><br>
			                                 			<select class="form-control" id="especial_select_dias">
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
                                 						<input type="number" min="0" max="31" maxlength="2" id="especial_dias" onkeyup="validarMinMax(this.id);" class="form-control m-bot15">
                                 					</div>
                                 					<div class="col-md-2"><label></label></div>
                                 				</div>
                                 			</div>
                                </div>
                                <div class="form-group col-xs-12" style="display: none;" id="div_bancos_preferentes">
                                	<div style="margin-bottom:30px;" class="form-group col-xs-9">
                                	</div>
				                    <div class="form-group col-xs-12" id="div_tabla_bancos"><br><br>
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
								</div>

								<div class="form-group col-xs-12" style="display: none;" id="div_bancos_otros">
									<div class="form-group col-xs-12">
				                        <label class="control-label">Otros Bancos: </label>
									</div>
				                    <div class="form-group col-xs-3">
				                        <label class="control-label">Tipo: </label>
										<select class="form-control" id="select_tipo_cuota_otros">
                        					<option value="1">Credito</option>
                        					<option value="2">Debito</option>
                                		</select>
									</div>
				                    <div class="form-group col-xs-3">
				                        <label class=" control-label">Porcentaje: </label>
										<input type="text" name="porcentaje_banco_otros" id="porcentaje_banco_otros" class="form-control">
									</div>
								</div>

								<div class="form-group col-xs-12" style="display: none;" id="div_bancos_amex">
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

								<div class="form-group col-xs-12" style="display: none;" id="div_fondo_reserva">
									<br>
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
                                	 	<label class="control-label">Periocidad para recibir facturas</label>
                                	 		<select id="periodicidad_ppt" class="form-control">
                                	 			<option value="1">Diario</option>
                                	 			<option value="2">Semanal</option>
                                	 			<option value="3">Quincenal</option>
                                	 			<option value="4">Mensual</option>
                                	 		</select>
									 	</div>
                                	 </div>
				                   
				                    
								</div>

                                <div class="form-group col-xs-12" style="margin-top:20px;display: none;" id="div_liq2">
                                	<label><h5>Comisión por Operaciones</h5></label>
                                </div>
                                <div class="form-group col-xs-12" id="div_liq3" style="display: none;">
                                	<!-- <div class="form-group col-xs-2">
                                        <label class="control-label"><input type="radio" name="radcom" id="radio_importe" value="1" onclick="cambiacomtip(this.value)"/> Importe: </label>
                                        <input type="text" id="comision" value="0" class='form-control m-bot15' disabled>
                                    </div>
                                    <div class="form-group col-xs-2">
                                        <label class=" control-label">
                                        	<input type="radio" name="radcom" id="radio_porcentaje" value="2" onclick="cambiacomtip(this.value)"/> Porcentaje: 
                                        </label>
                                    	<input type="text" id="porcentajeComision" value="0" class='form-control m-bot15' disabled>
                                    </div> -->
                                    <div class="form-group col-xs-2" id="div_retencion" style="display: none;">
                                        <label class="control-label">Retención: </label>
                                        <select class="form-control m-bot15" name="retencion" id="retencion">
                                            <option value="-1">Seleccione</option>
                                            <option value="1">Sin Retención</option>
                                            <option value="2">Con Retención</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-7" id="divCorreosNotificaciones" style="display: none;">
                                   		<label>Correos a enviar notificaciones de liquidacion:</label>
										<div class="row field_wrapper" id="">
			                                <div class="col-xs-12">
			                                    <input type="text" id="nuevocorreonotificaciones" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
			                                    <button id="btnCorreoNotificaciones" class="add_button btn btn-sm btn-default" onclick="agregarCorreoNotificaciones();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
			                                    </button>
			                                </div>
                                        </div>
		                                <div class="row field_wrapper" id="contenedordecorreosliquidacion"></div> 
									</div>
                                <div class="form-group col-xs-12" style="margin-top:20px;display: none;" id="div_liq4">                                	 
                                 	<label><h5>Comisón por Transferencia</h5></label>
                                </div>
                                <div class="form-group col-xs-12" id="div_liq5" style="display: none;">
                                    <div class="form-group col-xs-12" >
                                        <label class="control-label"><input type="checkbox" id="monto_transferencia" value="1" class='m-bot15' onclick="habilitar_transferencia(this);">¿Se cobrará monto por Transferencia? </label>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12" id="divcobtrans" style="display:none;"><!-- facturas-->
									<div class="form-group col-xs-3">
										<label class="control-label" >Costo  por Transferencia: </label>
										<input type="text" id="txtcostotrans" value="0" class='form-control m-bot15' disabled>
									</div>
                                </div>   
                                <div class="form-group col-xs-12" style="margin-top:30px;display: none;" id="div_liq6">                                	
                                 	<label><h5>Comisón al Usuario</h5></label>
                                </div>
                                <div class="form-group col-xs-3" id="div_liq7" style="display: none;">
                                	<div class="row"><label class="control-label"><input type="checkbox" id="comision_usuario" value="1" class='m-bot15' step="any" onclick="habilitar_com_usuario(this);">  ¿Se cobrará comision al usuario? </label></div>
                                	<div class="row"><label></label></div>
                                	<div class="row" id="div_comision_usuario" style="display: none;">
                                		<label class="control-label" >Costo Comison incluyendo IVA : </label>
										<input type="text" id="txtcostocom" value="0" class='form-control m-bot15' disabled>
										<label class="control-label" >IVA Comison: </label>
										<select class="form-control" id="iva_comision">
											<option value="-1">Seleccione...</option>
											<option value="1">16%</option>                                    		
                                    		<option value="2">8%</option>
                                    		<option value="3">0%</option>	
										</select>
									</div>
                                </div>
                                <div class="form-group col-xs-1">
                                	<div class="row"><label></label></div>
                                	<div class="row"><label></label></div>
                                	<div class="row"><label></label></div>
                                </div>
                                <div class="form-group col-xs-4" id="div_liq8" style="display: none;">
                                	<div class="row"><label class="control-label"><input type="checkbox" id="cargo_usuario" value="1" class='m-bot15' step="any" onclick="habilitar_cargo_usuario(this);">  ¿Se cobrará cargo por servicio al usuario? </label></div>
                                	<div class="row"><label></label></div>
                                	<div class="row" id="div_cargo_servicio" style="display: none;">
                                		<label class="control-label" >Cargo por Servicio incluyendo IVA : </label>
										<input type="text" id="txtcargoserv" value="0" class='form-control m-bot15' disabled>
										<label class="control-label" >IVA Cargo: </label>
										<select class="form-control" id="iva_cargo">
											<option value="-1">Seleccione...</option>
											<option value="1">16%</option>                                    		
                                    		<option value="2">8%</option>
                                    		<option value="3">0%</option>	
										</select>
									</div>
                                </div>
                            </div>       
                        </div>
                        <!--facturación-->	
						<div class="panel-body" id="datos_facturacion">
                            <div class="well">



                            	<div style="margin-bottom:30px;" class="form-group col-xs-9">
                                	<h4><span><i class="fa fa-gear"></i></span> Datos Facturación</h4>
                                </div>

                                <div class="form-group col-xs-12" id="div_cobro_pago_transfer" style="display: none;">
                                	<div class="col-xs-4">
	                                	<input type="checkbox" id="cobran_pago_transferencia" onclick="habilitarDivMontoCobroPagoTransfer();" value="1" class='m-bot15'>&nbsp;&nbsp;<label>Proveedor Cobra Pago por Transferencia:</label><br><br>

	                                	<label id="label_mpt" style="display: none;">Monto Pago Transferencia</label>
	                                	<input type="text" style="display: none;" name="monto_pago_transferencia" id="monto_pago_transferencia" class="form-control"><br><br>
                                	</div>
                               	</div>
                                <div class="form-group col-xs-4">
                                	<label>IVA de Facturación:</label>
                                    <select class="form-control" id="ivaFactura">
                                    	<option value="1">16%</option>                                    		
                                    	<option value="2">8%</option>
                                    	<option value="3">0%</option>		
                                    </select>
                               	</div>
                                <div class="well" style="padding-right: 0px;padding-left: 0px;" id="factura_comision">                                  
                                   	<div class="form-group col-xs-12">
                                   		<label class="control-label"><strong>Factura por Comisión</strong></label>
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
                                   		<label>Periocidad de facturación:</label>
                                   		<select class="form-control" id="periocidadComision">
                                   			<option value="1">Semanal</option>
                                   			<option value="2">Quincenal</option>
                                   			<option value="3">Mensual</option>
                                   		</select>
                                   	</div>
                                   	<div class="form-group col-xs-4">
                                   		<label>Días para liquidar la factura:</label>
                                   		<input class="form-control" type="text" id="diasLiquidacionComision">
                                   	</div>
                                   	<div class="col-xs-7" id="divCorreosFacturaComision">
                                   		<label>Correos a enviar la factura:</label>
										<div class="row field_wrapper" id="contenedordecorreosfacturas">
			                                <div class="col-xs-12">
			                                    <input type="text" id="nuevocorreofacturasComision" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
			                                    <button id="btnCorreoFacturasComision" class="add_button btn btn-sm btn-default" onclick="agrergarcorreosfacturasComision();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
			                                    </button>
			                                </div>
                                        </div>
		                                <div class="row field_wrapper" id="contenedordecorreosfacturasComision"></div> 
									</div>
								</div>
                                </div>
                                <div class="well" style="padding-right: 0px;padding-left: 0px;" id="div_factura_comision_transferencia">                                  
                                    <div class="form-group col-xs-12">
                                     	<label class="control-label"><strong>Factura Comisión por Transferencia</strong></label>
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
                                    	<label>Periocidad de facturación:</label>
                                    	<select class="form-control" id="periocidadTransferencia">
                                    		<option value="1">Semanal</option>
                                    		<option value="2">Quincenal</option>
                                    		<option value="3">Mensual</option>
                                    	</select>
                                    </div>
                                    <div class="form-group col-xs-4">
                                    	<label>Días para liquidar la factura:</label>
                                    	<input class="form-control" type="text" id="diasLiquidacionTransferencia">
                                    </div>
                                    <div class="col-xs-7" id="divCorreosFacturaTransferencia">
                                    	<label>Correos a enviar la factura:</label>
										<div class="row field_wrapper" id="contenedordecorreosfacturas">
			                                <div class="col-xs-12">
			                                    <input type="text" id="nuevocorreofacturasTransferencia" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
			                                    <button id="btnCorreoFacturas" class="add_button btn btn-sm btn-default" onclick="agrergarcorreosfacturasTransferencia();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
			                                    </button>
			                                </div>
                                       	</div>
		                                <div class="row field_wrapper" id="contenedordecorreosfacturasTransferencia"></div> 
									</div>
									</div>
                                </div>

                                <div class="well" style="padding-right: 0px;padding-left: 0px;display: none;" id="div_factura_pub_gral">                                  
                                    <div class="form-group col-xs-12">
                                     	<label class="control-label"><strong>Factura Publico en General</strong></label>
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
                                    	<label>Periocidad de facturación:</label>
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


                            </div>
                        </div> 
                        <!--Datos contables-->
                        <div class="panel-body" id="div_datos_contables">
                            <div class="well">
                                <div style="margin-bottom:30px;" class="form-group col-xs-9">
                                    <h4 id="h4_datos_contables"><span><i class="fa fa-gear"></i></span> Cuentas Contables</h4>
                                </div>
                                 <div class="form-group col-xs-12">
                                 	<div class="col-xs-3">
                                 		 <label>Cuenta Contable Ingresos</label>
                                 		<input type="text" id="cuenta_contable_ingresos" onkeyup="sinEspacios(this.id,event);"  class="form-control m-bot15" maxlength="16">
                                 	</div>
                                 	<div class="col-xs-3">
                                 		 <label>Cuenta Contable Costos</label>
                                 		<input type="text" id="cuenta_contable_costos" onkeyup="sinEspacios(this.id,event);" class="form-control m-bot15" maxlength="16">
                                 	</div>
                                 	<div class="col-xs-3">
                                 		 <label>Cuenta Contable del Proveedor</label>
                                 		<input type="text" id="cuenta_contable_proveedor"  onkeyup="sinEspacios(this.id,event);"class="form-control m-bot15" maxlength="16">
                                 	</div>
                                 	<div class="col-xs-3">
                                 		 <label>Cuenta Contable del Banco</label>
                                 		<input type="text" id="cuenta_contable_banco" onkeyup="sinEspacios(this.id,event);" class="form-control m-bot15" maxlength="16">
                                 	</div>
                                 	<div class="col-xs-3">
                                 		 <label>Cuenta Contable del Cliente</label>
                                 		<input type="text" id="cuenta_contable_cliente" onkeyup="sinEspacios(this.id,event);" class="form-control m-bot15" maxlength="16">
                                 	</div>
                                 	<div class="col-xs-3">
                                 		 <label>IVA Traslado por Cobrar</label>
                                 		<input type="text" id="cuenta_contable_iva_translado_por_cobrar" class="form-control m-bot15" maxlength="16">
                                 	</div>
                                 	<div class="col-xs-3">
                                 		 <label>IVA Acreditable por Pagar</label>
                                 		<input type="text" id="cuenta_contable_iva_acreditable_por_pagar" class="form-control m-bot15" maxlength="16">
                                 	</div>
                            	</div>
                            	<div class="form-group col-xs-12">
                            		<label>&nbsp;</label>
                            	</div>

                            	
                        	</div>       
                        </div>

                        <!--cuentas contables por producto -->
                        
                        <!--Time OUT-->
                        <div class="panel-body" id="div_time_out">
                            <div class="well">
                                <div style="margin-bottom:30px;" class="form-group col-xs-9">
                                    <h4><span><i class="fa fa-gear"></i></span> Time Out</h4>
                                </div>
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

                                  

                                <div class="form-group col-xs-12">
                                	<label>&nbsp;&nbsp;&nbsp;</label>
                                </div>
                                <div class="form-group col-xs-12">
                                	<label>&nbsp;&nbsp;&nbsp;</label>
                                </div>
                                <div class="form-group col-xs-12" id="timeout2" style="display: none;">
                                 	<div class="col-xs-3" id="div_tiempo_timeout2">
                                 		 <label>Tiempo de Time Out en Segundos</label>
                                 		<input type="text" id="tiempo_timeout2" maxlength="5" class="form-control m-bot15">
                                 	</div>
                                 	<div class="col-xs-3" id="div_vpn2">
                                 		 <label>VPN</label>
                                 		 <select id="select_vpn2" class="form-control">
                                 		 	<option value="1">SI</option>
                                 		 	<option value="2">NO</option>
                                 		 </select>
                                 	</div>
                                 	<div class="col-xs-3" id="div_vpn_pruebas2">
                                 		 <label>VPN Desarrollo/Pruebas</label>
                                 		 <select id="select_vpnDesPrue2" class="form-control">
                                 		 	<option value="si">SI</option>
                                 		 	<option value="no">NO</option>
                                 		 </select>
                                 	</div>
                                 	<div class="col-xs-3" id="div_metodo_envio2">
                                 		 <label>Metodo Envio</label>
                                 		 <select class="form-control m-bot15" name="cbnotif2" id="cbnotif2" onchange="ftpopt2(this.value)">
                                               <option value="0">Seleccione</option>
                                               <option value="1">Via FTP</option>
                                               <option value="2">Via SFTP</option>
                                               <option value="3">Via FTPS</option>
                                            </select>
                                 	</div>
                                </div>
                                <div  style="display: none;" id="datosFtp2">
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Host: </label>
                                            <input type="text" id="host2" class='form-control m-bot15' step="any">
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Puerto: </label>
                                            <input type="text" id="port2" class='form-control m-bot15'>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Usuario: </label>
                                            <input type="text" id="user2" class='form-control m-bot15'>
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Password: </label>
                                            <input type="text" id="password2" class='form-control m-bot15' step="any">
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">Path de folder remoto: </label>
                                            <input type="text" id="remoteFolder2" class='form-control m-bot15'>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                    	<div class="row" style="display: none;" id="confcorreos2">
	                                     <label style="margin-left: 15px; margin-top: 15px; text-align:center" class="col-xs-12 control-label"></label>
	                                     
	                                    <div id="formCorreos2"  style="margin-left: 30px; margin-top: 15px;">
	                                       <label class=" control-label">Correos: </label>
	                                            <div class="row field_wrapper" id="contenedordecorreos2">
	                                                <div class="col-xs-12">
	                                                    <input type="text" id="nuevocorreo2" class="form-control m-bot15" name="correos" style="width: 300px; display:inline-block;">
	                                                    <button id="nuevoCorreo2" class="add_button btn btn-sm btn-default" onclick="agregarcorreosTimeOut2();">  <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
	                                                </div>
	                                            </div>
	                                            <div class="row field_wrapper" id="contenedordecorreos2">
	                                            </div>
	                                    </div>
                                		</div>
                                    </div>
                                </div>
                            </div>       
                        </div>
                        <!--matriz de escalamiento-->
                        <div class="panel-body" id="div_matriz_escalamiento">
                            <div class="well">
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
                                		<td><input type="text" id="departamento_0" class="form-control m-bot15"></td>
                                		<td><input type="text" id="nombre_0" class="form-control m-bot15"></td>
                                		<td><input type="text" id="puesto_0" class="form-control m-bot15"></td>
                                		<td><input type="text" id="telefono_0" maxlength="12" class="form-control m-bot15 telefono"></td>
                                		<td><input type="text" id="correo_0" class="form-control m-bot15"></td>
                                		<td><button id="row_0" class="add_button btn btn-sm btn-default" onclick="agregarFila(this.id);">
                                 		 	<i class="fa fa-plus-circle" aria-hidden="true"></i>
			                             </button></td>
                                	</tr>
                                </table>
                            </div>       
                        </div>
                        <!--Guardar información-->
                        <div class="row" id="div_guardar">
                            <div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
                                <button class="btn btn-xs btn-info "  onclick="guardarProveedor();" id="guardarE" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;"> Guardar </button>
                                <button class="btn btn-xs btn-info pull-right" id="guardarCE" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;display:none" onclick="actualizarEmisor()"> Guardar Cambios</button>
                            </div>
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
						<span><i class="fa fa-lightbulb-o" style="font-size:18px"></i>  Información de Ayuda</span>
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
																		<p><b>Via WebService</b> : El emisor integra el webservice para generar referencias de 	30 posiciones.</p>
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
		      	<div class="modal-body" >
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
        <embed src="" frameborder="0" width="100%" height="400px" id="embertoIn">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
		<!--*.JS Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script> -->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->
		<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
		<!--Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/paycash/ajax/pdfobject.js"></script>
        <!--Autocomplete -->
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.core.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.widget.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.position.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.menu.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.autocomplete.js"></script>	
        <script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/js/codigo_postal.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/js/consulta.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.inputmask.bundle.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/js/afiliacionProveedor.js"></script>
		<script type="text/javascript">
			initViewAltaProveedor();			 
		</script>
		<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
		<link href="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">
		<script type="text/javascript">
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			$('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
            }).on('changeDate', function(e) {
            	var fecha = $("#fecha_entrada_vigor").val();
            	var partes = fecha.split("/");
            	var aniosExtra=20;
			    var dia = partes[0];
			    var mes = partes[1];
			    var anio = partes[2];
			    var anioS = parseInt(anio) + parseInt(aniosExtra);
			    var fsv =dia+"/"+mes+"/"+anioS;
			    $("#fecha_salida_vigor").val(fsv);
            });
		</script>
	</body>
</html>