<?php 
#########################################################
#
#Codigo PHP
#
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreSubCadena.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="SubCadena";

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

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
<title>.::Mi Red::. Resumen Pre Alta Sub Cadena</title>
<!-- Núcleo BOOTSTRAP -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../css/miredgen.css" rel="stylesheet">
<link href="../../css/style-responsive.css" rel="stylesheet" />
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
                              <img src="../../img/7.png" id="paso7">
                          </a>
                      </td>
                      <td align="center" valign="middle">
                          <a href="#" onClick="CambioPagina(8, existenCambios)">
                              <img src="../../img/r_a.png" id="resumenActual">
                          </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
                          <div class="legend-big"><i class="fa fa-file-o"></i> Resumen</div>  
                                    
                                   <legend><i class="fa fa-book"></i> Datos Generales</legend> 
                               <table class="display table table-bordered table-striped">
                                   <tbody>
                                    <tr>
                                          <td style="width:200px;">Nombre</td>
                                          <td>
										  	<?php
												$nombre = $oSubcadena->getNombre();
												if ( !preg_match('!!u', $nombre) ) {
													//no es utf-8
													$nombre = utf8_encode($nombre);
												}
												if ( $nombre != "" ) {
													echo $nombre;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Cadena</td>
                                          <td>
											  <?php
											  	$nombreCadena = $oSubcadena->getNombreCadena();
												if ( !preg_match('!!u', $nombreCadena) ) {
													//no es utf-8
													$nombreCadena = utf8_encode($nombreCadena);
												}
												if ( $nombreCadena != "" ) {
													echo $nombreCadena;
												} else {
													echo "N/A";
												}
                                              ?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Grupo</td>
                                          <td>
										  	<?php
												$grupo = $oSubcadena->getNombreGrupo();
												if ( !preg_match('!!u', $grupo) ) {
													//no es utf-8
													$grupo = utf8_encode($grupo);
												}
												if ( $grupo != "" ) {
													echo $grupo;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Referencia</td>
                                          <td>
										  	<?php
												$referencia = $oSubcadena->getNombreReferencia();
												if ( !preg_match('!!u', $referencia) ) {
													//no es utf-8
													$referencia = utf8_encode($referencia);
												}
												if ( $referencia != "" ) {
													echo $referencia;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Tel&eacute;fono</td>
                                          <td>
										  	<?php
												$telefono = $oSubcadena->getTel1();
												if ( !preg_match('!!u', $telefono) ) {
													//no es utf-8
													$telefono = utf8_encode($telefono);
												}
												if ( $telefono != "" ) {
													echo $telefono;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Correo</td>
                                          <td>
										  	<?php
												$correo = $oSubcadena->getCorreo();
												if ( !preg_match('!!u', $correo) ) {
													//no es utf-8
													$correo = utf8_encode($correo);
												}
												if ( $correo != "" ) {
													echo $correo;
												} else {
													echo "N/A";
												}							
                                           	?>
                                          </td>
                                          </tr>
                                           </tr>
                                          </tbody>
                                         </table>
                                      
                                      <legend> <i class="fa fa-home"></i>Direcci&oacute;n</legend>
                                   <table  class="display table table-bordered table-striped">
                                      <tbody>
                                      <tr>
                                      <td style="width:200px;">Direcci&oacute;n</td>
                                      <td><?php
											if ( $oSubcadena->getCalle() != '' && $oSubcadena->getNext() != ''
											&& $oSubcadena->getColonia() != '' && $oSubcadena->getCP() != '' && $oSubcadena->getNombreCiudad() != ''
											&& $oSubcadena->getNombreEstado() != '' && $oSubcadena->getNombrePais() != '' ) {
												if ( $oSubcadena->getCalle() != '' )
													echo (!preg_match('!!u', $oSubcadena->getCalle()))?utf8_encode($oSubcadena->getCalle()) : $oSubcadena->getCalle(); 
												if ( $oSubcadena->getCalle() != '' && $oSubcadena->getNext() != '' )    
													echo " No. ".$oSubcadena->getNext();
												if ( $oSubcadena->getCalle() != '' && $oSubcadena->getNint() != '' )
													echo " No. Int. ".$oSubcadena->getNint();
												
												echo "<br />";
												
												if ( $oSubcadena->getColonia() != '' )
													echo "Col. ".utf8_encode($oSubcadena->getNombreColonia());
												if ( $oSubcadena->getCP() != '' )
													echo " C.P. ".$oSubcadena->getCP();
												
												echo "<br />";										
												
												if ( $oSubcadena->getColonia() != '' && $oSubcadena->getNombreCiudad() != '' )
													echo utf8_encode($oSubcadena->getNombreCiudad());                                    
												if ( $oSubcadena->getNombreEstado() != '' )
													echo ", ".utf8_encode($oSubcadena->getNombreEstado());
												if ( $oSubcadena->getNombreEstado() != '' && $oSubcadena->getNombrePais() )
													echo ", ".utf8_encode($oSubcadena->getNombrePais());
											} else {
												echo "N/A";
											}								
										?></td>
                                      </tr>
                                      </tbody>
                                   </table>
                                   
                                      
                            <legend><i class="fa fa-users"></i> Contacto</legend>
                                    <table class="tablanueva">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablita">Contacto</th>
                                          <th class="theadtablita">Tel&eacute;fono</th>
                                          <th class="theadtablita">Extensi&oacute;n</th>
                                          <th class="theadtablita">Correo</th>
                                          <th class="theadtablita">Tipo de Contacto</th>
                                      </tr>
                                      </thead>
                                      <tbody class="tablapequena">
                                          <?php
                                            $sql = "CALL `prealta`.`SP_LOAD_PRESUBCADENA`({$_SESSION['idPreSubCadena']});";
                                            $ax = $sql;
                                            $res = $RBD->SP($sql);
                                            $AND = "";
                                            if ( $RBD->error() == '' ) {
                                                if ( $res != '' && mysqli_num_rows($res) > 0 ) {
                                                    $r = mysqli_fetch_array($res);
													$xml = simplexml_load_string(utf8_encode($r[0]));
                                                    /*$r = mysqli_fetch_array($res);

                                                    $reg = base64_decode($r[0]);
                                                    $xml = simplexml_load_string(utf8_encode($reg));*/
                                                    /*$r = mysqli_fetch_array($res);
                                                    $xml = simplexml_load_string($r[0]);*/
                                                    $band = false;
                                                    foreach ( $xml->Contactos->Contacto as $cont ) {
                                                        if ( $band == false && $cont != '' ) {
                                                            $AND .= " AND I.`idSubCadenaContacto` = $cont ";
                                                            $band = true;
                                                        } else if ( $band ) {
                                                            $AND .= " OR I.`idSubCadenaContacto` = $cont ";
                                                        }
                                                    }
													
                                                    if ( $AND != '' ) {
                                                        $sql = "CALL `prealta`.`SP_LOAD_CONTACTOSPDFAUTORIZACIONPRESUBCADENA`('$AND');";
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
											  echo "<td class=\"tbodyuno\"></td>";
											  echo "<td class=\"tdtablita\"></td>";
											  echo "<td class=\"tdtablita\"></td>";
											  echo "<td class=\"tdtablita\"></td>";
											  echo "<td class=\"tdtablita\"></td>";
											  echo "<td class=\"tbodydos\"></td>";									
                                            }						  
                                          ?>
                                 </tbody>
                                  </table>
                                  
                                      <legend><i class="fa fa-file"></i> Contrato</legend>
                                      <table class="display table table-bordered table-striped">
                                   <tbody>
                                    <tr>
                                          <td style="width:200px;">R&eacute;gimen</td>
                                          <td>
											<?php
                                                switch( $oSubcadena->getCRegimen() ) {
                                                    case 1:
                                                        echo "F&iacute;sica";
                                                    break;
                                                    case 2:
                                                        echo "Moral";
                                                    break;
                                                    default:
                                                        echo "N/A";
                                                    break;												
                                                }
                                            ?>                                          
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>RFC</td>
                                          <td>
										  	<?php
												$RFC = $oSubcadena->getCRfc();
												if ( !preg_match('!!u', $RFC) ) {
													//no es utf-8
													$RFC = utf8_encode($RFC);
												}
												if ( $RFC != "" ) {
													echo $RFC;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <?php if ( $oSubcadena->getCRegimen() == 2 ) { ?>
                                          <tr>
                                          <td>Raz&oacute;n Social</td>
                                          <td>
										  	<?php
												$razonSocial = $oSubcadena->getCRSocial();
												if ( !preg_match('!!u', $razonSocial) ) {
													//no es utf-8
													$razonSocial = utf8_encode($razonSocial);
												}
												if ( $razonSocial != "" ) {
													echo $razonSocial;
												} else {
													echo "N/A";
												}												
											?>
                                          </td>
                                          </tr>
                                          <?php } ?>
                                          <?php if ( $oSubcadena->getCRegimen() == 2 ) { ?>
                                          <tr>
                                          <td>Constituci&oacute;n</td>
                                          <td>
										  	<?php
												$fechaConstitucion = $oSubcadena->getCFConstitucion();
												if ( !preg_match('!!u', $fechaConstitucion) ) {
													//no es utf-8
													$fechaConstitucion = utf8_encode($fechaConstitucion);
												}
												if ( $fechaConstitucion != "" ) {
													echo (isset($fechaConstitucion) && $fechaConstitucion != "")? date("Y-m-d", strtotime($fechaConstitucion)) : '';
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <?php } ?>
                                          <tr>
                                          <td>Representante Legal</td>
                                          <td>
										  	<?php
                                            	$nombreRepLegal = $oSubcadena->getCNombre();
												$apellidoPaternoRepLegal = $oSubcadena->getCPaterno();
												$apellidoMaternoRepLegal = $oSubcadena->getCMaterno();
												if ( !preg_match('!!u', $nombreRepLegal) ) {
													//no es utf-8
													$nombreRepLegal = utf8_encode($nombreRepLegal);
												}
												if ( !preg_match('!!u', $apellidoPaternoRepLegal) ) {
													//no es utf-8
													$apellidoPaternoRepLegal = utf8_encode($apellidoPaternoRepLegal);
												}
												if ( !preg_match('!!u', $apellidoMaternoRepLegal) ) {
													//no es utf-8
													$apellidoMaternoRepLegal = utf8_encode($apellidoMaternoRepLegal);
												}
												if ( $nombreRepLegal != "" && $apellidoPaternoRepLegal != "" && $apellidoMaternoRepLegal != "" ) {
													echo $nombreRepLegal." ".$apellidoPaternoRepLegal." ".$apellidoMaternoRepLegal;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>N&uacute;mero de Identificaci&oacute;n</td>
                                          <td>
										  	<?php
												$numeroIdentificacion = $oSubcadena->getCNumIden();
												if ( !preg_match('!!u', $numeroIdentificacion) ) {
													//no es utf-8
													$numeroIdentificacion = utf8_encode($numeroIdentificacion);
												}
												if ( $numeroIdentificacion != "" ) {
													echo $numeroIdentificacion;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Tipo de Identificaci&oacute;n</td>
                                          <td>
										  	<?php
                                            	$tipoIdentificacion = $oSubcadena->getNombreCRTipoIden();
												if ( !preg_match('!!u', $tipoIdentificacion) ) {
													//no es utf-8
													$tipoIdentificacion = utf8_encode($tipoIdentificacion);
												}
												if ( $tipoIdentificacion != "" ) {
													echo $tipoIdentificacion;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <?php if ( $oSubcadena->getCRegimen() == 2 ) { ?>
                                          <tr>
                                          <td>RFC</td>
                                          <td>
										  <?php
                                          	$RFCRepLegal = $oSubcadena->getCRRfc();
											if ( !preg_match('!!u', $RFCRepLegal) ) {
												//no es utf-8
												$RFCRepLegal = utf8_encode($RFCRepLegal);
											}
											if ( $RFCRepLegal != "" ) {
												echo $RFCRepLegal;
											} else {
												echo "N/A";
											}
										  ?>
                                          </td>
                                          </tr>
                                          <?php } ?>
                                          <tr>
                                          <td>CURP</td>
                                          <td>
										  	<?php
                                            	$CURPRepLegal =  $oSubcadena->getCCurp();
												if ( !preg_match('!!u', $CURPRepLegal) ) {
													//no es utf-8
													$CURPRepLegal = utf8_encode($CURPRepLegal);
												}
												if ( $CURPRepLegal != "" ) {
													echo $CURPRepLegal;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Figura Pol&iacute;ticamente Expuesta</td>
                                          <td>
											<?php
                                				if ( $oSubcadena->getCFigura() == 0 && $oSubcadena->getCFigura() != "" ) {
                                    				echo "S&iacute;";
												} else {
													echo "No";
												}
                               	 			?>                                          
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Familia Pol&iacute;ticamente Expuesta</td>
                                          <td>
                                          	<?php
												if ( $oSubcadena->getCFamilia() == 0 && $oSubcadena->getCFamilia() != "" ) {
													echo "S&iacute;";
												} else {
													echo "No";
												}
											?>
                                          </td>
                                          </tr>
                                          </tbody>
                                         </table>
                                         
                                         <legend><i class="fa fa-shopping-cart"></i> Versi&oacute;n</legend>
                                          <table  class="display table table-bordered table-striped">
                                      <tbody>
                                      <tr>
                                      <td style="width:200px;">Versi&oacute;n</td>
                                      <td><?php
									  	$nombreVersion = $oSubcadena->getNombreVersion();
										if ( !preg_match('!!u', $nombreVersion) ) {
											$nombreVersion = utf8_encode($nombreVersion);
										}
										if ( $nombreVersion != "" ) {
											echo $nombreVersion;
										} else {
											echo "N/A";
										}
									  ?></td>
                                      </tr>
                                      </tbody>
                                   </table>
                                         
                                         
                                         <legend><i class="fa fa-credit-card"></i> Cuenta</legend>
                                         <table class="display table table-bordered table-striped">
                                   <tbody>
                                    <tr>
                                          <td style="width:200px;">CLABE</td>
                                          <td>
										  	<?php
                                            	$CLABE = $oSubcadena->getClabe();
												if ( !preg_match('!!u', $CLABE) ) {
													//no es utf-8
													$CLABE = utf8_encode($CLABE);
												}
												if ( $CLABE != "" ) {
													echo $CLABE;
												} else {
													echo "N/A";
												}
											?></td>
                                          </tr>
                                          <tr>
                                          <td>BANCO</td>
                                          <td>
										  	<?php
                                            	$banco = $oSubcadena->getNombreBanco();
												if ( !preg_match('!!u', $banco) ) {
													//no es utf-8
													$banco = utf8_encode($banco);
												}
												if ( $banco != "" ) {
													echo $banco;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>NO. CUENTA</td>
                                          <td>
										  	<?php
                                            	$numeroCuenta = $oSubcadena->getNumCuenta();
												if ( !preg_match('!!u', $numeroCuenta) ) {
													//no es utf-8
													$numeroCuenta = utf8_encode($numeroCuenta);
												}
												if ( $numeroCuenta != "" ) {
													echo $numeroCuenta;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>BENEFICIARIO</td>
                                          <td>
										  	<?php
                                            	$beneficiario = $oSubcadena->getBeneficiario();
												if ( !preg_match('!!u', $beneficiario) ) {
													//no es utf-8
													$beneficiario = utf8_encode($beneficiario);
												}
												if ( $beneficiario != "" ) {
													echo $beneficiario;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>DESCRIPCI&Oacute;N DE LA CUENTA</td>
                                          <td>
										  	<?php
                                            	$descripcion = $oSubcadena->getDescripcion();
												if ( !preg_match('!!u', $descripcion) ) {
													//no es utf-8
													$descripcion = utf8_encode($descripcion);
												}
												if ( $descripcion != "" ) {
													echo $descripcion;
												} else {
													echo "N/A";
												}
											?>
                                          </td>
                                          </tr>
                                          </tbody>
                                         </table>
                                         
                             
<!--Botones-->
<div class="col-lg-12 col-sm-12 col-xs-12">
<div class="pull-left">
<a href="#" onClick="CambioPagina(7, false);">
	<img src="../../img/atras.png"  id="atras">
</a>
</div>                               

<div class="pull-right">
<input type="hidden" id="idSubcadena" value="<?php echo $oSubcadena->getID();?>" />
<?php if ( $esEscritura && $oSubcadena->getPorcentaje() == 100 && ($idPerfil == 1 || $idPerfil == 4 || $idPerfil == 7) ) { ?>
<button type="button" class="btn btn-success" onClick="irAValidacion()">Validar</button>
<?php } ?>
</div>                               
</div>
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
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>