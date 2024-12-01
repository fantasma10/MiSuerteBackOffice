<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Comisiones";
$subsubmenuTitulo	= "Actualizacion";

$tipoDePagina = "mixto";
$idOpcion = 156;

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
		<div id="pdfvisor">
         <center>
        <div id="divclosepdf" ><span id="closepdf" title="Cerrar PDF">X</span></div>
        <div id="divpdf">
        	<object id="pdfdata" data="" type="application/pdf" width="100%" height="100%"></object>
         </center>  
        </div>
    </div>

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
								<h3>Monitor de liquidación de pagos</h3><span class="rev-combo pull-right">Liquidación de<br>Pagos</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<div class="form-group col-xs-6">
											<h4><span><i class="fa fa-money"></i></span> Liquidación de pagos</h4>
										</div>
										<div class="form-group col-xs-6">
												<h5 style="margin-top: 12px;margin-left: 290px;"><a data-toggle="modal" data-target="#ayuda"><i class="fa fa-info-circle"></i> Ayuda al Usuario </a></h5>
										</div>
										<div class="form-group col-xs-12" style="padding-right:0px;">
												<label class="col-xs-3 control-label">Fecha Inicial:</label>
												<label class="col-xs-3 control-label">Fecha Final:</label>
												<label class="col-xs-3 control-label" style="padding-right:0px">Seleccione el estatus:</label>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<div class="form-group col-xs-3">
													<input type="text" onpaste="return false;" id="fecha1"
                        							class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
												</div>
												<div class="form-group col-xs-3">
													<input type="text" onpaste="return false;" id="fecha2" class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
												</div>
												<div class="form-group col-xs-3">
												 <select name="estatus" id="estatus"  class="form-control m-bot15">
                                              		<option value="6">Seleccione el estatus</option>
													<?php 
													$result = $MWDB->SP("CALL `pronosticos`.`sp_load_indicadores`();") or die(mysql_error());
													while($row = mysqli_fetch_array($result)){
														$id = $row["nIdEstatus"];
														$nombre = utf8_encode($row["sNombre"]);
														echo '<option value='.$id.'>'.$nombre.'</option>';                    
													} 
													mysqli_free_result($result);
													?>
                                                </select>
											</div>
												<div class="form-group col-xs-2" style="text-align:right;margin-left:55px">
													<a type="button" id="buscarCorte" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando"> Buscar </a>
												</div>
											</div>
										<div class="form-group col-xs-12">
											<div id="gridbox" class="adv-table table-responsive">
 												<table id="tblGridBox" class="display table table-bordered table-striped">
 													<thead>
 														<tr data-id="prueba">
 															<th id="td" style="display:none">Corte</th>
 															<th style="display:none">Cliente Id</th>
 															<th style="display:none">Proveedor Id</th>
                                                        	<th id="thFecha">Proveedor</th>
                                                        	<th id="thFecha">Fecha Inicio</th>
                                                        	<th id="thFecha">Fecha Fin</th>
                                                        	<th id="thFecha">Fecha de Pago</th>
                                                        	<th id="thMonto">Monto</th>
                                                        	<th id="td1">Estatus</th>
                                                        	<th id="td1">Acciones</th>
                                                    	</tr>   
                                                	</thead>
                                                	<tbody>
														
													</tbody>
												</table>
											</div>											
										</div>
										<div class="form-group col-xs-12" id="indicadores">
										
										</div>
									</div>
									<div class="well" id="corteDetalles" style="display:none" >					
										<div>
											<h4><span><i class="fa fa-calculator"></i></span> Detalles del corte</h4>
											<input type="hidden" id="corte">
											<input type="hidden" id="montoOrden">
										</div>

										<div class="form-group col-xs-12">
											<form id="excel" method="post" class="excel" action="../../ajax/excelConciliacion.php" >
												<input type="hidden" id="fechaInicial" name="fechaInicial">
												<input type="hidden" id="fechaFinal" name="fechaFinal">
												<div id="exportar" class="form-group col-xs-2" style="float:right; display: none;">
            									<button type="submit" class="btn btn-xs btn-info pull-left" style="margin-right:50px;">
                									<i class="fa fa-file-archive-o"></i> Exportar 
            									</button>
            								</form>
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
                                                        		<th id="thMonto">Fecha del Corte</th>
                                                    		</tr>   
                                                		</thead>
                                                		<tbody>
														
														</tbody>
													</table>
												</div>											
											</div>
										<div class="form-group col-xs-6" style="float:right;text-align: right;">
											<!--<a type="button" class="btn btn-xs btn-info" id="liberaPago" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Buscando" style="margin-left: 10px;"  data-toggle="modal" data-target="#confirmaPago">Liberar Pago</a>
											<a type="button" class="btn btn-xs btn-info" id="autorizar" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Buscando" style="margin-left: 10px;" data-toggle="modal">Autorizar Pago</a>-->
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
						<p>Desea liberar el pago de este corte</p>
						<div class="row" >
							<div class="form-group col-xs-12" style="margin-right:16px;">
								<div class="form-group col-xs-6" style="text-align:left;padding-right:70px;">
									<label class="control-label" id="montoCorte"></label>
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
						<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="generaOrden">Liberar</button>
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
                            				<li class="active"><a href="#tab1default" data-toggle="tab">Liberacion de Pagos</a></li>
                       					</ul>
                					</div>
                					<div class="panel-body">
                    					<div class="tab-content">
                        					<div class="tab-pane fade in active" id="tab1default">
                        						<p>Paso 1 -Seleccione el periodo de fechas para consultar los cortes.</p>
                        						<p>Paso 2 -Se selecciona el estatus del corte.</p>
												<p>Paso 3 -Se muestra el/los cortes y el estatus en el que se encuentra.</p>
												<p>Paso 4 -El corte cuenta con 3 botones de accion detalle,autorización y liberacion de pago.</p>
												<p>Paso 5 -Al ver la informacion del corte tiene la opcion de exportacion del detalle de los cortes que lo incluyen.</p>
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
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/monitorPagos.js"></script>
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


	table.display {

    font-size: 11px;
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
           
            height:500px;
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
		

		#tblGridBox2{
			 width: 100%!important;
		}
		

		#thFecha{
			width: 15% !important;
			font-weight: bold;
    		color: black;
		}

		#thMonto{
			width: 15% !important;
			font-weight: bold !important;
    		color: black !important;
		}


		#td1{
			width: 10% !important;
			font-weight: bold !important;
    		color: black !important;
		}


		.thFecha{
			text-align: center !important;
    		color: black !important;
		}

		.thMonto{
			text-align: right !important;
    		color: black !important;
		}


		.td1{
			text-align: center !important;
			font-weight: bold !important;
    		color: black !important;
		}

		.detalles{
			text-align: right;
			padding-right: 5px;	
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
		.table tbody tr.active:hover td, .table tbody tr.active:hover th {
    		background-color: #99cde6 !important;
		}
		.table tbody tr.active td, .table tbody tr.active th {
    		background-color: #99cde6!important;
    	color: white;
		}

	</style>
	</html>



