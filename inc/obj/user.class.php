<?php
####################################Usuario.class####################################
//For break use "\n" instead '\n'
class User {

	private $USERID, $USERNAME, $USERPASS;

	public $idSeccion = array(), $desSeccion = array(), $idTipo = array();
	public $Nombre;
	public $Correo;

	public $SESSIONID;

	public function __construct($LOG,$RBD)
	{
		$this->LOG			=	$LOG;
		$this->RBD			=	$RBD;
		$this->USERID		=	0;
	}

	public function Login($Usuario, $Password)
	{
		/*try
		{
			$adldap = new adLDAP();
		}
		catch (adLDAPException $e) {
			echo $e;
			exit();
		}*/

		if($Usuario != '' && $Usuario != 'Usuario')
		{			
			if($Password != '')
			{
				$this->USERNAME		=	trim(strtoupper($Usuario));
				$this->USERPASS		=	trim($this->setPassMiSuerte($this->USERNAME, $Password));

				$ResultLoginCorreo= $this->getLoginMiSuerte($this->USERNAME, $this->USERPASS);

				//echo var_export($Result) . " " . $this->USERPASS . " " . $this->USERNAME;

				if(strlen($ResultLoginCorreo) > 0){

					$this->Nombre = $this->USERNAME;// $Info[0]['displayname'][0];
					$this->Correo = $ResultLoginCorreo;//$this->USERNAME.'@redefectiva.com'; //$Info[0]['mail'][0];

					return self::respuesta(0, "Usuario y Contrase�a validos");

				}
				else{
					return self::respuesta(2,"Usuario Invalido");
				}
			}
			else{
				return self::respuesta(3,"Contrase�a Vacia");
			}
		}
		else{
			return self::respuesta(4,"Usuario Vacio");
		}

	}

	/*
		JCalderon
		09/05/2024
		metodo para encriptar la contraseña para el login
	*/
	public function setPassMiSuerte($username, $newPassword){
		
		$texto = $username . "|" . $newPassword;

		$texto_encriptado = hash('sha256', $texto);

		return $texto_encriptado;
	}
/*
		JCalderon
		09/05/2024
		metodo para inicio de sesion la contraseña para el login
	*/
	public function getLoginMiSuerte($username, $newPassword) {

		$QUERY = "CALL `data_acceso_misuerte`.`sp_login_misuerte`('$username', '$newPassword');";
		$result = $this->RBD->SP($QUERY);

		if( mysqli_num_rows($result) > 0 ){
			list($idu)= mysqli_fetch_row($result);
			mysqli_free_result($result);
		} else {
			$idu = -1;
		}

		return $idu;
	}

	public function getIdUser( $correo ) {

		/*$QUERY = "SELECT `idUsuario`
				  FROM `data_acceso`.`dat_usuario`
				  WHERE `email` = '$correo';";*/

		$QUERY = "CALL `data_acceso_misuerte`.`SP_GET_USUARIOBYMAIL`('$correo');";
		$result = $this->RBD->SP($QUERY);

		if( mysqli_num_rows($result) > 0 ){
			list($idu)= mysqli_fetch_row($result);
			mysqli_free_result($result);
		} else {
			$idu = -1;
		}

		return $idu;
	}

	public function getIdPerfil( $correo, $idPortal ) {
		$QUERY = "SELECT perfilesdelusuario.idPerfil
				  FROM data_acceso_misuerte.inf_perfilesdelusuario perfilesdelusuario
				  INNER JOIN data_acceso_misuerte.dat_usuario usuario
				  ON ( usuario.idUsuario = perfilesdelusuario.idUsuario )
				  INNER JOIN data_acceso_misuerte.cat_portal portal
				  ON ( portal.idPortal = $idPortal )
				  WHERE usuario.email = '$correo'
				  AND perfilesdelusuario.idEstatus = 0
				  AND usuario.idEstatus = 0
				  AND portal.idEstatus = 0;";

		$result = $this->RBD->query($QUERY);

		if( mysqli_num_rows($result) > 0 ){
			list($idp)= mysqli_fetch_row($result);
			mysqli_free_result($result);
		} else {
			$idp = -1;
		}

		return $idp;
	}


	public function isUserMember($Group)
	{
		try
		{
			$adldap = new adLDAP();
		}
		catch (adLDAPException $e) {
			echo $e;
			exit();
		}

		return $adldap->user()->inGroup($this->USERNAME, $Group);
	}

	public function setPass($username, $newPassword) {
		try {
			$adldap = new adLDAP();
			$adldap->setUseSSL(true);
			return $adldap->user()->password($username, $newPassword);
		} catch ( adLDAPException $e ) {
			echo $e;
			exit();
		}
	}

	public function setSessionId($Session)
	{
		$this->SESSIONID = $Session;
	}

	public function getUserNombre()
	{
		return $this->Nombre;
	}

	public function getUserCorreo()
	{
		return $this->Correo;
	}

	public function getUserName()
	{
		return $this->USERNAME;
	}

	public function getUserId()
	{
		return $this->USERID;
	}

	public function getUserIdPerfil()
	{
		return $this->idPerfil;
	}

	public function getUserNombres()
	{
		return htmlentities($this->NombreUsuario);
	}

	public function getUserApaterno()
	{
		return htmlentities($this->PaternoUsuario);
	}

	public function getUserAmaterno()
	{
		return htmlentities($this->MaternoUsuario);
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

	public function getEstatus( $idUsuario ) {

		$QUERY = "SELECT `idEstatus`
				  FROM `data_acceso_misuerte`.`dat_usuario`
				  WHERE `idUsuario` = $idUsuario";

		$result = $this->RBD->query($QUERY);

		if( mysqli_num_rows($result) > 0 ){
			list($idEstatus) = mysqli_fetch_row($result);
			mysqli_free_result($result);
		} else {
			$idEstatus = 0;
		}

		return $idEstatus;

	}

	function __destruct() {	}
}
?>
