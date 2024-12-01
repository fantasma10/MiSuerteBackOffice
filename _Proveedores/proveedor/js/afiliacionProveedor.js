// JQuery.Inputmask example.

const valoresPeriodo = Object.freeze({
    0: 'Lu_Check',
    1: 'Ma_Check',
    2: 'Mi_Check',
    3: 'Ju_Check',
    4: 'Vi_Check'
})

var customInputmask = (function () {
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

    var init = function () {
        Inputmask.extendDefaults(config.extendDefaults);
        Inputmask.extendDefinitions(config.extendDefinitions);
        Inputmask.extendAliases(config.extendAliases);
        $('[data-inputmask]').inputmask();
    };

    return {
        init: init
    };
}());

var seccionesGlobal = {
    bRevision: 0
};
var enviarCorreoRevision = false;
const btnActualizar = {
    textBefore: 'Actualizando...',
    textSuccess: 'Actualizar',
    textFail: 'Actualizar'
};

const btnGuardar = {
    textBefore: 'Guardando...',
    textSuccess: 'Actualizar',
    textFail: 'Guardar'
};

const btnActualizarBanco = {
    textBefore: 'Actualizando...',
    textSuccess: 'Actualizar',
    textFail: 'Actualizar'
};

const btnGuardarBanco = {
    textBefore: 'Guardando...',
    textSuccess: 'Actualizar',
    textFail: 'Guardar'
};

const btnEliminar = {
    textBefore: 'Actualizar',
    textSuccess: 'Actualizar',
    textFail: 'Guardar'
};

function initViewAltaProveedor() {
    var Layout = {
        inicializatxt: function () {

            $("#rfc").alphanum({
                allow: '-',
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 12
            });
            $("#rfc").attr('style', 'text-transform: uppercase;');

            $("#clabeXZona_0").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: false,
                allowLeadingSpaces: false,
                maxDigits: 18
            });

            $("#nombreComercial, #code").alphanum({
                allow: '-.,',
                allowNumeric: true,
                allowOtherCharSets: true,
                maxLength: 50
            });
            $("#code").alphanum({
                allow: '-.,',
                allowNumeric: true,
                allowOtherCharSets: true,
                maxLength: 50,
                allowSpace: false
            });
            $("#razonSocial").alphanum({
                allow: '-.,',
                allowNumeric: true,
                allowOtherCharSets: true,
                maxLength: 50
            });
            $("#txtColonia, #txtCiudad, #txtEstado").alphanum({
                allow: '-.,',
                allowNumeric: false,
                maxLength: 50
            });
            $('#regimenSocietario').alphanum({
                allow: '-.,',
                maxLength: 200
            });
            $("#sku").alphanum({
                allow: '-',
                allowNumeric: true,
                allowOtherCharSets: true,
                maxLength: 25
            });
            $("#txtCalle").alphanum({
                allow: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 100
            });
            $("#ext, #int").alphanum({
                allow: '-',
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 10
            });
            $("#port").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: false,
                allowLeadingSpaces: false,
                maxDigits: 10
            });
            $("#txtCP").alphanum({
                allow: '-',
                allowLatin: false, // a-z A-Z
                allowOtherCharSets: false,
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 5
            });
            $("#representante_legal").alphanum({
                allow: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
                allowNumeric: false,
                allowOtherCharSets: false,
                maxLength: 100
            });
            $("#diasLiquidacionComision, #diasLiquidacionTransferencia, #tiempo_liquidacion, #diasLiquidacionPubGral").numeric({
                maxDigits: 2,
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: false
            });
            $("#numeroIdentificacion").alphanum({
                maxLength: 30
            });
            $("#cuentaBanco").alphanum({
                maxLength: 20
            });
            $("#comision, #porcentajeComision, #txtcostotrans, #txtCantTrans, #txtcostocom, #txtcargoserv").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: true,
                allowLeadingSpaces: false
            });
            $("#cuenta_contable_iva_translado_por_cobrar, #cuenta_contable_iva_acreditable_por_pagar, #cuenta_contable_ingresos, #cuenta_contable_costos, #cuenta_contable_proveedor, #cuenta_contable_banco, #cuenta_contable_cliente").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: false,
                allowLeadingSpaces: false
            });
            $("#tiempo_timeout").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: true,
                allowLeadingSpaces: false
            });
            $("#especial_dias").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: false,
                allowLeadingSpaces: false
            });
            $("#telefono_0").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: true,
                allowLeadingSpaces: false
            });
            $("#producto_descripcion").alphanum({
                allowNumeric: true,
                allowOtherCharSets: false,
                allowPlus: false,
                maxLength: 45
            });
            $("#producto_abreviatura").alphanum({
                allowNumeric: true,
                allowOtherCharSets: false,
                allowPlus: false,
                maxLength: 45
            });
            $("#importe_minimo_producto, #importe_maximo_producto,#porcentaje_comision_producto,#importe_comision_producto,#porcentaje_comision_corresponsal,#importe_comision_corresponsal,#porcentaje_comision_cliente,#importe_comision_cliente").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: true,
                allowLeadingSpaces: false
            });
            $("#tn_dias, #dias_credito").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: false,
                allowLeadingSpaces: false,
                maxDigits: 3
            });
            $("#importe_0, #descuento_0, #importesindescuento_0,#importesiniva_0").numeric({
                allowPlus: false,
                allowMinus: false,
                allowThouSep: false,
                allowDecSep: true,
                allowLeadingSpaces: false,
                maxDigits: 10
            });
            $("#swift,#iban").alphanum({
                allow: '-',
                allowNumeric: true,
                allowOtherCharSets: false,
                maxLength: 30,
                allowSpace: false
            });
            $("#swift,#iban").attr('style', 'text-transform: uppercase;');

        },
        definePais: function () {
            //para poner por default méxico
            $("#cmbpais").val("164");
        },
        getServicios: function (valor) {
            $.post("../ajax/servicios.php", { servicios: ['UsoCFDI', 'FormaPago', 'MetodoPago', 'ProductoServicio', 'Unidad', 'CatRegimenFiscal'] },
                function (response) {
                    const { FormaPago, MetodoPago, ProductoServicio, RegimenFiscal, Unidad, UsoCFDI } = JSON.parse(response);

                    const cmbCfdiComision = "#cmbCFDIComision";
                    const cmbCfdiTransferencia = "#cmbCFDITransferencia";
                    $(cmbCfdiComision).empty();
                    $(cmbCfdiTransferencia).empty();
                    jQuery.each(UsoCFDI, function (idx, cfdi) {
                        $(cmbCfdiComision).append(`<option ${(cfdi.strUsoCFDI == 'G03') ? 'selected' : ''} value="${cfdi.strUsoCFDI}">${cfdi.strUsoCFDI} ${cfdi.strDescripcion}</option>`);
                        $(cmbCfdiTransferencia).append(`<option ${(cfdi.strUsoCFDI == 'G03') ? 'selected' : ''} value="${cfdi.strUsoCFDI}">${cfdi.strUsoCFDI} ${cfdi.strDescripcion}</option>`);
                    });

                    const cmbFormaPagoComision = "#cmbFormaPagoComision";
                    const cmbFormaPagoTransferencia = "#cmbFormaPagoTransferencia";
                    $(cmbFormaPagoComision).empty();
                    $(cmbFormaPagoTransferencia).empty();
                    jQuery.each(FormaPago, function (idx, pago) {
                        $(cmbFormaPagoComision).append(`<option value="${pago.strFormaPago}">${pago.strFormaPago} ${pago.strDescripcion}</option>`);
                        $(cmbFormaPagoTransferencia).append(`<option value="${pago.strFormaPago}">${pago.strFormaPago} ${pago.strDescripcion}</option>`);
                    });

                    const cmbMetodoPagoComision = "#cmbMetodoPagoComision";
                    const cmbMetodoPagoTransferencia = "#cmbMetodoPagoTransferencia";
                    $(cmbMetodoPagoComision).empty();
                    $(cmbMetodoPagoTransferencia).empty();
                    jQuery.each(MetodoPago, function (idx, metodo) {
                        $(cmbMetodoPagoComision).append(`<option value="${metodo.strMetodoPago}">${metodo.strMetodoPago} ${metodo.strDescripcion}</option>`);
                        $(cmbMetodoPagoTransferencia).append(`<option value="${metodo.strMetodoPago}">${metodo.strMetodoPago} ${metodo.strDescripcion}</option>`);
                    });

                    const cmbProductoServicioComision = "#cmbProductoServicioComision";
                    const cmbProductoServicioTransferencia = "#cmbProductoServicioTransferencia";
                    $(cmbProductoServicioComision).empty();
                    $(cmbProductoServicioTransferencia).empty();
                    jQuery.each(ProductoServicio, function (idx, producto) {
                        $(cmbProductoServicioComision).append(`<option ${(producto.strClaveProducto == '80141628') ? 'selected' : ''} value="${producto.strClaveProducto}">${producto.strClaveProducto} ${producto.strDescripcion}</option>`);
                        $(cmbProductoServicioTransferencia).append(`<option ${(producto.strClaveProducto == '80141628') ? 'selected' : ''} value="${producto.strClaveProducto}">${producto.strClaveProducto} ${producto.strDescripcion}</option>`);
                    });

                    const cmbClaveUnidadComision = "#cmbClaveUnidadComision";
                    const cmbClaveUnidadTransferencia = "#cmbClaveUnidadTransferencia";
                    $(cmbClaveUnidadComision).empty();
                    $(cmbClaveUnidadTransferencia).empty();
                    jQuery.each(Unidad, function (index, unidad) {
                        $(cmbClaveUnidadComision).append(`<option ${(unidad.strUnidad == 'ACT') ? 'selected' : ''} value="${unidad.strUnidad}">${unidad.strUnidad} ${unidad.strDescripcion}</option>`);
                        $(cmbClaveUnidadTransferencia).append(`<option ${(unidad.strUnidad == 'ACT') ? 'selected' : ''} value="${unidad.strUnidad}">${unidad.strUnidad} ${unidad.strDescripcion}</option>`);
                    });

                    const cmbRegimenFiscal = "#cmbRegimenFiscal";
                    $(cmbRegimenFiscal).empty();
                    $(cmbRegimenFiscal).append('<option value="-1">Seleccione</option>');
                    jQuery.each(RegimenFiscal, function (index, regimen) {
                        $(cmbRegimenFiscal).append(`<option value="${regimen.strRegimenFiscal}">${regimen.strDescripcion}</option>`);
                    });


                    checaparametro();
                }
            ).fail(function (resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); });
        },
        initCombos: function () {
            $('#cmbpais').on("change", function (e) { //para el caso de proveedores extranjeros
                idpais = $('#cmbpais').val();
                $('#rfc').val('');
                $("#rfc").attr("readonly", false);
                $("#rfc").removeClass("readOnly");
                $("#rfc").attr('disabled', false);
                if (idpais == 164) {
                    $('#div-rfc label').html('RFC');
                    $('#divDirnac').css('display', 'block');
                    $('#divDirext').css('display', 'none');
                    $('#rfc').unmask();
                    $('#txtCP').attr('maxlength', 5);
                } else {
                    $('#div-rfc label').html('Id Oficial');
                    $('#divDirnac').css('display', 'none');
                    $('#divDirext').css('display', 'block');
                    $('#rfc').prop('maxlength', 13);
                    $('#telefono').unmask();
                    $('#txtCP').attr('maxlength', 13);
                }
            });
            $("#dias_liquidacion").on("change", function (e) {
                dias_liquidacion = $("#dias_liquidacion").val();
                if (dias_liquidacion == 1) { //T+ndias
                    $("#divTndias").css("display", "block");
                    $("#divporperiodos").css("display", "none");
                    $("#divEspecial").css('display', 'none');
                    $("#div_tiempo_liquidacion").css('display', 'none');
                }
                if (dias_liquidacion == 2) { //por periodo
                    $("#divTndias").css("display", "none");
                    $("#divporperiodos").css("display", "block");
                    $("#divEspecial").css('display', 'none');
                    $("#div_tiempo_liquidacion").css('display', 'none');
                }
                if (dias_liquidacion == 3) { //prepago
                    $("#divporperiodos").css("display", "none");
                    $("#divTndias").css("display", "none");
                    $("#divEspecial").css('display', 'none');
                    $("#div_tiempo_liquidacion").css('display', 'none');
                    $("#tiempo_liquidacion").val(0);
                }
                if (dias_liquidacion == 4) {
                    $("#divEspecial").css('display', 'block');
                    $("#divTndias").css('display', 'none');
                    $("#divporperiodos").css('display', 'none');
                    $("#div_tiempo_liquidacion").css('display', 'none');
                }
                if (dias_liquidacion == -1) {
                    $("#divTndias").css('display', 'none');
                    $("#divporperiodos").css('display', 'none');
                    $("#divEspecial").css('display', 'none');
                    $("#div_tiempo_liquidacion").css('display', 'none');
                }

            });

            //caso para el tipo proveedor pago con tarjeta
            // $("#dias_liquidacion_ppt").on("change", function(e) {
            //     dias_liquidacion_ppt = $("#dias_liquidacion_ppt").val();
            //     if (dias_liquidacion_ppt == 1) { //T+ndias
            //         $("#divTndias_ppt").css("display", "block");
            //         $("#divporperiodos_ppt").css("display", "none");
            //         $("#divEspecial_ppt").css('display', 'none');
            //         $("#div_tiempo_liquidacion").css('display', 'none');
            //     }
            //     if (dias_liquidacion_ppt == 2) { //por periodo
            //         $("#divTndias_ppt").css("display", "none");
            //         $("#divporperiodos_ppt").css("display", "block");
            //         $("#divEspecial_ppt").css('display', 'none');
            //         $("#div_tiempo_liquidacion").css('display', 'none');
            //     }
            //     if (dias_liquidacion_ppt == 3) { //prepago
            //         $("#divporperiodos_ppt").css("display", "none");
            //         $("#divTndias_ppt").css("display", "none");
            //         $("#divEspecial_ppt").css('display', 'none');
            //         $("#div_tiempo_liquidacion").css('display', 'none');
            //         $("#tiempo_liquidacion").val(0);
            //     }
            //     if (dias_liquidacion_ppt == 4) {
            //         $("#divEspecial_ppt").css('display', 'block');
            //         $("#divTndias_ppt").css('display', 'none');
            //         $("#divporperiodos_ppt").css('display', 'none');
            //         $("#div_tiempo_liquidacion").css('display', 'none');
            //     }
            //     if (dias_liquidacion_ppt == -1) {
            //         $("#divTndias_ppt").css('display', 'none');
            //         $("#divporperiodos_ppt").css('display', 'none');
            //         $("#divEspecial_ppt").css('display', 'none');
            //         $("#div_tiempo_liquidacion").css('display', 'none');
            //     }

            // });
        },
        esconderDivsFacturacion: function () {
            $("#contenidoFacturaComision").hide();
            $("#contenidoFacturaTransferencia").hide();
        },
        // buscaFamilia: function () {
        //     $("#familiaccp_0").empty();
        //     $.post("../ajax/altaProveedores.php", { tipo: 1 },
        //         function (response) {
        //             async: false;
        //             var obj = jQuery.parseJSON(response);
        //             $('#familiaccp_0').append('<option value="0">Seleccione</option>');
        //             if (obj !== null) {
        //                 jQuery.each(obj, function (index, value) {
        //                     var nombre_familia = obj[index]['descFamilia'];
        //                     $('#familiaccp_0').append('<option value="' + obj[index]['idFamilia'] + '">' + nombre_familia + '</option>');
        //                 });
        //             }
        //         }
        //     ).fail(function (resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        // },
        // buscaCadenas: function () {
        //     $("#select_comercio_0").empty();
        //     var lista = "";
        //     $.post("../ajax/altaProveedores.php", { tipo: 19 },
        //         function (response) {
        //             async: false;
        //             var obj = jQuery.parseJSON(response);
        //             $('#select_comercio_0').append('<option value="0">Seleccione</option>');
        //             if (obj !== null) {
        //                 jQuery.each(obj, function (index, value) {
        //                     var nombre_cadena = obj[index]['nombreCadena'];
        //                     lista += '<option value="' + obj[index]['idCadena'] + '">' + nombre_cadena + '</option>';
        //                 });
        //                 $("#select_comercio_0").html(lista).selectpicker('refresh');;
        //             }
        //         }
        //     ).fail(function (resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        // },
        buscaZonas: function () {
            $("#select_zonas_0").empty();
            var lista = "";
            $.post("../ajax/altaProveedores.php", { tipo: 29 },
                function (response) {
                    async: false;
                    var obj = jQuery.parseJSON(response);
                    lista += '<option value="0">Seleccione</option>';
                    if (obj !== null) {
                        jQuery.each(obj, function (index, value) {
                            var nombre_entidad = obj[index]['sEntidad'];
                            lista += '<option value="' + obj[index]['nIdEntidad'] + '">' + nombre_entidad + '</option>';
                        });
                        $("#select_zonas_0").html(lista).selectpicker('refresh');
                    }
                }
            ).fail(function (resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },
        cargarGiro: function () {
            $("#cmbGiro").empty();
            $.post("../ajax/altaProveedores.php", { tipo: 54 },
                function (response) {
                    async: false;
                    let obj = jQuery.parseJSON(response);
                    const { giros } = obj;
                    const cmbGiro = "#cmbGiro";
                    $(cmbGiro).empty();
                    $(cmbGiro).append('<option value="-1">Seleccione</option>');
                    jQuery.each(giros, function (index, giro) {
                        if (giro.idGiro !== null && giro.nombreGiro !== null) {
                            const option = `<option value="${giro.idGiro}" title="${giro.descGiro}">${giro.nombreGiro} - ${cortarTexto(giro.descGiro, 100)}</option>`;
                            $(cmbGiro).append(option);
                        }
                    });
                }
            ).fail(function (resp) { alert('Ha ocurrido un error, intente de nuevo más tarde'); })
        },
        
    }
    Layout.inicializatxt();
    Layout.definePais();
    Layout.getServicios();
    Layout.buscaZonas();
    Layout.cargarGiro();
    Layout.initCombos();
    Layout.esconderDivsFacturacion();
    // Layout.buscaFamilia();
    initInputFiles();
    usuariosComerciales();
    // checaparametro();
    // Layout.buscaCadenas();
    customInputmask.init();
    $('#closepdf').click(function () { $('#pdfvisor').css('display', 'none') });
    $("#cuentaccin_0").inputmask("9-9-99-9999-999");
    $("#cuentacccos_0").inputmask("9-9-99-9999-999");

    setTimeout(function () {

        $("#cuenta_contable_ingresos").inputmask("9-9-99-9999-999");
        $("#cuenta_contable_costos").inputmask("9-9-99-9999-999");
        $("#cuenta_contable_proveedor").inputmask("9-9-99-9999-999");
        $("#cuenta_contable_banco").inputmask("9-9-99-9999-999");
        $("#cuenta_contable_cliente").inputmask("9-9-99-9999-999");
        $("#cuenta_contable_iva_translado_por_cobrar").inputmask("9-9-99-9999-999");
        $("#cuenta_contable_iva_acreditable_por_pagar").inputmask("9-9-99-9999-999");
        // $("#clabeXZona_0").inputmask("9-9-99-9999-999");

    }, 1500);


    // var cc_cliente = document.getElementById("cuenta_contable_cliente");
    // var im_cliente = new Inputmask("9-9-99-9999-999");
    // im_cliente.mask(cc_cliente);


    // var cc_iva_traslado = document.getElementById("cuenta_contable_iva_translado_por_cobrar");
    // var im_iva_traslado = new Inputmask("9-9-99-9999-999");
    // im_iva_traslado.mask(cc_iva_traslado);

    // var cc_iva_acreditable = document.getElementById("cuenta_contable_iva_acreditable_por_pagar");
    // var im_iva_acreditable = new Inputmask("9-9-99-9999-999");
    // im_iva_acreditable.mask(cc_iva_acreditable);

    $("#beneficiario_DB").addClass("disabledbutton");
    $("#referenciaAlfa").addClass("disabledbutton");
    $("#beneficiario_DBred").addClass("disabledbutton");
}

function cortarTexto(cadena, longitudMaxima) {
    if (cadena !== null && cadena.length > longitudMaxima) {
        return cadena.substring(0, longitudMaxima) + '...';
    } else {
        return cadena;
    }
}

function Clonar() {
    let razonSocial = $("#razonSocial").val();
    let regimenSocietario = $("#regimenSocietario").val();
    let beneficiarioDB = `${razonSocial} ${regimenSocietario}`;
    $("#beneficiario_DB").val(beneficiarioDB);
}

function Clonar2() {
    $("#beneficiario_DBred").val("Red Efectiva");
}

function revision(seccion) {
    if (Object.keys(seccionesGlobal).length > 0) {
        let total = Number(seccionesGlobal.bSeccion1) + Number(seccionesGlobal.bSeccion2) + Number(seccionesGlobal.bSeccion3) +
            Number(seccionesGlobal.bSeccion4) + Number(seccionesGlobal.bSeccion5) + Number(seccionesGlobal.bSeccion6) + Number(seccionesGlobal.bSeccion7);

        let texto = 'Guardar y Revisar';
        if (total == 5) {
            if ((seccion == 'repr-datos') && seccionesGlobal.bSeccion2 == 0) {
                $(`#btn-${seccion}`).html(texto);
                enviarCorreoRevision = true;
            }
            if ((seccion == 'documentos') && seccionesGlobal.bSeccion3 == 0) {
                $(`#btn-${seccion}`).html(texto);
                enviarCorreoRevision = true;
            }
            if ((seccion == 'liquidacion') && seccionesGlobal.bSeccion4 == 0) {
                $(`#btn-${seccion}`).html(texto);
                enviarCorreoRevision = true;
            }
            if ((seccion == 'facturacion') && seccionesGlobal.bSeccion5 == 0) {
                $(`#btn-${seccion}`).html(texto);
                enviarCorreoRevision = true;
            }
            // if ((seccion == 'cuenta') && seccionesGlobal.bSeccion6 == 0) {
            //     $(`#btn-${seccion}`).html(texto);
            //     enviarCorreoRevision = true;
            // }
            if ((seccion == 'matriz-escalamiento') && seccionesGlobal.bSeccion7 == 0) {
                $(`#btn-${seccion}`).html(texto);
                enviarCorreoRevision = true;
            }
        }
    }
}

const esObligatorio = value => ((value === '') || (value === '-1') || (value === null)) ? false : true;
// const esCeros = value => ((value === '0') || (value === '0.00')) ? false : true;
// const isBetween = (length, min, max) => length < min || length > max ? false : true;

const showError = (input, mensaje, isInput = true) => {
    let formField = null;
    let error = null;

    if (isInput) {
        formField = input.parent();
        error = input.siblings('small');
    } else {
        formField = input;
        error = input;
    }

    formField.removeClass('success');
    formField.addClass('error');

    error.text(mensaje);
};

const showSuccess = (input, isInput = true) => {
    let formField = null;
    let error = null;
    if (isInput) {
        formField = input.parent();
        error = input.siblings('small');
    } else {
        formField = input;
        error = input;
    }

    formField.removeClass('error');
    formField.addClass('success');

    error.text('');
}

const validarCampo = (input, type) => {
    let valido = false;

    let valor = input.val();
    valor = valor ? valor.trim() : valor;

    if (!esObligatorio(valor)) {
        showError(input, 'El campo es requerido.', true);
    } else {
        showSuccess(input, true);
        valido = true;
    }

    return valido;
};

function setTipoRetencion() {
    var tipo = $("#pago_liquidacion option:selected").val();

    if (tipo == 1) {
        $("#retencion option[value='" + tipo + "']").prop('selected', true);
    }
    if (tipo == 2) {
        $("#retencion option[value='" + tipo + "']").prop('selected', true);
    }
}

function deshabilitarcampos() {
    $('input[type="text"]').prop("readonly", true);
    $("#cmbpais").prop("disabled", true);
    $("#cmbColonia").prop("disabled", true);
    $("#cmbCiudad").prop("disabled", true);
    $("#cmbEntidad").prop("disabled", true);
    $("#cmbIdentificacion").prop("disabled", true);
    $("#select_familia").prop("disabled", true);
    $("#select_subfamilia").prop("disabled", true);
    $("#select_productos").prop("disabled", true);
    $("#pagan_comisiones").prop("disabled", true);
    $("#cobran_comision").prop("disabled", true);
    $("#pago_liquidacion").prop("disabled", true);
    $("#dias_liquidacion").prop("disabled", true);
    $("#especial_select_dias").prop("disabled", true);
    $("#retencion").prop("disabled", true);
    $("#iva_comision").prop("disabled", true);
    $("#iva_cargo").prop("disabled", true);
    $("#ivaFactura").prop("disabled", true);
    $("#cmbCFDIComision").prop("disabled", true);
    $("#cmbFormaPagoComision").prop("disabled", true);
    $("#cmbMetodoPagoComision").prop("disabled", true);
    $("#cmbProductoServicioComision").prop("disabled", true);
    $("#cmbClaveUnidadComision").prop("disabled", true);
    $("#periocidadComision").prop("disabled", true);
    $("#cmbCFDITransferencia").prop("disabled", true);
    $("#cmbFormaPagoTransferencia").prop("disabled", true);
    $("#cmbMetodoPagoTransferencia").prop("disabled", true);
    $("#cmbProductoServicioTransferencia").prop("disabled", true);
    $("#cmbClaveUnidadTransferencia").prop("disabled", true);
    $("#periocidadTransferencia").prop("disabled", true);
    $("#select_vpn").prop("disabled", true);
    $("#select_vpnDesPrue").prop("disabled", true);
    $("#cbnotif").prop("disabled", true);
    $("#ctetipo").prop('disabled', true);
    $("#ctetipo3").prop('disabled', true);
    $("#btnAgregarProducto").prop('disabled', true);


    $("#cmbCFDIPubGral").prop("disabled", true);
    // $("#radio_importe").prop('disabled',true);
    // $("#radio_porcentaje").prop('disabled',true);
    $("#monto_transferencia").prop('disabled', true);
    $("#comision_usuario").prop('disabled', true);
    $("#cargo_usuario").prop('disabled', true);
    $("#genera_factura_comision").prop('disabled', true);
    $("#genera_factura_comision_transferencia").prop('disabled', true);
    $("#row_0").prop('disabled', true);
    $("#txtFile").prop('disabled', true);
    $("#documento_rfc").prop('disabled', true);
    $("#acta_constitutiva").prop('disabled', true);
    $("#poder_legal").prop('disabled', true);
    $("#id_representante_legal").prop('disabled', true);
    $("#file_Domicilio").prop('disabled', true);
    $("#file_Rfc").prop('disabled', true);
    $("#file_Acta").prop('disabled', true);
    $("#file_Poder").prop('disabled', true);
    $("#file_Repre").prop('disabled', true);
    $("#divCorreosNotificaciones").addClass("disabledbutton");
    $("#divCorreosFacturaComision").addClass("disabledbutton");
    $("#divCorreosFacturaTransferencia").addClass("disabledbutton");
    $("#tabla_escalamiento").addClass("disabledbutton");
    $("#tabla_ccp").addClass("disabledbutton");
    $("#confcorreos").addClass("disabledbutton");
    $("#div_guardar").addClass('disabledbutton');
    $(".Lu_Check").addClass("disabledbutton");
    $(".Ma_Check").addClass("disabledbutton");
    $(".Mi_Check").addClass("disabledbutton");
    $(".Ju_Check").addClass("disabledbutton");
    $(".Vi_Check").addClass("disabledbutton");
    $("#tabla_listaProductos").addClass('disabledbutton');
}

function habilitarDivs() {
    $('input[type="text"]').prop("readonly", false);
    $("#cmbpais").prop("disabled", false);
    $("#cmbColonia").prop("disabled", false);
    $("#cmbCiudad").prop("disabled", false);
    $("#cmbEntidad").prop("disabled", false);
    $("#cmbIdentificacion").prop("disabled", false);
    $("#select_familia").prop("disabled", false);
    $("#select_subfamilia").prop("disabled", false);
    $("#select_productos").prop("disabled", false);
    $("#pagan_comisiones").prop("disabled", false);
    $("#cobran_comision").prop("disabled", false);
    $("#pago_liquidacion").prop("disabled", false);
    $("#dias_liquidacion").prop("disabled", false);
    $("#especial_select_dias").prop("disabled", false);
    $("#retencion").prop("disabled", false);
    $("#iva_comision").prop("disabled", false);
    $("#iva_cargo").prop("disabled", false);
    $("#ivaFactura").prop("disabled", false);
    $("#cmbCFDIComision").prop("disabled", false);
    $("#cmbFormaPagoComision").prop("disabled", false);
    $("#cmbMetodoPagoComision").prop("disabled", false);
    $("#cmbProductoServicioComision").prop("disabled", false);
    $("#cmbClaveUnidadComision").prop("disabled", false);
    $("#periocidadComision").prop("disabled", false);
    $("#cmbCFDITransferencia").prop("disabled", false);
    $("#cmbFormaPagoTransferencia").prop("disabled", false);
    $("#cmbMetodoPagoTransferencia").prop("disabled", false);
    $("#cmbProductoServicioTransferencia").prop("disabled", false);
    $("#cmbClaveUnidadTransferencia").prop("disabled", false);
    $("#periocidadTransferencia").prop("disabled", false);
    $("#select_vpn").prop("disabled", false);
    $("#select_vpnDesPrue").prop("disabled", false);
    $("#cbnotif").prop("disabled", false);
    $("#ctetipo").prop('disabled', false);
    $("#ctetipo3").prop('disabled', false);
    $("#btnAgregarProducto").prop('disabled', false);
    $("#radio_importe").prop('disabled', false);
    $("#radio_porcentaje").prop('disabled', false);
    $("#monto_transferencia").prop('disabled', false);
    $("#comision_usuario").prop('disabled', false);
    $("#cargo_usuario").prop('disabled', false);
    $("#genera_factura_comision").prop('disabled', false);
    $("#genera_factura_comision_transferencia").prop('disabled', false);
    $("#row_0").prop('disabled', false);
    $("#txtFile").prop('disabled', false);
    $("#documento_rfc").prop('disabled', false);
    $("#acta_constitutiva").prop('disabled', false);
    $("#poder_legal").prop('disabled', false);
    $("#id_representante_legal").prop('disabled', false);
    $("#file_Domicilio").prop('disabled', false);
    $("#file_Rfc").prop('disabled', false);
    $("#file_Acta").prop('disabled', false);
    $("#file_Poder").prop('disabled', false);
    $("#file_Repre").prop('disabled', false);
    $("#divCorreosNotificaciones").removeClass("disabledbutton");
    $("#divCorreosFacturaComision").removeClass("disabledbutton");
    $("#divCorreosFacturaTransferencia").removeClass("disabledbutton");
    $("#tabla_escalamiento").removeClass("disabledbutton");
    $("#tabla_ccp").removeClass("disabledbutton");
    $("#confcorreos").removeClass("disabledbutton");
    $("#div_guardar").removeClass('disabledbutton');
    $(".Lu_Check").removeClass("disabledbutton");
    $(".Ma_Check").removeClass("disabledbutton");
    $(".Mi_Check").removeClass("disabledbutton");
    $(".Ju_Check").removeClass("disabledbutton");
    $(".Vi_Check").removeClass("disabledbutton");
    $("#tabla_listaProductos").removeClass('disabledbutton');
}

function habilitarDivFacturaComision() {
    var checkFacturaComision = $("#genera_factura_comision:checked").val();
    if (checkFacturaComision == undefined) {
        $("#contenidoFacturaComision").hide();
    } else {
        $("#contenidoFacturaComision").show();
    }
}

function habilitarDivFacturaTransferencia() {
    var checkFacturaTransferencia = $("#genera_factura_comision_transferencia:checked").val();
    if (checkFacturaTransferencia == undefined) {
        $("#contenidoFacturaTransferencia").hide();
    } else {
        $("#contenidoFacturaTransferencia").show();
    }
}

function habilitarDivFacturaPubGral() {
    var checkFacturaPubGral = $("#genera_factura_public_gral:checked").val();
    if (checkFacturaPubGral == undefined) {
        $("#contenidoFacturaPubGral").hide();
    } else {
        $("#contenidoFacturaPubGral").show();
    }
}

function usuariosComerciales() {
    $.ajax({
        data: { tipo: 32 },
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        dataType: 'json',
        success: function (resp) {
            const { code, comerciales, msg } = resp;
            if (code == 0) {
                customLlenarComboSolicitante('cmbSolicitante', comerciales);
            } else {
                jAlert(msg, 'Oops!');
            }
        }
    });
}

function checaparametro() {
    var p_proveedor = $("#p_proveedor").val();
    // $("#divEntidadZona").show();
    if (p_proveedor == 27 || p_proveedor == 119) { //mostrar el check para zonas por proveedor
        $("#divEntidadZona").show();
    } else {
        $("#divEntidadZona").hide();
    }
    if (p_proveedor > 0) {
        $('#btn-informacion').html('Actualizar');
        // $('#step1-processing').css('display', 'block');
        $('#step1-informacion').css('display', 'none');
        $("#tipoProceso").val("edicion");

        const data = {
            tipo: 34,
            p_proveedor: p_proveedor
        }
        // setTimeout(() => {
        buscarInformacionProvedor(data);
        // }, 500);
    } else {
        $("#datos_bancarios_proveedor_zona").hide();
        $("#tipoProceso").val("normal");
        $('#step1-processing').css('display', 'none');
        $('#step1-informacion').css('display', 'block');
    }
}

function deshabilitarSecciones() {
    $("#li_paso1, #li_paso2, #li_paso3, #li_paso4, #li_paso5, #li_paso6, #li_paso7").removeClass("disabled");
}

function Regresar() {
    $('body').append('<form id="aconsulta" method="post" action="consulta.php"></form>');
    $("#aconsulta").submit();
}

function buscarMatrizEscalamientoProveedor(idProveedor) {
    $.ajax({
        data: {
            tipo: 14,
            idProveedor: idProveedor
        },
        success: function (response) {
            jQuery.each(obj, function (index, value) {
                agregarFila(0);
            });
        }
    });
}

function buscarCuentasContablesProductoProveedor(idProveedor) {
    $.ajax({
        data: {
            tipo: 18,
            idProveedor: idProveedor
        },
        type: 'POST',
        // async : false,
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {

                var idFamilia = obj[index]['idFamilia'];
                var descFamilia = obj[index]['descFamilia'];
                var idSubFamilia = obj[index]['idSubFamilia'];
                var descSubFamilia = obj[index]['descSubFamilia'];
                var idEmisor = obj[index]['idEmisor'];
                var descEmisor = obj[index]['descEmisor'];
                var id_productos = obj[index]['id_productos'];
                var nombre_productos = obj[index]['nombre_productos'];
                var sCuentaContableIngresos = obj[index]['sCuentaContableIngresos'];
                var sCuentaContableCostos = obj[index]['sCuentaContableCostos'];

                var nTipoCredito = obj[index]['nTipoCredito'];
                var descTipoCredito = obj[index]['descTipoCredito'];
                var id_cadenas = obj[index]['id_cadenas'];
                var nombre_cadenas = obj[index]['nombre_cadenas'];
                agregarFilaCCPEdicionModoNuevo(idFamilia, descFamilia, idSubFamilia, descSubFamilia, idEmisor, descEmisor, id_productos, nombre_productos, sCuentaContableIngresos, sCuentaContableCostos, nTipoCredito, descTipoCredito, id_cadenas, nombre_cadenas);

            });
        }
    });
}

function buscarDiasPeriodos(idProveedor) {
    $.ajax({
        data: {
            tipo: 12,
            idProveedor: idProveedor
        },
        type: 'POST',
        // async : false,
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var diaPadre = obj[index]['nDiaCorte'];
                var dias = obj[index]['sDiasPago'];
                if (diaPadre == 0) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Lu_Check";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodo++;
                        }
                    }
                }
                if (diaPadre == 1) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Ma_Check";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodo++;
                        }
                    }
                }
                if (diaPadre == 2) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Mi_Check";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodo++;
                        }
                    }
                }
                if (diaPadre == 3) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Ju_Check";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodo++;
                        }
                    }
                }
                if (diaPadre == 4) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Vi_Check";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodo++;
                        }
                    }
                }
            });
        }
    });
}

function buscarDiasPeriodosPPT(idProveedor) {
    $.ajax({
        data: {
            tipo: 12,
            idProveedor: idProveedor
        },
        type: 'POST',
        // async : false,
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var diaPadre = obj[index]['nDiaCorte'];
                var dias = obj[index]['sDiasPago'];
                if (diaPadre == 0) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Lu_Check_ppt";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodoPPT++;
                        }
                    }
                }
                if (diaPadre == 1) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Ma_Check_ppt";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodoPPT++;
                        }
                    }
                }
                if (diaPadre == 2) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Mi_Check_ppt";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodoPPT++;
                        }
                    }
                }
                if (diaPadre == 3) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Ju_Check_ppt";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodoPPT++;
                        }
                    }
                }
                if (diaPadre == 4) {
                    var splitear = dias.split(",");
                    if (splitear != "-1") {
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var idCompuesto = splitear[i] + ".Vi_Check_ppt";
                            $("#" + idCompuesto).attr('checked', true);
                            contadorChecksPeriodoPPT++;
                        }
                    }
                }
            });
        }
    });
}

function getDatosFacturacion(idProveedor, nFacturaComision, nFacturaTransferencia, nFacturaPublico) {
    $.ajax({
        data: {
            tipo: 13,
            idProveedor: idProveedor
        },
        type: 'POST',
        // cache: false,
        // async : false,
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var nTipoFactura = obj[index]['nTipoFactura'];
                if (nTipoFactura == 1) {
                    //comision normal
                    if (nFacturaComision == 1) {
                        $("#cmbCFDIComision option[value='" + obj[index]['sUsoCFDI'] + "']").prop('selected', true);
                        $("#cmbFormaPagoComision option[value='" + obj[index]['sFormaPago'] + "']").prop('selected', true);
                        $("#cmbMetodoPagoComision option[value='" + obj[index]['sMetodoPago'] + "']").prop('selected', true);
                        $("#cmbProductoServicioComision option[value='" + obj[index]['sClaveProductoServicio'] + "']").prop('selected', true);
                        $("#cmbClaveUnidadComision option[value='" + obj[index]['sUnidad'] + "']").prop('selected', true);
                        $("#periocidadComision option[value='" + obj[index]['nPeriodoFacturacion'] + "']").prop('selected', true);
                        $("#diasLiquidacionComision").val(obj[index]['nDiasLiquidaFactura']);
                        var correos_factComision = obj[index]['sCorreoDestino'];
                        var splitear = correos_factComision.split(":");
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var correoAdd = splitear[i];
                            correosenvfacturasComision.push(correoAdd);
                            var html = "<div class='col-xs-12 formCorreosComision'>";
                            html += "<input type='text' id='camposCorreosComision' class='form-control m-bot15 lecturaCorreosComision' name='correosFacturasComision' value='" + correoAdd + "' style='width: 270px; display:inline-block;' disabled>";
                            html += "<button  class='remove_button lecturaCorreosComision btn btn-sm inhabilitar' id='removeCorreosComision' style='margin-left:3px;' value='" + correoAdd + "' onclick='removercorreoFacturasComision(this.value);'>";
                            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
                            $('#contenedordecorreosfacturasComision').append(html);
                            $('#nuevocorreofacturasComision').val('');
                        }
                    }
                }
                if (nTipoFactura == 2) {
                    //comision normal
                    if (nFacturaTransferencia == 1) {
                        $("#cmbCFDITransferencia option[value='" + obj[index]['sUsoCFDI'] + "']").prop('selected', true);
                        $("#cmbFormaPagoTransferencia option[value='" + obj[index]['sFormaPago'] + "']").prop('selected', true);
                        $("#cmbMetodoPagoTransferencia option[value='" + obj[index]['sMetodoPago'] + "']").prop('selected', true);
                        $("#cmbProductoServicioTransferencia option[value='" + obj[index]['sClaveProductoServicio'] + "']").prop('selected', true);
                        $("#cmbClaveUnidadTransferencia option[value='" + obj[index]['sUnidad'] + "']").prop('selected', true);
                        $("#periocidadTransferencia option[value='" + obj[index]['nPeriodoFacturacion'] + "']").prop('selected', true);
                        $("#diasLiquidacionTransferencia").val(obj[index]['nDiasLiquidaFactura']);
                        var correos_factComisionTransferencia = obj[index]['sCorreoDestino'];
                        var splitear = correos_factComisionTransferencia.split(":");
                        for (var i = splitear.length - 1; i >= 0; i--) {
                            var correoAdd = splitear[i];
                            correosenvfacturasTransferencia.push(correoAdd);
                            var html = "<div class='col-xs-12 formCorreosTransferencia'>";
                            html += "<input type='text' id='camposCorreosTransferencia' class='form-control m-bot15 lecturaCorreosTransferencia' name='correosFacturasTransferencia' value='" + correoAdd + "' style='width: 270px; display:inline-block;' disabled>";
                            html += "<button  class='remove_button lecturaCorreosTransferencia btn btn-sm inhabilitar' id='removeCorreosFacturas' style='margin-left:3px;' value='" + correoAdd + "' onclick='removercorreoFacturasTransferencia(this.value);'>";
                            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
                            $('#contenedordecorreosfacturasTransferencia').append(html);
                            $('#nuevocorreofacturasTransferencia').val('');
                        }
                    }
                }

                if (nTipoFactura == 3) {
                    //comision normal
                    if (nFacturaPublico == 1) {

                        if (obj[index]['sCorreoDestino'].length > 5) {
                            $("#genera_factura_public_gral").prop('checked', true);
                            habilitarDivFacturaPubGral();
                            $("#cmbCFDIPubGral option[value='" + obj[index]['sUsoCFDI'] + "']").prop('selected', true);
                            $("#cmbFormaPagoPubGral option[value='" + obj[index]['sFormaPago'] + "']").prop('selected', true);
                            $("#cmbMetodoPagoPubGral option[value='" + obj[index]['sMetodoPago'] + "']").prop('selected', true);
                            $("#cmbProductoServicioPubGral option[value='" + obj[index]['sClaveProductoServicio'] + "']").prop('selected', true);
                            $("#cmbClaveUnidadPubGral option[value='" + obj[index]['sUnidad'] + "']").prop('selected', true);
                            $("#periocidadPubGral option[value='" + obj[index]['nPeriodoFacturacion'] + "']").prop('selected', true);
                            $("#diasLiquidacionPubGral").val(obj[index]['nDiasLiquidaFactura']);

                            var correos_factComisionPubGral = obj[index]['sCorreoDestino'];
                            var splitear = correos_factComisionPubGral.split(":");
                            for (var i = splitear.length - 1; i >= 0; i--) {
                                var correoAdd = splitear[i];
                                correosenvfacturasPubGral.push(correoAdd);
                                var html = "<div class='col-xs-12 formCorreosPubGral'>";
                                html += "<input type='text' id='camposCorreosPubGral' class='form-control m-bot15 lecturaCorreosPubGral' name='correosFacturasPubGral' value='" + correoAdd + "' style='width: 270px; display:inline-block;' disabled>";
                                html += "<button  class='remove_button lecturaCorreosPubGral btn btn-sm inhabilitar' id='removeCorreosPubGral' style='margin-left:3px;' value='" + correoAdd + "' onclick='removercorreoFacturasPubGral(this.value);'>";
                                html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
                                $('#contenedordecorreosfacturasPubGral').append(html);
                                $('#nuevocorreofacturasPubGral').val('');
                            }

                        }

                    }
                }
            });
        }
    });
}

function buscarDocsProveedor(idProveedor) {
    $.ajax({
        data: {
            tipo: 11,
            idProveedor: idProveedor
        },
        type: 'POST',
        // cache: false,
        // async : false,
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var idDoc = obj[index]['nIdDocumento'];
                var tipoDoc = obj[index]['nIdTipoDoc'];
                var nombreDoc = obj[index]['sNombreDoc'];
                var rutadoc = obj[index]['nRutaDoc'];
                if (tipoDoc == 1) {
                    $("#urlActa").val(rutadoc + nombreDoc);
                }
                if (tipoDoc == 2) {
                    $("#urlRFC").val(rutadoc + nombreDoc);
                }
                if (tipoDoc == 3) {
                    $("#urlDomicilio").val(rutadoc + nombreDoc);
                }
                if (tipoDoc == 4) {
                    $("#urlPoder").val(rutadoc + nombreDoc);
                }
                if (tipoDoc == 5) {
                    $("#urlRepre").val(rutadoc + nombreDoc);
                }
                if (tipoDoc == 6) {
                    $("#urlContrato").val(rutadoc + nombreDoc);
                }
                if (tipoDoc == 7) {
                    $("#urlAdendo1").val(rutadoc + nombreDoc);
                }
                if (tipoDoc == 8) {
                    $("#urlAdendo2").val(rutadoc + nombreDoc);
                }
            });
        }
    });
}

function buscarProductosProveedor(idProveedor) {
    var familia = "";
    var subfamilia = "";
    var productos = new Array();
    var producto = "";
    $.ajax({
        data: {
            tipo: 10,
            idProveedor: idProveedor
        },
        type: 'POST',
        // async : false,
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var idFamilia = obj[index]['idFamilia'];
                var descFamilia = obj[index]['descFamilia'];
                var idsubfamilia = obj[index]['idsubfamilia'];
                var descSubFamilia = obj[index]['descSubFamilia'];
                var idproducto = obj[index]['idproducto'];
                var nombreproducto = obj[index]['nombreproducto'];
                var importe = obj[index]['importe'];
                var descuento = obj[index]['descuento'];
                var importesindescuento = obj[index]['importesindescuento'];
                var importesiniva = obj[index]['importesiniva'];
                if (importe > 0) {
                    $("#select_familia option[value='" + idFamilia + "']").prop('selected', true);
                    $('#select_familia').val(idFamilia).trigger('change');
                    $("#select_subfamilia option[value='" + idsubfamilia + "']").prop('selected', true);
                    $('#select_subfamilia').val(idsubfamilia).trigger('change');
                    $("#select_productos option[value='" + idproducto + "']").prop('selected', true);
                    $("#importe_0").val(importe);
                    $("#descuento_0").val(descuento);
                    $("#importesindescuento_0").val(importesindescuento);
                    $("#importesiniva_0").val(importesiniva);
                    // agregarListaProductos(0);
                }
            });
        }
    });
}

function revisarZonas(proveedor) {
    var listaZonas = "";
    var contador = 0;
    var arreglo = [];
    var arregloInformacion = [];
    $.ajax({
        data: {
            tipo: 30,
            proveedor: proveedor
        },
        type: 'POST',
        async: false,
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                contador++;
                var datos = obj[index]['sClabe'] + "," + obj[index]['nIdZona'] + "," + obj[index]['sZona'] + "," + obj[index]['sreferenciaZona'] + "," + obj[index]['nIdBanco'];
                arregloInformacion.push(datos);
            });
        }
    });

    arreglo["listazonas"] = arregloInformacion;
    arreglo["contador"] = contador;
    return arreglo;
}

function setInformacion(data) {
    let { proveedor, nombre, secciones } = data;
    $('#p_proveedor').val(proveedor);
    $('#proveedor-nombre').html(nombre);
    if (secciones.bSeccion1 === '1') {
        $("#rfc").attr("readonly", "readonly");
        $("#rfc").addClass("readOnly");
        $("#rfc").attr('disabled', true);
        deshabilitarSecciones();
    }
}

function setIdDocumentos(documentos) {
    $.each(documentos, function (index, value) {
        var idDoc = documentos[index]['nIdDocumento'];
        var tipoDoc = documentos[index]['nIdTipoDoc'];
        var nombreDoc = documentos[index]['sNombreDoc'];
        var rutadoc = documentos[index]['sRutaDoc'];
        if (tipoDoc == 1) {
            $("#urlActa").val(rutadoc + nombreDoc);
            $("#file-urlActa").text(nombreDoc);
            $("#urlActa").attr('data-acta', idDoc);
        }
        if (tipoDoc == 2) {
            $("#urlRFC").val(rutadoc + nombreDoc);
            $("#file-urlRFC").text(nombreDoc);
            $("#urlRFC").attr('data-rfc', idDoc);
        }
        if (tipoDoc == 3) {
            $("#urlDomicilio").val(rutadoc + nombreDoc);
            $("#file-urlDomicilio").text(nombreDoc);
            $("#urlDomicilio").attr('data-domicilio', idDoc);
        }
        if (tipoDoc == 4) {
            $("#urlPoder").val(rutadoc + nombreDoc);
            $("#file-urlPoder").text(nombreDoc);
            $("#urlPoder").attr('data-poder-legal', idDoc);
        }
        if (tipoDoc == 5) {
            $("#urlRepre").val(rutadoc + nombreDoc);
            $("#file-urlRepre").text(nombreDoc);
            $("#urlRepre").attr('data-repre-legal', idDoc);
        }
        if (tipoDoc == 6) {
            $("#urlContrato").val(rutadoc + nombreDoc);
            $("#file-urlContrato").text(nombreDoc);
            $("#urlContrato").attr('data-contrato', idDoc);
        }
        if (tipoDoc == 7) {
            $("#urlAdendo1").val(rutadoc + nombreDoc);
            $("#file-urlAdendo1").text(nombreDoc);
            $("#urlAdendo1").attr('data-adendo1', idDoc);
        }
        if (tipoDoc == 8) {
            $("#urlAdendo2").val(rutadoc + nombreDoc);
            $("#file-urlAdendo2").text(nombreDoc);
            $("#urlAdendo2").attr('data-adendo2', idDoc);
        }
    });
}

/*
function buscarInformacionProvedor(idProveedor) {
    var contadorEntradas = 0;
    $.ajax({
        data: {
            tipo: 9,
        },
        success: function(response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function(index, value) {

                // TAB DATOS Y DIRECCION
                setTimeout(function() {
                    if (obj[index]['RFC'].length > 0) {
                        $("#rfc").attr("readonly", "readonly");
                        $("#rfc").addClass("readOnly");
                        $("#rfc").attr('disabled', true);
                    }
                }, 500);

                // if(obj[index]['rfc'].length>0){
                //     $("#rfc").val(obj[index]['rfc']);
                //     $("#rfc").attr("readonly","readonly");
                //     $("#rfc").addClass("readOnly");
                //     $("#rfc").attr('disabled',true);
                // }else{ 
                // }
                
                // revision y carga de zonas
                var resultadoZonas = revisarZonas(idProveedor);
                if (resultadoZonas["contador"] > 0) {

                    if(contadorEntradas == 0){
                        $("#checkEntidad").attr('checked', true);
                        $("#datos_bancarios_proveedor").hide();
                        $("#datos_bancarios_proveedor_zona").show();
                        $("#div_titulo_datos_bancarios_red").hide();
                        $("#datos_bancarios_red").hide();
                        resultadoZonas["listazonas"].forEach(function(item) {
                            var partes = item.split(",");
                            //var datos = obj[index]['sClabe']+","+obj[index]['nIdZona']+","+obj[index]['sZona']+","+obj[index]['sreferenciaZona'];  
                            // agregarFilaZona(0, 'back', zonaP = "", clabeP = "", referenciaP = "")
                            agregarFilaZona(0,'back', partes[2].trim(), partes[0].trim(), partes[3].trim(),partes[4].trim());
                        });
                    }
                    contadorEntradas++;
                } else {
                    $("#datos_bancarios_proveedor_zona").hide();
                }

                var cobra_monto_transferencia = obj[index]['nCobroTransferencia'];
                getDatosFacturacion(idProveedor, nFacturaComision, nFacturaTransferencia, 1);
                buscarMatrizEscalamientoProveedor(idProveedor);
                buscarCuentasContablesProductoProveedor(idProveedor);
            });
        }
    });
}
*/

function calcularCosto() {
    var inputCantidad = $('#txtCantTrans');
    var inputPorcentaje = $('#ivaFactura');
    var inputResultado = $('#txtcostotrans');

    var cantidad = parseFloat(inputCantidad.val());
    var porcentaje = parseFloat(ivaMappingSelect[inputPorcentaje.val()]) / 100;

    if (isNaN(cantidad)) {
        cantidad = 0;
    }

    var resultado = (cantidad * porcentaje) + cantidad;
    inputResultado.val(resultado.toFixed(2));
}

$('#txtCantTrans, #ivaFactura').on('input change', calcularCosto);

let documentArray = []
let departamentosArray = []
let representanteLegalMatriz = []
let datosBancariosMatriz = []
let IVAFacturacion = ''
const tipoIdentificacion = Object.freeze({
    "-1": "Sin Indentificación",
    "1": "INE",
    "2": "Passaporte",
    "3": "Licencia de conducir",
})
const ivaMapping = {
    '0.0000': '0%',
    '0.0800': '8%',
    '0.1600': '16%',
};

const ivaMappingSelect = {
    '1': '16%',
    '2': '8%',
    '3': '0%',
};

function llenarTablaRepresentantes(repre) {
    const btnGuardarRepresentante = $('#btn-repr-datos');
    btnGuardarRepresentante.prop('disabled', true);
    // Limpiar la tabla
    $('#tabla_representante_legal tbody').empty();

    if (Array.isArray(repre)) {
        repre.forEach((re, index) => {
            let representanteLegal = re.sNombre ? re.sNombre : '';
            let identificacion = re.nIdentificacion;
            let numeroIdentificacion = re.sNoIdentificacion;
            let idRepre = re.nIdMatriz ? re.nIdMatriz : '';

            let representante = {
                representanteLegal,
                identificacion,
                numeroIdentificacion,
                idRepre
            };
            representanteLegalMatriz.push(representante);
        });
    }

    if (representanteLegalMatriz.length > 0) {
        representanteLegalMatriz.forEach((rep, index) => {
            const boton_edit = '<button id="editarRepresentante" onclick="editarRepresentante(' + index + ');" data-placement="top" rel="tooltip" title="Editar" class="btn habilitar btn-default btn-xs" data-title="Editar"><span class="fa fa-edit"></span></button>';
            const boton_eliminar = '<button id="eliminarRepresentante" data-placement="top" rel="tooltip" title="Eliminar"  data-toggle="modal"  data-target="#confirmarEliminarRepresentante" class="btn inhabilitar btn-default btn-xs" data-title="Eliminar" data-repre="' + index + '" data-name="' + rep.representanteLegal + '"><span class="fa fa-times"></span></button>';

            $('#tabla_representante_legal tbody').append(`
        <tr>
          <td>${rep.representanteLegal}</td>
          <td>${tipoIdentificacion[rep.identificacion]}</td>
          <td>${rep.numeroIdentificacion}</td>
          <td>${boton_edit} ${boton_eliminar}</td>
        </tr>
      `);
        });
        btnGuardarRepresentante.prop('disabled', false);
        btnGuardarRepresentante.html('Actualizar');
    } else {
        // Mostrar mensaje de "No hay representantes legales"
        $('#tabla_representante_legal tbody').append(`
        <tr>
          <td colspan="6" style="text-align: center; font-weight: 100;">No hay representantes legales</td>
        </tr>
      `);
    }
}

async function llenarTablaDatosBancarios(bancos) {
    const btnGuardarDatosBancarios = $('#btn-banco-datos');
    btnGuardarDatosBancarios.prop('disabled', true);
    $('#tabla_datos_bancarios tbody').empty();

    if (bancos && bancos.length > 0) {
        // Mostrar mensaje de "Cargando información..."
        $('#tabla_datos_bancarios tbody').append(`
        <tr>
          <td colspan="6" style="text-align: center;">Cargando información...</td>
        </tr>
      `);

        for (let i = 0; i < bancos.length; i++) {
            let re = bancos[i];
            let clabe = re.sClabe;
            let banco = '';
            let idBanco = re.nIdBanco;
            let cuenta = re.sCuenta;
            let alfanumerico = re.sAlfanumerica;
            let beneficiario = re.sBeneficiario;
            let nIdCuentaBanco = re.nIdCuentaBanco;
            let swift = re.sSwift
            let iban = re.sIBAN
            let code = re.sCode
            let pais = re.nIdPais

            // Filtrar bancos
            if (re.dFechaBorrado === null) {
                try {
                    const data = await $.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": clabe });
                    const parsedData = JSON.parse(data);
                    banco = parsedData.nombreBanco;
                } catch (error) {
                    console.error(error);
                }

                let datosBancarios = {
                    clabe,
                    banco,
                    idBanco,
                    cuenta,
                    alfanumerico,
                    beneficiario,
                    nIdCuentaBanco,
                    swift,
                    iban,
                    code,
                    pais
                };

                datosBancariosMatriz.push(datosBancarios);
            }
        }
    } else {
        $('#tabla_datos_bancarios tbody').append(`
        <tr>
          <td colspan="6" style="text-align: center;">No hay datos bancarios</td>
        </tr>
      `);
    }

    $('#tabla_datos_bancarios tbody').empty();

    if (datosBancariosMatriz.length > 0) {
        datosBancariosMatriz.forEach((rep, index) => {
            const boton_edit = '<button id="editarDatosBancarios" onclick="editarDatosBancarios(' + index + ');" data-placement="top" rel="tooltip" title="Editar" class="btn habilitar btn-default btn-xs" data-title="Editar"><span class="fa fa-edit"></span></button>';
            const boton_eliminar = '<button id="eliminarDatosBancarios" data-placement="top" rel="tooltip" title="Eliminar"  data-toggle="modal"  data-target="#confirmarEliminarDatosBancarios" class="btn inhabilitar btn-default btn-xs" data-title="Eliminar" data-index="' + index + '" data-name="' + rep.banco + '"><span class="fa fa-times"></span></button>';

            $('#tabla_datos_bancarios tbody').append(`
          <tr>
            <td>${rep.clabe}</td>
            <td>${rep.banco}</td>
            <td>${rep.cuenta}</td>
            <td>${rep.alfanumerico}</td>
            <td>${rep.beneficiario}</td>
            <td>${boton_edit} ${boton_eliminar}</td>
          </tr>
        `);
        });
        btnGuardarDatosBancarios.prop('disabled', false);
        btnGuardarDatosBancarios.html('Actualizar');
    } else {
        // Mostrar mensaje de "No hay datos bancarios"
        $('#tabla_datos_bancarios tbody').append(`
        <tr>
          <td colspan="6" style="text-align: center;">No hay datos bancarios</td>
        </tr>
      `);
    }
}

function obtenerIvaFactura(datos) {
    const ivaFactura = ivaMapping.hasOwnProperty(datos.nIVA) ? ivaMapping[datos.nIVA] : '16%';
    $(`#ivaFactura option[value='${ivaFactura}'`).prop('selected', true);
}

function buscarInformacionProvedor(data) {
    $.ajax({
        data: data,
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        dataType: 'json',
        success: function (response) {
            let { code, datos, secciones, documentos, departamentos, matriz, repre, bancos, periodos, facturas } = response;

            documentArray.splice(0, documentArray.length);
            documentArray.push(...(documentos ?? []));
            departamentosArray.push(...(departamentos ?? []));

            let zonasActivas = false;
            $("#datos_bancarios_proveedor_zona").hide();
            if (secciones.bRevision > 1) $('#verificar').hide();

            if (datos) {
                obtenerIvaFactura(datos)
                buscarColonias(datos.cpDireccion, datos.idcColonia)
                $("#cmbSolicitante option[value='" + datos.nIdSolicitante + "']").prop('selected', true);
                $("#fecha-constitutiva").val(datos.dFechaConstitutiva);

                // Tab Informacion
                if (secciones.bSeccion1 == 1) {
                    seccionesGlobal = secciones;
                    if (datos.nIdTipoCliente == 0) {
                        $("#ctetipo").attr('checked', true);
                    } else {
                        $("#ctetipo3").attr('checked', true);
                    }

                    if (datos.nTipoVenta == 1) $("#radio_venta_servicios").attr('checked', true);

                    if (datos.nTipoVenta == 2) $("#radio_recarga").attr('checked', true);

                    if (datos.nTipoVenta == 3) $("#radio_servicio_recarga").attr('checked', true);

                    validarProveedor();
                    enviarTipo()
                    validarTipo(datos, periodos);

                    $("#rfc").attr("readonly", "readonly");
                    $("#rfc").addClass("readOnly");
                    $("#rfc").attr('disabled', true);
                    $("#rfc").val(datos.RFC);
                    $("#razonSocial").val(datos.razonSocial);
                    $("#nombreComercial").val(datos.nombreProveedor);
                    $("#proveedor-nombre").html(`${data.p_proveedor ? '(' + data.p_proveedor + ')' : ''} ${datos.nombreProveedor}`);
                    $("#regimenSocietario").val(datos.sRegimenSocietario);
                    $("#cmbSolicitante option[value='" + datos.nIdSolicitante + "']").prop('selected', true);

                    $(`#cmbRegimenFiscal option[value='${datos.sRegimenFiscal}']`).prop('selected', true);
                    $(`#cmbGiro option[value='${datos.idGiro}']`).prop('selected', true);
                    $("#cmbpais").val(datos.idPais);

                    $("#paisPago").val('164');
                    validarPais()

                    $("#txtCalle").val(datos.calleDireccion);
                    $("#ext").val(datos.numeroExtDireccion);
                    $("#int").val(datos.numeroIntDireccion);

                    $("#txtCP").val(datos.cpDireccion);
                    if (datos.idPais == 164) {
                        $("#divDirext").hide();
                        $("#divDirnac").show();
                        $('#div-rfc label').html('RFC');
                        $("#txtCP").trigger('keyup');
                    } else {
                        $("#divDirext").show();
                        $("#divDirnac").hide();
                        $('#div-rfc label').html('Id Oficial');

                        $("#txtColonia").val(datos.sNombreColonia);
                        $("#txtCiudad").val(datos.sNombreMunicipio);
                        $("#txtEstado").val(datos.sNombreEstado);
                    }

                    $('#referenciaAlfa').val(datos.RFC);

                    $('#step1-processing').css('display', 'none');
                    $('#step1-informacion').css('display', 'block');
                }

                Clonar();

                // Tab Representante Legal y Datos Bancarios
                if (secciones.bSeccion2 == '1') {
                    let actualizarRepre = false;
                    let actualizarBancos = false;
                    if (repre) {
                        actualizarRepre = true;
                        llenarTablaRepresentantes(repre)
                    }
                    if (zonasActivas) {
                        if (contadorEntradas == 0) {
                            resultadoZonas["listazonas"].forEach((item) => {
                                var partes = item.split(",");
                                agregarFilaZona(0, 'back', partes[2].trim(), partes[0].trim(), partes[3].trim(), partes[4].trim());

                                representanteLegalMatriz.forEach((representante) => {
                                    $('#tabla_representante_legal tbody').append(`
                                        <tr>
                                            <td>${representante.sNombre}</td>
                                            <td>${tipoIdentificacion[representante.nIdentificacion]}</td>
                                            <td>${representante.sNoIdentificacion}</td>
                                        </tr>
                                    `);
                                });
                            });
                        }
                        contadorEntradas++;
                    } else {
                        if (bancos) {
                            actualizarBancos = true;
                            llenarTablaDatosBancarios(bancos)
                        }
                    }

                    // $('#btn-repr-datos').html('Actualizar');
                }

                // Tab Documentos
                if (secciones.bSeccion3 == 1 && documentos) {
                    setIdDocumentos(documentos);
                    $('#btn-documentos').html('Actualizar');
                }

                // Tab Liquidacion
                if (secciones.bSeccion4 == 1) {
                    // Liquidacion Venta de Servicios
                    if (datos.nTipoVenta) {
                        let ivaFactura = 1;
                        if (datos.nIVA == "0.0800") ivaFactura = 2;
                        if (datos.nIVA == "0.1600") ivaFactura = 1;
                        $(`#ivaFactura option[value='${ivaFactura}'`).prop('selected', true);
                        SetearFormaPago();
                        $("#retencion option[value='" + datos.nRetencion + "']").prop('selected', true);
                        $("#dias_liquidacion option[value='" + datos.nTipoLiquidacion + "']").prop('selected', true);

                        //agregar correo notificaciones
                        let correos_notificaciones = datos.sEmailNotifiLiquidacion;
                        if (correos_notificaciones != null && correos_notificaciones != 0) {
                            let splitear = correos_notificaciones.split(":");
                            for (let i = splitear.length - 1; i >= 0; i--) {
                                let correoAdd = splitear[i];
                                correosNotificaciones.push(correoAdd);
                                let html = "<div class='col-xs-12 formCorreosNotificaciones'>";
                                html += "<input type='text' id='camposCorreosNotificaciones' class='form-control m-bot15 lecturaCorreosNotificaciones' name='correosFacturasNotificaciones' value='" + correoAdd + "' style='width: 270px; display:inline-block;' disabled >";
                                html += "<button  class='remove_button lecturaCorreosNotificaciones btn btn-sm inhabilitar' id='removeCorreosNotificaciones' style='margin-left:3px;' value='" + correoAdd + "' onclick='removercorreoNotificaciones(this.value);'>";
                                html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
                                $('#contenedordecorreosliquidacion').append(html);
                                $('#nuevocorreonotificaciones').val('');
                            }
                        }

                        if (datos.nTipoTiempoAire <= 1) $('#radio_prepago').attr('checked', true);

                        if (datos.nTipoTiempoAire == 2) {
                            $('#radio_credito').attr('checked', true);
                            $('#monto_credito').val(datos.cantidadCredito);
                            $('#dias_credito').val(datos.diasCredito);
                            $("#select_tipo_credito option[value='" + datos.tipoCredito + "']").prop('selected', true);
                            validarSubTipo();
                        }
                    }

                    $('#btn-liquidacion').html('Actualizar');
                }

                // Tab Datos Facturacion
                if (secciones.bSeccion5 == 1) {
                    let ivaFactura = 1;
                    if (datos.nIVA == "0.0800") ivaFactura = 2;
                    if (datos.nIVA == "0.1600") ivaFactura = 1;
                    $(`#ivaFactura option[value='${ivaFactura}'`).prop('selected', true);

                    if (datos.nFacturaComision == 1 && facturas) {
                        $('#genera_factura_comision').attr('checked', true);

                        // const facturasComision = facturas.filter(factura => factura.nTipoFactura == 1);
                        // const factura = (facturasComision.length > 0) ? facturasComision[0] : null;

                        // if (factura) {
                        $(`#cmbCFDIComision option[value='${facturas[0].sUsoCFDI}'`).prop('selected', true);
                        $(`#cmbFormaPagoComision option[value='${facturas[0].sFormaPago}'`).prop('selected', true);
                        $(`#cmbMetodoPagoComision option[value='${facturas[0].sMetodoPago}'`).prop('selected', true);
                        $(`#cmbProductoServicioComision option[value='${facturas[0].sClaveProductoServicio}'`).prop('selected', true);
                        $(`#cmbClaveUnidadComision option[value='${facturas[0].sUnidad}'`).prop('selected', true);
                        $(`#periocidadComision option[value='${facturas[0].nPeriodoFacturacion}'`).prop('selected', true);
                        $('#diasLiquidacionComision').val(`${facturas[0].nDiasLiquidaFactura}`);
                        let correos_factComision = facturas[0].sCorreoDestino;
                        let splitear = correos_factComision.split(":");
                        for (let i = splitear.length - 1; i >= 0; i--) {
                            let correoAdd = splitear[i];
                            correosenvfacturasComision.push(correoAdd);
                            let html = "<div class='col-xs-12 formCorreosComision'>";
                            html += "<input type='text' id='camposCorreosComision' class='form-control m-bot15 lecturaCorreosComision' name='correosFacturasComision' value='" + correoAdd + "' style='width: 270px; display:inline-block;' disabled>";
                            html += "<button  class='remove_button lecturaCorreosComision btn btn-sm inhabilitar' id='removeCorreosComision' style='margin-left:3px;' value='" + correoAdd + "' onclick='removercorreoFacturasComision(this.value);'>";
                            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
                            $('#contenedordecorreosfacturasComision').append(html);
                            $('#nuevocorreofacturasComision').val('');
                        }
                        habilitarDivFacturaComision();
                        // }
                    }

                    if (datos.nFacturaTransferencia == 1 && facturas) {
                        $('#genera_factura_comision_transferencia').attr('checked', true);
                        $(`#cmbCFDITransferencia option[value='${facturas[1].sUsoCFDI}'`).prop('selected', true);
                        $(`#cmbFormaPagoTransferencia option[value='${facturas[1].sFormaPago}'`).prop('selected', true);
                        $(`#cmbMetodoPagoTransferencia option[value='${facturas[1].sMetodoPago}'`).prop('selected', true);
                        $(`#cmbProductoServicioTransferencia option[value='${facturas[1].sClaveProductoServicio}'`).prop('selected', true);
                        $(`#cmbClaveUnidadTransferencia option[value='${facturas[1].sUnidad}'`).prop('selected', true);
                        $(`#periocidadTransferencia option[value='${facturas[1].nPeriodoFacturacion}'`).prop('selected', true);
                        $('#diasLiquidacionTransferencia').val(`${facturas[1].nDiasLiquidaFactura}`);
                        let correos_factComisionTransferencia = facturas[1].sCorreoDestino;
                        let splitear = correos_factComisionTransferencia.split(":");
                        for (let i = splitear.length - 1; i >= 0; i--) {
                            let correoAdd = splitear[i];
                            correosenvfacturasTransferencia.push(correoAdd);
                            let html = "<div class='col-xs-12 formCorreosTransferencia'>";
                            html += "<input type='text' id='camposCorreosTransferencia' class='form-control m-bot15 lecturaCorreosTransferencia' name='correosFacturasTransferencia' value='" + correoAdd + "' style='width: 270px; display:inline-block;' disabled>";
                            html += "<button  class='remove_button lecturaCorreosTransferencia btn btn-sm inhabilitar' id='removeCorreosFacturas' style='margin-left:3px;' value='" + correoAdd + "' onclick='removercorreoFacturasTransferencia(this.value);'>";
                            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
                            $('#contenedordecorreosfacturasTransferencia').append(html);
                            $('#nuevocorreofacturasTransferencia').val('');
                        }

                        habilitarDivFacturaTransferencia();
                    }

                    $('#btn-facturacion').html('Actualizar');
                }

                // Tab Matriz Escalamiento
                var selectOptions = "";
                if (departamentosArray) {
                    selectOptions += "<option value='-1'>Seleccione</option>";
                    for (var i = 0; i < departamentosArray.length; i++) {
                        var option = departamentosArray[i];
                        var optionText = option.sNombre ? option.sNombre : "";
                        selectOptions += "<option value='" + option.nIdArea + "'>" + optionText + "</option>";
                    }
                }

                $("#departamento_0").html(selectOptions).val("");
                $('#departamento_0 option[value="-1"').prop('selected', true);

                if ((secciones.bSeccion7 == 1) && matriz) {
                    $.each(matriz, function (index, value) {
                        var nDepartamento = matriz[index]['nDepartamento'];
                        var sNombre = matriz[index]['sNombre'];
                        var sPuesto = matriz[index]['sPuesto'];
                        var sTelefono = matriz[index]['sTelefono'];
                        var sCorreo = matriz[index]['sCorreo'];
                        var departamento = $("#departamento_0").val(nDepartamento);
                        var nombre = $("#nombre_0").val(sNombre);
                        var puesto = $("#puesto_0").val(sPuesto);
                        var telefono = $("#telefono_0").val(sTelefono);
                        var correo = $("#correo_0").val(sCorreo);
                        agregarFila(0);
                    });

                    $('#btn-matriz-escalamiento').html('Actualizar');
                }

                deshabilitarSecciones();
                if (secciones.bRevision == 1) $('#verificar').removeClass('disabled');
            }
        }
    });
}

function agregarSpan(id) {
    var span = $('#' + id).next('span');
    if (span.length === 0) {
        span = $('<span></span>');
        var small = $('<small></small>');

        small.attr('style', 'color: #d44950 !important;');
        small.text('Ingresa los datos necesarios');
        span.append(small);

        if ($('#' + id).val().length === 0) {
            $('#' + id).after(span);
        }
    }
}

function cargandoSpan(id) {
    var formGroup = $(inputIds[id]).closest('.form-group');
    var span = formGroup.find('span');

    if (span.length === 0) {
        span = $('<span></span>');
        var small = $('<small></small>');
        small.attr('style', 'color: #024182 !important;');
        small.text('Subiendo archivo, espere un momento');

        span.append(small);
        formGroup.append(span);
    } else {
        var small = span.find('span');
        small.attr('style', 'color: #024182 !important;');
        small.text('Subiendo archivo, espere un momento');
    }
}


function eliminarSpan(id, time) {
    setTimeout(function () {
        var formGroup = $(inputIds[id]).closest('.form-group');
        var span = formGroup.find('span');
        span.remove();
    }, time);
}

function eliminarSpanError(id) {
    var span = $(inputIds[id]).next('span');
    if (span.length !== 0) {
        span.remove();
    }
}

const inputIds = Object.freeze({
    1: "#acta_constitutiva",
    2: "#documento_rfc",
    3: "#txtFile",
    4: "#poder_legal",
    5: "#id_representante_legal",
    6: "#contrato",
    7: "#adendo1",
    8: "#adendo2",
});

const inputsFile = Object.freeze({
    1: "#urlActa",
    2: "#urlRFC",
    3: "#urlDomicilio",
    4: "#urlPoder",
    5: "#urlRepre",
    6: "#urlContrato",
    7: "#urlAdendo1",
    8: "#urlAdendo2",
});

const urls = Object.freeze({
    file_Domicilio: "#urlDomicilio",
    file_Rfc: "#urlRFC",
    file_Acta: "#urlActa",
    file_Poder: "#urlPoder",
    file_Repre: "#urlRepre",
    file_Contrato: "#urlContrato",
    file_Adendo1: "#urlAdendo1",
    file_Adendo2: "#urlAdendo2",
});

const maxSize = 15 * 1024 * 1024; // 15 MB
let formDatas = [];

function initInputFiles() {
    $(":input[type=file]").unbind("change");
    $(":input[type=file]").on("change", handleFileChange);
}

function handleFileChange(e) {
    let input = e.target;
    let nIdTipoDoc = input.getAttribute("idtipodoc");
    let files = $(input).prop("files");

    if (files.length === 0 && documentArray.length === 0) { // No se ha seleccionado ningún archivo
        clearFilePreview(nIdTipoDoc);
        formDatas = formDatas.filter(formData => formData.get('nIdTipoDoc') !== nIdTipoDoc);
        setIdDocumentos(documentArray);
        return;
    } else if (files.length === 0 && documentArray.length > 0) {
        formDatas = formDatas.filter(formData => formData.get('nIdTipoDoc') !== nIdTipoDoc);
        setIdDocumentos(documentArray);
        return;
    } else {
        jAlert("El archivo ha sido cargado");
    }

    let file = files[0];
    let usr = $("#usuario_logueado").val();

    if (!validateFile(file)) {
        if (file && file.type !== "application/pdf") {
            jAlert("El archivo debe ser formato PDF");
        } else {
            jAlert("El archivo debe tener un máximo de 15 MB");
        }
        $(input).val("");
        clearFilePreview(nIdTipoDoc);
        setIdDocumentos(documentArray);
        return;
    }

    eliminarSpanError(nIdTipoDoc)
    let formData = createFormData(file, nIdTipoDoc, usr);
    formDatas.push(formData);
    showFilePreview(file, nIdTipoDoc);
}

function clearFilePreview(nIdTipoDoc) {
    if (inputsFile.hasOwnProperty(nIdTipoDoc)) {
        $(inputsFile[nIdTipoDoc]).val("");
    }
}

function clearFileInput(nIdTipoDoc) {
    if (inputIds.hasOwnProperty(nIdTipoDoc)) {
        $(inputIds[nIdTipoDoc]).val("");
        $(inputIds[nIdTipoDoc]).next('input[type="text"]').val("");
    }
}

function validateFile(file) {
    if (!file || file.type !== "application/pdf") {
        return false;
    }

    if (file.size > maxSize) {
        return false;
    }

    return true;
}

function createFormData(file, nIdTipoDoc, usr) {
    let formData = new FormData();
    formData.append("sFile", file);
    formData.append("nIdTipoDoc", nIdTipoDoc);
    formData.append("rfc", $("#rfc").val());
    formData.append("usr", usr);

    return formData;
}

function showFilePreview(file, nIdTipoDoc) {
    let reader = new FileReader();
    reader.onload = function (e) {
        let previewUrl = e.target.result;
        let archivoPreview = previewUrl;

        if (inputsFile.hasOwnProperty(nIdTipoDoc)) {
            $(inputsFile[nIdTipoDoc]).empty().val(archivoPreview);
        }
    };
    reader.readAsDataURL(file);
}

function verdocumento(id) {
    if (urls.hasOwnProperty(id)) {
        let url = $(urls[id]).val();
        let validarUndefined = url.includes("undefined");

        if (validarUndefined === false && url.length > 0) {
            if (url.startsWith("data:")) {
                // El archivo se encuentra en base64
                $("#modal-agreement").modal("show");
                let base64Data = url.split(",")[1]; // Extraer solo los datos base64
                let byteCharacters = atob(base64Data); // Decodificar los datos base64
                let byteNumbers = new Array(byteCharacters.length);

                // Convertir los caracteres a números
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteNumbers[i] = byteCharacters.charCodeAt(i);
                }

                // Crear un objeto Blob con los datos del archivo PDF
                let byteArray = new Uint8Array(byteNumbers);
                let blob = new Blob([byteArray], { type: "application/pdf" });

                // Crear una URL para el objeto Blob
                let pdfUrl = URL.createObjectURL(blob);

                // Crear un elemento <iframe> para mostrar el PDF
                let iframeElement = document.createElement("iframe");
                iframeElement.src = pdfUrl;
                iframeElement.frameBorder = "0";
                iframeElement.width = "100%";
                iframeElement.height = "400px";

                $("#contenedorEmbed").empty().append(iframeElement);
            } else {
                // El archivo se encuentra en una URL
                $("#modal-agreement").modal("show");

                // Crear un elemento <iframe> para mostrar el PDF
                let iframeElement = document.createElement("iframe");
                iframeElement.src = url;
                iframeElement.frameBorder = "0";
                iframeElement.width = "100%";
                iframeElement.height = "400px";

                $("#contenedorEmbed").empty().append(iframeElement);
            }
        } else {
            let mensaje;
            switch (id) {
                case "file_Domicilio":
                    mensaje = "Favor de subir el Comprobante de Domicilio";
                    break;
                case "file_Rfc":
                    mensaje = "Favor de subir el RFC";
                    break;
                case "file_Acta":
                    mensaje = "Favor de subir el Acta Constitutiva";
                    break;
                case "file_Poder":
                    mensaje = "Favor de subir el Poder Legal";
                    break;
                case "file_Repre":
                    mensaje = "Favor de subir el Id Representante";
                    break;
                case "file_Contrato":
                    mensaje = "Favor de subir el Contrato";
                    break;
                case "file_Adendo1":
                    mensaje = "Favor de subir el Adendo 1";
                    break;
                case "file_Adendo2":
                    mensaje = "Favor de subir el Adendo 2";
                    break;
                default:
                    mensaje = "Archivo no válido";
            }

            jAlert(mensaje);
        }
    }
}

function disableInputFiles() {
    Object.values(inputIds).forEach(function (inputId) {
        $(inputId).prop('disabled', true);
    });
}

function enableInputFiles() {
    Object.values(inputIds).forEach(function (inputId) {
        $(inputId).prop('disabled', false);
    });
}


function uploadFile(callback) {
    let uploadNextFile = function () {
        if (formDatas.length === 0) {
            // Todos los archivos se han subido
            return callback()
        }

        let formData = formDatas[0];
        let nIdTipoDoc = formData.get("nIdTipoDoc");

        // Muestra un span con un mensaje de subiendo archivo
        cargandoSpan(nIdTipoDoc);
        $.ajax({
            url: "../ajax/documentos.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json'
        })
            .done(function (resp) {
                if (resp.estatus == 1) {
                    if (inputsFile.hasOwnProperty(parseInt(resp.IdTipoDoc))) {
                        $(inputsFile[parseInt(resp.IdTipoDoc)]).empty().val(resp.url);
                    }
                    // Limpiar el campo de archivo
                    clearFileInput(parseInt(resp.IdTipoDoc));
                    // Eliminar el primer formulario de formDatas
                    formDatas.shift();
                    // Elimina el span con el mensaje subiendo archivo
                    eliminarSpan(parseInt(resp.IdTipoDoc), 100)
                    // Subir el siguiente archivo
                    uploadNextFile();
                } else {
                    jAlert(resp.mensaje);
                }
            })
            .fail(function (resp) {
                jAlert('Error al Intentar Subir el Archivo');
            });
    };

    // Iniciar la subida del primer archivo
    uploadNextFile();
}

function cambiacomtip(vals) { //para el radio button de comisión por operaciones
    if (vals == 1) {
        $('#porcentajeComision').val(0);
        $('#porcentajeComision').prop('disabled', true);
        $('#comision').prop('disabled', false);
    } else {
        $('#comision').val(0);
        $('#comision').prop('disabled', true);
        $('#porcentajeComision').prop('disabled', false);
    }
}

function habilitar_transferencia(ckb) { //para habilitar la caja de texto de monto por transferencia
    if (ckb.checked == false) {
        $('#txtcostotrans').val(0);
        $('#divcobtrans').css('display', 'none');
        $("#cmbFormaPagoTransferencia option[value='99']").prop('selected', true);
        $("#cmbMetodoPagoTransferencia option[value='PPD']").prop('selected', true);
        $("#diasLiquidacionTransferencia").attr('disabled', false);
        showSuccess($("#diasLiquidacionTransferencia"));
    } else {
        $('#divcobtrans').css('display', 'block');
        $("#cmbFormaPagoTransferencia option[value='17']").prop('selected', true);
        $("#cmbMetodoPagoTransferencia option[value='PUE']").prop('selected', true);
        $("#diasLiquidacionTransferencia").val('');
        $("#diasLiquidacionTransferencia").attr('disabled', true);
        showSuccess($("#diasLiquidacionTransferencia"));
    }
}

function habilitar_com_usuario(ckb) {
    if (ckb.checked == false) {
        $("#div_comision_usuario").css('display', 'none');
        $("#txtcostocom").attr('disabled', false);
        $("#txtcostocom").val(0);

    } else {
        $("#div_comision_usuario").css('display', 'block');
        $("#txtcostocom").attr('disabled', false);
    }
}

function habilitar_cargo_usuario(ckb) {
    if (ckb.checked == false) {
        $("#div_cargo_servicio").css('display', 'none');
        $('#txtcargoserv').attr("disabled", false);
        $('#txtcargoserv').val(0);
    } else {
        $("#div_cargo_servicio").css('display', 'block');
        $('#txtcargoserv').attr("disabled", false);
    }
}
var correosNotificaciones = [];

function agregarCorreoNotificaciones() { //para agragar los correos por comision
    var num_correos = correosNotificaciones.length;
    if (num_correos < 50) {
        new_correo = $('#nuevocorreonotificaciones').val();
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

function agrergarcorreosfacturasComision() { //para agragar los correos por comision
    var num_correos = correosenvfacturasComision.length;
    if (num_correos < 50) {
        new_correo = $('#nuevocorreofacturasComision').val();
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
var correosenvfacturasTransferencia = [];

function agrergarcorreosfacturasTransferencia() { //para agragar los correos por transferencia
    var num_correos = correosenvfacturasTransferencia.length;
    if (num_correos < 50) {
        new_correo = $('#nuevocorreofacturasTransferencia').val();
        if (validarEmail(new_correo) == false) {
            jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique');
            return;
        } else {
            correosenvfacturasTransferencia.push(new_correo);
            var html = "<div class='col-xs-12 formCorreosTransferencia'>";
            html += "<input type='text' id='camposCorreosTransferencia' class='form-control m-bot15 lecturaCorreosTransferencia' name='correosFacturasTransferencia' value='" + new_correo + "' style='width: 270px; display:inline-block;' disabled>";
            html += "<button  class='remove_button lecturaCorreosTransferencia btn btn-sm inhabilitar' id='removeCorreosFacturas' style='margin-left:3px;' value='" + new_correo + "' onclick='removercorreoFacturasTransferencia(this.value);'>";
            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
            $('#contenedordecorreosfacturasTransferencia').append(html);
            $('#nuevocorreofacturasTransferencia').val('');
        }
    } else {
        if (num_correos = 49) {
            $('#nuevocorreofacturasTransferencia').attr('disabled', true);
            $('#nuevocorreofacturasTransferencia').val('');
        }
        jAlert('Solo puede Agregar 50 Correos');
    }
}

var correosenvfacturasPubGral = [];

function agrergarcorreosfacturasPubGral() { //para agragar los correos por transferencia
    var num_correos = correosenvfacturasPubGral.length;
    if (num_correos < 50) {
        new_correo = $('#nuevocorreofacturasPubGral').val();
        if (validarEmail(new_correo) == false) {
            jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique');
            return;
        } else {
            correosenvfacturasPubGral.push(new_correo);
            var html = "<div class='col-xs-12 formCorreosPubGral'>";
            html += "<input type='text' id='camposCorreosPubGral' class='form-control m-bot15 lecturaCorreosPubGral' name='correosFacturasPubGral' value='" + new_correo + "' style='width: 270px; display:inline-block;' disabled>";
            html += "<button  class='remove_button lecturaCorreosPubGral btn btn-sm inhabilitar' id='removeCorreosPubGral' style='margin-left:3px;' value='" + new_correo + "' onclick='removercorreoFacturasPubGral(this.value);'>";
            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
            $('#contenedordecorreosfacturasPubGral').append(html);
            $('#nuevocorreofacturasPubGral').val('');
        }
    } else {
        if (num_correos = 49) {
            $('#nuevocorreofacturasPubGral').attr('disabled', true);
            $('#nuevocorreofacturasPubGral').val('');
        }
        jAlert('Solo puede Agregar 50 Correos');
    }
}


function removercorreoFacturasPubGral(corr) { //pra eliminar los correos por transferencia
    for (var i = 0; i < correosenvfacturasPubGral.length; i++) {
        while (correosenvfacturasPubGral[i] == corr)
            correosenvfacturasPubGral.splice(i, 1);
    }
    $('#contenedordecorreosfacturasPubGral').empty();
    for (var i = 0; i < correosenvfacturasPubGral.length; i++) {
        $('#contenedordecorreosfacturasPubGral').append('<div class="col-xs-12 formCorreosPubGral" > ' +
            '<input type="text" id="camposCorreosPubGral" class="form-control m-bot15 lecturaCorreosPubGral" name="correosFacturasPubGral" ' +
            'value="' + correosenvfacturasPubGral[i] + '" style="width: 270px; display:inline-block;" disabled> ' +
            '<button  class="remove_button lecturaCorreosPubGral btn btn-sm inhabilitar" id="removeCorreosPubGral" style="margin-left:3px" ' +
            'value="' + correosenvfacturasPubGral[i] + '" onclick="removercorreoFacturasPubGral(this.value);"> ' +
            '<i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    }
    if (correosenvfacturasPubGral.length < 50) {
        $('#nuevocorreofacturasPubGral').attr('disabled', false);
        $('#nuevocorreofacturasPubGral').val('');
    }
}


function removercorreoFacturasTransferencia(corr) { //pra eliminar los correos por transferencia
    for (var i = 0; i < correosenvfacturasTransferencia.length; i++) {
        while (correosenvfacturasTransferencia[i] == corr)
            correosenvfacturasTransferencia.splice(i, 1);
    }
    $('#contenedordecorreosfacturasTransferencia').empty();
    for (var i = 0; i < correosenvfacturasTransferencia.length; i++) {
        $('#contenedordecorreosfacturasTransferencia').append('<div class="col-xs-12 formCorreosTransferencia" ><input type="text" id="camposCorreosTransferencia" class="form-control m-bot15 lecturaCorreosTransferencia" name="correosFacturasTransferencia" value="' + correosenvfacturasTransferencia[i] + '" style="width: 270px; display:inline-block;" disabled><button  class="remove_button lecturaCorreosTransferencia btn btn-sm inhabilitar" id="removeCorreosFacturas" style="margin-left:3px" value="' + correosenvfacturasTransferencia[i] + '" onclick="removercorreoFacturasTransferencia(this.value);"> <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    }
    if (correosenvfacturasTransferencia.length < 50) {
        $('#nuevocorreofacturasTransferencia').attr('disabled', false);
        $('#nuevocorreofacturasTransferencia').val('');
    }
}
var correosTimeOut = [];

function agregarcorreosTimeOut() { //agregar los correos
    var num_correos = correosTimeOut.length;
    if (num_correos < 50) {
        new_correo = $('#nuevocorreo').val();
        if (validarEmail(new_correo) == false) {
            jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique');
            return;
        } else {
            correosTimeOut.push(new_correo);
            var html = "<div class='col-xs-12 formCorreosTime'>";
            html += "<input type='text' id='camposCorreosTime' class='form-control m-bot15 lecturaCorreosTime' name='correosFacturasTime' value='" + new_correo + "' style='width: 300px; display:inline-block;' disabled>";
            html += "<button  style='margin-left:3px;background-color:red;color:white' class='remove_button lecturaCorreosTime btn btn-sm inhabilitar' id='removeCorreosTime'  value='" + new_correo + "' onclick='removercorreoTimeOut(this.value);'>";
            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
            $('#contenedordecorreos1').append(html);
            $('#nuevocorreo').val('');
        }
    } else {
        if (num_correos = 49) {
            $('#nuevocorreo').attr('disabled', true);
            $('#nuevocorreo').val('');
        }
        jAlert('Solo puede Agregar 50 Correos');
    }
}

function removercorreoTimeOut(corr) { //eliminar correos
    for (var i = 0; i < correosTimeOut.length; i++) {
        while (correosTimeOut[i] == corr)
            correosTimeOut.splice(i, 1);
    }
    $('#contenedordecorreos1').empty();
    for (var i = 0; i < correosTimeOut.length; i++) {
        $('#contenedordecorreos1').append('<div class="col-xs-12 formCorreosTime" ><input type="text" id="camposCorreosTime" class="form-control m-bot15 lecturaCorreosTime" name="correosFacturasTime" value="' + correosTimeOut[i] + '" style="width: 300px; display:inline-block;" disabled><button  class="remove_button lecturaCorreosTime btn btn-sm inhabilitar" id="removeCorreosTime" style="margin-left:3px;background-color:red;color:white" value="' + correosTimeOut[i] + '" onclick="removercorreoTimeOut(this.value);"> <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    }
    if (correosTimeOut.length < 50) {
        $('#nuevocorreo').attr('disabled', false);
        $('#nuevocorreo').val('');
    }
}


var correosTimeOutenvio = [];

function agregarcorreosTimeOutenvio() { //agregar los correos
    var num_correos = correosTimeOutenvio.length;
    if (num_correos < 50) {
        new_correo = $('#nuevocorreoenvio').val();
        if (validarEmail(new_correo) == false) {
            jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique');
            return;
        } else {
            correosTimeOutenvio.push(new_correo);
            var html = "<div class='col-xs-12 formCorreosTimeenvio'>";
            html += "<input type='text' id='camposCorreosTimeenvio' class='form-control m-bot15 lecturaCorreosTimeenvio' name='correosFacturasTimeenvio' value='" + new_correo + "' style='width: 300px; display:inline-block;' disabled>";
            html += "<button  style='margin-left:3px;background-color:red;color:white' class='remove_button lecturaCorreosTimeenvio btn btn-sm inhabilitar' id='removeCorreosTimeenvio'  value='" + new_correo + "' onclick='removercorreoTimeOutenvio(this.value);'>";
            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
            $('#contenedordecorreosTimeOutEnvio').append(html);
            $('#nuevocorreoenvio').val('');
        }
    } else {
        if (num_correos = 49) {
            $('#nuevocorreoenvio').attr('disabled', true);
            $('#nuevocorreoenvio').val('');
        }
        jAlert('Solo puede Agregar 50 Correos');
    }
}

function removercorreoTimeOutenvio(corr) { //eliminar correos
    for (var i = 0; i < correosTimeOutenvio.length; i++) {
        while (correosTimeOutenvio[i] == corr)
            correosTimeOutenvio.splice(i, 1);
    }
    $('#contenedordecorreosTimeOutEnvio').empty();
    for (var i = 0; i < correosTimeOutenvio.length; i++) {
        $('#contenedordecorreosTimeOutEnvio').append('<div class="col-xs-12 formCorreosTimeenvio" ><input type="text" id="camposCorreosTimeenvio" class="form-control m-bot15 lecturaCorreosTimeenvio" name="correosFacturasTimeenvio" value="' + correosTimeOutenvio[i] + '" style="width: 300px; display:inline-block;" disabled><button  class="remove_button lecturaCorreosTimeenvio btn btn-sm inhabilitar" id="removeCorreosTimeenvio" style="margin-left:3px;background-color:red;color:white" value="' + correosTimeOutenvio[i] + '" onclick="removercorreoTimeOutenvio(this.value);"> <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    }
    if (correosTimeOutenvio.length < 50) {
        $('#nuevocorreoenvio').attr('disabled', false);
        $('#nuevocorreoenvio').val('');
    }
}


function BuscarSubFamilias(value) { //buscador de subfamilias
    $('#subfamiliaccp_0').empty();
    var idFamilia = value;
    $.ajax({
        data: {
            tipo: 2,
            idFamilia: idFamilia
        },
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            $('#subfamiliaccp_0').append('<option value="-1">Seleccione</option>');
            jQuery.each(obj, function (index, value) {
                var nombre_subfamilia = obj[index]['descSubFamilia'];
                $('#subfamiliaccp_0').append('<option value="' + obj[index]['idSubFamilia'] + '">' + nombre_subfamilia + '</option>');
            });
        }
    });
    //buscar servicios
    var contador = 0;
    var respuesta = "";
    $('.rowservicios').remove();
    $.ajax({
        data: {
            tipo: 6,
            idFamilia: idFamilia
        },
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                contador++;
                var id_servicio = obj[index]['idTranType'];
                var nombre_servicio = obj[index]['descTranType'];
                if (contador == 1) {
                    respuesta += "<tr class='rowservicios'><td id='td_" + id_servicio + "'><input class='check_servicios' type='checkbox' id='checkbox_" + id_servicio + " '> " + nombre_servicio + "</td>";
                }
                if (contador == 2) {
                    respuesta += "<td id='td_" + id_servicio + "'><input class='check_servicios' type='checkbox' id='checkbox_" + id_servicio + "' > " + nombre_servicio + "</td>";
                }
                if (contador == 3) {
                    respuesta += "<td id='td_" + id_servicio + "'><input class='check_servicios' type='checkbox' id='checkbox_" + id_servicio + "' > " + nombre_servicio + "</td></tr>";
                    contador = 0;
                }
            });
        }
    });
}

function BuscarProductos(value) { //busqueda de productos
    $('#productoccp_0').empty();
    var idFamilia = $("#familiaccp_0 option:selected").val();
    $.ajax({
        data: {
            tipo: 3,
            idFamilia: idFamilia,
            idSubFamilia: value
        },
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var nombre_producto = obj[index]['descProducto'];
                $('#productoccp_0').append('<option value="' + obj[index]['idProducto'] + '">' + nombre_producto + '</option>');
            });
        }
    });
}


function BuscarProductosPoremisor(emisor) {

    $("#productoccp_0").empty();

    var familia = $("#familiaccp_0 option:selected").val();
    var subfamilia = $("#subfamiliaccp_0 option:selected").val();
    var lista = "";
    $.ajax({
        data: {
            tipo: 27,
            emisor: emisor,
            familia: familia,
            subfamilia: subfamilia
        },
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var nombre_producto = obj[index]['descProducto'];
                lista += '<option value="' + obj[index]['idProducto'] + '">' + nombre_producto + '</option>';
            });
            $("#productoccp_0").html(lista).selectpicker('refresh');
        }
    });

}

function BuscarEmisores() { //busqueda de productos

    var familia = $("#familiaccp_0 option:selected").val();
    var subfamilia = $("#subfamiliaccp_0 option:selected").val();
    $('#emisoresccp_0').empty();

    $('#emisoresccp_0').append('<option value="0">Seleccione...</option>');
    $.ajax({
        data: {
            tipo: 26,
            familia: familia,
            subfamilia: subfamilia
        },
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var nombre_emisor = obj[index]['descEmisor'];
                $('#emisoresccp_0').append('<option value="' + obj[index]['idemisor'] + '">' + nombre_emisor + '</option>');
            });
        }
    });
}

function ftpopt(valor) { // para mostrar el tipo metodo de entrega
    if (valor == 0) {
        $('#confcorreos').css('display', 'none');
        $('#datosFtp').css('display', 'none');
    }
    if (valor >= 1) {
        $('#confcorreos').css('display', 'block');
        $('#datosFtp').css('display', 'block');
    }
}

function ftpoptppt1(valor) { // para mostrar el tipo metodo de entrega
    if (valor == 0) {
        $('#confcorreosppt1').css('display', 'none');
        $('#datosFtp_ppt1').css('display', 'none');
    }
    if (valor >= 1) {
        $('#confcorreosppt1').css('display', 'block');
        $('#datosFtp_ppt1').css('display', 'block');
    }
}

function ftpoptppt2(valor) { // para mostrar el tipo metodo de entrega
    if (valor == 0) {
        $('#confcorreosppt2').css('display', 'none');
        $('#datosFtp_ppt2').css('display', 'none');
    }
    if (valor >= 1) {
        $('#confcorreosppt2').css('display', 'block');
        $('#datosFtp_ppt2').css('display', 'block');
    }
}

function ftpopt2(valor) { // para mostrar el tipo metodo de entrega
    if (valor == 0) {
        $('#confcorreos2').css('display', 'none');
        $('#datosFtp2').css('display', 'none');
    }
    if (valor >= 1) {
        $('#confcorreos2').css('display', 'block');
        $('#datosFtp2').css('display', 'block');
    }
}
var contadorFilas = 0;
function agregarFila(id) { //agrega la fila de matriz de escalamiento
    var departamento = $("#departamento_0").val();
    var nombre = $("#nombre_0").val();
    var puesto = $("#puesto_0").val();
    var telefono = $("#telefono_0").val();
    var correo = $("#correo_0").val();

    if (nombre.length > 0 && correo.length > 0) {
        if (validarEmail(correo) == false) {
            jAlert("El formato del Correo Eletrónico es incorrecto, por favor Verifique");
        } else if (departamento === '-1') {
            jAlert("El departamento debe ser agregado.");
        } else {
            contadorFilas++;
            var selectOptions = "";
            if (departamentosArray) {
                selectOptions += "<option value='-1'>Seleccione</option>";
                for (var i = 0; i < departamentosArray.length; i++) {
                    var option = departamentosArray[i];
                    var optionText = option.sNombre ? option.sNombre : "";
                    selectOptions += "<option value='" + option.nIdArea + "'>" + optionText + "</option>";
                    if (option.nIdArea == departamento) {
                        departamento = option.nIdArea; // Obtener el valor correcto del departamento seleccionado
                    }
                }
            }

            var fila = "<tr class='tr_class' id='fila_" + contadorFilas + "'>"
                + "<td><select disabled id='departamento_" + contadorFilas + "' class='form-control m-bot15'>" + selectOptions + "</select></td>"
                + "<td><input readonly type='text' id='nombre_" + contadorFilas + "' class='form-control m-bot15'></td>"
                + "<td><input readonly type='text' id='puesto_" + contadorFilas + "' class='form-control m-bot15'></td>"
                + "<td><input readonly type='text' id='telefono_" + contadorFilas + "' maxlength='12' onkeyup='validarTelefono(this.id);' class='form-control m-bot15'></td>"
                + "<td><input readonly type='text' data-toggle='tooltip' title='Formato incorrecto' id='correo_" + contadorFilas + "' onkeyup='validarCorreo(this.id);' class='form-control m-bot15'></td>"
                + "<td><button style='background-color:red;border-color:red;' id='row_" + contadorFilas + "' class='add_button btn btn-sm btn-default' onclick='eliminarFila(this.id);'>"
                + "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>"
                + "</tr>";

            $("#tabla_escalamiento").append(fila);
            $("#departamento_" + contadorFilas + " ").val(departamento);
            $("#nombre_" + contadorFilas + " ").val(nombre);
            $("#puesto_" + contadorFilas + " ").val(puesto);
            $("#telefono_" + contadorFilas + " ").val(telefono);
            $("#correo_" + contadorFilas + " ").val(correo);
            $("#departamento_0 option[value='-1'").prop('selected', true);
            $("#nombre_0").val("");
            $("#puesto_0").val("");
            $("#telefono_0").val("");
            $("#correo_0").val("");

            var renglon = contadorFilas + "," + departamento + "," + nombre + "," + puesto + "," + telefono + "," + correo + "|";
            agregarcorreosLineaMatriz(renglon);
        }
    } else {
        jAlert("Favor de ingresar todos los datos");
    }
}

let contadorFilasRepresentantes = 0;

function limpiarInputsRepresentanteLegal() {
    const inputs = ['#representante_legal', '#cmbIdentificacion', '#numeroIdentificacion', '#positionRepre', '#idRepre'];

    inputs.forEach((input, index) => { // Buscar el select
        if (index === 1) {
            $(input).val('-1');
        } else {
            $(input).val('');
        }
    });
    habilitarBotonAgregarRepresentante()
}

function limpiarInputsDatosBancarios() {
    const inputs = ['#clabe', '#nombreBanco', '#banco', '#cuentaBanco', '#nIdCuentaBanco', '#positionBancos', '#swift', '#iban', '#code'];
    inputs.forEach((input, index) => {
        $(input).val('');
    });
    $("#paisPago").val('-1');
    validarPais()
    habilitarBotonAgregarBancos()
}

function editarRepresentante(index) {
    limpiarInputsRepresentanteLegal()

    let idRepresentante = representanteLegalMatriz[index].idRepre ? representanteLegalMatriz[index].idRepre : ''
    $('#representante_legal').val(representanteLegalMatriz[index].representanteLegal);
    $('#cmbIdentificacion').val(representanteLegalMatriz[index].identificacion);
    $('#numeroIdentificacion').val(representanteLegalMatriz[index].numeroIdentificacion);
    $('#positionRepre').val(index);
    $('#idRepre').val(idRepresentante);

    const btnAgregarRepresentante = $("#agregar-representante-legal");
    btnAgregarRepresentante.prop("disabled", false);
}

function editarDatosBancarios(index) {
    limpiarInputsDatosBancarios()

    let nIdCuentaBanco = datosBancariosMatriz[index].nIdCuentaBanco ? datosBancariosMatriz[index].nIdCuentaBanco : ''
    $('#clabe').val(datosBancariosMatriz[index].clabe);
    $('#banco').val(datosBancariosMatriz[index].idBanco);
    $('#nombreBanco').val(datosBancariosMatriz[index].banco);
    $('#cuentaBanco').val(datosBancariosMatriz[index].cuenta);
    $('#referenciaAlfa').val(datosBancariosMatriz[index].alfanumerico);
    $('#beneficiario_DB').val(datosBancariosMatriz[index].beneficiario);
    $('#swift').val(datosBancariosMatriz[index].swift);
    $('#iban').val(datosBancariosMatriz[index].iban);
    $('#code').val(datosBancariosMatriz[index].code);
    $('#paisPago').val(datosBancariosMatriz[index].pais);
    $('#positionBancos').val(index);
    $('#nIdCuentaBanco').val(nIdCuentaBanco);

    validarPais()

    const btnDatosBancarios = $("#agregar-datos-bancarios");
    btnDatosBancarios.prop("disabled", false);
}

function actualizarTablaRepresentantes(representanteLegalMatriz) {
    $('#tabla_representante_legal tbody').empty();

    representanteLegalMatriz.forEach((rep, index) => {
        const boton_edit = '<button id="editarRepresentante" onclick="editarRepresentante(' + index + ');" data-placement="top" rel="tooltip" title="Editar" class="btn habilitar btn-default btn-xs" data-title="Editar"><span class="fa fa-edit"></span></button>';
        const boton_eliminar = '<button id="eliminarRepresentante" data-placement="top" rel="tooltip" title="Eliminar"  data-toggle="modal"  data-target="#confirmarEliminarRepresentante" class="btn inhabilitar btn-default btn-xs" data-title="Eliminar" data-repre="' + index + '" data-name="' + rep.representanteLegal + '"><span class="fa fa-times"></span></button>';

        $('#tabla_representante_legal tbody').append(`
        <tr>
          <td>${rep.representanteLegal}</td>
          <td>${tipoIdentificacion[rep.identificacion]}</td>
          <td>${rep.numeroIdentificacion}</td>
          <td>${boton_edit} ${boton_eliminar}</td>
        </tr>
      `);
    });
}


function eliminarRepresentanteTabla(index) {
    const btnGuardarRepresentante = $('#btn-repr-datos');
    limpiarInputsRepresentanteLegal()
    representanteLegalMatriz.splice(index, 1);
    actualizarTablaRepresentantes(representanteLegalMatriz)
    if (representanteLegalMatriz.length < 1) {
        btnGuardarRepresentante.prop('disabled', true)
    }
}

function eliminarDatosBancarios(index) {
    const btnGuardarDatosBancarios = $('#btn-banco-datos');
    limpiarInputsDatosBancarios()
    datosBancariosMatriz.splice(index, 1);
    actualizarTablaDatosBancarios(datosBancariosMatriz)
    if (datosBancariosMatriz.length < 1) {
        btnGuardarDatosBancarios.prop('disabled', true)
    }
}

function eliminarRepresentanteBD(idRepre) {
    let data = {
        tipo: 40,
        p_idRepre: idRepre
    }
    data.p_proveedor = $('#p_proveedor').val();
    btnEliminar.id = '#btn-repr-datos';
    enviarSolicitud(data, btnEliminar, borrar.REPRESENTANTE)
}

function eliminarDatosBancariosBD(idCuentaBanco) {
    let data = {
        tipo: 53,
        p_idCuentaBanco: idCuentaBanco
    }
    data.p_proveedor = $('#p_proveedor').val();
    btnEliminar.id = '#btn-repr-datos';
    enviarSolicitud(data, btnEliminar, borrar.BANCO)
}

$(document).ready(function () {
    habilitarBotonAgregarRepresentante();
    habilitarBotonAgregarBancos()

    $('#representante_legal, #cmbIdentificacion, #numeroIdentificacion').on('input change', function () {
        habilitarBotonAgregarRepresentante();
        const elemCampo = $(this);
        validarCampo(elemCampo);
    });

    $('#clabe, #banco, #cuentaBanco, #cuentaContable, #beneficiario_DB').on('input', function () {
        habilitarBotonAgregarBancos();
        const elemCampo = $(this);
        validarCampo(elemCampo);
    });

});

function habilitarBotonAgregarRepresentante() {
    const elemRepresentanteLegal = $('#representante_legal').val();
    const elemIdentificacion = $('#cmbIdentificacion').val();
    const elemNumeroIdentificacion = $("#numeroIdentificacion").val();

    let esValido = Boolean(
        elemRepresentanteLegal &&
        elemIdentificacion &&
        elemNumeroIdentificacion
    );
    const btnAgregarRepresentante = $("#agregar-representante-legal");
    btnAgregarRepresentante.prop("disabled", !esValido);
}

function habilitarBotonAgregarBancos() {
    const elemClabe = $("#clabe").val();
    const elemBanco = $("#banco").val();
    const elemReferenciaAlfa = $("#referenciaAlfa").val();
    const elemBeneficiarioDB = $("#beneficiario_DB").val();
    const elemCuenta = $("#cuentaBanco").val();

    let esValido = Boolean(
        elemClabe &&
        elemBanco &&
        elemReferenciaAlfa &&
        elemBeneficiarioDB &&
        elemCuenta
    );

    const btnAgregarBancos = $("#agregar-datos-bancarios");
    btnAgregarBancos.prop("disabled", !esValido);
}

$(document).on('click', '#eliminarRepresentante', function (e) {//pasa datos al modal para desactivar el proveedor
    $('#confirmarEliminarRepresentante p').empty();
    var nombre = $(this).data("name");
    var texto = "Desea eliminar este representante: " + nombre;
    let position = $(this).data("repre")
    $('#confirmarEliminarRepresentante p').append(texto);

    if (representanteLegalMatriz.length > 0) {
        let rep = representanteLegalMatriz[position]
        $('#idRepre').val(rep.idRepre)
        $('#positionRepre').val(position)

    }
});

$('#eliminarRepre').on('click', function () {
    let idRepre = $('#idRepre').val()
    let position = $('#positionRepre').val()

    if (!idRepre && position) {
        eliminarRepresentanteTabla(position)
        limpiarInputsRepresentanteLegal()
        $('#confirmarEliminarRepresentante').modal("hide");
    }

    if (idRepre && position) {
        eliminarRepresentanteBD(idRepre)
    }
})

$(document).on('click', '#eliminarDatosBancarios', function (e) {
    $('#confirmarEliminarDatosBancarios p').empty();
    var nombreBanco = $(this).data("name");
    var texto = "Desea eliminar este banco: " + nombreBanco;
    let position = $(this).data("index")
    $('#confirmarEliminarDatosBancarios p').append(texto);

    if (datosBancariosMatriz.length > 0) {
        let rep = datosBancariosMatriz[position]
        $('#nIdCuentaBanco').val(rep.nIdCuentaBanco)
        $('#positionBancos').val(position)

    }
});

$('#eliminarBanco').on('click', function () {
    let idBanco = $('#nIdCuentaBanco').val()
    let position = $('#positionBancos').val()

    if (!idBanco && position) {
        eliminarDatosBancarios(position)
        limpiarInputsDatosBancarios()
        $('#confirmarEliminarDatosBancarios').modal("hide");
    }

    if (idBanco && position) {
        eliminarDatosBancariosBD(idBanco)
    }
})

function actualizarTablaRepresentanteLegal() {
    const tabla = $('#tabla_representante_legal tbody');
    tabla.empty();

    // Recorrer arreglo
    representanteLegalMatriz.forEach((item, index) => {
        const representante = item.representanteLegal;
        const identificacion = item.identificacion;
        const numIdentificacion = item.numeroIdentificacion;
        const boton_edit = '<button id="editarRepresentante" onclick="editarRepresentante(' + index + ');" data-placement="top" rel="tooltip" title="Editar" class="btn habilitar btn-default btn-xs" data-title="Editar"><span class="fa fa-edit"></span></button>';
        const boton_eliminar = '<button id="eliminarRepresentante" data-placement="top" rel="tooltip" title="Eliminar"  data-toggle="modal"  data-target="#confirmarEliminarRepresentante" data-repre="' + index + '" class="btn inhabilitar btn-default btn-xs" data-title="Eliminar" data-name="' + item.representanteLegal + '"><span class="fa fa-times"></span></button>'

        const fila = `<tr>
          <td>${representante}</td>
          <td>${tipoIdentificacion[identificacion]}</td>
          <td>${numIdentificacion}</td>
          <td>${boton_edit} ${boton_eliminar}</td>
        </tr>`;

        tabla.append(fila);
    });
}

function actualizarTablaDatosBancarios() {
    const tabla = $('#tabla_datos_bancarios tbody');
    tabla.empty();

    // Recorrer arreglo
    datosBancariosMatriz.forEach((item, index) => {
        const clabe = item.clabe;
        const nombreBanco = item.banco;
        const alfanumerico = item.alfanumerico;
        const cuenta = item.cuenta;
        const beneficiario = item.beneficiario;
        const boton_edit = '<button id="editarDatosBancarios" onclick="editarDatosBancarios(' + index + ');" data-placement="top" rel="tooltip" title="Editar" class="btn habilitar btn-default btn-xs" data-title="Editar"><span class="fa fa-edit"></span></button>';
        const boton_eliminar = '<button id="eliminarDatosBancarios" data-placement="top" rel="tooltip" title="Eliminar"  data-toggle="modal"  data-target="#confirmarEliminarDatosBancarios" data-index="' + index + '" class="btn inhabilitar btn-default btn-xs" data-title="Eliminar" data-name="' + item.banco + '"><span class="fa fa-times"></span></button>'

        const fila = `<tr>
          <td>${clabe}</td>
          <td>${nombreBanco}</td>
          <td>${cuenta}</td>
          <td>${alfanumerico}</td>
          <td>${beneficiario}</td>
          <td>${boton_edit} ${boton_eliminar}</td>
        </tr>`;

        tabla.append(fila);
    });
}

function agregarRepresentanteLegal() {
    const btnGuardarRepresentante = $('#btn-repr-datos');
    // Validar solo un maximo de 3
    if (representanteLegalMatriz.length >= 3 && $('#positionRepre').val() === '') {
        jAlert("No se pueden agregar más de 3 representantes.");
        limpiarInputsRepresentanteLegal();
        return;
    }

    const elemRepresentanteLegal = $('#representante_legal');
    const elemIdentificacion = $('#cmbIdentificacion');
    const elemNumeroIdentificacion = $("#numeroIdentificacion");

    // Validar los campos
    const esRepresentanteLegalValido = validarCampo(elemRepresentanteLegal);
    const esIdentificacionValido = validarCampo(elemIdentificacion);
    const esNumeroIdentificacionValido = validarCampo(elemNumeroIdentificacion);

    if (!(esRepresentanteLegalValido && esIdentificacionValido && esNumeroIdentificacionValido)) {
        return;
    }

    let representanteLegal = $('#representante_legal').val().toUpperCase();
    let identificacion = $('#cmbIdentificacion').val();
    let numeroIdentificacion = $('#numeroIdentificacion').val();
    let idRepre = $('#idRepre').val();
    let positionRepre = $('#positionRepre').val();

    let representante = {
        representanteLegal,
        identificacion,
        numeroIdentificacion,
        idRepre
    };

    // Validar si se debe actualizar o agregar
    if (positionRepre === '') {
        representanteLegalMatriz.push(representante);
    } else {
        representanteLegalMatriz[positionRepre] = representante;
    }


    limpiarInputsRepresentanteLegal();
    actualizarTablaRepresentanteLegal();
    if (representanteLegalMatriz.length < 1) {
        btnGuardarRepresentante.prop('disabled', true);
    } else {
        btnGuardarRepresentante.prop('disabled', false);
    }
}

function agregarDatosBancarios() {
    const btnGuardarDatosBancarios = $('#btn-banco-datos');
    // Validar solo un máximo de 3
    if (datosBancariosMatriz.length >= 3 && $('#positionBancos').val() === '') {
        jAlert("No se pueden agregar más de 3 bancos.");
        limpiarInputsDatosBancarios();
        return;
    }
    // Validar campos para latam
    let pais = $('#paisPago').val();
    let swift = $('#swift').val();
    let iban = $('#iban').val();
    let code = $('#code').val();

    if (pais == "" || pais == undefined || pais == "-1") {
        jAlert("País de pago requerido.");
        return
    }
    if (pais != 164) {
        if (iban == "" && swift == "" && code == "") {
            jAlert("Requerido cualquiera de estos: SWIFT, IBAN, CODE.");
            return
        }
    }


    const elemClabe = $("#clabe");
    const elemBanco = $("#banco");
    const elemReferenciaAlfa = $("#referenciaAlfa");
    const elemBeneficiarioDB = $("#beneficiario_DB");
    const elemCuenta = $("#cuentaBanco");

    let esClabeValido = validarCampo(elemClabe);
    let esBancoValido = validarCampo(elemBanco);
    let esReferenciaAlfaValido = validarCampo(elemReferenciaAlfa);
    let esBeneficiarioDBValido = validarCampo(elemBeneficiarioDB);
    let esCuentaBanco = validarCampo(elemCuenta);

    if (!(esClabeValido && esBancoValido && esReferenciaAlfaValido && esBeneficiarioDBValido && esCuentaBanco)) return;

    let clabe = $('#clabe').val().toUpperCase();
    let idBanco = $('#banco').val();
    let banco = $('#nombreBanco').val();
    let cuenta = $('#cuentaBanco').val();
    let alfanumerico = $('#referenciaAlfa').val();
    let beneficiario = $('#beneficiario_DB').val().toUpperCase();
    let nIdCuentaBanco = $('#nIdCuentaBanco').val();
    let positionBancos = $('#positionBancos').val();

    let datosBancarios = {
        clabe,
        banco,
        idBanco,
        cuenta,
        alfanumerico,
        beneficiario,
        nIdCuentaBanco,
        pais,
        swift,
        iban,
        code
    };

    // Validar si se debe actualizar o agregar
    if (positionBancos === '') {
        datosBancariosMatriz.push(datosBancarios);
    } else {
        datosBancariosMatriz[positionBancos] = datosBancarios;
    }

    limpiarInputsDatosBancarios();
    actualizarTablaDatosBancarios();
    if (datosBancariosMatriz.length < 1) {
        btnGuardarDatosBancarios.prop('disabled', true);
    } else {
        btnGuardarDatosBancarios.prop('disabled', false);
    }
}


function eliminarFila(id) { //elimina una fila de la matriz de escalamiento
    var partir = id.split("_");
    var numero_fila = partir[1];
    var fila = "fila_" + numero_fila;
    var row = document.getElementById(fila);
    var departamento = $("#departamento_" + numero_fila).val();
    var nombre = $("#nombre_" + numero_fila).val();
    var puesto = $("#puesto_" + numero_fila).val();
    var telefono = $("#telefono_" + numero_fila).val();
    var correo = $("#correo_" + numero_fila).val();
    var valor = numero_fila + "," + departamento + "," + nombre + "," + puesto + "," + telefono + "," + correo + "|";
    row.parentNode.removeChild(row);
    removerLineasMatriz(valor);
}

function RFCFormato(von) { //funcion para  el comportamiento del  texto RFC  
    var rfc = event.target.value;
    if (rfc.length > 11) {
        if ($('#cmbpais').val() == 164 & $('#rfc').val().length == 12) { //verifica el formato del rfcde la persona moral es correcto
            var rfcm = $('#rfc').val();
            if (verif_rfcm(rfcm) == false) {
                jAlert("Capture un RFC valido.");
                return false;
            } else {
                //validaExistencia(rfc,von);
                let rfc = $('#rfc').val();
                $('#referenciaAlfa').val(rfc);
                return true;
            }
        }
        if ($('#cmbpais').val() == 164 & $('#rfc').val().length < 12) {
            jAlert("Capture un RFC valido.");
            return false
        }
    }
}

function verif_rfcm(rfcs) { //verifica RFC persona Moral
    var for_rfc = /^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))/;
    if (for_rfc.test(rfcs)) {
        return true;
    } else {
        return false;
    }
}

function customLlenarComboSolicitante(id, data) {
    let length = data.length;
    let cmb = document.getElementById(id);

    for (var i = 0; i < length; i++) {
        var option = document.createElement("option");
        option.text = data[i].nombre;

        if (typeof option.textContent === 'undefined') {
            option.innerText = data[i].nombre;
        }
        else {
            option.textContent = data[i].nombre;
        }
        option.value = data[i].id;
        cmb.appendChild(option);
    }

}

function agregarProducto() {
    $("#btnOpenModal").click();
}

function guardarProducto() {
    var lack = "";
    var error = "";
    var familia = $("#familia_modal option:selected").val();
    var subfamilia = $("#subfamilia_modal option:selected").val();
    var emisor = $("#emisor_modal option:selected").val();
    var descripcion = $("#producto_descripcion").val();
    var abreviatura = $("#producto_abreviatura").val();
    var sku = $("#sku").val();
    var fechaentradavigor = $("#fecha_entrada_vigor").val();
    var fechasalidavigor = $("#fecha_salida_vigor").val();
    var flujoimporte = $("#select_flujo_importe option:selected").val();
    var importeminimoproducto = $("#importe_minimo_producto").val();
    var importemaximoproducto = $("#importe_maximo_producto").val();
    var porcentajecomisionproducto = $("#porcentaje_comision_producto").val();
    var importecomisionproducto = $("#importe_comision_producto").val();
    var porcentajecomisioncorresponsal = $("#porcentaje_comision_corresponsal").val();
    var importecomisioncorresponsal = $("#importe_comision_corresponsal").val();
    var porcentajecomisioncliente = $("#porcentaje_comision_cliente").val();
    var importecomisioncliente = $("#importe_comision_cliente").val();
    var CheckBox = new Array();
    $.each($('.check_servicios:checkbox:checked'), function (key, value) {
        CheckBox.push($(value).attr("id"));
    });
    longitudServicios = CheckBox.length;
    if (familia == undefined || familia == 0 || familia == '') { lack += 'Familia\n'; }
    if (subfamilia == undefined || subfamilia == 0 || subfamilia == '') { lack += 'Subfamilia\n'; }
    if (emisor == undefined || emisor == 0 || emisor == '') { lack += 'Emisor\n'; }
    if (descripcion == undefined || descripcion == 0 || descripcion == '') { lack += 'Descripcion\n'; }
    if (abreviatura == undefined || abreviatura == 0 || abreviatura == '') { lack += 'Abreviatura\n'; }
    if (sku == undefined || sku == 0 || sku == '') { lack += 'SKU\n'; }
    if (fechaentradavigor == undefined || fechaentradavigor == 0 || fechaentradavigor == '') { lack += 'Fecha Entrada Vigor\n'; }
    if (fechasalidavigor == undefined || fechasalidavigor == 0 || fechasalidavigor == '') { lack += 'Fecha Salida Vigor\n'; }
    if (flujoimporte == undefined || flujoimporte == '-1' || flujoimporte == '') { lack += 'Flujo Importe\n'; }
    if (importeminimoproducto == undefined || importeminimoproducto == '') { lack += 'Importe Minimo Producto\n'; }
    if (importemaximoproducto == undefined || importemaximoproducto == '') { lack += 'importe maximo producto\n'; }
    if (porcentajecomisionproducto == undefined || porcentajecomisionproducto == '') { lack += 'Porcentaje Comision Producto\n'; }
    if (importecomisionproducto == undefined || importecomisionproducto == '') { lack += 'Importe Comision Producto\n'; }
    if (porcentajecomisioncorresponsal == undefined || porcentajecomisioncorresponsal == '') { lack += 'Porcentaje Comision Corresponsal\n'; }
    if (importecomisioncorresponsal == undefined || importecomisioncorresponsal == '') { lack += 'Importe Comision Corresponsal\n'; }
    if (porcentajecomisioncliente == undefined || porcentajecomisioncliente == '') { lack += 'Porcentaje Comision Cliente\n'; }
    if (importecomisioncliente == undefined || importecomisioncliente == '') { lack += 'Importe Comision Cliente\n'; }
    if (lack != "" || error != "") {
        var black = (lack != "") ? "Los siguientes datos son Obligatorios : " : "";
        jAlert(black + '\n' + lack + '\n');
    } else {
        $.ajax({
            data: {
                tipo: 7,
                familia: familia,
                subfamilia: subfamilia,
                emisor: emisor,
                descripcion: descripcion,
                abreviatura: abreviatura,
                sku: sku,
                fechaentradavigor: fechaentradavigor,
                fechasalidavigor: fechasalidavigor,
                flujoimporte: flujoimporte,
                importeminimoproducto: importeminimoproducto,
                importemaximoproducto: importemaximoproducto,
                porcentajecomisionproducto: porcentajecomisionproducto,
                importecomisionproducto: importecomisionproducto,
                porcentajecomisioncorresponsal: porcentajecomisioncorresponsal,
                importecomisioncorresponsal: importecomisioncorresponsal,
                porcentajecomisioncliente: porcentajecomisioncliente,
                importecomisioncliente: importecomisioncliente
            },
            type: 'POST',
            url: '../ajax/altaProveedores.php',
            success: function (response) {
                var obj = jQuery.parseJSON(response);
                var mensaje = "";
                jQuery.each(obj, function (index, value) {
                    mensaje = obj['msg'];
                });
                jAlert(mensaje);
            }
        });
    }
}

function validarTelefono(elemento) {
    var texto = $("#" + elemento).val();
    var trimedo = texto.trim();
    var telefono = Number(trimedo.replace(/(?!-)[^0-9.]/g, ""));
    $("#" + elemento).val(telefono);
}

function validarCorreo(elemento) {
    var new_correo = $("#" + elemento).val();
    if (validarEmail(new_correo) == false) {
        $('#' + elemento).css('border-color', 'red');
        $('#' + elemento).css('color', 'red');
        $('[data-toggle="tooltip"]').tooltip();
        $('#' + elemento).tooltip().mouseover();
        $('#' + elemento).attr('data-original-title', 'Formato Incorrecto');
    } else {
        $('#' + elemento).css('border-color', 'green');
        $('#' + elemento).css('color', 'black');
        $('#' + elemento).tooltip().mouseout();
        $('#' + elemento).attr('data-original-title', 'Formato Correcto');
    }
}
var banderaCorreos = 0;
var banderaRepositorio = 0;

const actualizar = Object.freeze({
    'REPRESENTANTE': 0,
    'BANCO': 1,
})

const borrar = Object.freeze({
    'REPRESENTANTE': 'representante',
    'BANCO': 'banco',
})

function llenarTabla(opc, response) {
    if (opc === actualizar.REPRESENTANTE) {
        representanteLegalMatriz = [];
        llenarTablaRepresentantes(response.repre)
    } else if (opc === actualizar.BANCO) {
        datosBancariosMatriz = [];
        llenarTablaDatosBancarios(response.bancos)
    } else {
        return false
    }
}

function limpiarCampos(opc, response) {
    if (opc === borrar.REPRESENTANTE) {
        $('#eliminarRepre').prop('disabled', false);
        $('#eliminarRepre').html('Aceptar');
        $('#confirmarEliminarRepresentante').modal("hide");
        limpiarInputsRepresentanteLegal();
        representanteLegalMatriz = [];
        llenarTablaRepresentantes(response.repre)
    } else if (opc === borrar.BANCO) {
        $('#eliminarBanco').prop('disabled', false);
        $('#eliminarBanco').html('Aceptar');
        $('#confirmarEliminarDatosBancarios').modal("hide");
        limpiarInputsDatosBancarios();
        datosBancariosMatriz = [];
        llenarTablaDatosBancarios(response.bancos)
    } else {
        return false
    }
}

function enviarSolicitud(data, button, opc) {
    $.ajax({
        data: data,
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        dataType: 'json',
        beforeSend: function () {
            $(button.id).prop('disabled', true);
            $(button.id).html(button.textBefore);
            if (opc == 'representante') {
                $('#eliminarRepre').prop('disabled', true);
                $('#eliminarRepre').html('Eliminando...');
            }
            if (opc == 'banco') {
                $('#eliminarBanco').prop('disabled', true);
                $('#eliminarBanco').html('Eliminando...');
            }
        },
        success: function (response) {
            let { code, msg, secciones } = response;
            if (code === '0') {
                if (secciones) seccionesGlobal = secciones;
                if (opc == 'info') {
                    setInformacion(response);
                    validarTipo(response.datos)
                }
                if (opc == 'updateInfo') validarTipo(response.datos)
                if (opc == 'doc') setIdDocumentos(response.documentos);
                if (enviarCorreoRevision) {
                    msg = `${msg} \n Se enviara una notificacion para validar la información.`;
                    enviarCorreo();
                }
                if (opc == 'representante' || opc == 'banco') limpiarCampos(opc, response)

                if (opc === 0 || opc === 1) llenarTabla(opc, response)
                if (response.facturacion) obtenerIvaFactura(response.facturacion)
                $(button.id).html(button.textSuccess);
                jAlert(msg, 'Éxito');
            } else {
                $(button.id).html(button.textFail);
                jAlert(msg, 'Oops!');
            }

            $(button.id).prop('disabled', false);
            enableInputFiles()
        }
    });
}

function enviarCorreo() {
    $.ajax({
        data: {
            tipo: 50,
            p_proveedor: $('#p_proveedor').val(),
            p_nombre: $('#razonSocial').val()
        },
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        dataType: 'json',
        success: function (response) {
            seccionesGlobal = response.secciones;
            enviarCorreoRevision = false;
            setTimeout(function () { window.location.href = 'consulta.php'; }, 2000);
        }
    });
}

function cambiarmetodoentrega(valy) {
    if (valy == -1) {
        notifpagos = 0;
    } else {
        notifpagos = valy;
    }
}
var lineasMatriz = [];

function agregarcorreosLineaMatriz(renglon) { //agregar los correos
    var num_correos = lineasMatriz.length;
    linea = renglon;
    lineasMatriz.push(linea);
}

function removerLineasMatriz(corr) { //eliminar correos
    for (var i = 0; i < lineasMatriz.length; i++) {
        while (lineasMatriz[i] == corr)
            lineasMatriz.splice(i, 1);
    }
}

function analizarCLABE() {
    var CLABE = event.target.value;
    if (CLABE.length == 18) {
        var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
        if (CLABE_EsCorrecta) {
            $.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE }).done(function (data) {
                var banco = jQuery.parseJSON(data);
                $("#banco").val(banco.bancoID);
                $("#nombreBanco").val(banco.nombreBanco);
            });
        } else {
            alert("La CLABE escrita es incorrecta. Favor de verificarla.");
            $("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
        }
    } else {
        $("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
    }
}

function analizarCLABEZona() {
    var CLABE = event.target.value;
    if (CLABE.length == 18) {

        var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
        if (CLABE_EsCorrecta) {
            $.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE }).done(function (data) {
                var datos = jQuery.parseJSON(data);
                var codigo = datos.codigoDeRespuesta;
                if (codigo == 0) {
                    $("#clabeXZona").css('border-color', 'green');
                } else {
                    $("#clabeXZona").css('border-color', 'red');
                }
            });
        } else {
            $("#clabeXZona").css('border-color', 'red');
            alert("La CLABE escrita es incorrecta. Favor de verificarla.");
        }
    } else {
        $("#clabeXZona").css('border-color', 'red');
    }
}

function analizarCLABEred() {
    var CLABE = event.target.value;
    if (CLABE.length == 18) {
        var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
        if (CLABE_EsCorrecta) {
            $.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE }).done(function (data) {
                var banco = jQuery.parseJSON(data);
                $("#bancored").val(banco.bancoID);
                $("#nombreBancored").val(banco.nombreBanco);
            });
        } else {
            alert("La CLABE escrita es incorrecta. Favor de verificarla.");
            $("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
        }
    } else {
        $("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
    }
}

function analizarCLABE_Edicion(CLABE) {
    // var CLABE = event.target.value;
    if (CLABE.length == 18) {
        var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
        if (CLABE_EsCorrecta) {
            $.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE }).done(function (data) {
                var banco = jQuery.parseJSON(data);
                $("#banco").val(banco.bancoID);
                $("#nombreBanco").val(banco.nombreBanco);
            });
        } else {
            alert("La CLABE escrita es incorrecta. Favor de verificarla.");
            $("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
        }
    } else {
        $("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
    }
}

function analizarCLABE2_Edicion(CLABE) {
    // var CLABE = event.target.value;
    if (CLABE.length == 18) {
        var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
        if (CLABE_EsCorrecta) {
            $.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE }).done(function (data) {
                var banco = jQuery.parseJSON(data);
                $("#bancored").val(banco.bancoID);
                $("#nombreBancored").val(banco.nombreBanco);
            });
        } else {
            alert("La CLABE escrita es incorrecta. Favor de verificarla.");
            $("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
        }
    } else {
        $("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
    }
}
var contadorChecksPeriodoPPT = 0;

function validarCantidadPPT(id) {
    var lunes_long = $('.Lu_Check_ppt:checkbox:checked').length;
    var martes_long = $('.Ma_Check_ppt:checkbox:checked').length;
    var miercoles_long = $('.Mi_Check_ppt:checkbox:checked').length;
    var jueves_long = $('.Ju_Check_ppt:checkbox:checked').length;
    var viernes_long = $('.Vi_Check_ppt:checkbox:checked').length;
    contadorChecksPeriodoPPT = parseInt(lunes_long) + parseInt(martes_long) + parseInt(miercoles_long) + parseInt(jueves_long) + parseInt(viernes_long);
    if (contadorChecksPeriodoPPT > 7) {
        jAlert("El valor de dias no puede ser mayor a 7");
        $('.Lu_Check_ppt:checkbox:checked').attr('checked', false);
        $('.Ma_Check_ppt:checkbox:checked').attr('checked', false);
        $('.Mi_Check_ppt:checkbox:checked').attr('checked', false);
        $('.Ju_Check_ppt:checkbox:checked').attr('checked', false);
        $('.Vi_Check_ppt:checkbox:checked').attr('checked', false);
    }
}


function validarSeleccion(diaPago, diaChecked, id, pagos) {
    const diaSeleccionado = periodosLiquidacion.find(periodo => periodo.diaPago === diaPago);
    const mismoDiaCorte = periodosLiquidacion.find(periodo => periodo.diaCorte === id);

    if (diaSeleccionado && diaSeleccionado.diaCorte !== id) {
        jAlert(`Ya se ha seleccionado un día de corte. Solo puedes seleccionar uno.`, function () {
            $(diaChecked).prop('checked', false);
        });
    } else if (mismoDiaCorte) {
        var diaCorteId = mismoDiaCorte.diaCorte;
        var diaPagoValue = mismoDiaCorte.diaPago;

        if (diaChecked !== id) {
            $('input[type="checkbox"][id="' + diaCorteId + '"][data-dia="' + diaPagoValue + '"]').prop('checked', false);
        }

        let index = periodosLiquidacion.findIndex(periodo => periodo.diaCorte == diaCorteId && periodo.diaPago == diaPagoValue);
        if (index != -1) {
            periodosLiquidacion.splice(index, 1);
        }
        $(diaChecked[id]).prop('checked', true);
        periodosLiquidacion.push(pagos);
    } else {
        periodosLiquidacion.push(pagos);
    }
}

var contadorChecksPeriodo = 0;
var periodosLiquidacion = [];
var periodosRepetidos = {};
function validarCantidad(elem) {
    let dia = $(elem).data('dia');
    let id = $(elem).attr('id');
    let estaSeleccionado = $(elem).is(':checked');

    if (estaSeleccionado) {
        let pagos = { diaCorte: id, diaPago: dia };

        const checksLunes = $('.Lu_Check');
        const checksMartes = $('.Ma_Check');
        const checksMiercoles = $('.Mi_Check');
        const checksJueves = $('.Ju_Check');
        const checksViernes = $('.Vi_Check');

        const pagoLunes = periodosLiquidacion.find(periodo => periodo.diaPago == "Lu_Check");
        const pagoMartes = periodosLiquidacion.find(periodo => periodo.diaPago == "Ma_Check");
        const pagoMiercoles = periodosLiquidacion.find(periodo => periodo.diaPago == "Mi_Check");
        const pagoJueves = periodosLiquidacion.find(periodo => periodo.diaPago == "Ju_Check");
        const pagoViernes = periodosLiquidacion.find(periodo => periodo.diaPago == "Vi_Check");

        switch (dia) {
            case 'Lu_Check':
                validarSeleccion(pagoLunes, checksLunes, id, pagos);
                break;

            case 'Ma_Check':
                validarSeleccion(pagoMartes, checksMartes, id, pagos);
                break;


            case 'Mi_Check':
                validarSeleccion(pagoMiercoles, checksMiercoles, id, pagos);
                break;

            case 'Ju_Check':
                validarSeleccion(pagoJueves, checksJueves, id, pagos);
                break;

            case 'Vi_Check':
                validarSeleccion(pagoViernes, checksViernes, id, pagos);
                break;

            default:
                break;

        }

    } else {
        let index = periodosLiquidacion.findIndex(periodo => periodo.diaCorte == id && periodo.diaPago == dia);
        if (index != -1) {
            periodosLiquidacion.splice(index, 1);
        }
    }
}

function validarMinMax(id) {
    var max = parseInt($("#" + id).attr('max'));
    var min = parseInt($("#" + id).attr('min'));
    if ($("#" + id).val() > max) {
        $("#" + id).val(max);
    } else if ($("#" + id).val() < min) {
        $("#" + id).val(min);
    }
}

function formatoFecha(fecha) {
    let fechaFormateada = '';
    if (fecha && fecha !== '') {
        fechaFormateada = fecha.split('-').reverse().join('/');
    }

    return fechaFormateada;
}

function removerLineasProductos(corr) {
    for (var i = 0; i < lineasListaProductos.length; i++) {
        while (lineasListaProductos[i] == corr)
            lineasListaProductos.splice(i, 1);
    }
}
var lineasListaProductos = [];
function agregarlineasProductos(renglon) {
    linea = renglon;
    lineasListaProductos.push(linea);
}
var contadorListaProductos = 0;
function agregarListaProductos(id) {
    var familia = $("#select_familia option:selected").val();
    var subfamilia = $("#select_subfamilia option:selected").val();
    var producto = $("#select_productos option:selected").val();
    var importe = $("#importe_0").val();
    var descuento = $("#descuento_0").val();
    var importesindescuento = $("#importesindescuento_0").val();
    var importesiniva = $("#importesiniva_0").val();
    var familiaTexto = $("#select_familia option:selected").text();
    var subfamiliaTexto = $("#select_subfamilia option:selected").text();
    var productoTexto = $("#select_productos option:selected").text();
    if (familia > 0 && subfamilia > 0 && producto > 0 && importe > 0 && descuento > 0 && importesindescuento > 0 && importesiniva > 0) {
        contadorListaProductos++;
        var fila = "<tr class='tr_class' id='filaProducto" + contadorListaProductos + "'>" +
            "<td style='display:none;'><input type='text' id='familia_" + contadorListaProductos + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='familiaTexto_" + contadorListaProductos + "' class='form-control m-bot15' disabled></td>" +
            "<td style='display:none;'><input type='text' id='subfamilia_" + contadorListaProductos + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='subfamiliaTexto_" + contadorListaProductos + "' class='form-control m-bot15' disabled></td>" +
            "<td style='display:none;'><input type='text' id='producto_" + contadorListaProductos + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='productoTexto_" + contadorListaProductos + "' class='form-control m-bot15' disabled></td>" +
            "<td><input type='text' id='importe_" + contadorListaProductos + "' class='form-control m-bot15' disabled></td>" +
            "<td><input type='text' id='descuento_" + contadorListaProductos + "' class='form-control m-bot15' disabled></td>" +
            "<td><input type='text' id='importesindescuento_" + contadorListaProductos + "' class='form-control m-bot15' disabled></td>" +
            "<td><input type='text' id='importesiniva_" + contadorListaProductos + "' class='form-control m-bot15' disabled></td>" +
            "<td><button style='background-color:red;border-color:red;' id='row_" + contadorListaProductos + "' class='add_button btn btn-sm btn-default' onclick='eliminarFilaListaProductos(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
            "</tr>";
        $("#tabla_listaProductos").append(fila);
        $("#familia_" + contadorListaProductos + " ").val(familia);
        $("#familiaTexto_" + contadorListaProductos + " ").val(familiaTexto);
        $("#subfamilia_" + contadorListaProductos + " ").val(subfamilia);
        $("#subfamiliaTexto_" + contadorListaProductos + " ").val(subfamiliaTexto);
        $("#producto_" + contadorListaProductos + " ").val(producto);
        $("#productoTexto_" + contadorListaProductos + " ").val(productoTexto);
        $("#importe_" + contadorListaProductos + " ").val(importe);
        $("#descuento_" + contadorListaProductos + " ").val(descuento);
        $("#importesindescuento_" + contadorListaProductos + " ").val(importesindescuento);
        $("#importesiniva_" + contadorListaProductos + " ").val(importesiniva);
        $("#select_familia").val('0');
        $("#select_subfamilia").empty();
        $("#select_subfamilia").append('<option value="-1">Seleccione</option>');
        $("#select_productos").empty();
        $("#select_productos").append('<option value="-1">Seleccione</option>');
        $("#importe_0").val("");
        $("#descuento_0").val("");
        $("#importesindescuento_0").val("");
        $("#importesiniva_0").val("");
        var renglon = contadorListaProductos + "," + familia + "," + subfamilia + "," + producto + "," + importe + "," + descuento + "," + importesindescuento + "," + importesiniva + "|";
        agregarlineasProductos(renglon);

    } else {
        jAlert("Favor de ingresar todos los datos");
    }
}
function eliminarFilaListaProductos(id) {//elimina una fila de la matriz de escalamiento
    var partir = id.split("_");
    var numero_fila = partir[1];
    var fila = "filaProducto" + numero_fila;
    var row = document.getElementById(fila);
    var familia = $("#familia_" + numero_fila).val();
    var subfamilia = $("#subfamilia_" + numero_fila).val();
    var producto = $("#producto_" + numero_fila).val();
    var importe = $("#importe_" + numero_fila).val();
    var descuento = $("#descuento_" + numero_fila).val();
    var importesindescuento = $("#importesindescuento_" + numero_fila).val();
    var importesiniva = $("#importesiniva_" + numero_fila).val();
    var valor = numero_fila + "," + familia + "," + subfamilia + "," + producto + "," + importe + "," + descuento + "," + importesindescuento + "," + importesiniva + "|";
    row.parentNode.removeChild(row);
    removerLineasProductos(valor);
}
function validarEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

var lineasCCP = [];

function agregarRowsCCP(renglon) { //agregar los correos
    lineasCCP.push(renglon);
}

var lineasBP = [];

function agregarRowsBP(renglon) { //agregar los correos
    lineasBP.push(renglon);
}

var contadorFilasCCP = 0;

function agregarFilaCCP(id) {
    var familia_ccp = $("#familiaccp_0 option:selected").val();
    var subfamilia_ccp = $("#subfamiliaccp_0 option:selected").val();
    var producto_ccp = $("#productoccp_0 option:selected").val();
    var emisoresccp = $("#emisoresccp_0 option:selected").val();

    var familia_ccpText = $("#familiaccp_0 option:selected").text();
    var subfamilia_ccpText = $("#subfamiliaccp_0 option:selected").text();
    var producto_ccpText = $("#productoccp_0 option:selected").text();
    var emisoresccpText = $("#emisoresccp_0 option:selected").text();

    var cuenta_contable = $("#cuentacc_0").val();
    var validanumerosCC = (cuenta_contable.replace(/[^0-9]/g, "").length);
    var tipo_credito = $("#select_credito_prepago_0 option:selected").val();
    var tipo_creditoText = $("#select_credito_prepago_0 option:selected").text();

    var comercio = $("#select_comercio_0 option:selected").val();
    var comercioText = $("#select_comercio_0 option:selected").text();

    if (familia_ccp.length > 0 && subfamilia_ccp != undefined && producto_ccp != undefined && validanumerosCC >= 11 &&
        tipo_credito != undefined && comercio > 0) {
        contadorFilasCCP++;
        var fila = "<tr class='tr_classCC' id='filaccp_" + contadorFilasCCP + "'>" +
            "<td class='disabledbutton' style='display:none;'><input type='text' id='familiaccp_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='familiaccpText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton' style='display:none;'><input type='text' id='subfamiliaccp_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='subfamiliaccpText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton' style='display:none;'><input type='text' id='emisoresccp_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='emisoresccpText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton' style='display:none;'><input type='text' id='productoccp_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='productoccpText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='cuentacc_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton' style='display:none;'><input type='text' id='creditoprepago_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='creditoprepagoText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton' style='display:none;'><input type='text' id='comercio_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='comercioText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
            "<td><button style='background-color:red;border-color:red;' id='rowccp_" + contadorFilasCCP + "' class='add_button btn btn-sm btn-default' onclick='eliminarFilaCCP(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
            "</tr>";
        $("#tabla_ccp").append(fila);
        $("#familiaccp_" + contadorFilasCCP + " ").val(familia_ccp);
        $("#familiaccpText_" + contadorFilasCCP).val(familia_ccpText);
        $("#subfamiliaccp_" + contadorFilasCCP + " ").val(subfamilia_ccp);
        $("#subfamiliaccpText_" + contadorFilasCCP + " ").val(subfamilia_ccpText);
        $("#emisoresccp_" + contadorFilasCCP + " ").val(emisoresccp);
        $("#emisoresccpText_" + contadorFilasCCP + " ").val(emisoresccpText);
        $("#productoccp_" + contadorFilasCCP + " ").val(producto_ccp);
        $("#productoccpText_" + contadorFilasCCP + " ").val(producto_ccpText);
        $("#cuentacc_" + contadorFilasCCP + " ").val(cuenta_contable);
        $("#creditoprepagoText_" + contadorFilasCCP + " ").val(tipo_creditoText);
        $("#creditoprepago_" + contadorFilasCCP + " ").val(tipo_credito);
        $("#comercioText_" + contadorFilasCCP + " ").val(comercioText);
        $("#comercio_" + contadorFilasCCP + " ").val(comercio);
        $("#familiaccp_0").val(0);
        $("#subfamiliaccp_0").val(0);
        $("#productoccp_0").val(0);
        $("#cuentacc_0").val("");

        $("#select_credito_prepago_0").val(1);
        $("#select_comercio_0").val(0);

        var renglon = contadorFilasCCP + "," + familia_ccp + "," + subfamilia_ccp + "," + producto_ccp + "," + cuenta_contable + "," + tipo_credito + "," + comercio + "|";
        agregarRowsCCP(renglon);
    } else {
        jAlert("Favor de ingresar todos los datos");
    }
}


function agregarFilaCCPEdicion(idFam, descFam, idSub, descSub, idProd, descProd, cuenta, idTipoCredito, descTipoCredito, idCadena, descCadena) {

    contadorFilasCCP++;
    var fila = "<tr class='tr_classCC' id='filaccp_" + contadorFilasCCP + "'>" +
        "<td class='disabledbutton' style='display:none;'><input type='text' id='familiaccp_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton'><input type='text' id='familiaccpText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton' style='display:none;'><input type='text' id='subfamiliaccp_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton'><input type='text' id='subfamiliaccpText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton' style='display:none;'><input type='text' id='productoccp_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton'><input type='text' id='productoccpText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton'><input type='text' id='cuentacc_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton' style='display:none;'><input type='text' id='creditoprepago_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton'><input type='text' id='creditoprepagoText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton' style='display:none;'><input type='text' id='comercio_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td class='disabledbutton'><input type='text' id='comercioText_" + contadorFilasCCP + "' class='form-control m-bot15'></td>" +
        "<td><button style='background-color:red;border-color:red;' id='rowccp_" + contadorFilasCCP + "' class='add_button btn btn-sm btn-default' onclick='eliminarFilaCCP(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
        "</tr>";

    $("#tabla_ccp").append(fila);
    $("#familiaccp_" + contadorFilasCCP + " ").val(idFam);
    $("#familiaccpText_" + contadorFilasCCP).val(descFam);
    $("#subfamiliaccp_" + contadorFilasCCP + " ").val(idSub);
    $("#subfamiliaccpText_" + contadorFilasCCP + " ").val(descSub);
    $("#productoccp_" + contadorFilasCCP + " ").val(idProd);
    $("#productoccpText_" + contadorFilasCCP + " ").val(descProd);
    $("#cuentacc_" + contadorFilasCCP + " ").val(cuenta);

    $("#creditoprepagoText_" + contadorFilasCCP + " ").val(descTipoCredito);
    $("#creditoprepago_" + contadorFilasCCP + " ").val(idTipoCredito);
    $("#comercioText_" + contadorFilasCCP + " ").val(descCadena);
    $("#comercio_" + contadorFilasCCP + " ").val(idCadena);

    $("#familiaccp_0").val(0);
    $("#subfamiliaccp_0").val(0);
    $("#productoccp_0").val(0);
    $("#cuentacc_0").val("");

    var renglon = contadorFilasCCP + "," + idFam + "," + idSub + "," + idProd + "," + cuenta + "|";
    agregarRowsCCP(renglon);
}

function eliminarFilaCCP(id) { //elimina una fila de la matriz de escalamiento
    var partir = id.split("_");
    var numero_fila = partir[1];
    var fila = "filaccp_" + numero_fila;
    var row = document.getElementById(fila);
    var familia = $("#familiaccp_" + numero_fila).val();
    var subfamilia = $("#subfamiliaccp_" + numero_fila).val();
    var producto = $("#productoccp_" + numero_fila).val();
    var cuenta = $("#cuentacc_" + numero_fila).val();
    var tipo_credito = $("#creditoprepago_" + numero_fila).val();
    var comercio = $("#comercio_" + numero_fila).val();

    var valor = numero_fila + "," + familia + "," + subfamilia + "," + producto + "," + cuenta + "," + tipo_credito + "," + comercio + "|";
    row.parentNode.removeChild(row);
    removerLineasCCP(valor);
}

function removerLineasCCP(corr) { //eliminar correos
    for (var i = 0; i < lineasCCP.length; i++) {
        while (lineasCCP[i] == corr)
            lineasCCP.splice(i, 1);
    }
}


var banderaTipo = 0;

var ccIngresosVisible = true;
var ccCostosVisible = true;

function validarTipo(datos, periodos) {
    $("#div_tipo_proveedorVS").css("display", "block");
    if (datos.nEnviaReporte === 0) $('#checkEnviaCS').prop('checked', true);

    if (datos.nTipoLiquidacion == 1 && datos.nCobroTransferencia !== 1) { //T+ndias
        $("#divporperiodos, #txtcostotrans").css("display", "none");
    } else if (datos.nCobroTransferencia == 1) {
        $('#monto_transferencia').prop('checked', true);
        $("#txtcostotrans").css('display', 'block');
        $('#divcostotrans').css('display', 'block');
        $('#txtcostotrans').val(datos.nImporteTransferencia);
        $('#txtCantTrans').val(datos.nCantidadTransferencia);
    }

    $("#div_tipo_proveedorTA").css("display", "block");

    $("#h4_liquidacion_servicios").css("display", "block");
    $("#h4_liquidacion_TA").css("display", "none");

    $("#facturacion_VSTA").css("display", "block");
    $("#div_cc_ingresos").css("display", "block");
    $("#div_cc_costos").css("display", "block");

    if (datos.nTipoLiquidacion == 1) { //T+ndias
        $("#tn_dias").val(datos.nTndias);
        $("#divTndias").css("display", "block");
    }

    if (datos.nTipoLiquidacion == 2) { //por periodo
        $("#divTndias").css("display", "none");
        $("#divEspecial").css('display', 'none');

        if (periodos !== undefined && periodos.length > 0) {
            periodos.forEach(x => {
                if (x.sDiasPago !== '-1') {
                    periodosLiquidacion.push({ diaCorte: x.nDiaCorte, diaPago: valoresPeriodo[x.sDiasPago] });
                }
            })
            const checksLunes = $('.Lu_Check');
            const checksMartes = $('.Ma_Check');
            const checksMiercoles = $('.Mi_Check');
            const checksJueves = $('.Ju_Check');
            const checksViernes = $('.Vi_Check');

            const pagoLunes = periodos.filter(periodo => periodo.sDiasPago == 0);
            const pagoMartes = periodos.filter(periodo => periodo.sDiasPago == 1);
            const pagoMiercoles = periodos.filter(periodo => periodo.sDiasPago == 2);
            const pagoJueves = periodos.filter(periodo => periodo.sDiasPago == 3);
            const pagoViernes = periodos.filter(periodo => periodo.sDiasPago == 4);

            pagoLunes.forEach(lunes => {
                $(checksLunes[lunes.nDiaCorte]).attr('checked', true);
            });

            pagoMartes.forEach(Martes => {
                $(checksMartes[Martes.nDiaCorte]).attr('checked', true);
            });

            pagoMiercoles.forEach(Miercoles => {
                $(checksMiercoles[Miercoles.nDiaCorte]).attr('checked', true);
            });

            pagoJueves.forEach(jueves => {
                $(checksJueves[jueves.nDiaCorte]).attr('checked', true);
            });

            pagoViernes.forEach(viernes => {
                $(checksViernes[viernes.nDiaCorte]).attr('checked', true);
            });
        }

        $("#divporperiodos").css("display", "block");
    }

    if (datos.nTipoLiquidacion == 4) {
        $("#divTndias, #divporperiodos").css('display', 'none');
        $(`#especial_select_dias option[value='${datos.nDiaPago}'`).prop('selected', true);
        $("#especial_dias").val(datos.nDiasAtras);
        $("#divEspecial").css('display', 'block');
    }

    if ((datos.nTipoLiquidacion == -1) && (datos.nTipoLiquidacion == 0)) {
        $("#divTndias").css('display', 'none');
        $("#divporperiodos").css('display', 'none');
        $("#divEspecial").css('display', 'none');
    }

    habilitar_transferencia($('#monto_transferencia')[0]);
}


function enviarTipo() {
    banderaTipo = 1;

    if ($('#radio_venta_servicios').is(':checked')) {
        CheckTipoProveedor = "VS";
    }

    if ($('#radio_recarga').is(':checked')) {
        CheckTipoProveedor = "TA";
    }

    if ($('#radio_servicio_recarga').is(':checked')) {
        CheckTipoProveedor = "AMBAS";
    }
}






var banderaSubTipo = 0;
var checkTipoCredito;

function validarSubTipo() {
    if ($('#radio_prepago').is(':checked')) {
        banderaSubTipo = 1;
        $("#div_opciones_credito").hide();
        checkTipoCredito = "PREPAGO";
    }
    if ($('#radio_credito').is(':checked')) {
        banderaSubTipo = 1;
        $("#div_opciones_credito").show();
        checkTipoCredito = "CREDITO";
    }
}

var tipoProveedor = "";
var tipoProdServicio = "";

var CheckTipoProveedor = "";

function validarProveedor() {
    tipoProveedor = "";
    tipoProdServicio = "";
    if ($('#ctetipo').is(':checked')) {
        tipoProveedor = "Proveedor";
        // $("#div_tipos").show();
        // $("#radio_venta_servicios").attr('checked', false);
        // $("#radio_recarga").attr('checked', false);
        $("#div_titulo_datos_bancarios_red").hide();
        $("#datos_bancarios_red").hide();
        // $("#div_contrato").hide();
        $("#div_tipo_proveedorPT").hide();
        // $("#timeout_PPT").hide();
        $("#div_cc_ingresos").show();
        $("#div_cc_costos").show();
    }
    if ($('#ctetipo3').is(':checked')) {
        tipoProveedor = "Integrador";
        // $("#div_tipos").show();
        // $("#radio_venta_servicios").attr('checked', false);
        // $("#radio_recarga").attr('checked', false);
        $("#div_titulo_datos_bancarios_red").hide();
        $("#datos_bancarios_red").hide();
        // $("#div_contrato").hide();
        $("#div_tipo_proveedorPT").hide();
        // $("#timeout_PPT").hide();
        $("#div_cc_ingresos").show();
        $("#div_cc_costos").show();
    }

    // $("#h4_liquidacion").html("<span><i class='fa fa-gear'></i></span> Liquidación " + tipoProveedor + " " + tipoProdServicio);
}


var contadorFilasBP = 0;

function agregarFilaBancoPref(id) {
    var banco_preferente = $("#selectbancopreferente_0 option:selected").val();
    var banco_preferenteText = $("#selectbancopreferente_0 option:selected").text();

    var tipo_cuota_preferente = $("#selecttipocuotapreferente_0 option:selected").val();
    var tipo_cuota_preferenteText = $("#selecttipocuotapreferente_0 option:selected").text();

    var porcentaje = $("#porcentajebancopreferente_0").val();


    if (banco_preferente > 0 && tipo_cuota_preferente > 0 && porcentaje.length > 0) {
        contadorFilasBP++;
        var fila = "<tr class='tr_classBP' id='filabp_" + contadorFilasBP + "'>" +
            "<td class='disabledbutton' style='display:none;'><input type='text' id='bancopreferente_" + contadorFilasBP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='bancopreferenteText_" + contadorFilasBP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton' style='display:none;'><input type='text' id='tipocuotapreferente_" + contadorFilasBP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='tipocuotapreferenteText_" + contadorFilasBP + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='porcentajepreferente_" + contadorFilasBP + "' class='form-control m-bot15'></td>" +
            "<td><button style='background-color:red;border-color:red;' id='rowbp_" + contadorFilasBP + "' class='add_button btn btn-sm btn-default' onclick='eliminarFilaBP(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
            "</tr>";
        $("#tablaBP").append(fila);

        $("#bancopreferente_" + contadorFilasBP + " ").val(banco_preferente);
        $("#bancopreferenteText_" + contadorFilasBP).val(banco_preferenteText);
        $("#tipocuotapreferente_" + contadorFilasBP + " ").val(tipo_cuota_preferente);
        $("#tipocuotapreferenteText_" + contadorFilasBP).val(tipo_cuota_preferenteText);
        $("#porcentajepreferente_" + contadorFilasBP).val(porcentaje);

        $("#selectbancopreferente_0").val(1);
        $("#selecttipocuotapreferente_0").val(1);
        $("#porcentajebancopreferente_0").val("");


        var renglon = contadorFilasBP + "," + banco_preferente + "," + tipo_cuota_preferente + "," + porcentaje + "|";
        agregarRowsBP(renglon);
    } else {
        jAlert("Favor de ingresar todos los datos");
    }
}


function eliminarFilaBP(id) { //elimina una fila de la matriz de escalamiento
    var partir = id.split("_");
    var numero_fila = partir[1];
    var fila = "filabp_" + numero_fila;
    var row = document.getElementById(fila);
    var banco_pref = $("#bancopreferente_" + numero_fila).val();
    var tipo_cuota = $("#tipocuotapreferente_" + numero_fila).val();
    var porcentaje = $("#porcentajepreferente_" + numero_fila).val();

    var valor = numero_fila + "," + banco_pref + "," + tipo_cuota + "," + porcentaje + "|";
    row.parentNode.removeChild(row);
    removerLineasBP(valor);
}

function removerLineasBP(corr) { //eliminar correos
    for (var i = 0; i < lineasBP.length; i++) {
        while (lineasBP[i] == corr)
            lineasBP.splice(i, 1);
    }
}

function habilitarDivMontoCobroPagoTransfer() {
    var checkCobroPagoTransfer = $("#cobran_pago_transferencia:checked").val();
    if (checkCobroPagoTransfer == undefined) {
        $("#label_mpt").hide();
        $("#monto_pago_transferencia").hide();
        $("#div_factura_comision_transferencia").hide();
    } else {
        $("#label_mpt").show();
        $("#monto_pago_transferencia").show();
        $("#div_factura_comision_transferencia").show();
    }
}


function habilitarDivFondoReserva() {
    var checkfondo_reserva = $("#fondo_reserva:checked").val();
    if (checkfondo_reserva == undefined) {
        $("#div_datos_fondo_reserva").hide();
    } else {
        $("#div_datos_fondo_reserva").show();
    }
}

var correosTimeOutEntrega = [];

function agregarcorreosTimeOutEntrega() { //agregar los correos
    var num_correos = correosTimeOutEntrega.length;
    if (num_correos < 50) {
        new_correo = $('#nuevocorreoentrega').val();
        if (validarEmail(new_correo) == false) {
            jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique');
            return;
        } else {
            correosTimeOutEntrega.push(new_correo);
            var html = "<div class='col-xs-12 formCorreosEntrega'>";
            html += "<input type='text' id='camposCorreosEntrega' class='form-control m-bot15 lecturaCorreosEntrega' name='correosFacturasEntrega' value='" + new_correo + "' style='width: 300px; display:inline-block;' disabled>";
            html += "<button  style='margin-left:3px;background-color:red;color:white' class='remove_button lecturaCorreosEntrega btn btn-sm inhabilitar' id='removeCorreosEntrega'  value='" + new_correo + "' onclick='removercorreoTimeOutEntrega(this.value);'>";
            html += "<i class='fa fa-minus-circle' aria-hidden='true'></i></button></div>";
            $('#contenedordecorreosentrega').append(html);
            $('#nuevocorreoentrega').val('');
        }
    } else {
        if (num_correos = 49) {
            $('#nuevocorreoentrega').attr('disabled', true);
            $('#nuevocorreoentrega').val('');
        }
        jAlert('Solo puede Agregar 50 Correos');
    }
}

function removercorreoTimeOutEntrega(corr) { //eliminar correos
    for (var i = 0; i < correosTimeOutEntrega.length; i++) {
        while (correosTimeOutEntrega[i] == corr)
            correosTimeOutEntrega.splice(i, 1);
    }
    $('#contenedordecorreosentrega').empty();
    for (var i = 0; i < correosTimeOutEntrega.length; i++) {
        $('#contenedordecorreosentrega').append('<div class="col-xs-12 formCorreosEntrega" ><input type="text" id="camposCorreosEntrega" class="form-control m-bot15 lecturaCorreosEntrega" name="correosFacturasEntrega" value="' + correosTimeOutEntrega[i] + '" style="width: 300px; display:inline-block;" disabled><button  class="remove_button lecturaCorreosEntrega btn btn-sm inhabilitar" id="removeCorreosEntrega" style="margin-left:3px;background-color:red;color:white" value="' + correosTimeOutEntrega[i] + '" onclick="removercorreoTimeOutEntrega(this.value);"> <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    }
    if (correosTimeOutEntrega.length < 50) {
        $('#nuevocorreoentrega').attr('disabled', false);
        $('#nuevocorreoentrega').val('');
    }
}
//seccion del wizard

$(document).ready(function () {
    $("#checkEnviaCS").click(function () {
        var valor = $("#checkEnviaCS").prop('checked');
        if (valor == true) {//set periodos as default
            $("#dias_liquidacion option[value='2']").prop('selected', true).trigger('change');
            $("#dias_liquidacion").prop('disabled', 'disabled');
        } else {
            $("#dias_liquidacion").prop('disabled', false);
        }
    });

    $("#checkEnviaPCT").click(function () {
        var valor = $("#checkEnviaPCT").prop('checked');
        if (valor == true) {//set periodos as default
            $("#dias_liquidacion_ppt option[value='2']").prop('selected', true).trigger('change');
            $("#dias_liquidacion_ppt").prop('disabled', 'disabled');
        } else {
            $('#dias_liquidacion_ppt').prop('disabled', false);
        }
    });


    $("#checkEntidad").click(function () {
        var valorZona = $("#checkEntidad").prop('checked');

        if (valorZona == true) {
            // if ($('#ctetipo4').is(':checked')) {
            //     $("#datos_bancarios_proveedor_zona").show();
            //     $("#datos_bancarios_proveedor").hide();
            //     $("#div_titulo_datos_bancarios_red").hide();
            //     $("#datos_bancarios_red").hide();
            // } else {
            $("#datos_bancarios_proveedor").hide();
            $("#datos_bancarios_proveedor_zona").show();
            // }
        } else {
            // if ($('#ctetipo4').is(':checked')) {
            //     $("#datos_bancarios_proveedor_zona").hide();
            //     $("#datos_bancarios_proveedor").show();
            //     $("#div_titulo_datos_bancarios_red").show();
            //     $("#datos_bancarios_red").show();
            // } else {
            $("#datos_bancarios_proveedor").show();
            $("#datos_bancarios_proveedor_zona").hide();
            // }
        }
    });
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    // Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);

        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $("#btn-informacion").click(function () {
        var tipoCliente;
        let esProveedorValido = false;

        if (tipoProveedor == "Proveedor") {
            tipoCliente = 0;
            esProveedorValido = true;
        }
        if (tipoProveedor == "Integrador") {
            tipoCliente = 1;
            esProveedorValido = true;
        }

        var tipoVenta = 0;
        let esTipoValido = false;
        if (CheckTipoProveedor == "VS") {
            tipoVenta = 1;
            esTipoValido = true;
        }

        if (CheckTipoProveedor == "TA") {
            tipoVenta = 2;
            esTipoValido = true;
        }

        if (CheckTipoProveedor == "AMBAS") {
            tipoVenta = 3;
            esTipoValido = true;
        }

        const elemSolicitante = $('#cmbSolicitante');
        const elemRfc = $('#rfc');
        const elemRazonSocial = $('#razonSocial');
        const elemRegimenSocietario = $('#regimenSocietario');
        const elemNombreComercial = $('#nombreComercial');
        const elemPais = $('#cmbpais');
        const elemFechaConstitutiva = $('#fecha-constitutiva');
        const elemRegimenFiscal = $('#cmbRegimenFiscal');
        const elemCalle = $('#txtCalle');
        const elemExt = $('#ext');
        const elemInt = $('#int');
        const elemCodigoPostal = $('#txtCP');
        const elemCmbColonia = $('#cmbColonia');
        const elemCmbCiudad = $('#cmbCiudad');
        const elemCmbEstado = $('#cmbEntidad');
        const elemTxtColonia = $('#txtColonia');
        const elemTxtCiudad = $('#txtCiudad');
        const elemTxtEstado = $('#txtEstado');
        const elemErrorProveedor = $('#error-proveedor');
        const elemErrorTipo = $('#error-tipo');
        const elemGiro = $('#cmbGiro');

        let esSolicitanteValido = validarCampo(elemSolicitante);
        let esRfcValido = validarCampo(elemRfc);
        let esRazonSocialValido = validarCampo(elemRazonSocial);
        let esRegimenSocietarioValido = validarCampo(elemRegimenSocietario);
        let esNombreComercialValido = validarCampo(elemNombreComercial);
        let esPaisValido = validarCampo(elemPais);
        let esFechaConstitutivaValido = validarCampo(elemFechaConstitutiva);
        let esRegimenFiscalValido = validarCampo(elemRegimenFiscal);
        let esGiroValido = validarCampo(elemGiro);
        let esCalleValido = validarCampo(elemCalle);
        let esNumeroExteriorValido = validarCampo(elemExt);
        // let esNumeroInterValido             = validarCampo(elemInt);
        let esCodigoPostalValido = validarCampo(elemCodigoPostal);
        let esCmbColoniaValido = validarCampo(elemCmbColonia);
        let esCmbCiudadValido = validarCampo(elemCmbCiudad);
        let esCmbEstadoValido = validarCampo(elemCmbEstado);
        let esTxtColoniaValido = validarCampo(elemTxtColonia);
        let esTxtCiudadValido = validarCampo(elemTxtCiudad);
        let esTxtEstadoValido = validarCampo(elemTxtEstado);

        esProveedorValido ? showSuccess(elemErrorProveedor, false) : showError(elemErrorProveedor, 'El campo es requerido', false);
        esTipoValido ? showSuccess(elemErrorTipo, false) : showError(elemErrorTipo, 'El campo es requerido', false);

        let pais = elemPais.val();
        let esValido = false;
        // Validad informacion para Mexico
        if (esProveedorValido && esTipoValido && esSolicitanteValido && esRfcValido && esRazonSocialValido && esRegimenSocietarioValido && esNombreComercialValido &&
            esFechaConstitutivaValido && esRegimenFiscalValido && esGiroValido && esCalleValido && esNumeroExteriorValido && esCodigoPostalValido &&
            esPaisValido && (pais == 164) && esCmbColoniaValido && esCmbCiudadValido && esCmbEstadoValido) {
            esValido = true;
        }

        // Validad informacion Internacional
        if (esProveedorValido && esTipoValido && esSolicitanteValido && esRfcValido && esRazonSocialValido && esRegimenSocietarioValido && esNombreComercialValido &&
            esFechaConstitutivaValido && esRegimenFiscalValido && esGiroValido && esCalleValido && esNumeroExteriorValido && esCodigoPostalValido &&
            esPaisValido && (pais != 164) && esTxtColoniaValido && esTxtCiudadValido && esTxtEstadoValido) {
            esValido = true;
        }

        if (esValido) {
            const data = {
                p_tipoCliente: tipoCliente,
                p_tipoVenta: tipoVenta,
                p_solicitante: elemSolicitante.val().trim(),
                p_fechaConstitutiva: elemFechaConstitutiva.val().trim(),
                p_rfc: elemRfc.val().trim(),
                p_razonSocial: elemRazonSocial.val().trim(),
                p_nombreComercial: elemNombreComercial.val().trim(),
                p_regimenSocietario: elemRegimenSocietario.val().trim(),
                p_regimenFiscal: elemRegimenFiscal.val().trim(),
                p_giro: elemGiro.val().trim() ?? 0,
                p_cmbpais: pais,
                p_txtCalle: elemCalle.val().trim(),
                p_ext: elemExt.val().trim(),
                p_int: elemInt.val().trim(),
                p_txtCP: elemCodigoPostal.val().trim(),
                p_cmbColonia: pais === '164' ? elemCmbColonia.val().trim() : '',
                p_cmbCiudad: pais === '164' ? elemCmbCiudad.val().trim() : '',
                p_cmbEntidad: pais === '164' ? elemCmbEstado.val().trim() : '',
                p_txtColonia: elemTxtColonia.val().trim(),
                p_txtCiudad: elemTxtCiudad.val().trim(),
                p_txtEstado: elemTxtEstado.val().trim(),
                p_nIdSerie: 1,
                p_sSerie: "A",
                p_unidadNegocio: 1
            }

            if (seccionesGlobal.bSeccion1 && (seccionesGlobal.bSeccion1 == 1)) {
                data.p_proveedor = $('#p_proveedor').val();
                data.tipo = 35;
                btnActualizar.id = '#btn-informacion';
                enviarSolicitud(data, btnActualizar, 'updateInfo');
            } else {
                data.tipo = 31;
                btnGuardar.id = '#btn-informacion';
                enviarSolicitud(data, btnGuardar, 'info');
            }
        }
    });

    $('#btn-repr-datos').click(function () {
        let tipoCliente = 0;
        if ($('#ctetipo3').is(':checked')) tipoCliente = 1;
        let proveedor = $('#p_proveedor').val();

        let data = {
            p_proveedor: proveedor,
            p_tipoCliente: tipoCliente,
            p_representanteLegal: $('#representante_legal').val().trim(),
            p_identificacion: $('#cmbIdentificacion').val(),
            p_numIdentificacion: $("#numeroIdentificacion").val().trim(),
        };

        if (seccionesGlobal.bSeccion2 && (seccionesGlobal.bSeccion2 == 1)) {
            data.tipo = 33;
            let updateRepresentanteLegal = representanteLegalMatriz.filter((valor, indice, self) => {
                const representanteDuplicado = self.findIndex(r => r.representanteLegal === valor.representanteLegal) !== indice;
                return !representanteDuplicado;
            });

            data.p_lineasMatriz = updateRepresentanteLegal;
            btnActualizar.id = '#btn-repr-datos';
            enviarSolicitud(data, btnActualizar, actualizar.REPRESENTANTE)
        } else {
            data.tipo = 33;
            data.p_lineasMatriz = representanteLegalMatriz;
            btnGuardar.id = '#btn-repr-datos';
            enviarSolicitud(data, btnGuardar, actualizar.REPRESENTANTE);
        }
    });

    $('#btn-banco-datos').click(function () {
        let proveedor = $('#p_proveedor').val();
        let rfc = $('#rfc').val();

        let data = {
            p_proveedor: proveedor,
            p_valorZona: $("#checkEntidad").is(':checked'),
            p_rfc: rfc,
        };

        data.p_lineasMatriz = datosBancariosMatriz

        if (seccionesGlobal.bSeccion2 && (seccionesGlobal.bSeccion2 == 1)) {
            data.tipo = 52;
            data.p_lineasMatriz = datosBancariosMatriz;
            btnActualizarBanco.id = '#btn-banco-datos';
            enviarSolicitud(data, btnActualizarBanco, actualizar.BANCO)
        } else {
            data.tipo = 52;
            data.p_lineasMatriz = datosBancariosMatriz;
            btnGuardarBanco.id = '#btn-banco-datos';
            enviarSolicitud(data, btnGuardarBanco, actualizar.BANCO);
        }
    });

    $('#btn-documentos').click(function () {
        var inputActa = $("#urlActa").val();
        var inputContrato = $("#urlContrato").val();
        var inputRfc = $("#urlRFC").val();
        var inputDomicilio = $("#urlDomicilio").val();
        var inputRepresentanteLegal = $("#urlRepre").val();

        if ((inputActa.length > 0) && (inputContrato.length > 0) && (inputRfc.length > 0) && (inputDomicilio.length > 0) && (inputRepresentanteLegal.length > 0)) {
            disableInputFiles()
            $('#btn-documentos').prop('disabled', true);
            $('#btn-documentos').html('Subiendo Archivos');
            uploadFile(function () {

                const p_proveedor = $('#p_proveedor').val();
                var urlActa = $("#urlActa").val();
                var urlContrato = $("#urlContrato").val();
                var urlRfc = $("#urlRFC").val();
                var urlDomicilio = $("#urlDomicilio").val();
                var urlRepresentanteLegal = $("#urlRepre").val();
                var urlPoderLegal = $("#urlPoder").val();
                var urlAdendo1 = $("#urlAdendo1").val();
                var urlAdendo2 = $("#urlAdendo2").val();

                let splitActa = urlActa.split('/');
                let rutaActa = `${splitActa[0]}/${splitActa[1]}/`;
                let docActa = splitActa[2];

                let splitContrato = urlContrato.split('/');
                let rutaContrato = `${splitContrato[0]}/${splitContrato[1]}/`;
                let docContrato = splitContrato[2];

                let splitRfc = urlRfc.split('/');
                let rutaRfc = `${splitRfc[0]}/${splitRfc[1]}/`;
                let docRfc = splitRfc[2];

                let splitDomicilio = urlDomicilio.split('/');
                let rutaDomicilio = `${splitDomicilio[0]}/${splitDomicilio[1]}/`;
                let docDomicilio = splitDomicilio[2];

                let splitRepresLegal = urlRepresentanteLegal.split('/');
                let rutaRepresentanteLegal = `${splitRepresLegal[0]}/${splitRepresLegal[1]}/`;
                let docRepresentanteLegal = splitRepresLegal[2];

                const data = {
                    p_proveedor: p_proveedor,
                    p_rutaActa: rutaActa,
                    p_docNombreActa: docActa,
                    p_rutaContrato: rutaContrato,
                    p_docNombreContrato: docContrato,
                    p_rutaRfc: rutaRfc,
                    p_docNombreRfc: docRfc,
                    p_rutaDomicilio: rutaDomicilio,
                    p_docNombreDomicilio: docDomicilio,
                    p_rutaRepreLegal: rutaRepresentanteLegal,
                    p_docNombreRepreLegal: docRepresentanteLegal,
                    p_rutaPoderLegal: '',
                    p_docNombrePoderLegal: '',
                    p_rutaAdendo1: '',
                    p_docNombreAdendo1: '',
                    p_rutaAdendo2: '',
                    p_docNombreAdendo2: ''
                };

                if (urlPoderLegal.length > 0) {
                    let splitPoderLegal = urlPoderLegal.split('/');
                    let rutaPoderLegal = `${splitPoderLegal[0]}/${splitPoderLegal[1]}/`;
                    let docPoderLegal = splitPoderLegal[2];

                    data.p_rutaPoderLegal = rutaPoderLegal;
                    data.p_docNombrePoderLegal = docPoderLegal;
                }

                if (urlAdendo1.length > 0) {
                    let splitAdendo1 = urlAdendo1.split('/');
                    let rutaAdendo1 = `${splitAdendo1[0]}/${splitAdendo1[1]}/`;
                    let docAdendo1 = splitAdendo1[2];

                    data.p_rutaAdendo1 = rutaAdendo1;
                    data.p_docNombreAdendo1 = docAdendo1;
                }

                if (urlAdendo2.length > 0) {
                    let splitAdendo2 = urlAdendo2.split('/');
                    let rutaAdendo2 = `${splitAdendo2[0]}/${splitAdendo2[1]}/`;
                    let docAdendo2 = splitAdendo2[2];

                    data.p_rutaAdendo2 = rutaAdendo2;
                    data.p_docNombreAdendo2 = docAdendo2;
                }

                if (seccionesGlobal.bSeccion3 && (seccionesGlobal.bSeccion3 == 1)) {
                    data.tipo = 36;
                    data.p_tipoDocActa = $('#urlActa').attr('data-acta') ? $('#urlActa').attr('data-acta') : 0;
                    data.p_tipoDocContrato = $('#urlContrato').attr('data-contrato') ? $('#urlContrato').attr('data-contrato') : 0;
                    data.p_tipoDocRfc = $('#urlRFC').attr('data-rfc') ? $('#urlRFC').attr('data-rfc') : 0;
                    data.p_tipoDocDomicilio = $('#urlDomicilio').attr('data-domicilio') ? $('#urlDomicilio').attr('data-domicilio') : 0;
                    data.p_tipoDocRepreLegal = $('#urlRepre').attr('data-repre-legal') ? $('#urlRepre').attr('data-repre-legal') : 0;
                    data.p_tipoDocPoderLegal = $('#urlPoder').attr('data-poder-legal') ? $('#urlPoder').attr('data-poder-legal') : 0;
                    data.p_tipoDocAdendo1 = $('#urlAdendo1').attr('data-adendo1') ? $('#urlAdendo1').attr('data-adendo1') : 0;
                    data.p_tipoDocAdendo2 = $('#urlAdendo2').attr('data-adendo2') ? $('#urlAdendo2').attr('data-adendo2') : 0;

                    btnActualizar.id = '#btn-documentos';
                    enviarSolicitud(data, btnActualizar);
                    const info = {
                        tipo: 34,
                        p_proveedor: p_proveedor
                    }

                    buscarInformacionProvedor(info);
                } else {
                    data.tipo = 36;
                    data.p_tipoDocActa = 0;
                    data.p_tipoDocContrato = 0;
                    data.p_tipoDocRfc = 0;
                    data.p_tipoDocDomicilio = 0;
                    data.p_tipoDocRepreLegal = 0;
                    data.p_tipoDocPoderLegal = 0;
                    data.p_tipoDocAdendo1 = 0;
                    data.p_tipoDocAdendo2 = 0;

                    btnGuardar.id = '#btn-documentos';
                    enviarSolicitud(data, btnGuardar, 'doc');
                }

            })
        } else {
            agregarSpan('acta_constitutiva');
            agregarSpan('contrato');
            agregarSpan('documento_rfc');
            agregarSpan('txtFile');
            agregarSpan('id_representante_legal');
        }

    });

    $('#nuevocorreonotificaciones').on('input', function () {
        var idInputCorreo = $('#nuevocorreonotificaciones')
        if (idInputCorreo.val() !== '') {
            showSuccess(idInputCorreo)
        } else {
            showError(idInputCorreo, 'Ingrese al menos un correo.');
        }
    });

    $('#nuevocorreofacturasComision').on('input', function () {
        var idInputCorreo = $('#nuevocorreofacturasComision')
        if (idInputCorreo.val() !== '') {
            showSuccess(idInputCorreo)
        } else {
            showError(idInputCorreo, 'Ingrese al menos un correo.');
        }
    });

    $('#nuevocorreofacturasTransferencia').on('input', function () {
        var idInputCorreo = $('#nuevocorreofacturasTransferencia')
        if (idInputCorreo.val() !== '') {
            showSuccess(idInputCorreo)
        } else {
            showError(idInputCorreo, 'Ingrese al menos un correo.');
        }
    });
    
    $('#dias_credito').on('input', function () {
        var idInputDiasCredito = $('#dias_credito')
        if (idInputDiasCredito.val() !== '') {
            showSuccess(idInputDiasCredito)
        } else {
            showError(idInputDiasCredito, 'El campo es requerido.');
        }
    });

    async function guardarDatosLiquidacion() {
        const elemRetencion = $('#retencion');
        const elemTipoLiquidacion = $('#dias_liquidacion');
        const elemEnviarReporteCobranza = $("#checkEnviaCS");
        const elemMontoTransferencia = $('#monto_transferencia');
        const elemCostoTransferencia = $('#txtcostotrans');
        const elemCantidadTransferencia = $('#txtCantTrans');
        const elemNDias = $('#tn_dias');
        const elemDiaFechaPago = $('#especial_select_dias');
        const elemDiasAtras = $('#especial_dias');
        const elemCorreosLiquidaciones = $('#nuevocorreonotificaciones');

        let esRetencionValido = validarCampo(elemRetencion);
        let esTipoLiquidacionValido = validarCampo(elemTipoLiquidacion);

        let validarCobroTransferencia = true;
        let validarDatosTipoLiquidacion = false;
        let tipoLiquidacion = elemTipoLiquidacion.val();
        let retencion = $("#retencion option:selected").val();
        let montoTransferencia = elemMontoTransferencia.is(':checked');
        let ivaFactura = $("#ivaFactura option:selected").val();

        const data = {
            tipo: 42,
            p_nDias: 0,
            p_cobroTransferencia: 0,
            p_importeTransferencia: 0,
            p_proveedor: $('#p_proveedor').val(),
            p_nombreComercial: $('#nombreComercial').val(),
            p_diaFechaPago: 0,
            p_diasAtras: 0,
            p_enviarReporteCobranza: elemEnviarReporteCobranza.is(':checked') ? 0 : 1,
            p_diasPagoLunes: -1,
            p_diasPagoMartes: -1,
            p_diasPagoMiercoles: -1,
            p_diasPagoJueves: -1,
            p_diasPagoViernes: -1,
            p_diasPagoSabado: -1,
            p_diasPagoDomingo: -1,
            p_ivaFactura: ivaFactura,
            p_tipoTiempoAire: 0,
            p_cantidadCredito: 0,
            p_diasCredito: 0,
            p_tipoCredito: 0,
            p_cantidadTransferencia: 0
        };

        if (tipoLiquidacion == 1) { // T+ndias
            let esNDiasValido = validarCampo(elemNDias, 'numero');
            if (esNDiasValido) {
                validarDatosTipoLiquidacion = true;
                data.p_nDias = elemNDias.val().trim();
            } else {
                jAlert("Debe ingresar un valor válido para 'T+n días'", "Campo requerido");
                return;
            }
        }

        if (tipoLiquidacion == 2) { // Por periodos
            if (periodosLiquidacion.length < 7) {
                jAlert("El valor de días no puede ser menor o mayor a 7");
                return;
            }
            const periodosOrdenados = periodosLiquidacion.sort((a, b) => a.diaCorte - b.diaCorte);
            const dias = {
                Lu_Check: 0,
                Ma_Check: 1,
                Mi_Check: 2,
                Ju_Check: 3,
                Vi_Check: 4
            };

            periodosOrdenados.forEach(function (periodo, index) {
                let corte = periodo.diaCorte;
                switch (corte) {
                    case '0':
                        data.p_diasPagoLunes = dias[periodo.diaPago];
                        break;
                    case '1':
                        data.p_diasPagoMartes = dias[periodo.diaPago];
                        break;
                    case '2':
                        data.p_diasPagoMiercoles = dias[periodo.diaPago];
                        break;
                    case '3':
                        data.p_diasPagoJueves = dias[periodo.diaPago];
                        break;
                    case '4':
                        data.p_diasPagoViernes = dias[periodo.diaPago];
                        break;
                    case '5':
                        data.p_diasPagoSabado = dias[periodo.diaPago];
                        break;
                    case '6':
                        data.p_diasPagoDomingo = dias[periodo.diaPago];
                        break;
                    default:
                        break;
                }
            });
            validarDatosTipoLiquidacion = true;
        }

        if (tipoLiquidacion == 4) { // Especial
            let esDiaFechaPagoValido = validarCampo(elemDiaFechaPago);
            let esDiasAtrasValido = validarCampo(elemDiasAtras, 'numero');
            if (esDiaFechaPagoValido && esDiasAtrasValido) {
                validarDatosTipoLiquidacion = true;
                data.p_diaFechaPago = elemDiaFechaPago.val();
                data.p_diasAtras = elemDiasAtras.val();
            }
        }

        if (montoTransferencia) {
            let esCostoTransferenciaValido = validarCampo(elemCostoTransferencia, 'numero');
            let esCantidadTransferenciaValido = validarCampo(elemCantidadTransferencia, 'numero');
            if (!esCantidadTransferenciaValido) {
                jAlert("Debe ingresar una cantidad.");
                return;
            }

            if (esCostoTransferenciaValido) {
                validarCobroTransferencia = true;
                data.p_cobroTransferencia = 1;
                data.p_importeTransferencia = elemCostoTransferencia.val().trim();
                data.p_cantidadTransferencia = elemCantidadTransferencia.val().trim();
            }
        }

        (correosNotificaciones.length > 0) ? showSuccess(elemCorreosLiquidaciones) : showError(elemCorreosLiquidaciones, 'Ingrese al menos un correo.');

        // Tiempo Aire
        let esTiempoAireValido = false;
        if ($('#radio_prepago').is(':checked')) esTiempoAireValido = true;
        if ($('#radio_credito').is(':checked')) esTiempoAireValido = true;

        const elemTiempoAireError = $('#error-tiempo-aire');
        esTiempoAireValido ? showSuccess(elemTiempoAireError, false) : showError(elemTiempoAireError, 'Seleccione un tipo de Tiempo Aire', false);
        validarSubTipo()

        if (checkTipoCredito == 'PREPAGO') {
            data.p_tipoTiempoAire = 1;
        } else {
            const elemCantidadCredito = $('#monto_credito');
            const elemDiasCredito = $('#dias_credito');
            let valor = elemCantidadCredito.val();
            let dias = elemDiasCredito.val();
            if(dias === undefined || dias === ''){
                validarCampo(elemDiasCredito);
                return;
            }
            let elemCantidadCreditoFormateo = valor.replace(/,/g, "");
            let elemDiasCreditoFormateo = dias.replace(/,/g, "");
            data.p_tipoTiempoAire = 2;
            data.p_cantidadCredito = elemCantidadCreditoFormateo !== '' ? elemCantidadCreditoFormateo : 0
            data.p_diasCredito = elemDiasCreditoFormateo !== '' ? elemDiasCreditoFormateo : 0
            data.p_tipoCredito = $('#select_tipo_credito option:selected').val();
        }


        if (esRetencionValido && esTipoLiquidacionValido && validarDatosTipoLiquidacion && validarCobroTransferencia &&
            correosNotificaciones.length > 0) {

            data.p_tipoLiquidacion = tipoLiquidacion;
            data.p_retencion = retencion;
            data.p_correosLiquidacion = correosNotificaciones;
            jAlert("Subiendo cambios, por favor espere...", "Proceso en curso");
            if (seccionesGlobal.bSeccion4 && (seccionesGlobal.bSeccion4 == 1)) {
                data.tipo = 42;
                btnActualizar.id = '#btn-liquidacion';
                enviarSolicitud(data, btnActualizar);
            } else {
                data.tipo = 42;
                btnGuardar.id = '#btn-liquidacion';
                enviarSolicitud(data, btnGuardar);
            }
            return
        }
    }

    $("#btn-liquidacion").click(async function () {
        try {
            await guardarDatosLiquidacion();

        } catch (error) {
            console.error(error);
            jAlert("Hubo un error al subir los cambios. Por favor, intente de nuevo más tarde.", "Error en la subida de cambios");
        }
    });

    $("#btn-facturacion").click(function () {
        const elemDiasLiquidacionComision = $('#diasLiquidacionComision');
        const elemCorreosFacturasComision = $('#nuevocorreofacturasComision');
        const elemDiasLiquidacionTransferencia = $('#diasLiquidacionTransferencia');
        const elemCorreosFacturasTransferencia = $('#nuevocorreofacturasTransferencia');
        const elemMontoTransferencia = $('#monto_transferencia');

        let ivaFactura = $("#ivaFactura option:selected").val();
        let retencion = $('#retencion').val();
        let check_genera_factura_comision = $("#genera_factura_comision").is(':checked');
        let check_genera_factura_transferencia = $("#genera_factura_comision_transferencia").is(':checked');

        const data = {
            p_proveedor: $('#p_proveedor').val(),
            p_ivaFactura: ivaFactura,
            p_facturaComision: check_genera_factura_comision ? 1 : 0,
            p_facturaTransferencia: check_genera_factura_transferencia ? 1 : 0,
            p_cfdiComision: $("#cmbCFDIComision option:selected").val(),
            p_formaPagoComision: $("#cmbFormaPagoComision option:selected").val(),
            p_metodoPagoComision: $("#cmbMetodoPagoComision option:selected").val(),
            p_claveProductoServicioComision: $("#cmbProductoServicioComision option:selected").val(),
            p_unidadComision: $("#cmbClaveUnidadComision option:selected").val(),
            p_periodoFacturacionComision: $("#periocidadComision option:selected").val(),
            p_correoDestinoComision: '',
            p_diasLiquidaFacturaComision: 0,
            p_cfdiTransferencia: $("#cmbCFDITransferencia option:selected").val(),
            p_claveProductoServicioTransferencia: $("#cmbProductoServicioTransferencia option:selected").val(),
            p_unidadTransferencia: $("#cmbClaveUnidadTransferencia option:selected").val(),
            p_formaPagoTransferencia: $("#cmbFormaPagoTransferencia option:selected").val(),
            p_metodoPagoTransferencia: $("#cmbMetodoPagoTransferencia option:selected").val(),
            p_correoDestinoTransferencia: '',
            p_periodoFacturacionTransferencia: $("#periocidadTransferencia option:selected").val(),
        };

        let banderaFacturaComision = true;
        if (check_genera_factura_comision) {
            let esDiasLiquidacionComisionValido = true;

            if (retencion == 1) esDiasLiquidacionComisionValido = validarCampo(elemDiasLiquidacionComision);

            if (check_genera_factura_comision) {
                (correosenvfacturasComision.length > 0) ? showSuccess(elemCorreosFacturasComision) : showError(elemCorreosFacturasComision, 'Ingrese al menos un correo.');
            }

            if (esDiasLiquidacionComisionValido && (correosenvfacturasComision.length > 0)) {
                banderaFacturaComision = true;
                let diasLiquidacionComision = $("#diasLiquidacionComision").val();

                data.p_correoDestinoComision = correosenvfacturasComision;
                data.p_diasLiquidaFacturaComision = (diasLiquidacionComision == '') ? 0 : diasLiquidacionComision;
            } else {
                banderaFacturaComision = false;
            }
        }

        let banderaFacturaTransferencia = true;
        let montoTransferencia = elemMontoTransferencia.is(':checked');

        if (check_genera_factura_transferencia) {
            let esDiasLiquidacionTransferenciaValido = true;

            if (!montoTransferencia && check_genera_factura_transferencia) {
                esDiasLiquidacionTransferenciaValido = validarCampo(elemDiasLiquidacionTransferencia);
                banderaFacturaTransferencia = false;
            }

            if (check_genera_factura_transferencia) {
                (correosenvfacturasTransferencia.length > 0) ? showSuccess(elemCorreosFacturasTransferencia) : showError(elemCorreosFacturasTransferencia, 'Ingrese al menos un correo.');
            }

            if (esDiasLiquidacionTransferenciaValido && correosenvfacturasTransferencia.length > 0) {
                let diasLiquidacionTransferencia = $("#diasLiquidacionTransferencia").val();
                banderaFacturaTransferencia = true;

                data.p_correoDestinoTransferencia = correosenvfacturasTransferencia;
                data.p_diasLiquiquidaFacturaTransferencia = (diasLiquidacionTransferencia == '') ? 0 : diasLiquidacionTransferencia;
            } else {
                banderaFacturaTransferencia = false;
            }
        }

        if (banderaFacturaTransferencia && banderaFacturaComision) {
            // if (($('#tipoProceso').val() === 'edicion') || (seccionesGlobal.bSeccion5 == 1)) {
            if (seccionesGlobal.bSeccion5 && (seccionesGlobal.bSeccion5 == 1)) {
                data.tipo = 45;
                btnActualizar.id = '#btn-facturacion';
                enviarSolicitud(data, btnActualizar);
            } else {
                data.tipo = 44;
                btnGuardar.id = '#btn-facturacion';
                enviarSolicitud(data, btnGuardar);
            }
        }
    });

    $("#paso7").click(function () {
        var cuenta_contable_ingresos = $("#cuenta_contable_ingresos").val();
        var validanumeros_ingresos = (cuenta_contable_ingresos.replace(/[^0-9]/g, "").length);

        var cuenta_contable_costos = $("#cuenta_contable_costos").val();
        var validanumeros_costos = (cuenta_contable_costos.replace(/[^0-9]/g, "").length);


        var cuenta_contable_proveedor = $("#cuenta_contable_proveedor").val();
        var validanumeros_proveedor = (cuenta_contable_proveedor.replace(/[^0-9]/g, "").length);


        var cuenta_contable_banco = $("#cuenta_contable_banco").val();
        var validanumeros_banco = (cuenta_contable_banco.replace(/[^0-9]/g, "").length);


        var cuenta_contable_cliente = $("#cuenta_contable_cliente").val();
        var validanumeros_cliente = (cuenta_contable_cliente.replace(/[^0-9]/g, "").length);


        var cuenta_contable_iva_translado_por_cobrar = $("#cuenta_contable_iva_translado_por_cobrar").val();
        var validanumeros_iva_traslado = (cuenta_contable_iva_translado_por_cobrar.replace(/[^0-9]/g, "").length);


        var cuenta_contable_iva_acreditable_por_pagar = $("#cuenta_contable_iva_acreditable_por_pagar").val();
        var validanumeros_iva_acreditable = (cuenta_contable_iva_acreditable_por_pagar.replace(/[^0-9]/g, "").length);




        if (validanumeros_ingresos >= 11 && validanumeros_costos >= 11 &&
            validanumeros_proveedor >= 11 && validanumeros_banco >= 11 &&
            validanumeros_cliente >= 11 && validanumeros_iva_traslado >= 11 &&
            validanumeros_iva_acreditable >= 11) {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        } else {
            $("#span_paso7").show();
            $("#span_paso7").addClass('alert alert-danger');
            $("#span_paso7").html('Ingresa los datos necesarios');
            esconderElemento('span_paso7');
        }
    }); //fin paso7

    $('#btn-matriz-escalamiento').click(function () {
        if (lineasMatriz.length > 0) {
            const data = {
                p_proveedor: $('#p_proveedor').val(),
                p_tipoCliente: 0,
                p_lineasMatriz: lineasMatriz
            };

            if (tipoProveedor == 'Integrador') {
                data.p_tipoCliente = 1;
            }

            // if (($('#tipoProceso').val() === 'edicion') && (seccionesGlobal.bSeccion7 == 1)) {
            if (seccionesGlobal.bSeccion7 && (seccionesGlobal.bSeccion7 == 1)) {
                data.tipo = 39;
                btnActualizar.id = '#btn-matriz-escalamiento';
                enviarSolicitud(data, btnActualizar);
            } else {
                data.tipo = 38;
                btnGuardar.id = '#btn-matriz-escalamiento';
                enviarSolicitud(data, btnGuardar);
            }
        } else {
            $("#span-matriz-escalamiento").show();
            $("#span-matriz-escalamiento").addClass('alert alert-danger');
            $("#span-matriz-escalamiento").html('Ingresa al menos 1 fila en la matriz de escalamiento');
            esconderElemento('span-matriz-escalamiento');
        }
    });

    $('#verificar').click(function () {
        if (seccionesGlobal.bRevision == 1) {
            $.ajax({
                data: { tipo: 51, p_proveedor: $('#p_proveedor').val() },
                type: 'POST',
                url: '../ajax/altaProveedores.php',
                dataType: 'json',
                success: function (response) {
                    let url = 'consulta.php';
                    let { code, msg } = response;

                    if (code === '0') {
                        jAlert(msg, 'Éxito');
                        setTimeout(function () { window.location.href = url; }, 2000);
                    } else {
                        jAlert(msg, 'Oops!');
                        setTimeout(function () { window.location.href = url; }, 2000);
                    }
                }
            });
        }
    });
});

function esconderElemento(id) {
    setTimeout(function () {
        $("#" + id).fadeOut("slow");
    }, 3000);
}

function SetearFormaPago() {
    var valor = $("#retencion option:selected").val();
    if (valor == 2) {
        // Con Retención
        // $("#cmbFormaPagoTransferencia option[value='17']").prop('selected', true);
        $("#cmbFormaPagoComision option[value='17']").prop('selected', true);
        // $("#cmbMetodoPagoTransferencia option[value='PUE']").prop('selected', true);
        $("#cmbMetodoPagoComision option[value='PUE']").prop('selected', true);
        $("#diasLiquidacionComision").val('');
        $("#diasLiquidacionComision").attr('disabled', true);
        $("#diasLiquidacionTransferencia").val('');
        // $("#diasLiquidacionTransferencia").attr('disabled', true);
        showSuccess($("#diasLiquidacionComision"));
        // showSuccess($("#diasLiquidacionTransferencia"));
    } else {
        // Sin Retención
        // $("#cmbFormaPagoTransferencia option[value='99']").prop('selected', true);
        $("#cmbFormaPagoComision option[value='99']").prop('selected', true);
        // $("#cmbMetodoPagoTransferencia option[value='PPD']").prop('selected', true);
        $("#cmbMetodoPagoComision option[value='PPD']").prop('selected', true);
        $("#diasLiquidacionComision").attr('disabled', false);
        // $("#diasLiquidacionTransferencia").attr('disabled', false);
    }
}

var contadorFilasModoNuevo = 0;

function agregarFilaModoNuevo(id) {
    var familia = $("#familiaccp_0 option:selected").val();
    var subfamilia = $("#subfamiliaccp_0 option:selected").val();
    var emisores = $("#emisoresccp_0 option:selected").val();
    var producto = $("#productoccp_0").val();
    var cuentaingresos = $("#cuentaccin_0").val();
    var cuentacostos = $("#cuentacccos_0").val();
    var credito_prepago = $("#select_credito_prepago_0 option:selected").val();
    var comercio = $("#select_comercio_0").val();
    var familiaTexto = $("#familiaccp_0 option:selected").text();
    var subfamiliaTexto = $("#subfamiliaccp_0 option:selected").text();
    var emisoresTexto = $("#emisoresccp_0 option:selected").text();
    var cuentaIngresosTexto = $("#cuentaccin_0").val();
    var cuentaCostosTexto = $("#cuentacccos_0").val();
    var credito_prepagoTexto = $("#select_credito_prepago_0 option:selected").text();
    var validanumerosCC = (cuentaingresos.replace(/[^0-9]/g, "").length);
    var validanumeroCCCostos = (cuentacostos.replace(/[^0-9]/g, "").length);

    if (familia > 0 && subfamilia > 0 && emisores > 0 && producto != null && validanumerosCC >= 11 && validanumeroCCCostos >= 11 && credito_prepago > 0 && comercio != null) {
        var lista_productos = "";
        $("#productoccp_0 option:selected").each(function () {
            var $this = $(this);
            if ($this.length) {
                var selText = $this.text();
                lista_productos += selText + ",";
            }
        });
        lista_productos = lista_productos.substring(0, lista_productos.length - 1);
        var lista_comercios = "";
        $("#select_comercio_0 option:selected").each(function () {
            var $this = $(this);
            if ($this.length) {
                var selText = $this.text();
                lista_comercios += selText + ",";
            }
        });
        lista_comercios = lista_comercios.substring(0, lista_comercios.length - 1);
        contadorFilasModoNuevo++;
        var fila = "<tr class='tr_classCC' id='filaccp_" + contadorFilasModoNuevo + "'>" +
            "<td style='display:none;'><input type='text' id='familiaccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='familiaccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='subfamiliaccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='subfamiliaccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='emisorccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='emisorccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='productoccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='productoccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='cuentacingreso_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='cuentaccosto_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='tipoccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='tipoccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='cadenasccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='cadenasccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><button style='background-color:red;border-color:red;' id='rowccp_" + contadorFilasModoNuevo + "' class='add_button btn btn-sm btn-default' onclick='eliminarFilaModoNuevo(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
            "</tr>";

        $("#tabla_ccp").append(fila);
        $("#familiaccp_" + contadorFilasModoNuevo + " ").val(familia);
        $("#familiaccpText_" + contadorFilasModoNuevo + " ").val(familiaTexto);
        $("#subfamiliaccp_" + contadorFilasModoNuevo + " ").val(subfamilia);
        $("#subfamiliaccpText_" + contadorFilasModoNuevo + " ").val(subfamiliaTexto);
        $("#emisorccp_" + contadorFilasModoNuevo + " ").val(emisores);
        $("#emisorccpText_" + contadorFilasModoNuevo + " ").val(emisoresTexto);
        $("#productoccp_" + contadorFilasModoNuevo + " ").val(producto);
        $("#productoccpText_" + contadorFilasModoNuevo + " ").val(lista_productos);
        $("#cuentacingreso_" + contadorFilasModoNuevo + " ").val(cuentaingresos);
        $("#cuentaccosto_" + contadorFilasModoNuevo + " ").val(cuentacostos);
        $("#tipoccp_" + contadorFilasModoNuevo + " ").val(credito_prepago);
        $("#tipoccpText_" + contadorFilasModoNuevo + " ").val(credito_prepagoTexto);
        $("#cadenasccp_" + contadorFilasModoNuevo + " ").val(comercio);
        $("#cadenasccpText_" + contadorFilasModoNuevo + " ").val(lista_comercios);

        var renglon = contadorFilasModoNuevo + "|" + familia + "|" + subfamilia + "|" + emisores + "|" + producto + "|" + cuentaingresos + "|" + cuentacostos + "|" + credito_prepago + "|" + comercio;
        agregarRowsModoNuevo(renglon);
        //resetear inputs
        $("#familiaccp_0 option[value='0']").prop('selected', true);
        $("#subfamiliaccp_0 option[value='-1']").prop('selected', true);
        $("#emisoresccp_0 option[value='0']").prop('selected', true);
        $('#productoccp_0 option').attr("selected", false);
        $('#productoccp_0').selectpicker('refresh');
        $("#cuentaccin_0").val("");
        $("#cuentacccos_0").val("");
        $("#select_credito_prepago_0 option[value='1']").prop('selected', true);
        $('#select_comercio_0 option').attr("selected", false);
        $('#select_comercio_0').selectpicker('refresh');
    } else {
        jAlert("Ingresa todos los datos en la configuracion de productos");
    }


}

var lineasModoNuevo = [];

function agregarRowsModoNuevo(arreglo) {
    lineasModoNuevo.push(arreglo);
}

function eliminarFilaModoNuevo(id) {
    var partir = id.split("_");
    var numero_fila = partir[1];
    var fila = "filaccp_" + numero_fila;
    var row = document.getElementById(fila);
    var familia = $("#familiaccp_" + numero_fila).val();
    var subfamilia = $("#subfamiliaccp_" + numero_fila).val();
    var emisor = $("#emisorccp_" + numero_fila).val();
    var producto = $("#productoccp_" + numero_fila).val();
    var cuentaIngreso = $("#cuentacingreso_" + numero_fila).val();
    var cuentaCosto = $("#cuentaccosto_" + numero_fila).val();
    var tipo_credito = $("#tipoccp_" + numero_fila).val();
    var comercio = $("#cadenasccp_" + numero_fila).val();
    var valor = numero_fila + "|" + familia + "|" + subfamilia + "|" + emisor + "|" + producto + "|" + cuentaIngreso + "|" + cuentaCosto + "|" + tipo_credito + "|" + comercio;
    row.parentNode.removeChild(row);
    removerLineasModoNuevo(valor);
}

function removerLineasModoNuevo(corr) { //eliminar rows modo nuevo
    for (var i = 0; i < lineasModoNuevo.length; i++) {
        while (lineasModoNuevo[i] == corr)
            lineasModoNuevo.splice(i, 1);
    }
}


function agregarFilaCCPEdicionModoNuevo(idFamilia, nombreFam, idSubFam, nombreSubFam, idEmisor, nombreEmisor, id_productos, nombre_productos,
    cuentaContableIngresos, cuentaContableCostos, idTipoCredito, nombreTipoCredito, id_cadenas, nombre_cadenas) {

    if (idFamilia.length > 0 && idSubFam.length > 0 && idEmisor.length > 0 && id_productos.length > 0 && cuentaContableIngresos.length > 0 &&
        cuentaContableCostos.length > 0 && idTipoCredito.length > 0 && id_cadenas.length > 0) {
        contadorFilasModoNuevo++;
        var fila = "<tr class='tr_classCC' id='filaccp_" + contadorFilasModoNuevo + "'>" +
            "<td style='display:none;'><input type='text' id='familiaccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='familiaccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='subfamiliaccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='subfamiliaccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='emisorccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='emisorccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='productoccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='productoccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='cuentacingreso_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='cuentaccosto_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='tipoccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='tipoccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='cadenasccp_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='cadenasccpText_" + contadorFilasModoNuevo + "' class='form-control m-bot15'></td>" +
            "<td><button style='background-color:red;border-color:red;' id='rowccp_" + contadorFilasModoNuevo + "' class='add_button btn btn-sm btn-default' onclick='eliminarFilaModoNuevo(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
            "</tr>";

        $("#tabla_ccp").append(fila);
        $("#familiaccp_" + contadorFilasModoNuevo + " ").val(idFamilia);
        $("#familiaccpText_" + contadorFilasModoNuevo + " ").val(nombreFam);
        $("#subfamiliaccp_" + contadorFilasModoNuevo + " ").val(idSubFam);
        $("#subfamiliaccpText_" + contadorFilasModoNuevo + " ").val(nombreSubFam);
        $("#emisorccp_" + contadorFilasModoNuevo + " ").val(idEmisor);
        $("#emisorccpText_" + contadorFilasModoNuevo + " ").val(nombreEmisor);
        $("#productoccp_" + contadorFilasModoNuevo + " ").val(id_productos);
        $("#productoccpText_" + contadorFilasModoNuevo + " ").val(nombre_productos);
        $("#cuentacingreso_" + contadorFilasModoNuevo + " ").val(cuentaContableIngresos);
        $("#cuentaccosto_" + contadorFilasModoNuevo + " ").val(cuentaContableCostos);
        $("#tipoccp_" + contadorFilasModoNuevo + " ").val(idTipoCredito);
        $("#tipoccpText_" + contadorFilasModoNuevo + " ").val(nombreTipoCredito);
        $("#cadenasccp_" + contadorFilasModoNuevo + " ").val(id_cadenas);
        $("#cadenasccpText_" + contadorFilasModoNuevo + " ").val(nombre_cadenas);
        var renglon = contadorFilasModoNuevo + "|" + idFamilia + "|" + idSubFam + "|" + idEmisor + "|" + id_productos + "|" + cuentaContableIngresos + "|" + cuentaContableCostos + "|" + idTipoCredito + "|" + id_cadenas;
        agregarRowsModoNuevo(renglon);
    } else {

    }


}

var contadorFilaTarjetas = 0;

function agregarFilaTarjeta(id) {
    var tipoCredito = $("#select_tipo_credito_tarjeta_0 option:selected").val();
    var tipoTarjeta = $("#select_tipo_tarjeta_0 option:selected").val();
    var porcentaje = $("#porcentajetarjeta_0").val();
    var tipoCreditoTexto = $("#select_tipo_credito_tarjeta_0 option:selected").text();
    var tipoTarjetaTexto = $("#select_tipo_tarjeta_0 option:selected").text();

    if (tipoCredito > 0 && tipoTarjeta > 0 && porcentaje.length > 0) {
        contadorFilaTarjetas++;
        var fila = "<tr class='tr_classTar' id='filatar_" + contadorFilaTarjetas + "'>" +
            "<td style='display:none;'><input type='text' id='tipocredito_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='tipocreditoText_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='tipotarjeta_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='tipotarjetaText_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='porcentaje_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td><button style='background-color:red;border-color:red;' id='rowtar_" + contadorFilaTarjetas + "' class='add_button btn btn-sm btn-default' onclick='eliminaraFilaTarjeta(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
            "</tr>";

        $("#tabla_tarjetas").append(fila);
        $("#tipocredito_" + contadorFilaTarjetas + " ").val(tipoCredito);
        $("#tipocreditoText_" + contadorFilaTarjetas + " ").val(tipoCreditoTexto);
        $("#tipotarjeta_" + contadorFilaTarjetas + " ").val(tipoTarjeta);
        $("#tipotarjetaText_" + contadorFilaTarjetas + " ").val(tipoTarjetaTexto);
        $("#porcentaje_" + contadorFilaTarjetas + " ").val(porcentaje);
        $("#select_tipo_credito_tarjeta_0 option[value='1']").prop('selected', true);
        $("#select_tipo_tarjeta_0 option[value='1']").prop('selected', true);
        $("#porcentajetarjeta_0").val("");
        var renglon = contadorFilaTarjetas + "," + tipoCredito + "," + tipoTarjeta + "," + porcentaje;
        agregarRowsTarjetas(renglon);
    } else {
        jAlert("Favor de agregar los datos necesarios para los tipos de tarjeta");
    }
}

var lineasTarjetas = [];

function agregarRowsTarjetas(arreglo) {
    lineasTarjetas.push(arreglo);
}

function eliminaraFilaTarjeta(id) {
    var partir = id.split("_");
    var numero_fila = partir[1];
    var fila = "filatar_" + numero_fila;
    var row = document.getElementById(fila);
    var tipo_credito = $("#tipocredito_" + numero_fila).val();
    var tipo_tarjeta = $("#tipotarjeta_" + numero_fila).val();
    var porcentaje = $("#porcentaje_" + numero_fila).val();
    var valor = numero_fila + "," + tipo_credito + "," + tipo_tarjeta + "," + porcentaje;
    row.parentNode.removeChild(row);
    removerLineasTarjeta(valor);
}

function removerLineasTarjeta(corr) {
    for (var i = 0; i < lineasTarjetas.length; i++) {
        while (lineasTarjetas[i] == corr)
            lineasTarjetas.splice(i, 1);
    }
}

function buscarTarjetasProveedor(idProveedor) {
    $.ajax({
        data: {
            tipo: 28,
            idProveedor: idProveedor
        },
        type: 'POST',
        // async : false,
        url: '../ajax/altaProveedores.php',
        success: function (response) {
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj, function (index, value) {
                var nIdProveedor = obj[index]['nIdProveedor'];
                var nTipoCredito = obj[index]['nTipoCredito'];
                var nTipoTarjeta = obj[index]['nTipoTarjeta'];
                var nPorcentaje = obj[index]['nPorcentaje'];
                agregarFilaTarjetaEdicion(nTipoCredito, nTipoTarjeta, nPorcentaje);
            });
        }
    });
}


function agregarFilaTarjetaEdicion(nTipoCredito, nTipoTarjeta, nPorcentaje) {
    var labelTipoCredito = "";
    if (nTipoCredito == 1) {
        labelTipoCredito = "Credito";
    }
    if (nTipoCredito == 2) {
        labelTipoCredito = "Debito";
    }

    var labelTipoTarjeta = "";
    if (nTipoTarjeta == 1) {
        labelTipoTarjeta = "VISA";
    }
    if (nTipoTarjeta == 2) {
        labelTipoTarjeta = "MASTER CARD";
    }
    if (nTipoTarjeta == 3) {
        labelTipoTarjeta = "AMERICAN EXPRESS";
    }


    if (nTipoCredito > 0 && nTipoTarjeta > 0 && nPorcentaje.length > 0) {
        contadorFilaTarjetas++;
        var fila = "<tr class='tr_classTar' id='filatar_" + contadorFilaTarjetas + "'>" +
            "<td style='display:none;'><input type='text' id='tipocredito_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='tipocreditoText_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;'><input type='text' id='tipotarjeta_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='tipotarjetaText_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td><input type='text' id='porcentaje_" + contadorFilaTarjetas + "' class='form-control m-bot15'></td>" +
            "<td><button style='background-color:red;border-color:red;' id='rowtar_" + contadorFilaTarjetas + "' class='add_button btn btn-sm btn-default' onclick='eliminaraFilaTarjeta(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
            "</tr>";

        $("#tabla_tarjetas").append(fila);
        $("#tipocredito_" + contadorFilaTarjetas + " ").val(nTipoCredito);
        $("#tipocreditoText_" + contadorFilaTarjetas + " ").val(labelTipoCredito);
        $("#tipotarjeta_" + contadorFilaTarjetas + " ").val(nTipoTarjeta);
        $("#tipotarjetaText_" + contadorFilaTarjetas + " ").val(labelTipoTarjeta);
        $("#porcentaje_" + contadorFilaTarjetas + " ").val(nPorcentaje);
        $("#select_tipo_credito_tarjeta_0 option[value='1']").prop('selected', true);
        $("#select_tipo_tarjeta_0 option[value='1']").prop('selected', true);
        $("#porcentajetarjeta_0").val("");
        var renglon = contadorFilaTarjetas + "," + nTipoCredito + "," + nTipoTarjeta + "," + nPorcentaje;
        agregarRowsTarjetas(renglon);
    } else {
        jAlert("Favor de agregar los datos necesarios para los tipos de tarjeta");
    }
}


var contadorFilasZonas = 0;

function agregarFilaZona(id, tipoEntrada, zonaP = "", clabeP = "", referenciaP = "", bancoP = "") {
    var zona = $("#nombreZona_0").val();
    var clabe = $("#clabeXZona_0").val();
    var referencia = $("#referenciaZona_0").val();
    var banco = $("#bancoXZona_0").val();
    var bandera = 1;
    var banderaZona = 1;
    var mensajeZona = "";
    var banderaClabe = 0;
    var mensajeClabe = "";
    var banderaReferencia = 1;
    var mensajeReferencia = "";

    var banderaBanco = 1;
    var mensajeBanco = "";

    if (zonaP) {
        bandera = 1;
        zona = zonaP
    } else {
        zona = zona;
    }

    if (clabeP) {
        clabe = clabeP
    } else {
        clabe = clabe;
    }

    if (referenciaP) {
        referencia = referenciaP
    } else {
        referencia = referencia;
    }

    if (zona.length > 0) {
        banderaZona = 0;
    } else {
        banderaZona = 1;
        mensajeZona = "Ingresa una Zona";
    }

    if (referencia.length > 0) {
        banderaReferencia = 0;
    } else {
        mensajeReferencia = "Ingresa una Referencia";
    }

    if (clabe.length == 18) {
        banderaClabe = 0;
    } else if (clabe.length > 18) {
        banderaClabe = 1;
        mensajeClabe = "Cuenta CLABE excede el maximo de digitos";
    } else {
        banderaClabe = 1;
        mensajeClabe = "Ingresa una Cuenta CLABE de 18 digitos";
    }

    if (bancoP) {
        banderaBanco = 0;
        banco = bancoP
    } else {
        banco = banco;
        if (banco.length > 0) {
            banderaBanco = 0;
        } else {
            mensajeBanco = "Favor de revisar la cuenta clabe, no se reconoce el banco origen";
            banderaBanco = 1;
        }
    }

    if (banderaZona == 0 && banderaClabe == 0 && banderaReferencia == 0 && banderaBanco == 0) {
        contadorFilasZonas++;
        var fila = "<tr class='tr_classZona' id='filaZona_" + contadorFilasZonas + "'>" +

            // "<td style='display:none;'><input type='text'  id='idZona_" + contadorFilasZonas + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='stringZona_" + contadorFilasZonas + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='clabeZona_" + contadorFilasZonas + "' class='form-control m-bot15'></td>" +
            "<td style='display:none;' class='disabledbutton'><input type='text' id='bancoZona_" + contadorFilasZonas + "' class='form-control m-bot15'></td>" +
            "<td class='disabledbutton'><input type='text' id='referenciaZona_" + contadorFilasZonas + "' class='form-control m-bot15'></td>" +
            "<td><button style='background-color:red;border-color:red;' id='row_" + contadorFilasZonas + "' class='add_button btn btn-sm btn-default' onclick='eliminarFilaZona(this.id);'><i class='fa fa-minus-circle' aria-hidden='true'></i></button></td>" +
            "</tr>";

        $("#tabla_clabes_zonas").append(fila);
        $("#stringZona_" + contadorFilasZonas + " ").val(zona);
        $("#clabeZona_" + contadorFilasZonas + " ").val(clabe);
        $("#bancoZona_" + contadorFilasZonas + " ").val(banco);
        $("#referenciaZona_" + contadorFilasZonas + " ").val(referencia);
        //reset
        $("#nombreZona_0").val("");
        $("#clabeXZona_0").val("");
        $("#referenciaZona_0").val("");
        $("#bancoXZona_0").val("");
        var renglon = contadorFilasZonas + "," + zona + "," + clabe + "," + referencia + "," + banco + "|";
        agregarCCZona(renglon);
    } else {
        jAlert(mensajeZona + "<br>" + mensajeClabe + "<br>" + mensajeReferencia + "<br>" + mensajeBanco);
    }
}

var lineasCCZona = [];

function agregarCCZona(renglon) { //agregar los correos
    var num_correos = lineasCCZona.length;
    linea = renglon;
    lineasCCZona.push(linea);
}

function eliminarFilaZona(id) { //elimina una fila de la lista de zonas con cuenta clabe
    var partir = id.split("_");
    var numero_fila = partir[1];
    var fila = "filaZona_" + numero_fila;
    var row = document.getElementById(fila);
    var idZona = $("#idZona_" + numero_fila).val();
    var clabeZona = $("#clabeZona_" + numero_fila).val();
    var referenciaZona = $("#referenciaZona_" + numero_fila).val();
    var nombreZona = $("#stringZona_" + numero_fila).val();
    var bancoZona = $("#bancoZona_" + numero_fila).val();

    var valor = numero_fila + "," + nombreZona + "," + clabeZona + "," + referenciaZona + "," + bancoZona + "|";
    row.parentNode.removeChild(row);
    removerFilaZona(valor);
}

function removerFilaZona(corr) {
    for (var i = 0; i < lineasCCZona.length; i++) {
        while (lineasCCZona[i] == corr)
            lineasCCZona.splice(i, 1);
    }
}

function analizarCLABEZona() {
    var CLABE = event.target.value;
    if (CLABE.length == 18) {
        var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
        if (CLABE_EsCorrecta) {
            $.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE }).done(function (data) {
                var banco = jQuery.parseJSON(data);
                $("#bancoXZona_0").val(banco.bancoID);
            });
        } else {
            alert("La CLABE escrita es incorrecta. Favor de verificarla.");
        }
    } else {
    }
}

function validarPais() {
    var pais = $('#paisPago').val();
    var camposBancoLatam = $('#camposBancoLatam');
    if (parseInt(pais) === 164 || pais === '-1') {
        camposBancoLatam.css('display', 'none');
    } else {
        camposBancoLatam.css('display', 'block');
    }
}
