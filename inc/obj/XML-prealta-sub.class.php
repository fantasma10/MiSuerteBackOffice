<?php  
########################################################################################
#
#	Objeto que contiene toda la informacion relacionada a la prealta de corresponsales
#
class XMLP 
{
	#Base
	public $RBD,$WBD;
	
	public $ID;					#Id del Operador
	
	public $ID_USUARIO;			#Id del Usuario
	public $ID_CORRESPONSAL;	#Id de corresponsal
	public $ID_CADENA;			#Id de cadena
	public $ID_SUBCADENA;		#Id  de subcadena
	
	#Pre-Alta
	public $TIPO;				#Tipo de Corresponsal  (Unipunto, Subcadena o Franquicia)
	public $VERSION;			#Version   (Full, Light, Ultra Light o Unica)
	
	#Datos del Establecimineto
	public $NOMBRE;				#Nombre del Establecimiento
	public $TEL1;				#Telefono del Establecimiento
	public $TEL2;				#Telefono del Establecimiento
	public $CORREO;				#Correo del Establecimiento
	public $FAX;				#Fax del Establecimiento
	public $CALLE;				#Calle del Establecimiento
	public $NUMI;				#Numero Interior del Establecimiento
	public $NUME;				#Numero Exterior del Establecimiento
	public $CP;					#Codigo Postal del Establecimiento
	public $EDO;				#Estado del Establecimiento
	public $CD;					#Ciudad del Establecimiento
	public $COL;				#Colonia del Establecimiento

	#Datos Fiscales
	public $NOM_COM;			#Nombre Comercial
	public $RFC;				#RFC del Establecimiento
	public $REGIMEN;			#Regimen       ( 0 Fisica 1 Moral 2 REPECO )
	public $IVA;				#IVA
	
	#Horarios de Atencion
	public $DeD;				#Horas Inicio Domingo
	public $AD;					#Horas Fin Domingo
	
	public $DeLV;				#Horas Inicio Lunes a Viernes
	public $ALV;				#Horas Fin Lunes a Viernes
	
	public $DeS;				#Horas Inicio Sabado
	public $AS;					#Horas Fin Sabado
	
	#CONTACTOS
	public $CONTACTOS = array();			#XML-Contactos

	#VarXML
	private $XMLstring;
	private $readXML;
	
	public function __construct($RBD,$WBD) 
	{
		#$this->LOG					=	$LOG;
		$this->RBD					=	$RBD;
		#$this->LOG2				=	$LOG2;
		$this->WBD					=	$WBD;
		
		$this->ID					=	0;	
		
		$this->ID_USUARIO			=	0;				
		$this->ID_CORRESPONSAL		=	0;				
		$this->ID_CADENA			=	0;				
		$this->ID_SUBCADENA			=	0;				
		
		#Pre-Alta
		$this->TIPO					=	"";				
		$this->VERSION				=	"";
				
		#Datos del Establecimineto				
		$this->NOMBRE				=	"";				
		$this->TEL1					=	"";	
		$this->TEL2					=	"";				
		$this->CORREO				=	"";
		$this->FAX					=	"";	
		$this->CALLE				=	"";				
		$this->NUMI					=	"";				
		$this->NUME					=	"";				
		$this->CP					=	"";
		$this->EDO					=	"";				
		$this->CD					=	"";
		$this->COL					=	"";
		
		#Datos Fiscales	
		$this->NOM_COM				=	"";	
		$this->RFC					=	"";				
		$this->REGIMEN				=	"";				
		$this->IVA					=	"";				
		
		#Horarios de Atencion
		$this->DeD					=	"";				
		$this->AD					=	"";				
		
		$this->DeLV					=	"";
		$this->ALV					=	"";
		
		$this->DeS					=	"";
		$this->AS					=	"";
		
		#CONTACTOS		
		$this->CONTACTOS			=	array();
		
		#Var XML
		$this->XMLstring			=	"";
		$this->readXML			=	"";
	}
	
	public function setParametros($id,$idU,$idCor,$idCad,$idSub,$tipo,$ver,$nom,$tel1,$tel2,$mail,$fax,$calle,$numI,$numE,$cp,$edo,$cd,$col, $nomcom, $RFC, $regimen, $iva, $DeD, $AD, $DeLV, $ALV, $DeS, $AS, $Contactos){
		$this->ID					=	$id;	
		
		$this->ID_USUARIO			=	$idU;
		$this->ID_CORRESPONSAL		=	$idCor;
		$this->ID_CADENA			=	$idCad;
		$this->ID_SUBCADENA			=	$idSub;
		
		#Pre-Alta
		$this->TIPO					=	$tipo;
		$this->VERSION				=	$ver;
				
		#Datos del Establecimineto				
		$this->NOMBRE				=	$nom;
		$this->TEL1					=	$tel1;
		$this->TEL2					=	$tel2;
		$this->CORREO				=	$mail;
		$this->FAX					=	$fax;
		$this->CALLE				=	$calle;
		$this->NUMI					=	$numI;
		$this->NUME					=	$numE;				
		$this->CP					=	$cp;
		$this->EDO					=	$edo;				
		$this->CD					=	$cd;
		$this->COL					=	$col;
		
		#Datos Fiscales	
		$this->NOM_COM				=	$nomcom;	
		$this->RFC					=	$RFC;				
		$this->REGIMEN				=	$regimen;				
		$this->IVA					=	$iva;				
		
		#Horarios de Atencion
		$this->DeD					=	$DeD;				
		$this->AD					=	$AD;				
		
		$this->DeLV					=	$DeLV;
		$this->ALV					=	$ALV;
		
		$this->DeS					=	$DeS;
		$this->AS					=	$AS;
		
		#CONTACTOS		
		$this->CONTACTOS			=	$Contactos;
		
		#Var XML
		$this->XMLstring			=	"";	
		$this->readXML				=	"";	
	}
	
	
	public function	CrearXML(){
		$this->XMLstring = "<T>".$this->TIPO."</T>";
		$this->XMLstring .= "<V>".$this->VERSION."</V>";

        $this->XMLstring .= "<DE>";
            $this->XMLstring .= "<Nom>".$this->NOMBRE."</Nom>";
            $this->XMLstring .= "<Tel1>".$this->TEL1."</Tel1>";
            $this->XMLstring .= "<Tel2>".$this->TEL2."</Tel2>";
            $this->XMLstring .= "<MailE>".$this->CORREO."</MailE>";
            $this->XMLstring .= "<Fax>".$this->FAX."</Fax>";
            $this->XMLstring .= "<Calle>".$this->CALLE."</Calle>";
            $this->XMLstring .= "<NumI>".$this->NUMI."</NumI>";
            $this->XMLstring .= "<NumE>".$this->NUME."</NumE>";
            $this->XMLstring .= "<CP>".$this->CP."</CP>";
            $this->XMLstring .= "<Edo>".$this->EDO."</Edo>";
            $this->XMLstring .= "<Cd>".$this->CD."</Cd>";
            $this->XMLstring .= "<Col>".$this->COL."</Col>";
        $this->XMLstring .= "</DE>";

        $this->XMLstring .= "<DF>";
            $this->XMLstring .= "<NomCom>".$this->NOM_COM."</NomCom>";
            $this->XMLstring .= "<RFC>".$this->RFC."</RFC>";
            $this->XMLstring .= "<R>".$this->REGIMEN."</R>";
            $this->XMLstring .= "<IVA>".$this->IVA."</IVA>";
        $this->XMLstring .= "</DF>";

        $this->XMLstring .= "<H>";
            $this->XMLstring .= "<D>";
                $this->XMLstring .= "<De>".$this->DeD."</De>";
                $this->XMLstring .= "<A>".$this->AD."</A>";
            $this->XMLstring .= "</D>";
            $this->XMLstring .= "<LV>";
                $this->XMLstring .= "<De>".$this->DeLV."</De>";
                $this->XMLstring .= "<A>".$this->ALV."</A>";
            $this->XMLstring .= "</LV>";
            $this->XMLstring .= "<S>";
                $this->XMLstring .= "<De>".$this->DeS."</De>";
                $this->XMLstring .= "<A>".$this->AS."</A>";
            $this->XMLstring .= "</S>";
        $this->XMLstring .= "</H>";
		
		$this->XMLstring .= getArreglosContactos();
		
		return $this->XMLstring;		
		//mandar llamar al metdod de los contactos y concatenarlo a XMLstring
	}
	
	function cargarContactos() 
    { 
        array_push($this->CONTACTOS , $this->nuevoContacto); 
    } 

    function getArregloContactos() 
    { 
        return $this->CONTACTOS; 
    } 
    function setNuevoContacto(CONTACTS $CONTACTOS) 
    { 
        $this->nuevoContacto="<CA>".$CONTACTOS."</CA>"; 
    }
	
	function loadXMLCadenabyId($idPreClave) 
    { 
        $SQL = "SELECT XML FROM redefectiva.dat_precadena WHERE (idPreClave = ".$idPreClave.");";
		
		$Result = $this->RBD->query($SQL);
		if($Result){
			if(mysqli_num_rows($Result))
			{
				$XMLarray 		=  mysqli_fetch_array($Result);
				$this->XMLstring	= $XMLarray[0];
			}else{
				$this->XMLstring	= "";
			}
			
		}else{
			$this->XMLstring	= "";
		}
    }
	function loadXMLSubcadenabyId($idPreClave) 
    { 
        $SQL = "SELECT XML FROM redefectiva.dat_presubcadena WHERE (idPreClave = ".$idPreClave.");";
		
		$Result = $this->RBD->query($SQL);
		if($Result){
			if(mysqli_num_rows($Result))
			{
				$XMLarray 		=  mysqli_fetch_array($Result);
				$this->XMLstring	= $XMLarray[0];			
			}else{
				$this->XMLstring	= "";
			}
			
		}else{
			$this->XMLstring	= "";
		}
    }
	function loadXMLCorrbyId($idPreClave) 
    { 
        $SQL = "SELECT XML FROM redefectiva.dat_precorresponsal WHERE (idPreClave = ".$idPreClave.");";
		
		$Result = $this->RBD->query($SQL);
		if($Result){
			if(mysqli_num_rows($Result))
			{
				$XMLarray 		=  mysqli_fetch_array($Result);
				$this->XMLstring	= $XMLarray[0];
				return $this->XMLstring;
				return self::respuesta(0,"Mensaje cargado con exito"); 
			}else{
				$this->XMLstring	= "";
				return self::respuesta(1,"no se encontro la PreClave"); 
			}
		}else{
			$this->XMLstring	= "";
			return self::respuesta(1,"no se encontro la PreClave"); 
		}
    }
	
	/*codigo de  colores
		0 verde
		1 amarillo
		2 rojo
		
		en el form de los semaforos solo se pone un switch
		
	*/
	function readXMLDatGralCadena(){
		if($this->XMLstring	!= ""){
			
			$XMLGral 		= 	simplexml_load_string($this->XMLstring);
			
			$DatGrales 	= 	isset($XMLGral->DG)?$XMLGral->DG:("");
			//echo var_dump($XMLGral);
			if($DatGrales != ""){
				$Nom 			= 	isset($DatGrales->Nom)?$DatGrales->Nom:("");
				$Tel1 			= 	isset($DatGrales->Tel1)?$DatGrales->Tel1:("");
				$Tel2 			= 	isset($DatGrales->Tel2)?$DatGrales->Tel2:("");
				$MailE 			= 	isset($DatGrales->MailE)?$DatGrales->MailE:("");
				$Fax 			= 	isset($DatGrales->Fax)?$DatGrales->Fax:("");
				$Giro 			= 	isset($DatGrales->Giro)?$DatGrales->Giro:("");
				$Grupo 			= 	isset($DatGrales->Grupo)?$DatGrales->Grupo:("");
				$Referencia 	= 	isset($DatGrales->Referencia)?$DatGrales->Referencia:("");
				
				if($Nom != "" &&
					$Tel1 != "" &&
					$MailE != "" &&
					$Giro != "" &&
					$Grupo != "" &&
					$Referencia != "")
					return 0;
				
				if($Nom == "" &&
					$Tel1 == "" &&
					$MailE == "" &&
					$Giro == "" &&
					$Grupo == "" &&
					$Referencia == "")
					return 2;
				else
					return 1;
			}else{
				return 2;
			}
		}else{
			return 2;
		}
	}
	
	function readXMLDirCadena(){
		if($this->XMLstring	!= ""){
			
			$XMLGral 		= 	simplexml_load_string($this->XMLstring);
			
			$Dir 	= 	isset($XMLGral->Direccion)?$XMLGral->Direccion:("");
			//echo var_dump($Dir);
			if($Dir != ""){
				$Atri 			= 	isset($Dir->attributes)?$Dir->attributes:("");
				$Tipo 			= 	isset($Atri->tipos)?$Atri->tipo:("");

				if($Tipo != "")
					return 0;
				
				if($Tipo == "")
					return 2;
				else
					return 1;
				
			}else{
				return 2;
			}
		}else{
			return 2;
		}
	}
	function readXMLEjecuCadena(){
		if($this->XMLstring	!= ""){
			
			$XMLGral 		= 	simplexml_load_string($this->XMLstring);
			
			$ECuenta	 	= 	isset($XMLGral->ECuenta)?$XMLGral->ECuenta:("");
			$EVenta		 	= 	isset($XMLGral->EVenta)?$XMLGral->EVenta:("");
			//echo var_dump($XMLGral);
			if($ECuenta != "" && $EVenta != ""){
				return 0;
				
			}elseif($ECuenta == "" && $EVenta == ""){
				return 2;
			}else{
				return 1;
			}
			
		}else{
			return 2;
		}
	}
	
	function readXMLContacCadena(){
		if($this->XMLstring	!= ""){
			
			$XMLGral 		= 	simplexml_load_string($this->XMLstring);
			
			$Contactos	 	= 	isset($XMLGral->Contactos)?$XMLGral->Contactos:("");
			//aki va un foreach para sacar cada contacto si existe almenos uno es verde si no existe ninguno es rojo
			echo var_dump($Contactos);
			//echo var_dump($XMLGral);
			
		}else{
			return 2;
		}
	}
	
}


class CONTACTS 
{ 
    private  $NOMC;
	private  $APEPC;
	private  $APEMC;
	private  $TELC;
	private  $CELC;
	private  $MAILC;
     
    public function setCONTAC($N, $AP, $AM, $T, $C, $M) 
    { 
        $this->NOMC="<NomA>".$N."</NomA>";
		$this->APEPC="<ApePA>".$AP."</ApePA>";
		$this->APEMC="<ApeMA>".$AM."</ApeMA>";
		$this->TELC="<TelA>".$T."</TelA>";
		$this->CELC="<CelA>".$C."</CelA>";
		$this->MAILC="<MailA>".$M."</MailA>";
    } 
    public function getCONTAC() 
    {
		return $this->a;
	}
	
	public function getNomC() 
    {return $this->NOMC;}
	 
	public function getApePC() 
    {return $this->APEPC;}
	
	public function getApeMC() 
    {return $this->APEMC;}
	
	public function getTelC() 
    {return $this->TELC;}
	
	public function getCelC() 
    {return $this->CELC;}
	
	public function getMailC() 
    {return $this->MAILC;}
} 


?>