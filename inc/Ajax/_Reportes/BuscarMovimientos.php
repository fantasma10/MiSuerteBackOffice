<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

//VARIABLES NECESARIAS PARA LA CREACION DEL ARCHIVO .CSV
$_SESSION['sqlmovimientos'] = "";
$_SESSION['sqltodosmovimientos'] = "";

//FILTROS EN CASO DE QUE SE BUSQUE POR CORRESPONSAL, NUM CTA. Y FECHAS
$AND = '';
$AND2 = '';
$idCadena		= (isset($_POST['idcadena']))?$_POST['idcadena']:-1;
$idSubCadena	= (isset($_POST['idsubcadena']))?$_POST['idsubcadena']:-1;
$idCorresponsal = (isset($_POST['idcorresponsal']))?$_POST['idcorresponsal']:-1;
$noCuenta 		= (isset($_POST['nocuenta']))?$_POST['nocuenta']:'';
$fecha1 		= (isset($_POST['fecha1']))?$_POST['fecha1']:'';
$fecha2 		= (isset($_POST['fecha2']))?$_POST['fecha2']:'';
$tipoM	 		= (isset($_POST['tipoM']))?$_POST['tipoM']:-1;


$aux = '';
$INNER = "";

//NECESARIO INCLUIR PARA LA PAGINACION
include("../actualpaginacion.php");

if ( $noCuenta == "" ) {
	$noCuenta = 0;
}

$res = $RBD->SP("CALL `redefectiva`.`SP_LOAD_MOVIMIENTOS`($noCuenta, $idCadena, $idSubCadena, $idCorresponsal, '$fecha1', '$fecha2', $tipoM, $actual, $cant, @codigoRespuesta, @totalRegistros);");
//var_dump("CALL `redefectiva`.`SP_LOAD_MOVIMIENTOS`($noCuenta, $idCadena, $idSubCadena, $idCorresponsal, '$fecha1', '$fecha2', $tipoM, $actual, $cant, @codigoRespuesta, @totalRegistros);");
if($RBD->error() == ""){
	if(mysqli_num_rows($res) > 0){
		$res2 = $RBD->query("SELECT @codigoRespuesta, @totalRegistros");
		if ( $RBD->error() == "" ) {
			if ( mysqli_num_rows($res2) > 0 ) {
				$resultado = mysqli_fetch_row($res2);
				$codigoRespuesta = $resultado[0];
				$resultadosEncontrados = $resultado[1];
				if ( $codigoRespuesta == 0 ) {
					$d = "<table border='0' id='ordertabla' cellspacing='0' cellpadding='0' class='tablesorter tasktable' style='margin-top:30px;'><thead><tr><th>Id Mov.</th><th>Referencia</th><th>Fec. Aplic.</th><th>Com. Corresponsal</th><th>Tipo Mov.</th><th>Cargo</th><th>Abono</th><th>Saldo Final</th></tr></thead><tbody>";
					while(list($idMov,$idOp,$fecApp,$cargo,$abono,$comCor,$saldoIni,$saldoFin,$tipoMov,$descMov) = mysqli_fetch_array($res)){
						$d .= "<tr align='center'><td>$idMov</td><td>$idOp</td><td>$fecApp</td><td>\$$comCor</td><td>$descMov</td>";
						$d .= "<td>\$".number_format($cargo,2)."</td><td>\$".number_format($abono,2)."</td><td>\$".number_format($saldoFin,2)."</td></tr>";
					}
					$d.= "</tbody></table>";
					echo utf8_encode($d);
			
					//$cant = 20;
					$funcion = "BuscarMovimientos";
			  		$sqlcount = "CALL `redefectiva`.`SP_GET_FOUND_ROWS`();";
					
					//CODIGO PARA LA PAGINACION DE LOS RESULTADOS
					echo "<table align='center'><tr><td>";
					//NECESARIO INCLUIR PARA LA PAGINACION
					include("../paginanavegacion.php");
					echo "</td></tr></table>";
				}
			}
		}
	}else{
		$res2 = $RBD->query("SELECT @codigoRespuesta");
		if ( $RBD->error() == "" ) {
			if ( mysqli_num_rows($res2) > 0 ) {
				$resultado = mysqli_fetch_row($res2);
				$codigoRespuesta = $resultado[0];
				if ( $codigoRespuesta == 500 ) {
					echo "<span style='color:#f00;margin-left:10px;'>La combinacion ingresada no tiene ninguna cuenta asociada.</span>";
				} else if ( $codigoRespuesta == 700 ) {
					echo "<span style='color:#f00;margin-left:10px;'>El numero de cuenta no coincide con la combinacion de Cadena, Sub Cadena y Corresponsal proporcionada.</span>";
				} else {
					echo "<span style='color:#f00;margin-left:10px;'>Lo sentimos pero no se encontraron movimientos.</span>";
				}
			}
		}
	}
}else{
	echo "<span style='color:#f00;'>".$RBD->error()."</span>";
}

?>