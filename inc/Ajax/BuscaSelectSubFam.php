<?php
include("../config.inc.php");
include("../session.ajax.inc.php");

$idfamilia = (isset($_POST['idfamilia']))?$_POST['idfamilia']:'';

$AND = '';
if($idfamilia > -2)
	$AND.= " AND `idFamilia` = $idfamilia ";

if($idfamilia != ''){
    //$sql = "SELECT `idSubFamilia`,`descSubFamilia` FROM `redefectiva`.`cat_subfamilia` WHERE `idEstatusSubFamilia` = 0 $AND ORDER BY `descSubFamilia`";
    $RBD->query("SET NAMES utf8");
    $sql = "CALL redefectiva.SP_GET_SUBFAMILIAS($idfamilia);";
    $res = $RBD->query($sql);
    if(mysqli_num_rows($res) > 0){
        $d = "<select id='ddlSubFam' class='form-control m-bot15'><option value='-3'>Seleccione Una SubFamilia</option><option value='-2' selected='selected'>Todos</option>";
        while(list($idF,$descF) = mysqli_fetch_array($res)){
            $d.="<option value='$idF'>".$descF."</option>";
        }
        $d.="</select>";
        echo $d;
    }else{
        //echo "No se encontraron resultados";
		$d = "<select name='ddlSubFam' id='ddlSubFam' onChange='' class='form-control m-bot15'>";
		$d .= "<option value='-2' selected='selected'>Todos</option>";
		$sql = "CALL `redefectiva`.`SP_LOAD_SUBFAMILIAS`();";
		$result = $RBD->SP($sql);
		while($row = mysqli_fetch_row($result)){
			$d .= '<option value="'.$row[0].'">'.codificarUTF8($row[2]).'</option>';
		}
		mysqli_free_result($result);
		echo $d;
    }
}

?>