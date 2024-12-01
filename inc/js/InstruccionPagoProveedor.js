
function initInstruccionPagoProveedor(){

	$("#txtNumCuenta").numeric({
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false,
		maxDigits           : 11
	});

	cargarStore(BASE_PATH + "/inc/Ajax/stores/storeProveedores.php", "cmbProveedor", {}, {value : 'idProveedor', text : 'nombreProveedor'}, {}, '');
	cargarStore(BASE_PATH + "/inc/Ajax/stores/storeEstatusData_contable.php", "cmbEstatus", {}, {value : 'idEstatus', text : 'descEstatus'}, {}, '');

	$("[name='fechaInicio'], [name='fechaFinal']").prop("maxlength", 10);
	$("[name='fechaInicio'], [name='fechaFinal']").datepicker({format: 'yyyy-mm-dd'});

	$("#cmbProveedor").on('change', function(){
		ClearRes();
	});
	
	$('#txtFechaInicio').on('changeDate', function(ev){
		$(this).datepicker('hide');	
	});
	
	$('#txtFechaFinal').on('changeDate', function(ev){
		$(this).datepicker('hide');	
	});

	/*$('body').on('tablaLlena', function(event){
		$('#gridbox').find('tr').each(function(){
			$(this).find('td').eq(3).addClass("align-right");
			$(this).find('td').eq(4).addClass("align-right");
			$(this).find('td').eq(5).addClass("align-right");
		});
	});*/
}

function BuscarInstruccionesProveedor(){

	var params = getParams($("#formFiltros").serialize());

	if(params.fechaInicio != undefined && params.fechaInicio != "" && !isDate(params.fechaInicio)){
		alert("Seleccione una Fecha de Inicio Válida");return false;
	}

	if(params.fechaFinal != undefined && params.fechaFinal != "" && !isDate(params.fechaFinal)){
		alert("Seleccione una Fecha Final Válida");return false;
	}

	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Id Inst.</th><th>Proveedor</th><th>Cuenta</th><th>Fecha</th><th align="center">Importe</th><th>IVA</th><th>Total</th><th>Descripción</th><th>Estatus</th><th>Acciones</th></tr></thead><tbody></tbody></table>');
	$('#botones_excel').show();
	$('#gridbox').show();

	var parametros = getParams($("form").serialize());

	var customsettings = {
		aoColumnDefs: [
			{ sClass	: 'align-right', aTargets: [0,4,5,6] },
			{ bSortable	: false, aTargets: [9] }
		]
	}

	llenarDataTable('tblGridBox', parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/InstruccionesProveedor/BuscarInstruccionesProveedor.php", customsettings);
}

function resetInstruccion(idInstruccion){
	if(confirm("\u00BFDesea Reestablecer la Instrucción\u003F")){
		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/InstruccionesProveedor/reestablecerInstruccion.php',
			{
				idInstruccion : idInstruccion
			}
			,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				if(response.success == true){
					BuscarInstruccionesProveedor();
				}
			},
			"json"
		);
	}
}

function ClearRes(){
	$("#botones_excel").fadeOut('400');
	$("#gridbox").fadeOut('400').empty();
}


