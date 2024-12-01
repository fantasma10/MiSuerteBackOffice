<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreCorresponsal.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="Corresponsal";

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);

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
<title>.::Mi Red::. Resumen Pre Alta Corresponsal</title>
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
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCorresponsal.js" type="text/javascript"></script>
<script>
	$(document).ready(
		function() {
			cargarPreContactosPreCorresponsal();
		}
	);
</script>
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
                        	<img src="../../img/h.png" id="home">
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
                                          <td style="width:160px;">Nombre</td>
                                          <td ><?php
                                          	$nombre = $oCorresponsal->getNombre();
											if ( !preg_match('!!u', $nombre) ) {
												//no es utf-8
												$nombre = utf8_encode($nombre);
											}
											if ( $nombre != "" ) {
												echo $nombre;
											} else {
										  		echo "N/A";
											}
										  ?></td>
                                          </tr>
                                          <tr>
                                          <td  >Cadena</td>
                                          <td  ><?php
										  	$nombreCadena = $oCorresponsal->getNombreCadena();
											if ( !preg_match('!!u', $nombreCadena) ) {
												//no es utf-8
												$nombreCadena = utf8_encode($nombreCadena);
											}
											if ( $nombreCadena != "" ) {
												echo $nombreCadena;
											} else {
                                          		echo "N/A";
											}
										  ?></td>
                                          </tr>
                                          <tr>
                                          <td>Sub Cadena</td>
                                          <td><?php
                                          	$nombreSubCadena = $oCorresponsal->getNombreSubCadena();
											if ( !preg_match('!!u', $nombreSubCadena) ) {
												//no es utf-8
												$nombreSubCadena = utf8_encode($nombreSubCadena);
											}
											if ( $nombreSubCadena != "" ) {
												echo $nombreSubCadena;
											} else {
												echo "N/A";
											}
										  ?></td>
                                          </tr>
                                          <tr>
                                          <td>Versi&oacute;n</td>
                                          <td><?php
                                          	$nombreVersion = $oCorresponsal->getNombreVersion();
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
                                          <tr>
                                          <td>Grupo</td>
                                          <td><?php
                                          	$nombreGrupo = $oCorresponsal->getNombreGrupo();
										  	if ( !preg_match('!!u', $nombreGrupo) ) {
												$nombreGrupo = utf8_encode($nombreGrupo);
											}
											if ( $nombreGrupo != "" ) {
												echo $nombreGrupo;
											} else {
												echo "N/A";
											}
										  ?></td>
                                          </tr>
                                          <tr>
                                          <td>Referencia</td>
                                          <td><?php
                                          	$nombreReferencia = $oCorresponsal->getNombreReferencia();
											if ( !preg_match('!!u', $nombreReferencia) ) {
												$nombreReferencia = utf8_encode($nombreReferencia);
											}
											if ( $nombreReferencia != "" ) {
												echo $nombreReferencia;
											} else {
												echo "N/A";
											}
										  	?></td>
                                          </tr>
                                          <tr>
                                          <td>Giro</td>
                                          <td><?php
                                          	$nombreGiro = $oCorresponsal->getNombreGiro();
											if ( !preg_match('!!u', $nombreGiro) ) {
												$nombreGiro = utf8_encode($oCorresponsal->getNombreGiro());
											}
											if ( $nombreGiro != "" ) {
												echo $nombreGiro;	
											} else {
												echo "N/A";
											}
										  	?></td>
                                          </tr>
                                          <tr>
                                          <td>N&uacute;mero Sucursal</td>
                                          <td><?php
                                          	$numeroSucursal = $oCorresponsal->getNumSucu();
											if ( !preg_match('!!u', $numeroSucursal) ) {
												$numeroSucursal = utf8_encode($numeroSucursal);
											}
											if ( $numeroSucursal != "" ) {
												echo $numeroSucursal;
											} else {
												echo "N/A";
											}
											?></td>
                                          </tr>
                                          <tr>
                                          <td>Nombre de Sucursal</td>
                                          <td><?php
										  	$nombreSucursal = $oCorresponsal->getNomSucu();
											if ( !preg_match('!!u', $nombreSucursal) ) {
												$nombreSucursal = utf8_encode($nombreSucursal);
											}
											if ( $nombreSucursal != "" ) {
												echo $nombreSucursal;
											} else {
												echo "N/A";
											}
											?></td>
                                          </tr>
                                           </tr>
                                           <tr>
                                          <td>Tel&eacute;fono</td>
                                          <td ><?php
                                          	$telefono = $oCorresponsal->getTel1();
											if ( !preg_match('!!u', $telefono) ) {
												$telefono = utf8_encode($telefono);
											}
											if ( $telefono != "" ) {
												echo $telefono;
											} else {
												echo "N/A";
											}
										  ?></td>
                                          </tr>
                                          <tr>
                                          <td>Correo</td>
                                          <td><?php
                                          	$correo = $oCorresponsal->getCorreo();
											if ( !preg_match('!!u', $correo) ) {
												$correo = utf8_encode($correo);
											}
											if ( $correo != "" ) {
												echo $correo;
											} else {
												echo "N/A";
											}
											?></td>
                                          </tr>
                                          <tr>
                                          <td>IVA</td>
                                          <td><?php
                                          	$nombreIVA = $oCorresponsal->getNombreIva();
											if ( !preg_match('!!u', $nombreIVA) ) {
												$nombreIVA = utf8_encode($nombreIVA);
											}
											if ( $nombreIVA != "" ) {
												echo $nombreIVA;
											} else {
												echo "N/A";
											}
											?></td>
                                          </tr>
                                          </tbody>
                                         </table>
                                      
                                        <legend><i class="fa fa-map-marker"></i> Direcci&oacute;n y Horario</legend> 
                                   <table class="display table table-bordered table-striped">
                                   <tbody>
                                    <tr>
                                          <td style="width:160px;"><i class="fa fa-home"></i> Direcci&oacute;n</td>
                                          <td>
											<?php
												if ( $oCorresponsal->getCalle() != '' && $oCorresponsal->getNext() != ''
												&& $oCorresponsal->getColonia() != '' && $oCorresponsal->getCP() != '' && $oCorresponsal->getNombreCiudad() != ''
												&& $oCorresponsal->getNombreEstado() != '' && $oCorresponsal->getNombrePais() != '' ) {
													if ( $oCorresponsal->getCalle() != '' )
														echo utf8_encode($oCorresponsal->getCalle()); 
													if ( $oCorresponsal->getCalle() != '' && $oCorresponsal->getNext() != '' )    
														echo " No. ".$oCorresponsal->getNext();
													if ( $oCorresponsal->getCalle() != '' && $oCorresponsal->getNint() != '' )
														echo " No. Int. ".$oCorresponsal->getNint();

													echo "<br />";

													if ( $oCorresponsal->getColonia() != '' )
														echo "Col. ".utf8_encode($oCorresponsal->getNombreColonia());
													if ( $oCorresponsal->getCP() != '' )
														echo " C.P. ".$oCorresponsal->getCP();
													
													echo "<br />";										
													
													if ( $oCorresponsal->getColonia() != '' && $oCorresponsal->getNombreCiudad() != '' )
														echo utf8_encode($oCorresponsal->getNombreCiudad());                                    
													if ( $oCorresponsal->getNombreEstado() != '' )
														echo ", ".utf8_encode($oCorresponsal->getNombreEstado());
													if ( $oCorresponsal->getNombreEstado() != '' && $oCorresponsal->getNombrePais() )
														echo ", ".utf8_encode($oCorresponsal->getNombrePais());
												} else {
													echo "N/A";
												}								
											?>                                          
                                          </td>
                                          </tr>
                                          <tr>
                                          <td><i class="fa fa-clock-o"></i> Horario</td>
                                          <td>
                                          
											<table class="tablereshour">
                                            	<tr>
                                          			<td>Lunes:</td><td class="hora"><?php echo $oCorresponsal->getHDe1()." ".$oCorresponsal->getHA1(); ?></td></tr>
                                          			<td>Martes:</td><td class="hora"><?php echo $oCorresponsal->getHDe2()." ".$oCorresponsal->getHA2(); ?></td></tr>
                                          			<td>Mi&eacute;rcoles:</td><td class="hora"><?php echo $oCorresponsal->getHDe3()." ".$oCorresponsal->getHA3(); ?></td></tr>
                                          			<td>Jueves:</td><td class="hora"><?php echo $oCorresponsal->getHDe4()." ".$oCorresponsal->getHA4(); ?></td></tr>
                                          			<td>Viernes:</td><td class="hora"><?php echo $oCorresponsal->getHDe5()." ".$oCorresponsal->getHA5(); ?></td></tr>
                                          			<td>S&aacute;bado:</td><td class="hora"><?php echo $oCorresponsal->getHDe6()." ".$oCorresponsal->getHA6(); ?></td></tr>
                                          			<td>Domingo:</td><td class="hora"><?php echo $oCorresponsal->getHDe7()." ".$oCorresponsal->getHA7(); ?></td>
                                          		</tr>  
                                          	</table>
                                          </td>
                                          </tr>
                                          </tbody>
                                         </table>
                                   
                                    <div class="table-responsive">  
                                    <legend><i class="fa fa-users"></i> Contactos</legend> 
                                 		<div id="tblContactosPreCorresponsal">
									
                                  		</div>
                                  </div>
                                  
                                      <legend><i class="fa fa-credit-card"></i> Cuenta</legend> 
                                         <table class="display table table-bordered table-striped">
                                   <tbody>
                                    <tr>
                                          <td  style="width:160px;">Tipo de FORELO</td>
                                          <td class="tdtablita">
                                          <?php
										  	$tipoFORELO = $oCorresponsal->getTipoFORELO();
                                          	switch ( $tipoFORELO ) {
												case 1:
													echo "Compartido";
												break;
												case 2:
													echo "Individual";
												break;
												default:
													echo "N/A";
												break;
											}
										  ?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>CLABE</td>
                                          <td>
                                          <?php
										  	if ( $tipoFORELO == 2 ) {
												$CLABE = $oCorresponsal->getClabe();
												if ( $CLABE != "" ) {
													echo $CLABE;
												} else {
													echo "N/A";
												}
											} else {
												echo "N/A";
											}
										  ?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Banco</td>
                                          <td>
                                          <?php
										  	if ( $tipoFORELO == 2 ) {
												echo $oCorresponsal->getNombreBanco();
											} else {
												echo "N/A";
											}
										  ?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>No. Cuenta</td>
                                          <td>
                                          <?php
										  	if ( $tipoFORELO == 2 ) {
												$numeroDeCuenta = $oCorresponsal->getNumCuenta();
												if ( $numeroDeCuenta ) {
													echo $numeroDeCuenta;
												} else {
													echo "N/A";
												}
											} else {
												echo "N/A";
											}
										  ?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Beneficiario</td>
                                          <td>
                                          <?php
										  	if ( $tipoFORELO == 2 ) {
												$beneficiario = $oCorresponsal->getBeneficiario();
												if ( !preg_match('!!u', $beneficiario) ) {
													//no es utf-8
													$beneficiario = utf8_encode($beneficiario);
												}
												if ( $beneficiario != "" ) {
													echo $beneficiario;	
												} else {
													echo "N/A";
												}
											} else {
												echo "N/A";
											}
										  ?>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td>Descripci&oacute;n</td>
                                          <td>
                                          <?php
										  	if ( $tipoFORELO == 2 ) {
												$descripcion = $oCorresponsal->getDescripcion();
												if ( !preg_match('!!u', $descripcion) ) {
													//no es utf-8
													$descripcion = utf8_encode($descripcion);
												}
												if ( $descripcion != "" ) {
													echo $descripcion;
												} else {
													echo "N/A";
												}											
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
		<a href="#" onClick="CambioPagina(5, false);">
			<img src="../../img/atras.png" id="atras">
		</a>
	</div>

	<div class="pull-right">
		<input type="hidden" id="idCorresponsal" value="<?php echo $oCorresponsal->getID();?>" />
		<?php if ( $esEscritura && $oCorresponsal->getPorcentaje() == 100 && ($idPerfil == 1 || $idPerfil == 4 || $idPerfil == 7) ) { ?>
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