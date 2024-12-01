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
        <link rel="stylesheet" href="<?php echo $BASE_PATH;?>/css/themes/base/jquery.ui.all.css" />
        <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet">
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
        <link href="<?php echo $BASE_PATH;?>/css/style-autocomplete.css" rel="stylesheet">
        <style type="text/css">
        .align-right{
            text-align : right;
        }

        .list-inline{
            font-size:12px;
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
                div.ex1 {
                  background-color: none;
                  height: 200px;
                  width: auto;
                  overflow-y: scroll;
                }
                div.ex2 {
                  background-color: none;
                  height: 300px;
                  width: auto;
                  overflow-y: scroll;
                }
                #tablacontent{
                  margin: auto;
                }
                #galeria {
                            margin: 1rem auto;
                            width:100%;
                            max-width:960px;
                            column-count: 3;
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
                            <h3>Configuración de anuncio</h3>
                            <span class="rev-combo pull-right">Cat&aacute;logo</span>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="wizard">
                                    <div class="wizard-inner">
                                        <div class="connecting-line"></div>
                                        <ul class="nav nav-tabs" role="tablist">

                                            <li id="btnConsultar" role="presentation" class="active" data-tipocomercio="0">
                                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Cambiar">
                                                    <span class="round-tab">
                                                        <i class="glyphicon glyphicon-picture"></i>  Imagen
                                                    </span>
                                                </a>
                                            </li>

                                            <li id="btnConsultar" role="presentation"  data-tipocomercio="0">
                                                <a href="#step2" data-toggle="tab" id="apartadoBanner" aria-controls="step2" role="tab" title="Cambiar">
                                                    <span class="round-tab">
                                                        <i class="glyphicon glyphicon-bullhorn"></i>  Baner
                                                    </span>
                                                </a>
                                            </li>

                                            
                                        </ul>
                                    </div>

                                    <!-- <form role="form"> -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="step1" style="margin-button:20px;">

                                            <div class="form-group col-xs-12">

                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Nombre: </label>
                                                    <input type="text" id="txtNombre" name="txtNombre" class="form-control">
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Descripción: </label>
                                                    <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control">
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label class=" control-label">Imagen: </label>
                                                    <input type="file" id="imgAnuncio" name="imgAnuncio" accept="image/*" class="form-control">
                                                </div>

                                            </div>
                                            <div class="col-xs-5">
                                                        <div class="form-group col-xs-12" style="text-align:right;padding-right:0;">
                                                            <button class="btn btn-xs btn-info " id="guardarAnuncio" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:0;" onclick="validacionAnuncio();">Actualizar y Guardar </button>
                                                        </div>  
                                            </div>
                                        </div>


                                        <div class="tab-pane" role="tabpanel" id="step2" style="margin-button:20px;">
                                            <p><h3 style="text-align: center; display: block;">Publicar imagen carrusel</h3></p>
                                            <div class="form-group col-xs-12" style="margin-top: 30px;margin-bottom: 30px;">
                                                <button class ="btn btn-link" id="abrirModalGrupos" data-loading-text="<i class='fa fa-spinner fa-spin '></i> cargando" >Clasifica cadenas en Grupos </button> 
                                            </div>
                                            <div class="form-group col-xs-3">
                                                <label class=" control-label">Imagen: </label>
                                                <input type="file" id="imgBanner" name="imgBanner" accept="image/*" class="form-control" onchange="validaImgNueva();">
                                            </div>
                                            <div class="form-group col-xs-3" id="divCancela" style="display: none;">
                                                <input type="button" value="Cancelar" id="btnCancelaImg" class="btn btn-xs btn-info" onclick="cancelaImg();">
                                            </div>
                                            <div class="form-group col-xs-12" style="text-align: center; display: block;">
                                                <img id = "imgPreview" height="250" width="250" style="margin-top: 30px;margin-bottom: 30px; display: none;">
                                            </div>
                                            <div class="form-group col-xs-9">
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <div id="conenedorImg" class='row ex1'>
                                                </div>
                                            <div class="col-xs-12" style="display:none;" id="showTableOrden" >
                                                <div id="gridboxExport" class="adv-table table-responsive">
                                                    <div id="gridbox" class="adv-table table-responsive" >
                                                        <div class="ex2">
                                                            <p><h3 style="text-align: center; display: block;">Enviar publicación a los siguientes Grupos</h3></p>
                                                            <table id ="tablacontent" class="center">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center" colspan = "2"></th>  
                                                                        <th class="text-center" colspan = "3">Orden</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-center">Grupo</th>
                                                                        <th class="text-center">Existe</th>
                                                                        <th class="text-center">1</th>
                                                                        <th class="text-center">2</th>
                                                                        <th class="text-center">3</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id = "tbodyGruposOrden">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-5">
														<div class="form-group col-xs-12" style="text-align:right;padding-left:0;">
															<button class="btn btn-xs btn-info " id="guardarBanner" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:0;" onclick="validacionBannerList();">Asignar Imagen </button>
														</div>	
											</div>
                                        </div>
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
            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span>Clasificación de Comisionistas</span>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group col-xs-6">
                                <label class=" control-label">Introduce el grupo: </label>
                                <input type="text" id="txtGrupo" name="txtGrupo" class="form-control" onkeyup="buscaGrupo();" maxlength="80">
                                <input type="hidden" id="nIdGrupo" name="nIdGrupo">
                            </div>
                            <div class="form-group col-xs-3" style="margin-top: 30px;margin-bottom: 30px;">
                                <button class ="btn btn-link" id="abrirModalGruposReporte" data-loading-text="<i class='fa fa-spinner fa-spin '></i> cargando" >Grupos </button> 
                            </div>
                            <div class="form-group col-xs-12">
                                <label class=" control-label">Introduce una Descripción: </label>
                                <textarea class="form-control" id="txtAreaDescripcion" rows="3" maxlength="250"></textarea>
                            </div> 
                            <div class="col-xs-12" style="display:none;" id="showTable">
                                <div id="gridboxExport" class="adv-table table-responsive">
                                    <div id="gridbox" class="adv-table table-responsive" >
                                        <div class="ex1">
                                            <table id ="tablacontent" class="center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Cadena</th>
                                                        <th class="text-center">Existe</th>
                                                    </tr>
                                                </thead>
                                                <tbody id = "tbodyCadenasEnGrupo">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer"> 
                            <div class="col-xs-12">
                                <div class="col-xs-6">
                                    <button class="btn btn-primary btn-block" type="button" id="btnAceptar">Clasificar</button>
                                </div>
                                <div class="col-xs-6">
                                    <button class="btn btn-primary btn-block" type="button" id="btnCerrar">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalBannerReporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span>Grupos</span>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-12" id="showTable">
                                <div id="gridboxExport" class="adv-table table-responsive">
                                    <div id="gridbox" class="adv-table table-responsive" >
                                        <div class="ex1">
                                            <table id ="tablacontent" class="center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Fecha Registro</th>
                                                        <th class="text-center">Nombre del Grupo</th>
                                                        <th class="text-center"># Cadenas</th>
                                                    </tr>
                                                </thead>
                                                <tbody id = "tbodyGrupos">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer"> 
                            <div class="col-xs-12">
                                <div class="col-xs-6">
                                    <button class="btn btn-primary btn-block" type="button" id="btnCerrarReporte">cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    <script src="<?php echo $PATHRAIZ; ?>/amp/anuncios/js/conf_anuncio.js?v=<?php echo(rand()); ?>"></script>
    <script type="text/javascript">

        BASE_PATH = "<?php echo $PATHRAIZ; ?>";
     
    </script>
    <script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
    <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">

</body>
</html>