<?php

	class PreCargo{
		
		private $CONN;
		private $CONN2;
		private $idConf;
		private $idConcepto;
		private $idCadena;
		private $idSubCadena;
		private $idCorresponsal;
		private $importe;
		private $fechaInicio;
		private $Observaciones;
		private $descripcion;
		private $startDesc;
		private $idEstatus;
		private $numcuenta;
		private $tipoCargo;
		private $configuracion;
		private $idUsuario;
		
		public function __construct($LOG, $CONN, $CONN2, $idConf = null, $idConcepto = null, $idCadena=0, $idSubCadena=0, $idCorresponsal=0, $importe = 0, $fechaInicio="", $Observaciones="", $descripcion="", $idEstatus = 0, $numCuenta = 0, $tipoCargo = 0, $configuracion = 0, $idUsuario = 0){
			$this->CONN = $CONN;
			$this->CONN2 = $CONN2;
			
			$this->idConf			= $idConf;
			$this->idConcepto		= $idConcepto;
			$this->idCadena			= $idCadena;
			$this->idSubCadena		= $idSubCadena;
			$this->idCorresponsal	= $idCorresponsal;
			$this->importe			= $importe;
			$this->fechaInicio		= $fechaInicio;
			$this->Observaciones	= $Observaciones;
			$this->descripcion		= $descripcion;
			$this->startDesc		= $descripcion;
			$this->idEstatus		= $idEstatus;
			$this->numcuenta		= $numCuenta;
			$this->tipoCargo		= $tipoCargo;//0 Automatico, 1 Manual
			$this->configuracion	= $configuracion;
			$this->idUsuario		= $idUsuario;
		}

		/*
			Hace una consulta para obtener todos los cargos activos filtrando por Cadena, SubCadena y Corresponsal.
			Retorna un arreglo con los cargos obtenidos
		*/
		public function cargarTodos(){
			if($this->CONN2 != null){
				$query = "CALL prealta.SP_LOAD_PRECARGOS(".$this->idCadena.", ".$this->idSubCadena.", ".$this->idCorresponsal.")";
				$sql = $this->CONN2->SP($query);

				if(!$this->CONN2->error()){
					$cargos = array();

					while($row = mysqli_fetch_assoc($sql)){
						$cargos[] = $row;
					}
				}
				else{
					$cargos["error"] = 1;
					$cargos["msg"] = "Ha ocurrido un error";
					$cargos["errmsg"] = $this->CONN2->error();
				}
			}
			return $cargos;
		}// function cargarTodos

		public function cargarTodosPorCategoria(){
			if($this->CONN2 != null){
				$query = "CALL redefectiva.SP_LOAD_CARGOS_CATEGORIA(".$this->idCadena.", ".$this->idSubCadena.", ".$this->idCorresponsal.")";
				$sql = $this->CONN2->query($query);

				if(!$this->CONN2->error()){
					$cargos = array();

					while($row = mysqli_fetch_assoc($sql)){
						$cargos[] = $row;
					}
				}
				else{
					$cargos["error"] = 1;
					$cargos["msg"] = "Ha ocurrido un error";
					$cargos["errmsg"] = $this->CONN2->error();
				}
			}
			return $cargos;
		}// function cargarTodoscargarTodosPorCategoria	

		/*
			Carga un número determinado de registros por categoría, por ejemplo 10 registros de Cadena, subCadena, Corresponsal
		*/
		public function cargarResumen(){
			if($this->CONN2 != null){
				$query = "CALL redefectiva.SP_LOAD_CARGOS_RESUMEN(".$this->idCadena.", ".$this->idSubCadena.", ".$this->idCorresponsal.", 10)";
				$sql = $this->CONN2->query($query);

				if(!$this->CONN2->error()){
					$cargos = array();

					while($row = mysqli_fetch_assoc($sql)){
						$cargos[] = $row;
					}
				}
				else{
					$cargos["error"] = 1;
					$cargos["msg"] = "Ha ocurrido un error";
					$cargos["errmsg"] = $this->CONN2->error();
				}
			}
			return $cargos;
		}// function cargarResumen

		/*
			Hace una consulta para obtener el número de Cuenta de una Cadena.
			Retorna el número de Cuenta de la Cadena,
			en caso de no haber encontrado ningún número de Cuenta para la Cadena se devuelve un 0.
		*/
		public function buscaCuentaCadena(){

			if($this->CONN2){
				$query = "CALL redefectiva.SP_BUSCA_CUENTA_CADENA(".$this->idCadena.")";

				$sql = $this->CONN2->query($query);

				if($this->CONN2->num_rows($sql) == 1){
					$result = mysqli_fetch_assoc($sql);
					$numCuenta = $result["numCuenta"];
				}
				else{
					$numCuenta = 0;
				}
			}

			return $numCuenta;
		}// function buscaCuentaCadena


		/*
			Hace una consulta para obtener el número de Cuenta de una SubCadena
			Retorna el número de Cuenta de la SubCadena, en caso de no haber encontrado ninguno se devuelve un 0.
		*/
		public function buscaCuentaSubCadena(){

			if($this->CONN2){
				$query = "CALL redefectiva.SP_BUSCA_CUENTA_SUBCADENA(".$this->idCadena.", ".$this->idSubCadena.");";

				$sql = $this->CONN2->query($query);

				if($this->CONN2->num_rows($sql) == 1){
					$result = mysqli_fetch_assoc($sql);
					$numCuenta = $result["numCuenta"];
				}
				else{
					$numCuenta = 0;
				}
			}

			return $numCuenta;
		}// function buscaCuentaCadena

		/*
			Utiliza la función buscaCuentaCadena() para obtener la Cuenta de la Cadena a la que se le quiere hacer un cargo.
			En caso de encontrar un número de Cuenta, se utiliza la función setNumCuenta($numCuenta) y crearCargo() para insertar el cargo en la base de datos y se retorna el resultado de la función crearCargo().
			En caso de no encontrar un Número de Cuenta retorna un arreglo con error y errmsg.
		*/
		public function crearCargoPorCadena(){
			$result = array();
			$numCuenta = $this->buscaCuentaCadena();

			if($numCuenta > 0){
				$this->setNumCuenta($numCuenta);
				$result = $this->crearCargo();
			}
			else{
				$result["error"] = 2;
				$result["errmsg"] = "La Cadena no tiene una Cuenta Asignada";
			}

			return $result;
		}//function crearCargoPorCadena

		/*
			Utiliza la función buscaCuentaSubCadena() para obtener la Cuenta de la SubCadena a la que se le quiere hacer un cargo.
			En caso de encontrar un número de Cuenta, se utiliza la función setNumCuenta($numCuenta) y crearCargo() para insertar el cargo en la base de datos y se retorna el resultado de la función crearCargo().
			En caso de no encontrar un Número de Cuenta retorna un arreglo con error y errmsg.
		*/
		public function crearCargoPorSubCadena(){
			$result = array();
			$numCuenta = $this->buscaCuentaSubCadena();

			if($numCuenta > 0){
				$this->setNumCuenta($numCuenta);
				$result = $this->crearCargo();
			}
			else{
				$result["error"] = 2;
				$result["errmsg"] = "La SubCadena no tiene una Cuenta Asignada";
			}

			return $result;
		}//function crearCargoPorSubCadena

		/*
			Hace una consulta para buscar los Números de Cuenta de los un Corresponsal o de los Corresponsales que pertenecen a una Cadena o SubCadena.
			Después los itera, y si el corresponsal tiene alguna cuenta a la cual hacerle el cargo(puede ser cuenta de corresopnsal, subcadena o cadena) entonces se utiliza la función crearCargo() para insertar el cargo en la base de datos.
			En caso de que no se encuentre alguna cuenta a la cual hacer el cargo, el nombre del Corresponsal se guarda en la variable $failed.
			Retorna un arreglo con error, errmsg y msg.
		*/
		public function crearCargoPorCorresponsal(){
			if($this->CONN2){
				$sql = $this->CONN2->query("CALL redefectiva.SP_BUSCA_CUENTAS_CORRESPONSAL(".$this->idCadena.", ".$this->idSubCadena.", ".$this->idCorresponsal.")");

				if(!$this->CONN2->error()){
					$failed = "";
					$msgerror="";
					$numSuccess = 0;

					while($row = mysqli_fetch_assoc($sql)){
						$this->idCadena = $row["idCadena"];
						$this->idSubCadena = $row["idSubCadena"];
						$this->idCorresponsal = $row["idCorresponsal"];
						$this->descripcion = $this->getSubString($this->startDesc."(".$this->idCorresponsal.")".$row["nombreCorresponsal"], 45);

						if($row["numCuenta"] != ""){
							$this->numCuenta = $row["numCuenta"];

							$res = $this->crearCargo();
							//echo "<pre>"; echo var_dump($res); echo "</pre>";
						}
						else{
							$res["error"] = 1;
						}

						if($res["error"] == 0){
							$numSuccess++;
						}
						else{
							$failed .= "\n".$row["idCorresponsal"]." - ".$row["nombreCorresponsal"];
							$msgerror.=" ".$res["msg"];
						}
					}//while

					$result["error"] = ($failed == "")? 0 : 1;
					$result["errmsg"] = "No ha sido posible crear los Cargos de \n".$failed;
					$result["msgerror"] = $msgerror;
					$result["msg"]	= "Han sido Creados ".$numSuccess;
					if($numSuccess > 0){
						$result["msg"] .= " Cargos Exitosamente";
					}

				}//if ! $this->CONN2->error()
				else{
					$result["error"] = 1;
					$result["errmsg"] = "Ha ocurrido un error";
				}
			}//if ! $this->CONN2
			else{
				$result["error"] = 1;
				$result["errmsg"] = "Ha ocurrido un error";
			}

			return $result;
		}//function crearCargoPorCorresponsal

		public function getSubString($string, $length=NULL){
		    //Si no se especifica la longitud por defecto es 50
		    if ($length == NULL)
		        $length = 50;
		    //Primero eliminamos las etiquetas html y luego cortamos el string
		    $stringDisplay = substr(strip_tags($string), 0, $length);
		    //Si el texto es mayor que la longitud se agrega puntos suspensivos
		    //if (strlen(strip_tags($string)) > $length)
		        //$stringDisplay .= ' ...';
		    return $stringDisplay;
		}

		/*
			Crea un solo Cargo segun los parámetros definidos
		*/
		public function crearCargo(){
			if($this->CONN != null){
				$this->descripcion = $this->getSubString($this->descripcion, 45);
				$query = "CALL `prealta`.`SP_CREATE_PRECARGO`($this->idConcepto, $this->idCadena, $this->idSubCadena, $this->idCorresponsal, $this->importe, '$this->fechaInicio', $this->configuracion, '$this->Observaciones', '$this->descripcion', $this->idEstatus, '', $this->tipoCargo, $this->idUsuario);";
				$sql = $this->CONN->SP($query);
				$row = mysqli_fetch_assoc($sql);
				if(!$this->CONN->error()){
					if ( $row["error"] == 500 ) {
						$row["msg"] = "Solo puede agregarse una Cuota o Afiliación";
					} else {
						$row["error"] = 0;
						$row["msg"] = "Cargo creado correctamente";
					}
				}else{
					$row["error"] = 1;
					$row["msg"] = $this->CONN->error();
					$row["msg"] = "Ha ocurrido un error";
				}
			}
			else{
				$res["error"] = 1;
				$row["msg"] = "Ha ocurrido un error";
			}

			return $row;
		}// function crearConcepto

		/*
			Llama a un stored procedure para actualizar el concepto, importe, fecha de inicio y observaciones de un cargo
		*/
		public function actualizarCargo(){
			if($this->CONN != null){
				$sql = $this->CONN->SP("CALL prealta.SP_UPDATE_PRECARGO(".$this->idConf.", ".$this->idConcepto.", ".$this->importe.", '".$this->fechaInicio."', '".$this->Observaciones."', ".$this->configuracion.", ".$this->idCadena.", ".$this->idSubCadena.", ".$this->idCorresponsal.")");
				$row = mysqli_fetch_assoc($sql);
				if(!$this->CONN->error()){
					if ( $row["error"] == 500 ) {
						$row["msg"] = "Solo puede agregarse una Cuota o Afiliación";
					} else {
						$row["idConf"] = $this->idConf;
						$row["error"] = 0;
						$row["msg"] = "Cargo Actualizado Correctamente";
					}
				}else{
					$row["error"] = 1;
					$row["msg"] = "Ha ocurrido un error";
					$row["errmsg"] = $this->CONN->error();
				}
			}

			return $row;
		}// function actualizarCargo

		/*
			Carga los datos de un solo cargo
		*/
		public function getCargo(){
			if($this->CONN2 != null){
				$query = "CALL redefectiva.SP_LOAD_CARGO(".$this->idConf.")";
				$sql = $this->CONN->query($query);

				if(!$this->CONN2->error()){
					if($this->CONN2->num_rows($sql) > 0){
						$result = mysqli_fetch_assoc($sql);
					}
					else{
						$result["error"] = 1;
						$result["errmsg"] = "No se encuentra el cargo";
					}
				}
				else{
					$result["error"] = 1;
					$result["errmsg"] = "Ha ocurrido un error";
					$result["errormsg"] = $this->CONN2->error();
				}

				return $result;
			}
		}// function getCargo


		/*
			Hace una consulta para eliminar un cargo.
		*/
		public function deleteCargo(){
			$query = "CALL prealta.SP_DELETE_PRECARGO(".$this->idConf.", ".$this->idEstatus.", ".$this->tipoCargo.")";
			if($this->CONN != null){
				$sql = $this->CONN->SP($query);

				$result = mysqli_fetch_assoc($sql);

				$res = array();
				if(!$this->CONN->error()){
					$res["idConf"] = $this->idConf;
					$res["error"] = 0;
					$res["msg"] = (!empty($result["msg"]))? $result["msg"] : 'Cargo Eliminado';
				}
				else{

					$res["error"] = 1;
					$res["msg"] = $result["msg"];
					$res["errmsg"] = $this->CONN->error();
				}
			}

			return $res;
		}// function deleteConcepto

		public function cargarCuotas(){
			if($this->CONN2 != null){
				$query = "CALL prealta.SP_GET_PRECUOTAS(".$this->idCadena.", ".$this->idSubCadena.", ".$this->idCorresponsal.")";
				$sql = $this->CONN2->query($query);
				if(!$this->CONN2->error()){
					$row = mysqli_fetch_assoc($sql);
					return $row;
				}
				else{
					$cargos = array();
					$cargos["error"] = 1;
					$cargos["msg"] = "Ha ocurrido un error";
					$cargos["errmsg"] = $this->CONN2->error();
				}
			}
			return $cargos;			
		}
		
		public function cargarAfiliaciones(){
			if($this->CONN2 != null){
				$query = "CALL prealta.SP_GET_PREAFILIACIONES(".$this->idCadena.", ".$this->idSubCadena.", ".$this->idCorresponsal.")";
				$sql = $this->CONN2->query($query);

				if(!$this->CONN2->error()){
					$row = mysqli_fetch_assoc($sql);
					return $row;
				}
				else{
					$cargos["error"] = 1;
					$cargos["msg"] = "Ha ocurrido un error";
					$cargos["errmsg"] = $this->CONN2->error();
				}
			}
			return $cargos;			
		}

		public function setIdConf($idConf){
			$this->idConf = $idConf;
		}

		public function setIdConcepto($idConcepto){
			$this->idConcepto = $idConcepto;
		}

		public function setIdCadena($idCadena){
			$this->idCadena = $idCadena;
		}

		public function setIdSubCadena($idSubCadena){
			$this->idSubCadena = $idSubCadena;
		}
		
		public function setIdCorresponsal($idCorresponsal){
			$this->idCorresponsal = $idCorresponsal;
		}

		public function setImporte($importe){
			$this->importe = $importe;
		}

		public function setFechaInicio($fechaInicio){
			$this->fechaInicio = $fechaInicio;
		}

		public function setObservaciones($Observaciones){
			$this->Observaciones = $Observaciones;
		}

		public function setDescripcion($descripcion){
			$this->descripcion = $descripcion;
		}

		public function setIdEstatus($idEstatus){
			$this->idEstatus = $idEstatus;
		}

		public function setNumCuenta($numCuenta){
			$this->numCuenta = $numCuenta;
		}

		public function setTipoCargo($tipoCargo){
			$this->tipoCargo = $tipoCargo;
		}

		public function setIdUsuario($idUsuario){
			$this->idUsuario = $idUsuario;
		}
	}
?>