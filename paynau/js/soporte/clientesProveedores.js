
var clientes = {
	initClientes : function(){
		$('#misMovimientos').on('click',function(){
			initViewClientes(proveedor);
		});
	}
}
$(function(){
	clientes.initClientes();
});


function initViewClientes(nIdProveedor){
		var Layout = {
				buscarInformacion : function(){
					Layout._llenarTabla();
				},

		_llenarTabla : function(){
				var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
									"oLanguage": {
									"sZeroRecords": "No se encontraron registros",
									"sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
									"sLengthMenu": "Mostrar _MENU_ registros",
									"sSearch": "Buscar:"  ,
									"sInfoFiltered": " - filtrado de _MAX_ registros",
									"oPaginate": {
									"sNext": "Siguiente",
									"sPrevious": " Anterior"
										}
									},
									"bSort" :false
									};
				
				$("#dataClientes tbody").empty();
				var datos = $("#dataClientes").DataTable();
				datos.fnClearTable();
				datos.fnDestroy();

				
				
				$.post(BASE_URL +"/paynau/ajax/soporte/getClientesProveedor.php",
				{
					nIdProveedor : nIdProveedor
					
				}, 
				function(response){
					 var obj = jQuery.parseJSON(response);
					 
					  jQuery.each(obj, function(index,value) {
					 
					 $('#dataClientes tbody').append('<tr>'+

							'<td> '+obj[index]['nIdOrden']+'</td>'+
							'<td><span class="status-pill smaller '+obj[index]['sColorAlert']+'"></span><span>'+obj[index]['sEstatus']+'</span></td>'+
							'<td>'+obj[index]['sNombreCliente']+'</td>'+
							'<td>'+obj[index]['sNombreConcepto']+'</td>'+
							'<td> '+obj[index]['dFecVigencia']+'</td>'+
							'<td>'+obj[index]['nMontoOrden']+'</td>'+
							'<td>'+obj[index]['nSaldoOrden']+'</td>'+
							'<td> '+obj[index]['sCorreo']+'</td>'+
							'<td> '+obj[index]['sReferencia']+'</td>'+
							// '<td > '+obj[index]['nIdTipoPago']+'</td>'+

							'<td > <button id="verDetalleOrden" data-orden='+obj[index]['nIdOrden']+' data-referencia ="'+obj[index]['sReferencia']+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
							'</tr>');
							tipoPago = obj[index]['nIdTipoPago'].split();
							
					  });
					  datos.DataTable(settings);
				})
				.fail(function(resp){
						alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
				});
		},



		initBotones : function(){

			$(document).on('click','#verDetalleOrden',function(e){
				
				nIdOrden = this.attributes['data-orden'].value;
				sReferencia = this.attributes['data-referencia'].value;
				cargarModalOrden(nIdOrden);
				$('#modalDetalleOrden').modal();
			});

			
		}
	}

	
	Layout.initBotones();
	
	Layout._llenarTabla();

} // initViewComision

function cargarModalOrden(nIdOrden){
	var datos = $("#dataDetallePagoOrden").DataTable();
	datos.fnClearTable();
	datos.fnDestroy();

	
	
	$.post(BASE_URL +"/paynau/ajax/soporte/getDetalleOrden.php",
	{
		nIdOrden : nIdOrden
		
	}, 
	function(response){
		 var obj = jQuery.parseJSON(response);
		 var numeroPago = 1;
		 console.log(obj);
		  jQuery.each(obj, function(index,value) {
		  		console.log(obj[index]['nIdOrdenCobro']);

		 		$('#dataDetallePagoOrden tbody').append('<tr>'+
				'<td> '+obj[index]['nIdOrdenCobro']+'</td>'+
				'<td>'+numeroPago+'</td>'+
				'<td>'+obj[index]['sEstatus']+'</td>'+
				'td >'+obj[index]['sNombre']+'</td>'+
				'<td>$'+obj[index]['nMontoOrden']+'</td>'+
				'<td>$'+obj[index]['nAbono']+'</td>'+
				'<td>$'+obj[index]['nSaldoOrden']+'</td>'+
				'<td>'+obj[index]['dFecVigencia']+'</td>'+
				'<td>'+obj[index]['dFecEnvio']+'</td>'+
				'<td>'+obj[index]['dFechaPago']+'</td>'+
				'</tr>');
				// tipoPago = obj[index]['nIdTipoPago'].split();
				numeroPago++;
		  });
		  datos.DataTable(settings);
	})
	.fail(function(resp){
			alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	});
}

var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
									"oLanguage": {
									"sZeroRecords": "No se encontraron registros",
									"sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
									"sLengthMenu": "Mostrar _MENU_ registros",
									"sSearch": "Buscar:"  ,
									"sInfoFiltered": " - filtrado de _MAX_ registros",
									"oPaginate": {
									"sNext": "Siguiente",
									"sPrevious": " Anterior"
										}
									},
									"bSort" :false
									};