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
	
	$tipoBusqueda = !empty($_POST["tipoBusquedaP2"])? $_POST["tipoBusquedaP2"] : NULL;
	if ( $tipoBusqueda == 1 || $tipoBusqueda == 2 ) {
		$nombreCliente = !empty($_POST["nombreP2"])? $_POST["nombreP2"] : NULL;
		$numeroCuenta = !empty($_POST["numeroCuentaP2"])? $_POST["numeroCuentaP2"] : NULL;
		$idPropietario = !empty($_POST["idPropietarioP2"])? $_POST["idPropietarioP2"] : NULL;
		$nombrePropietario = !empty($_POST["nombrePropietarioP2"])? $_POST["nombrePropietarioP2"] : NULL;
		$referenciaBancaria = !empty($_POST["referenciaBancariaP2"])? $_POST["referenciaBancariaP2"] : NULL;
	}	
	
	if ( $tipoBusqueda == 3 ) {
		$numeroCuenta = !empty($_POST["numeroCuenta"])? $_POST["numeroCuenta"] : NULL;
		$sql = "SELECT cuenta.`numCuenta`, cuenta.`idCadena`, cuenta.`idSubCadena`, cuenta.`idCorresponsal`,
		cuenta.`idTipoLiqReembolso`, cuenta.`idTipoLiqComision`,
		reembolso.`descripcion` AS `reembolsoNombre`, comision.`descripcion` AS `comisionNombre`
		FROM `redefectiva`.`ops_cuenta` AS cuenta
		INNER JOIN `redefectiva`.`cat_tipoliquidacion` AS reembolso
		ON ( reembolso.`idTipoLiquidacion` = cuenta.`idTipoLiqReembolso` AND reembolso.`idEstatus` = 0 )
		INNER JOIN `redefectiva`.`cat_tipoliquidacion` AS comision
		ON ( comision.`idTipoLiquidacion` = cuenta.`idTipoLiqComision` AND comision.`idEstatus` = 0 )
		WHERE `numCuenta` = $numeroCuenta;";
		$result = $RBD->query($sql);
		if ( $RBD->error() == "" ) {
			if ( mysqli_num_rows($result) == 0 ) {
				header("Location: $PATHRAIZ/_Clientes/Cuentas/1.php?e=1");
				exit();
			}
		}
		$sqlCliente = "SELECT cuenta.`numCuenta`,
		IF ( cuenta.`idCorresponsal` = -1,
		CASE cliente.`idRegimen`
			WHEN 1 THEN
				CONCAT_WS('', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`)
			WHEN 2 THEN
				cliente.`RazonSocial`
			WHEN 3 THEN
				IF(cliente.`RazonSocial` = '' OR cliente.`RazonSocial` IS NULL, CONCAT_WS('', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`), cliente.`RazonSocial`)
		END, corresponsal.`nombreCorresponsal` ) AS 'nombreCliente', cuenta.`idCorresponsal`, cuenta.`idSubCadena`
		FROM `redefectiva`.`ops_cuenta` AS cuenta
		INNER JOIN `redefectiva`.`dat_cliente` AS cliente
		ON ( cliente.`idCliente` = cuenta.`idSubCadena` AND cliente.`idEstatus` = 0 )
		LEFT JOIN `redefectiva`.`dat_corresponsal` AS corresponsal
		ON ( corresponsal.`idCorresponsal` = cuenta.`idCorresponsal` AND corresponsal.`idEstatusCorresponsal` = 0 )
		WHERE cuenta.`numCuenta` LIKE CONCAT('%', $numeroCuenta, '%');";
		$result = $RBD->query($sqlCliente);
		if ( $RBD->error() == "" ) {
			if ( mysqli_num_rows($result) > 0 ) {
				$row = mysqli_fetch_assoc($result);
				$nombreCliente = codificarUTF8($row["nombreCliente"]);
				$idSubcadena = $row["idSubCadena"];
				$idCorresponsal = $row["idCorresponsal"];
				if ( $idCorresponsal == -1 ) {
					if ( $idSubcadena != -1 ) {
						$nivel = "Cliente";
					}
				} else {
					$nivel = "Corresponsal";
				}				
			}
		}
		$sqlCuenta = "SELECT cuenta.`numCuenta` AS `numeroCuenta`, cliente.`idCliente` AS `idPropietario`,
		CASE cliente.`idRegimen`
			WHEN 1 THEN
				CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`)
			WHEN 2 THEN
				cliente.`RazonSocial`
			WHEN 3 THEN
				IF(cliente.`RazonSocial` = '' OR cliente.`RazonSocial` IS NULL, CONCAT_WS(' ', cliente.`Nombre`, cliente.`Paterno`, cliente.`Materno`), cliente.`RazonSocial`)
		END AS `nombrePropietario`, bancoRef.`referencia` AS `referenciaBancaria`
		FROM `redefectiva`.`ops_cuenta` AS cuenta
		LEFT JOIN `redefectiva`.`dat_cliente` AS cliente
		ON ( cliente.`idCliente` = cuenta.`idSubCadena` AND `idEstatus` = 0 )
		LEFT JOIN `data_contable`.`dat_banco_ref` AS bancoRef
		ON ( bancoRef.`numCuenta` = cuenta.`numCuenta` AND bancoRef.`idEstatus` = 0 )
		WHERE cuenta.`numCuenta` = $numeroCuenta;";
		$result = $RBD->query($sqlCuenta);
		if ( $RBD->error() == "" ) {
			if ( mysqli_num_rows($result) > 0 ) {
				$row = mysqli_fetch_array($result);
				$idPropietario = $row["idPropietario"];
				$nombrePropietario = codificarUTF8($row["nombrePropietario"]);
				$referenciaBancaria = $row["referenciaBancaria"];
			}
		}		
	}
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
                </span>              
              </div>              
              <div class="panel">                
                <!--<div class="jumbotron"><div class="container">        <h2>Reembolsos</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel rutrum quam. Aenean luctus ligula et justo eleifend, a posuere felis ornare. Vivamus sit amet ligula leo.</p></div></div>-->                
                <div class="panel-body">                  
                  <div class="cliente-activo">
					  <?php
                        $sql = "SELECT cuenta.`numCuenta`, cuenta.`idCadena`, cuenta.`idSubCadena`, cuenta.`idCorresponsal`,
                        cuenta.`idTipoLiqReembolso`, cuenta.`idTipoLiqComision`,
                        reembolso.`descripcion` AS `reembolsoNombre`, comision.`descripcion` AS `comisionNombre`
                        FROM `redefectiva`.`ops_cuenta` AS cuenta
                        INNER JOIN `redefectiva`.`cat_tipoliquidacion` AS reembolso
                        ON ( reembolso.`idTipoLiquidacion` = cuenta.`idTipoLiqReembolso` AND reembolso.`idEstatus` = 0 )
                        INNER JOIN `redefectiva`.`cat_tipoliquidacion` AS comision
                        ON ( comision.`idTipoLiquidacion` = cuenta.`idTipoLiqComision` AND comision.`idEstatus` = 0 )
                        WHERE `numCuenta` = $numeroCuenta;";
                        $result = $RBD->query($sql);
                        if ( $RBD->error() == "" ) {
                            if ( mysqli_num_rows($result) > 0 ) {
                                $row = mysqli_fetch_array($result);
                                $idCadena = $row["idCadena"];
                                $idSubcadena = $row["idSubCadena"];
                                $idCorresponsal = $row["idCorresponsal"];
                                $idTipoLiqReembolso = $row["idTipoLiqReembolso"];
                                $idTipoLiqComision = $row["idTipoLiqComision"];
                                $reembolsoNombre = $row["reembolsoNombre"];
                                $comisionNombre = $row["comisionNombre"];
                                $nivel = "";
                                if ( $idCorresponsal == -1 ) {
                                    if ( $idSubcadena != -1 ) {
                                        $nivel = "Cliente";
                                        $tipoCuenta = "Compartida";
                                    }
                                } else {
                                    $nivel = "Corresponsal";
                                    $tipoCuenta = "Individual";
                                }
                            }
                        }
                        if ( $tipoCuenta == "Compartida" ) {
							$sqlIVA = "SELECT `idTipoComision`
							FROM `redefectiva`.`dat_cliente`
							WHERE `idCliente` = $idPropietario
							AND `idEstatus` = 0;";
                        } else if ( $tipoCuenta == "Individual" ) {
							$sqlCorrCliente = "SELECT `idSubCadena`
							FROM `redefectiva`.`dat_corresponsal`
							WHERE `idCorresponsal` = $idPropietario
							AND `idEstatusCorresponsal` = 0;";
							$resultCorrCliente = $RBD->query($sqlCorrCliente);
							if ( $RBD->error() == "" ) {
                                $row = mysqli_fetch_assoc($resultCorrCliente);
                                $idSubCorr = $row["idSubCadena"]; //Subcadena del Corresponsal
								$sqlIVA = "SELECT `idTipoComision`
								FROM `redefectiva`.`dat_cliente`
								WHERE `idCliente` = $idSubCorr
								AND `idEstatus` = 0;";
							}
                        }
                        if ( $sqlIVA != "" ) {
                            $resultIVA = $RBD->query($sqlIVA);
                            if ( $RBD->error() == "" ) {
                                $row = mysqli_fetch_assoc($resultIVA);
                                $idIVA = $row["idTipoComision"];
                            }
                        }
                      ?>                                        
                    <span>                        
                      <i class="fa fa-user"></i> <?php echo $nivel; ?> Seleccionado                     
                    </span><h3><?php echo $nombreCliente; ?></h3>
                    <button class="btn btn-primary pull-right btn-sm" id="nuevaBusqueda" style="margin-bottom:20px; display:inline-block"><i class="fa fa-search"></i> Nueva Búsqueda</button>                  
                  </div>                    
                  <br/>                  
                  <table width="100%">                    
                    <thead>                      
                      <tr>                        
                        <th   style="text-align:center; ">ID Cuenta                         
                        </th>                        
                        <th  style="text-align:center; ">Tipo de Cuenta                         
                        </th>                        
                        <th  style="text-align:center; ">Propietario                         
                        </th>                        
                        <th  style="text-align:center; ">Referencia Bancaria                         
                        </th>                        
                        <th  style="text-align:center; ">Comisiones                         
                        </th>                        
                        <th  style="text-align:center; ">Reembolsos                         
                        </th>                        
                        <th  style="text-align:center; "> Editar                         
                        </th>                      
                      </tr>                    
                    </thead>                    
                    <tbody>                    
                      <tr>                         
                        <td align="center" style="font-size:13px;" id="numCuentaLabel"><?php echo $numeroCuenta; ?></td>                        
                        <td align="center" style="font-size:13px;"><?php echo $tipoCuenta; ?></td>                        
                        <td align="center" style="font-size:13px;"><?php echo $nivel; ?>                          
                          <span style="font-size:11px; display:block;">(<?php echo $nombrePropietario; ?>)                         
                          </span></td>                        
                        <td align="center" style="font-size:13px;"><?php echo $referenciaBancaria; ?></td>                        
                        <td align="center" style="font-size:13px;"><?php echo $comisionNombre; ?></td>                        
                        <td align="center" style="font-size:13px;"><?php echo $reembolsoNombre; ?></td>                        
                        <td align="center">                        
                          <button class="btn btn-primary btn-xs" data-toggle="modal" href="#cuenta" id="editarCuentaCliente">                            
                            <i class="fa fa-pencil"></i>                        
                          </button></td>                        
                      </tr>                    
                    </tbody>                  
                  </table>                    
                  <br/>                  
                  <div class="cliente-activo">                      
                    <span>                        
                      <i class="fa fa-bank"></i> Cuentas Bancarias                     
                    </span>                  
                  </div>                  
                  <button type="button" class="btn btn-primary btn-xs" id="btnNuevaCuentaBancaria" data-toggle="modal" href="#nueva">                    
                    <i class="fa fa-plus"></i> Nueva Cuenta Bancaria                   
                  </button>                    
                  <br/>                  
                  <table class="table table-striped table-advance table-hover" cellpadding="3" style="margin-top:20px;">                    
                    <thead>                      
                      <tr style="border-bottom:1px solid #e4e4e4;">                        
                        <th width="16.666%" style="text-align:center;"> Tipo de Instrucción                         
                        </th>                        
                        <th width="16.666%" style="text-align:center;"> CLABE                         
                        </th>
                        <th width="16.666%" style="text-align:center;"> Referencia
                        </th>
                        <th width="16.666%" style="text-align:center;"> Beneficiario                         
                        </th>                        
                        <th width="16.666%" style="text-align:center;"> RFC                         
                        </th>                        
                        <th width="16.666%" style="text-align:center;"> Correo                         
                        </th>                        
                        <th width="16.666%" style="text-align:center;"> Acciones                         
                        </th>                      
                      </tr>                    
                    </thead>                    
                    <tbody>
                    	<?php
							$sqlCuentasBancarias = "SELECT confCuentaBanco.`id` AS `idConfCuentaBanco`, confCuenta.`idConfiguracion` AS `idConfCuenta`,
							confCuentaBanco.`CLABE`, confCuentaBanco.`Beneficiario`, confCuentaBanco.`alfanumerica`,
							confCuentaBanco.`RFC`, confCuentaBanco.`Correo`, confCuenta.`idTipoInstruccion`,
							IF(confCuenta.`idTipoInstruccion` != -1, instruccion.`descripcicon`, 'Todos') AS `liquidacionNombre`
							FROM `data_contable`.`conf_cuenta_banco` AS confCuentaBanco
							RIGHT JOIN `data_contable`.`conf_cuenta` AS confCuenta
							ON ( confCuenta.`idConfCuenta` = confCuentaBanco.`id` AND confCuenta.`idEstatus` = 0 )
							LEFT JOIN `redefectiva`.`cat_tipoinstruccion` AS instruccion
							ON ( instruccion.`idTipoInstruccion` = confCuenta.`idTipoInstruccion` AND instruccion.`idEstatus` = 0 )
							WHERE confCuenta.`numCuenta` = $numeroCuenta AND confCuenta.`idEstatus` = 0 AND confCuentaBanco.`idEstatus` = 0;";						
							$result = $RBD->query($sqlCuentasBancarias);
							if ( $RBD->error() == "" ) {
								if ( mysqli_num_rows($result) > 0 ) {
									$index = 0;
									while( $row = mysqli_fetch_assoc($result) ) {					
										echo "<tr>";
										echo "<td align=\"center\" id=\"liquidacion-$index\">".$row["liquidacionNombre"];
										echo "<input type=\"hidden\" name=\"idConfCuentaBanco-$index\" id=\"idConfCuentaBanco-$index\" value=\"".$row["idConfCuentaBanco"]."\">";
										echo "<input type=\"hidden\" name=\"idConfCuenta-$index\" id=\"idConfCuenta-$index\" value=\"".$row["idConfCuenta"]."\">";
										echo "<input type=\"hidden\" name=\"idTipoInstruccion-$index\" id=\"idTipoInstruccion-$index\" value=\"".$row["idTipoInstruccion"]."\">";
										echo "<input type=\"hidden\" name=\"referencia-$index\" id=\"referencia-$index\" value=\"".$row["alfanumerica"]."\">";
										echo "</td>";
										echo "<td align=\"center\" id=\"CLABE-$index\">".$row["CLABE"]."</td>";
										echo "<td align=\"center\" id=\"CLABE-$index\">".$row["alfanumerica"]."</td>";
										echo "<td align=\"center\" id=\"beneficiario-$index\" style=\"word:break:break-all\">".codificarUTF8($row["Beneficiario"])."</td>";
										echo "<td align=\"center\" id=\"RFC-$index\">".$row["RFC"]."</td>";
										echo "<td align=\"center\" id=\"correo-$index\" style=\"word:break:break-all\">".$row["Correo"]."</td>";
										echo "<td align=\"center\">                          
                          				<button class=\"btn btn-primary btn-xs editar\" data-toggle=\"modal\" id=\"editar-$index\" href=\"#edicion\">                              
                            			<i class=\"fa fa-pencil\"></i>                          
                          				</button>                          
                          				<button class=\"btn btn-primary btn-xs eliminar\" id=\"eliminar-$index\">                              
                            			<i class=\"fa fa-trash-o\"></i>                          
                          				</button></td>";
										echo "</tr>";
										$index++;										
									}
								} else {
									echo "<tr>";
									echo "<td align=\"center\" colspan=\"6\">No se encontraron resultados.</td>";
									echo "</tr>";
								}
							}
						?>                     
                    </tbody>                  
                  </table>                
                </div>              
              </div>            
            </div>          
          </div>        
        </div>      
      </section>    
    </section>    
    <!--Modal de Edición-->    
    <div class="modal fade in" id="edicion" aria-hidden="true">      
      <div class="modal-dialog">        
        <div class="modal-content">          
          <div class="modal-header"><h5>Cuenta Bancaria</h5>          
          </div>          
          <div class="modal-body">            
            <div class="cliente-activo">                
              <span>                  
                <i class="fa fa-user"></i> <?php echo $nivel; ?> Seleccionado               
              </span><h3><?php echo $nombreCliente; ?></h3>            
            </div>            
            <!--Formulario-->              
            <br/>            
            <form class="form-horizontal" style=" display: inline-block; width: 100%; ">                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">Tipo de Movimiento                   
                </label>                    
                <br>                    
                <select class="form-control m-bot15" id="tipoMovimiento_2" disabled="">                      
                  <option value="0">Pago</option>                  
                </select>                
              </div>                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">Tipo de Instrucción                   
                </label>                    
                <br>                    
                <select class="form-control m-bot15" id="tipoInstruccion_2" disabled>
                	<?php
						$sql = "SELECT `idTipoInstruccion`, `descripcicon`
						FROM `redefectiva`.`cat_tipoinstruccion`
						WHERE `idEstatus` = 0;";
						$result = $RBD->query($sql);
						if ( $RBD->error() == "" ) {
							echo "<option value=\"-1\">Todos</option>";
							while( $row = mysqli_fetch_assoc($result) ) {
								echo "<option value=\"".$row["idTipoInstruccion"]."\">".codificarUTF8($row["descripcicon"])."</option>";
							}
						}
					?>
                </select>                
              </div>
              <div class="form-group col-xs-3" style="margin-right:13px;">
              	<label class="control-label">Referencia</label>
                <br/>
                <input class="form-control m-bot15" type="text" id="txtReferencia_2" maxlength="15"> 
              </div>
              <br>                
              <br>                  
              <br>                  
              <br>                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">CLABE:                   
                </label>                    
                <br>                    
                <input type="text" class="form-control m-bot15" id="txtCLABE_2" maxlength="18">                
              </div>                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">Beneficiario:                   
                </label>                    
                <br>                    
                <input type="text" class="form-control m-bot15" id="txtBeneficiario_2" maxlength="35">                
              </div>                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">RFC:                   
                </label>                    
                <br>                    
                <input class="form-control m-bot15" type="text" id="txtRFC_2" style="text-transform: uppercase;" maxlength="13">                
              </div>                
              <div class="form-group col-xs-3">                    
                <label class="control-label">Correo:                   
                </label>                    
                <br>                    
                <input type="text" class="form-control m-bot15" id="txtCorreo_2" maxlength="120">
              </div>
            </form>            
            <!--Fin del Formulario-->          
          </div>          
          <div class="modal-footer">            
            <button aria-hidden="true" type="button" id="guardarEdicion">Guardar             
            </button>          
          </div>          
        </div>      
      </div>    
    </div>    
    <!--Modal de Edición-->    
    <!--Modal de Cuenta-->    
    <div class="modal fade in" id="cuenta" aria-hidden="true">      
      <div class="modal-dialog">        
        <div class="modal-content">          
          <div class="modal-header"><h5>Cuenta </h5>          
          </div>          
          <div class="modal-body">            
            <div class="cliente-activo">                
              <span>                  
                <i class="fa fa-user"></i> <?php echo $nivel; ?> Seleccionado                
              </span><h3><?php echo $nombreCliente; ?></h3>              
              <!--Formulario-->              
            </div>              
            <br/>              
            <form class="form-horizontal" style=" display: inline-block; width: 100%; ">                
              <div class="form-group col-xs-3">                    
                <label class="control-label">Liquidación de Comisiones:                   
                </label>                    
                <br>                    
                <select class="form-control m-bot15" id="destinoLiquidacionComision">                      
                  <option value="1">FORELO</option>                      
                  <option value="2">Cuenta Bancaria</option>                  
                </select>                
              </div>                
              <div class="form-group col-xs-5" style="margin-left:20px;margin-top: 24px;">                  
                <div class="radio">                      
                  <label>                        
                    <input type="radio" name="iva" id="sinIVA" value="2">        Sin IVA                     
                  </label>                  
                </div>                  
                <div class="radio" style="margin-left:20px;">                      
                  <label>                        
                    <input type="radio" name="iva" id="conIVA" value="1">        IVA 16%                     
                  </label>                  
                </div>                
              </div>                
            </form>                
            <br/>              
            <button type="submit" id="guardarLiquidacionComision">Guardar               
            </button>              
            <!--Fin del Formulario-->              
            <!--Formulario-->                
            <br/>                
            <br/>              
            <!--<div class="alert alert-info" id="mensajeExito" style="display:none;"> <strong>¡Correcto!</strong> Se ha cambiado la configuración exitosamente.               
            </div>-->                
            <br/>              
            <form class="form-horizontal" style=" display: inline-block; width: 100%; ">                
              <div class="form-group col-xs-3">                    
                <label class="control-label">Liquidación de Reembolsos:                   
                </label>                    
                <br>                    
                <select class="form-control m-bot15" id="destinoLiquidacionReembolso">                      
                  <option value="1">FORELO</option>                      
                  <option value="2">Cuenta Bancaria</option>                  
                </select>                
              </div>                  
              <!--<div class="form-group col-xs-5" style="margin-left:20px;margin-top: 24px;">                  
                <div class="radio">                      
                  <label>                        
                    <input type="radio">        TEXTO                     
                  </label>                  
                </div>                  
                <div class="radio" style="margin-left:20px;">                      
                  <label>                        
                    <input type="radio">        TEXTO                     
                  </label>                  
                </div>                
              </div>-->                
            </form>                        
            <br/>            
            <button type="submit" id="guardarLiquidacionReembolso">Guardar               
            </button>              
            <br/>           
            <!--Fin del Formulario-->
            <br/>
            <br/>
            <div class="alert alert-info" id="mensajeExito" style="display:none;"> <strong>¡Correcto!</strong> Se ha cambiado la configuración exitosamente.               
            </div>                        
          </div>          
          <div class="modal-footer">          
            <button aria-hidden="true" type="button" data-dismiss="modal">Cerrar             
            </button>          
          </div>          
        </div>        
      </div>      
    </div>    
    <!--Modal de Cuenta-->    
    <!--Modal de Nueva-->    
    <div class="modal fade in" id="nueva" aria-hidden="true">      
      <div class="modal-dialog">        
        <div class="modal-content">          
          <div class="modal-header"><h5>Nueva Cuenta Bancaria</h5>          
          </div>          
          <div class="modal-body">            
            <div class="cliente-activo">                
              <span>                  
                <i class="fa fa-user"></i> <?php echo $nivel; ?> Seleccionado               
              </span><h3><?php echo $nombreCliente; ?></h3>            
            </div>              
            <!--Formulario-->                
            <br/>              
            <form class="form-horizontal" style=" display: inline-block; width: 100%; ">                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">Tipo de Movimiento                   
                </label>                    
                <br>                    
                <select class="form-control m-bot15" id="tipoMovimiento_1" disabled>                      
                  <option value="0">Pago</option>                                        
                </select>                
              </div>                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">Tipo de Instrucción                   
                </label>                    
                <br>                    
                <select class="form-control m-bot15" id="tipoInstruccion_1">                      
                  <option value="-1">Todos</option>                 
                </select>                
              </div>
              <div class="form-group col-xs-3" style="margin-right:13px;">
              	<label class="control-label">Referencia:</label>
                <br>
                <input class="form-control m-bot15" type="text" id="txtReferencia_1" maxlength="15"> 
              </div>              
              <br/>                
              <br/>                  
              <br/>                  
              <br/>                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">CLABE:                   
                </label>                    
                <br>                    
                <input class="form-control m-bot15" type="text" id="txtCLABE_1" maxlength="18">                
              </div>                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">Beneficiario:                   
                </label>                    
                <br>                    
                <input class="form-control m-bot15" type="text" id="txtBeneficiario_1" maxlength="35">                
              </div>                
              <div class="form-group col-xs-3" style="margin-right:13px;">                    
                <label class="control-label">RFC:                   
                </label>                    
                <br>                    
                <input class="form-control m-bot15" type="text" id="txtRFC_1" style="text-transform: uppercase;" maxlength="13">                
              </div>                
              <div class="form-group col-xs-3">                    
                <label class="control-label">Correo:                   
                </label>                    
                <br>                    
                <input class="form-control m-bot15" type="text" id="txtCorreo_1" maxlength="120">                
              </div>
            </form>                
            <!--<button type="submit">Guardar
                          </button>-->               
            <br/>                
            <br/>              
            <!--Fin del Formulario-->            
          </div>          
          <div class="modal-footer">            
            <!--<button aria-hidden="true" type="button" data-dismiss="modal">Cerrar-->            
            <button aria-hidden="true" type="button" id="guardar">Guardar             
            </button>          
          </div>        
        </div>      
      </div>    
    </div>    
    <!--Modal Nueva-->
    <form class="form-horizontal" id="datosPantalla3" method="POST" action="3.php">
    	<input type="hidden" name="nombreP2" id="nombreP2" value="<?php echo $nombreCliente; ?>">
        <input type="hidden" name="numeroCuentaP2" id="numeroCuentaP2" value="<?php echo $numeroCuenta; ?>">
        <input type="hidden" name="idPropietarioP2" id="idPropietarioP2" value="<?php echo $idPropietario; ?>">
        <input type="hidden" name="nombrePropietarioP2" id="nombrePropietarioP2" value="<?php echo $nombrePropietario; ?>">
        <input type="hidden" name="referenciaBancariaP2" id="referenciaBancariaP2" value="<?php echo $referenciaBancaria; ?>">
        <input type="hidden" name="tipoBusquedaP2" id="tipoBusquedaP2" value="<?php echo $tipoBusqueda; ?>">
        <input type="hidden" name="numeroCuenta" id="numeroCuenta" value="<?php echo $numeroCuenta; ?>">
    </form>    
    <!--Fin de Contenido-->    
    <!--*.JS Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js" ></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>    
    <!--Generales-->
<script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>     
<script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $PATHRAIZ; ?>/inc/js/CuentaBancaria.js"></script>
<script>
	var BASE_PATH;
	var numeroCuenta;
	var idPropietario;
	var tipoCuenta;
	var idTipoLiqComision;
	var idTipoLiqReembolso;
	var idIVA;
	$(function(){
		BASE_PATH = "<?php echo $PATHRAIZ; ?>";
		numeroCuenta = "<?php echo $numeroCuenta; ?>";
		idPropietario = "<?php echo $idPropietario; ?>";
		tipoCuenta = "<?php echo $tipoCuenta; ?>";
		idTipoLiqComision = "<?php echo $idTipoLiqComision; ?>";
		idTipoLiqReembolso = "<?php echo $idTipoLiqReembolso; ?>";
		idIVA = "<?php echo $idIVA; ?>";
		initComponentsPantalla3();
	});
</script>    
    <!--Cierre del Sitio-->  
  </body>
</html>