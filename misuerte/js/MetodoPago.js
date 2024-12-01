function initMetodoPagoAlta(){
	initInputsAlta();

	if(NID_METODOPAGO > 0){
		cargarMetodoDePago(NID_METODOPAGO);
	}
	else{
		llenarComboEstatus();
	}
}// initMetodoPagoAlta

function llenarComboEstatus(){
	$('form[name=formMetodoPago] :input[name=nIdEstatus]').customLoadStore({
		url				: BASE_PATH + '/misuerte/ajax/storeEstatus.php',
		labelField		: 'sNombre',
		idField			: 'nIdEstatus',
		firstItemId		: '-1',
		firstItemValue	: 'Seleccione'
	});
} // llenarComboEstatus

function initInputsAlta(){
	$('form[name=formMetodoPago] :input[name=sNombre]').alphanum({
		allowLatin			: true,
		allowOtherCharSets	: true,
		maxLength			: 50
	});

	$('form[name=formMetodoPago] :input[name=nImporteCosto], form[name=formMetodoPago] :input[name=nPorcentajeCosto], form[name=formMetodoPago] :input[name=nImporteCostoAdicional], form[name=formMetodoPago] :input[name=nPorcentajeIVA]').css('text-align', 'right');

	$('form[name=formMetodoPago] :input[name=nImporteCosto], form[name=formMetodoPago] :input[name=nPorcentajeCosto], form[name=formMetodoPago] :input[name=nImporteCostoAdicional], form[name=formMetodoPago] :input[name=nPorcentajeIVA]').numeric({
		allowMinus			: false,
		maxDecimalPlaces	: 4,
		maxPreDecimalPlaces	: 16
	});

	$('#btnGuardarMetodoPago').on('click', function(e){
		guardarMetodoPago();
	});
} // initInputsAlta

function guardarMetodoPago(){
	var params = $('form[name=formMetodoPago]').getSimpleParams();

	if(params.sNombre == undefined || params.sNombre == ''){
		jAlert('Capture Nombre', 'Mensaje');
		return false;
	}

	params.sNombre = $('form[name=formMetodoPago] :input[name=sNombre]').val();

	if(params.nImporteCosto == undefined || params.nImporteCosto == ''){
		jAlert('Capture Importe Costo', 'Mensaje');
		return false;
	}

	if(params.nPorcentajeCosto == undefined || params.nPorcentajeCosto == ''){
		jAlert('Capture Porcentaje Costo', 'Mensaje');
		return false;
	}

	if(params.nImporteCostoAdicional == undefined || params.nImporteCostoAdicional == ''){
		jAlert('Capture Importe Adicional Costo', 'Mensaje');
		return false;
	}

	if(params.nPorcentajeIVA == undefined || params.nPorcentajeIVA == ''){
		jAlert('Capture IVA', 'Mensaje');
		return false;
	}

	var listaDiasPago	= $('form[name=formMetodoPago] :input[name=nIdDia]:checked');
	var nDiasPago		= listaDiasPago.length;

	if(nDiasPago <= 0){
		jAlert('Seleccione por lo menos un D\u00EDa de Pago');
		return false;
	}

	var array_diasPago = new Array();

	for(var i=0; i < nDiasPago; i++){
		var el		= listaDiasPago[i];
		var nIdDia	= el.value;

		if(array_diasPago.indexOf(nIdDia) < 0){
			array_diasPago.push(nIdDia);
		}
	}

	params.array_diasPago = array_diasPago;

	$('#btnGuardarMetodoPago').prop('disabled', true);

	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/metodoPagoGuardar.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params,
	})
	.done(function(resp){
		jAlert(resp.sMensaje, 'Mensaje');

		if(resp.nCodigo == 0){
			var nIdMetodoPago = resp.data.nIdMetodoPago;
			$('form[name=formMetodoPago] :input[name=nIdMetodoPago]').val(nIdMetodoPago);
		}
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		$('#btnGuardarMetodoPago').prop('disabled', false);
	});
} // guardarMetodoDePago

function cargarMetodoDePago(nIdMetodoPago){
	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/metodoPagoCargar.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			nIdMetodoPago : nIdMetodoPago
		}
	})
	.done(function(resp){
		if(resp.nCodigo != 0){
			jAlert(resp.sMensaje, 'Mensaje');
		}

		var data = resp.data[0];
		simpleFillForm(data, 'form_MetodoPago');

		var bIndirecta = data.bIndirecta;

		var check = false;
		if(bIndirecta == 1){
			check = true;
		}
		$('form[name=formMetodoPago] :checkbox[name=bIndirecta]').prop('checked', check);

		var array_diasPago	= data.array_diaspago;
		var length_diasPago	= array_diasPago.length;

		var chk_dias = $('form[name=formMetodoPago] :checkbox[name=nIdDia]');

		for(var index=0; index < chk_dias.length; index++){
			var el = chk_dias[index];
			$(el).prop('checked', false);
		}

		for(var index=0; index < length_diasPago; index++){
			var opt		= array_diasPago[index];
			var nIdDia	= opt.nIdDia;

			$('form[name=formMetodoPago] :checkbox[name=nIdDia][value='+nIdDia+']').prop('checked', true);
		}

		$('form[name=formMetodoPago] :input[name=nIdEstatus]').on('storeLoaded', function(e){
			$(this).val(data.nIdEstatus);
		});
		llenarComboEstatus();
	})
	.fail(function(){
		console.log("error");
	});
}// cargarMetodoDePago