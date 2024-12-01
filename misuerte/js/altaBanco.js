$( document ).ready(function() {


	$("#cuentaBancaria").prop('maxlength', 11);
	$("#cuentaBancaria").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#cuentaContable").prop('maxlength', 15);
	$("#cuentaContable").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#saldo").prop('maxlength', 15);
	$("#saldo").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#cuentaBancariaCargo").prop('maxlength', 11);
	$("#cuentaBancariaCargo").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#cuentaContableCargo").prop('maxlength', 15);
	$("#cuentaContableCargo").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#saldoCargo").prop('maxlength', 15);
	$("#saldoCargo").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#cuentaBancariaCA").prop('maxlength', 11);
	$("#cuentaBancariaCA").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#cuentaContableCA").prop('maxlength', 15);
	$("#cuentaContableCA").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#saldoCA").prop('maxlength', 15);
	$("#saldoCA").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#opcionCuenta").on("change", function(){
		opcionCuenta =+ $("#opcionCuenta option:selected").val();

		switch(opcionCuenta){

			case 0 :

			document.getElementById("cuentaAbono").style.display="none";
			document.getElementById("cuentaCargo").style.display="none";
			document.getElementById("cuentaCargoAbono").style.display="none";

			break;

			case 1 :

			document.getElementById("cuentaAbono").style.display="inline-block";
			document.getElementById("cuentaCargo").style.display="none";
			document.getElementById("cuentaCargoAbono").style.display="none";

			break;

			case 2 :

			document.getElementById("cuentaAbono").style.display="none";
			document.getElementById("cuentaCargo").style.display="inline-block";
			document.getElementById("cuentaCargoAbono").style.display="none";

			break;

			case 3 :

			document.getElementById("cuentaAbono").style.display="none";
			document.getElementById("cuentaCargo").style.display="none";
			document.getElementById("cuentaCargoAbono").style.display="inline-block";

			break;	

		}
	});
	
	$(document).on('click', '#guardar',function (e) {

		var opcion =+ $(this).val();

		switch(opcion){

			case 1:

			var idBanco = $("#banco").val();
			var cuentaBancaria = $("#cuentaBancaria").val();
			var cuentaContable = $("#cuentaContable").val();
			var saldo = $("#saldo").val();
			var operacion = opcion;

			break;

			case 2:

			var idBanco = $("#bancoCargo").val();
			var cuentaBancaria = $("#cuentaBancariaCargo").val();
			var cuentaContable = $("#cuentaContableCargo").val();
			var saldo = $("#saldoCargo").val();
			var operacion = opcion;

			break;

			case 3:

			var idBanco = $("#bancoCA").val();
			var cuentaBancaria = $("#cuentaBancariaCA").val();
			var cuentaContable = $("#cuentaContableCA").val();
			var saldo = $("#saldoCA").val();
			var operacion = opcion;

			break;

		}

		var lack = "";
		var error = "";

		if(idBanco == undefined || idBanco.trim() == '' || idBanco <= 0){
			lack +='Banco\n';
		}

		if(cuentaBancaria == undefined || cuentaBancaria.trim() == '' || cuentaBancaria <= 0){
			lack +='Cuenta Bancaria\n';
		}

		if(cuentaContable == undefined || cuentaContable.trim() == '' || cuentaContable <= 0){
			lack +='Cuenta contable\n';
		}

		if(saldo == undefined || saldo.trim() == '' || saldo < 0){
			saldo = 0;
		}	

				// Mensaje de error en caso de no contener algun valor en la cassilla //
				if(lack != "" || error != ""){
					var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
					jAlert(black + '\n' + lack+'\n' );
					event.preventDefault();
				}
				else{

					var $this = $(this);
					$this.button('loading');
					$.post("../../misuerte/ajax/afiliacion.php",{

						banco : idBanco,
						cuentaBancaria : cuentaBancaria,
						cuentaContable : cuentaContable,
						saldo: saldo,
						operacion :operacion,
						tipo: 3
					},
					function(response){
						setTimeout("location.reload()", 3000);
					})
				}
			});
});