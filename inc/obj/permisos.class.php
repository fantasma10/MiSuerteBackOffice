<?php
####################################corresponsal.class####################################
//For break use "\n" instead '\n' 
class Permisos{ 
		
	public $idSeccion = array();
	public $desSeccion = array();
	public $idTipo = array();
	public $descTipo = array();
	public $idMenu = array();
	public $idSubmenu = array(); 	
	public $Status = array();

	
	public function __construct($LOG,$RBD) 
	{
		$this->LOG			=	$LOG;
		$this->RBD			=	$RBD;
		$this->USERID		=	0;
	}
	
	public function load() { }
	
	public function getPermisos($idu, $idp, $idPortal)
	{		 	 	 	 	 	 	 	 	 	 	 	 				
		$SQL = "CALL `data_acceso`.`SP_GET_PERMISOS`($idu,$idp,$idPortal);";	

		$Result = $this->RBD->SP($SQL);

		if($Result){
			if(mysqli_num_rows($Result) > 0)
			{
				$i = 0;
				while(list($id, $desc, $tipo, $descTipo, $menu, $submenu)= mysqli_fetch_row($Result)){
					$this->idSeccion[$i] = $id;
					$this->desSeccion[$i] =$desc;
					$this->idTipo[$i] = $tipo;
					$this->descTipo[$i] = $descTipo;
					$this->idMenu[$i] = $menu;
					$this->idSubmenu[$i] = $submenu;
					$i++;
				}
				$arreglo = array(
				'Opcion' => $this->idSeccion,
				'DescripcionOpcion' => $this->desSeccion,
				'Accion' => $this->idTipo,
				'DescripcionAccion' => $this->descTipo,
				'Menu' => $this->idMenu,
				'Submenu' => $this->idSubmenu );
				
				if ( !is_null($arreglo) ) {
					return self::respuesta(0,"Permisos cargados con exito", $arreglo);
				} else {
					return self::respuesta(1, "No se encontraron permisos", $arreglo);
				}
			}else{
				return self::respuesta(2,"No se encontro Permisos"); 
			}
		}else{return self::respuesta(3,"No fue posible consultar datos");}
	}
	
	public function getMenu($idPortal) {
		
		$SQL = "CALL `data_acceso`.`SP_GET_MENU`($idPortal);";
		$Result = $this->RBD->SP($SQL);
		if( $Result ) {
			if ( mysqli_num_rows($Result) > 0 ) {
				$menuID = array();
				$menuNombre = array();
				$i = 0;
				while ( list($idMenu, $nombre) = mysqli_fetch_row($Result) ) {
					$menuID[$i] = $idMenu;
					$menuNombre[$i] = $nombre;
					$i++;
				}
				$menus = array( 'id' => $menuID, 'nombre' => $menuNombre );
				return self::respuesta(0, "Menus obtenidos con exito", $menus);	
			} else {
				return self::respuesta(1, "No se encontraron menus");
			}
		} else {
			return self::respuesta(2, "No fue posible consultar datos");
		}
		
	}
	
	public function getOpciones($idPortal) {
		
		$SQL = "CALL `data_acceso`.`SP_GET_OPCIONES`($idPortal);";
		$Result = $this->RBD->SP($SQL);
		
		if( $Result ) {
			if ( mysqli_num_rows($Result) > 0 ) {
				$opcionID = array();
				$opcionNombre = array();
				$menuID = array();
				$menuNombre = array();
				$submenuID = array();
				$submenuNombre = array();
				$portalID = array();
				$i = 0;
				while ( list($idOpcion, $opcion, $idMenu, $nombreMenu, $idSubmenu, $nombreSubmenu, $portal) = mysqli_fetch_row($Result) ) {
					$opcionID[$i] = $idOpcion;
					$opcionNombre[$i] = $opcion;
					$menuID[$i] = $idMenu;
					$menuNombre[$i] = $nombreMenu;
					$submenuID[$i] = $idSubmenu;
					$submenuNombre[$i] = $nombreSubmenu;
					$portalID[$i] = $portal;
					$i++;
				}
				$opciones = array(
					'idOpcion' => $opcionID,
					'opcion' => $opcionNombre,
					'idMenu' => $menuID,
					'menu' => $menuNombre,
					'idSubmenu' => $submenuID,
					'submenu' => $submenuNombre,
					'portal' => $portalID
				);
				return self::respuesta(0, "Opciones obtenidas con exito", $opciones);	
			} else {
				return self::respuesta(1, "No se encontraron opciones");
			}
		} else {
			return self::respuesta(2, "No fue posible consultar datos");
		}
					
	}
	
	public function getAcciones() {
	
		$SQL = "CALL `data_acceso`.`SP_GET_ACCIONES`();";	
		$Result = $this->RBD->SP($SQL);
		if ( $this->RBD->error() == '' ) {
			if ( mysqli_num_rows($Result) > 0 ) {
				$accionID = array();
				$accionNombre = array();
				$i = 0;
				while ( list($id, $nombre) = mysqli_fetch_row($Result) ) {
					$accionID[$i] = $id;
					$accionNombre[$i] = $nombre;
					$i++;
				}
				$acciones = array(
					'idAccion' => $accionID,
					'nombre' => $accionNombre
				);
				return self::respuesta(0, "Acciones obtenidas con exito", $acciones);
			} else {
				return self::respuesta(1, "No se encontraron acciones");
			}	
		} else {
			return self::respuesta(2, "No fue posible consultar datos");
		}	
	}
	
	public function getIdSeccion()
	{
		return $this->idSeccion;
	}
	
	public function getDescSeccion()
	{
		return $this->desSeccion;
	}
	
	public function getIdTipo()
	{
		return $this->idTipo;
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