function initView(){
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
				var nId=$('#cmbClientes').val();
				var sFechaI=$('#p_dFechaInicio').val();
				var sFechaF=$('#p_dFechaFin').val();
				var reporte=$('#tipoReporte').val();
				
				$("#data tbody").empty();
				var datos = $("#data").DataTable();
				datos.fnClearTable();
				datos.fnDestroy();

				var tabla = $("#tblGridBox2").DataTable();
				
    			tabla.fnClearTable();
 	   			tabla.fnDestroy();
 				document.getElementById('detalleOperaciones').style.display='none';
	  			document.getElementById('titulo').style.display='none';
				
				$.post(BASE_URL +"/ayddo/ajax/ReporteOperaciones.php",
				{
					itipo:1
					,tipoReporte:reporte
					,p_nId:nId
					,p_dFechaInicio:sFechaI
					,p_dFechaFin:sFechaF
				}, 
				function(response){
					 var obj = jQuery.parseJSON(response);
					  jQuery.each(obj, function(index,value) {
					  fechaOperaciones = obj[index]['dFechaOperaciones'];
					  nombreProveedor = obj[index]['sNombre'];
					 $('#data tbody').append('<tr>'+
							'<td >'+obj[index]['sNombre']+'</td>'+
							'<td > '+obj[index]['dFechaOperaciones']+'</td>'+
							'<td >'+obj[index]['nTotalOperaciones']+'</td>'+
							'<td >'+obj[index]['nTotalMonto']+'</td>'+
							'<td > '+obj[index]['nTotalComision']+'</td>'+
							'<td > '+obj[index]['nTotal']+'</td>'+
							'<td > <button id="verDetalle" data-fecha="'+fechaOperaciones+'"; data-proveedor='+obj[index]['nId']+' data-nombreProveedor ="'+nombreProveedor+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
							'</tr>');
					  });
					  datos.DataTable(settings);
				})
				.fail(function(resp){
								alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
					})
				
				
				document.getElementById("export").style.display="inline";
				document.getElementById("data").style.display="inline-table";
				document.getElementById("data").style.width="100%";
		},

		buscaIntegradorProveedor:function(){	
			$("#cmbClientes").on("change", function(){
				cliente = $("#cmbClientes").val();
				if (cliente =! 0) {
					$('#btnBuscar').click();
				}
			});
			
			$("#tipoReporte").on("change", function(){

				$("#data tbody").empty();
				var datos = $("#data").DataTable();
				datos.fnClearTable();
				datos.fnDestroy();

				document.getElementById("export").style.display="none";
				document.getElementById("data").style.display="none";
				document.getElementById("titulo").style.display="none";
				document.getElementById("detalleOperaciones").style.display="none";

				var reporte =  $("#tipoReporte").val();
				if (reporte != 0) {
					$('#btnBuscar').click();
				}

				if (reporte==1){
					$("#cmbClientes").empty();
					$.post(BASE_URL +"/ayddo/ajax/MetodosPago.php",{
					itipo : 1
					},
					function(response){		
						var obj = jQuery.parseJSON(response);
								
							$('#cmbClientes').append('<option value="0">Todos</option>');
							jQuery.each(obj, function(index,value) {
							$('#cmbClientes').append('<option value="'+obj[index]['nIdMetodoPago']+'">'+obj[index]['sNombre']+'</option>');
							});		
					})
					.fail(function(resp){
								alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
					})
				}

				if (reporte==2){
					$("#cmbClientes").empty();
					$.post(BASE_URL +"/ayddo/ajax/Proveedores.php",{
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
				}
				
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

			$(document).on('click','#verDetalle',function(e){
				fecha = this.attributes['data-fecha'].value;
				proveedor = this.attributes['data-proveedor'].value;
				nombreProveedor = this.attributes['data-nombreProveedor'].value;
				tipo =+ $("#tipoReporte option:selected").val();
				
				getDetalleOperaciones(fecha,proveedor,nombreProveedor,tipo);
				$('form[name=excel2] :input[name=h_cmbClientes]').val(proveedor);
			});
		}
	}

	
	Layout.initBotones();
	Layout.buscaIntegradorProveedor();
	

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

function getDetalleOperaciones(fecha,proveedor,nombreProveedor,tipo){

	var tabla = $("#tblGridBox2").DataTable();
				
    tabla.fnClearTable();
    tabla.fnDestroy();

    $.post(BASE_URL +"/ayddo/ajax/DetalleOperaciones.php",{
      fecha: fecha,
      proveedor : proveedor,
      tipoReporte : tipo 
    },
    function(response){   
      var obj = jQuery.parseJSON(response);
      
      conteo = obj.length;   
	  document.getElementById('detalleOperaciones').style.display='block';
	  document.getElementById('titulo').style.display='block';

	  $('form[name=excel2] :input[name=h_dFechaInicio]').val(fecha);
      // Validacion de que la consulta contiene registros para ser mostrados

      if(conteo > 0){

          // Llenado de la tabla con la informacion de la consulta
           jQuery.each(obj, function(index,value) {
        
              $('#tblGridBox2 tbody').append('<tr><td style="width: 13%!important;">'+obj[index]['nIdFolio']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['sNombreComercial']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['sMetodo']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['nMonto']+'</td>'+
              '<td style="text-align:right;">'+obj[index]['nComision']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['dFecha']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['dHora']+'</td>');

        
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