<?php
####################################corresponsal.class####################################
//For break use "\n" instead '\n' 
class Operacion{ 

	public $IDSOPE, $IDCAD, $IDSUBCAD, $IDCORR, $IDFAM, $IDSFAM, $FECALTAOP, $NUMCUENTA, $TICKET, $IDMOV, $IDCANCEL, $IDEMISOR, $IDTRANTYPE, $IDRUTA, $IDCONECT, $IDPROD, $IDPROV, $SKUPROV, $TRACEPROV, $PROCESADOR, $EQUIPO, $OPERADOR, $SKU, $TOTCOMCORR, $TOTCOMCLI, $TOTCOSTOP, $TOTCOMOP, $IMPOP, $IDFLUJO, $REFOP1, $REFOP2, $REFOP3, $AUTOP, $RESPOP, $PERIVAOP, $FECSOLICOP, $FECAPLICOP, $IDESTATUSOP, $FECCONOP, $FECCANOP, $TOTCOSTTRAN;
		
	public $COUNT;

    public $RBD,$WBD, $LOG;
	
	public function __construct($LOG,$RBD,$WBD) 
	{

		$this->RBD				=	$RBD;
		$this->LOG				=	$LOG;
		$this->WBD				=	$WBD;
		$this->IDSOPE			=	0;
		
		$this->IDCAD			=	NULL;
		$this->IDSUBCAD			=	NULL;
		$this->IDCORR			=	NULL;
		$this->IDFAM			=	NULL;
		$this->IDSFAM			=	NULL;
		$this->FECALTAOP		=	NULL;
		$this->NUMCUENTA		=	NULL;
		$this->TICKET			=	NULL;
		$this->IDMOV			=	NULL;
		$this->IDCANCEL			=	NULL;
		$this->IDEMISOR			=	NULL;
		$this->IDTRANTYPE		=	NULL;
		$this->IDRUTA			=	NULL;
		$this->IDCONECT			=	NULL;
		$this->IDPROD			=	NULL;
		$this->IDPROV			=	NULL;
		$this->SKUPROV			=	NULL;
		$this->TRACEPROV		=	NULL;
		$this->EQUIPO			=	NULL;
		$this->OPERADOR			=	NULL;
		$this->SKU				=	NULL;
		$this->TOTCOMCORR		=	NULL;
		$this->TOTCOMCLI		=	NULL;
		$this->TOTCOSTOP		=	NULL;
		$this->TOTCOMOP			=	NULL;
		$this->IMPOP			=	NULL;
		$this->IDFLUJO			=	NULL;
		$this->REFOP1			=	NULL;
		$this->REFOP2			=	NULL;
		$this->REFOP3			=	NULL;
		$this->AUTOP			=	NULL;
		$this->RESPOP			=	NULL;
		$this->PERIVAOP			=	NULL;
		$this->FECSOLICOP		=	NULL;
		$this->FECAPLICOP		=	NULL;
		$this->IDESTATUSOP		=	NULL;
		$this->FECCONOP			=	NULL;
		$this->FECCANOP			=	NULL;
		$this->TOTCOSTTRAN		=	NULL;
		
		$this->LOG->logMsg("Objeto Operacion creado");
	}
	
	public function load($ID)
	{ 	 	 	 		 	 	 	 	 	 	 	
		$SQL	=	"SELECT `idsOperacion`, `idCadena`, `idSubCadena`, `idCorresponsal`, `idFamilia`, `idSubFamilia`, `fecAltaOperacion`, `numCuenta`, `ticket`, `idMovimiento`, `idCancelacion`, `idEmisor`, `idTranType`, `idRuta`, `idConector`, `idProducto`, `idProveedor`, `skuProveedor`, `traceProveedor`, `idEquipo`, `idOperador`, `sku`,  `totComCorresponsal`, `totComCliente`, `totCostoOperacion`, `totComOperacion`, `importeOperacion`, `idFlujoImp`, `referencia1Operacion`, `referencia2Operacion`, `referencia3Operacion`, `autorizacionOperacion`, `respuestaOperacion`, `perIvaOperacion`, `fecSolicitudOperacion`, `fecAplicacionOperacion`, `idEstatusOperacion`, `fecConOperacion`, `fecCanOperacion`, `totCostoTransaccion` FROM `ops_operacion` WHERE `idsOperacion` = '$ID';";
		
		$Result		=	$this->RBD->query($SQL);
		if($Result){
			if(mysqli_num_rows($Result) > 0)
			{
				list(
					$this->IDSOPE,
					$this->IDCAD,
					$this->IDSUBCAD,
					$this->IDCORR,
					$this->IDFAM,
					$this->IDSFAM,
					$this->FECALTAOP,
					$this->NUMCUENTA,
					$this->TICKET,
					$this->IDMOV,
					$this->IDCANCEL,
					$this->IDEMISOR,
					$this->IDTRANTYPE,
					$this->IDRUTA,
					$this->IDCONECT,
					$this->IDPROD,
					$this->IDPROV,
					$this->SKUPROV,
					$this->TRACEPROV,
					$this->EQUIPO,
					$this->OPERADOR,
					$this->SKU,
					$this->TOTCOMCORR,
					$this->TOTCOMCLI,
					$this->TOTCOSTOP,
					$this->TOTCOMOP,
					$this->IMPOP,
					$this->IDFLUJO,
					$this->REFOP1,
					$this->REFOP2,
					$this->REFOP3,
					$this->AUTOP,
					$this->RESPOP,
					$this->PERIVAOP,
					$this->FECSOLICOP,
					$this->FECAPLICOP,
					$this->IDESTATUSOP,
					$this->FECCONOP,
					$this->FECCANOP,
					$this->TOTCOSTTRAN
				) = mysqli_fetch_array($Result);
				 return self::respuesta(0,"Operaci&oacute;n Cargada con Exito"); 
			}else{	
				return self::respuesta(2,"No se encontro Operaci&oacute;n"); 
			}
		}else{return self::respuesta(2,"No se encontro Operaci&oacute;n");}
	}
		
	function getidsOperacion(){
		return $this->IDSOPE;
	}
	
	public function setidCadena($idCadena)
	{
			$this->IDCAD	=	trim($idCadena);
	}
	
	function getidCadena(){
		return $this->IDCAD;
	}
	
	function getNombreCadena(){
		 $QUERY = "SELECT `nombreCadena` FROM `dat_cadena` WHERE `idCadena` = '".$this->IDCAD."';";
					$result = $this->RBD->query($QUERY);
					list($nom)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($nom);
	}
	
	public function setidSubCadena($idSubCadena)
	{
			$this->IDSUBCAD	=	trim($idSubCadena);
	}
	
	function getidSubCadena(){
		return $this->IDSUBCAD;
	}
	
	function getNombreSubCadena(){
		 $QUERY = "SELECT `nombreSubCadena` FROM `dat_subcadena` WHERE `idSubCadena` = '".$this->IDSUBCAD."';";
					$result = $this->RBD->query($QUERY);
					list($nom)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($nom);
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
	
	public function setfecAltaOperacion($fecAltaOperacion)
	{
			$this->FECALTAOP	=	trim($fecAltaOperacion);
	}
	
	function getfecAltaOperacion(){
		return $this->FECALTAOP;
	}
	
	public function setnumCuenta($numCuenta)
	{
			$this->NUMCUENTA	=	trim($numCuenta);
	}
	
	function getnumCuenta(){
		return $this->NUMCUENTA; 
	}
	
	public function setticket($ticket)
	{
			$this->TICKET	=	trim($ticket);
	}
	
	function getticket(){
		return $this->TICKET;
	}
	
	public function setidMovimiento($idMovimiento)
	{
			$this->IDMOV	=	trim($idMovimiento);
	}
	
	function getidMovimiento(){
		return $this->IDMOV;
	}
	
	public function setidCancelacion($idCancelacion)
	{
			$this->IDCANCEL	=	trim($idCancelacion);
	}
	
	function getidCancelacion(){
		return $this->IDCANCEL;
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
	
	public function setidRuta($idRuta)
	{
			$this->IDRUTA	=	trim($idRuta);
	}
	
	function getidRuta(){
		return $this->IDRUTA;
	}
	
	public function setidConector($idConector)
	{
			$this->IDCONECT	=	trim($idConector);
	}
	
	function getidConector(){
		return $this->IDCONECT;
	}
	
	public function setidProducto($idProducto)
	{
			$this->IDPROD	=	trim($idProducto);
	}
	
	function getidProducto(){
		return $this->IDPROD;
	}
	
	function getNombreProd(){
		 $QUERY = "SELECT `descProducto` FROM `dat_producto` WHERE `idProducto` = '".$this->IDPROD."';";
					$result = $this->RBD->query($QUERY);
					list($desc)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($desc);
	}
	
	public function setidProveedor($idProveedor)
	{
			$this->IDPROV	=	trim($idProveedor);
	}
	
	function getidProveedor(){
		return $this->IDPROV;
	}
	
	function getNombreProv(){
		$QUERY = "SELECT `nombreProveedor` FROM `dat_proveedor` WHERE `idProveedor` = '".$this->IDPROV."';";
					$result = $this->RBD->query($QUERY);
					list($nom)= mysqli_fetch_row($result);
					mysqli_free_result($result);
		
		return htmlentities($nom);
	}
	
	public function setskuProveedor($skuProveedor)
	{
			$this->SKUPROV	=	trim($skuProveedor);
	}
	
	function getskuProveedor(){
		return $this->SKUPROV;
	}
	
	public function settraceProveedor($traceProveedor)
	{
			$this->TRACEPROV	=	trim($traceProveedor);
	}
	
	function gettraceProveedor(){
		return $this->TRACEPROV;
	}
	
	public function setprocesador($procesador)
	{
			$this->PROCESADOR	=	trim($procesador);
	}
	
	function getprocesador(){
		return $this->PROCESADOR;
	}

	public function setequipo($equipo)
	{
			$this->EQUIPO	=	trim($equipo);
	}
	
	function getequipo(){
		return $this->EQUIPO;
	}
	
	public function setoperador($operador)
	{
			$this->OPERADOR	=	trim($operador);
	}
	
	function getoperador(){
		return $this->OPERADOR;
	}
	
	public function setsku($sku)
	{
			$this->SKU	=	trim($sku);
	}
	
	function getsku(){
		return $this->SKU;
	}
	
	public function settotComCorresponsal($totComCorresponsal)
	{
			$this->TOTCOMCORR	=	trim($totComCorresponsal);
	}
	
	function gettotComCorresponsal(){
		return $this->TOTCOMCORR;
	}
	
	public function settotComCliente($totComCliente)
	{
			$this->TOTCOMCLI	=	trim($totComCliente);
	}
	
	function gettotComCliente(){
		return $this->TOTCOMCLI;
	}

	public function settotCostoOperacion($totCostoOperacion)
	{
			$this->TOTCOSTOP	=	trim($totCostoOperacion);
	}
	
	function gettotCostoOperacion(){
		return $this->TOTCOSTOP;
	}
	
	public function settotComOperacion($totComOperacion)
	{
		$this->TOTCOMOP	= trim($totComOperacion);
	}
	
	function gettotComOperacion(){
		return $this->TOTCOMOP;
	}

	public function setimporteOperacion($importeOperacion)
	{
			$this->IMPOP	=	trim($importeOperacion);
	}
	
	function getimporteOperacion(){
		return $this->IMPOP;//+$this->TOTCOMCLI
	}
	
	function getimporteOperacionTotal(){
		return $this->IMPOP+$this->TOTCOMCLI;
	}
	
	public function setidFlujo($idFlujo)
	{
			$this->IDSFAM	=	trim($idFlujo);
	}
	
	function getidFlujo(){
		return $this->IDSFAM;
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
	
	function getreferenciaOperacion(){
		if($this->REFOP1==''){ return 'No Tiene';}
		else{ return $this->REFOP1.'|'.$this->REFOP2.'|'.$this->REFOP3;}
	}
	
	public function setautorizacionOperacionn($autorizacionOperacion)
	{
			$this->AUTOP	=	trim($autorizacionOperacion);
	}
	
	function getautorizacionOperacion(){
		if($this->AUTOP==''){ return 'No Tiene';}
		else{ return $this->AUTOP;}
	}

	public function setrespuestaOperacion($respuestaOperacion)
	{
			$this->RESPOP	=	trim(utf8_decode($respuestaOperacion));
	}
	
	function getrespuestaOperacion(){
		return htmlentities($this->RESPOP);
	}
	
	public function setperIvaOperacion($perIvaOperacion)
	{
			$this->PERIVAOP	=	trim($perIvaOperacion);
	}
	
	function getperIvaOperacion(){
		return $this->PERIVAOP;
	}
	
	public function setfecSolicitudOperacion($fecSolicitudOperacion)
	{
			$this->FECSOLICOP	=	trim($fecSolicitudOperacion);
	}
	
	function getfecSolicitudOperacion(){
		return $this->FECSOLICOP;
	}
	
	public function setfecAplicacionOperacion($fecAplicacionOperacion)
	{
			$this->FECAPLICOP	=	trim($fecAplicacionOperacion);
	}
	
	function getfecAplicacionOperacion(){
		return $this->FECAPLICOP;
	}
	
	public function setidEstatusOperacion($idEstatusOperacion)
	{
			$this->IDESTATUSOP	=	trim($idEstatusOperacion);
	}
	
	function getidEstatusOperacion(){
		return $this->IDESTATUSOP;
	}
	
	function getNombreEstatus(){
		if($this->IDESTATUSOP==1){ return "Incompleta";}
		else{ if($this->IDESTATUSOP==0){return "Exitosa";}
		else{ return "Rechazada"; }} 
		 //$QUERY = "SELECT `descEstatus` FROM `cat_estatus` WHERE `idEstatus` = ".$this->IDESTATUSOP."";
		//			$result = $this->RBD->query($QUERY);
		//			list($nomEstatus)= mysqli_fetch_row($result);
		//			mysqli_free_result($result);
		
		//return $nomEstatus;
	}
	
	public function setfecConOperacion($fecConOperacion)
	{
			$this->FECCONOP	=	trim($fecConOperacion);
	}
	
	function getfecConOperacion(){
		return $this->FECCONOP;
	}
	
	public function setfecCanOperacion($fecCanOperacion)
	{
			$this->FECCANOP	=	trim($fecCanOperacion);
	}
	
	function getfecCanOperacion(){
		return $this->FECCANOP;
	}
	
	public function settotCostoTransaccion($totCostoTransaccion)
	{
			$this->TOTCOSTTRAN	=	trim($totCostoTransaccion);
	}
	
	function gettotCostoTransaccion(){
		return $this->TOTCOSTTRAN;
	}
					
	function actualizar($AtribA,$valor,$id,$idEmp){
			
			trim($AtribA);trim($valor);trim($id);trim($idEmp);
			
			$sql = "UPDATE `mops_operacion` SET `$AtribA` = '".utf8_decode($valor)."' WHERE `idsOperacion` = '$id';";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();*/
			
			echo "Actualizaci&oacute;n Exitosa";
	}
	
	function eliminar($id,$idEmp){
			
			$sql = "UPDATE `mops_operacion` SET `idEstatusOperacion` = '3' WHERE `idsOperacion` = '$id';";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();
			
			//================
			$sql_e2 = "SELECT `idCadenaEjecutivo` FROM `inf_cadenaejecutivo` WHERE `idEjecutivo`='$id'";
			$res2 = $this->RBD->query($sql_e2);
			while(list($idCE)=mysqli_fetch_row($res2))
			{
				$sql_e2CE = "UPDATE `inf_cadenaejecutivo` SET `idEstatusCadenaEjecutivo`=3,`idEmpleado`='$idEmp' WHERE `idCadenaEjecutivo`='$idCE'";
				$res22 = $this->RBD->ejecutarComando($sql_e2CE);
			} 
			mysqli_free_result($res2);
			//================
			$sql_e3 = "SELECT `idCorresponsalEjecutivo` FROM `inf_corresponsalejecutivo` WHERE `idEjecutivo`='$id'";
			$res3 = $this->RBD->query($sql_e3);
			while(list($idCorE)=mysqli_fetch_row($res3))
			{
				$sql_e3CorE = "UPDATE `inf_corresponsalejecutivo` SET `idEstatusCorEjec`=3,`idEmpleado`='$idEmp' WHERE `idCorresponsalEjecutivo`='$idCorE'";
				$res32 = $this->RBD->ejecutarComando($sql_e3CorE);
			} 
			mysqli_free_result($res3);*/
			//================
			
			
			echo "Se Elimin&oacute; el Ejecutivo";	
	}
	//sin funcion
	function eliminarDireccionParaEjecutivo($idDir,$IdEjec,$idEmp){
			
			$sql = "UPDATE `inf_ejecutivodireccion` SET `idEstatusEjecDir` = 3, `idEmpleado` = '$idEmp' WHERE `idDireccion` = '$idDir' AND `idEjecutivo` = '$IdEjec';";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();*/
			
			echo "Se Dio de Baja la Direcci&oacute;n";	
	}
	
	function generar(){
		$QUERY = "SELECT MAX( `idsOperacion` ) FROM `mops_operacion`;";
		$result = $this->RBD->query($QUERY);
		list($idMax)= mysqli_fetch_row($result);
				
		echo $idMax;
	}	
	
	
	function insertar(){
	$sQuery="";
	$aAfectados=null;
		if ($this->TICKET == NULL OR $this->SKU == NULL)
			exit("Operacion->insertar(): error de codificaci&oacute;n, faltan datos");
		else{
			if ($this->RBD){
		 		$sQuery = "INSERT INTO `mops_operacion` (`idCadena`, `idSubCadena`, `idCorresponsal`, `numCuenta`, `ticket`, `idMovimiento`, `idCancelacion`, `idEmisor`, `idTranType`, `idRuta`, `idConector`, `idProducto`, `idProveedor`, `skuProveedor`, `traceProveedor`, `procesador`, `equipo`, `operador`, `sku`, `totComCorresponsal`, `totComCliente`, `totCostoOperacion`, `totComOperacion`, `importeOperacion`, `referenciaOperacion`, `autorizacionOperacion`, `respuestaOperacion`, `perIvaOperacion`, `fecSolicitudOperacion`, `fecAplicacionOperacion`, `idEstatusOperacion`, `fecConOperacion`) 
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