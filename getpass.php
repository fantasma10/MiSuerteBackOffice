<?php
$texto = "ZHERNANDEZ|1234";

$texto_encriptado = hash('sha256', $texto);

$texto_encriptado;

echo var_export($texto_encriptado);