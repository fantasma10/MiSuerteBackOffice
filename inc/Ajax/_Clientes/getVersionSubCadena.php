<?php
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");
	include("../../obj/XMLPreSubCadena.php");
	
	$idcadena = (isset($_POST['cadenaID']))? $_POST['cadenaID'] :'';
	$idsubcadena = (isset($_POST['subcadenaID']))? $_POST['subcadenaID'] :'';
	$tiposubcadena = (isset($_POST['tiposubcadena']))? $_POST['tiposubcadena'] :'';
	
	if ( $idcadena != '' && $idsubcadena != '' ) {
		if ( $tiposubcadena == 1 ) {
			$sql = "CALL `prealta`.`SP_GET_VERSIONPRESUBCADENA`($idsubcadena);";
			$result = $RBD->SP($sql);
			if ( $RBD->error() == "" ) {
				if ( $result->num_rows > 0 ) {
					$row = $result->fetch_array();
					if ( isset($row[0]) && $row[0] > 0 && $row[0] != "" ) {
						$idVersionSubCadena = $row[0];
					} else {
						$idVersionSubCadena = NULL;
					}	
				} else {
					$idVersionSubCadena = NULL;
				}
			} else {
				$idVersionSubCadena = NULL;
			}
		} else if ( $tiposubcadena == 0 ) {
			$sql = "CALL `redefectiva`.`SP_GET_VERSIONSUBCADENA`($idsubcadena);";
			$result = $RBD->SP($sql);
			if ( $RBD->error() == "" ) {
				if ( $result->num_rows > 0 ) {
					$row = $result->fetch_array();
					if ( isset($row[0]) && $row[0] > 0 && $row[0] != "" ) {
						$idVersionSubCadena = $row[0];
					} else {
						$idVersionSubCadena = NULL;
					}	
				} else {
					$idVersionSubCadena = NULL;
				}
			} else {
				$idVersionSubCadena = NULL;
			}			
		}
		
		if ( isset($idVersionSubCadena) && $idVersionSubCadena ) {
		$resultado = "";								
		$sql = "CALL `redefectiva`.`SP_GET_VERSIONES`($idcadena);";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( mysqli_num_rows($result) > 0 ) {
				$resultado = "<table class=\"tablanueva\">";
				$resultado .= "<thead class=\"theadtablita\">";
				$resultado .= "<tr>";
				$totalFamilias = 0;
				while ( $field = mysqli_fetch_field($result) ) {
					if ( $field->name != "idVersion" && $field->name != "idCadena" ) {
						$resultado .= "<th class=\"theadtablita\">$field->name</th>";
						if ( $field->name != "Version" && $field->name != "idCadena" ) {
							$totalFamilias++;
						}
					}
				}
				$resultado .= "</tr>";
				$resultado .= "</thead>";
				$resultado .= "<tbody>";
				$versiones = array();
				while ( $row = mysqli_fetch_array($result, MYSQLI_NUM) ) {
					$versiones[] = $row;
				}
				for ( $i = 0; $i < count($versiones); $i++ ) {
					$idVersion = $versiones[$i][0];
					if ( $idVersion == $idVersionSubCadena  ) {
						if ( isset($idVersionSubCadena) && $idVersionSubCadena != "" && $versionDeSubCadena == $versiones[$i][0] ) {
							$resultado .= "<tr>";
							$resultado .= "<td class=\"tdtablita\">";
							$resultado .= $versiones[$i][1];
							$resultado .= "</td>";
						} else {
							$resultado .= "<tr>";
							$resultado .= "<td class=\"tdtablita\">";
							$resultado .= $versiones[$i][1];
							$resultado .= "</td>";
						}
						for ( $j = 2; $j < count($versiones[0]); $j++ ) {
							$esEspecial = false;
							$piezas = explode(" ", $versiones[$i][$j]);
							$idFamilia = $piezas[0];
							if ( $piezas[1] == "E" ) {
								$esEspecial = true;
							}
							switch ( $idFamilia ) {
								case 1:
									$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/telefonia.png\">";
									if ( $esEspecial ) {
										$resultado .= "<span style=\"color: red;\">&nbsp;*G</span>";
									}
									$resultado .= "</td>";
								break;
								case 2:
									$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/servicios.png\">";
									if ( $esEspecial ) {
										$resultado .= "<span style=\"color: red;\">&nbsp;*G</span>";
									}
									$resultado .= "</td>";																		
								break;
								case 3:
									$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/banco.png\">";
									if ( $esEspecial ) {
										$resultado .= "<span style=\"color: red;\">&nbsp;*G</span>";
									}
									$resultado .= "</td>";																		
								break;
								case 4:
									$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/transporte.png\">";
									if ( $esEspecial ) {
										$resultado .= "<span style=\"color: red;\">&nbsp;*G</span>";
									}
									$resultado .= "</td>";																		
								break;
								case 5:
									$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/remesas.png\">";
									if ( $esEspecial ) {
										$resultado .= "<span style=\"color: red;\">&nbsp;*G</span>";
									}
									$resultado .= "</td>";																		
								break;
								case 6:
									$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/seguros.png\">";
									if ( $esEspecial ) {
										$resultado .= "<span style=\"color: red;\">&nbsp;*G</span>";
									}
									$resultado .= "</td>";																		
								break;
								case 7:
									$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/juegos.png\">";
									if ( $esEspecial ) {
										$resultado .= "<span style=\"color: red;\">&nbsp;*G</span>";
									}
									$resultado .= "</td>";																		
								break;
								default:
									$resultado .= "<td class=\"tdtablita\"></td>";
								break;
							}
						}
						$resultado .= "</tr>";
					}
				}
			}
		}		
		$resultado .= "</tbody>";
		$resultado .= "</table>";
		$resultado .= "<input type=\"hidden\" id=\"versionID\" value=\"$idVersionSubCadena\" />";
		echo $resultado;
		} else {
			echo "La Sub Cadena no tiene una versi&oacute;n asignada.<br /><br />";
		}
	}
?>
