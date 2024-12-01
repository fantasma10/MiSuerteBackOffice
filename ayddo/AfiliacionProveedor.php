<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/afiliacion/application/models/Cat_pais.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Proveedor";
$usuario = $_SESSION['idU'];
$tipoDePagina = "mixto";
$idOpcion = 197;

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

/*$r_nIdTipoCliente=(isset($_REQUEST['nIdTipoCliente']))?$_REQUEST['nIdTipoCliente']:5;
$r_stringEntidad=($r_nIdTipoCliente==3)?"Integrador":"Emisor";fer*/


$IdProveedor = (isset($_POST['p_IdProveedor']))?$_POST['p_IdProveedor']:0;


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

	<!-- Autocomplete -->
  <link href="../../css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<style>
		.ui-autocomplete {
			max-height	: 190px;
			overflow-y	: auto;
			overflow-x	: hidden;
			font-size	: 12px;
			background-color: white;
	  }

		.ui-helper-hidden-accessible, .inps{
			display:none;
		}

		.chkbx{
			/*width:80px;*/
			text-align: center;
			text-align: center;
			margin-right: 5px;
		}

		checkbox{
			width: 10px;
	    height: 10px;
	  }

		#pdfvisor{
			display:none;
			height: 100%;
			width: 100%;
			position:fixed;
			background-color: rgba(255, 255, 255, 0.55);
			z-index: 1500;
		}

		#divpdf{
			height:650px;
			width:70%;
			background-color:#e6e6e8;
		}

		#divclosepdf{
			width:70%;
			text-align: right;
		}

		#closepdf{
			color:red;
			font-size:20px;
			font-weight: bold;
			cursor: pointer;
		}
	  label, h4{
			color:#19204b;
			/*font-weight: bold;*/
		}

		.well{
			background-color: #f8f8f8;
		}

		input{
			background-color: #ffffff;
		}

		#tlbconf th{
			font-weight: bolder;
			color:darkblue;
			font-size: 14px;
		}

		#tlbconf tr{
			height:20px
		}

		#tlbconf tr:nth-child(even){
			background-color: #e8f1ff;
			color: #fff;
		}

		#tlbconf th{
			text-align: center;
		}
		#tlbconf td{
			text-align: center;
		}
</style>

</head>
		<!--Include Cuerpo, Contenedor y Cabecera-->
		<?php include($PATH_PRINCIPAL."/inc/cabecera2.php"); ?>
		<!--Fin de la Cabecera-->
		<!--Inicio del Menú Vertical-->
		<!--Función "Include" del Menú-->
		<?php include($PATH_PRINCIPAL."/inc/menu.php"); ?>
		<!--Final del Menú Vertical-->
		<!--Contenido Principal del Sitio-->

 <div id="pdfvisor">
	 <center>
		 <div id="divclosepdf" ><span id="closepdf" title="Cerrar PDF">X</span></div>
        <div id="divpdf">
            <object id="pdfdata" data="" type="application/pdf" width="100%" height="100%"></object>
        </div>
    </center>
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
                            <span class="rev-combo pull-right">Afiliación <br>de  Proveedor</span>
                        </div>
					<div class="panel">
						<div class="panel-body">
                                <div class="form-group col-xs-12" id="divedit" >
                                            <div class="form-group col-xs-2" style="">
                                                <button class="btn btn-xs btn-info " id="btnback" style="margin-top:20px;" >Regresar </button>
                                            </div>
                                            <div class="form-group col-xs-8" style="padding-top:0px;">
                                                        <div class="form-group col-xs-12" style="padding-top:0px;" id="tokendiv" >
                                                                    <div id="divIdProveedor">
                                                                    <div class="form-group col-xs-4" style="padding-top:0px;">

                                                                        <label class="control-label">Id Acceso: </label>
                                                                        <input type="text" id="p_IdProveedor" class='form-control m-bot15' maxlength="12" disabled>
                                                                    </div>
                                                                    </div>
                                                                    <div class="form-group col-xs-8" style="padding-top:0px;    ">
                                                                        <label class="control-label">Token: </label>
                                                                        <input type="text" id="p_sToken" class='form-control m-bot15' maxlength="32" >
                                                                    </div>
                                                        </div>
                                            </div>
                                            <div class="form-group col-xs-2" style="text-align:right">
                                                <button class="btn btn-xs btn-info " id="btneditar" onclick="habilitaredicion();" style="display:none;margin-top:20px;"> Editar </button>
                                                <button class="btn btn-xs btn-info " id="btncanceledit" onclick="cancelaredicion(2);" style="display:none;margin-top:20px;" > Cancelar Edición </button>
                                            </div>
                                </div>

							<div class="well">
                                <div class="form-group col-xs-8">
                                    <h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
                                </div>


                  <div class="form-group col-xs-12">
                 
                    <div class="form-group col-xs-2" style="padding-top:10px;text-align:right">
                              <label class=" control-label">&nbsp; </label>
                      </div>
                
                      <div class="form-group col-xs-2" style="padding-top:10px;text-align:right">
                              <label class=" control-label">&nbsp;</label>
                      </div>
                    
                      <div class="form-group col-xs-3">
                      <label class=" control-label">Id Integrador: </label>
                        <input type="text" id="p_nIdIntegrador" class='form-control m-bot15' maxlength="12"">    
                      </div>
                      <div class="form_group col-xs-3 ">
                                    <label class=" control-label">Pais: </label>
                                    <select class="form-control m-bot15" name="p_nIdPais" id="p_nIdPais" onchange="seleccionapais(this.value);">
                                        <option value="-1">Seleccione</option>
                                        <?php echo $htmlPais; ?>
                                    </select>
                    </div>
                      <div class="form-group col-xs-2" >
                        <label class=" control-label">Moneda: </label>
                        <select class="form-control m-bot15" name="p_nIdMoneda" id="p_nId_moneda" >
                              <option value="-1">Seleccione</option>
                              <option value="100" selected>Pesos</option>
                              <option value="149">Dólares</option>
                        </select>
                      </div>
                  </div>
                                <div class="form-group col-xs-12">
										<h4><span></span> </h4>
                                    </div>
								<div class="form-group col-xs-12">
                                    <div class="form-group col-xs-3" id="div-rfc">
                                       <label class="control-label">RFC: </label>
								       <input type="text" id="p_sRFC" class='form-control m-bot15' maxlength="12" onkeyup="RFCFormato();" onkeypress="RFCFormato();" onblur="RFCFormato(this.value);">
									</div>
                                    <div class="form-group col-xs-3" id="div-irs" style="display:none">
                                       <label class="control-label">&nbsp</label>
								       <input type="text" id="p_sIrs" class='form-control m-bot15' maxlength="13"  >
									</div>
                                    <div class="form-group col-xs-3">
                                        <label class="control-label">Razón Social: </label>
										<input type="text" id="p_sRazonSocial" class='form-control m-bot15'>
									</div>
                                    <div class="form-group col-xs-3">
                                        <label class=" control-label">Nombre Comercial: </label>
										<input type="text" id="p_sNombreComercial" class='form-control m-bot15'>
									</div>
									
								</div>
								<div class="form-group col-xs-12">

	                <div class="form-group col-xs-4">
	                    <label class=" control-label">Contacto: </label>
	                    <input type="text" id="p_sNombreContacto" class='form-control m-bot15'>
	                </div>

	                <div class="form-group col-xs-4">
	                    <label class=" control-label">Teléfono: </label>
	                    <input type="text" id="p_sTelefono" class='form-control m-bot15'>
	                </div>

	                <div class="form-group col-xs-4">
	                    <label class=" control-label">Correo: </label>
	                    <input type="text" id="p_sCorreo" class='form-control m-bot15'>
	                </div>
								</div>

								<div  class="form-group col-xs-12">
									<h4><span><i class="fa fa-building"></i></span> Dirección</h4>
								</div>
								<div class="form-group col-xs-12">
	                  <input type="hidden" name="p_nIdDireccion" id="p_nIdDireccion" value="0">
	                  <input type="hidden" name="origen" id="origen" value="0" />
	                  <div class="form-group col-xs-6	">
	                      <label class=" control-label">Calle: </label>
	                      <input type="text" class="form-control m-bot15" name="p_sCalle" id="p_sCalle">
	                  </div>

	                  <div class="form-group col-xs-2	">
	                      <label class=" control-label">Número Exterior: </label>
	                      <input type="text" class="form-control m-bot15" id="p_sNumeroExterior" name="p_sNumeroExterior">
	                  </div>
	                   <div class="form-group col-xs-2	">
	                      <label class=" control-label">Número Interior: </label>
	                      <input type="text" id="p_sNumeroInterior" class="form-control m-bot15" name="p_sNumeroInterior">
	                  </div>
	                  <div class="form-group col-xs-2	">
	                      <label class=" control-label">Código Postal: </label>
	                      <input type="text" class="form-control m-bot15" name="p_sCodigoPostal" id="p_sCodigoPostal">
	                  </div>
							</div>
     							<div class="form-group col-xs-12" id="divDirext" style="display:none">

									<div class="form-group col-xs-4	">
                                        <label class=" control-label">Colonia: </label>
                                       <input type="text" class="form-control m-bot15" name="p_sNombreColonia" id="p_sNombreColonia">
									</div>
									<div class="form-group col-xs-4	">
                                        <label class=" control-label">Ciudad: </label>
                                        <input type="text" class="form-control m-bot15" name="p_sNombreCiudad" id="p_sNombreCiudad">
									</div>
									<div class="form-group col-xs-4	">
                                        <label class=" control-label">Estado: </label>
                                        <input type="text" class="form-control m-bot15" name="p_sNombreEstado" id="p_sNombreEstado">
									</div>
                                    
								</div>

                                <div class="form-group col-xs-12" id="divDirnac">

									<div class="form-group col-xs-3	">
                                        <label class=" control-label">Colonia: </label>
                                        <select class="form-control m-bot15" name="p_nIdColonia" id="p_nIdColonia">
                                            <option value="-1">Seleccione</option>
                                        </select>
									</div>
									<div class="form-group col-xs-3	">
                                        <label class=" control-label">Ciudad: </label>
                                        <select class="form-control m-bot15" name="p_nIdCiudad" id="p_nIdCiudad">
                                            <option value="-1">Seleccione</option>
                                        </select>
									</div>
									<div class="form-group col-xs-3	">
                                        <label class=" control-label">Estado: </label>
                                        <select class="form-control m-bot15" name="p_nIdEstado" id="p_nIdEstado">
                                            <option value="-1">Seleccione</option>
                                        </select>
									</div>

								</div>

                                <div class="form-group col-xs-12">
                                    <div>
                                        <h4><span><i class="fa fa-credit-card"></i></span> Datos Bancarios</h4>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">CLABE Interbancaria para depósito de pagos: </label>
                                        <input type="text" id="p_sCLABE" class='form-control m-bot15' onkeyup="analizarCLABE();" onkeypress="analizarCLABE();">
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label class=" control-label">Banco</label>
                                        <input type="text" id="nombreBanco" class='form-control m-bot15' maxlength="18" disabled="">
                                        <input type="hidden" name="p_nIdCuentaBanco" id="p_nIdCuentaBanco" />
                                    </div>
                                
									<div class="form-group col-xs-4">
                                        <label class="control-label">Referencia alfanumérica</label>
                                        <input type="text" name="p_sReferencia" id="p_sReferencia" class='form-control m-bot15' maxlength="18" disabled="">
                                    </div>
                                </div>

                                </div>


							</div>
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

                                            <input type="file" class="hidess" style="" name="p_sDocumento" id="p_sDocumento" idtipodoc="2">
                                            <input type="hidden" class="" style="" name="p_sKeyDocumento" id="p_sKeyDocumento" idtipodoc="2">
                                            <input type="hidden" class="" style="" name="p_nIdDocumento" id="p_nIdDocumento" idtipodoc="2" >
                                        </div>
                                    </div>
                                    <div class="col-xs-2">

                                        <input origen="emisor" type="button" id="btnFileEstadoCuenta"  value="Ver Comprobante" idtipodoc="2" onclick="verdocumentoproveedor(this);" class ="btnfiles">

                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Documento RFC:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">

                                            <input type="file" class="hidess" style="" name="p_sDocumento" id="p_sDocumento" idtipodoc="1">
                                            <input type="hidden" class="" style="" name="p_sKeyDocumento" id="p_sKeyDocumento" idtipodoc="1">
                                            <input type="hidden" class="" style="" name="p_nIdDocumento" id="p_nIdDocumento" idtipodoc="1">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">

                                        <input origen="emisor" type="button" id="btnFileEstadoCuenta"  value="Ver Comprobante" idtipodoc="1" onclick="verdocumentoproveedor(this);" class ="btnfiles">

                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Estado de Cuenta:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">

                                             <input type="file" class="hidess" style="" name="p_sDocumento" id="p_sDocumento" idtipodoc="3">
                                             <input type="hidden" class="" style="" name="p_sKeyDocumento" id="p_sKeyDocumento" idtipodoc="3">
                                            <input type="hidden" class="" style="" name="p_nIdDocumento" id="p_nIdDocumento" idtipodoc="3" >
                                        </div>
                                    </div>
                                    <div class="col-xs-2">

                                        <input origen="emisor" type="button" id="btnFileEstadoCuenta"  value="Ver Comprobante" idtipodoc="3" onclick="verdocumentoproveedor(this);" class ="btnfiles">

                                    </div>
                                </div>
                                 <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Contrato:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">

                                             <input type="file" class="hidess" style="" name="p_sDocumento" id="p_sDocumento" idtipodoc="4">
                                             <input type="hidden" class="" style="" name="p_sKeyDocumento" id="p_sKeyDocumento" idtipodoc="4">
                                            <input type="hidden" class="" style="" name="p_nIdDocumento" id="p_nIdDocumento" idtipodoc="4" >
                                        </div>
                                    </div>
                                    <div class="col-xs-2">

                                        <input origen="emisor" type="button" id="btnFileEstadoCuenta"  value="Ver Comprobante"  idtipodoc="4" onclick="verdocumentoproveedor(this);" class ="btnfiles">

                                    </div>
                                </div>

                            </div>
							<div class="well">
                                <div style="margin-bottom:30px;" class="form-group col-xs-9">
                                    <h4><span><i class="fa fa-gear"></i></span> Datos Operativos</h4>
                                </div>
                                <div class="form-group col-xs-3">
                                    <h5 style="margin-left: 60px;"><a data-toggle="modal" data-target="#ayuda"><i class="fa fa-info-circle"></i> Ayuda al Usuario </a></h5>
                                </div>
                                 <div class="form-group col-xs-12">
                                      <label class=""> Programaci&oacute;n de Liquidaci&oacute;n</label>
                                </div>
                                  <div class="form-group col-xs-12">
																		<div class="form-group col-xs-2"></div>
                                        <div class="form-group col-xs-8">
																					<div class="form-group col-xs-3"></div>
																					<div class="form-group col-xs-6">
																						<label class="control-label">Tipo de pago: </label>
																						<select class="form-control m-bot15" name="p_nIdProgramacion" id="p_nIdProgramacion" value="-1">
																							<option value="-1" selected disabled hidden>Seleccione</option>
																							<option value="1">Por día de la semana.</option>
																							<option value="2">Día seleccionado del siguiente mes.</option>
																							<option value="3">Día siguiente inmediato seleccionado.</option>
																						</select>
																					</div>
                                            <div class="well" style="padding-right: 0px;padding-left: 0px;">
                                                <div class="form-group col-xs-12" >
																									<div class="form-group col-xs-3"> </div>
																									<div class="form-group col-xs-12" id="tipoSeleccionado">
																										<div class="form-group col-xs-6" id="nDiaCorte" style="display:none">
																											<label class="control-label">Día de corte: </label>
																											<input type="text" class="form-control m-bot15 diaSemana" style="text-align: center;" id="diaCorte_Lunes" valorConfig="0" value="Lunes" disabled><br>
																											<input type="text" class="form-control m-bot15 diaSemana" style="text-align: center;" id="diaCorte_Martes" valorConfig="1" value="Martes" disabled><br>
																											<input type="text" class="form-control m-bot15 diaSemana" style="text-align: center;" id="diaCorte_Miercoles" valorConfig="2" value="Miercoles" disabled><br>
																											<input type="text" class="form-control m-bot15 diaSemana" style="text-align: center;" id="diaCorte_Jueves" valorConfig="3" value="Jueves" disabled><br>
																											<input type="text" class="form-control m-bot15 diaSemana" style="text-align: center;" id="diaCorte_Viernes" valorConfig="4" value="Viernes" disabled><br>
																											<input type="text" class="form-control m-bot15 diaSemana" style="text-align: center;" id="diaCorte_Sabado" valorConfig="5" value="Sábado" disabled><br>
																											<input type="text" class="form-control m-bot15 diaSemana" style="text-align: center;" id="diaCorte_Domingo" valorConfig="6" value="Domingo" disabled>
																										</div>

																									</div>

                                                    

                                                </div>
                                              
                                            </div>
                                        </div>
                                      
                                    </div>



                                <div class="well" style="padding-right: 0px;padding-left: 0px;">
                                  
                                      <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-12" >
                                            <label class="control-label"><input type="checkbox" id="chkcobrotransferencia" value="1" class='m-bot15' step="any" onclick="habilitar1(this);">¿Se cobrará al Proveedor por Transferencia? </label>
                                        </div>

                                    </div>
                                    <div class="form-group col-xs-12" id="divcobtrans" style="display:none"><!-- facturas-->
																				<div class="form-group col-xs-3"> </div>
                                                                                <div class="form-group col-xs-4" >
																					<label class="control-label">Tipo de Facturacion por transferencia: </label>
                                                                                        <select class="form-control m-bot15" name="nIdTipofactura" id="p_nIdTipofactura" disabled>
																						<option value="-1">Seleccione</option>
																						<option value="0">Por Evento</option>
																						<option value="1">Mensual</option>
                                                                                        </select>
                                                                                </div>
                                                                                <div class="form-group col-xs-3">
																					<label class="control-label" >Costo  por Transferencia: </label>
																					<input type="text" id="p_nCostoTrasferencia" value="0" class='form-control m-bot15' disabled>
																				</div>
                                    </div>
                                </div>
                                <div class="well" style="padding-right: 0px;padding-left: 0px;">
                                    <div class="form-group col-xs-12"><!-- comision-->
                                        <div class="form-group col-xs-2">
                                            <label class="control-label">Pago Comisión: </label>
                                            <select class="form-control m-bot15" name="p_nIdPagoComision" id="p_nIdPagoComision" onchange="diascom(this.value,0)">
                                                <option value="-1">Seleccione</option>
                                                <option value="1">Mensual</option>
                                                <option value="2">Días</option>
                                                <option value="3">Catorcenal</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-xs-4" id="diascom" style="padding-top:20px">
                                        </div>
                                        <div class="form-group col-xs-2">
                                            <label class="control-label"><input type="radio" name="radcom" value="1" onclick="cambiacomtip(this.value)"/> Importe: </label>
                                            <input type="text" id="p_nImporteComision" value="0" class='form-control m-bot15' step="any" disabled>
                                        </div>
                                        <div class="form-group col-xs-2">
                                            <label class=" control-label"><input type="radio" name="radcom" value="2" onclick="cambiacomtip(this.value)"/> Porcentaje: </label>
                                            <input type="text" id="p_nPorcentajeComision" value="0" class='form-control m-bot15' disabled>
                                        </div>
                                        <div class="form-group col-xs-2">
                                            <label class="control-label">Retención: </label>
                                            <select class="form-control m-bot15" name="p_nIdRetencion" id="p_nIdRetencion">
                                                <option value="-1">Seleccione</option>
                                                <option value="1">Sin Retención</option>
                                                <option value="2">Con Retención</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                               <div class="well" style="padding-right: 0px;padding-left: 0px;">
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-2">

                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">¿Cómo el Proveedor Genera sus Referencias? </label>
                                            <select class="form-control m-bot15" name="p_nIdTipoReferencia" id="p_nIdTipoReferencia">
                                               <option value="-1">Seleccione</option>
                                               <option value="1">Referencia Proveedor Carga vía Portal 13</option>
                                               <option value="2">Referencia Paycash vía Portal 13</option>
                                               <option value="3">PayCash vía WebService 13</option>
                                               <option value="4">Referencia vía Webservice 30</option>
                                               <option value="5">Proveedor Genera sus Referencias 30</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">¿Cómo se notifican los pagos al Proveedor? </label>
                                            <select class="form-control m-bot15" name="p_nIdNotificaPagos" id="p_nIdNotificaPagos" onchange="ftpopt(this.value)">
                                               <option value="-1">Seleccione</option>
                                               <option value="1000">Entrega Archivos por Correo</option>
                                               <option value="2">Entrega Archivos vía Transferencia</option>
                                            </select>
                                        </div>
                                    </div>

                                <div  style="display: none;" id="datosFtp">
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-4">
                                            <label class=" control-label">Método de Entrega: </label>
                                            <select class="form-control m-bot15" name="p_nIdMetodoEntrega" id="p_nIdMetodoEntrega" onchange="cambiarmetodoentrega(this.value)">
                                               <option value="-1">Seleccione</option>
                                               <option value="1100">Via FTP</option>
                                               <option value="1010">Via SFTP</option>
                                               <option value="1001">Via FTPS</option>
                                            </select>
                                        </div>
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
                                </div>

                                <div class="row" style="display: none;" id="confcorreos">
                                    <div class="form-group col-xs-12">
                                        <label style="margin-left: 15px; margin-top: 15px; text-align:center" class="col-xs-12 control-label">Captura de 1 a 5 correos para la entrega del corte de operaciones. (Este se envia por default por las noches.)</label>
                                    </div>
                                    <div class="form-group col-xs-12" id="formCorreos"  style="margin-left: 30px; margin-top: 15px;">
                                         <center>
                                            <div class="row field_wrapper" id="contenedordecorreos">
                                                <div class="col-xs-12">
                                                    <input type="text" id="nuevocorreo" class="form-control m-bot15" name="correos" style="width: 300px; display:inline-block;">
                                                    <button id="nuevoCorreo" class="add_button btn btn-sm btn-default" onclick="agrergarcorreos();" style="width:150px">Agregar Correo  <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                             <div class="row field_wrapper" id="contenedordecorreos1">

                                            </div>
                                        </center>
                                    </div>

                                </div>
                                <div class="col-xs-12">
                                    <div class="col-xs-12" id="divenlinea" style="display:none">
                                        <label class="control-label"><input type="checkbox" id="chkenlinea" value="" onclick="mostrarmetodo(this)" />¿Entrega en Linea?  </label>
                                    </div>
                                </div>
                                <div class="col-xs-12" id="divmetodoenlinea" style="display:none">
                                    <div class="form-group col-xs-4">
                                    </div>
                                     <div class="form-group col-xs-4">
                                        <label class=" control-label">¿Cuál es el método en línea? </label>
                                        <select class="form-control m-bot15" name="p_nIdMetodoLinea" id="p_nIdMetodoLinea">
                                           <option value="-1">Seleccione</option>
                                           <option value="1">PayCash Notifica Pagos</option>
                                           <option value="2">Proveedor consulta Pagos</option>

                                        </select>
                                     </div>
                                    <div class="form-group col-xs-4">
                                    </div>
                                </div>

                            </div>


							</div>

                            <div class="row">
                               <div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
                                    <button class="btn btn-xs btn-info " id="guardarProveedor" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;"> Guardar </button>
                                   <button class="btn btn-xs btn-info pull-right" id="btnProveedor" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;display:none" onclick="actualizarintegrador()"> Guardar Cambios</button>
                                </div>
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
                                                    <p><b>Referencia Proveedor</b> : se genera la referencia respetando de 1 hasta 9 posiciones de la referencia del emisor. </p>
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
		<script src="<?php echo $PATHRAIZ;?>/ayddo/js/afiliacion.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/paycash/ajax/pdfobject.js"></script>

        <!--Autocomplete -->

        <script src="../../css/ui/jquery.ui.core.js"></script>
        <script src="../../css/ui/jquery.ui.widget.js"></script>
        <script src="../../css/ui/jquery.ui.position.js"></script>
        <script src="../../css/ui/jquery.ui.menu.js"></script>
        <script src="../../css/ui/jquery.ui.autocomplete.js"></script>

		<script>
			configPagoLiquidaciones();
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
            //busquedaintegrador();
            var usr = <?php echo $usuario; ?>;
			var idproveedor = <?php  echo $IdProveedor; ?>;
           
			cargaproveedor();

			$("#btnback").on('click',function(){
				$('body').append('<form id="aconsulta" method="post" action="./consultaClientesayddo.php"><input type="hidden" value="3" name="consvalor"/></form>');
				$("#aconsulta").submit();
			});

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

		.inhabilitar{

			background-color: #d9534f!important;
			border-color: #d9534f!important;
			margin-left: 10px;
			color: #FFFFFF;

		}

        #divIdProveedor{display:none}
	</style>
	</html>
