<div id="loadstep2" style="display: flex; justify-content: center;">
    <img src=<?php echo $PATHRAIZ.'/img/cargando3.gif' ?>>
</div>

<div id="contentStep2" style="display: none">

<div class="form-group col-lg-12">
    <h4><span><i class="fa fa-file-text"></i></span> Datos Generales</h4>
    <h5>*La siguiente información se actualiza únicamente en catálogo maestro.</h5>
</div>

<div class="form-group col-xs-12">
    <div class="form-group col-xs-3">
        <label class="control-label">País: </label>
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <select class="form-control m-bot15" name="cmbpais" id="cmbpais" disabled>
                <option value="-1">Seleccione</option>
                <?php echo $htmlPais; ?>
            </select>
        </span>
    </div>
    <div class="form-group col-xs-3" id="div-rfc">
        <label class="control-label">RFC: </label>
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <input type="hidden" id="p_cliente" name="p_cliente" value='<?php echo $parametro_cliente;?>'>
            <input type="text" id="rfc" class='form-control m-bot15' maxlength="12" disabled>
        </span>
    </div>
 </div>

<div id="divNombreApellidos" class="form-group col-xs-12">
    <div class="form-group col-xs-3">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class="control-label">Nombre (s)</label>
            <input type="text" class='form-control m-bot15 fisico mayusculas' name="sNombreCliente" maxlength="50" id="sNombreFisico" disabled>
        </span>
    </div>	
    <div class="form-group col-xs-3">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Apellido paterno:</label>
            <input type="text" class='form-control m-bot15 fisico mayusculas' name="sPaternoCliente" maxlength="50" id="sPaternoCliente" disabled>
        </span>
    </div>	
    <div class="form-group col-xs-3">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Apellido materno:</label>
            <input type="text" class='form-control m-bot15 fisico mayusculas' name="sMaternoCliente" maxlength="50" id="sMaternoCliente" disabled>
        </span>
    </div>
</div>		

<div class="form-group col-xs-12">
    <div id="razonSocialDiv" class="form-group col-xs-6">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class="control-label">Razón Social: </label>
            <input type="text" id="sRazonSocial" name="sRazonSocial" class='form-control m-bot15' style="text-transform: uppercase;" disabled onkeyup="Clonar()" maxlength="150">
        </span>
    </div>
    <div id="regimenCapitalDiv" class="form-group col-xs-6">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Régimen de Capital:</label>
            <input type="text" id="regimenCapital" class='form-control m-bot15' style="text-transform: uppercase;" maxlength="150" disabled>
        </span>
    </div>
    <div id="nombreComercialDiv" class="form-group col-xs-6">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Nombre Comercial: </label>
            <input type="text" id="sNombreComercial" name="sNombreComercial" class='form-control m-bot15' style="text-transform: uppercase;" disabled  maxlength="150">
        </span>
    </div>	
    <div class="form-group col-xs-6">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Actividad económica:</label>
            <input type="text" id="actividadEconomica" class='form-control m-bot15' style="text-transform: uppercase;"  maxlength="150" disabled>
        </span>
    </div>	
</div>
<div  class="form-group col-xs-12">
    <h4><span><i class="fa fa-map-marker"></i></span> Dirección</h4>
    <h5>*La siguiente información se actualiza únicamente en catálogo maestro.</h5>
</div>
<div class="form-group col-xs-12">
    <input type="hidden" name="idDireccion" id="idDireccion" value="0">
    <input type="hidden" name="origen" id="origen" value="0" />
    <div class="form-group col-xs-6">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Calle: </label>
            <input type="text" class="form-control m-bot15" name="calleDireccion" id="txtCalle" style="text-transform: uppercase;" disabled>
        </span>
    </div>
    <div class="form-group col-xs-2">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Número Exterior: </label>
            <input type="text" class="form-control m-bot15" id="ext" name="numeroExtDireccion" style="text-transform: uppercase;" disabled>
        </span>
    </div>
    <div class="form-group col-xs-2">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Número Interior: </label>
            <input type="text" class="form-control m-bot15" id="int" name="numeroIntDireccion" style="text-transform: uppercase;" disabled>
        </span>
    </div>
    <div class="form-group col-xs-2">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Código Postal: </label>
            <input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCP" disabled onkeyup="buscar_cp(event)">
        </span>
    </div>
</div>

<div class="form-group col-xs-12" id="divDirext" style="display:none">
    <div class="form-group col-xs-4	">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Colonia: </label>
            <input type="text" class="form-control m-bot15" name="txtColoniaExt" id="txtColoniaExt" style="text-transform: uppercase;" disabled>
        </span>
    </div>
    <div class="form-group col-xs-4	">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Ciudad: </label>
            <input type="text" class="form-control m-bot15" name="txtCiudadExt" id="txtCiudadExt" style="text-transform: uppercase;" disabled>
        </span>
    </div>
    <div class="form-group col-xs-4	">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Estado: </label>
            <input type="text" class="form-control m-bot15" name="txtEstadoExt" id="txtEstadoExt" style="text-transform: uppercase;" disabled>
        </span>
    </div>
</div>

<div class="form-group col-xs-12" id="divDirnac">
    <div class="form-group col-xs-3	">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Colonia: </label>
            <select class="form-control m-bot15" name="idcColonia" id="cmbColonia" disabled>
                <option value="-1">Seleccione</option>
            </select>
        </span>
    </div>
    <div class="form-group col-xs-3	">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Ciudad: </label>
            <select class="form-control m-bot15" name="idcMunicipio" id="cmbCiudad" disabled>
                <option value="-1">Seleccione</option>
            </select>
        </span>
    </div>
    <div class="form-group col-xs-3">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label">Estado: </label>
            <select class="form-control m-bot15" name="idcEntidad" id="cmbEntidad" disabled>
                <option value="-1">Seleccione</option>
            </select>
        </span>
    </div>
</div>

<div class="row">
    <div class="col-lg-12"><br><br>
        <span id="span_paso2" class="" style="display: none;"></span>
    </div>
</div>

<ul class="list-inline pull-right">
    <!-- <li><button type="button" class="btn btn-default prev-step">Anterior</button></li>
    <li><button id="paso2" type="button" class="btn btn-primary next-step">Continuar</button></li> -->
</ul>

</div>