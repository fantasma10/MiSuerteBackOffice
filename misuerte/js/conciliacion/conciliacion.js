function initViewConciliacion(){
	initFiltros();
	//cargarBancoMovs();
	//cargarCortesFacturas();
} // initViewConciliacion

function initFiltros(){
	$('form[name=formFiltros] :input[name=dFechaInicio], form[name=formFiltros] :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('#btnFiltros').on('click', function(e){
		traeInfo();
	});

	$('#btnConciliar').on('click', function(e){
		concilia();
	});
} // initFiltros

function traeInfo(){
	cargarBancoMovs();
	cargarCortesFacturas();
} // traInfo

function cargarBancoMovs(){
	var params = $('form[name=formFiltros]').getSimpleParams();
	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/conciliacion/bancoMovsLista.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje, 'Mensaje');
		}

		var table = armarTablaBanco(resp.data, resp.nTotal);

		$('#tbl-banco').replaceWith(table).promise().done(function(elem){
			bindClickToTable();
			//clickToChkBanco();
			//showCheckBox();
		});
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		console.log("complete");
	});
} // cargarBancoMovs

function cargarCortesFacturas(){
	var params = $('form[name=formFiltros]').getSimpleParams();
	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/conciliacion/cortesFacturaLista.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje, 'Mensaje');
		}

		var table = armarTablaFacturas(resp.data, resp.nTotal);

		$('#tbl-facturas').replaceWith(table).promise().done(function(elem){
			bindClickToTable();
			//clickToChkBanco();
			//showCheckBox();
		});
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		console.log("complete");
	});
} // cargarBancoMovs

function armarTablaBanco(data, nTotal){

	var table = '<table class="display table table-bordered" id="tbl-banco">';
	table += '<thead>';
	table += '<th></th>';
	table += '<th>Fecha</th>';
	table += '<th>Referencia</th>';
	table += '<th>Importe</th>';
	table += '</thead>';
	table += '<tbody>';

	for(var i=0; i<nTotal; i++){
		var elemento = data[i];
		table += '<tr>';
		table += '<td align="center"><input type="checkbox" name="nIdMovBanco" value="'+data[i].idMovBanco+'" nidmovbanco="'+data[i].idMovBanco+'" referencia="'+data[i].referencia+'" importe="'+data[i].importe+'"/></td>';
		table += '<td>'+data[i].fecBanco+'</td>';
		table += '<td>'+data[i].referencia+'</td>';
		table += '<td align="right">'+data[i].importeFormato+'</td>';
		table += '</tr>';
	}

	table += '</tbody>';
	table += '</table>';

	return table;
} // armarTablaBanco

function armarTablaFacturas(data, nTotal){

	var table = '<table class="display table table-bordered" id="tbl-facturas">';
	table += '<thead>';
	table += '<th></th>';
	table += '<th>Folio</th>';
	table += '<th>Fecha</th>';
	table += '<th>Importe</th>';
	table += '</thead>';
	table += '<tbody>';

	for(var i=0; i<nTotal; i++){
		var elemento = data[i];
		table += '<tr>';
		table += '<td align="center"><input type="checkbox" name="sListaCortes" value="'+data[i].sListaCortes+'" slistacortes="'+data[i].sListaCortes+'" sfolio="'+data[i].sFolio+'" nImporteComision="'+data[i].nImporteComision+'"/></td>';
		table += '<td>'+ data[i].sFolio +'</td>';
		table += '<td>'+ data[i].dFechaInicio +'</td>';
		table += '<td align="right">'+ data[i].nImporteComisionFormato +'</td>';
		table += '</tr>';
	}

	table += '</tbody>';
	table += '</table>';

	return table;
} // armarTablaBanco

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

			var chk = $($(e.currentTarget).find('td')[0]).find(':checkbox');

			var checked = $(chk).prop('checked');

			$(chk).prop('checked', !checked);
			$(chk).trigger('change');
		}
	});

	$('#tbl-facturas').unbind('click');
	$('#tbl-facturas').on('click', 'tr', function(e){
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

			var chk = $($(e.currentTarget).find('td')[0]).find(':checkbox');

			var checked = $(chk).prop('checked');

			$(chk).prop('checked', !checked);
			$(chk).trigger('change');
		}
	});
} // bindClickToTable

function concilia(){
	var selBanco	= $('#tbl-banco :input:checked');
	var selFacturas	= $('#tbl-facturas :input:checked');

	var lengthBanco		= selBanco.length;
	var lengthFacturas	= selFacturas.length;

	var array_movs = new Array();
	var array_facs = new Array();

	if(lengthBanco == undefined || lengthBanco <= 0){
		jAlert('Seleccione un Movimiento Bancario', 'Mensaje');
		return false;
	}

	if(lengthFacturas == undefined || lengthFacturas <= 0){
		jAlert('Seleccione Factura', 'Mensaje');
		return false;
	}

	var array_referencias = new Array();
	var showMsgBanco	= false;
	var importeBanco	= 0;

	for(var i=0; i<lengthBanco; i++){
		var el = selBanco[i];

		var ref = $(el).attr('referencia');
		var imp = $(el).attr('importe');
		var id	= $(el).attr('nidmovbanco');
		imp = parseFloat(imp);

		if(array_referencias.length == 0){
			array_referencias.push(ref);
		}

		if(array_referencias.indexOf(ref) < 0){
			showMsgBanco = true;
		}

		importeBanco += imp;
		array_movs.push(id);
	}

	if(showMsgBanco == true){
		jAlert('Debe seleccionar Movimientos de Banco con la misma Referencia', 'Mensaje');
		return false;
	}

	var array_referenciasF = new Array();
	var showMsgFacturas	= false;
	var importeFacturas	= 0;

	for(var i=0; i<lengthFacturas; i++){
		var el = selFacturas[i];

		var ref = $(el).attr('sFolio');
		var imp = $(el).attr('nImporteComision');
		var id	= $(el).attr('slistacortes');
		imp = parseFloat(imp);

		if(array_referenciasF.length == 0){
			array_referenciasF.push(ref);
		}

		if(array_referenciasF.indexOf(ref) < 0){
			showMsgFacturas = true;
		}

		importeFacturas += imp;
		array_facs.push(id);
	}

	if(showMsgBanco == true){
		jAlert('Debe seleccionar Facturas el mismo Folio', 'Mensaje');
		return false;
	}

	if(array_referencias[0] != array_referenciasF[0]){
		jAlert('No coincide la Referencia con el Folio de la Factura');
		return false;
	}

	if(importeBanco != importeFacturas){
		jAlert('El Monto del Banco no coincide con el Monto de la Factura', 'Mensaje');
		return false;
	}

	console.log(array_movs);
	console.log(array_facs);

	$('#btnConciliar').prop('disabled', true);
	$.ajax({
		url			: '/misuerte/ajax/conciliacion/conciliaManual.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			array_movs : array_movs,
			array_facs : array_facs
		}
	})
	.done(function(resp){
		jAlert(resp.sMensaje);

		cargarBancoMovs();
		cargarCortesFacturas();
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		$('#btnConciliar').prop('disabled', false);
	});
} //concilia