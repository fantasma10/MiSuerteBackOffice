function initViewMetodoPago(){
	llenarTabla();

	$('#btnNuevoMetodoPago').on('click', function(e){
		window.location = BASE_PATH + '/misuerte/metodospago/metodopago.php';
	});
} // initViewMetodoPago

function llenarTabla(){
	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Nombre</th><th>Importe Costo</th><th>Porcentaje Costo</th><th>Costo Adicional</th><th>IVA</th><th>Estatus</th><th>Acciones</th></tr></thead><tbody></tbody></table>');

	var dataTableObj = $('#tblGridBox').dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: true,
		"bServerSide"		: true,
		"sAjaxSource"		: BASE_PATH + '/misuerte/ajax/metodoPagoLista.php',
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
				'aTargets'	: [6]
			},
			{
				"mData"		: 'sNombre',
				'aTargets'	: [0]
			},
			{
				"mData"		: 'nImporteCosto',
				'aTargets'	: [1]
			},
			{
				"mData"		: 'nPorcentajeCosto',
				'aTargets'	: [2]
			},
			{
				"mData"		:'nImporteCostoAdicional',
				'aTargets'	: [3]
			},
			{
				"mData"		: 'nPorcentajeIVA',
				'aTargets'	: [4],
			},
			{
				"mData"		: 'sNombreEstatus',
				'aTargets'	: [5]
			},
			{
				"mData"		: 'nIdMetodoPago',
				'aTargets'	: [6],
				'fnRender'	: function(oObj){
					var nIdMetodoPago = oObj.aData.nIdMetodoPago;
					return '<a href="#" class="a_consulta_mp" nIdMetodoPago="'+nIdMetodoPago+'">' + 'Ver' + '</a>';
				}
			}
		],
		"fnPreDrawCallback"	: function() {
			//$('body').trigger('cargarTabla');
		},
		"fnDrawCallback": function ( oSettings ) {
			$('.a_consulta_mp').unbind('click');
			$('.a_consulta_mp').on('click', function(e){
				var nIdMetodoPago = $(e.target).attr('nidmetodopago');
				irAConsulta(nIdMetodoPago);
			})
		},
		"fnServerParams" : function (aoData){
		}
	});
} // llenarTabla

function irAConsulta(nIdMetodoPago){
	if($('#form_irAConsulta').length == 0){
		$('body').append('<form id="form_irAConsulta"></form>');
		$('#form_irAConsulta').attr("action", BASE_PATH+"/misuerte/metodospago/metodopago.php") .attr("method","post")
		.append('<input type="hidden" name="nIdMetodoPago" value="'+nIdMetodoPago+'">');
	}
	else{
		$('#form_irAConsulta :input[name=nIdMetodoPago]').val(nIdMetodoPago);
	}

	$('#form_irAConsulta').submit();
} // irAConsulta