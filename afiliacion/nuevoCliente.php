

<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");


    
    include ('./application/models/Cat_pais.php');
    include ('./application/models/Cat_regimen.php');
  

$submenuTitulo = "Pre-Alta";

$idOpcion = 2;
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
    
      <script >
           
            var usr = <?php echo $usuario; ?>
       
        </script> 
      <script src="./js/jquery-2.1.1.min.js" ></script>
     <!--<script src="./js/jquery.dcjqaccordion.2.7.js" ></script>-->
    <script src="./js/jquery.mask.min.js" ></script>
     <script src="./js/common-scripts.js" ></script>
     <script src="./js/nuevoclientead.js" ></script>
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
        
#presubcadenas tbody tr:hover,#presubcadenas tr:hover{
	background-color:#c4d2f8
}
        

    </style>    
    
    <div id="pop1" >
        <center>
        <div style="height:200px;width:600px;background-color:white;margin-top:150px">
            <div style="height:150px">
                <div style="height:50px"></div>
                <p class="popsley">¿Desea Eliminar el Registro de este cliente?</p>
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
				<div class="panel-heading " >
					<h4 class="panel-title" style=" display: inline;">Información Contable de Cliente</h4>
					
							<a href="#" class="toggle panel-minimize" style=" display: inline; float: right;"><img src="./img/icons/minus.png" onclick="inicial()"></img></a> 
					
				</div> 
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-1">
							<div class="form-group">
								<label>ID Cliente</label>
								<input class="form-control" id="txtIdCliente" maxlength="150" name="txtIdCliente" readonly/>
							</div>
						</div>
						<div class="col-xs-1"> 
							<div class="form-group" id="div-regimenfiscal">
								<label>ID Subcadena</label>
								<input class="form-control" id="txtIdSubcadena" maxlength="150" name="txtIdSubcadena" readonly/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group" id="div-rfc">
								<label>R.F.C.</label>
								<input class="form-control mex" id="txtRFC" maxlength="13" name="txtRFC" readonly/>
							</div>
						</div>
						
						<div class="col-xs-5">
							<div class="form-group">
								<label>Razón Social</label>
								<input class="form-control" id="txtRazonSocial" maxlength="150" name="txtRazonSocial" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Fecha Alta</label>
								<input class="form-control" id="txtFechaAlta" maxlength=""  name="txtFechaAlta" readonly/>
							</div>
						</div>
					</div>
                    
					<div class="row"> 
						<div class="col-xs-3">
							<div class="form-group">
								<label>Teléfono</label>
								<input class="form-control nombre" id="txttel" maxlength="50" name="txtPais" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Regimen</label>
								<input class="form-control nombre" id="txtRegimen" maxlength="50" name="txtRegimen" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Cadena</label>
								<input class="form-control nombre" id="txtCadena" maxlength="50" name="txtCadena" readonly/>
							</div>
						</div>
                        <div class="col-xs-3">
							<div class="form-group">
								<label>Correo electrónico</label>
								<input class="form-control nombre" id="txtSocio" maxlength="50" name="txtSocio" readonly/>
							</div>
						</div>
                       
						
					</div> 
               
                
				</div>
                
			</div>
            
            
               <div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
			
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-3">
							<div class="form-group">
								<label>Calle</label>
								<input class="form-control" id="txtcalle" maxlength="150" name="txtIdCliente" readonly/>
							</div>
						</div>
						<div class="col-xs-2"> 
							<div class="form-group" id="div-regimenfiscal">
								<label>Num. Exterior</label>
								<input class="form-control" id="txtnumext" maxlength="150" name="txtIdSubcadena" readonly/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group" id="div-rfc">
								<label>Num. Interior</label>
								<input class="form-control mex" id="txtnumint" maxlength="13" name="txtRFC" readonly/>
							</div>
						</div>
						
						<div class="col-xs-5">
							<div class="form-group">
								<label>Colonia</label>
								<input class="form-control" id="txtcolonia" maxlength="150" name="txtRazonSocial" readonly/>
							</div>
						</div>
					
					</div>
                    
					<div class="row"> 
						<div class="col-xs-4">
							<div class="form-group">
								<label>Municipio</label>
								<input class="form-control nombre" id="txtmunucipio" maxlength="50" name="txtPais" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Estado</label>
								<input class="form-control nombre" id="txtestado" maxlength="50" name="txtRegimen" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Pais</label>
								<input class="form-control nombre" id="txtpais" maxlength="50" name="txtCadena" readonly/>
							</div>
						</div>
                        <div class="col-xs-2">
							<div class="form-group">
								<label>Código Postal</label>
								<input class="form-control nombre" id="txtcp" maxlength="50" name="txtSocio" readonly/>
							</div>
						</div>
                       
						
					</div> 
               
                
				</div>
                
			</div>
					
			<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
				
				<div class="panel-body"> 
					
					<div class="row"> 
						<div class="col-xs-3">
							<div class="form-group">
								<label> Cuenta Forelo</label>
								<input class="form-control nombre" id="txtCtaForelo" maxlength="50" name="txtCtaForelo" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Tipo Forelo</label>
								<input class="form-control nombre" id="txtTipoForelo" maxlength="50" name="txtTipoForelo" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Tipo de Reembolso</label>
								<input class="form-control nombre" id="txtTipoComision" maxlength="50" name="txtTipoComision" readonly/>
							</div>
						</div>
                        <div class="col-xs-3">
							<div class="form-group">
								<label>Tipo de Liquidación</label>
								<input class="form-control nombre" id="txtTipoLiquidacion" maxlength="50" name="txtTipoLiquidacion" readonly/>
							</div>
						</div>
                       
						
					</div> 
                    <div class="row"> 
						<div class="col-xs-3">
							<div class="form-group">
								<label> Cuenta Contable</label>
								<input class="form-control nombre" id="txtCuentaContable" maxlength="50" name="txtCuentaContable" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Referencia</label>
								<input class="form-control nombre" id="txtReferencia" maxlength="50" name="txtReferencia" readonly/>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="form-group">
								<label>Clabe Interbancaria</label>
								<input class="form-control nombre" id="txtClabe" maxlength="50" name="txtClabe" readonly/>
							</div>
						</div>
                        <div class="col-xs-2 mt15"> 
							<a href="#" class="btn btn-info btn-xs " style="margin-top: 17px;margin-left: 2px;" id="btnRegistraCliente">Aceptar</a>
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
<h3>Nuevos  Clientes - Contabilidad</h3><span id="nuevospn" class="rev-combo pull-right">Busqueda</span></div>
<div class="panel-bodys">
                                    <!--Inicio de Tabla Cadena-->
                                    <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="presubcadenas">
                                      <thead>
                                      <tr>
                                          <th>RFC</th>
                                          <th>Razon Social</th>
                               
                                          <th>ID Cliente</th>
                                       
                                       <th>ID Subcadena</th>
                                      
                                          <th>Fecha Alta</th>
                                          
                                          <th>Detalle</th>
                                      
                                          
                                      </tr>
                                      </thead>
                                      
                                      <tbody>
                                      <tr class="gradeA">
                                          <td> </td>
                                          <td> </td>
                                         
                                          <td width="90px" align="center"> </td>
                                      
                                          
                                         
                                          <td width="90px"> </td>
                                          <td width="150px"> </td>
                                          <td width="80px"> </td>
                                          
                                         
                                        
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