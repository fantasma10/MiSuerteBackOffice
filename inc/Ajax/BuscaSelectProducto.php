<?php
include("../config.inc.php");
include("../session.ajax.inc.php");

$idProvee = (isset($_POST['idproveedor']))?$_POST['idproveedor']:'';

$AND = '';
if($idProvee > -2)
	$AND.= " AND `idProveedor` = $idProvee ";

if($idProvee != ''){
	
	if ( $idProvee > -2 ) {
		$sql = "SELECT PRODUCTO.`idProducto`, PRODUCTO.`descProducto`
				FROM `redefectiva`.`ops_ruta` AS RUTA
				INNER JOIN `redefectiva`.`dat_producto` AS PRODUCTO
				ON PRODUCTO.`idProducto` = RUTA.`idProducto`
				AND PRODUCTO.`idEstatusProducto` = 0
				WHERE IF( $idProvee > -1, RUTA.`idProveedor` = $idProvee, 1 )
				AND RUTA.`idEstatusRuta` = 0;";
		$res = $RBD->query($sql);		
	} else {
		$sql = "CALL `redefectiva`.`SP_LOAD_PRODUCTOS`();";
		$res = $RBD->SP($sql);
	}
    
    if(mysqli_num_rows($res) > 0){
        $d .= "<select id='ddlProducto' class='form-control m-bot15'>";
		$d .= "<option value='-3'>Seleccione Un Producto</option>";
		$d .= "<option value='-2' selected='selected'>Todos</option>";
		while(list($id,$desc) = mysqli_fetch_array($res)){
            $d.="<option value='$id'>$id $desc</option>";
        }
        $d.="</select>";
        echo $d;
    }else{
		$d .= "<select id='ddlProducto' class='form-control m-bot15'>";
		$d .= "<option value='-3'>Seleccione un Producto</option>";
		$d .= "</select>";
		echo $d;
    }
}

?>