<?php

#error_reporting(E_ALL);
#ini_set("display_errors", 1);

include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");
include "../../inc/PhpExcel/Classes/PhpExcel.php";


$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch ($tipo) {
    
    case 1:

        $fechaInicio  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fechaFin     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;
        $proveedor    = 1;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_load_corte_proveedor`('$fechaInicio','$fechaFin','$proveedor')");
   
        $datos = array();
        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){
                
                $datos[$index]["proveedor"] = $row["sNombreComercial"];
                $datos[$index]["operaciones"] = $row["operaciones"];
                $datos[$index]["monto"] = $row["monto"];
                $datos[$index]["comision"] = $row["comision"];
                $datos[$index]["archivo"] = $row["archivo"];
                $datos[$index]["premios"] = $row["premios"];
                $datos[$index]["corte"] = $row["nIdCorte"];
                $datos[$index]["estatus"] =+ $row["estatus"];
                $datos[$index]["cliente"] =+ $row["nIdCliente"];
                $index++;
            }   
        print json_encode($datos);

    break;

    case 2:

        // Carga la informacion del corte seleccionado

        $fechaInicio  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fechaFin     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_load_corte`('$fechaInicio','$fechaFin')");
    
        $datos = array();

        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){

                $datos[$index]["monto"] = $row["monto"];
                $datos[$index]["operaciones"] = $row["operaciones"];
                $datos[$index]["fecha"] = $row["fecha"];
                $datos[$index]["nombre"]= $row["nombre"];
                $datos[$index]["metodo"]=+ $row["metodo"];
                $index++;

            }

        print json_encode($datos);


    break;

    case 3:

        // Se carga la configuracion del proveedor credenciales de acceso hacia su servidor ftp

        $proveedor = (!empty($_POST["proveedor"]))? $_POST["proveedor"] : 0;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_load_proveedor_conf`($proveedor)");
    
        $datos = array();

        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){
                $datos[$index]["host"] = $row["sHost"];
                $datos[$index]["user"] = $row["sUser"];
                $datos[$index]["pass"] = $row["sPass"];
                $datos[$index]["localFolder"]= $row["sLocalFolder"];
                $datos[$index]["remoteFolder"]= $row["sRemoteFolder"];
                $datos[$index]["pagoComisiones"]= $row["nDiasPagoComisiones"];
                $index++;
            }   

        print json_encode($datos);

    break;


     case 4:

        $fechaInicio  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fechaFin     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;
        $estatus      =+ (!empty($_POST["estatus"]))? $_POST["estatus"] : 0;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_select_cortes_proveedor`('$fechaInicio','$fechaFin','$estatus')");
   
        $datos = array();
        $index = 0;
            while($row = mysqli_fetch_assoc($sql)){
                $datos[$index]["corte"] = $row["nIdCorte"];
                $datos[$index]["clienteId"] = $row["nIdCliente"];       
                $datos[$index]["proveedor"] = $row["sNombreComercial"];
                $datos[$index]["proveedorId"] = $row["nIdProveedor"];
                $datos[$index]["fechaCorte"] = $row["dFecAlta"];
                $datos[$index]["fechaInicio"] = $row["dFechaInicio"];
                $datos[$index]["fechaFinal"] = $row["dFechaFinal"];
                $datos[$index]["fechaPago"]= $row["dFechaPago"];
                $datos[$index]["monto"]= $row["nTotalPago"];
                $datos[$index]["estatus"]= $row["nIdEstatus"];
                $datos[$index]["conciliacion"]=+ $row["nResultadoConciliacion"];
                $datos[$index]["color"]= $row["sColor"];
                $index++;
            }   
        print json_encode($datos);

    break;



    case 6:

        $corte = (!empty($_POST["corte"]))? $_POST["corte"] : 0;
        $fecha = (!empty($_POST["fecha"]))? $_POST["fecha"] : 0;
        $detalle = (!empty($_POST["detalle"]))? $_POST["detalle"] : 0;
        $proveedor = (!empty($_POST["proveedor"]))? $_POST["proveedor"] : 0;
        $pago = (!empty($_POST["pago"]))? $_POST["pago"] : 0;

        $sql = $MWDB->query("CALL `pronosticos`.`sp_actualiza_corte`('$proveedor','$fecha','$corte','$detalle','$pago')");

        if(!$MWDB->error()){
            echo json_encode(array(
                "showMessage"   => 0,
                "msg"           => "Actualizacion realizada con exito"
            ));
        }else{
            echo json_encode(array(
                "showMessage"   => 1,
                "msg"           => "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
                "errmsg"        => $MWDB->error()
            ));
        }   

    break;


     case 7:

        $sql = $MRDB->query("CALL `pronosticos`.`sp_load_indicadores`()");
   
        $datos = array();
        $index = 0;
            while($row = mysqli_fetch_assoc($sql)){
        
                $datos[$index]["indicador"]= $row["sNombre"];
                $datos[$index]["clase"]= $row["sClase"];
                $datos[$index]["color"]= $row["sColor"];
                $datos[$index]["estatus"] =+ $row["nIdEstatus"];
                $index++;
            }   
        print json_encode($datos);

    break;




    case 8:

        $fechaInicio  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fechaFin     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;

        $sArchivo = !empty($_FILES['fileToUpload'])? $_FILES['fileToUpload'] : null;


        $oExcelFileReader = new ExcelFileReader();
        $oExcelFileReader->set_file($sArchivo);
        $arrRes = $oExcelFileReader->initReader();



        if($arrRes['bExito'] == false){
            echo json_encode($arrRes); exit();
        }

        $oExcelFileReader->loadDataSets();

        $data    = $oExcelFileReader->getArrayDataSets();
        $nTotal =+ $oExcelFileReader->getNTotalDataSets();

        $fecha1P = $data[$nTotal-1][0];
        $fecha2P = $data[3][0];


         function validaFechas($fechaInicio,$fechaFin,$fecha1P,$fecha2P){

        if($fechaInicio == $fecha1P && $fechaFin == $fecha2P){  
            return true;
        }else{
            return false;
        }
    }


        $validacion = validaFechas($fechaInicio,$fechaFin,$fecha1P,$fecha2P);

   



    $total = 0;
    $monto = 0;

    if($validacion){
        for($i=3;$i<=$nTotal;$i++){

            $informacion = $data[$i];
        
            $monto = $informacion[3];
            $estado = $informacion[8];
            $referencia = $informacion[9];


            if($estado == "aprobado" && $referencia == ""){

                $total =+ $total + $monto;
            }
        }

        $code = 0;
        $msg = "Monto Total del archivo de Sr Pago : $ ";

    }else{

    $total = "";
    $msg = "Las fechas del reporte no coinciden con las seleccionadas";
    $code = 1;

    }

    echo json_encode(array(
            "monto"             => $total,
            "nCodigo"           => $code,
            "bExito"            => true,
            "sMensaje"          => $msg
    ));

    break;


    case 9:

        $corte      = (!empty($_POST["corte"]))? $_POST["corte"] : 0;
        $monto      = (!empty($_POST["pago"]))? $_POST["pago"] : 0;
        $comentario = (!empty($_POST["comentario"]))? $_POST["comentario"] : 0;
        $diferencia = (!empty($_POST["diferencia"]))? $_POST["diferencia"] : 0;
        $pagoTotal  = (!empty($_POST["pagoTotal"]))? $_POST["pagoTotal"] : 0;
        $entidad    = (!empty($_POST["entidad"]))? $_POST["entidad"] : 0;
        $id         = $_SESSION["idU"];


        $sql = $MWDB->query("CALL `pronosticos`.`sp_actualiza_conciliacion`('$corte','$monto','$comentario','$id','$diferencia','$pagoTotal','$entidad')");

        if(!$MWDB->error()){
            echo json_encode(array(
                "showMessage"   => 0,
                "msg"           => "Actualizacion realizada con exito"
            ));
        }else{
            echo json_encode(array(
                "showMessage"   => 1,
                "msg"           => "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
                "errmsg"        => $MWDB->error()
            ));
        }   


    break;


    case 10:

        $fecha1  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fecha2     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;
        $cliente     = (!empty($_POST["cliente"]))? $_POST["cliente"] : 0;
        $id = $_SESSION["idU"];


        $sql = $MWDB->query("CALL `pronosticos`.`sp_insert_corte_proveedor`('$fecha1','$fecha2','$cliente','$id')");



        if(!$MWDB->error()){

            while($row = mysqli_fetch_assoc($sql)){
        
                $codigo= $row["codigo"];
                
                $msg  = $row["msg"];
                
            }   

            echo json_encode(array(
                "showMessage"   => $codigo,
                "msg"           => $msg
            ));
        }else{

            echo json_encode(array(
                "showMessage"   => 1,
                "msg"           => "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
                "errmsg"        => $MWDB->error()
            ));
        }   


    break;


    case 11:

        $fechaInicio  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fechaFin     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;
        $proveedor    = 1;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_select_corte_detalles`('$fechaInicio','$fechaFin','$proveedor')");
   
        $datos = array();
        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){
                
                $datos[$index]["proveedor"] = $row["sNombreComercial"];
                $datos[$index]["operaciones"] = $row["operaciones"];
                $datos[$index]["monto"] = $row["monto"];
                $datos[$index]["comision"] = $row["comision"];
                $datos[$index]["archivo"] = $row["archivo"];
                $datos[$index]["premios"] = $row["premios"];
                $datos[$index]["corte"] = $row["nIdCorte"];
                $datos[$index]["estatus"] =+ $row["estatus"];
                $datos[$index]["cliente"] =+ $row["nIdCliente"];
                $datos[$index]["fecha"] = $row["dFechaCorte"];
                $index++;
            }   
        print json_encode($datos);

    break;



 case 5:

         $corte = (!empty($_POST["corte"]))? $_POST["corte"] : 0;
         $fechaInicial  = (!empty($_POST["fechaInicial"]))? $_POST["fechaInicial"] : 0;
         $fechaFinal     = (!empty($_POST["fechaFinal"]))? $_POST["fechaFinal"] : 0;

         $sql = $MRDB->query("CALL `pronosticos`.`sp_load_no_conciliadas`('$fechaInicial','$fechaFinal')");

    
        $datos = array();

        $index = 0;
            while($row = mysqli_fetch_assoc($sql)){
                $datos[$index]["producto"] = $row["sGameName"];
                $datos[$index]["sorteo"] = $row["sSorteo"];       
                $datos[$index]["boleto"] = $row["sBoleto"];
                $datos[$index]["fechaVenta"] = $row["dFechaVenta"];
                $datos[$index]["horaVenta"]= $row["dHoraVenta"];
                $datos[$index]["monto"]= $row["nMonto"];
                $datos[$index]["montoCorte"]= $row["nMontoCorte"];
                $datos[$index]["entidad"]= $row["sEntidad"];
                $datos[$index]["juego"]= $row["juego"];
                $index++;
            }   
        print json_encode($datos);
    break;



}

?>



