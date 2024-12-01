<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];
$submenuTitulo = "Tipo de comercio";
$subsubmenuTitulo = "Tipo Comercio";
$tipoDePagina = "mixto";
$idOpcion = 281;
$parametro_proveedor = $_POST["txtidProveedor"];
if (!desplegarPagina($idOpcion, $tipoDePagina)) {
    header("Location: $PATHRAIZ/error.php");
    exit();
}
$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
    $esEscritura = true;
}
$hoy = date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Favicon-->
        <link rel="shortcut icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
        <title>.::Mi Red::.Anuncios</title>
        <!-- Núcleo BOOTSTRAP -->
        <!-- <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet"> -->
        <!--<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap3.min.css" rel="stylesheet">-->
        <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap3.min.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
        <!--ASSETS-->
        <!--ASSETS-->
        <link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/css/jquery.alerts.css" rel="stylesheet">
        <!-- ESTILOS MI RED -->
        <link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
        <!-- Autocomplete -->
        <link href="<?php echo $PATHRAIZ; ?>/css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css">
        <style type="text/css">
            .inhabilitar{
                background-color: #d9534f!important;
                border-color: #d9534f!important;
                margin-left: 10px;
                color: #FFFFFF;
            }
            .disabledbutton {
                pointer-events: none;
                opacity: 0.4;
            }

            td {border: 1px #DDD solid; padding: 5px; cursor: pointer;}

            .theadSelected{
                background-color: #FFF !important;
                user-select: none;
            }
            .selected {
                background-color: #01c6c4;
                color: #FFF;
                user-select: none;
            }

            .dataTables_length{
                display: none;
            }
            .dataTables_filter{
                display: none;
            }
        </style>
        <style>

                #divRESParent{
                    display : none;
                }

                #emergente{
                    height: 100%;
                    background-color: #fff;
                    position:fixed;
                    left:0;
                    right:0;
                    top:0;
                    z-index: 1000;
                    visibility: hidden;
                }
                .ui-autocomplete-loading {
                    background: white url('../../../img/loadAJAX.gif') right center no-repeat;
                }
                .ui-autocomplete {
                    max-height: 190px;
                    overflow-y: auto;
                    overflow-x: hidden;
                    font-size: 12px;
                }
            </style>
    </head>
    <!--Include Cuerpo, Contenedor y Cabecera-->
    <?php include($PATH_PRINCIPAL . "/inc/cabecera2.php"); ?>
    <!--Inicio del Menú Vertical-->
    <!--Función "Include" del Menú-->
    <?php include($PATH_PRINCIPAL . "/inc/menu.php"); ?>
    <!--Final del Menú Vertical-->
    <!--Contenido Principal del Sitio-->


    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panelrgb">
                        <div class="titulorgb-prealta">
                            <span><i class="fa fa-user"></i></span>
                            <h3>Detalle de Corte diario en el FORELO</h3>
                            <span class="rev-combo pull-right"></span>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="wizard">

<!----->
            <input type="hidden" name="nIdUsuarioReporte" id="nIdUsuarioReporte" value="<?php echo $_POST['nIdUsuarioReporte'];?>">
            <input type="hidden" name="hnCuenta" id="hnCuenta" value="<?php echo $_POST['hnCuenta'];?>">
            <div class="form-group col-xs-12" >   
                <label for="txtId" class="control-label">Nombre / Razón Social del Comisionista:</label>
                <input class="form-control" type="text" id="" name="" placeholder="" onpaste="return false;" value="<?php  echo $_POST['hsNombreComisionista'];?>" readonly="readonly">
            </div>
            <div class="form-group col-xs-12" >   
                <label for="txtId" class="control-label">Nombre Comercial:</label>
                <input class="form-control" type="text" id="" name="" placeholder="" onpaste="return false;" value="<?php  echo $_POST['hsNombreCadena'];?>" readonly="readonly">
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">   
                <label for="fecha1" class="control-label">De:</label>
                <input type="text" id="fecha1" name="fecha1" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo date("Y-m-d");?>" onkeypress="return validaFecha(event,'fecha1')" onkeyup="validaFecha2(event,'fecha1')">
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <label for="fecha2" class="control-label">A:</label>
                <input type="text" id="fecha2" name="fecha2" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo date("Y-m-d");?>" onkeypress="return validaFecha(event,'fecha2')" onkeyup="validaFecha2(event,'fecha2')">
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"> 
                <div class="form-group form-floating"> 
                    <label for=" " class="control-label"></label>
                    <button type="button" class="btn btn-primary btn-block" onclick="corteDiarioForelo();" >Consultar</button>
                </div>
            </div>
            <div id="divRES" class="divRES" style="width: 100%; display: inline-block;">
                <table id="data" border="0" cellspacing="0" cellpadding="0" class="tablesorter tasktable">
                    <thead>
                        <tr>
                            <td class="cabecera" >Fecha</td>
                            <td class="cabecera" >Saldo Inicial</td>
                            <td class="cabecera" >Salida</td>
                            <td class="cabecera" >Entrada</td>
                            <td class="cabecera" >Saldo Final</td>
                        </tr>
                    </thead>
                    <tbody id ="tbodyReporteCorteDiarioForelo">
                        <tr class="even">
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
                                <div class="form-group col-xs-2" style="padding-left:40px;">

                                    <form id="pdfex" name="pdfex" method="post" target="_blank" action="<?php echo $PATHRAIZ; ?>/amp/foreloscomisionista/controllers/detalleCorteDiarioForeloReporte.php" >
                                        <input type="hidden" name="pdf_hnIdUsuarioReporte" id="pdf_hnIdUsuarioReporte" value="" />
                                        <input type="hidden" name="pdf_hnCuenta" id="pdf_hnCuenta" value="" />
                                        <input type="hidden" name="pdf_hfecha1" id="pdf_hfecha1" value="" />
                                        <input type="hidden" name="pdf_hfecha2" id="pdf_hfecha2" value="" />
                                        <input type="hidden" name="pdf_hExport" id="pdf_hExport" value="1"/>
                                        <input type="hidden" name="pdf_NombreCadena" id="pdf_NombreCadena" value="<?php echo $_POST['hsNombreCadena'] ?>"/>
                                        <button  type ="button" class="btn btn-xs btn-info pdf" onclick="exportarPDF();" style="margin-right:10px;">
                                            <i class="fa fa-file-pdf-o"></i> Exportar PDF
                                        </button>
                                    </form>
                                    </div>
                                    <div class="form-group col-xs-2" style="padding-left:40px;">                             
                                        <form id="excel" name="excel" method="post" target="_blank" action="<?php echo $PATHRAIZ; ?>/amp/foreloscomisionista/controllers/detalleCorteDiarioForeloReporte.php" >
                                        <input type="hidden" name="excel_hnIdUsuarioReporte" id="excel_hnIdUsuarioReporte" value="" />
                                        <input type="hidden" name="excel_hnCuenta" id="excel_hnCuenta" value="" />
                                        <input type="hidden" name="excel_hfecha1" id="excel_hfecha1" value="" />
                                        <input type="hidden" name="excel_hfecha2" id="excel_hfecha2" value="" />
                                        <input type="hidden" name="excel_hExport" id="excel_hExport" value="1"/>
                                        <input type="hidden" name="excel_NombreCadena" id="excel_NombreCadena" value="<?php echo $_POST['hsNombreCadena'] ?>"/>
                                            <button type ="button" class="btn btn-xs btn-info excel"  style="margin-right:10px;" onclick="exportarExcel();" >
                                                <i class="fa fa-file-excel-o"></i> Exportar Excel
                                            </button>
                                        </form>
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
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/input-mask/input-mask.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script> -->
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->
    <script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
    <!--Generales-->
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
    <script src="<?php echo $PATHRAIZ ?>/inc/js/common-custom-scripts.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
    <!--<script src="<?php echo $PATHRAIZ; ?>/paycash/ajax/pdfobject.js"></script>-->
    <!--Autocomplete -->
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.core.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.widget.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.position.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.menu.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.autocomplete.js"></script>	
    <!--<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/codigo_postal.js"></script>-->
    <!--<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/consulta.js"></script>-->
    <script src="<?php echo $PATHRAIZ ?>/mis_pagos/cuponera/js/accounting.js"></script> 
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.inputmask.bundle.js"></script>
    <script type="text/javascript">
        BASE_PATH = "<?php echo $PATHRAIZ; ?>";     
    </script>
    <script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
    <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">    
    <script src="<?php echo $PATHRAIZ; ?>/amp/foreloscomisionista/js/detalleCorteDiarioForelo.js"></script>
    

</body>
</html>