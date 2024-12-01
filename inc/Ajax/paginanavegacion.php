<?php

/*

*******  ARCHIVO QUE GENERA LA PAGINACION DE LOS RESULTADOS DE LAS CONSULTAS ********

$funcion - Obligatoria - Cadena - Debe contener el nombre de la funcion que mandara realizar la peticion ajax 

$cant - Obligatoria - Entero - Deba contener la cantidad de registros que se mostraran por default es 20

$sqlcount - Obligatoria - Cadena - Debe contener un sql con un count para obtener el total de registros

*/

$res = '';
if($sqlcount != "" && $total == 0 && !isset($resultadosEncontrados)){
	$res = $RBD->SP($sqlcount);

	if($RBD->error() == ''){
		if($res != '' && mysqli_num_rows($res) > 0 ){
			$r = mysqli_fetch_array($res);
			$total = $r[0];
			echo "<input type='hidden' name='totalreg' id='totalreg' value='$total' />";
		}
	}else{
		echo "Error al realizar la consulta: ".$RBD->error();
		//echo "<br />".$sqlcount;
	}
}

if( isset($resultadosEncontrados) && $resultadosEncontrados > 0 ) {
	$total = $resultadosEncontrados;
	echo "<input type='hidden' name='totalreg' id='totalreg' value='$total' />";
}

if ( $verDetalle ) {
	$funcion = "verDetalleProveedor";
}

if(isset($total2) && $total2 > 0){
	$total = $total2;
}

if($total > 0 && $funcion != "" && $cant > 0){
	$cantpaginas = 10;
	$tpaginas = 0;
	echo "<div id='divpaginacion'>";
	$cm = ($_POST['cant'] > $total)?$total:$_POST['cant'];
	echo "<table class='pagina' style='margin:0px auto;'><tr><td>";
	
	$seccion = (isset($_POST['seccion']))?$_POST['seccion']:'';
		
	if($seccion != "monitor"){
		echo "<label>Mostrar #</label><input type='text' class='textfieldcito' name='cpag' id='cpag' value='".$cm."' maxlength='3' onkeypress='return validaNumeroEntero(event)' onkeyup='validaCantidad(\"$funcion\",event)' /><label>&nbsp;registros de $total</label><tr id='etbus' style='display:none'><td><p style='cursor:pointer;' class='anuncio' onclick='validaCantidad(\"$funcion\")'>\"Presione <span class='anuncio-import'  >Aqu&iacute;</span> o Enter Para Buscar\"</p></td></tr>";
		}
		echo "</td></tr><tr><td><br /></td></tr><tr><td>";
	$total = (isset($_POST['total']))?$_POST['total']:$total;
	$funcion = (isset($_POST['funcion']))?$_POST['funcion']:$funcion;
	$actual = (isset($_POST['actual']))?$_POST['actual']:1;
	$tpaginas = (int)($total/$cant);
	if(($tpaginas * $cant) < $total)
		$tpaginas++;
		if($actual == 0)
			$actual = 1;
		if($actual == 1){
			echo "<a href='#' class='anclapaginacion' disabled='true'> &lt;&lt;</a>";
			echo "<a href='#' class='anclapaginacion' disabled='disabled'> &lt;</a>";
		}else{
			echo "<a href='#' class='anclapaginacion' onclick='$funcion(1)'> &lt;&lt;</a>";
			echo "<a href='#' class='anclapaginacion' onclick='$funcion($actual-1)'> &lt;</a>";
		}
	if($tpaginas <= $cantpaginas){
		for($i=1;$i<=$tpaginas;$i++){
			if($actual == $i)
				echo "<a href='#' class='anclapaginacion' onclick='$funcion($i)'><span style='color:#f00;'>$i</span></a>";
			else
				echo "<a href='#' class='anclapaginacion' onclick='$funcion($i)'>$i</a>";
		}
	}else if($actual > $cantpaginas && $actual <= $tpaginas){
		if($actual % 10 != 0){
				$aux = $actual;
				while($aux % 10 != 0)
					$aux--;
				$a = $aux+1;
				$aux = $actual;
				while($aux % 10 != 0 && $aux < $tpaginas)
					$aux++;
				 for($i = $a;$i <= $aux; $i++){
					if($actual == $i)
						echo "<a href='#' class='anclapaginacion' onclick='$funcion($i)'><span style='color:#f00;'>$i</span></a>";
					else
						echo "<a href='#' class='anclapaginacion' onclick='$funcion($i)'>$i</a>";
				}
				
		}else{
			$aux = $actual-1;
			while($aux % 10 != 0)
				$aux--;
			$a = $aux+1;
			for($i = $a;$i <= $actual; $i++){
				if($actual == $i)
					echo "<a href='#' class='anclapaginacion' onclick='$funcion($i)'><span style='color:#f00;'>$i</span></a>";
				else
					echo "<a href='#' class='anclapaginacion' onclick='$funcion($i)'>$i</a>";
			}
		}
	}else{
		for($i=1;$i<=$cantpaginas;$i++){
			if($actual == $i)
				echo "<a href='#' class='anclapaginacion' onclick='$funcion($i)'><span style='color:#f00;'>$i</span></a>";
			else
				echo "<a href='#' class='anclapaginacion' onclick='$funcion($i)'>$i</a>";
		}
	}
	if($_POST['actual'] == $tpaginas || $tpaginas == 1){
		echo "<a href='#' class='anclapaginacion'  disabled='disabled'> &gt;</a>";
		echo "<a href='#' class='anclapaginacion' disabled='disabled'> &gt;&gt;</a>";
		echo "<input type='hidden' name='actual' id='actual' value='$actual'/>";
	}else{	
		echo "<a href='#' class='anclapaginacion' onclick='$funcion($actual+1)'> &gt;</a>";
		echo "<a href='#' class='anclapaginacion' onclick='$funcion($tpaginas)'> &gt;&gt;</a>";
		echo "<input type='hidden' name='actual' id='actual' value='$actual' />";
	}
	echo "</td></tr></table></div>";
}
?>