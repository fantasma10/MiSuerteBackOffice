<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");
	$idPermiso = (isset($_SESSION['Permisos']['Tipo'][3]))?$_SESSION['Permisos']['Tipo'][3]:1;

	global $RBD;

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}

	$idCadena		= (isset($_GET['cadena']) AND $_GET['cadena'] >= 0 AND $_GET['cadena'] != '')?$_GET['cadena']:-1;
	$idSubCadena	= (isset($_GET['subcadena']) AND $_GET['subcadena'] >= 0 AND $_GET['subcadena'] != '')?$_GET['subcadena']:-1;
	$idCorresponsal	= (isset($_GET['corresponsal']) AND $_GET['corresponsal'] >= 0 AND $_GET['corresponsal'] != '')?$_GET['corresponsal']:-1;

	$start	= (!empty($_GET['iDisplayStart']))? $_GET['iDisplayStart'] : 0;
	$limit	= (!empty($_GET['iDisplayLength']))? $_GET['iDisplayLength'] : 10;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? utf8_decode($_REQUEST['sSearch']) : '';

	$strQ = "CALL SP_LOAD_REFERENCIASBANCARIAS($idCadena, $idSubCadena, $idCorresponsal, $start, $limit)";
	$sql = $RBD->query($strQ);

	$data = array();

	if(!$RBD->error()){
		
		while($row= mysqli_fetch_assoc($sql)){

			if(empty($row['referencia'])){
				$referencia = '<input onclick="crearReferenciaBancaria('.$row['numCuenta'].');" type="button" value="Crear Referencia"/>';
			}else{
				$referencia = $row['referencia'];
			}
			
			$data[] = array(
				codificarUTF8($row['nombreCadena']),
				codificarUTF8($row['nombreSubCadena']),
				$row['numCuenta'],
				$referencia
			);

			
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