<?php
    $PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
    define('URL', 'http' . ((intval($_SERVER['SERVER_PORT']) == 443)?'s':'') . '://' . $_SERVER['HTTP_HOST'] . '/');

    include($PATH_PRINCIPAL."/inc/config.inc.php");
    include($PATH_PRINCIPAL."/inc/session.inc.php");
    $PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

    $submenuTitulo = "Contabilidad";
    $subsubmenuTitulo = "Comisiones";
    $tipoDePagina = "Lectura";
    $idOpcion = 202;

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
<title>.::Mi Red::.Reporte Operaciones</title>
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
        <h3>Operaciones</h3><span class="rev-combo pull-right">Consulta<br>de Reportes</span></div>

        <div class="panel">
            <div class="panel-body">
                <div class="well">
                    <form name="formFiltros" id="frmFiltros"  action="">
                    <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Seleccione Cliente</label>
                                    <select name="cmbClientes"  autocomplete="off"  id="cmbClientes" class="form-control">
                                </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Seleccione Estatus</label>
                                    <select name="cmbEstatus"  autocomplete="off"  id="cmbEstatus" class="form-control">
                                        <option value="-1" selec>Selecciona un Estatus</option>
                                        <option value="2">Pagada/Enviada</option>
                                        <option value="1">Pendiente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Fecha Inicial</label>
                                    <input type="hidden" id="fecha" value="<?php echo $hoy?>" class="form-control">
                                    <input type="text" onpaste="return false;" id="p_dFechaInicio" name="p_dFechaInicio"
                                        class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'p_dFechaInicio')" onKeyUp="validaFecha2(event,'p_dFechaInicio')">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Fecha Final</label>
                                    <input type="hidden" id="fecha" value="<?php echo $hoy?>" class="form-control">
                                    <input type="text" onpaste="return false;" id="p_dFechaFin" name="p_dFechaFin"
                                        class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'p_dFechaFin')" onKeyUp="validaFecha2(event,'p_dFechaFin')">
                                </div>
                            </div>
                        </div>
                   
                </div>
            </form>

                <button id="btnBuscar" class="btn btn-xs btn-info pull-right" style="margin-bottom:10px;"> Buscar </button>

                <div id="gridboxExport" class="adv-table table-responsive">
                        <div class="form-group col-xs-12" id="export" style="display: none">
							<div class="form-group col-xs-2" style="padding-left:40px;">										
                            <form id="pdf" name="pdf" method="post" target="_blank" action="<?php echo URL ?>ayddo/ajax/ReporteOrdenesExport.php" >
                                <input type="hidden" name="h_cmbClientes" id="h_cmbClientes" value="-1" />
                                <input type="hidden" name="h_dFechaInicio" id="h_dFechaInicio" value="" />
                                <input type="hidden" name="h_dFechaFin" id="h_dFechaFin" value="" />
                                <input type="hidden" name="h_ExportPdf" id="h_ExportPdf" value="1"/>
                                <button  class="btn btn-xs btn-info pdf"  style="margin-right:10px;">
                                    <i class="fa fa-file-pdf-o"></i> Exportar PDF
                                </button>
                            </form>
							</div>
							<div class="form-group col-xs-2" style="padding-left:40px;">										
                            <form id="excel" name="pdf" method="post" target="_blank" action="<?php echo URL ?>ayddo/ajax/ReporteOrdenesExport.php" >
                                <input type="hidden" name="h_tipoReporte" id="h_tipoReporte" value="0" />
                                <input type="hidden" name="h_cmbClientes" id="h_cmbClientes" value="-1" />
                                <input type="hidden" name="h_dFechaInicio" id="h_dFechaInicio" value="" />
                                <input type="hidden" name="h_dFechaFin" id="h_dFechaFin" value="" />
                                <input type="hidden" name="h_ExportExcel" id="h_ExportExcel" value="1"/>
                                <button  class="btn btn-xs btn-info excel"  style="margin-right:10px;">
                                    <i class="fa fa-file-excel-o"></i> Exportar Excel
                                </button>
                            </form>
							</div>
				</div>
				</div>
                <div id="gridbox" class="table-responsive">
                                        
                                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
</div>

        <div id="confirmacion" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Liberar Pago</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                        <input type="hidden" id="corteId" class='form-control m-bot15'>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="liberaPago">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
	BASE_PATH		= "<?php echo $PATHRAIZ;?>";
    BASE_URL        = "<?php echo URL?>";
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
<script src="<?php echo $PATHRAIZ;?>/ayddo/js/ordenesPago.js"></script>
<script src="<?php echo URL ?>inc/js/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo URL ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Cierre del Sitio-->
<script type="text/javascript">
			$(document).ready(function() {
				initView();
			});
		</script>
</body>
</html>
<style type="text/css"> 
        
        #thMonto{
            width: 15% !important;
            font-weight: bold !important;
            color: black !important;
        }

        #tblGridBox2{
            width: 100% !important;
        }

</style>
