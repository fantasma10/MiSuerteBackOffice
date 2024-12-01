<?php
class CadenaConsideracionesReporte{
	//parametros de entrada
	public $nIdCadena;

	//para la conexion
	public $oRdb;
	public $oWdb;

	public function setNIdCadena($value){
		$this->nIdCadena = $value;
	}

	public function getNIdCadena(){
		return $this->nIdCadena;
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

    public function sp_select_consideracion_cadena(){
		$array_params = array(
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_consideracion_cadena');
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
	}
}

?>