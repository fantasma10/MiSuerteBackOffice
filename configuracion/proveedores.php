

<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");


    
    include ('./application/models/Cat_pais.php');
    include ('./application/models/Cat_regimen.php');
  

$submenuTitulo = "Pre-Alta";

$idOpcion = 176;
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
    <script src="../inc/js/jquery.mask.min.js" ></script>
     <script src="./js/common-scripts.js" ></script>
     <!--<script src="./js/nuevocliente.js" ></script>-->
     <script src="./js/proveedores.js" ></script>
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
					<h4 class="panel-title">Registro de Proveedores</h4>
						<div class="panel-controls panel-controls-right">
							<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
						</div>
				</div> 
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-3">
							<div class="form-group">
						
								<label>Nombre de Proveedor </label>
								<input class="form-control" id="txtnombre" maxlength="150" name="sEmisor"/>
                               
						
							</div>
						</div>
						<div class="col-xs-3"> 
							<div class="form-group" id="div-regimenfiscal">
								<label>Raz&oacute;n Social </label>
								<input class="form-control" id="txtrc" maxlength="150" name="sEmisor"/>
                                
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group" id="div-regimenfiscal">
								<label>RFC </label>
								<input class="form-control" id="txtrfc" maxlength="150" name="sEmisor"/>
                                
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group" id="div-regimenfiscal">
								<label>Tel&eacute;fono</label>
								<input class="form-control" id="txttel" maxlength="150" name="stel"/>
                                
							</div>
						</div>
						
                        
                        <div class="col-xs-2">
							<div class="form-group">
								<label>Tipo de Proveedor</label>
								<select class="form-control" id="cmbtipo">
									<option value="-1">--</option>
                                    <option value="0">Interno</option>
                                    <option value="1">Externo</option>
								</select>
							</div>
						</div>
                       
					
					</div>
				
                    <div class="row">
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">CLABE <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sCLABE" id="txtCLABE">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Banco <span class="asterisco">*</span></label>
						<select class="form-control" name="nIdBanco" id="cmbBanco" disabled="">
							<option value="-1">--</option>
						</select>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Cuenta <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="nCuenta" id="txtCuenta" readonly>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="form-group">
						<label class="">Beneficiario <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sBeneficiario" id="txtBeneficiario">
					</div>
				</div>
				<div class="col-xs-3">
					<div class="form-group">
						<label class="">Descripción</label>
						<input type="text" class="form-control" name="sDescripcion" id="txtDescripcion">
					</div>
				</div>
			</div>
			<div class="row" style="display:none">
                <div class="col-xs-4">
				    <div class="form-group">
					   <label class="">Estado de Cuenta <span class="asterisco">*</span></label>
					   <input type="file" class="hidess" style="" name="sFileEstadoDeCuenta" id="txtFileEstadoDeCuenta" idtipodoc="4">
                        
					   <input type="hidden" class="" style="" name="nIdDocEstadoCuenta" id="txtNIdDocEstadoCuenta" idtipodoc="4">
                    </div>
				</div>
                  <div class="col-xs-2">
				    <div class="form-group">
					
                        <input type="button" id="btnFileEdocta" value="Ver Documento" style="margin-top:10px">
				
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
								    <label>Estatus</label>
								    <select class="form-control" id="cmbstatus" onchange="updatestatus(this.value)">
                                        
                                        <option value="0">Activo</option>
                                        <option value="1">Inactivo</option>
                                        <option value="2">Suspendido</option>
                                        <option value="3">Baja</option>
                                        <option value="4">Bloqueado</option>
                                    </select>    
							     </div>
                                    
                                </div> 
                                <div class="col-xs-2 "> 
                                  <div class="form-group inps">
								    <label>N&uacute;mero de Cuenta</label>
								    <input class="form-control " id="txtnc" disabled="disabled"/>
							     </div>
                                    
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
<h3>Proveedores Registrados</h3><span id="nuevospn" class="rev-combo pull-right">Nuevo<br>Proveedor</span></div>
<div class="panel-bodys">
                                    <!--Inicio de Tabla Cadena-->
                                    <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="presubcadenas">
                                      <thead>
                                      <tr>
                                          <th>RFC</th>
                                          <th>Nombre</th>
                               
                                          <th>Raz&oacute;n Social</th>
                                       
                                       <th>N&uacute;mero de Cuenta</th>
                                      
                                       
                                          <th>Detalle</th>
                                          
                                      
                                          
                                      </tr>
                                      </thead>
                                      
                                      <tbody>
                                      <tr class="gradeA">
                                          <td> </td>
                                          <td> </td>
                                          <td> </td>
                                          <td width="150px"> </td>
                                         
                                     
                                          <td width="80px"> </td>
                                         
                                         
                                        
                                      </tr>
                                      <tr class="gradeA">
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
                                        
                                        
                                     
                                      </tr>
                                      <tr class="gradeA">
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