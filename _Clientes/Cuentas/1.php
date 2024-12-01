<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];
	
	$idOpcion = 97;
	$tipoDePagina = "Mixto";
	$esEscritura = true;
	
	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../../error.php");
		exit();
	}
	
	if ( esLecturayEscrituraOpcion($idOpcion) ) {
		$esEscritura = true;
	}	
	
	$error = isset($_GET["e"])? $_GET["e"] : 0;
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
                </span><h3>Afiliación Express</h3>
              </div>
              <div class="panel">
                <div class="jumbotron">
                  <div class="container">        <h2>Cuentas</h2>
                    <p>Busque y seleccione la cuenta a configurar.
                    </p>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="well">
                    <form class="form-horizontal" id="cuentasPantalla1" method="POST" action="2.php">
                      <div class="form-group col-xs-4" style="margin-right:13px;"> 
                        <label class="control-label">Cliente:
                        </label> 
                        <br/>
                        <input class="form-control m-bot15" type="text" id="txtCliente" maxlength="240">
                        <input type="hidden" name="idCliente" id="idCliente" value="">
                        <input type="hidden" name="nombreCliente" id="nombreCliente" value="">
                      </div>
                      <div class="form-group col-xs-4" style="margin-right:13px;"> 
                        <label class="control-label">Corresponsal:
                        </label> 
                        <br/> 
                        <input class="form-control m-bot15" type="text" name="nombreCorresponsal" id="txtCorresponsal" maxlength="50">
                        <input type="hidden" name="idCorresponsal" id="idCorresponsal" value="" />
                        <input type="hidden" name="idCadena" id="idCadena" value="" />
                        <input type="hidden" name="idSubcadena" id="idSubcadena" value="" />
                      </div>
                      <div class="form-group col-xs-4" style="margin-right:13px;"> 
                        <label class="control-label">Cuenta: 
                        </label> 
                        <br/> 
                        <input class="form-control m-bot15" type="text" name="numeroCuenta" id="txtCuenta" maxlength="10">
                        <input type="hidden" name="tipoBusquedaP2" id="tipoBusquedaP2">
                      </div>
                      <button class="btn btn-success pull-right" id="buscar" type="button" style="margin-right:35px; margin-top:20px;">Buscar</button>
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
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
    <!--Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/CuentaBancaria.js"></script>
<script>
	var BASE_PATH;
	var error;
	$(function(){
		BASE_PATH = "<?php echo $PATHRAIZ; ?>";
		error = <?php echo $error; ?>;
		initComponents();
	});
</script>
    <!--Cierre del Sitio-->
  </body>
</html>