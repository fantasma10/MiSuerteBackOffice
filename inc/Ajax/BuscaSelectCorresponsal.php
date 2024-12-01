<?php
include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");

$band = true;
try{
//if(isset($_POST['al']) && isset($_POST['idcad']) && isset($_POST['idsubcad'])){
$cad		= (isset($_POST['idcad']))?$_POST['idcad']:'';
$subcad		= (isset($_POST['idsubcad']))?$_POST['idsubcad']:'';
if(isset($_POST['idcad']) && isset($_POST['idsubcad'])){

	$desabilitar = "";
	$seleccionar = "";
	if($cad < 0 || $subcad < 0)
		$desabilitar = "disabled='disabled'";
	if($cad == 0 || $subcad <= 0)
		$seleccionar = "selected='selected'";

$seccion 		= (isset($_POST['seccion']))?$_POST['seccion']:'';
$res 			= null;
$funcion2 		= (isset($_POST['funcion2']))?"window.setTimeout(\"".$_POST['funcion2']."\",150);":"";
$funcion3 		= (isset($_POST['funcion3']))?"window.setTimeout(\"".$_POST['funcion3']."\",200)":"";


        //$res = $RBD->query("SELECT `idCorresponsal`,`nombreCorresponsal` FROM `redefectiva`.`dat_corresponsal` where idCadena = ".$cad." and idSubCadena = ".$subcad." ORDER BY `nombreCorresponsal`;");
        $res = $RBD->query("call SP_LOAD_CORRESPONSALES($cad, $subcad)");
        $d = "";
       if($RBD->error() == '')
		{
				$d = "<select $desabilitar id='ddlCorresponsal' class='textfield' onchange='$funcion2; $funcion3;'><option value='-3'>Seleccione un corresponsal</option><option value='-1' selected='selected'>General</option>";
            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[0]' onclick='$funcion2; $funcion3;'>$r[1]</option>";
            }
            $d.="</select>";
            echo utf8_encode($d);
        }else{
            //echo "<select id='ddlCorresponsal' class='textfield'><option value='-1'>Seleccione un corresponsal -3</option></select>";
			echo $RBD->error();
        }
		$band = false;
		
		
}elseif(isset($_POST['idcad']) && isset($_POST['idsubcad']) && $band == true){
		$res = null;
        $res = $RBD->query("SELECT `idCorresponsal`,`nombreCorresponsal` FROM `redefectiva`.`dat_corresponsal` where idCadena = ".$_POST['idcad']." and idSubCadena = ".$_POST['idsubcad']." ORDER BY `nombreCorresponsal`;");
        $d = "";
        if($res != null){
            $d = "<select $desabilitar id='ddlCorresponsal' class='textfield' onchange='$funcion2; $funcion3;'><option value='-3'>Seleccione un corresponsal</option><option value='-2' onclick='$funcion2; $funcion3;'>Todos</option>";
			if($seccion != "Operadores")
				$d.="<option value='-1'>General</option>";
            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[0]' onclick='$funcion2'>$r[1]</option>";
            }
            $d.="</select>";
            echo utf8_encode($d);
        }else{
            echo "<select id='ddlCorresponsal' class='textfield'><option value='-3'>Seleccione un </option></select>";
        }
}else{ echo "<select id='ddlCorresponsal' class='textfield'><option value='-3'>Seleccione </option></select>";}
}catch(Exception $e){echo $e->getMessage();}
?>