 
<?php
 
//include ('../../../inc/config.inc.php');
$sQuery = "CALL afiliacion.SP_SUCURSAL_GUARDAR('$idsucursal', '$rfcsss', '$idstatus' , '$idgiro', '$idusuario', '$iddireccion', '$nomsucursal', '$identificador', '$descripcion', '$telefono' , '$correo' ,'$nombress' ,'$paternoss', '$maternoss' ,'$idcompdom');";
$resultsucursal = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultsucursal);
 
               
$recordsaffected = $DATS['rowss'];


          $json = json_encode(array(
              "recs"=>"$recordsaffected" ));   


//echo $json;

//printf("Error: %s\n", mysqli_error($conn));
//mysqli_close($conn);
?>
 