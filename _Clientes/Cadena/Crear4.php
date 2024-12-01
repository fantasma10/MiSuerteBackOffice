<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreCadena.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="Cadena";

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

$idCadena = (isset($_GET['id'])) ? $_GET['id'] : -1;
if(!isset($_SESSION['idPreCadena']) && $idCadena == -1){
   header('Location: ../../index.php');//redireccionar no existe la pre-cadena
}else if(isset($_SESSION['idPreCadena']) && $idCadena == -1){
	$idCadena = $_SESSION['idPreCadena'];
}
$oCadena = new XMLPreCadena($RBD,$WBD);
$oCadena->load($idCadena);

if ( $oCadena->getExiste() ) {
	$_SESSION['idPreCadena'] = $idCadena;//si existe la pre-cadena guardamos el valor en session
} else {
	header('Location: ../../index.php');//redireccionar no existe la pre-cadena
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
<title>.::Mi Red::. Pre Alta de Cadena</title>
<!-- N�cleo BOOTSTRAP -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../css/miredgen.css" rel="stylesheet">
<link href="../../css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../../assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" href="../../css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />

<style>
	.ui-autocomplete {
		max-height: 190px;
		overflow-y: auto;
		overflow-x: hidden;
		font-size: 12px;
	}	
</style>

<!--Cierre del Sitio-->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Men� Vertical---->
<!--Funci�n "Include" del Men�-->
<?php include("../../inc/menu.php"); ?>
<!--Final del Men� Vertical----->
<!--Final de Barra Vertical Izquierda-->
<!--Contenido Principal del Sitio-->
<!--Funci�n Include del Contenido Principal-->
<?php include("../../inc/main.php"); ?>
<!--Inicio del Contenido-->
<section class="panel">
<div class="titulorgb-prealta">
<span><i class="fa fa-file-o"></i></span>
<h3><?php echo $oCadena->getNombre(); ?></h3><span class="rev-combo pull-right">Pre Alta<br>Cadena</span></div>
<!--<header class="panel-heading">Pre Alta Cadena "<?php echo $oCadena->getNombre(); ?>"</header>-->
 <div class="panel-body">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px; margin-top:20px;">
                    <tbody><tr>
                     <td align="center" valign="middle">&nbsp;</td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(0, existenCambios)">
                        	<img src="../../img/h.png" id="home">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(1, existenCambios)">
                        	<img src="../../img/1.png" id="paso1">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(2, existenCambios)">
                        	<img src="../../img/2.png" id="paso2">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(3, existenCambios)">
                        	<img src="../../img/3.png" id="paso3">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(4, existenCambios)">
                        	<img src="../../img/4a.png" id="paso4Actual">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(5, existenCambios)">
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
 <div class="legend-big"><i class="fa fa-briefcase"></i> Ejecutivos</div> 
								<form class="form-horizontal">
                                    
                                    <div class="form-group">
                                          <label class="col-lg-2 control-label">Ejecutivo De Ventas:</label>
                                          <div class="col-lg-3">
                                            
                                              <input type="text" class="form-control" id="txtejecutivoventa"
                                              placeholder="" onKeyUp="verificarEjecutivos()"
                                              onkeypress="verificarEjecutivos()"
                                              value="<?php
												  if ( !preg_match('!!u', $oCadena->getNombreEVenta()) ) {
													echo trim(utf8_encode($oCadena->getNombreEVenta()));
												  } else {
													echo trim($oCadena->getNombreEVenta());
												  }
											  ?>" maxlength="200">
                                          </div>
                                          
                                  
                                          <label class="col-lg-2 control-label">Ejecutivo De Cuentas:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtejecutivocuenta"
                                              placeholder="" onKeyUp="verificarEjecutivos()"
                                              onkeypress="verificarEjecutivos()"
                                              value="<?php
												  if ( !preg_match('!!u', $oCadena->getNombreECuenta()) ) {
													echo trim(utf8_encode($oCadena->getNombreECuenta()));
												  } else {
													echo trim($oCadena->getNombreECuenta());
												  }											  
											  ?>" maxlength="200">
                                          </div>
                                    </div>
                                      
                            	</form>
                                  
                         <!--Boton-->
                         
                        <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" class="btn btn-success" id="guardarCambios"
disabled onClick="EditarEjecutivosPreCadena()" style="margin-top:10px;">
	Guardar
</button> 
</div>
                        
<!--Botones-->
<div class="col-lg-12 col-sm-12 col-xs-12">

<div class="pull-left">
<a href="#" onClick="CambioPagina(3, existenCambios);">
	<img src="../../img/atras.png" id="atras">
</a>
</div>                              


<div class="pull-right">
<a href="#" onClick="CambioPagina(5, existenCambios);">
	<img src="../../img/adelante.png" id="adelante">
</a>
</div>                               
</div>
<!--Cierre Botones-->

<!--Cierre-->
</div>
</div>
</section>
</section>                             
</body>
</html>


<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../inc/js/respond.min.js" ></script>
<script src="../../inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCadena.js" type="text/javascript"></script>
<script src="../../inc/js/common-scripts.js"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>