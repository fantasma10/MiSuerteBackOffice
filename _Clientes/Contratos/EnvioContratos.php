<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];
	
	$idOpcion = 105;
	$tipoDePagina = "Mixto";
	$esEscritura = true;
	
	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../../error.php");
		exit();
	}
	
	if ( esLecturayEscrituraOpcion($idOpcion) ) {
		$esEscritura = true;
	}
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
    <title>.::Mi Red::.Comisiones y Reembolsos
    </title>
    <!-- Núcleo BOOTSTRAP -->
    <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--ASSETS-->
    <link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
    <!-- ESTILOS MI RED -->
    <link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
    <link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo $PATHRAIZ; ?>/css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />
    <!--[if lt IE 9]><script src="js/html5shiv.js"></script><script src="js/respond.min.js"></script><![endif]-->
    <style>
		.resultadoBusqueda { display: none; }
		.ui-autocomplete-loading {
			background: white url('<?php echo $PATHRAIZ; ?>/img/loadAJAX.gif') right center no-repeat;
		}
		.ui-autocomplete {
			max-height: 190px;
			overflow-y: auto;
			overflow-x: hidden;
			font-size: 12px;
		}
		.botonGuardar { display: none; }
	</style>    
  </head>
  <?php include($_SERVER['DOCUMENT_ROOT']."/inc/cabecera2.php"); ?>
  <?php include($_SERVER['DOCUMENT_ROOT']."/inc/menu.php"); ?>
  <!--<body>-->
    <section id="main-content">
      <section class="wrapper site-min-height">
        <div class="row">
          <div class="col-xs-12">
            <!--Panel Principal-->
            <div class="panelrgb">
              <div class="titulorgb-prealta"> 
                <span> 
                  <i class="fa fa-users"></i>
                </span><h3>Clientes</h3>
              </div>
              <div class="panel">
                <div class="jumbotron">
                  <div class="container">        <h2>Envío de Contratos</h2>
                    <p>Seleccione el cliente o el representante legal al que desea enviar el contrato digital.</p>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="well">
                    <form class="form-horizontal" id="cuentasPantalla1" method="POST" action="">
                      <div class="form-group col-xs-4" style="margin-right:13px;"> 
                        <label class="control-label">Cliente:
                        </label> 
                        <br/>
                        <input class="form-control m-bot15" type="text" id="txtCliente" maxlength="240">
                        <input type="hidden" name="idCliente" id="idCliente" value="">
                        <input type="hidden" name="nombreCliente" id="nombreCliente" value="">
                      </div>
                      <div class="form-group col-xs-4" style="margin-right:13px;"> 
                        <label class="control-label">Representante Legal: 
                        </label> 
                        <br/> 
                        <input class="form-control m-bot15" type="text" name="representanteLegal" id="txtRepresentanteLegal" maxlength="765">
                        <input type="hidden" name="idRepresentanteLegal" id="idRepresentanteLegal" value="">
                        <input type="hidden" name="nombreRepresentanteLegal" id="nombreRepresentanteLegal" value="">
                        <input type="hidden" name="tipoBusqueda" id="tipoBusqueda" value="">
                      </div>
                      <button class="btn btn-success pull-left" id="buscar" type="button" style="margin-right:35px; margin-top:20px;">Enviar Contrato</button>
                    </form>
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
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
    <!--Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/EnvioContratos.js"></script>
<script>
	var BASE_PATH;
	var error;
	$(function(){
		BASE_PATH = "<?php echo $PATHRAIZ; ?>";
		initComponents();
	});
</script>
    <!--Cierre del Sitio-->
  </body>
</html>