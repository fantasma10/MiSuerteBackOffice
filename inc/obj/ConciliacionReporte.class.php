<?php

class ConciliacionReporte{

	public $nIdNivelConciliacion;
	public $sNombreCadena;
	public $nIdSubCadena;
	public $nIdCorresponsal;
	public $sNombreSubCadena;
	public $sNombreCorresponsal;
	public $nIdCorte;
	public $nIdEstatus;
	public $nIdCadena;
	public $nIdPoliza;
	public $corte_nOperaciones;
	public $corte_nMonto;
	public $corte_nComision;
	public $corte_nComisionEspecial;
	public $corte_dFecha;
	public $nIdArchivo;
	public $sNombreArchivo;
	public $archivo_nOperaciones;
	public $archivo_nMonto;
	public $archivo_nComision;
	public $archivo_nComisionEspecial;
	public $diferencia_nOperaciones;
	public $diferencia_nMonto;
	public $diferencia_nComision;
	public $diferencia_nComisionEspecial;
	public $oRdb;
	public $oWdb;

	public function setNIdNivelConciliacion($value){
		$this->nIdNivelConciliacion = $value;
	}

	public function getNIdNivelConciliacion(){
		return $this->nIdNivelConciliacion;
	}
	public function setSNombreCadena($value){
		$this->sNombreCadena = $value;
	}

	public function getSNombreCadena(){
		return $this->sNombreCadena;
	}

	public function setNIdSubCadena($value){
		$this->nIdSubCadena = $value;
	}

	public function getNIdSubCadena(){
		return $this->nIdSubCadena;
	}

	public function setNIdCorresponsal($value){
		$this->nIdCorresponsal = $value;
	}

	public function getNIdCorresponsal(){
		return $this->nIdCorresponsal;
	}

	public function setSNombreSubCadena($value){
		$this->sNombreSubCadena = $value;
	}

	public function getSNombreSubCadena(){
		return $this->sNombreSubCadena;
	}

	public function setSNombreCorresponsal($value){
		$this->sNombreCorresponsal = $value;
	}

	public function getSNombreCorresponsal(){
		return $this->sNombreCorresponsal;
	}

	public function setNIdCorte($value){
		$this->nIdCorte = $value;
	}

	public function getNIdCorte(){
		return $this->nIdCorte;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNIdCadena($value){
		$this->nIdCadena = $value;
	}

	public function getNIdCadena(){
		return $this->nIdCadena;
	}

	public function setNIdPoliza($value){
		$this->nIdPoliza = $value;
	}

	public function getNIdPoliza(){
		return $this->nIdPoliza;
	}

	public function setCorte_nOperaciones($value){
		$this->corte_nOperaciones = $value;
	}

	public function getCorte_nOperaciones(){
		return $this->corte_nOperaciones;
	}

	public function setCorte_nMonto($value){
		$this->corte_nMonto = $value;
	}

	public function getCorte_nMonto(){
		return $this->corte_nMonto;
	}

	public function setCorte_nComision($value){
		$this->corte_nComision = $value;
	}

	public function getCorte_nComision(){
		return $this->corte_nComision;
	}

	public function setCorte_nComisionEspecial($value){
		$this->corte_nComisionEspecial = $value;
	}

	public function getCorte_nComisionEspecial(){
		return $this->corte_nComisionEspecial;
	}

	public function setCorte_dFecha($value){
		$this->corte_dFecha = $value;
	}

	public function getCorte_dFecha(){
		return $this->corte_dFecha;
	}

	public function setNIdArchivo($value){
		$this->nIdArchivo = $value;
	}

	public function getNIdArchivo(){
		return $this->nIdArchivo;
	}

	public function setSNombreArchivo($value){
		$this->sNombreArchivo = $value;
	}

	public function getSNombreArchivo(){
		return $this->sNombreArchivo;
	}

	public function setArchivo_nOperaciones($value){
		$this->archivo_nOperaciones = $value;
	}

	public function getArchivo_nOperaciones(){
		return $this->archivo_nOperaciones;
	}

	public function setArchivo_nMonto($value){
		$this->archivo_nMonto = $value;
	}

	public function getArchivo_nMonto(){
		return $this->archivo_nMonto;
	}

	public function setArchivo_nComision($value){
		$this->archivo_nComision = $value;
	}

	public function getArchivo_nComision(){
		return $this->archivo_nComision;
	}

	public function setArchivo_nComisionEspecial($value){
		$this->archivo_nComisionEspecial = $value;
	}

	public function getArchivo_nComisionEspecial(){
		return $this->archivo_nComisionEspecial;
	}

	public function setDiferencia_nOperaciones($value){
		$this->diferencia_nOperaciones = $value;
	}

	public function getDiferencia_nOperaciones(){
		return $this->diferencia_nOperaciones;
	}

	public function setDiferencia_nMonto($value){
		$this->diferencia_nMonto = $value;
	}

	public function getDiferencia_nMonto(){
		return $this->diferencia_nMonto;
	}

	public function setDiferencia_nComision($value){
		$this->diferencia_nComision = $value;
	}

	public function getDiferencia_nComision(){
		return $this->diferencia_nComision;
	}

	public function setDiferencia_nComisionEspecial($value){
		$this->diferencia_nComisionEspecial = $value;
	}

	public function getDiferencia_nComisionEspecial(){
		return $this->diferencia_nComisionEspecial;
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

	public function obtenerDatosReporte($fechaInicial, $fechaFinal){
		switch($this->nIdNivelConciliacion){
			case '1' :
				$resultado = $this->sp_select_corte_cadena($fechaInicial, $fechaFinal);
			break;
			case '2' :
				$resultado = $this->sp_select_corte_subcadena($fechaInicial, $fechaFinal);
			break;
			case '3' :
				$resultado = $this->sp_select_corte_corresponsal($fechaInicial, $fechaFinal);
			break;
		}

		return $resultado;
	} # obtenerDatosReporte

	public function sp_select_corte_cadena($dFechaInicial, $dFechaFinal){
		$array_params = array(
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'dFechaInicial',
				'value'	=> $dFechaInicial,
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> $dFechaFinal,
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_conciliacion_cadena');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			echo json_encode($resultado);
			exit();
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'num_rows'			=> $found_rows
		);
	} # sp_select_corte_cadena

	public function sp_select_corte_subcadena($dFechaInicial, $dFechaFinal){
		$array_params = array(
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdSubCadena',
				'value'	=> self::getNIdSubCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'dFechaInicial',
				'value'	=> $dFechaInicial,
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> $dFechaFinal,
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_corte_subcadena');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			echo json_encode($resultado);
			exit();
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'num_rows'			=> $found_rows
		);
	} # sp_select_corte_subcadena

	public function sp_select_corte_corresponsal($dFechaInicial, $dFechaFinal){
		$array_params = array(
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdSubCadena',
				'value'	=> self::getNIdSubCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdCorresponsal',
				'value'	=> self::getNIdCorresponsal(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'dFechaInicial',
				'value'	=> $dFechaInicial,
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> $dFechaFinal,
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_corte_corresponsal');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			echo json_encode($resultado);
			exit();
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'num_rows'			=> $found_rows
		);
	} # sp_select_corte_corresponsal
} # ConciliacionReporte

?>