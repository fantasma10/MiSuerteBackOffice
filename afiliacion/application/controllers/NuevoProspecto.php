<?php
//define('STORAGE_FOLDER', '/DESARROLLO/wwwroot/STORAGE/MIR/');

include ('../../../inc/config.inc.php');

	//////DATOS GENERALES!!!  LISTOOOOO!!!	
        $prosIdDocRFC = (!empty($_POST['nIdDocRFC']))?$_POST['nIdDocRFC'] : 0;//$_POST['nIdDocRFC'];
        $prosIdDocDom = (!empty($_POST['nIdDocDomicilio']))?$_POST['nIdDocDomicilio'] : 0;//$_POST['nIdDocDomicilio'];
        $prosRFC = $_POST['sRFC'];
        $prosIdRegimen = $_POST['nIdRegimen'];
        $prosIdCadena = (!empty($_POST['nIdCadena']))? trim($_POST['nIdCadena']) : 1;
        $prosnIdSocio = ($_POST['nIdSocio'] == -1)?  0 : trim($_POST['nIdSocio']);
        $prosIdgiro = $_POST['nIdGiro'];

  


        
        $prosComercial = strtoupper(utf8_decode($_POST['sComercial']));
        $prosTelef = $_POST['sTelefono'];
        $prosMail = $_POST['sEmail'];
        $prosIdEjec = $_POST['nIdEjecutivoCuenta'];
        $prosIdUsr = $_POST['usuario'];
        $prosIdCte = 0;
        $prosIdTipoForelo = 1;
        $prosIdEstatus = 1;

///DIRECCION!!!!!!!! LISSSTOOOOO!!!!
       
        $dirIdPais = $_POST['idpais'];
        $dirCalle = utf8_decode($_POST['sNomCalles']);
        $dirNumExt = $_POST['nNumExterno'];
        $dirNumInt = $_POST['sNumeroInterno'];
        $dirCP = $_POST['nCodigoPostal'];
        $dirIdEstatus = 0;
        $dirIdDireccion = 0;
        $dirIdDRep = 0;

       if($dirIdPais == 164){
           
        $dirNumColonia = $_POST['nNumColonia'];
		$dirNumMunicipio = $_POST['cmbCiudad'];
		$dirNIdEstado = $_POST['cmbEntidad']; 
       $dirNombreColonia = ' ';
		$dirNombreMunicipio = ' ';
		$dirNombreEstado = ' ';
          
           
       }
        else
        {      
        
        	$dirNumColonia = 0;
			$dirNumMunicipio = 0;
			$dirNIdEstado = 0;
			$dirNombreColonia = strtoupper(utf8_decode($_POST['sNomColonia']));
			$dirNombreMunicipio = strtoupper(utf8_decode($_POST['sNomCiudad']));
			$dirNombreEstado = strtoupper(utf8_decode($_POST['sNomEstado']));
        
        }

////////INFORMACION ESPECIAL!!!!!!! LISTOOOO!!!!!


 
  
            $espPolExpuesto = (isset($_POST['bPoliticamenteExpuesto']))?$_POST['bPoliticamenteExpuesto']:0;
            $espIdStatus = 0;
            if($prosIdRegimen == 1){
                 $prosNombre = strtoupper(utf8_decode($_POST['sNombress1']));
                $prosPaterno = strtoupper(utf8_decode($_POST['sPaternoss1']));
                $prosMaterno = strtoupper(utf8_decode($_POST['sMaternoss1']));
                
                $espFechNaci    =      $_POST['dFechaNacimiento'];
                $espCURP        =      strtoupper($_POST['sCURP']);
                $espIDTipoId    =      $_POST['nIdTipoIdentificacion'];
                $espNumId       =      $_POST['sNumeroIdentificacion'];
                $espIdPaisNac   =      $_POST['nIdPaisNacimiento'];
                $espIdNacio     =      $_POST['nIdNacionalidad'];
                
                 $espIdTipoSoc   =     -1;
                $espFechaConst  =     '0000-00-00';
                $espIdDocActa   =      0;
                
                 $prosRaSoc = $prosNombre.' '.$prosPaterno.' '.$prosMaterno;   
                
            }else if($prosIdRegimen == 2){
                
                 $prosNombre = ' ';
                $prosPaterno = ' ';
                $prosMaterno = ' ';
                
                 $espFechNaci    =      '0000-00-00';
                $espCURP        =     ' ';
                $espIDTipoId    =     -1;
                $espNumId       =      ' ';
                $espIdPaisNac   =      -1;
                $espIdNacio     =      -1;
                
                $espIdTipoSoc   =      $_POST['nIdTipoSociedad'];
                $espFechaConst  =      $_POST['dFechaConstitutiva'];
                $espIdDocActa   =      (!empty($_POST['nIdDocActaConstitutiva']))?$_POST['nIdDocActaConstitutiva'] : 0; //$_POST['nIdDocActaConstitutiva'];
               $prosRaSoc = strtoupper(utf8_decode($_POST['sRazon']));
            }

////////////CONFIGURACION!!!!!!!!!  LISSSTOOOOO!!!!

                $confArrFamilias    =   explode(',', $_POST['nIdFamilias']);
                $confArrAccesos     =  explode(',', $_POST['nIdTipoAccesos']);
                //$confPerfil         =   $_POST['nIdPerfil'];
                $confVersion        =   $_POST['nIdVersion']; // este se inserta en al seccion de datos genrales.


///////////liquidacion///////////////////////

                $stat  = 0;
                $tiporeembolso  = $_POST['nIdTiporeembolso'];
                $tipocomision  = $_POST['nIdTipocomision'];
                $tipoliquidacionreembolso  = $_POST['nIdTipoliqreembolso'];
                $tipoloquidacioncomsion  = $_POST['nIdTipoloqcomsion'];


                

///////////////PAQUETESS!!!!!!!  LISSSTOOOOO!!!!

                $paqInsc            =   $_POST['nInscripcionCliente'];
                $paqAfil            =   $_POST['nAfiliacionSucursal'];
                $paqRentMens        =   $_POST['nRentaSucursal'];
                $paqAnual           =   $_POST['nAnualSucursal'];
                $paqLimSuc          =   $_POST['nLimiteSucursales'];
                $paqSuc             =   0;
                $paqProm            =   $_POST['bPromocion'];
                $paqFecVenc         =   $_POST['dFechaVencimiento'];
                $paqPriori          =   1;
                $paqIdPaq           =   $_POST['nIdPaquete'];
                $paqFecIni          =   $_POST['dFechaInicio'];

//////////////CUENTA BANCARIA!!!!!!
                $bancClabe          =   $_POST['sCLABE'];
                $bancIdBanco        =   $_POST['nIdBanco'];
                $bancCuenta         =   $_POST['nCuenta'];
                $bancBenefi         =   utf8_decode($_POST['sBeneficiario']);
                $bancDescrip        =   utf8_decode($_POST['sDescripcion']);
                $bancIdDocEdocta    =   (!empty($_POST['nIdDocEstadoCuenta']))?$_POST['nIdDocEstadoCuenta'] : 0;






///////// REPRESNETANTE LEGAL!!!!!

          if(in_array('3', $confArrFamilias) || in_array('5', $confArrFamilias) || in_array('7', $confArrFamilias)){
              
            /// DATOS GENERALES REP LEGAL!!  LISTOOOOO!!!!
               $repPolExpuesto      = (isset($_POST['bPoliticamenteExpuestoRepresentante']))?$_POST['bPoliticamenteExpuestoRepresentante']:0;
               $repId               =   0;
               $repNombre           =   strtoupper(utf8_decode($_POST['sNomReps']));
               $repPaterno          =   strtoupper(utf8_decode($_POST['sPatReps']));
               $repMaterno          =   strtoupper(utf8_decode($_POST['sMatReps']));
               $repFecNac           =   $_POST['dFechaNacimientoRepresentante'];
               $repIdNacio          =   $_POST['nIdNacionalidadRepresentante'];
               $repIdTipoID         =   $_POST['nIdTipoIdentificacionRepresentante'];
               $repNumId            =   $_POST['sNumeroIdentificacionRepresentante'];
               $repRFC              =   strtoupper($_POST['sRFCRepresentante']);
               $repCURP             =   strtoupper($_POST['sCURPRepresentante']);
               $repIdOcup           =   $_POST['nIdOcupacionRepresentante'];
               $repTelef            =   $_POST['sTelefonoRepresentante'];
               $repMail             =   $_POST['sEmailRepresentante'];
               $repIdDir            =   0;
               $repIdUsr            =    $_POST['usuario'];
               $repIdStatus         =   1;
               $repIdDocID          =  (!empty($_POST['nIdDocIdentificacion']))? $_POST['nIdDocIdentificacion'] : 0;// $_POST['nIdDocIdentificacion'];
               $repIdDocPoder       =   (!empty($_POST['nIdDocPoder']))? $_POST['nIdDocPoder'] : 0;
             
              
            //// DIRECCCION REPRESENTANTE LEGAL!!!!!! LISTOOOOO!!!
              
                 $direpPais             =   164;
                 $direpCalle            =   utf8_decode($_POST['sCalleReps']);
                 $direpNumExt           =   $_POST['sNumExtRepresentante'];
                 $direpNumInt           =   $_POST['sNumIntRepresentante'];
                 $direpCP               =   $_POST['nCodigoPostalRepresentante'];
                 $direpNumCol           =   $_POST['nNumColoniaRepresentante'];
                 $direpNumMun           =   $_POST['sMunicipioRepresentante'];
                 $direpIdEdo            =   $_POST['sEstadoRepresentante'];
                 $direpStatus           =   0;
              $direpNomEdo           =   ' ';
              $direpNomMun           =   ' ';
              $direpNomCol           =   ' ';
              
              
             include('../models/RE_RepresentanteLegal.php');
              echo $respuesta;
     }
	
	

          

include('../models/RE_ProspectoDatosGenerales.php');
include('../models/RE_ProspectoDatosEspeciales.php');
include('../models/RE_CuentaBancaria.php');
include('../models/RE_Direccion.php');
include('../models/RE_Configuracion.php');
include('../models/RE_Liquidacion.php');
include('../models/RE_PaqueteCliente.php');



/*$dir = STORAGE_FOLDER.$prosRFC;

		if(!is_dir($dir)){
			mkdir($dir, '0777', true);
		}*/


/*$json =  json_encode(array(
     "rfc" => $prosRFC,
     "nombre" => $prosNombre,
     "paterno" => $prosPaterno,
     "materno" => $prosMaterno,
    "cadena" => $prosIdCadena,
    "sociedad" => $prosnIdSocio,
    "idpais" => $dirIdPais,
    "expuesto" => $espPolExpuesto,
    "familias" => $confArrFamilias,
    "accesos" => $confArrAccesos,
    "perfil" => $confPerfil,
     "edoctaId" => $bancIdDocEdocta,
    "calle" =>$dirCalle,
    "nomrep" =>$repNombre
   // "compdompros" =>$fileCompdomPros

 ));*/

//echo $json;


//echo $conteo;
	?>