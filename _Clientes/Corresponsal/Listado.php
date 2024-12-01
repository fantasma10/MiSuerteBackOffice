<?php 
#########################################################
#
#Codigo PHP
#

	error_reporting(0);
	ini_set('display_errors', 0);
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];

	$submenuTitulo = "Consulta";
	$subsubmenuTitulo ="Corresponsal";
	$tipoDePagina = "Mixto";
	$idOpcion = 1;
	$esEscritura = false;

	if(!isset($_SESSION['Permisos'])){
		header("Location: ../../logout.php"); 
		 exit();
	}

	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../error.php"); 
		 exit(); 	
	}

	if ( esLecturayEscrituraOpcion($idOpcion) ) {
		$esEscritura = true;
	}
		
	if(!isset($_POST['hidCorresponsalX']) || $_POST['hidCorresponsalX'] == -1){
		header("Location: ../../main.php"); 
		 exit(); 
	}	

	$HidCor = $_POST['hidCorresponsalX'];


	$oCorresponsal = new Corresponsal($RBD, $WBD);
	$oCorresponsal->load($HidCor);

	$_POST['hidCadenaX'] = $oCorresponsal->getIdCadena();
	$_POST['hidSubCadenaX'] = $oCorresponsal->getIdSubCadena();

	function acentos($txt){
		return (!preg_match("!!u", $txt))? utf8_encode($txt) : $txt;
	}
	
	/*var_dump("REMESAS: ".$oCorresponsal->REMESAS);
	var_dump("BANCARIOS: ".$oCorresponsal->BANCARIOS);
	var_dump("SORTEOS: ".$oCorresponsal->SORTEOS);*/
	
	$idCadena = $oCorresponsal->getIdCadena();
	$idSubcadena = $oCorresponsal->getIdSubCadena();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	 <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
		<title>Consulta Corresponsal</title>

		<!--meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8"-->

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--Favicon-->
		<link rel="shortcut icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">

		<link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/css/themes/base/jquery.ui.all.css" />

		<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
		<!--ASSETS-->
		<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
		<!-- ESTILOS MI RED -->
		<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" />

		<script>
		<?php 
			$paisZ = $oCorresponsal->getIdPais();
			if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
		?>
				var tipoDireccion = "nacional";
		<?php
			}
			else{
		?>
				var tipoDireccion = "extranjera";
		<?php
			}
		?>	
		</script>
</head>
<body>
	
<?php include($_SERVER['DOCUMENT_ROOT']."/inc/cabecera2.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/inc/menu.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/inc/formPase.php"); ?>

<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-xs-12">

				<section class="panelrgb">
				<!--Panel de Mini Paneles-->
					<section class="panel">
						<div class="titulorgb">
							<span><i class="fa fa-clipboard"></i></span>
							<h3><?php echo acentos($oCorresponsal->getNombreCor());?></h3><span class="rev-combo pull-right">Consulta<br>Corresponsal</span>
						</div>
						<div class="consultabody">
							<input type="hidden" id="idCorresponsal" value="<?php echo $oCorresponsal->getId(); ?>"><input type="hidden" name="hidCorresponsal" id="hidCorresposal" />
							<input type="hidden" name="txtnomcor" id="txtnomcor" value="<?php  echo $oCorresponsal->getNombreCor(); ?>" />
							<input type="hidden" name="txttel2" id="txttel2" onkeyup="validaTelefono2(event,'txttel2')" onkeypress="return validaTelefono1(event,'txttel2')" maxlength="15" value="<?php  echo $oCorresponsal->getTel2(); ?>"/>
							<input type="hidden" id="ddlReferencia" value="<?php echo $oCorresponsal->getIdRef();?>">
							<input type="hidden" name="txtfax" id="txtfax" onkeyup="validaTelefono2(event, 'txtfax')" onkeypress="return validaTelefono1(event, 'txtfax')" value="<?php echo $oCorresponsal->getFax();?>" maxlength="15" />
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
											<?php echo $oCorresponsal->getId(); ?>
										</div>
									</div>
								</div>
								<!--Mini Panel-->
								<!--MiniPanel-->
								<div class="col-xs-2">
									<div class="minipanel">
										<div class="icono orange">
											<i class="fa fa-3x fa-calendar"></i>
										</div>
										<div class="linea">
											Vencimiento
										</div>
										<div class="dato">
											<?php echo $oCorresponsal->getFechaVencimiento(); ?>
										</div>
									</div>
								</div>
								<!--MiniPanel-->
								<div class="col-xs-2">
									<div class="minipanel">
										<div class="icono green">
											<i class="fa fa-3x fa-globe"></i>
										</div>
										<div class="linea">
											Estatus
										</div>
										<div class="dato">
											<?php echo $oCorresponsal->getStatus(); ?>
										</div>
									</div>
								</div>
								<!--Mini Panel-->
								<div class="col-xs-2">
									<div class="minipanel">
										<div class="icono yellow">
											<i class="fa fa-3x fa-folder"></i>
										</div>
										<div class="linea">
											Expediente
										</div>
										<div class="dato">
											<?php echo $oCorresponsal->getNombreExpediente();?>
										</div>
									</div>
								</div>
								<!--MiniPanel-->
								<div class="col-xs-2">
									<div class="minipanel">
										<div class="icono versionorange">
											<i class="fa fa-3x fa-shopping-cart"></i>
										</div>
										<div class="linea">
											Versión
										</div>
										<div class="dato">
											<?php echo $oCorresponsal->getVersion(); ?>
										</div>
									</div>
								</div>
								<div class="col-xs-3">
									<div class="minipanel">
										<div class="icono red">
											<i class="fa fa-3x fa-dollar"></i>
										</div>
										<div class="linea">
											FORELO
										</div>
										<div class="dato">
										<?php
											$idCadena = $oCorresponsal->getIdCadena();
											$idSubCadena = $oCorresponsal->getIdSubCadena();

											echo $oCorresponsal->getCuentaOwner()." ";
											echo "\t".$oCorresponsal->getForelo();
											echo " \$".number_format($oCorresponsal->getSaldoCuenta(), 2);
										?>
										</div>
									</div>
								</div>
								<!--Final de los Mini Paneles-->
								<button class="btn btnconsulta btn-xs" onclick="irANuevaBusqueda();">Nueva Búsqueda <i class="fa fa-search"></i></button>
							</div>
						</div>
					</section>
            
				
                <div class="row">
					<!--Panel de Datos Generales-->
					<div class="col-xs-6 col-sm-6 col-xs-12">
						<div class="panel">
							<div class="rgbtitulo"><i class="fa fa-book"></i> Datos Generales </div>
							<div class="panel-body" style="height:300px;">
								<!--Tabla Cadena y Sub Cadena-->
								<table class="generales">
									<thead>
										<tr>
											<th>Cadena</th>
											<th>Cliente</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo "ID: ".$idCadena." - ".utf8_encode($oCorresponsal->getCadena()); ?></td>
										<td><?php echo "ID: ".$idSubcadena." - ".utf8_encode($oCorresponsal->getSubCadena()); ?></td>
										</tr>
									</tbody>
									<thead>
										<tr>
											<th>Giro</th><th>Teléfono</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo utf8_encode($oCorresponsal->getNombreGiro()); ?></td>
											<td>
											<?php
												$telefonoCorr = $oCorresponsal->getTel1();
												if ( isset($telefonoCorr) && !empty($telefonoCorr) ) {
													$tel="";
													$telefonoCorr = str_replace("-", "", $telefonoCorr);
													$telefono = str_split($telefonoCorr);
													$longitudTelefono = strlen($telefonoCorr);
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
										</tr>
									</tbody>
									<thead>
										<tr>
											<th>Representante Legal</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo $oCorresponsal->getNombreRepresentanteLegal();?></td>
										</tr>
									</tbody>
									<thead>
										<tr>
											<th>Fecha de Vencimiento</th>
											<th>Fecha de Inicio</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<?php echo $oCorresponsal->getFechaVencimiento(); ?>
											</td>
											<td>
												<?php echo $oCorresponsal->getFechaInicio(); ?>
											</td>
										</tr>
									</tbody>
									<thead>
										<tr>
											<th>Ejecutivo de Venta</th>
											<th>Ejecutivo de Cuenta</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo utf8_encode($oCorresponsal->getNombreEjecutivoVenta()); ?></td>
											<td><?php echo utf8_encode($oCorresponsal->getNombreEjecutivoCuenta()); ?></td>
										</tr>
									</tbody>
                                    <thead>
										<tr>
											<?php if ( $oCorresponsal->REMESAS || $oCorresponsal->SORTEOS ) { ?>
                                            <th>Remesas y Sorteos</th>
                                            <?php } ?>
                                            <?php if ( $oCorresponsal->BANCARIOS ) { ?>
											<th>Bancarios</th>
                                            <?php } ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<?php if ( $oCorresponsal->REMESAS || $oCorresponsal->SORTEOS ) { ?>
                                            <td><?php echo $oCorresponsal->getNombreEjecutivoAfiliacionIntermedia(); ?></td>
                                            <?php } ?>
                                            <?php if ( $oCorresponsal->BANCARIOS ) { ?>
											<td><?php echo $oCorresponsal->getNombreEjecutivoAfiliacionAvanzada(); ?></td>
                                            <?php } ?>
										</tr>
									</tbody>
									<thead>
										<tr>
											<th>Usuario de Alta</th>
											<th>Estatus</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo $oCorresponsal->getNombreUsuarioAlta();?></td>
											<td><?php echo $oCorresponsal->getStatus();?></td>
										</tr>
									</tbody>
								</table>
							</div>

							<!--Editar-->
							<div class="panel-footer">
								<div class="row">
									<div class="col-xs-12">
										<?php
											if($esEscritura){
										?>
											<a href="#datos" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-edit"></i></a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--Fin Editar-->

					<!--Panel de Datos Generales-->
					<div class="col-xs-6 col-sm-6 col-xs-12">
						<div class="panel">
							<div class="rgbtitulo">
								<i class="fa fa-home"></i> Dirección
							</div>
							<div class="panel-body" style="height:102px;overflow-y: auto;overflow-x: hidden;">
								<!--Tabla Cadena y Sub Cadena-->
								<div class="direccion" style="margin-bottom:9px;">
									<?php
										echo utf8_encode($oCorresponsal->getDireccion());
										echo "<br/>";
										echo utf8_encode("Col. ".$oCorresponsal->getColonia()." CP ".$oCorresponsal->getCodigoPostal());
										echo "<br/>";
										echo utf8_encode($oCorresponsal->getCiudad().", ".$oCorresponsal->getEstado().", ".$oCorresponsal->getPais());
									?>
								</div>
								
								<?php

									if(!empty($oCorresponsal->INICIODIA1) && !empty($oCorresponsal->CIERREDIA1)
										&& !empty($oCorresponsal->INICIODIA2) && !empty($oCorresponsal->CIERREDIA2)
										&& !empty($oCorresponsal->INICIODIA3) && !empty($oCorresponsal->CIERREDIA3)
										&& !empty($oCorresponsal->INICIODIA4) && !empty($oCorresponsal->CIERREDIA4)
										&& !empty($oCorresponsal->INICIODIA5) && !empty($oCorresponsal->CIERREDIA5)
										&& !empty($oCorresponsal->INICIODIA6) && !empty($oCorresponsal->CIERREDIA6)
										&& !empty($oCorresponsal->INICIODIA7) && !empty($oCorresponsal->CIERREDIA7)){

										$i1 = date("H:i", strtotime($oCorresponsal->INICIODIA1));
										$f1 = date("H:i", strtotime($oCorresponsal->CIERREDIA1));
										$i2 = date("H:i", strtotime($oCorresponsal->INICIODIA2));
										$f2 = date("H:i", strtotime($oCorresponsal->CIERREDIA2));
										$i3 = date("H:i", strtotime($oCorresponsal->INICIODIA3));
										$f3 = date("H:i", strtotime($oCorresponsal->CIERREDIA3));
										$i4 = date("H:i", strtotime($oCorresponsal->INICIODIA4));
										$f4 = date("H:i", strtotime($oCorresponsal->CIERREDIA4));
										$i5 = date("H:i", strtotime($oCorresponsal->INICIODIA5));
										$f5 = date("H:i", strtotime($oCorresponsal->CIERREDIA5));
										$i6 = date("H:i", strtotime($oCorresponsal->INICIODIA6));
										$f6 = date("H:i", strtotime($oCorresponsal->CIERREDIA6));
										$i7 = date("H:i", strtotime($oCorresponsal->INICIODIA7));
										$f7 = date("H:i", strtotime($oCorresponsal->CIERREDIA7));
								?>
								<!--div class="theadresponsivea">
									<i class="fa fa-clock-o"></i> Horario
								</div-->
								<table class="ip">
									<thead>
										<tr>
											<th>Lunes</th>
											<th>Martes</th>
											<th>Miércoles</th>
											<th>Jueves</th>
											<th>Viernes</th>
											<th>Sábado</th>
											<th>Domingo</th>
										</tr>
									</thead>
									<tbody class="tablapequena">                                     
										<tr>
											<td class="tdtablita"><?php echo $i1." a ".$f1;?></td>
											<td class="tdtablita"><?php echo $i2." a ".$f2;?></td>
											<td class="tdtablita"><?php echo $i3." a ".$f3;?></td>
											<td class="tdtablita"><?php echo $i4." a ".$f4;?></td>
											<td class="tdtablita"><?php echo $i5." a ".$f5;?></td>
											<td class="tdtablita"><?php echo $i6." a ".$f6;?></td>
											<td class="tdtablita"><?php echo $i7." a ".$f7;?></td>
									</tr>
									</tbody>
								</table>
								<?php } ?>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-xs-12">
										<?php
											if($esEscritura){
										?>
										<a href="#direccion" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-edit"></i></a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div><!--Fin Editar-->

					<!--Inicio de Panel de Configuración de Acceso-->
					<div class="col-xs-6 col-sm-6 col-xs-12">
						<div class="panel">
							<div class="rgbtitulo">
								<i class="fa fa-desktop"></i> Configuración
							</div>
							<div class="panel-body">
								<!--Tabla Cadena y Sub Cadena-->
								<table class="generales">
									<thead>
										<tr>
											<th>Tipo de Acceso</th>
											<th>Código de Acceso</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo $oCorresponsal->getTipoAcceso();?></td>
											<td><?php echo $oCorresponsal->getCodigos();?></td>
											<td></td>
										</tr>
									</tbody>
								</table>
								<table class="ip">
                                	<thead>
                                		<tr>
											<th>#</th>
											<th>Interface</th>
											<th>Tipo de Conexión</th>
											<th>Estado</th>
											<th>IP</th>
											<th>Password</th>
											<th>Nivel</th>
                                      	</tr>
                                  	</thead>
                                  	<tbody>
										<?php
											$idCadena		= $oCorresponsal->getIdCadena();
											$idSubCadena	= $oCorresponsal->getIdSubCadena();
											$idCorresponsal= $oCorresponsal->getId();

											$query = "CALL nautilus.SP_GET_CONFCONEXION($idCadena, $idSubCadena, $idCorresponsal)";
											$sql = $RBD->query($query);
											if(!$RBD->error()){
												if(mysqli_num_rows($sql) >= 1){
													while($row = mysqli_fetch_assoc($sql)){
														echo "<tr><td class='tdtablita' align='right'>".$row["idClientAccess"]."</td>";
														echo "<td class='tdtablita' align='right'>".$row["idEntity"]."</td>";
														echo "<td class='tdtablita'>".$row["serverDescription"]."</td>";
														echo "<td class='tdtablita'>".$row["descEstatus"]."</td>";
														echo "<td class='tdtablita' align='center'>".$row["IP"]."</td>";
														echo "<td class='tdtablita'>".$row["password"]."</td>";
														echo "<td class='tdtablita' align='right'>".$row["idServerLogLevel"]."</td></tr>";
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
								<!--Tabla Cadena y Sub Cadena-->
								<table class="generales">
									<thead>
										<tr>
											<th>Permisos</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<?php
													$categoria = $oCorresponsal->getConfPermisos(3);
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
															$idGrupo = $oCorresponsal->getIdGrupo();
															$sql = $RBD->query("CALL `redefectiva`.`SP_TIENE_PERMISOS_GRUPO`($idGrupo)");
															$row = mysqli_fetch_assoc($sql);
															if($row['cuenta'] >= 1){
																echo "de Grupo (Default)";
															}
															else{
																echo '<span style="color:red">Sin Permisos</span>';
															}
														break;
													}
												?>
											</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
        
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-xs-12">
						<div class="panel">
							<div class="rgbtitulo">
								<i class="fa fa-bank"></i> Corresponsal Bancario
							</div>
							<div class="panel-body">
								<!--Tabla Cadena y Sub Cadena-->
                    		    <table class="bancario">
                        			<thead>
                        				<tr>
                        					<th>Corresponsal Bancario</th>
                        					<th>Estado</th>
                        				</tr>
                        			</thead>
                        			<tbody>
                        				<tr>
                        					<td>
                        						<?php
													$lbl = "";

													$idVersion = $oCorresponsal->getIdVer();
													$idCliente = $oCorresponsal->getIdSubCadena();
													$sql = $RBD->query("CALL `redefectiva`.`SP_BUSCA_FAMILIA_VERSION`($idVersion, 3, $idCliente)");

													$res = mysqli_fetch_assoc($sql);
													$nF = $res['cuenta'];
													if($res['cuenta'] > 0){
														//$lbl .= '<a href="#Bancario" data-toggle="modal">';
													}

													$idEstatusBancario = $oCorresponsal->getIdEstatusBancario();
													if($idEstatusBancario > 0){
														$lblEstatus = "Inactivo";
													}
													else{
														$lblEstatus = "Activo";
													}


													if($oCorresponsal->esBancario()){
														$lbl .= 'S&iacute; <!--i class="fa fa-check-circle"></i-->';
														//$lbl .= '</a>';
													}
													else{
														$lbl = 'No <i class="fa fa-times-circle"></i>';
													}

													if($res['cuenta'] > 0){
														//$lbl .= '</a>';
													}

													echo $lbl;
												?>
                        					</td>
                        					<td>
                        						<?php
													echo $lblEstatus;
                        						?>
                        					</td>
                        				</tr>
                        			</tbody>
								</table>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-xs-12">
										<?php
											if($esEscritura && $nF == 1){
										?>
										<a href="#Bancario" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-edit"></i></a>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-6 col-sm-6 col-xs-12">
						<div class="panel" >
							<div class="rgbtitulo"><i class="fa fa-bar-chart-o"></i>
								Reportes
							</div>
							<div class="panel-body">
								<?php
									$idCorresponsal = $oCorresponsal->getId();
									$numCuenta = $oCorresponsal->getNumCuenta();
								?>
								<!--Tabla Cadena y Sub Cadena-->
								<ul class="reportes">
									<li><a href="#Reportes" data-toggle="modal" onclick="showOperaciones(<?php echo $idCorresponsal;?>);"> Operaciones </a></li>
									<li><a href="#Reportes" data-toggle="modal" onclick="showMovimientosCorresponsal(<?php echo $numCuenta?>);"> Movimientos de FORELO </a>
								    <li><a href="#Reportes" data-toggle="modal" onclick="showDepositosCorresponsal(<?php echo $numCuenta?>)">Depósitos </a>
									<li><a href="#Reportes" data-toggle="modal" onclick="showRemesasCorresponsal(<?php echo $idCorresponsal;?>)">Remesas Pendientes</a>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="panel">
							<div class="rgbtitulo">
								<i class="fa fa-users"></i> Información de Contactos
							</div>
							<div class="panel-body">
								<!--Tabla Cadena y Sub Cadena-->
								<table class="cc">
									<thead>
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
											$qry = "CALL `redefectiva`.`SP_LOAD_CONTACTOS_GENERAL`($HidCor, 0, 3)";
											$res = $RBD->query($qry);
											if(!$RBD->error()){
												if(mysqli_num_rows($res)>0){
													while($row = mysqli_fetch_assoc($res)){
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
															//echo "<td class='tdtablita'>".$tel."</td>";
															echo "<td class='tdtablita' align='right'>".$row['extTelefono1']."</td>";
															echo "<td class='tdtablita'>".$row['correoContacto']."</td>";
															echo "<td class='tdtablita'>".utf8_encode($row['descTipoContacto'])."</td>";
															echo "<td class='tdtablita'>";
																if($esEscritura){
																	echo "
																	<a href='#' onclick='DeleteContactos2(".$HidCor.", ".$row['idContacto'].",3)''>
																	<img src='../../../img/delete2.png'>
																	</a>";
																	

																	if($row["subcadena"] == 0){
																		echo "<a href='#NewContacto' data-toggle='modal'
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
												}
												else{
													echo "<tr><td colspan='6'>No hay informaci&oacute;n para mostrar.</td></tr>";
												}
											}
											else{
												echo "<tr><td colspan='6'>No es posible mostrar la informaci&oacute;n.</td></tr>";
											}
										?>
									</tbody>
								</table>
								<?php
									if($esEscritura){
								?>
									<a href="#NewContacto" data-toggle="modal" class="btn btnconsultabig btn-xs" onclick="AgregarContacto(event);">Nuevo <i class="fa fa-plus"></i></a>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-xs-12">
						<div class="panel">
							<div class="rgbtitulo"><i class="fa fa-credit-card"></i>
								Información de la Cuenta
							</div>
							<div class="panel-body">
								<!--Tabla Cadena y Sub Cadena-->
								<table class="generales">
									<thead>
										<tr>
											<th>Cuenta FORELO</th>
											<th>Tipo Cuenta FORELO</th>
											<th>Referencia Bancaria</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<?php echo $oCorresponsal->getNumCuenta(); ?>
											</td>
											<td>
												<?php
													echo $oCorresponsal->getLabelTipoCuentaForelo();
												?>
											</td>
											<td>
												<?php echo $oCorresponsal->getReferenciaBancaria(); ?>
											</td>
										</tr>
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
                                        WHERE `idCliente` = ".$oCorresponsal->getIdSubCadena()."
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

								<?php
									if($oCorresponsal->esForeloIndividual()){
								?>
								<table class="cc">
									<thead>
										<tr>
											<th>Tipo de Movimiento</th>
											<th>Tipo de Instrucción</th>
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
											$q = "CALL `redefectiva`.`SP_GET_CUENTAS`($idCadena, $idSubCadena, $HidCor, -1, '');";
											//var_dump("q: $q");
											$sql = $RBD->query($q);
											if(!$RBD->error()){
												if(mysqli_num_rows($sql) > 0){
													while($row = mysqli_fetch_assoc($sql)){
														echo "<tr>";
															echo "<td class='tdtablita'>".$row['tipoMovimiento']."</td>";
															echo "<td class='tdtablita'>".$row['tipoDePago']."</td>";
															echo "<td class='tdtablita'>".$row['Destino']."</td>";
															echo "<td class='tdtablita'>".$row['nombreBanco']."</td>";
															echo "<td class='tdtablita'>".$row['CLABE']."</td>";
															echo "<td class='tdtablita'>".codificarUTF8($row['Beneficiario'])."</td>";
															echo "<td class='tdtablita'>".$row['RFC']."</td>";
															echo "<td class='tdtablita'>".$row['Correo']."</td>";
															echo "<td class='tdtablita'><img src='../../../img/delete.png' onclick='DeleteConfiguracionCuenta(".$row['idConfiguracion'].")'></td>";
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
								<?php
									}
								?>
								<?php
									if($esEscritura){
										if($oCorresponsal->esForeloIndividual()){
								?>
								<a href="#Cuenta" data-toggle="modal" class="btn btnconsultabig btn-xs" style="margin-bottom:20px;">Nuevo <i class="fa fa-plus"></i></a></br>
								<?php
										}
									}
								?>

								<div class="lt">
									<i class="fa fa-dollar"></i> Cuotas
								</div>
															
								<table class="cc">
									<thead>
										<tr>
											<th>Descripción</th>
											<th>Importe</th>
											<th>Fecha Inicio</th>
											<th>Cargado a</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$idCadena = $oCorresponsal->getIdCadena();
											$idSubCadena = $oCorresponsal->getIdSubCadena();
											$q = "CALL `redefectiva`.`SP_LOAD_CARGOS`($idCadena, $idSubCadena, $HidCor);";
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

													echo "<tr>";
														echo "<td class='tdtablita'>".$lbl."</td>";
														echo "<td class='tdtablita'>".$row['nombreConcepto']."</td>";
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
								<!--a href="#" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-pencil"></i></a-->
							</div>
						</div>
					</div>
      
					<!--MODAL DATOS GENERALES-->
					<div class="modal fade" id="datos" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-consulta">
									<span>
										<i class="fa fa-edit"></i>
									</span>
									<h3>Datos Generales</h3>
									
									<span class="rev-combo pull-right">
										<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
									</span>
								</div>
								<div class="modal-body">
									<form class="form-horizontal">
										<div class="form-group">
											<!--label class="col-xs-1 control-label">Cliente:</label>
											<div class="col-xs-3">
												<input type="text" class="form-control m-bot15">
											</div-->
	                                 
											<label class="col-xs-1 control-label">Giro:</label>
											<div class="col-xs-3">
												<select name="ddlGiro" id="ddlGiro" class="form-control m-bot15">
													<option value="-1">Seleccione un Giro</option>
													<?php
														$idGiro = $oCorresponsal->getGiro();
														$sql = "CALL `redefectiva`.`SP_LOAD_GIROS`();";
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
											</div>
										</div>
                                     
										<div class="form-group">
											<label class="col-xs-1 control-label">Teléfono:</label>
											<div class="col-xs-3">
												<input type="text" class="form-control" placeholder="Teléfono del Corresponsal" id="txttel1" onkeyup="validaTelefono2(event,'txttel1')" onkeypress="return validaTelefono1(event,'txttel1')" maxlength="20"
                                                value="<?php
													$telefonoCorr = $oCorresponsal->getTel1();
													if ( !preg_match("/\d{2}\-\d{3}\-\d{3}\-\d{4}$/", $telefonoCorr) ) {
														$tel="";
														$telefonoCorr = str_replace("-", "", $telefonoCorr);
														$telefono = str_split($telefonoCorr);
														$longitudTelefono = strlen($telefonoCorr);
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
													} else {
														$tel = $telefonoCorr;
													}
													echo $tel;
												?>">
											</div>

											<label class="col-xs-2 space control-label">Fecha de Vencimiento:</label>
											<div class="col-xs-2">
												<!--  form-control-inline input-medium default-date-picker -->
												<input class="form-control"  size="16" type="text" id="txtFechaVenc" onkeypress="return validaFecha(event,'txtFechaVenc')" onkeyup="validaFecha2(event,'txtFechaVenc')" maxlength="10" value="<?php echo $oCorresponsal->getFechaVencimiento(); ?>"/>
												<span class="help-block">Seleccionar Fecha.</span>
											</div>

											<label class="col-xs-2 control-label">Estatus:</label>
											<div class="col-xs-2">
												<?php
													$idE = $oCorresponsal->getIdStatus();

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
												<select name="ddlEstatus" id="ddlEstatus" onchange="/*UpdateCorresponsal(8);*/" class="form-control m-bot15">
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
                                       
										<div class="titulosexpress"><i class="fa fa-user"></i> Ejecutivos y Agentes</div>
                                       
										<div class="form-group">
											<label class="col-xs-3 control-label">Ejecutivo de Venta:</label>
											<div class="col-xs-3">
												<input type="hidden" id="ddlEjecutivoVenta" value="<?php echo $oCorresponsal->getIdEjecutivoVenta();?>"/>
												<input type="text" class="form-control" placeholder="Nombre de Ejecutivo de Venta" id="txtEjecutivoVenta" value="<?php echo  utf8_encode($oCorresponsal->getNombreEjecutivoVenta());?>">
											</div>

											<label class="col-xs-3 control-label">Ejecutivo de Cartera:</label>
											<div class="col-xs-3">
												<input type="hidden" id="ddlEjecutivo" value="<?php echo $oCorresponsal->getIdEjecutivoCuenta();?>"/>
												<input type="text" class="form-control" placeholder="Nombre de Ejecutivo de Cuenta" id="txtEjecutivoCuenta" value="<?php echo utf8_encode($oCorresponsal->getNombreEjecutivoCuenta());?>">
											</div>
										</div>
                                          
										<div class="form-group">
											<label class="col-xs-3 control-label"> Remesas y Sorteos:</label>
											<div class="col-xs-3">
												<input type="hidden" id="ddlEjecutivoAfIn" value="<?php echo $oCorresponsal->getIdEjecutivoAfiliacionIntermedia();?>"/>
												<input type="text" class="form-control"
                                                placeholder="Nombre de Ejecutivo de Cuenta"
                                                id="txtEjecutivoAfiliacionIntermedia"
                                                value="<?php echo utf8_encode($oCorresponsal->getNombreEjecutivoAfiliacionIntermedia());?>"
                                                <?php
                                                	if ( !$oCorresponsal->REMESAS && !$oCorresponsal->SORTEOS ) {
														echo "disabled=disabled";
													}
												?>>
											</div>
											<label class="col-xs-3 control-label">Bancarios:</label>
											<div class="col-xs-3">
												<input type="hidden" id="ddlEjecutivoAfAv" value="<?php echo $oCorresponsal->getIdEjecutivoAfiliacionAvanzada();?>"/>
												<input type="text" class="form-control"
                                                placeholder="Nombre de Ejecutivo de Cuenta"
                                                id="txtEjecutivoAfiliacionAvanzada"
                                                value="<?php echo utf8_encode($oCorresponsal->getNombreEjecutivoAfiliacionAvanzada());?>"
                                                <?php
                                                	if ( !$oCorresponsal->BANCARIOS ) {
														echo "disabled=disabled";
													}
												?>>
											</div>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button class="btn btnconsultabig consulta pull-right" type="button" onClick="UpdateCorresponsalGenerales(<?php echo $HidCor; ?>,3)">Guardar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
<!--Cierre Modal-->

				<!--MODAL DE DIRECCION-->
				<div class="modal fade" id="direccion" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-consulta">
								<span><i class="fa fa-edit"></i></span>
								<h3>Dirección</h3>
								<span class="rev-combo pull-right">
									<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
								</span>
							</div>
							
							<div class="modal-body">
								<form class="form-horizontal">
									<div class="form-group">
										<label class="col-xs-2 control-label">País:</label>
										<div class="col-lg-3" id="selectpaises">
											<input type="text" placeholder="" id="cPais" class="form-control" value="<?php echo ((!preg_match('!!u', $oCorresponsal->getPais()))? utf8_encode($oCorresponsal->getPais()): $oCorresponsal->getPais());?>">	
											<input type="hidden" id="ddlPais" value="<?php echo $oCorresponsal->getIdPais();?>">
											<input type="hidden" id="paisID" value="<?php echo $oCorresponsal->getIdPais();?>">
											<?php
												$paisZ = $oCorresponsal->getIdPais();
												if ( $paisZ == "" || $paisZ == "-2" || $paisZ == "164" ) {
														$tipoDireccion = "nacional";
												} else {
														$tipoDireccion = "extranjera";
												}
											?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-2 control-label">Calle:</label>
										<div class="col-xs-2">
											<input type="text" maxlength="50" class="form-control m-bot15" name="txtcalle" id="txtcalle" onblur="VerificarDireccionSub(tipoDireccion);"  value="<?php echo (!preg_match('!!u', $oCorresponsal->getCalle()))?utf8_encode($oCorresponsal->getCalle()) : $oCorresponsal->getCalle(); ?>" />
										</div>

										<label class="col-xs-2 control-label">Número Interior:</label>
										<div class="col-xs-2">
											<input type="text" maxlength="50" class="form-control m-bot15" name="txtnint" id="txtnint" onblur="VerificarDireccionSub(tipoDireccion);" value="<?php echo $oCorresponsal->getDirNInt2(); ?>" />
										</div>

										<label class="col-xs-2 control-label">Número Exterior:</label>
										<div class="col-xs-2">
											<input type="text" maxlength="50" class="form-control" name="txtnext" id="txtnext" onblur="VerificarDireccionSub(tipoDireccion);"  value="<?php echo $oCorresponsal->getDirNExt2(); ?>" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-2 control-label">Código Postal:</label>
										<div class="col-xs-2">
											<input type="text" class="form-control" name="txtcp" id="txtcp" maxlength="5" onblur="VerificarDireccionCorr2(tipoDireccion);" onkeyup="buscarColonias()" value="<?php echo $oCorresponsal->getCodigoPostal(); ?>" />
										</div>

										<label class="col-xs-2 control-label">Colonia:</label>
										<div class="col-xs-2" id="divCol">
											<?php
												$colZ	= $oCorresponsal->getIdColonia();
												$cdZ	= $oCorresponsal->getIdCiudad();
												$edoZ	= $oCorresponsal->getIdEstado();
												$paisZ	= $oCorresponsal->getIdPais();

												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlColonia\" id=\"ddlColonia\" onchange=\"VerificarDireccionCorr(tipoDireccion);\" style=\"display:block;\" class=\"form-control m-bot15\">";
												}
												else{
													echo "<select name=\"ddlColonia\" id=\"ddlColonia\" onchange=\"VerificarDireccionCorr(tipoDireccion);\" style=\"display:none;\" class=\"form-control m-bot15\">";
												}
											
												$sql2 = "CALL `redefectiva`.`SP_LOAD_COLONIAS`(164, '$edoZ', '$cdZ');";
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
												}
												else{
													echo "<option value='-1'>Seleccione una Colonia</option>";
												}
												echo "</select>";																									
												if ( $tipoDireccion == "extranjera" ) {
													$sql = "CALL `redefectiva`.`SP_GET_COLONIA`($paisZ, $colZ);";
													$result = $RBD->SP($sql);
													if ( $RBD->error() == '' ) {
														if ( $result->num_rows > 0 ) {
															list( $nombreColoniaExtranjera ) = $result->fetch_array();
														}
														else{
															$nombreColoniaExtranjera = "";
														}
													}
												}
												if ( $tipoDireccion == "nacional" ) {
													echo "<input type=\"text\" style=\"display:none;\" class=\"form-control\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\" />";
												}
												else if( $tipoDireccion == "extranjera" ){
													echo "<input type=\"text\" style=\"display:block;\" class=\"form-control\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													name=\"txtColonia\" id=\"txtColonia\" value=\"$nombreColoniaExtranjera\" />";													
												}
											?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-2 control-label">Estado:</label>
										<div class="col-xs-2" id="divEdo">
											<?php
												$paisZ	= $oCorresponsal->getIdPais();
												$edoZ	= $oCorresponsal->getIdEstado();
												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlEstado\" id=\"ddlEstado\" class=\"form-control m-bot15\" 
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													onchange=\"setValue('ddlPais',164); buscaSelectCiudad(false)\"
													style=\"display:block;\"
													disabled=\"disabled\">";																
												}
												else {
													echo "<select name=\"ddlEstado\" id=\"ddlEstado\"  class=\"form-control m-bot15\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
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
														$r[1] = utf8_encode($r[1]);
														if ( $edoZ == $r[0] )
															$d.="<option value='$r[0]' selected='selected'>$r[1]</option>";
														else
															$d.="<option value='$r[0]'	>$r[1]</option>";   
													}
													$d.="</select>";
													echo $d;
												}
												else {
													echo "<option value='-2'>Seleccione un Estado (Error)</option></select>";
												}
												echo "</select>";

												if ( $tipoDireccion == "extranjera" ) {
													$sql = "CALL `redefectiva`.`SP_GET_ESTADO`($paisZ, $edoZ);";
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
													echo "<input type=\"text\" class=\"form-control\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													style=\"display:none;\" name=\"txtEstado\"
													id=\"txtEstado\" value=\"$nombreEstadoExtranjero\" />";																
												}
												else if ( $tipoDireccion == "extranjera" ) {
													echo "<input type=\"text\" class=\"form-control\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													style=\"display:block;\" name=\"txtEstado\"
													id=\"txtEstado\" value=\"$nombreEstadoExtranjero\" />";																
												}
											?>
										</div>

										<label class="col-xs-2 control-label">Ciudad:</label>
										<div class="col-xs-2" id="divCd">
											<?php
												$cdZ	= $oCorresponsal->getIdCiudad();
												$edoZ	= $oCorresponsal->getIdEstado();
												$paisZ	= $oCorresponsal->getIdPais();

												if ( $tipoDireccion == "nacional" ) {
													echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\" class=\"form-control m-bot15\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													style=\"display:block;\"
													disabled=\"disabled\">";														
												}
												else if ( $tipoDireccion == "extranjera" ) {
													echo "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\" class=\"form-control m-bot15\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													style=\"display:none;\"
													disabled=\"disabled\">";															
												}													
												$sql2 = "CALL `redefectiva`.`SP_LOAD_CIUDADES`(164, '$edoZ');";
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
												}
												else {
													echo "<option value='-2'>Seleccione una Ciudad</option></select>";
												}
												echo "</select>";

												if ( $tipoDireccion == "extranjera" ) {
													$sql = "CALL `redefectiva`.`SP_GET_CIUDAD`($paisZ, $edoZ, $cdZ);";
													$result = $RBD->SP($sql);
													if ( $RBD->error() == '' ) {
														if ( $result->num_rows > 0 ) {
															list( $nombreCiudadExtranjera ) = $result->fetch_array();
														}
														else {
															$nombreCiudadExtranjera = "";
														}
													}
												}
												
												if ( $tipoDireccion == "nacional" ) {
													echo "<input type=\"text\" class=\"form-control\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													name=\"txtMunicipio\" id=\"txtMunicipio\"
													style=\"display:none;\"
													value=\"$nombreCiudadExtranjera\" />";	
												}
												else if ( $tipoDireccion == "extranjera" ) {
													echo "<input type=\"text\" class=\"form-control\"
													onblur=\"VerificarDireccionCorr(tipoDireccion);\"
													name=\"txtMunicipio\" id=\"txtMunicipio\"
													style=\"display:block;\"
													value=\"$nombreCiudadExtranjera\" />";															
												}
											?>
										</div>
									</div>
								</form>

								<div class="legmed"><i class="fa fa-clock-o"></i> Horario</div>
								<?php
									$i1 = (!empty($oCorresponsal->INICIODIA1))? date("H:i", strtotime($oCorresponsal->INICIODIA1)) : $oCorresponsal->INICIODIA1;
									$f1 = (!empty($oCorresponsal->CIERREDIA1))? date("H:i", strtotime($oCorresponsal->CIERREDIA1)) : $oCorresponsal->CIERREDIA1;
									$i2 = (!empty($oCorresponsal->INICIODIA2))? date("H:i", strtotime($oCorresponsal->INICIODIA2)) : $oCorresponsal->INICIODIA2;
									$f2 = (!empty($oCorresponsal->CIERREDIA2))? date("H:i", strtotime($oCorresponsal->CIERREDIA2)) : $oCorresponsal->CIERREDIA2;
									$i3 = (!empty($oCorresponsal->INICIODIA3))? date("H:i", strtotime($oCorresponsal->INICIODIA3)) : $oCorresponsal->INICIODIA3;
									$f3 = (!empty($oCorresponsal->CIERREDIA3))? date("H:i", strtotime($oCorresponsal->CIERREDIA3)) : $oCorresponsal->CIERREDIA3;
									$i4 = (!empty($oCorresponsal->INICIODIA4))? date("H:i", strtotime($oCorresponsal->INICIODIA4)) : $oCorresponsal->INICIODIA4;
									$f4 = (!empty($oCorresponsal->CIERREDIA4))? date("H:i", strtotime($oCorresponsal->CIERREDIA4)) : $oCorresponsal->CIERREDIA4;
									$i5 = (!empty($oCorresponsal->INICIODIA5))? date("H:i", strtotime($oCorresponsal->INICIODIA5)) : $oCorresponsal->INICIODIA5;
									$f5 = (!empty($oCorresponsal->CIERREDIA5))? date("H:i", strtotime($oCorresponsal->CIERREDIA5)) : $oCorresponsal->CIERREDIA5;
									$i6 = (!empty($oCorresponsal->INICIODIA6))? date("H:i", strtotime($oCorresponsal->INICIODIA6)) : $oCorresponsal->INICIODIA6;
									$f6 = (!empty($oCorresponsal->CIERREDIA6))? date("H:i", strtotime($oCorresponsal->CIERREDIA6)) : $oCorresponsal->CIERREDIA6;
									$i7 = (!empty($oCorresponsal->INICIODIA7))? date("H:i", strtotime($oCorresponsal->INICIODIA7)) : $oCorresponsal->INICIODIA7;
									$f7 = (!empty($oCorresponsal->CIERREDIA7))? date("H:i", strtotime($oCorresponsal->CIERREDIA7)) : $oCorresponsal->CIERREDIA7;
								?>
			                    <div class="table-responsive">
									<table  class="tabla-horario">
										<tbody>
											<tr align="center">
												<td class="helpme"><span>Lunes</span></td>
												<td><span>Martes</span></td>
												<td><span>Miércoles</span></td>
												<td><span>Jueves</span></td>
												<td><span>Viernes</span></td>
												<td><span>Sábado</span></td>
												<td><span>Domingo</span></td>
											</tr>
											<tr align="center">
												<td>De:</td><td>De:</td><td>De:</td><td>De:</td><td>De:</td><td>De:</td><td>De:</td>
											</tr>
											<tr align="center">
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt1" value="<?php echo $i1;?>"></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt3" value="<?php echo $i2;?>"></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt5" value="<?php echo $i3;?>"></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt7" value="<?php echo $i4;?>"></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt9" value="<?php echo $i5;?>"></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt11" value="<?php echo $i6;?>"></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt13" value="<?php echo $i7;?>"></td>
											</tr>
											<tr align="center">
												<td>A:</td>
												<td>A:</td>
												<td>A:</td>
												<td>A:</td>
												<td>A:</td>
												<td>A:</td>
												<td>A:</td>
											</tr>

											<tr align="center">
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt2"  value="<?php echo $f1;?>"></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt4"  value="<?php echo $f2;?>"> <!--Checkboxes Ocultos--<input type="checkbox">--></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt6"  value="<?php echo $f3;?>"> <!--Checkboxes Ocultos--<input type="checkbox">--></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt8"  value="<?php echo $f4;?>"> <!--Checkboxes Ocultos--<input type="checkbox">--></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt10"  value="<?php echo $f5;?>"> <!--Checkboxes Ocultos--<input type="checkbox">--></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt12"  value="<?php echo $f6;?>"> <!--Checkboxes Ocultos--<input type="checkbox">--></td>
												<td><input type="text" class="padhorario form-control" placeholder="" id="txt14"  value="<?php echo $f7;?>"> <!--Checkboxes Ocultos--<input type="checkbox">--></td>
											</tr>
											<tr>
												<td style="border:none;"><input type="checkbox" id='checkall'> &nbsp; <label for="checkall">Copiar Horario</label></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="modal-footer">
								<button class="btn btnconsultabig consulta pull-right" type="button" onclick="UpdateCorresponsalDireccion(<?php echo $HidCor; ?>,3)">Guardar</button>
							</div>
						</div>
					</div>
				</div>
			<!--/div-->
<!--Cierre Modal-->

                    <!--MODALES MODALES MODALES-->
				<div class="modal fade" id="Bancario" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-consulta">
								<span><i class="fa fa-edit"></i></span>
								<h3>Corresponsal Bancario</h3>
								<span class="rev-combo pull-right">
									<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
								</span>
							</div>

							<div class="modal-body">
								<div class="row">
									<div class="col-xs-3">
										<div class="titulosexpress-first">
											<i class="fa fa-bank"></i> Estatus
										</div>
										<form class="form-horizontal">
											<div class="form-group">
												<div class="col-xs-12">
													<?php
														$idB = $oCorresponsal->getIdEstatusBancario();
														$s0 = " ";
														$s1 = " ";
														$s2 = " ";
														$s3 = " ";
														switch($idB){
															case "0": $s0 = "selected"; break;
															case "3": $s3 = "selected"; break;
														}
													?>
													<select class="form-control m-bot15" id="ddlCorBanc">
														<?php
															echo '<option value="0" '.(($s0 == "selected")? "selected=selected": '').'>Activo</option>';
														echo '<option value="3" '.(($s3 == "selected")? "selected=selected": '').'>Inactivo</option>';
														?>
													</select>
												</div>
											</div>
										</form>
									</div>
                        
									<div class="col-xs-8 modalbancario">
										<div class="titulosexpress-first">
											<i class="fa fa-plus"></i> Agregar Banco
										</div>
										<form class="form-horizontal">
											<div class="form-group">
												<div class="col-xs-4" id="divddlBanco">
													<select name='ddlBanco' id="ddlBanco" class="form-control m-bot15">
														<option value='-1'>Seleccione</option>
														<?php
															$idCorresponsal = $oCorresponsal->getId();
															$sql = $RBD->query("CALL `redefectiva`.`SP_LOAD_CORRESPONSALIAS`($idCorresponsal)");
															while($row = mysqli_fetch_assoc($sql)){
																echo "<option value='".$row['idBanco']."'>".utf8_encode($row['descBanco'])."</option>";
															}
														?>
													</select>
												</div>
                            					<div class="col-xs-1">
                            						<a href="#" onclick="agregarCorresponsaliaBanc(<?php echo $oCorresponsal->getId(); ?>);">
														<?php
															if($esEscritura){
														?>
														<i class="fa fa-plus"></i>
														<?php
															}
														?>
													</a>
                            					</div>

                            					<div class="col-xs-6 agregados">
													<div class="bancos" id="divcorrbanc">
														
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>

								<div class="modal-footer">
									<?php if($esEscritura){ ?>
										<button class="btn btnconsultabig consulta pull-right" type="button" onclick="UpdateCorresponsalBancario(<?php echo $HidCor; ?>,3)">Guardar</button>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
<!--Cierre Modal-->


				<!--MODAL REPORTES-->
				<div class="modal fade" id="Reportes" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-consulta">
								<span><i class="fa fa-pencil"></i></span>
								<h3><?php echo utf8_encode($oCorresponsal->getNombreCor());?></h3>
								<span class="rev-combo pull-right">Operaciones</span>
							</div>
							<div class="modal-body">
								<div class="table-responsive">
									<div id='emergente' style="text-align:center;vertical-align:middle;width:95%;height:95%;position:absolute;z-index:500000;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto; display:none;">
    									<img alt='Cargando...' src='<?php echo $PATHRAIZ; ?>/img/cargando3.gif' id='imgcargando' />
									</div>
									<div class="adv-table" id="divTbl">

									</div>                                    
								</div>
							</div>
							<div class="modal-footer">
								<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
								<!--button class="btn btn-success" type="button" id="btnDtlReporte" disabled>Ver Detalle</button-->
							</div>
						</div>
					</div>
          		</div>
				<!--/div-->
				<!--Cierre Modal-->

				<!--MODALES MODALES MODALES-->
				<div class="modal fade" id="NewContacto" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-consulta">
								<span><i class="fa fa-edit"></i></span>
								<h3></h3>
								<span class="rev-combo pull-right">
									<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
								</span>
							</div>
							<div class="modal-body">
								<div class="legmed">
									<i class="fa fa-users"></i> Contactos del Cliente
								</div>

								<table class="cc" style="margin-top:12px;">
									<thead class="theadtablita">
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
											$idSubCadena = $oCorresponsal->getIdSubCadena();
											$sql = "CALL redefectiva.`SP_LOAD_CONTACTOS_GENERAL`($idSubCadena, 0, 2);";									
											$res = $RBD->SP($sql);

											if(!$RBD->error()){
												if(mysqli_num_rows($res) > 0){
													while($row = mysqli_fetch_assoc($res)){
														echo '<tr>';
														echo '<td class="tdtablita">'.codificarUTF8($row["nombreCompleto"]).'</td>';
														echo '<td class="tdtablita">'.($row["telefono1"]).'</td>';
														echo '<td class="tdtablita">'.($row["extTelefono1"]).'</td>';
														echo '<td class="tdtablita">'.$row["correoContacto"].'</td>';
														echo '<td class="tdtablita">'.utf8_encode($row["descTipoContacto"]).'</td>';
														echo '<td class="tdtablita">';
															echo '<a href="#" onclick="agregarContactoDeSubCadena('.$row["idContacto"].', '.$HidCor.');"><i class="fa fa-plus"></i></a>';
														echo '</td>';
														echo '</tr>';
													}
												}
												else{
													echo "<tr><td colspan='5'>No hay informaci&oacute;n para mostrar.</td></tr>";
												}
											}
											else{
												echo "<tr><td colspan='5'>No es posible mostrar la informaci&oacute;n.</td></tr>";
											}
										?>
									</tbody>
								</table>

								<div class="legmed"> <i class="fa fa-user"></i> Nuevo Contacto</div>
								<form class="form-horizontal">
									<div class="form-group">
										<input type="hidden" id="HidContacto" value="-2">
										<label class="col-xs-1 control-label">Nombre:</label>
										<div class="col-xs-3">
											<input type="text" class="form-control" placeholder="" id="txtContacNom" maxlength="100">
										</div>

										<label class="col-xs-1 control-label">A.Paterno:</label>
										<div class="col-xs-3">
											<input type="text" class="form-control" placeholder="" id="txtContacAP" maxlength="50">
										</div>

										<label class="col-xs-1 control-label">A.Materno:</label>
										<div class="col-xs-3">
											<input type="text" class="form-control" placeholder="" id="txtContacAM" maxlength="50">
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-1 control-label">Teléfono:</label>
										<div class="col-xs-3">
											<input type="text" class="form-control" placeholder="" id="txtTelContac" onkeyup="validaTelefono2(event,'txtTelContac')"
                                            onkeypress="return validaTelefono1(event,'txtTelContac')" maxlength="20" value="">
										</div>

										<label class="col-xs-1 control-label">Extensión:</label>
										<div class="col-xs-3">
											<input type="text" class="form-control" placeholder="" id="txtExtTelContac" onkeyup="validaNumeroEntero2(event,'txtTelContac')" onkeypress="return validaNumeroEntero(event,'txtTelContac')" maxlength="10">
										</div>

										<label class="col-xs-1 control-label">Correo:</label>
										<div class="col-xs-3">
											<input type="text" class="form-control" placeholder="" id="txtMailContac" maxlength="100">
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-1 control-label">Tipo de Contacto:</label>
										<div class="col-lg-3">
											<select name="ddlTipoContac" id="ddlTipoContac"  class="form-control m-bot15">
												<option value="-2" selected>Selecciona</option>
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
								<button class="btn btnconsultabig consulta pull-right" type="button"  onclick="UpdateContactosCor(<?php echo $HidCor; ?>,3);">Guardar</button>
							</div>
						</div>
					</div>
				</div>
				<!--Cierre Modal-->

				<!--MODALES MODALES MODALES-->
				<div class="modal fade" id="Cuenta" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-consulta">
								<span><i class="fa fa-edit"></i></span>
								<h3></h3>
								<span class="rev-combo pull-right">
									<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
								</span>
							</div>

							<div class="modal-body">
								<div class="titulosexpress-first">
									<i class="fa fa-dollar"></i>Configuración de Liquidacion
								</div>

								<form class="form-horizontal">
									<div class="form-group">
										<label class="col-xs-2 control-label">Tipo de Movimiento:</label>
										<div class="col-xs-2">
										  	<select id="ddlTipoMovimiento" class="form-control m-bot15">
												<option value="0">Pago</option>
											</select>
										</div>
                            
                                          
										<label class="col-xs-2 control-label">Tipo de Instrucción:</label>
										<div  id="selectInstruccion" class="col-xs-2">
											<select id="ddlInstruccion" class="form-control m-bot15">
												<option value="-1">Seleccione</option>
											</select>
										</div>

										<label class="col-xs-2 control-label">Destino:</label>
										<div class="col-xs-2">
											<select id="ddlDestino" class="form-control m-bot15">
												<option value="-1">Seleccione</option>
												<option value="1">Forelo</option>
												<option value="2">Banco</option>
											</select>
										</div>
									</div>

									<div id="fieldsBanco" style="display:none;">
			                            <div class="form-group">
											<label class="col-xs-2 control-label">CLABE:</label>
											<div class="col-xs-2">
												<input type="text" class="form-control" placeholder="" id="txtCLABE" maxlength="18">
											</div>
										</div>

										<div class="form-group">
											<label class="col-xs-2 control-label">Banco:</label>
											<div class="col-xs-2">
												<input type="text" class="form-control" placeholder="" id="txtBanco" readonly="readonly">
											</div>

											<label class="col-xs-2 control-label">No. Cuenta:</label>
											<div class="col-xs-2">
												<input type="text" class="form-control" placeholder="" id="txtNumCuenta" value="">
												<input type="hidden" class="form-control" placeholder="" id="txtNumCuentaForelo" value="<?php echo $oCorresponsal->getNumCuenta(); ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-xs-2 control-label">Beneficiario:</label>
											<div class="col-xs-2">
												<input type="text" class="form-control" placeholder="" id="txtBeneficiario" maxlength="35">
											</div>

											<label class="col-xs-2 control-label">RFC:</label>
											<div class="col-xs-2">
												<input type="text" class="form-control" placeholder="" id="txtRFC" maxlength="13" style="text-transform:uppercase;">
											</div>

											<label class="col-xs-2 control-label">Correo:</label>
											<div class="col-xs-2">
												<input type="text" class="form-control" placeholder="" id="txtCorreo" maxlength="100">
											</div>
										</div>
									</div>
								</form>
							</div>

							<div class="modal-footer">
								<?php if($esEscritura){ ?>
								<button class="btn btn-success consulta pull-right" type="button" onClick="crearConf()">Guardar</button>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<!--Cierre Modal-->
			</div>
		</div>
	</section>
</section>

<script>
function Mostrar(){
	if ( $("#divRES").length ) {
		$("#divRES").css("display", "block");
	}
}
</script>

<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js" ></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.core.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.widget.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.position.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.menu.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<!--<script src="<?php //echo $PATHRAIZ; ?>/inc/js/advanced-form-components.js"></script>-->
<!--Tabla-->
<script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>


<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/_Clientes.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/_ConsultaCadena.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/_ConsultaCorresponsal.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/_Consulta.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/_Clientes2.js" type="text/javascript"></script>

<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>

<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
<script>
	var SORTEOS = <?php echo ($oCorresponsal->SORTEOS)? "1" : "0" ?>;
	var BANCARIOS = <?php echo ($oCorresponsal->BANCARIOS)? "1" : "0" ?>;
	var REMESAS = <?php echo ($oCorresponsal->REMESAS)? "1" : "0" ?>;
</script>

</body>
</html>
