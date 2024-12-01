<?php
        
include ('../../../inc/config.inc.php');


$familia= $_POST['familia'];
$subfamila= $_POST['subfamila'];
$emisor= $_POST['emisor'];
$descript= utf8_encode($_POST['descript']);
$abrev = utf8_encode($_POST['abrev']);
$inivigencia= $_POST['inivigencia'];
$finvigencia= $_POST['finvigencia'];
$idflujo= $_POST['idflujo'];
$max= $_POST['max'];
$min= $_POST['min'];
$porcomprod= $_POST['porcomprod'];
$impcomprod= $_POST['impcomprod'];
$porcomcte= $_POST['porcomcte'];
$impporcte= $_POST['impporcte'];
$porcomusr= $_POST['porcomusr'];
$impcomusr= $_POST['impcomusr'];
$servicios= $_POST['servicios'];
$usr = $_POST['usr'];


/*echo '<br/>';
 echo $familia;
  echo '<br/>';
echo $subfamila;
  echo '<br/>';;
 echo $emisor;
  echo '<br/>';
 echo $descript;
  echo '<br/>';
 echo $inivigencia;
  echo '<br/>';
 echo $finvigencia;
  echo '<br/>';
 echo $idflujo;
 echo '<br/>';
 echo $max;
 echo '<br/>';
 echo $min;
 echo '<br/>';
 echo $porcomprod;
 echo '<br/>';
 echo $impcomprod;
 echo '<br/>';
 echo $porcomcte;
 echo '<br/>';
 echo $impporcte;
 echo '<br/>';
 echo $impcomusr;
echo '<br/>';
 echo $servicios;
echo '<br/>';*/



	$sQuery = "CALL `redefectiva`.`SP_CREAR_PRODUCTOS`('$familia','$subfamila','$emisor','$descript','$abrev','$inivigencia','$finvigencia','$idflujo','$max','$min','$porcomprod','$impcomprod','$porcomcte','$impporcte','$porcomusr','$impcomusr','$servicios','$usr');";

//echo $sQuery;
$result = $WBD->query( $sQuery );
$data  = mysqli_fetch_array($result);
  
$code =    $data['code'];
$msg =    $data['msg'];


echo json_encode(array("code"=>"$code","msg"=>"$msg"));

?>