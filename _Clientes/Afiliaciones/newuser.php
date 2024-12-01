<?php
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");

$idOpcion = 60;
$tipoDePagina = "Mixto";

if(!empty($_POST['consultaAfiliacion'])){
	$idOpcion = 61;
	$ESCONSULTA = true;
}
else{
	$idOpcion = 60;
	$ESCONSULTA = false;
}

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
}

$idAfiliacion = ( isset($_GET["idAfiliacion"]) )? $_GET["idAfiliacion"] : -500;

$idNivel = ( !empty($_POST["idNivel"]) )? $_POST["idNivel"] : NULL;
$familias = ( !empty($_POST["familias"]) )? $_POST["familias"] : NULL;
$idCliente = ( !empty($_POST["idCliente"]) )? $_POST["idCliente"] : NULL;

/*$idNivel = 3;
$familias = "6|4|5|7|3";*/

$haySeleccion = 0;
if ( isset($idNivel) && isset($familias) ) {
	$haySeleccion = 1;
}

$hayCliente = 0;
if ( isset($idCliente) ) {
	$hayCliente = 1;
}

$submenuTitulo = "Nuevo Cliente";

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::.Nuevo Usuario</title>
<!-- Núcleo BOOTSTRAP -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../css/miredgen.css" rel="stylesheet">
<link href="../../css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../../assets/bootstrap-datepicker/css/datepicker.css" />
<style>
	.noesconsulta, .esconsulta{
		display:  none;
	}
</style>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include("../../inc/menu.php"); ?>
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
<h3>Afiliación Express</h3><span class="rev-combo pull-right">Afiliación<br>Express</span></div>

<div class="panel">

<div class="jumbotron">
      <div class="container">
        <h2 id="encabezadoCliente"></h2>
        <p>Seleccione las familias que desea vender.</p>
      </div>
    </div>

<div class="panel-body">


<div class="row" id="seccion-paquetes">
<!--<div class="col-xs-4">
<div class="paquetes-active">
<h6><i class="fa fa-file"></i>  Expediente</h6>
<h5>Básico</h5>
<ul>
<li><div class="views"><input type="checkbox"><label> Telefonía</label></div></li>
<li><div class="views"><input type="checkbox"><label> Servicios</label></div></li>
<li><div class="views"><input type="checkbox"><label> Seguros</label></div></li>
<li><div class="views"><input type="checkbox"><label> Transporte</label></div></li>
</ul>
</div>
</div>
<div class="col-xs-4">
<div class="paquetes">
<h6><i class="fa fa-file"></i> Expediente</h6>
<h5>Intermedio</h5>
<ul id="paquetes-lista">
<li><div class="view"><input type="checkbox"><label> Remesas</label></div></li>
<li><div class="view"><input type="checkbox"><label> Entretenimiento</label></div></li>
</ul>-->
<!--<span>Texto de ayuda, en caso de ser necesario.</span>-->
<!--</div>
</div>
<div class="col-xs-4">
<div class="paquetes">
<h6><i class="fa fa-file"></i>  Expediente</h6>
<h5>Avanzado</h5>
<ul id="paquetes-lista">
<li><div class="view"><input type="checkbox"><label> Bancarios</label></div></li>
</ul>
</div>
</div>-->
</div>

<div class="row">
<div class="col-xs-4">
<div class="paquete-activo">
<span>Nivel de Expediente</span>
<h3 id="nivelDeterminado"></h3>
</div>
</div>
<div class="col-xs-8">
<div class="familias-activas">
<span>Familias Seleccionadas</span>
<h3 id="familiasSeleccionadas"></h3>
</div>
</div>
</div>


              
         
         
      
    <a href="#" class="noesconsulta boton_guardar">
    	<form name="formSiguiente" id="formSiguiente" action="DatosGenerales.php" method="post">
        	<input type="hidden" name="idNivel" value="" />
            <input type="hidden" name="familias" value="" />
            <input type="hidden" name="idCliente" value="" />
    		<button type="button" class="btn btn-xs btn-info pull-right" id="guardarNivel">Siguiente</button>
        </form>
    </a>

    <a href="Cliente.php?idCliente=<?php echo $idCliente;?>" class="esconsulta">
    	<button class="btn btn-xs btn-info pull-left">Regresar</button>
    </a>

    <a href="#" class="esconsulta  boton_guardar">
    	<button class="btn btn-xs btn-info pull-right" onClick="guardarNivel()">Guardar</button>
    </a>

    </div>





</div>
</div></section>
</section>


<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script>
	$(function(){
		ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		ID_AFILIACION	= "<?php echo $idAfiliacion;?>";

		ES_CONSULTA		= "<?php echo $ESCONSULTA;?>";

		HAY_SELECCION	= <?php echo $haySeleccion; ?>;
		
		NIVEL_SELECCION = <?php echo (isset($idNivel))? $idNivel : "null"; ?>;
		FAMILIAS_SELECCION = "<?php echo $familias; ?>";
		
		HAY_CLIENTE = <?php echo $hayCliente; ?>;
		
		CLIENTE_SELECCION = <?php echo (isset($idCliente))? $idCliente : "null"; ?>;

	});
</script>
<script src="../../inc/js/advanced-form-components.js"></script>
<script src="../../inc/js/_Afiliaciones.js"></script>
<!--Cierre del Sitio-->                             


</body>
</html>