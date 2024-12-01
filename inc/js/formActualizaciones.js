var ctrlCambios = [];
var actSecciones = [];

let popoverOpen = "";
$(document).ready(function() {
    $('html').click(function(e) {
        var $elem = e.target;
        if($elem.tagName == 'HTML' || $($elem).prop('id').indexOf('popover') == -1 || popoverOpen != $($elem).prop('id')) {
            //$('[data-toggle="popover"]').popover('hide');
            $(document.getElementById(popoverOpen)).popover('hide');
        } else {
            $('[data-toggle="popover"]').not(document.getElementById(popoverOpen)).popover('hide');
            /*$('[data-toggle="popover"]').popover('hide');
            $(document.getElementById(popoverOpen)).popover('show');*/
        }
    });
});

$(document).on( 'click', '.PO', function () {
    popoverOpen = $(this).prop("id");
});

$(document).on( 'change', '.ctrlCambios', function (e) {
    addFields(this);
});
$("#row_0").on('click', function(){
    // Para escalonadas si ya tiene comisiones escalonadas previamente
    if($(this).hasClass('ctrlCambios')){
        addFields(this);
    }
})

function addFields(field, changed=true) {
    let fieldName = "#" + $(field).attr("id");
    let pagoCalendario = ["Lu_Check","Ma_Check","Mi_Check","Ju_Check","Vi_Check","Sa_Check","Do_Check"];
    let comisionesFijas = ['radcom1', 'radcom2'];
    if(pagoCalendario.includes($(fieldName).attr('name'))) fieldName = "#pCalendario";
    if(comisionesFijas.includes($(fieldName).attr('id'))) {
        let radioSeleccionado = $("input[name=radcom]:checked").attr('id');
        if(radioSeleccionado === 'radcom1') {
            // Eliminar radcom2 de ctrlCambios
            ctrlCambios = ctrlCambios.filter(f => f !== '#radcom2');
            labelRadcom2 = $("#radcom2").parent().removeClass('text-warning').find('i');
            labelRadcom2.remove();
        } else if(radioSeleccionado === 'radcom2') {
            // Eliminar radcom1 de ctrlCambios
            ctrlCambios = ctrlCambios.filter(f => f !== '#radcom1');
            labelRadcom1 = $("#radcom1").parent().removeClass('text-warning').find('i');
            labelRadcom1.remove();
        }
    }
    if(!ctrlCambios.includes(fieldName)) {/*
        if(fieldName.includes("radcom")) {
            addFields($("input[name=radcom]").not(field));
        }*/
        ctrlCambios.push(fieldName);
        // addPopover(fieldName, $(field).val(), true, changed);
    } else if($(fieldName).attr('type') == "checkbox") {
        //ctrlCambios.splice( ctrlCambios.indexOf(fieldName) , 1);
    }
    $(function () {
        $('[data-toggle="popover"]').popover()
    });
}
function updateData(step) {
    if(actSecciones.length > 0){
        actSecciones.forEach(function (seccion, i) {

            if (seccion !== null) {
                for (const [key, value] of Object.entries(seccion)) {
                    // console.log(key, value);
                    if (!ctrlCambios.includes(key) && i === step) {
                        ctrlCambios.push(key);
                    }
                    if (key.includes("dSubCadena")) {
                        if(key.replace('#dSubCadena-', '') == value['idsubcadena']) {
                            if($(key).length > 0) {
                                $("#listNG-"+value['idsubcadena']).remove();
                            }
                            subcadenaRow(value['id'], value['idsubcadena'], value['subcadena'], value['grupo'], value['impfijo'], value['impper'], value['idsub'], false);
                            //let valueText = JSON.stringify(value);
                            let subcadena = datosReceptor.subcadena;
                            let index = subcadena.findIndex(x => x.nIdSub === value['idsubcadena']);
                            let text = "";
                            if(index >= 0) {
                                text = subcadena[index]['sSubcadena'] + ' - ' + subcadena[index]['sNombreGrupo'];
                            }
                            addPopover(key, text, false);
                            if(value['idsubcadena'].includes("g")) {
                                nListNSC++;
                            }
                        }
                            $(".noData").remove();/*
                        } else {
                            $(".noData").remove();
                            let html = "<tr class='noData'>" +
                                "<td colspan='5' style='text-align: center;font-size: 11px;'>" +
                                "No hay datos de subcadenas." +
                                "</td>" +
                                "</tr>";
                            $(".listNG").find("tbody").append(html);
                        }*/
                    } else if (key.includes("#pCalendario")) {
                        var dia = {0: "Lunes", 1: "Martes", 2: "Miércoles", 3: "Jueves", 4: "Viernes", 5: "Sábado", 6: "Domingo"};
                        var text = "<div class='xs6' style='font-weight: bold;'>Día de corte</div><div class='xs6' style='font-weight: bold;'>Día de pago</div>"+"<br>";
                        datosReceptor.cobroCadena.forEach(function (params,i) {
                            text += "<div class='xs6'>"+dia[params.nDiaCorte]+"</div><div class='xs6'>"+dia[params.nDiaPago]+"</div><br>";
                        })
                        addPopover(key, text);
                        let dat = value;
                        $("input[name=Lu_Check]").attr("checked", false);
                        $("input[name=Ma_Check]").attr("checked", false);
                        $("input[name=Mi_Check]").attr("checked", false);
                        $("input[name=Ju_Check]").attr("checked", false);
                        $("input[name=Vi_Check]").attr("checked", false);
                        $("input[name=Sa_Check]").attr("checked", false);
                        $("input[name=Do_Check]").attr("checked", false);
                        for (var i = 0; i < dat.length; i++) {
                            if (dat[i][0] == 0) {
                                $('#Lu_Check' + dat[i]['1']).click();
                            }
                            if (dat[i][0] == 1) {
                                $('#Ma_Check' + dat[i]['1']).click();
                            }
                            if (dat[i][0] == 2) {
                                $('#Mi_Check' + dat[i]['1']).click();
                            }
                            if (dat[i][0] == 3) {
                                $('#Ju_Check' + dat[i]['1']).click();
                            }
                            if (dat[i][0] == 4) {
                                $('#Vi_Check' + dat[i]['1']).click();
                            }
                            if (dat[i][0] == 5) {
                                $('#Sa_Check' + dat[i]['1']).click();
                            }
                            if (dat[i][0] == 6) {
                                $('#Do_Check' + dat[i]['1']).click();
                            }
                        }
                    }else if(key === '#row_0' && value !== null){
                        $("#contenedorEscalonado").prepend('<label>Cambios en escalonadas</label>');
                        addPopover(key, value);
                        var IVAGeneral = parseFloat(datosReceptor['datosGral'][0]['nIVA']) / 100;

                        limpiarMatrizEscalonada();
                        for (var i = 0; i < value.length; i++) {
                            if (parseFloat(value[i]["nMontoMin"]) == 1) { $("#min_0").val(parseFloat(0.01)); } else { $("#min_0").val(parseFloat(value[i]["nMontoMin"])); }
                            if (parseFloat(value[i]["nMontoMax"]) == 0) {
                                $("#max_0").val(parseFloat(value[i]["nMontoMax"]));
                            } else {
                                $("#max_0").val(parseFloat(value[i]["nMontoMax"]).toFixed(2));
                            }
                            let nCostoTotal = parseFloat(value[i]["nCosto"])
                            let nCostoEsc = nCostoTotal / (1 + IVAGeneral);
                            let ivaCostoEsc = (parseFloat(nCostoTotal) - parseFloat(nCostoEsc))
                            $("#comision_0").val(nCostoEsc.toFixed(4)); ///changed

                            var nPorcentajeComTotal = parseFloat(value[i]["nPorcentajeCom"])
                            var PorcentajeCom = nPorcentajeComTotal / (1 + IVAGeneral);
                            var ivaPorcentajeCom = parseFloat(nPorcentajeComTotal) - parseFloat(PorcentajeCom)

                            $("#comisionPorcentaje_0").val((PorcentajeCom * 100)); ///changed
                            // console.log(value);
                            //console.log({min, minN, max, maxN, nCostoTotal, nCostoEsc, ivaCostoEsc, nPorcentajeComTotal, PorcentajeCom, ivaPorcentajeCom});

                            // return false;
                            agregarFilaCadena()
                        }
                    } else {
                        addPopover(key, value);
                        if(key === '#checkEscalonado' && value !== null) {
                            var IVAGeneral = parseFloat(datosReceptor['datosGral'][0]['nIVA']) / 100;

                            limpiarMatrizEscalonada();
                            for (var i = 0; i < value.length; i++) {
                                if (parseFloat(value[i]["nMontoMin"]) == 1) { $("#min_0").val(parseFloat(0.01)); } else { $("#min_0").val(parseFloat(value[i]["nMontoMin"])); }
                                if (parseFloat(value[i]["nMontoMax"]) == 0) {
                                    $("#max_0").val(parseFloat(value[i]["nMontoMax"]));
                                } else {
                                    $("#max_0").val(parseFloat(value[i]["nMontoMax"]).toFixed(2));
                                }
                                let nCostoTotal = parseFloat(value[i]["nCosto"])
                                let nCostoEsc = nCostoTotal / (1 + IVAGeneral);
                                let ivaCostoEsc = (parseFloat(nCostoTotal) - parseFloat(nCostoEsc))
                                $("#comision_0").val(nCostoEsc.toFixed(4)); ///changed

                                var nPorcentajeComTotal = parseFloat(value[i]["nPorcentajeCom"])
                                var PorcentajeCom = nPorcentajeComTotal / (1 + IVAGeneral);
                                var ivaPorcentajeCom = parseFloat(nPorcentajeComTotal) - parseFloat(PorcentajeCom)

                                $("#comisionPorcentaje_0").val((PorcentajeCom * 100)); ///changed
                                // console.log(value);
                                //console.log({min, minN, max, maxN, nCostoTotal, nCostoEsc, ivaCostoEsc, nPorcentajeComTotal, PorcentajeCom, ivaPorcentajeCom});

                                // return false;
                                agregarFilaCadena()
                            }
                        }
                    }
                }
            }
        });
        $(function () {
            $('[data-toggle="popover"]').popover()
        });
    }
}

function clearCtrlCambios(step) {
    ctrlCambios = [];
    if(actSecciones[step] != null) {
        for (const [key, value] of Object.entries(actSecciones[step])) {
            // console.log(key, value);
            if (!ctrlCambios.includes(key)) {
                ctrlCambios.push(key);
            }
        }
    }
}

function addPopover(key, value, newChage = false, changed = false) {

    let contenedorValor = null;
    let label 			= null;
    let input 			= null;
    if($(key).prop('nodeName') === 'DIV') {
        contenedorValor = $(key);
        label 			= contenedorValor.find("label");
        input 			= contenedorValor.children().last();
    }  else if ($(key).prop('nodeName') === 'BUTTON') {
        if(key === '#row_0'){
            contenedorValor = $("#contenedorEscalonado");
            label 			= contenedorValor.find("label");
            input 			= $(key);
        }else {
            contenedorValor = $(key).parent().parent().parent();
            label = contenedorValor.find("label");
            input = $(key);
        }
    } else if($(key).attr('type') == "checkbox") {
        contenedorValor = $(key).parent();/*
        label 			= contenedorValor;
        input 			= contenedorValor.children().last();*/
        if(contenedorValor.prop('nodeName') === 'TD') {
            contenedorValor = $(key);
            input 			= $(key);
            label 			= $(key);
        } else {
            label 			= contenedorValor;
            input 			= contenedorValor.children().last();
        }
        if(key === '#chkComisionCadena'){
            /*if(actSecciones[5]['#chkComisionCadena'] === 'true'){
                console.log('Esta checkeado');
                $("#chkComisionCadena").prop('checked', true);
                habilitarCC($("#chkComisionCadena"));
            }*/
            if(actSecciones[5].hasOwnProperty('#comisionC') && parseFloat(actSecciones[5]['#comisionC']) > 0){
                $("chkComisionCadena").prop('checked', true);
                $("comisionC").val(actSecciones[5]['#comisionC']);
                datosComisionCadena()
            }
        }
    } else if($(key).attr('type') == "radio") {
        contenedorValor = $(key).parent();
        label 			= contenedorValor;
        input 			= $(key);
    } else {
        contenedorValor = $(key).parent();
        if(contenedorValor.prop('nodeName') === 'TD') {
            label 			= contenedorValor.prev().find("label");
        } else {
            label 			= contenedorValor.find("label");
        }
        input 			= $(key);
    }
    let dataOld = $(input).val();
    let textOld = $(input).val();
    let labelHas = true;


    if($(input).prop('nodeName') === 'SELECT') {
        textOld = $(input).find("option:selected").text();
    }  else if ($(input).prop('nodeName') === 'BUTTON') {
        if("#"+$(input).attr("id")  === "#btnCorreoFacturasComision") {
            // textOld = correosenvfacturasComision.join(":");
            textOld = correosenvfacturasComisionOriginal.join(":");
            textOld = textOld.split(":").join("<br>");
        }else if("#"+$(input).attr("id")  === "#row_0") {
            textOld = textOldEscalonadas();
        } else if($(input).attr("id").includes("dSubCadena")) {
            labelHas = false;
        }
    } else if ($(input).attr('type') == "checkbox") {
        textOld = $(input).prop("checked")*1;
        labelHas = false;
    }

    if (key.includes("#pCalendario")) {
        textOld = value;
    }


    if(("#"+$(input).attr("id")).includes("radcom")) {
        let inputIT = input;
        if(newChage) {
            inputIT = $("input[name=radcom]");
            ctrlCambios = ctrlCambios.filter(f => f !== "#radcom1").concat(["#radcom1"]);
            ctrlCambios = ctrlCambios.filter(f => f !== "#radcom2").concat(["#radcom2"]);
        }

        $(inputIT).next().parent().each(function(pos,parent) {
            // console.log(pos,parent);
            labelRB = $(parent);
            keyRB = "#"+$(parent).find("input").attr("id");

            if(($(keyRB).attr("id") === "radcom2")) {
                let porAdicional = parseFloat(datosReceptor['datosGral'][0]['porcentajeAdicional']).toFixed(4);
                dataOld = porAdicional != 0 ? "Seleccionado" : "No Seleccionado";
            } else if(($(keyRB).attr("id") === "radcom1")) {
                let comTotal = parseFloat(datosReceptor['datosGral'][0]['comisionAdicional']).toFixed(4);
                dataOld = comTotal != 0 ? "Seleccionado" : "No Seleccionado";
            }

            if(!labelRB.hasClass("text-warning")) {
                labelRB.addClass('text-warning');
                labelRB.append('<i id="popover-' + keyRB + '" class="fa fa-info-circle PO" title="Valor anterior"	 type="button" class="btn btn-lg btn-danger" data-toggle="popover" data-container="body" data-html="true" data-content="' + dataOld + '"></i>&nbsp;');
            }
            if (!newChage) {
                let field = keyRB.replace('#', '');
                if(!$("#rest" + field).length){
                    labelRB.append('<i id="rest' + field + '" class="fa fa-refresh" title="Restaurar valor" onClick="restaurarValor(\'' + keyRB + '\', ' + '\'' + dataOld + '\')"></i>');
                }
                
            }
        });
    } else if (labelHas) {
        if(!label.hasClass("text-warning")) {
            label.addClass('text-warning');
            // label.append('*');
            if (key.includes("#pCalendario")) {
                label.append('<i id="popover-' + key + '" class="fa fa-info-circle PO" title="Valor anterior"	 type="button" class="btn btn-lg btn-danger" data-toggle="popover" data-container=".diaPagoL" data-html="true" data-content="' + textOld + '"></i>&nbsp;');
            } else {
                if($(input).prop('nodeName') === 'SELECT') {
                    let selects_especiales = ['#cmbCFDIComision','#cmbClaveUnidadComision','#cmbFormaPagoComision','#cmbMetodoPagoComision','#cmbProductoServicioComision', '#periodoFComision'];
                    if(selects_especiales.includes(key)){
                        $(key).val(mapForm[key.replace('#','')]);
                        textOld = $(input).find("option:selected").text();
                    }
                    label.append('<i id="popover-' + key + '" class="fa fa-info-circle PO" title="Valor anterior"	 type="button" class="btn btn-lg btn-danger" data-toggle="popover" data-container="body" data-html="true" data-content="' + textOld + '"></i>&nbsp;');
                }else{
                    let inputs_especiales = ['#liquidoFacturaRC','#periodoFComision','#txtcostoIntegracion','#txtcostotrans', '#comisionC'];
                    if(inputs_especiales.includes(key)){
                        textOld = mapForm[key.replace('#','')];
                    }
                    label.append('<i id="popover-' + key + '" class="fa fa-info-circle PO" title="Valor anterior"	 type="button" class="btn btn-lg btn-danger" data-toggle="popover" data-container="body" data-html="true" data-content="' + textOld + '"></i>&nbsp;');
                }
            }
        }
        if (!newChage) {
            let field = key.replace('#', '');
            if(!$("#rest" + field).length){
                label.append('<i id="rest' + field + '" class="fa fa-refresh" title="Restaurar valor" onClick="restaurarValor(\'' + key + '\', ' + '\'' + dataOld + '\')"></i>');
            }
            
        }
    } else if (!labelHas) {
        if($(input).attr("id").includes("dSubCadena")) {
            if (!newChage) {
                let field = key.replace('#', '');
                if(!$("#rest" + field).length){
                    $('<i id="rest' + field + '" class="fa fa-refresh text-warning" title="Restaurar valor" onClick="restaurarValor(\'' + key + '\', ' + '\'' + textOld + '\')"></i>').insertAfter(input);
                }
                
            }
            if (!label.hasClass("text-warning")) $('<i id="popover-' + key + '" class="fa fa-info-circle text-warning PO" title="Valor anterior"	 type="button" class="btn btn-lg btn-danger" data-toggle="popover" data-content="' + value + '"></i>').insertAfter(input);
            input.parent().parent().addClass('text-warning');
        } else {
            if (!newChage) {
                let field = key.replace('#', '');
                if(!$("#rest" + field).length){
                    $('<i id="rest' + field + '" class="fa fa-refresh text-warning" title="Restaurar valor" onClick="restaurarValor(\'' + key + '\', ' + '\'' + textOld + '\')"></i>').insertAfter(contenedorValor);
                }
                
            }
            if(!label.hasClass("text-warning")) $('<i id="popover-' + key + '" class="fa fa-info-circle text-warning PO" title="Valor anterior"	 type="button" class="btn btn-lg btn-danger" data-toggle="popover" data-content="' + textOld + '"></i>').insertAfter(contenedorValor);
            contenedorValor.addClass('text-warning');
        }
    }

    if ($(input).attr('type') == "checkbox") {
        if (!changed/* && value != "false"*/) {
            input.click();
        }
    } else if ($(input).attr('type') == "radio") {
        if(("#"+$(input).attr("id")).includes("radcom")) {
            if(value === "true" && !newChage) {
                input.click();
            }
        } else {
            input.click();
        }
    } else if ($(input).prop('nodeName') === 'BUTTON') {
        if("#"+$(input).attr("id")  === "#btnCorreoFacturasComision") {
            // console.log("Correo", input, value, value !== undefined, value !== '', value !== null);
            if(value !== undefined && value !== '' && value !== null)
                correosenvfacturasComision = getCorreosFacturas(value.split(":"));
        }
    } /*else if ($(input).prop('nodeName') === 'SELECT') {
        input
            .val(value)
            .trigger('change');
    }*/ else {
        if(input.length > 0) {
            input.val(value);
            if(key === '#comisionC') {
                $("comisionC").val(actSecciones[5]['#comisionC']);
                datosComisionCadena()
            }
            datosComisionCadena()
            let events = $._data(  input[0], "events" );
            if(!(events === null || events === undefined)) {
                $.each(events, function(e) {
                    input
                        .trigger(e);
                })
            } else {
                input.click();
            }
        }
    }
    if(("#"+$(input).attr("id")).includes("radcom") && newChage) {
        ctrlCambios = ctrlCambios.filter(f => f !== "#radcom1").concat(["#radcom1"])
        ctrlCambios = ctrlCambios.filter(f => f !== "#radcom2").concat(["#radcom2"])
        $('#popover-#radcom1').popover({
            content: textOld,
            trigger: 'hover',
            html: 'true'
        });
        $('#popover-#radcom2').popover({
            content: textOld,
            trigger: 'hover',
            html: 'true'
        });
    } else {
        $('#popover-' + key ).popover({
            content: textOld,
            trigger: 'hover',
            html: 'true'
        });
    }
}

function textOldEscalonadas(){
    let ul = '<ul>';
    if(comisionesEscalonadasOriginal.datos.length > 0){
        comisionesEscalonadasOriginal.datos.forEach(function (params,i) {
            ul += '<li>';
            ul += 'Max: '+params.nMontoMax+' - % Com: '+params.nPorcentajeCom;
            ul += '</li>';
        })
    }
    ul += '</ul>';
    return ul;
}
function restaurarValor(key, valor_anterior){
    let contenedorValor = null;
    let label 			= null;
    let input 			= null;
    $('[data-toggle="popover"]').popover('hide');
    if($(key).prop('nodeName') === 'DIV') {
        contenedorValor = $(key);
        label 			= contenedorValor.find("label");
        input 			= $(key);
    } else {
        contenedorValor = $(key).parent();
        //label 			= contenedorValor.find("label");
        if(contenedorValor.prop('nodeName') === 'TD') {
            label 			= contenedorValor.prev().find("label");
        } else {
            label 			= contenedorValor.find("label");
        }
        input 			= $(key);
    }

    if ($(input).attr('type') == "checkbox") {
        //$(input).prop("checked",(valor_anterior === '0' ? false : true));
        let disabled = false;
        if(input.prop("disabled")) {
            // input.prop("disabled",false);
            disabled = true;
        }
        if(key === '#chkComisionCadena'){
            if((actSecciones[5]['#chkComisionCadena']) === 'false'){
                $("#comisionC").val(mapForm['#comisionC']);
                datosComisionCadena();
            }
        }
        (key !== '#checkEscalonado') ? input.click() : '';
        if(disabled) {
            // input.prop("disabled",true);
        }
        if(key === '#checkEscalonado'){
            if(comisionesFijasOriginal.radcom1.seleccionado){
                recuperarComisionFija();
            }
            if(comisionesFijasOriginal.radcom2.seleccionado){
                recuperarComisionFijaPorcentaje();
            }
            if(comisionesEscalonadasOriginal.seleccionado){
                recuperarComisionesEscalonadas();
            }
        }
    } else if($(input).attr('type') == "radio") {
        let rb = [
            {
                pos:"2",
                field:"radcom1",
                others:{"comision": "porcentajeComision"},
                remove:["perComision","txtMontoFijo"]
            },
            {
                pos:"1",
                field:"radcom2",
                others:{"perComision": "porcentajeAdicional","txtMontoFijo": "nImpFijo"},
                remove:["comision"]
            }];
        let index1 = rb.findIndex(x => `#${x.field}` === key);
        if(index1 !== -1) {
            let disabled = false;
            if (input.prop("disabled")) {
                // input.prop("disabled", false);
                disabled = true;
            }
            $(input).click();
            if (disabled) {
                // input.prop("disabled", true);
            }
            Object.entries(rb[index1].others).forEach(([keyRS, valueRS]) => {
                // console.log(`${keyRS} ${valueRS}`);
                $("#"+keyRS).val(datosReceptor.datosGral[0][valueRS]);
            });
            rb[index1].remove.forEach(function (fa) {
                $("#rest"+fa).parent().removeClass('text-warning');
                $("#rest"+fa).parent().find(".fa").remove();
                ctrlCambios.splice( ctrlCambios.indexOf("#" + fa) , 1);
            })
            let labelRM = $("label[for=radcom" + rb[index1].pos + "]").parent();
            labelRM.find(".fa").remove();
            labelRM.removeClass('text-warning');
            ctrlCambios.splice( ctrlCambios.indexOf("#radcom" + rb[index1].pos) , 1);
            //rb[index1].others.forEach(function(text) {$("#"+text).click()});
            // Restaurar valores si exixtian originales anteriormente, comisionesFijasOriginal se declaro y definio en el archivo afiliacionCadena.js

            if(comisionesFijasOriginal.radcom1.seleccionado){
                recuperarComisionFija();
            }
            if(comisionesFijasOriginal.radcom2.seleccionado){
                recuperarComisionFijaPorcentaje();
            }
            if(comisionesEscalonadasOriginal.seleccionado){
                recuperarComisionesEscalonadas();
            }
        }
    } else {
        if(key === '#row_0'){
            recuperarComisionesEscalonadas();
            label = $("#contenedorEscalonado").find("label");
            label.remove();
        }else{
            input.val(valor_anterior);
        }
    }

    let events = $._data(  input[0], "events" );

    if(!(events === null || events === undefined) && key !== '#row_0') {
        $.each(events, function(e) {
            input
                .trigger(e);
        })
    }

    if ($(input).attr('type') == "checkbox") {
        $(key).parent().next().remove();
        $(key).parent().next().remove();
        contenedorValor.removeClass('text-warning');
    } else if ($(input).attr('type') == "radio") {
        $(key).parent().find(".fa").remove();
        contenedorValor.removeClass('text-warning');
    } else {
        let texto_label		= label.text();
        let tipo_input		= input.prop('type');
        label.empty();
        label.text(texto_label);
        label.removeClass('text-warning');
    }

    /*
    let texto_label		= label.text();
    let tipo_input		= input.prop('type');
    label.empty();
    label.text(texto_label);
    label.removeClass('text-warning');

    if ($(input).attr('type') == "checkbox") {
        $(key).parent().next().remove();
        $(key).parent().next().remove();
        contenedorValor.removeClass('text-warning');
    }

    let events = $._data(  input[0], "events" );

    if ($(input).attr('type') == "checkbox" || $(input).attr('type') == "radio") {
        //$(input).prop("checked",(valor_anterior === '0' ? false : true));
        let disabled = false;
        if(input.prop("disabled")) {
            input.prop("disabled",false);
            disabled = true;
        }
        input.click();
        if(disabled) {
            input.prop("disabled",true);
        }
    } else {
        input.val(valor_anterior);
    }
    if(!(events === null || events === undefined)) {
        $.each(events, function(e) {
            input
                .trigger(e);
        })
    }
    */
    ctrlCambios.splice( ctrlCambios.indexOf(key) , 1);
    if(key === '#tipoPago') {
        let tipoLiquidacion = datosReceptor['datosGral'][0]["tipoliq"];
        let obj = datosReceptor;
        loadLiquidacion(datosReceptor);
        if (tipoLiquidacion == 1 || tipoLiquidacion == 4) {
            ctrlCambios.splice(ctrlCambios.indexOf('#diaPagoSelect') , 1);
            ctrlCambios.splice(ctrlCambios.indexOf('#nDiaPago') , 1);
            ctrlCambios.splice(ctrlCambios.indexOf('#nDiasAtras') , 1);
        } else if (tipoLiquidacion == 2) {
            ctrlCambios.splice(ctrlCambios.indexOf('#nDiaPago') , 1);
            ctrlCambios.splice(ctrlCambios.indexOf('#nDiasAtras') , 1);
            for (var i = 0; i < obj['cobroCadena'].length; i++) {
                if (obj["cobroCadena"][i]['nDiaCorte'] == 0) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Lu_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 1) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Ma_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 2) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Mi_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 3) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Ju_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 4) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Vi_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 5) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Sa_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 6) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Do_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
            }
        } else {
            ctrlCambios.splice(ctrlCambios.indexOf('#diaPagoSelect') , 1);
            for (var i = 0; i < obj['cobroCadena'].length; i++) {
                if (obj["cobroCadena"][i]['nDiaCorte'] == 0) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Lu_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 1) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Ma_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 2) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Mi_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 3) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Ju_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 4) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Vi_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 5) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Sa_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
                if (obj["cobroCadena"][i]['nDiaCorte'] == 6) {
                    ctrlCambios.splice(ctrlCambios.indexOf('#Do_Check' + obj["cobroCadena"][i]['nDiaPago']) , 1);
                }
            }
            $('#nDiaPago').val(obj['datosGral'][0]['nDiaPago']);
            $('#nDiasAtras').val(obj['datosGral'][0]['nDiasAtras']);
        }
        //$("select").prop('disabled',true);
        //$("input").prop('disabled', true);
    } else if (key === "#checkEscalonado") {
        let obj = [];
        obj['escalonado'] = datosEscalonado;
        var IVAGeneral = parseFloat(datosReceptor['datosGral'][0]['nIVA']) / 100;
        limpiarMatrizEscalonada();
        for (var i = 0; i < obj['escalonado'].length; i++) {
            if (parseFloat(obj["escalonado"][i]["nMontoMin"]) == 1) { $("#min_0").val(parseFloat(0.01)); } else { $("#min_0").val(parseFloat(obj["escalonado"][i]["nMontoMin"])); }
            if (parseFloat(obj["escalonado"][i]["nMontoMax"]) == 0) {
                $("#max_0").val(parseFloat(obj["escalonado"][i]["nMontoMax"]));
            } else {
                $("#max_0").val(parseFloat(obj["escalonado"][i]["nMontoMax"]).toFixed(2));
            }
            let nCostoTotal = parseFloat(obj["escalonado"][i]["nCosto"])
            let nCostoEsc = nCostoTotal / (1 + IVAGeneral);
            let ivaCostoEsc = (parseFloat(nCostoTotal) - parseFloat(nCostoEsc))
            $("#comision_0").val(nCostoEsc.toFixed(4)); ///changed

            var nPorcentajeComTotal = parseFloat(obj["escalonado"][i]["nPorcentajeCom"])
            var PorcentajeCom = nPorcentajeComTotal / (1 + IVAGeneral);
            var ivaPorcentajeCom = parseFloat(nPorcentajeComTotal) - parseFloat(PorcentajeCom)

            $("#comisionPorcentaje_0").val((PorcentajeCom * 100)); ///changed
            agregarFilaCadena()
        }
    } else if (key === "#pCalendario") {
        $("input[name=Lu_Check]").attr("checked", false);
        $("input[name=Ma_Check]").attr("checked", false);
        $("input[name=Mi_Check]").attr("checked", false);
        $("input[name=Ju_Check]").attr("checked", false);
        $("input[name=Vi_Check]").attr("checked", false);
        $("input[name=Sa_Check]").attr("checked", false);
        $("input[name=Do_Check]").attr("checked", false);
        let obj = datosReceptor;
        for (var i = 0; i < obj['cobroCadena'].length; i++) {
            if (obj["cobroCadena"][i]['nDiaCorte'] == 0) {
                $('#Lu_Check' + obj["cobroCadena"][i]['nDiaPago']).prop('checked', true);
            }
            if (obj["cobroCadena"][i]['nDiaCorte'] == 1) {
                $('#Ma_Check' + obj["cobroCadena"][i]['nDiaPago']).prop('checked', true);
            }
            if (obj["cobroCadena"][i]['nDiaCorte'] == 2) {
                $('#Mi_Check' + obj["cobroCadena"][i]['nDiaPago']).prop('checked', true);
            }
            if (obj["cobroCadena"][i]['nDiaCorte'] == 3) {
                $('#Ju_Check' + obj["cobroCadena"][i]['nDiaPago']).prop('checked', true);
            }
            if (obj["cobroCadena"][i]['nDiaCorte'] == 4) {
                $('#Vi_Check' + obj["cobroCadena"][i]['nDiaPago']).prop('checked', true);
            }
            if (obj["cobroCadena"][i]['nDiaCorte'] == 5) {
                $('#Sa_Check' + obj["cobroCadena"][i]['nDiaPago']).prop('checked', true);
            }
            if (obj["cobroCadena"][i]['nDiaCorte'] == 6) {
                $('#Do_Check' + obj["cobroCadena"][i]['nDiaPago']).prop('checked', true);
            }
        }
    } else if(key.includes("dSubCadena")) {
        let idSC = key.replace('#dSubCadena-', '');
        let subcadena = datosReceptor.subcadena;
        let index = subcadena.findIndex(x => x.nIdSub === idSC);
        if(index >= 0) {
            $("#listNG-"+idSC).remove();
            subcadenaRow(subcadena[index]['nIdGrupo'], subcadena[index]['nIdSub'], subcadena[index]['sSubcadena'], subcadena[index]['sNombreGrupo'], subcadena[index]['nImpFijo'], subcadena[index]['nImpPer'], subcadena[index]['nIdSubcadena'], false);
            // $(key).attr("disabled",true)
        } else {
            $("#listNG-"+idSC).remove();
        }
    } else if(key.includes('btnCorreoFacturasComision')){
        $("#contenedordecorreosfacturasComision").empty();
        getCorreosFacturas(correosenvfacturasComisionOriginal);
    }
}

function recuperarComisionFija(){
    $("#radcom1").prop('checked', true);
    $("#checkEscalonado").is(':checked') ? $("#checkEscalonado").prop('checked', false) : '';
    $("#comision").val(comisionesFijasOriginal.radcom1.comision);
    $("#comisionIva").val(comisionesFijasOriginal.radcom1.comisionIva);
    $("#comisionTotal").val(comisionesFijasOriginal.radcom1.comisionTotal);
    $("#perComision").val(0.0);
    $("#perComisionIva").val(0.0);
    $("#perComisionTotal").val(0.0);
    $("#txtMontoFijo").val(0.0);
    $("#txtMontoFijoIva").val(0.0);
    $("#txtMontoFijoTotal").val(0.0);
    $("#labelMontoComision").removeClass('text-warning');
    $("#labelMontoComision").find("i").remove();
    $("#labelMontoPerComision").removeClass('text-warning');
    $("#labelMontoPerComision").find("i").remove();
    $("#labelMontoTxtMontoFijo").removeClass('text-warning');
    $("#labelMontoTxtMontoFijo").find("i").remove();
    $("#contenedorEscalonado").css("display", "none");
}
function recuperarComisionFijaPorcentaje(){
    $("#radcom2").prop('checked', true);
    $("#checkEscalonado").is(':checked') ? $("#checkEscalonado").prop('checked', false) : '';
    $("#comision").val(0.0);
    $("#comisionIva").val(0.0);
    $("#comisionTotal").val(0.0);
    $("#perComision").val(comisionesFijasOriginal.radcom2.perComision);
    $("#perComisionIva").val(comisionesFijasOriginal.radcom2.perComisionIva);
    $("#perComisionTotal").val(comisionesFijasOriginal.radcom2.perComisionTotal);
    $("#txtMontoFijo").val(comisionesFijasOriginal.radcom2.txtMontoFijo);
    $("#txtMontoFijoIva").val(comisionesFijasOriginal.radcom2.txtMontoFijoIva);
    $("#txtMontoFijoTotal").val(comisionesFijasOriginal.radcom2.txtMontoFijoTotal);
    $("#labelMontoComision").removeClass('text-warning');
    $("#labelMontoComision").find("i").remove();
    $("#labelMontoPerComision").removeClass('text-warning');
    $("#labelMontoPerComision").find("i").remove();
    $("#labelMontoTxtMontoFijo").removeClass('text-warning');
    $("#labelMontoTxtMontoFijo").find("i").remove();
    $("#contenedorEscalonado").css("display", "none");
}
function recuperarComisionesEscalonadas(){
    $("#radcom1").prop('checked', false).trigger('change');
    $("#radcom2").prop('checked', false).trigger('change');
    $("#comision").val(0.0);
    $("#comisionIva").val(0.0);
    $("#comisionTotal").val(0.0);
    $("#perComision").val(0.0);
    $("#perComisionIva").val(0.0);
    $("#perComisionTotal").val(0.0);
    $("#txtMontoFijo").val(0.0);
    $("#txtMontoFijoIva").val(0.0);
    $("#txtMontoFijoTotal").val(0.0);
    $("#checkEscalonado").prop('checked', true);
    $("#contenedorEscalonado").css("display", "block");
    $("#labelMontoComision").removeClass('text-warning');
    $("#labelMontoComision").find("i").remove();
    $("#labelMontoPerComision").removeClass('text-warning');
    $("#labelMontoPerComision").find("i").remove();
    $("#labelMontoTxtMontoFijo").removeClass('text-warning');
    $("#labelMontoTxtMontoFijo").find("i").remove();
    limpiarMatrizEscalonada();
    for (var i = 0; i < comisionesEscalonadasOriginal.datos.length; i++) {
        if (parseFloat(comisionesEscalonadasOriginal.datos[i]["nMontoMin"]) == 1) { $("#min_0").val(parseFloat(0.01)); } else { $("#min_0").val(parseFloat(comisionesEscalonadasOriginal.datos[i]["nMontoMin"])); }
        if (parseFloat(comisionesEscalonadasOriginal.datos[i]["nMontoMax"]) == 0) {
            $("#max_0").val(parseFloat(comisionesEscalonadasOriginal.datos[i]["nMontoMax"]));
        } else {
            $("#max_0").val(parseFloat(comisionesEscalonadasOriginal.datos[i]["nMontoMax"]).toFixed(2));
        }
        let nCostoTotal = parseFloat(comisionesEscalonadasOriginal.datos[i]["nCosto"])
        let nCostoEsc = nCostoTotal / (1 + comisionesEscalonadasOriginal.IVAGeneral);
        let ivaCostoEsc = (parseFloat(nCostoTotal) - parseFloat(nCostoEsc))
        $("#comision_0").val(nCostoEsc.toFixed(4)); ///changed

        var nPorcentajeComTotal = parseFloat(comisionesEscalonadasOriginal.datos[i]["nPorcentajeCom"])
        var PorcentajeCom = nPorcentajeComTotal / (1 + comisionesEscalonadasOriginal.IVAGeneral);
        var ivaPorcentajeCom = parseFloat(nPorcentajeComTotal) - parseFloat(PorcentajeCom)

        $("#comisionPorcentaje_0").val((PorcentajeCom * 100)); ///changed
        // console.log('comisionesEscalonadasOriginal: ' + comisionesEscalonadasOriginal.datos[i]["nMontoMax"]);
        agregarFilaCadena()
    }
}

$("#chktrans").on('change', function () {
    if(actSecciones[5].hasOwnProperty('#chktrans') && actSecciones[5].hasOwnProperty('#txtcostotrans')){
        $("#txtcostotrans").val(actSecciones[5]['#txtcostotrans']);
    }
});
$("#chkInte").on('change', function () {
    if(actSecciones[5].hasOwnProperty('#chkInte') && actSecciones[5].hasOwnProperty('#txtcostoIntegracion')){
        $("#txtcostoIntegracion").val(actSecciones[5]['#txtcostoIntegracion']);
        CalcularCostoIntegracion();
    }
})
$("#chkComisionCadena").on('change', function () {
    if(actSecciones[5].hasOwnProperty('#chkComisionCadena') && actSecciones[5].hasOwnProperty('#comisionC')){
        $("#comisionC").val(actSecciones[5]['#comisionC']);
        datosComisionCadena()
    }
})
$("#chkFacturaCadena").on('change', function () {
    if(actSecciones[5].hasOwnProperty('#chkFacturaCadena') ){
        (actSecciones[5].hasOwnProperty("#cmbCFDIComision")) ? $("#cmbCFDIComision").val(actSecciones[5]['#cmbCFDIComision']) : '';
        (actSecciones[5].hasOwnProperty("#cmbFormaPagoComision")) ? $("#cmbFormaPagoComision").val(actSecciones[5]['#cmbFormaPagoComision']) : '';
        (actSecciones[5].hasOwnProperty("#cmbMetodoPagoComision")) ? $("#cmbMetodoPagoComision").val(actSecciones[5]['#cmbMetodoPagoComision']) : '';
        (actSecciones[5].hasOwnProperty("#cmbProductoServicioComision")) ? $("#cmbProductoServicioComision").val(actSecciones[5]['#cmbProductoServicioComision']) : '';
        (actSecciones[5].hasOwnProperty("#cmbClaveUnidadComision")) ? $("#cmbClaveUnidadComision").val(actSecciones[5]['#cmbClaveUnidadComision']) : '';
        (actSecciones[5].hasOwnProperty("#periodoFComision")) ? $("#periodoFComision").val(actSecciones[5]['#periodoFComision']) : '';
        (actSecciones[5].hasOwnProperty("#liquidoFacturaRC")) ? $("#liquidoFacturaRC").val(actSecciones[5]['#liquidoFacturaRC']) : '';
        if(actSecciones[5].hasOwnProperty("#btnCorreoFacturasComision")){
            $("#contenedordecorreosfacturasComision").empty();
            getCorreosFacturas(actSecciones[5]["#btnCorreoFacturasComision"].split(":"));
        }

    }
})

$('#checkEscalonado').on('change', function () {
    if(actSecciones[5].hasOwnProperty('#checkEscalonado')) {
        if (actSecciones[5]['#checkEscalonado'] !== null) {
            var IVAGeneral = parseFloat(datosReceptor['datosGral'][0]['nIVA']) / 100;
            limpiarMatrizEscalonada();
            let value = actSecciones[5]['#checkEscalonado'];
            for (var i = 0; i < value.length; i++) {
                if (parseFloat(value[i]["nMontoMin"]) == 1) { $("#min_0").val(parseFloat(0.01)); } else { $("#min_0").val(parseFloat(value[i]["nMontoMin"])); }
                if (parseFloat(value[i]["nMontoMax"]) == 0) {
                    $("#max_0").val(parseFloat(value[i]["nMontoMax"]));
                } else {
                    $("#max_0").val(parseFloat(value[i]["nMontoMax"]).toFixed(2));
                }
                let nCostoTotal = parseFloat(value[i]["nCosto"])
                let nCostoEsc = nCostoTotal / (1 + IVAGeneral);
                let ivaCostoEsc = (parseFloat(nCostoTotal) - parseFloat(nCostoEsc))
                $("#comision_0").val(nCostoEsc.toFixed(4)); ///changed

                var nPorcentajeComTotal = parseFloat(value[i]["nPorcentajeCom"])
                var PorcentajeCom = nPorcentajeComTotal / (1 + IVAGeneral);
                var ivaPorcentajeCom = parseFloat(nPorcentajeComTotal) - parseFloat(PorcentajeCom)

                $("#comisionPorcentaje_0").val((PorcentajeCom * 100)); ///changed
                // console.log(value);
                //console.log({min, minN, max, maxN, nCostoTotal, nCostoEsc, ivaCostoEsc, nPorcentajeComTotal, PorcentajeCom, ivaPorcentajeCom});

                // return false;
                agregarFilaCadena()
            }
        }
    }
})