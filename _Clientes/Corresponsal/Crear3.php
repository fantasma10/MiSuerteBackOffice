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
<title>.::Mi Red::. Pre Alta Corresponsal</title>
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
<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
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
<div class="panelrgb">
	<input type = "hidden" id="idCorresponsal" value="<?php echo $oCorresponsal->getId();?>">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px; margin-top:20px;">
		<tbody>
			<tr>
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
		</tbody>
	</table>
						<!--Contactos SubCadena-->
	<div class="legend-big"><i class="fa fa-users"></i> Contactos</div>
		<div class="legmed">
			Contactos de la Sub Cadena
		</div>
				  
		<table class="tablanueva" style="margin-top:12px;">
			<thead class="theadtablita">
				<tr>
					<th class="theadtablitauno">Contacto</th>
					<th class="theadtablita">Tel&eacute;fono</th>
					<th class="theadtablita">Extensi&oacute;n</th>
					<th class="theadtablita">Correo</th>
					<th class="theadtablita">Tipo de Contacto</th>
					<th class="theadtablita">Acciones</th>
				</tr>
			</thead>
			<tbody class="tablapequena">
				<?php
					/* validar si es de una subcadena real o de una pre-subcadena */
					$tipo			= $oCorresponsal->getTipoSubcadena();
					$idSubCadena	= $oCorresponsal->getIdSubCadena();
					$tipoContacto	= 0;
					$categoria		= 2;

					if($tipo == 0){/* buscar en subcadena real */
						$query = "CALL `redefectiva`.`SP_LOAD_CONTACTOS_GENERAL`($idSubCadena, $tipoContacto, $categoria)";
					}
					else{/* buscar en subcadena pre */
						$query = "CALL `prealta`.`SP_LOAD_PRECONTACTOS_GENERAL`($idSubCadena, $tipoContacto, $categoria)";
					}

					$emptyRow = "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";

					$sql = $RBD->query($query);

					if(!$RBD->error()){
						if(mysqli_num_rows($sql) > 0){
							while($row = mysqli_fetch_assoc($sql)){
								echo "<tr>";
									echo "<td class='tdtablita'>".((!preg_match("!!u", $row['nombreCompleto']))? utf8_encode($row['nombreCompleto']) : $row['nombreCompleto'])."</td>";
									echo "<td class='tdtablita'>".$row['telefono1']."</td>";
									echo "<td class='tdtablita'>".$row['extTelefono1']."</td>";
									echo "<td class='tdtablita'>".$row['correoContacto']."</td>";
									echo "<td class='tdtablita'>".((!preg_match("!!u", $row['descTipoContacto']))? utf8_encode($row['descTipoContacto']) : $row['descTipoContacto'])."</td>";
									echo "<td class='tdtablita'>
										<a href=\"#\" onclick=\"agregarContactoDeSubCadena(".$row[idContacto].", ".$oCorresponsal->getId().", ".$row[idcTipoContacto].",
											'".((!preg_match("!!u", $row['nombreContacto']))? utf8_encode($row["nombreContacto"]) : $row["nombreContacto"])."',
											'".((!preg_match("!!u", $row['apPaternoContacto']))? utf8_encode($row["apPaternoContacto"]) : $row["apPaternoContacto"])."',
											'".((!preg_match("!!u", $row['apMaternoContacto']))? utf8_encode($row["apMaternoContacto"]) : $row["apMaternoContacto"])."',
											'".$row["extTelefono1"]."',
											'".$row["telefono1"]."','".$row["correoContacto"]."')\">
											<i class=\"fa fa-plus tooltips\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Agregar\"></i>
										</a></td>";
								echo "</tr>";
							}
						}
						else{
							echo $emptyRow;
						}
					}
					else{
						echo $emptyRow;
						//echo $RBD->error();
					}
				?>
			</tbody>
		</table>
			<!--Contactos Sub Cadena Final-->

		<div class="legmed">
		Contactos del Corresponsal
		</div>
		<div id="tblContactosPreCor">
			<!-- aqui se muestra la tabla con los contactos -->
		</div>
			
		<button type="button" class="btn btn-info btn-xs" style="margin-bottom:20px;"
        id="boton-nuevo-contacto"
        onClick="LimpiarPreContactosCorresponsal(true);agregarPreContacto();">Nuevo <i class="fa fa-plus"></i></button>
		</div>
											  
		<div id="agregarcontacto" style="display: none;">
			<form class="form-horizontal">
				<div class="form-group">
					<label class="col-lg-1 control-label">*Nombre(s):</label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder=""
                        onBlur="VerificarContactos()"
                        id="txtnombre"onKeyUp="validaCadenaConAcentos(event)" onKeyPress="return validaCadenaConAcentos(event)">
					</div>
				
					<label class="col-lg-1 control-label">*A. Paterno:</label>
					<div class="col-lg-3">
						 <input type="text" class="form-control" placeholder=""
                         onBlur="VerificarContactos()"
                         id="txtpaterno" onKeyUp="validaCadenaConAcentos(event)" onKeyPress="return validaCadenaConAcentos(event)">
					</div>
		  
					<label class="col-lg-1 control-label">*A. Materno:</label>
					<div class="col-lg-3">
						 <input type="text" class="form-control" placeholder="" name="txtmaterno"
                         onBlur="VerificarContactos()"
                         id="txtmaterno" onKeyUp="validaCadenaConAcentos(event)" onKeyPress="return validaCadenaConAcentos(event)">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-1 control-label">*Tel&eacute;fono:</label>
					<div class="col-lg-3">
						 <input type="text" class="form-control" placeholder="" id="txttelefono"
                         onBlur="VerificarContactos()"
                         onFocus="RellenarTelefono()"
                         onkeyup="validaTelefono2(event,'txttelefono')" onKeyPress="return validaTelefono1(event,'txttelefono')" maxlength="15">
					</div>

					<label class="col-lg-1 control-label">Extensi&oacute;n:</label>
					<div class="col-lg-3">
						 <input type="text" class="form-control" placeholder="" id="txtext"
                         onBlur="VerificarContactos()"
                         onKeyPress="return validaNumeroEntero(event)" maxlength="10">
					</div>

					<label class="col-lg-1 control-label">*Correo:</label>
					<div class="col-lg-3">
						 <input type="text" class="form-control" placeholder="" onBlur="VerificarContactos()" id="txtcorreo" >
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-1 control-label">*Tipo de Contacto:</label>
					<div class="col-lg-3">
						<select class="form-control" name="ddlTipoContacto" id="ddlTipoContacto" onChange="VerificarContactos()">
						<option value="-1">Seleccione Tipo de Contacto</option>
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
					<!--div class="col-lg-3">
						 <input type="text" class="form-control" placeholder="">
					</div-->
				</div>
			</form>
		</div>

		<!--Botones-->
		<!--button class="btn btn-medio" type="button" id="guardarCambios" onClick="DesPreContactosCorresponsal(<?php echo $oCorresponsal->getId();?>);" disabled>Guardar</button>
		<div class="prealta-footer">
			<button class="btn btn-default" type="button" onClick="CambioPagina(4, false)"> Adelante </button>
			<button class="btn btn-success" type="button" onClick="CambioPagina(2, false)"> Atr&aacute;s </button>
		</div-->

   <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
			<button type="button" class="btn btn-success" id="guardarCambios" onClick="DesPreContactosCorresponsal(<?php echo $oCorresponsal->getId();?>);" style="margin-top:10px;" disabled>
				Guardar
			</button> 
			</div>


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
<!--script src="../../inc/js/common-scripts.js"></script-->
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->

</body>
</html>