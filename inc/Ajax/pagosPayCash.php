<?php

include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");


$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch ($tipo) {
    
    case 1: // Seleccion de los cortes.

        $sql = $RBD->query("CALL `redefectiva`.`sp_select_corte_paycash`()");
   
        $datos = array();
        $index = 0;
            while($row = mysqli_fetch_assoc($sql)){
                $datos[$index]["corte"] = $row["nIdCorte"];       
                $datos[$index]["monto"] = $row["nTotalPago"];
                $datos[$index]["fecha"] = $row["dFecha"];
                $datos[$index]["estatus"]= $row["nIdEstatus"];
                $datos[$index]["detalle"]= $row["sDetalle"];
                $datos[$index]["movimiento"]= $row["nIdMovimiento"];
                $datos[$index]["operaciones"]= $row["nTotalOperaciones"];
                $index++;
            }   
        print json_encode($datos);

    break;

    case 2:  // busqueda y apertura del archivo de conciliacion de paycash

            $montoCorte  =+ (!empty($_POST["monto"]))? $_POST["monto"] : 0;
            $corte  =+ (!empty($_POST["corte"]))? $_POST["corte"] : 0;
            $fechaArchivo  = (!empty($_POST["fecha"]))? $_POST["fecha"] : 0;
            $fechaCorte = $fechaArchivo;

            $fechaArchivo = str_replace("-", "", $fechaArchivo);

            $localFolder = $_SERVER['DOCUMENT_ROOT'].'/STORAGE/PayCash/Corte/';

            $local_file = $localFolder.$fechaArchivo.'_PAYCASH_RED EFECTIVA_.csv';
            $error = 0 ;
            $fila = 1;
            $contador = 0;
            $montoArchivo =0;
            if(($archivo = fopen($local_file, "r")) !== FALSE){ // lectura del archivo.
            
                while(($datos = fgetcsv($archivo, 1000, ",")) !== FALSE) {       

                    if($contador == 1 && $fila >= 2){

                        $folio = $datos[0];
                        $fecha = $datos[2];  

                        $fecha = str_replace("/", "", $fecha);
                        $fecha =  str_pad($fecha, 8, "0", STR_PAD_LEFT);
                        $anio = substr($fecha, 4);
                        $mes =  substr($fecha, 0 , 2);
                        $dia =  substr($fecha, 2,2);
                        $fecha = $anio."-".$mes."-".$dia;
                        $hora = $datos[3];
                        $cadena = $datos[4];
                        $monto = $datos[7];
                        $monto = $monto/100;
                        $comision = $datos[8];
                        $comision = $comision/100;
                        $autorizacion = $datos[9];

                        $montoArchivo = $montoArchivo + $monto;
                        $referencia = $datos[6];


                        // Insercion de los registros del archivo para su conciliacion.

                        $sql = $WBD->query("CALL `redefectiva`.`sp_insert_conciliacion`('$folio','$monto',
                        '$comision','$referencia','$autorizacion','$fecha','$hora')"); 


                        if(!$WBD->error()){
                
                            $registros++;

                        }else{
                            echo json_encode(array(
                                "showMessage"   => 1,
                                "msg"           => "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
                                "errmsg"        => $WBD->error()
                            ));
                        }
                    }

                    $numero = count($datos);
                    //echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
                    $fila++;
                    for ($c=0; $c < $numero; $c++) {
                    //Se omite la primer linea del documento.
                        if($c == ($numero -1)){
                            $contador = 1;
                        }
                    }
                }   
                fclose ($archivo); // se cierra el archivo.
            }else{
                $error = 1;
            }
        // cerrar la conexión ftp. 
        ftp_close($conn_id);

        $fila = $fila-2;
        if($montoArchivo == $montoCorte){// Si el monto de los cortes coincide la conciliacion es automatica.

            $conciliacion = 0;
            $sql = $WBD->query("CALL `redefectiva`.`sp_update_corte`('$corte','$fechaCorte')");
 

        }else{ // se insertan las operaciones que tienen diferencias en cuanto a montos o que no existan en alguna entidad(PayCash o Red Efectiva).

            $conciliacion = 1;
            $sql = $WBD->query("CALL `redefectiva`.`sp_insert_no_conciliadas`('$corte','$fechaCorte')");


            while($row = mysqli_fetch_assoc($sql)){
                $noconciliados = $row["noconciliados"];       
                $conciliados = $row["conciliados"];
            } 

        }

        echo json_encode(array(
            "showMessage"   => 0,
            "error"         => $error,
            "conciliacion"  => $conciliacion,
            "operaciones"   => $fila,
            "monto"         => $montoArchivo,
            "noConciliados" => $noconciliados,
            "conciliados"   => $conciliados
        ));


    break;

    case 3:  // Actualizacion del cote conciliado con un movimiento del banco.

        $corte = (!empty($_POST["corte"]))? $_POST["corte"] : 0;
        $movimiento = (!empty($_POST["movimiento"]))? $_POST["movimiento"] : 0;    
        $nIdUsuario = $_SESSION['idU'];

        $sql = $WBD->query("CALL `redefectiva`.`sp_update_movimiento_conciliacion`('$corte','$movimiento','$nIdUsuario')");            

        

        if(!$WBD->error()){
            echo json_encode(array(
                "showMessage"   => 0,
                "msg"           => "Actualizacion realizada con exito"
            ));
        }else{
            echo json_encode(array(
                "showMessage"   => 1,
                "msg"           => "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
                "errmsg"        => $WBD->error()
            ));
        }   
    

    break;

    case 4:  // Detallado del corte cuentas y montos a los que se les abono el forelo.

        $fecha = (!empty($_POST["fecha"]))? $_POST["fecha"] : 0;        

         $sql = $RBD->query("CALL `redefectiva`.`sp_select_corte_detalles`('$fecha')");

    
        $datos = array();

        $index = 0;
            while($row = mysqli_fetch_assoc($sql)){
                $datos[$index]["folio"] = $row["nIdFolio"];
                $datos[$index]["monto"]= $row["nMonto"];
                $datos[$index]["movimiento"] = $row["nIdMovimiento"];
                $datos[$index]["cuenta"] = $row["sNumCuenta"];
                $datos[$index]["subcadena"] = $row["nombreSubCadena"];
                $datos[$index]["cadena"]= $row["nombreCadena"];
                $datos[$index]["inicial"] = $row["saldoInicial"];
                $datos[$index]["final"] = $row["saldoFinal"];
                $index++;
            }   

        print json_encode($datos);

    break;
    
    case 5:     // Seleccion de los movimientos no conciliados.

         $corte = (!empty($_POST["corte"]))? $_POST["corte"] : 0;

         $sql = $RBD->query("CALL `redefectiva`.`sp_select_no_conciliadas`('$corte')");

    
        $datos = array();

        $index = 0;
            while($row = mysqli_fetch_assoc($sql)){
                $datos[$index]["folio"] = $row["nIdFolio"];
                $datos[$index]["monto"]= $row["nMonto"];
                $datos[$index]["referencia"] = $row["sReferencia"];
                $datos[$index]["fecha"] = $row["dFecha"];
                $datos[$index]["hora"]= $row["dHora"];
                $index++;
            }   

        print json_encode($datos);
    break;


    case 6: // Liberacion del corte para espera de deposito del banco para poder conciliarlo.

        $corte = (!empty($_POST["corte"]))? $_POST["corte"] : 0;
        $fecha = (!empty($_POST["fecha"]))? $_POST["fecha"] : 0;
        $detalle = (!empty($_POST["detalle"]))? $_POST["detalle"] : 0;
        $pago = (!empty($_POST["pago"]))? $_POST["pago"] : 0;

        $sql = $WBD->query("CALL `redefectiva`.`sp_update_corte_paycash`('$fecha','$corte','$detalle','$pago')");

        if(!$WBD->error()){
            echo json_encode(array(
                "showMessage"   => 0,
                "msg"           => "Actualizacion realizada con exito"
            ));
        }else{
            echo json_encode(array(
                "showMessage"   => 1,
                "msg"           => "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
                "errmsg"        => $WBD->error()
            ));
        }   

    break;


     case 7:    // Generacion del archivo txt de elementos no conciliados.



        $corte = (!empty($_POST["corte"]))? $_POST["corte"] : 0;
        $fecha = (!empty($_POST["fecha"]))? $_POST["fecha"] : 0;

        


    $sql = "CALL `redefectiva`.`sp_select_no_conciliadas`('$corte')";

    $res = $RBD->SP($sql);
    
    $rows = array();

    $index = 0;
    while($row = mysqli_fetch_assoc($res)){
        
        $anio = substr($fecha, 0 , -6);
        $mes =  substr($fecha, 5 , -3);
        $dia =  substr($fecha, 8 );
        $fechaArchivo = $anio.$mes.$dia;

        $nombreArchivo = $fechaArchivo."_PayCash_Diferencias.txt";
        $base = $_SERVER['DOCUMENT_ROOT'];
        if($index == 0){
            unlink("$base/STORAGE/PayCash/Diferencias/$nombreArchivo");
        }
        $ar=fopen("$base/STORAGE/PayCash/Diferencias/$nombreArchivo","a") or
        die("Problemas en la creacion");
        if($index == 0 ){
        fputs($ar,"Folio");
        fputs($ar,",");
        fputs($ar,"Monto");
        fputs($ar,",");
        fputs($ar,"Referencia");
        fputs($ar,",");
        fputs($ar,"Fecha");
        fputs($ar,",");
        fputs($ar,"Hora");    
        fputs($ar,chr(13).chr(10));
        }
        fputs($ar,$row["nIdFolio"]);
        fputs($ar,",");
        fputs($ar,$row["nMonto"]);
        fputs($ar,",");
        fputs($ar,$row["sReferencia"]);
        fputs($ar,",");
        fputs($ar,$row["dFecha"]);
        fputs($ar,",");
        fputs($ar,$row["dHora"]);
        fputs($ar,chr(13).chr(10));
        fclose($ar);
        $index ++;
    
    }

        $pathArchivo = "$base/STORAGE/PayCash/Diferencias/$nombreArchivo";
        header("Content-disposition: attachment; filename=$nombreArchivo");
        header("Content-type: MIME");
        readfile("$pathArchivo");
    break;


    case 8: // Seleccion de los movimientos bancarios segun los parametros solicitados.

        $movimientos = array();
        $inicial    = (isset($_POST['inicial']))?$_POST['inicial'] : -2;
        $final  = (isset($_POST['final']))?$_POST['final'] : -2;
        $id = (isset($_POST['id']))?$_POST['id'] : -2;
        $cuenta = (isset($_POST['cuenta']))?$_POST['cuenta'] : -2;
        $estatus = 1;
        $autorizacion = "";
        $fechaFiltro = 2;
        $perfil = 1;
        $sql = $RBD->query("CALL `redefectiva`.`SP_SELECT_BANCOMOVS`('$id','$cuenta','$autorizacion','$inicial','$final','$estatus','$fechaFiltro','$perfil')");

        $index = 0;
        while($row = mysqli_fetch_assoc($sql)){
            $movimientos[$index]["fecha"] = $row["fecBanco"];
            $movimientos[$index]["referencia"] = $row["referencia"];
            $movimientos[$index]["importe"] = $row["importe"];
            $movimientos[$index]["id"] = $row["idMovBanco"];
            $index++;
        }

        print json_encode($movimientos);

        break;


        case 9:    // seleccion de las cuentas de banco para realizar la busqueda de movimientos para conciliar los cortes.

            $sql = $RBD->query("call redefectiva.SP_SELECT_CFGCUENTA('0','0','','','2','1','0','','0','100','0','ASC')");

            $index = 0;
            while ($row = mysqli_fetch_assoc($sql)) {
                
                $cuentas[$index]["nombre"] = $row["sNombreBanco"];
                $cuentas[$index]["cuenta"] = $row["nNumCuentaBancaria"];
                $cuentas[$index]["bancoId"] = $row["nIdBanco"];
                $index++;
            }
            print json_encode($cuentas);

        break;


}

?>