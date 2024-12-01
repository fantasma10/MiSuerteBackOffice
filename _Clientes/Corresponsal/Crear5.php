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

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);
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
<title>.::Mi Red::. Pre Alta Corresponsal</title>
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
  <section class="panel">
                         <div class="titulorgb-prealta">
<span><i class="fa fa-file-o"></i></span>
<h3><?php echo $oCorresponsal->getNombre(); ?></h3><span class="rev-combo pull-right">Pre Alta<br>Corresponsal</span></div>
                          <div class="panel-body">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px; margin-top:20px;">
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
                        	<img src="../../img/4.png" id="paso4">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(5, existenCambios)">
                        	<img src="../../img/5a.png" id="paso5Actual">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(6, existenCambios)">
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
             
                             <div class="legend-big"><i class="fa fa-archive"></i> Documentaci&oacute;n</div>  
                            <form method="post" id="formulario" action="../../inc/Ajax/_Clientes/CargarComprobantesCorresponsal.php" enctype="multipart/form-data">
                            
                                      
                                      <table  class="tablanueva">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablita">Archivo</th>
                                           <th class="theadtablita">Seleccionar</th>
                                           <th class="theadtablita">Estado</th>
                                     </tr>
                                      </thead>
                                       <tbody class="tablapequena">   
                                      <tr>
                                      <td class="tdtablita">Comprobante de Domicilio</td>
                                      <td class="tdtablita">
                                      <input type="file" name="fudomicilio" id="fudomicilio" onChange="verificarArchivos()" maxlength="45">
                                      </td>
                                      <td class="tdtablita">
                                      	<?php if($oCorresponsal->getDDomicilio() != ''){ ?>
                                        <img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <?php
                                      	$tipoFORELO = $oCorresponsal->getTipoFORELO();
										if ( $tipoFORELO == 2 ) {
									  ?>
                                      <tr>
                                      <td class="tdtablita">Car&aacute;tula de Banco</td>
                                      <td class="tdtablita">
                                      <input type="file" name="fucabanco" id="fucabanco" onChange="verificarArchivos()" maxlength="45"></td>
                                      <td class="tdtablita">
                                      	<?php if($oCorresponsal->getDBanco() != ''){ ?>
                                        <img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <?php
									  	}
									  ?>
                                      </tbody>
                                      </table>
                                     </form>
                                     <br>
                                     
                                     
                                             <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
                                      <button type="button" class="btn btn-success" id="guardarCambios" onClick="CargarArchivos()" style="margin-top:10px;" disabled>
                                        Guardar
                                      </button> 
                                      </div>
                                     
                                     

                                 <div class="col-lg-12 col-sm-12 col-xs-12">
                                      <div class="pull-left">
                                        <a href="#" onClick="CambioPagina(4, false);">
                                            <img src="../../img/atras.png" id="atras">
                                          </a>
                                      </div>

                                  

                                      <div class="pull-right">
                                        <a href="#" onClick="CambioPagina(6, false);">
                                            <img src="../../img/adelante.png" id="adelante">
                                          </a>
                                      </div>
                                    </div>
                                  </div>

<!--Botones-->
<!--button class="btn btn-medio" type="button" onClick="CargarArchivos()"
id="guardarCambios" disabled>
	Guardar
</button>
<div class="prealta-footer">
<button class="btn btn-default" type="button"
onClick="CambioPagina(6, false)">
	Siguiente
</button>
<button class="btn btn-success" type="button"
onClick="CambioPagina(4, false)">
	Anterior
</button>
</div-->
<!--Cierre Botones-->
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
<!--Elector de Fecha-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Común-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>