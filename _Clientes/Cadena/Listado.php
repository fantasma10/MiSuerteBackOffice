<?php
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
$esEscritura = false;
$submenuTitulo = "Consulta";
$subsubmenuTitulo ="Cadena";
$tipoDePagina = "Mixto";
$idOpcion = 1;
if(!isset($_SESSION['Permisos'])){
	header("Location: ../../logout.php");
	exit();
}
if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
	exit();
}
if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}
if(!isset($_POST['hidCadenaX']) || $_POST['hidCadenaX'] == -1){
	header("Location: ../menuConsulta.php");
	exit();
}
$HidCad = $_POST['hidCadenaX'];
$oCadena = new Cadena($RBD, $WBD);
$Res = $oCadena->load($HidCad);
if ( $Res['codigoRespuesta'] > 0 ) {
echo "<script>window.location.href ='../menuConsulta.php'; alert('No existe esta Cadena, lo vamos a redireccionar');</script>";
}
$idCadena = $oCadena->getId();
$nombreCadena = utf8_encode($oCadena->getNombre());
$totalCorresponsales = $oCadena->getCountCorresponsales();
$colZ = $oCadena->getColonia();
$cdZ = $oCadena->getCiudad();
$edoZ = $oCadena->getEstado();
$paisZ = $oCadena->getPais();
if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" || $paisZ == "No tiene" ) {
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
		<title>.::Mi Red::.Consulta Cadena</title>
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
	<!--Contenido Principal del Sitio-->
	<section id="main-content">
		<section class="wrapper site-min-height">
			<div class="row">
				<div class="col-xs-12">
					<?php include("../../inc/formPase.php"); ?>
					<section class="panelrgb">
						<!--Panel de Mini Paneles-->
						<section class="panel">
							<div class="titulorgb">
								<span><i class="fa fa-clipboard"></i></span>
							<h3 id="nombreCadena"><?php echo $nombreCadena;?></h3><span class="rev-combo pull-right">Consulta<br>Cadena</span></div>
							<div class="consultabody">
								<div class="row mini">
									<!--MiniPanel-->
									<div class="col-xs-1">
										<div class="minipanel">
											<div class="icono blue">
												<i class="fa fa-3x fa-user"></i>
											</div>
											<div class="linea">
												ID
											</div>
											<div class="dato">
												<?php echo $oCadena->getId();?>
											</div>
										</div>
									</div>
									<!--Mini Panel-->
									<!--MiniPanel-->
									<div class="col-xs-2">
										<div class="minipanel">
											<div class="icono orange">
												<i class="fa fa-3x fa-globe"></i>
											</div>
											<div class="linea">
												Estatus
											</div>
											<div class="dato">
												<?php echo $oCadena->getStatus();?>
											</div>
										</div>
									</div>
									<!--MiniPanel-->
									<div class="col-xs-2">
										<div class="minipanel">
											<div class="icono green">
												<i class="fa fa-3x fa-calendar-o"></i>
											</div>
											<div class="linea">
												Fecha de Alta
											</div>
											<div class="dato">
												<?php
													$f = date_create($oCadena->getFecAlta());
													echo date_format($f, "Y-m-d");
												?>
											</div>
										</div>
									</div>
									<!--Mini Panel-->
									<div class="col-xs-2">
										<div class="minipanel">
											<div class="icono yellow">
												<i class="fa fa-3x fa-users"></i>
											</div>
											<div class="linea">
												Grupo
											</div>
											<div class="dato">
												<?php echo $oCadena->getNombreGrupo();?>
											</div>
										</div>
									</div>
									<!--Mini Panel-->
									<!--div class="col-xs-2 col-sm-4 col-xs-4">
										<div class="minipanel">
											<<div class="icono red">
												<i class="fa fa-3x fa-dollar"></i>
											</div>
											<div class="linea">
												FORELO
											</div>
											<div class="dato">
												7%  $1500.00
											</div>>
										</div>
									</div-->
									<!--Final de los Mini Paneles-->
									<button class="btn btnconsulta btn-xs" type="button" onClick="irANuevaBusqueda();">Nueva B&uacute;squeda <i class="fa fa-search"></i></button>
								</div>
							</section>
							<!--Row de Paneles Generales-->
							<div class="row">
								<!--Panel de Datos Generales-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-book"></i> Datos Generales </div>
										<div class="panel-body" style="height:250px;">
											<!--Tabla Cadena y Sub Cadena-->
											<!--div class="table-responsive"-->
												<!--Tabla-->
												<table class="generales">
													<thead>
														<tr><th>Grupo</th><th>Referencia</th></tr>
													</thead>
													<tbody class=" table-responsivec">
														<td class="thw"><?php echo utf8_encode($oCadena->getNombreGrupo());?></td>
														<td class="thw"><?php echo utf8_encode($oCadena->getReferencia());?></td>
													</tbody>
													<thead class="theadresponsivea">
														<tr><th>Tel&eacute;fono</th><th>Correo</th></tr>
													</thead>
													<tbody class="table-responsivec">
														<td class="thw">
															<?php
                                                            	//echo $oCadena->getTel1();
																$telefonoCad = $oCadena->getTel1();
																if ( isset($telefonoCad) && !empty($telefonoCad) ) {
																	$tel="";
																	$telefonoCad = str_replace("-", "", $telefonoCad);
																	$telefono = str_split($telefonoCad);
																	$longitudTelefono = strlen($telefonoCad);
																	$contador = 0;
																	$contador2 = 0;
																	
																	foreach ( $telefono as $t ) {
																		$contador++;
																		$contador2++;
																		$tel .= $t;
																		if ( $contador == 2 ) {
																			if ( $contador2 <= ($longitudTelefono-1) ) {
																				$contador = 0;
																				$tel .= "-";
																			}
																		}
																	}
																	echo $tel;
																} else {
																	echo "No tiene";
																}															
															?>
                                                        </td>
														<td class="thw" style="max-width: 200px;"><?php echo $oCadena->getMail();?></td>
													</tbody>
													<thead class="theadresponsivea">
														<tr><th>Ejecutivo de Cuenta</th><th>Ejecutivo de Venta</th></tr>
													</thead>
													<tbody class=" table-responsivec">
														<td class="thw"><?php echo utf8_encode($oCadena->getNombreEjecutivoCuentas());?></td>
														<td class="thw"><?php echo utf8_encode($oCadena->getNombreEjecutivoVentas());?></td>
													</tbody>
													<thead class="theadresponsivea">
														<tr><th>Fecha de Alta</th><th>Usuario de Alta</th></tr>
													</thead>
													<tbody class=" table-responsivec">
														<td class="thw"><?php echo htmlentities($oCadena->getFecAlta()); ?></td>
														<td class="thw"><?php echo htmlentities($oCadena->getUsuarioAlta()); ?></td>
													</tbody>
													<thead class="theadresponsivea">
														<tr><th>Estatus</th></tr>
													</thead>
													<tbody class=" table-responsivec">
														<td class="thw"><?php echo $oCadena->getStatus();?></td><td class="thw"></td>
													</tbody>
												</table>
											<!--/div-->
											<!--Editar-->
										</div>
										<div class="panel-footer">
											<div class="row">
												<div class="col-xs-12">
													<?php if($esEscritura){ ?>
													<a href="#Datos" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-edit"></i></a>
													<?php } ?>
													<!--Fin Editar-->
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Dirección-->
								<!--Inicio de Panel de Dirección-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-map-marker"></i> Direcci&oacute;n</div>
										<div class="panel-body" style="height:72px;">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="direccion" style="margin-bottom:9px;">
												<?php
												if ( $oCadena->getDireccion() != "No tiene" ) {
												echo utf8_encode($oCadena->getDireccion());
												echo "<br>";
														echo utf8_encode("Col. ".$oCadena->getNombreColonia()." C.P. ".$oCadena->getCP());
														echo "<br/>";
														echo utf8_encode($oCadena->getNombreCiudad().", ".$oCadena->getNombreEstado().", ".$oCadena->getNombrePais());
													}
												?>
											</div>
										</div>
										<div class="panel-footer">
											<div class="row">
												<div class="col-xs-12">
													<?php if($esEscritura){ ?>
													<a href="#Direccion" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-edit"></i></a>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Inicio de Panel de Configuración de Acceso-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-desktop"></i> Configuraci&oacute;n</div>
										<div class="panel-body" style="height:128px;overflow-y: auto;overflow-x: hidden;">
											<!--Tabla Cadena y Sub Cadena-->

											<table class="ip">
												<thead>
													<tr>
														<th>#</th>
														<th>Interface</th>
														<th>Tipo de Conexi&oacute;n</th>
														<th>Estado</th>
														<th>IP</th>
														<th>Password</th>
														<th>Nivel</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$query = "CALL nautilus.SP_GET_CONFCONEXION($idCadena, -1, -1)";
														$sql = $RBD->SP($query);
													if(!$RBD->error()){
													if(mysqli_num_rows($sql) >= 1){
													while($row = mysqli_fetch_assoc($sql)){
													echo "<tr><td align='right'>".$row["idClientAccess"]."</td>";
													echo "<td align='right'>".$row["idEntity"]."</td>";
													echo "<td>".$row["serverDescription"]."</td>";
													echo "<td>".$row["descEstatus"]."</td>";
													echo "<td align='center'>".$row["IP"]."</td>";
													echo "<td>".$row["password"]."</td>";
													echo "<td align='right'>".$row["idServerLogLevel"]."</td></tr>";
													}
													}else{
													echo "<td colspan='7'>No hay informaci&oacute;n para mostrar.</td>";
													}
													}
													else{
													echo "<td colspan='7'>No se puede mostrar la informaci&oacute;n.</td>";
													}
													?>
												</tbody>
											</table>
											<!--Tabla Cadena y Sub Cadena-->
											<table class="generales">
												<thead class="theadresponsivea">
													<tr><th><i class="fa fa-chain"></i> Grupos</th></tr>
												</thead>
												<tbody class=" table-responsivec">
													<td><?php echo utf8_encode($oCadena->getNombreGrupo());?></td>
													<td>
														<?php
															$categoria = $oCadena->getConfPermisos(1);
															switch($categoria){
																case 1:
																	echo " de Cadena";
																break;
																case 2:
																	echo " de SubCadena";
																break;
																case 3:
																	echo " de Corresponsal";
																break;
																case 0:
																	$idGrupo = $oCadena->getGrupo();
																	$sql = $RBD->query("CALL `redefectiva`.`SP_TIENE_PERMISOS_GRUPO`($idGrupo)");
																	$row = mysqli_fetch_assoc($sql);
																	if($row['cuenta'] >= 1){
																		echo "de Grupo (Default)";
																	}else{
																		echo '<span style="color:red">Sin Permisos</span>';
																	}
																break;
															}
														?>
													</td>
													<td></td>
												</tbody>
											</table>
											<!--Tabla Cadena y Sub Cadena-->
										</div>
									</div>
								</div>
								<!--khdfs-->
							</div>
							<div class="row">
								<!--Inicio de Panel de Versiones-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-shopping-cart"></i> Versiones</div>
										<div class="panel-body" style="height:110px;overflow-y: auto;overflow-x: hidden;">
											<!--Tabla Cadena y Sub Cadena-->
											<!--div class="table-responsive"-->
												<table class="generales">
													<thead>
														<tr><th>Versi&oacute;n (es):</th></tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<?php
																	$versiones = $oCadena->getVersiones();
																	if ( !empty($versiones) ) {
																		$versiones = explode(",", $versiones);
																		foreach( $versiones as $version ) {
																			$version = explode("-", $version);
																			echo $version[1];
																			echo "<br />";
																		}
																	} else {
																		echo "No tiene";
																	}
																?>
															</td>
														</tr>
														<tr>
															<td></td>
														</tr>
													</tbody>
												</table>
											<!--/div-->
										</div>
									</div>
								</div>
								<!--dfdf-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-user"></i> Corresponsales</div>
										<div class="panel-body" style="height:110px;overflow-y: auto;overflow-x: hidden;">
											<!--Tabla Cadena y Sub Cadena-->
											<table class="ip">
												<thead>
													<tr>
														<th>SubCadena</th>
														<th>Corresponsales</th>
														<th>Ver</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$subcadenas = $oCadena->getSubCadenas();
														foreach ( $subcadenas as $subcadena ) {
															$name = (!preg_match("!!u", $subcadena[1]))? utf8_encode($subcadena[1]) : $subcadena[1];
															echo "<tr>";
																echo "<td>$name</td>";
																echo "<td style='text-align:right;'>{$subcadena[0]}</td>";
																echo "<td style='text-align:center;'>";
																	echo "<a href=\"#Reportes\" data-toggle=\"modal\" onClick=\"desplegarModalSubCadena($idCadena, {$subcadena[2]})\">";
																		//echo "<img src=\"../../img/buscar.png\">";
																		echo "<i class='fa fa-search'></i>";
																	echo "</a></td>";
															echo "</tr>";
														}
													?>
													<tr>
														<td class='tdtablita'>Todos</td>
														<td style='text-align:right;' class='tdtablita'><?php echo $totalCorresponsales; ?></td>
														<td style='text-align:center;' class='centrado' style="padding-right:20px;">
															<a href="#Reportes" data-toggle="modal" onClick="desplegarModalSubCadena(<?php echo $idCadena ?>, -1)">
																<!--img src="../../img/buscar.png"--><i class="fa fa-search"></i>
															</a>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
                                        <div class="panel-footer">
                                        </div>
									</div>
								</div>
							</div>
							<div class="row">
								<!--Inicio de Panel de Contacto-->
								<?php if ( $idCadena != 0 ) { ?>
								<div class="col-xs-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-users"></i> Informaci&oacute;n de Contactos</div>
										<div class="panel-body">
											<!--Tabla Cadena y Sub Cadena-->
											<!--div class="table-responsive"-->
												<table class="cc">
													<thead>
														<tr>
															<th>Contacto</th>
															<th>Tel&eacute;fono</th>
															<th>Extensi&oacute;n</th>
															<th>Correo</th>
															<th>Tipo de Contacto</th>
															<th>Acciones</th>
														</tr>
													</thead>
													<tbody class="tablapequena">
														<?php
															$qry = "CALL `redefectiva`.`SP_LOAD_CONTACTOS_GENERAL`($idCadena, 0, 1);";
															$res = $RBD->query($qry);
															if ( !$RBD->error() ) {
																if ( mysqli_num_rows($res) > 0 ) {
																	while ( $row = mysqli_fetch_assoc($res) ) {
																		echo "<tr>";
																		echo "<td class='tdtablita'>".((!preg_match('!!u', $row['nombreCompleto']))? utf8_encode($row['nombreCompleto']) : $row['nombreCompleto'])."</td>";
																		$tel="";
																		$row['telefono1'] = str_replace("-", "", $row['telefono1']);
																		$telefono = str_split($row['telefono1']);
																		$longitudTelefono = strlen($row['telefono1']);
																		$contador = 0;
																		$contador2 = 0;
																		
																		foreach ( $telefono as $t ) {
																			$contador++;
																			$contador2++;
																			$tel .= $t;
																			if ( $contador == 2 ) {
																				if ( $contador2 <= ($longitudTelefono-1) ) {
																					$contador = 0;
																					$tel .= "-";
																				}
																			}
																		}
																		echo "<td class='tdtablita'>".$tel."</td>";																		
																		//echo "<td class='tdtablita'>".$row['telefono1']."</td>";
																		echo "<td class='tdtablita' align='right'>".$row['extTelefono1']."</td>";
																		echo "<td class='tdtablita'>".$row['correoContacto']."</td>";
																		echo "<td class='tdtablita'>".utf8_encode($row['descTipoContacto'])."</td>";
																		echo "<td class='tdtablita'>";
																		if ( $esEscritura ) {
																			echo "
																			<a href='#' onclick='DeleteContactos3(".$HidCad.", ".$row['idContacto'].",1)''>
																				<img src='../../../img/delete2.png'>
																			</a>";
																			
																			if ( $row["subcadena"] == 0 ) {
																				echo "<a href='#Contactos' data-toggle='modal'
																				onclick=\"EditarContactos('$row[idContacto]',
																				'".codificarUTF8($row['nombreContacto'])."',
																				'".codificarUTF8($row['apPaternoContacto'])."',
																				'".codificarUTF8($row['apMaternoContacto'])."',
																				'".utf8_encode($row['idcTipoContacto'])."',
																				'".$tel."',
																				'".$row['correoContacto']."',
																				'".$row['extTelefono1']."',event)\">
																				<img src='../../../img/edit2.png'>
																				</a>";
																			}
																		}
																		echo "</td>";
																		echo "</tr>";
																	}
																} else {
																	echo "<tr><td colspan='6'>No hay informaci&oacute;n para mostrar.</td></tr>";
																}
															} else {
																echo "<tr><td colspan='6'>No es posible mostrar la informaci&oacute;n.</td></tr>";
															}
														?>
													</tbody>
												</table>
										</div>
										<div class="panel-footer">
											<div class="row">
												<div class="col-xs-12">
													<?php if($esEscritura){ ?>
													<a href="#Contactos" data-toggle="modal" class="btn btnconsultabig btn-xs" onClick="AgregarContacto(event);">Nuevo <i class="fa fa-plus"></i></a>
													<?php } ?>
												</div>
											</div>
										</div>
										<!--/div-->
									</div>
								</div>
								<?php } ?>
								<!--MODALES MODALES MODALES-->
								<div class="modal fade" id="Cuenta" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-bar-chart-o"></i></span>
												<h3>Nombre de Corresponsal</h3>
												<span class="rev-combo pull-right">Editar</span>
											</div>
											<div class="modal-body">
												
												<legend>Configuraci&oacute;n de Liquidaci&oacute;n</legend>
												<form class="form-horizontal">
													
													<div class="form-group">
														<label class="col-xs-1 control-label">Tipo de Movimiento:</label>
														<div class="col-xs-3">
															<select class="form-control m-bot15">
																<option>Movimiento</option>
																<option>Movimiento</option>
															</select>
														</div>
														
														
														<label class="col-xs-1 control-label">Tipo de Instrucci&oacute;n:</label>
														<div class="col-xs-3">
															<select class="form-control m-bot15">
																<option>Instrucci&oacute;n</option>
																<option>Instrucci&oacute;n</option>
															</select>
														</div>
														
														
														<label class="col-xs-1 control-label">Destino:</label>
														<div class="col-xs-3">
															<select class="form-control m-bot15">
																<option>Contacto</option>
																<option>Contacto</option>
															</select>
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-xs-1 control-label">IVA:</label>
														<div class="col-xs-3">
															<select class="form-control m-bot15">
																<option>16%</option>
																<option>16%</option>
															</select>
														</div>
													</div>
													
													
													
													
													<legend>Cuenta</legend>
													
													<div class="form-group">
														<label class="col-xs-1 control-label">CLABE:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="">
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-xs-1 control-label">Banco:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="">
														</div>
														
														<label class="col-xs-1 control-label">No. Cuenta:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder=""></div>
														</div>
														
														
														<div class="form-group">
															<label class="col-xs-1 control-label">Beneficiario:</label>
															<div class="col-xs-3">
																<input type="text" class="form-control" placeholder="">
															</div>
															
															
															<label class="col-xs-1 control-label">RFC:</label>
															<div class="col-xs-3">
																<input type="text" class="form-control" placeholder="">
															</div>
															
															<label class="col-xs-1 control-label">Correo:</label>
															<div class="col-xs-3">
																<input type="text" class="form-control" placeholder="">
															</div>
														</div>
														
													</form>
												</div>
												<div class="modal-footer">
													<!--<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>-->
													<button class="btn btn-success consulta pull-right" type="button">Agregar</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Cierre Modal-->
								<!--Inicia Modal-->
								<div class="modal fade" id="Datos" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3><?php echo $nombreCadena;?></h3>
												<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
											</div>
											<div class="modal-body">
												<legend> <i class="fa fa-book"></i> Datos Generales</legend>
												<form class="form-horizontal">
													<div class="form-group">
														<label class="col-xs-1 control-label">Referencia:</label>
														<div class="col-xs-3">
															<select class="form-control m-bot15" name="ddlReferencia" id="ddlReferencia">
																<option value="-1">Seleccione una Referencia</option>
																<?php
																$z = $oCadena->getIdRef();
																$sql = "CALL `redefectiva`.`SP_LOAD_REFERENCIAS`();";
																$res = $RBD->SP($sql);
																if($RBD->error() == ''){
																if($res != '' && mysqli_num_rows($res) > 0){
																while($r = mysqli_fetch_array($res)){
																				if ( !preg_match('!!u', $r[1]) ) {
																					//no es utf-8
																					$r[1] = utf8_encode($r[1]);
																						}
																if ( $z != "" && isset($z) ) {
																					if($z == $r[0])
																						echo "<option value='$r[0]' selected='selected' >$r[1]</option>";
																					else
																						echo "<option value='$r[0]' >$r[1]</option>";
																				} else {
																					if ($r[0] == 1)
																						echo "<option value='$r[0]' selected='selected' >$r[1]</option>";
																					else
																						echo "<option value='$r[0]' >$r[1]</option>";
																				}
																}
																}
																}
																?>
															</select>
														</div>
														<label class="col-xs-1 control-label">Estatus:</label>
														<div class="col-xs-3">
															<?php
																$idE = $oCadena->getIdStatus();
																$e0 = "'false'";
																$e1 = "'false'";
																$e2 = "'false'";
																$e3 = "'false'";
																$e4 = "'false'";
																switch($idE){
																	case '0': $e0 = "selected"; break;
																	case '1': $e1 = "selected"; break;
																	case '2': $e2 = "selected"; break;
																	case '3': $e3 = "selected"; break;
																	case '4': $e4 = "selected"; break;
																}
															?>
															<select class="form-control m-bot15" name="ddlEstatus" id="ddlEstatus">
																<?php
																echo '<option value="0" '.(($e0 == "selected")? "selected=selected": '').'>Activo</option>';
																echo '<option value="1" '.(($e1 == "selected")? "selected=selected": '').'>Inactivo</option>';
																echo '<option value="2" '.(($e2 == "selected")? "selected=selected": '').'>Suspendido</option>';
																echo '<option value="3" '.(($e3 == "selected")? "selected=selected": '').'>Baja</option>';
																echo '<option value="4" '.(($e4 == "selected")? "selected=selected": '').'>Bloqueado</option>';
																?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-1 control-label">Tel&eacute;fono:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="Teléfono de la Cadena" id="txtTelCadena"
															onkeyup="validaTelefono2(event,'txtTelCadena')" onKeyPress="return validaTelefono1(event,'txtTelCadena')"
															maxlength="20"
                                                            value="<?php
                                                            	//echo $oCadena->getTel1();
																$telefonoCad = $oCadena->getTel1();
																$tel="";
																$telefonoCad = str_replace("-", "", $telefonoCad);
																$telefono = str_split($telefonoCad);
																$longitudTelefono = strlen($telefonoCad);
																$contador = 0;
																$contador2 = 0;
																
																foreach ( $telefono as $t ) {
																	$contador++;
																	$contador2++;
																	$tel .= $t;
																	if ( $contador == 2 ) {
																		if ( $contador2 <= ($longitudTelefono-1) ) {
																			$contador = 0;
																			$tel .= "-";
																		}
																	}
																}
																echo $tel;																
															?>">
														</div>
														<label class="col-xs-1 control-label">Correo:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="Correo de la Cadena" id="txtCorreo"
															value="<?php echo isset($oCadena->MAIL)? $oCadena->MAIL : ""; ?>" maxlength="100">
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-1 control-label">Ejecutivo de Cuenta:</label>
														<div class="col-xs-3">
															<input type="hidden" id="ddlEjecutivo" value="<?php echo $oCadena->getIdEjecutivoCuenta(); ?>"/>
															<input type="text" class="form-control ui-autocomplete-input" placeholder="Nombre de Ejecutivo de Cuenta" id="txtEjecutivoCuenta"
															value="<?php
															$idEjecutivoCuenta = $oCadena->getIdEjecutivoCuenta();
															if ( $idEjecutivoCuenta > 0 ) {
																echo utf8_encode(trim($oCadena->getNombreEjecutivoCuentas()));
															}
															?>">
														</div>
														<label class="col-xs-1 control-label">Ejecutivo de Venta:</label>
														<div class="col-xs-3">
															<input type="hidden" id="ddlEjecutivoVenta" value="<?php echo $oCadena->getIdEjecutivoVenta();?>"/>
															<input type="text" class="form-control" placeholder="Nombre de Ejecutivo de Venta" id="txtEjecutivoVenta"
															value="<?php
															$idEjecutivoVenta = $oCadena->getIdEjecutivoVenta();
															if ( $idEjecutivoVenta > 0 ) {
																echo utf8_encode(trim($oCadena->getNombreEjecutivoVentas()));
															}
															?>">
														</div>
													</div>
													<!--<div class="form-group">
														<label class="col-xs-2 control-label">Fecha de Vencimiento:</label>
														<div class="col-xs-2">
															<input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="" />
															<span class="help-block">Seleccionar Fecha.</span>
														</div> </div>-->
													</form>
												</div>
												<div class="modal-footer">
													<!--<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>-->
													<button class="btn btnconsultabig consulta pull-right" type="button"
													onClick="UpdateCadena(<?php echo $idCadena ?>,0,1)">Guardar</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Cierre Modal-->
								<!--Inicia Modal-->
								<div class="modal fade" id="Contactos" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3><?php echo $nombreCadena;?></h3>
												<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
											</div>
											<div class="modal-body">
												<legend> <i class="fa fa-users"></i> Contactos</legend>
												<form class="form-horizontal">
													<div class="form-group">
														<input type="hidden" id="HidContacto">
														<label class="col-xs-1 control-label">Nombre(s):</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="" id="txtContacNom">
														</div>
														
														<label class="col-xs-1 control-label">A.Paterno:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="" id="txtContacAP">
														</div>
														
														<label class="col-xs-1 control-label">A.Materno:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="" id="txtContacAM">
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-xs-1 control-label">Tel&eacute;fono:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="" id="txtTelContac" onKeyUp="validaTelefono2(event,'txtTelContac')" onKeyPress="return validaTelefono1(event,'txtTelContac')" maxlength="20">
														</div>
														
														<label class="col-xs-1 control-label">Extensi&oacute;n:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="" id="txtExtTelContac" onKeyUp="validaNumeroEntero2(event,'txtTelContac')" onKeyPress="return validaNumeroEntero(event,'txtTelContac')" maxlength="15">
														</div>
														
														
														<label class="col-xs-1 control-label">Correo:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" placeholder="" id="txtMailContac">
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-xs-1 control-label">Tipo de Contacto:</label>
														<div class="col-xs-3">
															<select name="ddlTipoContac" id="ddlTipoContac" class="form-control m-bot15">
																<option value="-2" selected>Selecciona Tipo de Contacto</option>
																<?php
																$sql = "CALL `redefectiva`.`SP_LOAD_TIPOS_DE_CONTACTO`();";
																$result = $RBD->SP($sql);
																
																while(list($id,$desc)= mysqli_fetch_row($result))
																{
																echo '<option value="'.$id.'">'.utf8_encode($desc).'</option>';
																}
																mysqli_free_result($result);
																?>
															</select>
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<!--<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>-->
												<button class="btn btnconsultabig consulta pull-right" type="button" onClick="UpdateContactos(<?php echo $HidCad; ?>,1);">Agregar</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--Modal Horario-->
							<!--Inicia Modal-->
							<div class="modal fade" id="Direccion" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-consulta">
											<span><i class="fa fa-edit"></i></span>
											<h3><?php echo $nombreCadena ?></h3>
											<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
										</div>
										<div class="modal-body">
											<legend> <i class="fa fa-home"></i> Direcci&oacute;n</legend>
											<form class="form-horizontal" id="datos-generales">
												<div class="form-group">
													<label class="col-xs-1 control-label">Pa&iacute;s:</label>
													<div class="col-xs-3">
														<!-- <input type="text" class="form-control" placeholder=""> -->
														<input type="text" class="form-control" id="txtPais"
														onkeypress="VerificarDireccionCad(tipoDireccion, false);"
														onkeyup="VerificarDireccionCad(tipoDireccion, false);"
														value="<?php echo ($oCadena->getPais() > 0)? utf8_encode($oCadena->getNombrePais()) : ''; ?>" placeholder=""
														maxlength="50">
														<input type="hidden" id="paisID" value="<?php echo ($oCadena->getPais() > 0)? $oCadena->getPais() : ''; ?>" />
													</div>
												</div>
												
												
												<div class="form-group">
													<label class="col-xs-1 control-label">Calle:</label>
													<div class="col-xs-3">
														<!-- <input type="text" class="form-control" placeholder=""> -->
														<?php
																										$calle = $oCadena->getCalle();
														?>
														<input type="text" class="form-control" id="txtcalle"
														onkeypress="VerificarDireccionCad(tipoDireccion, false);"
														onkeyup="VerificarDireccionCad(tipoDireccion, false);"
														value="<?php echo (isset($calle) && !empty($calle) && $calle != "No tiene") ? utf8_encode($calle) : ''; ?>" placeholder=""
														maxlength="50">
													</div>
													
													<label class="col-xs-1 control-label">No. Exterior:</label>
													<div class="col-xs-3">
														<!-- <input type="text" class="form-control" placeholder=""> -->
														<input type="text" class="form-control" id="txtnext"
														onkeypress="VerificarDireccionCad(tipoDireccion, false);"
														onkeyup="VerificarDireccionCad(tipoDireccion, false);"
														value="<?php echo ( $oCadena->getNext() != "No tiene" ) ? $oCadena->getNext() : ""; ?>" placeholder=""
														maxlength="50">
													</div>
													
													
													<label class="col-xs-1 control-label">No. Interior:</label>
													<div class="col-xs-3">
														<!-- <input type="text" class="form-control" placeholder=""> -->
														<input type="text" class="form-control" id="txtnint"
														onkeypress="VerificarDireccionCad(tipoDireccion, false);"
														onkeyup="VerificarDireccionCad(tipoDireccion, false);"
														value="<?php echo ( $oCadena->getNint() != "No tiene" ) ? $oCadena->getNint() : ""; ?>" placeholder=""
														maxlength="50">
													</div>
												</div>
												
												
												<div class="form-group">
													<label class="col-xs-1 control-label">C.P:</label>
													<div class="col-xs-3">
														<!-- <input type="text" class="form-control" placeholder=""> -->
														<input type="text" class="form-control" id="txtcp"
														onkeypress="VerificarDireccionCad(tipoDireccion, false);"
														onkeyup="buscarColonias();VerificarDireccionCad(tipoDireccion, false);"
														maxlength="5"
														value="<?php echo ( $oCadena->getCP() > 0 && $oCadena->getCP() != "No tiene" ) ? $oCadena->getCP() : ''; ?>" placeholder="">
													</div>
													
													
													<label class="col-xs-1 control-label">Colonia:</label>
													<div class="col-xs-3">
														<!--<select class="form-control m-bot15">
															<option>Las Torres</option>
															<option>Las Brisas</option>
															<option>Del Paseo</option>
														</select>-->
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
																$sql = "CALL `redefectiva`.`SP_GET_COLONIA`($paisZ, $colZ);";
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
													<label class="col-xs-1 control-label">Estado:</label>
													<div class="col-xs-3">
														<!--<select class="form-control m-bot15">
															<option>Nuevo León</option>
															<option>Coahuila</option>
															<option>Zacatecas</option>
														</select>-->
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
																	$sql2 = "CALL `redefectiva`.`SP_LOAD_ESTADOS`(164);";
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
																$sql = "CALL `redefectiva`.`SP_GET_ESTADO`($paisZ, $edoZ);";
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
													
													
													<label class="col-xs-1 control-label">Ciudad:</label>
													<div class="col-xs-3">
														<!--<select class="form-control m-bot15">
															<option>Monterrey</option>
															<option>Torreon</option>
															<option>Pinos</option>
														</select>-->
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
																	$sql2 = "CALL `redefectiva`.`SP_LOAD_CIUDADES`(164, '$edoZ');";
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
																$sql = "CALL `redefectiva`.`SP_GET_CIUDAD`($paisZ, $edoZ, $cdZ);";
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
											<div class="modal-footer">
												<!--<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>-->
												<button class="btn btnconsultabig consulta pull-right" type="button" onClick="editarDireccion(tipoDireccion, 1, <?php echo $idCadena; ?>)">Guardar</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--Cierres-->
							<div class="modal fade" id="Version" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-consulta">
											<span><i class="fa fa-edit"></i></span>
											<h3>Nombre de Corresponsal</h3>
											<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
										</div>
										<div class="modal-body">
											<legend> <i class="fa fa-home"></i> Versi&oacute;n</legend>
											<form class="form-horizontal">
												<div class="form-group">
													<label class="col-xs-1 control-label">Agregar:</label>
													<div class="col-xs-4">
														<select class="form-control m-bot15">
															<option>Única</option>
															<option>Light</option>
															<option>Completa</option>
														</select>
													</div>
													<div class="col-xs-1"><a href="#"><i class="fa fa-plus"></i></a></div>
													<label class="col-xs-1 control-label">Agregada:</label> <table><tr><td>Versi&oacute;n</td><td><a href="#"><i class="fa fa-times"></i></a></td></tr></table>
												</div>
											</form>
										</div>
										<div class="modal-footer">
											<!--<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>-->
											<button class="btn btn-success consulta pull-right" type="button" >Guardar</button>
										</div>
									</div>
								</div>
								</div><!--AQUI-->
								<!--Inicia Modal-->
								<div class="modal fade" id="Reportes" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3><?php echo $nombreCadena; ?></h3>
												<span class="rev-combo pull-right">Corresponsales</span>
											</div>
											<div class="modal-body">
												<div class="table-responsive">
													<div id="excelReporte">
														<?php
														echo "<div>";
															echo "<div style=\"text-align:center;\">";
																echo "<span>";
																echo $totalCorresponsales;
																echo "</span>";
																echo " Corresponsales - ";
																		echo "<span>";
																echo $nombreCadena;
																echo "</span>";
																echo "<br />";
															echo "</div>";
															echo "<div style=\"text-align:center;\">";
																echo "<span>";
																echo "<a href=\"#\" onclick=\"downloadExcelListaCorresponsales('$idCadena', '-1', '$nombreCadena', '$totalCorresponsales')\">";
																	echo "Descargar a Excel";
																echo "</a>";
																echo "</span>";
																echo "<br />";
																echo "<br />";
															echo "</div>";
														echo "</div>";
														?>
													</div>
													<div class="" id="tablaReporte">
														<?php
														$res = $RBD->SP("CALL `redefectiva`.`SP_LOAD_CORRESPONSALES`($idCadena, -1);");
														echo "<table class=\"tablacentrada\">";
															echo "<thead>";
																echo "<tr>";
																	echo "<th>ID</th>";
																	echo "<th>Nombre del Corresponsal</th>";
																echo "</tr>";
																echo "<tr>";
																	echo "&nbsp;";
																echo "</tr>";
															echo "</thead>";
															echo "<tbody>";
																if ( mysqli_num_rows($res) > 0 ) {
																while ( $corresponsal = mysqli_fetch_array($res) ) {
																	echo "<tr class=\"gradeA\">";
																		echo "<td>{$corresponsal[0]}</td>";
																		echo "<td>".htmlentities($corresponsal[1])."</td>";
																		echo "<td>";
																			echo "<a href=\"#\" onclick=\"GoCorresponsal({$corresponsal[0]})\">";
																				echo "<img src=\"../../img/buscar.png\">";
																			echo "</a>";
																		echo "</td>";
																	echo "</tr>";
																}
																}
															echo "</tbody>";
														echo "</table>";
														?>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<!--<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>-->
												<button class="btn btnconsultabig consulta pull-right" data-dismiss="modal" type="button" >Salir</button>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" id="txtNombreCadena" value="<?php echo $nombreCadena; ?>" />
								<!--Cierres-->
							</section>
						</div>
					</div>
				</section>
			</section>
			<!--*.JS Generales-->
			<script src="../../inc/js/jquery.js"></script>
			<script src="../../css/ui/jquery.ui.core.js"></script>
			<script src="../../css/ui/jquery.ui.widget.js"></script>
			<script src="../../css/ui/jquery.ui.position.js"></script>
			<script src="../../css/ui/jquery.ui.menu.js"></script>
			<script src="../../css/ui/jquery.ui.autocomplete.js"></script>
			<script src="../../inc/js/bootstrap.min.js"></script>
			<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
			<script src="../../inc/js/jquery.scrollTo.min.js"></script>
			<script src="../../inc/js/respond.min.js" ></script>
			<!--Específicos-->
			<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
			<script src="../../inc/js/advanced-form-components.js"></script>
			<script src="../../inc/js/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js"></script>
			<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
			<script src="../../inc/js/RE.js" type="text/javascript"></script>
			<script src="../../inc/js/_Clientes.js" type="text/javascript"></script>
			<script src="../../inc/js/_Consulta.js" type="text/javascript"></script>
			<script src="../../inc/js/_ConsultaCadena.js" type="text/javascript"></script>
			<script src="../../inc/js/_ConsultasGeneral.js" type="text/javascript"></script>
			<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
			<script src="../../inc/js/_PrealtaPreCadena.js" type="text/javascript"></script>
			<!--Generales-->
			<script src="../../inc/js/common-scripts.js"></script>            
			<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
			<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
			<script src="../../inc/js/jquery.tablesorter.js" type="text/javascript"></script>
			<script>
			<?php
				$paisZ = $oCadena->getPais();
				if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" || $paisZ == "No tiene" ) {
			?>
			var tipoDireccion = "nacional";
			<?php } else { ?>
			var tipoDireccion = "extranjera";
			<?php } ?>
			</script>
			<script>
				$(document).ready(function() {
					$("#txtEjecutivoCuenta").on("keyup keypress keydown", function() {
						var ejecutivo = $(this).val();
						if ( ejecutivo == "" ) {
							$("#ddlEjecutivo").val(-1);
						}
					});
					$("#txtEjecutivoVenta").on("keyup keypress keydown", function() {
						var ejecutivo = $(this).val();
						if ( ejecutivo == "" ) {
							$("#ddlEjecutivoVenta").val(-1);
						}
					});					
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
								VerificarDireccionCad(tipoDireccion, false);
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
				<!--Cierre del Sitio-->
			</body>
		</html>