

<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");


    
    include ('./application/models/Cat_pais.php');
    include ('./application/models/Cat_regimen.php');
  

$submenuTitulo = "Pre-Alta";

$idOpcion = 131;
$tipoDePagina = "Mixto";
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

$idPerfil = $_SESSION['idPerfil'];
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::. Clientes Registrados</title>
<!-- N�cleo BOOTSTRAP -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../css/miredgen.css" rel="stylesheet">
<link href="../css/style-responsive.css" rel="stylesheet" />
<!--Estilos �nicos-->
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" href="../assets/data-tables/DT_bootstrap.css" />
<link href="../assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="../assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    
    
    
      <!--<link href="./css/main.css" rel="stylesheet">-->
    <link href="./css/bootstrap.css" rel="stylesheet">
   <!--<link href="./css/icons.css" rel="stylesheet">-->
  <link href="./css/material-design-iconic-font.css" rel="stylesheet">
  <link href="./css/table-responsive.css" rel="stylesheet">
    <link href="./js/toastmessage/src/main/resources/css/jquery.toastmessage.css" rel="stylesheet">
    
    
      <script src="./js/jquery-2.1.1.min.js" ></script>
     <!--<script src="./js/jquery.dcjqaccordion.2.7.js" ></script>-->
    <script src="./js/jquery.mask.min.js" ></script>
     <script src="./js/common-scripts.js" ></script>
     <script src="./js/autorizaProspecto.js" ></script>
    <script src="./js/toastmessage/src/main/javascript/jquery.toastmessage.js" ></script>

<!--Cierre del Sitio-->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
    <style>
    
    </style>    
    
 
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../inc/cabecera.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Men� Vertical---->
<!--Funci�n "Include" del Men�-->
<?php include("../inc/menu.php"); ?>
<!--Final del Men� Vertical----->
<!--Final de Barra Vertical Izquierda-->
<!--Contenido Principal del Sitio-->
<!--Funci�n Include del Contenido Principal-->
<?php include("../inc/main.php"); ?>

<section class="panel">
<div class="titulorgb-prealta">
<span><i class="fa fa-search"></i></span>
<h3>Validación y Autorización de Prospectos</h3><span id="nuevospn" class="rev-combo pull-right">Busqueda</span></div>
<div class="panel-bodys">
                                    <!--Inicio de Tabla Cadena-->
                                    <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="presubcadenas">
                                      <thead>
                                      <tr>
                                          <th>RFC</th>
                                          <th>Razón Social</th>
                               
                                          <th>Validado</th>
                                       
                                   
                                      
                                          <th>Editar</th>
                                      
                                          
                                      </tr>
                                      </thead>
                                      
                                      <tbody>
                                      <tr class="gradeA">
                                          <td> </td>
                                          <td> </td>
                                         
                                          <td width="120px" align="center"> </td>
                                      
                                          
                                         
                                          <td width="120px"> </td>
                                         
                                        
                                      </tr>
                                      <tr class="gradeA">
                                        <td> </td>
                                          <td> </td>
                                         
                                          <td> </td>
                                      
                                          <td> </td>
                                        
                                         
                                       
                                        
                                      </tr>
                                      <tr class="gradeA">
                                            <td> </td>
                                          <td> </td>
                                         
                                          <td> </td>
                                      
                                          <td> </td>
                                        
                                        
                                     
                                      </tr>
                                      <tr class="gradeA">
                                          <td> </td>
                                          <td> </td>
                                         <td> </td>
                                         <td> </td>
                                    
                                          
                                      </tr>
                                      <tr class="gradeA">
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                   
                                        
                                      </tr>
                                      </tbody>
                          </table>

</div>
<!--Cierre Contenido-->
</div>
</section>    
<!--Cierre Main-->
</div>
</div>
</section>
</section>                             
</body>
</html>


<!--*.JS Generales-->
<!--<script src="../inc/js/jquery.js"></script>-->
<script src="../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../inc/js/jquery.scrollTo.min.js"></script>
<script src="../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../inc/js/respond.min.js" ></script>
<script src="../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Fechas-->
<script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<script src="../inc/js/common-scripts.js"></script>
<!--<script src="../inc/js/advanced-form-components.js"></script>-->
<!--Tabla-->
<script src="../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../assets/data-tables/DT_bootstrap.js"></script>