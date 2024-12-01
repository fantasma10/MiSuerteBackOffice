

<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");


    
    include ('./application/models/Cat_pais.php');
    include ('./application/models/Cat_regimen.php');
  

$submenuTitulo = "Gestion de Rutas";

$idOpcion = 175;
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
<title>.::Mi Red::. Rutas Gestion</title>
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
    <script src="../inc/js/jquery.mask.min.js" ></script>
     <script src="./js/common-scripts.js" ></script>
     <!--<script src="./js/nuevocliente.js" ></script>-->
     <script src="./js/rutas.js" ></script>
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
       
    </style>    
    
    <div id="pop1" >
        <center>
        <div style="height:200px;width:600px;background-color:white;margin-top:150px">
            <div style="height:150px">
                <div style="height:50px"></div>
                <p class="popsley">¿Desea Eliminar el Registro de este Prospecto?</p>
            </div>
            <div style="width:100%; background-color:#a7b7fc;">
                <center>
                    <div type="button" class="botones" id="btncan" ><p class="pbtn">Cancelar</p></div>
                    <div type="button" class="botones" id="btnarc" ><p class="pbtn">Eliminar</p></div>
                </center>    
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
<section class="panel" id="pannel1">
    <div id="content" class="page-content clearfix">
        <div class="contentwrappers">
            <form name="formBack" id="formModUno">
			<!--Content wrapper-->
		
			
			<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
				<div class="panel-heading">
					<h4 class="panel-title">Registro de Rutas</h4>
						<div class="panel-controls panel-controls-right">
							<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
						</div>
				</div> 
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-2">
							<div class="form-group">
								<label>Producto</label>
								<select class="form-control" id="cmbProducto" name="nIdFamilia" >
									<option value="-1">--</option>
                                     
                                    <?php echo $htmlProductos; ?>
								</select>
							</div>
						</div>
						<div class="col-xs-2"> 
							<div class="form-group" id="div-regimenfiscal">
								<label>Proveedor</label>
								<select class="form-control" id="cmbProveedor" name="cmbSubfamilia" >
									<option value="-1">--</option>
                                    <?php echo $htmlProveedores; ?>
								</select>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group" id="div-regimenfiscal">
								<label>Conector </label>
								<select class="form-control" id="cmbconector" name="cmbSubfamilia" >
									<option value="-1">--</option>
                                    <?php echo $htmlConectores; ?>
								</select>
							</div>
						</div>
						
						
                       <div class="col-xs-2">
							<div class="form-group">
								<label>Descripci&oacute;n</label>
								<input class="form-control" id="txtdescr" maxlength="50" name="sEmail"/>
							</div>
						</div>
                         <div class="col-xs-2">
							<div class="form-group">
								<label>SKU Proveedor</label>
								<input class="form-control" id="txtsku" maxlength="10" name="sAbrev"/>
							</div>
						</div>
					
						<div class="col-xs-2 "> 
                                  <div class="form-group ">
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
					
					</div>
					
                    
                    <div class="row"> 
                        <div class="col-xs-2">
							<div class="form-group">
								<label>Inicio Vigencia</label>
								<input class="form-control nombre" id="txtIniVigencia" maxlength="50" name="sNombre"/>
							</div>
						</div>
                        <div class="col-xs-2">
							<div class="form-group">
								<label>Importe M&iacute;nimo</label>
								<input class="form-control nombre" id="txtMin" maxlength="10" name="sNombre"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>% Costo Producto</label>
								<input class="form-control " id="txtPorcostoruta" maxlength="10" name="sPorComProd"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>% Comisi&oacute;n Producto</label>
								<input class="form-control " id="txtporcomprod" maxlength="10" name="sImpComProd"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>% Comisi&oacute;n Cliente</label>
								<input class="form-control " id="txtPorComCte" maxlength="10" name="sPorComCte"/>
							</div>
						</div>
                        <div class="col-xs-2">
							<div class="form-group">
								<label>% Comisi&oacute;n Usuario</label>
								<input class="form-control " id="txtPorComUsr" maxlength="10" name="sImpComCte"/>
							</div>
						</div>
                     
                        
						
					</div> 
                    
                    <div class="row"> 
                        <div class="col-xs-2">
							<div class="form-group">
								<label>Fin Vigencia</label>
								<input class="form-control nombre" id="txtFinVigencia" maxlength="50" name="sPaterno"/>
							</div>
						</div>
                         <div class="col-xs-2">
							<div class="form-group">
								<label>Importe M&aacute;ximo</label>
								<input class="form-control nombre" id="txtMax" maxlength="10" name="sNombre"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>$ Costo Producto</label>
								<input class="form-control " id="txtimpcostoruta" maxlength="10" name="sPorComProd"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>$ Comisi&oacute;n Producto</label>
								<input class="form-control " id="txtImpComProd" maxlength="10" name="sImpComProd"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>$ Comisi&oacute;n Cliente</label>
								<input class="form-control " id="txtImpComCte" maxlength="10" name="sPorComCte"/>
							</div>
						</div>
                        <div class="col-xs-2">
							<div class="form-group">
								<label>$ Comisi&oacute;n Usuario</label>
								<input class="form-control " id="txtImpComUsr" maxlength="10" name="sImpComCte"/>
							</div>
						</div>
                    
						
					</div> 
                    
                     <div class="row"> 
						 <div class="col-xs-12"> 
                             <br/>
				            <h5>Servicios </h5>
                             <br/>
				         </div> 
					</div> 
                    
                    
               
                    
                    <div class="row" > 
						
                        <div class="col-xs-12 " id="servporfam"> 
							
                            <div class="row">
                                
                                
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
                      
                               
                                <div class="col-xs-4"> 
                               
                                    
                                </div> 
                        
                               <div class="col-xs-8 "> 
                                   <div class="pull-right"> 
                                       <a href="#" class="btn btn-info btn-xs editar" id="btnGuardaProd" onclick="validarform(1)">Guardar</a>
                                       <a href="#" class="btn btn-info btn-xs editar" id="btneditarprod" onclick="validarform(2)">Editar</a>
                                      <a href="#" class="btn btn-info btn-xs editar" id="btnNuevoProd" onclick="resetform()" >Nuevo</a>
                                   </div>
                                </div> 
                         
                        
					</div> 
				</div>
			</div>

			<input type="hidden" class="form-control" name="backUrl" value="<?php //echo base_url();?>index.php/clientes/afiliacionexpress/cliente"/>
			<input type="hidden" class="form-control" name="nIdRegimen"/>
                <input type="hidden"  class="form-control" name="idincr" id="idincr"/> 
                <input type="hidden" class="form-control" name="txtmail" id="txtmail"/> 
                <input type="hidden" class="form-control" name="txtnomcom" id="txtnomcom"/> 
                <input type="hidden" class="form-control" name="txtcodval" id="txtcodval"/> 
	          
            </form>
        </div>
    
    </div>

</section>
<section class="panel">
<div class="titulorgb-prealta">
<span><i class="fa fa-search"></i></span>
<h3>Rutas Registradas</h3><span id="nuevospn" class="rev-combo pull-right">Nueva<br>Ruta</span></div>
<div class="panel-bodys">
                                    <!--Inicio de Tabla Cadena-->
                                    <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="presubcadenas">
                                      <thead>
                                      <tr>
                                          <th>ID</th>
                                          <th>Ruta</th>
                               
                                          <th>Producto</th>
                                       
                                       <th>Proveedor</th>
                                      
                                          <th>Conector</th>
                                          <th>SKU</th>
                                          <th>Detalle</th>
                                          
                                      
                                          
                                      </tr>
                                      </thead>
                                      
                                      <tbody>
                                      <tr class="gradeA">
                                          <td width="80px"> </td>
                                          <td> </td>
                                          <td> </td>
                                          <td width="150px"> </td>
                                         
                                          <td width="150px" > </td>
                                      
                                          
                                         
                                          <td width="120px"> </td>
                                          <td width="80px"> </td>
                                         
                                         
                                        
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