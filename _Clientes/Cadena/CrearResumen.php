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

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="Cadena";

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

$idPerfil = $_SESSION['idPerfil'];

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
<title>.::Mi Red::. Resumen Pre Alta</title>
<!-- N�cleo BOOTSTRAP -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../css/miredgen.css" rel="stylesheet">
<link href="../../css/style-responsive.css" rel="stylesheet" />

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
<!--<header class="panel-heading">
Pre Alta Cadena "<?php echo $oCadena->getNombre(); ?>"-->
                          </header>
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
                        	<img src="../../img/4.png" id="paso4">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(5, existenCambios)">
                        	<img src="../../img/r_a.png" id="resumenActual">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
                           <div class="legend-big"><i class="fa fa-file-text-o"></i> Resumen</div> 
                                    
                                   <legend> <i class="fa fa-book"></i> Datos Generales</legend>
                                   <table class="display table table-bordered table-striped">
                                  	<tbody>
                                        <tr>
                                          <td style="width:180px;">NOMBRE</td>
                                          <td>
										  <?php
                                          	 if ( $oCadena->getNombre() != NULL && $oCadena->getNombre() != "" ) {
											 	echo $oCadena->getNombre();
											 } else {
											 	echo "N/A";
											 }
										  ?>
                                          </td>
                                        </tr>
                                          <tr>
                                          <td>GRUPO</td>
                                          <td>
										  	<?php
                                            	if ( $oCadena->getNombreGrupo() != NULL && $oCadena->getNombreGrupo() != "" ) {
													echo $oCadena->getNombreGrupo();
												} else {
													echo "N/A";
												}
											?>                                          
                                          </td>
                                        </tr>
                                          <tr>
                                          <td>REFERENCIA</td>
                                          <td>
										  	<?php
                                          		if( $oCadena->getNombreReferencia() != NULL && $oCadena->getNombreReferencia() != "" ) {
													echo $oCadena->getNombreReferencia();
												} else {
													echo "N/A";
												}
											?>                                          
                                          </td>
                                        </tr>
                                          <tr>
                                          <td>TELÉFONO</td>
                                          <td>
										  	<?php
                                            	if ( $oCadena->getTel1() != NULL && $oCadena->getTel1() != "" ) {
													echo $oCadena->getTel1();
												} else {
													echo "N/A";
												}
											?>                                          
                                          </td>
                                        </tr>
                                          <tr>
                                          <td>CORREO</td>
                                          <td>
										  	<?php
                                            	if ( $oCadena->getCorreo() != NULL && $oCadena->getCorreo() != "" ) {
													echo $oCadena->getCorreo();
												} else {
													echo "N/A";
												}
											?>                                          
                                          </td>
                                        </tr>
                                   	</tbody>
                                   </table>                                      
                                      <legend><i class="fa fa-home"></i> Direcci&oacute;n</legend>
                                   <table  class="display table table-bordered table-striped">
                                      <tbody>
                                      <tr>
                                      <td style="width:180px;">DIRECCI&Oacute;N</td>
                                      <td>
                                        <?php
											if ( $oCadena->getCalle() != '' && $oCadena->getNext() != ''
											&& $oCadena->getColonia() != '' && $oCadena->getCP() != '' && $oCadena->getNombreCiudad() != ''
											&& $oCadena->getNombreEstado() != '' && $oCadena->getNombrePais() != '' ) {
												if ( $oCadena->getCalle() != '' )
													echo (!preg_match('!!u', $oCadena->getCalle()))? utf8_encode($oCadena->getCalle()) : $oCadena->getCalle(); 
												if ( $oCadena->getCalle() != '' && $oCadena->getNext() != '' )    
													echo " No. ".$oCadena->getNext();
												if ( $oCadena->getCalle() != '' && $oCadena->getNint() != '' )
													echo " No. Int. ".$oCadena->getNint();
												
												echo "<br />";
												
												if ( $oCadena->getColonia() != '' )
													echo "Col. ".utf8_encode($oCadena->getNombreColonia());
												if ( $oCadena->getCP() != '' )
													echo " C.P. ".$oCadena->getCP();
												
												echo "<br />";										
												
												if ( $oCadena->getColonia() != '' && $oCadena->getNombreCiudad() != '' )
													echo utf8_encode($oCadena->getNombreCiudad());                                    
												if ( $oCadena->getNombreEstado() != '' )
													echo ", ".utf8_encode($oCadena->getNombreEstado());
												if ( $oCadena->getNombreEstado() != '' && $oCadena->getNombrePais() )
													echo ", ".utf8_encode($oCadena->getNombrePais());
											} else {
												echo "N/A";
											}								
										?>                                      
                                      </td>
                                      </tr>
                                      </tbody>
                                   </table>
                                   
                                      
                                   <legend><i class="fa fa-users"></i> Contacto</legend>
                                    <table class="tablanueva">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Contacto</th>
                                          <th class="theadtablita">Tel&eacute;fono</th>
                                          <th class="theadtablita">Extensi&oacute;n</th>
                                          <th class="theadtablita">Correo</th>
                                          <th class="theadtablitados">Tipo de Contacto</th>
                                      </tr>
                                      </thead>
                                      <tbody class="tablapequena">
									  <?php
                                        $sql = "CALL `prealta`.`SP_LOAD_PRECADENA`({$_SESSION['idPreCadena']});";
                                        $ax = $sql;
                                        $res = $RBD->SP($sql);
                                        $AND = "";
                                        if ( $RBD->error() == '' ) {
                                            if ( $res != '' && mysqli_num_rows($res) > 0 ) {
                                                $r = mysqli_fetch_array($res);
                                                $reg = $r[0];
                                                $xml = simplexml_load_string(utf8_encode($reg));
                                                /*$r = mysqli_fetch_array($res);

                                                $reg = base64_decode($r[0]);
                                                $xml = simplexml_load_string(utf8_encode($reg));*/
                                                /*$r = mysqli_fetch_array($res);
                                                $xml = simplexml_load_string($r[0]);*/
                                                $band = false;
                                                foreach ( $xml->Contactos->Contacto as $cont ) {
                                                    if ( $band == false && $cont != '' ) {
                                                        $AND .= " AND I.`idCadenaContacto` = $cont ";
                                                        $band = true;
                                                    } else if ( $band ) {
                                                        $AND .= " OR I.`idCadenaContacto` = $cont ";
                                                    }
                                                }
                                                if ( $AND != '' ) {
                                                    $sql = "CALL `prealta`.`SP_LOAD_CONTACTOSPDFAUTORIZACIONPRECADENA`('$AND');";
                                                    $Result = $RBD->SP($sql);
                                                    if ( $RBD->error() == '' ) {
                                                        if ( $Result != '' && mysqli_num_rows($Result) > 0 ) {
                                                            $i = 0;
                                                            while ( list($infid,$tipo,$id,$nombre,$paterno,$materno,$telefono,$ext,$correo,$desc) = mysqli_fetch_array($Result) ) {
                                                                if ( !preg_match('!!u', $nombre) ) {
                                                                    $nombre = utf8_encode($nombre);
                                                                }
                                                                if ( !preg_match('!!u', $paterno) ) {
                                                                    $paterno = utf8_encode($paterno);
                                                                }
                                                                if ( !preg_match('!!u', $materno) ) {
                                                                    $materno = utf8_encode($materno);
                                                                }                                                            
																echo "<tr>";
                                                                echo "<td class=\"tdtablita\">$nombre $paterno $materno</td>";
                                                                echo "<td class=\"tdtablita\">$telefono</td>";
                                                                echo "<td class=\"tdtablita\">$ext</td>";
                                                                echo "<td class=\"tdtablita\">$correo</td>";
                                                                echo "<td class=\"tdtablita\">".utf8_encode($desc)."</td>";
                                                                echo "</tr>";																
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                } else {
												  echo "<td class=\"tbodyuno\"></td>";
												  echo "<td class=\"tdtablita\"></td>";
												  echo "<td class=\"tdtablita\"></td>";
												  echo "<td class=\"tdtablita\"></td>";
												  echo "<td class=\"tdtablita\"></td>";												
												}								
                                            }	
                                        } else {
										  echo "<td class=\"tdtablita\"></td>";
										  echo "<td class=\"tdtablita\"></td>";
										  echo "<td class=\"tdtablita\"></td>";
										  echo "<td class=\"tdtablita\"></td>";
										  echo "<td class=\"tdtablita\"></td>";									
                                        }						  
                                      ?>
                                 </tbody>
                                  </table>
                                  
                                      <legend><i class="fa fa-briefcase"></i> Ejecutivos</legend>
                                      <table  class="display table table-bordered table-striped">
                                      <tbody>
                                      <tr>
                                      <td style="width:180px;">Ejecutivo de Ventas</td>
                                      <td>
									  <?php
                                      	if ( $oCadena->getNombreEVenta() != NULL && $oCadena->getNombreEVenta() != "" ) {
											if ( !preg_match('!!u', $oCadena->getNombreEVenta()) ) {
												echo utf8_encode($oCadena->getNombreEVenta());
											} else {
												echo $oCadena->getNombreEVenta();
											}
										} else {
											echo "N/A";
										}
									  ?>
                                      </td>
                                      </tr>
                                      <tr>
                                      <td style="width:180px;">Ejecutivo de Cuenta</td>
                                      <td>
									  <?php
                                      	if ( $oCadena->getNombreECuenta() != NULL && $oCadena->getNombreECuenta() != "" ) {
											if ( !preg_match('!!u', $oCadena->getNombreECuenta()) ) {
												echo utf8_encode($oCadena->getNombreECuenta());
											} else {
												echo $oCadena->getNombreECuenta();
											}
										} else {
											echo "N/A";
										}
									  ?>
                                      </td>
                                      </tr>
                                      </tbody>
                                      </table>
                             
                             <legend></legend>
                             
                             <!--botons-->
<div class="col-lg-12 col-sm-12 col-xs-12">
<div class="pull-left">
<a href="#" onClick="CambioPagina(4, false);">
	<img src="../../img/atras.png" id="atras">
</a>
</div>                               

<div class="pull-right">
<input type="hidden" id="idCadena" value="<?php echo $oCadena->getID();?>" />
<?php if ( $esEscritura && $oCadena->getPorcentaje() == 100 && ($idPerfil == 1 || $idPerfil == 4 || $idPerfil == 7) ) { ?>
<button type="button" class="btn btn-success" onClick="irAValidacion(<?php echo $oCadena->getID(); ?>)">Validar</button>
<?php } ?>
</div>                               
</div>
                      
                      
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
<!--Generales-->
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PreAltaPreCadena.js" type="text/javascript"></script>
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->