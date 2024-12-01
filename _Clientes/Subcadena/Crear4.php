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
	#txtrfc { text-transform: uppercase; }
	#txtrrfc { text-transform: uppercase; }
	#txtcurp { text-transform: uppercase; }	
</style>
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="../../inc/js/RE.js"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js"></script>
<script src="../../inc/js/_PrealtaPreSubCadena.js"></script>
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
          VerificarDireccionSub(tipoDireccion, false);
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
<script>
	<?php
		if ( $direccionPaso2 ) {
			$paisZ = $oSubcadena->getPais();
		} else {
			$paisZ = $oSubcadena->getCPais();
		}
		if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
	?>
	var tipoDireccion = "nacional";
	<?php } else { ?>
	var tipoDireccion = "extranjera";
	<?php } ?>
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
                        	<img src="../../img/h.png" id="home">                        </a>                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(1, existenCambios)">
                        	<img src="../../img/1.png" id="paso1">                        </a>                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(2, existenCambios)">
                        	<img src="../../img/2.png" id="paso2">                        </a>                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(3, existenCambios)">
                        	<img src="../../img/3.png" id="paso3">                        </a>                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(4, existenCambios)">
                        	<img src="../../img/4a.png" id="paso4Actual">                        </a>                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(5, existenCambios)">
                        	<img src="../../img/5.png" id="paso5">                        </a>                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(6, existenCambios)">
                        	<img src="../../img/6.png" id="paso6">                        </a>                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(7, existenCambios)">
                        	<img src="../../img/7.png" id="paso7">                        </a>                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(8, existenCambios)">
                        	<img src="../../img/r.png" id="resumen">                        </a>                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
                  <div class="legend-big"> <i class="fa fa-file"></i> Contrato</div>
 <legend>Datos Generales</legend>  
                                    
                           
                             <form class="form-horizontal" id="default">
                             
                               <div class="form-group">
                                  <label class="col-lg-1 control-label">*R&eacute;gimen:</label>
                                          <div class="col-lg-3">
                                            <select class="form-control m-bot15" id="ddlRegimen" onChange="VerificarContrato();mostrarDatosPersonaMoral();">
                                                <?php
													switch( $oSubcadena->getCRegimen() ) {
                                                        case 1:
                                                            echo "<option value=\"1\" selected=\"selected\">F&iacute;sica</option>";
                                                            echo "<option value=\"2\">Moral</option>";
                                                        break;
                                                        case 2:
                                                            echo "<option value=\"1\">F&iacute;sica</option>";
                                                            echo "<option value=\"2\" selected=\"selected\">Moral</option>";
                                                        break;
                                                        case 3:
                                                            echo "<option value=\"1\">F&iacute;sica</option>";
                                                            echo "<option value=\"2\">Moral</option>";
                                                        break;
                                                        default:
                                                            echo "<option value=\"1\">F&iacute;sica</option>";
                                                            echo "<option value=\"2\">Moral</option>";
                                                        break;												
                                                    }
                                                ?>
                                            </select>                                           
                                          </div>
                                          </div>
                                          
                                          <div class="form-group">
                                          <label class="col-md-1 control-label">*RFC:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtrfc"
                                              onkeypress="VerificarContrato()"
                                              onkeyup="VerificarContrato()"
                                              onkeydown="RellenarContrato(event)"
                                              placeholder="" value="<?php echo $oSubcadena->getCRfc(); ?>"
											  <?php
                                              	if ( $oSubcadena->getCRegimen() == 1 ) {
													echo "maxlength=13";
												} else if ( $oSubcadena->getCRegimen() == 2 ) {
													echo "maxlength=12";
												} else {
													echo "maxlength=13";
												}
											  ?>>
                                          </div>
                                        
                                        
                                        <label class="col-lg-1 control-label" id="labelRazonSocial"
                                        <?php echo ($oSubcadena->getCRegimen() == 1 || $oSubcadena->getCRegimen() == "")? "style=\"visibility:hidden;\"" : ''; ?>>*Raz&oacute;n Social:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtrazon"
                                              onkeypress="verificarRepresentanteLegal()"
                                              onkeyup="verificarRepresentanteLegal()"
                                              maxlength="200"
                                              placeholder="" value="<?php
                                              $razonSocial = $oSubcadena->getCRSocial();
											  if ( !preg_match('!!u', $razonSocial) ) {
											  	$razonSocial = utf8_encode($razonSocial);
											  }
											  echo $razonSocial;
											  ?>"
                                              <?php echo ($oSubcadena->getCRegimen() == 1 || $oSubcadena->getCRegimen() == "")? "style=\"visibility:hidden;\"" : ''; ?>
                                              disabled>
                                          </div>
                                        
                                    
                                     
                                    <label class="col-lg-1 control-label" id="labelConstitucion"
                                    <?php echo ($oSubcadena->getCRegimen() == 1 || $oSubcadena->getCRegimen() == "")? "style=\"visibility:hidden;\"" : ''; ?>>*Constituci&oacute;n:</label>
                                  <div class="col-lg-3">
                                      <input class="form-control form-control-inline input-medium default-date-picker" id="txtfecha"
                                      onkeypress="verificarRepresentanteLegal()"
                                      onkeyup="verificarRepresentanteLegal()"
                                      maxlength="10"
                                      size="16" type="text" value="<?php
									  $fechaConstitucion = $oSubcadena->getCFConstitucion();
                    				  echo (isset($fechaConstitucion) && $fechaConstitucion != "")? date("Y-m-d", strtotime($fechaConstitucion)) : '';										
									  ?>" <?php echo ($oSubcadena->getCRegimen() == 1 || $oSubcadena->getCRegimen() == "")? "style=\"visibility:hidden;\"" : ''; ?>
                                      disabled />
                                      <span class="help-block" id="textoSeleccionarFecha"
                                      <?php echo ($oSubcadena->getCRegimen() == 1 || $oSubcadena->getCRegimen() == "")? "style=\"visibility:hidden;\"" : ''; ?>>Seleccionar Fecha.</span>                                  </div>
                                  </div>
                                         
                                
                                        
                                          <br/>
                                          
                                         <legend>Representante Legal</legend>
                                         
                                         <div class="form-group">
                                          <label class="col-lg-1 control-label">*Nombre(s):</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtnombre"
                                              onkeypress="verificarRepresentanteLegal()"
                                              onkeyup="verificarRepresentanteLegal()"
                                              maxlength="100"
                                              placeholder="" value="<?php
                                              $nombre = $oSubcadena->getCNombre();
											  if ( !preg_match('!!u', $nombre) ) {
											  	//no es utf-8
												$nombre = utf8_encode($nombre);
											  }
											  echo $nombre;
											  ?>">
                                          </div>
                                       
                                         <label class="col-lg-1 control-label">*A.Paterno:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtpaterno"
                                              onkeypress="verificarRepresentanteLegal()"
                                              onkeyup="verificarRepresentanteLegal()"
                                              maxlength="50"
                                              placeholder="" value="<?php
                                              $apellidoPaterno = $oSubcadena->getCPaterno();
											  if ( !preg_match('!!u', $apellidoPaterno) ) {
											  	//no es utf-8
												$apellidoPaterno = utf8_encode($apellidoPaterno);
											  }
											  echo $apellidoPaterno;
											  ?>">
                                          </div>
                                        
                                          <label class="col-lg-1 control-label">*A.Materno:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtmaterno"
                                              onkeypress="verificarRepresentanteLegal()"
                                              onkeyup="verificarRepresentanteLegal()"
                                              maxlength="50"
                                              placeholder="" value="<?php
                                              $apellidoMaterno = $oSubcadena->getCMaterno();
											  if ( !preg_match('!!u', $apellidoMaterno) ) {
											  	//no es utf-8
												$apellidoMaterno = utf8_encode($apellidoMaterno);
											  }
											  echo $apellidoMaterno;
											  ?>">
                                          </div>
                                         </div>
                                         
                                         <div class="form-group">
                                          <label class="col-lg-2 control-label">*No. Identificaci&oacute;n</label>
                                          <div class="col-lg-2">
                                              <input type="text" class="form-control" id="txtnumiden" maxlength="15"
                                              onkeypress="verificarRepresentanteLegal()"
                                              onkeyup="verificarRepresentanteLegal()"
                                              placeholder="" value="<?php echo $oSubcadena->getCNumIden(); ?>">
                                          </div>
                                         
                                          <label class="col-lg-2 control-label">*Tipo de Identificaci&oacute;n:</label>
                                          <div class="col-lg-2">
                                              <select class="form-control m-bot15" id="ddlTipoIden" onChange="verificarRepresentanteLegal()">
                                                <option value="-1">Seleccione</option>
													<?php
														$tipoIdentificacion = $oSubcadena->getCRTipoIden();
														$sql = "CALL `redefectiva`.`SP_LOAD_TIPOSDEIDENTIFICACION`();";
														$res = $RBD->SP($sql);
														if ( $res != '' && mysqli_num_rows($res) > 0 ) {
															while ( $r = mysqli_fetch_array($res) ) {
																if ( $r[0] == $tipoIdentificacion ) {
																	echo "<option value='$r[0]' selected='selected'>$r[1]</option>";
																} else {
																	echo "<option value='$r[0]'>$r[1]</option>";
																}
															}
														}
                                                    ?>
                                              </select>                                          
                                          </div>
                                          <label class="col-lg-2 control-label" id="labelRepLegalRFC"
										  <?php echo ( $oSubcadena->getCRegimen() == 2 )? "style=\"visibility:visible\"" : "style=\"visibility:hidden;\""; ?>>
                                          *RFC:
                                          </label>
                                          <div class="col-lg-2"
                                          <?php echo ( $oSubcadena->getCRegimen() == 2 )? "style=\"visibility:visible\"" : "style=\"visibility:hidden;\""; ?>>
                                              <input type="text" class="form-control" id="txtrrfc"
                                              onkeypress="verificarRepresentanteLegal()"
                                              onkeyup="verificarRepresentanteLegal()"
                                              placeholder="" value="<?php echo $oSubcadena->getCRRfc(); ?>" maxlength="13">
                                          </div>
                                         </div>
                                         
                                         
                                         <div class="form-group">
                                         <label class="col-lg-2 control-label">CURP:</label>
                                          <div class="col-lg-2">
                                              <input type="text" class="form-control" id="txtcurp"
                                              onkeypress="verificarRepresentanteLegal()"
                                              onkeyup="verificarRepresentanteLegal()"
                                              maxlength="18"
                                              placeholder="" value="<?php echo $oSubcadena->getCCurp(); ?>">
                                          </div>
                                          
                                            
                                            <label class="col-lg-3 control-label">Figura Pol&iacute;ticamente Expuesta:</label>
                                            <div class="col-lg-1">
                                            <input type="checkbox" id="chkfigura" name="checkboxFPolitica"
                                            onChange="VerificarContrato()"
											<?php echo ($oSubcadena->getCFigura() == 0 && $oSubcadena->getCFigura() != "")? 'checked="checked"' : ''; ?>> 
                                            </div>
                                            
                                            <label class="col-lg-3 control-label">Familia Pol&iacute;ticamente Expuesta:</label>
                                            <div class="col-lg-1">
                                            <input type="checkbox" id="chkfamilia" name="checkboxFPolitica"
                                            onChange="VerificarContrato()"
											<?php echo ($oSubcadena->getCFamilia()== 0 && $oSubcadena->getCFamilia() != "")? 'checked="checked"' : ''; ?>> 
                                            </div>
                                            </div>
                                            </form>
                                            
                                            
                                            
                                  <br>
                               <legend>Dirección Fiscal</legend>
                               
                                   <div class="checkbox" style="font-size:9px; padding-bottom:10px;">
                                      <label>
                                          <input type="checkbox" id="chkDirGral" onChange="VerificarContrato()" onClick="CheckDirGral('PreSubCadena', tipoDireccion);" <?php echo ($direccionPaso2)? "checked" : ""; ?>> Misma Dirección de PASO 2.                                    </label>
                                  </div>
<!--Forma-->

<form class="form-horizontal" id="datos-generales">
                                     <div class="form-group">
                                          <label class="col-lg-1 control-label">*Pa&iacute;s:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtPais"
                                              maxlength="50"
                                              value="<?php
												if ( $direccionPaso2 ) {
													$nombrePais = $oSubcadena->getNombrePais();
												} else {
													$nombrePais = $oSubcadena->getCNombrePais();
												}
												if ( !preg_match('!!u', $nombrePais) ) {
													//no es utf-8
													$nombrePais = utf8_encode($nombrePais);
												}
												echo $nombrePais;                                            
											  ?>" onKeyPress="VerificarDireccionSub(tipoDireccion);"
                                              onkeyup="VerificarDireccionSub(tipoDireccion);"
                                              onchange="cambiarPantalla();"
                                              placeholder=""
                                              <?php echo ($direccionPaso2)? "disabled" : ""; ?>>
                                              <input type="hidden" id="paisID" value="<?php
												if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
													$tipoDireccion = "nacional";
												} else {
													$tipoDireccion = "extranjera";
												}											  
                                              echo ( $paisZ > 0 )? $paisZ : ''; ?>"/>
                                          </div>
                                          </div>
                                         
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">*Calle:</label>
                                          <div class="col-lg-3">
                                              <?php
                                                $calle = (!preg_match('!!u', $oSubcadena->getCalle()))? utf8_encode($oSubcadena->getCalle()) : $oSubcadena->getCalle();
                                                $ccalle = (!preg_match('!!u', $oSubcadena->getCCalle()))? utf8_encode($oSubcadena->getCCalle()) : $oSubcadena->getCCalle();
                                              ?>
                                              <input type="text" class="form-control" id="txtcalle"
                                              value="<?php echo ($direccionPaso2)? $calle : $ccalle; ?>"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              onkeyup="VerificarDireccionSub(tipoDireccion);"
                                              placeholder="" maxlength="50"
                                              <?php echo ($direccionPaso2)? "disabled" : ""; ?>>
                                          </div>
                                  
                                      
                                          <label class="col-lg-1 control-label">No. Interior:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtnint"
                                              value="<?php echo ($direccionPaso2)? $oSubcadena->getNint() : $oSubcadena->getCNint(); ?>"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              onkeyup="VerificarDireccionSub(tipoDireccion);"
                                              placeholder="" maxlength="50"
                                              <?php echo ($direccionPaso2)? "disabled" : ""; ?>>
                                          </div>
                                      
                                     
                                          <label class="col-lg-1 control-label">*No. Exterior:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtnext"
                                              value="<?php echo ($direccionPaso2)? $oSubcadena->getNext() : $oSubcadena->getCNext(); ?>"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              onkeyup="VerificarDireccionSub(tipoDireccion);"
                                              placeholder="" maxlength="50"
                                              <?php echo ($direccionPaso2)? "disabled" : ""; ?>>
                                          </div>
                                          </div>
                                 
                                      
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">*C.P:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtcp"
                                              onkeyup="buscarColonias();VerificarDireccionSub(tipoDireccion);"
                                              onkeypress="VerificarDireccionSub(tipoDireccion);"
                                              value="<?php echo ($direccionPaso2)? $oSubcadena->getCP() : $oSubcadena->getCCP(); ?>"
                                              placeholder="" maxlength="5"
                                              <?php echo ($direccionPaso2)? "disabled" : ""; ?>>
                                          </div>
                                  
                                         
                                          <label class="col-lg-1 control-label">*Colonia:</label>
                                          <div class="col-lg-3">
                                          	<div id="divCol">
												<?php
													if ( $direccionPaso2 ) {
														$colZ = $oSubcadena->getColonia();
														$cdZ = $oSubcadena->getCiudad();
														$edoZ = $oSubcadena->getEstado();
														$paisZ = $oSubcadena->getPais();												
													} else {
														$colZ = $oSubcadena->getCColonia();
														$cdZ = $oSubcadena->getCCiudad();
														$edoZ = $oSubcadena->getCEstado();
														$paisZ = $oSubcadena->getCPais();											
													}											
                                                    if ( $tipoDireccion == "nacional" ) {
														if ( $direccionPaso2 ) {
															echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
																	class=\"form-control m-bot15\"
																	onchange=\"VerificarDireccionSub(tipoDireccion, false);\"
																	style=\"display:block;\"
																	disabled>";														
														} else {
															echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
																	class=\"form-control m-bot15\"
																	onchange=\"VerificarDireccionSub(tipoDireccion, false);\"
																	style=\"display:block;\">";
														}
                                                    } else {
                                                        if ( $direccionPaso2 ) {
															echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
																	class=\"form-control m-bot15\"
																	onchange=\"VerificarDireccionSub(tipoDireccion, false);\"
																	style=\"display:none;\" disabled>";														
														} else {
															echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
																	class=\"form-control m-bot15\"
																	onchange=\"VerificarDireccionSub(tipoDireccion, false);\"
																	style=\"display:none;\">";
														}												
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
                                          </div>
                                          
                                          
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">*Estado:</label>
                                          <div class="col-lg-3">
                                          	<div id="selectestados">
												<?php
													if ( $direccionPaso2 ) {
														$paisZ = $oSubcadena->getPais();
														$estadoZ = $oSubcadena->getEstado(); 													
													} else {
														$paisZ = $oSubcadena->getCPais();
														$edoZ = $oSubcadena->getCEstado();											
													}                                                    
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
                                          </div>
                                       
                                          
                                          
                                          <label class="col-lg-1 control-label">*Ciudad:</label>
                                          <div class="col-lg-3">
                                          	<div id="divCd">
												<?php
													if ( $direccionPaso2 ) {
														$cdZ = $oSubcadena->getCiudad();
														$edoZ = $oSubcadena->getEstado();
														$paisZ = $oSubcadena->getPais();														
													} else {
														$cdZ = $oSubcadena->getCCiudad();
														$edoZ = $oSubcadena->getCEstado();
														$paisZ = $oSubcadena->getCPais();														
													}
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
																maqxlength=\"50\" />";	
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
                                      </div>
                                  </form>

    <!--Final Forma-->
                                      
                                       
                                    
                  
                                  
                         <!--sep-->
                  
<!--Botones-->
  <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" id="guardarCambios" class="btn btn-success"
onclick="EditarContratoSubCadena(tipoDireccion)"
style="margin-top:10px;" disabled>
	Guardar
</button> 
</div>
<!--Botones-->
<div class="col-lg-12 col-sm-12 col-xs-12">
<div class="pull-left">
	<a href="#" onClick="CambioPagina(3, existenCambios);">
		<img src="../../img/atras.png" id="atras">    </a></div>                              


<div class="pull-right">
	<a href="#" onClick="CambioPagina(5, existenCambios);">
		<img src="../../img/adelante.png" id="adelante">    </a></div>                               
</div>
<!--Cierre Botones-->
<!--Cierre Botones-->

<!--Cierre-->
</div>
</div>
</section>
</section>                          
</body>
</html>

<!--*.JS Generales-->
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../inc/js/respond.min.js"></script>
<!--Generales-->
<!--Elector de Fecha-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Común-->
<script src="../../inc/js/common-scripts.js"></script>