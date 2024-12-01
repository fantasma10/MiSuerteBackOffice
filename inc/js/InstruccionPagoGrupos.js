
function initInstruccionPagoGrupo(){

	$("#txtNumCuenta").numeric({
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false,
		maxDigits           : 11
	});

	cargarStore(BASE_PATH + "/inc/Ajax/stores/storeGrupos.php", "cmbGrupo", {}, {value : 'idGrupo', text : 'nombreGrupo'}, {}, '');
	cargarStore(BASE_PATH + "/inc/Ajax/stores/storeEstatusData_contable.php", "cmbEstatus", {}, {value : 'idEstatus', text : 'descEstatus'}, {}, '');

	$("[name='fechaInicio'], [name='fechaFinal']").prop("maxlength", 10);
	$("[name='fechaInicio'], [name='fechaFinal']").datepicker({format: 'yyyy-mm-dd'});

	$("#cmbAcreedor").on('change', function(){
		ClearRes();
	});

	$('body').on('tablaLlena', function(event){
		$('#tblGridBox').find('tbody>tr').each(function(index, item){
			$(item).find('td').eq(3).addClass("align-right");
			$(item).find('td').eq(4).addClass("align-right");
			$(item).find('td').eq(5).addClass("align-right");
		});
	});
	
	$('#txtFechaInicio').on('changeDate', function(ev){
		$(this).datepicker('hide');
	});
	
	$('#txtFechaFinal').on('changeDate', function(ev){
		$(this).datepicker('hide');
	});
	
}

function BuscarInstrucciones(){

	var params = getParams($("#formFiltros").serialize());

	if(params.fechaInicio != undefined && params.fechaInicio != "" && !isDate(params.fechaInicio)){
		alert("Seleccione una Fecha de Inicio Válida");return false;
	}

	if(params.fechaFinal != undefined && params.fechaFinal != "" && !isDate(params.fechaFinal)){
		alert("Seleccione una Fecha Final Válida");return false;
	}

	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Id Inst.</th><th>Grupo</th><th>Cuenta</th><th>Fecha</th><th>Importe</th><th>IVA</th><th>Total</th><th>Descripción</th><th>Estatus</th><th>Acciones</th></tr></thead><tbody></tbody></table>');
	$('#botones_excel').show();
	$('#gridbox').show();

	var parametros = getParams($("form").serialize());

	var customsettings = {
		aoColumnDefs: [
			{ sClass	: 'align-right', aTargets: [0,4,5,6] }
		]
	}

	llenarDataTable('tblGridBox', parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/InstruccionesProveedor/BuscarInstruccionesGrupo.php", customsettings);
}

function resetInstruccion(idInstruccion){
	if(confirm("\u00BFDesea Reestablecer la Instrucción\u003F")){
		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/InstruccionesProveedor/reestablecerInstruccionGrupo.php',
			{
				idInstruccion : idInstruccion
			}
			,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				if(response.success == true){
					BuscarInstrucciones();
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