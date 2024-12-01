function initView(){
	$('#btnFiltros').on('click', function(e){
		llenarTabla();
	});

	$('form[name=filtrosCfg] :input[name=sFolio]').alphanum({
		allow		: '1234567890-',
		maxLength	: 10
	});
	$('form[name=filtrosCfg] :input[name=dFechaInicio], form[name=filtrosCfg] :input[name=dFechaFinal]').datepicker({
		format : 'yyyy-mm-dd'
	});
}

function llenarTabla(){

	var params = $('form[name=filtrosCfg]').getSimpleParams();

	if((params.dFechaInicio != undefined && params.dFechaInicio != '') && (params.dFechaFinal == undefined || params.dFechaFinal == '')){
		jAlert('Seleccione Fecha Final', 'Mensaje');
		return false;
	}

	if((params.dFechaFinal != undefined && params.dFechaFinal != '') && (params.dFechaInicio == undefined || params.dFechaInicio == '')){
		jAlert('Seleccione Fecha Inicio', 'Mensaje');
		return false;
	}


	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Folio</th><th>Fecha</th><th>Concepto</th><th>Tipo de Póliza</th><th></th></tr></thead><tbody></tbody></table>');

	showSpinner();
	var dataTableObj = $('#tblGridBox').dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: true,
		"bServerSide"		: true,
		"sAjaxSource"		: '../../../inc/ajax/_Contabilidad/Tablero/cargarListaPolizas.php',
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
				'bSortable'	: false,
				'aTargets'	: [4]
			},
			{
				"mData"		: 'sFolio',
				'aTargets'	: [0]
			},
			{
				"mData"		: 'dFecha',
				'aTargets'	: [1]
			},
			{
				"mData"		: 'sConcepto',
				'aTargets'	: [2]
			},
			{
				"mData"		:'sNombreTipoPoliza',
				'aTargets'	: [3]
			},
			{
				"mData"		: 'nIdPoliza',
				'aTargets'	: [4],
				"fnRender"	: function(oObj){
					var nIdPoliza = oObj.aData.nIdPoliza;
					return '<a href="#" class="a_descarga_poliza" nidpoliza="'+nIdPoliza+'">' + 'Descargar' + '</a>';
				}
			}
		],
		"fnPreDrawCallback"	: function() {
			//$('body').trigger('cargarTabla');
			showSpinner();
		},
		"fnDrawCallback": function ( oSettings ) {
			hideSpinner();
			$('.a_descarga_poliza').unbind('click');
			$('.a_descarga_poliza').on('click', function(e){
				var nIdPoliza = $(e.target).attr('nidpoliza');
				descargarPoliza(nIdPoliza);
			});
		},
		"fnServerParams" : function (aoData){
			var params = $('form[name=filtrosCfg]').getSimpleParams();

			$.each(params, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});
} // llenarTabla