<?php

class Cat_Giro{

	public $nIdGiro;
	public $sNombreGiro;
	public $oRdb;
	public $oWdb;

	public function setNIdGiro($value){
		$this->nIdGiro = $value;
	}

	public function getNIdGiro(){
		return $this->nIdGiro;
	}

	public function setSNombreGiro($value){
		$this->sNombreGiro = $value;
	}

	public function getSNombreGiro(){
		return $this->sNombreGiro;
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

	public function sp_select_giro(){
		$array_params = array();

		$this->oRdb->setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_giro');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
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
	} # sp_select_giro

} # Dat_Giro

?>