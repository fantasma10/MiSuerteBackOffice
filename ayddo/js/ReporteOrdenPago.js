function initView(){
		var Layout = {

				buscarInformacion : function(){
					Layout._llenarTabla();
				},

		_llenarTabla : function(){
      		//var params = $('form[name=frmFiltros]').getSimpleParams();

			$('#gridbox').html('<table  id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Fecha Orden Pago</th><th>Fecha Pago</th><th>Tipo Pago</th><th>Origen</th><th>Destino</th><th>Importe</th><th>Importe Comisión</th><th>Importe Transferencia</th><th>Importe pago</th><th>Beneficiario</th><th>Correo</th></tr></thead><tbody></tbody></table>');

			showSpinner();
			var dataTableObj = $('#tblGridBox').dataTable({
				"iDisplayLength"	: 10,
				"bProcessing"		: true,
				"bServerSide"		: true,
				"sAjaxSource"		: BASE_PATH + '/paycash/ajax/Reportes/ReporteOrdenPago.php',
				"sServerMethod"		: 'POST',
				"bFilter"			: false,
				"bAutoWidth"		: false,
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
						'aTargets'	: [0,1,2,3,4,5,6,7,8,9,10]
					},
					{
						"mData"		: 'dFecProcesamiento',
						'aTargets'	: [0]
					},
					{
						"mData"		: 'dFechaPago',
						'aTargets'	: [1]
					},
					{
						"mData"		: 'nIdTipoPago',
						'aTargets'	: [2]
					},
					{
						"mData"		:'sCtaOrigen',
						'aTargets'	: [3]
					},
					{
						"mData"		: 'sCtaBen',
						'aTargets'	: [4],
          			},
          			{
						"mData"		: 'nMonto',
						'aTargets'	: [5],
          			},
          			{
						"mData"		: 'nCargo',
						'aTargets'	: [6],
          			},
          			{
						"mData"		: 'nImporteTransferencia',
						'aTargets'	: [7],
					},
					{
						"mData"		: 'nTotal',
						'aTargets'	: [8],
					},
					{
						"mData"		: 'sBeneficiario',
						'aTargets'	: [9],
					},
					{
						"mData"		: 'sCorreoDestino',
						'aTargets'	: [10],
					}],
        
				"fnPreDrawCallback"	: function() {
					showSpinner();
        		},
        
				"fnDrawCallback": function ( oSettings ) {
					hideSpinner();
					if(oSettings._iRecordsTotal>=1){
						$('#exportar').show();
					};
					
				},
				"fnServerParams" : function (aoData){
					var params = $('form[name=formFiltros]').getSimpleParams();
					
					$.each(params, function(index, val){
						aoData.push({name : index, value : val });
					});
        		}
        
			});
			
		},


		buscarEmisor:function(){
			$("#p_sRazonSocial").autocomplete({
				source: function(request,respond){
					$.post( "../ajax/Pagos/emisoresAC.php", { "strBuscar": request.term },
					function( response ) {
						respond(response);
					}, "json" );
				},
				minLength: 1,
				focus: function(event,ui){
					$("#p_sRazonSocial").val(ui.item.snombreemisor);
					$("#p_sRFC").val(ui.item.sRFC);
					return false;
				},
				select: function(event,ui){
					$("#p_nIdEmisor").val(ui.item.nIdEmisor);
					
					return false;
				},
				search: function(){
				
					$("#p_nIdEmisor").val('');
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a style=\"color:black\">"+ item.value + "</a>" )
				.appendTo( ul );
			};
		},

		buscarEmisorporNombreComercial:function(){
			$("#p_sNombreComercial").autocomplete({
				source: function(request,respond){
					$.post( "../ajax/Pagos/emisoresAC.php", { "strBuscar": request.term },
					function( response ) {
						respond(response);
					}, "json" );
				},
				minLength: 1,
				focus: function(event,ui){
					$("#p_sRFC").val(ui.item.sRFC);
					$("#p_sRazonSocial").val(ui.item.snombreemisor);
					$("#p_sNombreComercial").val(ui.item.sNombreComercial);
					return false;
				},
				select: function(event,ui){
					$("#p_nIdEmisor").val(ui.item.nIdEmisor);
					
					return false;
				},
				search: function(){
				
					$("#p_nIdEmisor").val('');
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a style=\"color:black\">"+ item.sNombreComercial + "</a>" )
				.appendTo( ul );
			};
		},

		buscarEmisorporRFC:function(){
			$("#p_sRFC").autocomplete({
				source: function(request,respond){
					$.post( "../ajax/Pagos/emisoresAC.php", { "strBuscar": request.term },
					function( response ) {
						respond(response);
					}, "json" );
				},
				minLength: 1,
				focus: function(event,ui){
					$("#p_sRazonSocial").val(ui.item.snombreemisor);
					$("#p_sRFC").val(ui.item.sRFC);
					return false;
				},
				select: function(event,ui){
					$("#p_nIdEmisor").val(ui.item.nIdEmisor);
					
					return false;
				},
				search: function(){
				
					$("#p_nIdEmisor").val('');
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a style=\"color:black\">"+ item.sRFC + "</a>" )
				.appendTo( ul );
			};
		},

		initBotones : function(){
			$('#btnBuscar').on('click', function(e){
				if ($('#p_dFechaInicio').val()==''){jAlert('Debe capturar la fecha inicial del reporte');return;}
				if ($('#p_dFechaFin').val()==''){jAlert('Debe capturar la fecha Final del reporte');return;}
				if($('#p_dFechaFin').val() < $('#p_dFechaInicio').val()){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}

				Layout.buscarInformacion();
				$('form[name=excel] :input[name=h_nIdEmisor]').val($('#p_nIdEmisor').val());
				$('form[name=pdf] :input[name=h_nIdEmisor]').val($('#p_nIdEmisor').val());

				$('form[name=excel] :input[name=h_nIdEstatus]').val($('#p_nIdEstatus').val());
				$('form[name=pdf] :input[name=h_nIdEstatus]').val($('#p_nIdEstatus').val());

				$('form[name=excel] :input[name=h_dFechaInicio]').val($('#p_dFechaInicio').val());
				$('form[name=pdf] :input[name=h_dFechaInicio]').val($('#p_dFechaInicio').val());

				$('form[name=excel] :input[name=h_dFechaFin]').val($('#p_dFechaFin').val());
				$('form[name=pdf] :input[name=h_dFechaFin]').val($('#p_dFechaFin').val());

				  });

			$('#p_dFechaInicio, #p_dFechaFin').datepicker({format : 'yyyy-mm-dd'}).on('changeDate', function(){
				$(this).datepicker('hide'); 
				$(this).blur();
			   });
		}
	}

	
	Layout.initBotones();
	Layout.buscarEmisor();
	Layout.buscarEmisorporNombreComercial();
	Layout.buscarEmisorporRFC();

} // initViewComision