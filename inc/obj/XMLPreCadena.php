<?php
class XMLPreCadena{
	private $RBD,$WBD;
	//Variables del Sistema Local
	
	private $XML;
	
	private $ID;
	
	private $NOMBRE;
	
	private $PORCENTAJE;
	
	private $REVISADO;
	
	private $EXISTE;
	
	private $ERROR;
	
	private $MSG;
	
	//Datos  Generales
	private $CADENA;
	private $GIRO;
	private $GRUPO;
	private $REFERENCIA;
	private $TEL1;
	private $TEL2;
	private $FAX;
	private $CORREO;
	private $REVISADOGENERALES;
	private $PREREVISADOGENERALES;
	
	//CONTACTOS		
	
	private $CONTACTOS = array();
	public $CONTACTO;
	private $REVISADOCONTACTOS;
	private $PREREVISADOCONTACTOS;
	 
	//Direccion
	
	private $DIRECCION;
	
	private $CALLE;
	private $NEXT;
	private $NINT;
	private $COLONIA;
	private $CIUDAD;
	private $ESTADO;
	private $CP;
	private $PAIS;
	private $TIPODIRECCION;
	private $REVISADODIRECCION;
	private $PREREVISADODIRECCION;
	
	//Ecuenta
	
	private $ECUENTA;
	private $REVISADOECUENTA;
	private $PREREVISADOECUENTA;
	
	//Eventa
	
	private $EVENTA;
	private $REVISADOEVENTA;
	private $PREREVISADOEVENTA;
	
	//Cargos
	private $REVISADOCARGOS;
	private $PREREVISADOCARGOS;
	
	function __construct($r,$w){
		$this->RBD = $r;
		$this->WBD = $w;
		$this->XML = "";
		$this->PORCENTAJE = 0;
		$this->REVISADO = true;
		$this->EXISTE = false;
		$this->ID = "";
		$this->NOMBRE = "";
		$this->CADENA = "";
		$this->GIRO = "";
		$this->GRUPO = "";
		$this->REFERENCIA = "";
		$this->TEL1 = "";
		$this->TEL2 = "";
		$this->FAX = "";
		$this->CORREO = "";
		$this->REVISADOGENERALES = false;
		$this->PREREVISADOGENERALES = false;
		$this->DIRECCION = "";
		$this->REVISADODIRECCION = false;
		$this->PREREVISADODIRECCION = false;
		$this->ECUENTA = "";
		$this->REVISADOECUENTA = false;
		$this->PREREVISADOECUENTA = false;
		$this->EVENTA = "";
		$this->REVISADOEVENTA = false;
		$this->PREREVISADOEVENTA = false;
		$this->CONTACTO = "";
		$this->REVISADOCONTACTOS = false;
		$this->PREREVISADOCONTACTOS = false;
		$this->CALLE = "";
		$this->NEXT = "";
		$this->NINT = "";
		$this->COLONIA = "";
		$this->CIUDAD = "";
		$this->ESTADO = "";
		$this->CP = "";
		$this->PAIS = "";
		$this->TIPODIRECCION = "";
		$this->MSG = "";
		$this->REVISADOCARGOS = false;
		$this->PREREVISADOCARGOS = false;
	}
	
	 function load($id){
		$this->ID = $id;
		$sql = "CALL `prealta`.`SP_LOAD_PRECADENA`($id);";
		$res = $this->RBD->SP($sql);
		if($this->RBD->error() == ''){
			if($res != '' && mysqli_num_rows($res) > 0){
				
				$r = mysqli_fetch_array($res);

				/*$reg = base64_decode($r[0]);*/
				//$reg = utf8_decode($reg);
				$xml = simplexml_load_string(utf8_encode($r[0]));
				//echo "<pre>".var_dump($xml)."</pre>";
				/*echo "<pre>";
				print_r($r[0]);
				echo "</pre>";*/
				$this->EXISTE = true;
				$this->XML = $xml;
				$this->IDESTATUS = $r[1];
				$this->NOMBRE = (!preg_match('!!u', $xml->DG[0]->Nom))? utf8_encode($xml->DG[0]->Nom) : $xml->DG[0]->Nom;
				//$this->NOMBRE = $xml->DG[0]->Nom;
				$this->CADENA = $xml->Cadena;
				$this->GRUPO = $xml->DG[0]->Grupo;
				$this->REFERENCIA = $xml->DG[0]->Referencia;
				$this->TEL1 = $xml->DG[0]->Tel1;
				$this->CORREO = $xml->DG[0]->MailE;
				$this->REVISADOGENERALES = ($xml->DG->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOGENERALES = ($xml->DG->attributes()->prerevisado == "true") ? true : false;
				$this->DIRECCION = $xml->Direccion;
				$this->REVISADODIRECCION = ($xml->Direccion->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADODIRECCION = ($xml->Direccion->attributes()->prerevisado == "true") ? true : false;
				$this->ECUENTA = $xml->ECuenta;
				$this->REVISADOECUENTA = ($xml->ECuenta->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOECUENTA = ($xml->ECuenta->attributes()->prerevisado == "true") ? true : false;
				$this->EVENTA = $xml->EVenta;
				$this->REVISADOEVENTA = ($xml->EVenta->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOEVENTA = ($xml->EVenta->attributes()->prerevisado == "true") ? true : false;
				$this->REVISADOCONTACTOS = ($xml->Contactos->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOCONTACTOS = ($xml->Contactos->attributes()->prerevisado == "true") ? true : false;
				$this->REVISADOCARGOS = ($xml->Cargos->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOCARGOS = ($xml->Cargos->attributes()->prerevisado == "true") ? true : false;
				
				foreach($xml->Contactos->Contacto as $cont){
					if($cont > 0){
						$aux = new Contacto($this->RBD,$this->WBD);
						$aux->load($cont);
						$this->CONTACTOS[] = $aux; 
					}
				}
				
				$sql = "CALL `prealta`.`SP_GET_PREDIRECCION`($this->DIRECCION);";
				$res = $this->RBD->SP($sql);
				if($res != '' && mysqli_num_rows($res) > 0){
					list($c,$ni,$ne,$p,$e,$m,$col,$cp) = mysqli_fetch_array($res);
					$this->CALLE = $c;
					$this->NINT = $ni;
					$this->NEXT = $ne;
					$this->PAIS = $p;
					$this->ESTADO = $e;
					$this->CIUDAD = $m;
					$this->COLONIA = $col;
					$this->CP = $cp;
				}
				
			}else{
				$this->EXISTE = false;
			}
		}
		/*else{
			echo $this->RBD->error();
		}*/
	}
	
   
	
	function CrearXML(){
		$xml = '<Cadena>
					<Cargos revisado="false" prerevisado="false"></Cargos>
					<DG revisado="false" prerevisado="false">
						<Nom>'.$this->NOMBRE.'</Nom>
						<Tel1></Tel1>
						<Tel2></Tel2>
						<MailE></MailE>
						<Fax></Fax>
						<Giro></Giro>
						<Grupo></Grupo>
						<Referencia></Referencia>
					</DG>
					<Contactos revisado="false" prerevisado="false">
					</Contactos>
					<ECuenta revisado="false" prerevisado="false"></ECuenta>
					<EVenta revisado="false" prerevisado="false"></EVenta>
					<Direccion tipo="2" revisado="false" prerevisado="false"></Direccion>
				</Cadena>';
		
		$sql = "CALL `prealta`.`SP_INSERT_XMLPRECADENA`('$this->NOMBRE', '$xml');";
			
		$result = $this->WBD->SP($sql);

		if($this->WBD->error() == ''){
			if ( $result->num_rows > 0 ) {
				list( $ultimoID ) = $result->fetch_array();
				$this->ID = $ultimoID;
				return true;
			}
		}else{
			return false;
		}
	}
	
	private function getCargosXML(){
		$revisado = $this->REVISADOCARGOS ?  "true" : "false";
		$prerevisado = $this->PREREVISADOCARGOS ?  "true" : "false";
		$aux = '<Cargos revisado="'.$revisado.'" prerevisado="'.$prerevisado.'"></Cargos>';
		return $aux;				
	}
	
	private function getGeneralesXML(){
		$revisado = $this->REVISADOGENERALES ?  "true" : "false";
		$prerevisado = $this->PREREVISADOGENERALES ?  "true" : "false";
		$aux = '
		<DG revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">
			<Nom>'.utf8_decode($this->NOMBRE).'</Nom>
			<Tel1>'.$this->TEL1.'</Tel1>
			<MailE>'.$this->CORREO.'</MailE>
			<Grupo>'.$this->GRUPO.'</Grupo>
			<Referencia>'.$this->REFERENCIA.'</Referencia>
		</DG>';
		return $aux;
	}
	
	private function getDireccionXML(){
		$revisado = $this->REVISADODIRECCION ?  "true" : "false";
		$prerevisado = $this->PREREVISADODIRECCION ?  "true" : "false";
		$aux = '<Direccion tipo="'.$this->TIPODIRECCION.'" revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">'.$this->DIRECCION.'</Direccion>';
		return $aux;
	}
		
	private function getContactosXML(){
		$revisado = $this->REVISADOCONTACTOS ?  "true" : "false";
		$prerevisado = $this->PREREVISADOCONTACTOS ?  "true" : "false";
		$aux = '<Contactos revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">';
		for($i = 0; $i < count($this->CONTACTOS); $i++){
			$aux.='<Contacto tipo="'.$this->CONTACTOS[$i]->getTipoContacto().'">'.$this->CONTACTOS[$i]->getInfId().'</Contacto>';
		}
		$aux.='</Contactos>';
		return $aux;
	}
	
	private function getECuentaXML(){
		$revisado = ($this->REVISADOECUENTA) ?  "true" : "false";
		$prerevisado = ($this->PREREVISADOECUENTA) ?  "true" : "false";
		$aux = '
		<ECuenta revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">'.$this->ECUENTA.'</ECuenta>
		';
		return $aux;
	}
	
	private function getEVentaXML(){
		$revisado = $this->REVISADOEVENTA ?  "true" : "false";
		$prerevisado = $this->PREREVISADOEVENTA ?  "true" : "false";
		$aux = '
		<EVenta revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">'.$this->EVENTA.'</EVenta>
		';
		return $aux;
	}
	
	function GuardarXML(){
		$xml = '<Cadena>';
		$xml .= $this->getCargosXML();
		$xml .= $this->getGeneralesXML();
		$xml .= $this->getContactosXML();
		$xml .= $this->getECuentaXML();
		$xml .= $this->getEVentaXML();
		$xml .= $this->getDireccionXML();
		$xml .= '</Cadena>';
		
		$sql = "CALL `prealta`.`SP_UPDATE_XMLPRECADENA`($this->ID, '$xml');";
		$this->WBD->SP($sql);
		if($this->WBD->error() == ''){
			$this->Revisar();
			return true;
		}
		return false;
	}

	function wordMatch($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	function AutorizarPreCadena(){
		if($this->IDESTATUS == 1 && ($this->IsRevisado()) ){
			$this->WBD->query("START TRANSACTION");
			//Crear la cadena
			$idEmpleado = $_SESSION['idU'];

			$nombre = utf8_decode($this->NOMBRE);
			$sql = "CALL `prealta`.SP_CADENA_ALTA(".
							" '$this->GRUPO', ".
							" '$nombre', ". 
							" '$this->TEL1', ".
							" '$this->TEL2', ". 
							" '$this->FAX', ".
							" '$this->CORREO', ".
							" '$this->REFERENCIA', ".
							" '0', ".
							" '".$idEmpleado."', ".
							" '$this->ID')";
			$res = $this->WBD->query($sql);

			if(!$this->WBD->error()){

				$row = mysqli_fetch_array($res);
				$idCadenaReal = $row[2];

				if($row[0] == 0){
					//Crear los Ejecutivos de Cuenta y de Venta
					if(!empty($this->ECUENTA) && !empty($this->EVENTA)){
						$arrEjecutivos = array(
							array(
								"idEjecutivo"	=> $this->ECUENTA,
								"idTipo"		=> 5
							),
							array(
								"idEjecutivo"	=> $this->EVENTA,
								"idTipo"		=> 2
							)
						);

						$error = 0;
						foreach($arrEjecutivos AS $e){
							$query = "CALL `prealta`.`SP_EJECUTIVO_ALTA`($idCadenaReal, ".$e['idEjecutivo'].", $idEmpleado, 1, ".$e['idTipo'].")";
							$sql = $this->WBD->query($query);

							if($this->WBD->error()){
								$error = 1;
							}
						}

						if($error == 1){
							$this->ERROR .= $this->WBD->error();
							$this->MSG .= "No ha sido posible crear los ejecutivos";
							return false;
						}
						else{
							//Crear la Direccion (informacion opcional)
							if($this->DIRECCION != ""){
								$query = "CALL `prealta`.`SP_DIRECCION_ALTA`($this->DIRECCION, $idCadenaReal, 1, $idEmpleado)";

								$sql = $this->WBD->query($query);
								$res = mysqli_fetch_assoc($sql);

								if($this->WBD->error()){
									$this->ERROR.= $this->WBD->error();
									$this->MSG.= "No se pudo dar de alta la dirección";
									return false;
								}
							}

							//Crear los Contactos
							$contactos = $this->CONTACTOS;
							$numContactos = count($contactos);

							if($numContactos > 0){
								foreach($contactos AS $contacto){
									$query = "CALL `prealta`.`SP_CONTACTO_ALTA`({$contacto->getTipoContacto()},
										'".$this->wordMatch($contacto->getNombre())."',
										'".$this->wordMatch($contacto->getPaterno())."',
										'".$this->wordMatch($contacto->getMaterno())."',
										'".$this->wordMatch($contacto->getTelefono())."',
										'".$this->wordMatch($contacto->getExtTel())."',
										'".$this->wordMatch($contacto->getCorreo())."',
										$idEmpleado,
										'".$contacto->getId()."',
										'".$contacto->getInfId()."',
										'$idCadenaReal',
										1
										)";
									$this->WBD->query($query);

									if($this->WBD->error()){
										$this->ERROR.= $this->WBD->error();
										$this->MSG.= "No se puedo dar de alta el contacto";
										return false;
									}
								}
							}

							//Crear los Cargos
							$query = "CALL `prealta`.`SP_LOAD_PRECARGOS`($this->ID, -1, -1)";
							$sql = $this->RBD->query($query);

							if(!$this->RBD->error()){
								if(mysqli_num_rows($sql) > 0){
									while($row = mysqli_fetch_assoc($sql)){
										//INSERTAR EN LA TABLA DE CONFIGURACION GENERAL
										$fecIni = $row['fechaInicio'];
										$query = "CALL `redefectiva`.`SP_CREATE_CONFIGURACION_CARGOS`({$row['idConcepto']}, {$row['Configuracion']}, $idCadenaReal, {$row['idSubCadena']}, {$row['idCorresponsal']}, {$row['importe']}, '$fecIni', '{$row['observaciones']}')";
										$this->WBD->query($query);

										if($this->WBD->error()){
											$this->ERROR .= $this->WBD->error();
											$this->MSG.= "No se pudo dar de alta la configuración del cargo";
											return false;
										}
										//SI EL CARGO NO ES AFILIACION
										if($row['idConcepto'] != 99){
											$query = "CALL `prealta`.`SP_ALTA_CARGO`({$row['idConf']}, $this->ID, 0, 0, $idCadenaReal, -1, -1)";
											$this->WBD->query($query);

											if($this->WBD->error()){
												$this->ERROR .= $this->WBD->error();
												$this->MSG.= "No se pudo dar de alta el cargo";
												return false;
											}
										}
										else{
											//$fecha = date("Y-m-d");
											//$query = "CALL `data_contable`.`SP_GENERA_CARGO`('$numCuenta', {$row['importe']}, '$fecha', 0, 0, $idEmpleado, 'Afiliación', 0, '')";
										}

									}
								}
							}
							else{
								$this->ERROR .= $this->WBD->error();
								$this->MSG.= "No se pudieron leer los cargos";
								return false;
							}

							return true;
						}
					}
					else{
						$this->ERROR.= "No Cuenta Con Los Ejecutivos";
						$this->MSG.= "No Cuenta Con Los Ejecutivos";
						return false;
					}
				}
				else{
					$this->ERROR = $this->WBD->error();
					$this->MSG = $row[1];
					return false;
				}
			}
			else{
				$this->ERROR = $this->WBD->error();
				$this->MSG = "No se pudo dar de Alta la Cadena";
				return false;
			}
		}
		else{
			if(!$this->IsRevisado()){
				$this->ERROR	= "La PreCadena No ha sido revisada Totalmente";
				$this->MSG		= "La PreCadena No ha sido revisada Totalmente";
			}
			if($this->IDESTATUS != 1){
				$this->ERROR	= "La PreCadena No se encuentra con Estatus de Activo";
				$this->MSG		= "La PreCadena No se encuentra con Estatus de Activo";
				return false;
			}
			
		}
	}

	function Autorizar(){
		//Crear la cadena
		$sql = "CALL `redefectiva`.SP_ALTA_CADENA(".
						" '$this->GRUPO', ".
						" '$this->NOMBRE', ". 
						" '$this->TEL1', ".
						" '$this->TEL2', ". 
						" '$this->FAX', ".
						" '$this->CORREO', ".
						" '$this->REFERENCIA', ".
						" '0', ".
						" '".$_SESSION['idU']."' ".
				")";
				
		$res = $this->WBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			list($codRespuesta, $descRespuesta, $idCadena) = mysqli_fetch_array($res);
			if($codRespuesta == 0){
				//Asignar ejecutivos a la cadena
				if($this->ECUENTA != ''){
					$sql = "CALL `redefectiva`.`SP_CREATE_EJECUTIVO`($this->ECUENTA, 5, {$_SESSION['idU']});";
					$this->WBD->SP($sql);
					if($this->WBD->error() != ''){
					   $this->ERROR.= "Error al crear el ejecutivo de cuenta";
					}
					if($this->WBD->error() == ''){ 					
						$sql = "CALL `prealta`.`SP_INSERT_EJECUTIVO`($idCadena, $this->ECUENTA, {$_SESSION['idU']});";
						$this->WBD->SP($sql);					
						if($this->WBD->error() != ''){
						   $this->ERROR.= "Error al asignar el ejecutivo a la cadena";
						}
					}
				}
				if($this->EVENTA != ''){
					$sql = "CALL `redefectiva`.`SP_CREATE_EJECUTIVO`($this->ECUENTA, 2, {$_SESSION['idU']});";
					$this->WBD->SP($sql);
					if($this->WBD->error() != ''){
					   $this->ERROR.= "Error al crear el ejecutivo de venta";
					}
					if($this->WBD->error() == ''){ 									
						$sql = "CALL `prealta`.`SP_INSERT_EJECUTIVO`($idCadena, $this->EVENTA, {$_SESSION['idU']});";
						$this->WBD->SP($sql);
						if($this->WBD->error() != ''){
						   $this->ERROR.= "Error al asignar el ejecutivo a la cadena";
						}
					}
				}
				
				
				//Agregar contactos
				for($i = 0; $i < count($this->CONTACTOS); $i++){
					$c = $this->CONTACTOS[$i];
					$sql = "CALL `prealta`.`SP_INSERT_CONTACTO`({$c->getTipoContacto()}, '{$c->getNombre()}', '{$c->getPaterno()}', '{$c->getMaterno()}', '{$c->getTelefono()}', '{$c->getCorreo()}', {$_SESSION['idU']});";
					$result = $this->WBD->SP($sql);
					if ( $this->WBD->error() == '' ) {
						if ( $result->num_rows > 0 ) {
							list ( $ultimoID ) = $result->fetch_array();
							$idContacto = $ultimoID;
						}	
					} else {
						$this->ERROR.= "No se pudo agregar el contacto".$this->WBD->error();
					}
					//Asignar contacto a la cadena
					$sql = "CALL `prealta`.`SP_INSERT_CADENACONTACTO`($idCadena, $idContacto, {$_SESSION['idU']});";
					$this->WBD->SP($sql);
					if($this->WBD->error() != ''){
						$this->ERROR.= "No se pudo asignar el contacto a la cadena";
					}
					
				}
				
				$sql = "CALL `prealta`.`SP_ENABLE_PRECADENA`($this->ID);";
		
				$this->WBD->SP($sql);
				
				
				return true;
			}else{
				$this->ERROR = $descRespuesta;
				return false;
			}
		}else{
			$this->ERROR = "No se pudo crear la cadena";
			return false;
		}
	}
	
	
	function AgregarContacto(){
		$bandcont = true;
		foreach( $this->CONTACTOS as $Cont ) {
			if( $Cont->getTipoContacto() == 6 && $this->CONTACTO->getTipoContacto() == 6 ) {
				$bandcont = false;
				break;
			}
		}
		if( $bandcont ){
			if( $this->CONTACTO->Guardar($this->ID) ) {
				$this->CONTACTOS[] = $this->CONTACTO;
				if( $this->GuardarXML() ) {
					return true;
				} else {
					return false;
				}
			}
			$this->MSG = $this->CONTACTO->getMsg();
			return false;
		}
		$this->MSG = "solo puede existir un responsable";
		return false;     
	}
	
	function EliminarContacto($id){
		$i = 0;
		$bandel = false;
		while($i < count($this->CONTACTOS)){
			if($this->CONTACTOS[$i]->getInfId() == $id){
				$this->CONTACTO = $this->CONTACTOS[$i];
				$bandel = true;
				break;
			}
			$i++;
		}
		if($bandel){//para validar que el contacto existe en el arreglo
			if($this->CONTACTO->Borrar()){
				$aux = array();
				$i = 0;
				while($i < count($this->CONTACTOS)){
					if($this->CONTACTOS[$i]->getInfId() != $id){
						$aux[] = $this->CONTACTOS[$i];
					}
					$i++;
				}
				$this->CONTACTOS = $aux;
				if($this->GuardarXML())
					return true;
				else
					return false;
			}else{
				return false;
			}
		}
		return false;
		
	}
	
	function ActualizarContacto($id){
		$bandcont = true;
		$bandel = false;
		foreach($this->CONTACTOS as $Cont){//Verificar que no se repita el tipo de contacto Responsable
			if($Cont->getTipoContacto() == 6 && $this->CONTACTO->getTipoContacto() == 6 && $Cont->getInfId() != $id){
				$bandcont = false;
				break;
			}
		}
		
		if($bandcont){
			
			if($this->CONTACTO->Actualizar()){
				$aux = array();
				$i = 0;
				while($i < count($this->CONTACTOS)){//Actualizar la lista de contactos
					if($this->CONTACTOS[$i]->getInfId() != $id){
						$idc = $this->CONTACTOS[$i]->getInfId();
						$this->CONTACTOS[$i]->load($idc);
						$aux[] = $this->CONTACTOS[$i];
					}else{
						$idc = $this->CONTACTO->getInfId();
						$this->CONTACTO->load($idc);
						$aux[] = $this->CONTACTO;
					}
					$i++;
				}
				$this->CONTACTOS = $aux;
				
				if($this->GuardarXML())
					return true;
				else
					return false;
			}
			$this->ERROR = $this->CONTACTO->getError();
			return false;
		}
		$this->MSG = "solo puede existir un responsable";
		return false;
	}
	
	function GuardarDireccion(){
		$sql = "CALL `prealta`.`SP_INSERT_PREDIRECCION`('$this->CALLE', '$this->NINT', '$this->NEXT', $this->PAIS, $this->ESTADO, $this->CIUDAD, $this->COLONIA, $this->CP, $this->TIPODIRECCION);";
		$result = $this->WBD->SP($sql);
		if ( $this->WBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				list( $ultimoID ) = $result->fetch_array();
				$this->DIRECCION = $ultimoID;
				if ( $this->GuardarXML() )
					return true;
				else
					return false;				
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function SemaforoGenerales(){
		if ( $this->GRUPO != '' && $this->REFERENCIA != '' ) {
			return 0;
		} else if( $this->GRUPO != '' || $this->REFERENCIA != '' ) {
			return 1;
		} else {
			return 2;
		}
	}
	
	function SemaforoDireccion(){
		/*var_dump("CALLE: $this->CALLE");
		var_dump("NEXT: $this->NEXT");
		var_dump("CIUDAD: $this->CIUDAD");
		var_dump("ESTADO: $this->ESTADO");
		var_dump("PAIS: $this->PAIS");
		var_dump("CP: $this->CP");
		var_dump("COLONIA: $this->COLONIA");*/
		if( $this->CALLE != '' && $this->NEXT != ''
		&& $this->CIUDAD != '' && $this->CIUDAD > 0
		&& $this->ESTADO != '' && $this->ESTADO > 0
		&& $this->PAIS != '' && $this->PAIS > 0
		&& $this->CP != '' && $this->CP > 0
		&& $this->COLONIA != '' && $this->COLONIA > 0 ) {
			return 0;
		} else if ( $this->CALLE != '' || $this->NEXT != '' || $this->NEXT > 0
		|| $this->CIUDAD != '' || $this->CIUDAD > 0
		|| $this->ESTADO != '' || $this->ESTADO > 0
		|| $this->PAIS != '' || $this->PAIS > 0
		|| $this->CP != '' || $this->CP > 0
		|| $this->COLONIA != '' || $this->COLONIA > 0 ) {
			return 1;
		} else {
			return 2;
		}
	}
	
	function SemaforoContactos(){
	if(count($this->CONTACTOS) > 0)
		return 0;
	else{
		return 2;
	}
	}
	
	function SemaforoEjecutivos(){
		if($this->ECUENTA != '' && $this->EVENTA != '')
			return 0;
		else if($this->ECUENTA != '' || $this->EVENTA != '')
			return 1;
		else
			return 2;
	}
	
	function setID($value){
		$this->ID = $value;
	}
	
	function getID(){
		return $this->ID;
	}
	
	function setNombre($value){
		$this->NOMBRE = $value;
	}
	
	function getNombre(){
		return $this->NOMBRE;
	}
	
	function getError(){
		return $this->ERROR;
	}
	
	function getMsg(){
		return $this->MSG;
	}
	
	function setIdCadena($value){
		$this->CADENA = $value;
	}
	
	function getIdCadena(){
		return $this->CADENA;
	}
	
	function getNombreCadena(){
		$sql = "CALL `prealta`.`SP_GET_NOMBRECADENA`($this->CADENA)";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
	}
	
	function getExiste(){
		return $this->EXISTE;
	}
	
	function setIdGrupo($value){
		$this->GRUPO = $value;
	}
	
	function getIdGrupo(){
		return $this->GRUPO;
	}
	
	function getNombreGrupo(){
		$sql = "CALL `prealta`.`SP_GET_NOMBREGRUPO`($this->GRUPO);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
	}
	
	function setIdGiro($value){
		$this->GIRO = $value;
	}
	
	function getIdGiro(){
		return $this->GIRO;
	}
	
	function getNombreGiro(){
		$sql = "CALL `prealta`.`SP_GET_NOMBREGIRO`($this->GIRO);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
	}
	
	function setIdReferencia($value){
		$this->REFERENCIA = $value;
	}
	
	function getIdReferencia(){
		return $this->REFERENCIA;
	}
	
	function getNombreReferencia(){
		$sql = "CALL `redefectiva`.`SP_GET_NOMBREREFERENCIA`($this->REFERENCIA);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
	}
	
	function setTel1($value){
		$this->TEL1 = $value;
	}
	
	function getTel1(){
		return $this->TEL1;
	}
	
	function setTel2($value){
		$this->TEL2 = $value;
	}
	
	function getTel2(){
		return $this->TEL2;
	}
	
	function setFax($value){
		$this->FAX = $value;
	}
	
	function getFax(){
		return $this->FAX;
	}
	
	function setCorreo($value){
		$this->CORREO = $value;
	}
	
	function getCorreo(){
		return $this->CORREO;
	}
	
	function setDireccion($value){
		$this->DIRECCION = $value;
	}
	
	function getDireccion(){
		return $this->DIRECCION;
	}
	
	function setCalle($value){
		$this->CALLE = $value;
	}
	
	function getCalle(){
		return $this->CALLE;
	}
	
	function setNext($value){
		$this->NEXT = $value;
	}
	
	function getNext(){
		return $this->NEXT;
	}
	
	function setNint($value){
		$this->NINT = $value;
	}
	
	function getNint(){
		return $this->NINT;
	}
	
	function setColonia($value){
		$this->COLONIA = $value;
	}
	
	function getColonia(){
		return $this->COLONIA;
	}
	
	function getNombreColonia(){
		$sql = "CALL `redefectiva`.`SP_GET_COLONIA`($this->PAIS, $this->COLONIA);";		
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
	}
	
	function getCPColonia(){
		$sql = "CALL `redefectiva`.`SP_GET_CODIGOPOSTAL`($this->COLONIA);";
		$res = $this->RBD->query($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
		return "";
	}
	
	function setCiudad($value){
		$this->CIUDAD = $value;
	}
	
	function getCiudad(){
		return $this->CIUDAD;
	}
	
	function getNombreCiudad(){
		$sql = "CALL `prealta`.`SP_GET_CIUDAD`($this->PAIS, $this->ESTADO, $this->CIUDAD);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
	}
	
	function setEstado($value){
		$this->ESTADO = $value;
	}
	
	function getEstado(){
		return $this->ESTADO;
	}
	
	function getNombreEstado(){
		$sql = "CALL `prealta`.`SP_GET_ESTADO`($this->PAIS, $this->ESTADO);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
	}
	
	function setCP($value){
		$this->CP = $value;
	}
	
	function getCP(){
		if($this->CP == 0)
			return "";
		return $this->CP;
	}
	
	function setPais($value){
		$this->PAIS = $value;
	}
	
	function getPais(){
		return $this->PAIS;
	}
	
	function getNombrePais(){
		$sql = "CALL `redefectiva`.`SP_GET_PAIS`($this->PAIS);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
	}
	
	function setTipoDireccion($value){
		$this->TIPODIRECCION = $value;
	}
	
	function getTipoDireccion(){
		return $this->TIPODIRECCION;
	}
	
	function setContactos($value){
		$this->CONTACTOS = $value;
	}
	
	function getContactos(){
		return $this->CONTACTOS;
	}
	
	function setContacto($value){
		$this->CONTACTO = $value;
	}
	
	function getContacto(){
		return $this->CONTACTO;
	}
	
	function setIdECuenta($value){
		$this->ECUENTA = $value;
	}
	
	function getIdECuenta(){
		if($this->ECUENTA != '')
			return $this->ECUENTA;
		return -1;
	}
	
	function getNombreECuenta(){
		$sql = "CALL `redefectiva`.`SP_GET_NOMBREEJECUTIVO`($this->ECUENTA);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0]." ".$r[1]." ".$r[2];
		}
		return "";
	}
	
	function setIdEVenta($value){
		$this->EVENTA = $value;
	}
	
	function getIdEVenta(){
		if($this->EVENTA != '')
			return $this->EVENTA;
		return -1;
	}
	
	function getNombreEVenta(){
		$sql = "CALL `redefectiva`.`SP_GET_NOMBREEJECUTIVO`($this->EVENTA);";		
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0]." ".$r[1]." ".$r[2];
		}
		return "";
	}
	
	function Revisar(){
		$r = 1;

		if($this->REVISADOGENERALES && $this->REVISADODIRECCION && $this->REVISADOCONTACTOS && $this->REVISADOEVENTA && $this->REVISADOECUENTA && $this->REVISADOCARGOS)
			$r = 0;
		else
			$r = 1;
		
		$sql = "CALL `prealta`.`SP_SET_REVISADOPRECADENA`($r, $this->ID);";
		//var_dump("sql: $sql");
		$this->WBD->SP($sql);
		if($this->WBD->error() == '')
			return true;
		return false;
	}
	
	function IsRevisado(){
		if($this->REVISADOGENERALES && $this->REVISADODIRECCION && $this->REVISADOCONTACTOS && $this->REVISADOEVENTA && $this->REVISADOECUENTA && $this->REVISADOCARGOS)
			return true;
		return false;
	}
	
	function setRevisadoGenerales($value){
		$this->REVISADOGENERALES = $value;
	}
	
	function setPreRevisadoCargos($value){
		$this->PREREVISADOCARGOS = $value;
	}
	
	function setPreRevisadoGenerales($value){
		$this->PREREVISADOGENERALES = $value;
	}
	
	function setRevisadoCargos($value){
		$this->REVISADOCARGOS = $value;
	}
	
	function getPreRevisadoCargos(){
		return $this->PREREVISADOCARGOS;
	}
	
	function getRevisadoCargos(){
		return $this->REVISADOCARGOS;
	}
	
	function getRevisadoGenerales(){
		return $this->REVISADOGENERALES;
	}
		
	function getPreRevisadoGenerales(){
		return $this->PREREVISADOGENERALES;
	}
	
	function setRevisadoDireccion($value){
		$this->REVISADODIRECCION = $value;
	}
	
	function setPreRevisadoDireccion($value){
		$this->PREREVISADODIRECCION = $value;
	}
	
	function getRevisadoDireccion(){
		return $this->REVISADODIRECCION;
	}
	
	function getPreRevisadoDireccion(){
		return $this->PREREVISADODIRECCION;
	}	
	
	function setRevisadoContactos($value){
		$this->REVISADOCONTACTOS = $value;
	}
	
	function setPreRevisadoContactos($value){
		$this->PREREVISADOCONTACTOS = $value;
	}
	
	function getRevisadoContactos(){
		return $this->REVISADOCONTACTOS;
	}
	
	function getPreRevisadoContactos(){
		return $this->PREREVISADOCONTACTOS;
	}	
	
	function setRevisadoEjecutivos($value){
		if($this->SemaforoEjecutivos() == 0){
			$this->REVISADOECUENTA = $value;
			$this->REVISADOEVENTA = $value;
		}
	}
	
	function setPreRevisadoEjecutivos($value){
		if($this->SemaforoEjecutivos() == 0){
			$this->PREREVISADOECUENTA = $value;
			$this->PREREVISADOEVENTA = $value;
		}
	}
	
	function getRevisadoEjecutivos(){
		if($this->REVISADOECUENTA && $this->REVISADOEVENTA)
			return true;
		return false;
	}

	function getPreRevisadoEjecutivos(){
		if($this->PREREVISADOECUENTA && $this->PREREVISADOEVENTA)
			return true;
		return false;
	}
	
	function CalcularPorcentaje(){
		$this->PORCENTAJE = 0;
		if($this->SemaforoGenerales() == 0)
			$this->PORCENTAJE += 50;
		/*if($this->SemaforoDireccion() == 0)
			$this->PORCENTAJE+=25;
		if($this->SemaforoContactos() == 0)
			$this->PORCENTAJE+=25;*/
		if($this->SemaforoEjecutivos() == 0)
			$this->PORCENTAJE += 50;

		$sql = "CALL `prealta`.`SP_UPDATE_PORCENTAJEPRECADENA`($this->PORCENTAJE, $this->ID);";
		$this->WBD->SP($sql);
		if($this->WBD->error() == ''){
			return true;
		}
		return false;
	}
	
	function getPorcentaje(){
		$this->CalcularPorcentaje();
		return $this->PORCENTAJE;
	}
	
	function getRevisado(){
		return $this->REVISADO;
	}    
}


class Contacto{
	private $RBD;
	private $WBD;
	private $NOMBRE =   "";
	private $PATERNO =  "";
	private $MATERNO =  "";
	private $TELEFONO = "";
	private $EXTTEL =   "";
	private $CORREO =   "";
	private $TIPO =     "";
	private $ID = 0;
	private $INFID = 0;
	private $MSG = "";
	
	private $ERROR = "";
	
	function __construct($r,$w){
		$this->RBD = $r;
		$this->WBD = $w;
	}
	
	function load($id){
		$sql = "CALL `prealta`.`SP_LOAD_PRECADENACONTACTOS`($id);";
		$res = $this->RBD->SP($sql);
		if($this->RBD->error() == ''){
			if($res != '' && mysqli_num_rows($res) > 0){
				list($t,$idc,$n,$p,$m,$tel,$ext,$c) = mysqli_fetch_array($res);
				$this->INFID = $id;
				$this->ID = $idc;
				$this->TIPO = $t;
				$this->NOMBRE = $n;
				$this->PATERNO = $p;
				$this->MATERNO = $m;
				$this->TELEFONO = $tel;
				$this->EXTTEL = $ext;
				$this->CORREO = $c;
			}
		}
	}
	
	function Guardar($idCadena){
		if(!$this->Existe()){
			$sql = "CALL `prealta`.`SP_INSERT_PRECONTACTO`($this->TIPO, '$this->NOMBRE', '$this->PATERNO', '$this->MATERNO', '$this->TELEFONO', '$this->EXTTEL', '$this->CORREO', {$_SESSION['idU']});";
			$result = $this->WBD->SP($sql);
			if($this->WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $ultimoID ) = $result->fetch_array();
					$this->ID = $ultimoID;
					if(!$this->ExisteInf($idCadena)){
						$sql = "CALL `prealta`.`SP_INSERT_PRECADENACONTACTO`($idCadena, $this->ID, $this->TIPO, {$_SESSION['idU']});";
						$result = $this->WBD->SP($sql);
						if($this->WBD->error() == ''){
							if ( $result->num_rows > 0 ) {
								list( $ultimoID ) = $result->fetch_array();
								$this->INFID = $ultimoID;
								return true;
							} else {
								return false;
							}
						}
						$this->MSG = mysqli_errno($this->WBD->LINK) == 1062 ? "debido a que ya esta registrado" : "";
						return false;
					}
					$this->MSG = "debido a que ya esta registrado";
					return false;
				} else {
					return false;
				}
			}
			return false;
		} else {
			if ( !$this->ExisteInf($idCadena) ) {
				$sql = "CALL `prealta`.`SP_INSERT_PRECADENACONTACTO`($idCadena, $this->ID, $this->TIPO, {$_SESSION['idU']});"; 
				$result = $this->WBD->SP($sql);
				if ( $this->WBD->error() == '' ) {
					if ( $result->num_rows > 0 ) {
						list( $ultimoID ) = $result->fetch_array();
						$this->INFID = $ultimoID;
						return true;
					} else {
						return false;
					}
				}
				$this->MSG = mysqli_errno($this->WBD->LINK) == 1062 ? "debido a que ya esta registrado" : "";
				return false;
			}
			$this->MSG = "debido a que ya esta registrado";
			return false;
		}
	}
	
	function Borrar(){
		$sql = "CALL `prealta`.`SP_DISABLE_PRECADENACONTACTO`($this->INFID);";
		$this->WBD->SP($sql);
		if($this->WBD->error() == ''){
			return true;
		}else{
			return false;
		}
	}
	
	function Actualizar(){
		$sql = "CALL `prealta`.`SP_UPDATE_PRECONTACTO`('$this->NOMBRE', '$this->PATERNO', '$this->MATERNO', '$this->TELEFONO', '$this->EXTTEL', '$this->CORREO', $this->ID);";
		$this->WBD->SP($sql);
		if($this->WBD->error() == ''){
			$sql = "CALL `prealta`.`SP_UPDATE_PRECADENACONTACTO`($this->TIPO, $this->INFID);";
			$this->WBD->SP($sql);
			if($this->WBD->error() == ''){
				return true;
			}
			$this->ERROR = $this->WBD->error();
			return false;
		}
		$this->ERROR = $this->WBD->error();
		return false;
	}
	
	function Existe(){
		$sql = "CALL `prealta`.`SP_EXISTE_PRECONTACTO`('$this->NOMBRE', '$this->PATERNO', '$this->MATERNO', '$this->TELEFONO', '$this->EXT', '$this->CORREO');";
		$res = $this->RBD->SP($sql);
		if($this->RBD->error() == '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			$this->ID = $r[0];
			return true;
		}
		return false;
	}
	
	function ExisteInf($idCadena){
		$sql = "CALL `prealta`.`SP_EXISTE_PRECADENACONTACTO`($idCadena, $this->ID);";
		$res = $this->RBD->SP($sql);
		if($this->RBD->error() == '' && mysqli_num_rows($res) > 0){
			return true;
		}
		return false;
	}
	
	function setId($value){
	   $this->Id = $value;
	}
	
	function getId(){
		return $this->ID;
	}
	
	function setInfId($value){
	   $this->INFID = $value;
	}
	
	function getInfId(){
		return $this->INFID;
	}
	
	function setTipoContacto($value){
		$this->TIPO = $value;
	}
	
	function getTipoContacto(){
		return $this->TIPO;
	}
	
	function setNombre($value){
		$this->NOMBRE = $value;
	}
	
	function getNombre(){
		return $this->NOMBRE;
	}
	
	function setPaterno($value){
		$this->PATERNO = $value;
	}
	
	function getPaterno(){
		return $this->PATERNO;
	}
	
	function setMaterno($value){
		$this->MATERNO = $value;
	}
	
	function getMaterno(){
		return $this->MATERNO;
	}

	function setTelefono($value){
		$this->TELEFONO = $value;
	}
	
	function getTelefono(){
		return $this->TELEFONO;
	}
	
	function setExtTel($value){
		$this->EXTTEL = $value;
	}
	
	function getExtTel(){
		return $this->EXTTEL;
	}
	
	function setCorreo($value){
		$this->CORREO = $value;
	}
	
	function getCorreo(){
		return $this->CORREO;
	}
	
	function getError(){
		return $this->ERROR;
	}
	
	function getMsg(){
		return $this->MSG;
	}
	
}
?>