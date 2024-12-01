<?php
//define('STORAGE_FOLDER', '/DESARROLLO/wwwroot/STORAGE/MIR/');
include ('../../../inc/config.inc.php');
	//////DATOS GENERALES!!!  LISTOOOOO!!!	
        $idsucursal 	 = $_POST['nIdSucursal'];
        $rfcsss 	     = $_POST['sRFC'];
        $idstatus 	     = 1;
        $idgiro  	     = $_POST['nIdGiro'];
        $idusuario 	     = $_POST['usuario'];;// get from session
        $iddireccion 	 = 0;
        $nomsucursal 	 = $_POST['sNombreSucursal'];
        $identificador 	 = $_POST['nIdSucursal'];
        $descripcion	 = ' ';
        $teless 	     = $_POST['sTelefono'];
        $telefono        = preg_replace("/[^0-9]/","",$teless);
        $correo 	     = $_POST['sEmail'];
        $nombress 	     = $_POST['sNombre'];
        $paternoss 	     = $_POST['sPaterno'];
        $maternoss 	     = $_POST['sMaterno'];
        $idcompdom 	     = (!empty($_POST['nidDocDom']))?$_POST['nidDocDom'] : 0;

///DIRECCION!!!!!!!! LISSSTOOOOO!!!!
       
        //$idsucursal 	= $_POST['']; ya esta arriba
        $iddireccion 	= 0;// no hay un parametro  asi que le pondremos cero al cabo la va a buscar para crear uno nuevo
        $idestatusdir 	    = 1;
        
        $idpais 	    = $_POST['nIdPais'];
        $latitud 	    = (!empty($_POST['nLatitud']))?$_POST['nLatitud'] : 0;
        $logitud 	    = (!empty($_POST['nLongitud']))?$_POST['nLongitud'] : 0;
        $codpost 	    = $_POST['nCodigoPostal'];
        $idestado	    = (!empty($_POST['nNumEntidad']))?$_POST['nNumEntidad'] : 0;
        $numciudad 	    = (!empty($_POST['nNumCiudad']))?$_POST['nNumCiudad'] : 0;
        $numcolonia 	= (!empty($_POST['nNumColonia']))?$_POST['nNumColonia'] : 0;
        $numexterno 	= $_POST['nNumExterno'];
        $numinterno 	= $_POST['sNumInterno'];
        $calle  	    = $_POST['sCalle'];
        $nomestado 	    = $_POST['sNombreEstado'];
        $nommunicip 	= $_POST['sNombreMunicipio'];
        $nomcolonia 	= $_POST['sNombreColonia'];
        


////////////CONFIGURACION!!!!!!!!!  LISSSTOOOOO!!!!

               $confArrAccesos     =   explode(',', $_POST['arrTipoAccesos']);
           


	
	/// Documentos
            //$fileCompdomPros = $_POST['cdtipopros'];

          

include('../models/sucursalNueva.php');
include('../models/sucursalNuevaDireccion.php');
include('../models/RE_ConfiguracionSucursal.php');





/*$dir = STORAGE_FOLDER.$prosRFC;

		if(!is_dir($dir)){
			mkdir($dir, '0777', true);
		}*/


$json =  json_encode(array(
    "arrayaccesos" => $confArrAccesos,
     "idsucursal" => $idsucursal,
     "rrfc" => $rfcsss,
     "status" => $idstatus,
     "giro" => $idgiro,
    "usuario" => $idusuario,
    "iddir" => $iddireccion,
    "nomsuc" => $nomsucursal,
    "identif" => $identificador,
    "descrip" => $descripcion,
    "telefono" => $telefono,
    "correo" => $correo,
     "nombre" => $nombress,
    "paterno" =>$paternoss,
    "materno" =>$maternoss,
  "idcompdom" =>$idcompdom,
    
     "iddir" => $iddireccion,
     "idestatdir" => $idestatusdir,
     "idpais" => $idpais,
     "latitud" => $latitud,
    "logitud" => $logitud,
    "codpost" => $codpost,
    "idedo" => $idestado,
    "idemuni" => $numciudad,
    "numcol" => $numcolonia,
    "numext" => $numexterno,
    "numint" => $numinterno,
     "calles" => $calle,
    "nomest" =>$nomestado,
    "nommun" =>$nommunicip,
  "nomcol" =>$nomcolonia

 ));

//echo $json;
	?>