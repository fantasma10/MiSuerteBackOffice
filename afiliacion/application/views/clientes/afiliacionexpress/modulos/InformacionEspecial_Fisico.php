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
					<label><input type="checkbox"  name="bPoliticamenteExpuesto" id="txtPoliticamenteExpuesto" class="ro"> Persona Políticamente Expuesta</label>
				</div>	 
			</div>
			<div class="row">
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Fecha de Nacimiento<span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="dFechaNacimiento" id="txtFechaNacimiento">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">C.U.R.P.<span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sCURP" id="txtCURP" style="text-transform: uppercase;">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Tipo de Identificación <span class="asterisco">*</span></label>
						<select class="form-control" name="nIdTipoIdentificacion" id="cmbIdTipoIdentificacion">
							<option value="-1">--</option>
                            <?php echo $tipoID; ?>
                           
						</select>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">No. de Identificación <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sNumeroIdentificacion" id="txtNumeroIdentificacion" maxlength="15">
					</div>
				</div> 
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">País de Nacimiento <span class="asterisco">*</span></label>
						<select class="form-control" name="nIdPaisNacimiento" id="cmbIdPaisNacimiento">
							<option value="-1">--</option>
                            <?php echo $paises;?>
						</select>
					</div>
				</div> 
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Nacionalidad</label>
						<select class="form-control" name="nIdNacionalidad" id="cmbIdNacionalidad">
							<option value="-1">--</option>
                             <?php echo $nacionalidades;?>
						</select>
					</div>
				</div> 
			</div>
		</form>
	</div>
</div>