<?php
include ('../../../inc/config.inc.php');
 
        
        $cargado = 1;
        $idDocumento = 0;
        $mensaje = 'ok';
	
		$nIdTipoDoc	= $_POST['nIdTipoDoc'];
		$sFile		= $_FILES['sFile'];
        $sucursal = 'Sucursal';
        $usuario = $_POST['usr'];
        $descript = $sucursal;
		include ('../models/repositorioTipoDocumentos.php');

		$STR = $abreviatura;

        $sTipoDoc	= str_pad($nIdTipoDoc, 3, '0', STR_PAD_LEFT);
		$file_name	= date('YmdHis').'_'.$sTipoDoc.'_'.$STR.'.PDF';
		$dir = STORAGE_FOLDER.'SUCURSALES/';

		if(!is_dir($dir)){
			mkdir($dir, '0777', true);
		}

	 
	   $result = copy( $sFile["tmp_name"],$dir.$file_name );
	   if (!$result) {
	           $mensaje = "ERROR: No se pudo cargar el archivo $filename, verifique los permisos";
	       } else {
           $cargado = 0;
       }


//$misa = json_encode(array("1"=>$nIdTipoDoc,"2"=>$usuario,"3"=>$file_name,"4"=>$descript,"5"=>$dir));//tests
//echo $misa;
        if($cargado == 0){
           
           include ('../models/RepositorioGuardarDocumentos.php');
           $idDocumento = $iddocumento;
        }

           $jsong = json_encode(array(
             "cargado"=>$cargado,
             "idDocs"=>$idDocumento,
               "mensaje"=>$mensaje 
           ));

            echo $jsong;
	?>