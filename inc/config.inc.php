<?php
##############################################################################
#
#SARE V1.0 - Configuracion
#
#Descripcion : Parametros de configuracion
#Creado 06 Noviembre 2012
#Autor	Ing. Francisco Renteria
#Ultima Modificacion: 06 Nomviembre 2012 por Francisco Renteria

##############################################################################
#
#Parametros Configuracion Ambiente PHP
#

#Descripcion : Reportar Errores, 0 Omitir errores, 1 Reportar Errores
error_reporting(E_ALL);
error_reporting(1);
ini_set('display_errors',1);
################ Librerias, Objetos y Funciones ##############################

foreach (glob(dirname(__FILE__) ."\lib\*.class.php") as $filename)
{
    include $filename;
}

foreach (glob(dirname(__FILE__) ."\obj\*.class.php") as $filename)
{
    include $filename;
}

include("ad/adLDAP.php");
include("functions.inc.php");
include("menuFunctions.php");


##############################################################################
#
#Ruta Web
#Descripcion : Ruta Raiz para el sistema
$ROOT				=	"";


#Descripcion : Conexion a Base de Datos
#
#Autor	Ing. Francisco Renteria
#Ultima Modificacion: 13 Julio 2010 por Daniel Gutierrez
#Descripcion : Objetos Generales
#


$R_SERVER		=	"10.10.250.120";
$R_DATABASE		=	"misuerte";
$R_USER			=	"dbadmin";
$R_PASS			=	"dev@dmin2018";
$R_PORT			=	"3391";

$W_SERVER		=	"10.10.250.120";
$W_DATABASE		=	"misuerte";
$W_USER			=	"dbadmin";
$W_PASS			=	"dev@dmin2018";
$W_PORT			=	"3391";

/*
$R_SERVER		=	"10.10.250.201";
$R_DATABASE		=	"redefectiva";
$R_USER			=	"dbadmin";
$R_PASS			=	"dev@dmin2020";
$R_PORT			=	"3306";

$W_SERVER		=	"10.10.250.201";
$W_DATABASE		=	"redefectiva";
$W_USER			=	"dbadmin";
$W_PASS			=	"dev@dmin2020";
$W_PORT			=	"3306";*/

/*
//charly
$R_SERVER		=	"10.10.250.201";
$R_DATABASE		=	"redefectiva";
$R_USER			=	"dbadmin";
$R_PASS			=	"dev@dmin2020";
$R_PORT			=	"3306";

$W_SERVER		=	"10.10.250.201";
$W_DATABASE		=	"redefectiva";
$W_USER			=	"dbadmin";
$W_PASS			=	"dev@dmin2020";
$W_PORT			=	"3306";
*/

//MISUERTE
/*
$RM_SERVER		= "10.10.250.120"; 
$RM_DATABASE	= "misuerte"; 
$RM_USER		= "dbadmin"; 
$RM_PASS		= "dev@dmin2018"; 
$RM_PORT		= "3391"; 

$WM_SERVER      = "10.10.250.120";
$WM_DATABASE    = "misuerte";
$WM_USER        = "dbadmin";
$WM_PASS        = "dev@dmin2018";
$WM_PORT        = "3391"; //3392
*/

//original
$RM_SERVER		= "10.10.250.120"; 
$RM_DATABASE	= "redefectiva"; 
$RM_USER		= "dbadmin"; 
$RM_PASS		= "dev@dmin2018"; 
$RM_PORT		= "3391"; 


$WM_SERVER      = "10.10.250.120";
$WM_DATABASE    = "pronosticos";
$WM_USER        = "dbadmin";
$WM_PASS        = "dev@dmin2018";
$WM_PORT        = "3392"; //3392

// PAYCASH GLOBAL
$RGLOBAL_SERVER     =    "dev-qa-paycashglobal.cekuahwifdlp.us-east-2.rds.amazonaws.com";
$RGLOBAL_DATABASE   =    "paycash_global_test";
$RGLOBAL_USER       =    "admin";
$RGLOBAL_PASS       =    "1nt3rn4t1ona1123";
$RGLOBAL_PORT       =    "3306";

$WGLOBAL_SERVER     =    "dev-qa-paycashglobal.cekuahwifdlp.us-east-2.rds.amazonaws.com";
$WGLOBAL_DATABASE   =    "paycash_global_test";
$WGLOBAL_USER       =    "admin";
$WGLOBAL_PASS       =    "1nt3rn4t1ona1123";
$WGLOBAL_PORT       =    "3306";


$monedas = array(
	1 => 'Pesos Mexicanos',
	2 => 'Peso Argentino',
	3 => 'Peso Colombiano',
	4 => 'Costa Rica',
	5 => 'Dolares',
	6 => 'Soles',
	//7 => 'Panama',
	8 => 'Guatemala',
	7 => 'Nicaragua',
);

session_start();

#Descripcion : Objeto Log, Objeto BD
$IP 	=	getIP();
$LOG 	=	new Log("",$IP,"RED");


//	Inicializamos Base de datos de Lectura Y Escritura
$RBD	=	new database($LOG, "READ", $R_SERVER, $R_USER, $R_PASS, $R_DATABASE, $R_PORT);
$WBD	=	new database($LOG, "WRITE", $W_SERVER, $W_USER, $W_PASS, $W_DATABASE, $W_PORT);

$oRdb 	=    new MyMySQLi($LOG, "READ", $R_SERVER, $R_USER, $R_PASS, $R_DATABASE, $R_PORT);
$oWdb 	=    new MyMySQLi($LOG, "WRITE", $W_SERVER, $W_USER, $W_PASS, $W_DATABASE, $W_PORT);

//MI SUERTE
//original
$MRDB   =   new MyMySQLi($LOG, "READ", $RM_SERVER, $RM_USER, $RM_PASS, $RM_DATABASE, $RM_PORT);
//$MRDB   =   new MyMySQLi($LOG, "READ", $WM_SERVER, $WM_USER, $WM_PASS, $WM_DATABASE, $WM_PORT);
$MWDB 	=   new MyMySQLi($LOG, "WRITE", $WM_SERVER, $WM_USER, $WM_PASS, $WM_DATABASE, $WM_PORT);

// Boveda
$cfgUrlBoveda = "https://sandbox-misuerte.redefectiva.net/wsewallet/service.asmx?WSDL";
$cfgClientIDBoveda = 3;
$cfgPasswordBoveda = "mypasswordgoeshere";
$cfgModeBoveda = 0;

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
/*
$array_perfiles_polizas = array(
	'perfiles_contabilidad'	=> array(3,9,1),
	'perfiles_soporte'		=> array(7,8,4)
);
*/
if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
	define('PROTOCOLO', 'https');
}
else{
	define('PROTOCOLO', 'http');
}

$BASE_URL = $BASE_URL = PROTOCOLO.'://'.$_SERVER['HTTP_HOST'];

define('URL_FACEBOOK', 'https://www.facebook.com/red.efectiva');
define('URL_TWITTER', 'https://twitter.com/redefectiva');

define('Virtual','C:/Log/Pronosticos/VentaSaldoPremio/');

// $webService_users = 'https://www.redefectiva.net/extraerusuarios/api/usuario'; //prod
$webService_users = '';//'https://sandbox-paycash.redefectiva.net/ExtraerUsuarios/api/usuario'; //dev