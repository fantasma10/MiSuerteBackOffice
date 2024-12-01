<?php
/*
	********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .CSV DESCARGABLE **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");

/* recibimos los parametros por post, vienen en formato como si se hubieran pasado por la url proveedor=1&familia=2&... */
//$parametros = (!empty($_POST["params_excel"]))? $_POST["params_excel"] : "";

$idCliente      = (isset($_POST['idcliente']))?$_POST['idcliente']:-1;
$idCad			= (isset($_POST['idcadena']))?$_POST['idcadena']:-1;
$idSubCad		= (isset($_POST['idsubcadena']))?$_POST['idsubcadena']:-1;
$idCorresponsal = (isset($_POST['idcorresponsal']))?$_POST['idcorresponsal']:-1;
$identidad		= (isset($_POST['identidad']))?$_POST['identidad'] : 0;
$fecha1			= (isset($_POST['fecha1']))?$_POST['fecha1']:'';
$fecha2			= (isset($_POST['fecha2']))?$_POST['fecha2']:'';
$tipo			= (!empty($_POST['tipo']))? $_POST['tipo'] : 0;
$separa			= (!empty($_POST['separados']))? $_POST['separados'] : 0;

/*header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Comision.xls");*/

header("Content-type=application/x-msdownload");
header("Content-disposition:attachment;filename=Comision.xls");
header("Pragma:no-cache");
header("Expires:0");

if($separa == "false"){$separados = 0;}
if($separa == "true"){$separados = 1;}

$ncorresponsal = "Todos Los Corresponsales ";
$direccion = "";
$colonia = "";
$munest = "";
$cp = "";
$pais = "";

$AND = "";
if($idCad >= 0)
	$AND.= " AND O.`idCadena` = $idCad ";

if($idSubCad >= 0)
	$AND.= " AND O.`idSubCadena` = $idSubCad ";

//Busca Datos de ciente
if($idCliente >= 0)
{
    $cliente = $RBD->query("CALL `redefectiva`.`SP_DATCLIENTE_LOAD`($idCliente);");
    $datosCliente = $RBD->fetch_assoc($cliente);
}

if($idCorresponsal >= 0){
		$AND.= " AND O.`idCorresponsal` = $idCorresponsal ";


	//Busca el nombre del corresponsal
	$resultCorresponsal = $RBD->SP("CALL `redefectiva`.`SP_LOAD_CORRESPONSAL`($idCorresponsal);");
	$datosCorresponsal = mysqli_fetch_array($resultCorresponsal);
		//$ncc = mysqli_fetch_array($nc);
		$ncorresponsal = $datosCorresponsal[5];
		$direccion = $datosCorresponsal[54]." No. ".$datosCorresponsal[56]." ".$datosCorresponsal[55];
		$colonia = $datosCorresponsal[57];
		$munest = $datosCorresponsal[59].",".$datosCorresponsal[61];
		$cp = "C.P. ".$datosCorresponsal[62];
		$pais = $datosCorresponsal[63];
	}
	//direccion del corresponsal
	/*$sql2 ="SELECT v.`calle`,v.`numeroExterior`,v.`nombreColonia`,v.`nombreCiudad`, v.`nombreEstado`, v.`codigoPostal`, v.`nombrePais`
	FROM `redefectiva`.`inf_corresponsaldireccion` as inf
	INNER JOIN `redefectiva`.`dat_direccion` as v
	ON inf.`idDireccion` = v.`idDireccion`
	WHERE `idEstatusCorDir` = 0 $AND ;";*/
	//$dcorres = $RBD->SP($sql2);
	//if($RBD->error() == '' && mysqli_num_rows($res) > 0){
		/*$datcorres = mysqli_fetch_array($dcorres);
		$direccion = $datcorres[0]." No. ".$datcorres[1];
		$colonia = $datcorres[2];
		$munest = $datcorres[3].",".$datcorres[4];
		$cp = "CP: ".$datcorres[5];
		$pais = $datcorres[6];*/
	//}

	$arrF 		= NULL;
	$arrSF 		= NULL;
	$arrCom 	= NULL;

	$Result1 	= $RBD->query("call SP_LOAD_FAMILIAS();");
	$f = 0;
	while($row = mysqli_fetch_array($Result1)){
		$idFam = $row["idFamilia"];
		$descFam = $row["descFamilia"];

		$arrF["idFam"][$f]=$idFam;
		$arrF["nomFam"][$f]=$descFam;
		$f++;
	}

	$Result2 	= $RBD->query("call SP_LOAD_SUBFAMILIAS();");

	$sf = 0;
	while($row = mysqli_fetch_array($Result2)){
		$idSFam = $row["idSubFamilia"];
		$idFami = $row["idFamilia"];
		$descSFam = $row["descSubFamilia"];

		$arrSF["idSFam"][$sf]=$idSFam;
		$arrSF["nomSFam"][$sf]=$descSFam;
		$arrSF["idFami"][$sf]=$idFami;
		$sf++;
	}
	$OPtotalFSF		= 0;
	$IMPtotalFSF	= 0;
	$COMtotalFSF	= 0;

	$impcomision    = 0;
	$comcomision    = 0;
	$opTOTAL		= 0;
	$impTOTAL		= 0;
	$comTOTAL		= 0;
	$ivaTOTAL		= 0;

	$arrCom 		= NULL;
	$arrComDes 		= NULL;


	$Result = $RBD->query("CALL redefectiva.SP_LOAD_COMISIONES($tipo, $separados, $identidad, $idCad, $idSubCad, $idCorresponsal, '$fecha1', '$fecha2');");

	$c = 0;
	$tsubtotal = 0;
	$tivatotal = 0;

	$tsubcom = 0;
	$tivacom = 0;
	/* Arreglo para guardar los estados encontrados en las operaciones obtenidas de la bd */
	$arrEstados = array();

	while($row = mysqli_fetch_array($Result)){//familia
		//echo "<pre>"; echo var_dump($row); echo "</pre>";
		$arrCom["OP"][$c] 	= $row["OP"];
		$arrCom["IMP"][$c] 	= $row["IMP"];
		$arrCom["COM"][$c] 	= $row["COM"];
		$arrCom["idF"][$c] 	= $row["idFamilia"];
		$arrCom["idSF"][$c] = $row["idSubFamilia"];
		$arrCom["idE"][$c] 	= $row["idEmisor"];
		$arrCom["descE"][$c] = $row["descEmisor"];
		$arrCom["ivaO"][$c] = $row["perIvaOperacion"];
		$arrCom["estado"][$c] = $row["nombreEntidad"];
		/*
			Por cada operaci�n que se encontr� validamos si es que no ha sido previamente guardada en el arreglo $arrEstados y vamos guardando su valor en el arreglo
		*/
		if(!in_array($row["nombreEntidad"], $arrEstados)){
			$arrEstados[] = $row["nombreEntidad"];
		}
		$c++;
	}
	/* En caso de que no haya operaciones, el arreglo se llena con una sola posici�n, ya que mas adelante se recorre primeramente por los estados encontrados, y si no hay ninguno no mostrar�
	ninguna familia ni subfamilia. "uno" es el valor que tambi�n se le da en el stored procedure cuando hay operaciones pero no se requiri� separar por estados */
	if(count($arrEstados) == 0){
		$arrEstados[] = "uno";
	}

	$data='';
	$data.= '<table border="0" width="650" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td colspan="5" align="center"><span style="font-weight:bold;color:#777;">Reporte Para </span><span style="font-weight:bold;color:#444;">'.$ncorresponsal.'</span></td>
		</tr>
		<tr>
			<td rowspan="2" colspan="3" align="left"><span style="font-weight:bold;">Red Efectiva</span></td><td colspan="2" align="right"><span style="font-weight:bold;font-size:15px;">Red Efectiva S.A. de C.V.</span></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><span style="font-size:13px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;color:#555;">REPORTE CONDENSADO DE MOVIMIENTOS</span></td><td colspan="2" align="right"><span style="font-size:13px;">Colonia Santa Maria</span></td>
		</tr>
		<tr>
			<td colspan="3"></td><td colspan="2" align="right"><span style="font-size:13px;">Monterrey, N.L. C.P. 64650</span></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.htmlentities($direccion).'</span></td><td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.htmlentities($colonia).'</span></td><td><span style="font-weight:bold;">Tipo Comision</span></td><td><span style="font-weight:bold;">Corresponsal</span></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.htmlentities($munest).'</span></td><td colspan="2"><span style="font-weight:bold;">Periodo de </span><span style="font-weight:bold;color:#555;">'.$fecha1.'</span> <span style="font-weight:bold;">a</span> <span style="font-weight:bold;color:#555;">'.$fecha2.'</span></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.$cp.'</span></td><td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.htmlentities($pais).'</span></td><td colspan="2"></td>
		</tr>';
	$cont = 0;

	foreach($arrEstados as $estado){
		/* Si no se requiri� separar por estados entonces el valor del �nico 'estado' es 'uno' en ese caso se omite imprimir en el encabezado el nombre del estado */
		if($estado != 'uno'){
			if($cont > 0){
				$data .= '<tr><td colspan="5"><hr></td></tr>';
			}
			$cont++;

			$data .= '<tr>';
			$data .= '<td colspan="5" align="left"><h3><b> Estado : '.htmlentities($estado).'</b></h3></td>';
			$data .= '</tr>';
		}
		$data .= '<tr>';
		$data .= '<td colspan="5" align="left"><span style="font-weight:bold;color:#333:">Resumen De Movimientos</span></td>
		</tr>';

		for($i=0 ; $i < count($arrF["idFam"]) ; $i++){//ciclo FAMILIA
			$data.='<tr>
					<td align="left" colspan="2"><span style="font-weight:bold;color:#555;">'.htmlentities($arrF["nomFam"][$i]).'</span></td>
					<td align="right"><span style="font-weight:bold;color:#555;">Movimientos</span></td>
					<td align="right"><span style="font-weight:bold;color:#555;">Importe</span></td>
					<td align="right"><span style="font-weight:bold;color:#555;">Comisi&oacute;n</span></td>
				</tr>';
			for($j=0 ; $j < count($arrSF["idSFam"]) ; $j++){//ciclo SUBFAMILIA
				if($arrF["idFam"][$i] == $arrSF["idFami"][$j]){
					$data.='<tr>
							<td colspan="5" align="left">'.htmlentities($arrSF["nomSFam"][$j]).' </td>
						</tr>';

					$band = true;

					for($y=0 ; $y < count($arrCom["OP"]) ; $y++){//ciclo OPERACIONES
						/* si el nombre del estado de la operaci�n coincide con el nombre del estado en el que va el ciclo entonces agrega a la tabla las columnas */
						if($arrCom["estado"][$y] == $estado){
							if($arrSF["idSFam"][$j] == $arrCom["idSF"][$y]){

								$OPtotalFSF	 = $OPtotalFSF+$arrCom["OP"][$y];
								$IMPtotalFSF = $IMPtotalFSF+$arrCom["IMP"][$y];
								$COMtotalFSF = $COMtotalFSF+$arrCom["COM"][$y];

								$opTOTAL	= $opTOTAL+$arrCom["OP"][$y];
								$impTOTAL	= $impTOTAL+$arrCom["IMP"][$y];
								$comTOTAL	= $comTOTAL+$arrCom["COM"][$y];
								$ivaTOTAL	= $arrCom["ivaO"][$y];

								if($band){
									$data.='<tr>
											<td colspan="5"><div style="margin: 0px auto 0px auto;padding: 0px 0px 0px 0px;width:100%; border-bottom:1px solid #666;  height:0px;"></div></td>
										</tr>';
									$band = false;
								}

								$data.='<tr>
										<td align="left" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold;">'.$arrCom["descE"][$y].'</span></td>
										<td align="right"><span style="font-weight:bold;">'.number_format($arrCom["OP"][$y]).'</span></td>
										<td align="right"><span style="font-weight:bold;">$'.number_format($arrCom["IMP"][$y],2,".",",").'</span></td>
										<td align="right"><span style="font-weight:bold;">$'.number_format($arrCom["COM"][$y],2,".",",").'</span></td>
									</tr>';
							}
							//si la subcadena tiene MOVIMIENTOS
						}//if $arrCom["estado"][$y] == $estado
					} $t = 12;

					//CICLO de OPERACIONES
					//============================================================
					if($OPtotalFSF > 0){//total por FAMILIA y SUBFAMILIA
						$data.='<tr>
								<td colspan="2"></td>
								<td colspan="3"><div style="margin: 0px auto 0px auto;padding: 0px 0px 0px 0px;width:100%; border-bottom:1px solid #666;  height:0px;"></div></td>
							</tr>';
						$data.='<tr>
							<td colspan="2"></td>
							<td align="right" class="Cuerpo"><span style="font-weight:bold;">'.number_format($OPtotalFSF).'</span></td>
							<td align="right" class="Cuerpo"><span style="font-weight:bold;">$'.number_format($IMPtotalFSF,2,".",",").'</span></td>
							<td align="right" class="Cuerpo"><span style="font-weight:bold;">$'.number_format($COMtotalFSF,2,".",",").'</span></td>
						</tr>';
						$OPtotalFSF	 = 0;
						$IMPtotalFSF = 0;
						$COMtotalFSF = 0;
					}//total por FAMILIA y SUBFAMILIA
					//=============================================================
				}//if $arrF["idFam"][$i] == $arrSF["idFami"][$j]
			}//subfamilia
		}//familia

		$impcomision = $impTOTAL;
		$tsubtotal = $impTOTAL / 1.16;
		$tivatotal = $tsubtotal * $ivaTOTAL;
		$rivatotal = ($tivatotal / 3) * 2;

    	$comcomision = $comTOTAL ;
		$tsubcom = $comTOTAL / 1.16;
		$tivacom = $tsubcom * $ivaTOTAL;
		$rivacom = ($tivacom / 3) * 2;

		$data.='<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" colspan="2"><span style="font-weight:bold;">Comision</span></td>
				<td align="right"><span style="font-weight:bold;"></span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($tsubtotal,2,".",",").'</span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($tsubcom,2,".",",").'</span></td>

			</tr>
			<tr>
				<td align="right" colspan="2"><span style="font-weight:bold;">IVA</span></td>
				<td align="right"><span style="font-weight:bold;"></span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($tivatotal,2,".",",").'</span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($tivacom,2,".",",").'</span></td>
			</tr>
			<tr>
            <td colspan="5"><div style="margin: 0px auto 0px auto;padding: 0px 0px 0px 0px;width:100%; border-bottom:1px solid #666;  height:0px;"></div></td>
        	</tr>
        	<tr>
				<td align="right" colspan="2"><span style="font-weight:bold;">Sub Total</span></td>
				<td align="right"><span style="font-weight:bold;"></span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($impcomision,2,".",",").'</span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($comcomision,2,".",",").'</span></td>

			</tr>';
        	if(intval($datosCliente['idRegimen']) == 1):
        	$data.='<tr>
	            <td align="right" colspan="2"><span style="font-weight:bold;">Retencion IVA</span></td>
	            <td align="right"><span style="font-weight:bold;"></span></td>
	            <td align="right"><span style="font-weight:bold;">$'.number_format($rivatotal,2,".",",").'</span></td>
	            <td align="right"><span style="font-weight:bold;">$'.number_format($rivacom,2,".",",").'</span></td>
	        </tr>';
	        $comTOTAL = $comTOTAL - $rivacom;
	        endif;
			$data.='<tr>
				<td align="right" colspan="2"><span style="font-weight:bold;">Total</span></td>
				<td align="right"><span style="font-weight:bold;">'.number_format($opTOTAL).'</span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($impTOTAL,2,".",",").'</span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($comTOTAL,2,".",",").'</span></td>
			</tr>';
			$opTOTAL = 0;
			$impTOTAL = 0;
			$comTOTAL = 0;
			$ivaTOTAL = 0;
	}//foreach $arrEstado
			$data.='</table>';
			echo utf8_encode($data);

?>