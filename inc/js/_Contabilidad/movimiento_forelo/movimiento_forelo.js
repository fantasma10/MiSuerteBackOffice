function initViewMovimientoForelo(){
	initFiltros();
	initFiltrosConsulta();
	initModalMovimiento();
} // initMovimientoForelo

function initFiltros(){
	$('#btnNuevo').on('click', function(e){
		var nNumCuenta = $('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').val();

		if(nNumCuenta == undefined || nNumCuenta <= 0 || nNumCuenta == ''){
			jAlert('Debe seleccionar una Cuenta', 'Mensaje');
			return false;
		}

		$('#modal-captura_movimiento').modal('show');
		$('form[name=formCapturaMovimiento]').get(0).reset();
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreCadena]').autocomplete({
		serviceUrl				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/autocomplete_getListaCategoria.php',
		type					: 'post',
		dataType				: 'json',
		preventBadQueries		: false,
		width					: 300,
		paramName				: 'text',
		params					: {
			categoria			: 1
		},
		onSearchStart			: function (query){
			$('form[name=formFiltrosCuenta] :input[name=nIdCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=nIdCliente]').val('');
			$('form[name=formFiltrosCuenta] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreSubCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreCliente]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreCorresponsal]').val('');
			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltrosCuenta] :input[name=nIdCadena]').val(suggestion.data);
			buscaCuentaForelo(suggestion.data, -1, -1);

		}
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreCadena]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltrosCuenta] :input[name=nIdCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreSubCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreCorresponsal]').val('');
			resetCuentaForelo();
		}
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreSubCadena]').autocomplete({
		serviceUrl				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/autocomplete_getListaCategoria.php',
		type					: 'post',
		dataType				: 'json',
		preventBadQueries		: false,
		width					: 300,
		paramName				: 'text',
		params					: {
			categoria			: 2
		},
		onSearchStart			: function (options){
			$('form[name=formFiltrosCuenta] :input[name=nIdSubCadena]').val('');
			options.nIdCadena = $('form[name=formFiltrosCuenta] :input[name=nIdCadena]').val();

			$('form[name=formFiltrosCuenta] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreCorresponsal]').val('');
			$('form[name=formFiltrosCuenta] :input[name=nIdCliente]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreCliente]').val('');
			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltrosCuenta] :input[name=nIdSubCadena]').val(suggestion.data);
			buscaCuentaForelo(suggestion.idCadena, suggestion.data, -1);
		}
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreSubCadena]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltrosCuenta] :input[name=nIdSubCadena]').val('');

			$('form[name=formFiltrosCuenta] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreCorresponsal]').val('');
			resetCuentaForelo();
		}
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreCliente]').autocomplete({
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
			$('form[name=formFiltrosCuenta] :input[name=nIdCliente]').val('');

			$('form[name=formFiltrosCuenta] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreCorresponsal]').val('');
			$('form[name=formFiltrosCuenta] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreSubCadena]').val('');

			$('form[name=formFiltrosCuenta] :input[name=nIdCadena]').val('');
			$('form[name=formFiltrosCuenta] :input[name=sNombreCadena]').val('');
			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltrosCuenta] :input[name=nIdCliente]').val(suggestion.data);
			buscaCuentaForelo(suggestion.nIdCadena, suggestion.data, -1);
		}
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreCliente]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltrosCuenta] :input[name=nIdCliente]').val('');
			resetCuentaForelo();
		}
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreCorresponsal]').autocomplete({
		serviceUrl				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/autocomplete_getListaCategoria.php',
		type					: 'post',
		dataType				: 'json',
		preventBadQueries		: false,
		width					: 300,
		paramName				: 'text',
		params					: {
			categoria			: 3
		},
		onSearchStart			: function (options){
			$('form[name=formFiltrosCuenta] :input[name=nIdCorresponsal]').val('');

			var nIdCliente = $('form[name=formFiltrosCuenta] :input[name=nIdCliente]').val();

			options.nIdCadena		= $('form[name=formFiltrosCuenta] :input[name=nIdCadena]').val();
			options.nIdCliente		= nIdCliente;

			if(nIdCliente != undefined && nIdCliente != '' && nIdCliente > 0){
				options.nIdSubCadena = nIdCliente;
			}
			else{
				options.nIdSubCadena = $('form[name=formFiltrosCuenta] :input[name=nIdSubCadena]').val();
			}

			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltrosCuenta] :input[name=nIdCorresponsal]').val(suggestion.data);
			buscaCuentaForelo(suggestion.idCadena, suggestion.idSubCadena, suggestion.data);
		}
	});

	$('form[name=formFiltrosCuenta] :input[name=sNombreCorresponsal]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltrosCuenta] :input[name=nIdCorresponsal]').val('');
			resetCuentaForelo();
		}
	});
} // initFiltros

function initFiltrosConsulta(){
	$('#frmMovimientos :input[name=dFechaInicio]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('#frmMovimientos :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('#frmMovimientos :input[name=nIdTipoMovimiento]').customLoadStore({
		url				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/storeTipoMovimiento.php',
		labelField		: 'descTipoMovimiento',
		idField			: 'idTipoMovimiento',
		firstItemId		: '-1',
		firstItemValue	: 'Seleccione'
	});

	$('#btnBuscar').on('click', function(e){
		buscarMovimientos();
	});
} // initFiltrosConsulta

function buscaCuentaForelo(nIdCadena, nIdSubCadena, nIdCorresponsal){
	$('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').customLoadStore({
		url				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/storeCuentaForelo.php',
		labelField		: 'numCuenta',
		idField			: 'numCuenta',
		firstItemId		: '-1',
		firstItemValue	: '--',
		params			: {
			nIdCadena		: nIdCadena,
			nIdSubCadena	: nIdSubCadena,
			nIdCorresponsal	: nIdCorresponsal
		}
	});

	$('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').unbind('storeLoaded');
	$('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').on('storeLoaded', function(e){
		var length = document.formFiltrosCuenta.nNumCuenta.options.length;

		if(length == 2){
			var value = document.formFiltrosCuenta.nNumCuenta.options[1].value;
			document.formFiltrosCuenta.nNumCuenta.value = value;
		}
	});
} // buscaCuentaForelo

function resetCuentaForelo(){
	$('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').customLoadStore({});
} // resetCuentaForelo

function buscarMovimientos(){

	var params = $('#frmMovimientos').getSimpleParams();

	var nNumCuenta = $('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').val();

	if(nNumCuenta == undefined || params.nNumCuenta <= 0 || params.nNumCuenta == ''){
		jAlert('Debe seleccionar una Cuenta', 'Mensaje');
		return false;
	}

	if(params.dFechaInicio != undefined || params.dFechaInicio != ''){
		if(params.dFechaInicio > params.dFechaFinal){
			jAlert('La Fecha de Inicio no puede ser mayor que la Fecha Final', 'Mensaje');
			return false;
		}
	}

	if(params.dFechaInicio == undefined || params.dFechaInicio == ''){
		jAlert('Seleccione Fecha de Inicio', 'Mensaje');
		return false;
	}

	if(params.dFechaFinal == undefined || params.dFechaFinal == ''){
		jAlert('Seleccione Fecha de Final', 'Mensaje');
		return false;
	}



	showSpinner();

	$('#gridbox').html('<table id="tbl-movimientos" class="display table table-bordered table-striped"><thead><tr><th>Id</th><th>Fecha</th><th>Cargo</th><th>Abono</th><th>Saldo Final</th><th>Tipo de Movimiento</th><th>Descripci&oacute;n</th><th>Usuario</th></tr></thead><tbody></tbody></table>');

	var dataTableObj = $('#tbl-movimientos').dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: false,
		"bServerSide"		: true,
		"bFilter"			: false,
		"sAjaxSource"		: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/tblMovimientos.php',
		"sServerMethod"		: 'POST',
		"aaSorting"			: [[0, 'desc']],
		"oLanguage"			: {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se ha encontrado nada",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
			"sProcessing"		: "Cargando"
		},
		"aoColumnDefs"		: [
			{
				"mData"		: 'idsMovimiento',
				'aTargets'	: [0]
			},
			{
				"mData"		: 'fecAppMov',
				'aTargets'	: [1]
			},
			{
				"mData"		: 'cargoMov',
				'aTargets'	: [2],
				'sClass'	: 'align-right'
			},
			{
				"mData"		: 'abonoMov',
				'aTargets'	: [3],
				'sClass'	: 'align-right'
			},
			{
				"mData"		: 'saldoFinal',
				'aTargets'	: [4],
				'sClass'	: 'align-right'
			},
			{
				"mData"		:'descTipoMovimiento',
				'aTargets'	: [5]
			},
			{
				"mData"		: 'descMovimiento',
				'aTargets'	: [6],
			},
			{
				// "mData"		: 'sNombreEmpleado',
				"mData"		: 'sNombreUsuarioRegistro',
				'aTargets'	: [7],
			}
		],
		"fnPreDrawCallback"	: function() {
			showSpinner();
		},
		"fnDrawCallback": function ( oSettings ) {
			hideSpinner();
		},
		"fnServerParams" : function (aoData){
			var params = $('#frmMovimientos').getSimpleParams();
			params.nNumCuenta = $('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').val();

			$.each(params, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});
} // buscarMovimientos

function initModalMovimiento(){
	$('#formMovimiento :input[name=dFechaCobro]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('#formMovimiento :input[name=nIdTipoMovimiento]').customLoadStore({
		url				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/storeTipoMovimiento.php',
		labelField		: 'descTipoMovimiento',
		idField			: 'idTipoMovimiento',
		firstItemId		: '-1',
		firstItemValue	: 'Seleccione'
	});

	$('#formMovimiento :input[name=nMonto]').css('text-align', 'right');
	$('#formMovimiento :input[name=nMonto]').numeric({
		allowMinus			: false,
		allowThouSep		: false,
		maxDigits			: 18,
		maxDecimalPlaces	: 4,
		maxPreDecimalPlaces	: 14
	});

	$('#formMovimiento :input[name=sDescripcion]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚÜüñÑ',
		disallow			: '',
		allowOtherCharSets	: false,
		maxLength			: 45
	});

	$('#formMovimiento :input[name=nIdTipoMovimiento]').on('change', function(e){
		mostrarOcultarCredito();
	});

	$('#formMovimiento :input[name=tipo]').on('change', function(e){
		mostrarOcultarCredito();
	});

	hideCamposCredito();

	$('#btnCapturaMovimiento').on('click', function(e){
		guardarMovimiento();
	});
} // initModalMovimiento

function mostrarOcultarCredito(){
	var elementos			= $('#formMovimiento :input[name=tipo]:checked');
	var nIdTipoMovimiento	= $('#formMovimiento :input[name=nIdTipoMovimiento]').val();

	if(elementos.length != 1){
		return false;
	}

	var tipo = elementos[0].value;

	if(nIdTipoMovimiento == 11 && tipo == 2){
		showCamposCredito();
	}
	else{
		hideCamposCredito();
	}
} // mostrarOcultarCredito

function hideCamposCredito(){
	$('.mov_credito :input[name=dFechaCobro]').val('');
	$('.mov_credito :input[name=nIdTipoCobro]:checked').prop('checked', false);
	$('.mov_credito').hide();
}

function showCamposCredito(){
	$('.mov_credito :input[name=dFechaCobro]').val('');
	$('.mov_credito :input[name=nIdTipoCobro]:checked').prop('checked', false);
	$('.mov_credito').show();
}

function guardarMovimiento(){
	var params	= $('#formMovimiento').getSimpleParams();
	var tipos	= $('#formMovimiento :input[name=tipo]:checked');

	params.nNumCuenta = $('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').val();

	if(tipos.length != 1){
		jAlert('Seleccione si es Cargo \u00F3 Abono', 'Mensaje');
		return false;
	}

	params.nIdTipo = tipos[0].value;

	if(params.nMonto == undefined || params.nMonto == ''){
		jAlert('Capture Monto', 'Mensaje');
		return false;
	}

	if(params.nMonto <= 0){
		jAlert('Capture un Monto Mayor a Cero', 'Mensaje');
		return false;
	}

	if(params.nIdTipoMovimiento == undefined || params.nIdTipoMovimiento == '' || params.nIdTipoMovimiento <= 0){
		jAlert('Seleccione Tipo de Movimiento', 'Mensaje');
		return false;
	}

	var sDescripcion = $('#formMovimiento :input[name=sDescripcion]').val();

	if(sDescripcion == undefined){
		jAlert('Capture Descripci\u00F3n', 'Mensaje');
		return false;
	}

	if(sDescripcion.trim() == ''){
		jAlert('Capture Descripci\u00F3n', 'Mensaje');
		return false;
	}

	params.sDescripcion = sDescripcion.trim();

	if(params.nIdTipoMovimiento == 11 && params.nIdTipo == 2){
		if(params.dFechaCobro == undefined || params.dFechaCobro == ''){
			jAlert('Seleccione una Fecha de Cobro', 'Mensaje');
			return false;
		}

		var hoy		= fnHoy();
		var diff	= restaFechas(hoy, params.dFechaCobro);

		if(diff < 0){
			jAlert('Seleccione una Fecha de Cobro Igual o Posterior al D\u00EDa de Hoy', 'Mensaje');
			return false;
		}

		var tiposCobro = $('#formMovimiento :input[name=nIdTipoCobro]:checked');

		if(tiposCobro.length != 1){
			jAlert('Seleccione si es Cobro con Cargo a Forelo o Dep\u00F3sito en Banco', 'Mensaje');
			return false;
		}
	}

	jConfirm('\u00BFDesea Continuar\u003F', 'Confirmaci\u00F3n', function(r){
		if(r==true){
			showSpinner();
			$.ajax({
				url			: BASE_PATH + '/inc/Ajax/_Contabilidad/movimiento_forelo/movimientoGuardar.php',
				type		: 'POST',
				dataType	: 'json',
				data		: params
			})
			.done(function(resp){
				jAlert(resp.sMensaje, 'Mensaje');

				if(resp.nCodigo == 0){
					$('#modal-captura_movimiento').modal('hide');
					buscarMovimientos();
				}
			})
			.fail(function() {

			})
			.always(function() {
				hideSpinner();
			});
		}
	});
} // guardarMovimiento
