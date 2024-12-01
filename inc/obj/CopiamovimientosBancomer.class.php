<?php

class movimientosBancomer{

	public $oRdb;
	public $oWdb;
	public $oLog;
  public $webService_PC;
  public $token_PC;
  public $cadena_PC;


	public function setORdb($value){
		$this->oRdb = $value;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOWdb($value){
		$this->oWdb = $value;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function setOLog($value){
		$this->oLog = $value;
	}

	public function getOLog(){
		return $this->oLog;
	}

  public function setURLPC($value){
    $this->webService_PC = $value;
  }

  public function getURLPC(){
    return $this->webService_PC;
  }

  public function setTokenPC($value){
    $this->token_PC = $value;
  }

  public function getTokenPC(){
    return $this->token_PC;
  }

  public function setCadenaPC($value){
    $this->cadena_PC = $value;
  }

  public function getCadenaPC(){
    return $this->cadena_PC;
  }
	
	# # # # # # # # # # # # # # # # # # # # # # # #

	public function copiamovimientos(){
		$array_params = array();

		$this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase($_SESSION['db']);
		$this->oWdb->setSStoredProcedure('sp_insert_banco_mov_bancomer');
		$this->oWdb->setParams($array_params);
		$arrRes = $this->oWdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$result = $this->oWdb->fetchAll();
		
        

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> $result[0]['cod'] != 0? false : true,
			'nCodigo'			=> $result[0]['cod'],
			'sMensaje'			=> $result[0]['msg'],
			'sMensajeDetallado'	=> $result[0]['msg'],
			'data'				=> array()
		);
	} # copia movimientos

    
	public function procesamovs(){
        $webService = self::getURLPC();
        $token = self::getTokenPC();
        $cadena = self::getCadenaPC();
        $client = new SoapClient($webService);
        
        $array_params = array();
        $this->oWdb->setBDebug(1);
		    $this->oWdb->setSDatabase($_SESSION['db']);
		    $this->oWdb->setSStoredProcedure('sp_select_paycash_movs_procesar');
	     	$this->oWdb->setParams($array_params);
		    $arrRes = $this->oWdb->execute();
        $result = $this->oWdb->fetchAll();
        $this->oWdb->closeStmt();

        foreach($result as $rest){ 
            $idmov = $rest['nIdMovBanco'];
            $importe = $rest['nImporte']*100;
            $referencia = $rest['referencia'];
            
            //echo 'id:'.$idmov.' importe:'.$importe.' Referencia:'.$referencia.'</br>';
                $arrayParametros = array(
                 'Request'=> array(   
                     'Header'    => array(
                            'Cadena'    => $cadena,
                            'Sucursal'  => 0,
                            'Token'     => $token
                      ),
                      'Folio'       => $idmov,
                      'Secuencia'   => $idmov,
                      'Monto'       => $importe,
                      'Comision'    => 0,
                      'Referencia'  => $referencia
                     )
               );
           
            $result = $client->MakePayment($arrayParametros);

            $array = array($result);
            $resultado = $array[0] ->MakePaymentResult; 
            $mensaje =  $resultado -> ErrorMsg; 
            $error =  $resultado -> ErrorCode;  
            if($error == 0){
                
                $array_params = array(
                        array(
                            'name'	=> 'nIdBancoMov',
                            'value'	=> $idmov,
                            'type'	=> 'i'
                             )
                    );
                
                    $this->oWdb->setBDebug(1);
                    $this->oWdb->setSDatabase($_SESSION['db']);
                    $this->oWdb->setSStoredProcedure('sp_update_paycash_movs_estatus');
                    $this->oWdb->setParams($array_params);
                    $arrRes = $this->oWdb->execute();
                    $result = $this->oWdb->fetchAll();
                    $this->oWdb->closeStmt();
                
            }else{
               
               //echo $mensaje.'</br>';
               
               
                 $array_params = array(
                        array(
                            'name'	=> 'nIdBancoMov',
                            'value'	=> $idmov,
                            'type'	=> 'i'
                             ),
                        array(
                            'name'	=> 'sReferencia',
                            'value'	=> $referencia,
                            'type'	=> 's'
                             ),
                        array(
                            'name'	=> 'sError',
                            'value'	=> $mensaje,
                            'type'	=> 's'
                             ),    
                    );
                
                    $this->oWdb->setBDebug(1);
                    $this->oWdb->setSDatabase($_SESSION['db']);
                    $this->oWdb->setSStoredProcedure('sp_insert_paycash_ws_errores');
                    $this->oWdb->setParams($array_params);
                    $arrRes = $this->oWdb->execute();
                    $result = $this->oWdb->fetchAll();
                    $this->oWdb->closeStmt();
               
           }            
        }
        
        
		

	
	} # ejecuta el pago




} # Conciliacion

?>