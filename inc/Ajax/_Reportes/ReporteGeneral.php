<?php
	/*error_reporting(E_ALL);
	ini_set("display_errors", 1);*/

	include("../../config.inc.php");

	$descargarExcel = (!empty($_REQUEST["downloadExcel"]))? true : false;
	$fn = "utf8_encode";
	if($descargarExcel){
		header('Content-Description: File Transfer');
		header('Content-Type=application/x-msdownload');
		header('Content-disposition:attachment;filename=Reporte_General.xls');
		header("Pragma:no-cache");
		header("Set-Cookie: fileDownload=true; path=/");
		$RBD->query("SET NAMES utf8");
		$fn = "utf8_decode";
	}

	$idCad			= (!empty($_REQUEST["idCad"]))? $_REQUEST["idCad"] : 0;
	$idSubCad		= (!empty($_REQUEST["idSubCad"]))? $_REQUEST["idSubCad"] : 0;
	$idCorresponsal	= (!empty($_REQUEST["idCorresponsal"]))? $_REQUEST["idCorresponsal"] : 0;
	$idVersion		= (!empty($_REQUEST["idVersion"]))? $_REQUEST["idVersion"] : 0;
	$idProveedor	= (!empty($_REQUEST["idProveedor"]))? $_REQUEST["idProveedor"] : 0;
	$idEmisor		= (!empty($_REQUEST["idEmisor"]))? $_REQUEST["idEmisor"] : 0;
	$fini			= (!empty($_REQUEST["feini"]))? $_REQUEST["feini"] : date("Y-m-d");
	$ffin			= (!empty($_REQUEST["fefin"]))? $_REQUEST["fefin"] : date("Y-m-d");
	$ck_version		= (!empty($_REQUEST["ck_version"]))? $_REQUEST["ck_version"] : 0;
	$ck_direccion	= (!empty($_REQUEST["ck_direccion"]))? $_REQUEST["ck_direccion"] : 0;
	$ck_horario		= (!empty($_REQUEST["ck_horario"]))? $_REQUEST["ck_horario"] : 0;
	$ck_operaciones = (!empty($_REQUEST["ck_operaciones"]))? $_REQUEST["ck_operaciones"] : 0;
	$tipoOp			= (!empty($_REQUEST["tipoOp"]))? $_REQUEST["tipoOp"] : 0;
	$cant    = (isset($_REQUEST['cpag']))?$_REQUEST["cpag"]:20;

	$start  = (!empty($_REQUEST['actual']))?$_REQUEST["actual"]:0;
	$start = ($start != "undefined")? $start : 0;
	
	if($start > 0){
	    $start = $start * $cant - $cant;
	}

	$_POST["cant"] = $cant;
	$_POST["ac"] = $start;

	$qstr = "CALL redefectiva.SP_LOAD_REPORTE_GENERAL($idCad, $idSubCad, $idCorresponsal, $idVersion, $idProveedor, $idEmisor, '$fini', '$ffin', $ck_version, $ck_direccion, $ck_horario, $ck_operaciones, $tipoOp, $start, $cant)";
	
	$sql = $RBD->query($qstr);

	if(!$RBD->error()){
		if($RBD->num_rows($sql) > 0){

			$sqlcount = "CALL `redefectiva`.`SP_GET_FOUND_ROWS`();";

			$funcion = "showReporte";
			include("../actualpaginacion.php");	

			$showCad = true; $showSub = true; $showCor = true;

			if($tipoOp == 0 AND $ck_operaciones == 1){
				if($idCad == -1){
					$showCad = true;
					$showSub = false;
					$showCor = false;
				}
				if($idSubCad >= -1){
					$showCad = true;
					$showSub = true;
					$showCor = false;
				}
				if($idCorresponsal >= -1){
					$showCad = true;
					$showSub = true;
					$showCor = true;
				}
				if($idCad == -2){
					$showCad = false; $showSub = false; $showCor = false;
				}
			}

			if(!$descargarExcel){
				/*echo "<div style='padding:5px;'>
					<input type='checkbox' id='todoexcelgeneral'><label for='todoexcelgeneral'>Todo</label> <br/>
					<a href='#' id='linkDescargaExcel' class='liga_descarga_archivos'>Descargar Excel</a>
				</div>";*/
				/*echo "<div style='padding:5px;'>
					<div style='margin-top:3px; display:inline-block;'>
					<input type='checkbox' id='todoexcelgeneral'> <label for='todoexcelgeneral'>Todo</label>
					</div>
					<button id='linkDescargaExcel' class='btn btn-xs btn-info pull-left' style='margin-bottom:10px; margin-right:10px;'><i class='fa fa-file-excel-o'></i> Excel </button>
				</div>";*/
				echo "<div style='padding:5px;'>
					<button id='linkDescargaExcelActual' class='btn btn-xs btn-info pull-left' style='margin-bottom:10px; margin-right:10px;'><i class='fa fa-file-excel-o'></i> Excel - Actual </button>
					<button id='linkDescargaExcelTodo' class='btn btn-xs btn-info pull-left' style='margin-bottom:10px; margin-right:10px;'><i class='fa fa-file-excel-o'></i> Excel - Todo </button>
				</div>";							
			}
				echo "<table id='ordertabla' border='0' cellspacing='0' cellpadding='0' class='tablesorter tasktable'>";
				echo "<thead><tr>";
					if($showCad){
						echo "<th style='text-align:left;'>Id Cadena</th>";
						echo "<th style='text-align:left;'>Cadena</th>";
					}
					if($showSub){
						echo "<th style='text-align:left;'>Id SubCadena</th>";
						echo "<th style='text-align:left;'>SubCadena</th>";
					}
					if($showCor){
						echo "<th style='text-align:left;'>Id Corresponsal</th>";
						echo "<th style='text-align:left;'>Corresponsal</th>";
					}
					if($ck_version == 1){
						echo "<th style='text-align:left;'>Versi&oacute;n</th>";
					}
					if($ck_direccion == 1){
						echo "<th style='text-align:left;'>Direcci&oacute;n</th>";
					}
					if($ck_horario == 1){
						echo "<th style='text-align:left;'>Lunes</th>";
						echo "<th style='text-align:left;'>Martes</th>";
						echo "<th style='text-align:left;'>Mi&eacute;rcoles</th>";
						echo "<th style='text-align:left;'>Jueves</th>";
						echo "<th style='text-align:left;'>Viernes</th>";
						echo "<th style='text-align:left;'>S&aacute;bado</th>";
						echo "<th style='text-align:left;'>Domingo</th>";
					}
					/* Ver sumatoria de Operaciones */
					if($ck_operaciones == 1){
						echo "<th  style='text-align:right;'>Importe Operaci&oacute;n</th>";
						echo "<th  style='text-align:right;'>Comisi&oacute;n Corresponsal</th>";
						echo "<th  style='text-align:right;'>Comisi&oacute;n RE</th>";

						if($tipoOp == 1){//si es el detalle de las operaciones
							echo "<th  style='text-align:center;'>Fecha</th>";
							echo "<th  style='text-align:left;'>TranType</th>";
							echo "<th  style='text-align:left;'>Proveedor</th>";
							echo "<th  style='text-align:left;'>Emisor</th>";
						}
						if($tipoOp == 0 AND $idProveedor == -1){
							echo "<th  style='text-align:left;'>Proveedor</th>";	
						}
						if($tipoOp == 0 AND $idEmisor == -1){
							echo "<th  style='text-align:left;'>Emisor</th>";	
						}
					}
				echo "</tr></thead><tbody>";
			while($row = mysqli_fetch_assoc($sql)){
				echo "<tr>";

					if($showCad){
						echo "<td style='text-align:right;'>".$fn($row["idCadena"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["nombreCadena"])."</td>";
					}
					if($showSub){
						echo "<td style='text-align:right;'>".$fn($row["idSubCadena"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["nombreSubCadena"])."</td>";
					}
					if($showCor){
						echo "<td style='text-align:right;'>".$fn($row["idCorresponsal"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["nombreCorresponsal"])."</td>";
					}
					if($ck_version == 1){
						echo "<td style='text-align:left;'>".$fn($row["nombreVersion"])."</td>";
					}
					if($ck_direccion == 1){
						echo "<td style='text-align:left;'>".$fn($row["lblDireccion"])."</td>";
					}
					if($ck_horario == 1){
						echo "<td style='text-align:left;'>".$fn($row["horarioLunes"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["horarioMartes"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["horarioMiercoles"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["horarioJueves"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["horarioViernes"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["horarioSabado"])."</td>";
						echo "<td style='text-align:left;'>".$fn($row["horarioDomingo"])."</td>";
					}
					if($ck_operaciones == 1){
						echo "<td style='text-align:right;'>\$ ".number_format($row["valorOperacion"], 2)."</td>";
						echo "<td style='text-align:right;'>\$ ".number_format($row["totComCorresponsal"],2)."</td>";
						echo "<td style='text-align:right;'>\$ ".number_format($row["totComisionRE"],2)."</td>";
						/* si es el detalle */
						if($tipoOp == 1){
							echo "<td style='text-align:center;'>".$fn($row["fecAltaOperacion"])."</td>";
							echo "<td style='text-align:left;'>".$fn($row["descTranType"])."</td>";
							echo "<td style='text-align:left;'>".$fn($row["nombreProveedor"])."</td>";
							echo "<td style='text-align:left;'>".$fn($row["descEmisor"])."</td>";
						}
						if($tipoOp == 0 AND $idProveedor == -1){
							echo "<td style='text-align:left;'>".$fn($row["nombreProveedor"])."</td>";	
						}
						if($tipoOp == 0 AND $idEmisor == -1){
							echo "<td style='text-align:left;'>".$fn($row["descEmisor"])."</td>";	
						}
					}
				echo "</tr>";
			}
			echo "</tbody></table>";
			if(!$descargarExcel){
				include("../paginanavegacion.php");
			}
		}else{
			echo "<h2>No se encontraron resultados</h2>";
		}
	}
	else{
		echo "Error : ".$RBD->error();
	}

?>