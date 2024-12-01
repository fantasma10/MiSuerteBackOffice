function armarTablaBanco(data, nTotal){

	var nIdCfg = $('#formFiltrosCfg :input[name=nIdCfg]').val();

	var table = '<table class="display table table-bordered" id="tbl-banco">';
	table += '<thead>';
	table += '<th></th>';
	if(nIdCfg <= 0){
		table += '<th>Banco</th>';
		table += '<th>Cuenta</th>';
	}
	table += '<th>Fecha</th>';
	if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 1){
		table += '<th>Conciliaci&oacute;n</th>';
	}
	if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 2){
		table += '<th>Referencia</th>';
	}
	table += '<th>Autorizaci&oacute;n</th>';
	if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 2){
		table += '<th>Cargo</th>';
	}
	table += '<th>Abono</th>';
	table += '<th>Estatus</th>';
	table += '</thead>';
	table += '<tbody>';

	for(var i=0; i<nTotal; i++){
		var elemento = data[i];
		var bgcolor = "";

		if(elemento.idEstatus == 1){
			bgcolor = "#e5aaaa";
		}
		else if(elemento.idEstatus == 2){
			bgcolor = "#e6ad00";
		}

		if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 1 && (elemento.idEstatus == 0 || elemento.idEstatus == 2)){
			bgcolor = (data[i].fecAplicacion != "" && data[i].fecAplicacion == data[i].fecBanco)? '' : '#FFFF80';
		}


		table += '<tr style="background-color:'+bgcolor+'">';
		table += '<td><input type="checkbox" name="nIdMovBanco" value="'+data[i].idMovBanco+'" nAutorizacion="'+data[i].autorizacion+'" nIdDeposito="'+data[i].nIdDeposito+'" nIdEstatus="'+data[i].idEstatus+'" nIdBanco="'+data[i].idBanco+'" nImporte="'+data[i].nAbono+'" sfecha="'+data[i].fecBanco+'"></td>';
		if(nIdCfg <= 0){
			table += '<td>'+data[i].sNombreBanco+'</td>';
			table += '<td>'+data[i].nNumCuenta+'</td>';
		}
		table += '<td>'+data[i].fecBanco+'</td>';
		if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 1){
			
			table += '<td>'+data[i].fecAplicacion+'</td>';
			
		}
		if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 2){
			table += '<td>'+data[i].referencia+'</td>';
			
		}
		table += '<td class="td-cell-autorizacion">'+data[i].autorizacion+'</td>';

		if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 2){
			table += '<td class="class-currency" align="right">'+data[i].nCargoFormato+'</td>';
		}
		table += '<td class="class-currency" align="right">'+data[i].nAbonoFormato+'</td>';
		table += '<td>'+data[i].sNombreEstatus;
		//table += (data[i].idEstatus == 1 && data[i].bAutorizar == true)? '&nbsp;<a href="#" class="show-captura-deposito"><i title="Realizar Abono" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>' : '';
		table += '</td>';
		table += '</tr>';
	}

	table += '</tbody>';
	table += '</table>';

	return table;
}

function armarTablaDepositos(data, nTotal){
	var nIdCfg = $('#formFiltrosCfg :input[name=nIdCfg]').val();

	var table = '<table class="display table table-bordered" id="tbl-depositos">';
	table += '<thead>';
	table += '<th></th>';
	table += '<th>Cliente</th>';
	if(nIdCfg <= 0){
		table += '<th>Banco</th>';
	}
	table += '<th>Fecha</th>';
	table += '<th>Autorizaci&oacute;n</th>';
	table += '<th>Abono</th>';
	table += '<th>Estatus</th>';

	if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 2){
		table += '<th></th>';
	}

	table += '</thead>';
	table += '<tbody>';

	for(var i=0; i<nTotal; i++){
		var elemento = data[i];
		var bgcolor = "";

		if(elemento.idEstatus == 1){
			bgcolor = "#e5aaaa";
		}
		else if(elemento.idEstatus == 2){
			bgcolor = "#e6ad00";
		}
		table += '<tr style="background-color:'+bgcolor+'">';
		table += '<td><input type="checkbox" name="nIdDeposito" value="'+elemento.idDeposito+'" nIdEstatus="'+elemento.idEstatus+'" nIdBanco="'+elemento.idBanco+'" nImporte="'+elemento.importe+'"></td>'
		table += '<td><a href="#" class="consulta-sucursales" nidcliente="'+elemento.nIdCliente+'" style="color:#000000;text-decoration:none;"><span class="class-show_tooltip" style="display:block!important;overflow:auto;height:100%" title="'+elemento.sNombreCliente+'<br/>'+elemento.RFC+'<br/>' +elemento.Telefono+'<br/>'+elemento.Correo+'">';
		table += elemento.sNombreCliente;
		table +='</span></a></td>';
		if(nIdCfg <= 0){
			table += '<td>'+elemento.sNombreBanco+'</td>';
		}
		table += '<td>'+elemento.fechaDeposito+'</td>';
		table += '<td>'+elemento.autorizacion+'</td>';
		table += '<td class="class-currency" align="right">'+elemento.importeFormato+'</td>';
		table += '<td>'+elemento.sNombreEstatus+'</td>';

		if(typeof(nPERFIL) !== 'undefined' && nPERFIL == 2 && elemento.idEstatus == 1){
			table += '<td style="font-weight:bold;font-size:12px;" align="middle"><a href="#" title="Eliminar" class="eliminar-deposito" niddeposito="'+elemento.idDeposito+'"><i class="fa fa-times"></i></a></td>';
		}

		table += '</tr>';
	}

	table += '</tbody>';
	table += '</table>';

	return table;
}

function generarHexadecimal(){
	return '#'+Math.floor(Math.random()*16777215).toString(16);
}

function clickToChkBanco(){
	$('#tbl-banco :checkbox').unbind('change');
	$('#tbl-banco :checkbox').on('change', function(e){
		var checked		= $(e.target).is(':checked');
		var nIdDeposito	= $(e.target).attr('niddeposito');
		var nIdEstatus	= $(e.target).attr('nidestatus');
		var nIdMovBanco	= $(e.target).val();

		if(checked && nIdDeposito != undefined && nIdDeposito != '' && nIdDeposito > 0){
			var color = generarHexadecimal();
			$('#tbl-depositos :checkbox[value='+nIdDeposito+']').closest('tr').css('background-color', color);
			$(e.target).closest('tr').css('background-color', color);
		}
		else{
			if(nIdEstatus != 1){
				$('#tbl-depositos :checkbox[value='+nIdDeposito+']').closest('tr').removeAttr('style');
				$(e.target).closest('tr').removeAttr('style');

				if(nIdEstatus == 2){
					$('#tbl-depositos :checkbox[value='+nIdDeposito+']').closest('tr').css('background-color', '#e6ad00');
					$('#tbl-banco :checkbox[value='+nIdMovBanco+']').closest('tr').css('background-color', '#e6ad00');
				}
			}
		}
	});
}

function bindClickToAut(){
	$('.td-cell-autorizacion').unbind('click');
	$('.td-cell-autorizacion').on('click', function(e){
		$('#tbl-banco tbody tr td.class-green').removeClass('class-green');
		var target = e.currentTarget;
		$(target).addClass('class-green');

	});


	$('body').unbind('keyup');
	$('body').on('keyup', function(e){
		e.preventDefault();
		return false;
	});
	$('body').on('keyup', function(e){
		e.preventDefault();
		window.event.preventDefault();

		e = e || window.event;

		var arrEls	= $('#tbl-banco tbody tr td.class-green');
		var el		= arrEls[0];
		var currentIndex = el.parentNode.rowIndex;

		//if(e.keyCode == '38'){ // up
		if(e.keyCode == '107'){ // up
			nextIndex = currentIndex-1;
		}

		//if(e.keyCode == '40'){ // down
		if(e.keyCode == '109'){ // down
			nextIndex = currentIndex+1;
		}

		if(nextIndex > 0 && nextIndex < $('#tbl-banco tr').length){
			$('#tbl-banco :checkbox').prop('checked', false);
			$('#tbl-banco tbody tr td.class-green').removeClass('class-green');

			$($('#tbl-banco tr').get(nextIndex)).find('.td-cell-autorizacion').addClass('class-green');
			$($('#tbl-banco tr').get(nextIndex)).find('.td-cell-autorizacion').focus();
			$($('#tbl-banco tr').get(nextIndex)).find(':checkbox').prop('checked', true);
		}
	});
}

function bindClickToCapture(){
	$('.show-captura-deposito').unbind('click');
	$('.show-captura-deposito').on('click', function(e){
		var chk	= $($(e.currentTarget).parent('td').parent('tr').find('td')[0]).find(':checkbox');

		var nIdBanco		= $(chk).attr('nidbanco');
		var nImporte		= $(chk).attr('nimporte');
		var dFecha			= $(chk).attr('sfecha');
		var nAutorizacion	= $(chk).attr('nAutorizacion');
		var nIdMovBanco		= $(chk).val();
		var sDescripcion	= 'Abono por Operacion ' + nAutorizacion;


		$('form[name=formCapturaDeposito] :input[name=nIdBanco]').val(nIdBanco);
		$('form[name=formCapturaDeposito] :input[name=nImporte]').val(nImporte);
		$('form[name=formCapturaDeposito] :input[name=dFecha]').val(dFecha);
		$('form[name=formCapturaDeposito] :input[name=nAutorizacion]').val(nAutorizacion);
		$('form[name=formCapturaDeposito] :input[name=sDescripcion]').val(sDescripcion);
		$('form[name=formCapturaDeposito] :input[name=nIdMovBanco]').val(nIdMovBanco);

		muestraCapturaDeposito();
	});
}

function muestraCapturaDeposito(){
	$('form[name=formCapturaDeposito] :input[name=nIdCliente]').val(0)
	$('form[name=formCapturaDeposito] :input[name=sNombreCliente]').val('');
	resetCuentaContable();
	$('#modal-captura_deposito').modal('show');
}

function ocultaCapturaDeposito(){
	$('#modal-captura_deposito').modal('hide');
}

function bindClickToTable(){
	$('#tbl-banco').unbind('click');
	$('#tbl-banco').on('click', 'tr', function(e){
		if(e.currentTarget != undefined){

			if(e.target.type == 'checkbox'){
				return;
			}

			if(e.target.tagName == 'BUTTON'){
				return false;
			}

			if(e.target.tagName == 'INPUT'){
				return false;
			}

			if(e.target.tagName == 'A'){
				return false;
			}

			var chk = $($(e.currentTarget).find('td')[0]).find(':checkbox');

			var checked = $(chk).prop('checked');

			$(chk).prop('checked', !checked);
			$(chk).trigger('change');
		}
	});

	$('#tbl-depositos').unbind('click');
	$('#tbl-depositos').on('click', 'tr', function(e){
		if(e.currentTarget != undefined){

			if(e.target.type == 'checkbox'){
				return;
			}

			if(e.target.tagName == 'BUTTON'){
				return false;
			}

			if(e.target.tagName == 'INPUT'){
				return false;
			}

			if(e.target.tagName == 'A'){
				return false;
			}

			if(e.target.tagName == 'SPAN'){
				return false;
			}

			if(e.target.tagName == 'I'){
				return false;
			}

			var chk = $($(e.currentTarget).find('td')[0]).find(':checkbox');

			var checked = $(chk).prop('checked');

			$(chk).prop('checked', !checked);
		}
	});
}

function ajaxBancoMovs(params){
	showSpinner();
	$.ajax({
		url			: '/inc/Ajax/_Contabilidad/Tablero/cargarBancoMovs.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		if(resp.bExito == false || resp.nCodigo != 0){
			jAlert(resp.sMensaje);
		}
		else{
			var table = armarTablaBanco(resp.data, resp.nTotal);

			$('#tbl-banco').replaceWith(table).promise().done(function(elem){
				bindClickToTable();
				clickToChkBanco();
				bindClickToAut();
				showCheckBox();
				bindClickToCapture();
			});
		}
	})
	.fail(function(){
	})
	.always(function(){
		hideSpinner();
	});
}

function ajaxDepositoMovs(params){
	showSpinner();
	$.ajax({
		url			: '/inc/Ajax/_Contabilidad/Tablero/cargarDepositoMovs.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		if(resp.bExito == false || resp.nCodigo != 0){
			jAlert(resp.sMensaje);
		}
		else{
			//var table = armarTablaBanco(resp.data, resp.nTotal);

			/*$('#tbl-banco').replaceWith(table).promise().done(function(elem){

			});*/
			var table = armarTablaDepositos(resp.data, resp.nTotal);

			$('#tbl-depositos').replaceWith(table).promise().done(function(elem){
				$('.class-show_tooltip').powerTip('destroy');
				$('.class-show_tooltip').powerTip({
					mouseOnToPopup	: true
				});

				if($('.eliminar-deposito').length > 0){

					$('.eliminar-deposito').unbind('click');
					$('.eliminar-deposito').on('click', function(e){
						e.preventDefault();
						var nIdDeposito = $(e.currentTarget).attr('niddeposito');
						eliminarDeposito(nIdDeposito);
					});
				}

				if($('.consulta-sucursales').length > 0){
					$('.consulta-sucursales').unbind('click');
					$('.consulta-sucursales').on('click', function(e){
						e.preventDefault();
						var nIdCliente = $(e.currentTarget).attr('nidcliente');
						consultaSucursales(nIdCliente);
					});
				}

				bindClickToTable();
			});
		}
	})
	.fail(function(){
	})
	.always(function(){
		hideSpinner();
	});
}

function buscaDatos(){

	var params = $('form[name=filtrosCfg]').getSimpleParams();

	if(typeof(nPERFIL) !== 'undefined'){
		params.nPerfil = nPERFIL;
	}

	var dFechaInicio	= params.dFechaInicio;
	var dFechaFinal		= params.dFechaFinal;

	var arrFI = dFechaInicio.split('-');
	var arrFF = dFechaFinal.split('-');

	var nDFechaInicio	= new Date(arrFI[0], arrFI[1]-1, arrFI[2]);
	var nDFechaFinal	= new Date(arrFF[0], arrFF[1]-1, arrFF[2]);

	if(nDFechaInicio > nDFechaFinal){
		jAlert('La Fecha Inicio debe ser menor a la Fecha Final');
		return;
	}

	var nListaEstatus  = new Array();
	var nListaEstatusD = new Array();

	var checked = $('form[name=filtrosCfg] :checkbox[name=nIdEstatus]:checked');
	var length	= checked.length;

	for(var i=0; i<length; i++){
		nListaEstatus.push(checked[i].value);
	}

	params.nArrayListaEstatus = nListaEstatus;

	var checkedD = $('form[name=filtrosCfg] :checkbox[name=nIdEstatusD]:checked');
	var lengthD	 = checkedD.length;

	for(var i=0; i<lengthD; i++){
		nListaEstatusD.push(checkedD[i].value);
	}

	params.nArrayListaEstatusD = nListaEstatusD;

	if($('form[name=filtrosCfg] :input[name=dFechaFiltro]').length >0 ){
		params.dFechaFiltro = $('form[name=filtrosCfg] :input[name=dFechaFiltro]:checked')[0].value;
	}

	ajaxBancoMovs(params);
	ajaxDepositoMovs(params);
}

function initFechaFiltro(){
	$('form[name=filtrosCfg] :input[name=dFechaFiltro]').on('change', function(e){
		var elements	= $('form[name=filtrosCfg] :input[name=dFechaFiltro]');

		for(var i=0; i<elements.length; i++){
			$(elements[i]).prop('checked', false);
		}

		var els			= $('form[name=filtrosCfg] :input[name=dFechaFiltro]:checked');
		var length		= els.length;
		var value		= $(event.target).val();


		//if(!$(event.target).is(':checked')){
		$('form[name=filtrosCfg] :input[name=dFechaFiltro]:checkbox[value='+value+']').prop('checked', true);
		//}
	});
}

function descargarPoliza(nIdPoliza){

	if($('#download_poliza').length == 0){
		$('body').append('<form id="download_poliza"></form>');
		$('#download_poliza').attr("action", BASE_PATH+"/_Contabilidad/Tablero/polizas/descargaPoliza.php") .attr("method","post")
		.append('<input type="hidden" name="nIdPoliza" value="'+nIdPoliza+'">');
	}
	else{
		$('#download_poliza :input[name=nIdPoliza]').val(nIdPoliza);
	}

	$('#download_poliza').submit();
} // descargarPoliza

function eliminarDeposito(nIdDeposito){
	jConfirm('\u00BFSeguro que desea Eliminar el Dep\u00F3sito?', 'Confirmaci\u00F3n', function(r){
		if(r == true){
			showSpinner();
			$.ajax({
				url			: '../../../inc/Ajax/_Contabilidad/Tablero/eliminarDeposito.php',
				type		: 'POST',
				dataType	: 'json',
				data		: {
					nIdDeposito	: nIdDeposito
				}
			})
			.done(function(resp){
				if(resp.nCodigo > 0){
					jAlert(resp.sMensaje, 'Mensaje');
					return false;
				}

				if(resp.nCodigo == 0){
					if($('input[type=checkbox][value='+nIdDeposito+']').length == 1){
						$('input[type=checkbox][value='+nIdDeposito+']').closest('tr').remove();
					}
					else{
						buscaDatos();
					}
				}
			})
			.fail(function(){

			})
			.always(function(){
				hideSpinner();
			});

		}
	});
} // eliminarDeposito

function consultaSucursales(nIdCliente){
	showSpinner();
	$.ajax({
		url			: '../../../inc/Ajax/_Contabilidad/Tablero/consultaSucursales.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			nIdCliente : nIdCliente
		}
	})
	.done(function(resp){
		if(resp.nCodigo != 0){
			jAlert(resp.sMensaje, 'Mensaje');
		}
		else{
			$('.muestra-lista-sucursales').empty();

			var length = resp.data.length;

			if(length > 0){

				var newDiv = '<table style="width:90%;" cellpadding="20">';
					newDiv += '<thead><th>Corresponsal</th><th>Correo Electr&oacute;nico</th><th>Tel&eacute;fono</th></thead>';
					newDiv += '<tbody>';

				for(var index=0;index<length;index++){
					var el = resp.data[index];

						newDiv += '<tr>';
						newDiv += '<td>' + el.nombreCorresponsal + '</td>';
						newDiv += '<td><label>'+ el.email + '</label></td>';
						newDiv += '<td><label>'+ el.telefono1 + '</label></td>';
						newDiv += '</tr>';
				}

				newDiv += '</table>';
				$('.muestra-lista-sucursales').append(newDiv);

				$('#modal-lista_sucursales').modal('show');
			}
			else{
				jAlert('No se encontraron sucursales', 'Mensaje');
			}
		}
	})
	.fail(function(){
	})
	.always(function(){
		hideSpinner();
	});

} // consultaSucursales