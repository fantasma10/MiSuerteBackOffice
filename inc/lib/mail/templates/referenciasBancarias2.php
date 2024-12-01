<?php

	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];


	$SUB = new SubCadena($RBD, $WBD);

	$res = $SUB->load($idSubCadena);

	$response = array();

	if($res['codigoRespuesta'] == 0){
		$response['success'] = true;

		$referenciaBancaria = $SUB->getReferenciaBancaria();
	}
	else{
		$response['success'] = false;
	}

$tbl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<!-- If you delete this tag, the sky will fall on your head -->
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Env&iacute;o Correo</title>

			<link rel="stylesheet" type="text/css" href="stylesheets/email.css" />
			<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
			<style>
				* { 
					margin:0;
					padding:0;
				}
				* { }

				img { 
					max-width: 100%; 
				}
				.collapse {
					margin:0;
					padding:0;
				}
				body {
					-webkit-font-smoothing:antialiased; 
					-webkit-text-size-adjust:none; 
					width: 100%!important; 
					height: 100%;
					background:#f1f1f1;
					/*background:#191a1e;*/
				}


				a { color: #E0031D;}

				.btn {
					text-decoration:none;
					color: #FFF;
					background-color: #666;
					padding:10px 16px;
					font-weight:bold;
					margin-right:10px;
					text-align:center;
					cursor:pointer;
					display: inline-block;
				}

				p.callout {
				color:#ffffff; font-size:13px;
				text-align:center;
				background: #7d7e7d; /* Old browsers */
				background: -moz-linear-gradient(top,  #7d7e7d 0%, #0e0e0e 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#7d7e7d), color-stop(100%,#0e0e0e)); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(top,  #7d7e7d 0%,#0e0e0e 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(top,  #7d7e7d 0%,#0e0e0e 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(top,  #7d7e7d 0%,#0e0e0e 100%); /* IE10+ */
				background: linear-gradient(to bottom,  #7d7e7d 0%,#0e0e0e 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#7d7e7d", endColorstr="#0e0e0e",GradientType=0 ); /* IE6-9 */
				 
				}
				.callout a {
				font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px;
					font-weight:bold;
					color:#66CCFF;
				}

				table.social {
				width:502px; 

				background:#D7E4EC; font-family:Arial, Helvetica, sans-serif;
					
				}
				.social .soc-btn {
					padding: 3px 7px;
					font-size:12px;
					margin-bottom:10px;
					text-decoration:none;
					color: #FFF;font-weight:bold;
					display:block;
					text-align:center;
				}
				a.fb { background-color: #3B5998!important; }
				a.tw { background-color: #1daced!important; }
				a.gp { background-color: #DB4A39!important; }
				a.ms { background-color: #000!important; }

				.sidebar .soc-btn { 
					display:block;
					width:100%;
				}


				table.head-wrap { width: 100%; 
				}

				.header.container table td.logo { padding: 15px; }
				.header.container table td.label { padding: 15px; padding-left:0px;}



				table.pie {width:99% !important; text-align:center;}
				table.pie tr td p{ font-size:10px; font-family:Arial, Helvetica, sans-serif; color:#999;}

				.purchase { display:inline-block;
				font-family:Arial, Helvetica, sans-serif;
				height: auto;
				float: none;

				margin: 0px 23px 10px 23px;
				padding: 21px 0px 21px 31px;
				width:520px;
				}
				.purchase-text {
				margin-top:26px;
				width: 321px;
				height: auto;
				float: right;}
				.purchase-text h1 {
				font: Bold 18px Arial, Helvetica, sans-serif;
				color: #212121;}

				.purchase-buttion {
				width: 160px;
				height: auto;
				float: left;}

				table.body-wrap { width: 100%;}

				table.deposito-activo { width:560px !important; border: 1px solid #ddd; border-collapse:collapse; margin:0 auto; margin-bottom:30px !important;
				background: #ffffff;}
				table.deposito-activo thead tr th {font-weight:normal;font-size:12px; color: #222222; font-family:Verdana, Arial, Helvetica, sans-serif; padding:6px;background: #f6f8f9; /* Old browsers */
				background: -moz-linear-gradient(top,  #f6f8f9 0%, #e5ebee 50%, #d7dee3 100%, #f5f7f9 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6f8f9), color-stop(50%,#e5ebee), color-stop(100%,#d7dee3), color-stop(100%,#f5f7f9)); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(top,  #f6f8f9 0%,#e5ebee 50%,#d7dee3 100%,#f5f7f9 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(top,  #f6f8f9 0%,#e5ebee 50%,#d7dee3 100%,#f5f7f9 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(top,  #f6f8f9 0%,#e5ebee 50%,#d7dee3 100%,#f5f7f9 100%); /* IE10+ */
				background: linear-gradient(to bottom,  #f6f8f9 0%,#e5ebee 50%,#d7dee3 100%,#f5f7f9 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#f6f8f9", endColorstr="#f5f7f9",GradientType=0 ); /* IE6-9 */
				}
				table.deposito-activo tbody tr td {border: 1px solid #ddd; padding:6px; font-size:11px; color:#333; font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; background:none;}
				table.deposito-activo tbody tr td.cantidad {text-align:center; background:none;}

				table.deposito { margin:30px 0px; border-collapse:collapse;}
				table.deposito thead tr th { font-size:13px; color:#333333; font-weight:normal; border:1px solid #e4e4e4; background:none; }
				table.deposito tbody tr td { border:1px solid #e4e4e4; font-size:12px; color:#444444; background:none;}
				table.deposito tbody tr td.referencia { font-size:12px; color:#444444; text-align:center; background:none;}


				table.medio { margin-top:40px; border-collapse:collapse; width:60% !important; float:right; font-family:Arial, Helvetica, sans-serif}
				table.medio thead tr th { font-size:12px; color: #2C2C2C; font-weight:normal; background:#ddd;}
				table.medio tbody tr td { border:1px solid #e4e4e4; font-size:12px; color:#504b4b; background:none; text-align:center;}
				table.medio tbody tr td.referencia { font-size:12px; color:#504b4b; text-align:center; background:none;}


				td.sociales {text-align:right;}


				table.footer-wrap { width: 60%;	clear:both!important;font-size:9px; margin-top:60px !important;}
				.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
				.footer-wrap .container td.content p {
					font-size:9px;
					font-weight: bold;
					
				}
				td p img {background: #98bbe0;
				background: -moz-linear-gradient(top, #98bbe0 0%, #23538a 100%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#98bbe0), color-stop(100%,#23538a));
				background: -webkit-linear-gradient(top, #98bbe0 0%,#23538a 100%);
				background: -o-linear-gradient(top, #98bbe0 0%,#23538a 100%);
				background: -ms-linear-gradient(top, #98bbe0 0%,#23538a 100%);
				background: linear-gradient(to bottom, #98bbe0 0%,#23538a 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#98bbe0", endColorstr="#23538a",GradientType=0 );}


				h1,h2,h3,h4,h5,h6 {

				}
				h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

				h1 { font-weight:200; font-size: 44px;}
				h2 { font-weight:200; font-size: 37px;}
				h3 { padding:9px; font-weight:bold; font-size: 22px; text-align:center; margin-top:20px; margin-bottom:8px; color: #fff; font-family:Arial, Helvetica, sans-serif;}
				h4 { font-weight:500; font-size: 23px;}
				h5 { font-weight:100; font-size: 12px; font-family:Arial, Helvetica, sans-serif; color:#286488}
				h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

				.collapse { margin:0!important;}

				p, ul { 
					font-weight: normal; 
					font-size:14px; 
					line-height:1.6;
				}
				p.lead { padding:6px; font-size:15px;color: #fff; font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; margin-bottom:20px; line-height:17px;}
				p.last { margin-bottom:0px;}

				ul li {
					margin-left:5px;
					list-style-position: inside;
				}


				ul.sidebar {
					background:#ebebeb;
					display:block;
					list-style-type: none;
				}
				ul.sidebar li { display: block; margin:0;}
				ul.sidebar li a {
					text-decoration:none;
					color: #666;
					padding:10px 16px;

					margin-right:10px;

					cursor:pointer;
					border-bottom: 1px solid #777777;
					border-top: 1px solid #FFFFFF;
					display:block;
					margin:0;
				}
				ul.sidebar li a.last { border-bottom-width:0px;}
				ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}




				.container {
					display:block!important;
					max-width:600px!important;
					margin:0 auto!important;
					clear:both!important;
				}


				.imagenes { background:; z-index:999999999; min-height:60px; margin-bottom:40px;}
				table.customer {width:88% !important; font-family:Arial, Helvetica, sans-serif;}
				.imagenes table.customer thead tr th { font-size:21px; color:#333; font-weight:bold; padding-top:6px;}
				.imagenes table.customer tbody tr td {font-size:14px; color:#444; text-align:center;}
				.content {
				webkit-box-shadow: rgba(0,0,0,0.6) 0px 0px 18px;
				box-shadow: rgba(0,0,0,0.6) 0px 0px 18px;
					width:600px;
					margin:0 auto;
					display:block;
					background:#fff;
					border:1px solid #909BA8;
				}
				.content img {margin:0 auto;}


				.content table {
				width: 600px;
				margin: 0 auto;
				}


				.column {
					width: 300px;
					float:left;
				}
				.column tr td { padding: 15px; }
				.column-wrap { 
					padding:0!important; 
					margin:0 auto; 
					max-width:600px!important;
				}
				.column table { width:100%;}
				.social .column {
					width: 280px;
					min-width: 279px;
					float:left;
				}

				.clear { display: block; clear: both; }
			</style>

		</head>
		<body>
		<!-- BODY -->
			<table class="body-wrap">
				<tr>
					<td class="container">

						<div class="content">
							<img src="'.$PATHRAIZ.'/img/fondo4.png">
        					<div class="imagenes">
        						<table class="customer">
        							<thead>
        								<tr>
        									<th>'.$SUB->getNombre().'</th>
        								</tr>
        							</thead>
        							<tbody>
        								<tr>
        									<td><!--Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue pretium lacus, sed vestibulum justo tristique non. Phasellus mollis vel turpis sed consequat.--></td>
        								</tr>
        							</tbody>
						        </table>
							</div>

							<table class="deposito-activo" style="margin-bottom:60px;">
								<thead>
									<tr>
										<th>Banco</th>
										<th>Cuenta</th>
										<th>CLABE</th>';

									$idCliente = $idSubCadena;

									if($idCliente > 0){
										$sql = $RBD->query("CALL `afiliacion`.`SP_CLIENTE_SUB_LOAD`($idCliente)");
										$res = mysqli_fetch_assoc($sql);
									}


									if($idCliente > 0){
										$CLIENTE = new AfiliacionCliente($RBD, $WBD, $LOG);
										$CLIENTE->loadClienteReal($idSubCadena, 1);

										$SUB = new SubCadena($RBD, $WBD);
										$res = $SUB->load($idSubCadena);
										if($res['codigoRespuesta'] == 0){
											$referenciaBancaria = $SUB->getReferenciaBancaria();
										}
										else{
											$referenciaBancaria = "N/A";
										}

										$tbl .= '<th>Inversi&oacute;n por Tienda</th>';

										if($CLIENTE->TIPOFORELO == 1){
											$tbl .= '<th>Referencia</th>';
										}

										$tbl .= '<th>Inversi&oacute;n Total</th>';

										$sql2 = $RBD->query("CALL afiliacion.SP_COSTO_FIND($CLIENTE->IDCOSTO, $CLIENTE->IDNIVEL)");
										$res2 = mysqli_fetch_assoc($sql2);
										$costo = $CLIENTE->COSTO/*$res2['Afiliacion']*/;

										$sqlC = $RBD->query("SELECT COUNT(*) AS `cuenta` FROM `afiliacion`.`dat_sucursal` WHERE idSubcadena = $idCliente AND `idEstatus` IN(1, 0)");
										$res = mysqli_fetch_assoc($sqlC);
										$oAf->NUMEROCORRESPONSALES = $res['cuenta'];
										$costoTotal = $CLIENTE->PAGO_PENDIENTE;
									}

									$tbl .= '</tr>
								</thead>
								<tbody>';

									$QUERY = "CALL `afiliacion`.`SP_CUENTA_BANCARIA_LISTA`(0, 0, 1, 0)";
									$sql = $RBD->query($QUERY);

									if(!$RBD->error()){
										$result = array();
										while($row = mysqli_fetch_assoc($sql)){
											$result[] = $row;
										}
									}

									$rowspan = count($result);
									$rowspan = ($rowspan == 0)? 1 : $rowspan;

									$vuelta = 1;

									foreach($result as $key => $res){
										$tbl .= '<tr>';
											$tbl.= '<td>'.(!preg_match('!!u', $res['nombreBanco'])? utf8_encode($res['nombreBanco']) : $res['nombreBanco']).'</td>';
											$tbl.= '<td>'.$res['numCuenta'].'</td>';
											$tbl.= '<td>'.$res['CLABE'].'</td>';

										if($vuelta == 1){
											if($idCliente > 0){
												$tbl .= '<td class="cantidad" rowspan="'.$rowspan.'">$'.number_format($costo, 2).'</td>';
											}

											if($CLIENTE->TIPOFORELO == 1){
												$tbl .= '<td rowspan="'.$rowspan.'">'.$referenciaBancaria.'</td>';
											}

											if($idCliente > 0){
												$tbl .= '<td class="cantidad" rowspan="'.$rowspan.'">$'.number_format($costoTotal, 2).'</td>';
											}
										}
										$vuelta++;
										$tbl.= '</tr>';
									}
									$tbl .= '</tbody>
							</table>';

							$tbl .= '<img src="'.$PATHRAIZ.'/img/espacio.png">';

							/* Buscar las sucursales */
							$limit = 1000;
							$QUERY = "CALL `afiliacion`.`SP_SUCURSAL_LISTA`(0, 0, 'ASC', '', 0, $limit, $idSubCadena)";
							$sql = $RBD->query($QUERY);

							$tbl .= '<table class="deposito-activo">
								<thead>
									<tr>
										<th>Sucursal</th>';
							if($CLIENTE->TIPOFORELO == 2){
								$tbl .= '<th>Referencia</th>';
							}
							$tbl .= '</tr>
								</thead>
								<tbody>';

							if(!$RBD->error()){
								$sucursales = array();
								$referenciasEncontradas = 0;

								while($row = mysqli_fetch_assoc($sql)){
									if($TIPOFORELO == 1){
										$row['idRefBancaria'] = "";
										$row['referenciaBancaria'] = "";
									}
									else{
										$sucursales[] = array(
											"idSucursal"	=> $row['idSucursal'],
											"idRefBancaria"	=> $row['idRefBancaria']
										);
									}

									$nombre = !preg_match("!!u", $row['NombreSucursal'])? utf8_encode($row['NombreSucursal']) : $row['NombreSucursal'];

									$tbl.= "<tr><td>".$nombre."</td>";
									if($CLIENTE->TIPOFORELO == 2){
										$tbl.= "<td>".$row['referenciaBancaria']."</td>";
									}
									$tbl.="</tr>";
								}
								

								if($referenciasEncontradas > 0){
									$SENDMAIL = true;
								}
								else{
									$response = array(
										'showMsg'	=> 1,
										'msg'		=> "No se envió ningún correo debido a que las sucursales no cuentan con referencia bancaria"
									);
								}
							}
							$tbl .= '</tbody></table>';

							$tbl .= '<table class="footer-wrap">
								<tr>
									<td class="container">

										<table class="pie">
											<tr>
												<td colspan="2">
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam velit est, molestie id mi non, iaculis blandit augue. Ut lobortis congue erat, in aliquet nisi facilisis ac. Quisque leo magna, eleifend nec lacus a, sodales tincidunt sapien.<br/>
													<a href="www.redefectiva.com">Red Efectiva</a> phasellus adipiscing nisl vitae elit fringilla sodales. Sed interdum porttitor nunc.</p>
												</td>
											</tr>
											<tr>
												<td>
													<a href="#">
														<img src="'.$PATHRAIZ.'/img/fb.png" /></a>&nbsp;<a href="#"><img src="'.$PATHRAIZ.'/img/tt.png" /></a></td> <td><img src="'.$PATHRAIZ.'/img/logo.png">
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
<!-- /FOOTER -->
</div>
</body>
</html>';

//echo $tbl;