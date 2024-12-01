<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL."/_Proveedores/proveedor/ajax/Cat_familias.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Consulta Cortes";
$subsubmenuTitulo	= "Consulta Cortes";
$tipoDePagina = "mixto";
$idOpcion = 209;//cambiar


if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
}

$hoy = date("d/m/Y");

function acentos($word){
	return (!preg_match('!!u', $word))? utf8_encode($word) : $word;
}

$idemisores =  (isset($_POST['txtidemisor']))?$_POST['txtidemisor']: 0;


?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!--Favicon-->
		<link rel="shortcut icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">
		<title>.::Mi Red::.Consulta Cortes</title>
		<!-- Núcleo BOOTSTRAP -->
		<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
		<!--ASSETS-->
		<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
		<!-- ESTILOS MI RED -->
		<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />


		<style type="text/css">
		  	.inhabilitar{
					background-color: #d9534f!important;
					border-color: #d9534f!important;
					margin-left: 10px;
					color: #FFFFFF;
			}
			.habilitar{
				margin-left: 10px;
			}
		</style>
	</head>
	<body>

	<!--Include Cuerpo, Contenedor y Cabecera-->
	<?php include($PATH_PRINCIPAL."/inc/cabecera2.php"); ?>
	<!--Inicio del Menú Vertical-->
	<!--Función "Include" del Menú-->
	<?php include($PATH_PRINCIPAL."/inc/menu.php"); ?>
	<!--Final del Menú Vertical-->
	<!--Contenido Principal del Sitio-->


	<section id="main-content">
		<section class="wrapper site-min-height">
			<div class="row">
				<div class="col-lg-12">
					<!--Panel Principal-->
					<div class="panelrgb">
						<div class="titulorgb-prealta">
							<span><i class="fa fa-user"></i></span>
							<h3>Consulta</h3>
	                        <span class="rev-combo pull-right">Consulta</span>
						</div>
						<div class="panel">
							<div class="panel-body">
								<div class="well">
									<div class="form-group col-xs-12">
						                <div class="form-group col-xs-4" id="">
						                    <label class="control-label">Proveedor </label>
											<select id="select_proveedor" class="form-control"></select>
										</div>
						                <div class="form-group col-xs-4">
						                    <label class="control-label">Fecha Inicial</label>
						                    	<input type="text" id="fecIni" name="fecIni" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecIni')" onKeyUp="validaFecha2(event,'fecIni')">
                                      		<div class="help-block">Elegir Fecha.</div>
                                      	</div>
						                <div class="form-group col-xs-4">
						                    <label class=" control-label">Fecha Final</label>

						                    <input type="text" id="fecFin" name="fecFin" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $g_hoy; ?>" onKeyPress="return validaFecha(event,'fecFin')" onKeyUp="validaFecha2(event,'fecFin')">
						                     <div class="help-block">Elegir Fecha.</div>
										</div>									
										</div>

										<div class="form-group col-xs-12">
											<button class="btn btn-xs btn-info pull-right" style="margin-bottom:10px;" id="btn_buscar_cortes"> Buscar </button>
										</div>
									</div> 
									
									
									
			                    <div id="gridboxExport" class="adv-table table-responsive">
			                        <div id="gridbox" class="">
			                            <table id="tabla_productos" class="display table table-bordered table-striped" style="width: 100%;display:none">
			                                <thead>
			                                    <tr>
			                                    	<th>Id</th>                                                    
			                                        <th>Proveedor</th>
			                                        <th>Total Operaciones</th>
			                                        <th>Total Monto</th>
			                                        <th>Total Comision</th>
			                                    </tr>
			                                </thead>    
			                                <tbody >
			                                </tbody>
			                            </table>
			                        </div>                    
			                    </div>
	                		</div>	                     
						</div>
					</div>
				</div>
			</div>
		</section>
	</section>

			
		
	<!--*.JS Generales-->
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
	<!--Generales-->
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>		

	<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/js/consultaCortes.js"></script>
	<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<script type="text/javascript">	
		BASE_PATH = "<?php echo $PATHRAIZ;?>";
		ID_PERFIL = "<?php echo $_SESSION['idPerfil'];?>";	 
		initViewConsultaCorte();

		$('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
           });
	</script>
	</body>   	
</html>
