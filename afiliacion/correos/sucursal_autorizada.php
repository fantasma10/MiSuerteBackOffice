<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
		<title>Título</title>
	</head> 
	<body style="background-color: #ffffff; margin:0; padding:0; color: #777777;"> 
		<table width="600" height="501" align="center" style="background-image:url('bg.jpg');">
			<tr>
				<td valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td align="center">
									<table width="580">
										<tbody>  
											<tr> 
												<td align="left" style="padding-left:15px; padding-top:30px;"><a href=""><img src="<?php echo base_url()?>img/correos/logo.png" style="border:none;display:block;" alt=""></a></td> 
											</tr>  
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center" valign="top"> 
									<table width="558" border="0" cellspacing="0" cellpadding="0" style="width:558px;">
										<tbody>  
											<tr>
												<td align="center" style="padding-top:25px; padding-bottom:30px;">
													<table width="513" cellspacing="0" cellpadding="0" border="0" style="font-family: &#39;Lucida Sans Unicode&#39;,&#39;Lucida Grande&#39;,sans-serif,Arial,Verdana; font-size: 12px;"> 
														<tr>
															<td colspan="3"><img src="<?php echo base_url()?>img/correos/spacer.gif" style="display:block;" width="1" height="10" alt=""></td>
														</tr>
														<tr>
															<td valign="top">
																<p style="font-size: 17px; color: #000000; padding-top:5px;">Hola, <span style="color:#305D92;"><?php echo utf8_encode($oSucursal->sRazonSocial);?></span></p>
																<p style="color:#000000;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p> 
																<p>Lorem ipsum dolor sit amet, consectetur.</p>
																<p>
																	<span style="color:#333;">Nombre de Sucursal:</span><br><span><?php echo utf8_encode($oSucursal->sNombreSucursal);?></span>    
																</p>
															</td>
															<td><img src="<?php echo base_url()?>img/correos/spacer.gif" style="display:block;" width="25" height="5" alt=""></td>
															<td><img src="<?php echo base_url()?>img/correos/img_07.jpg" alt="Image" style="display:block;"></td>
														</tr>
													</table>
												</td> 
											</tr>
											<tr>
												<td colspan="3">
													<img src="<?php echo base_url()?>img/correos/spacer.gif" align="center" style="display:block;" width="1" height="10" alt="">
												</td>
											</tr>  
											<tr> 
												<td>
													<table width="400" align="center" border="0" cellspacing="0" cellpadding="2" style="font-family: &#39;Lucida Sans Unicode&#39;,&#39;Lucida Grande&#39;,sans-serif,Arial,Verdana; font-size: 12px;">
														<tbody>
															<tr>
																<td><span style="font-size: 12px; color:#000000; font-weight:normal;">Sígue a Red Efectiva:</span></td>
																<td><img src="<?php echo base_url()?>img/correos/facebook.png" alt="Facebook" width="22" height="23" style="border:none;"></td>
																<td><a href="<?php echo URL_FACEBOOK;?>" style="color:#777777; font-size:14px; text-decoration:none;">Facebook</a></td>
																<td><img src="<?php echo base_url()?>img/correos/twitter.png" alt="Twitter" width="22" height="22" align="absmiddle" style="border:none;"></td>
																<td><a href="<?php echo URL_TWITTER;?>" style="color:#777777; font-size:14px; text-decoration:none;">Twitter</a></td> 
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td align="center" style="padding-top:15px;"> 
													&nbsp;
												</td>
											</tr>
											<tr>
												<td>
													<table width="510" align="center" border="0" cellspacing="0" cellpadding="0" style="font-family: &#39;Lucida Sans Unicode&#39;,&#39;Lucida Grande&#39;,sans-serif,Arial,Verdana; font-size: 12px;">
														<tbody>
															<tr>
																<td valign="top"> 
																	<p style="color:#3B669B;">
																		<span style="color:#000000">Red Efectiva</span>
																		<br/>
																		Blvd. Antonio L. Rodríguez 3058, Plaza Delphi,Col. Sta. María. Monterrey N.L. 64650
																		<br/>
																		<span style="color:#000000">T: </span>+52(81) 8356 2600
																		<br/>
																		<span style="color:#000000">E: </span><a href="mailto:<?php echo CORREO_ELECTRONICO_MAILTO;?>" style="color: #04a8e3;"><?php echo CORREO_ELECTRONICO_MAILTO;?></a>
																	</p>
																</td>
															</tr> 
															<tr> 
																<td>&nbsp;</td>
															</tr> 
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table> 
	</body>
</html>