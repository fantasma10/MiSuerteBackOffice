<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreSubCadena.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="SubCadena";

$idSubCadena = (isset($_GET['id'])) ? $_GET['id'] : -1;
if(!isset($_SESSION['idPreSubCadena']) && $idSubCadena == -1){
   header('Location: ../../index.php');//redireccionar no existe la pre-cadena
}else if(isset($_SESSION['idPreSubCadena']) && $idSubCadena == -1){
    $idSubCadena = $_SESSION['idPreSubCadena'];
}
$oSubcadena = new XMLPreSubCad($RBD,$WBD);
$oSubcadena->load($idSubCadena);

if($oSubcadena->getExiste()){
    $_SESSION['idPreSubCadena'] = $idSubCadena;//si existe la pre-cadena guardamos el valor en session
} else {
    header('Location: ../../index.php');//redireccionar no existe la pre-cadena
}

$direccionPaso2 = false;
$calle = $oSubcadena->getCalle();
if ( isset($calle) && !empty($calle) ) {
	if ( $oSubcadena->getCalle() == $oSubcadena->getCCalle() && $oSubcadena->getNext() == $oSubcadena->getCNext()
	&& $oSubcadena->getNint() == $oSubcadena->getCNint() && $oSubcadena->getPais() == $oSubcadena->getCPais()
	&& $oSubcadena->getEstado() == $oSubcadena->getCEstado() && $oSubcadena->getCiudad() == $oSubcadena->getCCiudad()
	&& $oSubcadena->getColonia() == $oSubcadena->getCColonia() && $oSubcadena->getCP() == $oSubcadena->getCCP() ) {
		$direccionPaso2 = true;
	}
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
<title>.::Mi Red::. Pre Alta de Sub Cadena</title>
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
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<script src="../../inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreSubCadena.js" type="text/javascript"></script>
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
<h3><?php echo $oSubcadena->getNombre(); ?></h3><span class="rev-combo pull-right">Pre Alta<br>Sub Cadena</span></div>
                          
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
                        	<img src="../../img/5.png" id="paso5">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(6, existenCambios)">
                        	<img src="../../img/6.png" id="paso6">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(7, existenCambios)">
                        	<img src="../../img/7a.png" id="paso7Actual">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(8, existenCambios)">
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
                             <div class="legend-big"><i class=" fa fa-archive"></i> Documentaci&oacute;n</div>  
                            <form method="post" id="formulario" action="../../inc/Ajax/_Clientes/CargarComprobantesSubCadena.php" enctype="multipart/form-data">
                            
                                      
                                      <table  class="tablanueva">
                                    <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablita">Archivo</th>
                                           <th class="theadtablita">Seleccionar</th>
                                           <th class="theadtablita">Estado</th>
                                     </tr>
                                      </thead>
                                       <tbody class="tablapequena">
                                      <?php if ( $oSubcadena->SemaforoDireccion() == 0 ) { ?>    
                                      <tr>
                                       <td class="tdtablita">Comprobante de Domicilio</td>
                                       <td class="tdtablita">
                                      <input type="file" name="fudomicilio" id="fudomicilio" onChange="verificarArchivos()" maxlength="45">
                                      </td>
                                       <td class="tdtablita">
                                      	<?php if ( $oSubcadena->getDDomicilio() != '' ) { ?>
                                      	<img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <?php } ?>
                                      <?php if ( !$direccionPaso2 ) { ?>
                                      <tr>
                                       <td class="tdtablita">Comprobante de Domicilio Fiscal</td>
                                       <td class="tdtablita">
                                      <input type="file" name="fudomiciliofiscal" id="fudomiciliofiscal" onChange="verificarArchivos()" maxlength="45">
                                      <input type="hidden" name="mismaDireccionPaso2" id="mismaDireccionPaso2" value="0" />
                                      </td>
                                       <td class="tdtablita">
                                      	<?php if ( $oSubcadena->getDFiscal() != '' ) { ?>
                                        <img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <?php } else { ?>
                                      <input type="hidden" name="mismaDireccionPaso2" id="mismaDireccionPaso2" value="1" />
                                      <?php } ?>                                  
                                      <tr>
                                      <td class="tdtablita">Caratula de Banco</td>
                                      <td class="tdtablita"><input type="file" name="fucabanco" id="fucabanco" style="" onChange="verificarArchivos()" maxlength="45"></td>
                                      <td class="tdtablita">
                                      	<?php if ( $oSubcadena->getDBanco() != '' ) { ?>
                                      	<img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <tr>
                                       <td class="tdtablita">Identificaci&oacute;n de Representante Legal</td>
                                      <td class="tdtablita"><input type="file" name="fuidenrep" id="fuidenrep" onChange="verificarArchivos()" maxlength="45"></td>
                                       <td class="tdtablita">
                                      	<?php if ( $oSubcadena->getDRepLegal() != '' ) { ?>
                                      	<img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <tr>
                                       <td class="tdtablita">RFC Raz&oacute;n Social</td>
                                       <td class="tdtablita"><input type="file" name="fursocial" id="fursocial" onChange="verificarArchivos()" maxlength="45"></td>
                                       <td class="tdtablita">
                                      	<?php if ( $oSubcadena->getDRSocial() != '' ) { ?>
                                      	<img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <?php if ( $oSubcadena->getCRegimen() == 2 ) { ?>
                                      <tr>
                                       <td class="tdtablita">Acta Constitutiva</td>
                                       <td class="tdtablita"><input type="file" name="fuactacons" id="fuactacons" onChange="verificarArchivos()" maxlength="45"></td>
                                      <td class="tdtablita">
                                      	<?php if ( $oSubcadena->getDAConstitutiva() != '' ) { ?>
                                      	<img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <tr>
                                      <td class="tdtablita">Poderes</td>
                                       <td class="tdtablita"><input type="file" name="fupoderes" id="fupoderes" onChange="verificarArchivos()" maxlength="45"></td>
                                       <td class="tdtablita">
                                      	<?php if ( $oSubcadena->getDPoderes() != '' ) { ?>
                                      	<img src="../../img/add.png">
                                        <?php } ?>
                                      </td>
                                      </tr>
                                      <?php } ?>
                                      </tbody>
                                      </table>
                                     </form>
                                
<!--Botones Finales-->
                         
<!--Botones-->
  <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" class="btn btn-success" style="margin-top:10px;"
id="guardarCambios" onClick="CargarArchivos()" disabled>
	Guardar
</button> 
</div>
<!--Botones-->
<div class="col-lg-12 col-sm-12 col-xs-12">
<div class="pull-left">
<a href="#" onClick="CambioPagina(6, existenCambios);">
	<img src="../../img/atras.png" width="30" height="30" id="atras">
</a>
</div>                              



<div class="pull-right">
<a href="#" onClick="CambioPagina(8, existenCambios);">
	<img src="../../img/adelante.png" width="30" height="30" id="adelante">
</a>
</div>                               
</div>
<!--Cierre Botones-->
<!--Cierre Botones-->
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
<script type="text/javascript" src="../../inc/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Común-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>