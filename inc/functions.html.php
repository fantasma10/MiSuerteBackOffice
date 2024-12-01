<?php
/**
 * Este archivo está pensado para ser reutilizado SOLO en archivos HTML
 *
 * Las funciones que se agreguen aquí NO DEBEN de depender de variables globales.
 * De ser necesario el uso de variables globales entonces pasarlas como parámetros a las funciones.
 */

function get_isset ($value, $default_value)
{
    if (isset($value)) {
        return $value;
    }

    return $default_value;
}

function get_not_empty_key ($array, $key, $defaultValue)
{
    if (!is_null($array) && array_key_exists($key, $array) && !empty($array[$key])) {
        return $array[$key];
    }

    return $defaultValue;
}

function get_not_empty ($value, $default_value)
{
    if (!empty($value)) {
        return $value;
    }

    return $default_value;
}

function get_numeric ($value, $default_value)
{
    if (is_numeric($value)) {
        return $value;
    }

    return $default_value;
}

function get_numeric_key ($array, $key, $defaultValue)
{
    if (!is_null($array) && array_key_exists($key, $array) && is_numeric($array[$key])) {
        return $array[$key];
    }

    return $defaultValue;
}

/***************************************************
 *  Funciones Específicas para la Aplicación
 ***************************************************/

function get_profile_id_from_session ($session) {
    return get_numeric_key($session, 'idPerfil', null);
}

function get_country_id_from_session ($session) {
    return get_numeric_key($session, 'idpais', -1);
}

function get_app_root_directory ($server)
{
    return get_not_empty_key($server, 'DOCUMENT_ROOT', null);
}

function get_url_from_server ($server) {
    $port = (int) get_not_empty_key($server, 'SERVER_PORT', 80);
    $host = get_not_empty_key($server, 'HTTP_HOST', null);
    return 'http' . ($port == 443 ? 's' : '') . '://' . $host;
}

?>
