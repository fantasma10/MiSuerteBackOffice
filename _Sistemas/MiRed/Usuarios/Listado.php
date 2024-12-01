<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$tipoDePagina = "Mixto";
$idOpcion = 29;
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META http-equiv="Content-Type" content="text/html; charset="Windows-1252">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<title>Listado Usuarios</title>
<!--Favicon-->
<link rel="icon" href="../../../img/favicon.ico" type="image/x-icon">
<!-- Núcleo BOOTSTRAP -->
<link rel="stylesheet" href="../../../css/themes/base/jquery.ui.all.css" />

<link href="../../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../../css/bootstrap-reset.css" rel="stylesheet">
<link href="../../../css/style-autocomplete.css" rel="stylesheet">
<link href="../../../css/jquery.alerts.css" rel="stylesheet">
<link href="../../../css/jquery.powertip.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<link href="../../../css/miredgen.css" rel="stylesheet">
<link href="../../../css/style-responsive.css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="../../../assets/bootstrap-datepicker/css/datepicker.css" />

<script language="JavaScript">
    function goToPage(a)
    {
        window.location.href="Consulta.php?id=" + a;
    }
</script>
</head>

<body>
<?php include("../../../inc/cabecera2.php"); ?>
<?php include("../../../inc/menu.php"); ?>

<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="panel panelrgb">
            <div class="titulorgb-prealta">
                <span><i class="fa fa-users"></i></span>
                <h3>Usuarios</h3>
                <span class="rev-combo pull-right">Usuarios<br/>&nbsp;</span>
            </div>
            <div class="panel-body">
                <?php if ($esEscritura) { ?>
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label>Sincronizar Usuarios de Windows :</label>
                            <a href="#" onclick="SincronizarUsuarios();"/><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <div class="form-group col-xs-12" id="divBusqueda">
                    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <div align="center">
                                    <p><b>Buscar Usuarios por:</b></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table width="500" height="50" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="BorderShadow2 CornerRadius2">
                        <tr>
                            <td width="150" align="center">
                                <input type="radio" id="Activo" name="rdbBusca" onclick="RevisionFiltro()" checked="checked"/><label for="Activo" class="lblrbtn">Activos</label>
                            </td>
                            <td width="150" align="center">
                                <input type="radio" id="Inactivo" name="rdbBusca" onclick="RevisionFiltro()"/><label for="Inactivo" class="lblrbtn">Inactivos</label>
                            </td>
                            <td width="150" align="center">
                                <input type="radio" id="Eliminado" name="rdbBusca" onclick="RevisionFiltro()"/>
                                <label for="Eliminado" class="lblrbtn">Eliminados</label>
                            </td>
                        </tr>
                    </table>
                </div>                
                <table width="500" height="70" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                    <td align="center"> <a id="Mostrar" style="visibility:hidden; cursor:pointer;">Cambiar Busqueda <i class="fa fa-chevron-down"></i></a> </td>
                    </tr>
                </table>

                <div class="form-group col-xs-12">
                <div id="gridboxExport" class="adv-table table-responsive">
                    <div id="gridbox" class="adv-table table-responsive">
                        <table id="usuarios" class="display table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Perfil</th>
                                <th>Correo</th>
                                <th>Nombre</th>
    							<th></th>
                                <th></th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
            </div>
        </div>
    </section>
</section>

<script src="../../../inc/js/jquery.js"></script>
<script src="../../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../../inc/js/respond.min.js" ></script>
<script type="text/javascript" src="../../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../../inc/js/common-scripts.js"></script>
<script src="../../../inc/js/common-custom-scripts.js"></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<script src="../../../inc/js/UsuariosDataTableEditable.js" type="text/javascript"></script>
<script src="../../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../../inc/js/_Admin.js" type="text/javascript"></script>
<script type="text/javascript">
    BASE_PATH = '<?php echo $PATHRAIZ;?>';
</script>
</body>
<?php // $RBD->close(); ?>
</html>
