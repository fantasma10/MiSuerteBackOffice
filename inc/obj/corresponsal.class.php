<?php
class Corresponsal{
    public $RBD,$WBD;
	
	private $ID;
	private $IDGRUPO;
	private $IDCADENA;
	private $IDSUBCADENA;
	private $FECHAALTA;
	private $NOMBREC;
	private $NUMC;
	private $NUMCUENTA;
	private $NUMCONTRATO;
	private $CODIGO;
	private $TEL1;
	private $TEL2;
	private $FAX;
	private $MAIL;
	private $NUMSUCURSAL;
	private $NOMSUCURSAL;
	private $FECHAVENCIMIENTO;
	private $FECHAOPERACION;
	private $IDCGIRO;
	private $IDCBANCARIO;
	private $IDCVER;
	private $IDCREF;
	private $IDUSERALTA;
	private $STATUS;
	
	private $NOMBREGRUPO;
	private $NOMBRECADENA;
	private $NOMBRESUBCADENA;
	private $NOMBREGIRO;
	private $NOMBREVERSION;
	private $NOMBREREFERENCIA;
	private $NOMBREUSUARIOALTA;
	private $SALDOCUENTA;
	private $FORELO;
	private $NOMBREECUENTA;
	private $NOMBREEVENTA;
	/*private $INICIODIA1;
	private $CIERREDIA1;
	private $INICIODIA2;
	private $CIERREDIA2;
	private $INICIODIA3;
	private $CIERREDIA3;
	private $INICIODIA4;
	private $CIERREDIA4;
	private $INICIODIA5;
	private $CIERREDIA5;
	private $INICIODIA6;
	private $CIERREDIA6;
	private $INICIODIA7;
	private $CIERREDIA7;*/
	private $IDREPLEGAL;
	private $NOMBREREPLEGAL;
	private $CORRESPONSALBANCOESTATUS;
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
	private $REFERENCIABANCARIAESTATUS;
	private $REFERENCIABANCARIA;
	
    public function __construct($RBD,$WBD) 
	{
		$this->RBD					=	$RBD;
		$this->WBD					=	$WBD;
		$this->ID					=	0;

		$this->IDGRUPO				=	NULL;		
		$this->IDCADENA				=	NULL;		
		$this->IDSUBCADENA			=	NULL;
		$this->FECHAALTA			=	NULL;
		$this->NOMBREC				=	NULL;
		$this->NUMC					=	NULL;
		$this->NUMCUENTA			=	NULL;
		$this->NUMCONTRATO			=	NULL;
		$this->CODIGO				=	NULL;
		$this->TEL1					=	NULL;
		$this->TEL2					=	NULL;
		$this->FAX					=	NULL;
		$this->MAIL					=	NULL;
		$this->NUMSUCURSAL			=	NULL;
		$this->NOMSUCURSAL			=	NULL;
		$this->FECHAVENCIMIENTO		=	NULL;
		$this->FECHAOPERACION		=	NULL;
		$this->IDCGIRO				=	NULL;
		$this->IDCBANCARIO			=	NULL;
		$this->IDCVER				=	NULL;
		$this->IDCREF				=	NULL;
		$this->IDUSERALTA			=	NULL;
		$this->STATUS				=	NULL;
		$this->IDIVA				= 	NULL;
		$this->DESCIVA				=	NULL;
	}
	
	public function load($ID)
	{
		$SQL = "CALL `redefectiva`.`SP_LOAD_CORRESPONSAL`($ID);";
		//var_dump("SQL: $SQL");
		$Result = $this->RBD->SP($SQL);
		if($Result){
			if(mysqli_num_rows($Result) > 0)
			{
				list(
					$this->ID,
					$this->IDGRUPO,
					$this->IDCADENA,
					$this->IDSUBCADENA,
					$this->FECHAALTA,
					$this->NOMBREC,
					$this->NUMC,
					$this->NUMCUENTA,
					$this->NUMCONTRATO,
					$this->CODIGO,
					$this->TEL1,
					$this->TEL2,
					$this->FAX,
					$this->MAIL,
					$this->NUMSUCURSAL,
					$this->NOMSUCURSAL,
					$this->FECHAVENCIMIENTO,
					$this->FECHAOPERACION,
					$this->IDCGIRO,
					$this->IDCBANCARIO,
					$this->IDCVER,
					$this->IDCREF,
					$this->IDUSERALTA,
					$this->STATUS,
					$this->NOMBREGRUPO,
					$this->NOMBRECADENA,
					$this->NOMBRESUBCADENA,
					$this->NOMBREGIRO,
					$this->NOMBREVERSION,
					$this->NOMBREREFERENCIA,
					$this->NOMBREUSUARIOALTA,
					$this->SALDOCUENTA,
					$this->FORELO,
					$this->IDEJECUTIVOCUENTA,
					$this->IDEJECUTIVOVENTA,
					$this->NOMBREECUENTA,
					$this->NOMBREEVENTA,
					$this->INICIODIA1,
					$this->CIERREDIA1,
					$this->INICIODIA2,
					$this->CIERREDIA2,
					$this->INICIODIA3,
					$this->CIERREDIA3,
					$this->INICIODIA4,
					$this->CIERREDIA4,
					$this->INICIODIA5,
					$this->CIERREDIA5,
					$this->INICIODIA6,
					$this->CIERREDIA6,
					$this->INICIODIA7,
					$this->CIERREDIA7,
					$this->IDREPLEGAL,
					$this->NOMBREREPLEGAL,
					$this->CORRESPONSALBANCOESTATUS,
					$this->DIRCALLE,
					$this->DIRNINT,
					$this->DIRNEXT,
					$this->DIRNOMBRECOLONIA,
					$this->DIRIDCOLONIA,
					$this->DIRNOMBRECIUDAD,
					$this->DIRIDESTADO,
					$this->DIRNOMBREESTADO,
					$this->DIRCODIGOPOSTAL,
					$this->DIRNOMBREPAIS,
					$this->DIRIDPAIS,
					$this->DIRIDCIUDAD,
					$this->REFERENCIABANCARIAESTATUS,
					$this->REFERENCIABANCARIA,
					$this->DESCACCESO,
					$this->IDIVA,
					$this->DESCIVA,
					$this->BANCARIO,
					$this->NUMEROCONTRATO,
					$this->ID_REPLEGAL,
					$this->NOMBRE_REPLEGAL,
					$this->RFC_REPLEGAL,
					$this->FECHAINICIO,
					$this->ESTATUSBANCARIO,
					$this->ID_GRUPO,
					$this->CUENTA_OWNER,
					$this->TIPO_CUENTA_FORELO,
					$this->ES_FORELO_INDIVIDUAL,
					$this->RFC_CONTRATO,
					$this->NOMBRE_EXPEDIENTE,
					$this->IDEXPEDIENTE,
					$this->IDEJECUTIVOAFILIACIONINTERMEDIA,
					$this->IDEJECUTIVOAFILIACIONAVANZADA,
					$this->NOMBREEAFILIACIONINTERMEDIA,
					$this->NOMBREEAFILIACIONAVANZADA,
					$this->REMESAS,
					$this->BANCARIOS,
					$this->SORTEOS
				) = mysqli_fetch_array($Result);

			} else {
				return self::respuesta(2,"No se encontro Mensaje"); 
			}
		} else { return self::respuesta(2,"No fue posible consultar datos"); }
	}

	function esForeloIndividual(){
		if(!empty($this->ES_FORELO_INDIVIDUAL)){
			return true;
		}
		else{
			return false;
		}
	}

	function getLabelTipoCuentaForelo(){
		if(!empty($this->TIPO_CUENTA_FORELO)){
			return $this->TIPO_CUENTA_FORELO;
		}
		else{
			return '';
		}
	}

	function getCuentaOwner(){
		if(!empty($this->CUENTA_OWNER)){
			return $this->CUENTA_OWNER;
		}
		else{
			return '';
		}
	}

	function getIdcBancario(){
		if(!empty($this->IDCBANCARIO)){
			return $this->IDCBANCARIO;
		}
		else{
			return 0;
		}
	}

	function getIdEstatusBancario(){
		if(!empty($this->ESTATUSBANCARIO)){
			return $this->ESTATUSBANCARIO;
		}
		else{
			return 0;
		}
	}

    function getComboByName($idCadena,$idsubcadena){
        $res = null;
        $res = $this->RBD->query("SELECT `idCorresponsal`,`nombreCorresponsal` FROM `redefectiva`.`dat_corresponsal` where idCadena = $idCadena and idSubCadena = $idsubcadena ORDER BY `nombreCorresponsal`;");
        $d = "";
        if($res != null){
            $d = "<select id='selcorres' class='com'><option>&lt;Ningun Corresponsal&gt;</option>";
            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[0]'>$r[1]</option>";
            }
            $d.="</select>";
            return $d;
        }else{
            return "<select id='selsubcad' class='com'><option>&lt;Ningun Corresponsal&gt;</option></select>";
        }
    }

	function getId(){
	    if ( isset($this->ID) )
			return $this->ID;
	    else
			return "No tiene";
	}

	function getIdGrupo(){
		if ( !empty($this->ID_GRUPO) )
			return $this->ID_GRUPO; 
		else
	    	return 0;
	}

	function getGrupo(){
		if ( isset($this->NOMBREGRUPO) )
			return $this->NOMBREGRUPO; 
		else
	    	return "No tiene";
	}

	function getIdCadena(){
	    if ( isset($this->IDCADENA) )
			return $this->IDCADENA;
	    else
			return "No tiene";
	}

	function getCadena(){
		if ( isset($this->NOMBRECADENA) )
			return $this->NOMBRECADENA;
		else
	    	return "No tiene";
	}

	function getIdSubCadena(){
	    if ( isset($this->IDSUBCADENA) )
			return $this->IDSUBCADENA;
	    else
			return "No tiene";
	}

	function getSubCadena(){
		if ( isset($this->NOMBRESUBCADENA) )
	    	return $this->NOMBRESUBCADENA;
		else
	    	return "No tiene";
	}

	function getFechaAlta(){
	    if ( isset($this->FECHAALTA) )
			return $this->FECHAALTA;
	    else
			return "No tiene";
	}

	function getNombreCor(){
	    if ( isset($this->NOMBREC) )
			return $this->NOMBREC;
	    else
			return "No tiene";
	}
		
	function getNumeroCor(){
	    if ( isset($this->NUMC) )
			return $this->NUMC;
	    else
			return "No tiene";
	}
		
	function getNumCuenta(){
	    if ( isset($this->NUMCUENTA) )
			return $this->NUMCUENTA;
	    else
			return "0";
	}
	
	//se copio la funcion para que no marque error con el return de No tiene
	function getNumeroCuenta(){
	    if ( isset($this->NUMCUENTA) )
			return $this->NUMCUENTA;
	    else
			return "";
	}
	
	function getNumContrato(){
	    if ( isset($this->NUMCONTRATO) )
			return $this->NUMCONTRATO;
	    else
			return "No tiene";
	}	

	function Codigo(){
	    if ( isset($this->CODIGO) )
			return $this->CODIGO;
	    else
			return "No tiene";
	}
	
	function getTel1(){
	    if ( isset($this->TEL1) )
			return $this->TEL1;
	    else
			return "No tiene";
	}
	
	function getTel2(){
	    if ( isset($this->TEL2) )
			return $this->TEL2;
	    else
			return "No tiene";
	}
	
	function getFax(){
	    if ( isset($this->FAX) )
			return $this->FAX;
	    else
			return "No tiene";
	}
	
	function getMail(){
	    if ( isset($this->MAIL) )
			return $this->MAIL;
	    else
			return "No tiene";
	}
	
	function getNumSucursal(){
	    if ( isset($this->NUMSUCURSAL) )
			return $this->NUMSUCURSAL;
	    else
			return "No tiene";
	}
	
	function getNomSucursal(){
	    if ( isset($this->NOMSUCURSAL) )
			return $this->NOMSUCURSAL;
	    else
			return "No tiene";
	}
	
	function getFechaVencimiento(){
	    if ( isset($this->FECHAVENCIMIENTO) )
			return $this->FECHAVENCIMIENTO;
	    else
			return "No tiene";
	}
	
	function getFechaOperacion(){
	    if ( isset($this->FECHAOPERACION) )
			return $this->FECHAOPERACION;
	    else
			return "No tiene";
	}
	
	function getGiro(){
	    if ( isset($this->IDCGIRO) )
			return $this->IDCGIRO;
	    else
			return "No tiene";
	}
	
	function getNombreGiro(){//falta correccion un inf para el giro
		if ( isset($this->NOMBREGIRO) ) 
	    	return $this->NOMBREGIRO;
		else
			return "No tiene";
	}
	
	function getIdBancario(){
	    if ( isset($this->IDCGIRO) )
			return $this->IDCGIRO;
	    else
			return "No tiene";
	}
	
	function getIdVer(){
	    if ( isset($this->IDCVER) )
			return $this->IDCVER;
	    else
			return 0;
	}
	
	function getVersion(){
		if ( isset($this->NOMBREVERSION) )
	    	return $this->NOMBREVERSION;
		else
			return "No tiene";
	}
	
	function getIdRef(){
	    if ( isset($this->IDCREF) )
			return $this->IDCREF;
	    else
			return "No tiene";
	}
	
	function getNombreReferencia(){
		if ( isset($this->NOMBREREFERENCIA) )
	    	return $this->NOMBREREFERENCIA;
		else
			return "No tiene";
	}
	
	function getidUsuarioAlta(){
	    if ( isset($this->IDUSERALTA) )
			return $this->IDUSERALTA;
	    else
			return "No tiene";
	}
	
	function getNombreUsuarioAlta(){
		if ( isset($this->NOMBREUSUARIOALTA) )
	    	return $this->acentos($this->NOMBREUSUARIOALTA);
		else
			return "No tiene";
	}

	function getStatus(){
	    $nombreStatus = "Sin Estatus";
		switch($this->STATUS){
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
		}
		return $nombreStatus;
	}

	function getIdStatus(){
	    $nombreStatus = "Sin Estatus";
		if(!empty($this->STATUS)){
			return $this->STATUS;
		}
		else{
			return 0;
		}
	}
	
	function getSaldoCuenta(){
		if(!empty($this->SALDOCUENTA)){
			return $this->SALDOCUENTA;
		}
		else{
			return 0;
		}
	}

	function getForelo(){    
	    if ( isset($this->SALDOCUENTA) && isset($this->FORELO) ) {
			$r = mysqli_fetch_array($res);
			$saldo = $this->SALDOCUENTA;
			$forelo = $this->FORELO;
			$foreloporcentaje = ($forelo > 0) ? ($saldo / $forelo) * 100 : 100;
			$foreloporcentaje = ($saldo == 0 && $forelo == 0) ? 0 : $foreloporcentaje;
			$clase = "";
			if ( $foreloporcentaje < 30 )
				$clase = "forelo_rojo";
			else if ( $foreloporcentaje > 29 && $foreloporcentaje < 51 )
				$clase = "forelo_amarillo";
			else
				$clase = "forelo_verde";
			return "<span class='$clase'>".round($foreloporcentaje)."%</span>";
	    } else {
			return "";
		}
	}

	function getIdEjecutivoCuenta(){
		if(!empty($this->IDEJECUTIVOCUENTA)){
			return $this->IDEJECUTIVOCUENTA;
		}
		else{
			return 0;
		}
	}

	function getIdEjecutivoVenta(){
		if(!empty($this->IDEJECUTIVOVENTA)){
			return $this->IDEJECUTIVOVENTA;
		}
		else{
			return 0;
		}
	}

	function getNombreEjecutivoCuenta(){
		if ( isset($this->NOMBREECUENTA) ) 
			return $this->NOMBREECUENTA;
		else
	    	return "No tiene";
	    
	}
	
	function getNombreEjecutivoVenta(){
		if ( isset($this->NOMBREEVENTA) )
			return $this->NOMBREEVENTA;
		else
	    	return "No tiene";
	    
	}

	function getIdEjecutivoAfiliacionIntermedia(){
		if(!empty($this->IDEJECUTIVOAFILIACIONINTERMEDIA)){
			return $this->IDEJECUTIVOAFILIACIONINTERMEDIA;
		}
		else{
			return 0;
		}
	}

	function getNombreEjecutivoAfiliacionIntermedia(){
		if ( isset($this->NOMBREEAFILIACIONINTERMEDIA) )
			return $this->NOMBREEAFILIACIONINTERMEDIA;
		else
	    	return "No tiene";
	}

	function getIdEjecutivoAfiliacionAvanzada(){
		if(!empty($this->IDEJECUTIVOAFILIACIONAVANZADA)){
			return $this->IDEJECUTIVOAFILIACIONAVANZADA;
		}
		else{
			return 0;
		}
	}

	function getNombreEjecutivoAfiliacionAvanzada(){
		if ( isset($this->NOMBREEAFILIACIONAVANZADA) )
			return $this->NOMBREEAFILIACIONAVANZADA;
		else
	    	return "No tiene";
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

	function esBancario(){
		if(!empty($this->BANCARIO)){
			return true;
		}
		else{
			return false;
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
			$this->ID_REPLEGAL;
		}
		else{
			return 0;
		}
	}

	function getNombreRepresentanteLegal(){
		if(!empty($this->NOMBRE_REPLEGAL)){
			return $this->acentos($this->NOMBRE_REPLEGAL);
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

	function getFechaInicio(){
		if(!empty($this->FECHAINICIO)){
			return $this->FECHAINICIO;
		}
		else{
			return "0000-00-00";
		}
	}

	function getHorario(){
	    $b1 = false;
	    $b2 = false;
	    $b3 = false;
	    $b4 = false;
	    $b5 = false;
	    $b6 = false;
	    $b7 = false;
		if( isset($this->INICIODIA1) && isset($this->INICIODIA2) && isset($this->INICIODIA3) && isset($this->INICIODIA4) && isset($this->INICIODIA5) && isset($this->INICIODIA6) && isset($this->INICIODIA7) && isset($this->CIERREDIA1) && isset($this->CIERREDIA2) && isset($this->CIERREDIA3) && isset($this->CIERREDIA4) && isset($this->CIERREDIA5) && isset($this->CIERREDIA6) && isset($this->CIERREDIA7) ){
		    $d = "";
			$d1 = date("H:i", strtotime($this->INICIODIA1));
			$c1 = date("H:i", strtotime($this->CIERREDIA1));
			$d2 = date("H:i", strtotime($this->INICIODIA2));
			$c2 = date("H:i", strtotime($this->CIERREDIA2));
			$d3 = date("H:i", strtotime($this->INICIODIA3));
			$c3 = date("H:i", strtotime($this->CIERREDIA3));
			$d4 = date("H:i", strtotime($this->INICIODIA4));
			$c4 = date("H:i", strtotime($this->CIERREDIA4));
			$d5 = date("H:i", strtotime($this->INICIODIA5));
			$c5 = date("H:i", strtotime($this->CIERREDIA5));
			$d6 = date("H:i", strtotime($this->INICIODIA6));
			$c6 = date("H:i", strtotime($this->CIERREDIA6));
			$d7 = date("H:i", strtotime($this->INICIODIA7));
			$c7 = date("H:i", strtotime($this->CIERREDIA7));
		    $d.="<table width='90%' border='0' cellpadding='6' cellspacing='0' class='borde_tabla_contactos'>
		<tr>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Lunes</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Martes</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Mi&eacute;rcoles</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Jueves</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Viernes</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>S&aacute;bado</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos1'><span class='texto_bold'>Domingo</span></td>
		</tr>
		    <tr align='center'>";
		    if($d1 == NULL)
			$b1 = true;
		    if($d2 == NULL)
			$b2 = true;
		    if($d3 == NULL)
			$b3 = true;
		    if($d4 == NULL)
			$b4 = true;
		    if($d5 == NULL)
			$b5 = true;
		    if($d6 == NULL)
			$b6 = true;
		    if($d7 == NULL)
			$b7 = true;
		    $d.="<td width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b1){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.=">De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b2){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.=">De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b3){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.=">De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b4){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.=">De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b5){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.=">De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b6){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.=">De:";}$d.="</td><td";if($b7){$d.=" rowspan='4' valign='center' >Descanzo";}else{$d.=">De:";}$d.="</td>
		    </tr>
		    <tr align='center'>";
			if(!$b1){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$d1</td>";}if(!$b2){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$d2</td>";}if(!$b3){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$d3</td>";}if(!$b4){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$d4</td>";}if(!$b5){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$d5</td>";}if(!$b6){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$d6</td>";}if(!$b7){$d.="<td>$d7</td>";}
		    $d.="</tr>
		    <tr align='center'>";
			if(!$b1){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";}if(!$b2){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";}if(!$b3){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";}if(!$b4){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";}if(!$b5){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";}if(!$b6){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";}if(!$b7){$d.="<td>A:</td>";}
		    $d.="</tr>
		    <tr align='center'>";
			if(!$b1){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$c1</td>";}if(!$b2){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$c2</td>";}if(!$b3){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$c3</td>";}if(!$b4){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$c4</td>";}if(!$b5){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$c5</td>";}if(!$b6){$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >$c6</td>";}if(!$b7){$d.="<td>$c7</td>";}
		    $d.="</tr>
		    </tbody></table>";
		    return $d;
		}else{
		    return "Lo sentimos pero no se encontraron resultados";
		}
	}
	
	function getHorarioEditar(){
	    $b1 = false;
	    $b2 = false;
	    $b3 = false;
	    $b4 = false;
	    $b5 = false;
	    $b6 = false;
	    $b7 = false;
		if ( isset($this->INICIODIA1) && isset($this->INICIODIA2) && isset($this->INICIODIA3) && isset($this->INICIODIA4) && isset($this->INICIODIA5) && isset($this->INICIODIA6) && isset($this->INICIODIA7) && isset($this->CIERREDIA1) && isset($this->CIERREDIA2) && isset($this->CIERREDIA3) && isset($this->CIERREDIA4) && isset($this->CIERREDIA5) && isset($this->CIERREDIA6) && isset($this->CIERREDIA7) ) {
		    $d = "";
			$d1 = date("H:i", strtotime($this->INICIODIA1));
			$c1 = date("H:i", strtotime($this->CIERREDIA1));
			$d2 = date("H:i", strtotime($this->INICIODIA2));
			$c2 = date("H:i", strtotime($this->CIERREDIA2));
			$d3 = date("H:i", strtotime($this->INICIODIA3));
			$c3 = date("H:i", strtotime($this->CIERREDIA3));
			$d4 = date("H:i", strtotime($this->INICIODIA4));
			$c4 = date("H:i", strtotime($this->CIERREDIA4));
			$d5 = date("H:i", strtotime($this->INICIODIA5));
			$c5 = date("H:i", strtotime($this->CIERREDIA5));
			$d6 = date("H:i", strtotime($this->INICIODIA6));
			$c6 = date("H:i", strtotime($this->CIERREDIA6));
			$d7 = date("H:i", strtotime($this->INICIODIA7));
			$c7 = date("H:i", strtotime($this->CIERREDIA7));
		    $d.="<table  width='70%' height='57' border='0' align='center' cellpadding='3' cellspacing='0' class='borde_tabla_contactos'>
		<tr>
		    <td width='14%' height='22px' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Lunes</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Martes</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Mi&eacute;rcoles</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Jueves</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>Viernes</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos2'><span class='texto_bold'>S&aacute;bado</span></td>
		    <td width='14%' align='center' valign='middle' class='borde_tabla_contactos_titulos1'><span class='texto_bold'>Domingo</span></td>
		</tr>
		    <tr align='center'>";
		    if($d1 == NULL)
			$b1 = true;
		    if($d2 == NULL)
			$b2 = true;
		    if($d3 == NULL)
			$b3 = true;
		    if($d4 == NULL)
			$b4 = true;
		    if($d5 == NULL)
			$b5 = true;
		    if($d6 == NULL)
			$b6 = true;
		    if($d7 == NULL)
			$b7 = true;
		    $d.="<td width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b1){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.="><br />De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b2){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.="><br />De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b3){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.="><br />De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b4){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.="><br />De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b5){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.="><br />De:";}$d.="</td><td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' ";if($b6){$d.=" rowspan='4' valign='center' >Descanso";}else{$d.="><br />De:";}$d.="</td><td";if($b7){$d.=" rowspan='4' valign='center' >Descanzo";}else{$d.="><br />De:";}$d.="</td>
		    </tr>
		    <tr align='center'>";
			if(!$b1){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt1' id='txt1' value='".substr($d1,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt1\")' onKeyUp='return validaHoras2(event,\"txt1\")' maxlength='5'/>
					</td>";
			}
			if(!$b2){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt3' id='txt3' value='".substr($d2,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt3\")' onKeyUp='return validaHoras2(event,\"txt3\")' maxlength='5'/>
					</td>";
			}
			if(!$b3){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt5' id='txt5' value='".substr($d3,0,5)."' size='5'  onKeyPress='return validaHoras(event,\"txt5\")' onKeyUp='return validaHoras2(event,\"txt5\")' maxlength='5'/>
					</td>";
			}
			if(!$b4){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
					<input type='text' name='txt7' id='txt7' value='".substr($d4,0,5)."' size='5'  onKeyPress='return validaHoras(event,\"txt7\")' onKeyUp='return validaHoras2(event,\"txt7\")' maxlength='5'/>
				</td>";
			}
			if(!$b5){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
					<input type='text' name='txt9' id='txt9' value='".substr($d5,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt9\")' onKeyUp='return validaHoras2(event,\"txt9\")' maxlength='5'/>
				</td>";
			}
			if(!$b6){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
					<input type='text' name='txt11' id='txt11' value='".substr($d6,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt11\")' onKeyUp='return validaHoras2(event,\"txt11\")' maxlength='5'/>
				</td>";
			}
			if(!$b7){
				$d.="<td>
						<input type='text' name='txt13' id='txt13' value='".substr($d7,0,5)."' size='5'  onKeyPress='return validaHoras(event,\"txt13\")' onKeyUp='return validaHoras2(event,\"txt13\")' maxlength='5'/>
					</td>";
			}
		    $d.="</tr>
		    <tr align='center'>";
			if(!$b1){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";
			}
			if(!$b2){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";
			}
			if(!$b3){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";
			}
			if(!$b4){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";
			}if(!$b5){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";
			}
			if(!$b6){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >A:</td>";
			}
			if(!$b7){
				$d.="<td>A:</td>";
			}
		    $d.="</tr>
		    <tbody>
		    <tr align='center'>";
			if(!$b1){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt2' id='txt2' value='".substr($c1,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt2\")' onKeyUp='return validaHoras2(event,\"txt2\")' maxlength='5'/>
						<br />
						<input type='checkbox' name='check2' id='check2' value='' style='visibility:hidden;' />
						<br />
						<br />
					</td>";
			}
			if(!$b2){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt4' id='txt4' value='".substr($c2,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt4\")' onKeyUp='return validaHoras2(event,\"txt4\")' maxlength='5' />
						<br />
						<!--input type='checkbox' name='check4' id='check4' value='' /-->
						<br />
						<br />
					</td>";
			}
			if(!$b3){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt6' id='txt6' value='".substr($c3,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt6\")' onKeyUp='return validaHoras2(event,\"txt6\")' maxlength='5'/>
						<br />
						<!--input type='checkbox' name='check6' id='check6' value='' /-->
						<br />
						<br />
					</td>";
			}
			if(!$b4){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt8' id='txt8' value='".substr($c4,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt8\")' onKeyUp='return validaHoras2(event,\"txt8\")' maxlength='5'/>
						<br />
						<!--input type='checkbox' name='check8' id='check8' value='' /-->
						<br />
						<br />
					</td>";
			}
			if(!$b5){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt10' id='txt10' value='".substr($c5,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt10\")' onKeyUp='return validaHoras2(event,\"txt10\")' maxlength='5'/>
						<br />
						<!--input type='checkbox' name='check10' id='check10' value='' /-->
						<br />
						<br />
					</td>";
			}
			if(!$b6){
				$d.="<td  width='14%' align='center' valign='middle' class='borde_tabla_contactos_int' >
						<input type='text' name='txt12' id='txt12' value='".substr($c6,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt12\")' onKeyUp='return validaHoras2(event,\"txt12\")' maxlength='5'/>
						<br />
						<!--input type='checkbox' name='check12' id='check12' value='' /-->
						<br />
						<br />
					</td>";
			}
			if(!$b7){
				$d.="<td>
						<input type='text' name='txt14' id='txt14' value='".substr($c7,0,5)."' size='5' onKeyPress='return validaHoras(event,\"txt14\")' onKeyUp='return validaHoras2(event,\"txt14\")' maxlength='5'/>
						<br />
						<!--input type='checkbox' name='check14' id='check14' value='' /-->
						<br />
						<br />
					</td>";
			}
		    $d.="</tr>
		    <tr>
		    	<td colspan='7' class='borde_tabla_contactos_int'>
		    		<input type='checkbox' id='checkall'/>Copiar a Todos
		    	</td>
		    </tr>
		    </tbody></table>";
		    return $d;
		}else{
		    return "Lo sentimos pero no se encontraron resultados";
		}
	}

	function getIdRepLegal(){
		if ( isset($this->IDREPLEGAL) )
			return $this->IDREPLEGAL;
		else 
	    	return 0;
	}
	
	function getNombreRepLegal(){
		if ( isset($this->NOMBREREPLEGAL) )
			return $this->NOMBREREPLEGAL;
		else
	    	return "No tiene";
	}
	
	function getNombreBanco(){
	    $sql = "SELECT B.`nombreBanco`
		    FROM `redefectiva`.`cat_banco` as B
		    INNER JOIN `redefectiva`.`inf_corresponsalbanco` as I on I.`idBanco` = B.`idBanco`
		    WHERE I.`idCorresponsal` = $this->ID
			AND I.`idEstatus` = 0;";
	    $res = $this->RBD->query($sql);
	    if($res != '' && mysqli_num_rows($res) > 0){
		$r = mysqli_fetch_array($res);
		return $r[0];
	    }
	    return "No tiene";
	}
	
	function getEstatusBancario(){
		if ( isset($this->CORRESPONSALBANCOESTATUS) )
			return $this->CORRESPONSALBANCOESTATUS;
		else
			return NULL;
	}
	
	function getDireccion(){
		if ( isset($this->DIRCALLE) && isset($this->DIRNEXT) && isset($this->DIRNINT) )
			return $this->DIRCALLE.' No. Ext. '.$this->DIRNEXT.' No. Int. '.$this->DIRNINT;
		else
	    	return "No tiene";
	}
	function getCalle(){
		if ( isset($this->DIRCALLE) )
			return $this->DIRCALLE;
		else
	    	return "No tiene";
	}
	
	function getDirNExt(){
		if ( isset($this->DIRNEXT) )
			return $this->DIRNEXT;
		else
	    	return "No tiene";
	}
	
	function getDirNExt2(){
		if ( isset($this->DIRNEXT) )
			return $this->DIRNEXT;
		else
	    	return "No tiene";
	}
	
	function getDirNInt(){
		if ( isset($this->DIRNINT) )
			return $this->DIRNINT;
		else
	    	return "No tiene";
	}
	
	function getDirNInt2(){
		if ( isset($this->DIRNINT) )
			return $this->DIRNINT;
		else
	    	return "No tiene";
	}
	
	function getColonia(){
		if ( isset($this->DIRNOMBRECOLONIA) )
			return $this->DIRNOMBRECOLONIA;
		else
	    	return "No tiene";
	}
	
	function getIdColonia(){
		if ( isset($this->DIRIDCOLONIA) )
			return $this->DIRIDCOLONIA;
		else
	    	return "No tiene";
	}	
	
	function getCiudad(){
		if ( isset($this->DIRNOMBRECIUDAD) )
			return $this->DIRNOMBRECIUDAD;
		else
	    	return "No tiene";
	}
	
	function getIdEstado(){
		if ( isset($this->DIRIDESTADO) )
			return $this->DIRIDESTADO;
		else
	    	return "No tiene";
	}
	
	function getEstado(){
		if ( isset($this->DIRNOMBREESTADO) )
			return $this->DIRNOMBREESTADO;
		else
	    	return "No tiene";
	}
	
	function getCodigoPostal(){
		if ( isset($this->DIRCODIGOPOSTAL) )
			return $this->DIRCODIGOPOSTAL;
		else
	    	return "No tiene";
	}
	
	function getPais(){
		if ( isset($this->DIRNOMBREPAIS) )
			return $this->DIRNOMBREPAIS;
		else
	    	return "No tiene";
	}
	function getIdPais(){
		if ( isset($this->DIRIDPAIS) )
			return $this->DIRIDPAIS;
		else
	    	return "No tiene";
	}
	
	function getMunicipio(){
		if ( isset($this->DIRNOMBRECIUDAD) )
			return $this->DIRNOMBRECIUDAD;	
		else
	    	return "No tiene";
	}
	
	function getIdCiudad(){
		if ( isset($this->DIRIDCIUDAD) )
			return $this->DIRIDCIUDAD;
		else
	    	return "No tiene";
	}	
	
	function acentos($txt){
		return (!preg_match("!!u", $txt))? utf8_encode($txt) : $txt;
	}

	function getNombreExpediente(){
		return (!empty($this->NOMBRE_EXPEDIENTE))? $this->acentos($this->NOMBRE_EXPEDIENTE) : 'N/A';
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
	
	function getTipoAcceso(){
	    /*$sql = "SELECT A.`descTipoAcceso`
	    	    FROM `nautilus`.`cat_tipoacceso` as A
		    INNER JOIN `nautilus`.`inf_clienteacceso` as I on I.`idTipoAcceso` = A.`idTipoAcceso`
		    WHERE I.`idSubCadena` = $this->IDSUBCADENA AND I.`idCorresponsal` = $this->ID ;";
	    $res = $this->RBD->query($sql);
	    if($res != '' && mysqli_num_rows($res) > 0){
		$r = mysqli_fetch_array($res);
		return "Acceso v&iacute;a $r[0]";
		 
	    }
	    return "Sin Accesos";*/

		if(!empty($this->DESCACCESO)){
			return "Acceso v&iacute;a ".$this->DESCACCESO;
		}
		else{
			return "Sin Accesos";
		}
	}
	
	function getCodigos(){
	    /*$sql = "SELECT `idCadena`,`idSubCadena`,`idCorresponsal`,`Codigo`
	    	    FROM `nautilus`.`conf_codigo`
		    WHERE (`idCadena` = $this->IDCADENA) AND (`idSubCadena` = $this->IDSUBCADENA OR `idSubCadena` = -1) AND (`idCorresponsal` = $this->ID OR `idCorresponsal` = -1)
		    ORDER BY `idCadena`,`idSubCadena`,`idCorresponsal`;";*/
	    $sql = "CALL `nautilus`.`SP_FIND_CODIGOS`(".$this->IDCADENA.", ".$this->IDSUBCADENA.", ".$this->ID.")";
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
	
    private function respuesta($codigoRespuesta = 1 ,$descRespuesta = "Error Generico", $Data = NULL){
	$RESPUESTA = array(
	    'codigoRespuesta' 	 => $codigoRespuesta, 
	    'descRespuesta' 	 => $descRespuesta,
	    'data' 				 => $Data
        );
	    
	 return $RESPUESTA;
    }
	
    function __destruct(){}

    public function getRFCContrato(){
    	return (!empty($this->RFC_CONTRATO))? $this->RFC_CONTRATO : '';
    }

    public function getConfPermisos($categoria){
		$sql = $this->RBD->query("CALL `redefectiva`.`SP_FIND_CATEGORIA_PERMISOS`(".$this->IDCADENA.",".$this->IDSUBCADENA.", ".$this->ID.")");

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