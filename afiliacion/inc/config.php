<?php 

//include('../../inc/config.inc.php');

$R_SERVER		=	"10.10.240.125";
$R_DATABASE		=	"redefectiva";
$R_USER			=	"root";
$R_PASS			=	"Estrategia2013";
$R_PORT			=	"3306";

$W_SERVER		=	"10.10.240.125";
$W_DATABASE		=	"redefectiva";
$W_USER			=	"root";
$W_PASS			=	"Estrategia2013";
$W_PORT			=	"3306";




//	Inicializamos Base de datos de Lectura
$conn	= mysqli_connect( $W_SERVER, $W_USER, $W_PASS, $W_DATABASE);
$rconn	= mysqli_connect( $R_SERVER, $R_USER, $R_PASS, $R_DATABASE);

//	Inicializamos Base de datos de Escritura
//$WBD	=	new database($LOG, "WRITE", $W_SERVER, $W_USER, $W_PASS, $W_DATABASE, $W_PORT);


//====================== Objeto para correo =============================
//$AUTORIZADO ="";
//$MAIL 				=	new correo($AUTORIZADOR, $IP, $LOG, $RBD, $LOG, $WBD, "RED");
//$MAIL->MailD("","","","","","","");

//======================  Ruta donde se almacenan los comprobantes  =============================
$RUTACOMPROBANTES = "../../../archivos/Comprobantes/";

//Ruta para la Documentacion en Alta de Sucursales de Afiliacion Express
$RUTADOCUMENTACIONAE = $_SERVER['DOCUMENT_ROOT']."/archivos/Comprobantes/";

$WSDL3V = "http://www.3vdigitalcel.net/servicios/v3d/DigitalTAE.asmx?WSDL";
$usuarioWS3V = "USTAETEST";
$passwordWS3V = "2K8d7Hh3k";

$WSDLMTCenterServicios = "http://187.253.132.12/MTCenter.WS.PagoServicios/WSPagoServicios.asmx?WSDL";
$MTCenterCadenaServicios = "5000";
$MTCenterEstablecimientoServicios = "11678";
$MTCenterTerminalServicios = "32424";
$MTCenterCajeroServicios = "ws_test";
$MTCenterClaveServicios = "F#(/G0@dwZ";

$WSDLMTCenterTAE = "http://187.253.132.12/MTCenter.WS.TAE/Servicetae.asmx?WSDL";
$MTCenterCadenaTAE = "5000";
$MTCenterEstablecimientoTAE = "11678";
$MTCenterTerminalTAE = "32424";
$MTCenterCajeroTAE = "ws_test";
$MTCenterClaveTAE = "F#(/G0@dwZ";


/*
 * Activa la sincronizacion con Intranet.
 * En caso de ser verdadero, solo agrega usuarios
 * que tengan cuenta de usuario en Intranet y tomando
 * su ID de dicho sistema para utilizarlo en MIRED.
 * En caso de ser falso, agrega los usuarios que se
 * encuentre en Active Directory aunque no tengan
 * cuenta de usuario en Intranet y agregando el
 * proximo ID que siga consecutivamente al hacer la
 * insercion.
*/
$sincronizarConIntranet = true;

#Descripcion: Nombre del portal al que
#este acrhivo de configuracion pertenece
#Autor: Roberto Cortina
#Ultima Modificacion: 8 de Noviembre de 2013 por Roberto Cortina
$PORTAL = "Mi Red";
?>