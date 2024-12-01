<?php
class XMLPreSubCad{
    private $RBD,$WBD;
    //Variables del Sistema Local
    
    private $ID;
    
    private $NOMBRE;
    
    private $PORCENTAJE;
    
    private $REVISADO;
    
    private $EXISTE;
    
    private $ERROR;
    
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
	
    //Version
    private $VERSION;	
	
    //Var XML
    
    
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
	
    //Contrato
    private $CONTRATO;
    private $CRRFC;
    private $CRSOCIAL;
    private $CFCONSTITUCION;
    private $CREGIMEN;
    
    private $CDIRECCION;
    
    private $CCALLE;
    private $CNEXT;
    private $CNINT;
    private $CCOLONIA;
    private $CCIUDAD;
    private $CESTADO;
    private $CCP;
    private $CPAIS;
    private $CTIPODIRECCION;
    
    private $CREPLEGAL;
    private $CNOMBRE;
    private $CPATERNO;
    private $CMATERNO;
    private $CNUMIDEN;
    private $CTIPOIDEN;
    private $CRFC;
    private $CCURP;
    private $CFIGURA;
    private $CFAMILIA;
    private $REVISADOCONTRATO;
    private $PREREVISADOCONTRATO;
    
    //Cuenta
    private $CUENTA;
    private $BANCO;
    private $CLABE;
    private $BENEFICIARIO;
    private $NUMCUENTA;
    private $DESCRIPCION;
    private $REVISADOCUENTA;
	private $PREREVISADOCUENTA;
    
    //Forelo
    private $FORELO;
    private $FCANTIDAD;
    private $FDESCRIPCION;
    private $FREFERENCIA;
    private $REVISADOFORELO;
	private $PREREVISADOFORELO;
    
    //Documentacion
    private $DDOMICILIO;
    private $DFISCAL;
    private $DBANCO;
    private $DREPLEGAL;
    private $DRSOCIAL;
    private $DACONSTITUTIVA;
    private $DPODERES;
	private $REVISADODOCUMENTACION;
	private $PREREVISADODOCUMENTACION;

	//Cargos
	private $REVISADOCARGOS;
	private $PREREVISADOCARGOS;   
    
	private $REFBANCARIA;
	
    function __construct($r,$w){
        $this->RBD = $r;
        $this->WBD = $w;
        $this->PORCENTAJE = 0;
        $this->REVISADO = true;
        $this->EXISTE = false;
        $this->NOMBRE = "";
        $this->CADENA = "";
        $this->ERROR = "";
        $this->GIRO = "";
        $this->GRUPO = "";
        $this->REFERENCIA = "";
        $this->TEL1 = "";
        $this->TEL2 = "";
        $this->FAX = "";
        $this->CORREO = "";
        $this->REVISADOGENERALES = false;
		$this->PREVISADOGENERALES = false;
        $this->DIRECCION = "";
        $this->REVISADODIRECCION = false;
		$this->PREVISADODIRECCION = false;
        $this->ECUENTA = "";
        $this->REVISADOECUENTA = false;
		$this->PREVISADOECUENTA = false;
        $this->EVENTA = "";
        $this->REVISADOEVENTA = false;
		$this->PREVISADOEVENTA = false;
        $this->CONTACTO = "";
        $this->REVISADOCONTACTOS = false;
		$this->PREVISADOCONTACTOS = false;
        $this->CALLE = "";
        $this->NEXT = "";
        $this->NINT = "";
        $this->COLONIA = "";
        $this->CIUDAD = "";
        $this->ESTADO = "";
        $this->CP = "";
        $this->PAIS = "";
        $this->TIPODIRECCION = "";
        $this->CUENTA = "";
        $this->BANCO = "";
        $this->CLABE = "";
        $this->BENEFICIARIO = "";
        $this->NUMCUENTA = "";
        $this->DESCRIPCION = "";
        $this->DDOMICILIO = "";
        $this->DFISCAL = "";
        $this->DBANCO = "";
        $this->DREPLEGAL = "";
        $this->DRSOCIAL = "";
        $this->DACONSTITUTIVA = "";
        $this->DPODERES = "";
        $this->CONTRATO = "";
        $this->CRRFC  = "" ;
        $this->CRSOCIAL = "";
        $this->CFCONSTITUCION = "";
        $this->CREGIMEN = "";
        $this->CDIRECCION = "";
        $this->CCALLE = "";
        $this->CNEXT = "";
        $this->CNINT = "";
        $this->CCOLONIA = "";
        $this->CCIUDAD = "";
        $this->CESTADO = "";
        $this->CCP = "";
        $this->CPAIS = "";
        $this->CTIPODIRECCION = "";
        $this->CREPLEGAL = "";
        $this->CNOMBRE = "";
        $this->CPATERNO = "";
        $this->CMATERNO = "";
        $this->CNUMIDEN = "";
        $this->CTIPOIDEN = "";
        $this->CRFC = "";
        $this->CCURP = "";
        $this->CFIGURA = "";
        $this->CFAMILIA = "";
        $this->REVISADOCONTRATO = false;
		$this->PREVISADOCONTRATO = false;
		$this->REVISADOCUENTA = false;
		$this->PREVISADOCUENTA = false;
        $this->FORELO = "";
		$this->FCANTIDAD = "";
		$this->FDESCRIPCION = "";
		$this->FREFERENCIA = "";
		$this->REVISADOFORELO = false;
		$this->PREVISADOFORELO = false;
		$this->VERSION = "";
		$this->REVISADODOCUMENTACION = false;
		$this->PREVISADODOCUMENTACION = false;
		$this->REVISADOCARGOS = false;
		$this->PREREVISADOCARGOS = false;
		$this->REFBANCARIA = "";
    }
    
    
    function load($id){
        $this->ID = $id;
		$sql = "CALL `prealta`.`SP_LOAD_PRESUBCADENA`($id);";
        $res = $this->RBD->SP($sql);
        if($this->RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
				$r = mysqli_fetch_array($res);
				$xml = simplexml_load_string(utf8_encode($r[0]));
				/*$r = mysqli_fetch_array($res);

                $reg = base64_decode($r[0]);
                $xml = simplexml_load_string(utf8_encode($reg));*/
               // $r = mysqli_fetch_array($res);
                $this->EXISTE = true;
                //$xml = simplexml_load_string($r[0]);
				/*echo "<pre>";
				print_r($r[0]);
				echo "</pre>";*/
				$this->NOMBRE = $xml->DG[0]->Nom;
                $this->CADENA = $xml->Cadena;
                $this->GIRO = $xml->DG[0]->Giro;
                $this->GRUPO = $xml->DG[0]->Grupo;
                $this->REFERENCIA = $xml->DG[0]->Referencia;
                $this->TEL1 = $xml->DG[0]->Tel1;
                $this->TEL2 = $xml->DG[0]->Tel2;
                $this->FAX = $xml->DG[0]->Fax;
                $this->CORREO = $xml->DG[0]->MailE;
                $this->REVISADOGENERALES = ($xml->DG->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOGENERALES = ($xml->DG->attributes()->prerevisado == "true") ? true : false;
                $this->DIRECCION = $xml->Direccion;
                $this->REVISADODIRECCION = ($xml->Direccion->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADODIRECCION = ($xml->Direccion->attributes()->prerevisado == "true") ? true : false;
                $this->ECUENTA = $xml->ECuenta;
                $this->REVISADOECUENTA = ($xml->ECuenta->attributes()->revisado == "true") ? true : false;
                $this->FCANTIDAD = $xml->Forelo[0]->Cantidad;
				$this->FDESCRIPCION = $xml->Forelo[0]->Descripcion;
				$this->FREFERENCIA = $xml->Forelo[0]->Referencia;
				$this->REVISADOFORELO = ($xml->Forelo->attributes()->revisado == "true") ? true : false;
				
				$this->VERSION= $xml->version;
                $this->REVISADOVERSION = ($xml->version->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOVERSION = ($xml->version->attributes()->prerevisado == "true") ? true : false;
				$this->EVENTA = $xml->EVenta;
                $this->REVISADOEVENTA = ($xml->EVenta->attributes()->revisado == "true") ? true : false;
                $this->CUENTA = $xml->CuentaBanco;
                $this->REVISADOCUENTA = ($xml->CuentaBanco->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOCUENTA = ($xml->CuentaBanco->attributes()->prerevisado == "true") ? true : false;
                $this->DDOMICILIO = $xml->Documentos[0]->CDomicilio;
                $this->DFISCAL = $xml->Documentos[0]->CFiscal;
                $this->DBANCO = $xml->Documentos[0]->CBanco;
                $this->DREPLEGAL = $xml->Documentos[0]->CRepLegal;
                $this->DRSOCIAL = $xml->Documentos[0]->CRSocial;
                $this->DACONSTITUTIVA = $xml->Documentos[0]->CAConstitutiva;
                $this->DPODERES = $xml->Documentos[0]->CPoderes;
                $this->CONTRATO = $xml->Contrato[0]->Id;
				$this->REVISADOCONTRATO= ($xml->Contrato->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOCONTRATO= ($xml->Contrato->attributes()->prerevisado == "true") ? true : false;
                $this->CDIRECCION = $xml->Contrato[0]->Dir;
				$this->CREPLEGAL = $xml->Contrato[0]->RepLegal;
                $this->REVISADOCONTACTOS = ($xml->Contactos->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOCONTACTOS = ($xml->Contactos->attributes()->prerevisado == "true") ? true : false;
				$this->REVISADOCARGOS = ($xml->Cargos->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADOCARGOS = ($xml->Cargos->attributes()->prerevisado == "true") ? true : false;
				$this->REVISADODOCUMENTACION = ($xml->Documentos->attributes()->revisado == "true") ? true : false;
				$this->PREREVISADODOCUMENTACION = ($xml->Documentos->attributes()->prerevisado == "true") ? true : false;            
				$this->REFBANCARIA = $xml->RefBancaria;
				
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
                    list($c,$ni,$ne,$p,$e,$m,$col,$cp,$td) = mysqli_fetch_array($res);
                    $this->CALLE = $c;
                    $this->NINT = $ni;
                    $this->NEXT = $ne;
                    $this->PAIS = $p;
                    $this->ESTADO = $e;
                    $this->CIUDAD = $m;
                    $this->COLONIA = $col;
                    $this->CP = $cp;
                    $this->TIPODIRECCION = $td;
                }
                
				$sql = "CALL `prealta`.`SP_GET_PREDIRECCION`($this->CDIRECCION);";
                $res = $this->RBD->SP($sql);
                if($res != '' && mysqli_num_rows($res) > 0){
                    list($c,$ni,$ne,$p,$e,$m,$col,$cp,$td) = mysqli_fetch_array($res);
                    $this->CCALLE = $c;
                    $this->CNINT = $ni;
                    $this->CNEXT = $ne;
                    $this->CPAIS = $p;
                    $this->CESTADO = $e;
                    $this->CCIUDAD = $m;
                    $this->CCOLONIA = $col;
                    $this->CCP = $cp;
		    		$this->CTIPODIRECCION = $td;
                }
                
				$sql = "CALL `prealta`.`SP_GET_PRECUENTA`($this->CUENTA);";		
                $res = $this->RBD->SP($sql);
                if($res != '' && mysqli_num_rows($res) > 0){
                    list($b,$nc,$c,$ben,$d) = mysqli_fetch_array($res);
                    $this->BANCO = $b;
                    $this->NUMCUENTA = $nc;
                    $this->CLABE = $c;
                    $this->BENEFICIARIO = $ben;
                    $this->DESCRIPCION = $d;
                }
                
				$sql = "CALL `prealta`.`SP_GET_PREREPRESENTANTELEGAL`($this->CREPLEGAL);";	
				$res = $this->RBD->SP($sql);
                if($res != '' && mysqli_num_rows($res) > 0){
                    list($tipoRL,$nomRL,$apPRL,$apMRL,$numIdent,$RFCRL,$CURPRL,$figP,$famP) = mysqli_fetch_array($res);
                    $this->CNOMBRE = $nomRL;
					$this->CPATERNO = $apPRL;
					$this->CMATERNO = $apMRL;
					$this->CNUMIDEN = $numIdent;
					$this->CTIPOIDEN = $tipoRL;
					$this->CRRFC = $RFCRL;
					$this->CCURP = $CURPRL;
					$this->CFIGURA = $figP;
					$this->CFAMILIA = $famP;
                }
		
				$sql = "CALL `prealta`.`SP_GET_PRECONTRATO`($this->CONTRATO);";
                $res = $this->RBD->SP($sql);
                if($res != '' && mysqli_num_rows($res) > 0){
                    list($tipoPer,$razonS,$fecAlta,$RFCContra) = mysqli_fetch_array($res);
                    $this->CRFC  = $RFCContra;
					$this->CRSOCIAL = $razonS;
					$this->CFCONSTITUCION = $fecAlta;
					$this->CREGIMEN = $tipoPer;
                }
                
            }
        }
    }
    
   
    
    function CrearXML(){
        $xml = '<SubCadena>
               <Cadena></Cadena>
			   <version></version>
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
               <Contactos revisado="false" prerevisado="false"></Contactos>
               <ECuenta revisado="false" prerevisado="false"></ECuenta>
               <EVenta revisado="false" prerevisado="false"></EVenta>
               <Direccion tipo="2" revisado="false" prerevisado="false"></Direccion>
               <Contrato revisado="false" prerevisado="false">
                    <Id></Id>
                    <Dir></Dir>
                    <RepLegal></RepLegal>
               </Contrato>
               <CuentaBanco revisado="false" prerevisado="false"></CuentaBanco>
               <Forelo revisado="false" prerevisado="false">
		    <Cantidad></Cantidad>
		    <Descripcion></Descripcion>
		    <Referencia></Referencia>
		</Forelo>
               <Documentos revisado="false" prerevisado="false">
                    <CDomicilio></CDomicilio>
                    <CFiscal></CFiscal>
                    <CBanco></CBanco>
                    <CRepLegal></CRepLegal>
                    <CRSocial></CRSocial>
                    <CAConstitutiva></CAConstitutiva>
                    <CPoderes></CPoderes>
                </Documentos>
				<RefBancaria></RefBancaria>
           </SubCadena>';

		$sql = "CALL `prealta`.`SP_INSERT_XMLPRESUBCADENA`('$this->NOMBRE', '$xml');";
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
        $NOMBRE = ($this->ID > 0)? utf8_decode($this->NOMBRE) : $this->NOMBRE;
        $aux = '
        <DG revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">
            <Nom>'.utf8_decode($this->NOMBRE).'</Nom>
            <Tel1>'.$this->TEL1.'</Tel1>
            <Tel2>'.$this->TEL2.'</Tel2>
            <MailE>'.$this->CORREO.'</MailE>
            <Fax>'.$this->FAX.'</Fax>
            <Giro>'.$this->GIRO.'</Giro>
            <Grupo>'.$this->GRUPO.'</Grupo>
            <Referencia>'.$this->REFERENCIA.'</Referencia>
        </DG>';
        return $aux;
    }
    
    private function getDireccionXML(){
        $revisado = $this->REVISADODIRECCION ?  "true" : "false";
		$prerevisado = $this->PREREVISADODIRECCION ?  "true" : "false";
        $aux = '<Direccion tipo="2" revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">'.$this->DIRECCION.'</Direccion>';
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
    
    private function getContratoXML(){
        $revisado = $this->REVISADOCONTRATO ?  "true" : "false";
		$prerevisado = $this->PREREVISADOCONTRATO ?  "true" : "false";
        $aux = '<Contrato revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">
                    <Id>'.$this->CONTRATO.'</Id>
                    <Dir>'.$this->CDIRECCION.'</Dir>
                    <RepLegal>'.$this->CREPLEGAL.'</RepLegal>
               </Contrato>';
        return $aux;
    }
    
    private function getDocumentacionXML(){
        $revisado = $this->REVISADODOCUMENTACION ?  "true" : "false";
		$prerevisado = $this->PREREVISADODOCUMENTACION ?  "true" : "false";	
        $aux = '<Documentos revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">
                    <CDomicilio>'.$this->DDOMICILIO.'</CDomicilio>
                    <CFiscal>'.$this->DFISCAL.'</CFiscal>
                    <CBanco>'.$this->DBANCO.'</CBanco>
                    <CRepLegal>'.$this->DREPLEGAL.'</CRepLegal>
                    <CRSocial>'.$this->DRSOCIAL.'</CRSocial>
                    <CAConstitutiva>'.$this->DACONSTITUTIVA.'</CAConstitutiva>
                    <CPoderes>'.$this->DPODERES.'</CPoderes>
                </Documentos>';
        return $aux;
    }
    
    private function getCuentaBancoXML(){
        $revisado = $this->REVISADOCUENTA ?  "true" : "false";
		$prerevisado = $this->PREREVISADOCUENTA ?  "true" : "false";
        $aux = '<CuentaBanco revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">'.$this->CUENTA.'</CuentaBanco>';
        return $aux;
    }
    
    private function getForeloXML(){
		$revisado = $this->REVISADOFORELO ?  "true" : "false";
		$prerevisado = $this->PREREVISADOFORELO ?  "true" : "false";
		$aux = '<Forelo revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">
		    <Cantidad>'.$this->FCANTIDAD.'</Cantidad>
		    <Descripcion>'.$this->FDESCRIPCION.'</Descripcion>
		    <Referencia>'.$this->FREFERENCIA.'</Referencia>
		</Forelo>';
		return $aux;
    }
    
	function getReferenciaBancariaXML(){
		$aux = '<RefBancaria>'.$this->REFBANCARIA.'</RefBancaria>';
		return $aux;
	}
	
    function GuardarXML(){
		$revisado = $this->REVISADOVERSION ?  "true" : "false";
		$prerevisado = $this->PREREVISADOVERSION ?  "true" : "false";        
		$xml = '
        <SubCadena>
            <Cadena>'.$this->CADENA.'</Cadena>
			<version revisado="'.$revisado.'" prerevisado="'.$prerevisado.'">'.$this->VERSION.'</version>';
			$xml .= $this->getCargosXML();           
		    $xml .= $this->getGeneralesXML();
            $xml .= $this->getContactosXML();
            $xml .= $this->getECuentaXML();
            $xml .= $this->getEVentaXML();
            $xml .= $this->getDireccionXML();
            $xml .= $this->getContratoXML();
            $xml .= $this->getCuentaBancoXML();
            $xml .= $this->getForeloXML();
            $xml .= $this->getDocumentacionXML();
			$xml .= $this->getReferenciaBancariaXML();
        $xml.='</SubCadena>';
        
		$sql = "CALL `prealta`.`SP_UPDATE_XMLPRESUBCADENA`('$xml', $this->ID);";
		$this->WBD->SP($sql);
		if($this->WBD->error() == ''){
			$this->CalcularPorcentaje();
			$this->Revisar();
			return true;
		}
		return false;
    }
    
	function AsociarPreSubCadenaConCadena() {
		$sql = "CALL `prealta`.`SP_UPDATE_PRESUBCADENA`($this->ID, NULL, $this->CADENA, NULL, NULL, {$_SESSION['idU']}, NULL, NULL);";
		$this->WBD->SP($sql);
		if ( $this->WBD->error() == '' ) {
			return true;
		} else {
			return false;
		}
	}
	
    function Autorizar(){
        $CODIGO = "";
        $CODIGO = $this->GenerarCodigo(8);
        $bandcodigo = true;
	   //Verificar si el codigo ya existe!
	
    	while($bandcodigo){
    		$sql = "CALL `prealta`.`SP_GET_CODIGOACCESO`('$CODIGO');";
    	    $res = $this->RBD->SP($sql);
    	    if ( $res != '' && mysqli_num_rows($res) > 0 ) {
    			$CODIGO = $this->GenerarCodigo(8);
    	    } else {
    			$bandcodigo = false;
    	    }
    	    
    	}
        
        //Crear la subcadena
        $sql = "CALL SPA_ALTASUBCADENA(".
                    " '$this->GRUPO', ".
                    " '$this->CADENA', ".
                    " '$this->GIRO', ". 
                    " '$this->NOMBRE', ".
                    " '$this->TEL1', ".
                    " '$this->TEL2', ".
                    " '$this->FAX', ".
                    " '$this->CORREO', ".
                    " '$CODIGO', ".
                    " '$this->REFERENCIA', ".
                    " '0',".
                    " '".$_SESSION['idU']."'".
            ")";
            
        $res = $this->WBD->SP($sql);
        
        if($res != '' && mysqli_num_rows($res) > 0){
            list($codRespuesta, $descRespuesta, $idSubCadena) = mysqli_fetch_array($res);
            if($codRespuesta == 0){
                //Asignar ejecutivos a la cadena
                if($this->ECUENTA != ''){
				 	$sql = "CALL `prealta`.`SP_INSERT_SUBCADENAEJECUTIVO`($idSubCadena, $this->ECUENTA, {$_SESSION['idU']});";
                    $this->WBD->SP($sql);
                    if($this->WBD->error() != ''){
                       $this->ERROR.= "Error al asignar el ejecutivo a la cadena";
                    }
                }
                if($this->EVENTA != ''){
                    $sql = "CALL `prealta`.`SP_INSERT_SUBCADENAEJECUTIVO`($idSubCadena, $this->EVENTA, {$_SESSION['idU']});";
					$this->WBD->SP($sql);
                    if($this->WBD->error() != ''){
                       $this->ERROR.= "Error al asignar el ejecutivo a la cadena";
                    }
                }
                
                
                //Agregar contactos
                for($i = 0; $i < count($this->CONTACTOS); $i++){
                    $c = $this->CONTACTOS[$i];
					$sql = "CALL `prealta`.`SP_INSERT_CONTACTO`({$c->getTipoContacto()}, '{$c->getNombre()}', '{$c->getPaterno()}', '{$c->getMaterno()}', '{$c->getTelefono()}', '{$c->getCorreo()}', {$_SESSION['idU']});";
                    $result = $this->WBD->SP($sql);
					if ( $result->num_rows > 0 ) {
                    	list( $ultimoID ) = $result->fetch_array();
						$idContacto = $ultimoID;
                    }
					if($this->WBD->error() != ''){
                        $this->ERROR.= "No se pudo agregar el contacto".$this->WBD->error();
                    }
                    //Asignar contacto a la cadena
					$sql = "CALL `prealta`.`SP_INSERT_SUBCADENACONTACTO`($idSubCadena, $idContacto, {$_SESSION['idU']});";
                    $this->WBD->SP($sql);
                    if($this->WBD->error() != ''){
                        $this->ERROR.= "No se pudo asignar el contacto a la cadena";
                    }
                    
                }
                
                //Agregar Direccion
		$idDireccion = "";
		$sql = "CALL `prealta`.`SP_INSERT_DIRECCION`('$this->CALLE', '$this->NINT', '$this->NEXT', $this->PAIS, $this->ESTADO, $this->CIUDAD, $this->COLONIA, $this->CP, $this->TIPODIRECCION, {$_SESSION['idU']});";
		$result = $this->WBD->SP($sql);
		if($this->WBD->error() != ''){
		    $this->ERROR.= "No se pudo guardar la direccion ".$sql;
		}else{
		    if ( $result->num_rows > 0 ) {
				list( $ultimoID ) = $result->fetch_array();
				$idDireccion = $ultimoID;
				//Asignar Direccion a la subcadena
				$sql = "CALL `prealta`.`SP_INSERT_SUBCADENADIRECCION`($idSubCadena, $idDireccion, {$_SESSION['idU']});";
				$this->WBD->SP($sql);
				if($this->WBD->error() != ''){
					$this->ERROR.= "No se pudo asignar la direccion a la subcadena";
				}
		    }
		}
                
                //Crear Direccion del Contrato
		if ( $this->DIRECCION !=  $this->CDIRECCION ) {
		    $idDireccion = NULL;
	    	$sql = "CALL `prealta`.`SP_INSERT_DIRECCION`('$this->CCALLE', '$this->CNINT', 'this->CNEXT', $this->CPAIS, $this->CESTADO, $this->CCIUDAD, $this->CCOLONIA, $this->CCP, $this->CTIPODIRECCION, {$_SESSION['idU']});";
			$result = $this->WBD->SP($sql);
			if ( $this->WBD->error() != '' ) {
				$this->ERROR.= "No se pudo guardar la direccion fiscal".$sql;
		    } else {
				if ( $result->num_rows > 0 ) {
					list( $ultimoID ) = $result->fetch_array();
					$idDireccion = $ultimoID;
					//Asignar Direccion al corresponsal
					$sql = "CALL `prealta`.`SP_INSERT_SUBCADENADIRECCION`($idSubCadena, $idDireccion, {$_SESSION['idU']});";
					$this->WBD->SP($sql);
					if ( $this->WBD->error() != '' ) {
						$this->ERROR.= "No se pudo asignar la direccion fiscal a la subcadena";
					}
				}
		    }
		}
		
		//Crear el representante legal
		$sql = "CALL `prealta`.`SP_FIND_REPRESENTANTELEGAL`($this->CTIPOIDEN, '$this->CNUMIDEN', '$this->CRFC');";	
		$res = $this->RBD->SP($sql);
		$idRepLegal = 0;		
		if($res != '' && mysqli_num_rows($res) > 0){
		    $r = mysqli_fetch_array($res);
		    $idRepLegal = $r[0];		
		} else {
			$sql = "CALL `prealta`.`SP_INSERT_REPRESENTANTELEGAL`($this->CTIPOIDEN, '$this->CNOMBRE', '$this->CPATERNO', '$this->CMATERNO', '$this->CNUMIDEN', '$this->CRFC', '$this->CCURP', $this->CFIGURA, $this->CFAMILIA, {$_SESSION['idU']});";
			$result = $this->WBD->SP($sql);
			if($this->WBD->error() != ''){
				$this->ERROR.= "No se pudo crear el representante legal ";
				if(mysqli_errno($this->WBD->LINK) == 1062)
					$this->ERROR.= " Llave duplicada para el representante legal ";
			}else{
				if ( $result->num_rows > 0 ) {
					list( $ultimoID ) = $result->fetch_array();
					$idRepLegal = $ultimoID;
				}
			}
		}
		
		//Crear el contrato
		
		$idEjec = $this->ECUENTA;
		if ( $idEjec >= 100 ) {
			$idEjec = $idEjec;
		} else {
			if ( $idEjec >= 10 ) {
				$idEjec = '0'.$idEjec;
			} else {
				$idEjec = '00'.$idEjec;
			}
		}				
		$fecha = substr(date("Ymd"),2,7);
		
		$sql ="CALL `prealta`.`SP_COUNT_CONTRATOSDEEJECUTIVO`($idEjec);";				
		
		$result = $this->RBD->SP($sql);
		$countC=0;
		list($countC) = mysqli_fetch_row($result);
		$countC=$countC+1;
		
		if ($countC>=100) {
			$countC=$countC;
		} else {
			if ($countC>=10) {
				$countC = '0'.$countC;
			} else {
				$countC = '00'.$countC;
			}
		}
		
		$n1=rand(0, 9);
		$n2=rand(0, 9);				
		
		$numeroContrato = $idEjec.$fecha.$countC.$n1.$n2; 

		$sql = "CALL `prealta`.`SP_INSERT_CONTRATO`('$numeroContrato', $this->EVENTA, $this->CREGIMEN, '$this->CRSOCIAL', '$this->CFCONSTITUCION', '$this->CRRFC', $idRepLegal, $idDireccion, {$_SESSION['idU']}, '$fecha');";

		$this->WBD->SP($sql);
		if($this->WBD->error() != ''){
		    $this->ERROR.= "No se pudo crear el contrato";
		    if(mysqli_errno($this->WBD->LINK) == 1062)
				$this->ERROR.= " Llave duplicada para el numero de contrato ";
			return false;
		}
                
                //Crear la Cuenta
		$IDENT = 1;
		if($this->CADENA == 0 && $this->SUBCADENA == 0)
		    $IDENT = 0;
		$sql = "CALL SPA_ALTACUENTA(".
			    " '$this->FDESCRIPCION', ".
			    " '$this->CADENA', ".
			    " '$idSubCadena', ". 
			    " '-1', ". 
			    " $this->REFERENCIA, ".
			    " '0', ". 
			    " '0', ". 
			    " '0', ". 
			    " '1', ".
			    " '$this->FCANTIDAD', ".
			    " '0', ".
			    " '1', ". 
			    " '1', ".
			    " ".$_SESSION['idU'].", ".
			    " $IDENT ".
			    ")";
		$this->WBD->SP($sql);
		//if($this->WBD->error() != ''){
		//    $this->ERROR.= "No se pudo crear la cuenta";
		//}
		
                //Asignar archivos a la subcadena
		
		//Comprobante de domicilio
		$sql = "CALL `prealta`.`SP_INSERT_SUBCADENAARCHIVO`($idSubCadena, $this->DDOMICILIO, {$_SESSION['idU']});";
		$this->WBD->SP($sql);
		if($this->WBD->error() != ''){
		    $this->ERROR.= "No se pudo asignar el comprobante de domicilio ";
			return false;
		}
		
		////Comprobante de domicilio fiscal
		//$sql = "INSERT INTO `redefectiva`.`inf_subcadenaarchivo`(`idSubCadena`,`idArchivo`,`idEstatusSubArchivo`,`fecAltaSubArchivo`,`fecVigenciaSubArchivo`,`idEmpleado`)
		// VALUES($idSubCadena,$this->DFISCAL,0,NOW(),NOW() + INTERVAL 1 YEAR,".$_SESSION['idU'].")";
		//
		//$this->WBD->query($sql);
		//
		//if($this->WBD->error() != ''){
		//    $this->ERROR.= "No se pudo asignar el comprobante de domicilio";
		//}
		
		//Caratula de banco
		$sql = "CALL `prealta`.`SP_INSERT_SUBCADENAARCHIVO`($idSubCadena, $this->DBANCO, {$_SESSION['idU']});";
		$this->WBD->SP($sql);
		if($this->WBD->error() != ''){
		    $this->ERROR.= "No se pudo asignar caratula de banco";
			return false;
		}
		
		//Identificacion de Representante legal
		$sql = "CALL `prealta`.`SP_INSERT_SUBCADENAARCHIVO`($idSubCadena, $this->DREPLEGAL, {$_SESSION['idU']});";
		$this->WBD->SP($sql);
		if($this->WBD->error() != ''){
		    $this->ERROR.= "No se pudo asignar identificacion del Representante Legal";
			return false;
		}
		
		//RFC Razon social
		$sql = "CALL `prealta`.`SP_INSERT_SUBCADENAARCHIVO`($idSubCadena, $this->DRSOCIAL, {$_SESSION['idU']});";
		$this->WBD->SP($sql);
		if($this->WBD->error() != ''){
		    $this->ERROR.= "No se pudo asignar comprobante de RFC/Razon Social";
			return false;
		}
		
		//Acta Constitutiva
		$sql = "CALL `prealta`.`SP_INSERT_SUBCADENAARCHIVO`($idSubCadena, $this->DACONSTITUTIVA, {$_SESSION['idU']});";
		$this->WBD->SP($sql);
		if($this->WBD->error() != ''){
		    $this->ERROR.= "No se pudo asignar acta constitutiva";
			return false;
		}
		
		//Poderes
		$sql = "CALL `prealta`.`SP_INSERT_SUBCADENAARCHIVO`($idSubCadena, $this->DPODERES, {$_SESSION['idU']});";
		$this->WBD->SP($sql);
		if($this->WBD->error() != ''){
		    $this->ERROR.= "No se pudo asignar comprobante de poderes";
			return false;
		}
                
		$sql = "CALL `prealta`.`SP_ENABLE_PRESUBCADENA`($this->ID);";
		$this->WBD->SP($sql);
                
                
                return true;
            }else{
                $this->ERROR = $descRespuesta.$sql;
                return false;
            }
        }else{
            $this->ERROR = "No se pudo crear la cadena";
            return false;
        }
    }
    
    
    function GenerarCodigo($length = 10){	
        if ($length <= 0)
        {
            return false;
        }
 
        $code = "";
        //$chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
        $chars = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < $length; $i++)
        {
                $code = $code . substr($chars, rand() % strlen($chars), 1);
        }
        return $code;
    }
    
    function AgregarContacto(){
        $bandcont = true;
        foreach($this->CONTACTOS as $Cont){
            if($Cont->getTipoContacto() == 6 && $this->CONTACTO->getTipoContacto() == 6){
                $bandcont = false;
                break;
            }
        }
        if($bandcont){
            if($this->CONTACTO->Guardar($this->ID)){
                $this->CONTACTOS[] = $this->CONTACTO;
                if($this->GuardarXML())
                    return true;
                return false;
            }
            $this->MSG = $this->CONTACTO->getMsg();
            return false;
        }
        $this->MSG = "sólo puede existir un Responsable";
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
    
	function ActualizarVersion() {
		$sql = "CALL `prealta`.`SP_UPDATE_VERSIONPRESUBCADENA`($this->ID, $this->VERSION);";
		$result = $this->WBD->SP($sql);
		if ( $this->WBD->error() == "" ) {
			return true;
		} else {
			return false;
		}
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
        $this->MSG = "sólo puede existir un Responsable";
        return false;
    }
    
    function GuardarDireccion(){
        $sql = "CALL `prealta`.`SP_INSERT_PREDIRECCION`('$this->CALLE','$this->NINT','$this->NEXT',$this->PAIS,$this->ESTADO,$this->CIUDAD,$this->COLONIA,'$this->CP',$this->TIPODIRECCION);";
        $result = $this->WBD->SP($sql);
        if($this->WBD->error() == ''){
            if ( $result->num_rows > 0 ) {
				list( $ultimoID ) = $result->fetch_array();
				$this->DIRECCION = $ultimoID;
            	if($this->GuardarXML())
                	return true;
            	else
                	return false;
			} else {
				return false;
			}
        }else{
            return false;
        }
    }
    
    function GuardarDireccionContrato(){
        $sql = "CALL `prealta`.`SP_INSERT_PREDIRECCION`('$this->CALLE','$this->NINT','$this->NEXT',$this->PAIS,$this->ESTADO,$this->CIUDAD,$this->COLONIA,$this->CP,$this->TIPODIRECCION);";
		$result = $this->WBD->SP($sql);
        if($this->WBD->error() == ''){
            if ( $result->num_rows > 0 ) {
				list( $ultimoID ) = $result->fetch_array();
				$this->CDIRECCION = $ultimoID;
            	if($this->GuardarXML())
                	return true;
            	else
                	return false;
			} else {
				return false;
			}
        }else{
            return false;
        }
    }
    
    function GuardarContrato(){
		if ( $this->CFCONSTITUCION == "NULL" ) {
			$sql = "CALL `prealta`.`SP_INSERT_PRECONTRATO`($this->CREGIMEN, '$this->CRSOCIAL', $this->CFCONSTITUCION, '$this->CRFC', {$_SESSION['idU']});";	
		} else {
			$sql = "CALL `prealta`.`SP_INSERT_PRECONTRATO`($this->CREGIMEN, '$this->CRSOCIAL', '$this->CFCONSTITUCION', '$this->CRFC', {$_SESSION['idU']});";
		}
		$result = $this->WBD->SP($sql);
		if($this->WBD->error() == ''){
            if ( $result->num_rows > 0 ) {
				list( $ultimoID ) = $result->fetch_array();
				$this->CONTRATO = $ultimoID;
            	return true;
			} else {
				return false;
			}
        }
        return $this->WBD->error();
    }
    
    function SemaforoGenerales(){
        if($this->CADENA != '' && $this->GRUPO != '' && $this->REFERENCIA != ''){
            return 0;
        }else if($this->CADENA != '' || $this->GRUPO != '' || $this->REFERENCIA != ''){
            return 1;
        }else{
            return 3;
        }
    }
    
    function SemaforoDireccion(){
        if($this->CALLE != '' && $this->NEXT != '' && $this->CIUDAD != '' && $this->ESTADO != '' && $this->PAIS != ''){
            return 0;
        }else if($this->CALLE != '' || $this->NEXT != '' || $this->CIUDAD != '' || $this->ESTADO != '' || $this->PAIS != ''){
            return 1;
        }else{
            return 3;
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
    
    function SemaforoContrato(){
		if ( $this->CREGIMEN == 1 ) {
			if($this->CRFC != '' && $this->CNOMBRE != '' && $this->CPATERNO != '' && $this->CMATERNO != '' && $this->CNUMIDEN != ''
			&& $this->CTIPOIDEN != '' && $this->CPAIS != '' && $this->CCALLE != '' && $this->CNEXT != ''
			&& $this->CCP != '' && $this->CCOLONIA != '' && $this->CESTADO != '' && $this->CCIUDAD != ''){
				return 0;
			}else if($this->CRFC != '' || $this->CNOMBRE != '' || $this->CPATERNO != ''
			|| $this->CMATERNO != '' || $this->CNUMIDEN != ''
			|| $this->CTIPOIDEN != '' || $this->CPAIS != '' || $this->CCALLE != '' || $this->CNEXT != ''
			|| $this->CCP != '' || $this->CCOLONIA != '' || $this->CESTADO != '' || $this->CCIUDAD != ''){
				return 1;
			}else{
				return 3;
			}
		} else if ( $this->CREGIMEN == 2 ) {
			if($this->CRRFC != '' && $this->CRSOCIAL != '' && $this->CFCONSTITUCION != '' && $this->CREGIMEN != '' &&
			$this->CNOMBRE != '' && $this->CPATERNO != '' && $this->CMATERNO != '' && $this->CNUMIDEN != ''
			&& $this->CTIPOIDEN != '' && $this->CPAIS != '' && $this->CCALLE != '' && $this->CNEXT != ''
			&& $this->CCP != '' && $this->CCOLONIA != '' && $this->CESTADO != '' && $this->CCIUDAD != ''){
				return 0;
			}else if($this->CRRFC != '' || $this->CRSOCIAL != '' || $this->CFCONSTITUCION != '' || $this->CREGIMEN != '' ||
			$this->CNOMBRE != '' || $this->CPATERNO != '' || $this->CMATERNO != '' || $this->CNUMIDEN != ''
			|| $this->CTIPOIDEN != '' || $this->CPAIS != '' || $this->CCALLE != '' || $this->CNEXT != ''
			|| $this->CCP != '' || $this->CCOLONIA != '' || $this->CESTADO != '' || $this->CCIUDAD != ''){
				return 1;
			}else{
				return 3;
			}		
		} else {
			return 2;
		}
    }
    
    function SemaforoCuenta(){
        if($this->BANCO != '' && $this->CLABE != ''  && $this->BENEFICIARIO != ''){
            return 0;
        }else if($this->BANCO != '' || $this->CLABE != ''  || $this->BENEFICIARIO != ''){
            return 1;
        }else{
            return 3;
        }
    }
    
    function SemaforoDocumentacion(){
		if ( $this->CREGIMEN == 2 ) {
			if ( $this->SemaforoDireccion() != 0 ) {
				if($this->DFISCAL != '' && $this->DBANCO != '' && $this->DREPLEGAL != '' && $this->DRSOCIAL != '' && $this->DACONSTITUTIVA != '' && $this->DPODERES != ''){
					return 0;
				}else if($this->DFISCAL != '' || $this->DBANCO != '' || $this->DREPLEGAL != '' || $this->DRSOCIAL != '' || $this->DACONSTITUTIVA != '' || $this->DPODERES != ''){
					return 1;
				}else{
					return 3;
				}
			} else if ( $this->SemaforoDireccion() == 0 ) {
				if($this->DDOMICILIO != '' && $this->DFISCAL != '' && $this->DBANCO != '' && $this->DREPLEGAL != '' && $this->DRSOCIAL != '' && $this->DACONSTITUTIVA != '' && $this->DPODERES != ''){
					return 0;
				}else if($this->DDOMICILIO != '' || $this->DFISCAL != '' || $this->DBANCO != '' || $this->DREPLEGAL != '' || $this->DRSOCIAL != '' || $this->DACONSTITUTIVA != '' || $this->DPODERES != ''){
					return 1;
				}else{
					return 3;
				}			
			}
		} else if ( $this->CREGIMEN == 1 ) {
			if ( $this->SemaforoDireccion() != 0 ) {
				if($this->DBANCO != '' && $this->DREPLEGAL != '' && $this->DRSOCIAL != ''){
					return 0;
				}else if($this->DBANCO != '' || $this->DREPLEGAL != '' || $this->DRSOCIAL != ''){
					return 1;
				}else{
					return 3;
				}
			} else if ( $this->SemaforoDireccion() == 0 ) {
				if($this->DDOMICILIO != '' && $this->DBANCO != '' && $this->DREPLEGAL != '' && $this->DRSOCIAL != ''){
					return 0;
				}else if($this->DDOMICILIO != '' || $this->DBANCO != '' || $this->DREPLEGAL != '' || $this->DRSOCIAL != ''){
					return 1;
				}else{
					return 3;
				}			
			}		
		} else {
			if($this->DFISCAL != '' && $this->DBANCO != '' && $this->DREPLEGAL != '' && $this->DRSOCIAL != ''){
				return 0;
			}else if($this->DFISCAL != '' || $this->DBANCO != '' || $this->DREPLEGAL != '' || $this->DRSOCIAL != ''){
				return 1;
			}else{
				return 3;
			}
		}
    }
    
    function setID($value){
        $this->ID = $value;
    }
    
    function getID(){
        return $this->ID;
    }
    
    function getError(){
        return $this->ERROR;
    }
    
    function getMsg(){
        return $this->MSG;
    }
    
    function setNombre($value){
        $this->NOMBRE = $value;
    }
    
    function getNombre(){
        return $this->NOMBRE;
    }
    
	function setVersion($value){
        $this->VERSION = $value;
    }	
	
    function setIdCadena($value){
        $this->CADENA = $value;
    }
    
    function getIdCadena(){
        return $this->CADENA;
    }
    
    function getNombreCadena(){
        $sql = "CALL `redefectiva`.`SP_GET_NOMBRECADENA`($this->CADENA);";
		$res = $this->RBD->SP($sql);
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            return $r[0];
        }
    }
    
    function getExiste(){
        return $this->EXISTE;
    }
	
    function getVersion(){
        return $this->VERSION;
    }
	
    function getNombreVersion(){
		$sql = "CALL `redefectiva`.`SP_GET_VERSION`($this->VERSION);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
		return "";
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
		$sql = "CALL `prealta`.`SP_GET_COLONIA`($this->PAIS, $this->COLONIA);";
        $res = $this->RBD->SP($sql);
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            return $r[0];
        }
    }
 
     function getCNombreColonia(){
		$sql = "CALL `prealta`.`SP_GET_COLONIA`($this->CPAIS, $this->CCOLONIA);";
		$res = $this->RBD->SP($sql);
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            return $r[0];
        }
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
    
    function getNombreCCiudad(){
		$sql = "CALL `prealta`.`SP_GET_CIUDAD`($this->CPAIS, $this->CESTADO, $this->CCIUDAD);";
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
        $res = $this->RBD->query($sql);
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            return $r[0];
        }
    }

    function getCNombreEstado(){
		$sql = "CALL `prealta`.`SP_GET_ESTADO`($this->CPAIS, $this->CESTADO);";
        $res = $this->RBD->query($sql);
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

    function getCNombrePais(){
		$sql = "CALL `redefectiva`.`SP_GET_PAIS`($this->CPAIS);";
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
		$sql = "CALL `prealta`.`SP_GET_NOMBREEJECUTIVO`($this->ECUENTA);";
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
		$sql = "CALL `prealta`.`SP_GET_NOMBREEJECUTIVO`($this->EVENTA);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0]." ".$r[1]." ".$r[2];
		}
		return "";
    }
    
    function setForelo($value){
	$this->FORELO = $value;
    }
    
    function getForelo(){
	return $this->FORELO;
    }
    
    function setFCantidad($value){
	$this->FCANTIDAD = $value;
    }
    
    function getFCantidad(){
	return $this->FCANTIDAD;
    }
    
    function setFDescripcion($value){
	$this->FDESCRIPCION = $value;
    }
    
    function getFDescripcion(){
	return $this->FDESCRIPCION;
    }
    
    function setFReferencia($value){
	$this->FREFERENCIA = $value;
    }
    
    function getFReferencia(){
	return $this->FREFERENCIA;
    }
    
    function setIdCuentaBanco($value){
        $this->CUENTA = $value;
    }
    
    function getIdCuentaBanco(){
        return $this->CUENTA;
    }

    function setIdBanco($value){
        $this->BANCO = $value;
    }
    
    function getIdBanco(){
        return $this->BANCO;
    }
    
    function getNombreBanco(){
		$sql = "CALL `redefectiva`.`SP_GET_NOMBREBANCO`($this->BANCO);";
        $res = $this->RBD->SP($sql);
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            return $r[0];
        }
    }
    
    function setNumCuenta($value){
        $this->NUMCUENTA = $value;
    }
    
    function getNumCuenta(){
        return $this->NUMCUENTA;
    }
    
    function setClabe($value){
        $this->CLABE = $value;
    }
    
    function getClabe(){
        return $this->CLABE;
    }
    
    function setBeneficiario($value){
        $this->BENEFICIARIO = $value;
    }
    
    function getBeneficiario(){
        return $this->BENEFICIARIO;
    }
    
    function setDescripcion($value){
        $this->DESCRIPCION = $value;
    }
    
    function getDescripcion(){
        return $this->DESCRIPCION;
    }
    
    function GuardarCuentaBanco(){
		$sql = "CALL `prealta`.`SP_INSERT_PRECUENTA`($this->BANCO, '$this->NUMCUENTA', '$this->CLABE', '$this->BENEFICIARIO', '$this->DESCRIPCION', {$_SESSION['idU']});";
		$res = $this->WBD->SP($sql);
		if ( $this->WBD->error() == '' ) {
            if ( $res->num_rows > 0 ) {
				list( $ultimoID ) = $res->fetch_array();
				$this->CUENTA = $ultimoID;
            	if($this->GuardarXML())
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
    
    function setDDomicilio($value){
        $this->DDOMICILIO = $value;
    }
    
    function getDDomicilio(){
        return $this->DDOMICILIO;
    }
    
    function getNombreDocumento($id){
		$sql = "CALL `prealta`.`SP_GET_NOMBREDOCUMENTO`($id);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
		return "";
    }
    
    function setDFiscal($value){
        $this->DFISCAL = $value;
    }
    
    function getDFiscal(){
        return $this->DFISCAL;
    }
    
    function setDBanco($value){
        $this->DBANCO = $value;
    }
    
    function getDBanco(){
        return $this->DBANCO;
    }
    
    function setDRSocial($value){
        $this->DRSOCIAL = $value;
    }
    
    function getDRSocial(){
        return $this->DRSOCIAL;
    }
    
    function setDRepLegal($value){
        $this->DREPLEGAL = $value;
    }
    
    function getDRepLegal(){
        return $this->DREPLEGAL;
    }
    
    function setDAConstitutiva($value){
        $this->DACONSTITUTIVA = $value;
    }
    
    function getDAConstitutiva(){
        return $this->DACONSTITUTIVA;
    }
    
    function setDPoderes($value){
        $this->DPODERES = $value;
    }
    
    function getDPoderes(){
        return $this->DPODERES;
    }
    
    function setContrato($value){
        $this->CONTRATO = $value;
    }
    
    function getContrato(){
        return $this->CONTRATO;
    }
    
    function setCRRfc($value){
        $this->CRRFC = $value;
    }
    
    function getCRRfc(){
        return $this->CRRFC;
    }
    
    function setCRSocial($value){
        $this->CRSOCIAL = $value;
    }
    
    function getCRSocial(){
        return $this->CRSOCIAL;
    }
    
    function setCFConstitucion($value){
        $this->CFCONSTITUCION = $value;
    }
    
    function getCFConstitucion(){
        return $this->CFCONSTITUCION;
    }
    
    function setCRegimen($value){
        $this->CREGIMEN = $value;
    }
    
    function getCRegimen(){
        return $this->CREGIMEN;
    }
    
    function getNombreCRegimen(){
		$nombre = "";
		switch($this->CREGIMEN){
			case 1:
				$nombre = "F&iacute;sica";
			break;
			case 2:
				$nombre = "Moral";
			break;
		}
		return $nombre;
    }
    
    function setCDireccion($value){
        $this->CDIRECCION = $value;
    }
    
    function getCDireccion(){
        return $this->CDIRECCION;
    }
    
    function setCCalle($value){
        $this->CCALLE = $value;
    }
    
    function getCCalle(){
        return $this->CCALLE;
    }
    
    function setCNext($value){
        $this->CNEXT = $value;
    }
    
    function getCNext(){
        return $this->CNEXT;
    }
    
    function setCNint($value){
        $this->CNINT = $value;
    }
    
    function getCNint(){
        return $this->CNINT;
    }
    
    function setCColonia($value){
        $this->CCOLONIA = $value;
    }
    
    function getCColonia(){
        return $this->CCOLONIA;
    }
    
    function setCCiudad($value){
        $this->CCIUDAD = $value;
    }
    
    function getCCiudad(){
        return $this->CCIUDAD;
    }
    
    function getCNombreCiudad(){
		$sql = "CALL `prealta`.`SP_GET_CIUDAD`($this->CPAIS, $this->CESTADO, $this->CCIUDAD);";
        $res = $this->RBD->SP($sql);
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            return $r[0];
        }
    }
    
    function setCEstado($value){
        $this->CESTADO = $value;
    }
    
    function getCEstado(){
        return $this->CESTADO;
    }
    
    function setCCP($value){
        $this->CCP = $value;
    }
    
    function getCCP(){
        return $this->CCP;
    }
    
    function setCPais($value){
        $this->CPAIS = $value;
    }
    
    function getCPais(){
        return $this->CPAIS;
    }
    
    function setCTipoDireccion($value){
        $this->CTIPODIRECCION = $value;
    }
    
    function getCTipoDireccion(){
        return $this->CTIPODIRECCION;
    }
    
    function setCRepLegal($value){
        $this->CREPLEGAL = $value;
    }
    
    function getCRepLegal(){
        return $this->CREPLEGAL;
    }
    
    function setCNombre($value){
        $this->CNOMBRE = $value;
    }
    
    function getCNombre(){
        return $this->CNOMBRE;
    }
    
    function setCPaterno($value){
        $this->CPATERNO = $value;
    }
    
    function getCPaterno(){
        return $this->CPATERNO;
    }
    
    function setCMaterno($value){
        $this->CMATERNO = $value;
    }
    
    function getCMaterno(){
        return $this->CMATERNO;
    }
    
    function setCNumIden($value){
        $this->CNUMIDEN = $value;
    }
    
    function getCNumIden(){
        return $this->CNUMIDEN;
    }
    
    function setCRTipoIden($value){
        $this->CTIPOIDEN = $value;
    }
    
    function getCRTipoIden(){
        return $this->CTIPOIDEN;
    }
    
    function getNombreCRTipoIden(){
		$sql = "CALL `prealta`.`SP_GET_TIPOIDENTIFICACION`($this->CTIPOIDEN);";
		$res = $this->RBD->SP($sql);
		if($res != '' && mysqli_num_rows($res) > 0){
			$r = mysqli_fetch_array($res);
			return $r[0];
		}
		return "";
    }
    
    function setCRfc($value){
        $this->CRFC = $value;
    }
    
    function getCRfc(){
        return $this->CRFC;
    }
    
    function setCCurp($value){
        $this->CCURP = $value;
    }
    
    function getCCurp(){
        return $this->CCURP;
    }
    
    function setCFigura($value){
        $this->CFIGURA = $value;
    }
    
    function getCFigura(){
        return $this->CFIGURA;
    }
    
    function setCFamilia($value){
        $this->CFAMILIA = $value;
    }
    
    function getCFamilia(){
        return $this->CFAMILIA;
    }
    
    function GuardarRepLegal(){
		$sql = "CALL `prealta`.`SP_FIND_PREREPRESENTANTELEGAL`($this->CTIPOIDEN, '$this->CNUMIDEN', '$this->CRRFC');";
        $res = $this->RBD->SP($sql);


		if(($res != '' && mysqli_num_rows($res) > 0) || $this->CREPLEGAL != ""){

			$r = mysqli_fetch_array($res);
			if($this->CREPLEGAL == ""){
                if($this->RBD->error() == ''){
                    $this->CREPLEGAL = $r[0];
                } else {
				    return false;
                }
            }
	    	$sql = "CALL `prealta`.`SP_UPDATE_PREREPRESENTANTELEGAL`($this->CTIPOIDEN, '$this->CNOMBRE', '$this->CPATERNO', '$this->CMATERNO', '$this->CNUMIDEN', '$this->CRRFC', '$this->CCURP', $this->CFIGURA, $this->CFAMILIA, {$_SESSION['idU']}, $this->CREPLEGAL);";
            //echo "<pre>"; echo var_dump($sql); echo "</pre>";
	    	$this->WBD->SP($sql);
			//var_dump("sql: $sql");
			if($this->WBD->error() == ''){
				return true;
	    	} else {
	    		return false;
			}
        } else {
			$sql = "CALL `prealta`.`SP_INSERT_PREREPRESENTANTELEGAL`($this->CTIPOIDEN, '$this->CNOMBRE', '$this->CPATERNO', '$this->CMATERNO', '$this->CNUMIDEN', '$this->CRRFC', '$this->CCURP', $this->CFIGURA, $this->CFAMILIA, {$_SESSION['idU']});";
			$result = $this->WBD->SP($sql);
			if ( $this->WBD->error() == '' ) {
				if ( $result->num_rows > 0 ) {
					list( $ultimoID ) = $result->fetch_array();
					$this->CREPLEGAL = $ultimoID;
					return true;
				} else {
					return false;
				}
	    	} else {
				if ( mysqli_errno($this->WBD->LINK) == 1062 )
		    		$this->ERROR = "Favor de checar Numero de Identificacion y/o RFC (Entrada duplicada).";
				return false;
	    	}
		}
		$this->ERROR = $sql;
        return false;
    }
    
    function Revisar(){
        $r = 1;
        if($this->REVISADOGENERALES && $this->REVISADOCUENTA && $this->REVISADOCONTRATO && $this->VERSION
		&& $this->REVISADOCONTACTOS && $this->REVISADODIRECCION && $this->REVISADOCONTRATO && $this->REVISADOCUENTA && $this->REVISADODOCUMENTACION)
            $r = 0;
        else
            $r = 1;
        
        $sql = "CALL `prealta`.`SP_SET_REVISADOPRESUBCADENA`($this->ID, $r);";
		$this->WBD->SP($sql);
        if($this->WBD->error() == '')
            return true;
        return false;
    }
    
    function IsRevisado(){
		if($this->REVISADOGENERALES && $this->REVISADOCUENTA && $this->REVISADOCONTRATO && $this->VERSION
		&& $this->REVISADOCONTACTOS && $this->REVISADODIRECCION && $this->REVISADOCONTRATO && $this->REVISADOCUENTA && $this->REVISADODOCUMENTACION)
            return true;
        return false;
    }
    
	function setReferenciaBancaria( $value ){
		$this->REFBANCARIA = $value;
	}
	
	function getReferenciaBancaria(){
		return $this->REFBANCARIA;
	}
	
	function getPreRevisadoVersion(){
		return $this->PREREVISADOVERSION;
	}	
	
	function setPreRevisadoVersion($value){
		$this->PREREVISADOVERSION = $value;
	}	
	
	function getPreRevisadoCargos(){
		return $this->PREREVISADOCARGOS;
	}
	
	function setPreRevisadoCargos($value){
		$this->PREREVISADOCARGOS = $value;
	}			
	
	function getRevisadoCargos(){
		return $this->REVISADOCARGOS;
	}
	
	function setRevisadoCargos($value){
		$this->REVISADOCARGOS = $value;
	}	
	
	function getPreRevisadoGenerales(){
		return $this->PREREVISADOGENERALES;
	}
	
	function setPreRevisadoGenerales($value){
		$this->PREREVISADOGENERALES = $value;
	}	
	
	function setPreRevisadoDireccion($value){
		$this->PREREVISADODIRECCION = $value;
	}
	
	function getPreRevisadoDireccion(){
		return $this->PREREVISADODIRECCION;
	}		
	
	function setRevisadoDocumentacion($value){
		$this->REVISADODOCUMENTACION = $value;
	}
	
	function setPreRevisadoContactos($value){
		$this->PREREVISADOCONTACTOS = $value;
	}
	
	function getPreRevisadoContactos(){
		return $this->PREREVISADOCONTACTOS;
	}
	
	function setPreRevisadoEjecutivos($value){
		if($this->SemaforoEjecutivos() == 0){
			$this->PREREVISADOECUENTA = $value;
			$this->PREREVISADOEVENTA = $value;
		}
	}
	
	function getPreRevisadoEjecutivos(){
		if($this->PREREVISADOECUENTA && $this->PREREVISADOEVENTA)
			return true;
		return false;
	}				
	
	function getRevisadoDocumentacion(){
		return $this->REVISADODOCUMENTACION;
	}
	
	function setPreRevisadoDocumentacion($value){
		$this->PREREVISADODOCUMENTACION = $value;
	}
	
	function getPreRevisadoDocumentacion(){
		return $this->PREREVISADODOCUMENTACION;
	}	
	
    function setRevisadoGenerales($value){
        $this->REVISADOGENERALES = $value;
    }
    
    function getRevisadoGenerales(){
        return $this->REVISADOGENERALES;
    }
    
    function setRevisadoDireccion($value){
        $this->REVISADODIRECCION = $value;
    }
    
    function getRevisadoDireccion(){
        return $this->REVISADODIRECCION;
    }
    
    function setRevisadoContactos($value){
        $this->REVISADOCONTACTOS = $value;
    }
    
    function getRevisadoContactos(){
        return $this->REVISADOCONTACTOS;
    }
    
    function setRevisadoEjecutivos($value){
        $this->REVISADOECUENTA = $value;
        $this->REVISADOEVENTA = $value;
    }
    
    function getRevisadoEjecutivos(){
        if($this->REVISADOECUENTA && $this->REVISADOEVENTA)
            return true;
        return false;
    }
    
    function setRevisadoCuenta($value){
		$this->REVISADOCUENTA = $value;
    }
    
    function getRevisadoCuenta(){
		return $this->REVISADOCUENTA;
    }
	
    function setPreRevisadoCuenta($value){
	$this->PREREVISADOCUENTA = $value;
    }
    
    function getPreRevisadoCuenta(){
	return $this->PREREVISADOCUENTA;
    }	
    
	function setRevisadoVersion($value){
		$this->REVISADOVERSION = $value;
	}
	
	function getRevisadoVersion(){
		return $this->REVISADOVERSION;
	}
	
    function setRevisadoContrato($value){
		$this->REVISADOCONTRATO = $value;
    }
    
    function getRevisadoContrato(){
	return $this->REVISADOCONTRATO;
    }
    
    function setPreRevisadoContrato($value){
		$this->PREREVISADOCONTRATO = $value;
    }	
	
    function getPreRevisadoContrato(){
	return $this->PREREVISADOCONTRATO;
    }	
	
    function setRevisadoForelo($value){
	$this->REVISADOFORELO = $value;
    }
    
    function getRevisadoForelo(){
	return $this->REVISADOFORELO;
    }
	
    function SemaforoVersion(){
		if ( $this->VERSION != '' ) {
			return 0;
		} else {
			return 2;
		}
    }
    
    function CalcularPorcentaje(){
        $this->PORCENTAJE = 0;
        if($this->SemaforoGenerales() == 0)
            $this->PORCENTAJE += 20;
        if($this->SemaforoContrato() == 0)
            $this->PORCENTAJE += 20;
		if($this->SemaforoVersion() == 0)
			$this->PORCENTAJE += 20;
		if($this->SemaforoDocumentacion() == 0)
			$this->PORCENTAJE += 20;			
        if($this->SemaforoCuenta() == 0)
            $this->PORCENTAJE += 20;            
        
		if($this->PORCENTAJE > 99)
            $this->PORCENTAJE = 100;
        
		$sql = "CALL `prealta`.`SP_UPDATE_PORCENTAJEPRESUBCADENA`($this->PORCENTAJE, $this->ID);";
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
    
    private $ERROR = "";
    private $MSG = "";
    
    function __construct($r,$w){
        $this->RBD = $r;
        $this->WBD = $w;
    }
    
    function load($id){
		$sql = "CALL `prealta`.`SP_LOAD_PRESUBCADENACONTACTOS`($id);";
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
    
    function Guardar($idSubCadena){
		if(!$this->Existe()){
            $sql = "CALL `prealta`.`SP_INSERT_PRECONTACTO`($this->TIPO, '$this->NOMBRE', '$this->PATERNO', '$this->MATERNO', '$this->TELEFONO', '$this->EXTTEL', '$this->CORREO', {$_SESSION['idU']});";
			$result = $this->WBD->SP($sql);    
		    if($this->WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $ultimoID ) = $result->fetch_array();
					$this->ID = $ultimoID;
					if(!$this->ExisteInf($idSubCadena)){
						$sql = "CALL `prealta`.`SP_INSERT_PRESUBCADENACONTACTO`($idSubCadena, $this->ID, $this->TIPO, {$_SESSION['idU']});";
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
        }else{
			if(!$this->ExisteInf($idSubCadena)){
				$sql = "CALL `prealta`.`SP_INSERT_PRESUBCADENACONTACTO`($idSubCadena, $this->ID, $this->TIPO, {$_SESSION['idU']});";    
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
        }
    }
    
    function Borrar(){
        $sql = "CALL `prealta`.`SP_DISABLE_PRESUBCADENACONTACTO`($this->INFID);";
		$this->WBD->SP($sql);
        if($this->WBD->error() == ''){
            return true;
        }else{
            return false;
        }
    }
    
    function Actualizar(){
		$sql = "CALL `prealta`.`SP_UPDATE_PRECONTACTO`('$this->NOMBRE', '$this->PATERNO', '$this->MATERNO', '$this->TELEFONO', '$this->EXTTEL', '$this->CORREO', '$this->ID');";
        $this->WBD->SP($sql);
        if($this->WBD->error() == ''){
            $sql = "CALL `prealta`.`SP_UPDATE_PRESUBCADENACONTACTO`($this->TIPO, $this->INFID);";
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
    
    function ExisteInf($idSubCadena){
        $sql = "CALL `prealta`.`SP_EXISTE_PRESUBCADENACONTACTO`($idSubCadena, $this->ID);";
		$res = $this->RBD->SP($sql);
        if($this->RBD->error() == '' && mysqli_num_rows($res) > 0){
            return true;
        }
        return false;
    }
    
    function setId($value){
        $this->ID = $value;
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