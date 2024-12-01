function initView(){
		var Layout = {

				buscarInformacion : function(){
					Layout._llenarTabla();
				},

		_llenarTabla : function(){
			showSpinner();
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
				var nId = $('#cmbMetodosPago').val() == null ? 0 : $('#cmbMetodosPago').val();
				var sFechaI=$('#p_dFechaInicio').val();
				var sFechaF=$('#p_dFechaFin').val();
				
				$("#data tbody").empty();
				var datos = $("#data").DataTable();
				datos.fnClearTable();
				datos.fnDestroy();

				var tabla = $("#tblGridBox2").DataTable();
				
                                tabla.fnClearTable();
 	   			tabla.fnDestroy();
 				document.getElementById('detalleOperaciones').style.display='none';
	  			document.getElementById('titulo').style.display='none';
				$.post(BASE_URL +"/ayddo/ajax/ReporteLiquidacionPagos.php",
				{
					idProveedor: nId,
                                    dFechaInicio:sFechaI,
                                    dFechaFin:sFechaF
				}, 
				function(response){
					 var obj = jQuery.parseJSON(response);
					  jQuery.each(obj, function(index,value) {
					  fechaOperaciones = obj[index]['dFechaOperaciones'];
					  idMetodoPago = obj[index]['nIdMetodoPago'];
					 $('#data tbody').append('<tr>'+
							'<td >'+obj[index]['sNombre']+'</td>'+
							'<td style="text-align:center">'+obj[index]['num_pagos']+'</td>'+
							'<td > '+obj[index]['total_pagos']+'</td>'+
							'<td >'+obj[index]['comison']+'</td>'+
							// '<td >'+obj[index]['iva']+'</td>'+
							// '<td > '+obj[index]['total']+'</td>'+
							'<td > '+obj[index]['total']+'</td>'+
							'<td > <button id="verDetalle" data-fecha="'+fechaOperaciones+'"; data-proveedor='+obj[index]['nId']+' data-idMetodo="'+idMetodoPago+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
							'</tr>');
					  });
					  datos.DataTable(settings);
				})
				.fail(function(resp){
								alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
					}).always(function(){
						hideSpinner();
					})
				
				
//				document.getElementById("export").style.display="inline";
				document.getElementById("data").style.display="inline-table";
				document.getElementById("data").style.width="100%";
		},

                _MetodosPago:function(){
                        $.post(BASE_URL + "/ayddo/ajax/MetodosPago.php",{itipo : 1}, function(response){
                            var obj = jQuery.parseJSON(response);
                            
                            $('#cmbMetodosPago').append('<option value="0">Todos</option>');
                            jQuery.each(obj, function(index, value){
                                $('#cmbMetodosPago').append('<option value="'+obj[index]['nIdMetodoPago']+'">'+obj[index]['sNombre']+'</option>');
                                
                            })
                        }).fail(function(resp){
                           jAlert("ha ocurrido un error vuelva a intentar mas tarde"); 
                        });
                },
		initBotones : function(){
			$('#btnBuscar').on('click', function(e){
				if ($('#tipoReporte').val()==0){jAlert('Seleccione un tipo de reporte');return;}
				if ($('#p_dFechaInicio').val()==''){jAlert('Debe capturar la fecha inicial del reporte');return;}
				if ($('#p_dFechaFin').val()==''){jAlert('Debe capturar la fecha Final del reporte');return;}
				if($('#p_dFechaFin').val() < $('#p_dFechaInicio').val()){jAlert('La Fecha Final debe ser igual o mayor que la Fecha Inicial');return;}

				Layout.buscarInformacion();
				$('form[name=excel] :input[name=h_tipoReporte]').val($('#tipoReporte').val());
				$('form[name=pdf] :input[name=h_tipoReporte]').val($('#tipoReporte').val());

				$('form[name=excel] :input[name=h_cmbClientes]').val($('#cmbClientes').val());
				$('form[name=pdf] :input[name=h_cmbClientes]').val($('#cmbClientes').val());

				$('form[name=excel] :input[name=h_dFechaInicio]').val($('#p_dFechaInicio').val());
				$('form[name=pdf] :input[name=h_dFechaInicio]').val($('#p_dFechaInicio').val());

				$('form[name=excel] :input[name=h_dFechaFin]').val($('#p_dFechaFin').val());
				$('form[name=pdf] :input[name=h_dFechaFin]').val($('#p_dFechaFin').val());


				$('form[name=excel2] :input[name=h_tipoReporte]').val($('#tipoReporte').val());
				$('form[name=excel2] :input[name=h_cmbClientes]').val($('#cmbClientes').val());
				

				  });
				$('#p_dFechaInicio, #p_dFechaFin').datepicker({format : 'yyyy-mm-dd'}).on('changeDate', function(){
				$(this).datepicker('hide'); 
				$(this).blur();
			   });
                        $('#cmbMetodosPago').on("change", function(){
                            Layout._llenarTabla();
                        });
			$(document).on('click','#verDetalle',function(e){
                                sFechaI =$('#p_dFechaInicio').val();
				sFechaF =$('#p_dFechaFin').val();
				idMetodo = this.attributes['data-idMetodo'].value;
				tipo =+ $("#tipoReporte option:selected").val();
				
				getDetalleLiquidaciones(idMetodo,sFechaI,sFechaF);
				$('form[name=excel2] :input[name=h_cmbClientes]').val(idMetodo);
			});
		}
	}

	
	Layout._MetodosPago();
	Layout.initBotones();
//	Layout.buscaIntegradorProveedor();
        Layout._llenarTabla();

} // initViewComision


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

function getDetalleLiquidaciones(idMetodo,sFechaI,sFechaF){

	var tabla = $("#tblGridBox2").DataTable();
				
    tabla.fnClearTable();
    tabla.fnDestroy();

    $.post(BASE_URL +"/ayddo/ajax/DetalleLiquidacionPagos.php",{
      idProveedor : idMetodo,
      dFechaInicio: sFechaI,
      dFechaFin : sFechaF 
    },
    function(response){
      var obj = jQuery.parseJSON(response);
        obj = obj.Data;
      conteo = obj.length;   
	  document.getElementById('detalleOperaciones').style.display='block';
	  document.getElementById('titulo').style.display='block';

	  $('form[name=excel2] :input[name=h_dFechaInicio]').val(sFechaI);
	  $('form[name=excel2] :input[name=h_dFechaFinal]').val(sFechaF);
	  $('form[name=excel2] :input[name=h_metodoPago]').val(idMetodo);
      // Validacion de que la consulta contiene registros para ser mostrados

      if(conteo > 0){

          // Llenado de la tabla con la informacion de la consulta
           jQuery.each(obj, function(index,value) {
        
              $('#tblGridBox2 tbody').append('<tr>'+
              '<td style="text-align:center;">'+obj[index]['dFecha']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['nIdFolio']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['nMonto']+'</td>'+
              '<td style="text-align:right;">'+obj[index]['nComision']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['iva']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['total']+'</td>');

        
            })   
           table = $("#tblGridBox2").DataTable(settings);
      }else{
        table = $("#tblGridBox2").DataTable(settings);
        document.getElementById('detalleOperaciones').style.display='none';
	  	document.getElementById('titulo').style.display='none';
        jAlert("No se encontro informacion");

      } 
  })
  .fail(function(resp){
          alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
  })
}