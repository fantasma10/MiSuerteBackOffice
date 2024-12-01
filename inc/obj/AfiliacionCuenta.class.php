<?php

	class AfiliacionCuenta{

		private $RBD;
		private $WBD;
		private $LOG;
		private $XML;
		
		public $IDCUENTA;
		public $BENEFICIARIO;
		public $NUMCUENTA;
		public $IDBANCO;
		public $DESCRIPCION;
		public $CLABE;	

		function __construct($r,$w, $log){
			$this->RBD = $r;
			$this->WBD = $w;
			$this->XML = "";
			$this->LOG = $log;

			$this->IDCUENTA		= 0;

			$this->IDEJECUTIVO	= 0;
			$this->IDREPLEGAL	= 0;

			$this->ERROR_MSG	= "";
			$this->ERROR_CODE	= 0;
		}

		function guardarCuenta(){
			$IDEMPLEADO = $_SESSION['idU'];

			if($this->IDCUENTA == 0){
				$QUERY = "CALL `afiliacion`.`SP_CUENTA_CREAR`(".$this->IDBANCO.", '".$this->NUMCUENTA."', '".$this->CLABE."', '".$this->BENEFICIARIO."', '".$this->DESCRIPCION."', $IDEMPLEADO)";
			}
			else{
				$QUERY = "CALL `afiliacion`.`SP_CUENTA_UPDATE`(".$this->IDCUENTA.", ".$this->IDBANCO.", '".$this->NUMCUENTA."', '".$this->CLABE."', '".$this->BENEFICIARIO."', '".$this->DESCRIPCION."', $IDEMPLEADO)";
			}

			//var_dump($QUERY);

			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);

				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idCuenta' => $res['idCuenta']
					)
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Guardar Cuenta : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}

		function eliminarCuenta(){
			$IDEMPLEADO = $_SESSION['idU'];

			$QUERY = "CALL `afiliacioN`.`SP_CUENTA_ELIMINAR`(".$this->IDCUENTA.", $IDEMPLEADO)";
			$sql = $this->WBD->query($QUERY);

			if(!$this->WBD->error()){
				$res = mysqli_fetch_assoc($sql);

				$response = array(
					'success'	=> true,
					'data'		=> array(
						'idCuenta'	=> $this->IDCUENTA
					)
				);
			}
			else{
				$response = array(
					'success'	=> false,
					'data'		=> array(),
					'errmsg'	=> $this->WBD->error()
				);
				$this->LOG->error("Error al Eliminar la Cuenta : ".$QUERY." -- ".$this->WBD->error(), false);
			}

			return $response;
		}
	}

?>