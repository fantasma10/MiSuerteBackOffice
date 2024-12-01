<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Comisiones";
$subsubmenuTitulo	= "Actualizacion";

$tipoDePagina = "mixto";
$idOpcion = 178;

$hoy = date("Y-m-d");

if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
}

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
	<title>.::Mi Red:: Monitor de liquidacion de pagos</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    
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
								<h3>Conciliacion</h3><span class="rev-combo pull-right">Conciliacion <br>Diaria</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div id="panelConciliacion">
										<div class="well">
											<div class="form-group col-xs-6">
												<h4><span><i class="fa fa-money"></i></span> Conciliacion y Creacion de Cortes</h4>
											</div>
											<div class="form-group col-xs-6">
												<h5 style="margin-top: 12px;margin-left: 290px;"><a data-toggle="modal" data-target="#ayuda"><i class="fa fa-info-circle"></i> Ayuda al Usuario </a></h5>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<label class="col-xs-3 control-label">Fecha del Corte:</label>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<div class="form-group col-xs-3">
													<input type="text" onpaste="return false;" id="fecha1"
                        							class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
												</div>
												<div class="form-group col-xs-2" style="text-align:right;margin-left:55px">
													<a type="button" id="buscarCorte" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando"> Buscar </a>
												</div>
												<div class="form-group col-xs-6" style="text-align: right">
													<a type="button" style="width: 130px;" id="corte_crea" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando">Ir a Creacion de Corte</a>
												</div>
											</div>
											<div class="form-group col-xs-12">
												<div id="gridbox" class="adv-table table-responsive">
 													<table id="tblGridBox" class="display table table-bordered table-striped">
 														<thead>
 															<tr data-id="prueba">
                                                        		<th id="thFecha">Proveedor</th>
                                                        		<th id="thFecha">Numero de Operaciones</th>
                                                        		<th id="thMonto">Monto del Corte</th>
                                                        		<th id="thMonto">Monto de Pronosticos</th>
                                                        		<th id="thMonto">Monto de Premios</th>
                                                        		<th id="thMonto">Monto de la Comision</th>
                                                    		</tr>   
                                                		</thead>
                                                		<tbody>
														
														</tbody>
													</table>
												</div>											
											</div>								
										</div>
										<div class="well" id="corteDetalles" style="display: none">					
											<div class="form-group col-xs-6">
												<h4><span><i class="fa fa-calculator"></i></span>Detalle del corte</h4>
											</div>
											<div class="form-group col-xs-6" id="carga">
												<h4>Carga Sr Pago</h4>
												<input type="file"  id="fileToUpload">
												<input type="hidden" id="montoCheck">
												<input type="hidden" id="corte">
												<input type="hidden" id="montoCorte">
												<input type="hidden" id="montoArchivo">
												<input type="hidden" id="montoSr">
												<input type="hidden" id="saldoDiferencia">
											</div>
											<div class="well" id="familiasInfo" style="margin-top:30px;height: 300px;overflow: scroll;">
												<form class="form-horizontal" id="formFiltros">	
													<div>
														<h4><span><i class="fa fa-money"></i></span> Métodos de Pago</h4>
													</div>
													<div class="form-group col-xs-11" id="metodosPago">

													</div>
												</form>										
											</div>
											<div class="form-group col-xs-12" style="text-align:right;">
												<div class="form-group col-xs-12" id="conciliar" style="text-align:right;">
													<a type="button" id="conciliacion" style="display: none" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando">Conciliar</a>
												</div>
												
											</div>
										</div>
									</div>



									<div id="panelCorte" style="display: none;">
										<div class="well">
											<div>
												<h4><span><i class="fa fa-money"></i></span> Creacion de Cortes</h4>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<label class="col-xs-3 control-label">Fecha Inicial:</label>
												<label class="col-xs-3 control-label">Fecha Final:</label>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<div class="form-group col-xs-3">
													<input type="text" onpaste="return false;" id="txtFechaIni"
                        							class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'txtFechaIni')" onKeyUp="validaFecha2(event,'txtFechaIni')">
												</div>
												<div class="form-group col-xs-3" style="margin-right:10px;">						
													<input type="text" id="fecha2" name="fecha2" onpaste="return false;" class="form-control form-control-inline input-medium default-date-picker"
												data-date-format="yyyy-mm-dd" maxlength="10"  value="<?php echo $hoy; ?>"
												onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
												</div>
												<div class="form-group col-xs-2" style="text-align:right;margin-left:55px">
													<a type="button" id="buscarCreacion" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando"> Buscar </a>
												</div>
												<div class="form-group col-xs-2" style="text-align:right;margin-left:55px">
													<a type="button" id="crea_corte" class="btn btn-xs btn-info" style="display: none;" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando"> Crear Corte </a>
												</div>
											</div>
											<div class="form-group col-xs-12">
												<div id="gridbox" class="adv-table table-responsive">
 													<table id="tblGridBox2" class="display table table-bordered table-striped">
 														<thead>
 															<tr data-id="prueba">
                                                        		<th id="thFecha">Proveedor</th>
                                                        		<th id="thFecha">Numero de Operaciones</th>
                                                        		<th id="thMonto">Monto del Corte</th>
                                                        		<th id="thMonto">Monto de Pronosticos</th>
                                                        		<th id="thMonto">Monto de Premios</th>
                                                        		<th id="thMonto">Monto de la Comision</th>
                                                    		</tr>   
                                                		</thead>
                                                		<tbody>
														
														</tbody>
													</table>
												</div>											
											</div>									
										</div>
										<div class="form-group col-xs-6">
												<input type="hidden" id="cliente">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</section>



		<div id="confirmaPago" class="modal fade col-xs-12" role="dialog">
			<div class="modal-dialog" style="width:50%;">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<span><i class="fa fa-lightbulb-o" style="font-size:18px"></i>  Información de Corte</span>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body texto">
						<p>Para liberar este corte ingrese detalle de liberacion.</p>
						<div class="row" >
							
							<div class="form-group col-xs-12" id="diferencia" style="margin-right:16px; display: none;">
								<div class="form-group col-xs-6" style="text-align:right;padding-right:70px;">
									<label class="control-label" id="montoCorte2">Mi Suerte</label>
									<input type="radio" id="corteMonto" name="corteMonto" checked="true">
								</div>
								<div class="form-group col-xs-6">
									<label class="control-label" id="montoPronosticos">Pronosticos</label>
									<input type="radio" id="cortePronosticos" name="cortePronosticos">
									<input type="hidden" id="pagoTotal">
									<input type="hidden" id="entidad">
								</div>
							</div>


							<div class="form-group col-xs-12" style="margin-right:16px;">
								<div class="form-group col-xs-12">
									<label class="control-label" id="montoDiferencia"></label>
								</div>
							</div>

							<div class="form-group col-xs-12" style="margin-right:16px;">
								<div id="trDetalle">
									<label class="col">Detalles:</label>
									<br />
									<div>
										<textarea class="form-control" id="txtDetalle" name="txtDetalle" onpaste="return false;" rows="2" maxlength="250"></textarea>
									</div>
								</div>
							</div>	
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="liberaCorte">Liberar</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					</div>
				</div>

			</div>
		</div>


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
                            				<li class="active"><a href="#tab1default" data-toggle="tab">Conciliacion</a></li>
                            				<li><a href="#tab2default" data-toggle="tab">Creacion de Corte</a></li>
                       					</ul>
                					</div>
                					<div class="panel-body">
                    					<div class="tab-content">
                        					<div class="tab-pane fade in active" id="tab1default">
                        						<p>Paso 1 -Seleccione la fecha del corte a conciliar</p>
												<p>Paso 2 -Se muestra la información del corte y el detalle por metodo de pago.</p>
												<p>Paso 3 -Seleccionar la casilla de Tarjeta de Credito.</p>
												<p>Paso 4 -Oprimir el boton de seleccionar el archivo de Sr Pago.</p>
												<p>Paso 5 -Se muestra el resultado de la conciliacion con Sr Pago.</p>
												<p>Paso 6 -Se habilita el boton para realizar la conciliacion.</p>
												<p>Paso 7 -En caso de existir diferencia se genera alerta y puede liberarse con algun detalle ajustando.</p>
                        					</div>
                        					<div class="tab-pane fade" id="tab2default">
                        						<p>Paso 1 -Haga clic en el boton de creación de corte</p>
												<p>Paso 2 -Se muestra en la parte inferior las opciones para la creación.</p>
												<p>Paso 3 -Seleccion el periodo para el corte.</p>
												<p>Paso 4 -Se muestra el detalle del corte a crear.</p>
												<p>Paso 5 -Aparece el boton de creación de corte.</p>
												<p>Paso 6 -Al oprimir el boton se muestra el resultado en caso de existir un corte con alguna de las fechas no se genera el registro.</p>
												<p>Paso 7 -Si se genero el corte ahora aparecera en el modulo de liquidacion de pagos <a href="<?php echo $ROOT; ?>/misuerte/conciliacion/monitorPagos.php/">Liquidaci&oacute;n de Pagos</a> en estatus por autorizar.</p>
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
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/cortes/corte.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
           <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>

		<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		</script>
	</body>
	<style type="text/css">
		
				#thFecha{
			width: 20% !important;
			font-weight: bold;
    		color: black;
		}

		#thMonto{
			width: 15% !important;
			font-weight: bold !important;
    		color: black !important;
		}

		#tblGridBox2{
			 width: 100%!important;
		}


		.thFecha{
			text-align: center !important;
			font-weight: bold !important;
    		color: black !important;
		}

		.thMonto{
			text-align: right !important;
			font-weight: bold !important;
    		color: black !important;
		}


	

	
		.dataTables_filter{
			text-align: right!important;
			width: 40% !important;
			padding-right: 0!important;
		}

		.dataTables_length label{
			width: 175px !important;
		}

		.well ul li {
    		padding: 0 !important;
    		font-size: 11px !important;
		}

		.table-striped tbody tr.active:nth-child(odd) td, .table-striped tbody tr.active:nth-child(odd) th {
     		background-color: #99cde6!important;
		}
		
		.table tbody tr.active td, .table tbody tr.active th {
    		background-color: #99cde6!important;
    	color: white;
		}

	</style>
	</html>



