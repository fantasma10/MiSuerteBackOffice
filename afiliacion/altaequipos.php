

<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");


    
  
  

$submenuTitulo = "Alta de Equipos";

$idOpcion = 165;
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
$usuario = $_SESSION['idU'];	
$nombreusuario =  $_SESSION['nombre'];
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
<title>.::Mi Red::. Prospectos Registrados</title>
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
    
  <!-- <link href="./css/style-autocomplete.css" rel="stylesheet"> -->
<link href="../css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">   
    
      <!--<link href="./css/main.css" rel="stylesheet">-->
    <link href="./css/bootstrap.css" rel="stylesheet">
   <!--<link href="./css/icons.css" rel="stylesheet">-->
  <link href="./css/material-design-iconic-font.css" rel="stylesheet">
  <link href="./css/table-responsive.css" rel="stylesheet">
    <link href="./js/toastmessage/src/main/resources/css/jquery.toastmessage.css" rel="stylesheet">
    
      <script >
           
            var usr = <?php echo $usuario; ?>;
                
            var nombreusuario = '<?php echo $nombreusuario; ?>';  
          
       
        </script> 
      <script src="./js/jquery-2.1.1.min.js" ></script>
    
         <!-- <script src="./js/jquery-2.1.1.min.js" ></script>-->
     <script src="../css/ui/jquery.ui.core.js"></script>
<script src="../css/ui/jquery.ui.widget.js"></script>
<script src="../css/ui/jquery.ui.position.js"></script>
<script src="../css/ui/jquery.ui.menu.js"></script>
       <!--<script src="./js/jquery.autocomplete.js" ></script>-->
    <script src="./js/ui/jquery.ui.autocomplete.js"></script> 
     <!--<script src="./js/jquery.dcjqaccordion.2.7.js" ></script>-->
    <script src="./js/jquery.mask.min.js" ></script>
     <script src="./js/common-scripts.js" ></script>
     <script src="./js/altaequipos.js" ></script>
    <script src="./js/toastmessage/src/main/javascript/jquery.toastmessage.js" ></script>

<!--Cierre del Sitio-->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
    <style>
        div.botones{
            height:30px;
            width:80px;
            background-color: dodgerblue;
            color:white;
            display:inline-flex;
            margin: 10px;
            font-family: Verdana;
            cursor:pointer; 
        }
        p.pbtn{
            margin:5px 0px 10px 15px;
        }
        div.botones:hover{
            background-color: #0e3860;
        
        }
        div#pop1{
            height:100%;
            width:100%;
            position:fixed;
            z-index:100;
            background-color:rgba(173, 173, 250, 0.33);
            display: none;
        }
        p.popsley{
            color:darkred;
            font-family: Verdana;
            font-weight: bold;
            font-size:20px;
           
        }
        section#pannel1{
            
            display:none
        }
        span#nuevospn{
             cursor:pointer;
            background-color:#4474d0;   
            color:white;
        }
        span#nuevospn:hover{
             
            background-color:#a7c2f5;   
            color:#072e50;
        }
        section#panel2{
            
            display: none;
        }
        
        
        	.ui-autocomplete {
			max-height	: 190px;
			overflow-y	: auto;
			overflow-x	: hidden;
			font-size	: 12px;
			background-color: white;
		}
       .ui-helper-hidden-accessible{
	       display:none;
	       }
        #btnregresar:hover { background-color: #294890;}
    </style>    
    
     <!--- este es el modal donde se contienen los equipos -->
    <div id="disclamer"  class="modal fade col-xs-12" role="dialog">
        <center>
        <div class="modal-dialog" style="width:70%;">
                     <!-- Modal content-->
                    <div class="modal-content">
                       <div class="modal-header">
                          <span><i class="fa fa-lightbulb-o" style="font-size:18px"></i> Alta de Equipos</span>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                       </div>
                      <div class="modal-body texto">
                          <div class="row" >
                               <div class="form-group col-xs-1" style="margin-right:16px;"> </div> 
                              <div class="form-group col-xs-2" style="margin-right:16px;">
                                  <label>Cliente:</label>
                              </div>  
                               <div class="form-group col-xs-6" style="margin-right:16px;">
                                  <input type="text" class="form-control" id="txtclienteequipo" />
                                </div>
                              </div>  
                         
                          
                           <div class="row" >
                               <div class="form-group col-xs-1" style="margin-right:16px;"> </div> 
                              <div class="form-group col-xs-2" style="margin-right:16px;">
                                  <label>Sucursal:</label>
                              </div>  
                               <div class="form-group col-xs-6" style="margin-right:16px;">
                                  <input type="text" class="form-control" id="txtsucursalequipo" />
                                  </div>
                              </div>   
                          
                          
                           <div class="row" >
                              <div class="form-group col-xs-12" style="margin-right:16px;">
                                  <div id="trDetalle">
                                    
                                         <br>
                                         <div>
                                            <button type="button" class="btn btn-default" id="nuevoequipobtn" onclick="nuevoequipo()">Agregar Equipo</button>
                                         </div><br>
                                       <div>
                                            <label style="color:gray; font-weight:normal">El M&aacute;ximo n&uacute;mero de Cajas por Sucursal es de 9.</label>
                                         </div><br>
                                         <div id="equiposdiv">
                                         </div><br>
                                      <div align="left" style="padding-left:200px">
                                          <label style="color:Red;">ELIMINAR.-</label><label style="color:gray; font-weight:normal"> Click en el bot&oacute;n "Eliminar" para  eliminar los c&oacute;digos activos que aun no han sido utilizados en el cliente WebPos.</label><br>
                                          <label style="color:#0e3860;">DESHABILITAR.-</label><label style="color:gray; font-weight:normal">Click en el bot&oacute;n "Deshabilitar" Para impedir que se hagan operaciones webpos desde la caja relacionada.</label><br>
                                          <label style="color:dodgerblue;">ARCHIVAR.-</label><label style="color:gray; font-weight:normal">Click en el bot&oacute;n "Archivar" para  desaparecer el registro del listado y se reestablezca el conteo de cajas.</label><br>
                                      
                                        </div><br>
                                  </div>
                              </div>  
                          </div>
                     </div>
                     <div class="modal-footer">
    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                     </div>
                 </div>

        
        </div>
        </center>
    </div>
    
    
    <!--- este es el modal donde se contienen los operadores -->
    
        <div id="operadoresmodal"  class="modal fade col-xs-12" role="dialog">
        <center>
        <div class="modal-dialog" style="width:70%;">
                     <!-- Modal content-->
                    <div class="modal-content">
                       <div class="modal-header">
                          <span><i class="fa fa-lightbulb-o" style="font-size:18px"></i> Alta de Operadores</span>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                       </div>
                      <div class="modal-body texto">
                          <div class="row" >
                               <div class="form-group col-xs-1" style="margin-right:16px;"> </div> 
                              <div class="form-group col-xs-2" style="margin-right:16px;" align="right">
                                  <label>Cliente:</label>
                              </div>  
                               <div class="form-group col-xs-6" style="margin-right:16px;">
                                  <input type="text" class="form-control" id="txtclienteequipo2" />
                                </div>
                              </div>  
                         
                          
                           <div class="row" >
                               <div class="form-group col-xs-1" style="margin-right:16px;"> </div> 
                              <div class="form-group col-xs-2" style="margin-right:16px" align="right">
                                  <label>Sucursal:</label>
                              </div>  
                               <div class="form-group col-xs-6" style="margin-right:16px;">
                                  <input type="text" class="form-control" id="txtsucursalequipo2" />
                                  </div>
                              </div>   
                            <div class="row" >
                               <div class="form-group col-xs-1" style="margin-right:16px;"> </div> 
                              <div class="form-group col-xs-2" style="margin-right:16px;" align="right">
                                  <label>Correo del Cliente:</label>
                              </div>  
                               <div class="form-group col-xs-6" style="margin-right:16px;">
                                  <input type="text" class="form-control" id="txtclientecorreo" />
                                  </div>
                              </div>  
                          
                          
                           <div class="row" >
                              <div class="form-group col-xs-12" style="margin-right:16px;">
                                  <div id="trDetalle">
                                    
                                         <br>
                                         <div>
                                            <button type="button" class="btn btn-default" id="nuevoequipobtn" onclick="nuevooperador()">Agregar Operador</button>
                                         </div><br>
                                       <div>
                                            <label style="color:gray; font-weight:normal">El M&aacute;ximo n&uacute;mero de Operadores por Sucursal es de 9.</label>
                                         </div><br>
                                         <div id="operadoresdiv">
                                         </div><br>
                                      <div align="left" style="padding-left:200px">
                                          <label style="color:Red;">ELIMINAR.-</label><label style="color:gray; font-weight:normal"> Click en el bot&oacute;n "Eliminar" para  eliminar el operador desdeado y no pueda operar WebPos.</label><br>
                                          <label style="color:#0e3860;">REINICIAR.-</label><label style="color:gray; font-weight:normal">Click en el bot&oacute;n "REINICIAR" Para reiniciar la contrase&ntilde;a del operador y este pueda registrar una nueva.</label><br>
                                          <label style="color:dodgerblue;">DESBLOQUEAR.-</label><label style="color:gray; font-weight:normal">Click en el bot&oacute;n "DESBLOQUEAR" para  reniciar la sesi&oacute;n de un operador que se quedo sesionada en otra interfaz.</label><br>
                                      
                                        </div><br>
                                  </div>
                              </div>  
                          </div>
                     </div>
                     <div class="modal-footer">
    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                     </div>
                 </div>

        
        </div>
        </center>
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
    
    <section class="panel" id="pannelbusq">
  <div id="content" class="page-content clearfix">
   <!-- <div class="contentwrapper">
        <!--Content wrapper-->
     
		<!--Panel Información General-->
		<div class="panel panel-default toggle panelMove panelClose panelRefresh"> 
			<div class="panel-heading">
				<h4 class="panel-title">Buscar Sucursales por Cliente</h4>
				<div class="panel-controls panel-controls-right">
					  
				</div>
			</div> 
			<div class="panel-body">
				  <div class="row">
						<div class="col-xs-12">
							<label class="" style="color:gray; font-weight:normal">Para Agregar Equipos a las sucursales de los clientes, Ingrese en el cuadro de b&uacute;squeda  el ID del Cliente o el RFC del Cliente o la Raz&oacute;n social, y en seguida presione el bot&oacute;n Sucursales.</label>
						</div> 
					
					</div>
					<div class="row ">
						<div class="col-xs-4">
							
						</div> 
					
						<div class="col-xs-4">
							<div class="form-group">
								<label class="">Buscar por: ID Cliente, RFC o Raz&oacute;n Social.</label>
								<input type="text" class="form-control" name="sCliente" id="txtCliente">
								<input type="hidden" name="nIdCliente" id="txtIdCliente">
							</div>
						</div>
                       
						<div class="col-xs-4">
							
						</div>
					</div>
                	<div class="row">
						<div class="col-xs-5">
							
						</div> 
					
						
                        <div class="col-xs-2">
                            <center><button type="button" class="btn btn-primary btn-sm " id="btnBusacrSucursal">Sucursales</button></center>
						</div>
						<div class="col-xs-5">
							
						</div>
					</div>
			</div>
		</div>
		<!--.Panel Información General-->
		
		
		
			<!--.Panel de Contactos--> 
		
<!--</div>--> 

</section>

<section class="panel" id="panel1" >
<div class="titulorgb-prealta">
<span><i class="fa fa-search"></i></span>
<h3>Clientes con Equipos por Configurar</h3></div>
    <div class="row">
        <center>	
            <div class="col-xs-12">
				<label class="" style="color:gray; font-weight:normal">Este es el listado de los clientes Que: tiene alg&uacute;n equipo sin activar o que no tienen ning&uacute;n equipo activo o que no tienen ninguna sucursal y que el tipo de acceso "WebPos" ah sido seleccionado en la afiliaci&oacute;n.</label>
            </div> 
            <div class="col-xs-12">
				<label class="" style="color:gray; font-weight:normal">Para ver las sucursales del Cliente, haga clic en el icono editar de la columna "Ver Sucursales".</label>
            </div> 
        </center>
					
	</div>
<div class="panel-bodys">
                                    <!--Inicio de Tabla Cadena-->
                                    <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="presubcadenas">
                                      <thead>
                                      <tr>
                                          <th>ID</th>
                                          <th>RFC</th>
                                        <th>Raz&oacute;n Social</th>
                                          <th>Sucursales</th>
                                       
                                       <th>Fecha Alta</th>
                                      
                                          <th> Ver Sucursales</th>
                                      
                                          
                                      </tr>
                                      </thead>
                                      
                                      <tbody>
                                      <tr class="gradeA">
                                          <td width="100px"> </td>
                                          
                                         
                                          <td width="120px" align="center"> </td>
                                         <td> </td>
                                          
                                          <td width="80px" align="center"> </td>
                                         
                                          <td width="180px"> </td>
                                          <td width="100px"> </td>
                                         
                                        
                                      </tr>
                                      <tr class="gradeA">
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
                                     
                                      </tr>
                                      <tr class="gradeA">
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
                                      </tr>
                                      </tbody>
                          </table>

</div>
<!--Cierre Contenido-->
</div>
</section>    
    
    
<section class="panel" id="panel2">
<div class="titulorgb-prealta">
    <span><i class="fa fa-search"></i></span>
    <span><h3>Sucursales del Cliente:</h3><input type="text" id="txtcliente" style="background-color:transparent; border:none;width:650px; font-size:14px"/></span>
     <a href="altaequipos.php" ><button type="button" class="btn pull-right" height="50px" style="background-color: #243974; color:white" id="btnregresar">Regresar a<br>Clientes</button></a>
</div>
     <div class="row">
					<center>	<div class="col-xs-12">
							<label class="" style="color:gray; font-weight:normal">Para ver los Equipos de la sucursal, haga clic en el icono editar de la columna "Ver Equipos".</label>
                        </div> </center>
					
	</div>
<div class="panel-bodys">
                                    <!--Inicio de Tabla Cadena-->
            <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="sucursalesdt">
                                      <thead>
                                       <tr>
                                          <th>ID</th>
                                          <th>Codigo</th>
                                        <th>Nombre</th>
                                          <th>Equipos Activos</th>
                                       
                                       <th>Equipos Inactivos</th>
                                      
                                          <th>Ver Equipos</th>
                                           <th>Ver Operadores</th>
                                      
                                          
                                      </tr>
                                      </thead>
                                      
                                      <tbody>
                                      <tr class="gradeA">
                                          <td width="100px"> </td>
                                          
                                         
                                          <td width="120px" align="center"> </td>
                                         <td> </td>
                                          
                                          <td width="150px" align="center"> </td>
                                         
                                          <td width="150px" align="center"> </td>
                                          <td width="100px"> </td>
                                           <td width="100px"> </td>
                                         
                                        
                                      </tr>
                                      <tr class="gradeA">
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
                                      </tr>
                                      <tr class="gradeA">
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
                                      </tr>
                                      </tbody>
                          </table>

    </div>
</div>
</section>        
<!--Cierre Main-->
<!--</div>
</div>
</section>
</section>  -->                           
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