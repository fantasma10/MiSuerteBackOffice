<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
include($PATH_PRINCIPAL . "/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL . "/_Proveedores/proveedor/ajax/Cat_familias.php");
$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];
$submenuTitulo = "Parametros Generales";
$subsubmenuTitulo = "Parametros Generales";
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
        <title>.::Mi Red::.Parametros Generales</title>
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
                            <h3>Cat&aacute;logo de Parametros Generales</h3>
                            <span class="rev-combo pull-right">Cat&aacute;logo</span>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="wizard">
                                    <div class="wizard-inner">
                                        <div class="connecting-line"></div>
                                        <ul class="nav nav-tabs" role="tablist">

                                            <li id="btnConsultar" role="presentation" class="active" data-parametro="0">
                                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Consultar">
                                                    <span class="round-tab">
                                                        <i class="glyphicon glyphicon-search"></i>  Consultar
                                                    </span>
                                                </a>
                                            </li>

                                            <li id="btnAgregarParametro" role="presentation" class="" data-parametro="1">
                                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Agregar">
                                                    <span class="round-tab">
                                                        <i class="glyphicon glyphicon-plus"></i>  Agregar
                                                    </span>
                                                </a>
                                            </li>

                                            <li id="btnDatosParametroEditar" role="presentation" class="disabled" data-parametro="2">
                                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" id="" title="Modificar">
                                                    <span class="round-tab" id="">
                                                        <i class="glyphicon glyphicon-edit"></i> Modificar
                                                    </span>
                                                </a>
                                            </li>
                                            <li id="btnEliminar" role="presentation" class="disabled" data-parametro="3">
                                                <a href="" data-toggle="tab" aria-controls="step4" role="tab" title="Activar/Desactivar">
                                                    <span class="round-tab">
                                                        <i class="glyphicon glyphicon-remove"></i> Activar/Desactivar
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- <form role="form"> -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="step1" style="margin-button:20px;">
                                                <!--<input type="hidden" name="tipoProceso" id="tipoProceso" />-->
                                            <div class="form-group col-lg-12">
                                                <h4><span><i></i></span> Listado de Parametros Generales</h4>
                                            </div>
                                            <div id="gridboxExport" class="adv-table table-responsive">
                                                <!--Aqui se listara los datos de la cuponera-->
                                                <div id="gridbox" class="adv-table table-responsive" >
                                                    <table id="data" class="display table table-bordered table-striped" style=" width: 100%; display:none;">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Nombre del proceso</th>
                                                                <th>Referencia</th>
                                                                <th>Parametro</th>
                                                                <th>Tipo de dato</th>
                                                                <th>Valor obligatorio</th>
                                                                <th>Valor</th>
                                                                <!--<th>Comentarios</th>-->
                                                                <th>Activo</th>
                                                                <th>F Registro</th>
                                                                <th>F Movimiento</th>
                                                            </tr>
                                                        </thead>	
                                                        <tbody>
                                                            <!--Aqui se enlistan los datos de los parametros, de manera dinamica-->
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>


                                            <span id="span_paso1" class="alert alert-success" style="display: none;">
                                            </span>
                                        </div>

                                        <!--Panel para agregar un Parametro-->

                                        <div class="tab-pane" role="tabpanel" id="step2">
                                            <div class="form-group col-lg-12">
                                                <h4 id="tituloAgregar"><span><i class="fa fa-file-text"></i></span> Agregar un Parametro</h4>
                                                <h4 id="tituloEditar" style="display: none;"><span><i class="fa fa-file-text"></i></span> Editar un Parametro</h4>
                                            </div>
                                            <form id="frmParametrosGrales">
                                                <input type="hidden" class="form-control m-bot15" id="tipo" name="tipo" value="2" />
                                                <input type="hidden" class="form-control m-bot15" name="idParametro" id="idParametro" />
                                                <div class="form-group col-xs-12">

                                                    <div class="form-group col-xs-6">
                                                        <label class=" control-label">Nombre proceso: * </label>
                                                        <input type="text" class="form-control m-bot15" name="sNombreProceso" id="sNombreProceso" />
                                                    </div>
                                                    <div class="form-group col-xs-6">
                                                        <label class=" control-label">Referencia: * </label>
                                                        <input type="text" class="form-control m-bot15" name="sReferencia" id="sReferencia">
                                                    </div>

                                                </div>

                                                <div class="form-group col-xs-12">

                                                    <div class="form-group col-xs-4">
                                                        <label class=" control-label">Parametro: * </label>
                                                        <input type="text" class="form-control m-bot15" name="sParametro" id="sParametro">
                                                    </div>
                                                    <div class="form-group col-xs-4">
                                                        <label class=" control-label">Tipo de dato: </label>
                                                        <select class="form-control m-bot15" name="sTipoDato" id="sTipoDato">
                                                            <option value="0">Seleccione...</option>
                                                            <option value="Alfanumerico">Alfanumérico</option>
                                                            <option value="Decimal">Decimal</option>
                                                            <option value="Fecha">Fecha</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-xs-4">
                                                        <label class="control-label">Valor: * </label>
                                                        <input type="text" class="form-control form-control-inline" id="sValor" name="sValor" />
                                                    </div>
                                                </div>

                                                <div class="form-group col-xs-12">

                                                    <div class="form-group col-xs-8">
                                                        <label class=" control-label">Comentarios: * </label>
                                                        <textarea type="text" class="form-control form-control-inline" id="sComentarios" name="sComentarios" maxlength="100" cols="25" rows="3">
                                                                    
                                                        </textarea>
                                                    </div>       

                                                    <div class="form-group col-xs-4">
                                                        <label class=" control-label">Valor obligatorio: </label>
                                                        <input type="checkbox" class="form-control" name="sValObligatorio" id="sValObligatorio" >
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="row">
                                                <div class="col-lg-12"><br><br>
                                                    <span id="span_paso2" class="" style="display: none;"></span>
                                                </div>
                                            </div>
                                            <ul class="list-inline pull-right">
                                                <li><button type="button" class="btn btn-default prev-step" id="btnCancelar">Cancelar</button></li>
                                                <li><input id="btnAgregar" type="button" class="btn btn-primary " value="Agregar" ></li>
                                                <li><input id="btnEditar" type="button" class="btn btn-primary " value="Guardar" style="display: none;"></li>
                                            </ul>

                                        </div>


                                        <div class="clearfix"></div>
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
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
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
    <!--Autocomplete -->
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.core.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.widget.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.position.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.menu.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.autocomplete.js"></script>	
    <script src="<?php echo $PATHRAIZ ?>/mis_pagos/cuponera/js/accounting.js"></script> 
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.inputmask.bundle.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/repay/administracion/js/parametrosGenerales.js"></script>
    <script type="text/javascript">

        BASE_PATH = "<?php echo $PATHRAIZ; ?>";
        $(document).ready(function () {
            initViewParametros();

        });
    </script>
    <script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
    <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">

</body>
</html>