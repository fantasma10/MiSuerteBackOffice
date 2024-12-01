<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");


	$idCadena		= (!empty($_POST['idCadena']))? $_POST['idCadena'] : 0;
	$idSubCadena	= (!empty($_POST['idSubCadena']))? $_POST['idSubCadena'] : -1;
	$idCorresponsal	= (!empty($_POST['idCorresponsal']))? $_POST['idCorresponsal'] : -1;

	//echo "CALL `prealta`.`SP_GET_PRECOMISIONES`($idCadena, $idSubCadena, $idCorresponsal)";
	$sql = $RBD->query("CALL `prealta`.`SP_GET_PRECOMISIONES`($idCadena, $idSubCadena, $idCorresponsal)");

	if(!$RBD->error()){
		if(mysqli_num_rows($sql) > 0){

			$subfamilia = "";
			$cont = 0;
			while($res = mysqli_fetch_assoc($sql)){
				
				if($res["descSubFamilia"] != $subfamilia){
					if($cont > 0){
						echo '</tbody>
							</table>';
					}
					echo '<div class="bread">';
					echo $res['descFamilia'].' <i class="fa fa-play"></i>&nbsp; '.$res['descSubFamilia'].' <i class="fa fa-play"></i><br>';
					echo '</div>';
					echo '<table class="minicomision">
						<thead>
							<th>Emisor</th>
							<th>Producto</th>
							<th>Cliente</th>
							<th>Corresponsal</th>
							<th>Especial</th>
							<th>Máximo</th>
							<th>Mínimo</th>
							<th class="miniactions">Permiso</th>
							<th class="miniactions">Editar</th>
							<th class="miniactions">Eliminar</th>
						</thead>
						<tbody>';
				}
				
				switch($res['idTipoPermiso']){
					case '0':
						$tipoPermiso = '<i class="fa fa-check"></i>';
					break;
					case '1':
						$tipoPermiso = '';
					break;
				}
				$idPermiso = $res['idPermiso'];

				

				$lblCliente	= (!empty($res['impComCliente']) AND $res['impComCliente'] > 0)? "\$".number_format($res['impComCliente'], 2) : "";
				$middleC	= (!empty($lblCliente))? " / " : "";
				$lblCliente	.= (!empty($res['perComCliente']) AND $res['perComCliente'] > 0)? $middleC.number_format($res['perComCliente']*100, 3)."%" : "";

				$lblCorresponsal	= (!empty($res['impComCorresponsal']) AND $res['impComCorresponsal'] > 0)? "\$".number_format($res['impComCorresponsal'], 2) : "";
				$middleCo			= (!empty($lblCorresponsal))? " / " : "";
				$lblCorresponsal	.= (!empty($res['perComCorresponsal']) AND $res['perComCorresponsal'] > 0)? $middleCo.number_format($res['perComCorresponsal']*100, 3)."%" : "";

				$lblEspecial	= (!empty($res['impComEspecial']) AND $res['impComEspecial'] > 0)? "\$".number_format($res['impComEspecial'], 2) : "";
				$middleE		= (!empty($lblEspecial))? " / " : "";
				$lblEspecial	.= (!empty($res['perComEspecial']) AND $res['perComEspecial'] > 0)? $middleE.number_format($res['perComEspecial']*100, 3)."%" : "";

				echo "<tr>";
					echo "<td>".$res['descEmisor']."</td>";
					echo "<td>".$res['descProducto']."</td>";
					echo "<td>".$lblCliente."</td>";
					echo "<td>".$lblCorresponsal."</td>";
					echo "<td>".$lblEspecial."</td>";
					echo "<td>".$res['impMaxPermiso']."</td>";
					echo "<td>".$res['impMinPermiso']."</td>";
					echo "<td>".$tipoPermiso."</td>";
					echo "<td><a href=\"#\" onclick='editarPermisos(".$idPermiso.")'><i class=\"fa fa-pencil\"></i></a></td>";
					echo "<td><a href=\"#\" onclick='eliminarPermisos(".$idPermiso.")'><i class=\"fa fa-times\"></i></a></td>";
				echo "</tr>";

				$subfamilia = $res['descSubFamilia'];
				$cont++;
			}
			
		}
		else{
			echo "";
		}
	}
	else{

	}

?>