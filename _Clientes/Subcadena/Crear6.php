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
<title>.::Mi Red::. Pre Alta de Sub Cadena</title>
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
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/RE.js"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js"></script>
<script src="../../inc/js/_PrealtaPreSubCadena.js"></script>
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
                        	<img src="../../img/6a.png" id="paso6Actual">
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
                  <form class="form-horizontal">
                             <div class="legend-big"><i class="fa fa-credit-card"></i> Cuenta</div>  
                             <div class="form-group">
                             
                             <label class="col-lg-1 control-label">*CLABE:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtCLABE"
                                              onkeydown="analizarCLABE(event)"
                                              onkeyup="analizarCLABE(event)"
                                              maxlength="18"
                                              placeholder=""
                                              value="<?php
                                              	$CLABE = $oSubcadena->getClabe();
												if ( !preg_match('!!u', $CLABE) ) {
													$CLABE = utf8_encode($CLABE);
												}
												if ( isset($CLABE) && $CLABE != "" ) {
													echo $CLABE;
												}
											  ?>" >
                                          </div>
                                          </div>
                                          
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">*Banco:</label>
                                          <div class="col-lg-3">
                                       		<select class="form-control m-bot15" id="ddlBanco" disabled>
                                              <option value="-1">Seleccione Banco</option>
												<?php
                                                $idBanco = $oSubcadena->getIdBanco();
                                                $sql = "CALL `redefectiva`.`SP_LOAD_BANCOS`();";
                                                $res = $RBD->SP($sql);
                                                if($res != ''  && mysqli_num_rows($res) > 0){
                                                    while($r = mysqli_fetch_array($res)){
                                                        if ( $r[0] == $idBanco ) {
                                                            echo "<option value='$r[0]' selected='selected'>$r[1]</option>";
                                                        } else {
                                                            echo "<option value='$r[0]'>$r[1]</option>";
                                                        }
                                                    }
                                                }
                                                ?>
                                          	</select>
                                          </div>
                                          
                                         
                                          <label class="col-lg-1 control-label">*No.Cuenta:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtCuenta" placeholder=""
                                              maxlength="11"
                                              value="<?php
											  	$numeroDeCuenta = $oSubcadena->getNumCuenta();
											  	if ( !preg_match('!!u', $numeroDeCuenta) ) {
													//no es utf-8
													$numeroDeCuenta = utf8_encode($numeroDeCuenta);
												}
												if ( isset($numeroDeCuenta) && $numeroDeCuenta != "" ) {
													echo $numeroDeCuenta;
												}
                                              ?>" disabled>
                                          </div>
                                          </div>
                                          
                                          
                                          <div class="form-group">
                                          <label class="col-lg-1 control-label">*Beneficiario:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtBeneficiario" placeholder=""
                                              onkeypress="validarCamposPaso6()"
                                              onkeyup="validarCamposPaso6()"
                                              value="<?php
											  	$razonSocial = $oSubcadena->getBeneficiario();
												if ( !isset($razonSocial) || $razonSocial == "" ) {
													$razonSocial = $oSubcadena->getCRSocial();
												}
												if ( !preg_match('!!u', $razonSocial) ) {
													//no es utf-8
													$razonSocial = utf8_encode($razonSocial);
												}
												if ( isset($razonSocial) && $razonSocial != "" ) {
													echo $razonSocial;
												}
											  ?>" maxlength="200">
                                          </div>
                                      
                                      
                                       <label class="col-lg-1 control-label">Descripci&oacute;n:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtDescripcionCuenta" placeholder=""
                                              onkeypress="validarCamposPaso6()"
                                              onkeyup="validarCamposPaso6()"
                                              value="<?php
                                              	$descripcion = $oSubcadena->getDescripcion();
												if ( !preg_match('!!u', $descripcion) ) {
													//no es utf-8
													$descripcion = utf8_encode($descripcion);
												}
												echo $descripcion;
											  ?>"
                                              maxlength="30">
                                          </div>
                                      </div>
                                      </form>
                                        
<!--Botones Finales-->
<!--Botones-->

  <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" class="btn btn-success" style="margin-top:10px;"
onclick="EditarCuentaBancoSubCadena()" id="guardarCambios" disabled>
	Guardar
</button> 
</div>
<!--Botones-->
<div class="col-lg-12 col-sm-12 col-xs-12">
<div class="pull-left">
<a href="#" onClick="CambioPagina(5, existenCambios);">
	<img src="../../img/atras.png" width="30" height="30" id="atras">
</a>
</div>                              


<div class="pull-right">
<a href="#" onClick="CambioPagina(7, existenCambios);">
	<img src="../../img/adelante.png" width="30" height="30" id="adelante">
</a>
</div>                               
</div>
<!--Cierre Botones-->
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
<!--Elector de Fecha-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Com�n-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>