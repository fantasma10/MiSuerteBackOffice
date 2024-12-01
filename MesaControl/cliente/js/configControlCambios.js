var secciones                             = [];
var tipo_actualizacion_control_cambios  = 0;
var control_cambios                       = [];
var catalogos                             = [];
var matrizCalendario_recaudo              = [];
var matrizCalendario_pago                 = [];
var matrizCalendario_cobro                = [];
var calendario                            = [];
var sCorreoEnvio_original                 = [];
var sCorreoEnvio_controlCambios           = [];
var sCorreoDestino_original               = [];
var sCorreoDestino_controlCambios         = [];
var sCorreoDestinoTae_original            = [];
var sCorreoDestinoTae_controlCambios      = [];
var familiasOriginales                    = [];
var usuario_id                          = 0;
var pruebasProduccionOriginal             = [];
var comisionUsuarioFinalOriginal          = [];
var checksForms = {
    checkIntegrador: 0,
    checkVigencia: 0
}
var mapForm = [];

/* Definición de catálogos para sccion 1*/
catalogos.cmbticket = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'De cliente'},
    {key: 1, value: 'De RED'},
    {key: 2, value: 'Neto de comisiones'},
];
catalogos.cmbforelo = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'Solo una'},
    {key: 1, value: 'Cuenta individual para servicios y otra para TAE'}
];
catalogos.cmbReqFacTAE = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'No'},
    {key: 1, value: 'Si'}
];
catalogos.tipoLiqRecaudo = [
    {key: 1, value: 'FORELO (Prepago)'},
    {key: 2, value: 'Crédito'},
];
catalogos.limitCreditY = [
    {key: 1, value: 'Si'},
    {key: 0, value: 'No'},
];
catalogos.cmbRetieneComision = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'No'},
    {key: 1, value: 'Si'}
];
/* /Definición de catálogos para sccion 1*/

/*Definicion de catálogos para seccion 5*/
catalogos.cmbSemanalDiaOperaciones = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'Lunes'},
    {key: 1, value: 'Martes'},
    {key: 2, value: 'Miercoles'},
    {key: 3, value: 'Jueves'},
    {key: 4, value: 'Viernes'},
];
catalogos.cmbCostoTransferencia = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'No'},
    {key: 1, value: 'Si'}
];
catalogos.cmbRetieneComision = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'No'},
    {key: 1, value: 'Si'}
];
catalogos.cmbPeriodoPrepPagoCom = [
    {key: -1, value: 'Seleccione'},
    {key:1, value: "Pago a FORELO (con factura)"},
    {key:2, value: "Pago a FORELO (sin factura)"},
    {key:3, value: "Pago a Bancos"},
    {key:4, value: "Pago en Prepago (se descuenta la comisión en la liquidación del crédito)"},
];
catalogos.cmbSemanalDiaPago = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'Lunes'},
    {key: 1, value: 'Martes'},
    {key: 2, value: 'Miercoles'},
    {key: 3, value: 'Jueves'},
    {key: 4, value: 'Viernes'},
];
catalogos.cmbSemanalDiaCobro = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'Lunes'},
    {key: 1, value: 'Martes'},
    {key: 2, value: 'Miercoles'},
    {key: 3, value: 'Jueves'},
    {key: 4, value: 'Viernes'},
];
catalogos.cmbComisionIntegrador = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'No'},
    {key: 1, value: 'Si'}
];
catalogos.cmb_valida_monto = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'No'},
    {key: 1, value: 'Si'}
];
/* Definicion de catálogos para seccion 6*/
catalogos.cmbCFDIComision               = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbCFDITAE                    = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbFormaPagoComision          = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbFormaPagoTAE               = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbMetodoPagoComision         = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbMetodoPagoTAE              = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbProductoServicioComision   = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbProductoServicioTAE        = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbClaveUnidadComision        = [{'key': -1, 'value': 'Seleccione'}];
catalogos.cmbClaveUnidadTAE             = [{'key': -1, 'value': 'Seleccione'}];
catalogos.periocidadComision = [
    {key: -1, value: 'Seleccione'},
    {key: 1, value: 'Semanal'},
    {key: 2, value: 'Quincenal'},
    {key: 3, value: 'Mensual'},
];
catalogos.periocidadTAE = [
    {key: -1, value: 'Seleccione'},
    {key: 1, value: 'Semanal'},
    {key: 2, value: 'Quincenal'},
    {key: 3, value: 'Mensual'},
];
catalogos.cmbIVAComision = [
    {key: -1, value: 'Seleccione'},
    {key: 0.1600, value: '16%'},
    {key: 0.0800, value: '8%'},
    {key: 0.0000, value: '0%'},
];
catalogos.nRetieneIVA = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'No'},
    {key: 1, value: 'Si'}
];
catalogos.nRetieneISR = [
    {key: -1, value: 'Seleccione'},
    {key: 0, value: 'No'},
    {key: 1, value: 'Si'}
];
