<div id="loadstep1" style="display: flex; justify-content: center;">
    <img src=<?php echo $PATHRAIZ.'/img/cargando3.gif' ?>>
</div>

<div id="contentStep1" style="display: none">

<input type="hidden" name="tipoProceso" id="tipoProceso" />
<div class="form-group col-xs-2">
    <a href="<?php echo $url1 ?>" class="btn btn-info" style="margin-top: 15px;">Regresar</a>
</div>
<div class="form-group col-xs-12">
    <div class="form-group col-xs-5">
        <br/>
        <label class="control-label" for="solicitante">Solicitante *</label>
        <select class="form-control m-bot15" name="solicitante" id="cmbSolicitante">
            <option value="-1">Seleccione</option>
            <?php echo $htmlSolicitantes ?>
        </select>
        <small></small>
    </div>	
</div>

<!-- Apartado de tipo cliente -->
<div class="form-group col-lg-12">
    <h4><span><i class="fa fa-file-text"></i></span> Tipo Cliente</h4>
</div>

<div class="form-group col-xs-12">
    <div class="form-group col-xs-3">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label"><input type="radio" onclick="configTipoPersona();" name="gbTipoPersona" id="gbPersonaMoral" value="2" disabled /> PERSONA MORAL</label>
        </span>
    </div>
    <div class="form-group col-xs-3">
        <span class="d-inline-block" tabindex="0" data-toogle="tooltip" data-placement="top" title="Dato modificable en catálogo maestro">
            <label class=" control-label"><input type="radio" onclick="configTipoPersona();" name="gbTipoPersona" id="gbPersonaRFC" value="1" disabled /> PERSONA FÍSICA</label>
        </span>
    </div>
    <!-- <div class="form-group col-xs-4">
        <label class=" control-label"><input type="radio" onclick="configTipoPersona();" name="gbTipoPersona" id="gbPersonaNF" value="3" disabled /> PERSONA FÍSICA (Público en general)</label>
    </div> -->
</div>
<div class="form-group col-xs-12">
    <div class="form-check col-xs-4" id="divCheckFisicaGeneral" style="display: none">
        <input type="checkbox" class="form-check-input" id="checkFisicaGeneral">
        <label class="form-check-label" for="checkFisicaGeneral">Persona física (Público en general)</label>
    </div>
    <div class="form-check col-xs-4 ">
        <input type="checkbox" class="form-check-input" id="checkIntegrador">
        <label class="form-check-label" for="checkIntegrador">¿El cliente es integrador?</label>
    </div>
    <div class="form-group col-xs-4">
        <label class=" control-label">Ticket fiscal *</label>
        <select class="form-control m-bot15" name="cmbticket" id="cmbticket">
            <option value="-1">Seleccione</option>
            <option value="0">De cliente</option>
            <option value="1">De RED</option>
            <option value="2">Neteo de comisiones</option>
        </select>
    </div>
</div>
<!-- Apartado de configuracion -->
<div class="form-group col-lg-12">
    <h4><span><i class="fa fa-gear"></i></span> Configuración</h4>
</div>
<div class="form-group col-xs-12">
    <div class="form-group col-xs-4">
        <label class="control-label">Cadena *</label>
        <input type="text" id="txtSCadena" name="sCadena" class='form-control'>
        <input type="hidden" name="nIdCadena" id="txtIdCadena">
    </div>
    <div class="form-check col-xs-4">
        <label class=" control-label">Cuantas forelo *</label>
        <select class="form-control m-bot15" name="cmbforelo" id="cmbforelo">
            <option value="-1">Seleccione</option>
            <option value="0">Solo una</option>
            <option value="1">Cuenta individual para servicios y otra para TAE</option>
        </select>
    </div>
</div>
<div class="form-group col-lg-12">
    <h5>Tipo de acceso *</h5>
</div>
<div class="form-group col-xs-12">
    <?php echo $html_tipoacceso; ?>
</div>
<div class="form-group col-lg-12">
    <h5 id="matrizCheckbox_nIdFamilia">Familias *</h5>
</div>
<div class="form-group col-xs-12">
    <?php echo $html_familias; ?>
</div>
<div class="form-group col-lg-12">
    <h5>Factura TAE</h5>
</div>
<div class="form-group col-xs-12">
    <div class="form-group col-xs-4">
        <label class=" control-label">¿Requiere factura de TAE? *</label>
        <select class="form-control m-bot15" name="cmbReqFacTAE" id="cmbReqFacTAE">
            <option value="-1">Seleccione</option>
            <option value="0">NO</option>
            <option value="1">SI</option>
        </select>
    </div>
    <!-- <div class="form-group col-xs-4" id="divPeriodoEmiPrepTAE" style="display: none">
        <label class=" control-label">Periodo de emisión de factura TAE (En Prepago): </label>
        <select class="form-control m-bot15" name="cmbPeriodoTae" id="cmbPeriodoTae">
            <option value="-1">Seleccione</option>
            <option value="0">Por deposito</option>
            <option value="1">...</option>
        </select>
    </div> -->
</div>
<!-- Ambiente de operacion -->
<div class="form-group col-lg-12">
    <h4><span><i class="fa fa-archive"></i></span> Ambiente de operación</h4>
</div>
<div class="form-group col-xs-12">
    <div class="form-check col-xs-4">
        <input type="checkbox" class="form-check-input" id="checkModPruebas">
        <label class="form-check-label" for="checkModPruebas">Modo pruebas</label>
    </div>
    <div class="form-group col-xs-4" id="divFechaModPruebas" style="display: none">
        <label class="control-label">Fecha inicio de pruebas </label>
        <input type="text" id="fecPruebas" name="fecPruebas" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>">
        <div class="help-block">Elegir Fecha.</div>
    </div> 
</div>
<div class="form-group col-xs-12">
    <div class="form-check col-xs-4">
        <input type="checkbox" class="form-check-input" id="checkModProduccion">
        <label class="form-check-label" for="chechModProduccion">Modo producción</label>
    </div>
    <div class="form-group col-xs-4" id="divFechaModProduccion" style="display: none">
        <label class="control-label">Fecha inicio de producción </label>
        <input type="text" id="fecProduccion" name="fecProduccion" onpaste="return false;" class="form-control form-control-inline input-medium default-date-picker" data-date-format="yyyy-mm-dd" maxlength="10"  value="<?php echo $hoy; ?>">
        <div class="help-block">Elegir Fecha</div>
    </div>
</div>

<?php if ($permisos) { ?>
    <ul class="list-inline pull-right">
        <li><button onclick="actualizarApartadoTipoCliente('sSeccion1')" type="button" id="btnGuardar1" class="btn btn-default next-step">Guardar cambios</button></li>
        <li><button onclick="actualizarControlCambios('sSeccion1')" type="button" id="btnActualizarControlCambios" class="btn btn-default next-step btnActualizarControlCambios" style="display: none;">Actualizar</button></li>
        <!-- <li><button id="paso1" type="button" class="btn btn-primary next-step">Siguiente</button></li> -->
    </ul>
    <span id="span_paso1" class="alert alert-success" style="display: none;">
    </span>
<?php } ?>

</div>