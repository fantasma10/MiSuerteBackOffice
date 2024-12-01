$(document).ready(function() {
	

	var settings = {"iDisplayLength": 5, // configuracion del lenguaje del plugin de la tabla
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
	"bSort": false, 
	};
   
	var tabla  = $("#tblGridBox").DataTable(settings);
   


	$(document).on('click', '#buscarPagos',function (e) {
		
		fecha1 = $("#fecha1").val();
		fecha2 = $("#fecha2").val();
		$("#fechaInicial").val(fecha1);
		$("#fechaFinal").val(fecha2);

		validacion = validarFechas(fecha1,fecha2);
		if(validacion){
			getPagos(fecha1,fecha2);
		}else{
			alert("La fecha inicial es mayor a la final");
		}

	});

    function getPagos(fecha1,fecha2){
    	
    	tabla.fnClearTable(); //limpieza de tabla 
		tabla.fnDestroy();
    	tipo = 2;

		$.post(BASE_PATH+"/misuerte/ajax/pagosExcel.php",{
			tipo: tipo,
			fecha1 : fecha1,
			fecha2 : fecha2
		},

		function(response){		
			var obj = jQuery.parseJSON(response);

			if(obj.length > 0){

				document.getElementById("exportar").style.display="inline-block";

			}else{
				
				document.getElementById("exportar").style.display="none";
				

			}
					
			jQuery.each(obj, function(index,value) {
											


				$('#tblGridBox tbody').append('<tr><td style="word-break:break-all width:17% !important">'+obj[index]['agencia']+'</td>'+
				'<td>'+obj[index]['concursante']+'</td><td class="thMonto"> $'+obj[index]['montoMonedero']+'</td>'+
				'<td>'+obj[index]['fechaCargo']+'</td><td class="thMonto"> $'+obj[index]['venta']+'</td>'+
				'<td>'+obj[index]['fechaVenta']+'</td><td class="thMonto"> $'+obj[index]['saldo']+'</td></tr>');
			});

				table = $("#tblGridBox").DataTable(settings);

		});
	}



	$(document).on('click', '#excel1',function (e) {
		
	
		fecha1 = $("#fecha1").val();
		fecha2 = $("#fecha2").val();


		generaExcel(fecha1,fecha2);

		function generaExcel(fecha1,fecha2){
			
			$.post(BASE_PATH+"/misuerte/ajax/excelPagosPremios.php",{
				fecha1 : fecha1,
				fecha2 : fecha2
			},

			function(response){

				var obj = jQuery.parseJSON(response);


				alert(obj.sMensaje);
			

			})
			.fail(function(response){
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
			})
		}

	});


});