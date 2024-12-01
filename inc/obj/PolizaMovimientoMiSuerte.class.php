<?php

class PolizaMovimientoMiSuerte{

	public $nIdPoliza;
	public $nIdMovPoliza;
	public $sTipo;
	public $sCampo1		= '';
	public $sCampo2		= '';
	public $sCampo3		= '';
	public $sCampo4		= '';
	public $sCampo5		= '';
	public $sCampo6		= '';
	public $sCampo7		= '';
	public $sCampo8		= '';
	public $sCampo9		= '';
	public $sCampo10	= '';
	public $sCampo11	= '';
	public $sCampo12	= '';
	public $sCampo13	= '';
	public $sCampo14	= '';
	public $sCampo15	= '';
	public $sCampo16	= '';
	public $sCampo17	= '';
	public $sCampo18	= '';
	public $sCampo19	= '';
	public $sCampo20	= '';
	public $oRdb;
	public $oWdb;
	public $nIdUsuario;
	public $nIdMovBanco;
	public $nIdCorte;

	public function setNIdCorte($value){
		$this->nIdCorte = $value;
	}

	public function getNIdCorte(){
		return $this->nIdCorte;
	}

	public function setNIdMovBanco($value){
		$this->nIdMovBanco = $value;
	}

	public function getNIdMovBanco(){
		return $this->nIdMovBanco;
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

	public function setNIdPoliza($nIdPoliza){
		$this->nIdPoliza = $nIdPoliza;
	}

	public function getNIdPoliza(){
		return $this->nIdPoliza;
	}

	public function setNIdMovPoliza($nIdMovPoliza){
		$this->nIdMovPoliza = $nIdMovPoliza;
	}

	public function getNIdMovPoliza(){
		return $this->nIdMovPoliza;
	}

	public function setSTipo($sTipo){
		$this->sTipo = $sTipo;
	}

	public function getSTipo(){
		return $this->sTipo;
	}

	public function setSCampo1($sCampo1){
		$this->sCampo1 = $sCampo1;
	}

	public function getSCampo1(){
		return $this->sCampo1;
	}

	public function setSCampo2($sCampo2){
		$this->sCampo2 = $sCampo2;
	}

	public function getSCampo2(){
		return $this->sCampo2;
	}

	public function setSCampo3($sCampo3){
		$this->sCampo3 = $sCampo3;
	}

	public function getSCampo3(){
		return $this->sCampo3;
	}

	public function setSCampo4($sCampo4){
		$this->sCampo4 = $sCampo4;
	}

	public function getSCampo4(){
		return $this->sCampo4;
	}

	public function setSCampo5($sCampo5){
		$this->sCampo5 = $sCampo5;
	}

	public function getSCampo5(){
		return $this->sCampo5;
	}

	public function setSCampo6($sCampo6){
		$this->sCampo6 = $sCampo6;
	}

	public function getSCampo6(){
		return $this->sCampo6;
	}

	public function setSCampo7($sCampo7){
		$this->sCampo7 = $sCampo7;
	}

	public function getSCampo7(){
		return $this->sCampo7;
	}

	public function setSCampo8($sCampo8){
		$this->sCampo8 = $sCampo8;
	}

	public function getSCampo8(){
		return $this->sCampo8;
	}

	public function setSCampo9($sCampo9){
		$this->sCampo9 = $sCampo9;
	}

	public function getSCampo9(){
		return $this->sCampo9;
	}

	public function setSCampo10($sCampo10){
		$this->sCampo10 = $sCampo10;
	}

	public function getSCampo10(){
		return $this->sCampo10;
	}

	public function setSCampo11($sCampo11){
		$this->sCampo11 = $sCampo11;
	}

	public function getSCampo11(){
		return $this->sCampo11;
	}

	public function setSCampo12($sCampo12){
		$this->sCampo12 = $sCampo12;
	}

	public function getSCampo12(){
		return $this->sCampo12;
	}

	public function setSCampo13($sCampo13){
		$this->sCampo13 = $sCampo13;
	}

	public function getSCampo13(){
		return $this->sCampo13;
	}

	public function setSCampo14($sCampo14){
		$this->sCampo14 = $sCampo14;
	}

	public function getSCampo14(){
		return $this->sCampo14;
	}

	public function setSCampo15($sCampo15){
		$this->sCampo15 = $sCampo15;
	}

	public function getSCampo15(){
		return $this->sCampo15;
	}

	public function setSCampo16($sCampo16){
		$this->sCampo16 = $sCampo16;
	}

	public function getSCampo16(){
		return $this->sCampo16;
	}

	public function setSCampo17($sCampo17){
		$this->sCampo17 = $sCampo17;
	}

	public function getSCampo17(){
		return $this->sCampo17;
	}

	public function setSCampo18($sCampo18){
		$this->sCampo18 = $sCampo18;
	}

	public function getSCampo18(){
		return $this->sCampo18;
	}

	public function setSCampo19($sCampo19){
		$this->sCampo19 = $sCampo19;
	}

	public function getSCampo19(){
		return $this->sCampo19;
	}

	public function setSCampo20($sCampo20){
		$this->sCampo20 = $sCampo20;
	}

	public function getSCampo20(){
		return $this->sCampo20;
	}

	# # # # # # # # # # # # # # # # # # # # #

	public function guardar(){
		$array_params = array(
			array(
				'name' 	=> 'nIdPoliza',
				'value'	=> self::getNIdPoliza(),
				'type'	=> 'i'
			),
			array(
				'name' 	=> 'nIdMovPoliza',
				'value'	=> self::getNIdMovPoliza(),
				'type'	=> 'i'
			),
			array(
				'name' 	=> 'sTipo',
				'value'	=> self::getSTipo(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo1',
				'value'	=> self::getSCampo1(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo2',
				'value'	=> self::getSCampo2(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo3',
				'value'	=> self::getSCampo3(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo4',
				'value'	=> self::getSCampo4(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo5',
				'value'	=> self::getSCampo5(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo6',
				'value'	=> self::getSCampo6(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo7',
				'value'	=> self::getSCampo7(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo8',
				'value'	=> self::getSCampo8(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo9',
				'value'	=> self::getSCampo9(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo10',
				'value'	=> self::getSCampo10(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo11',
				'value'	=> self::getSCampo11(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo12',
				'value'	=> self::getSCampo12(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo13',
				'value'	=> self::getSCampo13(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo14',
				'value'	=> self::getSCampo14(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo15',
				'value'	=> self::getSCampo15(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo16',
				'value'	=> self::getSCampo16(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo17',
				'value'	=> self::getSCampo17(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo18',
				'value'	=> self::getSCampo18(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo19',
				'value'	=> self::getSCampo19(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'sCampo20',
				'value'	=> self::getSCampo20(),
				'type'	=> 's'
			),
			array(
				'name' 	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdCorte',
				'value'	=> self::getNIdCorte(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_insert_poliza_movimiento');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Registro Insertado Exitosamente'
		);
	} # guardar

	public function cargar(){
		$array_params = array(
			array(
				'name'	=> 'nIdPoliza',
				'type'	=> 'i',
				'value'	=> self::getNIdPoliza()
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_poliza_layoutmovimientos');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data
		);
	} # cargar
} # LayoutMovimientos

?>