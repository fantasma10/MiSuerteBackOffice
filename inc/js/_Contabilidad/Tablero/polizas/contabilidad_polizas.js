function initView(){

	//cargarListaCfgEstadoCuenta();
	initModalCuentaBancaria();
	llenarSelectCuentas();
	initPolizaIngresos();
	initPolizaIngresosComplementaria();
	initPolizaNoIdentificados();
	initButtonsQTips();
	initFechaFiltro();
	initCapturaDeposito();

	$('form[name=filtrosCfg] :input[name=nIdCfg]').on('change', function(e){
		var nIdCfg = e.target.value;
		if(nIdCfg == -1){
			$('#modal-alta_cuenta').modal('show');
		}
	});

	$('.class-show_tooltip').tooltip({
		tooltipSourceID	: '#example3Content',
		loader			: 1,
		loaderImagePath	: 'animationProcessing.gif',
		loaderHeight	:16,
		loaderWidth		:17,
		width			:'400px',
		height			:'200px',
		tooltipSource	:'inline',
		borderSize		:'0',
		tooltipBGColor	:'#efefef'
	});

	$('form[name=filtrosCfg] :input[name=dFechaInicio], form[name=filtrosCfg] :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});

	var hoy = fnHoy();

	$('form[name=filtrosCfg] :input[name=dFechaInicio], form[name=filtrosCfg] :input[name=dFechaFinal]').val(hoy);

	$('form[name=filtrosCfg] :input[name=dFechaInicio], form[name=filtrosCfg] :input[name=dFechaFinal]').alphanum({
		allow		: '1234567890-',
		disallow	: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		maxLength	: 10
	});

	$('form[name=filtrosCfg] :input[name=nIdCfg]').on('storeLoaded', function(e){
		if(bES_ESCRITURA == 1 || bES_ESCRITURA == true){
			var option		= document.createElement("option");
			option.text		= "Nueva";
			option.value	= -1;
			$('form[name=filtrosCfg] :input[name=nIdCfg]').append(option);
		}
	});

	$('form[name=formCapturaDeposito] :input[name=sNombreCliente]').autocomplete({
		serviceUrl				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/autocomplete_getListaClientes.php',
		type					: 'post',
		dataType				: 'json',
		preventBadQueries		: false,
		width					: 300,
		paramName				: 'text',
		params					: {
			categoria			: 2
		},
		onSearchStart			: function (options){
			$('form[name=formCapturaDeposito] :input[name=nIdCliente]').val('');
			resetCuentaContable();
		},
		onSelect				: function (suggestion){
			$('form[name=formCapturaDeposito] :input[name=nIdCliente]').val(suggestion.data);
			buscaCuentaContable(suggestion.nIdCadena, suggestion.data, -1);
		}
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreCliente]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltrosCuenta] :input[name=nIdCliente]').val('');
			resetCuentaForelo();
		}
	});

	$('#btnFiltros').on('click', function(e){
		buscaDatos();
	});

	$('#btnPolizaIngresos').on('click', function(e){
		generarPolizaDeIngresos();
	});

	$('#btnPolizaIngresosComplementaria').on('click', function(e){
		generarPolizaDeIngresosComplementaria();
	});

	$('#btnPolizaNoIdentificados').on('click', function(e){
		generarPolizaDeIngresosNoIdentificados();
	});

	$('#aDescargaPoliza1, #aDescargaPoliza2, #aDescargaPoliza3').on('click', function(e){
		var target		= e.target;
		var nIdPoliza	= $(target).attr('nidpoliza');

		descargarPoliza(nIdPoliza);

	});
}//initView

function llenarSelectCuentas(){
	$('form[name=filtrosCfg] :input[name=nIdCfg]').prop('disabled', false);
	$('form[name=filtrosCfg] :input[name=nIdCfg]').customLoadStore({
		url				: '../../../inc/ajax/_Contabilidad/Tablero/listaCfgCuentas.php',
		labelField		: 'sCuentaMap',
		idField			: 'nIdCfg',
		firstItemId		: '-2',
		firstItemValue	: 'Seleccione Cuenta'
	});
}//llenarSelectCuentas

function llenarSelectCuentasDNI(){
	$('form[name=formPolizaIngresosNoIdentificados] :input[name=nIdCfg]').prop('disabled', false);
	$('form[name=formPolizaIngresosNoIdentificados] :input[name=nIdCfg]').customLoadStore({
		url				: '../../../inc/ajax/_Contabilidad/Tablero/listaCfgCuentas.php',
		labelField		: 'sCuentaMap',
		idField			: 'nIdCfg',
		firstItemId		: '-2',
		firstItemValue	: 'Seleccione Cuenta'
	});
}//llenarSelectCuentas



function loadData(nIdBanco, sNombreBanco, nIdCfg){
	$('form[name=filtrosCfg] :input[name=nIdBanco]').val(nIdBanco);
	$('form[name=filtrosCfg] :input[name=sNombreBanco]').val(sNombreBanco);

	llenarSelectCuentas(nIdBanco);

	$('form[name=filtrosCfg] :input[name=nIdCfg]').on('storeLoaded', function(e, g){
		$(this).val(nIdCfg);
	});
}

function initModalCuentaBancaria(){
	$('form[name=formAltaCuentaBancaria] :input[name=sNombreBanco]').autocomplete({
		serviceUrl				: '../../../inc/ajax/_Contabilidad/Tablero/autocompleteBancos.php',
		type					: 'post',
		dataType				: 'json',
		preventBadQueries		: false,
		width					: 300,
		onSearchStart			: function (query){
			$('form[name=formAltaCuentaBancaria] :input[name=nIdBanco]').val('');
		},
		onSelect				: function (suggestion){
			$('form[name=formAltaCuentaBancaria] :input[name=nIdBanco]').val(suggestion.data);
		}
	});

	$('form[name=formAltaCuentaBancaria] :input[name=sNombreBanco]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formAltaCuentaBancaria] :input[name=nIdBanco]').val('');
		}
	});

	$('form[name=formAltaCuentaBancaria] :input[name=sNombreBanco]').alphanum({
		allow				: '-ñÑáÁéÉíÍóÓúÚüÜ,.',
		disallow			: '',
		allowSpace			: true,
		allowNumeric		: true,
		allowLatin			: true,
		allowOtherCharSets	: false,
		maxLength			: 45
	});

	$('form[name=formAltaCuentaBancaria] :input[name=nNumCuentaBancaria]').numeric({
		allowMinus			: false,
		allowThouSep		: false,
		allowDecSep			: false,
		allowLeadingSpaces	: false,
		maxDecimalPlaces	: 0,
		maxDigits			: 11
	});

	$('form[name=formAltaCuentaBancaria] :input[name=nNumCuentaContable]').alphanum({
		allow				: '-',
		disallow			: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		allowSpace			: false,
		allowNumeric		: true,
		allowLatin			: true,
		allowOtherCharSets	: false,
		maxLength			: 15
	});

	$('form[name=formAltaCuentaBancaria] :input[name=nIdTipoOperacion]').customLoadStore({
		url				: '../../../inc/ajax/_Contabilidad/Tablero/storeTipoOperacion.php',
		labelField		: 'sNombreTipoOperacion',
		idField			: 'nIdTipoOperacion',
		firstItemId		: '-1',
		firstItemValue	: 'Seleccione'
	});

	$('#btnGuardarCuentaBancaria').on('click', function(e){
		guardarCuentaBancaria();
	});
}

function guardarCuentaBancaria(){
	var params = $('form[name=formAltaCuentaBancaria]').getSimpleParams();

	if(params.nIdBanco == undefined || params.nIdBanco <= 0 || params.nIdBanco == ''){
		jAlert('Seleccione Banco', 'Alerta');
		return false;
	}

	if(params.nNumCuentaBancaria == undefined || params.nNumCuentaBancaria <= 0 || params.nNumCuentaBancaria == ''){
		jAlert('Capture N\u00FAmero de Cuenta Bancaria');
		return false;
	}

	if(params.nNumCuentaContable == undefined || params.nNumCuentaContable <= 0 || params.nNumCuentaContable == ''){
		jAlert('Capture N\u00FAmero de Cuenta Contable');
		return false;
	}

	if(params.nIdTipoOperacion == undefined || params.nIdTipoOperacion <= 0 || params.nIdTipoOperacion == ''){
		jAlert('Seleccione Tipo de Operaci\u00F3n');
		return false;
	}

	jConfirm('\u00BFDesea guardar la informaci\u00F3n?', 'Confirmaci\u00F3n', function(r) {
		if(r == true){
			showSpinner();
			$.ajax({
				url			: BASE_PATH + '/inc/ajax/_Contabilidad/Tablero/guardarCfgCuenta.php',
				type		: 'POST',
				dataType	: 'json',
				data		: params
			})
			.done(function(resp){
				jAlert(resp.sMensaje);
				if(resp.bExito == true && resp.nCodigo == 0){
					$('#modal-alta_cuenta').modal('hide');
					llenarSelectCuentas();
				}
			})
			.fail(function(){
				jAlert('Error General');
			})
			.always(function(){
				hideSpinner();
			});
		}
	});
}

function showCheckBox(){
	var th = $('#tbl-banco th')[0];
	$(th).append('<input type="checkbox" onclick="selectAllRows(event);"/>');
}

function selectAllRows(event){
	var target	= event.target;
	var checked = $(target).is(':checked');
	$('#tbl-banco tr td :input[type=checkbox]').prop('checked', checked);
}

function generarPolizaDeIngresos(){
	$('#modal-poliza_ingresos').unbind('hidden.bs.modal');
	$('#modal-poliza_ingresos').on('hidden.bs.modal', function(e){
		$('#aDescargaPoliza1').attr('nidpoliza', 0);
		$('#aDescargaPoliza1').fadeOut();
	});

	$('#modal-poliza_ingresos').modal('show');
}

function generarPolizaDeIngresosComplementaria(){
	$('#modal-poliza_ingresos_complementaria').unbind('hidden.bs.modal');
	$('#modal-poliza_ingresos_complementaria').on('hidden.bs.modal', function(e){
		$('#aDescargaPoliza2').attr('nidpoliza', 0);
		$('#aDescargaPoliza2').fadeOut();
	});

	$('#modal-poliza_ingresos_complementaria').modal('show');
}

function generarPolizaDeIngresosNoIdentificados(){
	var elementos = $('#tbl-banco tr td :input[type=checkbox]:checked');

	if(elementos.length == 0){
		jAlert('Debe seleccionar por lo menos un movimiento', 'Mensaje');
		return false;
	}

	var dFechaInicio	= $('form[name=filtrosCfg] :input[name=dFechaInicio]').val();
	var dFechaFinal		= $('form[name=filtrosCfg] :input[name=dFechaFinal]').val();
	var sConcepto		= 'DEPOSITOS POR IDENTIFICAR DEL ' + dFechaInicio + ' AL ' + dFechaFinal;

	$('form[name=formPolizaIngresosNoIdentificados] :input[name=sConcepto]').val(sConcepto);

	var nDiasInicio	= restaFechas(dFechaInicio,	fnHoy());
	var nDiasFinal	= restaFechas(dFechaFinal, fnHoy());
	var sMensaje	= "";

	if(nDiasInicio <= 29){
		sMensaje = "La Fecha de Inicio es Menor a 30 d\u00EDas";
	}

	if(nDiasFinal <= 29){
		sMensaje+= "La Fecha Final es Menor a 30 d\u00EDas";
	}

	if(sMensaje != ""){
		jConfirm(sMensaje, 'Confirmaci\u00F3n', function(r){
			if(r){
				$('#modal-poliza_ingresos_no_identificados').modal('show');
			}
		});
	}
	else{
		$('#modal-poliza_ingresos_no_identificados').modal('show');
	}

	llenarSelectCuentasDNI();
	$('form[name=formPolizaIngresosNoIdentificados] :input[name=nIdCfg]').unbind('storeLoaded');
	$('form[name=formPolizaIngresosNoIdentificados] :input[name=nIdCfg]').on('storeLoaded', function(e){
		deleteOptionSelect();
	});
}

function initPolizaIngresos(){
	$('form[name=formPolizaIngresos] :input[name=dFecha]').datepicker({
		format : 'yyyy-mm-dd'
	});

	var hoy = fnHoy();

	$('form[name=formPolizaIngresos] :input[name=dFecha]').val(hoy);
	$('form[name=formPolizaIngresos] :input[name=sFolio]').alphanum({
		allow		: '1234567890-',
		maxLength	: 10
	});

	var sFolio	= hoy.replace(new RegExp('-', 'g'), '');
	var sFolio2 = '1' + sFolio;

	$('form[name=formPolizaIngresos] :input[name=sFolio]').val(sFolio);

	$('form[name=formPolizaIngresos] :input[name=sConcepto]').alphanum({
		allow		: '1234567890-',
		maxLength	: 200
	});

	var sConcepto	= 'DEPOSITOS CORRESPONDIENTES AL ' + hoy;

	$('form[name=formPolizaIngresos] :input[name=sConcepto]').val(sConcepto);

	$('#btnGeneraPolizaIngresos').on('click', function(e){
		generaPolizaIngresos();
	});
} // initPolizaIngresos

function initPolizaIngresosComplementaria(){
	$('form[name=formPolizaIngresosComplementaria] :input[name=dFecha2]').datepicker({
		format : 'yyyy-mm-dd'
	});

	var hoy = fnHoy();

	$('form[name=formPolizaIngresosComplementaria] :input[name=dFecha2]').val(hoy);
	$('form[name=formPolizaIngresosComplementaria] :input[name=sFolio2]').alphanum({
		allow		: '1234567890-',
		maxLength	: 10
	});

	var sFolio	= hoy.replace(new RegExp('-', 'g'), '');
	var sFolio2 = '1' + sFolio;

	$('form[name=formPolizaIngresosComplementaria] :input[name=sFolio2]').val(sFolio2);

	$('form[name=formPolizaIngresosComplementaria] :input[name=sConcepto2]').alphanum({
		allow		: '1234567890-',
		maxLength	: 200
	});

	var sConcepto2	= 'DEPOSITOS CONCILIADOS FUERA DE FECHA ' + hoy;
	$('form[name=formPolizaIngresosComplementaria] :input[name=sConcepto2]').val(sConcepto2);

	$('#btnGeneraPolizaIngresosComplementaria').on('click', function(e){
		generaPolizaIngresosComplementaria();
	});
} // initPolizaIngresos

function deleteOptionSelect(){
	var arraySelected = new Array();
	$('#tbl-banco :input[type=checkbox]:checked').each(function(index, el){
		var tr		= $(el).closest('tr');
		var td		= $(tr).find('td').get(2);
		var cuenta	= $(td).html();

		if(cuenta != undefined && cuenta != ''){
			if(arraySelected.indexOf(cuenta) < 0){
				arraySelected.push(cuenta);
			}
		}
	});

	var arrayDelete = new Array();
	$('form[name=filtrosCfg] :input[name=nIdCfg] option').each(function(index, el){
		var length = arraySelected.length;

		for(var i=0; i<length; i++){
			var cuenta	= arraySelected[i];
			var html	= $(el).html();
			var found	= html.search(eval('/'+cuenta+'/'));

			if(found >= 0){
				arrayDelete.push(index);
			}
		}
	});
	console.log(arraySelected, arrayDelete);
	for(var i=arrayDelete.length-1; i>=0; i--){
		var index = arrayDelete[i];
		$('form[name=formPolizaIngresosNoIdentificados] :input[name=nIdCfg] option:eq('+index+')').remove();
	}
}

function initPolizaNoIdentificados(){
	llenarSelectCuentasDNI();

	$('form[name=formPolizaIngresosNoIdentificados] :input[name=dFecha]').datepicker({
		format : 'yyyy-mm-dd'
	});

	var hoy = fnHoy();

	$('form[name=formPolizaIngresosNoIdentificados] :input[name=dFecha]').val(hoy);
	$('form[name=formPolizaIngresosNoIdentificados] :input[name=sFolio]').alphanum({
		allow		: '1234567890-',
		maxLength	: 10
	});

	var sFolio	= hoy.replace(new RegExp('-', 'g'), '');
	var sFolio2 = '1' + sFolio;

	$('form[name=formPolizaIngresosNoIdentificados] :input[name=sFolio]').val(sFolio);
	$('form[name=formPolizaIngresosNoIdentificados] :input[name=sConcepto]').alphanum({
		allow		: '1234567890-',
		maxLength	: 200
	});

	$('#btnGeneraPolizaIngresosNoIdentificados').on('click', function(e){
		generaPolizaIngresosNoIdentificados();
	});
}

function generaPolizaIngresos(){
	var params = $('form[name=formPolizaIngresos]').getSimpleParams();

	if(params.sFolio == undefined || params.sFolio == ''){
		jAlert('Capture Folio para P\u00F3liza de Ingresos', 'Mensaje');
		return false;
	}

	if(params.dFecha == undefined || params.dFecha == ''){
		jAlert('Seleccione Fecha para P\u00F3liza de Ingresos', 'Mensaje');
		return false;
	}

	if(params.sConcepto == undefined || params.sConcepto == ''){
		jAlert('Capture Concepto para P\u00F3liza de Ingresos', 'Mensaje');
		return false;
	}

	var elementos		= $('#tbl-banco tr td :input[type=checkbox]:checked');
	var length			= elementos.length;
	var array_el		= new Array();
	var bNoConciliados	= false;

	for(var i=0; i<length; i++){
		var el			= elementos[i];
		var nIdEstatus	= el.getAttribute('nidestatus');

		if(nIdEstatus != 0 && nIdEstatus != 2){
			bNoConciliados = true;
		}
	}

	if(bNoConciliados == true){
		jAlert('Seleccione Solamente Movimientos con Estatus "Conciliado" o "Conciliaci\u00F3n Parcial"', 'Mensaje');
		return false;
	}

	if(length <= 0){
		jAlert('Seleccione por lo menos un movimiento bancario', 'Mensaje');
		return false;
	}

	for(var i=0; i<length; i++){
		var el = elementos[i];
		array_el.push(el.value);
	}

	params.nIdMovBanco = array_el;	

	jConfirm('\u00BFDesea Generar la P\u00F3liza de Ingresos?', 'Confirmaci\u00F3n', function(c){
		if(c){

			showSpinner();
			$('#btnGeneraPolizaIngresos').prop('disabled', true);

			$.ajax({
				url			: '../../../inc/Ajax/_Contabilidad/Tablero/generaPolizaIngresos.php?'+$.now(),
				cache		: false,
				type		: 'POST',
				dataType	: 'json',
				data		: params
			})
			.done(function(resp){
				jAlert(resp.sMensaje);
				$('#btnGeneraPolizaIngresos').prop('disabled', false);

				if(resp.bExito == true){
					buscaDatos();

					if(resp.data.nIdPoliza1 != undefined && resp.data.nIdPoliza1 > 0){
						$('#aDescargaPoliza1').attr('nidpoliza', resp.data.nIdPoliza1);
						$('#aDescargaPoliza1').fadeIn();
					}
					else{
						$('#aDescargaPoliza1').fadeOut();
					}
				}
			})
			.fail(function(){
				console.log("error");
			})
			.
			always(function(){
				hideSpinner();
			});
		}
	});
} // generaPolizaIngresos

function generaPolizaIngresosComplementaria(){
	var params = $('form[name=formPolizaIngresosComplementaria]').getSimpleParams();

	if(params.sFolio2 == undefined || params.sFolio2 == ''){
		jAlert('Capture Folio para P\u00F3liza de Ingresos Complementaria', 'Mensaje');
		return false;
	}

	if(params.dFecha2 == undefined || params.dFecha2 == ''){
		jAlert('Seleccione Fecha para P\u00F3liza de Ingresos Complementaria', 'Mensaje');
		return false;
	}

	if(params.sConcepto2 == undefined || params.sConcepto2 == ''){
		jAlert('Capture Concepto para P\u00F3liza de Ingresos Complementaria', 'Mensaje');
		return false;
	}

	var elementos		= $('#tbl-banco tr td :input[type=checkbox]:checked');
	var length			= elementos.length;
	var array_el		= new Array();
	var bNoConciliados	= false;

	for(var i=0; i<length; i++){
		var el			= elementos[i];
		var nIdEstatus	= el.getAttribute('nidestatus');

		if(nIdEstatus != 0 && nIdEstatus != 2){
			bNoConciliados = true;
		}
	}

	if(bNoConciliados == true){
		jAlert('Seleccione Solamente Movimientos con Estatus "Conciliado" o "Conciliaci\u00F3n Parcial"', 'Mensaje');
		return false;
	}

	if(length <= 0){
		jAlert('Seleccione por lo menos un movimiento bancario', 'Mensaje');
		return false;
	}

	for(var i=0; i<length; i++){
		var el = elementos[i];
		array_el.push(el.value);
	}

	params.nIdMovBanco = array_el;

	jConfirm('\u00BFDesea Generar la P\u00F3liza de Ingresos Complementaria?', 'Confirmaci\u00F3n', function(c){
		if(c){

			showSpinner();
			$('#btnGeneraPolizaIngresosComplementaria').prop('disabled', true);

			$.ajax({
				url			: '../../../inc/Ajax/_Contabilidad/Tablero/generaPolizaIngresosComplementaria.php?'+$.now(),
				cache		: false,
				type		: 'POST',
				dataType	: 'json',
				data		: params
			})
			.done(function(resp){
				jAlert(resp.sMensaje);
				$('#btnGeneraPolizaIngresosComplementaria').prop('disabled', false);

				if(resp.bExito == true){
					buscaDatos();

					if(resp.data.nIdPoliza2 != undefined && resp.data.nIdPoliza2 > 0){
						$('#aDescargaPoliza2').attr('nidpoliza', resp.data.nIdPoliza2);
						$('#aDescargaPoliza2').fadeIn();
					}
					else{
						$('#aDescargaPoliza2').fadeOut();
					}
				}
			})
			.fail(function(){
				console.log("error");
			})
			.
			always(function(){
				hideSpinner();
			});
		}
	});
} // generaPolizaIngresos

function generaPolizaIngresosNoIdentificados(){
	var params = $('form[name=formPolizaIngresosNoIdentificados]').getSimpleParams();

	if(params.sFolio == undefined || params.sFolio == '' || params.sFolio <= 0){
		jAlert('Capture Folio', 'Mensaje');
		return false;
	}

	if(params.dFecha == undefined || params.dFecha == '' || params.dFecha <= 0){
		jAlert('Seleccione Fecha', 'Mensaje');
		return false;
	}

	if(params.sConcepto == undefined || params.sConcepto == '' || params.sConcepto <= 0){
		jAlert('Capture Concepto', 'Mensaje');
		return false;
	}

	if(params.nIdCfg == undefined || params.nIdCfg == '' || params.nIdCfg <= 0){
		jAlert('Seleccione Cuenta Destino', 'Mensaje');
		return false;
	}

	var elementos		= $('#tbl-banco tr td :input[type=checkbox]:checked');
	var length			= elementos.length;
	var array_el		= new Array();
	var bConciliados	= false;

	for(var i=0; i<length; i++){
		var el			= elementos[i];
		var nIdEstatus	= el.getAttribute('nidestatus');

		if(nIdEstatus == 0){
			bConciliados = true;
		}
	}

	if(bConciliados == true){
		jAlert('Seleccione Solamente Movimientos con Estatus "No Conciliado"', 'Mensaje');
		return false;
	}

	if(length <= 0){
		jAlert('Seleccione por lo menos un movimiento bancario', 'Mensaje');
		return false;
	}

	for(var i=0; i<length; i++){
		var el = elementos[i];
		array_el.push(el.value);
	}

	params.nIdMovBanco = array_el;

	jConfirm('\u00BFDesea Generar la P\u00F3liza de Dep\u00F3sitos no Identificados?', 'Confirmaci\u00F3n', function(c){
		if(c){
			showSpinner();
			$('#btnGeneraPolizaIngresosNoIdentificados').prop('disabled', true);
			$.ajax({
				url			: '../../../inc/Ajax/_Contabilidad/Tablero/generaPolizaDepositosNoIdentificados.php',
				type		: 'POST',
				dataType	: 'json',
				data		: params
			})
			.done(function(resp){
				jAlert(resp.sMensaje);

				if(resp.data.nIdPoliza != undefined && resp.data.nIdPoliza > 0){
					$('#aDescargaPoliza3').attr('nidpoliza', resp.data.nIdPoliza);
					$('#aDescargaPoliza3').fadeIn();
				}
				else{
					$('#aDescargaPoliza3').fadeOut();
				}
			})
			.fail(function(){
				console.log("error");
			})
			.always(function(){
				hideSpinner();
				$('#btnGeneraPolizaIngresosNoIdentificados').prop('disabled', false);
			});
		}
	});

}// generaPolizaIngresosNoIdentificados

function initButtonsQTips(){
	$('#btnPolizaNoIdentificados').attr('title', 'Movimientos <strong>No Conciliados</strong> mayores a 30 d&iacute;as');
	$('#btnPolizaIngresos').attr('title', 'Movimientos Conciliados');

	$('#btnPolizaNoIdentificados, #btnPolizaIngresos').powerTip({});
} // initButtonsQTips

function initCapturaDeposito(){
	$('form[name=formCapturaDeposito] :input[name=nNumCuentaContable]').alphanum({
		allow				: '1234567890-',
		disallow			: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		maxLength			: 12,
		allowOtherCharSets	: false,
		allowSpace			: false
	});

	$('form[name=formCapturaDeposito] :input[name=sDescripcion]').alphanum({
		allow				: '-ñÑáÁéÉíÍóÓúÚüÜ,.',
		disallow			: '',
		allowSpace			: true,
		allowNumeric		: true,
		allowLatin			: true,
		allowOtherCharSets	: false,
		maxLength			: 45
	});

	$('form[name=formCapturaDeposito] :input[name=nNumCuentaContable]').mask('000-0000-000');

	$('#btnCapturaDeposito').on('click', function(e){
		guardarDeposito();
	});
} // initCapturaDeposito

function guardarDeposito(){

	var params = $('form[name=formCapturaDeposito]').getSimpleParams();

	if(params.nIdBanco == undefined || params.nIdBanco <= 0){
		jAlert('Seleccione nuevamente el Movimiento', 'Mensaje');
		return false;
	}

	if(params.nAutorizacion == undefined || params.nAutorizacion < 0){
		jAlert('Seleccione nuevamente el Movimiento', 'Mensaje');
		return false;
	}

	if(params.nImporte == undefined || params.nImporte <= 0){
		jAlert('Seleccione un Movimiento con Importe mayor a 0', 'Mensaje');
		return false;
	}

	if(params.nNumCuentaContable == undefined || params.nNumCuentaContable <= 0){
		jAlert('Seleccione Cuenta Contable', 'Mensaje');
		return false;
	}

	if(params.sDescripcion == undefined || params.sDescripcion == ''){
		jAlert('Capture Descripci\u00F3n', 'Mensaje');
		return false;
	}

	if(params.sDescripcion.length > 45){
		jAlert('La Descripci\u00F3n debe ser de M\u00E1ximo 45 caracteres', 'Mensaje');
		return false;
	}

	params.sDescripcion = $('form[name=formCapturaDeposito] :input[name=sDescripcion]').val();

	jConfirm('\u00BFDesea aplicar el Dep\u00F3sito?', 'Confirmaci\u00F3n', function(r){
		if(r == true){
			showSpinner();
			$.ajax({
				url		: '../../../inc/Ajax/_Contabilidad/Tablero/guardaDeposito.php',
				type	: 'POST',
				dataType: 'json',
				data	: params
			})
			.done(function(resp){
				if(resp.nCodigo != 0){
					jAlert(resp.sMensaje, 'Mensaje');
				}
				else{
					jAlert('Movimiento aplicado correctamente', 'Mensaje');
					ajaxBancoMovs();
					ocultaCapturaDeposito();
				}
			})
			.fail(function(){

			})
			.always(function(){
				hideSpinner();
			});
		}
	});
} // guardarDeposito

function resetCuentaContable(){
	$('form[name=formCapturaDeposito] :input[name=nNumCuentaContable]').customLoadStore({});
}

function buscaCuentaContable(nIdCadena, nIdSubCadena, nIdCorresponsal){
	$('form[name=formCapturaDeposito] :input[name=nNumCuentaContable]').customLoadStore({
		url				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/storeCuentaForelo.php',
		labelField		: 'ctaContable',
		idField			: 'ctaContable',
		firstItemId		: '-1',
		firstItemValue	: '--',
		params			: {
			nIdCadena		: nIdCadena,
			nIdSubCadena	: nIdSubCadena,
			nIdCorresponsal	: nIdCorresponsal
		}
	});
} // buscaCuentaContable