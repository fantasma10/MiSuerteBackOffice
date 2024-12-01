<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
include($PATH_PRINCIPAL . "/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL . "/_Proveedores/proveedor/ajax/Cat_familias.php");
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

function acentos($word) {
    return (!preg_match('!!u', $word)) ? utf8_encode($word) : $word;
}
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
        <title>.::Mi Red::.Tipo Comercio</title>
        <!-- Núcleo BOOTSTRAP -->
        <!-- <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet"> -->
        <!--<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap3.min.css" rel="stylesheet">-->
        <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap3.min.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
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
                            <h3>Cat&aacute;logo de Tipo de comercio</h3>
                            <span class="rev-combo pull-right">Cat&aacute;logo</span>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="wizard">
                                    <div class="wizard-inner">
                                        <div class="connecting-line"></div>
                                        <ul class="nav nav-tabs" role="tablist">

                                            <li id="btnConsultar" role="presentation" class="active" data-tipocomercio="0">
                                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Consultar">
                                                    <span class="round-tab">
                                                        <i class="glyphicon glyphicon-search"></i>  Configuracion de Cliente
                                                    </span>
                                                </a>
                                            </li>
                                            <!--
                                            <li id="btnConsultar" role="presentation"  data-tipocomercio="0">
                                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Consultar">
                                                    <span class="round-tab">
                                                        <i class="glyphicon glyphicon-search"></i>  Configuracion de facturación Servicios
                                                    </span>
                                                </a>
                                            </li>
                                            -->
                                            
                                        </ul>
                                    </div>

                                    <!-- <form role="form"> -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="step1" style="margin-button:20px;">
                                            
                                           <input type="hidden" value="" name="idFacturacionTAE" id="idFacturacionTAE">
                                       

                                            <div class="form-group col-xs-12">

                                                <div class="form-group col-xs-3">
                                                    <input type="hidden" id="activoEdit" />
                                                    <label class=" control-label">Serie: </label>
                                                    <input type="text" id="txtSerie" name="txtSerie" class="form-control">
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Metodo de pago: </label>
                                                    <select id="cmbMetodoPago" name="cmbMetodoPago" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>    
                                                </div>

                                            </div>
                                            <div class="form-group col-xs-12">

                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Forma de pago: </label>
                                                    <select id="cmbFormaPago" name="cmbFormaPago" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>    
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Uso CFDI: </label>
                                                    <select id="cmbCFDI" name="cmbCFDI" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>    
                                                </div>

                                            </div>
                                            <div class="form-group col-xs-12">

                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Clave del Producto o Servicio: </label>
                                                    <select id="cmbProducto" name="cmbProducto" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>    
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">IVA: </label>
                                                    <select id="cmbIVA" name="cmbIVA" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                        <option value="8">8%</option>
                                                        <option value="16">16%</option>
                                                    </select>    
                                                </div>

                                            </div>

                                            <div class="col-xs-5">
														<div class="form-group col-xs-12" style="text-align:right;padding-right:0;">
															<button class="btn btn-xs btn-info " id="guardarFacturaManual" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:0;" onclick="guardarConf_facturacion();"> Guardar </button>
														</div>	
													</div>
                                            


                                            
                                        </div>


                                        <div class="tab-pane" role="tabpanel" id="step2" style="margin-button:20px;">
                                            
                                           
                                        <input type="hidden" value="" name="idFacturacionServicios" id="idFacturacionServicios">

                                            <div class="form-group col-xs-12">

                                                <div class="form-group col-xs-3">
                                                    <input type="hidden" id="activoEdit" />
                                                    <label class=" control-label">Serie: </label>
                                                    <input type="text" id="txtSerieS" name="txtSerieS" class="form-control">
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Metodo de pago: </label>
                                                    <select id="cmbMetodoPagoS" name="cmbMetodoPagoS" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>    
                                                </div>

                                            </div>
                                            <div class="form-group col-xs-12">

                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Forma de pago: </label>
                                                    <select id="cmbFormaPagoS" name="cmbFormaPagoS" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>    
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Uso CFDI: </label>
                                                    <select id="cmbCFDIS" name="cmbCFDIS" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>    
                                                </div>

                                            </div>
                                            <div class="form-group col-xs-12">

                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Clave del Producto o Servicio: </label>
                                                    <select id="cmbProductoS" name="cmbProductoS" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>    
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">IVA: </label>
                                                    <select id="cmbIVAS" name="cmbIVAS" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                        <option value="8">8%</option>
                                                        <option value="16">16%</option>
                                                    </select>    
                                                </div>

                                            </div>

                                            <div class="col-xs-5">
														<div class="form-group col-xs-12" style="text-align:right;padding-right:0;">
															<button class="btn btn-xs btn-info " id="guardarFacturaManual" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:0;" onclick="guardarConf_facturacion();"> Guardar </button>
														</div>	
													</div>
                                            


                                            
                                        </div>
                                        <!--Panel para agregar un tipo de comercio-->

                                     

                                        <div class="clearfix"></div>
                                    </div>
                                    <!-- </form> -->
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
    <script src="<?php echo $PATHRAIZ; ?>/amp/facturacion/js/conf_facturacion_clientes.js?v=<?php echo(rand()); ?>"></script>
    <script type="text/javascript">

        BASE_PATH = "<?php echo $PATHRAIZ; ?>";
     
    </script>
    <script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
    <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">

</body>
</html>