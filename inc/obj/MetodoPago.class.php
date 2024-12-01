<?php

class MetodoPago{

	public $nIdMetodoPago;
	public $nIdMetodo;
	public $nIdEstatus = 0;
	public $sNombre;
	public $bIndirecta;
	public $nImporteCosto;
	public $nPorcentajeCosto;
	public $nImporteCostoAdicional;
	public $nPorcentajeIVA;
	public $dFecAlta;
	public $dFecMov;
	public $nIdUsuario;
	public $oRdb;
	public $oWdb;
	public $oDiasPago;
	public $array_DiasPago;

	public function setArray_DiasPago($value) {
		$this->array_DiasPago = $value;
	}

	public function getArray_DiasPago() {
		return $this->array_DiasPago;
	}

	public function setNIdMetodoPago($value){
		$this->nIdMetodoPago = $value;
	}

	public function getNIdMetodoPago(){
		return $this->nIdMetodoPago;
	}

	public function setNIdMetodo($value){
		$this->nIdMetodo = $value;
	}

	public function getNIdMetodo(){
		return $this->nIdMetodo;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setSNombre($value){
		$this->sNombre = $value;
	}

	public function getSNombre(){
		return $this->sNombre;
	}

	public function setBIndirecta($value){
		$this->bIndirecta = $value;
	}

	public function getBIndirecta(){
		return $this->bIndirecta;
	}

	public function setNImporteCosto($value){
		$this->nImporteCosto = $value;
	}

	public function getNImporteCosto(){
		return $this->nImporteCosto;
	}

	public function setNPorcentajeCosto($value){
		$this->nPorcentajeCosto = $value;
	}

	public function getNPorcentajeCosto(){
		return $this->nPorcentajeCosto;
	}

	public function setNImporteCostoAdicional($value){
		$this->nImporteCostoAdicional = $value;
	}

	public function getNImporteCostoAdicional(){
		return $this->nImporteCostoAdicional;
	}

	public function setNPorcentajeIVA($value){
		$this->nPorcentajeIVA = $value;
	}

	public function getNPorcentajeIVA(){
		return $this->nPorcentajeIVA;
	}

	public function setDFecAlta($value){
		$this->dFecAlta = $value;
	}

	public function getDFecAlta(){
		return $this->dFecAlta;
	}

	public function setDFecMov($value){
		$this->dFecMov = $value;
	}

	public function getDFecMov(){
		return $this->dFecMov;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

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

	public function setODiasPago($oDiasPago){
		$this->oDiasPago = $oDiasPago;
	}

	public function getODiasPago(){
		return $this->oDiasPago;
	}

	# # # # # # # # # # # # # # # # #

	public function guardar(){

		$array_params = array(
			array(
				'name'	=> 'sNombre',
				'value'	=> self::getSNombre(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'bIndirecta',
				'value'	=> self::getBIndirecta(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nImporteCosto',
				'value'	=> self::getNImporteCosto(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nPorcentajeCosto',
				'value'	=> self::getNPorcentajeCosto(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nImporteCostoAdicional',
				'value'	=> self::getNImporteCostoAdicional(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nPorcentajeIVA',
				'value'	=> self::getNPorcentajeIVA(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nIdMetodoPago',
				'value'	=> self::getNIdMetodo(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_insert_metodopago');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$resultado = $this->oWdb->fetchAll();


		$nIdMetodoPago = $resultado[0]['nIdMetodoPago'];
		$respuesta =+ $resultado[0]['respuesta'];

		if($respuesta == 0){
			$sMensaje = 'Metodo de Pago Guardado Exitosamente';
		}else{
			$sMensaje = 'Valor del metodo de pago duplicado';
		}
		//$nIdMetodoPago = $this->oWdb->lastInsertId();

		self::setNIdMetodoPago($nIdMetodoPago);

		$this->oWdb->closeStmt();

		$resultado = self::guardarDiasPago();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> $sMensaje,
			'sMensajeDetallado'	=> '',
			'data'				=> array(
				'nIdMetodoPago'	=> $nIdMetodoPago
			)
		);
	}# guardar

	public function actualizar(){

		$array_params = array(
			array(
				'name'	=> 'nIdMetodoPago',
				'value'	=> self::getNIdMetodoPago(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sNombre',
				'value'	=> self::getSNombre(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'bIndirecta',
				'value'	=> self::getBIndirecta(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nImporteCosto',
				'value'	=> self::getNImporteCosto(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nPorcentajeCosto',
				'value'	=> self::getNPorcentajeCosto(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nImporteCostoAdicional',
				'value'	=> self::getNImporteCostoAdicional(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nPorcentajeIVA',
				'value'	=> self::getNPorcentajeIVA(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nIdMetodoPago',
				'value'	=> self::getNIdMetodo(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_update_metodopago');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}


		$resultado = $this->oWdb->fetchAll();


		$respuesta =+ $resultado[0]['respuesta'];

		if($respuesta == 0){
			$sMensaje = 'Metodo de Pago Guardado Exitosamente';
		}else{
			$sMensaje = 'Valor del metodo de pago duplicado';
		}


		//$nIdMetodoPago = $this->oWdb->lastInsertId();

		$this->oWdb->closeStmt();

		$resultado = self::guardarDiasPago();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$nIdMetodoPago = self::getNIdMetodoPago();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> $sMensaje,
			'sMensajeDetallado'	=> '',
			'data'				=> array(
				'nIdMetodoPago'	=> $nIdMetodoPago
			)
		);
	}# actualizar

	public function guardarDiasPago(){
		$nIdMetodoPago	= self::getNIdMetodoPago();
		$nIdUsuario		= self::getNIdUsuario();
		$oRdb			= self::getORdb();
		$oWdb			= self::getOWdb();

		$this->oDiasPago->setNIdMetodoPago($nIdMetodoPago);
		$this->oDiasPago->setNIdUsuario($nIdUsuario);
		$this->oDiasPago->setORdb($oRdb);
		$this->oDiasPago->setOWdb($oWdb);

		$resultado = $this->oDiasPago->eliminarDiasPago();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$array_DiasPago = self::getArray_DiasPago();

		foreach($array_DiasPago AS $value){
			$this->oDiasPago->setNIdDia($value);

			$resultado = $this->oDiasPago->insertarDiaPago();

			if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
				break;
				return $resultado;
			}
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> array()
		);
	} # guardarDiasPago

	public function consulta($oCfgTabla){
		$array_params = array(
			array(
				'name'	=> 'nIdMetodoPago',
				'value'	=> self::getNIdMetodoPago(),
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

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_metodopago');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$resultado = $this->oWdb->fetchAll();

		$num_rows = $this->oWdb->numRows();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Lista Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $resultado,
			'num_rows'			=> $num_rows
		);
	} # consulta
} # MetodoPago

?>