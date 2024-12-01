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
$subsubmenuTitulo = "Cadena";

$iddireccion = -1;

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

$idCadena = (isset($_GET['id'])) ? $_GET['id'] : -1;
if ( !isset($_SESSION['idPreCadena']) && $idCadena == -1 ) {
   header('Location: ../../index.php');//redireccionar no existe la pre-cadena
} else if ( isset($_SESSION['idPreCadena']) && $idCadena == -1 ) {
	$idCadena = $_SESSION['idPreCadena'];
}

$oCadena = new XMLPreCadena($RBD,$WBD);
$oCadena->load($idCadena);

if ( $oCadena->getExiste() ) {
	$_SESSION['idPreCadena'] = $idCadena;//si existe la pre-cadena guardamos el valor en session
} else {
	header('Location: ../../index.php');//redireccionar no existe la pre-cadena
}

$colZ = $oCadena->getColonia();
$cdZ = $oCadena->getCiudad();
$edoZ = $oCadena->getEstado();
$paisZ = $oCadena->getPais();

if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
	$tipoDireccion = "nacional";
} else {
	$tipoDireccion = "extranjera";
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
                        	<img src="../../img/2a.png" id="paso2Actual">
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
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
<div class="legend-big"><i class="fa fa-home"></i> Direcci&oacute;n</div> 
  <form class="form-horizontal" id="datos-generales">
                                     <div class="form-group">
                                          <label class="col-lg-1 control-label">*Pa&iacute;s:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtPais"
                                              onkeypress="VerificarDireccionCad(tipoDireccion, false);"
                                              onkeyup="VerificarDireccionCad(tipoDireccion, false);"
                                              value="<?php echo utf8_encode($oCadena->getNombrePais()); ?>" placeholder=""
                                              maxlength="50">
                                              <input type="hidden" id="paisID" value="<?php echo ($oCadena->getPais() > 0)? $oCadena->getPais() : ''; ?>" />
                                          </div>
                                          </div>
                                  
                                         
                                         <div class="form-group">
                                          <label class="col-lg-1 control-label">*Calle:</label>
                                          <div class="col-lg-3">
                                          	<?php
                                          		$street = (!preg_match('!!u', $oCadena->getCalle()))? utf8_encode($oCadena->getCalle()) : $oCadena->getCalle();
                                          	?>
                                              <input type="text" class="form-control" id="txtcalle"
                                              onkeypress="VerificarDireccionCad(tipoDireccion, false);"
                                              onkeyup="VerificarDireccionCad(tipoDireccion, false);"
                                              value="<?php echo $street; ?>" placeholder=""
                                              maxlength="50">
                                          </div>
                                  
                                      
                                          <label class="col-lg-1 control-label">No. Interior:</label>
                                          <div class="col-lg-3">
                                              <input type="number" class="form-control" id="txtnint"
                                              onkeypress="VerificarDireccionCad(tipoDireccion, false);"
                                              onkeyup="VerificarDireccionCad(tipoDireccion, false);"
                                              value="<?php echo $oCadena->getNint(); ?>" placeholder=""
                                              maxlength="50">
                                          </div>
                                      
                                        
                                      
                                      
                                      
                                          <label class="col-lg-1 control-label">*No. Exterior:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtnext"
                                              onkeypress="VerificarDireccionCad(tipoDireccion, false);"
                                              onkeyup="VerificarDireccionCad(tipoDireccion, false);"
                                              value="<?php echo $oCadena->getNext(); ?>" placeholder=""
                                              maxlength="50">
                                          </div>
                                          </div>
                                 
                                      
                                        <div class="form-group">
                                          <label class="col-lg-1 control-label">*C.P.:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtcp"
                                              onkeypress="VerificarDireccionCad(tipoDireccion, false);"
                                              onkeyup="buscarColonias();VerificarDireccionCad(tipoDireccion, false);"
                                              maxlength="5"
                                              value="<?php echo ( $oCadena->getCP() > 0 ) ? $oCadena->getCp() : ''; ?>" placeholder="">
                                          </div>
                                  
                                         
                                          <label class="col-lg-1 control-label">*Colonia:</label>
                                          <div class="col-lg-3">
											<?php
												$colZ = $oCadena->getColonia();
												$cdZ = $oCadena->getCiudad();
												$edoZ = $oCadena->getEstado();
												$paisZ = $oCadena->getPais();
												$cpZ = $oCadena->getCP();
												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
															class=\"form-control m-bot15\"
															onchange=\"VerificarDireccionCad(tipoDireccion, false);\"
															style=\"display:block;\">";
												} else {
													echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
															class=\"form-control m-bot15\"
															onchange=\"VerificarDireccionCad(tipoDireccion, false);\"
															style=\"display:none;\">";													
												}
												if ( $cpZ != "" && $cpZ > 0 && $tipoDireccion == "nacional" ) {
													$sql2 = "CALL `redefectiva`.`SP_BUSCARCOLONIA`($cpZ);";
													$res = $RBD->SP($sql2);
													$d = "";
													if($res != NULL){
														$d = "<option value='-2'>Seleccione una Colonia</option>";
														while ( $r = mysqli_fetch_array($res) ) {
															if ( $colZ == $r[0] )
																$d .= "<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
															else
																$d .= "<option value='$r[0]'>".utf8_encode($r[1])."</option>";	
														}
														echo $d;
													}else{
														echo "<option value='-1'>Seleccione una Colonia</option>";
													}
													echo "</select>";											
												} else {
													echo "<option value='-2'>Seleccione una Colonia</option>";
													echo "</select>";
												}																									
												if ( $tipoDireccion == "extranjera" ) {
													$sql = "CALL `prealta`.`SP_GET_COLONIA`($paisZ, $colZ);";
													$result = $RBD->SP($sql);
													if ( $RBD->error() == '' ) {
														if ( $result->num_rows > 0 ) {
															list( $nombreColoniaExtranjera ) = $result->fetch_array();
															$nombreColoniaExtranjera = utf8_encode($nombreColoniaExtranjera);
														} else {
															$nombreColoniaExtranjera = "";
														}
													}
												}
												if ( $tipoDireccion == "nacional" ) {
													echo "<input type=\"text\" style=\"display:none;\"
													class=\"form-control\"
													onkeypress=\"VerificarDireccionCad(tipoDireccion, false);\"
													onkeyup=\"VerificarDireccionCad(tipoDireccion, false);\"
													name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\"
													maxlength=\"50\" />";
												} else if( $tipoDireccion == "extranjera" ) {
													echo "<input type=\"text\" style=\"display:block;\"
													class=\"form-control\"
													onkeypress=\"VerificarDireccionCad(tipoDireccion, false);\"
													onkeyup=\"VerificarDireccionCad(tipoDireccion, false);\"
													name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\"
													maxlength=\"50\" />";													
												}
                                          	?>
                                          </div>
                                          </div>
                                          
                                          
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">*Estado:</label>
                                          <div class="col-lg-3">
											<?php
												$paisZ = $oCadena->getPais();
												$edoZ = $oCadena->getEstado();
												
												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlEstado\" id=\"ddlEstado\"
															class=\"form-control m-bot15\"
															onblur=\"VerificarDireccionCad(tipoDireccion, false);\"
															onchange=\"setValue('ddlPais',164); buscaSelectCiudad(false)\"
															style=\"display:block;\"
															disabled=\"disabled\">";																
												} else {
													echo "<select name=\"ddlEstado\" id=\"ddlEstado\"
															class=\"form-control m-bot15\"
															onblur=\"VerificarDireccionCad(tipoDireccion, false);\"
															onchange=\"setValue('ddlPais',164); buscaSelectCiudad(false)\"
															style=\"display:none;\"
															disabled=\"disabled\">";																	
												}
												
												if ( $paisZ == "" ) {
													$paisZ = 164;
												}
												$sql2 = "CALL `prealta`.`SP_LOAD_ESTADOS`(164);";
												$res = $RBD->SP($sql2);
												$d = "";
												if ( $res != NULL ) {
													$d = "<option value='-2'>Seleccione un Estado</option>";
													while ( $r = mysqli_fetch_array($res) ){ 
														if ( $edoZ == $r[0] )
															$d.="<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
														else
															$d.="<option value='$r[0]'>".utf8_encode($r[1])."</option>";   
													}
													$d.="</select>";
													echo $d;
												} else {
													echo "<option value='-2'>Seleccione un Estado (Error)</option></select>";
												}
												echo "</select>";
												
												if ( $tipoDireccion == "extranjera" ) {
													$sql = "CALL `prealta`.`SP_GET_ESTADO`($paisZ, $edoZ);";
													$result = $RBD->SP($sql);
													if ( $RBD->error() == '' ) {
														if ( $result->num_rows > 0 ) {
															list( $nombreEstadoExtranjero ) = $result->fetch_array();
															$nombreEstadoExtranjero = utf8_encode($nombreEstadoExtranjero);
														} else {
															$nombreEstadoExtranjero = "";
														}
														if ( $nombreEstadoExtranjero == -1 ) {
															$nombreEstadoExtranjero = "";
														}
													}																
												}
												if ( $tipoDireccion == "nacional" ) {
													echo "<input type=\"text\"
														class=\"form-control\"
														onkeypress=\"VerificarDireccionCad(tipoDireccion, false);\"
														onkeyup=\"VerificarDireccionCad(tipoDireccion, false);\"
														style=\"display:none;\" name=\"txtEstado\"
														id=\"txtEstado\" value=\"$nombreEstadoExtranjero\"
														maxlength=\"50\" />";																
												} else if ( $tipoDireccion == "extranjera" ) {
													echo "<input type=\"text\"
														class=\"form-control\"
														onkeypress=\"VerificarDireccionCad(tipoDireccion, false);\"
														onkeyup=\"VerificarDireccionCad(tipoDireccion, false);\"
														style=\"display:block;\" name=\"txtEstado\"
														id=\"txtEstado\" value=\"$nombreEstadoExtranjero\"
														maxlength=\"50\" />";																
												}
                                          	?>
                                          </div>
                                       
                                          
                                          
                                          <label class="col-lg-1 control-label">*Ciudad:</label>
                                          <div class="col-lg-3">
											<?php
												$cdZ = $oCadena->getCiudad();
												$edoZ = $oCadena->getEstado();
												$paisZ = $oCadena->getPais();
												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\"
													class=\"form-control m-bot15\"
													onkeypress=\"VerificarDireccionCad(tipoDireccion, false);\"
													onkeyup=\"VerificarDireccionCad(tipoDireccion, false);\"
													style=\"display:block;\"
													disabled=\"disabled\">";														
												} else if ( $tipoDireccion == "extranjera" ) {
													echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\"
													class=\"form-control m-bot15\"
													onkeypress=\"VerificarDireccionCad(tipoDireccion, false);\"
													onkeyup=\"VerificarDireccionCad(tipoDireccion, false);\"
													style=\"display:none;\"
													disabled=\"disabled\">";															
												}													
												$sql2 = "CALL `prealta`.`SP_LOAD_CIUDADES`(164, '$edoZ');";
												$res = $RBD->SP($sql2);
												$d = "";
												if ( $res != NULL ) {
													$d = "<option value='-2'>Seleccione un Cd</option>";
													while ( $r = mysqli_fetch_array($res) ) {
														if ( $cdZ == $r[0] )
															$d .= "<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
														else	
															$d .= "<option value='$r[0]'>".utf8_encode($r[1])."</option>";   
													}
													$d.="</select>";
													echo $d;
												} else {
													echo "<option value='-2'>Seleccione una Ciudad</option></select>";
												}
												echo "</select>";
												if ( $tipoDireccion == "extranjera" ) {
													$sql = "CALL `prealta`.`SP_GET_CIUDAD`($paisZ, $edoZ, $cdZ);";
													$result = $RBD->SP($sql);
													if ( $RBD->error() == '' ) {
														if ( $result->num_rows > 0 ) {
															list( $nombreCiudadExtranjera ) = $result->fetch_array();
															$nombreCiudadExtranjera = utf8_encode($nombreCiudadExtranjera);
														} else {
															$nombreCiudadExtranjera = "";
														}
														if ( $nombreCiudadExtranjera == -1 ) {
															$nombreCiudadExtranjera = "";
														}
													}														
												}
												if ( $tipoDireccion == "nacional" ) {
													echo "<input type=\"text\"
															class=\"form-control\"
															onkeypress=\"VerificarDireccionCad(tipoDireccion, false);\"
															onkeyup=\"VerificarDireccionCad(tipoDireccion, false);\"
															name=\"txtMunicipio\" id=\"txtMunicipio\"
															style=\"display:none;\"
															value=\"$nombreCiudadExtranjera\"
															maxlength=\"50\" />";	
												} else if ( $tipoDireccion == "extranjera" ) {
													echo "<input type=\"text\"
															class=\"form-control\"
															onkeypress=\"VerificarDireccionCad(tipoDireccion, false);\"
															onkeyup=\"VerificarDireccionCad(tipoDireccion, false);\"
															name=\"txtMunicipio\" id=\"txtMunicipio\"
															style=\"display:block;\"
															value=\"$nombreCiudadExtranjera\"
															maxlength=\"50\" />";															
												}
                                          	?>                                       
                                          </div>
                                      </div>
                                  </form>
                                  <br>
<div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" class="btn btn-success" id="guardarCambios" style="margin-top:10px;" disabled onclick="CrearDirPreCadena(tipoDireccion);" disabled>
	Guardar
</button> 
</div>
                                
                                            <!--Botones-->
<div class="col-lg-12 col-sm-12 col-xs-12">
<div class="pull-left">
<a href="#" onClick="CambioPagina(1, existenCambios);">
	<img src="../../img/atras.png" id="atras">
</a>
</div>                              


<div class="pull-right">
<a href="#" onClick="CambioPagina(3, existenCambios);">
	<img src="../../img/adelante.png" id="adelante">
</a>
</div>                               
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
<script src="../../inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<!--Forma Avanzada-->
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Fechas-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Tabla-->
<script src="../../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../../assets/data-tables/DT_bootstrap.js"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCadena.js" type="text/javascript"></script>
<!--Script-->
<script>
	<?php 
		$paisZ = $oCadena->getPais();
		if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
	?>
	var tipoDireccion = "nacional";
	<?php } else { ?>
	var tipoDireccion = "extranjera";
	<?php } ?>
</script>
<script>
	$(document).ready(function() {
		if ( $("#txtPais").length ) {
			$("#txtPais").autocomplete({
				source: function( request, respond ) {
					$.post( "../../inc/Ajax/_Clientes/getPaises.php", { "pais": request.term },
					function( response ) {
						respond(response);
					}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#txtPais").val(ui.item.nombre);
					return false;
				},
				select: function( event, ui ) {
					$("#paisID").val(ui.item.idPais);
					VerificarDireccionCad(tipoDireccion, false);
					cambiarPantalla();
					return false;
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a>" + item.nombre + "</a>" )
				.appendTo( ul );
			};
		}
	});
</script>