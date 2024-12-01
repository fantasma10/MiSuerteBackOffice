<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Afiliacion";
$subsubmenuTitulo	= "Lista de Integradores";

$tipoDePagina = "mixto";
$idOpcion = 198;
setlocale(LC_TIME, 'spanish');


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
$valorconsulta = (isset($_POST['consvalor']))?$_POST['consvalor']:0;

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
		<title>.::Mi Red::.Consulta de Clientes</title>
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
		<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" />
				<!--[if lt IE 9]>
				<script src="js/html5shiv.js"></script>
				<script src="js/respond.min.js"></script>
				<![endif]-->
		<style>
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

			#ordertablaI{
				width: 100%!important;
			}
		</style>
	</head>
	<body>
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
								<span><i class="fa fa-search"></i></span>
								<h3>Consulta de Clientes</h3><span class="rev-combo pull-right">Lista<br>de clientes</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										
													<div class="form-group col-xs-12" style="margin-bottom:30px;">
														
														
														<div class="form-group col-xs-2" style="text-align:center">										
															<div class="btn-group" data-toggle="buttons">			
																<label class="btn boton btn-primary" id="integrador">Integrador
																	<input type="radio" name="integrador" id="integrador">
																	<span class="fa fa-check"></span>
																</label>
															</div>
														</div>
                                                  		<div class="form-group col-xs-2" style="text-align:center">										
															<div class="btn-group" data-toggle="buttons">			
																<label class="btn boton btn-primary" id="preemisor">Preemisores
																	<input type="radio" name="preemisor" id="preemisor">
																	<span class="fa fa-check"></span>
																</label>
															</div>
														</div>
														<div class="form-group col-xs-2" style="text-align:center">										
															<div class="btn-group" data-toggle="buttons">			
																<label class="btn boton btn-primary" id="proveedor">Proveedor
																	<input type="radio" name="proveedor" id="proveedor">
																	<span class="fa fa-check"></span>
																</label>
															</div>
														</div>
														
													</div>
										
                                       
                                           
                                          
													<div id="gridbox" class="adv-table table-responsive">
													
															
															<div class="form-group col-xs-12" id="tablaIntegradores" style="display: none">
																	<div id="gridbox" class="adv-table table-responsive">
																		<table id="ordertablaIntegradores" class="display table table-bordered table-striped" style=" width: 100%; display:none;">
																			<thead>
																				<tr>
																																
																					<th>RFC</th>
																					<th>Razon social</th>
																					<th>Comision </th>
																					<th>Comision Integradores</th>
																					<th>Fecha Alta</th>
																					<th>Acciones</th>
																				</tr>
																			</thead>	
																			<tbody id="I">

																			</tbody>
																		</table>
																	</div>
															</div>
                                        
															<div class="form-group col-xs-12" id="tablaPreemisores" style="display: none">

																<div id="gridbox" class="adv-table table-responsive">
																	<table id="ordertablaPreemisores" class="display table table-bordered table-striped" style=" width: 100%; display:none;">
																		<thead>
																			<tr>
																															
																				<th>RFC</th>
																				<th>Razon social</th>
																				<th>Integrador</th>
																				<th>Fecha Alta</th>
																				<th>Acciones</th>
																			</tr>
																		</thead>	
																		<tbody id="P">

																		</tbody>
																	</table>
																</div>

															</div>

															<div class="form-group col-xs-12" id="tablaProveedores" style="display: none">
															
																<div id="gridbox" class="adv-table table-responsive">
																	<table id="ordertablaProveedores" class="display table table-bordered table-striped" style=" width: 100%; display:none;">
																		<thead>
																			<tr>
																															
																				<th>RFC</th>
																				<th>Razon social</th>
																				<th>Nombre Comercial</th>
																				<th>Telefono</th>
																				<th>Giro</th>
																				<th>Acciones</th>
																			</tr>
																		</thead>	
																		<tbody id="P">

																		</tbody>
																	</table>
																</div>

															</div>

														
														</div>		
									</div>

								</div><!--panel-body-->
							</div><!--panel-->
				
						</div>
					</div>
				</div>
			</section>
		</section>

		<div id="confirmacion" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modificar Estatus Emisor</h4>
					</div>
					<div class="modal-body">
						<p></p>
						<input type="hidden" id="emisorId" class='form-control m-bot15'>
						<input type="hidden" id="estatusEmisor" class='form-control m-bot15'>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="borrarEmisor">Aceptar</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>


		<div id="confirmacionIntegrador" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modificar Estatus de Integrador</h4>
					</div>
					<div class="modal-body">
						<p></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="btnactualizaintegradorestatus" onclick="actualizaEstatusIntegrador();">Aceptar</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>

		<!--*.JS Generales-->
		<script>
			var valorconsulta = <?php  echo $valorconsulta; ?>;
			//console.log(valorconsulta);
		</script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
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
		<script src="<?php echo $PATHRAIZ;?>/ayddo/js/consulta.js"></script>
		<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		</script>
	</body>
	<style type="text/css">
		.prueba{
			width:100%!important;
		}

		#td{
			width: 30% !important;
		}

		#inputs{
			text-align: center;
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


		.boton span.fa-check {
			opacity: 0;
		}
		.boton.active span.fa-check {
			opacity: 1;
		}

		#emisor{
			background-color: #0275d8!important;
			border-color: #0275d8!important;
		}


		.inhabilitar{
			background-color: #d9534f!important;
			border-color: #d9534f!important;
			margin-left: 10px;
			color: #FFFFFF;
		}

		.habilitar{
			margin-left: 10px;
		}

		.lectura{
			 background: rgb(238, 238, 238); color: rgb(128, 128, 128);
		}

		.lecturaCorreos{
			 background: rgb(238, 238, 238); color: rgb(128, 128, 128);
		}
		#buttonsSubEmi{
			padding: 15px 0;
			width: 29%;
			float: left;
		}
		.button_table{
			margin: 0 2px 0 2px;
		}

		.button_table {
		  display: inline-block;
		  padding: 5px 10px;
		  font-size: 10px;
		  cursor: pointer;
		  text-align: center;
		  text-decoration: none;
		  outline: none;
		  color: #fff;
		  background-color: #428bca;
		  border: none;
		  border-radius: 5px;
		  box-shadow: 0 5px #999;
		}

		.button_table:hover {background-color: #428bca}

		.button_table:active {
		  background-color: #5c95c6;
		  box-shadow: 0 5px #666;
		  transform: translateY(4px);
		}
	</style>
</html>
