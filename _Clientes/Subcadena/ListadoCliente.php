<?php

//	error_reporting(E_ALL);
//	ini_set('display_errors', 1);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
	$submenuTitulo		= "Clientes";
	$subsubmenuTitulo	= "Consulta";
	$tipoDePagina		= "Mixto";

	$idOpcion = 1;

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location: ../../../error.php");
		exit();
	}

	$esEscritura = false;

	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$idCliente = (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];

	if($idCliente == 0){
		header("Location:".$PATHRAIZ);
	}

	$CLIENTE = new Cliente($RBD, $WBD, $LOG);
	$CLIENTE->load($idCliente);
	
	$idPerfil = $_SESSION['idPerfil'];
    $usrses   = $_SESSION['idU'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<META http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
		<title>Consulta Cliente</title>
		<!--meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8"-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--Favicon-->
		<link rel="shortcut icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">

		<link rel="stylesheet" href="<?php echo $PATHRAIZ?>/css/themes/base/jquery.ui.all.css" />
		<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
		<!--ASSETS-->
		<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
		<!-- ESTILOS MI RED -->
		<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" />

		<style>
				.noesconsulta, .esconsulta{
					display:  none;
				}
				.ui-autocomplete-loading {
					background: white url('../../img/loadAJAX.gif') right center no-repeat;
				}
				.ui-autocomplete {
					max-height: 190px;
					overflow-y: auto;
					overflow-x: hidden;
					font-size: 12px;
				}
                       #pdfvisor{
           display:none;
           height: 100%;
           width: 100%;
           position:fixed;
           background-color: rgba(255, 255, 255, 0.55);
           z-index: 1500;
       }
       #divpdf{
           
            height:650px;
           width:70%;
            background-color:#e6e6e8;  
          
       }
       #divclosepdf{
         width:70%;
          
           text-align: right;
       }
       #closepdf{
           color:red;
           font-size:20px;
           font-weight: bold;
           cursor: pointer;
           
       }
		</style>
	</head>
		<?php include($_SERVER['DOCUMENT_ROOT']."/inc/cabecera2.php"); ?>
		<?php include($_SERVER['DOCUMENT_ROOT']."/inc/menu.php"); ?>
		<?php include($_SERVER['DOCUMENT_ROOT']."/inc/formPase.php"); ?>
        
        
        <div id="pdfvisor">
             <center>
                <div id="divclosepdf" ><span id="closepdf" title="Cerrar PDF">X</span></div>
                <div id="divpdf">
                    <object id="pdfdata" data="" type="application/pdf" width="100%" height="100%"></object>
                </div>    
            </center>  
        </div>
        
        
        
        
		<section id="main-content">
			<section class="wrapper site-min-height">
				<div class="row">
					<div class="col-xs-12">
						<section class="panelrgb">
							<!--Panel de Mini Paneles-->
							<section class="panel">
								<div class="titulorgb">
									<span>
									<i class="fa fa-clipboard"></i>
									</span>
									<h3 name="nombreCompletoCliente"></h3>
									<span class="rev-combo pull-right">Consulta<br>Cliente</span>
								</div>
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
												<div class="dato" name="idCliente">
													-
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
													Fecha de Alta
												</div>
												<div class="dato" name="fechaRegistro">
													-
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
												<div class="dato" name="nombreEstatus">
													-
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
												<div class="dato" name="nombreNivel">
													-
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
												<div class="dato" name="nombreVersion">
													-
												</div>
											</div>
										</div>
										<!--Final de los Mini Paneles-->
										<div class="col-xs-3">
											<div class="minipanel">
												<div class="icono red">
													<i class="fa fa-3x fa-dollar"></i>
												</div>
												<div class="linea">
													FORELO
												</div>
												<div class="dato">
													<span class="forelo_verde" name="lblsaldoCuenta">-</span>
												</div>
											</div>
										</div>
										<!--Mini-->
										<button class="btn btnconsulta btn-xs" onClick="irANuevaBusqueda();">Nueva Búsqueda <i class="fa fa-search"></i></button>
									</div>
								</div>
							</section>
							<div class="row">
								<!--Panel de Datos Generales-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo">
											<i class="fa fa-book"></i> Datos Generales
										</div>
										<div class="panel-body" style="height:380px;">
											<!--Tabla Cadena y Sub Cadena-->
											<table class="generales">
												<thead>
													<tr>
														<th>Cadena</th><th>Grupo</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreCadena">-</td>
														<td name="nombreGrupo">-</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Referencia</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreReferencia">-</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Régimen Fiscal</th>
														<th>RFC</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreRegimen">-</td>
														<td name="rfcCliente">-</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Giro</th>
														<th name="labelNombre"></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreGiro">-</td>
														<td name="nombreCompletoCliente">-</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Teléfono</th>
														<th>Correo</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="telefono">-</td>
														<td name="correo">-</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Ejecutivo de Venta</th>
														<th>Ejecutivo de Cartera</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreEjecutivoVenta">-</td>
														<td name="nombreEjecutivoCuenta">-</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Remesas y Sorteos</th>
														<th>Bancarios</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreEjecutivoAfiliacionInter">-</td>
														<td name="nombreEjecutivoAfiliacionAvanz">-</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Usuario de Alta</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreUsuarioAlta">-</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Sucursales</th>
														<th>Versión</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><span name="numeroCorresponsales"></span> <a href="#Reportes" data-toggle="modal" ><i class="fa fa-search"></i> Ver</a></td>
														<td name="nombreNivel">-</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="panel-footer">
											<div class="row">
												<div class="col-xs-12">
													<a href="#datos" data-toggle="modal" class="btn btnconsultabig btn-xs" onclick="cargarDatosGenerales();initDatosGenerales();">Editar <i class="fa fa-edit"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Inicio de Panel de Expediente-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo">
											<i class="fa fa-folder"></i> Nivel de Expediente
										</div>
										<div class="panel-body scroller" style="height:150px;">
											<div class="row">
												<div class="col-xs-6">
													<div class="consultanivel">
														<h6>
														<i class="fa fa-shopping-cart"></i> Familias
														</h6>
													</div>
													<table class="familia">
														<tbody>
															<?php
																$QUERY = "CALL `redefectiva`.`SP_LOAD_FAMILIAS`()";
																$sql = $RBD->query($QUERY);

																if(!$RBD->error()){
																	while($row = mysqli_fetch_assoc($sql)){
																		$nombreFamilia = (!preg_match("!!u", $row['descFamilia']))? utf8_encode($row['descFamilia']) : $row['descFamilia'];

																		echo "<tr>";
																			echo "<td name='familia".$row['idFamilia']."' class='deny'>".$nombreFamilia."</td>";
																		echo "</tr>";
																	}
																}
																else{

																}
															?>
														</tbody>
													</table>
												</div>
												<div class="col-xs-6">
													<div class="consultanivel">
														<h6>
														<i class="fa fa-folder-o"></i> Nivel
														</h6>
														<h5 name="nombreNivel"></h5>
													</div>
												</div>
											</div>
										</div>
										<div class="panel-footer" style="height:47px;">
											<div class="row">
												<div class="col-xs-12">
													<!--a href="#familias" data-toggle="modal" class="btn btnconsultabig btn-xs"">Editar <i class="fa fa-edit"></i></a-->
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Inicio de Panel de Configuración de Acceso-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo">
											<i class="fa fa-desktop"></i> Configuración
										</div>
										<div class="panel-body scroller" style="height:180px;">
											<!--Tabla Cadena y Sub Cadena-->
											<table class="generales">
												<thead>
													<tr>
														<th>Tipo de Acceso</th>
														<th>Código de Acceso</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreTipoAcceso">-</td>
														<td><?php echo $CLIENTE->getCodigos();?></td>
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
												<tbody class="tablapequena">
													<?php

														

														$idCadena		= $CLIENTE->ID_CADENA;
														$idSubCadena	= $CLIENTE->ID_CLIENTE;
														$idCorresponsal = -1;
														
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
																$categoria = $CLIENTE->getConfPermisos(2);
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
																		$idGrupo = $CLIENTE->ID_GRUPO;
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
															<!--span style="color:red">Sin Permisos</span-->
														</td>
														<td></td>
													</tr>
												</tbody>
											</table>
											<!--Tabla Cadena y Sub Cadena-->
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<!--Panel de Representante Legal -->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo">
											<i class="fa fa-user"></i> Representante Legal
										</div>
										<div class="panel-body">
											<table class="generales">
												<thead>
													<tr>
														<th>Nombre</th>
														<th>RFC</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreRepresentantelegal">-</td>
														<td name="rfcRepresentantelegal">-</td>
													</tr>
												</tbody>
												<tbody>
													<tr>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Tipo Identificación</th>
														<th>Número Identificación</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="nombreTipoIdentificacion">-</td>
														<td name="numeroIdentificacion"></td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Figura Políticamente Expuesta</th>
														<th>Familia Políticamente Expuesta</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td name="labelFigPolitica">-</td>
														<td name="labelFamPolitica">-</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="panel-footer">
											<div class="row">
												<div class="col-xs-12">
													<a href="#representante" data-toggle="modal" class="btn btnconsultabig btn-xs" onclick="cargarRepresentanteLegal();initRepresentanteLegal();">Editar <i class="fa fa-edit"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Inicio de Panel de Dirección-->
								<div class="col-xs-6 col-sm-6 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo">
											<i class="fa fa-home"></i> Dirección Fiscal
										</div>
										<div class="panel-body" style="height:139px;">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="direccion" name="direccionCompleta">
												-
											</div>
										</div><!--dfdjfh-->
										<div class="panel-footer">
											<div class="row">
												<div class="col-xs-12">
													<a href="#direccion" data-toggle="modal" class="btn btnconsulta btn-xs" onclick="cargarDireccion();initDireccion();">Editar <i class="fa fa-edit"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--Dos-->
								<div class="col-xs-12">
									<div class="panel">
										<div class="rgbtitulo">
											<i class="fa fa-users"></i> Información de Contactos
										</div>
										<div class="panel-body">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="table-responsive" id="divContactos">
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
													<tbody class="tablapequena">
														<?php
															$qry = "CALL `redefectiva`.`SP_LOAD_CONTACTOS_GENERAL`($CLIENTE->ID_CLIENTE, 0, 2);";
															$res = $RBD->query($qry);
																if ( !$RBD->error() ) {
																	if ( mysqli_num_rows($res) > 0 ) {
																		while ( $row = mysqli_fetch_assoc($res) ) {
																			$nombreCompleto = $row['nombreCompleto'];
																			$nombre = $row['nombreContacto'];
																			$apellidoPaterno = $row['apPaternoContacto'];
																			$apellidoMaterno = $row['apMaternoContacto'];
																			if( !preg_match('!!u', $nombreCompleto) ) { $nombreCompleto = utf8_encode($nombreCompleto); }
																			if( !preg_match('!!u', $nombre) ) { $nombre = utf8_encode($nombre); }
																			if( !preg_match('!!u', $apellidoPaterno) ) { $apellidoPaterno = utf8_encode($apellidoPaterno); }
																			if( !preg_match('!!u', $apellidoMaterno) ) { $apellidoMaterno = utf8_encode($apellidoMaterno); }
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
																					<a href='#' onclick='eliminarContacto(".$CLIENTE->ID_CLIENTE.", ".$row['idContacto'].",2)''>
																					<img src='../../../img/delete2.png'>
																				</a>";
																				
																				if ( $esEscritura ) {
																					echo "<a href='#contactos' data-toggle='modal'
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
													<a href="#contactos" data-toggle="modal" class="btn btnconsultabig btn-xs" onClick="resetContactos();">Nuevo <i class="fa fa-plus"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- informacion de la cuenta -->
								<div class="col-xs-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo">
											<i class="fa fa-credit-card"></i> Información de la Cuenta
										</div>
										<div class="panel-body">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="table-responsive">
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
															<td name="numCuenta"></td>
															<td name="labelForelo">
																<?php
																	$query = "CALL `redefectiva`.`SP_GET_CORRESPONSALES_CUENTA`($CLIENTE->ID_CADENA, $CLIENTE->ID_CLIENTE, -1, '');";
																	$result = $RBD->query($query);
																	if ( $RBD->error() == '' ) {
																		$corresponsalesFORELOSubcadena = $result->num_rows;
																		$corresponsalesFORELOIndividual = $CLIENTE->NUMERO_CORRESPONSALES - $corresponsalesFORELOSubcadena;
																		echo "Individual - $corresponsalesFORELOSubcadena Corresponsal(es) comparten FORELO de la Sub Cadena y $corresponsalesFORELOIndividual Corresponsal(es) no";
																	} else {
																		echo "Error al consultar base de datos";
																	}
																?>
															</td>
															<td name="referenciaBancaria">-</td>
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
															WHERE `idCliente` = ".$CLIENTE->ID_CLIENTE."
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
												<table class="cc" id="tblConfiguracionCuenta">
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
													<tbody>
														<?php
															$q = "CALL `redefectiva`.`SP_GET_CUENTAS`($CLIENTE->ID_CADENA, $CLIENTE->ID_CLIENTE, -1, -1, '');";
															//var_dump($q);
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
																			echo "<td class='tdtablita'><img src='../../../img/delete.png' onclick='eliminarConfiguracionCuenta(".$row['idConfiguracion'].")'></td>";
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
											<a href="#liquidacion" data-toggle="modal" class="btn btnconsultabig btn-xs" style="margin-bottom:20px;" onclick="initConfiguracionCuenta();">Nuevo <i class="fa fa-plus"></i></a>
											<br>
											<div class="theadresponsivea" style="margin-top:15px; margin-bottom:6px;">
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
														$q = "CALL `redefectiva`.`SP_LOAD_CARGOS`($CLIENTE->ID_CADENA, $CLIENTE->ID_CLIENTE, -1);";
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
                                
                                <!-- documentos -->
								<div class="col-xs-12 col-sm-12 col-xs-12">
									<div class="panel">
										<div class="rgbtitulo">
											<i class="fa fa-credit-card"></i> Documentos
										</div>
										<div class="panel-body">
											<!--Tabla Cadena y Sub Cadena-->
											<div class="table-responsive">
												
                                                
                                                <table class="cc">
                                                    <thead>
                                                        <tr>
                                                            <th>Documento</th>
                                                            <th align="center">Ver Documento</th>
                                                            <th>Cargar Documento</th>
                                                            
                                                        </tr>
                                                    </thead>
												    <tbody>
                                                        <tr>
                                                            <td>Identificación</td>
                                                            <td align="center"><img src='../../../img/buscar.png' title="Ver Idendtificación" onclick="verdoc(10);"></td>
                                                            <td><input type="file" name="bntident" idtipodoc="10" /></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>RFC</td>
                                                           <td align="center"><img src='../../../img/buscar.png' title="Ver RFC" onclick="verdoc(2);"></td>
                                                            <td><input type="file" name="bntident"  idtipodoc="2"/></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Comprobante de Domicilio</td>
                                                              <td align="center"><img src='../../../img/buscar.png' title="Ver Comprobante de Domicilio" onclick="verdoc(1);"></td>
                                                            <td><input type="file" name="bntident" idtipodoc="1"/></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Estado de Cuenta</td>
                                                             <td align="center"><img src='../../../img/buscar.png' title="Ver Estado de Cuenta" onclick="verdoc(4);"></td>
                                                            <td><input type="file" name="bntident" idtipodoc="4"/></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Representante Identificación</td>
                                                            <td align="center"><img src='../../../img/buscar.png' title="Ver Idendtificación" onclick="verdoc(5);"></td>
                                                            <td><input type="file" name="bntident" idtipodoc="5"/></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Poder del Representante</td>
                                                             <td align="center"><img src='../../../img/buscar.png' title="Ver Poder" onclick="verdoc(6);"></td>
                                                            <td><input type="file" name="bntident" idtipodoc="6"/></td>
                                                            
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                              
										
											
											
                                            
											<!-- <a href="#Cuenta" data-toggle="modal" class="btn btnconsultabig btn-xs">Editar <i class="fa fa-edit"></i></a> -->
                                            </div>    
										</div>
									</div>
								</div>
								<!--MODALES MODALES MODALES-->
								
								<div class="modal fade" id="Reportes" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3><?php echo $CLIENTE->NOMBRE_COMPLETO_CLIENTE; ?></h3>

												<span class="rev-combo pull-right">Sucursales</span>
											</div>

											<div class="modal-body">
												<div class="table-responsive">                               
													<div id="excelReporte">
														<?php
															echo "<div>";
															echo "<div style=\"text-align:center;\">";
															echo "<span>";
															echo $CLIENTE->NUMERO_CORRESPONSALES;
															echo "</span>";
															echo " Corresponsales - ";
															echo "<span>";
															echo $CLIENTE->NOMBRE_COMPLETO_CLIENTE;
															echo "</span>";
															echo "<br />";
															echo "</div>";
															echo "<div style=\"text-align:center;\">";
															echo "<span>";
															echo "<a href=\"#\" onclick=\"downloadExcelListaCorresponsales('$CLIENTE->ID_CADENA', '$CLIENTE->ID_CLIENTE', '$CLIENTE->NOMBRE_COMPLETO_CLIENTE', '$CLIENTE->NUMERO_CORRESPONSALES')\">";
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
															$res = $RBD->SP("CALL `redefectiva`.`SP_LOAD_CORRESPONSALES`($CLIENTE->ID_CADENA, $CLIENTE->ID_CLIENTE);");
															echo "<table class=\"tablacentrada\">";
															echo "<thead>";
															echo "<tr>";
															echo "<th>ID</th>";
															echo "<th>Nombre del Corresponsal</th>";
															echo "<th>Ver</th>";
															echo "</tr>";
															echo "</thead>";
															echo "<tbody>";
															if ( mysqli_num_rows($res) > 0 ) {
																while ( $corresponsal = mysqli_fetch_array($res) ) {
																	echo "<tr>";
																	echo "<td class='derecha'>{$corresponsal[0]}</td>";
																	echo "<td>".htmlentities($corresponsal[1])."</td>";
																	echo "<td class='centrado'>";
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
												<button class="btn btn-success consulta pull-right" data-dismiss="modal" type="button" >Salir</button>
											</div>
										</div>
									</div>
								</div>
								<div class="modal fade" id="datos" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3>Datos Generales</h3>
												<span class="rev-combo pull-right">
												<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
												</span>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" id="formGenerales">
													<div class="form-group">
														<!--label class="col-xs-1 control-label">Cadena:</label>
														<div class="col-xs-3">
															<input type="hidden" class="form-control m-bot15" name="idCadena">
															<input type="text" class="form-control m-bot15" name="nombreCadena">
														</div-->
														<label class="col-xs-1 control-label">Grupo:</label>
														<div class="col-xs-3">
															<select
                                                            class="form-control m-bot15"
                                                            name="idGrupo"
                                                            id="cmbGrupo"
                                                            <?php
                                                            	if ( $idPerfil != 1 && $idPerfil != 4 ) {
															 		echo "disabled";
																}
															 ?>>
																<option value="-1">Seleccione</option>
															</select>
														</div>
														<label class="col-xs-1 control-label">Referencia:</label>
														<div class="col-xs-3">
															<select
                                                            class="form-control m-bot15"
                                                            name="idReferencia"
                                                            id="cmbReferencia"
                                                            <?php
                                                            	if ( $idPerfil != 1 && $idPerfil != 4 ) {
															 		echo "disabled";
																}															
                                                            ?>>
																<option value="-1">Seleccione</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Régimen Fiscal:</label>
														<div class="col-xs-2">
															<select
                                                            class="form-control m-bot15"
                                                            name="idRegimen"
                                                            id="cmbRegimen"
                                                            <?php
                                                            	if ( $idPerfil != 1 && $idPerfil != 4 ) {
															 		echo "disabled";
																}                                                            
															?>>
																<option value="-1">Seleccione</option>
															</select>
														</div>
														<label class="col-xs-2 control-label">RFC:</label>
														<div class="col-xs-2">
															<input
                                                            type="text"
                                                            class="form-control m-bot15"
                                                            name="rfcCliente"
                                                            id="txtRFC"
                                                            <?php
                                                            	if ( $idPerfil != 1 && $idPerfil != 4 ) {
															 		echo "disabled";
																}                                                            
															?>>
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Giro:</label>
														<div class="col-xs-2">
															<select class="form-control m-bot15" name="idGiro" id="cmbGiro">
																<option value="-1">Seleccione</option>
															</select>
														</div>
														<label class="col-xs-2 control-label">Razón Social:</label>
														<div class="col-xs-6">
															<input
                                                            type="text"
                                                            class="form-control m-bot15 personamoral"
                                                            name="razonSocial"
                                                            <?php
                                                            	if ( $idPerfil != 1 && $idPerfil != 4 ) {
															 		echo "disabled";
																}                                                            
															?>>
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Nombre(s):</label>
														<div class="col-xs-2">
															<input
                                                            type="text"
                                                            class="form-control m-bot15 personafisica"
                                                            name="nombreCliente"
                                                            <?php
                                                            	if ( $idPerfil != 1 && $idPerfil != 4 ) {
															 		echo "disabled";
																}                                                            
															?>>
														</div>
														<label class="col-xs-2 control-label">Apellido Paterno:</label>
														<div class="col-xs-2">
															<input
                                                            type="text"
                                                            class="form-control m-bot15 personafisica"
                                                            name="paternoCliente"
                                                            <?php
                                                            	if ( $idPerfil != 1 && $idPerfil != 4 ) {
															 		echo "disabled";
																}                                                            
															?>>
														</div>
														<label class="col-xs-2 control-label">Apellido Materno:</label>
														<div class="col-xs-2">
															<input
                                                            type="text"
                                                            class="form-control m-bot15 personafisica"
                                                            name="maternoCliente"
                                                            <?php
                                                            	if ( $idPerfil != 1 && $idPerfil != 4 ) {
															 		echo "disabled";
																}                                                            
															?>>
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Teléfono:</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="telefono" id="txttelefono" onkeyup="validaTelefono2(event,'txttelefono')" onkeypress="return validaTelefono1(event,'txttelefono')">
														</div>
														<label class="col-xs-2 control-label">Correo:</label>
														<div class="col-xs-4">
															<input type="text" class="form-control m-bot15" name="correo" id="txtemail">
														</div>
													</div>
													<div class="titulosexpress">
														<i class="fa fa-book"></i> Ejecutivos
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Ejecutivo de Venta:</label>
														<div class="col-xs-4">
															<input type="hidden" name="idEjecutivoVenta" id="idEjecutivoVenta"/>
															<input type="text" class="form-control m-bot15" name="nombreEjecutivoVenta" id="txtEjecutivoVenta">
														</div>
														<label class="col-xs-2 control-label">Ejecutivo de Cuenta:</label>
														<div class="col-xs-4">
															<input type="hidden" name="idEjecutivoCuenta" id="idEjecutivoCuenta"/>
															<input type="text" class="form-control m-bot15" name="nombreEjecutivoCuenta" id="txtEjecutivoCuenta">
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Remesas y Sorteos:</label>
														<div class="col-xs-4">
															<input type="hidden" name="idEjecutivoAfiliacionInter" id="idEjecutivoAfiliacionInter">
															<input type="text" class="form-control m-bot15" name="nombreEjecutivoAfiliacionInter" id="txtEjecutivoAfIn">
														</div>
														<label class="col-xs-2 control-label">Bancarios:</label>
														<div class="col-xs-4">
															<input type="hidden" name="idEjecutivoAfiliacionAvanz" id="idEjecutivoAfiliacionAvanz">
															<input type="text" class="form-control m-bot15" name="nombreEjecutivoAfiliacionAvanz" id="txtEjecutivoAfAv">
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<!-- <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button> -->
												<!-- <button class="btn btn-success" type="button">Agregar</button> -->
												<button class="btn btnconsultabig consulta pull-right" type="button" onClick="guardarDatosGenerales()">Guardar</button>
											</div>
										</div>
									</div>
								</div>

								<!--Cierre Modal-->
								<!--MODALES MODALES MODALES-->
								<div class="modal fade" id="direccion" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span>
													<i class="fa fa-edit"></i>
												</span>
												<h3>Dirección Fiscal</h3>
												<span class="rev-combo pull-right">
													<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
												</span>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" id="formDireccion">
													<input type="hidden" name="idDireccion" id="idDireccion" value="0"/>
													<div class="form-group">
														<label class="col-xs-2 control-label">País:</label>
														<div class="col-xs-2">
															<input type="hidden" class="form-control m-bot15" name="dirfIdPais" id="idPais" value="164">
															<input type="text" class="form-control" name="txtPais" id="txtPais" value="México">
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Calle:</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15 ui-autocomplete-input" name="dirfCalle" id="txtCalle" autocomplete="off">
														</div>
														<label class="col-xs-2 control-label">Número Interior:</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="dirfNumerointerior">
														</div>
														<label class="col-xs-2 control-label">Número Exterior:</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="dirfNumeroexterior">
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Código Postal:</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="dirfCodigo_postal" id="txtCP" maxlength="5">
														</div>
														<label class="col-xs-2 control-label">Colonia:</label>
														<div class="col-xs-2">
															<select class="form-control m-bot15" name="dirfIdColonia" id="cmbColonia">
																<option value="-1">Seleccione</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">Estado:</label>
														<div class="col-xs-2">
															<select class="form-control m-bot15" name="dirfIdEstado" id="cmbEstado" disabled="">
																<option value="-1">Seleccione</option>
															</select>
														</div>
														<label class="col-xs-2 control-label">Ciudad:</label>
														<div class="col-xs-2">
															<select class="form-control m-bot15" name="dirfIdMunicipio" id="cmbMunicipio" disabled="">
																<option value="-1">Seleccione</option>
															</select>
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<!-- <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button> -->
												<!-- <button class="btn btn-success" type="button">Agregar</button> -->
												<button class="btn btnconsultabig consulta pull-right" type="button" onClick="guardarDireccion()">Guardar</button>
											</div>
										</div>
									</div>
								</div>
								<!--/div-->
								<!--Cierre Modal-->
								<!--MODALES MODALES MODALES-->
								<div class="modal fade" id="representante" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3>Representante Legal</h3>
												<span class="rev-combo pull-right">
												<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
												</span>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" id="formRepresentante">
													<input type="hidden" name="idRepresentantelegal" value="0">
													<div class="form-group">
														<label class="col-xs-2 control-label">Nombre(s):</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="nombreRepLegal">
														</div>
														<label class="col-xs-2 control-label">Apellido Paterno</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="paternoRepLegal">
														</div>
														<label class="col-xs-2 control-label">Apellido Materno:</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="maternoRepLegal">
														</div>
													</div>
													<div class="form-group">
														<label class="col-xs-2 control-label">RFC:</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="rfcRepresentantelegal" id="txtRFCRep" maxlength="13" style="text-transform: uppercase;">
														</div>
														<label class="col-xs-2 control-label">Tipo Identificación:</label>
														<div class="col-xs-2">
															<select class="form-control m-bot15" name="idTipoIdent" id="cmbIdent">
																<option value="-1">Seleccione</option>
															</select>
														</div>
														<label class="col-xs-2 control-label">No. Identificación:</label>
														<div class="col-xs-2">
															<input type="text" class="form-control m-bot15" name="numeroIdentificacion" maxlength="20">
														</div>
													</div>
													<div class="form-group">
														<label for="ChkFigPolita" class="col-xs-3 control-label">Figura Políticamente Expuesta:</label>
														<div class="col-xs-1">
															<input type="checkbox" class="pull-right" name="figPolitica" id="ChkFigPolita">
														</div>
														<label for="ChkFamPolitica" class="col-xs-3 control-label">Familia Políticamente Expuesta:</label>
														<div class="col-xs-1">
															<input type="checkbox" class="pull-right" name="famPolitica" id="ChkFamPolitica">
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<!-- <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button> -->
												<!-- <button class="btn btn-success" type="button">Agregar</button> -->
												<button class="btn btnconsultabig consulta pull-right" type="button" onClick="guardarRepresentanteLegal()">Guardar</button>
											</div>
										</div>
									</div>
								</div>
								<!--/div-->
								<!--Cierre Modal-->
								<!--MODALES MODALES MODALES-->
								<div class="modal fade" id="familias" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3>Nivel de Expediente</h3>
												<span class="rev-combo pull-right">
												<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
												</span>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-xs-7">
														<div class="titulosexpress-first">
															<i class="fa fa-shopping-cart"></i> Familias
														</div>
														<form class="form-horizontal" id="formExpediente">
															<input type="hidden" name="idExpediente" id="idExpediente">
															<?php
																$QUERY = "CALL `afiliacion`.`SP_GET_EXPEDIENTE`(0)";
																$sql = $RBD->query($QUERY);

																if(!$RBD->error()){
																	while($row = mysqli_fetch_assoc($sql)){
																		$nombreFamilia		= (!preg_match("!!u", $row['descFamilia']))? utf8_encode($row['descFamilia']) : $row['descFamilia'];
																		$nombreExpediente	= (!preg_match("!!u", $row['Nombre']))? utf8_encode($row['Nombre']) : $row['Nombre'];

																		echo "<div class='form-group'>";
																			echo "<label class='col-xs-4 control-label' for='chkFamilia".$row['idFamilia']."' idexpediente='".$row['idExpediente']."' nombreexpediente='".$nombreExpediente."'>".$nombreFamilia.":</label>";
																			echo "<div class='col-xs-3'>
																				<input type='checkbox' class='pull-right' idexpediente='".$row['idExpediente']."' nombreexpediente='".$nombreExpediente."' name='chkFamilia".$row['idFamilia']."' id='chkFamilia".$row['idFamilia']."' idfamilia='".$row['idFamilia']."'>
																			</div>";
																		echo "</div>";
																	}
																}
																else{

																}
															?>
														</form>
													</div>
													<div class="col-xs-4 modalfamilias">
														<div class="titulosexpress-first"><i class="fa fa-folder"></i> Nivel de Expediente</div>
														<div class="nivel" name="nombreNivel" id="divNombreNivel">--</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button class="btn btn-success consulta pull-right" type="button" onClick="guardarExpediente()">Guardar</button>
											</div>
										</div>
									</div>
								</div>
								<!--/div-->
								<!--Cierre Modal-->
								<!--MODALES MODALES MODALES-->
								<div class="modal fade" id="contactos" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3></h3>
												<span class="rev-combo pull-right"><button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button></span>
											</div>
											<div class="modal-body">
												<div class="titulosexpress-first"><i class="fa fa-users"></i> Contactos</div>
												<form class="form-horizontal" id="formContactos">
													<div class="form-group">
														<input type="hidden" id="HidContacto" value="0">
														<label class="col-lg-2 control-label">Nombre(s):</label>
														<div class="col-lg-2">
															<input type="text" class="form-control" placeholder="" id="txtContacNom" maxlength="100">
														</div>
														<label class="col-lg-2 control-label">Apellído Paterno:</label>
														<div class="col-lg-2">
															<input type="text" class="form-control" placeholder="" id="txtContacAP" maxlength="50">
														</div>
														<label class="col-lg-2 control-label">Apellído Materno:</label>
														<div class="col-lg-2">
															<input type="text" class="form-control" placeholder="" id="txtContacAM" maxlength="50">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-2 control-label">Teléfono:</label>
														<div class="col-lg-2">
															<input type="text" class="form-control" placeholder="" id="txtTelContac"
                                                            onkeyup="validaTelefono2(event,'txtTelContac')" onkeypress="return validaTelefono1(event,'txtTelContac')"
                                                            maxlength="20">
														</div>
														<label class="col-lg-2 control-label">Extensión:</label>
														<div class="col-lg-2">
															<input type="text" class="form-control" placeholder="" id="txtExtTelContac" onkeyup="validaNumeroEntero2(event,'txtExtTelContac')" onkeypress="return validaNumeroEntero(event,'txtExtTelContac')" maxlength="10">
														</div>
														<label class="col-lg-2 control-label">Correo:</label>
														<div class="col-lg-2">
															<input type="text" class="form-control" placeholder="" id="txtMailContac" maxlength="100">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-2 control-label">Tipo de Contacto:</label>
														<div class="col-lg-2">
															<select name="ddlTipoContac" id="ddlTipoContac" class="form-control m-bot15">
																<option value="-1" selected>Seleccione</option>
				                                            </select>
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<!-- <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button> -->
												<!-- <button class="btn btn-success" type="button">Agregar</button> -->
												<button class="btn btnconsultabig consulta pull-right" type="button" onClick="actualizaContacto(<?php echo $CLIENTE->ID_CLIENTE;?>,2)">Guardar</button>
											</div>
										</div>
									</div>
								</div>
								<!--Cierre Modal-->
								<!--MODALES MODALES MODALES-->
								<div class="modal fade" id="liquidacion" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-consulta">
												<span><i class="fa fa-edit"></i></span>
												<h3></h3>
												<span class="rev-combo pull-right"><button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button></span>
											</div>
											<div class="modal-body">
												<div class="titulosexpress-first"><i class="fa fa-dollar"></i>Configuración de Liquidacion</div>
												<form class="form-horizontal">
													<div class="form-group">
														<label class="col-lg-2 control-label">Tipo de Movimiento:</label>
														<div class="col-lg-2">
															<select id="ddlTipoMovimiento" class="form-control m-bot15">
																<option value="0">Pago</option>
															</select>
														</div>
														<label class="col-lg-2 control-label">Tipo de Instrucción:</label>
														<div id="selectInstruccion" class="col-lg-2">
															<select id="ddlInstruccion" class="form-control m-bot15">
																<option value="-1">Todos</option>
															</select>
														</div>
														<label class="col-lg-2 control-label">Destino:</label>
														<div class="col-lg-2">
															<select id="ddlDestino"  class="form-control m-bot15">
																<option value="-1">Seleccione</option>
																<option value="1">Forelo</option>
																<option value="2">Banco</option>
															</select>
														</div>
													</div>
													<div id="fieldsBanco" style="display:none;">
														<div class="form-group">
															<label class="col-lg-2 control-label">CLABE:</label>
															<div class="col-lg-2">
																<input type="text" class="form-control" placeholder="" id="txtCLABE" maxlength="18">
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-2 control-label">Banco:</label>
															<div class="col-lg-2">
																<input type="text" class="form-control" placeholder="" id="txtBanco" readonly="readonly">
															</div>
															<label class="col-lg-2 control-label">No. Cuenta:</label>
															<div class="col-lg-2">
																<input type="text" id="txtNumCuenta" class="form-control" placeholder="" value="">
															</div>
																<input type="hidden" class="form-control" placeholder="" id="txtNumCuentaForelo" value="<?php echo $CLIENTE->NUM_CUENTA; ?>">
														</div>
														<div class="form-group">
															<label class="col-lg-2 control-label">Beneficiario:</label>
															<div class="col-lg-2">
																<input type="text" class="form-control" placeholder="" id="txtBeneficiario" maxlength="35">
															</div>
															<label class="col-lg-2 control-label">RFC:</label>
															<div class="col-lg-2">
																<input type="text" class="form-control" placeholder="" id="txtRFCBen" maxlength="13" style="text-transform:uppercase;">
															</div>
															<label class="col-lg-2 control-label">Correo:</label>
															<div class="col-lg-2">
																<input type="text" class="form-control" placeholder="" id="txtCorreo" maxlength="100">
															</div>
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<!-- <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button> -->
												<!-- <button class="btn btn-success" type="button">Agregar</button> -->
												<button class="btn btnconsultabig consulta pull-right" type="button" onClick="crearConfiguracion()">Guardar</button>
											</div>
										</div>
									</div>
								</div>
								<!--Cierre Modal-->
							</div>
						</section>
					</div>
				</div>
			</section>
		</section>
			<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
			<!--script src="<?php echo $PATHRAIZ;?>/inc/js/jquery-ui-1.10.4.custom.min.js"></script-->
			<script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.core.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.widget.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.position.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.menu.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.autocomplete.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
			<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
			<!--script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.nicescroll.js" type="text/javascript"></script-->
			<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
			<!--Generales-->
			<script src="<?php echo $PATHRAIZ;?>/inc/js/RE.js"></script>
			<!--script src="../../inc/js/advanced-form-components.js"></script-->
			<!--Tabla-->
			<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>

			<script src="<?php echo $PATHRAIZ;?>/inc/js/_ConsultaCliente.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
			<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js"></script>

			<script>
			$(function(){
				BASE_PATH		= "<?php echo $PATHRAIZ;?>";
				ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
				ES_ESCRITURA	= "<?php echo $esEscritura;?>";
				ID_CLIENTE		= "<?php echo $idCliente;?>";

				initConsultaCliente();
				//initDatosGenerales();
			});
                
                var usr = <?php echo $usrses; ?>
			</script>
		</body>
	</html>