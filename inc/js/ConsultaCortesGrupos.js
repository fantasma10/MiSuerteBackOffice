
function initComponentsConsultaCortesGrupo(){
	// LLenar combo de Grupos
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeGrupos.php', 'ddlGrupo', {}, {text : 'nombreGrupo', value : 'idGrupo'}, {}, 'grupoloaded');
	// LLenar combo de Meses
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeMeses.php', 'ddlMes', {}, {text : 'descMes', value : 'idMes'});
	// LLenar combo de Años
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeAniosCortes.php', 'ddlAnio', {tipoCorte : 2}, {text : 'anio', value : 'anio'});
	// Lenar combo de Estatus
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeEstatusData_Contable.php', 'ddlEstatus', {}, {text : 'descEstatus', value : 'idEstatus'});

	$('body').on('tablaLlena', function(ev, oT){
		dataTableObj.fnSettings().aoColumns[5].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[6].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[9].style = 'word-wrap:break-word';

	});

	$('body').delegate('.check', 'click', seleccionarFacturas);

	$('#gridbox').delegate('#tblGridBox tbody tr', 'click',  function(){
		console.log(event.target);
		if(event.target.type != 'checkbox'){
			console.log(this);
			var rowIndex = dataTableObj.fnGetPosition(this);
			console.log(rowIndex);
			var checkBox = $(".check[row='" + rowIndex + "']").trigger('click');
		}
	});
}

function buscarCorteGrupo(){
	var parametros = getParams($('#formCorteGrupo').serialize());

	$("#botones_excel").show();
	$("#gridbox").empty().html("<table id='tblGridBox' class='display table table-bordered table-striped'><thead><tr><th>Seleccione</th><th>Pago</th><th>N&uacute;mero de Cuenta</th><th>Instrucci&oacute;n</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Importe Total</th><th>Total Ventas</th><th>Detalle</th><th>Factura</th><th>Estatus</th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>");

	llenaDataTable('tblGridBox', parametros, BASE_PATH + '/inc/Ajax/_Contabilidad/BuscaPagoGrupo.php');

	$("#gridbox").show();	
}

function descargaExcel(todo){
	var url = BASE_PATH + '/inc/Ajax/_Contabilidad/CortesGrupoExcel.php';
	showExcelCommon(todo, url, '#formCorteGrupo');
}

function AbrirDetalleDeFactura(tipoDocumento, numeroCuenta, noFactura){
	
	var url = BASE_PATH + "/_Contabilidad/FacturasRecibos/Consulta.php?tipoDocumento="+tipoDocumento+"&numeroCuenta="+numeroCuenta+"&noFactura="+noFactura;
	cargarContenidoHtml(url, 'divTbl', 'cambiaTitulosModal()');
}

function cambiaTitulosModal(){
	$('#mainTitleModal').empty().html("Factura / Recibo");
	$('#cornerModal').empty().html("Factura / Recibo");
}

function seleccionar(){
	var el = event.target;

	var at = getAttrs(el);

	var numCuenta = at.numcuenta;

	var disabled = $(".check[numcuenta='"+numCuenta+"']").is(':checked');

	$(".check[numcuenta!='"+ numCuenta +"']").prop('disabled', disabled);
}

function seleccionarFacturas(){
	
	var el = event.target;

	var at = getAttrs(el);

	var idFactura = at.idfactura;

	var disabled = $(".check[idfactura='"+idFactura+"']").is(':checked');

	if (noInputs > 1){
		
		$(".check[idfactura!='"+ idFactura +"']").prop('disabled', disabled);
		$(".check[idcorte]").prop('disabled', false);		
	};
		
	
}

var noInputs;

function showAsignarFactura(){
	var nInputs = $('input:checked').length;

	if(nInputs > 0){
		noInputs = nInputs;
		cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaAsignarGrupos.php', 'divTbl', 'initComponentsAsignarFacturas()');
		$("#SectionModal").modal();
	}
	else{
		alert("Debe seleccionar por lo menos un corte");
	}
}