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
    <link rel="shortcut icon" href="<?php echo $BASE_PATH;?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo $BASE_PATH;?>/img/favicon.ico" type="image/x-icon">
    <title>.::Mi Red::.P&oacute;lizas</title>
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
    <link href="<?php echo $PATHRAIZ;?>/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo $BASE_PATH;?>/assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="<?php echo $PATHRAIZ?>/assets/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $PATHRAIZ; ?>/amp/notificacion/js/mobiscroll.jquery.min.css">
    <style>
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
    </style>
    <style type="text/css">
    body {
        margin: 0;
        padding: 0;
    }

    body,
    html {
        height: 100%;
    }

    .md-mobile-picker-header {
        font-size: 14px;
    }
    
    input.md-mobile-picker-input {
        color: initial;
        width: 100%;
        padding: 10px;
        margin: 6px 0 12px 0;
        border: 1px solid #ccc;
        border-radius: 0;
        font-family: arial, verdana, sans-serif;
        font-size: 14px;
        box-sizing: border-box;
        -webkit-appearance: none;
    }
    
    .md-mobile-picker-button.mbsc-button {
        font-size: 13px;
        padding: 0 15px;
        line-height: 36px;
        float: right;
        margin: 6px 0;
        width: 100%;
    }
    
    .mbsc-col-no-padding {
        padding-left: 0;
    }
    
    .md-mobile-picker-box-label.mbsc-textfield-wrapper-box,
    .md-mobile-picker-box-label .mbsc-textfield-wrapper-box,
    .md-mobile-picker-inline {
        margin: 6px 0 12px 0;
    }
    .mbsc-selected{

    border-color: #007aff;
    background: #007aff;
    color: #fff;
    border-radius: 60%;

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
<?php  
        $oRAMP->setSDatabase('aquimispagos');
        $oRAMP->setSStoredProcedure('sp_select_notificaciones_datcadena');
        $result2 = $oRAMP->execute();
        $cadenas =  ($oRAMP->fetchAll());
        $oRAMP->closeStmt();
        $sCadenas='<option value="-1">Todas</option>';
        foreach ( ($cadenas) as $key) {
            if ($key['sNombre']!='') {
                $sCadenas.='<option value="'.$key['nIdCadena'].'">'.utf8_encode($key['sNombre']).'</option>';
            }            
        }
        $oRAMP->setSDatabase('aquimispagos');
        $oRAMP->setSStoredProcedure('sp_select_notificaciones_catperiodo');
        $result2 = $oRAMP->execute();
        $periodos =  ($oRAMP->fetchAll());
        $oRAMP->closeStmt();
        $sPeriodos="";
        foreach ( ($periodos) as $key) {
            if ($key['sNombre']!='') {
                $sPeriodos.='<option value="'.$key['nIdPeriodo'].'">'.$key['sNombre'].'</option>';
            }            
        }
?>
    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panelrgb">
                        <div class="titulorgb-prealta">
                            <span><i class="fa fa-user"></i></span>
                            <h3>Notificación</h3>
                            <span class="rev-combo pull-right"></span>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="wizard">
<!----->
                                <input type="hidden" name="usuario_logueado" id="usuario_logueado" value="<?php echo $usuario_logueado;?>">
                                <input type="hidden" name="hnOperadores[]" id="hnOperadores">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align: center;">
                                        <h5><strong>A quien vas a enviar la Notificación</strong></h5>
                                    </div>
                                    <div class="col-4  col-sm-4 col-md-4 col-lg-4 col-xl-4" style="">
                                        <label class="custom-control-label" for="despGraficos"><strong>Cadena:</strong></label>
                                        <select class="js-example-basic-multiple form-control" name="nCadenas[]" id="nCadenas" onchange="mostarTiendas();"  multiple="multiple" >
                                            <option value="">Selecciona</option>
                                            <?php echo $sCadenas;?>
                                        </select>                                
                                    </div>
                                    <div class="col-4  col-sm-4 col-md-4 col-lg-4 col-xl-4" style="">
                                        <label class="custom-control-label" for="despGraficon"><strong>Tienda:</strong></label>
                                        <select class="js-example-basic-multiple form-control" name="nTiendas[]" id="nTiendas" onchange=""   multiple="multiple" >
                                            <option value="">Selecciona</option>
                                        </select>                                
                                    </div>
                                    <div class="col-4  col-sm-4 col-md-4 col-lg-4 col-xl-4" style="">
                                        <label class="custom-control-label" for="despGraficon"><strong>Usuarios:</strong></label>
                                        <div class="form-check" >
                                          <input class="form-check-input" type="radio" name="nTipoUsuario" id="flexRadioDefault1" value="-1"  onchange="mostarOperadores() ;">
                                          <label class="form-check-label" for="flexRadioDefault1">
                                            Todos
                                          </label>
                                        </div>
                                        <div class="form-check" >
                                          <input class="form-check-input" type="radio" name="nTipoUsuario" id="flexRadioDefault2" value="1" onchange="mostarOperadores() ;" >
                                          <label class="form-check-label" for="flexRadioDefault2">
                                            Comisionistas
                                          </label>
                                        </div>

                                                                         
                                    </div>

                                <!--
                                    <div class="col-4  col-sm-4 col-md-4 col-lg-4 col-xl-4" style="">
                                        <label class="custom-control-label" for="despGraficon"><strong>Tienda:</strong></label>
                                        <select class="js-example-basic-multiple form-control" name="nTiendas[]" id="nTiendas" onchange="mostarOperadores();"   multiple="multiple" >
                                            <option value="">Selecciona</option>
                                        </select>                                
                                    </div>
                                    <div class="col-4  col-sm-4 col-md-4 col-lg-4 col-xl-4" style="">
                                        <label class="custom-control-label" for="despGraficon"><strong>Operador:</strong></label>
                                        <select class="js-example-basic-multiple form-control" name="nOperadores[]" id="nOperadores"  multiple="multiple"   >
                                            <option value="">Selecciona</option>
                                        </select>                                                                        
                                    </div>
                                mbsc-input-->
                                </div>
                                <div class="row">
                                    <label class="col-12  col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <strong>Calendario</strong>
                                        <input id="dFechasEnvio"  placeholder="Por favor seleccione" type="text" class="form-control"  />
                                    </label>
                                </div>
                                <!--
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align: center;">
                                        <h5><strong>Con que frecuencia deseas que se notifique tu mensaje</strong></h5>
                                    </div>
                                    <div class="col-3  col-sm-3 col-md-3 col-lg-3 col-xl-3" style="">
                                        <label class="custom-control-label" for="nIdPeriodo"><strong>Periodo:</strong></label>
                                        <select class="form-control" id="nIdPeriodo" name="nIdPeriodo" >
                                            <option value="">Selecciona</option>
                                            <?php echo utf8_encode($sPeriodos);?>
                                        </select>                                
                                    </div>
                                    <div class="col-3  col-sm-3 col-md-3 col-lg-3 col-xl-3" style="">
                                        <label class="custom-control-label" for="fecha1"><strong>Fecha Inicio Notificación:</strong></label>
                                        <input type="text" id="fecha1" name="fecha1" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo date("Y-m-d");?>" onkeypress="return validaFecha(event,'fecha1')" onkeyup="validaFecha2(event,'fecha1')" autocomplete="off" >                                
                                    </div>
                                    <div class="col-3  col-sm-3 col-md-3 col-lg-3 col-xl-3" style="">
                                        <label class="custom-control-label" for="fecha2"><strong>Fecha Final Notificación:</strong></label>
                                        <input type="text" id="fecha2" name="fecha2" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo date("Y-m-d");?>" onkeypress="return validaFecha(event,'fecha1')" onkeyup="validaFecha2(event,'fecha1')" autocomplete="off" >                              
                                    </div>
                                    <div class="col-3  col-sm-3 col-md-3 col-lg-3 col-xl-3" style="">
                                        <label class="custom-control-label" for="nVecesEnviar"><strong># de veces a enviar:</strong></label>
                                        <input type="text" id="nVecesEnviar" name="nVecesEnviar" class="form-control">                              
                                    </div>
                                </div>-->
                                <div class="row">
                                    <div class="col-12  col-sm-12 col-md-12 col-lg-12 col-xl-12" style="">
                                        <label class="custom-control-label" for="sTituloMensaje"><strong>Titulo Notificación:</strong></label>
                                        <input type="text" id="sTituloMensaje" name="sTituloMensaje" class="form-control" placeholder="Ingresa Titulo del mensaje">                                
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12  col-sm-12 col-md-12 col-lg-12 col-xl-12" style="">
                                        <label class="custom-control-label" for="sMensaje"><strong>Mensaje por notificar:</strong></label>
                                        <textarea type="text" id="sMensaje" name="sMensaje" class="form-control" placeholder="Ingresa mensaje" rows="10" ></textarea>                               
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12  col-sm-12 col-md-12 col-lg-12 col-xl-12" style="">
                                        <button type="button" class="btn btn-primary btn-block" onclick="notificacionValidaRegistro();" >Enviar Mensaje</button>    
                                    </div>
                                </div>

<!----->
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
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/select2.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        BASE_PATH = "<?php echo $PATHRAIZ; ?>";
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });     
    </script>
    <script src="<?php echo $PATHRAIZ; ?>/amp/notificacion/js/notificacionOperadores.js?v=<?php echo(rand()); ?>"></script>        
    <script src="<?php echo $PATHRAIZ; ?>/amp/notificacion/js/mobiscroll.jquery.min.js"></script>
    <script type="text/javascript">/*
    $('#dFechasEnvio').mobiscroll().datepicker({
        controls: ['calendar'],
        dateFormat: 'YYYY-MM-DD',
        selectMultiple: true,
        selectCounter: true
    });*/
    </script>
    <style type="text/css">
        /* comenzar: jQuery UI Datepicker énfasis en fechas seleccionadas */ 
        .ui-datepicker .ui-datepicker-calendar .ui-state-highlight a { background : #3363FF none ; 
            /* un color que se ajusta al tema del widget */ 
            color : white ; /* un color que se puede leer con el color de arriba */ } 
            /* end: jQuery UI Datepicker énfasis en fechas seleccionadas* /
        /* begin: jQuery UI Datepicker corrección de píxeles en movimiento */ 
        table .ui-datepicker-calendar { border-collapse : separado ;} .ui-datepicker-calendar td { border : 1px solid transparent ;} 
        .ui-icon-circle-triangle-e{
            background : #3363FF none ; 
        }
        .ui-icon-circle-triangle-w{
            background : #3363FF none ; 
        }
        /* end: jQuery UI Datepicker corrección de píxeles en movimiento */
    

    </style>
    <script src="<?php echo $PATHRAIZ; ?>/amp/notificacion/js/jquery-ui-1.11.1.js?v=<?php echo(rand()); ?>"></script>
    <script src="<?php echo $PATHRAIZ; ?>/amp/notificacion/js/jquery-ui.multidatespicker.js?v=<?php echo(rand()); ?>"></script>
    <script type="text/javascript">
            var latestMDPver = $.ui.multiDatesPicker.version;
            var lastMDPupdate = '2014-09-19';
            
            $(function() {
                // Version //
                //$('title').append(' v' + latestMDPver);
                $('.mdp-version').text('v' + latestMDPver);
                $('#mdp-title').attr('title', 'last update: ' + lastMDPupdate);
                
                // Documentation //
                $('i:contains(type)').attr('title', '[Optional] accepted values are: "allowed" [default]; "disabled".');
                $('i:contains(format)').attr('title', '[Optional] accepted values are: "string" [default]; "object".');
                $('#how-to h4').each(function () {
                    var a = $(this).closest('li').attr('id');
                    $(this).wrap('<'+'a href="#'+a+'"></'+'a>');
                });
                $('#demos .demo').each(function () {
                    var id = $(this).find('.box').attr('id') + '-demo';
                    $(this).attr('id', id)
                        .find('h3').wrapInner('<'+'a href="#'+id+'"></'+'a>');
                });
                
                // Run Demos
                $('.demo .code').each(function() {
                    eval($(this).attr('title','NEW: edit this code and test it!').text());
                    this.contentEditable = true;
                }).focus(function() {
                    if(!$(this).next().hasClass('test'))
                        $(this)
                            .after('<button class="test">test</button>')
                            .next('.test').click(function() {
                                $(this).closest('.demo').find('.hasDatepicker').multiDatesPicker('destroy');
                                eval($(this).prev().text());
                                $(this).remove();
                            });
                });
            });   
    $('#dFechasEnvio').multiDatesPicker(
        {
            dateFormat: "yy-mm-dd" ,
            minDate: 0
        });
    </script>

</body>
</html>