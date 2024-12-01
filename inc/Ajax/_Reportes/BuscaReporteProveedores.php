<?php

ini_set('display_errors', 0);

include("../../config.inc.php");
include("../../session.ajax.inc.php");

$proveedor = (isset($_POST['proveedor']))?$_POST['proveedor']:'';
$familia = (isset($_POST['familia']))?$_POST['familia']:'';
$fecha1 = (isset($_POST['fecha1']))?$_POST['fecha1']:'';
$fecha2 = (isset($_POST['fecha2']))?$_POST['fecha2']:'';
$verDetalle = (isset($_POST['verDetalle']))?$_POST['verDetalle']:'';
$totalReg = (isset($_POST['totalReg']))?$_POST['totalReg']:'';

$AND = "";
if($proveedor != '')
	$AND.= " AND `idProveedor` = $proveedor ";
if($familia != '')
	$AND.= " AND `ops_operacion`.`idFamilia` = $familia ";

if ( empty($proveedor) ) {
	$proveedor = "NULL";
}
if ( empty($familia) ) {
	$familia = "NULL";
}

//NECESARIO INCLUIR PARA LA PAGINACION
if ( $verDetalle ) {
	include("../actualpaginacion.php");
}

//QUERY PARA LOS PROVEEDORES

$sql = "SELECT `idsOperacion`,
    COUNT(`idsOperacion`),
    `descProducto` AS PROD,
    SUM(  IF( `idFlujoImp`>0, `importeOperacion` , ( -1 * `importeOperacion` ) )  ) AS IMPOP,
    SUM(`totComCliente`) AS COMCLI,
    SUM(  IF( `idFlujoImp`>0, ((`importeOperacion`+`totComCliente`)/(1+`perIvaOperacion`)) , ( -1 * ((`importeOperacion`+`totComCliente`)/(1+`perIvaOperacion`)) ) )  ) AS SUBTOTAL,
    SUM(  IF( `idFlujoImp`>0, ((`importeOperacion`+`totComCliente`)- ((`importeOperacion`+`totComCliente`)/(1+`perIvaOperacion`))) , ( -1 * ((`importeOperacion`+`totComCliente`)- ((`importeOperacion`+`totComCliente`)/(1+`perIvaOperacion`))) ) ) ) AS IVA,
    SUM(  IF( `idFlujoImp`>0, `importeOperacion`+`totComCliente` , ( -1 * `importeOperacion`+`totComCliente` ) )  ) AS IMPTOTAL,
    SUM(`totComOperacion`) AS COMGANADA,
    SUM(  IF( `idFlujoImp`>0, (`importeOperacion`+`totComCliente`)-`totComOperacion` , ( -1 * (`importeOperacion`+`totComCliente`)-`totComOperacion` ) )  ) AS IMPNETO

    FROM `ops_operacion` INNER JOIN `dat_producto` USING(`idProducto`)
    WHERE `fecAplicacionOperacion` >= '$fecha1'
    AND `fecAplicacionOperacion` <= '$fecha2'
     ".$AND."
    AND `idEstatusOperacion`=0
    GROUP BY `ops_operacion`.`idProducto`
    ORDER BY `fecAplicacionOperacion` DESC LIMIT $actual,$cant;";

    $AND2 = "' ".$AND." '";
    $fecha12 = "'".$fecha1."'";
    $fecha22 = "'".$fecha2."'";
    $INNER = "INNER JOIN `dat_producto` USING(`idProducto`)";
    $INNER = "'".$INNER."'";

	if ( !$verDetalle ) {
		$cant = "NULL";
		$actual = "NULL";
		$resReporte = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha12, $fecha22, $proveedor, $familia, $actual, $cant, 0);");
	} else {
		$resReporte = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha12, $fecha22, $proveedor, $familia, $actual, $cant, 2);");
	}
	//var_dump("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha12, $fecha22, $proveedor, $familia, $actual, $cant, 2);");
	//ESTAS TRES VARIABLES SON NECESARIAS PARA MOSTRAR LA PAGINACION DEL ARCHIVO paginanavegacion.php
	$funcion = "BuscarProveedores";
	$sqlcount = "CALL `redefectiva`.`SP_GET_FOUND_ROWS`();";
	if ( !$verDetalle ) {
		$res = $RBD->SP($sqlcount);
		$total = 0;
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
		echo "<input type='hidden' name='verDetalle' id='verDetalle' value='false' />";
	} else {
		$res2 = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha12, $fecha22, $proveedor, $familia, $actual, $cant, 3);");
		$res = $RBD->SP($sqlcount);
		$total = 0;
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
		echo "<input type='hidden' name='verDetalle' id='verDetalle' value='true' />";
	}

	if(mysqli_num_rows($resReporte) > 0){
	   if ( !$verDetalle ) {
		   	$bandera = false;

		   	$d = "<table id='ordertabla' border='0' cellspacing='0' cellpadding='0' class='tablesorter tasktable'><thead><tr><th>Total</th><th>Producto</th><th>Importe</th><th>Comisi&oacute;n Cliente</th><th>SubTotal</th><th>IVA</th><th>Importe Total</th><th>Comisi&oacute;n Ganada</th><th>Importe Neto</th></tr></thead>";

			$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha12, $fecha22, $proveedor, $familia, $actual, $cant, 1);");

			list($IDop,$TOTOP,$AUT,$TOTIMP,$TOTCOMCLI,$TOTSUBTOT,$TOTIVA,$TOTIMPTOT,$TOTCOMGAN,$TOTIMPNET)= mysqli_fetch_row($res);
			$d .= "<tfoot>";
			$d .= "<tr style='height:20px;'><td colspan='9'></td></tr>";
			$d .= "<tr id='trTotales'>
				<td style='color:green;font-weight:bold;'>".number_format($TOTOP,0)."</td>
				<td></td>
				<td style='color:green;font-weight:bold;'>\$".number_format($TOTIMP,2,'.',',')."</td>
				<td style='color:green;font-weight:bold;'>\$".number_format($TOTCOMCLI,2,'.',',')."</td>
				<td style='color:green;font-weight:bold;'>\$".number_format($TOTSUBTOT,2,'.',',')."</td>
				<td style='color:green;font-weight:bold;'>\$".number_format($TOTIVA,2,'.',',')."</td>
				<td style='color:green;font-weight:bold;'>\$".number_format($TOTIMPTOT,2,'.',',')."</td>
				<td style='color:green;font-weight:bold;'>\$".number_format($TOTCOMGAN,2,'.',',')."</td>
				<td style='color:green;font-weight:bold;'>\$".number_format($TOTIMPNET,2,'.',',')."</td>
			</tr>";
			$d .= "</tfoot>";

			$d .= "<tbody>";

			while(list($IDop,$TOTOP,$PROD,$TOTIMP,$TOTCOMCLI,$TOTSUBTOT,$TOTIVA,$TOTIMPTOT,$TOTCOMGAN,$TOTIMPNET) = mysqli_fetch_array($resReporte)){
				$class= ($bandera)?"odd":"even";
				$d.="<tr class='$class'><td>$TOTOP</td><td>$PROD</td><td>\$  ".number_format($TOTIMP,2)."</td><td>\$  ".number_format($TOTCOMCLI,2)."</td><td>\$  ".number_format($TOTSUBTOT,2)."</td><td>\$  ".number_format($TOTIVA,2)."</td><td>\$  ".number_format($TOTIMPTOT,2)."</td><td>\$  ".number_format($TOTCOMGAN,2)."</td><td>\$  ".number_format($TOTIMPNET,2)."</td></tr>";

				$bandera = !$bandera;
			}

			//Totales
			//$d.= "<tr style='height:20px;'><td colspan='9'></td></tr>";
			$sql2 ="SELECT	`idsOperacion`, COUNT(`idsOperacion`),
						`autorizacionOperacion` AS AUT,
						SUM(  IF( `idFlujoImp`>0, `importeOperacion` , ( -1 * `importeOperacion` ) )  ) AS IMPOP,
						SUM(`totComCliente`) AS COMCLI,
						SUM(  IF( `idFlujoImp`>0, ((`importeOperacion`+`totComCliente`)/(1+`perIvaOperacion`)) , ( -1 * ((`importeOperacion`+`totComCliente`)/(1+`perIvaOperacion`)) ) )  ) AS SUBTOTAL,
						SUM(  IF( `idFlujoImp`>0, ((`importeOperacion`+`totComCliente`)- ((`importeOperacion`+`totComCliente`)/(1+`perIvaOperacion`))) , ( -1 * ((`importeOperacion`+`totComCliente`)- ((`importeOperacion`+`totComCliente`)/(1+`perIvaOperacion`))) ) ) ) AS IVA,
						SUM(  IF( `idFlujoImp`>0, `importeOperacion`+`totComCliente` , ( -1 * `importeOperacion`+`totComCliente` ) )  ) AS IMPTOTAL,
						SUM(`totComOperacion`) AS COMGANADA,
						SUM(  IF( `idFlujoImp`>0, (`importeOperacion`+`totComCliente`)-`totComOperacion` , ( -1 * (`importeOperacion`+`totComCliente`)-`totComOperacion` ) )  ) AS IMPNETO
						FROM `ops_operacion`
						WHERE `fecAplicacionOperacion` >= '$fecha1'
						AND `fecAplicacionOperacion` <= '$fecha2'
						".$AND."
						AND `idEstatusOperacion`=0
						ORDER BY `fecAplicacionOperacion` DESC;";

			$_SESSION['sqlproveedorestot'] = $sql2;

		} else {
			$d = "<table id='ordertabla' border='0' cellspacing='0' cellpadding='0' class='tablesorter tasktable'>";
			$d .= "<thead>";
			$d .= "<tr>";
			$d .= "<th>idFolio</th>";
			$d .= "<th>Autorizaci&oacute;n</th>";
			$d .= "<th>Producto</th>";
			$d .= "<th>Importe</th>";
			$d .= "<th>Comisi&oacute;n Cliente</th>";
			$d .= "<th>SubTotal</th>";
			$d .= "<th>IVA</th>";
			$d .= "<th>Importe Total</th>";
			$d .= "<th>Comisi&oacute;n Ganada</th>";
			$d .= "<th>Importe Neto</th>";
			$d .= "<th>Fecha</th>";
			$d .= "<th>Cta. Contable</th>";
			$d .= "<th>Corresponsal</th>";
			$d .= "</tr>";
			$d .= "</thead>";
			$d .= "<tbody>";

			while (list($IDop,$AUT,$PROD,$TOTIMP,$TOTCOMCLI,$TOTSUBTOT,$TOTIVA,$TOTIMPTOT,$TOTCOMGAN,$TOTIMPNET,$FECHA,$CUENTA,$IDCORR,$NOMCORR,$CTACONTABLE) = mysqli_fetch_array($resReporte)) {
				$class= ($bandera)?"odd":"even";
				$d .= "<tr class='$class'>";
				$d .= "<td>$IDop</td>";
				$d .= "<td>$AUT</td>";
				$d .= "<td>$PROD</td>";
				$d .= "<td>\$ ".number_format($TOTIMP,2)."</td>";
				$d .= "<td>\$  ".number_format($TOTCOMCLI,2)."</td>";
				$d .= "<td>\$  ".number_format($TOTSUBTOT,2)."</td>";
				$d .= "<td>\$  ".number_format($TOTIVA,2)."</td>";
				$d .= "<td>\$  ".number_format($TOTIMPTOT,2)."</td>";
				$d .= "<td>\$  ".number_format($TOTCOMGAN,2)."</td>";
				$d .= "<td>\$  ".number_format($TOTIMPNET,2)."</td>";
				$d .= "<td>$FECHA</td>";
				$d .= "<td>$CTACONTABLE</td>";
				$d .= "<td>$NOMCORR</td>";
				$d .= "</tr>";
			}

		}
		$d.="</tbody></table>";
		echo utf8_encode($d);
	}else{
		echo "<span>Lo Sentimos pero no se encontraron operaciones...</span>";
	}
    //CODIGO PARA LA PAGINACION DE LOS RESULTADOS
    echo "<table align='center'><tr><td>";

    //NECESARIO INCLUIR PARA LA PAGINACION
    if ( $verDetalle ) {
		include("../paginanavegacion.php");
	}
	echo "</td></tr></table>";

?>
