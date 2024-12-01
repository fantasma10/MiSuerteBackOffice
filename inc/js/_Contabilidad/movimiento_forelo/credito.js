function initViewCredito(){
	initFiltros();
	initFiltrosConsultaCredito();
	initModalMovimientosBanco();
} // initViewCredito

function initFiltrosConsultaCredito(){
	$('#frmMovimientosCredito :input[name=dFechaInicio]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('#frmMovimientosCredito :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('#btnBuscar').on('click', function(e){
		buscarMovimientosCredito();
	});
} // initFiltrosConsultaCredito

function initModalMovimientosBanco(){
	$('form[name=filtrosCfg] :input[name=nIdCfg]').customLoadStore({
		url				: BASE_PATH + '/inc/ajax/_Contabilidad/Tablero/listaCfgCuentas.php',
		labelField		: 'sCuentaMap',
		idField			: 'nIdCfg',
		firstItemId		: '-2',
		firstItemValue	: 'Seleccione Cuenta'
	});

	$('form[name=filtrosCfg] :input[name=dFechaInicio], form[name=filtrosCfg] :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});

	var hoy = fnHoy();

	$('form[name=filtrosCfg] :input[name=dFechaInicio], form[name=filtrosCfg] :input[name=dFechaFinal]').val(hoy);

	$('#btnFiltros').on('click', function(e){
		buscaMovimientosBanco();
	});

	$('#btnSeleccionMovimiento').on('click', function(e){
		cobrarPorDeposito();
	});
} // initModalMovimientosBanco

function buscaMovimientosBanco(){
	var params = $('form[name=filtrosCfg]').getSimpleParams();

	var dFechaInicio	= params.dFechaInicio;
	var dFechaFinal		= params.dFechaFinal;

	var arrFI = dFechaInicio.split('-');
	var arrFF = dFechaFinal.split('-');

	var nDFechaInicio	= new Date(arrFI[0], arrFI[1]-1, arrFI[2]);
	var nDFechaFinal	= new Date(arrFF[0], arrFF[1]-1, arrFF[2]);

	if(nDFechaInicio > nDFechaFinal){
		jAlert('La Fecha Inicio debe ser menor a la Fecha Final');
		return;
	}

	var arrayListaEstatus = new Array();
	arrayListaEstatus.push(1);

	params.nArrayListaEstatus = arrayListaEstatus;

	if($('form[name=filtrosCfg] :input[name=dFechaFiltro]').length >0 ){
		params.dFechaFiltro = $('form[name=filtrosCfg] :input[name=dFechaFiltro]:checked')[0].value;
	}

	params.dFechaFiltro = 2;

	ajaxBuscaBancoMovs(params);
}

function ajaxBuscaBancoMovs(params){
	params.nPerfil = 1;
	showSpinner();
	$.ajax({
		url			: '/inc/Ajax/_Contabilidad/Tablero/cargarBancoMovs.php',
		type		: 'POST',
		dataType	: 'json',
		data		: params
	})
	.done(function(resp){
		console.log(resp);
		if(resp.bExito == false || resp.nCodigo != 0){
			jAlert(resp.sMensaje);
		}
		else{
			var table = armarTablaBanco(resp.data, resp.nTotal);

			$('#tbl-banco').replaceWith(table).promise().done(function(elem){
				bindClickToTable();
				bindChangeToCheckbox();
			});
		}
	})
	.fail(function(){
	})
	.always(function(){
		hideSpinner();
	});
} // ajaxBuscaBancoMovs

function armarTablaBanco(data, nTotal){

	var nIdCfg = $('#formFiltrosCfg :input[name=nIdCfg]').val();

	var table = '<table class="display table table-bordered" id="tbl-banco">';
	table += '<thead>';
	table += '<th></th>';
	if(nIdCfg <= 0){
		table += '<th>Banco</th>';
		table += '<th>Cuenta</th>';
	}
	table += '<th>Fecha</th>';
	table += '<th>Referencia</th>';
	table += '<th>Autorizaci&oacute;n</th>';
	table += '<th>Abono</th>';
	table += '<th>Estatus</th>';
	table += '</thead>';
	table += '<tbody>';

	for(var i=0; i<nTotal; i++){
		var elemento = data[i];

		var bgcolor = "";
		if(elemento.idEstatus == 1){
			bgcolor = "#e5aaaa";
		}
		else if(elemento.idEstatus == 2){
			bgcolor = "#e6ad00";
		}

		table += '<tr style="background-color:'+bgcolor+'">';
		table += '<td><input type="checkbox" name="nIdMovBanco" value="'+data[i].idMovBanco+'" nAutorizacion="'+data[i].autorizacion+'" nIdDeposito="'+data[i].nIdDeposito+'" nIdEstatus="'+data[i].idEstatus+'" nIdBanco="'+data[i].idBanco+'" nImporte="'+data[i].nAbono+'" sfecha="'+data[i].fecBanco+'"></td>';
		if(nIdCfg <= 0){
			table += '<td>'+data[i].sNombreBanco+'</td>';
			table += '<td>'+data[i].nNumCuenta+'</td>';
		}
		table += '<td>'+data[i].fecBanco+'</td>';
		table += '<td>'+data[i].referencia+'</td>';
		table += '<td>'+data[i].autorizacion+'</td>';

		table += '<td class="class-currency" align="right">'+data[i].nAbonoFormato+'</td>';
		table += '<td>'+data[i].sNombreEstatus+'</td>';
		table += '</tr>';
	}

	table += '</tbody>';
	table += '</table>';

	return table;
} // armarTablaBanco

function buscarMovimientosCredito(){

	var params = $('#frmMovimientosCredito').getSimpleParams();

	var nNumCuenta = $('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').val();

	if(params.dFechaInicio == undefined || params.dFechaInicio == ''){
		jAlert('Seleccione Fecha de Inicio', 'Mensaje');
		return false;
	}

	if(params.dFechaFinal == undefined || params.dFechaFinal == ''){
		jAlert('Seleccione Fecha de Final', 'Mensaje');
		return false;
	}

	showSpinner();

	$('#gridbox').html('<table id="tbl-movimientos" class="display table table-bordered"><thead><tr><th>Dueño</th><th>Cuenta</th><th>Fecha</th><th>Fecha<br/>de Cobro</th><th>Cobro<br/>Real</th><th style="text-align:left;!important">Abono</th><th>Descripci&oacute;n</th><th>Usuario</th><th>Modo</th><th>Usuario Cobro</th><th>Estatus</th></tr></thead><tbody></tbody></table>');

	var dataTableObj = $('#tbl-movimientos').dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: false,
		"bServerSide"		: true,
		"bFilter"			: false,
		"sAjaxSource"		: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/tblMovimientosCredito.php',
		"sServerMethod"		: 'POST',
		"aaSorting"			: [[0, 'desc']],
		"oLanguage"			: {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se ha encontrado nada",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
			"sProcessing"		: "Cargando"
		},
		"aoColumnDefs"		: [
			{
				"mData"		: 'sOwner',
				'aTargets'	: [0],
				"mRender"	: function(data, type, row){
					var sOwner		= data;
					var arrOwner	= sOwner.split(':');
					var string		= '<b>' + arrOwner[0] + '</b><br/>' + arrOwner[1];

					return string;
				}
			},
			{
				"mData"		: 'numCuenta',
				'aTargets'	: [1]
			},
			{
				"mData"		: 'fecAppMovDate',
				'aTargets'	: [2]
			},
			{
				"mData"		: 'dFecCobro',
				'aTargets'	: [3],
				"mRender"	: function(data, type, row){
					return "<b>"+data+"</b>";
				}
			},
			{
				"mData"		: 'dFecCobroReal',
				'aTargets'	: [4]
			},
			{
				"mData"		: 'abonoMov',
				'aTargets'	: [5],
				'sClass'	: 'align-right'
			},
			{
				"mData"		: 'descMovimiento',
				'aTargets'	: [6],
			},
			{
				"mData"		: 'sNombreUsuarioRegistro',
				'aTargets'	: [7],
			},
			{
				"mData"		: 'sNombre',
				'aTargets'	: [8],
			},
			{
				"mData"		: 'sNombreUsuarioCobro',
				'aTargets'	: [9],
			},
			{
				"mData"		: 'nIdEstatus',
				'aTargets'	: [10],
				"mRender"	: function(data, type, row){
					if(row.nIdEstatus == 0){
						return "Cobrado";
					}
					else if(row.nIdEstatus == 1){
						var sOwner		= row.sOwner;
						var arrOwner	= sOwner.split(':');
						var string		= '<b>' + arrOwner[0] + '</b><br/>' + arrOwner[1];

						if(bES_ESCRITURA){
							return "<a href='#' class='mov-cobrar_credito' title='Haga clic para realizar el Cobro' fecAppMovDate='"+row.fecAppMovDate+"' numCuenta='"+row.numCuenta+"' sowner='"+string+"' nAbonoFormato='"+row.abonoMov+"' nAbono='"+row.nAbono+"' nIdMovimiento='"+row.nIdMovimiento+"' nIdTipoCobro='"+row.nIdTipoCobro+"'>Pendiente</a>";
						}
						else{
							return "Pendiente";
						}
					}
					else{
						return "";
					}
				}
			}
		],
		"fnPreDrawCallback"	: function() {
			showSpinner();
		},
		"fnDrawCallback": function ( oSettings ) {
			hideSpinner();
			var data	= oSettings.aoData;
			var length	= data.length;

			if(length > 0){
				for(var i=0; i<length;i++){
					var row			= data[i]._aData;
					var sHexColor	= '';

					if(row.nIdEstatus != 0){
						if(row.nDiasCobro == 0){
							sHexColor = '#FFFF9A'
						}
						else if(row.nDiasCobro > 0){
							sHexColor = '#FF9A9A';
						}
						else if(row.nDiasCobro < 0){
							sHexColor = '#9AFFFF';
						}
						$($('#tbl-movimientos tbody tr').get(i)).css('background-color', sHexColor);
					}
				}
			}

			$('.mov-cobrar_credito').on('click', function(e){
				cobraCredito(e);
			});
		},
		"fnServerParams" : function (aoData){
			var params = $('#frmMovimientosCredito').getSimpleParams();
			params.nNumCuenta = $('form[name=formFiltrosCuenta] :input[name=nNumCuenta]').val();

			$.each(params, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});
} // buscarMovimientos

function cobraCredito(e){
	var target			= e.target;
	var nIdTipoCobro	= $(target).attr('nidtipocobro');
	var nAbonoFormato	= $(target).attr('nabonoformato');
	var nAbono			= $(target).attr('nabono');
	var fecAppMovDate	= $(target).attr('fecappmovdate');
	var nIdMovimiento	= $(target).attr('nidmovimiento');
	var nNumCuenta		= $(target).attr('numcuenta');

	if(nIdTipoCobro == 1){
		cobrarPorForelo(target);
	}
	else if(nIdTipoCobro == 2){
		$('#monto-a-cobrar').html(nAbonoFormato);
		$('#monto-seleccionado').html('$ 0');
		$('#txtMontoACobrar').val(nAbono);
		$('#txtFecAppMovDate').val(fecAppMovDate);
		$('#txtNIdMovimiento').val(nIdMovimiento);
		$('#txtNIdTipoCobro').val(nIdTipoCobro);
		$('#txtNNumCuenta').val(nNumCuenta);
		mostrarMovimientosBancarios();
	}
} // cobraCredito

function cobrarPorForelo(target){

	var nAbonoFormato	= $(target).attr('nabonoformato');
	var nAbono			= $(target).attr('nabono');
	var nIdMovimiento	= $(target).attr('nidmovimiento');
	var nIdTipoCobro	= $(target).attr('nidtipocobro');
	var sOwner			= $(target).attr('sowner');
	var numCuenta		= $(target).attr('numcuenta');

	var params = {
		nAbono			: nAbono,
		nIdMovimiento	: nIdMovimiento,
		nIdTipoCobro	: nIdTipoCobro,
		numCuenta		: numCuenta,
		sDescripcion	: sOwner
	}

	var hMensaje = '<span style="font-size:14px;">Se realizar\u00E1 un cargo por <b>' + nAbonoFormato + '</b> a '+sOwner+' en la cuenta '+numCuenta+'</span>';
	jConfirm(hMensaje, 'Confirmaci\u00F3n', function(confirm){
		if(confirm){
			$.ajax({
				url			: '/inc/Ajax/_Contabilidad/movimiento_forelo/creditoCargoForelo.php',
				type		: 'POST',
				dataType	: 'json',
				data		: params
			})
			.done(function(resp){
				jAlert(resp.sMensaje, 'Mensaje');

				buscarMovimientosCredito();
			})
			.fail(function(){

			})
			.always(function() {
				console.log("complete");
			});
		}
	});
} // cobrarPorForelo

function mostrarMovimientosBancarios(){
	var hoy = fnHoy();
	$('#formFiltrosCfg')[0].reset();
	$('form[name=filtrosCfg] :input[name=dFechaInicio], form[name=filtrosCfg] :input[name=dFechaFinal]').val(hoy);
	$('#tbl-banco').html('');
	$('#modal-seleccion_movimiento').modal('show');
} // mostrarMovimientosBancarios

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

			if(e.target.tagName == 'A'){
				return false;
			}

			var chk = $($(e.currentTarget).find('td')[0]).find(':checkbox');

			var checked = $(chk).prop('checked');

			$(chk).prop('checked', !checked);
			$(chk).trigger('change');
		}
	});
} // bindClickToTable

function bindChangeToCheckbox(){
	$('#tbl-banco :checkbox').unbind('change');
	$('#tbl-banco :checkbox').on('change', function(e){
		var checkboxes	= $('#tbl-banco :checkbox:checked');
		var length		= checkboxes.length;
		var nImporte	= 0;
		for(var i=0; i<length; i++){
			var check = checkboxes[i];
			nImporte += eval($(check).attr('nimporte'));
		}
		$('#monto-seleccionado').html('$ ' + nImporte);
		$('#monto-seleccionado').mask('$ 000,000,000.000');
	});
} // bindChangeToCheckbox

function cobrarPorDeposito(){
	var checkboxes	= $('#tbl-banco :checkbox:checked');
	var length		= checkboxes.length;
	var nImporte	= 0;

	if(length == 0){
		jAlert('Seleccione por lo menos un Movimiento', 'Mensaje');
		return false;
	}

	var arrayMovimientos	= new Array();
	var arrayFechas			= new Array();

	for(var i=0; i<length; i++){
		var check = checkboxes[i];
		nImporte += eval($(check).attr('nimporte'));
		sFecha = $(check).attr('sfecha');

		arrayMovimientos.push($(check).val());
		arrayFechas.push(sFecha);
	}

	var nImporteCobro	= $('#txtMontoACobrar').val();
	var fecAppMovDate	= $('#txtFecAppMovDate').val();
	var nIdMovimiento	= $('#txtNIdMovimiento').val();
	var nIdTipoCobro	= $('#txtNIdTipoCobro').val();
	var nNumCuenta		= $('#txtNNumCuenta').val();

	var lengthFechas	= arrayFechas.length;
	var bFecha			= false;

	for(var i=0; i<lengthFechas; i++){
		var dFecha = arrayFechas[i];

		if(dFecha < fecAppMovDate){
			bFecha = true;
		}
	}

	if(bFecha == true){
		jAlert('La fecha del o los depósitos debe ser mayor a la fecha en que se realizó el abono', 'Mensaje');
		return;
	}

	if(nImporte != nImporteCobro){
		jAlert('El Importe seleccionado no es Igual al Importe que debe ser Cobrado', 'Mensaje');
		return false;
	}

	var params = {
		nIdMovimiento	: nIdMovimiento,
		arrMovBanco		: arrayMovimientos,
		nIdTipoCobro	: nIdTipoCobro,
		nNumCuenta		: nNumCuenta
	}

	jConfirm('\u00BFDesea Continuar?','Mensaje', function(confirm){
		if(confirm == true){
			showSpinner();
			$.ajax({
				url			: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/creditoPagoBanco.php',
				type		: 'POST',
				dataType	: 'json',
				data		: params
			})
			.done(function(resp){
				jAlert(resp.sMensaje, 'Mensaje');

				buscarMovimientosCredito();
				buscaMovimientosBanco();

				if(resp.nCodigo == 0){
					$('#monto-seleccionado').html('$ 0');
					$('#modal-seleccion_movimiento').modal('hide');
				}
			})
			.fail(function(){

			})
			.always(function(){
				hideSpinner();
			});
		}
	});
} // cobrarPorDeposito