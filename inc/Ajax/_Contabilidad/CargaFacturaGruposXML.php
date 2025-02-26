<?php

    /*error_reporting(E_ALL);
    ini_set('display_errors', 1);*/

	$error = "";
	$msg = "0|";
	$fileElementName = 'fileToUpload';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{
                    case '1':
                            $error = 'The uploaded file exceeds the upload_max_filesize par&aacute;metro en el archivo php.ini';
                            break;
                    case '2':
                            $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                            break;
                    case '3':
                            $error = 'The uploaded file was only partially uploaded';
                            break;
                    case '4':
                            $error = 'No file was uploaded.';
                            break;

                    case '6':
                            $error = 'Missing a temporary folder';
                            break;
                    case '7':
                            $error = 'Failed to write file to disk';
                            break;
                    case '8':
                            $error = 'File upload stopped by extension';
                            break;
                    case '999':
                    default:
                            $error = 'No error code avaiable';
		}
	}
    elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none') {
		$error = 'No file was uploaded..';
	}
    else{
        $_GET["archivoXML"] = $_FILES[$fileElementName]["tmp_name"];
        $data = require("CargaFacturaXML-Grupos.php");            
	}

    echo json_encode(array(
        'success'   => ($error != '' OR $data['success'] == false)? false : true,
        'showMsg'   => ($error != '' OR $data['showMsg'] == 1)? 1 : 0,
        'error'     => $error,
        'errmsg'    => $data['errmsg'],
        'msg'       => $data['msg'],
        'data'      => $data['data']
    ));
?>