<?php
####################################portal.class####################################
class Portal {
	
	public $idPortal;
	
	public function __construct($LOG,$RBD)
	{
		$this->LOG			=	$LOG;
		$this->RBD			=	$RBD;
	}
	
	#Descripcion: Obtiene el ID del Portal especificado
	#Autor: Roberto Cortina
	#Fecha de creacion: 8 de noviembre de 2013
	#Fecha de ultima modificacion: 8 de noviembre de 2013
	public function getIDPortal($portal)
	{
		$SQL = "CALL `data_acceso`.`SP_GET_IDPORTAL`('$portal');";
		$resultado = $this->RBD->SP($SQL);
		
		if($resultado)
		{
			if(mysqli_num_rows($resultado) == 1)
			{
				$row = mysqli_fetch_row($resultado);
				$this->idPortal = $row[0];
				mysqli_free_result($resultado);
				return self::respuesta(0, "ID del Portal encontrado satisfactoriamente");
			}
			else
			{
				return self::respuesta(1, "No se encontr� el Portal especificado como parametro");
			}
		}
		else
		{
			return self::respuesta(2, "Error al ejecutar la consulta");
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
	
	function __destruct() { }
}
?>