<?php

    $opcion = (!empty($_POST["opcion"]))? $_POST["opcion"] : 0;
   
    switch ($opcion){
        case 1:
            getDatosCliente();
            break;
        case 2:
            getCorresponsalesCliente();
            break;
        case 3:
            getOperadoresCliente();
            break;
        case 4:
            // getProductosCliente();
            break;
        case 5:
            getClienteAMP();
            break;
        case 6:
            getOperadoresClienteAMP();
            break;
        case 7:
            getModalidadCliente();
            break;
        case 8:
            getMapeoClienteAMP();
            break;
        case 9:
            getMapCorresponsalesAgencias();
            break;
        case 10:
            getUsuariosAMP();
            break;
        // case 11:
        //     getDataMigracionRemesas();
        //     break;
        default:
            echo "No se recibio número de opción correctamente";
            break;
    }

    // consulta de informacion de cliente a migrar.
        function getDatosCliente(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

            $idCliente = (!empty($_POST["idCliente"]))? $_POST["idCliente"] : 0;
            $idSubcadena = (!empty($_POST["idSubcadena"]))? $_POST["idSubcadena"] : 0;
            $idCadena = (!empty($_POST["idCadena"]))? $_POST["idCadena"] : 0;

            $array_params_config = array(
                array(
                    'name'  => 'ck_idCliente', 
                    'value' => $idCliente, 
                    'type'  =>'i'
                ),
                array(
                    'name'  => 'ck_idSubCadena', 
                    'value' => $idSubcadena, 
                    'type'  =>'i'
                ),
                array(
                    'name'  => 'ck_idCadena', 
                    'value' => $idCadena, 
                    'type'  =>'i'
                )
            );
            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_cliente_migracion');
            $oRdb->setParams($array_params_config);
            $result = $oRdb->execute();

            $data = array();
            if($result['nCodigo'] == 0){
                $data = $oRdb->fetchAll();
            }

            $data[0]['nombreCliente']       = utf8_encode($data[0]['nombreCliente']);
            $data[0]['apPaternoCliente']    = utf8_encode($data[0]['apPaternoCliente']);
            $data[0]['apMaternoCliente']    = utf8_encode($data[0]['apMaternoCliente']);
            $data[0]['nombreCadena']        = utf8_encode($data[0]['nombreCadena']);
            $data[0]['nombreCorresponsal']  = utf8_encode($data[0]['nombreCorresponsal']);
            
            $siglasNomUsuario = explode(" ",$data[0]['nombreCliente']);
            $siglasPatUsuario = explode(" ",$data[0]['apPaternoCliente']);
            $siglasMatUsuario = explode(" ",$data[0]['apMaternoCliente']);

            $siglasUsuario = '';
            //$siglasUsuario.=$data[0]['idCadena']; // concatena el id de candea al inicio.
            if($siglasNomUsuario == null){
                $siglasUsuario = '';
            }
            else if( count($siglasNomUsuario)>1 ){
                for($i=0; $i<count($siglasNomUsuario); $i++){
                    $siglasUsuario.= substr($siglasNomUsuario[$i],0,1);
                }
            }else{
                $siglasUsuario.= substr($siglasNomUsuario[0],0,1);
            }


            $siglasUsuario.=substr($siglasPatUsuario[0],0,1).substr($siglasMatUsuario[0],0,1);


            if(  strlen( trim($siglasUsuario) ) == 0  ){
                $siglasUsuario = '';
            }else{
                $siglasUsuario = substr($siglasUsuario,-5);
            }

            // regla para Razon social cuando el valor venga vacío:
            // si es persona moral, se toma el valor del nombre de subcadena
            // si es persona fisica ó no fiscalizado, tomar el valor del nombre de la persona.

            $data['usuario'] = strtoupper( trim($siglasUsuario) );
            $data['contrasena'] = '12345';
            $data['razonSocial'] = utf8_encode($data[0]['razonSocialCliente']);
            $data['telefono']= str_replace("-","",$data[0]['telefonoCliente']);
            $data['telefono'] = substr($data['telefono'],-10);
            
            echo json_encode($data);
        }
    // ********************************************

    // consulta de informacion de corresponsales a migrar.
        function getCorresponsalesCliente(){
            // *** Obtener los correponsales mapeados con agencias de nautilus 
            // *** tabla: nautilus.conf_acceso_agencia
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

            $data = array();
            $idCliente = (!empty($_POST["idCliente"]))? $_POST["idCliente"] : 0;
            $flagMigRE = (!empty($_POST['flagMigRE']))? $_POST["flagMigRE"] : 0;

            $array_params = array(
                array(
                    'name'  => 'ck_nIdCliente', 
                    'value' => $idCliente, 
                    'type'  =>'i'
                )
            );

            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_corresponsales_by_idCliente');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $data = array();
            if($result['nCodigo'] == 0){
                $data = $oRdb->fetchAll();



                for($i=0; $i<count($data); $i++){
                    $data[$i]['nombreCorresponsal'] = utf8_encode($data[$i]['nombreCorresponsal']);
                    $data[$i]['nombreSucursal'] = utf8_encode($data[$i]['nombreSucursal']);
                    $data[$i]['nombreCadena'] = utf8_encode($data[$i]['nombreCadena']);
                }
            }
            
            // *** solo cuando es migracion complementaria de RE ***
                if($flagMigRE == 1)
                {
                    $dataB = null;
                    for($i=0; $i<count($data); $i++){
                        $dataB[] = array(
                            'nombreCorresponsal'    => utf8_encode($data[$i]['nombreCorresponsal']),
                            'nombreSucursal'        => utf8_encode($data[$i]['nombreSucursal']),
                            'idcColonia'            => $data[$i]['idcColonia'],
                            'calleDireccion'        => $data[$i]['calleDireccion'],
                            'numeroIntDireccion'    => $data[$i]['numeroIntDireccion'],
                            'numeroExtDireccion'    => $data[$i]['numeroExtDireccion'],
                            'nombreCadena'          => utf8_encode($data[$i]['nombreCadena']),
                            'foreloIndividual'      => $data[$i]['foreloIndividual'],
                            'idCorresponsal'        => $data[$i]['idCorresponsal']
                        );
                    }
                    $data = null;
                    $data = $dataB;
                }
                if($flagMigRE == 2) // registro activacion de accesos 
                {
                    $dataB = null;
                    for($i=0; $i<count($data); $i++)
                    {
                        $dataB[] = array(
                            'idCorresponsal' => $data[$i]['idCorresponsal']
                        );
                    }
                    $data = null;
                    $data = $dataB;
                }
            // *****************************************************
            
            echo json_encode($data);
        }
    // ********************************************

    // consulta de informacion de corresponsales a migrar.
        function getOperadoresCliente(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

            $data = array();
            $idCliente = (!empty($_POST["idCliente"]))? $_POST["idCliente"] : 0;

            $array_params = array(
                array(
                    'name'  => 'ck_nIdCliente', 
                    'value' => $idCliente, 
                    'type'  =>'i'
                )
            );

            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_operadores_by_idCliente');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $data = array();
            if($result['nCodigo'] == 0){
                $data = $oRdb->fetchAll();
            }
            
            echo json_encode($data);
        }
    // ********************************************

    // consulta de informacion de corresponsales a migrar.
        /*function getProductosCliente(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

            $data = array();
            $idCadenaRE = (!empty($_POST["idCadenaRE"]))? $_POST["idCadenaRE"] : 0;
            $idSubCadenaRE = (!empty($_POST["idSubCadenaRE"]))? $_POST["idSubCadenaRE"] : 0;

            $array_params = array(
                array(
                    'name'  => 'Ck_idCadena', 
                    'value' => $idCadenaRE, 
                    'type'  =>'i'
                ),
                array(
                    'name'  => 'Ck_idSubCadena', 
                    'value' => $idSubCadenaRE, 
                    'type'  =>'i'
                )
                // array(
                //     'name'  => 'Ck_idCorresponsal', 
                //     'value' => $, 
                //     'type'  =>'i'
                // ),
            );
            
            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_productos_migracion');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $data = array();
            if($result['nCodigo'] == 0){
                $data = $oRdb->fetchAll();
            }
            
            echo json_encode($data);
        }*/
    // ********************************************

    // consulta de informacion de cliente migrado.
        function getClienteAMP(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $idSubcadena = (!empty($_POST["idSubCadena"]))? $_POST["idSubCadena"] : 0;
            $numCuenta = (!empty($_POST["numCuenta"]))? $_POST["numCuenta"] : 0;
            $data = array();

            // $array_params = array(
            //     array(
            //         'name'  => 'ck_idSubCadena', 
            //         'value' => $idSubcadena, 
            //         'type'  =>'i'
            //     ),
            //     array(
            //         'name'  => 'ck_nNumCuenta', 
            //         'value' => $numCuenta, 
            //         'type'  =>'i'
            //     )
            // );

            // $oRAMP->setSDatabase('aquimispagos');
            // $oRAMP->setSStoredProcedure('sp_select_cliente_migrado_RE');
            // $oRAMP->setParams($array_params);
            // $result = $oRAMP->execute();

            // if($result['nCodigo'] == 0){
            //     $data = $oRAMP->fetchAll();
            // }

            // *** WS ***
            $array_params= array(
                'idSubCadena' => $idSubcadena,
                'numCuenta' => $numCuenta
            );

            $respuesta = null;
            $respuesta =(array) $client->ObtenerClienteAMP($array_params);  // OK

            if($respuesta['ObtenerClienteAMPResult']->ErrorCode == 0){
                $data[] = $respuesta['ObtenerClienteAMPResult']->Model->anyType->enc_value;
            }
            
            echo json_encode($data);
        }
    // ********************************************

    // consulta de informacion de operadores migrados.
        function getOperadoresClienteAMP(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 
            
            $idCadenaAMP = (!empty($_POST["idCadenaAMP"]))? $_POST["idCadenaAMP"] : 0;
            
            // $array_params = array(
            //     array(
            //         'name'  => 'ck_idCadenaAMP', 
            //         'value' => $idCadenaAMP, 
            //         'type'  =>'i'
            //     )
            // );

            // $oRAMP->setSDatabase('aquimispagos');
            // $oRAMP->setSStoredProcedure('sp_select_operadores_migrados_RE');
            // $oRAMP->setParams($array_params);
            // $result = $oRAMP->execute();

            // $data = array();
            // if($result['nCodigo'] == 0){
            //     $data = $oRAMP->fetchAll();
            // }

            // *** WS ***
                $array_params= array(
                    'idCadenaAMP' => $idCadenaAMP
                );

                $respuesta = null;
                $respuesta =(array) $client->ObtenerOperadores($array_params);  // OK

                if($respuesta['ObtenerOperadoresResult']->ErrorCode == 0){
                    
                    if(isset($respuesta['ObtenerOperadoresResult']->Model->anyType->enc_value)){
                        $data[] = $respuesta['ObtenerOperadoresResult']->Model->anyType->enc_value;
                    }
                    else{
                        for($i=0; $i<count($respuesta['ObtenerOperadoresResult']->Model->anyType); $i++){
                            $data[] = $respuesta['ObtenerOperadoresResult']->Model->anyType[$i]->enc_value;
                        }
                    }
                }
            // *** *** ***
            
            echo json_encode($data);
        }
    // ********************************************

    // consulta de informacion de modalidad de cliente. Revisa si tiene configuracion servicios y remesas.
        function getModalidadCliente(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 
            
            $nIdSubCadenaRE = (!empty($_POST["nIdSubCadenaRE"]))? $_POST["nIdSubCadenaRE"] : 0;
            $nIdAgente = (!empty($_POST["nIdAgente"]))? $_POST["nIdAgente"] : 0;
            
            $array_params = array(
                array(
                    'name'  => 'ck_idSubCadena', 
                    'value' => $nIdSubCadenaRE, 
                    'type'  =>'i'
                ),
                array(
                    'name'  => 'ck_idAgente', 
                    'value' => $nIdAgente,
                    'type'  =>'i'
                )
            );

            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_modalidad_cliente');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $data = array();
            if($result['nCodigo'] == 0){
                $data = $oRdb->fetchAll();
            }
            
            echo json_encode($data);
        }
    // ************************************************
    
    // consulta de informacion de mapeo de cliente.
        function getMapeoClienteAMP(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $idAgente = (!empty($_POST["idAgente"]))? $_POST["idAgente"] : 0;
            $idCorresponsal = (!empty($_POST["idCorresponsal"]))? $_POST["idCorresponsal"] : 0;
            
            // *** WS ***
            $array_params= array(
                'idAgente' => $idAgente,
                'idCorresponsal' => $idCorresponsal
            );

            $respuesta = null;
            $respuesta =(array) $client->getMapeoClienteAMP($array_params);  // OK

            $data = array();
            if( isset($respuesta['getMapeoClienteAMPResult']->ErrorCode) && $respuesta['getMapeoClienteAMPResult']->ErrorCode == 0){
                $data = $respuesta['getMapeoClienteAMPResult']->Model->anyType->enc_value;
            }

            echo json_encode($data);
        }
    // ********************************************

    // consulta de informacion de mapeo de corresponsales y agencias
        function getMapCorresponsalesAgencias(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            //include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            //$idCorresponsales = (!empty($_POST["corresponsales"]))? $_POST["corresponsales"] : 0;
            $idAgente = (!empty($_POST["idAgente"]))? $_POST["idAgente"] : 0;

            $data = array();

            $array_params = array(
                array(
                    'name'  => 'Ck_nIdAgente', 
                    'value' => $idAgente, 
                    'type'  =>'i'
                )
            );

            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_corresponsales_agencias');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            if($result['nCodigo'] == 0){
                $data = $oRdb->fetchAll();
            }
            
            echo json_encode($data);
        }
    // ********************************************

    // consulta de usuarios de AMP
        function getUsuariosAMP(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $idCadenaAMP = (!empty($_POST["idCadenaAMP"]))? $_POST["idCadenaAMP"] : 0;

            $data = array();
            $array_params = null;

            // *** WS ***
            $array_params= array(
                'Ck_nIdCadena' => $idCadenaAMP, 
            );

            $respuesta = null;
            $respuesta =(array) $client->GetUsuariosAMP($array_params);  // OK



            if($respuesta['GetUsuariosAMPResult']->ErrorCode == 0){
                if(isset($respuesta['GetUsuariosAMPResult']->Model->anyType)){
                    $data = $respuesta['GetUsuariosAMPResult']->Model->anyType;
                }
            }



            if(is_object($data)){
                $data = array($data);
            }

            // $array_params = array(
            //     array(
            //         'name'  => 'Ck_nIdCadena', 
            //         'value' => $idCadenaAMP, 
            //         'type'  =>'i'
            //     )
            // );

            // $oRAMP->setSDatabase('aquimispagos');
            // $oRAMP->setSStoredProcedure('sp_select_usuarios_AMP');
            // $oRAMP->setParams($array_params);
            // $result = $oRAMP->execute();

            // if($result['nCodigo'] == 0){
            //     $data = $oRAMP->fetchAll();
            // }
            // $oRAMP->closeStmt();
            
            echo json_encode($data);
        }
    // ***************************

    // Obtener informacion para la migracion de remesas
        // function getDataMigracionRemesas(){
        //     ini_set("soap.wsdl_cache_enabled", "0");
        //     include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
        //     include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
        //     include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

        //     $idAgenteTD = (!empty($_POST["idAgente"]))? $_POST["idAgente"] : 0;

        //     $data = array();

        //     $array_params = array(
        //         array(
        //             'name'  => 'Ck_nIdAgenteTD', 
        //             'value' => $idAgenteTD, 
        //             'type'  =>'i'
        //         )
        //     );

        //     $oWTD->setSDatabase('td_administracion');
        //     $oWTD->setSStoredProcedure('sp_select_data_migracion_AMP');
        //     $oWTD->setParams($array_params);
        //     $result = $oWTD->execute();

        //     if($result['nCodigo'] == 0){
        //         $data = $oWTD->fetchAll();
        //     }
        //     $oWTD->closeStmt();
            
        //     echo json_encode($data);
        // }
    // ************************************************
?>