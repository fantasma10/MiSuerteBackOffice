<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Comisiones";
$subsubmenuTitulo	= "Actualizacion";


$tipoDePagina = "mixto";
$idOpcion = 166;

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
	<title>.::Mi Red:: Liquidacion de Retiros</title>
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
								<h3>Liquidación de retiros</h3><span class="rev-combo pull-right">Liquidación de<br>Retiros</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<div>
											<h4><span><i class="fa fa-money"></i></span> Liquidación de Retiros</h4>
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
                                              		<option value="-1">Seleccione el estatus</option>
													<option value='1'>Pendientes</option>
													<option value='0'>Pagados</option>
                                                </select>
											</div>
												<div class="form-group col-xs-2" style="text-align:right;margin-left:55px">
													<a type="button" id="buscarRetiro" class="btn btn-xs btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Buscando"> Buscar </a>
												</div>
											</div>
										<div class="form-group col-xs-12">
											<div id="gridbox" class="adv-table table-responsive">
 												<table id="tblGridBox" style="display:inline-table;" class="display table table-bordered table-striped">
 													<thead>
 														<tr data-id="prueba">
                                                        	<th id="thFecha">Nombre</th>
                                                        	<th id="thFecha">Correo</th>
                                                        	<th id="thFecha">Telefono</th>
                                                        	<th id="thFecha">Importe</th>
                                                        	<th id="thFecha">Cuenta Clabe</th>
                                                        	<th id="thMonto">Fecha Retiro</th>
                                                        	<th id="td1">Estatus</th>
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
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/liberacion.js"></script>
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
			font-weight: bold !important;
    		color: black !important;
		}

		.thMonto{
			text-align: right !important;
			font-weight: bold !important;
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



