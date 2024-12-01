<?php

	class Cliente{

		private $RBD;
		private $WBD;
		private $LOG;
		private $XML;

		function __construct($RBD,$WBD, $LOG){
			$this->RBD = $RBD;
			$this->WBD = $WBD;
			$this->LOG = $LOG;

			$this->ERROR_MSG	= "";
			$this->ERROR_CODE	= 0;
		}

		function acentos($txt){
			return (!preg_match("!!u", $txt))? utf8_encode($txt) : $txt;
		}

		function load($id){
			if($id > 0){
				$this->ID_CLIENTE = $id;

				$QUERY	= "CALL `redefectiva`.`SP_DATCLIENTE_LOAD`($id);";
				$sql	= $this->RBD->query($QUERY);

				if(!$this->RBD->error()){
					if(mysqli_num_rows($sql) > 0){

						$res = mysqli_fetch_assoc($sql);
						$this->ID_GRUPO						= ($res['idGrupo'] == null)? -1 : $res['idGrupo'];
						$this->ID_CADENA					= ($res['idCadena'] == null)? -1 : $res['idCadena'];
						$this->ID_GIRO						= ($res['idGiro'] == null)? -1 : $res['idGiro'];
						$this->ID_REFERENCIA				= ($res['idReferencia'] == null)? -1 : $res['idReferencia'];
						$this->ID_ESTATUS					= $res['idEstatus'];
						$this->ID_VERSION					= $res['version'];
						$this->ID_DIRECCION					= $res['idDirFiscal'];
						$this->ID_REPRESENTANTELEGAL		= $res['idRepLegal'];
						$this->ID_IVA						= $res['idIva'];
						$this->ID_REGIMEN					= $res['idRegimen'];
						$this->ID_NIVEL						= $res['idExpediente'];
						$this->ID_TIPOIDENTIFICACION		= $res['idcTipoIdent'];
						$this->ID_COSTO						= $res['idCosto'];
						$this->ID_TIPO_FORELO				= $res['idTipoForelo'];

						$this->NOMBRE_GRUPO					= $this->acentos($res['nombreGrupo']);
						$this->NOMBRE_CADENA				= $this->acentos($res['nombreCadena']);
						$this->NOMBRE_GIRO					= $this->acentos($res['nombreGiro']);
						$this->NOMBRE_COMPLETO_CLIENTE		= $this->acentos($res['nombreCompletoCliente']);
						$this->NOMBRE_REFERENCIA			= (!empty($res['nombreReferencia']))? $this->acentos($res['nombreReferencia']) : "Sin Referencia";
						$this->NOMBRE_VERSION				= $this->acentos($res['nombreVersion']);
						$this->NOMBRE_REPRESENTANTELEGAL	= (!empty($res['nombreCompletoRepLegal']))? $this->acentos($res['nombreCompletoRepLegal']) : "No tiene";
						$this->NOMBRE_REPLEGAL				= $this->acentos($res['nombreRepLegal']);
						$this->NOMBRE_ESTATUS				= $this->acentos($res['descEstatus']);
						$this->NOMBRE_IVA					= $this->acentos($res['descIva']);
						$this->NOMBRE_REGIMEN				= $this->acentos($res['descRegimen']);
						$this->NOMBRE_NIVEL					= $this->acentos($res['descExpediente']);
						$this->NOMBRE_TIPOIDENTIFICACION	= $this->acentos($res['descTipoIdentificacion']);
						$this->NOMBRE_CLIENTE				= $this->acentos($res['nombreCliente']);
						$this->NOMBRE_USUARIOALTA			= (!empty($res['usuario_alta']))?$this->acentos($res['usuario_alta']) : "No tiene";
						$this->NOMBRE_TIPO_ACCESO			= (!empty($res['descTipoAcceso']))?$this->acentos($res['descTipoAcceso']) : "No tiene";

						$this->PATERNO_CLIENTE				= $this->acentos($res['paternoCliente']);
						$this->MATERNO_CLIENTE				= $this->acentos($res['maternoCliente']);

						$this->PATERNO_REPRESENTANTELEGAL	= $this->acentos($res['paternoRepLegal']);
						$this->MATERNO_REPRESENTANTELEGAL	= $this->acentos($res['maternoRegpLegal']);

						$this->RAZON_SOCIAL					= $this->acentos($res['razonSocial']);

						$this->NUM_CUENTA					= $res['numCuenta'];

						$this->RFC_CLIENTE					= strtoupper($res['RFCCliente']);
						$this->RFC_REPRESENTANTELEGAL		= (!empty($res['RFCRepresentante']))? strtoupper($res['RFCRepresentante']) : "No tiene";

						$this->TELEFONO						= $res['Telefono'];
						$this->CORREO						= $res['Correo'];
						$this->FECHA_REGISTRO				= $res['FecRegistro'];

						$this->NUMERO_CORRESPONSALES		= $res['numero_corresponsales'];
						
						$this->NUMERO_IDENTIFICACION		= (!empty($res['numIdentificacion']))? $res['numIdentificacion'] : "No tiene";
						$this->FAM_POLITICA					= $res['famPolitica'];
						$this->FIG_POLITICA					= $res['figPolitica'];

						$this->SALDO_CUENTA					= $res['saldoCuenta'];
						$this->FORELO						= $res['FORELO'];

						$this->DIRF_ID_COLONIA				= $res['idColonia'];
						$this->DIRF_ID_MUNICIPIO			= $res['idCiudad'];
						$this->DIRF_ID_ESTADO				= $res['idEstado'];
						$this->DIRF_ID_PAIS					= $res['idPais'];

						$this->DIRF_CALLE					= $this->acentos($res['calle']);
						$this->DIRF_NUMEROINTERIOR			= $res['numeroInterior'];
						$this->DIRF_NUMEROEXTERIOR			= $res['numeroExterior'];
						$this->DIRF_NOMBRE_COLONIA			= $this->acentos($res['nombreColonia']);
						$this->DIRF_NOMBRE_MUNICIPIO		= $this->acentos($res['nombreCiudad']);
						$this->DIRF_NOMBRE_ESTADO			= $this->acentos($res['nombreEstado']);
						$this->DIRF_NOMBRE_PAIS				= $this->acentos($res['nombrePais']);
						$this->DIRF_CODIGO_POSTAL			= $res['codigoPostal'];

						$this->REFERENCIA_BANCARIA			= $res['referencia'];

						$this->FAMILIAS						= $res['familias'];

						$this->setEjecutivos();


						$this->EXISTE		= TRUE;
						$this->ERROR_CODE	= 0;
						$this->ERROR_MSG	= "";


					}
					else{
						$this->EXISTE		= TRUE;
						$this->ERROR_CODE	= 3;
						$this->ERROR_MSG	= "Se encontró más de un registro";
					}
				}
				else{
					$this->EXISTE		= FALSE;
					$this->ERROR_MSG	= $this->RBD->error();
					$this->ERROR_CODE	= 2;
				}
			}
			else{
				$this->EXISTE		= FALSE;
				$this->ERROR_MSG	= "El id del Cliente debe ser Mayor a 0";
				$this->ERROR_CODE	= 1;
			}
		}

		function setEjecutivos(){
			// ejecutivo de cuenta
			$query = "CALL `redefectiva`.`SP_FIND_EJECUTIVO`(".$this->ID_CLIENTE.", 5, 2)";

			$sql = $this->RBD->query($query);

			if(!$this->RBD->error()){
				$row = mysqli_fetch_assoc($sql);
				$this->NOMBRE_EJECUTIVOCUENTA	= (!empty($row["nombreCompletoEjecutivo"]))? $this->acentos($row["nombreCompletoEjecutivo"]) : "No tiene";
				$this->ID_EJECUTIVOCUENTA		= $row["idEjecutivo"];
			}
			else{
				$this->NOMBRE_EJECUTIVOCUENTA	= "No tiene";
				$this->ID_EJECUTIVOCUENTA		= 0;
			}

			// ejecutivo de venta
			$query = "CALL `redefectiva`.`SP_FIND_EJECUTIVO`(".$this->ID_CLIENTE.", 2, 2)";

			$sql = $this->RBD->query($query);

			if(!$this->RBD->error()){
				$row = mysqli_fetch_assoc($sql);
				$this->NOMBRE_EJECUTIVOVENTA	= (!empty($row["nombreCompletoEjecutivo"]))? $this->acentos($row["nombreCompletoEjecutivo"]) : "No tiene"; 
				$this->ID_EJECUTIVOVENTA		= $row["idEjecutivo"];
			}
			else{
				$this->NOMBRE_EJECUTIVOVENTA	= "No tiene";
				$this->ID_EJECUTIVOVENTA		= 0;
			}

			// ejecutivo de AFILIACION AVANZADO
			$query = "CALL `redefectiva`.`SP_FIND_EJECUTIVO`(".$this->ID_CLIENTE.", 9, 2)";

			$sql = $this->RBD->query($query);

			if(!$this->RBD->error()){
				$row = mysqli_fetch_assoc($sql);
				$this->NOMBRE_EJECUTIVOAFILIACION_INTERMEDIO	= (!empty($row["nombreCompletoEjecutivo"]))? $this->acentos($row["nombreCompletoEjecutivo"]) : "No tiene";
				$this->ID_EJECUTIVOAFILIACION_INTERMEDIO		= $row["idEjecutivo"];
			}
			else{
				$this->NOMBRE_EJECUTIVOAFILIACION_INTERMEDIO	= "No tiene";
				$this->ID_EJECUTIVOAFILIACION_INTERMEDIO		= 0;
			}

			// ejecutivo de AFILIACION INTERMEDIO
			$query = "CALL `redefectiva`.`SP_FIND_EJECUTIVO`(".$this->ID_CLIENTE.", 9, 2)";

			$sql = $this->RBD->query($query);

			if(!$this->RBD->error()){
				$row = mysqli_fetch_assoc($sql);
				$this->NOMBRE_EJECUTIVOAFILIACION_AVANZADO	= (!empty($row["nombreCompletoEjecutivo"]))? $this->acentos($row["nombreCompletoEjecutivo"]) : "No tiene";
				$this->ID_EJECUTIVOAFILIACION_AVANZADO		= $row["idEjecutivo"];
			}
			else{
				$this->NOMBRE_EJECUTIVOAFILIACION_AVANZADO	= "No tiene";
				$this->ID_EJECUTIVOAFILIACION_AVANZADO		= 0;
			}
		}

		function getDireccion(){
			$dir = $this->DIRF_CALLE;
			$dir.= " No. Ext. ".$this->DIRF_NUMEROEXTERIOR;
			if(!empty($this->DIRF_NUMEROINTERIOR)){
				$dir .= " No. Int. ".$this->DIRF_NUMEROINTERIOR;
			}
			$dir .= "<br>";
			$dir .= "Col. ".$this->DIRF_NOMBRE_COLONIA;
			$dir .= " C.P. ".$this->DIRF_CODIGO_POSTAL;
			$dir .= "<br>";

			$dir .= $this->DIRF_NOMBRE_MUNICIPIO;
			$dir .= ", ".$this->DIRF_NOMBRE_ESTADO;
			$dir .= ", ".$this->DIRF_NOMBRE_PAIS;

			return $dir;
		}

		function guardarDatosGenerales(){
			$QUERY = "CALL `redefectiva`.`SP_DATCLIENTE_UPDATE`($this->ID_CLIENTE, $this->ID_REFERENCIA, $this->ID_DIRECCION, $this->ID_REPRESENTANTELEGAL, $this->ID_GIRO, $this->ID_REGIMEN, $this->ID_GRUPO, '$this->RFC_CLIENTE', '$this->RAZON_SOCIAL', '$this->NOMBRE_CLIENTE', '$this->PATERNO_CLIENTE', '$this->MATERNO_CLIENTE', '$this->TELEFONO', '$this->CORREO', $this->ID_NIVEL);";
			//var_dump($QUERY);
			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$response = array(
					'success'	=> true
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Datos Generales : ".$QUERY." | ".$this->WBD->error(), false);
			}

			return $response;
		}

		function guardarDireccion(){
			$idUsuario = $_SESSION['idU'];
			//crear el registro de direccion
			//var_dump("ID_DIRECCION: ".$this->ID_DIRECCION);
			if($this->ID_DIRECCION == 0){
				$QUERY = "CALL `redefectiva`.`SP_INSERT_DIRECCION`('$this->DIRF_CALLE', '$this->DIRF_NUMEROINTERIOR', '$this->DIRF_NUMEROEXTERIOR', $this->DIRF_ID_PAIS, $this->DIRF_ID_ESTADO, $this->DIRF_ID_MUNICIPIO, $this->DIRF_ID_COLONIA, '$this->DIRF_CODIGO_POSTAL', 0, $idUsuario);";
			}else{
				$QUERY = "CALL `redefectiva`.`SP_UPDATE_DIRECCION`('$this->ID_DIRECCION', '$this->DIRF_CALLE', '$this->DIRF_NUMEROINTERIOR', '$this->DIRF_NUMEROEXTERIOR',
				$this->DIRF_ID_PAIS, $this->DIRF_ID_ESTADO, $this->DIRF_ID_MUNICIPIO, $this->DIRF_ID_COLONIA, '$this->DIRF_CODIGO_POSTAL', 0, $idUsuario);";
			}
			//var_dump("QUERY: $QUERY");
			$sql = $this->WBD->query($QUERY);
			if(!$this->WBD->error()){
				$res = mysqli_fetch_array($sql);
				$this->ID_DIRECCION = $res[0];
				$response = array(
					'success'		=> true,
					'idDireccion'	=> $res[0]
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'errmsg'	=> $this->WBD->error()
				);
				//var_dump("WBD: ".$this->WBD->error());
				$this->LOG->error("Error al Guardar Direccion : ".$QUERY." | ".$this->WBD->error(), false);
			}

			return $response;
		}

		function guardarRepresentanteLegal(){
			$idUsuario = $_SESSION['idU'];
			//crear el registro de direccion
			if($this->ID_REPRESENTANTELEGAL == 0){
				$QUERY = "CALL `redefectiva`.`SP_INSERT_REPRESENTANTELEGAL`($this->ID_TIPOIDENTIFICACION, '$this->NOMBRE_REPLEGAL', '$this->PATERNO_REPRESENTANTELEGAL', '$this->MATERNO_REPRESENTANTELEGAL', '$this->NUMERO_IDENTIFICACION', '$this->RFC_REPRESENTANTELEGAL', '', $this->FIG_POLITICA, $this->FAM_POLITICA, $idUsuario);";
			}else{
				$QUERY = "CALL `redefectiva`.`SP_UPDATE_REPRESENTANTELEGAL`($this->ID_REPRESENTANTELEGAL, $this->ID_TIPOIDENTIFICACION, '$this->NOMBRE_REPLEGAL', '$this->PATERNO_REPRESENTANTELEGAL', '$this->MATERNO_REPRESENTANTELEGAL', '$this->NUMERO_IDENTIFICACION', '$this->RFC_REPRESENTANTELEGAL', '', $this->FIG_POLITICA, $this->FAM_POLITICA, $idUsuario)";
			}

			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_array($sql);

				$this->ID_REPRESENTANTELEGAL = $res[0];
				$this->guardarDatosGenerales();
				$response = array(
					'success'				=> true,
					'idRepresentanteLegal'	=> $res[0]
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Representante Legal : ".$QUERY." | ".$this->WBD->error(), false);
			}

			return $response;
		}
		
		function getCodigos(){
			$sql = "CALL `nautilus`.`SP_FIND_CODIGOS`(".$this->ID_CADENA.", ".$this->ID_CLIENTE.", -1)";
			$res = $this->RBD->query($sql);
			if($res != '' && mysqli_num_rows($res) > 0){
				$d = "";
				while(list($idcadena,$idsubcadena,$idcorresponsal,$codigo) = mysqli_fetch_array($res)){
					$codigores = "$codigo";
					$codigores.= ($idcadena == $this->IDCADENA && $idsubcadena == -1 && $idcorresponsal == -1) ? " (Cadena)" : "";
					$codigores.= ($idcadena == $this->IDCADENA && $idsubcadena == $this->IDSUBCADENA && $idcorresponsal == -1) ? " (SubCadena)" : "";
					$codigores.= ($idcadena == $this->IDCADENA && $idsubcadena == $this->IDSUBCADENA && $idcorresponsal == $this->ID) ? " (Corresponsal)" : "";
					$d.=$codigores."<br />";
				}
			
				return $d;
			}
			else{
				return "N/A";
			}
		}

		public function getConfPermisos($categoria){
			$sql = $this->RBD->query("CALL `redefectiva`.`SP_FIND_CATEGORIA_PERMISOS`(".$this->ID_CADENA.",".$this->ID_CLIENTE.", -1)");

			if(!$this->RBD->error()){

				$res = mysqli_fetch_assoc($sql);
				
				/* si la categoria es 0 quiere decir que no encontró nada para subcadena ni cadena, entonces los permisos deben estar en el grupo */
				if($categoria == 0){
					return $categoria;
				}
		    	else{
		    		$sql	= $this->RBD->query("SELECT FOUND_ROWS() AS total");
					$result	= mysqli_fetch_assoc($sql);
					/* si no encuentra permisos en la categoria que se está buscando, se busca en una categoría más arriba */
					if($result["total"] <= 0){
						$cat = $categoria - 1;
						return $this->getConfPermisos($cat);
					}
					else{
						return $categoria;
					}
				}
			}
			else{
				return "Error : ".$this->RBD->error();
			}
		}
	}


?>