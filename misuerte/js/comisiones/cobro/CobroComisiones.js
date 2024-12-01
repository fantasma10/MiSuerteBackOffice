function initViewCobro(){

	initFiltros();
	initModal();
	initModalPoliza();
	showEstatus();
} // initViewCobro

function initFiltros(){
	$('form[name=formFiltros] :input[name=dFechaInicio], form[name=formFiltros] :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('form[name=formFiltros] :input[name=nIdProveedor]').customLoadStore({
		url				: BASE_PATH + '/misuerte/ajax/proveedores/proveedoresLista.php',
		labelField		: 'sNombreComercial',
		idField			: 'nIdProveedor',
		firstItemId		: '0',
		firstItemValue	: 'Seleccione'
	});

	$('form[name=formFiltros] :input[name=nIdEstatus]').customLoadStore({
		url				: BASE_PATH + '/misuerte/ajax/storeEstatusCorteComision.php',
		labelField		: 'sNombre',
		idField			: 'nIdEstatus',
		firstItemId		: '-1',
		firstItemValue	: 'Seleccione'
	});

	$('#btnFiltros').on('click', function(e){
		buscarInfo();
	});

	$('#btnFactura').on('click', function(e){
		$('#modal-subirFactura').modal('show');
	});
} // initFiltros

function showEstatus(){
	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/storeEstatusCorteComision.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {}
	})
	.done(function(resp){
		console.log(resp);
		var data	= resp.data;
		var length	= data.length;

		for(var i=0; i<length; i++){
			var el = data[i];

			$('.show-estatus').append('<div class="col-xs-3"><label><i class="fa fa-circle" style="color:'+el.sColor+'"></i>&nbsp;'+el.sNombre+'</label></div>');
		}
	})
	.fail(function() {
		console.log("error");
	});
} // showEstatus

function initModal(){
	$('#btnSubirFactura').on('click', function(e){
		subirFactura();
	});
} // initModal

function initModalPoliza(){
	$('form[name=formPolizaIngresos] :input[name=dFecha]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('form[name=formPolizaIngresos] :input[name=sFolio]').alphanum({
		allow		: '1234567890-',
		maxLength	: 10
	});

	$('form[name=formPolizaIngresos] :input[name=sConcepto]').alphanum({
		allow		: '1234567890-',
		maxLength	: 200
	});

	$('#btnGeneraPoliza').on('click', function(e){
		generarPoliza();
	});
} // initModalPoliza

function buscarInfo(){
	var params = $('form[name=formFiltros]').getSimpleParams();

	if(params.dFechaInicio == undefined || params.dFechaInicio == ''){
		jAlert('Seleccione Fecha Inicio', 'Mensaje');
		return false;
	}

	if(params.dFechaFinal == undefined || params.dFechaFinal == ''){
		jAlert('Seleccione Fecha Final', 'Mensaje');
		return false;
	}

	var resta = restaFechas(params.dFechaInicio, params.dFechaFinal);

	if(resta < 0){
		jAlert('La Fecha de Inicio debe ser menor a la Fecha Final', 'Mensaje');
	}

	cargarListaCortesComision();
} // buscarInfo

function cargarListaCortesComision(){
	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th></th><th>Proveedor</th><th>Folio</th><th>Fecha Corte</th><th>Fecha Pago</th><th>Monto</th><th>Estatus</th></tr></thead><tbody></tbody><tfoot><td colspan="5"></td><td id="td_total" colspan="2">$ 0</td></tfoot></table>');

	var dataTableObj = $('#tblGridBox').dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: true,
		"bServerSide"		: true,
		"sAjaxSource"		: BASE_PATH + '/misuerte/ajax/comisiones/cobro/corteComisionesLista.php',
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
				'aTargets'	: [0]
			},
			{
				"mData"		: 'nIdCorte2',
				'aTargets'	: [0],
				'fnRender'	: function(oObj){
					var nIdCorte			= oObj.aData.nIdCorte;
					var nIdProveedor		= oObj.aData.nIdProveedor;
					var nImporteComision	= oObj.aData.nImporteComision;
					var nIdEstatus			= oObj.aData.nIdEstatus;
					if(nIdEstatus == 0){
						var html = '<input type="checkbox" class="a_seleccionar" nidcorte="'+nIdCorte+'" nImporteComision="'+nImporteComision+'" nidproveedor="'+nIdProveedor+'">';
					}
					else{
						var html = '';
					}

					return html;
				}
			},
			{
				"mData"		: 'sNombreProveedor',
				'aTargets'	: [1]
			},
			{
				"mData"		: 'sFolio',
				'aTargets'	: [2]
			},
			{
				"mData"		: 'dFechaInicio',
				'aTargets'	: [3]
			},
			{
				"mData"		: 'dFechaDeposito',
				'aTargets'	: [4]
			},
			{
				"mData"		: 'nImporteComision',
				'aTargets'	: [5]
			},
			{
				"mData"		: 'nIdEstatus',
				'aTargets'	: [6],
				'fnRender'	: function(oObj){
					var sColorEstatus	= oObj.aData.sColorEstatus;
					var sNombreEstatus	= oObj.aData.sNombreEstatus;
					var nIdEstatus		= oObj.aData.nIdEstatus;
					var nIdCorte		= oObj.aData.nIdCorte;
					var nIdPoliza		= oObj.aData.nIdPoliza;

					if(nIdEstatus == 2){
						var html = '<a href="#" class="a_descarga" nidcorte="'+nIdCorte+'" title="Haga clic para Generar la Póliza" style="display:block;"><i class="fa fa-circle" style="color:'+sColorEstatus+'"></i> <label style="font-size:9px;">' + sNombreEstatus + '</label></a>';
					}
					else if(nIdEstatus == 3){
						var html = '<a href="#" class="a_descarga_poliza" nidpoliza="'+nIdPoliza+'" title="Haga clic para Descargar la Póliza" style="display:block;"><i class="fa fa-circle" style="color:'+sColorEstatus+'"></i> <label style="font-size:9px;">' + sNombreEstatus + '</label></a>';
					}
					else{
						var html = '<i class="fa fa-circle" style="color:'+sColorEstatus+'"></i> <label style="font-size:9px;">' + sNombreEstatus + '</label>';
					}

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

			$('.a_seleccionar').unbind('change');
			$('.a_seleccionar').on('change', function(e){
				e.preventDefault();
				calcularImporte();
			});

			$('.a_descarga').unbind('click');
			$('.a_descarga').on('click', function(e){
				e.preventDefault();
				var nIdCorte = $(e.target).attr('nidcorte');

				if(e.target.tagName == 'LABEL'){
					var a			= $(e.target).parent();
					var nIdCorte	= $(a).attr('nidcorte');
				}
				crearPoliza(nIdCorte);
			});

			$('.a_descarga_poliza').unbind('click');
			$('.a_descarga_poliza').on('click', function(e){
				e.preventDefault();
				var nIdPoliza = $(e.target).attr('nidpoliza');

				if(e.target.tagName == 'LABEL'){
					var a			= $(e.target).parent();
					var nIdPoliza	= $(a).attr('nidpoliza');
				}
				descargarPoliza(nIdPoliza);
			});

			bindClickTable();
		},
		"fnServerParams" : function (aoData){
			var params = $('form[name=formFiltros]').getSimpleParams();
			$.each(params, function(index, val){
				aoData.push({name : index, value : val });
			});
		},
	});
} // cargarListaAlertas

function calcularImporte(){
	var els					= $('.a_seleccionar:checked');
	var length				= els.length;
	var importeTotal		= 0;
	var array_proveedores	= new Array();
	var bShowMsg			= false;

	for(var index=0; index < length; index++){
		var el		= els[index];
		var importe	= $(el).attr('nimportecomision');

		var nIdProveedor = $(el).attr('nidproveedor');

		if(array_proveedores.length == 0){
			array_proveedores.push(nIdProveedor);
		}

		var found = array_proveedores.indexOf(nIdProveedor);

		if(found < 0){
			bShowMsg = true;
		}

		importeTotal += parseFloat(importe);
	}

	$('#td_total').html("$ " + importeTotal);

	if(bShowMsg){
		jAlert('Ha seleccionado Cortes de Proveedores Diferentes', 'Mensaje');
	}

	$('#btnFactura').prop('disabled', bShowMsg);
}// calcularImporte

function bindClickTable(){
	$('#tblGridBox').unbind('click');
	$('#tblGridBox').on('click', 'tr', function(e){

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
} // bindClicTable

function subirFactura(){
	var els = $('.a_seleccionar:checked');

	if(els.length == 0){
		jAlert('Seleccione por lo menos un Corte', 'Mensaje');
		return false;
	}

	var sNombreArchivo = $('#sFileFactura').val();

	var archivoExtension = $('#sFileFactura').val().split('.').pop().toLowerCase();
	if(archivoExtension != "xml"){
		jAlert("Solo esta permitido archivos con extensión .XML", 'Mensaje');
		$('#sFileFactura').replaceWith($('#sFileFactura').clone( true ) );
	}

	var nIdProveedor = $(els[0]).attr('nidproveedor');

	var formData = new FormData();
	formData.append('sFileFactura', $('#sFileFactura').prop('files')[0]);
	formData.append('nIdProveedor', nIdProveedor);

	var length = els.length;

	for(var index=0; index < length; index++){
		var el = els[index];

		formData.append('nIdCorte[]', $(el).attr('nidcorte'));
	}

	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/comisiones/cobro/XMLSubir.php',
		type		: 'POST',
		data		: formData,
		mimeType	:"multipart/form-data",
		contentType	: false,
		cache		: false,
		processData	: false,
		dataType	: 'json'
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje);
		}

		$('#sFileFactura').replaceWith($('#sFileFactura').clone(true));
		cargarListaCortesComision();

		$('#modal-subirFactura').modal('hide');
	})
	.fail(function(){
	})
	.always(function(){
	});
} // subirFactura

function crearPoliza(nIdCorte){
	console.log(nIdCorte);
	$('#modal-poliza').modal('show');
	$('form[name=formPolizaIngresos] :input[name=nIdCorte]').val(nIdCorte);
} // crearPoliza

function generarPoliza(){
	var nIdCorte = $('form[name=formPolizaIngresos] :input[name=nIdCorte]').val();

	var params = $('form[name=formPolizaIngresos]').getSimpleParams();

	if(params.sFolio == undefined || params.sFolio == ''){
		jAlert('Capture Folio', 'Mensaje');
		return false;
	}

	params.dFecha = $('form[name=formPolizaIngresos] :input[name=dFecha]').val();

	if(params.dFecha == undefined || params.dFecha == ''){
		jAlert('Seleccione Fecha', 'Mensaje');
		return false;
	}

	if(params.sConcepto == undefined || params.sConcepto == ''){
		jAlert('Capture Concepto', 'Mensaje');
		return false;
	}
	params.sConcepto = $('form[name=formPolizaIngresos] :input[name=sConcepto]').val();

	$('#btnGeneraPoliza').prop('disabled', true);
	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/poliza/generaPoliza.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		jAlert(resp.sMensaje, 'Mensaje');

		$('#modal-poliza :input[name=sFolio]').val('');
		$('#modal-poliza :input[name=dFecha]').val('');
		$('#modal-poliza :input[name=sConcepto]').val('');
		$('#modal-poliza').modal('hide');


		if(resp.nCodigo == 0){
			var nIdPoliza = resp.data.nIdPoliza;
			descargarPoliza(nIdPoliza);
		}

		cargarListaCortesComision();
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		$('#btnGeneraPoliza').prop('disabled', false);
	});

} // generarPoliza

function descargarPoliza(nIdPoliza){
	if($('#download_poliza').length == 0){
		$('body').append('<form id="download_poliza"></form>');
		$('#download_poliza').attr("action", BASE_PATH+"/misuerte/ajax/poliza/descargaPoliza.php") .attr("method","post")
		.append('<input type="hidden" name="nIdPoliza" value="'+nIdPoliza+'">');
	}
	else{
		$('#download_poliza :input[name=nIdPoliza]').val(nIdPoliza);
	}

	$('#download_poliza').submit();
}