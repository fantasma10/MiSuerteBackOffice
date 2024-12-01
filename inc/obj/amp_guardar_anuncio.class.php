<?php


class guardar_conf_anuncio{
    private $sNombre;
    private $sDescripcion;
    private $sUrlTemp;
    private $sUrlAWS;
    public $oRAMP;
    private $UrlAws;

    function setsNombre($sNombre){
        $this->sNombre=$sNombre;
    }
    function setsDescripcion($sDescripcion){
        $this->sDescripcion=$sDescripcion;
    }
    function setsUrlTemp($sUrlTemp){
        $this->sUrlTemp=$sUrlTemp;
    }
    function setsUrlAWS($sUrlAWS){
        $this->sUrlAWS=$sUrlAWS;
    }

    function setoRAMP($oRAMP){
        $this->oRAMP=$oRAMP;
    }

    function setUrlAws($UrlAws){
        $this->UrlAws=$UrlAws;
    }

    function guardarAnuncio(){

       $data=array();
        
                $param = array
                (   array(
                        'name'  => 'sNombre',
                        'type'  => 's',
                        'value' => $this->sNombre),
                    array(
                        'name'  => 'sDescripcion',
                        'type'  => 's',
                        'value' => $this->sDescripcion),
                    array(
                        'name'  => 'sPath',
                        'type'  => 's',
                        'value' => $this->UrlAws)    
                );
                $this->oRAMP->setSDatabase('aquimispagos');
                $this->oRAMP->setSStoredProcedure('sp_insert_anuncio');
                $this->oRAMP->setParams($param);
                $result2 = $this->oRAMP->execute();
                $data = $this->oRAMP->fetchAll();
                $this->oRAMP->closeStmt();
            
                 
                 $ArrayRetorno['data'] = $data[0]['ID'];

        return $ArrayRetorno;   
    }
  
}

?>