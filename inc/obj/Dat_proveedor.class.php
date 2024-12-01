<?php

class Dat_Proveedor{

	public $nIdEstatus;
	public $nIdUsuario;
	public $nIdGiro;
	public $nIdNivel;
	public $nIdProveedor;
	public $nIdRegimen;
	public $nIdTipoLiquidacion;
	public $sApellidoMaterno;
	public $sApellidoPaterno;
	public $sCelular;
	public $sNombre;
	public $sNombreComercial;
	public $sNombreContacto;
	public $sNombreImagen;
	public $sRazonSocial;
	public $sRFC;
	public $sTelefono;
	public $nIdFaseRegistroEmisor;
	public $bEstadoEmisor;
	public $oRdb;
	public $oWdb;

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNIdGiro($value){
		$this->nIdGiro = $value;
	}

	public function getNIdGiro(){
		return $this->nIdGiro;
	}

	public function setNIdNivel($value){
		$this->nIdNivel = $value;
	}

	public function getNIdNivel(){
		return $this->nIdNivel;
	}

	public function setNIdProveedor($value){
		$this->nIdProveedor = $value;
	}

	public function getNIdProveedor(){
		return $this->nIdProveedor;
	}

	public function setNIdRegimen($value){
		$this->nIdRegimen = $value;
	}

	public function getNIdRegimen(){
		return $this->nIdRegimen;
	}

	public function setNIdTipoLiquidacion($value){
		$this->nIdTipoLiquidacion = $value;
	}

	public function getNIdTipoLiquidacion(){
		return $this->nIdTipoLiquidacion;
	}

	public function setSApellidoMaterno($value){
		$this->sApellidoMaterno = $value;
	}

	public function getSApellidoMaterno(){
		return $this->sApellidoMaterno;
	}

	public function setSApellidoPaterno($value){
		$this->sApellidoPaterno = $value;
	}

	public function getSApellidoPaterno(){
		return $this->sApellidoPaterno;
	}

	public function setSCelular($value){
		$this->sCelular = $value;
	}

	public function getSCelular(){
		return $this->sCelular;
	}

	public function setSNombre($value){
		$this->sNombre = $value;
	}

	public function getSNombre(){
		return $this->sNombre;
	}

	public function setSNombreComercial($value){
		$this->sNombreComercial = $value;
	}

	public function getSNombreComercial(){
		return $this->sNombreComercial;
	}

	public function setSNombreContacto($value){
		$this->sNombreContacto = $value;
	}

	public function getSNombreContacto(){
		return $this->sNombreContacto;
	}

	public function setSNombreImagen($value){
		$this->sNombreImagen = $value;
	}

	public function getSNombreImagen(){
		return $this->sNombreImagen;
	}

	public function setSRazonSocial($value){
		$this->sRazonSocial = $value;
	}

	public function getSRazonSocial(){
		return $this->sRazonSocial;
	}

	public function setSRFC($value){
		$this->sRFC = $value;
	}

	public function getSRFC(){
		return $this->sRFC;
	}

	public function setSTelefono($value){
		$this->sTelefono = $value;
	}

	public function getSTelefono(){
		return $this->sTelefono;
	}

	public function setnIdFaseRegistroEmisor($value){
		$this->nIdFaseRegistroEmisor = $value;
	}

	public function getnIdFaseRegistroEmisor(){
		return $this->nIdFaseRegistroEmisor;
	}
	
	public function setBEstadoEmisor($value){
		$this->bEstadoEmisor = $value;
	}

	public function getBEstadoEmisor(){
		return $this->bEstadoEmisor;
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

	public function sp_insert_proveedor(){
		$array_params = array(
			array(
				'name'	=> 'nIdUsurio',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sNombre',
				'value'	=> self::getSNombre(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sApellidoPaterno',
				'value'	=> self::getSApellidoPaterno(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sApellidoMa',
				'value'	=> self::getSApellidoMaterno(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdRegimen',
				'value'	=> self::getNIdRegimen(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sRFC',
				'value'	=> self::getSRFC(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sRazonSocial',
				'value'	=> self::getSRazonSocial(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sNombreComercial',
				'value'	=> self::getSNombreComercial(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdGiro',
				'value'	=> self::getNIdGiro(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sNombreImagen',
				'value'	=> self::getSNombreImagen(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sTelefono',
				'value'	=> self::getSTelefono(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sCelular',
				'value'	=> self::getSCelular(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nidNivel',
				'value'	=> self::getNIdNivel(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdTipoLiquidacion',
				'value'	=> self::getNIdTipoLiquidacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sNombreContacto',
				'value'	=> self::getSNombreContacto(),
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('paycash_one');
		$this->oWdb->setSStoredProcedure('sp_insert_proveedor');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		if(!empty($data)){
			$data = $data[0];
		}

		$found_rows = $this->oWdb->foundRows();
		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} #sp_insert_proveedor


	public function sp_select_proveedor_fase_registro_emisor(){
		$array_params = array(
			array(
				'name'  => 'nIdProveedor',
				'value' => self::getNIdProveedor(),
				'type'  => 'i'
			)
		);

		$this->oRdb-> setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_proveedor_fase_registro_emisor');
		$this->oRdb->setParams($array_params);
		
		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}
		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		if(count($data) == 1){
			$data = $data[0];
		}

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

	}#select_id_fase_registro_emisor


	public function actualizarFaseRegistro(){
		$array_params = array(
			array(
				'name'  => 'nIdProveedor',
				'value' => self::getNIdProveedor(),
				'type'  => 'i'
			),
			array(
				'name'  => 'nIdFaseRegistroEmisor',
				'value' => self::getnIdFaseRegistroEmisor(),
				'type'  => 'i'
			)
		);

		$this->oRdb-> setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_update_fase_registro_emisor');
		$this->oRdb->setParams($array_params);
		
		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}
		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		if(count($data) == 1){
			$data = $data[0];
		}

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

	}# sp_select_estado_emisor

	public function sp_select_estado_emisor(){
		$array_params = array(
			array(
				'name'  => 'nIdProveedor',
				'value' => self::getNIdProveedor(),
				'type'  => 'i'
			)
		);

		$this->oRdb-> setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_estado_emisor');
		$this->oRdb->setParams($array_params);
		
		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}
		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		if(count($data) == 1){
			$data = $data[0];
		}

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

	}#select_estado_emisor


	public function sp_select_proveedor(){
		$array_params = array(
			array(
				'name'	=> 'nIdProveedor',
				'value'	=> self::getNIdProveedor(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_proveedor');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		if(count($data) == 1){
			$data = $data[0];
		}

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
	} # sp_select_proveedor

	public function sp_update_proveedor(){
		$array_params = array(
			array(
				'name'	=> 'nIdProveedor',
				'value'	=> self::getNIdProveedor(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sNombreComercial',
				'value'	=> self::getSNombreComercial(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdGiro',
				'value'	=> self::getNIdGiro(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sTelefono',
				'value'	=> self::getSTelefono(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sCelular',
				'value'	=> self::getSCelular(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sNombreImagen',
				'value'	=> self::getSNombreImagen(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sRfc',
				'value'	=> self::getSRFC(),
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('paycash_one');
		$this->oWdb->setSStoredProcedure('sp_update_proveedor');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		if(!empty($data)){
			$data = $data[0];
		}

		$found_rows = $this->oWdb->foundRows();
		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} # sp_update_proveedor


	public function select_proveedores(){
		$array_params = array(
			
		);

		$this->oRdb->setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_proveedores_facturacion');
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
	} # select_cat_tipo_conciliacion
	
	public function select_empresas(){
		$array_params = array(
			array(
				'name'	=> 'nIdProveedor',
				'value'	=> self::getNIdProveedor(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_empresas_emisor');
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
	} # sp_select_empresas_emisor
	
} # Dat_Proveedor

?>