<?php

$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Contabilidad";
$subsubmenuTitulo	= "Proveedores";

$tipoDePagina = "mixto";
$idOpcion = 164;

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
	<title>.::Mi Red::.Consulta de Corte</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
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
							<h3>Cortes</h3><span class="rev-combo pull-right">Consulta<br>de Reportes</span></div>
							<div class="panel">
								<div class="panel-body">
									<div class="well">
										<form class="form-horizontal" id="formFiltros">

											<div class="form-group col-xs-4" style="margin-right:10px;">
												<label class="control-label">Periodo:</label>
												<br/>
												<select name="periodo" id="periodo" class="form-control m-bot15">
													<option value="-1">Seleccione</option>
													<?php 
													$result = $MWDB->SP("CALL `pronosticos`.`sp_select_periodo`();") or die(mysql_error());
													while($row = mysqli_fetch_array($result)){
														$year = $row["anio"];
														$mes = $row["mes"];
														$numMes = $row["numMes"];
														echo '<option value="'.$numMes."-".$year.'">'.$mes."-".$year.'</option>';                    
													} 
													mysqli_free_result($result);
													?>
												</select>
											</div>								
											
											<div class="form-group col-xs-4" style="margin-right:10px;">
												<label class="control-label">De:</label>
												<br/>
												<input type="text" id="fecha1" name="fecha1" class="form-control form-control-inline input-medium default-date-picker"
												onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10"
												value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecha1')" onKeyUp="validaFecha2(event,'fecha1')">
												<div class="help-block">Elegir Fecha.</div>
											</div>
											
											<div class="form-group col-xs-4" style="margin-right:10px;">
												<label class="control-label">De:</label>
												<br/>
												<input type="text" id="fecha2" name="fecha2" onpaste="return false;" class="form-control form-control-inline input-medium default-date-picker"
												data-date-format="yyyy-mm-dd" maxlength="10"  value="<?php echo $g_hoy; ?>"
												onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
												<div class="help-block">Elegir Fecha.</div>
											</div>
											
											<div class="form-group col-xs-4">

											</div>
											
											<div class="form-group col-xs-4 ocultarSeccion" style="margin-right:16px;" id="divFechaPago">
												<br />
												<label class="control-label">Fecha de Pago</label>
												<br />
												<input type="text" id="fecha11" name="fecha11" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="" onKeyPress="return validaFecha(event,\'fecha11\')" onKeyUp="validaFecha2(event,\'fecha11\')">
											</div>
											
											<div class="form-group col-xs-4 ocultarSeccion" style="margin-right:16px;">

											</div>
											
											<div class="form-group col-xs-4 ocultarSeccion">

											</div>


										</form>
									</div>

									<button class="btn btn-xs btn-info pull-right" style="margin-bottom:10px;" onClick="corteDetalles();"> Buscar </button>
									<div class="well" id="detalles" style="display: none;">
										<div class="form-group col-xs-12">
											<div id="operacionesDetalles" class="adv-table table-responsive">
												<table id="opDetalles" class="display table table-bordered table-striped">
													<thead>
														<tr>
															<th>Fecha Inicio</th>
															<th>Fecha Fin</th>
															<th>Total de Operaciones</th>
															<th>Monto</th>
														</tr>   
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>											
										</div>
										<div class="well" id="corteDetalles">					
											<div>
												<h4><span><i class="fa fa-calculator"></i></span>Detalle del corte</h4>
											</div>
											<div class="well" id="familiasInfo" style="margin-top:30px;width: 45%;height: 300px;overflow: scroll;">
												<form class="form-horizontal" id="formFiltros">	
													<div>
														<h4><span><i class="fa fa-money"></i></span> Métodos de Pago</h4>
													</div>
													<div class="form-group col-xs-12" id="metodosPago">

													</div>
												</form>										
											</div>
											<div class="well" id="proveedoresInfo" style="margin-top:30px;width: 50%;margin-left: 30px; height: 300px; overflow: scroll;">
												<form class="form-horizontal" id="formFiltros">	
													<div>
														<h4><span><i class="fa fa-gamepad"></i></span> Juegos</h4>
													</div>
													<div class="form-group col-xs-12" id="juegos">
													</div>
												</form>										
											</div>
											<div class="form-group col-xs-12">
												<div class="form-group col-xs-6">
													<div class="form-group col-xs-12">
														<div class="form-group col-xs-3" style="text-align:left;">
															<label class="control-label">Totales : </label>
														</div>
														<div class="form-group col-xs-4">
															<input type="text" id="totalOpsOperaciones" class="form-control "   style="width:100%;" disabled>
														</div>
														<div class="form-group col-xs-4">
															<input type="text" id="totalOperaciones" class="form-control "  style="width:100%;" disabled>
														</div>
													</div>
												</div>
												<div class="form-group col-xs-6">
													<div class="form-group col-xs-12">
														<div class="form-group col-xs-4" style="text-align:left;">
															<label class="control-label">Totales : </label>
														</div>
														<div class="form-group col-xs-4">
															<input type="text" id="totalOpsJuegos" class="form-control "   style="width:100%; margin-left:10px;" disabled>
														</div>
														<div class="form-group col-xs-4">
															<input type="text" id="totalJuegos" class="form-control "  style="width:100%;" disabled>
														</div>
													</div>
												</div>
											</div>
										</div>



										<div class="col-xs-6">     
											<div class="area_contenido" style="padding:0px 0px 0px 0px; width:100%; float:left;">
												<div id="contenedor" float:left;>
													<div id="grafica2" >
														<?php echo $error; ?>
													</div>
												</div> 
												<br />    
											</div>
											<div class="sombra_inferior" style="float:left; margin-top:0px;"></div>
											<!--Cierre-->
										</div>

										<div class="col-xs-6">     
											<div class="area_contenido2" style="padding:0px 0px 0px 0px; width:100%; float:left;">
												<div id="contenedor2" float:left;>
													<div id="grafica1" >
														<?php echo $error; ?>
													</div>
												</div> 
												<br />    
											</div>
											<div class="sombra_inferior" style="float:left; margin-top:0px;"></div>
											<!--Cierre-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></div></section>
				</section>
				<!--*.JS Generales-->
				<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
				<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
				<!--Generales-->
				<script src="<?php echo $PATHRAIZ;?>/inc/js/RE.js" type="text/javascript"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/_Reportes2.js" type="text/javascript"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.autocomplete.js" type="text/javascript"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
				<!--Elector de Fecha-->
				<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
				<!--script src="../../inc/js/advanced-form-components.js"></script-->
				<!-- script para la creacion de cortes -->
				<script src="<?php echo $PATHRAIZ;?>/misuerte/js/cortes/consultaCorte.js"></script><script src="<?php echo $PATHRAIZ; ?>/inc/js/highcharts.js"></script>
				<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
				<!--Cierre del Sitio-->
				<script>
					BASE_PATH		= "<?php echo $PATHRAIZ;?>";
					ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
					ES_ESCRITURA	= "<?php echo $esEscritura;?>";

							//Funcion para la inicializar la creacion de cortes
						</script>
					</body>
					</html>


					<style type="text/css">



						input {
							text-align: right;
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


					</style>