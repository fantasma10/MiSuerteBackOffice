<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Comisiones";
$subsubmenuTitulo	= "Actualizacion";

$tipoDePagina = "mixto";
$idOpcion = 180;

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
	<title>.::Mi Red:: Abono a Cuenta Electronica</title>
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
								<h3>Abonos	</h3><span class="rev-combo pull-right">Abono a Cuenta <br>Electronica</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div id="panelConciliacion">
										<div class="well">
											<div class="form-group col-xs-6">
												<h4><span><i class="fa fa-money"></i></span> Abono a Cuenta Electronica del Cliente</h4>
											</div>
											<div class="form-group col-xs-6">
												<h5 style="margin-top: 12px;margin-left: 290px;"><a data-toggle="modal" data-target="#ayuda"><i class="fa fa-info-circle"></i> Ayuda al Usuario </a></h5>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<label class="col-xs-3 control-label">Correo del Usuario:</label>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<div class="form-group col-xs-3">
													<input type="text" id="correoUsuario" class="form-control ">
												</div>
												<div class="form-group col-xs-2" style="text-align:right;margin-left:55px">
													<a type="button" id="buscarUsuario" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando"> Buscar Usuario </a>
												</div>
											</div>
											</div>

											<div class="well" id="datosUsuario" style="display:none;">
											<div class="form-group col-xs-6">
												<h4><span><i class="fa fa-user"></i></span> Datos del Cliente</h4>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<label class="col-xs-4 control-label">Nombre del Cliente:</label>
												<label class="col-xs-4 control-label">Referencia:</label>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<div class="form-group col-xs-4">
													<input type="text" id="nombreUsuario" class="form-control ">
												</div>
												<div class="form-group col-xs-4">
													<input type="text" id="referencia" class="form-control ">
												</div>
											</div>
											</div>

											<div class="well" id="movimientosBancarios" style="display: none">
											<div class="form-group col-xs-12">
												<h4><span><i class="fa fa-money"></i></span> Depositos no Identificados</h4>
											</div>
											<div class="form-group col-xs-3" style="margin-right:10px;margin-left:15px;">
												<label class="control-label">Fecha Inicial:</label>
												<br/>
												<input type="text" id="fecha1" name="fecha1" class="form-control form-control-inline input-medium default-date-picker"
												onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10"
												value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecha1')" onKeyUp="validaFecha2(event,'fecha1')">
												<div class="help-block">Elegir Fecha.</div>
											</div>
											
											<div class="form-group col-xs-3" style="margin-right:10px;">
												<label class="control-label">Fecha final:</label>
												<br/>
												<input type="text" id="fecha2" name="fecha2" onpaste="return false;" class="form-control form-control-inline input-medium default-date-picker"
												data-date-format="yyyy-mm-dd" maxlength="10"  value="<?php echo $g_hoy; ?>"
												onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
												<div class="help-block">Elegir Fecha.</div>
											</div>
											<div class="form-group col-xs-3">
												<label class="control-label">Autorizacion:</label>
												<input type="text" id="autorizacion" class="form-control ">
											</div>
											<div class="form-group col-xs-2" style="text-align:right;margin-left:25px">
											<br/>
													<a type="button" id="buscarAbonos" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando"> Buscar Movimientos </a>
												</div>
											<div class="form-group col-xs-12">
												<div id="gridbox" class="adv-table table-responsive">
 													<table id="tblGridBox" class="display table table-bordered table-striped">
 														<thead>
 															<tr data-id="prueba">
                                                        		<th id="thFecha">Fecha</th>
                                                        		<th id="thFecha">Descripcion del Movimiento</th>
                                                        		<th id="thFecha">Referencia</th>
                                                        		<th id="thFecha">Autorizacion</th>
                                                        		<th id="thMonto">Abono</th>
                                                        		<th id="thMonto"></th>
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
					</div>
				</div>
			</section>
		</section>


		<div id="abonoAutorizacion" class="modal fade col-xs-12" role="dialog">
			<div class="modal-dialog" style="width:50%;">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<span><i class="fa fa-lightbulb-o" style="font-size:18px"></i>  Información de Corte</span>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"></h4>
						<input type="hidden" id="movimientoId">
					</div>
					<div class="modal-body" id="texto">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="abonar">Autorizar</button>
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
                            				<li class="active"><a href="#tab1default" data-toggle="tab">Reconocimiento de Abono</a></li>
                       					</ul>
                					</div>
                					<div class="panel-body">
                    					<div class="tab-content">
                        					<div class="tab-pane fade in active" id="tab1default">
                        						<p>Paso 1 -Ingrese el correo electronico que el cliente registro en la aplicación.</p>
												<p>Paso 2 -Oprima el botón de buscar usuario.</p>
												<p>Paso 3 -Si el usuario se encontro el sistema muestra los datos.</p>
												<p>Paso 4 -El sistema despliega el panel de búsqueda de movimientos.</p>
												<p>Paso 5 -Se selecciona el rango de fechas de busqueda y el número de autorización si el usuario lo proporciona.</p>
												<p>Paso 6 -Se despliega la información que la consulta arroje.</p>
												<p>Paso 7 -Si se encuentra el movimiento se debe oprimir el botón de abonar.</p>
												<p>Paso 8 -El sistema muestra ventana de confirmacion del movimiento.</p>
												<p>Paso 9 -Se oprime el botón de autorizar,el sistema actualiza el movimiento de lo contrario el pulsar el boton cancelar y no se realiza ninguna operación .</p>
												<p>Paso 10 -En caso de no encontrarse el sistema muestra mensaje.</p>
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
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/abono.js"></script>
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

		#tblGridBox{
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



