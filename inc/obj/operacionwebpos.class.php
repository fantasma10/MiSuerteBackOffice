<?php
####################################corresponsal.class####################################
//For break use "\n" instead '\n' 
class Operacionwa{ 

	public $IDSOPE, $TICKET, $IDFOLIO, $IDTRACE, $AUTOP, $EQUIPO, $IDCORR, $IDEMISOR, $IDFAM, $IDSFAM, $IDTRANTYPE, $SKU, $IMPOP, $COMCOB, $IDFLUJO, $REFOP1, $REFOP2, $REFOP3, $MSJOP, $INFOOP1, $INFOOP2, $INFOOP3, $OPERADOR, $CODOP, $DESCCODOP, $FECSOLOP, $FECRESPOP, $NIMPRESION, $IDESTATUS;
		
	public $COUNT;

    public $RBD,$WBD, $LOG;
		
	public function __construct($LOG,$RBD,$WBD) 
	{

		$this->RBD				=	$RBD;
		$this->LOG				=	$LOG;
		$this->WBD				=	$WBD;
		$this->IDSOPE			=	0;
		
		$this->TICKET			=	NULL;
		$this->IDFOLIO			=	NULL;
		$this->IDTRACE			=	NULL;
		$this->AUTOP			=	NULL;
		$this->EQUIPO			=	NULL;
		$this->IDCORR			=	NULL;
		$this->IDEMISOR			=	NULL;
		$this->IDFAM			=	NULL;
		$this->IDSFAM			=	NULL;
		$this->IDTRANTYPE		=	NULL;
		$this->SKU				=	NULL;
		$this->IMPOP			=	NULL;
		$this->COMCOB			=	NULL;
		$this->IDFLUJO			=	NULL;
		$this->REFOP1			=	NULL;
		$this->REFOP2			=	NULL;
		$this->REFOP3			=	NULL;
		$this->MSJOP			=	NULL;
		$this->INFOOP1			=	NULL;
		$this->INFOOP2			=	NULL;
		$this->INFOOP3			=	NULL;
		$this->OPERADOR			=	NULL;
		$this->CODOP			=	NULL;
		$this->DESCCODOP		=	NULL;
		$this->FECSOLOP			=	NULL;
		$this->FECRESPOP		=	NULL;
		$this->NIMPRESION		=	NULL;
		$this->IDESTATUS		=	NULL;
		
		$this->LOG->logMsg("Objeto Operacion creado");
	}
	
	public function load($ID)
	{ 	 	 	 		 	 	 	 	 	 	 	
		$SQL	=	"SELECT `idOperacion`, `numTicket`, `idFolio`, `idTrace`, `autorizacion`, `idEquipo`, `idCorresponsal`, `idEmisor`, `idFamilia`, `idSubFamilia`, `idTranType`, `skuProducto`, `importeOperacion`, `comCobrada`, `idFlujoImp`, `referencia1Operacion`, `referencia2Operacion`, `referencia3Operacion`, `mensajeOperacion`, `info1Operacion`, `info2Operacion`, `info3Operacion`, `idOperador`, `codigoRespuesta`, `descCodigoRespuesta`, `fecSolicitudOperacion`, `fecRespuestaOperacion`, `nImpresion`, `idEstatusOperacion` FROM `data_webpos`.`aps_operacion` WHERE `idOperacion` = '$ID';";
		
		$Result		=	$this->RBD->query($SQL);
		if($Result){
			if(mysqli_num_rows($Result) > 0)
			{
				list(
					$this->IDSOPE,
					$this->TICKET,
					$this->IDFOLIO,
					$this->IDTRACE,
					$this->AUTOP,
					$this->EQUIPO,
					$this->IDCORR,
					$this->IDEMISOR,
					$this->IDFAM,
					$this->IDSFAM,
					$this->IDTRANTYPE,
					$this->SKU,
					$this->IMPOP,
					$this->COMCOB,
					$this->IDFLUJO,
					$this->REFOP1,
					$this->REFOP2,
					$this->REFOP3,
					$this->MSJOP,
					$this->INFOOP1,
					$this->INFOOP2,
					$this->INFOOP3,
					$this->OPERADOR,
					$this->CODOP,
					$this->DESCCODOP,
					$this->FECSOLOP,
					$this->FECRESPOP,
					$this->NIMPRESION,
					$this->IDESTATUS 
				) = mysqli_fetch_array($Result);
				 return self::respuesta(0,"Operaci&oacute;n Cargada con exito"); 
			}else{	
				return self::respuesta(2,"No se encontro operaci&oacute;n"); 
			}
		}else{return self::respuesta(2,"No se encontro operaci&oacute;n");}
	}
		
	function getidOperacion(){
		return $this->IDSOPE;
	}
	
	public function setnumTicket($numTicket)
	{
			$this->TICKET	=	trim($numTicket);
	}
	
	function getnumTicket(){
		return $this->TICKET;
	}
	
	public function setidFolio($idFolio)
	{
			$this->IDFOLIO	=	trim($idFolio);
	}
	
	function getidFolio(){
		return $this->IDFOLIO;
	}
	
	public function setidTrace($idTrace)
	{
			$this->IDTRACE	=	trim($idTrace);
	}
	
	function getidTrace(){
		return $this->IDTRACE;
	}
	
	public function setautorizacion($autorizacion)
	{
			$this->AUTOP	=	trim($autorizacion);
	}
	
	function getautorizacion(){
		if($this->AUTOP==''){ return 'No Tiene';}
		else{ return $this->AUTOP;}
	}
	
	
	
	public function setidEquipo($idEquipo)
	{
			$this->EQUIPO	=	trim($idEquipo);
	}
	
	function getidEquipo(){
		return $this->EQUIPO;
	}
	
	public function setidCorresponsal($idCorresponsal)
	{
			$this->IDCORR	=	trim($idCorresponsal);
	}
	
	function getidCorresponsal(){
		return $this->IDCORR;
	}
	
	function getNombreCorresposnal(){
		 $QUERY = "SELECT `nombreCorresponsal` FROM `dat_corresponsal` WHERE `idCorresponsal` = '".$this->IDCORR."';";
					$result = $this->RBD->query($QUERY);
					list($nom)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($nom);
	}
	
	public function setidEmisor($idEmisor)
	{
			$this->IDEMISOR	=	trim($idEmisor);
	}
	
	function getidEmisor(){
		return $this->IDEMISOR;
	}
	
	function getNombreEmisor(){
		 $QUERY = "SELECT `descEmisor` FROM `cat_emisor` WHERE `idEmisor` = '".$this->IDEMISOR."';";
					$result = $this->RBD->query($QUERY);
					list($desc)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($desc);
	}
	
	function getNombreEmisorcID($idEmisor){
		 $QUERY = "SELECT `descEmisor` FROM `cat_emisor` WHERE `idEmisor` = '$idEmisor';";
					$result = $this->RBD->query($QUERY);
					list($desc)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($desc);
	}
	
	public function setidFamilia($idFamilia)
	{
			$this->IDFAM	=	trim($idFamilia);
	}
	
	function getidFamilia(){
		return $this->IDFAM;
	}
	
	function getNombreFamilia(){
		 $QUERY = "SELECT `descFamilia` FROM `cat_familia` WHERE `idFamilia` = '".$this->IDFAM."';";
					$result = $this->RBD->query($QUERY);
					list($desc)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($desc);
	}
	
	public function setidSubFamilia($idSubFamilia)
	{
			$this->IDSFAM	=	trim($idSubFamilia);
	}
	
	function getidSubFamilia(){
		return $this->IDSFAM;
	}
	
	function getNombreSubFamilia(){
		 $QUERY = "SELECT `descSubFamilia` FROM `cat_subfamilia` WHERE `idFamilia` = '".$this->IDSFAM."';";
					$result = $this->RBD->query($QUERY);
					list($desc)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($desc);
	}
	
	public function setidTranType($idTranType)
	{
			$this->IDTRANTYPE	=	trim($idTranType);
	}
	
	function getidTranType(){
		return $this->IDTRANTYPE;
	}
	
	function getNombreTranType(){
		 $QUERY = "SELECT `descTranType` FROM `cat_trantype` WHERE `idTranType` = '".$this->IDTRANTYPE."';";
					$result = $this->RBD->query($QUERY);
					list($desc)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($desc);
	}
	
	public function setskuProducto($skuProducto)
	{
			$this->SKU	=	trim($skuProducto);
	}
	
	function getskuProducto(){
		return $this->SKU; 
	}
	
	public function setimporteOperacion($importeOperacion)
	{
			$this->IMPOP	=	trim($importeOperacion);
	}
	
	function getimporteOperacion(){
		return $this->IMPOP;
	}
	
	public function setcomCobrada($comCobrada)
	{
			$this->COMCOB	=	trim($comCobrada);
	}
	
	function getcomCobrada(){
		return $this->COMCOB;
	}
	
	public function setidFlujoImp($idFlujoImp)
	{
			$this->IDFLUJO	=	trim($idFlujoImp);
	}
	
	function getidFlujoImp(){
		return $this->IDFLUJO;
	}
	
	function getdescFlujo(){
		 $QUERY = "SELECT `descFlujo` FROM `cat_flujo` WHERE `idFlujo` = '".$this->IDFLUJO."';";
					$result = $this->RBD->query($QUERY);
					list($desc)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($desc);
	}
	
	public function setreferencia1Operacion($referencia1Operacion)
	{
			$this->REFOP1	=	trim($referencia1Operacion);
	}
	
	function getreferencia1Operacion(){
		if($this->REFOP1==''){ return 'No Tiene';}
		else{ return $this->REFOP1;}
	}
	
	public function setreferencia2Operacion($referencia2Operacion)
	{
			$this->REFOP2	=	trim($referencia2Operacion);
	}
	
	function getreferencia2Operacion(){
		if($this->REFOP2==''){ return 'No Tiene';}
		else{ return $this->REFOP2;}
	}
	
	public function setreferencia3Operacion($referencia3Operacion)
	{
			$this->REFOP3	=	trim($referencia3Operacion);
	}
	
	function getreferencia3Operacion(){
		if($this->REFOP3==''){ return 'No Tiene';}
		else{ return $this->REFOP3;}
	}
	
	public function setmensajeOperacion($mensajeOperacion)
	{
			$this->MSJOP	=	trim($mensajeOperacion);
	}
	
	function getmensajeOperacion(){
		return $this->MSJOP;
	}
	
	public function setinfo1Operacion($info1Operacion)
	{
			$this->INFOOP1	=	trim($info1Operacion);
	}
	
	function getinfo1Operacion(){
		if($this->INFOOP1==''){ return 'No Tiene';}
		else{ return $this->INFOOP1;}
	}
	
	public function setinfo2Operacion($info2Operacion)
	{
			$this->INFOOP2	=	trim($info2Operacion);
	}
	
	function getinfo2Operacion(){
		if($this->INFOOP2==''){ return 'No Tiene';}
		else{ return $this->INFOOP2;}
	}
	
	public function setinfo3Operacion($info3Operacion)
	{
			$this->INFOOP3	=	trim($info3Operacion);
	}
	
	function getinfo3Operacion(){
		if($this->INFOOP3==''){ return 'No Tiene';}
		else{ return $this->INFOOP3;}
	}
	
	public function setidOperador($idOperador)
	{
			$this->OPERADOR	=	trim($idOperador);
	}
	
	function getidOperador(){
		return $this->OPERADOR;
	}
	
	function getnombreOperador(){
		 $QUERY = "SELECT `nombreOperador`, `paternoOperador` FROM `data_webpos`.`aps_operador` WHERE `idOperador` = '".$this->OPERADOR."';";
					$result = $this->RBD->query($QUERY);
					list($nom,$app)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($nom.' '.$app);
	}
	
	public function setcodigoRespuesta($codigoRespuesta)
	{
			$this->CODOP	=	trim($codigoRespuesta);
	}
	
	function getcodigoRespuesta(){
		return $this->CODOP;
	}
	
	public function setdescCodigoRespuesta($descCodigoRespuesta)
	{
			$this->DESCCODOP	=	trim($descCodigoRespuesta);
	}
	
	function getdescCodigoRespuesta(){
		return $this->DESCCODOP;
	}
	
	public function setfecSolicitudOperacion($fecSolicitudOperacion)
	{
			$this->FECSOLOP	=	trim($fecSolicitudOperacion);
	}
	
	function getfecSolicitudOperacion(){
		return $this->FECSOLOP;
	}
	
	public function setfecRespuestaOperacion($fecRespuestaOperacion)
	{
			$this->FECRESPOP	=	trim($fecRespuestaOperacion);
	}
	
	function getfecRespuestaOperacion(){
		return $this->FECRESPOP;
	}
	
	public function setnImpresion($nImpresion)
	{
			$this->NIMPRESION	=	trim($nImpresion);
	}
	
	function getnImpresion(){
		return $this->NIMPRESION;
	}

	public function setidEstatusOperacion($idEstatusOperacion)
	{
			$this->IDESTATUS	=	trim($idEstatusOperacion);
	}
	
	function getidEstatusOperacion(){
		return $this->IDESTATUS;
	}
	
	function getNombreEstatus(){
		if($this->IDESTATUS==1){ return "Incompleta";}
		else{ if($this->IDESTATUS==0){return "Exitosa";}
		else{ return "Rechazada"; }} 
	}
					
	function actualizar($AtribA,$valor,$id,$idEmp){
			
			trim($AtribA);trim($valor);trim($id);trim($idEmp);
			
			$sql = "UPDATE `data_webpos`.`aps_operacion` SET `$AtribA` = '".utf8_decode($valor)."' WHERE `idOperacion` = '$id';";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();*/
			
			echo "Actualizaci&oacute;n exitosa";
	}
	
	function eliminar($id,$idEmp){
			
			$sql = "UPDATE `data_webpos`.`aps_operacion` SET `idEstatusOperacion` = '3' WHERE `idOperacion` = '$id';";
			
			$result = $this->RBD->query($sql);
			
			echo "Se Elimin&oacute;";	
	}
	
	function generar(){
		$QUERY = "SELECT MAX( `idOperacion` ) FROM `data_webpos`.`aps_operacion`;";
		$result = $this->RBD->query($QUERY);
		list($idMax)= mysqli_fetch_row($result);
				
		echo $idMax;
	}	
	
	/*
	function insertar(){
	$sQuery="";
	$aAfectados=null;
		if ($this->TICKET == NULL OR $this->SKU == NULL)
			exit("Operacion->insertar(): error de codificaci&oacute;n, faltan datos");
		else{
			if ($this->RBD){
		 		$sQuery = "INSERT INTO `ops_operacion` (`idCadena`, `idSubCadena`, `idCorresponsal`, `numCuenta`, `ticket`, `idMovimiento`, `idCancelacion`, `idEmisor`, `idTranType`, `idRuta`, `idConector`, `idProducto`, `idProveedor`, `skuProveedor`, `traceProveedor`, `procesador`, `equipo`, `operador`, `sku`, `totComCorresponsal`, `totComCliente`, `totCostoOperacion`, `totComOperacion`, `importeOperacion`, `referenciaOperacion`, `autorizacionOperacion`, `respuestaOperacion`, `perIvaOperacion`, `fecSolicitudOperacion`, `fecAplicacionOperacion`, `idEstatusOperacion`, `fecConOperacion`) 
				VALUES (".$this->IDCAD.",
				 ".$this->IDSUBCAD.",
				  ".$this->IDCORR.",
				   '".$this->NUMCUENTA."',
				    '".$this->TICKET."',
					 ".$this->IDMOV.",
					  ".$this->IDCANCEL.",
					   ".$this->IDEMISOR.",
					    '".$this->IDTRANTYPE."',
						 ".$this->IDRUTA.",
						  ".$this->IDCONECT.",
						   ".$this->IDPROD.",
						    ".$this->IDPROV.",
							 '".$this->SKUPROV."',
							  ".$this->TRACEPROV.",
							   '".$this->PROCESADOR."',
							    '".$this->EQUIPO."',
								 '".$this->OPERADOR."',
								  '".$this->SKU."',
								   ".$this->TOTCOMCORR.",
								    ".$this->TOTCOMCLI.",
									 ".$this->TOTCOSTOP.",
									  ".$this->TOTCOMOP.",
									   ".$this->IMPOP.",
									    '".$this->REFOP."',
										 '".$this->AUTOP."',
										  ".$this->RESPOP.",
										   ".$this->PERIVAOP.",
										    '".$this->FECSOLICOP."',
											 '".$this->FECAPLICOP."',
											  ".$this->IDESTATUSOP.",
											   '".$this->FECCONOP."');";
				$aAfectados = $this->RBD->query($sQuery);
				if($aAfectados){return $aAfectados;}else{return -1;}					
			}else{
				return -1;
			}
		}
	}	
	*/
	
	
	private function respuesta($codigoRespuesta = 1 ,$descRespuesta = "Error Generico", $Data = NULL)
	{
			$RESPUESTA = array(
			'codigoRespuesta' 	 => $codigoRespuesta, 
			'descRespuesta' 	 => $descRespuesta,
			'data' 				 => $Data
		);
		
		return $RESPUESTA;
	}
	
	function __destruct() {	}
}
?>