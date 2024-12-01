
<!-- Formulario para Expediente Avanzado -->

<!-- Datos Generales -->
<div class="well">
	<form class="form-horizontal" name="formGenerales" id="formGenerales">
		<input type="hidden" name="idCliente" value="-1">
		<div class="titulosexpress-first">
			 Datos Generales
		</div>
												
		<div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Cadena:</label>
			<br/>
				<input type="hidden" class="form-control m-bot15" name="idCadena" id="idCadena">
				<input type="text" class="form-control m-bot15" name="txtCadena" id="txtCadena">
			</div>
            
            
            <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Grupo:</label>
			<br/>
				<select class="form-control m-bot15" name="idGrupo" id="cmbGrupo">
				</select>
			</div>
            
            <div class="form-group col-xs-4">
			<label class="control-label">Referencia:</label>
			<br/>
				<select class="form-control m-bot15" name="idReferencia" id="cmbReferencia">
				</select>
			</div>
	
															 
		<div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Régimen Fiscal:</label>
			<br/>
				<select class="form-control m-bot15" name="tipoPersona" id="cmbTipoPersona" id="cmbTipoPersona">
				</select>
			</div>

	        <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">RFC:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="RFC" id="txtRFC">
			</div>
	
												
			<div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Giro:</label>
			<br/>
				<select class="form-control m-bot15" name="idGiro" id="cmbGiro">
				</select>
			</div> 

        	<div class="form-group col-xs-8 personamoral">
			<label class="control-label personamoral2">Razón Social:</label>
			<br/>
				<input type="text" class="form-control m-bot15 personamoral2" name="razonSocial">
			</div>
		
		<div class="form-group col-xs-4 personafisica" style="margin-right:16px;">
			<label class="control-label">Nombre(s):</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="nombrePersona">
			</div>

            <div class="form-group col-xs-4 personafisica" style="margin-right:16px;">
			<label class="control-label">Apellido Paterno:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="apPPersona">
			</div>

       	    <div class="form-group col-xs-4 personafisica">
			<label class="control-label">Apellido Materno:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="apMPersona">
		    </div>

		<div class="form-group col-xs-4 personamoral2" style="margin-right:16px;">
			<label class="control-label">Fecha Constitutiva:</label>
			<br/>
				<input class="form-control form-control-inline input-medium default-date-picker" name="fecAltaRPPC" id="fecAltaRPPC" onkeypress="return validaFecha(event,'fecAltaRPPC')" onkeyup="validaFecha2(event,'fecAltaRPPC')" maxlength="10">
				<span class="help-block">Seleccionar Fecha.</span>
			</div>
             
            <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Teléfono:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="telefono" id="txttelefono" onkeyup="validaTelefono2(event,'txttelefono')" onkeypress="return validaTelefono1(event,'txttelefono')">
			</div>

            <div class="form-group col-xs-4">
			<label class="control-label">Correo:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="email" id="txtemail">
			</div>
		
	</form>
</div>
<!-- Direccion -->
<div class="well">
	<form class="form-horizontal" name="formDireccion" id="formDireccion">
		<input type="hidden" name="idDireccion" id="idDireccion" value="0">
        <input type="hidden" name="origen" id="origen" value="0" />
		<div class="titulosexpress-first">
			Dirección Fiscal
		</div>

		 <div class="form-group col-xs-4" style="margin-right:16px;">	
			<label class="control-label">País:</label>
			<br/>
				<input type="hidden" class="form-control m-bot15" name="idPais" id="idPais" value="164">
				<input type="text" class="form-control m-bot15" name="txtPais" id="txtPais" value="">
			</div>
            
            
            <div class="form-group col-xs-4" style="margin-right:16px;">	
			<br/>
				
			</div>
            
            <div class="form-group col-xs-4">	
			</div>
            
            
            
        <div class="form-group col-xs-4" style="margin-right:16px;">										 
	    <label class="control-label">Calle:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="calleDireccion" id="txtCalle">
			</div>

            <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Número Interior:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="numeroIntDireccion">
			</div>

            <div class="form-group col-xs-4">
			<label class="control-label">Número Exterior:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="numeroExtDireccion">
			</div>
		
														 
		<div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Código Postal:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCP">
				<input type="hidden" class="form-control m-bot15" name="idLocalidad" id="idLocalidad">
			</div>
            
           <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Colonia:</label>
			<br/>
				<select class="form-control m-bot15" name="idcColonia" id="cmbColonia">
					<option value="-1">Seleccione</option>
				</select>
			</div>


	   	 <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Estado:</label>
			<br/>
				<select class="form-control m-bot15" name="idcEntidad" id="cmbEstado">
					<option value="-1">Seleccione</option>
				</select>
			</div>

 <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Ciudad:</label>
			<br/>
				<select class="form-control m-bot15" name="idcMunicipio" id="cmbMunicipio">
					<option value="-1">Seleccione</option>
				</select>
			</div> 

	</form>
</div>
<div class="well">
	<form class="form-horizontal">
		<div class="titulosexpress-first">
	 Configuración de Acceso
		</div>

		<!--div class="form-group">
			<label class="col-lg-2 control-label">Tipo de Cliente:</label>
			<div class="col-lg-2">
				<select class="form-control m-bot15" id="ddlTipoCliente">
					<option value="-1">Seleccione</option>
					<option value="1">Integrado</option>
					<option value="0">Red Efectiva</option>
				</select>
			</div>
		</div-->

		 <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Tipo de Acceso:</label>
			<br />
				<select class="form-control m-bot15" id="ddlTipoAcceso" name="idTipoAcceso">
					<option value="-1">Seleccione</option>
				</select>
			</div>
	

	</form>
</div>
<!-- Representante Legal -->
<div class="well">
	<form class="form-horizontal" name="formRepresentante" id="formRepresentante">
		<div class="titulosexpress-first">
		Representante Legal
		</div>

		 <div class="form-group col-xs-4" style="margin-right:16px;">
			<input type="hidden" name="idRepLegal" value="0" id="idRepLegal">
			<label class="control-label">RFC:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="RFCRepreLegal" id="txtRFCRep">
			</div>

           <div class="form-group col-xs-4">
           </div>
           
            <div class="form-group col-xs-4">
            </div>

		 <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Nombre(s):</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="nombreRepLegal">
			</div>

            <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Apellido Paterno</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="apPRepreLegal">
			</div>

            <div class="form-group col-xs-4">
			<label class="control-label">Apellido Materno:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="apMRepreLegal">
			</div>
		
		
			<!--label class="col-xs-2 control-label">RFC:</label>
			<div class="col-xs-2">
				<input type="text" class="form-control m-bot15" name="RFCRepreLegal" id="txtRFCRep">
			</div-->
            <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">Tipo Identificación:</label>
			<br/>
				<select class="form-control m-bot15" name="idTipoIdent" id="cmbIdent">
				<option>--</option>
				<option>IFE</option>
				<option>Pasaporte</option>
				</select>
			</div>

 <div class="form-group col-xs-4" style="margin-right:16px;">
			<label class="control-label">No. Identificación:</label>
			<br/>
				<input type="text" class="form-control m-bot15" name="numIdentificacion">
			</div>
	<br/>

		 <div class="form-group col-xs-4" style="margin-right:16px; margin-top:20px;">
			<label class="control-label">Figura Políticamente Expuesta:</label>
			
				<input type="checkbox" class="pull-right" name="figPolitica">
			</div>

             <div class="form-group col-xs-4" style="margin-right:16px; margin-top:20px;">
			<label class="control-label">Familia Políticamente Expuesta:</label>
			
				<input type="checkbox" class="pull-right" name="famPolitica">
			</div>
		</div>
	</form>  
</div>

<!--a href="#" id="btnAnterior" class="noesconsulta"><button class="btn btn-xs btn-info pull-left">Anterior</button></a> 
<a href="#" onclick="guardarDatosGenerales();" class="noesconsulta boton_guardar"><button class="btn btn-xs btn-info pull-right">Siguiente</button></a>


<a href="#" id="btnRegresar" class="esconsulta"><button class="btn btn-xs btn-info pull-left">Regresar</button></a> 
<a href="#" onclick="guardarDatosGenerales2();" class="esconsulta boton_guardar"><button class="btn btn-xs btn-info pull-right">Guardar</button></a-->


<!--- href="#sdfformnew2.php" onclick=""><button class="btn btn-xs btn-info pull-right">Siguiente</button></a-->