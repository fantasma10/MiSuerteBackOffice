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
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCorresponsal.js" type="text/javascript"></script>
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
<h3><?php echo $oCorresponsal->getNombre(); ?></h3><span class="rev-combo pull-right">Pre Alta<br>Corresponsal</span></div>
                          
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
                        	<img src="../../img/4a.png" id="paso4Actual">
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
             
                  
                  <form class="form-horizontal">
                             <div class="legend-big"><i class="fa fa-credit-card"></i> Cuenta</div>  
                             <div class="form-group">
                             <label class="col-lg-1 control-label">*FORELO:</label>
                               <div class="col-lg-3">
                                       <select class="form-control m-bot15" id="tipoFORELO" onChange="desplegarCamposDeCuenta();verificarCamposCuenta();">
                                       	<?php
											$tipoFORELO = $oCorresponsal->getTipoFORELO();
											switch ( $tipoFORELO ) {
												case 1:
													echo "<option value=\"-1\">Seleccione tipo de FORELO</option>";
													echo "<option value=\"1\" selected=\"selected\">Compartido</option>";
													echo "<option value=\"2\">Individual</option>";
												break;
												case 2:
													echo "<option value=\"-1\">Seleccione tipo de FORELO</option>";
													echo "<option value=\"1\">Compartido</option>";
													echo "<option value=\"2\" selected=\"selected\">Individual</option>";													
												break;
												default:
													echo "<option value=\"-1\">Seleccione tipo de FORELO</option>";
													echo "<option value=\"1\">Compartido</option>";
													echo "<option value=\"2\">Individual</option>";												
												break;
											}
										?>
                                       </select>
                                          </div>
                                          </div>
                                         
                             
                             <div class="form-group" <?php echo ($tipoFORELO == 1 || $tipoFORELO == "")? "style=\"display:none;\"" : ""; ?> id="divCLABE">
                             <label class="col-lg-1 control-label">*CLABE:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control"
                                              id="txtCLABE"
                                              onkeyup="analizarCLABE();verificarCamposCuenta();"
                                              onkeypress="analizarCLABE();verificarCamposCuenta();"
                                              placeholder=""
                                              value="<?php
                                              	if ( $tipoFORELO == 2 ) {
													$CLABE = $oCorresponsal->getClabe();
													if ( !preg_match('!!u', $CLABE) ) {
														$CLABE = utf8_encode($CLABE);
													}
													if ( isset($CLABE) && $CLABE != "" ) {
														echo $CLABE;
													}
												}
											  ?>">
                                          </div>
                                          </div>
                                          
                                          <div class="form-group" <?php echo ($tipoFORELO == 1 || $tipoFORELO == "")? "style=\"display:none;\"" : ""; ?> id="divBanco">
                                          <label class="col-lg-1 control-label">*Banco:</label>
                                          <div class="col-lg-3">
                                       		<select class="form-control m-bot15" id="ddlBanco" disabled>
                                              <option value="-1">Seleccione Banco</option>
												<?php
                                                if ( $tipoFORELO == 2 ) {
													$idBanco = $oCorresponsal->getIdBanco();
												}
                                                $sql = "CALL `redefectiva`.`SP_LOAD_BANCOS`();";
                                                $res = $RBD->SP($sql);
                                                if($res != ''  && mysqli_num_rows($res) > 0){
                                                    while($r = mysqli_fetch_array($res)){
                                                        if ( !preg_match('!!u', $r[1]) ) {
															//no es utf-8
															$r[1] = utf8_encode($r[1]);
														}
														if ( $tipoFORELO == 2 ) {
															if ( $r[0] == $idBanco ) {
																echo "<option value='$r[0]' selected='selected'>$r[1]</option>";
															} else {
																echo "<option value='$r[0]'>$r[1]</option>";
															}
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
                                              <input type="text" class="form-control" id="txtCuenta"
                                              placeholder=""
                                              value="<?php
											    if ( $tipoFORELO == 2 ) {
													$numeroDeCuenta = $oCorresponsal->getNumCuenta();
													if ( !preg_match('!!u', $numeroDeCuenta) ) {
														//no es utf-8
														$numeroDeCuenta = utf8_encode($numeroDeCuenta);
													}
													if ( isset($numeroDeCuenta) && $numeroDeCuenta != "" ) {
														echo $numeroDeCuenta;
													}
												}                                            
											  ?>"
                                              disabled>
                                          </div>
                                          </div>
                                          
                                          
                                          <div class="form-group" <?php echo ($tipoFORELO == 1 || $tipoFORELO == "")? "style=\"display:none;\"" : ""; ?> id="divBeneficiario">
                                          <label class="col-lg-1 control-label">*Beneficiario:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtBeneficiario" placeholder=""
                                              onkeypress="verificarCamposCuenta()"
                                              onkeyup="verificarCamposCuenta()"
                                              value="<?php
											  	if ( $tipoFORELO == 2 ) {
													$razonSocial = $oCorresponsal->getBeneficiario();
													if ( !isset($razonSocial) || $razonSocial == "" ) {
														$razonSocial = $oCorresponsal->getCRSocial();
													}
													if ( !preg_match('!!u', $razonSocial) ) {
														//no es utf-8
														$razonSocial = utf8_encode($razonSocial);
													}
													if ( isset($razonSocial) && $razonSocial != "" ) {
														echo $razonSocial;
													}
												}                                          
											  ?>">
                                          </div>
                                      
                                      
                                       <label class="col-lg-1 control-label">Descripci&oacute;n:</label>
                                          <div class="col-lg-3">
                                              <input type="text" class="form-control" id="txtDescripcionCuenta" placeholder=""
                                              onkeypress="verificarCamposCuenta()"
                                              onkeyup="verificarCamposCuenta()"
                                              maxlength="30"
                                              value="<?php
											  	if ( $tipoFORELO == 2 ) {
													$descripcion = $oCorresponsal->getDescripcion();
													if ( !preg_match('!!u', $descripcion) ) {
														//no es utf-8
														$descripcion = utf8_encode($descripcion);
													}
													echo $descripcion;
												}                                             
											  ?>">
                                          </div>
                                      </div>
                                      </form>
                                      <br>
                                      
                                       <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
                                          <button type="button" class="btn btn-success" id="guardarCambios" onClick="EditarCuentaBancoSubCadena();" style="margin-top:10px;" disabled>
                                            Guardar
                                          </button> 
                                          </div>



                                     <div class="col-lg-12 col-sm-12 col-xs-12">
                                          <div class="pull-left">
                                            <a href="#" onClick="CambioPagina(3, false);">
                                                <img src="../../img/atras.png" id="atras">
                                              </a>
                                          </div>

                                         
                                          <div class="pull-right">
                                            <a href="#" onClick="CambioPagina(5, false);">
                                                <img src="../../img/adelante.png" id="adelante">
                                              </a>
                                          </div>
                                        </div>

                                        </div>

<!--Botones-->
<!--button class="btn btn-medio" type="button"
id="guardarCambios"
onclick="EditarCuentaBancoSubCadena()" disabled>
	Guardar
</button>
<div class="prealta-footer">
<button class="btn btn-default" type="button"
onClick="CambioPagina(5, false)">
	Adelante
</button>
<button class="btn btn-success" type="button"
onClick="CambioPagina(3, false)">
	Atrás
</button-->


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
<!--Elector de Fecha-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Común-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>