<?php

class CorteCadena{

	public $sNombreCadena;
	public $nIdCorte;
	public $nIdEstatus;
	public $nIdCadena;
	public $nIdPoliza;
	public $nTotalOperaciones;
	public $nTotalMonto;
	public $nTotalComision;
	public $nTotalComisionEspecial;
	public $dFecha;
	public $oRdb;
	public $oWdb;

	public function setSNombreCadena($value){
		$this->sNombreCadena = $value;
	}

	public function getSNombreCadena(){
		return $this->sNombreCadena;
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

	public function setNTotalOperaciones($value){
		$this->nTotalOperaciones = $value;
	}

	public function getNTotalOperaciones(){
		return $this->nTotalOperaciones;
	}

	public function setNTotalMonto($value){
		$this->nTotalMonto = $value;
	}

	public function getNTotalMonto(){
		return $this->nTotalMonto;
	}

	public function setNTotalComision($value){
		$this->nTotalComision = $value;
	}

	public function getNTotalComision(){
		return $this->nTotalComision;
	}

	public function setNTotalComisionEspecial($value){
		$this->nTotalComisionEspecial = $value;
	}

	public function getNTotalComisionEspecial(){
		return $this->nTotalComisionEspecial;
	}

	public function setDFecha($value){
		$this->dFecha = $value;
	}

	public function getDFecha(){
		return $this->dFecha;
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

	public function sp_select_corte_cadena(){
		$array_params = array(
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_corte_cadena');
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

} # CorteCadena

?>