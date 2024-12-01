<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreCorresponsal.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="Corresponsal";

$idCorresponsal = (isset($_GET['id'])) ? $_GET['id'] : -1;
if(!isset($_SESSION['idPreCorresponsal']) && $idCorresponsal == -1){
   //header('Location: ../../index.php');//redireccionar no existe la pre-cadena
}else if(isset($_SESSION['idPreCorresponsal']) && $idCorresponsal == -1){
    $idCorresponsal = $_SESSION['idPreCorresponsal'];
}
$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($idCorresponsal);

if($oCorresponsal->getExiste()){
    $_SESSION['idPreCorresponsal'] = $idCorresponsal;//si existe la pre-cadena guardamos el valor en session
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
<title>.::Mi Red::. Pre Alta de Corresponsal</title>
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
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCorresponsal.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical---->
<!--Función "Include" del Menú-->
<?php include("../../inc/menu.php"); ?>
<!--Final del Menú Vertical----->
<!--Final de Barra Vertical Izquierda-->
<!--Contenido Principal del Sitio-->
<!--Función Include del Contenido Principal-->
<?php include("../../inc/main.php"); ?>
<!--Inicio del Contenido-->
  <section class="panel"><div class="titulorgb-prealta">
<span><i class="fa fa-file-o"></i></span>
<h3><?php echo $oCorresponsal->getNombre(); ?></h3><span class="rev-combo pull-right">Pre Alta<br>Corresponsal</span></div><div class="panel-body">
                         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px; margin-top:20px;">
                    <tbody><tr>
                     <td align="center" valign="middle">&nbsp;</td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(0, false)">
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
                        	<img src="../../img/5.png" id="paso5">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(6, false)">
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
                       <div class="legend-big"> <i class="fa fa-list-alt"></i> Estatus</div>                                   
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
                                      <td class="tdtablita">Datos Generales</a></td>
                                      <td class="tdtablita">
										<?php
                                            switch ( $oCorresponsal->SemaforoGenerales() ) {
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
                                      <td class="tdtablita">Direcci&oacute;n</a></td>
                                      <td class="tdtablita">
										<?php
                                            switch ( $oCorresponsal->SemaforoDireccion() ) {
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
                                      <td class="tdtablita"><a href="#" onClick="CambioPagina(3, false)"><img src="../../img/3_sm.png"></a></td>
                                      <td class="tdtablita">Contactos</a></td>
                                      <td class="tdtablita">
										<?php
                                            switch ( $oCorresponsal->SemaforoContactos() ) {
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
                                      <td class="tdtablita"><a href="#" onClick="CambioPagina(4, false)"><img src="../../img/4_sm.png"></a></td>
                                      <td class="tdtablita">Cuenta</a></td>
                                      <td class="tdtablita">
										<?php
                                            switch ( $oCorresponsal->SemaforoCuenta() ) {
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
                                      <td class="tdtablita"><a href="#" onClick="CambioPagina(5, false)"><img src="../../img/5_sm.png"></a></td>
                                      <td class="tdtablita">Documentaci&oacute;n</a></td>
                                      <td class="tdtablita">
										<?php
                                            switch ( $oCorresponsal->SemaforoDocumentacion() ) {
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
                                      
                                      <!--Botones-->

<!--div class="prealta-footer">
<button class="btn btn-default" type="button"
onClick="CambioPagina(1, false)">
	Siguiente
</button>

</div-->
 <div class="col-lg-12">
 <div class="pull-right">
        <a href="#" onClick="CambioPagina(1, false);">
            <img src="../../img/adelante.png" id="adelante">
          </a>
      </div>
    </div>
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
<!--*.JS Generales-->
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>