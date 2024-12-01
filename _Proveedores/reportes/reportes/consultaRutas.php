<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL."/_Proveedores/proveedor/ajax/Cat_familias.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Consulta Rutas";
$subsubmenuTitulo	= "Consulta Rutas";
$tipoDePagina = "mixto";
$idOpcion = 329;


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
		<title>.::Mi Red::.Consulta Rutas</title>
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
		<link href="<?php echo $PATHRAIZ;?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
		
		<style>
			.align-right { text-align: right; }
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
                    <div class="panelrgb" style="max-width: 95%!important;">
                        <div class="titulorgb-prealta">
                            <span><i class="fa fa-money"></i></span>
                            <h3>RUTAS PROVEEDOR</h3><h3 id="etiquetaTipoUsuario"></h3><span class="rev-combo pull-right">Rutas</span>
                        </div>
                        <div class="panel" style="max-width: 100%!important;">
                            <div class="panel-body">
                                <div class="well">
                                    <div class="row">
                                        <div class="form-group col-xs-3" id="">
                                            <label class="control-label">Familia </label>
                                            <select id="select_familia" class="form-control">
                                                <option value="2">Servicios</option>
                                                <option value="1">Telefonía</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-xs-3" id="">
                                            <label class="control-label">Proveedor </label>
                                            <select id="select_proveedor" class="form-control"></select>
                                        </div>
                                        
                                        <div class="form-group col-xs-3" id="">
                                            <label class="control-label">Producto</label>
                                            <select id="select_producto" class="form-control">
                                            </select>
                                        </div>

                                        <div class="form-group col-xs-3" id="">
                                            <label class="control-label">Estatus producto</label>
                                            <select id="select_estatus" class="form-control">
                                                <option value="-1">Todo</option>
                                                <option value="0">Activo</option>
                                                <option value="1">Inactivo</option>
                                            </select>
                                        </div>

                                    </div>  
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <form method="post" id="exportar_excel" action="../ajax/exportRutasProveedoresExcel.php" style="margin-top:10px;margin-left:-15px;">
                                                <input type="hidden" name="id_familia_excel" id="id_familia_excel">
                                                <input type="hidden" name="id_proveedor_excel" id="id_proveedor_excel">
                                                <input type="hidden" name="id_producto_excel" id="id_producto_excel">
                                                <input type="hidden" name="id_estatus_producto" id="id_estatus_producto">
                                                <input type="hidden" name="tipo" id="tipo">
                                                <div class="form-group col-xs-6">
                                                    <button class="btn btn-xs btn-info excel" id="btn_ExportarRutasProveedoresExcel" style="display: none; margin-bottom:10px;"><i class="fa fa-file-excel-o"></i> Excel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-xs-6">
                                            <button id="btn_buscar_rutas" class="btn btn-xs btn-info pull-right" style="margin-top:10px">Buscar</button>
                                        </div>	
                                    </div>                           	
                                </div>
                                <div id="gridboxExport" class="adv-table table-responsive">
                                    <div id="gridbox" class="">
                                        
                                        <div class="col-lg-12">
                                            <div class="row" id="reporte">
                                                <div class="adv-table col-12">
                                                    <div class=" " style="overflow-x: scroll; height: auto;">
                                                        <div class="box-body table-responsive">
                                                            <table id="tabla_rutas_proveedores" class="table table-bordered table-striped" style="width: 100%; display: none;">
                                                                <thead>
                                                                    <tr>
                                                                    <th>FAMILIA</th>
                                                                    <th>ID PROVEEDOR</th>
                                                                    <th>NOMBRE COM PROVEEDOR</th>
                                                                    <th>NOMBRE PROVEEDOR</th>
                                                                    <th>ID RUTA</th>
                                                                    <th>RUTA</th>
                                                                    <th>ID PRODUCTO</th>
                                                                    <th>PRODUCTO</th>
                                                                    <th>ESTATUS PRODUCTO</th>
                                                                    <th>% USUARIO MAX POSIBLE</th>
                                                                    <th>IMP USUARIO MAX POSIBLE</th>
                                                                    <th>% COBRO PROVEEDOR</th>
                                                                    <th>IMP COBRO PROVEEDOR</th>
                                                                    <th>% PAGO PROVEEDOR</th>
                                                                    <th>IMP PAGO PROVEEDOR</th>
                                                                    <th>SUMA INGRESO RED</th>
                                                                    <th>MARGEN MINIMO</th>
                                                                    <th>MAXIMO COMISION EN RUTAS</th>
                                                                    <th>% MAX COMISION CADENA</th>
                                                                    <th>IMP MAX COMISION CADENA</th>
                                                                    <th>MARGEN RED</th>
                                                                    </tr>
                                                                </thead>
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
                    </div>
                </div>
            </div>
        </section>
    </section>

	
	</body>
	<!--*.JS Generales-->
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
		 
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
				
	<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/RE.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>	
    <script src="<?php echo $PATHRAIZ;?>/_Proveedores/reportes/js/consultaRutasProveedores.js"></script>
	<script type="text/javascript">		
		
		// initViewConsultaCorte();
        initViewConsultaRutas();
	</script> 	
</html>