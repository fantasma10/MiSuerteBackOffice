<?php

class ConciliacionDiferencia{

	public $sIdTipo;
	public $nombreCadena;
	public $nombreSubCadena;
	public $nombreCorresponsal;
	public $descEmisor;
	public $descProducto;
	public $nId;
	public $nIdEstatus;
	public $nIdTipo;
	public $nIdNivelConciliacion;
	public $nIdCadena;
	public $nIdSubCadena;
	public $nIdCorresponsal;
	public $nIdCorte;
	public $nIdArchivo;
	public $nIdEmisor;
	public $nIdProducto;
	public $nFolio;
	public $dFecha;
	public $sReferencia1;
	public $sReferencia2;
	public $sReferencia3;
	public $nMonto;
	public $nComision;
	public $nComisionEspecial;
	public $sAutorizacion;
	public $dFechaMovimiento;
	public $oRdb;
	public $oWdb;

	public function setSIdTipo($value){
		$this->sIdTipo = $value;
	}

	public function getSIdTipo(){
		return $this->sIdTipo;
	}

	public function setNombreCadena($value){
		$this->nombreCadena = $value;
	}

	public function getNombreCadena(){
		return $this->nombreCadena;
	}

	public function setNombreSubCadena($value){
		$this->nombreSubCadena = $value;
	}

	public function getNombreSubCadena(){
		return $this->nombreSubCadena;
	}

	public function setNombreCorresponsal($value){
		$this->nombreCorresponsal = $value;
	}

	public function getNombreCorresponsal(){
		return $this->nombreCorresponsal;
	}

	public function setDescEmisor($value){
		$this->descEmisor = $value;
	}

	public function getDescEmisor(){
		return $this->descEmisor;
	}

	public function setDescProducto($value){
		$this->descProducto = $value;
	}

	public function getDescProducto(){
		return $this->descProducto;
	}

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

	public function setNIdTipo($value){
		$this->nIdTipo = $value;
	}

	public function getNIdTipo(){
		return $this->nIdTipo;
	}

	public function setNIdNivelConciliacion($value){
		$this->nIdNivelConciliacion = $value;
	}

	public function getNIdNivelConciliacion(){
		return $this->nIdNivelConciliacion;
	}

	public function setNIdCadena($value){
		$this->nIdCadena = $value;
	}

	public function getNIdCadena(){
		return $this->nIdCadena;
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

	public function setNIdCorte($value){
		$this->nIdCorte = $value;
	}

	public function getNIdCorte(){
		return $this->nIdCorte;
	}

	public function setNIdArchivo($value){
		$this->nIdArchivo = $value;
	}

	public function getNIdArchivo(){
		return $this->nIdArchivo;
	}

	public function setNIdEmisor($value){
		$this->nIdEmisor = $value;
	}

	public function getNIdEmisor(){
		return $this->nIdEmisor;
	}

	public function setNIdProducto($value){
		$this->nIdProducto = $value;
	}

	public function getNIdProducto(){
		return $this->nIdProducto;
	}

	public function setNFolio($value){
		$this->nFolio = $value;
	}

	public function getNFolio(){
		return $this->nFolio;
	}

	public function setDFecha($value){
		$this->dFecha = $value;
	}

	public function getDFecha(){
		return $this->dFecha;
	}

	public function setSReferencia1($value){
		$this->sReferencia1 = $value;
	}

	public function getSReferencia1(){
		return $this->sReferencia1;
	}

	public function setSReferencia2($value){
		$this->sReferencia2 = $value;
	}

	public function getSReferencia2(){
		return $this->sReferencia2;
	}

	public function setSReferencia3($value){
		$this->sReferencia3 = $value;
	}

	public function getSReferencia3(){
		return $this->sReferencia3;
	}

	public function setNMonto($value){
		$this->nMonto = $value;
	}

	public function getNMonto(){
		return $this->nMonto;
	}

	public function setNComision($value){
		$this->nComision = $value;
	}

	public function getNComision(){
		return $this->nComision;
	}

	public function setNComisionEspecial($value){
		$this->nComisionEspecial = $value;
	}

	public function getNComisionEspecial(){
		return $this->nComisionEspecial;
	}

	public function setSAutorizacion($value){
		$this->sAutorizacion = $value;
	}

	public function getSAutorizacion(){
		return $this->sAutorizacion;
	}

	public function setDFechaMovimiento($value){
		$this->dFechaMovimiento = $value;
	}

	public function getDFechaMovimiento(){
		return $this->dFechaMovimiento;
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

	public function obtener_detalle($start=0, $limit=10){
		$array_params = array(
			array(
				'name'	=> 'nIdTipo',
				'value'	=> self::getNIdTipo(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdArchivo ',
				'value'	=> self::getNIdArchivo(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'start',
				'value'	=> $start,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'limit',
				'value'	=> $limit,
				'type'	=> 'i'
			)
		);


		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_conciliacion_dif');
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
			'found_rows'		=> $found_rows
		);
	} # obtener_detalle

	public function obtener_detalle_general ($start = 0, $limit = 10, $nIdEstatus = 0, $fechaInicial = null, $fechaFinal = null, $porAutorizar = 0) {
		$array_params = array(
			array(
				'name'		=> 'nIdCadena',
				'value'		=> self::getNIdCadena(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'dFechaInicial',
				'value'		=> $fechaInicial,
				'type'		=> 's'
			),
			array(
				'name'		=> 'dFechaFinal',
				'value'		=> $fechaFinal,
				'type'		=> 's'
			),
			array(
				'name'	=> 'start',
				'value'	=> $start,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'end',
				'value'	=> $limit,
				'type'	=> 'i'
			),
			array(
				'name'		=> 'nIdEstatus',
				'value'		=> $nIdEstatus,
				'type'		=> 'i'
			),
			array(
				'name'		=> 'nPorAutorizar',
				'value'		=> $porAutorizar,
				'type'		=> 'i'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_reporte_conciliacion_diferencias');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

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
			'found_rows'		=> $found_rows
		);
	} # obtener_detalle_general

	public function obtener_importe_total_general($nIdEstatus, $fechaInicial, $fechaFinal, $porAutorizar=0) {
		$array_params = array(
			array(
				'name'		=> 'nIdCadena',
				'value'		=> self::getNIdCadena(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'nIdEstatus',
				'value'		=> $nIdEstatus,
				'type'		=> 'i'
			),
			array(
				'name'		=> 'dFechaInicial',
				'value'		=> $fechaInicial,
				'type'		=> 's'
			),
			array(
				'name'		=> 'dFechaFinal',
				'value'		=> $fechaFinal,
				'type'		=> 's'
			),
			array(
				'name'		=> 'nPorAutorizar',
				'value'		=> $porAutorizar,
				'type'		=> 'i'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_importe_reporte_diferencias');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();
		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'found_rows'		=> ''
		);
	} #

	public function actualizar_estatus_autorizacion($nIdEstatus, $nIdAutorizacion, $usuarioLogeado) {
		$array_params = array(
			array(
				'name'	=> 'nIdDiferencia',
				'value'	=> self::getNId(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> $nIdEstatus,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdAutorizacion',
				'value'	=> $nIdAutorizacion,
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> $usuarioLogeado,
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_update_estatus_autorizacion_diferencias');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'Ha ocurrido un error al realizar al autorizar la diferencia';
			return $resultado;
		}

		$this->oRdb->closeStmt();

		$bExito		= ($resultado['bExito']) ? true : false;
		$nCodigo	= $resultado['nCodigo'];
		$sMensaje	= $resultado['sMensaje'];

		return array(
			'bExito'			=> $bExito,
			'nCodigo'			=> $nCodigo,
			'sMensaje'			=> $sMensaje,
			'sMensajeDetallado'	=> ''
		);
	} # Actualizar estatus de autorizacion



} # PC_ConciliacionDiferencia

?>
