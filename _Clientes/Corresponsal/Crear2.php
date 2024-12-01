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
<link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css" />
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

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
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCorresponsal.js" type="text/javascript"></script>
<script>
	<?php
		$paisZ = $oCorresponsal->getPais();
		if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
	?>
			var tipoDireccion = "nacional";
	<?php
		}
	 	else{
	?>
			var tipoDireccion = "extranjera";
	<?php
		}
	?>

	function DisableCP(){
		if ( document.getElementById("ddlPais").value == 164 ) {
			document.getElementById("txtcp").value = "";
			document.getElementById("txtcp").disabled = true;
		}
		else {
			document.getElementById("txtcp").value = "";
			document.getElementById("txtcp").disabled = false;
		}
	}
</script>

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
													value="<?php echo utf8_encode($oCorresponsal->getNombrePais()); ?>" placeholder=""
													maxlength="50" placeholder="">
													<input type="hidden" id="paisID" value="<?php echo ($oCorresponsal->getPais() > 0)? $oCorresponsal->getPais() : ''; ?>" />
													<?php
														$paisZ = $oCorresponsal->getPais();
														if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
															$tipoDireccion = "nacional";
														} else {
															$tipoDireccion = "extranjera";
														}
													?>
											</div>
										</div>
																				 
										<div class="form-group">
											<label class="col-lg-1 control-label">*Calle:</label>
											<div class="col-lg-3">
													<?php
	                                          			$street = (!preg_match('!!u', $oCorresponsal->getCalle()))? utf8_encode($oCorresponsal->getCalle()) : $oCorresponsal->getCalle();
	                                          		?>
													<input type="text" name="txtcalle" id="txtcalle" class="form-control" placeholder=""
														onblur="VerificarDireccionCad(tipoDireccion);"  value="<?php echo $street; ?>" />
											</div>


											<label class="col-lg-1 control-label">No. Interior:</label>
											<div class="col-lg-3">
													<input type="text" name="txtnint" id="txtnint"
											      onblur="VerificarDireccionCad(tipoDireccion);"
											      value="<?php echo $oCorresponsal->getNint(); ?>"
											      class="form-control" placeholder=""/>
											</div>

											<label class="col-lg-1 control-label">*No. Exterior:</label>
											<div class="col-lg-3">
												<input type="text" name="txtnext" id="txtnext"
												onblur="VerificarDireccionCad(tipoDireccion);"  value="<?php echo $oCorresponsal->getNext(); ?>"
												class="form-control" placeholder=""/>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-1 control-label">*C.P:</label>
											<div class="col-lg-3">
													<input type="text" name="txtcp"
													id="txtcp" maxlength="5"
													onblur="VerificarDireccionCad(tipoDireccion);"
													onkeyup="buscarColonias()" value="<?php echo $oCorresponsal->getCP(); ?>"
													class="form-control" placeholder=""/>
											</div>

										 
											<label class="col-lg-1 control-label">*Colonia:</label>
											<div class="col-lg-3">
												<div id="divCol">
													<?php
														$colZ = $oCorresponsal->getColonia();
														$cdZ = $oCorresponsal->getCiudad();
														$edoZ = $oCorresponsal->getEstado();
														$paisZ = $oCorresponsal->getPais();
														if($tipoDireccion == "nacional"){
															echo "<select name=\"ddlColonia\" id=\"ddlColonia\" class=\"form-control m-bot15\"
															onchange=\"VerificarDireccionCad(tipoDireccion);\"
															style=\"display:block;\">";
														}
														else{
															echo "<select name=\"ddlColonia\" id=\"ddlColonia\" class=\"form-control m-bot15\"
															onchange=\"VerificarDireccionCad(tipoDireccion);\"
															style=\"display:none;\">";													
														}

														$sql2 = "CALL `prealta`.`SP_LOAD_COLONIAS`(164, '$edoZ', '$cdZ');";
														$res = $RBD->SP($sql2);
														$d = "";
														
														if($res != NULL){
															$d = "<option value='-2'>Seleccione una Colonia</option>";
															while($r = mysqli_fetch_array($res)){
																if($colZ == $r[0])
																	$d.="<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
															}
															echo $d;
														}
														else{
															echo "<option value='-1'>Seleccione una Colonia</option>";
														}

														echo "</select>";																									
														if ( $tipoDireccion == "extranjera" ) {
															$sql = "CALL `prealta`.`SP_GET_COLONIA`($paisZ, $colZ);";
															$result = $RBD->SP($sql);
															if ( $RBD->error() == '' ) {
																if ( $result->num_rows > 0 ) {
																	list( $nombreColoniaExtranjera ) = $result->fetch_array();
																}
																else {
																	$nombreColoniaExtranjera = "";
																}
															}
														}
														
														if ( $tipoDireccion == "nacional" ) {
															echo "<input type=\"text\" style=\"display:none;\" class=\"form-control\" placeholder=\"\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\"
															name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\" />";
														}
														else if( $tipoDireccion == "extranjera" ) {
															echo "<input type=\"text\" style=\"display:block;\" class=\"form-control\" placeholder=\"\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\"
															name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\" />";													
														}
													?>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-1 control-label">*Estado:</label>
											<div class="col-lg-3">
												<div id="divEdo">
													<?php
														$paisZ = $oCorresponsal->getPais();
														$edoZ = $oCorresponsal->getEstado();

														if($tipoDireccion == "nacional"){
															echo "<select name=\"ddlEstado\" id=\"ddlEstado\" class=\"form-control m-bot15\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\"
															onchange=\"setValue('ddlPais',164); buscaSelectCiudad(false)\"
															style=\"display:block;\"
															disabled=\"disabled\">";																
														}
														else{
															echo "<select name=\"ddlEstado\" id=\"ddlEstado\" class=\"form-control m-bot15\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\"
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
																if ( $edoZ == $r[0] ){
																	$d.="<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
																}
																else{
																	$d.="<option value='$r[0]'>".utf8_encode($r[1])."</option>";   
																}
															}
															
															$d.="</select>";
															echo $d;
														}
														else {
															echo "<option value='-2'>Seleccione un Estado (Error)</option></select>";
														}
														echo "</select>";

														if ( $tipoDireccion == "extranjera" ) {
															$sql = "CALL `prealta`.`SP_GET_ESTADO`($paisZ, $edoZ);";
															$result = $RBD->SP($sql);
															if ( $RBD->error() == '' ) {
																if ( $result->num_rows > 0 ) {
																	list( $nombreEstadoExtranjero ) = $result->fetch_array();
																}
																else {
																	$nombreEstadoExtranjero = "";
																}
															}
														}

														if ( $tipoDireccion == "nacional" ) {
															echo "<input type=\"text\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\" class=\"form-control\"
															style=\"display:none;\" name=\"txtEstado\"
															id=\"txtEstado\" value=\"$nombreEstadoExtranjero\" />";																
														}
														else if ( $tipoDireccion == "extranjera" ) {
															echo "<input type=\"text\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\" class=\"form-control\"
															style=\"display:block;\" name=\"txtEstado\"
															id=\"txtEstado\" value=\"$nombreEstadoExtranjero\" />";																
														}
													?>
												</div>
											</div>

											<label class="col-lg-1 control-label">*Ciudad:</label>
											<div class="col-lg-3">
												<div id="divCd">
													<?php
														$cdZ		= $oCorresponsal->getCiudad();
														$edoZ		= $oCorresponsal->getEstado();
														$paisZ	= $oCorresponsal->getPais();
														
														if ( $tipoDireccion == "nacional" ) {
															echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\" class=\"form-control m-bot15\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\"
															style=\"display:block;\"
															disabled=\"disabled\">";														
														}
														else if ( $tipoDireccion == "extranjera" ) {
															echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\" class=\"form-control m-bot15\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\"
															style=\"display:none;\"
															disabled=\"disabled\">";															
														}													
														$sql2 = "CALL `prealta`.`SP_LOAD_CIUDADES`(164, '$edoZ');";
														$res = $RBD->SP($sql2);
														$d = "";
														if ( $res != NULL ) {
															$d = "<option value='-2'>Seleccione un Cd</option>";
														
															while ($r = mysqli_fetch_array($res) ) {
																if ( $cdZ == $r[0] )
																	$d.="<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
																else	
																	$d.="<option value='$r[0]'	>".utf8_encode($r[1])."</option>";   
															}
														
															$d.="</select>";
															echo $d;
														}
														else {
															echo "<option value='-2'>Seleccione una Ciudad</option></select>";
														}
														echo "</select>";
														
														if ( $tipoDireccion == "extranjera" ) {
															$sql = "CALL `prealta`.`SP_GET_CIUDAD`($paisZ, $edoZ, $cdZ);";
															$result = $RBD->SP($sql);
															if ( $RBD->error() == '' ) {
																if ( $result->num_rows > 0 ) {
																	list( $nombreCiudadExtranjera ) = $result->fetch_array();
																}
																else {
																	$nombreCiudadExtranjera = "";
																}
															}														
														}

														if ( $tipoDireccion == "nacional" ) {
															echo "<input type=\"text\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\" class=\"form-control\"
															name=\"txtMunicipio\" id=\"txtMunicipio\"
															style=\"display:none;\"
															value=\"$nombreCiudadExtranjera\" />";	
														}
														else if ( $tipoDireccion == "extranjera" ) {
															echo "<input type=\"text\"
															onblur=\"VerificarDireccionCad(tipoDireccion);\" class=\"form-control\"
															name=\"txtMunicipio\" id=\"txtMunicipio\"
															style=\"display:block;\"
															value=\"$nombreCiudadExtranjera\" />";															
														}
													?>
												</div>
											</div>
										</div>
									</form>

									<div class="legend-big"><i class="fa fa-clock-o"></i> Horario</div> 
										<div>
											<?php
												$DE1	= $oCorresponsal->HDE1;
												$A1	= $oCorresponsal->HA1;
												$DE2	= $oCorresponsal->HDE2;
												$A2	= $oCorresponsal->HA2;
												$DE3	= $oCorresponsal->HDE3;
												$A3	= $oCorresponsal->HA3;
												$DE4	= $oCorresponsal->HDE4;
												$A4	= $oCorresponsal->HA4;
												$DE5	= $oCorresponsal->HDE5;
												$A5	= $oCorresponsal->HA5;
												$DE6	= $oCorresponsal->HDE6;
												$A6	= $oCorresponsal->HA6;
												$DE7	= $oCorresponsal->HDE7;
												$A7	= $oCorresponsal->HA7;
											?>
											<table  class="table table-bordered tabla-horario">
												<tbody>
													<tr align="center">
														<td><span>Lunes</span></td>
														<td><span>Martes</span></td>
														<td><span>Mi&eacute;rcoles</span></td>
														<td><span>Jueves</span></td>
														<td><span>Viernes</span></td>
														<td><span>S&aacute;bado</span></td>
														<td><span>Domingo</span></td>
													</tr>
													<tr align="center">
														<td>De:</td>
														<td>De:</td>
														<td>De:</td>
														<td>De:</td>
														<td>De:</td>
														<td>De:</td>
														<td>De:</td>
													</tr>
													<tr align="center">
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"
                                                            placeholder="" id="txt1" value="<?php echo $DE1;?>">
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt3" value="<?php echo $DE2;?>">
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt5" value="<?php echo $DE3;?>">
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt7" value="<?php echo $DE4;?>">
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt9" value="<?php echo $DE5;?>">
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt11" value="<?php echo $DE6;?>">
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt13" value="<?php echo $DE7;?>">
                                                        </td>
													</tr>
													<tr align="center">
														<td>A:</td>
														<td>A:</td>
														<td>A:</td>
														<td>A:</td>
														<td>A:</td>
														<td>A:</td>
														<td>A:</td>
													</tr>
					 
													<tr align="center">
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt2" value="<?php echo $A1;?>">
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt4" value="<?php echo $A2;?>">
                                                            <!--Checkboxes Ocultos--<input type="checkbox">-->
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt6" value="<?php echo $A3;?>">
                                                            <!--Checkboxes Ocultos--<input type="checkbox">-->
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt8" value="<?php echo $A4;?>">
                                                            <!--Checkboxes Ocultos--<input type="checkbox">-->
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt10" value="<?php echo $A5;?>">
                                                            <!--Checkboxes Ocultos--<input type="checkbox">-->
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt12" value="<?php echo $A6;?>">
                                                            <!--Checkboxes Ocultos--<input type="checkbox">-->
                                                        </td>
														<td>
                                                        	<input type="text" class="padhorario form-control"
                                                            onkeypress="verificarHorarioCambios()"
                                                            onkeyup="verificarHorarioCambios()"                                                            
                                                            placeholder="" id="txt14" value="<?php echo $A7;?>">
                                                            <!--Checkboxes Ocultos--<input type="checkbox">-->
                                                        </td>
													</tr>
					 							</tbody>
											</table>
											<input type="checkbox" onChange="verificarHorarioCambios()" id="checkall"> &nbsp; <label for="checkall">Copiar Horario</label>
											<!--Final Horario-->
											<!--Botones-->
											<!--button class="btn btn-medio" type="button"
                                            id = "guardarCambios"
                                            onClick="CrearDirPreCorresponsal(tipoDireccion);" disabled>
                                            	Guardar
                                            </button>
											<div class="prealta-footer">
												<button class="btn btn-default" type="button" onClick="CambioPagina(3, false)">
													Adelante
												</button>
												<button class="btn btn-success" type="button" onClick="CambioPagina(1, false)">
													Atr&aacute;s
												<!--button-->
                                               <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
												<button type="button" class="btn btn-success" id="guardarCambios" onClick="CrearDirPreCorresponsal(tipoDireccion);" style="margin-top:10px;" disabled>
													Guardar
												</button> 
												</div>
											<!--div-->
											<div class="col-lg-12 col-sm-12 col-xs-12">
												<div class="pull-left">
													<a href="#" onClick="CambioPagina(1, false);">
												    	<img src="../../img/atras.png" id="atras">
												    </a>
												</div>

							

												<div class="pull-right">
													<a href="#" onClick="CambioPagina(3, false);">
												    	<img src="../../img/adelante.png" id="adelante">
												    </a>
												</div>
											</div>
<!--Cierre Botones-->
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
<!--script src="../../inc/js/advanced-form-components.js"></script-->
<!--Fechas-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--script src="../../inc/js/advanced-form-components.js"></script-->
	<!--Tabla-->
<script src="../../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../../assets/data-tables/DT_bootstrap.js"></script>
<script src="../../css/ui/jquery.ui.core.js<?php echo "?".date("is"); ?>"></script>
    <script src="../../css/ui/jquery.ui.widget.js<?php echo "?".date("is"); ?>"></script>
    <script src="../../css/ui/jquery.ui.position.js<?php echo "?".date("is"); ?>"></script>
    <script src="../../css/ui/jquery.ui.menu.js<?php echo "?".date("is"); ?>"></script>
<script src="../../css/ui/jquery.ui.autocomplete.js<?php echo "?".date("is"); ?>"></script>
<!--Script-->
<!--Cierre del Sitio-->                             
</body>
</html>