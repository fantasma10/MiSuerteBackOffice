<?php

class ExcelFileReader{

	public $_file;
	public $sName			= '';
	public $nSize			= '';
	public $sTmpName		= '';
	public $sType			= '';
	public $nLineStart		= '';
	public $oPhpExcel		= null;
	public $arrayDataSets	= array();
	public $nTotalDataSets	= 0;

	public function set_file($value){
		$this->_file = $value;
	}

	public function get_file(){
		return $this->_file;
	}

	public function setSName($value){
		$this->sName = $value;
	}

	public function getSName(){
		return $this->sName;
	}

	public function setNSize($value){
		$this->nSize = $value;
	}

	public function getNSize(){
		return $this->nSize;
	}

	public function setSTmpName($value){
		$this->sTmpName = $value;
	}

	public function getSTmpName(){
		return $this->sTmpName;
	}

	public function setSType($value){
		$this->sType = $value;
	}

	public function getSType(){
		return $this->sType;
	}

	public function setNLineStart($value){
		$this->nLineStart = $value;
	}

	public function getNLineStart(){
		return $this->nLineStart;
	}

	public function setOPhpExcel($oPhpExcel){
		$this->oPhpExcel = $oPhpExcel;
	}

	public function getOPhpExcel(){
		return $this->oPhpExcel;
	}

	public function setArrayDataSets($arrayDataSets){
		$this->arrayDataSets = $arrayDataSets;
	}

	public function getArrayDataSets(){
		return $this->arrayDataSets;
	}

	public function setNTotalDataSets($nTotalDataSets){
		$this->nTotalDataSets = $nTotalDataSets;
	}

	public function getNTotalDataSets(){
		return $this->nTotalDataSets;
	}

	public function initReader(){
		$sTmpName	= $this->_file['tmp_name'];
		$nSize		= $this->_file['size'];
		$sName		= $this->_file['name'];
		$sType		= PHPExcel_IOFactory::identify($sTmpName);

		self::setSTmpName($sTmpName);
		self::setNSize($nSize);
		self::setSName($sName);
		self::setSType($sType);

		return self::_initPhpExcel();
	} # initReader

	private function _initPhpExcel(){
		$oPhpExcel		= new PhpExcel();
		$inputFileName	= self::getSTmpName();

		try{
			$inputFileType	= self::getSType();
			$objReader		= PHPExcel_IOFactory::createReader($inputFileType);
			
			if($inputFileType == 'CSV'){
				$objReader->setInputEncoding('ISO-8859-1');
			}
			$objPHPExcel	= $objReader->load($inputFileName);

			$array = array(
				'nCodigo'		=> 0,
				'bExito'		=> true,
				'sMensaje'		=> 'Ok'
			);

			self::setOPhpExcel($objPHPExcel);
		}
		catch(Exception $e){

			$sMsgError = 'Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage();

			$array = array(
				'nCodigo'	=> 1,
				'bExito'	=> false,
				'sMensaje'	=> $sMsgError
			);
		}

		return $array;
	} # _initPhpExcel

	public function loadDataSets(){
		$sheet		= $this->oPhpExcel->getSheet(0);
		$dataSets	= $sheet->toArray(null, false, false, false);
		$sType		= $this->getSType();

		if($sType == 'CSV'){
			$newDataSets = array();
			foreach($dataSets AS $key => $dataSet){
				$newDataSet = array();
				foreach($dataSet AS $key2 => $value){
					array_push($newDataSet, str_replace("\0", "", $value));
				}
				array_push($newDataSets, $newDataSet);
			}
			$dataSets = $newDataSets;
		}

		$nCountDataSets = count($dataSets);

		self::setNTotalDataSets($nCountDataSets);
		self::setArrayDataSets($dataSets);
	} # read

} # FileReader

?>