function initView(){

	llenarSelectCuentas();
	cargarPendientesConciliacion();
	initFechaFiltro();

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


	$('#btnShowModalEstadoCuenta').on('click', function(e){
		cargarEstadoDeCuenta();
	});

	$('#btnSubirEstadoDeCuenta').on('click', function(e){
		subirEstadoDeCuenta();
	});

	$('#btnFiltros').on('click', function(e){
		buscaDatos();
	});

	$('#btnUnificar').on('click', function(e){
		unificar();
	});

	$('#btnConciliacionManual').on('click', function(e){
		conciliaManual();
	});

	$('#btnDesconciliar').on('click', function(e){
		desconciliar();
	});

	$('#btnSwitch').on('click', function(e){
		switchMovimientos();
	});
}//initView

function cargarPendientesConciliacion(){
	$.ajax({
		url			: BASE_PATH + '/inc/ajax/_Contabilidad/Tablero/cargarPendientesConciliacion.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {}
	})
	.done(function(resp){
		if(resp.bExito == true){
			$('#div-pendientes_conciliacion').html(resp.html);
		}
	})
	.fail(function(){
	});
} // cargarPendientesConciliacion

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

function cargarEstadoDeCuenta(){
	var params = $('form[name=filtrosCfg]').getSimpleParams();

	if(params.nIdCfg == undefined || params.nIdCfg == '' || params.nIdCfg <= 0){
		jAlert('Seleccione Cuenta de Banco', 'Mensaje');
		return false;
	}

	$('form[name=formEstadoDeCuenta]').get(0).reset();
	$('form[name=formEstadoDeCuenta] :input[name=sArchivo]').val('');
	$('#modal-estado_de_cuenta').modal('show');
} // cargarEstadoDeCuenta

function subirEstadoDeCuenta(){
	var params = $('form[name=filtrosCfg]').getSimpleParams();

	var nIdCfg = params.nIdCfg;

	if(nIdCfg == undefined || nIdCfg.trim() == '' || nIdCfg <= 0){
		jAlert('Seleccione Cuenta', 'Mensaje');
		return;
	}

	var sNombreArchivo = $('form[name=formEstadoDeCuenta] :input[name=sArchivo]').val();

	if(sNombreArchivo == undefined || sNombreArchivo == ''){
		jAlert('Seleccione un Archivo', 'Mensaje');
		return false;
	}

	var input = document.getElementsByName('sArchivo')[0];

	if(input.files == undefined || !input.files){
		jConfirm('Verifique que el Estado de Cuenta haya sido descargado el D\u00EDa de Hoy', 'Mensaje', function(r){
			if(r){
				subeEstadoDeCuenta(sNombreArchivo);
			}
		});
	}
	else{
		var file = input.files[0];

		var lastModified	= file.lastModifiedDate
		var dLastModified	= new Date(lastModified);
		var year			= dLastModified.getFullYear();
		var month			= dLastModified.getMonth(); month+=1;
		month				= (month < 10)? "0"+month : month;
		var day				= dLastModified.getDate();
		day					= (day < 10)? "0"+day : day;
		var dDate			= year + "-" + month + "-" + day;

		var dHoy			= fnHoy();
		var nDias			= restaFechas(dHoy, dDate);

		nDias =0;
		if(nDias == 0){
			subeEstadoDeCuenta(sNombreArchivo);
		}
		else{
			$.alerts.okButton = "Aceptar";
			jAlert('Al parecer el Estado de Cuenta que intenta subir no ha sido descargado el D\u00EDa de Hoy', 'Mensaje');
		}
	}
}// cargarEstadoDeCuenta

function subeEstadoDeCuenta(sNombreArchivo){
	var params = $('form[name=filtrosCfg]').getSimpleParams();
	var nIdCfg = params.nIdCfg;

	var arrNombreArchivo	= sNombreArchivo.split('.');
	var length				= arrNombreArchivo.length;
	var sExtArchivo			= arrNombreArchivo[length-1];

	$('#btnSubirEstadoDeCuenta').prop('disabled', true);

	$("form[name=formEstadoDeCuenta]").submit(function(e){
		if(window.FormData !== undefined){
			var formData = new FormData(this);
			formData.append('nIdCfg', nIdCfg);

			showSpinner();
			$.ajax({
				url			: BASE_PATH + '/inc/Ajax/_Contabilidad/Tablero/cargarEstadoCuenta.php',
				type		: 'POST',
				data		: formData,
				mimeType	:"multipart/form-data",
				contentType	: false,
				cache		: false,
				processData	: false,
				dataType	: 'json',
				success		: function(response, textStatus, jqXHR){
					jAlert(response.sMensaje, 'Mensaje');
					$('#btnSubirEstadoDeCuenta').prop('disabled', false);
					setTimeout(function(){$('#modal-estado_de_cuenta').modal('hide'); buscaDatos();}, 2000);
				},
				error		: function(jqXHR, textStatus, errorThrown){
					$('#btnSubirEstadoDeCuenta').prop('disabled', false);
					hideSpinner();
				},
				complete	: function(){
					hideSpinner();
				}
			});
			e.preventDefault();
			$(this).unbind();
		}
	});
	$("form[name=formEstadoDeCuenta]").submit();
}

function conciliaManual(){
	var chkBanco	= $('#tbl-banco :checkbox:checked');
	var chkDeposito	= $('#tbl-depositos :checkbox:checked');

	var lengthBanco		= chkBanco.length;
	var lengthDeposito	= chkDeposito.length;

	if(lengthBanco != 1){
		jAlert('Seleccione un solo Movimiento Bancario', 'Mensaje');
		return false;
	}

	if(lengthDeposito != 1){
		jAlert('Seleccione un solo Dep\u00F3sito', 'Mensaje');
		return false;
	}

	var nIdMovBanco = $('#tbl-banco :checkbox:checked').val();
	var nIdDeposito	= $('#tbl-depositos :checkbox:checked').val();

	var nIdEstatusBanco		= $('#tbl-banco :checkbox:checked').attr('nidestatus');
	var nIdEstatusDeposito	= $('#tbl-depositos :checkbox:checked').attr('nidestatus');

	var nIdBancoBanco		= $('#tbl-banco :checkbox:checked').attr('nidbanco');
	var nIdBancoDeposito	= $('#tbl-depositos :checkbox:checked').attr('nidbanco');

	var nImporteBanco		= $('#tbl-banco :checkbox:checked').attr('nimporte');
	var nImporteDeposito	= $('#tbl-depositos :checkbox:checked').attr('nimporte');

	if(nIdEstatusBanco != 1){
		jAlert('Seleccione un Movimiento Bancario con estatus No Conciliado', 'Mensaje');
		return false;
	}

	if(nIdEstatusDeposito != 1){
		jAlert('Seleccione un Dep\u00F3sito con estatus No Conciliado', 'Mensaje');
		return false;
	}

	if(nIdBancoBanco != nIdBancoDeposito){
		jAlert('El Banco del Movimiento Bancario y del Dep\u00F3sito debe ser el mismo', 'Mensaje');
		return false;
	}

	if(nImporteBanco != nImporteDeposito){
		jAlert('El importe de los Movimientos debe ser igual', 'Mensaje');
		return false;
	}

	jConfirm('\u00BFSeguro que desea Conciliar los Movimientos Seleccionados?', 'Confirmaci\u00F3n', function(r){
		if(r == true){
			conciliar(nIdMovBanco, nIdDeposito, 0);
		}
	});
} // conciliaManual

function muestraModalAutorizar(data){
	$('#modal-autorizacion_conciliacion').modal('show');
	$('#lblNameAutorizador').html(data.sNombreCompleto);

	$('#btnAutorizarConciliacion').on('click', function(e){
		autorizarMovimiento();
	});
} // muestraModalAutorizar

function autorizarMovimiento(){
	jConfirm('\u00BFEst\u00E1 seguro(a) de Autorizar?', 'Confirmaci\u00F3n', function(r){
		if(r == true){
			var nIdMovBanco = $('#tbl-banco :checkbox:checked').val();
			var nIdDeposito	= $('#tbl-depositos :checkbox:checked').val();

			var sClave		= $('form[name=formAutorizacionConciliacion] :input[name=sClave]').val();
			var sClaveHash	= CryptoJS.SHA256(sClave, { asString: true });
			sClave = sClaveHash.toString();

			conciliar(nIdMovBanco, nIdDeposito, 1, sClave);
		}
	});
} //  autorizarMovimiento

function conciliar(nIdMovBanco, nIdDeposito, bAutorizado, sClave){
	showSpinner();
	$.ajax({
		url			: '../../../inc/Ajax/_Contabilidad/Tablero/conciliarManual.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			nIdMovBanco	: nIdMovBanco,
			nIdDeposito	: nIdDeposito,
			bAutorizado	: bAutorizado,
			sClave		: sClave
		}
	})
	.done(function(resp){
		if(resp.nCodigo != 1){
			jAlert(resp.sMensaje, 'Mensaje');
		}

		if(resp.nCodigo == 0){
			if(bAutorizado == 1){
				$('#modal-autorizacion_conciliacion').modal('hide');
				$('form[name=formAutorizacionConciliacion] :input[name=sClave]').val('');
			}
			buscaDatos();
		}
		else{
			if(resp.nCodigo == 1){
				muestraModalAutorizar(resp.data);
			}
		}
	})
	.fail(function(){
	})
	.always(function(){
		hideSpinner();
	});
} // conciliar

function desconciliar(){
	var chkBanco	= $('#tbl-banco :checkbox:checked');
	var lengthBanco	= chkBanco.length;

	if(lengthBanco <= 0){
		jAlert('Seleccione un Movimiento Bancario', 'Mensaje');
		return false;
	}

	if(lengthBanco != 1){
		jAlert('Seleccione un solo Movimiento Bancario', 'Mensaje');
		return false;
	}

	var nIdMovBanco = $('#tbl-banco :checkbox:checked').val();

	if(nIdMovBanco == undefined || nIdMovBanco == '' || nIdMovBanco <= 0){
		jAlert('Seleccione un Movimiento Bancario', 'Mensaje');
		return false;
	}

	var nIdEstatusBanco		= $('#tbl-banco :checkbox:checked').attr('nidestatus');

	if(nIdEstatusBanco != 2){
		jAlert('Solo es posible desconciliar los movimientos con estatus "Conciliaci\u00F3n Parcial"', 'Mensaje');
		return false;
	}



	jConfirm('\u00BFDesea Desconciliar el movimiento?<br>El Movimiento Bancario y el Dep\u00F3sito ser\u00E1n marcados como Cancelados<br> y el monto ser\u00E1 cargado a la cuenta de Forelo del Cliente m\u00E1s  un cargo administrativo', 'Confirmaci\u00F3n', function(c){
		if(c){
			showSpinner();
			$.ajax({
				url			: '../../../inc/Ajax/_Contabilidad/Tablero/desconciliar.php',
				type		: 'POST',
				dataType	: 'json',
				data		: {
					nIdMovBanco	: nIdMovBanco
				}
			})
			.done(function(resp){
				if(resp.nCodigo == 0){
					buscaDatos();
				}

				jAlert(resp.sMensaje, resp);
			})
			.fail(function(){
			})
			.always(function(){
				hideSpinner();
			});
		}
	});
}// desconciliar

function unificar(){
	var chkBanco	= $('#tbl-banco :checkbox:checked');
	var lengthBanco	= chkBanco.length;

	if(lengthBanco != 2){
		jAlert('Debe seleccionar 2 Movimientos Bancarios', 'Mensaje');
		return false;
	}

	var nIdMovBanco1 = $('#tbl-banco :checkbox:checked')[0].value;
	var nIdMovBanco2 = $('#tbl-banco :checkbox:checked')[1].value;

	var nIdEstatusMov1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('nidestatus');
	var nIdEstatusMov2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('nidestatus');

	var nIdBancoMov1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('nidbanco');
	var nIdBancoMov2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('nidbanco');

	var sFechaMov1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('sfecha');
	var sFechaMov2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('sfecha');

	var nImporteMov1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('nimporte');
	var nImporteMov2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('nimporte');

	if(nIdEstatusMov1 != 2 && nIdEstatusMov2 != 2){
		jAlert('Seleccione un Movimiento con estatus "Conciliaci\u00F3n Parcial"', 'Mensaje');
		return false;
	}

	if(nIdBancoMov1 != nIdBancoMov2){
		jAlert('No es posible unificar los movimientos debido a que son de Bancos diferentes', 'Mensaje');
		return false;
	}

	if(sFechaMov1 != sFechaMov2){
		jAlert('No es posible unificar los movimientos debido a que son de Fechas diferentes', 'Mensaje');
		return false;
	}

	if(nImporteMov1 != nImporteMov2){
		jAlert('No es posible unificar los movimientos debido a que los Importes son diferentes', 'Mensaje');
		return false;
	}

	jConfirm('\u00BF Desea Unificar los Movimientos Bancarios seleccionados?', 'Confirmaci\u00F3n', function(c){
		if(c){
			showSpinner();
			$.ajax({
				url			: '../../../inc/Ajax/_Contabilidad/Tablero/unificar.php',
				type		: 'POST',
				dataType	: 'json',
				data		: {
					nIdMovBanco1 : nIdMovBanco1,
					nIdMovBanco2 : nIdMovBanco2
				}
			})
			.done(function(resp){
				if(resp.nCodigo == 0){
					buscaDatos();
				}

				jAlert(resp.sMensaje, 'Mensaje');
			})
			.fail(function(){
			})
			.always(function(){
				hideSpinner();
			});
		}
	});
} // unificar

function switchMovimientos(){
	var elementos	= $('#tbl-banco :input[type=checkbox]:checked');
	var length		= elementos.length;

	if(length != 2){
		jAlert('Debe Seleccionar por lo menos 2 Movimientos Bancarios', 'Mensaje');
		return false;
	}

	var el1		= $('#tbl-banco :input[type=checkbox]:checked')[0];
	var el2		= $('#tbl-banco :input[type=checkbox]:checked')[0];

	var nIdMovBanco1 = $('#tbl-banco :checkbox:checked')[0].value;
	var nIdMovBanco2 = $('#tbl-banco :checkbox:checked')[1].value;

	var nIdEstatusMov1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('nidestatus');
	var nIdEstatusMov2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('nidestatus');

	var nIdBancoMov1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('nidbanco');
	var nIdBancoMov2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('nidbanco');

	var sFechaMov1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('sfecha');
	var sFechaMov2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('sfecha');

	var nImporteMov1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('nimporte');
	var nImporteMov2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('nimporte');

	var nAutorizacion1 = $('#tbl-banco :checkbox:checked')[0].getAttribute('nautorizacion');
	var nAutorizacion2 = $('#tbl-banco :checkbox:checked')[1].getAttribute('nautorizacion');

	if(nIdEstatusMov1 == 1 && nIdEstatusMov2 == 1){
		jAlert('Seleccione un Movimiento con estatus "Conciliaci\u00F3n Parcial"', 'Mensaje');
		return false;
	}

	if(nIdEstatusMov1 == 0 && nIdEstatusMov2 == 0){
		jAlert('Seleccione Movimientos con Estatus diferente a "Conciliado"', 'Mensaje');
		return false;
	}

	if(nIdBancoMov1 != nIdBancoMov2){
		jAlert('No es posible corregir los movimientos debido a que son de Bancos diferentes', 'Mensaje');
		return false;
	}

	if(sFechaMov1 != sFechaMov2){
		jAlert('No es posible corregir los movimientos debido a que son de Fechas diferentes', 'Mensaje');
		return false;
	}

	if(nImporteMov1 != nImporteMov2){
		jAlert('No es posible corregir los movimientos debido a que los Importes son diferentes', 'Mensaje');
		return false;
	}

	if(nAutorizacion1 == 0 || nAutorizacion2 == 0){
		jAlert('Ambos Movimientos deben contar con N\u00FAmero de Autorizaci\u00F3n', 'Mensaje');
		return false;
	}

	showSpinner();
	$.ajax({
		url			: '../../../inc/Ajax/_Contabilidad/Tablero/corregirMovimientos.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			nIdMovBanco1 : nIdMovBanco1,
			nIdMovBanco2 : nIdMovBanco2
		}
	})
	.done(function(resp){
		if(resp.nCodigo == 0){
			buscaDatos();
		}

		jAlert(resp.sMensaje, 'Mensaje');
	})
	.fail(function(){
	})
	.always(function(){
		hideSpinner();
	});
} // switchMovimientos