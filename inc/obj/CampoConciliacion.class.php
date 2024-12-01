<?php

class CampoConciliacion{


	public $nIdCampo;
	public $nIdEstatus;
	public $sNombreCampo;
	public $sCampoClase;
	public $dFecRegistro;
	public $dFecMovimiento;
	public $oRdb;
	public $oWdb;

	public function setNIdCampo($value){
		$this->nIdCampo = $value;
	}

	public function getNIdCampo(){
		return $this->nIdCampo;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setSNombreCampo($value){
		$this->sNombreCampo = $value;
	}

	public function getSNombreCampo(){
		return $this->sNombreCampo;
	}

	public function setSCampoClase($value){
		$this->sCampoClase = $value;
	}

	public function getSCampoClase(){
		return $this->sCampoClase;
	}

	public function setDFecRegistro($value){
		$this->dFecRegistro = $value;
	}

	public function getDFecRegistro(){
		return $this->dFecRegistro;
	}

	public function setDFecMovimiento($value){
		$this->dFecMovimiento = $value;
	}

	public function getDFecMovimiento(){
		return $this->dFecMovimiento;
	}

	public function setORdb($oRdb){
		$this->oRdb = $oRdb;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOWdb($oWdb){
		$this->oWdb = $oWdb;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function sp_select_campo_conciliacion(){
		$array_params = array();

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_campo_conciliacion');
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
	} # sp_select_campo_conciliacion

} # PC_CampoConciliacion

?>