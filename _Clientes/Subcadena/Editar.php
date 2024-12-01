<?php 
#########################################################
#
#Codigo PHP
#
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");

$extra = "Consulta";
$submenuTitulo = "Subcadena";
$subsubmenuTitulo ="Editar Subcadena";
$tipoDePagina = "Escritura";
$idOpcion = 1;

if(!isset($_SESSION['Permisos'])){
	header("Location: ../../logout.php"); 
		exit(); 
}

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
		exit();
}

if(!isset($_POST['hidSubCadenaX']) || $_POST['hidSubCadenaX'] < 1){
	header("Location: ../../main.php"); 
		exit(); 
}

$HidSubCad = $_POST['hidSubCadenaX'];
$oSubcadena = new SubCadena($RBD, $WBD);
$Res = $oSubcadena->load($HidSubCad);

if($Res['codigoRespuesta'] > 0)
{
	echo "<script>alert('No existe esta Subcadena, lo vamos a redireccionar'); window.location.href ='../menuConsulta.php';</script>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<title>Consulta Subcadena</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Favicon-->
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="../../../img/favicon.ico" type="image/x-icon">

	<!-- N�cleo BOOTSTRAP -->
	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../../assets/opensans/open.css" rel="stylesheet" />
	<link href="../../css/style-responsive.css" rel="stylesheet" />
   
	<!-- ESTILOS MI RED -->
	<link href="../../css/miredgen.css" rel="stylesheet">
	<link href="../../css/style-responsive.css" rel="stylesheet" />
	<!--Estilos �nicos-->
	<link rel="stylesheet" type="text/css" href="../../assets/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" href="../../assets/data-tables/DT_bootstrap.css" />
	<link href="../../assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
	<link href="../../assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />    
	<link href="../../css/css.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css" />

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

</head>
<body>

<?php include("../../inc/cabecera2.php"); ?>
<?php include("../../inc/menu.php"); ?>

<section id="main-content">
<section class="wrapper site-min-height">
<div class="row">
<div class="col-lg-12">	
	<?php include("../../inc/formPase.php") ?>
	<section class="panel">
		<header class="panel-heading">Editar Sub Cadena <?php echo ((!preg_match('!!u', $oSubcadena->getNombre()))? utf8_encode($oSubcadena->getNombre()) : $oSubcadena->getNombre());?></header>
		<input type="hidden" name="txtNombreSubCad" id="txtNombreSubCad" <?php echo $oSubcadena->getNombre();?>/>
		<input type = "hidden" id="ddlGiro" value="<?php echo $oSubcadena->getGiro();?>"/>
		<div class="panel-body">
			<legend>Datos Generales</legend>
			<td align="left" valign="top">
				<div class="cuadro_id">
					<span class="texto_bold">ID SubCadena: </span><?php echo $oSubcadena->getId();?>
				</div>
			</td>

			<form class="form-horizontal">
				<div class="form-group">
					<label class="col-lg-1 control-label">Referencia:</label>
					<div class="col-lg-3">
						<select name="ddlReferencia" id="ddlReferencia" class="form-control m-bot15">
							<option value="-2">Selecciona Referencia</option>
							<?php
								$x =  $oSubcadena->getIdRef();
								$sql = "CALL `redefectiva`.`SP_LOAD_REFERENCIAS`();";      
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
					</div>

					<label class="col-lg-1 control-label"><!--Grupo:--></label>
					<div class="col-lg-3">
						<input type="hidden" name="ddlGrupo" id="ddlGrupo" value="<?php echo $oSubcadena->getGrupo()?>">
							<?php 
								/*$x =   $oSubcadena->getGrupo();
								$sql = "CALL `redefectiva`.`SP_LOAD_GRUPOS`();";
									$res = $RBD->SP($sql);
									if ( $res != NULL ) {
											$d = "";
											while ( $r = mysqli_fetch_array($res) ) {
													if ( $r[0] == $x )
															echo "<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
													else
															echo "<option value='$r[0]'>".utf8_encode($r[1])."</option>";
											}
									}*/
							 ?>
					</div>
				</div>

				<div class="form-group">  
					<label class="col-lg-1 control-label">Teléfono:</label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="" id="txtTelSub" value="<?php echo $oSubcadena->getTel1();?>" onkeyup="validaTelefono2(event,'txtTelSub')" onkeypress="return validaTelefono1(event,'txtTelSub')" maxlength="15" value="52-">
					</div>

					<label class="col-lg-1 control-label">Correo:</label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="" value="<?php echo $oSubcadena->getMail();?>" id="txtMailSub">
					</div>
				</div>

				<!--Cambio-->
				<div class="form-group">
					<label class="col-lg-1 control-label">Ejecutivo de Cuenta:</label>
					<div class="col-lg-3">
						<input type="hidden" id="ddlEjecutivo" value="<?php echo $oSubcadena->getIdEjecutivoCuenta();?>"/>
						<input type="text" class="form-control" placeholder="" id="txtEjecutivoCuenta" value="<?php echo ((!preg_match('!!u', $oSubcadena->getNombreEjecutivoCuentas()))? utf8_encode($oSubcadena->getNombreEjecutivoCuentas()): $oSubcadena->getNombreEjecutivoCuentas());?>">
					</div>

					<label class="col-lg-1 control-label">Ejecutivo de Venta:</label>
					<div class="col-lg-3">
						<input type="hidden" id="ddlEjecutivoVenta" value="<?php echo $oSubcadena->getIdEjecutivoVentas();?>"/>
						<input type="text" class="form-control" placeholder="" id="txtEjecutivoVenta" value="<?php echo $oSubcadena->getNombreEjecutivoVentas();?>">
					</div>
				</div>
				<!--Cambio-->

				<div class="form-group">
					<label class="col-lg-1 control-label">Estatus:</label>
					<div class="col-lg-3">
						<select name="ddlEstatus" id="ddlEstatus" class="form-control m-bot-especial">
							<?php
								$x =   $oSubcadena->getIdStatus();
								$sql = "CALL `redefectiva`.`SP_LOAD_ESTATUS`()";
								$result = $RBD->query($sql);

								while(list($id,$desc)= mysqli_fetch_row($result)){
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
					</div>
				</div>
			</form>
			<!--Versión-->
			<legend>Agregar Versión</legend>
			<form class="form-horizontal">
				<div class="form-group">
					<label class="col-lg-1 control-label">Agregar:</label>
					<div class="col-lg-3">
						<?php
							$idGrupo = $oSubcadena->getGrupo();
							$idCadena = $oSubcadena->getCadena();
							$idSubCadena = $oSubcadena->getId();

							//$sql = $RBD->query("CALL `redefectiva`.`SP_GET_VERSIONES_CADENA`($idGrupo, $idCadena, $idSubCadena, -1);");
							$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_VERSIONES`();");
							if(mysqli_num_rows($sql) > 0){
								$idV = (empty($oSubcadena->ID_VERSION))? 0 : $oSubcadena->getIdVersion();
						?>
						<input type="hidden" id="idVersionOriginal" value="<?php echo $idV?>"/>
						<select id="ddlVersion" class="form-control m-bot15">
							<option value="-1">Seleccione Versi&oacute;n</option>
							<?php
								$idVer = $oSubcadena->getIdVersion();

								while($row = mysqli_fetch_assoc($sql)){
									if($row["idVersion"] == $idVer){
										echo "<option value='".$row["idVersion"]."' selected='selected'>".$row["nombreVersion"]."</option>";
									}
									else{
										echo "<option value='".$row["idVersion"]."'>".$row["nombreVersion"]."</option>";
									}
								}
							?>
						</select>
						<?php
							}
							else{
								echo '<input type="hidden" id="idVersionOriginal" value="0"/>';
								echo '<select id="ddlVersion">';
								echo '<option value="-1">Seleccione</option>';
								echo '</select>';
							}
						?>
					</div>
				</div>
			</form>
			<!--Lista de Contactos-->
			<legend>Contactos</legend>
			<section id="no-more-tables">
				<table class="table table-bordered table-striped table-condensed cf">
					<thead class="cf">
						<tr>
							<th>Contacto</th>
							<th>Teléfono</th>
							<th>Extensión</th>
							<th>Correo</th>
							<th>Tipo de Contacto</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$qry = "CALL `redefectiva`.`SP_LOAD_CONTACTOS_GENERAL`($HidSubCad, 0, 2);";
							$res = $RBD->query($qry);
							if($res != NULL || $res != ""){
								while($contactResponsa = mysqli_fetch_array($res)){
							
						?>
							<tr>
								<td align="left" valign="middle">
									<?php echo ($res != NULL)?($contactResponsa["nombreCompleto"]):""?>
								</td>
								<td align="right" valign="middle">
									<?php echo ($res != NULL)?$contactResponsa["telefono1"]:""?>
								</td>
								<td align="right" valign="middle">
									<?php echo ($res != NULL)?$contactResponsa["extTelefono1"]:""?>
								</td>
								<td align="left" valign="middle">
									<?php echo ($res != NULL)?$contactResponsa["correoContacto"]:""?>
								</td>
								<td align="left" valign="middle">
									<?php echo ($res != NULL)?utf8_encode($contactResponsa["descTipoContacto"]):""?>
								</td>
								<td align="center" valign="middle">
									<img src="../../../img/edit.png"
										onclick="EditarContactos('<?php echo $contactResponsa[0]; ?>',
										'<?php echo $contactResponsa[1]; ?>',
										'<?php echo $contactResponsa[2]; ?>',
										'<?php echo $contactResponsa[3]; ?>',
										'<?php echo $contactResponsa[idcTipoContacto];?>',
										'<?php echo $contactResponsa[6]; ?>',
										'<?php echo $contactResponsa[5]; ?>',
										'<?php echo $contactResponsa[9]; ?>',event)">
									&nbsp;&nbsp;&nbsp;&nbsp;
									<img src="../../../img/delete.png" onclick="DeleteContactos(<?php echo $HidSubCad; ?>,<?php echo $contactResponsa['idContacto']; ?>,2)">
								</td>
							</tr>
						<?php 
								}
							}
						?>
					</tbody>
				</table>
			</section>

			<button type="button" class="btn btn-info btn-xs" onclick="AgregarContacto(event);">Nuevo</button>
			<div id="NewContacto" style="display:none;">
				<form class="form-horizontal" id="datos-generales">
					<input type="hidden" id="HidContacto" name="HidContacto" value="-2" />
					<div class="form-group">
						<label class="col-lg-1 control-label">Nombre(s):</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtContacNom">
						</div>

						<label class="col-lg-1 control-label">A.Paterno:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtContacAP">
						</div>

						<label class="col-lg-1 control-label">A.Materno:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtContacAM">
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-1 control-label">Teléfono:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtTelContac" onkeyup="validaTelefono2(event,'txtTelContac')" onkeypress="return validaTelefono1(event,'txtTelContac')" maxlength="15" value="52-">
						</div>

						<label class="col-lg-1 control-label">Extensión:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtExtTelContac" onkeyup="validaNumeroEntero2(event,'txtTelContac')" onkeypress="return validaNumeroEntero(event,'txtTelContac')" maxlength="15">
						</div>

						<label class="col-lg-1 control-label">Correo:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtMailContac">
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-1 control-label">Tipo de Contacto:</label>
						<div class="col-lg-3">
							<select name="ddlTipoContac" id="ddlTipoContac" class="form-control m-bot15">
								<option value="-2">Selecciona</option>
								<?php 
									$sql = "CALL `redefectiva`.`SP_LOAD_TIPOS_DE_CONTACTO`();";    
									$result = $RBD->SP($sql);

									while(list($id,$desc)= mysqli_fetch_row($result)){
										echo '<option value="'.$id.'">'.utf8_encode($desc).'</option>';                
									} 
									mysqli_free_result($result);
								?>
							</select>
						</div>
					</div>
				</form>
				<br>
				<button type="button" class="btn btn-info btn-xs" onclick="UpdateContactos(<?php echo $HidSubCad; ?>,2);">Agregar</button>
			</div>

			<legend>Cuenta Bancaria</legend>
			<section id="no-more-tables">
				<table class="table table-bordered table-striped table-condensed cf">
					<thead class="cf">
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
							<!--th>CLABE</th>
								<th>No. Cuenta</th>
								<th>Banco</th>
								<th>Beneficiario</th>
								<th>RFC</th>
								<th>Tipo de Pago</th>
								<th>Acciones</th-->
						</tr>
					</thead>
					<tbody>
						<?php
							$idCadena = $oSubcadena->getCadena();
							$idSubCadena = $oSubcadena->getId();
							$q = "CALL `redefectiva`.`SP_GET_CUENTAS`($idCadena, $idSubCadena, -1, -1, '');";
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

				<a href="#ModalCuentaBancaria" data-toggle="modal" class="btn btn-info btn-xs">
					Nueva Cuenta
				</a>
			</section>

			<!--Inicia Modal-->
			<div class="modal fade" id="ModalCuentaBancaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Agregar Cuenta</h4>
						</div>

						<div class="modal-body">
							<legend>Configuración de Liquidación</legend>
							<form class="form-horizontal">

								<div class="form-group">
									<label class="col-lg-1 control-label">Tipo de Movimiento:</label>
									<div class="col-lg-3">
										<select id="ddlTipoMovimiento" class="form-control m-bot15">
											<!--option value="-1">Seleccione</option-->
											<!--option value="0">Cobro</option-->
											<option value="1">Pago</option>
										</select>
									</div>

									<label class="col-lg-1 control-label">Tipo de Instrucción:</label>
									<div class="col-lg-3">
										<div id="selectInstruccion">
											<select id="ddlInstruccion" class="form-control m-bot15">
												<option value="-1">Seleccione</option>
											</select>
										</div>
									</div>

									<label class="col-lg-1 control-label">Destino:</label>
									<div class="col-lg-3">
										<select id="ddlDestino" class="form-control m-bot15">
											<option value="-1">Seleccione</option>
											<option value="0">Forelo</option>
											<option value="1">Banco</option>
										</select>
									</div>
								</div>

								<div id="fieldsBanco" style="display:none;">
									<legend>Cuenta</legend>

									<div class="form-group">
										<label class="col-lg-1 control-label">CLABE:</label>
										<div class="col-lg-3">
											<input type="text" class="form-control" placeholder="" id="txtCLABE">
										</div>
									</div>

									<div class="form-group">
										<label class="col-lg-1 control-label">Banco:</label>
										<div class="col-lg-3">
											<input type="text" class="form-control" placeholder="" id="txtBanco">
										</div>

										<label class="col-lg-1 control-label">No. Cuenta:</label>
										<div class="col-lg-3">
											<input type="text" class="form-control" placeholder="" id="txtCuenta"/>
											<input type="hidden" class="form-control" placeholder="" id="txtNumCuenta" value="<?php echo $oSubcadena->getCuentaForelo();?>">
											<input type="hidden" class="form-control" placeholder="" id="txtNumCuentaForelo" value="<?php echo $oSubcadena->getCuentaForelo();?>">
										</div>
									</div>

									<div class="form-group">
										<label class="col-lg-1 control-label">Beneficiario:</label>
										<div class="col-lg-3">
											<?php
												$idRep = $oSubcadena->getIdRepresentateLegal();
												$repLegal = ($idRep > 0)? $oSubcadena->getNombreRepresentanteLegal() : "";
											?>
											<input type="text" class="form-control" placeholder="" id="txtBeneficiario" value="<?php echo $repLegal;?>">
										</div>

										<label class="col-lg-1 control-label">RFC:</label>
										<div class="col-lg-3">
											<?php
												$rfc = ($idRep > 0)? $oSubcadena->getRFCRepresentanteLegal() : "";
											?>
											<input type="text" class="form-control" placeholder="" id="txtRFC" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $rfc;?>">
										</div>

										<label class="col-lg-1 control-label">Correo:</label>
										<div class="col-lg-3">
											<input type="text" class="form-control" placeholder="" id="txtCorreo">
										</div>
									</div>
								</div>
							</form>
						</div>

						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
							<button class="btn btn-success" type="button" onclick="crearConfEd()" id="guardarCambios">Agregar</button>
						</div>
					</div>
				</div>
			</div>
			<!--Termina-->
			<legend></legend>

			<div class="modal-footer">
				<!--button class="btn btn-success" type="button" onclick="UpdateSubCadena(<?php echo $HidSubCad; ?>,4,2)">Guardar</button-->
				<button data-dismiss="modal" class="btn btn-success" type="button" onclick="returnListado1();">Regresar</button>
				<button data-dismiss="modal" class="btn btn-default" type="button" onclick="UpdateSubCadena(<?php echo $HidSubCad; ?>,4,2)">Guardar</button>

			</div>
<!--Cierre-->
		</div>
	</section>
</div>
</div>
</section>
</section>


<script src="../../inc/js/jquery.js"></script>
<script src="../../css/ui/jquery.ui.core.js"></script>
<script src="../../css/ui/jquery.ui.widget.js"></script>
<script src="../../css/ui/jquery.ui.position.js"></script>
<script src="../../css/ui/jquery.ui.menu.js"></script>
<script src="../../css/ui/jquery.ui.autocomplete.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Fechas-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--script src="../../inc/js/advanced-form-components.js"></script-->
<!--Tabla-->
<script src="../../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../../assets/data-tables/DT_bootstrap.js"></script>

<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_Clientes.js" type="text/javascript"></script>
<script src="../../inc/js/_Consulta.js" type="text/javascript"></script>
<script src="../../inc/js/_ConsultaCadena.js" type="text/javascript"></script>
<script src="../../inc/js/_ConsultaSubCadena.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>

<script>
	$(function(){
		cargarTiposInstruccion();
	});

</script>

</body>

</html>