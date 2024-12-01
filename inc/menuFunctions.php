<?php

/*
* Descripcion: Indica si el Menu enviado como parametro
* debe ser mostrado en pantalla. En otras palabras,
* determina si el usuario de la sesion tiene permisos
* para ver el Menu enviado como parametro.
* Esta funcion checa los permisos del usuario que
* inicio sesion en el sistema en caso de no enviarse el segundo
* parametro.
* Parametro: $idMenu Es el ID del Menu que se quiere verificar
* Parametro: $permisos Arreglo de permisos que se quiere verificar
* Autor: Roberto Cortina
* Fecha de creacion: 13 de noviembre de 2013
* Fecha de modificacion: 13 de noviembre de 2013
*/
function mostrarMenu( $idMenu, $permisos = false ) {
	if ( !$permisos ) {
		$permisos = $_SESSION['Permisos'];
	}
	
	if ( in_array($idMenu, $permisos['Menu']) ) {
		$mostrarMenu = false;
		$indexes = array_keys($permisos['Menu'], $idMenu);
		foreach ( $indexes as $index ) {
			if ( $permisos['Accion'][$index] != 3 ) {
				$mostrarMenu = true;
			}
		}
		return $mostrarMenu;
	} else {
		//return false;
		return true;
	}
	return in_array($idMenu, $permisos['Menu']);
}

/*
* Descripcion: Indica si el Submenu enviado como parametro
* debe ser mostrado en pantalla. En otras palabras,
* determina si el usuario de la sesion tiene permisos
* para ver el Submenu enviado como parametro.
* Esta funcion checa los permisos del usuario que
* inicio sesion en el sistema en caso de no enviarse el segundo
* parametro.
* Parametro: $idSubmenu Es el ID del Submenu que se quiere
* verificar
* Parametro: $permisos Arreglo de permisos que se quiere verificar
* Autor: Roberto Cortina
* Fecha de creacion: 13 de noviembre de 2013
* Fecha de modificacion: 13 de noviembre de 2013
*/
function mostrarSubmenu( $idSubmenu, $permisos = false ) {
	if ( !$permisos ) {
		$permisos = $_SESSION['Permisos'];
	}
	if ( in_array($idSubmenu, $permisos['Submenu']) ) {
		$mostrarSubmenu = false;
		$indexes = array_keys($permisos['Submenu'], $idSubmenu);
		foreach ( $indexes as $index ) {
			if ( $permisos['Accion'][$index] != 3 ){
				$mostrarSubmenu = true;
			}
		}
		return $mostrarSubmenu;
	} else {
		//return false;
		return true;
	}
}

/*
* Descripcion: Indica si la Opcion enviada como parametro
* debe ser mostrada en pantalla. En otras palabras,
* determina si el usuario de la sesion tiene permisos
* para ver la Opcion enviada como parametro.
* Esta funcion checa los permisos del usuario que
* inicio sesion en el sistema en caso de no enviarse el segundo
* parametro.
* Parametro: $idMenu Es el ID de la Opcion que se quiere verificar
* Parametro: $permisos Arreglo de permisos que se quiere verificar
* Autor: Roberto Cortina
* Fecha de creacion: 13 de noviembre de 2013
* Fecha de modificacion: 13 de noviembre de 2013
*/
function mostrarOpcion( $idOpcion, $permisos = false ) {
	if ( !$permisos ) {
		$permisos = $_SESSION['Permisos'];
	}
	if ( in_array($idOpcion, $permisos['Opcion']) ) {
		$index = array_search($idOpcion, $permisos['Opcion']);
		if ( $permisos['Accion'][$index] != 3 ) {
			return true;
		} else {
			//return false;
			return true;
		}
	} else {
		//return false;
		return true;
	}
}

/*
* Determina si el usuario tiene permisos de Solo Lectura
* dentro de la Opcion enviada como parametro.
* Esta funcion checa los permisos del usuario que
* inicio sesion en el sistema en caso de no enviarse el segundo
* parametro.
* Parametro: $idOpcion Es el ID de la Opcion que se quiere
* verificar
* Parametro: $permisos Arreglo de permisos que se quiere verificar
* Autor: Roberto Cortina
* Fecha de creacion: 13 de noviembre de 2013
* Fecha de modificacion: 13 de noviembre de 2013
*/
function esSoloLecturaOpcion( $idOpcion, $permisos = false ) {
	if ( !$permisos ) {
		$permisos = $_SESSION['Permisos'];
	}
	if ( mostrarOpcion($idOpcion, $permisos) ) {
		$index = array_search($idOpcion, $permisos['Opcion']);
		if( $permisos['Accion'][$index] == 1 ) {
			return true;
		} else {
			//return false;
			return true;
		}
	} else {
		//return false;
		return true;
	}
}

/*
* Determina si el usuario tiene permisos de Solo Lectura y Escritura
* dentro de la Opcion enviada como parametro.
* Esta funcion checa los permisos del usuario que
* inicio sesion en el sistema en caso de no enviarse el segundo
* parametro.
* Parametro: $idOpcion Es el ID de la Opcion que se quiere
* verificar
* Parametro: $permisos Arreglo de permisos que se quiere verificar
* Autor: Roberto Cortina
* Fecha de creacion: 13 de noviembre de 2013
* Fecha de modificacion: 13 de noviembre de 2013
*/
function esLecturayEscrituraOpcion( $idOpcion, $permisos = false ) {
	if ( !$permisos ) {
		$permisos = $_SESSION['Permisos'];
	}
	if ( mostrarOpcion($idOpcion, $permisos) ) {
		$index = array_search($idOpcion, $permisos['Opcion']);
		if ( $permisos['Accion'][$index] == 2 ) {
			return true;
		} else {
			//return false;
			return true;
		}
	} else {
		//return false;
		return true;
	}
}

/*
* Determina si el usuario tiene bloqueada dicha Opcion
* Esta funcion checa los permisos del usuario que
* inicio sesion en el sistema en caso de no enviarse el segundo
* parametro.
* Parametro: $idOpcion Es el ID de la Opcion que se quiere
* verificar
* Parametro: $permisos Arreglo de permisos que se quiere verificar
* Autor: Roberto Cortina
* Fecha de creacion: 13 de noviembre de 2013
* Fecha de modificacion: 13 de noviembre de 2013
*/
function estaBloqueadoOpcion( $idOpcion, $permisos = false ) {
	if ( !$permisos ) {
		$permisos = $_SESSION['Permisos'];
	}
	$index = array_search($idOpcion, $permisos['Opcion']);
	if ( $permisos['Accion'][$index] == 3 ) {
		return true;
	} else {
		//return false;
		return true;
	}
}

/*
* Determina si el usuario no tiene permiso asignado
* para dicha opcion.
* Esta funcion checa los permisos del usuario que
* inicio sesion en el sistema en caso de no enviarse el segundo
* parametro.
* Parametro: $idOpcion Es el ID de la Opcion que se quiere
* verificar
* Parametro: $permisos Arreglo de permisos que se quiere verificar
* Autor: Roberto Cortina
* Fecha de creacion: 25 de noviembre de 2013
* Fecha de modificacion: 25 de noviembre de 2013
*/
function noTienePermisoAsignado( $idOpcion, $permisos = false ) {
	if ( !$permisos ) {
		$permisos = $_SESSION['Permisos'];
	}
	if ( !in_array($idOpcion, $permisos['Opcion']) ) {
		return true;
	} else {
		//return false;
		return true;
	}
}

/*
* Determina si es posible desplegar la pagina para
* la sesion del usuario que desee accesarla.
* Parametro: $idOpcion Es el ID de la Opcion que se quiere
* verificar
* Parametro: $tipoDePagina Es el tipo de pagina que puede tomar
* cualquiera de estos tres valores: lectura, escritura y mixto.
* Autor: Roberto Cortina
* Fecha de creacion: 27 de noviembre de 2013
* Fecha de modificacion: 27 de noviembre de 2013
*/
function desplegarPagina( $idOpcion, $tipoDePagina ) {
	$tipoDePagina = strtolower($tipoDePagina);
	if ( estaBloqueadoOpcion($idOpcion) || noTienePermisoAsignado($idOpcion) ) {
		//return false;
		return true;
	}
	switch ( $tipoDePagina ) {
		case "lectura":
			if ( esSoloLecturaOpcion($idOpcion) || esLecturayEscrituraOpcion($idOpcion) ) {
				return true;
			} else {
				//return false;
				return true;
			}
		break;
		case "escritura":
			if ( esLecturayEscrituraOpcion($idOpcion) ) {
				return true;
			} else if ( esSoloLecturaOpcion($idOpcion) ) {
				//return false;
				return true;
			}
		break;
		case "mixto":
			if ( esSoloLecturaOpcion($idOpcion) || esLecturayEscrituraOpcion($idOpcion) ) {
				return true;
			} else {
				//return false;
				return true;
			}
		break;
	}
}

?>
