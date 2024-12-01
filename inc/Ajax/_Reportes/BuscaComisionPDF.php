<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

$seccion = "Comisiones";
//codigo del departamento
$departamento = "DCN";
//tipo de documento
$tipodocumento = "IF";
//consecutivo del documento
$consecutivo = "02";
include("../../../tcpdf/PDFP.php");


include("../../config.inc.php");
include("../../session.ajax.inc.php");

$AND = '';
$idCliente      = (isset($_POST['idcliente']))?$_POST['idcliente']:-1;
$idCad			= (isset($_POST['idcadena']))?$_POST['idcadena']:-1;
$idSubCad		= (isset($_POST['idsubcadena']))?$_POST['idsubcadena']:-1;
$idCorresponsal = (isset($_POST['idcorresponsal']))?$_POST['idcorresponsal']:-1;
$identidad		= (isset($_POST['identidad']))?$_POST['identidad'] : 0;
$fecha1			= (isset($_POST['fecha1']))?$_POST['fecha1']:'';
$fecha2			= (isset($_POST['fecha2']))?$_POST['fecha2']:'';
$tipo			= (!empty($_POST['tipo']))? $_POST['tipo'] : 0;
$separa			= (!empty($_POST['separados']))? $_POST['separados'] : 0;

if($separa == "false"){$separados = 0;}
if($separa == "true"){$separados = 1;}

/*echo "idcadena--".$idCad."</br>";
echo "idsubcad--".$idSubCad."</br>";
echo "idcorresponsal--".$idCorresponsal."</br>";*/
$ncorresponsal = "Todos Los Corresponsales ";
$direccion = "";
$colonia = "";
$munest = "";
$cp = "";
$pais = "";

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

if( $idCorresponsal >= 0){
	$AND.= " AND O.`idCorresponsal` = $idCorresponsal ";
	$resultCorresponsal = $RBD->SP("CALL `redefectiva`.`SP_LOAD_CORRESPONSAL`($idCorresponsal);");
	$datosCorresponsal = mysqli_fetch_array($resultCorresponsal);
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
INNER JOIN `redefectiva`.`v_direccion` as v
ON inf.`idDireccion` = v.`idDireccion`
WHERE `idEstatusCorDir` = 0 $AND ;";
$dcorres = $RBD->query($sql2);
if($RBD->error() == '' && mysqli_num_rows($res)){
    $datcorres = mysqli_fetch_array($dcorres);
    $direccion = $datcorres[0]." No. ".$datcorres[1];
    $colonia = $datcorres[2];
    $munest = $datcorres[3].",".$datcorres[4];
    $cp = "CP: ".$datcorres[5];
    $pais = $datcorres[6];
}*/

$arrF 		= NULL;
$arrSF 		= NULL;
$arrCom 	= NULL;

$Result1 	= $RBD->query("call SP_LOAD_FAMILIAS()");
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

	$AND = '" '.$AND.' "';
	$INNER = '" '.$INNER.' "';

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
		Por cada operación que se encontró validamos si es que no ha sido previamente guardada en el arreglo $arrEstados y vamos guardando su valor en el arreglo
	*/
	if(!in_array($row["nombreEntidad"], $arrEstados)){
		$arrEstados[] = $row["nombreEntidad"];
	}
	$c++;
}
/* En caso de que no haya operaciones, el arreglo se llena con una sola posición, ya que mas adelante se recorre primeramente por los estados encontrados, y si no hay ninguno no mostrará
ninguna familia ni subfamilia. "uno" es el valor que también se le da en el stored procedure cuando hay operaciones pero no se requirió separar por estados */
if(count($arrEstados) == 0){
	$arrEstados[] = "uno";
}
$datas = '<style>
	    table {
			width:100%;
			float:left;
		}
		th{
			text-align:center;
			font-size:24px;
			float:left;
		}
		td{
			text-align:left;
			font-size:22px;
			float:left;
		}
		.divDividerX{
			margin: 0px auto 0px auto;
			padding: 0px 0px 0px 0px;
			width:100%; border-bottom:1px solid #BBB; border-top:1px solid #CCC; height:0px;
		}
	    </style>';
$data = $datas;
$data .= '<table border="0" width="650" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse;padding:0px;margin:0px;">
	<tr>
		<td colspan="5" align="center" height="0"><span style="font-weight:bold;color:#777;font-size:30px;">Reporte Para </span><span style="font-weight:bold;color:#444;font-size:30px;">'.$ncorresponsal.'</span></td>
	</tr>
	<tr>
		<td rowspan="2" colspan="3" align="left" height="0"><span style="font-weight:bold;font-size:32px;">Red Efectiva</span></td><td colspan="2" align="right"><span style="font-weight:bold;font-size:27px;">Red Efectiva S.A. de C.V.</span></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><span style="font-size:24px;">Blvd. Antonio L. Rdz 3058 Suite 201-A</span></td>
	</tr>
	<tr>
		<td colspan="3" align="left"><span style="font-weight:bold;color:#555;font-size:30px;">REPORTE CONDENSADO DE MOVIMIENTOS</span></td><td colspan="2" align="right"><span style="font-size:24px;">Colonia Santa Maria</span></td>
	</tr>
	<tr>
		<td colspan="3"></td><td colspan="2" align="right"><span style="font-size:24px;">Monterrey, N.L. C.P. 64650</span></td>
	</tr>
	<tr>
		<td colspan="3" align="left"><span style="font-weight:bold;font-size:24px;">'.$direccion.'</span></td><td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="3" align="left"><span style="font-weight:bold;font-size:24px;">'.$colonia.'</span></td><td><span style="font-weight:bold;font-size:24px;">Tipo Comision</span></td><td><span style="font-weight:bold;font-size:24px;">Corresponsal</span></td>
	</tr>
	<tr>
		<td colspan="3" align="left"><span style="font-weight:bold;font-size:24px;">'.$munest.'</span></td><td colspan="2"><span style="font-weight:bold;font-size:24px;">Periodo de </span><span style="font-weight:bold;color:#555;font-size:24px;">'.$fecha1.'</span> <span style="font-weight:bold;font-size:24px;">a</span> <span style="font-weight:bold;color:#555;font-size:24px;">'.$fecha2.'</span></td>
	</tr>
	<tr>
		<td colspan="3" align="left"><span style="font-weight:bold;font-size:24px;">'.$cp.'</span></td><td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="3" align="left"><span style="font-weight:bold;font-size:24px;">'.$pais.'</span></td><td colspan="2"></td>
	</tr></table>';

$pdf->writeHTML(utf8_encode($data), false, false, false, false, '');

$data=$datas;


$cont = 0;
foreach($arrEstados AS $estado){
	/* Si no se requirió separar por estados entonces el valor del único 'estado' es 'uno' en ese caso se omite imprimir en el encabezado el nombre del estado */
	$data.='<table border="0" width="650" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse;" height="1">';
	if($estado != 'uno'){
		$data .= '<tr>';
		$data .= '<td colspan="5" align="left"><h1><b> Estado : '.$estado.'</b></h2></td>';
		$data .= '</tr>';
	}
	$data .= '<tr>';
	$data .= '<td colspan="5" align="left"><span style="font-weight:bold;color:#333;font-size:28px;">Resumen De Movimientos</span></td>
	</tr>';

	for($i=0 ; $i < count($arrF["idFam"]) ; $i++){//ciclo FAMILIA
		$data.='<tr>
				<td align="left" colspan="2"><span style="font-weight:bold;color:#555;font-size:30px;">'. $arrF["nomFam"][$i].'</span></td>
				<td align="right"><span style="font-weight:bold;color:#555;font-size:30px;">Movimientos</span></td>
				<td align="right"><span style="font-weight:bold;color:#555;font-size:30px;">Importe</span></td>
				<td align="right"><span style="font-weight:bold;color:#555;font-size:30px;">Comisi&oacute;n</span></td>
			</tr>';
		for($j=0 ; $j < count($arrSF["idSFam"]) ; $j++){//ciclo SUBFAMILIA
			if($arrF["idFam"][$i] == $arrSF["idFami"][$j]){
			$data.='<tr>
					<td colspan="5" align="left"><span style="font-size:30px;">'.$arrSF["nomSFam"][$j].' </span></td>
				</tr>';

				$band = true;

				for($y=0 ; $y < count($arrCom["OP"]) ; $y++){//ciclo OPERACIONES
					/* si el nombre del estado de la operación coincide con el nombre del estado en el que va el ciclo entonces agrega a la tabla las columnas */
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
								$data.='<tr style="height:0px;">
										<td colspan="5"><div style="margin: 0px auto 0px auto;padding: 0px 0px 0px 0px;width:100%; border-bottom:1px solid #666;  height:0px;"></div></td>
									</tr>';
								$band = false;
							}

							$data.='<tr>
									<td align="left" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold;font-size:30px;">'.$arrCom["descE"][$y].'</span></td>
									<td align="right"><span style="font-weight:bold;font-size:30px;">'.number_format($arrCom["OP"][$y]).'</span></td>
									<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($arrCom["IMP"][$y],2,".",",").'</span></td>
									<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($arrCom["COM"][$y],2,".",",").'</span></td>
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
					<td align="right" class="Cuerpo"><span style="font-weight:bold;font-size:30px;">'.number_format($OPtotalFSF).'</span></td>
					<td align="right" class="Cuerpo"><span style="font-weight:bold;font-size:30px;">$'.number_format($IMPtotalFSF,2,".",",").'</span></td>
					<td align="right" class="Cuerpo"><span style="font-weight:bold;font-size:30px;">$'.number_format($COMtotalFSF,2,".",",").'</span></td>
				</tr>';
				$OPtotalFSF	= 0;
				$IMPtotalFSF	= 0;
				$COMtotalFSF	= 0;
			}//total por FAMILIA y SUBFAMILIA
			//=============================================================
			}
		}
	}

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
			<td align="right" colspan="2"><span style="font-weight:bold;font-size:30px;">Comision</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;"></span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($tsubtotal,2,".",",").'</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($tsubcom,2,".",",").'</span></td>

		</tr>
		<tr>
			<td align="right" colspan="2"><span style="font-weight:bold;font-size:30px;">IVA</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;"></span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($tivatotal,2,".",",").'</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($tivacom,2,".",",").'</span></td>
		</tr>
		<tr>
            <td colspan="5"><div style="margin: 0px auto 0px auto;padding: 0px 0px 0px 0px;width:100%; border-bottom:1px solid #666;  height:0px;"></div></td>
        </tr>
        <tr>
			<td align="right" colspan="2"><span style="font-weight:bold;font-size:30px;">Sub Total</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;"></span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($impcomision,2,".",",").'</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($comcomision,2,".",",").'</span></td>

		</tr>';
        if(intval($datosCliente['idRegimen']) == 1):
        $data.='<tr>
            <td align="right" colspan="2"><span style="font-weight:bold;font-size:30px;">RETENCION IVA</span></td>
            <td align="right"><span style="font-weight:bold;font-size:30px;"></span></td>
            <td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($rivatotal,2,".",",").'</span></td>
            <td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($rivacom,2,".",",").'</span></td>
        </tr>';
        $comTOTAL = $comTOTAL - $rivacom;
        endif;
		$data.='<tr>
			<td align="right" colspan="2"><span style="font-weight:bold;font-size:30px;">Total</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">'.number_format($opTOTAL).'</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($impTOTAL,2,".",",").'</span></td>
			<td align="right"><span style="font-weight:bold;font-size:30px;">$'.number_format($comTOTAL,2,".",",").'</span></td>
		</tr></table>';
		$opTOTAL = 0;
		$impTOTAL = 0;
		$comTOTAL = 0;
		$ivaTOTAL = 0;
		$pdf->writeHTML(utf8_encode($data), false, false, false, false, '');
		$pdf->AddPage();
		$data = $datas;
}//foreach $arrEstado
		//$data .= '</table>';
	$pdf->Output()

	//include("../../../tcpdf/CrearPDF.php");
?>