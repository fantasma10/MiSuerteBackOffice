<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	$idPermiso = (isset($_SESSION['Permisos']['Tipo'][3]))?$_SESSION['Permisos']['Tipo'][3]:1;

	global $RBD;

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idCadena		= (isset($_GET['idCadena']) AND $_GET['idCadena'] >= 0 AND $_GET['idCadena'] != '')?$_GET['idCadena']:-1;
	$idSubCadena	= (isset($_GET['idSubCadena']) AND $_GET['idSubCadena'] >= 0 AND $_GET['idSubCadena'] != '')?$_GET['idSubCadena']:-1;
	$idCorresponsal	= (isset($_GET['idCorresponsal']) AND $_GET['idCorresponsal'] >= 0 AND $_GET['idCorresponsal'] != '')?$_GET['idCorresponsal']:-1;
	$month			= (isset($_GET['month']))?$_GET['month']:01;
	$year			= (isset($_GET['year']))?$_GET['year']:2004;
	$idEstatus		= (isset($_GET['idEstatus']) AND $_GET['idEstatus'] >-1)?$_GET['idEstatus']:-1;
	$facturaAs		= (isset($_REQUEST['facturaAs']) AND $_REQUEST['facturaAs'] > -1)? $_REQUEST['facturaAs'] : -1;
	$idInstruccion	= (isset($_GET['idInstruccion']))? $_GET['idInstruccion'] : -1;
	$idLiquidacion	= (isset($_GET['idLiquidacion']))? $_GET['idLiquidacion'] : -1;

	$start	= (!empty($_GET['iDisplayStart']))? $_GET['iDisplayStart'] : 0;
	$limit	= (!empty($_GET['iDisplayLength']))? $_GET['iDisplayLength'] : 10;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? utf8_decode($_REQUEST['sSearch']) : '';

	$strQ = "CALL `data_contable`.`SP_CORTES_COMISION_LOAD_2`($idCadena, $idSubCadena, $idCorresponsal, $year, $month, '', 0, '', $colsort, '$ascdesc', '$strToFind', $start, $limit, $idEstatus, $facturaAs, $idInstruccion, $idLiquidacion)";
	//var_dump("strQ: $strQ");
	$sql = $RBD->query($strQ);

	$data = array();

	if(!$RBD->error()){
		$fila = 0;
		while($row= mysqli_fetch_assoc($sql)){
			$iva = "";
			if ( $row['idTipoComision'] == 1 ) {
				$iva = "Con IVA";
			} else if ( $row['idTipoComision'] == 2 ) {
				$iva = "Sin IVA";
			}
			$data[] = array(
				((empty( $row['noFactura']) && $row['idEstatus'] == 1)? "<input type='checkbox' idcorte='".$row['idCorte']."' numcuenta='".$row['numCuenta']."' class='check' row='".$fila."' importe='".number_format($row['importePago'], 2)."'>" : ""),
				acentos($row['descTipoLiquidacion']),
				acentos($row['nombreCadena']),
				acentos($row['nombreSubCadena']),
				acentos($row['nombreCorresponsal']),
				$row['numCuenta'],
				$row['ctaContable'],
				acentos($row['descTipoInstruccion']),
				$iva,
				"\$".number_format($row['importeTotal'], 2),
				$row['totalVentas'],
				//((empty($row['idFactura']))? "<a href='#SectionModal' data-toggle='modal' onclick=''>Asignar Factura</a>" : $row['noFactura']),
				((empty($row['idFactura']))? "" : $row['noFactura']),
				acentos($row['descEstatus'])
			);

			$fila++;
		}

		$sqlcount = $RBD->query("SELECT FOUND_ROWS() AS total");
		$res = mysqli_fetch_assoc($sqlcount);
		$iTotal = $res["total"];
		$error = "";
	}
	else{
		$error = $RBD->error();
		$iTotal = 0;
	}

	$iTotalDisplayRecords = ($iTotal < $limit)? $iTotal : $limit;
	$output = array(
		"sEcho"                 => intval($_GET['sEcho']),
		"iTotalRecords"         => $iTotal,
		"iTotalDisplayRecords"  => $iTotal,
		"aaData"                => $data,
		"errmsg"				=> $error
	);

	echo json_encode($output);

/*

	CREATE DEFINER=`root`@`%` PROCEDURE `SP_LOAD_CORTES_COMISION`(
		IN	Ck_idCadena			INT,
		IN	Ck_idSubCadena		INT,
		IN	Ck_idCorresponsal	INT,
		IN	Ck_year				INT,
		IN	Ck_month			INT,
		IN	Ck_numCuenta		VARCHAR(10),
		IN	Ck_idFactura		INT,
		IN	Ck_noFactura		VARCHAR(64),
		IN	Ck_start			INT,
		IN	Ck_limit			INT
	)
	BEGIN

		SELECT cad.`nombreCadena`, sub.`nombreSubCadena`, IF(cuenta.`idCorresponsal` = -1, '', cor.`nombreCorresponsal`) AS `nombreCorresponsal`,
		cuenta.`idCadena`, cuenta.`idSubCadena`, cuenta.`idCorresponsal`,
		cuenta.`numCuenta`, C.`impEntrada`, C.`impSalida`, C.`impComision`, C.`totalVentas`, C.`importeTotal`, f.`noFactura`
		FROM `data_contable`.`dat_corte_comision` AS C
		LEFT JOIN `data_contable`.`dat_facturas`	AS	f		ON f.`idFactura` = C.`idFactura`
		LEFT JOIN `redefectiva`.`ops_cuenta`		AS	cuenta	ON cuenta.`numCuenta` = C.`numeroCuenta`
		LEFT JOIN `redefectiva`.`dat_corresponsal`	AS	cor		ON cor.`numeroCuenta` = cuenta.`numCuenta`
		LEFT JOIN `redefectiva`.`dat_subcadena`		AS	sub		ON sub.`numCuenta` = cuenta.`numCuenta` AND sub.`idSubCadena` = cor.`idSubCadena`
		LEFT JOIN `redefectiva`.`dat_cadena`		AS	cad		ON cad.`idCadena` = cor.`idCadena`
		WHERE
			IF(Ck_idCadena			> -1, cad.`idCadena` = Ck_idCadena AND sub.`idCadena` = Ck_idCadena AND cor.`idCadena` = Ck_idCadena, 1)
		AND IF(Ck_idSubCadena		> -1, sub.`idSubCadena` = Ck_idSubCadena AND cor.`idSubCadena` = Ck_idSubCadena, 1)
		AND IF(Ck_idCorresponsal	> -1, cor.`idCorresponsal` = Ck_idCorresponsal, 1)
		AND IF(Ck_numCuenta			!= '', C.`numeroCuenta` = Ck_numCuenta, 1)
		AND IF(Ck_year				> 0, C.`year` = Ck_year, 1)
		AND IF(Ck_month				> 0, C.`month` = Ck_month, 1)
		AND IF(Ck_idFactura			> 0, C.`idFactura` = Ck_idFactura, 1)
		AND IF(Ck_noFactura			> 0, f.`noFactura` = Ck_noFactura, 1)
		GROUP BY cuenta.`numCuenta`
		LIMIT Ck_start, Ck_limit
		;
	END

*//*
$sql = "SELECT *
		FROM `data_contable`.`dat_corte_comision` AS C
		LEFT JOIN `redefectiva`.`dat_corresponsal` AS cor ON cor.`numeroCuenta` = C.`numeroCuenta`";

$sql = "SELECT CORTE.`idCorte`,DAT.`idCorresponsal`,DAT.`nombreCorresponsal`,DAT.`numeroCuenta`, CORTE.`totalVentas`, CORTE.`importeTotal`
FROM `redefectiva`.`dat_corresponsal` AS DAT
LEFT JOIN `data_contable`.`dat_corte_comision` AS CORTE
USING (`numeroCuenta`)
WHERE DAT.`idEstatusCorresponsal` = 0
AND CORTE.`idEstatus` = 3
$AND;";


	$Result = $RBD->query($sql);
	if($RBD->error() == ''){
		if(mysqli_num_rows($Result) > 0){	
?>

<table id="ordertabla"  border="0" cellspacing="0" cellpadding="0" class="tablesorter" style="width:700px; margin:0px auto;">
    <thead>
        <th style="width:30px" align="center">ID</th>
        <th style="width:80px">Corresponsal</th>
        <th style="width:100px">N&uacute;mero de Operaciones</th>
        <th style="width:80px;" align="center">Monto Total</th>
        <?php if($idPermiso == 0){ ?>
        	<th style="width:100px"></th>
        <?php } ?>
    </thead><tbody>
	<?php while(list($id,$idcor,$desc,$cta,$op,$impT)=mysqli_fetch_array($Result)){ ?>
	<tr>
        <td><?php echo $idcor; ?></td>
        <td><?php echo utf8_encode($desc); ?></td>
        <td align="center"><?php echo $op; ?></td>
        <td align="right"><?php echo number_format(($impT/1),2); ?></td>
        <?php if(true){ ?>
        <td align="right">
        <form method="post" action="Consulta.php" id="Form<?php echo $id; ?>" name="Form<?php echo $id; ?>">
            <input type="hidden" id="cadena" name="cadena" value="<?php echo $cadena; ?>" />
            <input type="hidden" id="subcadena" name="subcadena" value="<?php echo $subcadena; ?>" />
            <input type="hidden" id="corresponsal" name="corresponsal" value="<?php echo $corresponsal; ?>" />
            <input type="hidden" id="nomCorresponsal" name="nomCorresponsal" value="<?php echo $desc; ?>" />
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" id="mes" name="mes" value="<?php echo $mes; ?>" />
            <input type="hidden" id="ano" name="ano" value="<?php echo $ano; ?>" />
            <input type="hidden" id="importe" name="importe" value="<?php echo $impT; ?>" />
            <input type="hidden" id="numcta" name="numcta" value="<?php echo $cta; ?>" />
            	<a href="#" onclick="SubmitForm('Form<?php echo $id; ?>')">Asignar Factura</a>
        </form>
        <?php } ?>
        </td>
	</tr>
	<?php } ?>
    </tbody>
</table>
<br />
    
<?php 			
		}else{
			echo "<label class='subtitulo_contenido'>No se Encontraron Registros</label>";
		}		
	}else{
		echo "<label class='subtitulo_contenido'>Error: ".$RBD->error()."</label>";
	}*/
?>