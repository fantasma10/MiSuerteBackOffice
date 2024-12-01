<?php

class PolizaZP extends Poliza{

	public $nNumCuentaContable = '';

	public function setNNumCuentaContable($nNumCuentaContable){
		$this->nNumCuentaContable = $nNumCuentaContable;
	}

	public function getNNumCuentaContable(){
		return $this->nNumCuentaContable;
	}

	# # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

	public function obtenerMovimientosPolizaIngresos(){
		$array_params = array(
			array(
				'name'	=> 'sListaMovimientos',
				'value'	=> self::getSListaMovimientos(),
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_movimientos_polizaingresos');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$array_lista	= $this->oRdb->fetchAll();
		$num_rows		= $this->oRdb->numRows();
		$nIdMovPoliza	= 1;

		$this->oRdb->closeStmt();

		$arrayMovimientos = array();

		foreach($array_lista AS $mov){
			# armar registro corresponsal
			$nIdUsuario = self::getNIdUsuario();

			$oPolizaMovimiento	= new PolizaMovimiento();
			$oPolizaMovimiento->setORdb($this->oRdb);
			$oPolizaMovimiento->setOWdb($this->oWdb);
			$oPolizaMovimiento->setSDatabase('zeropago');
			$oPolizaMovimiento->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento->setNIdMovPoliza($nIdMovPoliza);

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento->{$key} = $value;
				}
			}

			$array_params = array(
				array(
					'name' 	=> 'nIdPoliza',
					'value'	=> $oPolizaMovimiento->getNIdPoliza(),
					'type'	=> 'i'
				),
				array(
					'name' 	=> 'nIdMovPoliza',
					'value'	=> $oPolizaMovimiento->getNIdMovPoliza(),
					'type'	=> 'i'
				),
				array(
					'name' 	=> 'sTipo',
					'value'	=> $oPolizaMovimiento->getSTipo(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo1',
					'value'	=> $oPolizaMovimiento->getSCampo1(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo2',
					'value'	=> $oPolizaMovimiento->getSCampo2(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo3',
					'value'	=> $oPolizaMovimiento->getSCampo3(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo4',
					'value'	=> $oPolizaMovimiento->getSCampo4(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo5',
					'value'	=> $oPolizaMovimiento->getSCampo5(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo6',
					'value'	=> $oPolizaMovimiento->getSCampo6(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo7',
					'value'	=> $oPolizaMovimiento->getSCampo7(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo8',
					'value'	=> $oPolizaMovimiento->getSCampo8(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo9',
					'value'	=> $oPolizaMovimiento->getSCampo9(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo10',
					'value'	=> $oPolizaMovimiento->getSCampo10(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo11',
					'value'	=> $oPolizaMovimiento->getSCampo11(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo12',
					'value'	=> $oPolizaMovimiento->getSCampo12(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo13',
					'value'	=> $oPolizaMovimiento->getSCampo13(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo14',
					'value'	=> $oPolizaMovimiento->getSCampo14(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo15',
					'value'	=> $oPolizaMovimiento->getSCampo15(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo16',
					'value'	=> $oPolizaMovimiento->getSCampo16(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo17',
					'value'	=> $oPolizaMovimiento->getSCampo17(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo18',
					'value'	=> $oPolizaMovimiento->getSCampo18(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo19',
					'value'	=> $oPolizaMovimiento->getSCampo19(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo20',
					'value'	=> $oPolizaMovimiento->getSCampo20(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'nIdUsuario',
					'value'	=> $oPolizaMovimiento->getNIdUsuario(),
					'type'	=> 'i'
				),
				array(
					'name'	=> 'nIdMovBanco',
					'value'	=> 0,
					'type'	=> 'i'
				),
				array(
					'name'	=> 'nIdCorte',
					'value'	=> $mov['nIdCorte'],
					'type'	=> 'i'
				)
			);

			$oPolizaMovimiento->setCustomParams($array_params);

			$arrayMovimientos[] = $oPolizaMovimiento;

			$nIdMovPoliza+=1;

			$oPolizaMovimiento2	= new PolizaMovimiento();
			$oPolizaMovimiento2->setORdb($this->oRdb);
			$oPolizaMovimiento2->setOWdb($this->oWdb);
			$oPolizaMovimiento2->setSDatabase('zeropago');
			$oPolizaMovimiento2->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento2->{$key} = $value;
				}
			}

			$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);
			$oPolizaMovimiento2->setSCAmpo1($mov['nNumCuentaContableBanco']);
			$oPolizaMovimiento2->setSCampo3(1);

			$arrayMovimientos[] = $oPolizaMovimiento2;

			$nIdMovPoliza+=1;
		} # foreach

		self::setArrayMovimientos($arrayMovimientos);

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $array_lista,
			'num_rows'			=> $num_rows
		);
	} # obtenerMovimientosPolizaIngresos

	public function obtenerMovimientosPolizaComisionesReceptor(){
		$array_params = array(
			array(
				'name'	=> 'sListaMovimientos',
				'value'	=> self::getSListaMovimientos(),
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_movimientos_polizacomisionreceptor');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$array_lista	= $this->oRdb->fetchAll();
		$num_rows		= $this->oRdb->numRows();
		$nIdMovPoliza	= 1;

		$this->oRdb->closeStmt();

		$arrayMovimientos = array();

		foreach($array_lista AS $mov){
			# armar registro cadena
			$nIdUsuario = self::getNIdUsuario();

			$oPolizaMovimiento	= new PolizaMovimiento();
			$oPolizaMovimiento->setORdb($this->oRdb);
			$oPolizaMovimiento->setOWdb($this->oWdb);
			$oPolizaMovimiento->setSDatabase('zeropago');
			$oPolizaMovimiento->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento->setNIdMovPoliza($nIdMovPoliza);

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento->{$key} = $value;
				}
			}

			$array_params = array(
				array(
					'name' 	=> 'nIdPoliza',
					'value'	=> $oPolizaMovimiento->getNIdPoliza(),
					'type'	=> 'i'
				),
				array(
					'name' 	=> 'nIdMovPoliza',
					'value'	=> $nIdMovPoliza,
					'type'	=> 'i'
				),
				array(
					'name' 	=> 'sTipo',
					'value'	=> $oPolizaMovimiento->getSTipo(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo1',
					'value'	=> $oPolizaMovimiento->getSCampo1(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo2',
					'value'	=> $oPolizaMovimiento->getSCampo2(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo3',
					'value'	=> 1,
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo4',
					'value'	=> $oPolizaMovimiento->getSCampo4(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo5',
					'value'	=> $oPolizaMovimiento->getSCampo5(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo6',
					'value'	=> $oPolizaMovimiento->getSCampo6(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo7',
					'value'	=> $oPolizaMovimiento->getSCampo7(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo8',
					'value'	=> $oPolizaMovimiento->getSCampo8(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo9',
					'value'	=> $oPolizaMovimiento->getSCampo9(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo10',
					'value'	=> $oPolizaMovimiento->getSCampo10(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo11',
					'value'	=> $oPolizaMovimiento->getSCampo11(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo12',
					'value'	=> $oPolizaMovimiento->getSCampo12(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo13',
					'value'	=> $oPolizaMovimiento->getSCampo13(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo14',
					'value'	=> $oPolizaMovimiento->getSCampo14(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo15',
					'value'	=> $oPolizaMovimiento->getSCampo15(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo16',
					'value'	=> $oPolizaMovimiento->getSCampo16(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo17',
					'value'	=> $oPolizaMovimiento->getSCampo17(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo18',
					'value'	=> $oPolizaMovimiento->getSCampo18(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo19',
					'value'	=> $oPolizaMovimiento->getSCampo19(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo20',
					'value'	=> $oPolizaMovimiento->getSCampo20(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'nIdUsuario',
					'value'	=> $oPolizaMovimiento->getNIdUsuario(),
					'type'	=> 'i'
				),
				array(
					'name'	=> 'nIdMovBanco',
					'value'	=> 0,
					'type'	=> 'i'
				),
				array(
					'name'	=> 'nIdCorte',
					'value'	=> $mov['nIdCorte'],
					'type'	=> 'i'
				)
			);

			$oPolizaMovimiento->setCustomParams($array_params);

			$arrayMovimientos[] = $oPolizaMovimiento;

			$nIdMovPoliza+=1;

			$oPolizaMovimiento2	= new PolizaMovimiento();
			$oPolizaMovimiento2->setORdb($this->oRdb);
			$oPolizaMovimiento2->setOWdb($this->oWdb);
			$oPolizaMovimiento2->setSDatabase('zeropago');
			$oPolizaMovimiento2->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento2->{$key} = $value;
				}
			}

			$nNumCuentaContable = self::getNNumCuentaContable();
			$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);
			$oPolizaMovimiento2->setSCampo3(0);

			$array_params = array(
				array(
					'name' 	=> 'nIdPoliza',
					'value'	=> $oPolizaMovimiento->getNIdPoliza(),
					'type'	=> 'i'
				),
				array(
					'name' 	=> 'nIdMovPoliza',
					'value'	=> $nIdMovPoliza,
					'type'	=> 'i'
				),
				array(
					'name' 	=> 'sTipo',
					'value'	=> $oPolizaMovimiento->getSTipo(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo1',
					'value'	=> $nNumCuentaContable,
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo2',
					'value'	=> $oPolizaMovimiento->getSCampo2(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo3',
					'value'	=> 0,
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo4',
					'value'	=> $oPolizaMovimiento->getSCampo4(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo5',
					'value'	=> $oPolizaMovimiento->getSCampo5(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo6',
					'value'	=> $oPolizaMovimiento->getSCampo6(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo7',
					'value'	=> $oPolizaMovimiento->getSCampo7(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo8',
					'value'	=> $oPolizaMovimiento->getSCampo8(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo9',
					'value'	=> $oPolizaMovimiento->getSCampo9(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo10',
					'value'	=> $oPolizaMovimiento->getSCampo10(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo11',
					'value'	=> $oPolizaMovimiento->getSCampo11(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo12',
					'value'	=> $oPolizaMovimiento->getSCampo12(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo13',
					'value'	=> $oPolizaMovimiento->getSCampo13(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo14',
					'value'	=> $oPolizaMovimiento->getSCampo14(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo15',
					'value'	=> $oPolizaMovimiento->getSCampo15(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo16',
					'value'	=> $oPolizaMovimiento->getSCampo16(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo17',
					'value'	=> $oPolizaMovimiento->getSCampo17(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo18',
					'value'	=> $oPolizaMovimiento->getSCampo18(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo19',
					'value'	=> $oPolizaMovimiento->getSCampo19(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'sCampo20',
					'value'	=> $oPolizaMovimiento->getSCampo20(),
					'type'	=> 's'
				),
				array(
					'name' 	=> 'nIdUsuario',
					'value'	=> $oPolizaMovimiento->getNIdUsuario(),
					'type'	=> 'i'
				),
				array(
					'name'	=> 'nIdMovBanco',
					'value'	=> 0,
					'type'	=> 'i'
				),
				array(
					'name'	=> 'nIdCorte',
					'value'	=> $mov['nIdCorte'],
					'type'	=> 'i'
				)
			);

			$oPolizaMovimiento2->setCustomParams($array_params);

			$arrayMovimientos[] = $oPolizaMovimiento2;

			$nIdMovPoliza+=1;
		} # foreach

		self::setArrayMovimientos($arrayMovimientos);

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $array_lista,
			'num_rows'			=> $num_rows
		);
	} # obtenerMovimientosPolizaComisionesReceptor

	public function obtenerMovimientosPolizaComisionesGanadas(){
		$array_params = array(
			array(
				'name'	=> 'sListaMovimientos',
				'value'	=> self::getSListaMovimientos(),
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_movimientos_polizacomisionganada');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$array_lista	= $this->oRdb->fetchAll();
		$num_rows		= $this->oRdb->numRows();
		$nIdMovPoliza	= 0;

		$this->oRdb->closeStmt();

		$arrayMovimientos = array();

		$importeEntradaBanco	= 0;
		$sMes					= 'COMISION GANADA';

		foreach($array_lista AS $mov){
			$nIdMovPoliza+=1;

			$sMes = $mov['sMes'];
			$nIdUsuario = self::getNIdUsuario();

			$oPolizaMovimiento = new PolizaMovimiento();
			$oPolizaMovimiento->setORdb($this->oRdb);
			$oPolizaMovimiento->setOWdb($this->oWdb);
			$oPolizaMovimiento->setSDatabase('zeropago');
			$oPolizaMovimiento->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento->setNIdMovPoliza($nIdMovPoliza);
			$oPolizaMovimiento->nIdComision = $mov['nIdComision'];

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento->{$key} = $value;
				}
			}

			$arrayMovimientos[] = $oPolizaMovimiento;

			$importeEntradaBanco+= $mov['sCampo4'];
		} # foreach

		$nIdMovPoliza+=1;

		$nNumCuentaContable = self::getNNumCuentaContable();

		$oPolizaMovimiento2	= new PolizaMovimiento();
		$oPolizaMovimiento2->setORdb($this->oRdb);
		$oPolizaMovimiento2->setOWdb($this->oWdb);
		$oPolizaMovimiento2->setSDatabase('zeropago');
		$oPolizaMovimiento2->setNIdUsuario($nIdUsuario);
		$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);

		$oPolizaMovimiento2->setSTipo('M1');
		$oPolizaMovimiento2->setSCampo1($nNumCuentaContable);
		$oPolizaMovimiento2->setSCampo3(1);
		$oPolizaMovimiento2->setSCampo4($importeEntradaBanco);
		$oPolizaMovimiento2->setSCampo5(0);
		$oPolizaMovimiento2->setSCampo6(0);
		$oPolizaMovimiento2->setSCampo7($sMes);

		$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);

		$arrayMovimientos[] = $oPolizaMovimiento2;

		self::setArrayMovimientos($arrayMovimientos);

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $arrayMovimientos,
			'num_rows'			=> $num_rows
		);
	} # obtenerMovimientosPolizaComisionesGanadas

	public function obtenerMovimientosPolizaPagosEmisor(){
		$array_params = array(
			array(
				'name'	=> 'sListaMovimientos',
				'value'	=> self::getSListaMovimientos(),
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_movimientos_polizapagosemisor');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$array_lista	= $this->oRdb->fetchAll();
		$num_rows		= $this->oRdb->numRows();
		$nIdMovPoliza	= 0;

		$this->oRdb->closeStmt();

		$arrayMovimientos = array();

		$importeEntradaBanco	= 0;
		$sMes					= 'COMISION GANADA';

		$nIdUsuario = self::getNIdUsuario();
		foreach($array_lista AS $mov){
			$nIdMovPoliza+=1;

			$sMes = $mov['sMes'];

			$oPolizaMovimiento = new PolizaMovimiento();
			$oPolizaMovimiento->setORdb($this->oRdb);
			$oPolizaMovimiento->setOWdb($this->oWdb);
			$oPolizaMovimiento->setSDatabase('zeropago');
			$oPolizaMovimiento->setNIdUsuario($nIdUsuario);
			$oPolizaMovimiento->setNIdMovPoliza($nIdMovPoliza);
			$oPolizaMovimiento->nIdCorte = $mov['nIdCorte'];

			foreach($mov AS $key => $value){
				if(property_exists('PolizaMovimiento', $key)){
					$oPolizaMovimiento->{$key} = $value;
				}
			}

			$arrayMovimientos[] = $oPolizaMovimiento;

			$importeEntradaBanco+= $mov['sCampo4'];
		} # foreach

		$nIdMovPoliza+=1;

		$nNumCuentaContable = self::getNNumCuentaContable();

		$oPolizaMovimiento2	= new PolizaMovimiento();
		$oPolizaMovimiento2->setORdb($this->oRdb);
		$oPolizaMovimiento2->setOWdb($this->oWdb);
		$oPolizaMovimiento2->setSDatabase('zeropago');
		$oPolizaMovimiento2->setNIdUsuario($nIdUsuario);
		$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);

		$oPolizaMovimiento2->setSTipo('M1');
		$oPolizaMovimiento2->setSCampo1($nNumCuentaContable);
		$oPolizaMovimiento2->setSCampo3(1);
		$oPolizaMovimiento2->setSCampo4($importeEntradaBanco);
		$oPolizaMovimiento2->setSCampo5(0);
		$oPolizaMovimiento2->setSCampo6(0);
		$oPolizaMovimiento2->setSCampo7($sMes);

		$oPolizaMovimiento2->setNIdMovPoliza($nIdMovPoliza);

		$arrayMovimientos[] = $oPolizaMovimiento2;

		self::setArrayMovimientos($arrayMovimientos);

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $arrayMovimientos,
			'num_rows'			=> $num_rows
		);
	} # obtenerMovimientosPolizaPagosEmisor

	public function guardarPolizaComisionesGanadas(){
		$oHeader			= self::getOHeader();
		$arrayMovimientos	= self::getArrayMovimientos();

		$resultado = $oHeader->guardar();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		self::setNIdPoliza($oHeader->getNIdPoliza());

		$cuenta = 0;
		foreach($arrayMovimientos as $oPolizaMovimiento){
			$oPolizaMovimiento->setNIdPoliza(self::getNIdPoliza());
			$resultado = $oPolizaMovimiento->guardar();

			if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
				return $resultado;
			}

			if(!empty($oPolizaMovimiento->nIdComision) && $oPolizaMovimiento->nIdComision > 0){
				$oCorteComisionEmisor = new CorteComisionEmisorZP();
				$oCorteComisionEmisor->setORdb($this->oRdb);
				$oCorteComisionEmisor->setOWdb($this->oWdb);

				$nIdComision	= $oPolizaMovimiento->nIdComision;
				$nIdPoliza		= $oPolizaMovimiento->nIdPoliza;

				$oCorteComisionEmisor->setNIdComision($nIdComision);

				$resultado = $oCorteComisionEmisor->actualizaPolizaComision($nIdPoliza);

				if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
					return $resultado;
				}
			}
			$cuenta++;
		}

		$array_data = array(
			'nIdPoliza'	=> self::getNIdPoliza(),
			'nRegs'		=> $cuenta
		);

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Poliza guardada Correctamente',
			'data'		=> $array_data
		);
	} # guardarPolizaComisionesGanadas

	/*
		Guarda la poliza de pagos a los emisores
		Flujo : zeropago a Emisor
		Tipo de Poliza : Egreso
	*/
	public function guardarPolizaPagosEmisor(){
		$oHeader			= self::getOHeader();
		$arrayMovimientos	= self::getArrayMovimientos();

		$resultado = $oHeader->guardar();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		self::setNIdPoliza($oHeader->getNIdPoliza());

		$cuenta = 0;
		foreach($arrayMovimientos as $oPolizaMovimiento){
			$oPolizaMovimiento->setNIdPoliza(self::getNIdPoliza());
			$resultado = $oPolizaMovimiento->guardar();

			if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
				return $resultado;
			}

			if(!empty($oPolizaMovimiento->nIdCorte) && $oPolizaMovimiento->nIdCorte > 0){
				$oCorteComisionEmisor = new CorteEmisorZP();
				$oCorteComisionEmisor->setORdb($this->oRdb);
				$oCorteComisionEmisor->setOWdb($this->oWdb);

				$nIdCorte	= $oPolizaMovimiento->nIdCorte;
				$nIdPoliza	= $oPolizaMovimiento->nIdPoliza;

				$oCorteComisionEmisor->setNIdCorte($nIdCorte);

				$resultado = $oCorteComisionEmisor->actualizaPolizaPagoEmisor($nIdPoliza);

				if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
					return $resultado;
				}
			}
			$cuenta++;
		}

		$array_data = array(
			'nIdPoliza'	=> self::getNIdPoliza(),
			'nRegs'		=> $cuenta
		);

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Poliza guardada Correctamente',
			'data'		=> $array_data
		);
	} # guardarPolizaComisionesGanadas
} #zeropagoPoliza

?>