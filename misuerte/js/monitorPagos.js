$(document).ready(function() {
	var host ="";
	var user ="";
	var pass ="";
	var localFolder ="";
	var remoteFolder ="";
	var diasComisiones ="";
	var corte =  "";
	var fechaCorte = "";
	var cliente = "";
	var estatus1 = "";
	var clase ="";
	var proveedor ="";
	var cortePronosticos = "";
	var totalPago = "";
	getIndicadores();

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
    var table = "";
    table2 = $("#tblGridBox2").DataTable(settings);

    fecha1 =  '0000-00-00';
    fecha2 =  '0000-00-00';
    corteE = $("#estatus option:selected").val();

    getCortes(fecha1,fecha2,corteE);




$('#buscarCorte').click(function(){
		table.fnClearTable();
		table.fnDestroy();
		fecha1 = $("#fecha1").val();
		fecha2 = $("#fecha2").val();

		estatusCorte =+ $("#estatus option:selected").val();

		getCortes(fecha1,fecha2,estatusCorte);
});

//Extraccion del corte
    function getCortes(fecha1,fecha2,estatus){
    	document.getElementById("corteDetalles").style.display="none";
    	tipo = 4;
		$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
			tipo: tipo,
			fecha1 : fecha1,
			fecha2 : fecha2,
			estatus : estatus
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);

					jQuery.each(obj, function(index,value) {
					var estatus = "";
					estatus =+ obj[index]['estatus'];


					if(estatus == 0){
					var buttons = '<button id="autorizar" style="margin-left:5px;" data-placement="top" rel="tooltip" title="Autorizar Pago" class="btn btn-warning btn-xs"'+
													  'data-corte='+obj[index]['corte']+' data-title="Imprimir Autorizacion"><span class="fa fa-list"></span></button>'+
													  '<button id="liberaPago" style="margin-left:5px;" data-placement="top" rel="tooltip" title="Liberar Pago" class="btn btn-primary btn-xs"'+
													  'data-corte='+obj[index]['corte']+' data-monto='+obj[index]['monto']+' data-title="Liberar Pago"><span class="fa fa-check"></span></button>';
					}else{

						var buttons = '';

					}
						$('#tblGridBox tbody').append('<tr><td style="display:none">'+obj[index]['corte']+'</td>'+
													  '<td style="display:none">'+obj[index]['clienteId']+'</td>'+
													  '<td style="display:none">'+obj[index]['proveedorId']+'</td>'+
													  '<td class="thFecha">'+obj[index]['proveedor']+'</td>'+
													  '<td class="thFecha">'+obj[index]['fechaInicio']+'</td>'+
													  '<td class="thFecha">'+obj[index]['fechaFinal']+'</td>'+
													  '<td class="thFecha">'+obj[index]['fechaPago']+'</td>'+
													  '<td class="thMonto">$ '+obj[index]['monto']+'</td>'+
													  '<td class="td1"><span class="badge" style="background-color:'+obj[index]['color']+'">&nbsp</span></td>'+
													  '<td style="width: 13%!important;"><button id="detalleCorte" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs"'+
													  'data-inicio='+obj[index]['fechaInicio']+' data-fin='+obj[index]['fechaFinal']+' data-corte='+obj[index]['corte']+' data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
													  ''+buttons+'</td></tr>');
					
					});
					table = $("#tblGridBox").DataTable(settings);		
		});
	}

	//Se cargan los indicadores de color
	 function getIndicadores(){
    	tipo = 7;
		$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
			tipo: tipo
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);
					var size = 2;
				jQuery.each(obj, function(index,value) {
					longitud = obj[index]['indicador'].length;

					if(longitud > 20)
					{
						size = 3;
					}else{
						size = 2;
					}
					$('#indicadores').append('<label class="col-xs-'+size+' control-label">'+obj[index]['indicador']+' <span class="badge" style="background-color:'+obj[index]['color']+'">&nbsp</span></label>');
				});
		});
	}


	//Detecta corte clickeado y trae informacion de detalle del corte
    //$('#tblGridBox').on('click', 'tr', function(e) {
    $(document).on('click', '#detalleCorte',function (e) {	
    	var fechaInicial = $(this).data("inicio");
    	var fechaCorte = $(this).data("fin");

		$("#fechaInicial").val(fechaInicial);
		$("#fechaFinal").val(fechaCorte);

    	var corte = $(this).data("corte");

    	$("#corte").val(corte);

		document.getElementById("corteDetalles").style.display="inline-block";  	


	   		getCorteInfo(fechaInicial,fechaCorte);
	   		$('html,body').animate({
    			scrollTop: $("#corteDetalles").offset().top
			}, 2000);
	   	
	});


     //Se traen los detalles del corte y se muestran
     function getCorteInfo(fechaInicial,fechaCorte){
     	table2.fnClearTable();
		table2.fnDestroy();
    	fecha1 = fechaInicial;
    	fecha2 = fechaCorte;
    	tipo = 11;
		$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
			tipo: tipo,
			fecha1 : fecha1,
			fecha2 : fecha2
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
			if(obj.length > 0){

				document.getElementById("exportar").style.display="inline-block";

			}
					
						jQuery.each(obj, function(index,value) {						

							$('#tblGridBox2 tbody').append('<tr><td class="thFecha">'+obj[index]['proveedor']+'</td><td class="thFecha">'+obj[index]['operaciones']+'</td>'+
														   '<td class="thMonto">$ '+obj[index]['monto']+'</td><td class="thMonto">$ '+obj[index]['archivo']+' </td>'+
														   '<td class="thMonto">$ '+obj[index]['premios']+'</td><td class="thMonto">$ '+obj[index]['comision']+' </td>'+
														   '<td class="thFecha">'+obj[index]['fecha']+' </td></tr>');
						});
					

					table2 = $("#tblGridBox2").DataTable(settings);
		});
	}



 $(document).on('click', '#autorizar',function (e) {
    	
    	var corteId = $(this).data("corte");

    	$("#corte").val(corte);
	  	

	jQuery('#pdfdata').attr('data', ''+BASE_PATH+'/misuerte/conciliacion/ReportePreautorizado.php?corte='+corteId);
			$('#pdfvisor').css('display','block')
	  	
    });


 $(document).on('click', '#closepdf',function (e) {

			$('#pdfvisor').css('display','none')
	  	
    });



$(document).on('click', '#liberaPago',function (e) {
		$("#confirmaPago").modal("show");
    	$("#montoCorte").empty();
    	$("#montoPronosticos").empty();

    	var corte = $(this).data("corte");
    	var monto = $(this).data("monto");

    	$("#corte").val(corte);
	  	$("#montoOrden").val(monto);
	  	
    	$("#montoCorte").append('Monto Corte $ '+monto);

    });


    

	//Se libera el pago y se marca con estatus de autorizado para posteriormente se cree la orden de pago
	$(document).on('click', '#generaOrden',function (e) {
    	var $this = $(this);
		$this.button('loading');
	  	corteId = $("#corte").val();
	  	fecha = $("#fecha1").val();
	  	detalleLiberacion = $("#txtDetalle").val();
	  	var pago = $("#montoOrden").val();
	  	liberarPago(corteId,fecha,detalleLiberacion,pago);
    });






    function liberarPago(corteId,fecha,detalleLiberacion,pago){

		var lack = "";
		var error = "";

		if(detalleLiberacion == undefined || detalleLiberacion.trim() == '' || detalleLiberacion <= 0){
			lack +='Detalle\n';
		}
		if(lack != "" || error != ""){
			var black = (lack != "")? "El siguiente campo es obligatorio : " : "";
			$("#generaOrden").button('reset');
			jAlert(black + '\n' + lack+'\n' );
			event.preventDefault();
		}else{
    		tipo = 6;
			$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
				corte : corteId,
				fecha : fecha,
				detalle : detalleLiberacion,
				proveedor : proveedor,
				pago : pago,
				tipo: tipo
			},
			function(response){		
				var obj = jQuery.parseJSON(response);
					if(obj['showMessage'] == 1){
						jAlert(obj["msg"]);
					}else{
						jAlert(obj["msg"]);
						setTimeout("location.reload()", 4000);
					}
			});
		}
	}

});