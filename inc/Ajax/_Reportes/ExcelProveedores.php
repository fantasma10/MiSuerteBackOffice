<?php
/*
********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .CSV DESCARGABLE **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");

/*header("Content-Type: application/vnd.ms-excel"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=Proveedores.xls");*/

header("Content-type=application/x-msdownload");
header("Content-disposition:attachment;filename=Proveedores.xls");
header("Pragma:no-cache");
header("Expires:0");

/*
	recibimos los parametros por post, vienen en formato como si se hubieran pasado por la url proveedor=1&familia=2&...
*/
$parametros = (!empty($_POST["params"]))? $_POST["params"] : "";

/*
	si se recibieron parametros, se separan por el &
*/
if(!empty($parametros)){
	$parametros = explode("&", $parametros);
	/* arreglo para guardar los parametros */
	$params = array();
	
	/*	recorrer el arreglo $parametros y cada elemento separarlo por el =
		el primer valor será el indice que se guardará en el arreglo $params y el segundo el contenido
		valores usados actualmente : 
		proveedor: proveedor seleccionado
		familia	: familia seleccionada
		fecha1	: fecha inicial
		fecha2	: fecha final
		opPag	: operaciones a mostrar por pagina
		actual	: pagina actual del reporte
		todos	: bandera para saber si se generara el excel paginado o sin paginar
	*/
	foreach($parametros AS $param){
		$exp = explode("=", $param);
		$key = current($exp);
		$value = end($exp);

		$params[$key] = $value;
	}

	/*
		armar una cadena que enviaremos al stored procedure para filtrar
		en caso de que los parametros contengan al proveedor y/o familia
		se buscan sus descripciones para añadirlas al reporte
	*/
	$AND = "";
	$lblProveedor = "";
	$lblFamilia = "";
	$proveedor = $params["proveedor"];
	$familia = $params["familia"];
	if($params["proveedor"] != ''){
		$AND.= " AND `idProveedor` = $params[proveedor] ";
		$sProv = $RBD->query("call SPA_LOADPROVEEDOR($params[proveedor])");
		$rProv = mysqli_fetch_array($sProv);
		$lblProveedor = $rProv["nombreProveedor"];
	}
	if($params["familia"] != ''){
		$AND.= " AND `ops_operacion`.`idFamilia` = $params[familia] ";
		$sFam = $RBD->query("call SP_LOAD_FAMILIA($params[familia])");
		$rFam = mysqli_fetch_array($sFam);
		$lblFamilia = $rFam["descFamilia"];
	}
	
	if ( empty($proveedor) ) {
		$proveedor = "NULL";
	}
	if ( empty($familia) ) {
		$familia = "NULL";
	}
	
	if ( $params["verDetalle"] == "false" ) {
		$params["verDetalle"] = false;
	} else {
		$params["verDetalle"] = true;
	}
	
	$AND			= " '".$AND."' ";
	$fecha_inicio	= " '".$params["fecha1"]."' ";
	$fecha_final	= " '".$params["fecha2"]."' ";
	$INNER = "INNER JOIN `dat_producto` USING(`idProducto`)";
    $INNER = "'".$INNER."'";

	/*	
		si no se requiere paginacion se envian en 0 el start y el limit, en el stored procedure se valida y en este caso, no realizara la paginacion
		si se requiere entonces calculamos los valores de start y limit de acuerdo a la informacion de opPag y actual
	*/
	if ( !empty($params["todos"]) ) {
		$start = 0;
		$limit = $params["totalReg"];
	} else {
		$limit = $params["opPag"];
		$start = 0;
		if ( $params["actual"]>1 ) {
			$start = ($params["actual"] -1) * $params["opPag"];
		}
	}

	//$res = $RBD->query("call SP_LOAD_REPORTEPROVEEDORES($fecha_inicio, $fecha_final, $AND, $start, $limit, $INNER, 0)");

	if ( !$params["verDetalle"] ) {
		$start = "NULL";
		$limit = "NULL";
		if ( $limit >= 100 ) {
			$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, 100, 0);");
		} else {
			$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, $limit, 0);");
		}	
		//$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, $limit, 0);");
		//var_dump("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, $limit, 0);");
	} else {
		/*if ( $limit >= 100 ) {
			$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, 100, 2);");
		} else {
			$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, $limit, 2);");
		}*/
		//$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, $limit, 2);");
		//var_dump("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, $limit, 2);");
		$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, 100, 2);");
		//var_dump("CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES`($fecha_inicio, $fecha_final, $proveedor, $familia, $start, 100, 2);");
	}
	
	/*
		Dibujar Headers de la Tabla
	*/
?>
	<table border='0' cellspacing='0' cellpadding='0' class='tablesorter'>
		<tr>
			<th colspan=9>PROVEEDORES</th>
		</tr>
		<tr></tr>
<?php
		/* si se filtro por proveedor, ponemos el nombre del proveedor en los encabezados del reporte */
	if($lblProveedor != ""){
?>
		<tr>
			<th colspan=9>Proveedor : <?php echo $lblProveedor; ?></th>
		</tr>
<?php
	}

		/* Si se filtro por familia ponemos el nombre de la familia en los encabezados del reporte */
	if($lblFamilia != ""){
?>
		<tr>
			<th colspan=9>Familia : <?php echo $lblFamilia; ?></th>
		</tr>
<?php
	}
?>
<?php
	if(!$params["verDetalle"]){
?>		
        <tr>
			<th class='header'>Total</th>
			<th class='header'>Producto</th>
			<th class='header'>Importe</th>
			<th class='header'>Comisi&oacute;n Cliente</th>
			<th class='header'>SubTotal</th>
			<th class='header'>IVA</th>
			<th class='header'>Importe Total</th>
			<th class='header'>Comisi&oacute;n Ganada</th>
			<th class='header'>Importe Neto</th>
		</tr>
		<tbody>
<?php
	}else{
?>
        <tr>
			<th class='header'>idFolio</th>
            <th class='header'>Autorizaci&oacute;n</th>
			<th class='header'>Producto</th>
			<th class='header'>Importe</th>
			<th class='header'>Comisi&oacute;n Cliente</th>
			<th class='header'>SubTotal</th>
			<th class='header'>IVA</th>
			<th class='header'>Importe Total</th>
			<th class='header'>Comisi&oacute;n Ganada</th>
			<th class='header'>Importe Neto</th>
            <th class='header'>Fecha</th>
            <th class='header'>Cta. Contable</th>
           <th class='header'> Corresponsal</th>
		</tr>
		<tbody>
<?php
	}
?>
<?php if ( !$params["verDetalle"] ) { ?>
<?php
	$suma = array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0);
	while(list($IDop,$TOTOP,$PROD,$TOTIMP,$TOTCOMCLI,$TOTSUBTOT,$TOTIVA,$TOTIMPTOT,$TOTCOMGAN,$TOTIMPNET) = mysqli_fetch_array($res)){
	$suma[0] += $TOTOP;
	$suma[1] += $PROD;
	$suma[2] += $TOTIMP;
	$suma[3] += $TOTCOMCLI;
	$suma[4] += $TOTSUBTOT;
	$suma[5] += $TOTIVA;
	$suma[6] += $TOTIMPTOT;
	$suma[7] += $TOTCOMGAN;
	$suma[8] += $TOTIMPNET;
?>		
		<tr>
			<td><?php echo $TOTOP; ?></td>
			<td><?php echo $PROD; ?></td>
			<td><?php echo "\$  ".number_format($TOTIMP,2);?></td>
			<td><?php echo "\$  ".number_format($TOTCOMCLI,2);?></td>
			<td><?php echo "\$  ".number_format($TOTSUBTOT,2);?></td>
			<td><?php echo "\$  ".number_format($TOTIVA,2);?></td>
			<td><?php echo "\$  ".number_format($TOTIMPTOT,2);?></td>
			<td><?php echo "\$  ".number_format($TOTCOMGAN,2);?></td>
			<td><?php echo "\$  ".number_format($TOTIMPNET,2);?></td>
		</tr>
<?php
	}
?>
		<tr>
		<?php
			$cont=0;
			foreach($suma AS $sum){
				if($cont > 1){
					echo "<td>\$ ".number_format($sum,2)."</td>";
				}
				else{
					echo "<td>".utf8_decode($sum)."</td>";
				}
				$cont++;
			}
		?>
		</tr>
		</tbody>
	</table>
<?php
//}
?>
<?php }else{ ?>
<?php
	$suma = array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0);
	while(list($IDop,$AUT,$PROD,$TOTIMP,$TOTCOMCLI,$TOTSUBTOT,$TOTIVA,$TOTIMPTOT,$TOTCOMGAN,$TOTIMPNET,$FECHA,$CUENTA,$IDCORR,$NOMCORR,$CTACONTABLE) = mysqli_fetch_array($res)){
	$suma[0] += $TOTOP;
	$suma[1] += $PROD;
	$suma[2] += $TOTIMP;
	$suma[3] += $TOTCOMCLI;
	$suma[4] += $TOTSUBTOT;
	$suma[5] += $TOTIVA;
	$suma[6] += $TOTIMPTOT;
	$suma[7] += $TOTCOMGAN;
	$suma[8] += $TOTIMPNET;
?>		
		<tr>
			<td><?php echo $IDop; ?></td>
            <td><?php echo $AUT; ?></td>
			<td><?php echo $PROD; ?></td>
			<td><?php echo "\$  ".number_format($TOTIMP,2);?></td>
			<td><?php echo "\$  ".number_format($TOTCOMCLI,2);?></td>
			<td><?php echo "\$  ".number_format($TOTSUBTOT,2);?></td>
			<td><?php echo "\$  ".number_format($TOTIVA,2);?></td>
			<td><?php echo "\$  ".number_format($TOTIMPTOT,2);?></td>
			<td><?php echo "\$  ".number_format($TOTCOMGAN,2);?></td>
			<td><?php echo "\$  ".number_format($TOTIMPNET,2);?></td>
            <td><?php echo $FECHA; ?></td>
            <td><?php echo $CTACONTABLE; ?></td>
            <td><?php echo $NOMCORR; ?></td>
		</tr>
<?php
	}
?>
		<tr>
		<?php
			$cont=0;
			foreach($suma AS $sum){
				if($cont > 1){
					echo "<td>\$ ".number_format($sum,2)."</td>";
				}
				else{
					echo "<td>".utf8_decode($sum)."</td>";
				}
				$cont++;
			}
		?>
		</tr>
		</tbody>
	</table>
<?php
}
?>
<?php } ?>