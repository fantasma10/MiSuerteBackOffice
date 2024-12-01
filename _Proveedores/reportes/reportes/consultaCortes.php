<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL."/_Proveedores/proveedor/ajax/Cat_familias.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Consulta Cortes";
$subsubmenuTitulo	= "Consulta Cortes";
$tipoDePagina = "mixto";
$idOpcion = 209;


if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
}

$hoy = date("d/m/Y");

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
		<title>.::Mi Red::.Consulta Cortes</title>
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
		<link href="<?php echo $PATHRAIZ;?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
		
		<style>
			.align-right { text-align: right; }
			.panelrgb,
			.panel {max-width: 100%;}
		</style>
	</head>
	<body>

	<!--Include Cuerpo, Contenedor y Cabecera-->
	<?php include($PATH_PRINCIPAL."/inc/cabecera2.php"); ?>
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
						<span><i class="fa fa-money"></i></span>
						<h3>CORTE PROVEEDOR</h3><h3 id="etiquetaTipoUsuario"></h3><span class="rev-combo pull-right">Corte</span>
					</div>
					<div class="panel">
						<div class="panel-body">
							<div class="well">
								<div class="row">                                	 
									<div class="form-group col-xs-3" id="">
										<label class="control-label">Proveedor </label>
										<select id="select_proveedor" class="form-control"></select>
									</div>
                                	 
									<div class="form-group col-xs-3" id="">
										<label class="control-label">Tipo Fecha</label>
										<select id="select-tipo-fecha" class="form-control">
											<option value="1">Corte</option>
											<option value="2">Pago</option>
										</select>
									</div>

                                	<div class="form-group col-xs-3">
										<label class="control-label">Fecha Inicial</label>
										<input type="text" id="fecIni" name="fecIni" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecIni')" onKeyUp="validaFecha2(event,'fecIni')">
									</div>
									<div id="fechaFinBock" class="form-group col-xs-3">
										<label class=" control-label">Fecha Final</label>
										<input type="text" id="fecFin" name="fecFin" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo$g_hoy; ?>" onKeyPress="return validaFecha(event,'fecFin')" onKeyUp="validaFecha2(event,'fecFin')">
									</div>	
								</div>  
								<div class="row">
									<div class="col-xs-6">
										<form method="post" id="exportar_excel" action="../ajax/exportarCorteExcel.php" style="margin-top:10px;margin-left:-15px;">
											<input type="hidden" name="id_proveedor_excel" id="id_proveedor_excel">
											<input type="hidden" name="fecha1_excel" id="fecha1_excel">
											<input type="hidden" name="fecha2_excel" id="fecha2_excel">
											<input type="hidden" name="tipo" id="tipo">
											<div class="form-group col-xs-6">
												<button class="btn btn-xs btn-info excel" id="btn_ExportarCorteExcel" style="display: none; margin-bottom:10px;"><i class="fa fa-file-excel-o"></i> Excel
												</button>
											</div>
										</form>
									</div>
									<div class="col-xs-6">
                            			<button id="btn_buscar_cortes" class="btn btn-xs btn-info pull-right" style="margin-top:10px">Buscar</button>
									</div>	
								</div>                           	
							</div>
							<div id="gridboxExport" class="adv-table table-responsive">
								<div id="gridbox" class="">
									<!--
									<table id="tabla_iconos" class="table" style="display: none;">
										<thead>
											<tr>
												<td>
													<button style="cursor: auto;" data-placement="top" rel="tooltip" class="btn habilitar btn-default btn-xs">
														<span class="fa fa-clock-o"></span> 
													</button> = Corte Pendiente
												</td>
												<td>
													<button style="cursor: auto;" data-placement="top" rel="tooltip" class="btn habilitar btn-default btn-xs">
														<span class="fa fa-check"></span>
													</button> = Corte Cerrado
												</td>
												<td>
													<button style="cursor: auto;" data-placement="top" rel="tooltip" class="btn habilitar btn-default btn-xs">
														<span class="fa fa-thumbs-up"></span>
													</button> = Corte Autorizado
												</td>
												<td>
													<button style="cursor: auto;" data-placement="top" rel="tooltip" class="btn habilitar btn-default btn-xs">
														<span class="fa fa-list"></span>
													</button> = Corte para Revalidar
												</td>
											</tr>
										</thead>
									</table>
									-->
									<!-- <div id="contenedorTabla">										
									</div> -->
									<div class="col-lg-12">
                                    <div class="row" id="reporte">
                                        <div class="adv-table">
                                            <div class=" ">
                                                <div class="box-body table-responsive">
                                                    <table id="tabla_proveedores" class="table table-bordered table-striped" style="width: 100%;display: none;">
                                                        <thead>
													    	<tr>
													    	<th id='th1'>Id</th>                                                
													    	<th id='th2'>Proveedor</th>
													    	<!-- <th id='th3'>Zona</th> -->
													    	<th id='th4'>Fecha Corte</th>
													    	<th id='th5'>Fecha Pago</th>
													    	<th id='th6'>Operaciones</th>
													    	<th id='th7'>Monto</th>
													    	<th id='th8'>Comision CxC</th>
													    	<th id='th9'>Comision CxP</th>
													    	<th id='th10'>Comision Transferencia</th>
													    	<th id='th11'>Pago</th>
													    	</tr>
													    </thead>
													    <tbody></tbody>
                                                        <tfoot id="footDetalle">
                                                            <td colspan="4"><strong>TOTAL</strong></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="adv-table">
                                            <div class=" ">
                                                <div class="box-body table-responsive">
                                                    <table id="tabla_autorizador" class="table table-bordered table-striped" style="width: 100%;display: none;">
                                                        <thead>
													    	<tr>
													    	<th id='th1'>Id</th>                                                
													    	<th id='th2'>Proveedor</th>
													    	<th id='th3'>Zona</th>
													    	<th id='th4'>Fecha Pago</th>
													    	<th id='th5'>Operaciones</th>
													    	<th id='th6'>Monto</th>
													    	<th id='th7'>Comision</th>
													    	<th id='th8'>Pago</th>
													    	<th id='th9'></th>
													    	<!-- <th id='th10'></th> -->
													    	</tr>
													    </thead>
													    <tbody></tbody>
                                                        <tfoot id="footDetalle2">
                                                            <td colspan="4"><strong>TOTAL</strong></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <!-- <td></td> -->
                                                        </tfoot>
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
			</div>
		</div>
	</section>
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="width:70%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="h4text"></h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="idProveedorP" id="idProveedorP">
				<input type="hidden" name="idCorteP" id="idCorteP">
				<input type="hidden" name="fechaP" id="fechaP">
				<input type="hidden" name="referenciaP" id="referenciaP">
				<input type="hidden" name="estatusCorte" id="estatusCorte">
				<input type="hidden" name="zona" id="zona">
				<div class="col-md-3">
					<!-- <div class="col-md-2"> -->
						<label class="control-label">Estatus de Operaciones</label>
						<select class="form-control" id="selectEstatus">
							<option value="0">Todas</option>
							<option value="1">Aceptadas</option>
							<option value="2">Rechazadas</option>
						</select>
					<!-- </div> -->
				</div>
				<div id="gridboxOperacionesF" class="adv-table table-responsive">
					<div id="gridboxOperacionesS" class="">
						<table id="tabla_operaciones" class="display table table-bordered table-striped" style="width: 100%;display:none">
							<thead><tr>
								<th>Id Operacion</th>
								<th>Ticket</th>
								<th>Referencia</th>
								<th>Cadena</th>
								<th>Corresponsal</th>
								<th>Importe</th>
								<th>Exitosa</th>
								<th>Cancelada</th>
							</tr></thead>    
							<tbody >
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="col-md-12">
				<button id="guardarCorte" type="button" class="btn btn-default" >Cerrar Corte</button>
				<button id="cerrarModalCorte" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>
			</div>
		</div>
	</div>
</div>

<div style="margin-top: 10%;" class="modal fade modales" id="modalAclaracion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modales-dialog" role="document" style="width:30%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Agregar Aclaracion</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<input type="hidden" name="currentIdOperacion" id="currentIdOperacion">
						<input type="hidden" name="pTipoOperacion" id="pTipoOperacion">
						<input type="hidden" name="pTipoMovimiento" id="pTipoMovimiento">
						<label for="motivoAclaracion" class="col-form-label">Motivo de Aclaracion:</label>
						<input type="text" class="form-control" id="motivoAclaracion">
					</div>
					<div class="form-group">
						<label for="montoAclaracion" class="col-form-label">Monto:</label>
						<input type="text" class="form-control" id="montoAclaracion" readonly="true">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="guardarAclaracion">Guardar</button>
			</div>
		</div>
	</div>
</div>

<div style="margin-top: 10%;" class="modal fade modales" id="modalConfirmacionCorte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modales-dialog" role="document" style="width:30%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Confirmacion de cierre de corte</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<h4>¿DESEA REALMENTE CERRAR ESTE CORTE?</h4>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="confirmarCierreCorte">Confirmar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<div style="margin-top: 10%;" class="modal fade modales" id="modalConfirmacionCorte2" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modales-dialog" role="document" style="width:35%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="">Confirmacion Cierre de Corte</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<h4>¿DESEA REALMENTE CERRAR ESTE CORTE MULTIPLE?</h4>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="confirmarCierreCorte2" onclick="cerrar_corte_multiple()">Confirmar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalDetalleAclaraciones" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" style="width: 60%;height: 100%;">
		<div class="modal-content">
			<div class="modal-consulta">
				<span><i class="fa fa-file-o"></i></span>
				<h3>Detalle de Aclaraciones</h3>
				<span class="rev-combo pull-right">
					<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
				</span>
			</div>
			<div id="tabla_aclaraciones" class="modal-body">
			</div>
			<div class="modal-footer">                 
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div style="margin-top: 10%;" class="modal fade modales" id="modalMultiCortes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modales-dialog" role="document" style="width:60%;">
		<div class="modal-content">
			<div class="modal-consulta">
				<span><i class="fa fa-file-o"></i></span>
				<h3>Revision Cortes</h3>
				<span class="rev-combo pull-right">
					<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
				</span>
			</div>
			<input type="hidden" id="fechaPago">
			<input type="hidden" id="idProveedor">
			<input type="hidden" id="idZona">
			<div class="modal-body" id="cuerpoModal"></div>
			<div class="modal-footer">
				 
				<button id="autorizarCorte" type="button" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Autorizar</button>
				<button id="rechazarCorte"  type="button" class="btn btn-primary"><i class="fa fa-times" aria-hidden="true"></i>  Rechazar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
				 
			</div>
		</div>
	</div>
</div>

<div style="margin-top: 10%;" class="modal fade modales" id="modalAutorizacion" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modales-dialog" role="document" style="width:35%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="">Autorización de Cortes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<h4>¿DESEA REALMENTE AUTORIZAR ESTE CORTE MULTIPLE?</h4>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="confirmarCierreCorte2" onclick="autorizar_corte_multiple()">Confirmar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
	
	</body>
	<!--*.JS Generales-->
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
		 
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
				
	<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/RE.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>	
	<script src="<?php echo $PATHRAIZ;?>/_Proveedores/reportes/js/consultaCortes.js?v=<?php echo(rand()); ?>"></script>
	<script type="text/javascript">		
		<?php 
		$permiso=0;
		if(in_array($_SESSION['idU'], $array_reportes_telmex['usuario_analista'])){
			$permiso=1;
		}
		if(in_array($_SESSION['idU'], $array_reportes_telmex['usuario_autoriza'])){
			$permiso=2;
		}
		?>
		BASE_PATH = "<?php echo $PATHRAIZ;?>";
		ID_PERFIL = "<?php echo $_SESSION['idPerfil'];?>";	 
		ID_USUARIO = "<?php echo $_SESSION['idU'];?>";
		PERMISO_USER = "<?php echo $permiso;?>";
		METROGAS =  119;
		GASNATURAL = 27;
		TELMEX = 113;
		initViewConsultaCorte();
	</script> 	
</html>