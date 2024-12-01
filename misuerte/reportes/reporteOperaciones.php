<?php 
    include("../../inc/config.inc.php");
    include("../../inc/session.inc.php");
    $PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

    $submenuTitulo = "Contabilidad";
    $subsubmenuTitulo = "Movimientos";
    $tipoDePagina = "Lectura";
    $idOpcion = 221;

    if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
    	header("Location: ../../../error.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::.Reporte de Operaciones</title>
<!-- Núcleo BOOTSTRAP -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../css/miredgen.css" rel="stylesheet">
<link href="../../css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../../assets/bootstrap-datepicker/css/datepicker.css" />
<!-- <link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css" /> -->
<link rel="stylesheet" href="../../../css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />
<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">
<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<style>
	.ui-autocomplete-loading {
		background: white url('../../img/loadAJAX.gif') right center no-repeat;
	}
	.ui-autocomplete {
		max-height: 190px;
		overflow-y: auto;
		overflow-x: hidden;
		font-size: 12px;
	}
</style>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include("../../inc/menu.php"); ?>
<!--Final del Menú Vertical-->
<!--Contenido Principal del Sitio-->

<section id="main-content">


<section class="wrapper site-min-height">
<div class="row">
<div class="col-lg-12">

<!--Panel Principal-->
<div class="panelrgb">

<div class="titulorgb-prealta">
<span><i class="fa fa-search"></i></span>
<h3>Reporte de Operaciones de Mi Suerte</h3><span class="rev-combo pull-right">Reporte<br>de Operaciones</span></div>

<div class="panel">
    <div class="panel-body">
        <div class="well">
            <div class="form-group col-xs-12">
            	<div class="row">	                                
	                <div class="form-group col-xs-2">
	                    <label class="control-label">Fecha Inicial</label>
	                    <input class="form-control form-control-inline input-medium default-date-picker"
	                    id="fecha1" name="fecha1"
	                    data-date-format="yyyy-mm-dd" maxlength="10"
	                    value="<?php echo $g_hoy; ?>"
	                    onKeyPress="return validaFecha(event,'fecha1')"
	                    onKeyUp="validaFecha2(event,'fecha1')">
                        </div>
	                <div class="form-group col-xs-2">
	                    <label class="control-label">Fecha Final</label>
	                    <input class="form-control form-control-inline input-medium default-date-picker"
	                    id="fecha2" name="fecha2"
	                    data-date-format="yyyy-mm-dd" maxlength="10"
	                    value="<?php echo $g_hoy; ?>"
	                    onkeypress="return validaFecha(event,'fecha2')"
	                    onkeyup="validaFecha2(event,'fecha2')">
	                </div>
	                <div class="form-group col-xs-2">
	                    <label class="control-label">Metodo de pago</label>
	                    <select name="mPago" id="mPago" class="form-control m-bot15">
                                    <option value="0">Todos</option>
                                     <?php 
                                    $result = $MRDB->SP("CALL `pronosticos`.`sp_load_metodopago`();") or die(mysqli_error());
                                    while ($row = mysqli_fetch_array($result)){
                                            $id = $row["nIdvalue"];
                                            $nombre = utf8_encode($row["sNombre"]);
                                        echo '<option value='.$id.'>'.$nombre.'</option>';
                                    }
                                    mysqli_free_result($result);                                 
                                    ?>
                                    
                            </select>
	                </div>
                        
                    <button class="btn btn-xs btn-info" style="margin-top: 20px" id="btn_buscar"> Buscar </button>
                 
                    <div class="form-group col-xs-12">
                        <form method="post" id="" action="ajax/exportarReporteOperaciones.php">
                        <input type="hidden" name="fecha1_excel" id="fecha1_excel">
                        <input type="hidden" name="fecha2_excel" id="fecha2_excel">                        
                        <input type="hidden" name="mPago_excel" id="metodoPago">                        
                        <input type="hidden" name="textoMPago" id="textoMPago">                        
                        <button class="btn btn-xs btn-info pull-left excel" style="display:none;">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </button> 
                        </form><br>
                    </div>
                </div>                   
            </div>
        </div>
        <div id="gridboxExport" class="adv-table table-responsive" style="overflow-y: auto;" >
        	<div id="gridbox" class="table-responsive">
        		<table id="tabla_reporteOperaciones" class="table table-bordered table-striped" style="width: 100%;display:none;">
        			<thead>
        				<tr> 
        					<th>Fecha Contable</th>
        					<th>Fecha Solicitud</th>
        					<th>Fecha Confirmacion</th>                                               
        					<th>Nombre Juego</th>
        					<th>Metodo de Pago</th>   					
        					<th>Id Folio</th>
        					<th>Id Folio de Venta</th>
<!--        					<th>Id Juego</th>   					
        					<th>Id Modo Entrada</th>   					-->
        					<th>Monto Cargo</th>   					
        					<th>Monto Redencion</th>   					
        					<th>Monto</th>   					
        					<th>Comision Pronosticos</th>   					
        				</tr>
        			</thead>    
        			<tbody >
        			</tbody>
        		</table>
        	</div>                    
        </div>
    </div>
</div>
</div>
</div></div></section>
</section>


<!--*.JS Generales-->
<script src="../../inc/js/jquery.js"></script>
<script src="../../css/ui/jquery.ui.core.js"></script>
<script src="../../css/ui/jquery.ui.widget.js"></script>
<script src="../../css/ui/jquery.ui.position.js"></script>
<script src="../../css/ui/jquery.ui.menu.js"></script>
<script src="../../css/ui/jquery.ui.autocomplete.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
<!-- <script src="../../inc/js/_Reportes2.js" type="text/javascript"></script> -->
<!--Elector de Fecha-->
<script type="text/javascript" src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/reporteOperaciones.js"></script>                         
<script type="text/javascript">
	 initView();
</script>
</body>
</html>