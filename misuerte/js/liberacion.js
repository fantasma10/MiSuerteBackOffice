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
   


	$(document).on('click', '#buscarRetiro',function (e) {
		
		fecha1 = $("#fecha1").val();
		fecha2 = $("#fecha2").val();
		estatus = $("#estatus option:selected").val();

		if(estatus == -1){

			alert("Selecciona un estatus");

		}else{

			getRetiros(fecha1,fecha2,estatus);

		}

	});

    function getRetiros(fecha1,fecha2,estatus){
    	
    	tabla.fnClearTable(); //limpieza de tabla 
		tabla.fnDestroy();
    	tipo = 1;

		$.post(BASE_PATH+"/misuerte/ajax/pagosRetiro.php",{
			tipo: tipo,
			fecha1 : fecha1,
			fecha2 : fecha2,
			estatus : estatus
		},

		function(response){		
			var obj = jQuery.parseJSON(response);
					
					//console.log(obj);

			jQuery.each(obj, function(index,value) {
			
				var estatus_registro =+ obj[index]['estatus'];

				if(estatus == 1){
					var boton = '<button class="btn btn-default pagar" id="actualizar" data-id="'+obj[index]['registro']+'" >Pagar</button>';
				}else{
					var boton = '<button type="button"  class="btn btn-default pagado" data-id="'+obj[index]['registro']+'" >Pagado</button>';
				}
					
				$('#tblGridBox tbody').append('<tr><td class="thFecha" style="word-break:break-all">'+obj[index]['nombre']+'</td>'+
				'<td class="thFecha">'+obj[index]['correo']+'</td><td class="thFecha">'+obj[index]['telefono']+'</td>'+
				'<td class="thMonto">$ '+obj[index]['importe']+'</td><td class="thFecha">'+obj[index]['clabe']+'</td>'+
				'<td class="thFecha">'+obj[index]['fecha']+'</td>'+
				'<td>'+boton+'</td></tr>');
			});

				table = $("#tblGridBox").DataTable(settings);

		});
	}



	$(document).on('click', '#actualizar',function (e) {
		
		var id = $(this).data("id");

		var boton = $(this).button();		

		tipo = 2;


		actualizarPago(id,tipo);
		function actualizarPago(id,tipo){
			
			$.post(BASE_PATH+"/misuerte/ajax/pagosRetiro.php",{
				id : id,
				tipo : tipo
			},

			function(response){

				var obj = jQuery.parseJSON(response);

				alert(obj.msg);
			
				$(boton)[0].innerText= "Pagado";
		 		$(boton)[0].className= "btn btn-default pagado";

			})
			.fail(function(response){
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
			})
		}

	});

});