function initViewConfiguracion(){
	initInputs();

	cargarConfiguracion();
	cargarListaAlertas();
}

function initInputs(){
	$('form[name=formAlertas] :input[name=sCorreo]').alphanum({
		allow				: '._-@',
		allowLatin			: true,
		allowOtherCharSets	: false,
		maxLength			: 200
	});

	$('form[name=formConfiguracion] :input[name=nNumCuentaContableDeposito]').alphanum({
		allow				: '-',
		allowLatin			: false,
		allowOtherCharSets	: false,
		maxLength			: 15
	});

	$('form[name=formConfiguracion] :input[name=sClabeRetiro], form[name=formConfiguracion] :input[name=sClabeDeposito], form[name=formConfiguracion] :input[name=nTiempoActualizacion], form[name=formConfiguracion] :input[name=nTiempoInactividad], form[name=formConfiguracion] :input[name=nTiempoAlerta]').css('text-align', 'right');

	$('form[name=formConfiguracion] :input[name=sClabeRetiro], form[name=formConfiguracion] :input[name=sClabeDeposito]').numeric({
		allowThouSep	: false,
		allowDecSep		: false,
		maxDigits		: 18
	});

	$('form[name=formConfiguracion] :input[name=nTiempoActualizacion], form[name=formConfiguracion] :input[name=nTiempoInactividad], form[name=formConfiguracion] :input[name=nTiempoAlerta]').numeric({
		allowThouSep	: false,
		allowDecSep		: false,
		maxDigits		: 11
	});

	$('form[name=formAlertas] :input[name=nIdArea]').customLoadStore({
		url				: BASE_PATH + '/misuerte/ajax/storeArea.php',
		labelField		: 'sNombre',
		idField			: 'nIdArea',
		firstItemId		: '0',
		firstItemValue	: 'Seleccione'
	});

	$('form[name=formConfiguracion] :input[name=sClabeRetiro]').on('keyup', function(e){
		validarCLABE('Retiro', e);
	});

	$('form[name=formConfiguracion] :input[name=sClabeDeposito]').on('keyup', function(e){
		validarCLABE('Depósito', e);
	});

	$('#btnGuardarConfiguracion').on('click', function(e){
		guardarConfiguracion();
	});

	$('#btnGuardarAlerta').on('click', function(e){
		guardarAlerta();
	});
} // initInputsAlta

function validarCLABE(leyenda, e){
	var val = $(e.target).val();

	if(val.length == 18){
		var valida = validarDigitoVerificador(val);

		if(!valida){
			jAlert('CLABE de ' + leyenda + ' no v\u00E1lida', 'Mensaje');
		}
	}
}// validarCLABE

function guardarConfiguracion(){
	var params = $('form[name=formConfiguracion]').getSimpleParams();

	if(params.sClabeRetiro == undefined || params.sClabeRetiro == ''){
		jAlert('Capture cuenta CLABE de Retiro', 'Mensaje');
		return false;
	}

	if(params.sClabeRetiro.length != 18){
		jAlert('La cuenta CLABE de Retiro debe ser de 18 d\u00EDgitos');
		return false;
	}

	if(!validarDigitoVerificador(params.sClabeRetiro)){
		jAlert('La cuenta CLABE de Retiro es inv\u00E1lida');
		return false;
	}

	if(params.sClabeDeposito == undefined || params.sClabeDeposito == ''){
		jAlert('Capture cuenta CLABE de Dep\u00F3sito', 'Mensaje');
		return false;
	}

	if(params.sClabeDeposito.length != 18){
		jAlert('La cuenta CLABE de Dep\u00F3sito debe ser de 18 d\u00EDgitos');
		return false;
	}

	if(!validarDigitoVerificador(params.sClabeDeposito)){
		jAlert('La cuenta CLABE de Dep\u00F3sito es inv\u00E1lida');
		return false;
	}

	if(params.nNumCuentaContableDeposito == undefined || params.nNumCuentaContableDeposito == ''){
		jAlert('Capture Cuenta Contable', 'Mensaje');
		return false;
	}

	if(params.nTiempoActualizacion == undefined || params.nTiempoActualizacion == '' || params.nTiempoActualizacion <= 0){
		jAlert('Capture Tiempo de Actualizaci\u00F3n');
		return false;
	}

	if(params.nTiempoInactividad == undefined || params.nTiempoInactividad == '' || params.nTiempoInactividad <= 0){
		jAlert('Capture Tiempo de Inactividad');
		return false;
	}

	if(params.nTiempoAlerta == undefined || params.nTiempoAlerta == '' || params.nTiempoAlerta <= 0){
		jAlert('Capture Tiempo de Alerta');
		return false;
	}

	$('#btnGuardarConfiguracion').prop('disabled', true);
	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/configuracionGuardar.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		jAlert(resp.sMensaje);

		if(resp.nCodigo == 0){
			$('form[name=formConfiguracion] :input[name=nIdConfiguracion]').val(resp.data.nIdConfiguracion);
		}
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		$('#btnGuardarConfiguracion').prop('disabled', false);
	});
} // guardarConfiguracion

function cargarConfiguracion(){
	$.ajax({
		url		: BASE_PATH + '/misuerte/ajax/configuracionCargar.php',
		type	: 'POST',
		dataType: 'json',
		data	: {
			nIdConfiguracion : 1
		}
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje, 'Mensaje');
			return false;
		}
		simpleFillForm(resp.data, 'form_Configuracion');
	})
	.fail(function() {
		console.log("error");
	});
} // cargarConfiguracion

function guardarAlerta(){
	var params = $('form[name=formAlertas]').getSimpleParams();

	if(params.nIdArea == undefined || params.nIdArea == '' || params.nIdArea <= 0){
		jAlert('Seleccione \u00C1rea', 'Mensaje');
		return false;
	}

	if(params.sCorreo == undefined || params.sCorreo == ''){
		jAlert('Capture Correo', 'Mensaje');
		return false;
	}

	var sCorreo = $('form[name=formAlertas] :input[name=sCorreo]').val();

	params.sCorreo = sCorreo.trim();

	if(!validar_email(params.sCorreo)){
		jAlert('Correo Electr\u00F3nico No v\u00E1lido', 'Mensaje');
		return false;
	}

	$('#btnGuardarAlerta').prop('disabled', true);
	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/alertasGuardar.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje, 'Mensaje');
		}
		cargarListaAlertas();
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		$('#btnGuardarAlerta').prop('disabled', false);
		$('form[name=formAlertas] :input[name=nIdNotificacion]').val(0);
		$('form[name=formAlertas] :input[name=nIdArea]').val(0);
		$('form[name=formAlertas] :input[name=sCorreo]').val('');
	});

} // guardarAlerta

function cargarListaAlertas(){
	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>&Aacute;rea</th><th>Correo</th><th>Acciones</th></tr></thead><tbody></tbody></table>');

	var dataTableObj = $('#tblGridBox').dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: true,
		"bServerSide"		: true,
		"sAjaxSource"		: BASE_PATH + '/misuerte/ajax/alertasLista.php',
		"sServerMethod"		: 'POST',
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
				'bSortable' : false,
				'aTargets'	: [2]
			},
			{
				"mData"		: 'sNombreArea',
				'aTargets'	: [0]
			},
			{
				"mData"		: 'sCorreo',
				'aTargets'	: [1]
			},
			{
				"mData"		: 'nIdNotificacion',
				'aTargets'	: [2],
				'fnRender'	: function(oObj){
					var nIdNotificacion = oObj.aData.nIdNotificacion;
					var html = '<a href="#" class="a_editar_n" nIdNotificacion="'+nIdNotificacion+'">Editar</a> | ';
					html+= '<a href="#" class="a_eliminar_n" nIdNotificacion="'+nIdNotificacion+'">Eliminar</a>';

					return html;
				}
			}
		],
		"fnPreDrawCallback"	: function(){
			//$('body').trigger('cargarTabla');
		},
		"fnDrawCallback": function ( oSettings ){
			$('.a_editar_n').unbind('click');
			$('.a_editar_n').on('click', function(e){
				e.preventDefault();
				var nIdNotificacion = $(e.target).attr('nidnotificacion');
				mostrarConsulta(nIdNotificacion);
			});

			$('.a_eliminar_n').unbind('click');
			$('.a_eliminar_n').on('click', function(e){
				e.preventDefault();
				var nIdNotificacion = $(e.target).attr('nidnotificacion');
				eliminarAlerta(nIdNotificacion);
			});
		},
		"fnServerParams" : function (aoData){
		}
	});

} // cargarListaAlertas

function mostrarConsulta(nIdNotificacion){
	$.ajax({
		url			: '/misuerte/ajax/alertasLista.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			nIdNotificacion : nIdNotificacion
		}
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje, 'Mensaje');
		}
		else{
			var data = resp.aaData[0];

			simpleFillForm(data, 'form_Alertas');
		}
	})
	.fail(function(){
		console.log("error");
	});
} // mostrarConsulta

function eliminarAlerta(nIdNotificacion){
	jConfirm('Confirmar', 'Confirmaci\u00F3n', function(r) {
		if(r){
			$.ajax({
				url			: '/misuerte/ajax/alertasEliminar.php',
				type		: 'POST',
				dataType	: 'json',
				data		: {
					nIdNotificacion : nIdNotificacion
				}
			})
			.done(function(resp){
				if(resp.bExito == false){
					jAlert(resp.sMensaje, 'Mensaje');
				}

				cargarListaAlertas();
			})
			.fail(function(){
				console.log("error");
			});
		}
	});
} // eliminarAlerta