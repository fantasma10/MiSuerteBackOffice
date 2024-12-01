<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nuevo Cliente";
$tipoDePagina = "mixto";
$idOpcion = 317;
$prealta = isset($_GET['prealta']) ? ($_GET['prealta'] == 1 ? 1 : 0) : 0;
$usuario_logueado = $_SESSION['idU']*1;
$permisosAut = (in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_autorizador']) || in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_capturistas'])) ? 1 : 0;
$isAuthorizer = (bool) (in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_autorizador'])) ? 1 : 0;

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
		<title>.::Mi Red::.Afiliacion de Cliente</title>
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
		<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />

		<style type="text/css">
		  	.inhabilitar{
					background-color: #d9534f!important;
					border-color: #d9534f!important;
					margin-left: 10px;
					color: #FFFFFF;
			}
			.habilitar{
				margin-left: 10px;
			}
			.alignRight { text-align: right; }
		</style>
		<script>IS_AUTHORIZER = "<?php echo $isAuthorizer; ?>";</script>
	</head>
	<body>

	<!--Include Cuerpo, Contenedor y Cabecera-->
	<?php include($PATH_PRINCIPAL."/inc/cabecera2.php"); ?>
	<!--Inicio del Menú Vertical-->
	<!--Función "Include" del Menú-->
	<?php include($PATH_PRINCIPAL."/inc/menu.php"); ?>
	<!--Final del Menú Vertical-->
	<!--Contenido Principal del Sitio-->
	<!-- Consulta a mapeo AMP - Mi Red -->
	<!-- <?php //include($PATH_PRINCIPAL."/MesaControl/cliente/ajax/getMapeoAMP.php"); ?> -->


	<section id="main-content">
		<section class="wrapper site-min-height">
			<div class="row">
				<div class="col-lg-12">
					<!--Panel Principal-->
					<div class="panelrgb">
						<div class="titulorgb-prealta">
							<span><i class="fa fa-user"></i></span>
							<h3>Consulta</h3>
	                        <span class="rev-combo pull-right"><?php echo $prealta ? 'Consulta' : 'Prealta'; ?></span>
                            <input id="prealta" type="hidden" value="<?php echo $prealta; ?>">
						</div>
						<div id="consultaCLientePanel" class="panel">
							<!--Datos Generales-->
							<div class="panel-body">
			                    <div id="gridboxExport" class="adv-table table-responsive">
			                        <div id="gridbox" class="">
										<div class="form-group col-xs-12">
											<div class="form-group col-xs-2 <?php echo $prealta == 1 ? 'hidden' : ''; ?>" style="margin-left: -30px">
												<label>Estatus:</label>
												<select class="form-control" id="cmbEstatus" name="cmbEstatus">
													<option value="-1" selected>Todos</option>
													<option value="0">Activos</option>
													<option value="3">Inactivos</option>
												</select>
											</div>
											<div class="form-group col-xs-2">
												<button onclick="generarExcel()" class="btn btn-xs btn-info" id="btnExportarAExcel" style="margin-top:20px;" type="button"> Generar Excel </button>
											</div>
										</div>
			                            <table id="tabla_clientes" class="display table table-bordered table-striped" style="width: 100%">
			                                <thead>
			                                    <tr>                                                    
			                                        <th>Id</th>
			                                        <th>RFC</th>
			                                        <th>Razón Social</th>
													<th>Estatus</th>
			                                        <th>Acción</th>
			                                    </tr>
			                                </thead>    
			                                <tbody >
			                                </tbody>
			                            </table>
			                        </div>                    
			                    </div>
	                		</div>	                     
						</div>

						<div id="bitacoraClientePanel" class="panel" style="display: none;">
							<div class="panel-body">
								<div class="well">
									<div class="form-group col-xs-12">
										<h5 class="col-xs-6 pb-3 control-label">Catálogo: <em id='labelCatalogo'></em></h5>
										<h5 class="col-xs-6 pb-3 control-label">Usuario: <em id='labelUsuario'></em></h5>
										<h5 class="col-xs-6 pb-3 control-label">Fecha de Movimiento: <em id='labelFechaMovimiento'></em></h5>
										<h5 class="col-xs-6 pb-3 control-label">Tipo de acción: <em id='labelAccion'></em></h5>
									</div>
									<button id="botonVolverBitacora" class="btn btn-xs btn-info col-xs-offset-10" onclick="volverBitacora()"> Volver </button>
									<div class="adv-table table-responsive">
										<table id="bitacoraClienteTable" class="display table table-bordered table-striped" style="display:inline-table;">
											<thead>
												<tr>
													<th>#</th>
													<th>Campo</th>
													<th>Cambio Anterior</th>
													<th>Cambio Nuevo</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
	</section>

	<div id="infoCliente" class="modal fade col-xs-12" role="dialog">
		<div class="modal-dialog" style="width:60%;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<span><i class="fa fa-lightbulb-o" style="font-size:18px"></i>  Información de Cliente</span>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body texto">
					<div class="row">
						<div class="col-md-12">
							<div class="panel with-nav-tabs panel-default" style="box-shadow: none;">
								<div class="panel-heading">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#tab1default" data-toggle="tab"><span id="spnPestana"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="tab1default">
											<div class="form-group">
												<div class="row">
													<div class="col-md-2">Cadena</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfCadena" name="sconfCadena" value=""/></div>
												
													<div class="col-md-2">Razon Social</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfRazonSocial" name="sconfRazonSocial" value=""/></div>
												</div>
												<div class="row">
													<div class="col-md-2">Corresponsal</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfCorresponsal" name="sconfCorresponsal" value=""/></div>
													<div class="col-md-2">Corresponsales</div>
													<div class="col-md-4"><input class="form-control" type="number" id="sconfCantCorresponsal" name="sconfCantCorresponsal" value="" readonly/></div>
												</div>
												<div class="row">
													<div class="col-md-2">RFC</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sRFC" name="sRFC" readonly value=""/></div>
													<div class="col-md-2">Fiscalizado</div>
													<div class="col-md-4">
															SI <input class="" style="margin: 5px;" type="radio" id="nFiscalizadoSi" name="nFiscalizado" value="1"/>
															NO <input class="" style="margin: 5px;" type="radio" id="nFiscalizadoNo" name="nFiscalizado" value="0"/>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2">Regimen</div>
													<div class="col-md-4">
														Fisico <input class="" style="margin: 5px;" type="radio" id="nRegimenFisico" name="nRegimen" value="1"/>
														Moral <input class="" style="margin: 5px;" type="radio" id="nRegimenMoral" name="nRegimen" value="2"/> </p>
														Sin Regimen <input class="" style="margin: 5px;" type="radio" id="nRegimenSinRegimen" name="nRegimen" value="0"/>
													</div>
												</div>
												
												<div class="row">
													<div class="col-md-2">Correo</div>
													<div class="col-md-4"><input class="form-control" type="email" id="sconfCorreo" name="sconfCorreo" value=""/></div>
													<div class="col-md-2">Telefono</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfTelefono" name="sconfTelefono" value="" maxlength="10"/></div>
												</div>
												
												<div class="row">
													<div class="col-md-2">Operadores</div>
													<div class="col-md-4"><input class="form-control" type="number" id="sconfCantOperadores" name="sconfCantOperadores" value="" readonly/></div>
												</div>
												<div class="row">
													<div class="col-md-2">Num. Cuenta</div>
													<div class="col-md-4"><input class="form-control" type="number" id="numCuentaCorresponsal" name="numCuentaCorresponsal" value="" readonly/></div>
													<div class="col-md-2">Referencia</div>
													<div class="col-md-4"><input class="form-control" type="text" id="referencia" name="referencia" value="" readonly/></div>
												</div>

												<!-- <div class="row" id="rowTituloAdmin" style="display: none;"> -->
												<div class="row" id="rowTituloAdmin">
													<div class="col-md-12"><hr><b>ADMINISTRADOR</b></div>
												</div>
												<!-- <div class="row" id="rowNombreA" style="display: none;"> -->
												<div class="row" id="rowNombreA" >
													<div class="col-md-2">Nombre</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfNombre" name="sconfNombre" value="" onkeyup="generarUsuario(); soloLetras('sconfNombre');"/></div>
													<div class="col-md-2">Apellido Paterno</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfPaterno" name="sconfPaterno" value="" onkeyup="generarUsuario(); soloLetras('sconfPaterno');"/></div>
												</div>
												<!-- <div class="row" id="rowNombreB" style="display: none;"> -->
												<div class="row" id="rowNombreB" >
													<div class="col-md-2">Apellido Materno</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfMaterno" name="sconfMaterno" value="" onkeyup="generarUsuario(); soloLetras('sconfMaterno');"/></div>
												</div>
												<!-- <div class="row" id="rowUsuario" style="display: none;"> -->
												<div class="row" id="rowUsuario" >
													<div class="col-md-2">Usuario</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfUsuario" name="sconfUsuario" value="" maxlength="5" readonly /></div>
													<div class="col-md-2">Contraseña</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfContrasena" name="sconfContrasena" value=""/></div>
												</div>

												<div class="row">
													<div class="col-md-12" style="overflow-y: scroll; height: 150px;">
														<hr><p><b>OPERADORES</b></p>
														<span id="dTablaOperadores" style="display: none; font-weight: bold; color: #d9534f;"></span>
														<table id="tabla_operadores" class="tablaOperadores display table table-bordered table-striped" style="width: 100%">
															<thead>
																<tr>
																	<th>Id Operador Red Efectiva</th>
																	<th>Nombre Operador</th>
																	<th>Estatus</th>
																	<th>Administrador</th>
																</tr>
															</thead>
															<tbody id="tdbody_operadores">
															</tbody>
														</table>
													</div>
												</div>

												<div class="row" id="d_usFinal" style="display: none;">
													<div class="col-md-12">La clave de usuario generada por sistema es: <span id="s_usFinal" style="font-weight: bold; font-size: 14px;"></span></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="hnIdCliente" value=""/>
					<input type="hidden" id="hnIdCadena" value=""/>
					<input type="hidden" id="hnIdCadenaAMP" value=""/>
					<input type="hidden" id="hnIdSubCadena" value=""/>
					<input type="hidden" id="hnIdCorresponsal" value=""/>
					<input type="hidden" id="hnIdOperador" value=""/>
					<input type="hidden" id="hnTipoPersona" value=""/>
					<input type="hidden" id="hsCURPCliente" value=""/>
					<input type="hidden" id="hnIdTipoIdentificacion" value=""/>
					<input type="hidden" id="hsNumIdentificacion" value=""/>
					<input type="hidden" id="hnFigPolitica" value=""/>
					<input type="hidden" id="hnIdTipoForeloCliente" value=""/>
					<input type="hidden" id="hcodigoAccesoCorresponsal" value=""/>
					<input type="hidden" id="hnumCuentaCorresponsal" value=""/>
					<input type="hidden" id="hreferencia" value=""/>
					<input type="hidden" id="hSerie" value=""/>
					<input type="hidden" id="hidRegimen" value=""/>
					<input type="hidden" id="hidUsuarioAMP" value=""/>
					<input type="hidden" id="hmigracion" value=""/>
					<input type="hidden" id="hidAgente" value=""/>
					<input type="hidden" id="hflagFinMigracion" value="0"/>
					<input type="hidden" id="hVersionCliente" value="0"/>

					<button type="button" id="btn_guardar" class="btn btn-default" onclick="confirmarDatos();">Guardar</button>
					<button type="button" onclick="cerrarModuloMig();" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>

		</div>
	</div>


	<div id="infoClienteMigrado" class="modal fade col-xs-12" role="dialog">
		<div class="modal-dialog" style="width:60%;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<span><i class="fa fa-lightbulb-o" style="font-size:18px"></i>  Información de Cliente Migrado</span>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body texto">
					<div class="row">
						<div class="col-md-12">
							<div class="panel with-nav-tabs panel-default" style="box-shadow: none;">
								<div class="panel-heading">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#tab2default" data-toggle="tab"><span id="spnPestana2"></span></a></li>
									</ul>
								</div>
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="tab2default">
											<div class="form-group">
												<div class="row">
													<div class="col-md-2">Cadena</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfCadenaB" name="sconfCadenaB" value="" readonly/></div>
												
													<div class="col-md-2">Razon Social</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfRazonSocialB" name="sconfRazonSocialB" value="" readonly/></div>
												</div>
												<div class="row">
													<div class="col-md-2">Sucursal</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfCorresponsalB" name="sconfCorresponsalB" value="" readonly/></div>
													<div class="col-md-2">Sucursales</div>
													<div class="col-md-4"><input class="form-control" type="number" id="sconfCantCorresponsalB" name="sconfCantCorresponsalB" value="" readonly/></div>
												</div>
												<div class="row">
													<div class="col-md-2">RFC</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sRFCB" name="sRFCB" readonly value=""/></div>
													<div class="col-md-2">Fiscalizado</div>
													<div class="col-md-4">
															SI <input class="" style="margin: 5px;" type="radio" id="nFiscalizadoSiB" name="nFiscalizadoB" value="1"/>
															NO <input class="" style="margin: 5px;" type="radio" id="nFiscalizadoNoB" name="nFiscalizadoB" value="0"/>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2">Regimen</div>
													<div class="col-md-10">
														Fisico <input class="" style="margin: 5px;" type="radio" id="nRegimenFisicoB" name="nRegimenB" value="1"/>
														Moral <input class="" style="margin: 5px;" type="radio" id="nRegimenMoralB" name="nRegimenB" value="2"/>
														Sin Regimen <input class="" style="margin: 5px;" type="radio" id="nRegimenSinRegimenB" name="nRegimenB" value="0"/>
													</div>
												</div>
												
												<div class="row">
													<div class="col-md-2">Correo</div>
													<div class="col-md-4"><input class="form-control" type="email" id="sconfCorreoB" name="sconfCorreoB" value="" readonly/></div>
													<div class="col-md-2">Telefono</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfTelefonoB" name="sconfTelefonoB" value="" maxlength="10" readonly/></div>
												</div>
												
												<div class="row">
													<div class="col-md-2">Operadores</div>
													<div class="col-md-4"><input class="form-control" type="number" id="sconfCantOperadoresB" name="sconfCantOperadoresB" value="" readonly/></div>
												</div>
												<div class="row">
													<div class="col-md-2">Num. Cuenta</div>
													<div class="col-md-4"><input class="form-control" type="number" id="numCuentaCorresponsalB" name="numCuentaCorresponsalB" value="" readonly/></div>
													<div class="col-md-2">Referencia</div>
													<div class="col-md-4"><input class="form-control" type="text" id="referenciaB" name="referenciaB" value="" readonly/></div>
												</div>

												<div class="row" id="rowTituloAdmin">
													<div class="col-md-12"><hr><b>ADMINISTRADOR</b></div>
												</div>
												
												<div class="row" id="rowNombreA" >
													<div class="col-md-2">Nombre</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfNombreB" name="sconfNombreB" value="" readonly /></div>
													<div class="col-md-2">Apellido Paterno</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfPaternoB" name="sconfPaternoB" value="" readonly /></div>
												</div>
												
												<div class="row" id="rowNombreB" >
													<div class="col-md-2">Apellido Materno</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfMaternoB" name="sconfMaternoB" value="" readonly /></div>
												</div>
												
												<div class="row" id="rowUsuario" >
													<div class="col-md-2">Usuario</div>
													<div class="col-md-4"><input class="form-control" type="text" id="sconfUsuarioB" name="sconfUsuarioB" value="" maxlength="5" readonly /></div>
													<!--<div class="col-md-2">Contraseña</div>
													<div class="col-md-4"><input class="form-control" type="password" id="sconfContrasena" name="sconfContrasena" value="" readonly /></div>-->
												</div>

												<div class="row">
													<div class="col-md-12" style="max-height: 150px; overflow-y: scroll;" >
														<hr><p><b>OPERADORES</b></p>
														<table id="tabla_operadoresB" class="tablaOperadoresB display table table-bordered table-striped" style="width: 100%">
															<thead>
																<tr>
																	<th>Id Operador Aquimispagos</th>
																	<th>Nombre Operador</th>
																	<th>Cve. Usuario</th>
																	<th>Administrador</th>
																</tr>
															</thead>
															<tbody id="tdbody_operadoresB">
															</tbody>
														</table>
													</div>
												</div>

											</div>
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
			
	<div id="modalEstatusCliente" class="modal fade" role="dialog" aria-hidden="true" tabindex="-1" aria-labelledby="myModal">
		<div class="modal-dialog" style="width: 60%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title">Modificar estatus cliente</h3>
				</div>
				<div class="modal-body">
					<h4 id="mensajeCambioEstatus"></h4>
					<input type="hidden" id="nIdCliente" class='form-control m-bot15'>
					<input type="hidden" id="nEstatusCliente" class='form-control m-bot15'>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="cambiarEstatusCliente">Aceptar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelarCambioEstatus">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<!--*.JS Generales-->
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/common-custom-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
	<!--Generales-->
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>		

	<script src="<?php echo $PATHRAIZ;?>/MesaControl/cliente/js/consulta.js?v=<?php echo rand(); ?>"></script>
	<script type="text/javascript">	
		BASE_PATH = "<?php echo $PATHRAIZ;?>";
		ID_PERFIL = "<?php echo $_SESSION['idPerfil'];?>";
        PERMISOAUT = "<?php echo $prealta == 1 ? $permisosAut : true;?>";
        PREALTA = "<?php echo $prealta;?>";
	</script>
	</body>   	
	<style type="text/css">
	.prueba {
		width: 100% !important;
	}

	#td {
		width: 30% !important;
	}

	#inputs {
		text-align: center;
	}

	.dataTables_filter {
		text-align: right !important;
		width: 40% !important;
		padding-right: 0 !important;
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

	#emisor {
		background-color: #0275d8 !important;
		border-color: #0275d8 !important;
	}


	.inhabilitar {
		background-color: #d9534f !important;
		border-color: #d9534f !important;
		margin-left: 10px;
		color: #FFFFFF;
	}

	.habilitar {
		margin-left: 10px;
	}

	.lectura {
		background: rgb(238, 238, 238);
		color: rgb(128, 128, 128);
	}

	.lecturaCorreos {
		background: rgb(238, 238, 238);
		color: rgb(128, 128, 128);
	}
</style>
</html>
