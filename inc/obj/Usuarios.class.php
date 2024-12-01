<?php
####################################corresponsal.class####################################
//For break use "\n" instead '\n'
class Usuarios{

	public $ID, $CORREO, $IDPERFIL, $NOMBREUSUARIO, $PATERNOUSUARIO, $MATERNOUSUARIO, $IDESTATUSUSUARIO, $IDEMPLEADO;

	public $RBD;
	#public $LOG;
	public $WBD;
	#public $LOG2;

	public function __construct($RBD,$WBD)
	{
		#$this->LOG					=	$LOG;
		$this->RBD					=	$RBD;
		#$this->LOG2				=	$LOG2;
		$this->WBD					=	$WBD;
		$this->ID					=	0;
		$this->CORREO				=	NULL;
		$this->IDPERFIL				=	NULL;
		$this->NOMBREUSUARIO		=	NULL;
		$this->PATERNOUSUARIO		=	NULL;
		$this->MATERNOUSUARIO		=	NULL;
		$this->IDESTATUSUSUARIO		=	NULL;
		$this->IDEMPLEADO			=	NULL;
	}

	public function load( $idUsuario, $idPortal ) {
		$SQL = "CALL `data_acceso`.`SP_LOAD_USUARIO`($idUsuario, $idPortal, NULL, 1);";
		$Result = $this->RBD->SP($SQL);
		//$Result = $this->WBD->SP($SQL);
		if ( $Result ) {
			if( mysqli_num_rows($Result) > 0 ) {
				list(
					$this->ID,
					$this->CORREO,
					$this->IDPERFIL,
					$this->NOMBREUSUARIO,
					$this->PATERNOUSUARIO,
					$this->MATERNOUSUARIO,
					$this->IDESTATUSUSUARIO,
					$this->IDEMPLEADO
				) = mysqli_fetch_array($Result);
				return self::respuesta(0,"Mensaje cargado con exito");
			} else {
				return self::respuesta(2,"No se encontro Mensaje");
			}
		} else { return self::respuesta(2,"No fue posible consultar datos"); }
	}

	public function listaUsuarios( $idUsuario, $idPortal ) {
		$SQL = "CALL `data_acceso`.`SP_SELECT_USUARIOS`();";
		//$Result = $this->RBD->SP($SQL);
		$Result = $this->WBD->SP($SQL);
		if($Result){
			if(mysqli_num_rows($Result) > 0){
				$data = array();
				while($row = mysqli_fetch_assoc($Result)){
					$data[] = $row;
				}
				return self::respuesta(0,"Mensaje cargado con exito", $data);
			} else {
				return self::respuesta(2,"No se encontro Mensaje");
			}
		} else { return self::respuesta(2,"No fue posible consultar datos"); }
	}

	public function loadByCorreo() {
		$SQL = "CALL `data_acceso`.`SP_LOAD_USUARIO`($idUsuario, $idPortal, '{$_SESSION['email']}', 2);";
		//$Result = $this->RBD->SP($SQL);
		$Result = $this->WBD->SP($SQL);
		if($Result){
			if(mysqli_num_rows($Result) > 0)
			{
				list(
					$this->ID,
					$this->CORREO,
					$this->IDPERFIL,
					$this->NOMBREUSUARIO,
					$this->PATERNOUSUARIO,
					$this->MATERNOUSUARIO,
					$this->IDESTATUSUSUARIO,
					$this->IDEMPLEADO

				) = mysqli_fetch_array($Result);
				return self::respuesta(0,"Mensaje cargado con exito");
			}else{
				return self::respuesta(2,"No se encontro Mensaje");
			}
		}else{return self::respuesta(2,"No fue posible consultar datos");}
	}

	function getIdUsuario(){
		return $this->ID;
	}

	function getcorreo(){
		return $this->CORREO;
	}

	function getidPerfil(){
		return $this->IDPERFIL;
	}

	function getNombreUsuario(){
		return $this->NOMBREUSUARIO;
	}

	function getPaternoUsuario(){
		return $this->PATERNOUSUARIO;
	}
	function getMaternoUsuario(){
		return $this->MATERNOUSUARIO;
	}

	function getStatus(){
		return $this->IDESTATUSUSUARIO;
	}

	function getIdEmpleado(){
		return $this->IDEMPLEADO;
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