<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

if(isset($_FILES["filename"]["name"])){
	$i = 0;
	move_uploaded_file ($_FILES ['filename']['tmp_name'], "../../../tmp/".$_FILES ['filename']['name']); 
	$fp = fopen ("../../../tmp/". $_FILES['filename']['name'] , "r" );
	while (( $data = fgetcsv ( $fp , 1000 , "," )) !== FALSE ){
		$tcorreo = explode("@",$data[1]);
		if($tcorreo[1] == "redefectiva.com"){
			$sql = "SELECT idusuario FROM `data_acceso`.`in_usuarioad` WHERE `correo` = '".$data[1]."';";
			$res = null;
			$res = $RBD->query($sql);
			if(mysqli_num_rows($res) == 0){
				$sql = "INSERT INTO `data_acceso`.`in_usuarioad` (correo,idPerfilSAIRE,nombreUsuario,paternoUsuario,maternoUsuario,idEstatusUsuario,fecMovUsuario,idEmpleado) values('".$data[1]."',2,'".$data[3]."','".$data[4]."','".$data[5]."',0,NOW(),".$_SESSION['idU'].");";
				$RBD->query($sql);
				$i++;
			}
		}else{
			//lista de usuarios no cargados
		}
	}
	fclose ( $fp ); 
}
if($RBD->error() == ''){
	if($i == 0)
		echo "<span style='color:red'>No se pudieron cargar los usuarios!</span>";
	else
		echo "<span style='color:red'>Se cargaron ".$i." usuarios con exito!</span>";
}else{
	echo "<span style='color:red'>No se pudieron cargar los usuarios</span>";
}
?>