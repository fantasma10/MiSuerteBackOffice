<?php
class Cadena{
    public $RBD,$WBD;
	public $ID;
	public $IDGRUPO;
	public $IDGIRO;
	public $NOMBRE;
	public $TEL1;
	public $TEL2;
	public $FAX;
	public $MAIL;
	public $IDCREF;
	public $IDUSERALTA;
	public $STATUS;
	public $FECALTA;
	public $NUMERO_CORRESPONSALES;
	public $SUBCADENAS;
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
			
	public function __construct($RBD,$WBD) 
	{
		#$this->LOG						=	$LOG;
		$this->RBD						=	$RBD;
		#$this->LOG2					=	$LOG2;
		$this->WBD						=	$WBD;
		$this->ID						=	0;

		$this->IDGRUPO					=	"No Tiene";		
		$this->IDCGIRO					=	NULL;
		$this->NOMBRE					=	NULL;
		$this->TEL1						=	NULL;
		$this->TEL2						=	NULL;
		$this->FAX						=	NULL;
		$this->MAIL						=	NULL;
		$this->IDCREF					=	NULL;
		$this->IDUSERALTA				=	NULL;
		$this->STATUS					=	NULL;
		$this->FECALTA					=	NULL;
		$this->NUMERO_CORRESPONSALES	=	NULL;
		$this->SUBCADENAS				=	NULL;
		$this->DIRCALLE					=	NULL;
		$this->DIRNINT					=	NULL;
		$this->DIRNEXT					=	NULL;
		$this->DIRNOMBRECOLONIA			=	NULL;
		$this->DIRIDCOLONIA				=	NULL;
		$this->DIRNOMBRECIUDAD			=	NULL;
		$this->DIRIDESTADO				=	NULL;
		$this->DIRNOMBREESTADO			=	NULL;
		$this->DIRCODIGOPOSTAL			=	NULL;
		$this->DIRNOMBREPAIS			=	NULL;
		$this->DIRIDPAIS				=	NULL;
		$this->DIRIDCIUDAD				=	NULL;
		$this->TIPODIRECCION 			= 	"";
	}
	
	public function load($ID)
	{		 	 	 	 	 	 	 	 	 	 	 	 	
		/*$SQL = "SELECT `idCadena`, `idGrupo`, `idcGiro`, `nombreCadena`, `telefono1`, `telefono2`, `fax`, `email`, `idcReferencia`, `idUsuarioAlta`, `idEstatusCadena`, `fecAltaCadena`
				FROM `redefectiva`.`dat_cadena`
				WHERE `idCadena` =   $ID";*/
		
		$SQL = "CALL redefectiva.SP_LOAD_CADENA($ID)";
		$Result = $this->RBD->query($SQL);
		if($Result){
			if(mysqli_num_rows($Result) > 0)
			{
				list(
					$this->ID,
					$this->IDGRUPO,
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
					$this->NOMBREGRUPO,
					$this->NUMERO_CORRESPONSALES,
					$this->NOMBRE_GIRO,
					$this->USUARIO_ALTA,
					$this->NOMBRE_ESTATUS,
					$this->VERSIONES,
					$this->REFERENCIA,
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
					$this->NUM_CUENTA
				) = mysqli_fetch_array($Result);
				$this->setNombreEjecutivoCuentas();
				$this->setNombreEjecutivoVentas();
				return self::respuesta(0,"Mensaje cargado con exito"); 
			}else{
				return self::respuesta(2,"No se encontro la Cadena en la Base de Datos"); 
			}
		}else{return self::respuesta(2,"No fue posible consultar datos");}
	}
	
    function getComboByName(){
        $res = null;
        $res = $this->RBD->query("SELECT `idCadena`,`nombreCadena` FROM `redefectiva`.`dat_cadena` ORDER BY `nombreCadena`;");
        $d = "";
        if($res != null){
            $d = "<select id='ddlCad'><option>&lt;Ninguna Cadena&gt;</option>";
            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[0]'>$r[1].</option>";
            }
            $d.="</select>";
            return $d;
        }else{
            return "<select id='ddlCad'><option>&lt;Ninguna Cadena&gt;</option></select>";
        }
    }
    function getId(){
		if ( $this->ID >= 0 )
			return $this->ID;
		else
			return "No tiene";
    }
	
    function getGrupo(){
	    return $this->IDGRUPO;
    }
    function getNombreGrupo(){#join
	    /*$res = $this->RBD->query("SELECT `nombreGrupo` FROM `redefectiva`.`dat_grupo` WHERE `idGrupo`= ".$this->IDGRUPO.";");
	    $nombreGrupo = "";
	    if($res != NULL){
		    $nombreGrupo =  mysqli_fetch_array($res);
		    $nombreGrupo = $nombreGrupo[0];
	    }
	    return $nombreGrupo;*/
	    if(!empty($this->NOMBREGRUPO)){
	    	return $this->NOMBREGRUPO;
	    }else{
	    	return "No tiene";
	    }
    }
	
    function getCountCorresponsales(){
	    $numero = 0;
	    if(!empty($this->NUMERO_CORRESPONSALES)){
	    	$numero = $this->NUMERO_CORRESPONSALES;
	    }
	    return $numero;
    }

    function getGiro(){
	    return $this->IDCGIRO;
    }
    function getNombreGiro(){#join
	    /*$res = $this->RBD->query("SELECT `nombreGiro` FROM `redefectiva`.`cat_giro` WHERE `idGiro`= ".$this->IDCGIRO.";");
	    $nombreGiro = "";
	    if($res != NULL){
		    $nombreGiro =  mysqli_fetch_array($res);
		    $nombreGiro = $nombreGiro[0];
	    }*/
	    $nombreGiro = "";
	    if(!empty($this->NOMBRE_GIRO)){
	    	$nombreGiro = $this->NOMBRE_GIRO;
	    }
	    return $nombreGiro;
    }
    
    function getNombre(){
	    return $this->NOMBRE;
    }
    
    function getTel1(){
		if ( !empty($this->TEL1) )
	    	return $this->TEL1;
		else
			return "No tiene";
    }
    
    function getTel2(){
	    return $this->TEL2;
    }
    
    function getFax(){
	    return $this->FAX;
    }
    
    function getMail(){
		if ( !empty($this->MAIL) )
	    	return $this->MAIL;
		else
			return "No tiene";
    }
    
    function getIdRef(){
	    return $this->IDCREF;
    }

    function getReferencia(){
		if ( !empty($this->REFERENCIA) )
    		return $this->REFERENCIA;
		else
			return "No tiene";
    }
    
    function getidUsuarioAlta(){
	    return $this->IDUSERALTA;
    }
    function getUsuarioAlta(){#join
		$usuAlta = "No tiene";
	   /* if($this->IDUSERALTA > 0){
		    $qry="SELECT `nombreUsuario`,`paternoUsuario`,`maternoUsuario` FROM `data_acceso`.`in_usuarioad` WHERE `idusuario`= ".$this->IDUSERALTA.";";
		    $res = $this->RBD->query($qry);
    
		    if($res != NULL){
			    $usuAlta =  mysqli_fetch_array($res);
			    $usuAlta = $usuAlta[0].' '.$usuAlta[1].' '.$usuAlta[2];
		    }
	    }*/
	    if(!empty($this->USUARIO_ALTA)){
	    	$usuAlta = $this->USUARIO_ALTA;
	    } else {
			$usuAlta = "No tiene";
		}
	    return $usuAlta;
    }

    function getStatus(){#join
	    $nombreStatus;
	    /*switch($this->STATUS){
		    case 0:$nombreStatus="Activo";
		    break;
		    case 1:$nombreStatus="Pendiente";
		    break;
		    case 2:$nombreStatus="Suspendido";
		    break;
		    case 3:$nombreStatus="Baja";
		    break;
			case 4:$nombreStatus="Bloqueado";
			break;
	    }*/
	    if(!empty($this->NOMBRE_ESTATUS)){
	    	$nombreStatus = $this->NOMBRE_ESTATUS;
	    } else {
			$nombreStatus = "No tiene";
		}
	    return $nombreStatus;
    }
    function getIdStatus(){
	    return $this->STATUS;
    }
    function getFecAlta(){
		if ( !empty($this->FECALTA) )
	    	return $this->FECALTA;
		else
			return "No tiene";
    }
    function getIdEjecutivoCuenta(){
		if(!empty($this->ID_EJECUTIVOCUENTA)){
			return $this->ID_EJECUTIVOCUENTA;
		}
		else{
			return 0;
		}
    }

   	function getIdEjecutivoVenta(){
		if(!empty($this->ID_EJECUTIVOVENTA)){
			return $this->ID_EJECUTIVOVENTA;
		}
		else{
			return 0;
		}
    }

    function setNombreEjecutivoCuentas(){
		$query = "CALL `redefectiva`.`SP_FIND_EJECUTIVO`(".$this->ID.", 5, 1)";
		try{
			$sql = $this->RBD->query($query);

			if(!$this->RBD->error()){
				$row = mysqli_fetch_assoc($sql);
				$this->NOMBRE_EJECUTIVOCUENTA = $row["nombreCompletoEjecutivo"];
				$this->ID_EJECUTIVOCUENTA = $row["idEjecutivo"];
			}
			else{
				$this->NOMBRE_EJECUTIVOCUENTA = "No tiene";
				$this->ID_EJECUTIVOCUENTA = 0;
			}
		}catch(PDOException $e){
			echo "Error".$e->getMessage();
		}
	}

	function setNombreEjecutivoVentas(){
		$query = "CALL `redefectiva`.`SP_FIND_EJECUTIVO`(".$this->ID.", 2, 1)";
		try{
			$sql = $this->RBD->query($query);

			if(!$this->RBD->error()){
				$row = mysqli_fetch_assoc($sql);
				$this->NOMBRE_EJECUTIVOVENTA = $row["nombreCompletoEjecutivo"];
				$this->ID_EJECUTIVOVENTA = $row["idEjecutivo"];
			}
			else{
				$this->NOMBRE_EJECUTIVOVENTA = "No tiene";
				$this->ID_EJECUTIVOVENTA = 0;
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

	function getNombreEjecutivoVentas(){
		if(!empty($this->NOMBRE_EJECUTIVOVENTA)){
			return $this->NOMBRE_EJECUTIVOVENTA;
		}
		else{
			return "No cuenta con Ejecutivo de Venta";
		}
	}

	function getVersiones(){
		$versiones = "";
		if(!empty($this->VERSIONES)){
			$versiones = $this->VERSIONES;
		}
		return $versiones;
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
	
	function getNext2(){
		if ( isset($this->DIRNEXT) )
			return $this->DIRNEXT;
		else
	    	return "No tiene";
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
	
	function getNint2(){
		if ( isset($this->DIRNINT) )
			return $this->DIRNINT;
		else
	    	return "No tiene";
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

    public function getConfPermisos($categoria){
		$sql = $this->RBD->query("CALL `redefectiva`.`SP_FIND_CATEGORIA_PERMISOS`(".$this->ID.", -1, -1)");

		if(!$this->RBD->error()){

			$res = mysqli_fetch_assoc($sql);
			
			/* si la categoria es 0 quiere decir que no encontró nada para subcadena ni cadena, entonces los permisos deben estar en el grupo */
			if($categoria == 0){
				return $categoria;
			}else{
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
	
	public function getSubCadenas() {
		$res = $this->RBD->SP("CALL `redefectiva`.`SP_COUNT_CORRESPONSALES`($this->ID);");
		if ( !$this->RBD->error() ) {
			$this->SUBCADENAS = array();
			if ( mysqli_num_rows($res) > 0 ) {
				while ( $subcadena = mysqli_fetch_row($res) ) {
					$this->SUBCADENAS[] = $subcadena;
				}
				return $this->SUBCADENAS;
			}
		} else {
			return "Error : ".$this->RBD->error();
		}
	}

	function GuardarDireccion( $idEmpleado ){
		$sql = "CALL `redefectiva`.`SP_UPDATE_DIRECCIONCADENA`('$this->ID', '$this->DIRCALLE', '$this->DIRNINT', '$this->DIRNEXT', $this->DIRPAIS, $this->DIRESTADO, $this->DIRCIUDAD, $this->DIRCOLONIA, $this->DIRCP, $this->TIPODIRECCION, $idEmpleado);";
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

	function getNumCuenta(){
		if(!empty($this->NUM_CUENTA)){
			return $this->NUM_CUENTA;
		}
		else{
			return 0;
		}
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
    
}
?>