<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="div-representanteLegal"> 
	<div class="panel-heading">
		<h4 class="panel-title">Representante Legal</h4>
			<div class="panel-controls panel-controls-right">
				<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
			</div>
	</div> 
	<div class="panel-body">
		<form name="representanteLegal" id="formRepresentanteLegal">
			<div class="row mb10">
				<div class="col-xs-6">
					<label><input type="checkbox" value="" name="bPoliticamenteExpuestoRepresentante" id="chkPoliticamenteExpuestoRepresentante" class="ro"> Persona Políticamente Expuesta</label>
				</div>
			</div>
			<div class="row">
                <div class="col-xs-2">
					<div class="form-group">
						<label class="">R.F.C. <span class="asterisco">*</span></label>
						<input type="text" class="form-control mayusculas" name="sRFCRepresentante" id="txtRFCRepresentante">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Nombre (s) <span class="asterisco">*</span></label>
						<input type="text" class="form-control mayusculas" name="sNombreRepresentante" id="txtNombreRepresentante">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Apellido Paterno <span class="asterisco">*</span></label>
						<input type="text" class="form-control mayusculas" name="sPaternoRepresentante" id="txtPaternoRepresentante">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Apellido Materno <span class="asterisco">*</span></label>
						<input type="text" class="form-control mayusculas" name="sMaternoRepresentante" id="txtMaternoRepresentante">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Fecha de Nacimiento <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="dFechaNacimientoRepresentante" id="txtFechaNacimientoRepresentante">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Nacionalidad <span class="asterisco">*</span></label>
						<select class="form-control" name="nIdNacionalidadRepresentante" id="cmbNacionalidadRepresentante">
                            <option value="-1">--</option>
                             <?php echo $nacionalidades;?>
						</select>
					</div>
				</div>
				
			</div> 
			<div class="row ">  
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">C.U.R.P. <span class="asterisco">*</span></label>
						<input type="text" class="form-control mayusculas" name="sCURPRepresentante" id="txtCURPRepresentante">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Tipo de Identificación <span class="asterisco">*</span></label>
						<select class="form-control" name="nIdTipoIdentificacionRepresentante" id="cmbTipoIdentificacionRepresentante">
							<option value="-1">--</option>
							 <?php echo $tipoID; ?>
						</select>
					</div>
				</div> 
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Número de Identificación <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sNumeroIdentificacionRepresentante" id="txtNumeroIdentificacionRepresentante">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Teléfono <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sTelefonoRepresentante" id="txtTelefonoRepresentante" placeholder="(00) 00-00-00-00">
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label class="">Correo Electrónico <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sEmailRepresentante" id="txtEmailRepresentante" placeholder="usuario@dominio.xyz">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Calle<span class="asterisco">*</span></label>
						<input type="text" class="form-control mayusculas" name="sCalleRepresentante" id="txtCalleRepresentante" maxlength="50">
					</div>
				</div>
				<div class="col-xs-1">
					<div class="form-group">
						<label class="">Num. Ext <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sNumExtRepresentante" id="txtNumExtRepresentante">
					</div>
				</div> 
				<div class="col-xs-1">
					<div class="form-group">
						<label class="">Num. Int <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sNumIntRepresentante" id="txtNumIntRepresentante">
					</div>
				</div>
				<div class="col-xs-1">
					<div class="form-group">
						<label class="">C.P.<span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="nCodigoPostalRepresentante" id="txtCodigoPostalRepresentante">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Colonia<span class="asterisco">*</span></label>
						<select class="form-control" name="nNumColoniaRepresentante" id="cmbColoniaRepresentante">
							<option></option>
						</select>
					</div>
				</div> 
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Ciudad<span class="asterisco">*</span></label>
						<select class="form-control" name="sMunicipioRepresentante" id="txtSMunicipioRepresentante" disabled="">
                            
						</select>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Estado<span class="asterisco">*</span></label>
						<select class="form-control" name="sEstadoRepresentante" id="txtSEstadoRepresentante" disabled="">
						</select>
					</div>
				</div>
				<div class="col-xs-1">
					<div class="form-group">
						<label class="">País <span class="asterisco">*</span></label>
						<input type="text" class="form-control" placeholder="México" disabled="" name="sPaisRepresentante" id="txtSPaisRepresentante" disabled="">
						<input type="hidden" class="form-control" name="nIdPaisRepresentante" id="txtIdPaisRepresentante">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<label class="">Ocupación <span class="asterisco">*</span></label>
						<select class="form-control" name="nIdOcupacionRepresentante" id="cmbOcupacionRepresentante">
							<option value="-1">--</option> 
                            <?php  echo $htmlOcupacion; ?>
						</select>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="form-group">
						<label class="">Identificación <span class="asterisco">*</span></label><br>
						<input type="file" class="hidess" style="display:inline-block;" name="sFileIdentificacionRepresentante" id="txtFileIdentificacionRepresentante" idtipodoc="5">
                        <input type="button" id="btnFileIdRL" value="Ver Documento"><br>
						<input type="hidden" class="" name="nIdDocIdentificacion" id="txtNIdDocIdentificacion" idtipodoc="5"><br>
						<span class="help-text"></span>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="form-group">
						<label class="">Poder</label><br>
						<input type="file" class="hidess" style="display:inline-block;" name="sFilePoderRepresentanteLegal" id="txtFilePoderRepresentanteLegal" idtipodoc="6">
                        <input type="button" id="btnFilePoderRL" value="Ver Documento"><br>
						<input type="hidden" class="" style="" name="nIdDocPoder" id="txtNIdDocPoder" idtipodoc="6"><br>
						<span class="help-text"></span>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>