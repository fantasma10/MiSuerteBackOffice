<?php

 include ('../../../inc/config.inc.php');
        

        $cargado = 1;
        $idDocumento = 0;
        $mensaje = 'ok';
	
		$nIdTipoDoc	= $_POST['nIdTipoDoc'];
		$sFile		= $_FILES['sFile'];
        $rfc = $_POST['rfc'];
        $usuario = $_POST['usr'];
        $descript = $rfc;
		include ('../models/repositorioTipoDocumentos.php');

		$STR = $abreviatura;
        $sTipoDoc	= str_pad($nIdTipoDoc, 3, '0', STR_PAD_LEFT);
		$file_name	= $rfc.'_'.$sTipoDoc.'_'.$STR.'.PDF';
		$dir = STORAGE_FOLDER.$rfc.'/';

		if(!is_dir($dir)){
			mkdir($dir, '0777', true);
		}

	
	   $result = copy( $sFile["tmp_name"],$dir.$file_name );
	   if (!$result) {
	           $mensaje = "ERROR: No se pudo cargar el archivo $filename, verifique los permisos";
	       } else {
           $cargado = 0;
       }


        if($cargado == 0){
           include ('../models/repositorioGuardarDocumentos.php');
           $idDocumento = $iddocumento;
        }

           $jsong = json_encode(array(
             "cargado"=>$cargado,
             "idDocs"=>$idDocumento,
               "mensaje"=>$mensaje 
           ));

            echo $jsong;
	?>