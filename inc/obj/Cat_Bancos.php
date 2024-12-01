<?php
class Cat_Bancos{

	public $nIdBanco;
	public $nIdEstatusBanco;
    public $nIdEmpleado;
    public $bCorresponsalia;
    public $sNombreBanco;
    public $sDescBanco;
    public $sCveBanco;
    public $oWdb;
    public $oRdb;

    public function setNIdBanco($valor){
        $this->nIdBanco = $valor;
    }

    public function getNIdBanco(){
        return $this->nIdBanco;
    }

    public function setNIdEstatusBanco($valor){
        $this->nIdEstatusBanco = $valor;
    }

    public function getNIdEstatusBanco(){
        return $this->nIdEstatusBanco;
    }

    public function setNIdEmpleado($valor){
        $this->nIdEmpleado = $valor;
    }

    public function getNIdEmpleado(){
        return $this->nIdEmpleado;
    }

    public function setBCorresponsalia($valor){
        $this->bCorresponsalia = $valor;
    }

    public function getBCorresponsalia(){
        return $this->bCorresponsalia;
    }

    public function setSNombreBanco($valor){
        $this->sNombreBanco = $valor;
    }

    public function getNombreBanco(){
        return $this->sNombreBanco;
    }

    public function setSDescBanco($valor){
        $this->sDescBanco = $valor;
    }

    public function getDescBanco(){
        return $this->sDescBanco;
    }

    public function setSCveBanco($valor){
        $this->sCveBanco = $valor;
    }

    public function getSCveBanco(){
        return $this->sCveBanco;
    }

    public function setORdb($value){
		$this->oRdb = $value;
	}

	public function getORdb(){
		return $this->oRdb;
	}

    public function setOWdb($value){
		$this->oWdb = $value;
	}

	public function getOWdb(){
		return $this->oWdb;
	}


    public function getBanco(){
        //$id_banco           = $this->getNIdBanco();
        //$id_estatus         = $this->getNIdEstatusBanco();
        $array_params 		= array(
			array(
				'name'	=> 'nIdBanco',
				'value'	=> $this->nIdBanco,
				'type'	=> 'i'
			),
            array(
                'name'  => 'nIdEstatus',
                'value' => $this->nIdEstatusBanco,
                'type'  => 'i'
            )
		);

        $this->oRdb->setBDebug(1);
		$this->oRdb->setSDatabase($_SESSION['db']);
		$this->oRdb->setSStoredProcedure('sp_select_cat_banco');
		$this->oRdb->setParams($array_params);
        $resultado = $this->oRdb->execute();

        if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'Ha ocurrido un error al obtener los datos del catálogo ';
			return $resultado;
		}

        $resultado = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();
        header('Content-Type: text/html; charset)utf-8');

        return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Correcta',
			'sMensajeDetallado'	=> '',
			'data'				=> $resultado
		);
    }

    public function updateBanco(){
        $array_params = array(
            array(
                'name'  => 'nIdBanco',
                'value' => $this->nIdBanco,
                'type'	=> 'i'
            ),
            array(
                'name'  => 'nIdEstatus',
                'value' => $this->nIdEstatusBanco,
                'type'	=> 'i'
            ),
            array(
                'name' => 'NidEmpleado',
                'value' => $this->nIdEmpleado,
                'type' => 'i'
            ),
            array(
                'name' => 'Corresponsalia',
                'value' => $this->bCorresponsalia,
                'type' => 'i'
            ),
            array(
                'name' => 'sNombreBanco',
                'value' => utf8_decode($this->sNombreBanco),
                'type' => 's'
            ),
            array(
                'name' => 'sDescBanco',
                'value' => utf8_decode($this->sDescBanco),
                'type' => 's'
            ),
            array(
                'name' => 'sCveBanco',
                'value' => $this->sCveBanco,
                'type' => 's'
            )
        );
        $this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase($_SESSION['db']);
		$this->oWdb->setSStoredProcedure('sp_update_cat_banco');
		$this->oWdb->setParams($array_params);
        $resultado = $this->oWdb->execute();

        if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'Ha ocurrido un error al obtener los datos del catálogo    ';
			return $resultado;
		}

        $resultado = $this->oWdb->fetchAll();
        $this->oWdb->closeStmt();

        return array(
            'bExito'			=> true,
            'nCodigo'			=> 0,
            'sMensaje'			=> 'Consulta Correcta',
            'sMensajeDetallado'	=> '',
            'data'				=> $resultado
        );
    }

    public function crearBanco(){
        $array_params = array(
            array(
                'name'  => 'nIdBanco',
                'value' => $this->nIdBanco,
                'type'	=> 'i'
            ),
            array(
                'name'  => 'nIdEstatus',
                'value' => $this->nIdEstatusBanco,
                'type'	=> 'i'
            ),
            array(
                'name' => 'NidEmpleado',
                'value' => $this->nIdEmpleado,
                'type' => 'i'
            ),
            array(
                'name' => 'Corresponsalia',
                'value' => $this->bCorresponsalia,
                'type' => 'i'
            ),
            array(
                'name' => 'sNombreBanco',
                'value' => utf8_decode($this->sNombreBanco),
                'type' => 's'
            ),
            array(
                'name' => 'sDescBanco',
                'value' => utf8_decode($this->sDescBanco),
                'type' => 's'
            ),
            array(
                'name' => 'sCveBanco',
                'value' => $this->sCveBanco,
                'type' => 's'
            )
        );
        $this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase($_SESSION['db']);
		$this->oWdb->setSStoredProcedure('sp_insert_cat_banco');
		$this->oWdb->setParams($array_params);
        
        $resultado = $this->oWdb->execute();
        if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'Ha ocurrido un error al obtener los datos del catálogo    ';
			return $resultado;
		}

        $resultado = $this->oWdb->fetchAll();
        $this->oWdb->closeStmt();

        return array(
            'bExito'			=> true,
            'nCodigo'			=> 0,
            'sMensaje'			=> 'Consulta Correcta',
            'sMensajeDetallado'	=> '',
            'data'				=> $resultado
        );
    }
	

	
}

?>