<?php

include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");


$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;

switch ($tipo) {
    
    case 1:

        $fechaInicio  = (!empty($_POST["fecha1"]))? $_POST["fecha1"] : 0;
        $fechaFin     = (!empty($_POST["fecha2"]))? $_POST["fecha2"] : 0;
        $estatus      =+ (!empty($_POST["estatus"]))? $_POST["estatus"] : 0;

        $sql = $MRDB->query("CALL `pronosticos`.`sp_select_retiros`('$fechaInicio','$fechaFin','$estatus')");
   
        $datos = array();
        $index = 0;

            while($row = mysqli_fetch_assoc($sql)){
                $datos[$index]["nombre"] = utf8_encode($row["sNombre"]);
                $datos[$index]["correo"] = $row["sCorreo"];       
                $datos[$index]["telefono"] = $row["sTelefono"];
                $datos[$index]["importe"] = $row["nImporte"];
                $datos[$index]["clabe"] = $row["sClabe"];
                $datos[$index]["fecha"] = $row["dFechaRetiro"];
                $datos[$index]["estatus"] = $row["nIdEstatus"];
                $datos[$index]["registro"] = $row["nIdRegistro"];
                $index++;
            }

        print json_encode($datos);

    break;


    case 2:


        $id      =+ (!empty($_POST["id"]))? $_POST["id"] : 0;

        $estatus = 0;
        $estatusMS = 2;

        $fecha = date('c');
        
        $sql = $MWDB->query("CALL `pronosticos`.`sp_update_retiro`('$id','$estatus','0')");
    

        if(!$MWDB->error()){
                
            $webService = 'https://www.misuerteweb.com/WSMiSuerte/misuerteservice.asmx?WSDL';
  
            $arrayParametros = array(
                
                'Request' => array(

                    'Id'      => '1',
                    'ChainId' => '1',
                    'StoreId' => '1',
                    'TransactionId'  => '1',
                    'Token' => '',
                    'Host' => '5001',
                    'UserId' => '1',


                    'Retiro' => array(

                        'Status' => $estatusMS,
                        'IdRegistro' => $id,
                        'ErrorStatus' => 0,
                        'Importe' => 0,
                        'Nombre' => '',
                        'Clabe' => '',
                        'Correo' => '',
                        'Telefono'  => ''

                    )
                )
            );

            //Conexion con el webservice
            $client = new SoapClient($webService); 
            $result = $client->RetiroMiSuerte($arrayParametros);
            $array = array($result);

            //captura de codigo de error
            $error =+ $array[0]->ErrorCode;


            if($error == 0 ){

                $codigoError = 0;

                 echo json_encode(array(
                    
                    "showMessage"   => $codigoError,
                    "msg"           => "Actualizacion Exitosa"

                ));

            }else{

                $codigoError = 1;

                $sql = $MWDB->query("CALL `pronosticos`.`sp_update_retiro`('$id','$estatus','$codigoError')");

                if(!$MWDB->error()){
                
                    echo json_encode(array(
                    
                        "showMessage"   => $codigoError,
                        "msg"           => "Actualizacion exitosa,error al actualiza en el portal"

                ));

                }else{

                    echo json_encode(array(
                        "showMessage"   => 1,
                        "msg"           => "Ha ocurrido un Error, Intentelo de Nuevo Mas Tarde",
                        "errmsg"        => $MWDB->error()
                    ));

                }

            }

        }else{

            echo json_encode(array(
                "showMessage"   => 1,
                "msg"           => "Ha ocurrido un Error, Intentelo de Nuevo Mas Tarde",
                "errmsg"        => $MWDB->error()
            ));
        }  

    break;


  


}
?>