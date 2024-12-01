<?php
	
		define('AUTORIZADOR', '1');
		define('APP_NAME', 'MI RED');
		$IP				=	getIP();

		$R_SERVER		=	$conexion[$nIdPaisSet]['hostR'];
		$R_DATABASE		=	$conexion[$nIdPaisSet]['dbR'];
		$R_PORT			=	$conexion[$nIdPaisSet]['portR'];
		$R_USER			=	$conexion[$nIdPaisSet]['usrR'];
		$R_PASS			=	$conexion[$nIdPaisSet]['pwR'];
		$R_NAME			= 	"READ";
		
		$W_SERVER		=	$conexion[$nIdPaisSet]['hostW'];
		$W_DATABASE		=	$conexion[$nIdPaisSet]['dbW'];
		$W_PORT			=	$conexion[$nIdPaisSet]['portW'];
		$W_USER			=	$conexion[$nIdPaisSet]['usrW'];
		$W_PASS			=	$conexion[$nIdPaisSet]['pwW'];
		$W_NAME			= 	"WRITE";		
	
		$oLog			=	new Log(AUTORIZADOR, $IP, APP_NAME);

		# Base de datos de lectura
		$oRdb	= new MyMySQLi($oLog, "READ", $R_SERVER, $R_USER, $R_PASS, $R_DATABASE, $R_PORT);

		
		# Base de datos de escritura
		$oWdb	= new MyMySQLi($oLog, "WRITE", $W_SERVER, $W_USER, $W_PASS, $W_DATABASE, $W_PORT);






?>