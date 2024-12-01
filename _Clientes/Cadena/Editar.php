<?php
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");

$extra = "Consulta";
$submenuTitulo = "Cadena";
$subsubmenuTitulo ="Editar Cadena";
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

if(!isset($_POST['hidCadenaX']) || $_POST['hidCadenaX'] == -1){
	header("Location: ../../main.php"); 
	 exit(); 
}	

$HidCad = $_POST['hidCadenaX'];

$oCadena 		= new Cadena($RBD, $WBD);
$oCadena->load($HidCad);

$HidCad = $_POST['hidCadenaX'];
$Hruta 	= $_POST['hRutaX'];
$Hparametros	= isset($_POST['hParametrosX'])?$_POST['hParametrosX']:"";



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<title>Consulta Cadena</title>

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

	<link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css" />
	<link rel="stylesheet" href="../../css/demos.css" />

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

</head>
<body>
	
<?php include("../../inc/cabecera2.php"); ?>
<?php include("../../inc/menu.php"); ?>

<section id="main-content">
<section class="wrapper site-min-height">
<div class="row">
<div class="col-lg-12">
	<?php include("../../inc/formPase.php"); ?>
	<section class="panel">
		<header class="panel-heading">Editar Cadena <?php echo utf8_encode($oCadena->getNombre());?></header>
		<div class="panel-body">
			<legend>Datos Generales</legend>

			<input type="hidden" id="ddlGiro" value="<?php echo $oCadena->getGiro();?>">
			<input type="hidden" name="txtNombreCadena" id="txtNombreCadena" value="<?php echo utf8_encode($oCadena->getNombre()); ?>"/>

			<td align="left" valign="top">
				<div class="cuadro_id">
					<span class="texto_bold">ID Cadena: </span><?php echo $oCadena->getId();?>
				</div>
			</td>
			<form class="form-horizontal">
				<div class="form-group">
					<label class="col-lg-1 control-label">Referencia:</label>
					<div class="col-lg-3">
						<select class="form-control m-bot15" id="ddlReferencia">
						<option value="-2">Selecciona Referencia</option>
						<?php 
							$x =  $oCadena->getIdRef();
							$sql = "CALL `redefectiva`.`SP_LOAD_REFERENCIAS`();";      
							$result = $RBD->SP($sql);

							while ($row = mysqli_fetch_assoc($result)){
								$id		= $row["idReferencia"];
								$desc	= $row["nombreReferencia"];
								if ($id == $x){
									echo('<option value="'.$id.'" selected="selected">'.utf8_encode($desc).'</option>');                
								}
								else{
									echo('<option value="'.$id.'">'.utf8_encode($desc).'</option>');                
								}
							}
							mysqli_free_result($result);
						?>
						</select>
					</div>

					<label class="col-lg-1 control-label">Grupo:</label>
					<div class="col-lg-3">
						<input type="hidden" id="idGrupoOriginal" value="<?php echo $oCadena->getGrupo()?>"/>
						<select class="form-control m-bot15" id="ddlGrupo">
							<option value="-1">Seleccione Grupo</option>
							<?php 
								$x = $oCadena->getGrupo();
								$sql = "CALL `redefectiva`.`SP_LOAD_GRUPOS`();";
								$res = $RBD->SP($sql);
								
								if($res != NULL){
									$d = "";
									while($r = mysqli_fetch_array($res)){
										if($r[0] == $x){
											echo "<option value='$r[0]' selected='selected'>".utf8_encode($r[1])."</option>";
										}
										else{
											echo "<option value='$r[0]'>".utf8_encode($r[1])."</option>";
										}
									}/* while */
								}
							?>
						</select>
					</div>
				</div>

				<div class="form-group">  
					<label class="col-lg-1 control-label">Teléfono:</label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="" id="txtTelCadena" onkeyup="validaTelefono2(event,'txtTelCadena')" onkeypress="return validaTelefono1(event,'txtTelCadena')" maxlength="15" value="<?php echo $oCadena->getTel1(); ?>">
					</div>

					<label class="col-lg-1 control-label">Correo:</label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="" id="txtCorreo" value="<?php echo $oCadena->getMail();?>">
					</div>
				</div>
				<!--Cambio-->
				<div class="form-group">
				<label class="col-lg-1 control-label">Ejecutivo de Cuenta:</label>
				<div class="col-lg-3">
					<input type="hidden" id="ddlEjecutivo" value="<?php echo $oCadena->getIdEjecutivoCuenta();?>"/>
					<input type="text" class="form-control" placeholder="" id="txtEjecutivoCuenta" value="<?php echo utf8_encode($oCadena->getNombreEjecutivoCuentas());?>">
				</div>

				<label class="col-lg-1 control-label">Ejecutivo de Venta:</label>
				<div class="col-lg-3">
					<input type="hidden" id="ddlEjecutivoVenta" value="<?php echo $oCadena->getIdEjecutivoVenta();?>"/>
					<input type="text" class="form-control" placeholder="" id="txtEjecutivoVenta" value="<?php echo utf8_encode($oCadena->getNombreEjecutivoVentas());?>">
				</div>
				</div>
				<!--Cambio-->

				<div class="form-group">
					<label class="col-lg-1 control-label">Estatus:</label>
					<div class="col-lg-3">
						<select class="form-control m-bot-especial" id="ddlEstatus">
							<?php
								$x = $oCadena->getIdStatus();
								$sql = "CALL `redefectiva`.`SP_LOAD_ESTATUS`();";
								$result = $RBD->SP($sql);

								while(list($id,$desc)= mysqli_fetch_row($result)){
									if($id == $x){
										echo ('<option value="'.$id.'" selected="selected">'.$desc.'</option>');								
									}
									else{
										echo ('<option value="'.$id.'">'.$desc.'</option>');								
									}
								}/* while */
								mysqli_free_result($result);
							?>
						</select>
					</div>
				</div>
			</form>

			<legend>Agregar Versión</legend>
			<div class="row">
				<div class="col-lg-4">
					<div class="td-consultabold">Version(es):</div>
					<table>
						<?php
							$versiones = trim($oCadena->getVersiones(), ',');

							if(!empty($versiones)){
								$arrVer = explode(",", $versiones);

								foreach($arrVer AS $version){
									$v = explode("-", $version);
									$idGrupo = $oCadena->getGrupo();
									$idCadena = $oCadena->getId();
									$idVersion = $v[0];

									echo "<tr><td>".htmlentities($v[1])."</td><td><img src='../../../img/eliminar.png' onclick='eliminarVersion(".$idGrupo.",".$idCadena.", ".$idVersion.")'></td></tr>";
								}
							}
						?>
					</table>
				</div>
				<div class="col-lg-8">
					<form class="form-horizontal">
						<label class="col-lg-2 control-label">Agregar:</label>
						<div class="col-lg-4">
							<?php
								$idGrupo = $oCadena->getGrupo();
								$sql = $RBD->query("CALL `redefectiva`.`SP_GET_VERSIONES_GRUPO`($idGrupo, $HidCad, -1, -1);");
								$show = false;
								if(mysqli_num_rows($sql) > 0){
									$show = true;
							?>
							<select id="ddlVersion" class="form-control m-bot15">
								<option value="-1">Seleccione Versi&oacute;n</option>
								<?php
									while($row = mysqli_fetch_assoc($sql)){
										echo "<option value='".$row["idVersion"]."'>".$row["nombreVersion"]."</option>";
									}
								?>
							</select>
							<?php
								}
							?>
						</div>
					</form>
					<div class="col-xs-1">
						<?php
							if($show == true){
						?>
						<img src="../../../img/add.png" onclick="agregarVersion('<?php echo $idGrupo?>', '<?php echo $HidCad;?>', -1, -1)">
						<?php
							}
						?>
					</div>
				</div>
			</div>

			<br>
			<br>
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
						$sql = "CALL `redefectiva`.`SP_LOAD_CONTACTOS_GENERAL`($HidCad, 0, 1);";
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
								<td align="left" valign="middle">
									<?php echo ($res != NULL)?($contactResponsa["nombreCompleto"]):""?>
								</td>
								<td align="center" valign="middle">
									<?php echo ($res != NULL)?$contactResponsa["telefono1"]:""?>
								</td>
								<td align="center" valign="middle">
									<?php echo ($res != NULL)?$contactResponsa["extTelefono1"]:""?>
								</td>
								<td align="center" valign="middle">
									<?php echo ($res != NULL)?$contactResponsa["correoContacto"]:""?>
								</td>
								<td align="center" valign="middle">
									<?php echo ($res != NULL)?utf8_encode($contactResponsa["descTipoContacto"]):""?>
								</td>
								<td>
									<img src="../../../img/edit.png" onclick="EditarContactos('<?php echo $contactResponsa[0]; ?>','<?php echo $contactResponsa[1]; ?>','<?php echo $contactResponsa[2]; ?>','<?php echo $contactResponsa[3]; ?>','<?php echo $contactResponsa["idcTipoContacto"]?>','<?php echo $contactResponsa["6"]; ?>','<?php echo $contactResponsa[5]; ?>','<?php echo $contactResponsa[9]; ?>',event)">
									&nbsp;&nbsp;&nbsp;&nbsp;
									<img src="../../../img/delete.png" onclick="DeleteContactos(<?php echo $HidCad; ?>,<?php echo $contactResponsa['idContacto']; ?>,1)">
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
				<form class="form-horizontal" id="datos-generales" >
					<input type="hidden" id="HidContacto" name="HidContacto" value="-2" />
					<div class="form-group" >
						<label class="col-lg-1 control-label">Nombre(s):</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtContacNom" onkeypress="return validaCadenaConAcentos(event);">
						</div>

						<label class="col-lg-1 control-label">A.Paterno:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtContacAP" onkeypress="return validaCadenaConAcentos(event);">
						</div>

						<label class="col-lg-1 control-label">A.Materno:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtContacAM" onkeypress="return validaCadenaConAcentos(event);">
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-1 control-label">Teléfono:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtTelContac" onkeyup="validaTelefono2(event,'txtTelContac')" onkeypress="return validaTelefono1(event,'txtTelContac')" maxlength="15" value="52-">
						</div>

						<label class="col-lg-1 control-label">Extensión:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtExtTelContac" onkeyup="validaNumeroEntero2(event,'txtTelContac')" onkeypress="return validaNumeroEntero(event,'txtTelContac')">
						</div>


						<label class="col-lg-1 control-label">Correo:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" placeholder="" id="txtMailContac">
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-1 control-label">Tipo de Contacto:</label>
						<div class="col-lg-3">
							<select class="form-control m-bot15" id="ddlTipoContac">
							<option value="-2" selected>Selecciona</option>
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

				<button type="button" class="btn btn-info btn-xs" onclick="UpdateContactos(<?php echo $HidCad; ?>,1);">Agregar</button>
			</div>                                 
			<div class="modal-footer"> 
				<button data-dismiss="modal" class="btn btn-default" type="button" onclick="UpdateCadena(<?php echo $HidCad; ?>,1,1)">Guardar</button>
				<button class="btn btn-success" type="button" onclick="returnListado1();">Regresar</button>
			</div>
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
<script src="../../inc/js/advanced-form-components.js"></script>
<!--Tabla-->
<script src="../../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../../assets/data-tables/DT_bootstrap.js"></script>

<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_Consulta.js" type="text/javascript"></script>
<script src="../../inc/js/_ConsultaCadena.js" type="text/javascript"></script>
<script src="../../inc/js/_Clientes.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.tablesorter.js" type="text/javascript"></script>
</body>

</html>