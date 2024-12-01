<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");


$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];

$submenuTitulo		= "Consulta";
$subsubmenuTitulo	= "Cadenas";
$tipoDePagina = "mixto";
$idOpcion = 308;

if (!desplegarPagina($idOpcion, $tipoDePagina)) {
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
	$esEscritura = true;
}
$hoy = date("Y-m-d");
function acentos($word)
{
	return (!preg_match('!!u', $word)) ? utf8_encode($word) : $word;
}
$idemisores =  (isset($_POST['txtidemisor'])) ? $_POST['txtidemisor'] : 0;

$query = "call redefectiva.sp_select_cadena();";
$resultado = $GLOBALS["RBD"]->query($query);
$arr = $resultado->fetch_all(MYSQLI_ASSOC);
$totalElements = mysqli_num_rows($resultado);
if ($_GET["offset"]) {
	$elementosPorPagina = $_GET["offset"];
} else {
	$elementosPorPagina = 50;
}
$paginas = $totalElements / $elementosPorPagina;
$paginas = ceil($paginas);
?>

<!DOCTYPE html>
<html lang="en" style="overflow-x:hidden">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>.::Mi Red::.Consulta de Cadenas</title>
	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
</head>

<body>
	<!--Include Cuerpo, Contenedor y Cabecera-->
	<?php include($PATH_PRINCIPAL . "/inc/cabecera2.php"); ?>
	<!--Inicio del Menú Vertical-->
	<!--Función "Include" del Menú-->
	<?php include($PATH_PRINCIPAL . "/inc/menu.php"); ?>
	<!--Final del Menú Vertical-->
	<!--Contenido Principal del Sitio-->

	<div id="carga" style="width: 100%; height: 100%;" class="hidden">
		<img style="margin-left: 35%; width:500px; heigth: 500px" src="<?php echo $PATHRAIZ . "/img/cargando3.gif" ?>" alt="">
	</div>

	<section id="main-content">
		<section class="wrapper site-min-height">
			<div class="panel">
				<!--Panel Principal-->
				<div class="panelrgb">
					<div class="titulorgb-prealta">
						<span><i class="fa fa-user"></i></span>
						<h3>Consulta</h3>
						<span class="rev-combo pull-right">Consulta de Cadena</span>
					</div>
					<div class="panel">
						<!--Datos Generales-->
						<div class="panel-body">
							<br>
							<div class="form-group row">
								<label for="maxItemsSelector" class="col-sm-1 col-form-label" style="margin-top:7px; text-align: right; padding-left: 45px;">Mostrar:</label>
								<div class="col-sm-2">
									<select id="maxItemsSelector" class="form-control" size="1" style="height: 30px;">
										<option value="10" <?php echo $_GET['offset'] == "10" ? 'selected="selected"' : "" ?>>10</option>
										<option value="25" <?php echo $_GET['offset'] == "25" ? 'selected="selected"' : "" ?>>25</option>
										<option value="50" <?php echo $_GET['offset'] == "50" ? 'selected="selected"' : "" ?>>50</option>
										<option value="100" <?php echo $_GET['offset'] == "100" ? 'selected="selected"' : "" ?>>100</option>
									</select>
								</div>
								<label for="search" class="col-sm-6 col-form-label" style="margin-top:7px; text-align: right; padding-right: 0px;">Buscar:</label>
								<div class="col-sm-3" style="margin-left: -10px;">
									<input type="text" id="search" class="form-control" onkeyup="searchCadena(this.value)">
								</div>
							</div>
							<div id="gridboxExport" class="adv-table table-responsive">
								<br>
								<div id="gridbox">
									<table class="display table table-bordered table-striped" style="width: 100%">
										<thead>
											<tr>
												<th>Id</th>
												<th>Giro</th>
												<th>Nombre</th>
												<th>Tel.</th>
												<th>Email</th>
											</tr>
										</thead>
										<tbody>
												<?php
												$start = ($_GET['pag'] - 1) * $elementosPorPagina;
												foreach (array_slice($arr, $start, $elementosPorPagina) as $cadena) : ?>
													<tr name="paginationElements">
														<td><?php echo $cadena["idCadena"] ?></td>
														<td><?php echo acentos($cadena["nombreGiro"]) ?></td>
														<td><?php echo acentos($cadena["nombreCadena"]) ?></td>
														<td><?php echo $cadena["telefono1"] ?></td>
														<td><?php echo $cadena["email"] ?></td>
													</tr>
												<?php endforeach ?>

												<?php foreach ($arr as $element): ?>
												<tr name="fullElements" class="hidden">
													<td><?php echo $element["idCadena"]?></td>
													<td><?php echo acentos($element["nombreGiro"]) ?></td>
													<td><?php echo acentos($element["nombreCadena"]) ?></td>
													<td><?php echo $element["telefono1"] ?></td>
													<td><?php echo $element["email"] ?></td>
												</tr>
												<?php endforeach ?>
										</tbody>
									</table>
								</div>
							</div>

							<nav class="pull-right" style="margin-right: 20px;">
								<ul class="pagination">
									<li class="page-item <?php echo $_GET["pag"] <= 1 ? 'disabled' : '' ?>">
										<a class="page-link" <?php echo $_GET["pag"] <= 1 ? 'style="pointer-events: none;"' : '' ?> href="./consultaCadena.php?pag=<?php echo $_GET["pag"] - 1 ?>&offset=<?php echo $_GET["offset"] != "" ? $_GET["offset"] : "50" ?> " tabindex="-1">Anterior</a>
									</li>

									<?php for ($i = 0; $i < $paginas; $i++) : ?>
										<li class="page-item <?php echo $_GET["pag"] == $i + 1 ? 'active' : '' ?>"><a class="page-link" href="./consultaCadena.php?pag=<?php echo $i + 1 ?>&offset=<?php echo $_GET["offset"] != "" ? $_GET["offset"] : "50" ?>"><?php echo $i + 1 ?></a></li>
									<?php endfor ?>

									<li class="page-item <?php echo $_GET["pag"] >= $paginas ? 'disabled' : '' ?>">
										<a class="page-link" <?php echo $_GET["pag"] >= $paginas ? 'style="pointer-events: none;"' : '' ?> href="./consultaCadena.php?pag=<?php echo $_GET["pag"] + 1 ?>&offset=<?php echo $_GET["offset"] != "" ? $_GET["offset"] : "50" ?>" tabindex="+1">Siguiente</a>
									</li>
								</ul>
							</nav>

						</div>
					</div>
				</div>
			</div>
		</section>
	</section>

	<!--*.JS Generales-->
	<script type="text/javascript">
		BASE_PATH = "<?php echo $PATHRAIZ; ?>";
		ID_PERFIL = "<?php echo $_SESSION['idPerfil']; ?>";
	</script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
	<!--Generales-->
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/_ConsultasCadena.js" type="text/javascript"></script>
	<script>
		let selector = document.querySelector("#maxItemsSelector");
		selector.addEventListener('change', function() {
			document.querySelector("#main-content").classList.add("hidden");
			document.querySelector("#carga").classList.remove("hidden");
			location.href = BASE_PATH + '/_cadenas/consulta/consultaCadena.php?offset=' + selector.value + '&pag=1';
		})
	</script>
</body>
</html>