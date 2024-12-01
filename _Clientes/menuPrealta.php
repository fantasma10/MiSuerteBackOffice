<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");

$submenuTitulo = "Pre-Alta";

$idOpcion = 2;
$tipoDePagina = "Mixto";
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

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
<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::. Crear Pre Alta</title>
<!-- Núcleo BOOTSTRAP -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../css/miredgen.css" rel="stylesheet">
<link href="../css/style-responsive.css" rel="stylesheet" />

<!--Cierre del Sitio-->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../inc/cabecera.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical---->
<!--Función "Include" del Menú-->
<?php include("../inc/menu.php"); ?>
<!--Final del Menú Vertical----->
<!--Final de Barra Vertical Izquierda-->
<!--Contenido Principal del Sitio-->
<!--Función Include del Contenido Principal-->
<?php include("../inc/main.php"); ?>
<!--Inicio del Contenido-->
<section class="panel">

<div class="titulorgb-prealta">
<span><i class="fa fa-file-o"></i></span>
<h3>Crear Pre Alta</h3><span class="rev-combo pull-right">Menú<br>Pre Alta</span></div>

<div class="panel-body">
<!--<legend>Crear Pre Alta</legend>-->
<div class="col-md-9 col-md-offset-2">
 
    <div class="col-sm-4">
        <img src="../img/cca.png" onClick="tipoconsulta=0;CrearGeneral(false);" width="60" height="60">
        <input name="radio" type="radio" id="rdbCadena"
        onclick="tipoconsulta=0;CrearGeneral(false);">
        <label for="rdbCadena">Cadena</label>
    </div>
 
    <div class="col-sm-4">
        <img src="../img/csu.png" onClick="tipoconsulta=1;CrearGeneral(false);" width="60" height="60">
        <input name="radio" type="radio" id="rdbSubCadena"
        onclick="tipoconsulta=1;CrearGeneral(false);"
        value="radio">
        <label for="rdbSubCadena">Sub Cadena</label>
    </div>
 
    <div class="col-sm-4">
        <img src="../img/cco.png" onClick="tipoconsulta=2;CrearGeneral(false);" width="60" height="60">
        <input name="radio" type="radio"
        onclick="tipoconsulta=2;CrearGeneral(false);" id="rdbCorresponsal"
        value="radio">
        <label for="rdbCorresponsal">Corresponsal</label>
    </div>
</div>
</div>
<!--2 Panel-->
<div class="panel-body" id="creacion" style="display:none;">
	<!--<legend id="tipoDeCreacion">Cadena</legend>-->
	<div class="col-sm-12">
		<div class="col-sm-9 col-sm-offset-2">
            <form class="form-horizontal" id="datos-generales"> 
                <div class="form-group">
                    <label class="col-md-1 col-md-offset-1 control-label">Nombre:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="txtcrear" placeholder="" maxlength="50">
                    </div>
                    <div class="col-xs-1">
                        <button type="button" class="btn btn-info btn-xs"
                        onclick="CrearGeneral(true);">
                            Crear
                        </button>
                    </div>
                </div>
			</form>
		</div>
	</div>
</div>
<!--Cierre-->
</div>
</section>
<!--2-->
</div>
</div>
</section>
</section>
<!--Fin de Tabla-->
<!--Forma-->

</section>
<!--Cierre Main-->
</div>
</div>
</section>
</section>                             
</body>
</html>

<!--*.JS Generales-->
<script src="../inc/js/jquery.js"></script>
<script src="../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../inc/js/jquery.scrollTo.min.js"></script>
<script src="../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../inc/js/respond.min.js" ></script>
<script src="../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Generales-->
<script src="../inc/js/RE.js" type="text/javascript"></script>
<script src="../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../inc/js/_PrealtaCreacion.js" type="text/javascript"></script>
<script src="../inc/js/common-scripts.js"></script>