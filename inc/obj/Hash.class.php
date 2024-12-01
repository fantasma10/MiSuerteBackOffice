<?php

class Hash{

	const SALT = '5%(hX87Q@';

	public $string;
	public $sAlgorithmName;

	public function setString($value){
		$this->string = $value;
	}

	public function getString(){
		return $this->string;
	}


	public function setSAlgorithmName($value){
		$this->sAlgorithmName = $value;
	}

	public function getSAlgorithmName(){
		return $this->sAlgorithmName;
	}

	public function makeHash(){
		return hash($this->sAlgorithmName, $this->string.self::SALT);
	} # makeHash
} # Hash

?>