<?php
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreCadena.php");

$idOpcion = 2;
$tipoDePagina = "Escritura";
$idPerfil = $_SESSION['idPerfil'];

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( $idPerfil != 1 && $idPerfil != 4 && $idPerfil != 7 ) {
	header("Location: ../../../error.php");
	exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="Cadena";
if ( !isset($_SESSION['rec']) )
    $_SESSION['rec'] = true;

$idCadena = (isset($_GET['id'])) ? $_GET['id'] : -1;

if ( $idCadena == -1 ) {
    header('Location: ../../index.php');//redireccionar no existe la pre-cadena
} else {
    $oCadena = new XMLPreCadena($RBD,$WBD);
    $oCadena->load($idCadena);
    if ( $oCadena->getExiste() ) {
        $_SESSION['idPreCadena'] = $idCadena;
    } else {
        header('Location: ../../index.php');//redireccionar no existe la pre-cadena
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
<title>.::Mi Red::.Validación de Cadena</title>
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
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCadena.js" type="text/javascript"></script>
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
<!--Contenido Principal del Sitio-->

<section id="main-content">
<section class="wrapper site-min-height">
<div class="row">
<div class="col-lg-12">


<!--Panel Principal-->

<div class="panelrgb">
<div class="panel">
<div class="titulorgb-prealta"><span>
                                  <i class="fa fa-check-square"></i>
                              </span>
                              <h3><?php
								$nombre = $oCadena->getNombre();
								if ( !preg_match('!!u', $nombre) ) {
									echo $oCadena->getNombre();
								}
								echo $nombre;                              
							  ?></h3>
                              <span class="rev-combo pull-right">
                                 Validaci&oacute;n<br> de Cadena
                              </span>
                          </div>
                          
<div class="panel-body">
<!--Panel-->
<button class="btn btnrevision " type="button" onClick="irABusqueda()">Nueva B&uacute;squeda <i class="fa fa-search"></i></button>
<div class="room-desk">
<!--Panel-->
<div class="row mini">
<div class="col-lg-3 col-sm-4 col-xs-8">
<div class="minipanel">
<div class="icono orange">
<i class="fa fa-3x fa-exclamation-circle"></i>
</div>
<div class="linea">
Estatus
</div>
<div class="dato">
Validado
</div>
</div>
</div>
</div>
<br>
<!--Auto Room-->
<div class="room-auto">
<h5 class="text-primary"><i class="fa fa-dollar"></i> Afiliación y Cuotas</h5>
<!--Inicio de la Tabla de Cuotas-->
<table class="tablarevision-hc">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Concepto</th>
                                          <th class="theadtablita">Importe</th>
                                          <th class="theadtablita">Fecha de Inicio</th>
                                          <th class="theadtablita">Observaciones</th>
                                          <th class="theadtablita">Configuraci&oacute;n</th>
                                      </tr>
                                      </thead>
                                      <tbody class="tablapequena">                                     
                                      <?php
									  	$oPreCargo = new PreCargo($LOG, $WBD, $RBD, NULL, NULL, $idCadena, -1, -1, 0, NULL, "", "", 0, "", 0, 0, $_SESSION['idU']);
										$preCargos = $oPreCargo->cargarTodos();
										if ( count($preCargos) > 0 ) {
											foreach ( $preCargos as $preCargo ) {
												echo "<tr>";
												if ( !preg_match('!!u', $preCargo['nombreConcepto']) ) {
													$preCargo['nombreConcepto'] = utf8_encode($preCargo['nombreConcepto']);
												}
												if ( !preg_match('!!u', $preCargo['observaciones']) ) {
													$preCargo['observaciones'] = utf8_encode($preCargo['observaciones']);
												}
												echo "<td class=\"tdtablita-o\">{$preCargo['nombreConcepto']}<input type=\"hidden\" id=\"nombreConcepto-{$preCargo['idConf']}\" value=\"{$preCargo['idConcepto']}\" /></td>";
												echo "<td class=\"tdtablita-o\" style=\"text-align:right;\">$".number_format($preCargo['importe'], 2, '.', ',')."<input type=\"hidden\" id=\"importe-{$preCargo['idConf']}\" value=\"{$preCargo['importe']}\" /></td>";
												echo "<td class=\"tdtablita-o\">{$preCargo['fechaInicio']}<input type=\"hidden\" id=\"fechaInicio-{$preCargo['idConf']}\" value=\"{$preCargo['fechaInicio']}\" /></td>";
												echo "<td class=\"tdtablita-o\">{$preCargo['observaciones']}<input type=\"hidden\" id=\"observaciones-{$preCargo['idConf']}\" value=\"{$preCargo['observaciones']}\" /></td>";
												switch ( $preCargo["Configuracion"] ) {
													case 0:
														echo "<td class=\"tdtablita-o\">Compartida<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
													break;
													case 1:
														echo "<td class=\"tdtablita-o\">Individual<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
													break;
													default:
														echo "<td class=\"tdtablita-o\">Compartida<input type=\"hidden\" id=\"configuracion-{$preCargo['idConf']}\" value=\"{$preCargo['Configuracion']}\" /></td>";
													break;
												}
												echo "</tr>";
											}										
										} else {
											echo "<tr>";
											echo "<td class=\"tdtablita-o\"></td>";
											echo "<td class=\"tdtablita-o\"></td>";
											echo "<td class=\"tdtablita-o\"></td>";
											echo "<td class=\"tdtablita-o\"></td>";
											echo "<td class=\"tdtablita-o\"></td>";
											echo "</tr>";
										}
									  ?>
                                      </tbody>
                                      </table>
<!--Fin de la Tabla-->
</div>
<div class="room-auto">
<h5 class="text-primary"><i class="fa fa-book"></i> Datos Generales</h5>


<table class="tablaauto">
<tr>
<td>Grupo</td><td>Referencia</td></tr>
<tr>
<td class="dato"><?php
$nombreGrupo = $oCadena->getNombreGrupo();
if ( !preg_match('!!u', $nombreGrupo) ) {
	$nombreGrupo = utf8_encode($nombreGrupo);
}
echo $nombreGrupo;
?></td><td class="dato"><?php
$nombreReferencia = $oCadena->getNombreReferencia();
if ( !preg_match('!!u', $nombreReferencia) ) {
	$nombreReferencia = utf8_encode($nombreReferencia);
}
echo $nombreReferencia;
?></td></tr>
<tr>
<td>Tel&eacute;fono</td><td>Correo</td></tr>
<tr>
<td class="dato"><?php
$telefono = $oCadena->getTel1();
if ( !preg_match('!!u', $telefono) ) {
	$telefono = utf8_encode($telefono);
}
echo $telefono;
?></td><td class="dato"><?php
$correo = $oCadena->getCorreo();
if ( !preg_match('!!u', $correo) ) {
	$correo = utf8_encode($correo);
}
echo $correo;
?></td></tr>
</table>
</div>




                             
<div class="room-auto">
<h5 class="text-primary"><i class="fa fa-home"></i> Direcci&oacute;n</h5>
<table class="tablaauto">
<tr>
<td> Direcci&oacute;n</td></tr>
<tr>
<td class="dato">
<?php
	if ( $oCadena->getCalle() != '' && $oCadena->getNext() != ''
	&& $oCadena->getColonia() != '' && $oCadena->getCP() != '' && $oCadena->getNombreCiudad() != ''
	&& $oCadena->getNombreEstado() != '' && $oCadena->getNombrePais() != '' ) {
		if ( $oCadena->getCalle() != '' )
			echo (!preg_match('!!u', $oCadena->getCalle()))?utf8_encode($oCadena->getCalle()) : $oCadena->getCalle(); 
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
</td></tr>
</table>    
</div>




<div class="room-auto">
  <h5 class="text-primary"><i class="fa fa-users"></i> Contactos</h5>
  
 <table class="tablarevision-hc" style="margin-bottom:22px;">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Contacto</th>
                                          <th class="theadtablita">Tel&eacute;fono</th>
                                          <th class="theadtablita">Extensi&oacute;n</th>
                                          <th class="theadtablita">Correo</th>
                                          <th class="theadtablita">Tipo de Contacto</th>
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
                                      </table><br>
</div>


<!--jdh-->

<div class="room-auto">
  <h5 class="text-primary"><i class="fa fa-briefcase"></i> Ejecutivos</h5>
  
<table class="tablaauto">
<tr>
<td>Ejecutivo de Cuenta</td><td>Ejecutivo de Ventas</td></tr>
<tr>
<td class="dato"><?php
$nombreECuenta = $oCadena->getNombreECuenta();
if ( !preg_match('!!u', $nombreECuenta) ) {
	$nombreECuenta = utf8_encode($nombreECuenta);
}
echo $nombreECuenta;
?></td><td class="dato"><?php
$nombreEVenta = $oCadena->getNombreEVenta();
if ( !preg_match('!!u', $nombreEVenta) ) {
	$nombreEVenta = utf8_encode($nombreEVenta);
}
echo $nombreEVenta;
?></td></tr>
</table>
</div>
</div>
<!--Final de Ejecutivo-->
<div id="container" style="display:none;">
</div>
<div class="prealta-footer">
<?php if($idPerfil == 1 || $idPerfil == 4) { ?>
<button class="btn btn-default" type="button" onClick="irAAutorizarCadena(<?php echo $idCadena; ?>)"><i class="fa fa-mail-forward"></i> Ir a Autorizaci&oacute;n</button>
<?php } ?>
</div>


<!--Inicia Modal-->
<div class="modal fade" id="Domicilio" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-revision">
<span><i class="fa fa-check-square"></i></span>
<h3>Nombre de Corresponsal</h3>
<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
</div>
<div class="modal-body">
<legend> <i class="fa fa-folder-open-o"></i> Comprobante de Domicilio</legend>

<img src="img/dummyimage.jpg" width="60%" height="60%">
                                     </div>
                                 <div class="modal-footer">
                                              <button class="btn btn-success" type="button">Editar <i class="fa fa-edit"></i></button>
                                          </div>
</div>
</div>
</div>
</div>
<!--Cierre Modal-->



</div>
</div>
</div> 
</div>
</div>
</section>
</section>



<!--*.JS Generales-->
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>