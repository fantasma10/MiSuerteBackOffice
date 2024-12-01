<?php 
#########################################################
#
#Codigo PHP
#
include("inc/config.inc.php");
include("inc/session.inc.php");

if ( !isset($_SESSION['MiSuerte']) ) {
	header('Location: ./logout.php');
	exit;		
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="../../../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../../../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::.Sistemas - Usuarios</title>
<!-- N�cleo BOOTSTRAP -->
<link href="../../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../../css/miredgen.css" rel="stylesheet">
<link href="../../../css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../../../assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" href="../../../assets/data-tables/DT_bootstrap.css" />
<style>
	.centrar {
		text-align: center;
	}
</style>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Men� Vertical-->
<!--Funci�n "Include" del Men�-->
<?php include("inc/menu.php"); ?>
<!--Final del Men� Vertical-->
<body>

<section id="main-content">
	<section class="wrapper site-min-height">
    	<div class="row">
        	<div class="col-lg-12">
            	<section class="panel">
                    <div class="titulorgb">
                        <span><i class="fa fa-clipboard"></i></span>
                        <h3>Error</h3><span class="rev-combo pull-right">Mensaje<br>de Error</span>
                    </div>
                    <div class="panel-body centrar">
                        <img src="img/btn_ico_error.png" title="Error" />
                        <br />
                        <br />
                        Lo Sentimos
                        <br />
                        <strong>No tienes permisos para acceder a esta p&aacute;gina</strong>
                        <br />
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
<!--*.JS Generales-->
<script src="../../../inc/js/jquery.js"></script>
<script src="../../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../../inc/js/common-scripts.js"></script>
</body>
</html>