<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");     

        $fechaCorte =(!empty($_POST["fecha"]))? $_POST["fecha"]: 0;
        $fechaInicial =(!empty($_POST["fechaInicial"]))? $_POST["fechaInicial"]: 0;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_select_conciliacion`('$fechaInicial','$fechaCorte')");
    


        $datos = array();
        $index = 0;        

        while($row = mysqli_fetch_assoc($sql)){
            
            $datos[$index]["efectivo"]=+ $row["archivo"];
            $datos[$index]["corte"] =+ $row["monto"];
            $datos[$index]["conciliacion"] =+ $row["conciliacion"];
            $datos[$index]["operaciones"] =+ $row["operaciones"];

            $index++;
        }

        print json_encode($datos);







/*
    
           // Se cargan los nombres de los juegos con los cuales identificaremos el archivo a buscar
        $sql = $MRDB->query("CALL `pronosticos`.`sp_load_games`()");
    
        $juegos = array();

        $index = 0;

        while($row = mysqli_fetch_assoc($sql)){
            $juegos[$index]["game"]= $row["gameName"];
            $juegos[$index]["id"] = $row["nIdGame"];
            $index++;
        }

        $cliente = (!empty($_POST["cliente"]))? $_POST["cliente"] : 0;
        $sql = $MRDB->query("CALL `pronosticos`.`sp_load_socio`($cliente)");



        while($row = mysqli_fetch_assoc($sql)){
            $idSocio = $row["nIdSocio"];
        }

        //Se reciben las variables para estableceer la conexion con el ftp para la extraccion de los archivos

        $corteId =(!empty($_POST["corte"]))? $_POST["corte"]: 0;
        $fechaCorte =(!empty($_POST["fecha"]))? $_POST["fecha"]: 0;
        $fechaInicial =(!empty($_POST["fechaInicial"]))? $_POST["fechaInicial"]: 0;
        $ftp_user_name =(!empty($_POST["user"]))? $_POST["user"] : 0;
        $ftp_user_pass =(!empty($_POST["pass"]))? $_POST["pass"] : 0;
        $ftp_server =(!empty($_POST["server"]))? $_POST["server"]: 0;
        $remoteFolder =$_POST["remote"];
        $localFolder =(!empty($_POST["local"]))? $_POST["local"]: 0;
        $proveedor =(!empty($_POST["proveedor"]))? $_POST["proveedor"]: 0;
        $diasComisiones =+(!empty($_POST["diasComisiones"]))? $_POST["diasComisiones"]: 0;

        $indice = 0;
        $archivos = array();
        $archivosE = array();
        $indexError = 0;
        $indexEncontrado = 0;
        $registros = 0;
        $registrosNo = 0;

        $numArchivos = 0;
        
        // Se calcula el intervalo de dias que se deben iterar para la busqueda de archivos en el servidor remoto
            
            $datetime1 = date_create($fechaInicial);
            $datetime2 = date_create($fechaCorte);
            $interval = date_diff($datetime1, $datetime2);
            $interval = $interval->format('%a');

            
        // Empieza el proceso en un ciclo para recorrer las fechas que se deben buscar en el servidor remoto
        while($indice <= $interval){

            //se calculan las fechas con las cuales se buscaran los archivos            
            $nuevaFecha = strtotime ('-'.$indice.'day' , strtotime ( $fechaCorte ) );
            $nuevaFecha = date ( 'Y-m-d' , $nuevaFecha ); 

            $indice++;




        // Asigancion de numero de espacio rellenando espacios a la izquierda para ucmplir estandard en los archivos
            $idSocio =  str_pad($idSocio, 9, "0", STR_PAD_LEFT);


        //  Se descompone la fecha parel armado de la nomenclatura del archivo

            $anio = substr($nuevaFecha, 0 , -6);
            $mes =  substr($nuevaFecha, 5 , -3);
            $dia =  substr($nuevaFecha, 8 );
            $fechaArchivo = $anio.$mes.$dia;

        //echo $fechaArchivo."<br/>";

        // Conteo del numero de juegos existentes para hacer la iteracion por fechas
            $iteracion = count($juegos);
        

        // Se establece la conexion con el servidor del cual se extraira la informacion 
            $conn_id = ftp_connect($ftp_server); 

        // Se ingresan las credenciales de acceso traidas de base de datos 
            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

        // Se verifica la conexion hacia el servidor
        if((!$conn_id) || (!$login_result)) {  
           $messageError = "No se realizo conexi&oacute;n con el servidor"; 
           echo json_encode(array(
                "showMessage" => 1,
                "msg" => $messageError,
                "conciliacion" => 0
            ));
           exit; 
        }else{
           $messageError = "Conexi&oacute;n a $ftp_server realizada con &Eacute;xito, por el usuario $ftp_user_name\n";
        }

          
        // Se inicia la descarga de los archivos ingresando a otro ciclo
    
        for($i=0;$i<$iteracion;$i++){
            
            // Se asigna el nombre que llevara el archivo al descargarse y su extension asi como el path donde se guardara
            $local_file = $localFolder.'ventas_'.$juegos[$i]["game"].'_'.$idSocio.'_'.$fechaArchivo.'.csv';
            
            // Path de servidor externo de donde se extraera la informacion
            $server_file = $remoteFolder.'ventas_'.$juegos[$i]["game"].'_'.$idSocio.'_'.$fechaArchivo.'.txt'; 
            
            
            // Se valida si la descarga a sido exitosa 
            unlink($local_file);
            if(ftp_get($conn_id, $local_file, $server_file, FTP_ASCII)){
                $errorArchivo =+ 0;
                $numArchivos = $numArchivos + 1;
                $archivosE[$indexEncontrado]['archivo'] = $juegos[$i]["game"];
                $archivosE[$indexEncontrado]['fecha'] = $nuevaFecha;
                $fileMessage = "Se ha guardado satisfactoriamente en $local_file\n";
                $indexEncontrado++;
            }else{

                $errorArchivo =+ 1;
                $archivos[$indexError]['archivo'] =  $juegos[$i]["game"];
                $archivos[$indexError]['fecha'] =  $nuevaFecha;
                $fileMessage = "Ha habido un problema\n";
                $indexError++;

            }
        }
          
        if($indexError == $iteracion){
            $errorArchivo = 404;
        }

        
        // Se comienza la lectura del archivo y su guardado en la base de datos
        for($i=0;$i<$iteracion;$i++){

            $local_file = $localFolder.'Ventas_'.$juegos[$i]["game"].'_'.$idSocio.'_'.$fechaArchivo.'.csv';
            $fila = 1;
            $contador = 0;
            if(($archivo = fopen($local_file, "r")) !== FALSE){ 
            
                while(($datos = fgetcsv($archivo, 1000, ",")) !== FALSE) {       

                    if($contador == 1 && $fila >= 2){

                        $seccion = $datos[0];
                        $producto = $datos[1];
                        $sorteo=  $datos[2];
                        $agencia = $datos[3];
                        $cadena = $datos[4];
                        $tienda = $datos[5];
                        $terminal = $datos[6];
                        $transaccion = $datos[7];
                        // Se valida la fecha contenida aqui
                        if($transaccion == 2){
                            $fechaCancelacion = $datos[10];
                        }else{
                            $fechaCancelacion = '0000-00-00';
                        }

                        $fechaVenta = $datos[8];                        
                        $anio = substr($fechaVenta, 6);
                        $mes =  substr($fechaVenta, 3 , -5);
                        $dia =  substr($fechaVenta, 0,  -8);
                        $fechaVenta = $anio."-".$mes."-".$dia;

                        $horaVenta = $datos[9];
                        $horaCancelacion = $datos[11];
                        $boleto = $datos[12];
                        $serie = $datos[13];
                        $monto = $datos[14]/100;
                        $tipoPago = $datos[15];
                        $flagmatico = $datos[16];

                        //guardado de cada una de las lineas del archivo en un registro de la base de datos

                        $sql = $MWDB->query("CALL `pronosticos`.`sp_guarda_conciliacion`('$seccion','$producto',
                        '$sorteo','$agencia','$cadena','$tienda','$terminal','$transaccion','$fechaVenta',
                        '$horaVenta','$fechaCancelacion','$horaCancelacion','$boleto','$serie','$monto','$tipoPago',
                        '$flagmatico','$corteId')");

                        if(!$MWDB->error()){
                
                            $registros++;


                        }else{
                            echo json_encode(array(
                                "showMessage"   => 1,
                                "msg"           => "Ha ocurrido un Error, Intentelo de Nuevo Mas Tarde",
                                "errmsg"        => $MWDB->error()
                            ));
                        }
                    }

                    $numero = count($datos);
                    
                    $fila++;
                    for ($c=0; $c < $numero; $c++) {
                    //Se omite la primer linea del documento ya que solo es el encabezado
                        if($c == ($numero -1)){
                            $contador = 1;
                        }
                    }
                }   
                fclose ($archivo); // se cierra el archivo
            }
        }
        // cerrar la conexiÃ³n ftp 
        ftp_close($conn_id);

    }        

    //Realizar procedimiento que ejecute la conciliacion contra el corte compara el monot del corte contra la suma de los totales de los archivos//

    //Si el numero de archivos es = 0 no se procede a ejecutar ningun procedimiento ya que no hay archivos para conciliar
    if($numArchivos > 0){
        $sql = $MWDB->query("CALL `pronosticos`.`sp_realiza_conciliacion`('$fechaCorte','$corteId','$proveedor')");

        if(!$MWDB->error()){
            $registros = ($registros -2);
            while($row = mysqli_fetch_assoc($sql)){
                
                $errorCode =+ $row["ErrorCode"];
                $mesage = $row["ErrorMsg"];
                $corteConciliacion = $row["monto"];
                $registros =  $row["registros"];
            }

        // Si no hay conciliacion a totales se procede  a la conciliacion manual archivo contra registros de venta 
            if($errorCode == 1){
                 $sql2 = $MWDB->query("CALL `pronosticos`.`sp_guarda_noconciliadas`('$fechaInicial','$fechaCorte','$corteId','$cliente')");

                if(!$MWDB->error()){
                    
                    while($row2 = mysqli_fetch_assoc($sql2)){
                    
                        $registrosNo = $row2["noconciliados"];
                        $conciliados = $row2["conciliados"];
                    }
                }
            }else{
                $conciliados = $registros;       
            }
            if($errorCode == 0){
                $conciliacion = 1;
            }else{
                $conciliacion = 0;
            }

            echo json_encode(array(
                "messageFile" => $fileMessage,
                "cortePronosticos" => $corteConciliacion,
                "archivoError" => $errorArchivo,
                "archivos" => $archivos,
                "archivosE" => $archivosE,
                "registros" => $registros,
                "noconciliados" => $registrosNo,
                "conciliados" => $conciliados,
                "showMessage" => $mesage,
                "conciliacion" => $conciliacion
            ));


        }else{
            echo json_encode(array(
                "showMessage"   => 1,
                "msg"           => "Ha ocurrido un Error, Intentelo de Nuevo Mas Tarde",
                "errmsg"        => $MWDB->error()
            ));
        }

    }else{

             echo json_encode(array(
                "archivoError" => 404
            ));
    }*/






?>