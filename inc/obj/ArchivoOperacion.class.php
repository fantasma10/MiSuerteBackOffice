<?php

class ArchivoOperacion{

	public $nIdArchivo;
	public $nIdFila;
	public $sIdentificador;
	public $dFecha				= '';
	public $dHora				= '';
	public $nFolio				= '';
	public $sAutorizacion		= '';
	public $nIdCorresponsal		= -1;
	public $Sku					= '';
	public $sReferencia1		= '';
	public $sReferencia2		= '';
	public $sReferencia3		= '';
	public $nImporte			= 0;
	public $nComision			= 0;
	public $nComisionEspecial	= 0;

	public function setNIdArchivo($nIdArchivo){
		$this->nIdArchivo = $nIdArchivo;
	}

	public function getNIdArchivo(){
		return $this->nIdArchivo;
	}

	public function setNIdFila($nIdFila){
		$this->nIdFila = $nIdFila;
	}

	public function getNIdFila(){
		return $this->nIdFila;
	}

	public function setSIdentificador($value){
		$this->sIdentificador = $value;
	}

	public function getSIdentificador(){
		return $this->sIdentificador;
	}

	public function setDFecha($value){
		$this->dFecha = $value;
	}

	public function getDFecha(){
		return $this->dFecha;
	}

	public function setDHora($value){
		$this->dHora = $value;
	}

	public function getDHora(){
		return $this->dHora;
	}

	public function setNFolio($value){
		$this->nFolio = $value;
	}

	public function getNFolio(){
		return $this->nFolio;
	}

	public function setSAutorizacion($value){
		$this->sAutorizacion = $value;
	}

	public function getSAutorizacion(){
		return $this->sAutorizacion;
	}

	public function setNIdCorresponsal($value){
		$this->nIdCorresponsal = $value;
	}

	public function getNIdCorresponsal(){
		return $this->nIdCorresponsal;
	}

	public function setSku($value){
		$this->Sku = $value;
	}

	public function getSku(){
		return $this->Sku;
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

	public function setNImporte($value){
		$this->nImporte = $value;
	}

	public function getNImporte(){
		return $this->nImporte;
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

	public function guardar(){

		$dFecha			= self::getDFecha();
		$dNuevaFecha	= $dFecha[0].$dFecha[1].'-'.$dFecha[2].$dFecha[3].'-'.$dFecha[4].$dFecha[5].$dFecha[6].$dFecha[7];
		$date			= str_replace('/', '-', $dNuevaFecha);
		$dFecha			= date('Ymd', strtotime($date));

		$array_params = array(
			array(
				'name'	=> 'nIdArchivo',
				'value'	=> self::getNIdArchivo(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sIdentificador',
				'value'	=> self::getSIdentificador(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFecha',
				'value'	=> $dFecha,
				'type'	=> 's'
			),
			array(
				'name'	=> 'dHora',
				'value'	=> self::getDHora(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nFolio',
				'value'	=> self::getNFolio(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sAutorizacion',
				'value'	=> self::getSAutorizacion(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdCorresponsal',
				'value'	=> self::getNIdCorresponsal(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sReferencia1',
				'value'	=> self::getSReferencia1(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sReferencia2',
				'value'	=> self::getSReferencia2(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'sReferencia3',
				'value'	=> self::getSReferencia3(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nImporte',
				'value'	=> self::getNImporte(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nComision',
				'value'	=> self::getNComision(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nComisionEspecial',
				'value'	=> self::getNComisionEspecial(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'Sku',
				'value'	=> self::getSKu(),
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('data_contable');
		$this->oWdb->setSStoredProcedure('sp_insert_archivo_operacion');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'No ha sido posible guardar la informacion de Operacion de Archivo';
			return $resultado;
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Informacion guardada',
			'sMensajeDetallado'	=> ''
		);
	} # guardar
} # PC_ArchivoOperaciones

?>