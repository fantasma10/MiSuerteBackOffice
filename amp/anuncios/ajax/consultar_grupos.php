<?php

class guardar_conf_grupos{
    private $sNombreGrupo;
    private $nIdGrupo;
    private $sDescripcion;
    private $nIdCadena;
    private $nIdCadenas;

    private $nIdCarrusel;
    private $nOpcion;

    private $nIdGrupos;
    private $nIdOrdens;
    private $sUrlTemp;

    function setsNombreGrupo($sNombreGrupo){
        $this->sNombreGrupo=$sNombreGrupo;
    }
    function setnIdGrupo($nIdGrupo){
        $this->nIdGrupo=$nIdGrupo;
    }
    function setsDescripcion($sDescripcion){
        $this->sDescripcion=$sDescripcion;
    }
    function setnIdCadena($nIdCadena){
        $this->nIdCadena=$nIdCadena;
    }

    function setnIdCarrusel($nIdCarrusel){
        $this->nIdCarrusel=$nIdCarrusel;
    }
    function setnOpcion($nOpcion){
        $this->nOpcion=$nOpcion;
    }
    function setnIdGrupos($nIdGrupos){
        $this->nIdGrupos=$nIdGrupos;
    }
    function setnIdOrdens($nIdOrdens){
        $this->nIdOrdens=$nIdOrdens;
    }
    function setsUrlTemp($sUrlTemp){
        $this->sUrlTemp=$sUrlTemp;
    }
    
    function consultarNombreGrupo(){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        
        $param = array
        (   array(
                'name'  => 'sNombreGrupo',
                'type'  => 's',
                'value' => $this->sNombreGrupo)
        );
        $oRAMP->setSStoredProcedure('sp_select_buscar_grupo');
        $oRAMP->setParams($param);
        $result2 = $oRAMP->execute();
        $data = $oRAMP->fetchAll();
        $oRAMP->closeStmt();

         $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;   
    }
    function consultaGrupoReporte(){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        
        $oRAMP->setSStoredProcedure('sp_select_grupos');
        $result2 = $oRAMP->execute();
        $data = $oRAMP->fetchAll();
        $oRAMP->closeStmt();

         $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;   
    }
    function consultarlistadoCadenasEnGrupo(){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        
        $param = array
        (   array(
                'name'  => 'nIdGrupo',
                'type'  => 'i',
                'value' => $this->nIdGrupo)
        );
        $oRAMP->setSStoredProcedure('sp_select_cadenas_grupo');
        $oRAMP->setParams($param);
        $result2 = $oRAMP->execute();
        $data = $oRAMP->fetchAll();
        $oRAMP->closeStmt();

         $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;   
    }
    function guardarCadenaEnGrupo(){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
       session_start();
	   $usuario_logueado = $_SESSION['idU'];

       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        
        $param = array
        (   
        	array(
                'name'  => 'sNombreGrupo',
                'type'  => 's',
                'value' => $this->sNombreGrupo),
        	array(
                'name'  => 'sDescripcion',
                'type'  => 's',
                'value' => $this->sDescripcion),
        	array(
                'name'  => 'nIdGrupo',
                'type'  => 'i',
                'value' => $this->nIdGrupo),
        	array(
                'name'  => 'nIdCadena',
                'type'  => 's',
                'value' => $this->nIdCadena),
        	array(
                'name'  => 'nIdUsuarioMiRed',
                'type'  => 's',
                'value' => $usuario_logueado)
        );
        //echo "call aquimispagos.sp_insert_cadenas_grupo('".$this->sNombreGrupo."', '".$this->sNombreGrupo."', ".$this->nIdGrupo.", '".$this->nIdCadena."', ".$usuario_logueado.");";

        $oRAMP->setSStoredProcedure('sp_insert_cadenas_grupo');
        $oRAMP->setParams($param);
        $result2 = $oRAMP->execute();
        $data = $oRAMP->fetchAll();
        $oRAMP->closeStmt();

         $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;   
    }
    function consultaImagenesCarrusel(){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        
        $param = array
        (   array(
                'name'  => 'nIdCarrusel',
                'type'  => 'i',
                'value' => $this->nIdCarrusel),
            array(
                'name'  => 'nOpcion',
                'type'  => 'i',
                'value' => $this->nOpcion)
        );
        $oRAMP->setSStoredProcedure('sp_select_carrusel_grupo');
        $oRAMP->setParams($param);
        $result2 = $oRAMP->execute();
        $data = $oRAMP->fetchAll();
        $oRAMP->closeStmt();

         $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;   
    }
    function guardaGrupoCarruselOrden(){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

       session_start();
       $usuario_logueado = $_SESSION['idU'];
       if ($this->sUrlTemp['name'] !=""){
          $ruta = $_SERVER['DOCUMENT_ROOT'].'\amp\anuncios\banners';
           if (!file_exists($ruta)) {
                @mkdir($ruta, 0700, true);
           }
           $imageString = file_get_contents($this->sUrlTemp['tmp_name']);
           file_put_contents($ruta.'\/'.pathinfo($this->sUrlTemp['name'],PATHINFO_FILENAME).'.webp',$imageString);
           $rutaImagen = $ruta.'\/'.pathinfo($this->sUrlTemp['name'],PATHINFO_FILENAME).'.webp';
           $rutaAWS = 'aquimispagos/banners/'.pathinfo($this->sUrlTemp['name'],PATHINFO_FILENAME).'.webp';
           //$responseAWS = subirImagenAWS($_key_aquimispagos,$_secret_aquimispagos,$_region_aquimispagos,$bucket_aquimispagos,$rutaImagen,$rutaAWS);
       }
       if($responseAWS['url'] == NULL){
            $responseAWS['url'] = '';
       }

       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        $param = array
        (   
            array(
                'name'  => 'nIdCarrusel',
                'type'  => 'i',
                'value' => $this->nIdCarrusel),
            array(
                'name'  => 'nIdGrupos',
                'type'  => 's',
                'value' => $this->nIdGrupos),
            array(
                'name'  => 'nIdOrdens',
                'type'  => 's',
                'value' => $this->nIdOrdens),
            array(
                'name'  => 'nIdUsuarioMiRed',
                'type'  => 'i',
                'value' => $usuario_logueado),
            array(
                'name'  => 'sUrl',
                'type'  => 's',
                'value' => $responseAWS['url'])
        );
        $oRAMP->setSStoredProcedure('sp_insert_grupo_carrusel_orden');
        $oRAMP->setParams($param);
        $result2 = $oRAMP->execute();
        $data = $oRAMP->fetchAll();
        $oRAMP->closeStmt();

         $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;   
    }
}

$obj = new guardar_conf_grupos();



if (!isset($_POST['case'])) {
   $data = $_POST['data'];
   $case = $data['case'];
}else{
    $case = $_POST['case'];
}
switch($case){

	case '1':
		$obj->setsNombreGrupo($data['sNombreGrupo']);
		$result=$obj->consultarNombreGrupo();
	break;
	case '2';
		$obj->setnIdGrupo($data['nIdGrupo']);
		$result=$obj->consultarlistadoCadenasEnGrupo();
	break;
	case '3':
		$obj->setsNombreGrupo($data['sNombre']);
        $obj->setsDescripcion($data['sDescripcion']);
        $obj->setnIdGrupo($data['nIdGrupo']);
        if( is_null($data['nIdCadenas'])){
            $nIdCadenasTemp = '';
        }else{
           $nIdCadenasTemp = implode(',', $data['nIdCadenas']);
        }
        $obj->setnIdCadena($nIdCadenasTemp);
		$result=$obj->guardarCadenaEnGrupo();
	break;
    case '4':
        $obj->setnIdCarrusel($data['nIdCarrusel']);
        $obj->setnOpcion($data['nOpcion']);
        $result=$obj->consultaImagenesCarrusel();
    break;
    case '5':
    include_once($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
    session_start();
        $obj->setnIdCarrusel($_POST['nIdCarrusel']);
        $obj->setnIdGrupos($_POST['nIdGrupos']);
        $obj->setnIdOrdens($_POST['nIdOrdens']);
        
        $imagenComoBase64 = 0;
        $nombreImg = '';
        if(isset($_FILES['imgBanner'])){
        $sArchivo = $_FILES['imgBanner'];
        $imageString = file_get_contents($sArchivo['tmp_name']);
        $imagenComoBase64 = base64_encode($imageString);
        $obj->setsUrlTemp($sArchivo);
        $nombreImg = pathinfo($sArchivo['name'],PATHINFO_FILENAME);
        }
        $usuario_logueado = $_SESSION['idU'];
        $jsonData=array('case'=>2,
                        'nIdCarrusel'=>$_POST['nIdCarrusel'],
                        'nIdGrupos'=>$_POST['nIdGrupos'],
                        'nIdOrdens'=>$_POST['nIdOrdens'],
                        'nIdUsuarioMiRed'=>$usuario_logueado,
                        'nombreImg'=>$nombreImg,
                        'ImgBanner'=>$imagenComoBase64 
                    );
        try{
        $URL='http://10.10.250.121:8088//index.php/CargaAnuncioBackOffice';
        $ch = curl_init();

        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result['data'] = curl_exec ($ch);
        $info = curl_getinfo($ch);
        curl_close ($ch);
        }catch(Exception $R){
            echo $R;
        }
        $result=json_decode($result['data']);
    break;
    case '6':
        $result=$obj->consultaGrupoReporte();
    break;

}
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));
    
?>