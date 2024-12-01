<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Comisiones";
$subsubmenuTitulo	= "Actualizacion";

$tipoDePagina = "mixto";
$idOpcion = 156;
$corte = (!empty($_POST["corte"]))? $_POST["corte"] : 0;
$fechaI = (!empty($_POST["fechaI"]))? $_POST["fechaI"] : 0;
$fechaF = (!empty($_POST["fechaF"]))? $_POST["fechaF"] : 0;
$cliente = (!empty($_POST["cliente"]))? $_POST["cliente"] : 0;
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
	<title>.::Mi Red:: Operaciones no conciliadas</title>
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
								<h3>Movimientos No Conciliados</h3><span class="rev-combo pull-right">Movimientos no<br>Conciliados</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<div>
											<h4><span><i class="fa fa-times"></i></span> Movimientos sin conciliar</h4>
										</div>
										<div class="row excel" id="exportacion" style="display:inline-block;float:right">            
        									<form id="excel" method="post" class="excel" action="../ajax/excelConciliacion.php" >
            									<input  type="hidden" name="corte" id="corte"  value="<?php echo $corte ?>">
            									<input  type="hidden" id="fechaI" name="fechaI" value="<?php echo $fechaI ?>">
            									<input  type="hidden" id="fechaF" name="fechaF" value="<?php echo $fechaF ?>">
            									<input  type="hidden" name="cliente"  value="<?php echo $cliente ?>">
            									<button type="submit" class="btn btn-xs btn-info pull-left" style="margin-right:50px;">
                									<i class="fa fa-file-archive-o"></i> Exportar 
            									</button>
        									</form>
										</div>	
										<div class="form-group col-xs-12" style="margin-top:25px;">
											<div id="gridbox" class="adv-table table-responsive">
 												<table id="noConciliadas" class="display table table-bordered table-striped">
 													<thead>
 														<tr data-id="prueba">
                                                        	<th id="td">Producto</th>
                                                        	<th id="td">Entidad</th>
                                                        	<th id="thFecha">Sorteo</th>
                                                        	<th id="thFecha">Boleto</th>
                                                        	<th id="thFecha">Fecha de Venta</th>
                                                        	<th id="thFecha">Hora de Venta</th>
                                                        	<th id="thMonto">Monto Pronosticos</th>
                                                        	<th id="thMonto">Monto Mi Suerte</th>
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
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/noConciliadas.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
           <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>

		<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		</script>
	</body>
	<style type="text/css">
		

		.proveedor{
			font-weight: bold !important;
    		color: black !important;
		}

		#thFecha{
			width: 15% !important;
			font-weight: bold;
    		color: black;
		}

		#thMonto{
			width: 10% !important;
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

		.well ul li {
    		padding: 0 !important;
    		font-size: 11px !important;
		}

		.table-striped tbody tr.active:nth-child(odd) td, .table-striped tbody tr.active:nth-child(odd) th {
     		background-color: #eaeaea!important;
		}
		.table tbody tr.active:hover td, .table tbody tr.active:hover th {
    		background-color: #eaeaea !important;
		}
		.table tbody tr.active td, .table tbody tr.active th {
    		background-color: #eaeaea!important;
    	color: white;
		}

	</style>
	</html>
