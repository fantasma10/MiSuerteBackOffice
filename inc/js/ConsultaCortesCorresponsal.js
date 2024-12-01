
function initConsultaCortesCorresponsal(){
	var urlCat = BASE_PATH + '/inc/Ajax/_Clientes/getListaCategoria.php';
	//AutoCompletar Cadena
	if($('#idCadena').length && $('#txtCadena').length){
		autoCompletaGeneral('txtCadena', 'idCadena', urlCat, 'nombreCadena', 'idCadena', {categoria : 1}, renderItemCadena);
	}

	if($('#idCadena').length && $('#txtCadenaCor').length){
		autoCompletaGeneral('txtCadenaCor', 'idCadena', urlCat, 'nombreCadena', 'idCadena', {categoria : 1}, renderItemCadena);
	}
	//AutoCompletar SubCadena
	if($('#idSubCadena').length && $('#txtSubCadena').length){
		
		$("#txtSubCadena").keyup(function(){
			var cadena = $("#idCadena").val();
			autoCompletaGeneral('txtSubCadena', 'idSubCadena', urlCat, 'nombreSubCadena', 'idSubCadena', {categoria : 2, idCadena : cadena}, renderItemSubCadena);
		});
		$("#txtSubCadena").keypress(function(){
			var cadena = $("#idCadena").val();
			autoCompletaGeneral('txtSubCadena', 'idSubCadena', urlCat, 'nombreSubCadena', 'idSubCadena', {categoria : 2, idCadena : cadena}, renderItemSubCadena);
		});
	}
	//AutoCompletar Corresponsal
	if($("#txtCorresponsal").length){
		$("#txtCorresponsal").keypress(function(){
			var cadena		= $("#idCadena").val();
			var subcadena	= $("#idSubCadena").val();
			var parametros	= {categoria : 3, idCadena : cadena, idSubCadena : subcadena}

			autoCompletaGeneral('txtCorresponsal', 'idCorresponsal', urlCat, 'nombreCorresponsal', 'idCorresponsal', parametros, renderItemCorresponsal);
		});
	}

	// LLenar combo de Meses
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeMeses.php', 'ddlMes', {}, {text : 'descMes', value : 'idMes'});
	// LLenar combo de Años
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeAniosCortes.php', 'ddlAnio', {tipoCorte : 1}, {text : 'anio', value : 'anio'});
	//Lenar combo de EStatus
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeEstatusData_Contable.php', 'ddlEstatus', {}, {text : 'descEstatus', value : 'idEstatus'});

	$("#txtCadena, #txtSubCadena, #txtCorresponsal").keyup(function(e){
		var targ	= e.target;
		var id		= targ.id;
		var tip 	= id.substring(0, 3);
		var last	= id.substring(3, id.length);

		var val = $("#"+id).val();
		var valor = val.trim();

		var arr = {'txt' : 'id'};

		if(valor == ""){
			$("#" +arr[tip] + last).val(-1);
		}
	});

	$(":input").bind("paste", _denegar);
	$("#gridbox").delegate("input", "paste", _denegar);

	$('body').on('tablaLlena', function(ev, oT){
		dataTableObj.fnSettings().aoColumns[4].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[5].sClass = 'align-right';
	});


	$('body').delegate('.check', 'click', seleccionarFacturas);

	/*$('#gridbox').delegate('#tblGridBox tbody tr td', 'click',  function(){
		var table = $('#tblGridBox').DataTable();
		$(this).toggleClass('selected');
	});*/

	$('#gridbox').delegate('#tblGridBox tbody tr', 'click',  function(){
		if(event.target.type != 'checkbox'){
			var rowIndex = dataTableObj.fnGetPosition(this);
			var checkBox = $(".check[row='" + rowIndex + "']").trigger('click');
		}
	});
	
	$("body").on('cargarTabla', function(){
		Emergente();
	});
	
	$("body").on('tablaLlena', function(){
		SELECCIONAR_CHECKBOX = true;
		OcultarEmergente();
	});
	
}

function _denegar(e){
	e.preventDefault();
	return false;
}

function renderItemCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "</a>" )
	.appendTo( ul );
}

function renderItemSubCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "<br>" + item.nombreCadena +"</a>" )
	.appendTo( ul );
}

function renderItemCorresponsal( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label +"</a>" )
	.appendTo( ul );
}

function BuscarCorteClientes(){
	var p = $('#formCorteCorresponsal').serialize();
	var params = getParams(p);

	$('#botones_excel').show();
	$('#gridbox').empty().html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><th>Elige</th><th>Pago</th><th>Cadena</th><th>SubCadena</th><th>Corresponsal</th><th>N&uacute;mero de Cuenta</th><th>Cuenta Contable</th><th>Instrucci&oacute;n</th><th>IVA</th><th>Importe Total</th><th>Total de Ventas</th><th>Factura</th><th>Estatus</th></thead><tbody><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tbody></table>').show();

	dataTableObj = $("#tblGridBox").dataTable({
		"iDisplayLength"	: 10,
		"aLengthMenu"		: [[10, 25, 50, 100, 300], [10, 25, 50, 100, 300]],
		"bProcessing"		: false,
		"bServerSide"		: true,
		"sAjaxSource"		: BASE_PATH + '/inc/Ajax/_Contabilidad/BuscaPagoCorresponsal.php',
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se ha encontrado nada",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)"
		},
		"fnPreDrawCallback"	: function() {
			$('body').trigger('cargarTabla');
		},
		"fnDrawCallback": function ( oSettings ) {			
			dataTableObj.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});

			dataTableObj.$('i').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			
			$('body').trigger('tablaLlena');
		},
		"fnServerParams" : function (aoData){
			$.each(params, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});
}

function descargaExcel(todo){
	var url = BASE_PATH + '/inc/Ajax/_Contabilidad/CortesComisionesExcel.php';
	showExcelCommon(todo, url);
}

function AbrirDetalleDeFactura(tipoDocumento, numeroCuenta, noFactura){
	
	var url = BASE_PATH + "/_Contabilidad/FacturasRecibos/Consulta.php?tipoDocumento="+tipoDocumento+"&numeroCuenta="+numeroCuenta+"&noFactura="+noFactura;
	cargarContenidoHtml(url, 'divTbl', '');
}

function seleccionar(){
	var el = event.target;

	var at = getAttrs(el);

	var numCuenta = at.numcuenta;

	//var disabled = $(".check[numcuenta='"+numCuenta+"']").is(':checked');

	//$(".check[numcuenta!='"+ numCuenta +"']").prop('disabled', disabled);
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
		cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaAsignarClientes.php', 'divTbl', 'initComponentsAsignarFacturas()');
		$("#SectionModal").modal();
	}
	else{
		alert("Debe seleccionar por lo menos un corte");
	}
}