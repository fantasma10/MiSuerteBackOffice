<?php
include("../../../inc/config.inc.php");
include("../../../inc/session.ajax.inc.php");

global $RBD;

$clientCP 	= (isset($_POST['Cp']))?$_POST['Cp']:(0);

$RES			= '';
$sql 			= "SELECT `idColonia`,`nombreColonia`  FROM `redefectiva`.`cat_colonia` WHERE `codigoColonia` =".$clientCP." GROUP BY `codigoColonia`;";
			
	$RESsql 	= $RBD->query($sql);	
	if($RESsql){
		
		if(mysqli_num_rows($RESsql)){
	
			$RES .= '<select name="ddlColonia" id="ddlColonia" class="textfield">';
			while(list($id,$nombre)= mysqli_fetch_row($RESsql)){
				$RES .= '<option value="'.$id.'" >'.$nombre.'</option>';
			}
			$RES .='</select>';
		}
	}
		
echo utf8_encode($RES);
			
?>