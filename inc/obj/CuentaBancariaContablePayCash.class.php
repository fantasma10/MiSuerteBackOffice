<?php

class CuentaBancariaContablePayCash{
	public $nIdCfg				= 0;
	public $nIdBanco			= 0;
	public $nNumCuentaBancaria;
	public $nNumCuentaContable;
	public $nIdUsuario;
	public $nIdEstatus;
	public $nIdUnidadNegocio;
	public $nIdTipoOperacion;
	public $nSaldo;

	public function setNIdUnidadNegocio($value){
		$this->nIdUnidadNegocio = $value;
	}

	public function getNIdUnidadNegocio(){
		return $this->nIdUnidadNegocio;
	}

	public function setNIdTipoOperacion($value){
		$this->nIdTipoOperacion = $value;
	}

	public function getNIdTipoOperacion(){
		return $this->nIdTipoOperacion;
	}

	public function setNSaldo($value){
		$this->nSaldo = $value;
	}

	public function getNSaldo(){
		return $this->nSaldo;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setNIdCfg($value){
		$this->nIdCfg = $value;
	}

	public function getNIdCfg(){
		return $this->nIdCfg;
	}

	public function setNIdBanco($value){
		$this->nIdBanco = $value;
	}

	public function getNIdBanco(){
		return $this->nIdBanco;
	}

	public function setNNumCuentaBancaria($value){
		$this->nNumCuentaBancaria = $value;
	}

	public function getNNumCuentaBancaria(){
		return $this->nNumCuentaBancaria;
	}

	public function setNNumCuentaContable($value){
		$this->nNumCuentaContable = $value;
	}

	public function getNNumCuentaContable(){
		return $this->nNumCuentaContable;
	}

	public function setORdb($oRdb){
		$this->oRdb = $oRdb;
	}

	public function setOWdb($oWdb){
		$this->oWdb = $oWdb;
	}

	public function setLOG($LOG){
		$this->LOG = $LOG;
	}

	public function guardarCfgCuenta(){
		$array_params = array(
			array(
				'name'	=> 'nIdBanco',
				'type'	=> 'i',
				'value'	=> self::getNIdBanco()
			),
			array(
				'name'	=> 'nNumCuentaBancaria',
				'type'	=> 's',
				'value'	=> self::getNNumCuentaBancaria()
			),
			array(
				'name'	=> 'nNumCuentaContable',
				'type'	=> 's',
				'value'	=> self::getNNumCuentaContable()
			),
			array(
				'name'	=> 'nIdUnidadNegocio',
				'type'	=> 'i',
				'value'	=> self::getNIdUnidadNegocio()
			),
			array(
				'name'	=> 'nIdTipoOperacion',
				'type'	=> 'i',
				'value'	=> self::getNIdTipoOperacion()
			),
			array(
				'name'	=> 'nSaldo',
				'type'	=> 'd',
				'value'	=> 0
			),
			array(
				'name'	=> 'nIdUsuario',
				'type'	=> 'i',
				'value'	=> self::getNIdUsuario()
			)
		);


		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_INSERT_CFGCUENTA');
		$this->oWdb->setParams($array_params);
		$arrRes = $this->oWdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] > 0){
			return $arrRes;
		}

		$array = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> $array[0]['result_code'] == 0? true : false,
			'nCodigo'			=> $array[0]['result_code'],
			'sMensaje'			=> $array[0]['result_msg'],
			'sMensajeDetallado'	=> 'Ok'
		);
	}# guardarCfgCuenta

	public function actualizarCfgCuenta(){
		$nIdCfg				= self::getNIdCfg();
		$nIdBanco			= self::getNIdBanco();
		$nNumCuentaBancaria	= self::getNNumCuentaBancaria();
		$nNumCuentaContable	= self::getNNumCuentaContable();
		$nIdUsuario			= self::getNIdUsuario();

		$sQUERY = "CALL `redefectiva`.`SP_UPDATE_CFGCUENTA`($nIdCfg, $nIdBanco, '$nNumCuentaBancaria', '$nNumCuentaContable', $nIdUsuario)";
		$SQL = $this->WBD->query($sQUERY);

		$sMsg		= '';
		$arrData	= array();
		$nCodigo	= 0;
		$sMsgError	= '';
		$bExito		= true;

		if(!$this->WBD->error()){
			while($row = mysqli_fetch_assoc($SQL)){
				$arrData = $row;
			}
			$nCodigo	= $arrData['result_code'];
			$sMsg		= $arrData['result_msg'];
		}
		else{
			$sMsgError = $this->WBD->error();
			$bExito		= false;
			$nCodigo	= $this->WBD->LINK->errno;

			$this->LOG->error($sMsgError);
		}

		return array(
			'bExito'	=> $bExito,
			'nCodigo'	=> $nCodigo,
			'sMsg'		=> $sMsg,
			'sMsgError'	=> $sMsgError,
			'data'		=> $arrData
		);
	}# guardarCfgCuenta

	/*
		Funcion para cargar la lista de configuraciones en una datatable
	*/
	public function getListaCfg($oCfgTabla){
		$nIdCfg				= self::getNIdCfg();
		$nIdBanco			= self::getNIdBanco();
		$nNumCuentaBancaria	= self::getNNumCuentaBancaria();
		$nNumCuentaContable	= self::getNNumCuentaContable();
		$nIdEstatus			= self::getNIdEstatus();

		$str		= utf8_decode($oCfgTabla->str);
		$start		= $oCfgTabla->start;
		$limit		= $oCfgTabla->limit;
		$sortCol	= $oCfgTabla->sortCol;
		$sortDir	= $oCfgTabla->sortDir;

		$sQUERY	= "CALL `redefectiva`.`SP_SELECT_CFGCUENTA`('$nIdCfg','$nIdBanco','$nNumCuentaBancaria','$nNumCuentaContable', '$nIdEstatus','$str','$start','$limit','$sortCol','$sortDir')";
		#echo '<pre>'; var_dump($sQUERY); echo '</pre>';
		$SQL	= $this->RBD->query($sQUERY);

		$sMsg		= '';
		$arrData	= array();
		$nCodigo	= 0;
		$sMsgError	= '';
		$bExito		= true;

		if(!$this->RBD->error()){
			while($row = mysqli_fetch_assoc($SQL)){

				$accion = $row['nIdEstatus'] == 0? "<a href='#' onclick='eliminarCfg(\"".$row['nIdCfg']."\", event);'>Eliminar</a>" : "<a href='#' onclick='activarCfg(\"".$row['nIdCfg']."\", event);'>Activar</a>";
				$editar = "<a href='#' onclick='editarCfg(\"".$row['nIdCfg']."\", event);'>Editar</a>";
				$arrData[] = array(
					utf8_encode($row['sNombreBanco']),
					$row['nNumCuentaBancaria'],
					$row['nNumCuentaContable'],
					$row['sNombreEstatus'],
					"<div>".$accion." | ".$editar."</div>"
				);
			}
		}
		else{
			$sMsgError = $this->RBD->error();
			$bExito		= false;
			$nCodigo	= $this->RBD->LINK->errno;

			$this->LOG->error($sMsgError);
		}

		return array(
			'bExito'	=> $bExito,
			'nCodigo'	=> $nCodigo,
			'sMsg'		=> $sMsg,
			'sMsgError'	=> $sMsgError,
			'data'		=> $arrData
		);
	}# getListaCfg+

	public function getListaCfg2($oCfgTabla){
		$array_params = array(
			array(
				'name'	=> 'nIdCfg',
				'value'	=> self::getNIdCfg(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdBanco',
				'value'	=> self::getNIdBanco(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nNumCuentaBancaria',
				'value'	=> self::getNNumCuentaBancaria(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nNumCuentaContable',
				'value'	=> self::getNNumCuentaContable(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdUnidadNegocio',
				'value'	=> self::getNIdUnidadNegocio(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdTipoOperacion',
				'value'	=> self::getNIdTipoOperacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'str',
				'value'	=> utf8_decode($oCfgTabla->str),
				'type'	=> 's'
			),
			array(
				'name'	=> 'start',
				'value'	=> $oCfgTabla->start,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'limit',
				'value'	=> $oCfgTabla->limit,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sortCol',
				'value'	=> $oCfgTabla->sortCol,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sortDir',
				'value'	=> $oCfgTabla->sortDir,
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_SELECT_CFGCUENTA');
		$this->oRdb->setParams($array_params);

		$arrRes	= $this->oRdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			$data = array();
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	}# getListaCfg+

	public function eliminarCfg(){
		$nIdCfg = self::getNIdCfg();

		$sQuery = "CALL `redefectiva`.`SP_DELETE_CFGCUENTA`('".$nIdCfg."')";
		$SQL	= $this->WBD->query($sQuery);

		$sMsg		= '';
		$arrData	= array();
		$nCodigo	= 0;
		$sMsgError	= '';
		$bExito		= true;

		if(!$this->WBD->error()){
			$sMsg = "Operación Exitosa";
		}
		else{
			$sMsgError	= $this->WBD->error();
			$bExito		= false;
			$nCodigo	= $this->WBD->LINK->errno;
			$sMsg		= "No ha sido posible realizar la operación";
			$this->LOG->error($sMsgError);
		}

		return array(
			'bExito'	=> $bExito,
			'nCodigo'	=> $nCodigo,
			'sMsg'		=> $sMsg,
			'sMsgError'	=> $sMsgError,
			'data'		=> $arrData
		);
	} # eliminarCfg

	public function activarCfg(){
		$nIdCfg = self::getNIdCfg();

		$sQuery = "CALL `redefectiva`.`SP_ACTIVAR_CFGCUENTA`('".$nIdCfg."')";
		$SQL	= $this->WBD->query($sQuery);

		$sMsg		= '';
		$arrData	= array();
		$nCodigo	= 0;
		$sMsgError	= '';
		$bExito		= true;

		if(!$this->WBD->error()){
			$sMsg = "Operación Exitosa";
		}
		else{
			$sMsgError	= $this->WBD->error();
			$bExito		= false;
			$nCodigo	= $this->WBD->LINK->errno;
			$sMsg		= "No ha sido posible realizar la operación";
			$this->LOG->error($sMsgError);
		}

		return array(
			'bExito'	=> $bExito,
			'nCodigo'	=> $nCodigo,
			'sMsg'		=> $sMsg,
			'sMsgError'	=> $sMsgError,
			'data'		=> $arrData
		);
	} # activarCfg

	public function obtenerListaCfgEstadoCuenta(){
		$nIdCfg				= self::getNIdCfg();
		$nIdBanco			= self::getNIdBanco();
		$nNumCuentaBancaria	= self::getNNumCuentaBancaria();
		$nNumCuentaContable	= self::getNNumCuentaContable();
		$nIdEstatus			= self::getNIdEstatus();

		$str		= '';
		$start		= 0;
		$limit		= 1000;
		$sortCol	= 0;
		$sortDir	= 'ASC';

		$sQUERY	= "CALL `redefectiva`.`SP_SELECT_CFGCUENTA`('$nIdCfg','$nIdBanco','$nNumCuentaBancaria','$nNumCuentaContable', '$nIdEstatus','$str','$start','$limit','$sortCol','$sortDir')";

		$SQL	= $this->RBD->query($sQUERY);

		$sMsg		= '';
		$arrData	= array();
		$nCodigo	= 0;
		$sMsgError	= '';
		$bExito		= true;

		if(!$this->RBD->error()){
			while($row = mysqli_fetch_assoc($SQL)){

				$arrData[] = array(
					'sNombreBanco'			=> utf8_encode($row['sNombreBanco']),
					'nNumCuentaBancaria'	=> $row['nNumCuentaBancaria'],
					'nNumCuentaContable'	=> $row['nNumCuentaContable'],
					'nIdCfg'				=> $row['nIdCfg'],
					'nIdBanco'				=> $row['nIdBanco']
				);
			}
		}
		else{
			$sMsgError = $this->RBD->error();
			$bExito		= false;
			$nCodigo	= $this->RBD->LINK->errno;

			$this->LOG->error($sMsgError);
		}

		return array(
			'bExito'	=> $bExito,
			'nCodigo'	=> $nCodigo,
			'sMsg'		=> $sMsg,
			'sMsgError'	=> $sMsgError,
			'data'		=> $arrData
		);
	}

	public function obtenerCuentaBancaria(){
		$array_params = array(
			array(
				'name'	=> 'nIdUnidadNegocio',
				'type'	=> 'i',
				'value'	=> self::getNIdUnidadNegocio()
			),
			array(
				'name'	=> 'nIdTipoOperacion',
				'type'	=> 'i',
				'value'	=> self::getNIdTipoOperacion()
			)
		);

		$this->oRdb->setSDatabase($_SESSION['db']);
		$this->oRdb->setSStoredProcedure('sp_select_cuentabancaria');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();

		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # obtenerCuentaBancaria
} # CuentaBancariaContable



?>