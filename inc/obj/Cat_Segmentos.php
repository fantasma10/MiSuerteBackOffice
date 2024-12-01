<?php
class Cat_Segmentos{

	public $nIdSegmento;
	public $nIdEstatus;
    public $nIdNombre;
    public $oWdb;
    public $oRdb;

    public function setnIdSegmento($valor){
        $this->nIdSegmento = $valor;
    }

    public function getnIdSegmento(){
        return $this->nIdSegmento;
    }

    public function setnIdEstatus($valor){
        $this->nIdEstatus = $valor;
    }

    public function getnIdEstatus(){
        return $this->nIdEstatus;
    }

    public function setnIdNombre($valor){
        $this->nIdNombre = $valor;
    }

    public function getNombre(){
        return $this->nIdNombre;
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


    public function getSegmento(){

        $array_params 		= array(
			array(
				'name'	=> 'nIdSegmento',
				'value'	=> $this->nIdSegmento,
				'type'	=> 'i'
			),
            array(
                'name'  => 'nIdEstatus',
                'value' => $this->nIdEstatus,
                'type'  => 'i'
            )
		);

        $this->oRdb->setBDebug(1);
		$this->oRdb->setSDatabase($_SESSION['db']);
		$this->oRdb->setSStoredProcedure('sp_select_segmento');
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

    public function updateSegmento(){
        $array_params = array(
            array(
                'name'  => 'nIdSegmento',
                'value' => $this->nIdSegmento,
                'type'	=> 'i'
            ),
            array(
                'name'  => 'nIdEstatus',
                'value' => $this->nIdEstatus,
                'type'	=> 'i'
            ),
            array(
                'name' => 'nIdNombre',
                'value' => utf8_decode($this->nIdNombre),
                'type' => 's'
            ),
        );
        $this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase($_SESSION['db']);
		$this->oWdb->setSStoredProcedure('sp_update_cat_segmento');
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

    public function crearSegmento(){
        $array_params = array(
            array(
                'name'  => 'nIdEstatus',
                'value' => $this->nIdEstatus,
                'type'	=> 'i'
            ),
            array(
                'name' => 'nIdNombre',
                'value' => utf8_decode($this->nIdNombre),
                'type' => 's'
            ),
        );
        $this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase($_SESSION['db']);
		$this->oWdb->setSStoredProcedure('sp_insert_cat_segmento');
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