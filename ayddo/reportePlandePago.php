<?php
    $PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
    define('URL', 'http' . ((intval($_SERVER['SERVER_PORT']) == 443)?'s':'') . '://' . $_SERVER['HTTP_HOST'] . '/');

    include($PATH_PRINCIPAL."/inc/config.inc.php");
    include($PATH_PRINCIPAL."/inc/session.inc.php");
    $PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

    $submenuTitulo = "Contabilidad";
    $subsubmenuTitulo = "Comisiones";
    $tipoDePagina = "Lectura";
    $idOpcion = 262;

    $hoy = date("Y-m-d");

    if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
        header("Location: " . URL ."error.php");
        exit();
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
<title>.::Mi Red::.Reporte Plan de Pagos </title>
<!-- Núcleo BOOTSTRAP -->
<link href="<?php echo URL ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo URL ?>css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="<?php echo URL ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo URL ?>assets/opensans/open.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="<?php echo URL ?>css/miredgen.css" rel="stylesheet">
<link href="<?php echo URL ?>css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo URL ?>assets/bootstrap-datepicker/css/datepicker.css" />
<link href="<?php echo URL ?>css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

<style type="text/css">
    .nav li a {
        background:#0c9ba0;
        color:#FFF;
        display:block;
        border:1px solid;
        padding:10px 12px;
        }
    .nav li a:hover {
    background:#0fbfc6;
    }
</style>
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
                <h3>Reporte de plan de pago</h3><span class="rev-combo pull-right">Reporte<br>Plan de pago</span>
            </div>

            <div class="panel">
                
                <div class="panel-body">
                    <div class="well" id="divBusquedas">
                        <div class="row">
                             <div class="form-group col-xs-3">
                                 <label class="control-label">Fecha de Solicitud:</label>
                                 <input type="date" id="dFechaInicio" name="dFechaInicio" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;"/>
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
                    <div id="gridboxExport" class="adv-table table-responsive">
                        <div class="form-group col-xs-12" id="export" style="display: none">
                            <div class="form-group col-xs-2" style="padding-left:40px;">										
                                <form id="pdf" name="pdf" method="post" target="_blank" action="<?php echo URL ?>ayddo/ajax/ReportePlandePagoExport.php" >
                                    <input type="hidden" name="h_fechaSolicitud" id="h_fechaSolicitud" value="" />
                                    <input type="hidden" name="h_ExportPdf" id="h_ExportPdf" value="1"/>
                                    <button  class="btn btn-xs btn-info pdf"  style="margin-right:10px;">
                                        <i class="fa fa-file-pdf-o"></i> Exportar PDF
                                    </button>
                                </form>
                            </div>
                            <div class="form-group col-xs-2" style="padding-left:40px;">										
                                <form id="excel" name="pdf" method="post" target="_blank" action="<?php echo URL ?>ayddo/ajax/ReportePlandePagoExport.php" >
                                    <input type="hidden" name="h_fechaSolicitud" id="h_fechaSolicitud" value="" />
                                    <input type="hidden" name="h_ExportExcel" id="h_ExportExcel" value="1"/>
                                    <button  class="btn btn-xs btn-info excel"  style="margin-right:10px;">
                                        <i class="fa fa-file-excel-o"></i> Exportar Excel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">  
                        <div class="tab-pane active" id="tab1"> 
                            <div id="gridbox" class="adv-table table-responsive" >
                                <table id="data" class="display table table-bordered table-striped" style=" width: auto;">
                                    <thead>
                                        <tr>
                                            <!--<th id="thId">ID</th>-->
                                            <th id="thRFC">RFC</th>
                                            <th id="thRazonSocial">Razon Social</th>
                                            <th id="thNombre">CLABE interbancaria</th>
                                            <th id="thCorreo">Saldo disponible</th>
                                            <th id="thTelefono">Monto solicitado</th>
                                            <th id="thCuenta">Comision por Orden</th>
                                            <th id="thDetalles">Total a depositar</th>
                                        </tr>
                                    </thead>    
                                    <tbody >
                                        
                                        <!--esta informacion se llena desde el Jsavascript reportePlandePago.js-->
                                        
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

<script>
	BASE_PATH		= "<?php echo $PATHRAIZ;?>";
	ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";

			
</script>

<!--*.JS Generales-->
<script src="<?php echo URL ?>inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
<script src="<?php echo URL ?>inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo URL ?>inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo URL ?>inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo URL ?>inc/js/respond.min.js" ></script>
<script src="<?php echo URL ?>inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

<!--Generales-->
<script src="<?php echo URL ?>inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="<?php echo URL ?>inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="<?php echo URL ?>inc/js/common-scripts.js"></script>
<script src="<?php echo URL ?>/inc/js/common-custom-scripts.js"></script>
<script src="<?php echo URL ?>inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo URL ?>inc/js/_Reportes2.js" type="text/javascript"></script>
<!--<script src="<?php echo $PATHRAIZ;?>/paynau/js/soporte/reporteProveedores.js"></script>
<script src="<?php echo $PATHRAIZ;?>/paynau/js/soporte/ordenesProveedores.js"></script>-->
<script src="<?php echo $PATHRAIZ;?>/ayddo/js/reportePlandePago.js?<?php echo rand() ?>"></script>
<script src="<?php echo URL ?>inc/js/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo URL ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
<!--Cierre del Sitio-->
<script type="text/javascript">
    var BASE_URL = '<?php echo URL  ?>';
			$(document).ready(function() {
				initView();
			});
		</script>
</body>
</html>

