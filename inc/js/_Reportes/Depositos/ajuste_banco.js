function initViewAjusteBanco(){
	initFiltros();
} //initViewAjusteBanco

function initFiltros(){

	$('#btnBuscar').on('click', function(){
		buscarDepositos();
	});

	$('form[name=formFiltros] :input[name=sNombreCliente]').autocomplete({
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
			$('form[name=formFiltros] :input[name=nIdCliente]').val('');

			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltros] :input[name=sNombreSubCadena]').val('');

			$('form[name=formFiltros] :input[name=nIdCadena]').val('');
			$('form[name=formFiltros] :input[name=sNombreCadena]').val('');
			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltros] :input[name=nIdCliente]').val(suggestion.data);
			buscaCuentaForelo(suggestion.nIdCadena, suggestion.data, -1);
		}
	});

	$('form[name=formFiltros] :input[name=sNombreCadena]').autocomplete({
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
			$('form[name=formFiltros] :input[name=nIdCadena]').val('');
			$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltros] :input[name=nIdCliente]').val('');
			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=sNombreSubCadena]').val('');
			$('form[name=formFiltros] :input[name=sNombreCliente]').val('');
			$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltros] :input[name=nIdCadena]').val(suggestion.data);
			buscaCuentaForelo(suggestion.data, -1, -1);

		}
	});

	$('form[name=formFiltros] :input[name=sNombreCadena]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltros] :input[name=nIdCadena]').val('');
			$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=sNombreSubCadena]').val('');
			$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
			resetCuentaForelo();
		}
	});

	$('form[name=formFiltros] :input[name=sNombreSubCadena]').autocomplete({
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
			$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
			options.nIdCadena = $('form[name=formFiltros] :input[name=nIdCadena]').val();

			$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=nIdCliente]').val('');
			$('form[name=formFiltros] :input[name=sNombreCliente]').val('');
			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltros] :input[name=nIdSubCadena]').val(suggestion.data);
			buscaCuentaForelo(suggestion.idCadena, suggestion.data, -1);
		}
	});

	$('form[name=formFiltros] :input[name=sNombreSubCadena]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');

			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
			resetCuentaForelo();
		}
	});

	$('form[name=formFiltros] :input[name=sNombreCliente]').autocomplete({
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
			$('form[name=formFiltros] :input[name=nIdCliente]').val('');

			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
			$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
			$('form[name=formFiltros] :input[name=sNombreSubCadena]').val('');

			$('form[name=formFiltros] :input[name=nIdCadena]').val('');
			$('form[name=formFiltros] :input[name=sNombreCadena]').val('');
			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltros] :input[name=nIdCliente]').val(suggestion.data);
			buscaCuentaForelo(suggestion.nIdCadena, suggestion.data, -1);
		}
	});

	$('form[name=formFiltros] :input[name=sNombreCliente]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltros] :input[name=nIdCliente]').val('');
			resetCuentaForelo();
		}
	});

	$('form[name=formFiltros] :input[name=sNombreCorresponsal]').autocomplete({
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
			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');

			var nIdCliente = $('form[name=formFiltros] :input[name=nIdCliente]').val();

			options.nIdCadena		= $('form[name=formFiltros] :input[name=nIdCadena]').val();
			options.nIdCliente		= nIdCliente;

			if(nIdCliente != undefined && nIdCliente != '' && nIdCliente > 0){
				options.nIdSubCadena = nIdCliente;
			}
			else{
				options.nIdSubCadena = $('form[name=formFiltros] :input[name=nIdSubCadena]').val();
			}

			resetCuentaForelo();
		},
		onSelect				: function (suggestion){
			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val(suggestion.data);
			buscaCuentaForelo(suggestion.idCadena, suggestion.idSubCadena, suggestion.data);
		}
	});

	$('form[name=formFiltros] :input[name=sNombreCorresponsal]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
			resetCuentaForelo();
		}
	});

	$('form[name=formFiltros] :input[name=dFechaInicio]').datepicker({
		format : 'yyyy-mm-dd'
	});
	$('form[name=formFiltros] :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});

	var hoy = fnHoy();

	$('form[name=formFiltros] :input[name=dFechaInicio], form[name=formFiltros] :input[name=dFechaFinal]').val(hoy);
} // initFiltros

function resetCuentaForelo(){
	$('form[name=formFiltros] :input[name=nNumCuenta]').customLoadStore({});
} // resetCuentaForelo

function buscaCuentaForelo(nIdCadena, nIdSubCadena, nIdCorresponsal){
	$('form[name=formFiltros] :input[name=nNumCuenta]').customLoadStore({
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

	$('form[name=formFiltros] :input[name=nNumCuenta]').unbind('storeLoaded');
	$('form[name=formFiltros] :input[name=nNumCuenta]').on('storeLoaded', function(e){
		var length = document.formFiltros.nNumCuenta.options.length;

		if(length == 2){
			var value = document.formFiltros.nNumCuenta.options[1].value;
			document.formFiltros.nNumCuenta.value = value;
		}
	});
} // buscaCuentaForelo

function buscarDepositos(){
	var params = $('form[name=formFiltros]').getSimpleParams();

	var dFechaInicio	= params.dFechaInicio;
	var dFechaFinal		= params.dFechaFinal;

	var nIdCliente		= params.nIdCliente;
	var nIdCadena		= params.nIdCadena;
	var nIdSubCadena	= params.nIdSubCadena;
	var nIdCorresponsal	= params.nIdCorresponsal;
	var nNumCuenta		= (params.nNumCuenta != undefined)? params.nNumCuenta : '';
	nNumCuenta			= (nNumCuenta == -1)? '' : nNumCuenta;

	if(nIdCliente != undefined && nIdCliente != '' && nNumCuenta == ''){
		jAlert('El Cliente Seleccionado no Cuenta con Número de Cuenta', 'Mensaje');
		return false;
	}

	if(nIdCadena != undefined && nIdCadena != '' && nNumCuenta == ''){
		jAlert('La Cadena Seleccionada no Cuenta con Número de Cuenta', 'Mensaje');
		return false;
	}

	if(nIdSubCadena != undefined && nIdSubCadena != '' && nNumCuenta == ''){
		jAlert('La Sub Cadena Seleccionada no Cuenta con Número de Cuenta', 'Mensaje');
		return false;
	}

	if(nIdCorresponsal != undefined && nIdCorresponsal != '' && nNumCuenta == ''){
		jAlert('El Corresponsal Seleccionado no Cuenta con Número de Cuenta', 'Mensaje');
		return false;
	}

	if(dFechaInicio == ''){
		jAlert('Seleccione Fecha de Inicio', 'Mensaje');
		return false;
	}

	if(dFechaFinal == ''){
		jAlert('Seleccione Fecha Final', 'Mensaje');
		return false;
	}

	$('#gridbox').html('<table id="tbl-movimientos" class="display table table-bordered table-striped"><thead><tr><th>Folio</th><th>Cuenta</th><th>Banco</th><th>Nuevo Banco</th><th>Importe</th><th>Fecha de Captura</th><th>Autorización</th><th>Estatus</th><th>Acci&oacute;n</th></tr></thead><tbody></tbody></table>');

	var dataTableObj = $('#tbl-movimientos').dataTable({
		"iDisplayLength"	: 50,
		"bProcessing"		: true,
		"bServerSide"		: true,
		"sAjaxSource"		: BASE_PATH + '/inc/ajax/_Reportes/Depositos/obtener_depositos.php',
		"sServerMethod"		: 'POST',
		"bFilter"			: false,
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se ha encontrado nada",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
			"sProcessing"		: "Cargando"
		},
		"aoColumnDefs"		: [
			{
				'bSortable'	: false,
				'aTargets'	: [0,1,2,3,4,5,6,7,8]
			},
			{
				"mData"		: 'idDeposito',
				'aTargets'	: [0]
			},
			{
				"mData"		: null,
				'aTargets'	: [1],
				"fnRender"	: function(oObj){
					var sOwner		= oObj.aData.sNombreCuenta;
					var nNumCuenta	= oObj.aData.numCuenta;

					var lbl = "<b>" + nNumCuenta + "</b><br/>" + sOwner
					return lbl;
				}
			},
			{
				"mData"		:'sNombreBanco',
				'aTargets'	: [2]
			},
			{
				"mData"		: null,
				'aTargets'	: [3],
				"fnRender"	: function(oObj){
					var idDeposito = oObj.aData.idDeposito;

					var cmb = "<select name='nIdNuevoBanco"+idDeposito+"' class='cmb-llenar'></select>";

					return cmb;
				}
			},
			{
				"mData"		:'importeFormato',
				'aTargets'	: [4],
				"fnRender"	: function(oObj){
					var importeFormato = oObj.aData.importeFormato;
					return '$ <span>'+importeFormato+'</span>';
				}
			},
			{
				"mData"		:'fecAlta',
				'aTargets'	: [5]
			},
			{
				"mData"		:'autorizacion',
				'aTargets'	: [6]
			},
			{
				"mData"		:'sNombreEstatus',
				'aTargets'	: [7]
			},
			{
				"mData"		:null,
				'aTargets'	: [8],
				"fnRender"	: function(oObj){
					var idDeposito = oObj.aData.idDeposito;

					return '<button type="button" class="btn btn-sm btn-default btn-on-click" style="margin-top:20px;" iddeposito="'+idDeposito+'">Guardar</button>';
				}
			}
		],
		"fnPreDrawCallback"	: function() {
			//$('body').trigger('cargarTabla');
			showSpinner();
		},
		"fnDrawCallback": function ( oSettings ) {
			hideSpinner();
			cargarStoreBancos();

			$('.btn-on-click').unbind('click');
			$('.btn-on-click').on('click', function(e){
				guardarNuevoBanco(e);
			});
		},
		"fnServerParams" : function (aoData){
			var params = $('form[name=formFiltros]').getSimpleParams();

			$.each(params, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});
	
} // buscarDepositos

function cargarStoreBancos(){
	$.ajax({
		url		: '/inc/Ajax/_Reportes/Depositos/storeBancoDepositos.php',
		type	: 'POST',
		dataType: 'json',
		data	: {}
	})
	.done(function(resp){
		if(resp.bExito == true){
			var data	= resp.data;
			var length	= data.length;

			if(length >= 1){
				for(var i=0; i<length; i++){
					var elemento		= data[i];
					var nIdBanco		= elemento.nIdBanco;
					var sNombreBanco	= elemento.nombreBanco;

					$('select.cmb-llenar').append('<option value="'+nIdBanco+'">'+sNombreBanco+'</option>')
				}
			}
		}
	})
	.fail(function(){
		jAlert('No ha sido posible cargar la lista de Bancos', 'Mensaje');
	})
	.always(function(){
	});
} // cargarStoreBancos

function guardarNuevoBanco(e){
	var nIdDeposito = e.target.getAttribute('iddeposito');
	var nIdBanco	= $('select[name=nIdNuevoBanco'+nIdDeposito+']').val();

	if(nIdBanco == undefined || nIdBanco <= 0){
		jAlert('Seleccione Banco');
		return false;
	}

	showSpinner();
	$.ajax({
		url		: BASE_PATH + '/inc/ajax/_Reportes/Depositos/deposito_actualizarbanco.php',
		type	: 'POST',
		dataType: 'json',
		data	: {
			nIdDeposito : nIdDeposito,
			nIdBanco	: nIdBanco
		}
	})
	.done(function(resp){
		jAlert(resp.sMensaje, 'Mensaje');
		if(resp.bExito == true){
			buscarDepositos();
		}
	})
	.fail(function(){
		hideSpinner();
		jAlert('No ha sido posible actualizar el Deposito','Mensaje');
	})
	.always(function(){
		hideSpinner();
	});
	
} // guardarNuevoBanco