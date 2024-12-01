<?php
####################################corresponsal.class####################################
//For break use "\n" instead '\n' 
class Ejecutivo{ 
        
        private $RBD,$WBD;
        
	public $IDEJECUTIVO, $NOMBREEJECUTIVO, $APPATERNO, $APMATERNO, $USUARIOEJECUTIVO, $CONTRASENIAEJECUTIVO, $FECHANACEJECUTIVO, $NUMTELEJECUTIVO, $NUMCELEJECUTIVO, $CORREOEXTEJECUTIVO, $IDCTIPOEJECUTIVO, $FECALTAEJECUTIVO, $FECVIGENCIAEJECUTIVO, $IDCESTATUS, $FECMOV, $IDEMP;
        
	public $COUNT;
	
	public function __construct($r,$w) 
	{
            $this->RBD			=	$r;
            $this->WBD			=	$w;
            $this->IDEJECUTIVO		=	0;
            
            $this->NOMBREEJECUTIVO	=	NULL;
            $this->APPATERNO		=	NULL;
            $this->APMATERNO		=	NULL;
            $this->USUARIOEJECUTIVO	=	NULL;
            $this->CONTRASENIAEJECUTIVO	=	NULL;
            $this->FECHANACEJECUTIVO	=	NULL;
            $this->NUMTELEJECUTIVO	=	NULL;
            $this->NUMCELEJECUTIVO	=	NULL;
            $this->CORREOEXTEJECUTIVO	=	NULL;
            $this->IDCTIPOEJECUTIVO	=	NULL;
            $this->FECALTAEJECUTIVO	=	NULL;
            $this->FECVIGENCIAEJECUTIVO	=	NULL;
            $this->IDCESTATUS		=	NULL;
            $this->FECMOV		=	NULL;
            $this->IDEMP		=	NULL;
            
            //$this->LOG->logMsg("Objeto Ejecutivo creado");
	}
	
	public function load($IDEJECUTIVO)
	{ 	 	 	 	 	 	 	 	 	 	 	 	 	
            $SQL = "CALL `redefectiva`.SPA_LOADEJECUTIVO('$IDEJECUTIVO');";
            
            $Result = $this->RBD->SP($SQL);
            if($Result){
                if(mysqli_num_rows($Result) > 0)
                {
                    list(
                        $this->IDEJECUTIVO,
                        $this->NOMBREEJECUTIVO,
                        $this->APPATERNO,
                        $this->APMATERNO,
                        $this->USUARIOEJECUTIVO, 
                        $this->CONTRASENIAEJECUTIVO, 
                        $this->FECHANACEJECUTIVO,
                        $this->NUMTELEJECUTIVO,
                        $this->NUMCELEJECUTIVO,
                        $this->CORREOEXTEJECUTIVO,
                        $this->IDCTIPOEJECUTIVO,
                        $this->FECALTAEJECUTIVO,
                        $this->FECVIGENCIAEJECUTIVO,
                        $this->IDCESTATUS,
                        $this->FECMOV,
                        $this->IDEMP
                    ) = mysqli_fetch_array($Result);
                     return self::respuesta(0,"Ejecutivo Cargado con Exito",$this->IDEJECUTIVO); 
                }else{	
                        return self::respuesta(2,"No se encontro Ejecutivo",$IDEJECUTIVO); 
                }
            }else{return self::respuesta(2,"No se encontro Ejecutivo",$IDEJECUTIVO);}
	}
	
	function getidEjecutivo(){
	    return $this->IDEJECUTIVO;
	}
	
	public function setnombreEjecutivo($nombreEjecutivo)
	{
	    $this->NOMBREEJECUTIVO	=	trim(utf8_decode($nombreEjecutivo));
	}
	
	function getnombreEjecutivo(){
	    return htmlentities($this->NOMBREEJECUTIVO);
	}
	
	public function setapPaternoEjecutivo($apPaternoEjecutivo)
	{
	    $this->APPATERNO	=	trim(utf8_decode($apPaternoEjecutivo));
	}
	
	function getapPaternoEjecutivo(){
	    return htmlentities($this->APPATERNO);
	}
	
	public function setapMaternoEjecutivo($apMaternoEjecutivo)
	{
	    $this->APMATERNO	=	trim(utf8_decode($apMaternoEjecutivo));
	}
	
	function getapMaternoEjecutivo(){
	    return htmlentities($this->APMATERNO);
	}
	
	public function setusuarioEjecutivo($usuarioEjecutivo)
	{
	    $this->USUARIOEJECUTIVO	=	trim(utf8_decode($usuarioEjecutivo));
	}
	
	function getusuarioEjecutivo(){
            return htmlentities($this->USUARIOEJECUTIVO);
	}
	
	public function setcontraseniaEjecutivo($contraseniaEjecutivo)
	{
	    $this->CONTRASENIAEJECUTIVO	=	trim(utf8_decode($contraseniaEjecutivo));
	}
	
	function getcontraseniaEjecutivo(){
	    return htmlentities($this->CONTRASENIAEJECUTIVO);
	}
	
	public function setfecNacEjecutivo($fecNacEjecutivo)
	{
	    $this->FECHANACEJECUTIVO	=	trim($fecNacEjecutivo);
	}
	
	function getfecNacEjecutivo(){
	    return $this->FECHANACEJECUTIVO;
	}
	
	public function setnumTelEjecutivo($numTelEjecutivo)
	{
	    $this->NUMTELEJECUTIVO	=	trim((strlen($numTelEjecutivo > 0))?('52-'.$numTelEjecutivo):(NULL));
	}
	
	function getnumTelEjecutivo(){
	    return $this->NUMTELEJECUTIVO;
	}
	
	public function setnumCelEjecutivo($numCelEjecutivo)
	{
	    $this->NUMCELEJECUTIVO	=	trim((strlen($numCelEjecutivo > 0))?('52-'.$numCelEjecutivo):(NULL));
	}
	
	function getnumCelEjecutivo(){
	    return $this->NUMCELEJECUTIVO;
	}
	
	public function setcorreoExtEjecutivo($correoExtEjecutivo)
	{
	    $this->CORREOEXTEJECUTIVO	=	trim($correoExtEjecutivo);
	}
	
	function getcorreoExtEjecutivo(){
	    return htmlentities($this->CORREOEXTEJECUTIVO);
	}
	
	public function setidcTipoEjecutivo($idcTipoEjecutivo)
	{
	    $this->IDCTIPOEJECUTIVO	=	trim($idcTipoEjecutivo);
	}
	
	function getidcTipoEjecutivo(){
	    return $this->IDCTIPOEJECUTIVO;
	}
	
	public function setidcEstatus($idcEstatus)
	{
	    $this->IDCESTATUS	=	trim($idcEstatus);
	}
	
	function getidcEstatus(){
	    return $this->IDCESTATUS;
	}
	
	public function setfecAltaEjecutivo($fecAltaEjecutivo)
	{
	    $this->FECALTAEJECUTIVO	=	trim($fecAltaEjecutivo);
	}
	
	function getfecAltaEjecutivo(){
	    return $this->FECALTAEJECUTIVO;
	}
	
	public function setfecVigenciaEjecutivo($fecVigenciaEjecutivo)
	{
	    $this->FECVIGENCIAEJECUTIVO	=	trim($fecVigenciaEjecutivo);
	}
	
	function getfecVigenciaEjecutivo(){
	    return $this->FECVIGENCIAEJECUTIVO;
	}
	
	function getFECMMOV(){
	    return $this->FECMOV;
	}
	
	public function setidEmpleado($idEmpleado)
	{
	    $this->IDEMP	=	trim($idEmpleado);
	}
	
	function getidEmpleado(){
	    return $this->IDEMP;
	}
				
	
	function getTipoEjecutivo(){
		$QUERY = "SELECT `descTipoEjecutivo` FROM `cat_tipoejecutivo` WHERE `idTipoEjecutivo` = '".$this->IDCTIPOEJECUTIVO."';";
		$result = $this->RBD->query($QUERY);
		if($result){
			list($nomTipoEjecutivo)= mysqli_fetch_row($result);
			if($nomTipoEjecutivo){return htmlentities($nomTipoEjecutivo);}else{return 'No se encuentra';}
		}else{return 'Consulta sin resultado';}
	}
	
	function getNombreEstatus(){
		$QUERY = "SELECT `descEstatus` FROM `cat_estatus` WHERE `idEstatus` = '".$this->IDCESTATUS."';";
		$result = $this->RBD->query($QUERY);
		if($result){
			list($nomEstatus)= mysqli_fetch_row($result);
			if($nomEstatus){return htmlentities($nomEstatus);}else{return 'No se encuentra';}
		}else{return 'Consulta sin resultado';}
	}
	
	function getDireccionFormat(){	
		$idDir=0;$direcC='';
		$sql_dir = "SELECT `idDireccion` FROM `inf_ejecutivodireccion` WHERE `idEjecutivo` = '".$this->IDEJECUTIVO."' AND `idEstatusEjecDir` = 0;";
		$resultdir = $this->RBD->query($sql_dir);
		if(mysqli_num_rows($resultdir)==0){return 'No se encuentra';}else{
			list($idDir)=mysqli_fetch_row($resultdir);mysqli_free_result($resultdir);
		
			$oDireccion = new Direccion($this->LOG,$this->RBD,$this->LOG2,$this->RBD);
			$oDireccion->load($idDir);
		
			if($oDireccion->getnumeroIntDireccion()==""){
				$direcC=$direcC.$oDireccion->getcalleDireccion()."&nbsp;No.&nbsp;".$oDireccion->getnumeroExtDireccion();
			}else{ $direcC=$direcC.$oDireccion->getcalleDireccion()."&nbsp;No.&nbsp;".$oDireccion->getnumeroExtDireccion()."&nbsp;int.&nbsp;".$oDireccion->getnumeroIntDireccion();} 
			$direcC=$direcC."<br>";
			$direcC=$direcC.$oDireccion->getNombreColonia();
			$direcC=$direcC."<br>";
			$direcC=$direcC.$oDireccion->getNombreMunicipio().",&nbsp;".$oDireccion->getNombreEntidad();
			$direcC=$direcC."<br>";
			$direcC=$direcC."CP:&nbsp;".$oDireccion->getcpDireccion()."<br>";
		}
		return $direcC;
	}
	
	function validaEjecutivo(){
		if($this->IDEJECUTIVO > 0){ return self::respuesta(4,"El ejecutivo ya existe"); }
	}
	
	function actualizar($AtribA,$valor,$id,$idEmp){
			
			trim($AtribA);trim($valor);trim($id);trim($idEmp);
			
			$sql = "UPDATE `dat_ejecutivo` SET `$AtribA` = '".utf8_decode($valor)."', `idEmpleado` = '$idEmp' WHERE `idEjecutivo` = '$id';";
			
			$result = $this->RBD->query($sql);
			if($result){echo "Actualizaci&oacute;n Exitosa";}else{echo 'Consulta sin resultado';}
			
	}
	
	function insertarCorrEjec($idCorr,$idEjec,$fechaRes,$idEmp){
			
			$oCorresponsal = new Corresponsal($this->LOG,$this->RBD,$this->LOG2,$this->RBD2);
			$sql = "INSERT INTO `inf_corresponsalejecutivo` (`idCorresponsal`, `idEjecutivo`, `fecAltaCorEjec`, `fecVigenciaCorEjec`, `idEmpleado`) VALUES ('$idCorr', '$idEjec', now(), '$fechaRes', '$idEmp');";
			
			$result = $this->RBD->query($sql);
			
			$sql2 = "SELECT `idCadena`, `idSubCadena` FROM `dat_corresponsal` WHERE `idCorresponsal` = '$idCorr';";
			$result2 = $this->RBD->query($sql2);
			list($idCad,$idScad)= mysqli_fetch_row($result2);
			mysqli_free_result($result2);
			
			$oCorresponsal->actualizacionpasos($idCad,$idScad,$idCorr,'11',$idEmp);
			
			echo "Ejecutivo Asignado";
	}
	
	function insertarSCadEjec($idsCad,$idEjec,$fechaRes,$idEmp){
			
			$osubCadena = new subCadena($this->LOG,$this->RBD,$this->LOG2,$this->RBD2);
			$sql = "INSERT INTO `inf_subcadenaejecutivo` (`idSubCadena`, `idEjecutivo`, `fecAltaSubCadEjec`, `fecVigenciaSubCadEjec`, `idEmpleado`) VALUES ('$idsCad', '$idEjec', now(), '$fechaRes', '$idEmp')";
			
			$result = $this->RBD->query($sql);
			
			$sql2 = "SELECT `idCadena` FROM `dat_subcadena` WHERE `idSubCadena` = '$idsCad';";
			$result2 = $this->RBD->query($sql2);
			list($idCad)= mysqli_fetch_row($result2);
			mysqli_free_result($result2);
			
			$osubCadena->actualizacionpasos($idCad,$idsCad,'-1','21',$idEmp);
			
			echo "Ejecutivo Asignado";
	}
	
	function insertarEjecDir($idEjec,$idDir,$fechaRes,$idEmp){
			
			$sql = "INSERT INTO `inf_ejecutivodireccion` (`idEjecutivo`, `idDireccion`, `fecAltaEjecDir`, `fecVigenciaEjecDir`, `idEmpleado`) VALUES ('$idEjec', '$idDir', now(), '$fechaRes', '$idEmp');";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();*/
			
			echo "Direcci&oacute;n Asignada";
	}
	
	function eliminar($id,$idEmp){
			
			$sql = "UPDATE `dat_ejecutivo` SET `idEstatusEjecutivo` = 3, `idEmpleado` = '$idEmp' WHERE `idEjecutivo` = '$id';";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();*/
			
			//=========CADENA=======
			//$oCadena = new Cadena($this->LOG,$this->RBD,$this->LOG2,$this->RBD2);
			$sql_e2 = "SELECT `idCadenaEjecutivo`, `idCadena` FROM `inf_cadenaejecutivo` WHERE `idEjecutivo` = '$id';";
			$res2 = $this->RBD->query($sql_e2);
			while(list($idCE,$idCad)=mysqli_fetch_row($res2))
			{
				$sql_e2CE = "UPDATE `inf_cadenaejecutivo` SET `idEstatusCadenaEjecutivo` = 3, `idEmpleado` = '$idEmp' WHERE `idCadenaEjecutivo` = '$idCE';";
				$res22 = $this->RBD->query($sql_e2CE);
				
				//$oCadena->actualizacionpasosBaja($idCad,'-1','-1','4',$idEmp);
			} 
			mysqli_free_result($res2);
			//=========CORRESPONSAL=======
			//$oCorresponsal = new Corresponsal($this->LOG,$this->RBD,$this->LOG2,$this->RBD2);
			$sql_e3 = "SELECT `idCorresponsalEjecutivo`, `idCorresponsal` FROM `inf_corresponsalejecutivo` WHERE `idEjecutivo` = '$id';";
			$res3 = $this->RBD->query($sql_e3);
			while(list($idCorE,$idCorr)=mysqli_fetch_row($res3))
			{
				$sql_e3CorE = "UPDATE `inf_corresponsalejecutivo` SET `idEstatusCorEjec` = 3, `idEmpleado` = '$idEmp' WHERE `idCorresponsalEjecutivo` = '$idCorE';";
				$res32 = $this->RBD->query($sql_e3CorE);
				
				/*$sql = "SELECT `idCadena`, `idSubCadena` FROM `dat_corresponsal` WHERE `idCorresponsal`=$idCorr";
				$result = $this->RBD->query($sql);
				list($idCad,$idScad)= mysqli_fetch_row($result);
				mysqli_free_result($result);
				
				$oCorresponsal->actualizacionpasosBaja($idCad,$idScad,$idCorr,'11',$idEmp);*/
			} 
			mysqli_free_result($res3);
			//================
			//=========SUBCADENA=======
			//$oCorresponsal = new Corresponsal($this->LOG,$this->RBD,$this->LOG2,$this->RBD2);
			$sql_e4 = "SELECT `idSubCadenaEjecutivo`, `idSubCadena` FROM `inf_subcadenaejecutivo` WHERE `idEjecutivo` = '$id';";
			$res4 = $this->RBD->query($sql_e4);
			while(list($idSCE,$idsCad)=mysqli_fetch_row($res4))
			{
				$sql_e4SCE = "UPDATE `inf_subcadenaejecutivo` SET `idEstatusSubCadEjec` = 3,`idEmpleado` = '$idEmp' WHERE `idSubCadenaEjecutivo` = '$idSCE';";
				$res42 = $this->RBD->query($sql_e4SCE);
				
				/*$sql = "SELECT `idCadena`, `idSubCadena` FROM `dat_corresponsal` WHERE `idCorresponsal`=$idCorr";
				$result = $this->RBD->query($sql);
				list($idCad,$idScad)= mysqli_fetch_row($result);
				mysqli_free_result($result);
				
				$oCorresponsal->actualizacionpasosBaja($idCad,$idScad,$idCorr,'11',$idEmp);*/
			} 
			mysqli_free_result($res4);
			//================
			
			
			
			echo "Se Elimin&oacute; el Ejecutivo";	
	}
	
	function eliminarDireccionParaEjecutivo($idDir,$IdEjec,$idEmp){
			
			$sql = "UPDATE `inf_ejecutivodireccion` SET `idEstatusEjecDir` = 3, `idEmpleado` = '$idEmp' WHERE `idDireccion` = '$idDir' AND `idEjecutivo` = '$IdEjec';";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();*/
			
			echo "Se Dio de Baja la Direcci&oacute;n";	
	}
	
	function generar(){
		$QUERY = "SELECT MAX( `idEjecutivo` ) FROM `dat_ejecutivo`;";
		$result = $this->RBD->query($QUERY);
		list($idMax)= mysqli_fetch_row($result);
				
		echo $idMax;
	}	
	
	function actualizacionpasos($idCad,$idScad,$idCorr,$idReq,$idEmp){
			
			$sql = "UPDATE `inf_pasoscsc` SET `fecPasosCSC` = now(), `idEmpleado` = '$idEmp' WHERE `idCadena` = '$idCad' AND `idSubCadena` = '$idScad' AND `idCorresponsal` = '$idCorr' AND `idRequisito` = '$idReq';";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();*/
	}
	
	function actualizacionpasosBaja($idCad,$idScad,$idCorr,$idReq,$idEmp){
			
			$sql = "UPDATE `inf_pasoscsc` SET `fecPasosCSC` = NULL, `idEmpleado` = '$idEmp' WHERE `idCadena` = '$idCad' AND `idSubCadena` = '$idScad' AND `idCorresponsal` = '$idCorr' AND `idRequisito` = '$idReq';";
			
			$result = $this->RBD->query($sql);
			/*$this->LOG->error($this->RBD->error());
			echo $this->RBD->error();*/
	}
	
	function insertar(){
	$sQuery="";
	$aAfectados=null;
		if ($this->CONTRASENIAEJECUTIVO == NULL OR $this->USUARIOEJECUTIVO == NULL)
			exit("Ejecutivo->insertar(): error de codificaci&oacute;n, faltan datos");
		else{
			if ($this->RBD){
		 		$sQuery = "INSERT INTO `dat_ejecutivo` (`nombreEjecutivo`, `apPaternoEjecutivo`, `apMaternoEjecutivo`, `usuarioEjecutivo`, `contraseniaEjecutivo`, `fecNacEjecutivo`, `numTelEjecutivo`, `numCelEjecutivo`, `correoExtEjecutivo`, `idcTipoEjecutivo`, `fecAltaEjecutivo`, `fecVigenciaEjecutivo`, `idEmpleado`) VALUES ('".$this->NOMBREEJECUTIVO."', '".$this->APPATERNO."', '".$this->APMATERNO."', '".$this->USUARIOEJECUTIVO."' , '".$this->CONTRASENIAEJECUTIVO."' , '".$this->FECHANACEJECUTIVO."' , '".$this->NUMTELEJECUTIVO."' ,'".$this->NUMCELEJECUTIVO."','".$this->CORREOEXTEJECUTIVO."',".$this->IDCTIPOEJECUTIVO.", now(), '".$this->FECVIGENCIAEJECUTIVO."', ".$this->IDEMP.");";
				$aAfectados = $this->RBD->query($sQuery);
				if($aAfectados){return $aAfectados;}else{return -1;}				
			}else{
				return -1;
			}
		}
	}

	function buscarNomUSU(){
	$sQuery1="";
	$aFila=null;
		if ($this->USUARIOEJECUTIVO==NULL)
			exit("Ejecutivo->buscarCvePwd(): error de codificaci&oacute;n, faltan datos");
		else{
			if ($this->RBD){
			
		 		$sQuery1 = "SELECT `idEjecutivo`, `nombreEjecutivo`, `apPaternoEjecutivo`, `apMaternoEjecutivo`, `usuarioEjecutivo`, `contraseniaEjecutivo`, `fecNacEjecutivo`, `numTelEjecutivo`, `numCelEjecutivo`, `correoExtEjecutivo`, `idcTipoEjecutivo`, `fecAltaEjecutivo`, `fecVigenciaEjecutivo`, `idEstatusEjecutivo`, `fecMovEjecutivo`, `idEmpleado`
					FROM `dat_ejecutivo`
					WHERE `usuarioEjecutivo` = '".$this->USUARIOEJECUTIVO."';";		
				$aFila = $this->RBD->ejecutarComando($sQuery1);
				if ($aFila){
						$this->IDEJECUTIVO = $aFila[0][0];
						$this->NOMBREEJECUTIVO = $aFila[0][1];
						$this->APPATERNO = $aFila[0][2];
						$this->APMATERNO = $aFila[0][3];
						$this->USUARIOEJECUTIVO = $aFila[0][4];
						$this->CONTRASENIAEJECUTIVO = $aFila[0][5];
						$this->FECHANACEJECUTIVO = $aFila[0][6];
						$this->NUMTELEJECUTIVO = $aFila[0][7];
						$this->NUMCELEJECUTIVO = $aFila[0][8];
						$this->CORREOEXTEJECUTIVO = $aFila[0][9];
						$this->IDCTIPOEJECUTIVO = $aFila[0][10];
						$this->FECALTAEJECUTIVO = $aFila[0][11];
						$this->FECVIGENCIAEJECUTIVO = $aFila[0][12];
						$this->IDCESTATUS = $aFila[0][13];
						$this->FECMOV = $aFila[0][14];
						$this->IDEMP = $aFila[0][15];
					return true;
				}else{
			   		return false;}
			}else{
				return false;}
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