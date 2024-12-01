<?php

$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
define('URL', 'http' . ((intval($_SERVER['SERVER_PORT']) == 443)?'s':'') . '://' . $_SERVER['HTTP_HOST'] . '/');

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
//include("../ajax/Pagos/catalogoEstatusOrdenes.php");
include($PATH_PRINCIPAL."/inc/customFunctions.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo = "Paycash";
$subsubmenuTitulo = "OrdenesPago";

$tipoDePagina = "lectura";
$idOpcion = 185;

$hoy = date("Y-m-d");

if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}

$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
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
	<title>.::Mi Red::.Reporte de Ordenes de Pagos</title>
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.powertip.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<style type="text/css">
	.align-right{text-align: right;}  
	.ui-autocomplete {
			max-height	: 190px;
			overflow-y	: auto;
			overflow-x	: hidden;
			font-size	: 12px;
			background-color: white;
                }
	.ui-helper-hidden-accessible, .inps{
	       display:none;
	           }</style>
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
						<!--Panel Principal-->
						<div class="panel panelrgb">
                                <div class="titulorgb-prealta">
                                    <span><i class="fa fa-search"></i></span>
                                    <h3>Consulta de Ordenes de Pago</h3><span class="rev-combo pull-right">Reporte</span>
                                </div>

								<div class="panel-body">
                                    <div class="well">
										<form name="formFiltros" id="frmFiltros" method="POST" action="">
                                            <div class="row">
                                                <input type="hidden" name="MostrarReporte" value="0">
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>RFC</label>
                                                        <input type="text" id="p_sRFC" name="p_sRFC" class='form-control m-bot15' maxlength="12" >
                                                    </div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Razón social</label>
														<input type="text" id="p_sRazonSocial" name="p_sRazonSocial" class='form-control m-bot15'>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Nombre Comercial</label>
                                                        <input type="text" id="p_sNombreComercial" name="p_sNombreComercial" class='form-control m-bot15'>
                                                    </div>
                                                </div>

												<div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Estatus</label>
                                                        
														<select class="form-control" id="p_nIdEstatus" name="p_nIdEstatus"  >
															<option value="-1">Seleccione</option>
															<?php echo $estatushtml; ?>
                                                  		</select>
                                                    </div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Fecha Inicial</label>
                                                        <input type="text" class="form-control" id="p_dFechaInicio" name="p_dFechaInicio" maxlength="10" value="<?php echo $hoy; ?>"/>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Fecha Final</label>
                                                        <input type="text" class="form-control" id="p_dFechaFin" name="p_dFechaFin" maxlength="10" value="<?php echo $hoy; ?>"/>
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <button class="btn btn-xs btn-info" id="btnBuscar" style="margin-top:20px;" type="button"> Buscar </button>
                                                    </div>
                                                </div>
                                            </div>
											<input type="hidden" id="p_nIdEmisor" name="p_nIdEmisor" class='form-control m-bot15'>
										</form>
                                    </div>
									
                                    
									<div class="row excel" id="exportar" style="display:none;">
										<div class="col-xs-1" >
												<form name="excel"  method="post" target="_blank" id="excel" action="<?php echo URL ?>paycash/ajax/Reportes/ReporteOrdenPagoExport.php">
													<input type="hidden" name="h_nIdEmisor" id="h_nIdEmisor" value="0"/>
                                                    <input type="hidden" name="h_nIdEstatus" id="h_nIdEstatus" value="0"/>
                                                    <input type="hidden" name="h_dFechaInicio" id="h_dFechaInicio" value="0"/>
                                                    <input type="hidden" name="h_dFechaFin" id="h_dFechaFin" value="0"/>
													<input type="hidden" name="h_ExportPdf" id="h_ExportPdf" value="1"/>
                                                    <button  class="btn btn-xs btn-info pdf"  style="margin-right:10px;">
                                                    <i class="fa fa-file-pdf-o"></i> PDF
                                                    </button>
												</form>
                                        </div>
                                        <div class="col-xs-1">
                                                <form name="pdf"  method="post"  target="_blank" id="pdf" action="<?php echo URL ?>paycash/ajax/Reportes/ReporteOrdenPagoExport.php">
													<input type="hidden" name="h_nIdEmisor" id="h_nIdEmisor" value="0"/>
                                                    <input type="hidden" name="h_nIdEstatus" id="h_nIdEstatus" value="0"/>
                                                    <input type="hidden" name="h_dFechaInicio" id="h_dFechaInicio" value="0"/>
                                                    <input type="hidden" name="h_dFechaFin" id="h_dFechaFin" value="0"/>
													<input type="hidden" name="h_ExportExcel" id="h_ExportExcel" value="1"/>
                                                    <button class="btn btn-xs btn-info excel" style="margin-left: 70px;">
            	                                    <i class="fa fa-file-excel-o"></i> Excel
                                                    </button>
												</form>
                                        </div>
									</div>

									<div id="gridbox" class="table-responsive">
										
									</div>
								</div>
						</div>
					
				</section>
			</section>

			<script>
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
			
			</script>


		<!--*.JS Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
		<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
		<!--Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-custom-scripts.js"></script>
        <script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
       
		<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.powertip-1.2.0/jquery.powertip.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/highcharts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/ayddo/js/ReporteOrdenPago.js"></script>

		<!--Autocomplete -->
    
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.core.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.widget.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.position.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.menu.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.autocomplete.js"></script> 

		
		<script type="text/javascript">
			$(document).ready(function() {
				initView();
			});
		</script>
	</body>

	
</html>