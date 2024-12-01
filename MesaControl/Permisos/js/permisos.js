let urlPrincipal = '';
let urlExportarExcel = '';
let dataTablePermisos = null;
let permisos = [];
let permisosOriginal = [];
let productos = [];
let productosComisionCadena = [];
let roleCapturista = false;
let roleAutorizador = false;
let roleCapturistaYAutorizador = false;
let roleLector = false;
let tituloModal = '';
let textoModal = '';
let permisosNoValidos = [];
let productosNoSeleccionados = [];
let botonAccion = '';
let existenPermisosPorAutorizar = false;
const CLIENTE_WALMART_INNOVACION = 2168;
const configuracionDefaultDataTable = {
    language: {
        emptyTable: 'No se ha encontrado información',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        infoFiltered: '(filtrado de _MAX_ total de registros)',
        lengthMenu: 'Mostrar _MENU_ registros por página',
        loadingRecords: 'Cargando...',
        search: 'Buscar:',
        zeroRecords: 'No se encontraron coincidencias en los registros',
        paginate: {
            first: 'Primero',
            last: 'Último',
            next: 'Siguiente',
            previous: 'Anterior'
        }
    },
    paging: true,
    scrollCollapse: false,
    lengthMenu: [100, 250, 500],
    iDisplayLength: 250
};
const filtroEstatusPermiso = [
    { id: '-1', value: 'Todos' },
    { id: 0, value: 'Autorizados' },
    { id: 1, value: 'Pendientes' },
    { id: 10, value: 'Sin permisos' },
];

const elemTxtCliente = $('#txtSCliente');
const elemNIdCliente = $('#nIdCliente');
const elemNTicketFiscal = $('#nTicketFiscal');
const elemTxtIdCadena = $('#txtIdCadena');
const elemTxtCadena = $('#txtSCadena');
const elemTxtIdSubCadena = $('#txtIdSubCadena');
const elemTxtSubCadena = $('#txtSSubCadena');
const elemSelectCorresponsal = $('#selectCorresponsal');
const elemSelectProveedor = $('#selectProveedor');
const elemInformacionPermisos = $('#informacionPermisos');
const elemTxtComisionCadenaGrupal = $('#txtComisionCadenaGrupal');
const elemDescTicketFiscal = $('#descTicketFiscal');

const elemBtnBuscar = $('#btn-buscar');
const elemSectionButtons = $('.section-buttons');
const elemBtnGuardar = $('#btnGuardar');
const elemBtnAutorizar = $('#btnAutorizar');
const elemBtnAsignarComisionGrupal = $('#btnAsignarComisionGrupal');
const elemBtnCancelarComisionGrupal = $('#btnCancelarComisionGrupal');
const elemModalConfimacion = $('#modal-confirmacion');
const elemBtnConfirmacion = $('#btnConfirmar');
const elemBtnCancelarConfirmacion = $('#btnCancelarConfirmacion');
const elemBtnDeclinarCambios = $('#btnDeclinarCambios');

const generarDatosAutocomplete = (buscar) => {
    let filtrarClientes = CLIENTES.filter(cliente => {
        if (cliente.sRazonSocial.toLowerCase().includes(buscar.toLowerCase()) || 
            (cliente.sRFC && cliente.sRFC.toLowerCase().includes(buscar.toLowerCase())) ||
            cliente.sNombre.toLowerCase().includes(buscar.toLowerCase()) ||
            cliente.nIdCliente == buscar.trim()) {
            
            cliente.text = '';

            if (cliente.sRazonSocial.trim() != '' && cliente.sNombre.trim() != '') {
                cliente.text = `${cliente.nIdCliente} - ${cliente.sRazonSocial}`;
                return cliente;
            } else {
                if (cliente.sRazonSocial.trim() != '') {
                    cliente.text = `${cliente.nIdCliente} - ${cliente.sRazonSocial}`;
                    return cliente;
                }

                if (cliente.sNombre.trim() != '') {
                    cliente.text = `${cliente.nIdCliente} - ${cliente.sNombre}`;
                    return cliente;
                }
            }

            return cliente;
        }
    });
   
    return filtrarClientes;
}

const initAutocomplete = () => {
    const autocomplete = new autoComplete({
        selector: '#txtSCliente',
        minChars: 1,
        source: function(term, suggest) {
            const suggestions = [];
            term = term.toLowerCase();

            let clientes = generarDatosAutocomplete(term);

            suggest(clientes);
        },
        renderItem: function (item, search) {
            // escape special characters
            search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
            return `<div class="autocomplete-suggestion" data-val="${item.text}" data-id-cliente="${item.nIdCliente}" data-ticket-fiscal="${item.nTicketFiscal}">${item.text.replace(re, "<b>$1</b>")}</div>`;
        },
        onSelect: function (e, term, item) { 
            let nIdCliente = item.getAttribute('data-id-cliente');
            let nTicketFiscal = item.getAttribute('data-ticket-fiscal');
            elemNIdCliente.val(nIdCliente);
            elemNTicketFiscal.val(nTicketFiscal);
        }
    });
}

const obtenerCadenaSubcadenaCorresponsales = (idCliente) => {
    $.ajax({
        data: { tipo: 2, idCliente: idCliente },
        type: 'POST',
        url: urlPrincipal,
        dataType: 'json',
        success: function (response) {
            const { bExito, data, sMensaje } = response;

            if (bExito && data.length > 0) {
                let txtSubCadena = `${(data[0].nIdSubCadenaCliente == -1) ? 'Todas' : data[0].sNombreSubCadena}`;
                elemTxtIdCadena.val(data[0].nIdCadena);
                elemTxtCadena.val(data[0].sNombreCadena);
                elemTxtIdSubCadena.val(data[0].nIdSubCadenaCliente);
                elemTxtSubCadena.val(txtSubCadena);
                construirSelector(elemSelectCorresponsal, data, 'nIdCorresponsal', 'sNombreCorresponsal');
                elemSelectCorresponsal.prop('disabled', false);
            }

            buscarProveedores();
        }
    }).fail(function(xhr, status, error) {
        jAlert(`${status} ${error}`, 'Alerta');
    });
}

const resetInputs = () => {
    elemTxtIdCadena.val('');
    elemTxtCadena.val('');
    elemTxtIdSubCadena.val('');
    elemTxtSubCadena.val('');
    elemSelectCorresponsal.val(-1);
    elemSelectProveedor.val(-1);
    elemSelectCorresponsal.prop('disabled', true);
    elemSelectProveedor.prop('disabled', true);
    dataTablePermisos = null;
    elemInformacionPermisos.html('');
    permisos = [];
    permisosOriginal = [];
    productos = [];
    productosComisionCadena = [];
    tituloModal = '';
    textoModal = '';
    permisosNoValidos = [];
    productosNoSeleccionados = [];
    elemSectionButtons.removeClass('show').addClass('hide');
}

const construirSelector = (elemento, datos, value, text, mostrarOpcionDefault = false, primeraOpcion = 'Seleccione') => {
    elemento.empty();

    if (mostrarOpcionDefault) {
        elemento.append(`<option value="-1">${primeraOpcion}</option>`);
    }

    if (datos.length > 0) {
        datos.forEach(dato => {
            elemento.append(`<option value="${dato[value]}">${dato[text]}</option>`)        
        });
    }
}

const esWalmartInnovacion = () => {
    return elemNIdCliente.val() == CLIENTE_WALMART_INNOVACION;
}

const buscarProveedores = () => {
    let nIdCliente = elemNIdCliente.val();
    $.ajax({
        data: { tipo: 3 , nIdCliente: nIdCliente },
        type: 'POST',
        url: urlPrincipal,
        dataType: 'json',
        success: function (response) {
            let { bExito, data, sMensaje } = response;

            if (bExito) {
                if (data.length > 0) {
                    let opcionTodo = {
                        nIdProveedor: 0,
                        sNombreProveedor: 'Todos'
                    };

                    data.sort((a, b) => b.sNombreProveedor.toLowerCase() > a.sNombreProveedor.toLowerCase() ? -1 : b.sNombreProveedor.toLowerCase() < a.sNombreProveedor.toLowerCase() ? 1 : 0);

                    // Si el cliente es Walmart Innovacion mostramos solo los permisos y productos de Altan 
                    if (esWalmartInnovacion()) {
                        mostrarOpcionDefault = false;
                        elemSelectProveedor.val(data[0].nIdProveedor);
                        construirSelector(elemSelectProveedor, data, 'nIdProveedor', 'sNombreProveedor');
                        elemSelectProveedor.trigger('change');
                    } else {
                        data.unshift(opcionTodo);
                        construirSelector(elemSelectProveedor, data, 'nIdProveedor', 'sNombreProveedor', true);
                    }

                } else {
                    jAlert(sMensaje, 'Aviso');
                }
            } else {
                hideSpinner();
                jAlert(sMensaje, 'Alerta');
            }

            elemSelectProveedor.prop('disabled', false);
            $('.btn-spinner').removeClass('show').addClass('hide');
            elemBtnBuscar.prop('disabled', false);
        }
    }).fail(function(xhr, status, error) {
        jAlert(`${status} ${error}`, 'Alerta');
    });
}

const esObligatorio = value => ((value === '') || (value === '-1') || (value === null)) ? false : true;

const validarCampo = (input, type) => {
    let valido = false;
    let valor = input.val();
    valor = valor ? valor.trim() : valor;
    
    let a = esObligatorio(valor);

    if (!esObligatorio(valor)) {
       input.removeClass('has-succes').addClass('has-error');
    }else {
       input.removeClass('has-error');
       valido = true;
    }

    return valido;
}

const validarSiEstaSeleccionadoProducto = (permiso, valor) => {
    if (valor > 0) {
        let index = productosNoSeleccionados.findIndex(producto => producto.nIdProducto == permiso.nIdProducto && producto.nIdRuta == permiso.nIdRuta);

        if (index == -1) {
            let noSeleccionado = {
                nIdProducto: permiso.nIdProducto,
                nIdRuta: permiso.nIdRuta,
                sNombreProducto: permiso.sNombreProducto
            };

            productosNoSeleccionados.push(noSeleccionado);
        }
    }
}

const guardarPermiso = () => {
    let permisosSeleccionados = permisos.filter(permiso => permiso.nSeleccionado == 1 && permiso.bPermisoValido && Object.values(permiso.bModificado).some(modificado => modificado == true));

    $.ajax({
        data: { 
            tipo: 7,
            nIdCliente: elemNIdCliente.val(),
            permisos: permisosSeleccionados
        },
        type: 'POST',
        url: urlPrincipal,
        dataType: 'json',
        beforeSend: function() {
            elemBtnConfirmacion.prop('disabled', true);
            elemBtnCancelarConfirmacion.prop('disabled', true);
            showSpinner();
        },
        success: function(response) {
            let { bExito, sMensaje, data } = response;
            if (bExito) {
                elemModalConfimacion.modal('hide');
                permisos = [];
                obtenerPermisos();

                if (data.length > 0) {
                    let mensaje = 'No se pudieron guardar los permisos de los siguientes productos: \n';
                    data.forEach(function(row) {
                        mensaje += `${row.producto} ${row.mensaje ? (row.mensaje) : ''} \n`;
                    });

                    jAlert(mensaje, 'Alerta');
                } else {
                    jAlert('Los permisos fueron guardados exitosamente', 'Exito')
                }
            } else {
                jAlert(sMensaje, 'Oops! Ocurrio un error')
            }
            elemBtnConfirmacion.prop('disabled', false);
            elemBtnCancelarConfirmacion.prop('disabled', false);
        }
    }).fail(function(xhr, status, error) {
        jAlert(`${status} ${error}`, 'Alerta');
        hideSpinner();
    });
}

const autorizarPermisos = () => {
    let permisosAAutorizar = permisos.filter(permiso => permiso.nSeleccionado == 1 && permiso.nIdEstatusPermiso == 1).map((permiso => permiso.nIdPermiso));

    if (permisosAAutorizar.length > 0) {
        showSpinner();
        $.ajax({
            data: { 
                tipo: 8,
                permisos: permisosAAutorizar,
            },
            type: 'POST',
            url: urlPrincipal,
            dataType: 'json',
            beforeSend: function() {
                elemBtnConfirmacion.prop('disabled', true);
                elemBtnCancelarConfirmacion.prop('disabled', true);
            },
            success: function(response) {
                let { bExito, sMensaje, data } = response;
                elemModalConfimacion.modal('hide');
                if (bExito) {
                    if (data.length > 0) {
                        let mensaje = 'No se pudieron autorizar los permisos de los siguientes productos: \n';
                        data.forEach(function(row) {
                            mensaje += `${row.producto} ${row.mensaje ? (row.mensaje) : ''} \n`;
                        });

                        jAlert(mensaje, 'Alerta');
                    } else {
                        jAlert('Los permisos fueron autorizados exitosamente', 'Exito');
                    }

                    obtenerPermisos();
                    elemBtnAutorizar.prop('disabled', true);
                } else {
                    jAlert(sMensaje, 'Oops! Ocurrio un error')
                }
                elemBtnConfirmacion.prop('disabled', false);
                elemBtnCancelarConfirmacion.prop('disabled', false);
            }
        }).fail(function(xhr,status, error) {
            jAlert(`${status} ${error}`, 'Alerta');
            hideSpinner();
        });
    } else {
        jAlert('No hay permisos pendientes por autorizar.', 'Aviso');
    }
}

const tipoComision = (elem, idRuta) => {
    let valor = elem.value;
    let existePermiso = buscarPermiso(idRuta);
    
    if (existePermiso != -1) {
        let permiso = permisos[existePermiso];
        if (valor == 0) {
            // Tipo comision por Importe
            permiso.nTipoComision = 0;
            $(`#txtComisionCobroProveedor-${idRuta}`).val(permiso.nImpComisionProducto);
            $(`#txtComisionPagoProveedor-${idRuta}`).val(permiso.nImpPagoProveedor);
            $(`#txtComisionMinimaMargenRed-${idRuta}`).val(permiso.nImpMargen);
            $(`#txtComisionMaximaUsuario-${idRuta}`).val(permiso.nImpComClienteMaxima);

            $(`#txtComisionUsuario-${idRuta}`).val(permiso.nImpComCliente);
            $(`#txtComisionEspecial-${idRuta}`).val(permiso.nImpComEspecial);
            $(`#txtComisionCadena-${idRuta}`).val(permiso.nImpComCorresponsal);
            $(`#txtComisionFrente-${idRuta}`).val(permiso.nImpComFrente);
            $(`#txtComisionCadenaFactura-${idRuta}`).val(permiso.nImpComCadenaFactura);
            $(`#txtComisionRED-${idRuta}`).val(permiso.nImpRed);
            $(`.signo-${idRuta}`).html('$');
            $(`#grupal-${idRuta}`).prop('checked', false);
            $(`#grupal-${idRuta}`).prop('disabled', true);
            $(`#txtComisionUsuario-${idRuta}`).prop('disabled', false);
            $(`#txtComisionEspecial-${idRuta}`).prop('disabled', false);
        } else {
            // Tipo comision por Porcentaje
            permiso.nTipoComision = 1;
            $(`#txtComisionCobroProveedor-${idRuta}`).val(permiso.nPerComisionProducto);
            $(`#txtComisionPagoProveedor-${idRuta}`).val(permiso.nPerPagoProveedor);
            $(`#txtComisionMinimaMargenRed-${idRuta}`).val(permiso.nPerMargen);
            $(`#txtComisionMaximaUsuario-${idRuta}`).val(permiso.nPerComClienteMaxima);

            $(`#txtComisionUsuario-${idRuta}`).val(permiso.nPerComCliente);
            $(`#txtComisionEspecial-${idRuta}`).val(permiso.nPerComEspecial);
            $(`#txtComisionCadena-${idRuta}`).val(permiso.nPerComCorresponsal);
            $(`#txtComisionFrente-${idRuta}`).val(permiso.nPerComFrente);
            $(`#txtComisionCadenaFactura-${idRuta}`).val(permiso.nPerComCadenaFactura);
            $(`#txtComisionRED-${idRuta}`).val(permiso.nPerRed);
            $(`.signo-${idRuta}`).html('%');
            $(`#grupal-${idRuta}`).prop('disabled', false);
            $(`#txtComisionUsuario-${idRuta}`).prop('disabled', true);
            $(`#txtComisionEspecial-${idRuta}`).prop('disabled', true);
        }
    }
}

const buscarPermiso = (idRuta) => {
    return permisos.findIndex(permiso => permiso.nIdRuta == idRuta);
}

const buscarProducto = (idRuta) => {
    return productos.findIndex(producto => producto.nIdRuta == idRuta);
}

const checkProducto = (elem, idRuta) => {
    let existePermiso = buscarPermiso(idRuta);

    if (existePermiso != -1) {
        let permiso = permisos[existePermiso];
        let comCadenaMaxima = 0;
        comCadenaMaxima = obtenerComisionCadenaMaxima(permiso);

        console.log(permiso);

        if($(elem).is(':checked')) {
            permiso.nSeleccionado = 1;
            permiso.nIdEstatusPermiso = 1;

            let index = productosNoSeleccionados.findIndex(producto => producto.nIdRuta == idRuta);
            if (index != -1) {
                productosNoSeleccionados.splice(index, 1);
            }

            if (permiso.nTipoComision == 0) {
                if ((parseFloat(permiso.nImpComCliente) == 0 && parseFloat(permiso.nImpComEspecial) == 0 && parseFloat(permiso.nImpComCorresponsal) == 0) && (comCadenaMaxima > 0)) {
                    permiso.bModificado.productoCheck = true;
                } else {
                    // jAlert('No esta ganando Red Efectiva, favor de revisar las comisiones', 'Aviso');
                }
            } else {
                if ((parseFloat(permiso.nPerComCliente) == 0 && parseFloat(permiso.nPerComEspecial) == 0 && parseFloat(permiso.nPerComCorresponsal) == 0) && (comCadenaMaxima > 0)) {
                    permiso.bModificado.productoCheck = true;
                } else {
                    // jAlert('No esta ganando Red Efectiva, favor de revisar las comisiones', 'Aviso');
                }

                if (esWalmartInnovacion()) {
                    permiso.bModificado.productoCheck = true;
                }
            }
        } else {
            permiso.nSeleccionado = 0;
            permiso.nIdEstatusPermiso = 3;
            permiso.bModificado.productoCheck = false;
            $(`#grupal-${idRuta}`).prop('checked', false);
        }
    }
}

const checkPorcentajeCadena = (elem, idRuta) => {
    let existePermiso = buscarPermiso(idRuta);

    if (permisos[existePermiso].nSeleccionado == 0) {
        jAlert('Debe seleccionar el producto para poder seleccionar la comisión grupal', 'Aviso');
        $(`#grupal-${idRuta}`).prop('checked', false);
        return;
    }

    if ($(elem).is(':checked')) {
        productosComisionCadena.push({idRuta});
    } else {
        const index = productosComisionCadena.findIndex(producto => producto.idRuta == idRuta);

        if (index != -1) {
            productosComisionCadena.splice(index, 1);
        }
    }
}

const checarCambios = (nombreComision, idRuta) => {
    let agregarClase = '';

    if (roleAutorizador || roleCapturistaYAutorizador) {
        let existePermiso = buscarPermiso(idRuta);

        if (existePermiso != -1) {
            // $(elem).removeClass('cambios');
            let permiso = permisos[existePermiso];

            if (permiso.bCambio[nombreComision]) {
                agregarClase = 'cambios';
            }
        }
    }

    return agregarClase;
}

/*
*   La
*/
const obtenerNuevaComisionCadenaMaxima = (idRuta) => {
    let existePermiso = buscarPermiso(idRuta);
    let resultado = 0.0000;

    if (existePermiso != -1) {
        let permiso = permisos[existePermiso];
        let ticketFiscal = elemNTicketFiscal.val();
        let nuevoImporteComisionCadenaMaxima = 0.0000;
        let nuevoPorcentajeComisionCadena = 0.0000;

        if (permiso.nTipoComision == 0) {
            nuevoImporteComisionCadenaMaxima = ((parseFloat(permiso.nImpComCliente) + parseFloat(permiso.nImpComEspecial) + parseFloat(permiso.nImpComisionProducto)) - parseFloat(permiso.nImpMargen)) - parseFloat(permiso.nImpPagoProveedor);

            if (ticketFiscal == 2) {
                nuevoImporteComisionCadenaMaxima = (parseFloat(permiso.nImpComFrente) + parseFloat(permiso.nImpComisionProducto) - parseFloat(permiso.nImpPagoProveedor)) - parseFloat(permiso.nImpMargen);
            }

            resultado = parseFloat(nuevoImporteComisionCadenaMaxima).toFixed(4);
        } else {
            nuevoPorcentajeComisionCadena = ((parseFloat(permiso.nPerComCliente) + parseFloat(permiso.nPerComEspecial) + parseFloat(permiso.nPerComisionProducto)) - parseFloat(permiso.nPerMargen)) - parseFloat(permiso.nPerPagoProveedor); 

            if (ticketFiscal == 2) {
                nuevoPorcentajeComisionCadena = (parseFloat(permiso.nPerComisionProducto) - parseFloat(permiso.nPerPagoProveedor)) - parseFloat(permiso.nPerMargen);
            }

            resultado = parseFloat(nuevoPorcentajeComisionCadena).toFixed(4);
        }
    }

    return resultado;
}

const setearComisionUsuario = (elem, idRuta) => {
    let existePermiso = buscarPermiso(idRuta);

    if (existePermiso != -1) {
        let value = (elem.value == '') ? '0.0000' : elem.value;
        let valor = parseFloat(value).toFixed(4);
        let permiso = permisos[existePermiso];

        if (permiso.nTipoComision == 0) {
            permiso.bModificado.comisionUsuario = esModificado(idRuta, valor, 'nImpComCliente');
            permiso.nImpComCliente = valor;
            permiso.nPerComCliente = '0.0000';
        } else {
            permiso.bModificado.comisionUsuario = esModificado(idRuta, valor, 'nPerComCliente');
            permiso.nImpComCliente = '0.0000';
            permiso.nPerComCliente = valor;
        }
    }
}

const setearComisionEspecial = (elem, idRuta) => {
    let existePermiso = buscarPermiso(idRuta);

    if (existePermiso != -1) {
        let value = (elem.value == '') ? '0.0000' : elem.value;
        let valor = parseFloat(value).toFixed(4);
        let permiso = permisos[existePermiso];

        if (permiso.nTipoComision == 0) {
            permiso.bModificado.comisionEspecial = esModificado(idRuta, valor, 'nImpComEspecial');
            permiso.nImpComEspecial = valor;
            permiso.nPerComEspecial = '0.0000';
        } else {
            permiso.bModificado.comisionEspecial = esModificado(idRuta, valor, 'nPerComEspecial');
            permiso.nImpComEspecial = '0.0000';
            permiso.nPerComEspecial = valor;
        }
    }
}

const setearComisionCadena = (elem, idRuta) => {
    let existePermiso = buscarPermiso(idRuta);

    if (existePermiso != -1) {
        let value = (elem.value == '') ? '0.0000' : elem.value;
        let valor = parseFloat(value).toFixed(4);
        let permiso = permisos[existePermiso]; 

        if (permiso.nTipoComision == 0) {
            permiso.bModificado.comisionCadena = esModificado(idRuta, valor, 'nImpComCorresponsal');
            permiso.nImpComCorresponsal = valor;
            permiso.nPerComCorresponsal = '0.0000';
        } else {
            permiso.bModificado.comisionCadena = esModificado(idRuta, valor, 'nPerComCorresponsal');
            permiso.nImpComCorresponsal = '0.0000';
            permiso.nPerComCorresponsal = valor;
        }
    }
}

const setearComisionFrente = (elem, idRuta) => {
    let existePermiso = buscarPermiso(idRuta);

    if (existePermiso != -1) {
        let value = (elem.value == '') ? '0.0000' : elem.value;
        let valor = parseFloat(value).toFixed(4);
        let permiso = permisos[existePermiso];

        if (permiso.nTipoComision == 0) {
            permiso.bModificado.comisionFrente = esModificado(idRuta, valor, 'nImpComFrente');
            permiso.nImpComFrente = valor;
            permiso.nPerComFrente = '0.0000';
        } else {
            permiso.bModificado.comisionFrente = esModificado(idRuta, valor, 'nPerComFrente');
            permiso.nImpComFrente = '0.0000';
            permiso.nPerComFrente = valor;
        }
    }
}

const setearImporteRed = (elem, idRuta) => {
    let existePermiso = buscarPermiso(idRuta);

    if (existePermiso != -1) {
        let valor = parseFloat(elem.value).toFixed(4);
        let permiso = permisos[existePermiso];

        if (permiso.nTipoComision == 0) {
            permisos.nImpRed = valor;
            permisos.nPerRed = '0.0000';
        } else {
            permisos.nImpRed = '0.0000';
            permisos.nPerRed = valor;
        }
    }
}

const limpiarComisionGrupal = () => {
    if (productosComisionCadena.length > 0) {
        productosComisionCadena.forEach(producto => {
            $(`#grupal-${producto.idRuta}`).prop('checked', false);
        });
    }
}

const esModificado = (idRuta, valor, propiedad) => {
    let existePermiso = permisosOriginal.findIndex(permiso => permiso.nIdRuta == idRuta);
    let modificado = false;

    modificado = parseFloat(valor).toFixed(4) != parseFloat(0.0000).toFixed(4);

    if (existePermiso != -1) {
        let valor2 = permisosOriginal[existePermiso][propiedad];
        modificado = parseFloat(valor).toFixed(4) != parseFloat(valor2).toFixed(4);
    }

    return modificado;
}

/**
 * 
 * @param {*} permiso 
 * @returns 
 */
const obtenerComisionCadenaMaxima = (permiso) => {
    let comisionCadenaMaxima = 0;

    if (permiso.nTipoComision == 0) {
        if (elemNTicketFiscal.val() == 2) {
            comisionCadenaMaxima = (parseFloat(permiso.nImpComFrente) == 0) ? permiso.nImpComCorresponsalMaxima : obtenerNuevaComisionCadenaMaxima(permiso.nIdRuta);
        } else {
            comisionCadenaMaxima = (parseFloat(permiso.nImpComCliente) == 0) ? permiso.nImpComCorresponsalMaxima : obtenerNuevaComisionCadenaMaxima(permiso.nIdRuta);
        }
    } else {
        if (elemNTicketFiscal.val == 2) {
            comisionCadenaMaxima = (parseFloat(permiso.nPerComFrente) == 0) ? permiso.nPerComClienteMaxima : obtenerComisionCadenaMaxima(permiso.nIdRuta);
        } else {
            comisionCadenaMaxima = (parseFloat(permiso.nPerComCliente) == 0) ? permiso.nPerComCorresponsalMaxima :  obtenerNuevaComisionCadenaMaxima(permiso.nIdRuta);
        }
    }
    return comisionCadenaMaxima;
}

const obtenerTipoComision = (data) => {
    let tipoComision = 0;
    let comisionesRutaImporte = [
        parseFloat(data.nImpComClienteMaxima),
        parseFloat(data.nImpComCorresponsalMaxima), 
        parseFloat(data.nImpMargen),
        parseFloat(data.nImpComisionProducto), 
        parseFloat(data.nImpPagoProveedor)
    ];

    let comisionesRutaPorcentaje = [
        parseFloat(data.nPerComClienteMaxima),
        parseFloat(data.nPerComCorresponsalMaxima), 
        parseFloat(data.nPerMargen), 
        parseFloat(data.nPerComisionProducto), 
        parseFloat(data.nPerPagoProveedor)
    ];

    let comisionesRuta = comisionesRutaImporte.concat(comisionesRutaPorcentaje);
    let existeComisionImporte = comisionesRutaImporte.some(comisionImporte => comisionImporte > 0);
    let existeComisionPorcentaje = comisionesRutaPorcentaje.some(comisionPorcentaje => comisionPorcentaje > 0);
    let estanTodasComisionesCeros = comisionesRuta.every(comision => comision == 0);

    if (existeComisionPorcentaje) {
        tipoComision = 1;
    }

    if ((existeComisionImporte && existeComisionPorcentaje) || estanTodasComisionesCeros) {
        if (data.sDescFamilia == 'Telefonia') {
            tipoComision = 1;
        } 
    }

    // Todos lo productos de Walmart Innovacion son por porcentaje
    if (esWalmartInnovacion()) {
        tipoComision = 1;
    }

    return tipoComision;
}

const validarComisionUsuario = (elem, idRuta) => {
    let esComisionUsuarioValida = validarCampo($(elem));
    let existePermiso = buscarPermiso(idRuta);
    let comisionCadenaMaxima = 0;
    let comisionCadena = 0;

    if (!esComisionUsuarioValida) {
        jAlert('La comisión del usuario es requerida', 'Aviso', function () {
            $(elem).trigger('focus');
        });
        return;
    }

    if (existePermiso != -1) {
        let permiso = permisos[existePermiso];
        let valor = parseFloat(elem.value).toFixed(4);
        $(elem).val(valor);
        
        if (permiso.nSeleccionado == 0) {
            validarSiEstaSeleccionadoProducto(permiso, valor);
        }

        comisionCadenaMaxima = obtenerComisionCadenaMaxima(permiso);
        comisionCadena = $(`#txtComisionCadena-${idRuta}`).val();

        if (permiso.nTipoComision == 0) {
            if (parseFloat(valor) > parseFloat(permiso.nImpComClienteMaxima)) {
                jAlert(`La comisión al usuario (${valor}) no debe de se mayor a la comisión usuario máxima (${parseFloat(Math.abs(permiso.nImpComClienteMaxima)).toFixed(4)}) permitida por la ruta.`, 'Aviso');
            } else {
                if (parseFloat(comisionCadena) > parseFloat(comisionCadenaMaxima)) {
                    jAlert(`La comisión al usuario (${valor}) y la comisión cadena (${parseFloat(Math.abs(comisionCadena)).toFixed(4)}) no superan la comisión minima margen red (${permiso.nImpMargen}).`, 'Aviso');
                }
            }
        } else {
            if (parseFloat(valor) > parseFloat(permiso.nPerComClienteMaxima)) {
                jAlert(`La comisión al usuario (${valor}) no debe de se mayor a la comisión usuario máxima (${parseFloat(Math.abs(permiso.nPerComClienteMaxima)).toFixed(4)}) permitida por la ruta.`, 'Aviso');
            } else {
                if (parseFloat(comisionCadena) > parseFloat(comisionCadenaMaxima)) {
                    jAlert(`La comisión al usuario (${valor}) y la comisión cadena (${parseFloat(Math.abs(comisionCadena)).toFixed(4)}) no superan la comision minima margen red (${permiso.nPerMargen}).`, 'Aviso');
                }
            }
        }

        calcularComisionesFacturas(idRuta);
    }
}

const validarComisionEspecial = (elem, idRuta) => {
    let esComisionEspecialValida = validarCampo($(elem));
    let existePermiso = buscarPermiso(idRuta);

    if (!esComisionEspecialValida) {
        jAlert('La comisión especial es requerida', 'Aviso', function () {
            $(elem).trigger('focus');
        });
        return;
    }

    if (existePermiso != -1) {
        let permiso = permisos[existePermiso];
        let valor = parseFloat(elem.value).toFixed(4);
        $(elem).val(valor);

        if (permiso.nSeleccionado == 0) {
            validarSiEstaSeleccionadoProducto(permiso, valor);
        }

        calcularComisionesFacturas(idRuta);
    }
}

const validarComisionFrente = (elem, idRuta) => {
    let esComisionFrenteValida = validarCampo($(elem));
    let existePermiso = buscarPermiso(idRuta);

    if (!esComisionFrenteValida) {
        jAlert('La comisión al frente (no se valida) es requerida', 'Aviso', function () {
            $(elem).trigger('focus');
        });
        return;
    }

    if (existePermiso != -1) {
        let valor = parseFloat(elem.value).toFixed(4);
        let permiso = permisos[existePermiso];

        $(elem).val(valor);
        
        if (permiso.nSeleccionado == 0) {
            validarSiEstaSeleccionadoProducto(permiso, valor);
        }

        let comisionUsuarioMaxima = permiso.nImpComClienteMaxima;

        if (permiso.nTipoComision == 1) {
            comisionUsuarioMaxima = permiso.nPerComClienteMaxima;
        }

        if (parseFloat(valor) > parseFloat(comisionUsuarioMaxima)) {
            jAlert(`La comisión al frente (${valor}) no debe de se mayor a la comisión usuario máxima (${parseFloat(comisionUsuarioMaxima).toFixed(4)}) permitida por la ruta.`, 'Aviso', function () {
                $(elem).trigger('focus');
            });
        }

        calcularComisionesFacturas(idRuta);
    }
}

const validarComisionCadena = (elem, idRuta) => {
    let esComisionCadenaValida = validarCampo($(elem));
    let existePermiso = buscarPermiso(idRuta);

    if (!esComisionCadenaValida) {
        jAlert('La comisión cadena es requerida', 'Aviso', function () {
            $(elem).trigger('focus');
        });
        return;
    }

    if (existePermiso != -1) {
        let valor = parseFloat(elem.value).toFixed(4);
        let permiso = permisos[existePermiso];
        let comisionCadenaMaxima = 0;
        let textoAlerta = '';

        $(elem).val(valor);

        if (permiso.nSeleccionado == 0) {
            validarSiEstaSeleccionadoProducto(permiso, valor);
        }

        comisionCadenaMaxima = obtenerComisionCadenaMaxima(permiso);
        
        if (permiso.nTipoComision == 0) {
            let signoValor = Math.sign(comisionCadenaMaxima);

            if (signoValor == -1) {
                textoAlerta = `La comisión mínima margen red (${parseFloat(Math.abs(comisionCadenaMaxima)).toFixed(4)}) no se cumple.`;
                jAlert(textoAlerta, 'Aviso');
            } else {
                if (parseFloat(valor) > parseFloat(comisionCadenaMaxima)) {
                    textoAlerta = `La comisión a pagar a la cadena (${valor}) no debe de se mayor a la comisión cadena máxima (${parseFloat(comisionCadenaMaxima).toFixed(4)}) que permite el proveedor.`;

                    jAlert(textoAlerta, 'Aviso');
                }
            }
        } else {
            if (parseFloat(valor) > parseFloat(comisionCadenaMaxima)) {
                jAlert(`La comisión a pagar a la cadena (${valor}) no debe de se mayor a la comisión cadena máxima (${parseFloat(Math.abs(comisionCadenaMaxima)).toFixed(4)}) que permite el proveedor.`, 'Aviso');
            }
        } 

        calcularComisionesFacturas(idRuta);
    }
}

const validarRedFactura = (elem, idRuta) => {
    let esRedFacturaValida = validarCampo($(elem));
    let existePermiso = buscarPermiso(idRuta);

    if (!esRedFacturaValida) {
        jAlert('El campo RED (Factura) es requerido', 'Aviso');
        return;
    }

    if (existePermiso != -1) {
        let valor = parseFloat(elem.value).toFixed(4);
        let permiso = permisos[existePermiso];

        $(elem).val(valor);

        if (permiso.nSeleccionado == 0) {
            validarSiEstaSeleccionadoProducto(permiso, valor);
        }
    }
}

const validarExistenCambios = () => {
    let huboCambios = false;
    let cambios = permisos.filter(permiso => Object.values(permiso.bCambio).some(cambio => cambio == true));
    
    if (cambios.length > 0) {
        huboCambios = true;
    }

    return huboCambios;
}

const calcularComisionesFacturas = (idRuta) => {
    let ticketFiscal = elemNTicketFiscal.val();
    let comisionCadena = $(`#txtComisionCadena-${idRuta}`).val();
    let comisionCadenaFactura = '0.000';
    let comisionRed = '0.0000';

    if (ticketFiscal == 0 || ticketFiscal == 1) {
        let comisionUsuario = $(`#txtComisionUsuario-${idRuta}`).val();
        let comisionEspecial = $(`#txtComisionEspecial-${idRuta}`).val();

        if ((parseFloat(comisionUsuario) == parseFloat(comisionCadena)) && (parseFloat(comisionEspecial) == 0)) {
            if (ticketFiscal == 1) {
                comisionCadenaFactura = comisionCadena;
            }

            if (ticketFiscal == 0) {
            }
        }

        if ((parseFloat(comisionUsuario) > parseFloat(comisionCadena)) && (parseFloat(comisionEspecial) == 0)) {
            if (ticketFiscal == 0) {
                comisionRed = (parseFloat(comisionUsuario) + parseFloat(comisionEspecial)) - parseFloat(comisionCadena);
            }

            if (ticketFiscal == 1) {
                comisionCadenaFactura = comisionCadena;
            }
        }
        
        if ((parseFloat(comisionUsuario) < parseFloat(comisionCadena)) && (parseFloat(comisionEspecial) == 0)) {
            if (ticketFiscal == 0) {
                comisionCadenaFactura = parseFloat(comisionCadena) - (parseFloat(comisionUsuario) + parseFloat(comisionEspecial));
            }

            if (ticketFiscal == 1) {
                comisionCadenaFactura = comisionCadena;
            }
        }

        if ((parseFloat(comisionUsuario) < parseFloat(comisionCadena)) && (parseFloat(comisionEspecial) > 0)) {
            if (ticketFiscal == 0) {
                comisionCadenaFactura = parseFloat(comisionCadena) - (parseFloat(comisionUsuario) + parseFloat(comisionEspecial));
            }

            if (ticketFiscal == 1) {
                comisionCadenaFactura = comisionCadena;
            }
        }

        if ((parseFloat(comisionUsuario) == 0) && (parseFloat(comisionCadena) == 0) && (parseFloat(comisionEspecial) > 0)) {
            if (ticketFiscal == 0) {
                comisionRed = (parseFloat(comisionUsuario) + parseFloat(comisionEspecial)) - parseFloat(comisionCadena);
            }

            if (ticketFiscal == 1) {
                comisionCadenaFactura = comisionCadena;
            }
        }

        if ((parseFloat(comisionUsuario) == parseFloat(comisionCadena)) && (parseFloat(comisionEspecial) > 0)) {
            if (ticketFiscal == 0) {
                comisionRed = (parseFloat(comisionUsuario) + parseFloat(comisionEspecial)) - parseFloat(comisionCadena);
            }

            if (ticketFiscal == 1) {
                comisionCadenaFactura = comisionCadena;
            }
        }

        if ((parseFloat(comisionUsuario) > 0 && parseFloat(comisionCadena) == 0) && (parseFloat(comisionEspecial) > 0)) {
            if (ticketFiscal == 0) {
                comisionRed = parseFloat(comisionUsuario) + parseFloat(comisionEspecial);
            }

            if (ticketFiscal == 1) {
                comisionCadenaFactura = comisionCadena;
            }
        }

        if ((comisionUsuario > 0) && (comisionCadena > 0) && (parseFloat(comisionEspecial) > 0)) {
            if (ticketFiscal == 0) {
                comisionSumaUsuarioEspecial = (parseFloat(comisionUsuario) + parseFloat(comisionEspecial));
                if (parseFloat(comisionSumaUsuarioEspecial) > parseFloat(comisionCadena)) {
                    comisionRed = parseFloat(comisionSumaUsuarioEspecial) - parseFloat(comisionCadena);
                }

                if (parseFloat(comisionSumaUsuarioEspecial) < parseFloat(comisionCadena)) {
                    comisionCadenaFactura = parseFloat(comisionCadena) - parseFloat(comisionSumaUsuarioEspecial);
                }
            }

            if (ticketFiscal == 1) {
                comisionCadenaFactura = comisionCadena;
            }
        }

        $(`#txtComisionCadenaFactura-${idRuta}`).val(parseFloat(comisionCadenaFactura).toFixed(4));
        $(`#txtComisionRED-${idRuta}`).val(parseFloat(comisionRed).toFixed(4));

        let existePermiso = buscarPermiso(idRuta);
        if (existePermiso != -1) {
            let permiso = permisos[existePermiso];

            if (permiso.nTipoComision == 0) {
                permiso.nImpComCliente = comisionUsuario; 
                permiso.nImpComEspecial = comisionEspecial;
                permiso.nImpComCorresponsal = comisionCadena; 
                permiso.nImpComCadenaFactura = $(`#txtComisionCadenaFactura-${idRuta}`).val();
                permiso.nPerComCadenaFactura = '0.0000';
                permiso.nImpRed = $(`#txtComisionRED-${idRuta}`).val();
                permiso.nPerRed = '0.0000';
            } else {
                permiso.nPerComCliente = comisionUsuario; 
                permiso.nPerComEspecial = comisionEspecial;
                permiso.nPerComCorresponsal = comisionCadena;
                permiso.nImpComCadenaFactura = '0.0000';
                permiso.nPerComCadenaFactura = $(`#txtComisionCadenaFactura-${idRuta}`).val();
                permiso.nImpRed = '0.0000';
                permiso.nPerRed = $(`#txtComisionRED-${idRuta}`).val();
            }

        }
    }

    if (ticketFiscal == 2) {
        let comisionFrente = $(`#txtComisionFrente-${idRuta}`).val();

        if (parseFloat(comisionFrente) > 0 && parseFloat(comisionCadena) == 0) {
            comisionRed = comisionFrente;
        }

        if (parseFloat(comisionFrente) > parseFloat(comisionCadena) && parseFloat(comisionCadena) != 0) {
            comisionRed = comisionFrente - comisionCadena;
        }

        if (parseFloat(comisionFrente) == 0 && parseFloat(comisionCadena) > 0) {
            comisionCadenaFactura = comisionCadena;
        }

        if (parseFloat(comisionFrente) < parseFloat(comisionCadena) && parseFloat(comisionFrente) != 0) {
            comisionCadenaFactura = comisionCadena - comisionFrente;
        }

        if (comisionFrente == comisionCadena) {
        }

        $(`#txtComisionCadenaFactura-${idRuta}`).val(parseFloat(comisionCadenaFactura).toFixed(4));
        $(`#txtComisionRED-${idRuta}`).val(parseFloat(comisionRed).toFixed(4));
        
        let existePermiso = buscarPermiso(idRuta);
        if (existePermiso != -1) {
            let permiso = permisos[existePermiso];

            if (permiso.nTipoComision == 0) {
                permiso.nImpComFrente = comisionFrente; 
                permiso.nImpComCorresponsal = comisionCadena; 
                permiso.nImpComCadenaFactura = $(`#txtComisionCadenaFactura-${idRuta}`).val();
                permiso.nPerComCadenaFactura = '0.0000';
                permiso.nImpRed = $(`#txtComisionRED-${idRuta}`).val();
                permiso.nPerRed = '0.0000';
            } else {
                permiso.nPerComFrente = comisionFrente; 
                permiso.nPerComCorresponsal = comisionCadena;
                permiso.nImpComCadenaFactura = '0.0000';
                permiso.nPerComCadenaFactura = $(`#txtComisionCadenaFactura-${idRuta}`).val();
                permiso.nImpRed = '0.0000';
                permiso.nPerRed = $(`#txtComisionRED-${idRuta}`).val();
            }

        }
    }
}

const generarDataSet = (permisos, productos) => {
    const myArrayFiltered = productos.filter((producto) => {
        return permisos.some((permiso) => { 
            return permiso.nIdRuta == producto.nIdRuta;
        });
    });

    return myArrayFiltered;
}

const obtenerPermisos = () => {
    let idProveedor = elemSelectProveedor.val();
    let role = roleLector ? 'lector' : '';

    $.ajax({
        data: { 
            tipo: 6,
            idCliente: elemNIdCliente.val(),
            idCadena: elemTxtIdCadena.val(),
            idSubCadena: elemTxtIdSubCadena.val(),
            idCorresponsal: elemSelectCorresponsal.val(),
            idProveedor: idProveedor,
            role: role
        },
        type: 'POST',
        url: urlPrincipal,
        dataType: 'json',
        success: function(response) {
            let { bExito, data, sMensaje } = response;
            if (bExito) {
                permisos = data;
                permisosOriginal = JSON.parse(JSON.stringify(permisos));
                obtenerProductos(idProveedor);
            } else {
                jAlert(sMensaje, 'Oops! Ocurrio un error');
            }
        }
    }).fail(function(xhr,status, error) {
        jAlert(`${status} ${error}`, 'Alerta');
        hideSpinner();
    });
}

const obtenerProductos = (idProveedor) => {
    $.ajax({
        data: {
            tipo: 5,
            idProveedor: idProveedor
        },
        type: 'POST',
        url: urlPrincipal,
        dataType: 'json',
        success: function(response) {
            let { bExito, data, sMensaje } = response;
            if (bExito) {
                productos = data;
                
                if (roleAutorizador || roleCapturistaYAutorizador) {
                    productos = generarDataSet(permisos, productos);
                }
                
                preparDatos(productos, permisos);
                // generarTabla(productos);
            } else  {
                jAlert(sMensaje, 'Oops! Ocurrio un error');
                hideSpinner();
            }
        }
    }).fail(function (xhr, status, error) {
        jAlert(`${status} ${error}`, 'Alerta');
    });
}

const preparDatos = (productos, permisos) => {
    productos.forEach(producto => {
        let existePermiso = buscarPermiso(producto.nIdRuta);
        let defaultModificado = {
            productoCheck: false,
            comisionUsuario: false,
            comisionEspecial: false,
            comisionFrente: false,
            comisionCadena: false
        };
        
        if (existePermiso == -1) {
            let defaultPermiso = {
                nIdPermiso: null,
                nIdCadena: elemTxtIdCadena.val(),
                nIdSubCadena: elemTxtIdSubCadena.val(),
                nIdCorresponsal: elemSelectCorresponsal.val(),
                nIdProducto: producto.nIdProducto,
                nIdEstatusPermiso: 1,
                nIdRuta: producto.nIdRuta,
                nImpComCliente: "0.0000",
                nImpComCorresponsal: "0.0000",
                nImpComEspecial: "0.0000",
                nImpComFrente: '0.0000',
                nImpComCadenaFactura: '0.0000',
                nImpRed: "0.0000",
                nImpMargen: producto.nImpMargen,
                nImpComisionProducto: producto.nImpComisionProducto,
                nImpPagoProveedor: producto.nImpPagoProveedor,
                nImpComClienteMaxima: producto.nImpComClienteMaxima,
                nImpComCorresponsalMaxima: producto.nImpComCorresponsalMaxima,
                nPerComCliente: "0.0000",
                nPerComCorresponsal: "0.0000",
                nPerComEspecial: "0.0000",
                nPerComFrente: '0.0000',
                nPerComCadenaFactura: '0.0000',
                nPerRed: '0.0000',
                nPerMargen: producto.nPerMargen,
                nPerComisionProducto: producto.nPerComisionProducto, 
                nPerPagoProveedor: producto.nPerPagoProveedor,
                nPerComClienteMaxima: producto.nPerComClienteMaxima,
                nPerComCorresponsalMaxima: producto.nPerComCorresponsalMaxima,
                nTipoComision: obtenerTipoComision(producto),
                nSeleccionado: 0,
                sNombreProducto: producto.sDescProducto,
                sDescFamilia: producto.sDescFamilia,
                sNombreProveedor: producto.sNombreProveedor,
                bCambio: {
                    tipoComision: false,
                    comisionUsuario: false,
                    comisionEspecial: false,
                    comisionFrente: false,
                    comisionCadena: false,
                    comisionCadenaFactura: false,
                    comisionRedFactura: false
                },
                bPermisoValido: true,
                bEsNuevo: true,
                bModificado: defaultModificado, 
                nEstatus: 10 // Esta propiedad es la que se usa para filtrar los datos, el valor 10 es para los que no tienen permiso
            };

            if (esWalmartInnovacion()) {
                defaultPermiso.nPerRed = '2.5000';
            }

            permisos.push(defaultPermiso);
        } else {
            let permiso = permisos[existePermiso];

            permiso.sNombreProducto = producto.sDescProducto;
            permiso.sDescFamilia = producto.sDescFamilia;
            permiso.sNombreProveedor = producto.sNombreProveedor;
            permiso.bPermisoValido = true;
            permiso.bEsNuevo = false;
            permiso.bModificado = defaultModificado;
            permiso.nImpComisionProducto = producto.nImpComisionProducto;
            permiso.nImpPagoProveedor = producto.nImpPagoProveedor;
            permiso.nImpMargen = producto.nImpMargen;
            permiso.nImpComClienteMaxima = producto.nImpComClienteMaxima;
            permiso.nImpComCorresponsalMaxima = producto.nImpComCorresponsalMaxima;
            permiso.nPerComisionProducto = producto.nPerComisionProducto;
            permiso.nPerPagoProveedor = producto.nPerPagoProveedor;
            permiso.nPerMargen = producto.nPerMargen;
            permiso.nPerComClienteMaxima = producto.nPerComClienteMaxima;
            permiso.nPerComCorresponsalMaxima = producto.nPerComCorresponsalMaxima;
            permiso.nEstatus = permiso.nIdEstatusPermiso; // Esta propiedad es la que se usa para filtrar los datos
        }

    });

    generarTabla(permisos);
}

const generarTabla = (dataSet) => {
    elemInformacionPermisos.html(`
        <table id="tblPermisos" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>PRODUCTO</th>
                    <th>PROVEEDOR</th>
                    <th class="text-center">TIPO <br> COMISIÓN</th>
                    <th class="text-center informativo">COMISIÓN <br> COBRO AL <br> PROVEEDOR</th>
                    <th class="text-center informativo">COMISIÓN <br> PAGO AL <br> PROVEEDOR</th>
                    <th class="text-center informativo">COMISIÓN <br> MÍNIMA <br> MARGEN RED</th>
                    <th class="text-center informativo">COMISIÓN <br> MÁXIMA <br> USUARIO</th>
                    <th class="text-center">COMISIÓN <br> USUARIO</th>
                    <th class="text-center">COMISIÓN <br> ESPECIAL</th>
                    <th class="text-center">COMISIÓN <br> GRUPAL</th>
                    <th class="text-center">COMISIÓN <br> FRENTE <br> (NO SE VALIDA)</th>
                    <th class="text-center">COMISIÓN <br> CADENA</th>
                    <th class="text-center informativo">COMISIÓN <br> CADENA <br>(FACTURA)</th>
                    <th class="text-center informativo">COMISIÓN <br> RED <br>(FACTURA)</th>
                    <th class="text-center">ESTATUS <br> PERMISO</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>`
    );

    dataTablePermisos = $('#tblPermisos').DataTable({
        ...configuracionDefaultDataTable,
        data: dataSet,
        columns: [ 
            { 
                data: 'nIdProducto',
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') { 
                        // Columna check permiso
                        let checkbox = `<div class="checkbox"><label><input class="chkIdProducto" type="checkbox" ${(row.nSeleccionado == 1) ? 'checked' : ''} onchange="checkProducto(this, ${row.nIdRuta})"></label></div>`;

                        return checkbox;
                    }

                    return data;
                }
            },
            { 
                data: 'sNombreProducto'
            },
            {   
                data: 'sNombreProveedor'
            },
            { 
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') {
                        // Columna tipo de comisión
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let tipoComisionInicial = 0;
                        let campoDeshabilitado = '';

                        if (existePermiso != -1) { 
                            let permiso = permisos[existePermiso];
                            tipoComisionInicial = permiso.nTipoComision;
                        }

                        if (esWalmartInnovacion()) {
                            campoDeshabilitado = 'disabled';
                        }

                        let checarCambio = checarCambios('tipoComision', row.nIdRuta);
                        let selectTipoComision = `<select class="form-control selectTipoComision ${checarCambio}" onchange="tipoComision(this, ${row.nIdRuta})" ${campoDeshabilitado}>
                                            <option value="0" ${(tipoComisionInicial == 0) ? 'selected' : ''}>Importe</option>
                                            <option value="1" ${(tipoComisionInicial == 1) ? 'selected' : ''}>Porcentaje</option>
                                        </select>`;

                        return selectTipoComision;
                    }

                    return data;
                }
            },
            { 
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') {
                        // Columna comision cobro al proveedor
                        let signo = '$';
                        let valorCobroProveedor = row.nImpComisionProducto;

                        if (row.nTipoComision == 1) {
                            signo = '%';
                            valorCobroProveedor = row.nPerComisionProducto;
                        }

                        let txtComisionCobroProveedor = `<div class="input-group"><span class="input-group-addon informativo signo-${row.nIdRuta}">${signo}</span><input type="text" class="form-control text-right informativo" id="txtComisionCobroProveedor-${row.nIdRuta}" value="${valorCobroProveedor}" disabled="disabled"></div>`;

                        return txtComisionCobroProveedor;
                    }

                    return data;
                }
            },
            { 
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') {
                        // Columna comision pago al proveedor 
                        let signo = '$';
                        let valorPagoProveedor = row.nImpPagoProveedor;

                        if (row.nTipoComision == 1) {
                            valorPagoProveedor = row.nPerPagoProveedor;
                            signo = '%';
                        }

                        let txtComisionPagoProveedor = `<div class="input-group"><span class="input-group-addon informativo signo-${row.nIdRuta}">${signo}</span><input type="text" class="form-control text-right informativo" id="txtComisionPagoProveedor-${row.nIdRuta}" value="${valorPagoProveedor}" disabled="disabled"></div>`;

                        return txtComisionPagoProveedor;
                    }

                    return data;
                }
            },
            { 
                data: null, 
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') {
                        // Columna comision minima margen red
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let signo = '$';
                        let valorMargenRed = '0.0000';

                        if (existePermiso != -1) {
                            let permiso = permisos[existePermiso];

                            if (permiso.nTipoComision == 0) {
                                valorMargenRed = row.nImpMargen;
                            } else {
                                valorMargenRed = row.nPerMargen;
                                signo = '%';
                            }
                        } 

                        let txtComisionMargen = `<div class="input-group"><span class="input-group-addon informativo signo-${row.nIdRuta}">${signo}</span><input type="text" class="form-control text-right informativo" id="txtComisionMinimaMargenRed-${row.nIdRuta}" value="${valorMargenRed}" disabled="disabled"></div>`;

                        return txtComisionMargen;
                    }

                    return data;
                }
            },
            { 
                data: null, 
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') {
                        // Columna comisión máxima usuario
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let signo = '$';
                        let valorComisionMaximaUsuario = '0.0000';

                        if (existePermiso != -1) {
                            let permiso = permisos[existePermiso];

                            if (permiso.nTipoComision == 0) {
                                valorComisionMaximaUsuario = row.nImpComClienteMaxima;
                            } else {
                                valorComisionMaximaUsuario = row.nPerComClienteMaxima;
                                signo = '%';
                            }
                        }

                        let txtComisionMaximaUsuario = `<div class="input-group"><span class="input-group-addon informativo signo-${row.nIdRuta}">${signo}</span><input type="text" id="txtComisionMaximaUsuario-${row.nIdRuta}" class="form-control text-right informativo" value="${valorComisionMaximaUsuario}" disabled="disabled"></div>`;

                        return txtComisionMaximaUsuario;
                    }

                    return data;
                }
            },
            { 
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') { 
                        // Columna comisión usuario
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let valorComisionUsuario = "0.0000";
                        let signo = '$';
                        let campoDeshabilitado = '';
                        
                        if (existePermiso != -1) { 
                            let permiso = permisos[existePermiso];

                            if (permiso.nTipoComision == 0) {
                                valorComisionUsuario = permiso.nImpComCliente;
                            } else {
                                valorComisionUsuario = permiso.nPerComCliente;
                                signo = '%';
                                campoDeshabilitado = 'disabled';
                            }
                        }

                        if (esWalmartInnovacion()) {
                            campoDeshabilitado = 'disabled';
                        }

                        let checarCambio = checarCambios('comisionUsuario', row.nIdRuta);
                        let txtComisionUsuario = `<div class="input-group"><span class="input-group-addon signo-${row.nIdRuta}">${signo}</span><input type="text" class="form-control decimals text-right ${checarCambio} comision-usuario" style="padding-right: 5px;" id="txtComisionUsuario-${row.nIdRuta}" value="${valorComisionUsuario}" ${campoDeshabilitado} onkeyup="setearComisionUsuario(this, ${row.nIdRuta})" onblur="validarComisionUsuario(this, ${row.nIdRuta})"></div>`;

                        return txtComisionUsuario;
                    }
                    return data;
                }
            },
            { 
                data: null, 
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') { 
                        // Columna comisión especial
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let valorComisionEspecial = "0.0000";
                        let signo = '$';
                        let campoDeshabilitado = '';

                        if (existePermiso != -1) { 
                            let permiso = permisos[existePermiso];

                            if (permiso.nTipoComision == 0) {
                                valorComisionEspecial = permiso.nImpComEspecial;
                            } else {
                                valorComisionEspecial = permiso.nPerComEspecial;
                                signo = '%';
                                campoDeshabilitado = 'disabled';
                            }
                        }

                        if (esWalmartInnovacion()) {
                            campoDeshabilitado = 'disabled';
                        }

                        let checarCambio = checarCambios('comisionEspecial', row.nIdRuta);
                        let txtComisionEspecial = `<div class="input-group"><span class="input-group-addon signo-${row.nIdRuta}">${signo}</span><input type="text" class="form-control decimals text-right ${checarCambio} comision-especial" id="txtComisionEspecial-${row.nIdRuta}" value="${valorComisionEspecial}" ${campoDeshabilitado} onkeyup="setearComisionEspecial(this, ${row.nIdRuta})" onblur="validarComisionEspecial(this, ${row.nIdRuta})"></div>`;

                        return txtComisionEspecial;
                    }

                    return data;
                }
            }, 
            { 
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') {
                        // Columna comisión grupal (CG)
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let disabledCheck = '';

                        if (existePermiso != -1) {
                            let permiso = permisos[existePermiso];
                            disabledCheck = (permiso.nTipoComision == 0) ? 'disabled' : '';
                        }
                        
                        if (esWalmartInnovacion()) {
                            disabledCheck = 'disabled';
                        }

                        let checkbox = `<div class="checkbox comision-grupal"><label><input type="checkbox" class="chkComisionGrupal" id="grupal-${row.nIdRuta}" ${disabledCheck} onchange="checkPorcentajeCadena(this, ${row.nIdRuta})"></label></div>`;

                        return checkbox;
                    }

                    return data;
                }
            },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') {
                        // Columna comisión al frente (no se cobra)
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let valorComisionFrente = '0.0000';
                        let signo = '$';
                        let nTicketFiscal = elemNTicketFiscal.val();
                        let campoDeshabilitado = (nTicketFiscal == 2) ? '' : 'disabled';

                        if (existePermiso != -1) {
                            let permiso = permisos[existePermiso];
                           
                            if (permiso.nTipoComision == 0) {
                                valorComisionFrente = permiso.nImpComFrente;
                            } else {
                                valorComisionFrente = permiso.nPerComFrente;
                                signo = '%';
                                if (nTicketFiscal == 2) {
                                    campoDeshabilitado = 'disabled';
                                }
                            }
                        }

                        if (esWalmartInnovacion()) {
                            campoDeshabilitado = 'disabled';
                        }

                        let checarCambio = checarCambios('comisionFrente', row.nIdRuta);
                        let txtComisionFrente = `<div class="input-group"><span class="input-group-addon signo-${row.nIdRuta}">${signo}</span><input type="text" class="form-control decimals text-right ${checarCambio} comision-frente" id="txtComisionFrente-${row.nIdRuta}" ${campoDeshabilitado} value="${valorComisionFrente}" onkeyup="setearComisionFrente(this, ${row.nIdRuta})" onblur="validarComisionFrente(this, ${row.nIdRuta})"></div>`;

                        return txtComisionFrente;
                    }

                    return data;
                }
            },
            { 
                data: null, 
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') { 
                        // Columna comisión cadena
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let valorComisionCadena = "0.0000";
                        let signo = '$';
                        let campoDeshabilitado = '';

                        if (existePermiso != -1) { 
                            let permiso = permisos[existePermiso];

                            if (permiso.nTipoComision == 0) {
                                valorComisionCadena = permiso.nImpComCorresponsal;
                            } else {
                                valorComisionCadena = permiso.nPerComCorresponsal;
                                signo = '%';
                            }
                        }

                        if (esWalmartInnovacion()) {
                            campoDeshabilitado = 'disabled';
                        }

                        let checarCambio = checarCambios('comisionCadena', row.nIdRuta);
                        let txtComisionCadena = `<div class="input-group"><span class="input-group-addon signo-${row.nIdRuta}">${signo}</span><input type="text" class="form-control decimals text-right ${checarCambio} comision-cadena" id="txtComisionCadena-${row.nIdRuta}" value="${valorComisionCadena}" onkeyup="setearComisionCadena(this, ${row.nIdRuta})" onblur="validarComisionCadena(this, ${row.nIdRuta})" ${campoDeshabilitado}></div>`;

                        return txtComisionCadena;
                    }

                    return data;
                }
            },
            { 
                data: null, 
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') { 
                        // Columna comisión cadena (factura)
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let valorComisionCadenaFactura = "0.0000";
                        let signo = '$';

                        if (existePermiso != -1) { 
                            let permiso = permisos[existePermiso];

                            if (permiso.nTipoComision == 0) {
                                valorComisionCadenaFactura = permiso.nImpComCadenaFactura; 
                            } else {
                                valorComisionCadenaFactura = permiso.nPerComCadenaFactura;
                                signo = '%';
                            }
                        }

                        let checarCambio = checarCambios('comisionCadenaFactura', row.nIdRuta);
                        let txtComisionCadenaFactura = `<div class="input-group"><span class="input-group-addon signo-${row.nIdRuta} informativo">${signo}</span><input type="text" class="form-control decimals text-right ${checarCambio} comision-cadena-factura informativo" id="txtComisionCadenaFactura-${row.nIdRuta}" value="${valorComisionCadenaFactura}" disabled="disabled" onkeyup="setearImporteRed(this, ${row.nIdRuta})"></div>`;

                        return txtComisionCadenaFactura;
                    }

                    return data;
                }
            },
            { 
                data: null, 
                orderable: false,
                render: function (data, type, row) {
                    if (type === 'display') { 
                        // Columna comisión red (factura)
                        let existePermiso = buscarPermiso(row.nIdRuta);
                        let importeRed = "0.0000";
                        let signo = '$';

                        if (existePermiso != -1) { 
                            let permiso = permisos[existePermiso];

                            if (permiso.nTipoComision == 0) {
                                importeRed = permiso.nImpRed; 
                            } else {
                                importeRed = permiso.nPerRed;
                                signo = '%';
                            }
                        }

                        let checarCambio = checarCambios('comisionRedFactura', row.nIdRuta);

                        let txtComisionRED = `<div class="input-group"><span class="input-group-addon signo-${row.nIdRuta} informativo">${signo}</span><input type="text" class="form-control decimals text-right ${checarCambio} comision-red informativo" id="txtComisionRED-${row.nIdRuta}" value="${importeRed}" onkeyup="setearImporteRed(this, ${row.nIdRuta})" onblur="validarRedFactura(this, ${row.nIdRuta})" disabled="disabled"></div>`;

                        return txtComisionRED;
                    }
                    return data;
                }
            }, 
            {
                data: 'nEstatus',
                orderable: false,
                width: '100px',
                className: 'text-center',
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Columna estatus permiso
                        let sTextEstatus = 'Sin permiso';
                        let sClassName = 'sin-permiso';

                        if (data == 1) {
                            sTextEstatus = 'Pendiente';
                            sClassName = 'pendiente';
                        }

                        if (data == 0) {
                            sTextEstatus = 'Autorizado';
                            sClassName = 'autorizado';
                        }

                        let elemEstatus = `<span class="estatus ${sClassName}">${sTextEstatus}</span>`;
                        return elemEstatus;
                    }

                    return data;
                }
            }
        ],
        defarRender: true,
        scrollY: '500px',
        scrollX: true,
        fixedColumns: {
            left: 3
        },
        order: [[2, 'asc'], [1, 'asc']],
        autoWidth: false,
        drawCallback: function (settings, json) {
            if (elemNTicketFiscal.val() == 2) {
                habilitarDeshabilitarNeteo(true);
            }
            
            if (roleLector || roleAutorizador) {
                habilitarDeshabilitarInputs(true);
            }

            initInputs();
        },
        initComplete: function (settings, json) {
            console.log(settings, json);
            let seccionBotones = agregarBotones();
            $('#tblPermisos_wrapper .row')[0].childNodes[0].className = 'col-sm-4';
            $('#tblPermisos_wrapper .row')[0].childNodes[1].className = 'col-sm-4';

            $('#tblPermisos_wrapper .row .col-sm-4:last-child').before(seccionBotones);

            if (elemNTicketFiscal.val() == 2) {
                habilitarDeshabilitarNeteo(true);
            }

            if (roleLector) {
                elemSectionButtons.removeClass('show').addClass('hide');
                habilitarDeshabilitarInputs(true);
            } else {
                elemSectionButtons.removeClass('hide').addClass('show').css('text-align', 'right');

                if (roleAutorizador) {
                    habilitarDeshabilitarInputs(true);
                    let existenCambios = !validarExistenCambios();

                    elemBtnAutorizar.removeClass('hide').addClass('show');
                    elemBtnAutorizar.prop('disabled', existenCambios);
                }

                if (roleCapturista) {
                    elemBtnGuardar.removeClass('hide').addClass('show');
                }

                if (roleCapturistaYAutorizador) {
                    let existenCambios = !validarExistenCambios();

                    elemBtnAutorizar.removeClass('hide').addClass('show');
                    elemBtnAutorizar.prop('disabled', existenCambios);

                    // No mostramos el boton de guardar comisiones si el cliente es Walmart Innovacion
                    if (elemNIdCliente.val() != CLIENTE_WALMART_INNOVACION) {
                        elemBtnGuardar.removeClass('hide').addClass('show');
                    }
                }
                
            }

            if (esWalmartInnovacion()) {
                $('#btn-comision-grupal').prop('disabled', true);
            }

            initInputs();
            hideSpinner();
        }, 
    });
}

const crearFiltroEstatusPermisos = (elem) => {
    const selectFiltroEstatusPermiso = document.createElement('select');
    selectFiltroEstatusPermiso.id = 'filtro-estatus';
    selectFiltroEstatusPermiso.className = 'form-control';

    filtroEstatusPermiso.forEach((filtro) => {
        let option = document.createElement('option');
        option.value = filtro.id;
        option.text = filtro.value;

        selectFiltroEstatusPermiso.appendChild(option);
    });

    selectFiltroEstatusPermiso.addEventListener('change', function (e) {
        let nIdEstatus = e.target.value;
        dataTablePermisos.column(15).search(nIdEstatus == -1 ? '' : '^' + nIdEstatus + '$', true, false).draw();
    });

    elem.appendChild(selectFiltroEstatusPermiso);

    return elem;
}

const agregarBotones = () => {
    const row = document.createElement('div');
    const contenedorBotones = document.createElement('div');
    const lblFiltroEstatus = document.createElement('label');
    const btnComsionGrupal = document.createElement('button');
    const btnExportarExcel = document.createElement('button');

    row.className = 'col-sm-4';

    contenedorBotones.id = 'tblPermisos_buttons';
    contenedorBotones.className = 'dataTables_buttons';

    lblFiltroEstatus.innerHTML = 'Filtro estatus: ';
    const selFiltroEstatus = crearFiltroEstatusPermisos(lblFiltroEstatus);
   
    btnComsionGrupal.id = 'btn-comision-grupal';
    btnComsionGrupal.type = 'button';
    btnComsionGrupal.className = 'btn btn-info';
    btnComsionGrupal.textContent = 'Comisión grupal';
    btnComsionGrupal.addEventListener('click', function(e) {
        if (productosComisionCadena.length == 0) {
            jAlert('Debe seleccionar mínimo un registro en la columna comisión grupal.', 'Aviso');
            return;
        }

        $('#comision-grupal').modal({backdrop: 'static'});
    });

    btnExportarExcel.id = 'btn-export-excel';
    btnExportarExcel.type = 'button';
    btnExportarExcel.className = 'btn btn-info';
    btnExportarExcel.textContent = 'Excel';
    btnExportarExcel.addEventListener('click', function () {
        $(this).html('Excel <span class="btn-spinner hide"><i class="fa fa-spinner"></i></span>');
        exportarExcel();
    });

    contenedorBotones.appendChild(lblFiltroEstatus);
    contenedorBotones.appendChild(btnExportarExcel);
    contenedorBotones.appendChild(btnComsionGrupal);
    row.appendChild(contenedorBotones);

    return row;
}

const exportarExcel = () => {
    $('#btn-export-excel').prop('disabled', true);
    $('#btn-export-excel span').removeClass('hide').addClass('show');

    let nIdCliente = elemNIdCliente.val(); 
    let nIdCadena = elemTxtIdCadena.val(); 
    let nIdSubCadena = elemTxtIdSubCadena.val(); 
    let nIdCorresponsal = elemSelectCorresponsal.val(); 
    let nIdProveedor = elemSelectProveedor.val();
    let nIdFiltro = $('#filtro-estatus').val();
    // Tipo de Reporte: 
    // 1 => Muestra todos los productos y los que tengas permisos asignados.
    // 2 => Muestra solo los productos que tienen permisos asignados.
    let tipoReporte = (roleCapturista || roleLector) ? 1 : 2;
    let mostrarPermisosAutorizados = (roleCapturista) ? 1 : 0; 
    let sNombreCliente = elemTxtCliente.val();

    const excelForm = `
                <form id="formExcel" method="post" action="${urlExportarExcel}" >
                    <input type="hidden" name="idCliente" value="${nIdCliente}" />
                    <input type="hidden" name="cadena" value="${nIdCadena}" />
                    <input type="hidden" name="subcadena" value="${nIdSubCadena}" />
                    <input type="hidden" name="corresponsal" value="${nIdCorresponsal}"/>
                    <input type="hidden" name="proveedor" value="${nIdProveedor}" />
                    <input type="hidden" name="tipoReporte" value="${tipoReporte}" />
                    <input type="hidden" name="nIdFiltro" value="${nIdFiltro}" />
                    <input type="hidden" name="mostrarPermisosAutorizados" value="${mostrarPermisosAutorizados}" />
                    <input type="hidden" name="nombreCliente" value="${sNombreCliente}" />
                </form>
            `;
    $('body').append(excelForm);
    $('#formExcel').submit();
    $('#formExcel').remove();

    $('#btn-export-excel span').removeClass('show').addClass('hide');
    $('#btn-export-excel').prop('disabled', false);
}

const existenPermisosSeleccionados = () => {
    const permisosSeleccionados = permisos.filter(permiso => permiso.nSeleccionado == 1);
    let hayPermisosSeleccionados = false;

    if (permisosSeleccionados.length > 0) {
        hayPermisosSeleccionados = true;
    }
    return hayPermisosSeleccionados;
}

const validarComisionesMaximas = () => {
    const permisosSeleccionados = permisos.filter(permiso => permiso.nSeleccionado == 1);

    permisosSeleccionados.forEach(permiso => {
        permiso.bPermisoValido = true;
        let comisionCadenaMaxima = obtenerComisionCadenaMaxima(permiso);
        let comisionCadena = 0;
        if (permiso.nTipoComision == 0) {
            comisionCadena = permiso.nImpComCorresponsal;
            if (permiso.nImpMargen > 0) {
                if ((parseFloat(permiso.nImpComCliente) > parseFloat(permiso.nImpComClienteMaxima)) || 
                    (parseFloat(comisionCadena) > parseFloat(comisionCadenaMaxima))) {
                    permisosNoValidos.push(permiso.sNombreProducto);
                    permiso.bPermisoValido = false;
                } 
            } else {
                permisosNoValidos.push(permiso.sNombreProducto);
                permiso.bPermisoValido = false;
            }
        } else {
            comisionCadena = permiso.nPerComCorresponsal;
            if (permiso.nPerMargen > 0) {
                if ((parseFloat(permiso.nPerComCliente) > parseFloat(permiso.nPerComClienteMaxima)) || 
                    (parseFloat(comisionCadena) > parseFloat(comisionCadenaMaxima))) {
                    permisosNoValidos.push(permiso.sNombreProducto);
                    permiso.bPermisoValido = false;
                } 
            } else {
                permisosNoValidos.push(permiso.sNombreProducto);
                permiso.bPermisoValido = false;
            }
        }
    });
}

const initInputs = () => {
    $.fn.alphanum.setNumericSeparators({
        thousandsSeparator: "",
        decimalSeparator: "."
    });

    $('.decimals').numeric({
        allowMinus          : false,
        maxDigits           : 6,
        maxDecimalPlaces    : 4,
        allowOtherCharSets  : false,
        allowDecSep         : true
    });
}

const habilitarDeshabilitarInputs = (disabled) => {
    $('.chkIdProducto, #selectRuta, .decimals, .selectTipoComision, .chkComisionGrupal, #btn-comision-grupal').prop('disabled', disabled);
}

const habilitarDeshabilitarNeteo = (disabled) => {
    $('.comision-usuario, .comision-especial').prop('disabled', disabled);
}

elemSelectCorresponsal.on('change', function (evt) {
    elemSelectProveedor.val('-1');
    permisos = [];
    permisosOriginal = [];
    productos = [];
    permisosNoValidos = [];
    productosNoSeleccionados = [];

    if (dataTablePermisos) {
        dataTablePermisos.destroy(true);
    }
    dataTablePermisos = null;
    elemSectionButtons.removeClass('show').addClass('hide');
});

elemSelectProveedor.on('change', function (evt) {
    permisos = [];
    permisosOriginal = [];
    productos = [];
    permisosNoValidos = [];
    productosNoSeleccionados = [];

    if (evt.target.value == -1) {
        dataTablePermisos.destroy(true);
        dataTablePermisos = null;
        elemBtnGuardar.removeClass('show').addClass('hide');
    } else {
        showSpinner();
        obtenerPermisos();
    }
});

elemBtnGuardar.on('click', function() {
    let permisosSeleccionados = existenPermisosSeleccionados();

    if (permisosSeleccionados) {
        if (productosNoSeleccionados.length == 0) {
            let texto = '';

            // No se validan las comisiones cuando el cliente es Walmart Innovacion
            // if (elemNIdCliente.val() != CLIENTE_WALMART_INNOVACION) {
            if (!esWalmartInnovacion()) {
                validarComisionesMaximas();
            }

            if (permisosNoValidos.length > 0) {
                texto += 'Los permisos asignados a los siguientes productos no se guardarán  debido a que exceden los máximos de las comisiones permitidas: <br><br>';
                permisosNoValidos.forEach(permiso => {
                    texto += `${permiso}<br>`;
                });
            }

            texto += '<br>¿Está seguro que desea guardar los cambios realizados en los permisos?';

            botonAccion = 'guardar';
            $('#modal-confirmacion .modal-title').text('Confirmar permisos');
            $('#modal-confirmacion .modal-text').html(texto);
            elemModalConfimacion.modal({backdrop: 'static'});
        } else {
            let alerta = 'Los siguiente productos tienen comisiones asignadas pero no se han seleccionado.\n Favor de seleccionarlos.\n';
            
            productosNoSeleccionados.forEach(producto => {
                alerta += `${producto.sNombreProducto}\n`;
            });

            jAlert(alerta, 'Aviso');
        }
    } else {
        jAlert('Tiene que seleccionar por lo menos un producto y configurar sus comisiones', 'Aviso');
    }
});

elemBtnConfirmacion.on('click', function () {
    if (roleCapturista) {
        guardarPermiso();
    }

    if (roleAutorizador) {
        autorizarPermisos();
    }

    if (roleCapturistaYAutorizador) {
        if (botonAccion == 'guardar') {
            guardarPermiso();
        }

        if (botonAccion == 'autorizar') {
            autorizarPermisos();
        }
    }
});

elemBtnCancelarConfirmacion.on('click', function () {
    permisosNoValidos = [];
    elemModalConfimacion.modal('hide');
});

elemBtnBuscar.on('click', () => {
    let idCliente = elemNIdCliente.val();
    let ticketFiscal = elemNTicketFiscal.val();
    const ticketFiscales = {
        0: '- Cliente retiene comisión',
        1: '- Red retiene comisión',
        2: '- Neteo de comisiones'
    };

    let textoTicketFiscal = ticketFiscales[ticketFiscal];

    elemDescTicketFiscal.text(textoTicketFiscal);
    
    if (idCliente == '' || (elemTxtCliente.val() == '')) {
        jAlert('Tiene que seleccionar un cliente', 'Aviso');
        return;
    }
    
    if (ticketFiscal == '') {
        jAlert('El cliente seleccionado no tiene configurado el campo Ticket fiscal', 'Alerta');
        return;
    }

    resetInputs();
    elemBtnBuscar.prop('disabled', true);
    $('.btn-spinner').removeClass('hide').addClass('show');
    obtenerCadenaSubcadenaCorresponsales(idCliente);
});

elemBtnAutorizar.on('click', () => {
    let permisosSeleccionados = existenPermisosSeleccionados();
    
    if (permisosSeleccionados) {
        botonAccion = 'autorizar';
        $('#modal-confirmacion .modal-title').text('Confirmar autorización de permisos');
        $('#modal-confirmacion .modal-text').text('¿Está seguro que desea autorizar los cambios realizados en los permisos?');

        elemModalConfimacion.modal({backdrop: 'static'});
    } else {
        jAlert('Tiene que seleccionar por lo menos un producto y configurar sus comisiones', 'Aviso');
        return;
    }
});

elemBtnAsignarComisionGrupal.on('click', () => {
    let esAsignarComisionGrupalValido = validarCampo(elemTxtComisionCadenaGrupal);

    if (!esAsignarComisionGrupalValido) {
        return;
    }

    let comisionCadenaGrupal = elemTxtComisionCadenaGrupal.val();
    comisionCadenaGrupal = parseFloat(comisionCadenaGrupal).toFixed(4);

    productosComisionCadena.forEach(producto => {
        let indexPermiso = buscarPermiso(producto.idRuta);

        if (indexPermiso != -1) {
            let permiso = permisos[indexPermiso];

            if (permiso.nTipoComision == 1) {
                permiso.nPerComCorresponsal = comisionCadenaGrupal;
                permiso.nPerComCadenaFactura = comisionCadenaGrupal;
                permiso.bModificado.comisionCadena = esModificado(producto.idRuta, comisionCadenaGrupal, 'nPerComCorresponsal');
            }
        }

        $(`#txtComisionCadena-${producto.idRuta}`).val(comisionCadenaGrupal);
        $(`#txtComisionCadenaFactura-${producto.idRuta}`).val(comisionCadenaGrupal);
    });

    limpiarComisionGrupal();
    elemTxtComisionCadenaGrupal.val('0.0000');
    productosComisionCadena = [];
    $('#comision-grupal').modal('hide');
});

elemBtnCancelarComisionGrupal.on('click', () => {
    limpiarComisionGrupal();
    productosComisionCadena = [];
    elemTxtComisionCadenaGrupal.val('0.0000');

    $('#comision-grupal').modal('hide');
});

elemTxtComisionCadenaGrupal.on('blur', function () {
    let comisionCadenaGrupal = elemTxtComisionCadenaGrupal.val();
    comisionCadenaGrupal = parseFloat(comisionCadenaGrupal).toFixed(4);
    $(this).val(comisionCadenaGrupal);
});

const initPermisos = () => {
    urlPrincipal = `${BASE_PATH}/MesaControl/Permisos/ajax/permisos.php`;
    urlExportarExcel = `${BASE_PATH}/MesaControl/Permisos/ajax/descargarPermisos.php`;
    let panelTitulo = 'Capturar';
    initAutocomplete();

    if (ROLES.length > 0) {
        let indexCapturista = ROLES.findIndex(role => role.nIdTipoUsuario == 1);
        let indexAutorizador = ROLES.findIndex(role => role.nIdTipoUsuario == 2);
        let indexCapturistaAutorizador = ROLES.findIndex(role => role.nIdTipoUsuario == 3);
        
        if (indexCapturista >= 0) {
            roleCapturista = true;
        } 

        if (indexAutorizador >= 0) {
            panelTitulo = 'Autorizar';
            roleAutorizador = true;
        }

        if (indexCapturistaAutorizador >= 0) {
            panelTitulo = 'Modificar / Autorizar';
            roleCapturistaYAutorizador = true;
            roleCapturista = false;
            roleAutorizador = false;
        }
    } else {
        panelTitulo = 'Lectura';
        roleLector = true;
    }

    $('#panel-title').text(panelTitulo);
}

elemModalConfimacion.on('hidden.bs.modal', function () {
    permisosNoValidos = [];
});
