<?php
class Cat_Monedas{

	public $nIdMoneda;
	public $sDescripcionLarga;
	public $sDescripcionCorta;
	public $nIdEstatus;
	public $oRdb;
    public $oWdb;

    public function setNIdMoneda($valor){
        $this->nIdMoneda = $valor;
    }

    public function getNidMoneda(){
        return $this->nIdMoneda;
    }

    public function setSDescripcionLarga($valor){
        $this->sDescripcionLarga = $valor;
    }

    public function getSDescripcionLarga(){
        return $this->sDescripcionLarga;
    }

    public function setSDescripcionCorta($valor){
        $this->sDescripcionCorta = $valor;
    }

    public function getSDescripcionCorta(){
        return $this->sDescripcionCorta;
    }

    public function setNIdEstatus($valor){
        $this->nIdEstatus = $valor;
    }

    public function getNIdEstatus(){
        return $this->nIdEstatus;
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


    public function getMoneda(){
        $id_filtro          = $this->getNidMoneda();
        $array_params 		= array(
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> NULL,
				'type'	=> 'i'
			),
		);

        $this->oRdb->setBDebug(1);
		$this->oRdb->setSDatabase($_SESSION['db']);
		$this->oRdb->setSStoredProcedure('sp_select_cat_moneda');
		$this->oRdb->setParams($array_params);
        $resultado = $this->oRdb->execute();

        if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'Ha ocurrido un error al obtener los datos del catálogo    ';
			return $resultado;
		}

        $resultado = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();
        header('Content-Type: text/html; charset)utf-8');

        $filtro_resultado = array_filter($resultado, function($item) use($id_filtro){
            if($item['nIdMoneda'] == $id_filtro){
                return $item;
            }
        });

        foreach($filtro_resultado as &$item_encoding){
            $item_encoding['sDescripcionLarga'] = mb_convert_encoding($item_encoding['sDescripcionLarga'], 'UTF-8');
        }
        return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Correcta',
			'sMensajeDetallado'	=> '',
			'data'				=> $filtro_resultado
		);
    }

    public function setMoneda(){
        if(!$this->nIdMoneda){
            return array(
                'bExito'			=> false,
			    'nCodigo'			=> 0,
			    'sMensaje'			=> 'No se recive el identificador de la moneda',
			    'sMensajeDetallado'	=> '',
			    'data'				=> null
            );
        }

        $array_params 		= array(
			array(
				'name'	=> 'nIdMoneda',
				'value'	=> $this->nIdMoneda,
				'type'	=> 'i'
			),
            array(
                'name' => 'nIdEstatus',
                'value' => $this->nIdEstatus,
                'type' => 'i'
            ),
            array(
                'name' => 'sDescripcionCorta',
                'value' => null,
                'type' => 's'
            ),
            array(
                'name' => 'sDescripcionLarga',
                'value' => null,
                'type' => 's'
            )
		);

        $this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase($_SESSION['db']);
		$this->oWdb->setSStoredProcedure('sp_update_cat_moneda');
		$this->oWdb->setParams($array_params);
        $resultado = $this->oWdb->execute();
        $this->oWdb->closeStmt();

        if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'Ha ocurrido un error al obtener los datos del catálogo    ';
			return $resultado;
		}

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