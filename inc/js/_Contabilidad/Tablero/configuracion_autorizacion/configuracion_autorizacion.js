function initView(){
	llenarTablaConfiguraciones();
	initModalConfiguracion();

	$('#btnNuevaConfiguracion').on('click', function(e){
		muestraModalConfiguracion();
	});
}

function muestraModalConfiguracion(){
	console.log('muestraModalConfiguracion');
	$('#modal-alta_configuracion').modal('show');
	$('form[name=formAltaConfiguracion]').get(0).reset();
}

function initModalConfiguracion(){
	$('form[name=formAltaConfiguracion] :input[name=nIdUsuario]').customLoadStore({
		url				: BASE_PATH + '/inc/ajax/_Contabilidad/Tablero/storeUsuarios.php',
		labelField		: 'sNombreCompleto',
		idField			: 'idUsuario',
		firstItemId		: '0',
		firstItemValue	: '--'
	});

	$('form[name=formAltaConfiguracion] :input[name=nIdBanco]').customLoadStore({
		url				: BASE_PATH + '/inc/ajax/_Contabilidad/Tablero/storeBancos.php',
		labelField		: 'sNombreBanco',
		idField			: 'nIdBanco',
		firstItemId		: '0',
		firstItemValue	: '--'
	});

	$('form[name=formAltaConfiguracion] :input[name=sCorreo]').alphanum({
		allow				: '@-_.',
		allowSpace			: false,
		allowOtherCharSets	: false,
		maxLength			: 200
	});

	$('form[name=formAltaConfiguracion] :input[name=nMonto]').numeric({
		allowMinus			: false,
		allowThouSep		: false,
		maxDigits			: 16,
		maxDecimalPlaces	: 2,
		maxPreDecimalPlaces	: 14
	});

	$('form[name=formAltaConfiguracion] :input[name=nDias]').numeric({
		allowMinus			: false,
		allowThouSep		: false,
		maxDigits			: 11,
		allowDecSep			: false
	});

	$('#btnGuardarConfiguracion').on('click', function(e){
		guardarConfiguracion();
	});

	function guardarConfiguracion(){
		var params = $('form[name=formAltaConfiguracion]').getSimpleParams();

		if(params.nIdUsuario == undefined || params.nIdUsuario == '' || params.nIdUsuario <= 0){
			jAlert('Seleccione Usuario');
			return;
		}

		if(params.sClave == undefined || params.sClave == ''){
			jAlert('Capture Clave');
			return;
		}

		if(params.nMonto == undefined || params.nMonto == '' || params.nMonto <= 0){
			jAlert('Capture Monto');
			return;
		}

		if(params.nDias == undefined || params.nDias == '' || params.nDias <= 0){
			jAlert('Capture D\u00EDas');
			return;
		}

		var hash = CryptoJS.SHA256(params.sClave, { asString: true });
		params.sClave = hash.toString();

		jConfirm('\u00BFSeguro que desea Guardar la configuraci\u00F3n?', 'Confirmaci\u00F3n', function(r){
			if(r){
				showSpinner();
				$.ajax({
					url			: '../../../inc/Ajax/_Contabilidad/Tablero/guardarConfiguracionAutorizacion.php',
					type		: 'POST',
					dataType	: 'json',
					data		: params
				})
				.done(function(resp){
					jAlert(resp.sMensaje);

					if(resp.nCodigo == 0){
						$('#modal-alta_configuracion').modal('hide');
						llenarTablaConfiguraciones();
					}
				})
				.fail(function(){

				})
				.always(function(){
					hideSpinner();
				});
			}
		});

	}
}

function llenarTablaConfiguraciones(){
	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Autorizador</th><th>Correo</th><th>Monto</th><th>D&iacute;as</th><th>Banco</th></tr></thead><tbody></tbody></table>');

	showSpinner();
	var dataTableObj = $('#tblGridBox').dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: false,
		"bServerSide"		: true,
		"sAjaxSource"		: '../../../inc/ajax/_Contabilidad/Tablero/cargarListaConfiguracionAutorizacion.php',
		"aoColumns": [
			{ "mData": "sNombreCompleto" },
			{ "mData": "sCorreo" },
			{ "mData": "nMonto" },
			{ "mData": "nDias" },
			{ "mData": "sNombreBanco" }
		],
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se ha encontrado nada",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)"
		},
		/*"aoColumnDefs"		: [{
			'bSortable'	: false,
			'aTargets'	: [4]
		}],*/
		"fnPreDrawCallback"	: function() {
			//$('body').trigger('cargarTabla');
			showSpinner();
		},
		"fnDrawCallback": function ( oSettings ) {
			hideSpinner();
			/*dataTableObj.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250
			});*/

			/*dataTableObj.$('i').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250
			});*/

			//$('body').trigger('tablaLlena');
		},
		"fnServerParams" : function (aoData){
			/*$.each(obj, function(index, val){
				aoData.push({name : index, value : val });
			});*/
			var nIdBanco			= $('form[name=filtrosCfg] :input[name=nIdBanco]').val();
			var nNumCuentaBancaria	= $('form[name=filtrosCfg] :input[name=nNumCuentaBancaria]').val();
			var nNumCuentaContable	= $('form[name=filtrosCfg] :input[name=nNumCuentaContable]').val();
			var nIdEstatus			= $('form[name=filtrosCfg] :input[name=nIdEstatus]').val();

			aoData.push({name : 'nIdBanco', value : nIdBanco});
			aoData.push({name : 'nNumCuentaBancaria', value : nNumCuentaBancaria});
			aoData.push({name : 'nNumCuentaContable', value : nNumCuentaContable});
			aoData.push({name : 'nIdEstatus', value : nIdEstatus});
		}
	});
}