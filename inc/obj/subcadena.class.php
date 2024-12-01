<?php
class SubCadena{
    public $RBD,$WBD;
    private $ID;
	private $IDGRUPO;
	private $IDCADENA;
	private $IDCGIRO;
	private $NOMBRE;
	private $TEL1;
	private $TEL2;
	private $FAX;
	private $MAIL;
	private $IDCREF;
	private $IDUSERALTA;
	private $STATUS;
	private $FECALTA;
	private $DIRCALLE;
	private $DIRNINT;
	private $DIRNEXT;
	private $DIRNOMBRECOLONIA;
	private $DIRIDCOLONIA;
	private $DIRNOMBRECIUDAD;
	private $DIRIDESTADO;
	private $DIRNOMBREESTADO;
	private $DIRCODIGOPOSTAL;
	private $DIRNOMBREPAIS;
	private $DIRIDPAIS;
	private $DIRIDCIUDAD;  
	private $TIPODIRECCION;
	private $NUMCUENTA;
	private $REFERENCIABANCARIAESTATUS;
	private $REFERENCIABANCARIA;
	private $IDIVA;
	private $DESCIVA;
	
    public function __construct($RBD,$WBD) 
	{
		#$this->LOG							=	$LOG;
		$this->RBD							=	$RBD;
		#$this->LOG2						=	$LOG2;
		$this->WBD							=	$WBD;
		$this->ID							=	0;
		$this->IDGRUPO						=	NULL;		
		$this->IDCADENA						=	NULL;		
		$this->IDCGIRO						=	NULL;
		$this->NOMBRE						=	NULL;
		$this->TEL1							=	NULL;
		$this->TEL2							=	NULL;
		$this->FAX							=	NULL;
		$this->MAIL							=	NULL;
		$this->IDCREF						=	NULL;
		$this->IDUSERALTA					=	NULL;
		$this->STATUS						=	NULL;
		$this->FECALTA						=	NULL;
		$this->DIRCALLE						=	NULL;
		$this->DIRNINT						=	NULL;
		$this->DIRNEXT						=	NULL;
		$this->DIRNOMBRECOLONIA				=	NULL;
		$this->DIRIDCOLONIA					=	NULL;
		$this->DIRNOMBRECIUDAD				=	NULL;
		$this->DIRIDESTADO					=	NULL;
		$this->DIRNOMBREESTADO				=	NULL;
		$this->DIRCODIGOPOSTAL				=	NULL;
		$this->DIRNOMBREPAIS				=	NULL;
		$this->DIRIDPAIS					=	NULL;
		$this->DIRIDCIUDAD					=	NULL;
		$this->TIPODIRECCION 				= 	"";
		$this->NUMCUENTA					=	NULL;
		$this->REFERENCIABANCARIAESTATUS	=	NULL;
		$this->REFERENCIABANCARIA			=	NULL;
		$this->IDIVA						=	NULL;	
		$this->DESCIVA						=	NULL;
	}
	
	public function load($ID)
	{		 	 	 	 	 	 	 	 	 	 	 	 	
		$SQL = "CALL `redefectiva`.`SP_LOAD_SUBCADENA`($ID)";
		
		$Result = $this->RBD->query($SQL);
		if($Result){
			if(mysqli_num_rows($Result) > 0)
			{
				list(
					$this->ID,
					$this->IDGRUPO,
					$this->IDCADENA,
					$this->IDCGIRO,
					$this->NOMBRE,
					$this->TEL1,
					$this->TEL2,
					$this->FAX,
					$this->MAIL,
					$this->IDCREF,
					$this->IDUSERALTA,
					$this->STATUS,
					$this->FECALTA,
					$this->NOMBRE_GRUPO,
					$this->NOMBRE_CADENA,
					$this->NOMBRE_GIRO,
					$this->NUMEROCORRESPONSALES,
					$this->NOMBRE_USUARIOALTA,
					$this->SALDOCUENTA,
					$this->FORELO,
					$this->NUMCUENTA,
					$this->DESCACCESO,
					$this->REFERENCIA,
					$this->IDVERSION,
					$this->NOMBRE_VERSION,
					$this->NUMEROCONTRATO,
					$this->ID_REPLEGAL,
					$this->NOMBRE_REPLEGAL,
					$this->RFC_REPLEGAL,
					$this->NOMBRE_ESTATUS,
					$this->DIRCALLE,
					$this->DIRNINT,
					$this->DIRNEXT,
					$this->DIRNOMBRECOLONIA,
					$this->DIRIDCOLONIA,
					$this->DIRNOMBRECIUDAD,
					$this->DIRIDCIUDAD,
					$this->DIRIDESTADO,
					$this->DIRNOMBREESTADO,
					$this->DIRCODIGOPOSTAL,
					$this->DIRNOMBREPAIS,
					$this->DIRIDPAIS,
					$this->REFERENCIABANCARIAESTATUS,
					$this->REFERENCIABANCARIA,
					$this->IDIVA,
					$this->DESCIVA,
					$this->RFC_CONTRATO
				) = mysqli_fetch_array($Result);

				$this->setNombreEjecutivoCuentas();
				$this->setNombreEjecutivoVentas();

				return self::respuesta(0,"Mensaje cargado con exito"); 
			}
			else{
				return self::respuesta(2,"No se encontro Mensaje"); 
			}
		}else{return self::respuesta(2,"No fue posible consultar datos");}
	}

    function getComboByName($idCadena){
        $res = null;
        $res = $this->RBD->query("SELECT `idSubCadena`,`nombreSubCadena` FROM `redefectiva`.`dat_subcadena` where idCadena = $idCadena ORDER BY `nombreSubCadena`;");
        $d = "";
        if($res != null){
            $d = "<select id='selsubcad' class='com'><option>&lt;Ninguna SubCadena&gt;</option>";
            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[0]'>$r[1]</option>";
                if($idCadena == 63)
                    $d.="<option value='0'>Unipuntos</option>";
            }
            $d.="</select>";
            return $d;
        }else{
            return "<select id='selsubcad' class='com'><option>&lt;Ninguna SubCadena&gt;</option>";
        }
    }

	function getId(){
		return $this->ID;
	}

	function getGrupo(){
		if(!empty($this->IDGRUPO)){
			return $this->IDGRUPO;
		}
		else{
			return 0;
		}
	}

	function getNombreGrupo(){
		//$res = $this->RBD->query("SELECT `nombreGrupo` FROM `redefectiva`.`dat_grupo` WHERE `idGrupo`= ".$this->IDGRUPO.";");
		$nombreGrupo = "No tiene";
		/*if($res != NULL){
			$nombreGrupo =  mysqli_fetch_array($res);
			$nombreGrupo = $nombreGrupo[0];
		}*/
		if(!empty($this->NOMBRE_GRUPO)){
			$nombreGrupo = $this->NOMBRE_GRUPO;
		}
		return $nombreGrupo;
	}

	function getCadena(){
		return $this->IDCADENA;
	}

	function getNombreCadena(){
		//$res = $this->RBD->query("SELECT `nombreCadena` FROM `redefectiva`.`dat_cadena` WHERE `idCadena` = $this->IDCADENA ;");
		$nombreCadena = "";
		/*if($res != NULL){
			$nombreCadena =  mysqli_fetch_array($res);
			$nombreCadena = $nombreCadena[0];
		}*/
		if(!empty($this->NOMBRE_CADENA)){
			$nombreCadena = $this->NOMBRE_CADENA;
		}
		return $nombreCadena;
	}

	function getGiro(){
		return $this->IDCGIRO;
	}

	function getNombreGiro(){
		//$res = $this->RBD->query("SELECT `nombreGiro` FROM `redefectiva`.`cat_giro` WHERE `idGiro`= ".$this->IDCGIRO.";");
		$nombreGiro = "";
		/*if($res != NULL){
			$nombreGiro =  mysqli_fetch_array($res);
			$nombreGiro = $nombreGiro[0];
		}*/
		if(!empty($this->NOMBRE_GIRO)){
			$nombreGiro = $this->NOMBRE_GIRO;
		}
		return $nombreGiro;
	}

	function getCountCorresponsales($idSubX){
		//$res = $this->RBD->query("SELECT COUNT(`idCorresponsal`) FROM `redefectiva`.`dat_corresponsal` WHERE `idSubCadena`= $idSubX AND `idCadena` = $this->IDCADENA;");
		$countX = "No Tiene";
		/*if($res != NULL){
			$countX =  mysqli_fetch_array($res);
			$countX = $countX[0];
		}*/
		if(!empty($this->NUMEROCORRESPONSALES)){
			$countX = $this->NUMEROCORRESPONSALES;
		}
		return $countX;
	}

	function getCountCorresponsales2($idSubX){
		//$res = $this->RBD->query("SELECT COUNT(`idCorresponsal`) FROM `redefectiva`.`dat_corresponsal` WHERE `idSubCadena`= $idSubX AND `idCadena` = $this->IDCADENA;");
		$countX = "0";
		/*if($res != NULL){
			$countX =  mysqli_fetch_array($res);
			$countX = $countX[0];
		}*/
		if(!empty($this->NUMEROCORRESPONSALES)){
			$countX = $this->NUMEROCORRESPONSALES;
		}
		return $countX;
	}

	function getCodigos(){
	    /*$sql = "SELECT `idCadena`,`idSubCadena`,`idCorresponsal`,`Codigo`
	    	    FROM `nautilus`.`conf_codigo`
		    WHERE (`idCadena` = $this->IDCADENA) AND (`idSubCadena` = $this->IDSUBCADENA OR `idSubCadena` = -1) AND (`idCorresponsal` = $this->ID OR `idCorresponsal` = -1)
		    ORDER BY `idCadena`,`idSubCadena`,`idCorresponsal`;";*/
	    $sql = "CALL `nautilus`.`SP_FIND_CODIGOS`(".$this->IDCADENA.", ".$this->ID.", -1)";
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
	    return "N/A";
	}
	
	
	function getNombre(){
		return $this->NOMBRE;
	}
	
	function getTel1(){
		return $this->TEL1;
	}
	
	function getTel2(){
		return $this->TEL2;
	}
	
	function getFax(){
		return $this->FAX;
	}
	
	function getMail(){
		return $this->MAIL;
	}
	
	function getIdRef(){
		return $this->IDCREF;
	}
	
	function getFecAlta(){
		return $this->FECALTA;
	}
	
	function getIdEjecutivoCuenta(){
		/*$qry = "SELECT inf.`idEjecutivo`
				FROM `inf_subcadenaejecutivo` AS inf
				LEFT JOIN `dat_ejecutivo` AS dat
				ON inf.`idEjecutivo` = dat.`idEjecutivo`
				WHERE inf.`idSubCadena` = ".$this->ID."
				AND dat.`idcTipoEjecutivo` = 5
				AND inf.`idEstatusSubCadEjec` = 0
				AND dat.`idEstatusEjecutivo` = 0;
				";
		$res = $this->RBD->query($qry);
		$nombresEjecutiv = -2;
		if($res != NULL){
			 while($r = mysqli_fetch_array($res)){
			 	$nombresEjecutiv = $r[0];
			 }
		}
		return $nombresEjecutiv;*/
		if(!empty($this->IDEJECUTIVOCUENTA)){
			return $this->IDEJECUTIVOCUENTA;
		}
		else{
			return 0;
		}
	}
	
	function setNombreEjecutivoCuentas(){
		$query = "CALL `redefectiva`.`SP_FIND_EJECUTIVO`(".$this->ID.", 5, 2)";
		try{
			$sql = $this->RBD->query($query);

			if(!$this->RBD->error()){
				$row = mysqli_fetch_assoc($sql);
				$this->NOMBRE_EJECUTIVOCUENTA = $row["nombreCompletoEjecutivo"];
				$this->IDEJECUTIVOCUENTA = $row["idEjecutivo"];
			}
			else{
				$this->NOMBRE_EJECUTIVOCUENTA = "No tiene";
				$this->IDEJECUTIVOVENTA = 0;
			}
		}catch(PDOException $e){
			echo "Error".$e->getMessage();
		}
	}
	
	function getNombreEjecutivoCuentas(){
		if(!empty($this->NOMBRE_EJECUTIVOCUENTA)){
			return $this->NOMBRE_EJECUTIVOCUENTA;
		}
		else{
			return "No cuenta con Ejecutivo de Cuenta";
		}
	}

	function setNombreEjecutivoVentas(){
		$query = "CALL `redefectiva`.`SP_FIND_EJECUTIVO`(".$this->ID.", 2, 2)";
		try{
			$sql = $this->RBD->query($query);

			if(!$this->RBD->error()){
				$row = mysqli_fetch_assoc($sql);
				$this->NOMBRE_EJECUTIVOVENTA = $row["nombreCompletoEjecutivo"];
				$this->IDEJECUTIVOVENTA = $row["idEjecutivo"];
			}
			else{
				$this->NOMBRE_EJECUTIVOVENTA = "No tiene";
				$this->IDEJECUTIVOVENTA = 0;
			}
		}catch(PDOException $e){
			echo "Error".$e->getMessage();
		}
	}

	function getNombreEjecutivoVentas(){
		if(!empty($this->NOMBRE_EJECUTIVOVENTA)){
			return $this->NOMBRE_EJECUTIVOVENTA;
		}
		else{
			return "No cuenta con Ejecutivo de Venta";
		}
	}

	function getIdEjecutivoVentas(){
		if(!empty($this->IDEJECUTIVOVENTA)){
			return $this->IDEJECUTIVOVENTA;
		}
		else{
			return 0;
		}
	}
	
	
	function getidUsuarioAlta(){
		return $this->IDUSERALTA;
	}
	function getUsuarioAlta(){
		$usuAlta = "No tiene";
		/*if($this->IDUSERALTA > 0){
			$qry="SELECT `nombreUsuario`,`paternoUsuario`,`maternoUsuario` FROM `data_acceso`.`in_usuarioad` WHERE `idusuario`= ".$this->IDUSERALTA.";";
			$res = $this->RBD->query($qry);
	
			if($res != NULL){
				$usuAlta =  mysqli_fetch_array($res);
				$usuAlta = $usuAlta[0].' '.$usuAlta[1].' '.$usuAlta[2];
			}
		}*/
		if(!empty($this->NOMBRE_USUARIOALTA)){
			$usuAlta = $this->NOMBRE_USUARIOALTA;
		}
		return $usuAlta;
	}

	function getIdStatus(){
		return $this->STATUS;
	}
	function getStatus(){
		$nombreStatus;
		if(!empty($this->NOMBRE_ESTATUS)){
			return $this->NOMBRE_ESTATUS;
		}
		else{
			switch($this->STATUS){
				case 0:$nombreStatus="Activo";
				break;
				case 1:$nombreStatus="Inactivo";
				break;
				case 2:$nombreStatus="Suspendido";
				break;
				case 3:$nombreStatus="Cancelado";
				break;
				case 4:$nombreStatus="Bloqueado";
				break;
			}
			return $nombreStatus;
		}
	}

	function getSaldo(){
		return $this->SALDOCUENTA;
	}

	function getForelo(){
	    //$res = $this->RBD->query("SELECT `saldoCuenta`,`FORELO` FROM `redefectiva`.`ops_cuenta` WHERE `idSubCadena` = $this->ID AND `idCorresponsal` = -1;");
	    
	    //if($res != ''){
		if($this->SALDOCUENTA && $this->FORELO){
			$r = mysqli_fetch_array($res);
			//$saldo = $r[0];
			//$forelo = $r[1];
			$saldo = $this->SALDOCUENTA;
			$forelo = $this->FORELO;
			$foreloporcentaje = ($forelo > 0) ? ($saldo / $forelo) * 100 : 100;
			$foreloporcentaje = ($saldo == 0 && $forelo == 0) ? 0 : $foreloporcentaje;
			$clase = "";
			if($foreloporcentaje < 30)
			    $clase = "forelo_rojo";
			else if($foreloporcentaje > 29 && $foreloporcentaje < 51)
			    $clase = "forelo_amarillo";
			else
			    $clase = "forelo_verde";
			return "<span class='$clase'>".round($foreloporcentaje)."%</span>";
	    }else 
		return "";
	}
	function getCuentaForelo(){
	    //$res = $this->RBD->query("SELECT `numCuenta` FROM `redefectiva`.`ops_cuenta` WHERE `idSubCadena` = $this->ID AND `idCorresponsal` = -1;");
	    
	    /*if($res != ''){
			$r = mysqli_fetch_array($res);
			$cta = $r[0];
			return $cta;
	    }else 
		return "";*/
		if(!empty($this->NUMCUENTA)){
			return $this->NUMCUENTA;
		}
		else{
			return "No tiene";
		}
	}
	
	/*					a este le falta el numero de cuenta k no viene en dat_subcadena     --de donde se obtiene?
	function getForelo(){
	    $res = $this->RBD->query("SELECT `saldoCuenta`,`FORELO` FROM `redefectiva`.`ops_cuenta` WHERE `numCuenta` = '$this->NUMCUENTA';");
	    
	    if($res != ''){
		$r = mysqli_fetch_array($res);
		$saldo = $r[0];
		$forelo = $r[1];
		$foreloporcentaje = ($forelo > 0) ? ($saldo / $forelo) * 100 : 100;
		$foreloporcentaje = ($saldo == 0 && $forelo == 0) ? 0 : $foreloporcentaje;
		return round($foreloporcentaje)."%";
	    }else 
		return "";
	}
	*/
	
	
	function getTipoAcceso(){
	    /*$sql = "SELECT A.`descTipoAcceso`
	    	    FROM `nautilus`.`cat_tipoacceso` as A
		    INNER JOIN `nautilus`.`inf_clienteacceso` as I on I.`idTipoAcceso` = A.`idTipoAcceso`
		    WHERE I.`idSubCadena` = $this->ID AND I.`idCorresponsal` = -1 ;";*/
	   /* $res = $this->RBD->query($sql);
	    if($res != '' && mysqli_num_rows($res) > 0){
		$r = mysqli_fetch_array($res);
		return "Acceso v&iacute;a $r[0]";
		 
	    }*/
	    if(!empty($this->DESCACCESO)){
	    	return "Acceso v&iacute;a ".$this->DESCACCESO;
	    }
	    else{
	    	return "Sin Accesos";
	    }
	}
	
	
	function getNombreCodigos(){
	    /*$sql = "SELECT `idCadena`,`idSubCadena`,`idCorresponsal`,`Codigo`
	    	    FROM `nautilus`.`conf_codigo`
		    WHERE (`idCadena` = $this->IDCADENA) AND (`idSubCadena` = $this->ID OR `idSubCadena` = -1) AND (`idCorresponsal` = -1)
		    ORDER BY `idCadena`,`idSubCadena`,`idCorresponsal`;";*/
	    $sql = "CALl `nautilus`.`SP_FIND_CODIGOS`(".$this->IDCADENA.", ".$this->ID.", -1)";
	    $res = $this->RBD->query($sql);
	    if($res != '' && mysqli_num_rows($res) > 0){
		$d = "";
		while(list($idcadena,$idsubcadena,$idcorresponsal,$codigo) = mysqli_fetch_array($res)){
		    $codigores = "$codigo";
		    $codigores.= ($idcadena == $this->IDCADENA && $idsubcadena == -1 && $idcorresponsal == -1) ? " (Cadena)" : "";
		    $codigores.= ($idcadena == $this->IDCADENA && $idsubcadena == $this->ID && $idcorresponsal == -1) ? " (SubCadena)" : "";
		    $d.=$codigores."<br />";
		}
		return $d;
	    }
	    return "N/A";
	}

	function getReferencia(){
		if(!empty($this->REFERENCIA)){
			return $this->REFERENCIA;
		}
		else{
			return "No cuenta con Referencia Asignada";
		}
	}

	function getIdVersion(){
		if(!empty($this->IDVERSION)){
			return $this->IDVERSION;
		}
		else{
			return 0;
		}
	}

	function getVersion(){
		if(!empty($this->NOMBRE_VERSION)){
			return $this->NOMBRE_VERSION;
		}
		else{
			return "Sin Versi&oacute;n";
		}
	}

	function getNumeroContrato(){
		if(!empty($this->NUMEROCONTRATO)){
			return $this->NUMEROCONTRATO;
		}
		else{
			return 0;
		}
	}

	function getIdRepresentateLegal(){
		if(!empty($this->ID_REPLEGAL)){
			return $this->ID_REPLEGAL;
		}
		else{
			return 0;
		}
	}

	function getNombreRepresentanteLegal(){
		if(!empty($this->NOMBRE_REPLEGAL)){
			return $this->NOMBRE_REPLEGAL;
		}
		else{
			return "no tiene";
		}
	}

	function getRFCRepresentanteLegal(){
		if(!empty($this->RFC_REPLEGAL)){
			return $this->RFC_REPLEGAL;
		}
		else{
			return "no tiene";
		}
	}

	function getDireccion(){
		if ( isset($this->DIRCALLE) && isset($this->DIRNEXT) ) {
			if ( isset($this->DIRNINT) && !empty($this->DIRNINT) ) { 
				return $this->DIRCALLE.' No. Ext. '.$this->DIRNEXT.' No. Int. '.$this->DIRNINT;
			} else {
				return $this->DIRCALLE.' No. Ext. '.$this->DIRNEXT;
			}
		} else {
	    	return "No tiene";
		}
	}

	function getCalle(){
		if ( isset($this->DIRCALLE) )
			return $this->DIRCALLE;
		else
	    	return "No tiene";
	}
	
	function setCalle($value){
		$this->DIRCALLE = $value;
	}	
	
	function getNext(){
		if ( isset($this->DIRNEXT) )
			return $this->DIRNEXT;
		else
	    	return "No tiene";
	}

	function setNext($value){
		$this->DIRNEXT = $value;
	}
		
	function getNint(){
		if ( isset($this->DIRNINT) )
			return $this->DIRNINT;
		else
	    	return "No tiene";
	}
	
	function setNint($value){
		$this->DIRNINT = $value;
	}	
		
	function getNombreColonia(){
		if ( isset($this->DIRNOMBRECOLONIA) )
			return $this->DIRNOMBRECOLONIA;
		else
	    	return "No tiene";
	}
	
	function getColonia(){
		if ( isset($this->DIRIDCOLONIA) )
			return $this->DIRIDCOLONIA;
		else
	    	return "No tiene";
	}	
	
	function setColonia($value){
		$this->DIRCOLONIA = $value;
	}	
	
	function getNombreCiudad(){
		if ( isset($this->DIRNOMBRECIUDAD) )
			return $this->DIRNOMBRECIUDAD;
		else
	    	return "No tiene";
	}
	
	function getEstado(){
		if ( isset($this->DIRIDESTADO) )
			return $this->DIRIDESTADO;
		else
	    	return "No tiene";
	}
	
	function setEstado($value){
		$this->DIRESTADO = $value;
	}	
	
	function getNombreEstado(){
		if ( isset($this->DIRNOMBREESTADO) )
			return $this->DIRNOMBREESTADO;
		else
	    	return "No tiene";
	}
	
	function getCP(){
		if ( isset($this->DIRCODIGOPOSTAL) )
			return $this->DIRCODIGOPOSTAL;
		else
	    	return "No tiene";
	}
	
	function setCP($value){
		$this->DIRCP = $value;
	}	
	
	function getNombrePais(){
		if ( isset($this->DIRNOMBREPAIS) )
			return $this->DIRNOMBREPAIS;
		else
	    	return "No tiene";
	}
	
	function getPais(){
		if ( isset($this->DIRIDPAIS) )
			return $this->DIRIDPAIS;
		else
	    	return "No tiene";
	}
	
	function setPais($value){
		$this->DIRPAIS = $value;
	}	
		
	function getCiudad(){
		if ( isset($this->DIRIDCIUDAD) )
			return $this->DIRIDCIUDAD;
		else
	    	return "No tiene";
	}

	function setCiudad($value){
		$this->DIRCIUDAD = $value;
	}

	function setTipoDireccion($value){
		$this->TIPODIRECCION = $value;
	}
	
	function getTipoDireccion(){
		return $this->TIPODIRECCION;
	}	

    private function respuesta($codigoRespuesta = 1 ,$descRespuesta = "Error Generico", $Data = NULL)
	{
			$RESPUESTA = array(
			'codigoRespuesta' 	 => $codigoRespuesta, 
			'descRespuesta' 	 => $descRespuesta,
			'data' 				 => $Data
		);
		
		return $RESPUESTA;
	}
    
    function __destruct(){}

    public function getConfPermisos($categoria){
		$sql = $this->RBD->query("CALL `redefectiva`.`SP_FIND_CATEGORIA_PERMISOS`(".$this->IDCADENA.",".$this->ID.", -1)");

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
	
	function GuardarDireccion( $idEmpleado ){
		$sql = "CALL `redefectiva`.`SP_UPDATE_DIRECCIONSUBCADENA`('$this->IDCADENA', '$this->ID', '$this->DIRCALLE', '$this->DIRNINT', '$this->DIRNEXT', $this->DIRPAIS, $this->DIRESTADO, $this->DIRCIUDAD, $this->DIRCOLONIA, $this->DIRCP, $this->TIPODIRECCION, $idEmpleado);";
		$result = $this->WBD->SP($sql);
		if ( $this->WBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				//list( $ultimoID ) = $result->fetch_array();
				//$this->DIRECCION = $ultimoID;
				return true;				
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function getIdIva(){
		if(!empty($this->IDIVA)){
			return $this->IDIVA;
		}
		else{
			return 0;
		}
	}

	function getDescIva(){
		if(!empty($this->DESCIVA)){
			return $this->DESCIVA;
		}
		else{
			return "No tiene";
		}
	}
	
	function getReferenciaBancaria(){
		if ( isset($this->REFERENCIABANCARIAESTATUS) && isset($this->REFERENCIABANCARIA) ) {
			$salida = $this->REFERENCIABANCARIA;
			$salida .= ($this->REFERENCIABANCARIAESTATUS)? " (Inactiva)" : "";
			return $salida;
		} else {
	    	return "No tiene";
		}
	}

	function getRFCContrato(){
		if(!empty($this->RFC_CONTRATO)){
			return $this->RFC_CONTRATO;
		}
		else{
			return '';
		}
	}
	
}
?>