
function initComponentsAutorizacion(){

	$(':input').bind('paste', function(){return false;});

	var checkin1 = $('#txtFechaFact').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			checkin1.hide();
		}
	).data('datepicker');

	$("#noFactura").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});

	$("#tRFC").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 15
	});

	/*$("#txtNumCuenta").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 11
	});*/
	
	$("#txtNumCuenta").numeric({
		allowMinus			: false,
		allowThouSep		: false,
		allowDecSep			: false,
		maxLength			: 11
	});

	$("#txtdetalle").alphanum({
		allow				: 'áéíóúñÁÉÍÓÚÑ.',
		allowNumeric		: true,
		allowOtherCharSets	: false
	});

	// Llenar combo de Estatus
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeEstatusData_Contable.php', 'idEstatus', {op : 0}, {text : 'descEstatus', value : 'idEstatus'});
	// Llenar combo de Tipo de Corte de Pago
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoCortePago.php', 'tipoPago', {}, {text : 'descTipoCortePago', value : 'idTipoCortePago'});

	$('body').on('tablaLlena', function(ev, oT){
		dataTableObj.fnSettings().aoColumns[3].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[4].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[5].sClass = 'align-right';
	});
}

function buscarAutorizaciones(){

	var extraHeaders	= '';
	var extraCells		= '';

	var extraHeaders	= "";
	var extraCells		= "";

	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Tipo</th><th>Documento</th><th>#</th><th>Importe Original</th><th>Importe Solicitado</th><th>Importe Diferencia</th><th>Descripci&oacute;n</th><th>Estatus</th><th>Autorizar</th></tr></thead><tbody></tbody></table>');
	$('#botones_excel').show();
	$('#gridbox').show();

	var parametros = getParams($("form").serialize());

	if ( ID_PERFIL != 3 && ID_PERFIL != 1 ) {
		var customsettings = {
			aoColumnDefs: [
				{ bSortable	: false, aTargets: [8] }
			]
		}
	} else {
		var customsettings = { aoColumnDefs: [] };
	}

	//llenaDataTable("tblGridBox", parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/Pagos/ListaAutorizaciones.php");
	llenarDataTable("tblGridBox", parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/Pagos/ListaAutorizaciones.php", customsettings);
}

function buscarAutorizacionesProveedores(){

	var extraHeaders	= '';
	var extraCells		= '';

	var extraHeaders	= "";
	var extraCells		= "";

	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Tipo</th><th>Documento</th><th>#</th><th>Importe Original</th><th>Importe Solicitado</th><th>Importe Diferencia</th><th>Descripci&oacute;n</th><th></th><th>Autorizar</th></tr></thead><tbody></tbody></table>');
	$('#botones_excel').show();
	$('#gridbox').show();

	var parametros = getParams($("form").serialize());

	llenaDataTable("tblGridBox", parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/Pagos/ListaAutorizacionesProveedores.php");
}


function abrirDetalle(event){
	
		
	var target = event.target;

	var params = getAttrs(event.target);

	parametrosGlobales = params;

	var origenDocumento = $(target).attr('origendocumento');
	var nombreDocumento = $(target).attr('nombredocumento');

	$('#nameDoc').html(nombreDocumento);

	urlpost	= "";
	var url	= "";

	var mostrarmodal	= true;
	console.log(params);
	// si es un reembolso
	if(params.tipocorte == 5){
		idDoc = params.iddocumento;
		urlpost = "/inc/Ajax/_Contabilidad/cargarReembolso.php";
		url = "/_Contabilidad/Pagos/Reembolsos/Consulta.php";
		mostrarmodal = true;
		idTipoProveedor = 0;
	}// si es una factura o recibo
	else{
		// urls para 
		idDoc = params.iddocumento;
		idTipoProveedor = 0;
		switch(origenDocumento){
			// proveedor interno
			case '1':
				$('#idTipoProveedor').val(0); // tipo proveedor = 0 (interno), se necesita para cargar el combo de proveedores de la pantalla de consulta
				urlpost = '/inc/Ajax/_Contabilidad/loadDocumento.php';
				url = "/_Contabilidad/FacturasRecibos/Consulta.php?idFactura=" + params.iddocumento + "&tipoDocumento=" + params.tipodocumento + "&noFactura=" + params.nofactura + "&numeroCuenta=" + params.numcuenta + "&idAutorizacion=" + params.idautorizacion;
			break;
			// proveedor externo
			case '2':
			idTipoProveedor = 1;
				$('#idTipoProveedor').val(1); // tipo proveedor = 1 (externo), se necesita para cargar el combo de proveedores de la pantalla de consulta
				urlpost = '/inc/Ajax/_Contabilidad/loadDocumento.php';
				url = "/_Contabilidad/FacturasRecibos/Consulta.php?tipoProveedor=1&idFactura=" + params.iddocumento + "&tipoDocumento=" + params.tipodocumento + "&noFactura=" + params.nofactura + "&numeroCuenta=" + params.numcuenta + "&idAutorizacion=" + params.idautorizacion;
			break;
			// corresponsal
			case '3':
			
				urlpost = '/inc/Ajax/_Contabilidad/loadFacturaCliente.php';
				url = "/_Contabilidad/FacturasRecibos/ConsultaCliente.php?idFactura=" + params.iddocumento + "&tipoDocumento=" + params.tipodocumento + "&noFactura=" + params.nofactura + "&numeroCuenta=" + params.numcuenta + "&idAutorizacion=" + params.idautorizacion;
			break;
			// grupo
			case '4':
				urlpost = '/inc/Ajax/_Contabilidad/loadFacturaGrupo.php';
				url = "/_Contabilidad/FacturasRecibos/ConsultaGrupo.php?idFactura=" + params.iddocumento + "&idAutorizacion=" + params.idautorizacion;
			break;

			default:
				mostrarmodal = false;
			break;
		}
	}

console.log(BASE_PATH);
	if(mostrarmodal){
		cargarContenidoHtml(BASE_PATH + url, 'divI', 'loadDocumento(' +idDoc + ')', params);
	}
}

// cargar datos del documento
function loadDocumento(idDoc){
	$.post(BASE_PATH + urlpost,
		{
			idDocumento 	: idDoc,
			idCorte			: idDoc,
			idTipoProveedor	: idTipoProveedor
		},
		function(response){
			console.log(response.data);
			fillFieldsChange(response.data, '');
		},
		'json'
	);
}

function cerrarModal(){
	$('#divI').empty();
}

function showExcel(todo){
	showExcelCommon(todo, BASE_PATH + '/inc/Ajax/_Contabilidad/Pagos/ListaExcelAutorizaciones.php', '#formBusqueda');
}

function showExcelProvs(todo){
	showExcelCommon(todo, BASE_PATH + '/inc/Ajax/_Contabilidad/Pagos/ListaExcelAutorizacionesProveedores.php', '#formBusqueda');
}

/*
**	Funcion para autorizar y rechazar
*/
function autorizar(){
	var attrs = getAttrs(event.target);
	var params = formatParams(attrs, parametrosGlobales);
	var dtl = $('#txtdetalle').val();

	if(dtl.trim() == ""){
		alert('Capture Observaciones');
	}
	else{
		if(confirm("\u00BF" + attrs.info + "?")){
			params.detalle = dtl;

			$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/Pagos/Autorizar.php',
				params,
				function(response){
					if(showMsg(response)){
						alert(response.msg);
					}

					//if(response.success == true){
						$('#ModalEditar').modal('hide');
						$('#txtdetalle').val('');
						
						/*if(response.success == true && response.showMsg == 0){
							alert("El pago ha sido autorizado.");
						}*/

						//$('#btnBuscarAutorizaciones').trigger('click');
						buscarAutorizaciones();
					//}
				},
				"json"
			);
		}
	}
}