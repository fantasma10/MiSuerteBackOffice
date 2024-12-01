<?php
$APP_ROOT_DIRECTORY = $_SERVER['DOCUMENT_ROOT'];

include($APP_ROOT_DIRECTORY . "/inc/config.inc.php");
include($APP_ROOT_DIRECTORY . "/inc/session.inc.php");
include($APP_ROOT_DIRECTORY . "/inc/functions.html.php");
include($APP_ROOT_DIRECTORY . "/MesaControl/Reportes/revisioncontratos/ajax/clientes.php");

$URL = get_url_from_server($_SERVER);

$submenuTitulo = "Reportes";
$subsubmenuTitulo = "Revisión de contratos";
$tipoDePagina = "Lectura";
$idOpcion = 330;

$today = date("Y-m-d");

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
    header("Location: " . $URL ."error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php echo $URL; ?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo $URL; ?>/img/favicon.ico" type="image/x-icon">
    <title>.::Mi Red::.<?php echo $subsubmenuTitulo; ?></title>
    <!-- Núcleo BOOTSTRAP -->
    <link href="<?php echo $URL; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $URL; ?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--ASSETS-->
    <link href="<?php echo $URL; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo $URL; ?>/assets/opensans/open.css" rel="stylesheet" />
    <!-- ESTILOS MI RED -->
    <link href="<?php echo $URL; ?>/css/miredgen.css" rel="stylesheet">
    <link href="<?php echo $URL; ?>/css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo $URL; ?>/assets/bootstrap-datepicker/css/datepicker.css" />
    <link href="<?php echo $URL; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">
    <!-- Autocomplete -->
    <link href="<?php echo $URL; ?>/css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">
    <link href="<?php echo $URL; ?>/css/jquery.alerts.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $URL; ?>/inc/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo $URL; ?>/inc/auto-complete/auto-complete.css">
    <link href="<?php echo $URL; ?>/MesaControl/reportes/revisioncontratos/css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include($APP_ROOT_DIRECTORY . "/inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include($APP_ROOT_DIRECTORY . "/inc/menu.php"); ?>
<!--Final del Menú Vertical-->
<!--Contenido Principal del Sitio-->

<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <!--Panel Principal-->
                <div class="">
                    <div class="titulorgb-prealta">
                        <span><i class="fa fa-search"></i></span>
                        <h3><?php echo $subsubmenuTitulo; ?></h3>
                        <span class="rev-combo pull-right">Reportes<br></span>
                    </div>
                </div>

                <div class="panel" style="min-width: 100%;">
                    <div class="panel-body">
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group">
                                        <label for="" class="control-label">Fecha</label>
                                        <input type="text" id="txt-due-date" class="form-control" value="<?php echo $today; ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Cliente</label>
                                        <input type="text" class="form-control" id="txt-sCliente" placeholder="Escribir nombre o RFC...">
                                        <input type="hidden" id="txt-nIdCliente">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <button id="btn-search" class="btn btn-sx btn-info pull-right">
                                        Buscar
                                        <span class="btn-spinner hide"><i class="fa fa-spinner"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div id="container-contracts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<!--*.JS Generales-->
    <script src="<?php echo $URL; ?>/inc/jquery-3.6.0.min.js"></script>
	<script src="<?php echo $URL; ?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $URL; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $URL; ?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $URL; ?>/inc/js/respond.min.js" ></script>
	<script src="<?php echo $URL; ?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
	<!--Generales-->
	<script src="<?php echo $URL; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $URL; ?>/inc/js/common-scripts.js"></script>
	<script src="<?php echo $URL; ?>/inc/js/common-custom-scripts.js"></script>
	<script src="<?php echo $URL; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo $URL; ?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $URL; ?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $URL; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>

    <script src="/inc/DataTables/datatables.min.js"></script>
	<!-- UI Autocomplete -->
	<script src="<?php echo $URL; ?>/inc/auto-complete/auto-complete.min.js"></script>
	<!--Cierre del Sitio-->  


<script src="<?php echo $URL; ?>/MesaControl/reportes/revisioncontratos/js/revisioncontratos.js"></script>
<script>
    $(function () {
        BASE_PATH   = '<?php echo $URL.'/MesaControl/reportes/revisioncontratos'; ?>';
		CLIENTES    = <?php echo json_encode($clientes); ?>;

        initContractReview();
    });
</script>

<!--Cierre del Sitio-->
</body>
</html>