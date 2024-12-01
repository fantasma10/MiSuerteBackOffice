<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Consulta Cambios de Cliente";
$tipoDePagina = "mixto";
$idOpcion = 333;
$prealta = isset($_GET['prealta']) ? ($_GET['prealta'] == 1 ? 1 : 0) : 0;
$usuario_logueado = $_SESSION['idU']*1;
$permisosAut = (in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_autorizador']) || in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_capturistas'])) ? 1 : 0;

if(!desplegarPagina($idOpcion, $tipoDePagina)){
    header("Location: $PATHRAIZ/error.php");
    exit();
}

$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
    $esEscritura = true;
}

$hoy = date("Y-m-d");

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
    <title>.::Mi Red::.Afiliacion de Cliente</title>
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

    <style type="text/css">
        .inhabilitar{
            background-color: #d9534f!important;
            border-color: #d9534f!important;
            margin-left: 10px;
            color: #FFFFFF;
        }
        .habilitar{
            margin-left: 10px;
        }
        .alignRight { text-align: right; }
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
<!-- Consulta a mapeo AMP - Mi Red -->
<!-- <?php //include($PATH_PRINCIPAL."/MesaControl/cliente/ajax/getMapeoAMP.php"); ?> -->


<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="row">
            <div class="col-lg-12">
                <!--Panel Principal-->
                <div class="panelrgb">
                    <div class="titulorgb-prealta">
                        <span><i class="fa fa-user"></i></span>
                        <h3>Consulta de cambios por autorizar</h3>
                        <span class="rev-combo pull-right">Consulta</span>
                    </div>
                    <div id="consultaCLientePanel" class="panel">
                        <!--Datos Generales-->
                        <div class="panel-body">
                            <div id="gridboxExport" class="adv-table table-responsive">
                                <div id="gridbox" class="">
                                    <div class="form-group col-xs-12">
                                        <div class="form-group col-xs-2">
                                            <a href="ajax/reporteConcultaCambiosClientesXLS.php" target="_blank" class="btn btn-xs btn-info" style="margin-top:20px;" type="button"> Generar Excel </a>
                                        </div>
                                    </div>
                                    <table id="tabla_clientes" class="display table table-bordered table-striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>RFC</th>
                                            <th>Razón Social</th>
                                            <th>Estatus</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        </tbody>
                                    </table>
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
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-custom-scripts.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>

<script src="<?php echo $PATHRAIZ;?>/MesaControl/cliente/js/consultaControlCambios.js?v=<?php echo rand(); ?>"></script>
<script type="text/javascript">
    BASE_PATH = "<?php echo $PATHRAIZ;?>";
    ID_PERFIL = "<?php echo $_SESSION['idPerfil'];?>";
    PERMISOAUT = "<?php echo $prealta == 1 ? $permisosAut : true;?>";
    PREALTA = "<?php echo $prealta;?>";
</script>
</body>
<style type="text/css">
    .prueba {
        width: 100% !important;
    }

    #td {
        width: 30% !important;
    }

    #inputs {
        text-align: center;
    }

    .dataTables_filter {
        text-align: right !important;
        width: 40% !important;
        padding-right: 0 !important;
    }

    .well ul li {
        padding: 0 !important;
        font-size: 11px !important;
    }


    .boton span.fa-check {
        opacity: 0;
    }

    .boton.active span.fa-check {
        opacity: 1;
    }

    #emisor {
        background-color: #0275d8 !important;
        border-color: #0275d8 !important;
    }


    .inhabilitar {
        background-color: #d9534f !important;
        border-color: #d9534f !important;
        margin-left: 10px;
        color: #FFFFFF;
    }

    .habilitar {
        margin-left: 10px;
    }

    .lectura {
        background: rgb(238, 238, 238);
        color: rgb(128, 128, 128);
    }

    .lecturaCorreos {
        background: rgb(238, 238, 238);
        color: rgb(128, 128, 128);
    }
</style>
</html>
