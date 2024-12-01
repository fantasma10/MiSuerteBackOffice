<?php
class RE_GeneraTxtTelmex{
	public $nIdProveedor;
	public $dFechaPago;
	public $nIdZona;
	
	public function setOWdb($oWdb){
		$this->oWdb = $oWdb;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function setORdb($oRdb){
		$this->oRdb = $oRdb;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOLog($value){
		$this->oLog = $value;
	}

	public function getOLog(){
		return $this->oLog;
	}

	public function setNIdProveedor($value){
		$this->nIdProveedor = $value;
	}

	public function getNIdProveedor(){
		return $this->nIdProveedor;
	}

	public function setNIdZona($value){
		$this->nIdZona = $value;
	}

	public function getNIdZona(){
		return $this->nIdZona;
	}

	public function setDFechaPago($value){
		$this->dFechaPago = $value;
	}

	public function getDFechaPago(){
		return $this->dFechaPago;
	}

	# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
	public function generaTxt(){
		$fechaPago   = $this->dFechaPago;
        $idProveedor = $this->nIdProveedor;
        $idZona = $this->nIdZona;
        $METROGAS = 119;
		$GASNATURAL=27;

		$this->oRdb->setSDatabase('redefectiva');
        $array_params = array(
            array('name' => 'p_idProveedor',    'value' => $idProveedor,    'type' => 'i'),
            array('name' => 'p_fecha',          'value' => $fechaPago,      'type' => 's'),
            array('name' => 'p_zona',          'value' => $idZona,      'type' => 'i')
        );

        $this->oRdb->setSStoredProcedure('sp_select_operaciones_fecha_liquidacion');
        $this->oRdb->setParams($array_params);
        $result = $this->oRdb->execute();
        $data = $this->oRdb->fetchAll();
        
        $content="";
        if ($result['nCodigo'] == 0){
            for($i=0;$i<count($data);$i++){
            	if($idProveedor == $METROGAS || $idProveedor==$GASNATURAL){//Para gas natural se le informa en que cadena se recibio el pago
            		$content .=$data[$i]["idOperacion"]."|".$data[$i]["ticket"]."|".$data[$i]["nombreCadena"]."|".$data[$i]["nombreCorresponsal"]."|".$data[$i]["importeOperacion"]."\n";
            	}else{
            		$content .=$data[$i]["idOperacion"]."|".$data[$i]["ticket"]."|".$data[$i]["importeOperacion"]."\n";
            	}
            }
        }

        $dir=$_SERVER['DOCUMENT_ROOT']."/STORAGE/RED_EFECTIVA/TELMEX/";
        if($idZona==0){
        	$nombreArchivoTxt =$this->nIdProveedor."_".$this->dFechaPago;
        }
        else{
        	$nombreArchivoTxt =$this->nIdProveedor."_".$idZona."_".$this->dFechaPago;
        }

	    if(!is_dir($dir)){
	        mkdir($dir, '0777', true);
	    }

		$fp = fopen($dir.$nombreArchivoTxt.".txt","wb");
		fwrite($fp,$content);
		fclose($fp);  

		if (file_exists($dir.$nombreArchivoTxt.'.txt')) 
	    	$arrayRespuesta["retorno"] = 0;
	    else
	    	$arrayRespuesta["retorno"] = 1;

	    $arrayRespuesta["ruta_archivo"] = $dir.$nombreArchivoTxt.'.txt';
	    $arrayRespuesta["nombre_archivo"] = $nombreArchivoTxt.'.txt';
    	return $arrayRespuesta;

	}
}
?>