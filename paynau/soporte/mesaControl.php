<?php
    $PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
    define('URL', 'http' . ((intval($_SERVER['SERVER_PORT']) == 443)?'s':'') . '://' . $_SERVER['HTTP_HOST'] . '/');

    include($PATH_PRINCIPAL."/inc/config.inc.php");
    include($PATH_PRINCIPAL."/inc/session.inc.php");
    $PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

    $submenuTitulo = "Contabilidad";
    $subsubmenuTitulo = "Comisiones";
    $tipoDePagina = "Lectura";
    $idOpcion = 265;

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
<title>.::Mi Red::.Mesa de Control</title>
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
                <h3>Ususarios PayNau</h3><span class="rev-combo pull-right">Consulta<br>de Proveedores</span>
            </div>

            <div class="panel">
                <div class="panel-body">
                    <div style="margin-bottom: 25px;"> 
                        <ul class="nav nav-tabs nav-justified" style="padding: 0;margin: 0;background-color:#0c9ba0; color: #FFF; border:1px solid; " id="nav-items">
                            <li class="nav-item active">
                              <a class="nav-link active show"  data-toggle="tab" id="listaProveedores" href="#tab1" data-target="#tab1" role="tab" aria-selected="true">Proveedores</a> 
                            </li>
                            <li class="nav-item">
                              <a class="nav-link"  data-toggle="tab" id="datosProveedor" href="#tab2" data-target="#tab2" role="tab" aria-selected="false">Documentos de solicitud</a> 
                            </li>
                            <!-- <li class="nav-item">
                              <a class="nav-link"  data-toggle="tab" id="miEmpresa" href="#tab3" data-target="#tab3" role="tab" aria-selected="false">Detalle Empresa</a> 
                            </li> -->
                        </ul>
                    </div>
                    
    				<div class="tab-content">  
                        <div class="tab-pane active" id="tab1"> 
                            <div id="gridbox" class="adv-table table-responsive" >
                                <table id="data" class="display table table-bordered table-striped" style="">
                                    <thead>
                                        <tr>
                                            <th id="thId">ID</th>
                                            <th id="thRFC">RFC</th>
                                            <th id="thRazonSocial">Razon Social</th>
                                            <th id="thNombre">Nombre Comercial</th>
                                            <th id="thCorreo">Correo</th>
                                            <th id="thTelefono">Telefono</th>
                                            <th id="thCuenta">Cuenta CLABE</th>
                                            <th id="thDetalles">Documentos</th>
                                        </tr>
                                    </thead>    
                                    <tbody >

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="tab2"> 
                            <div class="well">
                                <div class="row">
                                    <div class="col" id="sEmpresas" style="display: block;">
                                        <div style="margin-top: 25px;">
                                            <h4><span><i class="fa fa-building"></i></span>Solicitudes</h4>
                                        </div>
                                        <div id="gridbox2" class="adv-table table-responsive" >
                                            <table id="dataDocumentos" class="display table table-bordered table-striped" style="">
                                                <thead>
                                                    <tr>
                                                        <th>nIdSolicitud</th>
                                                        <th>RFC</th>
                                                        <th>Razon Social</th>
                                                        <th>Nivel Actual</th>
                                                        <th>Nivel solicitado</th>
                                                        <th>fecha solicitud</th>
                                                        <th>Nombre documento</th>
                                                        <th>Ver documentos</th>
                                                    </tr>
                                                </thead>    
                                                <tbody >

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="float: right;">
                                    <div class="col-6">
                                        <button id="validadSolicitar" class="btn btn-primary">Validad</button>
                                    
                                        <button id="rechazarSolicitar" class="btn btn-secondary">Rechazar</button>
                                    </div>
                                </div>
                                <input type="hidden" id="nivelActual" name="nivelActual" value="">
                                <input type="hidden" id="nivelSolicitado" name="nivelSolicitado" value="">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div id="modalRespuesta" class="modal fade " role="dialog">
                <div class="modal-dialog" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <span><i class="fa fa-lightbulb-o" style="font-size:18px"></i>Finalizar solicitud</span>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">                
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Rechazo:</label>
                                    <textarea name="comment" id='rechazo' form="usrform"style="width:100%; height: 100%;">Ingrese el motivo del rechazo de la solicitud... </textarea>
                                </div>
                            </div>
                        </div>             

                        <div class="modal-footer" >
                            <div class="row">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-default" id="btnEnviar" style="">Enviar</button>
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
<script src="<?php echo $PATHRAIZ;?>/paynau/js/soporte/mesaControl.js?<?php echo rand() ?>"></script>

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
				initViewMesaControl();
			});
		</script>
</body>
</html>

