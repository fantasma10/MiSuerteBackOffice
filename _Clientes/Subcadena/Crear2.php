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

$paisZ = $oSubcadena->getPais();

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
<link rel="stylesheet" href="../../css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />
<style>
	.ui-autocomplete {
		max-height: 190px;
		overflow-y: auto;
		overflow-x: hidden;
		font-size: 12px;
	}	
</style>
<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<!--Tabla-->
<script src="../../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../../assets/data-tables/DT_bootstrap.js"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreSubCadena.js" type="text/javascript"></script>
<!--Script-->
<script>
	<?php 
		$paisZ = $oSubcadena->getPais();
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
					VerificarDireccionSub(tipoDireccion);
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
<!--Cierre del Sitio-->
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
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
<div class="legend-big"><i class="fa fa-home"></i> Dirección</div>
  <form class="form-horizontal" id="datos-generales">
                                     <div class="form-group">
                                          <label class="col-lg-1 control-label">*Pa&iacute;s:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtPais"
                                              value="<?php echo utf8_encode($oSubcadena->getNombrePais()); ?>"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              onkeyup="VerificarDireccionSub(tipoDireccion);"
                                              placeholder="" maxlength="50">
                                              <input type="hidden" id="paisID" value="<?php echo ($oSubcadena->getPais() > 0)? $oSubcadena->getPais() : ''; ?>" />
                                          </div>
                                          </div>
                                         
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">*Calle:</label>
                                          <div class="col-lg-3">
                                              <?php
                                          		$street = (!preg_match('!!u', $oSubcadena->getCalle()))? utf8_encode($oSubcadena->getCalle()) : $oSubcadena->getCalle();
                                          		?>
                                              <input type="text" class="form-control" id="txtcalle"
                                              value="<?php echo $street; ?>"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              onkeyup="VerificarDireccionSub(tipoDireccion);"
                                              placeholder="" maxlength="50">
                                          </div>
                                  
                                      
                                          <label class="col-lg-1 control-label">No. Interior:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtnint"
                                              value="<?php echo $oSubcadena->getNint(); ?>"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              onkeyup="VerificarDireccionSub(tipoDireccion);"
                                              placeholder="" maxlength="50">
                                          </div>
                                      
                                     
                                          <label class="col-lg-1 control-label">*No. Exterior:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtnext"
                                              value="<?php echo $oSubcadena->getNext(); ?>"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              onkeyup="VerificarDireccionSub(tipoDireccion);"
                                              placeholder="" maxlength="50">
                                          </div>
                                          </div>
                                 
                                      
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">*C.P:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtcp"
                                              onkeyup="buscarColonias();VerificarDireccionSub(tipoDireccion);" maxlength="5"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              value="<?php echo $oSubcadena->getCP(); ?>"
                                              placeholder="">
                                          </div>
                                  
                                         
                                          <label class="col-lg-1 control-label">*Colonia:</label>
                                          <div class="col-lg-3">
											<?php
												$colZ = $oSubcadena->getColonia();
												$cdZ = $oSubcadena->getCiudad();
												$edoZ = $oSubcadena->getEstado();
												$paisZ = $oSubcadena->getPais();
												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
															class=\"form-control m-bot15\"
															onchange=\"VerificarDireccionSub(tipoDireccion, false);\"
															style=\"display:block;\">";
												} else {
													echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
															class=\"form-control m-bot15\"
															onchange=\"VerificarDireccionSub(tipoDireccion, false);\"
															style=\"display:none;\">";													
												}
												$sql2 = "CALL `prealta`.`SP_LOAD_COLONIAS`(164, '$edoZ', '$cdZ');";
												$res = $RBD->SP($sql2);
												$d = "";
												if($res != NULL){
													$d = "<option value='-2'>Seleccione una Colonia</option>";
													while ( $r = mysqli_fetch_array($res) ) {
														if ( $colZ == $r[0] )
															$d .= "<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
													}
													echo $d;
												}else{
													echo "<option value='-1'>Seleccione una Colonia</option>";
												}
												echo "</select>";																									
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
													onkeyup=\"VerificarDireccionSub(tipoDireccion, false);\"
													onkeypress=\"VerificarDireccionSub(tipoDireccion, false);\"
													name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\"
													maxlength=\"50\" />";
												} else if( $tipoDireccion == "extranjera" ) {
													echo "<input type=\"text\" style=\"display:block;\"
													class=\"form-control\"
													onkeyup=\"VerificarDireccionSub(tipoDireccion, false);\"
													onkeypress=\"VerificarDireccionSub(tipoDireccion, false);\"
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
												$paisZ = $oSubcadena->getPais();
												$edoZ = $oSubcadena->getEstado();
												
												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlEstado\" id=\"ddlEstado\"
															class=\"form-control m-bot15\"
															onblur=\"VerificarDireccionSub(tipoDireccion, false);\"
															onchange=\"setValue('ddlPais',164); buscaSelectCiudad(false)\"
															style=\"display:block;\"
															disabled=\"disabled\">";																
												} else {
													echo "<select name=\"ddlEstado\" id=\"ddlEstado\"
															class=\"form-control m-bot15\"
															onblur=\"VerificarDireccionSub(tipoDireccion, false);\"
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
													}																
												}
												if ( $tipoDireccion == "nacional" ) {
													echo "<input type=\"text\"
														class=\"form-control\"
														onkeyup=\"VerificarDireccionSub(tipoDireccion, false);\"
														onkeypress=\"VerificarDireccionSub(tipoDireccion, false);\"
														style=\"display:none;\" name=\"txtEstado\"
														id=\"txtEstado\" value=\"$nombreEstadoExtranjero\"
														maxlength=\"50\" />";																
												} else if ( $tipoDireccion == "extranjera" ) {
													echo "<input type=\"text\"
														class=\"form-control\"
														onkeyup=\"VerificarDireccionSub(tipoDireccion, false);\"
														onkeypress=\"VerificarDireccionSub(tipoDireccion, false);\"
														style=\"display:block;\" name=\"txtEstado\"
														id=\"txtEstado\" value=\"$nombreEstadoExtranjero\"
														maxlength=\"50\" />";																
												}
                                          	?>
                                          </div>
                                       
                                          
                                          
                                          <label class="col-lg-1 control-label">*Ciudad:</label>
                                          <div class="col-lg-3">
											<?php
												$cdZ = $oSubcadena->getCiudad();
												$edoZ = $oSubcadena->getEstado();
												$paisZ = $oSubcadena->getPais();
												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\"
													class=\"form-control m-bot15\"
													onblur=\"VerificarDireccionSub(tipoDireccion, false);\"
													style=\"display:block;\"
													disabled=\"disabled\">";														
												} else if ( $tipoDireccion == "extranjera" ) {
													echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\"
													class=\"form-control m-bot15\"
													onblur=\"VerificarDireccionSub(tipoDireccion, false);\"
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
													}														
												}
												if ( $tipoDireccion == "nacional" ) {
													echo "<input type=\"text\"
															class=\"form-control\"
															onkeyup=\"VerificarDireccionSub(tipoDireccion, false);\"
															onkeypress=\"VerificarDireccionSub(tipoDireccion, false);\"
															name=\"txtMunicipio\" id=\"txtMunicipio\"
															style=\"display:none;\"
															value=\"$nombreCiudadExtranjera\"
															maxlength=\"50\" />";	
												} else if ( $tipoDireccion == "extranjera" ) {
													echo "<input type=\"text\"
															class=\"form-control\"
															onkeyup=\"VerificarDireccionSub(tipoDireccion, false);\"
															onkeypress=\"VerificarDireccionSub(tipoDireccion, false);\"
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
                                  <!--Botón-->
                                  
                                    <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" class="btn btn-success" id="guardarCambios"
onclick="CrearDirPreSubCadena(tipoDireccion)"
style="margin-top:10px;" disabled>
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
<!--Cierre-->
</div>
</div>
</section>
</section>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Forma Avanzada-->
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Fechas-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>                        
</body>
</html>