<?php
class WebService {
	private $WSDL;
	private $client;
	private $clientError;
	
	public function __construct( $webServiceURL ) {
		$this->WSDL = $webServiceURL;
	}
	
	public function createClient() {
		if ( isset($this->WSDL) ) {
			try {
				$this->client = new SoapClient( $this->WSDL );
				return true;
			} catch (SoapFault $fault) {
				$this->clientError = $fault->getMessage();
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function getClient() {
		return $this->client;
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
	
	public function getClientError() {
		return $this->clientError;
	}
	
	public function getClientFunctions() {
		try {
			return $this->client->__getFunctions();
		} catch ( SoapFault $fault ) {
			$this->clientError = $fault->getMessage();
			return false;
		}
	}							
}
?>