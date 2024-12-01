<?php

class ClienteCfgLayout{

	public $nId;
	public $nIdEstatus;
	public $nIdCadena;
	public $nIdCampo;
	public $nPosicionInicial;
	public $nPosicionFinal;
	public $oRdb;
	public $oWdb;
	public $sCampoClase;
	public $sValorComparar;

	public function setNId($value){
		$this->nId = $value;
	}

	public function getNId(){
		return $this->nId;
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

	public function setNIdCampo($value){
		$this->nIdCampo = $value;
	}

	public function getNIdCampo(){
		return $this->nIdCampo;
	}

	public function setNPosicionInicial($value){
		$this->nPosicionInicial = $value;
	}

	public function getNPosicionInicial(){
		return $this->nPosicionInicial;
	}

	public function setNPosicionFinal($value){
		$this->nPosicionFinal = $value;
	}

	public function getNPosicionFinal(){
		return $this->nPosicionFinal;
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

	public function setSCampoClase($value){
		$this->sCampoClase = $value;
	}

	public function getSCampoClase(){
		return $this->sCampoClase;
	}

	public function setSValorComparar($value) {
		$this->sValorComparar = $value;
	}

	public function getSValorComparar() {
		return $this->sValorComparar;
	}

	public function cargarClienteCfgLayout(){
		$array_params = array(
			array(
				'name'		=> 'nIdCadena',
				'value'		=> self::getNIdCadena(),
				'type'		=> 'i'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_cliente_cfglayout');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'No ha sido posible cargar la informacion de layout';
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} # cargarClienteCfgLayout
} # PC_ClienteCfgLayout

?>