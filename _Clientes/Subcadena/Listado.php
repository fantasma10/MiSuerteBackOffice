<?php
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
$submenuTitulo = "Consulta";
$subsubmenuTitulo ="Subcadena";
$esEscritura = false;
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
if(!isset($_POST['hidSubCadenaX']) || $_POST['hidSubCadenaX'] < 0){
	header("Location: ../../main.php");
	exit();
}
$HidSubCad 	= $_POST['hidSubCadenaX'];
$oSubcadena = new SubCadena($RBD, $WBD);
$Res = $oSubcadena->load($HidSubCad);
if ( $Res['codigoRespuesta'] > 0 ) {
	echo "<script>alert('No existe esta Subcadena, lo vamos a redireccionar'); window.location.href ='../menuConsulta.php';</script>";
}
$idCadena = $oSubcadena->getCadena();
$idSubcadena = $oSubcadena->getId();
$nombreSubcadena = $oSubcadena->getNombre();
$totalCorresponsales = $oSubcadena->getCountCorresponsales($HidSubCad);
if ( !preg_match('!!u', $nombreSubcadena) ) {
	$nombreSubcadena = utf8_encode($nombreSubcadena);
}
$colZ = $oSubcadena->getColonia();
$cdZ = $oSubcadena->getCiudad();
$edoZ = $oSubcadena->getEstado();
$paisZ = $oSubcadena->getPais();
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
		<title>.::Mi Red::.Consulta Sub Cadena</title>
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
							<h3><?php echo $nombreSubcadena; ?></h3><span class="rev-combo pull-right">Consulta<br>Sub Cadena</span></div>
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
												<?php echo $oSubcadena->getId(); ?>
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
												<?php echo $oSubcadena->getStatus(); ?>
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
													$f = date_create($oSubcadena->getFecAlta());
													echo date_format($f, "Y-m-d");
												?>
											</div>
										</div>
									</div>
									<!--Mini Panel-->
									<div class="col-xs-2">
										<div class="minipanel">
											<div class="icono yellow">
												<i class="fa fa-3x fa-shopping-cart"></i>
											</div>
											<div class="linea">
												Versión
											</div>
											<div class="dato">
												<?php
													$id = $oSubcadena->getIdVersion();
													if($id > 0){
														//$id = $oSubcadena->getIdVersion();
														$vers = $oSubcadena->getVersion();
														//echo '- <a href="#" onclick="irAVersio('.$id.',\'../../../_Clientes/Cadena/Listado.php\')" class="liga_descarga_archivos">'.htmlentities($vers).'</a>';
														echo htmlentities($vers);
													}
													else{
														echo $vers = $oSubcadena->getVersion();
													}
												?>
											</div>
										</div>
									</div>
									<!--Mini Panel-->
									<div class="col-xs-2">
										<div class="minipanel">
											<div class="icono red">
												<i class="fa fa-3x fa-dollar"></i>
											</div>
											<div class="linea">
												FORELO
											</div>
											<div class="dato">
												<?php echo $oSubcadena->getForelo(); echo "   \$".number_format($oSubcadena->getSaldo(),2); ?>
											</div>
										</div>
									</div>
									<!--Final de los Mini Paneles--->
									<button class="btn btnconsulta btn-xs" type="button" onClick="irANuevaBusqueda();">Nueva B&uacute;squeda <i class="fa fa-search"></i></button>
								</div>
							</section>
							<!--Row de Paneles Generales-->
							<div class="row">
								<!--Panel de Datos Generales-->
								<div class="col-xs-6">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-book"></i> Datos Generales </div>
										<div class="panel-body" style="height:387px;overflow-y: auto;overflow-x: hidden;">
											<!--Tabla Cadena y Sub Cadena-->
											<table class="generales">
												<thead class="theadresponsivea">
													<tr><th class="thw">Cadena</th><th class="thw"></th></tr>
												</thead>
												<tbody class=" table-responsivec">
													<td class="thw"><?php echo "ID: ".$idCadena." - ".utf8_encode($oSubcadena->getNombreCadena()); ?></td>
													<td class="thw"></td>
												</tbody>
												<thead>
													<tr><th>Grupo</th><th>Referencia</th></tr>
												</thead>
												<tbody>
													<td><?php echo $oSubcadena->getNombreGrupo(); ?></td>
													<td><?php echo $oSubcadena->getReferencia(); ?></td>
												</tbody>
												<thead>
													<tr><th>Tel&eacute;fono</th><th>Correo</th></tr>
												</thead>
												<tbody>
													<td>
														<?php
															$telefono = $oSubcadena->getTel1();
															if ( isset($telefono) && !empty($telefono) ) {
																//echo $telefono;
																$tel = "";
																$telefono = str_replace("-", "", $telefono);
																$longitudTelefono = strlen($telefono);
																$telefono = str_split($telefono);
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
													?></td>
													<td style="max-width: 200px;">
														<?php
															$correo = $oSubcadena->getMail();
															if ( isset($correo) && !empty($correo) ) {
																echo $oSubcadena->getMail();
															} else {
																echo "No tiene";
															}
													?></td>
												</tbody>
												<thead>
													<tr><th>Ejecutivo de Cuenta</th><th>Ejecutivo de Venta</th></tr>
												</thead>
												<tbody>
													<td>
														<?php echo utf8_encode($oSubcadena->getNombreEjecutivoCuentas()); ?>
													</td>
													<td>
														<?php echo utf8_encode($oSubcadena->getNombreEjecutivoVentas()); ?>
													</td>
												</tbody>
												<thead>
													<tr><th>Fecha de Alta</th><th>Usuario de Alta</th></tr>
												</thead>
												<tbody>
													<td><?php echo $oSubcadena->getFecAlta(); ?></td>
													<td><?php echo utf8_encode($oSubcadena->getUsuarioAlta());?></td>
												</tbody>
												<thead>
													<tr><th>Estatus</th><th>IVA</th></tr>
												</thead>
												<tbody>
													<td><?php echo $oSubcadena->getStatus();?></td><td><?php echo $oSubcadena->getDescIva(); ?></td>
												</tbody>
											</table>

										</div>
										<div class="panel-footer">
											<div class="row">
												<div class="col-xs-12">
													<?php if($esEscritura){ ?>
													<!--Editar-->
													<a href="#Datos" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-edit"></i></a>
													<!--Fin Editar-->
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Inicio de Panel de Dirección-->
								<div class="col-xs-6">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-map-marker"></i> Direcci&oacute;n</div>
										<div class="panel-body" style="height:63px;overflow-y: auto;overflow-x: hidden;">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="direccion">
												<?php
													if($oSubcadena->getDireccion() != "No tiene"){
														echo utf8_encode($oSubcadena->getDireccion());
														echo "<br/>";
														echo utf8_encode("Col. ".$oSubcadena->getNombreColonia()." C.P. ".$oSubcadena->getCP());
														echo "<br/>";
														echo utf8_encode($oSubcadena->getNombreCiudad().", ".$oSubcadena->getNombreEstado().", ".$oSubcadena->getNombrePais());
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
								<div class="col-xs-6">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-desktop"></i> Configuraci&oacute;n</div>
										<div class="panel-body" style="height:190px;overflow-y: auto;overflow-x: hidden;">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="table-responsive">
												<table class="generales">
													<thead>
														<tr><th>Tipo de Acceso</th><th>C&oacute;digo de Acceso</th><th></th></tr>
													</thead>
													<tbody>
														<td><?php echo $oSubcadena->getTipoAcceso(); ?></td>
														<td><?php echo $oSubcadena->getCodigos(); ?></td>
														<td></td>
													</tbody>
												</table>
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
																	$idCadena		= $oSubcadena->getCadena();
																$idSubCadena	= $oSubcadena->getId();
															//$idCorresponsal = "NULL";
															$idCorresponsal = -1;
															
															$query = "CALL nautilus.SP_GET_CONFCONEXION($idCadena, $idSubCadena, $idCorresponsal)";
															$sql = $RBD->query($query);
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
																}
																else{
																	echo "<tr><td colspan='7'>No hay informaci&oacute;n para mostrar.</td></tr>";
																}
															}
															else{
																echo "<tr><td colspan='7'>No se puede mostrar la informaci&oacute;n.</td></tr>";
																echo "<tr><td colspan='7'>".$RBD->error()."</td></tr>";
															}
														?>
													</tbody>
												</table>
											</div>
											<!--Tabla Cadena y Sub Cadena-->
											<table class="table">
												<thead>
													<tr><th><i class="fa fa-users"></i> Grupos</th></tr>
												</thead>
												<tbody class=" table-responsivec">
													<td>
														<?php
															$nombreGrupo = $oSubcadena->getNombreGrupo();
															if ( !preg_match('!!u', $nombreGrupo) ) {
																	$nombreGrupo = utf8_encode($nombreGrupo);
															}
															echo $nombreGrupo;
													?></td>
													<td>
														<?php
															$categoria = $oSubcadena->getConfPermisos(2);
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
																	$idGrupo = $oSubcadena->getGrupo();
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
                                </div></div>
								<!--dfdf-->
								<div class="col-xs-6">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-user"></i> Corresponsales</div>
										<div class="panel-body">
											<!--Tabla Cadena y Sub Cadena-->
											<table>
												<tr>
													<td style="text-align:center;">
														<a href="#Reportes" data-toggle="modal">
															<!--img src="../../img/buscar.png"-->
															<i class='fa fa-search'></i>
														</a>
													</td>
													<td style="padding-left:10px;">N&uacute;mero de Corresponsales: <?php echo $totalCorresponsales; ?></td>
												</tr>
											</table>
										</div>
									</div>
								</div>
								<!--khdfs-->
							</div>
							<!--Cierre O-->
							<div class="row">
								<!---sdjfhhjsdf--->
								<!--Inicio de Panel de Contacto-->
								<?php if ( $idSubcadena != 0 ) { ?>
								<div class="col-xs-12">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-users"></i> Informaci&oacute;n de Contactos</div>
										<div class="panel-body" style="height:160px;overflow-y: auto;overflow-x: hidden;">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="table-responsive">
												<table class="cc" style="margin-top:12px;">
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
													<tbody>
														<?php
															$qry = "CALL `redefectiva`.`SP_LOAD_CONTACTOS_GENERAL`($idSubcadena, 0, 2);";
															$res = $RBD->query($qry);
															if ( !$RBD->error() ) {
																if ( mysqli_num_rows($res)>0 ) {
																	while ( $row = mysqli_fetch_assoc($res) ) {
																		$nombreCompleto = $row['nombreCompleto'];
																		$nombre = $row['nombreContacto'];
																		$apellidoPaterno = $row['apPaternoContacto'];
																		$apellidoMaterno = $row['apMaternoContacto'];
																		if ( !preg_match('!!u', $nombreCompleto) ) {
																			$nombreCompleto = utf8_encode($nombreCompleto);
																		}
																		if ( !preg_match('!!u', $nombre) ) {
																			$nombre = utf8_encode($nombre);
																		}
																		if ( !preg_match('!!u', $apellidoPaterno) ) {
																			$apellidoPaterno = utf8_encode($apellidoPaterno);
																		}
																		if ( !preg_match('!!u', $apellidoMaterno) ) {
																			$apellidoMaterno = utf8_encode($apellidoMaterno);
																		}
																		echo "<tr>";
																		echo "<td class='tdtablita'>".$nombreCompleto."</td>";
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
																			<a href='#' onclick='DeleteContactos3(".$HidSubCad.", ".$row['idContacto'].",2)''>
																				<img src='../../../img/delete2.png'>
																			</a>";
																			if ( $row["subcadena"] == 0 && $esEscritura ) {
																				echo "<a href='#Contactos' data-toggle='modal'
																					onclick=\"EditarContactos('$row[idContacto]',
																					'".$nombre."',
																					'".$apellidoPaterno."',
																					'".$apellidoMaterno."',
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
									</div>
								</div>
								<!--Inicia Modal-->
								<!--Final Row-->
								<?php } ?>
								<!--Inicio de Panel de FORELO-->
								<?php if ( $idSubcadena != 0 ) { ?>
								<div class="col-xs-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo"><i class="fa fa-credit-card"></i> Informaci&oacute;n de la Cuenta</div>
										<!--<div class="panel-body" style="height:250px;overflow-y: auto;overflow-x: hidden;">-->
                                        	<div class="panel-body">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="table-responsive">
												<table class="generales">
													<thead>
														<tr><th>Cuenta FORELO</th><th>Tipo Cuenta FORELO</th><th>Referencia Bancaria</th></tr>
													</thead>
													<tbody>
														<td><?php echo $oSubcadena->getCuentaForelo(); ?></td>
														<td>
															<?php
																$query = "CALL `redefectiva`.`SP_GET_CORRESPONSALES_CUENTA`($idCadena, $HidSubCad, -1, '');";
																$result = $RBD->query($query);
																if ( $RBD->error() == '' ) {
																	$corresponsalesFORELOSubcadena = $result->num_rows;
																	$corresponsalesFORELOIndividual = $totalCorresponsales - $corresponsalesFORELOSubcadena;
																	echo "Individual - $corresponsalesFORELOSubcadena Corresponsal(es) comparten FORELO de la Sub Cadena y $corresponsalesFORELOIndividual Corresponsal(es) no";
																} else {
																	echo "Error al consultar base de datos";
																}
															?>
														</td>
														<td><?php echo $oSubcadena->getReferenciaBancaria(); ?></td>
													</tbody>
												</table>
                                                <table class="generales">
													<thead>
														<tr>
															<th>Tipo Reembolso</th>
															<th>Tipo Comisi&oacute;n</th>
                                                            <th>Pago de Reembolso</th>
                                                            <th>Pago de Comisi&oacute;n</th>
														</tr>
													</thead>
                                                    <tbody>
                                                    	<?php
															$sql_datosCuenta = "SELECT
															CLIENTE.`idTipoReembolso`, CLIENTE.`idTipoComision`,
															CUENTA.`idTipoLiqReembolso`, CUENTA.`idTipoLiqComision`
															FROM `redefectiva`.`dat_cliente` AS CLIENTE
															INNER JOIN `redefectiva`.`ops_cuenta` AS CUENTA
															ON CUENTA.`numCuenta` = CLIENTE.`numCuenta`
															WHERE CLIENTE.`idCliente` = ".$oSubcadena->getId()."
															AND CLIENTE.`idEstatus` = 0;";
															$resultado_datosCuenta = $RBD->query($sql_datosCuenta);
															$tipoReembolso = "N/A";
															$tipoComision = "N/A";
															$pagoReembolso = "N/A";
															$pagoComision = "N/A";
															if ( $RBD->error() == '' ) {
																if ( mysqli_num_rows($resultado_datosCuenta) > 0 ) {
																	$row = mysqli_fetch_array($resultado_datosCuenta);
																	if ( $row["idTipoReembolso"] == 1 ) {
																		$tipoReembolso = "Corte";
																	} else if ( $row["idTipoReembolso"] == 2 ) {
																		$tipoReembolso = "Integro";
																	}
																	if ( $row["idTipoComision"] == 1 ) {
																		$tipoComision = "Con IVA";
																	} else if ( $row["idTipoComision"] == 2 ) {
																		$tipoComision = "Sin IVA";
																	}
																	if ( $row["idTipoLiqReembolso"] == 1 ) {
																		$pagoReembolso = "FORELO";
																	} else if ( $row["idTipoLiqReembolso"] == 2 ) {
																		$pagoReembolso = "Banco";
																	}
																	if ( $row["idTipoLiqComision"] == 1 ) {
																		$pagoComision = "FORELO";
																	} else if ( $row["idTipoLiqComision"] == 2 ) {
																		$pagoComision = "Banco";
																	}
																}
															}
														?>
														<tr>
                                                        	<td><?php echo $tipoReembolso; ?></td>
                                                            <td><?php echo $tipoComision; ?></td>
                                                            <td><?php echo $pagoReembolso; ?></td>
                                                            <td><?php echo $pagoComision; ?></td>
                                                        </tr>
                                                    </tbody>                                                
                                                </table>
												<table class="cc">
													<thead>
														<tr>
															<th>Tipo de Movimiento</th>
															<th>Tipo de Instrucci&oacute;n</th>
															<th>Destino</th>
															<th>CLABE</th>
															<th>Banco</th>
															<th>Beneficiario</th>
															<th>RFC</th>
															<th>Correo</th>
															<th>Acciones</th>
														</tr>
													</thead>
													<tbody class="tablapequena">
														<?php
														$q = "CALL `redefectiva`.`SP_GET_CUENTAS`($idCadena, $idSubCadena, -1, -1, '');";
														$sql = $RBD->query($q);
														if(!$RBD->error()){
														if(mysqli_num_rows($sql) > 0){
														while($row = mysqli_fetch_assoc($sql)){
																		$beneficiario = $row['Beneficiario'];
																		if ( !preg_match('!!u', $beneficiario) ) {
																			$beneficiario = utf8_encode($beneficiario);
																		}
																		echo "<tr>";
															echo "<td class='tdtablita'>".$row['tipoMovimiento']."</td>";
															echo "<td class='tdtablita'>".$row['tipoDePago']."</td>";
															echo "<td class='tdtablita'>".$row['Destino']."</td>";
															echo "<td class='tdtablita'>".$row['CLABE']."</td>";
															echo "<td class='tdtablita'>".$row['nombreBanco']."</td>";
																				echo "<td class='tdtablita'>".$beneficiario."</td>";
															echo "<td class='tdtablita'>".$row['RFC']."</td>";
															echo "<td class='tdtablita'>".$row['Correo']."</td>";
																				if ( $esEscritura ) {
															echo "<td class='tdtablita'><img src='../../../img/delete.png' onclick='DeleteConfiguracionCuenta(".$row['idConfiguracion'].")'></td>";
																				} else {
																					echo "<td class='tdtablita'></td>";
																				}
														echo "</tr>";
														}
														}
														else{
														echo "<tr><td colspan='9' class='tdtablita'>No hay informaci&oacute;n para mostrar.</td></tr>";
														}
														}
														else{
														echo "<tr><td colspan='9' class='tdtablita'>No es posible mostrar la informaci&oacute;n.</td></tr>";
														}
														?>
													</tbody>
												</table>
											</div>
											<?php if($esEscritura){ ?>
											<a href="#Cuenta" data-toggle="modal" class="btn btnconsultabig btn-xs" style="margin-bottom:20px;">Nuevo <i class="fa fa-plus"></i></a></br>
											<?php } ?>
											<div class="theadresponsivea" style="margin-top:15px; margin-bottom:6px;"> <i class="fa fa-dollar"></i> Cuotas </div>
											<table class="cc">
												<thead>
													<tr>
														<th></th>
														<td>Descripci&oacute;n</td>
														<td>Importe</td>
														<td >Fecha Inicio</td>
														<td>Cargado a</td>
													</tr>
												</thead>
												<tbody>
													<?php
													$idCadena = $oSubcadena->getCadena();
													$idSubCadena = $oSubcadena->getId();
													$q = "CALL `redefectiva`.`SP_LOAD_CARGOS`($idCadena, $idSubCadena, -1);";
													$sql = $RBD->query($q);
													
													if(mysqli_num_rows($sql) >= 1){
													while($row = mysqli_fetch_assoc($sql)){
													$cargadoA = "";
													
													switch($row["cargado_a"]){
													case 1:
													$cargadoA = "Cadena";
													break;
													case 2:
													$cargadoA = "SubCadena";
													break;
													case 3:
													$cargadoA = "Corresponsal";
													break;
													}
													
													if(!empty($row["nombreCadena"])){
													$lbl = $row["nombreCadena"];
													}
													if(!empty($row["nombreSubCadena"])){
													$lbl = $row["nombreSubCadena"];
													}
													if(!empty($row["nombreCorresponsal"])){
													$lbl = $row["nombreCorresponsal"];
													}
															
																$nombreConcepto = $row['nombreConcepto'];
																if ( !preg_match('!!u', $nombreConcepto) ) {
																	$nombreConcepto = utf8_encode($nombreConcepto);
																}
																
													echo "<tr>";
														echo "<td class='tdtablita'>".$lbl."</td>";
														//echo "<td class='tdtablita'>".$row['nombreConcepto']."</td>";
																		echo "<td class='tdtablita'>".$nombreConcepto."</td>";
														echo "<td class='tdtablita' align='right'>\$ ".number_format($row['importe'],2)."</td>";
														echo "<td class='tdtablita' align='center'>".$row['fechaInicio']."</td>";
														echo "<td class='tdtablita'>".$cargadoA."</td>";
													echo "</tr>";
													}
													}
													else{
													echo "<tr><td colspan='5' class='tdtablita'>No hay informaci&oacute;n para mostrar.</td></tr>";
													}
													?>
												</tbody>
											</table>
											<!-- <a href="#Cuenta" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-edit"></i></a> -->
										</div>
									</div>
								</div>
								<!--Final Row--></div><!--Final Row-->
								<div class="row">
									<!--Final Row--></div><!--Final Row-->
									<?php } ?>
									<!--MODALES MODALES MODALES-->
									<div class="modal fade" id="Cuenta" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-consulta">
													<span><i class="fa fa-edit"></i></span>
													<h3><?php echo $nombreSubcadena; ?></h3>
													<span class="rev-combo pull-right"><button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button></span>
												</div>
												<div class="modal-body">
													
													<legend>Configuraci&oacute;n de Liquidación</legend>
													<form class="form-horizontal">
														
														<div class="form-group">
															<label class="col-xs-1 control-label">Tipo de Movimiento:</label>
															<div class="col-xs-3">
																<select id="ddlTipoMovimiento" class="form-control m-bot15">
																	<option value="1">Pago</option>
																</select>
															</div>
															
															
															<label class="col-xs-1 control-label">Tipo de Instrucci&oacute;n:</label>
															<div id="selectInstruccion" class="col-xs-3">
																<select id="ddlInstruccion" class="form-control m-bot15">
																	<option value="-1">Seleccione</option>
																</select>
															</div>
															
															
															<label class="col-xs-1 control-label">Destino:</label>
															<div class="col-xs-3">
																<select id="ddlDestino"  class="form-control m-bot15">
																	<option value="-1">Seleccione</option>
																	<option value="1">Forelo</option>
																	<option value="2">Banco</option>
																</select>
															</div>
														</div>
														
														<!--<div class="form-group">
															<label class="col-xs-1 control-label">IVA:</label>
															<div class="col-xs-3">
																<select class="form-control m-bot15">
																	<option>16%</option>
																	<option>16%</option>
																</select>
															</div>
														</div>-->
														
														
														
														<div id="fieldsBanco" style="display:none;">
															<legend>Cuenta</legend>
															
															<div class="form-group">
																<label class="col-xs-1 control-label">CLABE:</label>
																<div class="col-xs-3">
																	<input type="text" class="form-control" placeholder="" id="txtCLABE">
																</div>
															</div>
															
															<div class="form-group">
																<label class="col-xs-1 control-label">Banco:</label>
																<div class="col-xs-3">
																	<input type="text" class="form-control" placeholder="" id="txtBanco">
																</div>
																
																<label class="col-xs-1 control-label">No. Cuenta:</label>
																<div class="col-xs-3">
																	<input type="text" id="txtNumCuenta" class="form-control" placeholder="" value=""></div>
																	<input type="hidden" class="form-control" placeholder="" id="txtNumCuentaForelo" value="<?php echo $oSubcadena->getCuentaForelo(); ?>">
																</div>
																
																
																<div class="form-group">
																	<label class="col-xs-1 control-label">Beneficiario:</label>
																	<div class="col-xs-3">
																		<input type="text" class="form-control" placeholder="" id="txtBeneficiario">
																	</div>
																	
																	
																	<label class="col-xs-1 control-label">RFC:</label>
																	<div class="col-xs-3">
																		<input type="text" class="form-control" placeholder="" id="txtRFC">
																	</div>
																	
																	<label class="col-xs-1 control-label">Correo:</label>
																	<div class="col-xs-3">
																		<input type="text" class="form-control" placeholder="" id="txtCorreo">
																	</div>
																</div>
															</div>
														</form>
													</div>
													<div class="modal-footer">
														<!-- <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button> -->
														<!-- <button class="btn btn-success" type="button">Agregar</button> -->
														<button class="btn btnconsultabig consulta pull-right" type="button" onClick="crearConf()">Guardar</button>
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
													<h3><?php echo utf8_encode($oSubcadena->getNombre()); ?></h3>
													<span class="rev-combo pull-right"><button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button></span>
												</div>
												<div class="modal-body">
													<legend> <i class="fa fa-book"></i> Datos Generales</legend>
													<form class="form-horizontal">
														<div class="form-group">
															<label class="col-xs-2 control-label">Referencia:</label>
															<div class="col-xs-3">
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
															<label class="col-xs-2 control-label">Estatus:</label>
															<div class="col-xs-3">
																<?php
																	$idE = $oSubcadena->getIdStatus();
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
															<label class="col-xs-2 control-label">Tel&eacute;fono:</label>
															<div class="col-xs-3">
																<input type="text" class="form-control" placeholder="Teléfono de la Sub Cadena" id="txttel1"
																onkeyup="validaTelefono2(event,'txttel1')" onKeyPress="return validaTelefono1(event,'txttel1')"
																maxlength="20"
                                                                value="<?php
                                                                	//echo $oSubcadena->getTel1();
																	$telefono = $oSubcadena->getTel1();
																	if ( isset($telefono) && !empty($telefono) ) {
																		//echo $telefono;
																		$tel = "";
																		$telefono = str_replace("-", "", $telefono);
																		$longitudTelefono = strlen($telefono);
																		$telefono = str_split($telefono);
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
																	}																	
																?>">
															</div>
															<label class="col-xs-2 control-label">Correo:</label>
															<div class="col-xs-3">
																<input type="text" class="form-control"
                                                                placeholder="Correo de la Sub Cadena" id="txtMailSubCadena"
																value="<?php
																	$email = $oSubcadena->getMail();
																	if ( isset($email) ) {
																		echo $email;
																	} else {
																		echo "";
																	}
																?>"
                                                                maxlength="100">
															</div>
														</div>
														<div class="form-group">
															<label class="col-xs-2 control-label">Ejecutivo de Cuenta:</label>
															<div class="col-xs-3">
																<input type="hidden" id="ddlEjecutivo" value="<?php echo $oSubcadena->getIdEjecutivoCuenta(); ?>"/>
																<input type="text" class="form-control ui-autocomplete-input" id="txtEjecutivoCuenta"
																value="<?php
																	$idEjecutivoCuenta = $oSubcadena->getIdEjecutivoCuenta();
																	$nombreEjecutivoCuenta = $oSubcadena->getNombreEjecutivoCuentas();
																	if ( $idEjecutivoCuenta > 0 ) {
																		if ( !preg_match('!!u', $nombreEjecutivoCuenta) ) {
																			$nombreEjecutivoCuenta = utf8_encode($nombreEjecutivoCuenta);
																		}
																		echo $nombreEjecutivoCuenta;
																	} else {
																		echo "";
																	}
																?>"
																placeholder="Nombre de Ejecutivo de Cuenta">
															</div>
															<label class="col-xs-2 control-label">Ejecutivo de Venta:</label>
															<div class="col-xs-3">
																<input type="hidden" id="ddlEjecutivoVenta" value="<?php echo $oSubcadena->getIdEjecutivoVentas(); ?>"/>
																<input type="text" class="form-control" placeholder="Nombre de Ejecutivo de Venta" id="txtEjecutivoVenta"
																value="<?php
																	$idEjecutivoVenta = $oSubcadena->getIdEjecutivoVentas();
																	$nombreEjecutivoVenta = $oSubcadena->getNombreEjecutivoVentas();
																	if ( $idEjecutivoVenta > 0 ) {
																		if ( !preg_match('!!u', $nombreEjecutivoVenta) ) {
																			$nombreEjecutivoVenta = utf8_encode($nombreEjecutivoVenta);
																		}
																		echo $nombreEjecutivoVenta;
																	} else {
																		echo "";
																	}
																?>">
															</div>
														</div>
														<div class="form-group">
															<label class="col-xs-2 control-label">IVA:</label>
															<div class="col-xs-3">
																<select id="ddlIva" class="form-control m-bot15">
																	<option value="-1">Seleccione IVA</option>
																	<?php
																	$idIva = $oSubcadena->getIdIva();
																	$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_IVA`();");
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
														onClick="UpdateSubCadena(<?php echo $idSubcadena ?>,0,1)">Agregar</button>
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
													<h3><?php echo $nombreSubcadena; ?></h3>
													<span class="rev-combo pull-right"><button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button></span>
												</div>
												<div class="modal-body">
													<legend> <i class="fa fa-users"></i> Contactos</legend>
													<form class="form-horizontal">
														<div class="form-group">
															<input type="hidden" id="HidContacto">
															<label class="col-xs-1 control-label">Nombre(s):</label>
															<div class="col-xs-3">
																<input type="text" class="form-control" placeholder=""
																id="txtContacNom" maxlength="100">
															</div>
															
															<label class="col-xs-1 control-label">A.Paterno:</label>
															<div class="col-xs-3">
																<input type="text" class="form-control" placeholder=""
																id="txtContacAP" maxlength="50">
															</div>
															
															<label class="col-xs-1 control-label">A.Materno:</label>
															<div class="col-xs-3">
																<input type="text" class="form-control" placeholder=""
																id="txtContacAM" maxlength="50">
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-xs-1 control-label">Tel&eacute;fono:</label>
															<div class="col-xs-3">
																<input type="text" class="form-control" placeholder="" id="txtTelContac"
                                                                onKeyUp="validaTelefono2(event,'txtTelContac')"
                                                                onKeyPress="return validaTelefono1(event,'txtTelContac')"
                                                                maxlength="20">
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
													<!--<button class="btn btn-success" type="button">Agregar</button>-->
                                                        <button class="btn btnconsultabig consulta pull-right" type="button" onClick="UpdateContactos(<?php echo $HidSubCad; ?>,2);">Agregar</button>
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
												<h3><?php echo $nombreSubcadena; ?></h3>
												<span class="rev-combo pull-right"><button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button></span>
											</div>
											<div class="modal-body">
												<legend> <i class="fa fa-home"></i> Direcci&oacute;n</legend>
												<form class="form-horizontal" id="datos-generales">
													<div class="form-group">
														<label class="col-xs-1 control-label">Pa&iacute;s:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" id="txtPais"
															onkeypress="VerificarDireccionCad(tipoDireccion, false);"
															onkeyup="VerificarDireccionCad(tipoDireccion, false);"
															value="<?php echo ($oSubcadena->getPais() > 0)? utf8_encode($oSubcadena->getNombrePais()) : ''; ?>" placeholder=""
															maxlength="50">
															<input type="hidden" id="paisID" value="<?php echo ($oSubcadena->getPais() > 0)? $oSubcadena->getPais() : ''; ?>" />
														</div>
													</div>
													
													
													<div class="form-group">
														<label class="col-xs-1 control-label">Calle:</label>
														<div class="col-xs-3">
															<?php
																											$calle = $oSubcadena->getCalle();
															?>
															<input type="text" class="form-control" id="txtcalle"
															onkeypress="VerificarDireccionCad(tipoDireccion, false);"
															onkeyup="VerificarDireccionCad(tipoDireccion, false);"
															value="<?php echo (isset($calle) && !empty($calle) && $calle != "No tiene") ? utf8_encode($calle) : ''; ?>" placeholder=""
															maxlength="50">
														</div>
														
														<label class="col-xs-1 control-label">No. Exterior:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" id="txtnext"
															onkeypress="VerificarDireccionCad(tipoDireccion, false);"
															onkeyup="VerificarDireccionCad(tipoDireccion, false);"
															value="<?php echo ( $oSubcadena->getNext() != "No tiene" ) ? $oSubcadena->getNext() : ""; ?>" placeholder=""
															maxlength="50">
														</div>
														
														
														<label class="col-xs-1 control-label">No. Interior:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" id="txtnint"
															onkeypress="VerificarDireccionCad(tipoDireccion, false);"
															onkeyup="VerificarDireccionCad(tipoDireccion, false);"
															value="<?php echo ( $oSubcadena->getNint() != "No tiene" ) ? $oSubcadena->getNint() : ""; ?>" placeholder=""
															maxlength="50">
														</div>
													</div>
													
													
													<div class="form-group">
														<label class="col-xs-1 control-label">C.P:</label>
														<div class="col-xs-3">
															<input type="text" class="form-control" id="txtcp"
															onkeypress="VerificarDireccionCad(tipoDireccion, false);"
															onkeyup="buscarColonias();VerificarDireccionCad(tipoDireccion, false);"
															maxlength="5"
															value="<?php echo ( $oSubcadena->getCP() > 0 && $oSubcadena->getCP() != "No tiene" ) ? $oSubcadena->getCP() : ''; ?>"
															placeholder="">
														</div>
														
														
														<label class="col-xs-1 control-label">Colonia:</label>
														<div class="col-xs-3">
															<!--<select class="form-control m-bot15">
																<option>Las Torres</option>
																<option>Las Brisas</option>
																<option>Del Paseo</option>
															</select>-->
															<?php
																$colZ = $oSubcadena->getColonia();
																$cdZ = $oSubcadena->getCiudad();
																$edoZ = $oSubcadena->getEstado();
																$paisZ = $oSubcadena->getPais();
																$cpZ = $oSubcadena->getCP();
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
																$paisZ = $oSubcadena->getPais();
																$edoZ = $oSubcadena->getEstado();
																
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
																$cdZ = $oSubcadena->getCiudad();
																$edoZ = $oSubcadena->getEstado();
																$paisZ = $oSubcadena->getPais();
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
											</div>
											<div class="modal-footer">
												<!-- <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button> -->
												<button class="btn btnconsultabig consulta pull-right" onClick="editarDireccion(tipoDireccion, 2, <?php echo $idSubcadena; ?>)" type="button">Agregar</button>
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
											<span class="rev-combo pull-right"><button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button></span>
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
													<label class="col-xs-1 control-label">Agregado:</label> Única.
												</div>
											</form>
										</div>
										<div class="modal-footer">
											<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
											<button class="btn btn-success" type="button">Agregar</button>
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
												<h3><?php echo $nombreSubcadena; ?></h3>
												<span class="rev-combo pull-right">Corresponsales</span>
											</div>
											<div class="modal-body">
												<div class="table-responsive">
													<div id="tablacentrada">
														<?php
														echo "<div>";
															echo "<div style=\"text-align:center;\">";
																echo "<span>";
																echo $totalCorresponsales;
																echo "</span>";
																echo " Corresponsales - ";
																		echo "<span>";
																echo $nombreSubcadena;
																echo "</span>";
																echo "<br />";
															echo "</div>";
															echo "<div style=\"text-align:center;\">";
																echo "<span>";
																echo "<a href=\"#\" onclick=\"downloadExcelListaCorresponsales('$idCadena', '$idSubcadena', '$nombreSubcadena', '$totalCorresponsales')\">";
																	echo "Descargar a Excel";
																echo "</a>";
																echo "</span>";
																echo "<br />";
																echo "<br />";
															echo "</div>";
														echo "</div>";
														?>
													</div>
													<div id="tablaReporte">
														<?php
														$res = $RBD->SP("CALL `redefectiva`.`SP_LOAD_CORRESPONSALES`($idCadena, $idSubcadena);");
														echo "<table class=\"tablacentrada\" style='width:100%;'>";
															echo "<thead>";
																echo "<tr>";
																	echo "<th style='width:33%;'>ID</th>";
																	echo "<th style='width:33%;'>Nombre del Corresponsal</th>";
																	echo "<th style='width:33%;'>Ver</th>";
																echo "</tr>";
															echo "</thead>";
															echo "<tbody>";
																if ( mysqli_num_rows($res) > 0 ) {
																while ( $corresponsal = mysqli_fetch_array($res) ) {
																	echo "<tr>";
																		echo "<td style='width:33%;'>{$corresponsal[0]}</td>";
																		echo "<td style='width:33%;'>".htmlentities($corresponsal[1])."</td>";
																		echo "<td style='width:33%;'>";
																			echo "<a href=\"#\" onclick=\"GoCorresponsal({$corresponsal[0]})\">";
																				//echo "<img src=\"../../img/buscar.png\">";
																			echo "<i class='fa fa-search'></i>";
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
												<!--<button class="btn btn-success" type="button">Agregar</button>-->
												<button class="btn btnconsultabig consulta pull-right" data-dismiss="modal" type="button" >Salir</button>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" id="txtNombreSubCadena" value="<?php echo $nombreSubcadena; ?>" />
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
			<!--<script src="../../inc/js/advanced-form-components.js"></script>-->
			<!--Cierre del Sitio-->
			<script src="../../inc/js/RE.js" type="text/javascript"></script>
			<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
			<script src="../../inc/js/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js"></script>
			<script src="../../inc/js/_Clientes.js" type="text/javascript"></script>
			<script src="../../inc/js/_Consulta.js" type="text/javascript"></script>
			<script src="../../inc/js/_ConsultaCadena.js" type="text/javascript"></script>
			<script src="../../inc/js/_ConsultasGeneral.js" type="text/javascript"></script>
			<script src="../../inc/js/_ConsultaSubCadena.js" type="text/javascript"></script>
			<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
			<script src="../../inc/js/_PrealtaPreSubCadena.js" type="text/javascript"></script>
			<!--Generales-->
			<script src="../../inc/js/common-scripts.js"></script>            
			<script src="../../inc/js/jquery.numeric.js" type="text/javascript"></script>
			<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
			<script src="../../inc/js/jquery.tablesorter.js" type="text/javascript"></script>
			<script>
			<?php
				$paisZ = $oSubcadena->getPais();
				if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" || $paisZ == "No tiene" ) {
			?>
			var tipoDireccion = "nacional";
			<?php } else { ?>
			var tipoDireccion = "extranjera";
			<?php } ?>
			</script>
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
				<script>
					$(function(){
						cargarTiposInstruccion();
					});
				</script>
			</body>
		</html>