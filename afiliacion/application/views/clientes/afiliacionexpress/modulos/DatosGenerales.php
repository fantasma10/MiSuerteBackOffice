<div id="content" class="page-content clearfix">
	<div class="contentwrapper">
		<!--Content wrapper-->
		<div class="heading">
			<!--  .heading-->
			<h3>Alta de Cliente "<?php //echo strtoupper($oProspecto->sRFC);?>"</h3>  
		
		</div> 
		
			<form name="datosGenerales" id="formDatosGenerales">
				<div class="panel-heading">
					<h4 class="panel-title">Datos Generales</h4>
						<div class="panel-controls panel-controls-right">
							<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
						</div>
				</div> 
				<div class="panel-body">  
					<div class="row ">
						<div class="col-xs-2">
							<div class="form-group">
								<label class="">R.F.C.<span class="asterisco">*</span></label>
								<input type="text" class="form-control" placeholder="MAHY670331HJI" disabled="" name="sRFC" id="txtRFC">
							</div>
						</div> 
						<div class="col-xs-2">
							<div class="form-group">
								<label class="">Regimen Fiscal <span class="asterisco">*</span></label>
								<select class="form-control" disabled="" name="nIdRegimen" id="cmbRegimen"> 
									<!-- <option>--</option> -->
								</select>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="">Cadena</label>
								<input type="text" class="form-control" name="sCadena" id="txtSCadena">
								<input type="hidden" name="nIdCadena" id="txtIdCadena">
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="">Socio</label>
								<select class="form-control" name="nIdSocio" id="cmbSocio">
									<option>--</option>
								</select>
							</div>
						</div>
					</div>
                        
					<?php 
                    include('./application/afiliacionexpress/modulos/datosgenerales_fisico.php');
						/*if($oProspecto->nIdTipoPersona == 1){
							$CI =& get_instance();
							$CI->load->
						}
						if($oProspecto->nIdTipoPersona == 2){
							$CI =& get_instance();
							$CI->load->view('clientes/afiliacionexpress/modulos/datosgenerales_moral.php');
						}*/
					?>

					<div class="row">
						<div class="col-xs-2">
							<div class="form-group">
								<label class="">Teléfono<span class="asterisco">*</span></label>
								<input type="text" class="form-control" name="sTelefono" id="txtTelefono" placeholder="(00) 00-00-00-00">
							</div>
						</div> 
						<div class="col-xs-4">
							<div class="form-group">
								<label class="">Correo Electrónico</label>
								<input type="text" class="form-control" name="sEmail" id="txtEmail">
							</div>
						</div> 
						<div class="col-xs-6">
							<div class="form-group">
								<label class="">Ejecutivo de Cuenta <span class="asterisco">*</span></label>
								<select class="has-error form-control" name="nIdEjecutivoCuenta" id="cmbEjecutivoCuenta">
									<option>--</option> 
								</select>
							</div>
						</div>
					</div>
					<?php
						/*if($oProspecto->nIdPais == 164){
							$CI->load->view('clientes/afiliacionexpress/modulos/datosgenerales_direccionnacional');
						}
						else if($oProspecto->nIdPais > 0){
							$CI->load->view('clientes/afiliacionexpress/modulos/datosgenerales_direccionextranjera');
						}*/
					?>
					<div class="row">
						<div class="col-xs-4"> 
							<label class="">R.F.C. <span class="asterisco">*</span></label><br>
							<input type="file" class="" style="display:inline-block;" name="sFileRFC" id="txtFileRFC" idtipodoc="2">
                            <input type="button" id="btnFileRfc" value="Ver RFC">
                            <br>
							<input type="hidden" class="" name="nIdDocRFC" id="txtIdDocRFC" idtipodoc="2"><br>
							<span class="help-text"></span>
						</div>
						<div class="col-xs-4"> 
                            <label class="">Comprobante Domicilio <span class="asterisco">*</span></label><br>
							<input type="file" class="" style="display:inline-block;" name="sFileComprobanteDomicilio" id="sFileComprobanteDomicilio" idtipodoc="1"><br>
							<input type="hidden" class="" name="nIdDocDomicilio" id="txtIdDocDomicilio" idtipodoc="1"><br>
							<span class="help-text"></span>
						</div>
					</div>
				</div>
			</form>
		</div>

		<?php
			/*if($oProspecto->nIdTipoPersona == 1){
				$CI->load->view('clientes/afiliacionexpress/modulos/InformacionEspecial_Fisico.php');
			}
			else if($oProspecto->nIdTipoPersona == 2){
				$CI->load->view('clientes/afiliacionexpress/modulos/InformacionEspecial_Moral.php');
			}
			$CI->load->view('clientes/afiliacionexpress/modulos/Configuracion.php', $lista_familias);
			$CI->load->view('clientes/afiliacionexpress/modulos/PaqueteComercial.php', $paquete_comercial);
			$CI->load->view('clientes/afiliacionexpress/modulos/DatosBancarios.php');
			$CI->load->view('clientes/afiliacionexpress/modulos/Contactos.php');*/
		?>
		<button type="button" class="btn btn-primary btn-sm pull-right" id="btnGuardarSolicitud">Guardar Solicitud</button>
            
       	</div>     
	</div>
</div>

