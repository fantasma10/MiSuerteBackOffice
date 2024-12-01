<?php

class CorteComision{

	public $nIdCorte;
	public $nIdEstatus;
	public $nIdProveedor;
	public $nTotalOperaciones;
	public $nImporte;
	public $nImporteIVA;
	public $nImporteTotal;
	public $nImporteComision;
	public $sFolio;
	public $dFechaInicio;
	public $dFechaFinal;
	public $dFechaFactura;
	public $dFechaDeposito;
	public $nIdUsuario;
	public $oRdb;
	public $oWdb;

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

	public function setNIdProveedor($value){
		$this->nIdProveedor = $value;
	}

	public function getNIdProveedor(){
		return $this->nIdProveedor;
	}

	public function setNTotalOperaciones($value){
		$this->nTotalOperaciones = $value;
	}

	public function getNTotalOperaciones(){
		return $this->nTotalOperaciones;
	}

	public function setNImporte($value){
		$this->nImporte = $value;
	}

	public function getNImporte(){
		return $this->nImporte;
	}

	public function setNImporteIVA($value){
		$this->nImporteIVA = $value;
	}

	public function getNImporteIVA(){
		return $this->nImporteIVA;
	}

	public function setNImporteTotal($value){
		$this->nImporteTotal = $value;
	}

	public function getNImporteTotal(){
		return $this->nImporteTotal;
	}

	public function setNImporteComision($value){
		$this->nImporteComision = $value;
	}

	public function getNImporteComision(){
		return $this->nImporteComision;
	}

	public function setSFolio($value){
		$this->sFolio = $value;
	}

	public function getSFolio(){
		return $this->sFolio;
	}

	public function setDFechaInicio($value){
		$this->dFechaInicio = $value;
	}

	public function getDFechaInicio(){
		return $this->dFechaInicio;
	}

	public function setDFechaFinal($value){
		$this->dFechaFinal = $value;
	}

	public function getDFechaFinal(){
		return $this->dFechaFinal;
	}

	public function setDFechaFactura($value){
		$this->dFechaFactura = $value;
	}

	public function getDFechaFactura(){
		return $this->dFechaFactura;
	}

	public function setDFechaDeposito($value){
		$this->dFechaDeposito = $value;
	}

	public function getDFechaDeposito(){
		return $this->dFechaDeposito;
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

	# # # # # # # # # # # # # # # # # # # # #

	public function listaCortes($oCfgTabla){
		$array_params = array(
			array(
				'name'	=> 'dFechaInicio',
				'value'	=> self::getDFechaInicio(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> self::getDFechaFinal(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdProveedor',
				'value'	=> self::getNIdProveedor(),
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
		$this->oWdb->setSStoredProcedure('sp_select_corte_comision');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data		= $this->oWdb->fetchAll();
		$num_rows	= $this->oWdb->numRows();

		$this->oWdb->closeStmt();

		$found_rows	= $this->oWdb->foundRows();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'num_rows'			=> $num_rows,
			'found_rows'		=> $found_rows
		);
	} # listaCortes

	public function asignarFactura($sRFC, $nImporte, $sFolio, $sListaCortes){
		$array_params = array(
			array(
				'name'	=> 'sListaCortes',
				'value'	=> $sListaCortes,
				'type'	=> 's'
			),
			array(
				'name'	=> 'nImporte',
				'value'	=> $nImporte,
				'type'	=> 'd'
			),
			array(
				'name'	=> 'sRFC',
				'value'	=> $sRFC,
				'type'	=> 's'
			),
			array(
				'name'	=> 'sFolio',
				'value'	=> $sFolio,
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_asignar_factura');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	}# validarAsignarFactura

	/*
		se utiliza para cargar la lista de cortes agrupados por factura que están pendientes de conciliar con los
		movimientos de banco
	*/
	public function listaPendientes(){
		$array_params = array(
			array(
				'name'	=> 'nIdEstatus',
				'type'	=> 'i',
				'value'	=> self::getNIdEstatus()
			),
			array(
				'name'	=> 'nIdProveedor',
				'type'	=> 'i',
				'value'	=> self::getNIdProveedor()
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_cortespendientes');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'nTotal'			=> count($data)
		);
	} # listaPendientes

	/*
		conciliar manualmente
	*/
	public function conciliacionManual($array_movs, $array_facs){
		$array_params = array(
			array(
				'name'	=> 'array_movs',
				'value'	=> $array_movs,
				'type'	=> 's'
			),
			array(
				'name'	=> 'array_facs',
				'value'	=> $array_facs,
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_concilia_manual');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'data'				=> $data,
			'sMensaje'			=> 'Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # conciliacionManual

	public function obtenerCorteMensual(){
		$array_params = array(
			array(
				'name'	=> 'dFechaInicial',
				'value'	=> self::getDFechaInicio(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> self::getDFechaFinal(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdProveedor',
				'value'	=> self::getNIdProveedor(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_cortecomision_periodo');
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
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # obtenerCorteMensual
} # CorteComision

?>