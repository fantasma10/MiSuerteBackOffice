<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL."/_Proveedores/proveedor/ajax/Cat_familias.php");
include("../ajax/catalogoEstatusOrdenes.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];
$submenuTitulo		= "Ventas Por Dia";
$subsubmenuTitulo	= "Ventas Por Dia";
$tipoDePagina = "mixto";
$idOpcion = 210; // verificar


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
		<title>.::Mi Red::.Ventas Por Dia</title>
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
		<style type="text/css">
			.panelrgb,
            .panel {max-width: 100%;}

			.align-right{text-align: right;}  
			.ui-autocomplete-loading {
                    background: white url("<?php echo $PATHRAIZ;?>/img/loadAJAX.gif") right center no-repeat;
                }
                .ui-autocomplete {
                    max-height: 190px;
                    overflow-y: auto;
                    overflow-x: hidden;
                    font-size: 12px;
                }
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
							<span><i class="fa fa-user"></i></span>
							<h3>Ventas Por Dia</h3>
	                        <span class="rev-combo pull-right">Ventas Por Dia</span>
						</div>
						<div class="panel">
							<div class="panel-body">
								<div class="well">
									<div class="form-group col-xs-12">

										<div class="row">
											<div class="form-group col-xs-4">
							                    <label class="control-label">Cadena</label>
							                    <select id="cmb_cadena" class="form-control">
							                    </select>
	                                      	</div>
	                                      	<div class="form-group col-xs-4" >
		                                        <label class="control-label">SubCadena</label>
		                                        <br/>
		                                        <select name="" id="cmb_subcadena" class="form-control m-bot15">
		                                        </select>
		                                    </div>		                                
		                                    <div class="form-group col-xs-4" >
		                                        <label class="control-label">Corresponsal</label>
		                                        <br/>
		                                        <input type="hidden" id="idCorresponsal">
		                                        <select name="" id="cmb_corresponsal" class="form-control m-bot15">
		                                        </select>
		                                    </div>
		                                </div>
	                                    <div class="row">
	                                      	<div class="form-group col-xs-3">
							                    <label class="control-label">RFC</label>
							                    <input type="text" id="txtRFC" class="form-control m-bot15" autocomplete="off">
	                                      	</div>
	                                      	<div class="form-group col-xs-5">
							                    <label class="control-label">Cliente</label>
							                    <input type="text" id="txtCliente" class="form-control m-bot15" autocomplete="off">
	                                      	</div>
	                                    </div>
	                                    <div class="row">
	                                    	<div class="form-group col-xs-4">
							                    <label class="control-label">Forelo</label>
							                    <input type="text" id="txtForelo" class="form-control m-bot15" autocomplete="off">
	                                      	</div>
	                                      	<div class="form-group col-xs-4">
							                    <label class="control-label">Cta Contable</label>
							                    <input type="text" id="txtCta" class="form-control m-bot15" autocomplete="off">
	                                      	</div>
	                                      	<div class="form-group col-xs-4">
								                <label class="control-label">Familia</label>
								                <select id="familia_select" class="form-control">
								                </select>
		                                    </div>                                 	
	                                    </div>
										<div class="row">
							                <div class="form-group col-xs-4">
							                    <label class="control-label">Fecha Inicial</label>
							                    	<input type="text" id="fecIni" name="fecIni" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecIni')" onKeyUp="validaFecha2(event,'fecIni')">
	                                      		<div class="help-block">Elegir Fecha.</div>
	                                      	</div>
							                <div class="form-group col-xs-4">
							                    <label class=" control-label">Fecha Final</label>

							                    <input type="text" id="fecFin" name="fecFin" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecFin')" onKeyUp="validaFecha2(event,'fecFin')">
							                     <div class="help-block">Elegir Fecha.</div>
											</div>	
											<div class="form-group col-xs-4">
											<button class="btn btn-xs btn-info pull-right" style="margin-top:20px;" id="btn_buscar_ventas"> Buscar </button>
										</div>								
										</div>



									</div>

									<div>
										<form method="post" id="exportar_excel" action="../ajax/exportarVentasxdia.php">
	                                        <input type="hidden" name="fecha1_excel" id="fecha1_excel">
	                                        <input type="hidden" name="fecha2_excel" id="fecha2_excel">
	                                        <input type="hidden" name="familia_select_excel" id="familia_select_excel">
	                                        <input type="hidden" name="cadena_excel" id="cadena_excel">
	                                        <input type="hidden" name="subcadena_excel" id="subcadena_excel">
	                                        <input type="hidden" name="corresponsal_excel" id="corresponsal_excel">
	                                        <input type="hidden" name="cadena_txt" id="cadena_txt">
	                                      	<div class="form-group col-xs-6">
												<button class="btn btn-xs btn-info excel" id="btn_ExportarVentasXDia" style="display: none; margin-bottom:10px;"><i class="fa fa-file-excel-o"></i> Excel
	                                        	</button>
	                                        </div>
	                                	</form> 										
									</div> 
								</div>
									
			                    <div id="gridboxExport" class="adv-table table-responsive" style="overflow-y: auto;" >
			                        <div id="gridbox" class="table-responsive">
			                            <table id="tabla_ventas" class="table table-bordered table-striped" style="width: 100%;display:none;">
			                                <thead>
			                                    <tr>                                                 
			                                        <th>Mes</th>
													<th>Fec Alta Operacion</th>
													<th>Id Cadena</th>
													<th>Nombre Cadena</th>
													<th>Id SubCadena</th>
													<th>Nombre SubCadena</th>
													<th>Id Corresponsal</th>
													<th>Nombre Corresponsal</th>
													<th>RFC Cliente</th>
													<th>Id Proveedor</th>
													<th>Nombre Proveedor</th>
													<th>RFC Proveedor</th>
													<th>Id Familia</th>
													<th>Desc Familia</th>
													<th>Id Emisor</th>
													<th>Desc Emisor</th>
													<th>Id Producto</th>
													<th>Desc Producto</th>
													<th>NumCuenta</th>
													<th>Cta Contable</th>
													<th>Ventas</th>
													<th>Importe</th>
													<th>Retiros</th>
													<th>CxP Cliente</th>
													<th>CxC Cliente</th>
													<th>Com Integradores</th>
													<th>Com Recibo</th>
													<th>CPS</th>
													<th>Ingreso</th>
													<th>CxC Proveedor</th>
													<th>CxP Proveedor</th>
			                                    </tr>
			                                </thead>    
			                                <tbody >
			                                </tbody>
			                            </table>
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
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>		

	<script src="<?php echo $PATHRAIZ;?>/_Proveedores/reportes/js/ventasxdia.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />

	<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

	<!-- <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.core.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.widget.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.position.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.menu.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.autocomplete.js"></script>  -->


	<script type="text/javascript">	
		BASE_PATH = "<?php echo $PATHRAIZ;?>";
		ID_PERFIL = "<?php echo $_SESSION['idPerfil'];?>";	 
		initViewConsultaCorte();
	</script>
	</body>   	
</html>
