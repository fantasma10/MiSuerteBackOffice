<?php

    $opcion = (!empty($_POST["opcion"]))? $_POST["opcion"] : 0;
   
    switch ($opcion){
        case 1:
            setDatosCliente();
            break;
        case 2:
            //setMapSubCadena();
            break;
        case 3:
            //setMapSucursal();
            break;
        case 4:
            setMapOperador();
            break;
        case 5:
            setCodAcceso();
            break;
        case 6:
            setSucursales();
            break;
        case 7:
            setOperadores();
            break;
        case 8:
            setProductos();
            break;
        case 9:
            setAcceso();
            break;
        case 10:
            setOperadorRE();
            break;
        case 11:
            setMigracionServicios();
            break;
        case 12:
            setMapeoCorresponsalesRE();
            break;
        case 13:
            setRegistroOperadorREComplemento();
            break;
        case 14:
            setRegistroMapeoOperadorREComplemento();
            break;
        case 15:
            setDataMigracionRemesas();
            break;
        case 16:
            setUsuarioAMP();
            break;
        default:
            echo "No se recibió número de opción correctamente";
            break;
    }

    // Registro de Usuario en AMP
        function setUsuarioAMP(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $dataIN = (!empty($_POST["data"]))? $_POST["data"] : '';

            $dataInsertUsAMP = null;

            $array_params = null;
            $array_params = array(
                'OperadorEntity' => array(
                    'OperadorEntity' => array(
                        'Nombre'            => utf8_encode($dataIN['nombreOperador']),
                        'ApellidoPaterno'   => utf8_encode($dataIN['paternoOperador']), 
                        'ApellidoMaterno'   => utf8_encode($dataIN['maternoOperador']), 
                        'Telefono'          => $dataIN['telefonoOperador'], 
                        'Correo'            => utf8_encode($dataIN['correoOperador']), 
                        'Contrasena'        => '12345', 
                        'Perfil'            => 1, 
                        'Cadena'            => utf8_encode($dataIN['idCadenaAMP']), 
                        'Sucursal'          => utf8_encode($dataIN['idSucursalAMP']), 
                        'TipoRegistro'      => 3,
                        'EstatusRegistro'   => 1,
                        'Usuario'           => $dataIN['cveUsuario'], 
                        'IdOperadorRE'      => $dataIN['idOperador'], 
                        'Activo'            => 1
                    )
                )
            );

            $respuesta = null;
            $respuesta =(array)$client->InsertOperadores($array_params); // OK

            if($respuesta['InsertOperadoresResult']->ErrorCode == 0){
                $dataInsertUsAMP = $respuesta['InsertOperadoresResult']->Model->anyType->enc_value;
            }
            else{
                $dataInsertUsAMP = 0;
            }

            // Registrar en TD

            // *** consultar corresponsales y agencias mapeadas en RE ***
                $idAgente = $dataIN['idAgente'];
                $array_params = null;
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
                    $dataMapCorrAgencias = $oRdb->fetchAll();
                }
            // *** *** ***

                for($a=0; $a<count($dataMapCorrAgencias); $a++)
                {
                    $idAgencia = 0;
                    if($dataMapCorrAgencias[$a]['idCorresponsal'] == $dataIN['hnIdCorresponsal'])
                    {
                        $idAgencia = $dataMapCorrAgencias[$a]['idAgencia'];
                        break;
                    }
                }


                $array_params = null;
                $array_params = array(
                    array(
                        'name'  => 'Ck_nIdEmpleado', 
                        'value' => 1, 
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'Ck_nIdAgente', 
                        'value' => $idAgente,
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'Ck_nIdSubAgente', 
                        'value' => 0,
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'Ck_nIdAgencia', 
                        'value' => $idAgencia,
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'Ck_sCveOperador', 
                        'value' => '',
                        'type'  =>'s'
                    ),
                    array(
                        'name'  => 'Ck_sNombre', 
                        'value' => $dataIN['nombreOperador'],
                        'type'  =>'s'
                    ),
                    array(
                        'name'  => 'Ck_sPaterno', 
                        'value' => $dataIN['paternoOperador'],
                        'type'  =>'s'
                    ),
                    array(
                        'name'  => 'Ck_sMaterno', 
                        'value' => $dataIN['maternoOperador'],
                        'type'  =>'s'
                    ),
                    array(
                        'name'  => 'Ck_dFecNacimiento', 
                        'value' => '0000-00-00',
                        'type'  =>'s'
                    )
                );

                $dataOperadoresTD = null;
                $oWTD->setSDatabase('td_administracion');
                $oWTD->setSStoredProcedure('sp_insert_Operador_migracion');
                $oWTD->setParams($array_params);
                $result = $oWTD->execute();

                $dataOperadoresTD = array();
                if($result['nCodigo'] == 0){
                    $dataOperadoresTD = $oWTD->fetchAll();
                }
                $oWTD->closeStmt();

                $idOperador = 0;
                $idOperador = $dataOperadoresTD[0]['idOperador'];

                // 2. Generar codigo 

                include('generarCodigoTD.php');

                // 4. Registrar mapeo de operador en TD

                $array_params = null;
                $array_params = array(
                    array(
                        'name'  => 'CknIdOperador', 
                        'value' => $idOperador,
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'CknIdUsuario', 
                        'value' => $dataInsertUsAMP->nIdOperador,
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'CksUsuario', 
                        'value' => $dataInsertUsAMP->Usuario,
                        'type'  =>'s'
                    )
                );

                $oWTD->setSDatabase('td_administracion');
                $oWTD->setSStoredProcedure('sp_insert_map_operador_usuario_amp');
                $oWTD->setParams($array_params);
                $result = $oWTD->execute();
                
                $dataResp = array();
                if($result['nCodigo'] == 0){
                    $dataResp = $oWTD->fetchAll();
                }
                $oWTD->closeStmt();

                // 5. Registrar mapeo de operador TD en AMP

                $array_params = null;   
                $array_params= array(
                    'Ck_nIdAgente' => $idAgente,
                    'Ck_nIdAgencia' => $idAgencia,
                    'Ck_nIdOperador' => $idOperador,
                    'Ck_nIdUsuario' => $dataInsertUsAMP->nIdOperador
                );

                $respuesta = null;
                $respuesta =(array) $client->setMapOperadorTDAMP($array_params);  // OK
                
                $dataRespMapeoOperadores = null;
                $dataRespMapeoOperadores = array();
                if( isset($respuesta['setMapOperadorTDAMPResult']->ErrorCode) && $respuesta['setMapOperadorTDAMPResult']->ErrorCode == 0){
                    if(isset( $respuesta['setMapOperadorTDAMPResult']->Model->anyType->enc_value )){
                        $dataRespMapeoOperadores = $respuesta['setMapOperadorTDAMPResult']->Model->anyType;
                    }
                }

                // 3. Actualizar codigo capacit en usuario de AMP
                // sp_update_usuario_codigo_capacitacion_remesas

                $array_params = null;
                $array_params= array(
                    'CknIdOperador' => $idOperador, 
                    'CksCodigoCapacitacion' => $genSigCodigo 
                );

                $respuesta = null;
                $respuesta =(array)$client->SetUpdCodCap($array_params); // OK

                $dataUpd = null;
                $dataUpd = array();
                if($respuesta != null){
                    if($respuesta['SetUpdCodCapResult']->ErrorCode == 0){
                        $dataUpd[] = $respuesta['SetUpdCodCapResult']->ErrorMessage;
                    }else{ // error
                        $dataUpd[] = 0;
                    }
                }

            echo json_encode($dataRespMapeoOperadores);
        }

    // Registro de mapeo de usuarios RE complemento
        function setRegistroMapeoOperadorREComplemento(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $respMapOper    = (!empty($_POST["respMapOper"]))? $_POST["respMapOper"] : '';
            $respUsuAMP     = (!empty($_POST["respUsuAMP"]))? $_POST["respUsuAMP"] : '';
            $respOperWebpos = (!empty($_POST["respOperWebpos"]))? $_POST["respOperWebpos"] : '';
            $idCadenaAMP    = (!empty($_POST["idCadenaAMP"]))? $_POST["idCadenaAMP"] : 0;
            
            $data = array();
            if( is_array($respMapOper) )
            {
                // *** Revisar los usuarios Webpos vs usuarios AMP para identificar los que no existen ***
                for($i=0; $i<count($respOperWebpos); $i++)
                {
                    $respOperWebpos[$i]['flagMapeo'] = 0;
                    for($a=0; $a<count($respMapOper); $a++)
                    {
                        if( $respOperWebpos[$i]['idOperador'] == $respMapOper[$a]['data'][0]['IdOperador'] ){
                            $respOperWebpos[$i]['flagMapeo'] = 1;
                            break;
                        }
                    }
                }

                // *** consultar corresponsales y agencias mapeadas en RE ***
                    $idAgente = $respUsuAMP[0]['enc_value']['nIdAgenteTD'];
                    $array_params = null;
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
                        $dataMapCorrAgencias = $oRdb->fetchAll();
                    }
                // *** *** ***

                // *** Registrar usuario de webpos que no existe en los usuarios de AMP. Registro en AMP. ***
                    $dataInsertUsAMP = null;
                    for($i=0; $i<count($respOperWebpos); $i++)
                    {
                        if($respOperWebpos[$i]['flagMapeo'] == 0 && !empty($respOperWebpos[$i]['nombreOperador']) )
                        {
                            $cveUsuario = substr($respOperWebpos[$i]['nombreOperador'],0,1).substr($respOperWebpos[$i]['paternoOperador'],0,1).substr($respOperWebpos[$i]['maternoOperador'],0,1);
                            $cveUsuario = trim($cveUsuario);
                            $array_params = null;
                            $array_params = array(
                                'OperadorEntity' => array(
                                    'OperadorEntity' => array(
                                        'Nombre'            => utf8_encode($respOperWebpos[$i]['nombreOperador']),
                                        'ApellidoPaterno'   => utf8_encode($respOperWebpos[$i]['paternoOperador']), 
                                        'ApellidoMaterno'   => utf8_encode($respOperWebpos[$i]['maternoOperador']), 
                                        'Telefono'          => str_replace("-","",$respOperWebpos[$i]['telefonoOperador']), 
                                        'Correo'            => utf8_encode($respOperWebpos[$i]['correoOperador']), 
                                        'Contrasena'        => '12345', 
                                        'Perfil'            => 2, 
                                        'Cadena'            => utf8_encode($idCadenaAMP), // id cadena amp
                                        'Sucursal'          => utf8_encode($respUsuAMP[0]['enc_value']['nIdSucursal']), // id sucursal amp
                                        'TipoRegistro'      => 3,
                                        'EstatusRegistro'   => 1,
                                        'Usuario'           => utf8_encode($cveUsuario), 
                                        'IdOperadorRE'      => $respOperWebpos[$i]['idOperador'], 
                                        'Activo'            => $respOperWebpos[$i]['idEstatus']
                                    )
                                )
                            );

                            $respuesta = null;
                            $respuesta =(array)$client->InsertOperadores($array_params); // OK

                            if($respuesta['InsertOperadoresResult']->ErrorCode == 0){
                                $dataInsertUsAMP[] = $respuesta['InsertOperadoresResult']->Model->anyType->enc_value;
                            }
                            else{
                                $dataInsertUsAMP[] = 0;
                            }

                            // *** Registrar usuario en TD ***

                            // 1. Registrar Operador en TD

                            for($a=0; $a<count($dataMapCorrAgencias); $a++)
                            {
                                $idAgencia = $respUsuAMP[0]['enc_value']['nIdAgencia'];
                                if($dataMapCorrAgencias[$a]['idCorresponsal'] == $respOperWebpos[$i]['idCorresponsal'])
                                {
                                    $idAgencia = $dataMapCorrAgencias[$a]['idAgencia'];
                                    break;
                                }
                            }

                            $array_params = null;
                            $array_params = array(
                                array(
                                    'name'  => 'Ck_nIdEmpleado', 
                                    //'value' => 1, 
                                    'value' => $_SESSION['idU'], // id empleado
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'Ck_nIdAgente', 
                                    'value' => $respUsuAMP[0]['enc_value']['nIdAgenteTD'],
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'Ck_nIdSubAgente', 
                                    'value' => 0,
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'Ck_nIdAgencia', 
                                    'value' => $idAgencia,
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'Ck_sCveOperador', 
                                    'value' => '',
                                    'type'  =>'s'
                                ),
                                array(
                                    'name'  => 'Ck_sNombre', 
                                    'value' => $respOperWebpos[$i]['nombreOperador'],
                                    'type'  =>'s'
                                ),
                                array(
                                    'name'  => 'Ck_sPaterno', 
                                    'value' => $respOperWebpos[$i]['paternoOperador'],
                                    'type'  =>'s'
                                ),
                                array(
                                    'name'  => 'Ck_sMaterno', 
                                    'value' => $respOperWebpos[$i]['maternoOperador'],
                                    'type'  =>'s'
                                ),
                                array(
                                    'name'  => 'Ck_dFecNacimiento', 
                                    'value' => '0000-00-00',
                                    'type'  =>'s'
                                )
                            );

                            $dataOperadoresTD = null;
                            $oWTD->setSDatabase('td_administracion');
                            $oWTD->setSStoredProcedure('sp_insert_Operador_migracion');
                            $oWTD->setParams($array_params);
                            $result = $oWTD->execute();

                            $dataOperadoresTD = array();
                            if($result['nCodigo'] == 0){
                                $dataOperadoresTD = $oWTD->fetchAll();
                            }
                            $oWTD->closeStmt();

                            $idOperador = 0;
                            $idOperador = $dataOperadoresTD[0]['idOperador'];

                            // 2. Generar codigo 

                            include('generarCodigoTD.php');

                            

                            // 4. Registrar mapeo de operador en TD

                            $array_params = null;
                            $array_params = array(
                                array(
                                    'name'  => 'CknIdOperador', 
                                    'value' => $idOperador,
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'CknIdUsuario', 
                                    'value' => $dataInsertUsAMP[0]->nIdOperador,
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'CksUsuario', 
                                    'value' => $dataInsertUsAMP[0]->Usuario,
                                    'type'  =>'s'
                                )
                            );
            
                            $oWTD->setSDatabase('td_administracion');
                            $oWTD->setSStoredProcedure('sp_insert_map_operador_usuario_amp');
                            $oWTD->setParams($array_params);
                            $result = $oWTD->execute();
                            
                            $dataResp = array();
                            if($result['nCodigo'] == 0){
                                $dataResp = $oWTD->fetchAll();
                                
                            }
                            $oWTD->closeStmt();
                            // 5. Registrar mapeo de operador TD en AMP

                            $array_params = null;   
                            $array_params= array(
                                'Ck_nIdAgente' => $respUsuAMP[0]['enc_value']['nIdAgenteTD'],
                                'Ck_nIdAgencia' => $idAgencia,
                                'Ck_nIdOperador' => $idOperador,
                                'Ck_nIdUsuario' => $dataInsertUsAMP[0]->nIdOperador
                            );

                            $respuesta = null;
                            $respuesta =(array) $client->setMapOperadorTDAMP($array_params);  // OK
                            
                            $dataRespMapeoOperadores = null;
                            $dataRespMapeoOperadores = array();
                            if( isset($respuesta['setMapOperadorTDAMPResult']->ErrorCode) && $respuesta['setMapOperadorTDAMPResult']->ErrorCode == 0){
                                if(isset( $respuesta['setMapOperadorTDAMPResult']->Model->anyType->enc_value )){
                                    $dataRespMapeoOperadores = $respuesta['setMapOperadorTDAMPResult']->Model->anyType;
                                }
                            }


                            // 3. Actualizar codigo capacit en usuario de AMP
                            // sp_update_usuario_codigo_capacitacion_remesas

                            $array_params = null;
                            $array_params= array(
                                'CknIdOperador' => $idOperador, 
                                'CksCodigoCapacitacion' => $genSigCodigo 
                            );

                            $respuesta = null;
                            $respuesta =(array)$client->SetUpdCodCap($array_params); // OK
                
                            $dataUpd = null;
                            $dataUpd = array();
                            if($respuesta != null){
                                if($respuesta['SetUpdCodCapResult']->ErrorCode == 0){
                                    $dataUpd[] = $respuesta['SetUpdCodCapResult']->ErrorMessage;
                                }else{ // error
                                    $dataUpd[] = 0;
                                }
                            }
                        }
                        else
                        {
                            continue;
                        }
                        // ***********************
                    }

                // ******************************************************************
                $data = null; $data = array();
                for($i=0; $i<count($respMapOper); $i++)
                {
                    // *** WS ***
                    $array_params = null;
                    $array_params= array(
                        'P_nIdOperadorRE' => $respMapOper[$i]['data'][0]['IdOperador'], 
                        'P_nIdOperadorAMP' => $respMapOper[$i]['nIdUsuarioAMP']
                    );

                    $respuesta = null;
                    $respuesta =(array)$client->SetMapOperMig($array_params); // OK
        
                    if($respuesta != null){
                        if($respuesta['SetMapOperMigResult']->ErrorCode == 0){
                            $data[] = $respuesta['SetMapOperMigResult']->ErrorMessage;
                        }else{ // error
                            $data[] = 0;
                        }
                    }
                }
            }
            echo json_encode($data);
        }
    // ********************************************

    // Registro de usuarios RE complemento
        function setRegistroOperadorREComplemento(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            // include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $respUsuAMP = (!empty($_POST["respUsuAMP"]))? $_POST["respUsuAMP"] : '';

            $data = array();
            if( count($respUsuAMP) > 0 )
            {
                for($i=0; $i<count($respUsuAMP); $i++)
                {
                    $idCorresponsalRE   = $respUsuAMP[$i]['enc_value']['nIdCorresponsalRE'];
                    $nombre             = $respUsuAMP[$i]['enc_value']['sNombre'];
                    $apellidos          = trim( $respUsuAMP[$i]['enc_value']['sApellidoPaterno'].' '.$respUsuAMP[$i]['enc_value']['sApellidoMaterno'] );

                    $array_params = array(
                        array(
                            'name'  => 'IDCORR', 
                            'value' => $idCorresponsalRE, 
                            'type'  =>'i'
                        ),
                        array(
                            'name'  => 'NOMBRE', 
                            'value' => $nombre, 
                            'type'  =>'s'
                        ),
                        array(
                            'name'  => 'APELLIDOS', 
                            'value' => $apellidos, 
                            'type'  =>'s'
                        )
                    );

                    $oWdb->setSDatabase('redefectiva');
                    $oWdb->setSStoredProcedure('SPE_ALTAOPERADOR_AQUIMP');
                    $oWdb->setParams($array_params);
                    $result = $oWdb->execute();

                    if($result['nCodigo'] == 0){
                        $data[] = array(
                            'idOperadorRE' => $respUsuAMP[$i]['enc_value']['nIdOperadorRE'],
                            'idOperadorTD' => $respUsuAMP[$i]['enc_value']['nIdOperadorTD'],
                            'nIdUsuarioAMP' => $respUsuAMP[$i]['enc_value']['nIdUsuario'],
                            'data' => $oWdb->fetchAll()
                         );
                    }
                    $oWdb->closeStmt();
                }
            }
            echo json_encode($data);
        }
    // ********************************************

    // registra información de cliente a migrar.
        function setDatosCliente(){
            // *** Correr script 1 para registrar informacion en AMP ***
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $nidCadenaRE        = (!empty($_POST["nidCadenaRE"]))? $_POST["nidCadenaRE"] : 0;
            $sCadena            = (!empty($_POST["sCadena"]))? $_POST["sCadena"] : '';
            $sRazonSocial       = (!empty($_POST["sRazonSocial"]))? $_POST["sRazonSocial"] : '';
            $sCorresponsal      = (!empty($_POST["sCorresponsal"]))? $_POST["sCorresponsal"] : '';
            $sNombre            = (!empty($_POST["sNombre"]))? $_POST["sNombre"] : '';
            $sPaterno           = (!empty($_POST["sPaterno"]))? $_POST["sPaterno"] : '';
            $sMaterno           = (!empty($_POST["sMaterno"]))? $_POST["sMaterno"] : '';
            $sCorreo            = (!empty($_POST["sCorreo"]))? $_POST["sCorreo"] : '';
            $telefono           = (!empty($_POST["telefono"]))? $_POST["telefono"] : '0';
            $sUsuario           = (!empty($_POST["sUsuario"]))? $_POST["sUsuario"] : '0';
            $sContrasena        = (!empty($_POST["sContrasena"]))? $_POST["sContrasena"] : '12345';
            $tipoPersona        = (!empty($_POST["tipoPersona"]))? $_POST["tipoPersona"] : 3;
            $sCURP              = (!empty($_POST["sCURP"]))? $_POST["sCURP"] : '0';
            $nIdTipoIdentif     = (!empty($_POST["nIdTipoIdentif"]))? $_POST["nIdTipoIdentif"] : 0;
            $nNumIdentif        = (!empty($_POST["nNumIdentif"]))? $_POST["nNumIdentif"] : '0';
            $nFigPolitica       = (!empty($_POST["nFigPolitica"]))? $_POST["nFigPolitica"] : 0;
            $nIdTipoForeloCliente = (!empty($_POST["nIdTipoForeloCliente"]))? $_POST["nIdTipoForeloCliente"] : 0;
            $nIdSubCadenaRE     = (!empty($_POST["nIdSubCadenaRE"]))? $_POST["nIdSubCadenaRE"] : 0;
            $nIdCorresponsalRE  = (!empty($_POST["nIdCorresponsalRE"]))? $_POST["nIdCorresponsalRE"] : 0;
            $nIdOperadorRE      = (!empty($_POST["nIdOperadorRE"]))? $_POST["nIdOperadorRE"] : 0;
            $sNumCuenta         = (!empty($_POST["sNumCuenta"]))? $_POST["sNumCuenta"] : '';
            $sReferencia        = (!empty($_POST["sReferencia"]))? $_POST["sReferencia"] : '';
            $sRFC               = (!empty($_POST["sRFC"]))? $_POST["sRFC"] : '';
            $nSerie             = (!empty($_POST["nSerie"]))? $_POST["nSerie"] : '0';

            $sCadena = preg_replace('/[áÁ]/u', 'a', $sCadena);
            $sCadena = preg_replace('/[éÉ]/u', 'e', $sCadena);
            $sCadena = preg_replace('/[íÍ]/u', 'i', $sCadena);
            $sCadena = preg_replace('/[óÓ]/u', 'o', $sCadena);
            $sCadena = preg_replace('/[úÚ]/u', 'u', $sCadena);
            $sCadena = strtoupper($sCadena);

            $sRazonSocial = preg_replace('/[áÁ]/u', 'a', $sRazonSocial);
            $sRazonSocial = preg_replace('/[éÉ]/u', 'e', $sRazonSocial);
            $sRazonSocial = preg_replace('/[íÍ]/u', 'i', $sRazonSocial);
            $sRazonSocial = preg_replace('/[óÓ]/u', 'o', $sRazonSocial);
            $sRazonSocial = preg_replace('/[úÚ]/u', 'u', $sRazonSocial);
            $sRazonSocial = strtoupper($sRazonSocial);

            $sNombre = preg_replace('/[áÁ]/u', 'a', $sNombre);
            $sNombre = preg_replace('/[éÉ]/u', 'e', $sNombre);
            $sNombre = preg_replace('/[íÍ]/u', 'i', $sNombre);
            $sNombre = preg_replace('/[óÓ]/u', 'o', $sNombre);
            $sNombre = preg_replace('/[úÚ]/u', 'u', $sNombre);
            $sNombre = strtoupper($sNombre);

            $sPaterno = preg_replace('/[áÁ]/u', 'a', $sPaterno);
            $sPaterno = preg_replace('/[éÉ]/u', 'e', $sPaterno);
            $sPaterno = preg_replace('/[íÍ]/u', 'i', $sPaterno);
            $sPaterno = preg_replace('/[óÓ]/u', 'o', $sPaterno);
            $sPaterno = preg_replace('/[úÚ]/u', 'u', $sPaterno);
            $sPaterno = strtoupper($sPaterno);

            $sMaterno = preg_replace('/[áÁ]/u', 'a', $sMaterno);
            $sMaterno = preg_replace('/[éÉ]/u', 'e', $sMaterno);
            $sMaterno = preg_replace('/[íÍ]/u', 'i', $sMaterno);
            $sMaterno = preg_replace('/[óÓ]/u', 'o', $sMaterno);
            $sMaterno = preg_replace('/[úÚ]/u', 'u', $sMaterno);
            $sMaterno = strtoupper($sMaterno);

            $array_params= array(
                "oClientEntity" => array(                    
                    'NombreCadena'          => utf8_encode($sCadena),
                    'RazonSocCadena'        => utf8_encode($sRazonSocial),
                    'NombreCorresponsal'    => utf8_encode($sCorresponsal),
                    'Nombre'                => utf8_encode($sNombre),
                    'ApellidoPaterno'       => utf8_encode($sPaterno),
                    'ApellidoMaterno'       => utf8_encode($sMaterno),
                    'Usuario'               => utf8_encode($sUsuario),
                    'Contrasena'            => utf8_encode($sContrasena),
                    'Correo'                => utf8_encode($sCorreo),
                    'Telefono'              => $telefono,
                    'ForeloIndividual'      => $nIdTipoForeloCliente,
                    'IdTipoCadena'          => $tipoPersona,
                    'IdTipoIdentificacion'  => $nIdTipoIdentif,
                    'NumIdentificacion'     => $nNumIdentif,
                    'FigPolitica'           => $nFigPolitica,
                    'CURP'                  => $sCURP,
                    'FechaNacimiento'       => '2000-01-01',
                    'Nacionalidad'          => 0,
                    'PaisNacimiento'        => 0,
                    'IdSubCadenaRE'         => $nIdSubCadenaRE,
                    'IdCorresponsalRE'      => $nIdCorresponsalRE,
                    'IdOperadorRE'          => $nIdOperadorRE,
                    'NumCuentaForelo'       => $sNumCuenta,
                    'Referencia'            => $sReferencia,
                    'RFC'                   => $sRFC,
                    'Serie'                 => $nSerie
                )
            );

            // *** WS ***
            $respuesta = null;
            $respuesta =(array)$client->RegistraCliente($array_params); // OK

            if($respuesta != null){
                if($respuesta['RegistraClienteResult']->ErrorCode == 0 ){
                    $data[] = $respuesta['RegistraClienteResult']->Model->anyType->enc_value;
                }else{ // error
                    $data[] = $respuesta['RegistraClienteResult']->ErrorCode;
                }
            }
            
            echo json_encode($data);
        }
    // ********************************************

    // *** Registra mapeo de operador ***
        function setMapOperador(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $P_nIdOperadorRE = (!empty($_POST["P_nIdOperadorRE"]))? $_POST["P_nIdOperadorRE"] : 0;
            $P_nIdOperadorAMP = (!empty($_POST["P_nIdOperadorAMP"]))? $_POST["P_nIdOperadorAMP"] : 0;

            $data = array();

            if($P_nIdOperadorRE > 0){
                
                // *** WS ***
                    $array_params= array(
                        'IdOperadorRE' => $P_nIdOperadorRE, 
                        'IdOperadorAMP' => $P_nIdOperadorAMP
                    );

                    $respuesta = null;
                    $respuesta =(array)$client->MapeoOperador($array_params); // OK

                    if($respuesta != null){
                        if($respuesta['MapeoOperadorResult']->ErrorCode == 0){
                            $data = $respuesta['MapeoOperadorResult']->ErrorMessage;
                        }else{ // error
                            $data = 0;
                        }
                    }
                // *** *** ***
            }

            echo json_encode($data);
        }
    // ***********************************

    // *** Registra codigo de acceso ***
        function setCodAcceso(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

            $Ck_nIdCadenaRE = (!empty($_POST["idCadenaRE"]))? $_POST["idCadenaRE"] : 0;
            $Ck_nIdSubCadenaRE = (!empty($_POST["idSubCadenaRE"]))? $_POST["idSubCadenaRE"] : 0;
            $Ck_nIdCorresponsalRE = (!empty($_POST["idCorresponsal"]))? $_POST["idCorresponsal"] : 0;
            $Ck_sCodigo = (!empty($_POST["codigoAcceso"]))? $_POST["codigoAcceso"] : '';

            $data = array();

            if($Ck_sCodigo <> ''){
                $array_params = array(
                    array(
                        'name'  => 'Ck_nIdCadenaRE', 
                        'value' => $Ck_nIdCadenaRE, 
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'Ck_nIdSubCadenaRE', 
                        'value' => $Ck_nIdSubCadenaRE, 
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'Ck_nIdCorresponsalRE', 
                        'value' => $Ck_nIdCorresponsalRE, 
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'Ck_sCodigo', 
                        'value' => $Ck_sCodigo, 
                        'type'  =>'s'
                    )
                );

                $oWdb->setSDatabase('redefectiva');
                $oWdb->setSStoredProcedure('sp_insert_codigoAcceso_migracion_AQUIMP');
                $oWdb->setParams($array_params);
                $result = $oWdb->execute();

                if($result['nCodigo'] == 0){
                    $data = $oWdb->fetchAll();
                }
            }
            
            echo json_encode($data);
        }
    // ***********************************

    // *** Registra sucursales ***
        function setSucursales(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 


            // *** Consulta de corresponsales ***
            //$data = array();
            $idCliente = (!empty($_POST["idCliente"]))? $_POST["idCliente"] : 0;
            // $flagMigRE = (!empty($_POST['flagMigRE']))? $_POST["flagMigRE"] : 0;

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
                // if($flagMigRE == 1)
                // {
                //     $dataB = null;
                //     for($i=0; $i<count($data); $i++){
                //         $dataB[] = array(
                //             'nombreCorresponsal'    => utf8_encode($data[$i]['nombreCorresponsal']),
                //             'nombreSucursal'        => utf8_encode($data[$i]['nombreSucursal']),
                //             'idcColonia'            => $data[$i]['idcColonia'],
                //             'calleDireccion'        => $data[$i]['calleDireccion'],
                //             'numeroIntDireccion'    => $data[$i]['numeroIntDireccion'],
                //             'numeroExtDireccion'    => $data[$i]['numeroExtDireccion'],
                //             'nombreCadena'          => utf8_encode($data[$i]['nombreCadena']),
                //             'foreloIndividual'      => $data[$i]['foreloIndividual'],
                //             'idCorresponsal'        => $data[$i]['idCorresponsal']
                //         );
                //     }
                //     $data = null;
                //     $data = $dataB;
                // }
                // if($flagMigRE == 2) // registro activacion de accesos 
                // {
                //     $dataB = null;
                //     for($i=0; $i<count($data); $i++)
                //     {
                //         $dataB[] = array(
                //             'idCorresponsal' => $data[$i]['idCorresponsal']
                //         );
                //     }
                //     $data = null;
                //     $data = $dataB;
                // }

            //$corresponsales = (!empty($_POST["data"]))? $_POST["data"] : '';
            $corresponsales = $data;
            $idCadenaAMP = (!empty($_POST["idCadenaAMP"]))? $_POST["idCadenaAMP"] : 0;

            $data = null;
            $data = array();
            $data['errorCode'] = "0";
            $array_params = array();

            if($idCadenaAMP > 0)
            {
                for($i=0; $i<count($corresponsales); $i++){
                    if($corresponsales[$i]['nombreSucursal'] == ''){
                        $corresponsales[$i]['nombreSucursal'] = $corresponsales[$i]['nombreCorresponsal'];
                    }
                    if($corresponsales[$i]['numeroIntDireccion'] == ''){
                        $corresponsales[$i]['numeroIntDireccion'] = 0;
                    }
                    if($telefono == ''){
                        $telefono = 0;
                    }
    
                    $num_interior = 0; $num_exterior = 0; $idColonia = 1;
                    if( !empty($corresponsales[$i]['numeroIntDireccion']) ){
                        $num_interior = preg_replace("/[^0-9]/","",$corresponsales[$i]['numeroIntDireccion']);
                    }
                    if( !empty($corresponsales[$i]['numeroExtDireccion']) ){
                        $num_exterior = preg_replace("/[^0-9]/","",$corresponsales[$i]['numeroExtDireccion']);
                    }
                    if( !empty($telefono) ){
                        $telefono = preg_replace("/[^0-9]/","",$telefono);
                    }
                    if( !empty($corresponsales[$i]['idcColonia']) ){
                        $idColonia = $corresponsales[$i]['idcColonia'];
                    }

                    if( trim($corresponsales[$i]['calleDireccion']) == '' ){
                        $corresponsales[$i]['calleDireccion'] = "Sin Calle";
                    }

                    $array_params = null;
                    $array_params = array(
                        "oSucursalesEntity" => array(
                            "SucursalEntity" => array(
                                'NombreSucursal'    => utf8_encode($corresponsales[$i]['nombreCorresponsal']),
                                'Descripcion'       => utf8_encode($corresponsales[$i]['nombreSucursal']),
                                'IdColonia'         => $idColonia,
                                'Calle'             => $corresponsales[$i]['calleDireccion'],
                                'NumInterior'       => substr($num_interior,0,4),
                                'NumExterior'       => substr($num_exterior,0,4),
                                'EntreCalleUno'     => '0',
                                'EntreCalleDos'     => '0',
                                'Telefono'          => $telefono,
                                'IdCadenaS'         => $idCadenaAMP,
                                'NombreCadena'      => utf8_encode($corresponsales[$i]['nombreCadena']),
                                'ForeloIndividual'  => $corresponsales[$i]['foreloIndividual'],
                                'IdCorresponsal'    => $corresponsales[$i]['idCorresponsal'],
                                'CkNumCuentaForelo' => $corresponsales[$i]['numeroCuenta'],
                                'CksReferencia'     => $corresponsales[$i]['referencia'],
                                'CkRFC'             => $corresponsales[$i]['RFC'],
                                'CksSerie'          => $corresponsales[$i]['serie']
                            )
                        )
                    );

                    $respuesta = null;
                    $respuesta =(array)$client->RegistraSucursales($array_params); // OK
    
                    if($respuesta != null){
                        if($respuesta['RegistraSucursalesResult']->ErrorCode == 0 && $respuesta['RegistraSucursalesResult']->Status == true ){
                            $data[] = $respuesta['RegistraSucursalesResult']->Model->anyType->enc_value;
                        }else{ // error
                            $data[] = 0;
                        }
                    }
                    sleep(0.02);
                }
            }
            else{
                $data['errorCode'] = "99";
            }
            
            echo json_encode($data);
        }
    // ***********************************

    // *** Registra operadores en AMP ***
        function setOperadores(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $idCadenaAMP = (!empty($_POST["idCadenaAMP"]))? $_POST["idCadenaAMP"] : 0;
            $idCliente = (!empty($_POST["idCliente"]))? $_POST["idCliente"] : 0;
            $administradores = (!empty($_POST["administradores"]))? $_POST["administradores"] : 0;

            $idPerfil = 2;

            // Consulta de operadores
            $array_paramsOper = array(
                array(
                    'name'  => 'ck_nIdCliente', 
                    'value' => $idCliente, 
                    'type'  =>'i'
                )
            );
            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_operadores_by_idCliente');
            $oRdb->setParams($array_paramsOper);
            $result = $oRdb->execute();

            $operadores = array();
            if($result['nCodigo'] == 0){
                $operadores = $oRdb->fetchAll();
            }
            $oRdb->closeStmt();

            // consultar mapeo de corresponsal vs sucursal
            $dataMap = array(); 
            $data = array();
            //if( count($operadores) > 0 )
            {
                $idCorresponsalTemp = 0;
                for($i=0; $i<count($operadores); $i++)
                {
                    // *** WS ***
                        if( $operadores[$i]['idCorresponsal'] == $idCorresponsalTemp ){ continue; }
                        $array_paramsMap= array(
                            'oCorresponsalEntity'=>array(
                                'CorresponsalEntity' =>array(
                                    'IdCorresponsal' => $operadores[$i]['idCorresponsal'],
                                    'IdSucursal' => 0
                                )
                            )
                        );
        
                        $respuesta = null;
                        $respuesta =(array)$client->ObtieneOperadores($array_paramsMap); // OK
        
                        if($respuesta != null){
                            if($respuesta['ObtieneOperadoresResult']->ErrorCode == 0){
                                $dataMap[] = $respuesta['ObtieneOperadoresResult']->Model->anyType->enc_value;
                            }else{ // error
                                $dataMap[] = 0;
                            }
                        }
                        sleep(0.01);
                        $idCorresponsalTemp = $operadores[$i]['idCorresponsal'];
                    // *** *** ***
                }

                // *** Comparar el nombre de los operadores encontrados para no duplicarlos. ***
                /*
                * Quitar acentos.
                * Paso 1. Hacer uniforme en mayusculas el nombre de operador RE
                * Paso 2. Hacer uniforme en mayusculas el nombre de operador AMP
                * Paso 3. Comparar nombres.
                * Paso 4. Guardar en array nuevo los que se van a registrar.
                */

                for($i=0; $i<count($operadores); $i++)
                {
                    $flagIgual = 0;
                    for($b=0; $b<count($dataMap); $b++)
                    {
                        $nombreCompletoRE = strtoupper( trim($operadores[$i]['nombreOperador']).trim($operadores[$i]['paternoOperador']).trim($operadores[$i]['maternoOperador']) );
                        $nombreCompletoAMP = strtoupper( trim($dataMap[$b]->sNombre).trim($dataMap[$b]->sApellidoPaterno).trim($dataMap[$b]->sApellidoMaterno) );

                        $nombreCompletoRE = preg_replace('/[áÁ]/u', 'a', $nombreCompletoRE);
                        $nombreCompletoRE = preg_replace('/[éÉ]/u', 'a', $nombreCompletoRE);
                        $nombreCompletoRE = preg_replace('/[íÍ]/u', 'a', $nombreCompletoRE);
                        $nombreCompletoRE = preg_replace('/[óÓ]/u', 'a', $nombreCompletoRE);
                        $nombreCompletoRE = preg_replace('/[úÚ]/u', 'a', $nombreCompletoRE);

                        $nombreCompletoAMP = preg_replace('/[áÁ]/u', 'a', $nombreCompletoAMP);
                        $nombreCompletoAMP = preg_replace('/[éÉ]/u', 'a', $nombreCompletoAMP);
                        $nombreCompletoAMP = preg_replace('/[íÍ]/u', 'a', $nombreCompletoAMP);
                        $nombreCompletoAMP = preg_replace('/[óÓ]/u', 'a', $nombreCompletoAMP);
                        $nombreCompletoAMP = preg_replace('/[úÚ]/u', 'a', $nombreCompletoAMP);

                        if( $nombreCompletoRE == $nombreCompletoAMP ){  
                            $flagIgual = 1;
                            break;
                        }
                    }

                    if( $flagIgual == 1 ){ continue; }

                    $telefono = str_replace("-","",$operadores[$i]['telefonoOperador']);
                    $telefono = substr($telefono,-10);

                    $idSucursalAMP = 0;

                    if( is_array($dataMap) && count($dataMap) > 0 )
                    {
                        for($a=0; $a<count($dataMap); $a++){
                            if($dataMap[$a]->nIdCorresponsalRE == $operadores[$i]['idCorresponsal']){
                                $idSucursalAMP = $dataMap[$a]->nIdSucursalAMP;
                                break;
                            }
                        }
                    }
                    
                    if($operadores[$i]['idEstatus'] > 1){
                        $operadores[$i]['idEstatus'] = 0;
                    }

                    if($operadores[$i]['telefonoOperador'] == null || $operadores[$i]['telefonoOperador'] == 'null' || trim($operadores[$i]['telefonoOperador']) == ''){
                        $operadores[$i]['telefonoOperador'] = 0;
                    }

                    for($ii=0; $ii<count($administradores); $ii++){
                        $idPerfil = 2;
                        if($operadores[$i]['idOperador'] == $administradores[$ii]){
                            $idPerfil = 1;
                            break;
                        }
                    }

                    $operadores[$i]['nombreOperador'] = strtoupper( trim($operadores[$i]['nombreOperador']) ) ;
                    $operadores[$i]['paternoOperador'] = strtoupper( trim($operadores[$i]['paternoOperador']) ) ;
                    $operadores[$i]['maternoOperador'] = strtoupper( trim($operadores[$i]['maternoOperador']) );

                    $cveUsuario = substr($operadores[$i]['nombreOperador'],0,1).substr($operadores[$i]['paternoOperador'],0,1).substr($operadores[$i]['maternoOperador'],0,1);
                    $cveUsuario = trim($cveUsuario);
                    
                    // *** WS ***
                    $array_params = null;
                    $array_params = array(
                        'OperadorEntity' => array(
                            'OperadorEntity' => array(
                                'Nombre'            => utf8_encode($operadores[$i]['nombreOperador']),
                                'ApellidoPaterno'   => utf8_encode($operadores[$i]['paternoOperador']), 
                                'ApellidoMaterno'   => utf8_encode($operadores[$i]['maternoOperador']), 
                                'Telefono'          => $operadores[$i]['telefonoOperador'], 
                                'Correo'            => utf8_encode($operadores[$i]['correoOperador']), 
                                'Contrasena'        => '12345', 
                                'Perfil'            => $idPerfil, 
                                'Cadena'            => $idCadenaAMP, // id cadena amp
                                'Sucursal'          => $idSucursalAMP, // id sucursal amp
                                'TipoRegistro'      => 3,
                                'EstatusRegistro'   => 1,
                                'Usuario'           => utf8_encode($cveUsuario), 
                                'IdOperadorRE'      => $operadores[$i]['idOperador'], 
                                'Activo'            => $operadores[$i]['idEstatus']
                            )
                        )
                    );

                    $respuesta = null;
                    $respuesta =(array)$client->InsertOperadores($array_params); // OK

                    if($respuesta['InsertOperadoresResult']->ErrorCode == 0){
                        $data[] = $respuesta['InsertOperadoresResult']->Model->anyType->enc_value;
                    }
                    else{
                        $data[] = 0;
                    }
                    sleep(0.01);
                    // *** *** ***
                }
            }

            echo json_encode($data);
        }
    // ***********************************

    // *** Registra productos en AMP ***
        function setProductos(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            // consulta de productos
            $idCadenaAMP = (!empty($_POST["idCadenaAMP"]))? $_POST["idCadenaAMP"] : 0;
            $idCadenaRE = (!empty($_POST["idCadenaRE"]))? $_POST["idCadenaRE"] : 0;
            $idSubCadenaRE = (!empty($_POST["idSubCadenaRE"]))? $_POST["idSubCadenaRE"] : 0;
            $idVersionCliente = (!empty($_POST["idVersionCliente"]))? $_POST["idVersionCliente"] : 0;
            //$idCorresponsalMigracionRE = (!empty($_POST["idCorresponsalMigracion"]))? $_POST["idCorresponsalMigracion"] : '';

            /*
            Paso 1: Obtener la versión del cliente. -OK
            Paso 2: Obtener los productos configurados de la subcadena RE con su versión.
            Paso 3: Obtener los productos de la configuración por cadena y subcadena global (-1) según la versión del cliente.
            Paso 4: Obtener los productos de la configuración global según la versión del cliente.
            Paso 5, Fusionar los resultados dando prioridad a las comisiones de la configuración de la subcadena.
            */

            // Parametros y consulta originales antes del 3 oct 2023
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
                ),
                array(
                    'name'  => 'Ck_idVersionCte', 
                    'value' => $idVersionCliente, 
                    'type'  =>'i'
                ),
                array(
                    'name'  => 'Ck_idConsulta', 
                    'value' => 0,
                    'type'  =>'i'
                )
            );

            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_productos_migracion');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $productos = array();
            if($result['nCodigo'] == 0){
                $productos = $oRdb->fetchAll();
            }
            $oRdb->closeStmt();

            // $errorCode = 0;
            $data = array();
            for($i=0; $i<count($productos); $i++)
            {
                // $telefono = str_replace("-","",$productos[$i]['telefono1']);
                // $telefono = substr($telefono,-10);

                $productos[$i]['idEstatusPermiso'] = 1;

                //if($productos[$i]['idEstatusPermiso'] == 0){ $productos[$i]['idEstatusPermiso'] = 1; }else{ $productos[$i]['idEstatusPermiso'] = 0; }
                if($productos[$i]['skuProducto'] == null || $productos[$i]['skuProducto'] == 'null' || trim($productos[$i]['skuProducto']) == ''){ continue; }

                /*
                si id corresponsal es -1, consultar sucursales de cadena para agregar el producto por cada sucursal encontrada
                si el id corresponsal es mayor a 0 entonces solo inserta el producto por esa sucursal encontrada del mapeo.
                */

                $dataMap = null;
                if($productos[$i]['idCorresponsal'] < 0) // si id es -1 (todos)
                {
                    // *** WS ***
                        $array_paramsMap = null;
                        $array_paramsMap = array(
                            'IdCadenas' => array(
                                'int' => $idCadenaAMP
                            )
                        );

                        $respuesta = null;
                        $respuesta =(array)$client->ObtieneSucursalesPorCadena($array_paramsMap); // OK

                        if($respuesta['ObtieneSucursalesPorCadenaResult']->ErrorCode == 0){
                            if(isset($respuesta['ObtieneSucursalesPorCadenaResult']->Model->anyType->enc_value)){
                                $dataMap[] = $respuesta['ObtieneSucursalesPorCadenaResult']->Model->anyType->enc_value;
                            }
                            else{
                                for($mapCount = 0; $mapCount < count($respuesta['ObtieneSucursalesPorCadenaResult']->Model->anyType); $mapCount++){
                                    $dataMap[] = $respuesta['ObtieneSucursalesPorCadenaResult']->Model->anyType[$mapCount]->enc_value;
                                }
                            }
                        }
                    // *** *** ***
                }
                else{ // si id es especifico
                    // *** WS ***
                    $array_paramsMap= array(
                        'oCorresponsalEntity'=>array(
                            'CorresponsalEntity' =>array(
                                'IdCorresponsal' => $productos[$i]['idCorresponsal'], 
                                'IdSucursal' => 0
                            )
                        )
                    );

                    $respuesta = null;
                    $respuesta =(array)$client->ObtieneOperadores($array_paramsMap); // OK

                    if($respuesta != null){
                        if($respuesta['ObtieneOperadoresResult']->ErrorCode == 0){
                            $dataMap[] = $respuesta['ObtieneOperadoresResult']->Model->anyType->enc_value;
                        }
                    }
                    // *** *** ***
                }

                if( isset($dataMap[0]) && $dataMap[0] != '' )
                {
                    //for($a=0; $a<count($dataMap); $a++)
                    {
                        // *** WS ***
                            if($dataMap[0]->IdCorresponsalRE != '' && $dataMap[0]->IdCorresponsalRE != 0)
                            {
                                $array_params = null;
                                $array_params = array(
                                    'oProductosEntiry' => array(
                                        'ProductoEntity' => array(
                                            'IdSubCadenaRE' => $idSubCadenaRE, 
                                            'IdCorresponsalRE' => $dataMap[0]->IdCorresponsalRE,
                                            'IdVersionAMP' => 1,
                                            'ActivoAMP' => $productos[$i]['idEstatusPermiso'], 
                                            'IdProducto' => $productos[$i]['idProducto'], 
                                            'Sku' => $productos[$i]['skuProducto'], 
                                            'ImporteMinimo' => $productos[$i]['impMinPermiso'], 
                                            'ImporteMaximo' => $productos[$i]['impMaxPermiso'], 
                                            'Comision' => $productos[$i]['impComCliente'],
                                            'Consulta' => 0,
                                            'Cargo' => $productos[$i]['impComEspecial'],
                                            'Parcial' => 0,
                                            'Activo' => $productos[$i]['idEstatusPermiso'], 
                                            // 'tranType' => $productos[$i]['idTranType'], 
                                            // 'IdEmisor' => $productos[$i]['idEmisor'] 
                                            'tranType' => 0, 
                                            'IdEmisor' => 0 
                                        )
                                    )
                                );
                                $respuesta = null;
                                $respuesta =(array)$client->RegistraProductos($array_params);
                                if($respuesta != null){
                                    if($respuesta['RegistraProductosResult']->ErrorCode == 0){
                                        $data[] = $respuesta['RegistraProductosResult']->Model->anyType->enc_value;
                                    }else{ // error
                                        $data[] = 0;
                                    }
                                }
                            }
                            else{ // no viene idCorresponsal
                                $data[] = 0;
                            }
                        // *** *** ***
                        sleep(0.01);
                        //break;
                    }
                }
            }
            // $data['errorCode'] = $errorCode;
            echo json_encode($data);
        }
    // ***********************************

    // *** Registra acceso de terminal  ***
        function setAcceso(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

            $Ck_nIdCadenaRE = (!empty($_POST["idCadenaRE"]))? $_POST["idCadenaRE"] : 0;
            $Ck_nIdSubCadenaRE = (!empty($_POST["idSubCadenaRE"]))? $_POST["idSubCadenaRE"] : 0;
            $Ck_nIdCorresponsalRE = (!empty($_POST["idCorresponsal"]))? $_POST["idCorresponsal"] : 0;

            $data = array();

            $array_params = array(
                array(
                    'name'  => 'Ck_nIdCadenaRE', 
                    'value' => $Ck_nIdCadenaRE, 
                    'type'  =>'i'
                ),
                array(
                    'name'  => 'Ck_nIdSubCadenaRE', 
                    'value' => $Ck_nIdSubCadenaRE, 
                    'type'  =>'i'
                ),
                array(
                    'name'  => 'Ck_nIdCorresponsalRE', 
                    'value' => $Ck_nIdCorresponsalRE, 
                    'type'  =>'i'
                )
            );

            $oWdb->setSDatabase('redefectiva');
            $oWdb->setSStoredProcedure('sp_insert_acceso_terminal_migracion_AQUIMP');
            $oWdb->setParams($array_params);
            $result = $oWdb->execute();

            if($result['nCodigo'] == 0){
                $data = $oWdb->fetchAll();
            }
            
            echo json_encode($data);
        }
    // ***********************************

    // *** Registra Operador en RE  ***
        function setOperadorRE(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

            $idCorresponsalRE = (!empty($_POST["idCorresponsalRE"]))? $_POST["idCorresponsalRE"] : 0;
            $sNombre = (!empty($_POST["sNombre"]))? $_POST["sNombre"] : '';
            $sApellidos = (!empty($_POST["sApellidos"]))? $_POST["sApellidos"] : '';

            $sNombre = preg_replace('/[áÁ]/u', 'a', $sNombre);
            $sNombre = preg_replace('/[éÉ]/u', 'e', $sNombre);
            $sNombre = preg_replace('/[íÍ]/u', 'i', $sNombre);
            $sNombre = preg_replace('/[óÓ]/u', 'o', $sNombre);
            $sNombre = preg_replace('/[úÚ]/u', 'u', $sNombre);
            $sNombre = strtoupper( trim($sNombre) );

            $sApellidos = preg_replace('/[áÁ]/u', 'a', $sApellidos);
            $sApellidos = preg_replace('/[éÉ]/u', 'e', $sApellidos);
            $sApellidos = preg_replace('/[íÍ]/u', 'i', $sApellidos);
            $sApellidos = preg_replace('/[óÓ]/u', 'o', $sApellidos);
            $sApellidos = preg_replace('/[úÚ]/u', 'u', $sApellidos);
            $sApellidos = strtoupper( trim($sApellidos) );

            $data = array();

            $array_params = array(
                array(
                    'name'  => 'IDCORR', 
                    'value' => $idCorresponsalRE, 
                    'type'  => 'i'
                ),
                array(
                    'name'  => 'NOMBRE', 
                    'value' => $sNombre, 
                    'type'  => 's'
                ),
                array(
                    'name'  => 'APELLIDOS', 
                    'value' => $sApellidos, 
                    'type'  => 's'
                )
            );

            $oWdb->setSDatabase('redefectiva');
            $oWdb->setSStoredProcedure('SPE_ALTAOPERADOR_AQUIMP');
            $oWdb->setParams($array_params);
            $result = $oWdb->execute();

            if($result['nCodigo'] == 0){
                $data = $oWdb->fetchAll();
            }
            $oWdb->closeStmt();
            
            echo json_encode($data);
        }
    // ***********************************

    // registra información de cliente a migrar.
        function setMigracionServicios(){
            
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $nidCadenaRE = (!empty($_POST["nidCadenaRE"]))? $_POST["nidCadenaRE"] : 0;
            $sCadena = (!empty($_POST["sCadena"]))? $_POST["sCadena"] : '';
            $sRazonSocial = (!empty($_POST["sRazonSocial"]))? $_POST["sRazonSocial"] : '';
            $sCorresponsal = (!empty($_POST["sCorresponsal"]))? $_POST["sCorresponsal"] : '';
            $sNombre = (!empty($_POST["sNombre"]))? $_POST["sNombre"] : '';
            $sPaterno = (!empty($_POST["sPaterno"]))? $_POST["sPaterno"] : '';
            $sMaterno = (!empty($_POST["sMaterno"]))? $_POST["sMaterno"] : '';
            $sCorreo = (!empty($_POST["sCorreo"]))? $_POST["sCorreo"] : '';
            $telefono = (!empty($_POST["telefono"]))? $_POST["telefono"] : '0';
            $sUsuario = (!empty($_POST["sUsuario"]))? $_POST["sUsuario"] : '0';
            $sContrasena = (!empty($_POST["sContrasena"]))? $_POST["sContrasena"] : '12345';
            $tipoPersona = (!empty($_POST["tipoPersona"]))? $_POST["tipoPersona"] : 3;
            $sCURP = (!empty($_POST["sCURP"]))? $_POST["sCURP"] : '0';
            $nIdTipoIdentif = (!empty($_POST["nIdTipoIdentif"]))? $_POST["nIdTipoIdentif"] : 0;
            $nNumIdentif = (!empty($_POST["nNumIdentif"]))? $_POST["nNumIdentif"] : '0';
            $nFigPolitica = (!empty($_POST["nFigPolitica"]))? $_POST["nFigPolitica"] : 0;
            $nIdTipoForeloCliente = (!empty($_POST["nIdTipoForeloCliente"]))? $_POST["nIdTipoForeloCliente"] : 0;
            $nIdSubCadenaRE = (!empty($_POST["nIdSubCadenaRE"]))? $_POST["nIdSubCadenaRE"] : 0;
            $nIdCorresponsalRE = (!empty($_POST["nIdCorresponsalRE"]))? $_POST["nIdCorresponsalRE"] : 0;
            $nIdOperadorRE = (!empty($_POST["nIdOperadorRE"]))? $_POST["nIdOperadorRE"] : 0;
            $sNumCuenta = (!empty($_POST["sNumCuenta"]))? $_POST["sNumCuenta"] : '';
            $sReferencia = (!empty($_POST["sReferencia"]))? $_POST["sReferencia"] : '';
            $sRFC = (!empty($_POST["sRFC"]))? $_POST["sRFC"] : '';
            $nSerie = (!empty($_POST["nSerie"]))? $_POST["nSerie"] : '0';
            $nIdCadenaAMP = (!empty($_POST["idCadenaAMP"]))? $_POST["idCadenaAMP"] : '0';
            $nIdSucursalAMP = (!empty($_POST["idSucursalAMP"]))? $_POST["idSucursalAMP"] : '0';
            $nIdUsuarioAMP = (!empty($_POST["idUsuarioAMP"]))? $_POST["idUsuarioAMP"] : '0';
            $sCodigoAccesoCorresponsal = (!empty($_POST["codigoAccesoCorresponsal"]))? $_POST["codigoAccesoCorresponsal"] : '0';

            $array_params= array(
                'CknIdSubCadenaRE' => $nIdSubCadenaRE, 
                'CknIdCorresponsalRE' => $nIdCorresponsalRE, 
                'CknIdOperadorRE' => $nIdOperadorRE,
                'CkNumCuentaForelo' => $sNumCuenta,
                'CksReferencia' => $sReferencia,
                'CkRFC' => $sRFC,
                'CksSerie' => $nSerie,
                'CknIdCadenaAMP' => $nIdCadenaAMP,
                'CknIdSucursalAMP' => $nIdSucursalAMP,
                'CknIdUsuarioAMP' => $nIdUsuarioAMP
            );

            // *** WS ***
            $respuesta = null;
            $respuesta =(array)$client->SetComplementoMigracionREAMP($array_params); // OK

            $data = array();
            if($respuesta != null){
                if($respuesta['SetComplementoMigracionREAMPResult']->ErrorCode == 0 ){
                    if(isset($respuesta['SetComplementoMigracionREAMPResult']->Model->anyType->enc_value)){
                        $data[] = $respuesta['SetComplementoMigracionREAMPResult']->Model->anyType->enc_value;
                    }
                }else{ // error
                    $data[] = $respuesta['SetComplementoMigracionREAMPResult']->ErrorCode;
                }
            }
            
            echo json_encode($data);
        }
    // ********************************************

    // Mapeo de corresponsales encontrados en tabla conf_acceso_agencia
        function setMapeoCorresponsalesRE(){
            // 1. Consultar primero los id de sucursales del mapeo de agencias-sucursales AMP.
            // 2. Con los id de sucursales, registrar mapeo de corresponsales-sucursales segun la relacion con agencia.

            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $resp = (!empty($_POST["resp"]))? $_POST["resp"] : 0;
            
            $data = array();

            for($i=0; $i<count($resp); $i++)
            {
                // *** WS ***
                    $array_params = null;
                    $array_params= array(
                        'Ck_idCorresponsal' => $resp[$i]['idCorresponsal'], 
                        'Ck_idAgente' => $resp[$i]['idAgente'], 
                        'Ck_idAgencia' => $resp[$i]['idAgencia']
                    );
        
                    $respuesta = null;
                    $respuesta =(array)$client->SetMapSucComplementoRE($array_params); // OK
        
                    if($respuesta != null){
                        if($respuesta['MapeoOperadorResult']->ErrorCode == 0){
                            $data = $respuesta['MapeoOperadorResult']->ErrorMessage;
                        }else{ // error
                            $data = 0;
                        }
                    }
                // *** *** ***
            }
            echo json_encode($data);
        }
    // *** *** ***

    // Migracion Remesas 
        function setDataMigracionRemesas(){
            ini_set("soap.wsdl_cache_enabled", "0");
            include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
            include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSREAMP.php"); 

            $idAgenteTD = (!empty($_POST["idAgente"]))? $_POST["idAgente"] : 0;
            $dataRelacion = array();
            
            // *** consultar relacion agencias - corresponsales ***
                $array_params = null;    
                $array_params = array(
                    array(
                        'name'  => 'Ck_nIdAgente', 
                        'value' => $idAgenteTD, 
                        'type'  =>'i'
                    )
                );

                $oRdb->setSDatabase('redefectiva');
                $oRdb->setSStoredProcedure('sp_select_corresponsales_agencias');
                $oRdb->setParams($array_params);
                $result = $oRdb->execute();

                $data = array();
                if($result['nCodigo'] == 0){
                    $data = $oRdb->fetchAll();
                }
                $oRdb->closeStmt();
                $dataRelacion = $data;
            // ********************************************************

            // *** Consultar mapeo AMP - RE ***
                if( is_array($dataRelacion) )
                {
                    for($i=0; $i<count($dataRelacion); $i++)
                    {
                        // *** WS ***
                        $array_params = null;   
                        $array_params= array(
                            'Ck_nIdCorresponsal' => $dataRelacion[$i]['idCorresponsal']
                        );

                        $respuesta = null;
                        $respuesta =(array) $client->getMapeoSucursalAMPRE($array_params);  // OK

                        $data = array();
                        if( isset($respuesta['getMapeoSucursalAMPREResult']->ErrorCode) && $respuesta['getMapeoSucursalAMPREResult']->ErrorCode == 0){
                            $data = $respuesta['getMapeoSucursalAMPREResult']->Model->anyType->enc_value;
                        }

                        $dataRelacion[$i]['nIdSucursalAMP'] = $data->nIdSucursalAMP;
                        $dataRelacion[$i]['nIdCadenaAMP'] = $data->nIdCadenaAMP;

                        // **********
                    }
                }
            // *********************************
            // *** Registro mapeo agente ***
                if( is_array($dataRelacion) )
                {
                    if(isset($dataRelacion[0]['nIdCadenaAMP']))
                    {
                        // *** WS ***
                        $array_params = null;   
                        $array_params= array(
                            'CknIdAgente' => $idAgenteTD,
                            'CKnIdCadena' => $dataRelacion[0]['nIdCadenaAMP']
                        );

                        $respuesta = null;
                        $respuesta =(array) $client->setMapeoTDAgenteCadenaREAMP($array_params);  // OK

                        $data = array();
                        if( isset($respuesta['setMapeoTDAgenteCadenaREAMPResult']->ErrorCode) && $respuesta['setMapeoTDAgenteCadenaREAMPResult']->ErrorCode == 0){
                            $data = $respuesta['setMapeoTDAgenteCadenaREAMPResult']->Model->anyType->enc_value;
                        }

                        // **********
                    }
                }
            // *****************************

            // validar si registro fue exitoso

            // *** Registro mapeo agencias ***
            
                if( is_array($dataRelacion) && isset($data->errorCode)  )
                {
                    if($data->errorCode == 0)
                    {
                        for($i=0; $i<count($dataRelacion); $i++)
                        {
                            // *** WS ***
                            $array_params = null;   
                            $array_params= array(
                                'CknIdAgente' => $idAgenteTD, 
                                'CKnIdCadena' => $dataRelacion[$i]['nIdCadenaAMP'], 
                                'CKnIdAgencia' => $dataRelacion[$i]['idAgencia'], 
                                'CKnIdSucursal' => $dataRelacion[$i]['nIdSucursalAMP'] 
                            );

                            $respuesta = null;
                            $respuesta =(array) $client->setMapeoTDAgenciaSucursalREAMP($array_params);  // OK

                            $data = array();
                            if( isset($respuesta['setMapeoTDAgenciaSucursalREAMPResult']->ErrorCode) && $respuesta['setMapeoTDAgenciaSucursalREAMPResult']->ErrorCode == 0){
                                $data = $respuesta['setMapeoTDAgenciaSucursalREAMPResult']->Model->anyType->enc_value;
                            }
                        }
                    }
                    else
                    {
                        $data = array(
                            "errorCode" => $data->errorCode,
                            "msg" => $data->msg
                        );
                    }
                }
                else
                {
                    $data = array(
                        "errorCode" => 10,
                        "msg" => 'Error en proceso de mapeo de la agencia.'
                    );
                }
            // *******************************

            // *** Consulta Operadores en TD ***
                $array_params = null;
                $array_params = array(
                    array(
                        'name'  => 'Ck_nIdAgenteTD', 
                        'value' => $idAgenteTD, 
                        'type'  =>'i'
                    ),
                    array(
                        'name'  => 'Ck_nFlag', 
                        'value' => 2, // agencias
                        'type'  =>'i'
                    )
                );

                $oWTD->setSDatabase('td_administracion');
                $oWTD->setSStoredProcedure('sp_select_data_migracion_AMP');
                $oWTD->setParams($array_params);
                $result = $oWTD->execute();

                $dataOperadoresTD = array();
                if($result['nCodigo'] == 0){
                    $dataOperadoresTD = $oWTD->fetchAll();
                }
                $oWTD->closeStmt();

            // ******************

            // *** Consulta operadores en AMP **
                // *** WS ***
                $array_params = null;   
                $array_params= array(
                    'Ck_idCadenaAMP' => $dataRelacion[0]['nIdCadenaAMP'], 
                );

                $respuesta = null;
                $respuesta =(array) $client->getMapOperadorREAMP($array_params);  // OK

                $dataOperadoresAMP = array();
                if( isset($respuesta['getMapOperadorREAMPResult']->ErrorCode) && $respuesta['getMapOperadorREAMPResult']->ErrorCode == 0){
                    if(isset( $respuesta['getMapOperadorREAMPResult']->Model->anyType->enc_value )){
                        $dataOperadoresAMP = $respuesta['getMapOperadorREAMPResult']->Model->anyType;
                    }
                    else{
                        $dataOperadoresAMP = $respuesta['getMapOperadorREAMPResult']->Model->anyType;
                    }
                }
                if( is_object($dataOperadoresAMP) ){
                    $dataOperadoresAMP = array($dataOperadoresAMP);
                }

            // *********************************
            // *** Comparativo de Nombres de Operadores entre plataformas ***

                if( is_array($dataOperadoresTD) && (is_array($dataOperadoresAMP)) ){
                    if( isset($dataOperadoresTD[0]['sNombre']) ) // si existe informacion de operdores de TD
                    {
                        $sNomTemp = null;
                        for($i=0; $i<count($dataOperadoresTD); $i++){
                            $sNomTemp = str_replace(" ","",trim( $dataOperadoresTD[$i]['sNombre'].$dataOperadoresTD[$i]['sPaterno'].$dataOperadoresTD[$i]['sMaterno'] ) );
                            $dataOperadoresTD[$i]['sNombreCompleto'] = utf8_encode( strtoupper( $sNomTemp ) );
                            $dataOperadoresTD[$i]['flagMapeo'] = 0;
                            $dataOperadoresTD[$i]['nIdCorresponsalRE'] = 0;
                        }

                        $sNomTemp = null; //$cantRegOperadores = 0;
                        for($i=0; $i<count($dataOperadoresAMP); $i++){
                            $sNomTemp = str_replace(" ","",trim( $dataOperadoresAMP[$i]->enc_value->sNombre.$dataOperadoresAMP[$i]->enc_value->sApellidoPaterno.$dataOperadoresAMP[$i]->enc_value->sApellidoMaterno ) );
                            $dataOperadoresAMP[$i]->enc_value->sNombreCompleto = utf8_encode( strtoupper( $sNomTemp ) );
                            $dataOperadoresAMP[$i]->enc_value->flagMapeo = 0;
                            //$cantRegOperadores++;
                        }
                        
                        if( count($dataOperadoresTD) > count($dataOperadoresAMP) ){ // si los operadores AMP son menos que los de TD
                            for($i=0; $i<count($dataOperadoresTD); $i++){
                                for($a=0; $a<count($dataOperadoresAMP); $a++){
                                    // si es igual el nombre, mapear
                                    if( $dataOperadoresTD[$i]['sNombreCompleto'] == $dataOperadoresAMP[$a]->enc_value->sNombreCompleto )
                                    {
                                        $dataOperadoresTD[$i]['flagMapeo'] = 1;
                                        $dataOperadoresTD[$i]['sUsuario'] = $dataOperadoresAMP[$a]->enc_value->sUsuario;
                                        $dataOperadoresTD[$i]['nIdUsuarioAMP'] = $dataOperadoresAMP[$a]->enc_value->nIdUsuario;
                                        $dataOperadoresTD[$i]['nIdCorresponsalRE'] = $dataOperadoresAMP[$a]->enc_value->nIdCorresponsalRE;

                                        // *** WS ***
                                        $array_params = null;   
                                        $array_params= array(
                                            'Ck_nIdAgente' => $dataOperadoresTD[$i]['nIdAgente'],
                                            'Ck_nIdAgencia' => $dataOperadoresTD[$i]['nIdAgencia'],
                                            'Ck_nIdOperador' => $dataOperadoresTD[$i]['nIdOperador'],
                                            'Ck_nIdUsuario' => $dataOperadoresAMP[$a]->enc_value->nIdUsuario
                                        );

                                        $respuesta = null;
                                        $respuesta =(array) $client->setMapOperadorTDAMP($array_params);  // OK
                                        
                                        $dataRespMapeoOperadores = array();
                                        if( isset($respuesta['setMapOperadorTDAMPResult']->ErrorCode) && $respuesta['setMapOperadorTDAMPResult']->ErrorCode == 0){
                                            if(isset( $respuesta['setMapOperadorTDAMPResult']->Model->anyType->enc_value )){
                                                $dataRespMapeoOperadores = $respuesta['setMapOperadorTDAMPResult']->Model->anyType;
                                            }
                                        }

                                        // Mapeo de usuario en TD
                                        $array_params = null;
                                        $array_params = array(
                                            array(
                                                'name'  => 'CknIdOperador', 
                                                'value' => $dataOperadoresTD[$i]['nIdOperador'], // idOperador TD
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'CknIdUsuario', 
                                                'value' => $dataOperadoresAMP[$a]->enc_value->nIdUsuario, // idUsuario AMP
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'CksUsuario', 
                                                'value' => $dataOperadoresAMP[$a]->enc_value->sUsuario, // cve usuario AMP
                                                'type'  =>'s'
                                            )
                                        );

                                        $oWTD->setSDatabase('td_administracion');
                                        $oWTD->setSStoredProcedure('sp_insert_map_operador_usuario_amp');
                                        $oWTD->setParams($array_params);
                                        $result = $oWTD->execute();
                                        
                                        $dataResp = null;
                                        $dataResp = array();
                                        if($result['nCodigo'] == 0){
                                            $dataResp = $oWTD->fetchAll();
                                        }
                                        $oWTD->closeStmt();


                                        // Actualizar código capacitacion en AMP
                                        $array_params = null;
                                        $array_params= array(
                                            'CknIdOperador' => $dataOperadoresTD[$i]['nIdOperador'], 
                                            'CksCodigoCapacitacion' => $dataOperadoresTD[$i]['CksCodigoCapacitacion'] 
                                        );
                                        $respuesta = null;
                                        $respuesta =(array)$client->SetUpdCodCap($array_params); // OK

                                        $dataUpd = null;
                                        $dataUpd = array();
                                        if($respuesta != null){
                                            if($respuesta['SetUpdCodCapResult']->ErrorCode == 0){
                                                $dataUpd[] = $respuesta['SetUpdCodCapResult']->ErrorMessage;
                                            }else{ // error
                                                $dataUpd[] = 0;
                                            }
                                        }
                                    }
                                    else{ // Registrar en TD y mapear si no es igual

                                        for( $aa=0; $aa<count($dataRelacion); $aa++ ){
                                            $idAgencia = 0;
                                            if( $dataRelacion[$aa]['nIdSucursalAMP'] == $dataOperadoresAMP[$a]->enc_value->nIdSucursal )
                                            {
                                                $idAgencia = $dataRelacion[$aa]['idAgencia'] ;
                                                break;
                                            }
                                        }


                                        $array_params = null;
                                        $array_params = array(
                                            array(
                                                'name'  => 'Ck_nIdEmpleado', 
                                                // 'value' => $_SESSION['idU'], // id empleado
                                                'value' => 19, // solo pruebas
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'Ck_nIdAgente', 
                                                'value' => $dataOperadoresTD[0]['nIdAgente'],
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'Ck_nIdSubAgente', 
                                                'value' => 0,
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'Ck_nIdAgencia', 
                                                'value' => $idAgencia,
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'Ck_sCveOperador', 
                                                'value' => '1',
                                                'type'  =>'s'
                                            ),
                                            array(
                                                'name'  => 'Ck_sNombre', 
                                                'value' => $dataOperadoresAMP[$a]->enc_value->sNombre,
                                                'type'  =>'s'
                                            ),
                                            array(
                                                'name'  => 'Ck_sPaterno', 
                                                'value' => $dataOperadoresAMP[$a]->enc_value->sApellidoPaterno,
                                                'type'  =>'s'
                                            ),
                                            array(
                                                'name'  => 'Ck_sMaterno', 
                                                'value' => $dataOperadoresAMP[$a]->enc_value->sApellidoMaterno,
                                                'type'  =>'s'
                                            ),
                                            array(
                                                'name'  => 'Ck_dFecNacimiento', 
                                                'value' => '2000-01-01',
                                                'type'  =>'s'
                                            )
                                        );

                                        $oWTD->setSDatabase('td_administracion');
                                        $oWTD->setSStoredProcedure('sp_insert_Operador_migracion');
                                        $oWTD->setParams($array_params);
                                        $result = $oWTD->execute();

                                        $dataResp = array();
                                        if($result['nCodigo'] == 0){
                                            $dataResp = $oWTD->fetchAll();
                                        }
                                        $oWTD->closeStmt();

                                        $idOperador = 0;
                                        $idOperador = $dataResp[0]['idOperador'];

                                        include('generarCodigoTD.php');

                                        $array_params = null;
                                        $array_params = array(
                                            array(
                                                'name'  => 'CknIdOperador', 
                                                'value' => $idOperador, // idOperador TD
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'CknIdUsuario', 
                                                'value' => $dataOperadoresAMP[$a]->enc_value->nIdUsuario, // idUsuario AMP
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'CksUsuario', 
                                                'value' => $dataOperadoresAMP[$a]->enc_value->sUsuario, // cve usuario AMP
                                                'type'  =>'s'
                                            )
                                        );

                                        $oWTD->setSDatabase('td_administracion');
                                        $oWTD->setSStoredProcedure('sp_insert_map_operador_usuario_amp');
                                        $oWTD->setParams($array_params);
                                        $result = $oWTD->execute();
                                        
                                        $dataResp = array();
                                        if($result['nCodigo'] == 0){
                                            $dataResp = $oWTD->fetchAll();
                                        }
                                        $oWTD->closeStmt();

                                        // Registrar mapeo de operador TD en AMP

                                        $array_params = null;   
                                        $array_params= array(
                                            'Ck_nIdAgente' => $dataOperadoresTD[0]['nIdAgente'],
                                            'Ck_nIdAgencia' => $idAgencia,
                                            'Ck_nIdOperador' => $idOperador,
                                            'Ck_nIdUsuario' => $dataOperadoresAMP[$a]->enc_value->nIdUsuario
                                        );

                                        $respuesta = null;
                                        $respuesta =(array) $client->setMapOperadorTDAMP($array_params);  // OK

                                        // 3. Actualizar codigo capacit en usuario de AMP
                                        $array_params = null;
                                        $array_params= array(
                                            'CknIdOperador' => $idOperador, 
                                            'CksCodigoCapacitacion' => $genSigCodigo 
                                        );

                                        $respuesta = null;
                                        $respuesta =(array)$client->SetUpdCodCap($array_params); // OK

                                        $dataUpd = null;
                                        $dataUpd = array();
                                        if($respuesta != null){
                                            if($respuesta['SetUpdCodCapResult']->ErrorCode == 0){
                                                $dataUpd[] = $respuesta['SetUpdCodCapResult']->ErrorMessage;
                                            }else{ // error
                                                $dataUpd[] = 0;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else if( count($dataOperadoresTD) < count($dataOperadoresAMP) ){ // si los operadores TD son menos que los de AMP
                            for($i=0; $i<count($dataOperadoresAMP); $i++){
                                for($a=0; $a<count($dataOperadoresTD); $a++){
                                    // si es igual el nombre, mapear
                                    if( $dataOperadoresAMP[$i]->enc_value->sNombreCompleto == $dataOperadoresTD[$a]['sNombreCompleto'] )
                                    {
                                        $dataOperadoresTD[$a]['flagMapeo'] = 1;
                                        $dataOperadoresTD[$a]['sUsuario'] = $dataOperadoresAMP[$i]->enc_value->sUsuario;
                                        $dataOperadoresTD[$a]['nIdUsuarioAMP'] = $dataOperadoresAMP[$i]->enc_value->nIdUsuario;
                                        $dataOperadoresTD[$a]['nIdCorresponsalRE'] = $dataOperadoresAMP[$i]->enc_value->nIdCorresponsalRE;

                                        // *** WS ***
                                        $array_params = null;   
                                        $array_params= array(
                                            'Ck_nIdAgente' => $dataOperadoresTD[$a]['nIdAgente'],
                                            'Ck_nIdAgencia' => $dataOperadoresTD[$a]['nIdAgencia'],
                                            'Ck_nIdOperador' => $dataOperadoresTD[$a]['nIdOperador'],
                                            'Ck_nIdUsuario' => $dataOperadoresAMP[$i]->enc_value->nIdUsuario
                                        );

                                        $respuesta = null;
                                        $respuesta =(array) $client->setMapOperadorTDAMP($array_params);  // OK

                                        $dataRespMapeoOperadores = array();
                                        if( isset($respuesta['setMapOperadorTDAMPResult']->ErrorCode) && $respuesta['setMapOperadorTDAMPResult']->ErrorCode == 0){
                                            if(isset( $respuesta['setMapOperadorTDAMPResult']->Model->anyType->enc_value )){
                                                $dataRespMapeoOperadores = $respuesta['setMapOperadorTDAMPResult']->Model->anyType;
                                            }
                                        }

                                        // Mapeo de usuario en TD
                                        $array_params = null;
                                        $array_params = array(
                                            array(
                                                'name'  => 'CknIdOperador', 
                                                'value' => $dataOperadoresTD[$a]['nIdOperador'], // idOperador TD
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'CknIdUsuario', 
                                                'value' => $dataOperadoresAMP[$i]->enc_value->nIdUsuario, // idUsuario AMP
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'CksUsuario', 
                                                'value' => $dataOperadoresAMP[$i]->enc_value->sUsuario, // cve usuario AMP
                                                'type'  =>'s'
                                            )
                                        );

                                        $oWTD->setSDatabase('td_administracion');
                                        $oWTD->setSStoredProcedure('sp_insert_map_operador_usuario_amp');
                                        $oWTD->setParams($array_params);
                                        $result = $oWTD->execute();
                                        
                                        $dataResp = null;
                                        $dataResp = array();
                                        if($result['nCodigo'] == 0){
                                            $dataResp = $oWTD->fetchAll();
                                        }
                                        $oWTD->closeStmt();



                                        // Actualizar código capacitacion en AMP
                                        $array_params = null;
                                        $array_params= array(
                                            'CknIdOperador' => $dataOperadoresTD[$a]['nIdOperador'], 
                                            'CksCodigoCapacitacion' => $dataOperadoresTD[$a]['CksCodigoCapacitacion'] 
                                        );
                                        $respuesta = null;
                                        $respuesta =(array)$client->SetUpdCodCap($array_params); // OK

                                        $dataUpd = null;
                                        $dataUpd = array();
                                        if($respuesta != null){
                                            if($respuesta['SetUpdCodCapResult']->ErrorCode == 0){
                                                $dataUpd[] = $respuesta['SetUpdCodCapResult']->ErrorMessage;
                                            }else{ // error
                                                $dataUpd[] = 0;
                                            }
                                        }
                                    }
                                    else{ // Registrar en TD y mapear si no es igual
                                        /*
                                        * Paso 1. Preparar la info 
                                        * Considerar: id agencia mapeada entre AMP y TD.
                                        * Paso 2. Registrar la info en TD
                                        * Asegurar codigos de acceso
                                        */
                                        for( $aa=0; $aa<count($dataRelacion); $aa++ ){
                                            $idAgencia = 0;
                                            if( $dataRelacion[$aa]['nIdSucursalAMP'] == $dataOperadoresAMP[$i]->enc_value->nIdSucursal )
                                            {
                                                $idAgencia = $dataRelacion[$aa]['idAgencia'] ;
                                                break;
                                            }
                                        }

                                        $array_params = null;
                                        $array_params = array(
                                            array(
                                                'name'  => 'Ck_nIdEmpleado', 
                                                // 'value' => $_SESSION['idU'], // id empleado
                                                'value' => 19, // solo pruebas
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'Ck_nIdAgente', 
                                                'value' => $dataOperadoresTD[0]['nIdAgente'],
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'Ck_nIdSubAgente', 
                                                'value' => 0,
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'Ck_nIdAgencia', 
                                                'value' => $idAgencia,
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'Ck_sCveOperador', 
                                                'value' => '1',
                                                'type'  =>'s'
                                            ),
                                            array(
                                                'name'  => 'Ck_sNombre', 
                                                'value' => $dataOperadoresAMP[$i]->enc_value->sNombre,
                                                'type'  =>'s'
                                            ),
                                            array(
                                                'name'  => 'Ck_sPaterno', 
                                                'value' => $dataOperadoresAMP[$i]->enc_value->sApellidoPaterno,
                                                'type'  =>'s'
                                            ),
                                            array(
                                                'name'  => 'Ck_sMaterno', 
                                                'value' => $dataOperadoresAMP[$i]->enc_value->sApellidoMaterno,
                                                'type'  =>'s'
                                            ),
                                            array(
                                                'name'  => 'Ck_dFecNacimiento', 
                                                'value' => '2000-01-01',
                                                'type'  =>'s'
                                            )
                                        );


                                        $oWTD->setSDatabase('td_administracion');
                                        $oWTD->setSStoredProcedure('sp_insert_Operador_migracion');
                                        $oWTD->setParams($array_params);
                                        $result = $oWTD->execute();

                                        $dataResp = array();
                                        if($result['nCodigo'] == 0){
                                            $dataResp = $oWTD->fetchAll();
                                        }
                                        $oWTD->closeStmt();

                                        $idOperador = 0;
                                        $idOperador = $dataResp[0]['idOperador'];


                                        include('generarCodigoTD.php');

                                        $array_params = null;
                                        $array_params = array(
                                            array(
                                                'name'  => 'CknIdOperador', 
                                                'value' => $idOperador, // idOperador TD
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'CknIdUsuario', 
                                                'value' => $dataOperadoresAMP[$i]->enc_value->nIdUsuario, // idUsuario AMP
                                                'type'  =>'i'
                                            ),
                                            array(
                                                'name'  => 'CksUsuario', 
                                                'value' => $dataOperadoresAMP[$i]->enc_value->sUsuario, // cve usuario AMP
                                                'type'  =>'s'
                                            )
                                        );


                                        $oWTD->setSDatabase('td_administracion');
                                        $oWTD->setSStoredProcedure('sp_insert_map_operador_usuario_amp');
                                        $oWTD->setParams($array_params);
                                        $result = $oWTD->execute();
                                        
                                        $dataResp = array();
                                        if($result['nCodigo'] == 0){
                                            $dataResp = $oWTD->fetchAll();
                                        }
                                        $oWTD->closeStmt();

                                        // Registrar mapeo de operador TD en AMP

                                        $array_params = null;   
                                        $array_params= array(
                                            'Ck_nIdAgente' => $dataOperadoresTD[0]['nIdAgente'],
                                            'Ck_nIdAgencia' => $idAgencia,
                                            'Ck_nIdOperador' => $idOperador,
                                            'Ck_nIdUsuario' => $dataOperadoresAMP[$i]->enc_value->nIdUsuario
                                        );

                                        $respuesta = null;
                                        $respuesta =(array) $client->setMapOperadorTDAMP($array_params);  // OK

                                        // 3. Actualizar codigo capacit en usuario de AMP

                                        $array_params = null;
                                        $array_params= array(
                                            'CknIdOperador' => $idOperador, 
                                            'CksCodigoCapacitacion' => $genSigCodigo 
                                        );


                                        $respuesta = null;
                                        $respuesta =(array)$client->SetUpdCodCap($array_params); // OK

                                        $dataUpd = null;
                                        $dataUpd = array();
                                        if($respuesta != null){
                                            if($respuesta['SetUpdCodCapResult']->ErrorCode == 0){
                                                $dataUpd[] = $respuesta['SetUpdCodCapResult']->ErrorMessage;
                                            }else{ // error
                                                $dataUpd[] = 0;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else{ // no existen operadores de TD
                        /*
                            Registrar los operadores en TD, mapearlos, colocar sus codigos de capacitacion
                        */
                        for($i=0; $i<count($dataOperadoresAMP); $i++)
                        {
                            for( $aa=0; $aa<count($dataRelacion); $aa++ ){
                                $idAgente = 0;
                                $idAgencia = 0;
                                if( $dataRelacion[$aa]['nIdSucursalAMP'] == $dataOperadoresAMP[$i]->enc_value->nIdSucursal )
                                {
                                    $idAgencia = $dataRelacion[$aa]['idAgencia'];
                                    $idAgente = $dataRelacion[$aa]['idAgente'];
                                    break;
                                }
                            }

                            $array_params = null;
                            $array_params = array(
                                array(
                                    'name'  => 'Ck_nIdEmpleado', 
                                    // 'value' => $_SESSION['idU'], // id empleado
                                    'value' => 19, // solo pruebas
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'Ck_nIdAgente', 
                                    'value' => $idAgente,
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'Ck_nIdSubAgente', 
                                    'value' => 0,
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'Ck_nIdAgencia', 
                                    'value' => $idAgencia,
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'Ck_sCveOperador', 
                                    'value' => '1',
                                    'type'  =>'s'
                                ),
                                array(
                                    'name'  => 'Ck_sNombre', 
                                    'value' => $dataOperadoresAMP[$i]->enc_value->sNombre,
                                    'type'  =>'s'
                                ),
                                array(
                                    'name'  => 'Ck_sPaterno', 
                                    'value' => $dataOperadoresAMP[$i]->enc_value->sApellidoPaterno,
                                    'type'  =>'s'
                                ),
                                array(
                                    'name'  => 'Ck_sMaterno', 
                                    'value' => $dataOperadoresAMP[$i]->enc_value->sApellidoMaterno,
                                    'type'  =>'s'
                                ),
                                array(
                                    'name'  => 'Ck_dFecNacimiento', 
                                    'value' => '2000-01-01',
                                    'type'  =>'s'
                                )
                            );

                            $oWTD->setSDatabase('td_administracion');
                            $oWTD->setSStoredProcedure('sp_insert_Operador_migracion');
                            $oWTD->setParams($array_params);
                            $result = $oWTD->execute();

                            $dataResp = array();
                            if($result['nCodigo'] == 0){
                                $dataResp = $oWTD->fetchAll();
                            }
                            $oWTD->closeStmt();

                            $idOperador = 0;
                            $idOperador = $dataResp[0]['idOperador'];
                            
                            // *** Generar Codigo ***
                                include('generarCodigoTD.php');
                            // **********************

                            $array_params = null;
                            $array_params = array(
                                array(
                                    'name'  => 'CknIdOperador', 
                                    'value' => $idOperador, // idOperador TD
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'CknIdUsuario', 
                                    'value' => $dataOperadoresAMP[$i]->enc_value->nIdUsuario, // idUsuario AMP
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'CksUsuario', 
                                    'value' => $dataOperadoresAMP[$i]->enc_value->sUsuario, // cve usuario AMP
                                    'type'  =>'s'
                                )
                            );

                            $oWTD->setSDatabase('td_administracion');
                            $oWTD->setSStoredProcedure('sp_insert_map_operador_usuario_amp');
                            $oWTD->setParams($array_params);
                            $result = $oWTD->execute();

                            $dataResp = array();
                            if($result['nCodigo'] == 0){
                                $dataResp = $oWTD->fetchAll();
                            }
                            $oWTD->closeStmt();

                            // Registrar mapeo de operador TD en AMP

                            $array_params = null;   
                            $array_params= array(
                                'Ck_nIdAgente' => $idAgente,
                                'Ck_nIdAgencia' => $idAgencia,
                                'Ck_nIdOperador' => $idOperador,
                                'Ck_nIdUsuario' => $dataOperadoresAMP[$i]->enc_value->nIdUsuario
                            );

                            $respuesta = null;
                            $respuesta =(array) $client->setMapOperadorTDAMP($array_params);  // OK

                            // 3. Actualizar codigo capacit en usuario de AMP

                            $array_params = null;
                            $array_params= array(
                                'CknIdOperador' => $idOperador, 
                                'CksCodigoCapacitacion' => $genSigCodigo 
                            );

                            $respuesta = null;
                            $respuesta =(array)$client->SetUpdCodCap($array_params); // OK

                            $dataUpd = null;
                            $dataUpd = array();
                            if($respuesta != null){
                                if($respuesta['SetUpdCodCapResult']->ErrorCode == 0){
                                    $dataUpd[] = $respuesta['SetUpdCodCapResult']->ErrorMessage;
                                }else{ // error
                                    $dataUpd[] = 0;
                                }
                            }
                        }
                    }
                }
            // **************************************************************

            // *** Registro de operadores faltantes en AMP desde TD ***
                if( is_array($dataOperadoresTD) && count($dataOperadoresTD) > 0 )
                {
                    for($i=0; $i<count($dataOperadoresTD); $i++)
                    {
                        if( $dataOperadoresTD[$i]['flagMapeo'] == 1 ){ continue; } 

                        $sUsuario = '';
                        if( isset( $dataOperadoresTD[$i]['sUsuario'] ) ){
                            $sUsuario = trim($dataOperadoresTD[$i]['sUsuario']);
                        }

                        // *** WS ***
                        $array_params = null;   
                        $array_params= array(
                            'CksNombre'             => utf8_encode($dataOperadoresTD[$i]['sNombre']),
                            'CksApellidoPaterno'    => utf8_encode($dataOperadoresTD[$i]['sPaterno']),
                            'CksApellidoMaterno'    => utf8_encode($dataOperadoresTD[$i]['sMaterno']),
                            'CknTelefono'           => $dataOperadoresTD[$i]['sTelefono'],
                            'CksCorreo'             => $dataOperadoresTD[$i]['sEmail'],
                            'CknIdAgente'           => $dataOperadoresTD[$i]['nIdAgente'],
                            'CKnIdAgencia'          => $dataOperadoresTD[$i]['nIdAgencia'],
                            'CKnIdOperador'         => $dataOperadoresTD[$i]['nIdOperador'],
                            'CksCodigoAcceso'       => $dataOperadoresTD[$i]['CksCodigoAcceso'],
                            'CksCodigoCapacitacion' => trim($dataOperadoresTD[$i]['CksCodigoCapacitacion']),
                            'CksUsuario'            => utf8_encode($sUsuario), 
                            'CksContrasena'         => '12345',
                            'CknPerfil'             => 2
                        );

                        $respuesta = null;
                        $respuesta =(array) $client->setOperadoresRemesas($array_params);  // OK
                        
                        $dataRespRegOperadores = array();
                        if( isset($respuesta['SetOperadoresRemesasResult']->ErrorCode) && $respuesta['SetOperadoresRemesasResult']->ErrorCode == 0){
                            if(isset( $respuesta['SetOperadoresRemesasResult']->Model->anyType->enc_value )){
                                $dataRespRegOperadores = $respuesta['SetOperadoresRemesasResult']->Model->anyType->enc_value;

                                    if($dataRespRegOperadores->errorCode == 0){
                                        $dataOperadoresTD[$i]['flagMapeo'] = 1;
                                        $dataOperadoresTD[$i]['sUsuario'] = $dataRespRegOperadores->sUsuario;
                                        $dataOperadoresTD[$i]['nIdUsuarioAMP'] = $dataRespRegOperadores->nIdUsuario;
                                    }
                            }
                        }
                    }
                }
            // ********************************************************

            // *** registro en td_administracion.map_operador_usuario_amp / sp_insert_map_operador_usuario_amp ***
                if( is_array($dataOperadoresTD) && count($dataOperadoresTD) > 0 )
                {
                    for($i=0; $i<count($dataOperadoresTD); $i++)
                    {
                        for($a=0; $a<count($dataRelacion); $a++)
                        {
                            if( $dataOperadoresTD[$i]['nIdAgencia'] == $dataRelacion[$a]['idAgencia'] )
                            {
                                $dataOperadoresTD[$i]['nIdCorresponsalRE'] = $dataRelacion[$a]['idCorresponsal'];
                            }
                        }

                        if($dataOperadoresTD[$i]['flagMapeo'] == 1)
                        {
                            $array_params = null;
                            $array_params = array(
                                array(
                                    'name'  => 'CknIdOperador', 
                                    'value' => $dataOperadoresTD[$i]['nIdOperador'],
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'CknIdUsuario', 
                                    'value' => $dataOperadoresTD[$i]['nIdUsuarioAMP'],
                                    'type'  =>'i'
                                ),
                                array(
                                    'name'  => 'CksUsuario', 
                                    'value' => $dataOperadoresTD[$i]['sUsuario'],
                                    'type'  =>'s'
                                )
                            );
            
                            $oWTD->setSDatabase('td_administracion');
                            $oWTD->setSStoredProcedure('sp_insert_map_operador_usuario_amp');
                            $oWTD->setParams($array_params);
                            $result = $oWTD->execute();
                            
                            
                            $dataResp = array();
                            if($result['nCodigo'] == 0){
                                $dataResp = $oWTD->fetchAll();
                                
                            }
                            $oWTD->closeStmt();

                            // *** Registrar usuarios en webpos ***
                                $array_params = null;
                                $array_params = array(
                                    array(
                                        'name'  => 'IDCORR', 
                                        'value' => $dataOperadoresTD[$i]['nIdCorresponsalRE'], 
                                        'type'  =>'i'
                                    ),
                                    array(
                                        'name'  => 'NOMBRE', 
                                        'value' => $dataOperadoresTD[$i]['sNombre'], 
                                        'type'  =>'s'
                                    ),
                                    array(
                                        'name'  => 'APELLIDOS', 
                                        'value' => trim($dataOperadoresTD[$i]['sPaterno']." ".$dataOperadoresTD[$i]['sMaterno']) , 
                                        'type'  =>'s'
                                    )
                                );

                                $oWdb->setSDatabase('redefectiva');
                                $oWdb->setSStoredProcedure('SPE_ALTAOPERADOR_AQUIMP');
                                $oWdb->setParams($array_params);
                                $result = $oWdb->execute();
                                

                                $data = array();
                                if($result['nCodigo'] == 0){
                                    $data = $oWdb->fetchAll();
                                }
                                $oWdb->closeStmt();

                                // *** Agregar paso de registro mapeo RE ***
                                // *** WS ***
                                if(isset($data[0]['IdOperador']) && $data[0]['IdOperador'] > 0)
                                {
                                    $array_params = null;   
                                    $array_params= array(
                                        'P_nIdOperadorRE'   => $data[0]['IdOperador'], 
                                        'P_nIdOperadorAMP'  => $dataOperadoresTD[$i]['nIdUsuarioAMP']
                                    );
                                    $respuesta = null;
                                    $respuesta =(array) $client->setMapOperadorMigracion($array_params);  // OK
                                }
                            // *** *** ***
                        }
                    }
                }
            // *** *** *** ***

            // *** Actualizar cfg_seguimiento_cadena ***
            // *** WS ***
                $array_params = null;   
                $array_params= array(
                    'Ck_nIdCadena'   => $dataRelacion[0]['nIdCadenaAMP'], 
                    'Ck_nIdSeguimiento'  => 2 
                );

                $respuesta = null;
                $respuesta =(array) $client->updtCfgSegCadenaMigracion($array_params);  // OK

                $data = array();
                if( isset($respuesta['updtCfgSegCadenaMigracionResult']->ErrorCode) && $respuesta['updtCfgSegCadenaMigracionResult']->ErrorCode == 0){
                    if(isset( $respuesta['updtCfgSegCadenaMigracionResult']->Model->anyType->enc_value )){
                        $data = $respuesta['updtCfgSegCadenaMigracionResult']->Model->anyType->enc_value;
                    }
                }
            // *****************************************

            // *** Registrar codigo acceso a sucursales ***
                if( is_array($dataRelacion) )
                {
                    for($i=0; $i<count($dataRelacion); $i++)
                    {
                        // *** WS ***
                        $array_params = null;   
                        $array_params= array(
                            'CK_nIdSucursal'   => $dataRelacion[$i]['nIdSucursalAMP'], 
                            'CK_codigoAcceso'  => $dataRelacion[$i]['Codigo']
                        );

                        $respuesta = null;
                        $respuesta =(array) $client->updtSucCodAcceso($array_params);  // OK


                        $data = array();
                        if( isset($respuesta['updtSucCodAccesoResult']->ErrorCode) && $respuesta['updtSucCodAccesoResult']->ErrorCode == 0){
                            if(isset( $respuesta['updtSucCodAccesoResult']->Model->anyType->enc_value )){
                                $data = $respuesta['updtSucCodAccesoResult']->Model->anyType->enc_value;
                            }
                        }
                    }
                }
            // ********************************************

            echo json_encode($data);
        }
    // *****************

    function _generarSiguienteCodigo($sCodigo, $nCodigos){
        $YEAR			= date('y');
        if($sCodigo == null || $sCodigo == ''){
            $sCodigo	= $YEAR.'ZZZ0000';
            $nCodigos	= 0;
        }
        $baseUltima		= substr($sCodigo, 2, 3);
        $consecutivo	= $nCodigos + 1;
        if(strlen($consecutivo) > 4){
            $consecutivo = 1;
        }
        $sNext			= str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
        $base			= _obtenerSiguienteLetra($baseUltima);
        return $sClave = $YEAR.$base.$sNext;
    }

    function _obtenerSiguienteLetra($letra){
		$siguiente = ++$letra;
		if(strlen($siguiente) >= 4){
			$siguiente = 'AAA';
		}
		return $siguiente;
	} 
?>