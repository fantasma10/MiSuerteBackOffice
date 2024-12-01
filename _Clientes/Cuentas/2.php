<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
	
	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];
	
	$idOpcion = 97;
	$tipoDePagina = "Mixto";
	$esEscritura = true;
	
	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../../error.php");
		exit();
	}
	
	if ( esLecturayEscrituraOpcion($idOpcion) ) {
		$esEscritura = true;
	}	
	
	$nombreCliente = !empty($_POST["nombreCliente"])? $_POST["nombreCliente"] : NULL;
	$idCliente = !empty($_POST["idCliente"])? $_POST["idCliente"] : NULL;
	$nombreCorresponsal = !empty($_POST["nombreCorresponsal"])? $_POST["nombreCorresponsal"] : NULL;
	$idCorresponsal = !empty($_POST["idCorresponsal"])? $_POST["idCorresponsal"] : NULL;
	$idCadena = !empty($_POST["idCadena"])? $_POST["idCadena"] : NULL;
	$idSubcadena = !empty($_POST["idSubcadena"])? $_POST["idSubcadena"] : NULL;
	$numeroCuenta = !empty($_POST["numeroCuenta"])? $_POST["numeroCuenta"] : NULL;
	$tipoBusqueda = !empty($_POST["tipoBusquedaP2"])? $_POST["tipoBusquedaP2"] : NULL;
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
    <title>.::Mi Red::.Comisiones y Reembolsos
    </title>
    <!-- Núcleo BOOTSTRAP -->
    <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--ASSETS-->
    <link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
    <!-- ESTILOS MI RED -->
    <link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" />
    <!--[if lt IE 9]><script src="js/html5shiv.js"></script><script src="js/respond.min.js"></script><![endif]-->
  </head>
  <?php include($_SERVER['DOCUMENT_ROOT']."/inc/cabecera2.php"); ?>
  <?php include($_SERVER['DOCUMENT_ROOT']."/inc/menu.php"); ?> 
  <!--<body>-->
    <!--Contenido-->
    <section id="main-content">
      <section class="wrapper site-min-height">
        <div class="row">
          <div class="col-xs-12">
            <!--Panel Principal-->
            <div class="panelrgb">
              <div class="titulorgb-prealta"> 
                <span> 
                  <i class="fa fa-users"></i>
                </span><h3> </h3>
              </div>
              <div class="panel">
                <!--<div class="jumbotron"><div class="container">        <h2>Reembolsos</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel rutrum quam. Aenean luctus ligula et justo eleifend, a posuere felis ornare. Vivamus sit amet ligula leo.</p></div></div>-->
                <div class="panel-body">
                  <div class="cliente-activo" style="display:inline;"> 
                    <span style="display:inline-block;"> 
                      <i class="fa fa-user"></i> <?php
                      	switch( $tipoBusqueda ) {
							case 1:
								echo "Cliente";
							break;
							case 2:
								echo "Corresponsal";
							break;
							case 3:
								echo "Cliente";
							break;
						}
					  ?> Seleccionado
                    </span>
                    <h3 id="nombre">
						<?php
							switch( $tipoBusqueda ) {
								case 1:
									echo isset($nombreCliente)? $nombreCliente : "";
								break;
								case 2:
									echo isset($nombreCorresponsal)? $nombreCorresponsal : "";
								break;
								case 3:
									echo isset($nombreCliente)? $nombreCliente : "";
								break;
							}
						?>                    
                    </h3>
                    <button class="btn btn-primary pull-right btn-sm" id="nuevaBusqueda" style="margin-bottom:20px; display:inline-block"><i class="fa fa-search"></i> Nueva Búsqueda</button>
                  </div> 
                  <br/>
                  <table class="table table-striped table-advance table-hover" cellpadding="3" style="border: 1px solid #e4e4e4;">
                    <thead>
                      <tr style="border-bottom:1px solid #e4e4e4;">
                        <th width="20%" style="text-align:center;"> ID de Cuenta
                        </th>
                        <th width="20%" style="text-align:center;"> ID de Propietario
                        </th>                        
                        <th width="20%" style="text-align:center;"> Propietario
                        </th>
                        <th width="20%" style="text-align:center;"> Referencia Bancaria
                        </th>
                        <th width="20%" style="text-align:center;"> Configurar
                      </tr>
                    </thead>
                    <tbody>
						<?php
                            switch( $tipoBusqueda ) {
                                case 1:
                                   /*$sql = "SELECT cuenta.`numCuenta` AS `numeroCuenta`, cliente.`idCliente` AS `idPropietario`,
                                    cuenta.`idSubCadena`, cuenta.`idCorresponsal`,
									IF ( cuenta.`idCorresponsal` = -1,
									CASE cliente.`idRegimen`
                                        WHEN 1 THEN
                                            CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`)
                                        WHEN 2 THEN
                                            cliente.`RazonSocial`
                                        WHEN 3 THEN
                                            IF(cliente.`RazonSocial` = '' OR cliente.`RazonSocial` IS NULL, CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`), cliente.`RazonSocial`)
                                    END, corresponsal.`nombreCorresponsal` ) AS `nombrePropietario`, bancoRef.`referencia` AS `referenciaBancaria`
                                    FROM `redefectiva`.`ops_cuenta` AS cuenta
                                    LEFT JOIN `redefectiva`.`dat_cliente` AS cliente
                                    ON ( cliente.`idCliente` = cuenta.`idSubCadena` AND `idEstatus` = 0 )
                                    LEFT JOIN `data_contable`.`dat_banco_ref` AS bancoRef
                                    ON ( bancoRef.`numCuenta` = cuenta.`numCuenta` AND bancoRef.`idEstatus` = 0 )
									LEFT JOIN `redefectiva`.`dat_corresponsal` AS corresponsal
									ON ( corresponsal.`idCorresponsal` = cuenta.`idCorresponsal` AND corresponsal.`idEstatusCorresponsal` = 0 )
                                    WHERE cuenta.`idSubCadena` = $idCliente
									ORDER BY cuenta.`numCuenta` ASC;";*/
                                   $sql = "SELECT cuenta.`numCuenta` AS `numeroCuenta`, cliente.`idCliente` AS `idPropietario`,
                                    cuenta.`idSubCadena`, cuenta.`idCorresponsal`,
									IF ( cuenta.`idCorresponsal` = -1,
									CASE cliente.`idRegimen`
                                        WHEN 1 THEN
                                            CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`)
                                        WHEN 2 THEN
                                            cliente.`RazonSocial`
                                        WHEN 3 THEN
                                            IF(cliente.`RazonSocial` = '' OR cliente.`RazonSocial` IS NULL, CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`), cliente.`RazonSocial`)
                                    END, corresponsal.`nombreCorresponsal` ) AS `nombrePropietario`, bancoRef.`referencia` AS `referenciaBancaria`,
									IF ( cuenta.`idCorresponsal` = -1, cliente.`idEstatus`, corresponsal.`idEstatusCorresponsal` ) AS `idEstatus`
                                    FROM `redefectiva`.`ops_cuenta` AS cuenta
                                    LEFT JOIN `redefectiva`.`dat_cliente` AS cliente
                                    ON ( cliente.`idCliente` = cuenta.`idSubCadena` )
                                    LEFT JOIN `data_contable`.`dat_banco_ref` AS bancoRef
                                    ON ( bancoRef.`numCuenta` = cuenta.`numCuenta` AND bancoRef.`idEstatus` = 0 )
									LEFT JOIN `redefectiva`.`dat_corresponsal` AS corresponsal
									ON ( corresponsal.`idCorresponsal` = cuenta.`idCorresponsal` )
                                    WHERE cuenta.`idSubCadena` = $idCliente
									ORDER BY cuenta.`numCuenta` ASC;";
                                break;
                                case 2:
                                    /*$sql = "SELECT cuenta.`numCuenta` AS `numeroCuenta`, corresponsal.`idCorresponsal` AS `idPropietario`,
                                    corresponsal.`nombreCorresponsal` AS `nombrePropietario`, bancoRef.`referencia` AS `referenciaBancaria`,
									cuenta.`idSubCadena`, cuenta.`idCorresponsal`
                                    FROM `redefectiva`.`ops_cuenta` AS cuenta
                                    INNER JOIN `redefectiva`.`dat_corresponsal` AS corresponsal
                                    ON ( corresponsal.`idCorresponsal` = cuenta.`idCorresponsal` AND `idEstatusCorresponsal` = 0 )
                                    LEFT JOIN `data_contable`.`dat_banco_ref` AS bancoRef
                                    ON ( bancoRef.`numCuenta` = cuenta.`numCuenta` AND bancoRef.`idEstatus` = 0 )
                                    WHERE cuenta.`idCorresponsal` = $idCorresponsal
									ORDER BY cuenta.`numCuenta` ASC;";*/
                                    $sql = "SELECT cuenta.`numCuenta` AS `numeroCuenta`, corresponsal.`idCorresponsal` AS `idPropietario`,
                                    corresponsal.`nombreCorresponsal` AS `nombrePropietario`, bancoRef.`referencia` AS `referenciaBancaria`,
									cuenta.`idSubCadena`, cuenta.`idCorresponsal`,
									corresponsal.`idEstatusCorresponsal` AS `idEstatus`
                                    FROM `redefectiva`.`ops_cuenta` AS cuenta
                                    INNER JOIN `redefectiva`.`dat_corresponsal` AS corresponsal
                                    ON ( corresponsal.`idCorresponsal` = cuenta.`idCorresponsal` )
                                    LEFT JOIN `data_contable`.`dat_banco_ref` AS bancoRef
                                    ON ( bancoRef.`numCuenta` = cuenta.`numCuenta` AND bancoRef.`idEstatus` = 0 )
                                    WHERE cuenta.`idCorresponsal` = $idCorresponsal
									ORDER BY cuenta.`numCuenta` ASC;";
                                break;
                                case 3:
                                    $sql = "SELECT cuenta.`numCuenta` AS `numeroCuenta`, cliente.`idCliente` AS `idPropietario`,
                                    cuenta.`idSubCadena`, cuenta.`idCorresponsal`,
									CASE cliente.`idRegimen`
                                        WHEN 1 THEN
                                            CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`)
                                        WHEN 2 THEN
                                            cliente.`RazonSocial`
                                        WHEN 3 THEN
                                            IF(cliente.`RazonSocial` = '' OR cliente.`RazonSocial` IS NULL, CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`), cliente.`RazonSocial`)
                                    END AS `nombrePropietario`, bancoRef.`referencia` AS `referenciaBancaria`,
									cliente.`idEstatus`
                                    FROM `redefectiva`.`ops_cuenta` AS cuenta
                                    LEFT JOIN `redefectiva`.`dat_cliente` AS cliente
                                    ON ( cliente.`idCliente` = cuenta.`idSubCadena` )
                                    LEFT JOIN `data_contable`.`dat_banco_ref` AS bancoRef
                                    ON ( bancoRef.`numCuenta` = cuenta.`numCuenta` AND bancoRef.`idEstatus` = 0 )
                                    WHERE cuenta.`numCuenta` = $numeroCuenta
									ORDER BY cuenta.`numCuenta` ASC;";
                                break;
                            }
							//var_dump("sql: $sql");
                            $result = $RBD->query($sql);
                            if ( $RBD->error() == "" ) {
                                if ( mysqli_num_rows($result) > 0 ) {
									$index = 0;
                                    while ( $row = mysqli_fetch_array($result) ) {
										$idSubcadena = $row["idSubCadena"];
										$idCorresponsal = $row["idCorresponsal"];
										if ( $idCorresponsal == -1 ) {
											if ( $idSubcadena != -1 ) {
												$nivel = "Cliente";
												$idPropietario = $idSubcadena;
											}
										} else {
											$nivel = "Corresponsal";
											$idPropietario = $idCorresponsal;
										}										 
                                        echo "<tr>";
                                        echo "<td align=\"center\" id=\"numeroCuenta-$index\">".$row["numeroCuenta"]."</td>";
										echo "<td align=\"center\" id=\"idPropietario-$index\">".$idPropietario."</td>";
                                        //echo "<td align=\"center\" id=\"idPropietario-$index\">".$row["idPropietario"]."</td>";
                                        echo "<td align=\"center\">".$nivel." (".codificarUTF8($row["nombrePropietario"]).")";
										echo "<input type=\"hidden\" name=\"nombrePropietario-$index\" id=\"nombrePropietario-$index\" value=\"".codificarUTF8($row["nombrePropietario"])."\">";
										if ( $row["idEstatus"] != 0 ) {
											echo " No activo";
										}
										echo "</td>";
                                        echo "<td align=\"center\" id=\"referenciaBancaria-$index\">".$row["referenciaBancaria"]."</td>";
                                        echo "<td align=\"center\">";
                                        echo "<button class=\"btn btn-primary btn-xs configurar\" id=\"configuracion-$index\">";
                                        echo "<i class=\"fa fa-gear\"></i>";
                                        echo "</button></td>";
                                        echo "</tr>";
										$index++;
                                    }
                                } else {
                                    echo "<tr>";
                                    echo "<td align=\"center\" colspan=\"5\">No se encontraron resultados.</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                  </table>
                  <form class="form-horizontal" id="cuentasPantalla2" method="POST" action="3.php">
                  	<input type="hidden" name="nombreP2" id="nombreP2" value="">
                    <input type="hidden" name="numeroCuentaP2" id="numeroCuentaP2" value="">
                    <input type="hidden" name="idPropietarioP2" id="idPropietarioP2" value="">
                    <input type="hidden" name="nombrePropietarioP2" id="nombrePropietarioP2" value="">
                    <input type="hidden" name="referenciaBancariaP2" id="referenciaBancariaP2" value="">
                    <input type="hidden" name="tipoBusquedaP2" id="tipoBusquedaP2" value="<?php echo $tipoBusqueda; ?>">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>
    <!--Fin de Contenido-->
    <!--*.JS Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js" ></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
    <!--Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/CuentaBancaria.js"></script>
<script>
	var BASE_PATH;
	$(function(){
		BASE_PATH = "<?php echo $PATHRAIZ; ?>";
		initComponentsPantalla2();
	});
</script>
    <!--Cierre del Sitio-->
  </body>
</html>