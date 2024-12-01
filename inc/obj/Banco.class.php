<?php

class Banco{

	public $nIdBanco;
	public $sNombreBanco;
	public $sDescBanco;
	public $strBancos = '';

	public function setNIdBanco($value){
		$this->nIdBanco = $value;
	}

	public function getNIdBanco(){
		return $this->nIdBanco;
	}

	public function setSNombreBanco($value){
		$this->sNombreBanco = $value;
	}

	public function getSNombreBanco(){
		return $this->sNombreBanco;
	}

	public function setSDescBanco($value){
		$this->sDescBanco = $value;
	}

	public function getSDescBanco(){
		return $this->sDescBanco;
	}

	public function setRBD($RBD){
		$this->RBD = $RBD;
	}

	public function setWBD($WBD){
		$this->WBD = $WBD;
	}

	public function setStrBancos($str){
		$this->strBancos = $str;
	}

	public function getStrBancos(){
		return $this->strBancos;
	}

	public function getListaBancos(){
		$sQuery = "CALL `redefectiva`.`SP_LOAD_BANCOS`();";
		$sql	= $this->RBD->query($sQuery);

		$sMsg		= '';
		$arrData	= array();
		$nCodigo	= 0;
		$sMsgError	= '';
		$bExito		= true;

		if(!$this->RBD->error()){
			while($row = mysqli_fetch_assoc($sql)){
				$arrData[] = array(
					'nIdBanco'		=> $row['idBanco'],
					'sNombreBanco'	=> utf8_encode($row['nombreBanco'])
				);
			}
		}
		else{
			$bExito		= false;
			$nCodigo	= $this->RBD->LINK->errno;
			$sMsgError	= $this->RBD->error();
		}

		return array(
			'bExito'	=> $bExito,
			'nCodigo'	=> $nCodigo,
			'sMsg'		=> $sMsg,
			'sMsgError'	=> $sMsgError,
			'data'		=> $arrData
		);
	} # getListaBancos

	public function getListaBancos2(){
		$nIdBanco 	= self::getNIdBanco();
		$strBancos	= self::getStrBancos();

		$sQuery = "CALL `redefectiva`.`SP_LOAD_BANCOS2`($nIdBanco, '$strBancos');";
		$sql	= $this->RBD->query($sQuery);

		$sMsg		= '';
		$arrData	= array();
		$nCodigo	= 0;
		$sMsgError	= '';
		$bExito		= true;

		if(!$this->RBD->error()){
			while($row = mysqli_fetch_assoc($sql)){
				$arrData[] = array(
					'data'	=> $row['idBanco'],
					'value'	=> utf8_encode($row['nombreBanco'])
				);
			}
		}
		else{
			$bExito		= false;
			$nCodigo	= $this->RBD->LINK->errno;
			$sMsgError	= $this->RBD->error();
		}

		return array(
			'bExito'	=> $bExito,
			'nCodigo'	=> $nCodigo,
			'sMsg'		=> $sMsg,
			'sMsgError'	=> $sMsgError,
			'data'		=> $arrData
		);
	} # getListaBancos

	/*
		Obtiene la lista de bancos para mostrar en la pantalla de corrección de banco
		de los depositos que realizan los corresponsales

		este metodo utiliza la nueva funcionalidad de MyMysqli.class
	*/
	public function getListaBancosDeposito(){
		$this->RBD->setSDatabase('redefectiva');
		$this->RBD->setSStoredProcedure('sp_select_bancodeposito');
		$this->RBD->setParams($array_params);
		$arrRes	= $this->RBD->execute();

		if($arrRes['nCodigo'] > 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$data		= $this->RBD->fetchAll();
		$num_rows	= $this->RBD->numRows();
		$this->RBD->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Exitosa',
			'sMensajeDetallado'	=> 'Consulta Exitosa',
			'data'				=> $data,
			'num_rows'			=> $num_rows
		);
	}
} # Banco

?>