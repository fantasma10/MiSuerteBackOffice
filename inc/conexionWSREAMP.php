<?php
    $webService = 'http://10.10.1.106:9020/Servicios/ServMigracion.asmx?WSDL'; // URL Web Service de Aquimispagos
    $página_inicio = file_get_contents($webService); 

    if($página_inicio != ''){
        $opts = array(
            'ssl' => array(
                'ciphers' => 'RC4-SHA',
                'verify_peer' => false,
                'verify_peer_name' => false
            )
        );
        
        // SOAP 1.2 client
        $params = array( 
            'encoding' => 'UTF-8',
            'verifypeer' => false,
            'verifyhost' => false,
            'soap_version' => SOAP_1_2,
            'trace' => 1,
            'exceptions' => 1,
            'connection_timeout' => 180,
            'stream_context' => stream_context_create($opts)
        );
        $client = new SoapClient($webService,$params);
    }else{
        $client = '';
    }
?>