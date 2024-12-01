<?php

class WSTransferDirecto {

	private $WSDL;
	private $client;
	
	public function __construct( $webServiceURL ) {
		$this->WSDL = $webServiceURL;
	}
	
	public function createClient() {
			if ( isset($this->WSDL) ) {
			try {
				$this->client = new SoapClient( $this->WSDL );
				//echo $this->WSDL;
				return true;
			} catch (SoapFault $fault) {
				echo $fault->getMessage();
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function setWebServiceURL( $webServiceURL ) {
		$this->WSDL = $webServiceURL;
	}
	
	public function getWebServiceURL() {
		return $this->WSDL;
	}
	
	public function setClientTimeout( $time ) {
		$this->client->timeout = $time;
	}
	
	public function setClientResponseTimeout( $time ) {
		$this->client->response_timeout = $time;
	}
	

	public function HelloWorld() {
		try {
			return $this->client->HelloWorld();
		} catch ( SoapFault $fault ) {
			//echo $fault->getMessage();
			return false;
		}
	}
	
	public function TD_GetCobroParameterList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetCobroParameterList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible realizar la Operacion (Cobro Parametros)",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetCobroParameterList

	public function TD_GetEnvioParameterList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetEnvioParameterList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible realizar la Operacion (Envio Parametros)",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetEnvioParameterList

	public function TD_GetOcupationList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetOcupationList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible realizar la Ocupacion",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetOcupationList

	public function TD_GetCountryList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetCountryList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Pais, Nacionalidad",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetCountryList

	public function TD_GetAvailableStateList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetAvailableStateList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Estados",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetAvailableStateList

	public function TD_GetStateList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetStateList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Estados",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetStateList

	public function TD_GetAvailableCityList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetAvailableCityList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Ciudad",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetAvailableCityList

	public function TD_GetCityList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetCityList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Ciudades",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetCityList

	public function TD_GetAgencia($parameters) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetAgencia( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Agencias",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetAgencia

	public function TD_GetNeighborhoodList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetNeighborhoodList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Estados",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetNeighborhoodList

	public function TD_GetIdList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetIdList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Estados",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetIdList

	public function TD_GetGenreList( $parameters ) {
		try{
			return array(
				'nCodigo'				=> 0,
				'bExito'				=> true,
				'sMensaje'				=> "Operacion Exitosa",
				'sMensajeDetallado'		=> "Ok",
				'oResultado'			=> $this->client->TD_GetGenreList( $parameters )
			);
		}
		catch(SoapFault $fault){
			return array(
				'nCodigo'				=> $fault->getCode(),
				'bExito'				=> false,
				'sMensaje'				=> "No fue posible obtener : Estados",
				'sMensajeDetallado'		=> "Mensaje: ".$fault->getMessage()." Archivo: ".$fault->getFile()." Linea: ".$fault->getLine(),
				'oResultado'			=> NULL
			);
		}
	} # TD_GetGenreList

} # class WSTransferDirecto

?>