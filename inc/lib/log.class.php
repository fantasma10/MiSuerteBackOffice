<?php
####################################log.class####################################
//For break use "\n" instead '\n' 
class Log { 

	const ROOT_SYS		=	'/Server/wwwroot';
	const LOG_DIR		=	'/log';
	const NEWLINE		=  	"\r\n";

 	public $AUTORIZADOR, $IP;
	public $DATE, $APP;
	
	public $LOG_FILE;
  
	public function __construct($Autorizador,$ip,$sistema = "DEF") 
	{
	
		$this->AUTORIZADOR	= 	sprintf("%02s",$Autorizador);
		$this->IP			=	sprintf("[%15s]",$ip);
		$this->APP			= 	substr(strtoupper(trim($sistema)),0,3);
		$this->DATE		 	= 	'['.date('d.m.Y H:i:s').']'; 
	
		$this->LOG_FILE		=	self::setLogFile("LOG");
		
	}

  /* 
   Registra Errores... 
  */ 
    public function error($msg,$mail=false) 
    { 
		$Type	=	"Error";
		$Mail	=	($mail)?(TRUE):(FALSE);
		$Sent	=	($Mail)?(1):(0);
		$log	= 	"-->|Type: ".$Type."|Mail: ".$Sent."|Date: ".$this->DATE."|Server: ".$this->AUTORIZADOR."|Client: ".$this->IP."|Data: ".$msg;
		$log	.=	self::NEWLINE;						
		
		error_log($log, 3, $this->LOG_FILE); 
    } 
	
  /* 
   Registra Errores... 
  */ 
    public function logMsg($msg,$mail=false)  
    { 
		$Type	=	"Log";
		$Mail	=	($mail)?(TRUE):(FALSE);
		$Sent	=	($Mail)?(1):(0);
		$log	= 	"-->|Type: ".$Type."|Mail: ".$Sent."|Date: ".$this->DATE."|Server: ".$this->AUTORIZADOR."|Client: ".$this->IP."|Data: ".$msg;
		$log	.=	self::NEWLINE;						
		
		error_log($log, 3, $this->LOG_FILE); 
    } 
    /* 
   General Errors... 
  */ 
    public function login($user,$pass,$referer) 
    { 
		$Type	=	"Login";
		$date 	= 	date('d.m.Y H:i:s'); 
		$msg	=	"User: ".$user." - Password: ".$pass." - Page: ".$referer;
		$log	= 	"-->|Type: ".$Type."|Date:  ".$this->DATE."|Server: ".$this->AUTORIZADOR."|Client: ".$this->IP."Data: ".$msg;						
		$log	.=	self::NEWLINE;	
		
		error_log($log, 3, $this->LOG_FILE); 
    } 
    /* 
   General Errors... 
  */
  
	public function db($name,$errno,$errstr,$errfile,$errline) 
    { 
		$Type	=	"DB";
		$date 	= 	date('d.m.Y H:i:s'); 
		$msg	=	"LINK: ".$name." - ETYPE: ".$errno." - ESTR: ".$errstr." - EFILE: ".$errfile." - ELINE: ".$errline;
		$log	= 	"-->|Type: ".$Type."|Date:  ".$this->DATE."|Server: ".$this->AUTORIZADOR."|Client: ".$this->IP."Data: ".$msg;						
		$log	.=	self::NEWLINE;	
		
		error_log($log, 3, $this->LOG_FILE); 
    }  
	
    public function trx($trace,$sucursal,$proveedor,$producto,$estado,$resultado,$desc) 
    { 
		
		$TRACE	= 	sprintf("%06s", $trace);
		$CID	=	sprintf("%04s", $sucursal);
		$PR		=	sprintf("%03s", $proveedor);
		#$PROD	=	sprintf("%06s", $producto);
		$STEP	=	sprintf("%06s", $estado);
		$RESULT	=	intval($resultado);
		$MSG	=	trim($desc);
		
		$Type	=	"TRX";
		$date 	= 	date('d.m.Y H:i:s'); 
		$log	= 	"-->|Type: ".$Type."|Date: ".$this->DATE."|Trace: ".$TRACE."|STEP: ".$estado."|RESULT: ".$RESULT;
		$log	.=	"|Server: ".$this->AUTORIZADOR."|Client: ".$this->IP."|CID: ".$CID."|PR: ".$PR."|PROD: ".$producto."|Msg: ".$MSG;
		$log	.=	self::NEWLINE;					
		
		error_log($log, 3, $this->LOG_FILE); 
    } 

	private function checkDir($TIPO)
	{
		$DATE_DIR	=	'/'.date("my");
		$APP_DIR	=	'/'.$this->APP;
		$TYPE_DIR	=	'/'.$TIPO;
		
		#Revisamos si el directorio Base es correcto		
		#$BASEDIR	=	self::ROOT_SYS.self::LOG_DIR.$DATE_DIR.$APP_DIR.$TYPE_DIR;
		$BASEDIR	=	self::ROOT_SYS.self::LOG_DIR.$DATE_DIR.$APP_DIR;
		#
		#Verificamos directorio base, si no existe intentamos crearlo, si falla utilizamos /
		#
		if(file_exists($BASEDIR))
		{
			$RESULT_DIR = $BASEDIR;
		}
		else
		{
			$RESULT_DIR = (mkdir($BASEDIR, 0777, TRUE))?($BASEDIR):("");
		}
		#
		#Regresamos el directorio a utilizar para la creacion de los logs
		#
		return $RESULT_DIR;
	}

	private function setLogFile($TIPO = 'ALL')
	{
		
		$PATH		=	self::checkDir($TIPO);
		
		$FILENAME	=	'/'.date("d_my")."_".$TIPO.".log";	
		
		return $PATH.$FILENAME;

	}
	
	function __destruct() {	}
} 

?>