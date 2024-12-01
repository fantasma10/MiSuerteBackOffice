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
$subsubmenuTitulo ="Cadena";

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

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
                        	<img src="../../img/2.png" id="paso2">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(3, existenCambios)">
                        	<img src="../../img/3a.png" id="paso3Actual">
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
 <div class="legend-big"><i class="fa fa-users"></i> Contactos</div> 
                                    
                          
                              
                              	<div id="divRES">
                                    <table class="tablanueva">
                                      <thead class="theadtablita">
                                      <tr>
                                          <th class="theadtablitauno">Contacto</th>
                                          <th class="theadtablita">Tel&eacute;fono</th>
                                          <th class="theadtablita">Extensi&oacute;n</th>
                                          <th class="theadtablita">Correo</th>
                                          <th class="theadtablita">Tipo de Contacto</th>
                                          <th class="theadtablitados">Editar</th>
                                           <th class="theadtablitados">Eliminar</th>
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
                                                    //$r = mysqli_fetch_array($res);
                                                    //$xml = simplexml_load_string($r[0]);
                                                    $r = mysqli_fetch_array($res);
                                                    $reg = $r[0];
                                                    $xml = simplexml_load_string(utf8_encode($reg));
                                                    //$reg = base64_decode($r[0]);
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
                                                                    echo "<td class=\"tdtablita\">";
                                  																	echo "<a href=\"#\" onclick=\"bandedcont = 1;EditarPreContacto($infid,0,0)\">";
                                  																	echo "<img src=\"../../img/edit.png\" title=\"Editar\" name=\"Image3\" border=\"0\" id=\"Image3\" />";
                                  																	echo "</a>";
                                  																	echo "</td>";
                                  																	echo "<td class=\"tdtablita\">";
                                  																	echo "<a href=\"#\" onclick=\"EliminarPreContacto($infid);\">";
                                  																	echo "<img src=\"../../img/delete.png\" title=\"Borrar\" name=\"Image26\" border=\"0\" id=\"Image26\" />";
                                  																	echo "</a>";
                                                                    echo "</td>";
                                                                    echo "</tr>";														
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else {
                          													  echo "<td class=\"tdtablita\"></td>";
                          													  echo "<td class=\"tdtablita\"></td>";
                          													  echo "<td class=\"tdtablita\"></td>";
                          													  echo "<td class=\"tdtablita\"></td>";
                          													  echo "<td class=\"tdtablita\"></td>";
                                                      echo "<td class=\"tdtablita\"></td>";
                          													  echo "<td class=\"tdtablita\"></td>";
													                          }							
                                                }
                                                else {
                                              echo "<td class=\"tdtablita\"></td>";
                                              echo "<td class=\"tdtablita\"></td>";
                                              echo "<td class=\"tdtablita\"></td>";
                                              echo "<td class=\"tdtablita\"></td>";
                                              echo "<td class=\"tdtablita\"></td>";
                                              echo "<td class=\"tdtablita\"></td>";               
                                              echo "<td class=\"tdtablita\"></td>";               
                                            }
                                            }
                                            else {
                      											  echo "<td class=\"tdtablita\"></td>";
                      											  echo "<td class=\"tdtablita\"></td>";
                      											  echo "<td class=\"tdtablita\"></td>";
                      											  echo "<td class=\"tdtablita\"></td>";
                      											  echo "<td class=\"tdtablita\"></td>";
                                              echo "<td class=\"tdtablita\"></td>";               
                      											  echo "<td class=\"tdtablita\"></td>";								
                                            }						  
                                          ?>
                                     	</tbody>
                                     </table>
                                  </div>
                             
                                   <button type="button" class="btn btn-info btn-xs" id="boton-nuevo-contacto" onClick="agregarPreContacto()">Nuevo <i class="fa fa-plus"></i></button><br>
                                   
                                     <form class="form-horizontal" id="datos-generales-contacto" style="display:none;">
                                     <div class="form-group">
                                          <label class="col-lg-1 control-label">*Nombre(s):</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtnombre"
                                              placeholder="" onBlur="VerificarContactos()" maxlength="100">
                                          </div>
                                          
                                          <label class="col-lg-1 control-label">*A. Paterno:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtpaterno"
                                              placeholder="" onBlur="VerificarContactos()" maxlength="50">
                                          </div>
                                      
                                          <label class="col-lg-1 control-label">*A. Materno:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtmaterno"
                                              placeholder="" onBlur="VerificarContactos()" maxlength="50">
                                          </div>
                                     </div>
                                 
                                     <div class="form-group">
                                         <label class="col-lg-1 control-label">*Tel&eacute;fono:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txttelefono"
                                              onkeyup="validaTelefono2(event,'txttelefono')"
                                              onkeypress="return validaTelefono1(event,'txttelefono')"
                                              maxlength="15"
                                              placeholder="" onBlur="VerificarContactos()" onFocus="RellenarTelefono()">
                                          </div>
                                  
                                         <label class="col-lg-1 control-label">Extensi&oacute;n</label>
                                          <div class="col-lg-3">
										  	<input type="text" class="form-control" id="txtext"
                                            maxlength="10" placeholder="" onBlur="VerificarContactos()">
                                          </div>
                                          
                                          <label class="col-lg-1 control-label">*Correo:</label>
                                          <div class="col-lg-3">
											<input type="text" class="form-control" id="txtcorreo"
                                            placeholder="" onBlur="VerificarContactos()" maxlength="100">
                                          </div>
                                          </div>
                                          
                                     <div class="form-group">
                                         <label class="col-lg-1 control-label">*Tipo de Contacto:</label>
                                          <div class="col-lg-3">
											<select class="form-control" name="ddlTipoContacto"
                                            id="ddlTipoContacto" onChange="VerificarContactos()">
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
                                  
                         <!--Guardar Boton-->
                         
                        <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" class="btn btn-success" id="guardarCambios"
onclick="DesPreContactos(<?php echo $_SESSION['idPreCadena']; ?>)"
style="margin-top:10px;" disabled>
	Guardar
</button> 
</div>
                 
<!--Botones-->
<div class="col-lg-12 col-sm-12 col-xs-12">

<div class="pull-left">
	<a href="#" onClick="CambioPagina(2, existenCambios);">
		<img src="../../img/atras.png" id="atras">
	</a>
</div>                              



<div class="pull-right">
	<a href="#" onClick="CambioPagina(4, existenCambios);">
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
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCadena.js" type="text/javascript"></script>
<script src="../../inc/js/common-scripts.js"></script>