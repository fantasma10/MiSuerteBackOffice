
<?php
        
include ('../../../inc/config.inc.php');
$idsuc = $_POST['idsucur'];

        $sQuery = "CALL `afiliacion`.`SP_SUCURSAL_CARGARDATOS`('$idsuc');";
        $resultsuc = $WBD->query($sQuery);
        $suc  = mysqli_fetch_array($resultsuc);
       
        $idsuc              = $suc['nIdSucursal'];
        $idcte              = $suc['sRFC'];
        //$razonSocial = $suc['sRFC'];
        $NomSucursal        = $suc['sNombreSucursal'];
        $IdentifSucursal    = $suc['sIdentificadorSucursal'];
        $correo             = $suc['sEmail'];
        $telefono           = $suc['sTelefono'];
        $giro               = $suc['nIdGiro'];
        $nombre             = $suc['sNombre'];
        $paterno            = $suc['sPaterno'];
        $materno            = $suc['sMaterno'];
        $latitud            = $suc['nLatitud'];
        $longitud           = $suc['nLongitud'];
        $idpais             = $suc['nIdPais'];
        $calle              = $suc['sCalle'];
        $numExterno         = $suc['nNumExterno'];
        $numInterno         = $suc['sNumInterno'];
        $codigopostal       = $suc['nCodigoPostal'];
        $numColonia         = $suc['nNumColonia'];
        $numMunicipio       = $suc['nNumMunicipio'];
        $numEstado          = $suc['nIdEstado'];
        $nomEstado          = $suc['sNombreEstado'];
        $nomMunicipio       = $suc['sNombreMunicipio'];
        $nomColonia         = $suc['sNombreColonia'];
        $iddoc              = $suc['nIdDocDomicilio'];
        $accesos            = $suc['accesos'];
        $idestatus            = $suc['status'];
       


       $jsonss = json_encode(array(
           "idsuc"=>"$idsuc",
           "idcte"=>"$idcte",
           "nomsuc"=>"$NomSucursal",
           "identsuc"=>"$IdentifSucursal",
           "correo"=>"$correo",
           "telefono"=>"$telefono",
           "giro"=>"$giro",
           "nombre"=>"$nombre",
           "paterno"=>"$paterno",
           "materno"=>"$materno",
           "latitud"=>"$latitud",
           "longitud"=>"$longitud",
           "idpais"=>"$idpais",
           "calle"=>"$calle",
           "numext"=>"$numExterno",
           "numint"=>"$numInterno",
           "cp"=>"$codigopostal",
           "numcol"=>"$numColonia",
           "nummun"=>"$numMunicipio",
           "numedo"=>"$numEstado",
           "nomedo"=>"$nomEstado",
           "nommun"=>"$nomMunicipio",
           "nomcol"=>"$nomColonia",
           "iddoc"=>"$iddoc",
           "accessos"=>"$accesos",
           "idestatus"=>"$idestatus"
       )); 
            echo $jsonss;
        //mysqli_close($conn);

?>

