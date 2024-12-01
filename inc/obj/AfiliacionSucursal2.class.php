<?php
	class AfiliacionSucursal2 {
		
		private $RBD;
		private $WBD;
		private $LOG;
		
		public $IDCLIENTE;
		public $IDSUCURSALTEMPORAL;
		public $SUCURSALES = array();
		public $ES_CLIENTE_REAL;
		public $IDCOSTO;
		public $IDNIVEL;
		
		function __construct($r, $w, $log){
			$this->RBD = $r;
			$this->WBD = $w;
			$this->LOG = $log;

			$this->ERROR_MSG	= "";
			$this->ERROR_CODE	= 0;
			$this->IDSUCURSALTEMPORAL = NULL;
			$this->IDCLIENTE = 0;
		}
		
		function load( $idCliente ) {
			$this->IDCLIENTE = $idCliente;
			$this->ES_CLIENTE_REAL = false;
			$sql = "CALL `afiliacion`.`SP_SUCURSAL_LOAD`($idCliente);";
			//var_dump($sql);
			$res = $this->RBD->query($sql);
			
			if ( !$this->RBD->error() ){
				if ( mysqli_num_rows($res) > 0 ) {
					while ( $row = $res->fetch_array() ) {
						if ( count($this->SUCURSALES) == 0 ) {
							$sucursal = array(
								"idSucursal" => (isset($row['idSucursal']))? $row['idSucursal'] : 'NULL',
								"idCorresponsal" => (isset($row['idCorresponsal']))? $row['idCorresponsal'] : 'NULL',
								"idCliente" => (isset($row['idCliente']))? $row['idCliente'] : 'NULL',
								"idSubCadena" => (isset($row['idSubCadena']))? $row['idSubCadena'] : 'NULL',
								"idCadena" => (isset($row['idCadena']))? $row['idCadena'] : 'NULL',
								"idEstatus" => (isset($row['idEstatus']))? $row['idEstatus'] : 'NULL',
								"idEmpleado" => (isset($row['idEmpleado']))? $row['idEmpleado'] : 'NULL',
								"idGrupo" => (isset($row['idGrupo']))? $row['idGrupo'] : 'NULL',
								"idReferencia" => (isset($row['idReferencia']))? $row['idReferencia'] : 'NULL',
								//"idDireccion" => (isset($row['idDireccion']))? $row['idDireccion'] : 'NULL',
								"idDireccion" => (isset($row['sucursalDireccion']))? $row['sucursalDireccion'] : 'NULL',
								"idVersion" => (isset($row['idVersion']))? $row['idVersion'] : 'NULL',
								"idGiro" => (isset($row['idGiro']))? $row['idGiro'] : 'NULL',
								"idForelo" => (isset($row['idForelo']))? $row['idForelo'] : 'NULL',
								"NombreSucursal" => (isset($row['NombreSucursal']))? (!preg_match('!!u', $row['NombreSucursal']))? utf8_encode($row['NombreSucursal']) : $row['NombreSucursal'] : 'NULL',
								"Telefono" => (isset($row['Telefono']))? (!preg_match('!!u', $row['Telefono']))? utf8_encode($row['Telefono']) : $row['Telefono'] : 'NULL',
								"Correo" => (isset($row['Correo']))? (!preg_match('!!u', $row['Correo']))? utf8_encode($row['Correo']) : $row['Correo'] : 'NULL',
								"FecActivacion" => (isset($row['FecActivacion']))? (!preg_match('!!u', $row['FecActivacion']))? utf8_encode($row['FecActivacion']) : $row['FecActivacion'] : 'NULL',
								"idDir" => (isset($row['idDir']))? $row['idDir'] : 'NULL',
								"idDireccionAntiguo" => (isset($row['idDireccionAntiguo']))? $row['idDireccionAntiguo'] : 'NULL',
								"Calle" => (isset($row['Calle']))? (!preg_match('!!u', $row['Calle']))? utf8_encode($row['Calle']) : $row['Calle'] : 'NULL',
								"NumInt" => (isset($row['NumInt']))? $row['NumInt'] : 'NULL',
								"NumExt" => (isset($row['NumExt']))? $row['NumExt'] : 'NULL',
								"idPais" => (isset($row['idPais']))? $row['idPais'] : 'NULL',
								"idEntidad" => (isset($row['idcEntidad']))? $row['idcEntidad'] : 'NULL',
								"idMunicipio" => (isset($row['idcMunicipio']))? $row['idcMunicipio'] : 'NULL',
								"idLocalidad" => (isset($row['idLocalidad']))? $row['idLocalidad'] : 0,
								"idColonia" => (isset($row['idcColonia']))? $row['idcColonia'] : 'NULL',
								"codigoPostal" => (isset($row['cpDireccion']))? $row['cpDireccion'] : 'NULL',
								"idCuentaBanco" => (isset($row['idCuentaBanco']))? $row['idCuentaBanco'] : 'NULL',
								"idEstatusCuenta" => (isset($row['idEstatusCuenta']))? $row['idEstatusCuenta'] : 'NULL',
								"idBanco" => (isset($row['idBanco']))? $row['idBanco'] : 'NULL',
								"NumCuenta" => (isset($row['NumCuenta']))? $row['NumCuenta'] : 'NULL',
								"CLABE" => (isset($row['CLABE']))? $row['CLABE'] : 'NULL',
								"Beneficiario" => (isset($row['Beneficiario']))? (!preg_match('!!u',$row['Beneficiario']))? utf8_encode($row['Beneficiario']) : $row['Beneficiario']: 'NULL',
								"Descripcion" => (isset($row['Descripcion']))? (!preg_match('!!u',$row['Descripcion']))? utf8_encode($row['Descripcion']) : $row['Descripcion'] : 'NULL',
								"idEstatusFORELO" => (isset($row['idEstatusFORELO']))? $row['idEstatusFORELO'] : 'NULL',
								"idComisiones" => (isset($row['idComisiones']))? $row['idComisiones'] : 'NULL',
								"idReembolso" => (isset($row['idReembolso']))? $row['idReembolso'] : 'NULL',
								"ReferenciaBanco" => (isset($row['ReferenciaBanco']))? $row['ReferenciaBanco'] : 'NULL',
								"idTipoDir" => (isset($row['idTipo']))? $row['idTipo'] : 'NULL'
							);
							//var_dump($sucursal);
							array_push($this->SUCURSALES, $sucursal);
						} else {
							$estaEnLista = false;
							foreach( $this->SUCURSALES as $sucursalInfo ) {
								if ( $sucursalInfo["idSucursal"] == $row['idCorresponsal'] ) {
									$estaEnLista = true;
								}
							}
							if ( !$estaEnLista ) {
								$sucursal = array(
									"idSucursal" => (isset($row['idSucursal']))? $row['idSucursal'] : 'NULL',
									"idCorresponsal" => (isset($row['idCorresponsal']))? $row['idCorresponsal'] : 'NULL',
									"idCliente" => (isset($row['idCliente']))? $row['idCliente'] : 'NULL',
									"idSubCadena" => (isset($row['idSubCadena']))? $row['idSubCadena'] : 'NULL',
									"idCadena" => (isset($row['idCadena']))? $row['idCadena'] : 'NULL',
									"idEstatus" => (isset($row['idEstatus']))? $row['idEstatus'] : 'NULL',
									"idEmpleado" => (isset($row['idEmpleado']))? $row['idEmpleado'] : 'NULL',
									"idGrupo" => (isset($row['idGrupo']))? $row['idGrupo'] : 'NULL',
									"idReferencia" => (isset($row['idReferencia']))? $row['idReferencia'] : 'NULL',
									//"idDireccion" => (isset($row['idDireccion']))? $row['idDireccion'] : 'NULL',
									"idDireccion" => (isset($row['sucursalDireccion']))? $row['sucursalDireccion'] : 'NULL',
									"idVersion" => (isset($row['idVersion']))? $row['idVersion'] : 'NULL',
									"idGiro" => (isset($row['idGiro']))? $row['idGiro'] : 'NULL',
									"idForelo" => (isset($row['idForelo']))? $row['idForelo'] : 'NULL',
									"NombreSucursal" => (isset($row['NombreSucursal']))? (!preg_match('!!u', $row['NombreSucursal']))? utf8_encode($row['NombreSucursal']) : $row['NombreSucursal'] : 'NULL',
									"Telefono" => (isset($row['Telefono']))? (!preg_match('!!u', $row['Telefono']))? utf8_encode($row['Telefono']) : $row['Telefono'] : 'NULL',
									"Correo" => (isset($row['Correo']))? (!preg_match('!!u', $row['Correo']))? utf8_encode($row['Correo']) : $row['Correo'] : 'NULL',
									"FecActivacion" => (isset($row['FecActivacion']))? (!preg_match('!!u', $row['FecActivacion']))? utf8_encode($row['FecActivacion']) : $row['FecActivacion'] : 'NULL',
									"idDir" => (isset($row['idDir']))? $row['idDir'] : 'NULL',
									"idDireccionAntiguo" => (isset($row['idDireccionAntiguo']))? $row['idDireccionAntiguo'] : 'NULL',
									"Calle" => (isset($row['Calle']))? (!preg_match('!!u', $row['Calle']))? utf8_encode($row['Calle']) : $row['Calle'] : 'NULL',
									"NumInt" => (isset($row['NumInt']))? $row['NumInt'] : 'NULL',
									"NumExt" => (isset($row['NumExt']))? $row['NumExt'] : 'NULL',
									"idPais" => (isset($row['idPais']))? $row['idPais'] : 'NULL',
									"idEntidad" => (isset($row['idcEntidad']))? $row['idcEntidad'] : 'NULL',
									"idMunicipio" => (isset($row['idcMunicipio']))? $row['idcMunicipio'] : 'NULL',
									"idLocalidad" => (isset($row['idLocalidad']))? $row['idLocalidad'] : 0,
									"idColonia" => (isset($row['idcColonia']))? $row['idcColonia'] : 'NULL',
									"codigoPostal" => (isset($row['cpDireccion']))? $row['cpDireccion'] : 'NULL',
									"idCuentaBanco" => (isset($row['idCuentaBanco']))? $row['idCuentaBanco'] : 'NULL',
									"idEstatusCuenta" => (isset($row['idEstatusCuenta']))? $row['idEstatusCuenta'] : 'NULL',
									"idBanco" => (isset($row['idBanco']))? $row['idBanco'] : 'NULL',
									"NumCuenta" => (isset($row['NumCuenta']))? $row['NumCuenta'] : 'NULL',
									"CLABE" => (isset($row['CLABE']))? $row['CLABE'] : 'NULL',
									"Beneficiario" => (isset($row['Beneficiario']))? (!preg_match('!!u',$row['Beneficiario']))? utf8_encode($row['Beneficiario']) : $row['Beneficiario']: 'NULL',
									"Descripcion" => (isset($row['Descripcion']))? (!preg_match('!!u',$row['Descripcion']))? utf8_encode($row['Descripcion']) : $row['Descripcion'] : 'NULL',
									"idEstatusFORELO" => (isset($row['idEstatusFORELO']))? $row['idEstatusFORELO'] : 'NULL',
									"idComisiones" => (isset($row['idComisiones']))? $row['idComisiones'] : 'NULL',
									"idReembolso" => (isset($row['idReembolso']))? $row['idReembolso'] : 'NULL',
									"ReferenciaBanco" => (isset($row['ReferenciaBanco']))? $row['ReferenciaBanco'] : 'NULL',									
									"idTipoDir" => (isset($row['idTipo']))? $row['idTipo'] : 'NULL'
								);
								array_push($this->SUCURSALES, $sucursal);
								if ( $row['idEstatus'] == 1 ) {
									$this->IDSUCURSALTEMPORAL = $row['idSucursal'];
								}
							}
						}
						/*echo "<pre>";
						print_r($this->SUCURSALES);
						echo "</pre>";*/
					}
				}
			} else {
				$this->EXISTE = FALSE;
				$this->ERROR_MSG = $this->RBD->error();
				$this->ERROR_CODE = 1;
			}
		}
		
		function loadClienteReal( $idCliente ) {
			$this->IDCLIENTE = $idCliente;
			$this->ES_CLIENTE_REAL = TRUE;
			$sql = "CALL `afiliacion`.`SP_SUCURSALCLIENTEREAL_LOAD`($idCliente);";
			//var_dump($sql);
			$res = $this->RBD->query($sql);
			
			if ( !$this->RBD->error() ){
				//var_dump("TEST A");
				if ( mysqli_num_rows($res) > 0 ) {
					//var_dump("TEST B");
					while ( $row = $res->fetch_array() ) {
						//var_dump("TEST C");
						if ( count($this->SUCURSALES) == 0 ) {
							$sucursal = array(
								"idSucursal" => (isset($row['idSucursal']))? $row['idSucursal'] : 'NULL',
								"idCorresponsal" => (isset($row['idCorresponsal']))? $row['idCorresponsal'] : 'NULL',
								"idCliente" => (isset($row['idCliente']))? $row['idCliente'] : 'NULL',
								"idSubCadena" => (isset($row['idSubCadena']))? $row['idSubCadena'] : 'NULL',
								"idCadena" => (isset($row['idCadena']))? $row['idCadena'] : 'NULL',
								"idEstatus" => (isset($row['idEstatus']))? $row['idEstatus'] : 'NULL',
								"idEmpleado" => (isset($row['idEmpleado']))? $row['idEmpleado'] : 'NULL',
								"idGrupo" => (isset($row['idGrupo']))? $row['idGrupo'] : 'NULL',
								"idReferencia" => (isset($row['idReferencia']))? $row['idReferencia'] : 'NULL',
								//"idDireccion" => (isset($row['idDireccion']))? $row['idDireccion'] : 'NULL',
								"idDireccion" => (isset($row['sucursalDireccion']))? $row['sucursalDireccion'] : 'NULL',
								"idVersion" => (isset($row['idVersion']))? $row['idVersion'] : 'NULL',
								"idGiro" => (isset($row['idGiro']))? $row['idGiro'] : 'NULL',
								"idForelo" => (isset($row['idForelo']))? $row['idForelo'] : 'NULL',
								"NombreSucursal" => (isset($row['NombreSucursal']))? (!preg_match('!!u', $row['NombreSucursal']))? utf8_encode($row['NombreSucursal']) : $row['NombreSucursal'] : 'NULL',
								"Telefono" => (isset($row['Telefono']))? (!preg_match('!!u', $row['Telefono']))? utf8_encode($row['Telefono']) : $row['Telefono'] : 'NULL',
								"Correo" => (isset($row['Correo']))? (!preg_match('!!u', $row['Correo']))? utf8_encode($row['Correo']) : $row['Correo'] : 'NULL',
								"FecActivacion" => (isset($row['FecActivacion']))? (!preg_match('!!u', $row['FecActivacion']))? utf8_encode($row['FecActivacion']) : $row['FecActivacion'] : 'NULL',
								"idDir" => (isset($row['idDir']))? $row['idDir'] : 'NULL',
								"idDireccionAntiguo" => (isset($row['idDireccionAntiguo']))? $row['idDireccionAntiguo'] : 'NULL',
								"Calle" => (isset($row['Calle']))? (!preg_match('!!u', $row['Calle']))? utf8_encode($row['Calle']) : $row['Calle'] : 'NULL',
								"NumInt" => (isset($row['NumInt']))? $row['NumInt'] : 'NULL',
								"NumExt" => (isset($row['NumExt']))? $row['NumExt'] : 'NULL',
								"idPais" => (isset($row['idPais']))? $row['idPais'] : 'NULL',
								"idEntidad" => (isset($row['idcEntidad']))? $row['idcEntidad'] : 'NULL',
								"idMunicipio" => (isset($row['idcMunicipio']))? $row['idcMunicipio'] : 'NULL',
								"idLocalidad" => (isset($row['idLocalidad']))? $row['idLocalidad'] : 0,
								"idColonia" => (isset($row['idcColonia']))? $row['idcColonia'] : 'NULL',
								"codigoPostal" => (isset($row['cpDireccion']))? $row['cpDireccion'] : 'NULL',
								"idCuentaBanco" => (isset($row['idCuentaBanco']))? $row['idCuentaBanco'] : 'NULL',
								"idEstatusCuenta" => (isset($row['idEstatusCuenta']))? $row['idEstatusCuenta'] : 'NULL',
								"idBanco" => (isset($row['idBanco']))? $row['idBanco'] : 'NULL',
								"NumCuenta" => (isset($row['NumCuenta']))? $row['NumCuenta'] : 'NULL',
								"CLABE" => (isset($row['CLABE']))? $row['CLABE'] : 'NULL',
								"Beneficiario" => (isset($row['Beneficiario']))? (!preg_match('!!u',$row['Beneficiario']))? utf8_encode($row['Beneficiario']) : $row['Beneficiario']: 'NULL',
								"Descripcion" => (isset($row['Descripcion']))? (!preg_match('!!u',$row['Descripcion']))? utf8_encode($row['Descripcion']) : $row['Descripcion'] : 'NULL',
								"idEstatusFORELO" => (isset($row['idEstatusFORELO']))? $row['idEstatusFORELO'] : 'NULL',
								"idComisiones" => (isset($row['idComisiones']))? $row['idComisiones'] : 'NULL',
								"idReembolso" => (isset($row['idReembolso']))? $row['idReembolso'] : 'NULL',
								"ReferenciaBanco" => (isset($row['ReferenciaBanco']))? $row['ReferenciaBanco'] : 'NULL',
								"idTipoDir" => (isset($row['idTipo']))? $row['idTipo'] : 'NULL'
							);
							array_push($this->SUCURSALES, $sucursal);
						} else {
							$estaEnLista = false;
							foreach( $this->SUCURSALES as $sucursalInfo ) {
								if ( $sucursalInfo["idSucursal"] == $row['idCorresponsal'] ) {
									$estaEnLista = true;
								}
							}
							if ( !$estaEnLista ) {
								$sucursal = array(
									"idSucursal" => (isset($row['idSucursal']))? $row['idSucursal'] : 'NULL',
									"idCorresponsal" => (isset($row['idCorresponsal']))? $row['idCorresponsal'] : 'NULL',
									"idCliente" => (isset($row['idCliente']))? $row['idCliente'] : 'NULL',
									"idSubCadena" => (isset($row['idSubCadena']))? $row['idSubCadena'] : 'NULL',
									"idCadena" => (isset($row['idCadena']))? $row['idCadena'] : 'NULL',
									"idEstatus" => (isset($row['idEstatus']))? $row['idEstatus'] : 'NULL',
									"idEmpleado" => (isset($row['idEmpleado']))? $row['idEmpleado'] : 'NULL',
									"idGrupo" => (isset($row['idGrupo']))? $row['idGrupo'] : 'NULL',
									"idReferencia" => (isset($row['idReferencia']))? $row['idReferencia'] : 'NULL',
									//"idDireccion" => (isset($row['idDireccion']))? $row['idDireccion'] : 'NULL',
									"idDireccion" => (isset($row['sucursalDireccion']))? $row['sucursalDireccion'] : 'NULL',
									"idVersion" => (isset($row['idVersion']))? $row['idVersion'] : 'NULL',
									"idGiro" => (isset($row['idGiro']))? $row['idGiro'] : 'NULL',
									"idForelo" => (isset($row['idForelo']))? $row['idForelo'] : 'NULL',
									"NombreSucursal" => (isset($row['NombreSucursal']))? (!preg_match('!!u', $row['NombreSucursal']))? utf8_encode($row['NombreSucursal']) : $row['NombreSucursal'] : 'NULL',
									"Telefono" => (isset($row['Telefono']))? (!preg_match('!!u', $row['Telefono']))? utf8_encode($row['Telefono']) : $row['Telefono'] : 'NULL',
									"Correo" => (isset($row['Correo']))? (!preg_match('!!u', $row['Correo']))? utf8_encode($row['Correo']) : $row['Correo'] : 'NULL',
									"FecActivacion" => (isset($row['FecActivacion']))? (!preg_match('!!u', $row['FecActivacion']))? utf8_encode($row['FecActivacion']) : $row['FecActivacion'] : 'NULL',
									"idDir" => (isset($row['idDir']))? $row['idDir'] : 'NULL',
									"idDireccionAntiguo" => (isset($row['idDireccionAntiguo']))? $row['idDireccionAntiguo'] : 'NULL',
									"Calle" => (isset($row['Calle']))? (!preg_match('!!u', $row['Calle']))? utf8_encode($row['Calle']) : $row['Calle'] : 'NULL',
									"NumInt" => (isset($row['NumInt']))? $row['NumInt'] : 'NULL',
									"NumExt" => (isset($row['NumExt']))? $row['NumExt'] : 'NULL',
									"idPais" => (isset($row['idPais']))? $row['idPais'] : 'NULL',
									"idEntidad" => (isset($row['idcEntidad']))? $row['idcEntidad'] : 'NULL',
									"idMunicipio" => (isset($row['idcMunicipio']))? $row['idcMunicipio'] : 'NULL',
									"idLocalidad" => (isset($row['idLocalidad']))? $row['idLocalidad'] : 0,
									"idColonia" => (isset($row['idcColonia']))? $row['idcColonia'] : 'NULL',
									"codigoPostal" => (isset($row['cpDireccion']))? $row['cpDireccion'] : 'NULL',
									"idCuentaBanco" => (isset($row['idCuentaBanco']))? $row['idCuentaBanco'] : 'NULL',
									"idEstatusCuenta" => (isset($row['idEstatusCuenta']))? $row['idEstatusCuenta'] : 'NULL',
									"idBanco" => (isset($row['idBanco']))? $row['idBanco'] : 'NULL',
									"NumCuenta" => (isset($row['NumCuenta']))? $row['NumCuenta'] : 'NULL',
									"CLABE" => (isset($row['CLABE']))? $row['CLABE'] : 'NULL',
									"Beneficiario" => (isset($row['Beneficiario']))? (!preg_match('!!u',$row['Beneficiario']))? utf8_encode($row['Beneficiario']) : $row['Beneficiario']: 'NULL',
									"Descripcion" => (isset($row['Descripcion']))? (!preg_match('!!u',$row['Descripcion']))? utf8_encode($row['Descripcion']) : $row['Descripcion'] : 'NULL',
									"idEstatusFORELO" => (isset($row['idEstatusFORELO']))? $row['idEstatusFORELO'] : 'NULL',
									"idComisiones" => (isset($row['idComisiones']))? $row['idComisiones'] : 'NULL',
									"idReembolso" => (isset($row['idReembolso']))? $row['idReembolso'] : 'NULL',
									"ReferenciaBanco" => (isset($row['ReferenciaBanco']))? $row['ReferenciaBanco'] : 'NULL',									
									"idTipoDir" => (isset($row['idTipo']))? $row['idTipo'] : 'NULL'
								);
								array_push($this->SUCURSALES, $sucursal);
								if ( $row['idEstatus'] == 1 ) {
									$this->IDSUCURSALTEMPORAL = $row['idSucursal'];
								}
							}
						}
					}
				}
			} else {
				$this->EXISTE = FALSE;
				$this->ERROR_MSG = $this->RBD->error();
				$this->ERROR_CODE = 1;
			}		
		}
		
		function getSucursal( $idSucursal ) {
			$sucursal = NULL;
			foreach( $this->SUCURSALES as $sucursalInfo ) {
				if ( $idSucursal == $sucursalInfo['idSucursal'] ) {
					$sucursal = $sucursalInfo;
				}
			}
			
			return $sucursal;
		}
		
		function existeSucursal( $idSucursal ) {
			$estaEnLista = false;
			foreach( $this->SUCURSALES as $sucursalInfo ) {
				if ( $idSucursal == $sucursalInfo['idSucursal'] ) {
					$estaEnLista = true;
				}
			}
			
			return $estaEnLista;	
		}
		
		function getContactos( $idSucursal ) {
			$QUERY = "CALL `afiliacion`.`SP_CONTACTOSUCURSAL_GET`($idSucursal);";
			//var_dump($QUERY);
			$sql = $this->WBD->query($QUERY);
			if(!$this->WBD->error()){
				$contactos = array();
				while( $res = mysqli_fetch_assoc($sql) ) {
					$contactos[] = $res;
				}
				$response = array(
					'success'	=> true,
					'data'		=> array(
						'contactos' => $contactos
					)
				);
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Direccion : ".$QUERY." -- ".$this->WBD->error(), false);
			}
			
			return $response;			
		}
		
		function crearSucursal( $idSucursal, $sucursal ) {
			$idEmpleado = $_SESSION['idU'];
			
			$QUERY = "CALL `afiliacion`.`SP_SUCURSAL_CREAR`({$sucursal['idCorresponsal']}, {$sucursal['idCliente']}, {$sucursal['idSubCadena']}, {$sucursal['idCadena']},
			{$sucursal['idEstatus']}, $idEmpleado, {$sucursal['idGrupo']}, {$sucursal['idReferencia']}, {$sucursal['idDireccion']}, {$sucursal['idGiro']},
			{$sucursal['idForelo']}, {$sucursal['NombreSucursal']}, {$sucursal['Telefono']}, {$sucursal['Correo']}, {$sucursal['FecActivacion']}, {$sucursal['idVersion']});";
			
			//var_dump($QUERY);
			
			$sql = $this->WBD->query($QUERY);
			
			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);
				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idSucursal' => $res['idSucursal']
					)
				);
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Direccion : ".$QUERY." -- ".$this->WBD->error(), false);
			}
			
			return $response;
		}
		
		function editarSucursal( $idSucursal, $sucursal ) {
			$idEmpleado = $_SESSION['idU'];
			
			$QUERY = "CALL `afiliacion`.`SP_SUCURSAL_UPDATE`($idSucursal, {$sucursal['idCorresponsal']}, {$sucursal['idCliente']}, {$sucursal['idSubCadena']},
			{$sucursal['idCadena']}, {$sucursal['idEstatus']}, $idEmpleado, {$sucursal['idGrupo']}, {$sucursal['idReferencia']}, {$sucursal['idDireccion']},
			{$sucursal['idVersion']}, {$sucursal['idGiro']}, {$sucursal['idForelo']}, {$sucursal['NombreSucursal']}, {$sucursal['Telefono']}, {$sucursal['Correo']},
			{$sucursal['FecActivacion']});";
			
			//var_dump($QUERY);
			
			$sql = $this->WBD->query($QUERY);
			
			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);
				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idSucursal' => $res['idSucursal']
					)
				);
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Direccion : ".$QUERY." -- ".$this->WBD->error(), false);
			}
			
			return $response;
		}
		
		function crearDireccion( $idSucursal, $sucursal ){
			$idUsuario = $_SESSION['idU'];

			$QUERY = "CALL `afiliacion`.`SP_DIRECCION_CREAR`({$sucursal['Calle']}, {$sucursal['NumInt']}, {$sucursal['NumExt']}, {$sucursal['idPais']}, {$sucursal['idEntidad']}, {$sucursal['idMunicipio']}, {$sucursal['idLocalidad']}, {$sucursal['idColonia']}, {$sucursal['codigoPostal']}, {$sucursal['idTipoDir']}, $idUsuario,
			{$sucursal['idDireccion']})";
			//var_dump($QUERY);
			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);
				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idDireccion' => $res['idDireccionF']
					)
				);
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Direccion : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}
		
		function editarDireccion( $idSucursal, $sucursal ){
			$idUsuario = $_SESSION['idU'];
						
			$QUERY = "CALL `afiliacion`.`SP_DIRECCION_UPDATE`({$sucursal['idDir']}, {$sucursal['Calle']}, {$sucursal['NumInt']}, {$sucursal['NumExt']}, {$sucursal['idPais']}, {$sucursal['idEntidad']}, {$sucursal['idMunicipio']}, {$sucursal['idLocalidad']}, {$sucursal['idColonia']}, {$sucursal['codigoPostal']}, {$sucursal['idTipoDir']}, $idUsuario, {$sucursal['idDireccionAntiguo']})";
			
			//var_dump($QUERY);
			
			$sql = $this->WBD->query($QUERY);

			if ( !$this->WBD->error() ) {
				$res = mysqli_fetch_assoc($sql);
				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idDir' => $res['idDireccionF']
					)
				);
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Direccion : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}
		
		function eliminarDireccion( $idDireccion ) {
			$QUERY = "CALL `afiliacion`.`SP_DIRECCION_ELIMINAR`($idDireccion)";
			
			//var_dump($QUERY);
			
			$sql = $this->WBD->query($QUERY);
			
			if ( !$this->WBD->error() ) {
				$res = mysqli_fetch_assoc($sql);
				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idDir' => $res['idDireccionF']
					)
				);
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Direccion : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}
		
		function agregarContacto( $idSucursal, $contacto ) {
			$idEmpleado = $_SESSION['idU'];
			
			$QUERY = "CALL `afiliacion`.`SP_CONTACTO_CREAR`({$contacto['tipoContactoID']}, '{$contacto['nombre']}', '{$contacto['apellidoPaterno']}', '{$contacto['apellidoMaterno']}', '{$contacto['telefono']}', '{$contacto['extension']}', '{$contacto['correo']}', {$contacto['idEstatus']}, $idEmpleado);";
			
			//var_dump($QUERY);
			
			$sql = $this->WBD->query($QUERY);

			if ( !$this->WBD->error() ) {
				$res = mysqli_fetch_assoc($sql);
				$idContacto = $res["idContacto"];
				
				$QUERY = "CALL `afiliacion`.`SP_SUCURSALCONTACTO_CREAR`($idSucursal, $idContacto, {$contacto['tipoContactoID']}, {$contacto['idEstatus']}, $idEmpleado);";
				
				//var_dump($QUERY);
				
				$sql = $this->WBD->query($QUERY);
				
				if (!$this->WBD->error()) {
					$response = array(
						'success'	=> true,
						'data'		=> array(
							'idContacto' => $idContacto
						)
					);
				} else {
					$response = array(
						'success'	=> false,
						'data'		=> array(),
						'errmsg'	=> $this->WBD->error()
					);
					$this->LOG->error("Error al Asociar Contacto con Sucursal : ".$QUERY." -- ".$this->WBD->error(), false);				
				}
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Crear Contacto : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}
		
		function editarContacto( $idSucursal, $contacto ) {
			$idEmpleado = $_SESSION['idU'];
			
			$QUERY = "CALL `afiliacion`.`SP_CONTACTO_UPDATE`({$contacto['id']}, {$contacto['idContacto']}, {$contacto['idTipo']}, {$contacto['nombre']}, {$contacto['apellidoPaterno']}, {$contacto['apellidoMaterno']}, {$contacto['telefono']}, {$contacto['extension']}, {$contacto['correo']}, {$contacto['idEstatus']}, $idEmpleado);";
			
			//var_dump($QUERY);
			
			$sql = $this->WBD->query($QUERY);

			if ( !$this->WBD->error() ) {
				$res = mysqli_fetch_assoc($sql);
				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idContacto' => $res["idContacto"]
					)
				);				
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Crear Contacto : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}

		function editarCorresponsalContacto( $idSucursal, $contacto ) {
			$idEmpleado = $_SESSION['idU'];
			
			$QUERY = "CALL `afiliacion`.`SP_CORRESPONSALCONTACTO_UPDATE`( $idSucursal, {$contacto['id']}, {$contacto['idEstatus']} );";
			
			//var_dump($QUERY);
			
			$sql = $this->WBD->query($QUERY);

			if ( !$this->WBD->error() ) {
				$res = mysqli_fetch_assoc($sql);
				$response = array(
					'success'	=> true,
					'data'		=> array()
				);				
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Crear Contacto : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}
		
		function crearReferenciaBancaria($idSucursal, $idCliente, $idSubcadena){
			if($idSucursal == 0){
				$idS = 0;
			}
			else{
				$SUC = $this->getSucursal($idSucursal);
				$idS = $SUC['idSucursal'];
			}

			$fecha		= date("Y-m-d");
			$idEmpleado = $_SESSION['idU'];

			$QUERY = "CALL `afiliacion`.`SP_REFERENCIASBANCARIAS_COUNT`('$fecha')";
			$sql = $this->RBD->query($QUERY);

			if(!$this->RBD->error()){

				$res = mysqli_fetch_assoc($sql);
				$contador = (int)$res['cuenta'];
				//$incremental = (int)$res['cuenta'] + 1;
				do {
					$contador = $contador + 1;
					if ( $contador > 999 ) {
						$referenciaCreada = false;
						break;
					}					
					$incremental = str_pad($contador, 3, '0', STR_PAD_LEFT);
	
					$anio	= date("y");
					$mes	= date("m");
					$dia	= date("d");
	
					$numeroCuenta = $anio.$mes.$dia.$incremental.'A';
	
					$QUERY2 = "CALL `data_contable`.`SP_ALG_REFBNMX`('$numeroCuenta', @refBancaria);";
					$sql2 = $this->RBD->query($QUERY2);
	
					if(!$this->RBD->error()){
						$row = mysqli_fetch_assoc($sql2);
						$referenciaBancaria = $row['@REFERENCIA'];
	
						$QUERY3 = "CALL `afiliacion`.`SP_FORELO_CREAR`($idCliente, $idSubcadena, $idS, 0, 0, '$referenciaBancaria')";
						//var_dump($QUERY3);
						$sql3 = $this->WBD->query($QUERY3);
	
						if(!$this->WBD->error()){
							$res = mysqli_fetch_assoc($sql3);
							$referenciaCreada = true;
							if ( $res["idForelo"] == -500 ) {
								$referenciaCreada = false;
							}
							if ( $referenciaCreada ) {
								$response = array(
									'success'	=> true,
									'data'		=> array(
										'idForelo'	=> $res['idForelo'],
										'referenciaBancaria' => $referenciaBancaria
									)
								);
							}
						}
						else{
							$this->LOG->error("Error al Insertar La referencia Bancaria ".$QUERY3." | ".$this->WBD->error());
							$response = array(
								'success'	=> false,
								'errmsg'	=> $this->WBD->error()
							);
						}
					}else{
						$this->LOG->error("Error al Obtener Numero de Verificacion ".$QUERY2." | ".$this->RBD->error());
						$response = array(
							'success'	=> false,
							'errmsg'	=> $this->RBD->error()
						);
					}
				} while( !$referenciaCreada );
				if ( !$referenciaCreada ) {
					$this->LOG->error("Se trato de crear una Referencia cuyo incremental era mayor a 999. Incremental: $contador Referencia: $referenciaBancaria");
					$response = array(
						'success'	=> false,
						'errmsg'	=> "No es posible crear mas Referencias para este dia. Solo es posible crear hasta 999 Referencias por dia."
					);				
				}
			}else{
				$this->LOG->error("Error al Contar Referencias ".$QUERY." | ".$this->RBD->error());
				$response = array(
					'success'	=> false,
					'errmsg'	=> $this->RBD->error()
				);
			}

			return $response;
		}
		
		function actualizarForelo( $idForelo, $idSucursal, $comisiones, $reembolso, $idCuenta, $referenciaBancaria ){
			if($idSucursal == 0){
				$idS = 0;
			}
			else{
				$SUC = $this->getSucursal($idSucursal);
				$idS = $SUC['idSucursal'];
			}

			$QUERY = "CALL `afiliacion`.`SP_FORELO_UPDATE`($idForelo, $idS, $comisiones, $reembolso, $idCuenta, '$referenciaBancaria');";

			//var_dump($QUERY);

			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);

				$response = array(
					'success'	=> true,
					'data'		=> array()
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al ACtualizar Datos de forelo : ".$QUERY." | ".$this->WBD->error(), false);
			}

			return $response;
		}
		
		function eliminarForelo( $idForelo ){
			$QUERY = "CALL `afiliacion`.`SP_FORELO_ELIMINAR`($idForelo);";
			//var_dump($QUERY);
			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);

				$response = array(
					'success'	=> true,
					'data'		=> array()
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Eliminar Forelo : ".$QUERY." | ".$this->WBD->error(), false);
			}

			return $response;	
		}		

		function completoSucursal($idSucursal){
			// obtener la sucursal
			$SUCURSAL = $this->getSucursal($idSucursal);
			//var_dump($SUCURSAL);
			// obtener los contactos de la sucursal
			$response = $this->getContactos($idSucursal);
			if($response['success'] == true){
				$CLIENTE = new AfiliacionCliente($this->RBD, $this->WBD, $this->LOG);
				if(!$this->ES_CLIENTE_REAL){
					$CLIENTE->load($this->IDCLIENTE);
				}
				else{
					// obtener tipo forelo
					$sqlC = $this->RBD->query("CALL `redefectiva`.`SP_CUOTAS_OBTENER`($this->IDCLIENTE)");
					$res = mysqli_fetch_assoc($sqlC);

					if($res['cuenta'] > 0){
						$CLIENTE->TIPOFORELO = 1;
					}
					else{
						$CLIENTE->TIPOFORELO = 2;
					}
				}
				$tipoForelo = $CLIENTE->TIPOFORELO;
				$contactos = $response['data']['contactos'];
				if($tipoForelo == 1){
					//echo "tipo 1";
					if(count($contactos) > 0){
						return 0;
					}
					else{
						return 1;
					}
				}
				else{
					//echo "tipo 2";
					if($SUCURSAL['idComisiones'] == 'NULL' || $SUCURSAL['idReembolso'] == 'NULL'){
						return 1;
					}
					else{
						if(count($contactos) > 0){
							return 0;
						}
						else{
							return 1;
						}
					}
				}
			}
			else{
				return 1;
			}
		}

		function prepararSucursal($idSucursal){
			$idEstatus = $this->completoSucursal($idSucursal);

			$QUERY = "CALL `afiliacion`.`SP_SUCURSAL_PREPARAR`($idSucursal, $idEstatus)";

			$this->WBD->query($QUERY);

			if($this->WBD->error()){
				$this->LOG->error($QUERY." | ".$this->WBD->error());
			}
		}

		function crearCuotas( $idCosto, $idNivel, $idForelo, $idCliente, $idSubcadena, $idSucursal ){
			$sql = $this->RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`($idCosto, $idNivel)");
			$res = mysqli_fetch_assoc($sql);
						
			$montoAfiliacion = $res['Afiliacion'];
			$montoCuota = $res['Cuota'];
			$cobroA		= (!empty($res['CobroA']))? $res['CobroA'] : 0;
			$tipoCobro	= (!empty($res['TipoCobro']))? $res['TipoCobro'] : 0;
			
			if($cobroA == 1){// cobro a sucursal
				$QUERY = "CALL `afiliacion`.`SP_CUOTA_CREAR`($idForelo, $idCliente, $idSubcadena, $idSucursal, 0, '$montoAfiliacion', '$montoCuota', 'Cuota de sucursal', $tipoCobro, $cobroA)";
				$sql = $this->WBD->query($QUERY);

				if ( !$this->WBD->error() ) {
					$res = mysqli_fetch_assoc($sql);
					$response = array(
						'success'	=> true,
						'data'		=> array()
					);
				} else {
					$response = array(
						'success'	=> false,
						'data'		=> array(),
						'errmsg'	=> 'Configuracion de costos inv�lida.'
					);
					$this->LOG->error("Error al Crear La Cuota : ".$QUERY." -- ".$this->WBD->error(), false);
				}
			}
			else if($cobroA == 2){// cobro a cliente
				if(!$this->ES_CLIENTE_REAL){
					$CLIENTE = new AfiliacionCliente($this->RBD, $this->WBD, $this->LOG);
					$CLIENTE->load($idCliente);
					$idForelo = $CLIENTE->IDFORELO;
				}
				else{
					$idForelo = 0;
				}
				$this->ID_SUCURSAL_ACTIVA = $idSucursal;
				if(!$this->ES_CLIENTE_REAL){
					$this->IDCLIENTE = $idCliente;
				}
				else{
					$this->IDCLIENTE = $idSubCadena;
				}
				//var_dump("idForelo: $idForelo");
				//var_dump("A punto de entrar a actualizacion de cuotas");
				$response = $this->actualizarCuotas();
			}

			return $response;
		}

		function eliminarCuotas() {
			$sucursales = $this->SUCURSALES;
			if ( count($sucursales) > 0 ) {
				$error = false;
				foreach ( $sucursales as $sucursal ) {
					$QUERY = "CALL `afiliacion`.`SP_CUOTA_ELIMINAR`( $this->IDCLIENTE, 0,  {$sucursal['idSucursal']} )";
					$sql = $this->WBD->query($QUERY);
					if ( $this->WBD->error() ) {
						$error = true;
						break;
					}
				}
				if ( !$error ) {
					$response = array(
						'success'	=> true,
						'data'		=> array()
					);
				} else {
					$response = array(
						'success'	=> false,
						'data'		=> array(),
						'errmsg'	=> $this->WBD->error()
					);
					$this->LOG->error("Error al Crear La Cuota : ".$QUERY." -- ".$this->WBD->error(), false);
				}
			}
		}

		function eliminarCuota( $idSucursal ) {
			$SUCURSAL = $this->getSucursal( $idSucursal );
			$QUERY = "CALL `afiliacion`.`SP_CUOTA_ELIMINAR`( {$SUCURSAL['idCliente']}, {$SUCURSAL['idSubCadena']}, $idSucursal )";
			$sql = $this->WBD->query($QUERY);
			if ( $this->WBD->error() ) {
				$error = true;
				//break;
			}
			if ( !$error ) {
				$response = array(
					'success'	=> true,
					'data'		=> array()
				);
			} else {
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Eliminar la Cuota : ".$QUERY." -- ".$this->WBD->error(), false);
			}
			return $response;
		}

		function actualizarCuotas(){
			//$this->LOG->logMsg('actualizando cuotas');
			//$this->LOG->logMsg("cliente real ".$this->ES_CLIENTE_REAL);
			//if(!$this->ES_CLIENTE_REAL){

				$CLIENTE = new AfiliacionCliente($this->RBD, $this->WBD, $this->LOG);
				if(!$this->ES_CLIENTE_REAL){
					$CLIENTE->load($this->IDCLIENTE);
				}else{
					$CLIENTE->loadClienteReal($this->IDCLIENTE, 0);
				}

				$numSucursales	= $CLIENTE->NUMEROCORRESPONSALES;
				$idCosto		= $CLIENTE->IDCOSTO;
				$idExpediente	= $CLIENTE->IDNIVEL;
				
				$sql = $this->RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`($idCosto, $idExpediente)");
				$res = mysqli_fetch_assoc($sql);

				if ( $res['codigo'] == -500 ) {
					$this->LOG->error($res['mensaje']);
					$response = array(
						'success'	=> false,
						'msg'		=> 'No es posible actualizar costos de la sucursal porque es necesario que el cliente tenga un expediente definido.',
						'errmsg'	=> 'No es posible actualizar costos de la sucursal porque es necesario que el cliente tenga un expediente definido.'
					);
					return $response;
				}

				$cobroA		= (!empty($res['CobroA']))? $res['CobroA'] : 0;
				$tipoCobro	= (!empty($res['TipoCobro']))? $res['TipoCobro'] : 0;

				if(!$this->ES_CLIENTE_REAL){
					if($tipoCobro == 0){
						$cuotaMensual = $CLIENTE->NUMEROCORRESPONSALES * $res['Cuota'];
					}else if($tipoCobro == 1){
						if($CLIENTE->MAXIMOPUNTOS == 0){
							$cuotaMensual = $CLIENTE->MINIMOPUNTOS * $res['Cuota'];
						}else{
							$cuotaMensual = $CLIENTE->MAXIMOPUNTOS * $res['Cuota'];
						}
					}
				}else{
					if($tipoCobro == 0){
						$cuotaMensual = $CLIENTE->NUMEROCORRESPONSALESNUEVOS * $res['Cuota'];
					}else if($tipoCobro == 1){
						if($CLIENTE->MAXIMOPUNTOS == 0){
							$cuotaMensual = $CLIENTE->MINIMOPUNTOS * $res['Cuota'];
						}else{
							$cuotaMensual = $CLIENTE->MAXIMOPUNTOS * $res['Cuota'];
						}
					}				
				}
				
				//var_dump("TEST 1");
				
				$monto = $CLIENTE->PAGO_PENDIENTE/*$numSucursales * $res['Afiliacion']*/;
				$montoAfiliacion = number_format($monto, 4, '.', '');

				//var_dump("TEST 2");

				if($CLIENTE->TIPOFORELO == 1 || $cobroA == 2){
					//var_dump("TEST 3");
					if($cobroA == 2){
						//var_dump("TEST 4");
						$sql2 = $this->RBD->query("SELECT `id`, `idTipoCuota` FROM `afiliacion`.`dat_cuota` WHERE `idCliente` = $this->IDCLIENTE AND `idSucursal` = 0 AND `idSubCadena` = 0 AND `idForelo` = {$CLIENTE->IDFORELO} AND `idEstatus` = 1");
						/*var_dump("SELECT `id`, `idTipoCuota` FROM `afiliacion`.`dat_cuota` WHERE `idCliente` = $this->IDCLIENTE AND `idSucursal` = 0 AND `idSubCadena` = 0 AND `idForelo` = {$CLIENTE->IDFORELO} AND `idEstatus` = 1");*/
						//var_dump("TEST 5");
						if(mysqli_num_rows($sql2) > 0){
							//$QUERY = "CALL `afiliacion`.`SP_CUOTA_ACTUALIZAR`($CLIENTE->ID_CLIENTE, 0, 0, '$montoAfiliacion', '$cuotaMensual')";
							while($res2 = mysqli_fetch_assoc($sql2)){
								if($res2['id'] > 0){

									if($res2['idTipoCuota'] == 2){
										$monto = $cuotaMensual;
									}
									if($res2['idTipoCuota'] == 99){
										$monto = $montoAfiliacion;
									}

									$QUERY = "CALL `afiliacion`.`SP_CUOTAS_ACTUALIZAR`({$res2['id']}, $monto, {$res2['idTipoCuota']}, $tipoCobro, $cobroA)";
									//var_dump($QUERY);
									//$this->LOG->logMsg($QUERY);
									$this->WBD->query($QUERY);

									if($this->WBD->error()){
										$this->LOG("Error al actualizar cuota idTipoCuota=>".$res['idTipoCuota']." | ".$QUERY." | ".$this->WBD->error());
									}

									$actualizadas++;
								}
							}
							$this->WBD->query($QUERY);
							if(!$this->WBD->error()){
								$response = array(
									'success'	=> true,
									'msg'		=> 'Cuotas Actualizadas'
								);
							}
							else{
								$this->LOG->error('Error al actualizar las cuotas '.' | '.$QUERY.' | '.$this->WBD->error());
								$response = array(
									'success'	=> false,
									'msg'		=> 'Ha ocurrido un error al actualizar las Cuotas',
									'errmsg'	=> $this->WBD->error()
								);
							}
						}
						else{
							//var_dump("TEST 5");
							$response = $CLIENTE->crearCuotas();
							/*$SUCURSAL = $this->getSucursal($this->ID_SUCURSAL_ACTIVA);
							$response = $this->crearCuotas($CLIENTE->IDCOSTO, $CLIENTE->IDNIVEL, $CLIENTE->IDFORELO, $CLIENTE->ID_CLIENTE, $CLIENTE->ID_SUBCADENA, 0);*/
						}

					}
					else{
						//var_dump("TEST 6");
						$SUCURSAL = $this->getSucursal($this->ID_SUCURSAL_ACTIVA);
						$response = $this->crearCuotas($CLIENTE->IDCOSTO, $CLIENTE->IDNIVEL, $SUCURSAL['idForelo'], $CLIENTE->ID_CLIENTE, $CLIENTE->ID_SUBCADENA, $this->ID_SUCURSAL_ACTIVA);
					}
				}
			//}
			//else{
				//$QUERY = "CALL `redefectiva`.`SP_CLIENTE_DATOS`($this->IDCLIENTE)";

				//$sql = $this->RBD->query($QUERY);
				//if(!$this->RBD->error()){
					// obtener las cuotas y tipo forelo
					/*$sqlC = $this->RBD->query("CALL `redefectiva`.`SP_CUOTAS_OBTENER`($this->IDCLIENTE)");

					$res = mysqli_fetch_assoc($sqlC);

					// es forelo compartido
					if($res['cuenta'] > 0){
						$sql2 = $this->RBD->query("SELECT `id`, `idTipoCuota` FROM `afiliacion`.`dat_cuota` WHERE `idSubCadena` = $this->IDCLIENTE AND `idSucursal` = 0 AND `idCliente` = 0 AND `idForelo` = 0 AND `idEstatus` = 1");
						if($this->RBD->error()){
							$this->LOG("Error | ".$QUERY." | ".$this->RBD->error());
						}

						// obtener el numero de sucursales activas
						$sqlS = $this->RBD->query("SELECT COUNT(`idSucursal`) AS `numeroCorresponsales` FROM `afiliacion`.`dat_sucursal` WHERE `idSubCadena` = $this->IDCLIENTE AND `idEstatus` IN(0,1) ");

						$resS = mysqli_fetch_assoc($sqlS);
						$numSucursales = $resS['numeroCorresponsales'];

						$montoAfiliacion	= ($res['importeAfiliacion'] != null)? $res['importeAfiliacion'] : 0;
						$cuotaMensual		= ($res['importeCuota'] != null)? $res['importeCuota'] : 0;

						$actualizadas = 0;
						while($res2 = mysqli_fetch_assoc($sql2)){
							if($res2['id'] > 0){

								if($res2['idTipoCuota'] == 2){
									$monto = $cuotaMensual;
								}
								if($res2['idTipoCuota'] == 99){
									$monto = $numSucursales * $montoAfiliacion;
								}

								$QUERY = "CALL `afiliacion`.`SP_CUOTAS_ACTUALIZAR`({$res2['id']}, $monto, {$res2['idTipoCuota']})";
								$this->WBD->query($QUERY);

								if($this->WBD->error()){
									$this->LOG("Error al actualizar cuota idTipoCuota=>".$res['idTipoCuota']." | ".$QUERY." | ".$this->WBD->error());
								}

								$actualizadas++;
							}
						}

						if($actualizadas == 0){
							$afiliacion = $numSucursales * $montoAfiliacion;
							$cuota		= $cuotaMensual;

							$QUERY = "CALL `afiliacion`.`SP_CUOTA_CREAR`(0, 0, $this->IDCLIENTE, 0, 2, '$afiliacion', '$cuota', '')";
							$this->WBD->query($QUERY);

							if($this->WBD->error()){
								$this->LOG->error("Error al crear cuota idTipoCuota=>".$res['idTipoCuota']." | ".$QUERY." | ".$this->WBD->error());
							}
						}
					}

					$response = array(
						'success'	=> true,
						'msg'		=> ''
					);*/
				/*}
				else{
					$this->LOG->error('Error al consultar datos del cliente '.' | '.$QUERY.' | '.$this->RBD->error());
					$response = array(
						'success'	=> false,
						'msg'		=> 'Ha ocurrido un error al actualizar las Cuotas',
						'errmsg'	=> $this->RBD->error()
					);
				}*/
			//}
			/*echo "<pre>";
			print_r($response);
			echo "</pre>";*/
			return $response;
		}
	}
?>