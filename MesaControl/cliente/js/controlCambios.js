

function controlBotones(statusRegistro, status_seccion){
    console.log({usuario_capturisa, usuario_autorizador, statusRegistro, status_seccion})
    if(usuario_capturisa == 1 && usuario_autorizador == 0){
        if(usuario_autorizador == 1){

        }else{
            if(statusRegistro == '0' && (status_seccion !== 'null')){

                $('#btnGuardar1').hide();
                $('#btnGuardar3').hide();
                $('#btnGuardar5').hide();
                $('#btnGuardar6').hide();
                $('.btnActualizarControlCambios').show();
            }else{
                $('#btnGuardar1').hide();
                $('#btnGuardar3').hide();
                $('#btnGuardar5').hide();
                $('#btnGuardar6').hide();
                $('.btnActualizarControlCambios').hide();
            }
        }
    }else if(usuario_autorizador == 1 || (usuario_autorizador == 1 && usuario_capturisa == 1)){

        //if((statusRegistro == '0' && status_seccion == '0') || (statusRegistro == 1 && status_seccion == 1)){
        if((statusRegistro == '0' && status_seccion == '0') || (statusRegistro == '1' && status_seccion == '1') || ((statusRegistro == '1' && status_seccion != 'null'))){

            $('#btnGuardar1').show();
            $('#btnGuardar3').show();
            $('#btnGuardar5').show();
            $('#btnGuardar6').show();
            // $('.btnActualizarControlCambios').hide();
        }else{

            $('#btnGuardar1').hide();
            $('#btnGuardar3').hide();
            $('#btnGuardar5').hide();
            $('#btnGuardar6').hide();
            // $('.btnActualizarControlCambios').show();
        }
    }
}
function setSSeccion(seccion, data){
    secciones[seccion]                      = data.sSeccion;
    secciones['nIdCliente']                 = data.nIdCliente;
    secciones['nIdActualizacion']           = data.nIdActualizacion;
    secciones['bRevisionSecciones']         = data.bRevisionSecciones;
    secciones['allSecciones']               = data.allSecciones;
    tipo_actualizacion_control_cambios      = (data.nIdActualizacion > 0) ? 2 : 1;
    control_cambios                         = [];

    datos_seccion   = JSON.parse(secciones[seccion]);
    keys            = Object.keys(datos_seccion) || [];
    mapFormulario(seccion);
    marcaTab(secciones['allSecciones']);
    if(seccion === 'sSeccion5') {
        selectCmbticket();
        if(!datos_seccion.hasOwnProperty('divCalendarioPago')){
            let calendario_cobtro_original = calendario.filter(element => element.nTipoRegistro === '2');
            setCalendario(calendario_cobtro_original);
        }
    }
    if(datos_seccion.hasOwnProperty('status') && datos_seccion.status === '1'){
        $('.text-warning').each(function(){
            let textLabel = $(this).text()
            // $(this).empty();
            // $(this).text(textLabel);
            $(".fa-exclamation-circle").remove();
            $(".fa-undo").remove();
            $(this).removeClass('text-warning');
        });
        return false;
    }
    for(let key of keys){
        let tipo_elemento = 'normal';
        if(key === 'divCalendarioOperaciones' || key === 'divCalendarioPago' || key === 'divCalendarioCobro'){
            tipo_elemento               = 'calendario';
            matrizCalendario_recaudo    = (datos_seccion.hasOwnProperty('divCalendarioOperaciones')) ? datos_seccion['divCalendarioOperaciones'] : [];
            matrizCalendario_cobro      = (datos_seccion.hasOwnProperty('divCalendarioCobro')) ? datos_seccion['divCalendarioCobro'] : [];
            matrizCalendario_pago       = (datos_seccion.hasOwnProperty('divCalendarioPago')) ? datos_seccion['divCalendarioPago'] : [];
        }
        if(key === 'divCorreosNotificaciones' || key === 'divCorreosFacturaComision' || key === 'divCorreosFacturaTAE'){
            tipo_elemento                       = 'matriz_correos';
            sCorreoEnvio_controlCambios         = (datos_seccion.hasOwnProperty('divCorreosNotificaciones')) ? datos_seccion['divCorreosNotificaciones'] : [];
            sCorreoDestino_controlCambios       = (datos_seccion.hasOwnProperty('divCorreosFacturaComision')) ? datos_seccion['divCorreosFacturaComision'] : [];
            sCorreoDestinoTae_controlCambios    = (datos_seccion.hasOwnProperty('divCorreosFacturaTAE')) ? datos_seccion['divCorreosFacturaTAE'] : [];
        }
        if(key.includes('nIdFamilia')){
            tipo_elemento = 'matriz_familias';
        }
        $("#"+key).addClass('controlCambios');
        switch (tipo_elemento) {
            case 'calendario':
                creaPopoverCalendario(key, seccion);
                break;
            case 'matriz_correos':
                creaPopoverMatrizCorreos(key, seccion);
                break;
            case 'normal':
                creaPopover(key, seccion);
                break;
            case 'matriz_familias':
                creaPopoverMatrizCheckbox(key, seccion);
                break;
            default:
                creaPopover(key, seccion);
                break;
        }
    }

}

function marcaTab(allSecciones){
    let tabs = {
        'sSeccion1' : 'tabTipoCliente',
        'sSeccion2' : 'li_paso1',
        'sSeccion3' : 'tabRepLegal',
        'sSeccion4' : 'li_paso3',
        'sSeccion5' : 'tabLiquidacion',
        'sSeccion6' : 'tabFacturacion',
        'sSeccion7' : 'tabEscalonamiento'
    }
    Object.keys(allSecciones).forEach(function(key) {
       let item = JSON.parse(allSecciones[key]);
       if(item.hasOwnProperty('status') && item.status === '0'){
           $("#"+tabs[key]).attr('style', 'background-color: #FCB322');
       }else{
           $("#"+tabs[key]).removeAttr('style');
       }
    });
}

function creaPopover(key, seccion){
    let contenedor      = $("#"+key).parent();
    let label           = contenedor.find('label');
    let label_text      = label.text();
    let input           = $("#"+key);
    let valor_anterior  = input.val();
    let descripcion_anterior = valor_anterior;
    let tipo_input      = input.prop('type');
    let datos_seccion  = JSON.parse(secciones[seccion]);
    let en_catalogo     = (catalogos[key] != undefined) ? true : false;

    label.empty();
    label.text(label_text);

    switch (tipo_input) {
        case 'text':
            break;
        case 'select-one':
            descripcion_anterior = buascarEnCatalogo(key, valor_anterior);
            break;
        case 'radio':
            label.removeAttr('for');
            valor_anterior          = $("input[id="+key+"]:checked").val();
            descripcion_anterior    = (en_catalogo) ? buascarEnCatalogo(key, valor_anterior) : descripcion_anterior;
            descripcion_anterior    = (descripcion_anterior == undefined || descripcion_anterior == null) ? 'Sin valor previo' : descripcion_anterior;
            let checkLimiteCredito  = ['limitCreditY', 'limitCreditN'];
            if(checkLimiteCredito.includes(key)){
                descripcion_anterior = (parseFloat(mapForm['montoLimiteCredito']) > 0) ? 'Si' : 'No';
            }
            let input_nuevo         = $("input[id="+key+"][value="+datos_seccion[key]+"]");
            label                   = input_nuevo.parent().find('label');
            label_text              = label.text();
            label.empty();
            label.text(label_text);
            $(input_nuevo).addClass('controlCambios');

            break;
        case 'checkbox':
            valor_anterior = (input.prop('checked')) ? true : false;
            label.removeAttr('for');
            // Para checkbox de produccion/pruebas
            let checksPruebasProduccion = ['checkModProduccion', 'checkModPruebas'];
            let checksComisionUsuarioFinalOriginal = ['checkDescFDM','checkDescGD','checkTicketResp'];
            let checksGeneral = ['checkVigencia', 'checkIntegrador'];
            if(checksPruebasProduccion.includes(key)){
                descripcion_anterior = pruebasProduccionOriginal[key] == 1 ? 'On' : 'Off';
            }
            if(checksComisionUsuarioFinalOriginal.includes(key)){
                descripcion_anterior = comisionUsuarioFinalOriginal[key] == 1 ? 'On' : 'Off';
            }
            if(checksGeneral.includes(key)){
                descripcion_anterior = checksForms[key] == 1 ? 'On' : 'Off';
            }

            break;
        case 'textarea':
            break;
        default:
            break;
    }

    let icono_popover   = document.createElement('i');
    icono_popover.id        = 'popover_' + key;
    icono_popover.title     = 'Valores anteriores';
    icono_popover.type      = 'button';
    icono_popover.classList.add('fa', 'fa-exclamation-circle', 'text-warning');
    icono_popover.setAttribute('data-toggle', 'popover');
    icono_popover.setAttribute('data-html', 'true');
    icono_popover.setAttribute('data-content', descripcion_anterior);
    icono_popover.setAttribute('style', 'cursor: pointer');
    label.append(icono_popover);

    let icono_restaurar = document.createElement('i');
    icono_restaurar.id      = 'restaurar_' + key;
    icono_restaurar.title   = 'Restaurar valores anteriores';
    icono_restaurar.type    = 'button';
    icono_restaurar.classList.add('fa', 'fa-undo', 'text-warning');
    icono_restaurar.onclick = function(){
        restaurarValorAnterior(key, valor_anterior, tipo_input);
    }
    label.append(icono_restaurar);

    label.addClass('text-warning');
    $('[data-toggle="popover"]').popover();

    asignanuevoValor(key, input, tipo_input, seccion);
}

function creaPopoverMatrizCheckbox(key, seccion){
    let label      = $("#matrizCheckbox_nIdFamilia");
    let input      = $("#" + key);
    let tipo_input = input.prop('type');
    let label_text = label.text();
    label.empty();
    label.text(label_text);

    let lista_valor_anterior = "<ul>";
    familiasOriginales.forEach(function (familia) {
        lista_valor_anterior += "<li>"+ (catalogos.idFamilias.find((data) => data.key == familia)).value +"</li>";
    });
    lista_valor_anterior += "</ul>";

    let icono_popover   = document.createElement('i');
    icono_popover.id        = 'popover_' + key;
    icono_popover.title     = 'Valores anteriores';
    icono_popover.type      = 'button';
    icono_popover.classList.add('fa', 'fa-exclamation-circle', 'text-warning');
    icono_popover.setAttribute('data-toggle', 'popover');
    icono_popover.setAttribute('data-html', 'true');
    icono_popover.setAttribute('data-content', lista_valor_anterior);
    icono_popover.setAttribute('style', 'cursor: pointer');
    label.append(icono_popover);

    let icono_restaurar = document.createElement('i');
    icono_restaurar.id      = 'restaurar_' + key;
    icono_restaurar.title   = 'Restaurar valores anteriores';
    icono_restaurar.type    = 'button';
    icono_restaurar.classList.add('fa', 'fa-undo', 'text-warning');
    icono_restaurar.onclick = function(){
        restaurarMatrizChecbox(key);
    }
    label.append(icono_restaurar);

    label.addClass('text-warning');
    asignanuevoValor(key, input, tipo_input, seccion);
}

function creaPopoverCalendario(key, seccion){
    let contenedor              = $("#"+key);
    let label                   = contenedor.find('label');
    let label_text              = label.text();
    let data_calendario   = [];
    let matriz_calendario = [];

    label.empty();
    label.text(label_text);

    switch (key) {
        case 'divCalendarioPago':
            data_calendario = calendario.filter(element => element.nTipoRegistro === '1');
            matriz_calendario = matrizCalendario_pago;
            break;
        case 'divCalendarioCobro':
            data_calendario = calendario.filter(element => element.nTipoRegistro === '2');
            matriz_calendario = matrizCalendario_cobro;
            break;
        case 'divCalendarioOperaciones':
            data_calendario = calendario.filter(element => element.nTipoRegistro === '3');
            matriz_calendario = matrizCalendario_recaudo;
            break;
    }

    let table_valor_anterior = creaTablaCalendario(data_calendario)

    let icono_popover   = document.createElement('i');
    icono_popover.id        = 'popover_' + key;
    icono_popover.title     = 'Valores anteriores';
    icono_popover.type      = 'button';
    icono_popover.classList.add('fa', 'fa-exclamation-circle', 'text-warning');
    icono_popover.setAttribute('data-toggle', 'popover');
    icono_popover.setAttribute('data-html', 'true');
    icono_popover.setAttribute('data-content', table_valor_anterior);
    icono_popover.setAttribute('style', 'cursor: pointer');
    label.append(icono_popover);

    setCalendario(matriz_calendario);

    let icono_restaurar = document.createElement('i');
    icono_restaurar.id      = 'restaurar_' + key;
    icono_restaurar.title   = 'Restaurar valores anteriores';
    icono_restaurar.type    = 'button';
    icono_restaurar.classList.add('fa', 'fa-undo', 'text-warning');
    icono_restaurar.onclick = function(){
        restaurarValoresCalendario(key);
    }
    label.addClass('text-warning');
    label.append(icono_restaurar);

}

function creaPopoverMatrizCorreos(key, seccion){
    let contenedor              = $("#"+key);
    let label                   = contenedor.find('label');
    let label_text              = label.text();
    let data_correos      = [];
    let matriz_correos    = [];

    label.empty();
    label.text(label_text);

    // if(key === 'divCorreosNotificaciones' || key === 'divCorreosFacturaComision' || key === 'divCorreosFacturaTAE'){
    switch (key) {
        case 'divCorreosNotificaciones':
            data_correos            = sCorreoEnvio_original;
            matriz_correos          = sCorreoEnvio_controlCambios;
            correosNotificaciones   = [];
            $("#contenedordecorreosliquidacion").empty();
            matriz_correos.forEach(function (correo) {
                agregarCorreoNotificaciones(correo);
            });
            break;
        case 'divCorreosFacturaComision':
            data_correos                = sCorreoDestino_original;
            matriz_correos              = sCorreoDestino_controlCambios;
            correosenvfacturasComision  = [];
            $("#contenedordecorreosfacturasComision").empty();
            matriz_correos.forEach(function (correo) {
                agregarcorreosfacturasComision(correo);
            });
            break;
        case 'divCorreosFacturaTAE':
            data_correos            = sCorreoDestinoTae_original;
            matriz_correos          = sCorreoDestinoTae_controlCambios;
            correosenvfacturasTAE   = [];
            $("#contenedordecorreosfacturasTAE").empty();
            matriz_correos.forEach(function (correo){
                agregarcorreosfacturasTAE(correo);
            })
            break;
    }

    let lista_valor_anterior = creaListaCorreos(data_correos)

    let icono_popover   = document.createElement('i');
    icono_popover.id        = 'popover_' + key;
    icono_popover.title     = 'Valores anteriores';
    icono_popover.type      = 'button';
    icono_popover.classList.add('fa', 'fa-exclamation-circle', 'text-warning');
    icono_popover.setAttribute('data-toggle', 'popover');
    icono_popover.setAttribute('data-html', 'true');
    icono_popover.setAttribute('data-content', lista_valor_anterior);
    icono_popover.setAttribute('style', 'cursor: pointer');
    label.append(icono_popover);

    let icono_restaurar = document.createElement('i');
    icono_restaurar.id      = 'restaurar_' + key;
    icono_restaurar.title   = 'Restaurar valores anteriores';
    icono_restaurar.type    = 'button';
    icono_restaurar.classList.add('fa', 'fa-undo', 'text-warning');
    icono_restaurar.onclick = function(){
        restaurarValoresCorreos(key);
    }
    label.addClass('text-warning');
    label.append(icono_restaurar);
}

function creaTablaCalendario(data_calendario){
    let dias_semana         = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'];
    let table_valor_anterior = "<table class='table table-bordered table-striped table-hover table-sm'>";
    table_valor_anterior            += "<thead><tr><th>Corte</th><th colspan='7'>Dias de pago</th></tr></thead>";
    table_valor_anterior            += "<tbody>";
    for (let i = 0; i < data_calendario.length; i++) {
        let dias_pago              = data_calendario[i].sDiasPago.split(',');
        let diaPagoLunes    = dias_pago.includes('0') ? '*' : "&nbsp;";
        let diaPagoMartes   = dias_pago.includes('1') ? '*' : "&nbsp;";
        let diaPagoMiercoles= dias_pago.includes('2') ? '*' : "&nbsp;";
        let diaPagoJueves   = dias_pago.includes('3') ? '*' : "&nbsp;";
        let diaPagoViernes  = dias_pago.includes('4') ? '*' : "&nbsp;";
        let diaPagoSabado   = dias_pago.includes('5') ? '*' : "&nbsp;";
        let diaPagoDomingo  = dias_pago.includes('6') ? '*' : "&nbsp;";
        table_valor_anterior       += "<tr><td>"+ dias_semana[data_calendario[i].nDiaCorte] +"</td><td>"+ diaPagoLunes +"</td><td>"+ diaPagoMartes +"</td><td>"+ diaPagoMiercoles +"</td><td>"+ diaPagoJueves +"</td><td>"+ diaPagoViernes +"</td><td>"+ diaPagoSabado +"</td><td>"+ diaPagoDomingo +"</td></tr>"
    }
    table_valor_anterior += "</table>";

    return table_valor_anterior;
}

function creaListaCorreos(data_correos){
    let lista_valor_anterior = "<ul>";
    // Eliminar duplicados de data_correos
    data_correos = data_correos.filter(function(item, index, inputArray) {
        return inputArray.indexOf(item) == index;
    } );
    for (let i = 0; i < data_correos.length; i++) {
        lista_valor_anterior += "<li>"+ data_correos[i] +"</li>";
    }
    lista_valor_anterior += "</ul>";

    return lista_valor_anterior;
}

function asignanuevoValor(key, input, tipo_input, seccion){
    switch (tipo_input) {
        case 'text':
            let inputsCarateresEspeciales = ['sNombreReplegal', 'sPaternoReplegal', 'sMaternoReplegal']
            let valor_input = inputsCarateresEspeciales.includes(key) ? codificarCaracteresEspeciales(datos_seccion[key]) : datos_seccion[key];
            input.val(valor_input);
            funcionesText(key, datos_seccion[key]);
            break;
        case 'number':
            input.val(datos_seccion[key]);
            funcionesText(key, datos_seccion[key]);
            break;
        case 'select-one':
            input.val(datos_seccion[key])
            funcionesSelect(key, datos_seccion[key]);
            break;
        case 'radio':
            asignaRadiosEspecificos(key, input, seccion);
            $("input[id="+key+"][value="+datos_seccion[key]+"]").prop('checked', true);
            funcionesRadio(key);
            break;
        case 'checkbox':
            input.prop('checked', false);
            input.prop('checked', (datos_seccion[key] === 'on') ? true : false);
            funcionesCheckbox(key, datos_seccion[key]);
            break;
        case 'textarea':
            input.val(datos_seccion[key])
            break;
        default:
            break;
    }
    // input.removeClass('controlCambios');
}

function buascarEnCatalogo(key, valor_anterior){

    if(valor_anterior == null || valor_anterior == undefined){
        return 'Sin valor anterior';
    }
    let selects_especiales = ['cmbRetieneComision', 'cmbPeriodoPrepPagoCom', 'cmbPeriodoPagoCom'];
    if(selects_especiales.includes(key)){
        valor_anterior = mapForm[key];
    }
    seleccionado_anterior   = catalogos[key].find(element => element['key'] == valor_anterior);
    descripcion_anterior    = (seleccionado_anterior != null) ? seleccionado_anterior['value'] : valor_anterior;
    return descripcion_anterior;
}

function restaurarValorAnterior(key, valor_anterior, tipo_input){
    let input           = $("#"+key);
    let parent          = input.parent();
    let label           = parent.find('label');
    let label_text      = label.text();

    switch (tipo_input) {
        case 'text':
            input.val(valor_anterior);
            funcionesText(key, valor_anterior);
            break;
        case 'number':
            input.val(valor_anterior);
            funcionesText(key, valor_anterior);
            break;
        case 'select-one':
            input.val(valor_anterior);
            let selects_especiales = ['cmbRetieneComision', 'cmbPeriodoPrepPagoCom', 'cmbPeriodoPagoCom'];
            if(selects_especiales.includes(key)){
                input.val(mapForm[key]);
            }
            funcionesSelect(key, datos_seccion[key]);
            break;
        case 'radio':
            $("input[id="+key+"][value="+valor_anterior+"]").prop('checked', true);
            let input_nuevo         = $("input[id="+key+"][value="+datos_seccion[key]+"]");
            label                   = input_nuevo.parent().find('label');
            label_text              = label.text();
            let checkLimiteCredito  = ['limitCreditY', 'limitCreditN'];
            if(checkLimiteCredito.includes(key)){
                descripcion_anterior = parseFloat(mapForm['montoLimiteCredito']);
                if(descripcion_anterior > 0){
                    $("#limitCreditY").prop('checked', true).trigger('change');
                    $("#montoLimiteCredito").val(descripcion_anterior)
                }else{
                    $("#limitCreditN").prop('checked', true).trigger('change');
                }
            }
            if(key === 'tipoLiqRecaudo'){
                $("#tipoLiqRecaudo").trigger('change');
            }
            funcionesRadio(key, valor_anterior);
            break;
        case 'checkbox':
            input.prop('checked', valor_anterior);
            funcionesCheckbox(key, valor_anterior);
            let checksPruebasProduccion = ['checkModProduccion', 'checkModPruebas'];
            let checksComisionUsuarioFinalOriginal = ['checkDescFDM','checkDescGD','checkTicketResp'];
            if(checksPruebasProduccion.includes(key)){
                // descripcion_anterior = pruebasProduccionOriginal[key] == 1 ? 'On' : 'Off';
                if(key === 'checkModPruebas' && pruebasProduccionOriginal['checkModPruebas'] == 1){
                    $("#checkModPruebas").prop('checked', true);
                    $("#checkModProduccion").prop('checked', false);
                    $("#popover_checkModProduccion").remove();
                    $("#restaurar_checkModProduccion").remove();
                    funcionesCheckbox(key, valor_anterior);
                    funcionesCheckbox('checkModProduccion', 0);
                }
                if(key == 'checkModProduccion' && pruebasProduccionOriginal['checkModProduccion'] == 1){
                    $("#checkModProduccion").prop('checked', true);
                    $("#checkModPruebas").prop('checked', false);
                    $("#popover_checkModPruebas").remove();
                    $("#restaurar_checkModPruebas").remove();
                    funcionesCheckbox(key, valor_anterior);
                    funcionesCheckbox('checkModPruebas', 0);
                }
            }
            if(checksComisionUsuarioFinalOriginal.includes(key)){
                // buscar en comisionUsuarioFinalOriginal cual tiene valor 1
                const propiedadEncontrada = Object.keys(comisionUsuarioFinalOriginal).find(key => comisionUsuarioFinalOriginal[key] === 1);
                if(propiedadEncontrada != undefined){
                    checkboxComisionUsuarioFinal(propiedadEncontrada);
                }

            }

            break;
        case 'textarea':
            input.val(valor_anterior);
            break;
        default:
            break;
    }
    input.removeClass('controlCambios');
    label.empty();
    label.text(label_text);
    label.removeClass('text-warning');
}

function restaurarValoresCalendario(key, data_calendario){
    let contenedor          = $("#"+key);
    let label               = contenedor.find('label');
    let label_text          = label.text();
    let calendario_key= [];
    contenedor.removeClass('controlCambios');
    label.empty();
    label.text(label_text);
    label.removeClass('text-warning');
    switch (key) {
        case 'divCalendarioPago':
            matrizCalendario_pago = [];
            calendario_key = calendario.filter(element => element.nTipoRegistro === '1');
            break;
        case 'divCalendarioCobro':
            matrizCalendario_cobro = [];
            calendario_key = calendario.filter(element => element.nTipoRegistro === '2');
            break;
        case 'divCalendarioOperaciones':
            matrizCalendario_recaudo = [];
            calendario_key = calendario.filter(element => element.nTipoRegistro === '3');
            break;

    }
    setCalendario(calendario_key);
}
function restaurarValoresCorreos(key){
    let contenedor          = $("#"+key);
    let label               = contenedor.find('label');
    let label_text          = label.text();
    let correos_key   = [];
    contenedor.removeClass('controlCambios');
    label.empty();
    label.text(label_text);
    label.removeClass('text-warning');
    switch (key) {
        case 'divCorreosNotificaciones':
            sCorreoEnvio_controlCambios = [];
            correos_key                 = sCorreoEnvio_original;
            correosNotificaciones       = [];
            $("#contenedordecorreosliquidacion").empty();
            correos_key.forEach(function (correo) {
                agregarCorreoNotificaciones(correo);
            });
        case 'divCorreosFacturaComision':
            sCorreoDestino_controlCambios   = [];
            correos_key                     = sCorreoDestino_original;
            correosenvfacturasComision      = [];
            $("#contenedordecorreosfacturasComision").empty();
            correos_key.forEach(function (correo) {
                agregarcorreosfacturasComision(correo);
            });
            break;
        case 'divCorreosFacturaTAE':
            sCorreoDestinoTae_controlCambios    = [];
            correos_key                         = sCorreoDestinoTae_original
            correosenvfacturasTAE               = [];
            $("#contenedordecorreosfacturasTAE").empty();
            correos_key.forEach(function (correo){
                agregarcorreosfacturasTAE(correo);
            })
            break;

    }
}

function restaurarMatrizChecbox(key){

    catalogos.idFamilias.forEach(function (familia) {
        familiasOriginales.includes(familia.key) ? $("#nIdFamilia"+familia.key).prop('checked', true) : $("#nIdFamilia"+familia.key).prop('checked', false);
        $("#"+familia.key).prop('checked', false);
    });
    famsarr = familiasOriginales;
    let label      = $("#matrizCheckbox_nIdFamilia");
    let label_text = label.text();
    label.empty();
    label.text(label_text);
    label.removeClass('text-warning');
}
function funcionesText(key, valor){
    switch (key) {
        case 'fecContrato':
            txtfechaContrato();
            break;
        case 'txtNumVigencia':
            texttxtNumVigencia(key, valor);
            break;
        case 'txtCLABE':
            textTxtCLABE(key, valor);
            break;
    }
}

function textTxtCLABE(key, valor){
    let valTipo = $("#txtCLABE").val();
    analizarCLABE(valTipo);
}

function funcionesSelect(key, valor){
    switch (key) {
        case 'cmbticket':
            selectCmbticket();
            break;
        case 'cmbReqFacTAE':
            selectCmbReqFacTAE();
            break;
        case 'cmbTipoLiquidacionOperaciones':
            selectCmbTipoLiquidacionOperaciones();
            break;
        case 'cmbPeriodoPagoCom':
            selectCmbPeriodoPagoCom();
            break;
        case 'cmbCostoTransferencia':
            selectCmbCostoTransferencia();
            break;
        case 'cmbRetieneComision':
            selectCmbRetieneComision();
            break;
        case 'cmbPaisPago':
            selectCmbPaisPago();
            break;
        case 'cmbPeriodoCobroCom':
            selectCmbPeriodoCobroCom();
            break;
        case 'cmbFormaPagoComision':
            selectCmbFormaPagoComision();
            break;
        case 'cmbFormaPagoTAE':
            selectCmbFormaPagoTAE();
            break;
        case 'cmbComisionIntegrador':
            selectCmbComisionIntegrador();
            break;
        case 'cmbIdentificacion':
            tipoEntraDaNoIdentificacion();
            break;
    }
}

function selectCmbComisionIntegrador(){
    let valTipo = $("#cmbComisionIntegrador").val();
    valTipo == '1' ? $('#div_monto_comision_adicional').show() : $('#div_monto_comision_adicional').hide();
}
function selectCmbticket(){
    let valTipo = $("#cmbticket").val();
    if (valTipo === '0') {
        $("#contenidoFacturaComision").addClass("hidden");
        let tipos = ["Comision","TAE"];
        tipos.forEach(function(tipo) {
            $("#cmbCFDI"+tipo).val("G03");
            $("#cmbFormaPago"+tipo).val("99");
            $("#cmbMetodoPago"+tipo).val("PDD");
            $("#cmbProductoServicio"+tipo).val("80141628");
            $("#cmbClaveUnidad"+tipo).val("ACT");
            $("#periocidad"+tipo).val("-1");
            $("#diasLiquidacion"+tipo).val('');
            $(".lecturaCorreos"+tipo).click();
        });
        $("#div_cobrar_comisiones").removeClass('hidden');
    } else {
        $("#contenidoFacturaComision").removeClass("hidden");
        $("#div_cobrar_comisiones").addClass('hidden');
        $("#cmbPeriodoCobroCom").val("-1");
        $("#divTndiasCobro").hide();
        $("#divCalendarioCobro").hide();
        $("#divSemanalCobro").hide();
        $("#tnDiasCobro").val("");
        $("#cmbSemanalDiaCobro").val("-1");
        $("#semanalAtrasCobro").val("");
        let semana = ['Lu','Ma','Mi','Ju','Vi'];
        semana.forEach(function (dia) {
            $( "."+dia+"_Check_Cobro" ).prop( "checked", false );
        });
        $("#cmbCuentaRED").val("-1");
    }
}
function selectCmbReqFacTAE(){
    let valTipo = $("#cmbReqFacTAE").val();
    valTipo == '1' ? $('#contenidoFacturaTae').show() : $('#contenidoFacturaTae').hide()
}
function selectCmbTipoLiquidacionOperaciones(){
    let valTipo = $("#cmbTipoLiquidacionOperaciones").val();

    if (valTipo == "1") { //T+ndias
        $("#divTndiasOperaciones").show();
        $("#divCalendarioOperaciones").hide();
        $("#divSemanalOperaciones").hide();
    }
    else if (valTipo == "2") { //calendario
        $("#divCalendarioOperaciones").show();
        $("#divTndiasOperaciones").hide();
        $("#divSemanalOperaciones").hide();
    }
    else if (valTipo == "4") { // semanal
        $("#divSemanalOperaciones").show();
        $("#divTndiasOperaciones").hide();
        $("#divCalendarioOperaciones").hide();
    }
    else {
        $("#divTndiasOperaciones").hide();
        $("#divCalendarioOperaciones").hide();
        $("#divSemanalOperaciones").hide();
    }
}
function selectCmbPeriodoPagoCom(){
    let valTipo = $("#cmbPeriodoPagoCom").val();
        if (valTipo == "1") { //T+ndias
            $("#divTndiasPago").show();
            $("#divCalendarioPago").hide();
            $("#divSemanalPago").hide();
        }
        else if (valTipo == "2") { //calendario
            $("#divCalendarioPago").show();
            $("#divTndiasPago").hide();
            $("#divSemanalPago").hide();
        }
        else if (valTipo == "4") { // semanal
            $("#divSemanalPago").show();
            $("#divTndiasPago").hide();
            $("#divCalendarioPago").hide();
        }
        else {
            $("#divTndiasPago").hide();
            $("#divCalendarioPago").hide();
            $("#divSemanalPago").hide();
        }
}
function selectCmbCostoTransferencia(){
    let valTipo = $("#cmbCostoTransferencia").val();
    valTipo == '1' ? $('#div_monto_transferencia').show() : $('#div_monto_transferencia').hide();
}
function selectCmbRetieneComision(){
    let valTipo = $("#cmbRetieneComision").val();
    if (valTipo == "1") {
        $("#cmbPeriodoPagoCom").val("-1").trigger("change");
        $("#divPeriodoPagoComision").hide();
    } else {
        $("#divPeriodoPagoComision").show();
    }
}
function selectCmbPaisPago(){
    let valTipo = $("#cmbPaisPago").val();
    if (valTipo == "164") {
        $("#cmbMonedaExt").val("1");
        //$("#cmbMonedaExt").prop("disabled", true);
    } else {
        //$("#cmbMonedaExt").prop("disabled", false);
    }
}
function selectCmbPeriodoCobroCom(){
    let valTipo = $("#cmbPeriodoCobroCom").val();

    if (valTipo == "1") { //T+ndias
        $("#divTndiasCobro").show();
        $("#divCalendarioCobro").hide();
        $("#divSemanalCobro").hide();
    }
    else if (valTipo == "2") { //calendario
        $("#divCalendarioCobro").show();
        $("#divTndiasCobro").hide();
        $("#divSemanalCobro").hide();
    }
    else if (valTipo == "4") { // semanal
        $("#divSemanalCobro").show();
        $("#divTndiasCobro").hide();
        $("#divCalendarioCobro").hide();
    }
    else {
        $("#divTndiasCobro").hide();
        $("#divCalendarioCobro").hide();
        $("#divSemanalCobro").hide();
    }
}
function selectCmbFormaPagoComision(){
    let valTipo = $("#cmbFormaPagoComision").val();
    if (valTipo == "17") {
        $("#cmbMetodoPagoComision").val("PUE");
    } else if (valTipo == "99") {
        $("#cmbMetodoPagoComision").val("PPD");
    }
}
function selectCmbFormaPagoTAE(){
    let valTipo = $("#cmbFormaPagoTAE").val();
    if (valTipo == "17") {
        $("#cmbMetodoPagoTAE").val("PUE");
    } else if (valTipo == "99") {
        $("#cmbMetodoPagoTAE").val("PPD");
    }
}
/* Fincones que deben ser ejecutadas para radios en particular */
function funcionesRadio(key, valor){
    switch (key) {
        case 'gbPersonaMoral':
            configTipoPersona();
            break;
        case 'gbPersonaRFC':
            configTipoPersona();
            break;
        case 'gbTipoPersona':
            // addFamiliasArray(this)
            radiogbTipoPersona(key, valor);
            break;
        case 'tipoLiqRecaudo':
            radiotipoLiqRecaudo(key);
            break;
        case 'limitCreditY':
            radioLimitCreditY(key);
        case 'limitCreditN':
            radioLimitCreditY(key);
            break;
    }
}

function gbTipoPersona(key, valor){
    let radio_seleccionado = $("input[name=gbTipoPersona]:checked");
    let valor_seleccionado = radio_seleccionado.val();
    if(valor_seleccionado * 1 === 1) {
        $("#div_replegal").addClass('hidden');
    }
}
function radiotipoLiqRecaudo(key){
    let radio_seleccionado = $("input[name=tipoLiqRecaudo]:checked");
    let valor_seleccionado = radio_seleccionado.val();
        if (valor_seleccionado == "2") {
            $("#div_credito_liquidaciones").show();
            $("#div_cmb_retiene_comision").show();
            $("#costoTransferencia").removeClass("hidden");
        }
        else {
            $("#costoTransferencia").addClass("hidden");
            $("#div_credito_liquidaciones").hide();
            $("#div_cmb_retiene_comision").hide();
            $("#cmbRetieneComision").val("-1").trigger("change");
        }
}
function radioLimitCreditY(key){
    let radio_seleccionado = $("input[name=limitCredit]:checked");
    let valor_seleccionado = radio_seleccionado.val();
    if (valor_seleccionado == "1") {
        $("#limiteCredito").show()
    } else {
        $("#limiteCredito").hide()
        $("#montoLimiteCredito").val(0);
    }
}

function funcionesCheckbox(key, valor){
    let input = $("#"+key);
    let elemento = document.getElementById(key);
    switch (key) {
        case 'checkModPruebas':
            checkboxcheckModPruebas(key, valor);
            break;
        case 'checkModProduccion':
            checkboxcheckModProduccion(key, valor);
            break;
        case  'nIdFamilia1':
            addFamiliasArray(elemento, 1);
            break;
        case  'nIdFamilia2':
            addFamiliasArray(elemento, 2);
            break;
        case  'nIdFamilia3':
            addFamiliasArray(elemento, 3);
            break;
        case  'nIdFamilia4':
            addFamiliasArray(elemento, 4);
            break;
        case  'nIdFamilia5':
            addFamiliasArray(elemento, 5);
            break;
        case  'nIdFamilia6':
            addFamiliasArray(elemento, 6);
            break;
        case  'nIdFamilia7':
            addFamiliasArray(elemento, 7);
            break;
        case  'checkVigencia':
            checkcheckVigencia(key, valor);
            break;
        case 'checkDescFDM':
            checkboxComisionUsuarioFinal(key, valor);
            break;
        case 'checkDescGD':
            checkboxComisionUsuarioFinal(key, valor);
            break;
        case 'checkTicketResp':
            checkboxComisionUsuarioFinal(key, valor);
            break;
    }
}

function checkboxComisionUsuarioFinal(key, valor){
    let check = $('#' + key);

    $(".pagoComisiones").prop("checked",false);
    check.prop("checked",true);
}
function texttxtNumVigencia(key, valor){
    try {
        if ($('#fecContrato').val() != "") {
            calcularFechaVigencia();
        } else {
            mostrarSpanMsg(3, "alert-danger", 'No hay definida una fecha de contrato');
        }
    } catch (e) {
        jAlert('Error al calcular la fecha de vigencia del contrato');
    }
}

function txtfechaContrato(key, valor){
    $('#fecContrato').datepicker({
        /*minDate: new Date(),*/
        format: 'yyyy-mm-dd'
    });

    // Ejecuta la función cuando se llama a txtfechaContrato con el valor deseado

        if ($('#checkVigencia').is(':checked')) {
            calcularFechaVigenciaIndefinida();
        } else {
            calcularFechaVigencia();
        }
        $('#fecRevisionCondicion').val($('#fecRenovarContrato').val());

}
function checkboxcheckModPruebas(key, valor){
        let checkModPruebas = $('#checkModPruebas');
        !checkModPruebas.is(':checked') ? $('#divFechaModPruebas').hide() : $('#divFechaModPruebas').show();
        !checkModPruebas.is(':checked') ? $('#checkModProduccion').prop('disabled',false) : $('#checkModProduccion').prop('disabled',true);
}

function checkboxcheckModProduccion(key, valor){
    let checkModProduccion = $('#checkModProduccion');
    !checkModProduccion.is(':checked') ? $('#divFechaModProduccion').hide() : $('#divFechaModProduccion').show();
    !checkModProduccion.is(':checked') ? $('#checkModPruebas').prop('disabled',false) : $('#checkModPruebas').prop('disabled',true);
}

function checkcheckVigencia(key, valor){
    let nVigencia = parseInt($("#txtNumVigencia").val().trim());

    if ($('#' + key).is(':checked')){
        calcularFechaVigenciaIndefinida();
        $('#divNumVigencia').hide();
        $("#fecRevisionCondicion").prop("disabled",false);
    } else {
        $('#divNumVigencia').show();
        $("#fecRevisionCondicion").prop("disabled",true);
        if((isNaN(nVigencia) || nVigencia <= 0)){
            mostrarSpanMsg(3, "alert-danger", 'La vigencia debe ser un valor numérico y mayor a 0');
        }
    }
}

$(document).ready(function(){
    $("input, select").on('change', function(){
        let fieldName = $(this).prop('id');
        let fieldData = $(this).val();
        control_cambios.push({
            'fieldName'  : $(this).attr('id'),
        });
        // Verificamos si el nuevo cambio es diferente al original
        if($(this).prop('type') == 'text'){
            if(fieldData == mapForm[fieldName]){
                // Eliminar fieldName de control_cambios
                control_cambios = control_cambios.filter(function(item) {
                    return item.fieldName !== fieldName
                })
            }
        }

        // verificar solo el check seleccionado para comision a usuario final
        let checksComisionUsuarioFinalOriginal = ['checkDescFDM','checkDescGD','checkTicketResp'];
        if(checksComisionUsuarioFinalOriginal.includes(fieldName)) {
            $(".pagoComisiones").removeClass('controlCambios');
            let label = $(".pagoComisiones").parent().find('label');
            label.removeClass('text-warning');
            label.find('i').remove();
            control_cambios.forEach(function (element) {
                if (checksComisionUsuarioFinalOriginal.includes(element.fieldName)) {
                    if (!$("#" + element.fieldName).is(':checked')) {
                        if (element.fieldName != fieldName) {
                            control_cambios = control_cambios.filter(function (item) {
                                return item.fieldName !== element.fieldName
                            })
                        }
                    }else{
                        if(comisionUsuarioFinalOriginal[element.fieldName] == 1){
                            control_cambios = control_cambios.filter(function (item) {
                                return item.fieldName !== element.fieldName
                            })
                        }
                    }
                }
            });
        }

    });
})

/* control de cambios para datepicker*/
var date_piker_temporal;
$('.default-date-picker').on('focus', function(){
    date_piker_temporal = $(this).val();
});
$('.default-date-picker').on('blur', function(){
    let nuevo_valor  	= $(this).val();
    let id_input 		= $(this).prop('id');
    if(nuevo_valor != date_piker_temporal){
        if(!control_cambios.includes('id_input')){
            let fieldName = $(this).prop('id');
            control_cambios.push({
                'fieldName': fieldName
            });
        }
    }
    date_piker_temporal = null;
});

// Cerrar el popover al hacer clic en cualquier parte de la página
$(document).on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        // Verificar si el clic no se encuentra dentro del popover o del elemento que lo abre
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 &&
            $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

function actualizarControlCambios(seccion){
    const cambios = [];
    let tabs = {
        'sSeccion1' : 'step1',
        'sSeccion2' : 'step2',
        'sSeccion3' : 'step3',
        'sSeccion4' : 'step4',
        'sSeccion5' : 'step5',
        'sSeccion6' : 'step6',
        'sSeccion7' : 'step7'
    }
    $("#" + tabs[seccion]).find(".controlCambios").each(function(){
        let element_tipo    = $(this).prop('type');
        let valor           = $(this).val();
        switch (element_tipo) {
            case 'radio':
                valor = $("input[id="+$(this).attr('id')+"]:checked").val();
                break;
            case 'checkbox':
                valor = $(this).is(':checked') ? 'on' : 'off';
                break;
        }
        let excluyeFields = ['divCalendarioOperaciones', 'divCalendarioPago', 'divCalendarioCobro'];
        if(!excluyeFields.includes($(this).attr('id'))) {
            cambios.push({
                'fieldName': $(this).attr('id'),
                'fieldData': valor
            });
        }
    });
    for (let i = 0; i < control_cambios.length; i++) {
        const element = control_cambios[i];

        let element_tipo    = $("#"+element.fieldName).prop('type');
        let valor           = $("#"+element.fieldName).val();
        switch (element_tipo) {
            case 'radio':
                if($("#"+element.fieldName).prop('type') == 'radio'){
                    valor = $("input[id="+element.fieldName+"]:checked").val();
                }
                break;
            case 'checkbox':
                valor = $("#"+element.fieldName).is(':checked') ? 'on' : 'off';

                break;

        }
        /*let valor = $("#"+element.fieldName).val();
        if($("#"+element.fieldName).prop('type') == 'radio'){
            valor = $("input[id="+element.fieldName+"]:checked").val();
        }*/
        // Excluir checkbox de calendario: Lu_Check_Recaudo, Ma_Check_Recaudo, Mi_Check_Recaudo, Ju_Check_Recaudo, Vi_Check_Recaudo
        let excluyeInputs = [0, '', '0', '1', '2', '3', '4', '5', '6'];
        if(!excluyeInputs.includes(element.fieldName)){
            cambios.push({
                'fieldName'  : element.fieldName,
                'fieldData'  : valor,
            });
        }

    }
    // Para calendarios y correos de la seccion 5
    if(seccion == 'sSeccion5'){
        if(matrizCalendario_recaudo.length > 0){
            cambios.push({
                'fieldName'  : 'divCalendarioOperaciones',
                'fieldData'  : matrizCalendario_recaudo,
            })
        }
        if(matrizCalendario_pago.length > 0){
            cambios.push({
                'fieldName'  : 'divCalendarioPago',
                'fieldData'  : matrizCalendario_pago,
            })
        }
        if(matrizCalendario_cobro.length > 0){
            cambios.push({
                'fieldName'  : 'divCalendarioCobro',
                'fieldData'  : matrizCalendario_cobro,
            })
        }
        if(sCorreoEnvio_original.length != correosNotificaciones.length){ // Si el tamaño de los arreglos es diferente
            cambios.push({
                'fieldName'  : 'divCorreosNotificaciones',
                'fieldData'  : correosNotificaciones,
            })
        }else{ // si son iguales verificar si el contenido es diferente
            let correos_diferentes = false;
            sCorreoEnvio_original.forEach(function (correo) {
                if(!correosNotificaciones.includes(correo)){
                    correos_diferentes = true;
                }
            });

            if(correos_diferentes){
                cambios.push({
                    'fieldName'  : 'divCorreosNotificaciones',
                    'fieldData'  : correosNotificaciones,
                })
            }
        }
    }
    // Para correos de la seccion 6
    if(seccion === 'sSeccion6'){
        if(sCorreoDestino_original.length != correosenvfacturasComision.length){ // Si el tamaño de los arreglos es diferente
            cambios.push({
                'fieldName' : 'divCorreosFacturaComision',
                'fieldData' : correosenvfacturasComision
            })
        }else{ // si son iguales verificar si el contenido es diferente
            let correos_diferentes = false;
            sCorreoDestino_original.forEach(function (correo) {
                if(!correosenvfacturasComision.includes(correo)){
                    correos_diferentes = true;
                }
            });
            if(correos_diferentes){
                cambios.push({
                    'fieldName' : 'divCorreosFacturaComision',
                    'fieldData' : correosenvfacturasComision
                })
            }
        }
        if(sCorreoDestinoTae_original.length != correosenvfacturasTAE.length){ // Si el tamaño de los arreglos es diferente
            cambios.push({
                'fieldName' : 'divCorreosFacturaTAE',
                'fieldData' :   correosenvfacturasTAE
            })
        }else{ // si son iguales verificar si el contenido es diferente
            let correos_diferentes = false;
            sCorreoDestinoTae_original.forEach(function (correo) {
                if(!correosenvfacturasTAE.includes(correo)){
                    correos_diferentes = true;
                }
            });
            if(correos_diferentes){
                cambios.push({
                    'fieldName' : 'divCorreosFacturaTAE',
                    'fieldData' :   correosenvfacturasTAE
                })
            }
        }

    }
    if(cambios.length == 0){
        jAlert('No se detectaron cambios en la sección');
        return true;
    }
    cambios.push({
        'fieldName'  : 'status',
        'fieldData'  : 0, // Sin autorizar | 1: Autorizado
    })
    const payload = {
        'seccion'       : seccion,
        'nIdCliente'    : secciones['nIdCliente'],
        'nIdActualizacion' : secciones['nIdActualizacion'],
        'bRevisionSecciones' : secciones['bRevisionSecciones'],
        'tipo_actualizacion_control_cambios' : tipo_actualizacion_control_cambios,
        'dataSeccion'       : cambios,
        'usuario'           : usuario_id,
        'tipo'              : 1,
    }
    if(seccion == 'sSeccion1'){
        validacion = validacionesTipoCliente();
        if(validacion.error == 1){
            jAlert(validacion.mensaje);
            return false;
        }
    }
    if(seccion == 'sSeccion3'){
        validacion = validacionesRepLegalcontrato();
        if(validacion.error == 1){
            jAlert(validacion.mensaje);
            return false;
        }
    }
    if(seccion == 'sSeccion5'){
        validacion = validacionesLiquidaciones();
        if(validacion.error == 1){
            jAlert(validacion.mensaje);
            return false;
        }
    }
    if(seccion == 'sSeccion6'){
        validacion = validacionesFacturacion();
        if(validacion.error == 1){
            jAlert(validacion.mensaje);
            return false;
        }
    }
    // console.log({payload});
    $.ajax({
        url: BASE_PATH+'/MesaControl/cliente/ajax/actualizarControlCambios.php',
        type: 'POST',
        dataType: 'json',
        data: payload,
        beforeSend: function(){
            let array_tabs = {
                'sSeccion1' : 1,
                'sSeccion2' : 2,
                'sSeccion3' : 3,
                'sSeccion4' : 4,
                'sSeccion5' : 5,
                'sSeccion6' : 6,
                'sSeccion7' : 7
            }
            loadingApartados(array_tabs[seccion], false);
        },
        success: function(response){
            //loadingApartados(1, true);
            replegalYContratoCargado    = false;
            liquidacionesCargado        = false;
            facturacionCargado          = false;
            switch (seccion){
                case 'sSeccion1':
                    cargarApartadoTipoCliente();
                    break;
                case 'sSeccion2':
                    break;
                case 'sSeccion3':
                    cargarApartadoReplegalContrato();
                    break;
                case 'sSeccion4':
                    break;
                case 'sSeccion5':
                    cargarApartadoLiquidaciones();
                    break;
                case 'sSeccion6':
                    cargarApartadoFacturacion();
                    break;
                case 'sSeccion7':
                    break;

            }
        }
    });
}

function autorizaControlCambio(seccion){
    let data_secciones = JSON.parse(secciones[seccion]);
    let cambios_autorizacion = [];
    let validacion_status = terminarControlCambios(seccion);
    // recorrer objeto secciones
    for (const key in data_secciones) {
        cambios_autorizacion.push({
            'fieldName'  : key,
            'fieldData'  : (key === 'status') ? 1 : data_secciones[key],
        });
    }
    const payload = {
        'seccion'       : seccion,
        'nIdCliente'    : secciones['nIdCliente'],
        'nIdActualizacion' : secciones['nIdActualizacion'],
        'bRevisionSecciones' : (validacion_status) ? 2 : secciones['bRevisionSecciones'],
        'tipo_actualizacion_control_cambios' : tipo_actualizacion_control_cambios,
        'dataSeccion'       : cambios_autorizacion,
        'usuario'           : usuario_id,
        'tipo'              : 1,
    }
    $.ajax({
        url: BASE_PATH+'/MesaControl/cliente/ajax/actualizarControlCambios.php',
        type: 'POST',
        dataType: 'json',
        data: payload,
        beforeSend: function(){
            let array_tabs = {
                'sSeccion1' : 1,
                'sSeccion2' : 2,
                'sSeccion3' : 3,
                'sSeccion4' : 4,
                'sSeccion5' : 5,
                'sSeccion6' : 6,
                'sSeccion7' : 7
            }
            loadingApartados(array_tabs[seccion], false);
        },
        success: function(response){
            $('.text-warning').each(function(){
                let textLabel = $(this).text()
                $(this).empty();
                $(this).text(textLabel);
                $(this).removeClass('text-warning');
            });
            replegalYContratoCargado    = false;
            liquidacionesCargado        = false;
            facturacionCargado          = false;
            switch (seccion){
                case 'sSeccion1':
                    cargarApartadoTipoCliente();
                    break;
                case 'sSeccion2':
                    break;
                case 'sSeccion3':
                    cargarApartadoReplegalContrato();
                    break;
                case 'sSeccion4':
                    break;
                case 'sSeccion5':
                    cargarApartadoLiquidaciones();
                    break;
                case 'sSeccion6':
                    cargarApartadoFacturacion();
                    break;
                case 'sSeccion7':
                    break;

            }
        }
    });
}

function terminarControlCambios(seccion_a_validar){
    let validacion      = false;
    let objeto_secciones = Object.keys(secciones.allSecciones).reduce((result, key) => {
        result[key] = JSON.parse(secciones.allSecciones[key]);
        return result;
        }, {});

    // Filtras las secciones que tienen status 0
    let secciones_status_0 = Object.keys(objeto_secciones).filter(function(key) {
        return objeto_secciones[key].status == 0;
    });
    let secciones_status_1 = Object.keys(objeto_secciones).filter(function(key) {
        return objeto_secciones[key].status == 1;
    });

    if(secciones_status_0.length == 1 && secciones_status_0.find(element => element == seccion_a_validar)){
        validacion = true;
    }

    return validacion;


}

/*********
* Casos específicos
* */
function asignaRadiosEspecificos(key, input, seccion){
    if(key === 'nIdTipoAcceso'){

    }
}

function codificarCaracteresEspeciales(string){
    value_decode_string = decodeURIComponent(string.replace(/u([0-9a-fA-F]{4})/g, function (whole, group1) {
        return String.fromCharCode(parseInt(group1, 16));
    }))
    return value_decode_string;
}

const valoresPeriodo = Object.freeze({
    0: 'Lu_Check_Recaudo',
    1: 'Ma_Check_Recaudo',
    2: 'Mi_Check_Recaudo',
    3: 'Ju_Check_Recaudo',
    4: 'Vi_Check_Recaudo'
})

function setCalendario(calendario){
    let calendarios = calendario;
    for (let operacion of calendarios) {
        var tipo = "";
        var diaCorte = "";
        var dias = operacion.sDiasPago.split(",");

        switch(operacion.nTipoRegistro) {
            case "1":
                tipo = "Pago";
                break;
            case "2":
                tipo = "Cobro";
                break;
            case "3":
                tipo = "Recaudo";
                break;
            default:
                break;
        }

        switch(operacion.nDiaCorte) {
            case "0":
                diaCorte = "Lu";
                break;
            case "1":
                diaCorte = "Ma";
                break;
            case "2":
                diaCorte = "Mi";
                break;
            case "3":
                diaCorte = "Ju";
                break;
            case "4":
                diaCorte = "Vi";
                break;
            default:
                break;
        }

        // Desmarcar primero todos los checkbox
        for (let dia = 0; dia < 7; dia++) {
            let input = $("#"+dia+"."+diaCorte+"_Check_"+tipo);
            input.prop('checked', false);
            //$("#"+valoresPeriodo[dia]+"."+diaCorte+"_Check_"+tipo).attr('checked', false);
        }

        for (let dia of dias) {
            if (dia != "") {
                let input = $("#"+dia+"."+diaCorte+"_Check_"+tipo);
                input.prop('checked', true);
                //$("#"+dia+"."+diaCorte+"_Check_"+tipo).attr('checked', true);
            }
        }
    }
}

$('.Lu_Check_Recaudo, .Ma_Check_Recaudo, .Mi_Check_Recaudo, .Ju_Check_Recaudo, .Vi_Check_Recaudo').on('change', function(){
    screenShotCalendario('Recaudo');
});
$('.Lu_Check_Pago, .Ma_Check_Pago, .Mi_Check_Pago, .Ju_Check_Pago, .Vi_Check_Pago').on('change', function(){
    screenShotCalendario('Pago');
});
$('.Lu_Check_Cobro, .Ma_Check_Cobro, .Mi_Check_Cobro, .Ju_Check_Cobro, .Vi_Check_Cobro').on('change', function(){
    screenShotCalendario('Cobro');
});
function screenShotCalendario(tipo){

    // 1: pago #divCalendarioPago, 2: Cobro #divCalendarioCobro, 3: Recaudo #divCalendarioOperaciones

    let checks_Lu           = [];
    let checks_Ma           = [];
    let checks_Mi           = [];
    let checks_Ju           = [];
    let checks_Vi           = [];

    $('.Lu_Check_' + tipo).each(function(){
        if($(this).is(':checked')){
            checks_Lu.push($(this).prop('id'));
        }
    });
    $('.Ma_Check_' + tipo).each(function(){
        if($(this).is(':checked')){
            checks_Ma.push($(this).prop('id'));
        }
    });
    $('.Mi_Check_' + tipo).each(function(){
        if($(this).is(':checked')){
            checks_Mi.push($(this).prop('id'));
        }
    });
    $('.Ju_Check_' + tipo).each(function(){
        if($(this).is(':checked')){
            checks_Ju.push($(this).prop('id'));
        }
    });
    $('.Vi_Check_' + tipo).each(function(){
        if($(this).is(':checked')){
            checks_Vi.push($(this).prop('id'));
        }
    });

    switch (tipo) {
        case 'Pago':
            matrizCalendario_pago = [];
            matrizCalendario_pago.push(
                {'nDiaCorte' : 0, 'sDiasPago' : checks_Lu.join(','), 'nTipoRegistro' : 1, 'tipo': tipo},
                {'nDiaCorte' : 1, 'sDiasPago' : checks_Ma.join(','), 'nTipoRegistro' : 1, 'tipo': tipo},
                {'nDiaCorte' : 2, 'sDiasPago' : checks_Mi.join(','), 'nTipoRegistro' : 1, 'tipo': tipo},
                {'nDiaCorte' : 3, 'sDiasPago' : checks_Ju.join(','), 'nTipoRegistro' : 1, 'tipo': tipo},
                {'nDiaCorte' : 4, 'sDiasPago' : checks_Vi.join(','), 'nTipoRegistro' : 1, 'tipo': tipo}
            );
            break;
        case 'Cobro':
            matrizCalendario_cobro = [];
            matrizCalendario_cobro.push(
                {'nDiaCorte' : 0, 'sDiasPago' : checks_Lu.join(','), 'nTipoRegistro' : 2, 'tipo': tipo},
                {'nDiaCorte' : 1, 'sDiasPago' : checks_Ma.join(','), 'nTipoRegistro' : 2, 'tipo': tipo},
                {'nDiaCorte' : 2, 'sDiasPago' : checks_Mi.join(','), 'nTipoRegistro' : 2, 'tipo': tipo},
                {'nDiaCorte' : 3, 'sDiasPago' : checks_Ju.join(','), 'nTipoRegistro' : 2, 'tipo': tipo},
                {'nDiaCorte' : 4, 'sDiasPago' : checks_Vi.join(','), 'nTipoRegistro' : 2, 'tipo': tipo}
            );
            break;
        case 'Recaudo':
            matrizCalendario_recaudo = [];
            matrizCalendario_recaudo.push(
                {'nDiaCorte' : 0, 'sDiasPago' : checks_Lu.join(','), 'nTipoRegistro' : 3, 'tipo': tipo},
                {'nDiaCorte' : 1, 'sDiasPago' : checks_Ma.join(','), 'nTipoRegistro' : 3, 'tipo': tipo},
                {'nDiaCorte' : 2, 'sDiasPago' : checks_Mi.join(','), 'nTipoRegistro' : 3, 'tipo': tipo},
                {'nDiaCorte' : 3, 'sDiasPago' : checks_Ju.join(','), 'nTipoRegistro' : 3, 'tipo': tipo},
                {'nDiaCorte' : 4, 'sDiasPago' : checks_Vi.join(','), 'nTipoRegistro' : 3, 'tipo': tipo}
            );
            break;
    }

}

function mapFormulario(){
    let form = {};
    // obtener todos los inputs
    $('input, select').each(function(){
        let key = $(this).prop('id');
        let value = $(this).val();
        form[key] = value;
    });

    mapForm = form;

}

// Validación para cunado se cambia el tipo de liquidación con los valores de ¿Cliente retiene su comision? para que al regresar el tipo de liquidación se regresen los valores de este campo tambien
// Detectar cambio sobre radio con name tipoLiqRecaudo
$("input[name=tipoLiqRecaudo]").on('change', function(){
   let tipo_liquidacion = $(this).val();
   console.log(tipo_liquidacion);
   if(tipo_liquidacion == 1){
       if(!datos_seccion.hasOwnProperty('cmbRetieneComision')) {
           $("#cmbPeriodoPagoCom").val(mapForm['cmbPeriodoPagoCom']).trigger('change');
           let calendrioPago = calendario.filter(function (calendario) {
               return calendario.nTipoRegistro == '1';
               setCalendario(calendrio);
           });
       }
   }
   if(tipo_liquidacion == 2){
       $("#cmbRetieneComision").val(mapForm['cmbRetieneComision']).trigger('change');
   }
});
function validacionesTipoCliente(){
    let fechaModPruebas = $('#fecPruebas').val();
    let fechaModProduccion = $('#fecProduccion').val();
    let nSolicitante = $("#cmbSolicitante").val();
    let respuesta = {
        error: 0,
        mensaje: ''
    }


    // Campos obligatorios
    if (!nSolicitante || nSolicitante == "-1" || nSolicitante == "0") {
        respuesta = {
            error: 1,
            mensaje: 'El solicitante es obligatorio'
        }
    }

    if (!$("#txtIdCadena").val() || $("txtSCadena").val() == "") {
        respuesta = {
            error: 1,
            mensaje: 'La cadena es obligatoria'
        }
    }

    if ($("input[name=nIdTipoAcceso]:checked").length <= 0) {
        respuesta = {
            error: 1,
            mensaje: 'Debe seleccionar un tipo de acceso'
        }
    }

    if (famsarr.length == 0) {
        respuesta = {
            error: 1,
            mensaje: 'Al menos una familia deber ser seleccionada'
        }
    }

    if ($("input[name=gbTipoPersona]:checked").length < 0) {
        respuesta = {
            error: 1,
            mensaje: 'Debe seleccionar un tipo de cliente'
        }
    }

    if (!$("#cmbticket").val() || $("#cmbticket").val() == "-1") {
        respuesta = {
            error: 1,
            mensaje: 'Debe seleccionar un tipo de ticket fiscal'
        }
    }

    if (!$("#cmbforelo").val() || $("#cmbforelo").val() == "-1") {
        respuesta = {
            error: 1,
            mensaje: 'Debe seleccionar cuántas cuentas forelo posee el cliente'
        }
    }

    if (!$("#cmbReqFacTAE").val() || $("#cmbReqFacTAE").val() == "-1") {
        respuesta = {
            error: 1,
            mensaje: 'Debe seleccionar si el cliente requiere la factura TAE'
        }
    }

    // Fisica RFC y NF
    if ($("input[name=gbTipoPersona]:checked").val() == "1") {
        if ($('#checkFisicaGeneral').is(':checked')) {
            personaFisica = 2;
        } else {
            personaFisica = 1;
        }
    }
    // Moral
    else {
        personaFisica = 0;
    }

    return respuesta;
}
function validacionesLiquidaciones(){
    // VALIDACIONES EN LIQUIDACIONES GENERALES
    let tipoRecaudoVal = $("input[name=tipoLiqRecaudo]:checked").val();
    let tipoLiquidacionOp = $("#cmbTipoLiquidacionOperaciones").val();
    let tnDiasOp = $('#tnDiasOperaciones').val();
    let nDiaPagoOp = $("#cmbSemanalDiaOperaciones").val();
    let nDiaAtrasOp = $("#semanalAtrasOperaciones").val();
    let calendarioOp = getDiasCalendarios("Recaudo");
    let montoLimiteCredito = $("#montoLimiteCredito").val();
    let nRetieneComision = $("#cmbRetieneComision").val();
    let respuesta = {
        error: 0,
        mensaje: ''
    };
    if (!tipoRecaudoVal) {
        //return mostrarSpanMsg(5, "alert-danger", 'Seleccione un tipo de recaudo');
        respuesta = {
            error: 1,
            mensaje: 'Seleccione un tipo de recaudo'
        }
    }

    if (tipoRecaudoVal == "2") {
        if (!montoLimiteCredito || parseFloat(montoLimiteCredito) < 0) {
            respuesta = {
                error: 1,
                mensaje: 'El monto de límite de crédito debe ser mayor o igual a 0'
            };
        }

        if (!nRetieneComision || nRetieneComision == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Debe seleccionar si el cliente retiene comisión'
            }
        }

        if (tipoLiquidacionOp == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Debe seleccionar un tipo de liquidación para recuado'
            }
        }
        else if (tipoLiquidacionOp == "1") {
            // Tndias
            if (!tnDiasOp || parseInt(tnDiasOp) <= 0) {
                respuesta = {
                    error: 1,
                    mensaje: 'El valor de T+n días debe ser mayor a 0'
                }
            }
            nDiaAtrasOp = "NULL";
            nDiaPagoOp = "NULL";
            calendarioOp = calendarioDefault;
        }
        else if (tipoLiquidacionOp == "2") {
            // Calendario
            if (contarCheckCalendario("Recaudo") == 0) {
                respuesta = {
                    error: 1,
                    mensaje: 'Configure el calendario de liquidaciones'
                }
            }
            nDiaAtrasOp = "NULL";
            nDiaPagoOp = "NULL";
            tnDiasOp = "NULL";
        }
        else if (tipoLiquidacionOp == "4") {
            // Semanal
            if (!nDiaPagoOp || nDiaPagoOp == "-1") {
                respuesta = {
                    error: 1,
                    mensaje: 'Debe seleccionar una día de pago'
                }
            }
            if (!nDiaAtrasOp || parseInt(nDiaAtrasOp) < 0) {
                respuesta = {
                    error: 1,
                    mensaje: 'El valor de días hacia atras debe ser mayor o igual a 0'
                }
            }
            tnDiasOp = "NULL";
            calendarioOp = calendarioDefault;
        }
    } else {
        tnDiasOp = "NULL";
        nDiaAtrasOp = "NULL";
        nDiaPagoOp = "NULL";
        nRetieneComision = "NULL";
        tipoLiquidacionOp = -1;
        montoLimiteCredito = 0;
        calendarioOp = calendarioDefault;
    }
    var validaCobroVal = $("#cmb_valida_monto").val();
    if ((!validaCobroVal || validaCobroVal == "-1") && ($("input[name='nIdTipoAcceso']:checked").val() !== '3') ) {
        respuesta = {
            error: 1,
            mensaje: 'Seleccione si el sistema valida cobro'
        }
    }

    var comisionIntegradorVal = 0;
    if ($('#checkIntegrador').is(':checked')) {
        var valCmbComision = $("#cmbComisionIntegrador").val();
        if (!valCmbComision || valCmbComision == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione si hay comisión adicional como integrador'
            }
        } else {
            if (valCmbComision == "1") {
                comisionIntegradorVal = $("#nMontoIntegrador").val()
                if (!comisionIntegradorVal || parseFloat(comisionIntegradorVal) <= 0) {
                    respuesta = {
                        error: 1,
                        mensaje: 'El valor de comisión como integrador debe ser mayor a 0'
                    }
                }
            } else {
                comisionIntegradorVal = 0;
            }
        }
    }
    let tipoLiquidacionPago = $("#cmbPeriodoPagoCom").val();
    let tnDiasPago = $('#tnDiasPago').val();
    let nPagoDiaPago = $("#cmbSemanalDiaPago").val();
    let nDiaAtrasPago = $("#semanalAtrasPago").val();
    let calendarioPago = getDiasCalendarios("Pago");

    if (nRetieneComision == "1") {
        tipoLiquidacionPago = "-1";
        tnDiasPago = "NULL";
        nDiaAtrasPago = "NULL";
        nPagoDiaPago = "NULL";
        calendarioPago = calendarioDefault;
    }
    else if (tipoLiquidacionPago == "-1" && tipoRecaudoVal == "2") {
        respuesta = {
            error: 1,
            mensaje: 'Debe seleccionar un Período para pago de comisiones'
        }
    }
    else if (tipoLiquidacionPago == "1") {
        // Tndias
        if (!tnDiasPago || parseInt(tnDiasPago) <= 0) {
            respuesta = {
                error: 1,
                mensaje: 'El valor de T+n días debe ser mayor a 0'
            }
        }
        nDiaAtrasPago = "NULL";
        nPagoDiaPago = "NULL";
        calendarioPago = calendarioDefault;
    }
    else if (tipoLiquidacionPago == "2") {
        // Calendario
        if (contarCheckCalendario("Pago") == 0) {
            respuesta = {
                error: 1,
                mensaje: 'Configure el calendario de liquidaciones para pago'
            }
        }
        nDiaAtrasPago = "NULL";
        nPagoDiaPago = "NULL";
        tnDiasPago = "NULL";
    }
    else if (tipoLiquidacionPago == "4") {
        // Semanal
        if (!nPagoDiaPago || nPagoDiaPago == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Debe seleccionar una día de pago'
            }
        }
        if (!nDiaAtrasPago || parseInt(nDiaAtrasPago) < 0) {
            respuesta = {
                error: 1,
                mensaje: 'El valor de días hacia atras debe ser mayor o igual a 0'
            }
        }
        tnDiasPago = "NULL";
        calendarioPago = calendarioDefault;
    }

    if (correosNotificaciones.length == 0) {
        respuesta = {
            error: 1,
            mensaje: 'Debe agregar un correo para el pago de comisiones'
        }
    }

    let nIdBanco = $("#cmbBancoPago").val();
    let sNumCuenta = $("#txtCuenta").val();
    let sCLABE = $("#txtCLABE").val();
    let sBeneficiario = $("#txtBeneficiario").val() || "";
    let nIdPaisPago = $("#cmbPaisPago").val() || "NULL";
    let sSwift = $("#txtsSwift").val();
    let sABA = $("#txtABA").val();
    let nIdMonedaExt = $("#cmbMonedaExt").val() || "NULL";

    var cmbPeriodoPrePagoCom = $("#cmbPeriodoPrepPagoCom").val();
    if (!cmbPeriodoPrePagoCom || cmbPeriodoPrePagoCom == "-1") {
        respuesta = {
            error: 1,
            mensaje: 'Debe seleccionar el tipo de prepago para el pago de comisiones'
        }
    }

    if (!nIdBanco || nIdBanco == "-1") {
        respuesta = {
            error: 1,
            mensaje: 'Debe colocar una clabe válida'
        }
    }
    if (!sNumCuenta || sNumCuenta == "") {
        respuesta = {
            error: 1,
            mensaje: 'Debe colocar una clabe válida'
        }
    }
    if (!sCLABE || sCLABE == "") {
        respuesta = {
            error: 1,
            mensaje: 'CLABE es requerido'
        }
    }
    // if (!sBeneficiario || sBeneficiario == "") {
    //     return;
    // }
    if (sSwift != "" && (sSwift.length < 8 || sSwift.length > 11)) {
        respuesta = {
            error: 1,
            mensaje: 'Código Swift es incorrecto, debe ingresar un valor de 8 a 11 dígitos alfanuméricos'
        }
    }
    if (sABA != "" && sABA.length != 9) {
        respuesta = {
            error: 1,
            mensaje: 'Código ABA es incorrecto, debe ingresar un código de 9 dígitos'
        }
    }

    // APARTADO DE COBRO DE COMISIONES
    let nCobroComisiones = 0;
    let nTipoLiquidacionCobro = $("#cmbPeriodoCobroCom").val() || "NULL";
    let nIdCuentaRE = $("#cmbCuentaRED").val() || "NULL";
    let nCobroTnDias = $("#tnDiasCobro").val() || "NULL";
    let nCobroDiaPago = $("#cmbSemanalDiaCobro").val() || "NULL";
    let nCobroDiasAtras = $("#semanalAtrasCobro").val() || "NULL";
    let calendarioCobro = getDiasCalendarios("Cobro");

    if ((nTipoLiquidacionCobro != "NULL" && nTipoLiquidacionCobro != "-1") || (nIdCuentaRE != "NULL" && nIdCuentaRE != "-1")) {

        if (nTipoLiquidacionCobro == "-1" || nTipoLiquidacionCobro == "NULL") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione un tipo de liquidación para el cobro'
            }
        }

        if (nIdCuentaRE == "-1" || nIdCuentaRE == "NULL") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione una cuenta de RED'
            }
        }

        if (nTipoLiquidacionCobro == "1") {
            // Tndias
            if (nCobroTnDias == "NULL" || parseInt(nCobroTnDias) <= 0) {
                respuesta = {
                    error: 1,
                    mensaje: 'El valor de T+n días debe ser mayor a 0'
                }
            }
            nCobroDiasAtras = "NULL";
            nCobroDiaPago = "NULL";
            calendarioCobro = calendarioDefault;
        }
        else if (nTipoLiquidacionCobro == "2") {
            // Calendario
            if (contarCheckCalendario("Cobro") == 0) {
                respuesta = {
                    error: 1,
                    mensaje: 'Configure el calendario de liquidaciones para cobro'
                }
            }
            nCobroDiasAtras = "NULL";
            nCobroDiaPago = "NULL";
            nCobroTnDias = "NULL";
        }
        else if (nTipoLiquidacionCobro == "4") {
            // Semanal
            if (nCobroDiaPago == "NULL" || nCobroDiaPago == "-1") {
                respuesta = {
                    error: 1,
                    mensaje: 'Debe seleccionar una día de pago'
                }
            }
            if (nCobroDiasAtras == "NULL" || parseInt(nCobroDiasAtras) < 0) {
                respuesta = {
                    error: 1,
                    mensaje: 'El valor de días hacia atras debe ser mayor o igual a 0'
                }
            }
            nCobroTnDias = "NULL";
            calendarioCobro = calendarioDefault;
        }

        nCobroComisiones = 1;
    } else {
        nCobroTnDias = "NULL";
        nCobroDiasAtras = "NULL";
        nCobroDiaPago = "NULL";
        nIdCuentaRE = "NULL";
        nTipoLiquidacionCobro = "NULL";
        calendarioCobro = calendarioDefault;
    }

    return respuesta;
}

function validacionesRepLegalcontrato(){
    let nombreRep       = $("#sNombreReplegal").val().trim();
    let apPaternoRep    = $("#sPaternoReplegal").val().trim();
    let apMaternoRep    = $("#sMaternoReplegal").val().trim();
    let numIdent        = $("#numeroIdentificacion").val().trim();
    let tipoIdent       = $("#cmbIdentificacion").val();
    let fechaContrato   = $("#fecContrato").val();
    let fechaCondicion  = $("#fecRevisionCondicion").val();
    let nVigencia = parseInt($("#txtNumVigencia").val().trim());
    let respuesta= {
        error: 0,
        mensaje: ''
    };

    //if( $("#cmbticket").val() !== '0') {
    if( $("#gbPersonaMoral").prop("checked") ) {
        if (!nombreRep || nombreRep == "") {
            respuesta = {
                error: 1,
                mensaje: 'Captura del nombre del Representante Legal'
            }
        } else if (nombreRep.length < 3) {
            respuesta = {
                error: 1,
                mensaje: 'La Longitud M\u00EDnima para el Nombre del Representante Legal es de 3 caracteres'
            }
        } else if (nombreRep.length > 50) {
            respuesta = {
                error: 1,
                mensaje: 'La Longitud M\u00E1xima para el Nombre del Representante Legal es de 50 caracteres'
            }
        }

        if (!apPaternoRep || apPaternoRep == "") {
            respuesta = {
                error: 1,
                mensaje: 'Captura Apellido Paterno del Representante Legal'
            }
        }
        else if (apPaternoRep.length < 3) {
            respuesta = {
                error: 1,
                mensaje: 'La Longitud M\u00EDnima para el Apellido Paterno del Representante Legal es de 3 caracteres'
            }
        }
        else if (apPaternoRep.length > 50) {
            respuesta = {
                error: 1,
                mensaje: 'La Longitud M\u00E1xima para el Apellido Paterno del Representante Legal es de 50 caracteres'
            }
        }

        if (!apMaternoRep || apMaternoRep == "") {
            respuesta = {
                error: 1,
                mensaje: 'Captura Apellido Materno del Representante Legal'
            }
        }
        else if (apMaternoRep.length < 3) {
            respuesta = {
                error: 1,
                mensaje: 'La Longitud M\u00EDnima para el Apellido Materno del Representante Legal es de 3 caracteres'
            }
        }
        else if (apMaternoRep.length > 50) {
            respuesta = {
                error: 1,
                mensaje: 'La Longitud M\u00E1xima para el Apellido Materno del Representante Legal es de 50 caracteres'
            }
        }

        if (!tipoIdent || tipoIdent == "" || tipoIdent == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione un Tipo de Identificación del Representante Legal'
            }
        }

        if (!numIdent || numIdent == "") {
            respuesta = {
                error: 1,
                mensaje: 'Captura Número de Identificación del Representante Legal'
            }
        } else {
            var showmsg = false;

            if(tipoIdent == "1" && numIdent.length != 13) {
                showmsg = true;
            }
            // else if(tipoIdent == "2" && !validarFormatoCartillaMilitar(numIdent)) {
            else if(tipoIdent == "2" && numIdent.length != 10) {
                showmsg = true;
            }
            else if(tipoIdent == "3" && !validarFormatoPasaporte(numIdent)) {
                showmsg = true;
            }
            else if(tipoIdent == "4" && !validarFormatoCedulaProfesional(numIdent)) {
                showmsg = true;
            }

            if(showmsg){
                respuesta = {
                    error: 1,
                    mensaje: 'El Formato del N\u00FAmero de identificaci\u00F3n es Incorrecto'
                }
            }
        }
    }

    if (!$('#checkVigencia').is(':checked') && (isNaN(nVigencia) || nVigencia <= 0)){
        respuesta = {
            error: 1,
            mensaje: 'La vigencia debe ser un valor numérico y mayor a 0'
        }
    }
    return respuesta;
}

function validacionesFacturacion(){
    let sUsoCFDI = $("#cmbCFDIComision").val();
    let sClaveProductoServicio = $("#cmbProductoServicioComision").val();
    let sUnidad = $("#cmbClaveUnidadComision").val();
    let sFormaPago = $("#cmbFormaPagoComision").val();
    let sMetodoPago = $("#cmbMetodoPagoComision").val();
    let sCorreoDestino = correosenvfacturasComision.join(':');
    let nPeriodoFacturacion = $("#periocidadComision").val();
    let nDiaFacturacionSemanal = $("#diasLiquidacionComision").val();
    let nIVAComision = $("#cmbIVAComision").val();
    let respuesta = {
        error: 0,
        mensaje: ''
    }

    if($("#cmbticket").val()*1 > 0 ) {
        if (!sUsoCFDI || sUsoCFDI == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione el uso de CFDI en factura de comisiones'
            }

        }

        if (!sClaveProductoServicio || sClaveProductoServicio == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione la clave del producto en factura de comisiones'
            }

        }

        if (!sFormaPago || sFormaPago == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione la forma de pago en factura de comisiones'
            }

        }

        if (!sUnidad || sUnidad == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione la clave de unidad en factura de comisiones'
            }

        }

        if (!sMetodoPago || sMetodoPago == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione el método de pago en factura de comisiones'
            }

        }

        if (!nPeriodoFacturacion || nPeriodoFacturacion == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione el período de facturación en factura de comisiones'
            }

        }

        if (!nDiaFacturacionSemanal || parseInt(nDiaFacturacionSemanal) < 0) {
            respuesta = {
                error: 1,
                mensaje: 'El día de facturación debe ser mayor o igual a 0'
            }

        }

        if (correosenvfacturasComision.length == 0) {
            respuesta = {
                error: 1,
                mensaje: 'Ingrese un correo para el envío de factura de comisiones'
            }

        }
    }

    if (!nIVAComision || nIVAComision == "-1") {
        respuesta = {
            error: 1,
            mensaje: 'Seleccione el IVA aplicable a las facturas de comisiones'
        }

    }

    let nFacturaTAE = $('#cmbReqFacTAE').val();
    let sUsoCFDITAE = $("#cmbCFDITAE").val();
    let sClaveProductoServicioTAE = $("#cmbProductoServicioTAE").val();
    let sUnidadTAE = $("#cmbClaveUnidadTAE").val();
    let sFormaPagoTAE = $("#cmbFormaPagoTAE").val();
    let sMetodoPagoTAE = $("#cmbMetodoPagoTAE").val();
    let sCorreoDestinoTAE = correosenvfacturasTAE.join(':');
    let nPeriodoFacturacionTAE = $("#periocidadTAE").val();
    let nDiaFacturacionSemanalTAE = $("#diasLiquidacionTAE").val();

    if (nFacturaTAE == "1") {

        if (!sUsoCFDITAE || sUsoCFDITAE == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione el uso de CFDI en factura TAE'
            }

        }

        if (!sClaveProductoServicioTAE || sClaveProductoServicioTAE == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione la clave del producto en factura TAE'
            }

        }

        if (!sFormaPagoTAE || sFormaPagoTAE == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione la forma de pago en factura TAE'
            }

        }

        if (!sUnidadTAE || sUnidadTAE == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione la clave de unidad en factura TAE'
            }

        }

        if (!sMetodoPagoTAE || sMetodoPagoTAE == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione el método de pago en factura TAE'
            }

        }

        if (!nPeriodoFacturacionTAE || nPeriodoFacturacionTAE == "-1") {
            respuesta = {
                error: 1,
                mensaje: 'Seleccione el período de facturación en factura TAE'
            }

        }

        if (!nDiaFacturacionSemanalTAE || parseInt(nDiaFacturacionSemanalTAE) < 0) {
            respuesta = {
                error: 1,
                mensaje: 'El día de facturación debe ser mayor o igual a 0'
            }

        }

        if (correosenvfacturasTAE.length == 0) {
            respuesta = {
                error: 1,
                mensaje: 'Ingrese un correo para el envío de factura TAE'
            }

        }
    }

    let nRetieneISR = $("#nRetieneISR").val();
    let nRetieneIVA = $("#nRetieneIVA").val();

    if (!nRetieneISR || nRetieneISR == "-1") {
        respuesta = {
            error: 1,
            mensaje: 'Especifique si el cliente retiene ISR'
        }

    }

    if (!nRetieneIVA || nRetieneIVA == "-1") {
        respuesta = {
            error: 1,
            mensaje: 'Especifique si el cliente retiene IVA'
        }

    }
    return respuesta;
}