<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Cliente";

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

$r_nIdTipoCliente=$_REQUEST['nIdTipoCliente'];

function acentos($word){
	return (!preg_match('!!u', $word))? utf8_encode($word) : $word;
}

$idPerfil = $_SESSION['idPerfil'];
$usuario = $_SESSION['idU'];

$idpreemisor = (isset($_POST['txtidpreem']))?$_POST['txtidpreem']:0;
$idintegrador = (isset($_POST['txtidinteg']))?$_POST['txtidinteg']:0;
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
	<title>.::Mi Red::.Afiliacion de emisores</title>
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

    #pdfvisor{
           display:none;
           height: 100%;
           width: 100%;
           position:fixed;
           background-color: rgba(255, 255, 255, 0.55);
           z-index: 1500;
       }
       #divpdf{

            height:600px;
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


    </style>

        <script>
		
			var usr = <?php echo $usuario; ?>;
            var preem = <?php echo $idpreemisor; ?> ;
            var integ = <?php echo $idintegrador; ?> ;

      
		</script>
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
								<h3>Datos del Preemisor</h3><span class="rev-combo pull-right">Afiliación <br>de Preemisores</span>
							</div>
							<div class="panel">
								<div class="panel-body">
                                    <div class="form-group col-xs-12" id="divedit" >
                                <div class="form-group col-xs-2" style="padding-top:10px;text-align:right">
                                    <button class="btn btn-xs btn-info " id="btnback"  >Preemisores </button>
                                </div>

                                <div class="form-group col-xs-2" style="padding-top:10px;text-align:right">

                                </div>
                                <div class="form-group col-xs-6" style="padding-top:10px;text-align:right">

                                </div>

                                <div class="form-group col-xs-2" style="padding-top:10px;text-align:right">
                                     <button class="btn btn-xs btn-info " id="btneditar" onclick="habilitaredicion(4);" style="display:none"> Editar </button>
                                    <button class="btn btn-xs btn-info " id="btncanceledit" onclick="cancelaredicion(4);" style="display:none" > Cancelar Edición </button>
                                </div>
                            </div>
									<div class="well">
										<div style="margin-bottom:30px;" class="form-group col-xs-9">
											<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
										</div>
										<div class="form-group col-xs-12">

											<div class="form-group col-xs-3">
                                                <label class="control-label">RFC: </label>
												<input type="text" id="rfc" class='form-control m-bot15' maxlength="12" onkeyup="RFCFormato();" onkeypress="RFCFormato();">
											</div>

                                            <div class="form-group col-xs-3">
                                                <label class="control-label">Razón Social: </label>
												<input type="text" id="razonSocial" class='form-control m-bot15'>
											</div>

											<div class="form-group col-xs-3">
                                                <label class=" control-label">Nombre Comercial: </label>
												<input type="text" id="nombreComercial" class='form-control m-bot15'>
											</div>
											<div class="form-group col-xs-3">
												<label class=" control-label">Buscar Integrador por ID o Nombre: </label>
												<input type="text" id="txintegrador" class='form-control m-bot15'>
												<input type="hidden" id="idIntegrador" class='form-control m-bot15'>
											</div>



										</div>
										<div class="form-group col-xs-12">

											<div class="form-group col-xs-4">
                                                <label class=" control-label">Contacto: </label>
												<input type="text" id="beneficiario" class='form-control m-bot15'>
											</div>

											<div class="form-group col-xs-4">
                                                <label class=" control-label">Teléfono: </label>
												<input type="text" id="telefono" class='form-control m-bot15'>
											</div>

											<div class="form-group col-xs-4">
                                                <label class=" control-label">Correo: </label>
												<input type="text" id="correo" class='form-control m-bot15'>
											</div>
										</div>
										<div style="margin-top:150px;">
											<h4><span><i class="fa fa-building"></i></span> Dirección</h4>
										</div>
										<div class="form-group col-xs-12">
											<input type="hidden" name="idDireccion" id="idDireccion" value="0">
											<input type="hidden" name="origen" id="origen" value="0" />



											<div class="form-group col-xs-6	">
                                                <label class=" control-label">Calle: </label>
												<input type="text" class="form-control m-bot15" name="calleDireccion" id="txtCalle">
											</div>
											  <div class="form-group col-xs-2	">
                                                <label class=" control-label">Número Exterior: </label>
												<input type="text" class="form-control m-bot15" id="ext" name="numeroExtDireccion">
											</div>
											<div class="form-group col-xs-2	">
                                                <label class=" control-label">Número Interior: </label>
													<input type="text" id="int" class="form-control m-bot15" name="numeroIntDireccion">
											</div>

                                            <div class="form-group col-xs-2	">
                                                <label class=" control-label">Código Postal: </label>
												<input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCP">
												<input type="hidden" class="form-control m-bot15" name="idLocalidad" id="idLocalidad">
											</div>
										</div>
										<div class="form-group col-xs-12">



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

                                             <div class="form-group col-xs-3">
                                                <label class=" control-label">País: </label>
												<input type="hidden" class="form-control m-bot15" name="idPais" id="idPais" value="164">
												<input type="text" class="form-control m-bot15" name="txtPais" id="txtPais" value="Mexico">
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
											<label class="col-xs-4 control-label">Referencia alfanumérica</label>
										</div>
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<input type="text" id="clabe" class='form-control m-bot15' onkeyup="analizarCLABE();" onkeypress="analizarCLABE();" onblur="limpiabanco();">
											</div>
											<div class="form-group col-xs-4">
												<input type="text" id="nombreBanco" class='form-control m-bot15' maxlength="18" disabled="">
												<input type="hidden" name="banco" id="banco" />
											</div>
											<!--div class="form-group col-xs-4">
												<input type="text" id="referencia" class='form-control m-bot15' maxlength="18">
											</div-->

											<div class="form-group col-xs-4">
												<input type="text" name="referenciaAlfa" id="referenciaAlfa" class='form-control m-bot15' maxlength="18" disabled="">
												<input type="hidden" name="cuentaContable" id="cuentaContable" class='form-control m-bot15' maxlength="15">
											</div>
										</div>

										<!--div class="form-group col-xs-12">
											<div class="form-group col-xs-4">
												<label class="control-label">Ingresa una referencia alfanumérica</label>
												<input type="text" name="referenciaAlfa" id="referenciaAlfa" class='form-control m-bot15' maxlength="18">
												<input type="hidden" name="cuentaContable" id="cuentaContable" class='form-control m-bot15' maxlength="15">
											</div>
										</div-->

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

                                            <input type="file" class="hidess" style="" name="sFile" id="txtFile" idtipodoc="1">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="1">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">

                                        <input origen="emisor" type="button" id="btnFileEstadoCuenta"  value="Ver Comprobante" idtipodoc="1" onclick="verdocumentopremisor(this);" class ="btnfiles">

                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Documento RFC:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">

                                            <input type="file" class="hidess" style="" name="sFile" id="txtFile" idtipodoc="2">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="2">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">

                                        <input origen="emisor" type="button" id="btnFileEstadoCuenta"  value="Ver Comprobante" idtipodoc="2" onclick="verdocumentopremisor(this);" class ="btnfiles">

                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Estado de Cuenta:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">

                                             <input type="file" class="hidess" style="" name="sFile" id="txtFile" idtipodoc="4">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="4">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">

                                        <input origen="emisor" type="button" id="btnFileEstadoCuenta"  value="Ver Comprobante" idtipodoc="4" onclick="verdocumentopremisor(this);" class ="btnfiles">

                                    </div>
                                </div>
                                 <div class="form-group col-xs-12">
                                    <div class="col-xs-5">
                                         <label class=""> Cargar Contrato:</label>
                                     </div>
                                    <div class="col-xs-5">
                                        <div class="form-group">

                                             <input type="file" class="hidess" style="" name="sFile" id="txtFile" idtipodoc="10">
                                            <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="10">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">

                                        <input origen="emisor" type="button" id="btnFileEstadoCuenta"  value="Ver Comprobante"  idtipodoc="10" onclick="verdocumentopremisor(this);" class ="btnfiles">

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
																						<select class="form-control m-bot15" name="tipoPago" id="tipoPago" value="-1">
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
																										<div class="form-group col-xs-6" id="diaCorte" style="display:none">
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
                                               <!-- <center>
                                                  <button class="btn btn-xs btn-info" id="guardarconf"  style="margin-top:10px;" onclick="guardardiasprueba();"> Guardar conf </button>
                                                </center>    -->
                                            </div>
                                        </div>
                                       <!-- <div class="form-group col-xs-6">
                                            <div class="well" style="padding-right: 0px;padding-left: 0px;">

                                            </div>
                                        </div> -->
                                    </div>



                        <div class="well" style="padding-right: 0px;padding-left: 0px;">
                                   <!-- <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-2">
                                            <label class="control-label">Tipo de Liquidación: </label>
                                                <select class="form-control m-bot15" name="retencion" id="idTipoLiq" onchange="diasliq(this.value,0)">
                                                    <option value="-1">Seleccione</option>
                                                    <option value="1">Mensual</option>
                                                    <option value="2">Días</option>
                                                    <option value="3">Catorcenal</option>
                                                </select>
                                        </div>
                                        <div class="form-group col-xs-7" id="diasliq" style="padding-top:20px">
                                        </div>
                                    </div> -->
                                      <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-12" >
                                            <label class="control-label"><input type="checkbox" id="chktrans" value="1" class='m-bot15' step="any" onclick="habilitar1(this);">¿Se cobrará al Emisor por Transferencia? </label>
                                        </div>

                                    </div>
                                    <div class="form-group col-xs-12" id="divcobtrans" style="display:none"><!-- facturas-->
                                        <div class="form-group col-xs-3" style="text-align:right">

                                        </div>
                                        <div class="form-group col-xs-4" >
                                            <label class="control-label">Tipo de Facturacion por transferencia: </label>
                                            <select class="form-control m-bot15" name="tipofactura" id="tipofactura" disabled>
                                                    <option value="-1">Seleccione..</option>
                                                    <option value="0">Por Evento</option>
                                                    <option value="1">Mensual</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-xs-3">
                                           <label class="control-label" >Costo  por Transferencia: </label>
                                            <input type="text" id="txtcostotrans" value="0" class='form-control m-bot15' disabled>

                                        </div>
                                    </div>
                                </div>
                                <div class="well" style="padding-right: 0px;padding-left: 0px;">
                                    <div class="form-group col-xs-12"><!-- comision-->
                                        <div class="form-group col-xs-2">
                                            <label class="control-label">Pago Comisión: </label>
                                            <select class="form-control m-bot15" name="retencion" id="idTipoCom" onchange="diascom(this.value,0)">
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
                                            <input type="text" id="comision" value="0" class='form-control m-bot15' step="any" disabled>
                                        </div>
                                        <div class="form-group col-xs-2">
                                            <label class=" control-label"><input type="radio" name="radcom" value="2" onclick="cambiacomtip(this.value)"/> Porcentaje: </label>
                                            <input type="text" id="perComision" value="0" class='form-control m-bot15' disabled>
                                        </div>
                                        <div class="form-group col-xs-2">
                                            <label class="control-label">Retención: </label>
                                            <select class="form-control m-bot15" name="retencion" id="retencion">
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
                                            <label class="control-label">¿Cómo el Emisor Genera sus Referencias? </label>
                                            <select class="form-control m-bot15" name="cbref" id="cbref">
                                               <option value="-1">Seleccione</option>
                                               <option value="1">Referencia Emisor Carga vía Portal 13</option>
                                               <option value="2">Referencia Paycash vía Portal 13</option>
                                               <option value="3">PayCash vía WebService 13</option>
                                               <option value="4">Referencia vía Webservice 30</option>
                                               <option value="5">Emisor Genera sus Referencias 30</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label">¿Cómo se notifican los pagos al Emisor? </label>
                                            <select class="form-control m-bot15" name="cbnotif" id="cbnotif" onchange="ftpopt(this.value)">
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
                                            <select class="form-control m-bot15" name="cbmetent" id="cbmetent" onchange="cambiarmetodoentrega(this.value)">
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

                                <!--div class="row" style="display: none;" id="confcorreos">
                                    <div class="form-group col-xs-12">
                                        <label style="margin-left: 15px; margin-top: 15px; text-align:center" class="col-xs-12 control-label">Captura de 1 a 5 correos para la entrega del corte de operaciones.</label>
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

                                </div-->
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
                                        <select class="form-control m-bot15" name="cbmetodoenlinea" id="cbmetodoenlinea">
                                           <option value="-1">Seleccione</option>
                                           <option value="1">PayCash Notifica Pagos</option>
                                           <option value="2">Emisor consulta Pagos</option>

                                        </select>
                                     </div>
                                    <div class="form-group col-xs-4">
                                    </div>
                                </div>

                            </div>


							</div>

                             <div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
											<button class="btn btn-xs btn-info " id="autpreem" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;" onclick="autorizaPremisor(preem);"> Autorizar</button>
                                            <button class="btn btn-xs btn-info pull-right" id="guardarCE" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;display:none" onclick=" guardarPreemisor();"> Guardar  </button>
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
			ES_ESCRITURA	= "<?php echo $esEscritura; ?>";
			
     // cargapreemisor(preem);

			if(preem > 0){
                cargapreemisor(preem);
                //cargardatosIntegrador(integ);
                
                
            }

			$("#btnback").on('click',function(){
				$('body').append('<form id="aconsulta" method="post" action="./consultaClientesayddo.php"><input type="hidden" value="2" name="consvalor"/></form>');
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


	</style>
	</html>
