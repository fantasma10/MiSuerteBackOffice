
function initComponentsConsultaCortesProveedor(){
	// Llenar combo de Proveedores
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeProveedores.php', 'ddlProv', {tipoProv : 0}, {text : 'nombreProveedor', value : 'idProveedor'});
	// LLenar combo de Meses
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeMeses.php', 'ddlMes', {}, {text : 'descMes', value : 'idMes'});
	// LLenar combo de Años
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeAniosCortes.php', 'ddlAnio', {tipoCorte : 3}, {text : 'anio', value : 'anio'});
	//Lenar combo de EStatus
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeEstatusData_Contable.php', 'ddlEstatus', {}, {text : 'descEstatus', value : 'idEstatus'});

	$('body').on('tablaLlena', function(ev, oT){
		dataTableObj.fnSettings().aoColumns[4].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[5].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[6].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[7].sClass = 'align-right';
	});

	$('linkFacturas').on('click', function(){
		console.log(event);
	});

}

//Busca los pago pendientes a proveedores
function BuscarCorteProveedor(){

	var parametros = $('#formCorteProveedor').serialize();
	var params = getParams(parametros);

	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Proveedor</th><th>N&uacute;mero de Cuenta</th><th>Fecha Inicio</th><th>Fecha Final</th><th>Importe</th><th>Iva</th><th>Importe Total</th><th>Total Operaciones</th><th>Factura</th><th>Fecha de Pago</th><th>Descripci&oacute;n</th><th>Estatus</th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>');
	$('#botones_excel').show();
	$('#gridbox').show();

	var parametros = getParams($("form").serialize());

	llenaDataTable('tblGridBox', parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/BuscarCorteProveedor.php");
}

function descargaExcel(todo){
	showExcelCommon(todo, BASE_PATH + "/inc/Ajax/_Contabilidad/CortesProveedorExcel.php");
}

function showListaFacturas(e){
	var link = e.target;

	var idCorte			= $(link).attr('idcorte');
	var idProveedor		= $(link).attr('idproveedor');
	var tipoProveedor	= $(link).attr('tipoproveedor');
	var importeCorte	= $(link).attr('importe');

	cfgCorte = {
		tipoProveedor	: tipoProveedor, // proveedores internos
		tipoCorte		: 2,
		idCorte			: idCorte,
		idProveedor		: idProveedor,
		importeCorte	: importeCorte
	}

	cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaAsignar.php', 'divTbl', 'initComponentsAsignarFacturas()');
	$('#mainTitleModal').empty().html('Asignar Factura');
	$("#cornerModal").empty().html('Asignaci&oacute;n de Facturas');
}

function cerrarModal(){
	$('#divTbl').empty();
}

function AbrirDetalleDeFactura(tipoDocumento, numeroCuenta, noFactura){
	
	var url = BASE_PATH + "/_Contabilidad/FacturasRecibos/Consulta.php?tipoDocumento="+tipoDocumento+"&numeroCuenta="+numeroCuenta+"&noFactura="+noFactura;
	cargarContenidoHtml(url, 'divTbl', 'cambiaTitulosModal()');
}

function cambiaTitulosModal(){
	$('#mainTitleModal').empty().html("Factura / Recibo");
	$('#cornerModal').empty().html("Factura / Recibo");
}