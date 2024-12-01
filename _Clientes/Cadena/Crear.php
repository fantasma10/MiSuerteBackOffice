<?php
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreCadena.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="Cadena";
if(!isset($_SESSION['rec']))
    $_SESSION['rec'] = true;
    
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
                          <!--<header class="panel-heading">
                              Pre Alta Cadena "<?php echo $oCadena->getNombre(); ?>"
                          </header>-->
                          
                          <!--Cambio-->
<div class="titulorgb-prealta">
<span><i class="fa fa-file-o"></i></span>
<h3><?php echo $oCadena->getNombre(); ?></h3><span class="rev-combo pull-right">Pre Alta<br>Cadena</span></div>
                          
                          <div class="panel-body">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px; margin-top:20px;">
                    <tbody><tr>
                     <td align="center" valign="middle">&nbsp;</td>
                      <td align="center" valign="middle">
                      	<a href="#">
                        	<img src="../../img/h_a.png" id="homeActual">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(1, false)">
                        	<img src="../../img/1.png" id="paso1">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(2, false)">
                        	<img src="../../img/2.png" id="paso2">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(3, false)">
                        	<img src="../../img/3.png" id="paso3">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(4, false)">
                        	<img src="../../img/4.png" id="paso4">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(5, false)">
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
                            <div class="legend-big"><i class="fa fa-list-alt"></i> Estatus</div>                                  
                                      <table  class="tablanueva">
                                      <thead class="theadtablita">
                                      <tr>
                                      <th class="theadtablita">#</th>
                                      <th class="theadtablita">Paso</th>
                                      <th class="theadtablita">Estado</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                      <td class="tdtablita"><a href="#" onClick="CambioPagina(1, false)"><img src="../../img/1_sm.png"></a></td>
                                       <td class="tdtablita">&nbsp;Datos Generales</td>
                                       <td class="tdtablita">
										<?php
                                            switch ( $oCadena->SemaforoGenerales() ) {
                                                case 0:
                                                    echo "<img src=\"../../img/green.png\">";
                                                break;
                                                case 1:
                                                    echo "<img src=\"../../img/yell.png\">";
                                                break;
												case 2:
													echo "<img src=\"../../img/red.png\">";
												break;
                                                default:
                                                    echo "<img src=\"../../img/red.png\">";
                                                break;
                                            }										
                                        ?>
                                      </td>
                                      </tr>
                                      <tr>
                                       <td class="tdtablita"><a href="#" onClick="CambioPagina(2, false)"><img src="../../img/2_sm.png"></a></td>
                                       <td class="tdtablita"> &nbsp;Direcci&oacute;n</td>
                                       <td class="tdtablita">
										<?php
                                            switch ( $oCadena->SemaforoDireccion() ) {
                                                case 0:
                                                    echo "<img src=\"../../img/opcional3.png\">";
                                                break;
                                                case 1:
                                                    echo "<img src=\"../../img/opcional2.png\">";
                                                break;
												case 2:
													echo "<img src=\"../../img/opcional.png\">";
												break;												
                                                default:
                                                    echo "<img src=\"../../img/opcional.png\">";
                                                break;
                                            }										
                                        ?>                                      
                                      </td>
                                      </tr>
                                      <tr>
                                       <td class="tdtablita"><a href="#" onClick="CambioPagina(3, false)"><img src="../../img/3_sm.png"></a></td>
                                        <td class="tdtablita">&nbsp;Contactos</td>
                                       <td class="tdtablita">
										<?php
                                            switch ( $oCadena->SemaforoContactos() ) {
                                                case 0:
                                                    echo "<img src=\"../../img/opcional3.png\">";
                                                break;
                                                case 1:
                                                    echo "<img src=\"../../img/opcional2.png\">";
                                                break;
												case 2:
													echo "<img src=\"../../img/opcional.png\">";
												break;												
                                                default:
                                                    echo "<img src=\"../../img/opcional.png\">";
                                                break;
                                            }										
                                        ?>                                      
                                      </td>
                                      </tr>
                                      <tr>
                                      <td class="tdtablita"><a href="#" onClick="CambioPagina(4, false)"><img src="../../img/4_sm.png"></a></td>
                                       <td class="tdtablita">&nbsp;Ejecutivo</td>
                                       <td class="tdtablita">
										<?php
                                            switch ( $oCadena->SemaforoEjecutivos() ) {
                                                case 0:
                                                    echo "<img src=\"../../img/green.png\">";
                                                break;
                                                case 1:
                                                    echo "<img src=\"../../img/yell.png\">";
                                                break;
												case 2:
													echo "<img src=\"../../img/red.png\">";
												break;												
                                                default:
                                                    echo "<img src=\"../../img/red.png\">";
                                                break;
                                            }										
                                        ?>                                      
                                      </td>
                                      </tr>
                                      </tbody>
                                      </table>
                                      
                                     <div class="col-lg-12">
<div class="pull-right">
<a href="#" onClick="CambioPagina(1, false);">
	<img src="../../img/adelante.png" id="adelante" >
</a>
</div>                               
</div></div>
                        </div>
                        </section>
                        </div>
                        </div>
          
  </section>
</section>
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
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCadena.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>