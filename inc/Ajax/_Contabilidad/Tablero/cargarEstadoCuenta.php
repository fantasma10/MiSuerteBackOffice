<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	include "../../../PhpExcel/Classes/PhpExcel.php";

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$nIdCfg		= !empty($_POST['nIdCfg'])? $_POST['nIdCfg'] : '';
	$nIdUsuario	= $_SESSION['idU'];

	$oCfgTabla = new StdClass;
	$oCfgTabla->start	= 0;
	$oCfgTabla->limit	= 1;
	$oCfgTabla->sortCol	= 0;
	$oCfgTabla->sortDir	= 'ASC';
	$oCfgTabla->str		= '';

	$oCuenta = new CuentaBancariaContable();
	$oCuenta->setoRdb($oRdb);
	$oCuenta->setoWdb($oWdb);
	$oCuenta->setLOG($LOG);

	$oCuenta->setNIdCfg($nIdCfg);

	$oCuenta->setNIdBanco(0);
	$oCuenta->setNNumCuentaBancaria('');
	$oCuenta->setNNumCuentaContable('');
	$oCuenta->setNIdEstatus(-1);

	$arrRes = $oCuenta->getListaCfg2($oCfgTabla);

	#echo '<pre>'; var_dump($arrRes); echo '</pre>';

	$nNumCuentaBancaria = $arrRes['data'][0]['nNumCuentaBancaria'];
	$nIdBanco			= $arrRes['data'][0]['nIdBanco'];

	#echo '<pre>'; var_dump($nNumCuentaBancaria); echo '</pre>';

	$oEstadoCuenta	= new EstadoCuenta();
	$oEstadoCuenta->setNIdBanco($nIdBanco);
	$oEstadoCuenta->setNNumCuentaBancaria($nNumCuentaBancaria);
	$oEstadoCuenta->setFile($_FILES['sArchivo']);
	$oEstadoCuenta->setORdb($oRdb);
	$oEstadoCuenta->setOWdb($oWdb);
	$oEstadoCuenta->setOLog($LOG);
	//$oEstadoCuenta->setConvenioPaycash($CONVENIO_PAYCASH);

	$oLayoutEstadoCuenta = new LayoutEstadoCuenta();
	$oLayoutEstadoCuenta->setORdb($oRdb);
	$oLayoutEstadoCuenta->setOWdb($oWdb);
	$oLayoutEstadoCuenta->setOLog($LOG);


	$oEstadoCuenta->setOLayoutEstadoCuenta($oLayoutEstadoCuenta);
	$arrRes = $oEstadoCuenta->cargarMovimientos();
	
	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		echo json_encode($arrRes);
		exit();
	}else{
		##codigo para paycash
        ##se modifica esta parte debido al combio de la BD a amazon
		$oRdb->closeStmt();
        $array_params = array(array('name' => 'p_convenio',	'value' => $CONVENIO_PAYCASH,	'type' =>'i'));
		$oRdb->setSDatabase('data_contable');
		$oRdb->setSStoredProcedure('sp_select_movimientos_bancomer');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();

		if ( $result['nCodigo'] ==0){
			$data = $oRdb->fetchAll();
			$oRdb->closeStmt();
			for($i=0;$i<count($data);$i++){

				//inserta el movimiento a al BD de Paycash
				$array_params = array(
					array('name' => 'p_idEstatus',			'value' => $data[$i]["idEstatus"],			'type' =>'i'),
					array('name' => 'p_idRegistro',			'value' => $data[$i]["idRegistro"], 		'type' =>'s'),
					array('name' => 'p_idTipoMov',			'value' => $data[$i]["idTipoMov"], 			'type' =>'i'),
					array('name' => 'p_idTipoTrx',			'value' => $data[$i]["idTipoTrx"], 			'type' =>'i'),
					array('name' => 'p_idBanco',			'value' => $data[$i]["idBanco"], 			'type' =>'i'),
				    array('name' => 'p_idMovimiento',		'value' => $data[$i]["idMovimiento"], 		'type' =>'i'),
				    array('name' => 'p_bReferencia',		'value' => $data[$i]["bReferencia"], 		'type' =>'i'),
					array('name' => 'p_cuenta',				'value' => $data[$i]["cuenta"], 			'type' =>'s'),
					array('name' => 'p_importe',			'value' => $data[$i]["importe"], 			'type' =>'d'),
					array('name' => 'p_referencia',			'value' => $data[$i]["referencia"], 		'type' =>'s'),
					array('name' => 'p_archivo',			'value' => $data[$i]["archivo"], 			'type' =>'s'),
					array('name' => 'p_autorizacion',		'value' => $data[$i]["autorizacion"], 		'type' =>'i'),
					array('name' => 'p_nIdPoliza',			'value' => $data[$i]["nIdPoliza"], 			'type' =>'i'),
					array('name' => 'p_nSaldo',				'value' => $data[$i]["nSaldo"], 			'type' =>'i'),
					array('name' => 'p_nIdDeposito',		'value' => $data[$i]["nIdDeposito"], 		'type' =>'i'),
					array('name' => 'p_nIdUsuario',			'value' => $data[$i]["nIdUsuario"], 		'type' =>'i'),
					array('name' => 'p_nNumAutorizaciones',	'value' => $data[$i]["nNumAutorizaciones"], 'type' =>'i'),
					array('name' => 'p_fecBanco',			'value' => $data[$i]["fecBanco"], 			'type' =>'s'),
					array('name' => 'p_fecBusqueda',		'value' => $data[$i]["fecBusqueda"], 		'type' =>'s'),
					array('name' => 'p_fecAplicacion',		'value' => $data[$i]["fecAplicacion"],		'type' =>'s'),
					array('name' => 'p_dFecConciliacion',	'value' => $data[$i]["dFecConciliacion"],	'type' =>'s'),
					array('name' => 'p_fecRegistro',		'value' => $data[$i]["fecRegistro"], 		'type' =>'s'),
					array('name' => 'p_fecMovimiento',		'value' => $data[$i]["fecMovimiento"], 		'type' =>'s')
				);
				$oWBDPC->setSDatabase($_SESSION['db']);
				$oWBDPC->setSStoredProcedure('sp_insert_banco_mov');
				$oWBDPC->setParams($array_params);
				$result = $oWBDPC->execute();
			    
				if ( $result['nCodigo'] == 0){
					$data2 = $oWBDPC->fetchAll();
					if($data2[0]['ErrorCode'] == 0){						
				        $array_params = array(
				        	array('name' => 'p_idMovBanco',	'value' => $data[$i]["idMovBanco"],	'type' =>'i'),
				        	array('name' => 'p_convenio',	'value' => $CONVENIO_PAYCASH,		'type' =>'i'));
						$oWdb->setSDatabase('data_contable');
						$oWdb->setSStoredProcedure('sp_update_dat_banco_mov');
						$oWdb->setParams($array_params);
						$result2 = $oWdb->execute();
						$oWdb->closeStmt();
					}
				}
				$oWBDPC->closeStmt();
			}
		}

        $oBancomerPaycash = new movimientosBancomer();
        $oBancomerPaycash->setORdb($oRBDPC);
	    $oBancomerPaycash->setOWdb($oWBDPC);
	    $oBancomerPaycash->setOLog($LOG);
	    $oBancomerPaycash->setURLPC($webService_PC);
	    $oBancomerPaycash->setTokenPC($token_PC);
	    $oBancomerPaycash->setCadenaPC($cadena_PC);

        $arrRes2 = $oBancomerPaycash->procesamovs();
        // var_dump($arrRes2);
        // exit();
        //$oBancomerPaycash = new movimientosBancomer();
        //$oBancomerPaycash->setORdb($oRdb);
	    //$oBancomerPaycash->setOWdb($oWdb);
	    ///$oBancomerPaycash->setOLog($LOG);
       	//$arrRes1 = $oBancomerPaycash->copiamovimientos();
        //$arrRes2 = $oBancomerPaycash->procesamovs(); //se comento por que tiene la liga de produccion    
       	
       	/*codigo para zeropago*/
     	// $oBancomerZeroPago = new CopiaMovimientosBancomerZP(); 
     	// $oBancomerZeroPago->setORdb($oRdb);
	    // $oBancomerZeroPago->setOWdb($oWdb);
	    // $oBancomerZeroPago->setOLog($LOG);
	    // $oBancomerZeroPago->setURLZP($webService_ZP);
	    // $oBancomerZeroPago->setTokenZP($token_B_ZP);
	    // $oBancomerZeroPago->setCadenaZP($cadena_B_ZP);
     	// $arrRes3 = $oBancomerZeroPago->copiamovimientos();    
       	//$arrRes4 = $oBancomerZeroPago->procesamovs(); //se comento por que tiene la liga de produccion  
    }
	$oConciliacion = new Conciliacion();
	$oConciliacion->setORdb($oRdb);
	$oConciliacion->setOWdb($oWdb);
	$oConciliacion->setNIdBanco(0);
	$oConciliacion->setNIdUsuario($nIdUsuario);
	$resultado = $oConciliacion->conciliacionAutomatica();

	/*if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
		echo json_encode($resultado);
		exit();
	}*/

	echo json_encode($arrRes);

?>