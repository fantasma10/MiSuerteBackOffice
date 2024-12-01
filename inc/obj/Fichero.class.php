<?php

class Fichero{

	public $path;
	public $fichero;
	public $currentLine;
	protected $maxLine;
	protected $arrayEveryLine;

	public function setPath($value){
		$this->path = $value;
	}

	public function getPath(){
		return $this->path;
	}

	public function setFichero(){
		$this->fichero = file($this->path);
	}

	public function getFichero(){
		return $this->fichero;
	}

	protected function setCurrentLine($linea){
		$this->currentLine = $this->fichero[$linea-1];
	}

	public function setMaxLine($line){
		if(!empty($line) && $line >= 1){
			$this->maxLine = $line;
		}
		else{
			$this->maxLine = count($this->fichero);
		}
	}

	public function getFullLine($linea){
		if(!empty($linea) && $linea != null){
			self::setCurrentLine($linea);
		}

		return $this->currentLine;
	}

	protected function getSubstrLine($posicion){
		return substr($this->currentLine, $posicion);
	}

	protected function setEveryLine(){
		$maxLine		= $this->getMaxLine();
		$arrayEveryLine = array();

		for($i=0; $i<$maxLine; $i++){
			$line				= $i+1;
			$arrayEveryLine[]	= $this->getFullLine($line);
		}

		$this->arrayEveryLine = $arrayEveryLine;
	}

	protected function getEveryLine(){
		return $this->arrayEveryLine;
	}

	protected function getMaxLine(){
		return $this->maxLine;
	}
} # Fichero

?>