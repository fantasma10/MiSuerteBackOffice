<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");


$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];

$submenuTitulo		= "AFiliacion";
$subsubmenuTitulo	= "Nueva Cadena";
$tipoDePagina = "mixto";
$idOpcion = 307;

if (!desplegarPagina($idOpcion, $tipoDePagina)) {
	header("Location: $PATHRAIZ/error.php");
	exit();
}
$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
	$esEscritura = true;
}
$hoy = date("Y-m-d");
function acentos($word)
{
	return (!preg_match('!!u', $word)) ? utf8_encode($word) : $word;
}
$idemisores =  (isset($_POST['txtidemisor'])) ? $_POST['txtidemisor'] : 0;
$query = "call sp_select_giro()";
$resultado = $GLOBALS["RBD"]->query($query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--Favicon-->
	<link rel="shortcut icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
	<title>.::Mi Red::.Afiliacion de Cadena</title>

	<!-- Núcleo BOOTSTRAP -->
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/css/jquery.alerts.css" rel="stylesheet">
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />

	<style type="text/css">
		.inhabilitar {
			background-color: #d9534f !important;
			border-color: #d9534f !important;
			margin-left: 10px;
			color: #FFFFFF;
		}

		.habilitar {
			margin-left: 10px;
		}

		.hidden {
			display: none;
		}

		.alignRight {
			text-align: right;
		}

		/*input:invalid {
			border: 1px solid red;
		}

        select:invalid {
            border: solid 1px red;
        }

		input:valid {
			border: 1px solid green;
		}*/

		html {
			overflow: hidden;
		}

		.alert-success {
			width: 50%;
			padding: 20px;
			background-color: #26CA5B;
			/* Red */
			color: white;
			margin-bottom: 15px;
		}

		.alert-error {
			width: 50%;
			padding: 20px;
			background-color: #f44336;
			/* Red */
			color: white;
			margin-bottom: 15px;
		}

		/* The close button */
		.closebtn {
			margin-left: 15px;
			color: white;
			font-weight: bold;
			float: right;
			font-size: 22px;
			line-height: 20px;
			cursor: pointer;
			transition: 0.3s;
		}

		/* When moving the mouse over the close button */
		.closebtn:hover {
			color: black;
		}

        .loading-input {
            background: white url('<?php echo $PATHRAIZ;?>/img/loadAJAX.gif') right center no-repeat;
        }
	</style>
</head>

<body>
	<!--Include Cuerpo, Contenedor y Cabecera-->
	<?php include($PATH_PRINCIPAL . "/inc/cabecera2.php"); ?>
	<!--Inicio del Menú Vertical-->
	<!--Función "Include" del Menú-->
	<?php include($PATH_PRINCIPAL . "/inc/menu.php"); ?>
	<!--Final del Menú Vertical-->
	<!--Contenido Principal del Sitio-->

	<section id="main-content">
		<section class="wrapper site-min-height">
			<div class="panel" style="position: relative">
				<!--Panel Principal-->
				<div class="panelrgb">
					<div class="titulorgb-prealta">
						<span><i class="fa fa-user"></i></span>
						<h3>Afiliación</h3>
						<span class="rev-combo pull-right">Afiliación de Cadena</span>
					</div>
					<hr>
				</div>
				<form id="formInsertCadena" name="formInsertCadena">
					<div class="container">
                        <div class="row align-items-start">
                            <div class="col-xs-10 text-right"><span><small>*: campos requeridos</small></span></div>
                        </div>
						<div class="row align-items-start">
							<div class="col-xs-7 ps-5">
								<div class="mb-3">
									<label for="nombreCadena" class="form-label">Ingrese el nombre de la Cadena: *</label>
									<input type="text" class="form-control" name="nombreCadena" id="nombreCadena" maxlength="100" required autocomplete="off" placeholder="Ingrese el nombre de la Cadena">
								</div>
							</div>
							<div class="col-xs-3">
								<label for="selectGiro" class="form-label">Seleccione el Giro: *</label>
								<select name="selectGiro" required id="selectGiro" class="form-control" disabled>
                                    <option disabled value="0" selected>Seleccione</option>
									<?php while ($row = mysqli_fetch_array($resultado, MYSQL_NUM)) {
										echo "<option value=" . $row[0] . ">" . acentos($row[1]) . "</option>";
									}
									?>
								</select>
							</div>
						</div>
						<br>
						<div class="row align-items-start">
							<div class="col-xs-5">
								<div class="mb-3">
									<label for="numeroTelefono" class="form-label">Ingrese el numero de telefono:</label>
									<input type="text" class="form-control" name="numeroTelefono" id="numeroTelefono" placeholder="+521234567890" pattern="(([\(\+]*[0-9]{2,3}|[0-9]{4}|[0-9]{2,3}[\)]*)?[ -]*(([0-9]{3,4})?[ -]*([0-9]{3,4})?[ -]*([0-9]{0,4})))" maxlength="15" minlength="10" disabled>
								</div>
							</div>
							<div class="col-xs-5">
								<div class="mb-3">
									<label for="email" class="form-label">Ingrese el correo electronico:</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="jhon@mail.com" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" maxlength="100" disabled>
								</div>
							</div>
						</div>
						<div class="row" style="width: 100%">
							<div class="col-sm-1"></div>
							<div class="col-sm-3 pull-right">
								<div class="mb-3">
									<button type="submit" id="saveCadena" class="btn btn-info" style="margin-top: 10px; margin-bottom: 10px" disabled>Guardar</button>
								</div>
							</div>
						</div>

						<div class="alert-success hidden">
							<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
							Cadena ingresada correctamente!
						</div>

						<div class="alert-error hidden">
							<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
							Se encontro un error por favor intente de nuevo!
						</div>
                        <div id="loaderEmisor" class="loaderEmisor hidden"><div id="loader" class="loader"></div></div>
					</div>
				</form>
			</div>
		</section>
	</section>
    <style type="text/css">
        .dataTables_processing {
            border: none;
            background: none;
        }
        /*LOADER*/
        .loaderEmisor {
            z-index: 999999;
            align-items: center;
            display: flex;
            justify-content: center;
            width: 100%;
            height: 100%;
            position: absolute;
            background: #00000080;
            left: 0;
            top: 0;
        }

        .loader {
            font-size: 20px;
            margin: 45% auto;
            width: 1em;
            height: 1em;
            border-radius: 50%;
            position: relative;
            text-indent: -9999em;
            -webkit-animation: load4 1.3s infinite linear;
            animation: load4 1.3s infinite linear;
        }
        @-webkit-keyframes load4 {
            0%,
            100% {
                box-shadow: 0em -3em 0em 0.2em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 0em #ffffff;
            }
            12.5% {
                box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 0.2em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            25% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 0.2em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            37.5% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 0.2em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            50% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 0.2em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            62.5% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 0.2em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            75% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0.2em #ffffff, -2em -2em 0 0em #ffffff;
            }
            87.5% {
                box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 0.2em #ffffff;
            }
        }
        @keyframes load4 {
            0%,
            100% {
                box-shadow: 0em -3em 0em 0.2em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 0em #ffffff;
            }
            12.5% {
                box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 0.2em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            25% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 0em #ffffff, 3em 0em 0 0.2em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            37.5% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 0em #ffffff, 2em 2em 0 0.2em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 -0.5em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            50% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 0em #ffffff, 0em 3em 0 0.2em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 -0.5em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            62.5% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 0em #ffffff, -2em 2em 0 0.2em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 -0.5em #ffffff;
            }
            75% {
                box-shadow: 0em -3em 0em -0.5em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0.2em #ffffff, -2em -2em 0 0em #ffffff;
            }
            87.5% {
                box-shadow: 0em -3em 0em 0em #ffffff, 2em -2em 0 -0.5em #ffffff, 3em 0em 0 -0.5em #ffffff, 2em 2em 0 -0.5em #ffffff, 0em 3em 0 -0.5em #ffffff, -2em 2em 0 0em #ffffff, -3em 0em 0 0em #ffffff, -2em -2em 0 0.2em #ffffff;
            }
        }
    </style>
	<!--*.JS Generales-->
	<script type="text/javascript">
		BASE_PATH = "<?php echo $PATHRAIZ; ?>";
		ID_PERFIL = "<?php echo $_SESSION['idPerfil']; ?>";
	</script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
	<!--Generales-->
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/input-mask/input-mask.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
	<script src="<?php echo $PATHRAIZ; ?>/inc/js/_AfiliacionesCadena.js?v=<?php echo rand(); ?>"></script>
</body>

</html>