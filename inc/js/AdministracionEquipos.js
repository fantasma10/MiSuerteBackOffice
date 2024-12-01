function initComponents(){
	$('#fechaInicio').datepicker({
		language: 'es'
	});
	$('#fechaFin').datepicker({
		language: 'es'
	});
	
	$("body").on('tablaLlena', function(){
		
		$("#suspender").on("click", function(){		
			suspenderEquipo(this.parentNode.id);
		});
	});
}