<?php
class Mail {
    #Variables para LOG
    const SROOTSYS	=	'/server/wwwroot';
    const SLOGDIR	=	'/log';
    const SNEWLINE	=  	"\r\n";

    private $nAutorizador;
	private $sIp;
    private $dDate;
	private $sApp;
    private $sFilename;

    #Variables para Configuracion de correo
    const SUSERNAME	=	'frankrochin';
    const SPASSWORD	=	'Estrategia2008';
    const SALTBODY	=	'Correo en Formato HTML';
    const SHOST		=	'relay.dnsexit.com';
    /*'67.214.171.66';'64.182.102.186';*/

    private $sFrom;
	private $sName;
    private $sResult;
	private $sResultMsg;
    public  $oMail;

    private $oLog;
    private $oRdb;
	
	private $sSistema;

    public function getNAutorizador() {
        return $this->nAutorizador;
    }

    public function getSIp() {
        return $this->sIp;
    }

    public function getDDate() {
        return $this->dDate;
    }

    public function getSApp() {
        return $this->sApp;
    }

    public function getSFilename() {
        return $this->sFilename;
    }

    public function getSFrom() {
        return $this->sFrom;
    }

    public function getSName() {
        return $this->sName;
    }

    public function getSResult() {
        return $this->sResult;
    }

    public function getSResultMsg() {
        return $this->sResultMsg;
    }

    public function getOMail() {
        return $this->oMail;
    }

    public function getOLog() {
        return $this->oLog;
    }

    public function getORdb() {
        return $this->oRdb;
    }

    public function getOWdb() {
        return $this->oWdb;
    }

	public function getSSistema() {
		return $this->sSistema;
	}

    public function setNAutorizador($nAutorizador) {
        $this->nAutorizador = sprintf("%02s",$nAutorizador);
    }

    public function setSIp($sIp) {
        $this->sIp = sprintf("[%15s]",$sIp);
    }

    public function setDDate($dDate) {
        $this->dDate = '['.date('d.m.Y H:i:s').']';
    }

    public function setSApp($sSistema) {
        $this->sApp = substr(strtoupper(trim($sSistema)),0,3);
    }

    public function setSFilename() {
        $this->sFilename = self::setLogFile("MAIL");
    }

    public function setSFrom($sFrom) {
        $this->sFrom = trim($sFrom);
    }

    public function setSName($sName) {
        $this->sName = trim($sName);
    }

    public function setSResult($sResult) {
        $this->sResult = $sResult;
    }

    public function setSResultMsg($sResultMsg) {
        $this->sResultMsg = $sResultMsg;
    }

    public function setOMail() {
        $this->oMail = new PHPMailer();
    }

    public function setOLog($oLog) {
        $this->oLog = $oLog;
    }

    public function setORdb($oRdb) {
        $this->oRdb = $oRdb;
    }

	public function setSSistema($sSistema) {
		$this->sSistema = $sSistema;
	}

    private function send($sTo,$sSubject,$sTemplate,$sData) {
        $arrMailAddr	=	explode(',',$sTo);
        reset($arrMailAddr);
        foreach ($arrMailAddr as $sEmail) { 
                if(trim($sEmail)){	$this->oMail->AddAddress($sEmail, $sEmail); }
        }

        $this->sResult		=	$this->oMail->Send();
        $this->sResultMsg	=	($this->sResult)?("Message sent!"):("Mailer Error: " . $this->oMail->ErrorInfo);

        self::mail_log($sTo,$sSubject,$sTemplate,$sData);

        return $this->sResult;
    }

    public function setMail() {
        $this->oMail->Username  	= self::SUSERNAME;
        $this->oMail->Password  	= self::SPASSWORD;
        $this->oMail->AltBody   	= self::SALTBODY;
        $this->oMail->From			= $this->sFrom;
        $this->oMail->FromName  	= $this->sName;	
        $this->oMail->SMTPAuth		= true;
        $this->oMail->Host			= self::SHOST;
        $this->oMail->IsSMTP();
        $this->oMail->AddReplyTo($this->sFrom,$this->sName);
    }

    private function mail_log($sTo,$sSubject,$sTemplate,$sData) {
        $sType		=	"MAIL_LOG";
        $sResult	=	($this->sResult)?(1):(0);

        $sLog	 = 	"-->|Type: ".$sType."|Date: ".$this->dDate."|RESULT: ".$sResult."|Server: ".$this->nAutorizador."|Client: ".$this->sIp;
        $sLog	.=	"|SUBJECT: ".$sSubject."|FROM: ".$this->sFrom."|TO: ".$sTo."|TEMPLATE: ".$sTemplate."|Data: ".$sData;
        $sLog	.=	"|Msg: ".$this->RESULT_MSG;
        $sLog	.=	self::SNEWLINE;						

        error_log($sLog, 3, $this->sFilename); 
    }

    private function checkDir($sTipo) {
        $dDateDir	=	'/'.date("my");
        $sAppDir	=	'/'.$this->sApp;
        $sTypeDir	=	'/'.$sTipo;

        #Revisamos si el directorio Base es correcto		
        $sBaseDir	=	self::SROOTSYS.self::SLOGDIR.$dDateDir.$sAppDir;
        #
        #Verificamos directorio base, si no existe intentamos crearlo, si falla utilizamos /
        #
        if(file_exists($sBaseDir)) {
                $sResultDir = $sBaseDir;
        }else{
                $sResultDir = (mkdir($sBaseDir, 0777, TRUE))?($sBaseDir):("");
        }
        #
        #Regresamos el directorio a utilizar para la creacion de los logs
        #
        return $sResultDir;
    }

    private function setLogFile($sTipo = 'ALL') {
        $sPath		=	self::checkDir($sTipo);

        $sFilename	=	'/'.date("d_my")."_".$sTipo.".log";	

        return $sPath.$sFilename;
    }

	public function cerrarConexiones() {
		$this->oLog = NULL;
		$this->oRdb = NULL;
	}	
	
    function __destruct() {	}
} 
?>
