<?php
$clientes = array();
$idEstatus = 0;

function obtenerClientes ($oRdb, $idEstatus) {
    $_clientes = array();

    $oRdb->setSDatabase('redefectiva');
    $oRdb->setSStoredProcedure('sp_select_clientes_autocomplete');
    $result = $oRdb->execute();

    if ($result['nCodigo'] == 0) {
        $rows = $oRdb->fetchAll();

        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $_clientes[] = array(
                    'nIdCliente' => $row['nIdCliente'],
                    'sNombreCliente' => utf8_encode($row['sNombreCliente']),
                    'sRFC' => $row['sRFC']
                );
            }
        }
    }

    return $_clientes;
}


$clientes = obtenerClientes($oRdb, $idEstatus);