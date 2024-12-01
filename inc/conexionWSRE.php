<?php
//SANDBOX
// $webService = 'https://sandbox-txservice.redefectiva.net/WSAMP/server.asmx';



$webService = 'http://10.10.1.106:8088/Server.asmx?wsdl';
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
// $client = new SoapClient($webService); // sandbox


//PRODUCCION
// $webService = 'https://facturacion.redefectiva.net/Service/service.asmx?wsdl';
// $client = new SoapClient($webService);
?>