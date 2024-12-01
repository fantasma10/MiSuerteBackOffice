function initView(){

	$('#txtSNombreBanco').autocomplete({
		serviceUrl				: '../../../inc/ajax/_Contabilidad/Tablero/autocompleteBancos.php',
		type					: 'post',
		dataType				: 'json',
		preventBadQueries		: false,
		noCache					: true,
		width					: 300,
		onSearchStart			: function (query){
			$('#txtNIdBanco').val('');
		},
		onSelect				: function (suggestion){
			$('#txtNIdBanco').val(suggestion.data);
		}
	});

	$('form[name=filtrosCfg] :input[name=sNombreBanco]').on('keyup', function(e){
		if(e.target.value == ''){
			$('form[name=filtrosCfg] :input[name=nIdBanco]').val('');
		}
	});

	$('form[name=filtrosCfg] :input[name=sNombreBanco]').autocomplete({
		serviceUrl				: '../../../inc/ajax/_Contabilidad/Tablero/autocompleteBancos.php',
		type					: 'post',
		dataType				: 'json',
		preventBadQueries		: false,
		width					: 300,
		onSearchStart			: function (query){
			$('form[name=filtrosCfg] :input[name=nIdBanco]').val('');
		},
		onSelect				: function (suggestion){
			$('form[name=filtrosCfg] :input[name=nIdBanco]').val(suggestion.data);
		}
	});

	$('#txtNNumCuentaBancaria, form[name=filtrosCfg] :input[name=nNumCuentaBancaria]').numeric({
		allowMinus			: false,
		allowThouSep		: false,
		allowDecSep			: false,
		allowLeadingSpaces	: false,
		maxDecimalPlaces	: 0,
		maxDigits			: 11
	});

	$('#txtNNumCuentaContable, form[name=filtrosCfg] :input[name=nNumCuentaContable]').alphanum({
		allow				: '-',
		disallow			: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		allowSpace			: false,
		allowNumeric		: true,
		allowLatin			: true,
		allowOtherCharSets	: false,
		maxLength			: 15
	});

	$('#txtSNombreBanco, form[name=filtrosCfg] :input[name=sNombreBanco]').alphanum({
		allow				: '-ñÑáÁéÉíÍóÓúÚüÜ,.',
		disallow			: '',
		allowSpace			: true,
		allowNumeric		: true,
		allowLatin			: true,
		allowOtherCharSets	: false,
		maxLength			: 45
	});

	$('#btnGuardarData').on('click', function(e){
		guardarDatos();
	});

	$('#btnCancelarGuardarData').on('click', function(e){
		$('#divNuevoCfg').fadeOut();
	});

	$('#btnNewData').on('click', function(e){
		limpiarFormCfg();
		$('#divNuevoCfg').fadeIn();
	});

	$('#btnFiltrarData').on('click', function(e){
		llenarTabla();
	});

	llenarTabla();

	function guardarDatos(){
		var nIdBanco			= $('form[name=capturaCuenta] :input[name=nIdBanco]').val();
		var nNumCuentaBancaria	= $('form[name=capturaCuenta] :input[name=nNumCuentaBancaria]').val();
		var nNumCuentaContable	= $('form[name=capturaCuenta] :input[name=nNumCuentaContable]').val();
		var nIdCfg				= $('form[name=capturaCuenta] :input[name=nIdCfg]').val();

		if(nIdBanco == undefined || nIdBanco.trim() == '' || nIdBanco <= 0){
			jAlert('Seleccione Banco');
			return;
		}

		if(nNumCuentaBancaria == undefined || nNumCuentaBancaria.trim() == '' || nNumCuentaBancaria <= 0){
			jAlert('Capture Cuenta Bancaria');
			return;
		}

		if(nNumCuentaContable == undefined || nNumCuentaContable.trim() == '' || nNumCuentaContable <= 0){
			jAlert('Capture Cuenta Contable');
			return;
		}

		jConfirm('\u00BFDesea guardar la informaci\u00F3n?', 'Confirmati\u00F3n', function(r) {
			if(r == true){
				$.ajax({
					url			: '../../../inc/ajax/_Contabilidad/Tablero/guardarCfgCuenta.php',
					type		: 'POST',
					dataType	: 'json',
					data		: {
						nIdCfg				: nIdCfg,
						nIdBanco			: nIdBanco,
						nNumCuentaBancaria	: nNumCuentaBancaria,
						nNumCuentaContable	: nNumCuentaContable
					}
				})
				.done(function(resp){
					jAlert(resp.sMsg);
					llenarTabla();
					if(resp.bExito == true && resp.nCodigo == 0){
						limpiarFormCfg();
					}
				})
				.fail(function(){
					jAlert('Error General');
				});
			}
		});
	} // guardarDatos

	function limpiarFormCfg(){
		$('#txtSNombreBanco, #txtNNumCuentaBancaria, #txtNNumCuentaContable, #txtNIdBanco').val('');
		$('#divNuevoCfg').fadeOut();
	}
} // initView

function llenarTabla(){
	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Banco</th><th>Cuenta Bancaria</th><th>Cuenta Contable</th><th>Estatus</th><th>Acciones</th></tr></thead><tbody></tbody></table>');

	var dataTableObj = $('#tblGridBox').dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: false,
		"bServerSide"		: true,
		"sAjaxSource"		: '../../../inc/ajax/_Contabilidad/Tablero/cargarListaCfg.php',
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se ha encontrado nada",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)"
		},
		"aoColumnDefs"		: [{
			'bSortable'	: false,
			'aTargets'	: [4]
		}],
		"fnPreDrawCallback"	: function() {
			//$('body').trigger('cargarTabla');
		},
		"fnDrawCallback": function ( oSettings ) {
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

function eliminarCfg(nIdCfg, e){
	e.preventDefault();
	if(nIdCfg == undefined || nIdCfg.trim() == '' || nIdCfg <= 0){
		return;
	}

	jConfirm('\u00BFDesea eliminar la informaci\u00F3n?', 'Confirmati\u00F3n', function(r){
		if(r == true){
			$.ajax({
				url			: '../../../inc/ajax/_Contabilidad/Tablero/eliminarCfg.php',
				type		: 'POST',
				dataType	: 'json',
				data		: {
					nIdCfg	: nIdCfg
				},
			})
			.done(function(resp){
				jAlert(resp.sMsg);
				llenarTabla();
			})
			.fail(function(){
				jAlert('Error General');
			});

		}
	});
} // eliminarCfg

function activarCfg(nIdCfg, e){
	e.preventDefault();
	if(nIdCfg == undefined || nIdCfg.trim() == '' || nIdCfg <= 0){
		return;
	}

	jConfirm('\u00BFDesea activar?', 'Confirmati\u00F3n', function(r){
		if(r == true){
			$.ajax({
				url			: '../../../inc/ajax/_Contabilidad/Tablero/activarCfg.php',
				type		: 'POST',
				dataType	: 'json',
				data		: {
					nIdCfg	: nIdCfg
				},
			})
			.done(function(resp){
				jAlert(resp.sMsg);
				llenarTabla();
			})
			.fail(function(){
				jAlert('Error General');
			});

		}
	});
} // eliminarCfg

function editarCfg(nIdCfg, e){
	if(nIdCfg == undefined || nIdCfg.trim() == '' || nIdCfg <= 0){
		return;
	}

	$.ajax({
		url			: '../../../inc/Ajax/_Contabilidad/Tablero/cargarCfgDatos.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			nIdCfg	: nIdCfg
		}
	})
	.done(function(resp){
		if(resp.bExito == true){
			$('#divNuevoCfg').fadeIn();
			simpleFillForm(resp.data[0], 'formCapturaCuenta', '');
		}
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		console.log("complete");
	});
}