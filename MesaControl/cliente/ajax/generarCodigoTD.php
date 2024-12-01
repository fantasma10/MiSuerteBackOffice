<?php
    // function _generarSiguienteCodigo($sCodigo, $nCodigos){
    //     $YEAR			= date('y');
    //     if($sCodigo == null || $sCodigo == ''){
    //         $sCodigo	= $YEAR.'ZZZ0000';
    //         $nCodigos	= 0;
    //     }
    //     $baseUltima		= substr($sCodigo, 2, 3);
    //     $consecutivo	= $nCodigos + 1;
    //     if(strlen($consecutivo) > 4){
    //         $consecutivo = 1;
    //     }
    //     $sNext			= str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
    //     $base			= _obtenerSiguienteLetra($baseUltima);
    //     return $sClave = $YEAR.$base.$sNext;
    // }

    // function _obtenerSiguienteLetra($letra){
	// 	$siguiente = ++$letra;
	// 	if(strlen($siguiente) >= 4){
	// 		$siguiente = 'AAA';
	// 	}
	// 	return $siguiente;
	// } 

	# buscar la ultima capacitacion del operador
    $array_params = null;
    $array_params = array(
        array(
            'name'  => 'Ck_nIdOperador', 
            'value' => $idOperador, 
            'type'  =>'i'
        )
    );

    $dataUltimaCapacitTD = null; $result = null;
    $oWTD->setSDatabase('td_capacitacion');
    $oWTD->setSStoredProcedure('SP_CAPACITACION_ULTIMA_OPERADOR');
    $oWTD->setParams($array_params);
    $result = $oWTD->execute();

    if($result['nCodigo'] == 0){
        $dataUltimaCapacitTD = $oWTD->fetchAll();
    }
    $oWTD->closeStmt();

    # buscar el ultimo codigo del operador
    $array_params = null;
    $array_params = array(
        array(
            'name'  => 'Ck_nIdOperador', 
            'value' => $idOperador, 
            'type'  =>'i'
        )
    );

    $dataUltimoCodigoTD = null;
    $oWTD->setSDatabase('td_administracion');
    $oWTD->setSStoredProcedure('sp_query_OperadorUltimoCodigo');
    $oWTD->setParams($array_params);
    $result = $oWTD->execute();

    if($result['nCodigo'] == 0){
        $dataUltimoCodigoTD = $oWTD->fetchAll();
    }
    $oWTD->closeStmt();

    $bGenerarCodigoCapacitacion = false;

	if(empty($dataUltimaCapacitTD['nIdCapacitacion']) || $dataUltimaCapacitTD['nIdCapacitacion'] == null || $dataUltimaCapacitTD['nIdCapacitacion'] == ''){
		$bGenerarCodigoCapacitacion = true;
	}

    if($bGenerarCodigoCapacitacion)
    {
        $dataMaxOperCodigo = null;
        $oWTD->setSDatabase('td_administracion');
        $oWTD->setSStoredProcedure('sp_query_consultaMaxOperadorCodigoMigracion');
        $oWTD->setParams();
        $result = $oWTD->execute();

        if($result['nCodigo'] == 0){
            $dataMaxOperCodigo = $oWTD->fetchAll();
        }
        $oWTD->closeStmt();

        $sCodigo = $dataMaxOperCodigo[0]['sCodigo'];
        $nCodigos = $dataMaxOperCodigo[0]['nCodigos'];

        $genSigCodigo = null;
        $genSigCodigo = _generarSiguienteCodigo($sCodigo, $nCodigos);

        // *** guardar nuevo codigo ***

        $array_params = null;
        $array_params = array(
            array(
                'name'  => 'Ck_nIdOperador', 
                'value' => $idOperador, 
                'type'  =>'i'
            ),
            array(
                'name'  => 'Ck_sCodigo', 
                'value' => $genSigCodigo, 
                'type'  =>'s'
            ),
            array(
                'name'  => 'Ck_sCodigoSeguro', 
                'value' => md5($genSigCodigo), 
                'type'  =>'s'
            )
        );

        $dataInsertOpCodigo = null;
        $oWTD->setSDatabase('td_capacitacion');
        $oWTD->setSStoredProcedure('SP_INSERT_OPERADORCODIGO_MIGRACION');
        $oWTD->setParams($array_params);
        $result = $oWTD->execute();

        if($result['nCodigo'] == 0){
            $dataInsertOpCodigo = $oWTD->fetchAll();
        }
        $oWTD->closeStmt();

        // *** Guardar nueva capacitacion ***
        $array_params = null;
        $array_params = array(
            array(
                'name'  => 'Ck_nIdOperador', 
                'value' => $idOperador, 
                'type'  =>'i'
            ),
            array(
                'name'  => 'Ck_nIdCurso', 
                'value' => 1, 
                'type'  =>'s'
            ),
            array(
                'name'  => 'Ck_sComentarios', 
                'value' => '', 
                'type'  =>'s'
            )
        );

        $dataInsertOpCapacit = null;
        $oWTD->setSDatabase('td_capacitacion');
        $oWTD->setSStoredProcedure('SP_INSERT_OPERADORCAPACITACION_MIGRACION');
        $oWTD->setParams($array_params);
        $result = $oWTD->execute();

        if($result['nCodigo'] == 0){
            $dataInsertOpCapacit = $oWTD->fetchAll();
        }
        $oWTD->closeStmt();

    }
?>