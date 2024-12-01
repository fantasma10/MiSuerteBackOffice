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

if ( $oSubcadena->getExiste() ) {
    $_SESSION['idPreSubCadena'] = $idSubCadena;//si existe la pre-cadena guardamos el valor en session
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
<title>.::Mi Red::. Pre Alta de SubCadena</title>
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
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/RE.js"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js"></script>
<script src="../../inc/js/_PrealtaPreSubCadena.js"></script>
<!--Cierre del Sitio-->
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
                        	<img src="../../img/5a.png" id="paso5Actual">
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
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
                            <div class="legend-big"> <i class="fa fa-shopping-cart"></i> Versi&oacute;n</div>                                   
                                      <?php
									  	$cadenaID = $oSubcadena->getIdCadena();
										$versionDeSubCadena = $oSubcadena->getVersion();
										$idGrupo = $oSubcadena->getIdGrupo();
										if ( isset($cadenaID) && $cadenaID != "" ) {										
											$sql = "CALL `redefectiva`.`SP_GET_VERSIONES`($cadenaID);";
											$result = $RBD->SP($sql);
											if ( $RBD->error() == '' ) {
												if ( mysqli_num_rows($result) > 0 ) {
													echo "<table class=\"display table table-bordered table-striped\">";
													echo "<tbody>";
													echo "<tr>";
													$totalFamilias = 0;
													while ( $field = mysqli_fetch_field($result) ) {
														if ( $field->name != "idVersion" && $field->name != "idCadena" ) {
															echo "<td>$field->name</td>";
															if ( $field->name != "Version" && $field->name != "idCadena" ) {
																$totalFamilias++;
															}
														}
													}
													$versiones = array();
													while ( $row = mysqli_fetch_array($result, MYSQLI_NUM) ) {
														$versiones[] = $row;
													}
													for ( $i = 0; $i < count($versiones); $i++ ) {
														$idVersion = $versiones[$i][0];
														if ( isset($versionDeSubCadena) && $versionDeSubCadena != "" && $versionDeSubCadena == $versiones[$i][0] ) {
															echo "<tr>";
															echo "<td>";															
															echo "<input type=\"radio\" checked=\"checked\" name=\"version\" id=\"rdbVersion-$idVersion\" value=\"$idVersion\">";
															echo "&nbsp;";
															echo $versiones[$i][1];
															echo "</td>";
														} else {
															echo "<tr>";
															echo "<td>";
															echo "<input type=\"radio\" name=\"version\" id=\"rdbVersion-$idVersion\" value=\"$idVersion\">";
															echo "&nbsp;";
															echo $versiones[$i][1];
															echo "</td>";
														}
														for ( $j = 2; $j < count($versiones[0]); $j++ ) {
															$esEspecial = false;
															$piezas = explode(" ", $versiones[$i][$j]);
															$idFamilia = $piezas[0];
															if ( $piezas[1] == "E" ) {
																$esEspecial = true;
															}
															switch ( $idFamilia ) {
																case 1:
																	echo "<td style=\"text-align: center;\"><img src=\"../../img/telefonia.png\">";
																	if ( $esEspecial ) {
																		echo "<span style=\"color: red;\">&nbsp;*G</span>";
																	}
																	echo "</td>";
																break;
																case 2:
																	echo "<td style=\"text-align: center;\"><img src=\"../../img/servicios.png\">";
																	if ( $esEspecial ) {
																		echo "<span style=\"color: red;\">&nbsp;*G</span>";
																	}
																	echo "</td>";																		
																break;
																case 3:
																	echo "<td style=\"text-align: center;\"><img src=\"../../img/banco.png\">";
																	if ( $esEspecial ) {
																		echo "<span style=\"color: red;\">&nbsp;*G</span>";
																	}
																	echo "</td>";																		
																break;
																case 4:
																	echo "<td style=\"text-align: center;\"><img src=\"../../img/transporte.png\">";
																	if ( $esEspecial ) {
																		echo "<span style=\"color: red;\">&nbsp;*G</span>";
																	}
																	echo "</td>";																		
																break;
																case 5:
																	echo "<td style=\"text-align: center;\"><img src=\"../../img/remesas.png\">";
																	if ( $esEspecial ) {
																		echo "<span style=\"color: red;\">&nbsp;*G</span>";
																	}
																	echo "</td>";																		
																break;
																case 6:
																	echo "<td style=\"text-align: center;\"><img src=\"../../img/seguros.png\">";
																	if ( $esEspecial ) {
																		echo "<span style=\"color: red;\">&nbsp;*G</span>";
																	}
																	echo "</td>";																		
																break;
																case 7:
																	echo "<td style=\"text-align: center;\"><img src=\"../../img/juegos.png\">";
																	if ( $esEspecial ) {
																		echo "<span style=\"color: red;\">&nbsp;*G</span>";
																	}
																	echo "</td>";																		
																break;
																default:
																	echo "<td></td>";
																break;
															}
														}
														echo "</tr>";
													}
												}
											}		
											echo "</tbody>";
											echo "</table>";
										} else {
											echo "Para poder seleccionar una versi&oacute;n primero es necesario seleccionar una Cadena.";
										}
									  ?>
                                      
                                      
                                      <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" class="btn btn-success" style="margin-top:10px;"
onclick="EditarVersionPreSubCadena()" id="guardarCambios" disabled
<?php
	/*if ( isset($versionDeSubCadena) && $versionDeSubCadena != "" ) {
		echo "disabled";
	}*/
?>>
	Guardar
</button>
</div>
                                      
                                      
<div class="col-lg-12 col-sm-12 col-xs-12">
<div class="pull-left">
<a href="#" onClick="CambioPagina(4, existenCambios);">
	<img src="../../img/atras.png" width="30" height="30" id="atras">
</a>
</div>                              



<div class="pull-right">
<a href="#" onClick="CambioPagina(6, existenCambios);">
	<img src="../../img/adelante.png" width="30" height="30" id="adelante">
</a>
</div>                               
</div>
<!--Cierre Botones-->                                 
                                    
<!--Cierre Botones-->
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
<script src="../../inc/js/bootstrap.min.js"></script>
<script src="../../inc/js/common-scripts.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../inc/js/respond.min.js" ></script>                          
</body>
</html>