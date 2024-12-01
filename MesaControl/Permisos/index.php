<?php
include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session3.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/MesaControl/Permisos/ajax/cat_clientes.php");

$submenuTitulo = "Permisos";
$subsubmenuTitulo = "Agregar permisos";
$tipoDePagina = "Mixto";
$idOpcion = 314;

if (!desplegarPagina($idOpcion, $tipoDePagina)) {
    header("Location: ../../../error.php");
    exit();
}

$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
    $esEscritura = true;
}

$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];
$usuario = $_SESSION['idU'];
getUsuarioRoles($usuario, 1);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
    <title>.::Mi Red::.Permisos</title>
    <!-- Núcleo BOOTSTRAP -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-reset.css" rel="stylesheet">
    <!--ASSETS-->
    <link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
    <!-- ESTILOS MI RED -->
    <link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
    <link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" />
    <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">
    <!-- Autocomplete -->
    <link href="<?php echo $PATHRAIZ; ?>/css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">
    <link href="<?php echo $PATHRAIZ; ?>/css/jquery.alerts.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $PATHRAIZ; ?>/inc/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo $PATHRAIZ; ?>/inc/auto-complete/auto-complete.css">
    <link href="<?php echo $PATHRAIZ; ?>/MesaControl/Permisos/css/estilos.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include($_SERVER['DOCUMENT_ROOT'] . "/inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include($_SERVER['DOCUMENT_ROOT'] . "/inc/menu.php"); ?>
<!--Final del Menú Vertical-->
<!--Contenido Principal del Sitio-->

<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="row">
            <div class="col-lg-12">
                <!--Panel Principal-->
                <div class="panelrgb">
                    <div class="titulorgb-prealta">
                        <span><i class="fa fa-users"></i></span>
                        <h3><span id="panel-title"></span> permisos <em id="descTicketFiscal"></em></h3>
                        <span class="rev-combo pull-right">Comisiones<br>Clientes</span>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-body">
                        <div class="well">
                            <div class="row p-b">
                                <div class="col-xs-6">
                                    <label class="control-label">Cliente</label>
                                    <input type="text" id="txtSCliente" class="form-control" placeholder="Escribir Nombre o RFC...">
                                    <input type="hidden" id="nIdCliente">
                                    <input type="hidden" id="nTicketFiscal">
                                </div>
                                <div class="col-xs-6">
                                    <button id="btn-buscar" type="button" class="btn btn-info" style="margin-top: 20px;">
                                        Buscar
                                        <span class="btn-spinner hide"><i class="fa fa-spinner"></i></span>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <label class="control-label">Cadena</label>
                                    <input type="text" id="txtSCadena" class="form-control" readonly disabled>
                                    <input type="hidden" id="txtIdCadena">
                                </div>
                                <div class="col-xs-3">
                                    <label>Subcadena</label>
                                    <input type="text" id="txtSSubCadena" class="form-control" readonly disabled>
                                    <input type="hidden" id="txtIdSubCadena">
                                </div>
                                <div class="col-xs-3">
                                    <label>Corresponsal</label>
                                    <select class="form-control" id="selectCorresponsal" disabled>
                                        <option value="-1">Todos</option>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <label class="control-label">Proveedor</label>
                                    <select class="form-control" id="selectProveedor" disabled>
                                        <option value="-1">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="informacionPermisos"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 section-buttons hide">
								<button id="btnAutorizar" type="button" class="btn btn-info hide">Autorizar</button>
                                <button id="btnGuardar" type="button" class="btn btn-info hide">Guardar</button>
                            </div>
                        </div>
                        <div id="comision-grupal" class="modal fade col-xs-12" role="dialog">
                            <div class="modal-dialog" style="width:30%;">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Asignar comisión grupal</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="txtComisionCadenaGrupal" class="col-sm-7 control-label">Comisión Cadena</label>
                                            <div class="col-sm-5 input-group">
                                                <input type="text" class="form-control decimals text-right" id="txtComisionCadenaGrupal" placeholder="0.0000" value="0.0000" />
                                                <span class="input-group-addon">%</span>
                                                <!-- <small class="errorComisionCadenaGrupal has-error hidden">El campo es requerido</small> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="btnAsignarComisionGrupal">Asignar</button>
                                        <button type="button" class="btn btn-default" id="btnCancelarComisionGrupal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="modal-confirmacion" class="modal fade col-xs-12" role="dialog">
                            <div class="modal-dialog" style="width:60%;">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p class="modal-text"></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="btnConfirmar">Confirmar</button>
                                        <button type="button" class="btn btn-default" id="btnCancelarConfirmacion">Cancelar</button>
                                    </div>
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
    <script src="<?php echo $PATHRAIZ;?>/inc/jquery-3.6.0.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
	<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
	<!--Generales-->
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/common-custom-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>

    <script src="/inc/DataTables/datatables.min.js"></script>
	<!-- UI Autocomplete -->
	<script src="<?php echo $PATHRAIZ;?>/inc/auto-complete/auto-complete.min.js"></script>
	<!--Cierre del Sitio-->  

<script src="<?php echo $PATHRAIZ;?>/MesaControl/Permisos/js/permisos.js?v=<?php echo rand(); ?>"></script>
<script>
		$(function(){
			BASE_PATH		= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA	= "<?php echo $esEscritura;?>";
			ROLES 			= <?php echo json_encode($_SESSION['roles']); ?>;
			CLIENTES 		= <?php echo json_encode($clientes); ?>;

			initPermisos();
		});
	</script>
<script>
</script>
</body>
</html>