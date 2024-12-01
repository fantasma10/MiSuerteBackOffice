<?php
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include("../../inc/config.inc.php");
	include("../../inc/session.inc.php");
	include("../../inc/obj/XMLPreCadena.php");

	$idOpcion = 2;
	$tipoDePagina = "Escritura";
	$idPerfil = $_SESSION['idPerfil'];
	
	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location: ../../../error.php");
		exit();
	}

	if ( $idPerfil != 1 && $idPerfil != 4 ) {
		header("Location: ../../../error.php");
		exit();
	}

	$submenuTitulo = "Pre-Alta";
	$subsubmenuTitulo ="Corresponsal";

	if(!isset($_SESSION['rec'])){
		$_SESSION['rec'] = true;
	}

	$idCadena = (!empty($_POST['idCadena'])) ? $_POST['idCadena'] : 0;

	if($idCadena == -1){
		header('Location: ../../index.php');//redireccionar no existe la pre-cadena
	}
	else{
		$oCadena = new XMLPreCadena($RBD,$WBD);
		$oCadena->load($idCadena);

		if($oCadena->getExiste()){
			//$_SESSION['idPreCadena'] = $idCadena;
		}
		else{
			//echo "<pre>"; echo var_dump("<h2>No existe la PreCadena : $idCadena</h2>"); echo "</pre>";
			header('Location: ../../index.php');//redireccionar no existe la pre-cadena
		}	
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
	<title>.::Mi Red::.Autorización de Cadena</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../../assets/opensans/open.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="../../css/miredgen.css" rel="stylesheet">
	<link href="../../css/style-responsive.css" rel="stylesheet" />
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

<?php
	function wordmatch($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

?>

<section id="main-content">
<section class="wrapper site-min-height">
<div class="row">
<div class="col-lg-12">

	<!--Panel Principal-->
	<div class="panelrgb">
	<div class="panel">
		<div class="titulorgb-prealta">
			<span>
				<i class="fa fa-check-square"></i>
			</span>
			<h3><?php echo wordmatch($oCadena->getNombre());?></h3>
			<span class="rev-combo pull-right">
				 Autorización<br> de Cadena
			</span>
		</div>

		<div class="panel-body">
			<button class="btn btnrevision " type="button" onClick="irABuscarCadena();">Nueva Búsqueda <i class="fa fa-search"></i> </button>

		<div class="room-desk">

			<div class="room-formauto">
				<h5 class="text-primary"><i class="fa fa-dollar"></i> Afiliación y Cuotas</h5>
				<?php
				$emptyRow = "<tr><td colspan='5' class='tdtablita-o'>No hay informaci&oacute;n para mostrar</td></tr>";

					$oPreCargo = new PreCargo($LOG, $WBD, $RBD, null, null, $oCadena->getID(), -1, -1, 0, "", "", "", 0, 0, $_SESSION['idU']);
					$cargos = $oPreCargo->cargarTodos();
					$cuenta = count($cargos);

					//if($cuenta > 0){
				?>
				<table class="tablarevision-hc">
					<thead class="theadtablita">
						<tr>
							<th class="theadtablitauno">Concepto</th>
							<th class="theadtablita">Importe</th>
							<th class="theadtablita">Fecha de Inicio</th>
							<th class="theadtablita">Observaciones</th>
							<th class="theadtablita">Configuraci&oacute;n</th>
						</tr>
					</thead>
					<tbody class="tablapequena">
						<?php
							if($cuenta > 0){
								foreach($cargos AS $cargo){
									$cfg = ($cargo['Configuracion'] == 0)? 'Compartido' : 'Individual';
									echo '<tr>';
										echo '<td class="tdtablita-o">'.wordmatch($cargo['nombreConcepto']).'</td>';
										echo '<td class="tdtablita-o" style="text-align:right;">$'.number_format($cargo['importe'], 2).'</td>';
										echo '<td class="tdtablita-o">'.$cargo['fechaInicio'].'</td>';
										echo '<td class="tdtablita-o">'.wordmatch($cargo['observaciones']).'</td>';
										echo '<td class="tdtablita-o">'.$cfg.'</td>';
									echo '</tr>';
								}
							}
							else{
								echo $emptyRow;
							}
						?>
					</tbody>
				</table>
				<?php
					//}
				?>
			</div>

			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-book"></i> Datos Generales
				</h5>

				<table class="tablaauto">
					<tr>
						<td>Grupo</td>
						<td>Referencia</td>
					</tr>
					<tr>
						<td class="dato"><?php echo $oCadena->getNombreGrupo();?></td>
						<td class="dato"><?php echo $oCadena->getNombreReferencia();?></td>
					</tr>
					<tr>
						<td>Teléfono</td>
						<td>Correo</td>
					</tr>
					<tr>
						<td class="dato"><?php echo $oCadena->getTel1();?></td>
						<td class="dato"><?php echo $oCadena->getCorreo();?></td>
					</tr>
				</table>
			</div>

			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-map-marker"></i> Dirección
				</h5>
				<table class="tablaauto">
					<tr>
						<td>
							<i class="fa fa-home"></i> Dirección
						</td>
					</tr>
					<tr>
						<td class="dato">
							<?php
								$dir = wordmatch($oCadena->getCalle())." ".$oCadena->getNint()." ".$oCadena->getNext();
								$dir.= "<br/>Col. ".wordmatch($oCadena->getNombreColonia())." C.P.".$oCadena->getCp();
								$dir.= "<br/>".wordmatch($oCadena->getNombreCiudad()).", ".wordmatch($oCadena->getNombreEstado()).", ".wordmatch($oCadena->getNombrePais());

								echo $dir;
							?>
						</td>
					</tr>
				</table>
			</div>

			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-users"></i> Contactos
				</h5>
				<table class="tablaautoc">
					<thead class="theadtablita">
						<tr>
							<th class="theadtablitauno">Contacto</th>
							<th class="theadtablita">Teléfono</th>
							<th class="theadtablita">Extensión</th>
							<th class="theadtablita">Correo</th>
							<th class="theadtablita">Tipo de Contacto</th>
						</tr>
					</thead>
					<tbody class="tablapequena">                                     
						<?php
							$query = "CALL `prealta`.`SP_LOAD_PRECONTACTOS_GENERAL`($idCadena, 0, 1)";

							$emptyRow = "<tr>
								<td class='tdtablita'>&nbsp;</td>
								<td class='tdtablita'>&nbsp;</td>
								<td class='tdtablita'>&nbsp;</td>
								<td class='tdtablita'>&nbsp;</td>
								<td class='tdtablita'>&nbsp;</td>
								</tr>";

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
										echo "</tr>";
									}
								}
								else{
									echo $emptyRow;
								}
							}
							else{
								echo $emptyRow;
							}
						?>
					</tbody>
				</table>
			</div>
			<!--jdh-->

			<div class="room-auto">
				<h5 class="text-primary">
					<i class="fa fa-briefcase"></i> Ejecutivos
				</h5>
				<table class="tablaauto">
					<tr>
						<td>Ejecutivo de Cuenta</td>
						<td>Ejecutivo de Ventas</td>
					</tr>
					<tr>
						<td class="dato"><?php echo wordmatch($oCadena->getNombreECuenta());?></td>
						<td class="dato"><?php echo wordmatch($oCadena->getNombreEVenta());?></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="prealta-footer">
			<button class="btn btn-default" type="button" onClick="autorizarCadena(<?php echo $oCadena->getID();?>)"><i class="fa fa-check"></i> Autorizar</i> </button>
			<!--button class="btn btn-success" type="button" onclick="showPdfCadena(<?php echo $oCadena->getID();?>);"><i class="fa fa-print"></i> Exportar a PDF</button-->
		</div>

		<!--Inicia Modal-->
		<div class="modal fade" id="Domicilio" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-revision">
						<span>
							<i class="fa fa-check-square"></i>
						</span>
						<h3>Nombre de Corresponsal</h3>
						<span class="rev-combo pull-right">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</span>
					</div>

					<div class="modal-body">
						<legend> <i class="fa fa-folder-open-o"></i> Comprobante de Domicilio</legend>
						<img src="img/dummyimage.jpg" width="60%" height="60%"/>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success" type="button">Editar <i class="fa fa-edit"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Cierre Modal-->
	</div>
</div>
</div> 
</div>
</div>
</section>
</section>

<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<script src="../../inc/js/_Autorizar.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>