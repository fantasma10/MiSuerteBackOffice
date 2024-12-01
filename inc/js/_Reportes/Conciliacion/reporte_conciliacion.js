function initReporteConciliacion(){
	initFiltros();
}

function initFiltros(){
	$('form[name=formFiltros] :input[name=dFechaInicio]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('form[name=formFiltros] :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});

	$('#btnBuscar').on('click', function(e){
		buscarDatos();
	});
}

function buscarDatos(){
	var dFechaInicio	= document.formFiltros.dFechaInicio.value;
	var dFechaFinal		= document.formFiltros.dFechaFinal.value;

	var dif = restaFechas(dFechaInicio, dFechaFinal);

	if(dif < 0){
		jAlert('La Fecha Final debe ser mayor o igual a la Fecha Inicial');
		return false;
	}

	if(dif > 31){
		jAlert('Solamente se pueden realizar búsquedas de máximo 31 días');
		return false;
	}

	showSpinner();
	$.ajax({
		url		: BASE_PATH + '/inc/ajax/_Reportes/Conciliacion/reporte_conciliacion.php',
		type	: 'POST',
		dataType: 'json',
		data	: {
			dFechaInicio	: dFechaInicio,
			dFechaFinal		: dFechaFinal
		}
	})
	.done(function(resp){
		console.log(resp);
		if(resp.bExito == true){
			document.getElementById('label-cuenta-banco').innerHTML		= "# " + resp.data.banco.nCuenta;
			document.getElementById('label-monto-banco').innerHTML		= "$ " + resp.data.banco.nImporte;
			document.getElementById('label-cuenta-movs').innerHTML		= "# " + resp.data.forelo.nCuenta;
			document.getElementById('label-importe-movs').innerHTML		= "$ " + resp.data.forelo.nImporte;
			document.getElementById('label-cuenta-dif').innerHTML		= "# " + resp.data.diferencia.nCuenta;
			document.getElementById('label-importe-dif').innerHTML		= "$ " + resp.data.diferencia.nImporte;
			document.getElementById('label-importe-dif').innerHTML		= "$ " + resp.data.diferencia.nImporte;
			
			document.getElementById('label-forelo-detalle').style.display = 'inline';
			document.getElementById('label-banco-pendiente-detalle').style.display = 'inline';

			var html = "<table border='0'><thead><th>Mes</th><th>#</th><th>$</th></thead>";
			var forelo_detalle = resp.data.forelo_detalle;

			for(var i=0; i < forelo_detalle.length; i++){
				var el = forelo_detalle[i];
				console.log(typeof(el.mes), el.mes);

				var mes = (typeof(el.mes) != 'string')? '&nbsp;' : el.mes;

				html += "<tr>";
				html += "<td align='center'>" + mes + "</td>";
				html += "<td align='right'>" + el.nCuenta + "</td>";
				html += "<td align='right'>$" + el.nImporte + "</td>";
				html += "</tr>";
			}

			html += "</table>";

			$('#div-resumen-forelo').html(html);
		}
	})
	.fail(function(){
		console.log("error");
	})
	.always(function(){
		hideSpinner();
	});
	
} // buscarDatos


function customToggleDiv(){
	$('#div-resumen-forelo').toggle();
	$('#span-mas').toggle();
	$('#span-menos').toggle();
} // customToggleDiv

function mostrarModalMovimientos(){
	cargarMovimientos();
	$('#modal-lista-movimientos').modal('show');
} // mostrarModalMovimientos

function cargarMovimientos(){
	showSpinner();
	$.ajax({
		url			: BASE_PATH + '/inc/Ajax/_Contabilidad/Tablero/cargarBancoMovs.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			dFechaInicio		: document.formFiltros.dFechaInicio.value,
			dFechaFinal			: document.formFiltros.dFechaFinal.value,
			nPerfil				: 1,
			nArrayListaEstatus	: ['1'],
			dFechaFiltro		: 2,
			nIdCfg				: 0,
			nIdEstatus			: 1
		}
	})
	.done(function(resp){
		console.log(resp);
		if(resp.bExito == false || resp.nCodigo != 0){
			jAlert(resp.sMensaje);
		}
		else{
			var table = armarTablaBanco(resp.data, resp.nTotal);

			$('#div-mostrar-tabla').html(table);
		}
	})
	.fail(function(){
	})
	.always(function(){
		hideSpinner();
	});
}

function armarTablaBanco(data, nTotal){


	var table = '<table style="margin:0 auto;font-size:12px;" class="table-bordered table-striped table-condensed mt5 id="tbl-banco">';
	table += '<thead>';
	table += '<th>#</th>';
	table += '<th>Banco</th>';
	table += '<th>Cuenta</th>';
	table += '<th>Fecha</th>';
	table += '<th>Referencia</th>';
	table += '<th>Autorizaci&oacute;n</th>';
	table += '<th>Abono</th>';
	table += '</thead>';
	table += '<tbody>';

	for(var i=0; i<nTotal; i++){
		var nNum = i+1;
		table += '<tr>';
		table += '<td>'+nNum+'</td>';
		table += '<td>'+data[i].sNombreBanco+'</td>';
		table += '<td>'+data[i].nNumCuenta+'</td>';
		table += '<td>'+data[i].fecBanco+'</td>';
		table += '<td>'+data[i].referencia+'</td>';
		table += '<td class="td-cell-autorizacion">'+data[i].autorizacion+'</td>';
		table += '<td class="class-currency" align="right">'+data[i].nAbonoFormato+'</td>';
		table += '</td>';
		table += '</tr>';
	}

	table += '</tbody>';
	table += '</table>';

	return table;
}