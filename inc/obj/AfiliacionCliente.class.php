<?php

	class AfiliacionCliente{

		private $RBD;
		private $WBD;
		private $LOG;
		private $XML;

		public $IDAFILIACION;
		public $IDNIVEL;
		public $FAMILIAS = array();		
		public $IDCADENA;
		public $IDGRUPO;
		public $IDREFERENCIA;
		public $IDTIPOPERSONA;
		public $RFC;
		public $IDGIRO;
		public $RAZONSOCIAL;
		public $NOMBREPERSONA;
		public $APATERNOPERSONA;
		public $AMATERNOPERSONA;
		public $FECHACONSITUTUCION;
		public $TELEFONO;
		public $CORREO;
		public $IDPAIS;
		public $CALLE;
		public $NUMEROINTERIOR;
		public $NUMEROEXTERIOR;
		public $CODIGOPOSTAL;
		public $IDCOLONIA;
		public $IDENTIDAD;
		public $IDMUNICIPIO;
		public $NOMBREREPLEGAL;
		public $APATERNOREPLEGAL;
		public $AMATERNOREPLEGAL;
		public $RFCREPLEGAL;
		public $IDTIPOIDENTIFICACION;
		public $NUMEROIDENTIFICACION;
		public $FIGPOLITICA;
		public $FAMPOLITICA;
		public $IDREPLEGAL;
		public $IDEJECUTIVO;
		public $NOMBRECADENA;
		public $IDCONTRATO;
		public $COMISIONES;
		public $REEMBOLSO;

		public $IDCUENTA;
		public $IDESTATUSCUENTA;

		public $BENEFICIARIO;
		public $NUMCUENTA;
		public $IDBANCO;
		public $DESCRIPCION;
		public $CLABE;	

		public $MINIMOPUNTOS;
		public $MAXIMOPUNTOS;

		public $IDTIPODIR = 0;
		public $ID_CLIENTE = 0;
		public $ID_DIRECCION = 0;

		function __construct($r,$w, $log){
			$this->RBD = $r;
			$this->WBD = $w;
			$this->XML = "";
			$this->LOG = $log;

			$this->IDEJECUTIVO	= 0;
			$this->IDREPLEGAL	= 0;
			$this->IDCUENTA		= 0;
			$this->IDCOSTO		= 0;
			$this->IDREPLEGAL	= 0;
			$this->IDCOSTO		= 0;
			$this->TIPOFORELO	= 0;
			$this->IDCUENTA		= 0;

			$this->IDCONTRATO	= 0;
			$this->COMISIONES	= 0;
			$this->REEMBOLSO	= 0;
			$this->IDCUENTA		= 0;

			$this->IDREFERENCIABANCARIA = 0;

			$this->NUMEROCORRESPONSALES = 0;
			$this->MINIMOPUNTOS = 0;
			$this->MAXIMOPUNTOS = 0;

			$this->ERROR_MSG	= "";
			$this->ERROR_CODE	= 0;
		}

		function load($id){
			$this->ID = $id;

			$sql = "CALL `afiliacion`.`SP_CLIENTE_LOAD`($id);";
			//var_dump("sql: $sql");
			$res = $this->RBD->query($sql);

			if(!$this->RBD->error()){
				if($res != '' && mysqli_num_rows($res) > 0){
					$r = mysqli_fetch_assoc($res);

					$this->NOMBRE_COMPLETO_CLIENTE = (!preg_match("!!u", $r['nombreCompletoCliente']))? utf8_encode($r['nombreCompletoCliente']) : $r['nombreCompletoCliente'];
					$this->EXISTE				= TRUE;
					$this->FAMILIAS				= str_replace(",", "|", $r['familias']);
					$this->IDNIVEL				= $r['idExpediente'];
					$this->ID_CLIENTE			= $r['idCliente'];
					$this->ID_SUBCADENA			= 0;
					$this->IDREPLEGAL			= ($r['idRepLegal'] == null)? 0 : $r['idRepLegal']; // id de relacion de la tabla dat_replegal
					$this->ID_REPLEGAL			= ($r['idRepLegalReal'] == null)? 0 : $r['idRepLegalReal'];// id real de representante legal
					$this->IDCADENA				= $r['idCadena'];
					$this->NOMBRECADENA			= $r['nombreCadena'];
					$this->IDGRUPO				= ($r['idGrupo'] == null)? -1 : $r['idGrupo'];
					$this->IDREFERENCIA			= ($r['idReferencia'] == null)? -1 : $r['idReferencia'];
					$this->IDTIPOPERSONA		= ($r['idRegimen'] == null)? -1 : $r['idRegimen'];
					$this->RFC					= $r['RFC'];
					$this->IDGIRO				= ($r['idGiro'] == null)? -1 : $r['idGiro'];
					$this->RAZONSOCIAL			= $r['RazonSocial'];
					$this->NOMBREPERSONA		= $r['Nombre'];
					$this->APATERNOPERSONA		= $r['Paterno'];
					$this->AMATERNOPERSONA		= $r['Materno'];
					$this->FECHACONSITUTUCION	= ($r['FecConstitutiva'] == null)? "0000-00-00" : $r['FecConstitutiva'];
					$this->TELEFONO				= $r['Telefono'];
					$this->CORREO				= $r['Correo'];
					$this->NOMBREREPLEGAL		= $r['nombreRep'];
					$this->APATERNOREPLEGAL		= $r['paternoRep'];
					$this->AMATERNOREPLEGAL		= $r['maternoRep'];
					$this->RFCREPLEGAL			= $r['rfcRep'];
					$this->IDTIPOIDENTIFICACION	= ($r['idTipoIdent'] == null)? -1 : $r['idTipoIdent'] ;
					$this->IDTIPOACCESO			= ($r['idTipoAcceso'] == null)? 0 : $r['idTipoAcceso'] ;
					$this->NUMEROIDENTIFICACION	= $r['numIdentificacion'];
					$this->FIGPOLITICA			= $r['figPolitica'];
					$this->FAMPOLITICA			= $r['famPolitica'];

					$this->IDDIRECCION = ($r['idDirFiscal'] == null)? 0 : $r['idDirFiscal']; // id de relacion con la tabla afiliacion.dat_direccion
					$this->ID_DIRECCION = $r['idDireccion']; // direccion real

					$this->CALLE			= $r['calleDireccion'];
					$this->IDPAIS			= ($r['idPais'] == null)? 164 : $r['idPais'];
					$this->IDENTIDAD		= ($r['idcEntidad'] == null)? -1 : $r['idcEntidad'];
					$this->IDMUNICIPIO		= ($r['idcMunicipio'] == null)? -1 : $r['idcMunicipio'];
					$this->IDLOCALIDAD		= ($r['idLocalidad'] == null)? 0 : $r['idLocalidad'];
					$this->IDCOLONIA		= ($r['idcColonia'] == null)? -1 : $r['idcColonia'];
					$this->CODIGOPOSTAL		= $r['cpDireccion'];
					$this->IDTIPODIR		= $r['idTipo'];
					$this->NUMEROINTERIOR	= $r['numeroIntDireccion'];
					$this->NUMEROEXTERIOR	= $r['numeroExtDireccion'];

					$this->IDCONTRATO		= ($r['idContrato'] == null)? 0 : $r['idContrato'];
					$this->COMISIONES		= ($r['comision'] == null)? 0 : $r['comision'];
					$this->REEMBOLSO		= ($r['reembolso'] == null)? 0 : $r['reembolso'];
					$this->IDCUENTA			= ($r['idCuenta'] == null)? 0 : $r['idCuenta'];
					$this->IDESTATUSCUENTA	= ($r['idEstatusCuenta'] == null)? -1 : $r['idEstatusCuenta'];
					$this->TIPOFORELO		= ($r['idTipoForelo'] == null)? 0 : $r['idTipoForelo'];
					$this->IDCOSTO			= ($r['idCosto'] == null)? 0 : $r['idCosto'];

					$this->BENEFICIARIO	= $r['beneficiario'];
					$this->NUMCUENTA	= $r['numCuenta'];
					$this->IDBANCO		= $r['idBanco'];
					$this->DESCRIPCION	= $r['descripcion'];
					$this->CLABE		= $r['CLABE'];
					$this->NOMBREBANCO	= $r['nombreBanco'];

					$this->IDFORELO = ($r['idRefBancaria'] == null)? 0 : $r['idRefBancaria'] ;
					$this->IDREFERENCIABANCARIA = ($r['idRefBancaria'] == null)? 0 : $r['idRefBancaria'] ;
					$this->REFERENCIABANCARIA	= $r['referenciaBancaria'];

					$this->COSTO = $r['costo'];

					$this->NUMEROCORRESPONSALES = ($r['numeroCorresponsales'] == null)? 0 : $r['numeroCorresponsales'];
					$this->NUMERO_SUCURSALES	= ($r['NUMERO_SUCURSALES'] == null)? 0 : $r['NUMERO_SUCURSALES'];

					$this->MINIMOPUNTOS = $r['minimoPuntos'];
					$this->MAXIMOPUNTOS = ($r['maximoPuntos'] == null)? 0 : $r['maximoPuntos'];

					$this->IDTIPODIR = 0;

					$this->IDTERMINOS			= ($r['idTerminos'] == null)? 0 : $r['idTerminos'];
					$this->IDESTATUSTERMINOS	= ($r['idEstatusTerminos'] == null)? 1 : $r['idEstatusTerminos'];

					$this->IDVERSION = (empty($r['idVersion']))? 0 : $r['idVersion'];

					$this->NOMBRENIVEL = $r['nombreNivel'];
					$this->LBLTIPOFORELO = $r['descTipoForelo'];

					$this->PAGO_PENDIENTE = (!empty($r['pagoPendiente']))? $r['pagoPendiente'] : 0;
				}
			}
			else{
				$this->EXISTE = FALSE;
				$this->ERROR_MSG = $this->RBD->error();
				$this->ERROR_CODE = 1;
			}
		}

		function loadClienteReal($id, $esSubcadena){
			$this->ID = $id;

			$sql = "CALL `redefectiva`.`SP_CLIENTE_GET_LOAD`($id,$esSubcadena);";
			//var_dump("sql: $sql");
			$res = $this->RBD->query($sql);

			if(!$this->RBD->error()){
				if($res != '' && mysqli_num_rows($res) > 0){
					$r = mysqli_fetch_assoc($res);

					$this->NOMBRE_COMPLETO_CLIENTE = (!preg_match("!!u", $r['nombreCompletoCliente']))? utf8_encode($r['nombreCompletoCliente']) : $r['nombreCompletoCliente'];
					$this->EXISTE				= TRUE;
					$this->FAMILIAS				= str_replace(",", "|", $r['familias']);
					$this->IDNIVEL				= $r['idExpediente'];
					$this->ID_CLIENTE			= $r['idCliente'];
					$this->IDREPLEGAL			= ($r['idRepLegal'] == null)? 0 : $r['idRepLegal']; // id de relacion de la tabla dat_replegal
					$this->ID_REPLEGAL			= ($r['idRepLegalReal'] == null)? 0 : $r['idRepLegalReal'];// id real de representante legal
					$this->IDCADENA				= $r['idCadena'];
					$this->NOMBRECADENA			= $r['nombreCadena'];
					$this->IDGRUPO				= ($r['idGrupo'] == null)? -1 : $r['idGrupo'];
					$this->IDREFERENCIA			= ($r['idReferencia'] == null)? -1 : $r['idReferencia'];
					$this->IDTIPOPERSONA		= ($r['idRegimen'] == null)? -1 : $r['idRegimen'];
					$this->RFC					= $r['RFC'];
					$this->IDGIRO				= ($r['idGiro'] == null)? -1 : $r['idGiro'];
					$this->RAZONSOCIAL			= $r['RazonSocial'];
					$this->NOMBREPERSONA		= $r['Nombre'];
					$this->APATERNOPERSONA		= $r['Paterno'];
					$this->AMATERNOPERSONA		= $r['Materno'];
					$this->FECHACONSITUTUCION	= ($r['FecConstitutiva'] == null)? "0000-00-00" : $r['FecConstitutiva'];
					$this->TELEFONO				= $r['Telefono'];
					$this->CORREO				= $r['Correo'];
					$this->NOMBREREPLEGAL		= $r['nombreRep'];
					$this->APATERNOREPLEGAL		= $r['paternoRep'];
					$this->AMATERNOREPLEGAL		= $r['maternoRep'];
					$this->RFCREPLEGAL			= $r['rfcRep'];
					$this->IDTIPOIDENTIFICACION	= ($r['idTipoIdent'] == null)? -1 : $r['idTipoIdent'] ;
					$this->IDTIPOACCESO			= ($r['idTipoAcceso'] == null)? 0 : $r['idTipoAcceso'] ;
					$this->NUMEROIDENTIFICACION	= $r['numIdentificacion'];
					$this->FIGPOLITICA			= $r['figPolitica'];
					$this->FAMPOLITICA			= $r['famPolitica'];

					$this->IDDIRECCION = ($r['idDirFiscal'] == null)? 0 : $r['idDirFiscal']; // id de relacion con la tabla afiliacion.dat_direccion
					$this->ID_DIRECCION = $r['idDireccion']; // direccion real

					$this->CALLE			= $r['calleDireccion'];
					$this->IDPAIS			= ($r['idPais'] == null)? 164 : $r['idPais'];
					$this->IDENTIDAD		= ($r['idcEntidad'] == null)? -1 : $r['idcEntidad'];
					$this->IDMUNICIPIO		= ($r['idcMunicipio'] == null)? -1 : $r['idcMunicipio'];
					$this->IDLOCALIDAD		= ($r['idLocalidad'] == null)? 0 : $r['idLocalidad'];
					$this->IDCOLONIA		= ($r['idcColonia'] == null)? -1 : $r['idcColonia'];
					$this->CODIGOPOSTAL		= $r['cpDireccion'];
					$this->IDTIPODIR		= $r['idTipo'];
					$this->NUMEROINTERIOR	= $r['numeroIntDireccion'];
					$this->NUMEROEXTERIOR	= $r['numeroExtDireccion'];

					$this->IDCONTRATO		= ($r['idContrato'] == null)? 0 : $r['idContrato'];
					$this->COMISIONES		= ($r['comision'] == null)? 0 : $r['comision'];
					$this->REEMBOLSO		= ($r['reembolso'] == null)? 0 : $r['reembolso'];
					$this->IDCUENTA			= ($r['idCuenta'] == null)? 0 : $r['idCuenta'];
					$this->IDESTATUSCUENTA	= ($r['idEstatusCuenta'] == null)? -1 : $r['idEstatusCuenta'];
					$this->TIPOFORELO		= ($r['idTipoForelo'] == null)? 0 : $r['idTipoForelo'];
					$this->IDCOSTO			= ($r['idCosto'] == null)? 0 : $r['idCosto'];

					$this->BENEFICIARIO	= $r['beneficiario'];
					$this->NUMCUENTA	= $r['numCuenta'];
					$this->IDBANCO		= $r['idBanco'];
					$this->DESCRIPCION	= $r['descripcion'];
					$this->CLABE		= $r['CLABE'];
					$this->NOMBREBANCO	= $r['nombreBanco'];

					$this->IDFORELO = ($r['idRefBancaria'] == null)? 0 : $r['idRefBancaria'] ;
					$this->IDREFERENCIABANCARIA = ($r['idRefBancaria'] == null)? 0 : $r['idRefBancaria'] ;
					$this->REFERENCIABANCARIA	= $r['referencia'];

					$this->COSTO = $r['costo'];

					$this->NUMEROCORRESPONSALES = $r['numero_corresponsales'];
					$this->NUMEROCORRESPONSALESNUEVOS = $r['corresponsalesPendientes'];
					$this->MINIMOPUNTOS = $r['minimoPuntos'];
					$this->MAXIMOPUNTOS = ($r['maxSucursales'] == null)? 0 : $r['maxSucursales'];

					$this->IDTIPODIR = 0;

					$this->IDTERMINOS			= ($r['idTerminos'] == null)? 0 : $r['idTerminos'];
					$this->IDESTATUSTERMINOS	= ($r['idEstatusTerminos'] == null)? 1 : $r['idEstatusTerminos'];

					$this->IDVERSION = (empty($r['idVersion']))? 0 : $r['idVersion'];

					$this->NOMBRENIVEL = $r['nombreNivel'];
					$this->LBLTIPOFORELO = $r['descTipoForelo'];

					$this->PAGO_PENDIENTE = (!empty($r['pagoPendiente']))? $r['pagoPendiente'] : 0;
				}
			}
			else{
				$this->EXISTE = FALSE;
				$this->ERROR_MSG = $this->RBD->error();
				$this->ERROR_CODE = 1;
			}
		}

		function guardarDatosGenerales(){
			$idEmpleado = $_SESSION['idU'];

			if($this->ID_CLIENTE == 0){
				$QUERY = "CALL `afiliacion`.`SP_CLIENTE_CREAR`(".$this->IDTIPOPERSONA.", '".$this->RAZONSOCIAL."', '".$this->NOMBREPERSONA."', '".$this->APATERNOPERSONA."', '".$this->AMATERNOPERSONA."', ".$this->IDCADENA.", ".$this->IDGRUPO.", ".$this->IDREFERENCIA.", '".$this->TELEFONO."', '".$this->CORREO."', 0, '".$this->FECHACONSITUTUCION."', '".$this->RFC."', '".$this->IDEJECUTIVO."', '".$idEmpleado."', 0, ".$this->IDCOSTO.", ".$this->IDNIVEL.", ".$this->IDVERSION.", ".$this->IDGIRO.", ".$this->IDTIPOACCESO.");";
			}
			else{
				$QUERY = "CALL `afiliacion`.`SP_CLIENTE_UPDATE`(".$this->ID_CLIENTE.",".$this->IDTIPOPERSONA.", '".$this->RAZONSOCIAL."', '".$this->NOMBREPERSONA."', '".$this->APATERNOPERSONA."', '".$this->AMATERNOPERSONA."', ".$this->IDCADENA.", ".$this->IDGRUPO.", ".$this->IDREFERENCIA.", '".$this->TELEFONO."', '".$this->CORREO."', ".$this->IDREPLEGAL.", '".$this->FECHACONSITUTUCION."', '".$this->RFC."', '".$this->IDEJECUTIVO."', '".$idEmpleado."', ".$this->IDDIRECCION.", ".$this->IDCOSTO.", ".$this->IDNIVEL.", ".$this->IDVERSION.", ".$this->IDGIRO.", ".$this->TIPOFORELO.", ".$this->MAXIMOPUNTOS.", ".$this->IDTIPOACCESO.");";
			}
			//var_dump("QUERY: $QUERY");
			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);

				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idCliente' => $res['idCliente']
					)
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Datos Generales : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}

		function guardarFamilias(){
			$familias = explode("|", $this->FAMILIAS);

			$error		= "";
			$errmsg		= "";
			$inserts	= 0;
			foreach($familias AS $familia){
				$QUERY = "CALL `afiliacion`.`SP_CLIENTEFAMILIA_CREAR`(".$this->ID_CLIENTE.", $familia)";
				$this->WBD->query($QUERY);

				if(!$this->WBD->error()){
					$inserts++;
				}
				else{
					$errmsg .= $this->WBD->error;
					$this->LOG->ERROR("La familia ".$familia." no se pudo insertar | ".$QUERY." | ".$this->WBD->error);
					$error .= "No se insertó la familia ".$familia;
				}
			}

			return array(
				'success'	=> ($inserts > 0)? true : false,
				'errormsg'	=> $errmsg,
				'msg'		=> $error
			);
		}

		function guardarDireccion(){
			$idUsuario = $_SESSION['idU'];

			if($this->IDDIRECCION <= 0){
				$QUERY = "CALL `afiliacion`.`SP_DIRECCION_CREAR`('".$this->CALLE."', '".$this->NUMEROINTERIOR."', '".$this->NUMEROEXTERIOR."', ".$this->IDPAIS.", ".$this->IDENTIDAD.", ".$this->IDMUNICIPIO.", ".$this->IDLOCALIDAD.",".$this->IDCOLONIA.", ".$this->CODIGOPOSTAL.", ".$this->IDTIPODIR.", ".$idUsuario.", ".$this->ID_DIRECCION.")";
			}	
			else{
				$QUERY = "CALL `afiliacion`.`SP_DIRECCION_UPDATE`(".$this->IDDIRECCION.",'".$this->CALLE."', '".$this->NUMEROINTERIOR."', '".$this->NUMEROEXTERIOR."', ".$this->IDPAIS.", ".$this->IDENTIDAD.", ".$this->IDMUNICIPIO.", ".$this->IDLOCALIDAD.", ".$this->IDCOLONIA.", ".$this->CODIGOPOSTAL.", ".$this->IDTIPODIR.", ".$idUsuario.", ".$this->ID_DIRECCION.")";
			}
			//var_dump("this->IDDIRECCION: ".$this->IDDIRECCION);
			//var_dump($QUERY);
			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);
				$this->IDDIRECCION = $res['idDireccion'];

				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idDireccion' => $res['idDireccionF']
					)
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Direccion : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}

		function guardarRepresentanteLegal(){
			$idEmpleado = $_SESSION['idU'];
			//var_dump("IDREPLEGAL: ".$this->IDREPLEGAL);
			if($this->IDREPLEGAL <= 0){
				$QUERY = "CALL `afiliacion`.`SP_REPRESENTANTE_LEGAL_CREAR`(".$this->IDTIPOIDENTIFICACION.", '".$this->NOMBREREPLEGAL."', '".$this->APATERNOREPLEGAL."', '".$this->AMATERNOREPLEGAL."', '".$this->NUMEROIDENTIFICACION."', '".$this->RFCREPLEGAL."', '".$this->FIGPOLITICA."', '".$this->FAMPOLITICA."', $idEmpleado,".$this->ID_REPLEGAL.")";
			}
			else{
				$QUERY = "CALL `afiliacion`.`SP_REPRESENTANTE_LEGAL_UPDATE`(".$this->IDREPLEGAL.",".$this->IDTIPOIDENTIFICACION.", '".$this->NOMBREREPLEGAL."', '".$this->APATERNOREPLEGAL."', '".$this->AMATERNOREPLEGAL."', '".$this->NUMEROIDENTIFICACION."', '".$this->RFCREPLEGAL."', '".$this->FIGPOLITICA."', '".$this->FAMPOLITICA."', $idEmpleado, ".$this->ID_REPLEGAL.")";
			}

			//var_dump($QUERY);
			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);
				$this->IDREPLEGAL = $res['idRepLegal'];
				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idRepLegal' => $res['idRepLegal']
					)
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Representante Legal : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}
		
		// Esta es la funcion original
		/*function crearReferenciaBancaria(){
			$fecha		= date("Y-m-d");
			$idEmpleado = $_SESSION['idU'];

			$QUERY = "CALL `afiliacion`.`SP_REFERENCIASBANCARIAS_COUNT`('$fecha')";
			$sql = $this->RBD->query($QUERY);

			if(!$this->RBD->error()){

				$res = mysqli_fetch_assoc($sql);
				$incremental = (int)$res['cuenta'] + 1;
				$incremental = str_pad($incremental, 3, '0', STR_PAD_LEFT);

				$anio	= date("y");
				$mes	= date("m");
				$dia	= date("d");

				$numeroCuenta = $anio.$mes.$dia.$incremental.'A';

				$QUERY2 = "CALL `data_contable`.`SP_ALG_REFBNMX`('$numeroCuenta', @refBancaria);";
				$sql2 = $this->RBD->query($QUERY2);

				if(!$this->RBD->error()){
					$row = mysqli_fetch_assoc($sql2);
					$referenciaBancaria = $row['@REFERENCIA'];

					$QUERY3 = "CALL `afiliacion`.`SP_FORELO_CREAR`(".$this->ID_CLIENTE.", 0, 0, 0, 0, '$referenciaBancaria')";
					$sql3 = $this->WBD->query($QUERY3);

					if(!$this->WBD->error()){
						$res = mysqli_fetch_assoc($sql3);

						$response = array(
							'success'	=> true,
							'data'		=> array(
								'idReferencia'	=> $res['idReferencia']
							)
						);
					}
					else{
						$this->LOG->error("Error al Insertar La referencia Bancaria ".$QUERY3." | ".$this->WBD->error());
						$response = array(
							'success'	=> false,
							'errmsg'	=> $this->WBD->error()
						);
					}
				}
				else{
					$this->LOG->error("Error al Obtener Numero de Verificacion ".$QUERY2." | ".$this->RBD->error());
					$response = array(
						'success'	=> false,
						'errmsg'	=> $this->RBD->error()
					);
				}
			}
			else{
				$this->LOG->error("Error al Contar Referencias ".$QUERY." | ".$this->RBD->error());
				$response = array(
					'success'	=> false,
					'errmsg'	=> $this->RBD->error()
				);
			}

			return $response;
		}*/

		function crearReferenciaBancaria(){
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
	
						$QUERY3 = "CALL `afiliacion`.`SP_FORELO_CREAR`(".$this->ID_CLIENTE.", 0, 0, 0, 0, '$referenciaBancaria')";
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
										'idReferencia'	=> $res['idReferencia']
									)
								);
							}
						}else{
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

		function actualizarForelo(){
			$QUERY = "CALL `afiliacion`.`SP_FORELO_UPDATE`(".$this->IDFORELO.", 0, ".$this->COMISIONES.", ".$this->REEMBOLSO.", ".$this->IDCUENTA.", '".$this->REFERENCIABANCARIA."');";

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

		function eliminarForelo(){
			$QUERY = "CALL `afiliacion`.`SP_FORELO_ELIMINAR`(".$this->IDFORELO.");";

			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);

				$response = array(
					'success'	=> true,
					'data'		=> array()
				);

				$QUERY = "CALL `afiliacion`.`SP_CUOTA_ELIMINAR`(".$this->ID_CLIENTE.", 0,0);";

				$sql = $this->WBD->query($QUERY);

				if(!$this->WBD->error()){

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
					$this->LOG->error("Error al Las cuotas : ".$QUERY." | ".$this->WBD->error(), false);
				}
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

		function crearCuotas(){
			$sql = $this->RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`($this->IDCOSTO, $this->IDNIVEL)");
			$res = mysqli_fetch_assoc($sql);

			$monto = $this->PAGO_PENDIENTE/*$this->NUMEROCORRESPONSALES * $res['Afiliacion']*/;
			$monto = number_format($monto, 4, '.', '');

			$cobroA		= (!empty($res['CobroA']))? $res['CobroA'] : 0;
			$tipoCobro	= (!empty($res['TipoCobro']))? $res['TipoCobro'] : 0;

			//var_dump("cobroA: $cobroA");

			if($tipoCobro == 0){
				$cuotaMensual = $this->NUMEROCORRESPONSALES * $res['Cuota'];
				$monto = $this->NUMEROCORRESPONSALES * $res['Afiliacion'];
			}
			else if($tipoCobro == 1){
				if($this->MAXIMOPUNTOS == 0){
					$cuotaMensual = $this->MINIMOPUNTOS * $res['Cuota'];
					$monto = $this->MINIMOPUNTOS * $res['Afiliacion'];
				}
				else{
					$cuotaMensual = $this->MAXIMOPUNTOS * $res['Cuota'];
					$monto = $this->MAXIMOPUNTOS * $res['Afiliacion'];
				}
			}

			if($cobroA == 2){//cobro a Cliente
				$QUERY = "CALL `afiliacion`.`SP_CUOTA_CREAR`(".$this->IDFORELO.", ".$this->ID_CLIENTE.", 0, 0, 0, '$monto', '$cuotaMensual', 'cuota', $tipoCobro, $cobroA)";
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
					$this->LOG->error("Error al Crear La Cuota : ".$QUERY." -- ".$this->WBD->error(), false);
				}
			}
			else{
				$response = array(
					'success'	=> true,
					'data'		=> array()
				);
			}

			return $response;			
		}

		function correoEnviado($id, $idRefBancaria, $tipoForelo, $fechaEnvio, $email, $enviado=1){
			$idEmpleado = $_SESSION['idU'];

			$QUERY = "CALL `afiliaciones`.`SP_ENVIOREFBANCARIA_CREAR`(".$idRefBancaria.", ".$tipoForelo.", ".$id.",'".$fechaEnvio."', ".$enviado.", '".$email."', $idEmpleado)";

			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){

				$response = array(
					'success'	=> true,
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar el registro de enviar correo : ".$QUERY." | ".$this->WBD->error(), false);
			}

			return $response;
		}

		function completoGenerales(){
			$NOMBREVALIDO	= false;
			$FECHAVALIDA	= false;

			if($this->IDNIVEL == 1){
				$FECHAVALIDA = true;
			}
			/*else if($this->IDNIVEL > 1){
				if(!empty($this->FECHACONSITUTUCION) && $this->FECHACONSITUTUCION != "0000-00-00"){
					$FECHAVALIDA = true;
				}
			}*/

			/*var_dump("IDNIVEL: ".$this->IDNIVEL);
			var_dump("IDTIPOPERSONA: ".$this->IDTIPOPERSONA);*/

			switch($this->IDTIPOPERSONA){
				case '1':
					if(!empty($this->NOMBREPERSONA) && !empty($this->APATERNOPERSONA) && !empty($this->AMATERNOPERSONA)){
						$NOMBREVALIDO = true;
					}
					$FECHAVALIDA = true;
				break;

				case '2':
					if(!empty($this->RAZONSOCIAL)){
						$NOMBREVALIDO = true;
					}
					if(!empty($this->FECHACONSITUTUCION) && $this->FECHACONSITUTUCION != "0000-00-00" && $this->IDNIVEL > 1){
						$FECHAVALIDA = true;
					}
				break;

				case '3':
					/*var_dump("RAZONSOCIAL: ".$this->RAZONSOCIAL);
					var_dump("NOMBREPERSONA: ".$this->NOMBREPERSONA);
					var_dump("APATERNOPERSONA: ".$this->APATERNOPERSONA);
					var_dump("AMATERNOPERSONA: ".$this->AMATERNOPERSONA);*/
					if(!empty($this->RAZONSOCIAL) || (!empty($this->NOMBREPERSONA) && !empty($this->APATERNOPERSONA) && !empty($this->AMATERNOPERSONA))){
						$NOMBREVALIDO = true;
					}
					//var_dump("IDNIVEL: ".$this->IDNIVEL);
					if($this->IDNIVEL > 1){
						if( $this->IDNIVEL == 3 ){
							if( count($this->RFC) == 12 ){
								if(!empty($this->FECHACONSITUTUCION) && $this->FECHACONSITUTUCION != "0000-00-00"){
									$FECHAVALIDA = true;
								}							
							} else {
								$FECHAVALIDA = true;
							}
						}else{
							$FECHAVALIDA = true;
						}
					}
				break;
			}
			
			/*var_dump("IDCADENA: ".$this->IDCADENA);
			var_dump("IDGRUPO: ".$this->IDGRUPO);
			var_dump("IDREFERENCIA: ".$this->IDREFERENCIA);
			var_dump("IDTIPOPERSONA: ".$this->IDTIPOPERSONA);
			var_dump("RFC: ".$this->RFC);
			var_dump("IDGIRO: ".$this->IDGIRO);
			var_dump("FECHAVALIDA: ".$FECHAVALIDA);
			var_dump("TELEFONO: ".$this->TELEFONO);
			var_dump("CORREO: ".$this->CORREO);
			var_dump("NOMBREVALIDO: ".$NOMBREVALIDO);
			var_dump("IDTIPOACCESO: ".$this->IDTIPOACCESO);*/

			if($this->IDCADENA >= 0 &&  $this->IDGRUPO > -1
				&& $this->IDREFERENCIA > -1
				&& $this->IDTIPOPERSONA > -1
				&& !empty($this->RFC)
				&& $this->IDGIRO > -1
				&& $FECHAVALIDA == true
				&& !empty($this->TELEFONO)
				&& !empty($this->CORREO)
				&& $NOMBREVALIDO == true
				&& !empty($this->IDTIPOACCESO)){
					return 0;
			}
			else{
				return 1;
			}
		}

		function completoDireccionFiscal(){
			if(!empty($this->ID_DIRECCION) && $this->ID_DIRECCION > 0){
				return 0;
			}
			else{
				if(!empty($this->IDPAIS)
					&& !empty($this->CALLE)
					//&& !empty($this->NUMEROINTERIOR)
					&& !empty($this->NUMEROEXTERIOR)
					&& !empty($this->CODIGOPOSTAL)
					&& $this->IDCOLONIA > 0
					&& $this->IDENTIDAD > 0
					&& $this->IDMUNICIPIO > 0
					&& !empty($this->CODIGOPOSTAL)
				){
					return 0;
				}
				else{
					return 1;
				}
			}
		}

		function completoRepresentanteLegal(){
			if($this->ID_REPLEGAL > 0){
				return 0;
			}
			else{
				if(!empty($this->RFCREPLEGAL)
					&& !empty($this->NOMBREREPLEGAL)
					&& !empty($this->APATERNOREPLEGAL)
					&& !empty($this->AMATERNOREPLEGAL)
					&& $this->IDTIPOIDENTIFICACION > 0
					&& !empty($this->NUMEROIDENTIFICACION)
				){
					return 0;
				}
				else{
					return 1;
				}
			}
		}

		function completoTipoForelo(){
			if($this->IDCOSTO > 0 && $this->TIPOFORELO > 0){
				if($this->TIPOFORELO == 1/* && $this->IDREFERENCIABANCARIA > 0*/){
					return 0;
				}
				else if($this->TIPOFORELO == 2){
					return 0;
				}
				else{
					return 1;
				}
			}
			else{
				return 1;
			}
		}

		function completoConfiguracionCuenta(){
			if($this->COMISIONES < 0 && $this->REEMBOLSO < 0){
				return 1;
			}

			if($this->COMISIONES == 0 && $this->REEMBOLSO == 0){
				return 0;
			}
			else{
				if($this->COMISIONES == 1 || $this->REEMBOLSO == 1){
					if($this->IDCUENTA > 0){
						return 0;
					}
					else{
						return 1;
					}
				}
			}
		}

		function completoExpediente(){
			if(!empty($this->IDNIVEL)){
				return 0;
			}
			else{
				return 1;
			}

		}

		function prepararCliente(){
			$completoGenerales				= $this->completoGenerales();
			$completoDireccionFiscal		= $this->completoDireccionFiscal();
			if($this->IDNIVEL > 1){
				$completoRepresentanteLegal = $this->completoRepresentanteLegal();
			}
			else{
				$completoRepresentanteLegal = 0;
			}
			$completoTipoForelo				= $this->completoTipoForelo();
			$completoConfiguracionCuenta	= $this->completoConfiguracionCuenta();
			$completoExpediente				= $this->completoExpediente();

			if($completoGenerales == 0 && $completoDireccionFiscal == 0 && $completoRepresentanteLegal == 0 && $completoTipoForelo == 0 && $completoConfiguracionCuenta == 0 && $completoExpediente == 0){
				$idEstatus = 0;
			}
			else{
				$idEstatus = 1;
			}
			$this->WBD->query("CALL `afiliacion`.`SP_CLIENTE_PREPARAR`($this->ID_CLIENTE, $idEstatus);");
			//var_dump("CALL `afiliacion`.`SP_CLIENTE_PREPARAR`($this->ID_CLIENTE, $idEstatus);");
		}

	}


?>