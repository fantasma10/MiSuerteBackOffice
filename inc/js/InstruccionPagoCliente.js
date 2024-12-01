
function initInstruccionPagoCliente(){

	$("#txtNumCuenta").numeric({
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false,
		maxDigits           : 11
	});

	$("#txtCliente").on('itemselected', function(){
		ClearRes();
	});

	autoCompletaGeneral("txtCliente", "idCliente", BASE_PATH + "/inc/Ajax/_Clientes/getClientes.php", "nombre", "idCliente", {}, renderItemCliente);
	cargarStore(BASE_PATH + "/inc/Ajax/stores/storeEstatusData_contable.php", "cmbEstatus", {}, {value : 'idEstatus', text : 'descEstatus'}, {}, '');

	$("[name='fechaInicio'], [name='fechaFinal']").prop("maxlength", 10);
	$("[name='fechaInicio'], [name='fechaFinal']").datepicker({format: 'yyyy-mm-dd'});

	$("#txtCliente").on('keyup', function(event){
		var str = $(this).val();

		if(str == undefined || myTrim(str) == ""){
			$("#idCliente").val(0);
		}
	});
	
	$('#txtFechaInicio').on('changeDate', function(ev){
		$(this).datepicker('hide');	
	});
	
	$('#txtFechaFinal').on('changeDate', function(ev){
		$(this).datepicker('hide');	
	});
	
	$("body").on('cargarTabla', function(){
		//alert("TEST cargarTabla");
		Emergente();
	});
	
	$("body").on('tablaLlena', function(){
		//alert("TEST tablaLlena");
		OcultarEmergente();
	});	

}

function renderItemCliente( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.idCliente + " : " + item.nombre + "</a>" )
	.appendTo( ul );
}

function BuscarInstruccionesCliente(){

	var params = getParams($("#formFiltros").serialize());

	if(params.fechaInicio != undefined && params.fechaInicio != "" && !isDate(params.fechaInicio)){
		alert("Seleccione una Fecha de Inicio Válida");return false;
	}

	if(params.fechaFinal != undefined && params.fechaFinal != "" && !isDate(params.fechaFinal)){
		alert("Seleccione una Fecha Final Válida");return false;
	}

	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Id Inst.</th><th>Pago</th><th>Cliente</th><th>Cuenta</th><th>Cuenta Contable</th><th>Instrucción</th><th>Fecha</th><th>IVA</th><th>Importe</th><th>Descripción</th><th>Estatus</th><th>Acciones</th></tr></thead><tbody></tbody></table>');
	$('#botones_excel').show();
	$('#gridbox').show();

	var parametros = getParams($("form").serialize());

	var customsettings = {
		aoColumnDefs: [
			{ sClass	: 'align-right', aTargets: [0, 5] }/*,
			{ bSortable	: false, aTargets: [9] }*/
		]
	}

	llenarDataTable('tblGridBox', parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/InstruccionesProveedor/BuscarInstruccionesCliente.php", customsettings);
}

function resetInstruccion(idInstruccion){
	if(confirm("\u00BFDesea Reestablecer la Instrucción\u003F")){
		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/InstruccionesProveedor/reestablecerInstruccionCliente.php',
			{
				idInstruccion : idInstruccion
			}
			,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				if(response.success == true){
					BuscarInstruccionesCliente();
				}
			},
			"json"
		);
	}
}

function ClearRes(){
	$("#gridbox").fadeOut('1000').empty();
}
function descargaExcel(todo){

	var url = BASE_PATH + '/inc/Ajax/_Contabilidad/InstruccionesClienteExcel.php';
	showExcelCommon(todo, url, '#formFiltros');
}