<div id="loadstep4" style="display: flex; justify-content: center;">
    <img src=<?php echo $PATHRAIZ.'/img/cargando3.gif' ?>>
</div>

<div id="contentStep4" style="display: none">

    <div style="margin-bottom:10px;" class="form-group col-xs-6">
        <h4><span><i class="fa fa-file"></i></span> Documentos</h4>
    </div>

    <div style="margin-bottom:10px;text-align: right;" class="form-group col-xs-6">
        <span>El tamaño máximo de un archivo PDF es de 15 MB</span>
    </div>

    <div class="form-group col-xs-12" id="div_docActConstitutiva">
        <div class="col-xs-5">
            <label class=""> Acta Constitutiva</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="acta_constitutiva" id="acta_constitutiva" idtipodoc="1" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="1">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlActa">
            <input origen="emisor" type="button" id="file_Acta"  value="Ver Comprobante" idtipodoc="1" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docRFC">
        <div class="col-xs-5">
            <label class=""> RFC (Constancia de situación fiscal) *</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="documento_rfc" id="documento_rfc" idtipodoc="2" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="2">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlRFC">
            <input origen="emisor" type="button" id="file_Rfc"  value="Ver Comprobante" idtipodoc="2" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docComprobanteDomicilio">
        <div class="col-xs-5">
            <label class=""> Comprobante de Domicilio *</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="sFile" id="txtFile" idtipodoc="3" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="3">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlDomicilio">
            <input origen="emisor" type="button" id="file_Domicilio"  value="Ver Comprobante" idtipodoc="3" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docPoderReplegal">
        <div class="col-xs-5">
            <label class=""> Poder Representante Legal</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="poder_legal" id="poder_legal" idtipodoc="4" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="4">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlPoder">
            <input origen="emisor" type="button" id="file_Poder"  value="Ver Comprobante"  idtipodoc="4" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docIdReplegal">
        <div class="col-xs-5">
            <label class=""> Identificación Representante Legal</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="id_representante_legal" id="id_representante_legal" idtipodoc="5" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="5">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlRepre">
            <input origen="emisor" type="button" id="file_Repre"  value="Ver Comprobante"  idtipodoc="5" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docContrato">
        <div class="col-xs-5">
            <label class=""> Contrato *</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="contrato" id="contrato" idtipodoc="6" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="6">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlContrato">
            <input origen="emisor" type="button" id="file_Contrato"  value="Ver Comprobante"  idtipodoc="6" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>
    <div class="form-group col-xs-12" id="div_docCtaBancaria">
        <div class="col-xs-5">
            <label class=""> Carátula Cuenta Bancaria *</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="ctabancaria" id="ctabancaria" idtipodoc="11" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="11">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlctabancaria">
            <input origen="emisor" type="button" id="file_ctabancaria"  value="Ver Comprobante"  idtipodoc="11" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docAdendo1">
        <div class="col-xs-5">
            <label class=""> Adendo 1</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="adendo1" id="adendo1" idtipodoc="7" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="7">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlAdendo1">
            <input origen="emisor" type="button" id="file_Adendo1"  value="Ver Comprobante"  idtipodoc="7" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docAdendo2">
        <div class="col-xs-5">
            <label class=""> Adendo 2</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="adendo2" id="adendo2" idtipodoc="8" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="8">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlAdendo2">
            <input origen="emisor" type="button" id="file_Adendo2"  value="Ver Comprobante"  idtipodoc="8" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docAdendo3">
        <div class="col-xs-5">
            <label class=""> Adendo 3</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="adendo3" id="adendo3" idtipodoc="9" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="9">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlAdendo3">
            <input origen="emisor" type="button" id="file_Adendo3"  value="Ver Comprobante"  idtipodoc="9" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="form-group col-xs-12" id="div_docIdentificacion">
        <div class="col-xs-5">
            <label class=""> Identificación</label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="id_identificacion_fisica" id="id_identificacion_fisica" idtipodoc="10" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="10">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlID">
            <input origen="emisor" type="button" id="file_IDFisica" value="Ver Comprobante"  idtipodoc="10" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>



    <div class="form-group col-xs-12" id="div_ActPrepSat">
        <div class="col-xs-5">
            <label class=""> Actividad Preponderante SAT </label>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
                <input type="file" class="hidess transparent" style="" name="actPrepSat" id="actPrepSat" idtipodoc="12" accept="application/pdf">
                <input type="hidden" class="" style="" name="nIdDoc" id="txtNIdDoc" idtipodoc="12">
            </div>
        </div>
        <div class="col-xs-2">
            <input type="hidden" name="" id="urlactPrepSat">
            <input origen="emisor" type="button" id="file_actPrepSat"  value="Ver Comprobante"  idtipodoc="12" onclick="verdocumento(this.id);" class ="btnfiles btn btn-info disabled">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <span id="span_paso4" class="" style="display: none;"></span>
        </div>
    </div>

    <?php if ($permisos) { ?>
        <ul class="list-inline pull-right">
            <li><button onclick="actualizarApartadoDocs()" type="button" id="btnGuardar4" class="btn btn-default next-step">Guardar cambios</button></li>
            <!-- <li><button id="paso6" type="button" class="btn btn-primary next-step">Continuar</button></li> -->
        </ul>
    <?php } ?>

</div>