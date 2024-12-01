<?php
include("../inc/config.inc.php");
include("../inc/session.inc.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::. Alta de Grupo</title>
<!-- Núcleo BOOTSTRAP -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../css/miredgen.css" rel="stylesheet">
<link href="../css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/datepicker.css" />
<script src="../inc/js/jquery.js"></script>
<script src="../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<script src="../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="../inc/js/RE.js"></script>
<script src="../inc/js/_PrealtaScriptsComunes.js"></script>
<script src="../inc/js/_Grupos.js"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical---->
<!--Función "Include" del Menú-->
<?php include("../inc/menu.php"); ?>
<!--Final del Menú Vertical----->
<!--Final de Barra Vertical Izquierda-->
<!--Contenido Principal del Sitio-->
<!--Función Include del Contenido Principal-->
<?php include("../inc/main.php"); ?>
<!--Inicio del Contenido-->
  <section class="panel">
                          <div class="titulorgb-grupos">
<span><i class="fa fa-file-o"></i></span>
<h3>Crear Grupo</h3><span class="rev-combo pull-right">Alta<br>de Grupo</span></div>
<div class="panel-body" >
	<!--<legend id="tipoDeCreacion">Cadena</legend>-->
	<div class="col-sm-12">
<div class="col-sm-9 col-sm-offset-2">
<form class="form-horizontal" id="datos-generales"> 
<div class="form-group">
<label class="col-md-1 col-md-offset-1 control-label">Nombre:</label>
<div class="col-md-6">
<input class="form-control" type="text" placeholder="">
</div>
<div class="col-xs-1">
<button class="btn btn-info btn-xs" type="button" style="margin-top:2px;">Crear</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
                 
                 
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                  <div class="panel">
                  <div class="panel-heading"><i class="fa fa-book"></i> Datos Generales</div>
                  <div class="panel-body">
<!--Forma-->
<form class="form-horizontal">
<div class="form-group">  
<label class="col-lg-1 control-label">Nombre:</label>
<div class="col-lg-3">
<input type="text" class="form-control" id="txtnombrereferencia" placeholder="">
</div>
 
<label class="col-lg-1 control-label">Referencia:</label>
<div class="col-lg-3">
<input type="text" class="form-control" placeholder="">
</div>

<label class="col-lg-1 control-label">RFC:</label>
<div class="col-lg-3">
<input type="text" class="form-control" placeholder="">
</div>
</div>

<div class="form-group">  
<label class="col-lg-1 control-label">Tel&eacute;fono:</label>
<div class="col-lg-3">
<input type="text" class="form-control" id="txttel1"
onkeyup="validaTelefono2(event,'txttel1');VerificarGrlsSub();"
onfocus="RellenarTelefonoDatosGenerales()"
onkeypress="return validaTelefono1(event,'txttel1');VerificarGrlsSub();" maxlength="15"
placeholder="">
</div>

<label class="col-lg-1 control-label">Descripci&oacute;n:</label>
<div class="col-lg-3">
<input type="text" class="form-control" placeholder="">
</div>

</div>
</form>
</div>
</div>
<!--Cierre-->
 <div class="panel">
                  <div class="panel-heading"><i class="fa fa-home"></i> Direcci&oacute;n</div>
                  <div class="panel-body">
<!--Forma-->
<form class="form-horizontal" id="datos-generales">
                                     <div class="form-group">
                                          <label class="col-lg-1 control-label">Pa&iacute;s:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="text" id="txtPais" placeholder="" maxlength="50">
                                          </div>
                                          </div>
                                  
                                         
                                         <div class="form-group">
                                          <label class="col-lg-1 control-label">Calle:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="text" id="txtcalle" placeholder="" maxlength="50">
                                          </div>
                                  
                                      
                                          <label class="col-lg-1 control-label">No. Interior:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="number" id="txtnint" placeholder="" maxlength="50">
                                          </div>
                                      
                                      
                                        
                                          <label class="col-lg-1 control-label">No. Exterior:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="text" id="txtnext" placeholder="" maxlength="50">
                                          </div>
                                          </div>
                                 
                                      
                                           <div class="form-group">
                                          <label class="col-lg-1 control-label">C.P:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="text" id="txtcp" placeholder="" maxlength="5">
                                          </div>
                                  
                                         
                                          <label class="col-lg-1 control-label">Colonia:</label>
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
                                          <label class="col-lg-1 control-label">Estado:</label>
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
                                       
                                          
                                          
                                          <label class="col-lg-1 control-label">Ciudad:</label>
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
</div>
</div>
<!--Cierre-->
<div class="panel">
                  <div class="panel-heading"><i class="fa fa-dollar"></i> Afiliaci&oacute;n y Cuotas</div>
                  <div class="panel-body">
<!--Forma-->
                  <!--Tabla-->
                  
                  <table class="tablanueva">

                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Concepto</th>
                                          <th class="theadtablita">Importe</th>
                                          <th class="theadtablita">Fecha de Inicio</th>
                                          <th class="theadtablita">Observaciones</th>
                                          <th class="theadtablita">Cargo A</th>
                                          <th class="acciones">Editar</th>
                                          <th class="acciones">Eliminar</th>
                                      </tr>
                                      </thead>
                                      <tbody class="tablapequena">                                     
                                          <tr><td class="tdtablita-o">Cuota Mensual</td><td class="tdtablita-o">$1000.00</td><td class="tdtablita-o">10/10/2013</td><td class="tdtablita-o">Observaciones.</td><td class="tdtablita-o">Cadena</td>
                                          <td class="acciones"><i class="fa fa-pencil"></i></td><td class="acciones"><i class="fa fa-times"></i></td></tr></tbody></table>
 
 <button class="btn btn-info btn-xs" type="button" style="margin-bottom:10px;">Nuevo <i class="fa fa-plus"></i></button>
 <!--Otro-->
 
 <form class="form-horizontal">
                                     
                                     <div class="form-group">
                                          <label class="col-lg-2 control-label">Concepto:</label>
                                          <div class="col-lg-3">
                                       <select class="form-control m-bot15">
                                              <option>Cuota Anual</option>
                                              <option>Cuota Mensual</option>
                                              </select>
                                          </div>
                            
                                          
                        
                                          <label class="col-lg-1 control-label">Importe:</label>
                                          <div class="col-lg-2">
                                              <input class="form-control" type="text" placeholder="">
                                          </div>
                                         
                                          
                                          
                                          <label class="col-lg-2 control-label">Fecha de Inicio:</label>
                                          <div class="col-lg-2">
                                      <input class="form-control default-date-picker">
                                      <span class="help-block">Seleccionar Fecha.</span>  
                                      </div>
                                      </div>                              
                                      
                                           <div class="form-group">
                                           <label class="col-lg-2 control-label">Observaciones:</label>
                                           <div class="col-lg-3">
                                           <textarea class="form-control" rows="3"></textarea>
                                          </div>
                                          </div>                                  
      </form>
           
<!--Forma-->
                                  </div>


                                  </div>
                            
<!--Cierre-->
<!--Cierre-->
<div class="panel">
                  <div class="panel-heading"><i class="fa fa-users"></i> Contactos</div>
                  <div class="panel-body">
                  <!--Tabla-->
                  
                  
 <table class="tablanueva">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Contacto</th>
                                          <th class="theadtablita">Tel&eacute;fono</th>
                                          <th class="theadtablita">Extensi&oacute;n</th>
                                          <th class="theadtablita">Correo</th>
                                          <th class="theadtablita">Tipo de Contacto</th>
                                          <th class="acciones">Editar</th>
                                          <th class="acciones">Eliminar</th>
                                      </tr>
                                      </thead>
                                      <tbody class="tablapequena">                                     
                                          <tr><td class="tdtablita-o">Cuota Mensual</td><td class="tdtablita-o">$1000.00</td><td class="tdtablita-o">10/10/2013</td><td class="tdtablita-o">Observaciones.</td><td class="tdtablita-o">Cadena</td>
                                          <td class="acciones"><i class="fa fa-pencil"></i></td><td class="acciones"><i class="fa fa-times"></i></td></tr></tbody></table>
 
 <button class="btn btn-info btn-xs" type="button" style="margin-bottom:10px;">Nuevo <i class="fa fa-plus"></i></button>
           
<!--Forma-->

      
      <form class="form-horizontal" >
                                     <div class="form-group">
                                          <label class="col-lg-1 control-label">*Nombre(s):</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" id="txtnombre" onBlur="VerificarContactos()" type="text" maxlength="100" placeholder="">
                                          </div>
                                          
                                          <label class="col-lg-1 control-label">*A. Paterno:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" id="txtpaterno" onBlur="VerificarContactos()" type="text" maxlength="50" placeholder="">
                                          </div>
                                      
                                          <label class="col-lg-1 control-label">*A. Materno:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" id="txtmaterno" onBlur="VerificarContactos()" type="text" maxlength="50" placeholder="">
                                          </div>
                                     </div>
                                 
                                     <div class="form-group">
                                         <label class="col-lg-1 control-label">*Tel&eacute;fono:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" id="txttelefono" onKeyUp="validaTelefono2(event,'txttelefono')" onKeyPress="return validaTelefono1(event,'txttelefono')" onFocus="RellenarTelefonoContactos()" onBlur="VerificarContactos()" type="text" maxlength="15" placeholder="">
                                          </div>
                                  
                                         <label class="col-lg-1 control-label">Extensi&oacute;n</label>
                                          <div class="col-lg-3">
										  	<input class="form-control" id="txtext" onBlur="VerificarContactos()" type="text" maxlength="10" placeholder="">
                                          </div>
                                          
                                          <label class="col-lg-1 control-label">*Correo:</label>
                                          <div class="col-lg-3">
											<input class="form-control" id="txtcorreo" onBlur="VerificarContactos()" type="text" maxlength="100" placeholder="">
                                          </div>
                                          </div>
                                          
                                     <div class="form-group">
                                         <label class="col-lg-1 control-label">*Tipo:</label>
                                          <div class="col-lg-3">
											<select name="ddlTipoContacto" class="form-control" id="ddlTipoContacto" onChange="VerificarContactos()">
                                              <option value="-1">Tipo de Contacto</option>
                                              <?php
                                                $sql = "CALL `redefectiva`.`SP_LOAD_TIPOS_DE_CONTACTO`();";
                                                $res = $RBD->SP($sql);
                                                if($RBD->error() == ''){
                                                    if($res != '' && mysqli_num_rows($res) > 0){
                                                        while($r = mysqli_fetch_array($res)){
                                                            echo "<option value='$r[0]'>".utf8_encode($r[1])."</option>";
                                                        }
                                                    }
                                                }
                                              ?>
                                            </select>
                                          </div>                                        
                                      </div>
                                  </form>
                                  </div>
                                  </div>
                                  <!--Cierre-->
                                  <div class="panel">
                  <div class="panel-heading"><i class="fa fa-shopping-cart"></i> Versión</div>
                  <div class="panel-body">
                  
                  
                                  
                                  
                                  <table class="tablanueva">
                                      <thead class="theadtablita">
                                      <tr>
                                      <th></th>
                                      <th class="theadtablita">Telefonía</th>
                                      <th class="theadtablita">Servicios</th>
                                      <th class="theadtablita">Bancos</th>
                                      <th class="theadtablita">Transporte</th>
                                      <th class="theadtablita">Remesas</th>
                                      <th class="theadtablita">Seguros</th>
                                      <th class="theadtablita">Juegos</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                      <td class="tdtablita"><input name="version" type="radio" checked="" value="full"> Completa</td>
                                      <td class="tdtablita"><img src="../img/telefonia.png"></td>
                                      <td class="tdtablita"><img src="../img/servicios.png"></td>
                                      <td class="tdtablita"><img src="../img/banco.png"></td>
                                      <td class="tdtablita"><img src="../img/transporte.png"></td>
                                      <td class="tdtablita"><img src="../img/remesas.png"></td>
                                      <td class="tdtablita"><img src="../img/seguros.png"></td>
                                      <td class="tdtablita"><img src="../img/juegos.png"></td>
                                      </tr>
                                      <tr>
                                      <td class="tdtablita"><input name="version" type="radio" value="light"> Light</td>
                                      <td class="tdtablita"><img src="../img/telefonia.png"></td>
                                      <td class="tdtablita"><img src="../img/servicios.png"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"><img src="../img/transporte.png"></td>
                                      <td class="tdtablita"><img src="../img/remesas.png"></td>
                                      <td class="tdtablita"><img src="../img/seguros.png"></td>
                                      <td class="tdtablita"><img src="../img/juegos.png"></td>
                                      </tr>
                                      <tr>
                                      <td class="tdtablita"><input name="version" type="radio" value="ulight"> Ultra Light</td>
                                      <td class="tdtablita"><img src="../img/telefonia.png"></td>
                                      <td class="tdtablita"><img src="../img/servicios.png"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      </tr>
                                      <tr>
                                      <td class="tdtablita"><input name="version" type="radio" value="srv"> Servicios</td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"><img src="../img/servicios.png"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      </tr>
                                      <tr>
                                      <td class="tdtablita"><input name="version" type="radio" value="unica"> Única</td>
                                      <td class="tdtablita"><img src="../img/telefonia.png"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      <td class="tdtablita"></td>
                                      </tr>
                                      </tbody>
                                      </table>
                                    
                                 <table class="tablarevision">
<tbody><tr>
<td>Versión</td><td>Comisiones Personalizadas</td></tr>
<tr>
<td class="dato">Light</td><td><a href="#">Agregar <i class="fa fa-plus"></i></a></tr>
</tbody></table>
<!--Cierre de Área Tabla-->



</div>





</div>

</div>
                                  
                                  </div></div>
                                  <!--Cierre-->
                                  
                                   <div class="panel">
                  <div class="panel-heading"><i class="fa fa-credit-card"></i> Cuenta</div>
                  <div class="panel-body">
                  
                  <form class="form-horizontal">
                             <div class="form-group">
                             <label class="col-lg-1 control-label">FORELO:</label>
                               <div class="col-lg-3">
                                       <select class="form-control m-bot15">
                                              <option>Cliente</option>
                                              <option>Individual</option>
                                       </select>
                                          </div>
                                          </div>
                                         
                             
                             <div class="form-group">
                             <label class="col-lg-1 control-label">CLABE:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="text" placeholder="">
                                          </div>
                                          </div>
                                          
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">Banco:</label>
                                          <div class="col-lg-3">
                                       <select class="form-control m-bot15">
                                              <option>Banamex</option>
                                              <option>ScotiaBank</option>
                                              <option>Banco</option>
                                          </select>
                                          </div>
                                          
                                         
                                          <label class="col-lg-1 control-label">No.Cuenta:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="text" placeholder="">
                                          </div>
                                          </div>
                                          
                                          
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">Beneficiario:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="text" placeholder="">
                                          </div>
                                      
                                      
                                       <label class="col-lg-1 control-label">Descripción:</label>
                                          <div class="col-lg-3">
                                              <input class="form-control" type="text" placeholder="">
                                          </div>
                                      </div>
                                      </form>
                  
                  </div>
                  </div>
                                  
                                  
                                  <!--Cierre-->
                                     <div class="panel">
                  <div class="panel-heading"><i class="fa fa-folder"></i> Documentación</div>
                  <div class="panel-body">
                  
             <table class="tablanueva">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablita">Archivo</th>
                                           <th class="theadtablita">Seleccionar</th>
                                           <th class="theadtablita">Estado</th>
                                     </tr>
                                      </thead>
                                       <tbody class="tablapequena">   
                                      <tr>
                                      <td class="tdtablita">Caratula de Banco</td>
                                      <td class="tdtablita">
                                      <input type="file"></td>
                                      <td class="tdtablita"><img src="../img/add.png"></td>
                                      </tr>
                                      </tbody>
                                      </table>
                  
                 
</div>
<div class="modal-footer">
<button class="btn btn-success consulta pull-right" type="button">Crear Grupo</button>
</div>

</div>
</div>
                                  
                                  <!--Cierre-->
                                  
</div>
</div>
</section>
</section>
<!--*.JS Generales-->
<script src="../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../inc/js/jquery.scrollTo.min.js"></script>
<script src="../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../inc/js/common-scripts.js"></script>
<!--Específicos-->
<script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../inc/js/advanced-form-components.js"></script>
<!--Cierre del Sitio--> 
<!--Cierre del Sitio-->                             
</body>
</html>