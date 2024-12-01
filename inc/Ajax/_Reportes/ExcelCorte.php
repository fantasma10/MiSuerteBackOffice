<?php
/*
	********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .CSV DESCARGABLE **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");

/* recibimos los parametros por post, vienen en formato como si se hubieran pasado por la url proveedor=1&familia=2&... */
//$parametros = (!empty($_POST["params_excel"]))? $_POST["params_excel"] : "";

$idCadena = (isset($_POST['idcadena']))?$_POST['idcadena']:'';
$idSubCadena = (isset($_POST['idsubcadena']))?$_POST['idsubcadena']:'';
$idCorresponsal = (isset($_POST['idcorresponsal']))?$_POST['idcorresponsal']:'';
$fecha1 = (isset($_POST['fechac']))?$_POST['fechac']:'';
$fecha2 = (isset($_POST['fecha2']))?$_POST['fecha2']:'';

/*header("Content-Type: application/vnd.ms-excel"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Corte.xls");*/

header("Content-type=application/x-msdownload");
header("Content-disposition:attachment;filename=Corte.xls");
header("Pragma:no-cache");
header("Expires:0");

if ( !empty($idCadena) && !empty($idSubCadena) && !empty($idCorresponsal) && !empty($fecha1) && !empty($fecha2) ) {
	$IDENT				= -1;
	$representanteL		= '';
	$direccion			= '';
	$AND				= '';
	$ncorresponsal = "Todos Los Corresponsales ";
	$direccion = "";
	$colonia = "";
	$munest = "";
	$cp = "";
	$pais = "";
	if($idCorresponsal > 0){//echo 'Corresponsal';
		$IDENT				= 1;
		$AND				= "	AND `idCadena` = $idCadena
								AND `idSubCadena` = $idSubCadena
								AND `idCorresponsal` = $idCorresponsal ";
		$resultCorresponsal = $RBD->SP("CALL `redefectiva`.`SP_LOAD_CORRESPONSAL`($idCorresponsal);");
		$datosCorresponsal = mysqli_fetch_array($resultCorresponsal);			
		//$nc = $RBD->query("SELECT `nombreCorresponsal` FROM `redefectiva`.`dat_corresponsal` WHERE `idCorresponsal` = ".$idCorresponsal.";");
		//$ncc = mysqli_fetch_array($nc);
		$ncorresponsal = $datosCorresponsal[5];
		/*$dcorres = $RBD->query("SELECT  v.`calle`,v.`numeroExterior`,v.`nombreColonia`,v.`nombreCiudad`, v.`nombreEstado`, v.`codigoPostal`, v.`nombrePais`
	FROM `dat_corresponsal` INNER JOIN `inf_corresponsaldireccion` USING(`idCorresponsal`)
	INNER JOIN `v_direccion` as v USING(`idDireccion`)
	WHERE `idEstatusCorresponsal` = 0 $AND ;");*/
		//$dcorres = $RBD->SP("CALL `redefectiva`.`SP_GET_DIRECCIONCORRESPONSAL`($idCadena, $idSubCadena, $idCorresponsal);");
		//$datcorres = mysqli_fetch_array($dcorres);		
		$direccion = $datosCorresponsal[54]." No. ".$datosCorresponsal[56]." ".$datosCorresponsal[55];
		$colonia = $datosCorresponsal[57];
		$munest = $datosCorresponsal[59].",".$datosCorresponsal[61];
		$cp = "C.P. ".$datosCorresponsal[62];
		$pais = $datosCorresponsal[63];		
	}
	if(($idCadena >= 0)&&($idSubCadena >= 0)&&($idCorresponsal < 0)){//echo 'SubCadena';
		$IDENT	= 2;
		$AND	=" 	AND `idCadena` = $idCadena
					AND `idSubCadena` = $idSubCadena";
	}
	if(($idCadena >= 0)&&($idSubCadena < 0)&&($idCorresponsal < 0)){//echo 'Cadena';
		$IDENT		= 3;
		$AND		= "	AND `idCadena` = $idCadena";
	}
	
	
	$arrF 		= NULL;
	$arrSF 		= NULL;
	$arrCom 	= NULL;
	
	$sql_FAM	="	SELECT `idFamilia`, `descFamilia` 
					FROM `cat_familia`
					WHERE `idEstatusFamilia` = 0;";
	
	$Result1 	= $RBD->query("call SP_LOAD_FAMILIAS()");$f = 0;
	while(list($idFam,$descFam) = mysqli_fetch_row($Result1)){$arrF["idFam"][$f]=$idFam;$arrF["nomFam"][$f]=$descFam;$f++;}
	
	$sql_SFAM	= "	SELECT `idFamilia`, `idSubFamilia`, `descSubFamilia` 
					FROM `cat_subfamilia`
					WHERE `idEstatusSubFamilia` = 0;";
	
	$Result2 	= $RBD->query("call SP_LOAD_SUBFAMILIAS()");$sf = 0;
	while(list($idFami,$idSFam,$descSFam) = mysqli_fetch_row($Result2)){
		$arrSF["idSFam"][$sf]=$idSFam;
		$arrSF["nomSFam"][$sf]=$descSFam;
		$arrSF["idFami"][$sf]=$idFami;
		$sf++;
	}
	
	$OPtotalFSF		= 0;
	$ENTtotalFSF	= 0;
	$SALtotalFSF	= 0;
	
	$opTOTAL		= 0;
	$entTOTAL		= 0;
	$salTOTAL		= 0;
	
	$DIF			= 0;
		$sql_opx = "
		SELECT COUNT( O.`idsOperacion` ) as OP , 
		SUM( IF( O.`idFlujoImp` <1, (O.`importeOperacion`), 0 ) ) AS IMPSAL, 
		SUM( IF( O.`idFlujoImp` >0, (O.`importeOperacion` + O.`totComCliente` + O.`totComEspecial`), 0 ) ) AS IMPENT, 
		O.`idFamilia` , O.`idSubFamilia` , O.`idEmisor` , E.`descEmisor` 
		FROM  `mops_operacion` AS O
		INNER JOIN  `cat_emisor` AS E
		USING (  `idEmisor` ) 
		WHERE O.`fecAltaOperacion` >=  '".$fecha1."'
		AND O.`fecAltaOperacion` <=  '".$fecha2."'
		AND O.`idEstatusOperacion` = 0 $AND 
		GROUP BY O.`idFamilia` , O.`idSubFamilia` , O.`idEmisor`; 
		";
		
		//$Result3 = $RBD->query("call SP_LOAD_CORTES('$fecha1', '$fecha2', '$AND')");
		$Result3 = $RBD->query("CALL SP_LOAD_CORTES($idCadena, $idSubCadena, $idCorresponsal, '$fecha1', '$fecha2')");
		$sf = 0;
		echo $RBD->error();
		$fg = 0;
	while(list($OPX,$IMPSALX,$IMPENTX,$idFX,$idSFX,$idEX,$descEX) = mysqli_fetch_row($Result3)){
		$arrCom["OP"][$sf] 	= $OPX;
		$arrCom["IMPSAL"][$sf] 	= $IMPSALX;
		$arrCom["IMPENT"][$sf] 	= $IMPENTX;
		$arrCom["idF"][$sf] 	= $idFX;
		$arrCom["idSF"][$sf] 	= $idSFX;
		$arrCom["idE"][$sf] 	= $idEX;
		$arrCom["descE"][$sf] 	= $descEX;
		$sf++;
		$fg = $sf;
	}
	
	$data='';
	$data.='<table border="0" width="650" cellpadding="0" cellspacing="0" align="center">
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
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.htmlentities($colonia).'</span></td><td><span style="font-weight:bold;">Tipo Corte</span></td><td><span style="font-weight:bold;">Corresponsal</span></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.htmlentities($munest).'</span></td><td colspan="2"><span style="font-weight:bold;">Periodo de </span><span style="font-weight:bold;color:#555;">'.$fecha1.'</span> <span style="font-weight:bold;">a</span> <span style="font-weight:bold;color:#555;">'.$fecha2.'</span></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.$cp.'</span></td><td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="3" align="left"><span style="font-weight:bold;font-size:13px;">'.htmlentities($pais).'</span></td><td colspan="2"></td>
		</tr>
		
		<tr>
			<td colspan="5" align="left"><span style="font-weight:bold;color:#333:">Resumen De Movimientos</span></td>
		</tr>';
		for($i=0 ; $i < count($arrF["idFam"]) ; $i++){//ciclo FAMILIA
			$data.='<tr>
					<td align="left" colspan="2"><span style="font-weight:bold;color:#555;">'.htmlentities($arrF["nomFam"][$i]).'</span></td>
					<td align="right"><span style="font-weight:bold;color:#555;">Movimientos</span></td>
					<td align="right"><span style="font-weight:bold;color:#555;">Entradas</span></td>
					<td align="right"><span style="font-weight:bold;color:#555;">Salidas</span></td>
				</tr>';
			for($j=0 ; $j < count($arrSF["idSFam"]) ; $j++){//ciclo SUBFAMILIA
				if($arrF["idFam"][$i] == $arrSF["idFami"][$j]){
				$data.='<tr>
						<td colspan="5" align="left">'.htmlentities($arrSF["nomSFam"][$j]).' </td>
					</tr>';
					
					$band = true;
					for($y=0 ; $y < count($arrCom["OP"]) ; $y++){//ciclo OPERACIONES
						if($arrSF["idSFam"][$j] == $arrCom["idSF"][$y]){
							if($band){
								$data.='<tr>
										<td colspan="5"><div style="margin: 0px auto 0px auto;padding: 0px 0px 0px 0px;width:100%; border-bottom:1px solid #666;  height:0px;"></div></td>
									</tr>';
								$band = false;
							}
							$varD 		= $arrCom["descE"][$y];
							$OPtotalFSF		= $OPtotalFSF+$arrCom["OP"][$y];
							$SALtotalFSF	= $SALtotalFSF+$arrCom["IMPSAL"][$y];
							$ENTtotalFSF	= $ENTtotalFSF+$arrCom["IMPENT"][$y];
							
							$opTOTAL	= $opTOTAL+$arrCom["OP"][$y];
							$salTOTAL	= $salTOTAL+$arrCom["IMPSAL"][$y];
							$entTOTAL	= $entTOTAL+$arrCom["IMPENT"][$y];
	
							$data.='<tr>
									<td align="left" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold;">'.$arrCom["descE"][$y].'</span></td>
									<td align="right"><span style="font-weight:bold;">'.number_format($arrCom["OP"][$y]).'</span></td>
									<td align="right"><span style="font-weight:bold;">$'.number_format($arrCom["IMPENT"][$y],2,".",",").'</span></td>
									<td align="right"><span style="font-weight:bold;">$'.number_format($arrCom["IMPSAL"][$y],2,".",",").'</span></td>
								</tr>';
						}
						//si la subcadena tiene MOVIMIENTOS
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
						<td align="right" class="Cuerpo"><span style="font-weight:bold;">$'.number_format($ENTtotalFSF,2,".",",").'</span></td>
						<td align="right" class="Cuerpo"><span style="font-weight:bold;">$'.number_format($SALtotalFSF,2,".",",").'</span></td>
					</tr>';
					$OPtotalFSF		= 0;
					$ENTtotalFSF	= 0;
					$SALtotalFSF	= 0;
				}//total por FAMILIA y SUBFAMILIA
				//=============================================================
				}
			}
		}
			
		$data.='<tr>
				<td colspan="5">&nbsp;</td>
			</tr>       
			<tr>
				<td align="right" colspan="2"><span style="font-weight:bold;">Total</span></td>
				<td align="right"><span style="font-weight:bold;">'.number_format($opTOTAL).'</span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($entTOTAL,2,".",",").'</span></td>
				<td align="right"><span style="font-weight:bold;">$'.number_format($salTOTAL,2,".",",").'</span></td>
			</tr>';
				$DIF=($entTOTAL-$salTOTAL);
				   $data.='
						   <tr>
							   <td colspan="4" align="right"><span style="font-weight:bold;color:#006;font-size:14px;">Diferencia de entradas y salidas&nbsp;</span></td>
							   <td align="right" ';
							   if($DIF>0){$data.=' class="Titulo11">';
							   }else{ $data.=' class="Titulo1">';}
								   if($DIF>0){$data.='<span style="color:#360;font-weight:bold;">'.number_format($DIF,2,'.',',').'</span>';}else{$data.= '(<span style="color:#360;font-weight:bold;">'.number_format($DIF,2,'.',',').')</span>';}
							   $data.='</td>
						   </tr>
			<tr>
				<td colspan="5" class="Cuerpo" align="right">
					<span style="font-weight:bold;font-size:13px;">Una diferencia negativa ( - ) significa a favor del corresponsal</span>
				</td>	 
			</tr></table>';
			echo utf8_encode($data);
}
?>