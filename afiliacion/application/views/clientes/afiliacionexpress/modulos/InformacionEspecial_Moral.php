<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
	<div class="panel-heading">
		<h4 class="panel-title">Información Especial</h4>
			<div class="panel-controls panel-controls-right">
				<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
			</div>
	</div> 
	<div class="panel-body">
		<form name="informacionEspecial" id="formInformacionEspecial">
			<div class="row mb10">
				<div class="col-xs-6">
					<label><input type="checkbox" value="0" name="bPoliticamenteExpuesto" id="chkPoliticamenteExpuesto" class="ro"> Persona Políticamente Expuesta</label>
				</div>	 
			</div>
			<div class="row "> 
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Tipo de Sociedad <span class="asterisco">*</span></label>
						<select class="form-control" name="nIdTipoSociedad" id="cmbIdTipoSociedad">
							<option value="-1">--</option>
                            <?php echo $sociedad; ?>
						</select>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Fecha Constitutiva <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="dFechaConstitutiva" id="txtFechaConstitutiva">
					</div>
				</div> 
				<!--<div class="col-xs-4"> 
						<label class="">R.F.C. Razón Social  <span class="asterisco">*</span></label><br>
						<input type="file" class="" style="display:inline-block;"><br>
						<span class="help-text"></span>
				</div> -->
				<div class="col-xs-4"> 
						<label class="">Acta Constitutiva  <span class="asterisco">*</span></label><br>
						<input type="file" class="hidess" style="display:inline-block;" name="sFileActaConstitutiva" id="fileActaConstitutiva" idtipodoc="3">
                    <input type="button" id="btnFileActa" value="Ver Documento">
                    <br>
						<input type="hidden" class="" style=";" name="nIdDocActaConstitutiva" id="txtIdDocActaConstitutiva" idtipodoc="3"><br>
						<span class="help-text"></span>
				</div> 
			</div>
		</form>
	</div>
</div>