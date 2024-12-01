

<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");

include("catalogos.php");
    
    /*include ('./application/models/Cat_pais.php');
    include ('./application/models/Cat_regimen.php');*/
$hoy = date('ymd') ;


$submenuTitulo = "Pre-Alta";

$idOpcion = 132;
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
<link href="./css/style-autocomplete.css" rel="stylesheet">  
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
      <script src="./js/jquery.autocomplete.js" ></script> 
     <!--<script src="./js/jquery.dcjqaccordion.2.7.js" ></script>-->
    <script src="./js/jquery.mask.min.js" ></script>
     <script src="./js/common-scripts.js" ></script>
     <!--<script src="./js/nuevocliente.js" ></script>-->
     <script src="./js/nuevasucursalAutorizar.js" ></script>
    <script src="./js/toastmessage/src/main/javascript/jquery.toastmessage.js" ></script>

<!--Cierre del Sitio-->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
    <style>
   
   
     
        section#pannel1{
            
            display:none
        }
        span#nuevospn{
           
            background-color:#4474d0;   
            color:white;
        }
   
        
        div#popupmap{
            height:100%;
            width:100%;
            position:fixed;
            z-index:100;
            background-color:rgba(81, 81, 82, 0.33);
            display: none;
        }
        div#maps{
            margin-top:150px;
            margin-left:35%;
            height: 410px;
            width:600px;
            z-index:200;
            position: relative;
            padding-left: 15px;
            background-color: white;
        
        }
        
        div#map{height: 385px;width:570px;   }
        div#btnclosemap{
           height:100%;width:15px;border-radius:10px;color:white;font-weight:bold;color:red;float:right;
            cursor:pointer;
        }
         .mayusculas{text-transform: uppercase;} 
        div#divcontactos{display:none}
        .btn1{margin-top: 15px;}
        #tdacciones{display:none}
        #thacciones{display:none}
         .btnfin{margin:5px;}
  #pdfvisor{
           display:none;
           height: 100%;
           width: 100%;
           position:fixed;
           background-color: rgba(255, 255, 255, 0.55);
           z-index: 1500;
       }
   #divpdf{
           
           height:650px;
           width:70%;
            
          
            
         background-color:#e6e6e8;       
       }
       #divclosepdf{
         width:70%;
          
           text-align: right;
       }
       #closepdf{
           color:red;
           font-size:20px;
           font-weight: bold;
           cursor: pointer;
           
       }
       
       
    </style>    
    

    <div id="pdfvisor">
         <center>
        <div id="divclosepdf" ><span id="closepdf" title="Cerrar PDF">X</span></div>
        <div id="divpdf">
            
            <object id="pdfdata" data="" type="application/pdf" width="100%" height="100%"></object>
          
        </div>
         </center>      
     </div>
     <div id="popupmap">
     
        <div id="maps">
            <div style="height:15px;width:100%;align:right;"><div id="btnclosemap">X</div></div>
            <div id="map"></div>
        
        </div>
   
         <script async defer
                 src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFOzxKd4vBpuj8jl4p3gzGxPFt12P74H0&callback=initMap">
         </script>

    </div>
    
    
    
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
    
 
    
<section class="panel" id="pannel1">
  <div id="content" class="page-content clearfix">
   <!-- <div class="contentwrapper">
        <!--Content wrapper-->
     
		<!--Panel Información General-->
		<div class="panel panel-default toggle panelMove panelClose panelRefresh"> 
			<div class="panel-heading">
				<h4 class="panel-title">Información General</h4>
				<div class="panel-controls panel-controls-right">
					
				</div>
			</div> 
			<div class="panel-body">
				<?php
					include('./application/views/sucursales/modulos/informacionGeneral.php');
				?>
			</div>
		</div>
		<!--.Panel Información General-->
		
		<!--Panel Información General-->
		<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr0">
			<div class="panel-heading">
				<h4 class="panel-title">Dirección</h4>
				<div class="panel-controls panel-controls-right">
					<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
				</div>
			</div> 
			<div class="panel-body">     
				<?php
					include('./application/views/sucursales/modulos/direccion.php');
				?>
			</div>
		</div>  
		<!--Panel de Configuración-->
		<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr2"> 
			<div class="panel-heading">
				<h4 class="panel-title">Configuración</h4>
				<div class="panel-controls panel-controls-right">
					<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
				</div>
			</div> 
			<div class="panel-body">
				<?php
					include('./application/views/sucursales/modulos/tipoacceso.php');
				?>
			</div>      
		</div>
		<!--.Panel de Configuración--> 
		
		<!--Panel de Contactos-->
		<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="divcontactos"> 
			<div class="panel-heading">
				<h4 class="panel-title">Contactos</h4>
				<div class="panel-controls panel-controls-right">
					<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
				</div>
			</div>  
			<?php
				include('./application/views/sucursales/modulos/contactos.php');
			?>
		</div>
			<!--.Panel de Contactos--> 
		<button type="button" class="btn btn-primary btn-sm pull-right" id="btnGuardarSucursal">Guardar</button>
        <button type="button" class="btn btn-primary btn-sm pull-right btnfin" id="btnAutorizarSolicitud">Autorizar Solicitud</button>
      <button type="button" class="btn btn-primary btn-sm pull-right btnfin" id="btnValidarSolicitud">Validar Solicitud</button>
	</div> 
<!--</div>--> 

</section>
<section class="panel">
<div class="titulorgb-prealta">
<span><i class="fa fa-search"></i></span>
<h3>Validación y Autorización de Sucursales</h3><span id="nuevospn" class="rev-combo pull-right">Buscar<br>Registro</span></div>
<div class="panel-bodys">
                                    <!--Inicio de Tabla Cadena-->
                                    <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="presubcadenas">
                                      <thead>
                                      <tr>
                                            <th>No. Sucursal</th>
                                            <th>Nombre</th>
                                            <th>RFC Cliente</th>
                                            <th>Razon social</th>
                                            <th>Editar</th>
                                            <th>Eliminar</th>
                                          <th>Validado</th>
                                          <th>Autorizado</th>
                                          
                                      </tr>
                                      </thead>
                                      
                                      <tbody>
                                      <tr class="gradeA">
                                          <td width="120px"> </td>
                                          <td> </td>
                                         
                                          <td width="120px"> </td>
                                      
                                          
                                         
                                          <td > </td>
                                          <td width="70px"> </td>
                                          <td width="70px"> </td>
                                          <td width="70px"> </td>
                                          <td width="70px"> </td>
                                         
                                        
                                      </tr>
                                      <tr class="gradeA">
                                        <td> </td>
                                          <td> </td>
                                         
                                          <td> </td>
                                      
                                          <td> </td>
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