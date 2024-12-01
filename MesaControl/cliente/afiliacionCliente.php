<?php
session_start();

$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
$perfil_usuario   = $_SESSION['idPerfil'];
include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
include("catalogo.php");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];
$parametro_cliente = $_POST["txtidCliente"];
$parametro_razon = $_POST["txtRazonSocial"];
$prealta =  (isset($_POST['prealta'])) ? $_POST['prealta'] : 0;

$submenuTitulo		= "Mesa de Control";
$subsubmenuTitulo	= "Formulario de Cliente";

$permisos = (in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_autorizador']) || in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_capturistas'])) ? true : false;

$idOpcion = 316;
$tipoDePagina = "mixto";
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

$partesFecHoy = explode("-", $hoy);
$aniop10 = $partesFecHoy[0]+10;
$hoyplus10 = $aniop10."-".$partesFecHoy[1]."-".$partesFecHoy[2];

if($prealta == "1") {
    $paso1 = "Prealta";
    $url1 = "/MesaControl/cliente/consulta.php?prealta=1";
    $paso2 = "Prealta";
    $url2 = '#" onclick="window.location.reload(true);';
}else if($prealta == "2"){
    $paso1 = "Consulta";
    $url1 = "/MesaControl/cliente/consultaCambiosClientes.php";
    $paso2 = "Prealta";
    $url2 = '#" onclick="window.location.reload(true);';
} else {
    $paso1 = "Consulta";
    $url1 = "/MesaControl/cliente/consulta.php";
    $paso2 = "Alta";
    $url2 = '#" onclick="window.location.reload(true);';
}

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
	<title>.::Mi Red::Alta de Cliente</title>
	<!-- Núcleo BOOTSTRAP -->
	<!-- <link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet"> -->
	<!--<link href="<?php echo $PATHRAIZ;?>/css/bootstrap3.min.css" rel="stylesheet">-->
	<link href="<?php echo $PATHRAIZ;?>/MesaControl/cliente/estilos/css/bootstrap3.min.css" rel="stylesheet">
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
    <link href="<?php echo $PATHRAIZ;?>/css/breadcrumb.css" rel="stylesheet" />
	
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

   		.mayusculas{
			text-transform: uppercase;
		} 

		.btn1{
			margin-top: 15px;
		}

        .btn2{display: none}

        #div-representanteLegal{display: none}

        .btnfin{margin:5px; display:none}

		#pdfvisor{
			display:none;
			height: 100%;
			width: 100%;
			position:fixed;
			background-color: rgba(255, 255, 255, 0.55);
			z-index: 1500;
		}
		#divpdf {
			height:80%;
			width:70%;
			margin-left:8%; 
			background-color:#e6e6e8;       
		}

		#divclosepdf {
			width:70%;
			margin-left:8%; 
			text-align: right;
		}

		#closepdf {
			color:red;
			font-size:20px;
			font-weight: bold;
			cursor: pointer;	
		}
       
		.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
			border-bottom:none;
		}
       
       	table thead {border:0px;}
       
       	th {    background-size: contain;}
    	.montos{width:70px; }
    
    	.ui-autocomplete-loading {
			background: white url('<?php echo $PATHRAIZ;?>/img/loadAJAX.gif') right center no-repeat;
		}

		.loading-input {
			background: white url('<?php echo $PATHRAIZ;?>/img/loadAJAX.gif') right center no-repeat;
		}

    	.ui-autocomplete {
			max-height	: 190px;
			overflow-y	: auto;
			overflow-x	: hidden;
			font-size	: 12px;
			background-color: white;
			color:black,
		}
       .ui-helper-hidden-accessible{
	       display:none;
	       }
	   .ui-menu-item{font-color:black}

        .form-check-input:disabled+label {
            color: #ccc;
        }

        input.transparent {
            color: transparent;
        }

        .btnfiles.disabled {
            pointer-events: painted;
        }
        .panel {
            max-width: 1100px;
        }

        .panelrgb {
            max-width: 1100px;
        }

        .nav-tabs li a.faltante {
            font-weight: bold;
            color: #428bca;
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
        <div id="bc">
            <a href="#" class="bc">Multipagos</a>
            <a href="#" class="bc">Cliente</a>
            <a href="<?php echo $url1 ?>" class="bc"><?php echo $paso1 ?></a>
            <a href="<?php echo $url2 ?>" class="bc"><?php echo $paso2 ?></a>
        </div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panelrgb">
					<div class="titulorgb-prealta">
						<span><i class="fa fa-user"></i></span>
						<h3>Datos del Cliente -</h3><h3 id="title_cliente"><?php echo $parametro_razon; ?></h3>
                        <span class="rev-combo pull-right"><?php echo $paso2 ?> <br>de Cliente</span>
						<input type="hidden" id="p_cliente" name="p_cliente" value='<?php echo $parametro_cliente; ?>' >
						<input type="hidden" id="p_razonSocial" name="p_razonSocial" value='<?php echo $parametro_razon; ?>' >
					</div>
					<div class="panel">
						<div class="wizard">
							<div class="wizard-inner">
								<div class="connecting-line"></div>
								<ul class="nav nav-tabs" role="tablist">

									<li id="li_paso0" role="presentation" class="active">
										<a id="tabTipoCliente" href="#step1" onclick="cargarApartadoTipoCliente()" data-toggle="tab" aria-controls="step1" role="tab" title="Definicion Cliente">
											<span class="round-tab">
												<i class="glyphicon glyphicon-folder-open"></i>  Tipo Cliente
											</span>
										</a>
									</li>

									<li id="li_paso1" role="presentation" class="disabled">
										<a href="#step2" aria-controls="step2" onclick="cargarApartadoDatosDireccion()" role="tab" title="Datos y Dirección">
											<span class="round-tab">
												<i class="glyphicon glyphicon-pencil"></i> Datos y Dirección
											</span>
										</a>
									</li>
									
									<li id="li_paso2" role="presentation" class="disabled">
										<a id="tabRepLegal" href="#step3" aria-controls="step3" onclick="cargarApartadoReplegalContrato()" role="tab" title="Representante Legal y Datos de contrato">
											<span class="round-tab">
												<i class="glyphicon glyphicon-folder-close"></i> Repr. Legal y Contrato
											</span>
										</a>
									</li>

									<li id="li_paso3" role="presentation" class="disabled">
										<a href="#step4" aria-controls="step4" onclick="cargarApartadoDocs()" role="tab" title="Documentos">
											<span class="round-tab">
												<i class="glyphicon glyphicon-duplicate"></i> Docs.
											</span>
										</a>
									</li>

									<li id="li_paso4" role="presentation" class="disabled">
										<a id="tabLiquidacion" href="#step5" aria-controls="step5" onclick="cargarApartadoLiquidaciones()"  role="tab" title="Liquidacion">
											<span class="round-tab">
												<i class="glyphicon glyphicon-calendar"></i> Liquidación
											</span>
										</a>
									</li>

									<li id="li_paso5" role="presentation" class="disabled">
										<a id="tabFacturacion" href="#step6" aria-controls="step6" onclick="cargarApartadoFacturacion()" role="tab" title="Datos Facturacion">
											<span class="round-tab">
												<i class="glyphicon glyphicon-list-alt"></i> Facturación
											</span>
										</a>
									</li>

									<li id="li_paso6" role="presentation" class="disabled" style="display: none">
										<a href="#step7" aria-controls="step7" role="tab" title="Ctas. Cntbles">
											<span class="round-tab">
												<i class="glyphicon glyphicon-equalizer"></i> Ctas Contables
											</span>
										</a>
									</li>

									<li id="li_paso7" role="presentation" class="disabled">
										<a href="#step8" aria-controls="step8" onclick="cargarApartadoMatriz()" role="tab" title="Matriz Escalamiento">
											<span class="round-tab">
												<i class="glyphicon glyphicon-th"></i> Matriz Escalamiento
											</span>
										</a>
									</li>

									<?php if(in_array($usuario_logueado, $usuarios_afiliacion_clientes['usuarios_autorizador'])){ ?>
										<li id="verificar" role="presentation" class="disabled">
											<a href="#" data-toggle="tab" aria-controls="complete" role="tab" title="Autorizar">
												<span class="round-tab" id="spanAutorizar">
													<i class="glyphicon glyphicon-ok"></i> Autorizar
												</span>
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>
							<div class="tab-content">
								<div class="tab-pane active" role="tabpanel" id="step1">
									<?php  include("./modulos/Mod_TipoCliente.php"); ?>
								</div>
								
								<div class="tab-pane" role="tabpanel" id="step2">
									<?php include("./modulos/Mod_DatosDireccion.php"); ?>
								</div>

								<div class="tab-pane" role="tabpanel" id="step3">
									<?php include("./modulos/Mod_ReplegalContrato.php"); ?>
								</div>

								<div class="tab-pane" role="tabpanel" id="step4">
									<?php include("./modulos/Mod_Docs.php"); ?>
								</div>

								<div class="tab-pane" role="tabpanel" id="step5">
									<?php include("./modulos/Mod_Liquidacion.php"); ?>
								</div>
						
								<div class="tab-pane" role="tabpanel" id="step6">
									<?php include("./modulos/Mod_Facturacion.php"); ?>   
								</div>

								<div class="tab-pane" role="tabpanel" id="step7">
									<?php include("./modulos/Mod_CtaContables.php"); ?>
								</div>

								<div class="tab-pane" role="tabpanel" id="step8">
									<?php include("./modulos/Mod_MatrizEscalamiento.php"); ?>
								</div>

								<div class="tab-pane" role="tabpanel" id="complete">
									<h3>Formulario Completo</h3>
									<p id="mensajefinal"></p>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
        			</div>      
				</div>
			</div>
		</div>
	</section>
</section>
	
<button id="btnVisor" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVisor" style="display: none;"></button>
<div class="modal fade" id="modalVisor" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xs" style="width: 50%;height: 100%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Ver Comprobante</h4>
			</div>
			<div class="modal-body" >
				<iframe id="iframepdf" src="" style="width: -moz-available;height: 600px;"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-agreement">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
        	<div id="contenedorEmbed"></div>
        	<!-- <embed src="" frameborder="0" width="100%" height="400px" id="embertoIn"> -->
      	</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

		<!--*.JS Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
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
		<script src="<?php echo $PATHRAIZ;?>/MesaControl/cliente/js/common-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/paycash/ajax/pdfobject.js"></script>
        <!--Autocomplete -->
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.core.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.widget.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.position.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.menu.js"></script>
        <script src="<?php echo $PATHRAIZ;?>/css/ui/jquery.ui.autocomplete.js"></script>	
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.inputmask.bundle.js"></script>

        <script src="<?php echo $PATHRAIZ;?>/MesaControl/cliente/js/configControlCambios.js?"></script>
        <script>
            var usuario_autorizador    = parseInt('<?php echo (in_array($usuario_logueado, $usuarios_afiliacion_clientes["usuarios_autorizador"])) ? 1 : 0; ?>');
            var usuario_capturisa      = parseInt('<?php echo (in_array($usuario_logueado, $usuarios_afiliacion_clientes["usuarios_capturistas"])) ? 1 : 0; ?>');
        </script>
        <script src="<?php echo $PATHRAIZ;?>/MesaControl/cliente/js/afiliacion.js?v=1.0.3"></script>

        <script>
            catalogos['cmbSolicitante'] = JSON.parse('<?php echo json_encode($dataSolicitantes); ?>');
            catalogos['nIdTipoAcceso']  = JSON.parse('<?php echo json_encode($dataTipoaccesso); ?>');
            catalogos['idFamilias']     = JSON.parse('<?php echo json_encode($dataFamilias); ?>');
            catalogos['cmbIdentificacion'] = JSON.parse('<?php echo json_encode($datatipoID); ?>');
            catalogos['cmbTipoLiquidacionOperaciones'] = JSON.parse('<?php echo json_encode($dataTipoLiquidaciones); ?>');
            catalogos['cmbPeriodoPagoCom'] = JSON.parse('<?php echo json_encode($dataTipoLiquidaciones); ?>');
            catalogos['cmbBancoPago'] = JSON.parse('<?php echo json_encode($dataBancos); ?>');
            catalogos['cmbPaisPago'] = JSON.parse('<?php echo json_encode($dataPais); ?>');
            catalogos['cmbMonedaExt'] = JSON.parse('<?php echo json_encode($dataMonedas); ?>');
            catalogos['cmbPeriodoCobroCom'] = JSON.parse('<?php echo json_encode($dataTipoLiquidaciones); ?>');
            catalogos['cmbCuentaRED'] = JSON.parse('<?php echo json_encode($dataCuentasRE); ?>');
            usuario_id = parseInt('<?php echo $usuario_logueado; ?>');
            peril_usuario = parseInt('<?php echo $perfil_usuario; ?>');
        </script>

        <script src="<?php echo $PATHRAIZ;?>/MesaControl/cliente/js/codigo_postal.js"></script>

        <script type="text/javascript">
            BASE_PATH = "<?php echo $PATHRAIZ;?>";
            PERMISOS = parseInt("<?php echo $permisos;?>");
            DATA_APARTADO_DIR = null;
			DATA_APARTADO_GENERAL = null;
			DATA_APARTADO_REPLCONT = null;

            initViewAltaCliente();			 
        </script>

        <script src="<?php echo $PATHRAIZ;?>/MesaControl/cliente/estilos/js/bootstrap-select.min.js"></script>
        <link href="<?php echo $PATHRAIZ;?>/MesaControl/cliente/estilos/css/bootstrap-select.min.css" rel="stylesheet">
        <script src="<?php echo $PATHRAIZ;?>/MesaControl/cliente/js/controlCambios.js?"></script>
	</body>
</html>