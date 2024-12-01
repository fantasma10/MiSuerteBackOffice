<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include($_SERVER["DOCUMENT_ROOT"]."/inc/customFunctions.php");
include("../../inc/lib/nusoap");

$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$idOpcion = 107;
$tipoDePagina = "Mixto";
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../error.php");
    exit();
}

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

$oWebService = new WebService($WSDL3V);
$clienteOK = $oWebService->createClient();

if ($clienteOK) {
	$cliente = $oWebService->getClient();
	$parametros = array();
	$parametros["Usuario"] = $usuarioWS3V;
	$parametros["Pass"] = $passwordWS3V;
	try {
		$resultado = $cliente->Saldo($parametros);
		$mensaje = $resultado->SaldoResult->mensaje;
		$error = $resultado->SaldoResult->error;
	} catch ( SoapFault $fault ) {
		echo "Error: ".$fault->getMessage();
	}
}else{
	echo "Error: ".$oWebService->getClientError();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<meta charset="UTF-8">
	<!--Favicon-->
	<link rel="shortcut icon" href="<?php echo $PATHRAIZ?>/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $PATHRAIZ?>/img/favicon.ico" type="image/x-icon"> 
	<title><?php echo $submenuTitulo." ".$subsubmenuTitulo;?></title>

	<!-- N�cleo BOOTSTRAP -->
	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../../assets/opensans/open.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	
	<link href="../../css/miredgen.css" rel="stylesheet">
	<link href="../../css/style-responsive.css" rel="stylesheet" />
	<link rel="stylesheet" href="../../css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />
		
	<link href="../../assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="../../assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
	<link rel="stylesheet" href="../../assets/data-tables/DT_bootstrap.css" />
	
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
		
	<style>
		.img-disabled{
    		opacity: 0.4;
		}
		.textcurrency {
			text-align  : right;
		}

		.ui-autocomplete-loading {
			background: white url('<?php echo $PATHRAIZ;?>/img/loadAJAX.gif') right center no-repeat;
		}
		.ui-autocomplete {
			max-height: 190px;
			overflow-y: auto;
			overflow-x: hidden;
			font-size: 12px;
		}

		.align-right{
			text-align : right;
		}

		.selected {
			background-color	: #DBECFF;
			color				: gray;
		}

		#gridbox{
			/*max-height: 190px;*/
			overflow-y: auto;
			overflow-x: auto;
		}

		#gridbox2{
			/*max-height: 190px;*/
			overflow-y: auto;
			overflow-x: auto;
		}
	</style>
	
	<style>
		.numero{
			width: 80px;
		}
		
		.codigo{
			width: 100px;
		}
		
		.estatus{
			width: 75px;
		}
	</style>
</head>
<body>
<?php
	include("../../inc/cabecera2.php");
	include("../../inc/menu.php");
?>
<section id="main-content">

<section class="wrapper site-min-height">
    <div class="row">
        <div class="col-lg-12">

            <!--Panel Principal-->
            <div class="panelrgb">
            <div class="titulorgb-prealta">
            <span><i class="fa fa-briefcase"></i></span>
            <h3>Cuenta Proveedor</h3><span class="rev-combo pull-right" style="text-align: right">Cuenta<br />Proveedor</span></div>

            <div class="panel">

            <div class="jumbotron">
                <div class="container">
                <h2>Cuenta Proveedor</h2>
                <p>Consulta de Saldo.</p>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">             
                        <div class="well">
                            <h4>3VDigitalCel</h4>
                            <form class="form-horizontal" id="formaCuentaProveedor" method="post" >                                      
                                <div class="form-group col-xs-4" style="margin-right:20px;">
                                    <label class="control-label" style="font-size: 15px;">Saldo:</label>
                                    <label class="control-label" style="font-size: 15px;" id="saldo3VDigitalCel">
										<?php
                                        	if ( !$error ) {
												echo "$".$mensaje;
											}else{
												echo $mensaje;
											}
										?>
                                    </label>
                                    <span id="leyendaSaldo">
                                    	<br />
                                    	Saldo disponible para este d&iacute;a
                                    </span>
                                </div>
                                          
                                <div class="col-xs-3">
                                    <button type="button" class="btn btn-guardar" style="margin-top: 2px;" id="consultar" onclick="getSaldo3VDigitalCel(event)">Actualizar</button>
                                    <input type="checkbox" name="actualizar" id="actualizar" onclick="actualizarSaldo3VDigitalCel(this.checked);" />
                                    <label class="texto_bold" id="lblacces" for="actualizar">
                                    	Actualizar
                                    </label>
                                </div>  
                            </form>
                        </div>
			
                        <div class="alert alert-danger d ocultarSeccion" id="alerta">
                        </div>
                    </div>      
                </div>
		
                <div class="row excel" id="botones_excel" style="display:none">
                    <div>
                    </div>
                <div class="col-lg-4">		
                    <button class="btn btn-xs btn-info pull-left excel"  onclick="ExportarRefBancariasMiRed()" style="margin-right:10px;">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </button>
                </div>			
            </div>

            <div id="gridbox" class="adv-table table-responsive" >

            </div>
		
            <div id="contenedor" class="adv-table">
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
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../../assets/data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/CuentaProveedor.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
</body>
</html>