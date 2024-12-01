$(document).ready(function() {

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
	"bSort": false, 
	};

var corte = $('#corte').val();
var cliente = $('#cliente').val();

var fechaInicial = $('#fechaI').val();
var fechaFinal = $('#fechaF').val();

getMovimientos(corte);
function getMovimientos(corte){
    	tipo = 5;
		$.post("../../misuerte/ajax/pagosProveedor.php",{
			corte : corte,
			fechaInicial :fechaInicial,
			fechaFinal :fechaFinal,
			tipo: tipo
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					console.log(obj);
					var juego = "";
					jQuery.each(obj, function(index,value) {
						if(obj[index]['entidad'] == "MI SUERTE"){
							juego = obj[index]['juego'];
						}else{
							juego = obj[index]['producto'];
						}
						$('#noConciliadas tbody').append('<tr><td>'+juego+'</td><td>'+obj[index]['entidad']+'</td><td class="thFecha">'+obj[index]['sorteo']+'</td><td class="thFecha">'+obj[index]['boleto']+'</td><td class="thFecha">'+obj[index]['fechaVenta']+'</td><td class="thFecha">'+obj[index]['horaVenta']+'</td><td class="thMonto">$ '+obj[index]['monto']+'</td><td class="thMonto">$ '+obj[index]['montoCorte']+'</td></tr>');
					});
					table = $("#noConciliadas").DataTable(settings);
		});
	}

});