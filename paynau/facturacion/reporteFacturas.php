<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$tipoDePagina = "Mixto";
$idOpcion = 257;
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( esLecturayEscrituraOpcion($idOpcion) ) {
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
	<link rel="shortcut icon" href="<?php echo $BASE_PATH;?>/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $BASE_PATH;?>/img/favicon.ico" type="image/x-icon">
	<title>.::Mi Red::.Reporte Facturas</title>
	<!-- Núcleo BOOTSTRAP -->
	<link rel="stylesheet" href="<?php echo $BASE_PATH;?>/css/themes/base/jquery.ui.all.css" />

	<link href="<?php echo $BASE_PATH;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/bootstrap-reset.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/style-autocomplete.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/jquery.alerts.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/jquery.powertip.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $BASE_PATH;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $BASE_PATH;?>/assets/opensans/open.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $BASE_PATH;?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/style-responsive.css" rel="stylesheet" />

	<link rel="stylesheet" type="text/css" href="<?php echo $BASE_PATH;?>/assets/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" href="<?php echo $PATHRAIZ?>/assets/data-tables/DT_bootstrap.css" />

	<style>
		.align-right{
			text-align : right;
		}

		.list-inline{
			font-size:12px;
		}
	</style>

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical---->
<!--Función "Include" del Menú-->
<?php include("../../inc/menu.php"); ?>
<!--Final del Menú Vertical----->
<!--Contenido Principal del Sitio-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="panel panelrgb">
            <div class="titulorgb-prealta">
                <span><i class="fa fa-users"></i></span>
                <h3>Reporte de ventas de CFDI´s</h3>
                <span class="rev-combo pull-right">Operaciones - Facturación<br/>&nbsp;</span>
            </div>
            <div class="panel-body">
                <div class="well" id="divBusqueda">
                   <div class="row">
                        <div class="form-group col-xs-3">
                            <label class="control-label">Unidad de Negocio:</label>
                            <select name="opcionBusqueda" id="opcionBusqueda" class="form-control m-bot15">
                                <!-- <option value="2">Empresa</option> -->
                            </select>
                        </div>
                        <div class="form-group col-xs-3">
                            <label class="control-label">Fecha Inicial:</label>
                            <input type="date" id="dFechaInicio" name="dFechaInicio" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;"/>
                        </div>
                        <div class="form-group col-xs-3">
                            <label class="control-label">Fecha Final:</label>
                            <input type="date" id="dFechaFin" name="dFechaFin" class="form-control "/>
                        </div>
                        <div class="form-group col-xs-3">
                            <button class="primary btn btn-guardar" style="margin-top: 20px;" id="btnBuscarOperaciones">Buscar</button>
                        </div>									
                    </div>
                    <div class="row" id="busquedaFiltro" style="display: none;">
                        <div class="form-group col-xs-3">
                            <label class="control-label">Empresa:</label>
                            <select id="selcetBusqueda" class="form-control m-bot15"></select>
                        </div>
                    </div>
                </div>                

                <div class="form-group col-xs-12">
                    <div id="gridboxExport" class="adv-table table-responsive" style="overflow-y: auto;">
                        <div id="gridbox" class="">
                            <table id="ventaFolios" class="display table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Razon Social Emisor</th>;
                                        <th>RFC Emisor</th>;
                                        <th>Folio fiscal</th>;
                                        <th>Fecha timbrado</th>;
                                        <th>Monto total</th>;
                                        <th>Razon Social Receptor</th>;
                                        <th>RFC del Receptor</th>;
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                <div class="well" id="div_Exportar" style="display: none;">
                    <form method="post" id="exportar_excel" action="../../ajax/facturacion/reporteFacturaExcel.php">
                        <input type="hidden" name="fechaIni_excel" id="fechaIni_excel" class="fechaIni_reporte">
                        <input type="hidden" name="fechaFin_excel" id="fechaFin_excel" class="fechaIni_reporte">
                        <input type="hidden" name="nIdProveedor_excel" id="nIdProveedor_excel" class="fechaIni_reporte">
                        <input type="hidden" name="nIdEmpresa_excel" id="nIdEmpresa_excel" class="fechaIni_reporte">
                        <button class="btn btn-xs btn-info pull-left excel" id="btn_ExportarExcel" style=" margin-top:20px;margin-bottom:10px;"><i class="fa fa-file-excel-o"></i> Excel
                        </button>                                            
                    </form>
                    <!-- <form method="post" id="exportar_PDF" action="../../ajax/facturacion/reporteOperacionesPDF.php">
                        <input type="hidden" class="fechaIni_reporte">
                        <input type="hidden" class="fechaFin_reporte">
                        <input type="hidden" class="nIdProveedor_reporte">
                        <input type="hidden" class="nIdEmpresa_reporte">
                        <button class="btn btn-xs btn-info pull-left pdf" id="btn_ExportarPDF" style=" margin-top:20px;margin-bottom:10px; margin-left: 20px;"> <i class="fa fa-file-excel-o" style="display: none;"></i> PDF
                        </button>                                            
                    </form>  -->
                </div>
            </div>
        </div>
    </section>
</section>

<!--*.JS Generales-->
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $BASE_PATH;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/respond.min.js" ></script>
<script type="text/javascript" src="<?php echo $BASE_PATH;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<!--Generales-->
<script src="<?php echo $BASE_PATH;?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/common-custom-scripts.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="<?php echo $BASE_PATH;?>/inc/input-mask/input-mask.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.autocomplete.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.alerts.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.powertip-1.2.0/jquery.powertip.js"></script>
<script type="text/javascript">
    BASE_PATH       = "<?php echo $PATHRAIZ;?>";
</script>
<script src="<?php echo $BASE_PATH;?>/paynau/js/facturacion/reporteFacturas.js?<?php echo rand() ?>"></script>

<!--Cierre del Sitio-->
</body>
</html>