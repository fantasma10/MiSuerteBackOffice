<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
session_start();
$usuario = $_SESSION['idU'];


include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/_Proveedores/proveedor/ajax/Cat_familias.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo		= "Alta";
$subsubmenuTitulo	= "Nuevo Producto";
$tipoDePagina = "mixto";
$idOpcion = 207;//cambiar


if(!desplegarPagina($idOpcion, $tipoDePagina)){
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if(esLecturayEscrituraOpcion($idOpcion)){
	$esEscritura = true;
}

$hoy = date("Y-m-d");
$partes = explode("-", $hoy);
$aniop20 = $partes[0]+50;
$hoyplus20 = $aniop20."-".$partes[1]."-".$partes[2];

function acentos($word){
	return (!preg_match('!!u', $word))? utf8_encode($word) : $word;
}
$idProducto =  (isset($_POST['txtidProducto']))?$_POST['txtidProducto']: 0;
// var_dump($usuario_logueado);
// var_dump($_SESSION);

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
	<title>.::Mi Red::.Afiliacion de Proveedor</title>
	<!-- Núcleo BOOTSTRAP -->
	<!-- <link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet"> -->
	<!--<link href="<?php echo $PATHRAIZ;?>/css/bootstrap3.min.css" rel="stylesheet">-->
	<link href="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/estilos/css/bootstrap3.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
	<!--<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />-->
	<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />

	<!-- Autocomplete -->
  <link href="<?php echo $PATHRAIZ;?>/css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">
  <style type="text/css">
  	.inhabilitar{
			background-color: #d9534f!important;
			border-color: #d9534f!important;
			margin-left: 10px;
			color: #FFFFFF;
	}
	.disabledbutton {
    	pointer-events: none;
    	opacity: 0.4;
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
</head>
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
						<h3>Datos del Producto</h3>
                        <span class="rev-combo pull-right">Alta <br>de Productos</span>
					</div>
					<div class="panel">
						<!--Datos Generales-->
						<div class="panel-body">
			                <div class="row">
			                	<div class="col-lg-12">
			                		<div class="col-sm-4">
			                        <button class="btn btn-xs btn-info " id="btnback" onclick="irAtras()" style="margin-top:20px;display:none;" >Regresar </button>
			                		</div>
			                		<div class="col-sm-4"></div>
			                		<div class="col-sm-4">
			                			<button class="btn btn-xs btn-info pull-right" id="btnEditar" onclick="habilitaredicion();" style="margin-top:20px;display:none"> Editar</button>
			                		<button class="btn btn-xs btn-info pull-right" id="btnCancelarEditar" onclick="cancelarEdicion();" style="margin-top:20px;display:none"> Cancelar Edición</button></div>
			                	</div>

			                </div>


							<div class="well">
								<div class="form-group col-xs-8">
			                    	<h4><span><i class="fa fa-file-text"></i></span> Datos Producto</h4>
			                  	</div>

			                  	<div class="form-group col-xs-12">
			                  		<div class="form-group col-xs-4" id="cajaIdProducto" style="display:none">
			                  			<label class="control-label">Producto</label>
			                  			<input type="text" class="form-control" id="idProducto">
			                  		</div>
			                  	</div>
			                  	<div class="form-group col-xs-12">
				                    <div class="form-group col-xs-4" id="">
				                        <label class="control-label">Familia *</label>
										<select id="select_familia" class="form-control"></select><!--onchange="BuscarSubFamilias(this.value)"-->
									</div>
				                    <div class="form-group col-xs-4">
				                        <label class="control-label">Sub Familia *</label>
										<select id="select_subfamilia" class="form-control"></select>
									</div>
				                    <div class="form-group col-xs-4">
				                        <label class=" control-label">Emisor *</label>
										<select id="select_emisor" class="form-control"></select>
									</div>

								</div>

			                  	<div class="form-group col-xs-12">
			                  		<div class="form-group col-xs-4">
				                        <label class="control-label">Descripcion *</label>
										<input type="text" id="producto_descripcion" class="form-control alphanum45">
									</div>
									<div class="form-group col-xs-4">
				                        <label class="control-label">Abreviatura *</label>
										<input type="text" id="producto_abreviatura" class="form-control alphanum45">
									</div>

									<div class="form-group col-xs-4">
				                        <label class="control-label">Flujo del Importe *</label>
										<select id="select_flujo_importe" class="form-control"></select>
									</div>
			                  	</div>
                                <!--DISPLAY NONE valores en cero y fecha entrada now -->
			                  	<div class="form-group col-xs-12 hidden">
			                  		<div class="form-group col-xs-4">
				                        <label class="control-label">Fecha de entrada en vigor </label>
										<input type="text" id="fecha1" name="fecha1" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'fecha1')" onKeyUp="validaFecha2(event,'fecha1')">
                                        <div class="help-block">Elegir Fecha.</div>
									</div>
									<div class="form-group col-xs-4">
				                        <label class="control-label">Fecha de salida de vigor</label>
										<input type="text" id="fecha2" name="fecha2" onpaste="return false;" disabled="disabled" class="form-control form-control-inline input-medium default-date-picker" data-date-format="yyyy-mm-dd" maxlength="10"  value="<?php echo $hoyplus20; ?>" onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
                                        <div class="help-block">Elegir Fecha.</div>
									</div>
			                  	</div>

                                <div class="form-group col-xs-12">
			                  		<div class="form-group col-xs-4">
				                        <label class="control-label">Importe Mínimo Producto </label>
										<input type="text" id="importe_minimo_producto" name="importe_minimo_producto" class="form-control" value="0">
									</div>

									<div class="form-group col-xs-4">
				                        <label class="control-label">Importe Máximo Producto</label>
										<input type="text" id="importe_maximo_producto" name="importe_maximo_producto" class="form-control" value="10000">
									</div>
                                </div>

			                  	<div class="form-group col-xs-12 hidden">
									<div class="form-group col-xs-4">
				                        <label class="control-label">% de Comisión del Producto </label>
										<input type="text" id="porcentaje_comision_producto" name="porcentaje_comision_producto" class="form-control" value="0">
										<input type="hidden" id="porcentaje_comision_producto_mascara" class="form-control">
									</div>
			                  		<div class="form-group col-xs-4">
				                        <label class="control-label">Importe de Comisión del Producto </label>
										<input type="text" id="importe_comision_producto" name="importe_comision_producto" class="form-control" value="0">
									</div>
			                  	</div>

			                  	<div class="form-group col-xs-12 hidden">
									<div class="form-group col-xs-4">
				                        <label class="control-label">% de Comisión del Corresponsal</label>
										<input type="text" id="porcentaje_comision_corresponsal" name="porcentaje_comision_corresponsal" class="form-control" value="0">
										<input type="hidden" id="porcentaje_comision_corresponsal_mascara" class="form-control">
									</div>
									<div class="form-group col-xs-4">
				                        <label class="control-label">Importe de Comisión del Corresponsal </label>
										<input type="text" id="importe_comision_corresponsal" name="importe_comision_corresponsal" class="form-control" value="0">
									</div>
			                  		<div class="form-group col-xs-4">
				                        <label class="control-label">% de Comisión del Cliente </label>
										<input type="text" id="porcentaje_comision_cliente" name="porcentaje_comision_cliente" class="form-control" value="0">
										<input type="hidden" id="porcentaje_comision_cliente_mascara" class="form-control">
									</div>
			                  	</div>

			                  	<div class="form-group col-xs-12 hidden">
									<div class="form-group col-xs-4">
				                        <label class="control-label">Importe de Comisión del Cliente</label>
										<input type="text" id="importe_comision_cliente" name="importe_comision_cliente" class="form-control" value="0">
									</div>
									<div class="form-group col-xs-4" id="divEstatus" style="display: none">
										<label class="control-label">Estatus</label>
										<select class="form-control" id="estatus"></select>
									</div>
			                  	</div>
                                <!--DISPLAY NONE-->
			                  	<div class="form-group col-xs-12">
			                  		<label>Servicios *</label>
									<table id="tableServicios" class="table" disabled></table>
			                  	</div>

							</div>
						</div>

                        <!--Guardar información-->
                        <div class="row">
                            <div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
                                <button class="btn btn-xs btn-info " id="guardarProducto" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;"> Guardar </button>
                                 
                                <button class="btn btn-xs btn-info pull-right" id="guardarProductoEditar" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Actualizando" style="margin-top:10px;display:none"> Actualizar</button>
                            </div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<div id="loaderEmisor" class="loaderEmisor hidden"><div id="loader" class="loader"></div></div>
<!--*.JS Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script> -->


		<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->
		<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
		<!--Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/paycash/ajax/pdfobject.js"></script>
        <!--Autocomplete -->
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.core.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.widget.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.position.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.menu.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.autocomplete.js"></script>	

        <script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/js/codigo_postal.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/js/altaProducto.js?v=1.09"></script>
		<script type="text/javascript">
			BASE_PATH	= "<?php echo $PATHRAIZ;?>";
			ID_PERFIL   = "<?php echo $_SESSION['idPerfil'];?>";
            var jSonFlujoImporte = <?php  echo $jSonFlujoImporte; ?>;
            var jSonEmisor = <?php  echo $jSonEmisor; ?>;
            var jSonFamilia = <?php  echo $jSonFamilia; ?>;
            /*
            var jSonFlujoImporte = undefined;
            var jSonEmisor = undefined;
            var jSonFamilia = undefined;
            //*/
            initViewAltaProducto();
            var idProducto = <?php  echo $idProducto; ?>;
            cargaProducto();
		</script>
	</body>
    
   
	
</html>
