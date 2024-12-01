<div id="loadstep3" style="display: flex; justify-content: center;">
    <img src=<?php echo $PATHRAIZ.'/img/cargando3.gif' ?>>
</div>

<div id="contentStep3" style="display: none">

<div id="div_replegal">
    <div class="form-group col-xs-8 repLegal">
        <input type="hidden" id="usuario_logueado" name="usuario_logueado" value="<?php echo $usuario_logueado;?>" >
        <h4><span><i class="fa fa-suitcase"></i></span> Representante Legal</h4>
    </div>
    <div class="form-group col-xs-12 repLegal">
        <div class="form-group col-xs-3">
            <label class=" control-label">Nombre(s) *</label>
            <input type="text" class='form-control m-bot15 fisico mayusculas' name="sNombreReplegal" maxlength="50" id="sNombreReplegal" style="text-transform: uppercase;">
        </div>	
        <div class="form-group col-xs-3">
            <label class=" control-label">Apellido paterno *</label>
            <input type="text" class='form-control m-bot15 fisico mayusculas' name="sPaternoReplegal" maxlength="50" id="sPaternoReplegal" style="text-transform: uppercase;">
        </div>	
        <div class="form-group col-xs-3">
            <label class=" control-label">Apellido materno *</label>
            <input type="text" class='form-control m-bot15 fisico mayusculas' name="sMaternoReplegal" maxlength="50" id="sMaternoReplegal" style="text-transform: uppercase;">
        </div>
    </div>	

    <div class="form-group col-xs-12">
        <div class="form-group col-xs-3">
            <label class="control-label">Identificación *</label>
            <select class="form-control" id="cmbIdentificacion">
                <option value="-1" selected>Seleccione</option>
                <?php echo $htmlTipoID; ?>
            </select>
        </div>
        <div class="form-group col-xs-3">
            <label class="control-label">No. Identificación *</label>
            <input type="text" class="form-control" name="" id="numeroIdentificacion" style="text-transform: uppercase;">
        </div>
    </div>
</div>

<div class="form-group col-xs-12" id="div_titulo_datos_bancarios_proveedor">
    <div>
        <h4><span><i class="fa fa-file-o"></i></span> Contrato</h4>
    </div>    
</div>
<div class="form-group col-xs-12">
    <div class="form-group col-xs-3">
        <label class="control-label">Fecha de contrato: </label>
        <input type="text" id="fecContrato" name="fecContrato" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" autocomplete="off">
        <div class="help-block">Elegir Fecha</div>
    </div>
    <div class="form-group col-xs-3">
        <label class="control-label">Fecha renovación de contrato: </label>
        <input type="text" id="fecRenovarContrato" name="fecRenovarContrato" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" disabled>
        <!-- <div class="help-block">Elegir Fecha.</div> -->
    </div>
</div>
<div class="form-group col-xs-12">
    <div class="form-group col-xs-3">
        <!--<label class=" control-label">Vigencia: </label>-->
        <!--<br/>-->
        <input type="checkbox" class="form-check-input" id="checkVigencia" checked>
        <label class="form-check-label" for="checkVigencia">Vigencia: Indefinida</label>
    </div>
    <div id="divNumVigencia" class="form-group col-xs-3" style="display: none">
        <label class="control-label">Especificar vigencia:</label>
        <input type="text" id="txtNumVigencia" name="txtNumVigencia" class="form-control">
        <div class="help-block">Número de meses</div>
    </div>
</div>
<div class="form-group col-xs-12">
    <div class="form-group col-xs-3">
        <label class="control-label">Fecha revisión de condiciones comerciales: </label>
        <input type="text" id="fecRevisionCondicion" name="fecRevisionCondicion" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" autocomplete="off">
        <div class="help-block">Elegir Fecha</div>
    </div>
</div>
    
<div class="row">
    <div class="col-lg-12">
        <span id="span_paso3" class="" style="display: none;"></span>
    </div>
</div>

<?php if ($permisos) { ?>
    <ul class="list-inline pull-right">
        <li><button onclick="actualizarApartadoReplegalContrato('sSeccion3')" type="button" id="btnGuardar3" class="btn btn-default">Guardar cambios</button></li>
        <li><button onclick="actualizarControlCambios('sSeccion3')" type="button" id="btnActualizarControlCambios" class="btn btn-default next-step btnActualizarControlCambios" style="display: none;">Actualizar</button></li>
        <!-- <li><button id="paso3" type="button" class="btn btn-primary next-step">Continuar</button></li> -->
    </ul>
<?php } ?>

</div>
