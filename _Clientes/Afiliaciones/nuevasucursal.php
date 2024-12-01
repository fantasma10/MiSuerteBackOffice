<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
	$idOpcion = 63;
	$tipoDePagina = "Mixto";
	
	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../../error.php");
		exit();
	}
	
	$submenuTitulo = "Nueva Sucursal";
	
	$directorio = $_SERVER['HTTP_HOST'];
	$PATHRAIZ = "https://".$directorio;
	
	$esEscritura = false;
  	if ( esLecturayEscrituraOpcion($idOpcion) ) {
    	$esEscritura = true;
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
<title>.::Mi Red::.Nueva Sucursal</title>
<!-- Núcleo BOOTSTRAP -->
<link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />
<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" />
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
<style>
	.ui-autocomplete-loading {
		background: white url('<?php echo $PATHRAIZ;?>/img/loadAJAX.gif') right center no-repeat;
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
<?php include($_SERVER['DOCUMENT_ROOT']."/inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include($_SERVER['DOCUMENT_ROOT']."/inc/menu.php"); ?>
<!--Final del Menú Vertical-->
<!--Contenido Principal del Sitio-->

<section id="main-content">


<section class="wrapper site-min-height">
<div class="row">
<div class="col-xs-12">

<!--Panel Principal-->
<div class="panelrgb">
<div class="titulorgb-prealta">
<span><i class="fa fa-users"></i></span>
<h3>Afiliación Express</h3><span class="rev-combo pull-right">Afiliación<br>Express</span></div>

<div class="panel">

<div class="jumbotron">
      <div class="container">
        <h2>Alta de Sucursales</h2>
        <p>Busque y seleccione al cliente que se le dar&aacute; de alta la nueva sucursal.</p>
      </div>
    </div>

<div class="panel-body">
<div class="well"> 
<form class="form-horizontal" id="formBuscarCliente" method="post">
                                  
                                          <div class="form-group buscar">
                                          <label class="col-xs-2 col-xs-offset-1 control-label">Nombre del Cliente:</label>
                                          <div class="col-xs-6">
                                          <input type="hidden" name="idCliente" id="idCliente">
                                          <input type="hidden" name="esSubcadena" id="esSubcadena" value="">
                                          <input type="hidden" name="vieneDeNuevaSucursal" id="vieneDeNuevaSucursal" value="1">
                                          <input type="text" class="form-control m-bot15" placeholder="ID o Nombre del Cliente" name="txtCliente" id="txtCliente">
                                          </div>
                                          <button type="button" class="btn btn-guardar" id="seleccionarCliente">Seleccionar Cliente &nbsp;<i class="fa fa-search"></i></button>
                                          </div>
                                          </form>
                                         </div>
      
   </div>                                         
                                         
</div>
   
  




</div>
</div>
</section>
</section>

<!--*.JS Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/advanced-form-components.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesNuevaSucursal.js"></script>
<script>
	$(function(){
		BASE_PATH		= "<?php echo $PATHRAIZ;?>";
		ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";

		initConsultaCliente();

	});
</script>
<!--Cierre del Sitio-->                             
</body>
</html>
