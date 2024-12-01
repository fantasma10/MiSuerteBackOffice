<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include($PATH_PRINCIPAL."/afiliacion/application/models/Cat_pais.php");
include($PATH_PRINCIPAL."/_Proveedores/proveedor/ajax/Cat_familias.php");
$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];
$submenuTitulo		= "Edicion de Comision";
$subsubmenuTitulo	= "Edicion de Comision";
$tipoDePagina = "mixto";
$idOpcion = 205;
$parametro_proveedor = $_POST["txtidProveedor"];
$parametro_nombreProveedor = $_POST["txtNombreProveedor"];

$parametro_ruta = $_POST["txtidRuta"];

$edicion=0;
if(!empty($parametro_ruta)){
	$edicion=1;
}
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
$aniop50 = $partes[0]+50;
$hoyplus50 = $aniop50."-".$partes[1]."-".$partes[2];

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
	<title>.::Mi Red::.Edicion de Comision</title>
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
	.icon-info { 
		color: #31708f;
		cursor: pointer;
	}
	#modal-information .modal-body p {
		font-size: 15px;
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
						<h3>Proveedor - Productos</h3>
                        <span class="rev-combo pull-right">Edicion <br>de Comision</span>
					</div>
					<div class="panel">
						<!--Datos Generales-->
						<div class="panel-body" id="">
							<div class="row">
			                <div class="form-group col-xs-12" id="panel_botones" style="display: block;" >
			                    <div class="form-group col-xs-6" style="">
			                        <button class="btn btn-xs btn-info " id="btnback" onclick="Regresar();" style="margin-top:20px;display:block" >Regresar </button>
			                    </div>
			                     
			                    <div class="form-group col-xs-6" style="display:none;" id="divEditar">
			                    	<input type="hidden" id="edicion_ruta" value='<?php echo $edicion; ?>'>
			                    	<input type="hidden" id="id_ruta_edicion" value='<?php echo $parametro_ruta; ?>'>
			                        <button class="btn btn-xs btn-info pull-right" id="btnedit" onclick="habilitarDivs();" style="margin-top:20px;" >Editar </button>
			                    </div>
			                </div>
			            	</div>
							<div class="well" id="datos_generales">
								<div class="form-group col-xs-12">
			                    	<h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4><input type="hidden" name="tipoProceso" id="tipoProceso" />
			                  	</div>

								<div class="row">
									<div class="form-group col-xs-12 col-md-3">
										<label class="control-label">Producto*</label>
										<select class="form-control"  id="select_productos">
											<option value="-1">Seleccione</option>
										</select>
									</div>
									<div class="form-group col-xs-12 col-md-3">
										<label class="control-label">Conector*</label>
										<select class="form-control"  id="select_conector">
											<option value="-1">Seleccione</option>
										</select>
									</div>
									<div class="form-group col-xs-12 col-md-3">
										<label class="control-label">Id Proveedor: </label>
										<input type="text" id="idProveedor" class='form-control m-bot15'  value='<?php echo $parametro_proveedor;?>' disabled>
									</div>
									<div class="form-group col-xs-12 col-md-3">
										<label class="control-label">Nombre Proveedor: </label>
										<input type="text" id="nombreProveedor" class='form-control m-bot15'  value='<?php echo $parametro_nombreProveedor;?>' disabled>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">SKU proveedor*</label>
										<input type="text" id="skuProveedor" class="form-control">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">Descripción ruta*</label>
										<input type="text" id="descripcionRuta" class="form-control">
									</div>

									<div class="form-group col-xs-12 col-md-6 hidden">
										<label class="control-label">Fecha de entrada en vigor</label>
										<input type="text" id="fecha1" name="fecha1" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd"  readonly="true" maxlength="10" value="<?php echo $hoy; ?>" onKeyPress="return validaFecha(event,'fecha1')" onKeyUp="validaFecha2(event,'fecha1')">
									</div>

									<div class="form-group col-xs-12 col-md-6 hidden">
										<label>Fecha de salida de vigor</label>
										<input type="text" id="fecha2" disabled="disabled" readonly="true" name="fecha2" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoyplus50; ?>" onKeyPress="return validaFecha(event,'fecha2')" onKeyUp="validaFecha2(event,'fecha2')">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">Importe mínimo de ruta</label>
										<input type="text" id="importe_minimo_ruta" class="form-control numeric" value="0">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">Importe máximo de ruta</label>
										<input type="text" id="importe_maximo_ruta" class="form-control numeric" value="10000">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">% costo de ruta</label>
										<input type="text" id="porcentaje_costo_ruta" class="form-control numericPer" value="0">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">Importe de costo de ruta</label>
										<input type="text" id="importe_costo_ruta" class="form-control numeric" value="0">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">% de comisión del corresponsal</label>
										<input type="text" id="porcentaje_comision_corresponsal" class="form-control numericPer" value="0">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">Importe de comisión del corresponsal</label>
										<input type="text" id="importe_comision_corresponsal" class="form-control numeric" value="0">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">% De comisión del cliente</label>
										<input type="text" id="porcentaje_comision_cliente" class="form-control numericPer" value="0">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">Importe de comisión del cliente</label>
										<input type="text" id="importe_comision_cliente" class="form-control numeric" value="0">
									</div>

									<div class="form-group hidden">
										<label class="control-label">Comisión pago proveedor</label>
										<input type="text" id="imp_cxp" class="form-control" value="0">
									</div>

                                    <div class="form-group col-xs-12 col-md-6">
                                        <label class="control-label">% de comisión pago proveedor<!--Del Producto--></label>
                                        <input type="text" id="porcentaje_pago_producto" class="form-control numericPer" value="0">
                                    </div>

                                    <div class="form-group col-xs-12 col-md-6">
                                        <label class="control-label">Importe de comisión pago proveedor</label>
                                        <input type="text" id="importe_pago_producto" class="form-control numeric" value="0">
                                    </div>

                                    <div class="form-group col-xs-12 col-md-6">
                                        <label class="control-label">% de comisión cobro proveedor<!--Del Producto--></label>
                                        <input type="text" id="porcentaje_comision_producto" class="form-control numericPer" value="0">
                                    </div>

                                    <div class="form-group col-xs-12 col-md-6">
                                        <label class="control-label">Importe de comisión cobro proveedor</label>
                                        <input type="text" id="importe_comision_producto" class="form-control numeric" value="0">
                                    </div>

									<div class="form-group hidden">
										<label class="control-label">Comisión cobro proveedor</label>
										<input type="text" id="imp_cxc" class="form-control" value="0">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">% margen mínimo RED 
											<span class="icon-info" onclick="showInformationModal('porcentaje')">
												<i class="fa fa-info-circle"></i>
											</span>
										</label>
										<input type="text" id="porcentaje_margen_red" class="form-control numericPer" value="0">
									</div>

									<div class="form-group col-xs-12 col-md-6">
										<label class="control-label">Importe margen mínimo RED 
											<span class="icon-info" onclick="showInformationModal('importe')">
												<i class="fa fa-info-circle"></i>
											</span>
										</label>
										<input type="text" id="importe_margen_red" class="form-control numeric" value="0">
									</div>
								</div>
				            </div>
						</div>
                        <!--Guardar información-->
                        <div class="row" id="div_guardar">
                            <div class="form-group col-xs-12" style="text-align:right;padding-right:30px;">
                                <button class="btn btn-xs btn-info "  onclick="guardarRelacion();" id="guardarE" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Guardando" style="margin-top:10px;"> Guardar </button>
                                <button class="btn btn-xs btn-info "  onclick="editarRuta();" id="editarE" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Actualizando" style="margin-top:10px;"> Guardar Edicion </button>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>


<div class="modal fade" id="modalEdicion" role="dialog">
    <div class="modal-dialog" style="width: 30%">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Producto</h4>
        </div>
        <div class="modal-body">
        	<div class="row" align="center">
        		<div class="col-md-8 col-md-offset-2" style="display: none;">
        		<label>ID ROW</label>
          		<input type="hidden" name="idRow" id="idRow" class="form-control">
          		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-8 col-md-offset-2">
        		<label>FAMILIA</label>
          		<select id="familia_edicion" class="form-control" onchange="BuscarSubFamiliasDinamico(this.value);"></select>
          		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-8 col-md-offset-2">
        		<label>SUBFAMILIA</label>
          		<select id="subfamilia_edicion" class="form-control" onchange="BuscarProductosDinamico(this.value)"></select>
          		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-8 col-md-offset-2">
        		<label>PRODUCTO</label>
          		<select id="producto_edicion" class="form-control"></select>
          		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-8 col-md-offset-2">
        		<label>IMPORTE</label>
          		<input type="text" class="form-control" id="importe_edicion" onkeyup="calcularDesIvaImporte(this.id);">
          		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-8 col-md-offset-2">
        		<label>DESCUENTO</label>
          		<input type="text" class="form-control" id="descuento_edicion" onkeyup="calcularDesIvaDescuento(this.id,event);">
          		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-8 col-md-offset-2">
        		<label>IMPORTE SIN DESCUENTO</label>
          		<input type="text" class="form-control" id="importesindescuento_edicion" disabled="">
          		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-8 col-md-offset-2">
        		<label>IMPORTE SIN IVA</label>
          		<input type="text" class="form-control" id="importesiniva_edicion" disabled="">
          		</div>
        	</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-default" onclick="editarProducto();">OK</button>
        </div>
      </div>
      
    </div>
  </div>

	<div class="modal fade" id="modal-information">
		<div class="modal-dialog" style="width: 45%;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Infomación</h4>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

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
		<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/js/ComisionesProdProv.js?v=<?php echo (rand()); ?>"></script>
		<script type="text/javascript">
			initEdicionComisiones();			 
		</script>
		<script src="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
		<link href="<?php echo $PATHRAIZ;?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">
	</body>
</html>