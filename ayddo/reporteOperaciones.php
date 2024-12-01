<?php
    $PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
    define('URL', 'http' . ((intval($_SERVER['SERVER_PORT']) == 443)?'s':'') . '://' . $_SERVER['HTTP_HOST'] . '/');

    include($PATH_PRINCIPAL."/inc/config.inc.php");
    include($PATH_PRINCIPAL."/inc/session.inc.php");
    $PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

    $submenuTitulo = "Contabilidad";
    $subsubmenuTitulo = "Comisiones";
    $tipoDePagina = "Lectura";
    $idOpcion = 258;

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
                
                    <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Seleccione el tipo de Reporte</label>
                                    <select name="tipoReporte" id="tipoReporte" class="form-control">
                                        <option value="0" selec>Selecciona una opcion</option>
                                        <option value="1">Metodo Pago</option>
                                        <option value="2">Proveedor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Seleccione Cliente</label>
                                    <select name="cmbClientes"  autocomplete="off"  id="cmbClientes" class="form-control">
                                        <option value="-1">--</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Fecha Inicial</label>
                                    <input type="hidden" id="fecha" value="<?php echo $hoy?>" class="form-control">
                                    <input type="text" onpaste="return false;" id="p_dFechaInicio"
                                        class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'p_dFechaInicio')" onKeyUp="validaFecha2(event,'p_dFechaInicio')">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Fecha Final</label>
                                    <input type="hidden" id="fecha" value="<?php echo $hoy?>" class="form-control">
                                    <input type="text" onpaste="return false;" id="p_dFechaFin"
                                        class='form-control m-bot15' data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'p_dFechaFin')" onKeyUp="validaFecha2(event,'p_dFechaFin')">
                                </div>
                            </div>
                        </div>
                   
                </div>


                <button id="btnBuscar" class="btn btn-xs btn-info pull-right" style="margin-bottom:10px;"> Buscar </button>

                <div id="gridboxExport" class="adv-table table-responsive">
                        <div class="form-group col-xs-12" id="export" style="display: none">
							<div class="form-group col-xs-2" style="padding-left:40px;">										
                            <form id="pdf" name="pdf" method="post" target="_blank" action="<?php echo URL ?>ayddo/ajax/ReporteOperacionesExport.php" >
                                <input type="hidden" name="h_tipoReporte" id="h_tipoReporte" value="0" />
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
                            <form id="excel" name="pdf" method="post" target="_blank" action="<?php echo URL ?>ayddo/ajax/ReporteOperacionesExport.php" >
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
                            <div class="form-group col-xs-2" style="padding-left:40px;">
                                <form id="excel" name="pdf" method="post" target="_blank" action="<?php echo URL ?>ayddo/ajax/ReporteOperacionesGlobalExport.php" >
                                    <input type="hidden" name="h_tipoReporte" id="h_tipoReporte" value="1" />
                                    <input type="hidden" name="h_cmbClientes" id="h_cmbClientes" value="-1" />
                                    <input type="hidden" name="h_dFechaInicio" id="h_dFechaInicio" value="" />
                                    <input type="hidden" name="h_dFechaFin" id="h_dFechaFin" value="" />
                                    <input type="hidden" name="h_ExportExcel" id="h_ExportExcel" value="1"/>
                                    <button id="rGloblal" class="btn btn-xs btn-info excel"  style="margin-right:10px;">
                                        <i class="fa fa-file-excel-o"></i> Reporte Global
                                    </button>
                                </form>
                            </div>
				</div>

				<div id="gridbox" class="adv-table table-responsive" >
							<table id="data" class="display table table-bordered table-striped" style=" width: 100%; display:none;">
								<thead>
									<tr>
										<th id="thMonto">Metodo de Pago</th>
                                        <th id="thMonto">Fecha</th>
										<th id="thMonto">Operaciones</th>
										<th id="thMonto">Importe</th>
										<th id="thMonto">Comision</th>
                                        <th id="thMonto">Total Neto</th>
                                        <th id="thMonto">Acciones</th>
								    </tr>
								</thead>	
								<tbody >

								</tbody>
							</table>
				</div>
				</div>
            <h4 id="titulo" style="display: none">Detalle de Operaciones</h4>
            <div class="row excel" id="detalleOperaciones" style="display: none;">
             <div class="col-xs-1" style="float: right;margin-right: 90px;">
                <form id="excel2" name="excel2" method="post" action="<?php echo URL ?>ayddo/ajax/DetalleOperacionesExport.php" >
                    <input type="hidden" name="h_tipoReporte" id="h_tipoReporte" value="0" />
                    <input type="hidden" name="h_cmbClientes" id="h_cmbClientes" value="-1" />
                    <input type="hidden" name="h_dFechaInicio" id="h_dFechaInicio" value="" />
                    <button class="btn btn-xs btn-info">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </button>
                </form>
            </div>


                <div id="gridbox" class="adv-table table-responsive">
                    <table id="tblGridBox2" class="display table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th >Folio</th>
                                <th id="thMonto">Proveedor</th>
                                <th id="thMonto">Metodo de Pago</th>
                                <th id="thMonto">Monto</th>
                                <th id="thMonto">Comision</th>
                                <th id="thMonto">Fecha</th>
                                <th id="thMonto">Hora</th>
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
<script src="<?php echo $PATHRAIZ;?>/ayddo/js/ReporteOperaciones.js?<?php echo rand() ?>"></script>
<script src="<?php echo URL ?>inc/js/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo URL ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Cierre del Sitio-->
<script type="text/javascript">
    var BASE_URL = '<?php echo URL  ?>';
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
