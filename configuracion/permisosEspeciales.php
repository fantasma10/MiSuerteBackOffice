

<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");


    
 
include ('./ajax/permisos/cat_versiones.php');
  

$submenuTitulo = "Pre-Alta";

$idOpcion = 179;
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">    
    
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::. Clientes Registrados</title>
<!-- N�cleo BOOTSTRAP -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- <link href="./css/style-autocomplete.css" rel="stylesheet"> -->
<link href="../css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet"> 
<!--ASSETS-->
<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../css/miredgen.css" rel="stylesheet">
<link href="../css/style-responsive.css" rel="stylesheet" />
<!--Estilos �nicos-->
<!--<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/datepicker.css" />-->
<link rel="stylesheet" href="../assets/data-tables/DT_bootstrap.css" />
<link href="../assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="../assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    
    

    <link href="./css/bootstrap.css" rel="stylesheet">
     <link href="./css/datepicker.css" rel="stylesheet">
   <!--<link href="./css/icons.css" rel="stylesheet">-->
  <link href="../css/material-design-iconic-font.css" rel="stylesheet">
  <link href="../css/table-responsive.css" rel="stylesheet">
    <link href="../inc/js/toastmessage/src/main/resources/css/jquery.toastmessage.css" rel="stylesheet">
    
     
      <script src="../inc/js/jquery.js"></script>
     <!-- <script src="./js/jquery-2.1.1.min.js" ></script>-->
     <script src="../css/ui/jquery.ui.core.js"></script>
<script src="../css/ui/jquery.ui.widget.js"></script>
<script src="../css/ui/jquery.ui.position.js"></script>
<script src="../css/ui/jquery.ui.menu.js"></script>
       <!--<script src="./js/jquery.autocomplete.js" ></script>-->
    <script src="../css/ui/jquery.ui.autocomplete.js"></script> 
     <!--<script src="./js/jquery.dcjqaccordion.2.7.js" ></script>-->
        <script src="../inc/js/input-mask/input-mask.js" ></script>
     <script src="./js/common-scripts.js" ></script>
     <!--<script src="./js/nuevocliente.js" ></script>-->
     <script src="./js/permisosespeciales.js" ></script>
    <script src="./js/bootstrap-datepicker.js" ></script>
      <script src="./js/jquery.alphanum.js" ></script>
    <script src="../inc/js/toastmessage/src/main/javascript/jquery.toastmessage.js" ></script>


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
          	.ui-autocomplete {
			max-height	: 190px;
			overflow-y	: auto;
			overflow-x	: hidden;
			font-size	: 12px;
			background-color: white;
		}
       .ui-helper-hidden-accessible, .inps{
	       display:none;
	       }
        #rutasdiv{
            
            display:none;
        }
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
<section class="panel" id="pannel1">
    <div id="content" class="page-content clearfix">
        <div class="contentwrappers">
            <form name="formBack" id="formModUno">
			<!--Content wrapper-->
		
			
			<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
				<div class="panel-heading">
					<h4 class="panel-title">Asignación de Productos a Permisos</h4>
						<div class="panel-controls panel-controls-right">
							<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
						</div>
				</div> 
				<div class="panel-body"> 
                    
                    <div class="row" align="center" >
                        <div class="col-xs-12">
							<div class="form-group">
							<label style="margin-botton:30px;color:#525f80; font-weight:normal">Primero seleccione la Versi&oacute;n y despues la Ruta. Al seleccionar la ruta, obtendr&aacute; algunos porcentajes e importes necesarios para validar que los porcentajes e importes capturados no excedan a los configurados en la ruta en los campos relacionados. </label>			
							</div>
						</div>
						
                    </div>
                     <div class="row" align="center" height="20px" >
                        <div class="col-xs-12">
							<label style="margin-botton:30px;color:#525f80; font-weight:normal">   </label>
						</div>
						
                    </div>
					<div class="row">
                        <div class="col-xs-2">
							<div class="form-group">
								
							</div>
						</div>
                        <div class="col-xs-3">
							<div class="form-group">
									  <label>Versión</label>
								<select class="form-control" id="cmbversion">
									<option value="-1">--</option>
                                    <?php echo $htmlVersion; ?>
                                </select>    
                                    
							</div>
						</div>
						<div class="col-xs-1">
							<div class="form-group">
						
								  <label>$Máximo</label>
								<input class="form-control" id="txtmaximo" maxlength="150" name="sEmisor"/>
                               
						
							</div>
						</div>
						<div class="col-xs-1"> 
							<div class="form-group" id="div-regimenfiscal">
								  <label>%Comercio</label>
								<input class="form-control" id="txtporcomercio" maxlength="150" name="sEmisor"/>
                                
							</div>
						</div>
						
                        <div class="col-xs-1">
							<div class="form-group">
						    <label>%Grupo </label>
								<input class="form-control" id="txtporgrup" maxlength="150" name="sEmisor"/>
													
							</div>
						</div>
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>%Usuario</label>
								<input class="form-control" id="txtporusuario" maxlength="150" name="sEmisor"/>
													
							</div>
						</div>
                        <div class="col-xs-1">
							<div class="form-group">
						   <label>%Especial</label>
								<input class="form-control" id="txtporespecial" maxlength="150" name="sEmisor"/>
													
							</div>
						</div>
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>%Costo</label>
								<input class="form-control" id="txtporcosto" maxlength="150" name="sEmisor"/>
													
							</div>
						</div>
					
					</div>
				
                   
                    
                    
                    
                    
                    <div class="row">
                        <div class="col-xs-2">
							<div class="form-group">
								
							</div>
						</div>
                        <div class="col-xs-3">
							<div class="form-group">
									  <label>Ruta</label>
								<select class="form-control" id="cmbruta" onchange="cargaruta();">
									
                                </select> 
							</div>
						</div>
						<div class="col-xs-1">
							<div class="form-group">
						
								  <label>$Mínimo</label>
								<input class="form-control" id="txtminimo" maxlength="150" name="sEmisor"/>
                               
						
							</div>
						</div>
						<div class="col-xs-1"> 
							<div class="form-group" id="div-regimenfiscal">
								  <label>$Comercio</label>
								<input class="form-control" id="txtimpcomercio" maxlength="150" name="sEmisor"/>
                                
							</div>
						</div>
						
                        <div class="col-xs-1">
							<div class="form-group">
						    <label>$Grupo </label>
								<input class="form-control" id="txtimpgrupo" maxlength="150" name="sEmisor"/>
													
							</div>
						</div>
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>$Usuario</label>
								<input class="form-control" id="txtimpusuario" maxlength="150" name="sEmisor"/>
													
							</div>
						</div>
                        <div class="col-xs-1">
							<div class="form-group">
						   <label>$Especial</label>
								<input class="form-control" id="txtimpespecial" maxlength="150" name="sEmisor" />
													
							</div>
						</div>
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>$Costo</label>
								<input class="form-control" id="txtimpcosto" maxlength="150" name="sEmisor"/>
													
							</div>
						</div>
					
					</div>
                    
                <div class="row" id="divstatus">
                        <div class="col-xs-8">
							<div class="form-group">
								
							</div>
						</div>
                   
                        <div class="col-xs-3">
							<div class="form-group">
								<label>Estatus</label>	 
								  <select class="form-control" id="txtestatus" onchange="updatestatus(this.value)">
                                        
                                        <option value="0">Activo</option>
                                        <option value="1">Inactivo</option>
                                        <option value="2">Suspendido</option>
                                        <option value="3">Baja</option>
                                        <option value="4">Bloqueado</option>
                                    </select>    
							</div>
						</div>
						<div class="col-xs-1">
							<div class="form-group">
						
								
                               
						
							</div>
						</div>
					
			</div>
                    
          <div id="rutasdiv">
                 <div class="row" align="center" height="20px" >
                        <div class="col-xs-12">
							<label style="margin-botton:30px;color:#525f80; font-weight:normal">   </label>
						</div>
						
                    </div>
		          <div class="row">
                      
                        <div class="col-xs-2">
							<div class="form-group">
								<label>Informaci&oacute;n de la Ruta:</label>
							</div>
						</div>
                       
					
					</div>
                     <div class="row" align="center" >
                        <div class="col-xs-12">
							<div class="form-group">
							<label style="margin-botton:30px;color:#525f80; font-weight:normal">Estas son Algunos Porcentajes e Importes configurados en la Ruta.  Los Porcentajes e Importes  capturados  arriba  en los campos relacionados no deber&aacute;n exeder a los mostrados abajo." </label>	
                                
                                
    
  
                                
							</div>
						</div>
						
                    </div>
                    <div class="row" align="center" height="20px" >
                        <div class="col-xs-12">
							<label style="margin-botton:30px;color:#525f80; font-weight:normal">   </label>
						</div>
						
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
							<div class="form-group">
						 
													
							</div>
						</div>
                            <div class="col-xs-1">
							<div class="form-group">
						  <label>%Comercio</label>
								<input class="form-control" id="pocomercio" maxlength="150" name="sEmisor" disabled/>
													
							</div>
						</div>
                        
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>%Usuario</label>
								<input class="form-control" id="porusuario" maxlength="150" name="sEmisor" disabled/>
													
							</div>
						</div>
                       
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>%Costo</label>
								<input class="form-control" id="porcosto" maxlength="150" name="sEmisor" disabled/>
													
							</div>
						</div>
                     
                      
                      
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>$Comercio</label>
								<input class="form-control" id="impcomercio" maxlength="150" name="sEmisor" disabled/>
													
							</div>
						</div>
                        
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>$Usuario</label>
								<input class="form-control" id="impusuario" maxlength="150" name="sEmisor" disabled/>
													
							</div>
						</div>
                        
                        <div class="col-xs-1">
							<div class="form-group">
						  <label>$Costo</label>
								<input class="form-control" id="impcosto" maxlength="150" name="sEmisor" disabled/>
													
							</div>
						</div>
                    
					
					</div>
                </div>
                    
                     <div class="row"> 
						 <div class="col-xs-12"> 
                             <br/>
				            <h5></h5>
                             <br/>
				         </div> 
					</div> 
                    
                    <div class="row" >     
                      
                                <div class="col-xs-2 "> 
                                  <div class="form-group inps">
								   
							     </div>
                                    
                                </div> 
                                <div class="col-xs-2 "> 
                                  <div class="form-group inps">
								   
							     </div>
                                    
                                </div> 
                               <div class="col-xs-8 "> 
                                   <div class="pull-right"> 
                                       <a href="#" class="btn btn-info btn-xs editar" id="btnGuardaProd" onclick="validarform()">Guardar</a>
                                     
                                      <a href="#" class="btn btn-info btn-xs editar" id="btnNuevoProd" onclick="limpiaformulario()" >Nuevo</a>
                                   </div>
                                </div> 
                         
                        
					</div> 
				</div>
			</div>

	
	          
            </form>
        </div>
    
    </div>

</section>
<section class="panel">
<div class="titulorgb-prealta">
<span><i class="fa fa-search"></i></span>
<h3>Permisos Especiales a Cadenas y/o Clientes y/o Sucursales</h3></div>
<div class="panel-bodys">
   <div class="contentwrappers">
           
		  <div class="row" align="center" >
                        <div class="col-xs-12">
							<div class="form-group">
							<label style="margin-botton:30px;color:#525f80; font-weight:normal">Haga una b&uacute;sqeda por Nombre o ID del Producto y en seguida haga clic en el bot&oacute;n filtrar para obtener el listado de las versiones en las que el producto ha sido incluido, Si elproducto no est&aacute; disponible en ninguna versi&oacute;n, haga clic en el bot&oacute;n "Agregar a Permisos" </label>			
							</div>
						</div>
						
          </div>	
       
       
       <div class="row" align="center" style="height:30px">
                   
          </div>	
    
       
       
         <div class="row">
                         <div class="col-xs-3">
							<div class="form-group">
							<label>Buscar por</label><br/>
                            <label>Nombre o ID del Producto: </label>
								<input class="form-control" id="txtProducto" maxlength="150" name="sEmisor" onblur="borraidprod()"/>
                                <input type="hidden" class="form-control" id="idproducto" maxlength="150" name="sEmisor"/>			
							</div>
						</div>
                        <div class="col-xs-3">
							<div class="form-group">
                                <label>Buscar por</label><br/>
							    <label>Nombre o ID de la Cadena: </label>
								<input class="form-control" id="txtcadena" maxlength="150" name="sEmisor" onblur="borraidcadena()"/>
                                <input type="hidden" class="form-control" id="idcadena" maxlength="150" name="sEmisor"/>			
							</div>
						</div>
             
						<div class="col-xs-3">
							<div class="form-group">
						        <label>Buscar por</label><br/>
								<label>Nombre o ID del Cliente: </label>
								<input class="form-control" id="txtcliente" maxlength="150" name="sEmisor" onblur="borraidcliente()" />
                                <input type="hidden" class="form-control" id="idcliente" maxlength="150" name="sEmisor"/>
                               
						</div>
						</div>
             
						<div class="col-xs-3"> 
							<div class="form-group">
						        <label>Buscar por</label><br/>
								<label>Nombre de Sucursal: </label>
								<select class="form-control" id="cmbSucursal" maxlength="150" name="sEmisor" onblur="" disabled>
                                    <option value="-1">--</option>
                                </select>
						
							</div>
						</div>
						
          </div>
         <div class="row" style="height:30px">
                        <div class="col-xs-12">
							<div class="form-group">
								
							</div>
						</div>
											
          </div>
       
        <div class="row" >
                        <div class="col-xs-4">
							<div class="form-group">
										
							</div>
						</div>
						<div class="col-xs-4" align="center">
							<div class="form-group">
                                
						  <a href="#"  style="width:120px" class="btn btn-info btn-xs editar" id="btnNuevoProd" onclick="cargapermisos()" >Filtrar</a>
							<a href="#"  style="width:120px"  class="btn btn-info btn-xs editar" id="btnGuardaProd" onclick="loadformulario()">Agregar Permisos</a>
                                 
                               
						
							</div>
						</div>
						<div class="col-xs-4"> 
							
						</div>
						
          </div>
       
            <div class="row" style="height:30px">
                        <div class="col-xs-12">
							<div class="form-group">
								
							</div>
						</div>
											
          </div>
       
       
    </div>                                 
                                   
 <div class="contentwrappers">
           
			<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
				<div class="panel-heading" >
					<h4 class="panel-title">Permisos Creados a los Productos</h4>
						<div class="panel-controls panel-controls-right">
							<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
						</div>
                </div> 
		      <div class="panel-body"> 
                    <div id="tablaCortes">    
	
                    </div> 
			 </div>

			
        </div>
    </div>
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

<!--*.JS Generales-->
<!--<script src="../inc/js/jquery.js"></script>-->
<script src="../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../inc/js/jquery.scrollTo.min.js"></script>
<script src="../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../inc/js/respond.min.js" ></script>
<script src="../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Fechas-->
<!--<script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
<!--Generales-->
<script src="../inc/js/common-scripts.js"></script>
<!--<script src="../inc/js/advanced-form-components.js"></script>-->
<!--Tabla-->
<script src="../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../assets/data-tables/DT_bootstrap.js"></script>

 <script >
           
            var usr = <?php echo $usuario; ?>
       
        </script> 