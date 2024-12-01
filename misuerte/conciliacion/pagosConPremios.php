<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Conciliacion";
$subsubmenuTitulo	= "Pagos con Premios";


$tipoDePagina = "mixto";
$idOpcion = 168;

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
	<title>.::Mi Red:: Pagos con Premios</title>
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
								<h3>Pago con premios</h3><span class="rev-combo pull-right">Pago con <br>Premios</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<div>
											<h4><span><i class="fa fa-money"></i></span> Pagos con Premios Virtuales</h4>
										</div>
										<div class="form-group col-xs-12" style="padding-right:0px;">
												<label class="col-xs-3 control-label">Fecha Inicial:</label>
												<label class="col-xs-3 control-label">Fecha Final:</label>
											</div>
											<div class="form-group col-xs-12" style="padding-right:0px;">
												<div class="form-group col-xs-3">
													<input type="text" onpaste="return false;" id="fecha1"
                        							class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
												</div>
												<div class="form-group col-xs-3">
													<input type="text" onpaste="return false;" id="fecha2" class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
												</div>
												<div class="form-group col-xs-2" style="text-align:right;">
													<a type="button" id="buscarPagos" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando"> Buscar </a>
												</div>
												<form id="excel" method="post" class="excel" action="../../ajax/excelPagosPremios.php" >
												<input type="hidden" id="fechaInicial" name="fechaInicial">
												<input type="hidden" id="fechaFinal" name="fechaFinal">
												<div class="form-group col-xs-2" id="exportar" style="float:right; display: none;">
            									<button type="submit" class="btn btn-xs btn-info pull-left" style="margin-right:50px;">
                									<i class="fa fa-file-archive-o"></i> Exportar 
            									</button>
            									</form>
        									</div>
											</div>											
										<div class="form-group col-xs-12">
											<div id="gridbox" class="adv-table table-responsive">
 												<table id="tblGridBox" style="display:inline-table;" class="display table table-bordered table-striped">
 													<thead>
 														<tr>
                                                        	<th id="thFecha">Agencia Virtual</th>
                                                        	<th id="thFecha">Id del concursante</th>
                                                        	<th id="thFecha">Premios determinados por concursante</th>
                                                        	<th id="thFecha">Fecha de dispersion de premios determinados.</th>                   			
                                                        	<th id="thFecha">Premios Efectivamente Pagados</th>
                                                        	<th id="thFecha">Fecha de Pago de Premios</th>
                                                        	<th id="thFecha">Ventas de M.V.</th>
                                                        	<th id="thFecha">Fecha de Venta</th>
                                                        	<th id="thMonto">Saldo</th>                                               	
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
			</section>
		</section>

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
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/pagosPremios.js"></script>
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
		

		.pagado{

			background-color: #5cb85c!important; 
			border-color: #5cb85c!important;
		}


		#tblGridBox{
			width: 100% !important;
		}

		

		#thFecha{
			width: 12% !important;
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
			font-weight: bold !important;
    		color: black !important;
    		width: 10% !important;
		}

		.thMonto{
			text-align: right !important;
    		color: black !important;
    		width: 10% !important;
		}


		.td1{
			text-align: center !important;
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
		.table tbody tr.active:hover td, .table tbody tr.active:hover th {
    		background-color: #99cde6 !important;
		}
		.table tbody tr.active td, .table tbody tr.active th {
    		background-color: #99cde6!important;
    	color: white;
		}

	</style>
	</html>



