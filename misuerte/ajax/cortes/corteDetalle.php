<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	

	
	$fechaInicio = (!empty($_POST['fecha1']))? ($_POST['fecha1']) : '0000-00-00';
	$fechaFin	= (!empty($_POST['fecha2']))? ($_POST['fecha2']) : '0000-00-00';
	$tipo = (!empty($_POST['tipo']))? ($_POST['tipo']) : '0000-00-00';
	switch ($tipo) {
	
		case 1: 

		$sql = $MRDB->query("CALL `pronosticos`.`sp_select_operaciones_metodopago`('$fechaInicio','$fechaFin')");

    
        $datos = array();

        $datos[0] = array(
			"name"	=> "Metodo de Pago",
			"data"	=> array()
	 	);

		$datos[1] = array(
			"name"	=> "Monto",
			"data"	=> array()
		);
		$datos[2] = array(
			"name"	=> "Operaciones",
			"data"	=> array()
		);

        $index = 0;
            while($row = mysqli_fetch_assoc($sql)){
                
                $datos[0]["data"][$index]= $row["sNombre"];
                $datos[1]["data"][$index]=+ $row["monto"];
                $datos[2]["data"][$index]=+ $row["operaciones"];
                $index++;
            } 

            echo json_encode($datos);

            break;

        case 2: 

        $sql = $MRDB->query("CALL `pronosticos`.`sp_select_operaciones_juego`('$fechaInicio','$fechaFin')");

    
        $datos = array();

        $datos[0] = array(
			"name"	=> "Juego",
			"data"	=> array()
	 	);

		$datos[1] = array(
			"name"	=> "Monto",
			"data"	=> array()
		);
		$datos[2] = array(
			"name"	=> "Operaciones",
			"data"	=> array()
		);

        $index = 0;
        while($row = mysqli_fetch_assoc($sql)){
                
                	
            $datos[0]["data"][$index]= utf8_encode($row["sGameName"]);
            $datos[1]["data"][$index]=+ $row["monto"];
            $datos[2]["data"][$index]=+ $row["operaciones"];
                

            $index++;
        } 

            echo json_encode($datos);




            break;



}



?>