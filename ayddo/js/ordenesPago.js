function initView(){
		var Layout = {

				buscarInformacion : function(){
					Layout._llenarTabla();
				},

		_llenarTabla : function(){
			$('#gridbox').html('<table  id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Fecha Orden Pago</th><th>Fecha Pago</th><th>Estatus</th><th>Tipo Pago</th><th>Origen</th><th>Destino</th><th>Importe</th><th>Importe Transferencia</th><th>Importe pago</th><th>Beneficiario</th><th>Correo</th><th>Acciones</th></tr></thead><tbody></tbody></table>');

			showSpinner();
			var dataTableObj = $('#tblGridBox').dataTable({
				"iDisplayLength"	: 10,
				"bProcessing"		: true,
				"bServerSide"		: true,
				"sAjaxSource"		: BASE_URL + '/ayddo/ajax/ReporteOrdenPago.php',
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
						'aTargets'	: [0,1,2,3,4,5,6,7,8,9,10,11]
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
						"mData"   : null,
          				'aTargets'  : [2],

          				"fnRender": function ( data, type, row ) {
          					estatus =+ data.aData.nIdEstatus;
          					if(estatus == 1){
								estatus = 'Pendiente';
          					}else{
          						estatus = 'Liberada';
          					}
            				return estatus;        				
    					}
					},
					{
						"mData"		: 'nIdTipoPago',
						'aTargets'	: [3]
					},
					{
						"mData"		:'sCtaOrigen',
						'aTargets'	: [4]
					},
					{
						"mData"		: 'sCtaBen',
						'aTargets'	: [5],
          			},
          			{
						"mData"		: 'nMonto',
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
					},
					{ 
						"mData"   : null,
          				'aTargets'  : [11],

          				"fnRender": function ( data, type, row ) {
          					estatus =+ data.aData.nIdEstatus;
          					if(estatus == 1){
								boton = '<button id="liberar" data-placement="top" rel="tooltip" title="Liberar" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-id='+data.aData.nIdOrdenPago+' data-nombre="'+data.aData.sNombreComercial+'" data-title="Liberar Pago"><span class="fa fa-check"></span></button>';
          					}else{
          						boton = '';
          					}
            				return boton;        				
    					}
					}
					],
        
				"fnPreDrawCallback"	: function() {
					showSpinner();
        		},
        
				"fnDrawCallback": function ( oSettings ) {
					hideSpinner();
					if(oSettings._iRecordsTotal>=1){
						document.getElementById('export').style.display='block';
					}else{
						document.getElementById('export').style.display='none';
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

		buscaIntegradorProveedor:function(){	



					$("#cmbClientes").empty();
					$.post("/ayddo/ajax/Proveedores.php",{
					itipo : 1
					},
					function(response){		
						var obj = jQuery.parseJSON(response);
								
							$('#cmbClientes').append('<option value="0">Todos</option>');
							jQuery.each(obj, function(index,value) {
							$('#cmbClientes').append('<option value="'+obj[index]['nIdProveedor']+'">'+obj[index]['sRazonSocial']+'</option>');
							});		
					})
					.fail(function(resp){
								alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
					})
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

			$(document).on('click','#verDetalle',function(e){
				fecha = this.attributes['data-fecha'].value;
				proveedor = this.attributes['data-proveedor'].value;
				nombreProveedor = this.attributes['data-nombreProveedor'].value;
				tipo =+ $("#tipoReporte option:selected").val();
				
				getDetalleOperaciones(fecha,proveedor,nombreProveedor,tipo);
			});
		}
	}

	
	Layout.initBotones();
	Layout.buscaIntegradorProveedor();
	

} // initViewComision


$(document).on('click', '#liberar',function (e) {
		var id = $(this).data("id");
		var nombre = $(this).data("nombre");
		$("#corteId").val(id);
		$('#confirmacion p').empty();
		var texto = "Desea Habilitar liberar el pago para :" +nombre;
		$('#confirmacion p').append(texto);
});


$(document).on('click', '#liberaPago',function (e) {
		var $this = $(this);
		
		id = $("#corteId").val();
		actualizaEstatus(id);
});


function actualizaEstatus(id){
	$.post(BASE_URL + '/ayddo/ajax/LiberaOrden.php',{
			corte : id
		},
		function(response){
			
			var obj = jQuery.parseJSON(response);
			
			if(obj[0].nCodigo != 0){
				alert(obj[0].sMensaje);
				
			}else{
				alert(obj[0].sMensaje);
				$("#btnBuscar").click();
				$("#confirmacion").modal('hide');
			}
		})

		.fail(function(response){
		
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}