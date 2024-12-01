<?php
####################################log.class####################################
//For break use "\n" instead '\n'
class database{

    public $HOST, $USER, $PASSWORD, $PORT, $DATABASE, $NAME, $TIMEOUT;
    public $COUNT;
    public $LINK;
    public $LOG;

    public $ERROR;

    public function __construct($log,$name,$host,$user,$password,$database,$port = 3306,$timeout = 5)
    {

        $this->NAME			= 	trim($name);
        $this->HOST			= 	trim($host);
        $this->USER			=	trim($user);
        $this->PASSWORD		= 	trim($password);
        $this->DATABASE		=	trim($database);
        $this->TIMEOUT		= 	$timeout;
        $this->PORT		 	= 	$port;

        $this->COUNT		= 	0;

        $this->LOG			=	$log;

        #$this->OLD_ERROR_HANDLER = set_error_handler("self::catchME",E_WARNING);

        self::initDatabase();
    }


    public function setDatabase($NEWDB)
    {
        $this->DATABASE	= ($this->LINK->select_db($NEWDB))?($NEWDB):($this->DATABASE);

        return $this->DATABASE;
    }

    public function getName()
    {
        return $this->NAME;
    }

    public function getPort()
    {
        return $this->PORT;
    }

    public function getHost()
    {
        return $this->HOST;
    }

    public function getDatabase()
    {
        return $this->DATABASE;
    }

    public function error()
    {
        return $this->LINK->error;
    }

    public function lastId()
    {
        return $this->LINK->insert_id;
    }

    public function rowcount()
    {
        return $this->COUNT;
    }

    public function check()
    {
        return (mysqli_connect_error())?(FALSE):(TRUE);
    }

    public function query($QUERY)
    {
        if(self::check()){
            try{
                self::clean_db($this->LINK,NULL,FALSE);
                $RESULT = $this->LINK->query($QUERY);
                self::clean_db($this->LINK,$RESULT,FALSE);

                return $RESULT;

            }catch(Exception $e){

                self::catchME($e->getCode(),$e->getMessage(),$e->getFile(),$e->getLine());

                return false;
            }
        }else{
            return false;
        }
    }

    public function SP($QUERY)
    {
        if(self::check()){
            try{
                self::clean_db($this->LINK,NULL);
                $RESULT = $this->LINK->query($QUERY);
                self::clean_db($this->LINK,$RESULT);

                return $RESULT;

            }catch(Exception $e){

                self::catchME($e->getCode(),$e->getMessage(),$e->getFile(),$e->getLine());

                return false;
            }
        }else{
            return false;
        }
    }

    public function ejecutarComando($psComando){
        $nAfectados = -1;
        $bResult = false;
        if ($psComando==""){
            exit("Error de codificaci&oacute;n, falta indicar el comando");
        }
        if (!$this->LINK){
            exit("Error de codificaci&oacute;n, falta conectar la base");
        }

        self::clean_db($this->LINK,NULL);
        $bResult = $this->LINK->query($psComando);//mysqli_query($this->LINK,$psComando);
        self::clean_db($this->LINK,$bResult);

        if ($bResult){
            $nAfectados = mysqli_affected_rows($this->LINK);
        }
        return $nAfectados;
    }

    function fetch_array($consulta)
    {
        return mysqli_fetch_array($consulta);
    }

    function num_rows($consulta)
    {
        return mysqli_num_rows($consulta);
    }

    function fetch_row($consulta)
    {
        return mysqli_fetch_row($consulta);
    }
    function fetch_assoc($consulta)
    {
        return mysqli_fetch_assoc($consulta);
    }








    public function close()
    {
        return $this->LINK->close();
    }

    public function getInfo()
    {
        return $this->LINK->info;
    }
    private function initDatabase()
    {
        $this->LINK = mysqli_init();

        if (!$this->LINK) {

            $this->LOG->error($this->NAME.' : '."Falla al crear link ",FALSE);

            return false;
        }

        if (!mysqli_options($this->LINK, MYSQLI_OPT_CONNECT_TIMEOUT, $this->TIMEOUT)) {

            $this->LOG->error($this->NAME.' : '."Setting MYSQLI_OPT_CONNECT_TIMEOUT failed ",FALSE);

            return false;
        }

        if (!mysqli_real_connect($this->LINK, $this->HOST, $this->USER, $this->PASSWORD, $this->DATABASE, $this->PORT)) {
            // 	$this->LOG->error("Falla en conexion de Base de Datos ".$this->NAME." : ".mysqli_connect_errno(),FALSE);
            // 	#$this->LOG->error($this->NAME.' : '.'Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error(),FALSE);

            return false;
        }

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        return true;
    }

    private function catchME($errno,$errstr,$errfile,$errline)
    {
        $this->LOG->db($this->NAME,$errno,$errstr,$errfile,$errline);

        return true;
    }

    private function catchError()
    {
        if($this->LINK->errno > 0)
        {
            $this->ERROR	=	$this->LINK->error;
            $this->LOG->error($this->ERROR);
        }
    }

    private function clean_db($result)
    {
        if($this->LINK->more_results())
        {
            $this->LINK->next_result();
        }

        /**
        while(mysqli_next_result($this->LINK))
        {
        if($l_result = mysqli_store_result($this->LINK))
        {
        mysqli_free_result($l_result);
        }
        }
         **/

        if($result != NULL){
            if(is_resource($result)) {
                mysqli_free_result($result);
            }
        }

        /**
        $result->close();
        while(mysql_result($this->LINK)){}
        if($this->LINK->more_results())
        {
        $this->LINK->next_result();
        }
         **/
    }

    function __destruct() {	}
}


class MyMySQLi extends database{

    public $sHost;
    public $sUser;
    public $sPassword;
    public $sDatabase;
    public $sPort;
    public $CONNECTION;
    public $sObjectType;
    public $LOG;
    public $bDebug = 0;
    public $stmt;
    public $result;

    public function setSHost($sHost){
        $this->sHost = $sHost;
    }

    public function getSHost(){
        return $this->sHost;
    }

    public function setSUser($sUser){
        $this->sUser = $sUser;
    }

    public function getSUser(){
        return $this->sUser;
    }

    public function setSPassword($sPassword){
        $this->sPassword = $sPassword;
    }

    public function getSPassword(){
        return $this->sPassword;
    }

    public function setSDatabase($sDatabase){
        $this->sDatabase = $sDatabase;
    }

    public function getSDatabase(){
        return $this->sDatabase;
    }

    public function setSPort($sPort){
        $this->sPort = $sPort;
    }

    public function getSPort(){
        return $this->sPort;
    }

    public function setCONNECTION($CONNECTION){
        $this->LINK = $CONNECTION;
    }

    public function getCONNECTION(){
        return $this->LINK;
    }

    public function setSObjectType($sObjectType){
        $this->sObjectType = $sObjectType;
    }

    public function getSObjectType(){
        return $this->sObjectType;
    }

    public function setLOG($LOG){
        $this->LOG = $LOG;
    }

    public function getLOG(){
        return $this->LOG;
    }

    public function setSStoredProcedure($sStoredProcedure){
        $this->sStoredProcedure = $sStoredProcedure;
    }

    public function getSStoredProcedure(){
        return $this->sStoredProcedure;
    }

    public function setParams($arrParams){
        $this->arrParams = $arrParams;
    }

    public function getParams(){
        return $this->arrParams;
    }

    public function setBDebug($bDebug){
        $this->bDebug = $bDebug;
    }

    public function getBDebug(){
        return $this->bDebug;
    }

    public function setResult($result){
        $this->result = $result;
    }

    public function getResult(){
        return $this->result;
    }


    /*public function __construct($sHost, $sUser, $sPassword, $sDatabase, $sObjectType = '', $LOG, $sPort = 3306){
        self::setShost($sHost);
        self::setSUser($sUser);
        self::setSPassword($sPassword);
        self::setSDatabase($sDatabase);
        self::setSPort($sPort);
        self::setSObjectType($sObjectType);
        self::setLOG($LOG);

        self::_connectme();
    }*/

    /*
        Realiza la conexion a la base de datos, en caso de error se guarda el mensaje en el log
    */
    /*private function _connectme(){

		$this->LINK = new mysqli($this->sHost, $this->sUser, $this->sPassword, $this->sDatabase);
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		if($this->LINK->connect_error) {
			$this->LOG->error('Connect Error (' . $this->LINK->connect_errno . ') '. $this->LINK->connect_error);
		}
	}*/

    /*
        Por cada parametro encontrado lo concatena
        Devuelve un string con el siguiente formato : ?,?,?,?,?
    */
    private function _getParamsString(){
        $arrParams		= self::getParams();
        $length			= count($arrParams);
        $paramsString	= "";

        for($i=0; $i<$length; $i++){
            $paramsString .= "?,";
        }

        $paramsString = trim($paramsString, ',');

        return $paramsString;
    } # getParamsString

    /*
        Recorre arrParams y devuelve sus valores concatenados.
        Ejemplo '1', 'Hola', '16.02', '2016-09-08'
    */
    private function _concatenateParams(){
        $arrParams = self::getParams();

        if(count($arrParams) >= 1){
            $length = count($arrParams);


            for($i=0; $i < $length; $i++){
                $arrValues[] = $arrParams[$i]['value'];
            }
            $sParams	= implode("','", $arrValues);
        }
        else{
            $sParams = "";
        }

        return "'".$sParams."'";
    } # concatenateParams

    /*
        Guarda en el log el query ejecutado
        Ejemplo CALL `redefectiva`.`SP_SELECT_TIPOOPERACION`('-1', '0');
    */
    private function _debugQuery(){
        $sParams		= self::_concatenateParams();
        $sDebugQuery	= "CALL `".self::getSDatabase()."`.`".self::getSStoredProcedure()."`(".$sParams.");";

        $this->LOG->error($sDebugQuery);
    } # debugQuery

    /*
        Esta funcion asigna los valores a los parametros definidos, utilizando la funcion bind_param de mysqli.
        Crea el string de tipo de parametros ('iissd')
        Llena un arreglo con los valores de los parámetros recibidos
    */
    private function _bindParams(){
        $arrParams		= self::getParams();
        $stringTypes	= "";
        $stringValues	= "";

        if(count($arrParams) >= 1){
            $length			= count($arrParams);
            $array_params	= array();
            $param_type		= "";

            for($i = 0; $i < $length; $i++) {
                $param_type .= $arrParams[$i]['type'];
            }

            $array_params[] =& $param_type;

            for($i = 0; $i < $length; $i++) {
                $array_params[] =& $arrParams[$i]['value'];
            }

            call_user_func_array(array($this->stmt, 'bind_param'), $array_params);
        }
    } # bindParams

    /*
        Ejecuta la consulta, en caso de error guarda un mensaje en el log, con el número de error, mensaje de error y consulta ejecutada (sin parámetros)
    */
    public function execute(){
        if($this->bDebug == 1){
            self::_debugQuery();
        }

        $paramsString	= self::_getParamsString();
        $queryString	= "CALL `".self::getSDatabase()."`.`".self::getSStoredProcedure()."`(".$paramsString.");";

        try{
            $this->stmt = $this->LINK->prepare($queryString);
            self::_bindParams();
            $this->stmt->execute();
            $this->result = $this->stmt->get_result();

            return array(
                'bExito'			=> true,
                'nCodigo'			=> 0,
                'sMensaje'			=> 'Ok',
                'sMensajeDetallado'	=> 'Ok'
            );
        }
        catch(mysqli_sql_exception $e){
            $this->LOG->error("Error al ejecutar ".$queryString." (".$e->getCode().") : ".$e->getMessage()." L ".$e->getLine()." FILE ".$e->getFile());

            return array(
                'bExito'			=> false,
                'nCodigo'			=> $e->getCode(),
                'sMensaje'			=> 'Ha ocurrido un error al realizar la operacion ('.$e->getCode().')',
                'sMensajeDetallado'	=> "Error al ejecutar ".$queryString." (".$e->getCode().") : ".$e->getMessage()." L ".$e->getLine()." FILE ".$e->getFile()
            );
        }
    } # execute

    /*
        Hace una llamada "fetch_all" de mysqli, enviando como parametro MYSQLI_ASSOC
        Retorna un arreglo con una lista de arreglos con los valores retornados por la consulta.
        array(
            array('sNombre' => 'Fulanita', 'nEdad' => '24', 'sEstado' => 'Nuevo Leon'),
            array('sNombre' => 'Fulanito', 'nEdad' => '27', 'sEstado' => 'Tamaulipas'),
            ...
        );
    */
    public function fetchAll(){
        $array = $this->result->fetch_all(MYSQLI_ASSOC);

        return $array;
    } # fetchAll

    public function fetchObject($className = 'StdClass'){
        $array = array();

        while($obj = $this->result->fetch_object($className)){
            $array[] = $obj;
        }

        return $array;
    } # fetchAll

    /*
        Retorna el numero de filas encontradas
    */
    public function numRows(){
        return $this->result->num_rows;
    } # numRows

    /*
        Cierra la sentencia preparada
    */
    public function closeStmt(){
        $this->stmt->close();
    } # closeStmt

    /*
        Libera la memoria del resultado
    */
    public function freeResult(){
        $this->result->free_result();
    } # freeResult

    public function closeConnection(){
        $this->LINK->close();
    }

    public function lastInsertId(){
        $this->stmt->prepare("SELECT LAST_INSERT_ID() AS last_insert_id");
        $this->stmt->execute();
        $this->result = $this->stmt->get_result();

        $array = self::fetchAll();

        return $array[0]['last_insert_id'];
    }

    public function foundRows(){
        $this->stmt = $this->LINK->prepare("SELECT FOUND_ROWS() AS found_rows");
        $this->stmt->execute();
        $this->result = $this->stmt->get_result();

        $array = self::fetchAll();

        return $array[0]['found_rows'];
    }
} #MyMySQLi


?>