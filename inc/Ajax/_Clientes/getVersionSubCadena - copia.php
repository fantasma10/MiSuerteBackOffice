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
						$idVersion = $row[0];
					} else {
						$idVersion = NULL;
					}	
				} else {
					$idVersion = NULL;
				}
			} else {
				$idVersion = NULL;
			}
		} else if ( $tiposubcadena == 0 ) {
			$sql = "CALL `redefectiva`.`SP_GET_VERSIONSUBCADENA`($idsubcadena);";
			$result = $RBD->SP($sql);
			if ( $RBD->error() == "" ) {
				if ( $result->num_rows > 0 ) {
					$row = $result->fetch_array();
					if ( isset($row[0]) && $row[0] > 0 && $row[0] != "" ) {
						$idVersion = $row[0];
					} else {
						$idVersion = NULL;
					}	
				} else {
					$idVersion = NULL;
				}
			} else {
				$idVersion = NULL;
			}			
		}
		
		$resultado = "";
		$resultado .= "<table class=\"tablanueva\">";
		$resultado .= "<thead class=\"theadtablita\">";
		//$resultado .= "<tbody>";
		$resultado .= "<tr>";
		$resultado .= "<th class=\"theadtablita\">Versi&oacute;n</th>";		
				
		if ( isset($idVersion) && $idVersion != '' ) {
			$sql = "CALL `redefectiva`.`SP_LOAD_FAMILIAS`();";
			$result = $RBD->SP($sql);
			if ( $RBD->error() == '' ) {
				if ( $result->num_rows > 0 ) {
					$familias = array();
					$index = 0;
					while ( $familia = $result->fetch_array() ) {
						$familias[$index] = array( "id" => $familia[0], "nombre" => $familia[1] );
						$resultado .= "<th class=\"theadtablita\">{$familias[$index]['nombre']}</th>";
						$index++;
					}
				}
			}
			$resultado .= "</tr>";			
			$resultado .= "</thead>";
			$sql = "CALL `redefectiva`.`SP_LOAD_FAMILIASDEVERSIONES`();";
			$result = $RBD->SP($sql);
			if ( $RBD->error() == '' ) {
				if ( $result->num_rows > 0 ) {
					$versionesConProductos = array();
					$versionesConProductosDetalle = array();
					$index = 0;
					while ( $version = $result->fetch_array() ) {
						$versionesConProductos[$index] = $version[0];
						$versionesConProductosDetalle[$index] = array( "idVersion" => $version[0], "idFamilia" => $version[1], "familia" => $version[2] );
						$index++;
					}
				}
			}		

			$sql = "CALL `redefectiva`.`SP_LOAD_FAMILIASDEVERSION`($idVersion);";
			$result = $RBD->SP($sql);
			if ( $RBD->error() == '' ) {
				if ( $result->num_rows > 0 ) {
					$familiasDeVersion = array();
					$index = 0;
					while ( $familia = $result->fetch_array() ) {
						$familiasDeVersion[$index] = $familia[1];
						$index++;
					}
				}
			}
			
			$sql = "CALL `redefectiva`.`SP_LOAD_VERSIONES`();";
			$result = $RBD->SP($sql);
			if ( $RBD->error() == '' ) {
				if ( $result->num_rows > 0 ) {
					$versiones = array();
					$index = 0;
					$versionYaEstaSeleccionada = false;
					while ( $version = $result->fetch_array() ) {
						$versiones[$index] = array( "id" => $version[0], "nombre" => $version[1] );
						if ( $idVersion == $versiones[$index]["id"] ) {
							$resultado .= "<tr>";
							$resultado .= "<td class=\"tdtablita\">";
							$resultado .= " &nbsp;";
							$resultado .= "<label for=\"rdbVersion-{$versiones[$index]['id']}\">{$versiones[$index]['nombre']}</label>";
							$resultado .= "</td>";
							if ( $idVersion == $versiones[$index]["id"] ) {
								for ( $index1 = 0; $index1 < count($familias); $index1++ ) {
									$flag = true;
									for ( $index2 = 0; $index2 < count($versionesConProductosDetalle); $index2++ ) {
										if ( $versiones[$index]["id"] == $versionesConProductosDetalle[$index2]["idVersion"]
										&& $familias[$index1]["id"] == $versionesConProductosDetalle[$index2]["idFamilia"] ) {									
											switch ( $familias[$index1]["id"] ) {
												case 1:
													$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/telefonia.png\"></td>";
												break;
												case 2:
													$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/servicios.png\"></td>";
												break;
												case 3:
													$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/banco.png\"></td>";
												break;
												case 4:
													$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/transporte.png\"></td>";
												break;
												case 5:
													$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/remesas.png\"></td>";
												break;
												case 6:
													$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/seguros.png\"></td>";
												break;
												case 7:
													$resultado .= "<td class=\"tdtablita\" style=\"text-align: center;\"><img src=\"../../img/juegos.png\"></td>";
												break;
												default:
													$resultado .= "<td class=\"tdtablita\"></td>";
												break;
											}
											$flag = false;
										}								
									}
									if ( $flag ) {
										$resultado .= "<td class=\"tdtablita\"></td>";
									}									
								}
							}
							$resultado .= "</tr>";
						}
						$index++;
					}
				}		
			}
			$resultado .= "</tbody>";
			$resultado .= "</table>";
			$resultado .= "<input type=\"hidden\" id=\"versionID\" value=\"$idVersion\" />";
			echo $resultado;
		} else {
			echo "La Sub Cadena no tiene una versi&oacute;n asignada.<br /><br />";
		}
	}
?>
