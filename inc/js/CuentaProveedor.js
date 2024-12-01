var intervalo = 30000;
var int = null;
var stopClick = false;

function getSaldo3VDigitalCel() {
	if ( !stopClick ) {
		stopClick = true;
		$.post( "../../inc/Ajax/_Administracion/ActualizarSaldo3VDigitalCel.php",
		function(data){
			var resultado = jQuery.parseJSON(data);
			if ( resultado.codigo == 0 ) {
				$("#saldo3VDigitalCel").hide();
				$("#saldo3VDigitalCel").empty();
				$("#saldo3VDigitalCel").html("$" + resultado.mensaje);
				$("#saldo3VDigitalCel").fadeIn("slow");
				var textoLeyenda = $("#leyendaSaldo").text();
				textoLeyenda = $.trim(textoLeyenda);
				if ( textoLeyenda.length == 0 ) {
					$("#leyendaSaldo").html("<br />Saldo de este d&iacute;a disponible");
				}
				stopClick = false;
			} else {
				$("#saldo3VDigitalCel").hide();
				$("#saldo3VDigitalCel").empty();
				$("#leyendaSaldo").empty();
				$("#saldo3VDigitalCel").html(resultado.mensaje);
				$("#saldo3VDigitalCel").fadeIn("slow");
				stopClick = false;
			}
		});
	}
}

function actualizarSaldo3VDigitalCel(a) {
	if (a) {
		getSaldo3VDigitalCel();
		Start();
	} else {
		Stop();
	}
}

function Stop(){
	int = window.clearInterval(int);
}

function Start(){
	int = self.setInterval(function(){
		getSaldo3VDigitalCel();
	}, intervalo);
}