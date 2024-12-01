var verificarRequest = null;
var idEstatusSeccion6 = 1;
var customInputmask = (function() {
    var config = {
        extendDefaults: {
            showMaskOnHover: false,
            showMaskOnFocus: false
        },
        extendDefinitions: {},
        extendAliases: {
            'numeric': {
                radixPoint: '.',
                groupSeparator: ',',
                autoGroup: true,
                placeholder: ''
            },
            'currency': {
                alias: 'numeric',
                digits: '*',
                digitsOptional: true,
                radixPoint: ',',
                groupSeparator: '.',
                autoGroup: true,
                placeholder: ''
            },
            'euro': {
                alias: 'currency',
                prefix: '',
                suffix: ' €',
                radixPoint: ',',
                groupSeparator: '',
                autoGroup: false,
            },
            'euroComplex': {
                alias: 'currency',
                prefix: '',
                suffix: ' €',
            }
        }
    };

    var init = function() {
        Inputmask.extendDefaults(config.extendDefaults);
        Inputmask.extendDefinitions(config.extendDefinitions);
        Inputmask.extendAliases(config.extendAliases);
        $('[data-inputmask]').inputmask();
    };

    return {
        init: init
    };
}());

function initViewAltaCliente() {
    var Layout = {
        inicializatxt: function() {
            $("#rfc").alphanum({
                allow: '-',
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 12
            });
            $("#rfc").attr('style', 'text-transform: uppercase;');

            $("#nombreComercial").alphanum({
                allow: '-.,',
                allowNumeric: true,
                allowOtherCharSets: true,
                maxLength: 50
            });

            $("#razonSocial").alphanum({
                allow: '-.,',
                allowNumeric: true,
                allowOtherCharSets: true,
                maxLength: 50
            });
    
            $("#txtCalle").alphanum({
                allow: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 100
            });

            $("#int").alphanum({
                allow: '-',
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 10
            });

            $("#txtCP").alphanum({
                allow: '-',
                allowLatin: false, // a-z A-Z
                allowOtherCharSets: false,
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 5
            });

            $("#sNombreReplegal, #sPaternoReplegal, #sMaternoReplegal").alphanum({
                allow: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
                allowNumeric: false,
                allowOtherCharSets: false,
                maxLength: 100
            });

            /*$("#numeroIdentificacion").alphanum({
                maxLength: 13,
                allowLatin: true,
                allowOtherCharSets: false
            });*/

            $("#txtNumVigencia").alphanum({
                maxLength: 3,
                allowNumeric: true,
                allowLatin: false,
                allowOtherCharSets: false
            });

            $("#tnDiasOperaciones, #tnDiasCobro, #tnDiasPago").alphanum({
                maxLength: 3,
                allowNumeric: true,
                allowLatin: false,
                allowOtherCharSets: false
            });

            $("#txtCLABE").alphanum({
                allowNumeric: true,
                allowLatin: false,
                allowOtherCharSets: false
            });

            $("#diasLiquidacionComision, #diasLiquidacionTAE").alphanum({
                maxLength: 3,
                allowNumeric: true,
                allowLatin: false,
                allowOtherCharSets: false,
            });

            $("#txtABA").alphanum({
                allowNumeric: true,
                allowLatin: false,
                allowOtherCharSets: false,
                maxLength: 9
            });

            $("#txtsSwift").alphanum({
                allowLatin: true,
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 11
            });

            $("#montoLimiteCredito").numeric({
                maxDigits           : 16,
                maxDecimalPlaces    : 4,
                allowOtherCharSets	: false,
                allowDecSep         : true,
                allowMinus          : false
            });

            $("#nMontoTransferencia").numeric({
                maxDigits           : 18,
                maxDecimalPlaces    : 4,
                allowOtherCharSets	: false,
                allowDecSep         : true,
                allowMinus          : false
            });

            $(".pagoComisiones").on("change", function(e) {
                e.preventDefault();
                $this = $(this);
                $(".pagoComisiones").prop("checked",false);
                $this.prop("checked",true);
            });

            /*
            $("#cmbticket").on("change", function(e) {
                if ($(this).val() === '0') {
                    $("#contenidoFacturaComision").addClass("hidden");
                    $("#div_cobrar_comisiones").removeClass('hidden');
                } else {
                    $("#contenidoFacturaComision").removeClass("hidden");
                    $("#div_cobrar_comisiones").addClass('hidden');
                }
            });
            */
        },
        getCFDI: function(valor) {
            $.post(BASE_PATH + '/MesaControl/cliente/models/Cat_Facturacion.php', { tipo: 1 },
                function(response) {
                    var obj = jQuery.parseJSON(response);
                    if (obj.length == 0) {
                        console.log("No hay información");
                    } else {
                        var cmbComision = "#cmbCFDIComision";
                        var cmbTAE = "#cmbCFDITAE";
                        jQuery.each(obj, function(index, value) {
                            var nombre_cfdi = obj[index]['strUsoCFDI'] + " " + obj[index]['strDescripcion'];
                            $(cmbComision).append('<option value="' + obj[index]['strUsoCFDI'] + '" ' + (obj[index]['strUsoCFDI'] == 'G03' ? 'selected' : '') + '>' + nombre_cfdi + '</option>');
                            $(cmbTAE).append('<option value="' + obj[index]['strUsoCFDI'] + '" ' + (obj[index]['strUsoCFDI'] == 'G03' ? 'selected' : '') + '>' + nombre_cfdi + '</option>');
                            catalogos['cmbCFDIComision'].push({ 'key': obj[index]['strUsoCFDI'], 'value': nombre_cfdi });
                            catalogos['cmbCFDITAE'].push({ 'key': obj[index]['strUsoCFDI'], 'value': nombre_cfdi });
                        });
                    }
                }
            ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
        getFormaPago: function(valor) {
            $.post(BASE_PATH + '/MesaControl/cliente/models/Cat_Facturacion.php', { tipo: 2 },
                function(response) {
                    var obj = jQuery.parseJSON(response);
                    if (obj.length == 0) {
                        console.log("No hay información");
                    } else {
                        var cmbComision = "#cmbFormaPagoComision";
                        var cmbTAE = "#cmbFormaPagoTAE";
                        jQuery.each(obj, function(index, value) {
                            var valFormaPago = obj[index]['strFormaPago'];
                            if (valFormaPago == "17" || valFormaPago == "99") {
                                var nombre_forma_pago = valFormaPago + " " + obj[index]['strDescripcion'];                            
                                $(cmbComision).append('<option value="' + valFormaPago + '" ' + (obj[index]['strFormaPago'] == '99' ? 'selected' : '') + '>' + nombre_forma_pago + '</option>');
                                $(cmbTAE).append('<option value="' + valFormaPago + '">' + nombre_forma_pago + '</option>');
                                catalogos['cmbFormaPagoComision'].push({ 'key': valFormaPago, 'value': nombre_forma_pago });
                                catalogos['cmbFormaPagoTAE'].push({ 'key': valFormaPago, 'value': nombre_forma_pago });
                            }
                        });
                    }
                }
            ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
        getMetodoPago: function(valor) {
            $.post(BASE_PATH + '/MesaControl/cliente/models/Cat_Facturacion.php', { tipo: 3 },
                function(response) {
                    var obj = jQuery.parseJSON(response);
                    if (obj.length == 0) {
                        console.log("No hay información");
                    } else {
                        var cmbComision = "#cmbMetodoPagoComision";
                        var cmbTAE = "#cmbMetodoPagoTAE";
                        jQuery.each(obj, function(index, value) {
                            var nombre_metodo_pago = obj[index]['strMetodoPago'] + " " + obj[index]['strDescripcion'];
                            $(cmbComision).append('<option value="' + obj[index]['strMetodoPago'] + '">' + nombre_metodo_pago + '</option>');
                            $(cmbTAE).append('<option value="' + obj[index]['strMetodoPago'] + '">' + nombre_metodo_pago + '</option>');
                            catalogos['cmbMetodoPagoComision'].push({ 'key': obj[index]['strMetodoPago'], 'value': nombre_metodo_pago });
                            catalogos['cmbMetodoPagoTAE'].push({ 'key': obj[index]['strMetodoPago'], 'value': nombre_metodo_pago });
                        });
                    }
                }
            ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
        getProductoServicio: function(valor) {
            $.post(BASE_PATH + '/MesaControl/cliente/models/Cat_Facturacion.php', { tipo: 4 },
                function(response) {
                    var obj = jQuery.parseJSON(response);
                    if (obj.length == 0) {
                        console.log("No hay información");
                    } else {
                        var cmbComision = "#cmbProductoServicioComision";
                        var cmbTAE = "#cmbProductoServicioTAE";
                        jQuery.each(obj, function(index, value) {
                            var producto = obj[index]['strClaveProducto'] + " " + obj[index]['strDescripcion'];
                            $(cmbComision).append('<option value="' + obj[index]['strClaveProducto'] + '" ' + (obj[index]['strClaveProducto'] == '80141628' ? 'selected' : '') + '>' + producto + '</option>');
                            $(cmbTAE).append('<option value="' + obj[index]['strClaveProducto'] + '">' + producto + '</option>');
                            catalogos['cmbProductoServicioComision'].push({ 'key': obj[index]['strClaveProducto'], 'value': producto });
                            catalogos['cmbProductoServicioTAE'].push({ 'key': obj[index]['strClaveProducto'], 'value': producto });
                        });
                    }
                }
            ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
        getClaveUnidad: function(valor) {
            $.post(BASE_PATH + '/MesaControl/cliente/models/Cat_Facturacion.php', { tipo: 5 },
                function(response) {
                    var obj = jQuery.parseJSON(response);
                    if (obj.length == 0) {
                        console.log("No hay información");
                    } else {
                        var cmbComision = "#cmbClaveUnidadComision";
                        var cmbTAE = "#cmbClaveUnidadTAE";
                        jQuery.each(obj, function(index, value) {
                            var unidad = obj[index]['strUnidad'] + " " + obj[index]['strDescripcion'];
                            $(cmbComision).append('<option value="' + obj[index]['strUnidad'] + '" ' + (obj[index]['strUnidad'] == 'E48' ? 'selected' : '') + '>' + unidad + '</option>');
                            $(cmbTAE).append('<option value="' + obj[index]['strUnidad'] + '">' + unidad + '</option>');
                            catalogos['cmbClaveUnidadComision'].push({ 'key': obj[index]['strUnidad'], 'value': unidad });
                            catalogos['cmbClaveUnidadTAE'].push({ 'key': obj[index]['strUnidad'], 'value': unidad });
                        });
                    }
                }
            ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
    }
    Layout.inicializatxt();
    Layout.getCFDI();
    Layout.getFormaPago();
    Layout.getMetodoPago();
    Layout.getProductoServicio();
    Layout.getClaveUnidad();

    /*if (!PERMISOS) {
        desabilitarInputs(0,true);
    }*/
}

$(document).ready(function() {
    configuracionCampos();
    configuracionInputDocs();
    cargarApartadoTipoCliente();
});

/**
    * Controla las familias seleccionadas del cliente
    * @param {*} cb    - Es el check de la familia 
    * @param {*} valor - Es el id de la familia
*/
var famsarr = [];
function addFamiliasArray(cb, valor) {    
    if (cb.checked==true) {
        famsarr.push(valor);
    } 

    if (cb.checked==false) {
        for(var i = 0; i< famsarr.length; i++){
            while(famsarr[i] == valor) famsarr.splice(i,1);
        }
    }
}

/**
 * Es utilizado para mostrar el span de mensaje de error en caso de campos invalidos
 * @param {*} num       - Id del apartado 
 * @param {*} classSpan - La clase de la alerta - (alert-danger)
 * @param {*} msg       - Mensaje de error en la alerta
 */
function mostrarSpanMsg(num, classSpan, msg) {
    $("#span_paso"+num).show();
    $("#span_paso"+num).addClass('alert ' + classSpan);
    $("#span_paso"+num).html(msg);
    esconderElemento('span_paso'+num);
}

/**
 * Utilizado con mostrarSpanMsg para ocultar la alerta con timeout
 * @param {*} id    - Id de la alerta/apartado
 */
function esconderElemento(id) {
    setTimeout(function() {
        $("#" + id).fadeOut("slow");
    }, 3000);
}

/**
 * Segun id y accion oculta contenido para mostrar el gif de cargando o viceversa
 * @param {*} step   - Id del apartado
 * @param {*} accion - True=Mostrar contenido   False=Mostrar cargando
 */
function loadingApartados(step, accion) {
    if (accion) {
        $("#loadstep"+step).hide();
        $("#contentStep"+step).show();
    } else {
        $("#contentStep"+step).hide();
        $("#loadstep"+step).show();
    }
}

var tipoClienteCargado = false;
var familiasCargadas = false;
var familiasActuales = [];
var noCadenaAnterior = false;
var primeraVez = false;
var estadoSecciones = Array.from({length: 8}).fill('0');
var revisionSecciones = 0;
var estatus = 1;
var notiVerificar = true;
/**
 * Cuando el cliente no esta autorizado se ejecuta cada que un apartado es actualizado
 * Identifica si faltan apartados pendientes, si hay unicamente uno coloca el texto 'Guardar y revisar'
 * @returns {Boolean}
 */
function seccionPendiente() {
    let contPendiente = 0;
    let indexPendiente = 0;

    estadoSecciones.forEach((val, i) => {
        if (val == "0") {
            $("#li_paso" + i + " a").addClass("faltante");
            contPendiente++;
            indexPendiente = i;
        } else {
            $("#li_paso" + i + " a").removeClass("faltante");
        }
    });

    if (contPendiente == 1) {
        $("#btnGuardar" + (indexPendiente + 1)).html("Guardar y revisar");
        return true;
    } else if (contPendiente > 1) {
        return true;
    } else {
        $("#btnGuardar1, #btnGuardar3, #btnGuardar4, #btnGuardar5, #btnGuardar6, #btnGuardar7").html("Guardar cambios");
    }

    return false;
}

/**
 * Si un cliente no esta autorizado comprueba las secciones y actualiza su valor a 1 en el array
 * Si identifica que no hay pendientes, tira la notificacion y manda el correo si es necesario
 * @param {*} seccionActualizada - Id del apartado actualizado
 * @param {*} msgGuardado        - Mensaje de guardado para mostrar
 */
function comprobarSecciones(seccionActualizada, msgGuardado) {
    // Comprobar unicamente primera vez de ingreso de datos o si el cliente ya esta autorizado (estatus = 0)
    if (estatus != 0 && revisionSecciones == 0) {

        // Cambiar valor de seccion a 1 - Actualizada
        estadoSecciones[seccionActualizada-1] = "1";

        // Comprobar que no haya ninguna pendiente sino return y solo mostrar mensaje de guardado
        for (let seccion of estadoSecciones) {
            if (!seccion || seccion == "0") {
                loadingApartados(seccionActualizada, true);
                jAlert(msgGuardado);
                seccionPendiente();
                return;
            }
        }

        // Enviar notificacion si no es encargado, sino unicamente indicarle que la opcion fue activadas
        // Usuario autorizador
        if ($("#verificar").length) {
            $('#verificar').removeClass('disabled');
            loadingApartados(seccionActualizada, true);
            jAlert("Datos de cliente completados, se activo la opción de autorización");
        } 
        // Usuario capturista
        else {
            if(notiVerificar) {
                $.ajax({
                    data: {
                        'nIdCliente': $("#p_cliente").val(),
                        'razonSocial': $("#p_razonSocial").val()
                    },
                    type: 'POST',
                    url: BASE_PATH + '/MesaControl/cliente/ajax/solicitarAutorizacion.php',
                    dataType: 'json',
                    success: function (response) {
                        notiVerificar = false;
                        jAlert("Datos de cliente completados, se envió una notificación para su autorización");
                        seccionPendiente();
                        loadingApartados(seccionActualizada, true);
                    }
                });
            } else {
                loadingApartados(seccionActualizada, true);
                seccionPendiente();
                jAlert(msgGuardado);
            }
        }
    } else {
        // Si ya fue revisado o notificado, unicamente actualizar y mostrar mensaje
        loadingApartados(seccionActualizada, true);
        seccionPendiente();
        jAlert(msgGuardado);
    }
}

var nombre, paterno, materno;
function cargarApartadoTipoCliente() {
    $.post(
        BASE_PATH + '/MesaControl/cliente/ajax/getApartadoTipoCliente.php', 
        {
            idCliente: $("#p_cliente").val()
        })
        .done(function(data) {
            var dataTC = jQuery.parseJSON(data);
            DATA_APARTADO_GENERAL = dataTC;
  
            $("input[name=gbTipoPersona][value="+dataTC.idRegimen+"]").prop('checked', true).trigger("change");

            // Oculta el tipo de acceso DLL cuando el cliente esta en la prealta.
            // Y cuando el cliente ya esta activo y no tiene asignado el valor DLL en la opcion Tipo de acceso
            if ((dataTC.idEstatus == 1) || ((dataTC.idEstatus == 0 || dataTC.idEstatus == 3) && dataTC.idTipoAcceso != 1)) {
                $('input[name=nIdTipoAcceso][value=1]').parent().addClass('hide');
            }

            $("input[name=nIdTipoAcceso][value="+dataTC.idTipoAcceso+"]").prop('checked', true);
            configTipoPersona();
            
            nombre = dataTC.Nombre;
            paterno = dataTC.Paterno;
            materno = dataTC.Materno;

            if ($("#title_cliente").html() == "") {
                $("#title_cliente").html(nombre + " " + paterno + " " + materno);
            }

            $("#checkFisicaGeneral").prop('checked', parseInt(dataTC.nPersonaFisica) == 2 ? true : false);
            $("#checkIntegrador").prop('checked', parseInt(dataTC.nIntegrador)).trigger("change");
            $("#checkModPruebas").prop('checked', parseInt(dataTC.nModoPruebas)).trigger("change");
            $("#checkModProduccion").prop('checked', parseInt(dataTC.nModoProduccion)).trigger("change");
            checksForms.checkIntegrador =  parseInt(dataTC.nIntegrador);
            pruebasProduccionOriginal = {
                checkModPruebas: parseInt(dataTC.nModoPruebas),
                checkModProduccion: parseInt(dataTC.nModoProduccion)
            }

            $("#fecPruebas").val(dataTC.dFecInicioPruebas);
            $('#fecPruebas').datepicker({
                /*minDate: new Date(),*/
                format: 'yyyy-mm-dd'
            }).on('changeDate hide', function(e) {
                if (false && $(this).val() != DATA_APARTADO_GENERAL.dFecInicioPruebas && !calcularFechaMayor($(this).val())) {
                    $(this).val("");
                    $(this).datepicker('update', new Date());
                }
            });

            /*
            $("input[name='nIdTipoAcceso']").on("change", function() {
                if($("input[name='nIdTipoAcceso']:checked").val() === '3') {
                    $("#validaCobroUsuario").addClass("hidden");
                } else {
                    $("#validaCobroUsuario").removeClass("hidden");
                }
            });
            */

            $("#fecProduccion").val(dataTC.dFecInicioProduccion);
            $('#fecProduccion').datepicker({
                /*minDate: new Date(),*/
                format: 'yyyy-mm-dd'
            }).on('changeDate hide', function(e) {
                if (false && $(this).val() != DATA_APARTADO_GENERAL.dFecInicioProduccion && !calcularFechaMayor($(this).val())) {
                    $(this).val("");
                    $(this).datepicker('update', new Date());
                }
            });

            $("#cmbSolicitante").val(dataTC.nSolicitante || "-1");
            $("#cmbticket").val(dataTC.nTicketFiscal || "-1");
            $("#cmbforelo").val(dataTC.nCuantasForelo || "-1");
            $("#cmbReqFacTAE").val(dataTC.nFacturaTAE || "-1").trigger("change"); 
            
            if (dataTC.idRegimen == "1") {
                $("#nRetieneIVA").val("1");
                $("#nRetieneISR").val("0");
            }
            else if (dataTC.idRegimen == "2") {
                $("#nRetieneIVA").val(dataTC.nRetieneIVA || "-1");
                $("#nRetieneISR").val(dataTC.nRetieneISR || "-1");
            }
            
            if (dataTC.idCadena && parseInt(dataTC.idCadena) != -1) {
                $("#txtIdCadena").val(dataTC.idCadena);
                $("#txtSCadena").val(dataTC.nombreCadena);
                $("#txtSCadena").prop("disabled", true);
            } else {
                noCadenaAnterior = true;
            }

            // Verificar primera vez
            if (
                (parseInt(dataTC.idCadena) != -1 &&
                dataTC.idFamilias && 
                (dataTC.nCuantasForelo && parseInt(dataTC.nCuantasForelo) != -1) && 
                (dataTC.nFacturaTAE && parseInt(dataTC.nFacturaTAE) != -1) && 
                (dataTC.nIntegrador && parseInt(dataTC.nIntegrador) != -1) &&
                (dataTC.nSolicitante && (parseInt(dataTC.nSolicitante) != 0 && parseInt(dataTC.nSolicitante) != -1)))
                ) {
                habilitarTabs();
                primeraVez = false;
            } else {
                primeraVez = true;
            }

            if(primeraVez && !PERMISOS) {
                habilitarTabs();
            }

            // Estos son los ids de los checks de familias que no se ocuparan de momento
            // cuando se vuelvan a usar solo se tiene que quitar el id del array de la variable familiasCanceladas
            let idsFamiliasCanceladas = ['3','4','6','7'];
            for (const idFamiliaCancelada of idsFamiliasCanceladas) {
                $(`#nIdFamilia${idFamiliaCancelada}`).parent().addClass('hide');
            }

            if (dataTC.idFamilias) {
                familiasActuales    = dataTC.idFamilias.split(',');
                familiasOriginales  = familiasActuales;
                for(const fam of familiasActuales) {
                    // Si algun cliente tiene una configuracion de alguna familia cancelada se mostrara
                    if (idsFamiliasCanceladas.includes(fam)) {
                        $(`#nIdFamilia${fam}`).parent().removeClass('hide').addClass('show');
                    }
                    $("#nIdFamilia"+fam).prop("checked", true);
                    famsarr.push(parseInt(fam));
                }
            }

            // Secciones
            if (dataTC.dataSecciones) {
                const secciones = dataTC.dataSecciones;
                revisionSecciones = parseInt(dataTC.bRevision) || 0;
                estadoSecciones = [
                    secciones.bSeccion1, secciones.bSeccion2, secciones.bSeccion3,
                    secciones.bSeccion4, secciones.bSeccion5, secciones.bSeccion6,
                    secciones.bSeccion7, secciones.bSeccion8
                ];
            }
            
            // Si el estatus ya es 0 no realizar secciones
            if (dataTC.idEstatus == "0" && $('#verificar').length) {
                $("#verificar").hide();
            } else {
                // Si no hay secciones pendientes 
                // y el usuario es de mesa de control 
                // y el estado de revision no es 2=autorizado
                if (!seccionPendiente() && $('#verificar').length) {
                    // Activar boton de verificar/autorizar
                    if (revisionSecciones != 2) {
                        $('#verificar').removeClass('disabled');
                    }
                    // Si es dos ocultar boton
                    else {
                        $("#verificar").hide();
                    }
                }
            }

            $("#rfc").val(dataTC.RFC);
            estatus = parseInt(dataTC.idEstatus);
            familiasCargadas = true;
            tipoClienteCargado = true;
            loadingApartados(1, true);
            if(!PERMISOS) {
                desabilitarInputs(1,false);
            }
            /*** Modificación para control de cambios */
            datos_seccion = {
                'sSeccion': dataTC.sSeccion1,
                'nIdActualizacion': dataTC.nIdActualizacion,
                'bRevisionSecciones': dataTC.bRevisionSecciones,
                'nIdCliente': $("#p_cliente").val(),
                'allSecciones': {
                    'sSeccion1': dataTC.sSeccion1,
                    'sSeccion2': dataTC.sSeccion2,
                    'sSeccion3': dataTC.sSeccion3,
                    'sSeccion4': dataTC.sSeccion4,
                    'sSeccion5': dataTC.sSeccion5,
                    'sSeccion6': dataTC.sSeccion6,
                    'sSeccion7': dataTC.sSeccion7,
                }
            };
            dataSeccion         = JSON.parse(dataTC.sSeccion1);
            var statusRegistro  = dataTC.idEstatus;
            idEstatusSeccion6   = dataTC.idEstatus;
            status_seccion = (dataSeccion != null && dataSeccion.hasOwnProperty('status')) ? dataSeccion.status : dataTC.sSeccion1;
            controlBotones(statusRegistro, status_seccion);
            if(dataTC.idEstatus == "0"){
                setSSeccion('sSeccion1', datos_seccion);
            }
            /*** /Modificación para control de cambios */
        })
        .fail(function (err) {
            jAlert("Error al cargar los datos de tipo de cliente");
            loadingApartados(1, true);
        });
};

function actualizarApartadoTipoCliente(seccion) {
    if (tipoClienteCargado && familiasCargadas) {
        
        var fechaModPruebas = $('#fecPruebas').val(); 
        var fechaModProduccion = $('#fecProduccion').val();
        var nSolicitante = $("#cmbSolicitante").val();

        /*if (!$('#checkModPruebas').is(':checked')) {
            $('#fecPruebas').val("");
            fechaModPruebas = null;
        } else {
            // Si esta check verificar que no este vacio o que sea el valor original
            if  (fechaModPruebas != DATA_APARTADO_GENERAL.dFecInicioPruebas  && 
                    (fechaModPruebas == "" || !calcularFechaMayor(fechaModPruebas))
                ) {
                mostrarSpanMsg(1, "alert-danger", "Ingresar una fecha de modo de pruebas mayor al día de hoy");
                return;
            }
        }

        if (!$('#checkModProduccion').is(':checked')) {
            $('#fecProduccion').val("");
            fechaModProduccion = null;
        } else {
            // Si esta check verificar que no este vacio o que sea el valor original
            if  (fechaModProduccion != DATA_APARTADO_GENERAL.dFecInicioProduccion  && 
                    (fechaModProduccion == "" || !calcularFechaMayor(fechaModProduccion))
                ) {
                mostrarSpanMsg(1, "alert-danger", "Ingresar una fecha de modo de producción mayor al día de hoy");
                return;
            }
        }*/

        // Campos obligatorios
        if (!nSolicitante || nSolicitante == "-1" || nSolicitante == "0") {
            mostrarSpanMsg(1, "alert-danger", "El solicitante es obligatorio");
            return;
        }

        if (!$("#txtIdCadena").val() || $("txtSCadena").val() == "") {
            mostrarSpanMsg(1, "alert-danger", "La cadena es obligatoria");
            return;
        }

        if ($("input[name=nIdTipoAcceso]:checked").length <= 0) {
            mostrarSpanMsg(1, "alert-danger", "Debe seleccionar un tipo de acceso");
            return;
        }

        if (famsarr.length == 0) {
            mostrarSpanMsg(1, "alert-danger", "Al menos una familia deber ser seleccionada");
            return;
        }

        if ($("input[name=gbTipoPersona]:checked").length < 0) {
            mostrarSpanMsg(1, "alert-danger", "Debe seleccionar un tipo de cliente");
            return;
        }

        if (!$("#cmbticket").val() || $("#cmbticket").val() == "-1") {
            mostrarSpanMsg(1, "alert-danger", "Debe seleccionar un tipo de ticket fiscal");
            return;
        }

        if (!$("#cmbforelo").val() || $("#cmbforelo").val() == "-1") {
            mostrarSpanMsg(1, "alert-danger", "Debe seleccionar cuántas cuentas forelo posee el cliente");
            return;
        }

        if (!$("#cmbReqFacTAE").val() || $("#cmbReqFacTAE").val() == "-1") {
            mostrarSpanMsg(1, "alert-danger", "Debe seleccionar si el cliente requiere la factura TAE");
            return;
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

        var form = {
            idCliente: $("#p_cliente").val(),
            estatusCliente: estatus,
            noCadenaAnterior: noCadenaAnterior,
            idCadena: $("#txtIdCadena").val(),
            idTipoAcceso: $("input[name=nIdTipoAcceso]:checked").val(),
            idRegimen: $("input[name=gbTipoPersona]:checked").val(),
            nPersonaFisica: personaFisica,
            nSolicitante: nSolicitante,

            selectFamilias: famsarr.toString(),
            actualFamilias: familiasActuales.toString(),
        
            nIntegrador: $('#checkIntegrador').is(':checked') ? 1 : 0,
            nTicketFiscal: $("#cmbticket").val(),
            nCuantasForelo: $("#cmbforelo").val(),
            nFacturaTAE: $('#cmbReqFacTAE').val(),

            nModoPruebas: $('#checkModPruebas').is(':checked') ? 1 : 0,
            nModoProduccion: $('#checkModProduccion').is(':checked') ? 1 : 0,
            dFecInicioPruebas: fechaModPruebas,
            dFecInicioProduccion: fechaModProduccion,

            primeraVez: primeraVez ? 1 : 0
        }

        $("#btnGuardar1").prop("disabled", true);
        loadingApartados(1, false);

        $.post(BASE_PATH + '/MesaControl/cliente/ajax/actualizarApartadoTipoCliente.php', form)
            .done(function(data) {
                var data = jQuery.parseJSON(data);
          
                if (parseInt(data.code) == 0) {
                    familiasActuales = famsarr;

                    habilitarTabs();
                    loadingApartados(1, true);
                    
                    // Actualizar secciones
                    estadoSecciones[0] = "1"; // Tipo
                    estadoSecciones[1] = "1"; // Datos y dir
                    estadoSecciones[6] = "1"; // Ctas contables
                    estadoSecciones[7] = "1"; // Matriz
                    seccionPendiente();

                    $("#txtSCadena").prop("disabled", true);

                    if ($("#cmbticket").val() === '0') {
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

                    if($("input[name='nIdTipoAcceso']:checked").val() === '3') {
                        $("#validaCobroUsuario").addClass("hidden");
                        $("#cmb_valida_monto").val("-1");
                    } else {
                        $("#validaCobroUsuario").removeClass("hidden");
                    }
                }
                
                jAlert(data.msg || "Error al actualizar los datos de tipo de cliente");
                $("#btnGuardar1").prop("disabled", false);
                autorizaControlCambio('sSeccion1');
            })
            .fail(function (err) {
                jAlert("Error al actualizar los datos de tipo de cliente");
                $("#btnGuardar1").prop("disabled", false);
                loadingApartados(1, true);
            });
    } else {
        jAlert("Los datos del apartado de tipo cliente no han sido cargados");
    }
}

var datosYDireccionCargado = false;
function cargarApartadoDatosDireccion() {
    if (!datosYDireccionCargado) {
        loadingApartados(2, false);
        try {
            $.post(BASE_PATH + '/MesaControl/cliente/ajax/getApartadoGeneralesDir.php', {idCliente: $("#p_cliente").val()})
                .done(function(data) {
                    var dataGD = jQuery.parseJSON(data);
                    DATA_APARTADO_DIR = dataGD;
      
                    $("#sNombreFisico").val(dataGD.Nombre);
                    $("#sPaternoCliente").val(dataGD.Paterno);
                    $("#sMaternoCliente").val(dataGD.Materno);
                    $("#sRazonSocial").val(dataGD.RazonSocial);
                    $("#sNombreComercial").val(dataGD.sNombreComercial);
                    $("#regimenCapital").val(dataGD.sRegimenSocietario);
                    $("#actividadEconomica").val(dataGD.sActividadEconomica);
                    
                    $("#cmbpais").val(dataGD.idPais);
                    $("#txtCalle").val(dataGD.calleDireccion);
                    $("#int").val(dataGD.numeroIntDireccion);
                    $("#ext").val(dataGD.numeroExtDireccion);
                    $("#txtCP").val(dataGD.cpDireccion);

                    if($("input[name='gbTipoPersona']:checked").val()*1 === 1) {
                        $("#razonSocialDiv").addClass("hidden");
                        $("#regimenCapitalDiv").addClass("hidden");
                        $("#nombreComercialDiv").addClass("hidden");
                    }

                    if (dataGD.idPais == "164") {
                        // Buscar datos de colonias, municipio y estado
                        //$("#txtCP").keyup();
                        $("#cmbEntidad").append('<option value="1">'+ dataGD.nombreEstado +'</option>');
                        $("#cmbCiudad").append('<option value="1">'+ dataGD.nombreCiudad +'</option>');
                        $("#cmbColonia").append('<option value="1">'+ dataGD.nombreColonia +'</option>');
                        $("#cmbEntidad").val(1);
                        $("#cmbCiudad").val(1);
                        $("#cmbColonia").val(1);
                    } else {
                        // Extranjeros
                        /*$('#div-rfc label').html('TIN:');
                        if ($("input[name=gbTipoPersona]:checked").val() == "1") {
                            $('#rfc').mask('000-00-0000'); 
                        } 
                        else if ($("input[name=gbTipoPersona]:checked").val() == "2") {
                            $('#rfc').mask('00-0000000'); 
                        }*/
                        $("#txtColoniaExt").val(dataGD.sNombreColonia);
                        $("#txtCiudadExt").val(dataGD.sNombreMunicipio);
                        $("#txtEstadoExt").val(dataGD.sNombreEstado);
                        $("#divDirext").show();
                        $("#divDirnac").hide(); 
                    }
    
                    loadingApartados(2, true);
                    datosYDireccionCargado = true;
                })
                .fail(function (err) {
                    jAlert("Error al cargar los datos y dirección");
                    loadingApartados(2, true);
                });
        } catch (e) {
            jAlert("Error al cargar los datos y dirección");
            loadingApartados(2, true);
        }
    }
}

var replegalYContratoCargado = false;
function cargarApartadoReplegalContrato() {
    if (!replegalYContratoCargado) { 
        try {
            $.post(BASE_PATH + '/MesaControl/cliente/ajax/getApartadoReplegalContrato.php', {idCliente: $("#p_cliente").val()})
                .done(function(data) {
                    var dataRC = jQuery.parseJSON(data);
                    DATA_APARTADO_REPLCONT = dataRC;
  
                    $("#sNombreReplegal").val(dataRC.nombreRepreLegal);
                    $("#sPaternoReplegal").val(dataRC.apPRepreLegal);
                    $("#sMaternoReplegal").val(dataRC.apMRepreLegal);

                    $("#cmbIdentificacion").val((dataRC.idcTipoIdent !== null) ? dataRC.idcTipoIdent : -1);
                    $("#numeroIdentificacion").val(dataRC.numIdentificacion);

                    $("#fecRenovarContrato").val(dataRC.dFecRenovacion);
                    $("#fecContrato").val(dataRC.dFechaContrato);
                    $('#fecContrato').datepicker({
                        /*minDate: new Date(),*/
                        format: 'yyyy-mm-dd'
                    }).on('changeDate hide', function(e) {
                        if (false && $(this).val() != DATA_APARTADO_REPLCONT.dFechaContrato && !calcularFechaMayor($(this).val())) {
                            $(this).val("");
                            $(this).datepicker('update', new Date());
                        } else {
                            if ($("#checkVigencia").is(':checked')) {
                                calcularFechaVigenciaIndefinida();
                            } else {
                                calcularFechaVigencia();
                            }
                            $("#fecRevisionCondicion").val($("#fecRenovarContrato").val());
                        }
                    });
                    
                    $("#fecRevisionCondicion").val(dataRC.dFecRevisionCondicionesComerciales);
                    $('#fecRevisionCondicion').datepicker({
                        minDate: $('#fecContrato').val(),
                        format: 'yyyy-mm-dd'
                    }).on('changeDate hide', function(e) {
                        if($(this).val() < $('#fecContrato').val()) {
                            $(this).val("");
                            $(this).datepicker('update', $('#fecContrato').val());
                        }
                        if (false && $(this).val() != DATA_APARTADO_REPLCONT.dFecRevisionCondicionesComerciales && !calcularFechaMayor($(this).val())) {
                            $(this).val("");
                            $(this).datepicker('update', new Date());
                        }
                    });

                    if (dataRC.nVigencia != null && parseInt(dataRC.nVigencia) != 0) {
                        $("#checkVigencia").prop("checked", false);
                        $('#divNumVigencia').show(); 
                        $("#txtNumVigencia").val(dataRC.nVigencia);
                        checksForms.checkVigencia = 0
                    }else{
                        checksForms.checkVigencia = 1;
                    }

                    if($("input[name='gbTipoPersona']:checked").val()*1 === 1) {
                        $("#div_replegal").addClass('hidden');
                    }

                    loadingApartados(3, true);
                    replegalYContratoCargado = true;
                    if(!PERMISOS) {
                        desabilitarInputs(3,false);
                    }
                    /*** Modificación para control de cambios */
                    datos_seccion = {
                        'sSeccion': dataRC.sSeccion3,
                        'nIdActualizacion': dataRC.nIdActualizacion,
                        'bRevisionSecciones': dataRC.bRevisionSecciones,
                        'nIdCliente': $("#p_cliente").val(),
                        'allSecciones': {
                            'sSeccion1': dataRC.sSeccion1,
                            'sSeccion2': dataRC.sSeccion2,
                            'sSeccion3': dataRC.sSeccion3,
                            'sSeccion4': dataRC.sSeccion4,
                            'sSeccion5': dataRC.sSeccion5,
                            'sSeccion6': dataRC.sSeccion6,
                            'sSeccion7': dataRC.sSeccion7,
                        }
                    };
                    dataSeccion         = JSON.parse(dataRC.sSeccion3);
                    var statusRegistro  = dataRC.idEstatus;
                    status_seccion = (dataSeccion != null && dataSeccion.hasOwnProperty('status')) ? dataSeccion.status : dataRC.sSeccion3;
                    controlBotones(dataRC.idEstatus, status_seccion);
                    if(dataRC.idEstatus == "0") {
                        setSSeccion('sSeccion3', datos_seccion);
                    }
                    /*** /Modificación para control de cambios */

                })
                .fail(function (err) {
                    jAlert("Error al cargar el representante legal y contrato");
                    loadingApartados(3, true);
                });
        } catch (e) {
            jAlert("Error al cargar el representante legal y contrato");
            loadingApartados(3, true);
        }
    }
}

var apartadoReplegalActualizado = false;
function actualizarApartadoReplegalContrato(seccion) {
    if (replegalYContratoCargado) {

        var nombreRep       = $("#sNombreReplegal").val().trim();
        var apPaternoRep    = $("#sPaternoReplegal").val().trim();
        var apMaternoRep    = $("#sMaternoReplegal").val().trim();
        var numIdent        = $("#numeroIdentificacion").val().trim();
        var tipoIdent       = $("#cmbIdentificacion").val();
        var fechaContrato   = $("#fecContrato").val();
        var fechaCondicion  = $("#fecRevisionCondicion").val();

        //if( $("#cmbticket").val() !== '0') {
        if( $("#gbPersonaMoral").prop("checked") ) {
            if (!nombreRep || nombreRep == "") {
                mostrarSpanMsg(3, "alert-danger", "Captura del nombre del Representante Legal");
                return;
            } else if (nombreRep.length < 3) {
                mostrarSpanMsg(3, "alert-danger", "La Longitud M\u00EDnima para el Nombre del Representante Legal es de 3 caracteres");
                return;
            } else if (nombreRep.length > 50) {
                mostrarSpanMsg(3, "alert-danger", "La Longitud M\u00E1xima para el Nombre del Representante Legal es de 50 caracteres");
                return;
            }

            if (!apPaternoRep || apPaternoRep == "") {
                mostrarSpanMsg(3, "alert-danger", "Captura Apellido Paterno del Representante Legal");
                return;
            }
            else if (apPaternoRep.length < 3) {
                mostrarSpanMsg(3, "alert-danger", "La Longitud M\u00EDnima para el Apellido Paterno del Representante Legal es de 3 caracteres");
                return;
            }
            else if (apPaternoRep.length > 50) {
                mostrarSpanMsg(3, "alert-danger", "La Longitud M\u00E1xima para el Apellido Paterno del Representante Legal es de 50 caracteres");
                return;
            }

            if (!apMaternoRep || apMaternoRep == "") {
                mostrarSpanMsg(3, "alert-danger", "Captura Apellido Materno del Representante Legal");
                return;
            }
            else if (apMaternoRep.length < 3) {
                mostrarSpanMsg(3, "alert-danger", "La Longitud M\u00EDnima para el Apellido Materno del Representante Legal es de 3 caracteres");
                return;
            }
            else if (apMaternoRep.length > 50) {
                mostrarSpanMsg(3, "alert-danger", "La Longitud M\u00E1xima para el Apellido Materno del Representante Legal es de 50 caracteres");
                return;
            }

            if (!tipoIdent || tipoIdent == "" || tipoIdent == "-1") {
                mostrarSpanMsg(3, "alert-danger", "Seleccione un Tipo de Identificación del Representante Legal");
                return;
            }

            if (!numIdent || numIdent == "") {
                mostrarSpanMsg(3, "alert-danger", "Captura Número de Identificación del Representante Legal");
                return;
            } else {
                var showmsg = false;

                if(tipoIdent == "1" && numIdent.length != 13) {
                    showmsg = true;
                }
                // else if(tipoIdent == "2" && !validarFormatoCartillaMilitar(numIdent) && numIdent.length != 10) {
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
                    mostrarSpanMsg(3, "alert-danger", 'El Formato del N\u00FAmero de identificaci\u00F3n es Incorrecto');
                    return;
                }
            }
        }
        
        var nVigencia = parseInt($("#txtNumVigencia").val().trim());
        if (!$('#checkVigencia').is(':checked') && (isNaN(nVigencia) || nVigencia <= 0)){
            mostrarSpanMsg(3, "alert-danger", 'La vigencia debe ser un valor numérico y mayor a 0');
            return;
        }
        
        /*if  (fechaContrato != DATA_APARTADO_REPLCONT.dFechaContrato  &&
            (fechaContrato != "" && !calcularFechaMayor(fechaContrato))    
        ) {
            mostrarSpanMsg(3, "alert-danger", "Ingresar una fecha de contrato mayor al día de hoy");
            return;
        }

        if  (fechaCondicion != DATA_APARTADO_REPLCONT.dFecRevisionCondicionesComerciales  && 
            (fechaCondicion != "" && !calcularFechaMayor(fechaCondicion))    
        ) {
            mostrarSpanMsg(3, "alert-danger", "Ingresar una fecha de condiciones mayor al día de hoy");
            return;
        }*/

        var form = {
            idCliente:              $("#p_cliente").val(),
            estatusCliente:         estatus,

            nTipoIdentificacion:    $("#cmbIdentificacion").val(),
            numIdentificacion:      $("#numeroIdentificacion").val().trim(),
            sNombreReplegal:        $("#sNombreReplegal").val().trim().toUpperCase(),
            sPaternoReplegal:       $("#sPaternoReplegal").val().trim().toUpperCase(),
            sMaternoReplegal:       $("#sMaternoReplegal").val().trim().toUpperCase(),

            txtNumVigencia:         $('#checkVigencia').is(':checked') ? 0 : nVigencia,
            fecContrato:            fechaContrato,
            fecRenovarContrato:     $("#fecRenovarContrato").val(),
            fecRevisionCondicion:   $("#fecRevisionCondicion").val(),

            secciones:              estadoSecciones.join(','),
            numSeccion:             3
        }

        $("#btnGuardar3").prop("disabled", true);
        loadingApartados(3, false);
        $.post(BASE_PATH + '/MesaControl/cliente/ajax/actualizarApartadoReplegalContrato.php', form)
            .done(function(data) {
                var data = jQuery.parseJSON(data);
 
                if (parseInt(data.code) == 0) {
                    apartadoReplegalActualizado = true;
                    comprobarSecciones(3, data.msg);
                } else {
                    jAlert(data.msg);
                    loadingApartados(3, true);
                }
 
                $("#btnGuardar3").prop("disabled", false);

                autorizaControlCambio('sSeccion3');

            })
            .fail(function (err) {
                jAlert("Error al actualizar los datos de representante legal y contrato");
                $("#btnGuardar3").prop("disabled", false);
                loadingApartados(3, true);
            });
    } else {
        jAlert("Los datos del apartado de representante legal y contrato no han sido cargados");
    }
}

var liquidacionesCargado = false;
function cargarApartadoLiquidaciones() {
    if (!liquidacionesCargado) {
        loadingApartados(5, false);
        try {
            $.post(BASE_PATH + '/MesaControl/cliente/ajax/getApartadoLiquidacionGeneral.php', {idCliente: $("#p_cliente").val()})
                .done(function(data) {
                    var dataLC = jQuery.parseJSON(data);
      
                    $("input[name=tipoLiqRecaudo][value="+dataLC.nTipoLiquidacionRecaudo+"]").prop('checked', true).trigger("change");
                    
                    $("#cmbCostoTransferencia").val(dataLC.nRetieneTransferencia || "-1").trigger("change");
                    $("#cmb_valida_monto").val(dataLC.nValidaMonto || "-1");
                    $("#cmbPeriodoPrepPagoCom").val(dataLC.nTipoPrepagoComisiones || "-1").trigger("change");
                    $("#cmbRetieneComision").val(dataLC.nRetieneComision || "-1").trigger("change");

                    if(dataLC.nTipoLiquidacionRecaudo*1 === 2) {
                        $("#costoTransferencia").removeClass("hidden");
                    }

                    if($("input[name='nIdTipoAcceso']:checked").val() === '3') {
                        $("#validaCobroUsuario").addClass("hidden");
                    }

                    console.log('parseFloat(dataLC.nLimiteCredito): ', parseFloat(dataLC.nLimiteCredito));
                    if(parseFloat(dataLC.nLimiteCredito) > 0) {
                        $("#limitCreditY").prop('checked', true).trigger("change");
                    }else{
                        $("#limitCreditN").prop('checked', true).trigger("change");
                    }

                    if (parseFloat(dataLC.nComisionAdicional) > 0) {
                        $("#nMontoIntegrador").val(dataLC.nComisionAdicional);
                        $("#cmbComisionIntegrador").val("1").trigger("change");
                    } 
                    else if (parseFloat(dataLC.nComisionAdicional) == 0) {
                        $("#cmbComisionIntegrador").val("0").trigger("change");
                    }

                    $("#cmbTipoLiquidacionOperaciones").val(dataLC.nTipoLiquidacion || "-1").trigger("change");
                    $("#cmbSemanalDiaOperaciones").val(dataLC.nDiaPago || "-1");
                    $("#semanalAtrasOperaciones").val(dataLC.nDiasAtras);
                    $("#tnDiasOperaciones").val(dataLC.nTndias);

                    $("#cmbPeriodoPagoCom").val(dataLC.nPagoTipoLiquidacion || "-1").trigger("change");
                    $("#cmbSemanalDiaPago").val(dataLC.nPagoDiaPago || "-1");
                    $("#semanalAtrasPago").val(dataLC.nPagoDiasAtras);
                    $("#tnDiasPago").val(dataLC.nPagoTnDias);

                    $("#cmbCuentaRED").val(dataLC.nIdCuentaRE || "-1");
                    $("#cmbPeriodoCobroCom").val(dataLC.nCobroTipoLiquidacion || "-1").trigger("change");
                    $("#cmbSemanalDiaCobro").val(dataLC.nCobroDiaPago || "-1");
                    $("#semanalAtrasCobro").val(dataLC.nCobroDiasAtras);
                    $("#tnDiasCobro").val(dataLC.nCobroTnDias);

                    $("#cmbBancoPago").val(dataLC.nIdBanco || "-1");
                    $("#txtBanco").val($("#cmbBancoPago option:selected").text());
                    if(dataLC.nIdPaisPago != '-1') {
                        $("#cmbPaisPago").val(dataLC.nIdPaisPago);
                    }
                    if(dataLC.nIdMonedaExtranjero != '-1'){
                        $("#cmbMonedaExt").val(dataLC.nIdMonedaExtranjero);
                    }

                    $("#txtCLABE").val(dataLC.sCLABE);
                    $("#txtBeneficiario").val(dataLC.sBeneficiario);
                    $("#txtsSwift").val(dataLC.sSwift);
                    $("#txtABA").val(dataLC.sABA);
                    $("#txtCuenta").val(dataLC.sNumCuenta);

                    $("#montoLimiteCredito").val(dataLC.nLimiteCredito);
                    $("#nMontoTransferencia").val(dataLC.nMontoTransferencia);
                    $("#checkDescFDM").prop('checked', parseInt(dataLC.nDescuentoForeloCliente));
                    $("#checkDescGD").prop('checked', parseInt(dataLC.nDescuentoForeloPG));
                    $("#checkTicketResp").prop('checked', parseInt(dataLC.nCadenaTicketFiscal));
                    comisionUsuarioFinalOriginal = {
                        checkDescFDM: parseInt(dataLC.nDescuentoForeloCliente),
                        checkDescGD: parseInt(dataLC.nDescuentoForeloPG),
                        checkTicketResp: parseInt(dataLC.nCadenaTicketFiscal)
                    }
                    calendario = dataLC.calendario;
                    if (dataLC.calendario.length > 0) {
                        cargarCalendarios(dataLC.calendario);
                    }

                    if (dataLC.sCorreoEnvio) {
                        var correos = dataLC.sCorreoEnvio.split(":");
                        sCorreoEnvio_original = correos;
                        for (let correo of correos) {
                            agregarCorreoNotificaciones(correo);
                        }
                    }

                    if( $("#cmbticket").val() === '0' ) {
                        $("#div_cobrar_comisiones").removeClass('hidden');
                    } else {
                        $("#div_cobrar_comisiones").addClass('hidden');
                    }

                    liquidacionesCargado = true;
                    loadingApartados(5, true);
                    if(!PERMISOS) {
                        desabilitarInputs(5,false);
                    }

                    /*** Modificación para control de cambios */
                    datos_seccion = {
                        'sSeccion': dataLC.sSeccion5,
                        'nIdActualizacion': dataLC.nIdActualizacion,
                        'bRevisionSecciones': dataLC.bRevisionSecciones,
                        'nIdCliente': $("#p_cliente").val(),
                        'allSecciones': {
                            'sSeccion1': dataLC.sSeccion1,
                            'sSeccion2': dataLC.sSeccion2,
                            'sSeccion3': dataLC.sSeccion3,
                            'sSeccion4': dataLC.sSeccion4,
                            'sSeccion5': dataLC.sSeccion5,
                            'sSeccion6': dataLC.sSeccion6,
                            'sSeccion7': dataLC.sSeccion7,
                        }
                    };
                    dataSeccion         = JSON.parse(dataLC.sSeccion5);
                    var statusRegistro  = dataLC.idEstatus;
                    status_seccion = (dataSeccion != null && dataSeccion.hasOwnProperty('status')) ? dataSeccion.status : dataLC.sSeccion5;
                    controlBotones(dataLC.idEstatus, status_seccion);
                    if(dataLC.idEstatus == "0") {
                        setSSeccion('sSeccion5', datos_seccion);
                    }
                    /*** /Modificación para control de cambios */

                })
                .fail(function (err) {
                    jAlert("Error al cargar el apartado de liquidaciones");
                    loadingApartados(5, true);
                });
        } catch (e) {
            jAlert("Error al cargar el apartado de liquidaciones");
            loadingApartados(5, true);
        }
    }
}

/**
 * Checkea los dias que tenga configurado el cliente en su calendario
 * @param {*} calendarios - Objeto que trae todos los calendarios que tenga configurado el cliente
 */
function cargarCalendarios(calendarios) {
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

        for (let dia of dias) {
            if (dia != "") {
                $("#"+dia+"."+diaCorte+"_Check_"+tipo).attr('checked', true);
            }
        }
    }
}

var calendarioDefault = ['', '', '', '', ''];
var apartadoLiquidacionesActualizado = false;
function actualizarApartadoLiquidacion() {
    if (liquidacionesCargado) {

        var cmbCostoTransfVal = $("#cmbCostoTransferencia").val();
        if (cmbCostoTransfVal == "-1") {
            mostrarSpanMsg(5, "alert-danger", 'Seleccione si retiene costo por transferencia');
            return;
        }
        else if (cmbCostoTransfVal == "1" && parseFloat($("#nMontoTransferencia").val()) <= 0) {
            mostrarSpanMsg(5, "alert-danger", 'El monto a retener por transferencia debe ser mayor a 0');
            return;
        }

        // VALIDACIONES EN LIQUIDACIONES GENERALES
        var tipoRecaudoVal = $("input[name=tipoLiqRecaudo]:checked").val();
        var tipoLiquidacionOp = $("#cmbTipoLiquidacionOperaciones").val();
        var tnDiasOp = $('#tnDiasOperaciones').val();
        var nDiaPagoOp = $("#cmbSemanalDiaOperaciones").val();
        var nDiaAtrasOp = $("#semanalAtrasOperaciones").val();
        var calendarioOp = getDiasCalendarios("Recaudo");
        var montoLimiteCredito = $("#montoLimiteCredito").val();
        var nRetieneComision = $("#cmbRetieneComision").val();

        if (!tipoRecaudoVal) {
            mostrarSpanMsg(5, "alert-danger", 'Seleccione un tipo de recaudo');
            return;
        }

        if (tipoRecaudoVal == "2") {
            if (!montoLimiteCredito || parseFloat(montoLimiteCredito) < 0) {
                mostrarSpanMsg(5, "alert-danger", 'El monto de límite de crédito debe ser mayor o igual a 0');
                return;
            }

            if (!nRetieneComision || nRetieneComision == "-1") {
                mostrarSpanMsg(5, "alert-danger", 'Debe seleccionar si el cliente retiene comisión');
                return;
            }

            if (tipoLiquidacionOp == "-1") {
                mostrarSpanMsg(5, "alert-danger", 'Debe seleccionar un tipo de liquidación para recuado');
                return;
            }
            else if (tipoLiquidacionOp == "1") {
                // Tndias
                if (!tnDiasOp || parseInt(tnDiasOp) <= 0) {
                    mostrarSpanMsg(5, "alert-danger", 'El valor de T+n días debe ser mayor a 0');
                    return;
                } 
                nDiaAtrasOp = "NULL";
                nDiaPagoOp = "NULL";
                calendarioOp = calendarioDefault;
            }
            else if (tipoLiquidacionOp == "2") {
                // Calendario
                if (contarCheckCalendario("Recaudo") == 0) {
                    mostrarSpanMsg(5, "alert-danger", 'Configure el calendario de liquidaciones');
                    return;
                }
                nDiaAtrasOp = "NULL";
                nDiaPagoOp = "NULL";
                tnDiasOp = "NULL";
            }
            else if (tipoLiquidacionOp == "4") {
                // Semanal
                if (!nDiaPagoOp || nDiaPagoOp == "-1") {
                    mostrarSpanMsg(5, "alert-danger", 'Debe seleccionar una día de pago');
                    return;
                }
                if (!nDiaAtrasOp || parseInt(nDiaAtrasOp) < 0) {
                    mostrarSpanMsg(5, "alert-danger", 'El valor de días hacia atras debe ser mayor o igual a 0');
                    return;
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

        // VALIDACIONES PAGO DE COMISIONES
        var validaCobroVal = $("#cmb_valida_monto").val();
        if ((!validaCobroVal || validaCobroVal == "-1") && ($("input[name='nIdTipoAcceso']:checked").val() !== '3') ) {
            mostrarSpanMsg(5, "alert-danger", 'Seleccione si el sistema valida cobro');
            return;
        }

        var comisionIntegradorVal = 0;
        if ($('#checkIntegrador').is(':checked')) {
            var valCmbComision = $("#cmbComisionIntegrador").val();
            if (!valCmbComision || valCmbComision == "-1") {
                mostrarSpanMsg(5, "alert-danger", 'Seleccione si hay comisión adicional como integrador');
                return;
            } else {
                if (valCmbComision == "1") {
                    comisionIntegradorVal = $("#nMontoIntegrador").val()
                    if (!comisionIntegradorVal || parseFloat(comisionIntegradorVal) <= 0) {
                        mostrarSpanMsg(5, "alert-danger", 'El valor de comisión como integrador debe ser mayor a 0');
                        return;
                    }
                } else {
                    comisionIntegradorVal = 0;
                }  
            }
        }

        var tipoLiquidacionPago = $("#cmbPeriodoPagoCom").val();
        var tnDiasPago = $('#tnDiasPago').val();
        var nPagoDiaPago = $("#cmbSemanalDiaPago").val();
        var nDiaAtrasPago = $("#semanalAtrasPago").val();
        var calendarioPago = getDiasCalendarios("Pago");
     
        if (nRetieneComision == "1") {
            tipoLiquidacionPago = "-1";
            tnDiasPago = "NULL";
            nDiaAtrasPago = "NULL";
            nPagoDiaPago = "NULL";
            calendarioPago = calendarioDefault;
        }
        else if (tipoLiquidacionPago == "-1" && tipoRecaudoVal == "2") {
            mostrarSpanMsg(5, "alert-danger", 'Debe seleccionar un Período para pago de comisiones');
            return;
        }
        else if (tipoLiquidacionPago == "1") {
            // Tndias
            if (!tnDiasPago || parseInt(tnDiasPago) <= 0) {
                mostrarSpanMsg(5, "alert-danger", 'El valor de T+n días debe ser mayor a 0');
                return;
            } 
            nDiaAtrasPago = "NULL";
            nPagoDiaPago = "NULL";
            calendarioPago = calendarioDefault;
        }
        else if (tipoLiquidacionPago == "2") {
            // Calendario
            if (contarCheckCalendario("Pago") == 0) {
                mostrarSpanMsg(5, "alert-danger", 'Configure el calendario de liquidaciones para pago');
                return;
            }
            nDiaAtrasPago = "NULL";
            nPagoDiaPago = "NULL";
            tnDiasPago = "NULL";
        }
        else if (tipoLiquidacionPago == "4") {
            // Semanal
            if (!nPagoDiaPago || nPagoDiaPago == "-1") {
                mostrarSpanMsg(5, "alert-danger", 'Debe seleccionar una día de pago');
                return;
            }
            if (!nDiaAtrasPago || parseInt(nDiaAtrasPago) < 0) {
                mostrarSpanMsg(5, "alert-danger", 'El valor de días hacia atras debe ser mayor o igual a 0');
                return;
            }
            tnDiasPago = "NULL";
            calendarioPago = calendarioDefault;
        }

        if (correosNotificaciones.length == 0) {
            mostrarSpanMsg(5, "alert-danger", 'Debe agregar un correo para el pago de comisiones');
            return;
        }

        var nIdBanco = $("#cmbBancoPago").val();
        var sNumCuenta = $("#txtCuenta").val();
        var sCLABE = $("#txtCLABE").val();
        var sBeneficiario = $("#txtBeneficiario").val() || "";
        var nIdPaisPago = $("#cmbPaisPago").val() || "NULL";
        var sSwift = $("#txtsSwift").val();
        var sABA = $("#txtABA").val();
        var nIdMonedaExt = $("#cmbMonedaExt").val() || "NULL";

        var cmbPeriodoPrePagoCom = $("#cmbPeriodoPrepPagoCom").val();
        if (!cmbPeriodoPrePagoCom || cmbPeriodoPrePagoCom == "-1") {
            mostrarSpanMsg(5, "alert-danger", 'Debe seleccionar el tipo de prepago para el pago de comisiones');
            return;
        }

        if (!nIdBanco || nIdBanco == "-1") {
            mostrarSpanMsg(5, "alert-danger", 'Debe colocar una clabe válida');
            return;
        }
        if (!sNumCuenta || sNumCuenta == "") {
            mostrarSpanMsg(5, "alert-danger", 'Debe colocar una clabe válida');
            return;
        }
        if (!sCLABE || sCLABE == "") {
            mostrarSpanMsg(5, "alert-danger", 'CLABE es requerido');
            return;
        }
        // if (!sBeneficiario || sBeneficiario == "") {
        //     mostrarSpanMsg(5, "alert-danger", 'El beneficiario es requerido');
        //     return;
        // }
        if (sSwift != "" && (sSwift.length < 8 || sSwift.length > 11)) {
            mostrarSpanMsg(5, "alert-danger", 'Código Swift es incorrecto, debe ingresar un valor de 8 a 11 dígitos alfanuméricos');
            return;
        }
        if (sABA != "" && sABA.length != 9) {
            mostrarSpanMsg(5, "alert-danger", 'Código ABA es incorrecto, debe ingresar un código de 9 dígitos');
            return;
        }

        // APARTADO DE COBRO DE COMISIONES
        var nCobroComisiones = 0;
        var nTipoLiquidacionCobro = $("#cmbPeriodoCobroCom").val() || "NULL";
        var nIdCuentaRE = $("#cmbCuentaRED").val() || "NULL";
        var nCobroTnDias = $("#tnDiasCobro").val() || "NULL";
        var nCobroDiaPago = $("#cmbSemanalDiaCobro").val() || "NULL";
        var nCobroDiasAtras = $("#semanalAtrasCobro").val() || "NULL";
        var calendarioCobro = getDiasCalendarios("Cobro");

        if ((nTipoLiquidacionCobro != "NULL" && nTipoLiquidacionCobro != "-1") || (nIdCuentaRE != "NULL" && nIdCuentaRE != "-1")) {
            
            if (nTipoLiquidacionCobro == "-1" || nTipoLiquidacionCobro == "NULL") {
                mostrarSpanMsg(5, "alert-danger", 'Seleccione un tipo de liquidación para el cobro');
                return;
            }

            if (nIdCuentaRE == "-1" || nIdCuentaRE == "NULL") {
                mostrarSpanMsg(5, "alert-danger", 'Seleccione una cuenta de RED');
                return;
            }
            
            if (nTipoLiquidacionCobro == "1") {
                // Tndias
                if (nCobroTnDias == "NULL" || parseInt(nCobroTnDias) <= 0) {
                    mostrarSpanMsg(5, "alert-danger", 'El valor de T+n días debe ser mayor a 0');
                    return;
                } 
                nCobroDiasAtras = "NULL";
                nCobroDiaPago = "NULL";
                calendarioCobro = calendarioDefault;
            }
            else if (nTipoLiquidacionCobro == "2") {
                // Calendario
                if (contarCheckCalendario("Cobro") == 0) {
                    mostrarSpanMsg(5, "alert-danger", 'Configure el calendario de liquidaciones para cobro');
                    return;
                }
                nCobroDiasAtras = "NULL";
                nCobroDiaPago = "NULL";
                nCobroTnDias = "NULL";
            }
            else if (nTipoLiquidacionCobro == "4") {
                // Semanal
                if (nCobroDiaPago == "NULL" || nCobroDiaPago == "-1") {
                    mostrarSpanMsg(5, "alert-danger", 'Debe seleccionar una día de pago');
                    return;
                }
                if (nCobroDiasAtras == "NULL" || parseInt(nCobroDiasAtras) < 0) {
                    mostrarSpanMsg(5, "alert-danger", 'El valor de días hacia atras debe ser mayor o igual a 0');
                    return;
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

        var form = {
            idCliente: $("#p_cliente").val(),
            estatusCliente: estatus,

            nTipoLiquidacionRecaudo: tipoRecaudoVal,
            nLimiteCredito: montoLimiteCredito,
            nRetieneTransferencia: cmbCostoTransfVal,
            nMontoTransferencia: $("#nMontoTransferencia").val() || 0,
            nTipoLiquidacion: tipoLiquidacionOp,
            nTndias: tnDiasOp,
            nDiaPago: nDiaPagoOp,
            nDiasAtras: nDiaAtrasOp,
            calendarioRecaudo: calendarioOp,

            nDescForeloCli: $('#checkDescFDM').is(':checked') ? 1 : 0,
            nDescForeloPG: $('#checkDescGD').is(':checked') ? 1 : 0,
            nCadenaTicket: $('#checkTicketResp').is(':checked') ? 1 : 0,
            nValidaMonto: validaCobroVal,
            nComisionAdicional: comisionIntegradorVal,
            nTipoLiquidacionPago: tipoLiquidacionPago,
            nTipoPrepago: cmbPeriodoPrePagoCom,
            nRetieneComision: nRetieneComision,
            nPagoTnDias: tnDiasPago,
            nPagoDiaPago: nPagoDiaPago,
            nPagoDiasAtras: nDiaAtrasPago,
            sCorreoEnvio: correosNotificaciones.join(':') || "",
            calendarioPago: calendarioPago,            

            nIdBanco: nIdBanco,
            sNumCuenta: sNumCuenta,
            sCLABE: sCLABE,
            sBeneficiario: sBeneficiario,
            nIdPaisPago: nIdPaisPago,
            sSwift: sSwift,
            sABA: sABA,
            nIdMonedaExt: nIdMonedaExt,

            nCobroComisiones: nCobroComisiones,
            nTipoLiquidacionCobro: nTipoLiquidacionCobro,
            nIdCuentaRE: nIdCuentaRE,
            nCobroTnDias: nCobroTnDias,
            nCobroDiaPago: nCobroDiaPago,
            nCobroDiasAtras: nCobroDiasAtras,
            calendarioCobro: calendarioCobro,

            secciones: estadoSecciones.join(','),
            numSeccion: 5
        }

        $("#btnGuardar5").prop("disabled", true);
        loadingApartados(5, false);
        $.post(BASE_PATH + '/MesaControl/cliente/ajax/actualizarApartadoLiquidacion.php', form)
            .done(function(data) {
                var data = jQuery.parseJSON(data);

                if (parseInt(data.code) == 0) {
                    apartadoLiquidacionesActualizado = true;
                    comprobarSecciones(5, data.msg);
                } else {
                    jAlert(data.msg);
                    loadingApartados(5, true);
                }

                $("#btnGuardar5").prop("disabled", false);
                autorizaControlCambio('sSeccion5');
            })
            .fail(function (err) {
                jAlert("Error al actualizar los datos de liquidación");
                $("#btnGuardar5").prop("disabled", false);
                loadingApartados(5, true);
            });
    } else {
        jAlert("Los datos del apartado de liquidación no han sido cargados");
    }
}

var facturacionCargado = false;
function cargarApartadoFacturacion() {
    if (!facturacionCargado) {
        loadingApartados(6, false);
        try {
            $.post(BASE_PATH + '/MesaControl/cliente/ajax/getApartadoFacturacion.php', {idCliente: $("#p_cliente").val()})
                .done(function(data) {
                    var dataFAC = jQuery.parseJSON(data);
 
                    if( $("#cmbticket").val() === '0' ) {
                        $("#contenidoFacturaComision").addClass("hidden");
                    } else {
                        $("#contenidoFacturaComision").removeClass("hidden");
                    }
                    let datos_seccion = [];
                    let facIdEstatus = "";
                    let facSeccion = "{}";
                    if (dataFAC.length > 0) {
                        for (let fac of dataFAC) {
                            var tipo = "";
                            if (fac.nTipoFactura == "1") {
                                tipo = "Comision";
                                $("#cmbIVAComision").val(fac.nIVA);
                            } else {
                                tipo = "TAE";
                            }

                            $("#cmbCFDI"+tipo).val(fac.sUsoCFDI || "G03");
                            $("#cmbFormaPago"+tipo).val(fac.sFormaPago || "99");
                            $("#cmbMetodoPago"+tipo).val(fac.sMetodoPago || "PDD");
                            $("#cmbProductoServicio"+tipo).val(fac.sClaveProductoServicio || "80141628");
                            $("#cmbClaveUnidad"+tipo).val(fac.sUnidad || "ACT");
                            $("#periocidad"+tipo).val(fac.nPeriodoFacturacion || "-1");
                            $("#diasLiquidacion"+tipo).val(fac.nDiaFacturacionSemanal || 0);

                            if (fac.sCorreoDestino) {
                                var correos         = [];
                                correos = fac.sCorreoDestino.split(":");
                                for (let correo of correos) {
                                    if (tipo == "Comision") {
                                        sCorreoDestino_original.push(correo);
                                        agregarcorreosfacturasComision(correo);
                                    } else {
                                        sCorreoDestinoTae_original.push(correo);
                                        agregarcorreosfacturasTAE(correo);
                                    }                                 
                                }
                            }
                            if($("input[name=gbTipoPersona]").val() == 2) {
                                $("#div_impuestos_comisiones").hide();
                                $("#cmbIVAComision").val("0.1600").change();
                            }
                            /*** Modificación para control de cambios */
                            facIdEstatus = fac.idEstatus;
                            facSeccion = fac.sSeccion6;
                            datos_seccion = {
                                'sSeccion': fac.sSeccion6,
                                'nIdActualizacion': fac.nIdActualizacion,
                                'bRevisionSecciones': fac.bRevisionSecciones,
                                'nIdCliente': $("#p_cliente").val(),
                                'allSecciones': {
                                    'sSeccion1': fac.sSeccion1,
                                    'sSeccion2': fac.sSeccion2,
                                    'sSeccion3': fac.sSeccion3,
                                    'sSeccion4': fac.sSeccion4,
                                    'sSeccion5': fac.sSeccion5,
                                    'sSeccion6': fac.sSeccion6,
                                    'sSeccion7': fac.sSeccion7,
                                }
                            };
                            /*** /Modificación para control de cambios */
                        }
                    } else {
                        $("#cmbCFDIComision").val("G03");
                        $("#cmbFormaPagoComision").val("99");
                        $("#cmbMetodoPagoComision").val("PPD");
                        $("#cmbCFDITAE").val("G03");
                        $("#cmbFormaPagoTAE").val("99");
                        $("#cmbMetodoPagoTAE").val("PPD");
                    }
                    
                    loadingApartados(6, true);
                    facturacionCargado = true;
                    if(!PERMISOS) {
                        desabilitarInputs(6,false);
                    }
                    /*** Modificación para control de cambios */
                    dataSeccion         = JSON.parse(facSeccion);
                    status_seccion = (dataSeccion != null && dataSeccion.hasOwnProperty('status')) ? dataSeccion.status : facSeccion;
                    facIdEstatus = idEstatusSeccion6;
                    controlBotones(facIdEstatus, status_seccion);
                    if(facIdEstatus == "0") {
                        setSSeccion('sSeccion6', datos_seccion);
                    }
                    /*** /Modificación para control de cambios */
                })
                .fail(function (err) {
                    loadingApartados(6, true);
                    jAlert("Error al cargar el apartado de facturas");
                });
        } catch (e) {
            loadingApartados(6, true);
            jAlert("Error al cargar el apartado de facturas");
        }
    }
}

var apartadoFacturacionActualizado = false;
function actualizarApartadoFacturas() {
    if (facturacionCargado) {

        var sUsoCFDI = $("#cmbCFDIComision").val();
        var sClaveProductoServicio = $("#cmbProductoServicioComision").val();
        var sUnidad = $("#cmbClaveUnidadComision").val();
        var sFormaPago = $("#cmbFormaPagoComision").val();
        var sMetodoPago = $("#cmbMetodoPagoComision").val();
        var sCorreoDestino = correosenvfacturasComision.join(':');
        var nPeriodoFacturacion = $("#periocidadComision").val();
        var nDiaFacturacionSemanal = $("#diasLiquidacionComision").val();
        var nIVAComision = $("#cmbIVAComision").val();

        if($("#cmbticket").val()*1 > 0 ) {
            if (!sUsoCFDI || sUsoCFDI == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione el uso de CFDI en factura de comisiones');
                return;
            }

            if (!sClaveProductoServicio || sClaveProductoServicio == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione la clave del producto en factura de comisiones');
                return;
            }

            if (!sFormaPago || sFormaPago == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione la forma de pago en factura de comisiones');
                return;
            }

            if (!sUnidad || sUnidad == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione la clave de unidad en factura de comisiones');
                return;
            }

            if (!sMetodoPago || sMetodoPago == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione el método de pago en factura de comisiones');
                return;
            }

            if (!nPeriodoFacturacion || nPeriodoFacturacion == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione el período de facturación en factura de comisiones');
                return;
            }

            if (!nDiaFacturacionSemanal || parseInt(nDiaFacturacionSemanal) < 0) {
                mostrarSpanMsg(6, "alert-danger", 'El día de facturación debe ser mayor o igual a 0');
                return;
            }

            if (correosenvfacturasComision.length == 0) {
                mostrarSpanMsg(6, "alert-danger", 'Ingrese un correo para el envío de factura de comisiones');
                return;
            }
        }

        if (!nIVAComision || nIVAComision == "-1") {
            mostrarSpanMsg(6, "alert-danger", 'Seleccione el IVA aplicable a las facturas de comisiones');
            return;
        }

        var nFacturaTAE = $('#cmbReqFacTAE').val();
        var sUsoCFDITAE = $("#cmbCFDITAE").val();
        var sClaveProductoServicioTAE = $("#cmbProductoServicioTAE").val();
        var sUnidadTAE = $("#cmbClaveUnidadTAE").val();
        var sFormaPagoTAE = $("#cmbFormaPagoTAE").val();
        var sMetodoPagoTAE = $("#cmbMetodoPagoTAE").val();
        var sCorreoDestinoTAE = correosenvfacturasTAE.join(':');
        var nPeriodoFacturacionTAE = $("#periocidadTAE").val();
        var nDiaFacturacionSemanalTAE = $("#diasLiquidacionTAE").val();
       
        if (nFacturaTAE == "1") {

            if (!sUsoCFDITAE || sUsoCFDITAE == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione el uso de CFDI en factura TAE');
                return;
            }
    
            if (!sClaveProductoServicioTAE || sClaveProductoServicioTAE == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione la clave del producto en factura TAE');
                return;
            }
    
            if (!sFormaPagoTAE || sFormaPagoTAE == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione la forma de pago en factura TAE');
                return;
            }
    
            if (!sUnidadTAE || sUnidadTAE == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione la clave de unidad en factura TAE');
                return;
            }
    
            if (!sMetodoPagoTAE || sMetodoPagoTAE == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione el método de pago en factura TAE');
                return;
            }
    
            if (!nPeriodoFacturacionTAE || nPeriodoFacturacionTAE == "-1") {
                mostrarSpanMsg(6, "alert-danger", 'Seleccione el período de facturación en factura TAE');
                return;
            }
    
            if (!nDiaFacturacionSemanalTAE || parseInt(nDiaFacturacionSemanalTAE) < 0) {
                mostrarSpanMsg(6, "alert-danger", 'El día de facturación debe ser mayor o igual a 0');
                return;
            }
    
            if (correosenvfacturasTAE.length == 0) {
                mostrarSpanMsg(6, "alert-danger", 'Ingrese un correo para el envío de factura TAE');
                return;
            }
        }

        var nRetieneISR = $("#nRetieneISR").val();
        var nRetieneIVA = $("#nRetieneIVA").val();

        if (!nRetieneISR || nRetieneISR == "-1") {
            mostrarSpanMsg(6, "alert-danger", 'Especifique si el cliente retiene ISR');
            return;
        }

        if (!nRetieneIVA || nRetieneIVA == "-1") {
            mostrarSpanMsg(6, "alert-danger", 'Especifique si el cliente retiene IVA');
            return;
        }
        
        var form = {
            idCliente: $("#p_cliente").val(),
            estatusCliente: estatus,

            nTipoFactura: "1",
            sUsoCFDI: sUsoCFDI,
            sClaveProductoServicio: sClaveProductoServicio,
            sUnidad: sUnidad,
            sFormaPago: sFormaPago,
            sMetodoPago: sMetodoPago,
            sCorreoDestino: sCorreoDestino,
            nPeriodoFacturacion: nPeriodoFacturacion,
            nDiaFacturacionSemanal: nDiaFacturacionSemanal,
            nIVAComision: nIVAComision,

            nFacturaTAE: nFacturaTAE,
            nTipoFacturaTAE: "4",
            sUsoCFDITAE: sUsoCFDITAE,
            sClaveProductoServicioTAE: sClaveProductoServicioTAE,
            sUnidadTAE: sUnidadTAE,
            sFormaPagoTAE: sFormaPagoTAE,
            sMetodoPagoTAE: sMetodoPagoTAE,
            sCorreoDestinoTAE: sCorreoDestinoTAE,
            nPeriodoFacturacionTAE: nPeriodoFacturacionTAE,
            nDiaFacturacionSemanalTAE: nDiaFacturacionSemanalTAE,

            nRetieneISR: nRetieneISR,
            nRetieneIVA: nRetieneIVA,

            secciones: estadoSecciones.join(','),
            numSeccion: 6
        }

        loadingApartados(6, false);
        $("#btnGuardar6").prop("disabled", true);
        $.post(BASE_PATH + '/MesaControl/cliente/ajax/actualizarApartadoFacturacion.php', form)
            .done(function(data) {
                var data = jQuery.parseJSON(data);

                if (parseInt(data.code) == 0) {
                    apartadoFacturacionActualizado = true;
                    comprobarSecciones(6, data.msg);
                } else {
                    jAlert(data.msg);
                    loadingApartados(6, true);
                }

                $("#btnGuardar6").prop("disabled", false);
                autorizaControlCambio('sSeccion6');
            })
            .fail(function (err) {
                jAlert("Error al actualizar los datos de facturación");
                $("#btnGuardar6").prop("disabled", false);
                loadingApartados(6, true);
            });
    } else {
        jAlert("Los datos del apartado de facturación no han sido cargados");
    }
}

var matrizEscCargado = false;
var contadorFilas = 0;
function cargarApartadoMatriz() {
    if (!matrizEscCargado) {
        loadingApartados(8, false);
        try {
            $.post(BASE_PATH + '/MesaControl/cliente/ajax/getApartadoMatriz.php', {idCliente: $("#p_cliente").val()})
                .done(function(data) {
                    var dataMA = jQuery.parseJSON(data);
    
                    for (let fila of dataMA) {
                        agregarFilaMatrizHTML(fila);
                    }

                    matrizEscCargado = true;
                    loadingApartados(8, true);
                })
                .fail(function (err) {
                    jAlert("Error al cargar el apartado de matriz escalamiento");
                    loadingApartados(8, true);
                });
        } catch (e) {
            jAlert("Error al cargar el apartado de matriz escalamiento");
            loadingApartados(8, true);
        }
    }
}

/**
 * Genera el html para mostrar una fila de la matriz de escalamiento
 * @param {*} data - Datos del contacto
 */
function agregarFilaMatrizHTML(data) {
    var fila = "<tr class='tr_class' id='fila_" + contadorFilas + "'><td><input disabled data-toggle='tooltip' title='Dato modificable en catálogo maestro' type='text' id='area_" + contadorFilas + "' class='form-control m-bot15'></td><td><input disabled data-toggle='tooltip' title='Dato modificable en catálogo maestro' type='text' id='nombre_" + contadorFilas + "' class='form-control m-bot15'></td><td><input disabled data-toggle='tooltip' title='Dato modificable en catálogo maestro' type='text' id='telefono_" + contadorFilas + "'  maxlength='12'  class='form-control m-bot15'></td><td><input disabled type='text' data-toggle='tooltip' title='Dato modificable en catálogo maestro' id='correo_" + contadorFilas + "' class='form-control m-bot15'></td><td><input disabled data-toggle='tooltip' title='Dato modificable en catálogo maestro' type='text' id='comentario_" + contadorFilas + "' class='form-control m-bot15'></td></tr>";
    
    if (contadorFilas != 0) { 
        $("#tabla_escalamiento").append(fila);
    }

    $("#area_" + contadorFilas + " ").val(data.sAreaNombre);
    $("#nombre_" + contadorFilas + " ").val(data.sNombre);
    $("#telefono_" + contadorFilas + " ").val(data.sTelefono);
    $("#correo_" + contadorFilas + " ").val(data.sMail); 
    $("#comentario_" + contadorFilas + " ").val(data.sComentario); 

    contadorFilas++;
}

var docsCargado = false;
var docs = [];
function cargarApartadoDocs() {
    if (!docsCargado) {
        loadingApartados(4, false);
        try {
            $.post(BASE_PATH + '/MesaControl/cliente/ajax/getDocumentos.php', 
                {
                    idCliente: $("#p_cliente").val()
                })
                .done(function(data) {
                    var obj = jQuery.parseJSON(data);
                    
                    jQuery.each(obj, function(index, value) {
                        var idDoc = obj[index]['nIdDocumento'];
                        var tipoDoc = obj[index]['nIdTipoDocumento'];
                        var nombreDoc = obj[index]['sNombreDocumento'];
                        var rutadoc = obj[index]['sRutaDocumento'];

                        docs.push({idDoc, tipoDoc, nombreDoc, rutadoc});

                        if (tipoDoc == 1) {
                            $("#urlActa").val(rutadoc + nombreDoc);
                            $("#file_Acta").removeClass("disabled");
                        }
                        if (tipoDoc == 2) {
                            $("#urlRFC").val(rutadoc + nombreDoc);
                            $("#file_Rfc").removeClass("disabled");
                        }
                        if (tipoDoc == 3) {
                            $("#urlDomicilio").val(rutadoc + nombreDoc);
                            $("#file_Domicilio").removeClass("disabled");
                        }
                        if (tipoDoc == 4) {
                            $("#urlPoder").val(rutadoc + nombreDoc);
                            $("#file_Poder").removeClass("disabled");
                        }
                        if (tipoDoc == 5) {
                            $("#urlRepre").val(rutadoc + nombreDoc);
                            $("#file_Repre").removeClass("disabled");
                        }
                        if (tipoDoc == 6) {
                            $("#urlContrato").val(rutadoc + nombreDoc);
                            $("#file_Contrato").removeClass("disabled");
                        }
                        if (tipoDoc == 7) {
                            $("#urlAdendo1").val(rutadoc + nombreDoc);
                            $("#file_Adendo1").removeClass("disabled");
                        }
                        if (tipoDoc == 8) {
                            $("#urlAdendo2").val(rutadoc + nombreDoc);
                            $("#file_Adendo2").removeClass("disabled");
                        }
                        if (tipoDoc == 9) {
                            $("#urlAdendo3").val(rutadoc + nombreDoc);
                            $("#file_Adendo3").removeClass("disabled");
                        }
                        if (tipoDoc == 10) {
                            $("#urlID").val(rutadoc + nombreDoc);
                            $("#file_IDFisica").removeClass("disabled");
                        }
                        if (tipoDoc == 11) {
                            $("#urlctabancaria").val(rutadoc + nombreDoc);
                            $("#file_ctabancaria").removeClass("disabled");
                        }
                        if (tipoDoc == 12) {
                            $("#urlactPrepSat").val(rutadoc + nombreDoc);
                            $("#file_actPrepSat").removeClass("disabled");
                        }
                    });

                    docsCargado = true;
                    loadingApartados(4, true);
                    if(!PERMISOS) {
                        desabilitarInputs(4,false);
                    }
                })
                .fail(function (err) {
                    jAlert("Error al cargar los documentos");
                    loadingApartados(4, true);
                });
        } catch (e) {
            jAlert("Error al cargar los documentos");
            loadingApartados(4, true);
        }
    }
}

function actualizarApartadoDocs() {
    var contrato, rfc, domicilio, banco;

    for (doc of docs) {
        switch (doc.tipoDoc) {
            case '2':
                rfc = true;
                break;
            case '3':
                domicilio = true;
                break;
            case '6':
                contrato = true;
                break;
            case '11':
                banco = true;
                break;
        }
    }

    if (contrato && rfc && domicilio && banco) {
        loadingApartados(4, false);
        $("#btnGuardar4").prop("disabled", true);

        const form = {
            idCliente: $("#p_cliente").val(),
            estatusCliente: estatus,
            secciones: estadoSecciones.join(','),
            numSeccion: 4,
            config: 1
        }

        $.post(BASE_PATH + '/MesaControl/cliente/ajax/actualizarSeccion.php', form)
            .done(function(data) {
                $("#btnGuardar4").prop("disabled", false);
                comprobarSecciones(4, "Datos de documentos actualizados correctamente");
            })
            .fail(function (err) {
                jAlert("Error al actualizar los documentos");
                $("#btnGuardar4").prop("disabled", false);
                loadingApartados(4, true);
            });
    } else {
        jAlert("Subir documentos obligatorios (*)");
    }
}

/**
 * Genera un array que representa los dias seleccionados del calendario
 * @param {*} clase - Comision, cobro, operaciones
 * @param {*} numDias - Numero de dias del calendario
 * @returns {Array}
 */
function getDiasCalendarios(clase, numDias = 5) {
    var arrayDias = Array();

    for (let i=0; i<numDias; i++) {
        var dia = Array();
        var diaCorte = "";

        switch(i) {
            case 0:
                diaCorte = "Lu";
                break;
            case 1:
                diaCorte = "Ma";
                break;
            case 2:
                diaCorte = "Mi";
                break;
            case 3:
                diaCorte = "Ju";
                break;
            case 4:
                diaCorte = "Vi";
                break;
            default:
                break;
        }

        $.each($('.'+diaCorte+'_Check_'+clase+':checkbox:checked'), function(key, value) {
            dia.push($(value).attr("id"));
        });

        if (dia.length == 0) {
            dia.push("");
        }

        arrayDias.push(dia.join(','));
    }

    return arrayDias;
}

/**
 * Dependiendo del tipo de regimen muestra o oculta campos
 */
function configTipoPersona() {
    if ($('#gbPersonaMoral').is(':checked')) {
        $("#divNombreApellidos").hide();
        $("#divCheckFisicaGeneral").hide();

        $("#sRazonSocial").prop("disabled", true);
        $("#nRetieneIVA").prop("disabled", false);
        $("#nRetieneISR").prop("disabled", false);
        configDocsTipoPersona(2);
    }
    else if ($('#gbPersonaRFC').is(':checked')) {
        $("#divNombreApellidos").show();
        $("#divCheckFisicaGeneral").show();

        $("#sRazonSocial").prop("disabled", true);
        $("#nRetieneIVA").prop("disabled", true);
        $("#nRetieneISR").prop("disabled", true);
        configDocsTipoPersona(1);
    }
}

/**
 * Dependiendo del regimen muestra o oculta inputs para subir documentos especificos
 * @param {*} tipo - Tipo de regimen de la persona fisico|moral 
 */
function configDocsTipoPersona(tipo) {
    if (tipo == 2) {
        // Moral 
        $("#div_docRFC label").html("Cédula fiscal *");
        $("#div_docRFC").show();
        $("#div_docActConstitutiva").show();
        $("#div_docComprobanteDomicilio").show();
        $("#div_docPoderReplegal").show();
        $("#div_docIdReplegal").show();
        $("#div_docContrato").show();
        $("#div_docAdendo1").show();
        $("#div_docAdendo2").show();
        $("#div_docAdendo3").show();
        $("#div_docIdentificacion").hide();
        $("#div_docCtaBancaria").show();
        $("#div_ActPrepSat").hide();
    } else {
        // Fisica
        $("#div_docRFC label").html("Cédula fiscal *")
        $("#div_docRFC").show();
        $("#div_docActConstitutiva").hide();
        $("#div_docComprobanteDomicilio").show();
        $("#div_docPoderReplegal").hide();
        $("#div_docIdReplegal").hide();
        $("#div_docContrato").show();
        $("#div_docAdendo1").hide();
        $("#div_docAdendo2").hide();
        $("#div_docAdendo3").hide();
        $("#div_docIdentificacion").show();
        $("#div_docCtaBancaria").show();
        $("#div_ActPrepSat").show();
    }
}

/**
 * Al detectar un cambio en un input de documento, lo sube automaticamente
 * y le asigna la url obtenida en el campo hidden
 */
function configuracionInputDocs() {
    $(':input[type=file]').unbind('change');
    $(':input[type=file]').on('change', function(e){
        e.stopPropagation();
        var input		= e.target;
        var nIdTipoDoc	= input.getAttribute('idtipodoc');
        var file = $(input).prop('files')[0];
        var inputFile = $(this);
        if(file == undefined) {
            inputFile.addClass('transparent');
            return false;
        }

        var formdata = new FormData();
        formdata.append('sFile', file);
        formdata.append('nIdTipoDoc', nIdTipoDoc);
        formdata.append('nIdCliente', $("#p_cliente").val());
        formdata.append('rfc', $("#rfc").val());

        const size = (file.size / 1024 / 1024).toFixed(2);
        inputFile.removeClass('transparent');
        if(file.type != 'application/pdf'){
            jAlert('El archivo debe ser formato pdf');
            inputFile.val(inputFile.prop('defaultValue'));
            inputFile.addClass('transparent');
        } else if (size > 15) {
            jAlert("El tamaño máximo de un archivo es de 15 MB");
            inputFile.val(inputFile.prop('defaultValue'));
            inputFile.addClass('transparent');
        } else{
            $(input).parent().parent().parent().find(".btnfiles").addClass("disabled")
            $.ajax({
                url			: BASE_PATH + '/MesaControl/cliente/ajax/actualizarDocumento.php',
                type		: 'POST',
                contentType	: false,
                data		: formdata,
                mimeType    : "multipart/form-data",
                processData	: false,
                cache		: false,
                dataType	: 'json'
            })
            .done(function(resp){
                if(resp.idDoc > 0) {
                    if (nIdTipoDoc == 1) {
                        $("#urlActa").val(resp.url);
                        $("#file_Acta").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 2) {
                        $("#urlRFC").val(resp.url);
                        $("#file_Rfc").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 3) {
                        $("#urlDomicilio").val(resp.url);
                        $("#file_Domicilio").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 4) {
                        $("#urlPoder").val(resp.url);
                        $("#file_Poder").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 5) {
                        $("#urlRepre").val(resp.url);
                        $("#file_Repre").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 6) {
                        $("#urlContrato").val(resp.url);
                        $("#file_Contrato").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 7) {
                        $("#urlAdendo1").val(resp.url);
                        $("#file_Adendo1").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 8) {
                        $("#urlAdendo2").val(resp.url);
                        $("#file_Adendo2").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 9) {
                        $("#urlAdendo3").val(resp.url);
                        $("#file_Adendo3").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 10) {
                        $("#urlID").val(resp.url);
                        $("#file_IDFisica").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 11) {
                        $("#urlctabancaria").val(resp.url);
                        $("#file_ctabancaria").removeClass("disabled");
                    }
                    if (nIdTipoDoc == 12) {
                        $("#urlactPrepSat").val(resp.url);
                        $("#file_actPrepSat").removeClass("disabled");
                    }
                    
                    jAlert('Documento Cargado Exitosamente');
                    docs.push({tipoDoc: nIdTipoDoc+""});
                }
                else{
                    inputFile.val(inputFile.prop('defaultValue'));
                    inputFile.addClass('transparent');
                    jAlert('Error al Intentar Subir el Archivo');
                    console.log(resp);
                }
            })
            .fail(function(e){
                inputFile.val(inputFile.prop('defaultValue'));
                inputFile.addClass('transparent');
                jAlert('Error al Intentar Subir el Archivo');
            });
        }
    });
}

/**
 * Contiene todas las configuraciones de los campos especiales que al detectar un cambio realizan una accion
 */
function configuracionCampos() {

    $("#txtSCadena").autocomplete({
        source: function(request,respond){
            $.post( "./models/Cat_Cadena.php", { "strBuscar": request.term },
            function( response ) {
                respond(response);
            }, "json" );
        },
        minLength: 1,
        focus: function(event,ui){
            $("#txtSCadena").val(ui.item.sNombreCadena);
            return false;
        },
        select: function(event,ui){
            $("#txtIdCadena").val(ui.item.nIdCadena);
            return false;
        },
        search: function(){
            $("#txtIdCadena").val('');
        }
    })
    .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        ul.css({
            "border": "2px solid #ddd", 
            "padding": "2px", 
            "border-radius" : "5px", 
            "background-color": "#EDEFF1",
            "max-width": $("#txtSCadena").width() + "px"
        });

        return $( '<li>' )
        .append( "<a style=\"color:black\">" + item.value + "</a>" )
        .appendTo( ul );
    };	

    $('#txtSCadena').on('change', function(e){//no se si esto aun no estba terminado
        if(myTrim(e.target.value) == ''){
            $('#txtIdCadena').val('');
        }
    });

    $('#txtSCadena').alphanum({
        allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
        allowSpace			: true,
        allowNumeric		: true,
        allowUpper			: true,
        allowLatin			: true,
        allowOtherCharSets	: false
    });

    $('#nuevocorreonotificaciones').alphanum({
        'allow'				: '@.-_',
        allowSpace			: false,
        allowNumeric		: true,
        allowOtherCharSets	: false,
        maxLength			: 150
    });

    $('#nuevocorreofacturasComision').alphanum({
        'allow'				: '@.-_',
        allowSpace			: false,
        allowNumeric		: true,
        allowOtherCharSets	: false,
        maxLength			: 150
    });

    $('#nuevocorreofacturasTAE').alphanum({
        'allow'				: '@.-_',
        allowSpace			: false,
        allowNumeric		: true,
        allowOtherCharSets	: false,
        maxLength			: 150
    });

    $('#cmbReqFacTAE').on('change', function(e) {
        e.target.value == '1' ? $('#contenidoFacturaTae').show() : $('#contenidoFacturaTae').hide()
    });

    $('#checkModPruebas').on('change', function(e) {
        !this.checked ? $('#divFechaModPruebas').hide() : $('#divFechaModPruebas').show();
        !this.checked ? $('#checkModProduccion').prop('disabled',false) : $('#checkModProduccion').prop('disabled',true);
    })

    $('#checkIntegrador').on('change', function(e) {
        !this.checked ? $('#div_cmb_comision_integrador').hide() : $('#div_cmb_comision_integrador').show(); 
    })

    $('#checkModProduccion').on('change', function(e) {
        !this.checked ? $('#divFechaModProduccion').hide() : $('#divFechaModProduccion').show();
        !this.checked ? $('#checkModPruebas').prop('disabled',false) : $('#checkModPruebas').prop('disabled',true);
    })

    $('.fisico').on('keyup', function(e){
        var nombre = $('#sNombreFisico').val();
        var paterno = $('#sPaternoCliente').val();
        var materno = $('#sMaternoCliente').val();
        var nombreConcatenado = nombre + ' ' + paterno + ' ' + materno;
        
        $('#sRazonSocial').val(nombreConcatenado.toUpperCase());
        $('#sNombreComercial').val(nombreConcatenado.toUpperCase());

        if($('#txtBeneficiario').length > 0){
            $('#txtBeneficiario').val(nombreConcatenado.toUpperCase());
        }
    });

    $('#checkVigencia').on('change', function(e) {
        if (this.checked) {
            calcularFechaVigenciaIndefinida();
            $('#divNumVigencia').hide();
            $("#fecRevisionCondicion").prop("disabled",false);
        } else {
            $('#divNumVigencia').show();
            $("#fecRevisionCondicion").prop("disabled",true);
        }
        $("#txtNumVigencia").val("");
    })

    $('#txtNumVigencia').keyup(function(e) {
        try {
            if ($('#fecContrato').val() != "") {
                calcularFechaVigencia();
            } else {
                mostrarSpanMsg(3, "alert-danger", 'No hay definida una fecha de contrato');
            }
        } catch (e) {
            jAlert('Error al calcular la fecha de vigencia del contrato');
        }
    });

    $('#fecContrato').on('change', function(e) {
        if ($(this).val() == "") {
            $('#fecRenovarContrato').val("");        
        }
        $( "#fecRevisionCondicion" ).datepicker( "option", "minDate",$('#fecContrato').val() );
    })

    $("#cmbTipoLiquidacionOperaciones").on("change", function(e) {
        let valTipo = $(this).val();
        
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
    });

    $("#cmbPeriodoPagoCom").on("change", function(e) {
        let valTipo = $(this).val();
        
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
    });

    $("#cmbPeriodoCobroCom").on("change", function(e) {
        let valTipo = $(this).val();
        
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
    });

    $('input[name=tipoLiqRecaudo]').on('change', function(e) {
        if (this.value == "2") {
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
    });
    $('input[name=limitCredit]').on('change', function(e) {
        if (this.value == "1") {
            $("#limiteCredito").show()
        } else {
            $("#limiteCredito").hide()
            $("#montoLimiteCredito").val(0);
        }
    });

    $("#cmbCostoTransferencia").on('change', function(e) {
        e.target.value == '1' ? $('#div_monto_transferencia').show() : $('#div_monto_transferencia').hide();
    });

    $("#cmbComisionIntegrador").on('change', function(e) {
        e.target.value == '1' ? $('#div_monto_comision_adicional').show() : $('#div_monto_comision_adicional').hide();
    });

    $("#cmbPaisPago").on('change', function(e) {
        if ($(this).val() == "164") {
            $("#cmbMonedaExt").val("1");
            //$("#cmbMonedaExt").prop("disabled", true);
        } else {
            //$("#cmbMonedaExt").prop("disabled", false);
        }
    })

    $("#cmbFormaPagoComision").on('change', function(e) {
        if ($(this).val() == "17") {
            $("#cmbMetodoPagoComision").val("PUE");   
        } else if (($(this).val() == "99")) {
            $("#cmbMetodoPagoComision").val("PPD");
        }
    });

    $("#cmbFormaPagoTAE").on('change', function(e) {
        if ($(this).val() == "17") {
            $("#cmbMetodoPagoTAE").val("PUE");   
        } else if (($(this).val() == "99")) {
            $("#cmbMetodoPagoTAE").val("PPD");
        }
    });

    $("#cmbRetieneComision").on('change', function(e) {
        if ($(this).val() == "1") {
            $("#cmbPeriodoPagoCom").val("-1").trigger("change");
            $("#divPeriodoPagoComision").hide();
        } else {
            $("#divPeriodoPagoComision").show();
        }
    });

    $('#verificar').click(function() {
        if (!$(this).hasClass("disabled")) {
            
            if (verificarRequest != null){
                return true;
            }
            if(confirm("¿Desea autorizar este cliente?")) {
                $("#spanAutorizar").html("<i class='fa fa-spinner fa-spin '></i>");

                verificarRequest = $.ajax({
                    data: { 
                        nIdCliente: $('#p_cliente').val(),
                        sRFC: $("#rfc").val(),
                    },
                    type: 'POST',
                    url: BASE_PATH + '/MesaControl/cliente/ajax/actualizarAutorizacion.php',
                    dataType: 'json',
                    success: function(response) {
                        var data = jQuery.parseJSON(response);
                        let url = 'consulta.php?prealta=1';

                        let { code, msg } = data;
                        console.log(data);
        
                        if (code == 0) {
                            jAlert(msg, 'Éxito');
                            $('#verificar').addClass("hidden");
                            estatus = 0;
                            $("#btnGuardar1, #btnGuardar3, #btnGuardar4, #btnGuardar5, #btnGuardar6, #btnGuardar7").html("Guardar");
                            //setTimeout(function () { window.location.href = url; }, 2000);
                        } else {
                            jAlert(msg || 'Error al autorizar, notifique a sistemas', 'Oops!');
                        }
                        $("#spanAutorizar").html('<i class="glyphicon glyphicon-ok"></i>');
                    }
                });
            }
        } 
    });
}

function customRange(input) {
    var x=$('#fecContrato').datepicker("getDate");
    $("#fecRevisionCondicion").datepicker( "option", "minDate",x );
}

/**
 * Realiza al calculo de fecha de renovacion del contrato con el numero de vigencia especificado
 */
function calcularFechaVigencia() {
    var fecha = $("#fecContrato").val();

    if (fecha) {
        var numMeses = parseInt($("#txtNumVigencia").val());
        var i = 0;
        while(i < numMeses) {
            let partes = fecha.split("-");
            let anio = parseInt(partes[0]);
            let mes = parseInt(partes[1]);

            if ((mes + 1) > 12) {
                anio += 1;
                mes = 1;
            } else {
                mes += 1;
            }

            fecha = anio + "-" + mes + "-" + partes[2];
            i++;
        }
        $("#fecRenovarContrato").val(fecha);
        $("#fecRevisionCondicion").val(fecha);

    } else {
        $("#fecRenovarContrato").val("");
    }
}

function calcularFechaMayor(val) {
    return validate_fechaMayorQue(fechaHoy(), val);
}

/**
 * Realiza el calculo de la fecha de renovacion de contrato si no especifica vigencia 
 * Se le suma 10 anios a la fecha inicial
 */
function calcularFechaVigenciaIndefinida() {
    var fecha = $('#fecContrato').val();

    if (fecha) {
        var partes = fecha.split("-");
        var anioFuturo = parseInt(partes[0]) + 10;
        var fsv = anioFuturo + "-" + partes[1] + "-" + partes[2];
        $("#fecRenovarContrato").val(fsv);
    } else {
        $("#fecRenovarContrato").val("");
    }
}

/**
 * Muestra el modal con el documento que fue cargado previamente
 * @param {*} id - Id del tipo de documento
 */
function verdocumento(id) {

    if (id == "file_Domicilio") {
        var url = $("#urlDomicilio").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el Comprobante de Domicilio");
        }
    }
    if (id == "file_Rfc") {
        var url = $("#urlRFC").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el RFC");
        }
    }
    if (id == "file_Acta") {
        var url = $("#urlActa").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el Acta Constitutiva");
        }
    }
    if (id == "file_Poder") {
        var url = $("#urlPoder").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el Poder Legal");
        }
    }
    if (id == "file_Repre") {
        var url = $("#urlRepre").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el Id Representante");
        }
    }
    if (id == "file_Contrato") {
        var url = $("#urlContrato").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el Contrato");
        }
    }

    if (id == "file_Adendo1") {
        var url = $("#urlAdendo1").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el Adendo 1");
        }
    }

    if (id == "file_Adendo2") {
        var url = $("#urlAdendo2").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el Adendo 2");
        }
    }

    if (id == "file_Adendo3") {
        var url = $("#urlAdendo3").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el Adendo 3");
        }
    }

    if (id == "file_IDFisica") {
        var url = $("#urlID").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir el ID");
        }
    }

    if (id == "file_ctabancaria") {
        var url = $("#urlctabancaria").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir la Carátula de Cuenta Bancaria");
        }
    }

    if (id == "file_actPrepSat") {
        var url = $("#urlactPrepSat").val();
        var validarUndefined = url.includes("undefined");
        if (validarUndefined == false && url.length > 0) {
            $("#modal-agreement").modal('show');
            $("#contenedorEmbed").html("<embed src='"+url+"' frameborder='0' width='100%' height='400px' id='embertoIn'>");
        } else {
            jAlert("Favor de subir la Actividad Preponderante SAT");
        }
    }
}

/**
 * Valida si el email cumple con la expresion regular
 * @param {*} email - Email a validar
 * @returns {Boolean}
 */
function validarEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

/**
 * Apartados de correos - agregar/eliminan los correos que sean ingresados
 */

var correosNotificaciones = [];
function agregarCorreoNotificaciones(correoval) { //para agragar los correos por comision
    var num_correos = correosNotificaciones.length;
    if (num_correos < 50) {
        new_correo = correoval || $('#nuevocorreonotificaciones').val();
        if(correosNotificaciones.includes(new_correo)){
            // jAlert('El correo ya se encuentra en la lista');
            return;
        }
        if (validarEmail(new_correo) == false) {
            jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique');
            return;
        } else {
            correosNotificaciones.push(new_correo);
            var html = "<div class='col-xs-12 formCorreosNotificaciones'>";
            html += "<input type='text' id='camposCorreosNotificaciones' class='form-control m-bot15 lecturaCorreosNotificaciones' name='correosFacturasNotificaciones' value='" + new_correo + "' style='width: 270px; display:inline-block;' disabled>";
            html += "<button  class='remove_button lecturaCorreosNotificaciones btn btn-sm inhabilitar' id='removeCorreosNotificaciones' style='margin-left:3px;' value='" + new_correo + "' onclick='removercorreoNotificaciones(this.value);'>";
            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
            $('#contenedordecorreosliquidacion').append(html);
            $('#nuevocorreonotificaciones').val('');
        }
    } else {
        if (num_correos = 49) {
            $('#nuevocorreonotificaciones').attr('disabled', true);
            $('#nuevocorreonotificaciones').val('');
        }
        jAlert('Solo puede Agregar 50 Correos');
    }
}

function removercorreoNotificaciones(corr) { //para eliminar los correos por comision
    for (var i = 0; i < correosNotificaciones.length; i++) {
        while (correosNotificaciones[i] == corr) correosNotificaciones.splice(i, 1);
    }
    $('#contenedordecorreosliquidacion').empty();
    for (var i = 0; i < correosNotificaciones.length; i++) {
        $('#contenedordecorreosliquidacion').append('<div class="col-xs-12 formCorreosNotificaciones" ><input type="text" id="camposCorreosNotificaciones" class="form-control m-bot15 lecturaCorreosNotificaciones" name="correosFacturasNotificaciones" value="' + correosNotificaciones[i] + '" style="width: 270px; display:inline-block;" disabled><button  class="remove_button lecturaCorreosNotificaciones btn btn-sm inhabilitar" id="removeCorreosNotificaciones" style="margin-left:3px" value="' + correosNotificaciones[i] + '" onclick="removercorreoNotificaciones(this.value);"> <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    }
    if (correosNotificaciones.length < 50) {
        $('#nuevocorreonotificaciones').attr('disabled', false);
        $('#nuevocorreonotificaciones').val('');
    }
}

var correosenvfacturasComision = [];
function agregarcorreosfacturasComision(correoval) { //para agragar los correos por comision
    var num_correos = correosenvfacturasComision.length;
    if (num_correos < 50) {
        new_correo = correoval || $('#nuevocorreofacturasComision').val();
        if(correosenvfacturasComision.includes(new_correo)){
            // jAlert('El correo ya se encuentra en la lista');
            return;
        }
        if (validarEmail(new_correo) == false) {
            jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique');
            return;
        } else {
            correosenvfacturasComision.push(new_correo);
            var html = "<div class='col-xs-12 formCorreosComision'>";
            html += "<input type='text' id='camposCorreosComision' class='form-control m-bot15 lecturaCorreosComision' name='correosFacturasComision' value='" + new_correo + "' style='width: 270px; display:inline-block;' disabled>";
            html += "<button  class='remove_button lecturaCorreosComision btn btn-sm inhabilitar' id='removeCorreosComision' style='margin-left:3px;' value='" + new_correo + "' onclick='removercorreoFacturasComision(this.value);'>";
            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
            $('#contenedordecorreosfacturasComision').append(html);
            $('#nuevocorreofacturasComision').val('');
        }
    } else {
        if (num_correos = 49) {
            $('#nuevocorreofacturasComision').attr('disabled', true);
            $('#nuevocorreofacturasComision').val('');
        }
        jAlert('Solo puede Agregar 50 Correos');
    }
}

function removercorreoFacturasComision(corr) { //para eliminar los correos por comision
    for (var i = 0; i < correosenvfacturasComision.length; i++) {
        while (correosenvfacturasComision[i] == corr) correosenvfacturasComision.splice(i, 1);
    }
    $('#contenedordecorreosfacturasComision').empty();
    for (var i = 0; i < correosenvfacturasComision.length; i++) {
        $('#contenedordecorreosfacturasComision').append('<div class="col-xs-12 formCorreosComision" ><input type="text" id="camposCorreosComision" class="form-control m-bot15 lecturaCorreosComision" name="correosFacturasComision" value="' + correosenvfacturasComision[i] + '" style="width: 270px; display:inline-block;" disabled><button  class="remove_button lecturaCorreosComision btn btn-sm inhabilitar" id="removeCorreosComision" style="margin-left:3px" value="' + correosenvfacturasComision[i] + '" onclick="removercorreoFacturasComision(this.value);"> <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    }
    if (correosenvfacturasComision.length < 50) {
        $('#nuevocorreofacturasComision').attr('disabled', false);
        $('#nuevocorreofacturasComision').val('');
    }
}

var correosenvfacturasTAE = [];
function agregarcorreosfacturasTAE(correoval) {
    var num_correos = correosenvfacturasTAE.length;
    if (num_correos < 50) {
        new_correo = correoval || $('#nuevocorreofacturasTAE').val();
        if(correosenvfacturasTAE.includes(new_correo)){
            // jAlert('El correo ya se encuentra en la lista');
            return;
        }
        if (validarEmail(new_correo) == false) {
            jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique');
            return;
        } else {
            correosenvfacturasTAE.push(new_correo);
            var html = "<div class='col-xs-12 formCorreosTAE'>";
            html += "<input type='text' id='camposCorreosTAE' class='form-control m-bot15 lecturaCorreosComision' name='correosFacturasTAE' value='" + new_correo + "' style='width: 270px; display:inline-block;' disabled>";
            html += "<button  class='remove_button lecturaCorreosTAE btn btn-sm inhabilitar' id='removeCorreosTAE' style='margin-left:3px;' value='" + new_correo + "' onclick='removercorreoFacturasTAE(this.value);'>";
            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
            $('#contenedordecorreosfacturasTAE').append(html);
            $('#nuevocorreofacturasTAE').val('');
        }
    } else {
        if (num_correos = 49) {
            $('#nuevocorreofacturasTAE').attr('disabled', true);
            $('#nuevocorreofacturasTAE').val('');
        }
        jAlert('Solo puede Agregar 50 Correos');
    }
}

function removercorreoFacturasTAE(corr) { //para eliminar los correos por comision
    for (var i = 0; i < correosenvfacturasTAE.length; i++) {
        while (correosenvfacturasTAE[i] == corr) correosenvfacturasTAE.splice(i, 1);
    }
    $('#contenedordecorreosfacturasTAE').empty();
    for (var i = 0; i < correosenvfacturasTAE.length; i++) {
        $('#contenedordecorreosfacturasTAE').append('<div class="col-xs-12 formCorreosTAE"><input type="text" id="camposCorreosTAE" class="form-control m-bot15 lecturaCorreosComision" name="correosFacturasTAE" value="' + correosenvfacturasTAE[i] + '" style="width: 270px; display:inline-block;" disabled><button  class="remove_button lecturaCorreosNotificaciones btn btn-sm inhabilitar" id="removeCorreosTAE" style="margin-left:3px" value="' + correosenvfacturasTAE[i] + '" onclick="removercorreoFacturasTAE(this.value);"> <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    }
    if (correosenvfacturasTAE.length < 50) {
        $('#nuevocorreofacturasTAE').attr('disabled', false);
        $('#nuevocorreofacturasTAE').val('');
    }
}

/**
 * Valida si el calendario no tiene mas de 7 check activos en total
 * @param {*} clase - Comision, cobro o operaciones
 */
function validarCalendario(clase) {
    if (contarCheckCalendario(clase) > 7) {
        jAlert("El valor de dias no puede ser mayor a 7");
        $('.Lu_Check_'+clase+':checkbox:checked').attr('checked', false);
        $('.Ma_Check_'+clase+':checkbox:checked').attr('checked', false);
        $('.Mi_Check_'+clase+':checkbox:checked').attr('checked', false);
        $('.Ju_Check_'+clase+':checkbox:checked').attr('checked', false);
        $('.Vi_Check_'+clase+':checkbox:checked').attr('checked', false);
    }
}

/**
 * Cuenta la cantidad de check activos que tiene el calendario especifico
 * @param {*} clase - Comision, cobro o operaciones
 * @returns {Number}
 */
function contarCheckCalendario(clase) {
    var lunes_long = $('.Lu_Check_'+clase+':checkbox:checked').length;
    var martes_long = $('.Ma_Check_'+clase+':checkbox:checked').length;
    var miercoles_long = $('.Mi_Check_'+clase+':checkbox:checked').length;
    var jueves_long = $('.Ju_Check_'+clase+':checkbox:checked').length;
    var viernes_long = $('.Vi_Check_'+clase+':checkbox:checked').length;

    return parseInt(lunes_long) + parseInt(martes_long) + parseInt(miercoles_long) + parseInt(jueves_long) + parseInt(viernes_long);
}

/**
 * Valida que el valor ingresado cumple con el minimo y el maximo configurado en el input
 * @param {*} id 
 */
function validarMinMax(id) {
    var max = parseInt($("#" + id).attr('max'));
    var min = parseInt($("#" + id).attr('min'));
    if ($("#" + id).val() > max) {
        $("#" + id).val(max);
    } else if ($("#" + id).val() < min) {
        $("#" + id).val(min);
    }
}

/**
 * Valida la clabe que sea ingresada en el input
 * Si es correcta manda a llamar los datos respectivos del banco
 */
function analizarCLABE(valTipo = null) {
    var CLABE = (valTipo != null) ? valTipo : event.target.value;
    
    if (CLABE.length == 18) {
        var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
        if (CLABE_EsCorrecta) {
            $("#txtCLABE").addClass("loading-input");
            $.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE }).done(function(data) {
                var banco = jQuery.parseJSON(data);
                var beneficiario = (
                    $("#p_razonSocial").val() == "" ? 
                    (nombre + " " + paterno + " " + materno) :
                    $("#p_razonSocial").val());

                $("#cmbBancoPago").val(banco.bancoID);
                $("#txtBanco").val(banco.nombreBanco);
                $("#txtBeneficiario").val(beneficiario);
                $("#txtCLABE").removeClass("loading-input");
                $("#txtCuenta").val(CLABE.substring(6,17));
            });
        } else {
            jAlert("La CLABE escrita es incorrecta. Favor de verificarla.");
            $("#txtCLABE").removeClass("loading-input");
            $("#cmbBancoPago").val("-1");
            $("#txtBanco").val("");
            $("#txtCuenta").val("");
        }
    } else {
        $("#txtCLABE").removeClass("loading-input");
        $("#cmbBancoPago").val("-1");
        $("#txtBanco").val("");
        $("#txtCuenta").val("");
    }
}

/**
 * Habilita todas las tabs del formulario
 */
function habilitarTabs() {
    for (let i=1; i<8; i++) {
        $("#li_paso"+i).removeClass("disabled");
        $("#li_paso"+i+" a").attr('data-toggle', 'tab');
    }
}

/**
 * Desabilita las tabs del formulario
 * @param {*} tabNoIncluir - Si no se desea desabilitar
 */
function desabilitarTabs(tabNoIncluir) {
    for (let i=0; i<8; i++) {
        if (i == tabNoIncluir) {
            continue;
        }
        $("#li_paso"+i).addClass("disabled");
    }
}

/**
 * No cumple permisos todos los campos se inhabilitan - Unicamente vista
 */
function desabilitarInputs(apartado, general) {
    if(general) apartado = 1;
    switch (apartado) {
        case 1://tipo cliente
            // Apartado de clientes
            $("input[name=nIdTipoAcceso]").prop("disabled", true);
            $("input[name=nIdFamilia]").prop("disabled", true);
            $("#cmbSolicitante").prop("disabled", true);
            $("#checkFisicaGeneral").prop("disabled", true);
            $("#checkIntegrador").prop("disabled", true);
            $("#cmbticket").prop("disabled", true);
            $("#txtSCadena").prop("disabled", true);
            $("#cmbforelo").prop("disabled", true);
            $("#cmbReqFacTAE").prop("disabled", true);
            $("#checkModPruebas").prop("disabled", true);
            $("#checkModProduccion").prop("disabled", true);
            $("#fecProduccion").prop("disabled", true);
            $("#fecPruebas").prop("disabled", true);
            if(!general) {
                break
            } else {
                apartado = 3;
            }
        case 3://Repr. legal y Contrato
            // Apartado replegal y contrato
            $("#sNombreReplegal").prop("disabled", true);
            $("#sPaternoReplegal").prop("disabled", true);
            $("#sMaternoReplegal").prop("disabled", true);
            $("#cmbIdentificacion").prop("disabled", true);
            $("#numeroIdentificacion").prop("disabled", true);
            $("#fecContrato").prop("disabled", true);
            $("#fecRenovarContrato").prop("disabled", true);
            $("#checkVigencia").prop("disabled", true);
            $("#txtNumVigencia").prop("disabled", true);
            $("#fecRevisionCondicion").prop("disabled", true);
            if(!general) {
                break
            } else {
                apartado = 4;
            }
        case 4://Docs.
            // Docs
            $("#acta_constitutiva").prop("disabled", true);
            $("#documento_rfc").prop("disabled", true);
            $("#txtFile").prop("disabled", true);
            $("#poder_legal").prop("disabled", true);
            $("#id_representante_legal").prop("disabled", true);
            $("#contrato").prop("disabled", true);
            $("#adendo1").prop("disabled", true);
            $("#adendo2").prop("disabled", true);
            $("#adendo3").prop("disabled", true);
            $("#id_identificacion_fisica").prop("disabled", true);
            $("#ctabancaria").prop("disabled", true);
            $("#actPrepSat").prop("disabled", true);
            if(!general) {
                break
            } else {
                apartado = 5;
            }
        case 5://Liquidación
            // Liquidacion
            $("input[name=tipoLiqRecaudo]").prop("disabled", true)
            $("#montoLimiteCredito").prop("disabled", true);
            $("#cmbTipoLiquidacionOperaciones").prop("disabled", true);
            $("#tnDiasOperaciones").prop("disabled", true);
            $(".Lu_Check_Recaudo").prop("disabled", true);
            $(".Ma_Check_Recaudo").prop("disabled", true);
            $(".Mi_Check_Recaudo").prop("disabled", true);
            $(".Ju_Check_Recaudo").prop("disabled", true);
            $(".Vi_Check_Recaudo").prop("disabled", true);
            $("#cmbSemanalDiaOperaciones").prop("disabled", true);
            $("#semanalAtrasOperaciones").prop("disabled", true);
            $("#cmbCostoTransferencia").prop("disabled", true);
            $("#nMontoTransferencia").prop("disabled", true);
            $("#checkDescFDM").prop("disabled", true);
            $("#checkDescGD").prop("disabled", true);
            $("#checkTicketResp").prop("disabled", true);
            $("#cmb_valida_monto").prop("disabled", true);
            $("#cmbComisionIntegrador").prop("disabled", true);
            $("#nMontoIntegrador").prop("disabled", true);
            $("#cmbRetieneComision").prop("disabled", true);
            $("#cmbPeriodoPagoCom").prop("disabled", true);
            $("#cmbPeriodoPrepPagoCom").prop("disabled", true);
            $("#tnDiasPago").prop("disabled", true);
            $(".Lu_Check_Pago, .Ma_Check_Recaudo").prop("disabled", true);
            $("#cmbSemanalDiaPago").prop("disabled", true);
            $("#semanalAtrasPago").prop("disabled", true);
            $("#nuevocorreonotificaciones").prop("disabled", true);
            $("#txtCLABE").prop("disabled", true);
            $("#txtsSwift").prop("disabled", true);
            $("#txtABA").prop("disabled", true);
            $("#cmbPaisPago").prop("disabled", true);
            $("#cmbMonedaExt").prop("disabled", true);
            $(".Lu_Check_Pago").prop("disabled", true);
            $(".Ma_Check_Pago").prop("disabled", true);
            $(".Mi_Check_Pago").prop("disabled", true);
            $(".Ju_Check_Pago").prop("disabled", true);
            $(".Vi_Check_Pago").prop("disabled", true);
            $("#btnCorreoNotificaciones").prop("disabled", true);
            $(".remove_button").prop("disabled", true);
            $("#cmbPeriodoCobroCom").prop("disabled", true);
            $("#cmbCuentaRED").prop("disabled", true);
            $("#tnDiasCobro").prop("disabled", true);
            $("#cmbSemanalDiaCobro").prop("disabled", true);
            $("#semanalAtrasCobro").prop("disabled", true);
            $("#cmbCuentaRED").prop("disabled", true);
            $(".Lu_Check_Cobro").prop("disabled", true);
            $(".Ma_Check_Cobro").prop("disabled", true);
            $(".Mi_Check_Cobro").prop("disabled", true);
            $(".Ju_Check_Cobro").prop("disabled", true);
            $(".Vi_Check_Cobro").prop("disabled", true);
            if(!general) {
                break
            } else {
                apartado = 6;
            }
        case 6://Facturación
            // Facturacion
            $("#cmbCFDIComision").prop("disabled", true);
            $("#cmbFormaPagoComision").prop("disabled", true);
            $("#cmbMetodoPagoComision").prop("disabled", true);
            $("#cmbProductoServicioComision").prop("disabled", true);
            $("#cmbClaveUnidadComision").prop("disabled", true);
            $("#periocidadComision").prop("disabled", true);
            $("#diasLiquidacionComision").prop("disabled", true);
            $("#nuevocorreofacturasComision").prop("disabled", true);
            $("#btnCorreoFacturasComision").prop("disabled", true);
            $("#cmbCFDITAE").prop("disabled", true);
            $("#cmbFormaPagoTAE").prop("disabled", true);
            $("#cmbMetodoPagoTAE").prop("disabled", true);
            $("#cmbProductoServicioTAE").prop("disabled", true);
            $("#cmbClaveUnidadTAE").prop("disabled", true);
            $("#periocidadTAE").prop("disabled", true);
            $("#diasLiquidacionTAE").prop("disabled", true);
            $("#nuevocorreofacturasTAE").prop("disabled", true);
            $("#btnCorreoFacturasTAE").prop("disabled", true);
            $("#cmbIVAComision").prop("disabled", true);
            $("#nRetieneIVA").prop("disabled", true);
            $("#nRetieneISR").prop("disabled", true);
            if(!general) {
                break
            } else {
                apartado = 7;
            }
        case 7://Ctas. Cntbles
            if(!general) {
                break
            } else {
                apartado = 8;
            }
    }

}

$("#cmbIdentificacion").on('change', function() {
    // $("#numeroIdentificacion").alphanum('destroy');

    tipoEntraDaNoIdentificacion();
});

function tipoEntraDaNoIdentificacion(){
    let valor = $("#cmbIdentificacion").val();
    let input = $("#numeroIdentificacion");

    input.off("input"); // Desvincula el manejador de eventos de entrada actual

    if(valor == 1) {
        console.log('1');
        input.on("input", function() {
            // Validación para permitir hasta 13 caracteres sin caracteres latinos ni otros conjuntos
            var inputValue = $(this).val();
            if (inputValue.length > 13) {
                inputValue = inputValue.substring(0, 13);
            }
            $(this).val(inputValue.replace(/[^0-9]/g, ''));
        });
    }
    if(valor == 2) {
        console.log('2');
        input.on("input", function() {
            // Validación para permitir hasta 10 caracteres sin caracteres latinos ni otros conjuntos
            var inputValue = $(this).val();
            if (inputValue.length > 10) {
                inputValue = inputValue.substring(0, 10);
            }
            $(this).val(inputValue.replace(/[^0-9]/g, ''));
        });
    }
    if(valor == 3) {
        console.log('3');
        input.on("input", function() {
            // Validación para permitir hasta 11 caracteres con caracteres latinos
            var inputValue = $(this).val();
            if (inputValue.length > 11) {
                inputValue = inputValue.substring(0, 11);
            }
            $(this).val(inputValue.replace(/[^a-zA-Z0-9]/g, ''));
        });
    }
    if(valor == 4) {
        console.log('4');
        input.on("input", function() {
            // Validación para permitir hasta 8 caracteres con caracteres latinos
            var inputValue = $(this).val();
            if (inputValue.length > 8) {
                inputValue = inputValue.substring(0, 8);
            }
            $(this).val(inputValue.replace(/[^0-9]/g, ''));
        });
    }
}