<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");

$extra = "Consulta";
$submenuTitulo = "Corresponsal";
$subsubmenuTitulo ="Editar Corresponsal";
$idOpcion = 1;
$tipoDePagina = "Escritura";

if(!isset($_SESSION['Permisos'])){
	header("Location: ../../logout.php"); 
		exit(); 
}

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../error.php"); 
		exit();	
}

if(!isset($_POST['hidCorresponsalX']) || $_POST['hidCorresponsalX'] == -1){
	header("Location: ../../main.php"); 
		exit(); 
}
$idPermiso = (isset($_SESSION['Permisos']['Tipo'][0]))?$_SESSION['Permisos']['Tipo'][$posicionPermisoSubSeccion]:1;
$HidCor = $_POST['hidCorresponsalX'];

$oCorresponsal = new Corresponsal($RBD, $WBD);
$oCorresponsal->load($HidCor);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
		<title>Consulta Corresponsal</title>
		<link href="../../css/bootstrap.css" rel="stylesheet">
		<link href="../../css/tm_docs.css" rel="stylesheet">
		<link href="../../css/RE-CSS.css" rel="stylesheet" type="text/css" />
		<link href="../../css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css" />
		<link rel="stylesheet" href="../../css/demos.css" />
		<link href="../../css/bootstrapDataPicker2.css" rel="stylesheet"/>
		<link href="../../css/css.css" rel="stylesheet" type="text/css" />

		<!-- N�cleo BOOTSTRAP -->
		<link href="../../css/bootstrap.min.css" rel="stylesheet">
		<link href="../../css/bootstrap-reset.css" rel="stylesheet">
		<!--ASSETS-->
		<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<!-- ESTILOS MI RED -->
		<link href="../../css/miredgen.css" rel="stylesheet">
		<link href="../../css/style-responsive.css" rel="stylesheet" />
		<!--Estilos �nicos-->
		<link rel="stylesheet" type="text/css" href="../../assets/bootstrap-datepicker/css/datepicker.css" />
		<link rel="stylesheet" href="../../assets/data-tables/DT_bootstrap.css" />
		<link href="../../assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
		<link href="../../assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />    
		<link href="../../css/css.css" rel="stylesheet" type="text/css" />

	<style>
		.ui-autocomplete-loading {
			background: white url('../../img/loadAJAX.gif') right center no-repeat;
		}
		.ui-autocomplete {
			max-height	: 190px;
			overflow-y	: auto;
			overflow-x	: hidden;
			font-size	: 12px;
		}
	</style>  
		
		<script>
		<?php 
			$paisZ = $oCorresponsal->getIdPais();
			if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
		?>
		var tipoDireccion = "nacional";
		<?php } else { ?>
		var tipoDireccion = "extranjera";
		<?php } ?>	
	</script>
</head>
<body>
	
<?php include("../../inc/cabecera2.php"); ?>
<?php include("../../inc/menu.php"); ?>

<section id="main-content">
<section class="wrapper site-min-height">
<div class="row">
<div class="col-lg-12">
		<br />
	<?php include("../../inc/submenu.php"); ?>
	<?php include("../../inc/formPase.php"); ?>
		<br />
		<br />
		<div class="cuadro_contenido">
				<div class="sombra_superior"></div>
				<div class="area_contenido" style="padding:0px 20px 0px 20px; width:100%; float:left;">	
						<div class="botones_busqueda">
								<div class="area_resultado">
									<table width="100%" border="0" cellspacing="0" cellpadding="2">
										<tr>
											<td align="left" valign="top"><span class="subtitulo_contenido">Datos Generales</span><br />
												<br />
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
		
												<tr>
													<td align="left" valign="top"><div class="cuadro_id"><span class="texto_bold">ID Corresponsal:</span> <input type="text" id="idCorresponsal" value="<?php echo $oCorresponsal->getId(); ?>"><input type="hidden" name="hidCorresponsal" id="hidCorresposal" /></div></td>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
												</tr>
												<tr>
													<td width="33%" align="left" valign="top" class="texto_bold">Nombre:</td>
													<td width="33%" align="left" valign="top" class="texto_bold">1er. Tel&eacute;fono:</td>
													<td width="34%" align="left" valign="top" class="texto_bold">2do. Tel&eacute;fono:</td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id="nombrecor"><?php  echo $oCorresponsal->getNombreCor(); ?></div></td>
													<td align="left" valign="top"><div id="tel1"><?php  echo $oCorresponsal->getTel1(); ?></div></td>
													<td align="left" valign="top"><div id="tel2"><?php  echo $oCorresponsal->getTel2(); ?></div></td>
												</tr>
												<tr>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txtnomcor" id="txtnomcor" value="<?php  echo $oCorresponsal->getNombreCor(); ?>" /></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txttel1" id="txttel1" onkeyup="validaTelefono2(event,'txttel1')" onkeypress="return validaTelefono1(event,'txttel1')" maxlength="15" value="<?php  echo $oCorresponsal->getTel1(); ?>"/></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txttel2" id="txttel2" onkeyup="validaTelefono2(event,'txttel2')" onkeypress="return validaTelefono1(event,'txttel2')" maxlength="15" value="<?php  echo $oCorresponsal->getTel2(); ?>"/></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold">Fax:</td>
													<td align="left" valign="top" class="texto_bold">Correo:</td>
													<td align="left" valign="top" class="texto_bold">Fecha Vencimiento:</td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id="fax"><?php  echo $oCorresponsal->getFax(); ?></div></td>
													<td align="left" valign="top"><div id="mail"><?php  echo $oCorresponsal->getMail(); ?></div></td>
													<td align="left" valign="top"><div id="fechavencimiento"><?php echo $oCorresponsal->getFechaVencimiento(); ?></div></td>
												</tr>
												<tr>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txtfax" id="txtfax" onkeyup="validaTelefono2(event, 'txtfax')"
																	onkeypress="return validaTelefono1(event, 'txtfax')" value="" maxlength="15" /></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txtmail" id="txtmail" /></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txtFechaVen" id="txtFechaVen" onkeypress="return validaFecha(event,'txtFechaVen')" onkeyup="validaFecha2(event,'txtFechaVen')" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $oCorresponsal->getFechaVencimiento(); ?>"/></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top"><span class="texto_bold">Fecha de Inicio:</span></td>
													<td align="left" valign="top"><span class="texto_bold">Fecha 1era. Operaci&oacute;n:</span></td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">2013-01-01</td>
													<td align="left" valign="top">2013-01-01</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="3" align="left" valign="top"><div class="separador"></div></td>
													</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold">Giro:</td>
													<td align="left" valign="top" class="texto_bold">Referencia:</td>
													<td align="left" valign="top" class="texto_bold">Estatus:</td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id="nombregiro"><?php  echo utf8_encode($oCorresponsal->getNombreGiro()); ?></div></td>
													<td align="left" valign="top"><div id="nombreref"><?php  echo $oCorresponsal->getNombreReferencia(); ?></div></td>
													<td align="left" valign="top"><div id="status" <?php echo ($oCorresponsal->getStatus() == "Baja")? "style=\"color:#FF0000;font-weight:bold;\"" : ""; ?>><?php  echo $oCorresponsal->getStatus(); ?></div></td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td>
																<select name="ddlGiro" id="ddlGiro">
																<option value="-1">Seleccione un Giro</option>
																	<?php
																		$idGiro = $oCorresponsal->getGiro();
																		$sql = "CALL `prealta`.`SP_LOAD_GIROS`();";
																		$res = $RBD->SP($sql);

																		if($RBD->error() == ''){
																			if($res != '' && mysqli_num_rows($res) > 0){
																				while($r = mysqli_fetch_array($res)){
																					if($idGiro == $r[0]){
																						echo "<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
																					}
																					else{
																						echo "<option value='$r[0]'>".utf8_encode($r[1])."</option>";
																					}
																				}
																			}
																		}
																	?>
																</select>
															</td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top" class="texto_bold"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><!--<input type="text" name="txtreferencia" id="txtreferencia" /></td>-->
																<select name="ddlReferencia" id="ddlReferencia">
																	<option value="-2">Selecciona Referencia</option>
																	<?php
																		$x =  $oCorresponsal->getIdRef();
																		$sql = "CALL `prealta`.`SP_LOAD_REFERENCIAS`();";      
																		$result = $RBD->SP($sql);

																		while ($row = mysqli_fetch_assoc($result)){
																			$id = $row["idReferencia"];
																			$desc = $row["nombreReferencia"];
																			if($id == $x){
																				echo ('<option value="'.$id.'" selected="selected">'.utf8_encode($desc).'</option>');
																			}
																			else{
																				echo ('<option value="'.$id.'">'.utf8_encode($desc).'</option>');
																			}
																		}

																		mysqli_free_result($result);
																	?>
																</select>
													      </td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top" class="texto_bold"><table width="100" border="0" cellspacing="0" cellpadding="6">
															<tr>
																<td><select name="ddlEstatus" id="ddlEstatus" onchange="/*UpdateCorresponsal(8);*/">
																	<option value="0">Activo</option>
																	<option value="1">Pendiente</option>
					<option value="2">Suspendido</option>
					<option value="3">Baja</option>
					<option value="4">Bloqueado</option>
																</select></td>
																<td>&nbsp;</td>
														</tr>
														</table></td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold">Corresponsal Bancario:</td>
													<td align="left" valign="top" class="texto_bold">Usuario Alta:</td>
													<td align="left" valign="top" class="texto_bold"><!--Ejecutivo de Venta:--></td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id='corbanc'><?php echo $oCorresponsal->getEstatusBancario(); ?></div></td>
													<td align="left" valign="top"><div id="usuarioalta"><?php  echo $oCorresponsal->getNombreUsuarioAlta(); ?></div></td>
													<td align="left" valign="top"><div id="ejecutivoventa"><?php //echo utf8_encode($oCorresponsal->getNombreEjecutivoVenta()); ?></div></td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold"><table width="100" border="0" cellspacing="0" cellpadding="6">
															<tr>
																<td><select name="ddlCorBanc" id="ddlCorBanc" onchange="/*UpdateCorresponsal(9)*/;">
																	<option value="0">Activo</option>
																	<option value="1">Pendiente</option>
																	<option value="2">Suspendido</option>
																	<option value="3">Baja</option>
																</select></td>
																<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top" class="texto_bold"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txtusuarioalta" value="<?php  echo $oCorresponsal->getNombreUsuarioAlta(); ?>" id="txtusuarioalta" /></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top" class="texto_bold"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><!--input type="text" name="txtejecutivoventa" value="<?php echo utf8_encode($oCorresponsal->getNombreEjecutivoVenta()); ?>" id="txtejecutivoventa" /--></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
													<td align="left" valign="top" class="texto_bold">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold">Representante Legal:</td>
													<td align="left" valign="top" class="texto_bold">Ejecutivo de Cuenta</td>
													<td align="left" valign="top" class="texto_bold">Ejecutivo de Venta</td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id="replegal"><?php echo utf8_encode($oCorresponsal->getNombreRepLegal()); ?></div></td>
													<td align="left" valign="top"><?php echo $oCorresponsal->getNombreEjecutivoCuenta();?></td>
													<td align="left" valign="top"><?php echo $oCorresponsal->getNombreEjecutivoVenta();?></td>
												</tr>
												<tr>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
															<tr>
																<td>
																	<input type="hidden" id="ddlRepLegal" value="<?php echo $oCorresponsal->getIdRepLegal();?>"/>
																	<input type="text" name="txtreplegal" id="txtreplegal" value="<?php echo utf8_encode($oCorresponsal->getNombreRepLegal()); ?>" />
																</td>
																<td>&nbsp;</td>
															</tr>
														</table></td>
													<td align="left" valign="top">
														<input type="hidden" id="ddlEjecutivo" value="<?php echo $oCorresponsal->getIdEjecutivoCuenta();?>"/>
														<input type="text" placeholder="" id="txtEjecutivoCuenta" value="<?php echo $oCorresponsal->getNombreEjecutivoCuenta();?>">
													</td>
													<td align="left" valign="top">
														<input type="hidden" id="ddlEjecutivoVenta" value="<?php echo $oCorresponsal->getIdEjecutivoVenta();?>"/>
														<input type="text" placeholder="" id="txtEjecutivoVenta" value="<?php echo $oCorresponsal->getNombreEjecutivoVenta();?>">
													</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top" class="texto_bold">IVA</td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td>
														<select id="ddlIva">
															<option value="-1">Seleccione IVA</option>
															<?php
																$idIva = $oCorresponsal->getIdIva();
																$sql = $RBD->query("CALL `prealta`.`SP_LOAD_IVA`();");
																while($row = mysqli_fetch_assoc($sql)){
																	if($row["idIva"] == $idIva){
																		echo "<option value='".$row['idIva']."' selected='selected'>".$row['descIva']."</option>";
																	}
																	else{
																		echo "<option value='".$row['idIva']."'>".$row['descIva']."</option>";
																	}
																}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="3" align="left" valign="top"><div class="separador"></div></td>
												</tr>
												<tr>
													<td align="left" valign="top"><span class="texto_bold">Direcci&oacute;n:</span></td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="3" align="left" valign="top"><div id="dircompleta">
								<?php
															echo utf8_encode($oCorresponsal->getDireccion())." ".$oCorresponsal->getDirNExt()." ".$oCorresponsal->getDirNInt();
							?>
														<br />
														<?php
															echo "Col. ".utf8_encode($oCorresponsal->getColonia())." C.P. ".$oCorresponsal->getCodigoPostal()
							?>
														<br />
														<?php
															echo utf8_encode($oCorresponsal->getMunicipio()).", ".utf8_encode($oCorresponsal->getEstado()).", ".utf8_encode($oCorresponsal->getPais());
							?>
														</div>
													</td>
													</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top"><span class="texto_bold">Pa&iacute;s:</span></td>
													<td align="left" valign="top"><span class="texto_bold"></span></td>
													<td align="left" valign="top"><span class="texto_bold"></span></td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id='calle'><?php echo utf8_encode($oCorresponsal->getPais()); ?></div></td>
													<td align="left" valign="top"><div id='nexte'></div></td>
													<td align="left" valign="top"><div id='ninte'></div></td>
												</tr>
												<tr>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td>
																<div id="selectpaises">
																	<input type="text" placeholder="" id="cPais">
	                  										<input type="hidden" id="ddlPais" value="<?php echo $oCorresponsal->getIdPais();?>">
																		<!--select name="ddlPais" id='ddlPais' onchange="cambiarPantalla();VerificarDireccionSub(tipoDireccion);">
																			<option value="-2" selected="selected">Seleccione un Pais</option>
																			<?php
																					$paisZ = $oCorresponsal->getIdPais();
																					if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
																							$tipoDireccion = "nacional";
																					} else {
																							$tipoDireccion = "extranjera";
																					}
																					$sql = "CALL `prealta`.`SP_LOAD_PAISES`();";
																					$res = $RBD->SP($sql);
																					if($RBD->error() == ''){
																							if($res != '' && mysqli_num_rows($res) >0){
																									while($r = mysqli_fetch_array($res)){
																										$r[1] = utf8_encode($r[1]);
																											if($paisZ == $r[0])
																													echo "<option value='$r[0]' selected='selected'>$r[1]</option>";
																											else
																													echo "<option value='$r[0]'	>$r[1]</option>"; 
																									}
																							}
																							
																					}
																			?>
																		</select-->
																</div>
															</td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top"></td>
													<td align="left" valign="top"></td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top"><span class="texto_bold">Calle:</span></td>
													<td align="left" valign="top"><span class="texto_bold">N&uacute;mero Exterior:</span></td>
													<td align="left" valign="top"><span class="texto_bold">N&uacute;mero Interior:</span></td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id='colonia'><?php echo utf8_encode($oCorresponsal->getCalle()); ?></div></td>
													<td align="left" valign="top"><div id='pais'><?php echo $oCorresponsal->getDirNExt2(); ?></div></td>
													<td align="left" valign="top"><div id='estado'><?php echo $oCorresponsal->getDirNInt2(); ?></div></td>
												</tr>
												<tr>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td>
								<input type="text" name="txtcalle" id="txtcalle"
																onblur="VerificarDireccionSub(tipoDireccion);"  value="<?php echo utf8_decode($oCorresponsal->getCalle()); ?>" />                              </td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top"><span class="texto_bold">
														</span>
														<table width="100" border="0" cellspacing="0" cellpadding="6">
															<tr>
																<td><span class="texto_bold">
									<input type="text" name="txtnext" id="txtnext"
																		onblur="VerificarDireccionSub(tipoDireccion);"  value="<?php echo $oCorresponsal->getDirNExt2(); ?>" />                                   
																</span></td>
																<td>&nbsp;</td>
															</tr>
														</table>                        </td>
													<td align="left" valign="top"><span class="texto_bold">
														</span>
														<table width="100" border="0" cellspacing="0" cellpadding="6">
															<tr>
																<td><span class="texto_bold">
																<div id="divEdo">
									<input type="text" name="txtnint" id="txtnint"
																		onblur="VerificarDireccionSub(tipoDireccion);"
																		value="<?php echo $oCorresponsal->getDirNInt2(); ?>" />
																</div>
																</span>                                </td>
																<td>&nbsp;</td>
															</tr>
														</table>                        </td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top"><span class="texto_bold">C.P.:</span></td>
													<td align="left" valign="top"><span class="texto_bold">Colonia:</span></td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id="municipio"><?php echo $oCorresponsal->getCodigoPostal(); ?></div></td>
													<td align="left" valign="top"><div id="cp"><?php echo utf8_encode($oCorresponsal->getColonia()); ?></div></td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top"><span class="texto_bold">
														</span>
														<table width="100" border="0" cellspacing="0" cellpadding="6">
															<tr>
																<td><span class="texto_bold">
																<!--div id="divCd"-->
																<div>
																		<input type="text" name="txtcp"
																		id="txtcp" maxlength="5"
																		onblur="VerificarDireccionSub(tipoDireccion);"
																		onkeyup="buscarColonias()" value="<?php echo $oCorresponsal->getCodigoPostal(); ?>" />                                  
																</div>
																<!--div id="divCol" style="display:none;"></div-->
																</span>                                </td>
																<td>&nbsp;</td>
															</tr>
														</table>                        </td>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td>
																<div id="divCol" >
									<?php
																				$colZ = $oCorresponsal->getIdColonia();
																				$cdZ = $oCorresponsal->getIdCiudad();
																				$edoZ = $oCorresponsal->getIdEstado();
																				$paisZ = $oCorresponsal->getIdPais();
																				if ( $tipoDireccion == "nacional" ) {
																						echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
																										onchange=\"VerificarDireccionCorr(tipoDireccion);\"
																										style=\"display:block;\">";
																				} else {
																						echo "<select name=\"ddlColonia\" id=\"ddlColonia\"
																										onchange=\"VerificarDireccionCorr(tipoDireccion);\"
																										style=\"display:none;\">";													
																				}
																				$sql2 = "CALL `prealta`.`SP_LOAD_COLONIAS`(164, '$edoZ', '$cdZ');";
																				$res = $RBD->SP($sql2);
																				$d = "";
																				if($res != NULL){
																						$d = "<option value='-2'>Seleccione una Colonia</option>";
																						while($r = mysqli_fetch_array($res)){
																								$r[1] = utf8_encode($r[1]);
												if($colZ == $r[0])
																										$d.="<option value='$r[0]' selected='selected'>$r[1]</option>";
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
																								} else {
																										$nombreColoniaExtranjera = "";
																								}
																						}
																				}
																				if ( $tipoDireccion == "nacional" ) {
																						echo "<input type=\"text\" style=\"display:none;\"
																						onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																						name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\" />";
																				} else if( $tipoDireccion == "extranjera" ) {
																						echo "<input type=\"text\" style=\"display:block;\"
																						onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																						name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\" />";													
																				}
																		?>
																</div>
															</td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top"><span class="texto_bold">Estado:</span></td>
													<td align="left" valign="top"><span class="texto_bold">Ciudad:</span></td>
												</tr>
												<tr>
													<td align="left" valign="top"><?php echo utf8_encode($oCorresponsal->getEstado()); ?></td>
													<td align="left" valign="top"><?php echo utf8_encode($oCorresponsal->getCiudad()); ?></td>
												</tr>
												<tr>
													<td align="left" valign="top">
														<table width="100" border="0" cellspacing="0" cellpadding="6">
															<tr>
																	<td>
																			<div id="divEdo">
											<?php
																						$paisZ = $oCorresponsal->getIdPais();
																						$edoZ = $oCorresponsal->getIdEstado();
																						if ( $tipoDireccion == "nacional" ) {
																								echo "<select name=\"ddlEstado\" id=\"ddlEstado\"
																												onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																												onchange=\"setValue('ddlPais',164); buscaSelectCiudad(false)\"
																												style=\"display:block;\"
																												>";																
																						} else {
																								echo "<select name=\"ddlEstado\" id=\"ddlEstado\"
																												onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																												onchange=\"setValue('ddlPais',164); buscaSelectCiudad(false)\"
																												style=\"display:none;\"
																												>";																	
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
													$r[1] = utf8_encode($r[1]);
																										if ( $edoZ == $r[0] )
																												$d.="<option value='$r[0]' selected='selected'>$r[1]</option>";
																										else
																												$d.="<option value='$r[0]'	>$r[1]</option>";   
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
																										} else {
																												$nombreEstadoExtranjero = "";
																										}
																								}																
																						}
																						if ( $tipoDireccion == "nacional" ) {
																								echo "<input type=\"text\"
																										onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																										style=\"display:none;\" name=\"txtEstado\"
																										id=\"txtEstado\" value=\"$nombreEstadoExtranjero\" />";																
																						} else if ( $tipoDireccion == "extranjera" ) {
																								echo "<input type=\"text\"
																										onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																										style=\"display:block;\" name=\"txtEstado\"
																										id=\"txtEstado\" value=\"$nombreEstadoExtranjero\" />";																
																						}
																						?>
																				</div>
																		</td>
																	<td>&nbsp;</td>
																</tr>
														</table>                          </td>
													<td align="left" valign="top">
							<table width="100" border="0" cellspacing="0" cellpadding="6">
															<tr>
																	<td>
																	<div id="divCd">
																		<?php
																			$cdZ = $oCorresponsal->getIdCiudad();
																			$edoZ = $oCorresponsal->getIdEstado();
																			$paisZ = $oCorresponsal->getIdPais();
																			if ( $tipoDireccion == "nacional" ) {
																					echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\"
																					onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																					style=\"display:block;\"
																					disabled=\"disabled\">";														
																			} else if ( $tipoDireccion == "extranjera" ) {
																					echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\"
																					onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																					style=\"display:none;\"
																					disabled=\"disabled\">";															
																			}													
																			$sql2 = "CALL `prealta`.`SP_LOAD_CIUDADES`(164, '$edoZ');";
																			$res = $RBD->SP($sql2);
																			$d = "";
																			if ( $res != NULL ) {
																					$d = "<option value='-2'>Seleccione un Cd</option>";
																					while ($r = mysqli_fetch_array($res) ) {
																							$r[1] = utf8_encode($r[1]);
																							if ( $cdZ == $r[0] )
																									$d.="<option value='$r[0]' selected='selected'>$r[1]</option>";
																							else	
																									$d.="<option value='$r[0]'	>$r[1]</option>";   
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
																							} else {
																									$nombreCiudadExtranjera = "";
																							}
																					}														
																			}
																			if ( $tipoDireccion == "nacional" ) {
																					echo "<input type=\"text\"
																									onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																									name=\"txtMunicipio\" id=\"txtMunicipio\"
																									style=\"display:none;\"
																									value=\"$nombreCiudadExtranjera\" />";	
																			} else if ( $tipoDireccion == "extranjera" ) {
																					echo "<input type=\"text\"
																									onblur=\"VerificarDireccionCorr(tipoDireccion);\"
																									name=\"txtMunicipio\" id=\"txtMunicipio\"
																									style=\"display:block;\"
																									value=\"$nombreCiudadExtranjera\" />";															
																			}
																		?>
																	</div>
																	</td>
																	<td>&nbsp;</td>
																</tr>
														</table>                          </td>
												</tr>
												<tr>
													<td colspan="3" align="left" valign="top"><div class="separador"></div></td>
													</tr>
												<tr>
													<td align="left" valign="top"><span class="texto_bold">Nombre de Sucursal:</span></td>
													<td align="left" valign="top"><span class="texto_bold">N&uacute;mero de Sucursal:</span></td>
													<td align="left" valign="top" class="texto_bold"></td>
												</tr>
												<tr>
													<td align="left" valign="top"><div id="nomsuc"><?php echo $oCorresponsal->getNomSucursal(); ?></div></td>
													<td align="left" valign="top"><div id="numsuc"><?php echo $oCorresponsal->getNumSucursal(); ?></div></td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txtnombresucursal" id="txtnombresucursal" value="<?php echo $oCorresponsal->getNomSucursal(); ?>"/></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top"><table width="100" border="0" cellspacing="0" cellpadding="6">
														<tr>
															<td><input type="text" name="txtnumerosucursal" id="txtnumerosucursal" value="<?php echo $oCorresponsal->getNumSucursal(); ?>"/></td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
													<td align="left" valign="top">			  </td>
												</tr>
												
												<tr>
													<td colspan="3" align="left" valign="top"><div class="separador"></div></td>
													</tr>
		
												<tr>
													<td align="left" valign="top" class="subtitulo_contenido">Lista de Contactos</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="3">
														<table width="69%" border="0" cellpadding="3" cellspacing="0" class="borde_tabla_contactos">
														<tr>
															<td align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Contacto</span></td>
															<td width="16%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tipo de Contacto</span></td>
															<td width="23%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Correo</span></td>
															<td width="22%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tel&eacute;fono</span></td>
															<td width="10%" align="center" valign="middle" class="borde_tabla_contactos_titulos1">&nbsp;</td>
														</tr>
														<?php
															$idSubCadena = $oCorresponsal->getIdSubCadena();
															$sql = "CALL redefectiva.`SP_LOAD_CONTACTOS_GENERAL`($idSubCadena, 0, 2);";									
															$res = $RBD->SP($sql);
															if($res != NULL || $res != ""){
																$cont = 0;
																while($contactResponsa = mysqli_fetch_array($res)){
																	if($cont%2 == 0){
																		$cls = "borde_tabla_contactos_int_responsable";
																	}
																	else{
																		$cls="borde_tabla_contactos_int";
																	}
																	$cont++;	
														?>
															<tr>
																<td width="23%" align="center" valign="middle" class="<?php echo $cls;?>">
																	<?php echo ($res != NULL)?($contactResponsa["nombreCompleto"]):""?>
																</td>
																<td width="31%" align="center" valign="middle" class="<?php echo $cls;?>">
																	<?php echo ($res != NULL)?utf8_encode($contactResponsa["descTipoContacto"]):""?>
																</td>
																<td width="24%" align="center" valign="middle" class="<?php echo $cls;?>">
																	<?php echo ($res != NULL)?$contactResponsa["correoContacto"]:""?>
																</td>
																<td width="22%" align="center" valign="middle" class="<?php echo $cls;?>">
																	<?php echo ($res != NULL)?$contactResponsa["telefono1"]:""?>
																</td>
																<td align="center" valign="middle">
																	<a onclick="agregarContactoDeSubCadena('<?php echo $contactResponsa["idContacto"]?>', '<?php echo $HidCor;?>');">Agregar</a>
																</td>
															</tr>
														<?php 
																}
															}
														?>
														</table>
													</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="3" align="center" valign="middle">
													
													<div id="divRES">
														<table width="69%" border="0" cellpadding="3" cellspacing="0" class="borde_tabla_contactos">
															<tr>
																<td align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Contacto</span></td>
																<td width="16%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tipo de Contacto</span></td>
																<td width="23%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Correo</span></td>
																<td width="22%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tel&eacute;fono</span></td>
																<td width="10%" align="center" valign="middle" class="borde_tabla_contactos_titulos1">&nbsp;</td>
															</tr>
															<?php
																//$sql = "CALL `prealta`.`SP_LOAD_CONTACTOS`(6, $HidCor);";
																$sql = "CALL redefectiva.`SP_LOAD_CONTACTOS_GENERAL`($HidCor, 0, 3);";									
																$res = $RBD->SP($sql);
																if($res != NULL || $res != ""){
																	$cont = 0;
																	while($contactResponsa = mysqli_fetch_array($res)){
																		if($cont%2 == 0){
																			$cls = "borde_tabla_contactos_int_responsable";
																		}
																		else{
																			$cls="borde_tabla_contactos_int";
																		}
																		$cont++;	
															?>
																<tr>
																	<td width="23%" align="center" valign="middle" class="<?php echo $cls;?>">
																		<?php echo ($res != NULL)?($contactResponsa["nombreCompleto"]):""?>
																	</td>
																	<td width="31%" align="center" valign="middle" class="<?php echo $cls;?>">
																		<?php echo ($res != NULL)?utf8_encode($contactResponsa["descTipoContacto"]):""?>
																	</td>
																	<td width="24%" align="center" valign="middle" class="<?php echo $cls;?>">
																		<?php echo ($res != NULL)?$contactResponsa["correoContacto"]:""?>
																	</td>
																	<td width="22%" align="center" valign="middle" class="<?php echo $cls;?>">
																		<?php echo ($res != NULL)?$contactResponsa["telefono1"]:""?>
																	</td>
																	<td width="10%" align="center" valign="middle" class="<?php echo $cls;?>">						
																		<table border="0" cellspacing="0" cellpadding="3">
																			<tr>
																				<td align="center" valign="middle">
																					<?php
																						if($contactResponsa["subcadena"] == 0){
																					?>
																					<a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image24-<?php echo $contactResponsa[0]; ?>','','../../img/btn_ico_editar2.png',1)"
																						onclick="EditarContactos('<?php echo $contactResponsa["idContacto"]; ?>',
																						'<?php echo $contactResponsa["nombreContacto"]; ?>',
																						'<?php echo $contactResponsa["apPaternoContacto"]; ?>',
																						'<?php echo utf8_encode($contactResponsa["apMaternoContacto"]); ?>',
																						'<?php echo utf8_encode($contactResponsa["idcTipoContacto"])?>',
																						'<?php echo $contactResponsa["telefono1"]; ?>',
																						'<?php echo $contactResponsa["correoContacto"]; ?>',
																						'<?php echo $contactResponsa["extTelefono1"]?>',event)">
																						<img src="../../img/btn_ico_editar1.png" name="Image24-<?php echo $contactResponsa[0]; ?>" width="23" height="23" border="0" id="Image24-<?php echo $contactResponsa[0]; ?>" />
																					</a>
																					<?php
																						}
																					?>
																				</td>
																				<td align="center" valign="middle">
																					<a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image33-<?php echo $contactResponsa[0]; ?>','','../../img/btn_borrar2.png',1)" onclick="DeleteContactos(<?php echo $HidCor; ?>,<?php echo $contactResponsa[0]; ?>,3)"><img src="../../img/btn_borrar1.png" name="Image33-<?php echo $contactResponsa[0]; ?>" width="23" height="23" border="0" id="Image33-<?php echo $contactResponsa[0]; ?>" /></a></td>
																			</tr>
																		</table>                                  </td>
																</tr>
																
																<?php 
								}}
									?>
													</table>
													</div>                          </td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="center" valign="middle"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image13','','../../img/btn_agregar1.png',1)" onclick="AgregarContacto(event);"><img src="../../img/btn_agregar1.png" name="Image13" width="106" height="31" border="0" id="Image13" /></a></td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="center" valign="middle">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="center" valign="middle">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="3">
										<div id="NewContacto" style="display:none;">
											<input type="hidden" id="HidContacto" name="HidContacto" value="-2" />
											<table width="100%">
													<tr>
														<td align="left" valign="top"  width="33%">&nbsp;</td>
														<td align="center" valign="middle"  width="33%">&nbsp;</td>
														<td align="left" valign="top"  width="34%">&nbsp;</td>
													 </tr>
													 <tr>
														<td align="left" valign="middle"><span class="texto_bold">Nombre de Contacto:</span></td>
														<td align="left" valign="middle"><span class="texto_bold">Apellido Paterno:</span></td>
														<td align="left" valign="middle"><span class="texto_bold">Apellido Materno:</span></td>
													 </tr>
													 <tr>
														<td align="left" valign="top"><input type="text" name="txtContacNom" id="txtContacNom" /></td>
														<td align="left" valign="top"><input type="text" name="txtContacAP" id="txtContacAP" /></td>
														<td align="left" valign="top"><input type="text" name="txtContacAM" id="txtContacAM" /></td>
													 </tr>
													 <tr>
														<td align="left" valign="top">&nbsp;</td>
														<td align="left" valign="top">&nbsp;</td>
														<td align="left" valign="top">&nbsp;</td>
													 </tr>
													 <tr>
														<td align="left" valign="top"><span class="texto_bold">Teléfono:</span></td>
														<td align="left" valign="top"><span class="texto_bold">Extensión:</span></td>
														<td align="left" valign="top"><span class="texto_bold">Correo:</span></td>
													 </tr>
													 <tr>
														<td align="left" valign="top"><input type="text" name="txtTelContac" id="txtTelContac" onkeyup="validaTelefono2(event,'txtTelContac')" onkeypress="return validaTelefono1(event,'txtTelContac')" maxlength="15" value="52-"/></td>
														<td align="left" valign="top"><input type="text" name="txtTelContac" id="txtExtTelContac" onkeyup="validaNumeroEntero2(event,'txtTelContac')" onkeypress="return validaNumeroEntero(event,'txtTelContac')" maxlength="15" /></td>
														<td align="left" valign="top"><input type="text" name="txtMailContac" id="txtMailContac" /></td>
													 </tr>
													 <tr>
														<td align="left" valign="top"><span class="texto_bold">Tipo de Contacto:</span></td>
													 </tr>
													 <tr>
														<td align="left" valign="top">
														<table width="235" border="0" cellspacing="0" cellpadding="6">
														  <tr>
															 <td width="159">
															 <select name="ddlTipoContac" id="ddlTipoContac">
																<option value="-2" selected>Selecciona</option>
																<?php 
																	 $sql = "CALL `prealta`.`SP_LOAD_TIPOS_DE_CONTACTO`();";    
																	 $result = $RBD->SP($sql);
																	 
																	 while(list($id,$desc)= mysqli_fetch_row($result))
																	 {
																		 echo '<option value="'.$id.'">'.utf8_encode($desc).'</option>';                
																	 } 
																	 mysqli_free_result($result);
															 ?>
															 </select>
															 </td>
															 <td width="21"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image211','','../../img/btn_ver_mas2.png',1)" onclick="UpdateContactos(<?php echo $HidCor; ?>,3);"><img src="../../img/btn_ver_mas1.png" name="Image211" width="21" height="21" border="0" id="Image211" /></a></td>
														  </tr>
														</table>
														</td>
													 </tr>
												</table>
										  
										  </div>
									 </td>
													
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
			<tr>
											<td colspan="3" align="left" valign="top"><div class="separador"></div></td>
											</tr>
			<tr>
				<?php
					$lbl = (!$oCorresponsal->esBancario())? "No cuenta con " : "";
				?>
				<td align="left" valign="top"><span class="subtitulo_contenido"><?php echo $lbl;?>Corresponsal&iacute;a Bancaria</span></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
			</tr>
			
			
			<tr>
											<td colspan="3" align="left" valign="top">
			<br />
			
			<table width="600" height="282" border="0" align="center" cellpadding="5" cellspacing="0" class="borde_tabla_contactos">
													<tr>
														<td width="30%" height="280" align="left" valign="top" bgcolor="#F0F5FB" class="borde_tabla_contactos_titulos2">
															<div id="divcorrbanc" style='margin-top: 20px;margin-right: 10px;'></div>
														</td>
														<td width="70%" align="left" valign="top" class="borde_tabla_contactos_titulos1">
															<?php
																$idVersion = $oCorresponsal->getIdVer();
																$sql = $RBD->query("CALL `redefectiva`.`SP_BUSCA_FAMILIA_VERSION`($idVersion, 3)");

																$res = mysqli_fetch_assoc($sql);

																if($res['cuenta'] > 0){
															?>
															<table width="100%" border="0" cellspacing="0" cellpadding="3">
																<tr>
																	<td align="center" valign="middle">&nbsp;</td>
																</tr>
																<tr>
																	<td align="center" valign="middle"><span class="texto_bold">Banco</span></td>
																</tr>
																<tr>
																	<td align="center" valign="middle">
																		<span class="texto_bold">
																			<!--select name='ddlBanco' id="ddlBanco" onchange="getSelDiv();window.setTimeout('AutoActividadBanco()',150)" style='width: 200px;'-->
																			<select name='ddlBanco' id="ddlBanco" style='width: 200px;'>
																				<option value='-1'>Seleccione</option>
																					<?php
																						$idCorresponsal = $oCorresponsal->getId();
																						$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_CORRESPONSALIAS`($idCorresponsal)");
																						while($row = mysqli_fetch_assoc($sql)){
																							echo "<option value='".$row['idBanco']."'>".utf8_encode($row['descBanco'])."</option>";
																						}
																					?>
																			</select>
																		</span>
																	</td>
																</tr>
																<tr>
																	<td align="center" valign="middle">&nbsp;</td>
																</tr>
																<tr>
																	<td align="center" valign="middle"><span class="texto_bold"><!--Actividad--></span></td>
																</tr>
																<tr>
																	<td align="center" valign="middle"><!--input name="txtactbanc" type="text" id="txtactbanc" style='width: 200px;'/--></td>
																</tr>
																<tr>
																	<td align="center" valign="middle">&nbsp;</td>
																</tr>
																<tr>
																	<td align="center" valign="middle"><span class="texto_bold"><!--Divisi&oacute;n Geogr&aacute;fica--></span></td>
																</tr>
																<tr>
																	<td height="37" align="center" valign="middle">
																		<span class="texto_bold">
																			<div id="selectdivision">
																			<!--select name="ddlEntDiv" id="ddlEntDiv" style='width: 200px;'>
																			</select-->
																			</div>
																		</span>
																	</td>
																</tr>
																<tr>
																	<td height="37" align="center" valign="middle"><a href="#" onclick="agregarCorresponsaliaBanc(<?php echo $oCorresponsal->getId(); ?>);"  onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image238','','../../img/btn_ver_mas2.png',1)"><img src="../../img/btn_ver_mas1.png" name="Image238" width="21" height="21" border="0" id="Image238" /></a></td>
																</tr>
															</table>
															<?php
																}
															?>
														</td>
													</tr>
			</table>
			
												</td>
											</tr>
										<tr>
											<td align="left" valign="top">&nbsp;</td>
											<td align="left" valign="top">&nbsp;</td>
											<td align="left" valign="top">&nbsp;</td>
										</tr>
										<tr>
											<td align="left" valign="top">&nbsp;</td>
											<td align="left" valign="top">&nbsp;</td>
											<td align="left" valign="top">&nbsp;</td>
										</tr>
				
				
				
				
												<tr>
													<td colspan="3" align="left" valign="top"><div class="separador"></div></td>
													</tr>
												<tr>
													<td align="left" valign="top"><span class="subtitulo_contenido">Horario</span></td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="3" align="left" valign="top">
														<?php echo $oCorresponsal->getHorarioEditar(); ?>
													</td>
													</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="center" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image15','','../../img/btn_guardar2.png',1)" onclick="UpdateHorariosCorr(<?php echo $HidCor; ?>)"><img src="../../img/btn_guardar1.png" alt="" name="Image15" width="106" height="31" border="0" id="Image15" /></a></td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td colspan="3" align="left" valign="top"><div class="separador"></div></td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="center" valign="middle">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top" colspan="3">
														<span class="subtitulo_contenido">Cuentas Bancarias</span>
														<?php
															$idCadena		= $oCorresponsal->getIdCadena();
															$idSubCadena	= $oCorresponsal->getIdSubCadena();
															$idCorresponsal= $oCorresponsal->getId();

															$sql = $RBD->query("CALL `redefectiva`.`SP_BUSCA_CUENTAS_CORRESPONSAL`($idCadena, $idSubCadena, $idCorresponsal)");
															$row = mysqli_fetch_assoc($sql);
															if($row["categoria_cuenta"] == 3){
														?>
														<table>
															<thead>
																<tr>
																	<th>Tipo de Movimiento</th>
																	<th>Tipo de Pago</th>
																	<th>Destino</th>
																	<th>Banco</th>
																	<th>CLABE</th>
																	<th>Beneficiario</th>
																	<th>RFC</th>
																	<th>Correo</th>
																	<th>Acciones</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$q = "CALL `redefectiva`.`SP_GET_CUENTAS`($idCadena, $idSubCadena, $idCorresponsal, -1, '');";
																	$sql = $RBD->query($q);

																	$cont = 0;
																	while($row = mysqli_fetch_assoc($sql)){
																		if($cont%2 == 0){
																			$cls = "borde_tabla_contactos_int_responsable";
																		}
																		else{
																			$cls="borde_tabla_contactos_int";
																		}
																		$cont++;
																		echo "<tr>";
																			echo "<td>".$row['tipoMovimiento']."</td>";
																			echo "<td>".$row['tipoDePago']."</td>";
																			echo "<td>".$row['Destino']."</td>";
																			echo "<td>".$row['nombreBanco']."</td>";
																			echo "<td>".$row['CLABE']."</td>";
																			echo "<td>".$row['Beneficiario']."</td>";
																			echo "<td>".$row['RFC']."</td>";
																			echo "<td>".$row['Correo']."</td>";
																			echo "<td><img src='../../../img/delete.png' onclick='DeleteConfiguracionCuenta(".$row['idConfiguracion'].")'></td>";
																		echo "</tr>";
																		//<img src='../../../img/edit.png'>&nbsp;&nbsp;&nbsp;&nbsp;
																	}
																?>
															</tbody>
														</table>
														<?php
															}
														?>
													</td>
													<td align="center" valign="middle">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="center" valign="middle">&nbsp;</td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
												<tr>
													<td align="left" valign="top">&nbsp;</td>
													<td align="center" valign="middle">
														<a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image44','','../../img/btn_regresar2.png',1)" onclick="returnListado1();">
															<img src="../../img/btn_regresar1.png" name="Image44" width="106" height="31" border="0" id="Image44" />                            </a>
														<a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image15','','../../img/btn_guardar2.png',1)"></a>
														<a href="#" onmouseout="MM_swapImgRestore()"
														onmouseover="MM_swapImage('Image99','','../../img/btn_guardar2.png',1)"
														onclick="UpdateCorresponsal(<?php echo $HidCor; ?>,3)">
																<img src="../../img/btn_guardar1_.png" name="Image99" width="106" height="31" border="0" id="Image99" />                            </a>                          </td>
													<td align="left" valign="top">&nbsp;</td>
												</tr>
											</table></td>
										</tr>
									</table>
								</div>
							</div>
						<div id="daniel"></div>
						<div id="divRES" class="divRES centrar"></div>
				</div>
				<div class="sombra_inferior" style="float:left; margin-top:0px;"></div>
		</div>



<div id="base" style="visibility: visible;"></div>
<div id="base4" style='visibility: visible;min-width: 900px;'>
		<div style="width:100%; float:left;">
				<div style="float:right;">
						<a id="cerrar" class="cerrarX"></a>
				</div>
				<div id="NomCorPopUp" style='float: left;'>Detalle Deposito</div>
		</div>
		<div id="ContentPopUp" class="contenido_detalle contenidoPopUp"></div>
</div>


<div id='emergente'>
	<img alt='Cargando...' src='../../img/cargando3.gif' id='imgcargando' />
</div>
</div>
</div>
</section>
</section>

<script>
	//window.setTimeout("AutoRepLegal()",100);
	window.setTimeout("AutoEjecutivoVenta()",100);
	window.setTimeout("AutoUsuarioAlta()", 100);
	window.setTimeout("AutoCalleDir()",200);
	window.setTimeout("AutoColoniaDir()",300);
	//window.setTimeout("AutoActividadBanco()",400)
	//window.setTimeout("getSelDiv()",500);
	window.setTimeout("getBancosCorresponsaliaBancaria()",600);
</script>

<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<!--script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script-->
<script src="../../inc/js/respond.min.js" ></script>
<!--Fechas-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Tabla-->
<script src="../../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../../assets/data-tables/DT_bootstrap.js"></script>

<script src="../../css/ui/jquery.ui.core.js"></script>
<script src="../../css/ui/jquery.ui.widget.js"></script>
<script src="../../css/ui/jquery.ui.position.js"></script>
<script src="../../css/ui/jquery.ui.menu.js"></script>
<script src="../../css/ui/jquery.ui.autocomplete.js"></script>

<script src="../../inc/js/bootstrap-datepicker2.js"></script>

<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_Clientes.js" type="text/javascript"></script>
<script src="../../inc/js/_Consulta.js" type="text/javascript"></script>
<script src="../../inc/js/_ConsultaCorresponsal.js" type="text/javascript"></script>
<script src="../../inc/js/_Clientes2.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.tablesorter.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>

</body>

</html>