<form id="frmDireccion">
	<div class="row">
		<div class="col-xs-3">
			<div class="form-group">
				<label class="">Latitud <span class="asterisco">*</span></label>
				<input type="text" class="form-control" name="nLatitud" id="txtNLatitud" disabled="disabled">
			</div>
		</div> 
		<div class="col-xs-3">
			<div class="form-group">
				<label class="">Longitud <span class="asterisco">*</span></label>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="#" id="aMapa" data-toggle="modal" data-target="#myModal">Mapa</a>
				<input type="text" class="form-control" name="nLongitud" id="txtNLongitud" disabled="disabled">
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<label class="">País<span class="asterisco">*</span></label>
				<select class="form-control form-control2" name="nIdPais" id="cmbPais">
					<option value="164">México</option>
                    <option value="68">Estados Unidos</option>
				</select>
			</div>
		</div>
	</div> 
	<div class="row ">
		<div class="col-xs-3">
			<div class="form-group">
				<label class="">Calle<span class="asterisco">*</span></label>
					<input type="text" class="form-control form-control2" name="sCalle" id="txtSCalle" maxlength="50">
				</div>
		</div>   
		<div class="col-xs-1">
			<div class="form-group">
				<label class="">Num. Ext <span class="asterisco">*</span></label>
				<input type="text" class="form-control form-control2" name="nNumExterno" id="txtNNumExterno" maxlength="10">
			</div>
		</div>
		<div class="col-xs-1">
			<div class="form-group">
				<label class="">Num. Int</label>
				<input type="text" class="form-control form-control2" name="sNumInterno" id="txtSNumInterno" maxlength="10">
			</div>
		</div>
		<div class="col-xs-1">
			<div class="form-group">
				<label class="">C.P.<span class="asterisco">*</span></label>
				<input type="text" class="form-control form-control2" name="nCodigoPostal" id="txtNCodigoPostal" maxlength="6">
			</div>
		</div>
		<div class="col-xs-2 dirext">
			<div class="form-group" id="div-colonia">
				<label class="">Colonia<span class="asterisco">*</span></label>
				<input type="text" class="form-control form-control2" name="sNombreColonia" id="txtSNombreColonia" disabled="disabled" maxlength="50">
			</div>
		</div> 
		<div class="col-xs-2 dirext">
			<div class="form-group">
				<label class="">Ciudad<span class="asterisco">*</span></label>
				<input type="text" class="form-control" name="sNombreMunicipio" id="txtSNombreMunicipio" disabled="disabled" maxlength="50">
				<input type="hidden" class="form-control form-control2" name="nNumMunicipio" id="txtNNumMunicipio">
			</div>
		</div>
		<div class="col-xs-2 dirext">
			<div class="form-group">
				<label class="">Estado<span class="asterisco">*</span></label>
				<input type="text" class="form-control" name="sNombreEstado" id="txtSNombreEstado" disabled="disabled" maxlength="50">
				<input type="hidden" class="form-control form-control2" name="nIdEstado" id="txtNIdEstado" disabled="disabled">
			</div>
		</div> 
        
        <!--aqui val los combos para mexivo -->
        
        <div class="col-xs-2 dirnac">
			<div class="form-group" id="div-colonia">
				<label class="">Colonia<span class="asterisco">*</span></label>
                <select class="form-control form-control2" name="nNumColonia" id="cmbColonia" disabled="disabled" maxlength="50">
                    <option value="-1">--</option>
                </select>
			</div>
		</div> 
		<div class="col-xs-2 dirnac">
			<div class="form-group">
				<label class="">Ciudad<span class="asterisco">*</span></label>
				  <select class="form-control form-control2" name="nNumCiudad" id="cmbCiudad" disabled="disabled" maxlength="50">
                    <option value="-1">--</option>
                </select>
			</div>
		</div>
		<div class="col-xs-2 dirnac">
			<div class="form-group">
				<label class="">Estado<span class="asterisco">*</span></label>
				  <select class="form-control form-control2" name="nNumEntidad" id="cmbEntidad" disabled="disabled" maxlength="50">
                    <option value="-1">--</option>
                </select>
			</div>
		</div> 
        
	</div> 
	<div class="row"> 
		<div class="col-xs-3">
			<div class="form-group">
				<label class="">Comprobante de Domicilio</label>
				<input type="file" name="sFile" id="txtNIdDocDomicilio" idtipodoc="1">
                <input type="button" id="btnFileCompDom" value="Ver Documento">
				<input type="hidden" name="nIdDocDomicilio" id="txtNIdDocDomicilios" idtipodoc="1">
			</div>
		</div>
	</div>
</form>