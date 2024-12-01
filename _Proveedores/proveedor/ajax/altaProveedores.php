<?php
ini_set("soap.wsdl_cache_enabled", "0");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session2.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/customFunctions.php");

$tipo  = (!empty($_POST["tipo"])) ? $_POST["tipo"] : 0;
//1: Busca en el catalog de familias
//2: Busca en el catalogo de subfamilia
//3:

/*
function saveInfoCfgCuentaBanco($arreglo,$idProveedor,$datos,$flagZona){

	$p_nTipoCliente = $datos["p_nTipoCliente"];
	$p_nTipo = $datos["p_nTipo"];
	$p_nIdBanco = $datos["p_nIdBanco"];
	$p_sRFC = $datos["p_sRFC"];
	$p_sAlfanumerica = $datos["p_sAlfanumerica"];
	$p_sBeneficiario = $datos["p_sBeneficiario"];
	$p_sCuentaContableIngresos = $datos["p_sCuentaContableIngresos"];
	$p_sCuentacontableCostos = $datos["p_sCuentacontableCostos"];
	$p_sCuentaContableProveedor = $datos["p_sCuentaContableProveedor"];
	$p_sCuentaContableBanco = $datos["p_sCuentaContableBanco"];
	$p_sCuentaContableClientes = $datos["p_sCuentaContableClientes"];
	$p_sCuentaContableIVATraslado = $datos["p_sCuentaContableIVATraslado"];
	$p_sCuentaContableIVACreditable = $datos["p_sCuentaContableIVACreditable"];

	$contador=0;
	$tipoGuardado="";
	if($flagZona==0){
		$tipoGuardado = 0; // Por Zonas
		if(is_array($arreglo)){
			foreach ($arreglo as $valor) {
				$partes = explode("|", $valor);
				$interno = explode(",",$partes[0]);

				$idZona = $interno[1];
				$cuentaclabe = $interno[2];
				$referenciazona = $interno[3];
				$bancoZona = $interno[4];
				$p_sAlfanumerica = 0;

				$query = "CALL `redefectiva`.`sp_insert_cfgcuentabanco`('$idProveedor','$p_nTipoCliente','$p_nTipo','$bancoZona','$cuentaclabe','$p_sRFC','$p_sAlfanumerica','$p_sBeneficiario','$p_sCuentaContableIngresos','$p_sCuentacontableCostos','$p_sCuentaContableProveedor','$p_sCuentaContableBanco','$p_sCuentaContableClientes','$p_sCuentaContableIVATraslado','$p_sCuentaContableIVACreditable','$idZona',$contador,$tipoGuardado,'$referenciazona');";
			    $resultado = $GLOBALS['WBD']->query($query);
			    $contador++;
			}
			return true;
		}else{
			return false;
		}

	}else{
		if($p_nTipoCliente == 2){ // guarda 2 cuentas
			// $tipoGuardado = 1; // Doble cuenta
			// $CLABE = $datos["p_clabe"];
			// $query = "CALL `redefectiva`.`sp_insert_cfgcuentabanco`('$idProveedor','$p_nTipoCliente','0','$p_nIdBanco','$CLABE','$p_sRFC','$p_sAlfanumerica','$p_sBeneficiario','$p_sCuentaContableIngresos','$p_sCuentacontableCostos','$p_sCuentaContableProveedor','$p_sCuentaContableBanco','$p_sCuentaContableClientes','$p_sCuentaContableIVATraslado','$p_sCuentaContableIVACreditable',0,$contador,$tipoGuardado,'');";
			// $resultado = $GLOBALS['WBD']->query($query);
			// $contador++;

			// $bancored = $datos["p_bancored"];
			// $clabered = $datos["p_clabered"];
			// $referenciared = $datos["p_referenciaAlfared"];
			// $beneficiariored = $datos["p_beneficiario_DBred"];

			// $query = "CALL `redefectiva`.`sp_insert_cfgcuentabanco`('$idProveedor','$p_nTipoCliente','1','$bancored','$clabered','$p_sRFC','$referenciared','$beneficiariored','$p_sCuentaContableIngresos','$p_sCuentacontableCostos','$p_sCuentaContableProveedor','$p_sCuentaContableBanco','$p_sCuentaContableClientes','$p_sCuentaContableIVATraslado','$p_sCuentaContableIVACreditable',0,$contador,$tipoGuardado,'');";
			// $resultado = $GLOBALS['WBD']->query($query);

			// return true;

		}else{
			$tipoGuardado = 2; // normal 1 cuenta
			$CLABE = $datos["p_clabe"];
			$query = "CALL `redefectiva`.`sp_insert_cfgcuentabanco`('$idProveedor','$p_nTipoCliente','0','$p_nIdBanco','$CLABE','$p_sRFC','$p_sAlfanumerica','$p_sBeneficiario','$p_sCuentaContableIngresos','$p_sCuentacontableCostos','$p_sCuentaContableProveedor','$p_sCuentaContableBanco','$p_sCuentaContableClientes','$p_sCuentaContableIVATraslado','$p_sCuentaContableIVACreditable',0,$contador,$tipoGuardado,'');";
			$resultado = $GLOBALS['WBD']->query($query);
			$contador++;
			return true;
		}

	}

}
 */

function guardarCuentaBanco($arreglo, $p_idProveedor, $parametros)
{
    $p_clabe                      = $parametros["p_clabe"];
    $p_rfc                         = $parametros["p_rfc"];
    $p_banco                     = $parametros["p_banco"];
    $p_referenciaAlfa             = $parametros["p_referenciaAlfa"];
    $p_beneficiarioDB             = $parametros["p_beneficiarioDB"];
    $p_cuenta                      = $parametros["p_cuenta"];
    $p_nTipo                     = $parametros['p_nTipo'];

    if ($p_nTipo === 2) {
        # code...
        return $resultado = 'Con zona';
    } else {
        $query = "CALL `redefectiva`.`sp_insert_cuentabanco`(
			$p_idProveedor,
			$p_nTipo,
			$p_banco,
			'$p_clabe',
			'$p_rfc',
			'$p_cuenta',
			'$p_referenciaAlfa',
			'$p_beneficiarioDB',
			0,
			'',
			''
		);";

        $resultado = $GLOBALS['WBD']->query($query);

        if (!($resultado)) {
            // $datos["code"] = "99";
            // $datos["msg"] = "Error al guardar los Datos Bancarios";
            $datos = false;
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                // $datos["code"] = $row["code"];
                // $datos["msg"] = utf8_encode($row["msg"]);
                $datos = ($row['nCodigo'] == '0') ? true : false;
            }
        }

        return $datos;
    }
}

function guardarCuentasContablesProducto($idProveedor, $lineas, $contadorCCP)
{

    if (is_array($lineas)) {
        foreach ($lineas as &$valor) {
            $partes = explode("|", $valor);
            $id = $partes[0];
            $familia = $partes[1];
            $subfamilia = $partes[2];
            $emisor = $partes[3];
            $producto = $partes[4];
            $cuentacontableingresos = $partes[5];
            $cuentacontablecostos = $partes[6];

            $tipo_credito = $partes[7];
            $ccingresos_clean = str_replace("-", "", $cuentacontableingresos);
            $cccostos_clean   = str_replace("-", "", $cuentacontablecostos);
            $cadena = $partes[8];
            $segmentado = explode(",", $producto);
            $arrlength = count($segmentado);
            for ($x = 0; $x < $arrlength; $x++) {
                $producto_ind = $segmentado[$x];
                $particion = explode(",", $cadena);
                $partlength = count($particion);
                for ($i = 0; $i < $partlength; $i++) {
                    $contadorCCP++;
                    $cadena_ind = $particion[$i];
                    $query = "CALL `redefectiva`.`sp_insert_cta_cntb_prods`($idProveedor,$familia,$subfamilia,'$producto_ind','$ccingresos_clean','$cccostos_clean',$contadorCCP,$tipo_credito,'$cadena_ind','$emisor');";
                    $resultado = $GLOBALS['WBD']->query($query);
                }
            }
            // $cadena_clean = substr($cadena,0,-1);
        }
    }
    return;
}

function guardarTarjetas($idProveedor, $lineas, $contadorTarjetas)
{
    if (is_array($lineas)) {
        foreach ($lineas as &$valor) {
            $contadorTarjetas++;
            $partes = explode(",", $valor);
            $id = $partes[0];

            $tipoCredito = $partes[1];
            $tipoTarjeta = $partes[2];
            $porcentaje = $partes[3];
            $query = "CALL `redefectiva`.`sp_insert_tarjetas_proveedor`($idProveedor,$tipoCredito,$tipoTarjeta,'$porcentaje',$contadorTarjetas);";
            $resultado = $GLOBALS['WBD']->query($query);
        }
    }
    return;
}

function guardarRepresentanteLegal($idProveedor, $representantes, $tipoCliente)
{
    $datos = array();
    $p_proveedor = $idProveedor;
    $p_tipoCliente = $tipoCliente;

    $queries = array();
    for ($i = 0; $i < count($representantes); $i++) {
        $representante = $representantes[$i];
        $p_representanteLegal = strtoupper(trim($representante['representanteLegal']));
        $p_identificacion = $representante['identificacion'];
        $p_numIdentificacion = strtoupper(trim($representante['numeroIdentificacion']));
        $p_idRepre = $representante['idRepre'];

        if (!empty($p_idRepre)) {
            $query = "CALL `redefectiva`.`sp_update_representante_legal`(
            $p_proveedor,
            '$p_tipoCliente',
            '$p_representanteLegal',
            $p_identificacion,
            '$p_numIdentificacion',
            $p_idRepre
        );";
        } else {
            $query = "CALL `redefectiva`.`sp_insert_representante_legal`(
            $p_proveedor,
            '$p_tipoCliente',
            '$p_representanteLegal',
            '$p_identificacion',
            '$p_numIdentificacion'
        );";
        }
        $queries[] = $query;
    }

    foreach ($queries as $quer) {
        $resultado = $GLOBALS['WBD']->query($quer);

        if (!$resultado) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
            return $datos; // Salir inmediatamente en caso de error
        }
    }

    $datos["code"] = "0";
    $datos["msg"] = "Proceso exitoso";
    $datos["representantes"] = secciones($p_proveedor);

    return $datos;
}

function guardarDatosBancarios($idProveedor, $bancos, $rfc)
{
    $datos = array();
    $p_proveedor = $idProveedor;
    $p_valorZona              = $_POST["p_valorZona"];
    $p_nTipo                 = $p_valorZona === "false" ? 0 : 2;
    $p_rfc                 = $rfc;

    $queries = array();
    for ($i = 0; $i < count($bancos); $i++) {
        $representante = $bancos[$i];
        $p_clabe = $representante['clabe'];
        $p_cuenta = $representante['cuenta'];
        $p_alfanumerico = $representante['alfanumerico'];
        $p_idBanco = $representante['idBanco'];
        $p_nIdCuentaBanco = $representante['nIdCuentaBanco'];
        $p_beneficiario = $representante['beneficiario'];
        //Bancos LATAM
        $p_swift = $representante['swift'];
        $p_iban = $representante['iban'];
        $p_code = $representante['code'];
        $p_pais = $representante['pais'];


        if (!empty($p_nIdCuentaBanco)) {
            $query = "CALL `redefectiva`.`sp_update_datos_bancarios`(
            '$p_proveedor',
            '$p_rfc',
            '$p_clabe',
            '$p_idBanco',
            '$p_alfanumerico',
            '$p_beneficiario',
            '$p_cuenta',
            '$p_nIdCuentaBanco',
            '$p_swift',
            '$p_iban',
            '$p_code',
            $p_pais
        );";
        } else {
            $query = "CALL `redefectiva`.`sp_insert_datos_bancarios`(
            '$p_proveedor',
            '$p_nTipo',
            '$p_idBanco',
            '$p_clabe',
            '$p_rfc',
            '$p_cuenta',
            '$p_alfanumerico',
            '$p_beneficiario',
            '$p_swift',
            '$p_iban',
            '$p_code',
            $p_pais
        );";
        }
        $queries[] = $query;
    }

    foreach ($queries as $quer) {
        $resultado = $GLOBALS['WBD']->query($quer);

        if (!$resultado) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
            return $datos; // Salir inmediatamente en caso de error
        }
    }

    $datos["code"] = "0";
    $datos["msg"] = "Proceso exitoso";
    $datos["bancos"] = secciones($p_proveedor);

    return $datos;
}

function borrarRepresentanteLegal($idProveedor, $idRepre)
{
    $datos = array();
    if (!empty($idRepre)) {
        $query = "CALL `redefectiva`.`sp_delete_representante_legal`($idProveedor, $idRepre);";
        $resultado = $GLOBALS['WBD']->query($query);

        if (!$resultado) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
            return $datos; // Salir caso de error
        }
    }

    $datos["code"] = "0";
    $datos["msg"] = "Proceso exitoso";
    $datos["representantes"] = secciones($idProveedor);

    return $datos;
}

function borrarDatosBancarios($idProveedor, $idRepre)
{
    $datos = array();
    if (!empty($idRepre)) {
        $query = "CALL `redefectiva`.`sp_delete_datos_bancarios`($idProveedor, $idRepre);";
        $resultado = $GLOBALS['WBD']->query($query);

        if (!$resultado) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
            return $datos; // Salir caso de error
        }
    }

    $datos["code"] = "0";
    $datos["msg"] = "Proceso exitoso";
    $datos["representantes"] = secciones($idProveedor);

    return $datos;
}





/*
function guardarMatrizEscalamiento($idProveedor,$lineasMatriz,$idIdentificacion,$numeroIdentificacion,$representante_legal){
		$contador=0;
		$query = "CALL `redefectiva`.`sp_select_proveedor`($idProveedor);";
		$sql = $GLOBALS['RBD']->query($query);
		$datos = array();
		$index = 0;
		$tipoProveedor;
		//insertar representante legal
		while ($row = mysqli_fetch_assoc($sql)) {
			$tipoProveedor= $row["nIdTipoCliente"];
		}

		$query = "CALL `redefectiva`.`sp_insert_matriz_escalamiento`($idProveedor,$tipoProveedor,'','$representante_legal','','','',1,$idIdentificacion,'$numeroIdentificacion');";
		$resultado = $GLOBALS['WBD']->query($query);

		foreach ($lineasMatriz as &$valor) {
		    $partes = explode(",", $valor);
		   	$id=$partes[0];
		   	$departamento = $partes[1];
		   	$nombre= $partes[2];
		   	$puesto = $partes[3];
		   	$telefono = $partes[4];
		   	$correo = $partes[5];
		   	$correoLimpio= substr($correo, 0, -1);
		$query = "CALL `redefectiva`.`sp_insert_matriz_escalamiento`($idProveedor,$tipoProveedor,'$departamento','$nombre','$puesto','$telefono','$correoLimpio',0,$idIdentificacion,'$numeroIdentificacion');";
		    $resultado = $GLOBALS['WBD']->query($query);
		    $contador=0;
		}
		return;
}
 */

function guardarMatrizEscalamiento($idProveedor, $matriz, $parametros, $es_representante)
{
    $p_tipoCliente                      = $parametros["p_tipoCliente"];

    if ($es_representante) {
        $p_representanteLegal     = $parametros["p_representanteLegal"];
        $p_identificacion         = $parametros["p_identificacion"];
        $p_numIdentificacion     = $parametros["p_numIdentificacion"];

        $query = "CALL `redefectiva`.`sp_insert_matriz_escalamiento`($idProveedor,$p_tipoCliente,'','','$p_representanteLegal','','','',1,$p_identificacion,'$p_numIdentificacion');";

        $resultado = $GLOBALS['WBD']->query($query);

        if (!($resultado)) {
            // $datos["code"] = "99";
            // $datos["msg"] = "Error al guardar el Representante Legal.";
            $datos = false;
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                // $datos["code"] = $row["nCodigo"];
                // $datos["msg"] = $row["sMensaje"];
                $datos = ($row['nCodigo'] == '0') ? true : false;
            }
        }
    } else {
        foreach ($matriz as &$valor) {
            $partes = explode(",", $valor);
            $id = $partes[0];
            $departamento = $partes[1];
            $nombre = $partes[2];
            $puesto = $partes[3];
            $telefono = $partes[4];
            $correo = $partes[5];
            $correoLimpio = substr($correo, 0, -1);

            $query = "CALL `redefectiva`.`sp_insert_matriz_escalamiento`($idProveedor,$p_tipoCliente,'', '$departamento','$nombre','$puesto','$telefono','$correoLimpio',0,0,'');";

            $resultado = $GLOBALS['WBD']->query($query);
            $contador = 0;
        }

        $query_secciones = "CALL `redefectiva`.`sp_update_secciones_proveedor`($idProveedor, 'bSeccion7', 1);";
        $resultado_secciones = $GLOBALS['WBD']->query($query_secciones);
        $datos = true;
    }

    return $datos;
}

function secciones($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_select_proveedor_secciones`($proveedor_id);";

    $resultado = $GLOBALS['RBD']->query($query);

    if (!($resultado)) {
        $datos = null;
    } else {
        $datos = mysqli_fetch_assoc($resultado);
    }

    return $datos;
}

function obtenerRepresentateLegal($proveedor_id)
{
    // $query = "CALL `redefectiva`.`sp_select_representante_legal_proveedor`($proveedor_id);";
    $query = "CALL `redefectiva`.`sp_select_representantes_legales`($proveedor_id);";

    $resultado = $GLOBALS['RBD']->query($query);

    $datos = array();

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos[] = $row;
        }
    }

    return $datos;
}

function obtenerPagosProveedor($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_select_pago_proveedor`($proveedor_id);";

    $resultado = $GLOBALS['RBD']->query($query);

    if (!($resultado)) {
        $datos = null;
    } else {
        $datos = mysqli_fetch_assoc($resultado);
    }

    return $datos;
}

function obtenerPeriodos($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_select_periodos_corte_proveedor`($proveedor_id);";

    $resultado = $GLOBALS['RBD']->query($query);

    if (!($resultado)) {
        $datos = null;
    } else {
        $index = 0;
        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos[$index]["nIdPagoProveedor"]     = $row["nIdPagoProveedor"];
            $datos[$index]["nDiaCorte"]         = $row["nDiaCorte"];
            $datos[$index]["sDiasPago"]         = $row["sDiasPago"];
            $datos[$index]["nIdProveedor"]         = $row["nIdProveedor"];
            $index++;
        }
    }

    return $datos;
}

function guardarFacturaProveedor($p_proveedor, $tipoFactura, $p_cfdi, $p_claveProductoServicio, $p_unidad, $p_formaPago, $p_metodoPago, $p_correoDestino, $p_periodoFacturacion, $p_diasLiquidaFactura)
{
    $query = "CALL `redefectiva`.`sp_cfg_factura_proveedor`('$p_proveedor', '$tipoFactura', '$p_cfdi', '$p_claveProductoServicio', '$p_unidad', '$p_formaPago', '$p_metodoPago', '$p_correoDestino', '$p_periodoFacturacion', '$p_diasLiquidaFactura');";

    $resultado = $GLOBALS['WBD']->query($query);

    if (!($resultado)) {
        $datos["code"]     = "99";
        $datos["msg"]     = "Error en el proceso de Factura Proveedor.";
    } else {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos["code"]     = $row["nCodigo"];
            $datos["msg"]     = $row["sMensaje"];
        }
    }

    return $datos;
}

function obtenerDatosBancarios($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_select_datos_bancarios_proveedor`($proveedor_id);";

    $resultado = $GLOBALS['RBD']->query($query);

    $datos = array();

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos[] = $row;
        }
    }

    return $datos;
}

function obtenerDatosProveedor($p_proveedor)
{
    $oRdb = $GLOBALS['oRdb'];
    $array_params = array(
        array('name' => 'p_nIdProveedor', 'value' => $p_proveedor, 'type' => 'i')
    );
    $oRdb->setSDatabase('redefectiva');
    $oRdb->setSStoredProcedure('sp_select_proveedor_datos');
    $oRdb->setParams($array_params);
    $result = $oRdb->execute();

    if ($result['nCodigo'] == 0) {
        $datos["code"] = "0";

        $rows = $oRdb->fetchAll();
        foreach ($rows as $key => $row) {
            $datos["datos"]["nIdSolicitante"] = $row["nIdSolicitante"];
            $datos["datos"]["dFechaConstitutiva"] = $row["dFechaConstitutiva"];
            $datos["datos"]["nIdTipoCliente"] = $row["nIdTipoCliente"];
            $datos["datos"]["nTipoVenta"] = $row["nTipoVenta"];
            $datos["datos"]["RFC"] = $row["RFC"];
            $datos["datos"]["razonSocial"] = utf8_encode($row["razonSocial"]);
            $datos["datos"]["idGiro"] = utf8_encode($row["nIdGiro"]);
            $datos["datos"]["nombreProveedor"] = utf8_encode($row["nombreProveedor"]);
            $datos["datos"]["sRegimenSocietario"] = utf8_encode($row["sRegimenSocietario"]);
            $datos["datos"]["nIdSolicitante"] = $row["nIdSolicitante"];
            $datos["datos"]["sRegimenFiscal"] = $row["sRegimenFiscal"];
            $datos["datos"]["idPais"] = $row["idPais"];
            $datos["datos"]["calleDireccion"] = utf8_encode($row["calleDireccion"]);
            $datos["datos"]["numeroExtDireccion"] = $row["numeroExtDireccion"];
            $datos["datos"]["numeroIntDireccion"] = $row["numeroIntDireccion"];
            $datos["datos"]["cpDireccion"] = $row["cpDireccion"];
            $datos["datos"]["sNombreColonia"] = utf8_encode($row["sNombreColonia"]);
            $datos["datos"]["sNombreMunicipio"] = utf8_encode($row["sNombreMunicipio"]);
            $datos["datos"]["sNombreEstado"] = utf8_encode($row["sNombreEstado"]);
            $datos["datos"]["nRetencion"] = $row["nRetencion"];
            $datos["datos"]["nTipoLiquidacion"] = $row["nTipoLiquidacion"];
            $datos["datos"]["nTndias"] = $row["nTndias"];
            $datos["datos"]["nDiaPago"] = $row["nDiaPago"];
            $datos["datos"]["nDiasAtras"] = $row["nDiasAtras"];
            $datos["datos"]["sEmailNotifiLiquidacion"] = $row["sEmailNotifiLiquidacion"];
            $datos["datos"]["nCobroTransferencia"] = $row["nCobroTransferencia"];
            $datos["datos"]["nImporteTransferencia"] = $row["nImporteTransferencia"];
            $datos["datos"]["nCantidadTransferencia"] = $row["nCantidadTransferencia"];
            $datos["datos"]["nTipoTiempoAire"] = $row["nTipoTiempoAire"];
            $datos["datos"]["cantidadCredito"] = $row["cantidadCredito"];
            $datos["datos"]["diasCredito"] = $row["nDiasCredito"];
            $datos["datos"]["tipoCredito"] = $row["tipoCredito"];
            $datos["datos"]["nIVA"] = $row["nIVA"];
            $datos["datos"]["nFacturaComision"] = $row["nFacturaComision"];
            $datos["datos"]["nFacturaTransferencia"] = $row["nFacturaTransferencia"];
            $datos["datos"]["idcColonia"] = $row["idcColonia"];
            $datos["datos"]["nEnviaReporte"] = $row["nEnviaReporte"];
        }

        $oRdb->closeStmt();

        $datos["secciones"] = secciones($p_proveedor);
        $datos["documentos"] = obtenerDocumentos($p_proveedor);
        $datos["matriz"] = obtenerMatrizEscalamiento($p_proveedor);
        $datos["repre"] = obtenerRepresentateLegal($p_proveedor);
        $datos["bancos"] = obtenerDatosBancarios($p_proveedor);
        $datos['facturas'] = obtenerFacturas($p_proveedor);
        $datos['departamentos'] = obtenerDepartamento();

        if ($datos['datos']['nTipoLiquidacion'] == 2) {
            $datos["periodos"] = obtenerPeriodos($p_proveedor);
        }
    } else {
        $datos["code"] = "99";
        $datos["msg"] = "No se puedo obtener la informacion del proveedor";
        $datos['datos'] = null;
    }

    return $datos;
}

function obtenerFacturacion($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_select_proveedor_datos`($proveedor_id);";

    $resultado = $GLOBALS['RBD']->query($query);

    $datos = array();

    if ($resultado) {
        if ($row = mysqli_fetch_assoc($resultado)) {
            $datos['nIVA'] = $row['nIVA'];
        }
    }

    return $datos;
}

function pagoProveedor($proveedor_id, $pagoLunes, $pagoMartes, $pagoMiercoles, $pagoJueves, $pagoViernes, $pagoSabado, $pagoDomingo)
{
    $query = "CALL `redefectiva`.`sp_pago_proveedor`('$proveedor_id', '$pagoLunes', '$pagoMartes', '$pagoMiercoles', '$pagoJueves', '$pagoViernes', '$pagoSabado', '$pagoDomingo');";

    $resultado = $GLOBALS['WBD']->query($query);

    if (!($resultado)) {
        $datos["code"] = "99";
        $datos["msg"] = "Error al guardar Pagos Poveedor.";
    } else {
        $datos = mysqli_fetch_assoc($resultado);
        // while ($row = mysqli_fetch_assoc($resultado)) {
        // 	// $datos["code"] = $row["nCodigo"];
        // 	$datos["msg"] = utf8_encode($row["sMensaje"]);
        // }
    }

    return $datos;
}

function limpiarMatrizEscalamiento($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_delete_matriz_escalamiento_proveedores`($proveedor_id);";
    $resultado = $GLOBALS['WBD']->query($query);

    return $resultado;
}

function obtenerDepartamento()
{
    $query = "SELECT * FROM redefectiva.cat_area;";
    $resultado = $GLOBALS['RBD']->query($query);

    if (!($resultado)) {
        $datos = null;
    } else {
        $index = 0;
        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos[$index]["nIdArea"] = $row["nIdArea"];
            $datos[$index]["sNombre"] = utf8_encode($row["sNombre"]);
            $index++;
        }
    }

    return $datos;
}

function obtenerMatrizEscalamiento($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_select_matriz_escalamiento_proveedores`($proveedor_id);";
    $resultado = $GLOBALS['RBD']->query($query);

    if (!($resultado)) {
        $datos = null;
    } else {
        $index = 0;
        while ($row = mysqli_fetch_assoc($resultado)) {
            // $datos[$index]["sDepartamento"] = $row["sDepartamento"];
            $datos[$index]["nDepartamento"] = $row["nDepartamento"];
            $datos[$index]["sNombre"]         = $row["sNombre"];
            $datos[$index]["sPuesto"]         = $row["sPuesto"];
            $datos[$index]["sTelefono"]        = $row["sTelefono"];
            $datos[$index]["sCorreo"]         = $row["sCorreo"];
            $index++;
        }
    }

    return $datos;
}

function obtenerFacturas($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_select_factura_proveedor`($proveedor_id);";

    $resultado = $GLOBALS['RBD']->query($query);

    if (!($resultado)) {
        $datos = null;
    } else {
        $index = 0;
        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos[$index]["nIdProveedor"]     = $row["nIdProveedor"];
            $datos[$index]["nTipoFactura"]     = $row["nTipoFactura"];
            $datos[$index]["sUsoCFDI"]     = $row["sUsoCFDI"];
            $datos[$index]["sClaveProductoServicio"]         = $row["sClaveProductoServicio"];
            $datos[$index]["sUnidad"]         = $row["sUnidad"];
            $datos[$index]["sFormaPago"]         = $row["sFormaPago"];
            $datos[$index]["sMetodoPago"]         = $row["sMetodoPago"];
            $datos[$index]["sCorreoDestino"]         = $row["sCorreoDestino"];
            $datos[$index]["nPeriodoFacturacion"]         = $row["nPeriodoFacturacion"];
            $datos[$index]["nDiaFacturacionSemanal"]         = $row["nDiaFacturacionSemanal"];
            $datos[$index]["nDiasLiquidaFactura"]         = $row["nDiasLiquidaFactura"];
            $index++;
        }
    }

    return $datos;
}

function obtenerDocumentos($proveedor_id)
{
    $query = "CALL `redefectiva`.`sp_select_documentos_proveedor`($proveedor_id);";

    $resultado = $GLOBALS['RBD']->query($query);

    if (!($resultado)) {
        $datos = null;
    } else {
        $index = 0;
        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos[$index]["nIdDocumento"]     = $row["nIdDocumento"];
            $datos[$index]["nIdTipoDoc"]     = $row["nIdTipoDoc"];
            $datos[$index]["sNombreDoc"]     = $row["sNombreDoc"];
            $datos[$index]["sRutaDoc"]         = $row["sRutaDoc"];
            $index++;
        }
    }

    return $datos;
}

function crearSku($familia, $subfamilia, $emisor)
{

    $query = "CALL `redefectiva`.`sp_select_datos_sku`($familia,$subfamilia,$emisor);";
    $sku1 = "";
    $sku2 = "";
    $sku3 = "";
    $sku4 = "";
    $sku5 = "";

    $sql = $GLOBALS['RBD']->query($query);
    $datos = array();
    $index = 0;
    $tipoProveedor;
    $abrev_familia = "";
    $abrev_subfamilia = "";
    $contador = 0;
    while ($row = mysqli_fetch_assoc($sql)) {
        $contador = $row["contador"];
        $abrev_familia = $row["abrev_familia"];
        $abrev_subfamilia = $row["abrev_subfamilia"];
    }

    $sku1 = substr($abrev_familia, 2, 4);
    $sku2 = $abrev_subfamilia;

    if ($familia >= 10) {
        $sku3 = $familia;
    } else {
        $sku3 = '0' . $familia;
    }

    if ($emisor >= 10) {
        $sku4 = $emisor;
    } else {
        $sku4 = '0' . $emisor;
    }
    $countp = $contador + 1;

    if ($countp >= 10) {
        $sku5 = $countp;
    } else {
        $sku5 = '0' . $countp;
    }

    $skuprod = $sku1 . $sku2 . $sku3 . $sku4 . $sku5;

    return $skuprod;
}

function guardarServicios($servicios, $idProducto, $emisor)
{
    $contador = 0;
    foreach ($servicios as $key => $value) {
        $splitear = explode("_", $value);
        $id_servicio = $splitear[1];
        /*SP*/
        $usuario = $_SESSION["idU"];
        $query = "CALL `redefectiva`.`sp_insert_inf_productoservicio`($idProducto,$id_servicio,$emisor,$usuario,$contador);";
        $resultado = $GLOBALS['WBD']->query($query);
        $contador++;
        /*SP*/
    }
}

function formatearFecha($fecha)
{
    $var = $fecha;
    $date = str_replace('/', '-', $var);
    $resultado =  date('Y-m-d', strtotime($date));
    return $resultado;
}

function listarCorreos($correos)
{
    $listaCorreos = "";

    if (!empty($correos)) {
        foreach ($correos as &$correo) {
            $listaCorreos .= $correo . ":";
        }
        $listaCorreos = substr($listaCorreos, 0, -1);
    }

    return $listaCorreos;
}

function obtenerGiro()
{
    $query = "SELECT * FROM `cat_giro`";

    $resultado = $GLOBALS['RBD']->query($query);

    $datos = array();

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos[] = $row;
        }
    }

    return $datos;
}

switch ($tipo) {
    case 1:
        $query = "CALL `redefectiva`.`SP_CAT_FAMILIA`();";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idFamilia"] = $row["idFamilia"];
            $datos[$index]["descFamilia"] = utf8_encode($row["descFamilia"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 2:
        $idFamilia = (!empty($_POST["idFamilia"])) ? $_POST["idFamilia"] : 0;
        $query = "CALL `redefectiva`.`SP_GET_SUBFAMILIAS`($idFamilia);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idSubFamilia"] = $row["idSubFamilia"];
            $datos[$index]["descSubFamilia"] = utf8_encode($row["descSubFamilia"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 3:
        $idFamilia = (!empty($_POST["idFamilia"])) ? $_POST["idFamilia"] : 0;
        $idSubFamilia = (!empty($_POST["idSubFamilia"])) ? $_POST["idSubFamilia"] : 0;
        $query = "CALL `redefectiva`.`SP_SELECT_PRODUCTOS_FAM_SUBFAM`($idFamilia,$idSubFamilia);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idProducto"] = $row['idProducto'];
            $datos[$index]["descProducto"] = utf8_encode($row['descProducto']);
            $index++;
        }
        print json_encode($datos);
        break;
    case 4:
        $query = "CALL `redefectiva`.`SP_LOAD_EMISORES`();";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idEmisor"] = $row["idEmisor"];
            $datos[$index]["descEmisor"] = utf8_encode($row["descEmisor"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 5:
        $query = "CALL `redefectiva`.`SP_GET_CAT_FLUJO`();";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idFlujo"] = $row["idFlujo"];
            $datos[$index]["descFlujo"] = utf8_encode($row["descFlujo"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 6:
        $idFamilia = (!empty($_POST["idFamilia"])) ? $_POST["idFamilia"] : 0;
        $query = "CALL `redefectiva`.`SP_GET_CAT_TRANTYPE`($idFamilia);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idTranType"] = $row["idTranType"];
            $datos[$index]["descTranType"] = utf8_encode($row["descTranType"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 7:
        $familia = (!empty($_POST["familia"])) ? $_POST["familia"] : 0;
        $subfamilia = (!empty($_POST["subfamilia"])) ? $_POST["subfamilia"] : 0;
        $emisor = (!empty($_POST["emisor"])) ? $_POST["emisor"] : 0;
        $descripcion = (!empty($_POST["descripcion"])) ? $_POST["descripcion"] : 0;
        $abreviatura = (!empty($_POST["abreviatura"])) ? $_POST["abreviatura"] : 0;

        $sku = crearSku($familia, $subfamilia, $emisor);

        if (!empty($_POST["fechaentradavigor"])) {
            $fechaentradavigor = formatearFecha($_POST["fechaentradavigor"]);
        } else {
            $fechaentradavigor = 0;
        }

        $date = explode('-', $fechaentradavigor);
        $anio = $date[0];
        $anio = $anio + 20;
        $mes = $date[1];
        $dia = $date[2];

        $fechasalidavigor = $anio . "-" . $mes . "-" . $dia;

        $flujoimporte = $_POST["flujoimporte"];
        if (empty($flujoimporte)) {
            $flujoimporte = 0;
        }

        $importeminimoproducto = $_POST["importeminimoproducto"];
        if (empty($importeminimoproducto)) {
            $importeminimoproducto = 0;
        }

        $importemaximoproducto = $_POST["importemaximoproducto"];
        if (empty($importemaximoproducto)) {
            $importemaximoproducto = 0;
        }

        $porcentajecomisionproducto = $_POST["porcentajecomisionproducto"];
        if (empty($porcentajecomisionproducto)) {
            $porcentajecomisionproducto = 0;
        } else {
            $porcentajecomisionproducto = $porcentajecomisionproducto / 100;
        }

        $importecomisionproducto = $_POST["importecomisionproducto"];
        if (empty($importecomisionproducto)) {
            $importecomisionproducto = 0;
        }

        $porcentajecomisioncorresponsal = $_POST["porcentajecomisioncorresponsal"];
        if (empty($porcentajecomisioncorresponsal)) {
            $porcentajecomisioncorresponsal = 0;
        } else {
            $porcentajecomisioncorresponsal = $porcentajecomisioncorresponsal / 100;
        }

        $importecomisioncorresponsal = $_POST["importecomisioncorresponsal"];
        if (empty($importecomisioncorresponsal)) {
            $importecomisioncorresponsal = 0;
        }

        $porcentajecomisioncliente = $_POST["porcentajecomisioncliente"];
        if (empty($porcentajecomisioncliente)) {
            $porcentajecomisioncliente = 0;
        } else {
            $porcentajecomisioncliente = $porcentajecomisioncliente / 100;
        }

        $importecomisioncliente = $_POST["importecomisioncliente"];
        if (empty($importecomisioncliente)) {
            $importecomisioncliente = 0;
        }

        $usuario = $_SESSION["idU"];
        $abreviatura = utf8_decode($abreviatura);
        $descripcion = utf8_decode($descripcion);
        $sku = utf8_decode($sku);
        $longitudServicios = $_POST["longitudServicios"];

        $query = "CALL `redefectiva`.`SP_INSERT_PRODUCTO`($familia,$subfamilia,$emisor,'$abreviatura','$descripcion','$sku','$fechaentradavigor','$fechasalidavigor',$flujoimporte,$importeminimoproducto,$importemaximoproducto,$porcentajecomisionproducto,$importecomisionproducto,$porcentajecomisioncorresponsal,$importecomisioncorresponsal,$porcentajecomisioncliente,$importecomisioncliente,$usuario);";


        $resultado = $WBD->query($query);

        while ($row = mysqli_fetch_assoc($resultado)) {
            $datos["code"] = $row["ErrorCode"];
            $datos["msg"] = $row["ErrorMsg"];
            $datos["idproducto"] = $row["idproducto"];
        }

        if (!empty($datos["idproducto"])) {

            guardarServicios($longitudServicios, $datos["idproducto"], $emisor);
        }

        if (is_array($datos)) {
            if ($datos["code"] == 0) {
                echo json_encode(array(
                    "showMessage"    => 0,
                    "msg"            => "Operación Exitosa",
                    "idproducto"     => $datos["idproducto"]
                ));
            } else {
                echo json_encode(array(
                    "showMessage"    => 1,
                    "msg"            => "Fallo Operación"
                ));
            }
        } else {
            echo json_encode(array(
                "showMessage"    => 1,
                "msg"            => "Fallo Operación"
            ));
        }

        break;
    case 10:
        $idProveedor = $_POST["idProveedor"];
        //obtener productos proveedor
        $queryPP = "CALL `redefectiva`.`sp_get_productos_proveedor`($idProveedor);";
        $sqlPP = $RBD->query($queryPP);
        $datosPP = array();
        $indexPP = 0;
        while ($rowPP = mysqli_fetch_assoc($sqlPP)) {
            $datosPP[$indexPP]["idFamilia"] = $rowPP["idFamilia"];
            $datosPP[$indexPP]["descFamilia"] = utf8_encode($rowPP["descFamilia"]);
            $datosPP[$indexPP]["idsubfamilia"] = $rowPP["idsubfamilia"];
            $datosPP[$indexPP]["descSubFamilia"] = utf8_decode($rowPP["descSubFamilia"]);
            $datosPP[$indexPP]["idproducto"] = $rowPP["idproducto"];
            $datosPP[$indexPP]["nombreproducto"] = utf8_encode($rowPP["nombreproducto"]);
            $datosPP[$indexPP]["importe"] = $rowPP["importe"];
            $datosPP[$indexPP]["descuento"] = $rowPP["descuento"];
            $datosPP[$indexPP]["importesindescuento"] = $rowPP["importesindescuento"];
            $datosPP[$indexPP]["importesiniva"] = $rowPP["importesiniva"];
            $indexPP++;
        }
        echo json_encode($datosPP);
        break;
    case 11:
        $idProveedor = $_POST["idProveedor"];
        $query = "CALL `redefectiva`.`sp_get_docs_proveedor`($idProveedor);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["nIdDocumento"] = $row["nIdDocumento"];
            $datos[$index]["nIdTipoDoc"] = $row["nIdTipoDoc"];
            $datos[$index]["sNombreDoc"] = $row["sNombreDoc"];
            $datos[$index]["nRutaDoc"] = $row["nRutaDoc"];
            $index++;
        }
        echo json_encode($datos);
        break;
    case 12:
        $idProveedor = $_POST["idProveedor"];
        $query = "CALL `redefectiva`.`sp_get_periodo_proveedor`($idProveedor);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["nDiaCorte"] = $row["nDiaCorte"];
            $datos[$index]["sDiasPago"] = $row["sDiasPago"];
            $index++;
        }
        echo json_encode($datos);
        break;
    case 13:
        $idProveedor = $_POST["idProveedor"];
        $query = "CALL `redefectiva`.`sp_get_datos_fact_proveedor`($idProveedor);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["nTipoFactura"] = $row["nTipoFactura"];
            $datos[$index]["sUsoCFDI"] = $row["sUsoCFDI"];
            $datos[$index]["sClaveProductoServicio"] = $row["sClaveProductoServicio"];
            $datos[$index]["sUnidad"] = $row["sUnidad"];
            $datos[$index]["sFormaPago"] = $row["sFormaPago"];
            $datos[$index]["sMetodoPago"] = $row["sMetodoPago"];
            $datos[$index]["sCorreoDestino"] = $row["sCorreoDestino"];
            $datos[$index]["nPeriodoFacturacion"] = $row["nPeriodoFacturacion"];
            $datos[$index]["nDiasLiquidaFactura"] = $row["nDiasLiquidaFactura"];

            $index++;
        }
        echo json_encode($datos);
        break;
    case 14:
        $idProveedor = $_POST["idProveedor"];
        $query = "CALL `redefectiva`.`sp_get_matriz_esc_proveedor`($idProveedor);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["sDepartamento"] = $row["sDepartamento"];
            $datos[$index]["sNombre"] = $row["sNombre"];
            $datos[$index]["sPuesto"] = $row["sPuesto"];
            $datos[$index]["sTelefono"] = $row["sTelefono"];
            $datos[$index]["sCorreo"] = $row["sCorreo"];
            $index++;
        }
        echo json_encode($datos);
        break;
    case 16:
        $query = "CALL `redefectiva`.`SP_LOAD_PRODUCTOS`();";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idProducto"] = $row["idProducto"];
            $datos[$index]["descProducto"] = utf8_encode($row["descProducto"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 17:
        $query = "CALL `redefectiva`.`sp_select_conectores`();";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idConector"] = $row["idConector"];
            $datos[$index]["descConector"] = utf8_encode($row["descConector"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 18:
        $idProveedor = $_POST["idProveedor"];
        $query = "CALL `redefectiva`.`sp_get_ccp_proveedor`($idProveedor);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idFamilia"] = $row["idFamilia"];
            $datos[$index]["descFamilia"] = utf8_encode($row["descFamilia"]);
            $datos[$index]["idSubFamilia"] = $row["idSubFamilia"];
            $datos[$index]["descSubFamilia"] = utf8_encode($row["descSubFamilia"]);
            $datos[$index]["idEmisor"] = $row["idEmisor"];
            $datos[$index]["descEmisor"] = utf8_encode($row["descEmisor"]);
            $datos[$index]["id_productos"] = $row["id_productos"];
            $datos[$index]["nombre_productos"] = utf8_encode($row["nombre_productos"]);
            $datos[$index]["sCuentaContableIngresos"] = $row["sCuentaContableIngresos"];
            $datos[$index]["sCuentaContableCostos"] = $row["sCuentaContableCostos"];
            $datos[$index]["nTipoCredito"] = $row["nTipoCredito"];
            $datos[$index]["descTipoCredito"] = utf8_encode($row["descTipoCredito"]);
            $datos[$index]["id_cadenas"] = $row["id_cadenas"];
            $datos[$index]["nombre_cadenas"] = utf8_encode($row["nombre_cadenas"]);
            $index++;
        }
        echo json_encode($datos);
        break;
    case 19:
        $query = "CALL `redefectiva`.`SP_LOAD_CADENAS`();";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idCadena"] = $row["idCadena"];
            $datos[$index]["nombreCadena"] = utf8_encode($row["nombreCadena"]);
            $index++;
        }
        echo json_encode($datos);
        break;
    case 26:
        $familia  = $_POST["familia"];
        $subfamilia = $_POST["subfamilia"];

        $query = "CALL `redefectiva`.`sp_loademisoresbyfamsubfam`($familia,$subfamilia);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idemisor"] = $row["idemisor"];
            $datos[$index]["descEmisor"] = utf8_encode($row["descEmisor"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 27:
        $emisor  = $_POST["emisor"];
        $familia  = $_POST["familia"];
        $subfamilia  = $_POST["subfamilia"];

        $query = "CALL `redefectiva`.`sp_get_productos_by_emisor`($emisor,$familia,$subfamilia);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["idProducto"] = $row["idProducto"];
            $datos[$index]["descProducto"] = utf8_encode($row["descProducto"]);
            $index++;
        }
        print json_encode($datos);
        break;
    case 28:
        $idProveedor = $_POST["idProveedor"];

        $query = "CALL `redefectiva`.`sp_get_info_tarjetas`($idProveedor);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {

            $datos[$index]["nIdProveedor"] = $row["nIdProveedor"];
            $datos[$index]["nTipoCredito"] = $row["nTipoCredito"];
            $datos[$index]["nTipoTarjeta"] = $row["nTipoTarjeta"];
            $datos[$index]["nPorcentaje"] = $row["nPorcentaje"];
            $index++;
        }
        print json_encode($datos);
        break;
    case 29:
        $query = "CALL `redefectiva`.`sp_getZonasGN`();";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["nIdEntidad"] = $row["nIdEntidad"];
            $datos[$index]["sEntidad"] = $row["sEntidad"];
            $index++;
        }
        print json_encode($datos);
        break;
    case 30:
        $proveedor = $_POST["proveedor"];
        $query = "CALL `redefectiva`.`sp_getInfoZonas`($proveedor);";
        $sql = $RBD->query($query);
        $datos = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($sql)) {
            $datos[$index]["sClabe"] = $row["sClabe"];
            $datos[$index]["nIdZona"] = $row["nIdZona"];
            $datos[$index]["sZona"] = $row["sZona"];
            $datos[$index]["sreferenciaZona"] = $row["sreferenciaZona"];
            $datos[$index]["nIdBanco"] = $row["nIdBanco"];
            $index++;
        }
        print json_encode($datos);
        break;
    case 31:
        $p_idEmpleado         = $_SESSION['idU'];
        $p_solicitante         = $_POST["p_solicitante"];
        $p_tipocliente         = $_POST["p_tipoCliente"];
        $p_tipoventa         = $_POST["p_tipoVenta"];
        $p_rfc                 = strtoupper(trim($_POST["p_rfc"]));
        $p_razonsocial         = utf8_decode(strtoupper(trim($_POST["p_razonSocial"])));
        $p_nombrecomercial     = utf8_decode(strtoupper(trim($_POST["p_nombreComercial"])));
        $p_regimenSocietario = utf8_decode(trim($_POST["p_regimenSocietario"]));
        $p_regimenFiscal     = $_POST['p_regimenFiscal'];
        $p_giro              = $_POST['p_giro'];
        $p_cmbpais             = $_POST["p_cmbpais"];
        $p_txtcalle         = utf8_decode(strtoupper(trim($_POST["p_txtCalle"])));
        $p_ext                 = trim($_POST["p_ext"]);
        $p_int                 = trim($_POST["p_int"]);
        $p_txtcp             = trim($_POST["p_txtCP"]);
        $p_cmbcolonia        = $_POST["p_cmbColonia"];
        $p_idcMunicipio     = $_POST["p_cmbCiudad"];
        $p_cmbentidad         = $_POST["p_cmbEntidad"];
        $p_txtcolonia         = utf8_decode(trim($_POST["p_txtColonia"]));
        $p_txtciudad         = utf8_decode(trim($_POST["p_txtCiudad"]));
        $p_txtestado        = utf8_decode(trim($_POST["p_txtEstado"]));
        $p_nIdSerie         = $_POST["p_nIdSerie"];
        $p_sSerie             = trim($_POST["p_sSerie"]);
        $p_nIdUnidadNegocio = $_POST["p_unidadNegocio"];

        $p_dFechaConstitutiva = '1900-01-01';
        if (!empty($_POST["p_fechaConstitutiva"])) {
            $p_dFechaConstitutiva = trim($_POST["p_fechaConstitutiva"]);
        }

        $array_params = array(
            array('name' => 'p_idEmpleado', 'value' => $p_idEmpleado, 'type' => 'i'),
            array('name' => 'p_solicitante', 'value' => $p_solicitante, 'type' => 'i'),
            array('name' => 'p_tipocliente', 'value' => $p_tipocliente, 'type' => 'i'),
            array('name' => 'p_tipoventa', 'value' => $p_tipoventa, 'type' => 'i'),
            array('name' => 'p_rfc', 'value' => $p_rfc, 'type' => 's'),
            array('name' => 'p_razonsocial', 'value' => $p_razonsocial, 'type' => 's'),
            array('name' => 'p_regimenSocietario', 'value' => $p_regimenSocietario, 'type' => 's'),
            array('name' => 'p_nombrecomercial', 'value' => $p_nombrecomercial, 'type' => 's'),
            array('name' => 'p_regimenFiscal', 'value' => $p_regimenFiscal, 'type' => 'i'),
            array('name' => '$p_cmbpais', 'value' => $p_cmbpais, 'type' => 'i'),
            array('name' => 'p_txtcalle', 'value' => $p_txtcalle, 'type' => 's'),
            array('name' => 'p_int', 'value' => $p_int, 'type' => 's'),
            array('name' => 'p_ext', 'value' => $p_ext, 'type' => 's'),
            array('name' => 'p_txtcp', 'value' => $p_txtcp, 'type' => 's'),
            array('name' => 'p_cmbcolonia', 'value' => $p_cmbcolonia, 'type' => 'i'),
            array('name' => 'p_idcMunicipio', 'value' => $p_idcMunicipio, 'type' => 'i'),
            array('name' => 'p_cmbentidad', 'value' => $p_cmbentidad, 'type' => 'i'),
            array('name' => 'p_txtcolonia', 'value' => $p_txtcolonia, 'type' => 's'),
            array('name' => 'p_txtciudad', 'value' => $p_txtciudad, 'type' => 's'),
            array('name' => 'p_txtestado', 'value' => $p_txtestado, 'type' => 's'),
            array('name' => 'p_estatus', 'value' => $p_nIdSerie, 'type' => 'i'),
            array('name' => 'p_estatus', 'value' => $p_sSerie, 'type' => 'i'),
            array('name' => 'p_estatus', 'value' => $p_nIdUnidadNegocio, 'type' => 'i'),
            array('name' => 'p_estatus', 'value' => $p_dFechaConstitutiva, 'type' => 's'),
            array('name' => 'p_giro', 'value' => $p_giro, 'type' => 'i')
        );

        $oWdb->setSDatabase('redefectiva');
        $oWdb->setSStoredProcedure('sp_insert_informacion_proveedor');
        $oWdb->setParams($array_params);
        $result = $oWdb->execute();

        if ($result['nCodigo'] == 0) {
            $row = $oWdb->fetchAll();
            $datos["code"] = strval($row[0]["nCodigo"]);
            $datos["msg"] = $row[0]["sMensaje"];
            $datos["proveedor"] = $row[0]["id"];
            $datos["nombre"] = $row[0]["sNombreProveedor"];
            $datos["secciones"] = secciones($row[0]["id"]);
            $data = obtenerDatosProveedor($row[0]["id"]);
            $datos["datos"] = $data['datos'];
        } else {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        }

        $oWdb->closeStmt();

        print json_encode($datos);
        break;
    case 32:
        $oRdb->setSDatabase('data_acceso');
        $oRdb->setSStoredProcedure('sp_select_usuarios_comercial');
        $result = $oRdb->execute();

        if ($result['nCodigo'] ==  0) {
            $datos['code'] = 0;
            $datos['msg'] = 'Ok';

            $rows = $oRdb->fetchAll();
            foreach ($rows as $key => $row) {
                $datos['comerciales'][$key]['id']     = $row['usuario_id'];
                $datos['comerciales'][$key]['nombre'] = utf8_encode($row['comerciales']);
            }
        } else {
            $datos["code"] = "99";
            $datos["msg"] = "No se puedo obtener la información de los solicitantes";
            $datos['comerciales'] = null;
        }

        $oRdb->closeStmt();
        echo json_encode($datos);
        break;
    case 33:
        $p_proveedor             = $_POST['p_proveedor'];
        $p_tipoCliente             = $_POST["p_tipoCliente"];
        $representantes            = $_POST['p_lineasMatriz'];

        $datos = guardarRepresentanteLegal($p_proveedor, $representantes, $p_tipoCliente);

        $datos["repre"] = obtenerRepresentateLegal($p_proveedor);
        $datos["bancos"] = obtenerDatosBancarios($p_proveedor);
        print json_encode($datos);
        break;
    case 34:
        $p_proveedor = $_POST['p_proveedor'];

        $datos = obtenerDatosProveedor($p_proveedor);

        print json_encode($datos);
        break;
    case 35:
        $p_proveedor         = $_POST['p_proveedor'];
        $p_idEmpleado         = $_SESSION['idU'];
        $p_solicitante         = $_POST["p_solicitante"];
        $p_tipocliente         = $_POST["p_tipoCliente"];
        $p_tipoventa         = $_POST["p_tipoVenta"];
        $p_rfc                 = strtoupper($_POST["p_rfc"]);
        $p_razonsocial         = utf8_decode(trim($_POST["p_razonSocial"]));
        $p_nombrecomercial     = utf8_decode(trim($_POST["p_nombreComercial"]));
        $p_regimenSocietario = utf8_decode(trim($_POST["p_regimenSocietario"]));
        $p_regimenFiscal     = $_POST['p_regimenFiscal'];
        $p_giro              = $_POST['p_giro'];
        $p_cmbpais             = $_POST["p_cmbpais"];
        $p_txtcalle         = utf8_decode(trim($_POST["p_txtCalle"]));
        $p_ext                 = $_POST["p_ext"];
        $p_int                 = $_POST["p_int"];
        $p_txtcp             = trim($_POST["p_txtCP"]);
        $p_cmbcolonia        = ($_POST["p_cmbColonia"] == "-1") ? 0 : $_POST["p_cmbColonia"];
        $p_idcMunicipio     = ($_POST["p_cmbCiudad"] == "-1") ? 0 : $_POST["p_cmbCiudad"];
        $p_cmbentidad         = ($_POST["p_cmbEntidad"] == "-1") ? 0 : $_POST["p_cmbEntidad"];
        $p_txtcolonia         = utf8_decode(trim($_POST["p_txtColonia"]));
        $p_txtciudad         = utf8_decode(trim($_POST["p_txtCiudad"]));
        $p_txtestado        = utf8_decode(trim($_POST["p_txtEstado"]));
        $p_nIdSerie         = $_POST["p_nIdSerie"];
        $p_sSerie             = $_POST["p_sSerie"];
        $p_nIdUnidadNegocio = $_POST["p_unidadNegocio"];

        $p_dFechaConstitutiva = '1900-01-01';
        if (!empty($_POST["p_fechaConstitutiva"])) {
            $p_dFechaConstitutiva = formatearFecha($_POST["p_fechaConstitutiva"]);
        }

        $array_params = array(
            array('name' => 'p_proveedor', 'value' => $p_proveedor, 'type' => 'i'),
            array('name' => 'p_idEmpleado', 'value' => $p_idEmpleado, 'type' => 'i'),
            array('name' => 'p_solicitante', 'value' => $p_solicitante, 'type' => 'i'),
            array('name' => 'p_tipocliente', 'value' => $p_tipocliente, 'type' => 'i'),
            array('name' => 'p_tipoventa', 'value' => $p_tipoventa, 'type' => 'i'),
            array('name' => 'p_rfc', 'value' => $p_rfc, 'type' => 's'),
            array('name' => 'p_razonsocial', 'value' => $p_razonsocial, 'type' => 's'),
            array('name' => 'p_regimenSocietario', 'value' => $p_regimenSocietario, 'type' => 's'),
            array('name' => 'p_nombrecomercial', 'value' => $p_nombrecomercial, 'type' => 's'),
            array('name' => 'p_regimenFiscal', 'value' => $p_regimenFiscal, 'type' => 'i'),
            array('name' => 'p_cmbpais', 'value' => $p_cmbpais, 'type' => 'i'),
            array('name' => 'p_txtcalle', 'value' => $p_txtcalle, 'type' => 's'),
            array('name' => 'p_int', 'value' => $p_int, 'type' => 's'),
            array('name' => 'p_ext', 'value' => $p_ext, 'type' => 's'),
            array('name' => 'p_txtcp', 'value' => $p_txtcp, 'type' => 's'),
            array('name' => 'p_cmbcolonia', 'value' => $p_cmbcolonia, 'type' => 'i'),
            array('name' => 'p_idcMunicipio', 'value' => $p_idcMunicipio, 'type' => 'i'),
            array('name' => 'p_cmbentidad', 'value' => $p_cmbentidad, 'type' => 'i'),
            array('name' => 'p_txtcolonia', 'value' => $p_txtcolonia, 'type' => 's'),
            array('name' => 'p_txtciudad', 'value' => $p_txtciudad, 'type' => 's'),
            array('name' => 'p_txtestado', 'value' => $p_txtestado, 'type' => 's'),
            array('name' => 'p_nIdSerie', 'value' => $p_nIdSerie, 'type' => 'i'),
            array('name' => 'p_sSerie', 'value' => $p_sSerie, 'type' => 'i'),
            array('name' => 'p_nIdUnidadNegocio', 'value' => $p_nIdUnidadNegocio, 'type' => 'i'),
            array('name' => 'p_dFechaConstitutiva', 'value' => $p_dFechaConstitutiva, 'type' => 's'),
            array('name' => 'p_giro', 'value' => $p_giro, 'type' => 'i')
        );

        $oWdb->setSDatabase('redefectiva');
        $oWdb->setSStoredProcedure('sp_update_informacion_proveedor');
        $oWdb->setParams($array_params);
        $result = $oWdb->execute();

        if ($result['nCodigo'] == 0) {
            $row = $oWdb->fetchAll();
            $datos["code"] = strval($row[0]["nCodigo"]);
            $datos["msg"] = $row[0]["sMensaje"];
            $data = obtenerDatosProveedor($p_proveedor);
            $datos["datos"] = $data['datos'];
        } else {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        }

        $oWdb->closeStmt();

        print json_encode($datos);
        break;
    case 36:
        $p_proveedor             = $_POST["p_proveedor"];
        $p_tipoDocActa            = $_POST["p_tipoDocActa"];
        $p_rutaActa             = $_POST["p_rutaActa"];
        $p_docNombreActa         = $_POST["p_docNombreActa"];
        $p_tipoDocContrato         = $_POST["p_tipoDocContrato"];
        $p_rutaContrato         = $_POST["p_rutaContrato"];
        $p_docNombreContrato     = $_POST["p_docNombreContrato"];
        $p_tipoDocRfc             = $_POST["p_tipoDocRfc"];
        $p_rutaRfc                 = $_POST["p_rutaRfc"];
        $p_docNombreRfc         = $_POST["p_docNombreRfc"];
        $p_tipoDocDomicilio     = $_POST["p_tipoDocDomicilio"];
        $p_rutaDomicilio        = $_POST["p_rutaDomicilio"];
        $p_docNombreDomicilio     = $_POST["p_docNombreDomicilio"];
        $p_tipoDocRepreLegal     = $_POST["p_tipoDocRepreLegal"];
        $p_rutaRepreLegal         = $_POST["p_rutaRepreLegal"];
        $p_docNombreRepreLegal     = $_POST["p_docNombreRepreLegal"];
        $p_tipoDocPoderLegal     = $_POST["p_tipoDocPoderLegal"];
        $p_rutaPoderLegal         = $_POST["p_rutaPoderLegal"];
        $p_docNombrePoderLegal     = $_POST["p_docNombrePoderLegal"];
        $p_tipoDocAdendo1         = $_POST["p_tipoDocAdendo1"];
        $p_rutaAdendo1             = $_POST["p_rutaAdendo1"];
        $p_docNombreAdendo1     = $_POST["p_docNombreAdendo1"];
        $p_tipoDocAdendo2         = $_POST["p_tipoDocAdendo2"];
        $p_rutaAdendo2             = $_POST["p_rutaAdendo2"];
        $p_docNombreAdendo2     = $_POST["p_docNombreAdendo2"];

        $query = "CALL `redefectiva`.`sp_insert_or_update_documentos_proveedor`(
        '$p_proveedor',
        '$p_tipoDocActa',
        '$p_docNombreActa',
        '$p_tipoDocContrato',
        '$p_docNombreContrato',
        '$p_tipoDocRfc',
        '$p_docNombreRfc',
        '$p_tipoDocDomicilio',
        '$p_docNombreDomicilio',
        '$p_tipoDocRepreLegal',
        '$p_docNombreRepreLegal',
        '$p_tipoDocPoderLegal',
        '$p_docNombrePoderLegal',
        '$p_tipoDocAdendo1',
        '$p_docNombreAdendo1',
        '$p_tipoDocAdendo2',
        '$p_docNombreAdendo2'
	);";

        $resultado = $WBD->query($query);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos["code"] = $row["nCodigo"];
                $datos["msg"] = $row["sMensaje"];
                $datos["secciones"] = secciones($p_proveedor);
                $datos["documentos"] = obtenerDocumentos($p_proveedor);
            }
        }

        print json_encode($datos);
        break;
    case 37:
        $p_proveedor             = $_POST["p_proveedor"];
        $p_idDocActa            = $_POST["p_idDocActa"];
        $p_rutaActa             = $_POST["p_rutaActa"];
        $p_docNombreActa         = $_POST["p_docNombreActa"];
        $p_idDocContrato         = $_POST["p_idDocContrato"];
        $p_rutaContrato         = $_POST["p_rutaContrato"];
        $p_docNombreContrato     = $_POST["p_docNombreContrato"];
        $p_idDocRfc             = $_POST["p_idDocRfc"];
        $p_rutaRfc                 = $_POST["p_rutaRfc"];
        $p_docNombreRfc         = $_POST["p_docNombreRfc"];
        $p_idDocDomicilio         = $_POST["p_idDocDomicilio"];
        $p_rutaDomicilio        = $_POST["p_rutaDomicilio"];
        $p_docNombreDomicilio     = $_POST["p_docNombreDomicilio"];
        $p_idDocRepreLegal         = $_POST["p_idDocRepreLegal"];
        $p_rutaRepreLegal         = $_POST["p_rutaRepreLegal"];
        $p_docNombreRepreLegal     = $_POST["p_docNombreRepreLegal"];
        $p_idDocPoderLegal         = $_POST["p_idDocPoderLegal"];
        $p_rutaPoderLegal         = $_POST["p_rutaPoderLegal"];
        $p_docNombrePoderLegal     = $_POST["p_docNombrePoderLegal"];
        $p_idDocAdendo1         = $_POST["p_idDocAdendo1"];
        $p_rutaAdendo1             = $_POST["p_rutaAdendo1"];
        $p_docNombreAdendo1     = $_POST["p_docNombreAdendo1"];
        $p_idDocAdendo2         = $_POST["p_idDocAdendo2"];
        $p_rutaAdendo2             = $_POST["p_rutaAdendo2"];
        $p_docNombreAdendo2     = $_POST["p_docNombreAdendo2"];

        $query = "CALL `redefectiva`.`sp_update_documentos_proveedor`(
		'$p_idDocActa',
		'$p_docNombreActa',
		'$p_rutaActa',
		'$p_idDocContrato',
		'$p_docNombreContrato',
		'$p_rutaContrato',
		'$p_idDocRfc',
		'$p_docNombreRfc',
		'$p_rutaRfc',
		'$p_idDocDomicilio',
		'$p_docNombreDomicilio',
		'$p_rutaDomicilio',
		'$p_idDocRepreLegal',
		'$p_docNombreRepreLegal',
		'$p_rutaRepreLegal',
		'$p_idDocPoderLegal',
		'$p_docNombrePoderLegal',
		'$p_rutaPoderLegal',
		'$p_idDocAdendo1',
		'$p_docNombreAdendo1',
		'$p_rutaAdendo1',
		'$p_idDocAdendo2',
		'$p_docNombreAdendo2',
		'$p_rutaAdendo2'
	);";

        $resultado = $WBD->query($query);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos["code"] = $row["nCodigo"];
                $datos["msg"] = $row["sMensaje"];
            }
        }

        print json_encode($datos);
        break;
    case 38:
        $p_proveedor                 = $_POST["p_proveedor"];
        $parametros["p_tipoCliente"] = $_POST["p_tipoCliente"];
        $matriz                     = $_POST['p_lineasMatriz'];

        $resultado = guardarMatrizEscalamiento($p_proveedor, $matriz, $parametros, 0);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            $datos["code"] = "0";
            $datos["msg"] = "Matriz de Escalamiento guardada exitosamente.";
            $datos["secciones"] = secciones($p_proveedor);
        }

        print json_encode($datos);
        break;
    case 39:
        $p_proveedor                 = $_POST["p_proveedor"];
        $parametros["p_tipoCliente"] = $_POST["p_tipoCliente"];
        $matriz                     = $_POST['p_lineasMatriz'];

        limpiarMatrizEscalamiento($p_proveedor);

        $resultado = guardarMatrizEscalamiento($p_proveedor, $matriz, $parametros, 0);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            $datos["code"] = "0";
            $datos["msg"] = "Matriz de Escalamiento actualizada exitosamente.";
        }

        print json_encode($datos);
        break;
    case 40:
        $p_proveedor         = $_POST['p_proveedor'];
        $p_idRepre         = $_POST['p_idRepre'];

        $datos = borrarRepresentanteLegal($p_proveedor, $p_idRepre);

        $datos["repre"] = obtenerRepresentateLegal($p_proveedor);
        $datos["bancos"] = obtenerDatosBancarios($p_proveedor);
        print json_encode($datos);
        break;
    case 41:
        $p_proveedor         = $_POST['p_proveedor'];
        $p_tipoCredito         = $_POST['p_tipoCredito'];
        $p_tipoTiempoAire     = $_POST['p_tipoTiempoAire'];
        $p_nombreComercial     = $_POST['p_nombreComercial'];
        $p_cantidadCredito     = $_POST['p_cantidadCredito'];

        // Tiempo Aire (TA)
        $query = "CALL `redefectiva`.`sp_liquidacion_TA_proveedor`(
		'$p_proveedor',
		'$p_tipoCredito',
		'$p_tipoTiempoAire',
		'$p_nombreComercial',
		'$p_cantidadCredito'
	);";

        $resultado = $WBD->query($query);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos["code"] = $row["nCodigo"];
                $datos["msg"] = $row["sMensaje"];
                $datos["secciones"] = secciones($p_proveedor);
            }
        }
        print json_encode($datos);
        break;
    case 42:
        $p_proveedor             = $_POST['p_proveedor'];
        $p_nombreComercial         = $_POST['p_nombreComercial'];
        $p_retencion             = $_POST['p_retencion'];
        $p_tipoLiquidacion         = $_POST['p_tipoLiquidacion'];
        $p_nDias                 = trim($_POST['p_nDias']);
        $p_correosLiquidacion     = listarCorreos($_POST['p_correosLiquidacion']);
        $p_cobroTransferencia     = $_POST['p_cobroTransferencia'];
        $p_importeTransferencia = trim($_POST['p_importeTransferencia']);
        $p_cantidadTransferencia = trim($_POST['p_cantidadTransferencia']);
        $p_diaFechaPago         = $_POST['p_diaFechaPago'];
        $p_diasAtras             = trim($_POST['p_diasAtras']);
        $p_enviarReporte         = $_POST['p_enviarReporteCobranza'];
        $p_diasPagoLunes         = $_POST['p_diasPagoLunes'];
        $p_diasPagoMartes         = $_POST['p_diasPagoMartes'];
        $p_diasPagoMiercoles     = $_POST['p_diasPagoMiercoles'];
        $p_diasPagoJueves         = $_POST['p_diasPagoJueves'];
        $p_diasPagoViernes         = $_POST['p_diasPagoViernes'];
        $p_diasPagoSabado         = $_POST['p_diasPagoSabado'];
        $p_diasPagoDomingo         = $_POST['p_diasPagoDomingo'];
        $p_ivaFactura                 = $_POST['p_ivaFactura'];
        if ($p_ivaFactura == 1) $p_nIva = '0.1600';
        if ($p_ivaFactura == 2) $p_nIva = '0.0800';
        if ($p_ivaFactura == 3) $p_nIva = '0.0000';
        $p_tipoCredito         = $_POST['p_tipoCredito'];
        $p_tipoTiempoAire     = $_POST['p_tipoTiempoAire'];
        $p_cantidadCredito     = $_POST['p_cantidadCredito'];
        $p_diasCredito     = $_POST['p_diasCredito'];

        $query = "CALL `redefectiva`.`sp_liquidacion_proveedor`(
            '$p_proveedor',
            '$p_nombreComercial',
            '$p_retencion',
            '$p_tipoLiquidacion',
            '$p_nDias',
            '$p_correosLiquidacion',
            '$p_cobroTransferencia',
            '$p_importeTransferencia',
            '$p_cantidadTransferencia',
            '$p_diaFechaPago',
            '$p_diasAtras',
            '$p_enviarReporte',
            '$p_diasPagoLunes',
            '$p_diasPagoMartes',
            '$p_diasPagoMiercoles',
            '$p_diasPagoJueves',		
            '$p_diasPagoViernes',	
            '$p_diasPagoSabado', 
            '$p_diasPagoDomingo',
             $p_nIva,
            '$p_tipoCredito',
		    '$p_tipoTiempoAire',
            '$p_cantidadCredito',
            '$p_diasCredito'
        );";

        $resultado = $WBD->query($query);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos["code"] = $row["nCodigo"];
                $datos["msg"] = $row["sMensaje"];
                $datos["secciones"] = secciones($p_proveedor);
            }
        }

        print json_encode($datos);
        break;
    case 43:
        $p_proveedor                 = $_POST['p_proveedor'];
        $p_nombreComercial             = $_POST['p_nombreComercial'];
        $p_retencion                 = $_POST['p_retencion'];
        $p_tipoLiquidacion             = $_POST['p_tipoLiquidacion'];
        $p_nDias                     = $_POST['p_nDias'];
        $p_correosLiquidacion         = listarCorreos($_POST['p_correosLiquidacion']);
        $p_cobroTransferencia         = $_POST['p_cobroTransferencia'];
        $p_importeTransferencia     = $_POST['p_importeTransferencia'];
        $p_diaFechaPago             = $_POST['p_diaFechaPago'];
        $p_diasAtras                 = $_POST['p_diasAtras'];
        $p_enviarReporte         = $_POST['p_enviarReporteCobranza'];
        $p_diasPagoLunes         = $_POST['p_diasPagoLunes'];
        $p_diasPagoMartes         = $_POST['p_diasPagoMartes'];
        $p_diasPagoMiercoles     = $_POST['p_diasPagoMiercoles'];
        $p_diasPagoJueves         = $_POST['p_diasPagoJueves'];
        $p_diasPagoViernes         = $_POST['p_diasPagoViernes'];
        $p_diasPagoSabado         = $_POST['p_diasPagoSabado'];
        $p_diasPagoDomingo         = $_POST['p_diasPagoDomingo'];

        // Venta de Servicios (VS)
        $query = "CALL `redefectiva`.`sp_update_liquidacion_VS_proveedor`(
		'$p_proveedor',
		'$p_retencion',
		'$p_tipoLiquidacion',
		'$p_nDias',
		'$p_correosLiquidacion',
		'$p_cobroTransferencia',
		'$p_importeTransferencia',
		'$p_diaFechaPago',
		'$p_diasAtras',
		'$p_enviarReporte',
		'$p_diasPagoLunes',
		'$p_diasPagoMartes',
		'$p_diasPagoMiercoles',
		'$p_diasPagoJueves',		
		'$p_diasPagoViernes',	
		'$p_diasPagoSabado', 
		'$p_diasPagoDomingo'
	);";

        $resultado = $WBD->query($query);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos["code"] = $row["nCodigo"];
                $datos["msg"] = $row["sMensaje"];

                $datos["msg"] = "Liquidacion de Servicios actualizada exitosamente.";
            }
        }

        print json_encode($datos);
        break;
    case 44:
        $p_proveedor                 = $_POST['p_proveedor'];
        $p_ivaFactura                 = $_POST['p_ivaFactura'];
        $p_nFacturaComision         = $_POST['p_facturaComision'];
        $p_nFacturaTransferencia     = $_POST['p_facturaTransferencia'];

        if ($p_ivaFactura == 1) $p_nIva = '0.1600';
        if ($p_ivaFactura == 2) $p_nIva = '0.0800';
        if ($p_ivaFactura == 3) $p_nIva = '0.0000';

        $p_cfdiComision = $_POST['p_cfdiComision'];
        $p_claveProductoServicioComision = $_POST['p_claveProductoServicioComision'];
        $p_unidadComision = $_POST['p_unidadComision'];
        $p_formaPagoComision = $_POST['p_formaPagoComision'];
        $p_metodoPagoComision = $_POST['p_metodoPagoComision'];
        $p_correoDestinoComision = (count($_POST['p_correoDestinoComision']) > 0) ? listarCorreos($_POST['p_correoDestinoComision']) : '';
        $p_periodoFacturacionComision = $_POST['p_periodoFacturacionComision'];
        $p_diasLiquidaFacturaComision = ($_POST['p_diasLiquidaFacturaComision'] == '') ? 0 : $_POST['p_diasLiquidaFacturaComision'];

        $p_cfdiTransferencia = $_POST['p_cfdiTransferencia'];
        $p_claveProductoServicioTransferencia = $_POST['p_claveProductoServicioTransferencia'];
        $p_unidadTransferencia = $_POST['p_unidadTransferencia'];
        $p_formaPagoTransferencia = $_POST['p_formaPagoTransferencia'];
        $p_metodoPagoTransferencia = $_POST['p_metodoPagoTransferencia'];
        $p_correoDestinoTransferencia = (count($_POST['p_correoDestinoTransferencia']) > 0) ? listarCorreos($_POST['p_correoDestinoTransferencia']) : '';
        $p_periodoFacturacionTransferencia = $_POST['p_periodoFacturacionTransferencia'];
        $p_diasLiquidaFacturaTransferencia = ($_POST['p_diasLiquiquidaFacturaTransferencia'] == '') ? 0 : $_POST['p_diasLiquiquidaFacturaTransferencia'];

        $query = "CALL `redefectiva`.`sp_insert_datos_facturacion_proveedor`(
		'$p_proveedor',
		'$p_nIva',
		'$p_nFacturaComision',
		'$p_nFacturaTransferencia',
		'$p_cfdiComision',
        '$p_claveProductoServicioComision',
        '$p_unidadComision', 
        '$p_formaPagoComision', 
        '$p_metodoPagoComision', 
        '$p_correoDestinoComision', 
        '$p_periodoFacturacionComision',
		'$p_diasLiquidaFacturaComision',
		'$p_cfdiTransferencia', 
        '$p_claveProductoServicioTransferencia', 
        '$p_unidadTransferencia',
        '$p_formaPagoTransferencia', 
        '$p_metodoPagoTransferencia', 
        '$p_correoDestinoTransferencia', 
        '$p_periodoFacturacionTransferencia', 
		'$p_diasLiquidaFacturaTransferencia'
	);";

        $resultado = $WBD->query($query);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos["code"] = $row["nCodigo"];
                $datos["msg"] = $row["sMensaje"];
                $datos["secciones"] = secciones($p_proveedor);
            }
        }

        print json_encode($datos);
        break;
    case 45:
        $p_proveedor                 = $_POST['p_proveedor'];
        $p_ivaFactura                 = $_POST['p_ivaFactura'];
        $p_nFacturaComision         = $_POST['p_facturaComision'];
        $p_nFacturaTransferencia     = $_POST['p_facturaTransferencia'];

        if ($p_ivaFactura == 1) $p_nIva = '0.1600';
        if ($p_ivaFactura == 2) $p_nIva = '0.0800';
        if ($p_ivaFactura == 3) $p_nIva = '0.0000';

        $p_cfdiComision = $_POST['p_cfdiComision'];
        $p_claveProductoServicioComision = $_POST['p_claveProductoServicioComision'];
        $p_unidadComision = $_POST['p_unidadComision'];
        $p_formaPagoComision = $_POST['p_formaPagoComision'];
        $p_metodoPagoComision = $_POST['p_metodoPagoComision'];
        $p_correoDestinoComision = (count($_POST['p_correoDestinoComision']) > 0) ? listarCorreos($_POST['p_correoDestinoComision']) : '';
        $p_periodoFacturacionComision = $_POST['p_periodoFacturacionComision'];
        $p_diasLiquidaFacturaComision = ($_POST['p_diasLiquidaFacturaComision'] == '') ? 0 : $_POST['p_diasLiquidaFacturaComision'];

        $p_cfdiTransferencia = $_POST['p_cfdiTransferencia'];
        $p_claveProductoServicioTransferencia = $_POST['p_claveProductoServicioTransferencia'];
        $p_unidadTransferencia = $_POST['p_unidadTransferencia'];
        $p_formaPagoTransferencia = $_POST['p_formaPagoTransferencia'];
        $p_metodoPagoTransferencia = $_POST['p_metodoPagoTransferencia'];
        $p_correoDestinoTransferencia = (count($_POST['p_correoDestinoTransferencia']) > 0) ? listarCorreos($_POST['p_correoDestinoTransferencia']) : '';
        $p_periodoFacturacionTransferencia = $_POST['p_periodoFacturacionTransferencia'];
        $p_diasLiquidaFacturaTransferencia = ($_POST['p_diasLiquiquidaFacturaTransferencia'] == '') ? 0 : $_POST['p_diasLiquiquidaFacturaTransferencia'];

        $query = "CALL `redefectiva`.`sp_update_datos_facturacion_proveedor`(
		'$p_proveedor',
		'$p_nIva',
		$p_nFacturaComision,
		'$p_nFacturaTransferencia',
		'$p_cfdiComision',
        '$p_claveProductoServicioComision',
        '$p_unidadComision', 
        '$p_formaPagoComision', 
        '$p_metodoPagoComision', 
        '$p_correoDestinoComision', 
        '$p_periodoFacturacionComision',
		'$p_diasLiquidaFacturaComision',
		'$p_cfdiTransferencia', 
        '$p_claveProductoServicioTransferencia', 
        '$p_unidadTransferencia',
        '$p_formaPagoTransferencia', 
        '$p_metodoPagoTransferencia', 
        '$p_correoDestinoTransferencia', 
        '$p_periodoFacturacionTransferencia', 
		'$p_diasLiquidaFacturaTransferencia'
	);";

        $resultado = $WBD->query($query);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos["code"] = $row["nCodigo"];
                $datos["msg"] = $row["sMensaje"];
            }
        }

        $datos["facturacion"] = obtenerFacturacion($p_proveedor);

        print json_encode($datos);
        break;
    case 50:
        $p_proveedor     = $_POST['p_proveedor'];
        $p_nombre         = $_POST['p_nombre'];

        include($_SERVER['DOCUMENT_ROOT'] . "/inc/lib/phpmailer/class.phpmailer.php");
        include($_SERVER['DOCUMENT_ROOT'] . "/_Proveedores/proveedor/Afiliacion/plantillaCorreo.php");

        $facebook = 'https://www.facebook.com/red.efectiva';
        $twitter = 'https://twitter.com/redefectiva';
        $subject = "Autorizar nuevo proveedor {$p_nombre}";
        $correos = $usuarios_afiliacion_proveedores['correos_revision'];

        $oMailHandler = new Mail();
        $oMailHandler->setNAutorizador("");
        $oMailHandler->setSIp("");
        $oMailHandler->setOLog($oLog);
        $oMailHandler->setORdb($oRdb);
        $oMailHandler->setSSistema("DEF");
        $oMailHandler->setSFrom("envios@redefectiva.com");
        $oMailHandler->setSName("Red Efectiva");
        $oMailHandler->setOMail();
        $oMailHandler->setMail();

        $oMailHandler->oMail->SMTPDebug = 0;
        // $oMailHandler->oMail->Port = $N_SMTP_PORT;
        $oMailHandler->oMail->Debugoutput = 'var_dump';
        $oMailHandler->oMail->AddAddress($correos);
        $oMailHandler->oMail->addReplyTo('envios@redefectiva.com', 'Sistemas');
        $oMailHandler->oMail->CharSet = 'UTF-8';
        $oMailHandler->oMail->Subject = $subject;
        $oMailHandler->oMail->isHTML(true);
        //$oMailHandler->oMail->AddEmbeddedImage('../inc/img/edv_logo_email.png', 'logo_envios');
        $oMailHandler->oMail->Body = $cuerpo;

        $q = "CALL `redefectiva`.`sp_update_secciones_proveedor`($p_proveedor, 'bRevision', 1);";
        $r = $WBD->query($q);

        if ($oMailHandler->oMail->Send()) {
            $datos = array(
                "nCodigo"            => 0,
                "bExito"            => true,
                "sMensaje"            => "Email enviado exitosamente.",
                "secciones"            => secciones($p_proveedor)
            );
        } else {
            $datos = array(
                "nCodigo"            => 500,
                "bExito"            => false,
                "sMensaje"            => "No fue posible enviar el Email.",
                "sMensajeDetallado"    => $oMailHandler->oMail->ErrorInfo
            );
        }
        $oMailHandler->oMail->__destruct();

        print json_encode($datos);
        break;
    case 51:
        $p_proveedor     = $_POST['p_proveedor'];
        $p_status         = "0";
        $query = "CALL `redefectiva`.`sp_cambia_estatus_proveedor`('$p_proveedor', '$p_status');";

        $resultado = $WBD->query($query);

        if (!($resultado)) {
            $datos["code"] = "99";
            $datos["msg"] = "Error al generar el proceso";
        } else {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $datos["code"] = $row["ErrorCode"];

                if ($datos["code"] == "0") {
                    $datos["msg"] = "Proveedor activado exitosamente";
                    $q = "CALL `redefectiva`.`sp_update_secciones_proveedor`($p_proveedor, 'bRevision', 2);";
                    $r = $WBD->query($q);
                } else {
                    $datos["msg"] = "No se puedo activar al Proveedor.";
                }
            }
        }

        print json_encode($datos);
        break;
    case 52:
        $p_proveedor             = $_POST['p_proveedor'];
        $p_rfc             = $_POST["p_rfc"];
        $bancos            = $_POST['p_lineasMatriz'];

        $datos = guardarDatosBancarios($p_proveedor, $bancos, $p_rfc);

        $datos["bancos"] = obtenerDatosBancarios($p_proveedor);
        $datos["repre"] = obtenerRepresentateLegal($p_proveedor);
        print json_encode($datos);
        break;
    case 53:
        $p_proveedor         = $_POST['p_proveedor'];
        $p_idCuentaBanco        = $_POST['p_idCuentaBanco'];

        $datos = borrarDatosBancarios($p_proveedor, $p_idCuentaBanco);

        $datos["bancos"] = obtenerDatosBancarios($p_proveedor);
        $datos["repre"] = obtenerRepresentateLegal($p_proveedor);
        print json_encode($datos);
        break;
    case 54:
        $datos["giros"] = obtenerGiro();
        print json_encode($datos);
        break;
    default:
        # code...
        break;
}
