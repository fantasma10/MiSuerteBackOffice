function initViewCorte(){

	initFiltros();
} // initViewCobro

function initFiltros(){
	$('form[name=formFiltros] :input[name=nIdProveedor]').customLoadStore({
		url				: BASE_PATH + '/misuerte/ajax/proveedores/proveedoresLista.php',
		labelField		: 'sNombreComercial',
		idField			: 'nIdProveedor',
		firstItemId		: '0',
		firstItemValue	: 'Seleccione'
	});

	$('#cmbPeriodo').customLoadStore({
		url				: BASE_PATH + '/misuerte/ajax/cortes/mensual/storePeriodos.php',
		labelField		: 'sPeriodo',
		idField			: 'nIdPeriodo',
		firstItemId		: '0',
		firstItemValue	: 'Seleccione'
	});

	$('#btnFiltros').on('click', function(e){
		buscarInfo();
	});
} // initFiltros

function buscarInfo(){
	var params = $('form[name=formFiltros]').getSimpleParams();

	if(params.nIdPeriodo == undefined || params.nIdPeriodo == '' || params.nIdPeriodo <= 0){
		jAlert('Seleccione Periodo', 'Mensaje');
		return false;
	}

	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/cortes/mensual/buscaInfoCortes.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje, 'Mensaje');
		}

		var data = resp.data;

		var cliente		= data.cliente;
		var proveedor	= data.proveedor;
		var utilidad	= data.utilidades;

		armarTablaProv(proveedor);
		armarTablaCliente(cliente);
		armarTablaUtilidad(utilidad);
	})
	.fail(function(){
	});
} // buscarInfo

function armarTablaProv(data){
	var table = '<table class="display table table-bordered" id="tbl-proveedor"><thead><tr><th>Proveedor</th><th>Venta Total</th><th>Venta Indirecta</th><th>Comisiones</th></tr></thead><tbody></tbody><tfoot style="font-weight:bold;font-size:12px;"></tfoot></table>';

	$('#tbl-proveedor').replaceWith(table).promise().done(function(elem){
		var filas	= data.data;
		var length	= filas.length;

		for(var i=0; i < length; i++){
			var fila = filas[i];
			var row = '<tr>';
			row += '<td>' + fila.sNombreComercial + '</td>';
			row += '<td>' + fila.nImporteTotal + '</td>';
			row += '<td>' + fila.nImporteVentaIndirecta + '</td>';
			row += '<td>' + fila.nImporteComision + '</td>';
			row += '</tr>';
			$('#tbl-proveedor tbody').append(row);
		}

		var footer = data.footer;

		var rowF = '<tr>';
		rowF += '<td align="right">Totales&nbsp;&nbsp;&nbsp;</td>';
		rowF += '<td>' + footer.suma_nImporteTotal + '</td>';
		rowF += '<td>' + footer.suma_nImporteVentaIndirecta + '</td>';
		rowF += '<td>' + footer.suma_nImporteComision + '</td>';
		rowF += '</tr>';

		$('#tbl-proveedor tfoot').append(rowF);
	});
} // armarTablaProv

function armarTablaCliente(data){
	var table = '<table class="display table table-bordered" id="tbl-cliente"><thead><tr><th>Cliente</th><th>Venta Total</th><th>Venta Indirecta</th><th>Comisiones</th></tr></thead><tbody></tbody><tfoot style="font-weight:bold;font-size:12px;"></tfoot></table>';

	$('#tbl-cliente').replaceWith(table).promise().done(function(elem){
		var filas	= data.data;
		var length	= filas.length;

		for(var i=0; i < length; i++){
			var fila = filas[i];
			var row = '<tr>';
			row += '<td>' + fila.sNombreComercial + '</td>';
			row += '<td>' + fila.nMonto + '</td>';
			row += '<td>' + fila.nImporteVentaIndirecta + '</td>';
			row += '<td>' + fila.nComision + '</td>';
			row += '</tr>';
			$('#tbl-cliente tbody').append(row);
		}

		var footer = data.footer;

		var rowF = '<tr>';
		rowF += '<td align="right">Total&nbsp;&nbsp;&nbsp;</td>';
		rowF += '<td>' + footer.suma_nMonto + '</td>';
		rowF += '<td>' + footer.suma_nImporteVentaIndirecta + '</td>';
		rowF += '<td>' + footer.suma_nComision + '</td>';
		rowF += '</tr>';

		$('#tbl-cliente tfoot').append(rowF);
	});
} // armarTablaCliente

function armarTablaUtilidad(data){
	var table = '<table class="display table" id="tbl-suma"><thead></thead><tbody></tbody></table>';
	var thead = '<tr border="0" style="font-size:16px;"><th colspan="2">Comisiones Ganadas</th><th colspan="2">Comisiones Pagadas a Clientes</th><th>Utilidad</th></tr>'

	var row = '<tr style="font-size:14px;font-weight:bold;">';
	row += '<td border="0">'+ data.nComisionesGanadas +'</td>';
	row += '<td border="0">-</td>';
	row += '<td border="0">'+ data.nComisionesAClientes +'</td>';
	row += '<td border="0">=</td>';
	row += '<td border="0">'+ data.nUtilidad +'</td>';
	row += '</tr>';

	$('#tbl-suma').replaceWith(table).promise().done(function(el){
		$('#tbl-suma thead').append(thead);
		$('#tbl-suma tbody').append(row);
	});

} // armarTablaUtilidad