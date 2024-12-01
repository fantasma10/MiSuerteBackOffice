<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL."/_Proveedores/proveedor/ajax/Cat_familias.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Consulta";
$subsubmenuTitulo	= "Consulta Producto";
$tipoDePagina = "mixto";
$idOpcion = 208;//cambiar


if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
}

$hoy = date("Y-m-d");

function acentos($word){
	return (!preg_match('!!u', $word))? utf8_encode($word) : $word;
}

$idemisores =  (isset($_POST['txtidemisor']))?$_POST['txtidemisor']: 0;

$query = "CALL `redefectiva`.`SP_GET_CAT_FLUJO`();";
$sql = $RBD->query($query);
$datos = array();
$index = 0;
while ($row = mysqli_fetch_assoc($sql)) {
    $datos[$index]["idFlujo"] = $row["idFlujo"];
    $datos[$index]["descFlujo"] = utf8_encode($row["descFlujo"]);
    $index++;
}
$jSonFlujoImporte = json_encode($datos);

$query = "CALL `redefectiva`.`SP_LOAD_EMISORES`();";
$sql = $RBD->query($query);
$datos = array();
$index = 0;
while ($row = mysqli_fetch_assoc($sql)) {
    $datos[$index]["idEmisor"] = $row["idEmisor"];
    $datos[$index]["descEmisor"] = utf8_encode($row["descEmisor"]);
    $index++;
}
$jSonEmisor = json_encode($datos);

$query = "CALL `redefectiva`.`SP_CAT_FAMILIA`();";
$sql = $RBD->query($query);
$datos = array();
$index = 0;
while ($row = mysqli_fetch_assoc($sql)) {
    $datos[$index]["idFamilia"] = $row["idFamilia"];
    $datos[$index]["descFamilia"] = utf8_encode($row["descFamilia"]);
    $index++;
}
$jSonFamilia = json_encode($datos);

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
		<title>.::Mi Red::.Consulta Productos</title>
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
						                <div class="form-group col-xs-3" id="">
						                    <label class="control-label">Familia </label>
											<select id="select_familia" class="form-control" onchange="BuscarSubFamilias(this.value)"></select>
										</div>
						                <div class="form-group col-xs-3">
						                    <label class="control-label">Sub Familia </label>
											<select id="select_subfamilia" class="form-control"></select>
										</div>
                                        <div class="form-group col-xs-3">
                                            <label class=" control-label">Emisor </label>
                                            <select id="select_emisor" class="form-control"></select>
                                        </div>
                                        <div class="form-group col-xs-3">
                                            <label class=" control-label">Estado </label>
                                            <select id="tipo_estado" class="form-control">
                                                <option value="0">Todos</option>
                                                <option value="1">Activos</option>
                                                <option value="2">Inactivos</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group col-xs-12">
										<button class="btn btn-xs btn-info pull-right" style="margin-bottom:10px;" id="btn_buscar_reporte_productos"> Buscar </button>
									</div>
									
								</div>
			                    <div id="gridboxExport" class="adv-table table-responsive">
			                        <div id="gridbox" class="">
			                            <table id="tabla_productos" class="display table table-bordered table-striped" style="width: 100%;display:none">
			                                <thead>
			                                    <tr>
			                                    	<th>Id</th>                                                    
			                                        <th>Descripcion</th>
			                                        <th>Fecha de Entrada en Vigor</th>
			                                        <th>Fecha de Salida en Vigor</th>
                                                    <th>SKU</th>
                                                    <th>Estatus</th>
			                                        <th>Acción</th>
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

    <div id="confirmacion" class="modal fade col-xs-12" role="dialog">
        <div class="modal-dialog" style="width:50%;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modificar Estatus Producto</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                    <input type="hidden" id="idProducto" class='form-control m-bot15'>
                    <input type="hidden" id="estatusProducto" class='form-control m-bot15'>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" id="desactivarProducto">Aceptar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
		
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

	<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/js/consultaProducto.js?v=<?php echo (rand()); ?>"></script>*/
	<script type="text/javascript">	
		BASE_PATH = "<?php echo $PATHRAIZ;?>";
		ID_PERFIL = "<?php echo $_SESSION['idPerfil'];?>";

        var jSonFlujoImporte = <?php  echo $jSonFlujoImporte; ?>;
        var jSonEmisor = <?php  echo $jSonEmisor; ?>;
        var jSonFamilia = <?php  echo $jSonFamilia; ?>;
        /*
        var jSonEmisor = undefined;
        var jSonFamilia = undefined;
        //*/
		initViewConsultaProducto();
	</script>
    <style type="text/css">
        .dataTables_processing {
            border: none;
            background: none;
        }
        /*LOADER*/
        .loaderEmisor {
            z-index: 999999;
            align-items: center;
            display: flex;
            justify-content: center;
            width: 100vw;
            height: 100vh;
            position: fixed;
            background: #00000080;
            left: 0;
            top: 0;
        }

        .loader {
            font-size: 20px;
            margin: 45% auto;
            width: 1em;
            height: 1em;
            border-radius: 50%;
            position: relative;
            text-indent: -9999em;
            -webkit-animation: load4 1.3s infinite linear;
            animation: load4 1.3s infinite linear;
        }
        @-webkit-keyframes load4 {
            0%,
            100% {
                box-shadow: 0em -3em 0em 0.2em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 0em #ffffff;
            }
            12.5% {
                box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 0.2em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            25% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 0.2em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            37.5% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 0.2em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            50% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 0.2em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            62.5% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 0.2em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            75% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0.2em #ffffff, -2em -2em 0 0em #ffffff;
            }
            87.5% {
                box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 0.2em #ffffff;
            }
        }
        @keyframes load4 {
            0%,
            100% {
                box-shadow: 0em -3em 0em 0.2em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 0em #ffffff;
            }
            12.5% {
                box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 0.2em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            25% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 0.2em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            37.5% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 0.2em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            50% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 0.2em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            62.5% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 0.2em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            75% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0.2em #ffffff, -2em -2em 0 0em #ffffff;
            }
            87.5% {
                box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 0.2em #ffffff;
            }
        }
    </style>
	</body>   	
</html>
