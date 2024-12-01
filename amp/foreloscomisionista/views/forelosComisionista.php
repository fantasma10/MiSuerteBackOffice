<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];
$submenuTitulo = "Tipo de comercio";
$subsubmenuTitulo = "Tipo Comercio";
$tipoDePagina = "mixto";
$idOpcion = 281;
$parametro_proveedor = $_POST["txtidProveedor"];
if (!desplegarPagina($idOpcion, $tipoDePagina)) {
    header("Location: $PATHRAIZ/error.php");
    exit();
}
$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
    $esEscritura = true;
}
$hoy = date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php echo $BASE_PATH;?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo $BASE_PATH;?>/img/favicon.ico" type="image/x-icon">
    <title>.::Mi Red::.P&oacute;lizas</title>
    <!-- Núcleo BOOTSTRAP -->
    <link rel="stylesheet" href="<?php echo $BASE_PATH;?>/css/themes/base/jquery.ui.all.css" />

    <link href="<?php echo $BASE_PATH;?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $BASE_PATH;?>/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo $BASE_PATH;?>/css/style-autocomplete.css" rel="stylesheet">
    <link href="<?php echo $BASE_PATH;?>/css/jquery.alerts.css" rel="stylesheet">
    <link href="<?php echo $BASE_PATH;?>/css/jquery.powertip.css" rel="stylesheet">
    <!--ASSETS-->
    <link href="<?php echo $BASE_PATH;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo $BASE_PATH;?>/assets/opensans/open.css" rel="stylesheet" />
    <!-- ESTILOS MI RED -->
    <link href="<?php echo $BASE_PATH;?>/css/miredgen.css" rel="stylesheet">
    <link href="<?php echo $BASE_PATH;?>/css/style-responsive.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="<?php echo $BASE_PATH;?>/assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="<?php echo $PATHRAIZ?>/assets/data-tables/DT_bootstrap.css" />
        <style>
        .align-right{
            text-align : right;
        }

        .list-inline{
            font-size:12px;
        }
    </style>
        <style>

                #divRESParent{
                    display : none;
                }

                #emergente{
                    height: 100%;
                    background-color: #fff;
                    position:fixed;
                    left:0;
                    right:0;
                    top:0;
                    z-index: 1000;
                    visibility: hidden;
                }
                .ui-autocomplete-loading {
                    background: white url('../../../img/loadAJAX.gif') right center no-repeat;
                }
                .ui-autocomplete {
                    max-height: 190px;
                    overflow-y: auto;
                    overflow-x: hidden;
                    font-size: 12px;
                }
            </style>
    </head>
    <!--Include Cuerpo, Contenedor y Cabecera-->
    <?php include($PATH_PRINCIPAL . "/inc/cabecera2.php"); ?>
    <!--Inicio del Menú Vertical-->
    <!--Función "Include" del Menú-->
    <?php include($PATH_PRINCIPAL . "/inc/menu.php"); ?>
    <!--Final del Menú Vertical-->
    <!--Contenido Principal del Sitio-->


    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panelrgb">
                        <div class="titulorgb-prealta">
                            <span><i class="fa fa-user"></i></span>
                            <h3>Monitor de saldos FORELO</h3>
                            <span class="rev-combo pull-right"></span>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="wizard">

<!----->
<?php  
        function nombreCorresponsal($idCorresponsal){
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");
            $arrayParametrosCorresponsal= array(        
                'IdCorresponsal' => $idCorresponsal
            ); 
            $respuesta =(array) $client->ObtenerCorresponsalPorId($arrayParametrosCorresponsal);
            $nombreCorresponsalRes = $respuesta['ObtenerCorresponsalPorIdResult']->Model->anyType->enc_value->NombreCorresponsal;
            return $nombreCorresponsalRes;
        }

        function saldoCuenta($idCorresponsal){
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");
            $arrayParametrosCorresponsal= array(        
                'IdCorresponsal' => $idCorresponsal
            ); 
            $respuesta =(array) $client->ObtenerCuentaForelo($arrayParametrosCorresponsal); 
            $SaldoCuenta = $respuesta['ObtenerCuentaForeloResult']->Model->anyType->enc_value->SaldoCuenta;
            return $SaldoCuenta;
        }

        function ObtenerComisionista($idCadena,$idSubCadena,$idCorresponsal){
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");
            $arrayParametrosCorresponsal= array(        
                'IdCadena' => $idCadena,
                'IdSubCadena' => $idSubCadena,
                'Idcorresponsal' => $idCorresponsal
            ); 
            $respuesta =(array) $client->ObtenerComisionista($arrayParametrosCorresponsal);
            return $respuesta;
        }



        
        // $oRAMP->setSDatabase('data_AquiMisPagos');
        // $oRAMP->setSStoredProcedure('sp_select_forelosComisionistas');
        $oRAMP->setSDatabase('aquimispagos');
        $oRAMP->setSStoredProcedure('sp_select_forelos_Comisionistas');

        $param = array
                (    
                    array(
                    'name'  => 'CksComisionista',
                    'type'  => 's',
                    'value' => ''),
                    array(
                    'name'  => 'CkbCredito',
                    'type'  => 's',
                    'value' => -1)
        );
        $oRAMP->setParams($param);
        $result2 = $oRAMP->execute();          
        $forelos =  ($oRAMP->fetchAll());
        $oRAMP->closeStmt();

                for($i=0; $i<count($forelos); $i++){
                    $resp = ObtenerComisionista(169, $forelos[$i]['nIdSubCadenaRE'], $forelos[$i]['nIdCorresponsalRE']);    
                    
                    //if( trim($resp['ObtenerComisionistaResult']->Status) == '1'){ // OK
                        if( strlen($forelos[$i]['sRFC'] == 13) ){
                            $sNombre =  $forelos[$i]['sNombre'].' '. $forelos[$i]['sApellidoPaterno'].' '. $forelos[$i]['sApellidoMaterno'];
                        }else{
                            $sNombre =  $resp['ObtenerComisionistaResult']->Model->anyType->enc_value->RazonSocial;
                        }

                        $forelos[$i]['nombreCorresponsal'] = $resp['ObtenerComisionistaResult']->Model->anyType->enc_value->NombreCorresponsal;
                        $forelos[$i]['saldoCuenta'] = $resp['ObtenerComisionistaResult']->Model->anyType->enc_value->SaldoCuenta;
                        $forelos[$i]['sNombre'] = $sNombre;
                        $forelos[$i]['idTipoLiqComision'] = $resp['ObtenerComisionistaResult']->Model->anyType->enc_value->IdTipoLiqComision;
                        $forelos[$i]['CLABE'] = $resp['ObtenerComisionistaResult']->Model->anyType->enc_value->CLABE;
                    //}
                }
                
        $sUsuario="";
        $saldos="";
        $colores="";

        $sUsuarioCredito="";
        $saldosCredito="";
        $coloresCredito="";

        foreach ( ($forelos) as $key) {
            if ($key['bActivoGrafico']==1) 
            {
                if ($key['bCredito']==0) {
                    $sUsuario.="'".$key['sNombre']."',";
                    $saldos.= "'".$key['saldoCuenta']."',";
                    $colores.="'#28a745',";
                }else{
                    $sUsuarioCredito.="'".$key['sNombre']."',";
                    $saldosCredito.= "'".$key['saldoCuenta']."',";
                    $coloresCredito.="'#28a745',";
                }  
            }
        }
        
        $sUsuario=trim($sUsuario,",");
        $saldos=trim($saldos,",");    
        $colores=trim($colores,",");
        $sUsuarioCredito=trim($sUsuarioCredito,",");
        $saldosCredito=trim($saldosCredito,",");
        $coloresCredito=trim($coloresCredito,",");


        $oRAMP->setSDatabase('aquimispagos');
        $oRAMP->setSStoredProcedure('sp_select_tipo_forelo');   
        $param = array();
        $oRAMP->setParams($param);      
        $result2 = $oRAMP->execute();
        $cargaTipoForelo =  ($oRAMP->fetchAll());
        $oRAMP->closeStmt();

?>
                            <div class="form-group col-xs-12">
                                <div class="form-group col-xs-3">
                                    <input type="radio" class="custom-control-input" name="nIdTipoUsuario" id="customRadio1" value="1" checked="checked" onclick="verComisionistas(1);" >
                                    <label class="custom-control-label" for="customRadio1"  onclick="verComisionistas(1);"  >Crédito</label> 
                                </div>
                                <div class="form-group col-xs-3">
                                    <input type="radio" class="custom-control-input" name="nIdTipoUsuario" id="customRadio2" value="1"  onclick="verComisionistas(0);" >
                                    <label class="custom-control-label" for="customRadio2" onclick="verComisionistas(0);" >Prepago</label> 
                                </div>
                                <div class="form-group col-xs-3">
                                    <button type="button" data-toggle="modal" data-target="#consultarComisionista" onclick="resetbuscaModalComisionista();"  class="btn btn-primary btn-block">Consultar Comisionista</button>
                                </div>
                            </div>
                            <div class="form-group col-xs-12" id="myCanvas">
                                <canvas id="myChart" width="100%" height=""></canvas>
                            </div>
                            <div class="form-group col-xs-12" style="text-align: center;" >
                                <H4>Comisionista</H4>
                            </div>
                            <div class="form-group col-xs-12" style="text-align: center;">
                                <H5 ><button type="button" class="btn btn-warning" style="background: #dc3545;"> </button>Insuficiente <button type="button" class="btn btn-warning"> </button>Aceptable <button type="button" class="btn btn-warning" style="background:#28a745;"> </button>Satisfactorio</H5>
                            </div>
<!----->
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
    <script src="<?php echo $PATHRAIZ; ?>/inc/input-mask/input-mask.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script> -->
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->
    <script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
    <!--Generales-->
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
    <script src="<?php echo $PATHRAIZ ?>/inc/js/common-custom-scripts.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
    <!--<script src="<?php echo $PATHRAIZ; ?>/paycash/ajax/pdfobject.js"></script>-->
    <!--Autocomplete -->
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.core.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.widget.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.position.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.menu.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.autocomplete.js"></script>	
    <!--<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/codigo_postal.js"></script>-->
            <!--<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/consulta.js"></script>-->
    <script src="<?php echo $PATHRAIZ ?>/mis_pagos/cuponera/js/accounting.js"></script> 
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.inputmask.bundle.js"></script>
    <script type="text/javascript">

        BASE_PATH = "<?php echo $PATHRAIZ; ?>";
     
    </script>
    <script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
    <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <script type="text/javascript">
        $('document').ready(function(){
            verComisionistas(1);
        });
    
    function verComisionistas(credito=-1) {
        $("#myCanvas").html('');
        $("#myCanvas").html('<canvas id="myChart" width="100%" height=""></canvas>');
        var usuarios=[<?php echo $sUsuario;?>];
        var saldos=[<?php echo $saldos; ?>];
        var colores=[<?php echo $colores;?>];
        var sUsuarioCredito=[<?php echo $sUsuarioCredito;?>];
        var saldosCredito=[<?php echo $saldosCredito;?>];
        var coloresCredito=[<?php echo $coloresCredito;?>];                     
        if (credito==1){
            usuarios=(sUsuarioCredito);
            saldos=(saldosCredito);
            colores=(coloresCredito);
        }
        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: usuarios,
                datasets: [{
                    label: 'SALDO FORELO',
                    data: saldos,
                    backgroundColor: colores,
                    borderColor: colores,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

            
    </script>
    <script src="<?php echo $PATHRAIZ; ?>/amp/foreloscomisionista/js/forelosComisionista.js?v=<?php echo(rand()); ?>"></script>
    
        <div class="modal fade" id="consultarComisionista" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content"> 
                    <div class="modal-header">
                          <span  style="background-color:transparent; border:none; ">Consulta Comisionista</span>
                            <button type="button" class="close" data-dismiss="modal" title="Cerrar">×</button>
                            <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row"> 

                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                <div class="form-group form-floating"> 
                                    <label>Ingresa Nombre/Razón Social del Comisionista</label>
                                    <input type="text" class="form-control m-bot15" id="buscaComisionista" name="buscaComisionista" onkeyup="buscaComisionista();" > 
                                    <input type="hidden" id="idComisionista" value="-1"  />
                                </div>
                            </div> 
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Tipo de Persona</label>
                                    <input type="text" class="form-control m-bot15" id="TipoPerso" name="TipoPerso"  > 
                                </div>
                            </div> 
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Crédito / Prepago</label>
                                    <input type="text" class="form-control m-bot15" id="sIdTipoCredito" name="sIdTipoCredito"  > 
                                </div>
                            </div> 

                        </div>
                        <div class="row"> 
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                            <label id="slabelNombre">Nombre del Comisionista</label>
                            <input type="text"  readonly="readonly" class="form-control" id="sNombreComisionista" name="sNombreComisionista"> 
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                            <label id="slabelCadena">Nombre de la Cadena</label>
                            <input type="text"  readonly="readonly" class="form-control" id="sNombreCadena" name="sNombreCadena"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating">
                                    <h5 class="row" style="text-align: center;" >INFORMACIÓN FISCAL</h5> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label id="slabelNombre">RFC</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="sRFC" name="sRFC" > 
                                    </div>
                                </div> 

                        </div>
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>Calle</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="sCalle" name="sCalle" > 
                                    </div>
                                </div> 
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>Núm. Exterior</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="sNumExterior" name="sNumExterior" > 
                                    </div>
                                </div> 
                        </div>
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>Núm. Interior</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="sNumInterior" name="sNumInterior" > 
                                    </div>
                                </div> 
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>Colonia</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="sColonia" name="sColonia" > 
                                    </div>
                                </div> 
                        </div>
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>Municipio / Delegación</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="sMunicipio" name="sMunicipio" > 
                                    </div>
                                </div> 
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>Entidad Federativa</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="sEstado" name="sEstado" > 
                                    </div>
                                </div> 
                        </div>
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>Código Postal</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="nCodigoPostal" name="nCodigoPostal" > 
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>% IVA</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="nIVA" name="nIVA" > 
                                    </div>
                                </div> 
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label>Uso de CFDI</label>
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="" value="" id="sCFDI" name="sCFDI" > 
                                    </div>
                                </div> 
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating">
                                    <h5 class="row">FORELO</h5> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        
                                    </div>
                                </div> 
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label class="mb-1">SALDO:</label>
                                        <input type="text" readonly="readonly" class="form-control" placeholder="" value="" id="saldoCuenta" name="saldoCuenta" >                                          
                                    </div>
                                </div> 
                        </div>
                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"  > 
                                       <strong id="bForeloIndividual"></strong>
                                    </div>
                                </div> 
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <label class="mb-1"># de Tiendas</label> 
                                        <input type="text" readonly="readonly" class="form-control" placeholder="" value="" id="sNumeroTiendas" name="sNumeroTiendas" >                                         
                                    </div>
                                </div> 
                        </div>


                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating">
                                    <h5 class="row" style="text-align: center;" >Limites de Saldo</h5> 
                                </div>
                            </div>
                        </div>


                        

                        <div class="row"> 
                            <form method="post" id="formularioReglas" name="formularioReglas">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                    <div class="form-group row">                                        
                                            <input type="hidden" name="hnIdUsuario" id="hnIdUsuario" >
                                            <input type="hidden" name="hnIdSucursal" id="hnIdSucursal" >  
                                            <input type="hidden" name="txtnIdForelo" id="txtnIdForelo" >                             
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 alert-dark"><label for="" class="tiendas" id="" ></label></div>                                        
                                            <?php 
                                            $cont=0;
                                            $clase="";
                                            $col=round(12/(count($cargaTipoForelo) ));
                                            foreach ( ($cargaTipoForelo) as $keys) {  ?>
                                             <div class="col-<?php echo $col;?> col-sm-<?php echo $col;?> col-md-<?php echo $col;?> col-lg-<?php echo $col;?> col-xl-<?php echo $col;?>"> 
                                                <div class="form-group form-floating "> 
                                                        <label class="mb-1">Monto para <?php echo $keys['sNombre'];?></label> 
                                                        <input type="text" class="form-control rangoReglas rangoReglasTienda" onkeypress="soloNumeros();" name="rangoReglas[<?php echo $keys['nIdTipoForelo'];?>]"  id="nIdTipoForelo<?php echo $keys['nIdTipoForelo'];?>" name="" placeholder="" >
                                                        <input type="hidden" name="nIdrangoReglas[<?php echo $keys['nIdTipoForelo'];?>]" id="ids<?php echo $keys['nIdTipoForelo'];?>">
                                                        <!-- <label class="mb-1">Valor</label> -->
                                                        <?php if( $keys['nIdTipoForelo'] == 3 ){ $keys['sColor'] = 'info';} ?>
                                                        <p class="mb-<?php echo $keys['nIdTipoForelo'];?> alert-<?php echo $keys['sColor'];?> " for="S<?php echo $keys['nIdTipoForelo'];?>"><?php echo $keys['sNombre'];?></p>
                                                    </div>
                                                </div>
                                            <?php   
                                                if ($cont==count($cargaTipoForelo)) {
                                                    $cont=0;
                                                }  
                                                $cont++;                                                   
                                            } 
                                            ?>                                       
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 alert-dark" style="text-align: right;">
                                    <p><label for="bS">¿Enviar SMS de alerta saldo Insuficiente?</label>
                                    <input type="checkbox" onclick="" id="bS" name="bS"    ></p>                                    
                                    <p><label for="bM">Mostrar saldo del FORELO</label>
                                    <input type="checkbox" onclick="" id="bM" name="bM"   ></p>                                    
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating">
                                    <h5 class="row" style="text-align: center;" >FACTURACIÓN</h5> 
                                </div>
                            </div>
                        </div>

                         

                        <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="Archivo CER" value=""> 
                                    </div>
                                </div> 
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                    <div class="form-group form-floating"> 
                                        <input type="text"  readonly="readonly" class="form-control" placeholder="Archivo KEY" value=""> 
                                    </div>
                                </div> 
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating">
                                    <h5 class="row" style="text-align: center;" >Deposito de comisiones</h5>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align: center;"> 
                                            <div class="col-6 col-md-6 mt-3 mb-3">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" name="depositoComisiones" id="Radio1" value="-1" disabled="disabled"  >
                                                    <label class="custom-control-label" for="Radio1">Mi banco</label> 
                                                </div> 
                                            </div>
                                            <div class="col-6 col-md-6 mt-3 mt-2 mb-3">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" name="depositoComisiones" id="Radio2" value="1" disabled="disabled" >
                                                    <label class="custom-control-label" for="Radio2">FORELO</label>
                                                </div> 
                                            </div>
                                        </div>
                                    <div class="row alert alert-primary" style="display: none; text-align: center;" id="FORELO"> 
                                        <button class="alert alert-primary">FORELO</button>
                                         
                                    </div>
                                    <div class="row alert alert-primary" style="display: none; text-align: center;" id="CLABE"> 
                                        <button class="alert alert-primary" value="" id="nClabe">CUENTA CLABE</button>
                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="row" >
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"> 
                                <div class="form-group form-floating"> 
                                    <form  method="post" action="<?php echo $PATHRAIZ; ?>/amp/foreloscomisionista/views/detalleCorteDiarioForelo.php" target="_blank">
                                        <input type="hidden" name="nIdUsuarioReporte" id="nIdUsuarioReporte" >
                                        <input type="hidden" name="hsNombreComisionista" id="hsNombreComisionista" >
                                        <input type="hidden" name="hsNombreCadena" id="hsNombreCadena" > 
                                        <input type="hidden" name="hnCuenta" id="hnCuenta" > 
                                        <button type="submit"  class="btn btn-primary btn-block" id="BtnEdocuenta" style="display: none;"  >Consulta Estado de Cuenta</button>
                                    </form>
                                </div>
                            </div> 
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"> 
                                <div class="form-group form-floating"> 
                                    <form method="post" action="<?php echo $PATHRAIZ; ?>/_Contabilidad/movimientos_forelo/index.php" target="_blank">
                                        <input type="hidden" name="hsRazonSocial" id="hsRazonSocial" > 
                                        <input type="hidden" name="hnsCuenta" id="hnsCuenta" >
                                        <input type="hidden" name="hnidCliente" id="hnidCliente" >

                                        <input type="hidden" name="hbCredito" id="hbCredito" >
                                        <input type="hidden" name="hnIdTipoCredito" id="hnIdTipoCredito" >
                                        <button type="submit" class="btn btn-primary btn-block" id="BtnCredito" style="display: none;" >Otorgar Crédito</button>
                                    </form>                                    
                                </div>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"> 
                                <div class="form-group form-floating"> 
                                    
                                        <button type="button"  class="btn btn-primary btn-block" onclick="validarFormReglasOperacion();" >Actualizar</button>
                             
                                </div>
                            </div>  
                        </div>
                    </div> 
                </div>
            </div>
        </div>
</body>
</html>