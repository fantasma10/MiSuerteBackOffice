<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
include($PATH_PRINCIPAL . "/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL . "/_Proveedores/proveedor/ajax/Cat_familias.php");

$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];

$submenuTitulo		= "Consulta Cortes";
$subsubmenuTitulo	= "Consulta Cortes";
$tipoDePagina = "mixto";
$idOpcion = 283;


if (!desplegarPagina($idOpcion, $tipoDePagina)) {
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
	$esEscritura = true;
}

$hoy = date("d/m/Y");

function acentos($word)
{
	return (!preg_match('!!u', $word)) ? utf8_encode($word) : $word;
}

$idemisores =  (isset($_POST['txtidemisor'])) ? $_POST['txtidemisor'] : 0;

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--Favicon-->
	<link rel="shortcut icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
	<title>.::Mi Red::.Consulta Cortes</title>
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
	<link href="<?php echo $PATHRAIZ; ?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />

</head>

<body>

	<!--Include Cuerpo, Contenedor y Cabecera-->
	<?php include($PATH_PRINCIPAL . "/inc/cabecera2.php"); ?>
	<!--Inicio del Menú Vertical-->
	<!--Función "Include" del Menú-->
	<?php include($PATH_PRINCIPAL . "/inc/menu.php"); ?>
	<!--Final del Menú Vertical-->
	<!--Contenido Principal del Sitio-->

	<section id="main-content">
		<section class="wrapper site-min-height">
			<div class="row">
				<div class="col-lg-12">
					<!--Panel Principal-->
					<div class="panelrgb">
						<div class="titulorgb-prealta">
							<span><i class="fa fa-money"></i></span>
							<h3>CORTE GAS NATURAL</h3>
							<h3 id="etiquetaTipoUsuario"></h3><span class="rev-combo pull-right">Corte</span>
						</div>
						<div class="panel">
							<div class="panel-body">
								<div class="well">
									<div class="row">
										<div class="form-group col-xs-3" id="">
											<label class="control-label">Proveedor </label>
											<select id="select_proveedor" class="form-control"></select>
										</div>

										<div class="form-group col-xs-3" id="">
											<label class="control-label">Tipo Fecha</label>
											<select id="select-tipo-fecha" class="form-control">
												<option value="1">Corte</option>
												<option value="2">Pago</option>
											</select>
										</div>

										<div class="form-group col-xs-3">
											<label class="control-label">Fecha Inicial</label>
											<input type="text" id="fecIni" name="fecIni" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecIni')" onKeyUp="validaFecha2(event,'fecIni')">
											<div id="etiquetaUsuario1" class="help-block"></div>
										</div>
										<div class="form-group col-xs-3">
											<label class=" control-label">Fecha Final</label>

											<input type="text" id="fecFin" name="fecFin" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecFin')" onKeyUp="validaFecha2(event,'fecFin')">
											<div id="etiquetaUsuario2" class="help-block"></div>
										</div>

										<form method="post" id="exportar_excel" action="../ajax/exportarCorteGNExcel.php">
											<input type="hidden" name="id_proveedor_excel" id="id_proveedor_excel">
											<input type="hidden" name="fecha1_excel" id="fecha1_excel">
											<input type="hidden" name="fecha2_excel" id="fecha2_excel">
											<input type="hidden" name="tipo" id="tipo">
											<div class="form-group col-xs-6">
												<button class="btn btn-xs btn-info excel" id="btn_ExportarCorteGNExcel" style="display: none; margin-bottom:10px;"><i class="fa fa-file-excel-o"></i> Excel
												</button>
											</div>
										</form>
									</div>
									<button id="btn_buscar_cortes" class="btn btn-xs btn-info pull-right" style="margin-top:10px; margin-right: -10px">Buscar</button>
								</div>
								<div id="gridboxExport" class="adv-table table-responsive">
									<div class="col-lg-12">
										<div class="row" id="reporte">
											<div class="adv-table">
												<div class=" ">
													<div class="box-body table-responsive">
														<table id="tabla_proveedores" class="table table-bordered table-striped" style="width: 100%;display: none;">
															<thead>
																<tr>
																	<th id='th1'>Id Proveedor</th>
																	<th id='th2'>Proveedor</th>
																	<th id='th3'>Fecha Corte</th>
																	<th id='th4'>Fecha Pago</th>
																	<th id='th5'>Tipo</th>
																	<th id='th6'>Zona</th>
																	<th id='th7'>Nombre Zona</th>
																	<th id='th8'>Clabe</th>
																	<th id='th9'>Operaciones</th>
																	<th id='th10'>Monto</th>
																	<th id='th11'>Comision</th>
																	<th id='th12'>Pago</th>
																</tr>
															</thead>
															<tbody></tbody>
															<tfoot id="footDetalle">
																<td colspan="8"></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tfoot>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</section>

</body>

<!--*.JS Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>

<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>

<script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/reportes/js/cortesGasNatural.js?v=<?php echo (rand()); ?>"></script>
<script type="text/javascript">
	<?php
	$permiso = 0;
	if (in_array($_SESSION['idU'], $array_reportes_telmex['usuario_analista'])) {
		$permiso = 1;
	}
	if (in_array($_SESSION['idU'], $array_reportes_telmex['usuario_autoriza'])) {
		$permiso = 2;
	}
	?>
	BASE_PATH = "<?php echo $PATHRAIZ; ?>";
	ID_PERFIL = "<?php echo $_SESSION['idPerfil']; ?>";
	ID_USUARIO = "<?php echo $_SESSION['idU']; ?>";
	PERMISO_USER = "<?php echo $permiso; ?>";
	METROGAS = 119;
	GASNATURAL = 27;
	TELMEX = 113;
	initViewConsultaCorte();
</script>

</html>